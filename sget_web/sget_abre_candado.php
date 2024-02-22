<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
	$Rut=$CookieRut;
	$Consulta="SELECT * from proyecto_modernizacion.funcionarios t1 ";
	$Consulta.=" where t1.rut='".$Rut."' ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$Nombre=$Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"];
	}
?>
<html>
<head>
<title>Ingreso Password</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opcion)
{
	var f= document.FrmCambioPass;
	switch(Opcion)
	{
		case "A":
			f.action = "sget_abre_candado01.php?Proceso=A";
			f.submit();
		break;	
	}
}
function ValidaForm()
{
	var teclaCodigo = event.keyCode; 
	if (teclaCodigo == 13)
		ValLogin();
}
function ValLogin()
{
	var f= document.FrmCambioPass;
	if (f.TxtPassActual.value=="")
	{
		alert("Debe Ingresar Contrase�a Actual");
		f.TxtPassActual.focus();
		return;
	}
	else
		Proceso('A');
	
}

function Salir()
{
	window.close();
}

</script>
</head>

<form name="FrmCambioPass" method="post" action="">
<input type="hidden" name="NumHoja" value="<? echo $NumHoja; ?>"> 
<input type="hidden" name="Est" value="<? echo $Est; ?>"> 
<input type="hidden" name="CmbEmpresa" value="<? echo $CmbEmpresa; ?>">
<input type="hidden" name="CmbContrato" value="<? echo $CmbContrato; ?>" />
<input type="hidden" name="CmbAno" value="<? echo $CmbAno; ?>"> 
<input type="hidden" name="TxtHoja" value="<? echo $TxtHoja; ?>"> 
<input type="hidden" name="CmbEstado" value="<? echo $CmbEstado; ?>"> 
<input type="hidden" name="NomPag" value="<? echo $NomPag; ?>"> 
	
	 
  <table width="100%" align="center"  border="0" cellpadding="0" bgcolor="#FFFBFB" cellspacing="0" >
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>  
       <table width="100%" border="0" cellpadding="3" cellspacing="0"   >
  
	 <tr align="right">
            <td colspan="3" ><a href="JavaScript:ValLogin()"><img src="archivos/btn_guardar.png" align="absmiddle"  alt="Aceptar" border="0"></a> &nbsp;<a href="JavaScript:Salir()"><img src="archivos/close.png" height="25" width="25" alt="Cerrar" border="0" align="absmiddle" /></a> </td>
          </tr>
    </table>
  
  <table width="100%" border="0" cellpadding="3" cellspacing="0" >
          
		  <tr>
            <td colspan="2" class="TituloTablaVerde"> Abre Candado</td>
          </tr>
<?
$Est="N";  
	if (isset($Error))
	{
		switch ($Error)
		{
			case "0":
				$Mensaje="Operaci�n Realizada con Exito";
				break;
			case "1":
				$Mensaje="Error!!!...Ud No tiene permiso para realizar esta operaci�n ";
				break;
			case "2":
				$Mensaje="Error!!!...Contrase�a Invalida";
				break;
		}
?>		  
          <tr align="center">
            <td colspan="2" class="formulario2"  ><span class="titulo_rojo_tabla"><? echo $Mensaje; ?></span></td>			
          </tr>
<?
	}
?>		  
          <tr>
            <td class="formulario2" >Usuario</td>
            <td class="formulario2"  ><? echo $Nombre;?>
            <input type="hidden" name="TxtNombre" value="<? echo $Nombre; ?>">              &nbsp;</td>
          </tr>
          <tr> 
            <td width="68" class="formulario2"  >Contrase&ntilde;a </td>
            <td class="formulario2" ><input name="TxtPassActual" type="password"  id="TxtPassActual" size="20" maxlength="50" onkeydown="ValidaForm()" <? if(($numh=='4')||($numh=='5')) 
		  {
?>onblur="Obs.focus();" <? }?> /></td>
          </tr>
        </table>
    </td>
   <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>
  <input name="ContObs" type="hidden" value='<? echo $Est;?>'>  
</form>
</body>
</html>