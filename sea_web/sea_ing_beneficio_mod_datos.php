<?php
include("../principal/conectar_rec_web.php");

if (isset($_REQUEST["proceso"])) {
	$proceso = $_REQUEST["proceso"];
}else {
	$proceso = '';
}
if(isset($_REQUEST["proveedor"])) {
	$proveedor = $_REQUEST["proveedor"];
}else{
	$proveedor = "";
}
if (isset($_REQUEST["txthornada"])) {
	$txthornada = $_REQUEST["txthornada"];
}else {
	$txthornada = '';
}
if(isset($_REQUEST["producto"])) {
	$producto = $_REQUEST["producto"];
}else{
	$producto = "";
}
if(isset($_REQUEST["subproducto"])) {
	$subproducto = $_REQUEST["subproducto"];
}else{
	$subproducto = "";
}

if(isset($_REQUEST["nrohornada"])) {
	$nrohornada = $_REQUEST["nrohornada"];
}else{
	$nrohornada = "";
}
if(isset($_REQUEST["unidad_hornada"])) {
	$unidad_hornada = $_REQUEST["unidad_hornada"];
}else{
	$unidad_hornada = "";
}
if(isset($_REQUEST["peso_hornada"])) {
	$peso_hornada = $_REQUEST["peso_hornada"];
}else{
	$peso_hornada = "";
}

if($proceso == "G")
{
	    
	$Consulta = "SELECT * from sea_web.hornadas where cod_producto = '".$producto."' and ";
	$Consulta.=" cod_subproducto = '".$subproducto."' and hornada_ventana = '".$nrohornada."' ";
	$RsHorna=mysqli_query($link, $Consulta) or die("Problemas en el Select sea_web.hornadas ".mysql_error());
	if ($Row2=mysqli_fetch_array($RsHorna))
	{
		$actualiza ="UPDATE sea_web.hornadas set peso_unidades = '".$peso_hornada."', unidades = '".$unidad_hornada."' ";
		$actualiza.=" where cod_producto = '".$producto."' and  cod_subproducto ='".$subproducto."' and hornada_ventana = '".$nrohornada."' ";
		//echo 'actualizara = '.$actualiza;
		mysqli_query($link, $actualiza) or die("Problemas en el Update sea_web.hornadas, ".mysql_error());
		
		
		// realiza el cierre popuo y vuelta al padre y le hace un refresh 
        echo '<script> window.opener.location.reload(); </script>' ; 
        echo '<script> self.close(); </script>' ;
				
	}
	else
	{
        echo " 
                <script language='JavaScript'> 
                alert('Problema al Select Hornada!!!'); 
                </script>";		
	}

}


if($proceso == "P")  // inicia la primera vez el proceso 
{
	
	$Consulta = "SELECT IFNULL(SUM(unidades),0) as Val_Unidades, IFNULL(SUM(peso),0) as Val_Peso From sea_web.movimientos ";
	$Consulta.=" Where tipo_movimiento = 1 and ";
	$Consulta.=" cod_producto = '".$producto."' and ";
	$Consulta.=" cod_subproducto = '".$subproducto."' and hornada = '".$txthornada."' ";
	//echo "Consulta = " .$Consulta;	
	$RsMovi=mysqli_query($link, $Consulta) or die("Problemas en el Select sea_web.movimientos ".mysql_error());
	$RowMovi=mysqli_fetch_array($RsMovi);
	
	$txtunidstock = $RowMovi["Val_Unidades"];
	$peso_stock = $RowMovi["Val_Peso"];
	
}

?>

<html>
<head>
<title>Modificaci&oacute;n Datos Beneficios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function guardar_datos()
{
	  if(confirm("¿Desea Modificar las unidades y Peso de la Hornada?"))
        {
			f=document.formulario;	
			f.action="sea_ing_beneficio_mod_datos.php?proceso=G&producto=" + f.producto.value + "&subproducto=" + f.subproducto.value +
			 "&nrohornada=" + f.nrohornada.value + "&unidad_hornada=" + f.unidad_hornada.value + "&peso_hornada=" + f.peso_hornada.value;
 			f.submit();
	    }

}

</script>
</head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body class="TablaPrincipal">
<form name="formulario" method="post">
	  <input name="subprod" type="hidden" value="subprod">
 	  
	  <table width="500" border="0" cellspacing="0" cellpadding="2" a align="center" class="TablaDetalle">
		<tr> 
		  <td colspan="9" align="center" class="ColorTabla01">Modificar Datos Hornada</td>
		</tr>
		<tr> 
		  <td width="101" height="25">N&deg; Hornada</td>
		  <td width="385">
          <p>
          <?php
          //<input type="text" name="guia" size="9">
		  echo '<input type="text" name="nrohornada" value="'.$txthornada.'" size="14" readonly>';
		  ?>
          <?php
		  		  echo '<input type="hidden" name="producto" value="'.$producto.'" size="10" readonly>';
				  ?>
                  <?php
				  		  echo '<input type="hidden" name="subproducto" value="'.$subproducto.'" size="10" readonly>';
		  ?>
		  </p>
	      </td>
		</tr>
		<?php
			$valbli = substr($proveedor,0,1);
			echo '<input type="hidden" name="valbli" value="'.$valbli.'">';
		?>
		<tr>
			<td>Unidades</td>
			<td>
            <?php
			//$txtunidstock = txtunidstock;
            //<input type="text" name="unidad_recepcion" size="9">
            echo '<input type="text" name="unidad_hornada" size="9" value="'.$txtunidstock.'" readonly>';
			?>
            </td>
		</tr>
		<tr> 
		  <td>Peso</td>
		  <td>
          <?php
		  // <input type="text" name="peso_recepcion" size="9">
		  echo '<input type="text" name="peso_hornada" value="'.$peso_stock.'" size="9" readonly>'; 
		  echo '<strong>&nbsp;&nbsp;Formato Ej: 21520</strong>';
		  ?>
		  </td>
		</tr>
	  </table>
	  <br>
	  <table width="500" border="1" cellspacing="0" cellpadding="2" a align="center" class="TablaDetalle">
		<tr> 
		  <td colspan="9" align="center">
		  <input type="button" name="guardar" value="Guardar" style="width:70" onClick="guardar_datos()">
		  <input type="button" name="salir" value="Salir" style="width:70" onClick="self.close()">
		  </td>
		</tr>
	  </table>	  
</form>
</body>
</html>
