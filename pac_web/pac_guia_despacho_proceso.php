<?php 	
	$Fecha_Hora = date("d-m-Y h:i");
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 3;
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut =$CookieRut;

	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Ver      = isset($_REQUEST["Ver"])?$_REQUEST["Ver"]:"";

	$checkbox = isset($_REQUEST["checkbox"])?$_REQUEST["checkbox"]:"";

	$dia = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
	$mes = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
	$ano = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
	$hh  = isset($_REQUEST["hh"])?$_REQUEST["hh"]:date("H");
	$mm  = isset($_REQUEST["mm"])?$_REQUEST["mm"]:date("i");

	$CmbBrazo = isset($_REQUEST["CmbBrazo"])?$_REQUEST["CmbBrazo"]:'-1';
	$NumGuia  = isset($_REQUEST["NumGuia"])?$_REQUEST["NumGuia"]:"";
	$CmbOri   = isset($_REQUEST["CmbOri"])?$_REQUEST["CmbOri"]:"";
	$CmbTransp  = isset($_REQUEST["CmbTransp"])?$_REQUEST["CmbTransp"]:"";
	$CmbCliente = isset($_REQUEST["CmbCliente"])?$_REQUEST["CmbCliente"]:"";
	$CmbChofer  = isset($_REQUEST["CmbChofer"])?$_REQUEST["CmbChofer"]:"";
	$CmbPatente = isset($_REQUEST["CmbPatente"])?$_REQUEST["CmbPatente"]:"";
	$CmbPatenteRampla = isset($_REQUEST["CmbPatenteRampla"])?$_REQUEST["CmbPatenteRampla"]:"";
	$Toneladas = isset($_REQUEST["Toneladas"])?$_REQUEST["Toneladas"]:0;
	$TxtMts    = isset($_REQUEST["TxtMts"])?$_REQUEST["TxtMts"]:"";
	$TxtCorrRomana = isset($_REQUEST["TxtCorrRomana"])?$_REQUEST["TxtCorrRomana"]:"";
	$CmbProd   = isset($_REQUEST["CmbProd"])?$_REQUEST["CmbProd"]:"";
	$VUnitario = isset($_REQUEST["VUnitario"])?$_REQUEST["VUnitario"]:"";
	$TxtObservacionAUX = isset($_REQUEST["TxtObservacionAUX"])?$_REQUEST["TxtObservacionAUX"]:"";
	$TxtObservacionFun = isset($_REQUEST["TxtObservacionFun"])?$_REQUEST["TxtObservacionFun"]:"";
	
	$CmbEstanque = isset($_REQUEST["CmbEstanque"])?$_REQUEST["CmbEstanque"]:"";
	$TxtSellos = isset($_REQUEST["TxtSellos"])?$_REQUEST["TxtSellos"]:"";

	$mostrar = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	
	

	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$Correlativo="";
	switch($Proceso)
	{
		case "M":
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
					$Guia=substr($Datos,0,$i);
			}
			$Consulta ="select *,t2.rut_chofer from pac_web.guia_despacho t1 ";
			$Consulta.=" left join pac_web.choferes t2 on t1.rut_transportista = t2.rut_transportista and t1.rut_chofer=t2.rut_chofer "; 
			$Consulta.=" where correlativo ='".$Guia."' ";
			//echo $Consulta."<br>";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila1=mysqli_fetch_array($Respuesta);
			$NumGuia=$Fila1["num_guia"];
			$FechaGuia=$Fila1["fecha_hora"];
			if (!isset($CmbPatente))
				$CmbPatente=$Fila1["nro_patente"];	
			if (!isset($CmbPatenteRampla))
				$CmbPatenteRampla=$Fila1["nro_patente_rampla"];	
			if (!isset($CmbTransp))
				$CmbTransp=$Fila1["rut_transportista"];	
			if (!isset($CmbCliente))
				$CmbCliente=$Fila1["rut_cliente"].'~'.$Fila1["corr_interno_cliente"];	
			if (!isset($CmbChofer))
				$CmbChofer=$Fila1["rut_chofer"];	
			if (!isset($CmbOri))
				$CmbOri=$Fila1["cod_originador"];	
				
			if (!isset($CmbProd))
				$CmbProd=$Fila1["cod_producto"];	
				
				 $TxtSellos=$Fila1["sellos"];	
				
			$CmbBrazo=$Fila1["brazo_carga"];
			$CmbEstanque=$Fila1["cod_estanque"];
			if (!isset($Toneladas))
				$Toneladas=$Fila1["toneladas"];
			
			$TxtMts=$Fila1["volumen_m3"];
			$TxtCorrRomana=$Fila1["corr_romana"];
			$Observacion=$Fila1["descripcion"];
			$Ver=$Fila1["tipo_guia"];
			if($Ver=='B')//BUQUE
			{
				$Consulta="select * from pac_web.movimientos where fecha_hora='".$FechaGuia."'";
				$RespMov=mysqli_query($link, $Consulta);
				while($FilaMov=mysqli_fetch_array($RespMov))
				{
					switch($FilaMov["cod_estanque_origen"])
					{
						case "1":
							$TxtEK1=$FilaMov["toneladas"];
							break;
						case "2":
							$TxtEK2=$FilaMov["toneladas"];
							break;
						case "3":
							$TxtEK3=$FilaMov["toneladas"];
							break;
						case "4":
							$TxtEK4=$FilaMov["toneladas"];
							break;
					}
				}
			}
			$Correlativo=$Fila1["correlativo"];
			$VUnitario=$Fila1["valor_unitario"];
			break;

	}	
?>
<html>
<head>
<script language="JavaScript">
function Calcula(Densidad)//METROS CUBICOS A TONELADAS
{
	var Frm=document.FrmProceso;
	
	Frm.Toneladas.value=Math.round(Number(Frm.TxtMts.value.replace(',','.'))*Number(Densidad.replace(',','.'))*100)/100;
	return;
		
}
function Calcula2(Densidad)//TONELADAS A METROS CUBICOS
{
	var Frm=document.FrmProceso;
	if(Densidad !=0)
	{
		Frm.TxtMts.value=Math.round(Number(Frm.Toneladas.value.replace(',','.'))*10000/Number(Densidad.replace(',','.')))/10000;
	}
	return;
		
}

function Grabar(Proceso,V,C,Tipo,checkbox)//V=variable Opcion Ver ,sirve para el proceso si es camion o barco/C=Correlativo 
{
	var Frm=document.FrmProceso;
	var FechaHoraRomana="";
	
	if (Frm.CmbOri.value == "-1")
	{
		alert("Debe Seleccionar Originador");
		Frm.CmbOri.focus();
		return;
	}
	if (Frm.CmbTransp.value == "-1")
	{
		alert("Debe Seleccionar Transportista");
		Frm.CmbTransp.focus();
		return;
	}
	if (Frm.CmbCliente.value == "-1")
	{
		alert("Debe Seleccionar Cliente");
		Frm.CmbCliente.focus();
		return;
	}
	if (V=='C')
	{	
		if (Frm.CmbChofer.value == "-1")
		{
			alert("Debe Seleccionar Chofer");
			Frm.CmbChofer.focus();
			return;
		}
	}	
	if (V=='C')
	{	
		if (Frm.CmbPatente.value == "-1")
		{
			alert("Debe Seleccionar Patente");
			Frm.CmbPatente.focus();
			return;
		}
		if (Frm.CmbPatenteRampla.value == "-1")
		{
			alert("Debe Seleccionar Patente Rampla");
			Frm.CmbPatenteRampla.focus();
			return;
		}
		if (Frm.CmbPatente.value==Frm.CmbPatenteRampla.value)
		{
			alert("Patente Camion debe ser distinta a Patente Rampla");
			Frm.CmbPatenteRampla.focus();
			return;
		}
		if (Frm.CmbEstanque.value == "-1")
		{
			alert("Debe Seleccionar Estanque");
			Frm.CmbEstanque.focus();
			return;
		}
		if (Frm.CmbBrazo.value == "-1")
		{
			alert("Debe Seleccionar Brazo Carga");
			Frm.CmbBrazo.focus();
			return;
		}
		if(Frm.TxtCorrRomana.value==''||Frm.TxtCorrRomana.value=='0')
		{
			alert("Correlativo Romana debe ser Ingresado");
			Frm.TxtCorrRomana.focus();
			return;
		}
		
	}	

	if (Frm.Toneladas.value == "" || Frm.Toneladas.value < 0)
	{
		alert("Debe Ingresar Toneladas (Positivas)");
		Frm.Toneladas.focus();
		return;
	}

	if (Frm.VUnitario.value == "")
	{
		alert("Debe Ingresar Valor Unitario");
		Frm.VUnitario.focus();
		return;
	}
	if (Frm.CmbProd.value == "-1")
	{
		alert("Debe Seleccionar un Producto");
		Frm.CmbProd.focus();
		return;
	}
	if (Frm.TxtSellos.value == "")
	{
		alert("Debe Ingresar Sellos, En caso contrario escribir 'NO APLICA'.");
		Frm.TxtSellos.focus();
		return;
	}
	if(Frm.TxtCliIndicador.value==1)
	{
		
		if(Frm.CmbFPago.value=='-1')
		{
			alert("Debe Seleccionar Forma de Pago.");
			Frm.CmbFPago.focus();
			return;
		}
	}
	if (Tipo=='P')
	{
	    if (checkbox=='1')
		   {
		    FechaHoraRomana=Frm.Toneladas.options[Frm.Toneladas.selectedIndex].text;	
			}
		else {FechaHoraRomana=Frm.Toneladas.text;}
	}
	
	if (Proceso=='N')
	{
		if ((V=='C')||(V=='B'))//Para que grabe en el 01 pero para Camion
		{	
			Frm.action="pac_guia_despacho_proceso01.php?Proceso="+Proceso +"&Ver="+V+"&FechaHoraRomana="+FechaHoraRomana+"&checkbox="+checkbox;
			Frm.submit();
		}
	}
	if (Proceso=='M')
	{
		Frm.action="pac_guia_despacho_proceso01.php?Proceso="+Proceso + "&Ver="+V+"&Correlativo="+C+"&FechaHoraRomana="+FechaHoraRomana+"&checkbox="+checkbox;
		Frm.submit();
	}
	if (Proceso=='GDE')
	{
		if(confirm("�Est� seguro de generar la GDE.?"))
		{
			document.getElementById("BtnGDE").disabled = true;
			Frm.action="pac_guia_despacho_proceso01.php?Proceso="+Proceso + "&Ver="+V+"&Correlativo="+C+"&FechaHoraRomana="+FechaHoraRomana+"&checkbox="+checkbox;
			Frm.submit();
			
		}
	}
}
function Salir()
{
	window.close();
}
function Recarga(Proceso,Valor,Ver,checkbox)
{
	var Frm=document.FrmProceso;
	var checkbox = chekea(checkbox);
	
	Frm.action="pac_guia_despacho_proceso.php?Proceso="+Proceso+"&Valores="+Valor+"&Ver="+Ver+"&checkbox="+checkbox;//+"&CmbEstanque="+Frm.CmbEstanque.value+"&CmbBrazo="+Frm.CmbBrazo.value+"&Observacion="+Frm.Observacion.value;
	Frm.submit();
}
function chekea(cuadro)
{
 var f=document.FrmProceso;
 if (f.checkbox.checked)
	return f.checkbox.value;
else 
	return 0;
}

function RecargaCheck (Proceso,Opc)
{
	var Frm=document.FrmProceso;
	if(Opc=='1')
	{
		Frm.action="pac_guia_despacho_proceso.php?Proceso="+Proceso + "&Ver=C";
		Frm.submit();
	}
	else
	{
		Frm.action="pac_guia_despacho_proceso.php?Proceso="+Proceso + "&Ver=B";
		Frm.submit();
	}
}

function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmProceso;
	 var code =event.keyCode,
  allowedKeys = [8, 9, 13, 27, 35,36,37,38,39,46,110, 190];
  
  if(allowedKeys.indexOf(code) > -1) {
    return;
  }
  
  if((event.shiftKey || (code < 48 || code > 57)) && (code < 96 || code > 105)) {
    event.preventDefault();
  }
}

</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" background="../principal/imagenes/fondo3.gif" marginwidth="0" marginheight="0" >
<form name="FrmProceso" method="post" action="">
	<table width="733" border="1" cellpadding="2" cellspacing="0"  class="TablaInterior">
          <tr> 
            <td colspan="4" align="left"><strong>Responsable:  
              <?php
				$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from proyecto_modernizacion.funcionarios where rut = '".$Rut."'";
			 	$Resultado= mysqli_query($link, $Consulta);
				if ($Fila =mysqli_fetch_array($Resultado))
					echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
				else
				{
					$Consulta = "select * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Respuesta))
						echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
				}
		  	  ?>
              </strong> </td></tr>
               <tr> 
              <tr>
                 <td><strong>Nro. Gu&iacute;a&nbsp;</strong></td>
                 <td><strong><?php echo $NumGuia;?></strong></td>                  
          <td>Fecha Hora Gu&iacute;a:</td>
   <td width="327"> 
<select name="dia" size="1">
	<?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		for ($i=1;$i<=31;$i++)
		{	
			if (($mostrar == "S") && ($i == $dia))			
				echo "<option selected value= '".$i."'>".$i."</option>";				
			else if (($i == date("j")) and ($mostrar != "S")) 
					echo "<option selected value= '".$i."'>".str_pad($i,2, "0",STR_PAD_LEFT)."</option>";											
			else					
				echo "<option value='".$i."'>".str_pad($i,2, "0",STR_PAD_LEFT)."</option>";												
		}		
	?>
		  </select>
		  <select name="mes" size="1" id="select">
			<?php
		for($i=1;$i<13;$i++)
		{
			if (($mostrar == "S") && ($i == $mes))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($mostrar != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
		  </select>
		  <select name="ano" size="1">
			<?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($mostrar == "S") && ($i == $ano))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($mostrar != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
		  </select>
      &nbsp; 
      <select name="hh" id="select5">
        <?php
		 	for($i=0; $i<=23; $i++)
			{
				if (($mostrar == "S") && ($i == $hh))
					echo '<option selected value ="'.$i.'">'.str_pad($i,2, "0",STR_PAD_LEFT).'</option>';
				else if (($i == date("H")) && ($mostrar != "S"))
					echo '<option selected value="'.$i.'">'.str_pad($i,2, "0",STR_PAD_LEFT).'</option>';
				else	
					echo '<option value="'.$i.'">'.str_pad($i,2, "0",STR_PAD_LEFT).'</option>';
			}
		?>
      </select>
      : 
      <select name="mm">
        <?php
		 	for($i=0; $i<=59; $i++)
			{
				if (($mostrar == "S") && ($i == $mm))
					echo '<option selected value ="'.$i.'">'.str_pad($i,2, "0",STR_PAD_LEFT).'</option>';
				else if (($i == date("i")) && ($mostrar != "S"))
					echo '<option selected value ="'.$i.'">'.str_pad($i,2, "0",STR_PAD_LEFT).'</option>';
				else	
					echo '<option value="'.$i.'">'.str_pad($i,2, "0",STR_PAD_LEFT).'</option>';
			}
		?>
      </select> &nbsp; </td>
          </tr>
     
          <tr>
		    <td   >Transporte</td> 
            <td colspan="3"> 
              <?php
					if ($Proceso!='M')	
					{
						if ($Ver == 'C')
							echo "<input name='RadioC' type='radio'   onClick=\"RecargaCheck('$Proceso','1');\" value='C' checked>";
						else
							echo "<input name='RadioC' type='radio'   onClick=\"RecargaCheck('$Proceso','1');\" value='C'>";
						echo "Camion";
					}
/*					if ($Proceso!='M')	
					{
						echo "<font size='1'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>";
						 if ($Ver=='B')
							echo  "<input type='radio' name='RadioB' value='B' onClick=\"RecargaCheck('$Proceso','2');\" checked>";
						 else
							echo  "<input type='radio' name='RadioB' value='B' onClick=\"RecargaCheck('$Proceso','2');\">";
						 echo "Buque";
					 }*/
					 if($Proceso=='M')
					 {
					 	echo "<strong>";
						if ($Ver=='B')
							echo strtoupper("Buque");
						else
							echo strtoupper("Camion");
						echo "</strong>";	
					 }
			 ?> 
			 </td>
          </tr>
          <tr>
           <td>Originador</td>
		   <td colspan="3">
			<?php	
						$txtorirut="";
						$txtorinombre="";
						$txtoridivsap="";
						$txtorialmacensap="";
						$txtorilugar="";
				echo "<select name='CmbOri'  onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox');>";
				echo "<option value ='-1' selected>Seleccionar</option> ";
				$Consulta="select * from pac_web.pac_originador";
				$Consulta.= " where activo = '1' order by cod_originador";
				$Respuesta=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbOri==$Fila["cod_originador"])
					{	echo "<option value ='".$Fila["cod_originador"]."' selected>".$Fila["rut"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
						$txtorirut=$Fila["rut"];
						$txtorinombre=$Fila["nombre"];
						$txtorilugar=$Fila["lugar"];
						$txtoridivsap=$Fila["div_sap"];
						$txtorialmacensap=$Fila["almacen_sap"];
				    }
					else{
						echo "<option value ='".$Fila["cod_originador"]."' >".$Fila["rut"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
					}
				}
				echo "</select>";
			?>
			<input type="hidden" name="txtorirut" value="<?php echo $txtorirut;?>">
			<input type="hidden" name="txtorinombre" value="<?php echo $txtorinombre;?>">
			<input type="hidden" name="txtorialmacensap" value="<?php echo $txtorialmacensap;?>">
			<input type="hidden" name="txtoridivsap" value="<?php echo $txtoridivsap;?>">
			<input type="hidden" name="txtorilugar" value="<?php echo $txtorilugar;?>">
		
		
			</td>
          </tr>
		  <tr>
		  <td>Transportista</td>
		  <td colspan="3">
			<?php			
						$TxtTranspRut="";
						$TxtTranspNombre="";
						$TxtTranspGiro="";
						/*$TxtTranspIndicador="";*/
				echo "<select name='CmbTransp' onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox');>";
				echo "<option value ='-1' selected>Seleccionar</option> ";
				$Consulta="select * from pac_web.transportista order by nombre";
				$Respuesta=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbTransp==$Fila["rut_transportista"])
					{	echo "<option value ='".$Fila["rut_transportista"]."' selected>".$Fila["rut_transportista"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
						$TxtTranspRut=$Fila["rut_transportista"];
						$TxtTranspNombre=$Fila["nombre"];
						$TxtTranspGiro=$Fila["giro_transp"];
						/*$TxtTranspIndicador=$Fila["indicador_traslado"];*/
					}
					else
						echo "<option value ='".$Fila["rut_transportista"]."' >".$Fila["rut_transportista"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
				}
				echo "</select>";
			?>
			<input type="hidden" name="TxtTranspRut" value="<?php echo $TxtTranspRut;?>">
			<input type="hidden" name="TxtTranspNombre" value="<?php echo $TxtTranspNombre;?>">
			<input type="hidden" name="TxtTranspGiro" value="<?php echo $TxtTranspGiro;?>">
			<!-- <input type="hidden" name="TxtTranspIndicador" value="<?php //echo $TxtTranspIndicador;?>"> -->
			</td>
   		  </tr>	
          <tr> 
            <td>Cliente </td>
            <td> 
              <?php
				$NombreCli="";
				$VUnitario="";
				$Direccion="";
				$ObserCliente="";
				$RutCliente="";
				$CiudadCli="";
				$DVSAP="";
				$ALMSAP="";
				$TxtCliIndicador="";
				$GiroCliente="";
				$Contrato="";
				$CorrInternoCliente="";
				echo "<select name='CmbCliente'  onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox');>";
				echo "<option value ='-1' selected>Seleccionar</option>";
				$Consulta="select distinct(t1.rut_cliente),t1.corr_interno_cliente,t1.nombre,t1.contrato,t1.precio_us,t1.direccion,t1.div_sap,t1.almacen_sap,t1.glosa,t1.ciudad,t1.indicador_traslado,t1.giro_cliente from pac_web.clientes t1 ";
				$Consulta.=" inner join pac_web.relacion_cliente_transp t2 on t1.rut_cliente = t2.rut_cliente and t1.corr_interno_cliente=t2.corr_interno_cliente";
				$Consulta.=" where t2.rut_transportista = '".$CmbTransp."' order by t1.nombre";
				$Respuesta=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbCliente == $Fila["rut_cliente"].'~'.$Fila["corr_interno_cliente"])
					{
						echo "<option value ='".$Fila["rut_cliente"]."~".$Fila["corr_interno_cliente"]."' selected>".$Fila["rut_cliente"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
						$CorrInternoCliente=$Fila["corr_interno_cliente"];
						$NombreCli=$Fila["nombre"];
						$RutCliente=$Fila["rut_cliente"];
						$CiudadCli=$Fila["ciudad"];
						$VUnitario=$Fila["precio_us"];
						$Direccion=$Fila["direccion"];
						$DVSAP=$Fila["div_sap"];
						$ALMSAP=$Fila["almacen_sap"];
						$ObserCliente=$Fila["glosa"];
						$TxtCliIndicador=$Fila["indicador_traslado"];
						$GiroCliente=$Fila["giro_cliente"];
						$Contrato=$Fila["contrato"];
					}
					else
						echo "<option value ='".$Fila["rut_cliente"]."~".$Fila["corr_interno_cliente"]."'>".$Fila["rut_cliente"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
				}
				echo "</select>";
				/*echo "Query = ".$Consulta;*/
				
			?>
			<input type="hidden" name="TxtRutCliente" value="<?php echo $RutCliente;?>">
			<input type="hidden" name="CorrInternoCliente" value="<?php echo $CorrInternoCliente;?>">
			<input type="hidden" name="TxtNombreCli" value="<?php echo $NombreCli;?>">
			<input type="hidden" name="TxtCiudadCli" value="<?php echo $CiudadCli;?>">
			<input type="hidden" name="TxtVUnitario" value="<?php echo $VUnitario;?>">
			<input type="hidden" name="TxtDireccionCli" value="<?php echo $Direccion;?>">
			<input type="hidden" name="TxtObserCliente" value="<?php echo $ObserCliente;?>">
			<input type="hidden" name="TxtDivSAp" value="<?php echo $DVSAP;?>">
			<input type="hidden" name="TxtAlmacenSap" value="<?php echo $ALMSAP;?>">
			<input type="hidden" name="TxtCliIndicador" value="<?php echo $TxtCliIndicador;?>">
			<input type="hidden" name="TxtGiroCliente" value="<?php echo $GiroCliente;?>">
			<input type="hidden" name="TxtContrato" value="<?php echo $Contrato;?>">

			</td>
            <?php
			 if ($TxtCliIndicador==1)
			{ ?>
				<td> Forma de Pago</td>
				<td>
                <select name='CmbFPago'>
              	 <option value ='-1' selected>Seleccionar</option>
             		<?php if($CmbFPago==1){
						?> <option value ='1' selected >Contado</option>
                      <option value ='2' >Credito</option>
                      <?php 
					}elseif($CmbFPago==2)
					{
						?> <option value ='1'>Contado</option>
                      	<option value ='2' selected >Credito</option>
                      <?php 
					}else
					{ ?><option value ='1'>Contado</option>
                      	<option value ='2'  >Credito</option>
						<?php
						}
					?>
                   </select>  
                   </td>
        <?php 	}
			else
			{
			?><td colspan="2"><input type="hidden" name="CmbFPago" value="3">
</td><?php
			}?>
        </tr>
		<tr>
			<td>
				Chofer
			</td>
			<td colspan="3">
		<?php
              	$RutChofer="";
              	$NombreChofer="";
				if ($Ver=='C')
				{
					//echo "Chofer&nbsp;&nbsp;";
					echo "<select name='CmbChofer' style='width:300'>";
					echo "<option value ='-1' selected>Seleccionar</option>";
					$Consulta="select t1.rut_chofer,t1.nombre from pac_web.choferes t1 ";
					$Consulta.=" inner join pac_web.transportista t2 on t1.rut_transportista = t2.rut_transportista ";
					$Consulta.= " where t2.rut_transportista = '".$CmbTransp."' order by t1.nombre ";
					$Respuesta=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbChofer == $Fila["rut_chofer"]){
							echo "<option value ='".$Fila["rut_chofer"]."' selected>".$Fila["rut_chofer"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
						$RutChofer=$Fila["rut_chofer"];
						$NombreChofer=$Fila["nombre"];
						}
						else
							echo "<option value ='".$Fila["rut_chofer"]."'>".$Fila["rut_chofer"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
					}
					echo "</select>";
				}
			?>
			<input type="hidden" name="TxtRutChofer" value="<?php echo $RutChofer;?>">
			<input type="hidden" name="TxtNombreChofer" value="<?php echo $NombreChofer;?>">
			</td>
            
<!-- 			<td>
				Almac&eacuten&nbspSAP
			</td>
			<td>	
				<input name='TxtAlmacenSap'  value="<?php //echo $ALMSAP;?>"readonly="" style="width:50px">
			</td> -->
          </tr>
          <tr> 
            <td>
			<?php
			if ($Ver=='C')
				echo "Patente";
			else
				echo "&nbsp;";
			?>
			</td>
			<td colspan="3"> 
              <?php
                $PatenteC="";
              	$PatenteR="";
				if ($Ver =='C' )
				{
					echo "<select name='CmbPatente' onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox');>";
					echo "<option value ='-1' selected>Seleccionar</option>";
					$Consulta="select nro_patente,fecha_rev_tecnica,tipo2 from pac_web.camiones_por_transportista where rut_transportista='".$CmbTransp."' and tipo ='C' ";
					$Respuesta=mysqli_query($link, $Consulta);
					$Tipo=""; //WSO
					$FechaRevTecnica="";//WSO
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbPatente==$Fila["nro_patente"])
						{
							echo "<option value =".$Fila["nro_patente"]." selected >".$Fila["nro_patente"]."</option>";
							$PatenteC=$Fila["nro_patente"];
							$FechaRevTecnica=$Fila["fecha_rev_tecnica"];
							$Tipo=$Fila["tipo2"];
						}
						else
							echo "<option value =".$Fila["nro_patente"].">".$Fila["nro_patente"]."</option>";
					}			
					echo "</select>&nbsp;";
					if (date($FechaRevTecnica)<date('Y-m-d'))
						echo "<strong>[RT:<font color='red'>".$FechaRevTecnica."</font>]&nbsp;</strong>";
					else
						echo "<strong>[RT:<font color='green'>".$FechaRevTecnica."</font>]&nbsp;</strong>";
					echo "Patente Rampla&nbsp;&nbsp;";
					echo "<select name='CmbPatenteRampla' onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox')>";
					echo "<option value ='-1' selected>Seleccionar</option>";
					$Consulta="select nro_patente,fecha_rev_tecnica,fecha_cert_estanque from pac_web.camiones_por_transportista where rut_transportista='".$CmbTransp."' and tipo ='R' ";
					$Respuesta=mysqli_query($link, $Consulta);
					$PatenteR="";//WSO
					$FechaRevTecnicaRampla="";//WSO
					$FechaCertEK="";//WSO
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbPatenteRampla==$Fila["nro_patente"])
						{
							echo "<option value =".$Fila["nro_patente"]." selected >".$Fila["nro_patente"]."</option>";
							$PatenteR=$Fila["nro_patente"];
							$FechaRevTecnicaRampla=$Fila["fecha_rev_tecnica"];
							$FechaCertEK=$Fila["fecha_cert_estanque"];
						}
						else
							echo "<option value =".$Fila["nro_patente"].">".$Fila["nro_patente"]."</option>";
					}			
					echo "</select>&nbsp;&nbsp;";
					if (date($FechaRevTecnicaRampla)<date('Y-m-d'))
						echo "<strong>[RT:<font color='red'>".$FechaRevTecnicaRampla."</font>]&nbsp;</strong>";
					else
						echo "<strong>[RT:<font color='green'>".$FechaRevTecnicaRampla."</font>]&nbsp;</strong>";
					if (date($FechaCertEK)<date('Y-m-d'))
						echo "<strong>[Cert-EK:<font color='red'>".$FechaCertEK."</font>]</strong>";
					else
						echo "<strong>[Cert-EK:<font color='green'>".$FechaCertEK."</font>]</strong>";
				}
				else
					echo "&nbsp;";
				?>

			<input type="hidden" name="TxtPatenteC" value="<?php echo $PatenteC;?>">
			<input type="hidden" name="TxtPatenteR" value="<?php echo $PatenteR;?>">
            </td>
          <tr> 
			<?php
			
				$EstanqueCB = "";
				if ($Ver =='C' )
				{
					echo "<td>Estanque</td>";
					echo "<td><select name='CmbEstanque' onChange=Recarga('$Proceso','$Valores','$Ver')>";
					echo "<option value='-1' selected>Seleccionar</option>";
					$Consulta="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase =9001 and valor_subclase1 ='0' ";
					$Respuesta=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbEstanque == $Fila["cod_subclase"]){
							echo "<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
							$EstanqueCB = $Fila["nombre_subclase"];
						}
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>"; 
					}
				    echo "</select>";
				    echo "<input type='hidden' name='TxtEstanqueCB' value='".$EstanqueCB."'>";
				    echo"</td>";
				    $BrazoCarga = "";
				    echo "<td>Brazo Carga $BrazoCarga</td>"; 
				    echo "<td><select name='CmbBrazo' onChange=Recarga('$Proceso','$Valores','$Ver')>";
				    echo "<option value='-1' selected>Seleccionar</option>";
				   $Consulta="select nombre,codigo from pac_web.parametros where (codigo between 10 and 14)";
					$Respuesta=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbBrazo==$Fila["codigo"])
						{
							echo "<option value='".$Fila["codigo"]."' selected >".$Fila["nombre"]."</option>";
							$BrazoCarga = $Fila["nombre"];
						}
						else
						{
							echo "<option value='".$Fila["codigo"]."' >".$Fila["nombre"]."</option>";
						}
					}
					if($CmbBrazo==0)
						{	 echo "<option value='0' selected>No Aplica</option>";
						
						}
						else
						{
							 echo "<option value='0'>No Aplica</option>";
							}
						
					
					echo "</select>";
				    echo "<input type='hidden' name='TxtBrazoCarga' value='".$BrazoCarga."'>";
				    echo"</td>";
				}
				else
				{
					echo "<td>Distribucion EKs</td>";
					echo "<td align='left' colspan='3'>";
					echo "EK1&nbsp;&nbsp;<input type='text' name='TxtEK1' value='$TxtEK1' size='10' onKeyDown='TeclaPulsada()' maxlength='12'>&nbsp;Ton.&nbsp;&nbsp;&nbsp;";
					echo "EK2&nbsp;&nbsp;<input type='text' name='TxtEK2' value='$TxtEK2' size='10' onKeyDown='TeclaPulsada()' maxlength='12'>&nbsp;Ton.&nbsp;&nbsp;&nbsp;";
					echo "EK3&nbsp;&nbsp;<input type='text' name='TxtEK3' value='$TxtEK3' size='10' onKeyDown='TeclaPulsada()' maxlength='12'>&nbsp;Ton.&nbsp;&nbsp;&nbsp;";
					echo "EK4&nbsp;&nbsp;<input type='text' name='TxtEK4' value='$TxtEK4' size='10' onKeyDown='TeclaPulsada()' maxlength='12'>&nbsp;Ton.";
				}   
			?>	  
          </tr>
		   <tr>
		    <td>Proceso Autom&aacute;tico</td> 
            <td colspan="3"> 
              <?php
					if (($Ver == 'C') && ($checkbox=='1'))
						echo "<input name='checkbox' type='checkbox' value='1' onClick=\"Recarga('$Proceso','$Valores','$Ver','$checkbox');\" checked>";
					else
						echo "<input name='checkbox' type='checkbox' value='1' onClick=\"Recarga('$Proceso','$Valores','$Ver','$checkbox');\" >";
			 ?>
            </td>
          </tr> 
		  <tr> 
            <?php  		
		////	echo "TxtMts ".$TxtMts."<br>";
			//echo "Estanque ".$CmbEstanque."<br>";		
				$Densidad=0;
				if ($CmbEstanque && ($CmbEstanque!='-1') && ($CmbEstanque!=''))
				{
					$Consulta="select valor1 from pac_web.parametros where codigo=".$CmbEstanque;
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Densidad=str_replace('.',',',$Fila["valor1"]);						
				}
				else
				{
					$Consulta="select valor1 from pac_web.parametros where codigo='1'";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Densidad=str_replace('.',',',$Fila["valor1"]);						
				}
			//	echo "Densidad ".$Densidad."<br>";
				if (($Ver=='C') and ($checkbox=='1'))
				{ 
					if ($Tipo=='E')//CAMION ENAMI
					{
						echo "<td>Mts.cc</td>";
						echo "<td>";
						if ($Densidad==0)
							echo "<input name='TxtMts' type='text' onKeyDown='TeclaPulsada()' style='width:80' value='$TxtMts' maxlength='10'>&nbsp;&nbsp;";										
						else
							echo "<input name='TxtMts' type='text' onBlur=\"Calcula('$Densidad');\" onKeyDown='TeclaPulsada()' style='width:80' value='$TxtMts' maxlength='10'>&nbsp;&nbsp;";				
						if ($Toneladas=='-1')
							echo "Toneladas&nbsp;<input name='Toneladas' type='text' onKeyDown='TeclaPulsada()' style='width:80' value='' maxlength='10'>";				
						else
							echo "Toneladas&nbsp;<input name='Toneladas'  type='text' onKeyDown='TeclaPulsada()' style='width:80' value='$Toneladas' maxlength='10'>";										
					}
					else
					{   
						echo "<td>Toneladas</td>";//CAMION PARTICULAR
						echo "<td>";
						echo "<select id='Toneladas' name='Toneladas' style='width:310' onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox')>";
						echo "<option value='-1' selected>Seleccionar</option>";
						if (isset($PatenteC))
						{   
							if ($Proceso=='M')
								$FechaActual=substr($FechaGuia,0,10);
							else
								$FechaActual=date("Y-m-d");
							$FechaDesde=date( "Y-m-d", mktime(0,0,0,substr($FechaActual,5,2),substr($FechaActual,8,2)-3,substr($FechaActual,0,4)));
							$Consulta="select fecha,hora_entrada,peso_neto from sipa_web.despachos where patente='".$PatenteC."' and fecha between'".$FechaDesde."' and '".$FechaActual."'";
							$RespPesaje=mysqli_query($link, $Consulta);
							while ($Fila=mysqli_fetch_array($RespPesaje))
							{
								if ($Toneladas==($Fila["peso_neto"]/1000))
									echo "<option value='".($Fila["peso_neto"]/1000)."' selected>".$Fila["fecha"]." ".$Fila["hora_entrada"]." Peso:  ".($Fila["peso_neto"]/1000)."</option>";
								else
									echo "<option value='".($Fila["peso_neto"]/1000)."'>".$Fila["fecha"]." ".$Fila["hora_entrada"]." Peso:".($Fila["peso_neto"]/1000)."</option>";								
							}
						}
						echo "</select>&nbsp;&nbsp;Mts.cc&nbsp;";
						if ($Toneladas=='-1')
							echo "<input name='TxtMts' type='text'  onKeyDown='TeclaPulsada()' style='width:80' value='' maxlength='10'>";				
						else
						{
							if ($Densidad==0)
								$Ton="";
							else
								$Ton=number_format($Toneladas/str_replace(',','.',$Densidad),5);
							echo "<input name='TxtMts' type='text' onKeyDown='TeclaPulsada()' style='width:80' value='$Ton' maxlength='10'>";										
						}	
					}	
				}
				else 
				{
					if ($Tipo=='E')//CAMION ENAMI
					{
						echo "<td>Mts.cc&nbsp;</td>";
						echo "<td>";
						if ($Densidad==0)
							echo "<input name='TxtMts' type='text' onKeyDown='TeclaPulsada()' style='width:80' value='$TxtMts' maxlength='10'>&nbsp;&nbsp;";				
						else
							echo "<input name='TxtMts' type='text' onKeyDown='TeclaPulsada()' onBlur=\"Calcula('$Densidad');\"  style='width:80' value='$TxtMts' maxlength='10'>&nbsp;&nbsp;";				
						if ($Toneladas=='')
							echo "&nbsp;&nbsp;Toneladas&nbsp;<input id='Toneladas' name='Toneladas' type='text' onKeyDown='TeclaPulsada()' style='width:80' value='' maxlength='10'>";				
						else
							echo "&nbsp;&nbsp;Toneladas&nbsp;<input id='Toneladas' name='Toneladas' type='text' onKeyDown='TeclaPulsada()' style='width:80' value='$Toneladas' maxlength='10'>";									
						echo "</td>";
					}				   
					else
					{
						echo "<td>Toneladas&nbsp;</td>";
						echo "<td>";
						echo "<input id='Toneladas' name='Toneladas' type='text' onBlur=\"Calcula2('$Densidad');\" onKeyDown='TeclaPulsada()' style='width:80' value='$Toneladas' maxlength='10'>";									
						if ($Densidad==0)
							echo "&nbsp;&nbsp;Mts.cc&nbsp;<input name='TxtMts' type='text' onKeyDown='TeclaPulsada()' style='width:80' value='$TxtMts' maxlength='10'>&nbsp;&nbsp;";				
						else
							echo "&nbsp;&nbsp;Mts.cc&nbsp;<input name='TxtMts' type='text' onKeyDown='TeclaPulsada()' style='width:80' value='$TxtMts' maxlength='10'>&nbsp;&nbsp;";				
						echo "</td>";
					}		
				}
				echo "</td>";
			?>
		  <td>Valor Unitario</td>
            <td><input name="VUnitario" type="text" onKeyDown="TeclaPulsada()" style="width:100" value="<?php echo $VUnitario;?>" maxlength="12" readonly></td>
          </tr>
		  <tr>
		  <td>Corr-Romana</td>
		  <td>
		  <?php
		  if($Proceso=='N')
		  {
			  $Consulta="select * from sipa_web.despachos where patente='".$CmbPatente."' and peso_bruto = '0' and peso_tara <> '0' and peso_neto = '0' and fecha = '".date('Y-m-d')."'";
			  $RespSipa=mysqli_query($link, $Consulta);
			 //echo $Consulta;
			  if($FilaSipa=mysqli_fetch_array($RespSipa))
				$TxtCorrRomana=$FilaSipa["correlativo"];
		  }		
		  ?>
		  <input type="text" name="TxtCorrRomana" value="<?php echo $TxtCorrRomana;?>" maxlength="8" size="9" onKeyDown="TeclaPulsada();">
		  </td>
		  <td>Producto</td>
			<td>
			<?php
				$ProductoNombre="";
              	$CodSapProducto="";
				$VarConcentracion="";
				$VarNU="";
					echo "<select name='CmbProd' onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox');>";
					echo "<option value ='-1' selected>Seleccionar</option>";
					$Consulta="select * from pac_web.pac_productos";
					$Consulta.= " where activo = '1' order by nombre";
					$Respuesta=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbProd == $Fila["cod_producto"]){
							echo "<option value ='".$Fila["cod_producto"]."' selected>".$Fila["cod_sap"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
								$ProductoNombre=$Fila["nombre"];
              					$CodSapProducto=$Fila["cod_sap"];
								$VarConcentracion=$Fila["concentracion"];
								$VarNU=$Fila["NU"];
						}
						else
							echo "<option value ='".$Fila["cod_producto"]."'>".$Fila["cod_sap"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
						
					}
					echo "</select>";
			?>
			<input type="hidden" name="TxtProductoNombre" value="<?php echo $ProductoNombre;?>">
			<input type="hidden" name="TxtCodSapProducto" value="<?php echo $CodSapProducto;?>">
			<input type="hidden" name="VarConcentracion" value="<?php echo $VarConcentracion;?>">
			<input type="hidden" name="VarNU" value="<?php echo $VarNU;?>"></td>
		  </tr>
		  <tr>
		  	<td>Sellos</td>
            <td><input type="text" name="TxtSellos" style='width:100%' value="<?php echo $TxtSellos;?>" maxlength="50"></td>
            
<!--             <td>Unidad de Medida</td>
			<td>
			<?php
/*					echo "<select name='CmbUnidad' style='width:100' onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox');>";
					echo "<option value ='-1' selected>Seleccionar</option>";
					$Consulta="select * from pac_web.pac_unidades_medida";
					$Consulta.= " where activo = '1' order by nombre";
					$Respuesta=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbUnidad == $Fila[cod_unidad]){
							echo "<option value ='$Fila[cod_unidad]' selected>$Fila["cod_sap"]&nbsp;-&nbsp;$Fila["nombre"]</option>";

								$txtCodSapUni=$Fila["cod_sap"];
								$txtUnidadNm=$Fila["nombre"];
						}
						else
							echo "<option value ='$Fila[cod_unidad]' >$Fila["cod_sap"]&nbsp;-&nbsp;$Fila["nombre"]</option>";

					}
					echo "</select>";*/
			?>
			<input type="hidden" name="txtCodSapUni" value="<?php// echo $txtCodSapUni;?>">
			<input type="hidden" name="txtUnidadNm" value="<?php //echo $txtUnidadNm;?>">			
			</td> -->
		  </tr>
          <tr> 
            <td>Observaci&oacute;n</td>
			<?php
/*				if (!isset($Observacion))
				{
					$Consulta="select nombre from pac_web.parametros where codigo=15";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Observacion=$Fila["nombre"];
				}
				*/
				
				$ObservacionAux="CONTRATO : ".$Contrato." \nCONCENTRACI&Oacute;N : ".str_replace('.',',',$VarConcentracion)."%  N.U ".$VarNU."\n";
			?>
            <td colspan="3"><textarea style="overflow:hidden;resize:none;width:300" name="TxtObservacionAUX" id="TxtObservacionAUX" readonly rows="2" scrolling="no"><?php echo $ObservacionAux; ?>
            </textarea><br>
            <input type="text" name="TxtObservacionFun" maxlength="50" style="width:300"  id="TxtObservacionFun" value="<?php echo $ObserCliente;?>">
        	</td>
           </tr>
        </table>
        <br>
        <table width="733" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="713">
			  <?php
			  $Grabar="S";//WSO
				if (($FechaRevTecnica ||$FechaCertEK) || $FechaRevTecnicaRampla)
				{
					if ($FechaRevTecnica && (date($FechaRevTecnica)<date('Y-m-d')))
					{
						$Grabar='N';
						$Mens='1';
					}
					if ($FechaRevTecnicaRampla && (date($FechaRevTecnica)<date('Y-m-d')))
					{
						$Grabar='N';
						$Mens='2';
					}
					if ( $FechaCertEK && (date($FechaCertEK)<date('Y-m-d')))
					{
						$Grabar='N';
						$Mens='2';
					}
				}	
				
				
				 if ($Grabar=='N')
					echo "<input type='button' name='BtnGrabar' value='Grabar' style='width:60' disabled>";
				 elseif($NumGuia=='')
				 {
					echo "<input type='button' name='BtnGrabar' value='Grabar' style='width:60' onClick=Grabar('$Proceso','$Ver','$Correlativo','$Tipo','$checkbox')>";			
				 }
				 else
				 {
					 	echo "<input type='button' name='BtnGrabar' value='Grabar' style='width:60' disabled>";
					}
			?>
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
			  <input type="button" name="BtnRecarga" value="Actualizar" style="width:70" onClick="Recarga('<?php echo $Proceso; ?>','<?php echo $Valores; ?>','<?php echo $Ver; ?>');">
            <?php  if ($NumGuia=='' && $Proceso=='M')
				 	echo "<input type='button' id='BtnGDE' name='BtnGDE' value='Generar GDE' style='width:100' onClick=Grabar('GDE','$Ver','$Correlativo','$Tipo','$checkbox')>";				 
				 else
					echo "<input type='button' id='BtnGDE' name='BtnGDE' value='Generar GDE' style='width:100' disabled>";
			
			  ?>&nbsp; </td>
          </tr>
        </table>
  </form>
</body>
</html>
<?php
	if ($Grabar=='N')
	{
		echo "<script languaje='javascript'>";
		if ($Mens=='1')
			echo "alert('Fecha Revision Tecnica Vencida del Camion');";
		else
			echo "alert('Fecha Revision Tecnica o Certificacion de Estanque Vencida de la Rampla');";
		echo "</script>";
	}	
	if ($Mostrar=='S')
	{
		echo "<script languaje='javascript'>";
		echo "var Frm=document.FrmProceso;";
		echo "alert('Esta Guia ya existe');";
		echo "</script>";
	}
?>