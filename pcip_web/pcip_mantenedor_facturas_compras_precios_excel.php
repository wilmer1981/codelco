<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
?>
<html>
<head>
<title>Precios Metales </title>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<table width="930" border="1" cellpadding="4" cellspacing="0" >
  <tr align="center">
    <td width="11%">A&ntilde;o</td>
    <td width="11%">Mes</td>
    <td width="34%">Fino</td>
    <td width="25%">Valor</td>
    <td width="12%">Unidad</td>
	<?
	 if($Checkeado!='') 
	 {
		?>
		 <td width="25%">Valor</td>
		 <td width="12%">Unidad</td>
		<? 
	 } 
	?>  
  </tr>
  <?
 $Buscar='S'; 
if($Buscar=='S')
{
	$Consulta = "select t1.cod_fino,t1.ano,t1.mes,t2.nombre_subclase as nom_fino,t1.valor,t3.nombre_subclase as nom_moneda";
	$Consulta.= " from pcip_fac_compra_precios t1 inner join proyecto_modernizacion.sub_clase t2 on";
	$Consulta.= " t2.cod_clase='31012' and t1.cod_fino=t2.cod_subclase";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31001' and t1.cod_moneda=t3.cod_subclase";
	$Consulta.=" where t1.ano<>''";
		if($CmbFino!='T')
			$Consulta.=" and t1.cod_fino='".$CmbFino."'";									  
		if($Ano!='T')
			$Consulta.=" and t1.ano='".$Ano."'";
		if($Mes!='T')
			$Consulta.=" and t1.mes='".$Mes."'";
	$Consulta.= " order by t1.ano,t1.mes ";
	$Resp = mysql_query($Consulta);
	//echo $Consulta;
	echo "<input name='CheckTipoDoc' type='hidden'  value=''>";
	
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Ano =$Fila["ano"];
		$Mes =$Meses[$Fila[mes]-1];
		$Fino =$Fila["nom_fino"];
		$Valor =$Fila["valor"];		
		$CodMoneda=	$Fila["cod_moneda"];
		$Moneda =$Fila["nom_moneda"];
		$Clave =$Fila["ano"]."~".$Fila["mes"]."~".$Fila["cod_fino"];	
	    if($Checkeado!='')
	    {
			if($CodMoneda=='2')
		   {
			$ValorUS=($Valor/31.103477)*1000; 
			$MonedaUS="US$/Kg";
						
		   }
			if($CodMoneda=='1')//CODIGO DE LA TONELADA
		   {
			$ValorUS=$Valor*1000; 
			$MonedaUS="US$/Kg";			
		   }
	    }
?>
  <tr >
    <td align="center"><? echo $Ano; ?></td>
    <td align="center">&nbsp;<? echo $Mes; ?></td>
    <td >&nbsp;<? echo $Fino; ?></td>
    <td align="right"><? echo number_format($Valor,2,',','');?></td>
    <td align="center">&nbsp;<? echo $Moneda; ?></td>
		<?
		 if($Checkeado!='') 
		 {
		  if($CodMoneda=='2' || $CodMoneda=='1')
		  {
		  	echo"<td>".number_format($ValorUS,2,',','.')."</td>";
		  	echo"<td>".$MonedaUS."</td>";
		  }	
		  else
		  {
		  	echo"<td>".number_format($Valor,2,',','.')."</td>";
			echo"<td align='center'>".$Moneda."</td>";
		  }
		 }
		?>
  </tr>
  <?
	}
}	
?>
</table>
</form>
</body>
</html>
<?
	if($Mensaje=='S')
   {
?>
	<script language="javascript">
	alert("No se pueden Eliminar el dato, existen relaciones ")
	</script>
<? }?>
