<?  header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
    $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

?>
<html>
<head>
<title>Reporte Documentaci�n Factura Excel</title>
<body>
<form name="frmPrincipal" action="" method="post">
<table border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td width="80" rowspan="3" align="center" class="TituloTablaVerde">Rut</td>
            <td width="120" rowspan="3" align="center" class="TituloTablaVerde">Empresa Contratita </td>
            <td width="80" rowspan="3" align="center" class="TituloTablaVerde">N&ordm; de Contrato </td>
            <td width="80" rowspan="3" align="center" class="TituloTablaVerde">Inicio</td>
            <td width="80" rowspan="3" align="center" class="TituloTablaVerde">T&eacute;rmino</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Enero</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Febrero</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Marzo</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Abril</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Mayo</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Junio</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Julio</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Agosto</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Septiembre</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Octubre</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Noviembre</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Diciembre</td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Documentaci&oacute;n</td>
            <td colspan="2" class="TituloTablaVerdeActiva">Factura</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Documentaci&oacute;n</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Factura</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Documentaci&oacute;n</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Factura</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Documentaci&oacute;n</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Factura</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Documentaci&oacute;n</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Factura</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Documentaci&oacute;n</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Factura</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Documentaci&oacute;n</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Factura</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Documentaci&oacute;n</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Factura</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Documentaci&oacute;n</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Factura</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Documentaci&oacute;n</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Factura</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Documentaci&oacute;n</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Factura</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Documentaci&oacute;n</td>
            <td colspan="2" align="center" class="TituloTablaVerdeActiva">Factura</td>
          </tr>
          <tr>
            <?
			for($i=1;$i<=12;$i++)
			{
			?>
			<td width="80" align="center" class="TituloTablaNaranja">Fecha Ingreso </td>
            <td width="50" align="center" class="TituloTablaNaranja">Dotac.</td>
            <td width="50" align="center" class="TituloTablaNaranja">N&ordm;</td>
            <td width="80" align="center" class="TituloTablaNaranja">Fecha Liberada </td>
			<?
			}
			?>
          </tr>
		  <?
		$Consulta=" SELECT t1.cod_contrato,t2.fecha_inicio,t2.fecha_termino,t3.rut_empresa,t3.razon_social from sget_facturas_contrato t1 ";
		$Consulta.=" inner join sget_contratos t2  on t1.cod_contrato=t2.cod_contrato  inner join sget_contratistas t3 ";
		$Consulta.=" on t2.rut_empresa=t3.rut_empresa where t1.cod_contrato<>''";
		if($CmbEmpresa!='-1')
			$Consulta.= " and t2.rut_empresa= '".$CmbEmpresa."'";
		if($TxtContrato!='')
			$Consulta.= " and upper(t1.cod_contrato) like ('%".strtoupper(trim($TxtContrato))."%') ";
		if($CmbAnoDF!='T')
			$Consulta.= " and t1.ano= '".$CmbAnoDF."'";
		if($TxtFingrD!=''&&$TxtFingrF!='' )
			$Consulta.="  and  t1.fecha_ing_doc between '".$TxtFingrD."' and '".$TxtFingrF."'";
		if($TxtFcontD!=''&&$TxtFcontF!='' )
			$Consulta.="  and  t1.fecha_ing_cont between '".$TxtFcontD."' and '".$TxtFcontF."'";		
		if($TxtFlibD!=''&&$TxtFlibF!='' )
			$Consulta.="  and  t1.fecha_liber between '".$TxtFlibD."' and '".$TxtFlibF."'";
		$Consulta.=" group by t1.cod_contrato,t1.ano order by t3.rut_empresa,t1.cod_contrato,t1.ano,t1.mes";
		//echo $Consulta;
		$RespMod=mysqli_query($link, $Consulta);
		$Cont=1;
		while($FilaMod=mysql_fetch_array($RespMod))
		{
			$Consulta=" SELECT count(*) as mayor from sget_facturas_contrato t1 ";
			$Consulta.=" inner join sget_contratos t2  on t1.cod_contrato=t2.cod_contrato  inner join sget_contratistas t3 ";
			$Consulta.=" on t2.rut_empresa=t3.rut_empresa where t1.cod_contrato='".$FilaMod["cod_contrato"]."' and t1.ano= '".$CmbAnoDF."'";
			if($TxtFingrD!=''&&$TxtFingrF!='' )
				$Consulta.="  and  t1.fecha_ing_doc between '".$TxtFingrD."' and '".$TxtFingrF."'";
			if($TxtFcontD!=''&&$TxtFcontF!='' )
				$Consulta.="  and  t1.fecha_ing_cont between '".$TxtFcontD."' and '".$TxtFcontF."'";		
			if($TxtFlibD!=''&&$TxtFlibF!='' )
				$Consulta.="  and  t1.fecha_liber between '".$TxtFlibD."' and '".$TxtFlibF."'";
			$Consulta.=" group by t1.cod_contrato,t1.ano,t1.mes order by mayor desc limit 1";
			//echo $Consulta;
			$RespCant=mysqli_query($link, $Consulta);
			$FilaCant=mysql_fetch_array($RespCant);
			$CantFactMes=$FilaCant["mayor"];
			echo "<tr>";
			echo "<td>".$FilaMod[rut_empresa]."</td>";
			echo "<td>".$FilaMod[razon_social]."</td>";
			echo "<td>".$FilaMod["cod_contrato"]."</td>";
			echo "<td>".$FilaMod[fecha_inicio]."</td>";
			echo "<td>".$FilaMod[fecha_termino]."</td>";
			for($i=1;$i<=12;$i++)
			{
				echo "<td colspan='4'>";
				$Consulta=" SELECT nro_factura,dotacion,fecha_ing_doc,fecha_liber from sget_facturas_contrato t1 ";
				$Consulta.=" inner join sget_contratos t2  on t1.cod_contrato=t2.cod_contrato  inner join sget_contratistas t3 ";
				$Consulta.=" on t2.rut_empresa=t3.rut_empresa where t1.cod_contrato='".$FilaMod["cod_contrato"]."' and t1.ano= '".$CmbAnoDF."' and t1.mes='".$i."' ";
				if($TxtFingrD!=''&&$TxtFingrF!='' )
					$Consulta.="  and  t1.fecha_ing_doc between '".$TxtFingrD."' and '".$TxtFingrF."'";
				if($TxtFcontD!=''&&$TxtFcontF!='' )
					$Consulta.="  and  t1.fecha_ing_cont between '".$TxtFcontD."' and '".$TxtFcontF."'";		
				if($TxtFlibD!=''&&$TxtFlibF!='' )
					$Consulta.="  and  t1.fecha_liber between '".$TxtFlibD."' and '".$TxtFlibF."'";
				$RespFact=mysqli_query($link, $Consulta);$Entro='N';$Cont=0;
				echo "<table border='1' align='center' cellpadding='0'  cellspacing='0' >";
				while($FilaFact=mysql_fetch_array($RespFact))
				{
					echo "<tr>";
					echo "<td width='80' align='center'>".$FilaFact[fecha_ing_doc]."</td>";
					echo "<td width='50' align='right'>".$FilaFact[dotacion]."</td>";
					echo "<td width='50'>".$FilaFact[nro_factura]."</td>";
					echo "<td width='80' align='center'>".$FilaFact[fecha_liber]."</td>";
					echo "</tr>";
					$Entro='S';
					$Cont++;
				}
				for($k=$Cont;$k<$CantFactMes;$k++)
				{
					//if($Entro=='N')
					//{
						echo "<tr>";
						echo "<td width='80'>&nbsp;</td>";
						echo "<td width='50'>&nbsp;</td>";
						echo "<td width='50'>&nbsp;</td>";
						echo "<td width='80'>&nbsp;</td>";
						echo "</tr>";
					//}	
				}
				echo "</table>";
				echo "</td>";
			}
			echo "</tr>";
		}  
		 ?>
        </table>
</form>
</body>
</html>