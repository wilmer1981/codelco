<?php
	header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_principal.php");
	if (!isset($DiaIni))
	{
		$DiaIni = date("d");
		$MesIni = date("m");
		$AnoIni = date("Y");
		$DiaFin = date("d");
		$MesFin = date("m");
		$AnoFin = date("Y");
	}
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
<title>Informe Impurezas</title>
<script language="JavaScript">
</script>
</head>
<form name="frmPrincipal" action="" method="post">
<table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">

  <tr align="center" > 
      <td colspan="4" class="ColorTabla01"><strong>INFORME IMPUREZAS POR TIPO</strong></td>
  </tr>
  <tr> 
    <td colspan="4"></td>
  </tr>
  <tr> 
    </td>
  </tr>
   <tr align="center">
    <td colspan="4"> 
       <table width="738" height="132" border="0">
          <tr> 
          
            <td width="279"> 
            </td>
         
            
          <td width="107"><select  style="width:70" name="cmbleyes" size="10" id="cmbleyes" > 
        </table>
		
	  </p>
        <p> 
          
          
        </p></td>
  </tr>
</table>
<br>
<table width="786" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01"> 
      <td width="200" align="left"><strong>Circuito <?php echo $cmbcircuito; ?></strong></td>
	  <?php
	     $consulta = "SELECT * FROM ref_web.leyes";
		 $consulta.= " ORDER BY cod_leyes asc";
		 $rs = mysqli_query($link, $consulta);
		 while ($row = mysqli_fetch_array($rs))
			{
				echo '<td width="73"><strong>'.$row["abreviatura"].'</strong></td>';   				 
		    }   ?>
   
  </tr>  
  <?php	
		$mostrar='S';	
       if ($mostrar=='S')
          {  
		
   			$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
			$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
			$consulta_ley="select * from ref_web.leyes order by cod_leyes asc";
			$Respuesta_ley = mysqli_query($link, $consulta_ley);
			while ($Fila_ley=mysqli_fetch_array($Respuesta_ley))
	    		{
					$Consulta_fecha="select distinct left(t1.fecha_muestra,10) as fecha from cal_web.solicitud_analisis as t1 ";
    				$Consulta_fecha.="inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.rut_funcionario=t2.rut_funcionario ";
    				$Consulta_fecha.="where ceiling(t1.id_muestra)='".$cmbcircuito."' and t1.cod_producto='41' and t1.cod_subproducto='22' and t2.cod_leyes='".$Fila_ley["cod_leyes"]."' and left(t1.fecha_muestra,10) between '".$FechaInicio."' and '".$FechaTermino."' order by left(t1.fecha_muestra,10) asc";
					//echo $Consulta_fecha;
					$Respuesta_fecha = mysqli_query($link, $Consulta_fecha);
					while ($Fila_fecha = mysqli_fetch_array($Respuesta_fecha))
	       				{
				    		echo "<tr>\n";
							echo "<td align='right' width='100' class=detalle02>".$Fila_fecha["fecha"]."</td>\n";
				    		$consulta_ley="select * from ref_web.leyes order by cod_leyes asc";
	                		$Respuesta_ley = mysqli_query($link, $consulta_ley);
	                		while ($Fila_ley=mysqli_fetch_array($Respuesta_ley))
	                  			{
		        	    			$Consulta="select  left(t1.fecha_muestra,10) as fecha ,t2.valor as valor,t2.candado,t2.cod_unidad,t2.cod_leyes from cal_web.solicitud_analisis as t1 ";
        			    			$Consulta.="inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.rut_funcionario=t2.rut_funcionario ";
        			    			$Consulta.="where ceiling(t1.id_muestra)='".$cmbcircuito."' and t1.cod_producto='41' and t1.cod_subproducto='22' and t2.cod_leyes='".$Fila_ley["cod_leyes"]."' and left(t1.fecha_muestra,10)='".$Fila_fecha["fecha"]."'";
					    			$Respuesta_res = mysqli_query($link, $Consulta);
 	            	    			$Fila_res = mysqli_fetch_array($Respuesta_res);
									$consulta_unidad="select abreviatura from proyecto_modernizacion.unidades where cod_unidad='".$Fila_res[cod_unidad]."'";
									$Respuesta_unidad = mysqli_query($link, $consulta_unidad);
 	            	    			$Fila_unidad = mysqli_fetch_array($Respuesta_unidad);
					    			if ($Fila_res=='')
					       				{echo "<td align='center'class=detalle02>&nbsp;</td>\n"; }
                        			else { $ley=number_format($Fila_res["valor"],"2",",","");
									       echo "<td align='center'  class=detalle01>$ley    ". $Fila_unidad["abreviatura"]."</td>\n";}
					  			}
					   		 echo "</tr>\n";
						}
				
					}
			
			}	
	
	?>
	
  
</table>
<br>
<br>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
      <td align="center"> </td>
  </tr>
</table>
</form>
</body>
</html> 
