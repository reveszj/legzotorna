<?php
$domain = $_SERVER['HTTP_HOST'];

if ($domain != 'localhost'){
	$kapcsolat = mysql_connect("localhost", "legzotor_user", "kerti2014");
	if (!$kapcsolat) {die('Hiba a MySQL szerverhez kapcsolódás közben: ' . mysql_error());}
	$adatbazis = mysql_select_db("legzotor_kerti");
	if (!$adatbazis) {die('Hiba az adatbázis elérésekor: ' . mysql_error());}
	$ekezet = mysql_set_charset("latin2",$kapcsolat);}

else {

	$kapcsolat = mysql_connect("localhost", "root", "");
	if (!$kapcsolat) {die('Hiba a MySQL szerverhez kapcsolódás közben: ' . mysql_error());}
	$adatbazis = mysql_select_db("kerti");
	if (!$adatbazis) {die('Hiba az adatbázis elérésekor: ' . mysql_error());}
	$ekezet = mysql_set_charset("latin2",$kapcsolat);

}
$_SESSION[adattabla_etag] = 'kerti_';
?>