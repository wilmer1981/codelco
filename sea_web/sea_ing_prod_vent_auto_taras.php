<?php
$PesoAuto="N";

?>
<table width="95%" class="TablaDetalle" cellpadding="2" cellspacing="0">
  <tr>
    <td width="15%">Fecha Tara:</td>
    <td colspan="3"><font color="#000000" size="2">
      <SELECT name="dia" style="width:50px" onChange="Proceso('R')">
        <?php			
			for ($i=1;$i<=31;$i++)
			{
				if (isset($dia))
				{
					if ($i==$dia)
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
					else
						echo "<option value='".$i."'>".$i."</option>"; 
				}
				else
				{
					if ($i==date("j"))
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
					else
						echo "<option value='".$i."'>".$i."</option>";    							
				}				
			}
	?>
      </SELECT>
      </font> <font color="#000000" size="2">
      <SELECT name="mes" style="width:90px" onChange="Proceso('R')">
        <?php
        $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");					
		for($i=1;$i<=12;$i++)
		{
			if (isset($mes))
			{
				if ($i==$mes)
					echo "<option SELECTed value ='".$i."'>".$Meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$Meses[$i-1]."</option>\n";			
			}
			else
			{
				if ($i==date("n"))
					echo "<option SELECTed value ='".$i."'>".$Meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$Meses[$i-1]."</option>\n";
			}
		}  			
     ?>
      </SELECT>
      <SELECT name="ano" style="width:60px;" onChange="Proceso('R')">
        <?php	
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
		{
			if (isset($ano))
			{
				if ($i==$ano)
					echo "<option SELECTed value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
			else
			{
				if ($i==date("Y"))
					echo "<option SELECTed value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		} 
?>
      </SELECT>
    </font> </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr class="boxcontent">
    <td><font color="#000000">Tipo:</font></td>
    <td colspan="5"><font color="#000000">
<?php	
	switch ($TipoTara)
	{
		case "C":
			echo "<input name='TipoTara' type='radio' onClick=\"ValidaTaras('C')\" value='C' checked>Carro&nbsp;&nbsp;\n";
			echo "<input name='TipoTara' type='radio'  onClick=\"ValidaTaras('R')\" value='R'>Rack\n";
			break;
		case "R":
			echo "<input name='TipoTara' type='radio' onClick=\"ValidaTaras('C')\" value='C'>Carro&nbsp;&nbsp;\n";
			echo "<input name='TipoTara' type='radio'  onClick=\"ValidaTaras('R')\" value='R' checked>Rack\n";
			break;
		default:
			echo "<input name='TipoTara' type='radio' onClick=\"ValidaTaras('C')\" value='C' checked>Carro&nbsp;&nbsp;\n";
			echo "<input name='TipoTara' type='radio'  onClick=\"ValidaTaras('R')\" value='R'>Rack\n";
			break;
	}
?>	  
       </font>
    </td>
  </tr>
  <input type="hidden" name="TxtNumRomana" class="InputCen" value="<?php echo $ROMANA;?>" size="2" readonly >
  <tr class="boxcontent">
    <td>Peso Automatico:</td>
    <td colspan="3"><?php 
			echo "<input name='PesoAuto' type='hidden' value='".$PesoAuto."'>";
			if ($PesoAuto=="S" || $PesoAuto=="")
			{
				echo "<input name='checkpeso' type='checkbox' value='S' checked onClick='FuncPesoAuto()'>";
			}
			else
			{		
				if ($PesoAuto=="N")
					echo "<input name='checkpeso' type='checkbox' value='N' onClick='FuncPesoAuto()'>";
			}
			?></td>
    <td>&nbsp;</td>
    <td width="14%">&nbsp;</td>
  </tr>
  <tr class="boxcontent">
    <td>Numero:</td>
    <td><input name="Numero" type="text" onKeyDown="TeclaPulsada_2('PesoBruto')" value="<?php echo $Numero ?>" size="10" onBlur="BuscaFechaAnt()"></td>
    <td>&nbsp;</td>
    <td>Fecha Ultima Tara:      </td>
    <td><input name="FechaPesajeAnt" type="text" value="" size="20" readonly>
      <img src="../Principal/imagenes/nuevo.gif" width="14" height="13" name="Img" style="visibility:hidden ">
      <input type="hidden" name="Nuevo" value="N"></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="boxcontent">
    <td>Peso Actual: </td>
    <td width="12%"><input name="PesoBruto" type="text" size="10" onKeyDown="TeclaPulsada_2('BtnGuardar')"></td>
    <td width="11%">&nbsp;</td>
    <td>    Peso Anterior:    </td>
    <td><input name="PesoAnt" type="text" size="10" readonly></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="boxcontent">
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="19%" align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<table width="95%" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
    <tr align="center" class="boxcontent">
    <td colspan="4"><input name="BtnGuardar" type="button" onClick="Proceso('G_Tara')" value='Guardar' style="width:70px">      <font color="#000000" size="2">
      <input name="BtnEliminar" type="button"  value="Eliminar" onClick="Proceso('E_Tara')" style="width:70px">
      <input name="BtnVer" type="button"  value="Ver Datos" onClick="Proceso('V_Tara')" style="width:70px">
      </font>
      <input name="BtnSalir" type="button" onClick="Proceso('S')" value="Salir" style="width:70px" ></td>
  </tr>
  <tr align="center" class="boxcontent">
    <td colspan="4">&nbsp;</td>
  </tr>
<?php
	//PERIODO DE PESAJE DE RACKS Y CARROS
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '2012' and cod_subclase='1'";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Periodo = $Fila["valor_subclase1"];
	}
?>  
  <tr class="boxcontent">
    <td width="18%">Periodo de Tara:</td>
    <td width="19%"><input name="Periodo" type="text" value="<?php echo $Periodo; ?>" size="10" onKeyDown="TeclaPulsada_2('BtnGrabar')"> 
      Mes(es) </td>
    <td width="18%"><input name="BtnGrabar" type="button" value="Grabar" onClick="Proceso('G_Periodo')"></td>
    <td width="45%">&nbsp;</td>
  </tr>
</table>
<script language="javascript">
	PesoAutomatico(); 	
	document.formulario.Numero.focus();	
</script>
<?php
	//SELECCIONA TARAS DE CARROS
	$Consulta = "SELECT * from sea_web.taras where tipo_tara='C' order by numero";
	$Respuesta = mysqli_query($link, $Consulta);
	$Cont=0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$FechaPesaje = substr($Fila["fecha_pesaje"],8,2)."-".substr($Fila["fecha_pesaje"],5,2)."-".substr($Fila["fecha_pesaje"],0,4);
		echo "<input type='hidden' name='Carro".$Fila["numero"]."' value='".$FechaPesaje."".$Fila["peso"]."'>\n";
		$Cont++;
	}
	echo "<input type='hidden' name='CantCarros' value='".$Cont."'>\n";
	//SELECCIONA TARAS DE RACKS
	$Consulta = "SELECT * from sea_web.taras where tipo_tara='R' order by numero";
	$Respuesta = mysqli_query($link, $Consulta);
	$Cont=0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$FechaPesaje = substr($Fila["fecha_pesaje"],8,2)."-".substr($Fila["fecha_pesaje"],5,2)."-".substr($Fila["fecha_pesaje"],0,4);
		echo "<input type='hidden' name='Rack".$Fila["numero"]."' value='".$FechaPesaje."".$Fila["peso"]."'>\n";
		$Cont++;
	}
	echo "<input type='hidden' name='CantRack' value='".$Cont."'>\n";
?>
