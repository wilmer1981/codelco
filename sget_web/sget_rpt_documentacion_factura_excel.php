<?  header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

 $CodigoDeSistema = 27;
 $CodigoDePantalla = 7;
 if(isset($CodCtto))
 	$TxtBuscaCod=$CodCtto;
if(!isset($CmbEmpresa))
	$CmbEmpresa='-1';
?>
<html>
<head>
<title>Reporte Documentaci�n Factura</title>
<body>

<form name="frmPrincipal" action="" method="post">
		<table  border="1" >
		<?
		
		$Consulta=" SELECT t1.*,t2.fecha_inicio,t2.fecha_termino,t3.rut_empresa,t3.razon_social from sget_facturas_contrato t1 ";
		$Consulta.=" inner join sget_contratos t2  on t1.cod_contrato=t2.cod_contrato  inner join sget_contratistas t3 ";
		$Consulta.=" on t2.rut_empresa=t3.rut_empresa where t1.cod_contrato<>''";
		if($CmbEmpresa!='-1')
			$Consulta.= " and t2.rut_empresa= '".$CmbEmpresa."'";
		if($TxtContrato!='')
			$Consulta.= " and upper(t1.cod_contrato) like ('%".strtoupper(trim($TxtContrato))."%') ";
		if($CmbAnoDF!='T')
			$Consulta.= " and t1.ano= '".$CmbAnoDF."'";
		if($CmbMesDF!='T')
			$Consulta.= " and t1.mes= '".$CmbMesDF."'";
		if($TxtFingrD!=''&&$TxtFingrF!='' )
			$Consulta.="  and  t1.fecha_ing_doc between '".$TxtFingrD."' and '".$TxtFingrF."'";
		if($TxtFcontD!=''&&$TxtFcontF!='' )
			$Consulta.="  and  t1.fecha_ing_cont between '".$TxtFcontD."' and '".$TxtFcontF."'";		
		if($TxtFlibD!=''&&$TxtFlibF!='' )
			$Consulta.="  and  t1.fecha_liber between '".$TxtFlibD."' and '".$TxtFlibF."'";
		$Consulta.=" order by t3.rut_empresa,t1.cod_contrato,t1.ano,t1.mes";
		$RespMod=mysql_query($Consulta);
		echo "<input type='hidden' name='CheckCtto'>";
		$Cont=1;		$Encontro='N';
		while($FilaMod=mysql_fetch_array($RespMod))
		{
			$Contrato=$FilaMod["cod_contrato"];
			if($EmpAnt!=$FilaMod[rut_empresa])
			{
				?>
				<tr >
				<td colspan="7" >Empresa&nbsp;&nbsp;<? echo $FilaMod[rut_empresa];?>&nbsp;&nbsp;&nbsp;<? echo $FilaMod[razon_social];?></td>
				</tr>
				<?
			}
		
			if($ContratoAnt!=$FilaMod["cod_contrato"])
			{
				?>
				<tr >
				<td colspan="7" >Contrato&nbsp;&nbsp;<? echo $Contrato;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Inicio&nbsp;<? echo $FilaMod[fecha_inicio];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Termino&nbsp;<? echo $FilaMod[fecha_termino] ?>&nbsp;</td>
				</tr>
			
			  <tr>
			  <td  >A&Ntilde;O</td>
			  <td  >MES</td>
			  <td  >Nro.&nbsp;Factura </td>
			  <td  >Fecha&nbsp;Ingreso&nbsp;Contabilidad </td>
			  <td  >Fecha&nbsp;Ingreso&nbsp;Documentos </td>
			  <td  >Fecha&nbsp;Liberaci&oacute;n </td>
			  <td  >Dotaci&oacute;n</td>
			</tr>
		
				<?
				$AnoAnt='';$MesAnt='';
			}
			
			if($AnoAnt!=$FilaMod["ano"])
			{
				?>
				<tr>
				<td colspan="7"><? echo $FilaMod["ano"]."&nbsp;";?></td>
				</tr>
				<?
			}
			if($MesAnt!=$FilaMod[mes])
			{
			?>
				<tr>
				<td>&nbsp;</td>
				<td colspan="6"><? echo $meses[$FilaMod[mes]-1]."&nbsp;";?></td>
				</tr>
			<?
			}
			$EmpAnt=$FilaMod[rut_empresa];
			$ContratoAnt=$FilaMod["cod_contrato"];
			$AnoAnt=$FilaMod["ano"];
			$MesAnt=$FilaMod[mes];
			?>
		
		
		<tr>
					
			<td colspan="2">&nbsp;</td>
			<td><? echo $FilaMod[nro_factura];?>&nbsp;</td>
			<td><? echo $FilaMod[fecha_ing_cont]; ?>&nbsp;</td>
			<td><? echo $FilaMod[fecha_ing_doc]; ?>&nbsp;</td>
			<td><? echo $FilaMod[fecha_liber]; ?>&nbsp;</td>
			<td><? echo $FilaMod[dotacion]; ?>&nbsp;</td>
		</tr>
		<?
			$Cont++;
			$Encontro='S';
		}
		if($Encontro=='N')
		{?>
			<tr>
			<td colspan="7">No se encontraron Registros asociados a la consulta</td>
			</tr>
			<?
			
		}
		?></table>
	 
</form>

</body>
</html>