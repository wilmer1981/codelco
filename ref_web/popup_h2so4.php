<?php
	include("../principal/conectar_ref_web.php");

	$proceso       = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$opcion   = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$Turno       = isset($_REQUEST["Turno"])?$_REQUEST["Turno"]:"";
	$Circuito       = isset($_REQUEST["Circuito"])?$_REQUEST["Circuito"]:"";
	$Volumen       = isset($_REQUEST["Volumen"])?$_REQUEST["Volumen"]:"";
	$txt_fecha       = isset($_REQUEST["txt_fecha"])?$_REQUEST["txt_fecha"]:"";

	$activar       = isset($_REQUEST["activar"])?$_REQUEST["activar"]:"";
	//$mensaje       = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";
     	 
	if ($proceso == "M")
	{   
	  	$txt_turno = $Turno;	
		$cmbcircuito = $Circuito;
		$txt_volumen_h2so4 = $Volumen;		
	}

	$fecha       = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
?>

<html>
<head>
<title>Modificacion H2so4</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Grabar(f)
{
	var f = document.frmPopup;
	/*var fecha=f.fecha.value;*/
	f.action = "proceso_modifica_h2so4.php?mostrar=S&proceso=M";
	f.submit();
	
}
function Salir222()
{
	window.close();
}
function Salir(f,fecha)
{
	f.action = "traspasos.php?fecha="+fecha;
	f.submit();
}
</script>
</head>


<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPopup" action="" method="post">
  <table width="433" height="157" border="0" align="center" cellpadding="5" cellspacing="0" class="TablaPrincipal">
<tr>
  <td width="421" align="center" valign="middle">
  
  <table width="405" border="1" cellspacing="0" cellpadding="3">
          <tr> 
            <td colspan="2" class="TablaDetalle" align="center">Modificacion de Agregados de H2SO4 a Circuitos</td>
          </tr>
          <tr> 
            <td width="141">Fecha</td>
            <td width="246"><?php echo "$txt_fecha" ?> <input name="txt_fecha" type="hidden" size="10" readonly value="<?php echo $txt_fecha; ?>"></td>
          </tr>
          <tr> 
            <td>Turno</td>
            <td width="246"><input name="txt_turno" type="text" size="10" readonly value="<?php echo $txt_turno; ?>" disabled></td>
          </tr>
          <tr> 
            <td>N&deg; Circuito</td>
            <td><select name="cmbcircuito" id="select" disabled>
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 3100 ORDER BY cod_clase";
				$rs = mysqli_query($link, $consulta);
				
				while ($row = mysqli_fetch_array($rs))
				{
		  			if ($cmbcircuito == $row["nombre_subclase"])
						echo '<option value="'.$row["nombre_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
					else 
						echo '<option value="'.$row["nombre_subclase"].'">'.$row["nombre_subclase"].'</option>';
				}			
			?>
              </select> <input name="txt_circuito" type="hidden" size="10" readonly value="<?php echo $cmbcircuito; ?>"> 
            </td>
          </tr>
          <tr> 
            <td>Volumen </td>
            <td><input name="txt_volumen_h2so4" type="text" size="10" value="<?php echo $txt_volumen_h2so4; ?>"></td>
          </tr>
        </table> 
	  	<?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
	  <br>
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
			<input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="JavaScript:Grabar(this.form)">
			<input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir(this.form,' <?php echo $txt_fecha;?>')">
		</td>
		
        </tr>
      </table></td>
	  
</tr>
</table>
<?php
	if (isset($activar))
	{
		echo '<script language="JavaScript">';		
		if (isset($mensaje))
			echo 'alert("'.$mensaje.'");';		
			
		//echo 'window.opener.document.frmPrincipal.action = "ingreso_cir_eleaux.php?fecha='.$txt_fecha.'&mostrar=S";';
		echo 'window.opener.document.FrmPrincipal.action = "traspasos.php?fecha='.$txt_fecha.'&mostrar=S";';
		echo 'window.opener.document.FrmPrincipal.submit();';
		echo 'window.close();';		
		echo '</script>';
		
	}
?>	  
</form>

</body>
</html>
<?php 	include("../principal/cerrar_sec_web.php"); ?>


