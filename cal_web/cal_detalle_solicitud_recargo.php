<?php
	include("../principal/conectar_principal.php");
   	$Consulta = "select recargo as recarg_a,fecha as fecha_a,peso_neto as pesont_a,ult_registro as u_regs_a ";
	$Consulta.= " from rec_web.recepciones ";
	$Consulta.= " where rut_prv ='".$RutPrv."' ";
	$Consulta.= " and lote='".$Muestra."' ";
	$Consulta.= " and cod_subproducto =".$SubProducto." and activo = 'N' order by recargo";
	$Respuesta = mysqli_query($link, $Consulta);
	$Cierre='N';
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		if ($Fila["recarg_a"]=='1')
		{
			$Fecha = $Fila["fecha_a"];
		}
		if ($Fila["u_regs_a"] == 'S')
		{
			$Cierre ='S';
			break;
		}
	}
	if ($Cierre == 'N')
	{
		$EstadoLote = "Abierto";
	}
	else
	{
		$EstadoLote = "Cerrado";
	}
	
?>
<html>
<head>
<title>Detalle Muestras</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body background="../principal/imagenes/fondo3.gif">
<form name="form1" method="post" action="">
  <table width="465" border="0" cellpadding="5" class="tablaprincipal">
    <tr> 
      <td width="456"><table width="448" border="0">
          <tr> 
            <td width="37" height="24"><div align="right"><strong>Lote:</strong></div></td>
            <td width="63">
              <?php echo $Muestra;?>
            </td>
            <td colspan="2"><div align="left"><strong>Estado Lote:</strong> 
                <?php echo $EstadoLote;?>
              </div></td>
            <td width="184"><div align="left"><strong>Fecha Ingreso:</strong> 
                <?php echo $Fecha;?>
              </div></td>
          </tr>
          <tr> 
            <td></td>
            <td>&nbsp;</td>
            <td width="112"></td>
            <td width="30">&nbsp;</td>
            <td></td>
          </tr>
        </table>
        <div style='position:absolute; overflow:auto; left: 75px; top:60px; width: 400px; height: 35px;'> 
          <table width="379" border="0">
            <tr> 
              <td width="85"><div align="left"><strong>#S.A</strong></div></td>
              <td width="57"><div align="right"><strong>Recargo</strong></div></td>
              <td width="90"><div align="center"><strong>Fecha Recep</strong>.</div></td>
              <td width="129"><strong>Peso Humedo(Kg)</strong></td>
            </tr>
          </table>
        </div>
        <div style='position:absolute; overflow:auto; left: 75px; top: 80px; width: 377px; height: 120px;'> 
          <table width="280" border="1">
            <?php
    	$Consulta = "select t1.nro_solicitud,t1.recargo,t1.fecha_hora,t2.peso_neto as pesont_a from cal_web.solicitud_analisis t1 left join sipa_web.recepciones t2 on t1.id_muestra = t2.lote "; 
		$Consulta = $Consulta." and t1.cod_subproducto = t2.cod_subproducto and t1.recargo = t2.recargo where t1.id_muestra=".$Muestra." order by t1.recargo";
		$Respuesta = mysqli_query($link, $Consulta);
		$TotRecargo=0;
		$TotPesoHum=0;
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			echo "<tr>";
			if ((!is_null($Fila["nro_solicitud"])) or ($Fila["nro_solicitud"]!=""))
			{
				echo "<td width:100><input type ='TextBox' readonly style='width:100' value =".$Fila["nro_solicitud"]."-".$Fila["recargo"]."></td>";
			}
			else
			{
				echo "<td width:100><input type ='TextBox' readonly style='width:100' value = 'NoGenerada'></td>";			
			}	
        	echo "<td width:40><input type ='TextBox' readonly style='width:40' value =".$Fila["recargo"]."></td>";
      		echo "<td width:80><input type ='TextBox' readonly style='width:80' value =".$Fila["fecha_hora"]."></td>";
      		echo "<td width:80><input type ='TextBox' readonly style='width:80' value =".$Fila["pesont_a"]."></td>";
			echo "</tr>";
			$TotRecargo=$TotRecargo + 1;
			$TotPesoHum=$TotPesoHum + $Fila["pesont_a"];
		}
	?>
          </table>
        </div>
        <br> <br> <br> <br> <br> <br> <br> <br><br><br>
        <br> <br> <table width="448" border="0">
          <tr> 
            <td width="123"><div align="right"><strong>Total Recargo:</strong></div></td>
            <td width="90">
              <?php echo $TotRecargo;?>
            </td>
            <td width="112"><div align="right"><strong>Peso Humedo:</strong></div></td>
            <td width="234">
              <?php echo $TotPesoHum;?>
            </td>
          </tr>
        </table>
        <br> <table width="448" border="0">
          <tr> 
            <td width="469"><div align="center"> 
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style ="width:60" onClick="javascript:window.close();">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
