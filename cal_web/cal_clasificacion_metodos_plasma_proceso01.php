<?php
	include("../principal/conectar_principal.php");

	$Opcion = isset($_REQUEST["Opcion"])?$_REQUEST["Opcion"]:"";
	$Valor  = isset($_REQUEST["Valor"])?$_REQUEST["Valor"]:"";
	
	$CmbProductos   = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbLeyes       = isset($_REQUEST["CmbLeyes"])?$_REQUEST["CmbLeyes"]:"";
	$CmbUnidad      = isset($_REQUEST["CmbUnidad"])?$_REQUEST["CmbUnidad"]:"";
	$Signo          = isset($_REQUEST["Signo"])?$_REQUEST["Signo"]:"";
	$ValoresMOD     = isset($_REQUEST["ValoresMOD"])?$_REQUEST["ValoresMOD"]:"";
	$CantidadLeyes  = isset($_REQUEST["CantidadLeyes"])?$_REQUEST["CantidadLeyes"]:"";

	//$CmbProductos2 = $_REQUEST["CmbProductos2"];
	//$CmbSubProducto2 = $_REQUEST["CmbSubProducto2"];

if($Opcion=='N')
{
	$Consulta="select * from cal_web.clasificacion_metodos_plasma where cod_producto='".$CmbProductos."' and cod_subproducto='".$CmbSubProducto."' and cod_leyes='".$CmbLeyes."' and cod_unidad='".$CmbUnidad."' and signo='".$Signo."' and valor='".str_replace(',','.',$Valor)."'";
	$Resp=mysqli_query($link, $Consulta);
	if(!$Fila=mysqli_fetch_assoc($Resp))
	{
		$Inserta="insert into cal_web.clasificacion_metodos_plasma values ('".$CmbProductos."','".$CmbSubProducto."','".$CmbLeyes."','".$CmbUnidad."','".$Signo."','".str_replace(',','.',$Valor)."')";
		mysqli_query($link, $Inserta);
		?>
		<script language="javascript">
		location.replace("cal_clasificacion_metodos_plasma_proceso.php?Msj=G&Opc=N&CmbProductos=<?php echo $CmbProductos;?>&CmbSubProducto=<?php echo $CmbSubProducto;?>");
		</script>
		
		<?php
		//echo "Ingresa 1";
	}
	else
	{
		//echo "Ingresa 2";
		$ValoresMOD=$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."~".$Fila["cod_unidad"]."~".$Fila["signo"]."~".$Fila["valor"];
		header('location:cal_clasificacion_metodos_plasma_proceso.php?Msj=Exis&Opc=M&Valores='.$ValoresMOD);	
	}		
}
if($Opcion=='M')
{
	$Valores2 = $_REQUEST["Valores2"];
	
	$DatosWhere=explode('~',$ValoresMOD);
    $CmbProductos2=$DatosWhere[0];
    $CmbSubProductos2=$DatosWhere[1];
    $Unidad=$DatosWhere[2];
    $Signo2=$DatosWhere[3];
    $Valor2=$DatosWhere[4];
	$Datos=explode('//',$Valores2);
	//while(list($c,$v)=each($Datos))
	foreach($Datos as $c => $v)
	{
		$Dato=explode('~',$v);
		$Actualiza="update cal_web.clasificacion_metodos_plasma set valor='".str_replace(',','.',$Dato[3])."' where cod_producto='".$CmbProductos2."' and cod_subproducto='".$CmbSubProductos2."' and cod_leyes='".$Dato[2]."' and cod_unidad='".$Unidad."' and signo='".$Signo2."' and valor='".$Valor2."'";
		mysqli_query($link, $Actualiza);
	}
	header('location:cal_clasificacion_metodos_plasma_proceso.php?Msj=M&Opc=M&Valores='.$ValoresMOD);	
}
if($Opcion=='E')
{
	$Dato=explode('~',$Valor);
	$Elimina="delete from cal_web.clasificacion_metodos_plasma where cod_producto='".$Dato[0]."' and cod_subproducto='".$Dato[1]."' and cod_leyes='".$Dato[2]."' and cod_unidad='".$Dato[3]."' and signo='".$Dato[4]."' and valor='".$Dato[5]."'";
	mysqli_query($link, $Elimina);
	
	if($CantidadLeyes=='1')
	{
	?>
	<script language="javascript">
	window.opener.document.MetodoPLasma.action="cal_clasificacion_metodos_plasma.php?Buscar=S&Msj=E";
	window.opener.document.MetodoPLasma.submit();		
	window.close();	
	</script>
	<?php
	}
	else
		header('location:cal_clasificacion_metodos_plasma_proceso.php?Msj=E&Opc=M&Valores='.$ValoresMOD);	
}
?>