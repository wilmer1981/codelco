<?php 	
	//$Fecha_Hora = date("d-m-Y h:i");
	$Fecha_Hora2 = date("Y-m-d");
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 3;
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut       = $CookieRut;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$Consulta ="SELECT * from pac_web.guia_despacho t1 WHERE num_guia ='".$Valores."'";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila1=mysqli_fetch_array($Respuesta);
	$NumGuia          = $Fila1["num_guia"];
	$CmbPatente       = $Fila1["nro_patente"];
	$CmbPatenteRampla = $Fila1["nro_patente_rampla"];	
	$CmbTransp        = $Fila1["rut_transportista"];	
	$CmbCliente       = $Fila1["rut_cliente"];	
	$CmbChofer        = $Fila1["rut_chofer"];	
	$CmbBrazo         = $Fila1["brazo_carga"];
	$CmbEstanque      = $Fila1["cod_estanque"];
	$Toneladas        = $Fila1["toneladas"];
	$VolumenM3        = $Fila1["volumen_m3"];
	$Observacion      = $Fila1["descripcion"];
	$Operador         = $Fila1["rut_funcionario"];
	$Opc              = $Fila1["tipo_guia"];
	$VUnitario        = $Fila1["valor_unitario"];
	$Fecha_Hora       = $Fila1["fecha_hora"];
	$DivSap           = $Fila1["div_sap"];
	$AlmSap           = $Fila1["almacen_sap"];
	$Sellos           = $Fila1["sellos"];
	$CodProd          = $Fila1["cod_producto"];
	$CodUnidad        = $Fila1["cod_unidad"];
	$CodOri           = $Fila1["cod_originador"];
	$estadoGuia       = $Fila1["estado"];
	$corr_interno_cliente = $Fila1["corr_interno_cliente"];

	if ($estadoGuia=="N") {
		$query = "select observacion from pac_web.pac_anulacion_guia where nro_guia ='".$Valores."'";
		$resp=mysqli_query($link, $query);
		$filaResp=mysqli_fetch_array($resp);
		$observacionAnula = $filaResp["observacion"];
	}
	
?>
<html>
<head>
<script language="JavaScript">
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" background="../principal/imagenes/fondo3.gif" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
  <table width="653" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table  width="653" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td colspan="2"><strong> 
              <?php
		$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from proyecto_modernizacion.funcionarios where rut = '".$Rut."'";
	  	$Resultado= mysqli_query($link, $Consulta);
		if ($Fila =mysqli_fetch_array($Resultado))
		{	
			echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
		}	  
	  	else
			{
		  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
					}
		
			}
		  ?>
              </strong> </td>
            <td>&nbsp;</td>
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $Fecha_Hora ?> 
              </strong>&nbsp; <strong> 
              <?php
					/*if (!isset($FechaHora))
					{
						echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
						$FechaHora=date('Y-m-d H:i');
					}
					else
					{ 
						echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
					}*/
				  ?>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td width="104">N&deg; Guia</td>
            <td> 
            <?php
				echo "<input name='NumGuia' type='hidden'  style='width:100' value=".$NumGuia.">";
            	echo $NumGuia;
			?>
			</td>
            <td>Camion 
              <?php
			 if ($Opc=='C')
			 {
			  	echo "<input type='radio' name='RadioC' value='radiobutton' disabled checked></td>"; 
             }
			 else
			 {
			 	echo "<input type='radio' name='RadioC' value='radiobutton' disabled></td>"; 
			 }
			 ?>
			</td>
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Buque 
              <?php
			  if ($Opc=='B')
			 {
			  	echo "<input type='radio' name='RadioB' value='radiobutton' checked disabled ></td>"; 
             }
			 else
			 {
			 	echo "<input type='radio' name='RadioB' value='radiobutton' disabled></td>"; 
			 }
			  ?>
              </font></font></td>
          </tr>
          <tr>
          	<td>Patente </td>
            <td width="156"> 
              <?php
				echo "<input name='CmbPatente' type='hidden'  style='width:100' value=".$CmbPatente.">";
            	echo $CmbPatente."&nbsp;";
				$Consulta ="select fecha_rev_tecnica,fecha_cert_estanque from pac_web.camiones_por_transportista where nro_patente = '".$CmbPatente."' ";
				$Resp=mysqli_query($link, $Consulta);
				$Fil=mysqli_fetch_array($Resp);
				if ((date($Fil["fecha_rev_tecnica"]))< (date($Fecha_Hora2)))
				{
					echo "[R.T:<font color='red'>".$Fil["fecha_rev_tecnica"]."</font>]";
				}
				else
				{
					echo "[R.T:<font color='green'>".$Fil["fecha_rev_tecnica"]."</font>]";
				}
				echo "</td>";
				?>
            </td>
            <td width="104">Transp.</td>
            <td width="252"> 
              <?php
				$Consulta=" select * from pac_web.transportista where rut_transportista = '".$CmbTransp."'"; 
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				echo "<input name='CmbTransp' type='hidden'  style='width:100' value=".$Fila["nombre"].">";
            	echo $Fila["nombre"];
				?>
            </td>
          </tr>
          <tr> 
            <td width="104">Originador</td>
            <td width="252"> 
              <?php
				$Consulta=" select * from pac_web.pac_originador where cod_originador = '".$CodOri."'"; 
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				echo "<input name='CodOri' type='hidden'  style='width:100' value=".$Fila["nombre"].">";
            	echo $Fila["nombre"];
				?>
            </td>
            <td>Operador Responsable</td>
            <td>
             <?php
				$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Operador."'";
				$Respuesta5 = mysqli_query($link, $Consulta);
				$NombreF = "";
				if ($Row2 = mysqli_fetch_array($Respuesta5))
				{
					
					$NombreF.= ucwords(strtolower($Row2["nombres"]))." ".ucwords(strtolower($Row2["apellido_paterno"]))." ".ucwords(strtolower($Row2["apellido_materno"]));
				}
					echo "<input name ='Funcionario' type='hidden' readonly style='width:250' maxlength='120' value ='".$NombreF."'>";
	  				echo $NombreF;			
				?>
			
			</td>
          </tr>
          <tr>
          <td width="104">Divisi&oacuten&nbspSAP</td>
            <td> 
             <?php
				echo "<input name='NumGuia' type='hidden'  style='width:100' value=".$DivSap.">";
            	echo $DivSap;
			 ?>
			</td>
			<td width="104">Almac&eacuten&nbspSAP</td>
            <td> 
             <?php
				echo "<input name='NumGuia' type='hidden'  style='width:100' value=".$AlmSap.">";
            	echo $AlmSap;
			 ?>
			</td>
          </tr>
          <tr> 
            <td>Cliente</td>
            <td> 
              <?php
				$Consulta=" select * from pac_web.clientes where rut_cliente = '".$CmbCliente."' and corr_interno_cliente=$corr_interno_cliente  "; 
				$Respuesta1=mysqli_query($link, $Consulta);
				$Fila1=mysqli_fetch_array($Respuesta1);
				echo "<input name='CmbCliente' type='hidden'  style='width:100' value=".$Fila1["nombre"].">";
            	echo $Fila1["nombre"];
				?>
            <td>Chofer 
            <td> 
              <?php
				$Consulta=" select * from pac_web.choferes where rut_chofer = '".$CmbChofer."'  "; 
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2);
				echo "<input name='CmbChofer' type='hidden'  style='width:100' value=".$Fila2["nombre"].">";
            	echo $Fila2["nombre"];
				?>
          </tr>
          <tr> 
            <td>Estanque</td>
            <td> 
              <?php
				$Consulta=" select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase = '9001' and cod_subclase = '".$CmbEstanque."' "; 
				$Respuesta3=mysqli_query($link, $Consulta);
				$Fila3=mysqli_fetch_array($Respuesta3);
				echo "<input name='CmbEstanque' type='hidden'  style='width:100' value=".$Fila3["nombre_subclase"].">";
            	echo $Fila3["nombre_subclase"];
				?>
            </td>
            <td>Brazo Carga</td>
            <td> 
              <?php
				$Consulta=" select nombre from pac_web.parametros where (codigo between 10 and 14) and codigo = '".$CmbBrazo."' ";
				$Respuesta4=mysqli_query($link, $Consulta);
				$Fila4=mysqli_fetch_array($Respuesta4);
				$nombre = isset($Fila4["nombre"])?$Fila4["nombre"]:"";
				echo "<input name='CmbBrazo' type='hidden'  style='width:100' value=".$nombre.">";
            	echo $nombre;
				?>
            </td>
          </tr>
          <tr> 
            <td>Toneladas</td>
            <td>
			<?php
				echo "<input name='Toneladas' type='hidden'  style='width:100' value=".$Toneladas.">";
            	echo str_replace(".",",",$Toneladas)."&nbsp;&nbsp;&nbsp;Mts<sup>3</sup>&nbsp;".str_replace(".",",",$VolumenM3);
			?>
            </td>
            <td width="104">Producto</td>
            <td width="252"> 
             <?php
			  $Consulta=" select * from pac_web.pac_productos where cod_producto = '".$CodProd."'";
			  $Respuesta=mysqli_query($link, $Consulta);
			  $Fila=mysqli_fetch_array($Respuesta);
			   echo "<input name='CodProd' type='hidden' style='width:100' value=".$Fila["nombre"].">";
               echo $Fila["nombre"];
			  ?>
            </td>
          </tr>
		  <tr> 
            <td>Patente Rampla</td>
            <td colspan="3">
			<?php 
				echo $CmbPatenteRampla."&nbsp;&nbsp;";
				$Consulta ="select fecha_rev_tecnica,fecha_cert_estanque from pac_web.camiones_por_transportista where nro_patente = '".$CmbPatenteRampla."' ";
				$Resp=mysqli_query($link, $Consulta);
				$Fil=mysqli_fetch_array($Resp);
				echo "[R.T:";
				if ((date($Fil["fecha_rev_tecnica"])) < (date($Fecha_Hora2)))
				{
					echo "<font color='red'>".$Fil["fecha_rev_tecnica"]."</font>]";
				}
				else
				{
					echo "<font color='green'>".$Fil["fecha_rev_tecnica"]."</font>]";
				}
				echo "&nbsp;&nbsp;[C.E:";
				if ((date($Fil["fecha_cert_estanque"])) < (date($Fecha_Hora2)))
				{
					echo "<font color='red'>".$Fil["fecha_cert_estanque"]."</font>]";
				}
				else
				{
					echo "<font color='green'>".$Fil["fecha_cert_estanque"]."</font>]";
				}
			?>
			</td>
		  </tr> 	
          <tr>
          <td width="104">Unidad de Medida</td>
            <td width="252"> 
             <?php
		$Consulta=" select * from pac_web.pac_unidades_medida where cod_unidad = '".$CodUnidad."'";
			  $Respuesta=mysqli_query($link, $Consulta);
			  $Fila=mysqli_fetch_array($Respuesta);
			  $nombre = isset($Fila["nombre"])?$Fila["nombre"]:"";
			   echo "<input name='CodProd' type='hidden' style='width:100' value=".$nombre.">";
               echo $nombre;
			  ?>
            </td> 
            <td>Valor Unitario</td>
            <td><?php echo $VUnitario; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
          <td width="104">Sellos N&deg;</td>
          <td> 
            <?php
			echo "<input name='NumGuia' type='hidden'  style='width:100' value=".$Sellos.">";
            echo $Sellos;
			?>
		  </td>
          </tr>
		  <tr> 
            <td>Glosa</td>
            <td colspan="3"> 
              <?php
					echo "<textarea name='Observacion' style='overflow:hidden;resize:none;width:350' wrap='VIRTUAL' readonly>$Observacion</textarea>";
			  ?>
          </tr>
         <?php if($estadoGuia=="N") 
         {
         	?>  <tr>
         <td>Observaci&oacuten Anulaci&oacuten</td>
			<td colspan="3"><textarea name='ObservacionAnula' style="overflow:hidden;resize:none;width:350" rows="3" scrolling="no" readonly><?php echo $observacionAnula;?> </textarea></td>
          </tr>
      <?php }?>
        </table>
        <br>
        <table width="653" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="653">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
