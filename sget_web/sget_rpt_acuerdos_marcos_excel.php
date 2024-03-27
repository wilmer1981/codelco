<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
	
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	
?>
<html>
<head>
<title>Reporte Control Acuerdos Marcos Excel</title>
<script language="javascript" src="funciones/sget_funciones.js"></script>
</head>
<body>   
<form name="frmPrincipal" action="" method="post">
<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
<tr>
<td width="8%" class="TituloTablaVerde" align="center" rowspan="2">A�o</td>
<td width="10%" class="TituloTablaVerde" align="center" rowspan="2">Rut</td>
<td width="18%" class="TituloTablaVerde" align="center" rowspan="2">Empresa</td>
<td width="10%"class="TituloTablaVerde" align="center" rowspan="2">Contrato</td>
<!--<td width="20%" class="TituloCabecera" align="center">Descripci&oacute;n</td>-->
<td width="10%"class="TituloTablaVerde" align="center" rowspan="2">Dotac. Trab.</td>
<td width="10%"class="TituloTablaVerde" align="center" rowspan="2">Trab. Sindicaliz.</td>
<td width="10%"class="TituloTablaVerde" align="center" rowspan="2">Nombre Sindicato</td>
<td width="10%"class="TituloTablaVerde" align="center" rowspan="2">Dotaci�n Seguro Acc.</td>
<td width="10%"class="TituloTablaVerde" align="center" rowspan="2">N� P�liza Seg. Complem.</td>
<?
$Consulta="SELECT t1.nombre_subclase as nom_eva,t1.cod_subclase as cod_eva from proyecto_modernizacion.sub_clase t1 where t1.cod_clase='30014' order by cod_subclase";
//echo $Consulta."<br>";
$RespBonos=mysqli_query($link, $Consulta);
while($FilaBonos=mysql_fetch_array($RespBonos))
{
	echo "<td class='TituloTablaVerde' width='1%' colspan='2' align='center'>".$FilaBonos[nom_eva]."&nbsp;</td>";
}

?>
</tr>	
<tr>
<?
$RespBonos=mysqli_query($link, $Consulta);
while($FilaBonos=mysql_fetch_array($RespBonos))
{
	echo "<td class='TituloTablaVerde' width='1%' align='center'>Dot.</td>";
	echo "<td class='TituloTablaVerde' width='1%' align='center'>Tot.Pag</td>";
}
?>
</tr>
<?
	$Consulta="SELECT t1.cod_contrato,t1.ano,t2.descripcion,t2.rut_empresa ";
	$Consulta.=" from sget_bonos_contratistas t1  inner join sget_contratos t2  on t1.cod_contrato=t2.cod_contrato ";
	$Consulta.=" left join  sget_administrador_contratos t3  on t2.rut_adm_contrato=t3.rut_adm_contrato ";
	$Consulta.="  where t1.cod_contrato<>'' ";
	if($TxtContrato!='')
		$Consulta.= " and upper(t1.cod_contrato) like ('%".strtoupper(trim($TxtContrato))."%') ";
	if($TxtDescripcion!='')
		$Consulta.= " and upper(t2.descripcion) like ('%".strtoupper(trim($TxtDescripcion))."%') ";
	if($CmbAno!= "T")
		$Consulta.="  and  t1.ano='".$CmbAno."' ";
	$Consulta.=" group by t1.cod_contrato,t1.ano";	
	$RespCtto=mysqli_query($link, $Consulta);
	while($FilaCtto=mysql_fetch_array($RespCtto))
	{
		$A�o=$FilaCtto["ano"];
		$Contrato=$FilaCtto["cod_contrato"];
		$Descripcion=$FilaCtto["descripcion"];
		$RutEmp=$FilaCtto[rut_empresa];
		$DescripEmp=DescripcionRazonSocial($RutEmp);
	    ?>
		<tr>
		<td align="center"><? echo $A�o;?></td>
		<td align="left"><? echo FormatearRun($RutEmp); ?>&nbsp;</td>
		<td><? echo FormatearNombre($DescripEmp); ?>&nbsp;</td>
		<td><? echo $FilaCtto["cod_contrato"]; ?>&nbsp;</td>
		<td align="center"><? echo PersonasBonosCttoAnual($Contrato,$A�o);?>&nbsp;</td>
		<td align="center"><? echo PersonasSindicalizCtto($Contrato);?>&nbsp;</td>
		<td align="center"><? echo SindicatosCtto($Contrato);?>&nbsp;</td>
		<td align="center"><? echo DotacionSegAcc($Contrato);?>&nbsp;</td>
		<td align="center"><? echo NumPolizaCtto($Contrato);?>&nbsp;</td>
		<?
		$Consulta="SELECT t1.nombre_subclase as nom_eva,t1.cod_subclase as cod_eva from proyecto_modernizacion.sub_clase t1 where t1.cod_clase='30014' order by cod_subclase";
		//echo $Consulta."<br>";
		$RespBonos=mysqli_query($link, $Consulta);
		while($FilaBonos=mysql_fetch_array($RespBonos))
		{
			$Consulta="SELECT ifnull(count(*),0) as cant,ifnull(sum(monto),0) as monto from sget_bonos_contratistas where cod_contrato='".$FilaCtto["cod_contrato"]."' and num_bono='".$FilaBonos[cod_eva]."' and ano='".$FilaCtto["ano"]."' group by cod_contrato";
			//echo $Consulta."<br>";
			$Resp2=mysqli_query($link, $Consulta);
			if($Fila2=mysql_fetch_array($Resp2))
			{
				echo "<td align='center'>".$Fila2["cant"]."&nbsp;</td>";
				echo "<td align='center'>".$Fila2[monto]."&nbsp;</td>";	
			}
			else
			{
				echo "<td align='center'>&nbsp;</td>";
				echo "<td align='center'>&nbsp;</td>";	
			}
		}
		?>
		</tr>
		<?
	}
	?>
	</table>
</form>
</body>
</html>