<HTML>
<HEAD>
<TITLE>CODELCO</TITLE>
<link href="estilos/style.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript src="archivos/general.js"></SCRIPT>
<SCRIPT language=JavaScript>
<!--
//------====== VARIABLES ======------
var k;
//------====== FUNCIONES ======------

function limpiaRutes(){
document.ejecutar.prsn_id.value="";
document.ejecutar.prsn_id_temp.value = '';
}
function login()
{
if ((!rut(document.ejecutar.prsn_id.value.substring(0,document.ejecutar.prsn_id.value.length - 1),document.ejecutar.prsn_id.value.substring(document.ejecutar.prsn_id.value.length - 1,document.ejecutar.prsn_id.value.length)))||(trim(document.ejecutar.prsn_id_temp.value)==""))
{
document.ejecutar.prsn_id_temp.value="";
document.ejecutar.prsn_id.value="";
document.ejecutar.accs_pin.value="";
document.ejecutar.prsn_id_temp.focus();
alert('Rut No válido');
return;
}
if (document.ejecutar.accs_pin.value.length < 4)
{
alert('Clave no cumple con largo Mínimo');
document.ejecutar.accs_pin.value="";
document.ejecutar.accs_pin.focus();
return;
}
str="";
for (i=document.ejecutar.prsn_id.value.length;i<10;i++)
{
str=str + '0';
}
document.ejecutar.prsn_id.value= str + document.ejecutar.prsn_id.value;
document.ejecutar.action="inter_menu.php";
document.ejecutar.submit();
}

function disableEnterKey()
{
 if (window.event.keyCode == 13) login();
}
function BorrarFormulario(){
document.ejecutar.prsn_id_temp.value='';
document.ejecutar.accs_pin.value='';
}
//-->
</SCRIPT>
<BODY class=body_inicio onkeypress=disableEnterKey() leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<table width="767" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="49%"><img src="archivos/logo_sup.jpeg" width="159" height="52"></td>
<td width="10%" background="archivos/bg_sup.gif"><img src="archivos/mitad.jpg" width="148" height="52"></td>
<td width="35%" background="archivos/bg_sup.gif">
<div align="right" class="titulo_cafe">Mesa de Ayuda - Horario 08:00 hrs a 17:00 hrs
<span class="titulo_cafe"> </span><span class="nTelefono"><br>
032-933399</span></div></td>
<td width="6%" background="archivos/bg_sup.gif">
<div align="right"><img src="archivos/telefono.gif" width="29" height="31"><img src="archivos/1pixel.gif" width="7" height="8"></div></td>
</tr>

<tr>
<td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="100%" height="22" background="archivos/alto_cobre.gif">
&nbsp;&nbsp;</td>
</tr>
</table></td>
</tr>
</table>
<TABLE cellSpacing=0 cellPadding=0 width="73%" border=0>
  <TBODY>
  <TR>
    <TD>      <table cellspacing=0 cellpadding=0 width=767 border=0>
      <tbody>
        <tr>
          <td valign=top>&nbsp;</td>
          <td valign=top>&nbsp;</td>
        </tr>
        <tr>
          <td valign=top>&nbsp;</td>
          <td valign=top>&nbsp;</td>
        </tr>
        <tr>
          <td valign=top width=180 height=261>
            <p>&nbsp;</p></td>
          <td valign=top align=middle width=629><!--------======== CUERPO =========-------->
              <!-- aqui comienza la tabla de informacion principal-->
              <form name="ejecutar" action="" method="post">
                <input type=hidden name=prsn_id>
                <table cellspacing=0 cellpadding=0 width="92%" align=center 
border=0>
                  <tbody>
                    <tr>
                      <td class=titulo_cafe_bold_grande>Integraci&oacute;n SAP - Divisi&oacute;n Ventanas </td>
                    </tr>
                    <tr>
                      <td bgcolor=#b26c4a><img height=1 
                  src="archivos/1pixel.gif" width=1></td>
                    </tr>
                    <tr>
                      <td class=titulo_cafe_bold_grande>Ingreso</td>
                    </tr>
                    <tr>
                      <td class=pie_bold height=50>
                        <table cellspacing=0 cellpadding=0 width="100%" border=0>
                          <tbody>
                            <tr>
                              <td class=pie_bold>&nbsp;</td>
                            </tr>
                          </tbody>
                      </table></td>
                    </tr>
                    <tr>
                      <td valign=top height=147>
                        <table cellspacing=0 cellpadding=3 width="100%" align=center 
                  border=0>
                          <tbody>
                            <tr>
                              <td class=pie_bold width="12%" height=143>
                                <div align=center></div>
                                <div align=center></div></td>
                              <td class=pie_bold width="78%">
                                <table cellspacing=1 cellpadding=1 width="100%" 
                        bgcolor=#cccccc border=0>
                                  <tbody>
                                    <tr>
                                      <td valign=center align=middle bgcolor=#ffffff 
                            height=90><br>
                                          <table cellspacing=5 cellpadding=0 width="98%" 
                              align=center border=0>
                                            <tbody>
                                              <tr>
                                                <td class=pie_bold 
                                width="32%">&nbsp;&nbsp;R.U.T. de Usuario</td>
                                                <td width="5%">
                                                  <div align=center>
                                                    <p class=pie_bold>&nbsp;</p>
                                                </div></td>
                                                <td width="40%">
						<input  name="prsn_id_temp" class="style_form" id="TxtRut"  onFocus="formatear2(this.form);" onBlur="formatear(this.form);" onKeyPress="return solorut();" value="<?php echo $TxtRut; ?>" size="25"></td>
<script languaje="javaScript">
<!--
document.ejecutar.prsn_id_temp.focus();
//-->
</script>
                                                <td class=pie_bold width="25%" 
                                rowspan=2>&nbsp;</td>
                                              </tr>
                                              <tr>
                                                <td class=pie_bold>&nbsp;&nbsp;Contraseña</td>
                                                <td>
                                                  <div class=pie_bold align=center>&nbsp;</div></td>
                                                <td><input  name="accs_pin"  type="password" class="style_form" id="TxtPassword"  onKeyPress="ValidaCaracter('Alfanumerico','')" size=25 maxlength=6></td>
                                              </tr>
                                              <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td colspan=3 height=30><a 
                                href="javascript:login();"><img src="archivos/ingresar.gif" border=0>
                               </a>&nbsp;&nbsp;<a href="javascript:BorrarFormulario();"><img src="archivos/borrar_login.gif" border=0></a></td>
                                              </tr>
                                              <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td><a href=""><img src="archivos/flecha_cafe.gif" border=0>&nbsp;Olvidó su clave</a></td>
                                                <td class=pie_bold width="25%" rowspan=2>&nbsp;</td>
                                              </tr>
                                              <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td><a href=""><img src="archivos/flecha_cafe.gif" border=0>&nbsp;Cambio de clave</a></td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <span 
                              class=titulo_cafe_bold></span></td>
                                    </tr>
                                  </tbody>
                              </table></td>
                              <td class=pie_bold width="10%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td class=subportada colspan=3 height=2>
                                <div align=left><span class=Estilo4><img height=5 src="archivos/1pixel.gif" width=10></span></div></td>
                            </tr>
                          </tbody>
                      </table></td>
                    </tr>
                  </tbody>
                </table>
                <!-- aqui termina la tabla de informacion principal -->
                <!--------======== FIN CUERPO =========---->
            </form></td>
        </tr>
      </tbody>
    </table></TD>
  </TR></TBODY></TABLE><!-- Tiempo : -.302000000003318 --></FORM>
</BODY></HTML>
