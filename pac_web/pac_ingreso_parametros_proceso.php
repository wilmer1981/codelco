<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla =4;
	include("../principal/conectar_pac_web.php");

	$EncontroCoincidencia = isset($_REQUEST["EncontroCoincidencia"])?$_REQUEST["EncontroCoincidencia"]:"";
	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$Codigo   = isset($_REQUEST["TxtCodigo"])?$_REQUEST["TxtCodigo"]:"";
	$Nombre   = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$Val1     = isset($_REQUEST["TxtValor1"])?$_REQUEST["TxtValor1"]:"";
	$Val2     = isset($_REQUEST["TxtValor2"])?$_REQUEST["TxtValor2"]:"";


	switch($Proceso)
	{
		case "N":
			break;
		case "M":
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$Codigo=substr($Datos,0,$i);
				}
			}
			$Consulta = "select * from pac_web.parametros where codigo=".$Codigo;
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Nombre=$Fila["nombre"];
			$Val1=$Fila["valor1"];
			$Val2=$Fila["valor2"];
			break;	
	}	
?>
<html>
<head>
<script language="JavaScript">
/*document.onkeydown = TeclaPulsada; 

function TeclaPulsada (tecla) 
{ 
var teclaCodigo = event.keyCode; 
var teclaReal = String.fromCharCode(teclaCodigo); 
alert("C�digo de la tecla: " + teclaCodigo + "\nTecla pulsada: " + teclaReal); 
}*/ 


function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Proceso=='N')
	{
		if (Frm.TxtCodigo.value == "")
		{
			alert("Debe Ingresar Codigo")
			Frm.TxtCodigo.focus();
			return;
		}
	}	
	if (Frm.TxtNombre.value == "")
	{
		alert("Debe Ingresar Nombre")
		Frm.TxtNombre.focus();
		return;
	}
	if (Frm.TxtValor1.value == "")
	{
		alert("Debe Ingresar Valor1")
		Frm.TxtValor1.focus();
		return;
	}
	Frm.action="pac_ingreso_parametros_proceso01.php?Proceso="+Proceso+"&TxtCodigo="+Frm.TxtCodigo.value+"&Valores="+Valores;
	Frm.submit();
	
}
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	if ($Proceso=='N')
	{
		echo "<body onload='document.FrmProceso.TxtCodigo.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
	else
	{
		echo "<body onload='document.FrmProceso.TxtNombre.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
?>

<form name="FrmProceso" method="post" action="">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td>Codigo</td>
            <td> 
              <?php
					if ($Proceso=='M')
					{
						echo "<input type='text' name='TxtCodigo' style='width:70' maxlength='9' value='$Codigo' disabled>";
					}
					else
					{
						echo "<input type='text' name='TxtCodigo' style='width:70' maxlength='9' value='$Codigo'>";
					}	
				?>
            </td>
          </tr>
          <tr> 
            <td>Nombre</td>
            <td><input type="text" name="TxtNombre" style="width:250" maxlength="80" value="<?php echo $Nombre;?>"></td>
          </tr>
          <tr> 
            <td>Valor1</td>
            <td><input type="text" name="TxtValor1" style="width:250" maxlength="255" value="<?php echo $Val1;?>"></td>
          </tr>
          <tr> 
            <td>Valor2</td>
            <td><input type="text" name="TxtValor2" style="width:250" maxlength="255" value="<?php echo $Val2;?>"></td>
          </tr>
        </table>
        <br>
        <table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
<?php
	if ($EncontroCoincidencia)
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
