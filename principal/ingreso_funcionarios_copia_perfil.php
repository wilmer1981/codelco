<?php 	
	//include("../principal/conectar_comet_web.php");
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}
	if(isset($_REQUEST["CmbRut"])){
		$CmbRut = $_REQUEST["CmbRut"];
	}else{
		$CmbRut = "";
	}

?>
<html>
<head>
<script language="JavaScript">
function Grabar()
{
	var Frm=document.FrmProceso;
	if (Frm.CmbRut.value=="S")
	{
		alert("Debe Seleccionar un Funcionario");
	}
	else
	{
		Frm.action="ingreso_funcionarios_proceso01.php?Proceso=CP";
		Frm.submit();
	}
}

function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body  background='../principal/imagenes/fondo3.gif' leftmargin='3' marginwidth='0'>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	margin-top: 5px;
	background-image: url(imagenes/fondo3.gif);
}
</style>
<br>
<br>
<form name="FrmProceso" method="post" action="">
<input type="hidden" name="Valores" value="<?php echo $Valores; ?>">
  <table width="535" border="0" align="center" cellpadding="5" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF"> 
            <td colspan="2"><strong>Seleccione Funcionario que Tiene el Perfil Deseado a Copiar</strong></td>
          </tr>
          <tr> 
            <td width="70">Rut Func.: </td>
            <td width="436"><select name="CmbRut">
			<option value="S" class="NoSelec">SELECCIONAR</option>
              <?php
			  	$Consulta = "select * from proyecto_modernizacion.funcionarios order by apellido_paterno, apellido_materno, nombres, rut";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Nombre = strtoupper($Fila["apellido_paterno"])." ".strtoupper($Fila["apellido_materno"])." ".strtoupper($Fila["nombres"]);
					if ($CmbRut==$Fila["rut"])
						echo "<option selected value='".$Fila["rut"]."'>".$Nombre."</option>\n";
					else
						echo "<option value='".$Fila["rut"]."'>".$Nombre."</option>\n";						
				}
  			  ?></select> 
            </td>
          </tr>
          <tr align="center">
            <td colspan="2"><input name="BtnCopiar" type="button" id="BtnCopiar" style="width:60" onClick="Grabar()" value="Copiar">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
&nbsp; </td>
          </tr>
          <?php
		  	if ($Proceso=='M')
			{	
				echo "<tr>"; 
				echo "<td>Restaurar Passw</td>";
				echo "<td> SI <input type='radio' name='passw' value='S'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
				echo "<input type='radio' name='passw' value='N' checked></td>";
				echo "</tr>";
			}	
		  ?>
  </table>
        <br>
        </form>
</body>
</html>
