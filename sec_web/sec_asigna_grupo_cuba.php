<?php
	$CodigoDeSistema = 3;
	$CodigoDePantalla =16; 
	include("../principal/conectar_principal.php");
	
	$Ano      = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date('Y');
	$NumBulto = isset($_REQUEST["NumBulto"])?$_REQUEST["NumBulto"]:"";
	$CodBulto = isset($_REQUEST["CodBulto"])?$_REQUEST["CodBulto"]:"A";
	$UnidLote = isset($_REQUEST["UnidLote"])?$_REQUEST["UnidLote"]:"";
	$PesoLote = isset($_REQUEST["PesoLote"])?$_REQUEST["PesoLote"]:"";

?>
<html>
<head>
<title>Sistema de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "A":
			if (f.NumBulto.value == "S")
			{
				alert("Debe seleccionar un Lote");
				f.NumBulto.focus();
				return;
			}									
			var URL = "sec_asigna_grupo_cuba01.php?FechaLote=" + f.FechaLote.value + "&Ano=" + f.Ano.value + "&CodBulto=" + f.CodBulto.value + "&NumBulto=" + f.NumBulto.value;
			window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
			break;
		case "E":
			var Parametros = ""
			for (i=1;i<f.elements.length;i++)
			{
				if ((f.elements[i].name == "RadioElim") && (f.elements[i].checked == true))
				{
					Parametros = f.elements[i].value;
					break;
				}
			}
			if (Parametros == "")
			{
				alert("Debe seleccionar un registro para eliminar");
				return;
			}
			f.action = "sec_asigna_grupo_cuba02.php?Proceso=E&Valores=" + Parametros;
			f.submit();
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=3";
			f.submit();
			break;
	}
}
function Recarga()
{
	var f = document.frmPrincipal;
	f.action = "sec_asigna_grupo_cuba.php";
	f.submit();
}

function Historial(SA)
{
	window.open("../cal_web/cal_con_registro_leyes.php?SA="+ SA,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body leftmargin="1" topmargin="1" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php"); ?>
<table width="770" height="315" border="0" cellpadding="3" cellspacing="3" class="TablaPrincipal">
  <tr> 
    <td valign="top"> <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr align="center"> 
            <td colspan="6"><strong>ASIGNACION DE GRUPOS A CAT. DESC. NORMAL</strong></td>
          </tr>
          <tr> 
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr> 
            <td width="95">A&Ntilde;O:</td>
            <td><select name="Ano" onChange="Recarga();">
                <?php
					for ($i = 2003; $i <= date("Y")+1;$i++)
					{
						if (isset($Ano))
						{
							if ($Ano == $i)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else
								echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if (date("Y") == $i)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else
								echo "<option value='".$i."'>".$i."</option>\n";
						}
					}		
				?>
              </select> </td>
            <td> COD.LOTE:</td>
            <td><select name="CodBulto" onChange="Recarga();">
                <?php
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3004' order by nombre_subclase";
					$Respuesta = mysqli_query($link, $Consulta);	
					while ($Fila = mysqli_fetch_array($Respuesta))
					{
						if ($CodBulto == $Fila["nombre_subclase"])
							echo "<option selected value='".$Fila["nombre_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
						else
							echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
					}		
				?>
              </select></td>
            <td width="115">LOTE:</td>
            <td width="259"><select name="NumBulto" onChange="Recarga();">
                <option value="S">Seleccione</option>
                <?php
					//if (!isset($Ano))
					//	$Ano = date("Y");
					//if (!isset($CodBulto))
					//	$CodBulto = "A";

					$Consulta = "select distinct t1.cod_bulto, t1.num_bulto ";
					$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2";
					$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
					$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
					$Consulta.= " where t1.cod_bulto = '".$CodBulto."'";
					$Consulta.= " and year(t1.fecha_creacion_lote) = '".$Ano."'";
					$Consulta.= " and t2.cod_producto = '18'";
					$Consulta.= " and t2.cod_subproducto in (3,42,43,44)";
					$Consulta.= " order by t1.cod_bulto, t1.num_bulto";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Respuesta))
					{
						if ($Fila["num_bulto"] == $NumBulto)
							echo "<option selected value = '".$Fila["num_bulto"]."'>".strtoupper($CodBulto)."-".str_pad($Fila["num_bulto"],6,0,STR_PAD_LEFT)."</option>\n";
						else
							echo "<option value = '".$Fila["num_bulto"]."'>".strtoupper($CodBulto)."-".str_pad($Fila["num_bulto"],6,0,STR_PAD_LEFT)."</option>\n";
					}
						
				?>
              </select></td>
          </tr>
          <tr> 
            <?php
				$Consulta = "select t1.cod_bulto, t1.num_bulto, t1.fecha_creacion_lote, sum(t2.num_unidades) as unidades, sum(t2.peso_paquetes) as peso";
				$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
				$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
				$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
				$Consulta.= " where t1.cod_bulto = '".$CodBulto."'";
				$Consulta.= " and t1.num_bulto = '".$NumBulto."'";
				$Consulta.= " group by t1.cod_bulto, t1.num_bulto";
				$Respuesta = mysqli_query($link, $Consulta);
				$FechaLote="0000-00-00";
				if ($Fila = mysqli_fetch_array($Respuesta))
				{
					$UnidLote = $Fila["unidades"];
					$PesoLote = $Fila["peso"];
					$FechaLote = $Fila["fecha_creacion_lote"];
				}
			?>
            <input type="hidden" name="FechaLote" value="<?php echo $FechaLote; ?>">
            <td height="28">UNID. LOTE:</td>
            <td> <input name="UnidLote" readonly="" type="text" id="UnidLote5" value="<?php echo $UnidLote; ?>" size="15" maxlength="7"> 
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>PESO LOTE:</td>
            <td><input name="PesoLote" type="text" readonly="" id="PesoLote2" value="<?php echo $PesoLote; ?>" size="15" maxlength="7"> 
            </td>
          </tr>
          <tr align="center"> 
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr align="center"> 
            <td colspan="6"><input name="BtnAsignar" type="button" id="BtnAsignar" style="width:130px" onClick="Proceso('A');" value="Asignar Grupo"> 
              <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70px" onClick="Proceso('E');" value="Eliminar">
              <input name="BtnSalir" type="button" value="Salir" style="width:70px" onClick="Proceso('S');"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="98%" border="1" align="center" cellpadding="3" cellspacing="1" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="10%">ELIMINA</td>
            <td width="16%">FECHA</td>
            <td width="10%">GRUPO</td>
            <td width="14%">PESO PROD.</td>
            <td width="14%">PARTICIPA</td>
          </tr>
          <?php		  
			$Encontro = false;
			//CONSULTA SI YA FUE ASIGNADO A ESTE LOTE
			$Consulta = "select * from sec_web.catodos_desc_normal ";
			$Consulta.= " where cod_bulto = '".$CodBulto."'";
			$Consulta.= " and num_bulto = '".$NumBulto."'";
			$Consulta.= " and fecha_creacion_bulto = '".$FechaLote."'";
			$Consulta.= " order by fecha_produccion, grupo";
			$Respuesta = mysqli_query($link, $Consulta);
			$UnidTotal = 0;
			$PesoTotal = 0;
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Encontro = true;
				$Valores = $Fila["cod_bulto"]."/".$Fila["num_bulto"]."/".$Fila["fecha_creacion_bulto"]."/".$Fila["grupo"]."/".$Fila["cuba"]."/".$Fila["fecha_produccion"];
				$FechaProd = substr($Fila["fecha_produccion"],8,2)."/".substr($Fila["fecha_produccion"],5,2)."/".substr($Fila["fecha_produccion"],0,4);
				echo "<tr>\n";
				echo "<td align='center'><input type='radio' name='RadioElim' value='".$Valores."'></td>\n";
				echo "<td align='center'>".$FechaProd."</td>\n";
				echo "<td align='center'>".$Fila["grupo"]."</td>\n";
				echo "<td align='right'>".number_format($Fila["peso_produccion"],0,",",".")."</td>\n";
				if ($Fila["participa"] == "T")
					$Desc = "TOTAL";
				else
					$Desc = "PARCIAL";
				echo "<td align='center'>".$Desc."</td>\n";
				echo "</tr>\n";
				$PesoTotal = $PesoTotal + $Fila["peso_produccion"];
			}
			if ($Encontro == false)
			{
				echo "<tr>\n";
				echo "<td>&nbsp;</td>\n";
				echo "<td>&nbsp;</td>\n";
				echo "<td>&nbsp;</td>\n";
				echo "<td>&nbsp;</td>\n";
				echo "<td>&nbsp;</td>\n";
				echo "</tr>\n";
			}
?>
          <tr align="center"> 
            <td colspan="3" align="right"><strong>TOTAL</strong></td>
            <td align="right">&nbsp;<?php echo number_format($PesoTotal,0,",","."); ?></td>
            <td align="right">&nbsp;</td>
          </tr>
        </table> </td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>
