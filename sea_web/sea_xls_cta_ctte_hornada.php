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
	include("../principal/conectar_sea_web.php");
	include("funciones.php");

	if(isset($_REQUEST["Ano"])) {
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano =  date("Y");
	}
	if(isset($_REQUEST["Hornada"])) {
		$Hornada = $_REQUEST["Hornada"];
	}else{
		$Hornada =  "";
	}
?>
<html>
<head>
<title>Sistema de Anodos</title>
</head>

<form name="frmPrincipal" action="" method="post">
  <div align="center"><br>
    <strong>Cuenta Cte. de la Hornada</strong><br>
  </div>
  <table width="736" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="31">A&ntilde;o: <?php echo $Ano?></td>
            <td width="90">Hornada: <?php echo $Hornada ?></td>
          </tr>
        </table>
  <br>
  <table width="900" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <!--<td width="20">&nbsp;</td>-->
      <td width="77">Fecha Prod.</td>
      <td width="189">Tipo Producto</td>
      <td width="89">Marca</td>
      <td width="73">Unid. Prod.</td>
      <td width="77">Peso Prod.</td>
      <td width="80">Peso Prom.</td>
      <td width="77">Saldo Unid.</td>
      <td width="73">Saldo Peso</td>
      <td width="90">Unid. a RAF</td>
    </tr>
    <?php
	if ((isset($Hornada)) && ($Hornada != ""))
	{
		$Consulta = "SELECT t1.hornada_ventana, t1.cod_producto, t1.cod_subproducto, t2.descripcion as nom_subproducto, t1.unidades, t1.peso_unidades, t3.marca ";
		$Consulta.= " from sea_web.hornadas t1 inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
		$Consulta.= " left join sea_web.relaciones t3 on t1.hornada_ventana = t3.hornada_ventana ";
		$Consulta.= " where substring(t1.hornada_ventana,1,4) = '".$Ano."'";
		$Consulta.= " and substring(t1.hornada_ventana,7) = '".$Hornada."'";
		$Consulta.= " order by t1.hornada_ventana,t1.cod_producto, t1.cod_subproducto";
		$Respuesta = mysqli_query($link, $Consulta);
		$i = 1;
		$CodProducto = 0;
		$CodSubproducto = 0;
		$IdHornada = 0;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";			
			$Consulta = "SELECT fecha_movimiento from sea_web.movimientos ";
			$Consulta.= " where cod_producto = '".$Row["cod_producto"]."'";
			$Consulta.= " and cod_subproducto = '".$Row["cod_subproducto"]."'";
			$Consulta.= " and hornada = '".$Row["hornada_ventana"]."'";
			if ($Row["cod_producto"] == 17)
				$Consulta.= " and tipo_movimiento = 1";	
			else	$Consulta.= " and tipo_movimiento = 3";	
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Row2 = mysqli_fetch_array($Resp2))
				echo "<td>".substr($Row2["fecha_movimiento"],8,2)."/".substr($Row2["fecha_movimiento"],5,2)."/".substr($Row2["fecha_movimiento"],0,4)."</td>\n";
			else
				echo "<td>&nbsp;</td>\n";
			echo "<td align='left'>".$Row["nom_subproducto"]."</td>\n";
			echo "<td align='left'><strong>";
			if (($Row["cod_producto"]==17) && (($Row["cod_subproducto"] == 4) || ($Row["cod_subproducto"]==8)))
			{
				$colores = "";
			   $num_hornada = substr($Row["hornada_ventana"],6);					
			   $num1 = substr($num_hornada,0,1);
			   $num2 = substr($num_hornada,2,1);
			   $num3 = substr($num_hornada,3,1);
			   
			   $consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2011 AND cod_subclase = '".$num3."'";				   
			   $rs1 = mysqli_query($link, $consulta);				   
			   if ($row1 = mysqli_fetch_array($rs1))
			   {
				   $colores = $row1["valor_subclase1"] .''. $colores;	
			   }
			   $consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2011 AND cod_subclase = '".$num2."'";
			   $rs1 = mysqli_query($link, $consulta);				   
			   if($row1 = mysqli_fetch_array($rs1))
			   {
				   $colores = $row1["valor_subclase1"] .''. $colores;	
			   }
			   $consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2011 AND cod_subclase = '".$num1."'";
			   $rs1 = mysqli_query($link, $consulta);
			   if($row1 = mysqli_fetch_array($rs1))
			   {
				   $colores = $row1["valor_subclase1"] .''. $colores;	
			   }
				echo $colores;
			}
			else
			{
				if (($row["marca"] <> '') && (!is_null($row["marca"]))) 
					echo $row["marca"];
				else echo "&nbsp;";
			}
			echo "</strong></td>\n";
			echo "<td align='right'>".$Row["unidades"]."</td>\n";
			echo "<td align='right'>".$Row["peso_unidades"]."</td>\n";
			$PesoProm = round(($Row["peso_unidades"] / $Row["unidades"]),0);
			echo "<td align='right'>".$PesoProm."</td>\n";
			echo "<td align='right'>";
			$SaldoUnidades = StockActual($Row["hornada_ventana"],$Row["cod_producto"],$Row["cod_subproducto"],$link);
			echo $SaldoUnidades;
			echo "</td>\n";
			$SaldoPesos = StockPesoActual($Row["hornada_ventana"],$Row["cod_producto"],$Row["cod_subproducto"],$link);
			echo "<td align='right'>".$SaldoPesos."</td>\n";
			echo "<td align='right'>";
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidades FROM  sea_web.movimientos";
			$consulta = $consulta." WHERE cod_producto = '".$Row["cod_producto"]."' AND cod_subproducto = '".$Row["cod_subproducto"]."' ";
			$consulta = $consulta." AND hornada = '".$Row["hornada_ventana"]."' AND tipo_movimiento = 4";
			$rs7 = mysqli_query($link, $consulta);
			$row7 = mysqli_fetch_array($rs7);
			echo $row7["unidades"];
			
			echo "</td>\n";
			echo "</tr>\n";
			$i++;
		}
	}
?>
  </table>
  <br>
  <table width="920" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td colspan="7">BENEFICIOS</td>
      <td colspan="2">RESTOS</td>
      <td colspan="2">SALDOS</td>
    </tr>
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="68">Fecha</td>
      <td width="204">Tipo Prod.</td>
      <td width="51">Grupo</td>
      <td width="52">La/Cu</td>
      <td width="49">Unid.</td>
      <td width="41">Peso</td>
      <td width="72">Peso Prom.</td>
      <td width="78">Fecha</td>
      <td width="70">Peso</td>
      <td width="59">Unid.</td>
      <td width="85">Peso</td>
    </tr>
<?php
	if ((isset($Hornada)) && ($Hornada != ""))
	{
		$Consulta = "SELECT t1.fecha_movimiento, t1.hornada, t1.cod_producto, t1.cod_subproducto, t2.descripcion as nom_subproducto, ";
		$Consulta.= " t1.campo1, t1.campo2, t1.unidades, t1.peso ";
		$Consulta.= " from sea_web.movimientos t1 inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
		$Consulta.= " where t1.tipo_movimiento = '2'";
		$Consulta.= " and substring(t1.hornada,1,4) = '".$Ano."'";
		$Consulta.= " and substring(t1.hornada,7) = '".$Hornada."'";
		$Consulta.= " order by  t1.hornada,t1.cod_producto, t1.cod_subproducto, t1.fecha_movimiento";
		$Respuesta = mysqli_query($link, $Consulta);
		$SaldoAnt = 0;
		$SaldoPesoAnt = 0;
		$CodProductoAnt = 0;
		$CodSubproductoAnt = 0;
		$HornadaAnt = 0;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			if (($CodProductoAnt != $Row["cod_producto"]) ||  ($CodSubproductoAnt != $Row["cod_subproducto"]) || ($HornadaAnt != $Row["hornada"]))
			{
				$SaldoAnt = 0;
				$SaldoPesoAnt = 0;
			}
			echo "<tr>\n";
			echo "<td align='center'>".substr($Row["fecha_movimiento"],8,2)."/".substr($Row["fecha_movimiento"],5,2)."/".substr($Row["fecha_movimiento"],0,4)."</td>\n";
			echo "<td>".$Row["nom_subproducto"]."</td>\n";
			echo "<td align='center'>".$Row["campo2"]."</td>\n";
			echo "<td align='center'>".$Row["campo1"]."</td>\n";
			echo "<td align='right'>".$Row["unidades"]."</td>\n";
			echo "<td align='right'>".$Row["peso"]."</td>\n";

			$Consulta = "SELECT unidades, peso_unidades from sea_web.hornadas ";
			$Consulta.= " where cod_producto = '".$Row["cod_producto"]."'";
			$Consulta.= " and cod_subproducto = '".$Row["cod_subproducto"]."'";
			$Consulta.= " and hornada_ventana = '".$Row["hornada"]."' ";
			$Resp2 = mysqli_query($link, $Consulta);
			$Row2 = mysqli_fetch_array($Resp2);
			
			
			echo "<td align='right'>".round($Row["peso"] / $Row["unidades"])."</td>\n";
			$Consulta = "SELECT cod_producto, cod_subproducto, hornada, fecha_movimiento, peso ";
			$Consulta.= " from sea_web.movimientos ";
			$Consulta.= " where tipo_movimiento = '3' ";
			$Consulta.= " and cod_subproducto = '".$Row["cod_subproducto"]."'";
			$Consulta.= " and numero_recarga = '".$Row["hornada"]."' ";
			$Consulta.= " and campo1 = '".$Row["campo1"]."' ";
			$Consulta.= " and campo2 = '".$Row["campo2"]."' ";
			$Consulta.= " and fecha_benef = '".$Row["fecha_movimiento"]."' ";
			$Resp3 = mysqli_query($link, $Consulta);
			if ($Row3 = mysqli_fetch_array($Resp3))
			{
				echo "<td align='center'>".substr($Row3["fecha_movimiento"],8,2)."/".substr($Row3["fecha_movimiento"],5,2)."/".substr($Row3["fecha_movimiento"],0,4)."</td>\n";
				echo "<td align='right'>".$Row3["peso"]."</td>\n";				
			}
			else
			{
				echo "<td>&nbsp;</td>\n";
				echo "<td>&nbsp;</td>\n";
			}
			if ($SaldoAnt == 0)
			{
				$SaldoUnid = $Row2["unidades"] - $Row["unidades"];
				$SaldoPeso= $Row2["peso_unidades"] - $Row["peso"];
			}
			else
			{
				$SaldoUnid = $SaldoAnt - $Row["unidades"];
				$SaldoPeso = $SaldoPesoAnt - $Row["peso"];
			}
			echo "<td align='right'>".$SaldoUnid."</td>\n";
			echo "<td align='right'>".$SaldoPeso."</td>\n";
			echo "</tr>\n";
			$CodProductoAnt = $Row["cod_producto"];
			$CodSubproductoAnt = $Row["cod_subproducto"];
			$HornadaAnt = $Row["hornada"];
			$SaldoAnt = $SaldoUnid;
			$SaldoPesoAnt = $SaldoPeso;
		}
	}
?>
  </table>
</form>
</html>