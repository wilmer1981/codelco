<?php 	
	//include("../principal/conectar_comet_web.php");
	include("conectar_principal.php");

	if(isset($_GET["Proceso"])){
		$Proceso = $_GET["Proceso"];
	}else{
		$Proceso = "";
	}

	if(isset($_GET["Valores"])){
		$Valores = $_GET["Valores"];
	}else{
		$Valores = "";
	}

	if(isset($_GET["CmbSistema2"])){
		$CmbSistema2 = $_GET["CmbSistema2"];
	}else{
		$CmbSistema2 = "";
	} 
	
	

/*
	if(isset($_GET["Proceso"])=="NC"){
		$CmbSistema2 = $_POST["CmbSistema2"];
	}else{
		$CmbSistema2 = "";
	}*/

	//ingreso_clase_subclase_proceso.php?Proceso=MC&Valores=34001&CmbSistema2=34




	if(isset($_POST["TxtDescripcion"])){
		$TxtDescripcion = $_POST["TxtDescripcion"];
	}else{
		$TxtDescripcion = "";
	}
	if(isset($_POST["TxtValor1"])){
		$TxtValor1 = $_POST["TxtValor1"];
	}else{
		$TxtValor1 = "";
	}
	if(isset($_POST["TxtValor2"])){
		$TxtValor2 = $_POST["TxtValor2"];
	}else{
		$TxtValor2 = "";
	}

	
	switch($Proceso)
	{
		case "NC":
			$CodigoIni = 1000*intval($CmbSistema2);
			$CodigoFin = $CodigoIni+999;
			$Consulta  = "SELECT ifnull(max(cod_clase)+1,'".$CodigoIni."' ) as codigo FROM proyecto_modernizacion.clase WHERE cod_clase between '".$CodigoIni."' and '".$CodigoFin."' ";
			$Respuesta = mysqli_query($link, $Consulta);
			$Fila      = mysqli_fetch_array($Respuesta);
			$TxtCodigo = $Fila["codigo"];
			break;
		case "MC":
			$Datos     = explode('//',$Valores);
			$TxtCodigo = $Datos[0];
			$Consulta  = "SELECT * FROM proyecto_modernizacion.clase WHERE cod_clase='".$TxtCodigo."' ";
			$Respuesta = mysqli_query($link, $Consulta);
			$Fila      = mysqli_fetch_array($Respuesta);
			$TxtCodigo      = $Fila["cod_clase"];
			$TxtDescripcion = $Fila["nombre_clase"];
			$TxtValor1 = $Fila["valor1"];
			$TxtValor2 = $Fila["valor2"];
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
alert("Cdigo de la tecla: " + teclaCodigo + "\nTecla pulsada: " + teclaReal); 
}*/ 


function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Frm.CmbSistema2.value == "-1")
	{
		alert("Debe Seleccionar Sistema");
		Frm.CmbSistema2.focus();
		return;
	}
	if (Proceso=='NC')
	{
		if (Frm.TxtCodigo.value == "")
		{
			alert("Debe Ingresar Codigo")
			Frm.TxtCodigo.focus();
			return;
		}
	}
	//Frm.action="ingreso_clase_subclase_proceso01.php?Proceso="+Proceso+"&TxtCodigo="+Frm.TxtCodigo.value+"&Valores="+Valores;
	Frm.action="ingreso_clase_subclase_proceso01.php?Proceso="+Proceso+"&TxtCodigo="+Frm.TxtCodigo.value+"&Valores="+Valores+"&CmbSistema2="+Frm.CmbSistema2.value;
	Frm.submit();
}
function Recarga(Proceso)
{
	var Frm=document.FrmProceso;
	
	Frm.action="ingreso_clase_subclase_proceso.php?Proceso="+Proceso;
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
	echo "<body onload='document.FrmProceso.TxtDescripcion.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>

<form name="FrmProceso" method="post" action="">
  <table width="546" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554"><table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="56">Sistema</td>
            <td width="450">
			<?php
				echo "<select name='CmbSistema2' style='width:250' onchange=Recarga('$Proceso')>";
				echo "<option value='-1'>SELECCIONAR</option>";
				$Consulta="select * from proyecto_modernizacion.sistemas order by cod_sistema";
				$Resultado=mysqli_query($link, $Consulta);

				while ($Fila=mysqli_fetch_array($Resultado))
				{
					if ($CmbSistema2==$Fila["cod_sistema"])
					{
						echo "<option value='".$Fila["cod_sistema"]."' selected>".strtoupper($Fila["descripcion"])."</option>";
					}
					else
					{
						echo "<option value='".$Fila["cod_sistema"]."'>".strtoupper($Fila["descripcion"])."</option>";
					}	
				}
				echo "</select>";
			?>
			</td>
			</tr>
			<tr>
			<td width="56">Codigo</td>
			<td width="450"> 
              <?php
				if ($CmbSistema2=='-1')
					echo "<input type='text' name='TxtCodigo' style='width:70' maxlength='9' value='' readonly>";
				else
				{	
					echo "<input type='text' name='TxtCodigo' style='width:70' maxlength='9' value='$TxtCodigo' >";	
				}	
  			  ?>
            </td>
          </tr>
          <tr> 
            <td>Nombre</td>
            <td>
			<input  type="text" name="TxtDescripcion" value="<?php echo $TxtDescripcion;?>" style="width:400"> 
            </td>
          </tr>
          <tr> 
            <td>Valor1</td>
            <td><input  type="text" name="TxtValor1" value="<?php echo $TxtValor1;?>" style="width:100"></td>
          </tr>
          <tr>
            <td>Valor2</td>
            <td><input  type="text" name="TxtValor2" value="<?php echo $TxtValor2;?>" style="width:100"></td>
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
