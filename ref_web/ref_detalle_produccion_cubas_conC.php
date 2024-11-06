<?php
	include("../principal/conectar_principal.php"); 
	
	$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$grupo   = isset($_REQUEST["grupo"])?$_REQUEST["grupo"]:"";
		
	$AnoIni=substr($fecha,0,4);
	$MesIni=substr($fecha,5,2);
	$DiaIni=substr($fecha,8,2);
	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $FechaInicio;
	$FechaInicio1 =date("Y-m-d", mktime(0,0,0,$MesIni,$DiaIni,$AnoIni));	

	$Fechainiturno =$FechaInicio1;
	$Fechafturno = date("Y-m-d", mktime(0,0,0,intval(substr($Fechainiturno, 5, 2)) ,intval(substr($Fechainiturno, 8, 2)) + 1,intval(substr($Fechainiturno, 0, 4))));
	//echo "F1".$Fechainiturno."-".$Fechafturno;
?>
<html>
<head>
<title>Sistema de Informacion Refineria Electrolitica</title>
<link rel="stylesheet" href="../Principal/estilos/css_principal.css" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="sec_con_inf_pesaje_prod.php";
			f.submit();
			break;
		case "E":
			f.action ="sec_con_inf_pesaje_prod_excel.php";
			f.submit();
			break;
		case "S":
			f.action ="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
</script>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><strong>DETALLE PESAJES DE PRODUCCION CATODO COMERCIAL</strong></td>
    </tr>
  </table>
  <br>
  <br>
<?php
	$FechaAux = $FechaInicio;	
	
		$Consulta = "select ifnull(count(*),0) as total_reg from sec_web.produccion_catodo ";
		$Consulta.= " where fecha_produccion = '".$FechaAux."'";
		$Respuesta = mysqli_query($link,$Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Fila["total_reg"] <> 0)
			{
				echo "<br><table width='500' border='0' align='center' cellpadding='2' cellspacing='1' class='TablaInterior'>\n";
				echo "<tr> \n";
				echo "<td align='center'><strong>DIA: ".substr($FechaAux,8,2)."/".substr($FechaAux,5,2)."/".substr($FechaAux,0,4)."</strong></td>\n";
				echo "</tr>\n";
				echo "</table>\n";
			}
		}							
	
			$Consulta = "select * from sec_web.produccion_catodo t1 ";
			$Consulta.= " where cod_producto = '18' ";
			$Consulta.= " and cod_subproducto = '1' ";
			$Consulta.= " and CONCAT(t1.fecha_produccion,' ',t1.hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";
			$Consulta.= " and cod_grupo='".$grupo."'";
			$Respuesta2 = mysqli_query($link,$Consulta);
			$SubTotalPeso = 0;
			$TotalDia =0;
			$CodProductoAnt = 0;
			$CodSubProductoAnt = 0;
			while ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				if (($Fila2["cod_producto"] != $CodProductoAnt) || ($Fila2["cod_subproducto"] != $CodSubProductoAnt))				
				{
					echo "</table>\n";
					echo "<table width='500' border='1' align='center' cellpadding='0' cellspacing='0' class='TablaDetalle'>\n";
					echo "<tr align='center' class='ColorTabla01'> \n";
					echo "<td width='76'>GRUPO </td>\n";
					echo "<td width='330' colspan='5'><strong>Detalle Produccion Catodos Comercial</strong></td>\n";
					echo "</tr> \n";					
					echo "<tr align='center' class='ColorTabla01'> \n";		
					echo "<td width='57'><strong>".$grupo."</strong></td>\n";
					echo "<td width='76'>MUESTRA</td>\n";
					echo "<td width='62'>LADO</td>\n";
					echo "<td width='65'>CUBA</td>\n";
					echo "<td width='87'>PESO</td>\n";
					echo "</tr>\n";
				}
				echo "<tr>\n";
				echo "<td type='hidden' align='center'>-----></td>\n";
				echo "<td align='center'>".strtoupper($Fila2["cod_muestra"])."</td>\n";
				echo "<td align='center'>";
				if ($Fila2["cod_lado"] != "")
					echo strtoupper($Fila2["cod_lado"]);
				else
					echo "&nbsp;";
				echo "</td>\n";
				echo "<td align='center'>".$Fila2["cod_cuba"]."</td>\n";
				echo "<td align='right'>".number_format($Fila2["peso_produccion"],0,",",".")."</td>\n";
				echo "</tr>\n";
				$SubTotalPeso = $SubTotalPeso + $Fila2["peso_produccion"];
				$TotalDia = $TotalDia + $Fila2["peso_produccion"];
				$CodProductoAnt = $Fila2["cod_producto"];
				$CodSubProductoAnt = $Fila2["cod_subproducto"];				
			}
			if ($SubTotalPeso != 0)
			{
				echo "<tr>\n";				
				echo "<td align='right' colspan='4'><strong>SUB TOTAL PRODUCTO</strong></td>\n";
				echo "<td align='right'><strong>".number_format($SubTotalPeso,0,",",".")."</strong></td>\n";
				echo "</tr>\n<br>";						
			}			
			
		if ($TotalDia != 0)
		{
			echo "<tr>\n";				
			echo "<td align='right' colspan='4'><strong>TOTAL DIA :".substr($FechaAux,5,2)."/".substr($FechaAux,8,2)."/".substr($FechaAux,0,4)."</strong></td>\n";
			echo "<td align='right'><strong>".number_format($TotalDia,0,",",".")."</strong></td>\n";
			echo "</tr>\n";						
		}
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),(intval(substr($FechaAux,8,2)) + 1),substr($FechaAux,0,4)));
		echo "</table>\n";
	
?>
</form>
</body>
</html>
