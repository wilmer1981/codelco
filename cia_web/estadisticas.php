<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style>
<!--
.LINK{
	font:Arial, Helvetica, sans-serif;
	color:#FFFF00;
	text-align:center;
	text-decoration:none;
}

a:link{
	color:#FFFF00;
}	

a:hover{
	color:#FFFF00;
}

a:visited{
	color:#FFFF00;
}

a:active{
	color:#FFFFFF;
}

.TD{
	border:solid 1px #666666;
	text-align:center;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script language="JavaScript" type="text/javascript" src="funciones.js"></script>
<script language="JavaScript" type="text/javascript">
var popup=0;

function to_excel()
{
	var URL,opciones;
	URL='ToExcel/est_general_excel.php';
	opciones='toolbar=0,resizable=0,menubar=1,status=1,scrollbars=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo(0,0);
	popup.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
}

function ver(opcion)
{
	var URL,opciones,f=document.frmEstadistica;
	switch(opcion)
	{
		case 'cc':
			if(f.cc.value==0)
			{
				alert("Debe seleccionar un centro de costo");
				f.cc.focus();
				return false;
			}
			URL='est_cc.php?cc=' + f.cc.value;
			opciones='toolbar=0,resizable=0,menubar=0,status=1,width=640,height=700,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
	}
}
</script>
</head>

<body bgcolor="#CCCCCC" onUnload="verificar_popup(popup)">
<?php
include("../principal/conectar_principal.php");

//se obtiene las cantidades generales para los equipos y las partes segun los estados
$query="select count(codigo) as cant from hardware where tipo='EQUIPO' and estado=1 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='EQUIPO' and estado=2 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='EQUIPO' and estado=3 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='EQUIPO' and estado=4 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='PARTE' and estado=1 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='PARTE' and estado=2 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='PARTE' and estado=3 UNION ALL ";
$query.="select count(codigo) as cant from hardware where tipo='PARTE' and estado=4;";
$result=mysql_db_query("cia_web",$query,$link);

$total_eq=0;
$total_pt=0;
?>
<form name="frmEstadistica" method="post">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" width="600" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table border="0" class="TablaInterior" align="center" width="550" cellspacing="2">
	<tr>
	    <td class="ColorTabla01" align="center"><strong>Estadisticas de Equipos y Partes</strong></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
		
		<!--      			ESTADISTICAS GENERALES		-->
		<table border="0" align="center" cellpadding="0" cellspacing="2" width="500" class="TD">
		<tr>
			<td class="TD" bgcolor="#00CCFF"><strong>Generales</strong></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td>
			<table border="0" cellspacing="2" width="450">
			<tr>
				        <td colspan="5" class="TD" style="color: #FFFFFF" bgcolor="#999999"><strong>EQUIPOS</strong></td>
			</tr>
			<tr bgcolor="#CCCCCC" style="color: #0000CC;">
				<td class="TD" width="100">Asignados</td>
				<td class="TD" width="100">Para Baja</td>
				<td class="TD" width="100">De Baja</td>
				<td class="TD" width="100">Disponibles</td>
				<td class="TD" width="50"><strong>TOTAL</strong></td>
			</tr>
			<tr style="color: #FF0000;">
				<td class="TD"><?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_eq+=$resp["cant"];?></td>
				<td class="TD"><?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_eq+=$resp["cant"];?></td>
				<td class="TD"><?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_eq+=$resp["cant"];?></td>
				<td class="TD"><?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_eq+=$resp["cant"];?></td>
				<td class="TD"><strong><?php echo $total_eq;?></strong></td>
			</tr>
			</table>
			</td>
		</tr>
			<tr><td>&nbsp;</td></tr>
		<tr>
			<td>
			<table border="0" cellspacing="2" width="450">
                      <tr> 
                        <td colspan="5" class="TD" style="color: #FFFFFF" bgcolor="#999999"><strong>PARTES</strong></td>
                      </tr>
                      <tr bgcolor="#CCCCCC" style="color: #0000CC;"> 
                        <td class="TD" width="100">Asignados</td>
                        <td class="TD" width="100">Para Baja</td>
                        <td class="TD" width="100">De Baja</td>
                        <td class="TD" width="100">Disponibles</td>
                        <td class="TD" width="50"><strong>TOTAL</strong></td>
                      </tr>
                      <tr style="color: #FF0000;"> 
                        <td class="TD"> 
                          <?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_pt+=$resp["cant"];?>
                        </td>
                        <td class="TD"> 
                          <?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_pt+=$resp["cant"];?>
                        </td>
                        <td class="TD"> 
                          <?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_pt+=$resp["cant"];?>
                        </td>
                        <td class="TD"> 
                          <?php $resp=mysql_fetch_array($result); echo $resp["cant"]; $total_pt+=$resp["cant"];?>
                        </td>
                        <td class="TD"><strong><?php echo $total_pt;?></strong></td>
                      </tr>
                    </table>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<?php 
		mysql_free_result($result);
		if($total_eq!=0 || $total_pt!=0)
		{
		?>
		<tr>
			<td>
			<table border="0" class="td" align="center" width="480">
			<tr>
		        <td class="TD" colspan="2" bgcolor="#999999" style="color: #FFFFFF;"><strong>Detalle</strong></td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td class="TD" width="150"><strong>Tipo de Equipo</strong></td>
				<td>
				<table border="0" cellpadding="0" cellspacing="2" width="330">
				<tr>
					<td width="280">&nbsp;</td>
					<td class="TD" bgcolor="#CCCCCC" style="color: #0000CC;" width="50">Total</td>
				</tr>
				<?php
				//se recuperan todos los tipos de equipos
				$query="select t1.nombre_subclase as nombre, count(t2.codigo) as cant ";
				$query.="from proyecto_modernizacion.sub_clase as t1, cia_web.hardware as t2";
				$query.=" where t1.cod_clase=18003 and t1.valor_subclase2='S' and ";
				$query.="t1.valor_subclase1 = left(t2.codigo,3) group by left(t2.codigo,3) ";
				$query.="order by t1.valor_subclase1;";
				$result=mysql_db_query("proyecto_modernizacion",$query,$link);
				while($resp=mysql_fetch_array($result))
				{
					echo '<tr>';
					echo '<td class="TD" width="280">'.$resp["nombre"].'</td>';
					echo '<td class="TD" style="color: #FF0000;"><strong>'.$resp["cant"].'</strong></td>';
					echo '</tr>';
				}
				mysql_free_result($result);
				?>
				</table>
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td class="TD"><strong>Centro de Costo</strong></td>
				<td>
				<table border="0" cellpadding="0" cellspacing="2" width="330">
				<tr>
					<td>&nbsp;</td>
					<td width="50" class="TD" bgcolor="#CCCCCC" style="color: #0000CC;">Equipos</td>
					<td width="50" class="TD" bgcolor="#CCCCCC" style="color: #0000CC;">Partes</td>
				</tr>
				<?php
				//consulta para obtener la cantidad de equipos que posee cada centro de costo
				$query="select t1.centro_costo,t1.descripcion, count(t2.cc_ubicacion) as cant_equipos";
				$query.=" from proyecto_modernizacion.centro_costo as t1, cia_web.asoc_equipos_usuarios as t2";
				$query.=" where t1.centro_costo = t2.cc_ubicacion and t2.estado_asoc=1";
				$query.=" group by t1.centro_costo order by t1.descripcion;";
				$result_1=mysql_query($query,$link);
				
				//consulta para obtener la cantidad de partes que posee cada centro de costo
				$query="select t1.centro_costo,t1.descripcion, count(t3.nro_asoc_eq_user) as cant_partes";
				$query.=" from proyecto_modernizacion.centro_costo as t1, cia_web.asoc_equipos_usuarios";
				$query.=" as t2, cia_web.asoc_partes_equipos as t3 where t1.centro_costo = t2.cc_ubicacion";
				$query.=" and t2.estado_asoc=1 and t2.nro_asoc=t3.nro_asoc_eq_user and t3.estado_asoc=1";
				$query.=" group by t1.centro_costo order by t1.descripcion;";
				$result_2=mysql_query($query,$link);
				while($resp_1=mysql_fetch_array($result_1))
				{
					echo '<tr>';
					echo '<td class="TD" width="230">'.$resp_1["centro_costo"]." - ".$resp_1["descripcion"].'</td>';
					echo '<td class="TD" style="color: #FF0000;" width="50">&nbsp;<strong>'.$resp_1["cant_equipos"].'</strong></td>';
					if(!$resp_2=mysql_fetch_array($result_2))
						$resp_2["cant_partes"]=0;
					echo '<td class="TD" style="color: #FF0000;" width="50">&nbsp;<strong>'.$resp_2["cant_partes"].'</strong></td>';
					echo '</tr>';
				}
				mysql_free_result($result_1);
				mysql_free_result($result_2);
				?>
				</table>
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			</table>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td align="center">
			<input type="button" name="TOEXCEL" value="Excel" style="width: 80px;" onClick="to_excel()">
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<?php }?>
		</table>
		<!--				FIN ESTADISTICAS GENERALES   		-->
		
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
		<tr>
			<td>
			
			<!--		ESTADISTICAS POR CENTRO DE COSTO 		-->
			<table border="0" align="center" cellpadding="0" cellspacing="2" width="500" class="TD">
			<tr>
				<td class="TD" bgcolor="#00CCFF"><strong>Por Centro de Costo</strong></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td align="center">
				<table cellspacing="2" border="0" width="350">
				<tr>
					<td class="TD">
					<select name="cc">
					<option value="0" selected>Seleccione el centro de costo</option>
					<?php
					//se recuperan todos los centros de costo
					$query="select centro_costo as cc, descripcion as nom from centro_costo;";
					$result=mysql_db_query("proyecto_modernizacion",$query,$link);
					while($resp=mysql_fetch_array($result))
						echo '<option value="'.$resp["cc"]." - ".$resp["nom"].'">'.$resp["cc"]." - ".$resp["nom"].'</option>';
					mysql_free_result($result);
					?>
					</select>
					</td>
				</tr>
				</table>
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td><input type="button" name="ver_cc" value="Ver" style="width: 80px;" onClick="ver('cc')"></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			</table>
			<!--		FIN ESTADISTICAS POR CENTRO DE COSTO 	-->
			
			</td>
		</tr>
	<tr><td>&nbsp;</td></tr>
	</table>
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr><td align="center">
<input type="button" name="close" value="Cerrar" style="width: 80px;" onClick="javascript: window.close()">
</td></tr>
<tr><td>&nbsp;</td></tr>
</table>

</form>
</body>
</html>
