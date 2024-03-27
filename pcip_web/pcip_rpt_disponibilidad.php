<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');	
?>
<html>
<head>
<title>Reporte Disponibilidad</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function GenerarExcel(ctto,emp)
{
		var URL = "../sget_web/sget_genera_excel.php?Ctto="+ctto+"&Empresa="+emp;
			window.open(URL,"","top=30,left=30,width=550,height=180,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				
}

function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "C"://BUSCA DISPONIBILIDAD EQUIPOS
			if(f.CmbSistema.value=='-1')
			{
				alert('Debe Seleccionar Sistema');
				f.CmbSistema.focus();
				return;
			}
			f.action = "pcip_rpt_disponibilidad.php?Buscar=S";
			f.submit();
		break;
		case "E":
			if(f.CmbSistema.value=='-1')
			{
				alert('Debe Seleccionar Sistema');
				f.CmbSistema.focus();
				return;
			}
			URL='pcip_rpt_disponibilidad_excel.php?CmbSistema='+f.CmbSistema.value+'&CmbEquipos='+f.CmbEquipos.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;
		case "R":
			f.action = "pcip_rpt_disponibilidad.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=7";
		break;
	
	}
	
}

</script>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'disponibilidad.png')
?>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
   <td  width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
   <td>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
	<tr>
		<td width="81%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td width="19%" align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span></a><a href="JavaScript:Procesos('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Procesos('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp; <a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> <a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a></td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
  <tr>
    <td width="16%" height="17" class='formulario2'>Sistema</td>
    <td class="formulario2" >    
      <select name="CmbSistema" onChange="Procesos('R')">
        <option value="-1" selected="selected">Seleccionar</option>
        <?
	  $Consulta = "select cod_sistema,nom_sistema from pcip_eec_sistemas where vigente='S' and mostrar='S' order by nom_sistema ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbSistema==$FilaTC["cod_sistema"])
				echo "<option selected value='".$FilaTC["cod_sistema"]."'>".ucfirst(strtolower($FilaTC["nom_sistema"]))."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_sistema"]."'>".ucfirst(strtolower($FilaTC["nom_sistema"]))."</option>\n";
		}
			?>
      </select><? //echo $Consulta; ?>
    </td>
  </tr>
  <tr>
    <td width="16%" height="17" class='formulario2'>Equipos</td>
    <td class="formulario2" >    
      <select name="CmbEquipos">
        <option value="T" selected="selected">Todos</option>
        <?
	  $Consulta = "select t1.cod_equipo,t2.nom_equipo from pcip_eec_equipos_por_sistema t1 inner join pcip_eec_equipos t2 on t1.cod_equipo=t2.cod_equipo where t1.cod_sistema='".$CmbSistema."' order by t2.nom_equipo ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEquipos==$FilaTC["cod_equipo"])
				echo "<option selected value='".$FilaTC["cod_equipo"]."'>".ucfirst(strtolower($FilaTC["nom_equipo"]))."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_equipo"]."'>".ucfirst(strtolower($FilaTC["nom_equipo"]))."</option>\n";
		}
			?>
      </select><? //echo $Consulta; ?>
    </tr>
  <tr>

    <td height="25" class='formulario2'>A&ntilde;o</td>
    <td class='formulario2'><select name="Ano" id="Ano">
      <?
	for ($i=2003;$i<=date("Y");$i++)
	{
		if ($i==$Ano)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
    </select>      </tr>
  <tr>
    <td height="25" class='formulario2'>Mes </td>
    <td class='formulario2'><select name="Mes" id="Mes">
      <?
	for ($i=1;$i<=12;$i++)
	{
		if ($i==$Mes)
			echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		else
			echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
	}
?>
    </select>      </tr>
 </table>  </td>
  <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" ><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" ><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
    <br>
    <table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
        <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
        <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
        <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
      </tr>
      <tr>
        <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td width="9%">&nbsp;</td>
            <td colspan="5" align="center" class="TituloTablaVerde"><p>MES&nbsp;&nbsp;&nbsp;&nbsp;<? echo strtoupper($Meses[$Mes-1])." ".$Ano;?></p></td>
            <td colspan="5" align="center" class="TituloTablaVerde"><p>ACUMULADO&nbsp;&nbsp;&nbsp;&nbsp;<? echo strtoupper($Meses[$Mes-1])." ".$Ano;?></p></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3" align="center" class="TituloTablaVerde"><p>REAL</p></td>
            <td width="10%" align="center" class="TituloTablaVerde"><p>PROGRAMADA</p></td>
			<td rowspan="2" align="center" class="formulario2"><p>Variacion</p><p>Disponibilidad</p></td>
            <td colspan="3" align="center" class="TituloTablaVerde"><p>REAL</p></td>
            <td width="10%" align="center" class="TituloTablaVerde"><p>PROGRAMADA</p></td>
            <td rowspan="2" align="center" class="formulario2"><p>Variacion</p><p>Disponibilidad</p></td>
          </tr>
          <tr>
            <td align="center" class="formulario2"><p>EQUIPO</p></td>
            <td width="10%" align="center" class="TituloTablaVerde"><p>HORAS DISPONIBLES </p></td>
            <td width="10%" align="center" class="TituloTablaVerde"><p>HORAS REALES </p></td>
            <td width="10%" align="center" class="TituloTablaVerde"><p>DISPONIBILIDAD %</p></td>
            <td align="center" class="TituloTablaVerde"><p>DISPONIBILIDAD %</p></td>
            <td width="13%" align="center" class="TituloTablaVerde"><p>HORAS DISPONIBLES</p> </td>
            <td width="10%" align="center" class="TituloTablaVerde"><p>HORAS REALES </p></td>
            <td width="10%" align="center" class="TituloTablaVerde"><p>DISPONIBILIDAD %</p></td>
            <td align="center" class="TituloTablaVerde"><p>DISPONIBILIDAD %</p></td>
            </tr>
		  <?
		  	if($Buscar=='S')
			{
				$Consulta="select t1.cod_equipo,t2.nom_equipo from pcip_eec_equipos_por_sistema t1 inner join pcip_eec_equipos t2 on t1.cod_equipo=t2.cod_equipo where t1.cod_sistema='".$CmbSistema."' ";
				if($CmbEquipos!='T')
					$Consulta.=" and t1.cod_equipo ='".$CmbEquipos."' ";
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					//MENSUAL
					$DatosVal=explode('~',ValoresDisponibilidad('R',$Ano,$Mes,$CmbSistema,$Fila[cod_equipo],'M'));
					$HorDispM=$DatosVal[0];
					$HorRealM=$DatosVal[1];
					if($DatosVal[0]>0)
						$DispRealM=($DatosVal[1]/$DatosVal[0])*100;
					else
						$DispRealM=0;
					$Disp=$DatosVal[0]-$DatosVal[1];
					$DatosVal=explode('~',ValoresDisponibilidad('P',$Ano,$Mes,$CmbSistema,$Fila[cod_equipo],'M'));
					if($DatosVal[3]>0)
						$DispProyM=(1-($DatosVal[2]/$DatosVal[3]))*100;
					else
						$DispProyM='';	
					$VarDispM=$DispRealM-$DispProyM;
					//ACUMULADA
					$DatosVal=explode('~',ValoresDisponibilidad('R',$Ano,$Mes,$CmbSistema,$Fila[cod_equipo],'A'));
					$HorDispA=$DatosVal[0];
					$HorRealA=$DatosVal[1];
					if($DatosVal[0]>0)
						$DispRealA=($DatosVal[1]/$DatosVal[0])*100;
					else
						$DispRealA=0;	
					$Disp=$DatosVal[0]-$DatosVal[1];
					$DatosVal=explode('~',ValoresDisponibilidad('P',$Ano,$Mes,$CmbSistema,$Fila[cod_equipo],'A'));
					if($DatosVal[3]>0)
						$DispProyA=(1-($DatosVal[2]/($DatosVal[3])))*100;
					else
						$DispProyA='';	

					$VarDispA=$DispRealA-$DispProyA;
					echo "<tr>";
					echo "<td class='formulario2'>".$Fila[nom_equipo]."</td>";
					//MENSUAL
					echo "<td align='right'>".number_format($HorDispM,2,',','.')."</td>";
					echo "<td align='right'>".number_format($HorRealM,2,',','.')."</td>";
					echo "<td align='right'>".number_format($DispRealM,2,',','.')."</td>";
					echo "<td align='right'>".number_format($DispProyM,2,',','.')."</td>";
					echo "<td align='right'>".number_format($VarDispM,2,',','.')."</td>";
					//ACUMULADO
					echo "<td align='right'>".number_format($HorDispA,2,',','.')."</td>";
					echo "<td align='right'>".number_format($HorRealA,2,',','.')."</td>";
					echo "<td align='right'>".number_format($DispRealA,2,',','.')."</td>";
					echo "<td align='right'>".number_format($DispProyA,2,',','.')."</td>";
					echo "<td align='right'>".number_format($VarDispA,2,',','.')."</td>";
					echo "</tr>";
				}
			
			}
		  ?>	
        </table></td>
        <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
        <td height="15"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
        <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
      </tr>
    </table></td>
 </tr>
  </table>
	<? include("pie_pagina.php")?>

</form>
</body>
</html>
<?
function ValoresDisponibilidad($Tipo,$Ano,$Mes,$CmbSistema,$CodEquipo,$Opcion)
{
	if($Opcion=='A')
		$MesIni=1;
	else
		$MesIni=$Mes;
	$MesFin=$Mes;
	$Valor=0;$ValorReal=0;$ValorHrsMM=0;$ValorDivisor=0;
	for($i=$MesIni;$i<=$MesFin;$i++)
	{
		$Consulta="select t1.valor as valor,t1.valor_real as valor_real,t1.hrs_oper_d as valor_hrs_oper_d,t1.hrs_mant_men as valor_hrs_mant_men,t1.hrs_mant_may as valor_hrs_mant_may ";
		$Consulta.= "from pcip_eec_disponibilidades t1 where t1.tipo_disponibilidad='".$Tipo."' and t1.ano='".$Ano."' and t1.mes = '".$i."'";
		$Consulta.= " and t1.cod_sistema='".$CmbSistema."' ";
		$Consulta.= " and t1.cod_equipo='".$CodEquipo."'";
		//echo $Consulta."<br>";
		$Resp2=mysqli_query($link, $Consulta);
		while($Fila2=mysql_fetch_array($Resp2))
		{
			$Valor=$Valor+$Fila2[valor];
			$ValorReal=$ValorReal+$Fila2[valor_real];
			$ValorHrsMM=$ValorHrsMM+$Fila2[valor_hrs_mant_men];
			$DiasMes=UltimoDia($Ano,intval($i));
			$ValorDivisor=$ValorDivisor+$Fila2[valor_hrs_oper_d]*$DiasMes-($Fila2[valor_hrs_mant_may]);
		}
	}
	$Valor=$Valor."~".$ValorReal."~".$ValorHrsMM."~".$ValorDivisor;
	/*else
	{
		$MesIni=$Mes;
		$MesFin=$Mes;		
		$Consulta="select sum(t1.valor) as valor,sum(t1.valor_real) as valor_real,sum(t1.hrs_oper_d) as valor_hrs_oper_d,sum(t1.hrs_mant_men) as valor_hrs_mant_men,sum(t1.hrs_mant_may) as valor_hrs_mant_may ";
		$Consulta.= "from pcip_eec_disponibilidades t1 where t1.tipo_disponibilidad='".$Tipo."' and t1.ano='".$Ano."' and t1.mes between '".$MesIni."' and '".$MesFin."' ";
		$Consulta.= " and t1.cod_sistema='".$CmbSistema."' ";
		$Consulta.= " and t1.cod_equipo='".$CodEquipo."'";
		if($Opcion=='A')
			$Consulta.= " group by t1.cod_sistema,t1.cod_equipo,t1.tipo_disponibilidad,t1.ano ";
		else
			$Consulta.= " group by t1.cod_sistema,t1.cod_equipo,t1.tipo_disponibilidad,t1.ano,t1.mes ";	
		//echo $Consulta;
		$Resp2=mysqli_query($link, $Consulta);
		if($Fila2=mysql_fetch_array($Resp2))
		{
			$Valor=$Fila2[valor]."~".$Fila2[valor_real]."~".$Fila2[valor_hrs_oper_d]."~".$Fila2[valor_hrs_mant_men]."~".$Fila2[valor_hrs_mant_may];
		}
	}*/
	return($Valor);
}
function UltimoDia($anho,$mes){ 
   if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) { 
       $dias_febrero = 29; 
   } else { 
       $dias_febrero = 28; 
   } 
   switch($mes) { 
       case 1: return 31; break; 
       case 2: return $dias_febrero; break; 
       case 3: return 31; break; 
       case 4: return 30; break; 
       case 5: return 31; break; 
       case 6: return 30; break; 
       case 7: return 31; break; 
       case 8: return 31; break; 
       case 9: return 30; break; 
       case 10: return 31; break; 
       case 11: return 30; break; 
       case 12: return 31; break; 
   } 
} 


?>