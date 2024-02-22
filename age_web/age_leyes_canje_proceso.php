<?php 	
	include("../principal/conectar_principal.php");
	$NomBtnGrabar='Grabar';
	$Proceso='N';
	if ($Recarga=='S')
	{
		//$EstadoRutPrv='readonly';
		$TxtLeyes='';
		$Consulta ="select * from age_web.leyes_canje where cod_producto='1' and cod_subproducto='".$CmbSubProducto."'";
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			$TxtLeyes=$TxtLeyes.$Fila["cod_ley"].", ";
			$TxtCodLeyes=$TxtCodLeyes.$Fila["cod_ley"]."~";
			$Proceso='M';
			$NomBtnGrabar='Modificar';
		}
		$TxtLeyes=substr($TxtLeyes,0,strlen($TxtLeyes)-2);
		$TxtCodLeyes=substr($TxtCodLeyes,0,strlen($TxtCodLeyes)-1);
	}
?>
<html>
<head>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Grabar(Proceso)
{
	var Frm=document.FrmProceso;
	
	if (Proceso=='N')
	{
		if (Frm.CmbSubProducto.value == "-1")
		{
			alert("Debe Seleccionar SubProducto")
			Frm.CmbSubProducto.focus();
			return;
		}
	}
	if (Frm.TxtLeyes.value == "")
	{
		alert("Debe Ingresar Leyes");
		Frm.BtnLeyes.focus();
		return;
	}
	Frm.action="age_leyes_canje_proceso01.php?Proceso="+Proceso;
	Frm.submit();
}
function Leyes()
{
	URL="age_con_multiple_lotes_leyes.php?Pag=LeyesCanje";
	window.open(URL,"","top=30,left=30,width=600,height=500,scrollbars=yes,resizable=yes");
}
function Eliminar(Proceso)
{
	var Frm=document.FrmProceso;
	
	if (Frm.CmbSubProducto.value!='-1')
	{
		Frm.action="age_leyes_canje_proceso01.php?Proceso="+Proceso;
		Frm.submit();
	}	
}

function Recarga(Tipo)
{
	var Frm=document.FrmProceso;
	
	switch(Tipo)
	{
		case '1':
			Frm.action="age_leyes_canje_proceso.php?Recarga=S";	
			break;
		case '2':
			Frm.action="age_leyes_canje_proceso.php";	
			break;
	}
	Frm.submit();
}

function Salir()
{
	window.close();
	
}
</script>
<title>Mantenedor Leyes Canje</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<?php
	echo "<body onload='document.FrmProceso.CmbSubProducto.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmProceso" method="post" action="">
  <table width="546" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554"><table width="535" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr>
            <td class="Colum01">SubProducto</td>
            <td>
              <select name="CmbSubProducto" class="Select01" onChange="Recarga('1');">
                <option value="-1">SELECCIONAR</option>
                <?php
				$Consulta = "select cod_subproducto, descripcion, abreviatura, LPAD(cod_subproducto,2,'0') as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' order by orden";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo  "<option selected value='".$Fila["cod_subproducto"]."'>".$Fila["orden"]." - ".$Fila["abreviatura"]."</option>\n";
					else
						echo  "<option value='".$Fila["cod_subproducto"]."'>".$Fila["orden"]." - ".$Fila["abreviatura"]."</option>\n";
				}
				?>
              </select>
            </td>
          </tr>
          <tr> 
            <td class="Colum01">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td width="91" height="22" class="Colum01">Leyes</td>
            <td width="415">
			<input name="TxtLeyes" type="text" value="<?php echo $TxtLeyes;?>" <?php echo $EstadoRutPrv?> class="InputCen" readonly=true>
			<input name="TxtCodLeyes" type="hidden" value="<?php echo $TxtCodLeyes;?>">
			<input type="button" name="BtnLeyes" value='Leyes' onClick="Leyes()">
			</td>
			
          </tr>
          <tr> 
            <td height="22" class="Colum01">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509">
			  <input type="button" name="BtnGrabar" value="<?php echo $NomBtnGrabar;?>" style="width:60" onClick="Grabar('<?php echo $Proceso;?>')">
              <input type="button" name="BtnCancelar" value="Cancelar" style="width:60" onClick="Recarga('2');">
			  <input type="button" name="BtnEliminar" value="Eliminar" style="width:60" onClick="Eliminar('E');">
			  <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
            </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
<?php
	if (isset($EncontroCoincidencia))
	{
		if ($EncontroCoincidencia==true)
		{
			echo "<script languaje='javascript'>";
			echo "var Frm=document.FrmProceso;";
			echo "alert('Codigo ya fue Ingresado');";
			echo "Frm.TxtCodigo.focus();";
			echo "</script>";
		}
	}
?>
