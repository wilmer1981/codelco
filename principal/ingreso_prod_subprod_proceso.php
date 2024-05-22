<?php 	
	//include("../principal/conectar_comet_web.php");
	include("conectar_principal.php");

	$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";

	if($Proceso=='MC'){
		//$TxtDescripcion = $_POST["TxtDescripcion"];
		//$TxtValor1 = $_POST["TxtValor1"];
		//$TxtValor2 = $_POST["TxtValor2"];
		//$TxtValor3 = $_POST["TxtValor3"];
		$Valores   = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";	
	}else{
		$TxtDescripcion = '';
		$TxtValor1 = '';
		$TxtValor2 = '';
		$TxtValor3 = '';
		$Valores = '';
	}
	
	switch($Proceso)
	{
		case "NC":
			$Consulta="select (max(cod_producto)+1) as codigo from proyecto_modernizacion.productos";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtCodigo=$Fila["codigo"];
			break;
		case "MC":
			$Datos=explode('//',$Valores);
			$TxtCodigo=$Datos[0];
			$Consulta="select * from proyecto_modernizacion.productos where cod_producto=".$TxtCodigo;
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TextCodigo=$Fila["cod_producto"];
			$TxtDescripcion=$Fila["descripcion"];
			$TxtValor1=$Fila["Mostrar"];
			$TxtValor2=$Fila["abreviatura"];
			$TxtValor3=$Fila["balance_sec"];
			break;
	}
?>
<html>
<head>
<script language="javascript">
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	if (Proceso=='NC')
	{
		if (Frm.TxtCodigo.value == "")
		{
			alert("Debe Ingresar Codigo")
			Frm.TxtCodigo.focus();
			return;
		}
	}
	Frm.action="ingreso_prod_subprod_proceso01.php?&Proceso="+Proceso+"&TxtCodigo="+Frm.TxtCodigo.value+"&Valores="+Valores;
	Frm.submit(); 	
}

function Salir()
{
	window.close();
}

</script>
<title>ingresa</title>  
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	echo "<body onload='document.FrmProceso.TxtDescripcion.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>
<form name="FrmProceso" method="post" action="">
  <table width="546" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554"><table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr>
			<td width="56">Codigo</td>
			<td width="450"> 
              <?php
				echo "<input type='text' name='TxtCodigo' style='width:70' maxlength='9' value='$TxtCodigo' >";	
			 ?>
            </td>
          </tr>
          <tr> 
            <td>Descripcion</td>
            <td>
			<input  type="text" name="TxtDescripcion" value="<?php echo $TxtDescripcion;?>" style="width:400"> 
            </td>
          </tr>
		    <tr> 
            <td>Mostrar</td>
            <td><input  type="text" name="TxtValor1" maxlength='1' value="<?php echo $TxtValor1;?>" style="width:30"></td>
          </tr>
          <tr> 
            <td>Abreviatura</td>
            <td><input  type="text" name="TxtValor2" value="<?php echo $TxtValor2;?>" style="width:100"></td>
          </tr>
          <tr>
            <td>Balance</td>
            <td><input  type="text" name="TxtValor3" value="<?php echo $TxtValor3;?>" style="width:100"></td>
          </tr>
        </table>
        <br>
        <table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</head>
</html>