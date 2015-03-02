<?php

class html_blokk{
	public $html_code;
	
	function load_template_file($fajlnev,$tomb) {
		if(file_exists($fajlnev) > 0) {
			$temp = fopen($fajlnev,"r");
			$tartalomj = fread($temp, filesize($fajlnev));
			fclose($temp);
			$tartalomj = preg_replace("/{(.*?)}/si","{\$tomb[\\1]}",$tartalomj);
			eval("\$tartalomj = \"" . addslashes($tartalomj) . "\";");
			$tartalomj = str_replace("\'", "'", $tartalomj);
			$this->html_code = $tartalomj . "\n";
		}
	}
}

class html_blokk_mysql{
	public $html_code;
	
	function load_template_string($string,$tomb) {			
		$tartalom = $string;			
		$tartalom = preg_replace("/{(.*?)}/si","{\$tomb[\\1]}",$tartalom);			
		eval("\$tartalom = \"" . addslashes($tartalom) . "\";");			
		$tartalom = str_replace("\'", "'", $tartalom);			
		$this->html_code = $tartalom . "\n";	
	}
}

?>