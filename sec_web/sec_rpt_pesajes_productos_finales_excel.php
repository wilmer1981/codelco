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
	include("../principal/conectar_principal.php");

	$productos = array(18=>"CATODOS", 64=> "SALES", 48=> "DESPUNTES Y LAMINAS", 57=> "BARROS REFINERIA", 66=> "OTROS PESAJES", 19=> "RESTOS ANODOS", 17=> "ANODOS");
	
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
		
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin." 08:00:00";
	$FechaInicio1 =date("Y-m-d", mktime(1,0,0,$MesIni,$DiaIni,$AnoIni));	

	$Fechainiturno =$FechaInicio;
	$Fechafturno =date("Y-m-d", mktime(1,0,0,$MesFin,(intval($DiaFin)+1),$AnoFin));	


?>
         <table border="1" align="center" cellpadding="2" cellspacing="1">
         <tr> 
             <td colspan="7">Periodo: <strong>Desde :</strong><?php echo $Fechainiturno." 08:00:00";?>  <strong>Hasta :</strong><?php echo $Fechafturno." 08:00:00";?></td>
 
          </tr>
          <tr> 
             <td><div align="center">Fecha/Hora Creaci&oacute;n</div></td>
            <td><div align="center">Nro de Serie</div></td>
            <td><div align="center">Peso</div></td>
            <td><div align="center">Unidad</div></td>
            <td><div align="center">Estado</div></td>
            <td><div align="center">Cod. Producto</div></td>
            <td><div align="center">Grupo</div></td>
             <td ><div align="center">Marca</div></td>  
           <td ><div align="center">I.E.</div></td>
          </tr>
         
			<?php  
			$cont = 0;			
		$Eliminar="Delete from sec_web.tmp_rep_product_final where Rut='".$CookieRut."' ";
		mysqli_query($link, $Eliminar);

		$Consulta="insert into sec_web.tmp_rep_product_final(fecha_creacion_paquete,corr_enm,cod_producto,cod_subproducto,num_paquete,num_unidades,cod_grupo,cod_marca,peso_paquetes,cod_estado,cod_paquete,Rut)";
		$Consulta.=" select CONCAT(t1.fecha_creacion_paquete,' ',t1.hora),t2.corr_enm,t1.cod_producto,t1.cod_subproducto,t1.num_paquete, t1.num_unidades ,t1.cod_grupo,t2.cod_marca,t1.peso_paquetes,t1.cod_estado,t1.cod_paquete,'".$CookieRut."' from sec_web.paquete_catodo t1 ";
		$Consulta.=" inner join sec_web.lote_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
		$Consulta.="  where t1.fecha_creacion_paquete BETWEEN '".$Fechainiturno."' and '".$Fechafturno."'";
		if($CmbProducto!='T')
			$Consulta.=" and t1.cod_producto = '".$CmbProducto."'";	
			
		if($CmbSubProducto!='T')
		{
				$Consulta.=" and t1.cod_subproducto = '".$CmbSubProducto."'";	
		}
		
		mysqli_query($link, $Consulta);
		$Eliminar="Delete from sec_web.tmp_rep_product_final where Rut='".$CookieRut."' and cod_producto = 48 and cod_subproducto = 10 ";	
		mysqli_query($link, $Eliminar);

			
			$Consulta1=" select * from sec_web.tmp_rep_product_final ";
			$Consulta1.=" where Rut='".$CookieRut."'  and (fecha_creacion_paquete  BETWEEN  '".$Fechainiturno." 08:00:00' and  '".$Fechafturno." 08:00:00' )";
			if($CmbProducto!='T')
				$Consulta1.=" and cod_producto = '".$CmbProducto."'";	
			if($CmbSubProducto!='T')
				$Consulta1.=" and cod_subproducto = '".$CmbSubProducto."'";	
			$Consulta1.=" ORDER BY fecha_creacion_paquete ASC ";
		   	$Respuesta=mysqli_query($link, $Consulta1);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
					if ($Fila["cod_estado"]=="c")
					{
						$Estado="Cerrado";
					}
					else
					{
						$Estado="Abierto";
					}
					$Consulta="select * from proyecto_modernizacion.subproducto ";
					$Consulta.=" where cod_producto='".$Fila["cod_producto"]."' and cod_subproducto='".$Fila["cod_subproducto"]."' ";
					$Respuesta1=mysqli_query($link, $Consulta);
					$Fila1=mysqli_fetch_array($Respuesta1);
					$Producto=$Fila1["abreviatura"];	
				   ?><tr>
					 <td><?php echo $Fila[fecha_creacion_paquete];?></td>
					 <td><?php echo $Fila["cod_paquete"]."-".$Fila["num_paquete"];?></td>
					 <td><?php echo $Fila["peso_paquetes"];?></td>
					 <td><?php echo $Fila["num_unidades"];?></td>
					 <td><?php echo $Estado;?></td>
					 <td><?php echo $Producto;?></td>
					 <td><?php echo $Fila["cod_grupo"];?></td>
						 <td><?php echo $Fila["cod_marca"];?></td>
                         	 <td><?php echo $Fila["corr_enm"];?></td>
				</tr>
                <?php
				$SumaPeso=$SumaPeso+$Fila["peso_paquetes"];
				$SumaUnidades=$SumaUnidades+$Fila["num_unidades"];
				$cont++;
			}
			echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td><strong>Total</strong></td>";
			echo "<td align='right'><strong>".$SumaPeso."</strong></td> ";		
			echo "<td align='right'><strong>".$SumaUnidades."</strong></td> ";	
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
			?>
        </table> 