<?php
	include("../principal/conectar_ref_web.php");

	$Proceso       = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Turno       = isset($_REQUEST["Turno"])?$_REQUEST["Turno"]:"";
	$Circuito       = isset($_REQUEST["Circuito"])?$_REQUEST["Circuito"]:"";
	$Destino       = isset($_REQUEST["Destino"])?$_REQUEST["Destino"]:"";
	$Volumen       = isset($_REQUEST["Volumen"])?$_REQUEST["Volumen"]:"";
	$txt_fecha       = isset($_REQUEST["txt_fecha"])?$_REQUEST["txt_fecha"]:"";

	if ($Proceso == "M")
	{
		$txt_turno = $Turno;	
		$cmbcircuito = $Circuito;
		$cmbdestino = $Destino;
	  	$txt_volumen_pte = $Volumen;		
	}
	
?>

<html>
<head>
<title>Modificacion Electrolito</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">

function Grabar(f)
{
	var f = document.frmPopup;
	/*var fecha=f.fecha.value;*/
	f.action = "proceso_modifica_electrolito.php?mostrar=S&proceso=M";
	f.submit();
	
}
function Salir()
{
	window.close();
}
</script>
</head>


<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<p>&nbsp;</p><form name="frmPopup" action="" method="post">
  <table width="433" height="157" border="0" align="center" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
  <td width="421" align="center" valign="middle">
  
  <table width="405" border="1" cellspacing="0" cellpadding="3">
          <tr> 
            <td>Fecha</td>
            <td><?php echo "$fecha" ?> <input name="txt_fecha" type="hidden" size="10" readonly value="<?php echo $fecha; ?>"></td>
          </tr>
          <tr> 
            <td>Turno </td>
            <td><input name="txt_turno" type="text" size="10" value="<?php echo $txt_turno; ?>" disabled>
			 <input name="txt_turno1" type="hidden" size="10" readonly value="<?php echo $txt_turno; ?>"></td>
          </tr>
          <tr> 
            <td>N&deg; Circuito Electrolito </td>
            <td><select name="cmbcircuito" id="select2" disabled>
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
              </select> <input name="txt_circuito" type="hidden" size="10" readonly value="<?php echo $cmbcircuito; ?>"></td>
          </tr>
          <tr> 
            <td width="141">Destino Electrolito</td>
            <td width="246"><select name="cmbdestino" disabled>
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT * FROM ref_web.tratamiento_electrolito";
				$rs = mysqli_query($link, $consulta);
				
				while ($row = mysqli_fetch_array($rs))
				{
		  			if ($cmbdestino == $row["destino_pte"])
						echo '<option value="'.$row["destino_pte"].'" selected>'.$row["destino_pte"].'</option>';
					else 
						echo '<option value="'.$row["destino_pte"].'">'.$row["destino_pte"].'</option>';
				}			
			?>
              </select> <input name="txt_destino" type="hidden" size="10" readonly value="<?php echo $cmbdestino; ?>"></td>
          </tr>
          <tr> 
            <td>Volumen Electrolito</td>
            <td><input name="txt_volumen_pte" type="text" size="10" value="<?php echo $txt_volumen_pte; ?>"></td>
          </tr>
        </table> 
	  	<?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
	  
        <br>
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="JavaScrip:Grabar(this.form)">
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="JavaScript:Salir()"></td>
        </tr>
      </table></td>
	  
</tr>
</table>	  
</form>
<?php
	if (isset($activar))
	{
		echo '<script language="JavaScript">';		
		if (isset($mensaje))
			echo 'alert("'.$mensaje.'");';		
			
		echo 'window.opener.document.frmPrincipal.action = "ingreso_cir_eleaux.php?fecha='.$txt_fecha.'&mostrar=S";';
		echo 'window.opener.document.frmPrincipal.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>
</body>
</html>
<?php 	include("../principal/cerrar_sec_web.php"); ?>



