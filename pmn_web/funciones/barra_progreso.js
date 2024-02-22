if (document.all || document.getElementById)
{
	document.write('<div id="barrapadre" style="position:relative;width:200px;height:20px;visibility:hidden;">');
	document.write('<div id="fondobarra" style="width:200px;height:20px;z-index:9;"></div>');
	document.write('<div id="barra" style="width:200px;height:20px;z-index:10"></div>');
	document.write('</div>');
}
var duracion=5;
var clipderecho=0; // define el recorte inicial derecho de la barra de progreso
var anchuraIE=0;  // define la anchura inicial de la barra de progreso para Internet Explorer
var anchuraN6=0;  // define la anchura inicial de la barra de progreso para Nestcape Navigator 6x
var anchuraNC=0; // define la anchura inicial de la barra de progreso para Nestcape Navigator 4x

function inicializabarra(form,url)
{  
	window.location=url;
  if (document.all)
  {
	  document.all['barrapadre'].style.visibility="visible";
	  anchuraIE=document.all['barra'].style.pixelWidth;
	  arrancaIE=setInterval("incrementaIE()",50);
  }
  else  if(document.getElementById)
  {
	  document.getElementById('barrapadre').style.visibility="visible";
	  anchuraN6=parseInt(document.getElementById('barra').style.width);
	  arrancaN6=setInterval("incrementaN6()",50);
  }
  else if (document.layers)
  {
	  anchuraNC=document.barrapadreNS.document.fondobarraNS.clip.width;
	  document.barrapadreNS.document.barraNC.clip.right=0;
	  document.barrapadreNS.visibility="show";
	  arrancaNC=setInterval("incrementaNC()",50);
  }
}
	  
function incrementaIE()
{
  barra.style.clip="rect(0 "+clipderecho+" auto 0)";
  window.status="Procesando...";
  if (clipderecho<anchuraIE)
  {
	  clipderecho=clipderecho+(anchuraIE/(duracion*20));
  }
  else
  {
		window.status="";
		clearInterval(arrancaIE);
		accion();
  }
}
	  
function incrementaN6()
{
  document.getElementById('barra').style.clip="rect(0 "+clipderecho+" auto 0)";
  window.status="Procesando...";
  if (clipderecho<anchuraN6)
  {
	  clipderecho=clipderecho+(anchuraN6/(duracion*20));
  }
  else
  {
		window.status="";
		clearInterval(arrancaN6);
		accion();
  }
}
	  
function incrementaNC()
{
  if (clipderecho<202)
  {
	  window.status="Procesando...";
	  document.barrapadreNS.document.barraNC.clip.right=clipderecho;
	  clipderecho=clipderecho+(anchuraNC/(duracion*20));
  }
  else
  {
	   window.status="";
	   clearInterval(arrancaNC);
	   accion();
  }
} 


