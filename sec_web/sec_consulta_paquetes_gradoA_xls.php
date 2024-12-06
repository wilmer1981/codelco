<?php 	
 	set_time_limit(3000);
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
	$CodigoDeSistema = 3;
	$CodigoDePantalla =28;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"S";
	$Recarga = isset($_REQUEST["Recarga"])?$_REQUEST["Recarga"]:"";

	$cmbproducto    = isset($_REQUEST["cmbproducto"])?$_REQUEST["cmbproducto"]:"";
	$cmbsubproducto = isset($_REQUEST["cmbsubproducto"])?$_REQUEST["cmbsubproducto"]:"";
	$CmbEstado      = isset($_REQUEST["CmbEstado"])?$_REQUEST["CmbEstado"]:"";
	$CmbMes         = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno         = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");	
	$cmbmovimiento  = isset($_REQUEST["cmbmovimiento"])?$_REQUEST["cmbmovimiento"]:"";
?>
<html>
<head>
<title>Detalle Paquetes Grado "A" Excel</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body>
<center>
<form name="FrmProceso" method="post" action="">
        <table border="1" cellpadding="3" cellspacing="0">
          <tr>
          <td>Producto</td><td colspan="10">
          <?php
 				$consulta = "SELECT * FROM proyecto_modernizacion.productos WHERE cod_producto = '".$cmbproducto."' ";
				$rs = mysqli_query($link, $consulta);
				if($row = mysqli_fetch_array($rs))
					echo $row["descripcion"];         
		  ?>
          </td>
          </tr>
          <tr>
          <td>SubProducto</td>
		  <td colspan="10">
          <?php
				$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = '".$cmbproducto."' AND cod_subproducto='".$cmbsubproducto."'";
				$rs = mysqli_query($link, $consulta);
				if($row = mysqli_fetch_array($rs))
					echo $row["descripcion"];          
		  ?>
          </td>          
          </tr>
          <tr>
          <td>Periodo</td>
		  <td colspan="10">
          <?php
				if (strlen($CmbMes)==1)
				{
					$CmbMes="0".$CmbMes;
				}
				$FechaInicio=$CmbAno."-".$CmbMes."-01";
				$FechaFin=$CmbAno."-".$CmbMes."-31";
				echo $CmbAno." ".$meses[$CmbMes-1];          
		  ?>
          </td>          
          </tr>
          <tr>
          <td>Estado</td>
		  <td colspan="10">
          <?php
             switch($CmbEstado)
			  {
					case "a":
						echo "Abierto";
					break; 
					case "c":
						echo "Cerrado";
					break; 
					case "t":
						echo "Abierto y Cerrado";
					break; 
			  }
          
		  ?>
          </td>          
          </tr>

        <tr class="ColorTabla01"> 
            <td align="left"><div align="center">I.E.</div></td>
            <td align="left"><div align="center">Cliente</div></td>
            <td align="left"><div align="left">Cod.Lote</div></td>
            <td align="left"><div align="left">Num.Lote</div></td>
            <td align="left"><div align="left">Fecha Creacion Lote</div></td>
            <td align="left"><div align="left">Cod.Paquete</div></td>
            <td align="left"><div align="left">Num.Paquete</div></td>
            <td><div align="center">Fecha Creacion Paquete</div></td>
            <td align="left"><div align="left">Estado</div></td>
            <td><div align="center">Peso</div></td>
            <td><div align="center">Unidades</div></td>
            <td><div align="center">Promedio</div></td>
        </tr>
        <?php
			if ($Mostrar=='S')
			{
				if (strlen($CmbMes)==1)
				{
					$CmbMes="0".$CmbMes;
				}
				$FechaInicio=$CmbAno."-".$CmbMes."-01";
				$FechaFin=$CmbAno."-".$CmbMes."-31";
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
				$consulta.= " WHERE cod_clase = '3004' and cod_subclase='".intval($CmbMes)."'";		
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{  
					$LetraMes=$row["nombre_subclase"];
				}	
				$Consulta="SELECT t1.cod_bulto,t1.num_bulto,t1.cod_estado,t3.cod_cliente,t2.cod_paquete,t2.num_paquete,t1.corr_enm,t1.fecha_creacion_lote,t2.fecha_creacion_paquete,t2.peso_paquetes,t2.num_unidades 
				from lote_catodo t1 
				inner join paquete_catodo t2 on t1.num_paquete=t2.num_paquete and t1.cod_paquete=t2.cod_paquete 
				and t1.fecha_creacion_paquete=t2.fecha_creacion_paquete and t1.cod_estado=t2.cod_estado and t2.cod_producto='".$cmbproducto."' and t2.cod_subproducto='".$cmbsubproducto."'
				inner join embarque_ventana t3 on t1.corr_enm=t3.corr_enm and t1.cod_bulto=t3.cod_bulto and t1.num_bulto=t3.num_bulto and t3.cod_producto='".$cmbproducto."' and t3.cod_subproducto='".$cmbsubproducto."'
				where t1.fecha_creacion_lote BETWEEN '".$FechaInicio."' and '".$FechaFin."' "; 
				if($CmbEstado!='t')
					$Consulta.="and t1.cod_estado='".$CmbEstado."' ";
				$Consulta.=" and t1.cod_bulto='".$LetraMes."' ";
				//echo $Consulta;
				$Respuesta=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo "<tr>"; 
					echo "<td align='center'>".$Fila["corr_enm"]."</td>";
					$Consulta="select * from sec_web.nave where cod_nave ='".$Fila["cod_cliente"]."'";
					$Respuesta2=mysqli_query($link, $Consulta);
					if($Fila2=mysqli_fetch_array($Respuesta2))
					{
						$Cliente=$Fila2["nombre_nave"];
					}
					else
					{
						$Consulta="select * from sec_web.cliente_venta where cod_cliente ='".$Fila["cod_cliente"]."'";
						$Respuesta2=mysqli_query($link, $Consulta);
						if($Fila2=mysqli_fetch_array($Respuesta2))
						{
							$Cliente=$Fila2["sigla_cliente"];
						}
					}
					echo "<td align='center'>".$Cliente."</td>";					
					echo "<td align='center'>".$Fila["cod_bulto"]."</td>\n";
					echo "<td align='right'>".$Fila["num_bulto"]."</td>\n";
					echo "<td align='center'>".FechaDMA($Fila["fecha_creacion_lote"])."</td>";
					echo "<td align='center'>".$Fila["cod_paquete"]."</td>\n";
					echo "<td align='right'>".$Fila["num_paquete"]."</td>\n";
					echo "<td align='center'>".FechaDMA($Fila["fecha_creacion_paquete"])."&nbsp;</td>";
					echo "<td align='center'>".$Fila["cod_estado"]."</td>";
					echo "<td align='right'>".$Fila["peso_paquetes"]."</td>";
					echo "<td align='right'>".$Fila["num_unidades"]."</td>";
					if($Fila["num_unidades"]>0)
						$Prom=$Fila["peso_paquetes"]/$Fila["num_unidades"];
					else
						$Prom=0;	
					echo "<td align='right'>".round($Prom,0)."</td>";
					echo "</tr>";
				}
			}
		?>
</table>
  </form>
  </center>
</body>
</html>
<?php 
function FechaDMA($Fecha)
{
	$FecAux=explode('-',$Fecha);
	$FecDMA=$FecAux[2]."-".$FecAux[1]."-".$FecAux[0];
	return($FecDMA);
}
?>