<?php
	$CodigoDeSistema = 8;
	$CodigoDePantalla = 1;
	include("../principal/conectar_rec_web.php");
?>
<html>
<head>
<title>Sistema de Recepci&oacute;n</title>
<link href="../principal/estilos/css_rec_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "W":
			f.action = "rec_consulta_general_web.php";
			f.submit();
			break;
		case "E":
			f.action = "rec_consulta_general_excel.php";
			f.submit();
			break;
		case "R":
			f.action = "rec_consulta_general.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=8";
			f.submit(); 
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form action="" method="post" name="frmPrincipal">
<?php include("../principal/encabezado.php")?>
  <table width="771" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td width="757" height="316" valign="top"> 
        <table width="750" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">
          <tr class="ColorTabla01">
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="92">Tipo Consulta:</td>
            <td width="228"><SELECT name="TipoConsulta" style="width:210px" onChange="Proceso('R');">
                <?php
				if ($TipoConsulta == "R")
				{
					echo "<option value='R' SELECTed>Recepcion</option>\n";
					echo "<option value='D'>Despacho</option>\n";
					echo "<option value='O'>Otros Pesajes</option>\n";
				}
				if ($TipoConsulta == "D")
				{
					echo "<option value='R'>Recepcion</option>\n";
					echo "<option value='D' SELECTed>Despacho</option>\n";
					echo "<option value='O'>Otros Pesajes</option>\n";
				}
				if ($TipoConsulta == "O")
				{
					echo "<option value='R'>Recepcion</option>\n";
					echo "<option value='D'>Despacho</option>\n";
					echo "<option value='O' SELECTed>Otros Pesajes</option>\n";
				}
				if (!isset($TipoConsulta))
				{
					echo "<option value='R' SELECTed>Recepcion</option>\n";
					echo "<option value='D'>Despacho</option>\n";
					echo "<option value='O'>Otros Pesajes</option>\n";
				}
			?>
              </SELECT></td>
            <td width="103">&nbsp;</td>
            <td width="235">&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>Fecha Inicio:</td>
            <td><SELECT name="DiaIni" style="width:50px;">
                <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
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
              </SELECT> <SELECT name="MesIni" style="width:90px;">
                <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
              </SELECT> <SELECT name="AnoIni" style="width:60px;">
                <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
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
              </SELECT></td>
            <td>Fecha Termino:</td>
            <td><SELECT name="DiaFin" style="width:50px;">
                <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
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
              </SELECT> <SELECT name="MesFin" style="width:90px;">
                <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
              </SELECT> <SELECT name="AnoFin" style="width:60px;">
                <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
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
              </SELECT></td>
          </tr>
          <?php
		  if (($TipoConsulta == "R") || ($TipoConsulta == "D") || (!isset($TipoConsulta)))
		  {
			  echo "<tr> \n";
				echo "<td>Producto:</td>\n";
				echo "<td><SELECT name='Producto' style='width:300px' onChange=\"Proceso('R');\">\n";
				echo "<option value='S'>Todos los Productos</option>\n";
				$Consulta = "SELECT * from proyecto_modernizacion.subproducto where cod_producto='1' order by lpad(cod_subproducto,3,'0')";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Resp))
				{
					if ($Producto==$Fila["cod_subproducto"])
						echo "<option SELECTed value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($Fila["descripcion"])."</option>\n";
				}
				echo "</SELECT></td>\n";
				echo "<td>&nbsp;</td>\n";
				echo "<td>&nbsp;</td>\n";
			  	echo "</tr>\n";
			  	echo "<tr valign='middle'>\n";
				echo "<td height='18'>Rut Proveedor:</td>\n";
				echo "<td height='18' colspan='3'> <SELECT name='RutProveedor' style='width:350px' onChange=\"Proceso('R');\">\n";
				echo "<option value='S'>Todos los Proveedores</option>\n";
				$Consulta = "SELECT distinct t1.rutprv_a,  t2.nomprv_a from rec_web.prodprv t1 inner join rec_web.proved t2 ";
				$Consulta.= " on t1.rutprv_a=t2.rutprv_a";
				if ((isset($Producto)) && ($Producto != "S") && ($Producto != ""))
					$Consulta.= " where t1.codprd_a = '".$Producto."'";
				$Consulta.= " order by trim(t2.nomprv_a)";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($RutProveedor == str_pad($Row[rutprv_a],10,'0',STR_PAD_LEFT))
						echo "<option SELECTed value='".str_pad($Row[rutprv_a],10,'0',STR_PAD_LEFT)."'>".str_pad($Row[rutprv_a],10,'0',STR_PAD_LEFT)." - ".$Row[nomprv_a]."</option>\n";
					else
						echo "<option value='".str_pad($Row[rutprv_a],10,'0',STR_PAD_LEFT)."'>".str_pad($Row[rutprv_a],10,'0',STR_PAD_LEFT)." - ".$Row[nomprv_a]."</option>\n";
				}
				echo "</SELECT></td>\n";
			    echo "</tr>\n";
			}
			else
			{
				echo "<tr valign='middle'>\n";
				echo "<td height='18'>Producto:</td>\n";
				echo "<td height='18' colspan='3'> \n";
				if ((!isset($IdProducto)) || ($IdProducto == ""))
					$IdProducto = "*";
				if ((!isset($IdProveedor)) || ($IdProveedor == ""))
					$IdProveedor = "*";
				echo "<input type='text' name='IdProducto' value='".$IdProducto."' style='width:210px;'>&nbsp;* = Todos</td>\n";
			  	echo "</tr>\n";
			  	echo "<tr valign='middle'>\n";
				echo "<td height='18'>Proveedor:</td>\n";
				echo "<td height='18' colspan='3'> \n";
				echo "<input type='text' name='IdProveedor' value='".$IdProveedor."' style='width:210px;'>&nbsp;* = Todos</td>\n";
			  	echo "</tr>\n";
			}
		  ?>
          <tr valign="middle" class="Detalle02"> 
            <td height="18" colspan="4" align="center"> 
              <?php
				if (($OptAcumulado == "N") || (!isset($OptAcumulado)))
				{
					echo "<input checked type='radio' name='OptAcumulado' value='N'>&nbsp;Diario\n"; 
					echo "<input type='radio' name='OptAcumulado' value='S'>&nbsp;Acumulado\n";
				}
				else
				{
					echo "<input type='radio' name='OptAcumulado' value='N'>&nbsp;Diario\n";
					echo "<input checked type='radio' name='OptAcumulado' value='S'>&nbsp;Acumulado\n";
				}                            
			  ?>
            </td>
          </tr>          
        </table>
		<?php
			if (($TipoConsulta == "R") || (!isset($TipoConsulta)))
			{
				echo "<br>\n";
				echo "<table width='700' border='0' align='center' cellpadding='3' cellspacing='0' class='TablaDetalle'>\n";
				echo "<tr>\n";
				echo "<td><input type='checkbox' name='Lote' value='S'> Buscar Lote: \n";
				echo "<input name='TxtLote' type='text' id='TxtLote' value='".$TxtLote."' size='17' maxlength='12'></td>\n";
				echo "</tr>\n";
				echo "</table>\n";
			}
		?><br>
        <table width="700" border="0" align="center" cellpadding="3" cellspacing="3" class="TablaInterior">
          <tr>
            <td align="center">
<input type="button" name="btnWeb" value="Consulta Web" onClick="Proceso('W');" style="width:90px">
              <input type="button" name="btnExcel" value="Consulta Excel" onClick="Proceso('E');" style="width:90px">
              <input type="button" name="btnsalir" value="Salir" onClick="Proceso('S');" style="width:90px">
            </td>
          </tr>
        </table> 
      </td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
