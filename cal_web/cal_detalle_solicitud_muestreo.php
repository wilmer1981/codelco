<?php
include("../principal/conectar_principal.php");

if(isset($_REQUEST["SA"])) {
	$SA = $_REQUEST["SA"];
}else{
	$SA = "";
}
if(isset($_REQUEST["RutF"])) {
	$RutF = $_REQUEST["RutF"];
}else{
	$RutF = "";
}
if(isset($_REQUEST["Muestra"])) {
	$Muestra = $_REQUEST["Muestra"];
}else{
	$Muestra = "";
}
if(isset($_REQUEST["Lotes"])) {
	$Lotes = $_REQUEST["Lotes"];
}else{
	$Lotes = "";
}
if(isset($_REQUEST["Productos"])) {
	$Productos = $_REQUEST["Productos"];
}else{
	$Productos = "";
}
if(isset($_REQUEST["Recargo"])) {
	$Recargo = $_REQUEST["Recargo"];
}else{
	$Recargo = "";
}

//Consulta que devuelve el centro de costo y las leyes asociadas a la solicitud
$Consulta ="select t3.abreviatura,t4.descripcion,t3.cod_leyes,t4.centro_costo,t3.tipo_leyes,t1.recargo "; 
$Consulta = $Consulta."from  cal_web.solicitud_analisis t1 left join cal_web.leyes_por_solicitud t2 on (t1.rut_funcionario = t2.rut_funcionario) "; 
$Consulta = $Consulta."and (t1.fecha_hora = t2.fecha_hora) and (t1.nro_solicitud = t2.nro_solicitud) and (t1.recargo = t2.recargo) ";
$Consulta = $Consulta." left join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes ";  
$Consulta = $Consulta." left join proyecto_modernizacion.centro_costo t4 on t1.cod_ccosto = t4.centro_costo "; 
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

	if (($Fila["tipo_leyes"] == '0') || ($Fila["tipo_leyes"] == '3'))
	{
		$Ley = $Ley.$Fila ["abreviatura"].'-';
	}
	if ($Fila["tipo_leyes"] == '1')
	{
		$Impurezas = $Impurezas.$Fila["abreviatura"].'-'; 
	}
}	
$TxtSA = $SA;
$TxtProductos = $Productos;
$TxtRecargo = $Recargo;
$TxtMuestra = $Muestra;
$TxtLotes = $Lotes;
$TxtCCosto = $CCosto;
$TxtLeyes = $Ley;
$TxtImpurezas = $Impurezas;
$TxtEstado = $Estado;
$TxtFechaAt =$FechaAt.' '.$HoraAt;
$fecha=$FechaC.' '.$HoraC;
$TxtFechaC = $FechaC.' '.$HoraC;
/*
//Consulta que devuelve los periodos por esa solicitud
$Consulta ="select t2.recargo,t1.cod_periodo,t3.nombre_subclase as estado, ";
$Consulta = $Consulta." t1.fecha_muestra,t1.a�o,t1.mes,t1.nro_semana ";
$Consulta = $Consulta." from cal_web.periodos_solicitud_analisis t1 ";
$Consulta = $Consulta." inner join cal_web.solicitud_analisis t2 ";
$Consulta = $Consulta." on t1.rut_funcionario = t2.rut_funcionario  ";
$Consulta = $Consulta." and t1.fecha_hora = t2.fecha_hora ";
$Consulta = $Consulta." and t1.id_muestra = t2.id_muestra ";
$Consulta = $Consulta." and t1.recargo = t2.recargo and t1.cod_periodo = t2.cod_periodo ";
$Consulta = $Consulta." inner join proyecto_modernizacion.sub_clase t3  ";
$Consulta = $Consulta." on t3.cod_subclase = t1.cod_periodo and t3.cod_clase ='2'  ";
$Consulta = $Consulta." left join proyecto_modernizacion.sub_clase t4  ";
$Consulta = $Consulta." on t1.cod_turno = t4.cod_subclase and t4.cod_clase ='1'";

if ($Recargo=='N')
{
	$Consulta = $Consulta."where t2.nro_solicitud ='".$SA."' "; 
}
else
{
	$Consulta = $Consulta."where t2.nro_solicitud ='".$SA."' and t2.recargo ='".$Recargo."' "; 
}
//echo $Consulta."<br>";
$Respuesta = mysqli_query($link, $Consulta);
if ($Fila1=mysqli_fetch_array($Respuesta))
{
	//Comienza ciclo para rescatar los valores de los periodos asociados a la solicitud  
	$P= $Fila1["cod_periodo"];
	switch ($P)
	{
	 //HOY
	case "1":
		$PeriodoH= $Fila1["estado"];
	//Semanal
	case "2":
		$PeriodoS=$Fila1["estado"].','."N� Semana"." ".$Fila1["nro_semana"];
		break;
	//Mensual
	case "3":
		$PeriodoM=$Fila1["estado"].','."Mes ".$Fila1["mes"]; 		
		break;
	}
$TxtFechaMuestra=$Fila1["fecha_muestra"];
}*/	
//Consulta que devuelve la observacion asociada al numero de solicitud
$Consulta = "select observacion,recargo,nro_solicitud from  cal_web.solicitud_analisis t1";
if ($Recargo=='N')
{
	$Consulta = $Consulta." where nro_solicitud ='".$SA."' "; 
}
else
{
	$Consulta = $Consulta." where nro_solicitud ='".$SA."' and recargo ='".$Recargo."' "; 
}
$Respuesta3 = mysqli_query($link, $Consulta); 
if ($Fila3=mysqli_fetch_array($Respuesta3))
{
	$Observacion = $Fila3["observacion"];
}
?>
<html>
<head>
<title>Detalle de Solicitudes Muestreo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmDetalle" method="post" action="">
  <table width="760"  border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="748"><table width="744"  border="0" cellpadding="3" cellspacing="0" class="ColorTabla01">
          <tr> 
            <td width="738"><div align="center"><strong>DETALLE SOLICITUDES MUESTREO</strong></div></td>
          </tr>
        </table>
        <br>
        <table width="746"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="106"><strong>Originador </strong></td>
            <td><strong> 
              <?php
			$Consulta = "select t2.nombres,t2.apellido_paterno,recargo from cal_web.solicitud_analisis t1 ";
			$Consulta = $Consulta." inner join proyecto_modernizacion.funcionarios t2 on t1.rut_funcionario = t2.rut ";
			if ($Recargo=='N')
			{
				$Consulta = $Consulta." where nro_solicitud ='".$SA."' "; 
			}
			else
			{
				$Consulta = $Consulta." where nro_solicitud ='".$SA."' and recargo ='".$Recargo."' "; 
			}
			$Respuesta4 = mysqli_query($link, $Consulta); 
			if ($Fila4=mysqli_fetch_array($Respuesta4))
			{
				$NombreFun = $Fila4["nombres"]." ".$Fila4["apellido_paterno"];
			}
		
			echo "<div align ='left'><input name ='TxtFuncionario' type='text' readonly style='width:250' maxlength='120' value ='".$NombreFun."'></div>";
	  		?>
              </strong></td>
            <td><strong>N&deg; Solicitud</strong></td>
            <td><input name='TxtSA' type='text' readonly    style='width:250' value='<?php  echo $TxtSA  ?>'></td>
          </tr>
          <tr> 
            <td><strong>Id Muestra</strong></td>
            <td width="252"><input name="TxtMuestra" type="text" readonly style='width:250' id="TxtMuestra2" value="<?php  echo $TxtMuestra ?>"> 
            </td>
            <td width="96"><strong>N&deg; Recargo</strong></td>
            <?php
			  if ($TxtRecargo =='N')
			  {
				$TxtRecargo=' ';	
			  }
			?>
            <td width="265"><strong> 
              <input name="TxtRecargo" type="text" readonly style='width:250' id="TxtRecargo" value="<?php echo $TxtRecargo ?>">
              </strong></td>
          </tr>
          <tr> 
            <td><strong>Fecha Muestra</strong></td>
            <td><strong> 
              <?php
	     	  $Consulta = "select * from cal_web.solicitud_analisis where nro_solicitud = '".$SA."' ";
			  $Respuesta41 = mysqli_query($link, $Consulta);
			  if ($Fila41=mysqli_fetch_array($Respuesta41))
			  {
			  	$TxtFechaMuestra = $Fila41["fecha_muestra"];
			  }
			  ?>
              <input name="TxtFechaMuestra" type="text" id="TxtFechaMuestra2" style='width:250' value="<?php echo $TxtFechaMuestra ?>" readonly>
              </strong></td>
            <td><strong>Agrupacion</strong></td>
            <td><strong> 
              <?php
				$Consulta ="select distinct t2.nombre_subclase from cal_web.solicitud_analisis t1";
			  	$Consulta =$Consulta." inner join  proyecto_modernizacion.sub_clase t2 ";
			  	$Consulta =$Consulta." on t1.agrupacion = t2.cod_subclase and t2.cod_clase = '1004'  ";
				$Consulta = $Consulta." where nro_solicitud ='".$SA."' "; 
				$Resp = mysqli_query($link, $Consulta); 
				$Fila25=mysqli_fetch_array($Resp);
				$TxtAgrupacion = $Fila25["nombre_subclase"];

			
			?>
              <input name="TxtAgrupacion" type="text" readonly style="width:250" value="<?php  echo $TxtAgrupacion  ?>">
              </strong></td>
          </tr>
          <tr> 
            <td><strong>Producto</strong></td>
            <td><strong> 
              <input name="TxtProductos" type="text" id="TxtProductos3" readonly style='width:250' value="<?php echo $TxtProductos ?>">
              </strong></td>
            <td><strong>CentroCosto</strong></td>
            <td><strong> 
              <input name="TxtCCosto" type="text" style='width:250'  readonly id="TxtCCosto2" value="<?php echo $TxtCCosto?>">
              </strong></td>
          </tr>
          <tr> 
            <td><strong>Leyes</strong></td>
            <td><strong> 
              <input name="TxtLeyes" type="text" id="TxtLeyes6" readonly style='width:250' value="<?phpecho $TxtLeyes ?>">
              </strong></td>
            <td><strong>Impurezas</strong></td>
            <td><strong> 
              <input name="TxtImpurezas" type="text" style='width:250' readonly value="<?php echo $TxtImpurezas?>">
              </strong></td>
          </tr>
          <tr> 
            <td height="23"><strong>Tipo Analisis</strong></td>
            <td><strong> 
              <?php
				$Consulta ="select distinct t2.nombre_subclase from cal_web.solicitud_analisis t1";
			  	$Consulta =$Consulta." inner join  proyecto_modernizacion.sub_clase t2 ";
			  	$Consulta =$Consulta." on t1.cod_analisis = t2.cod_subclase and t2.cod_clase = '1000'  ";
				$Consulta = $Consulta." where nro_solicitud ='".$SA."' "; 
				$Respuesta3 = mysqli_query($link, $Consulta); 
				$Fila3=mysqli_fetch_array($Respuesta3);
				$TxtTipoAnalisis = $Fila3["nombre_subclase"];
			?>
              <input name="TxtTipoAnalisis" type="text" id="TxtTipoAnalisis2" readonly style='width:250' value="<?phpecho $TxtTipoAnalisis ?>">
              </strong></td>
            <td><strong>Estado</strong></td>
            <td><strong> 
              <?php
			  	$Consulta ="select t2.nombre_subclase from cal_web.solicitud_analisis t1 ";
			  	$Consulta =$Consulta." inner join  proyecto_modernizacion.sub_clase t2 ";
			  	$Consulta =$Consulta." on t1.estado_actual = t2.cod_subclase and t2.cod_clase = '1002'  ";
			  	if ($Recargo=='N')
		   		{
					$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' "; 
				}
		  		else
				{
					$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.recargo ='".$Recargo."' "; 
				}
				$Respuesta =mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta))
				{
					$TxtEstado = $Fila2["nombre_subclase"]; 	
				
				}
			  ?>
              <input name="TxtEstado" type="text"  style='width:250's readonly id="TxtEstado" value="<?php echo $TxtEstado ?>">
              </strong></td>
          </tr>
          <tr> 
            <td height="24"><strong>Fecha Creacion</strong></td>
            <td><strong> 
              <?php
				$Consulta = "select fecha_hora from cal_web.estados_por_solicitud t1 ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.rut_funcionario = '".$RutF."' and cod_estado = '1' "; 
					
				}
				else
				{
					$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.recargo ='".$Recargo."' and t1.rut_funcionario = '".$RutF."' and cod_estado = '1'"; 
				}
				$Respuesta =mysqli_query($link, $Consulta);
				if ($Fila1=mysqli_fetch_array($Respuesta))
				{
					$TxtFechaC = $Fila1["fecha_hora"];
				}
			   ?>
              <input name="TxtFechaC" type="text" style='width:250' readonly value="<?php echo $TxtFechaC ?>">
              </strong></td>
            <td><strong>Fecha Recepcion</strong></td>
            <td><strong> 
              <?php
				$Consulta = "select fecha_hora from cal_web.estados_por_solicitud t1 ";
				if ($Recargo=='N')
				{
					$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.rut_funcionario = '".$RutF."' and cod_estado = '2' "; 
					
				}
				else
				{
					$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.recargo ='".$Recargo."' and t1.rut_funcionario = '".$RutF."' and cod_estado = '2'"; 
				}
				$Respuesta =mysqli_query($link, $Consulta);
				if ($Fila1=mysqli_fetch_array($Respuesta))
				{
					$TxtFechaR = $Fila1["fecha_hora"];
				}
			   ?>
              <input name="TxtFechaR" type="text" style='width:250' readonly  value="<?php echo $TxtFechaR ?>">
              </strong></td>
          </tr>
          <tr> 
            <td height="40"><strong>Fecha Atencion</strong></td>
            <td><strong> 
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
				$TxtFechaA = $Fila1["fecha_hora"];
			}
		  
		   ?>
              <input name="TxtFechaA" type="text" style='width:250' readonly  value="<?php echo $TxtFechaA ?>">
              </strong></td>
            <td><strong>Periodo</strong></td>
            <td><strong>
            <?php
			$Consulta ="select t1.cod_periodo,t1.fecha_muestra,t1.a�o,t1.mes,t1.nro_semana,t2.nombre_subclase as estado from cal_web.solicitud_analisis t1 ";
			$Consulta =$Consulta." inner join proyecto_modernizacion.sub_clase t2 on t1.cod_periodo = t2.cod_subclase and cod_clase = 2  "; 
			$Consulta =$Consulta. " where t1.nro_solicitud = '".$SA."' ";
			$Respuesta40 =mysqli_query($link, $Consulta);
			if ($Fila40=mysqli_fetch_array($Respuesta40))  
			{
				switch ($Fila40["cod_periodo"])
				{
				//HOY
				case "1":
					$PeriodoH= $Fila40["estado"];
					echo "<input name='TxtPeriodoSemanal' type='text' readonly style='width:250' value='".$PeriodoH."' >";
					break;	
				//Semanal
				case "2":
					$PeriodoS=$Fila40["estado"].','."N� Semana"." ".$Fila40["nro_semana"];
					echo "<input name='TxtPeriodoSemanal' type='text' readonly style='width:250' value='".$PeriodoS."' >";
					break;
				//Mensual
				case "3":
					$PeriodoM=$Fila40["estado"].','."Mes ".$Fila40["mes"]; 		
					echo "<input name='TxtMensual' type='text' readonly style='width:250' value='".$PeriodoM."' >";
					break;
				//Turno
				case "4":
				 	$PeriodoT=$Fila40["estado"];
					echo "<input name='TxtMensual' type='text' readonly style='width:250' value='".$PeriodoT."' >";
					break;
				//Quincenal
				case "5":
					$PeriodoQ=$Fila40["estado"];
					echo "<input name='TxtMensual' type='text' readonly style='width:250' value='".$PeriodoQ."' >";
					break;
				}
			}
			?>   </strong></td>
          </tr>
          <tr> 
            <td height="40"><strong>Estados</strong></td>
            <td><strong>
              <?php
			  	$Consulta ="select t2.nombre_subclase from cal_web.estados_por_solicitud t1 ";
			  	$Consulta =$Consulta." inner join  proyecto_modernizacion.sub_clase t2 ";
			  	$Consulta =$Consulta." on t1.cod_estado = t2.cod_subclase and t2.cod_clase = '1002'  ";
			  	if ($Recargo=='N')
		   		{
					$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.rut_funcionario = '".$RutF."' and (t1.cod_estado between '50' and '55')"; 
				}
		  		else
				{
					$Consulta = $Consulta."where t1.nro_solicitud ='".$SA."' and t1.recargo ='".$Recargo."' and t1.rut_funcionario = '".$RutF."' and (t1.cod_estado between '50' and '55')"; 
				}
				$Respuesta =mysqli_query($link, $Consulta);
				while ($Fila2=mysqli_fetch_array($Respuesta))
				{
					$Estados = $Estados.$Fila2["nombre_subclase"].'-'; 	
				
				}
			  
			  $Estados = substr($Estados,0,strlen-1);
	           echo "<textarea name='TxtEstado' readonly='readonly' style='width:250'>";
			   echo $Estados;
			  echo "</textarea>";
			  ?>
              </strong></td>
            <td><strong>Observacion </strong></td>
            <td><textarea name="textarea" readonly="readonly"  style="width:250" ><?php  echo $Observacion   ?></textarea></td>
          </tr>
		   <?php
			$Consulta = "select * from cal_web.solicitud_analisis where nro_solicitud = '".$SA."' ";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($Fila["recargo"]=='R')
				{
					$TxtRetalla=$Fila["peso_muestra"]; 
					$TxtTamiz=$Fila["peso_retalla"];
					echo "<tr>";
           			 	echo "<td height='24'><strong>Peso Retalla</strong></td>";
            			echo "<td><strong>";
          				echo "<input name='TxtRetalla' type='text' readonly  style='width:250' value=' $TxtRetalla'>";
              			echo "</strong></td>";
            			echo "<td><strong>Peso Tamiz</strong></td>";
            			echo "<td><strong>";
              			echo "<input name='TxtTamiz' type='text' readonly  style='width:250' value='$TxtTamiz'>";
              			echo "</strong> </td>";
          			echo "</tr>";
				}
			}
			?>
		  
        </table>
        <br>
        <table width="745"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td width="736" height="26"><div align="center">
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70" onClick="JavaScript:window.close();">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p>&nbsp; </p>
  <p>&nbsp;</p>
</form>
</body>
</html>
