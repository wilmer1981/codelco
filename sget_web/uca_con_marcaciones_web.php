<? 
	include("../principal/conectar_sget_web.php");
	$FechaP = date("Y-m-d H:i:s");
?>
<html>
<head>
<title>Consulta de Marcaciones</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			window.location="uca_con_marcaciones.php";
			break
	}
}
function Resumen()
{
	window.open("uca_con_marcaciones_web_resumen.php","","top=30,left=30,width=550,height=350,scrollbars=yes,resizable=yes");
}
</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<table width="600" border="1" align="center" cellpadding="3" cellspacing="0" class="tablainterior">
  <tr align="center" bgcolor="#FFFFFF">
    <td colspan="2" class="Detalle01"><em>CONSULTA DE MARCACIONES&nbsp;&nbsp;&nbsp;&nbsp;Fecha Proc:&nbsp;<? echo $FechaP;?></em></td>
  </tr>
  <tr>
    <td class="Detalle02">&gt;&gt;Fecha: </td>
    <td align="left"><? echo substr($TxtFechaIni,8,2)."/".substr($TxtFechaIni,5,2)."/".substr($TxtFechaIni,0,4);
						echo " al ".substr($TxtFechaFin,8,2)."/".substr($TxtFechaFin,5,2)."/".substr($TxtFechaFin,0,4) ?>
</td>
  </tr>
  <tr>
    <td class="Detalle02">&gt;&gt;Empresa:</td>
    <td align="left"><?
				if ($CmbEmpresa=="S")
				{
					echo "TODAS";
				}
				else
				{	
					$Consulta = "SELECT * from sget_contratistas  ";
					$Consulta.= " where rut_empresa='".$CmbEmpresa."'";
					//echo $Consulta;
					$Resp=mysqli_query($link, $Consulta); 
					if ($Fila=mysql_fetch_array($Resp)) 
					{ 
						echo $Fila["rut_empresa"]." - ".strtoupper($Fila["razon_social"]);
					}
				}
			  ?></td>
  </tr>
  <tr>
    <td class="Detalle02">&gt;&gt;Contrato:</td>
    <td align="left">
        <?
				
				if ($CmbContrato=="S")		
				{
					echo "TODOS";
				}
				else
				{
					$FechaActual=date("Y")."-".date("m")."-".date("d");
					$Consulta = "SELECT * from sget_contratos t1  ";
					//$Consulta.= " where rut_empresa='".$CmbEmpresa."' ";
					//$Consulta.= " and cod_contrato='".$CmbContrato."' ";
					$Consulta.= " where cod_contrato='".$CmbContrato."' ";
					$Consulta.= " order by cod_contrato asc";
					//echo $Consulta;
					$Resp=mysqli_query($link, $Consulta); 
					if ($Fila=mysql_fetch_array($Resp)) 
					{ 
						if ($FechaActual > $Fila["fecha_termino"]){
							$Estado="C";$Color="red";}
						else{
							$Estado="A";$Color="white";}
						echo $Estado." - ".$Fila["cod_contrato"];
					}
				}
			  ?>
    </td>
  </tr>
  <tr>
    <td width="100" class="Detalle02">&gt;&gt;Funcionario:</td>
    <td width="481" align="left">
        <?
				if ($CmbRut=="S")
				{
					echo "TODOS";
				}
				else
				{		
					
					$Consulta = "SELECT * from sget_personal t1  ";
					$Consulta.= " where t1.rut='".$CmbRut."' ";
					$Consulta.= " order by t1.ape_paterno, t1.ape_materno, t1.nombres";
					$Resp=mysqli_query($link, $Consulta); 
					//echo $Consulta;
					if ($Fila=mysql_fetch_array($Resp)) 
					{
						$Rut=substr($Fila["rut"],0,2).".".substr($Fila["rut"],2,3).".".substr($Fila["rut"],5,3)."-".substr($Fila["rut"],9,1);				
						$Nombre = ucwords(strtolower($Fila["ape_paterno"]." ".$Fila["ape_materno"]." ".$Fila["nombres"]));
						echo $Rut." ".$Nombre;
					}
				}
			  ?>
    </td>
  </tr>
  <tr align="center" bgcolor="#efefef">
    <td height="30" colspan="2">
      <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70" onClick="Proceso('C');" value="Imprimir">
      <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');"></td>
  </tr>
</table>
<br>
<?
	
	set_time_limit(300); 
	$Consulta = "SELECT distinct t3.rut_empresa, t1.rut, t3.razon_social from ";
	$Consulta.= " uca_web.uca_accesos_personas as t1 inner join sget_personal as t2 on t1.rut=t2.rut "; 
	$Consulta.= " inner join sget_contratistas as t3 on t2.rut_empresa=t3.rut_empresa";
	$Consulta.= " where t1.fechahora between '".$TxtFechaIni." 00:00:00' and '".$TxtFechaFin." 23:59:59' and t2.rut_empresa <> '61704000-k'";
	if ($CmbEmpresa!="S")
		$Consulta.= " and t2.rut_empresa = '".$CmbEmpresa."'";
	if ($CmbContrato!="S")
		$Consulta.= " and t2.cod_contrato = '".$CmbContrato."'";
	if ($CmbRut!="S")
		$Consulta.= " and t2.rut = '".$CmbRut."'";
	$Consulta.=" and t2.nro_tarjeta<>'00000000' and t2.estado<>'I' ";
	$Consulta.= " group by t3.razon_social";	
	$Consulta.= " order by t3.razon_social,t1.fechahora";
	//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta);
	$TotalMarcas=0;
	$TotalEntradas=0;
	$TotalSalidas=0;
	while ($Fila=mysql_fetch_array($Resp))
	{
		$TotalMarcasEmp=0;
		$TotalEntradasEmp=0;
		$TotalSalidasEmp=0;
		$RutEmp=substr($Fila["rut_empresa"],0,2).".".substr($Fila["rut_empresa"],2,3).".".substr($Fila["rut_empresa"],5,3)."-".substr($Fila["rut_empresa"],9,1);				
		echo "<table width=\"700\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"1\" class=\"TablaDetalle\">\n";
		echo "<tr align=\"center\" class=\"Detalle01\">\n";
		echo "<td colspan=\"1\">Empresa</td>\n";
		echo "<td colspan=\"6\">".$RutEmp." ".$Fila["razon_social"]."</td>\n";
		echo "</tr>\n";
		echo "<tr align='center'>\n";
		echo "<td width=\"100\" class=\"ColorTabla01\">RUT</td>\n";
		echo "<td width=\"250\" class=\"ColorTabla01\">Funcionario</td>\n";
		echo "<td width=\"100\" class=\"ColorTabla01\">Nro.Tarjeta</td>\n";
		echo "<td width=\"80\" class=\"ColorTabla01\">Fecha Hora</td>\n";
		echo "<td width=\"50\" class=\"ColorTabla01\">E/S</td>\n";
		echo "</tr>\n";
		$Consulta = "SELECT distinct t2.rut, t2.ape_paterno, t2.ape_materno, t2.nombres, t2.nro_tarjeta ";
		$Consulta.= ", t1.fechahora, t1.tipo from ";
		$Consulta.= " uca_web.uca_accesos_personas t1 inner join sget_personal t2 on t1.rut=t2.rut ";
		$Consulta.= " where t1.fechahora between '".$TxtFechaIni." 00:00:00' and '".$TxtFechaFin." 23:59:59'";
		$IdEmpresa= $Fila["rut_empresa"];
		$Consulta.= " and t2.rut_empresa = '".$IdEmpresa."'";
		if ($CmbContrato!="S")
			$Consulta.= " and t2.cod_contrato = '".$CmbContrato."'";
		if ($CmbRut!="S")
			$Consulta.= " and t2.rut = '".$CmbRut."'";
		$Consulta.=" and t2.nro_tarjeta<>'00000000' and t2.estado<>'I' ";
		$Consulta.= " order by t2.ape_paterno, t2.ape_materno, t2.nombres, t1.fechahora ";
		//echo $Consulta;
		$Resp2=mysqli_query($link, $Consulta);
		while ($Fila2=mysql_fetch_array($Resp2))
		{			
			$RutFun=substr($Fila2["rut"],0,2).".".substr($Fila2["rut"],2,3).".".substr($Fila2["rut"],5,3)."-".substr($Fila2["rut"],9,1);				
			$NombreFun = ucwords(strtolower($Fila2["ape_paterno"]." ".strtoupper(substr($Fila2["ape_materno"],0,1)).". ".$Fila2["nombres"]));									
			$Fecha=$Fila2["fechahora"];
			echo "<tr>\n";
			echo "<td bgcolor=\"#FFFFFF\" align='center'>".$RutFun."</td>\n";
			echo "<td bgcolor=\"#FFFFFF\">".$NombreFun."</td>\n";
			echo "<td bgcolor=\"#FFFFFF\" align='center'>".$Fila2["nro_tarjeta"]."</td>\n";
			echo "<td bgcolor=\"#FFFFFF\" align='center'>".$Fecha."</td>\n";
			$TipoTransaccion=$Fila2["tipo"];
			switch ($TipoTransaccion)
			{
				case 'E':
					echo "<td bgcolor=\"#FFFFFF\" align='center'>E</td>\n";
					$TotalEntradasEmp++;
					$TotalEntradas++;
					break;
				case 'S':
					echo "<td bgcolor=\"#FFFFFF\" align='center'>S</td>\n";
					$TotalSalidasEmp++;
					$TotalSalidas++;
					break;
				default:
					echo "<td bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
					break;
			}
			echo "</tr>\n";
			$TotalMarcasEmp++;						
			$TotalMarcas++;	
		}
		echo "<tr align=\"center\" bgcolor=\"#EFEFEF\">\n";
		echo "<td colspan=\"7\"><b>TOTAL EMPRESA: ".number_format($TotalMarcasEmp,0,",",".")." MARCADAS, ".number_format($TotalEntradasEmp,0,",",".")." ENTRADAS, ".number_format($TotalSalidasEmp,0,",",".")." SALIDAS</b></td>\n";
		echo "</tr>\n";
	}
	echo "<tr align=\"center\" bgcolor=\"#EFEFEF\">\n";
	echo "<td colspan=\"7\"><b>TOTAL ".number_format($TotalMarcas,0,",",".")." MARCADAS, ".number_format($TotalEntradas,0,",",".")." ENTRADAS, ".number_format($TotalSalidas,0,",",".")." SALIDAS</b></td>\n";
	echo "</tr>\n";	
?>  
</table>
</body>
</html>