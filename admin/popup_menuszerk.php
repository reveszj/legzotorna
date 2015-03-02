<?php
header('Content-Type: text/html; charset=iso-8859-2');

include('../inc/adatkapcsolat.php');

$id = $_REQUEST[id];

$result = mysql_query("SELECT id, nev, cikk_id, szulo, sorrend, archiv FROM ".$_SESSION[adattabla_etag]."menu WHERE id = '$id'");	
$a = mysql_fetch_row($result);

$result = mysql_query("SELECT id, nev, sorrend FROM ".$_SESSION[adattabla_etag]."menu WHERE szulo = '0' ORDER BY sorrend");
while ($next_element = mysql_fetch_array($result)){
	if ($a[3] == $next_element[id]){
		$combo_select = 'selected="selected"';
	} else {
		$combo_select = '';
	}
	$combo_rovat_lista .= '<option value="'.$next_element[id].'" '.$combo_select.'>'.$next_element[nev].'</option>';
}

$result = mysql_query("SELECT sorszam, cim FROM ".$_SESSION[adattabla_etag]."szoveg WHERE archiv = '0' ORDER BY cim");
while ($next_element = mysql_fetch_array($result)){
	if ($a[2] == $next_element[sorszam]){
		$combo_select = 'selected="selected"';
	} else {
		$combo_select = '';
	}
	$combo_cikk_lista .= '<option value="'.$next_element[sorszam].'" '.$combo_select.'>'.$next_element[sorszam].' - '.$next_element[cim].'</option>';
}

#$xxx = '<option value="'.$valtozo.'" '.$selected.'>Rólunk</option>';


if ($a[5] == '0'){
	$aktiv_check = 'checked="checked"';
} else {
	$aktiv_check = '';
}

echo '
<div id="popup_urlap">
	<fieldset>ÛRLAP <br /><br /><br />
	<form action="" method="post">
	<input type="hidden" name="id" value="'.$a[0].'"  />
	<label>Név: </label><input type="text" name="nev" value="'.$a[1].'" /><br /><br />	

	<label>Fõmenü</label>
	<select name="menu">
		<option value="0"></option>
		'.$combo_rovat_lista.'
	</select><br /><br />

	<label>Melyik cikk</label>
	<select name="cikk">
		<option value=""></option>
		'.$combo_cikk_lista.'
	</select><br /><br />

	<label>Sorrend: </label><input type="text" name="sorrend" value="'.$a[4].'" /><br /><br />	

	<label>Aktív: </label><input style="margin-left:-70px;" type="checkbox" name="aktiv" '.$aktiv_check.'/><br /><br />

	<input type="submit" name="mentes" class="buttom" value="MENTÉS" />
	<input type="submit" name="torles" class="buttom" style="margin-left: 20px;" value="TÖRLÉS" />
	<img src="graphics/close.png" title="Bezárás" alt="mégsem" onclick="divdisp_off(\'popup\')" />
</form>
</fieldset>
</div>';
?>