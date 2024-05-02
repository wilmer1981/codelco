<?php
	include("../principal/conectar_sec_web.php");
	
	

?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">

function Buscar(f)
{
	f.action = "sec_ing_grupo_electrolitico_proceso.php?opcion2=B&txtgrupo=" + f.cmbfecha.value ;
	f.submit();
}


/****************/
function Salir()
{
	window.close();
}
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
	     $consulta = "SELECT * FROM ref_web.leyes";
		 $consulta.= " ORDER BY cod_leyes asc";
		 $rs = mysqli_query($link, $consulta);
		 while ($row = mysqli_fetch_array($rs))
			{
				echo '<td width="73">'.$row["abreviatura"].'</td>';   				 
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
			$ponderado=0;
			$consulta_ley="select * from ref_web.leyes order by cod_leyes asc";
			$Respuesta_ley = mysqli_query($link, $consulta_ley);
			while ($Fila_ley=mysqli_fetch_array($Respuesta_ley))
	    		{
				   $consulta_circuitos = "SELECT * FROM sec_web.circuitos ";
				   $consulta_circuitos.= " ORDER BY cod_circuito";
				   $rs_c = mysqli_query($link, $consulta_circuitos);
				   while ($row_c = mysqli_fetch_array($rs_c))
				    {				  
			
						$Consulta_fecha="select distinct left(t2.fecha_hora,10) as fecha from cal_web.solicitud_analisis as t1 ";
    					$Consulta_fecha.="inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.rut_funcionario=t2.rut_funcionario and t1.id_muestra=t2.id_muestra ";
    					$Consulta_fecha.="where ceiling(t2.id_muestra)='".$row_c["cod_circuito"]."'  and t2.id_muestra not in ('1-HM') and t2.cod_producto='41' and t2.cod_subproducto='22' and t2.cod_leyes='".$Fila_ley["cod_leyes"]."' and left(t1.fecha_muestra,10) between '".$FechaInicio."' and '".$FechaTermino."'";
						//echo $Consulta_fecha;
						$Respuesta_fecha = mysqli_query($link, $Consulta_fecha);
	    				while ($Fila_fecha = mysqli_fetch_array($Respuesta_fecha))
	    	   				{
					    		echo "<tr>\n";
	            	    		echo "<td align='center' width='85'>".$Fila_fecha["fecha"]."</td>\n";
				    			$consulta_ley="select * from ref_web.leyes order by cod_leyes asc";
	                			$Respuesta_ley = mysqli_query($link, $consulta_ley);
	                			while ($Fila_ley=mysqli_fetch_array($Respuesta_ley))
	                  				{
									   $consulta_circuitos = "SELECT * FROM sec_web.circuitos ";
				  						$consulta_circuitos.= " ORDER BY cod_circuito";
				  						$rs_c = mysqli_query($link, $consulta_circuitos);
										$ponderado=0;
				  						while ($row_c = mysqli_fetch_array($rs_c))
				   							{								
												$Consulta="select  left(t2.fecha_hora,10) as fecha ,t2.valor as valor,t2.candado,t2.cod_unidad,t2.cod_leyes from cal_web.solicitud_analisis as t1 ";
												$Consulta.="inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.rut_funcionario=t2.rut_funcionario and t1.id_muestra=t2.id_muestra ";
												$Consulta.="where ceiling(t2.id_muestra)='".$row_c["cod_circuito"]."' and t2.id_muestra not in ('1-HM') and t2.cod_producto='41' and t2.cod_subproducto='22' and t2.cod_leyes='".$Fila_ley["cod_leyes"]."' and left(t1.fecha_muestra,10)='".$Fila_fecha["fecha"]."' order by left(t1.fecha_muestra,10) asc";
												//echo $Consulta."<br>";
												$Respuesta_res = mysqli_query($link, $Consulta);
												$Fila_res = mysqli_fetch_array($Respuesta_res);
												if ($row_c["cod_circuito"]=='01')
												    {$ponderado=$ponderado+$Fila_res["valor"]*0.5;}
												else {$ponderado=$ponderado+$Fila_res["valor"];}
					                        }
									   $ponderado=number_format($ponderado/5.5,"3",",","");		
									   echo "<td align='center' width='85' class=detalle01>".$ponderado."</td>\n";
				                    				
					  				}
									
					   		
							}	
                     }
			 		
					 					
				}
				 
		echo "</tr>\n";
?>
</table> 
</tr>
</table> 
	 
	  
        <br>
   
</tr>
</table>	    
</form>

</body>
</html>
<?php 	include("../principal/cerrar_sec_web.php"); ?>


