
document.write('<STYLE TYPE="text/css">');
document.write('<!--');
document.write('#dek {POSITION:absolute;VISIBILITY:hidden;Z-INDEX:200;}');
document.write('//-->');
document.write('</STYLE>');
document.write('<DIV ID="dek"></DIV>');


var Xoffset=-170;
var Yoffset= -40;

var old,skn,iex=(document.all),yyy=-1000;

var ns4=document.layers
var ns6=document.getElementById&&!document.all
var ie4=document.all

if (ns4)
	skn=document.dek
else if (ns6)
	skn=document.getElementById("dek").style
else if (ie4)
	skn=document.all.dek.style
if(ns4)document.captureEvents(Event.MOUSEMOVE);
else{
	skn.visibility="visible"
	skn.display="none"
}

document.onmousemove=get_mouse;

function popup(msg){
	var content="<TABLE  WIDTH=180 BORDER=1 BORDERCOLOR=D9D9D9 CELLPADDING=2 CELLSPACING=0 "+
	"BGCOLOR=F7F7F7><TD ALIGN=center><FONT COLOR=525552 SIZE=1 face=verdana >"+msg+"</FONT></TD></TABLE>";
	yyy=Yoffset;
	 if(ns4){skn.document.write(content);skn.document.close();skn.visibility="visible"}
	 if(ns6){document.getElementById("dek").innerHTML=content;skn.display=''}
	 if(ie4){document.all("dek").innerHTML=content;skn.display=''}
}

function get_mouse(e){
	var x=(ns4||ns6)?e.pageX:event.x+document.body.scrollLeft;
	skn.left=x+Xoffset;
	var y=(ns4||ns6)?e.pageY:event.y+document.body.scrollTop;
	skn.top=y+yyy;
}

function kill(){
	yyy=-1000;
	if(ns4){skn.visibility="hidden";}
	else if (ns6||ie4)
	skn.display="none"
}

