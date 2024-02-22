<?php 	
	$Fecha_Hora = date("d-m-Y h:i");
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 3;
	$Rut =$CookieRut;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	switch($Proceso)
	{
		case "M":
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$Guia=substr($Datos,0,$i);
				}
			}
			$Consulta ="select *,t2.rut_chofer from pac_web.guia_despacho t1 ";
			$Consulta.=" left join pac_web.choferes t2 on t1.rut_transportista = t2.rut_transportista "; 
			$Consulta.=" where num_guia ='".$Guia."' ";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila1=mysqli_fetch_array($Respuesta);
			$NumGuia=$Fila1["num_guia"];
			$FechaGuia=$Fila1["fecha_hora"];
			if (!isset($CmbPatente))
			{
				$CmbPatente=$Fila1[nro_patente];	
			}
			if (!isset($CmbPatenteRampla))
			{
				$CmbPatenteRampla=$Fila1[nro_patente_rampla];	
			}
			if (!isset($CmbTransp))
			{
				$CmbTransp=$Fila1[rut_transportista];	
			}
			if (!isset($CmbCliente))
			{
				$CmbCliente=$Fila1[rut_cliente];	
			}
			if (!isset($CmbChofer))
			{
				$CmbChofer=$Fila1[rut_chofer];	
			}
			$CmbBrazo=$Fila1[brazo_carga];
			$CmbEstanque=$Fila1[cod_estanque];
			if (!isset($Toneladas))
			{
				$Toneladas=$Fila1[toneladas];
			}	
			$TxtMts=$Fila1[volumen_m3];
			$Observacion=$Fila1["descripcion"];
			$Ver=$Fila1[tipo_guia];
			$Correlativo=$Fila1[correlativo];
			$VUnitario=$Fila1[valor_unitario];
			break;	
	}	
?>
<html>
<head>
<script language="JavaScript">
function Calcula(Densidad)
{
	var Frm=document.FrmProceso;
	
	Frm.Toneladas.value=Math.round(Number(Frm.TxtMts.value.replace(',','.'))*Number(Densidad.replace(',','.'))*100)/100;
	return;
		
}
function Grabar(Proceso,V,C,Tipo,checkbox)//V=variable Opcion Ver ,sirve para el proceso si es camion o barco/C=Correlativo 
{
	var Frm=document.FrmProceso;
	var FechaHoraRomana="";
	
	if (Frm.NumGuia.value == "")
	{
		alert("Debe Ingresar Numero Guia");
		Frm.NumGuia.focus();
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
	}	
	if (Frm.CmbEstanque.value == "-1")
	{
		alert("Debe Seleccionar Estanque");
		Frm.CmbEstanque.focus();
		return;
	}
	if (Frm.CmbBrazo.value == "-1")
	{
		alert("Debe Seleccionar Brazo");
		Frm.CmbBrazo.focus();
		return;
	}
	if (Frm.Toneladas.value == "-1")
	{
		alert("Debe Seleccionar Toneladas");
		Frm.Toneladas.focus();
		return;
	}
	if (Frm.VUnitario.value == "")
	{
		alert("Debe Ingresar Valor Unitario");
		Frm.VUnitario.focus();
		return;
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
	var teclaCodigo = event.keyCode; 
	if ((teclaCodigo != 188 )&&(teclaCodigo != 110 )&&(teclaCodigo != 190 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
	{
		if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
}

</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" background="../principal/imagenes/fondo3.gif" marginwidth="0" marginheight="0" onLoad="document.FrmProceso.NumGuia.focus();">
<form name="FrmProceso" method="post" action="">
  <table width="700" height="250" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="700"><table width="733" border="0" cellpadding="5" class="TablaInterior">
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
					if (!isset($FechaHora))
					{
						echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
						$FechaHora=date('Y-m-d H:i');
					}
					else
					{ 
						echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
					}
				  ?>
              </strong></font></font></td>
          </tr>
          <tr>
		    <td>Transporte</td> 
            <td colspan="3"> 
              <?php
					if ($Proceso!='M')	
					{
						
						if ($Ver == 'C')
						{
							echo "<input name='RadioC' type='radio'   onClick=\"RecargaCheck('$Proceso','1');\" value='C' checked>";
						}
						else
						{
							echo "<input name='RadioC' type='radio'   onClick=\"RecargaCheck('$Proceso','1');\" value='C'>";
						}
						echo "Camion";
					}
					if ($Proceso!='M')	
					{
						echo "<font size='1'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>";
						 if ($Ver=='B')
						 {
							echo  "<input type='radio' name='RadioB' value='B' onClick=\"RecargaCheck('$Proceso','2');\" checked>";
						 }
						 else
						 {
							echo  "<input type='radio' name='RadioB' value='B' onClick=\"RecargaCheck('$Proceso','2');\">";
						 }
						 echo "Buque";
					 }
			 ?> 
			 </td>
          </tr>
          <tr> 
            <td>Num Guia</td>
            <td>
			<?php
				if ($Proceso=='M')
				{
					echo "<input name='NumGuia' type='text'  style='width:100' value=".$NumGuia.">";
				}
				else
				{
					echo "<input name='NumGuia' type='text' id='Num' style='width:100' value='$NumGuia' maxlength='10'>";
				}
			?>
			
			</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
			<?php	
				//if($Ver=='C')
				//{
					echo "<tr>";
					echo "<td width='95'>Transp.</td>";
					echo "<td><select name='CmbTransp' style='width:300' onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox');>";
					echo "<option value ='-1' selected>Seleccionar</option> ";
					$Consulta="select rut_transportista,nombre from pac_web.transportista order by nombre";
					$Respuesta=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbTransp==$Fila[rut_transportista])
						{
							echo "<option value ='$Fila[rut_transportista]' selected>$Fila[rut_transportista]&nbsp;-&nbsp;$Fila["nombre"]</option>";
						}
						else
						{
							echo "<option value ='$Fila[rut_transportista]' >$Fila[rut_transportista]&nbsp;-&nbsp;$Fila["nombre"]</option>";
						}
					}
					echo "</select><td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "</tr>";
				//}
				//else
				//{
					/*echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";*/
				//}					
			?>
		  		
          <tr> 
            <td>Cliente</td>
            <td colspan='3'> 
              <?php
				echo "<select name='CmbCliente' style='width:300' onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox');>";
				echo "<option value ='-1' selected>Seleccionar</option>";
				$Consulta="select distinct(t1.rut_cliente),t1.nombre,t1.precio_us from pac_web.clientes t1 ";
				$Consulta.=" inner join pac_web.relacion_cliente_transp t2 on t1.rut_cliente = t2.rut_cliente ";
				$Consulta.=" where t2.rut_transportista = '".$CmbTransp."' order by t1.nombre";
				$Respuesta=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbCliente == $Fila[rut_cliente])
					{
						echo "<option value ='$Fila[rut_cliente]' selected>$Fila[rut_cliente]&nbsp;-&nbsp;$Fila["nombre"]</option>";
						$VUnitario=$Fila[precio_us];
					}
					else
					{
						echo "<option value ='$Fila[rut_cliente]'>$Fila[rut_cliente]&nbsp;-&nbsp;$Fila["nombre"]</option>";
					}
				}
				echo "</select>&nbsp;";
				if ($Ver=='C')
				{
					echo "Chofer&nbsp;&nbsp;";
					echo "<select name='CmbChofer' style='width:275'>";
					echo "<option value ='-1' selected>Seleccionar</option>";
					$Consulta="select t1.rut_chofer,t1.nombre from pac_web.choferes t1 ";
					$Consulta.=" inner join pac_web.transportista t2 on t1.rut_transportista = t2.rut_transportista ";
					$Consulta.= " where t2.rut_transportista = '".$CmbTransp."' order by t1.nombre ";
					$Respuesta=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbChofer == $Fila[rut_chofer])
						{
							echo "<option value ='$Fila[rut_chofer]' selected>$Fila[rut_chofer]&nbsp;-&nbsp;$Fila["nombre"]</option>";
						}
						else
						{
							echo "<option value ='$Fila[rut_chofer]'>$Fila[rut_chofer]&nbsp;-&nbsp;$Fila["nombre"]</option>";
						}
					}
					echo "</select>";
				}
			?>
			</td>
          </tr>
          <tr> 
            <?php
			if ($Ver=='C')
			{	
				echo "<td>Patente</td>";
            }
			else
			{
				//echo "<td>Transportista</td>";
			}
			?>
			<td colspan="3"> 
              <?php
				if ($Ver =='C' )
				{
					echo "<select name='CmbPatente' onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox');>";
					echo "<option value ='-1' selected>Seleccionar</option>";
					$Consulta="select nro_patente,fecha_rev_tecnica,tipo2 from pac_web.camiones_por_transportista where rut_transportista='".$CmbTransp."' and tipo ='C' ";
					$Respuesta=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbPatente==$Fila[nro_patente])
						{
							echo "<option value =".$Fila[nro_patente]." selected >".$Fila[nro_patente]."</option>";
							$Patente=$Fila[nro_patente];
							$FechaRevTecnica=$Fila[fecha_rev_tecnica];
							$Tipo=$Fila[tipo2];
						}
						else
						{
							echo "<option value =".$Fila[nro_patente].">".$Fila[nro_patente]."</option>";
						}
					}			
					echo "</select>&nbsp;";
					if (date($FechaRevTecnica)<date('Y-m-d'))
					{
						echo "<strong>[RT:<font color='red'>".$FechaRevTecnica."</font>]&nbsp;</strong>";
					}
					else
					{
						echo "<strong>[RT:<font color='green'>".$FechaRevTecnica."</font>]&nbsp;</strong>";
					}
					echo "Patente Rampla&nbsp;&nbsp;";
					echo "<select name='CmbPatenteRampla' onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox')>";
					echo "<option value ='-1' selected>Seleccionar</option>";
					$Consulta="select nro_patente,fecha_rev_tecnica,fecha_cert_estanque from pac_web.camiones_por_transportista where rut_transportista='".$CmbTransp."' and tipo ='R' ";
					$Respuesta=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbPatenteRampla==$Fila[nro_patente])
						{
							echo "<option value =".$Fila[nro_patente]." selected >".$Fila[nro_patente]."</option>";
							$FechaRevTecnicaRampla=$Fila[fecha_rev_tecnica];
							$FechaCertEK=$Fila[fecha_cert_estanque];
						}
						else
						{
							echo "<option value =".$Fila[nro_patente].">".$Fila[nro_patente]."</option>";
						}
					}			
					echo "</select>&nbsp;&nbsp;";
					if (date($FechaRevTecnicaRampla)<date('Y-m-d'))
					{
						echo "<strong>[RT:<font color='red'>".$FechaRevTecnicaRampla."</font>]&nbsp;</strong>";
					}
					else
					{
						echo "<strong>[RT:<font color='green'>".$FechaRevTecnicaRampla."</font>]&nbsp;</strong>";
					}
					if (date($FechaCertEK)<date('Y-m-d'))
					{
						echo "<strong>[Cert-EK:<font color='red'>".$FechaCertEK."</font>]</strong>";
					}
					else
					{
						echo "<strong>[Cert-EK:<font color='green'>".$FechaCertEK."</font>]</strong>";
					}
				}
				else
				{
					/*echo "<select name='CmbTransp' style='width:300' onChange=Recarga('$Proceso','$Valores','$Ver');>";
					echo "<option value ='-1' selected>Seleccionar</option> ";
					$Consulta="select t1.rut_transportista,t1.nombre from pac_web.transportista t1 order by t1.nombre";
					$Respuesta=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbTransp==$Fila[rut_transportista])
						{
							echo "<option value ='$Fila[rut_transportista]' selected>$Fila[rut_transportista]&nbsp;-&nbsp;$Fila["nombre"]</option>";
						}
						else
						{
							echo "<option value ='$Fila[rut_transportista]' >$Fila[rut_transportista]&nbsp;-&nbsp;$Fila["nombre"]</option>";
						}
					}
					echo "</select>";*/
				}
				?>
            </td>
		  
          <tr> 
            <td>Estanque</td>
            <td><select name="CmbEstanque" onChange=Recarga('<?php echo $Proceso;?>','<?php echo $Valores;?>','<?php echo $Ver;?>')>
                <option value="-1" selected>Seleccionar</option>
                <?php
				$Consulta="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase =9001 and valor_subclase1 ='0' ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbEstanque == $Fila["cod_subclase"])
					{
						echo "<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>"; 
					}
					else
					{
						echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>"; 
					}
				}
				?>
              </select> </td>
            <td>Brazo Carga</td>
            <td><select name="CmbBrazo">
                <option value="-1">Seleccionar</option>
                <?php
				$Consulta="select nombre,codigo from pac_web.parametros where (codigo between 10 and 14)";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbBrazo==$Fila[codigo])
					{	
						echo "<option value='".$Fila[codigo]."' selected >".$Fila["nombre"]."</option>";
					}
					else
					{
						echo "<option value='".$Fila[codigo]."' >".$Fila["nombre"]."</option>";
					}
				}
				?>
              </select> </td>
          </tr>
		  
		  
		  
		   <tr>
		    <td>Proceso Automatico</td> 
            <td colspan="3"> 
              <?php
					if (($Ver == 'C') and ($checkbox=='1'))
						{
						
							echo "<input name='checkbox' type='checkbox' value='1' onClick=\"Recarga('$Proceso','$Valores','$Ver','$checkbox');\" checked>";
						}
						else
						{
							echo "<input name='checkbox' type='checkbox' value='1' onClick=\"Recarga('$Proceso','$Valores','$Ver','$checkbox');\" >";
						}
			 ?> 
			 </td>
          </tr> 
		  <tr> 
            <?php  				
				$Densidad=0;
				if (isset($CmbEstanque) and ($CmbEstanque!='-1'))
				{
					$Consulta="select valor1 from pac_web.parametros where codigo=".$CmbEstanque;
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Densidad=$Fila[valor1];						
				}	
				if (($Ver=='C') and ($checkbox=='1'))
				{ 
					if ($Tipo=='E')//CAMION ENAMI
					{
						echo "<td>Mts.cc</td>";
						echo "<td>";
						if ($Densidad==0)
						{
							echo "<input name='TxtMts' type='text' onKeyDown='TeclaPulsada()' style='width:100' value='$TxtMts' maxlength='10'>&nbsp;&nbsp;";										
						}
						else
						{
							echo "<input name='TxtMts' type='text' onBlur=\"Calcula('$Densidad');\" onKeyDown='TeclaPulsada()' style='width:100' value='$TxtMts' maxlength='10'>&nbsp;&nbsp;";				
						}
						
						if ($Toneladas=='-1')
						{
							echo "Toneledas&nbsp;<input name='Toneladas' type='text' onKeyDown='TeclaPulsada()' style='width:100' value='' maxlength='10'>";				
						}
						else
						{
							echo "Toneledas&nbsp;<input name='Toneladas' type='text' onKeyDown='TeclaPulsada()' style='width:100' value='$Toneladas' maxlength='10'>";										
						}	
					}
					else
					{   
						echo "<td>Toneladas</td>";//CAMION PARTICULAR
						echo "<td>";
						echo "<select name='Toneladas' style='width:250' onChange=Recarga('$Proceso','$Valores','$Ver','$checkbox')>";
						echo "<option value='-1' selected>Seleccionar</option>";
						if (isset($Patente))
						{   echo hola;
							if ($Proceso=='M')
							{
								$FechaActual=substr($FechaGuia,0,10);
							}
							else
							{
								$FechaActual=date("Y-m-d");
								
							}
							
								
							$FechaDesde=date( "Y-m-d", mktime(0,0,0,substr($FechaActual,5,2),substr($FechaActual,8,2)-3,substr($FechaActual,0,4)));
							$Consulta="select fecha_a,hora_a,pesont_a, folios_a from rec_web.otros_pesajes where patent_a='".$Patente."' and fecha_a between'".$FechaDesde."' and '".$FechaActual."'";
							$RespPesaje=mysqli_query($link, $Consulta);
							while ($Fila=mysqli_fetch_array($RespPesaje))
							{
								if ($Toneladas==($Fila[pesont_a]/1000))
								{
									echo "<option value='".($Fila[pesont_a]/1000)."' selected>".$Fila[fecha_a]." ".$Fila[hora_a]." Boleta:".($Fila[folios_a])." Peso:".($Fila[pesont_a]/1000)."</option>";
								}
								else
								{
									echo "<option value='".($Fila[pesont_a]/1000)."'>".$Fila.$Fila[fecha_a]." ".$Fila[hora_a]." Boleta:".($Fila[folios_a])." Peso:".($Fila[pesont_a]/1000)."</option>";								
								}	
							}
						}
						echo "</select>&nbsp;&nbsp;Mts.cc&nbsp;";
						/*poly
						
						echo "fecha act".$FechaActual;
						echo "fecha des" .$FechaDesde;
						echo "patente" .$Pantente;*/
						
						
						if ($Toneladas=='-1')
						{
							echo "<input name='TxtMts' type='text' onKeyDown='TeclaPulsada()' style='width:100' value='' maxlength='10'>";				
						}
						else
						{
							if ($Densidad==0)
							{
								$Ton="";
							}
							else
							{
								$Ton=number_format($Toneladas/str_replace(',','.',$Densidad),5);
							}
							echo "<input name='TxtMts' type='text' onKeyDown='TeclaPulsada()' style='width:100' value='$Ton' maxlength='10'>";										
						}	
					}	
				}
				else 
				{		
				   echo "<td>Mts.cc&nbsp;</td>";
				   echo "<td>";
					if ($Densidad==0)
					{
						echo "<input name='TxtMts' type='text' onKeyDown='TeclaPulsada()' style='width:100' value='$TxtMts' maxlength='10'>&nbsp;&nbsp;";				
					}
					else
					{
						echo "<input name='TxtMts' type='text' onBlur=\"Calcula('$Densidad');\" onKeyDown='TeclaPulsada()' style='width:100' value='$TxtMts' maxlength='10'>&nbsp;&nbsp;";				
					}	
					if ($Toneladas=='')
					{
						echo "Toneladas&nbsp;<input name='Toneladas' type='text' onKeyDown='TeclaPulsada()' style='width:100' value='' maxlength='10'>";				
					}
					else
					{
						echo "Toneladas&nbsp;<input name='Toneladas' type='text' onKeyDown='TeclaPulsada()' style='width:100' value='$Toneladas' maxlength='10'>";									
					}
					echo "</td>";	
				}
				echo "</td>";
			?>
		  <td>Valor Unitario</td>
            <td><input name="VUnitario" type="text" onKeyDown="TeclaPulsada()" style="width:100" value="<?php echo $VUnitario;?>" maxlength="12" readonly></td>
          </tr>
          <tr> 
            <td>Glosa</td>
			<?php
				if (!isset($Observacion))
				{
					$Consulta="select nombre from pac_web.parametros where codigo=15";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Observacion=$Fila["nombre"];
					/*if (isset($CmbEstanque) and ($CmbEstanque!='-1'))
					{
						$Consulta="select valor2 from pac_web.parametros where codigo=".$CmbEstanque;
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$Observacion=$Observacion." CONCENTRACION ".$Fila[valor2];
					}
					$Consulta="select valor1 from pac_web.parametros where codigo=16";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$NU=$Fila[valor1];
					$Observacion=$Observacion." ".$Fila[valor1]." RAMPLA ".$CmbPatenteRampla." ".$TxtMts." MTS. CUB SELLOS N�";*/
				}
			?>
            <td colspan="3"><textarea name="Observacion" cols="40" rows="5" wrap="VIRTUAL"><?php echo $Observacion; ?></textarea></td>
          </tr>
        </table>
        <br>
        <table width="733" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="713">
			  <?php
				if ((isset($FechaRevTecnica))||(isset($FechaCertEK))||(isset($FechaRevTecnicaRampla)))
				{
					if ((isset($FechaRevTecnica))&&(date($FechaRevTecnica)<date('Y-m-d')))
					{
						$Grabar='N';
						$Mens='1';
					}
					if ((isset($FechaRevTecnicaRampla))&&(date($FechaRevTecnica)<date('Y-m-d')))
					{
						$Grabar='N';
						$Mens='2';
					}
					if ((isset($FechaCertEK))&&(date($FechaCertEK)<date('Y-m-d')))
					{
						$Grabar='N';
						$Mens='2';
					}
				}	
				 if ($Grabar=='N')
				 {
					echo "<input type='button' name='BtnGrabar' value='Grabar' style='width:60' disabled>";
				 }
				 else
				 {
					echo "<input type='button' name='BtnGrabar' value='Grabar' style='width:60' onClick=Grabar('$Proceso','$Ver','$Correlativo','$Tipo','$checkbox')>";				 
				 }
			  ?>
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
			  <input type="button" name="BtnRecarga" value="Actualizar" style="width:70" onClick="Recarga('<?php echo $Proceso; ?>','<?php echo $Valores; ?>','<?php echo $Ver; ?>');">
              &nbsp; </td>
          </tr>
        </table> </td>
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
		{
			echo "alert('Fecha Revision Tecnica Vencida del Camion');";
		}
		else
		{
			echo "alert('Fecha Revision Tecnica o Certificacion de Estanque Vencida de la Rampla');";
		}	
		echo "</script>";
	}	
	if ($Mostrar=='S')
	{
			echo "<script languaje='javascript'>";
			echo "var Frm=document.FrmProceso;";
			echo "alert('Esta Guia ya existe');";
			//echo "Frm.NumGuia.focus();";
			echo "</script>";
	}
?>
