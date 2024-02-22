<?php 

	include("../principal/conectar_ref_web.php");
	
?>
<html>
<head>
<script language="JavaScript">
function Buscar()
{
	var  f=document.form1;

	f.action='ref_ing_circuitos.php?mostrar=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10";
}
function Excel(E)
{
	document.location = "../ref_web/ref_web_xls.php?";
}
</script>
<title>Sistema GYC Nave Electrolitica</title>
<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="post" name="form1">
<?php include("../principal/encabezado.php");?>
<?php
?>
 <table width="772" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
 <tr>
 <td width="760" align="center" valign="middle">
          <table width="750" border="0" cellpadding="3" class="TablaInterior">
            <tr>
              <td width="80">Informe del:</td>
              <td colspan="2">
			  <select name="dia1" size="1" >
				<?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{
						if (($mostrar == "S") && ($i == $dia1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("j")) and ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select> <select name="mes1" size="1" id="mes1">
		       	<?php
					for($i=1;$i<13;$i++)
					{
						if (($mostrar == "S") && ($i == $mes1))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else if (($i == date("n")) && ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else
							echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';
					}
				?>
                </select> <select name="ano1" size="1" id="select4">
        		<?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (($mostrar == "S") && ($i == $ano1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("Y")) && ($mostrar != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
                </select>&nbsp;&nbsp;<input name="buscar" type="button" value="buscar" onClick="Buscar()" ></td>
            </tr>
          </table>
		  <BR>
		<table width="747" height="175" border="1"  align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr align="center"  class="ColorTabla01"> 
            <td colspan="15">1.- RENOVACION ELECTRODOS GRUPOS Y PRODUCCION CATODOS 
              COMERCIALES</td>
          </tr>
          <tr> 
            <td width="74" align="center">CIRCUITO</td>
            <td width="104" align="center">GRUPO</td>
            <td width="82" align="center">TURNO</td>
            <td width="106" align="center">PRODUCCION</td>
            <td width="70" align="center"><p>DESC.</p>
              <p>NORMAL</p></td>
            <td colspan="2" align="center">RECUPERADO</td>
            <td colspan="2" align="center">RECHAZO</td>
            <td colspan="6" align="center">DETALLE RECHAZO</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="55" align="center">VALOR</td>
            <td width="54" align="center">%</td>
            <td width="56">VALOR</td>
            <td width="13" align="center">%</td>
            <td width="21" align="center">NE</td>
            <td width="23" align="center">ND</td>
            <td width="21" align="center">RA</td>
            <td width="20" align="center">CL</td>
            <td width="20" align="center">CS</td>
            <td width="21" align="center">OT</td>
          </tr>
          <?php
	$fecha=$ano1."-".$mes1."-".$dia1;
$Consulta =  "select sum(t1.peso_produccion) as produccion,t1.cod_grupo,t2.cod_circuito from sec_web.produccion_catodo as t1 ";
	$Consulta = $Consulta." inner join sec_web.grupo_electrolitico as t2 on t1.cod_grupo=t2.cod_grupo";
	$Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_grupo not in ('01','02','07') group by t1.cod_grupo";
	$Respuesta = mysqli_query($link, $Consulta);
	$total_prod=0;
	$total_rec=0;
	$total_rech=0;
	$total_cuba=0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
	    echo "<tr>\n";
		echo "<td>".$Fila["cod_circuito"]."&nbsp;</td>\n";
		echo "<td>".$Fila["cod_grupo"]."&nbsp</td>\n";
		echo "<td>&nbsp;</td>\n";
		$produccion=number_format($Fila["produccion"],"",".",".");
		echo "<td>$produccion</td>\n";
		$Consulta = "select cubas_descobrizacion as cant_cuba from sec_web.grupo_electrolitico ";
		$Consulta = $Consulta."where cod_grupo = '".$Fila["cod_grupo"]."'";
		$rs1 = mysqli_query($link, $Consulta);
		$row1 = mysqli_fetch_array($rs1);
		echo "<td>".$row1[cant_cuba]."</td>\n";
		
		$Consulta = "select ifnull(sum(t1.recuperado),0) as recuperado_tot, ifnull(sum(t1.rechazado),0) as rechazado_tot from sec_web.recuperacion_catodo as t1 ";
		$Consulta = $Consulta."where t1.fecha_produccion = '".$fecha."' AND cod_grupo = '".$Fila["cod_grupo"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		$Fila2 = mysqli_fetch_array($Respuesta2);
		$total_prod=$total_prod+$Fila["produccion"];
		$total_rec=$total_rec+$Fila["recuperado"];
		$total_rech=$total_rech+$Fila["rechazado"];				
		$total_cuba=$total_cuba+$row1["cant_cuba"];
		echo "<td>".$Fila2["recuperado_tot"]."</td>\n";
		echo "<td>&nbsp</td>\n";
		echo "<td>".$Fila2[rechazado_tot]."</td>\n";
		echo "<td>&nbsp</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";		
		echo "</tr>\n";						
       }
$total_prod2=number_format($total_prod,"",".",".");
echo "<td>Total</td>\n";
echo "<td>&nbsp;</td>\n";
echo "<td>&nbsp;</td>\n";	   
echo "<td>$total_prod2</td>\n";
echo "<td>$total_cuba</td>\n";
echo "<td>$total_rec</td>\n";
echo "<td>&nbsp</td>\n";
echo "<td>$total_rech</td>\n";
echo "<td>&nbsp</td>\n";
echo "<td>&nbsp</td>\n";
echo "<td>&nbsp</td>\n";
echo "<td>&nbsp</td>\n";
echo "<td>&nbsp</td>\n";
echo "<td>&nbsp</td>\n";
echo "<td>&nbsp</td>\n";


?>
          <tr align="center"> 
            <td height="59" colspan="15">
<p>&nbsp;</p>
              <p>&nbsp; </p>
              <table width="93%" height="104" border="1">
              <tr align="center"  class="ColorTabla01"> 
                <td colspan="15">2.-PRODUCCION AREA DE HOJAS MADRES</td>
              </tr>
              <tr> 
                <td width="21%" rowspan="2" align="center">GRUPO</td>
                <td width="1%" rowspan="2" align="center">PRODUCCION</td>
                <td colspan="5" align="center">RECHAZO</td>
                <td colspan="2" align="center">RECUPERADO</td>
              </tr>
              <tr> 
                <td width="11%" align="center">DELGADAS</td>
                <td width="15%" align="center">GRANULADAS</td>
                <td width="10%" align="center">GRUESAS</td>
                <td width="7%" align="center">TOTAL</td>
                <td width="7%" align="center">%RECH</td>
                <td width="7%" align="center">TOTAL</td>
                <td width="21%" align="center">%REC</td>
              </tr>
              <?php
				$total_peso=0;
				$total_del=0;
				$total_gran=0;
				$total_grue=0;
				$total_recuperado=0;	  	
	    		$consulta="select nombre_subclase as sub_clas, valor_subclase1 as sub_clase1 from proyecto_modernizacion.sub_clase ";
				$consulta=$consulta."where cod_clase='10001' order by cod_subclase";
				$Resp = mysqli_query($link, $consulta);
				while ($row2 = mysqli_fetch_array($Resp))
	       		{
            		$total_rech=0;		   
	    			echo "<tr>\n";
					echo "<td>".$row2["sub_clas"]."&nbsp;</td>\n";
					$Consulta5 = "select grupo,ifnull(rechazo_delgadas,0) as rec_del,ifnull(rechazo_granuladas,0) as rec_gran,ifnull(rechazo_gruesas,0) as rec_grue from prod_hojas_madres.produccion as t1 ";
					$Consulta5 = $Consulta5."inner join proyecto_modernizacion.sub_clase as t2  on t1.grupo=t2.valor_subclase1 ";
					$Consulta5 = $Consulta5."where t1.fecha = '".$fecha."' and t1.grupo = t2.valor_subclase1 and t1.grupo= '".$row2[sub_clase1]."' group by t1.grupo";
					$rs12 = mysqli_query($link, $Consulta5);
					$row12 = mysqli_fetch_array($rs12);
					$Consulta6="select ifnull(sum(unidades),0) as unidades_hm from sea_web.movimientos as t1 "; 
					$Consulta6=$Consulta6."where t1.fecha_movimiento ='".$fecha."' and t1.campo2= '".$row2[sub_clase1]."' and t1.tipo_movimiento='3'";
					$rs3 = mysqli_query($link, $Consulta6);
					$row3 = mysqli_fetch_array($rs3);
					echo "<td>".$row3[unidades_hm]."</td>\n";
					$Consulta5 = "select grupo,ifnull(rechazo_delgadas,0) as rec_del,ifnull(rechazo_granuladas,0) as rec_gran,ifnull(rechazo_gruesas,0) as rec_grue from prod_hojas_madres.produccion as t1 ";
					$Consulta5 = $Consulta5."inner join proyecto_modernizacion.sub_clase as t2  on t1.grupo=t2.valor_subclase1 ";
					$Consulta5 = $Consulta5."where t1.fecha = '".$fecha."' and t1.grupo = t2.valor_subclase1 and t1.grupo= '".$row2[sub_clase1]."' group by t1.grupo";
					$rs12 = mysqli_query($link, $Consulta5);
					$row12 = mysqli_fetch_array($rs12);
					echo "<td>".$row12[rec_del]."</td>\n";
					echo "<td>".$row12[rec_gran]."</td>\n";
					echo "<td>".$row12[rec_grue]."</td>\n";
					$total=$row12[rec_del]+$row12[rec_gran]+$row12[rec_grue];
					$total_unidades=$total_unidades+$row3[unidades_hm];
					$total_del=$total_del+$row12[rec_del];
		    		$total_gran=$total_gran+$row12[rec_gran];
		    		$total_grue=$total_grue+$row12[rec_grue];
					$total2=$total2+$total;
					
					if (($row3[unidades_hm]==0) or ($total==0))
					{$porc_rech=0;}
					else {$porc_rech=(($total/$total_unidades)*100);};
					$porc_rech2=number_format($porc_rech,"2",",","");
					echo "<td>$total</td>\n";
					echo "<td>$porc_rech2</td>\n";
					$Consulta7="select ifnull(total_recuperado,0) as recuperado_tot from prod_hojas_madres.produccion as t1 "; 
					$Consulta7=$Consulta7."where t1.fecha ='".$fecha."' and t1.grupo= '".$row2[sub_clase1]."'";
					$rs13 = mysqli_query($link, $Consulta7);
					$row13 = mysqli_fetch_array($rs13);
					echo "<td>".$row13["recuperado_tot"]."</td>\n";
					$total_recuperado=$total_recuperado+$row13["recuperado_tot"];
					if (($row3[unidades_hm]==0) or ($total==0)) 
					{$porc_rec=0;}
					else {$porc_rec=(($row13["recuperado_tot"]/$total)*100);};
					$porc_rec2=number_format($porc_rec,"2",",","");
					echo "<td>$porc_rec2</td>\n";
					echo "</tr>\n";								
          		}    
            	echo "<td>total</td>\n";	
				echo "<td>$total_unidades</td>\n";
				echo "<td>$total_del</td>\n";
				echo "<td>$total_gran</td>\n";
				echo "<td>$total_grue</td>\n";	
				echo "<td>$total2</td>\n";
				if (($total_unidades==0) or($total_unidades==0))
				{$porc_tot_rech=0;
			 	}
				else {$porc_tot_rech=(($total2/$total_unidades)*100);};
				$porc_tot_rech=number_format($porc_tot_rech,"2",",","");
				echo "<td>$porc_tot_rech</td>\n";
				echo "<td>$total_recuperado</td>\n";
				if (($total_unidades==0) or ($total2==0))
				{$porc_tot_rec=0;
			 	}
				else {$porc_tot_rec=(($total_recuperado/$total2)*100);};
				$porc_tot_rec=number_format($porc_tot_rec,"2",".","");
				echo "<td>$porc_tot_rec</td>\n";
			?>
            </table>        
              <p>&nbsp; </p> 
              <table width="87%" border="1">
                <tr align="center"  class="ColorTabla01"> 
                  <td colspan="12">3.-CONFECCION CATODOS INICIALES</td>
                </tr>
                <tr> 
                  <td width="9%" rowspan="3" align="center">TURNO</td>
                  <td width="17%" align="center">PRODUCCION</td>
                  <td width="24%" rowspan="2" align="center">PRODUCCION</td>
                  <td width="16%" rowspan="2" align="center">PRODUCCION</td>
                  <td width="13%" rowspan="3" align="center">CONSUMO</td>
                  <td width="21%" rowspan="3" align="center">OBSERVACIONES</td>
                </tr>
                <tr> 
                  <td rowspan="2" align="center">MFCI</td>
                </tr>
                <tr> 
                  <td align="center">MDB</td>
                  <td width="16%" align="center">MCO</td>
                </tr>
          <?php
		  	$total_mfci=0;
			$total_mdb=0;
			$total_mco=0;
	   		$consulta_cat_ini="select turno as turno_cat_ini,ifnull(produccion_mfci,0) as prod_mfci,ifnull(produccion_mdb,0) as prod_mdb,ifnull(produccion_mco,0) as prod_mco,observacion as observacion_cat_ini,ifnull(stock,0) as stock1,ifnull(rechazo_cat_ini,0) as rechazo_cat_ini1 from catodos_iniciales.iniciales as t1 ";
			$consulta_cat_ini=$consulta_cat_ini."where  t1.fecha = '".$fecha."' order by t1.turno";
			
			$Resp_cat_ini = mysqli_query($link, $consulta_cat_ini);
			while ($row_cat_ini = mysqli_fetch_array($Resp_cat_ini))
	       	{
	    		echo "<tr>\n";
				echo "<td>".$row_cat_ini[turno_cat_ini]."</td>\n";
				echo "<td>".$row_cat_ini[prod_mfci]."</td>\n";
				$total_mfci=$total_mfci+$row_cat_ini[prod_mfci];
				echo "<td>".$row_cat_ini[prod_mdb]."</td>\n";
				$total_mdb=$total_mdb+$row_cat_ini[prod_mdb];
				echo "<td>".$row_cat_ini[prod_mco]."</td>\n";
				$total_mco=$total_mco+$row_cat_ini[prod_mco];
				echo "<td>&nbsp;</td>\n";
				echo "<td>".$row_cat_ini[observacion_cat_ini]."</td>\n";
				
				
				echo "</tr>\n";								
          	} 
			echo "<td>total</td>\n";
			echo "<td>$total_mfci</td>\n";
		    echo "<td>$total_mdb</td>\n";
			echo "<td>$total_mco</td>\n";
			echo "<td>&nbsp;</td>\n";
			echo "<td>&nbsp;</td>\n";		   
       
	?>
              </table>
              <table width="87%" border="1">
                <tr> 
                  <td>STOCK (8:00)</td>
                <?php 
					$consulta_cat_ini_stock="select sum(stock) as stock1, sum(rechazo_cat_ini) as rechazo_ini_cat from  catodos_iniciales.iniciales as t1 ";
					$consulta_cat_ini_stock=$consulta_cat_ini_stock."where  t1.fecha = '".$fecha."' ";
					$Resp_cat_stock = mysqli_query($link, $consulta_cat_ini_stock);
					$row_cat_stock = mysqli_fetch_array($Resp_cat_stock);
					echo "<td>".$row_cat_stock[stock1]."</td>\n";
				?>
                </tr>
                <tr> 
                  <td>RECHAZO CATODOS INICIALES</td>
                 <?php  echo "<td>".$row_cat_stock[rechazo_ini_cat]."</td>\n";?>
                </tr>
              </table>
           
              <p>&nbsp; </p></td>
  </tr>
</table>
</table>
</form>
</body>
</html>
