<?php  
	        ob_end_clean();
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
    include("../principal/conectar_ram_web.php"); 
?>
<html>
<head>
<title>Informe Diario</title>
<?php
	//<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
?>
<script language="JavaScript">
function Detalle(dir)
{
	window.open(dir, "","menubar=no resizable=no Top=50 Left=200 width=550 height=300 scrollbars=yes");
}
function Imprimir()
{	
	window.print();
}

/**************/
function Salir()
{
	window.history.back();
}

</script>
</head>

<body class="TablaPrincipal">
<form name="frm1" action="" method="post">
        
		<table width="400" border="0" align="center">
          <tr class="ColorTabla01"> 
		  	<td align="center" colspan="8">INFORME DIARIO RECEPCION Y MEZCLA</td>
		  </tr>
          <tr class="ColorTabla02"> 
		  	<td align="center" colspan="8">FECHA:  <?php echo $dia.'/'.$mes.'/'.$ano ?></td>
		  </tr>
		</table><br>  
<?php
if(strlen($dia) == 1)
	$dia = '0'.$dia;

if(strlen($mes) == 1)
	$mes = '0'.$mes;
	
$fecha_ini = $ano.'-'.$mes.'-'.$dia.' 00:00:00';
$fecha_ter = $ano.'-'.$mes.'-'.$dia.' 23:59:59';

$fecha_i = $ano.'-'.$mes.'-'.$dia.' 08:00:00';
$fecha_t = date("Y-m-d",mktime(7,59,59,$mes,($dia + 1),$ano))." 07:59:59";

$fecha = $ano.'-'.$mes.'-'.$dia;

$arreglo = array();
$arreglo2 = array();
?>

<?php

//*********************************************************** cod_conjunto = 1 - rango 1
$Total_ini = 0;
$Total_recep = 0;
$Total_val = 0;
$Total_trasp = 0;
$Total_benef = 0;
$Total_exist = 0;

   echo '<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">';
	  echo '<tr class="ColorTabla01">'; 
		echo '<td width="32%%" align="center">Conjunto</td>';
		echo '<td width="10%" align="right">Exist. Ini.</td>';
		echo '<td width="10%" align="right">Recep.</td>';
		echo '<td width="6%" align="right">Mezcla</td>';
		echo '<td width="10%" align="right">Traspaso</td>';			
		echo '<td width="10%" align="right">Ben. Dir.</td>';			
		echo '<td width="9%" align="right">Valid.</td>';			
		echo '<td width="10%" align="right">Exist. Final</td></tr>';			


	  $Consulta = "SELECT distinct num_conjunto,conjunto_destino FROM ram_web.movimiento_proveedor WHERE cod_conjunto = 1 AND peso_humedo > 0 
	  AND (cod_existencia = 02 OR cod_existencia = 13) AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'  AND  num_conjunto BETWEEN '1000' AND '8999' ORDER BY num_conjunto,fecha_movimiento ASC";
	  $rs = mysqli_query($link, $Consulta);

	  $Crear_Tabla = "CREATE TEMPORARY TABLE `tmp_table` (`num_conjunto` INT (10) UNSIGNED DEFAULT '0', `conjunto_destino` INT (10) UNSIGNED DEFAULT '0')";
	  mysqli_query($link, $Crear_Tabla);

	  while ($row = mysqli_fetch_array($rs))
	  {		 		
			$Insertar = "INSERT INTO tmp_table (num_conjunto, conjunto_destino)";
			$Insertar = "$Insertar VALUES ($row[num_conjunto],$row[conjunto_destino])";
			mysqli_query($link, $Insertar);
	  }
	  
	  $Consulta = "SELECT distinct num_conjunto, conjunto_destino FROM ram_web.movimiento_conjunto WHERE cod_conjunto = 1 AND peso_humedo_movido > 0
	  AND num_conjunto BETWEEN '1000' AND '8999' AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' order by num_conjunto,fecha_movimiento ASC";
	  $rs = mysqli_query($link, $Consulta);
	  
	  while ($row = mysqli_fetch_array($rs))
	  {		 		
			$Consulta = "SELECT * FROM tmp_table WHERE num_conjunto != $row[num_conjunto] AND conjunto_destino != $row[conjunto_destino]";
			$rs1 = mysqli_query($link, $Consulta);
			
			if($row2 = mysqli_fetch_array($rs1))
			{		
				$Insertar = "INSERT INTO tmp_table (num_conjunto, conjunto_destino)";
				$Insertar = "$Insertar VALUES ($row[num_conjunto],$row[conjunto_destino])";
				mysqli_query($link, $Insertar);
			}
	  }


	  $Consulta = "SELECT distinct num_conjunto, conjunto_destino FROM tmp_table ORDER by num_conjunto,conjunto_destino DESC";
	  $rs = mysqli_query($link, $Consulta);	  

	  $fecha_ini = $ano.'-'.$mes.'-'.$dia.' 00:00:00';		
	  while ($row = mysqli_fetch_array($rs))	  
      {

		$Encontrado = "";			

		if($row[num_conjunto] == $row[conjunto_destino])
		{
			$Consulta = "SELECT * FROM ram_web.movimiento_proveedor WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino <> $row[num_conjunto]
			AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs0 = mysqli_query($link, $Consulta);
			if($row0 = mysqli_fetch_array($rs0))
			{
				$Encontrado = "S";
			}
			else 
			{
				$Encontrado = "N";
			}
		}
		else	
		{
				$Encontrado = "N";
		}

		if($Encontrado == "N")
		{
				//Descripcion
				$Consulta = "SELECT * FROM ram_web.conjunto_ram where cod_conjunto = 1 AND num_conjunto = $row[num_conjunto]"; 
				$rs1 = mysqli_query($link, $Consulta);
		
				if($row1 = mysqli_fetch_array($rs1))
				{
					echo '<tr>';
					echo '<td>'.$row1[cod_conjunto].'-'.$row[num_conjunto].' '.$row1["descripcion"].'</td>';
					
					//Existencia Ini
					$Consulta ="SELECT sum(peso_humedo) AS peso_ini from ram_web.movimiento_proveedor where num_conjunto = $row[num_conjunto] AND (conjunto_destino = $row[num_conjunto] OR conjunto_destino = $row[conjunto_destino])
					 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 13";
					$rs2 = mysqli_query($link, $Consulta);
					
					if($row2 = mysqli_fetch_array($rs2))
					{
							$Consulta = "SELECT MAX(conjunto_destino) as conj_destino FROM ram_web.movimiento_proveedor WHERE  num_conjunto = $row[num_conjunto] AND conjunto_destino != $row[num_conjunto] 
							AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
							$rs_c = mysqli_query($link, $Consulta);
							
							if($row_c = mysqli_fetch_array($rs_c))
							{
								$conj_destino = $row_c[conj_destino];	
							}
							
							if($conj_destino == $row[conjunto_destino])
							{
								$peso_ini = $row2[peso_ini];
								$Total_ini = $Total_ini + $peso_ini;		
								echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
							}
							elseif($conj_destino != $row[conjunto_destino] AND $row[num_conjunto] != $row[conjunto_destino])
							{
								echo '<td align="right">0,000</td>';
							}
							if($row[num_conjunto] == $row[conjunto_destino])
							{
								$peso_ini = $row2[peso_ini];
								$Total_ini = $Total_ini + $peso_ini;		
								echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
							}
					}
					
					//Recepcion
					$Consulta ="SELECT sum(peso_humedo) AS peso_recep from ram_web.movimiento_proveedor where num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[num_conjunto]
					 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 2";
					$rs3 = mysqli_query($link, $Consulta);
					if($row3 = mysqli_fetch_array($rs3))
					{		
						$Consulta = "SELECT MAX(conjunto_destino) as conj_destino FROM ram_web.movimiento_proveedor WHERE  num_conjunto = $row[num_conjunto] AND conjunto_destino != $row[num_conjunto] 
						AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
						$rs_c = mysqli_query($link, $Consulta);
						
						if($row_c = mysqli_fetch_array($rs_c))
						{
							$conj_destino = $row_c[conj_destino];	
						}
						
						if($conj_destino == $row[conjunto_destino])
						{
							$peso_recep = $row3[peso_recep];
							$Total_recep = $Total_recep + $peso_recep;		                         
							
							if($peso_recep != 0)
								echo '<td align="right">'.number_format($peso_recep/1000,3,",","").'</td>';
							else
							  echo '<td align="right">0,000</td>';
						}
						elseif($conj_destino != $row[conjunto_destino] AND $row[num_conjunto] != $row[conjunto_destino])
						{
							echo '<td align="right">0,000</td>';							
						}
						if($row[num_conjunto] == $row[conjunto_destino])
						{
							$peso_recep = $row3[peso_recep];
							$Total_recep = $Total_recep + $peso_recep;		                         

							if($peso_recep != 0)
								echo '<td align="right">'.number_format($peso_recep/1000,3,",","").'</td>';
							else
							  echo '<td align="right">0,000</td>';
						}
												
					}
					
					//Mezcla
					$Consulta ="SELECT conjunto_destino FROM ram_web.movimiento_proveedor WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 12";
					$rs4 = mysqli_query($link, $Consulta);
					if($row4 = mysqli_fetch_array($rs4))
					{
						$conjunto_destino = $row4[conjunto_destino];		
						echo '<td align="right">'.$conjunto_destino.'</td>';
					}
					else
					{
						$conjunto_destino = $row[conjunto_destino];		
						echo '<td align="right">'.$conjunto_destino.'</td>';				
					}
			   
					//Traspaso 
					$Consulta ="SELECT sum(peso_humedo_movido) AS peso_trasp FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' AND (cod_existencia = 6 OR cod_existencia = 15 OR cod_existencia = 16)";
					$rs5 = mysqli_query($link, $Consulta);
					if($row5 = mysqli_fetch_array($rs5))
					{
						$peso_trasp = $row5[peso_trasp];	
						$Total_trasp = $Total_trasp + $peso_trasp;		
						
						if($peso_trasp != 0)				
								echo '<td align="right">'.number_format($peso_trasp/1000,3,",","").'</td>';
						else
							echo '<td align="right">0,000</td>';
					}
		
					//Benef. Dir.
					$Consulta ="SELECT sum(peso_humedo_movido) AS peso_benef FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' AND cod_existencia = 5";
					$rs6 = mysqli_query($link, $Consulta);
					if($row6 = mysqli_fetch_array($rs6))
					{
						$peso_benef = $row6[peso_benef];	
						$Total_benef = $Total_benef + $peso_benef;		
						if($peso_benef != 0)				
								echo '<td align="right">'.number_format($peso_benef/1000,3,",","").'</td>';
						else
							echo '<td align="right">0,000</td>';
					}
		
					//Validaci�n 
					$Consulta ="SELECT sum(estado_validacion) AS peso_val FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' AND (cod_existencia = 6 OR cod_existencia = 16 OR cod_existencia = 5)";
					$rs6 = mysqli_query($link, $Consulta);

					if($row6 = mysqli_fetch_array($rs6))
					{										
							$peso_val = $row6[peso_val];
							$Total_val = $Total_val + $peso_val;		                         
							
							if($peso_val != 0)
								echo '<td align="right">'.number_format($peso_val/1000,3,",","").'</td>';
							else
							  echo '<td align="right">0,000</td>';
					}
					
							
					//Existencia Final
					$Consulta ="SELECT sum(peso_humedo) AS peso_final FROM ram_web.movimiento_proveedor WHERE num_conjunto = $row[num_conjunto] AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 1";
					$rs6 = mysqli_query($link, $Consulta);
					if($row6 = mysqli_fetch_array($rs6))
					{
						$Consulta = "SELECT MAX(conjunto_destino) as conj_destino FROM ram_web.movimiento_proveedor WHERE  num_conjunto = $row[num_conjunto] AND conjunto_destino != $row[num_conjunto] 
						AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
						$rs_c = mysqli_query($link, $Consulta);
						
						if($row_c = mysqli_fetch_array($rs_c))
						{
							$conj_destino = $row_c[conj_destino];	
						}
						
						if($conj_destino == $row[conjunto_destino])
						{
							$peso_final = $row6[peso_final];
							$Total_exist = $Total_exist + $peso_final;
							echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
						}
						elseif($conj_destino != $row[conjunto_destino] AND $row[num_conjunto] != $row[conjunto_destino])
						{
							echo '<td align="right">0,000</td>';							
						}
						if($row[num_conjunto] == $row[conjunto_destino])
						{
							$peso_final = $row6[peso_final];
							$Total_exist = $Total_exist + $peso_final;
							echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
						}

					}
	
				echo '</tr>';
				}   			
		
		  } 
	 }	
	  echo '<tr class="ColorTabla02">';
		echo '<td>SubTotales</td>';
		echo '<td align="right">'.number_format($Total_ini/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_recep/1000,3,",","").'</td>';            
		echo '<td align="right">&nbsp;</td>';
		echo '<td align="right">'.number_format($Total_trasp/1000,3,",","").'</td>';            
		echo '<td align="right">'.number_format($Total_benef/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_val/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_exist/1000,3,",","").'</td>';            
	  echo '</tr>';
	echo '</table><br>';

//**************************************************** cod_conjunto = 1  - rango 2
$Total_ini = 0;
$Total_recep = 0;
$Total_val = 0;
$Total_trasp = 0;
$Total_benef = 0;
$Total_exist = 0;
   echo '<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">';
	  echo '<tr class="ColorTabla01">'; 
		echo '<td width="32%%" align="center">Conjunto</td>';
		echo '<td width="10%" align="right">Exist. Ini.</td>';
		echo '<td width="10%" align="right">Recep.</td>';
		echo '<td width="6%" align="right">Mezcla</td>';
		echo '<td width="10%" align="right">Traspaso</td>';			
		echo '<td width="10%" align="right">Ben. Dir.</td>';			
		echo '<td width="9%" align="right">Valid.</td>';			
		echo '<td width="10%" align="right">Exist. Final</td></tr>';			

	  $Consulta = "SELECT distinct num_conjunto, conjunto_destino FROM ram_web.movimiento_proveedor WHERE cod_conjunto = 1 AND (cod_existencia = 02 OR cod_existencia = 13) 
	  AND peso_humedo > 0  AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND num_conjunto BETWEEN '9000' AND '9999' ORDER BY num_conjunto,fecha_movimiento ASC";
	  $rs = mysqli_query($link, $Consulta);

	  $Crear_Tabla = "CREATE TEMPORARY TABLE `tmp_table2` (`num_conjunto` INT (10) UNSIGNED DEFAULT '0', `conjunto_destino` INT (10) UNSIGNED DEFAULT '0')";
	  mysqli_query($link, $Crear_Tabla);

	  while ($row = mysqli_fetch_array($rs))
	  {		 		
			$Insertar = "INSERT INTO tmp_table2 (num_conjunto, conjunto_destino)";
			$Insertar = "$Insertar VALUES ($row[num_conjunto],$row[conjunto_destino])";
			mysqli_query($link, $Insertar);
	  }
	  
	  $Consulta = "SELECT distinct num_conjunto, conjunto_destino FROM ram_web.movimiento_conjunto WHERE cod_conjunto = 1 AND peso_humedo_movido > 0
	  AND num_conjunto BETWEEN '9000' AND '9999' AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' order by num_conjunto,fecha_movimiento ASC";
	  $rs = mysqli_query($link, $Consulta);
	  
	  while ($row = mysqli_fetch_array($rs))
	  {		 		
			$Consulta = "SELECT * FROM tmp_table2 WHERE num_conjunto != $row[num_conjunto] AND conjunto_destino != $row[conjunto_destino]";
			$rs1 = mysqli_query($link, $Consulta);
			
			if($row2 = mysqli_fetch_array($rs1))
			{		
				$Insertar = "INSERT INTO tmp_table2 (num_conjunto, conjunto_destino)";
				$Insertar = "$Insertar VALUES ($row[num_conjunto],$row[conjunto_destino])";
				mysqli_query($link, $Insertar);
			}
	  }


	  $Consulta = "SELECT distinct num_conjunto, conjunto_destino FROM tmp_table2 ORDER by num_conjunto,conjunto_destino DESC";
	  $rs = mysqli_query($link, $Consulta);	  

	  $fecha_ini = $ano.'-'.$mes.'-'.$dia.' 00:00:00';		
	  while ($row = mysqli_fetch_array($rs))	  
      {

		$Encontrado = "";			

		if($row[num_conjunto] == $row[conjunto_destino])
		{
			$Consulta = "SELECT * FROM ram_web.movimiento_proveedor WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino <> $row[num_conjunto]
			AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs0 = mysqli_query($link, $Consulta);
			if($row0 = mysqli_fetch_array($rs0))
			{
				$Encontrado = "S";
			}
			else 
			{
				$Encontrado = "N";
			}
		}
		else	
		{
				$Encontrado = "N";
		}

		if($Encontrado == "N")
		{
				//Descripcion
				$Consulta = "SELECT * FROM ram_web.conjunto_ram where cod_conjunto = 1 AND num_conjunto = $row[num_conjunto]"; 
				$rs1 = mysqli_query($link, $Consulta);
		
				if($row1 = mysqli_fetch_array($rs1))
				{
					echo '<tr>';
					echo '<td>'.$row1[cod_conjunto].'-'.$row[num_conjunto].' '.$row1["descripcion"].'</td>';
					
					//Existencia Ini
					$Consulta ="SELECT sum(peso_humedo) AS peso_ini from ram_web.movimiento_proveedor where num_conjunto = $row[num_conjunto] AND (conjunto_destino = $row[num_conjunto] OR conjunto_destino = $row[conjunto_destino])
					 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 13";
					$rs2 = mysqli_query($link, $Consulta);
					
					if($row2 = mysqli_fetch_array($rs2))
					{
							$Consulta = "SELECT MAX(conjunto_destino) as conj_destino FROM ram_web.movimiento_proveedor WHERE  num_conjunto = $row[num_conjunto] AND conjunto_destino != $row[num_conjunto] 
							AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
							$rs_c = mysqli_query($link, $Consulta);
							
							if($row_c = mysqli_fetch_array($rs_c))
							{
								$conj_destino = $row_c[conj_destino];	
							}
							
							if($conj_destino == $row[conjunto_destino])
							{
								$peso_ini = $row2[peso_ini];
								$Total_ini = $Total_ini + $peso_ini;		
								echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
							}
							elseif($conj_destino != $row[conjunto_destino] AND $row[num_conjunto] != $row[conjunto_destino])
							{
								echo '<td align="right">0,000</td>';
							}
							if($row[num_conjunto] == $row[conjunto_destino])
							{
								$peso_ini = $row2[peso_ini];
								$Total_ini = $Total_ini + $peso_ini;		
								echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
							}
					}
					
					//Recepcion
					$Consulta ="SELECT sum(peso_humedo) AS peso_recep from ram_web.movimiento_proveedor where num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[num_conjunto]
					 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 2";
					$rs3 = mysqli_query($link, $Consulta);
					if($row3 = mysqli_fetch_array($rs3))
					{		
						$Consulta = "SELECT MAX(conjunto_destino) as conj_destino FROM ram_web.movimiento_proveedor WHERE  num_conjunto = $row[num_conjunto] AND conjunto_destino != $row[num_conjunto] 
						AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
						$rs_c = mysqli_query($link, $Consulta);
						
						if($row_c = mysqli_fetch_array($rs_c))
						{
							$conj_destino = $row_c[conj_destino];	
						}
						
						if($conj_destino == $row[conjunto_destino])
						{
							$peso_recep = $row3[peso_recep];
							$Total_recep = $Total_recep + $peso_recep;		                         
							
							if($peso_recep != 0)
								echo '<td align="right">'.number_format($peso_recep/1000,3,",","").'</td>';
							else
							  echo '<td align="right">0,000</td>';
						}
						elseif($conj_destino != $row[conjunto_destino] AND $row[num_conjunto] != $row[conjunto_destino])
						{
							echo '<td align="right">0,000</td>';							
						}
						if($row[num_conjunto] == $row[conjunto_destino])
						{
							$peso_recep = $row3[peso_recep];
							$Total_recep = $Total_recep + $peso_recep;		                         

							if($peso_recep != 0)
								echo '<td align="right">'.number_format($peso_recep/1000,3,",","").'</td>';
							else
							  echo '<td align="right">0,000</td>';
						}
												
					}
					
					//Mezcla
					$Consulta ="SELECT conjunto_destino FROM ram_web.movimiento_proveedor WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 12";
					$rs4 = mysqli_query($link, $Consulta);
					if($row4 = mysqli_fetch_array($rs4))
					{
						$conjunto_destino = $row4[conjunto_destino];		
						echo '<td align="right">'.$conjunto_destino.'</td>';
					}
					else
					{
						$conjunto_destino = $row[conjunto_destino];		
						echo '<td align="right">'.$conjunto_destino.'</td>';				
					}
			   
					//Traspaso 
					$Consulta ="SELECT sum(peso_humedo_movido) AS peso_trasp FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' AND (cod_existencia = 6 OR cod_existencia = 15 OR cod_existencia = 16)";
					$rs5 = mysqli_query($link, $Consulta);
					if($row5 = mysqli_fetch_array($rs5))
					{
						$peso_trasp = $row5[peso_trasp];	
						$Total_trasp = $Total_trasp + $peso_trasp;		
		
						if($peso_trasp != 0)				
								echo '<td align="right">'.number_format($peso_trasp/1000,3,",","").'</td>';
						else
							echo '<td align="right">0,000</td>';
					}
		
					//Benef. Dir.
					$Consulta ="SELECT sum(peso_humedo_movido) AS peso_benef FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' AND cod_existencia = 5";
					$rs6 = mysqli_query($link, $Consulta);
					if($row6 = mysqli_fetch_array($rs6))
					{
						$peso_benef = $row6[peso_benef];	
						$Total_benef = $Total_benef + $peso_benef;		
						if($peso_benef != 0)				
								echo '<td align="right">'.number_format($peso_benef/1000,3,",","").'</td>';
						else
							echo '<td align="right">0,000</td>';
					}
		
					//Validaci�n 
					$Consulta ="SELECT sum(estado_validacion) AS peso_val FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' AND (cod_existencia = 6 OR cod_existencia = 16 OR cod_existencia = 5)";
					$rs6 = mysqli_query($link, $Consulta);

					if($row6 = mysqli_fetch_array($rs6))
					{										
							$peso_val = $row6[peso_val];
							$Total_val = $Total_val + $peso_val;		                         
							
							if($peso_val != 0)
								echo '<td align="right">'.number_format($peso_val/1000,3,",","").'</td>';
							else
							  echo '<td align="right">0,000</td>';
					}
					
							
					//Existencia Final
					$Consulta ="SELECT sum(peso_humedo) AS peso_final FROM ram_web.movimiento_proveedor WHERE num_conjunto = $row[num_conjunto] AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 1";
					$rs6 = mysqli_query($link, $Consulta);
					if($row6 = mysqli_fetch_array($rs6))
					{
						$Consulta = "SELECT MAX(conjunto_destino) as conj_destino FROM ram_web.movimiento_proveedor WHERE  num_conjunto = $row[num_conjunto] AND conjunto_destino != $row[num_conjunto] 
						AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
						$rs_c = mysqli_query($link, $Consulta);
						
						if($row_c = mysqli_fetch_array($rs_c))
						{
							$conj_destino = $row_c[conj_destino];	
						}
						
						if($conj_destino == $row[conjunto_destino])
						{
							$peso_final = $row6[peso_final];
							$Total_exist = $Total_exist + $peso_final;
							echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
						}
						elseif($conj_destino != $row[conjunto_destino] AND $row[num_conjunto] != $row[conjunto_destino])
						{
							echo '<td align="right">0,000</td>';							
						}
						if($row[num_conjunto] == $row[conjunto_destino])
						{
							$peso_final = $row6[peso_final];
							$Total_exist = $Total_exist + $peso_final;
							echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
						}

					}
	
				echo '</tr>';
				}   			
		
		  } 
	 }	
	  echo '<tr class="ColorTabla02">';
		echo '<td>SubTotales</td>';
		echo '<td align="right">'.number_format($Total_ini/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_recep/1000,3,",","").'</td>';            
		echo '<td align="right">&nbsp;</td>';
		echo '<td align="right">'.number_format($Total_trasp/1000,3,",","").'</td>';            
		echo '<td align="right">'.number_format($Total_benef/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_val/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_exist/1000,3,",","").'</td>';            
	  echo '</tr>';
	echo '</table><br>';


//*********************************************************** cod_conjunto = 3

$Total_ini = 0;
$Total_recep = 0;
$Total_val = 0;
$Total_trasp = 0;
$Total_benef = 0;
$Total_exist = 0;

   echo '<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">';
	  echo '<tr class="ColorTabla01">'; 
		echo '<td width="32%%" align="center">Conjunto</td>';
		echo '<td width="10%" align="right">Exist. Ini.</td>';
		echo '<td width="10%" align="right">Recep.</td>';
		echo '<td width="6%" align="right">Mezcla</td>';
		echo '<td width="10%" align="right">Traspaso</td>';			
		echo '<td width="10%" align="right">Ben. Dir.</td>';			
		echo '<td width="9%" align="right">Valid.</td>';			
		echo '<td width="10%" align="right">Exist. Final</td></tr>';			

	  $Consulta = "SELECT distinct num_conjunto, conjunto_destino FROM ram_web.movimiento_proveedor WHERE cod_conjunto = 3 AND peso_humedo > 0
	  AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' order by num_conjunto,fecha_movimiento ASC";
	  $rs = mysqli_query($link, $Consulta);

	  //Crea Tabla	
	  $Crear_Tabla = "CREATE TEMPORARY TABLE `tmp_table3` (`num_conjunto` INT (10) UNSIGNED DEFAULT '0', `conjunto_destino` INT (10) UNSIGNED DEFAULT '0')";
	  mysqli_query($link, $Crear_Tabla);

	  while ($row = mysqli_fetch_array($rs))
	  {		 		
			$Insertar = "INSERT INTO tmp_table3 (num_conjunto, conjunto_destino)";
			$Insertar = "$Insertar VALUES ($row[num_conjunto],$row[conjunto_destino])";
			mysqli_query($link, $Insertar);
	  }
	  
	  $Consulta = "SELECT distinct num_conjunto, conjunto_destino FROM ram_web.movimiento_conjunto WHERE cod_conjunto = 3 AND peso_humedo_movido > 0
	  AND cod_existencia != 3 AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' order by num_conjunto,fecha_movimiento ASC";
	  $rs = mysqli_query($link, $Consulta);
	  
	  while ($row = mysqli_fetch_array($rs))
	  {		 		
			$Consulta = "SELECT * FROM tmp_table3 WHERE num_conjunto != $row[num_conjunto] AND conjunto_destino != $row[conjunto_destino]";
			$rs1 = mysqli_query($link, $Consulta);
			
			if($row2 = mysqli_fetch_array($rs1))
			{		
				$Insertar = "INSERT INTO tmp_table3 (num_conjunto, conjunto_destino)";
				$Insertar = "$Insertar VALUES ($row[num_conjunto],$row[conjunto_destino])";
				mysqli_query($link, $Insertar);
			}
	  }


	  $Consulta = "SELECT distinct num_conjunto, conjunto_destino FROM tmp_table3 ORDER by num_conjunto,conjunto_destino DESC";
	  $rs = mysqli_query($link, $Consulta);	  
  	  $fecha_ini = $ano.'-'.$mes.'-'.$dia.' 00:00:00';     
	  while ($row = mysqli_fetch_array($rs))	  
      {
		$Encontrado = "";			
		if($row[num_conjunto] == $row[conjunto_destino])
		{
			$Consulta = "SELECT * FROM ram_web.movimiento_proveedor WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino <> $row[num_conjunto]
			AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs0 = mysqli_query($link, $Consulta);
			if($row0 = mysqli_fetch_array($rs0))
			{
				$Encontrado = "S";				
			}
			else 
			{
				$Encontrado = "N";
			}
		}
		else	
		{
				$Encontrado = "N";
		}

		if($Encontrado == "N")
		{
				//Descripcion
				$Consulta = "SELECT * FROM ram_web.conjunto_ram where cod_conjunto = 3 AND num_conjunto = $row[num_conjunto]  AND estado != 'f'"; 
				$rs1 = mysqli_query($link, $Consulta);
				if($row1 = mysqli_fetch_array($rs1))
				{
					echo '<tr>';

					echo '<td>'.$row1[cod_conjunto].'-'.$row[num_conjunto].' '.$row1["descripcion"].'</td>';

					//Existencia Ini
					$Consulta ="SELECT sum(peso_humedo) AS peso_ini from ram_web.movimiento_proveedor where num_conjunto = $row[num_conjunto] AND (conjunto_destino = $row[num_conjunto] OR conjunto_destino = $row[conjunto_destino])
					 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 13";
					$rs2 = mysqli_query($link, $Consulta);
					if($row2 = mysqli_fetch_array($rs2))
					{

						$Consulta = "SELECT MAX(conjunto_destino) as conj_destino FROM ram_web.movimiento_proveedor WHERE  num_conjunto = $row[num_conjunto] AND conjunto_destino != $row[num_conjunto] 
						AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
						$rs_c = mysqli_query($link, $Consulta);
						
						if($row_c = mysqli_fetch_array($rs_c))
						{
							$conj_destino = $row_c[conj_destino];	
						}
						
						if($conj_destino == $row[conjunto_destino])
						{
							$peso_ini = $row2[peso_ini];
							$Total_ini = $Total_ini + $peso_ini;		
							echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
						}
						elseif($conj_destino != $row[conjunto_destino] AND $row[num_conjunto] != $row[conjunto_destino])
						{
							echo '<td align="right">0,000</td>';
						}
						if($row[num_conjunto] == $row[conjunto_destino])
						{
							$peso_ini = $row2[peso_ini];
							$Total_ini = $Total_ini + $peso_ini;		
							echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
						}
					}
					
					//Recepcion
					$Consulta ="SELECT sum(peso_humedo_movido + estado_validacion) AS peso_recep from ram_web.movimiento_conjunto where ((num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[num_conjunto]
					AND cod_existencia = 2 AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."')
					OR (conjunto_destino = $row[num_conjunto] AND cod_existencia = 15 AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."'))";
					
					$rs3 = mysqli_query($link, $Consulta);
					if($row3 = mysqli_fetch_array($rs3))
					{		
						$Consulta = "SELECT MAX(conjunto_destino) as conj_destino FROM ram_web.movimiento_proveedor WHERE  num_conjunto = $row[num_conjunto] AND conjunto_destino != $row[num_conjunto] 
						AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."'";
						$rs_c = mysqli_query($link, $Consulta);
						
						if($row_c = mysqli_fetch_array($rs_c))
						{
							$conj_destino = $row_c[conj_destino];	
						}
						
						if($conj_destino == $row[conjunto_destino])
						{
							$peso_recep = $row3[peso_recep];
							$Total_recep = $Total_recep + $peso_recep;		                         
							
							if($peso_recep != 0)
								echo '<td align="right">'.number_format($peso_recep/1000,3,",","").'</td>';
							else
								echo '<td align="right">0,000</td>';
						}
						elseif($conj_destino != $row[conjunto_destino] AND $row[num_conjunto] != $row[conjunto_destino])
						{
							echo '<td align="right">0,000</td>';							
						}
						if($row[num_conjunto] == $row[conjunto_destino])
						{
							$peso_recep = $row3[peso_recep];
							$Total_recep = $Total_recep + $peso_recep;		                         

							if($peso_recep != 0)
								echo '<td align="right">'.number_format($peso_recep/1000,3,",","").'</td>';
							else
								echo '<td align="right">0,000</td>';
						}

					}
					
					//Mezcla
					$Consulta ="SELECT conjunto_destino FROM ram_web.movimiento_proveedor WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 12";
					$rs4 = mysqli_query($link, $Consulta);
					if($row4 = mysqli_fetch_array($rs4))
					{
						$conjunto_destino = $row4[conjunto_destino];		
						echo '<td align="right">'.$conjunto_destino.'</td>';
					}
					else
					{
						$conjunto_destino = $row[conjunto_destino];		
						echo '<td align="right">'.$conjunto_destino.'</td>';				
					}
			   
					//Traspaso 
					$Consulta ="SELECT sum(peso_humedo_movido) AS peso_trasp FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' AND (cod_existencia = 6 OR cod_existencia = 15)AND (cod_lugar_destino <= 12 OR cod_lugar_destino >= 26)";
					$rs5 = mysqli_query($link, $Consulta);
					if($row5 = mysqli_fetch_array($rs5))
					{
						$peso_trasp = $row5[peso_trasp];	
						$Total_trasp = $Total_trasp + $peso_trasp;		

						if($peso_trasp != 0)				
								echo '<td align="right">'.number_format($peso_trasp/1000,3,",","").'</td>';
						else
							echo '<td align="right">0,000</td>';
					}
		
					//Benef. Dir.	
					$Consulta ="SELECT sum(peso_humedo_movido) AS peso_benef FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino] 
					 AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' AND (cod_existencia = 5 OR cod_existencia = 16 OR cod_existencia = 6)";
					$rs6 = mysqli_query($link, $Consulta);
					if($row6 = mysqli_fetch_array($rs6))
					{
						$peso_benef = $row6[peso_benef];	
						$Total_benef = $Total_benef + $peso_benef;		

						if($peso_benef != 0)				
								echo '<td align="right">'.number_format($peso_benef/1000,3,",","").'</td>';
						else
							echo '<td align="right">0,000</td>';
					}
		
					//Validaci�n 
					$Consulta ="SELECT sum(estado_validacion) AS peso_val FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[conjunto_destino]
					 AND fecha_movimiento BETWEEN '".$fecha_i."' AND '".$fecha_t."' AND (cod_existencia = 6 OR cod_existencia = 15)";
					$rs6 = mysqli_query($link, $Consulta);
					if($row6 = mysqli_fetch_array($rs6))
					{
						$peso_val = $row6[peso_val];
						$Total_val = $Total_val + $peso_val;		

						if($peso_val != 0)
								echo '<td align="right">'.number_format($peso_val/1000,3,",","").'</td>';
						else
							echo '<td align="right">0,000</td>';
					}
		
					//Existencia Final
					$Consulta ="SELECT sum(peso_humedo) AS peso_final FROM ram_web.movimiento_proveedor WHERE num_conjunto = $row[num_conjunto] AND conjunto_destino = $row[num_conjunto] AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_existencia = 1";
					$rs6 = mysqli_query($link, $Consulta);
					if($row6 = mysqli_fetch_array($rs6))
					{

						$Consulta = "SELECT MAX(conjunto_destino) as conj_destino FROM ram_web.movimiento_proveedor WHERE  num_conjunto = $row[num_conjunto] AND conjunto_destino != $row[num_conjunto] 
						AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
						$rs_c = mysqli_query($link, $Consulta);
						
						if($row_c = mysqli_fetch_array($rs_c))
						{
							$conj_destino = $row_c[conj_destino];	
						}
						
						if($conj_destino == $row[conjunto_destino])
						{
							$peso_final = $row6[peso_final];
							$Total_exist = $Total_exist + $peso_final;
							echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
						}
						elseif($conj_destino != $row[conjunto_destino] AND $row[num_conjunto] != $row[conjunto_destino])
						{
							echo '<td align="right">0,000</td>';							
						}
						if($row[num_conjunto] == $row[conjunto_destino])
						{
							$peso_final = $row6[peso_final];
							$Total_exist = $Total_exist + $peso_final;
							echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
						}
					}
				echo '</tr>';
				}   
		    }

	 } 
	  echo '<tr class="ColorTabla02">';
		echo '<td>SubTotales</td>';
		echo '<td align="right">'.number_format($Total_ini/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_recep/1000,3,",","").'</td>';            
		echo '<td align="right">&nbsp;</td>';
		echo '<td align="right">'.number_format($Total_trasp/1000,3,",","").'</td>';            
		echo '<td align="right">'.number_format($Total_benef/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_val/1000,3,",","").'</td>';
		echo '<td align="right">'.number_format($Total_exist/1000,3,",","").'</td>';            
	  echo '</tr>';
	echo '</table><br>';


//**************************************************************** cod_conjunto = 2
if(strlen($dia) == 1)
	$dia = '0'.$dia;

if(strlen($mes) == 1)
	$mes = '0'.$mes;
	
$fecha_ini = $ano.'-'.$mes.'-'.($dia - 1).' 00:00:00';
$fecha_ter = $ano.'-'.$mes.'-'.$dia.' 23:59:59';

$Total_ini = 0;
$Total_recep = 0;
$Total_val = 0;
$Total_trasp = 0;
$Total_benef = 0;
$Total_exist = 0;

   echo '<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">';
	  echo '<tr class="ColorTabla01">'; 
		echo '<td width="32%%" align="center">Conjunto</td>';
		echo '<td width="10%" align="right">Exist. Ini.</td>';
		echo '<td width="10%" align="right">Recep.</td>';
		echo '<td width="6%" align="right">Mezcla</td>';
		echo '<td width="10%" align="right">Traspaso</td>';			
		echo '<td width="10%" align="right">Ben. Dir.</td>';			
		echo '<td width="9%" align="right">Valid.</td>';			
		echo '<td width="10%" align="right">Exist. Final</td></tr>';			

	  $Consulta = "SELECT distinct conjunto_destino FROM ram_web.movimiento_conjunto WHERE cod_conjunto_destino = 2 AND peso_humedo_movido <> 0
				  AND fecha_movimiento <= '".$fecha."' ORDER BY conjunto_destino";
	  $rs = mysqli_query($link, $Consulta);
		  
	  while ($row = mysqli_fetch_array($rs))
	  {
		 	$arreglo4[] = array($row[conjunto_destino]);
	  }
     
	  while (list($clave, $valor) = each($arreglo4))	  
      {
			//Descripcion
			$Consulta = "SELECT * FROM ram_web.conjunto_ram WHERE cod_conjunto = 2 AND num_conjunto = $valor[0]
						 AND estado = 'p'"; 
			$rs1 = mysqli_query($link, $Consulta);
			if($row1 = mysqli_fetch_array($rs1))
			{
				$ano_c = substr($row1[fecha_creacion],0,4);
				$mes_c = substr($row1[fecha_creacion],5,2);
				$dia_c = substr($row1[fecha_creacion],8,2);
				$fecha_creacion = $ano_c.'-'.$mes_c.'-'.$dia_c;

				echo '<tr>';				
				echo '<td>'.$row1[cod_conjunto].'-'.$valor[0].' '.$row1["descripcion"].'</td>';
					
				$fecha_ini = $ano.'-'.$mes.'-'.$dia;						
				$Consulta ="SELECT sum(peso_humedo_movido + estado_validacion) AS peso_ini FROM ram_web.movimiento_conjunto 
				 WHERE conjunto_destino = $valor[0]  AND cod_existencia <> 15 AND cod_lugar_destino >= 14 
				 AND cod_lugar_destino <= 25 AND left(FECHA_MOVIMIENTO,10) < '$fecha_ini'";

				$rs2 = mysqli_query($link, $Consulta);
				if($row2 = mysqli_fetch_array($rs2))
				{
					$peso_ini = $row2[peso_ini];
					$Total_ini = $Total_ini + $peso_ini;		
					echo '<td align="right">'.number_format($peso_ini/1000,3,",","").'</td>';
				}
				
				//Recepcion
					echo '<td align="right">0,000</td>';
				
				//Mezcla 	
					echo '<td align="right">'.$valor[0].'</td>';				
		   
	
				//Traspaso 
				$fecha_ini = $ano.'-'.$mes.'-'.$dia.' 00:00:00';
				$Consulta ="SELECT sum(peso_humedo_movido + estado_validacion) AS peso_trasp FROM ram_web.movimiento_conjunto WHERE conjunto_destino = $valor[0] and fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_t."' AND (cod_existencia = 6 || cod_existencia = 5)";
				$rs5 = mysqli_query($link, $Consulta);
	
				if($row5 = mysqli_fetch_array($rs5))
				{
					$peso_trasp = $row5[peso_trasp];	
					$Total_trasp = $Total_trasp + $peso_trasp;		

					if($peso_trasp != 0)
						echo '<td align="right">'.number_format($peso_trasp/1000,3,",","").'</td>';
					else
						echo '<td align="right">0,000</td>';

				}
	
				//Benef Dir	
					echo '<td align="right">0,000</td>';
	
				//Validaci�n 
					echo '<td align="right">0,0000</td>';
				
				//Exist Final
				$peso_final = $peso_ini + $peso_trasp;
				$Total_exist = $Total_exist + $peso_final;				
					echo '<td align="right">'.number_format($peso_final/1000,3,",","").'</td>';            
	
			echo '</tr>';

		}				   			

    } 
		  echo '<tr class="ColorTabla02">';
            echo '<td>SubTotales</td>';
            echo '<td align="right">'.number_format($Total_ini/1000,3,",","").'</td>';
            echo '<td align="right">'.number_format($Total_recep/1000,3,",","").'</td>';            
            echo '<td align="right">&nbsp;</td>';
            echo '<td align="right">'.number_format($Total_trasp/1000,3,",","").'</td>';            
            echo '<td align="right">'.number_format($Total_benef/1000,3,",","").'</td>';
            echo '<td align="right">'.number_format($Total_val/1000,3,",","").'</td>';
            echo '<td align="right">'.number_format($Total_exist/1000,3,",","").'</td>';            
          echo '</tr>';
        echo '</table><br>';

?>

      <table width="450" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td align="center">
              <input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="Imprimir()">
              <input name="btnsalir" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()">
		  </td>
        </tr>
      </table>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>