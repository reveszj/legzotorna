<?php
session_start(); //session kezel�s bekapcsol�sa

include('inc/adatkapcsolat.php');
include('inc/class.php');
include('inc/menu.php');
include('inc/tartalomvalaszto.php');
include('inc/nyitokep.php');

$array = array('tartalom' => $tartalom_php,
				'menu' => $menu,			
				'slider' => $slider,
				'fejlec_kicsi' => $fejlec_kicsi,
				'kulcsszo'	=> $kulcsszo,				
				'oldalcim' => $oldalcim,
				'leiras' => $leiras,
				'email' => $email,			
);				
$index_html = new html_blokk;  //objektum l�trehoz�sa
$index_html->load_template_file("template/index.html",$array);
echo $index_html->html_code;
?>