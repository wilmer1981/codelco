<?php 	
 	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename="";
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
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
?>
<html>
<head>

<title>Proceso</title>
<body>
<center>
<form name="FrmProceso" method="post" action="">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5">
      <tr>
        <td width="883" align="left"><br>
          <table width="1000" height="20" border="1" cellpadding="3" cellspacing="0">
            <tr> 
              <td width="46" align="left">I.E.</td>
            <td>Num.Lote</td>
            <td>Fecha Creaci&oacute;n </td>
            <td>Marca Lote</td>
            <td>Sub Producto</td>
            <td>Num.Paquete</td>
		    <td>Peso</td>
		    <td>Unidades</td>
            </tr>
            <!-- </table>-->
            <?php
			$Cont=0;
			if ($Mostrar=='S')
			{
				
				$Consulta="  SELECT t1.fecha_creacion_lote,t1.cod_bulto,t1.num_bulto,t2.cod_paquete,t2.num_paquete,t1.corr_enm,t2.cod_producto,t1.cod_marca, ";
				$Consulta.=" t2.cod_subproducto,t2.peso_paquetes,t2.num_unidades  from sec_web.lote_catodo t1 ";
				$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
				$Consulta.=" and t1.num_paquete=t2.num_paquete ";
				$Consulta.=" where  ";
				$Consulta.=" LEFT(fecha_creacion_lote,4) <'".$CmbAno."'";
				$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  and t1.cod_estado=t2.cod_estado and t1.cod_estado='a'and t2.cod_estado='a' ";
             	$Respuesta=mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				$Cont=0;
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					
					$Cont++;
				//	echo $IEAnt.' vs '.$Fila["corr_enm"]."<br>";
					
					
					echo "<tr>"; 
					echo "<td width='40' align='center'>".$Fila["corr_enm"]."</td>";
					echo "<td width='50' align='center'>".$Fila["cod_bulto"]."-".$Fila["num_bulto"]."</td>";
					echo "<td width='70' align='center'>".$Fila["fecha_creacion_lote"]."</td>";
					/* CONSULTA DE MARCA DE CATODOS*/
					$Consulta="SELECT distinct t1.cod_marca,t2.descripcion from sec_web.lote_catodo t1 ";   
					$Consulta.="inner join sec_web.marca_catodos t2 on t1.cod_marca=t2.cod_marca ";
					$Consulta.=" where corr_enm='".$Fila["corr_enm"]."' and cod_bulto='".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."'	";
					$Respuesta4=mysqli_query($link, $Consulta);
					$Fila4=mysqli_fetch_array($Respuesta4);
					echo "<td width='100' align='center'>".$Fila4["descripcion"]."&nbsp;</td>";
					/* CONSULTA DE SUBPRODUCTO DE CATODOS*/
					$Consulta="SELECT abreviatura from proyecto_modernizacion.subproducto where cod_producto='".$Fila["cod_producto"]."' ";
					$Consulta.=" and cod_subproducto='".$Fila["cod_subproducto"]."'	";
					$Respuesta6=mysqli_query($link, $Consulta);
					$Fila6=mysqli_fetch_array($Respuesta6);
					echo "<td width='90' align='left'>".$Fila6["abreviatura"]."&nbsp;</td>";
					echo "<td width='70' align='center'>".$Fila["cod_paquete"].'-'.$Fila["num_paquete"];"</td>";
					echo "<td width='55' align='center'>".$Fila["peso_paquetes"]."&nbsp;</td>";
					echo "<td width='59' align='center'>".$Fila["num_unidades"]."&nbsp;</td>";
					echo "</tr>";
					$IEAnt=$Fila["corr_enm"];
					if($Cont=='2')
						$Cont=0;
				}
				echo "</table>";	
			}
		?>
           
     <!--   </td>
  </tr>-->
  </table>
  </form>
  </center>
</body>
</html>
