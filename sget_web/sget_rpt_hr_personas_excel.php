<?
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
<title>Reporte personas por hoja de Ruta Excel</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td width="8%" align="center" class="TituloTablaVerde">Hoja Ruta </td>
      <td width="11%" align="center" class="TituloTablaVerde">Fecha Ingreso </td>
      <td width="9%" align="center" class="TituloTablaVerde">Contrato</td>
      <td width="17%" align="center" class="TituloTablaVerde">Empresa</td>
      <td width="17%" align="center" class="TituloTablaVerde">Adm.Codelco</td>
      <td width="14%" align="center" class="TituloTablaVerde">Adm.Contratista</td>
      <td width="13%" align="center" class="TituloTablaVerde">Cant.Pers</td>
    </tr>
    <?
$Buscar='S';
if($Buscar=='S')
{
	$Consulta = "SELECT t1.num_hoja_ruta,t1.fecha_ingreso,t1.rut_empresa,t3.razon_social,t1.cod_contrato,t4.descripcion,count(t2.rut_personal) as cant_personas FROM sget_hoja_ruta t1 ";
	$Consulta.="inner join sget_hoja_ruta_nomina t2 on t1.num_hoja_ruta=t2.num_hoja_ruta INNER JOIN sget_contratistas t3 on t1.rut_empresa=t3.rut_empresa INNER JOIN sget_contratos t4 on t1.cod_contrato=t4.cod_contrato ";
	$Consulta.="WHERE t1.fecha_ingreso between '".$TxtFechaInicio."' and '".$TxtFechaTermino."' AND t1.cod_estado_aprobado IN ('14', '7') ";
	$Consulta.="and not isnull(t1.num_hoja_ruta)  ";
	if($CmbEmpresa!='T')
		$Consulta.=" and  t1.rut_empresa='".$CmbEmpresa."' ";
	if($CmbContrato!='S')
		$Consulta.=" and  t1.cod_contrato='".$CmbContrato."' ";
	$Consulta.="group by t1.num_hoja_ruta ORDER BY t1.num_hoja_ruta DESC";	
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);$TotPers=0;
	$cont=1;
	while ($Fila_HR=mysql_fetch_array($Resp))
	{
		?>
    <tr>
      <td ><? echo $Fila_HR["num_hoja_ruta"]."&nbsp;"; ?></td>
      <td ><? echo substr($Fila_HR["fecha_ingreso"],0,10)."&nbsp;"; ?>&nbsp;</td>
      <td ><? 
	  		$DescCtto=DescripCtto($Fila_HR["cod_contrato"]);
			$DescCtto=explode('~',$DescCtto);
			echo $Fila_HR["cod_contrato"]." - ".FormatearNombre($DescCtto[1]); ?></td>
      <td ><? 
		    $RazonSoc=DescripcionRazonSocial($Fila_HR["rut_empresa"]);
		  	echo $Fila_HR["rut_empresa"]." - ".FormatearNombre($RazonSoc)."&nbsp;"; ?></td>
      <td ><?
		   	$VarCodelco=AdmCttoCodelco($Fila_HR["cod_contrato"]);
		   	$array=explode('~',$VarCodelco);
		   	echo FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
	   		?></td>
      <td ><? 
		  	$VarContratista=AdmCttoContratista($Fila_HR["cod_contrato"]);
	  	 	$array=explode('~',$VarContratista);
	   	 	echo FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
		  	?></td>
      <?
	  $TotPers=$TotPers+intval($Fila_HR[cant_personas]);
	  ?>
      <td><? echo $Fila_HR[cant_personas];?></td>
    </tr>
    <?		
  		$cont++;
	}
}
?>
   <tr>
    <td class="TituloTablaVerde" colspan="6" align="right">Total Personas</td>
    <td class="TituloTablaVerde" align="right"><? echo number_format($TotPers,0,'','.');?></td>
  </tr>
  </table>
  <br>
</form>
</body>
</html>