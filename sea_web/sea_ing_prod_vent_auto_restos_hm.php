<?php

	$TotalTara = 0;
	$PesoBruto = 0;
	$PesoNeto = 0;
	$Corr = "";
	if ($Modif=="S")
	{
		//LIMPIO VARIABLES	
		$NumCubas = "";	
		$NumCarro = "";
		$NumRack = "";			
		$ChkFin = "N";
		$PesoAuto="S";
		//-------------
		$dia = substr($FechaHora,8,2);
		$des = substr($FechaHora,5,2);
		$ano = substr($FechaHora,0,4);
		$Fecha = $ano."-".$mes."-".$dia;
		$Hora = trim(substr($FechaHora,11));
		$Grupo = intval($GrupoModif);
		$Corr = $CorrModif;
		//CONSULTO LOS DATOS DEL REGISTRO A MODIFICAR
		$Consulta = "select * from sea_web.detalle_pesaje ";
		$Consulta.= " where fecha = '".$FechaHora."'";
		$Consulta.= " and cod_producto = '".$Grupo."'";
		$Consulta.= " and cod_subproducto = '".$Corr."'";
		$Respuesta = mysqli_query($link, $Consulta);
		//echo $Consulta;
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
								
			$NumCarro = $Fila["num_carro"];
			$NumRack = $Fila["num_rack"];
			$NumCubas = $Fila["horno"];
			$PesoNeto = $Fila["peso_total"];			
			if ($Fila["estado"]=="F")
				$ChkFin = "S";
		}
		$PesoAuto="N";			
	}	
	//CONSULTA CUBAS
	$Consulta = "select distinct cod_producto, cod_subproducto, unidades, peso, fecha_carga, ";
	$Consulta.= " case when length(cod_subproducto)=1 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where tipo_pesaje = 'RHM'";
	$Consulta.= " and cod_producto = '".$Grupo."'";
	$Consulta.= " and estado = 'C'";
	$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
	$Consulta.= " order by orden";
	$Resp = mysqli_query($link, $Consulta);
	//echo $Consulta;
	$Cubas = "";
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$Cubas = $Cubas.$Fila["orden"]."-";
	}
	$Cubas = substr($Cubas,0,strlen($Cubas)-1);
	//CONSULTAS TARAS SI EXISTEN
	$PesoCarro = 0; // WSO
	$Consulta = "select * from sea_web.taras where tipo_tara='C' and numero='".$NumCarro."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$PesoCarro = $Fila["peso"];
	}
	$PesoRack=0;// WSO
	$Consulta = "select * from sea_web.taras where tipo_tara='R' and numero='".$NumRack."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$PesoRack = $Fila["peso"];
	}
	$TotalTara = $PesoCarro + $PesoRack;
	if ($PesoNeto == 0)
		$PesoBruto = 0;
	else
		$PesoBruto = $PesoNeto + $TotalTara;
	$PesoNeto = $PesoBruto - $TotalTara;
?>
<table width="95%" class="TablaDetalle" cellpadding="2" cellspacing="0">
  <tr>
    <td width="18%">Fecha Producci&oacute;n:</td>
    <td colspan="3"><font color="#000000" size="2">
      <select name="dia" style="width:50px" onChange="Proceso('R')">
        <?php			
			for ($i=1;$i<=31;$i++)
			{
				if (isset($dia))
				{
					if ($i==$dia)
						echo "<option selected value= '".$i."'>".$i."</option>";
					else
						echo "<option value='".$i."'>".$i."</option>"; 
				}
				else
				{
					if ($i==date("j"))
						echo "<option selected value= '".$i."'>".$i."</option>";
					else
						echo "<option value='".$i."'>".$i."</option>";    							
				}				
			}
	?>
      </select>
      </font> <font color="#000000" size="2">
      <select name="mes" style="width:90px" onChange="Proceso('R')">
        <?php
        $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");					
		for($i=1;$i<=12;$i++)
		{
			if (isset($mes))
			{
				if ($i==$mes)
					echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$Meses[$i-1]."</option>\n";			
			}
			else
			{
				if ($i==date("n"))
					echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$Meses[$i-1]."</option>\n";
			}
		}  			
     ?>
      </select>
      <select name="ano" style="width:60px;" onChange="Proceso('R')">
        <?php	
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
		{
			if (isset($ano))
			{
				if ($i==$ano)
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
			else
			{
				if ($i==date("Y"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		} 
?>
      </select>
	  <input type="hidden" name="Hora" value="<?php 
		if (!isset($Hora))	  
			echo date("H:i:s");
		else
			echo $Hora; 
	  ?>">
	  <?php
	  	if ($Corr == "" && $Grupo != "")
		{
			$Consulta = "select ifnull(max(cod_subproducto*1),0) as max_corr from sea_web.detalle_pesaje ";
			$Consulta.= " where cod_producto = '".$Grupo."' ";
			$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
			$Consulta.= " and estado<>'C'";			
			$Respuesta = mysqli_query($link, $Consulta);
			$Fila = mysqli_fetch_array($Respuesta);
			$Corr = $Fila["max_corr"] + 1;
		}
	  ?>	  
      <input type="hidden" name="Corr" value="<?php echo $Corr; ?>">
</font> </td><td colspan="3">&nbsp;</td>
  </tr>
  <tr class="boxcontent">
    <td><font color="#000000">Grupo:</font></td>
    <td><font color="#000000">
    <input name="Grupo" type="text" onKeyDown="TeclaPulsadaHM('BtnCubas')" onBlur="TeclaPulsadaHM('Recarga')"  value="<?php echo $Grupo; ?>" size="10" maxlength="3">
</font>
    </td>
    <td colspan="5" valign="middle">Cubas
    <input name="Cubas" type="text" id="Cubas" value="<?php echo $Cubas; ?>" size="30" readonly>
    <input name="BtnCubas" type="button" id="BtnCubas" value="Definir Cubas" onClick="Proceso('DefCubas_RestosHM')">
    &nbsp;
	<?php 
		if ($Cubas == "")
			echo "<img src='../principal/imagenes/ing_cubas.gif' width='110' height='18'>\n";
	?></td>
  </tr>
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
    <td colspan="2">&nbsp;</td>
    <td width="13%">&nbsp;</td>
  </tr>
  <tr class="boxcontent">
    <td>Carro:</td>
    <td width="12%"><input name="NumCarro" type="text" onBlur="BuscaPeso('C')" onKeyDown="TeclaPulsada('NumRack')" value="<?php echo $NumCarro; ?>" size="10"></td>
    <td colspan="2"><input name="PesoCarro" type="text" disabled onKeyDown="TeclaPulsada('NumRack')" value="<?php echo $PesoCarro; ?>" size="10">
      <img src="../principal/imagenes/ing_carro.gif" width="90" height="18" name="ImgCarro" style="visibility:hidden ">
      <input type="hidden" name="CampoActivo" value="">
        <input type="hidden" name="NuevoCarro" value="N"></td>
    <td colspan="3"><font color="#000000">
      <?php
			if($ChkFin == "S")
				echo '<input type="checkbox" name="ChkFin" value="S" checked>';
			else
				echo '<input type="checkbox" name="ChkFin" value="S">';
            
			?>
      Fin del Grupo </font></td>
  </tr>
  <tr class="boxcontent">
    <td>Rack:</td>
    <td><input name="NumRack" type="text" id="NumRack2" onBlur="BuscaPeso('R')" onKeyDown="TeclaPulsada('NumCubas')" value="<?php echo $NumRack; ?>" size="10"></td>
    <td colspan="2"><input name="PesoRack" type="text" disabled onKeyDown="TeclaPulsada('NumCubas')" value="<?php echo $PesoRack; ?>" size="10" >
      <img src="../principal/imagenes/ing_rack.gif" width="90" height="18" name="ImgRack" style="visibility:hidden ">      <input type="hidden" name="NuevoRack" value="N"></td>
    <td width="17%">&nbsp;</td>
    <td width="16%" align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="boxcontent">
    <td>Total Tara:</td>
    <td>&nbsp;</td>
    <td width="9%"><input name="TotalTara" type="text" readonly value="<?php echo $TotalTara; ?>" size="10">
    </td>
    <td width="15%" align="right">Peso Bruto:</td>
    <td><input name="PesoBruto" type="text" id="PesoBruto" onKeyDown="TeclaPulsada('BtnGuardar')" value="<?php echo $PesoBruto; ?>" size="10"></td>
    <td align="right">Peso Neto: </td>
    <td><input name="PesoNeto" type="text" disabled id="PesoNeto" value="<?php echo $PesoNeto; ?>" size="10"></td>
  </tr>
  <tr class="boxcontent">
    <td>Cantidad de Cubas:</td>
    <td><input name="NumCubas" type="text" onKeyDown="TeclaPulsada('PesoBruto')" value="<?php echo $NumCubas; ?>" size="10"></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php
	//Cant Cubas Acumulada
	$Consulta = "select distinct cod_subproducto ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where tipo_pesaje = 'RHM'";
	$Consulta.= " and cod_producto = '".$Grupo."'";
	$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
	$Consulta.= " and estado = 'C'";	
	$Resp2 = mysqli_query($link, $Consulta);
	$CantCubas = mysqli_num_rows($Resp2);
	//Peso Acumulado del Grupo
	$Consulta = "select cod_producto, sum(unidades) as unidades, sum(peso) as peso_benef, sum(peso_total) as peso_prod";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where tipo_pesaje = 'RHM'";
	$Consulta.= " and cod_producto = '".$Grupo."'";
	$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
	$Consulta.= " group by cod_producto";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$PesoAcum = $Fila["peso_prod"];
	else $PesoAcum = 0;
?>  
  <tr class="boxcontent">
    <td colspan="2" align="right"><strong>Cant. Acum. de Cubas: </strong></td>
    <td><strong><?php echo number_format($CantCubas,0,",",".");?></strong></td>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="right"><strong>Peso Acum. del Grupo:</strong></td>
    <td><strong><?php echo number_format($PesoAcum,0,",",".");?></strong></td>
  </tr>
</table>
<br>
<table width="95%" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="boxcontent">
    <td width="100%"><?php
	if ($Modif == "S")	
	{
		$FechaProd = $ano."-".$mes."-".$dia;
		//CONSULTA PARA VER SI FUE FINALIZADO EL GRUPO
		$Consulta = "select DISTINCT estado as estado from sea_web.detalle_pesaje ";
		$Consulta.= " where tipo_pesaje = 'RHM'";
		$Consulta.= " and fecha between '".$FechaProd." 00:00:00' and '".$FechaProd." 23:59:59'";
		$Consulta.= " and cod_producto = '".$Grupo."'";
		$Consulta.= " and estado = 'F'";
		//echo $Consulta."<br>";
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux = mysqli_fetch_array($RespAux))
		{
			echo "<input name='BtnGuardar' type='button' onClick=\"Proceso('M_RestosHM')\" value='Modificar' style='width:100px'>\n";
		}
		else
		{
			echo "<input name='BtnGuardar' type='button' onClick=\"Proceso('G_RestosHM')\" value='Guardar' style='width:100px'>\n";
		}
	}
	else
	{
		echo "<input name='BtnGuardar' type='button' onClick=\"Proceso('G_RestosHM')\" value='Guardar' style='width:100px'>\n";
	}
		
?>
      <font color="#000000">
      <input name="ver" type="button"  value="Ver Hornadas" onClick="Proceso('V_RestosHM')" style="width:100px">
      <input name="ver2" type="button"  value="Ver Pesadas" onClick="Proceso('V_PesadasRestosHM')" style="width:100px">
      <input name="ver22" type="button"  value="Informe" onClick="Proceso('V_InformeRestosHM')" style="width:100px">
      </font>
      <input name="BtnSalir" type="button" onClick="Proceso('S')" value="Salir" style="width:70px" ></td>
  </tr>
  <tr class="boxcontent">
    <td align="center" valign="top">      <table width="400" border="1" align="center" cellpadding="3" cellspacing="0">
        <tr align="center" class="ColorTabla01">
          <td colspan="6"><strong>PESAJE DEL DIA </strong></td>
        </tr>
        <tr align="center" class="ColorTabla01">
          <td width="50"><strong>Grupo</strong></td>
          <td width="40"><strong>Num.Cuba</strong></td>
          <td width="70"><strong>Cant.Anodos </strong></td>
          <td width="70"><strong>Peso.Benef.</strong></td>
		  <td width="70"><strong>Peso.Prod.</strong></td>
		  <td width="70"><strong>Hornada</strong></td>
        </tr>
        <?php	
	$Fecha = $ano."-".$mes."-".$dia;
	$Consulta = "select cod_producto, sum(unidades) as unidades, sum(peso) as peso_benef, sum(peso_total) as peso_prod, hornada";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where tipo_pesaje = 'RHM'";
	$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
	$Consulta.= " group by cod_producto";
	$Resp = mysqli_query($link, $Consulta);
	//echo $Consulta;
	$TotalPeso = 0;
	$TotalCubas = 0;
	$TotalUnidades = 0; //WSO
	$TotalPesoBenef = 0; // WSO
	$TotalPesoProd = 0; // WSO
	while ($Fila = mysqli_fetch_array($Resp))
	{		
		$Consulta = "select distinct cod_subproducto ";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where tipo_pesaje = 'RHM'";
		$Consulta.= " and cod_producto = '".$Fila["cod_producto"]."'";
		$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
		$Consulta.= " and estado = 'C'";
		$Resp2 = mysqli_query($link, $Consulta);
		$CantCubas = mysqli_num_rows($Resp2);
		echo "<tr align='center'>\n";
		echo "<td>".$Fila["cod_producto"]."</td>\n";
		echo "<td>".$CantCubas."</td>\n";
		echo "<td>".number_format($Fila["unidades"],0,",",".")."</td>\n";
		echo "<td>".number_format($Fila["peso_benef"],0,",",".")."</td>\n";
		echo "<td>".number_format($Fila["peso_prod"],0,",",".")."</td>\n";
		$Consulta = "select distinct hornada ";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where tipo_pesaje = 'RHM'";
		$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
		$Consulta.= " and cod_producto = '".$Fila["cod_producto"]."'";
		$Consulta.= " and estado='C'";
		$Resp2 = mysqli_query($link, $Consulta);
		$Fila2 = mysqli_fetch_array($Resp2);
		if ($Fila2["hornada"]!="" && !is_null($Fila2["hornada"]) && $Fila2["hornada"]!="0")
			echo "<td>".substr($Fila2["hornada"],6)."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "</tr>\n";
		$TotalPesoBenef = $TotalPesoBenef + $Fila["peso_benef"];
		$TotalPesoProd = $TotalPesoProd + $Fila["peso_prod"];
		$TotalUnidades = $TotalUnidades + $Fila["unidades"];
	}
?>
        <tr align="center">
          <td colspan="2"><strong>Total</strong></td>
          <td><?php echo number_format($TotalUnidades,0,",","."); ?></td>
          <td><?php echo number_format($TotalPesoBenef,0,",","."); ?></td>
		  <td><?php echo number_format($TotalPesoProd,0,",","."); ?></td>
		  <td>&nbsp;</td>
        </tr>
          </table></td>
  </tr>
</table>
<?php
	//SELECCIONA TARAS DE CARROS
	$Consulta = "select * from sea_web.taras where tipo_tara='C' order by numero";
	$Respuesta = mysqli_query($link, $Consulta);
	$Cont=0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<input type='hidden' name='Carro".$Fila["numero"]."' value='".$Fila["peso"]."'>\n";
		$Cont++;
	}
	echo "<input type='hidden' name='CantCarros' value='".$Cont."'>\n";
	//SELECCIONA TARAS DE RACKS
	$Consulta = "select * from sea_web.taras where tipo_tara='R' order by numero";
	$Respuesta = mysqli_query($link, $Consulta);
	$Cont=0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<input type='hidden' name='Rack".$Fila["numero"]."' value='".$Fila["peso"]."'>\n";
		$Cont++;
	}
	echo "<input type='hidden' name='CantRack' value='".$Cont."'>\n";
?>
<script Language="JavaScript">
	PesoAutomatico(); 
	document.formulario.NumCarro.focus();		
</script>
