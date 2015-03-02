<?php
if($_REQUEST[id])	{
	$cikk_id = $_REQUEST[id];}
else {
	$cikk_id = 1;
}
$result = mysql_query("SELECT oldalcim, kulcsszo, leiras, tartalom, php_file, aktiv, menu FROM ".$_SESSION[adattabla_etag]."szoveg WHERE id = '$cikk_id' AND aktiv = '1'");
$cikk = mysql_fetch_row($result);

$oldalcim = ' - '.$cikk[0];
$kulcsszo = $cikk[1];
$leiras = $cikk[2];
$tartalom_php = $cikk[3];
$php_file = $cikk[4];

if($php_file)	{
	include('inc/'.$php_file); //itt jöhet létre a $php_file_html
}

$tartalom_html = new html_blokk_mysql;	
$tartalom_html->load_template_string($tartalom_php,$array);
	
$tartalom_php = $tartalom_html->html_code . $php_file_html;
?>