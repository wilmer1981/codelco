<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
if(!isset($CmbContr))
	$CmbContr='-1';		
?>
<html>
<head>
<title>Reporte Cuadro diario Ventas</title>
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
	switch(TipoProceso)
	{
		case "C":
			if(f.CmbConAjuste.value=='-1')
			{
			  alert("Debe Seleccionar Ajuste");
			  f.CmbConAjuste.focus();
			  return;
			} 		
			if(f.Ano.value<=f.AnoFin.value)
			{
				var mesdesde=parseInt(f.Mes.value);
				var meshasta=parseInt(f.MesFin.value);
				if(f.Ano.value==f.AnoFin.value&&mesdesde>meshasta)		
				{
					alert("Mes Desde No Puede Ser Mayor a Mes Hasta");
					return;	
				}
				f.action = "pcip_rpt_cuadro_diario_ventas.php?Buscar=S";
				f.submit();
			}
			else
				alert("A�o Desde No Puede ser Mayor a A�o Hasta")	
		break;
		case "E"://GENERA EXCEL
			URL='pcip_rpt_cuadro_diario_ventas_excel.php?CmbContr='+f.CmbContr.value+'&CmbMerc='+f.CmbMerc.value+'&CmbProd='+f.CmbProd.value+'&CmbVenta='+f.CmbVenta.value+'&CmbConAjuste='+f.CmbConAjuste.value+'&Ano='+f.Ano.value+'&Mes='+f.Mes.value+'&AnoFin='+f.AnoFin.value+'&MesFin='+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;				
		case "R":
			f.action = "pcip_rpt_cuadro_diario_ventas.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=12";
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
 EncabezadoPagina($IP_SERV,'mant_cuadro_diario_venta.png')
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
		<td width="82%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td width="18%" align="right" class='formulario2'>
		<a href="JavaScript:Proceso('C')"><span class="formulario2"></span></a><a href="JavaScript:Proceso('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a> 
		<a href="JavaScript:Proceso('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Proceso('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> 
		<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a></td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
<tr>
<td width="80" height="17" class='formulario2'>Contrato</td>
<td width="116"  class="formulario2" ><select name="CmbContr" onChange="Proceso('R')">
  <option value="-1" selected="noSelec">Todos</option>
  <?
	$Consulta = "select distinct(cod_contrato) from pcip_cdv_cuadro_diario_ventas order by cod_contrato ";			
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		if ($CmbContr==$Fila["cod_contrato"])
			echo "<option selected value='".$Fila["cod_contrato"]."'>".$Fila["cod_contrato"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_contrato"]."'>".$Fila["cod_contrato"]."</option>\n";
	}
  ?>
  </select>
    <td width="72" height="17" class='formulario2'>Mercado</td>
    <td class="formulario2" colspan="7">
	   <select name="CmbMerc" onChange="Proceso('R')">
	   <option value="-1" class="NoSelec">Todos</option>
	   <?
		$Consulta = "select distinct(t2.cod_subclase),t2.nombre_subclase";
		$Consulta.=" from pcip_cdv_cuadro_diario_ventas t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31008'";
		$Consulta.=" and t2.cod_subclase=t1.cod_mercado";
		if($CmbContr!='-1')
		$Consulta.=" where cod_contrato='".$CmbContr."'";												
		$Resp=mysqli_query($link, $Consulta);		
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbMerc==$Fila["cod_subclase"])
				echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
			else
				echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
		}
	   ?>
      </select><? //echo $Consulta;?>	</tr>
  <tr>
    <td height="17" class='formulario2'>Producto</td>
    <td  class='formulario2'><select name="CmbProd" onChange="Proceso('R')">
	   <option value="-1" class="NoSelec">Todos</option>
	   <?
		$Consulta ="select distinct(t1.cod_producto),t1.nom_producto from ";
		$Consulta.=" pcip_cdv_productos_ventas t1 inner join pcip_cdv_cuadro_diario_ventas t2 on t1.cod_producto=t2.cod_producto ";
		if($CmbContr!='-1')
		$Consulta.=" where cod_contrato='".$CmbContr."' and vigente='S' order by nom_producto";	 	
		$Resp=mysqli_query($link, $Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbProd==$Fila["cod_producto"])
				echo "<option selected value='".$Fila["cod_producto"]."'>".ucfirst(strtolower($Fila["nom_producto"]))."</option>\n";
			else
				echo "<option value='".$Fila["cod_producto"]."'>".ucfirst(strtolower($Fila["nom_producto"]))."</option>\n";
		}
	   ?>
      </select> <? //echo $Consulta;?>    
		<td height="17" class='formulario2'>Tipo Venta</td>
		<td width="142"  class='formulario2'><select name="CmbVenta" onChange="Proceso('R')">
		   <option value="-1" class="NoSelec">Todos</option>
		   <?
			$Consulta ="select distinct(t1.tipo_venta),t1.nom_venta from ";
			$Consulta.=" pcip_cdv_tipo_ventas_cdv t1 inner join pcip_cdv_cuadro_diario_ventas t2 on t1.tipo_venta=t2.tipo_venta ";
		    if($CmbContr!='-1')
			$Consulta.=" where cod_contrato='".$CmbContr."'order by nom_venta";									
			$Resp=mysqli_query($link, $Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($CmbVenta==$Fila["tipo_venta"])
					echo "<option selected value='".$Fila["tipo_venta"]."'>".ucfirst(strtolower($Fila["nom_venta"]))."</option>\n";
				else
					echo "<option value='".$Fila["tipo_venta"]."'>".ucfirst(strtolower($Fila["nom_venta"]))."</option>\n";
			}
		   ?>
		  </select> <? //echo $Consulta;?>	  
	       <td class="formulario2">Ajuste</td>
           <td class="formulariosimple" colspan="4">
               <select name="CmbConAjuste" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
				$Consulta = "select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbConAjuste==$FilaTC["nombre_subclase"])
						echo "<option selected value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
           </select>
		  </td>
	  </tr>
  <tr>
    <td height="25" class='formulario2'>Periodo</td>
    <td class='formulario2' colspan="3">Desde 
	  			<select name="Ano" id="Ano">
      			<?
				for ($i=2003;$i<=date("Y");$i++)
				{
					if ($i==$Ano)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}
				?>
               </select>
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
	            <select name="AnoFin">
	        	<?
				for ($i=2003;$i<=date("Y");$i++)
				{
					if ($i==$AnoFin)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}
				?>
               </select>
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
			   <td width="86" class="formulario2">Productos Por </td>
			   <td width="310" class="formulariosimple" >
				   <select name="CmbMostrar" >
				   <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31027' ";			
					$Resp=mysqli_query($link, $Consulta);
					while ($FilaTC=mysql_fetch_array($Resp))
					{
						if ($CmbMostrar==$FilaTC["cod_subclase"])
							echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
						else
							echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					}
				   ?>
			   </select>
			  </td>
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
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <?
			  if($CmbMostrar=='2')
			  {
			  ?>
			  <td width="9%"  align="center" class="TituloTablaVerde">N� Documento</td>
              <td width="11%" align="center" class="TituloTablaVerde">Fecha Emisi&oacute;n</td>
              <td width="3%"  align="center" class="TituloTablaVerde">Clte</td>
              <td width="8%" align="center" class="TituloTablaVerde">Fecha Emb.</td>
              <td width="3%" align="center" class="TituloTablaVerde">Nave</td>
              <td width="6%"  align="center" class="TituloTablaVerde">Contrato</td>
              <td width="8%"  align="center" class="TituloTablaVerde">Tipo de Mercado</td>
			  <?
			  }
			  ?>
              <td width="8%"  align="center" class="TituloTablaVerde">Producto</td>
              <td width="7%"  align="center" class="TituloTablaVerde">Tipo Venta</td>
              <td width="4%" align="center" class="TituloTablaVerde">Kilos Finos</td>
              <td width="5%" align="center" class="TituloTablaVerde">Valor Neto</td>
              <td width="5%" align="center" class="TituloTablaVerde">Precio</td>
			  <td width="5%" align="center" class="TituloTablaVerde">Unid</td>				  
              <td width="7%" align="center" class="TituloTablaVerde">Est Fle Des</td>
              <td width="7%" align="center" class="TituloTablaVerde">Seguro Iva</td>
              <td width="9%" align="center" class="TituloTablaVerde">Valor Total</td>
            </tr>
            <tr>
              <td width="9%"></td>
           </tr>
            <?
		  	if($Buscar=='S')
			{   
				$FinosTotal2=0;$TotalNeto2=0;$TotalEstFle2=0;$TotalIva2=0;$TotalTotal2=0;$Precio3=0;
				$Consulta = "select nombre_subclase as ajuste from proyecto_modernizacion.sub_clase where cod_clase='31007' ";
				if($CmbConAjuste=='S')
					$Consulta.= " and nombre_subclase in('N','S')";			
				else
					$Consulta.= " and nombre_subclase in('N')";	
				$Consulta.= "order by ajuste";			
				$RespTC=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($RespTC))
				{
					$FinosTotal=0;$TotalNeto=0;$TotalEstFle=0;$TotalIva=0;$TotalTotal=0;$Precio=0;$Precio2=0;
					if($CmbMostrar=='2')
					{
						$Consulta="select t1.cod_producto,t1.cod_contrato,t2.nombre_subclase,t4.nom_producto,t1.num_documento,t3.nom_venta,t1.fecha_emision,t1.num_folio,t1.ajuste,";
						$Consulta.=" t1.cod_cliente,t1.fecha_embarque,t1.nave,t1.ano,t1.mes,";#t5.cod_grupo, ";
						if($CmbContr!='-1'||$CmbMerc!='-1'||$CmbProd!='-1'||$CmbVenta!='-1')
							$Consulta.="sum(t1.kilos_finos) as kilos_finos,sum(t1.valor_cif_neto) as valor_cif_neto,sum(t1.est_fle_des) as est_fle_des,sum(t1.seguro_iva) as seguro_iva,";
						else
							$Consulta.="t1.kilos_finos,t1.valor_cif_neto,t1.est_fle_des,t1.seguro_iva,";
						$Consulta.=" t1.valor_fob_total from pcip_cdv_cuadro_diario_ventas t1 left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31008'";
						$Consulta.=" and t2.cod_subclase=t1.cod_mercado left join pcip_cdv_tipo_ventas_cdv t3 on t1.tipo_venta=t3.tipo_venta left join ";
						$Consulta.=" pcip_cdv_productos_ventas t4 on t1.cod_producto=t4.cod_producto  ";
						#$Consulta.="left join pcip_cdv_productos_ventas_por_grupo t5 on t5.cod_producto=t1.cod_producto ";
						$Consulta.=" where cod_contrato<>'' and ajuste='".$FilaTC[ajuste]."'";
						if($CmbContr!='-1')			
							$Consulta.=" and t1.cod_contrato='".$CmbContr."'";
						if($CmbMerc!='-1')
							$Consulta.=" and t1.cod_mercado='".$CmbMerc."'";
						if($CmbProd!='-1')
							$Consulta.=" and t1.cod_producto='".$CmbProd."'";
						if($CmbVenta!='-1')
							$Consulta.=" and t1.tipo_venta='".$CmbVenta."'";
						$FechaInicio=$Ano."-".$Mes."-01";
						$FechaTermino=$AnoFin."-".$MesFin."-31";
						if($Ano==$AnoFin)
							$VarAno=" and (t1.ano='".$Ano."' and t1.mes between '".$Mes."' and '".$MesFin."')";
						else
							$VarAno=" and ((t1.ano='".$Ano."' and t1.mes between '".$Mes."' and '12') or (t1.ano='".$AnoFin."' and t1.mes between '1' and '".$MesFin."')) ";	
						//$Consulta.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' AND '".$FechaTermino."'";
						$Consulta.=$VarAno;
						$Consulta.=" group by t1.num_documento ";
						$Consulta.=" order by t1.num_documento,t1.fecha_emision,cod_contrato ";
					}
					else
					{
						$Consulta="select t1.cod_producto,t1.cod_contrato,t2.nombre_subclase,t4.nom_producto,t1.num_documento,t3.nom_venta,t1.fecha_emision,t1.num_folio,t1.ajuste,";
						$Consulta.=" t1.cod_cliente,t1.fecha_embarque,t1.nave,t1.ano,t1.mes,";#t5.cod_grupo, ";
						if($CmbContr!='-1'||$CmbMerc!='-1'||$CmbProd!='-1'||$CmbVenta!='-1')
							$Consulta.="sum(t1.kilos_finos) as kilos_finos,sum(t1.valor_cif_neto) as valor_cif_neto,sum(t1.est_fle_des) as est_fle_des,sum(t1.seguro_iva) as seguro_iva,";
						else
							$Consulta.="sum(t1.kilos_finos) as kilos_finos,sum(t1.valor_cif_neto) as valor_cif_neto,sum(t1.est_fle_des) as est_fle_des,sum(t1.seguro_iva) as seguro_iva,";
						$Consulta.=" t1.valor_fob_total from pcip_cdv_cuadro_diario_ventas t1 left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31008'";
						$Consulta.=" and t2.cod_subclase=t1.cod_mercado left join pcip_cdv_tipo_ventas_cdv t3 on t1.tipo_venta=t3.tipo_venta left join ";
						$Consulta.=" pcip_cdv_productos_ventas t4 on t1.cod_producto=t4.cod_producto  ";
						#$Consulta.="left join pcip_cdv_productos_ventas_por_grupo t5 on t5.cod_producto=t1.cod_producto ";
						$Consulta.=" where cod_contrato<>'' and ajuste='".$FilaTC[ajuste]."'";
						if($CmbContr!='-1')			
							$Consulta.=" and t1.cod_contrato='".$CmbContr."'";
						if($CmbMerc!='-1')
							$Consulta.=" and t1.cod_mercado='".$CmbMerc."'";
						if($CmbProd!='-1')
							$Consulta.=" and t1.cod_producto='".$CmbProd."'";
						if($CmbVenta!='-1')
							$Consulta.=" and t1.tipo_venta='".$CmbVenta."'";
						$FechaInicio=$Ano."-".$Mes."-01";
						$FechaTermino=$AnoFin."-".$MesFin."-31";
						if($Ano==$AnoFin)
							$VarAno=" and (t1.ano='".$Ano."' and t1.mes between '".$Mes."' and '".$MesFin."')";
						else
							$VarAno=" and ((t1.ano='".$Ano."' and t1.mes between '".$Mes."' and '12') or (t1.ano='".$AnoFin."' and t1.mes between '1' and '".$MesFin."')) ";	
						//$Consulta.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' AND '".$FechaTermino."'";
						$Consulta.=$VarAno;
						$Consulta.=" group by t1.cod_producto,t1.tipo_venta ";
						$Consulta.=" order by t1.fecha_emision,cod_contrato ";
					}	
					$Resp=mysqli_query($link, $Consulta);				
					//echo $Consulta;
					while($Fila=mysql_fetch_array($Resp))
					{
					
						$FinosTotal=$FinosTotal+$Fila[kilos_finos];	
						$TotalNeto=$TotalNeto+$Fila[valor_cif_neto];
						$TotalEstFle=$TotalEstFle+$Fila[est_fle_des];
						$TotalIva=$TotalIva+$Fila[seguro_iva];
						$TotalTotal=$TotalTotal+$Fila[valor_fob_total];
						if($Fila[kilos_finos]<>0)
						{
							switch($Fila["cod_grupo"])
							{
								case "1":
								case "2":
								case "3":
/*										if($CodGrupo=='3'&&$i==1)
									 echo 	$Fila2[ValorNeto]."   ".$Fila2[KiloFino]."<br>";
*/										$Precio=1000*($Fila[valor_cif_neto]/$Fila[kilos_finos]);
										$Unid="[US$/TMF]";
								break;
								case "14":
								case "15":
									$Precio=($Fila[valor_cif_neto]/$Fila[kilos_finos])*(1/35.2739619);
									$Unid="[US$/Oz]";
								break;
								default:
									$Precio=$Fila[valor_cif_neto]/$Fila[kilos_finos];
									$Unid="[US$/Kg]";
								break;
							}		
							//    $Precio=$Fila[valor_cif_neto]/$Fila[kilos_finos];
						}
						else
							$Precio=0;							
						?>
						<tr>
						  <?	
						  if($CmbMostrar=='2')
						  {
						  ?>
						  <td align="center"><? echo $Fila[num_documento];?>&nbsp; </td>				  				 
						  <td align="right"><? echo $Fila[fecha_emision];?>&nbsp; </td>
						  <td align="right"><? echo $Fila[cod_cliente];?>&nbsp; </td>
						  <td align="right"><? echo $Fila["fecha_embarque"];?>				  
						  <td align="left"><? echo $Fila[nave];?>&nbsp;</td>				  
						  <td><? echo $Fila["cod_contrato"];?>&nbsp;</td>
						  <td><? echo $Fila["nombre_subclase"];?>&nbsp; </td>
						  <?
						  }
						  ?>
						  <td><? if($Fila["nom_producto"]=='')
								  {
							  ?> <span class="InputRojo">Sin Nombre Producto</span>
								   <?
									  }   
										else
										{
										echo $Fila["nom_producto"];
										}				  
								   ?>&nbsp; </td>
						  <td align="left"><? echo $Fila[nom_venta];?>&nbsp; </td>
						  <td align="right"><? echo number_format($Fila[kilos_finos],2,',','.');?>&nbsp; </td>				  
						  <td align="right"><? echo number_format($Fila[valor_cif_neto],2,',','.');?>&nbsp; </td>				  
						  <td align="right"><? echo number_format($Precio,2,',','.');?>&nbsp; </td>
						  <td align="right"><? echo $Unid;?>&nbsp; </td>					  						 
						  <td align="right"><? echo number_format($Fila[est_fle_des],2,',','.');?>&nbsp; </td>				  
						  <td align="right"><? echo number_format($Fila[seguro_iva],2,',','.');?>&nbsp; </td>				  				  		  
						  <td align="right"><? echo number_format($Fila[valor_fob_total],2,',','.');?>&nbsp; </td>
						</tr>
						<?			
					  }
					  	
				?>
				  <tr  class="Formulario2">
				  <td colspan="2"><? 
				  		if($FilaTC[ajuste]=='S')
							echo "Total Ajuste";
						else
							echo "Total Tipo Venta";	
				  ?></td>
				  <?
				   if($CmbMostrar=='2')
				   {
				  ?>
				  <td colspan="7">&nbsp;</td>
				  <?
				  }
				  ?>
				  <td align="right"><? echo number_format($FinosTotal,2,',','.')?>&nbsp;</td>
				  <td align="right"><? echo number_format($TotalNeto,2,',','.')?>&nbsp;</td>
				  <?
				  	if($FinosTotal<>0)
						$Precio2=$TotalNeto/$FinosTotal;
					else
						$Precio2=0;	
				  ?>
				  <td align="right">&nbsp;</td>
				  <td>&nbsp;</td>				  
				  <td align="right"><? echo number_format($TotalEstFle,2,',','.')?>&nbsp;</td>
				  <td align="right"><? echo number_format($TotalIva,2,',','.')?>&nbsp;</td>
				  <td align="right"><? echo number_format($TotalTotal,2,',','.')?>&nbsp;</td>			 
				  </tr>
				<?
				$FinosTotal2=$FinosTotal2+$FinosTotal;	
				$TotalNeto2=$TotalNeto2+$TotalNeto;
				$TotalEstFle2=$TotalEstFle2+$TotalEstFle;
				$TotalIva2=$TotalIva2+$TotalIva;
				$TotalTotal2=$TotalTotal2+$TotalTotal;
				 } 
				 if($CmbConAjuste=='S')
				 {
				 ?> 
				  <tr class="TituloTablaVerde">
				  <td  colspan="2">TOTAL</td>
				  <?
				   if($CmbMostrar=='2')
				   {
				  ?>
				  <td colspan="7">&nbsp;</td>
				  <?
				  }
				  ?>
				  <td align="right"><? echo number_format($FinosTotal2,2,',','.')?>&nbsp;</td>
				  <td align="right"><? echo number_format($TotalNeto2,2,',','.')?>&nbsp;</td>
				  <?
				  	if($FinosTotal2<>0)
						$Precio3=$TotalNeto2/$FinosTotal2;
					else
						$Precio3=0;	
				  ?>
				  <td align="right"><? echo number_format($Precio3,2,',','.')?>&nbsp;</td>
				  <td>&nbsp;</td>				  
				  <td align="right"><? echo number_format($TotalEstFle2,2,',','.')?>&nbsp;</td>				
				  <td align="right"><? echo number_format($TotalIva2,2,',','.')?>&nbsp;</td>
				  <td align="right"><? echo number_format($TotalTotal2,2,',','.')?>&nbsp;</td>			 
				  </tr>
				<?
				}			   }
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
function ValoresIn($Asig,$Area,$Maqui,$Prod,$Ano,$MesAux)
{
	$Valor=0;
	$Consulta="select sum(t1.valor) as total ";
	$Consulta.="from pcip_svp_variacion_inventario t1 where t1.cod_asignacion='".$Asig."'";
	if($Area!='-1')
		$Consulta.=" and t1.cod_area='".$Area."'";
	if($Maqui!='-1')
		$Consulta.=" and t1.cod_maquila='".$Maqui."'";
	if($Prod!='-1')
		$Consulta.=" and t1.cod_producto='".$Prod."'";
	if($Ano!='T')
		$Consulta.=" and t1.ano='".$Ano."'";
	if($MesAux!='T')
		$Consulta.=" and t1.mes='".$MesAux."'";
	//echo $Consulta."<br>";
	$Respaux=mysqli_query($link, $Consulta);
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
	$Consulta.="from pcip_svp_variacion_inventario t1 where t1.cod_asignacion='".$Asig."'";
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
	echo $Consulta."<br>";
	$Respaux=mysqli_query($link, $Consulta);
	if($Filaaux1=mysql_fetch_array($Respaux))
	{
		$ValorPpto=$Filaaux1["total"];
		
	}
	return($ValorPpto);
}
?>