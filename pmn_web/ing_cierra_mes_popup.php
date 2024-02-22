<?php
	include("../principal/conectar_principal.php");
?>
<html>
<head>
<script language="JavaScript">
function Confirmar(f,proceso)
{
	if (f.txtpassword.value=='')
	{
		alert("Debe Ingresar Contrase�a");
		f.txtpassword.focus();
		return;
	}

	if (proceso == 'AA')
	{
		f.action = "ing_cierra_mes01.php?proceso=" + proceso + "&ano=" + f.ano.value + "&mes=" + f.mes.value;
	}
		
	if (proceso == "AL")
	{
		linea =  "&FechaIni=" + f.FechaIni.value + "&FechaFin=" + f.FechaFin.value;
		linea = linea + "&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
		linea = linea + "&ano1=" + f.ano1.value + "&mes1=" + f.mes1.value + "&TipoCalculo=" +f.TipoCalculo.value;
		f.action = "ing_cierra_mes01.php?proceso=" + proceso + linea;
	}
		
	f.submit();
}
/******************/
function Salir()
{
	window.close();
}
</script>
<title>Sistema De Anodos</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPopUp" method="post" action="">
<?php	
	//Campos Ocultos.
	echo '<input name="cmbmovimiento" type="hidden" value="'.$cmbmovimiento.'">';
	echo '<input name="cmbproducto" type="hidden" value="'.$cmbproducto.'">';
	echo '<input name="cmbsubproducto" type="hidden" value="'.$cmbsubproducto.'">';
	echo '<input name="FechaIni" type="hidden" value="'.$FechaIni.'">';
	echo '<input name="FechaFin" type="hidden" value="'.$FechaFin.'">';
	echo '<input name="ano1" type="hidden" value="'.$ano1.'">';						
	echo '<input name="mes1" type="hidden" value="'.$mes1.'">';
	echo '<input name="TipoCalculo" type="hidden" value="'.$TipoCalculo.'">';	
?>

  <table width="400" height="200" border="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td><div align="center"></div>
        <table width="380" border="0" cellpadding="5" class="ColorTabla01">
          <tr>
            <td><div align="center">Confirmar Abrir Mes</div></td>
          </tr>
        </table>
<br>
        <table width="380" border="0" cellpadding="5" class="TablaInterior">
          <tr>
            <td>Usuario:
			<?php  
				$Consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$CookieRut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
				}

	
				//Campos Ocultos.
				echo '<input name="ano" type="hidden" value="'.$ano.'">';
				echo '<input name="mes" type="hidden" value="'.$mes.'">';
				echo '<input name="Sistema" type="hidden" value="'.$Sistema.'">';
			?>						
			</td>
          </tr>
        </table>
        <br>
        <table width="380" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="58" height="36">Password</td>&nbsp;
            <td width="322">&nbsp;<input name="txtpassword" type="password"  style="width:80"> 
			              <input name="BtnOk" type="button" id="BtnOk" value="Ok" onClick="Confirmar(this.form,'<?php echo $proceso ?>')"></td>
          </tr>
        </table> 
        <br>
        <table width="380" height="27" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><div align="center">
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:50" onClick="Salir()">
              </div></td>
          </tr>
        </table> </td>
	</tr>
  </table>
  </td>
  </tr>
  </table>
 	<?php
		if (isset($mensaje)) 
		{
			echo "<script languaje='JavaScript'>";
			echo "alert('".$mensaje."');";
			echo "</script>";
		}
	?>

</form>
</body>
</html>
<?php	include("../principal/cerrar_principal.php"); ?>