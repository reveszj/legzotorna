<?php

if ($_REQUEST[ok]){
	$uzenet = '<strong>K�sz�nj�k a rendel�s�t, a term�ket hamarosan post�zzuk!</strong>';
}

if (isset($_REQUEST[send]))	{
	unset($uzenet);
	$hiba = 0;
	
	if (!$_REQUEST[name]){
		$uzenet .= '- Nem adta meg a nev�t!<br />';
		$hiba++;
	}
	
	if (!$_REQUEST[phone]){
		$uzenet .= '- Nem adta meg a telefonsz�m�t!<br />';
		$hiba++;
	}
	
	if (!$_REQUEST[email]){
		$uzenet .= '- Nem adott meg email c�met!<br />';
		$hiba++;
	}
	
	if (!$_REQUEST[zip]){
		$uzenet .= '- Nem adta meg az ir�myit�sz�mot!<br />';
		$hiba++;
	}
	
	if (!$_REQUEST[city]){
		$uzenet .= '- Nem adta meg a telep�l�st<br />';
		$hiba++;
	}
	
	if (!$_REQUEST[street]){
		$uzenet.= '- Nem adta meg az utc�t!<br />';
		$hiba++;
	}
	$termekszam = 0;
	if ($_REQUEST[dvd] == 'on' ){
		$termekszam++;
	}

	if ($_REQUEST[szalag] == 'on'){
		$termekszam++;
	}

	if ($termekszam == 0){
	$uzenet .= '- Nem v�lasztott term�ket!<br />';
	$hiba++;
	}

	if (!$_REQUEST[no]){
		$uzenet .= '- Nem adta meg a darabsz�mot!<br />';
		$hiba++;
	}
	
	if (!$_REQUEST[fizetes])  {
		$uzenet .= '- Nem adta meg a fizet�si m�dot!<br />';
		$hiba++;
	}
	
	if ($_REQUEST[elfogad] != 'on'){
		$uzenet .= '- Nem fogadta el az ASZF-et!<br />';
		$hiba++;
	}
	
	$email = $_REQUEST['email'] ;
	$no = $_REQUEST['no'] ;
	$city = $_REQUEST['city'] ;
	$street = $_REQUEST['street'] ;
	$zip = $_REQUEST['zip'] ;
	$phone = $_REQUEST['phone'] ;
	$name = $_REQUEST['name'] ;
	$elfogad = $_REQUEST['elfogad'] ;
	
	if ($_REQUEST['dvd'] == 'on'){
		$dvd = 1;
		$dvd_szoveg = ' '. $_REQUEST['no'].' darab dvd';
		$dvd_x = ' checked="checked"';
	} else {
		$dvd = 0;
	}
	if ($_REQUEST['szalag'] == 'on'){
		$szalag = 1;
		$szalag_szoveg = ' '. $_REQUEST['no'].' darab torna szalag';
		$szalag_x = ' checked="checked"';
	} else {
		$szalag = 0;
	}
	
	
	if ($_REQUEST['fizetes'] == 'utalas'){
		$utalas = 'checked';
		$utalas_szoveg = 'el�re utal�s';
		$utalas_x = ' checked="checked"';
	} else {
		$utalas = 'unchecked';
	}
	if ($_REQUEST['fizetes'] == 'utanvet'){
		$utanvet = 'checked';
		$utanvet_szoveg = 'ut�nv�tel';
		$utanvet_x = ' checked="checked"';
	} else {
		$utanvet = 'unchecked';
	}
	
	$subject = 'Rendel�s' ;		
	$message = $_REQUEST['name'] .' rendelt a honlapr�l.<br /><br /><strong>Term�k(ek:)</strong><br />'.$dvd_szoveg.'<br />'.$szalag_szoveg.'.<br />
	<strong>Sz�ll�t�si c�m:</strong><br />
	'.$_REQUEST['city'].'<br />
	'.$_REQUEST['street'].'<br />
	'.$_REQUEST['zip'].'<br />
	<strong>Telefonsz�m:</strong> '.$_REQUEST['phone'].'<br />
	<strong>Fizet�si m�d:</strong> '.$utalas_szoveg.$utanvet_szoveg;
	
	if ($hiba == 0){
		  
		  $cimzett = 'info@legzotorna.hu';
			
			$subject = $subject. " honlapr�l: " ;
			$message = '<strong>�zenet:</strong><br /> '.$message;		
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-2' . "\r\n";
			$headers .= 'From: '.$name.'<'.$email.'>' . "\r\n" .
						'Reply-To: '.$email.'' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();

			mail($cimzett, $subject, $message, $headers);
			
		  
		    #adatb�zis ment�s helye
			$sql = "INSERT INTO ".$_SESSION[adattabla_etag]."rendeles ( nev, telefon, email, irsz, telepules, utca, darab, dvd, szalag, utalas, utanvet, elfogad) values ('$name', '$phone','$email','$zip','$city','$street','$no','$dvd','$szalag','$utalas','$utanvet','$elfogad')";
			mysql_query($sql);
			
			unset($email);
			unset($name);
			unset($phone);
			unset($zip);
			unset($street);
			unset($city);
			unset($dvd);
			unset($szalag);
			unset($no);
			unset($fizetes);
			unset($elfogad);
			
			//helyes v�grehajt�s ut�n �resen �jra megh�vjuk az oldalt �s az "ok"-nak �rt�ket ad
			header("Location: index.php?id=".$_REQUEST[id]."&ok=1");  
	}
}

if ($hiba > 0){
	$uzenet = '<strong>Az �rlap az al�bbi hib�kat tartalmazza: </strong><br />'.$uzenet;
}

$array = array('uzenet' => $uzenet,
				'email' => $email,
				'name' => $name,
				'message' => $message,
				'subject' => $subject,
				'phone' => $phone,
				'zip' => $zip,
				'city' => $city,
				'street' => $street,
				'dvd' => $dvd,
				'szalag' => $szalag,
				'no' => $no,
				'utalas' => $utalas,
				'utanvet' => $utanvet,
				'utanvet_x' => $utanvet_x,
				'utalas_x' => $utalas_x,
				'dvd_x' => $dvd_x,
				'szalag_x' => $szalag_x,
				'elfogad' => $elfogad);
$email_urlap_html = new html_blokk;
$email_urlap_html->load_template_file("template/rendeles.html",$array);
$php_file_html = $email_urlap_html->html_code;
?>

