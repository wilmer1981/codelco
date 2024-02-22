<?php
	include("../principal/conectar_rec_web.php");
   	$Consulta = "select recargo,fecha,peso_neto,ult_registro,sa_asignada from sipa_web.recepciones where lote='".$Muestra."' and rut_prv ='".$RutPrv."' and cod_subproducto=".$SubProducto." order by recargo";
	$Respuesta = mysqli_query($link, $Consulta);
	$Cierre='N';
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		if ($Fila["recargo"]=='1')
		{
			$Fecha = $Fila["fecha"];
		}
		if ($Fila["ult_registro"] == 'S')
		{
			$Cierre ='S';
			//break;
		}
		if ((!is_null($Fila["sa_asignada"])) || ($Fila["sa_asignada"]<>''))
		{
			$SA = $Fila["sa_asignada"];
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
<script language="JavaScript">
function Proceso(Lote,Producto,SubProducto)
{
	var Frm=document.FrmDetalleLotes;
	var Muestras="";
	if (ExistenElementosSolicitudesCheck())
	{
		for (i=1;i<Frm.CheckMuestra.length;i++)
		{
			if (Frm.CheckMuestra[i].checked==true)
			{
				Muestras= Muestras + Lote + "~~" + Frm.TxtRecargo[i].value + Frm.TxtFin[i].value + "//";
			}
		}
		Frm.action = "cal_solicitud_automatica01.php?proceso=N&Muestras_Check=" + Muestras +"&EsBusqueda=S&Asignado=S&CmbProductos="+Producto+"&CmbSubProducto="+SubProducto+"&Buscar=S&BuscarPrv=S&ConHum=S";
		Frm.submit();			

	}
	else
	{
		alert("No hay Elementos Seleccionados");
	}			 
}
function ExistenElementosSolicitudesCheck()
{
	var Frm=document.FrmDetalleLotes;
	var EncontroCheck=false;
	try 
	{
		Frm.CheckMuestra[0];
		for (i=1;i<Frm.CheckMuestra.length;i++)
		{
			if (Frm.CheckMuestra[i].checked==true)
			{
				EncontroCheck=true;
				break;
			}
		}
		if (EncontroCheck==true)
		{
			return(true);
		}
		else
		{
			return(false);					
		}
	}	
	catch (e)
	 {
		 return(false);
	 } 
}
</script>
<title>Detalle Lotes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmDetalleLotes" method="post" action="">
  <table width="463" border="0" cellpadding="5" class="TablaPrincipal">
    <tr> 
      <td width="449"><table width="448" border="0">
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
            <td align="right"><strong>S.A:</strong></td>
            <td>
            <?php 
			  	if ($SA=='')
				{
					echo "Ninguna";				
				}
				else
				{
					echo $SA;
				}	
			?>
            </td>
            <td width="112"> </td>
            <td width="30">&nbsp;</td>
            <td></td>
          </tr>
        </table>
        <table width="407" border="0">
          <tr> 
            <td width="148"><div align="right"><strong>Recargo</strong></div></td>
            <td width="132"><div align="center"><strong>Fecha Recep</strong>.</div></td>
            <td width="113"><strong>Peso Humedo(Kg)</strong></td>
          </tr>
        </table>
        <div style='position:absolute; overflow:auto; left: 90px; top: 90px; width: 340px; height: 120px;'> 
          <table width="240" border="1">
            <?php
    	$Consulta = "select sa_asignada,recargo,fecha,peso_neto,ult_registro,if(length(recargo)=1,concat('0',recargo),recargo) as recargo_ordenado from sipa_web.recepciones where (lote='".$Muestra."') and (rut_prv ='".$RutPrv."') and (cod_subproducto=".$SubProducto.") order by recargo_ordenado";
		$Respuesta = mysqli_query($link, $Consulta);
		$TotRecargo=0;
		$TotPesoHum=0;
		echo "<input type='hidden' name ='CheckMuestra'><input type='hidden' name ='TxtRecargo'><input type='hidden' name ='TxtFin'>";
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			echo "<tr>";
			if ((!is_null($Fila["sa_asignada"]))||($Fila["sa_asignada"]!=''))
			{
				echo "<td><input type ='checkbox' name='CheckMuestra' disabled></td>";
				echo "<td width:60><input type ='TextBox' name ='TxtRecargo' style='background:yellow' readonly style='width:60' value =".$Fila["recargo"]."></td>";
				echo "<td width:120><input type ='TextBox'  style='background:yellow' readonly style='width:120' value =".$Fila["fecha"]."></td>";
				echo "<td width:90><input type ='TextBox' style='background:yellow' readonly style='width:90' value =".$Fila["peso_neto"]."><input type='hidden' name ='TxtFin' value='".$Fila["ult_registro"]."'></td>";
				echo "</tr>";
			}	
			else
			{
				if($SA=='')
				{
					echo "<td><input type ='checkbox' name='CheckMuestra' disabled></td>";
				}	
				else
				{
					echo "<td><input type ='checkbox' name='CheckMuestra'></td>";
				}
				echo "<td width:60><input type ='TextBox' name ='TxtRecargo' readonly style='width:60' value ='".$Fila["recargo"]."'></td>";
				echo "<td width:120><input type ='TextBox' readonly style='width:120' value ='".$Fila["fecha"]."'></td>";
				echo "<td width:90><input type ='TextBox' readonly style='width:90' value ='".$Fila["peso_neto"]."'><input type='hidden' name ='TxtFin' value='".$Fila["ult_registro"]."'></td>";
				echo "</tr>";
			}
			$TotRecargo=$TotRecargo + 1;
			$TotPesoHum=$TotPesoHum + $Fila["pesont_a"];
		}
	?>
          </table>
        </div>
        <br> <br> <br> <br> <br> <br>
        <br> <br> <br><br><br> <table width="448" border="0">
          <tr> 
            <td width="107"><div align="right"><strong>Total Recargo:</strong></div></td>
            <td width="71">
              <?php echo $TotRecargo;?>
            </td>
            <td width="99"><div align="right"><strong>Peso Humedo:</strong></div></td>
            <td width="161">
              <?php echo $TotPesoHum;?>
            </td>
          </tr>
        </table>
        <table width="448" border="0">
          <tr> 
            <?php
				
			
                if ($SA=='')
				{	
					echo "<td align='center'><input name='BtnSalir' type='button' value='Salir' style ='width:60' onClick='javascript:window.close();'></td>";
				}
				else
				{
					echo "<td width='224'><div align='right'>";
					echo "<input name='BtnAsignar' type='button' value='Asignar' style ='width:60' onClick=Proceso('$Muestra','$Producto','$SubProducto');>";
					echo "</div></td>";
					echo "<td width='225'><input name='BtnSalir' type='button' value='Salir' style ='width:60' onClick='javascript:window.close();'></td>";
				}
			?>
          </tr>
        </table></td>
    </tr>
  </table>
<?php include ("../principal/cerrar_rec_web.php");?>    
</form>
</body>
</html>
