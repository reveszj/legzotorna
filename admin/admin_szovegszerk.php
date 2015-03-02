<?

If ($_REQUEST['torles'] != "") {
	$result = "DELETE FROM ".$_SESSION[adattabla_etag]."szoveg WHERE id = $_REQUEST[torles] LIMIT 1";
	mysql_query($result);
}

If ($_POST['ujcim'] != "") {
	$result = mysql_query("SELECT MAX(id) FROM ".$_SESSION[adattabla_etag]."szoveg");
	$row = mysql_fetch_array($result); 
	$num_rows=$row[0];
	$num_rows++;
	$result = mysql_query("SELECT MAX(sorrend) FROM ".$_SESSION[adattabla_etag]."szoveg");
	$row = mysql_fetch_array($result); 
	$num_sorrend=$row[0];
	$num_sorrend++;

	$result = "INSERT INTO ".$_SESSION[adattabla_etag]."szoveg  
		(id, sorrend, aktiv, oldalcim)
		VALUES
		($num_rows, $num_sorrend, '0', '$_POST[ujcim]')";
	mysql_query($result);
}

If ($_POST['cim'] != "") {
			if ($_POST[check_aktiv] == 'on'){$ment_aktiv = 1;}
			else {$ment_aktiv = 0;}
			
		$form_tartalom = mysql_real_escape_string($_POST[content]);
		$form_cikk_kulcsszavak = mysql_real_escape_string($_POST[kulcsszavak]);
		
		$sql2 = "UPDATE ".$_SESSION[adattabla_etag]."szoveg SET leiras='$form_cikk_kulcsszavak', tartalom='$form_tartalom', oldalcim='$_POST[cim]', menu='$_POST[menu]', sorrend='$_POST[sorrend]', php_file='$_POST[php_file]', aktiv='$ment_aktiv', kulcsszo='$_POST[kulcsszavak]', leiras='$_POST[leiras]' WHERE id='$_POST[sorszam]'";
		echo mysql_error();
		mysql_query($sql2);
}
//ûrlapok megjelenítése

	If ($_REQUEST[valaszt] != ''){
		//mivel nem adtunk meg kategóriát és !választottunk! cikket, ezért beolvassa a cikket
		$r = mysql_query("SELECT tartalom, id, oldalcim, aktiv, sorrend, leiras, menu, php_file, kulcsszo FROM ".$_SESSION[adattabla_etag]."szoveg WHERE id = $_REQUEST[valaszt]");
		$h = mysql_fetch_row($r);  
		$szoveg_tartalom = $h[0];
		$szoveg_menu = $h[6];
		$szoveg_aktiv = $h[3];
		if ($szoveg_aktiv == '1') {$cikkarchiv_check = 'checked="checked"';}
		$valaszt = 'valaszt';
	}
	


//itt olvassa be a listát
$result = mysql_query("SELECT id, oldalcim, sorrend, menu FROM ".$_SESSION[adattabla_etag]."szoveg ORDER BY sorrend");
$sor = 0;
while ($next_element = mysql_fetch_array($result)){
	$sor++;
	
	if ($next_element[archiv] == 0){
		$archivkapcs = 'igen';
	} else {
		$archivkapcs = 'nem';
	}
	
	/* $nev = "Hírrovat";
	if($next_element[sorrend]==0){
	$nev = "Cikk cím";
	} */
	
	if ($archivkapcs == 'igen'){
		$archiv_sor_jelol = '';
	} else {
		$archiv_sor_jelol = 'style="color: #aaaaaa;" ';
	}
	
	$szoveglista .= '
	<a href="?tartalom=szovegszerk&valaszt='.$next_element[id].'" '.$archiv_sor_jelol.'class="cedula_admintermeklista" style="width: 750px;">
		<span style="width: 36px; text-align: center;">'. $sor.'</span>
		<span style="width: 300px; text-align: left;">'. $next_element[oldalcim].'</span>
		<span style="width: 50px; text-align: center;">'. $next_element[id].'</span>
		<!--
		<span style="width: 70px; text-align: center;">'.$menukapcs.'</span>
		<span style="width: 50px; text-align: center;">'.$archivkapcs.'</span>
		-->
		<span style="width: 180px; text-align: center;">'.$next_element[menu].'</span>
		<span style="width: 80px; text-align: center;">'.$next_element[sorrend].'.  '.$nev.'</span>
	</a>';
}

$szoveglista = '
	<form method="post" action="?tartalom=szovegszerk" name="szoveg" class="admin_form" style="width: 800px;">
		<div class="a_form_fej">Szövegszerkesztés</div>
		<div style="width: 750px; height: 20px; color: #444444; font-weight: bold; font-size: 12px; margin: 0px auto 0px auto;">
			<span style="width: 36px;"></span>
			<span style="width: 300px; text-align: center;">cím</span>
			<span style="width: 50px; text-align: center;">id</span>
			<span style="width: 180px; text-align: center;">menü</span>
			<span style="width: 80px; text-align: center;">sorrend</span>
		</div>
		'.$szoveglista.'
		<div style="float:left; height: 40px; margin: 16px 0px 6px 36px;">
			Új szöveg címe:<input name="ujcim" type="text" value="" />
			<input type="submit" value="Létrehoz" />
		</div>
		<br style="clear: both;" />
		</div>
	</form>';

/*
$fnev=glob('templates/*_j.html');

foreach($fnev as $fn){
   if(is_file($fn)){
		unset($combo_oldalsav);
		$filenev = substr($fn, 10);
		if ($h[6] == $filenev){
			$combo_oldalsav = ' selected="selected"';
		}
		$szur_combo_oldalsav .= '<option value="'.$filenev.'"'.$combo_oldalsav.'>'.$filenev.'</option>';
   }
}
$szur_combo_oldalsav = '<option value="x">x</option>'.$szur_combo_oldalsav;
*/
if ($_REQUEST['valaszt'] == ''){
	$admin_torzs = '
	<div>
		'.$szoveglista .'
	</div>';
} else {

	$admin_torzs = '
	<script type="text/javascript" src="tinymce_4.1.0/tinymce/js/tinymce/tinymce_mod.js"></script>
	<form method="post" action="?tartalom=szovegszerk&'.$valaszt.'='. $h[1] .'" name="szoveg" class="admin_form">
		<div class="a_form_fej">Szövegszerkesztés <input type="submit" value="Mentés" class="a_form_mentes" /></div>
		<div style="width: 600px; float: left; text-align: left; margin: 20px 0px 0px 20px;">
			<a href="#" onclick="divdisp_on(\'admin_cikkadatlap\');" id="a_cikk_adatlap">ADATLAP</a>
			<a href="#" onclick="divdisp_on(\'admin_cikkszoveg\');" id="a_cikk_szoveg">SZÖVEG</a>
		</div>
		<div id="admin_cikkadatlap">
		<table class="a_form_beldiv">
			<tr><td>Cím:</td><td><input name="cim" type="text" value="' . $h[2] . '" /></span><br style="clear: both;"/></td></tr>
			<tr><td>Menü:</td><td><input name="menu" type="text" value="' . $h[6] . '" /></span><br style="clear: both;"/></td></tr>
			<tr><td>Php file:</td><td><input name="php_file" type="text" value="' . $h[7] . '" /></span><br style="clear: both;"/></td></tr>
			<tr><td>Kulcsszavak:</td><td><input name="kulcsszavak" type="text" value="' . $h[8] . '" /></span><br style="clear: both;"/></td></tr>
			<tr><td>Leirás:</td><td><input name="leiras" type="text" value="' . $h[5] . '" /></span><br style="clear: both;"/></td></tr>
			<tr><td><input name="sorszam" type="text" value="' . $h[1] . '" size="2" style="display:none;" /></td></tr>
			<tr><td>Sorrend:</td><td><input name="sorrend" type="text" value="' . $h[4] . '" onkeyup="numerikusCheck(szoveg.sorrend)" /></span><br style="clear: both;"/></td></tr>
			<tr><td>Aktív:</td><td><input name="check_aktiv" type="checkbox" '.$cikkarchiv_check.'/></td></tr>
			<tr><td>Végleges törlés:</td><td><input name="check_torles" type="checkbox" onclick="megerosites_x('.$h[1].', \'szoveg\')" /></td></tr>
		</table>
		</div>
		
		<div id="admin_cikkszoveg" style="display: none;">
		<div class="a_form_beldiv">
		<!--
			BEVEZETÕ (JOBB OLDALRA)
			<br style="clear:both;" />
			<textarea name="cikk_bevezeto" style="width:560px; height:150px;">' . $szoveg_cikk_bevezeto . '</textarea>
			<br style="clear:both;" />
			<br style="clear:both;" />
		-->
			TELJES TARTALOM
			<br style="clear:both;" />
			<textarea name="content" style="width:560px; height:550px;">' . $szoveg_tartalom . '</textarea>
			<br style="clear:both;" />
		</div>
		</div>
	</form>';
}

If ($kikapcs == 1) {$admin_torzs = '<div class="tabla_k">Ehhez a menüponthoz nem tartozik szerkeszthetõ tartalom!</div>';}
?>