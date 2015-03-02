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
			   <h3>Üdvözöljük!</h3>
			   <p>Kerti Mária gyógytornász közel két évtizede foglalkozik mellkasi deformitások és légzõszervi betegségek kezelésével.<br />
			   Az itt látható gyakorlatok a légzés-rehabilitációban töltött évek tapasztalatát tükrözik és körülbelül kétezer beteg állapotát javították jelentõsen.</p>
		</div>';
} else {
	$fejlec_kicsi = ' fejlec_kicsi';
}