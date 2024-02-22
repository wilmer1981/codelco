<?php 
  	include("../principal/conectar_sea_web.php");
	
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 51;
	if (!isset($TxtFechaFin))
		$TxtFechaFin = date("Y-m-d");
?>

<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga(f)
{
	vector = f.cmbproducto.value.split("-");
	chequeado = "S";

	f.action = "sea_ing_restos_trasp_sec_r01.php?recargapag=S&cmbproducto=" + f.cmbproducto.value + "&activar=" + chequeado;		
	f.submit();	
}

/**************/
function Excel(f)
{
	vector = f.cmbproducto.value.split("-");
	chequeado = "S";

	f.action = "sea_xls_ing_restos_trasp_sec_r01.php?recargapag=S&cmbproducto=" + f.cmbproducto.value + "&activar=" + chequeado;		
	f.submit();	
}
/**************/
function Imprimir()
{	
	window.print();
}
function Embarque()
{
	var f=document.frm1;
	var Valores="";
	
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="OptSelec" && f.elements[i].checked==true)
		{	
			Valores=Valores+f.elements[i+1].value+"//";
		}	
	}
	if (Valores!='')
	{
		Valores=Valores.substring(0,(Valores.length-2));
		if(confirm('Grupos ==> Preparacion para Embarque'))
		{
			//alert (Valores);
			f.action="sea_ing_restos_trasp_sec01_r01.php?Proceso=PE&Valores="+Valores;
			f.submit();	
		}	
	}
	else
		alert('Debe Seleccionar Grupo a Preparar');	
		
}
/**************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2"
}
</script>
</head>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>

  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
 		 <tr><td align="center" bgcolor="#FFFFFF">RESTOS A PREPARACION PARA EMBARQUE </td></tr>

    <tr>
	  <td width="762" height="316" align="center" valign="top"> 
        <table width="400" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td width="118">Tipo de Producto</td>
            <td><SELECT name="cmbproducto" style="width:220px" onChange="Recarga(this.form)">
              <option value="0-0">SELECCIONAR</option>
              <?php					
				$consulta = "SELECT DISTINCT * FROM proyecto_modernizacion.subproducto ";
				$consulta.= " WHERE cod_producto IN(19) and cod_subproducto in('1','2','3','4','8') ORDER BY cod_producto,cod_subproducto";
				$rs3 = mysqli_query($link, $consulta);
				while ($row3 = mysqli_fetch_array($rs3))
				{
					$prod = $row3["cod_producto"].'-'.$row3["cod_subproducto"];
											
					if ($prod == $cmbproducto)
						echo '<option value="'.$row3["cod_producto"].'-'.$row3["cod_subproducto"].'" SELECTed>'.$row3["cod_subproducto"].'-'.$row3["descripcion"].'</option>';
					else 
						echo '<option value="'.$row3["cod_producto"].'-'.$row3["cod_subproducto"].'">'.$row3["cod_subproducto"].'-'.$row3["descripcion"].'</option>';
				}
				?>
            </SELECT></td>
          </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		<?php
			$CmbAno=date("Y");
			$Prod = explode("-", $cmbproducto); 
			switch($Prod[1])
			{
				case "1":
					$SubProd=21;//PRODUCTO EMBARQUE HVL
					break;
				case "2":
					$SubProd=22;//PRODUCTO EMBARQUE TTE
					break;
				case "3":
					$SubProd=23;//PRODUCTO EMBARQUE SUR ANDES
					break;
				case "4":
					$SubProd=25;//PRODUCTO EMBARQUE VENTANAS
					break;
				case "8":
					$SubProd=26;//PRODUCTO EMBARQUE HM VENTANAS
					break;
			}
			?>
          <tr> 
          <tr align="center"> 
            <td colspan="2">
			  <input name="Btnembarque" type="button" value="A Embarque" onClick="JavaScritp:Embarque(this)" style="width:70px"> 
              <input name="btnimprimir2" type="button" style="width:70;" value="Imprimir" onClick="Imprimir()"> 
              <input name="BtnExcel" type="button" onClick="JavaScritp:Excel(this.form)" value="Excel" style="width:70px"> 
              <input name="btnsalir2" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="400" border="1" cellspacing="0" cellpadding="3">
          <tr align="center" class="ColorTabla01">
            <td width="30">Selec</td>
            <td width="54">Grupo</td>
			<td width="54">Hornada</td>
            <td width="90">Fecha</td>
            <td width="70">Unidades</td>
            <td width="80">Peso(Kg)</td>
          </tr>
        
		<?php
			if($recargapag=='S')
			{
				$FechaConsulta = substr($TxtFechaFin,0,8)."31";
				$FechaInicio = substr($TxtFechaFin,0,8)."01";
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
					//Hornadas del mes pasado		
					$consulta = "SELECT distinct t1.hornada, t1.cod_producto, t1.cod_subproducto";
					$consulta.= " FROM sea_web.stock t1 ";
					$consulta.= " WHERE t1.cod_producto = '".$arreglo[0]."' ";
					$consulta.= " AND t1.cod_subproducto = '".$arreglo[1]."' ";
					$consulta.= " AND t1.ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and t1.mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
					$consulta.= " ORDER BY t1.hornada";
					//echo "dos".$consulta."</br>";
					$array_hornadas = array();
					$rs = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($rs))
					{
						$consulta = "SELECT campo2, CASE WHEN LENGTH(campo2) = 1 THEN CONCAT('0',campo2) ELSE campo2 END AS grupo";
						$consulta.= " FROM sea_web.movimientos";
						$consulta.= " WHERE tipo_movimiento = 3 AND cod_producto = '".$row["cod_producto"]."'";
						$consulta.= " AND cod_subproducto = '".$row["cod_subproducto"]."'";
						$consulta.= " AND hornada = ".$row[hornada];
						$consulta.= " GROUP BY hornada";
						$rs1 = mysqli_query($link, $consulta);
						$row1 = mysqli_fetch_array($rs1);
						$clave = $row1["grupo"].'-'.$row["cod_producto"].'-'.$row["cod_subproducto"].'-'.substr($row[hornada],6,6);		
						$array_hornadas[$clave] = array($row[hornada], $row["cod_producto"], $row["cod_subproducto"], $row1[campo2]);
					}				
					//Hornadas del mes actual.
					$consulta = "SELECT distinct t1.hornada, t1.cod_producto, t1.cod_subproducto, t1.campo2,";
					$consulta.= " CASE WHEN LENGTH(campo2) = 1 THEN CONCAT('0',campo2) ELSE campo2 END AS grupo";
					$consulta.= " FROM sea_web.movimientos t1";
					$consulta.= " WHERE t1.cod_producto = '".$arreglo[0]."' ";
					$consulta.= " AND t1.cod_subproducto = '".$arreglo[1]."' ";
					$consulta.= " AND t1.fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."'";
					$consulta.= " AND t1.tipo_movimiento = 3";
					$rs = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($rs))
					{
						$clave = $row["grupo"].'-'.$row["cod_producto"].'-'.$row["cod_subproducto"].'-'.substr($row[hornada],6,6);
						$array_hornadas[$clave] = array($row[hornada], $row["cod_producto"], $row["cod_subproducto"], $row[campo2]);				
					}
					echo "<input type='hidden' name='TxtPesoTotGrupo'>";
					reset($array_hornadas);
					while (list($clave,$valor) = each($array_hornadas))
					{
						if ($valor[3] != "")
							$Grupo=$valor[3];
						else 
							$Grupo="";
						$hornadas = $valor[0];
						//Consulta la fecha de produccion de movimiento, para obtener la hornada restos de restos.
						$consulta = "SELECT DISTINCT fecha_movimiento,campo2,campo1 FROM sea_web.movimientos";
						$consulta.= " WHERE tipo_movimiento = 3 AND cod_producto = ".$valor[1]." AND cod_subproducto = ".$valor[2];
						$consulta.= " AND hornada = ".$valor[0];
						$rs = mysqli_query($link, $consulta);
						if ($row = mysqli_fetch_array($rs))
						{
							//Fecha de Produccion.
							$FechaMov=$row[fecha_movimiento];
							$consulta = "SELECT * FROM sea_web.movimientos";
							$consulta.= " WHERE tipo_movimiento = 3 AND campo1 = '".$row[campo1]."' AND campo2 = '".$row[campo2]."'";
							$consulta.= " AND fecha_movimiento = '".$row[fecha_movimiento]."' AND cod_subproducto = 30";
							$rs1 = mysqli_query($link, $consulta);
							if ($row1 = mysqli_fetch_array($rs1))
								$hornadas = $hornadas.",".$row1[hornada];
						}
						//STOCK INICIAL
						$peso_aux = 0;
						$unid_aux = 0;
						//Consulta mes anterior.
						$consulta = "SELECT ifnull(SUM(unid_fin),0) as unidades, ifnull(SUM(peso_fin),0) as peso ";
						$consulta.= " FROM sea_web.stock ";
						$consulta.= " WHERE cod_producto = '".$arreglo[0]."' ";
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";
						$rs1 = mysqli_query($link, $consulta);
						$row1 = mysqli_fetch_array($rs1);
						$unid_aux = $unid_aux + $row1["unidades"];						
						$peso_aux = $peso_aux + $row1["peso"];
						$TotalStockIniUnid = $TotalStockIniUnid + $unid_aux;
						$TotalStockIniPeso = $TotalStockIniPeso + $peso_aux;
						//PRODUCCION.
						$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
						$consulta.= " AND tipo_movimiento = '3'";
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{
							$TotalProdUnid = $TotalProdUnid + $row1["unidades"];
							$TotalProdPeso = $TotalProdPeso + $row1["peso"];
							$unid_aux = $unid_aux + $row1["unidades"];						
							$peso_aux = $peso_aux + $row1["peso"];
						}
						//TRASPASOS RAF.
						$consulta = "SELECT  ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
						$consulta.= " AND tipo_movimiento = '4'";
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{
							$TotalTrasUnid = $TotalTrasUnid + $row1["unidades"];
							$TotalTrasPeso = $TotalTrasPeso + $row1["peso"];
							$unid_aux = $unid_aux - $row1["unidades"];						
							$peso_aux = $peso_aux - $row1["peso"];
						}
						//TRASPASOS EMBARQUE.
						$consulta = "SELECT  ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
						$consulta.= " AND tipo_movimiento = '10'";
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{
							$TotalTrasUnid = $TotalTrasUnid + $row1["unidades"];
							$TotalTrasPeso = $TotalTrasPeso + $row1["peso"];
							$unid_aux = $unid_aux - $row1["unidades"];						
							$peso_aux = $peso_aux - $row1["peso"];
						}
						//RESTOS EN PREPARACION PARA EMBARQUE
						$consulta = "SELECT ifnull(unidades,0) as p_unidades, ifnull(peso,0) as p_peso FROM sea_web.restos_a_sec ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.=" AND grupo = '".$Grupo."'";
						$consulta.= " AND tipo_movimiento = '1'";
						$resp1= mysqli_query($link, $consulta);
						if ($FilaP=mysqli_fetch_array($resp1))
						{
							if ($unid_aux >0)
							{	
								if ($unid_aux >= $FilaP[p_unidades])
								{
									$unid_aux = $unid_aux - $FilaP[p_unidades];
									$peso_aux = $peso_aux - $FilaP[p_peso];
								}
								else
								{ 
									$actualiza="UPDATE sea_web.restos_a_sec set unidades = '".$unid_aux."', peso = '".$peso_aux."'";
									$actualiza.= " WHERE cod_producto = '".$arreglo[0]."' AND hornada IN (".$hornadas.")";
									$actualiza.= " AND grupo = '".$Grupo."' AND tipo_movimiento = '1'";
									mysqli_query($link, $actualiza);
									$unid_aux = 0;
									$peso_aux = 0;
								}
							}
							else
							{
									$elimina ="Delete from sea_web.restos_a_sec WHERE cod_producto = '".$arreglo[0]."' AND hornada IN (".$hornadas.")";									
									$elimina.= " AND fecha_movimiento = '".$Grupo."' AND tipo_movimiento = '1'";
									mysqli_query($link, $elimina);
							}
						}
						//OTROS DESTINOS
						$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
						$consulta.= " AND tipo_movimiento in(5,9)";
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{
							$TotalOtrosUnid = $TotalOtrosUnid + $row1["unidades"];
							$TotalOtrosPeso = $TotalOtrosPeso + $row1["peso"];
							$unid_aux = $unid_aux - $row1["unidades"];						
							$peso_aux = $peso_aux - $row1["peso"];
						}						
						/*******************/
						//AJUSTES (99)
						$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND fecha_movimiento BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
						$consulta.= " AND tipo_movimiento in (99)";
						//echo "doce".$consulta."</br>";
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{					
							$unid_ajuste = $unid_aux - $row1["unidades"];											
						}					
						$TotalStockFinUnid = $TotalStockFinUnid + $unid_aux;
						$TotalStockFinPeso = $TotalStockFinPeso + $peso_aux;					
						//STOCK EN PISO
						$consulta = "SELECT ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso FROM sea_web.stock_piso_raf ";
						$consulta.= " WHERE cod_producto = ".$arreglo[0];
						$consulta.=" AND cod_subproducto = ".$arreglo[1];
						$consulta.= " AND hornada IN (".$hornadas.")";
						$consulta.= " AND fecha BETWEEN '".$FechaInicio."' AND '".$FechaConsulta."' ";
						$rs1 = mysqli_query($link, $consulta);						
						if ($row1 = mysqli_fetch_array($rs1))
						{
							$TotalPisoUnid = $TotalPisoUnid + $row1["unidades"];
							$TotalPisoPeso = $TotalPisoPeso + $row1["peso"];
						}
						if ($unid_aux > 0)
						{
							$Datos=$Grupo."~".$FechaMov."~".$unid_aux."~".$peso_aux."~".$hornadas;
							echo '<tr>';
							echo '<td><input type="checkbox" name="OptSelec" onclick="AcumularPeso(this.form)" value="'.$peso_aux.'"><input type="hidden" name="TxtDatos" value="'.$Datos.'"></td>';
							echo '<td align="center">'.$Grupo.'</td>';
							echo '<td align="center">'.$hornadas.'</td>';
							echo '<td align="center">'.$FechaMov.'</td>';
							echo '<td align="right"><font color="blue">'.$unid_aux.'</font></td>';
							echo '<td align="right"><font color="blue">'.$peso_aux.'</font></td>';					
							echo '</tr>';
						}	
					}								
				}
			}	
		?>
		<tr>
		<td colspan="4">TOTAL</td>
		<td align="right"><font color="blue"><?php echo $TotalStockFinUnid; ?></font></td>
		<td align="right"><font color="blue"><?php echo $TotalStockFinPeso; ?></font></td>
		</tr>
		</table>
		<br>
        <br>
      <table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
			  <input name="Btnembarque2" type="button" value="A Embarque" onClick="JavaScritp:Embarque(this)" style="width:70px"> 
              <input name="btnimprimir2" type="button" style="width:70;" value="Imprimir" onClick="Imprimir()">
              <input name="BtnExcel2" type="button" onClick="JavaScritp:Excel(this.form)" value="Excel" style="width:70px">
              <input name="btnsalir2" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"></td>
        </tr>
      </table> </td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
