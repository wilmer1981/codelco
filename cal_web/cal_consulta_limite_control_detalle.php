<?php
	include("../principal/conectar_principal.php");

?>
<html>
<head>
<?php
  	echo "<title>Detalle Limite de Control</title>";	
?>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmProceso;
	switch (opt)
	{
		
		case "S": //Cancelar	
			window.close();	
		break
	}
}

</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmProceso" method="post" ENCTYPE="multipart/form-data">
<table width="100%"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="Detalle02">
    <td colspan="4"><?php
	 echo " Detalle Limite de control";	
	?></td>
  </tr>
  <tr class="Colum01">
    <td  bgcolor="#FFFFFF">Solicitud An&aacute;lisis </td>
    <td colspan="3" bgcolor="#EFEFEF"><?php echo $SA;?>&nbsp;</td>
  </tr>
  <tr class="Colum01">
    <td  bgcolor="#FFFFFF">Producto</td>
	<td colspan="3" bgcolor="#EFEFEF">
	<?php
			$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos where cod_producto='".$Producto."' order by cod_producto,descripcion"; 
			$Respuesta = mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
				echo $Fila["descripcion"];

	?>	</td>	
    </tr>
  <tr class="Colum01">
    <td bgcolor="#FFFFFF">SubProducto</td>
    <td colspan="3" bgcolor="#EFEFEF"><?php
			$Consulta="select cod_subproducto,descripcion from subproducto where cod_subproducto = '".$SubProducto."' and cod_producto='".$Producto."'"; 
			$Respuesta = mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
				echo $Fila["descripcion"];

	 ?>  </td>
    </tr>
	<?php
	 if($Producto=='1')
	 {	
	?>
	  <tr class="Colum01">
		<td bgcolor="#FFFFFF">Proveedores</td>
		<td colspan="3" bgcolor="#EFEFEF">
		 <?php
		if($Proveedor!='')
		{
				if($Proveedor!='T')
				{
					$Consulta="select rut_prv,nombre_prv from sipa_web.proveedores where rut_prv='".$Proveedor."' order by nombre_prv"; 
					$Respuesta = mysqli_query($link, $Consulta);
					if($Fila=mysqli_fetch_array($Respuesta))
						echo $Fila[rut_prv]." - ".$Fila["nombre_prv"];
				}
				else
				{
						echo 'TODOS';
				}					
		
		}
		?>	</td>
	</tr>
   <?php
    }
   ?>
  <tr>
    <td bgcolor="#FFFFFF">Ley</td>
    <td colspan="3" bgcolor="#EFEFEF">
      <?php
			$Consulta="select cod_leyes,nombre_leyes,cod_unidad from proyecto_modernizacion.leyes where cod_leyes='".$CodLey."'"; 
			$Respuesta = mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
	 			echo $Fila["nombre_leyes"];
	 
	?></td>
    </tr>
  <tr class="Colum01">
    <td bgcolor="#FFFFFF">Unidad</td>
    <td colspan="3" bgcolor="#EFEFEF">
	  <?php
			$Consulta="select cod_unidad,nombre_unidad,abreviatura from proyecto_modernizacion.unidades  where cod_unidad='".$Unidad."' order by nombre_unidad"; 
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo ucwords(strtolower($Fila[nombre_unidad]))." - ".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";				
			}
		?>	</td>
    </tr>
  <tr class="Colum01">
    <td bgcolor="#FFFFFF">Valor</td>
    <td colspan="3" bgcolor="#EFEFEF"><span class='InputRojo'>
	  <?php
		$Consulta="Select valor,observacion from cal_web.leyes_por_solicitud where nro_solicitud='".$SA."' and cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
		$Consulta.=" and cod_leyes='".$CodLey."' and cod_unidad='".$Unidad."'  and recargo='".$Recargo."'";
		$Resp= mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Resp))
		{
				$Valor=$Fila["valor"];
				$Obs=$Fila["observacion"];
			
		}
		echo number_format($Valor,3,',','');
				?></span>	</td>
    </tr>
	
	<?php 
	
		$Consulta="Select * from cal_web.limite where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
		$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' and rut_proveedor='".$Proveedor."'";
		$Resp= mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Resp))
		{
				$LimitIni=$Fila["limite_inicial"];
				$LimitFin=$Fila[limite_final];
	
		}
	?>
    <tr class="Colum01">
    <td bgcolor="#FFFFFF">Limite inicial </td>
    <td bgcolor="#EFEFEF"><?php echo number_format($LimitIni,3,',','');?></td>					
    <td align="left" bgcolor="#FFFFFF">Limite&nbsp;Final </td>
    <td bgcolor="#EFEFEF"><?php echo number_format($LimitFin,3,',','');?></td>
  </tr>
    <tr class="Colum01">
      <td bgcolor="#FFFFFF">Observaci�n</td>
      <td colspan="3" bgcolor="#EFEFEF"><textarea name='Descrip' cols="70" rows="3" readonly><?php echo $Obs;?></textarea></td>
    </tr>

  <?php
  	if($Opc=='N')
		$Boton='Grabar';
	else
		$Boton='Modificar';	
  ?>
  <tr class="Detalle02">
    <td colspan="4" align="center" class="Colum01"><input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
<br>
</form>
</body>
</html>
<?php
	echo "<script languaje='JavaScript'>";
	if ($Msj=='1')
		echo "alert('Limite Ingresado Exitosamente');";
	if ($Msj=='2')
		echo "alert('Registro Existente');";
	if ($Msj=='3')
		echo "alert('Limite Modificado Exitosamente');";
	echo "</script>";
?>