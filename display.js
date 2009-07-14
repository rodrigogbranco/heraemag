function display(esto) {
	var vista; 
	if (document.layers) {
		vista = (document.layers[esto].display == 'none') ? 'block' : 'none';
		document.layers[esto].display = vista;
	} else if (document.all) {
		vista = (document.all[esto].style.display == 'none') ? 'block' : 'none';
		document.all[esto].style.display = vista;
	} else if (document.getElementById) {
		vista = (document.getElementById(esto).style.display == 'none') ? 'block' : 'none';
		document.getElementById(esto).style.display = vista;
	}
}

function Aviso() {
	//document.write('<embed src="http://www.sidar.org/hera2/img/sonido.wav" hidden="true" loop="false" width="1" height="1"></embed>');
	document.write('<bgsound src="http://www.sidar.org/hera2/img/sonido.wav">');
}