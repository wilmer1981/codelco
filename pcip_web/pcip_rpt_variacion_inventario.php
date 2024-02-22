<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');	
?>
<html>
<head>
<title>Reporte Variaci�n Inventario</title>
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

function Proceso(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "C":
			if(f.CmbAsig.value=='-1')
			{
				alert('Debe Seleccionar Asignaci�n');
				f.CmbAsig.focus();
				return;
			}					
			f.action = "pcip_rpt_variacion_inventario.php?Buscar=S";
			f.submit();
		break;
		case "E":
			if(f.CmbAsig.value=='-1')
			{
				alert('Debe Seleccionar Sistema');
				f.CmbAsig.focus();
				return;
			}
			URL='pcip_rpt_variacion_inventario_excel.php?CmbAsig='+f.CmbAsig.value+'&CmbArea='+f.CmbArea.value+'&CmbMaqui='+f.CmbMaqui.value+'&CmbProd='+f.CmbProd.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;
		case "R":
			f.action = "pcip_rpt_variacion_inventario.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=8";
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
 EncabezadoPagina($IP_SERV,'variacion_inventario_report.png')
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
		<td width="87%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td width="13%" align="right" class='formulario2'>
		<a href="JavaScript:Proceso('C')"><span class="formulario2"></span></a><a href="JavaScript:Proceso('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a> 
		<a href="JavaScript:Proceso('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>
		<a href="JavaScript:Proceso('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> 
		<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a></td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
<tr>
<td width="16%" height="17" class='formulario2'>Grupo Asignaci�n</td>
<td width="84%" class="formulario2" colspan="3"><select name="CmbGrupo" onChange="Proceso('R')">
  <option value="-1" selected="selected">Seleccionar</option>
  <?
	$Consulta = "select cod_subclase,nombre_subclase,valor_subclase1 as mostrar_otros_inv from proyecto_modernizacion.sub_clase where cod_clase='31044'order by cod_subclase ";			
	$Resp=mysql_query($Consulta);
	while ($FilaTC=mysql_fetch_array($Resp))
	{
		if ($CmbGrupo==$FilaTC["cod_subclase"])
		{
			echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			$MostrarOtrosInv=$FilaTC["mostrar_otros_inv"];
		}
		else
			echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
	}
  ?>
  </select>
 </tr> 
<tr>
<td width="16%" height="17" class='formulario2'>Asignaci&oacute;n</td>
<td colspan="3" class="formulario2" ><select name="CmbAsig" onChange="Proceso('R')">
  <option value="-1" selected="selected">Seleccionar</option>
  <?
	$Consulta = "select distinct t1.cod_subclase,t1.nombre_subclase from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.sub_clase t2";
	$Consulta.= " on t1.cod_clase='31045' and t2.cod_subclase=t1.valor_subclase1 where t1.valor_subclase1='".$CmbGrupo."' order by t1.cod_subclase ";			
	$Resp=mysql_query($Consulta);
	while ($FilaTC=mysql_fetch_array($Resp))
	{
		if ($CmbAsig==$FilaTC["cod_subclase"])
		{
			echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			$Unidad=$FilaTC["cod_unidad"];
		}
		else
			echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
	}
  ?>
  </select><? //echo $Consulta;?>
</tr> 
  <tr>
    <td width="16%" height="17" class='formulario2'>&Aacute;rea</td>
    <td colspan="3" class="formulario2" ><select name="CmbArea" onChange="Proceso('R')">
	   <option value="-1" class="NoSelec">Todos</option>
	   <?
		$Consulta = "select distinct(t2.cod_area),t1.nombre_subclase";
		$Consulta.=" from proyecto_modernizacion.sub_clase t1 left join pcip_svp_variacion_inventario t2 on t1.cod_clase='31009'";
		$Consulta.=" and t1.cod_subclase=t2.cod_area where cod_asignacion<>''";
		if($CmbAsig!='-1')
			$Consulta.=" and cod_asignacion='".$CmbAsig."'";											
		$Resp=mysql_query($Consulta);		
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbArea==$FilaTC["cod_area"])
				echo "<option selected value='".$FilaTC["cod_area"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_area"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
	   ?>
      </select><? //echo $Consulta;?>
	  </tr>
  <tr>
    <td height="17" class='formulario2'>Maquila</td>
    <td colspan="3" class='formulario2'><select name="CmbMaqui" onChange="Proceso('R')">
	   <option value="-1" class="NoSelec">Todos</option>
	   <?
		$Consulta = "select distinct(t2.cod_maquila),t1.nombre_subclase";
		$Consulta.=" from proyecto_modernizacion.sub_clase t1 left join pcip_svp_variacion_inventario t2 on t1.cod_clase='31010'";
		$Consulta.=" and t1.cod_subclase=t2.cod_maquila where cod_area<>''";
		if($CmbArea!='-1')
			$Consulta.=" and cod_area='".$CmbArea."'";						
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbMaqui==$FilaTC["cod_maquila"])
				echo "<option selected value='".$FilaTC["cod_maquila"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_maquila"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
	   ?>
      </select> <? //echo $Consulta;?>     
  </tr>
  <tr>
    <td height="17" class='formulario2'> Productos</td>
    <td colspan="3" class='formulario2'><select name="CmbProd" onChange="Proceso('R')">
	   <option value="-1" class="NoSelec">Todos</option>
	   <?
		$Consulta ="select distinct(t1.cod_producto),t2.nom_producto from pcip_svp_variacion_inventario t1 left join pcip_svp_productos_inventarios t2";
		$Consulta.=" on t1.cod_producto=t2.cod_producto where cod_maquila<>''";	
		if($CmbMaqui!='-1')
			$Consulta.=" and cod_maquila='".$CmbMaqui."'";	
		$Resp=mysql_query($Consulta);							
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbProd==$FilaTC["cod_producto"])
				echo "<option selected value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nom_producto"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nom_producto"])."</option>\n";
		}
	   ?>
      </select>  <? //echo $Consulta;?>      
  </tr>	  
  <tr>
    <td height="25" class='formulario2'>A&ntilde;o</td>
    <td width="17%" class='formulario2'><select name="Ano" id="Ano" onChange="Proceso('R')"> 
			 <?
				for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
				{
					if ($i==$Ano)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}
		     ?>
    </select> 
    <td width="4%" height="25" class='formulario2'>Mes </td>
    <td width="63%" class='formulario2'><select name="Mes" id="Mes" onChange="Proceso('R')"> 
		  <?
			for ($i=1;$i<=12;$i++)
			{
				if ($i==$Mes)
					echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
				else
					echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
			}
      	  ?>
    </select></tr>
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
            <td  align="center" class="TituloTablaVerde">
			<? 
			$Consulta = "select nom_asignacion from pcip_svp_asignacion where cod_asignacion='".$CmbAsig."' ";			
			$Resp=mysql_query($Consulta);
			if ($Fila=mysql_fetch_array($Resp))
				echo $Fila[nom_asignacion]."<br> [".$Unidad."]";?>
			</td>
            <td width="13%"  align="center" class="TituloTablaVerde">Inventario 
              <? echo ucfirst($Meses[$Mes-2]).intval($Ano);?></td>	
            <td width="13%"  align="center" class="TituloTablaVerde">Inventario Actual
              <? echo ucfirst($Meses[$Mes-1])." ".$Ano;?></td>		
            <td width="1%" class="">&nbsp;</td>
            <td width="20%"  align="center" class="TituloTablaVerde">Inventario Final
              <? echo ucfirst($Meses[$Mes-1])." ".$Ano;?></td>		
            <td width="10%"  align="center" class="TituloTablaVerde">Variacion MES</td>	
            <td align="center" class="TituloTablaVerde">Acumulado<br>
              <? echo ucfirst($Meses[$Mes-1])." ".$Ano;?></td>		
            <td width="19%" align="center" class="TituloTablaVerde">PPTO
              <? echo ucfirst($Meses[$Mes-1])." ".$Ano;?></td>					
		  </tr>
		  <tr>
		    <td width="8%"></td>
		  </tr>
		  <?
		  	if($Buscar=='S')
			{
				$Consulta="select t1.cod_area,t2.nombre_subclase as nom_area from pcip_svp_variacion_inventario t1 left join proyecto_modernizacion.sub_clase t2";
				$Consulta.=" on t2.cod_clase='31009' and t2.cod_subclase=t1.cod_area where cod_asignacion='".$CmbAsig."'";
				if($CmbArea!='-1')
					$Consulta.=" and t1.cod_area='".$CmbArea."'";
				if($CmbMaqui!='-1')
					$Consulta.=" and t1.cod_maquila='".$CmbMaqui."'";
				if($CmbProd!='-1')
					$Consulta.=" and t1.cod_producto='".$CmbProd."'";
				 $Consulta.=" group by cod_asignacion,cod_area ";
				$Resp=mysql_query($Consulta);
				//echo $Consulta;
				while($Fila=mysql_fetch_array($Resp))
				{
					$TotArea_4=0;$TotArea_3=0;$TotArea_2=0;$TotArea_1=0;$TotAreaFinal_1=0;$TotAreaFinal_2=0;$TotArea_Acu_2=0;
					$NomArea=$Fila[nom_area];$TotPptoArea=0;
					?>
					<tr>
					<td class='FilaAbeja' colspan="14"><? echo "&nbsp;&nbsp;".str_replace(' ','&nbsp;',$Fila[nom_area]);?>&nbsp;</td>
					</tr>					
					<?
					$Consulta1="select t1.cod_maquila,t2.nombre_subclase as nom_maquila from pcip_svp_variacion_inventario t1 left join proyecto_modernizacion.sub_clase t2";
					$Consulta1.=" on t2.cod_clase='31010' and t2.cod_subclase=t1.cod_maquila where cod_asignacion='".$CmbAsig."' ";
					$Consulta1.=" and cod_area='".$Fila[cod_area]."'";
					if($CmbMaqui!='-1')
						$Consulta1.=" and t1.cod_maquila='".$CmbMaqui."'";
					if($CmbProd!='-1')
						$Consulta1.=" and t1.cod_producto='".$CmbProd."'";
					$Consulta1.=" group by cod_maquila ";
					$Resp1=mysql_query($Consulta1);
					//echo $Consulta1;
					while($Fila1=mysql_fetch_array($Resp1))
					{
						$TotMaq_4=0;$TotMaq_3=0;$TotMaq_2=0;$TotMaq_1=0;$TotMaqFinal_1=0;$TotAcu_Maq_2=0;
						$NomMaquila=$Fila1[nom_maquila];
						?>
						<tr>
						<td class='TituloTablaVerde' colspan="14"><? echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".str_replace(' ','&nbsp;',$Fila1[nom_maquila]);?></td>
						</tr>					
						<?						
						$Consulta2="select t1.cod_producto,t2.nom_producto from pcip_svp_variacion_inventario t1 left join pcip_svp_productos_inventarios t2";
						$Consulta2.=" on t1.cod_producto=t2.cod_producto where cod_asignacion='".$CmbAsig."' and cod_area='".$Fila[cod_area]."' and cod_maquila='".$Fila1[cod_maquila]."'";
						if($CmbProd!='-1')
							$Consulta2.=" and t1.cod_producto='".$CmbProd."'";
						$Consulta2.=" group by cod_producto ";
						$Resp2=mysql_query($Consulta2);$TotProd_4=0;$TotProd_3=0;$TotProd_2=0;$TotProd_1=0;$TotProdFinal_1=0;$TotVar_Final_2=0;$Producto_1=0;$ProdAcu=0;$TotAcuProd_2=0;$TotPpto=0;
						//echo $Consulta2."<br>";
						while($Fila2=mysql_fetch_array($Resp2))
						{						   
							?>
							<tr>
							<td class='FilaAbeja2'><? echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".str_replace(' ','&nbsp;',$Fila2["nom_producto"]);?></td>
							<td  align="right" ><? $var_2=ValoresIn($CmbAsig,$Fila[cod_area],$Fila1[cod_maquila],$Fila2["cod_producto"],intval($Ano),$Mes-1);echo number_format($var_2,3,',','.');?>&nbsp;</td>	
							<td  align="right" ><? $var_1=ValoresIn($CmbAsig,$Fila[cod_area],$Fila1[cod_maquila],$Fila2["cod_producto"],intval($Ano),$Mes);echo number_format($var_1,3,',','.');?>&nbsp;</td>		
							<td width="1%" class="">&nbsp;</td>
							<td  align="right" ><?  $Producto_1=+$var_1; echo number_format($Producto_1,3,',','.');?>&nbsp;</td>		
							<td  align="right"><? $Producto_2=($Producto_1-$var_2); echo  number_format($Producto_2,3,',','.');?></td>		
							<td width="16%"  align="right"><?  $ProdAcu=+$Producto_2; echo  number_format($ProdAcu,3,',','.');?></td>	
							<td width="19%"  align="right" ><? $var_5=ValorPpto($CmbAsig,$Fila[cod_area],$Fila1[cod_maquila],$Fila2["cod_producto"],intval($Ano),$Mes);echo number_format($var_5,3,',','.');?>&nbsp;</td>								
							</tr>					
							<?							
							$TotProd_4=$TotProd_4+$var_4;
							$TotProd_2=$TotProd_2+$var_2;	
							$TotProd_3=$TotProd_3+$var_3;	
							$TotProd_1=$TotProd_1+$var_1;	
							$TotProdFinal_1=+$TotProd_1;	
							$TotPpto=$TotPpto+$var_5;	
							$TotVar_Final_2=$TotVar_Final_2+$Producto_2;																									
						}
						$TotMaq_4=$TotMaq_4+$TotProd_4;
						$TotMaq_3=$TotMaq_3+$TotProd_3;	
						$TotMaq_2=$TotMaq_2+$TotProd_2;	
						$TotMaq_1=$TotMaq_1+$TotProd_1;	
						$TotMaqFinal_1=+$TotMaq_1;	
						$TotAcu_Maq_2=$TotAcu_Maq_2+$TotVar_Final_2																								
						?>
						<tr>
						<td class='TituloTablaVerde'>Total <? echo $NomMaquila?></td>					
						<td class='FilaAbeja' align="right"><? echo number_format($TotMaq_2,3,',','.');?>&nbsp;</td>
						<td class='FilaAbeja' align="right"><? echo number_format($TotMaq_1,3,',','.');?>&nbsp;</td>					
						<td class='FilaAbeja' align="right">&nbsp;</td>
						<td class='FilaAbeja' align="right"><? echo number_format($TotMaqFinal_1,3,',','.');?>&nbsp;</td>
						<td class='FilaAbeja' align="right" ><? echo number_format($TotVar_Final_2,3,',','.');?>&nbsp;</td>
						<td class='FilaAbeja' align="right" ><? echo number_format($TotAcu_Maq_2,3,',','.');?>&nbsp;</td>
						<td width="19%" class='FilaAbeja'  align="right" ><? echo number_format($TotPpto,3,',','.');?>&nbsp;</td>
						</tr>
					<?
				$TotArea_4=$TotArea_4+$TotMaq_4;
				$TotArea_3=$TotArea_3+$TotMaq_3;	
				$TotArea_2=$TotArea_2+$TotMaq_2;	
				$TotArea_1=$TotArea_1+$TotMaq_1;
				$TotAreaFinal_1=+$TotArea_1;
				$TotAreaFinal_2=$TotAreaFinal_2+$TotVar_Final_2;		
				$TotPptoArea=$TotPptoArea+$TotPpto;																		                
					}
				?>
				<tr>
				<td class='FilaAbeja'>Total <? echo $NomArea;?></td>
				<td class='FilaAbeja' align="right"><? echo number_format($TotArea_2,3,',','.');?>&nbsp;</td>
				<td class='FilaAbeja' align="right"><? echo number_format($TotArea_1,3,',','.');?>&nbsp;</td>					
				<td class='FilaAbeja' align="right">&nbsp;</td>
				<td class='FilaAbeja' align="right"><? echo number_format($TotAreaFinal_1,3,',','.');?>&nbsp;</td>
				<td class='FilaAbeja' align="right"><? echo number_format($TotAreaFinal_2,3,',','.');?>&nbsp;</td>
				<td class='FilaAbeja' align="right"><? echo number_format($TotArea_Acu_2=$TotAreaFinal_1-$TotArea_2,3,',','.');?>&nbsp;</td>
				<td width="19%" class='FilaAbeja'  align="right" ><? echo number_format($TotPptoArea,3,',','.');?>&nbsp;</td>
				</tr>
				<?
				 $Total_dato2=$Total_dato2+$TotArea_2;
				 $Total_dato1=$Total_dato1+$TotArea_1;
				 $TotAreaFin=$TotAreaFin+$TotAreaFinal_2;	
				}
				$Dato=ValoresInDiferencia($Ano,$Mes-1);
				$Diferencia2=$Dato-$Total_dato2;
				
				$Dato1=ValoresInDiferencia($Ano,$Mes);
				$Diferencia1=$Dato1-$Total_dato1;
				//echo 	$TotAreaFin."<br>";
				$DiferenciaTotal=+$Diferencia1;
				$DiferenciaTotal2=$Diferencia1-$Diferencia2;
				$AcumuladoDiferencia=$DiferenciaTotal-$Diferencia2;
				//echo $Diferencia2."<br>";
				$TotalInventario=$Total_dato1+$DiferenciaTotal;
				$TotalInventarioMes=$TotAreaFin+$DiferenciaTotal2;
				$TotAcumTotalInventario=$TotalInventario-$Dato;
				if($MostrarOtrosInv=='S')
				{
				?>			
				<tr>
				<td class='FilaAbeja'>Otros Inventarios</td>
				<td class='FilaAbeja' align="right"><? echo number_format($Diferencia2,3,',','.');?>&nbsp;</td>
				<td class='FilaAbeja' align="right"><? echo number_format($Diferencia1,3,',','.');?>&nbsp;</td>					
				<td class='FilaAbeja' align="right">&nbsp;</td>
				<td class='FilaAbeja' align="right"><? echo number_format($DiferenciaTotal,3,',','.');?>&nbsp;</td>
				<td class='FilaAbeja' align="right"><? echo number_format($DiferenciaTotal2,3,',','.');?>&nbsp;</td>
				<td class='FilaAbeja' align="right"><? echo number_format($AcumuladoDiferencia,3,',','.');?>&nbsp;</td>
				<td width="19%" class='FilaAbeja'  align="right" >&nbsp;</td>
				</tr>
				<?
				}
				?>
				<tr>
				<td class='FilaAbeja'>Total Inventarios<? echo $Fila[nom_asignacion];?></td>
				<td class='FilaAbeja' align="right"><? echo number_format($Dato,3,',','.');?>&nbsp;</td>
				<td class='FilaAbeja' align="right"><? echo number_format($Dato1,3,',','.');?>&nbsp;</td>					
				<td class='FilaAbeja' align="right">&nbsp;</td>
				<td class='FilaAbeja' align="right"><? echo number_format($TotalInventario,3,',','.');?>&nbsp;</td>
				<td class='FilaAbeja' align="right"><? echo number_format($TotalInventarioMes,3,',','.');?>&nbsp;</td>
				<td class='FilaAbeja' align="right"><? echo number_format($TotAcumTotalInventario,3,',','.');?>&nbsp;</td>
				<td width="19%" class='FilaAbeja'  align="right" >&nbsp;</td>
				</tr>
				<?
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
function ValoresIn($Asig,$Area,$Maqui,$Prod,$Ano,$MesAux1)
{
	$Valor=0;
	$Consulta="select sum(t2.VPcantidad) as total ";
	$Consulta.="from pcip_svp_variacion_inventario t1 inner join pcip_svp_valorizacproduccion t2";
	$Consulta.=" on t1.num_orden=t2.VPorden and t1.vptm=t2.VPtm and t1.num_orden_relacionada=t2.VPordenrel and t1.cod_material=t2.VPmaterial";
	$Consulta.=" and t1.vptipinv=t2.VPtipinv";
	if($Area!='-1')
		$Consulta.=" and t1.cod_area='".$Area."'";
	if($Maqui!='-1')
		$Consulta.=" and t1.cod_maquila='".$Maqui."'";
	if($Prod!='-1')
		$Consulta.=" and t1.cod_producto='".$Prod."'";
	$Consulta.="where t2.VPa�o='".$Ano."' and VPmes='".$MesAux1."'";
	//echo $Consulta."<br>";
	$Respaux=mysql_query($Consulta);
	if($Filaaux=mysql_fetch_array($Respaux))
	{
		$Valor=$Filaaux["total"];
		
	}
	return($Valor);
}
function ValorPpto($Asig,$Area,$Maqui,$Prod,$Ano,$MesAux1)
{
	$ValorPpto=0;
	$Consulta="select sum(t1.valor_ppto) as total ";
	$Consulta.="from pcip_svp_variacion_inventario_ppto t1";
	$Consulta.=" where t1.cod_asignacion='".$Asig."'";
	if($Area!='-1')
		$Consulta.=" and t1.cod_area='".$Area."'";
	if($Maqui!='-1')
		$Consulta.=" and t1.cod_maquila='".$Maqui."'";
	if($Prod!='-1')
		$Consulta.=" and t1.cod_producto='".$Prod."'";
	if($Ano!='T')
		$Consulta.=" and t1.ano='".$Ano."'";
	if($MesAux1!='T')
		$Consulta.=" and t1.mes='".$MesAux1."'";
		
	//echo $Consulta."<br>";
	$Respaux=mysql_query($Consulta);
	if($Filaaux1=mysql_fetch_array($Respaux))
	{
		$ValorPpto=$Filaaux1["total"];
		
	}
	return($ValorPpto);
}

function ValoresInDiferencia($Ano,$MesAux1)
{
	$Valor=0;
	$Consulta="select sum(t2.VPcantidad) as total ";
	$Consulta.="from pcip_svp_valorizacproduccion t2";
	$Consulta.=" where  VPtm in ('25','21') and t2.VPa�o='".$Ano."' and VPmes='".$MesAux1."' and VPorden < 5500 ";
	//echo $Consulta."<br>";
	$Respaux=mysql_query($Consulta);
	if($Filaaux=mysql_fetch_array($Respaux))
	{
		$Valor=$Filaaux["total"];
		
	}
	return($Valor);
}
?>