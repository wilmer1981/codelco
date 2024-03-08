<?php	        ob_end_clean();
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
	include("../principal/conectar_pac_web.php");
?>
<html>
<head>
<title>Planta de &Aacute;cido</title>
</head>
<body>
<form name="FrmConsultaGuias" action="" method="post">
  <table border="1">
    <tr> 
      <td align="center">Fecha</td>
      <td align='center'>Guia</td>
      <td align='center'>Patente</td>
      <td align='left'>Cliente</td>
      <td align='center'>Toneladas</td>
	  <td align='center'>V.Unitario</td>
      <td align='left'>Tipo</td>
      <td align='left'>Operador</td>
    </tr>
    <?php
		if ($Mostrar=='S')
		{
			if ($CmbGuias=='-1')
			{
				$Filtro='';
			}
			else
			{
				$Filtro= " and t1.tipo_guia='".$CmbGuias."'";
			}
			$FechaInicio=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
			$FechaTermino=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
			$Consulta="select t1.fecha_hora,t1.num_guia,t1.nro_patente,t1.toneladas,t2.nombre,t1.tipo_guia,t3.valor_subclase1 as operador,t1.valor_unitario ";
			$Consulta=$Consulta." from pac_web.guia_despacho t1 left join pac_web.clientes t2 on t1.rut_cliente = t2.rut_cliente";
			$Consulta=$Consulta." left join  proyecto_modernizacion.sub_clase t3 on t3.cod_clase=9002 and t1.rut_funcionario =t3.nombre_subclase ";
			$Consulta=$Consulta." where fecha_hora between '".$FechaInicio."' and '".$FechaTermino."'".$Filtro;
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				echo "<td align='center'>".$Fila["fecha_hora"]."</td>";
				echo "<td align='center'>".$Fila["num_guia"]."</td>";
				echo "<td align='center'>".$Fila[nro_patente]."</td>";
				echo "<td align='left'>".$Fila["nombre"]."</td>";
				echo "<td align='center'>".$Fila[toneladas]."</td>";
				echo "<td align='right'>".$Fila[valor_unitario]."</td>";
				if ($Fila["tipo_guia"]=='C')
				{
					echo "<td align='center'>Camion</td>";
				}
				else
				{
					echo "<td align='center'>Buque</td>";
				}
				echo "<td align='left'>".$Fila[operador]."</td>";
				echo "</tr>";
				$Total=$Total+$Fila[toneladas];
			}
			echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>Total</td>";
			echo "<td>".number_format($Total,'2',',','.')."</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";

		}				
	?>
  </table>		
</form>		
</body>
</html>
