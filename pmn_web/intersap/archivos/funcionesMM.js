function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}


function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_displayStatusMsg(msgStr) { //v1.0
  status=msgStr;
  document.MM_returnValue = true;
}

function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}

function sobre(src,Color) {
    if (!src.contains(event.fromElement)) {
	  src.style.cursor = 'hand';
	   src.bgColor = Color;}}
function fuera(src,Color2) {
	if (!src.contains(event.toElement)) {
	  src.style.cursor = 'default';
	  src.bgColor = Color2;}}


MM_reloadPage(true);

document.write('<link rel="stylesheet" href="css/style.CSS" type="text/css">')
document.write('<style type="text/css">')
document.write('<!--')
document.write('a:link {')
document.write('	text-decoration: underline;')
document.write('}')
document.write('a:visited {')
document.write('	text-decoration: underline;')
document.write('}')
document.write('a:hover {')
document.write('	text-decoration: none;')
document.write('}')
document.write('a:active {')
document.write('	text-decoration: underline;')
document.write('}')
document.write('-->')
document.write('</style>')

function swMouseOver(id_tr)
{
	document.all[id_tr].bgColor=bgColor_over;
}

function swMouseOut(id_tr, id_trp)
{
	//alert(id_trp)
	if(id_trp != id_tr) 
		document.all[id_tr].bgColor=bgColor_out;
}

var bgColor_over = "#E7E7E7";
var bgColor_out = "#FFFFFF";