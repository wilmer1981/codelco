<?php
	include("../principal/conectar_principal.php");
	if(!isset($CmbProveedores))
		$CmbProveedores='T';
	if($Opc=='M')
	{
		$Dato=explode("~",$Valores);
		$Consulta="select * from cal_web.limite where cod_producto='".$Dato[0]."' and cod_subproducto='".$Dato[1]."'";
		if($Dato[0]=='1')
			$Consulta.=" and rut_proveedor='".$Dato[2]."'";
		$Consulta.=" and cod_ley='".$Dato[3]."'";	
		$Respuesta = mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
		{
			$CmbProductos=$Fila["cod_producto"];
			$CmbSubProducto=$Fila["cod_subproducto"];
			$CmbProveedores=$Fila["rut_proveedor"];
			$CmbLeyes=$Fila[cod_ley];
			$LimitIni=$Fila[limite_inicial];
			$LimitFin=$Fila[limite_final];
			$CmbUnidad=$Fila[unidad];
		}
	}
?>
<html>
<head>
<?php
 	echo "<title>Eliminar Datos de Solicitud</title>";	
?>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
function Elimina(Valor)
{
	var f = document.frmProceso;
	if(f.CantidadLeyes.value=='1')
	{
		alert('No se puede Eliminar, debe quedar al menos 1 Valor por Ley.');
		return;
	}
	var mensaje=confirm('�Esta Seguro de Eliminar Registro?');
	if(mensaje==true)
	{
		f.action = "cal_tras_leyes_espectroplasma01.php?Opcion=Elimina&Valor="+Valor;
		f.submit();
	}
}
function Proceso(opt)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "S": //Cancelar	
			window.opener.document.EspectroPlasma.action="cal_tras_leyes_espectroplasma.php?M=S&Msj=R";
			window.opener.document.EspectroPlasma.submit();		
			window.close();	
		break
	}
}
function Mensaje(Msj)
{
	if(Msj=='E')
	{
		alert('Registro Eliminado con Exito.');
		return;
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
<body onLoad="Mensaje('<?php echo $Msj;?>')">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmProceso" method="post" ENCTYPE="multipart/form-data">
<table width="382"  border="1" align="center" cellpadding="1" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="6"><?php
	echo 	"Datos Solicitud: ".$SA;		
	?>&nbsp;</td>
  </tr>
		<tr class="ColorTabla01">
		<td width="36">Elim.</td>
		<td width="162">Ley</td>
		<td width="120">Valor</td>
		</tr>
	<?php
	$Consulta="select SA,ley,abreviatura,valor from cal_web.tmp_espectroplasma t1 ";
	$Consulta.="left join proyecto_modernizacion.leyes t2 on t1.ley=t2.cod_leyes where rut='".$CookieRut."' and SA='".$SA."' and ley='".$Ley."'";
	//echo $Consulta."<br>";
	$Resp=mysqli_query($link, $Consulta);$Cuenta='0';
	while($Filas=mysqli_fetch_assoc($Resp))
	{
		?>
			<tr>
			<td width="36" align="center">
			<input name="BtnSalir" type="button" id="BtnSalir" value="X" style="width:20px " onClick="Elimina('<?php echo $Filas[SA]."~".$Filas[ley]."~".$Filas[valor];?>')"></td>
			<td width="162"><?php echo $Filas["abreviatura"];?></td>
			<td width="120"><?php echo number_format($Filas[valor],4,'.',',');?></td>
			</tr>
		<?php	
		$Cuenta++;	
	}
  	$Consulta="select AVG(valor) as promedio from cal_web.tmp_espectroplasma ";
	$Consulta.="where rut='".$CookieRut."' and SA='".$SA."' and ley='".$Ley."' group by rut,SA, ley";
	$Resp=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_assoc($Resp);
	$ValorProm=$Fila[promedio];

  ?>
	<tr>
	<td class="ColorTabla02" colspan="2" align="right">Promedio</td>
	<td class="ColorTabla02"><?php echo number_format($ValorProm,4,'.',',');?></td>
	</tr>
</table>
<input type="hidden" name="CantidadLeyes" value="<?php echo $Cuenta;?>">
<table width="383"  border="1" align="center" cellpadding="1" cellspacing="0" class="TablaInterior">
  <tr class="Colum01">
    <td colspan="2" align="center" class="Colum01"><input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
<br>
</form>
</body>
</html>
