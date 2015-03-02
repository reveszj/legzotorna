<?
session_start();
include('inc/adatkapcsolat.php');
include('inc/class.php');
include('admin/login.php');

$admin_htmluj = new html_blokk;
	
If ($_SESSION["sessfelhasznalo"] == "") {
	#Ha nincs bejelentkezve
	$array = array('belephiba' => $belephiba);
	$admin_htmluj->load_template_file("template/login.tpl",$array);
	$login_html = $admin_htmluj->html_code;
			
	$array = array('admin_torzs' => $login_html);}
else {
	#Ha be van jelentkezve tovább megy
	$admin_menuuj = new html_blokk;
	$admin_menuuj->load_template_file("template/admin_menu.tpl",$array);
	$admin_menu = $admin_menuuj->html_code;
	
	include ('admin/admin_html.php');
	
	$array = array('admin_torzs' => $admin_torzs,
 	 			   'admin_menu' => $admin_menu);
}
	
$admin_htmluj->load_template_file("template/admin.tpl",$array);
echo $admin_htmluj->html_code;
?>