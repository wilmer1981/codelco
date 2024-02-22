<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");					

if($VisibleDivProceso=='S')
$VisibleDiv='hidden';

if(!isset($FDesde))
	$FDesde=date('Y-m-d');
	
$SelTarea=$NivelOrg;
?>
<html>
<head>
<title>Informe Diario</title>

<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">

var popup=0;
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmPrincipal;
	var teclaCodigo = event.keyCode;
	
	
		if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39) &&(teclaCodigo != 190 ))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
					event.keyCode=46;
			   }		
			}   
		}
		else
		{
			if ((teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 188 )&&(teclaCodigo != 190 ))
			{
				event.keyCode=46;
			}	
		}
	
} 
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "R":
				if(f.FDesde.value=='')
				{
					alert('Debe Ingresar Fecha Desde');
					f.FDesde.focus();
					return;
				}	
				if(f.FHasta.value=='')
				{
					alert('Debe Ingresar Fecha Hasta');
					f.FHasta.focus();
					return;
				}	
				f.action='consulta_acceso_control.php';
				f.submit();		
		break;
		case "C":
				f.action='pmn_rpt_informe_diario.php?Buscar=S&Tipo=C';
				f.submit();		
		break;
		case "GF":
				URL='consulta_acceso_control_grafica.php?Buscar=S&FDesde='+f.FDesde.value+'&FHasta='+f.FHasta.value+'&USUARIO='+f.USUARIO.value+'&CmbM='+f.CmbTipoProceso.value;
				window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");	
		break;
		case "S":
				window.location="pmn_principal.php";
		break;
		case "E":
				URL='pmn_rpt_informe_diario_excel.php?Buscar=S&FDesde='+f.FDesde.value+'&cmbturno='+f.cmbturno.value;
				window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");	
		break;
	}	
}
function CloseDiv()
{

	DivProceso.style.visibility='hidden';
	DivOCu.style.visibility='visible';
}
function compare_dates(fecha, fecha2)  
{  
	var xMonth=fecha.substring(3, 5);  
	var xDay=fecha.substring(0, 2);  
	var xYear=fecha.substring(6,10);  
	var yMonth=fecha2.substring(3, 5);  
	var yDay=fecha2.substring(0, 2);  
	var yYear=fecha2.substring(6,10);  
	if (xYear> yYear)  
   {  
	   return(true)  
   }  
  else  
   {  
	 if (xYear == yYear)  
	 {   
	   if (xMonth> yMonth)  
	   {  
		   return(true)  
	   }  
	   else  
	   {   
		 if (xMonth == yMonth)  
		 {  
		   if (xDay> yDay)  
			 return(true);  
		   else  
			 return(false);  
		 }  
		 else  
		   return(false);  
	   }  
	 }  
	 else  
	   return(false);  
  }  
}  

</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmPrincipal" method="post" action="">
<input name="Datos" type="hidden" value="<?php echo $Datos;?>">
<input name="Proc" type="hidden" value="<?php echo $Proc;?>">
<input type="hidden" size='100' value="<?php echo $SelTarea;?>" name="SelTarea">

<table width="50%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
	<td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
	<td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
	<td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
   <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
   <td align="center"><table width="100%" border="0" cellpadding="0"  cellspacing="0">
     <tr>
	 <td align="center" colspan="5" class="TituloCabecera2">NOVEDADES JEFE DE TURNO </td>
	 </tr>
	 <tr>       
	   <td width="168" height="35" align="left" class="formulario"   ><img src="archivos/LblCriterios.png" /> </td>
       <td align="right" class="formulario" colspan="5">
	   <div id="DivOCu" style="visibility:<?php echo $VisibleDiv;?>">
	   <a href="JavaScript:Proceso('C')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;
	    <a href="javascript:Proceso('E')"><img src="archivos/excel.png" alt='Excel' width="24" height="24" border="0" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Proceso('S')"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a>       </div></td>
	 </tr>
     <tr>
       <td colspan="3" class="formulario">D&iacute;a&nbsp;</td>
	   <td width="701" class="formulario"><input type="text" size="9" readonly="" maxlength="10" name="FDesde" id="FDesde"  class="InputDer" value='<?php echo $FDesde?>'/>
		&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha"  border="0" align="absmiddle" onClick="popFrame.fPopCalendar(FDesde,FDesde,popCal);return false"/>&nbsp; </span><a href="JavaScript:Proceso('R')"></a>&nbsp;Turno&nbsp;&nbsp;
		<select name="cmbturno">
          <?php
				echo"<option value='T' selected>Todos</option>";
				if($cmbturno == "1")
					echo"<option value='1' selected>A</option>";
				else
					echo"<option value='1'>A</option>";
				if($cmbturno == "2")
					echo"<option value='2' selected>B</option>";
				else
					echo"<option value='2'>B</option>";
				if($cmbturno == "3")
					echo"<option value='3' selected>C</option>";
				else
					echo"<option value='3'>C</option>";
			?>
        </select></td>
       <td width="191" class="formulario">&nbsp;</td>
       </tr>
     <tr>
       <td colspan="3" class="formulario">&nbsp;</td>
       <td class="formulario">&nbsp;</td>
       <td class="formulario">&nbsp;</td>
     </tr>
	 <?php
		//$FDesde=$FDesde." 00:00:00";
		//$FHasta=$FHasta." 23:59:59";
	 ?>
   </table></td>
   <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"  /></td>
  </tr>
  </table>
  <br>
<?php
if($Buscar=='S')
{
?>  
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="10" align="center" class="TituloCabecera2">LIXIVIACION</td>
        </tr>
      <tr>
        <td width="18%" rowspan="2" align="center" class="texto_bold">Lixiviadores</td>
        <td colspan="2" align="center" class="texto_bold">Carga de Lixiviadores </td>
        <td width="14%" align="center" class="texto_bold">Adici&oacute;n</td>
        <td width="17%" align="center" class="texto_bold">Hora</td>
        <td colspan="2" align="center" class="texto_bold">Producci&oacute;n</td>
      </tr>
      <tr>
        <td width="7%" align="center" class="texto_bold">N&ordm;</td>
        <td width="8%" align="center" class="texto_bold">Hora</td>
        <td align="center" class="texto_bold">H2So4 lts </td>
        <td align="center" class="texto_bold">Filtrado</td>
        <td width="9%" align="center" class="texto_bold">Fecha</td>
        <td width="10%" align="center" class="texto_bold">Peso B.A.D</td>
      </tr>
	  <?php
	  $ConLixi=" select * from lixiviacion_barro_anodico where fecha='".$FDesde."'";
	  if($cmbturno!='T')	  	
		  $ConLixi.=" and turno='".$cmbturno."' ";
	  $ConLixi.=" order by lixiviador,num_lixiviacion";	  
	  $RespLixi=mysqli_query($link, $ConLixi);
	  while($FilaLixi=mysqli_fetch_array($RespLixi))
	  {
	  ?>
		  <tr class="formulario" bgcolor="#CCCCCC">
			<td align="left"><?php echo "Lixiviador N ".$FilaLixi[lixiviador];?>&nbsp;</td>
			<td align="right"><?php echo $FilaLixi[num_lixiviacion];?>&nbsp;</td>
			<td align="right"><?php echo $FilaLixi[hora_carga];?>&nbsp;</td>
			<td align="right"><?php echo $FilaLixi[acidc];?>&nbsp;</td>
			<td align="right"><?php echo $FilaLixi[hora_filtracion];?></td>
			<td align="right"><?php echo $FilaLixi[fecha_carga];?>&nbsp;</td>
		    <td align="right"><?php echo $FilaLixi[bad];?></td>
		  </tr>
	  <?php
	  }
	  ?>	
    </table></td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"  /></td>
  </tr>
</table>
<BR>
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="13" align="center" class="TituloCabecera2">PLANTA DE SELENIO </td>
        </tr>
      <tr>
        <td colspan="2" align="center" class="texto_bold">Hornos en Proceso </td>
        <td colspan="4" align="center" class="texto_bold">Beneficio Barro </td>
        <td align="center" colspan="2" class="texto_bold">Producci&oacute;n Calcina </td>
        <td width="10%" rowspan="2" align="center" class="texto_bold"><p>Stock Calcina </p>
          </td>
        </tr>
      <tr>
        <td width="11%" align="center" class="texto_bold">Carga N&ordm; </td>
        <td width="17%" align="center" class="texto_bold">Fecha</td>
        <td width="12%" align="center" class="texto_bold">BAD DV </td>
        <td width="11%" align="center" class="texto_bold">BAD CN </td>
        <td width="10%" align="center" class="texto_bold">Rep.</td>
        <td width="9%" align="center" class="texto_bold">Total</td>
        <td width="13%" align="center" class="texto_bold">Fecha Filtrado</td>
        <td width="7%" align="center" class="texto_bold">KG.</td>
      </tr>
	  <?php
	//  $ConSele="select * from deselenizacion t1 left join detalle_deselenizacion t2 on t1.num_horno=t2.num_horno and t1.num_funda=t2.num_funda and t1.hornada_total=t2.hornada_total and t1.hornada_parcial=t2.hornada_parcial where t1.fecha='".$FDesde."' ";
	  $ConSele="select * from deselenizacion t1 where t1.fecha='".$FDesde."' ";
	  if($cmbturno!='T')
	  	$ConSele.=" and turno='".$cmbturno."'";
	  $ConSele.=" group by t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial order by t1.num_horno";	
	  //echo $ConSele;
	  $RespSele=mysqli_query($link, $ConSele);	$Total=0;
	  while($FilaSele=mysqli_fetch_array($RespSele))
	  {
	  	$Hornada=$FilaSele[num_horno]."-".$FilaSele[num_funda]."-".$FilaSele[hornada_total]."-".$FilaSele[hornada_parcial];
		
			//----------CONSULTO SI HAY REPROCESOS
			$ConCal="select sum(bad) as valorBADRep from pmn_web.detalle_deselenizacion where";
			$ConCal.=" num_horno='".$FilaSele[num_horno]."' and num_funda='".$FilaSele[num_funda]."' and hornada_total='".$FilaSele[hornada_total]."' and hornada_parcial='".$FilaSele[hornada_parcial]."'";
			$ConCal.=" and referencia like '%r%'";
			$RespCal=mysqli_query($link, $ConCal);$BADREP=0;
			if($FilaCal=mysqli_fetch_array($RespCal))
				$BADREP=$FilaCal[valorBADRep];
			//----------CONSULTO BAD ventanas
			$ConCal="select sum(bad) as valorBADDV from pmn_web.detalle_deselenizacion where";
			$ConCal.=" num_horno='".$FilaSele[num_horno]."' and num_funda='".$FilaSele[num_funda]."' and hornada_total='".$FilaSele[hornada_total]."' and hornada_parcial='".$FilaSele[hornada_parcial]."'";
			$ConCal.=" and referencia not like '%r%' and cod_producto='' and cod_subproducto=''";
			//echo $ConCal;
			$RespCal=mysqli_query($link, $ConCal);$BADDV=0;
			if($FilaCal=mysqli_fetch_array($RespCal))
				$BADDV=$FilaCal[valorBADDV];
			//----------CONSULTO BAD CODELCO NORTE
			$ConCal="select sum(bad) as valorBADCN from pmn_web.detalle_deselenizacion where";
			$ConCal.=" num_horno='".$FilaSele[num_horno]."' and num_funda='".$FilaSele[num_funda]."' and hornada_total='".$FilaSele[hornada_total]."' and hornada_parcial='".$FilaSele[hornada_parcial]."'";
			$ConCal.=" and cod_producto='25' and cod_subproducto='5'";
			$RespCal=mysqli_query($link, $ConCal);$BADCN=0;
			if($FilaCal=mysqli_fetch_array($RespCal))
				$BADCN=$FilaCal[valorBADCN];

			$Total=$BADCN+$BADDV+$BADREP;
			
			$AnoMes=explode('-',$FDesde);
			$ConStock="select sf_p from stock_pmn where cod_producto='36' and cod_subproducto='1' and ano='".$AnoMes[0]."' and mes='".$AnoMes[1]."'";
			$RespStock=mysqli_query($link, $ConStock);
			$FilaStock=mysqli_fetch_array($RespStock);
			$StockCal=$FilaStock[sf_p];
	  ?>
		  <tr bgcolor="#CCCCCC">
			<td align="center"><?php echo $Hornada;?></td>
			<td align="center"><?php echo $FilaSele["fecha"];?>&nbsp;</td>
			<td align="right"><?php echo number_format($BADDV,4,',','.');?>&nbsp;</td>
			<td align="right"><?php echo number_format($BADCN,4,',','.');?>&nbsp;</td>
			<td align="right"><?php echo number_format($BADREP,4,',','.');?>&nbsp;</td>
			<td align="right"><?php echo number_format($Total,4,',','.');?>&nbsp;</td>
			<td align="right"><?php echo $FilaSele[fecha_salida];?>&nbsp;</td>
			<td align="right"><?php echo number_format($FilaSele[prod_calcina],0,',','.');?>&nbsp;</td>
			<td align="right"><?php echo number_format($StockCal,2,',','.');?>&nbsp;</td>
		  </tr>
	  <?php
	  }
	  ?>	
    </table>
    <BR></td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"  /></td>
  </tr>
</table><br>
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="9" align="center" class="TituloCabecera2">HORNO TROF </td>
        </tr>
      <tr>
        <td width="11%" align="center" class="texto_bold">Hornada</td>
        <td colspan="3" align="center" class="texto_bold">Fecha de Inicio Fusi&oacute;n </td>
        <td colspan="3" align="center" class="texto_bold">Fecha Inicio Oxidaci&oacute;n </td>
        <td colspan="2" align="center" class="texto_bold">Horas de </td>
        </tr>
      <tr>
        <td rowspan="2" align="center" class="texto_bold">N&ordm;</td>
        <td width="12%" rowspan="2" align="center" class="texto_bold">Fecha Hora </td>
        <td colspan="2" align="center" class="texto_bold">Carga Acumulada </td>
        <td width="13%" rowspan="2" align="center" class="texto_bold">Fecha Hora </td>
        <td colspan="2" align="center" class="texto_bold">Carga Acumulada </td>
        <td width="11%" rowspan="2" align="center" class="texto_bold">Fusi&oacute;n Acum. </td>
        <td width="10%" rowspan="2" align="center" class="texto_bold">Oxidac. Acum. </td>
      </tr>
      <tr>
        <td width="12%" align="center" class="texto_bold">Calcina (Kg) </td>
        <td width="12%" align="center" class="texto_bold">Otros (Kg) </td>
        <td width="10%" align="center" class="texto_bold">Restos (Kg) </td>
        <td width="9%" align="center" class="texto_bold">Otros (Kg) </td>
        </tr>
		<?php
		$AnoMes=explode('-',$FDesde);
		$Ano=$AnoMes[0];
		$Mes=$AnoMes[1];
		$Consulta = "select * from pmn_web.carga_horno_trof t1 left join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t1.turno = t2.cod_subclase left join proyecto_modernizacion.subproducto t3 on t1.cod_producto = t3.cod_producto ";
		$Consulta.= " and t1.cod_subproducto = t3.cod_subproducto ";
		$Consulta.= " where t2.cod_clase = 1 ";
		//$Consulta.= " and hornada = '581113'";
		$Consulta.= " and fecha = '".$FDesde."'";
		$Consulta.= " group by t1.hornada order by t1.turno, t1.cod_producto, t1.cod_subproducto";
		//echo $Consulta."<br>";		
		$Respuesta = mysqli_query($link, $Consulta);		

		$i=1;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			$Consulta = "select t1.cod_producto,t1.cod_subproducto,sum(cantidad) as cantidad from pmn_web.carga_horno_trof t1 left join proyecto_modernizacion.sub_clase t2 ";
			$Consulta.= " on t1.turno = t2.cod_subclase left join proyecto_modernizacion.subproducto t3 on t1.cod_producto = t3.cod_producto ";
			$Consulta.= " and t1.cod_subproducto = t3.cod_subproducto ";
			$Consulta.= " where t2.cod_clase = 1 ";
			$Consulta.= " and hornada = '".$Row[hornada]."'";
			//$Consulta.= " and t1.cod_producto='".$Row["cod_producto"]."' and t1.cod_subproducto='".$Row["cod_subproducto"]."'";
			$Consulta.= " and fecha = '".$FDesde."'";
			$Consulta.= " group by t1.cod_producto,t1.cod_subproducto order by t1.turno, t1.cod_producto, t1.cod_subproducto";
			//echo $Consulta."<br>";		
			$Respuesta2 = mysqli_query($link, $Consulta);$Calcina=0;$Restos=0;	$OtrosOxidos=0;	
			$i=1;
			while ($Row2 = mysqli_fetch_array($Respuesta2))
			{
				if($Row2["cod_producto"]=='36' && $Row2["cod_subproducto"]=='1')
					$Calcina=$Row2[cantidad];
				if($Row2["cod_producto"]=='19')//RESTOS DE ANODOS
					$Restos=$Row2[cantidad];				
					
				//----------------CIRCULANTES Y OXIDO PLATA COBRE-------------			
				if($Row2["cod_producto"]=='42'||$Row2["cod_producto"]=='39'||$Row2["cod_producto"]=='29'||$Row2["cod_producto"]=='28')
					$OtrosOxidos=$Row2[cantidad];						
			}
			
			
			$Consulta3 = "select * from pmn_web.produccion_horno_trof ";
			//$Consulta.= " where fecha = '".$FDesde."'";
			$Consulta3.= " where hornada = '".$Row[hornada]."'";
			//echo $Consulta3;
			$Respuesta3 = mysqli_query($link, $Consulta3);
			if ($Row3 = mysqli_fetch_array($Respuesta3))
			{
				$Hornada = $Row3[hornada];
				$Obs = $Row3["observacion"];
				$GasIni = $Row3[gas_natural_ini];
				$GasFin = $Row3[gas_natural_fin];
				$NumAnodos = $Row3[num_anodos];
				$Peso = $Row3["peso"];
				$Operador = $Row3[operador];
				$Color = $Row3[color];
				$FHMol=explode(' ',$Row3[inicio_moldeo]);			
				$HoraMol=$FHMol[1];
				$FechaMol=$FHMol[0];
				$FechaFusion=$Row3['inicio_fusion'];
				$FechaOxida=$Row3['inicio_oxida'];
				list($YF,$MF,$DF)=explode('-',substr($Row3['inicio_fusion'],0,10));
				list($HF,$MinF)=explode(':',trim(substr($Row3['inicio_fusion'],10,8)));						
				$fecha1=mktime(intval($HF),intval($MinF),0,intval($MF),intval($DF),intval($YF));
				
				list($YO,$MO,$DO)=explode('-',substr($Row3['inicio_oxida'],0,10));
				list($HO,$MinO)=explode(':',trim(substr($Row3['inicio_oxida'],10,8)));						
				$fecha2=mktime(intval($HO),intval($MinO),0,intval($MO),intval($DO),intval($YO));
				
				list($YMol,$MMol,$DMol)=explode('-',substr($Row3['inicio_moldeo'],0,10));
				list($HMol,$MinMol)=explode(':',trim(substr($Row3['inicio_moldeo'],10,8)));						
				$fecha3=mktime(intval($HMol),intval($MinMol),0,intval($MMol),intval($DMol),intval($YMol));

				$SegFusion=$fecha2-$fecha1;
				$SegOxida=$fecha3-$fecha2;
				
				// Ahora pasas de segundos, a horas
				$HFusion=$SegFusion/60/60;
				$HOxida=$SegOxida/60/60;
			}
			echo "<tr bgcolor='#CCCCCC'>";
			echo "<td align='center'>".$Row[hornada]."&nbsp;</td>\n";
			echo "<td align='center'>".$FechaFusion."&nbsp;</td>\n";
			echo "<td align='center'>".number_format($Calcina,4,',','.')."&nbsp;</td>\n";
			echo "<td align='center'>0</td>\n";
			echo "<td align='center'>".$FechaOxida."&nbsp;</td>\n";
			echo "<td align='center'>".number_format($Restos,4,',','.')."&nbsp;</td>\n";
			echo "<td align='center'>".number_format($OtrosOxidos,4,',','.')."&nbsp;</td>\n";
			echo "<td align='center'>".number_format($HFusion,0,',','.')."&nbsp;</td>\n";
			echo "<td align='center'>".number_format($HOxida,0,',','.')."&nbsp;</td>\n";
			echo "</tr>\n";
			$i++;
			$Hornada=$Row[hornada];
		}
		//----------------------CONSULTO DATOS EN PESTAA PRODUCCIN---------------------------
		?>
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="2" align="center" class="texto_bold">Moldeo</td>
              <td colspan="3" align="center" class="texto_bold">Muestra</td>
              </tr>
            <tr>
              <td width="15%" align="center" class="texto_bold">Hora</td>
              <td width="16%" align="center" class="texto_bold">Fecha</td>
              <td width="12%" align="center" class="texto_bold">Te (Ppm) </td>
              <td width="12%" align="center" class="texto_bold">Se (Ppm) </td>
              <td width="13%" align="center" class="texto_bold">Cu (%) </td>
            </tr>
            <tr bgcolor="#CCCCCC">
              <td align="center"><?php echo $HoraMol;?>&nbsp;</td>
              <td align="center"><?php echo $FechaMol;?>&nbsp;</td>
			  <?php
				//------------------------------Muestras-------------------------------
				$Consulta = "select t1.cod_leyes, t2.abreviatura, t1.muestra01, t1.muestra02, t1.muestra03,t3.abreviatura as AbrevUni,hora01,hora02,hora03 ";
				$Consulta.= " from pmn_web.leyes_prod_horno_trof t1 inner join proyecto_modernizacion.leyes t2 on ";
				$Consulta.= " t1.cod_leyes = t2.cod_leyes ";
				$Consulta.=" inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad  ";
				//$Consulta.= " where fecha = '".$FDesde."'";
				$Consulta.= " and hornada = '".$Hornada."'";
				$Consulta.= " order by cod_leyes desc";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link, $Consulta);
				$i=1;
				while ($Row = mysqli_fetch_array($Respuesta))
				{
				  ?>
				  <td align="right"><?php echo number_format($Row[muestra01],4,',','.');?></td>
				  <?php
				}
				?>
            </tr>
          </table></td>
          <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="2" align="center" class="texto_bold">Producci&oacute;n</td>
              </tr>
            <tr>
              <td align="center" class="texto_bold">N&ordm; Anodos </td>
              <td align="center" class="texto_bold">Peso Kg. </td>
            </tr>
            <tr bgcolor="#CCCCCC">
              <td align="right"><?php echo number_format($NumAnodos,4,',','.');?>&nbsp;</td>
              <td align="right"><?php echo number_format($Peso,4,',','.');?>&nbsp;</td>
            </tr>
          </table></td>
          <td valign="top">
<!--			  <table width="100%" border="1" cellspacing="0" cellpadding="0">
				<tr>
				  <td width="55%" class="texto_bold">Anodos Acumulado </td>
				  <td width="45%" bgcolor="#CCCCCC">&nbsp;</td>
				</tr>
				<tr>
				  <td class="texto_bold">Peso Kg. </td>
				  <td bgcolor="#CCCCCC">&nbsp;</td>
				</tr>
			  </table>
-->		  </td>
        </tr>
      </table>
      <br>
      <br></td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"  /></td>
  </tr>
</table><br>
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="11" align="center" class="TituloCabecera2">ELECTROLISIS DE PLATA </td>
        </tr>
      <tr>
        <td width="8%" rowspan="2" align="center" class="texto_bold">Grupos</td>
        <td width="14%" align="center" class="texto_bold">Electr&oacute;lisis</td>
        <td colspan="3" align="center" class="texto_bold">Carga de Anodos </td>
        <td colspan="3" align="center" class="texto_bold">Descarga</td>
        <td width="5%" rowspan="2" align="center" class="texto_bold">Barro Acum. </td>
      </tr>
      <tr>
        <td align="center" class="texto_bold">N&ordm;</td>
        <td width="7%" align="center" class="texto_bold">Cantidad</td>
        <td width="11%" align="center" class="texto_bold">Fecha</td>
        <td width="13%" align="center" class="texto_bold">Peso Kg.</td>
        <td width="17%" align="center" class="texto_bold">Fecha</td>
        <td width="18%" align="center" class="texto_bold">Restos (Kg) </td>
        <td width="7%" align="center" class="texto_bold">Barro (Kg) </td>
        </tr>
		<?php
				$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
				$Consulta.= " where fecha='".$FDesde."'";
				if($cmbturno!='T')
					$Consulta.= " where turno='".$cmbturno."'";	  
				$Consulta.= " group by grupo,fecha order by turno, grupo, num_electrolisis, hornada, correlativo";
				//echo $Consulta;
				$Respuesta = mysqli_query($link, $Consulta);
				$i=1;
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					?>
					<tr class="formulario" bgcolor="#CCCCCC">
					<td align="center"><?php echo "M - ".$Row["grupo"];?></td>					
					<td align="center"><?php echo $Row[num_electrolisis];?></td>					
					<?php
					 $SumaCant="select * from pmn_web.carga_electrolisis_plata where fecha='".$FDesde."' and grupo='".$Row["grupo"]."'";
					 $RespCant=mysqli_query($link, $SumaCant);$Cant='0';$Hornadas='';$Peso='0';
					 while($FilaCant=mysqli_fetch_array($RespCant))
					 {
						$Cant=$Cant+$FilaCant[cant_anodos];
						$Hornadas=$Hornadas.$FilaCant[hornada].", ";
						$Peso=$Peso+$FilaCant[peso_anodos];
					 }	
					 if($Hornadas !='')
						$Hornadas=substr($Hornadas,0,strlen($Hornadas)-2);		
					?>
					<td align="right"><?php echo $Cant;?></td>					
					<td align="center"><?php echo $Row["fecha"];?></td>
					<td align="right"><?php echo number_format($Peso,4,',','.');?></td>
					<?php
					$ConDesc="select * from descarga_electrolisis_plata where num_electrolisis='".$Row[num_electrolisis]."'";
					$RespDesc=mysqli_query($link, $ConDesc);
					if($FilaDesc=mysqli_fetch_array($RespDesc))
					{
						$FechaDes=$FilaDesc["fecha"];
						$Restos=$FilaDesc[peso_resto];
						$Barro=$FilaDesc[peso_aurifero];
					}
					?>
					<td align="center"><?php echo $FechaDes;?>&nbsp;</td>
					<td align="right"><?php echo number_format($Restos,4,',','.');?>&nbsp;</td>
					<td align="right"><?php echo number_format($Barro,4,',','.');?>&nbsp;</td>
					<td align="right"><?php echo "&nbsp;";?></td>
					</tr>
				<?php	
					$i++;
				}
	   ?>
      <tr>
        <td colspan="11" class="formulario">&nbsp;</td>
        </tr>
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="1" cellspacing="0" cellpadding="0" style="vertical-align:top;">
            <tr>
              <td colspan="6" align="center" class="TituloCabecera2">LIXIVIACION DE ORO </td>
            </tr>
			<tr>
			  <td rowspan="2" align="center" class="formulario">Correlativo Cargado </td>
			  <td colspan="2" align="center" class="formulario">Fecha de Carga Bajando</td>
			</tr>
			<tr>
			  <td align="center" class="formulario">Fecha</td>
			  <td align="center" class="formulario">Peso (Kg) </td>
			</tr>
			<?php
			 $Consulta="select * from carga_lixiviacion_barro_aurifero where fecha='".$FDesde."'";
			 if($cmbturno!='T')
				$Consulta.= " where turno='".$cmbturno."'";	 
			 $Consulta.= " order by num_electrolisis";	 
			 $Resp=mysqli_query($link, $Consulta);	
			 while($Filas=mysqli_fetch_assoc($Resp))
			 { 
			?>
				<tr bgcolor="#CCCCCC">
					<td class="formulario"><?php echo $Filas[correlativo];?></td>
					<td class="formulario" align="center"><?php echo $Filas["fecha"];?></td>
					<td class="formulario" align="right"><?php echo number_format($Filas["peso"],2,',','.');?></td>
				</tr>
			<?php
			}
			?>
          </table></td>
          <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="4" align="center" class="TituloCabecera2">ELECTROLISIS DE ORO </td>
              </tr>
            <tr>
              <td align="center" class="formulario">Elec.</td>
              <td align="center" class="formulario">N&ordm;</td>
              <td colspan="2" align="center" class="formulario">&nbsp;</td>
              </tr>
            <tr>
              <td align="center" class="formulario">N&ordm;</td>
              <td align="center" class="formulario">Anodos</td>
              <td align="center" class="formulario">Fecha</td>
              <td align="center" class="formulario">Peso</td>
            </tr>
			<?php
			$Consulta="select * from carga_electrolisis_oro where fecha='".$FDesde."'";
			if($cmbturno!='T')
				$Consulta.=" and turno='".$cmbturno."'";
			$Resp=mysqli_query($link, $Consulta);	
			while($Filas=mysqli_fetch_array($Resp))
			{
			?>
				<tr bgcolor="#CCCCCC"> 
				  <td align="center" class="formulario"><?php echo $Filas[num_electrolisis];?>&nbsp;</td>
				  <td align="right" class="formulario"><?php echo $Filas[cant_anodos];?>&nbsp;</td>
				  <td align="center" class="formulario"><?php echo $Filas["fecha"];?>&nbsp;</td>
				  <td align="right" class="formulario"><?php echo number_format($Filas[peso_anodos],2,',','.');?>&nbsp;</td>
				</tr>
			<?php
			}
			?>
          </table></td>
        </tr>
      </table>
      <br>
      <br></td><td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"  /></td>
  </tr>
</table>
<?php
}
?>
</form>
</body>
</html>
<?php
echo "<script language='javascript'>";
if($Mensaje!='')
	echo "alert('".$Mensaje."');";
echo "</script>";



function Sales($producto,$subproducto,$Ano,$Mes,&$Valor1,&$Valor2)
{
	$Consulta1 = "Select SUM(peso) as Peso from pmn_web.produccion_subproductos ";
	$Consulta1.= " where year(fecha_produccion)= '".$Ano."' and month(fecha_produccion)='".$Mes."'  and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta1."<br>";
	$Respuesta1 = mysqli_query($link, $Consulta1);
	if ($Row1 = mysqli_fetch_array($Respuesta1))
		$Valor1=$Row1["peso"];							

	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}
function Calcina($producto,$subproducto,$Ano,$Mes,$Valor1,$Valor2)
{
	$Consulta1 = "Select SUM(prod_calcina) as ValorCal from pmn_web.deselenizacion ";
	$Consulta1.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."'";
	//echo $Consulta1."<br>";
	$Respuesta1 = mysqli_query($link, $Consulta1);
	if ($Row1 = mysqli_fetch_array($Respuesta1))
		$Valor1=$Row1[ValorCal];							

	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}
function oxido($producto,$subproducto,$Ano,$Mes,$Valor1,$Valor2)
{
	$Consulta3 = "Select SUM(valor) as ValorPeso from pmn_web.produccion_circulantes_oxidos ";
	$Consulta3.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta1."<br>";
	$Respuesta3 = mysqli_query($link, $Consulta3);
	if ($Row3 = mysqli_fetch_array($Respuesta3))
		$Valor1=$Row3[ValorPeso];

	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}
function ranodos($producto,$subproducto,$Ano,$Mes,$Valor1,$Valor2)
{
	$Consulta4 = "Select SUM(peso_resto) as ValorPeso from pmn_web.descarga_electrolisis_plata ";
	$Consulta4.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."'";
	//echo $Consulta1."<br>";
	$Respuesta4 = mysqli_query($link, $Consulta4);
	if ($Row4 = mysqli_fetch_array($Respuesta4))
		$Valor1=$Row4[peso_resto];
	
	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}

function BarroAuLixi($producto,$subproducto,$Ano,$Mes,&$Valor1,&$Valor2)
{
	$Consulta4 = "Select SUM(peso) as ValorPeso from pmn_web.carga_lixiviacion_barro_aurifero ";
	$Consulta4.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."'";
	//echo $Consulta1."<br>";
	$Respuesta4 = mysqli_query($link, $Consulta4);
	if ($Row4 = mysqli_fetch_array($Respuesta4))
		$Valor1=$Row4[ValorPeso];

	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}

function MetalDore($producto,$subproducto,$Ano,$Mes,&$Valor1,&$Valor2)
{
	$Consulta = "select sum(num_anodos) as ProdAnodos from pmn_web.produccion_horno_trof ";
	$Consulta.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."'";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	if($Row = mysqli_fetch_array($Respuesta))
		$Valor1=$Row4[ProdAnodos];

	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}

function Escorias($producto,$subproducto,$Ano,$Mes,&$Valor1,&$Valor2)
{
	$Consulta = "select sum(peso) as PesoFusi from pmn_web.fusion ";
	$Consulta.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."'";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	if($Row = mysqli_fetch_array($Respuesta))
		$Valor1=$Row4[PesoFusi];

	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}
?>

