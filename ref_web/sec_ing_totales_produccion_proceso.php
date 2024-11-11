<?php
	include("../principal/conectar_sec_web.php");
	$opcion         = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$parametros     = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";
	$mostrar   = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
	$activar   = isset($_REQUEST["activar"])?$_REQUEST["activar"]:"";
	$mensaje   = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";
			
	if($opcion == "M")
	{
		$arreglo = explode("/", $parametros); //Fecha - revision. 
		$ano = substr($arreglo[0],0,4);
		$mes = substr($arreglo[0],5,2);
		$dia= substr($arreglo[0],8,2);
		$consulta = "SELECT * FROM sec_web.totales_prog_prod WHERE fecha_total = '".$ano."-".$mes."-".$dia."' AND cod_revision = '".$arreglo[1]."'";
        $rs = mysqli_query($link, $consulta);
  		if ($row = mysqli_fetch_array($rs))
			$mostrar = "S";
	}
	if($opcion == "N")
	{
		$fecha_aux = date("Y")."-";
		if (strlen(date("n")) == 1)
			$fecha_aux = $fecha_aux."0";
		$fecha_aux = $fecha_aux.date("n");
		
		$consulta = "SELECT IFNULL(MAX(cod_revision)+1,0) AS revision FROM sec_web.totales_prog_prod";
		$consulta = $consulta." WHERE fecha_total LIKE '".$fecha_aux."%'";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
	}	

?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValidaCampos(f)
{
	if (f.txtrevision.value == "")
	{
		alert("Debe Ingresar Revision");
		return false;
	}
	
	if (f.txtcatodos.value == "")
	{
		alert("Debe Ingresar los Catodos Comerciales");
		return false;
	}
	
	if (f.txtdescobrizacion.value == "")
	{
		alert("Debe Ingresar la Descobrizacion");
		return false;
	}
	
	if (f.txtdespuntes.value == "")
	{
		alert("Debe Ingresar los Despuntes");
		return false;
	}
	
	return true;
}
/*****************/
function Grabar(f)
{
	if (ValidaCampos(f))
	{
		linea = "proceso=G&ano=" + f.ano.value + "&mes=" + f.mes.value + "&txtrevision=" + f.txtrevision.value;
		/*if (f.activar.checked)
			linea = linea + "&estado=1";
		else 
			linea = linea + "&estado=0";*/
			
		f.action = "sec_ing_totales_produccion_proceso01.php?" + linea;
		f.submit();
	}
}
/*****************/
function Salir()
{
	window.close();
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="PopupProduccion" action="" method="post">
<table width="433" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
<tr>
<td width="421" align="center" valign="middle"><table width="400" border="0" cellspacing="0" cellpadding="3">
          <tr> 
            <td width="167">Fecha</td>
            <td colspan="2"><font size="2"> 
            <?php
          	if ($mostrar == "S")
				echo '<select name="mes" disabled>';
			else
				echo '<select name="mes">';
   	
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($mostrar != "S"))
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
			?></select>
            <?php
          	if ($mostrar == "S")
		    	echo '<select name="ano" disabled>';
			else 
				echo '<select name="ano">';
          
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano))
					echo "<option selected value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
			?></select>
              </font></td>
          </tr>
          <tr> 
            <td>Revisi&oacute;n</td>
            <td width="65"> 
              <?php
			  $cod_revision = isset($row["cod_revision"])?$row["cod_revision"]:"";
			  $total_catodo_comercial = isset($row["total_catodo_comercial"])?$row["total_catodo_comercial"]:"";
			  $total_desc_normal = isset($row["total_desc_normal"])?$row["total_desc_normal"]:"";
			  $total_desp_lamina = isset($row["total_desp_lamina"])?$row["total_desp_lamina"]:"";

				if ($mostrar == "S")
					echo '<input name="txtrevision" type="text" size="10" value="'.$cod_revision.'" disabled></td>';
				else 
					echo '<input name="txtrevision" type="text" size="10" value="'.$cod_revision.'"></td>';
			?>
            <td width="150">
			<?php
			   /*
				if ($row["estado"] == 1)
					echo '<input name="activar" type="checkbox" id="activar" checked>';
				else 
					echo '<input name="activar" type="checkbox" id="activar">';*/
			?>
             <!-- Activar</tr>-->
          <tr> 
            <td>Catodos Comerciales</td>
            <td colspan="2"><input name="txtcatodos" type="text" size="10" value="<?php echo $total_catodo_comercial; ?>"></td>
          </tr>
          <tr> 
            <td>Descobrizacion Normal</td>
            <td colspan="2"><input name="txtdescobrizacion" type="text" size="10" value="<?php echo $total_desc_normal; ?>"></td>
          </tr>
          <tr> 
            <td>Despuntes y L&aacute;minas</td>
            <td colspan="2"><input name="txtdespuntes" type="text" size="10" value="<?php echo $total_desp_lamina; ?>"></td>
          </tr>
        </table> 
        <br>
		<?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
		
        <table width="400" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td align="center"><input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="Grabar(this.form)">
              <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
          </tr>
        </table>
    </tr>
</table>	
</form>
<?php
	if ($activar!="")
	{
		echo '<script language="JavaScript">';		
		if ($mensaje!="")
			echo 'alert("'.$mensaje.'");';		
		
		echo 'window.opener.document.frmPrincipal.action = "sec_ing_totales_produccion.php";';
		echo 'window.opener.document.frmPrincipal.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php"); ?>


