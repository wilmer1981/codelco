<?php
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
include("../principal/conectar_ref_web.php");

    $DiaIni    = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");
	$MesIni    = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	$AnoIni    = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");	

	$DiaFin    = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d");
	$MesFin    = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m");
	$AnoFin    = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");
	
?>

<html>
<head> 
<title>Informe Circuitos Comerciales</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">

<script language="JavaScript">

</script>
</head>


<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPopup" action="" method="post">
  <table width="433" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
<tr>
  <td width="421" align="center" valign="middle">
  
  <table width="465" border="1" cellspacing="0" cellpadding="3">
          <tr> 
            <td width="141">Fecha Inicio: <?php echo $DiaIni.'-'.$MesIni.'-'.$AnoIni?></td>
            <td width="246">Fecha Termino:<?php echo $DiaFin.'-'.$MesFin.'-'.$AnoFin?></td>
          </tr>
          <tr> 
         <p align="center"><strong>Ponderados</strong></p>
  <table width="786" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01"> 
      <td width="200" align="center"><div align="center"><strong>Global Cir. Comerciales</strong></div></td> 
		  <?php 
		 $ArrLeyes = array();
	     $consulta = "SELECT * FROM ref_web.leyes";
		 $consulta.= " ORDER BY cod_leyes asc";
		 $rs = mysqli_query($link, $consulta);
		 while ($row = mysqli_fetch_array($rs))
			{
				echo '<td width="73">'.$row["abreviatura"].'</td>';
			    $ArrLeyes[$row["cod_leyes"]][0]=$row["cod_leyes"];
				$ArrLeyes[$row["cod_leyes"]][1]=$row["abreviatura"];
				$leyes_cod[] = "'".$row["cod_leyes"]."'";
				$ArrLeyes[$row["cod_leyes"]][1]="";
		    }?>
   
  </tr>  
 <?php 
            if (strlen($DiaIni) == 1)
		       {$DiaIni = '0'.$DiaIni;}
			if (strlen($DiaFin) == 1)
		       {$DiaFin = '0'.$DiaFin;}   
	        if (strlen($MesFin)== 1) 
        		{$MesFin = '0'.$MesFin;}
			if (strlen($MesIni)== 1) 
        		{$MesIni = '0'.$MesIni;}	
  			$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
			$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
			
			$consulta_fecha="select distinct left(t1.fecha_muestra,10) as fecha from cal_web.solicitud_analisis as t1 ";
			$consulta_fecha.="inner join cal_web.leyes_por_solicitud as t2 on t1.fecha_hora=t2.fecha_hora and ";
			$consulta_fecha.="t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and ";
			$consulta_fecha.="t1.rut_funcionario=t2.rut_funcionario and t1.id_muestra=t2.id_muestra ";
			$consulta_fecha.="where ceiling(t2.id_muestra)in ('1','2','3','4','5','6') and t2.id_muestra not in ('1-HM') ";
			$consulta_fecha.="and t2.cod_producto='41' ";
			$consulta_fecha.="and t2.cod_subproducto='22' ";
			$consulta_fecha.="and left(t1.fecha_muestra,10) between '".$FechaInicio."' and '".$FechaTermino."' ";
			$Respuesta_fecha = mysqli_query($link, $consulta_fecha);
			while ($Fila_fecha = mysqli_fetch_array($Respuesta_fecha))
				{
				  echo '<tr>';
				  echo "<td align='center' width='85' class=detalle01>".$Fila_fecha["fecha"]."</td>\n";
				  $consulta="select  left(t1.fecha_muestra,10) as fecha , ";
				  $consulta.="(sum(case when t1.id_muestra = '1' then (t2.valor*0.5) else t2.valor end )/5.5) as valor, ";
				  $consulta.="t2.candado,t2.cod_unidad,t2.cod_leyes ";
				  $consulta.="from cal_web.solicitud_analisis as t1 ";
				  $consulta.="inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and ";
				  $consulta.="t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.rut_funcionario=t2.rut_funcionario ";
				  $consulta.="and t1.id_muestra=t2.id_muestra ";
				  $consulta.="where ceiling(t2.id_muestra) in ('1','2','3','4','5','6') ";
				  $consulta.="and t2.id_muestra not in ('1-HM') and t2.cod_producto='41' and t2.cod_subproducto='22' ";
				  $consulta.="and t2.cod_leyes in (".implode(',',$leyes_cod).") ";
				  $consulta.="and left(t1.fecha_muestra,10)='".$Fila_fecha["fecha"]."' ";
				  $consulta.="group by left(t1.fecha_muestra,10) ,t2.cod_leyes ";
				  $consulta.="order by left(t1.fecha_muestra,10) asc,t2.cod_leyes";
				  $respuesta=mysqli_query($link, $consulta);
				  while ($row=mysqli_fetch_array($respuesta))
					{
						$ArrLeyes[$row["cod_leyes"]][2]=$row["valor"];					  					
					}
					reset($ArrLeyes);
					foreach($ArrLeyes as $k => $v)
					{
						if ($v[2]!='')
						{
							echo "<td align='center' width='85' class=detalle01>".number_format($v[2],"2",".",".")."&nbsp;</td>\n";
						}else{
							echo "<td align='center' width='85' class=detalle01>&nbsp;</td>\n";
						}
					}
					reset($ArrLeyes);
					do {			 
	  				$key = key ($ArrLeyes);
	  				$ArrLeyes[$key][2] = "";
					} while (next($ArrLeyes));
					
					
						  
				  echo '<tr>';		
				}
             				
?>
</table> 
</tr>
</table> 
<br>
  </form>
</body>
</html>
<?php 	include("../principal/cerrar_sec_web.php"); ?>


