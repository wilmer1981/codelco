<? 
	include("../principal/conectar_sget_web.php");
	$CantDias=date("t", mktime(0,0,0,$Mes,1,$Ano));	
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
			window.location="uca_con_estadisticas.php";
			break
	}
}
function MostrarCapa(opcion, capa)
{		
	if (opcion=="M")
		eval(capa+".style.visibility='visible';");
	else
		eval(capa+".style.visibility='hidden';");
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
    <td colspan="2" class="Detalle01"><em>ESTADISTICAS DE MARCADAS </em></td>
  </tr>
  <tr>
    <td class="Detalle02">&gt;&gt;Fecha: </td>
    <td align="left"><? echo "01/".str_pad($Mes,2,'0',STR_PAD_LEFT)."/".$Ano;
						echo " al ".$CantDias."/".str_pad($Mes,2,'0',STR_PAD_LEFT)."/".$Ano; ?></td>
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
					$Resp=mysql_query($Consulta); 
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
					$FechaActual=date("Y").date("m").date("d");
					$Consulta = "SELECT * from sget_contratos t1  ";
					//$Consulta.= " where rut_empresa='".$CmbEmpresa."' ";
					//$Consulta.= " and cod_contrato='".$CmbContrato."' ";
					$Consulta.= " where cod_contrato='".$CmbContrato."' ";
					$Consulta.= " order by cod_contrato asc";
					$Resp=mysql_query($Consulta); 
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
					$Resp=mysql_query($Consulta); 
					if ($Fila=mysql_fetch_array($Resp)) 
					{
						$Rut=substr($Fila["rut"],1,2).".".substr($Fila["rut"],2,3).".".substr($Fila["rut"],5,3)."-".substr($Fila["rut"],9,1);				
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
	//$Eliminar="DROP TABLE TEMP_FUNCIONARIOS ";
	//mssql_query($Eliminar);
	
	/*$result = mssql_SELECT_db("finger");
	$i = 0;
	while ($i < msql_numrows($result)) {
		$tb_names[$i] = msql_tablename($result, $i);
		echo $tb_names[$i] . "<BR>";
		$i++; 
	}*/
	set_time_limit(300); 
	//CREA TABLA TEMPORAL DE LOS FUNCINOARIOS
	/*$Consulta = "SELECT Fun_Runfun, Fun_Apepat, Fun_Apemat, Fun_Nombre, ";
	$Consulta.= " convert(char(4),convert(numeric,Fun_PinEnr)) as Fun_PinEnr, Fun_Numemp, Fun_Numctr ";
	$Consulta.= " INTO TEMP_FUNCIONARIOS ";
	$Consulta.= " from FUNCIONARIOS ";
	$Consulta.= " order by Fun_Apepat, Fun_Apemat, Fun_Nombre ";
	mssql_query($Consulta);
	//CREAR INDICE
	$Consulta = "create index Ind01 on TEMP_FUNCIONARIOS (Fun_PinEnr ASC)";
	mssql_query($Consulta);*/
	//
?>
<table width="1500" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999" class="TablaDetalle">
<tr class="ColorTabla01">
    <td  rowspan="3" width="130">Empresa / Dias </td>
    <td  rowspan="3" width="100">Contrato</td>
    <?
	$NomDias=array("D","L","M","M","J","V","S");
	$FechaIni=$Ano."-".str_pad($Mes,2,'0',STR_PAD_LEFT)."-01";
	$FechaFin=$Ano."-".str_pad($Mes,2,'0',STR_PAD_LEFT)."-".str_pad($CantDias,2,'0',STR_PAD_LEFT);
	$IniCont=$Ano.str_pad($Mes,2,'0',STR_PAD_LEFT)."01";
	$FinCont=$Ano.str_pad($Mes,2,'0',STR_PAD_LEFT).str_pad($CantDias,2,'0',STR_PAD_LEFT);
	for ($i=1;$i<=$CantDias;$i++)
	{		
		$NumDia=date("w", mktime(0,0,0,$Mes,$i,$Ano));
    	echo "<td width=\"40\" colspan=\"2\" align=\"center\" class=\"Detalle01\">".$NomDias[$NumDia]."</td>\n";
	} 
	echo "<td width=\"40\" rowspan=\"2\" colspan=\"2\" align=\"center\">TOTAL</td>\n";   
?>	
  </tr>
  <tr class="ColorTabla01">
<?	
	for ($i=1;$i<=$CantDias;$i++)
	{
    	echo "<td colspan=\"2\" align=\"center\">".$i."</td>\n";
	} 
?>	
  </tr>
  <tr class="ColorTabla01">
<?
	for ($i=1;$i<=$CantDias;$i++)
	{
    	echo "<td align=\"center\">E</td>\n";
		echo "<td align=\"center\">S</td>\n";
	} 
	echo "<td align=\"center\">E</td>\n";
	echo "<td align=\"center\">S</td>\n";   
?>	
  </tr>
<?

	$Consulta = "SELECT distinct t3.rut_empresa, t3.razon_social, ";
	$Consulta.= " t2.cod_contrato, t4.cod_contrato, t4.descripcion";
	$Consulta.= " from ";
	$Consulta.= " uca_web.uca_accesos_personas as t1 inner join sget_personal as t2 on t1.rut=t2.rut "; 
	$Consulta.= " inner join sget_contratistas as t3 on t2.rut_empresa=t3.rut_empresa ";
	$Consulta.= " inner join sget_contratos as t4 on t2.cod_contrato=t4.cod_contrato";
	$Consulta.= " where t1.fechahora between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' and t2.nro_tarjeta<>'00000000'";
	if ($CmbEmpresa!="S")
		$Consulta.= " and t2.rut_empresa = '".$CmbEmpresa."'";
	if ($CmbContrato!="S")
		$Consulta.= " and t2.cod_contrato = '".$CmbContrato."'";
	if ($CmbRut!="S")
		$Consulta.= " and t2.rut = '".$CmbRut."'";
	$Consulta.= " order by t3.razon_social, t2.cod_contrato ";
	//echo $Consulta."<br>";
	$Resp=mysql_query($Consulta);
	$TotalMarcas=0;
	$TotalEntradas=0;
	$TotalSalidas=0;
	//RESETEA ARREGLO DE TOTALES
	$ArrTotales=array();
	for ($i=1;$i<=$CantDias;$i++)
	{
		$ArrTotales[$i]["entradas"]=0;
		$ArrTotales[$i]["salidas"]=0;
	}
	while ($Fila=mysql_fetch_array($Resp))
	{  
		$TotalMesEntradasEmp=0;
		$TotalMesSalidasEmp=0;
		$RutEmp=substr($Fila["rut_empresa"],1,2).".".substr($Fila["rut_empresa"],2,3).".".substr($Fila["rut_empresa"],5,3)."-".substr($Fila["rut_empresa"],9,1);					
		echo "<tr bgcolor=\"#FFFFFF\">\n";
		echo "<td class=\"Detalle01\">".substr($Fila["razon_social"],0,20)."</td>\n";
		echo "<td class=\"Detalle01\" onMouseOver=\"MostrarCapa('M','Capa".$Fila["rut_empresa"]."_".$Fila["cod_contrato"]."')\" onMouseOut=\"MostrarCapa('O','Capa".$Fila["rut_empresa"]."_".$Fila["cod_contrato"]."')\">";
		echo "<div Id=\"Capa".$Fila["rut_empresa"]."_".$Fila["cod_contrato"]."\" style=\"position:absolute; width:470px; height:15px; z-index:1; background-color: #FFCC99; border: solid 1px #000000; visibility: hidden;\">";
		echo "<font >".$Fila["descripcion"]."</font>";
		echo "</div>";
		echo substr($Fila["cod_contrato"],0,20)."</td>\n";
		//CALCULA EL TOTAL DE ENTRADAS Y TOTAL DE SALIDAS
		$FechaConsIni=$Ano.str_pad($Mes,2,'0',STR_PAD_LEFT).str_pad($i,2,'0',STR_PAD_LEFT)."00000000";
		$FechaConsFin=$Ano.str_pad($Mes,2,'0',STR_PAD_LEFT).str_pad($i,2,'0',STR_PAD_LEFT)."23595959";
		//RESETEA ARREGLO DE EMPRESA
		$ArrDias=array();
		for ($i=1;$i<=$CantDias;$i++)
		{
			$ArrDias[$i]["entradas"]=0;
			$ArrDias[$i]["salidas"]=0;
		}
		//------------------------------------ENTRADAS------------------------------------
		//
		$Consulta = "SELECT count(*) as entradas, t1.fechahora  ";
		$Consulta.= " from uca_web.uca_accesos_personas t1 inner join sget_personal t2 on t1.rut=t2.rut ";
		$Consulta.= " where t1.fechahora between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' and t2.nro_tarjeta<>'00000000'";
		$IdEmpresa= $Fila["rut_empresa"];
		$Consulta.= " and t2.rut_empresa = '".$IdEmpresa."' and t1.tipo ='E'";
		if ($CmbContrato=="S")
			$Consulta.= " and t2.cod_contrato = '".$Fila["cod_contrato"]."'";
		else
			$Consulta.= " and t2.cod_contrato = '".$CmbContrato."'";
		if ($CmbRut!="S")
			$Consulta.= " and t2.rut = '".$CmbRut."'";			
		$Consulta.= "group by t1.fechahora";
		//echo $Consulta;
		$Resp2=mysql_query($Consulta);						
		while ($Fila2=mysql_fetch_array($Resp2))
		{
			$Dia=intval(substr($Fila2["fechahora"],8,2));
			$ArrDias[$Dia]["entradas"]=$ArrDias[$Dia]["entradas"] + $Fila2["entradas"];
		}
		//------------------------------------SALIDAS-----------------------------------------------
		//
		$Consulta = "SELECT count(*) as salidas, t1.fechahora  ";
		$Consulta.= " from uca_web.uca_accesos_personas t1 inner join sget_personal t2 on t1.rut=t2.rut ";
		$Consulta.= " where t1.fechahora between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' and t2.nro_tarjeta<>'00000000'";
		$IdEmpresa= $Fila["rut_empresa"];
		$Consulta.= " and t2.rut_empresa = '".$IdEmpresa."' and t1.tipo ='S'";
		if ($CmbContrato=="S")
			$Consulta.= " and t2.cod_contrato = '".$Fila["cod_contrato"]."'";
		else
			$Consulta.= " and t2.cod_contrato = '".$CmbContrato."'";
		if ($CmbRut!="S")
			$Consulta.= " and t2.rut = '".$CmbRut."'";			
		$Consulta.= "group by t1.fechahora";
		//echo $Consulta."<br>";
		$Resp2=mysql_query($Consulta);						
		while ($Fila2=mysql_fetch_array($Resp2))
		{
			$Dia=intval(substr($Fila2["fechahora"],8,2));
			$ArrDias[$Dia]["salidas"]=$ArrDias[$Dia]["salidas"] + $Fila2["salidas"];
		}
		//------------------
		$Color="#FFFFFF";					
		reset($ArrDias);
		while (list($k,$v)=each($ArrDias))
		{
			if ($Color=="#FFFFFF")
				$Color="#CCCCCC";
			else
				$Color="#FFFFFF";
				
			$NumDia=date("w", mktime(0,0,0,$Mes,$k,$Ano));
			if ($NumDia==0)
				$Color="#FFCC00";

			if ($v["entradas"]==0)
				echo "<td bgcolor=\"".$Color."\" align=\"center\">&nbsp;</td>\n";//ENTRADAS
			else
				echo "<td bgcolor=\"".$Color."\" align=\"center\">".$v["entradas"]."</td>\n";//ENTRADAS
			if ($v["salidas"]==0)
				echo "<td bgcolor=\"".$Color."\" align=\"center\">&nbsp;</td>\n";//SALIDAS
			else
				echo "<td bgcolor=\"".$Color."\" align=\"center\">".$v["salidas"]."</td>\n";//SALIDAS
			$TotalMesEntradasEmp=$TotalMesEntradasEmp+$v["entradas"];
			$TotalMesSalidasEmp=$TotalMesSalidasEmp+$v["salidas"];
			$ArrTotales[$k]["entradas"]=$ArrTotales[$k]["entradas"] + $v["entradas"];
			$ArrTotales[$k]["salidas"]=$ArrTotales[$k]["salidas"] + $v["salidas"];
		}		
		echo "<td bgcolor=\"yellow\" align=\"center\">".number_format($TotalMesEntradasEmp,0,',','.')."</td>\n";//ENTRADAS
		echo "<td bgcolor=\"yellow\" align=\"center\">".number_format($TotalMesSalidasEmp,0,',','.')."</td>\n";//SALIDAS
		echo "</tr>\n";
	}
?>	
  <tr bgcolor="#FFFFFF">
    <td colspan="2" class="Detalle01">TOTAL</td>
<?
	$Color="#FFFFFF";		
	reset($ArrTotales);
	$TotalMesEntradas=0;
	$TotalMesSalidas=0;
	while (list($k,$v)=each($ArrTotales))
	{
		if ($Color=="#FFFFFF")
				$Color="#CCCCCC";
			else
				$Color="#FFFFFF";
		
		$NumDia=date("w", mktime(0,0,0,$Mes,$k,$Ano));
		if ($NumDia==0)
			$Color="#FFCC00";
			
		if ($v["entradas"]==0)
			echo "<td bgcolor=\"".$Color."\" align=\"center\">&nbsp;</td>\n";//ENTRADAS
		else
			echo "<td bgcolor=\"".$Color."\" align=\"center\">".$v["entradas"]."</td>\n";//ENTRADAS
		if ($v["salidas"]==0)
			echo "<td bgcolor=\"".$Color."\" align=\"center\">&nbsp;</td>\n";//SALIDAS
		else
			echo "<td bgcolor=\"".$Color."\" align=\"center\">".$v["salidas"]."</td>\n";//SALIDAS
		$TotalMesEntradas=$TotalMesEntradas+$v["entradas"];
		$TotalMesSalidas=$TotalMesSalidas+$v["salidas"];
	}
	echo "<td bgcolor=\"yellow\" align=\"center\">".number_format($TotalMesEntradas,0,',','.')."</td>\n";//ENTRADAS
	echo "<td bgcolor=\"yellow\" align=\"center\">".number_format($TotalMesSalidas,0,',','.')."</td>\n";//SALIDAS 
?>	
  </tr>
</table>
</table>
</body>
</html>