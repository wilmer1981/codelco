<?php
	include("../principal/conectar_principal.php");
	set_time_limit(450);
 //$link = mysql_connect('10.56.11.7','adm_bd','672312');
 mysql_select_db("ram_web",$link);

?>
<html>
<head>
<title>Carga Concetrado Diario RAM</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style>

<SCRIPT LANGUAGE="JavaScript">
function cerrar_sin()
{  
 window.open('','_parent','');
 window.close(); 
} 
</script> 

<SCRIPT LANGUAGE="JavaScript">
function cerrar_con()
{  
 window.close(); 
} 
</script> 
<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="ConsComun" value="<?php echo $ConsComun; ?>">
		
<table width="523" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr>
    <td colspan="3"><strong>
	<?php
           $TipoMovimiento =  "in(12)"; // filtrado por Beneficio
	       $Agrup = "P";  //agrupado por proveedor 
	       $FinoLeyes = "L";  //filtrado por leyes
	   	   $Acum = "A";   //periodo diario (D) o Mes (A)
		   $CodConjunto = "in(01)";    // solo por productos  mineros
		  		  		
			//  $Ano = '2016';
			//  $Mes = '01';
			//  $Dia = '01';
			
		 
      /*  echo $TipoMovimiento;
		echo $Acum;
		echo $Agrup;
	    echo $FinoLeyes; */

      //  $cons_fech = "select  year(now()) aa, month(now()) mm, day(now()) dd   from dual  ";
	   /*  $cons_fech = "SELECT year(DATE_ADD(now(),INTERVAL -1 DAY) )AS aa, month(DATE_ADD(now(),INTERVAL -1 DAY) )AS mm, day(DATE_ADD(now(),INTERVAL -1 DAY) )AS dd from dual";
	    $Respuesta = mysqli_query($link, $cons_fech);
		if ($Fila = mysqli_fetch_array($Respuesta))	
		   { 				
	  		 // $Ano = $Fila["aa"];
			 // $Mes = $Fila["mm"];
			//  $Dia = $Fila["dd"];
		   }
		 */
		//Asigna la fecha del proceso en forma automatica, toma el d�a operacional anterior a la fecha actual
	   // $cons_fech = " SELECT DATE_ADD(curdate(),INTERVAL -1 DAY) AS fechaop";
	   // $rsf = mysqli_query($link, $cons_fech);
	   // $row1 = mysqli_fetch_array($rsf);
	   // $fecha_oper = $row1[fechaop];	
		
  
		?></strong></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="117"><strong>AGRUPADO POR: </strong></td>
    <td width="269"><?php

			echo "PROVEEDOR";

    ?></td>
   
  </tr>
  <tr>
    <td><strong>PERIODO</strong></td>
    <td><?php
	if ($Acum == "D")
	{
		echo str_pad($Dia,2,"0",STR_PAD_LEFT)."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".$Ano;
		$FechaIni = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".str_pad($Dia,2,"0",STR_PAD_LEFT);
		$FechaFin = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".str_pad($Dia,2,"0",STR_PAD_LEFT);
	}
	else
	{
		if ($Acum == "A")
		{
		    $ult_dia = date("d",(mktime(0,0,0,$Mes+1,1,$Ano)-1));
			echo "01-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".$Ano." AL ".str_pad($ult_dia ,2,"0",STR_PAD_LEFT)."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".$Ano;			
			$FechaIni = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
			$FechaFin = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".str_pad($ult_dia,2,"0",STR_PAD_LEFT);
		}
		else
		{
			echo "&nbsp;";
		}	
	}
    ?></td>
  
  </tr>

</table>
<br>
<br>
<?php
echo "<table width='700' border='1' align='center' cellpadding='0' cellspacing='0' class='TablaDetalle02'>\n";
echo "<tr align='center' class='ColorTabla02'>\n";
echo "<td width='50'> </td>";   
echo "<td width='50'> </td>";  
echo "<td width='50'> </td>";  
echo "<td width='50'>Fecha </td>";  
echo "<td width='50'>P.Hum<br>(Ton)</td>";    
echo "</tr>\n";

// borrar en tabla los datos del mes a insertar
			
	$borrar = " DELETE FROM ram_web.flujos_concentrado ";
	//$borrar.= " WHERE fecha BETWEEN '2016-11-01' and '2016-11-30' ";
	$borrar.=  " WHERE fecha BETWEEN '".$FechaIni."' and '".$FechaFin."'";
	mysqli_query($link, $borrar);
	//echo $borrar."<br>";
	
$Consulta = "select * from proyecto_modernizacion.sub_clase ";
$Consulta.= " where cod_clase = '7002'";
$Consulta.= " and valor_subclase1 = '".$TipoMovimiento."'";
$Consulta.= " order by cod_subclase";
$Resp1 = mysqli_query($link, $Consulta);
while ($Fila1 = mysqli_fetch_array($Resp1))  //beneficio
{		
   $fecha_aux = $FechaIni; 
   while (date($fecha_aux) <= date($FechaFin)) //Recorre los dias.
   {
	
	  $FechaFinAux = date("Y-m-d", mktime(1,0,0,substr($fecha_aux,5,2),substr($fecha_aux,8,2)+1,substr($fecha_aux,0,4)));
	
		 //SUBTOTALES
	        $SubTotalHum = 0;
	        $SubTotalSeco = 0;
			$SubTotalAs = 0;
	        $SubTotalS = 0;
			
			$peso_humedo = 0;
	        $porc_hum = 0 ;
	        $ley_as = 0;
	        $ley_s =0;
	
	  //AGRUPADO POR PROVEEDOR y BENEFICIO

			$Consulta = " SELECT t1.cod_conjunto, ";
			$Consulta.= " Sum(t1.peso_humedo) AS peso_humedo,Sum(t1.peso_seco) AS peso_seco, Sum(t1.fino_as) AS fino_as, Sum(t1.fino_s) AS fino_s";
			$Consulta.= " FROM ram_web.movimiento_proveedor t1 INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto)";
			$Consulta.= " AND (t1.cod_conjunto = t2.cod_conjunto) INNER JOIN ram_web.movimiento_conjunto t3 ON (t1.num_conjunto = t3.num_conjunto) ";
			$Consulta.= " AND (t1.conjunto_destino = t3.conjunto_destino) AND (t1.fecha_movimiento = t3.fecha_movimiento)";
			$Consulta.= " AND case when t1.cod_conjunto='03' then (t3.cod_lugar_destino <= 12 OR t3.cod_lugar_destino >= 26) AND (t3.cod_existencia = 6 OR t3.cod_existencia = 15) ";
			$Consulta.= " else (t3.cod_lugar_destino > 12 OR t3.cod_lugar_destino < 26) AND (t3.cod_existencia = 6 OR t3.cod_existencia = 15) end ";					
			$Consulta.= " LEFT JOIN ram_web.proveedor t4 ON trim(t1.rut_proveedor)=trim(t4.rut_proveedor)";
			$Consulta.= " INNER JOIN proyecto_modernizacion.subproducto t5 ON t2.cod_producto = t5.cod_producto AND t2.cod_subproducto = t5.cod_subproducto ";
			$Consulta.= " WHERE t1.cod_conjunto ".$CodConjunto;	
			$Consulta.= " and t2.estado='a' ";				
			$Consulta.= " and t1.peso_humedo > 0";
			$Consulta.= " and (t1.cod_existencia in(05,12,15,16))";	
			$Consulta.= " and t1.num_conjunto <= 9000 ";
			$Consulta.= " and t1.fecha_movimiento BETWEEN '".$fecha_aux." 08:00:00' and '".$FechaFinAux." 07:59:59'";						
			$Consulta.= " GROUP BY t1.cod_conjunto";

	    // echo $Consulta."<br>";	
		
	  $Respuesta = mysqli_query($link, $Consulta);
					
 	  if ($Fila = mysqli_fetch_array($Respuesta))
	  { 
				$PesoHumedo = $Fila["peso_humedo"]; 
				$PesoSeco = $Fila["peso_seco"] ;
				if ($Fila["peso_humedo"]>0 && $Fila["peso_seco"]>0)
					$PorcHum = abs(100-(($Fila["peso_seco"]/$Fila["peso_humedo"])*100));
				else
					$PorcHum = 0;		
				if ($Fila["fino_as"]>0 && $Fila["peso_seco"]>0)
					$As = ($Fila["fino_as"]/$Fila["peso_seco"])*100;
				else
					$As = 0;
				if ($Fila["fino_s"]>0 && $Fila["peso_seco"]>0)
					$S = ($Fila["fino_s"]/$Fila["peso_seco"])*100;
				else
					$S = 0;		

				
				$CantDecHum = 2;
				$CantDecAs = 3;
				$CantDecS = 2;
	
				//SUBTOTALES
		    $SubTotalHum = $SubTotalHum + $Fila["peso_humedo"];
		    $SubTotalSeco = $SubTotalSeco + $Fila["peso_seco"];
			$SubTotalAs = $SubTotalAs + $Fila["fino_as"];
		    $SubTotalS = $SubTotalS + $Fila["fino_s"];
	 
				//ESCRIBE SUBTOTALES
					/*echo "<tr align='right' bgcolor='#FFFFFF'>\n";
					echo "<td colspan='3'>TOTAL PROD. MINEROS a insertar ";
				
					echo "</td>";
					echo "<td>".$fecha_aux."</td>\n";
					echo "<td>".number_format($SubTotalHum/1000,0,",",".")."</td>\n";
					echo "<td>\n";	*/
					
					  //$peso_humedo = number_format($SubTotalHum/1000,0,".","");
					  $peso_humedo = $SubTotalHum;
					  
						if ($SubTotalHum>0 && $SubTotalSeco>0)
						{
							//echo number_format(abs(100-(($SubTotalSeco/$SubTotalHum)*100)),2,",",".");
							//$porc_hum = number_format(abs(100-(($SubTotalSeco/$SubTotalHum)*100)),2);
							$porc_hum = abs(100-(($SubTotalSeco/$SubTotalHum)*100));
						}	
						else
						{
							echo "0";
						}					
					echo "</td>\n";	
					
					echo "<td>\n"; 
					
						if ($SubTotalAs > 0 && $SubTotalSeco > 0)
						 {
							//echo number_format(($SubTotalAs/$SubTotalSeco)*100,$CantDecAs,",",".");
							//$ley_as = number_format(($SubTotalAs/$SubTotalSeco)*100,3);
							$ley_as = ($SubTotalAs/$SubTotalSeco)*100;
						 }	
						else
						{
							echo "0";
                         }					
					echo "</td>\n";
					echo "<td>\n"; 
					
						if ($SubTotalS > 0 && $SubTotalSeco > 0)
						{
							//echo number_format(($SubTotalS/$SubTotalSeco)*100,$CantDecS,",",".");
							//$ley_s = number_format(($SubTotalS/$SubTotalSeco)*100,2);
							$ley_s = ($SubTotalS/$SubTotalSeco)*100;
						}	
						else
							echo "0";
					
					echo "</td>\n";
		
	
	       }	// fin if consulta que agrupa por proveedor y beneficio y conjunto
		  
		  // insertar en tabla
			
			$insertar = "INSERT INTO ram_web.flujos_concentrado (fecha,peso_humedo,porc_hum,ley_as,ley_s)";
			$insertar.= " VALUES('".$fecha_aux."',".$peso_humedo.",".$porc_hum.",".$ley_as.",".$ley_s.")";
			mysqli_query($link, $insertar);
			//echo $insertar."<br>";	
		
      //Incrementa la fecha en 1 Dia.
	    $ciclo = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
	    $rs10 = mysqli_query($link, $ciclo);
	    $row10 = mysqli_fetch_array($rs10);
	    $fecha_aux = $row10["fecha"];	

	 }	// fin while fecha
		 		
}  // fin While 	beneficio
?>	
</form>
</body>

<script language="javascript"> 
cerrar_sin(); 
</script>


</html>
