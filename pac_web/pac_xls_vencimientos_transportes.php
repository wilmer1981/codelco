<?php         ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
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
	include("../principal/conectar_pac_web.php");
	include("../principal/conectar_pac_web.php");
?>
<html>
<head>
<title>Planta de &Aacute;cido</title>
</head>
<body>
<form name="FrmConsultaVencimientos" action="" method="post">
  <table border='1'>
    <tr> 
      <td>Patente</td>
	  <td>Tipo</td>
      <td>Marca</td>
      <td>Modelo</td>
	  <td>Fecha Rev.Tecnica</td>
      <td>Fecha Cert. EK</td>
    </tr>
    <?php	
		if ($Mostrar=='S')
		{
			  if (strlen($CmbDias) == 1)
			      $CmbDias = '0'.$CmbDias;
			  if (strlen($CmbMes) == 1)	  
			      $CmbMes = '0'.$CmbMes;
			  
			  $FechaInicio=$CmbAno."-".$CmbMes."-".$CmbDias;
			  switch ($CmbTransporte)
			  {
			  		case "-1":
						$Filtro="where tipo <> 'B' ";					
						break;
			  		case "C":
						$Filtro="where tipo = 'C' ";										
						break;
			  		case "R":
						$Filtro="where tipo = 'R' ";										
						break;
			  }
			  $Consulta="select distinct(nro_patente),marca,modelo,fecha_rev_tecnica,fecha_cert_estanque,tipo,(case when tipo='C' then 'Camion' else 'Rampla' end) as tipotransp from pac_web.camiones_por_transportista ".$Filtro. " order by tipo,nro_patente";
			  $Respuesta=mysqli_query($link, $Consulta);			  
			  while($Fila=mysqli_fetch_array($Respuesta))
			  {
				  if (($Fila[tipo]=='C')&&(date($Fila[fecha_rev_tecnica])<date($FechaInicio)))
				  {
					  echo "<tr>";
					  echo "<td>".$Fila[nro_patente]."</td>";
					  echo "<td>".$Fila[tipotransp]."</td>";
					  echo "<td>".$Fila[marca]."</td>";
					  echo "<td>".$Fila[modelo]."</td>";
					  echo "<td><strong><font color='red'>".$Fila[fecha_rev_tecnica]."</font></strong></td>";
	   				  echo "<td>&nbsp;</td>";
					  echo "</tr>";
				   }  				  
				  if (($Fila[tipo]=='R')&&((date($Fila[fecha_rev_tecnica])<date($FechaInicio))||(date($Fila[fecha_cert_estanque])<date($FechaInicio))))
				  {
					  echo "<tr>";
					  echo "<td>".$Fila[nro_patente]."</td>";
					  echo "<td>".$Fila[tipotransp]."</td>";
					  echo "<td>".$Fila[marca]."</td>";
					  echo "<td>".$Fila[modelo]."</td>";
					  if (date($Fila[fecha_rev_tecnica])<date($FechaInicio))
					  {
					  	echo "<td><strong><font color='red'>".$Fila[fecha_rev_tecnica]."</font></strong></td>";
					  }
					  else
					  {
					  	echo "<td><strong><font color='green'>".$Fila[fecha_rev_tecnica]."</font></strong></td>";
					  }
					  if (date($Fila[fecha_cert_estanque])<date($FechaInicio))
					  {
  					  	echo "<td><strong><font color='red'>".$Fila[fecha_cert_estanque]."</font></strong></td>";
					  }
					  else
					  {
					  	echo "<td><strong><font color='green'>".$Fila[fecha_cert_estanque]."</font></strong></td>";	
					  } 	
					  echo "</tr>";
				   }  				  
			  } 	
		}		
	?>
  </table>		
</form>		
</body>
</html>
