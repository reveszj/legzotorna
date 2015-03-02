<?php
$result = mysql_query("SELECT id, menu FROM ".$_SESSION[adattabla_etag]."szoveg WHERE aktiv = '1' AND menu !='' ORDER BY sorrend");
while($next_element = mysql_fetch_array($result))	{
		if($next_element[id] == $_REQUEST[id]) {
			$current = ' class = "current"';
		}
		if($next_element[id] == $_REQUEST[p])	{
			$current = ' class = "current"';
		}
		
		$menu .= "\n".'<a '.$current.' href="?id='.$next_element[id].' " >'.$next_element[menu].'</a>';
		unset ($current);
}

?>