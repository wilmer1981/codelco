<?php  
	include("../principal/conectar_sea_web.php");
	//Ano=2023&Mes=11&Dia=9&GUIA=159590&FOLIO=&CORREC=466571

	if(isset($_REQUEST["Ano"])) {
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])) {
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}
	if(isset($_REQUEST["Dia"])) {
		$Dia = $_REQUEST["Dia"];
	}else{
		$Dia = "";
	}
	if(isset($_REQUEST["GUIA"])) {
		$GUIA = $_REQUEST["GUIA"];
	}else{
		$GUIA = "";
	}
	if(isset($_REQUEST["FOLIO"])) {
		$FOLIO = $_REQUEST["FOLIO"];
	}else{
		$FOLIO = "";
	}
	if(isset($_REQUEST["CORREC"])) {
		$CORREC = $_REQUEST["CORREC"];
	}else{
		$CORREC = "";
	}

	if(isset($_REQUEST["Grabar"])) {
		$Grabar = $_REQUEST["Grabar"];
	}else{
		$Grabar = "";
	}

	if(isset($_REQUEST["Lote"])) {
		$Lote = $_REQUEST["Lote"];
	}else{
		$Lote = "";
	}
	if(isset($_REQUEST["Recargo"])) {
		$Recargo = $_REQUEST["Recargo"];
	}else{
		$Recargo = "";
	}
	if(isset($_REQUEST["Patente"])) {
		$Patente = $_REQUEST["Patente"];
	}else{
		$Patente = "";
	}
	if(isset($_REQUEST["Guia"])) {
		$Guia = $_REQUEST["Guia"];
	}else{
		$Guia = "";
	}



	$Fecha = $Ano."-".$Mes."-".$Dia;
	 //echo "FECHA: ".$Fecha;
	if ($Grabar == "B")
	{
	        $Consulta2 = "SELECT * from SIPA_WEB.recepciones ";
      		$Consulta2.= " where FECHA = '".$Ano."-".$Mes."-".$Dia."'";
		    //$Consulta2.= " and FOLIOS_A = '".$FOLIO."'";
	        $Consulta2.= " and CORRELATIVO = '".$CORREC."'";
		    $Respuesta2 = mysqli_query($link, $Consulta2);
		    if ($Row2 = mysqli_fetch_array($Respuesta2))
		    {
                $Producto = $Row2["cod_subproducto"];
            }
					$Actualizar = "UPDATE sipa_web.recepciones set ";
					$Actualizar.= " GUIA_DESPACHO = '".$Guia."',PATENTE = '".$Patente."', ";
					$Actualizar.= " LOTE = '".$Lote."',RECARGO = '".$Recargo."', ";
					$Actualizar.= " ACTIVO = 'M'";
                    if ($Producto=='18')
                    {
                        $Actualizar.=" , COD_SUBPRODUCTO = '16'";
                    }
					$Actualizar.= " where FECHA = '".$Ano."-".$Mes."-".$Dia."'";
					//$Actualizar.= " and FOLIOS = '".$FOLIO."'";
					$Actualizar.= " and CORRELATIVO = '".$CORREC."'";
					mysqli_query($link, $Actualizar);
					echo "<script languaje='JavaScript'>";
					echo "window.opener.document.frmPoPup.action = 'sea_ing_recep_ext03.php?Proceso=B&ano=".$Ano."&mes=".$Mes."&dia=".$Dia."';";
					echo "window.opener.document.frmPoPup.submit();";
					echo "window.close();";
					echo "</script>";
					/*
					$valores = "?Proceso=B&ano=".$Ano."&mes=".$Mes."&dia=".$Dia;
					header("Location:sea_ing_recep_ext03.php".$valores);	*/
	}
    elseif($Grabar=="S")
	{	
		
			
					$control = 0;
					$Buscar = "SELECT * from sipa_web.recepciones where  LOTE = '".$Lote."'";
					$Buscar.=" and RECARGO = '".$Recargo."' and cod_subproducto = '17' ";
					//echo "Buscar".$Buscar;
					$Rbusca=mysqli_query($link, $Buscar);
					if ($Linea1 = mysqli_fetch_array($Rbusca))
					{
						$control = 1;
					}
					else
					{
						$Busca2 = "SELECT max(RECARGO) as recargo2 from sipa_web.recepciones where ";
						$Busca2.=" LOTE = '".$Lote."' and cod_subproducto = '17' ";
						$Rbusca2=mysqli_query($link, $Busca2);
						if ($Linea2 = mysqli_fetch_array($Rbusca2))
						{
							if ($Linea2["recargo2"] + 1 < $Recargo)
							$control = 2;
						}
					}
					//polyif ($control==0)
					if ($control==1)

					{
						$Actualizar = "UPDATE SIPA_WEB.recepciones set ";
						$Actualizar.= " GUIA_DESPACHO = '".$Guia."',PATENTE = '".$Patente."', ";
						$Actualizar.= " LOTE = '".$Lote."',RECARGO = '".$Recargo."', ";
						$Actualizar.= " ACTIVO = 'M'";
						$Actualizar.= " where FECHA = '".$Ano."-".$Mes."-".$Dia."'";
					//$Actualizar.= " and FOLIOS_A = '".$FOLIO."'";
						$Actualizar.= " and CORRELATIVO = '".$CORREC."'";
						mysqli_query($link, $Actualizar);
					}
					
					/*poly if($control==1)
					{
		 				echo'<script>
		      				alert("Recargo Ingresado para lote ya existe");
			  				</script>';
					}*/
					if ($control==2)
					{
						echo'<script>
						alert("Recargo Ingresado fuera de rango revise");
						</script>';
					
					}
					echo'<script>
							alert("Ano:"'.$Fecha.');
							</script>';
					/*
					echo "<script languaje='JavaScript'>";
					echo "window.opener.document.frmPoPup.action = 'sea_ing_recep_ext03.php?Proceso=B&ano=".$Ano."&mes=".$Mes."&dia=".$Dia."';";
					echo "window.opener.document.frmPoPup.submit();";
					echo "window.close();";
					echo "</script>";
					*/
					/*
					$valores = "?Proceso=B&ano=".$Ano."&mes=".$Mes."&dia=".$Dia;
					header("Location:sea_ing_recep_ext03.php".$valores);	*/
	}
	else
	{		
		$Consulta = "SELECT * from SIPA_WEB.recepciones ";
		$Consulta.= " where FECHA = '".$Fecha."'";
		$Consulta.= " and GUIA_DESPACHO = '".$GUIA."'";
		//$Consulta.= " and FOLIOS_A = '".$FOLIO."'";
		$Consulta.= " and CORRELATIVO = '".$CORREC."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$Guia = $Row["guia_despacho"];
			$Patente = $Row["patente"];
			$Lote = $Row["lote"];
			$Recargo = $Row["recargo"];
			$Peso = $Row["peso_neto"];
		}
	}
?>
<html>
<head>
<title>Modifica Guia</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso()
{
	var f = frmPoPup;

	if (f.Guia.value == "")
	{
		alert("Debe ingresar un numero de Guia");
	}
 	if (isNaN(parseInt(f.Guia.value)))			
	{
		alert("El N� Gu�a no es V�lido");
		f.Guia.focus();
		return
	}	

    f.action="sea_modif_guia.php?Grabar=S";
	f.submit();
}
function Proceso2()
{
	var f = frmPoPup;

	if (f.Guia.value == "")
	{
		alert("Debe ingresar un numero de Guia");
	}
 	if (isNaN(parseInt(f.Guia.value)))
	{
		alert("El N� Gu�a no es V�lido");
		f.Guia.focus();
		return
	}

    f.action="sea_modif_guia.php?Grabar=B";
	f.submit();
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPoPup" method="post" action="">
<input type="hidden" name="control" value="<?php echo $control; ?>"> 
<input type="hidden" name="ano" value="<?php echo $Ano; ?>">
<input type="hidden" name="mes" value="<?php echo $Mes; ?>">
<input type="hidden" name="dia" value="<?php echo $Dia; ?>">
<input type="hidden" name="FOLIO" value="<?php echo $FOLIO; ?>">
<input type="hidden" name="CORREC" value="<?php echo $CORREC; ?>">
  <br>
  <table width="387" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td>FECHA</td>
      <td><?php echo $Fecha; ?>&nbsp;</td>
      <td width="97" rowspan="6" align="center" valign="middle"> 
        <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:90;" onClick="Proceso();">
        <br>
        <br>
        <input name="BtnGrabar2" type="button" id="BtnGrabar2" value="Camb.a Blister" style="width:90;" onClick="Proceso2();">
        <br>
        <br>
        <input name="BtnCancelar" type="button" id="BtnCancelar" value="Cancelar" style="width:90;" onClick="JavaScript:window.close();"> </td>
    </tr>
    <tr> 
      <td width="105">GUIA</td>
      <td width="204"><input type="text" name="Guia" value="<?php echo $Guia; ?>"></td>
    </tr>
    <tr> 
      <td>PATENTE</td>
      <td><input type="text" name="Patente" value="<?php echo $Patente; ?>"></td>
    </tr>
    <tr> 
      <td>LOTE</td>
      <td><input type="text" name="Lote" value="<?php echo $Lote; ?>"></td>
    </tr>
    <tr> 
      <td>RECARGO</td>
      <td><input type="text" name="Recargo" value="<?php echo $Recargo; ?>"></td>
    </tr>
    <tr> 
      <td>PESO</td>
      <td><?php echo $Peso; ?>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
