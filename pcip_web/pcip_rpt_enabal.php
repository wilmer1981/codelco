<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
if(!isset($CmbMostrar))
	$CmbMostrar='P';			
?>
<html>
<head>
<title>Reporte Enabal</title>
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
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "C"://BUSCAR
			if(f.CmbOrigen.value=='-1')
			{
				alert('Debe Seleccionar Origen');
				f.CmbOrigen.focus();
				return;
			}

			if(f.CmbTipoMov.value=='-1')
			{
				alert('Debe Seleccionar Tipo Movimiento');
				f.CmbTipoMov.focus();
				return;
			}
			if(f.CmbTipoDatos.value=='-1')
			{
				alert('Debe Seleccionar Tipo Datos');
				f.CmbTipoDatos.focus();
				return;
			}
			f.action = "pcip_rpt_enabal.php?Buscar=S";
			f.submit();
		break;
		case "E":
			if(f.CmbOrigen.value=='-1')
			{
				alert('Debe Seleccionar Origen');
				f.CmbOrigen.focus();
				return;
			}

			if(f.CmbTipoMov.value=='-1')
			{
				alert('Debe Seleccionar Tipo Movimiento');
				f.CmbTipoMov.focus();
				return;
			}
			if(f.CmbTipoDatos.value=='-1')
			{
				alert('Debe Seleccionar Tipo Datos');
				f.CmbTipoDatos.focus();
				return;
			}
			URL='pcip_rpt_enabal_excel.php?CmbOrigen='+f.CmbOrigen.value+'&CmbTipoMov='+f.CmbTipoMov.value+'&CmbFlujos='+f.CmbFlujos.value+'&CmbTipoDatos='+f.CmbTipoDatos.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&MesFin="+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;
		case "R":
			f.action = "pcip_rpt_enabal.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=15";
		break;
	
	}
	
}

</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 11px}
-->
</style>
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
 EncabezadoPagina($IP_SERV,'enabal.png')
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
    <td width="16%" height="17" class='formulario2'>Origen</td>
    <td class="formulario2" ><span class="formulariosimple">
      <select name="CmbOrigen">
        <option value="-1" class="NoSelec">Seleccionar</option>
        <?
			$Consulta = "select cod_subclase,nombre_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31028' ";			
			$Resp=mysql_query($Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbOrigen==$FilaTC["valor_subclase1"])
					echo "<option selected value='".$FilaTC["valor_subclase1"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				else
					echo "<option value='".$FilaTC["valor_subclase1"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			}
		  ?>
      </select>
    </span></tr>	  

  <tr>
    <td width="16%" height="17" class='formulario2'>Tipo Movimiento </td>
    <td class="formulario2" ><span class="formulariosimple">
      <select name="CmbTipoMov" onChange="Procesos('R')">
        <option value="-1" class="NoSelec">Seleccionar</option>
        <?
			$Consulta = "select cod_subclase,nombre_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31025' ";			
			$Resp=mysql_query($Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbTipoMov==$FilaTC["valor_subclase1"])
					echo "<option selected value='".$FilaTC["valor_subclase1"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				else
					echo "<option value='".$FilaTC["valor_subclase1"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			}
		  ?>
      </select>
    </span></tr>	  

  <tr>
    <td width="16%" height="17" class='formulario2'>Flujo</td>
    <td class="formulario2" >    
      <select name="CmbFlujos" onChange="Procesos('R')">
        <option value="T" selected="selected">Todos</option>
        <?
	  $Consulta = "select * from pcip_ena_datos_enabal where tipo_mov='".$CmbTipoMov."' and origen='".$CmbOrigen."' group by cod_flujo order by cod_flujo ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbFlujos==$FilaTC["cod_flujo"])
				echo "<option selected value='".$FilaTC["cod_flujo"]."'>".$FilaTC["cod_flujo"]."&nbsp;&nbsp;".ucfirst($FilaTC["nom_flujo"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_flujo"]."'>".$FilaTC["cod_flujo"]."&nbsp;&nbsp;".ucfirst($FilaTC["nom_flujo"])."</option>\n";
		}
			?>
      </select>    </td>
  </tr>	  
  <tr>
    <td width="16%" height="17" class='formulario2'>Tipo Datos </td>
    <td class="formulario2" ><span class="formulariosimple">
      <select name="CmbTipoDatos" >
        <option value="-1" class="NoSelec">Seleccionar</option>
        <?
			$Consulta = "select cod_subclase,valor_subclase1,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31026' ";			
			$Resp=mysql_query($Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbTipoDatos==$FilaTC["valor_subclase1"])
					echo "<option selected value='".$FilaTC["valor_subclase1"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				else
					echo "<option value='".$FilaTC["valor_subclase1"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			}
		   ?>
      </select>
    </span></tr>	  
  <tr>

    <td height="25" class='formulario2'>Periodo</td>
    <td class='formulario2'><select name="Ano" id="Ano">
      <?
	for ($i=date("Y")-6;$i<=date("Y");$i++)
	{
		if ($i==$Ano)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
    </select>
      Desde
	  <select name="Mes" id="Mes">
        <?
	for ($i=1;$i<=12;$i++)
	{
		if ($i==$Mes)
			echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		else
			echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
	}
?>
      </select>
      
	  Hasta
	  
	        
	        <select name="MesFin">
        <?
	for ($i=1;$i<=12;$i++)
	{
		if ($i==$MesFin)
			echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		else
			echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
	}
?>
      </select>
  </tr>
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
        <td>
		<table width="100%" border="1" cellpadding="0" cellspacing="0" >
          <tr class="TituloTablaVerde">
            <td width="20%" rowspan="2" align="center"><span class="Estilo9">Flujo / Existencia </span></td>
			<td width="12%" rowspan="2" align="center"><span class="Estilo9">Tipo Dato</span></td>
			<td width="12%" rowspan="2" align="center"><span class="Estilo9">Mes</span></td>
            <td width="8%" rowspan="2" align="center"><span class="Estilo9">Peso Seco [Kg]  </span></td>
            <td width="24%" colspan="3" align="center"><span class="Estilo9">Finos</span></td>
            <td width="24%" colspan="3" align="center"><span class="Estilo9">Leyes</span></td>
          </tr>
          <tr class="TituloTablaVerde">
            <td width="8%" align="center"><span class="Estilo9">Cobre [Kg]</span></td>
            <td width="8%" align="center"><span class="Estilo9">Plata [Grs.] </span></td>
            <td width="8%" align="center"><span class="Estilo9">Oro [Grs.]</span></td>
            <td width="8%" align="center"><span class="Estilo9">Cobre [%] </span></td>
            <td width="8%" align="center"><span class="Estilo9">Plata [Grs/Kg] </span></td>
            <td width="8%" align="center"><span class="Estilo9">Oro [Grs/Kg]</span></td>
            </tr>
			<?
			if($Buscar=='S')
			{
				if($CmbTipoDatos!='D')
				{
					$TotPeso=0;$TotCobre=0;$TotAg=0;$TotAu=0;
					$Consulta = "select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31026' and valor_subclase1='".$CmbTipoDatos."'";			
					$Resp=mysql_query($Consulta);
					if ($Fila=mysql_fetch_array($Resp))
						$TipoDato=$Fila["nombre_subclase"];
					$Consulta = "select cod_flujo,nom_flujo from pcip_ena_datos_enabal where origen='".$CmbOrigen."' and tipo_mov='".$CmbTipoMov."'";
					if($CmbFlujos!='T')
						$Consulta.=" and cod_flujo='".$CmbFlujos."'";
					$Consulta.=" and ano='".$Ano."' and mes between  '".$Mes."' and '".$MesFin."' and tipo_dato='".$CmbTipoDatos."'";	
					$Consulta.=" group by tipo_mov,cod_flujo";
					//echo $Consulta;
					$Resp=mysql_query($Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						$CantFilas=$MesFin-$Mes;$Cont=1;
						echo "<tr>";
						echo "<td rowspan='".($CantFilas+1)."'>".$Fila[cod_flujo]." - ".$Fila[nom_flujo]."</td>";
						echo "<td rowspan='".($CantFilas+1)."'>".$TipoDato."</td>";
						for($i=$Mes;$i<=$MesFin;$i++)
						{
							if($Cont>1)
								echo "<tr>";
							echo "<td>".$Meses[$i-1]."</td>";	
							$Consulta = "select * from pcip_ena_datos_enabal where origen='".$CmbOrigen."' and tipo_mov='".$CmbTipoMov."'";
							$Consulta.=" and cod_flujo='".$Fila[cod_flujo]."'";
							$Consulta.=" and ano='".$Ano."' and mes =  '".$i."' and tipo_dato='".$CmbTipoDatos."'";	
							//echo $Consulta;
							$Resp2=mysql_query($Consulta);
							if($Fila2=mysql_fetch_array($Resp2))
							{
								
								echo "<td align='right'>".number_format($Fila2["peso"],0,'','.')."</td>";
								echo "<td align='right'>".number_format($Fila2[cobre],0,'','.')."</td>";
								echo "<td align='right'>".number_format($Fila2[plata],0,'','.')."</td>";
								echo "<td align='right'>".number_format($Fila2[oro],0,'','.')."</td>";
								$TotPeso=$TotPeso+$Fila2["peso"];
								$TotCobre=$TotCobre+$Fila2[cobre];
								$TotAg=$TotAg+$Fila2[plata];
								$TotAu=$TotAu+$Fila2[oro];
								if($Fila2["peso"]>0)
									echo "<td align='right'>".number_format($Fila2[cobre]/$Fila2["peso"],2,',','.')."</td>";
								else
									echo "<td align='right'>0</td>";
								if($Fila2["peso"]>0)
									echo "<td align='right'>".number_format($Fila2[plata]/$Fila2["peso"],2,',','.')."</td>";
								else
									echo "<td align='right'>0</td>";
								if($Fila2["peso"]>0)	
									echo "<td align='right'>".number_format($Fila2[oro]/$Fila2["peso"],3,',','.')."</td>";
								else
									echo "<td align='right'>0</td>";	
							}
							else
								echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
							$Cont++;
							echo "</tr>";	
						}
					}
					?>
				  <tr class="TituloTablaVerde">
					<td colspan="3" >TOTALES</td>
					<td align="right"><? echo number_format($TotPeso,0,',','.');?>&nbsp;</td>
					<td align="right"><? echo number_format($TotCobre,0,',','.');?>&nbsp;</td>
					<td align="right"><? echo number_format($TotAg,0,',','.');?>&nbsp;</td>
					<td align="right"><? echo number_format($TotAu,0,',','.');?>&nbsp;</td>
					<td colspan="3" >&nbsp;</td>
				  </tr>
					<?		
				}
				else
				{
					$Diferencias=array();
					$Consulta = "select cod_flujo,nom_flujo from pcip_ena_datos_enabal where origen='".$CmbOrigen."' and tipo_mov='".$CmbTipoMov."'";
					if($CmbFlujos!='T')
						$Consulta.=" and cod_flujo='".$CmbFlujos."'";
					$Consulta.=" and ano='".$Ano."' and mes between  '".$Mes."' and '".$MesFin."'";	
					$Consulta.=" group by tipo_mov,cod_flujo";
					//echo $Consulta;
					$Resp=mysql_query($Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						$CantFilas=abs($MesFin-$Mes)+1;$Cont=1;
						//echo $CantFilas."<br>";
						echo "<tr>";
						echo "<td rowspan='".($CantFilas*3)."'>".$Fila[cod_flujo]." - ".$Fila[nom_flujo]."</td>";
						for($i=$Mes;$i<=$MesFin;$i++)
						{
							if($Cont>1)
								echo "<tr>";
							echo "<td rowspan='3'>".$Meses[$i-1]."</td>";
							reset($Diferencias);
							DatosEnabal($CmbOrigen,$Fila[cod_flujo],$Ano,$i,$CmbTipoMov,'B',$Diferencias);
							echo "<tr>";
							DatosEnabal($CmbOrigen,$Fila[cod_flujo],$Ano,$i,$CmbTipoMov,'F',$Diferencias);
							echo "<tr class='FilaAbeja2'>";
							DatosEnabal($CmbOrigen,$Fila[cod_flujo],$Ano,$i,$CmbTipoMov,'D',$Diferencias);	
							$Cont++;
							echo "</tr>";	
						}
						//echo "</tr>";
					}					
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
function DatosEnabal($Origen,$CodFlujo,$AnoAux,$MesAux,$TipoMov,$TipoDato,&$Diferencias)
{
	switch($TipoDato)
	{
		case "B":
			echo "<td>Datos Base</td>";
		break;
		case "F":
			echo "<td>Datos Finales</td>";
		break;
		case "D":
			echo "<td>Diferencia</td>";
			echo "<td align='right'>".number_format($Diferencias[B][0]-$Diferencias[F][0],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Diferencias[B][1]-$Diferencias[F][1],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Diferencias[B][2]-$Diferencias[F][2],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Diferencias[B][3]-$Diferencias[F][3],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Diferencias[B][4]-$Diferencias[F][4],2,',','.')."</td>";
			echo "<td align='right'>".number_format($Diferencias[B][5]-$Diferencias[F][5],2,',','.')."</td>";
			echo "<td align='right'>".number_format($Diferencias[B][6]-$Diferencias[F][6],3,',','.')."</td>";
		break;
	}
	if($TipoDato!='D')
	{
		$Consulta = "select * from pcip_ena_datos_enabal where origen='".$Origen."' and tipo_dato='".$TipoDato."' and tipo_mov='".$TipoMov."'";
		$Consulta.=" and cod_flujo='".$CodFlujo."'";
		$Consulta.=" and ano='".$AnoAux."' and mes =  '".$MesAux."'";	
		//echo $Consulta;
		$Resp2=mysql_query($Consulta);
		if($Fila2=mysql_fetch_array($Resp2))
		{
			echo "<td align='right'>".number_format($Fila2["peso"],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Fila2[cobre],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Fila2[plata],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Fila2[oro],0,'','.')."</td>";
			if($Fila2["peso"]>0)
				echo "<td align='right'>".number_format($Fila2[cobre]/$Fila2["peso"],2,',','.')."</td>";
			else
				echo "<td align='right'>0</td>";
			if($Fila2["peso"]>0)
				echo "<td align='right'>".number_format($Fila2[plata]/$Fila2["peso"],2,',','.')."</td>";
			else
				echo "<td align='right'>0</td>";
			if($Fila2["peso"]>0)	
				echo "<td align='right'>".number_format($Fila2[oro]/$Fila2["peso"],3,',','.')."</td>";
			else
				echo "<td align='right'>0</td>";
			$Diferencias[$TipoDato][0]=$Fila2["peso"];
			$Diferencias[$TipoDato][1]=$Fila2[cobre];
			$Diferencias[$TipoDato][2]=$Fila2[plata];
			$Diferencias[$TipoDato][3]=$Fila2[oro];
			if($Fila2["peso"]>0)
			{
				$Diferencias[$TipoDato][4]=$Fila2[cobre]/$Fila2["peso"];
				$Diferencias[$TipoDato][5]=$Fila2[plata]/$Fila2["peso"];
				$Diferencias[$TipoDato][6]=$Fila2[oro]/$Fila2["peso"];
			}	
			else
			{
				$Diferencias[$TipoDato][4]=0;
				$Diferencias[$TipoDato][5]=0;
				$Diferencias[$TipoDato][6]=0;
			}
		}
		else
			echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
	}
}

?>