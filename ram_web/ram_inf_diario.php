<? 
  	include("../principal/conectar_ram_web.php");
	
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 15;
?>

<html>
<head>
<title>Informe Diario</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">

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
		  	<td align="center">INFORME DIARIO RECEPCION Y MEZCLA</td>
		  </tr>
          <tr class="ColorTabla02"> 
		  	<td align="center">FECHA:  <? echo $dia.'/'.$mes.'/'.$ano ?></td>
		  </tr>
		</table><br>  
<?
if(strlen($dia) == 1)
	$dia = '0'.$dia;

if(strlen($mes) == 1)
	$mes = '0'.$mes;
	
$fecha = $ano.'-'.$mes.'-'.$dia;
?>

<?	
// cod_producto = 1 - rango 1
        echo '<table width="871" border="1" cellspacing="0" cellpadding="3" align="center">';
          echo '<tr class="ColorTabla01">'; 
            echo '<td width="245" align="center">Conjunto</td>';
            echo '<td width="80" align="center">Existencia Ini.</td>';
            echo '<td width="58" align="center">Recepcion</td>';
            echo '<td width="60" align="center">Mezcla</td>';
            echo '<td width="70" align="center">Preparaci&oacute;n</td>';            
            echo '<td width="65" align="center">Traspaso</td>';			
            echo '<td width="62" align="center">Benef. Dir.</td>';			
            echo '<td width="64" align="center">Validación</td>';			
            echo '<td width="93" align="center">Existencia Final</td>';			

		  $Consulta = "SELECT distinct num_conjunto FROM ram_web.movimiento_proveedor WHERE cod_conjunto = 1 AND peso_humedo != 0 AND left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND  num_conjunto BETWEEN '1000' AND '8999' ORDER BY num_conjunto";
		  $rs = mysql_query($Consulta);
		  while($row = mysql_fetch_array($rs))
		  {          
		  	echo '</tr>';

			//Descripcion
			$Consulta = "SELECT * FROM ram_web.conjunto_ram where cod_conjunto = 1 AND num_conjunto = $row[num_conjunto]"; 
			$rs1 = mysql_query($Consulta);
			if($row1 = mysql_fetch_array($rs1))
			{
            	echo '<td>'.$row1[cod_conjunto].'-'.$row[num_conjunto].' '.$row1[descripcion].'</td>';
				
				//Existencia Ini		
				$Consulta ="SELECT sum(peso_humedo) AS peso_ini from ram_web.movimiento_proveedor where num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND cod_existencia = 13";
				$rs2 = mysql_query($Consulta);
				if($row2 = mysql_fetch_array($rs2))
				{
                    $peso_ini = $row2[peso_ini];
					$Total_ini = $Total_ini + $peso_ini;		
					echo '<td align="center">'.number_format($peso_ini,0,"",".") .'</td>';
				}
                
				//Recepcion
				$Consulta ="SELECT sum(peso_humedo) AS peso_recep from ram_web.movimiento_proveedor where num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND cod_existencia = 2";
				$rs3 = mysql_query($Consulta);
				if($row3 = mysql_fetch_array($rs3))
				{		
					$peso_recep = $row3[peso_recep];
					$Total_recep = $Total_recep + $peso_recep;		
					echo '<td align="center">'.number_format($peso_recep,0,"",".") .'</td>';
				}
                
				//Mezcla
				$Consulta ="SELECT conjunto_destino FROM ram_web.movimiento_proveedor WHERE num_conjunto = $row[num_conjunto] AND left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND cod_existencia = 12";
				$rs4 = mysql_query($Consulta);
				if($row4 = mysql_fetch_array($rs4))
				{
                    $conjunto_destino = $row4[conjunto_destino];		
					echo '<td align="center">'.$conjunto_destino.'</td>';
				}
				else
				{
                    $conjunto_destino = $row[num_conjunto];		
            		echo '<td align="center">'.$conjunto_destino.'</td>';				
				}
           
		    	//Preparación
           		echo '<td align="center">0</td>';

                //Traspaso 
				$Consulta ="SELECT sum(peso_humedo_movido) AS peso_trasp FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND conjunto_destino = $conjunto_destino AND cod_existencia = 6";
				$rs5 = mysql_query($Consulta);
				if($row5 = mysql_fetch_array($rs5))
				{
            	    $peso_trasp = $row5[peso_trasp];	
					$Total_trasp = $Total_trasp + $peso_trasp;		
					echo '<td align="center">'.number_format($peso_trasp,0,"",".") .'</td>';
				}

                //Benef. Dir.	
				$Consulta ="SELECT sum(peso_humedo_movido) AS peso_benef FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND conjunto_destino = $conjunto_destino AND cod_existencia = 5";
				$rs6 = mysql_query($Consulta);
				if($row6 = mysql_fetch_array($rs6))
				{
            	    $peso_benef = $row6[peso_benef];	
					$Total_benef = $Total_benef + $peso_benef;		
					echo '<td align="center">'.number_format($peso_benef,0,"",".") .'</td>';
				}

                //Validación 
				$Consulta ="SELECT sum(estado_validacion) AS peso_val FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND conjunto_destino = $conjunto_destino AND cod_existencia = 6";
				$rs6 = mysql_query($Consulta);
				if($row6 = mysql_fetch_array($rs6))
				{
					$peso_val = $row6[peso_val];
					$Total_val = $Total_val + $peso_val;		
					echo '<td align="center">'.number_format($peso_val,0,"",".") .'</td>';
				}

				//Existencia Final
				$Existencia_Final = (($peso_recep - $peso_trasp) + $peso_ini) - $peso_val;
				if($Existencia_Final < 0)
					$Existencia_Final = 0;

				$Total_exist = $Total_exist + $Existencia_Final;
	            echo '<td align="center">'.number_format($Existencia_Final,0,"",".").'</td>';            

			}   			

          echo '</tr>';
         } 
		  echo '<tr class="ColorTabla02">';
            echo '<td>SubTotales</td>';
            echo '<td align="center">'.number_format($Total_ini,0,"",".").'</td>';
            echo '<td align="center">'.number_format($Total_recep,0,"",".").'</td>';            
            echo '<td align="center">&nbsp;</td>';
            echo '<td align="center">0</td>';
            echo '<td align="center">'.number_format($Total_trasp,0,"",".").'</td>';            
            echo '<td align="center">'.number_format($Total_benef,0,"",".").'</td>';
            echo '<td align="center">'.number_format($Total_val,0,"",".").'</td>';
            echo '<td align="center">'.number_format($Total_exist,0,"",".").'</td>';            
          echo '</tr>';
        echo '</table><br>';


// cod_producto = 1  - rango 2
$Total_ini = 0;
$Total_recep = 0;
$Total_val = 0;
$Total_trasp = 0;
$Total_benef = 0;
$Total_exist = 0;
        echo '<table width="871" border="1" cellspacing="0" cellpadding="3" align="center">';
          echo '<tr class="ColorTabla01">'; 
            echo '<td width="245" align="center">Conjunto</td>';
            echo '<td width="80" align="center">Existencia Ini.</td>';
            echo '<td width="58" align="center">Recepcion</td>';
            echo '<td width="60" align="center">Mezcla</td>';
            echo '<td width="70" align="center">Preparaci&oacute;n</td>';            
            echo '<td width="65" align="center">Traspaso</td>';			
            echo '<td width="62" align="center">Benef. Dir.</td>';			
            echo '<td width="64" align="center">Validación</td>';			
            echo '<td width="93" align="center">Existencia Final</td>';			

		  $Consulta = "SELECT distinct num_conjunto FROM ram_web.movimiento_proveedor WHERE cod_conjunto = 1 AND peso_humedo != 0 AND left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND num_conjunto BETWEEN '9000' AND '9999' ORDER BY num_conjunto";
		  $rs = mysql_query($Consulta);
		  while($row = mysql_fetch_array($rs))
		  {          
		  	echo '</tr>';

			//Descripcion
			$Consulta = "SELECT * FROM ram_web.conjunto_ram where cod_conjunto = 1 AND num_conjunto = $row[num_conjunto]"; 
			$rs1 = mysql_query($Consulta);
			if($row1 = mysql_fetch_array($rs1))
			{
				echo '<td>'.$row1[cod_conjunto].'-'.$row[num_conjunto].' '.$row1[descripcion].'</td>';
				
				//Existencia Ini		
				$Consulta ="SELECT sum(peso_humedo) AS peso_ini from ram_web.movimiento_proveedor where num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND cod_existencia = 13";
				$rs2 = mysql_query($Consulta);
				if($row2 = mysql_fetch_array($rs2))
				{
                    $peso_ini = $row2[peso_ini];
					$Total_ini = $Total_ini + $peso_ini;		
					echo '<td align="center">'.number_format($peso_ini,0,"",".") .'</td>';
				}
                
				//Recepcion
				$Consulta ="SELECT sum(peso_humedo) AS peso_recep from ram_web.movimiento_proveedor where num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND cod_existencia = 2";
				$rs3 = mysql_query($Consulta);
				if($row3 = mysql_fetch_array($rs3))
				{		
					$peso_recep = $row3[peso_recep];
					$Total_recep = $Total_recep + $peso_recep;		
					echo '<td align="center">'.number_format($peso_recep,0,"",".") .'</td>';
				}
                
				//Mezcla
				$Consulta ="SELECT conjunto_destino FROM ram_web.movimiento_proveedor WHERE num_conjunto = $row[num_conjunto] AND left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND cod_existencia = 12";
				$rs4 = mysql_query($Consulta);
				if($row4 = mysql_fetch_array($rs4))
				{
                    $conjunto_destino = $row4[conjunto_destino];		
					echo '<td align="center">'.$conjunto_destino.'</td>';
				}
				else
				{
                    $conjunto_destino = $row[num_conjunto];		
            		echo '<td align="center">'.$conjunto_destino.'</td>';				
				}
           
		    	//Preparación
           		echo '<td align="center">0</td>';

                //Traspaso 
				$Consulta ="SELECT sum(peso_humedo_movido) AS peso_trasp FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND conjunto_destino = $conjunto_destino AND cod_existencia = 6";
				$rs5 = mysql_query($Consulta);
				if($row5 = mysql_fetch_array($rs5))
				{
            	    $peso_trasp = $row5[peso_trasp];	
					$Total_trasp = $Total_trasp + $peso_trasp;		
					echo '<td align="center">'.number_format($peso_trasp,0,"",".") .'</td>';
				}

                //Benef. Dir.	
				$Consulta ="SELECT sum(peso_humedo_movido) AS peso_benef FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND conjunto_destino = $conjunto_destino AND cod_existencia = 5";
				$rs6 = mysql_query($Consulta);
				if($row6 = mysql_fetch_array($rs6))
				{
            	    $peso_benef = $row6[peso_benef];	
					$Total_benef = $Total_benef + $peso_benef;		
					echo '<td align="center">'.number_format($peso_benef,0,"",".") .'</td>';
				}

                //Validación 
				$Consulta ="SELECT sum(estado_validacion) AS peso_val FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND conjunto_destino = $conjunto_destino AND cod_existencia = 6";
				$rs6 = mysql_query($Consulta);
				if($row6 = mysql_fetch_array($rs6))
				{
					$peso_val = $row6[peso_val];
					$Total_val = $Total_val + $peso_val;		
					echo '<td align="center">'.number_format($peso_val,0,"",".") .'</td>';
				}

				//Existencia Final
				$Existencia_Final = (($peso_recep - $peso_trasp) + $peso_ini) - $peso_val;
				if($Existencia_Final < 0)
					$Existencia_Final = 0;

				$Total_exist = $Total_exist + $Existencia_Final;
	            echo '<td align="center">'.number_format($Existencia_Final,0,"",".").'</td>';            
			}   			

          echo '</tr>';
         } 
		  echo '<tr class="ColorTabla02">';
            echo '<td>SubTotales</td>';
            echo '<td align="center">'.number_format($Total_ini,0,"",".").'</td>';
            echo '<td align="center">'.number_format($Total_recep,0,"",".").'</td>';            
            echo '<td align="center">&nbsp;</td>';
            echo '<td align="center">0</td>';
            echo '<td align="center">'.number_format($Total_trasp,0,"",".").'</td>';            
            echo '<td align="center">'.number_format($Total_benef,0,"",".").'</td>';
            echo '<td align="center">'.number_format($Total_val,0,"",".").'</td>';
            echo '<td align="center">'.number_format($Total_exist,0,"",".").'</td>';            
          echo '</tr>';
        echo '</table><br>';
?>

<?

// cod_producto = 3
$Total_ini = 0;
$Total_recep = 0;
$Total_val = 0;
$Total_trasp = 0;
$Total_benef = 0;
$Total_exist = 0;
        echo '<table width="871" border="1" cellspacing="0" cellpadding="3" align="center">';
          echo '<tr class="ColorTabla01">'; 
            echo '<td width="245" align="center">Conjunto</td>';
            echo '<td width="80" align="center">Existencia Ini.</td>';
            echo '<td width="58" align="center">Recepcion</td>';
            echo '<td width="60" align="center">Mezcla</td>';
            echo '<td width="70" align="center">Preparaci&oacute;n</td>';            
            echo '<td width="65" align="center">Traspaso</td>';			
            echo '<td width="62" align="center">Benef. Dir.</td>';			
            echo '<td width="64" align="center">Validación</td>';			
            echo '<td width="93" align="center">Existencia Final</td>';			

		  $Consulta = "SELECT distinct num_conjunto FROM ram_web.movimiento_proveedor WHERE cod_conjunto = 3 AND peso_humedo != 0 AND peso_humedo != '' AND left(FECHA_MOVIMIENTO,10) = '".$fecha."' ORDER BY num_conjunto";
		  $rs = mysql_query($Consulta);
		  while($row = mysql_fetch_array($rs))
		  {          
			echo '</tr>';

			//Descripcion
			$Consulta = "SELECT * FROM ram_web.conjunto_ram WHERE cod_conjunto = 3 AND num_conjunto = $row[num_conjunto]"; 
			$rs1 = mysql_query($Consulta);
			if($row1 = mysql_fetch_array($rs1))
			{
				echo '<td>'.$row1[cod_conjunto].'-'.$row[num_conjunto].' '.$row1[descripcion].'</td>';
				
				//Existencia Ini		
				$Consulta ="SELECT sum(peso_humedo) AS peso_ini from ram_web.movimiento_proveedor WHERE cod_conjunto = 3 AND num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND cod_existencia = 13";
				$rs2 = mysql_query($Consulta);
				if($row2 = mysql_fetch_array($rs2))
				{
                    $peso_ini = $row2[peso_ini];
					$Total_ini = $Total_ini + $peso_ini;		
					echo '<td align="center">'.number_format($peso_ini,0,"",".") .'</td>';
				}
                
				//Recepcion
				$Consulta ="SELECT sum(peso_humedo) AS peso_recep from ram_web.movimiento_proveedor WHERE cod_conjunto = 3 AND num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND cod_existencia = 2";
				$rs3 = mysql_query($Consulta);
				if($row3 = mysql_fetch_array($rs3))
				{		
					$peso_recep = $row3[peso_recep];
					$Total_recep = $Total_recep + $peso_recep;		
					echo '<td align="center">'.number_format($peso_recep,0,"",".") .'</td>';
				}
                
				//Mezcla
				$Consulta ="SELECT conjunto_destino FROM ram_web.movimiento_proveedor WHERE cod_conjunto = 3 AND num_conjunto = $row[num_conjunto] AND left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND cod_existencia = 12";
				$rs4 = mysql_query($Consulta);
				if($row4 = mysql_fetch_array($rs4))
				{
                    $conjunto_destino = $row4[conjunto_destino];		
					echo '<td align="center">'.$conjunto_destino.'</td>';
				}
				else
				{
                    $conjunto_destino = $row[num_conjunto];		
            		echo '<td align="center">'.$conjunto_destino.'</td>';				
				}
           
		    	//Preparación
           		echo '<td align="center">0</td>';

                //Traspaso 
				$Consulta ="SELECT sum(peso_humedo_movido) AS peso_trasp FROM ram_web.movimiento_conjunto WHERE cod_conjunto = 3 AND num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND conjunto_destino = $conjunto_destino AND cod_existencia = 6";
				$rs5 = mysql_query($Consulta);
				if($row5 = mysql_fetch_array($rs5))
				{
            	    $peso_trasp = $row5[peso_trasp];	
					$Total_trasp = $Total_trasp + $peso_trasp;		
					echo '<td align="center">'.number_format($peso_trasp,0,"",".") .'</td>';
				}

                //Benef. Dir.	
				$Consulta ="SELECT sum(peso_humedo_movido) AS peso_benef FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND conjunto_destino = $conjunto_destino AND cod_existencia = 5";
				$rs6 = mysql_query($Consulta);
				if($row6 = mysql_fetch_array($rs6))
				{
            	    $peso_benef = $row6[peso_benef];	
					$Total_benef = $Total_benef + $peso_benef;		
					echo '<td align="center">'.number_format($peso_benef,0,"",".") .'</td>';
				}

                //Validación 
				$Consulta ="SELECT sum(estado_validacion) AS peso_val FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND conjunto_destino = $conjunto_destino AND cod_existencia = 6";
				$rs6 = mysql_query($Consulta);
				if($row6 = mysql_fetch_array($rs6))
				{
					$peso_val = $row6[peso_val];
					$Total_val = $Total_val + $peso_val;		
					echo '<td align="center">'.number_format($peso_val,0,"",".") .'</td>';
				}

				//Existencia Final
				$Existencia_Final = (($peso_recep - $peso_trasp) + $peso_ini) - $peso_val;
				if($Existencia_Final < 0)
					$Existencia_Final = 0;

				$Total_exist = $Total_exist + $Existencia_Final;
	            echo '<td align="center">'.number_format($Existencia_Final,0,"",".").'</td>';            

			}   			

          echo '</tr>';
         } 
		  echo '<tr class="ColorTabla02">';
            echo '<td>SubTotales</td>';
            echo '<td align="center">'.number_format($Total_ini,0,"",".").'</td>';
            echo '<td align="center">'.number_format($Total_recep,0,"",".").'</td>';            
            echo '<td align="center">&nbsp;</td>';
            echo '<td align="center">0</td>';
            echo '<td align="center">'.number_format($Total_trasp,0,"",".").'</td>';            
            echo '<td align="center">'.number_format($Total_benef,0,"",".").'</td>';
            echo '<td align="center">'.number_format($Total_val,0,"",".").'</td>';
            echo '<td align="center">'.number_format($Total_exist,0,"",".").'</td>';            
          echo '</tr>';
        echo '</table><br>';
		
?>

<?

// cod_producto = 2  - rango 1
$Total_ini = 0;
$Total_recep = 0;
$Total_val = 0;
$Total_trasp = 0;
$Total_exist = 0;
        echo '<table width="871" border="1" cellspacing="0" cellpadding="3" align="center">';
          echo '<tr class="ColorTabla01">'; 
            echo '<td width="245" align="center">Conjunto</td>';
            echo '<td width="80" align="center">Existencia Ini.</td>';
            echo '<td width="58" align="center">Recepcion</td>';
            echo '<td width="60" align="center">Mezcla</td>';
            echo '<td width="70" align="center">Preparaci&oacute;n</td>';            
            echo '<td width="65" align="center">Traspaso</td>';			
            echo '<td width="62" align="center">Benef. Dir.</td>';			
            echo '<td width="64" align="center">Validación</td>';			
            echo '<td width="93" align="center">Existencia Final</td>';			

		  $Consulta = "SELECT distinct num_conjunto FROM ram_web.movimiento_proveedor WHERE cod_conjunto = 2 AND left(FECHA_MOVIMIENTO,10) = '".$fecha."'";
		  $rs = mysql_query($Consulta);
		  while($row = mysql_fetch_array($rs))
		  {          
		  	echo '</tr>';

			//Descripcion
			$Consulta = "SELECT * FROM ram_web_resp.conjunto_ram where cod_conjunto = 2 AND num_conjunto = $row[num_conjunto]"; 
			$rs1 = mysql_query($Consulta);
			if($row1 = mysql_fetch_array($rs1))
			{
				echo '<td>'.$row1[cod_conjunto].'-'.$row[num_conjunto].' '.$row1[descripcion].'</td>';
				
				//Existencia Ini		
				$Consulta ="SELECT sum(peso_humedo) AS peso_ini from ram_web.movimiento_proveedor where num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND cod_existencia = 13";
				$rs2 = mysql_query($Consulta);
				if($row2 = mysql_fetch_array($rs2))
				{
                    $peso_ini = $row2[peso_ini];
					$Total_ini = $Total_ini + $peso_ini;		
					echo '<td align="center">'.number_format($peso_ini,0,"",".") .'</td>';
				}
                
				//Recepcion
				$Consulta ="SELECT sum(peso_humedo) AS peso_recep from ram_web.movimiento_proveedor where num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND cod_existencia = 2";
				$rs3 = mysql_query($Consulta);
				if($row3 = mysql_fetch_array($rs3))
				{		
					$peso_recep = $row3[peso_recep];
					$Total_recep = $Total_recep + $peso_recep;		
					echo '<td align="center">'.number_format($peso_recep,0,"",".") .'</td>';
				}
                
				//Mezcla
				$Consulta ="SELECT conjunto_destino FROM ram_web.movimiento_proveedor WHERE num_conjunto = $row[num_conjunto] AND left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND cod_existencia = 12";
				$rs4 = mysql_query($Consulta);
				if($row4 = mysql_fetch_array($rs4))
				{
                    $conjunto_destino = $row4[conjunto_destino];		
					echo '<td align="center">'.$conjunto_destino.'</td>';
				}
				else
				{
                    $conjunto_destino = $row[num_conjunto];		
            		echo '<td align="center">'.$conjunto_destino.'</td>';				
				}
           
		    	//Preparación
           		echo '<td align="center">0</td>';

                //Traspaso 
				$Consulta ="SELECT sum(peso_humedo_movido) AS peso_trasp FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND conjunto_destino = $conjunto_destino AND cod_existencia = 6";
				$rs5 = mysql_query($Consulta);
				if($row5 = mysql_fetch_array($rs5))
				{
            	    $peso_trasp = $row5[peso_trasp];	
					$Total_trasp = $Total_trasp + $peso_trasp;		
					echo '<td align="center">'.number_format($peso_trasp,0,"",".") .'</td>';
				}

                //Benef. Dir.	
				$Consulta ="SELECT sum(peso_humedo_movido) AS peso_benef FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND conjunto_destino = $conjunto_destino AND cod_existencia = 5";
				$rs6 = mysql_query($Consulta);
				if($row6 = mysql_fetch_array($rs6))
				{
            	    $peso_benef = $row6[peso_benef];	
					$Total_benef = $Total_benef + $peso_benef;		
					echo '<td align="center">'.number_format($peso_benef,0,"",".") .'</td>';
				}

                //Validación 
				$Consulta ="SELECT sum(estado_validacion) AS peso_val FROM ram_web.movimiento_conjunto WHERE num_conjunto = $row[num_conjunto] and left(FECHA_MOVIMIENTO,10) = '".$fecha."' AND conjunto_destino = $conjunto_destino AND cod_existencia = 6";
				$rs6 = mysql_query($Consulta);
				if($row6 = mysql_fetch_array($rs6))
				{
					$peso_val = $row6[peso_val];
					$Total_val = $Total_val + $peso_val;		
					echo '<td align="center">'.number_format($peso_val,0,"",".") .'</td>';
				}

				//Existencia Final
				$Existencia_Final = (($peso_recep - $peso_trasp) + $peso_ini) - $peso_val;
				if($Existencia_Final < 0)
					$Existencia_Final = 0;

				$Total_exist = $Total_exist + $Existencia_Final;
	            echo '<td align="center">'.number_format($Existencia_Final,0,"",".").'</td>';            

			}   			

          echo '</tr>';
         } 
		  echo '<tr class="ColorTabla02">';
            echo '<td>SubTotales</td>';
            echo '<td align="center">'.number_format($Total_ini,0,"",".").'</td>';
            echo '<td align="center">'.number_format($Total_recep,0,"",".").'</td>';            
            echo '<td align="center">&nbsp;</td>';
            echo '<td align="center">0</td>';
            echo '<td align="center">'.number_format($Total_trasp,0,"",".").'</td>';            
            echo '<td align="center">'.number_format($Total_benef,0,"",".").'</td>';
            echo '<td align="center">'.number_format($Total_val,0,"",".").'</td>';
            echo '<td align="center">'.number_format($Total_exist,0,"",".").'</td>';            
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
<? include("../principal/cerrar_sea_web.php") ?>