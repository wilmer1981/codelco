<?php 
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
<link href="../Principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{	
		case "W":
			f.action = "sea_con_cta_ctte_hornada.php";
			f.submit();
			break;
		case "E":
			f.action = "sea_xls_cta_ctte_hornada.php";
			f.submit();
			break;
		case "S":
			f.action= "../principal/sistemas_usuario.php?CodSistema=2";
			f.submit();
			break;
	}
}
</script></head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <div align="center"><br>
    <strong>Cuenta Cte. de la Hornada</strong><br>
  </div>
  <table width="736" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="31">A&ntilde;o:</td>
            <td width="90"><SELECT name="Ano" style="width:80px;">
			<?php
				for ($i=2002; $i<= date("Y"); $i++)
				{	
					if (isset($Ano))
					{
						if ($i == $Ano)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
              </SELECT></td>
            <td width="56">Hornada: </td>
            <td width="113"><input name="Hornada" type="text" id="Hornada" value="<?php  echo $Hornada; ?>" size="20" maxlength="12"></td>
            <td width="413"><input name="BtnWeb" type="button" id="BtnWeb" value="Consultar Web" onClick="Proceso('W');" style="width:100px;"> 
              <input name="BtnExcel" type="button" id="BtnExcel" value="Consultar Excel" onClick="Proceso('E');" style="width:100px;"> 
              <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" onClick="Proceso('S');" style="width:100px;"> 
            </td>
          </tr>
          <tr align="center"> 
            <td colspan="5">&nbsp; </td>
          </tr>
  </table>
  <br>
  <table width="950" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <!--<td width="20">&nbsp;</td>-->
      <td width="105">Fecha Prod.</td>
      <td width="185">Tipo Producto</td>
      <td width="89">Marca</td>
      <td width="73">Unid. Prod.</td>
      <td width="77">Peso Prod.</td>
      <td width="80">Peso Prom.</td>
      <td width="77">Saldo Unid.</td>
      <td width="73">Saldo Peso</td>
      <td width="66">Unid. a RAF</td>
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
		$Consulta.= " order by t1.hornada_ventana, t1.cod_producto, t1.cod_subproducto";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		$i = 1;
		$CodProducto = 0;
		$CodSubproducto = 0;
		$IdHornada = 0;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";			
			$Consulta = "SELECT fecha_movimiento,hora from sea_web.movimientos ";
			$Consulta.= " where cod_producto = '".$Row["cod_producto"]."'";
			$Consulta.= " and cod_subproducto = '".$Row["cod_subproducto"]."'";
			$Consulta.= " and hornada = '".$Row["hornada_ventana"]."'";
			if ($Row["cod_producto"] == 17)
				$Consulta.= " and tipo_movimiento = 1";
			else
				$Consulta.= " and tipo_movimiento = 3";	
			$Resp2 = mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			if ($Row2 = mysqli_fetch_array($Resp2))
				echo "<td>".substr($Row2["hora"],8,2)."/".substr($Row2["hora"],5,2)."/".substr($Row2["hora"],0,4)." ".substr($Row2["hora"],10,9)."</td>\n";

				//echo "<td>".substr($Row2["fecha_movimiento"],8,2)."/".substr($Row2["fecha_movimiento"],5,2)."/".substr($Row2["fecha_movimiento"],0,4)."</td>\n";
			else
				echo "<td>&nbsp;</td>\n";
			echo "<td align='left'>".$Row["nom_subproducto"]."</td>\n";
			echo "<td align='left'><strong>";
			if (($Row["cod_producto"]==17) && (($Row["cod_subproducto"] == 4) || ($Row["cod_subproducto"]==8) || ($Row["cod_subproducto"]==11)))
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
			//$Rechazos = StockRechazo($Row["hornada_ventana"],$Row["cod_producto"],$Row["cod_subproducto"]);
			//echo $Rechazos;
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidades FROM  sea_web.movimientos";
			$consulta = $consulta." WHERE cod_producto = '".$Row["cod_producto"]."' AND cod_subproducto = '".$Row["cod_subproducto"]."' ";
			$consulta = $consulta." AND hornada = '".$Row["hornada_ventana"]."' AND tipo_movimiento = 4";
			//echo $consulta."<br>";
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
  <table width="990" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td colspan="7">BENEFICIOS</td>
      <td colspan="2">RESTOS</td>
      <td colspan="2">SALDOS</td>
    </tr>
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="90">Fecha</td>
      <td width="204">Tipo Prod.</td>
      <td width="51">Grupo</td>
      <td width="52">La/Cu</td>
      <td width="49">Unid.</td>
      <td width="41">Peso</td>
      <td width="72">Peso Prom.</td>
      <td width="78">Fecha</td>
      <td width="50">Peso</td>
      <td width="59">Unid.</td>
      <td width="85">Peso</td>
    </tr>
<?php
	if ((isset($Hornada)) && ($Hornada != ""))
	{
		$Consulta = "SELECT t1.fecha_movimiento, t1.hornada, t1.cod_producto, t1.cod_subproducto, t2.descripcion as nom_subproducto, ";
		$Consulta.= " t1.campo1, t1.campo2, t1.unidades, t1.peso,t1.hora ";
		$Consulta.= " from sea_web.movimientos t1 inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
		$Consulta.= " where t1.tipo_movimiento = '2'";
		$Consulta.= " and substring(t1.hornada,1,4) = '".$Ano."'";
		$Consulta.= " and substring(t1.hornada,7) = '".$Hornada."'";
		$Consulta.= " order by t1.hornada,t1.cod_producto, t1.cod_subproducto, t1.fecha_movimiento";
		$Respuesta = mysqli_query($link, $Consulta);
		//echo $Consulta;
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
			//echo "<td align='center'>".substr($Row["fecha_movimiento"],8,2)."/".substr($Row["fecha_movimiento"],5,2)."/".substr($Row["fecha_movimiento"],0,4)."</td>\n";

			echo "<td align='center'>".substr($Row["hora"],8,2)."/".substr($Row["hora"],5,2)."/".substr($Row["hora"],0,4)." ".substr($Row["hora"],10,9)."</td>\n";

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
			
			
/*			
			{
				echo "<td align='right'>".($Row2[peso_prom] * $Row["unidades"])."</td>\n";
			}
			else
			{
				echo "<td>&nbsp;</td>\n";
			}
*/			
			echo "<td align='right'>".round($Row["peso"] / $Row["unidades"])."</td>\n";
			$Consulta = "SELECT cod_producto, cod_subproducto, hornada, fecha_movimiento, peso,hora ";
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
				//echo "<td align='center'>".substr($Row3["fecha_movimiento"],8,2)."/".substr($Row3["fecha_movimiento"],5,2)."/".substr($Row3["fecha_movimiento"],0,4)."</td>\n";

				echo "<td align='center'>".substr($Row3["hora"],8,2)."/".substr($Row3["hora"],5,2)."/".substr($Row3["hora"],0,4)." ".substr($Row3["hora"],10,9)."</td>\n";

				echo "<td align='right'>".$Row3["peso"]."</td>\n";				
/*				
				$Consulta = "SELECT round((peso_unidades/unidades),0) as peso_prom from sea_web.hornadas ";
				$Consulta.= " where cod_producto = '".$Row3["cod_producto"]."'";
				$Consulta.= " and cod_subproducto = '".$Row3["cod_subproducto"]."'";
				$Consulta.= " and hornada_ventana = '".$Row3["hornada"]."' ";
				//echo $Consulta;
				$Resp4 = mysqli_query($link, $Consulta);
				if ($Row4 = mysqli_fetch_array($Resp4))
					echo "<td align='right'>".($Row4[peso_prom] * $Row["unidades"])."</td>\n";
				else
					echo "<td align='right'>&nbsp;</td>\n";
*/					
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
</body>
</html>
