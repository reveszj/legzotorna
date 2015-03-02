var tit = document.title;
var c = 0;

function writetitle() {
if (document.all || document.getElementById) {
 document.title = tit.substring(0,c);
 if (c==tit.length) {
 c = 0;
 setTimeout("writetitle()", 400) // 
 }
 else {
 c++;
 setTimeout("writetitle()", 200) // 
 }
}
}

function divdisp_on(id){

	if (id == 'admin_termekadatlap' || id == 'admin_termekfotok' || id == 'admin_termekforum'){
		document.getElementById('admin_termekadatlap').style.display = 'none';
		document.getElementById('admin_termekfotok').style.display = 'none';
		document.getElementById('admin_termekforum').style.display = 'none';
		document.getElementById('kepfeltolt').style.display = 'none';
	}
	
	if (id == 'admin_cikkadatlap' || id == 'admin_cikkszoveg'){
		document.getElementById('admin_cikkadatlap').style.display = 'none';
		document.getElementById('admin_cikkszoveg').style.display = 'none';
	}
	
	if (id == 'admin_termekfotok'){document.getElementById('kepfeltolt').style.display = 'block';}
	
	document.getElementById(id).style.display = 'block';
	
	var newStr = id.substring(0, id.length-1);
	document.getElementById(newStr).style.color = '#e9e9e9';
	document.getElementById(newStr).style.backgroundColor = '#5a4c43';
}

function megerosites_x(torolszam, formnev) {
	if (formnev == "kepek") {
		var answer = confirm ("Ön a KÉP TÖRLÉSÉT választotta.\n Biztosan szeretné?");
		if (answer) { window.location="admin.php?tartalom=kepek&keptorles="+torolszam;}
	}
	if (formnev == "dokumentumok") {
		var answer = confirm ("Ön a DOKUMENTUM TÖRLÉSÉT választotta.\n Biztosan szeretné?");
		if (answer) { window.location="admin.php?tartalom=dokumentumok&keptorles="+torolszam;}
	}
	if (formnev == "file") {
		var answer = confirm ("Ön a FÁJL TÖRLÉSÉT választotta.\n Biztosan szeretné?");
		if (answer) { window.location="admin.php?tartalom=file&keptorles="+torolszam;}
	}
	if (formnev == "szoveg") {
		var answer = confirm ("Ön a CIKK TÖRLÉSÉT választotta.\n Biztosan szeretné?");
		if (answer) { window.location="admin.php?tartalom=szovegszerk&torles="+torolszam;}
	}
}