<?php	
	$HoraAux=date('G');
	$MinAux=date('i');
	if(!isset($Hora))
	{
		if(intval($HoraAux)>=0&&intval($HoraAux)<8)
		{
			$Hora="07";
			$Minutos="59";
		}
		if(intval($HoraAux)>=8&&intval($HoraAux)<16)
		{
			$Hora="15";
			$Minutos="59";
		}
		if(intval($HoraAux)>=16&&intval($HoraAux)<=23)
		{
			$Hora="23";
			$Minutos="59";
		}
	}	






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
		$mes = substr($FechaHora,5,2);
		$ano = substr($FechaHora,0,4);
		$Fecha = $ano."-".$mes."-".$dia;
		$Hora = trim(substr($FechaHora,11));
		
		$Grupo = intval($GrupoModif);
		$Lado = $LadoModif;
		//CONSULTO LOS DATOS DEL REGISTRO A MODIFICAR
		$Consulta = "SELECT * from sea_web.detalle_pesaje ";
		$Consulta.= " where fecha = '".$FechaHora."'";
		$Consulta.= " and cod_producto = '".$Grupo."'";
		$Consulta.= " and cod_subproducto = '".$Lado."'";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
								
			$NumCarro = $Fila["num_carro"];
			$NumRack = $Fila["num_rack"];
			$NumCubas = $Fila["horno"];
			$PesoNeto = $Fila["peso_total"];
			$FechaCarga = $Fila["fecha_carga"];
			if ($Fila["estado"]=="F")
				$ChkFin = "S";
		}
		$PesoAuto="N";		
		/*$TotalTara = $PesoCarro + $PesoRack;
		$PesoBruto = $PesoNeto + $TotalTara;
		$PesoNeto = $PesoBruto - $TotalTara;*/
		$Grupo = intval($Grupo);
		//Obtiene el lado cargado (Mar  Tierra) del grupo seleccionado. (el mas antiguo).
		$Consulta = "SELECT campo1, fecha_movimiento ";
		$Consulta.= " FROM sea_web.movimientos ";
		$Consulta.= " WHERE tipo_movimiento = 2 ";
		$Consulta.= " AND campo1 = '".$Lado."' ";
		$Consulta.= " AND campo2 = '".$Grupo."' ";
		$Consulta.= " AND fecha_movimiento = '".$FechaCarga."' ";		
		$Consulta.= " ORDER BY fecha_movimiento ASC";
		$Resp = mysqli_query($link, $Consulta);
		$Fila = mysqli_fetch_array($Resp);			
		$FechaCarga = $Fila["fecha_movimiento"];							
		//Obtiene los codigos que representan a los Anodos Ctes.
		$Parametros = "";
		$UnidCorr = 0;
		$PesoCorr = 0;
		$Consulta = "SELECT valor_subclase1 AS valor ";
		$Consulta.= " FROM proyecto_modernizacion.sub_clase ";
		$Consulta.= " WHERE cod_clase = 2002";			
		$Resp = mysqli_query($link, $Consulta);						
		while ($Fila = mysqli_fetch_array($Resp))
		{
			//Obtiene las unidades de los Anodos Ctes y su peso.
			$Consulta = "SELECT IFNULL(SUM(unidades),0) AS unidadesmov, IFNULL(SUM(peso),0) AS peso ";
			$Consulta.= " FROM sea_web.movimientos ";
			$Consulta.= " WHERE tipo_movimiento = 2 ";
			$Consulta.= " AND cod_producto = 17";
			$Consulta.= " AND campo2 = '".$Grupo."' ";
			$Consulta.= " AND campo1 = '".$Lado."' ";
			$Consulta.= " AND cod_subproducto = ".$Fila["valor"];			
			$Consulta.= " AND fecha_movimiento = '".$FechaCarga."'";
			$Resp1 = mysqli_query($link, $Consulta);
			$Fila1 = mysqli_fetch_array($Resp1);						
			//Genera los parametros.
			$Parametros = $Parametros.$Fila["valor"]."-".$Fila1["unidadesmov"]."-".$Fila1["peso"]."/";			
			$PesoCorr = $PesoCorr + $Fila1["peso"];
			$UnidCorr = $UnidCorr + $Fila1["unidadesmov"];		
		}		
		//Saco el FACTOR asociado al grupo.		
		$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase ";
		$Consulta.= " WHERE cod_clase = 2004 AND cod_subclase = '".$Grupo."'";
		$Resp = mysqli_query($link, $Consulta);			
		$Fila = mysqli_fetch_array($Resp);			
		$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase ";
		$Consulta.= " WHERE cod_clase = 2003 AND cod_subclase = ".$Fila["valor_subclase1"];
		$Resp = mysqli_query($link, $Consulta);
		$Fila = mysqli_fetch_array($Resp);		
		$ValorFactor = $Fila["valor_subclase1"];
		//CODIGOS H.M.
		$Consulta = "SELECT valor_subclase2 FROM proyecto_modernizacion.sub_clase ";
		$Consulta.= " WHERE cod_clase = 2002"; //Colunma de H.M.
		$Resp = mysqli_query($link, $Consulta);					
		$ValoresHM = "";
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$ValoresHM = $ValoresHM.$Fila["valor_subclase2"].","; 
		}
		$ValoresHM = substr($ValoresHM,0,strlen($ValoresHM)-1);					
		//Obtiene la hornada y las unidades de los Anodos Restos H.M.
		$UnidHM = 0;
		$PesoHM = 0;
		$Consulta = "SELECT IFNULL(SUM(unidades),0) AS unidadesmov, IFNULL(SUM(peso),0) AS peso ";
		$Consulta.= " FROM sea_web.movimientos ";
		$Consulta.= " WHERE tipo_movimiento = 2 ";
		$Consulta.= " AND cod_producto = 19";
		$Consulta.= " AND cod_subproducto in (".$ValoresHM.") ";
		$Consulta.= " AND campo2 = '".$Grupo."' ";
		$Consulta.= " AND campo1 = '".$Lado."'";
		$Consulta.= " AND fecha_movimiento = '".$FechaCarga."'";	
		//echo $Consulta;		
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$UnidHM = $Fila["unidadesmov"];
			$PesoHM = $Fila["peso"];
		}					
	}	
	//CONSULTAS TARAS SI EXISTEN
	
	$Consulta = "SELECT * from sea_web.taras where tipo_tara='C' and numero='".$NumCarro."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$PesoCarro = $Fila["peso"];
	}
	$Consulta = "SELECT * from sea_web.taras where tipo_tara='R' and numero='".$NumRack."'";
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

<input name="Parametros"   type="hidden" value="<?php echo $Parametros; ?>">
<table width="95%" class="TablaDetalle" cellpadding="2" cellspacing="0">
  <tr>
    <td width="18%">Fecha Producci&oacute;n:</td>
    <td colspan="8"><font color="#000000" size="2">
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
      </font><font color="#000000" size="2">
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
	
               </SELECT>
            <font size="1"><font size="2">
            <SELECT name="Hora">
			<option value="S">S</option>
              <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($Hora))
					{	
						if ($Hora == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
            </SELECT><strong>:</strong>
            <SELECT name="Minutos">
			<option value="S">S</option>
              <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($Minutos))
					{	
						if ($Minutos == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
            </SELECT>
            </font></font></td>
          </tr>
		  





  <tr class="boxcontent">
    <td><font color="#000000">Grupo:</font></td>
    <td><font color="#000000">
    <input name="Grupo" value="<?php echo $Grupo; ?>" type="text" size="10" maxlength="3" onKeyDown="TeclaPulsada('BtnBuscar')">
    </font>
    </td>
    <td colspan="2">Lado:<font color="#000000">
      <input name="Lado" value="<?php echo $Lado; ?>" type="text" size="10" maxlength="3" readonly>
    </font>    <input name="BtnBuscar" type="button" id="BtnBuscar" value="OK" onClick="Proceso('B_RestosAnodos')"></td>
    <td colspan="3">&nbsp;</td>
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
    <td width="14%">&nbsp;</td>
  </tr>
  <tr class="boxcontent">
    <td>N&deg; Carro:</td>
    <td width="12%"><input name="NumCarro" type="text" onBlur="BuscaPeso('C')" onKeyDown="TeclaPulsada('NumRack')" value="<?php echo $NumCarro; ?>" size="10"></td>
    <td colspan="2"><input name="PesoCarro" type="text" disabled onKeyDown="TeclaPulsada('NumRack')" value="<?php echo $PesoCarro; ?>" size="10">
        <img src="../principal/imagenes/ing_carro.gif" width="90" height="18" name="ImgCarro" style="visibility:hidden ">      <input type="hidden" name="CampoActivo" value="">
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
    <td>N&deg; Rack:</td>
    <td><input name="NumRack" type="text" id="NumRack2" onBlur="BuscaPeso('R')" onKeyDown="TeclaPulsada('NumCubas')" value="<?php echo $NumRack; ?>" size="10"></td>
    <td colspan="2"><input name="PesoRack" type="text" disabled onKeyDown="TeclaPulsada('NumCubas')" value="<?php echo $PesoRack; ?>" size="10" >
        <img src="../principal/imagenes/ing_rack.gif" width="90" height="18" name="ImgRack" style="visibility:hidden ">      <input type="hidden" name="NuevoRack" value="N"></td>
    <td width="16%">&nbsp;</td>
    <td width="15%" align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </tr>
  <tr class="boxcontent">
    <td>Total Tara:</td>
    <td>&nbsp;</td>
    <td width="9%"><input name="TotalTara" type="text" value="<?php echo $TotalTara; ?>" size="10" readonly>
    </td>
    <td width="16%" align="right">Peso Bruto:</td>
    <td><input name="PesoBruto" type="text" id="PesoBruto" onKeyDown="TeclaPulsada('BtnGuardar')" value="<?php echo $PesoBruto; ?>" size="10"></td>
    <td align="right">Peso Neto: </td>
    <td><input name="PesoNeto" type="text" readonly id="PesoNeto" value="<?php echo $PesoNeto; ?>" size="10"></td>
  <tr class="boxcontent">
    <td>Cantidad de Cubas:</td>
    <td><input name="NumCubas" type="text" onKeyDown="TeclaPulsada('PesoBruto')" value="<?php echo $NumCubas; ?>" size="10"></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

<?php
	$Consulta = "SELECT sum(horno) as cant_cubas, sum(peso_total) as peso_acum ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59' ";
	$Consulta.= " and cod_producto = '".$Grupo."'";
	$Consulta.= " and cod_subproducto = '".$Lado."'";
	$Consulta.= " and tipo_pesaje = 'RA'";
	$Consulta.= " group by cod_producto, cod_subproducto";
	
	$Resp2 = mysqli_query($link, $Consulta);
	$PesoAcum = 0;
	$CantCubas = 0;
	if ($Fila2 = mysqli_fetch_array($Resp2))
	{
		$PesoAcum = $Fila2["peso_acum"];
		$CantCubas = $Fila2["cant_cubas"];
	}
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
    <td width="100%" colspan="4"><?php
	if ($Modif == "S")	
	{
		$FechaProd = $ano."-".$mes."-".$dia;
		//CONSULTA PARA VER SI FUE FINALIZADO EL GRUPO
		$Consulta = "SELECT DISTINCT estado as estado from sea_web.detalle_pesaje ";
		$Consulta.= " where tipo_pesaje = 'RA'";
		$Consulta.= " and fecha between '".$FechaProd." 00:00:00' and '".$FechaProd." 23:59:59'";
		$Consulta.= " and cod_producto = '".$Grupo."'";
		$Consulta.= " and estado = 'F'";
		//echo $Consulta."<br>";
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux = mysqli_fetch_array($RespAux))
		{
		
			echo "<input name='BtnGuardar' type='button' onClick=\"Proceso('M_RestosAnodos')\" value='Modificar' style='width:100px'>\n";
		}
		else
		{
		
			echo "<input name='BtnGuardar' type='button' onClick=\"Proceso('G_RestosAnodos')\" value='Guardar' style='width:100px'>\n";
		}
	}
	else
	{
	//por aqui pasa echo "kkkk";
			echo "<input name='BtnGuardar' type='button' onClick=\"Proceso('G_RestosAnodos')\" value='Guardar' style='width:100px'>\n";
	}
?>
      <font color="#000000">
      <input name="ver" type="button"  value="Ver Hornadas" onClick="Proceso('V_RestosAnodos')" style="width:100px">
      <input name="ver2" type="button"  value="Ver Pesadas" onClick="Proceso('V_PesadasRestosAnodos')" style="width:100px">
      <input name="ver22" type="button"  value="Informe" onClick="Proceso('V_InformeRestosAnodos')" style="width:100px">
      </font>
      <input name="BtnSalir" type="button" onClick="Proceso('S')" value="Salir" style="width:70px" ></td>
  </tr>
  <tr class="boxcontent">
    <td colspan="3" align="center" valign="top">
	<table width="310" border="1" align="center" cellpadding="3" cellspacing="0" >
      <tr class="ColorTabla01">
        <td height="20"><strong>Fecha Carga: 
            <?php
	if (isset($FechaCarga) && $FechaCarga != "")
		echo substr($FechaCarga,8,2)."-".substr($FechaCarga,5,2)."-".substr($FechaCarga,0,4);
	else
		echo "&nbsp;";	
	?>
            <input type="hidden" name="FechaCarga" value="<?php echo $FechaCarga; ?>">
        </strong></td>
        <td height="20" colspan="2"><strong>Factor:&nbsp;<?php echo $Factor; ?>%</strong></td>
        </tr>
      <tr class="ColorTabla01"> 
        <td width="174" height="20"><div align="center"><strong>Tipo Producto</strong></div></td>
        <td width="72"><div align="center"><strong>Unidades</strong></div></td>
        <td width="78"><div align="center"><strong>Peso</strong></div></td>
      </tr>  
	<?php					
		$Largo = strlen($Parametros);
		for ($i=0; $i < $Largo; $i++)
		{
			if (substr($Parametros,$i,1) == "/")
			{				
				$valor = substr($Parametros,0,$i);
											
				$pos = strpos($valor,"-"); //de donde vienen
				$prod = substr($valor,0,$pos);
				$valor = substr($valor,$pos+1,strlen($valor));					
				
				$pos = strpos($valor,"-"); //unidades
				$unidades = substr($valor,0,$pos);
				$valor = substr($valor,$pos+1,strlen($valor));
				
				$peso = $valor; //peso
								
				$Parametros = substr($Parametros,$i+1);
				$i = 0;			
				$tabla[$prod][0] = $unidades;
				$tabla[$prod][1] = $peso;
			}	
		}		
		$Consulta = "SELECT valor_subclase1 AS valor FROM sub_clase WHERE cod_clase = 2002";
		
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Consulta = "SELECT * FROM subproducto WHERE cod_producto = '17' AND cod_subproducto = '".$Fila["valor"]."'";
			$Resp2 = mysqli_query($link, $Consulta);
			$Fila2 = mysqli_fetch_array($Resp2);

			echo "<tr>";
			echo "<td>".$Fila2["abreviatura"]."</td>";
        	echo "<td align='center'>".number_format($tabla[$Fila["valor"]][0],0,",",".")."</td>";
         	echo "<td align='center'>".number_format($tabla[$Fila["valor"]][1],0,",",".")."</td>";
	    	echo "</tr>";	
		}
		echo "<tr>";
		echo "<td>RESTOS ANODOS H.M.</td>";
       	echo "<td align='center'>".number_format($UnidHM,0,",",".")."</td>";
       	echo "<td align='center'>".number_format($PesoHM,0,",",".")."</td>";
    	echo "</tr>";
		//Totales
		
	?><tr align="center">
	<td><strong>TOTAL</strong></td>
	<td><strong><?php echo number_format(($UnidCorr + $UnidHM),0,",","."); ?></strong></td>
    <td><strong><?php echo number_format(($PesoCorr + $PesoHM),0,",","."); ?></strong></td>
	</tr>
  </table><br>
	</td>
    <td width="55%" align="center" valign="top"><table width="370" border="1" cellspacing="0" cellpadding="3">
      <tr align="center" class="ColorTabla01">
        <td colspan="6"><strong>PESAJE DEL DIA </strong></td>
        </tr>
      <tr align="center" class="ColorTabla01">
        <td width="40"><strong>Grupo</strong></td>
        <td width="32"><strong>Lado</strong></td>
        <td width="78"><strong>F. Carga </strong></td>
        <td width="53"><strong>Cant. Cubas </strong></td>
        <td width="42"><strong>Peso Acum. </strong></td>
        <td width="65"><strong>Hornada</strong></td>
      </tr>
<?php	
	$Fecha = $ano."-".$mes."-".$dia;
	$Consulta = "SELECT distinct cod_producto, cod_subproducto, fecha_carga ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
	$Consulta.= " and tipo_pesaje = 'RA'";
	$Consulta.= " order by cod_producto, cod_subproducto"; 
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	$TotalCubas = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Consulta = "SELECT sum(horno) as cant_cubas, sum(peso_total) as peso_acum ";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59' ";
		$Consulta.= " and cod_producto = '".$Fila["cod_producto"]."'";
		$Consulta.= " and cod_subproducto = '".$Fila["cod_subproducto"]."'";
		$Consulta.= " and tipo_pesaje = 'RA'";
		$Consulta.= " group by cod_producto, cod_subproducto";
		$Resp2 = mysqli_query($link, $Consulta);
		$PesoAcum = 0;
		$CantCubas = 0;
		if ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$PesoAcum = $Fila2["peso_acum"];
			$CantCubas = $Fila2["cant_cubas"];
		}
		echo "<tr align='center'>\n";
		echo "<td>".$Fila["cod_producto"]."</td>\n";
		echo "<td>".$Fila["cod_subproducto"]."</td>\n";
		echo "<td>".substr($Fila["fecha_carga"],8,2)."-".substr($Fila["fecha_carga"],5,2)."-".substr($Fila["fecha_carga"],0,4)."</td>\n";
		echo "<td>".number_format($CantCubas,0,",",".")."</td>\n";
		echo "<td>".number_format($PesoAcum,0,",",".")."</td>\n";
		$Consulta = "SELECT DISTINCT hornada FROM sea_web.movimientos";
		$Consulta.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 ";
		$Consulta.= " AND campo1 = '".$Fila["cod_subproducto"]."'";
		$Consulta.= " AND campo2 = '".$Fila["cod_producto"]."'";
		$Consulta.= " AND fecha_movimiento = '".$Fecha."' ORDER BY campo2";
		$Resp2 = mysqli_query($link, $Consulta);
		//echo $consulta;
		if ($Fila2 = mysqli_fetch_array($Resp2))
		{	
			echo "<td>".substr($Fila2["hornada"],6)."</td>\n";
		}		
		else
		{
			echo "<td>&nbsp;</td>\n";
		}
		echo "</tr>\n";
		$TotalPeso = $TotalPeso + $PesoAcum;
		$TotalCubas = $TotalCubas + $CantCubas;
	}
?>	  
      <tr align="center">
        <td colspan="3"><strong>Total</strong></td>
        <td><?php echo number_format($TotalCubas,0,",","."); ?></td>
        <td><?php echo number_format($TotalPeso,0,",","."); ?></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<input name="Factor"   type="hidden" value="<?php echo $Factor; ?>">
<input name="UnidCorr" type="hidden" value="<?php echo $UnidCorr; ?>">
<input name="PesoCorr" type="hidden" value="<?php echo $PesoCorr; ?>">
<input name="UnidHM"   type="hidden" value="<?php echo $UnidHM; ?>">
<input name="PesoHM"   type="hidden" value="<?php echo $PesoHM; ?>">
<?php	
	//SELECCIONA TARAS DE CARROS
	$Consulta = "SELECT * from sea_web.taras where tipo_tara='C' order by numero";
	$Respuesta = mysqli_query($link, $Consulta);
	$Cont=0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<input type='hidden' name='Carro".$Fila["numero"]."' value='".$Fila["peso"]."'>\n";
		$Cont++;
	}
	echo "<input type='hidden' name='CantCarros' value='".$Cont."'>\n";
	//SELECCIONA TARAS DE RACKS
	$Consulta = "SELECT * from sea_web.taras where tipo_tara='R' order by numero";
	$Respuesta = mysqli_query($link, $Consulta);
	$Cont=0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<input type='hidden' name='Rack".$Fila["numero"]."' value='".$Fila["peso"]."'>\n";
		$Cont++;
	}
	echo "<input type='hidden' name='CantRack' value='".$Cont."'>\n";
?>
<?php
	//Muestra PopUp con las hornadas generadas.
	/*if ($activar=="S")
		echo '<script language="JavaScript"> window.open("sea_con_hornadas.php?valores='.$valores.'", "","menubar=no resizable=no width=500 height=250") </script>';*/
	echo "<script language='javascript'>\n";
	
	echo "PesoAutomatico();\n";
	if (isset($Grupo) && $Grupo!="")
		echo "document.formulario.NumCarro.focus();\n";
	else
		echo "document.formulario.Grupo.focus();\n";
	echo "</script>\n";
?>

