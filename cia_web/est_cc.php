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
function ver_detalle(cc)
{
	var URL,opciones;
	opciones='toolbar=0,resizable=0,menubar=1,status=1,scrollbars=1';
	URL='resultado.php?op=1&filtro=ubi&cmbUbicacion=' + cc + '&opcion=all&codigo=on&marca=on';
	URL+='&modelo=on&nro_serie=on&nombres=on&apellido_paterno=on&apellido_materno=on&cc_user=on&tipo=on';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
	popup.moveTo(0,0);
}

function to_excel(centro_costo)
{
	var URL,opciones;
	URL='ToExcel/est_cc_excel.php?centro_costo=' + centro_costo;
	opciones='toolbar=0,resizable=0,menubar=1,status=1,scrollbars=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo(0,0);
	popup.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
}
</script>
</head>

<body bgcolor="#CCCCCC" onUnload="verificar_popup(popup)">
<?php
include("../principal/conectar_principal.php");

$centro_costo=$cc;
$cc=substr($centro_costo,0,4);

//se recupera la cantidad total de equipos asignados al centro de costo
$query="select count(t1.codigo) as cant from hardware as t1, asoc_equipos_usuarios as t2 ";
$query.="where t1.tipo='EQUIPO' and t1.codigo=t2.cod_equipo and t2.estado_asoc=1 and t2.cc_ubicacion='".$cc."';";
$result=mysql_db_query("cia_web",$query,$link);
$resp=mysql_fetch_array($result);
mysql_free_result($result);
$total_eq_asig=$resp["cant"];

$query="select count(t1.codigo) as cant from hardware as t1, asoc_equipos_usuarios as t2, asoc_partes_equipos as t3 ";
$query.="where t1.tipo='PARTE' and t1.codigo=t3.cod_parte and t3.estado_asoc=1 and t2.nro_asoc=t3.nro_asoc_eq_user and t2.cc_ubicacion='".$cc."';";
$result=mysql_db_query("cia_web",$query,$link);
$resp=mysql_fetch_array($result);
mysql_free_result($result);
$total_pt_asig=$resp["cant"];
?>
<form name="frmEstadisticaCC" method="post">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" width="600" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table border="0" class="TablaInterior" align="center" width="550" cellspacing="2">
          <tr> 
            <td class="ColorTabla01" align="center"><strong>Estadisticas Centro 
              de Costo: 
              <?php echo $centro_costo;?>
              </strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td> 
              <!--      			ESTADISTICAS GENERALES		-->
              <table border="0" align="center" cellpadding="0" cellspacing="2" width="500" class="TD">
                <tr><td>&nbsp;</td></tr>
				<tr>
					<td>
					<table border="0" cellspacing="2" width="300">
					<tr>
						<td class="TD" width="200"><strong>Total Equipos Asignados</strong></td>
						<td class="TD" width="100" style="color: #FF0000;"><strong><?php echo $total_eq_asig;?></strong></td>
					</tr>
					<tr>
						<td class="TD" width="200"><strong>Total Partes Asignadas</strong></td>
						<td class="TD" width="100" style="color: #FF0000;"><strong><?php echo $total_pt_asig;?></strong></td>
					</tr>
					</table>
					</td>
				</tr>
                <tr><td>&nbsp;</td></tr>
				<?php
				if($total_eq_asig!=0 || $total_pt_asig!=0)
				{
				?>				
                <tr> 
                  <td> <table border="0" class="td" align="center" width="480">
                      <tr> 
                        <td class="TD" colspan="2" bgcolor="#999999" style="color: #FFFFFF;"><strong>Detalle</strong></td>
                      </tr>
                      <tr> 
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td class="TD" width="150"><strong>Tipo de Equipo</strong></td>
                        <td> <table border="0" cellpadding="0" cellspacing="2" width="330">
                            <tr> 
                              <td width="280">&nbsp;</td>
                              <td class="TD" bgcolor="#CCCCCC" style="color: #0000CC;" width="50">Total</td>
                            </tr>
                            <?php
							//se recuperan todos los tipos de equipos
							$query="select t1.nombre_subclase as nombre, count(t2.codigo) as cant ";
							$query.="from proyecto_modernizacion.sub_clase as t1, cia_web.hardware as t2,";
							$query.=" cia_web.asoc_equipos_usuarios as t3 where  t1.cod_clase=18003 and t1.valor_subclase1 = left(t2.codigo,3) ";
							$query.="and t2.codigo=t3.cod_equipo and t3.cc_ubicacion='".$cc."' and t3.estado_asoc=1 ";
							$query.="group by left(t2.codigo,3) UNION ALL ";
							$query.="select t1.nombre_subclase as nombre, count(t2.codigo) as cant ";
							$query.="from proyecto_modernizacion.sub_clase as t1, cia_web.hardware as t2, cia_web.asoc_equipos_usuarios as t3, ";
							$query.="cia_web.asoc_partes_equipos as t4 where t1.cod_clase=18003 and t1.valor_subclase1 = left(t2.codigo,3) ";
							$query.="and t2.codigo=t4.cod_parte and t4.estado_asoc=1 and t3.nro_asoc=t4.nro_asoc_eq_user ";
							$query.="and t3.cc_ubicacion='".$cc."' group by left(t2.codigo,3);";
							
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
                          </table></td>
                      </tr>
                      <tr><td colspan="2">&nbsp;</td></tr>
					  <tr>
					  	<td align="center" colspan="2">
						<input type="button" name="detalle" value="Ver Listado Detallado" style="width: 150px;" onClick="ver_detalle('<?php echo $cc;?>')">
						</td>
					  </tr>
					  <tr><td colspan="2">&nbsp;</td></tr>
                    </table></td>
                </tr>
                <tr><td>&nbsp;</td></tr>
				<tr>
					<td align="center">
					<input type="button" name="ToExcel" value="Excel" style="width: 80px;" onClick="to_excel('<?php echo $centro_costo;?>')">
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<?php }?>
              </table>
              <!--				FIN ESTADISTICAS GENERALES   		-->
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
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
