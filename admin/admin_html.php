<?
if ($_SESSION["sessfelhasznalo"] == "") {exit;}

if ($_REQUEST['tartalom']){
	include('admin/admin_'.$_REQUEST['tartalom'].'.php');
} else {
	$admin_torzs = '';
}
?>