<?php
if ((!$_REQUEST[id]) OR ($_REQUEST[id] == '1')){
	$slider = '
		<div id="slides">
		   <div class="slides_container">
			   <img src="images/banner1.jpg" width="960" height="300" alt="baner">
			   <img src="images/banner2.jpg" width="960" height="300" alt="baner">
			   <img src="images/banner3.jpg" width="960" height="300" alt="baner">
			   <img src="images/banner4.jpg" width="960" height="300" alt="baner">
			   <img src="images/banner5.jpg" width="960" height="300" alt="baner">
		   </div>
	   </div>
	   <div class="bevezeto">
			   <h3>�dv�z�lj�k!</h3>
			   <p>Kerti M�ria gy�gytorn�sz k�zel k�t �vtizede foglalkozik mellkasi deformit�sok �s l�gz�szervi betegs�gek kezel�s�vel.<br />
			   Az itt l�that� gyakorlatok a l�gz�s-rehabilit�ci�ban t�lt�tt �vek tapasztalat�t t�kr�zik �s k�r�lbel�l k�tezer beteg �llapot�t jav�tott�k jelent�sen.</p>
		</div>';
} else {
	$fejlec_kicsi = ' fejlec_kicsi';
}