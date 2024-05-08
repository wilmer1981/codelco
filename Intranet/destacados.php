<SCRIPT language=JavaScript>
<!--

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}
//-->
</SCRIPT>
<LINK href="images/style.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript>
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
// -->
</SCRIPT>

<SCRIPT language=JavaScript>
<!--


function doClock() {
    // By Paul Davis - www.kaosweaver.com;
    var t = new Date(), a = doClock.arguments, str = "", i, a1, lang = "5";
    var month = new Array('Enero','Enero', 'Febrero','Feb', 'Marzo','Marzo', 'Abril','Abr', 'Mayo','Mayo', 'Junio','Jun', 'Julio','Jul', 'Agosto','Agosto', 'Septiembre','Sept', 'Octubre','Oct', 'Noviembre','Nov', 'Diciembre','Dic');
    var tday = new Array('domingo','dom','lunes','lun', 'martes','mar', 'miércoles','mié','jueves','jue','viernes','vie','sábado','sáb');
    for (i = 0; i < a.length; i++) {
        a1 = a[i].charAt(1);
        switch (a[i].charAt(0)) {
          case "M":
            if ((Number(a1) == 3) && ((t.getMonth() + 1) < 10)) {
                str += "0";
            }
            str += (a1 == "2") ? t.getMonth() + 1 : month[t.getMonth() * 2 + Number(a1)];
            break;
          case "D":
            if ((Number(a1) == 1) && (t.getDate() < 10)) {
                str += "0";
            }
            str += t.getDate();
            break;
          case "Y":
            str += (a1 == "0") ? t.getFullYear() : t.getFullYear().toString().substring(2);
            break;
          case "W":
            str += tday[t.getDay() * 2 + Number(a1)];
            break;
          default:
            str += unescape(a[i]);
        }
    }
    return str;
}

function flevDivPositionValue(sDiv, sProperty) { // v2.1, Marja Ribbers-de Vroed, FlevOOware
	this.opera = (window.opera); // Opera 5+
	this.ns4 = (document.layers); // Netscape 4.x
	this.ns6 = (document.getElementById && !document.all && !this.opera); // Netscape 6+
	this.ie = (document.all);  // Internet Explorer 4+
    var sValue = ""; docObj = eval("MM_findObj('" + sDiv + "')"); if (docObj == null) {return 0;}
	if ((sProperty == "left") || (sProperty == "top")) {
		if (!this.ns4) {docObj = docObj.style;} 
		sValue = eval("docObj." + sProperty);
		if ((this.ie) && (sValue == "")) { // IE (on PC) bug with nested layers
			if (sProperty == "top") { sValue = eval(sDiv + ".offsetTop"); } 
			else { sValue = eval(sDiv + ".offsetLeft"); } 

		};
	}
	else {
		if (this.opera) {
			docObj = docObj.style;
			if (sProperty == "height") { sValue = docObj.pixelHeight; } 
			else if (sProperty == "width") { sValue = docObj.pixelWidth; } 
		}
		else if (this.ns4) {sValue = eval("docObj.clip." + sProperty);} 
		else if (this.ns6) {sValue = document.defaultView.getComputedStyle(docObj, "").getPropertyValue(sProperty); } 
	    else if (this.ie) { 
			if (sProperty == "width") { sValue = eval(sDiv + ".offsetWidth"); } 
			else if (sProperty == "height") { sValue = eval(sDiv + ".offsetHeight"); } 
		}
   	}
	sValue = (sValue == "") ? 0 : sValue; 
	if (isNaN(sValue)) { if (sValue.indexOf('px') > 0) { sValue = sValue.substring(0,sValue.indexOf('px')); } } 
	return parseInt(sValue); 
}

function flevMoveDiv(sDivID, sLeft, sTop){ // v1.3, Marja Ribbers-de Vroed, FlevOOware
	var	docObj = eval("MM_findObj('" + sDivID + "')"), sSuffix=""; 
	if (!document.layers) {docObj = docObj.style;} // not NS4.x 
	if((parseInt(navigator.appVersion)>4 || navigator.userAgent.indexOf("MSIE")>-1) && (!window.opera)) {sSuffix="px";}
	if (sLeft != "") {eval("docObj.left = '" + sLeft + sSuffix + "'");}
	if (sTop != "") {eval("docObj.top = '" + sTop + sSuffix + "'");}
}

function flevAutoScrollDivs() { // v1.11, Marja Ribbers-de Vroed, FlevOOware
	var iArgs = flevAutoScrollDivs.arguments.length;   
	var docObj = MM_findObj('AutoScrollContainer'); if (!docObj) {return;}
	if (docObj.scrollTimeout != null) {clearTimeout(docObj.scrollTimeout);}
	var sContainerDivID = 'AutoScrollContainer';   
	var sContentDivID = 'AutoScrollContent';   
	var iStartScrolling = (iArgs > 0) ? parseInt(flevAutoScrollDivs.arguments[0]) : 1;  
	var iPixels = (iArgs > 1) ? parseInt(flevAutoScrollDivs.arguments[1]) : 1;   
	var iDelay = (iArgs > 2) ? parseInt(flevAutoScrollDivs.arguments[2]) : 50;   
	var iCurrentTop = flevDivPositionValue(sContentDivID, 'top');   
	var iScrollTop = (-1 * flevDivPositionValue(sContentDivID, 'height'));   
	var iScrollBottom = flevDivPositionValue(sContainerDivID, 'height');   
	var iCurrentLeft = flevDivPositionValue(sContentDivID, 'left');  
	if (iStartScrolling) {   
		if (iCurrentTop >= iScrollTop) {flevMoveDiv(sContentDivID, String(iCurrentLeft), String(iCurrentTop-iPixels));}	// Continue scrolling   
		else {flevMoveDiv(sContentDivID, String(iCurrentLeft), String(iScrollBottom));}	// Re-position scrolling layer at bottom of containing layer  
		docObj.scrollTimeout = setTimeout("flevAutoScrollDivs(" + iStartScrolling + "," + iPixels + "," + iDelay + ")", iDelay);   
	}   
}
//-->
</SCRIPT>

<STYLE type=text/css>
#AutoScrollContent {
	LEFT: 0px; VISIBILITY: visible; WIDTH: 225px; POSITION: absolute; TOP: 96px
}
</STYLE>
<DIV id=AutoScrollContainer 
style="Z-INDEX: 1; LEFT: 200px; VISIBILITY: visible; OVERFLOW: hidden; WIDTH: 225px; HEIGHT: 60px; left:10px"><!-- Do NOT define (additional) styles for the following nested layer here. 
       If required, modify the inline styles in the head section -->
<DIV id=AutoScrollContent>
<SCRIPT language=JavaScript>
<!--
function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function flevDivPositionValue(sDiv, sProperty) { // v2.1, Marja Ribbers-de Vroed, FlevOOware
	this.opera = (window.opera); // Opera 5+
	this.ns4 = (document.layers); // Netscape 4.x
	this.ns6 = (document.getElementById && !document.all && !this.opera); // Netscape 6+
	this.ie = (document.all);  // Internet Explorer 4+
    var sValue = ""; docObj = eval("MM_findObj('" + sDiv + "')"); if (docObj == null) {return 0;}
	if ((sProperty == "left") || (sProperty == "top")) {
		if (!this.ns4) {docObj = docObj.style;} 
		sValue = eval("docObj." + sProperty);
		if ((this.ie) && (sValue == "")) { // IE (on PC) bug with nested layers
			if (sProperty == "top") { sValue = eval(sDiv + ".offsetTop"); } 
			else { sValue = eval(sDiv + ".offsetLeft"); } 
		};
	}
	else {
		if (this.opera) {
			docObj = docObj.style;
			if (sProperty == "height") { sValue = docObj.pixelHeight; } 
			else if (sProperty == "width") { sValue = docObj.pixelWidth; } 
		}
		else if (this.ns4) {sValue = eval("docObj.clip." + sProperty);} 
		else if (this.ns6) {sValue = document.defaultView.getComputedStyle(docObj, "").getPropertyValue(sProperty); } 
	    else if (this.ie) { 
			if (sProperty == "width") { sValue = eval(sDiv + ".offsetWidth"); } 
			else if (sProperty == "height") { sValue = eval(sDiv + ".offsetHeight"); } 
		}
   	}
	sValue = (sValue == "") ? 0 : sValue; 
	if (isNaN(sValue)) { if (sValue.indexOf('px') > 0) { sValue = sValue.substring(0,sValue.indexOf('px')); } } 
	return parseInt(sValue); 
}

function flevMoveDiv(sDivID, sLeft, sTop){ // v1.3, Marja Ribbers-de Vroed, FlevOOware
	var	docObj = eval("MM_findObj('" + sDivID + "')"), sSuffix=""; 
	if (!document.layers) {docObj = docObj.style;} // not NS4.x 
	if((parseInt(navigator.appVersion)>4 || navigator.userAgent.indexOf("MSIE")>-1) && (!window.opera)) {sSuffix="px";}
	if (sLeft != "") {eval("docObj.left = '" + sLeft + sSuffix + "'");}
	if (sTop != "") {eval("docObj.top = '" + sTop + sSuffix + "'");}
}

function flevAutoScrollDivs() { // v1.11, Marja Ribbers-de Vroed, FlevOOware
	var iArgs = flevAutoScrollDivs.arguments.length;   
	var docObj = MM_findObj('AutoScrollContainer'); if (!docObj) {return;}
	if (docObj.scrollTimeout != null) {clearTimeout(docObj.scrollTimeout);}
	var sContainerDivID = 'AutoScrollContainer';   
	var sContentDivID = 'AutoScrollContent';   
	var iStartScrolling = (iArgs > 0) ? parseInt(flevAutoScrollDivs.arguments[0]) : 1;  
	var iPixels = (iArgs > 1) ? parseInt(flevAutoScrollDivs.arguments[1]) : 1;   
	var iDelay = (iArgs > 2) ? parseInt(flevAutoScrollDivs.arguments[2]) : 50;   
	var iCurrentTop = flevDivPositionValue(sContentDivID, 'top');   
	var iScrollTop = (-1 * flevDivPositionValue(sContentDivID, 'height'));   
	var iScrollBottom = flevDivPositionValue(sContainerDivID, 'height');   
	var iCurrentLeft = flevDivPositionValue(sContentDivID, 'left');  
	if (iStartScrolling) {   
		if (iCurrentTop >= iScrollTop) {flevMoveDiv(sContentDivID, String(iCurrentLeft), String(iCurrentTop-iPixels));}	// Continue scrolling   
		else {flevMoveDiv(sContentDivID, String(iCurrentLeft), String(iScrollBottom));}	// Re-position scrolling layer at bottom of containing layer  
		docObj.scrollTimeout = setTimeout("flevAutoScrollDivs(" + iStartScrolling + "," + iPixels + "," + iDelay + ")", iDelay);   
	}   
}
//-->
</SCRIPT>
<?
	$Consulta = "select * from intranet.mensajes order by fecha ";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		echo "<P>";
		if ($Fila["link"]!="" && !is_null($Fila["link"]))
			echo "<A onmouseover=\"flevAutoScrollDivs(0)\" onmouseout=\"flevAutoScrollDivs(1,1,50)\" href=\"".$Fila["link"]."\" target=_top>";
		echo substr($Fila["fecha"],8,2)."-".substr($Fila["fecha"],5,2)."-".substr($Fila["fecha"],0,4)."<br>";
		echo "<b>".$Fila["mensaje"]."</b>";
		if ($Fila["link"]!="" && !is_null($Fila["link"]))
			echo "<IMG height=\"13\" src=\"images/mas_info.gif\" width=\"23\" align=\"absMiddle\" border=\"0\"></A>";
		else
			echo "<br>";
		echo "<IMG height=\"9\" src=\"images/div_horiz.gif\" width=\"139\" border=0></P>\n";
		echo "<P></P>\n";
	}
?>
<!-- End absolute positioned Cross-browser AutoScroller -->
</DIV></DIV>
