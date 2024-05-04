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
	include("../principal/conectar_principal.php");


	$buscar     = isset($_REQUEST["buscar"])?$_REQUEST["buscar"]:""; 
	$opcion     = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$FechaInicio = isset($_REQUEST["FechaInicio"])?$_REQUEST["FechaInicio"]:""; 
	$FechaTermino = isset($_REQUEST["FechaTermino"])?$_REQUEST["FechaTermino"]:""; 

	$DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	$MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	$AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	$DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	$MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	$AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y"); 
?>
<html>
<head>
<title>Informe Estadistica Pulido de Placas</title>
</head>
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" > 
      <td colspan="6" class="ColorTabla01"><strong>INFORME ESTADISTICAS PULIDO 
        DE PLACAS</strong></td>
    </tr>
    <tr> 
      <td colspan="6"></td>
    </tr>
    <tr> 
      <td width="157">Fecha Inicio:<?php echo $FechaInicio;?>Fecha Termino:<?php echo $FechaTermino?></td>
    </tr>
    <tr align="center"> 
      <td height="10" colspan="5"> 
    <tr> 
	<?php if ($opcion=='PN')
	      { ?>
           <td width="157" height="11"> Informe de Placas Negras  
	   <?php } 
		 else if ($opcion=='PP')
		         { ?>   
                   <td width="200"> Informe de Placas con Pernos 
			  <?php } 
			     else { ?>
				          <td width="378"> Informe de Placas Negras y Placas con Pernos 
				   <?php }?>  
      
    </tr>
  </table>
  </td></p>
      <td colspan="2"></td></tr>
  </table>
  <table width="687" align="center">
    <?php 
    if (($buscar=='S') and (($opcion=='PP') or ($opcion=='PN')))
        {	   
		      echo '<tr align="center">';
			  echo '<td>';
			  echo '<table width="756" border="2" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
              echo '<tr class="ColorTabla01">';
			  if ($opcion=='PN')
			     {echo '<td colspan="9" align="center"><strong>Placas Negras</strong></td>';}
			  else if ($opcion='PP')
			          {echo '<td colspan="9" align="center"><strong>Placas con Pernos</strong></td>';}	 
              echo '</tr>';
			  echo '<tr class="ColorTabla01">';
			  echo '<td width="90" rowspan="2" align="center"><strong>&nbsp;</strong><strong></strong><strong>Fecha</strong><strong></strong></td>';
			  echo '<td colspan="3" align="center"><strong>Arman</strong><strong></strong></td>';
			  echo '<td colspan="3" align="center"><strong>Cambian</strong></td>';
			  echo '<td colspan="2" align="center"><strong>Stock</strong></td>';
			  echo '</tr>';
			  echo '<tr class="ColorTabla01"> ';
			  echo '<td width="44" align="center"><strong>Turno A</strong></td>';
			  echo '<td width="48" align="center"><strong>Turno B</strong></td>';
			  echo '<td width="55" align="center"><strong>Total</strong></td>';
			  echo '<td width="62" align="center"><strong>Turno A</strong></td>';
			  echo '<td width="70" align="center"><strong>Turno B</strong></td>';
			  echo '<td width="70" align="center"><strong>Total</strong></td>';
			  echo '<td width="101" align="center"><strong>Turno A</strong></td>';
			  echo '<td width="107" align="center"><strong>Turno B</strong></td>';
			  echo '</tr>';
			  if ($opcion=='PN')
			     {
				   $consulta="select distinct fecha from ref_web.pulido_placas where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."'";
                   $respuesta=mysqli_query($link, $consulta);
				   while ($row=mysqli_fetch_array($respuesta))
				        {
						 echo '<tr>';
						 echo '<td width="120" align="center" class=detalle01><strong>'.$row["fecha"].'</strong><strong></strong></td>';
					     $consulta_placas="select fecha,placas_negras,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='1' order by fecha,cod_operacion,turno";
						 $respuesta_placas=mysqli_query($link, $consulta_placas);
						 $total_arman=0;
						 $total_cambian=0;	
						 while ($row_placas=mysqli_fetch_array($respuesta_placas))
						       {
							     echo '<td align="center">'.$row_placas["placas_negras"].'</td>';
								 $total_arman=$total_arman+$row_placas["placas_negras"];
							   }
						 echo '<td align="center" class="detalle01">'.$total_arman.'</td>';
						 $consulta_placas="select fecha,placas_negras,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='2' order by fecha,cod_operacion,turno";
						 $respuesta_placas=mysqli_query($link, $consulta_placas);
						 $total_arman=0;	
						 while ($row_placas=mysqli_fetch_array($respuesta_placas))
						       {
						         echo '<td align="center">'.$row_placas["placas_negras"].'</td>';
								 $total_cambian=$total_cambian+$row_placas["placas_negras"];
						       }
						 echo '<td align="center" class="detalle01">'.$total_cambian.'</td>';	   
						  $consulta_placas="select fecha,placas_negras,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='3' order by fecha,cod_operacion,turno";
						 $respuesta_placas=mysqli_query($link, $consulta_placas);
						 while ($row_placas=mysqli_fetch_array($respuesta_placas))
						       {
						         echo '<td align="center">'.$row_placas["placas_negras"].'</td>';
						       }
						
						}
							
				   
				 }
			  else if ($opcion=='PP')
			          {
					    $consulta="select distinct fecha from ref_web.pulido_placas where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."'";
					    $respuesta=mysqli_query($link, $consulta);
					    while ($row=mysqli_fetch_array($respuesta))
							{
							 echo '<tr>';
							 echo '<td width="120" align="center" class=detalle01><strong>'.$row["fecha"].'</strong><strong></strong></td>';
							 $consulta_placas="select fecha,placas_pernos,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='1' order by fecha,cod_operacion,turno";
							 $respuesta_placas=mysqli_query($link, $consulta_placas);
							 $total_arman=0;
							 $total_cambian=0;	
							 while ($row_placas=mysqli_fetch_array($respuesta_placas))
								   {
									 echo '<td align="center">'.$row_placas["placas_pernos"].'</td>';
									 $total_arman=$total_arman+$row_placas["placas_pernos"];
								   }
							 echo '<td align="center" class="detalle01">'.$total_arman.'</td>';
							 $consulta_placas="select fecha,placas_pernos,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='2' order by fecha,cod_operacion,turno";
							 $respuesta_placas=mysqli_query($link, $consulta_placas);
							 $total_arman=0;	
							 while ($row_placas=mysqli_fetch_array($respuesta_placas))
								   {
									 echo '<td align="center">'.$row_placas["placas_pernos"].'</td>';
									 $total_cambian=$total_cambian+$row_placas["placas_pernos"];
								   }
							 echo '<td align="center" class="detalle01">'.$total_cambian.'</td>';	   
							  $consulta_placas="select fecha,placas_pernos,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='3' order by fecha,cod_operacion,turno";
							 $respuesta_placas=mysqli_query($link, $consulta_placas);
							 while ($row_placas=mysqli_fetch_array($respuesta_placas))
								   {
									 echo '<td align="center">'.$row_placas["placas_pernos"].'</td>';
								   }
							
						}
				} 
    	    }
		 else if ($opcion=='T')
		         { 
				  echo '<tr align="center">';
				  echo '<td>';
				  echo '<table width="756" border="2" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
				  echo '<tr class="ColorTabla01">';
				  echo '<td colspan="9" align="center"><strong>Placas Negras</strong></td>';
				  echo '</tr>';
				  echo '<tr class="ColorTabla01">';
				  echo '<td width="90" rowspan="2" align="center"><strong>&nbsp;</strong><strong></strong><strong>Fecha</strong><strong></strong></td>';
				  echo '<td colspan="3" align="center"><strong>Arman</strong><strong></strong></td>';
				  echo '<td colspan="3" align="center"><strong>Cambian</strong></td>';
				  echo '<td colspan="2" align="center"><strong>Stock</strong></td>';
				  echo '</tr>';
				  echo '<tr class="ColorTabla01">';
				  echo '<td width="44" align="center"><strong>Turno A</strong></td>';
				  echo '<td width="48" align="center"><strong>Turno B</strong></td>';
				  echo '<td width="55" align="center"><strong>Total</strong></td>';
				  echo '<td width="62" align="center"><strong>Turno A</strong></td>';
				  echo '<td width="70" align="center"><strong>Turno B</strong></td>';
				  echo '<td width="70" align="center"><strong>Total</strong></td>';
				  echo '<td width="101" align="center"><strong>Turno A</strong></td>';
				  echo '<td width="107" align="center"><strong>Turno B</strong></td>';
				  echo '</tr>';
				  				   $consulta="select distinct fecha from ref_web.pulido_placas where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."'";
                   $respuesta=mysqli_query($link, $consulta);
				   while ($row=mysqli_fetch_array($respuesta))
				        {
						 echo '<tr>';
						 echo '<td width="120" align="center" class=detalle01><strong>'.$row["fecha"].'</strong><strong></strong></td>';
					     $consulta_placas="select fecha,placas_negras,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='1' order by fecha,cod_operacion,turno";
						 $respuesta_placas=mysqli_query($link, $consulta_placas);
						 $total_arman=0;
						 $total_cambian=0;	
						 while ($row_placas=mysqli_fetch_array($respuesta_placas))
						       {
							     echo '<td align="center">'.$row_placas["placas_negras"].'</td>';
								 $total_arman=$total_arman+$row_placas["placas_negras"];
							   }
						 echo '<td align="center" class="detalle01">'.$total_arman.'</td>';
						 $consulta_placas="select fecha,placas_negras,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='2' order by fecha,cod_operacion,turno";
						 $respuesta_placas=mysqli_query($link, $consulta_placas);
						 $total_arman=0;	
						 while ($row_placas=mysqli_fetch_array($respuesta_placas))
						       {
						         echo '<td align="center">'.$row_placas["placas_negras"].'</td>';
								 $total_cambian=$total_cambian+$row_placas["placas_negras"];
						       }
						 echo '<td align="center" class="detalle01">'.$total_cambian.'</td>';	   
						  $consulta_placas="select fecha,placas_negras,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='3' order by fecha,cod_operacion,turno";
						 $respuesta_placas=mysqli_query($link, $consulta_placas);
						 while ($row_placas=mysqli_fetch_array($respuesta_placas))
						       {
						         echo '<td align="center">'.$row_placas["placas_negras"].'</td>';
						       }
						
						}

                  echo '</table>';
				  echo '<tr align="center">';
				  echo '<td>&nbsp;</td>';
				  echo '</tr>';
				  echo '<table width="756" border="2" align="center" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
				  echo '<tr class="ColorTabla01">'; 
				  echo '<td colspan="9" align="center"><strong>Placas con Pernos</strong></td>';
				  echo '</tr>';
				  echo '<tr class="ColorTabla01">'; 
				  echo '<td width="90" rowspan="2" align="center"><strong>&nbsp;</strong><strong></strong><strong>Fecha</strong><strong></strong></td>';
				  echo '<td colspan="3" align="center"><strong>Arman</strong><strong></strong></td>';
				  echo '<td colspan="3" align="center"><strong>Cambian</strong></td>';
				  echo '<td colspan="2" align="center"><strong>Stock</strong></td>';
				  echo '</tr>';
				  echo '<tr class="ColorTabla01">'; 
				  echo '<td width="44" align="center"><strong>Turno A</strong></td>';
				  echo '<td width="48" align="center"><strong>Turno B</strong></td>';
				  echo '<td width="55" align="center"><strong>Total</strong></td>';
				  echo '<td width="62" align="center"><strong>Turno A</strong></td>';
				  echo '<td width="70" align="center"><strong>Turno B</strong></td>';
				  echo '<td width="70" align="center"><strong>Total</strong></td>';
				  echo '<td width="101" align="center"><strong>Turno A</strong></td>';
				  echo '<td width="107" align="center"><strong>Turno B</strong></td>';
				  echo '</tr>';
				   $consulta="select distinct fecha from ref_web.pulido_placas where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."'";
					    $respuesta=mysqli_query($link, $consulta);
					    while ($row=mysqli_fetch_array($respuesta))
							{
							 echo '<tr>';
							 echo '<td width="120" align="center" class=detalle01><strong>'.$row["fecha"].'</strong><strong></strong></td>';
							 $consulta_placas="select fecha,placas_pernos,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='1' order by fecha,cod_operacion,turno";
							 $respuesta_placas=mysqli_query($link, $consulta_placas);
							 $total_arman=0;
							 $total_cambian=0;	
							 while ($row_placas=mysqli_fetch_array($respuesta_placas))
								   {
									 echo '<td align="center">'.$row_placas["placas_pernos"].'</td>';
									 $total_arman=$total_arman+$row_placas["placas_pernos"];
								   }
							 echo '<td align="center" class="detalle01">'.$total_arman.'</td>';
							 $consulta_placas="select fecha,placas_pernos,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='2' order by fecha,cod_operacion,turno";
							 $respuesta_placas=mysqli_query($link, $consulta_placas);
							 $total_arman=0;	
							 while ($row_placas=mysqli_fetch_array($respuesta_placas))
								   {
									 echo '<td align="center">'.$row_placas["placas_pernos"].'</td>';
									 $total_cambian=$total_cambian+$row_placas["placas_pernos"];
								   }
							 echo '<td align="center" class="detalle01">'.$total_cambian.'</td>';	   
							  $consulta_placas="select fecha,placas_pernos,cod_operacion from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='3' order by fecha,cod_operacion,turno";
							 $respuesta_placas=mysqli_query($link, $consulta_placas);
							 while ($row_placas=mysqli_fetch_array($respuesta_placas))
								   {
									 echo '<td align="center">'.$row_placas["placas_pernos"].'</td>';
								   }
							}	   
				  echo '</table>';
         }		  
 ?>
      
      <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
</table>
</form>
</html>
