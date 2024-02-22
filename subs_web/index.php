<html>
<head>
<link rel="stylesheet" href="../principal/estilos/css_principal.css">
<title>Sistema Calculo Subsidio e Incapacidad Laboral</title>
<script language="JavaScript">
// FUNCION DE FOCO DE CAMPOS
foco = ""; // PRIMERO NOMBRAR LOS CAMPOS DEL FORMULARIO
netscape = "";
ver = navigator.appVersion; len = ver.length;
for(iln = 0; iln < len; iln++) if (ver.charAt(iln) == "(") break; 
	netscape = (ver.charAt(iln+1).toUpperCase() != "C");
	
	function keyDown(DnEvents) {
		// IE o netscape
		k = (netscape) ? DnEvents.which : window.event.keyCode;
		if (k == 13) { // preciona tecla enter
		if (foco == 'btnEntrar') {
			var f = document.frmPrincipal;
			if (f.Rut.value == "")
			{
				alert("Debe Ingresar Rut");
				f.Rut.focus();
				return false;
			}
			if (f.Pass.value == "")
			{
				alert("Debe Ingresar Password");
				f.Pass.focus();
				return false;
			}
			f.action = "index01.php";
			f.submit();
			return false;
			//return true; // envia cuando termina los campos
		} else {
			// si existen mas campos va para el proximo
			eval('document.frmPrincipal.' + foco + '.focus()');
			return false;
		}
	}
}
document.onkeydown = keyDown; // work together to analyze keystrokes
</script>

<script language="JavaScript">
<!--
function ValidaCampos()
{
	var f = document.frmPrincipal;
	if (f.Rut.value == "")
	{
		alert("Debe Ingresar Rut");
		f.Rut.focus();
		return false;
	}
	if (f.Pass.value == "")
	{
		alert("Debe Ingresar Password");
		f.Pass.focus();
		return false;
	}
	return true;
}
//*************************//
function Entrar(opt)
{
	var f = document.frmPrincipal;
	if (opt == "E")
	{
		if (ValidaCampos())
		{
			f.action = "index01.php?Pass="+f.Pass.value;
			f.submit();
		}
	}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" onLoad="JavaScript:document.frmPrincipal.Rut.focus();MM_preloadImages('principal/imagenes/ingreso/ingreso_r4_c2_f2.gif')">
<form name="frmPrincipal" method="get" action="">
<div style="position:absolute; left: 5px; top: 2px;">
  <TABLE width=770 height="44" border=0 cellPadding=0 cellSpacing=0>
    <TBODY>
      <TR> 
        <th valign="top"><img src="../principal/imagenes/fondoarriba.jpg" width="770" height="50"></th>
      </TR>
    </TBODY>
  </TABLE>
</div>
  <div style="position:absolute; left: 5px; top: 48px; width: 768px; height: 39px;" class="TablaPrincipal"> 
    <table width="768" border="0" cellspacing="0" cellpadding="0" class="TablaSinFondo">
    <tr>
      <td height="30" align="right" background="../principal/imagenes/fondo_horiz.gif">
	  <table width="765">
            <tr valign="middle"> 
              <td width="48%" align="right"><img src="../principal/imagenes/fun_ref.gif" width="353" height="29"></td>
              <td width="2%" align="right">&nbsp;</td>
              <td width="10%" align="center">&nbsp;</td>
              <td width="40%" align="left"><div align="center" class="Detalle01">
                  <strong><font color="#333366" size="7">Sistema Calculo Subsidio e Incapacidad Laboral </font></strong></div></td>
            </tr>
          </table>
	</td>
    </tr>
  </table>
</div>  
<div style="position:absolute; left: 5px; top: 86px; width: 770px; height: 600px;">
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
			<tr> 
				
        <td height="316" align="center" valign="middle" background="../principal/imagenes/fondo3.gif">
		<div style="position:absolute; left: 14px; top: 16px; width: 363px; height: 255px;"><img src="../principal/imagenes/fondo_inicio.jpg"></div>
          <div style="position:absolute; left: 481px; top: 70px; width: 276px; height: 120px;"> 
            <table border="0" cellpadding="0" cellspacing="0" width="245">
              <!-- fwtable fwsrc="condoro.png" fwbase="ingreso.gif" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="0" -->
              <tr> 
                <td><img src="../principal/imagenes/ingreso/spacer.gif" alt="" name="undefined_2" width="68" height="1" border="0"></td>
                <td><img src="../principal/imagenes/ingreso/spacer.gif" alt="" name="undefined_2" width="27" height="1" border="0"></td>
                <td><img src="../principal/imagenes/ingreso/spacer.gif" alt="" name="undefined_2" width="72" height="1" border="0"></td>
                <td><img src="../principal/imagenes/ingreso/spacer.gif" alt="" name="undefined_2" width="61" height="1" border="0"></td>
                <td><img src="../principal/imagenes/ingreso/spacer.gif" alt="" name="undefined_2" width="17" height="1" border="0"></td>
                <td><img src="../principal/imagenes/ingreso/spacer.gif" alt="" name="undefined_2" width="1" height="1" border="0"></td>
              </tr>
              <tr> 
                <td colspan="5"><img name="ingreso_r1_c1" src="../principal/imagenes/ingreso/ingreso_r1_c1.gif" width="245" height="34" border="0" alt=""></td>
                <td><img src="../principal/imagenes/ingreso/spacer.gif" alt="" name="undefined_2" width="1" height="34" border="0"></td>
              </tr>
              <tr> 
                <td rowspan="2" colspan="2"><img name="ingreso_r2_c1" src="../principal/imagenes/ingreso/ingreso_r2_c1.gif" width="95" height="70" border="0" alt=""></td>
                <td colspan="2" align="center" valign="middle" background="../principal/imagenes/ingreso/ingreso_r2_c3.gif"><input name="Rut" type="text" onFocus="foco='txtpassword';" size="15" maxlength="15"> 
                  <br> <br> <input name="Pass" type="password" onFocus="foco='btnEntrar';" size="15" maxlength="15"> 
                </td>
                <td rowspan="4"><img name="ingreso_r2_c5" src="../principal/imagenes/ingreso/ingreso_r2_c5.gif" width="17" height="115" border="0" alt=""></td>
                <td><img src="../principal/imagenes/ingreso/spacer.gif" alt="" name="undefined_2" width="1" height="58" border="0"></td>
              </tr>
              <tr> 
                <td colspan="2"><img name="ingreso_r3_c3" src="../principal/imagenes/ingreso/ingreso_r3_c3.gif" width="133" height="12" border="0" alt=""></td>
                <td><img src="../principal/imagenes/ingreso/spacer.gif" alt="" name="undefined_2" width="1" height="12" border="0"></td>
              </tr>
              <tr> 
                <td rowspan="2"><img name="ingreso_r4_c1" src="../principal/imagenes/ingreso/ingreso_r4_c1.gif" width="68" height="45" border="0" alt=""></td>
                <td colspan="2"><a href="JavaScript:Entrar('E');" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('ingreso_r4_c2','','../principal/imagenes/ingreso/ingreso_r4_c2_f2.gif',1);"><img name="ingreso_r4_c2" src="../principal/imagenes/ingreso/ingreso_r4_c2.gif" width="99" height="21" border="0" alt=""></a></td>
                <td rowspan="2"><img name="ingreso_r4_c4" src="../principal/imagenes/ingreso/ingreso_r4_c4.gif" width="61" height="45" border="0" alt=""></td>
                <td><img src="../principal/imagenes/ingreso/spacer.gif" alt="" name="undefined_2" width="1" height="21" border="0"></td>
              </tr>
              <tr> 
                <td colspan="2"><img name="ingreso_r5_c2" src="../principal/imagenes/ingreso/ingreso_r5_c2.gif" width="99" height="24" border="0" alt=""></td>
                <td><img src="../principal/imagenes/ingreso/spacer.gif" alt="" name="undefined_2" width="1" height="24" border="0"></td>
              </tr>
            </table>
          </div></td>
    </tr>
  </table>
  </div>
  <div style="position:absolute; left: 5px; top: 405px;">
  <TABLE width="770" height="23" border=0 cellPadding=3 cellSpacing=0>
    <TBODY>
      <TR> 
          <TH width="770" height="25" valign="bottom" noWrap background="../principal/imagenes/fondoabajo_b.jpg"><table width="695" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="76">&nbsp;</td>
                <td width="10" valign="top"><img src="../principal/imagenes/bola_cobre.gif" width="18" height="18"></td>
                <td width="143"><font color="#000099"><a href="mailto:pfarias@enami.cl" style="text-decoration:none; color:#000099; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">Contacto</a></font></td>
                <td width="10"><img src="../principal/imagenes/bola_cobre.gif" width="18" height="18"></td>
                <td width="143"><font color="#000099"><a href="http://200.1.1.200" style="text-decoration:none; color:#000099; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">Santiago</a></font></td>
                <td width="12"><img src="../principal/imagenes/bola_cobre.gif" width="18" height="18"></td>
                <td width="141"><font color="#000099"><a href="http://200.1.6.90" style="text-decoration:none; color:#000099; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">Intranet</a></font></td>
                <td width="10"><img src="../principal/imagenes/bola_cobre.gif" width="18" height="18"></td>
                <td width="150"><font color="#000099"><a href="index.php" style="text-decoration:none; color:#000099; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">Inicio</a></font></td>
              </tr>
            </table></TH>
      </TR>
    </TBODY>
  </TABLE>
  </div>
</form>
</body>
</html>
