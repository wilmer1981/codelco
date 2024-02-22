<?php
include("../principal/conectar_principal.php");
$Consulta ="select t3.abreviatura,t4.descripcion,t3.cod_leyes,t4.centro_costo,t3.tipo_leyes,t1.recargo "; 
$Consulta = $Consulta."from  cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on (t1.rut_funcionario = t2.rut_funcionario) "; 
$Consulta = $Consulta."and (t1.fecha_hora = t2.fecha_hora) and (t1.nro_solicitud = t2.nro_solicitud) and (t1.recargo = t2.recargo) ";
$Consulta = $Consulta."inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes ";  
$Consulta = $Consulta."inner join proyecto_modernizacion.centro_costo t4 on t1.cod_ccosto = t4.centro_costo "; 
if ($Recargo=='N')
{
	$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.rut_funcionario = '".$RutF."' "; 
}
else
{
	$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.recargo ='".$Recargo."' and t1.rut_funcionario = '".$RutF."'"; 
}
//echo $Consulta."<br>";
$Respuesta =mysqli_query($link, $Consulta);
$Ley ="";
$Impurezas ="";
while ($Fila =mysqli_fetch_array($Respuesta))
{
	$CCosto=$Fila["centro_costo"].' '.$Fila["descripcion"];
	
	if (($Fila["tipo_leyes"] == '0')|| ($Fila["tipo_leyes"] == '3'))
	{
		$Ley = $Ley.$Fila ["abreviatura"].'-';
	}
	if ($Fila["tipo_leyes"] == '1')
	{
		$Impurezas = $Impurezas.$Fila["abreviatura"].'-'; 
	}
}	

$TxtSA = $SA;
$TxtProductos = $Productos;;
$TxtMuestra = $Muestra;
$TxtLotes = $Lotes;
$TxtCCosto = $CCosto;
$TxtLeyes = $Ley;
$TxtImpurezas = $Impurezas;
$TxtEstado = $Estado;
$TxtFechaAt = $FechaAt.' '.$HoraAt;
$TxtFechaRe = $FechaRe.' '.$HoraR;
$TxtRecargo = $Recargo;
?>
<html>
<head>
<title>Detalle de Solicitudes Muestreo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="form1" method="post" action="">
  <table width="709" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5"  >
    <tr>
      <td><table width="704"  border="0" cellpadding="3" cellspacing="0" class="ColorTabla01">
          <tr> 
            <td width="695"><div align="center"><strong>DETALLE RECEPCION CALIDAD </strong></div></td>
          </tr>
        </table>
        <br>
        <table width="704"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="121"><strong>Originador </strong></td>
            <td colspan="3"><strong> 
              <?php
				$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$RutF."'";
				$Resultado= mysqli_query($link, $Consulta);
				if ($Fila =mysqli_fetch_array($Resultado))
				{	
					$NombreF=$Fila["nombres"]." ".$Fila["apellido_paterno"]." ".$Fila["apellido_materno"];
				}
				echo "<div align ='left'><input name ='TxtFuncionario' type='text' readonly style='width:210' maxlength='120' value ='".$NombreF."'></div>";
	  		?>
              </strong></td>
          </tr>
          <tr> 
            <td><strong>N&deg; Solicitud</strong></td>
            <td width="223"><input name='TxtSA' type='text'  style='width:210' value='<?php  echo $TxtSA  ?>'> 
            </td>
            <td width="115"><strong>N&deg; Recargo</strong></td>
            <?php
	  if ($TxtRecargo == 'N')
	  {
	
		$TxtRecargo =' ';
	  }

	  
	  ?>
            <td width="218"><input name="TxtRecargo" type="text" style='width:210' id="TxtRecargo3" value="<?php echo $TxtRecargo ?>"></td>
          </tr>
          <tr> 
            <td><strong>N&deg; Muestra</strong></td>
            <td><strong> 
              <input name="TxtMuestra" type="text" style='width:210' id="TxtMuestra2" value="<?php  echo $TxtMuestra ?>">
              </strong></td>
            <td><strong>N&deg; Lotes</strong></td>
            <td><input name="TxtLotes" type="text" style='width:210' id="TxtLotes3" value="<?php echo $TxtLotes ?>" ></td>
          </tr>
          <tr> 
            <td><strong>Producto</strong></td>
            <td><strong> 
              <input name="TxtProductos" type="text" id="TxtProductos2" style='width:210' value="<?php echo $TxtProductos ?>">
              </strong></td>
            <td><strong>CentroCosto</strong></td>
            <td><input name="TxtCCosto" type="text" style='width:210' id="TxtCCosto3" value="<?php echo $TxtCCosto?>"></td>
          </tr>
          <tr> 
            <td><strong>Leyes</strong></td>
            <td><strong> 
              <input name="TxtLeyes" type="text" id="TxtLeyes2" style='width:210' value="<?phpecho $TxtLeyes ?>">
              </strong></td>
            <td><strong>Tipo Analisis</strong></td>
            <td>
              <?php
				$Consulta ="select distinct t2.nombre_subclase from cal_web.solicitud_analisis t1";
			  	$Consulta =$Consulta." inner join  proyecto_modernizacion.sub_clase t2 ";
			  	$Consulta =$Consulta." on t1.cod_analisis = t2.cod_subclase and t2.cod_clase = '1000'  ";
				$Consulta = $Consulta." where nro_solicitud ='".$SA."' "; 
				$Respuesta3 = mysqli_query($link, $Consulta); 
				$Fila3=mysqli_fetch_array($Respuesta3);
				$TxtAnalisis = $Fila3["nombre_subclase"];

			
			?>
              <input name="TxtAnalisis" type="text" id="TxtAnalisis" style="width:210" value="<?php  echo $TxtAnalisis  ?>"></td>
          </tr>
          <tr> 
            <td height="23"><strong>Fecha Muestreo</strong></td>
            <td><div align="left"><strong> 
                <?php
		   	$Consulta = "select fecha_hora from cal_web.estados_por_solicitud t1 ";
		   	if ($Recargo=='N')
		   	{
				$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.rut_funcionario = '".$RutF."' and cod_estado = '13' "; 
				
			}
		  	else
			{
				$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.recargo ='".$Recargo."' and t1.rut_funcionario = '".$RutF."' and cod_estado = '13'"; 
			}
			$Respuesta =mysqli_query($link, $Consulta);
			if ($Fila1=mysqli_fetch_array($Respuesta))
			{
				$TxtFechaAt = $Fila1["fecha_hora"];
			}
		  
		   ?>
                </strong> 
                <input name="TxtFechaAt" type="text" style='width:210' id="TxtFechaAt2" value="<?php echo $TxtFechaAt ?>">
              </div></td>
            <td><strong>Impurezas</strong></td>
            <td><strong>
              <input name="TxtImpurezas" type="text" style='width:210' value="<?php echo $TxtImpurezas?>">
              </strong></td>
          </tr>
          <tr> 
            <td height="23"><strong> Fecha Recepcion</strong></td>
            <td><div align="left"><strong> 
                <?php
		   	$Consulta = "select fecha_hora from cal_web.estados_por_solicitud t1 ";
		   	if ($Recargo=='N')
		   	{
				$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.rut_funcionario = '".$RutF."' and cod_estado = '4' "; 
				
			}
		  	else
			{
				$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.recargo ='".$Recargo."' and t1.rut_funcionario = '".$RutF."' and cod_estado = '13'"; 
			}
			$Respuesta =mysqli_query($link, $Consulta);
			if ($Fila1=mysqli_fetch_array($Respuesta))
			{
				$TxtFechaRe = $Fila1["fecha_hora"];
			}
		  
		   ?>
                <input name="TxtFechaC" type="text" style='width:210' value="<?php echo $TxtFechaRe ?>">
                </strong></div></td>
            <td><strong>Estado</strong></td>
            <td><strong> 
              <?php
			  	$Consulta ="select t2.nombre_subclase,t1.cod_analisis from cal_web.solicitud_analisis t1";
				$Consulta =$Consulta." inner join  proyecto_modernizacion.sub_clase t2 ";
			  	$Consulta =$Consulta." on t1.estado_actual = t2.cod_subclase and t2.cod_clase = '1002'  ";
			  	if ($Recargo=='N')
		   		{
					$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.rut_funcionario = '".$RutF."' "; 
				}
		  		else
				{
					$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.recargo ='".$Recargo."' and t1.rut_funcionario = '".$RutF."'  "; 
				}
				$Respuesta =mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta))
				{
					if ($Fila2["cod_analisis"]==1)
					{
						echo  "<input name='TxtEstado' type='text'  style='width:210's  value='".$Fila2["nombre_subclase"]." Laboratorio Quimico'>";
					}
					else
					{
						echo  "<input name='TxtEstado' type='text'  style='width:210's  value='".$Fila2["nombre_subclase"]." Ensayo Fisico'>";
					}	
				}
			  ?>
              <!--<input name="TxtEstado" type="text"  style='width:210's id="TxtEstado2" value="<?php// echo $TxtEstado ?>">-->
              </strong></td>
          </tr>
        </table>
        <br>
        <table width="703"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td><div align="center"> 
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70" onClick="JavaScript:window.close();">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>
