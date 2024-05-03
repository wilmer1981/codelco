<?php
	include("../principal/conectar_principal.php");
	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename = "";
	if ( preg_match( '/MSIE/i', $userBrowser ) ) {
	$filename = urlencode($filename);
	}
	$filename = iconv('UTF-8', 'gb2312', $filename);
	$file_name = str_replace(".php", "", $file_name);
	header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
	header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");    
	header("content-disposition: attachment;filename={$file_name}");
	header( "Cache-Control: public" );
	header( "Pragma: public" );
	header( "Content-type: text/csv" ) ;
	header( "Content-Dis; filename={$file_name}" ) ;
	header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	$DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	$MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	$AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	$DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	$MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	$AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y"); 
	$cmbcircuito = isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:""; 

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
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	alert (fecha1);
	alert (fecha2);
	document.location = "ref_globales_selec_catodos_xls.php?DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value+"&DiaFin="+f.DiaFin.value+"&MesFin="+f.MesFin.value+"&AnoFin="+f.AnoFin.value;
}
function detalle_anodos(fecha,grupo)
{
	var Frm=document.form1;
	window.open("Detalle_carga_anodos.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}
</script>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
	<table width="632" border="0" align="center" cellpadding="2" cellspacing="0">
		<tr align="left"> 
    		<td colspan="7"><strong>INFORME DE CLASIFICACION FISICA DE CATODOS COMERCIALES (detalle rechazo por circuito)
			</strong></td>
    	</tr>
		<tr> 
			<td width="30" ><strong>Fecha Inicio :<?php echo $FechaInicio;?></strong></td>
	  			<input name="AnoIni" type="hidden" value="<?php echo $AnoIni;?>">
	  			<input name="MesIni" type="hidden" value="<?php echo $MesIni;?>">
	  			<input name="DiaIni" type="hidden" value="<?php echo $DiaIni;?>"></td>
      		<td width="30"></td>
      		<td width="30"><strong>Fecha Termino :<?php echo $FechaTermino;?></strong></td>
	  			<input name="AnoFin" type="hidden" value="<?php echo $AnoFin;?>">
	  			<input name="MesFin" type="hidden" value="<?php echo $MesFin;?>">
	  			<input name="DiaFin" type="hidden" value="<?php echo $DiaFin;?>"></td>
      		<td width="47" ></td>
      		<td width="162"></td>
    	</tr>
	</table>
  	<table width="955" align="center">
  	<?php 
 		echo "<input name='cmbcircuito' type='hidden' value='".$cmbcircuito."'>"; 
			if ($cmbcircuito!='99')
	   		{
    			$consulta="select distinct cod_grupo from ref_web.grupo_electrolitico2 where cod_circuito='".$cmbcircuito."' and cod_grupo not in ('01','02','07') order by cod_grupo";
	   		}
	 		else 
			{
				$consulta="select distinct cod_grupo from ref_web.grupo_electrolitico2 where cod_grupo not in ('01','02','07') order by cod_grupo";}   
	 			$rs = mysqli_query($link, $consulta);
				//echo "aa".$consulta."</br>";
				$cont=0;
				$total_ne=0;
				$total_nd=0;
				$total_ra=0;
				$total_cs=0;
				$total_cl=0;
				$total_ai=0;
				$total_qu=0;
				$total_re=0;
				$total_ot=0;
				$total_dias_total=0;
				while ($row = mysqli_fetch_array($rs))
	    		{
		  			if (($cont==3)||($cont==6)||($cont==9)||($cont==12)||($cont==15)||($cont==18)||($cont==21)||($cont==24)||($cont==27)
					    ||($cont==30)||($cont==33)||($cont==36)||($cont==39)||($cont==42)||($cont==45)||($cont==48)||($cont==51)) 
		   			{
						echo '<tr>';}
		  				echo '<td>';
						echo '<table width="250" border="2" cellspacing="1" cellpadding="1">';
          				echo '<tr">'; 
          				echo '<td colspan="8" align="center"><strong>Grupo '.$row["cod_grupo"].'</strong></td>';
          				echo '</tr>';
        				echo '<td  align="center"><strong>Fecha</strong><strong></strong></td>';
          				echo '<td  align="center"><strong>NE</strong><strong></strong></td>';
          				echo '<td  align="center"><strong>ND</strong></td>';
		  				echo '<td  align="center"><strong>RA</strong></td>';
		  				echo '<td  align="center"><strong>CS</strong></td>';
		  				echo '<td  align="center"><strong>CL</strong></td>';
		  				echo '<td  align="center"><strong>QU</strong></td>';
		  				echo '<td  align="center"><strong>RE</strong></td>';
		  				echo '<td  align="center"><strong>AI</strong></td>';
		  				echo '<td  align="center"><strong>OT</strong></td>';
		  				echo '<td  align="center"><strong>Total</strong></td>';
          				echo '</tr>';
						$consulta_cortos="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,sum(rayado) as ra,";
						$consulta_cortos.="sum(cordon_superior) as cs,sum(cordon_lateral) as cl,sum(quemados) as qu,sum(redondos) as re,";
						$consulta_cortos.="sum(aire) as ai,sum(otros) as ot , fecha from cal_web.rechazo_catodos ";
		  				$consulta_cortos.=" where fecha BETWEEN '".$FechaInicio."' and '".$FechaTermino."'  and grupo='".intval($row["cod_grupo"])."' group by fecha";
		  				//echo "kkk".$consulta_cortos."</br>";				
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
					?>
				  	<tr
				    	<?php echo substr($row_cortos["fecha"],8,2).'/'.substr($row_cortos["fecha"],5,2).'/'.substr($row_cortos["fecha"],0,4);?> grupo <?php echo $row["cod_grupo"];?>&nbsp;es de&nbsp;<?php echo $row_cortos["ne"]+$row_cortos["nd"]+$row_cortos["ra"]+$row_cortos["cs"]+$row_cortos["cl"]+$row_cortos["qu"]+$row_cortos["re"]+$row_cortos["ai"]+$row_cortos["ot"]?> Laminas">
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
				   		$total_dia=$row_cortos["ne"]+$row_cortos["nd"]+$row_cortos["ra"]+$row_cortos["cs"]+$row_cortos["cl"]+$row_cortos["qu"]+$row_cortos["re"]+$row_cortos["ai"]+$row_cortos["ot"];
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
		  			echo '<tr>';
		  			echo '<td  align="center"><strong>TOTALES</strong></td>';
		  			echo '<td  align="center">'.$total_ne.'</td>';
		  			echo '<td  align="center">'.$total_nd.'</td>';
		  			echo '<td  align="center">'.$total_ra.'</td>';
		  			echo '<td  align="center">'.$total_cs.'</td>';
		 			echo '<td  align="center">'.$total_cl.'</td>';
		 			echo '<td  align="center">'.$total_qu.'</td>';
		 			echo '<td  align="center">'.$total_re.'</td>';
		 			echo '<td  align="center">'.$total_ai.'</td>';
		  			echo '<td  align="center">'.$total_ot.'</td>';
		  			echo '<td  align="center">'.$total_dias_total.'</td>';
          			echo '</table>';
          			echo '</td>';
					
					
		}
		
	?> 
 </table>
</form>
</body>
</html>
 




