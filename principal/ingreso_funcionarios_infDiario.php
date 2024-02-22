<html>
<head>
<?php 	
include("../principal/conectar_principal.php");

	if(isset($_GET["Proceso"])){
		$Proceso = $_GET["Proceso"];
	}else{
		$Proceso = "";
	}

	if(isset($_POST["TxtRut"])){
		$TxtRut = $_POST["TxtRut"];
	}else{
		$TxtRut = "";
	}
	if(isset($_POST["TxtNombres"])){
		$TxtNombres = $_POST["TxtNombres"];
	}else{
		$TxtNombres = "";
	}
	if(isset($_POST["TxtPassword"])){
		$TxtPassword = $_POST["TxtPassword"];
	}else{
		$TxtPassword = "";
	}

	if(isset($_POST["CmbGrupo"])){
		$CmbGrupo = $_POST["CmbGrupo"];
	}else{
		$CmbGrupo = "";
	}

	

	$CodigoDeSistema = 99;
	$CodigoDePantalla = 12;

	//$CodigoDeSistema = $_POST["CodSist"];
	//$CodigoDePantalla = $_POST["CodPant"];
	//f.Pagina.value=url;


	$encuentro=0;
	if ($Proceso=="M")
	{
		$Consulta = "SELECT * from informe_diario.usuarios where RUT = '".$TxtRut."'";
		$resp=mysqli_query($link, $Consulta);
		if ($row = mysqli_fetch_array($resp))
		{
		
			$encuentro = 1;
			$TxtRut = $row["RUT"];
			$TxtNombres = $row["NOMBRE_APELLIDO"];
			$TxtGrupo = $row["Grupo"];
			$TxtPassword = $row["PASSWORD"];
		}
	}
	
?>
<script language="JavaScript">

function Grabar()
{
	var F =document.Formulario;
	//alert (F.TxtPassword.value);
	
	if (F.CmbGrupo.value == "-1")
	{
		alert("Debe Seleccionar area");
		F.CmbGrupo.focus();
		return;
	}
	if (F.TxtRut.value == "")
	{
			alert("Debe Ingresar Rut")
			F.TxtRut.focus();
			return;
	}
	if (F.TxtPassword.value=="")
	{
		alert("Debe ingresar Password")
		F.TxtPassword.focus();
		return;
	}
	F.action="ingreso_funcionario_infDiario01.php?Proceso=G";
	F.submit();
}
function Eliminar()
{
	var F=document.Formulario;
	
	F.action="ingreso_funcionario_infDiario01.php?Proceso=E";
	F.submit();
	
}
function Recarga()
{
	var F = document.Formulario;
	if (F.TxtRut.value == "")
	{
			alert("Debe Ingresar Rut")
			F.TxtRut.focus();
			return;
	}
	F.action="ingreso_funcionarios_infDiario.php?Proceso=M";
	F.submit();
}
function Salir()
{
	var F=document.Formulario;
	F.action="../principal/sistemas_usuario.php?CodSistema=99";
	F.submit();
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">

<form name="Formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>

  <table width="600"  height="15" border="1" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
	<tr><td>&nbsp;</td></tr>
  		<tr align="center">
  	 		<td> ACTUALIZACION DE FUNCIONARIOS PARA INFORME DIARIO</td>
		</tr>
	<tr><td>&nbsp;</td></tr>
	
  	<tr>
 	 <table width="600"  height="157" border="1" cellpadding="5" cellspacing="0" class="TablaPrincipal">
            <tr> 
             <td width="91">Area</td>
             <td width="415"> 
              <?php 
				  		echo "<input type='hidden' name='TxtDescripcion'>";
						echo "<select name='CmbGrupo' style='width:320'>";
						echo "<option value='-1'>SELECCIONAR</option>";
						$Consulta="SELECT distinct Grupo, DESCRIPCION_GRUPO from informe_diario.usuarios order by Grupo";
						$Resultado=mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Resultado))
						{
								if ($CmbGrupo==$Fila["Grupo"])
								{
										//echo "<option value='$Fila["Grupo"]' selected>".$Fila["Grupo"]."-".strtoupper($Fila["DESCRIPCION_GRUPO"])."</option>";
										echo "<option value='".$Fila["Grupo"]."' selected>".strtoupper($Fila["DESCRIPCION_GRUPO"])."</option>";
								}
								else
								{
									//echo "<option value='$Fila["Grupo"]' selected>".$Fila["Grupo"]."-".strtoupper($Fila["DESCRIPCION_GRUPO"])."</option>";
									echo "<option value='".$Fila["Grupo"]."'>".strtoupper($Fila["DESCRIPCION_GRUPO"])."</option>";
								}	
						}
				echo "</select>";
			?>
            </td>
          </tr>

    	<tr>
             <td width="91">Rut</td>
             <td width="415"> 
              <?php 
				echo "<input name='TxtRut' type='text' value='$TxtRut' style='width:85'>&nbsp;<input name='BtnOk' value='OK' type='button' style='width:25' onclick=Recarga('1')>";
					?>
			 </td>
			</tr>
            <tr> 
             <td width="91">Nombres</td>
             <td width="415"> 
              <?php echo "<input type='text' name='TxtNombres' style='width:320' maxlength='100' value='".$TxtNombres."' >";	?>
			 </td>
			</tr>
            <tr> 
             <td width="91">Password</td>
             <td width="415"> 
              <?php echo "<input type='password' name='TxtPassword' style='width:100' maxlength='13' value='".$TxtPassword."' >";	?>
			 </td>
			</tr>
        </table>
        <table width="600" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar()">
              <input type="button" name="BtnEliminar" value="Eliminar" style="width:60" onClick="Eliminar();">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
   </tr>
  </table>
  </form>
</body>
</html>
