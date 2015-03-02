<?php
if ($_REQUEST[ok]){
	$uzenet = 'Köszönjük érdeklõdését, hamarosan válaszolunk!';
}

if (isset($_REQUEST[send]))	{
	
	$hiba = 0;
	
	if (!$_REQUEST[subject]){
		$uzenet = 'Nem adott meg tárgy mezõt!';
		$hiba++;
	}
	
	if (!$_REQUEST[email]){
		$uzenet = 'Nem adott meg email címet!';
		$hiba++;
	}
	
	if (!$_REQUEST[message]){
		$uzenet = 'Nem írt üzenetet!';
		$hiba++;
	}
	
	$email = $_REQUEST['email'] ;
	#$name = $_REQUEST['name'] ;
	$subject = $_REQUEST['subject'] ;		
	$message = $_REQUEST['message'];
	
	if ($hiba == 0){
		  
		  $cimzett = 'info@legzotorna.hu';
			
			$subject = "Üzenet a honlapról: " . $subject;
			$message = 'Üzenet: '.$message;		
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-2' . "\r\n";
			$headers .= 'From: '.$name.'<'.$email.'>' . "\r\n" .
						'Reply-To: '.$email.'' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();

			mail($cimzett, $subject, $message, $headers);
			
		  
		    #adatbázis mentés helye
			$sql = "INSERT INTO ".$_SESSION[adattabla_etag]."uzenet (email, nev, message) values ('$email', '$name', '$message')";
			mysql_query($sql);
			
			unset($email);
			unset($name);
			unset($message);
			
			//helyes végrehajtás után üresen újra meghívjuk az oldalt és az "ok"-nak értéket ad
			header("Location: index.php?id=".$_REQUEST[id]."&ok=1");  
	}
}

$array = array('uzenet' => $uzenet,
				'email' => $email,
				'name' => $name,
				'message' => $message,
				'subject' => $subject);
$email_urlap_html = new html_blokk;
$email_urlap_html->load_template_file("template/email.html",$array);
$php_file_html = $email_urlap_html->html_code;
?>

