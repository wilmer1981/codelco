<?php 	
	//include("../principal/conectar_comet_web.php");
	include("../principal/conectar_principal.php");
	if(isset($_GET["Proceso"])){
		$Proceso = $_GET["Proceso"];
	}else{
		$Proceso = "";
	}
	
	if($Proceso=='M'){
		$Valores    = $_GET["Valores"];
		//$CmbCCosto2 = $_GET["CmbCCosto2"];
	}else{
		$CmbCCosto2 = "";
	}
	

	// $CmbCCosto2 = -1
	/*
	if(isset($_GET["CmbCCosto2"])){
		$CmbCCosto2 = $_GET["CmbCCosto2"];
	}else{
		$CmbCCosto2 = "";
	}*/



	//VARIABLES POST
	/*
	if(isset($_POST["TxtCodigo"])){
		$TxtCodigo = $_POST["TxtCodigo"];
	}else{
		$TxtCodigo = "";
	}*/
	
	if(isset($_POST["TxtNombres"])){
		$TxtNombres = $_POST["TxtNombres"];
	}else{
		$TxtNombres = "";
	}
	if(isset($_POST["TxtApePaterno"])){
		$TxtApePaterno = $_POST["TxtApePaterno"];
	}else{
		$TxtApePaterno = "";
	}
	if(isset($_POST["TxtApeMaterno"])){
		$TxtApeMaterno = $_POST["TxtApeMaterno"];
	}else{
		$TxtApeMaterno = "";
	}
	if(isset($_POST["TxtBloqueo"])){
		$TxtBloqueo = $_POST["TxtBloqueo"];
	}else{
		$TxtBloqueo= "";
	}
	if(isset($_POST["TxtCuentaCodelcoGDE"])){
		$TxtCuentaCodelcoGDE = $_POST["TxtCuentaCodelcoGDE"];
	}else{
		$TxtCuentaCodelcoGDE= "";
	}
	if(isset($_POST["TxtCuentaEnamiGDE"])){
		$TxtCuentaEnamiGDE = $_POST["TxtCuentaEnamiGDE"];
	}else{
		$TxtCuentaEnamiGDE= "";
	}

	if(isset($_POST["TxtCodigo"])){
		$TxtCodigo = $_POST["TxtCodigo"];
	}else{
		$TxtCodigo= "";
	}

	/////////////////////////////////////////////////////////////////
	

	switch($Proceso)
	{
		case "N":
			break;
		case "M":
			$Datos=explode('//',$Valores);
			$TxtCodigo=$Datos[0];
			$Consulta = "SELECT * FROM proyecto_modernizacion.funcionarios WHERE rut='".$TxtCodigo."'";
			$Respuesta= mysqli_query($link, $Consulta);
			$Fila     = mysqli_fetch_array($Respuesta);
			//echo "Respuesta:<br>";
			//var_dump($Fila);
			//$CmbCCosto2    =$Fila["cod_ceco"]; // no tiene valor		
			$CmbCCosto2    =$Fila["cod_centro_costo"];	//agregado por WSO	
		    //$CmbCCosto2    =str_replace('.','',$CmbCCosto2); // trae valor -1
			$TxtCodigo     =$Fila["rut"];
			$TxtNombres    =$Fila["nombres"];
			$TxtApePaterno =$Fila["apellido_paterno"];
			$TxtApeMaterno =$Fila["apellido_materno"];
			$TxtBloqueo    =$Fila["Bloqueo"];
			$TxtCuentaCodelcoGDE=$Fila["cuenta_red"];
			$TxtCuentaEnamiGDE=$Fila["cuenta_artikos"];
			
			break;	
	}	
	
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Frm.CmbCCosto2.value == "-1")
	{
		alert("Debe Seleccionar Centro de Costo");
		Frm.CmbCCosto2.focus();
		return;
	}
	if (Proceso=='N')
	{
		if (Frm.TxtCodigo.value == "")
		{
			alert("Debe Ingresar Rut")
			Frm.TxtCodigo.focus();
			return;
		}
	}
	//alert("Proceso="+Proceso+"&TxtCodigo="+Frm.TxtCodigo.value+"&CmbCCosto2="+Frm.CmbCCosto2.value);
	Frm.action="ingreso_funcionarios_proceso01.php?Proceso="+Proceso+"&TxtCodigo="+Frm.TxtCodigo.value+"&CmbCCosto2="+Frm.CmbCCosto2.value+"&Valores="+Valores;
	//Frm.action="ingreso_funcionarios_proceso01.php?Proceso="+Proceso+"&TxtCodigo="+Frm.TxtCodigo.value+"&CmbCCosto2="+Frm.CmbCCosto2.value;
	Frm.submit();
}
function Recarga(Proceso)
{
	var Frm=document.FrmProceso;
	
	Frm.action="ingreso_funcionarios_proceso.php?Proceso="+Proceso;
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
	echo "<body onload='document.FrmProceso.CmbCCosto2.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>

<form name="FrmProceso" method="post" action="">
  <table width="546" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554"><table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="76">C.Costo</td>
            <td colspan="6"> 
              <?php
				echo "<select name='CmbCCosto2' style='width:320'>";
				echo "<option value='-1'>SELECCIONAR</option>";
				$Consulta="SELECT * from proyecto_modernizacion.centro_costo order by CENTRO_COSTO";
				$Resultado=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Resultado))
				{
					if ($CmbCCosto2==$Fila["CENTRO_COSTO"])
					{
						echo "<option value='".$Fila["CENTRO_COSTO"]."' selected>".$Fila["CENTRO_COSTO"]."-".strtoupper($Fila["DESCRIPCION"])."</option>";
					}
					else
					{
						echo "<option value='".$Fila["CENTRO_COSTO"]."'>".$Fila["CENTRO_COSTO"]."-".strtoupper($Fila["DESCRIPCION"])."</option>";
					}	
				}
				echo "</select>";
			?>
            </td>
          </tr>
          <tr> 
            <td width="76">Rut</td>
            <td colspan="6"> 
              <?php
					echo "<input type='text' name='TxtCodigo' style='width:100' maxlength='13' value='".$TxtCodigo."' >";	
  			  ?>
            </td>
          </tr>
          <tr> 
            <td>Nombres</td>
            <td colspan="6"> <input  type="text" name="TxtNombres" value="<?php echo $TxtNombres;?>" style="width:400"> 
            </td>
          </tr>
          <tr> 
            <td>Apell. Paterno</td>
            <td colspan="6"><input  type="text" name="TxtApePaterno" value="<?php echo $TxtApePaterno;?>" style="width:200"></td>
          </tr>
          <tr> 
            <td>Apell. Materno</td>
            <td colspan="6"><input  type="text" name="TxtApeMaterno" value="<?php echo $TxtApeMaterno;?>" style="width:200"></td>
          <tr> 
            <td>Bloqueo</td>
            <td width="27"><input  type="text" name="TxtBloqueo" value="<?php echo $TxtBloqueo;?>" style="width:20"></td>
            <td width="58">Cuenta&nbsp;Red</td>
            <td width="83"><input  type="text" name="TxtCuentaCodelcoGDE" value="<?php echo $TxtCuentaCodelcoGDE;?>" style="width:80" maxlength="50"></td>
            <td width="97">Cuenta&nbsp;Enami&nbsp;GDE</td>
            <td width="117"><input  type="text" name="TxtCuentaEnamiGDE" value="<?php echo $TxtCuentaEnamiGDE;?>" style="width:80" maxlength="50"></td>
          </tr>
        
          <?php
		  	if ($Proceso=='M')
			{	?>
				<tr>
				<td>Restaurar Passw</td>
				<td colspan="5"> SI <input type='radio' name='passw' value='S'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO
				<input type='radio' name='passw' value='N' checked></td>
				</tr>
				<tr>
				<td>Restaurar Passw2</td>
				<td colspan="5"> SI <input type='radio' name='passw2' value='S'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO
				<input type='radio' name='passw2' value='N' checked></td>
				</tr><?php
			}	
		  ?>
        </table>
        <br>
        <table width="535" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509">
				<input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $TxtCodigo;?>')">
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
