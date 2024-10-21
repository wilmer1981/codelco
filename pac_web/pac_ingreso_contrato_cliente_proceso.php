<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 17;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	//$meses =array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sept","Oct","Nov","Dic");
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut=$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");

	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$Buscar  = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$BuscarContrato  = isset($_REQUEST["BuscarContrato"])?$_REQUEST["BuscarContrato"]:"";	
	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$Mostrar2 = isset($_REQUEST["Mostrar2"])?$_REQUEST["Mostrar2"]:"";

	$FechaHora   = isset($_REQUEST["FechaHora"])?$_REQUEST["FechaHora"]:"";
	$CmbCliente  = isset($_REQUEST["CmbCliente"])?$_REQUEST["CmbCliente"]:"";
	$CmbNumCuotas  = isset($_REQUEST["CmbNumCuotas"])?$_REQUEST["CmbNumCuotas"]:"";
	
	$TxtContrato  = isset($_REQUEST["TxtContrato"])?$_REQUEST["TxtContrato"]:"";
	$TxtTotalToneladas  = isset($_REQUEST["TxtTotalToneladas"])?$_REQUEST["TxtTotalToneladas"]:"";
	$CmbMesInicio  = isset($_REQUEST["CmbMesInicio"])?$_REQUEST["CmbMesInicio"]:date("m");
	$CmbAnoInicio  = isset($_REQUEST["CmbAnoInicio"])?$_REQUEST["CmbAnoInicio"]:date("Y");
	$CmbMesFinal  = isset($_REQUEST["CmbMesFinal"])?$_REQUEST["CmbMesFinal"]:date("m");
	$CmbAnoFinal  = isset($_REQUEST["CmbAnoFinal"])?$_REQUEST["CmbAnoFinal"]:date("Y");
	$CmbDia  = isset($_REQUEST["CmbDia"])?$_REQUEST["CmbDia"]:date("d");
	$CmbMes  = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno  = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");

	$TxtRef  = isset($_REQUEST["TxtRef"])?$_REQUEST["TxtRef"]:"";
	$TxtNroControl  = isset($_REQUEST["TxtNroControl"])?$_REQUEST["TxtNroControl"]:"";
	$TxtToneladas  = isset($_REQUEST["TxtToneladas"])?$_REQUEST["TxtToneladas"]:"";
    $RutCliente  = isset($_REQUEST["RutCliente"])?$_REQUEST["RutCliente"]:"";
	$Nombre  = isset($_REQUEST["Nombre"])?$_REQUEST["Nombre"]:"";
	if ($Proceso=='M')
	{
		//$RutCliente="";
		$Contrato="";
		$Datos=$Valores;
		for ($i=0;$i<=strlen($Datos);$i++)
		{
			if (substr($Datos,$i,2)=="//")
			{
				$RutContrato=substr($Datos,0,$i);
				for ($j=0;$j<=strlen($RutContrato);$j++)
				{
					if (substr($RutContrato,$j,2)=="~~")
					{
						$RutCliente=substr($RutContrato,0,$j);
						$Contrato  =substr($RutContrato,$j+2);
					}
				}						
				break;
			}
		}
		$Consulta="select t1.rut_cliente,t1.nro_contrato,t1.correlativo,t1.nro_cuotas,t1.toneladas,t1.mes_inicio,t1.mes_final,";
		$Consulta=$Consulta."t1.ano_inicio,t1.ano_final,t2.nombre,t2.referencia from pac_web.contrato_cliente t1 inner join pac_web.clientes t2 on t1.rut_cliente=t2.rut_cliente where t1.rut_cliente='".$RutCliente."' and t1.nro_contrato='".$Contrato."'";
		//echo "Consulta:".$Consulta;
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$Nombre=$Fila["nombre"];
		$TxtRef=$Fila["referencia"];
		$TxtNroControl=$Fila["correlativo"];
		$TxtContrato=$Fila["nro_contrato"];
		$TxtTotalToneladas=str_replace(".",",",$Fila["toneladas"]);
		$CmbNumCuotas=$Fila["nro_cuotas"];
		$CmbMesInicio=$Fila["mes_inicio"];
		$CmbMesFinal=$Fila["mes_final"];
		$CmbAnoInicio=$Fila["ano_inicio"];
		$CmbAnoFinal=$Fila["ano_final"];		
	}
	
?>
<html>
<head>
<script language="JavaScript">
function SoloNumeros() 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	
	if ((teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo !=9))
	{
		if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
} 
function SoloNumerosComas() 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	var CantComas =0;
	
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo !=9))
	{
		if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
} 

function Proceso(Opt,Valores)
{
	var Frm=document.FrmIngreso;
	var FechaInicio=0;
	var FechaFinal=0;
	
	switch (Opt)
	{
		case "N":
			FechaInicio=parseInt(Frm.CmbAnoInicio.value)+parseInt(Frm.CmbMesInicio.value);
			FechaFinal=parseInt(Frm.CmbAnoFinal.value)+parseInt(Frm.CmbMesFinal.value);
			if (FechaInicio>FechaFinal)
			{
				alert("Fecha Inicio debe ser Menor a Fecha Termino");
				Frm.CmbMesInicio.focus();
				return;
			}
			if (Frm.CmbCliente.value == -1 ) 
			{
				alert("Debe Seleccionar Cliente");
				Frm.CmbCliente.focus();
				return;
			}
			if (Frm.TxtContrato.value == -1 ) 
			{
				alert("Debe Ingresar Contrato");
				Frm.TxtContrato.focus();
				return;
			}
			if (Frm.TxtTotalToneladas.value == "" ) 
			{
				alert("Debe Ingresar Toneladas");
				Frm.TxtTotalToneladas.focus();
				return;
			}
			Frm.action="pac_ingreso_contrato_cliente_proceso01.php?Proceso="+Opt;
			Frm.submit();
		break;
		case "M":
			FechaInicio=parseInt(Frm.CmbAnoInicio.value)+parseInt(Frm.CmbMesInicio.value);
			FechaFinal=parseInt(Frm.CmbAnoFinal.value)+parseInt(Frm.CmbMesFinal.value);
			if (FechaInicio>FechaFinal)
			{
				alert("Fecha Inicio debe ser Menor a Fecha Termino");
				Frm.CmbMesInicio.focus();
				return;
			}
			if (Frm.TxtTotalToneladas.value == "" ) 
			{
				alert("Debe Ingresar Toneladas");
				Frm.TxtTotalToneladas.focus();
				return;
			}
			Frm.action="pac_ingreso_contrato_cliente_proceso01.php?Proceso="+Opt+"&Valores="+Valores;
			Frm.submit();
		break;
		
		case "G": 
			Frm.action= "pac_ingreso_contrato_cliente_proceso01.php?Proceso="+Opt;
	 		Frm.submit();
			break;
		case "S":
			window.close();	
			break;
	}
}
function Calcula(J)
{
	var Frm=document.FrmIngreso;
	var Suma=Number(Frm.elements[J].value)+Number(Frm.elements[J+1].value)+Number(Frm.elements[J+2].value)+Number(Frm.elements[J+3].value)+Number(Frm.elements[J+4].value)+Number(Frm.elements[J+5].value)+Number(Frm.elements[J+6].value)+Number(Frm.elements[J+7].value)+Number(Frm.elements[J+8].value)+Number(Frm.elements[J+9].value)+Number(Frm.elements[J+10].value)+Number(Frm.elements[J+11].value);
	if (Frm.elements[J-1].value < Suma)
	{
		alert("El Valor Ingresado Supera el Valor Total");
		return;
	}
	else
	{
		return;
	}
}
function Recarga(Tipo,Proceso,Valores)
{
	var Frm=document.FrmIngreso;
	switch (Tipo)
	{
		case "1":
			Frm.action="pac_ingreso_contrato_cliente_proceso.php?Buscar=S&Proceso="+Proceso+"&Valores="+Valores;	
			break;
		case "2":
			Frm.action="pac_ingreso_contrato_cliente_proceso.php?BuscarContrato=S&Buscar=S&Proceso="+Proceso+"&Valores="+Valores;
			break;	
	}
	Frm.submit();
}
var fila = 8; //Posicion Inicial de la Fila.
var col = 16;

function AgregarDetalle(Valores,Proceso)
{
	var Frm=document.FrmIngreso;
	
	if (Frm.TxtToneladas.value=="")
	{
		alert("Debe Ingresar Tonelada");
		Frm.TxtToneladas.focus();
		return;
	}
	Frm.action="pac_ingreso_contrato_cliente_proceso01.php?Proceso=A&Valores="+Valores+"&ProcesoAux="+Proceso;
	Frm.submit();
}
function BuscarDetalle(Valores,Proceso)
{
	var Frm=document.FrmIngreso;

	Frm.action="pac_ingreso_contrato_cliente_proceso01.php?Proceso=B&Valores="+Valores+"&ProcesoAux="+Proceso;
	Frm.submit();
}
function EliminarDetalle(Valores,Proceso)
{
	var Frm=document.FrmIngreso;
	var Resp="";
	
	Resp=confirm("Esta seguro de Eliminar el Dato");
	if (Resp==true)
	{
		Frm.action="pac_ingreso_contrato_cliente_proceso01.php?Proceso=ED&Valores="+Valores+"&ProcesoAux="+Proceso;
		Frm.submit();
	}	
}
function Activar(Frm)
{
	if (Frm.todos.checked == true)
		valor = true
	else valor = false;		
	pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = Frm.elements.length;
	for (i=pos; i<largo; i=i+col)
	{	
		if (Frm.elements[i].type != 'checkbox')
			return;
		else 
			Frm.elements[i].checked = valor;
	}	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0"  background='../principal/imagenes/fondo3.gif'>
<form name="FrmIngreso" method="post" action="">
 <table width="695" height="230" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td width="204" height="32" align="center" valign="top">
	  </td>
      <td width="401" align="center" valign="top"></td>
      <td width="133" align="center" valign="top"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
        <?php echo $Fecha_Hora ?> </strong>&nbsp; <strong> 
        <?php
			if ($FechaHora=="")
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
      <td colspan="3" align="center" valign="top"> <table width="685" border="0" class="TablaInterior">
          <tr> 
            <td colspan="4">&nbsp;</td>
            <td width="224"></td>
          </tr>
          <tr> 
            <td width="61" align="right">Cliente</td>
            <td colspan="4">
			<?php
				if ($Proceso=='N')
				{
					echo "<select name='CmbCliente' style='width:300' onChange=\"Recarga('1','$Proceso','$Valores');\">";
					echo "<option value='-1'>Seleccionar</option>";
					$Consulta="select rut_cliente,nombre from pac_web.clientes";	
					$Respuesta=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbCliente==$Fila["rut_cliente"])
						{
							echo "<option value = '".$Fila["rut_cliente"]."' selected>".$Fila["rut_cliente"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";	
						}
						else
						{
							echo "<option value = '".$Fila["rut_cliente"]."'>".$Fila["rut_cliente"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";	
						}
					}
					echo "</select>";
					if (isset($Buscar) && $Buscar=='S')
					{
						$Consulta = "select * from pac_web.clientes where rut_cliente='".$CmbCliente."'";
						$Respuesta=mysqli_query($link, $Consulta);
						if ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo "<input name='TxtRef' type='text' style='width:120' readonly value ='".$Fila["referencia"]."'>"; 	
						}
						else
						{
							echo "<input name='TxtRef' type='text' style='width:120' readonly>"; 
						}
						$Consulta = "select max(correlativo) as mayor from pac_web.contrato_cliente";
						$Respuesta=mysqli_query($link, $Consulta);
						if ($Fila=mysqli_fetch_array($Respuesta))
						{
							$Corr=$Fila["mayor"] +  1;
							echo "<input name='TxtNroControl' type='text' style='width:50' value ='".$Corr."' readonly>";
						}
						else
						{	
							echo "<input name='TxtNroControl' type='text' style='width:50' value = '1' readonly>";
						}
					}	
				}
				else
				{
					echo "<input type='hidden' name='TxtRutCliente' value='".$RutCliente."' style='width:80' readonly>";
					echo "<input type='text' name='TxtNombre' value='".$RutCliente."-".$Nombre."' style='width:300' readonly>";
					echo "&nbsp;<input name='TxtRef' type='text' style='width:120' value='".$TxtRef."'readonly>";
					echo "&nbsp;<input name='TxtNroControl' type='text' style='width:50' value='".$TxtNroControl."' readonly>"; 
				}
			?>
            </td>
          </tr>
          <tr> 
            <td>Nro.Cuotas</td>
			<td colspan='4'>
            <?php
					echo "<select name='CmbNumCuotas' style='width:40'>";		
					for ($i=1;$i<=12;$i++)		
					{
						if ((isset($CmbNumCuotas))&&($CmbNumCuotas==$i))
						{
							echo "<option value='$i' selected>$i</option>";
						}
						else
						{
							if ($i==1)
							{
								echo "<option value='$i' selected>$i</option>";
							}
							else
							{
								echo "<option value='$i'>$i</option>";
							}
						}		
					}
					echo "</select>&nbsp;";
					echo "&nbsp;Contrato&nbsp;";
					if ($Proceso=='M')
					{
						echo "<input name='TxtContrato' type='text' style='width:80' value='$TxtContrato' readonly>&nbsp;";
					}
					else
					{	
						echo "<input name='TxtContrato' type='text' style='width:80' value='$TxtContrato' onkeyDown='SoloNumerosComas();' maxlength='10'>&nbsp;";
					}	
					echo "&nbsp;Toneladas&nbsp;<input name='TxtTotalToneladas' type='text' style='width:80' value='$TxtTotalToneladas' onkeyDown='SoloNumerosComas();' maxlength='10'>";
			?>
		   </td>
          </tr>
          <tr> 
            <td align="right">Mes Inicio</td>
            <td colspan="4">
			  <select name="CmbMesInicio" style="width:120">
              <?php
			  	for ($i=0;$i<count($meses);$i++)
				{
					if (($CmbMesInicio!='')&&($i+1==$CmbMesInicio))
					{
						echo "<option value='".($i+1)."' selected>".$meses[$i]."</option>";
					}
					else
					{
						echo "<option value='".($i+1)."'>".$meses[$i]."</option>";
					}	
				}
			  ?>
              </select> <select name="CmbAnoInicio">
              <?php
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if (isset($CmbAnoT))
					{
						if ($i==$CmbAnoT)
						{
							echo "<option selected value ='$i'>$i</option>";
						}
						else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
					}
					else
					{
						if ($i==date("Y"))
						{
							echo "<option selected value ='$i'>$i</option>";
						}
						else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
					}		
				}
			  ?>
              </select>
              Mes Final <select name="CmbMesFinal" style="width:120">
                <?php
			  	for ($i=0;$i<count($meses);$i++)
				{
					if (($CmbMesFinal!='')&&($CmbMesFinal==$i+1))
					{
						echo "<option value='".($i+1)."' selected>".$meses[$i]."</option>\n";
					}
					else
					{
						echo "<option value='".($i+1)."'>".$meses[$i]."</option>\n";
					}	
				}
			  ?>
              </select> <select name="CmbAnoFinal">
                <?php
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if (isset($CmbAnoT))
					{
						if ($i==$CmbAnoT)
							{
								echo "<option selected value ='$i'>$i</option>";
							}
						else	
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
					}
					else
					{
						if ($i==date("Y"))
							{
								echo "<option selected value ='$i'>$i</option>";
							}
						else	
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
					}		
				}
				?>
              </select>
			  <?php 
			  	if ($Proceso=='N')
				{
					echo "<input name='BtnGrabar2' type='button' value='Grabar' style='width:60px;' onClick=\"Proceso('$Proceso','$Valores');\"></td>";
				}
				else
				{
					echo "<input name='BtnGrabar2' type='button' value='Modificar' style='width:60px;' onClick=\"Proceso('$Proceso','$Valores');\"></td>";
				} 	
			  ?>
              
          </tr>
        </table>
        <br>
        <table width="685" border="0" class="TablaInterior">
          <tr> 
            <td width="97">&nbsp;</td>
            <td width="578">Fecha:&nbsp; 
              <?php
				echo "<select name='CmbDia' id='select7' size='1' style='width:40px;'>";
				for ($i=1;$i<=31;$i++)
				{
					if ($CmbDia)
					{
						if ($i==$CmbDia)
						{
							echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{
						  echo "<option value='".$i."'>".$i."</option>";
						}
					}
					else
					{
						if ($i==date("j"))
						{
							echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{
						  echo "<option value='".$i."'>".$i."</option>";
						}
					}	
				}
				echo "</select>";
				echo "<select name='CmbMes' size='1' style='width:90px;'>";
				//for($i=1;$i<13;$i++)
				for($i=$CmbMesInicio;$i<$CmbMesFinal+1;$i++)
				{
					if ($CmbMes)
					{
						if ($i==$CmbMes)
						{
							echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
						}
						else
						{
							echo "<option value='$i'>".$meses[$i-1]."</option>\n";
						}
					
					}	
					else
					{
						if ($i==date("n"))
						{
							echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
						}
						else
						{
							echo "<option value='$i'>".$meses[$i-1]."</option>\n";
						}
					}	
				}
				echo "</select>";
				echo "<select name='CmbAno' size='1' style='width:70px;'>";
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if ($CmbAno)
					{
						if ($i==$CmbAno)
							{
								echo "<option selected value ='$i'>$i</option>";
							}
						else	
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
					}
					else
					{
						if ($i==date("Y"))
							{
								echo "<option selected value ='$i'>$i</option>";
							}
						else	
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
					}		
				}
				echo "</select>";
			?>
              <input type="button" name="BtnBuscar" value="Buscar" onClick="BuscarDetalle('<?php echo $Valores;?>','<?php echo $Proceso;?>');"> 
			  &nbsp;Ton. 
              <input type="text" name="TxtToneladas" maxlength="10" style="width:50" value='<?php echo $TxtToneladas;?>' onkeyDown="SoloNumerosComas();"> 
              <input type="button" name="BtnOk" value="OK" onClick="AgregarDetalle('<?php echo $Valores;?>','<?php echo $Proceso;?>');">
              <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="EliminarDetalle('<?php echo $Valores;?>','<?php echo $Proceso;?>')"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="685" height="20" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="60"><strong>#Mes</strong></td>
            <?php
				if ($TxtContrato!='')
				{
					$Dias=array();
					$Consulta="select distinct mid(fecha,9,2) as dia from pac_web.detalle_contrato where nro_contrato=".$TxtContrato;
					$Respuesta=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						$Dias[$Fila["dia"]][0]=$Fila["dia"];
					}
					reset($Dias);
					ksort($Dias);
					foreach($Dias as $Clave => $Valor)
					{
						echo "<td width='50'>";
						echo $Valor[0];
						echo "</td>";
					}
				}	
			?>
          </tr>
            <?php	
				if ($TxtContrato!='')
				{
					$Consulta="select distinct mid(fecha,1,7) as AnoMes from pac_web.detalle_contrato where nro_contrato=".$TxtContrato." order by AnoMes";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo "<tr>";
						reset($Dias);
						foreach($Dias as $Clave => $Valor)
						{
							$Dias[$Clave][0]="&nbsp;";				
						}
						$Mes=substr($Fila["AnoMes"],5,2);
						echo "<td width='60'>&nbsp;".$meses[$Mes-1]."</td>";
						$Consulta="select * from pac_web.detalle_contrato where nro_contrato=".$TxtContrato." and fecha between '".$Fila["AnoMes"]."-01' and '".$Fila["AnoMes"]."-31'";
						$Respuesta2 = mysqli_query($link, $Consulta);
						while ($Fila2 = mysqli_fetch_array($Respuesta2))
						{
							$Dia=substr($Fila2["fecha"],8,2);
							$Dias[$Dia][0]=str_replace(".",",",$Fila2["toneladas"]);
						}
						reset($Dias);
						foreach($Dias as $Clave => $Valor)
						{
							echo "<td width='50' align='right'>";
							echo $Valor[0];
							echo "</td>";
						}
						echo "</tr>";
					}
				}	
		?>
        </table>
        <br>
        <table width="685" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="52">&nbsp;</td>
            <td width="199">&nbsp;</td>
            <td width="239"><div align="center"> 
                <input name="BtnSalir2" type="button" id="BtnSalir" value="Salir" style="width:60px;" onClick="Proceso('S');">
              </div></td>
            <td width="245" align="center">&nbsp; </td>
          </tr>
        </table> </td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
	if ($Mostrar=='S')
	{
		echo "<script language='JavaScript'>";
		echo "var Frm=document.FrmIngreso;";
		echo "alert('Este Contrato Ya Existe');";
		echo "Frm.TxtContrato.focus();";
		echo "</script>";
	}
	if ($Mostrar2=='S')
	{
		echo "<script language='JavaScript'>";
		echo "var Frm=document.FrmIngreso;";
		echo "alert('Tonelada Ingresada supera el Total del Contrato');";
		echo "Frm.TxtToneladas.focus();";
		echo "</script>";
	}
?>

