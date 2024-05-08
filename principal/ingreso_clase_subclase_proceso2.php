<?php 	
	//include("../principal/conectar_comet_web.php");
	include("../principal/conectar_principal.php");

	$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores     = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$cod_subclase = isset($_REQUEST["cod_subclase"])?$_REQUEST["cod_subclase"]:"";

	$Recarga     = isset($_REQUEST["Recarga"])?$_REQUEST["Recarga"]:"";

	$Datos=explode('//',$Valores);
	$TxtCodigo=$Datos[0];
	
	switch($Proceso)
	{
		case "NS":
			$Consulta = "SELECT ifnull(max(cod_subclase)+1,1) as mayor from proyecto_modernizacion.sub_clase where cod_clase='".$TxtCodigo."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtCodSubClase=$Fila["mayor"];
			$TxtNombre='';$TxtValor1='';$TxtValor2='';$TxtValor3='';$TxtValor4='';$TxtValor5='';$TxtValor6='';$TxtValor7='';
			break;
		case "MS":
			$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase='".$TxtCodigo."' and cod_subclase='".$cod_subclase."' ";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtCodSubClase=$cod_subclase;
			$TxtNombre=$Fila["nombre_subclase"];
			$TxtValor1=$Fila["valor_subclase1"];
			$TxtValor2=$Fila["valor_subclase2"];
			$TxtValor3=$Fila["valor_subclase3"];
			$TxtValor4=$Fila["valor_subclase4"];
			$TxtValor5=$Fila["valor_subclase5"];
			$TxtValor6=$Fila["valor_subclase6"];
			$TxtValor7=$Fila["valor_subclase7"];
			break;	
	}	
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtCodSubClase.value=='0'||Frm.TxtCodSubClase.value=='')
	{
		alert("Debe Ingresar Codigo Subclase")
		Frm.TxtCodSubClase.focus();
		return;
	}
	if (Frm.TxtNombre.value == "")
	{
		alert("Debe Ingresar Nombre Subclase")
		Frm.TxtNombre.focus();
		return;
	}
	Frm.action="ingreso_clase_subclase_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
	Frm.submit();
}
function Eliminar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (confirm("Esta seguro de Eliminar la Subclase"))
	{
		Frm.action="ingreso_clase_subclase_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
		Frm.submit();
	}
}

function Recarga(Proceso)
{
	var Frm=document.FrmProceso;
	
	Frm.action="ingreso_clase_subclase_proceso2.php?Recarga=S&Proceso="+Proceso;
	Frm.submit();
	
}
function Cancelar(Valores,Proceso)
{
	var Frm=document.FrmProceso;
	
	Frm.action="ingreso_clase_subclase_proceso2.php?Proceso="+Proceso+"&Valores="+Valores;
	Frm.submit();
	
}

function Consultar(Valores)
{
	window.open("ingreso_clase_subclase_popup.php?Valores="+Valores,"","top=120,left=120,width=550,height=350,scrollbars=yes,resizable = no");		
}
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	echo "<body onload='document.FrmProceso.TxtNombre.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>

<form name="FrmProceso" method="post" action="">
  <table width="547" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="56">Cod_Clase</td>
            <td width="450"> 
              <?php
				echo "<input type='text' name='TxtCodigo' size='10' maxlength='9' value='$TxtCodigo' readonly>";
  			  ?>
            </td>
          </tr>
          <tr> 
            <td>Cod_SubClase</td>
            <td><input name="TxtCodSubClase" type="text" value='<?php echo $TxtCodSubClase;?>' size="10" maxlength="5"> </td>
          </tr>
          <tr> 
            <td>Nombre</td>
            <td><input name="TxtNombre" type="text" value='<?php echo $TxtNombre;?>' size="80" maxlength="80"> </td>
          </tr>
          <tr> 
            <td>Valor1</td>
            <td><input name="TxtValor1" type="text" value='<?php echo $TxtValor1;?>' size="80" maxlength="50"> 
            </td>
          </tr>
		  </table><br>
		  <table width="535" border="1" cellpadding="1" cellspacing="0" class="TablaInterior">
          <tr> 
            <td align="center">Valor2</td>
            <td align="center"><input type="text" name="TxtValor2" style="width:90" maxlength="30" value="<?php echo $TxtValor2;?>"> 
            <td align="center">Valor3</td>
			<td align="center"><input type="text" name="TxtValor3" style="width:90" maxlength="30" value="<?php echo $TxtValor3;?>"> 
            </td>
          </tr>
          <tr> 
            <td align="center">Valor4</td>
            <td align="center"><input type="text" name="TxtValor4" style="width:90" maxlength="30" value="<?php echo $TxtValor4;?>"> 
			<td align="center">Valor5</td>
            <td align="center"><input type="text" name="TxtValor5" style="width:90" maxlength="30" value="<?php echo $TxtValor5;?>"> 
            </td>
          </tr>
          <tr> 
            <td align="center">Valor6</td>
            <td align="center"><input type="text" name="TxtValor6" style="width:90" maxlength="30" value="<?php echo $TxtValor6;?>"> 
			<td align="center">Valor7</td>
            <td align="center"><input type="text" name="TxtValor7" style="width:90" maxlength="30" value="<?php echo $TxtValor7;?>"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509">
			  <?php 
			  if ($Proceso=='MS')
			  {
			  ?>	
			  <input type="button" name="BtnGrabar" value="Modificar" style="width:70" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">
			  <?php 
			  }
			  else
			  {
			  ?>
			  <input type="button" name="BtnGrabar" value="Grabar" style="width:70" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">
			  <?php 
			  }
			  ?>
              <input type="button" name="BtnConsultar" value="Consultar" style="width:70" onClick="Consultar('<?php echo $Valores;?>')">
			  <input type="button" name="BtnEliminar" value="Eliminar" style="width:70" onClick="Eliminar('ES','<?php echo $Valores;?>')">
			  <input type="button" name="BtnCancelar" value="Cancelar" style="width:70" onClick="Cancelar('<?php echo $Valores;?>','NS')">
			  <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();">
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
