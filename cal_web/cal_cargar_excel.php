<?php 
	include("../principal/conectar_principal.php");
	$CookieRut=$_COOKIE["CookieRut"];
	$Rut =$CookieRut;


	$TxtFecha=date("Y-m-d");
	$HoraActual = date("H");
	$MinutoActual = date("i");
	
	if(isset($_REQUEST["Proceso"])) {
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso =  "";
	}
	if(isset($_REQUEST["Formulario"])) {
		$Formulario = $_REQUEST["Formulario"];
	}else{
		$Formulario =  "";
	}
	if(isset($_REQUEST["Pagina"])) {
		$Pagina = $_REQUEST["Pagina"];
	}else{
		$Pagina =  "";
	}

?>
<html>
<head>
<title>Carga Leyes De Excel</title>
<script language="JavaScript">
function ProcesoExcel(Opcion)
{
	var f= document.FrmCargaExcel;
	switch(Opcion)
	{
		case "G":
			
			if(f.Archivo.value=='')
			{
				alert('Debe Seleccionar Documento')
				f.Archivo.focus();
				return;
			}
			f.action='cal_procesa_excel.php';
			f.submit();
		break;
		case "S":
			window.close();
		break;
	}
}
</script>
</head>

<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body class="TablaPrincipal">
<form action="" method="post" enctype="multipart/form-data" name="FrmCargaExcel">
<input type="hidden" name="Proceso" value="<?php echo $Proceso;?>">
<input type="hidden" name="Formulario" value="<?php echo $Formulario;?>">
<input type="hidden" name="Pagina" value="<?php echo $Pagina;?>">

  <table width="441" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaPrincipal" >
    <tr>
      <td colspan="6" class="TituloTablaNaranja">Cargar Excel  (Archivos) </td>
    </tr>   
   <tr>
      <td align="right" class="texto_bold">Documento Excel </td>
      <td class="texto_bold">:</td>
      <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<?php echo $TxtRutPrv;?>" size="12" maxlength="10" <?php echo $EstadoRutPrv?>>-->
      <td colspan="4" class="texto_bold">
        <input type="file" name="Archivo" id="Archivo">      </td>
    </tr>
     <tr align="center" >
       <td colspan="6" ><span class="InputRojo">Solo archivos con extenci&oacute;n XLS</span></td>
     </tr>
     <tr align="center" bgcolor="#FFFFFF" class="Detalle02">
      <td colspan="6" >
	<input name="BtnAceptar" type="button" id="BtnAceptar" style="width:80" value="Aceptar" onClick="ProcesoExcel('G')">&nbsp;
	<input name="BtnCancelar" type="button" id="BtnCancelar" style="width:80" value="Cancelar" onClick="ProcesoExcel('S')">&nbsp;</td>
    </tr>
    
  </table>

</form>
</body>
</html>
<?php 
	echo "<script languaje='JavaScript'>";
		
	if($Acento==true)
	{
		echo "alert('Renombre el Archivo sin Acentos');";	
	}
	
	
	echo "</script>";
?>