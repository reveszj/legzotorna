<?php
$id = mysql_real_escape_string($_REQUEST[id]);

if ($_REQUEST[mentes]){
	$nev = mysql_real_escape_string($_REQUEST[nev]);
	$menux = mysql_real_escape_string($_REQUEST[menu]);
	$cikk = mysql_real_escape_string($_REQUEST[cikk]);
	$sorrend = mysql_real_escape_string($_REQUEST[sorrend]);
	$aktiv = $_REQUEST[aktiv];
	if ($aktiv == 'on'){
		$aktiv = 0;
	} else {
		$aktiv = 1;
	}
	if ($_REQUEST[id]){
		$result = "UPDATE ".$_SESSION[adattabla_etag]."menu SET nev = '$nev', cikk_id = '$cikk', szulo = '$menux', sorrend = '$sorrend', archiv = '$aktiv' WHERE id ='$id' LIMIT 1";
	} else {
		$result = "INSERT INTO ".$_SESSION[adattabla_etag]."menu (nev, cikk_id, szulo, sorrend, archiv) VALUES ('$nev', '$cikk', '$menux', '$sorrend', '$aktiv')";
	}
	mysql_query($result);
}

if ($_REQUEST[torles]){
	$result = "DELETE FROM ".$_SESSION[adattabla_etag]."menu WHERE id = '$id'";
	mysql_query($result);
}

//beolvassa a fõmenüket
$r = mysql_query("SELECT id, nev, cikk_id, szulo, sorrend, archiv FROM ".$_SESSION[adattabla_etag]."menu WHERE szulo='0' ORDER BY sorrend");	
while ($next_element = mysql_fetch_array($r)){
	$jelolve = 0;
	
	//a fõmenühöz milyen almenük tartoznak
	$rr = mysql_query("SELECT id, nev, cikk_id, szulo, sorrend, archiv FROM ".$_SESSION[adattabla_etag]."menu WHERE szulo='$next_element[id]' ORDER BY sorrend");	
	while ($next_element2 = mysql_fetch_array($rr)){
		if ($next_element2[archiv] == '1'){
			$color_archiv = ' style="color: #cecece;"';
		} else {
			$color_archiv = '';
		}
		$almenu .= '<li>'.$next_element2[sorrend].' <span'.$color_archiv.'> '.$next_element2[nev].'</span><img src="graphics/icon_edit.gif" alt="szerkeszt" onclick="show_php_in_div(\'popup\', \'admin/popup_menuszerk.php?id='.$next_element2[id].'\')" /></li>';
	}
	
	//az almenü kiegészítése listává
	if ($almenu){
		$almenu = '<ul>'.$almenu.'</ul>';
	}
	
	if ($next_element[archiv] == '1'){
		$color_archiv = ' style="color: #cecece;"';
	} else {
		$color_archiv = '';
	}
	
	$menu .= '
	<li>
		'.$next_element[sorrend].'<span'.$color_archiv.'> '.$next_element[nev].'</span><img src="graphics/icon_edit.gif" alt="szerkeszt" onclick="show_php_in_div(\'popup\', \'admin/popup_menuszerk.php?id='.$next_element[id].'\')" />
		'.$almenu.'
	</li>';
	
	$almenu = '';
}

$menu = '
	<div class="menuszerk">
		<ul>
			'.$menu.'
		</ul>
		<div class="but" onclick="show_php_in_div(\'popup\', \'admin/popup_menuszerk.php\')">Új menüpont hozzáadása</div>
	</div>';

$admin_torzs = $menu;
?>