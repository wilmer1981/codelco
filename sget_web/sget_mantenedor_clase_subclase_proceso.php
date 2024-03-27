
<? include("../principal/conectar_sget_web.php");


if ($Opc=='M')
{
	$Consulta="SELECT * from sget_subclase t1 ";
	$Consulta.=" where t1.cod_clase='".$Valores."' ";
	
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigoClase=$Fila["cod_clase"];
		$TxtDescripcionSubClase=$Fila["descripcion"];
		$ReqSubClase='S';
	}
	else
		echo "elseeeeeeeeeeeeeee";
}

echo 'valor ^===========>'. $ReqSubClase;
?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nuevo Documento</title>";
		else	
			echo "<title>Modifica Documento</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="funciones/sgp_funciones.js"></script>
<script language="JavaScript">


function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	var Valida=true;
	var Veri="";
	var Check="";
	switch(Opcion)
	{
		case "N":
			Veri=ValidaCampos(Valida,Opcion);
			if (Veri==true)
			{
				
				f.action = "sget_mantenedor_clase_subclase01.php?Opcion="+ Opcion+"&Codigo="+f.TxtCodigo.value+"&Descri="+f.TxtDescripcion.value;
/*+"&Pagina="+f.Pagina.value;*/
				f.submit();
			}
		break;
		case "M":
			f.action = "sget_mantenedor_clase_subclase01.php?Opcion="+ Opcion+"&Codigo="+f.TxtCodigo.value+"&Descri="+f.TxtDescripcion.value;
/*+"&Pagina="+f.Pagina.value;*/
			f.submit();
		break;
	}
}
function Salir()
{
	window.close();
}
function ValidaCampos(Res,Opcion)
{
	var f= document.FrmPopupProceso;
	if (f.TxtDescripcion.value=="")
	{
		alert("Debe Ingresar Descripcion");
		f.TxtDescripcion.focus();
		Res=false;
		return;
	}
	return(Res);
}

</script>
</head>
<?
if ($Opc=='N')
	echo '<body onLoad="document.FrmPopupProceso.TxtDescripcion.focus();">';
	else
		echo '<body onLoad="document.FrmPopupProceso.TxtDescripcion.focus();">';
?>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
  <table width="70%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1.gif" width="17" height="15"></td>
	<td width="1" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
   <table width="100%">
     <tr  align="right">
            <td ><a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a></td>
          </tr>
   </table>
<table width="100%" border="0" cellpadding="3" cellspacing="0" >
          <tr>
            <td colspan="2" class="TituloTablaNaranja">Mantenedor de Datos 
              <?
			 		echo '<input name="TxtCodigo" type="hidden"     value="'.$TxtCodigo.'" >';
			 	?>         </td>
          </tr>
          <tr> 
            <td width="254" class="formulario">Clase</td>
			
            <td width="540" >
            <input name="TxtDescripcion" maxlength= "30" type="text" id="TxtDescripcion" style="width:350" value="<? echo $TxtDescripcion; ?>" >          </td>
          </tr>
          <tr>
            <td width="254" class="formulario">Requiere SubClase </td>
            <td ><?
				if($ReqSubClase == "S")
				{
				?>
SI
  <input name="radioAdm" type="radio" class="SinBorde" value="radiobutton" checked>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                NO
                <input name="radioAdm" type="radio" class="SinBorde" value="radiobutton">
                <?
				}
				else
				{
				?>
SI
<input name="radioAdm" type="radio" class="SinBorde" value="radiobutton">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                NO
                <input name="radioAdm" type="radio" class="SinBorde" value="radiobutton" checked>
            <?
				}
				?></td>
          </tr>
        </table>
	  </td>

  <td width="1" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="18" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>			
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje==true)
		echo "alert('Este Registro ya Existe');";
	echo "</script>";
?>