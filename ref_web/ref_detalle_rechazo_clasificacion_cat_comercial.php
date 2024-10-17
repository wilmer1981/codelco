<?php
	include("../principal/conectar_principal.php");
	$DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	$MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	$AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	$DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	$MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	$AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");
	$cmbcircuito= isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:"";

	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
	
	
?>
<html>
<head>
<title>Informe Clasificacion Catodos Conerciales</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1(opcion)
{	
	var f = document.frmPrincipal;
	if (opcion=='S')
	  // {f.action = "cortes2_aux.php?recarga=S"+"&dia1="+f.dia1.value+"&mes1="+f.mes1.value+"&ano1="+f.ano1.value+"&circuito="+f.cmbcircuito.value+"&mostrar=S&Buscar=N";}
	   {f.action = "ref_clasificacion_catodos_comerciales.php?cmbcircuito="+f.cmbcircuito.value+"&Buscar=S"+"&DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value;}
	f.submit();
}
function Imprimir(f)
{
  window.print();
}
function Salir(f)
{
 window.close();
}
function Grafico(f)
{
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	
	var URL ="../ref_web/ref_grafico_clasificacion_cat_com_global.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=930 height=650 scrollbars=no");
}	
function Excel(f)

{
	var f = document.frmPrincipal;
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	document.location = "ref_globales_selec_catodos_xls.php?DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value+"&DiaFin="+f.DiaFin.value+"&MesFin="+f.MesFin.value+"&AnoFin="+f.AnoFin.value+"&cmbcircuito="+f.cmbcircuito.value;
}
function detalle_anodos(fecha,grupo)
{
	var Frm=document.form1;
	window.open("Detalle_carga_anodos.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="632" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" > 
      <td colspan="7" class="ColorTabla01"><strong>INFORME DE CLASIFICACION FISICA 
        DE CATODOS COMERCIALES (detalle rechazo por circuito)</strong></td>
    </tr>
    <tr> 
      <td width="90" class="Detalle02"><strong>Fecha Inicio:</strong></td>
      <td width="84" class="detalle01"><strong><?php echo $FechaInicio;?></strong>
	  <input name="AnoIni" type="hidden" value="<?php echo $AnoIni;?>">
	
	  <input name="MesIni" type="hidden" value="<?php echo $MesIni;?>">
	  <input name="DiaIni" type="hidden" value="<?php echo $DiaIni;?>"></td>
      <td width="51"></td>
      <td width="89" class="Detalle02"><strong>Fecha Termino:</strong></td>
      <td width="78" class="detalle01"><strong><?php echo $FechaTermino;?></strong>
	  <input name="AnoFin" type="hidden" value="<?php echo $AnoFin;?>">
	  <input name="MesFin" type="hidden" value="<?php echo $MesFin;?>">
	  <input name="DiaFin" type="hidden" value="<?php echo $DiaFin;?>"></td>
      <td width="47" >&nbsp;</td>
      <td width="162">&nbsp;</td>
    </tr>
  </table>
  <table width="955" align="center">
 <?php 
 	echo "<input name='cmbcircuito' type='hidden' value='".$cmbcircuito."'>"; 
	if ($cmbcircuito!='99')
	   {
    	$consulta="select distinct cod_grupo from ref_web.grupo_electrolitico2 where cod_circuito='".$cmbcircuito."' and cod_grupo not in ('01','02','07') order by cod_grupo";
	   }
	else {$consulta="select distinct cod_grupo from ref_web.grupo_electrolitico2 where cod_grupo not in ('01','02','07') order by cod_grupo";}   
	$rs = mysqli_query($link, $consulta);
	$cont=0;
	$total_ne=0;
	$total_nd=0;
	$total_ra=0;
	$total_cs=0;
	$total_cl=0;
	$total_qu=0;
	$total_re=0;
	$total_ai=0;
	$total_ot=0;
	$total_dias_total=0;
	while ($row = mysqli_fetch_array($rs))
	    {
		  //if (($cont==4)||($cont==8)||($cont==12)||($cont==16)||($cont==20)||($cont==24)||($cont==28)||($cont==32)||($cont==36)||($cont==40)||($cont==44)||($cont==48)) 
		  if (($cont==3)||($cont==6)||($cont==9)||($cont==12)||($cont==15)||($cont==18)||($cont==21)||($cont==24)||($cont==27)||
		      ($cont==30)||($cont==33)||($cont==36) ||($cont==39)||($cont==42)||($cont==45)||($cont==48)||($cont==51)) 
		   {echo '<tr>';}
		  echo '<td>';
		  echo '<table width="290" border="2" cellspacing="1" cellpadding="1" bordercolor="#b26c4a" class="TablaDetalle">';
          echo '<tr bgcolor="#FFFFFF" class="ColorTabla01">'; 
          echo '<td colspan="8" align="center"><strong>Grupo '.$row["cod_grupo"].'</strong></td>';
          echo '</tr>';
          echo '<tr bgcolor="#FFFFFF" class="ColorTabla01"> ';
		  echo '<td  align="center"><strong>Fecha</strong><strong></strong></td>';
          echo '<td  align="center"><strong>NE</strong><strong></strong></td>';
          echo '<td align="center">ND</td>';
		  echo '<td  align="center">RA</td>';
		  echo '<td align="center">CS</td>';
		  echo '<td  align="center">CL</td>';
		  echo '<td  align="center">QU</td>';
		  echo '<td  align="center">RE</td>';
		  echo '<td  align="center">AI</td>';
		  echo '<td  align="center">OT</td>';
		  echo '<td  align="center">Total</td>';
          echo '</tr>';
		  $consulta_cortos="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,sum(rayado) as ra,sum(cordon_superior) as cs,";
		  $consulta_cortos.="sum(cordon_lateral) as cl,sum(quemados) as qu,sum(redondos) as re,sum(aire) as ai,sum(otros) as ot , fecha from cal_web.rechazo_catodos ";
		  $consulta_cortos.=" where fecha BETWEEN '".$FechaInicio."' and '".$FechaTermino."'  and grupo='".intval($row["cod_grupo"])."' group by fecha";
		  $respuesta_cortos = mysqli_query($link, $consulta_cortos);
		  $total_ne=0;
		  $total_nd=0;
		  $total_ra=0;
		  $total_cs=0;
		  $total_cl=0;
		  $total_qu=0;
		  $total_re=0;
		  $total_ai=0;
		  $total_ot=0;
		  $total_dias_total=0;
	 	  while ($row_cortos = mysqli_fetch_array($respuesta_cortos))
		        { 
				  //$obs=concatena_observacion($row_cortos["fecha"],row["cod_grupo"]);
				?>
				  <tr onMouseOver="if(!this.contains(event.fromElement)){this.bgColor='class=ColorTabla02';} if(!document.all){style.cursor='pointer'};style.cursor='hand';" onMouseOut="if(!this.contains(event.toElement)){this.bgColor=''; }" title="Total Rechazo <?php echo substr($row_cortos["fecha"],8,2).'/'.substr($row_cortos["fecha"],5,2).'/'.substr($row_cortos["fecha"],0,4);?> grupo <?php echo $row["cod_grupo"];?>&nbsp;es de&nbsp;<?php echo $row_cortos["ne"]+$row_cortos["nd"]+$row_cortos["ra"]+$row_cortos["cs"]+$row_cortos["cl"]+$row_cortos["ot"]?> Laminas">
				 <?php 
				   echo '<td  align="center" class=detalle01>'.$row_cortos["fecha"].'</td>';
				   echo '<td align="center">'.$row_cortos["ne"].'</td>';
				   echo '<td align="center">'.$row_cortos["nd"].'</td>';
				   echo '<td align="center">'.$row_cortos["ra"].'</td>';
				   echo '<td  align="center">'.$row_cortos["cs"].'</td>';
				   echo '<td  align="center">'.$row_cortos["cl"].'</td>';
				   echo '<td  align="center">'.$row_cortos["qu"].'</td>';
				   echo '<td  align="center">'.$row_cortos["re"].'</td>';
				   echo '<td  align="center">'.$row_cortos["ai"].'</td>';
				   echo '<td  align="center">'.$row_cortos["ot"].'</td>';
				   $total_dia=$row_cortos["ne"]+$row_cortos["nd"]+$row_cortos["ra"]+$row_cortos["cs"]+$row_cortos["cl"];
				   $total_dia=$total_dia+$row_cortos["qu"]+$row_cortos["re"]+$row_cortos["ai"]+$row_cortos["ot"];
				   echo '<td  align="center">'.$total_dia.'</td>';
				   $total_ne=$total_ne+$row_cortos["ne"];
				   $total_nd=$total_nd+$row_cortos["nd"];
				   $total_ra=$total_ra+$row_cortos["ra"];
				   $total_cs=$total_cs+$row_cortos["cs"];
				   $total_cl=$total_cl+$row_cortos["cl"];
				   $total_qu=$total_qu+$row_cortos["qu"];
				   $total_re=$total_re+$row_cortos["re"];
				   $total_ai=$total_ai+$row_cortos["ai"];
				   $total_ot=$total_ot+$row_cortos["ot"];
				   $total_dias_total=$total_dias_total+$total_dia;
				   echo '</tr>';
				}  
		  $cont++;
		  echo '<tr class="ColorTabla01">';
		  echo '<td  align="center">TOTALES</td>';
		  echo '<td  align="center">'.$total_ne.'</td>';
		  echo '<td  align="center">'.$total_nd.'</td>';
		  echo '<td  align="center">'.$total_ra.'</td>';
		  echo '<td  align="center">'.$total_cs.'</td>';
		  echo '<td  align="center">'.$total_cl.'</td>';
		  echo '<td  align="center">'.$total_qu.'</td>';
		  echo '<td  align="center">'.$total_re.'</td>';
		  echo '<td  align="center">'.$total_ai.'</td>';
		  echo '<td  align="center">'.$total_ot.'</td>';
		  echo '<td  align="center" class=detalle01>'.$total_dias_total.'</td>';
          echo '</table>';
          echo '</td>';
		}       
 ?> 
</table>

  <p>&nbsp;</p>
  <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"><input name="btnimprimir2" type="button" value="Excel" style="width:70;" onClick="JavaScript:Excel(this.form)"> 
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)"> 
      <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir(this.form)" value="Salir"></td>
  </tr>
	</table>
</form>
</body>
</html>