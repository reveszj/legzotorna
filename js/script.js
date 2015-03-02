$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: 'images/loading.gif',
				play: 5000,
				pause: 2500,
				hoverPause: true
			});
		});
/* Cím kiírás */		
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