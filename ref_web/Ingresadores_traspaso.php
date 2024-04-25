<?php
	include("../principal/conectar_ref_web.php");
  $fecha       = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
  $txt_fecha       = isset($_REQUEST["txt_fecha"])?$_REQUEST["txt_fecha"]:"";

	$fecha=ltrim($fecha);
	
?>

<html>
<head>
<title>Modificacion Electrolito</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(f,opc,fecha)
{
	if (opc == '1')
	    //window.open("ingreso_h2so4.php?"+linea,"","top=150,left=180,width=525,height=400,scrollbars=no,resizable = no");
		f.action = "ingreso_h2so4.php?fecha="+fecha;
        f.submit();

	if (opc == '2')
	    //window.open("ingreso_desc_parcial.php?"+linea,"","top=150,left=180,width=525,height=400,scrollbars=no,resizable = no");
        f.action = "ingreso_desc_parcial.php?fecha="+fecha;
        f.submit();
	if (opc == '3')
	    //window.open("ingreso_electrolito.php?"+linea,"","top=150,left=180,width=535,height=400,scrollbars=no,resizable = no");
		f.action = "ingreso_electrolito.php?fecha="+fecha;
        f.submit();
	/*if (opc == '4')
	    window.open("ingreso_pte.php?"+linea,"","top=150,left=5,width=765,height=290,scrollbars=no,resizable = no");*/
			
}

</script>
</head>


<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<p>&nbsp;</p><form name="frmPopup" action="" method="post">
  <table width="433" height="157" border="0" align="center" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="421" align="center" valign="middle"><br> 
        <table width="400" border="0" cellspacing="0" cellpadding="0" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td align="center" >Ingreso de Traspasos y Adiciones a Electrolito</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td align="center" valign="middle"><table width="405" border="1" cellspacing="0" cellpadding="3">
          <tr> 
            <td width="141"><input name="btningresosh2so4" type="button" value="Nuevo H2SO4" style="width:120" onClick="Proceso(this.form,'1',' <?php echo $fecha?>')"></td>
            <td width="123"><input name="btningresosh2so42" type="button" value="Nuevo Desc.Parcial" style="width:120" onClick="Proceso(this.form,'2',' <?php echo $fecha?>')"></td>
            <td width="123"><input name="btningresosh2so43" type="button" value="Nuevo Electrolito" style="width:120" onClick="Proceso(this.form,'3',' <?php echo $fecha?>')"></td>
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



