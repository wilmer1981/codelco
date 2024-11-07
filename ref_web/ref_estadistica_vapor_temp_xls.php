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

	$DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	$MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	$AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	$DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	$MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	$AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y"); 

	$cmbcircuito     = isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:""; 
	$buscar     = isset($_REQUEST["buscar"])?$_REQUEST["buscar"]:""; 
	$opcion     = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:""; 
	

	if (strlen($DiaIni)==1)
		$DiaIni = "0".$DiaIni;
	if (strlen($MesIni)==1)
		$MesIni = "0".$MesIni;
	if (strlen($DiaFin)==1)
		$DiaFin = "0".$DiaFin;
	if (strlen($MesFin)==1)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
	$circuitos_temp=array('1','2','3','4','5','6','HM','Parcial' );
	$circuitos_vapor=array('Matriz Entrada','1 al 4','5','6');
?>
<html>
<head>
<title>Informe Estadistica Temperaturas y Vapor</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" > 
      <td colspan="6" class="ColorTabla01"><strong>INFORME ESTADISTICAS DE TEMPERATURA 
        Y VAPOR</strong></td>
    </tr>
    <tr> 
      <td width="90">Fecha Inicio:<?php echo $DiaIni.'-'.$MesIni.'-'.$AnoIni; ?>&nbsp;&nbsp;&nbsp;Fecha Termino:<?php echo $DiaFin.'-'.$MesFin.'-'.$AnoFin;?></td>
    </tr>
    <tr> 
      <td height="12">Circuito:<?php 
	      						if ($opcion=='T')
								   { echo $circuitos_temp[$cmbcircuito - 1];}
								else {echo $circuitos_vapor[$cmbcircuito - 1];}   
	                           ?>&nbsp;&nbsp;&nbsp;Tipo:<?php echo $opcion; ?> </td>
    </tr>
  </table>
  </td></p>
      <td colspan="2"></td></tr>
  </table>
<table width="955" align="center">
 <?php 
    if ($buscar=='S')
        {	   
          if ($opcion=='T')
		     {
			   if ($cmbcircuito==1)
			      {
				   $parametros='FECHA,sum(TEMP1) as valor1,sum(TEMP2) as valor2';
				  }
				else if ($cmbcircuito==2)
			            {
				         $parametros='FECHA,sum(TEMP3) as valor1,sum(TEMP4) as valor2';
				        } 
					 else if ($cmbcircuito==3)
			                 {
				              $parametros='FECHA,sum(TEMP5) as valor1,sum(TEMP6) as valor2';
				             }
				     	  else if ($cmbcircuito==4)
			                     {
				                  $parametros='FECHA,sum(TEMP7) as valor1,sum(TEMP8) as valor2';
				                 }
							   else if ($cmbcircuito==5)
			                     {
				                  $parametros='FECHA,sum(TEMP9) as valor1,sum(TEMP10) as valor2';
				                 }
							   		else if ($cmbcircuito==6)
			                     			{
				                  			 $parametros='FECHA,sum(TEMP11) as valor1,sum(TEMP12) as valor2';
				                 			}
										 else if ($cmbcircuito==7)
			                                     {
				                                  $parametros='FECHA,sum(TEMP17) as valor1,sum(TEMP18) as valor2';
				                                 }  	  	 	
							   	   	  	 	  else if ($cmbcircuito==8)
			                                          {
				                                       $parametros='FECHA,sum(TEMP15) as valor1,sum(TEMP16) as valor2';
				                                      }  	  	  	  	 	   	  	 
			    $consulta_aux="select ".$parametros." from ref_web.temperaturas where ";
			   $consulta_fecha="select distinct FECHA from ref_web.temperaturas where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."' order by FECHA";
			 }
		 else if ($opcion=='V')
		         {
				   if ($cmbcircuito==1)
			          {
				       $parametros='FECHA,sum(TEMP1) as valor1,sum(PRE1) as valor2';
				      }
				   else if ($cmbcircuito==2)
			               { 
				            $parametros='FECHA,sum(TEMP2) as valor1,sum(PRE2) as valor2';
				           } 
					    else if ($cmbcircuito==3)
			                    {
				                 $parametros='FECHA,sum(TEMP3) as valor1,sum(PRE3) as valor2';
				                }
				     	     else if ($cmbcircuito==4)
			                         {
				                      $parametros='FECHA,sum(TEMP4) as valor1,sum(PRE4) as valor2';
				                    }
								 else if ($cmbcircuito==5)
										 {
										  $parametros='FECHA,sum(TEMP5) as valor1,sum(PRE5) as valor2';
										}

			   $consulta_fecha="select distinct FECHA from ref_web.vapor where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."' order by FECHA";			   
			   $consulta_aux="select ".$parametros." from ref_web.vapor where ";
			  } 
		      echo '<tr align="center">';
			  echo '<td>';
			  echo '<table width="756" border="2" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
              echo '<tr class="ColorTabla01">';
			  if ($opcion=='T')
			     {echo '<td colspan="7" align="center"><strong>Circuito&nbsp;'.$circuitos_temp[$cmbcircuito-1].'</strong></td>';}
			  else {echo '<td colspan="7" align="center"><strong>Circuito&nbsp;'.$circuitos_vapor[$cmbcircuito-1].'</strong></td>';}	 
              echo '</tr>';
              echo '<tr class="ColorTabla01">';
              echo '<td width="119" rowspan="2" align="center"><strong>&nbsp;</strong><strong></strong><strong>Fecha</strong><strong></strong></td>';
              echo '<td colspan="2" align="center"><strong>Turno C</strong><strong></strong></td>';
              echo '<td colspan="2" align="center"><strong>Turno A</strong></td>';
              echo '<td colspan="2" align="center"><strong>Turno B</strong></td>';
              echo '</tr>';
              echo '<tr class="ColorTabla01">';
			  if ($opcion=='T')
			     {
				  echo '<td width="86" align="center"><strong>Temperatura Entrada(&deg;C)</strong></td>';
				  echo '<td width="80" align="center"><strong>Termperatura Salida(&deg;C)</strong></td>';
				  echo '<td width="113" align="center"><strong>Temperatura Entrada(&deg;C)</strong></td>';
				  echo '<td width="99" align="center"><strong>Termperatura Salida(&deg;C)</strong></td>';
				  echo '<td width="99" align="center"><strong>Temperatura Entrada(&deg;C)</strong></td>';
				  echo '<td width="99" align="center"><strong>Termperatura Salida(&deg;C)</strong></td>';
				 } 
				else { echo '<td width="113" align="center"><strong>Temperatura(&deg;C)</strong></td>';
					   echo '<td width="99" align="center"><strong>Presion(Bar)</strong></td>';
					   echo '<td width="113" align="center"><strong>Temperatura(&deg;C)</td>';
					   echo '<td width="99" align="center"><strong>Presion(Bar)</strong></td>';
					   echo '<td width="113" align="center"><strong>Temperatura(&deg;C)</strong></td>';
					   echo '<td width="99" align="center"><strong>Presion(Bar)</strong></td>';} 
              echo '</tr>';
        
			  //echo $consulta_fecha;
			  $respuesta_fecha=mysqli_query($link, $consulta_fecha);
			  while ($row_fecha = mysqli_fetch_array($respuesta_fecha))
			       {
				     $consulta=$consulta_aux." FECHA='".$row_fecha["FECHA"]."' and TURNO='C' group by FECHA,turno order by FECHA,TURNO,INSTANTE ";
					 //echo $consulta."<br>";
				     $respuesta=mysqli_query($link, $consulta);
					 $row = mysqli_fetch_array($respuesta);
					 $total1=$row["valor1"]/3;
					 $total2=$row["valor2"]/3;
					 $consulta=$consulta_aux." FECHA='".$row_fecha["FECHA"]."' and TURNO='A' group by FECHA,turno order by FECHA,TURNO,INSTANTE ";
					 //echo $consulta."<br>";
				     $respuesta=mysqli_query($link, $consulta);
					 $row = mysqli_fetch_array($respuesta);
				     $total3=$row["valor1"]/3;
				     $total4=$row["valor2"]/3;
					 $consulta=$consulta_aux." FECHA='".$row_fecha["FECHA"]."' and TURNO='B' group by FECHA,turno order by FECHA,TURNO,INSTANTE ";
					 //echo $consulta."<br>";
				     $respuesta=mysqli_query($link, $consulta);
					 $row = mysqli_fetch_array($respuesta);
				     $total5=$row["valor1"]/3;
				     $total6=$row["valor2"]/3;
					echo '<tr>';
					echo '<td width="120" align="center" class=detalle01><strong>'.$row_fecha["FECHA"].'</strong><strong></strong></td>';
				    echo '<td align="center">'.number_format($total1,"1",".",".").'</td>';
					echo '<td align="center">'.number_format($total2,"1",".",".").'</td>';
					echo '<td align="center">'.number_format($total3,"1",".",".").'</td>';
					echo '<td align="center">'.number_format($total4,"1",".",".").'</td>';
					echo '<td align="center">'.number_format($total5,"1",".",".").'</td>';
					echo '<td align="center">'.number_format($total6,"1",".",".").'</td>';
				   }
	    }	  
 ?>
      </table>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
      <td align="center">&nbsp; </td>
  </tr>
</table>
</form>
</body>
</html>
