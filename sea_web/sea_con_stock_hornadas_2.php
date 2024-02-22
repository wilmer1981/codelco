<?php 
  	include("../principal/conectar_sea_web.php");
	
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 15;
?>

<html>
<head>
<title>Sistema de Anodos</title>
<link href="file://///200.1.6.139/proyecto/principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga(f)
{
	f.action = "sea_con_stock_hornadas.php?recargapag=S&cmbproducto=" + f.cmbproducto.value;		
	f.submit();	
}
/**************/
function Excel(f)
{
	f.action = "sea_xls_stock_hornadas.php?recargapag=S&cmbproducto=" + f.cmbproducto.value;		
	f.submit();	
}
/**************/
function Imprimir()
{	
	window.print();
}
/**************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2"
}
</script>
</head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>

  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
	  <td width="762" height="316" align="center" valign="top"> 
        <table width="753" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="118">Fecha de Consulta</td>
            <td><SELECT name="Dia" style="width:50px">
                <?php 
					for ($i=1;$i<=31;$i++)
					{
						if (isset($Dia))
						{
							if ($i == $Dia)
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == date("j"))
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
				  ?>
              </SELECT> <SELECT name="Mes" style="width:100px">
                <?php
					for ($i=1;$i<=12;$i++)
					{
						if (isset($Mes))
						{
							if ($i == $Mes)
								echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
						else
						{
							if ($i == date("n"))
								echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
					}
					?>
              </SELECT> <SELECT name="Ano" style="width:60px">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($Ano))
						{
							if ($i == $Ano)
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == date("Y"))
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}				
			?>
              </SELECT> </td>
            <td> 
              <?php 
					if (($RadioTipoFecha == "D") || (!isset($RadioTipoFecha)))
					{
						echo '<input name="RadioTipoFecha" type="radio" value="D" checked>';
					}
					else
					{
						echo '<input name="RadioTipoFecha" type="radio" value="D">';
					}
				?>
              Al Dia</td>
            <td> 
              <?php 
					if ($RadioTipoFecha == "A")
					{
						echo '<input name="RadioTipoFecha" type="radio" value="A" checked>';
					}
					else
					{
						echo '<input name="RadioTipoFecha" type="radio" value="A">';
					}
				?>
              Acumulado a la Fecha</td>
          </tr>
          <tr> 
            <td>Tipo de Producto</td>
            <td width="262"><SELECT name="cmbproducto" style="width:220px">
                <option value="0-0">SELECCIONAR</option>
                <?php					
					$consulta = "SELECT * FROM proyecto_modernizacion.subproducto ";
					$consulta.= " WHERE cod_producto in(17,19) ORDER BY cod_producto";
					$rs3 = mysqli_query($link, $consulta);
					while ($row3 = mysqli_fetch_array($rs3))
					{
						$prod = $row3["cod_producto"].'-'.$row3["cod_subproducto"];
						
						if ($prod == $cmbproducto)
							echo '<option value="'.$row3["cod_producto"].'-'.$row3["cod_subproducto"].'" SELECTed>'.$row3["descripcion"].'</option>';
						else 
							echo '<option value="'.$row3["cod_producto"].'-'.$row3["cod_subproducto"].'">'.$row3["descripcion"].'</option>';
					}					
				?>
              </SELECT> </td>
            <td width="139">
              <?php 
					if (($RadioTipoCons == "H") || (!isset($RadioTipoCons)))
					{
						echo '<input name="RadioTipoCons" type="radio" value="H" checked>';
					}
					else
					{
						echo '<input name="RadioTipoCons" type="radio" value="H">';
					}
				?>
              Por Hornada</td>
            <td width="207"> 
              <?php 
					if ($RadioTipoCons == "P")
					{
						echo '<input name="RadioTipoCons" type="radio" value="P" checked>';
					}
					else
					{
						echo '<input name="RadioTipoCons" type="radio" value="P">';
					}
				?>
              Por Producto</td>
          </tr>
          <tr align="center"> 
            <td colspan="4"> <input name="BtnCansultar" type="button" value="Consultar" onClick="JavaScritp:Recarga(this.form)" style="width:70px"> 
              <input name="btnimprimir2" type="button" style="width:70;" value="Imprimir" onClick="Imprimir()"> 
              <input name="BtnExcel" type="button" onClick="JavaScritp:Excel(this.form)" value="Excel" style="width:70px"> 
              <input name="btnsalir2" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"> 
            </td>
          </tr>
        </table>
        <br>
		
        <table width="753" border="1" cellspacing="0" cellpadding="3">
          <tr class="ColorTabla01"> 
		    <?php
				$arregloAux = explode("-", $cmbproducto); //0: Producto, 1: SubProducto.
				if (($RadioTipoCons == "H") || (!isset($RadioTipoCons)))
				{
            		echo "<td width='78' rowspan='2' align='center'>Hornadas</td>\n";
					echo "<td width='78' rowspan='2' align='center'>As</td>\n";
					echo "<td width='78' rowspan='2' align='center'>Sb</td>\n";
					//$arregloAux = explode("-", $cmbproducto); //0: Producto, 1: SubProducto.
					if ($arregloAux[0] == "19")					
						echo "<td width='78' rowspan='2' align='center'>Grupo</td>\n";
					else
						echo "<td width='78' rowspan='2' align='center'>Marca</td>\n";
				}
				else
				{
					echo "<td width='78' rowspan='2' align='left'>Tipo<br>Producto</td>\n";
				}
			?>
            <td colspan="2" align="center">Stock Inicial</td>
			<?php
				if ($arregloAux[0] == "17")
    		        echo '<td colspan="2" align="center">Recepcion</td>';
			?>
            <td colspan="2" align="center">Beneficio</td>
			<?php
				if ($arregloAux[0] == "19")
            		echo '<td colspan="2" align="center">Prod. Restos</td>';
			?>
            <td colspan="2" align="center">Traspaso</td>
            <td colspan="2" align="center">Otros Dest.</td>
            <td colspan="2" align="center">Stock Final</td>			
            <td colspan="2" align="center">Stock Piso</td>			
          </tr>
          <tr class="ColorTabla01"> 
            <td width="43" align="center">Unid.</td>
            <td width="53" align="center">Peso</td>
			<?php
				if ($arregloAux[0] == "17")
				{
    		        echo '<td width="43" align="center">Unid.</td>';
            		echo '<td width="44" align="center">Peso</td>';
				}
			?>
            <td width="46" align="center">Unid.</td>
            <td width="45" align="center">Peso</td>
			<?php
				if ($arregloAux[0] == "19")
				{
					echo '<td width="47" align="center">Unid.</td>';
					echo '<td width="53" align="center">Peso</td>';
				}
			?>
            
            <td width="40" align="center">Unid.</td>
            <td width="36" align="center">Peso</td>
            <td width="64" align="center">Unid.</td>
            <td width="55" align="center">Peso</td>
            <td width="55" align="center">Unid.</td>
            <td width="55" align="center">Peso</td>			
            <td width="55" align="center">Unid.</td>
            <td width="55" align="center">Peso</td>
          </tr>
<?php
function StockInicial($cod_producto,$cod_subproducto,$hornada,$fecha)
{
	$mes_act = substr($fecha,5,2);
	$ano_act = substr($fecha,0,4);
	$dia_act = substr($fecha,8,2);
	
	$mes_ant = $mes_act - 1;
	$ano_ant = $ano_act;
	$dia_ant = $dia_act - 1;
	
	if ($mes_ant == 0)
	{
		$mes_ant = 12;
		$ano_ant = $ano -1;
	}	
	
	if ($dia_ant == 0)
		$dia_ant = 1;
	
	//Consulta mes anterior.
	$consulta = "SELECT ifnull(SUM(unid_fin),0) as unidades, ifnull(SUM(peso_fin),0) as peso ";
	$consulta.= " FROM sea_web.stock ";
	$consulta.= " WHERE cod_producto = '".$cod_producto."' ";
	$consulta.= " AND cod_subproducto = '".$cod_subproducto."'";
	$consulta.= " AND hornada = '".$hornada."'";
	$consulta.= " AND ano = ".$ano_ant." AND mes = ".$mes_ant;
	//echo $consulta."<br>";
							
	$rs1 = mysqli_query($link, $consulta);
	$row1 = mysqli_fetch_array($rs1);
	
	$unidades = $row1["unidades"];
	$peso = $row1["peso"];

	// (+) Recepcion.		
	$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
	$consulta.= " WHERE cod_producto = ".$cod_producto." AND cod_subproducto = ".$cod_subproducto;
	$consulta.= " AND hornada = '".$hornada."' ";
	$consulta.= " AND fecha_movimiento between '".$ano_act."-".$mes_act."-01' and '".$ano_act."-".$mes_act."-".$dia_ant."' ";
	$consulta.= " AND tipo_movimiento = '1'";
	//echo $consulta."<br>";
	$rs2 = mysqli_query($link, $consulta);
	$row2 = mysqli_fetch_array($rs2);
		
	$unidades = $unidades + $row2["unidades"];
	$peso = $peso + $row2["peso"];
		
	// (-) Beneficio.
	$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
	$consulta.= " WHERE cod_producto = ".$cod_producto." AND cod_subproducto = ".$cod_subproducto;
	$consulta.= " AND hornada = '".$hornada."' ";		
	$consulta.= " AND fecha_movimiento between '".$ano_act."-".$mes_act."-01' and '".$ano_act."-".$mes_act."-".$dia_ant."' ";
	$consulta.= " AND tipo_movimiento = '2'";
	//echo $consulta."<br>";		
	$rs3 = mysqli_query($link, $consulta);
	$row3 = mysqli_fetch_array($rs3);
	
	$unidades = $unidades - $row3["unidades"];
	$peso = $peso - $row3["peso"];

	// (-) Traspaso.		
	$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
	$consulta.= " WHERE cod_producto = ".$cod_producto." AND cod_subproducto = ".$cod_subproducto;
	$consulta.= " AND hornada = '".$hornada."' ";
	$consulta.= " AND fecha_movimiento between '".$ano_act."-".$mes_act."-01' and '".$ano_act."-".$mes_act."-".$dia_ant."' ";
	$consulta.= " AND tipo_movimiento = '4'";
	//echo $consulta."<br>";	
	$rs4 = mysqli_query($link, $consulta);
	$row4 = mysqli_fetch_array($rs4);
		
	$unidades = $unidades - $row4["unidades"];
	$peso = $peso - $row4["peso"];		
						
	//(+) Produccion.
	$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
	$consulta.= " WHERE cod_producto = ".$cod_producto." AND cod_subproducto = ".$cod_subproducto;
	$consulta.= " AND hornada = '".$hornada."' ";
	$consulta.= " AND fecha_movimiento between '".$ano_act."-".$mes_act."-01' and '".$ano_act."-".$mes_act."-".$dia_ant."' ";
	$consulta.= " AND tipo_movimiento = '3'";
	//echo $consulta."<br>";	
	$rs5 = mysqli_query($link, $consulta);
	$row5 = mysqli_fetch_array($rs5);
		
	$unidades = $unidades + $row5["unidades"];
	$peso = $peso + $row5["peso"];	
								
    if ($unidades == 0)													
	   $peso = 0;
	   
	return $unidades."/".$peso;	
}
?>		  
		  
		  
		  
          <?php
	if (($RadioTipoCons == "H") || (!isset($RadioTipoCons)))
	{		  
		$FechaConsulta = $Ano."-".$Mes."-".$Dia;
		if ($RadioTipoFecha == "D")
			$FechaInicio = $FechaConsulta;
		else	$FechaInicio = $Ano."-".$Mes."-01";			
		$TotalStockIniUnid = 0;
        $TotalStockIniPeso = 0;
        $TotalRecepUnid = 0;
        $TotalRecepPeso = 0;
        $TotalBenefUnid = 0;
        $TotalBenefPeso = 0;
        $TotalProdUnid = 0;
        $TotalProdPeso = 0;
        $TotalTrasUnid = 0;
        $TotalTrasPeso = 0;
		$TotalOtrosUnid = 0;
        $TotalOtrosPeso = 0;
        $TotalStockFinUnid = 0;
        $TotalStockFinPeso = 0;
		$TotalPisoUnid = 0;
		$TotalPisoPeso = 0;			
		if ($recargapag == "S")
		{
			$arreglo = explode("-", $cmbproducto); //0: Producto, 1: SubProducto.					
		
			if ($arreglo[0] == "19")
			{
				$consulta = "SELECT distinct t1.hornada, t1.cod_producto, t1.cod_subproducto";
				$consulta.= " FROM sea_web.stock t1 ";
				$consulta.= " WHERE t1.cod_producto = '".$arreglo[0]."' ";
				$consulta.= " AND t1.cod_subproducto = '".$arreglo[1]."' ";
				$consulta.= " AND t1.ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and t1.mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";
				$consulta.= " AND t1.unid_fin > 0";				
				$consulta.= " ORDER BY SUBSTRING(t1.hornada,7,6)";
				//echo $consulta."<br>";				
			}
			else
			{
				//Horndas del mes pasado.
				$consulta = "SELECT STRAIGHT_JOIN distinct t1.hornada, t1.cod_producto, t1.cod_subproducto ";
				$consulta.= " FROM sea_web.stock t1 ";
//				$consulta.= " left join sea_web.relaciones t2 ";
//				$consulta.= " on t1.cod_subproducto = t2.cod_origen AND t1.hornada = t2.hornada_ventana";
				$consulta.= " WHERE t1.cod_producto = '".$arreglo[0]."' ";
				$consulta.= " AND t1.cod_subproducto = '".$arreglo[1]."' ";
				$consulta.= " AND t1.ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and t1.mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";
				$consulta.= " AND t1.unid_fin > 0";
				$consulta.= " ORDER BY SUBSTRING(t1.hornada,7,6)";
				//echo $consulta."<br>";
			}

			
			$array_hornadas = array();
			$rs = mysqli_query($link, $consulta);

			while ($row = mysqli_fetch_array($rs))
			{
				$clave = $row["cod_producto"].'-'.$row["cod_subproducto"].'-'.substr($row["hornada"],6,6);
				$array_hornadas[$clave] = array($row["hornada"], $row["cod_producto"], $row["cod_subproducto"]);							
			}
			
			
			if ($arreglo[0] == "19")
			{			
				//Consulta horndas recepcionadas hasta el dia anterior.
				$consulta = "SELECT distinct t1.hornada, t1.cod_producto, t1.cod_subproducto ";
				$consulta.= " FROM sea_web.movimientos t1";
				$consulta.= " WHERE t1.cod_producto = '".$arreglo[0]."' ";
				$consulta.= " AND t1.cod_subproducto = '".$arreglo[1]."' ";
				$consulta.= " AND t1.fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."'";
				$consulta.= " AND t1.tipo_movimiento = 3";
				//echo $consulta."<br>";
			}
			else
			{
				//Consulta horndas recepcionadas hasta el dia anterior.
				$consulta = "SELECT STRAIGHT_JOIN distinct t1.hornada, t1.cod_producto, t1.cod_subproducto ";
				$consulta.= " FROM sea_web.movimientos t1";
	//			$consulta.= " left join sea_web.relaciones t2 ";
	//			$consulta.= " on t1.cod_subproducto = t2.cod_origen AND t1.hornada = t2.hornada_ventana";
				$consulta.= " WHERE t1.cod_producto = '".$arreglo[0]."' ";
				$consulta.= " AND t1.cod_subproducto = '".$arreglo[1]."' ";
				$consulta.= " AND t1.fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."'";
				$consulta.= " AND t1.tipo_movimiento = 1";			
				//echo $consulta."<br>";				
			}			
			
			
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				$clave = $row["cod_producto"].'-'.$row["cod_subproducto"].'-'.substr($row["hornada"],6,6);
//				if (!key_exists($clave, $array_hornadas))
					$array_hornadas[$clave] = array($row["hornada"], $row["cod_producto"], $row["cod_subproducto"]);				
			}
										
			ksort($array_hornadas); //Orderna por la clave.
				
			reset($array_hornadas);
			while (list($clave,$valor) = each($array_hornadas))
			{
				echo '<tr>';
				echo '<td align="center">'.substr($valor[0],6,6).'</td>';
				//LEYES DE LA HORNADA
				$consulta = "SELECT distinct ifnull(cod_leyes,' ') as cod_leyes, valor from sea_web.leyes_por_hornada ";
				$consulta.= " where hornada = '".$valor[0]."' ";
				$consulta.= " and (cod_leyes = '08' or cod_leyes = '09') order by cod_leyes";
				$rs1 = mysqli_query($link, $consulta);
				//echo $consulta;
				$Arsenico = 0;
				$Antimonio = 0;
				while($row1 = mysqli_fetch_array($rs1))
				{
					if ($row1["cod_leyes"] == "08")
					{
						$Arsenico = $row1["valor"];
					}
					else
					{
						if ($row1["cod_leyes"] == "09")
						{
							$Antimonio = $row1["valor"];
						}
					}
				}
				echo '<td align="right">'.number_format($Arsenico,0,",",".").'</td>';
				echo '<td align="right">'.number_format($Antimonio,0,",",".").'</td>';
				//-----------------------------------------------------
				echo '<td align="center">';
				if (($arreglo[0]==17) && (($arreglo[1] == 4) || ($arreglo[1]==8)))
				{
				   $colores = "";
				   $num_hornada = substr($valor[0],6);					
				   $num1 = substr($num_hornada,0,1);
				   $num2 = substr($num_hornada,2,1);
				   $num3 = substr($num_hornada,3,1);
				   //echo $row["hornada"]."->".$num_hornada."=".$num1."".$num2."".$num3;
				   $consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2011 AND cod_subclase = '$num3'";				   
				   $rs1 = mysqli_query($link, $consulta);				   
				   if ($row1 = mysqli_fetch_array($rs1))
				   {
					   $colores = $row1["valor_subclase1"] .''. $colores;	
				   }
				   $consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2011 AND cod_subclase = '$num2'";
				   $rs1 = mysqli_query($link, $consulta);				   
				   if($row1 = mysqli_fetch_array($rs1))
				   {
					   $colores = $row1["valor_subclase1"] .''. $colores;	
				   }
				   $consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2011 AND cod_subclase = '$num1'";
				   $rs1 = mysqli_query($link, $consulta);
				   if($row1 = mysqli_fetch_array($rs1))
				   {
					   $colores = $row1["valor_subclase1"] .''. $colores;	
				   }
					echo $colores;
				}
				else
				{
					if ($arreglo[0] == 19)
					{
						$consulta = "SELECT * ";
						$consulta.= " from sea_web.movimientos ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0]." AND cod_subproducto = ".$arreglo[1];
						$consulta.= " AND hornada = '".$valor[0]."' ";
						//$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
						$consulta.= " AND tipo_movimiento = '3'";
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{
							if ((!is_null($row1[campo2])) && ($row1[campo2] != ""))
								echo $row1[campo2];							
							else echo "&nbsp;";	
						}
						else
						{
							echo "&nbsp;";
						}
					}
					else
					{
/*						if (($row[marca] <> '') && (!is_null($row[marca]))) 
							echo $row[marca];
						else echo "&nbsp;";
*/
						$consulta = "SELECT marca FROM sea_web.relaciones";
						$consulta = $consulta." WHERE cod_origen = ".$arreglo[1]." AND hornada_ventana = ".$valor[0];

						$rs1 = mysqli_query($link, $consulta);
						if ($row1 = mysqli_fetch_array($rs1))
							echo $row1[marca];
						else
							echo "&nbsp;";
					}
				}
				echo '</td>';				

				//STOCK INICIAL
				$peso_aux = 0;
				$unid_aux = 0;
				
				//Por Dia.
				if ($RadioTipoFecha == "D")
				{
				    $datos = StockInicial($valor[1],$valor[2],$valor[0],$FechaConsulta);
				    $vector = explode("/",$datos); //0: unidades, 1: peso.
				}
				else 
				{
					//Consulta mes anterior.
	                $consulta = "SELECT ifnull(SUM(unid_fin),0) as unidades, ifnull(SUM(peso_fin),0) as peso ";
	                $consulta.= " FROM sea_web.stock ";
	                $consulta.= " WHERE cod_producto = '".$arreglo[0]."' ";
	                $consulta.= " AND cod_subproducto = '".$arreglo[1]."'";
	                $consulta.= " AND hornada = '".$valor[0]."'";
     				$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";
					//echo $consulta."<br>";
					$rs1 = mysqli_query($link, $consulta);
					$row1 = mysqli_fetch_array($rs1);
					
					$vector[0] = $row1["unidades"];
					$vector[1] = $row1["peso"];
				}

				echo '<td align="right">'.$vector[0].'</td>';
				echo '<td align="right">'.$vector[1].'</td>';
				$TotalStockIniUnid = $TotalStockIniUnid + $vector[0];
				$TotalStockIniPeso = $TotalStockIniPeso + $vector[1];
				
				$unid_aux = $vector[0];				
				$peso_aux = $vector[1];

				
				//-------------
				if ($arreglo[0] == 17)
				{
					//RECEPCION
					$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = ".$arreglo[0]." AND cod_subproducto = ".$arreglo[1];
					$consulta.= " AND hornada = '".$valor[0]."' ";
					$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."'";
					$consulta.= " AND tipo_movimiento = '1'";
					//echo $consulta."<br>";
					$rs1 = mysqli_query($link, $consulta);						
					if ($row1 = mysqli_fetch_array($rs1))
					{
						echo '<td align="right">'.$row1["unidades"].'</td>';
						echo '<td align="right">'.$row1["peso"].'</td>';
						$TotalRecepUnid = $TotalRecepUnid + $row1["unidades"];
						$TotalRecepPeso = $TotalRecepPeso + $row1["peso"];

				    $unid_aux = $unid_aux + $row1["unidades"];
   				    $peso_aux = $peso_aux + $row1["peso"];
						
					}
					else
					{
						echo '<td align="right">&nbsp;</td>';
						echo '<td align="right">&nbsp;</td>';
					}
					//-----------------
				}
/*				else
				{
					echo '<td align="right">&nbsp;</td>';
					echo '<td align="right">&nbsp;</td>';
				}
*/				
				//BENEFICIO
				$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = ".$arreglo[0]." AND cod_subproducto = ".$arreglo[1];
				$consulta.= " AND hornada = '".$valor[0]."' ";
				$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento = '2'";
				//echo $consulta."<br>";				

				$rs1 = mysqli_query($link, $consulta);						
				if ($row1 = mysqli_fetch_array($rs1))
				{
					echo '<td align="right">'.$row1["unidades"].'</td>';
					echo '<td align="right">'.$row1["peso"].'</td>';
					$TotalBenefUnid = $TotalBenefUnid + $row1["unidades"];
					$TotalBenefPeso = $TotalBenefPeso + $row1["peso"];
					
				    $unid_aux = $unid_aux - $row1["unidades"];						
   				    $peso_aux = $peso_aux - $row1["peso"];
				}
				else
				{
					echo '<td align="right">&nbsp;</td>';
					echo '<td align="right">&nbsp;</td>';
				}
				//-----------------
				//PRODUCCION
				if ($arreglo[0] == "19")
				{
					$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = ".$arreglo[0]." AND cod_subproducto = ".$arreglo[1];
					$consulta.= " AND hornada = '".$valor[0]."' ";
					$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '3'";
					//echo $consulta."<br>";				
					$rs1 = mysqli_query($link, $consulta);						
					if ($row1 = mysqli_fetch_array($rs1))
					{
						echo '<td align="right">'.$row1["unidades"].'</td>';
						echo '<td align="right">'.$row1["peso"].'</td>';
						$TotalProdUnid = $TotalProdUnid + $row1["unidades"];
						$TotalProdPeso = $TotalProdPeso + $row1["peso"];
	
						$unid_aux = $unid_aux + $row1["unidades"];						
						$peso_aux = $peso_aux + $row1["peso"];
					}
					else
					{
						echo '<td align="right">&nbsp;</td>';
						echo '<td align="right">&nbsp;</td>';
					}
				}
				//-----------------
				//TRASPASO
				$consulta = "SELECT  ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = ".$arreglo[0]." AND cod_subproducto = ".$arreglo[1];
				$consulta.= " AND hornada = '".$valor[0]."' ";
				$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento = '4'";
				//echo $consulta."<br>";
				$rs1 = mysqli_query($link, $consulta);						
				if ($row1 = mysqli_fetch_array($rs1))
				{
					echo '<td align="right">'.$row1["unidades"].'</td>';
					echo '<td align="right">'.$row1["peso"].'</td>';
					$TotalTrasUnid = $TotalTrasUnid + $row1["unidades"];
					$TotalTrasPeso = $TotalTrasPeso + $row1["peso"];
					
				    $unid_aux = $unid_aux - $row1["unidades"];						
   				    $peso_aux = $peso_aux - $row1["peso"];
				}
				else
				{
					echo '<td align="right">&nbsp;</td>';
					echo '<td align="right">&nbsp;</td>';
				}
				//-----------------
				//OTROS DESTINOS
				$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = ".$arreglo[0]." AND cod_subproducto = ".$arreglo[1];
				$consulta.= " AND hornada = '".$valor[0]."' ";
				$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento in(5,9)";

				$rs1 = mysqli_query($link, $consulta);						
				if ($row1 = mysqli_fetch_array($rs1))
				{
					echo '<td align="right">'.$row1["unidades"].'</td>';
					echo '<td align="right">'.$row1["peso"].'</td>';
					$TotalOtrosUnid = $TotalOtrosUnid + $row1["unidades"];
					$TotalOtrosPeso = $TotalOtrosPeso + $row1["peso"];
					
				    $unid_aux = $unid_aux - $row1["unidades"];						
   				    $peso_aux = $peso_aux - $row1["peso"];					
				}
				else
				{
					echo '<td align="right">&nbsp;</td>';
					echo '<td align="right">&nbsp;</td>';
				}
								
				//-----------------				
				//STOCK FINAL A LA FECHA DE CONSULTA
				
				if ($unid_aux == 0)
				{
				 	echo '<td align="right">0</td>';
					echo '<td align="right">0</td>';
				}
				else 
				{
				 	echo '<td align="right">'.$unid_aux.'</td>';
					echo '<td align="right">'.$peso_aux.'</td>';					
				}
		        $TotalStockFinUnid = $TotalStockFinUnid + $unid_aux;
		        $TotalStockFinPeso = $TotalStockFinPeso + $peso_aux;				

				//-----------------
				//STOCK EN PISO
				$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.stock_piso_raf ";
				$consulta.= " WHERE cod_producto = ".$arreglo[0]." AND cod_subproducto = ".$arreglo[1];
				$consulta.= " AND hornada = '".$valor[0]."' ";
				$consulta.= " AND fecha BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
				//echo $consulta."<br>";

				$rs1 = mysqli_query($link, $consulta);						
				if ($row1 = mysqli_fetch_array($rs1))
				{
					echo '<td align="right">'.$row1["unidades"].'</td>';
					echo '<td align="right">'.$row1["peso"].'</td>';
					$TotalPisoUnid = $TotalPisoUnid + $row1["unidades"];
					$TotalPisoPeso = $TotalPisoPeso + $row1["peso"];
					
				    //$unid_aux = $unid_aux + $row1["unidades"];						
   				    //$peso_aux = $peso_aux + $row1["peso"];					
				}
				else
				{
					echo '<td align="right">&nbsp;</td>';
					echo '<td align="right">&nbsp;</td>';
				}
				//-------------
				echo '</tr>';
			}										 						
		}
	}
	else
	{
		$FechaConsulta = $Ano."-".$Mes."-".$Dia;
		if ($RadioTipoFecha == "D")
			$FechaInicio = $FechaConsulta;
		else	$FechaInicio = $Ano."-".$Mes."-01";
		//$FechaInicio = $Ano."-".$Mes."-01";		
		$TotalStockIniUnid = 0;
        $TotalStockIniPeso = 0;
        $TotalRecepUnid = 0;
        $TotalRecepPeso = 0;
        $TotalBenefUnid = 0;
        $TotalBenefPeso = 0;
        $TotalProdUnid = 0;
        $TotalProdPeso = 0;
        $TotalTrasUnid = 0;
        $TotalTrasPeso = 0;
		$TotalOtrosUnid = 0;
        $TotalOtrosPeso = 0;
        $TotalStockFinUnid = 0;
        $TotalStockFinPeso = 0;
		$SubTotalStockIniUnid = 0;
        $SubTotalStockIniPeso = 0;
        $SubTotalRecepUnid = 0;
        $SubTotalRecepPeso = 0;
        $SubTotalBenefUnid = 0;
        $SubTotalBenefPeso = 0;
        $SubTotalProdUnid = 0;
        $SubTotalProdPeso = 0;
        $SubTotalTrasUnid = 0;
        $SubTotalTrasPeso = 0;
		$SubTotalOtrosUnid = 0;
        $SubTotalOtrosPeso = 0;
		$SubTotalPisoUnid = 0;
        $SubTotalPisoPeso = 0;		
        $SubTotalStockFinUnid = 0;
        $SubTotalStockFinPeso = 0;			
		if ($recargapag == "S")
		{
			$arreglo = explode("-", $cmbproducto); //0: Producto, 1: SubProducto.
			$consulta = "SELECT STRAIGHT_JOIN distinct t1.cod_producto, t1.cod_subproducto, t2.abreviatura  ";
			$consulta.= " FROM sea_web.hornadas t1 inner join proyecto_modernizacion.subproducto t2 ";
			$consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
			//$consulta.= " WHERE t1.fecha between '".$FechaInicio."' AND '".$FechaConsulta."' ";

			
			if (($arreglo[0] != 0) && ($arreglo[1] != 0))
			{
				$consulta.= " AND t1.cod_subproducto = '".$arreglo[1]."' ";
				$consulta.= " AND t1.cod_producto = '".$arreglo[0]."'";
			}
			$consulta.= " ORDER BY t1.cod_producto, t1.cod_subproducto";
			//echo $consulta."<br>";
			
			$rs = mysqli_query($link, $consulta);
			$i = 1;				
			while ($row = mysqli_fetch_array($rs))
			{
				if (((($row["cod_producto"] == 17) && ($row["cod_subproducto"] == 8)) ||
				   (($row["cod_producto"] == 19) && ($row["cod_subproducto"] == 1))) && ($i != 1))
				{
					echo "<tr align='right' bgcolor='#CCCCCC'>\n";
					if (($RadioTipoCons == "H") || (!isset($RadioTipoCons)))
						echo "<td colspan='4'><strong>SUB-TOTAL</strong></td>";
					else echo "<td><strong>SUB-TOTAL</strong></td>";          
					echo "<td>".$SubTotalStockIniUnid."</td>\n";
					echo "<td>".$SubTotalStockIniPeso."</td>\n";
					if ($arreglo[0] == 17)
					{
						echo "<td>".$SubTotalRecepUnid."</td>\n";
						echo "<td>".$SubTotalRecepPeso."</td>\n";
					}
					echo "<td>".$SubTotalBenefUnid."</td>\n";
					echo "<td>".$SubTotalBenefPeso."</td>\n";
					if ($arreglo[0] == 19)
					{
						echo "<td>".$SubTotalProdUnid."</td>\n";
						echo "<td>".$SubTotalProdPeso."</td>\n";
					}
					echo "<td>".$SubTotalTrasUnid."</td>\n";
					echo "<td>".$SubTotalTrasPeso."</td>\n";
					echo "<td>".$SubTotalOtrosUnid."</td>\n";
					echo "<td>".$SubTotalOtrosPeso."</td>\n";
					echo "<td>".$SubTotalPisoUnid."</td>\n";
					echo "<td>".$SubTotalPisoPeso."</td>\n";					
					echo "<td>".$SubTotalStockFinUnid."</td>\n";
					echo "<td>".$SubTotalStockFinPeso."</td>\n";
					echo "</tr>\n";
					echo '<tr>';
					$SubTotalStockIniUnid = 0;
					$SubTotalStockIniPeso = 0;
					$SubTotalRecepUnid = 0;
					$SubTotalRecepPeso = 0;
					$SubTotalBenefUnid = 0;
					$SubTotalBenefPeso = 0;
					$SubTotalProdUnid = 0;
					$SubTotalProdPeso = 0;
					$SubTotalTrasUnid = 0;
					$SubTotalTrasPeso = 0;
					$SubTotalOtrosUnid = 0;
					$SubTotalOtrosPeso = 0;
					$SubTotalStockFinUnid = 0;
					$SubTotalStockFinPeso = 0;
					$SubTotalPisoUnid = 0;
					$SubTotalPisoPeso = 0;
				}
				$unidades_aux = 0;
				$peso_aux = 0;
				
				echo '<td align="left">';
				echo trim($row["abreviatura"]);
				echo '</td>';
				//STOCK INICIAL
				$consulta = "SELECT cod_producto, cod_subproducto, ifnull(sum(unid_fin),0) as unidades, ifnull(sum(peso_fin),0) as peso ";
				$consulta.= " FROM sea_web.stock ";
				$consulta.= " WHERE cod_producto = '".$row["cod_producto"]."' ";
				$consulta.= " AND cod_subproducto = '".$row["cod_subproducto"]."'";
				$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
				$consulta.= " AND unid_fin > 0";				
				$consulta.= " GROUP BY cod_producto, cod_subproducto";
				//echo $consulta;
				
				$rs1 = mysqli_query($link, $consulta);								
				if ($row1 = mysqli_fetch_array($rs1))
				{
					echo '<td align="right">'.$row1["unidades"].'</td>';
					echo '<td align="right">'.$row1["peso"].'</td>';
					$TotalStockIniUnid = $TotalStockIniUnid + $row1["unidades"];
					$TotalStockIniPeso = $TotalStockIniPeso + $row1["peso"];
					$SubTotalStockIniUnid = $SubTotalStockIniUnid + $row1["unidades"];
					$SubTotalStockIniPeso = $SubTotalStockIniPeso + $row1["peso"];								
							
					$unidades_aux = $row1["unidades"];
					$peso_aux = $row1["peso"];
				}
				else
				{
					echo '<td>&nbsp;</td>';
					echo '<td>&nbsp;</td>';
				}
				//-------------
				//RECEPCION
				if ($arreglo[0] == 17)
				{
					$consulta = "SELECT tipo_movimiento, ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = ".$row["cod_producto"]." AND cod_subproducto = ".$row["cod_subproducto"];
					$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '1'";
					$consulta.= " GROUP BY cod_producto, cod_subproducto";
					$rs1 = mysqli_query($link, $consulta);						
					if ($row1 = mysqli_fetch_array($rs1))
					{
						echo '<td align="right">'.$row1["unidades"].'</td>';
						echo '<td align="right">'.$row1["peso"].'</td>';
						$TotalRecepUnid = $TotalRecepUnid + $row1["unidades"];
						$TotalRecepPeso = $TotalRecepPeso + $row1["peso"];
						$SubTotalRecepUnid = $SubTotalRecepUnid + $row1["unidades"];
						$SubTotalRecepPeso = $SubTotalRecepPeso + $row1["peso"];				
									
						$unidades_aux = $unidades_aux + $row1["unidades"];
						$peso_aux = $peso_aux + $row1["peso"];					
					}
					else
					{
						echo '<td align="right">&nbsp;</td>';
						echo '<td align="right">&nbsp;</td>';
					}
				}
				//-----------------
				//BENEFICIO
				$consulta = "SELECT tipo_movimiento, ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = ".$row["cod_producto"]." AND cod_subproducto = ".$row["cod_subproducto"];
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento = '2'";
				$consulta.= " GROUP BY cod_producto, cod_subproducto";
				$rs1 = mysqli_query($link, $consulta);						
				if ($row1 = mysqli_fetch_array($rs1))
				{
					echo '<td align="right">'.$row1["unidades"].'</td>';
					echo '<td align="right">'.$row1["peso"].'</td>';
					$TotalBenefUnid = $TotalBenefUnid + $row1["unidades"];
					$TotalBenefPeso = $TotalBenefPeso + $row1["peso"];
					$SubTotalBenefUnid = $SubTotalBenefUnid + $row1["unidades"];
					$SubTotalBenefPeso = $SubTotalBenefPeso + $row1["peso"];						
					
					$unidades_aux = $unidades_aux - $row1["unidades"];
					$peso_aux = $peso_aux - $row1["peso"];					
				}
				else
				{
					echo '<td align="right">&nbsp;</td>';
					echo '<td align="right">&nbsp;</td>';
				}
				//-----------------
				//PRODUCCION
				if ($arreglo[0] == 19)
				{
					$consulta = "SELECT tipo_movimiento, ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = ".$row["cod_producto"]." AND cod_subproducto = ".$row["cod_subproducto"];
					$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '3'";
					$consulta.= " GROUP BY cod_producto, cod_subproducto";
					$rs1 = mysqli_query($link, $consulta);
					//echo $consulta."<br>";						
					if ($row1 = mysqli_fetch_array($rs1))
					{
						echo '<td align="right">'.$row1["unidades"].'</td>';
						echo '<td align="right">'.$row1["peso"].'</td>';
						$TotalProdUnid = $TotalProdUnid + $row1["unidades"];
						$TotalProdPeso = $TotalProdPeso + $row1["peso"];
						$SubTotalProdUnid = $SubTotalProdUnid + $row1["unidades"];
						$SubTotalProdPeso = $SubTotalProdPeso + $row1["peso"];
	
						$unidades_aux = $unidades_aux + $row1["unidades"];
						$peso_aux = $peso_aux + $row1["peso"];					
					}
					else
					{
						echo '<td align="right">&nbsp;</td>';
						echo '<td align="right">&nbsp;</td>';
					}
				}
				//-----------------
				//TRASPASO
				$consulta = "SELECT tipo_movimiento, ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = ".$row["cod_producto"]." AND cod_subproducto = ".$row["cod_subproducto"];
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento = '4'";
				$consulta.= " GROUP BY cod_producto, cod_subproducto";
				$rs1 = mysqli_query($link, $consulta);						
				if ($row1 = mysqli_fetch_array($rs1))
				{
					echo '<td align="right">'.$row1["unidades"].'</td>';
					echo '<td align="right">'.$row1["peso"].'</td>';
					$TotalTrasUnid = $TotalTrasUnid + $row1["unidades"];
					$TotalTrasPeso = $TotalTrasPeso + $row1["peso"];
					$SubTotalTrasUnid = $SubTotalTrasUnid + $row1["unidades"];
					$SubTotalTrasPeso = $SubTotalTrasPeso + $row1["peso"];
					
					$unidades_aux = $unidades_aux - $row1["unidades"];
					$peso_aux = $peso_aux - $row1["peso"];					
				}
				else
				{
					echo '<td align="right">&nbsp;</td>';
					echo '<td align="right">&nbsp;</td>';
				}
				//-----------------
				//OTROS DESTINOS
				$consulta = "SELECT tipo_movimiento, ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = '".$row["cod_producto"]."'" ;
				$consulta.= " AND cod_subproducto = '".$row["cod_subproducto"]."'";
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' AND '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento in(5,9)";
				$consulta.= " GROUP BY cod_producto, cod_subproducto";
				$rs1 = mysqli_query($link, $consulta);						
				if ($row1 = mysqli_fetch_array($rs1))
				{
					echo '<td align="right">'.$row1["unidades"].'</td>';
					echo '<td align="right">'.$row1["peso"].'</td>';
					$TotalOtrosUnid = $TotalOtrosUnid + $row1["unidades"];
					$TotalOtrosPeso = $TotalOtrosPeso + $row1["peso"];
					$SubTotalOtrosUnid = $SubTotalOtrosUnid + $row1["unidades"];
					$SubTotalOtrosPeso = $SubTotalOtrosPeso + $row1["peso"];
					
					$unidades_aux = $unidades_aux + $row1["unidades"];
					$peso_aux = $peso_aux + $row1["peso"];					
				}
				else
				{
					echo '<td align="right">&nbsp;</td>';
					echo '<td align="right">&nbsp;</td>';
				}
				
				//-----------------
				//STOCK FINAL A LA FECHA DE CONSULTA

				echo '<td align="right">'.$unidades_aux.'</td>';
				echo '<td align="right">'.$peso_aux.'</td>';
				$SubTotalStockFinPeso = $SubTotalStockFinPeso + $peso_aux;
				$SubTotalStockFinUnid = $SubTotalStockFinUnid + $unidades_aux;
				$TotalStockFinUnid = $TotalStockFinUnid + $unidades_aux;
				$TotalStockFinPeso = $TotalStockFinPeso + $peso_aux;
				//-------------
				//-----------------
				//STOCK PISO.
				$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.stock_piso_raf ";
				$consulta.= " WHERE cod_producto = '".$row["cod_producto"]."'" ;
				$consulta.= " AND cod_subproducto = '".$row["cod_subproducto"]."'";
				$consulta.= " AND fecha between '".$FechaInicio."' AND '".$FechaConsulta."' ";
				//echo $consulta."<br>";
				$rs1 = mysqli_query($link, $consulta);						
				if ($row1 = mysqli_fetch_array($rs1))
				{
					echo '<td align="right">'.$row1["unidades"].'</td>';
					echo '<td align="right">'.$row1["peso"].'</td>';
					$TotalPisoUnid = $TotalPisoUnid + $row1["unidades"];
					$TotalPisoPeso = $TotalPisoPeso + $row1["peso"];
					$SubTotalPisoUnid = $SubTotalPisoUnid + $row1["unidades"];
					$SubTotalPisoPeso = $SubTotalPisoPeso + $row1["peso"];
					
					//$unidades_aux = $unidades_aux + $row1["unidades"];
					//$peso_aux = $peso_aux + $row1["peso"];					
				}
				else
				{
					echo '<td align="right">&nbsp;</td>';
					echo '<td align="right">&nbsp;</td>';
				}
				//--------								
				echo "</tr>";
				$i++;								
			}
			echo "<tr align='right' bgcolor='#CCCCCC'>\n";
			if (($RadioTipoCons == "H") || (!isset($RadioTipoCons)))
				echo "<td colspan='4'><strong>SUB-TOTAL</strong></td>";
			else echo "<td><strong>SUB-TOTAL</strong></td>";          
			echo "<td>".$SubTotalStockIniUnid."</td>\n";
			echo "<td>".$SubTotalStockIniPeso."</td>\n";
			if ($arreglo[0] == 17)
			{
				echo "<td>".$SubTotalRecepUnid."</td>\n";
				echo "<td>".$SubTotalRecepPeso."</td>\n";
			}
			echo "<td>".$SubTotalBenefUnid."</td>\n";
			echo "<td>".$SubTotalBenefPeso."</td>\n";
			if ($arreglo[0] == 19)
			{
				echo "<td>".$SubTotalProdUnid."</td>\n";
				echo "<td>".$SubTotalProdPeso."</td>\n";
			}
			echo "<td>".$SubTotalTrasUnid."</td>\n";
			echo "<td>".$SubTotalTrasPeso."</td>\n";
			echo "<td>".$SubTotalOtrosUnid."</td>\n";
			echo "<td>".$SubTotalOtrosPeso."</td>\n";
			echo "<td>".$SubTotalStockFinUnid."</td>\n";
			echo "<td>".$SubTotalStockFinPeso."</td>\n";			
			echo "<td>".$SubTotalPisoUnid."</td>\n";
			echo "<td>".$SubTotalPisoPeso."</td>\n";			
			echo "</tr>\n";
			echo '<tr>';										 						
		}
	}				
?>
          <tr align="right"> 
		  <?php	
			if (($RadioTipoCons == "H") || (!isset($RadioTipoCons)))
				echo '<td colspan="4"><strong>TOTALES</strong></td>';
			else echo '<td><strong>TOTALES</strong></td>';
		?>	            
            <td><?php echo $TotalStockIniUnid; ?></td>
            <td><?php echo $TotalStockIniPeso; ?></td>
			<?php
				if ($arreglo[0] == "17")
				{
            		echo '<td>'.$TotalRecepUnid.'</td>';
            		echo '<td>'.$TotalRecepPeso.'</td>';
				}
			?>
            <td><?php echo $TotalBenefUnid; ?></td>
            <td><?php echo $TotalBenefPeso; ?></td>
			<?php
				if ($arreglo[0] == "19")
				{
            		echo '<td>'.$TotalProdUnid.'</td>';
            		echo '<td>'.$TotalProdPeso.'</td>';
				}
			?>
            <td><?php echo $TotalTrasUnid; ?></td>
            <td><?php echo $TotalTrasPeso; ?></td>
            <td><?php echo $TotalOtrosUnid; ?></td>
            <td><?php echo $TotalOtrosPeso; ?></td>
            <td><?php echo $TotalStockFinUnid; ?></td>
            <td><?php echo $TotalStockFinPeso; ?></td>			
            <td><?php echo $TotalPisoUnid; ?></td>
            <td><?php echo $TotalPisoPeso; ?></td>			
          </tr>
        </table>
        <br>

      <table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><input name="BtnCansultar2" type="button" value="Consultar" onClick="JavaScritp:Recarga(this.form)" style="width:70px">
              <input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="Imprimir()">
              <input name="BtnExcel2" type="button" onClick="JavaScritp:Excel(this.form)" value="Excel" style="width:70px">
              <input name="btnsalir" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"></td>
        </tr>
      </table> </td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>