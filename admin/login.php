<?php
$jel = mysql_real_escape_string($_REQUEST['jelszo']);
$jel = md5($jel);
$azon = mysql_real_escape_string($_REQUEST['azonosito']);

If ($_REQUEST['logout'] == 1) {	
	unset($_SESSION["sessfelhasznalo"]);
	unset($_SESSION["sessfelhasznalosorszam"]);
	unset($_SESSION["sessfelhasznalojog"]);
}

If ($_REQUEST['azonosito'] != "") {
	if ($azon != ""){
	$result = mysql_query("SELECT nev, sorszam, azonosito, jog FROM ".$_SESSION[adattabla_etag]."regisztralt WHERE azonosito = '$azon' AND jelszo = '$jel' AND archiv='0' AND jog='1'");	
	#echo mysql_error();
	$s = mysql_fetch_row($result);
		
	if ($s[2] != ""){
		$_SESSION["sessfelhasznalo"] = $s[2];
		$_SESSION["sessfelhasznalosorszam"] = $s[1];
		$_SESSION["sessfelhasznalojog"] = $s[3];
		}
	else {
		$belephiba = "<tr><td colspan='2' class='cedula_ar'>Rossz felhasználónév, vagy jelszó!</td></tr>";
		}
	}
}
?>