<?php
	$CodigoDeSistema = 24;
	$CodigoDePantalla = 1;
	include("../principal/conectar_principal.php");
	include("funciones_res.php");
	if(!isset($TxtFechaIni))
		$TxtFechaIni=date('Y-m-d');
	if(!isset($TxtFechaFin))
		$TxtFechaFin=date('Y-m-d');
?>
<html>
<head>
<title>Sistema de Recepci&oacute;n</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "W":
			//f.action = "rec_consulta_general_web.php";
			f.action = "rec_consulta_general_web_ant.php?Destino=W";
			f.submit();
			break;
		case "E":
			f.action = "rec_consulta_general_web_ant.php?Destino=E";
			f.submit();
			break;
		case "R":
			f.action = "rec_consulta_general.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=8";
			//f.action="../principal/sistemas_usuario.php?CodSistema=24";
			f.submit(); 
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=160 scrolling=no height=185></IFRAME></DIV>
<form action="" method="post" name="frmPrincipal">
<?php include("../principal/encabezado.php")?>
  <table width="771" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td width="757" height="316" valign="top"> 
        <table width="750" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
          <tr class="ColorTabla01">
            <td colspan="4" align="center">CONSULTA GENERAL DE RECEPCIONES</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="92">Tipo Consulta:</td>
            <td width="228"><SELECT name="TipoConsulta" style="width:210px" onChange="Proceso('R');">
                <?php
				if ($TipoConsulta == "R")
				{
					echo "<option value='R' SELECTed>Recepcion</option>\n";
					echo "<option value='D'>Despacho</option>\n";
//					echo "<option value='O'>Otros Pesajes</option>\n";
				}
				if ($TipoConsulta == "D")
				{
					echo "<option value='R'>Recepcion</option>\n";
					echo "<option value='D' SELECTed>Despacho</option>\n";
//					echo "<option value='O'>Otros Pesajes</option>\n";
				}
				if ($TipoConsulta == "O")
				{
					echo "<option value='R'>Recepcion</option>\n";
					echo "<option value='D'>Despacho</option>\n";
//					echo "<option value='O' SELECTed>Otros Pesajes</option>\n";
				}
				if (!isset($TipoConsulta))
				{
					echo "<option value='R' SELECTed>Recepcion</option>\n";
					echo "<option value='D'>Despacho</option>\n";
//					echo "<option value='O'>Otros Pesajes</option>\n";
				}
			?>
            </SELECT></td>
            <td width="103">&nbsp;</td>
            <td width="235">&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>Fecha Inicio:</td>
            <td><input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> </td>
            <td>Fecha Termino:</td>
            <td><input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"> </td>
          </tr>
          <?php
		  if (($TipoConsulta == "R") || (!isset($TipoConsulta)))
		  {
			    echo "<tr bgcolor='#FFFFFF'> \n";
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
			  	echo "<tr bgcolor='#FFFFFF' valign='middle'>\n";
				echo "<td height='18'>Rut Proveedor:</td>\n";
				echo "<td height='18' colspan='3'> <SELECT name='RutProveedor' style='width:350px' onChange=\"Proceso('R');\">\n";
				echo "<option value='S'>Todos los Proveedores</option>\n";
				$Consulta = "SELECT distinct t1.rut_prv as rutprv_a,  t2.nombre_prv as nomprv_a from sipa_web.prodprv t1 inner join sipa_web.proveedores t2 ";
                $Consulta.= "on t1.rut_prv = t2.rut_prv";
				if ((isset($Producto)) && ($Producto != "S") && ($Producto != ""))
					  $Consulta.=" where t1.cod_subproducto = '".$Producto."'";
				$Consulta.= " order by trim(t2.nombre_prv)";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($RutProveedor == str_pad($Row[rutprv_a],10,'0',STR_PAD_LEFT))
						echo "<option SELECTed value='".str_pad($Row[rutprv_a],10,'0',STR_PAD_LEFT)."'>".str_pad($Row[rutprv_a],10,'0',STR_PAD_LEFT)." - ".strtoupper($Row[nomprv_a])."</option>\n";
					else
						echo "<option value='".str_pad($Row[rutprv_a],10,'0',STR_PAD_LEFT)."'>".str_pad($Row[rutprv_a],10,'0',STR_PAD_LEFT)." - ".strtoupper($Row[nomprv_a])."</option>\n";
				}
				echo "</SELECT></td>\n";
			    echo "</tr>\n";
			  }
			  else
			 {
				if ($TipoConsulta == "D")
				{
					echo "<tr bgcolor='#FFFFFF'> \n";
					echo "<td>Producto:</td>\n";
					echo "<td><SELECT name='Producto' style='width:300px' onChange=\"Proceso('R');\">\n";
					echo "<option value='S'>Todos los Productos</option>\n";
					$Consulta = "SELECT distinct lpad(cod_producto,2,'0') as c_prod_a, cod_subproducto as cod_subproducto from sipa_web.despachos t1 ";
					$Consulta.= " where (cod_producto * 1)<>0 order by lpad(cod_producto,2,'0')";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resp))
					{
						$Consulta = "SELECT  descripcion as descripcion from proyecto_modernizacion.subproducto ";
						$Consulta.= " where cod_producto ='".$Fila["c_prod_a"]."'";
						$Consulta.=" and cod_subproducto = '".$Fila[cod_subproducto]."'";
						$Resp2 = mysqli_query($link, $Consulta);
						if ($Fila2=mysqli_fetch_array($Resp2))
						{
							if ($Producto==$Fila["c_prod_a"]."-".$Fila["cod_subproducto"])
							echo "<option SELECTed value='".$Fila["c_prod_a"]."-".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($Fila2["descripcion"])."</option>\n";
							else
							echo "<option value='".$Fila["c_prod_a"]."-".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($Fila2["descripcion"])."</option>\n";
						}

					}
					echo "</SELECT></td>\n";
					$prod = split('[-]', $Producto);
					echo "<td>&nbsp;</td>\n";
					echo "<td>&nbsp;</td>\n";
					echo "</tr>\n";
					echo "<tr bgcolor='#FFFFFF' valign='middle'>\n";
					echo "<td height='18'>Rut Proveedor:</td>\n";
					echo "<td height='18' colspan='3'> <SELECT name='RutProveedor' style='width:350px' onChange=\"Proceso('R');\">\n";
					echo "<option value='S'>Todos los Proveedores</option>\n";
					$Consulta =" SELECT distinct rut_prv as rut_prv, guia_despacho as Guia, correlativo as Corr ";
					$Consulta.=" from  sipa_web.despachos where rut_prv != ''";	
					if ((isset($Prod[0])) && ($Prod[0] != "S") && ($Prod[0] != ""))
						{
							$Consulta.= " and cod_producto= '".$Prod[0]."'";
							$Consulta.=" and  cod_subproducto= '".$Prod[1]."'";
					    }
					$Consulta.=" group by rut_prv";
                    $Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{					
							$Consulta_p ="Select * from sipa_web.proveedores where rut_prv = '".$Row[rut_prv]."'";
							$Resp2 = mysqli_query($link, $Consulta_p);
							if ($Row2 = mysqli_fetch_array($Resp2))
							{
									if ($RutProveedor == str_pad($Row2[rut_prv],10,'0',STR_PAD_LEFT))
									{	
										echo "<option SELECTed value='".str_pad($Row2[rut_prv],10,'0',STR_PAD_LEFT)."'>".str_pad($Row2[rut_prv],10,'0',STR_PAD_LEFT)." - ".strtoupper($Row2["nombre_prv"])."</option>\n";
									}
									else
									{		
										echo "<option value='".str_pad($Row2[rut_prv],10,'0',STR_PAD_LEFT)."'>".str_pad($Row2[rut_prv],10,'0',STR_PAD_LEFT)." - ".strtoupper($Row2["nombre_prv"])."</option>\n";
									}
							}
/*							else
							{
							
								$RutPrv = $Row[rut_prv];
								ObtenerProveedorDespacho($TipoProceso,$RutPrv,$Row["corr"],$Row[Guia],$RutProved,$NombreProved);
								if ($RutProveedor == str_pad($RutProved,10,'0',STR_PAD_LEFT))
								{										
									echo "<option SELECTed value='".str_pad($RutProved,10,'0',STR_PAD_LEFT)."'>".str_pad($RutProved,10,'0',STR_PAD_LEFT)." - ".strtoupper($NombreProved)."</option>\n";
								}
								else
								{
									echo "<option value='".str_pad($RutProved,10,'0',STR_PAD_LEFT)."'>".str_pad($RutProved,10,'0',STR_PAD_LEFT)." - ".strtoupper($NombreProved)."</option>\n";
								}
						  }*/
					}
					echo "</SELECT></td>\n";
					echo "</tr>\n";

				}
				else
				{
					echo "<tr bgcolor='#FFFFFF' valign='middle'>\n";
					echo "<td height='18'>Producto:</td>\n";
					echo "<td height='18' colspan='3'> \n";
					if ((!isset($IdProducto)) || ($IdProducto == ""))
						$IdProducto = "*";
					if ((!isset($IdProveedor)) || ($IdProveedor == ""))
						$IdProveedor = "*";
					echo "<input type='text' name='IdProducto' value='".$IdProducto."' style='width:210px;'>Todos</td>\n";
					echo "</tr>\n";
					echo "<tr bgcolor='#FFFFFF' valign='middle'>\n";
					echo "<td height='18'>Proveedor:</td>\n";
					echo "<td height='18' colspan='3'> \n";
					echo "<input type='text' name='IdProveedor' value='".$IdProveedor."' style='width:210px;'>Todos</td>\n";
					echo "</tr>\n";
				}
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
				echo "<table width='750' border='0' align='center' cellpadding='2' cellspacing='1' bgcolor='#000000' class='TablaDetalle'>\n";
				echo "<tr bgcolor='#FFFFFF'>\n";
				echo "<td><input type='checkbox' name='Lote' value='S'> Buscar Lote: \n";
				echo "<input name='TxtLote' type='text' id='TxtLote' value='".$TxtLote."' size='17' maxlength='12'></td>\n";
				echo "</tr>\n";
				echo "</table>\n";
			}
			else
			{
				if ($TipoConsulta=="D")
				{
					echo "<br>\n";
					echo "<table width='750' border='0' align='center' cellpadding='2' cellspacing='1' bgcolor='#000000' class='TablaDetalle'>\n";
					echo "<tr bgcolor='#FFFFFF'>\n";
					echo "<td><input type='checkbox' name='Lote' value='S'> Buscar Lote: \n";
					echo "<input name='TxtLote' type='text' id='TxtLote' value='".$TxtLote."' size='17' maxlength='12'></td>\n";
					echo "</tr>\n";
					echo "</table>\n";
				}
			}
		?><br>
        <table width="750" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
          <tr>
            <td align="center" bgcolor="#FFFFFF">
              <span class="Estilo1">
              <input type="button" name="btnWeb" value="Consulta Web" onClick="Proceso('W');" style="width:90px">
              <input type="button" name="btnExcel" value="Consulta Excel" onClick="Proceso('E');" style="width:90px">
              <input type="button" name="btnsalir" value="Salir" onClick="Proceso('S');" style="width:90px">
              </span></td>
          </tr>
        </table> 
      </td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
