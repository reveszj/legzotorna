<?

#a menü törlése az adatbázisból
	If ($_REQUEST['torles'] != ""){
		$sql = "DELETE FROM ".$_SESSION[adattabla_etag]."szoveg WHERE sorszam = $_REQUEST[torles]";
		mysql_query($sql);
	}

If ($_REQUEST['ment'] == "1"){
	$sql2 = "UPDATE ".$_SESSION[adattabla_etag]."szoveg SET archiv = '1'";
	mysql_query($sql2);
	$sql2 = "UPDATE ".$_SESSION[adattabla_etag]."szoveg SET menu_fent = '0'";
	mysql_query($sql2);
	$sql2 = "UPDATE ".$_SESSION[adattabla_etag]."szoveg SET menu_oldalt = '0'";
	mysql_query($sql2);
	#menunevek átírása
	for ($i = 1; $i < 10000; $i++){
		$menunev = 'menunev_' . $i;
		$menuaktiv = 'menu_akt_' . $i;
		$menufent = 'menu_f_' . $i;
		$menuoldalt = 'menu_o_' . $i;
		$menusorrend = 'menu_sorrend_' . $i;
		If ($_REQUEST[$menunev] != ""){
			$sql2 = "UPDATE ".$_SESSION[adattabla_etag]."szoveg SET menunev = '$_REQUEST[$menunev]' WHERE sorszam=$i";
			mysql_query($sql2);	
		}
		If ($_REQUEST[$menuaktiv] != ""){
			$sql2 = "UPDATE ".$_SESSION[adattabla_etag]."szoveg SET archiv = '0' WHERE sorszam=$i";
			mysql_query($sql2);	
		}
		If ($_REQUEST[$menufent] != ""){
			$sql2 = "UPDATE ".$_SESSION[adattabla_etag]."szoveg SET menu_fent = '1' WHERE sorszam=$i";
			mysql_query($sql2);	
		}
		If ($_REQUEST[$menuoldalt] != ""){
			$sql2 = "UPDATE ".$_SESSION[adattabla_etag]."szoveg SET menu_oldalt = '1' WHERE sorszam=$i";
			mysql_query($sql2);	
		}
		$sql2 = "UPDATE ".$_SESSION[adattabla_etag]."szoveg SET sorrend = '$_REQUEST[$menusorrend]' WHERE sorszam=$i";
		mysql_query($sql2);
	}
	
	#a menü adatainak rögzítése az adatbázisba
	If ($_REQUEST['kategoriakarb'] != ""){
		$result = mysql_query("SELECT MAX(sorszam) FROM ".$_SESSION[adattabla_etag]."szoveg");
		$row = mysql_fetch_array($result); 
		$num_rows=$row[0];
		$num_rows++;
		$sql2 = "INSERT INTO ".$_SESSION[adattabla_etag]."szoveg (sorszam, sorrend, menunev) values ('$num_rows', '$num_rows', '$_REQUEST[kategoriakarb]')";
		mysql_query($sql2);
}
}


$result = mysql_query("SELECT sorszam, menunev, archiv, sorrend, menu_fent, menu_oldalt FROM ".$_SESSION[adattabla_etag]."szoveg ORDER BY sorrend");
while ($next_element = mysql_fetch_array($result)){
	If ($next_element['archiv'] == '0') { $aktivcheck = 'checked="checked"';}
	else { $aktivcheck = '';}
	if ($next_element[menu_fent] == "1") { $menu_fent_be = ' checked="checked"';}
	else { $menu_fent_be = '';}
	if ($next_element[menu_oldalt] == "1") { $menu_oldalt_be = ' checked="checked"';}
	else { $menu_oldalt_be = '';}
	$menulista = $menulista . '<tr><td><input name="menunev_'.$next_element['sorszam'].'" size="30" type="text" value="'.$next_element['menunev'].'"></td><td><input type="checkbox" name="menu_akt_' . $next_element['sorszam'] . '" '.$aktivcheck.'></td><td><a href="#"><img src="graphics/icon_del.png" title="kategória törlése" border="0" width="23" style="margin: 5 0 0 20;" onclick="megerosites_x('.$next_element[sorszam].', \'menupont\')"></a></td><td><a href="admin.php?tartalom=szovegszerk&valaszt='.$next_element[sorszam].'"><img src="graphics/icon_edit.gif" title="leírás szerkesztése" border="0" width="23" style="margin: 5 0 0 20;"></a></td><td><input type="checkbox" name="menu_f_' . $next_element['sorszam'] . '"'.$menu_fent_be.'></td><td><input type="checkbox" name="menu_o_' . $next_element['sorszam'] . '"'.$menu_oldalt_be.'></td><td><input name="menu_sorrend_'.$next_element[sorszam].'" style="width: 25px;" type="text" value="'.$next_element[sorrend].'"></td></tr>';
}

$admin_menuk = '
<div class="admin_xtabla">
	<FORM ACTION="admin.php?tartalom=menuk&ment=1" enctype="multipart/form-data" METHOD="POST" NAME="kategoriak">
	<table class="">
		<tr>
			<td colspan="10" align="center">
			MENÜK KARBANTARTÁSA
			</td>
		</tr>
		<tr>
			<td align="center">Név</td><td align="center">Aktív</td><td align="center">Töröl</td><td align="center">Szerkeszt</td><td align="center">Fent</td><td align="center">Oldalt</td><td align="center">Sorrend</td>
		</tr>
		'.$menulista.'
		<tr>
			<td colspan="10" align="center">
			Új menü rögzítése:<br><input name="kategoriakarb" size="30" type="text" value="">
			</td>
		</tr>
		<tr>
			<td colspan="10" align="center">
			<INPUT type="submit" name="submit" value="Módosítás">
			</td>
		</tr>
	</table>
	</FORM>
</div>';
?>