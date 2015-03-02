<?php

if ($_REQUEST[ok]){
	$uzenet = '<strong>Köszönjük a rendelését, a terméket hamarosan postázzuk!</strong>';
}

if (isset($_REQUEST[send]))	{
	unset($uzenet);
	$hiba = 0;
	
	if (!$_REQUEST[name]){
		$uzenet .= '- Nem adta meg a nevét!<br />';
		$hiba++;
	}
	
	if (!$_REQUEST[phone]){
		$uzenet .= '- Nem adta meg a telefonszámát!<br />';
		$hiba++;
	}
	
	if (!$_REQUEST[email]){
		$uzenet .= '- Nem adott meg email címet!<br />';
		$hiba++;
	}
	
	if (!$_REQUEST[zip]){
		$uzenet .= '- Nem adta meg az irámyitószámot!<br />';
		$hiba++;
	}
	
	if (!$_REQUEST[city]){
		$uzenet .= '- Nem adta meg a települést<br />';
		$hiba++;
	}
	
	if (!$_REQUEST[street]){
		$uzenet.= '- Nem adta meg az utcát!<br />';
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
	$uzenet .= '- Nem választott terméket!<br />';
	$hiba++;
	}

	if (!$_REQUEST[no]){
		$uzenet .= '- Nem adta meg a darabszámot!<br />';
		$hiba++;
	}
	
	if (!$_REQUEST[fizetes])  {
		$uzenet .= '- Nem adta meg a fizetési módot!<br />';
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
		$utalas_szoveg = 'elõre utalás';
		$utalas_x = ' checked="checked"';
	} else {
		$utalas = 'unchecked';
	}
	if ($_REQUEST['fizetes'] == 'utanvet'){
		$utanvet = 'checked';
		$utanvet_szoveg = 'utánvétel';
		$utanvet_x = ' checked="checked"';
	} else {
		$utanvet = 'unchecked';
	}
	
	$subject = 'Rendelés' ;		
	$message = $_REQUEST['name'] .' rendelt a honlapról.<br /><br /><strong>Termék(ek:)</strong><br />'.$dvd_szoveg.'<br />'.$szalag_szoveg.'.<br />
	<strong>Szállítási cím:</strong><br />
	'.$_REQUEST['city'].'<br />
	'.$_REQUEST['street'].'<br />
	'.$_REQUEST['zip'].'<br />
	<strong>Telefonszám:</strong> '.$_REQUEST['phone'].'<br />
	<strong>Fizetési mód:</strong> '.$utalas_szoveg.$utanvet_szoveg;
	
	if ($hiba == 0){
		  
		  $cimzett = 'info@legzotorna.hu';
			
			$subject = $subject. " honlapról: " ;
			$message = '<strong>Üzenet:</strong><br /> '.$message;		
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-2' . "\r\n";
			$headers .= 'From: '.$name.'<'.$email.'>' . "\r\n" .
						'Reply-To: '.$email.'' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();

			mail($cimzett, $subject, $message, $headers);
			
		  
		    #adatbázis mentés helye
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
			
			//helyes végrehajtás után üresen újra meghívjuk az oldalt és az "ok"-nak értéket ad
			header("Location: index.php?id=".$_REQUEST[id]."&ok=1");  
	}
}

if ($hiba > 0){
	$uzenet = '<strong>Az ûrlap az alábbi hibákat tartalmazza: </strong><br />'.$uzenet;
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

