<?php include("../principal/conectar_ref_web.php"); 
    function FormatoFecha($f)
	{
		$fecha = substr($f,8,2)."/".substr($f,5,2)."/".substr($f,0,4)."  ".substr($f,11,2).":".substr($f,14,2);
		return $fecha;
	}
	
	$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:date("Y-m-d");
	$mostrar = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"S";
	//$mostrar='S';
	$ano1=substr($fecha,0,4);
	$mes1=substr($fecha,5,2);
	$dia1=substr($fecha,8,2);
?>


<html>
<head>
<title>Conexiones y Desconexiones</title>
</head>
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<script language="JavaScript">
<!--
function Eliminar(fecha,cod_grupo,tipo_desconexion,fecha_desconexion)
{
	var f = document.FrmPrincipal;
	if (confirm("Esta seguro que desea Eliminar permanentemente el dato"))
	{
     f.action = "sec_ing_estadistica_cortes_proceso01_ref.php?fecha="+fecha+"&cod_grupo="+cod_grupo+"&tipo_desconexion="+tipo_desconexion+"&fecha_desconexion="+fecha_desconexion+"&proceso=E";
	 f.submit();
	} 
}
function Modificar(fecha)
{
    var f = document.FrmPrincipal;
    f.action = "Detalle_hojas_madres_rechazo_proceso2.php?opcion=M&fecha="+fecha;
	f.submit();
}	
function Imprimir()
{
	window.print();
}
//-->
</script>


<body>

<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="fecha" value="<?php echo ''.$fecha.''; ?>">
<TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm lbl">
 <TBODY>
      <TR  vAlign=top  class=dt>  
        <TD width="100%" vAlign=bottom colspan=3> <H4><B>AREA DE PRODUCCION HOJAS 
            MADRES : &nbsp;&nbsp;<?php echo $dia1.'-'.$mes1.'-'.$ano1; ?></B></H4></TD>
        <?php 
	       echo'<TD width="14%" ><div align="right">';
		   echo "<a href=\"JavaScript:Imprimir()\">";
		   echo '<img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>';
	     ?>
               <table width="100%" height="92" border="0">
                <tr align="center"  class="cm lbl"> 
                  <td height="18" colspan="15">&nbsp;</td>
              </tr>
              <tr class=lcol> 
                  <td width="21%" rowspan="2" align="center"><strong>GRUPO</strong></td>
                  <td width="1%" rowspan="2" align="center"><strong>PRODUCCION</strong></td>
                  <td colspan="5" align="center"><strong>RECHAZO</strong></td>
                  <td colspan="2" align="center"><strong>RECUPERADO</strong></td>
              </tr>
              <tr class=lcol> 
                  <td width="11%" align="center"><strong>DELGADAS</strong></td>
                  <td width="15%" align="center"><strong>GRANULADAS</strong></td>
                  <td width="10%" align="center"><strong>GRUESAS</strong></td>
                  <td width="7%" align="center"><strong>TOTAL</strong></td>
                  <td width="7%" align="center"><strong>%</strong></td>
                  <td width="7%" align="center"><strong>TOTAL</strong></td>
                  <td width="21%" align="center"><strong>%</strong></td>
              </tr>
           <?php
			  if ($mostrar == "S")
			   {		   
		   
				$total_peso=0;
				$total_del=0;
				$total_gran=0;
				$total_grue=0;
				$total_recuperado=0;	
				$total_unidades=0;	
				$total2=0;	
				$row13=array();
	    		$consulta="select nombre_subclase as sub_clas, valor_subclase1 as sub_clase1 from proyecto_modernizacion.sub_clase ";
				$consulta=$consulta."where cod_clase='10001' order by cod_subclase";
				$Resp = mysqli_query($link,$consulta);
				while ($row2 = mysqli_fetch_array($Resp))
	       		{
            		$total_rech=0;		   
	    			echo "<tr class=lcol>\n";
					echo "<td align='center'>".$row2["sub_clas"]."&nbsp;</td>\n";
					$Consulta5 = "select cod_grupo,ifnull(rechazo_delgadas,0) as rec_del,ifnull(rechazo_granuladas,0) as rec_gran,ifnull(rechazo_gruesas,0) as rec_grue from ref_web.produccion as t1 ";
					$Consulta5 = $Consulta5."inner join proyecto_modernizacion.sub_clase as t2  on t1.cod_grupo=t2.valor_subclase1 ";
					$Consulta5 = $Consulta5."where t1.fecha = '".$fecha."' and t1.cod_grupo = t2.valor_subclase1 and t1.cod_grupo= '".$row2['sub_clase1']."' group by t1.cod_grupo";
					$rs12 = mysqli_query($link,$Consulta5);
					$row12 = mysqli_fetch_array($rs12);
					$consulta_fecha="select max(t1.fecha) as fecha from ref_web.grupo_electrolitico2 as t1 where t1.fecha <=  '".$fecha."' and t1.cod_grupo ='0".$row2['sub_clase1']."' group by t1.cod_grupo";
					$rs_fecha = mysqli_query($link,$consulta_fecha);
					$row_fecha = mysqli_fetch_array($rs_fecha);
					$Consulta6 =  "select max(t1.fecha) as fecha,t1.cod_grupo,t1.cod_circuito,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 as t1 ";
					$Consulta6 = $Consulta6." where  t1.fecha = '".$row_fecha['fecha']."' and t1.cod_grupo ='0".$row2['sub_clase1']."' group by t1.cod_grupo";
					$rs3 = mysqli_query($link,$Consulta6);
					$row3 = mysqli_fetch_array($rs3);
					$produccion=(($row3['hojas_madres']*$row3['num_catodos_celdas'])*2);         
					echo "<td align='center'>$produccion&nbsp</td>\n";
					$Consulta5 = "select cod_grupo,ifnull(rechazo_delgadas,0) as rec_del,ifnull(rechazo_granuladas,0) as rec_gran,ifnull(rechazo_gruesas,0) as rec_grue from ref_web.produccion as t1 ";
					$Consulta5 = $Consulta5."inner join proyecto_modernizacion.sub_clase as t2  on t1.cod_grupo=t2.valor_subclase1 ";
					$Consulta5 = $Consulta5."where t1.fecha = '".$fecha."' and t1.cod_grupo = t2.valor_subclase1 and t1.cod_grupo= '".$row2['sub_clase1']."' group by t1.cod_grupo";
       				$rs12 = mysqli_query($link,$Consulta5);
					$row12 = mysqli_fetch_array($rs12);
					$rec_del =isset($row12['rec_del'])?$row12['rec_del']:0;
					$rec_gran=isset($row12['rec_gran'])?$row12['rec_gran']:0;
					$rec_grue=isset($row12['rec_grue'])?$row12['rec_grue']:0;
					echo "<td align='center'>".$rec_del."&nbsp</td>\n";
					echo "<td align='center'>".$rec_gran."&nbsp</td>\n";
					echo "<td align='center'>".$rec_grue."&nbsp</td>\n";
					$total=$rec_del + $rec_gran + $rec_grue;
					$total_unidades=$total_unidades+$produccion;
					$total_del  = $total_del +$rec_del;
		    		$total_gran = $total_gran+$rec_gran;
		    		$total_grue = $total_grue+$rec_grue;
					$total2     = $total2+$total;
					if (($produccion==0) or ($total==0))
					{$porc_rech=0;}
					else {$porc_rech=(($total/$total_unidades)*100);};
					$porc_rech2=number_format($porc_rech,"2",",","");
					echo "<td align='center' >$total&nbsp</td>\n";
					echo "<td align='center'>$porc_rech2&nbsp</td>\n";
					$Consulta7="select ifnull(recuperado,0) as recuperado from ref_web.recuperado as t1 "; 
					$Consulta7=$Consulta7."where t1.fecha ='".$fecha."' ";
					$rs13 = mysqli_query($link,$Consulta7);
					$row13 = mysqli_fetch_array($rs13);
					echo "<td align='center'>--&nbsp</td>\n";
					echo "<td align='center'>--&nbsp</td>\n";
					echo "</tr>\n";								
          		}   
				$recuperado = isset($row13['recuperado'])?$row13['recuperado']:0;				
            	echo "<td align='right' class=lcol><strong>TOTAL</strong></td>\n";	
				echo "<td align='center' class=lcol><font color='blue'>$total_unidades&nbsp</font></td>\n";
				echo "<td align='center' class=lcol><font color='blue'>$total_del&nbsp</font></td>\n";
				echo "<td align='center' class=lcol><font color='blue'>$total_gran&nbsp</font></td>\n";
				echo "<td align='center' class=lcol><font color='blue'>$total_grue&nbsp</font></td>\n";	
				echo "<td align='center' class=lcol><font color='blue'>$total2&nbsp</font></td>\n";
				if (($total_unidades==0) or($total_unidades==0))
				{
					$porc_tot_rech=0;
			 	}
				else {$porc_tot_rech=(($total2/$total_unidades)*100);};
				$porc_tot_rech=number_format($porc_tot_rech,"2",",","");
				echo "<td align='center' class=lcol><font color='blue'>$porc_tot_rech&nbsp</font></td>\n";
				echo "<td align='center' class=lcol><font color='blue'>".$recuperado."&nbsp</font></td>\n";
				if (($total_unidades==0) or ($total2==0))
				{$porc_tot_rec=0;
			 	}
				else {$porc_tot_rec=(($recuperado/$total_unidades)*100);};
				$porc_tot_rec=number_format($porc_tot_rec,"2",".","");
				echo "<td align='center' class=lcol><font color='blue'>$porc_tot_rec&nbsp</font></td>\n";
			}
		?>
            </table>
    </TBODY>
	

	<TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm lbl">
 <TBODY>
      <TR  vAlign=top  class=dt>  
        <TD width="100%" vAlign=bottom colspan=3> <H4><B>AJUSTES DE CATODOS INICIALES: 
         </B></H4></TD>
              
      <table width="100%" height="53" border="0">
        <tr align="center"  class="cm lbl"> 
          <td height="18" colspan="9">&nbsp;</td>
        </tr>
        <tr class=lcol> 
          <td height="29" align="center">FECHA</td>
          <td align="center">AJUSTE</td>
          <td align="center">TIPO AJUSTE</td>
        </tr>
		<?php 
		   $consulta="select * from ref_web.ajustes where fecha='".$fecha."'";
	   	   $rs = mysqli_query($link,$consulta);
		   $row = mysqli_fetch_array($rs);
		   $fecha  = isset($row['fecha'])?$row['fecha']:"";
		   $ajuste = isset($row['ajuste'])?$row['ajuste']:"";
		   $tipo   = isset($row['tipo'])?$row['tipo']:"";
		   echo "<tr class=lcol>\n";
		   echo "<td align='center'>".$fecha."&nbsp</td>\n";
		   echo "<td align='center'>".$ajuste."&nbsp</td>\n";
		   echo "<td align='center'>".$tipo."&nbsp</td>\n";
		   echo "</tr>\n";
		
		?>
		
	    </TABLE>  	
      </TABLE>
	  <?php
	    echo '<TD width="10%" ><div align="center">';
		echo "<a href=JavaScript:Modificar($fecha)>";
		echo '<img src="archivos/modificar.gif" width="25" height="25" title="Modificar datos ya ingresados"></A></div></TD>';
	?>
</form>
            
</body>
</html>
