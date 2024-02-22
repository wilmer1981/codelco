<?php

	if(isset($_REQUEST["num_hornada"])) {
		$num_hornada = $_REQUEST["num_hornada"];
	}else{
		$num_hornada = 0;
	}
	if(isset($_REQUEST["Hornada"])) {
		$Hornada = $_REQUEST["Hornada"];
	}else{
		$Hornada = 0;
	}
	if(isset($_REQUEST["Mensaje"])) {
		$Mensaje = $_REQUEST["Mensaje"];
	}else{
		$Mensaje = "";
	}
	if(isset($_REQUEST["ChkTipoAnodo"])) {
		$ChkTipoAnodo = $_REQUEST["ChkTipoAnodo"];
	}else{
		$ChkTipoAnodo = "";
	}
	if(isset($_REQUEST["Hornos"])) {
		$Hornos = $_REQUEST["Hornos"];
	}else{
		$Hornos = "";
	}
	if(isset($_REQUEST["NumRueda"])) {
		$NumRueda = $_REQUEST["NumRueda"];
	}else{
		$NumRueda = "";
	}

	if(isset($_REQUEST["colores"])) {
		$colores = $_REQUEST["colores"];
	}else{
		$colores = "";
	}
	if(isset($_REQUEST["UnidCorrientes"])) {
		$UnidCorrientes = $_REQUEST["UnidCorrientes"];
	}else{
		$UnidCorrientes = "";
	}
	if(isset($_REQUEST["UnidEspeciales"])) {
		$UnidEspeciales = $_REQUEST["UnidEspeciales"];
	}else{
		$UnidEspeciales = "";
	}
	if(isset($_REQUEST["UnidHM"])) {
		$UnidHM = $_REQUEST["UnidHM"];
	}else{
		$UnidHM = "";
	}
	/*
	if(isset($_REQUEST["PesoNeto"])) {
		$PesoNeto = $_REQUEST["PesoNeto"];
	}else{
		$PesoNeto = 0;
	}
	if(isset($_REQUEST["TotalTara"])) {
		$TotalTara = $_REQUEST["TotalTara"];
	}else{
		$TotalTara = 0;
	}*/


	$TotalTara=0;
	$PesoCarro=0;
	$PesoNeto=0;
	if ($Modif=="S")
	{
		//LIMPIO VARIABLES
		$NumRueda = "";
		$NumCarro = "";
		$NumRack = "";			
		$ChkFin = "N";
		$PesoAuto="S";
		$ChkTipoAnodo = "CTTE";
		$UnidCorrientes = ""; 
		$UnidEspeciales = ""; 
		$UnidHM = ""; 
		//-------------
		$dia = substr($FechaHora,8,2);
		$des = substr($FechaHora,5,2);
		$ano = substr($FechaHora,0,4);
		$Fecha = $ano."-".$mes."-".$dia;
		$Hora = trim(substr($FechaHora,11));
		$Hornos = $Horno;
		$num_hornada = $Hornada;
		//CONSULTO LOS DATOS DEL REGISTRO A ELIMINAR
		$Consulta = "SELECT * from sea_web.detalle_pesaje ";
		$Consulta.= " where fecha = '".$FechaHora."'";
		$Consulta.= " and hornada = '".$Hornada."'";
		$Consulta.= " and horno = '".$Hornos."'";
		$Respuesta = mysqli_query($link, $Consulta);
		$Ctte = false;
		$Esp = false;
		$HM = false;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			switch ($Fila["cod_subproducto"])
			{
				case 4:
					$UnidCorrientes = $Fila["unidades"]; 
					$Ctte = true;
					break;
				case 8:
					$UnidHM = $Fila["unidades"];
					$HM = true;
					break;
				case 11:	
					$UnidEspeciales = $Fila["unidades"];
					$Esp = true;
					break;
			}
			if ($HM && !$Ctte && !$Esp)
				$ChkTipoAnodo = "HM";
			else
				$ChkTipoAnodo = "CTTE";

			$NumRueda = $Fila["rueda"];
			$NumCarro = $Fila["num_carro"];
			$NumRack = $Fila["num_rack"];
			$PesoNeto = $Fila["peso_total"];
			if ($Fila["estado"]=="F")
				$ChkFin = "S";
		}
		$PesoAuto="N";		
	}	
	//CONSULTAS TARAS SI EXISTEN
	//$TotalTara=0;
	//$PesoCarro =0;
	//$PesoNeto=0;

	$Consulta = "SELECT * from sea_web.taras where tipo_tara='C' and numero='".$NumCarro."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$PesoCarro = $Fila["peso"];
	}
	$PesoRack=0;
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
<table width="95%" class="TablaDetalle" cellpadding="2" cellspacing="0">
  <tr>
    <td width="18%">Fecha Producci&oacute;n</td>
    <td colspan="5"><font color="#000000" size="2">
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
      <SELECT name="mes" style="width:90px"  onChange="Proceso('R')">
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
      <SELECT name="ano" style="width:60px;"  onChange="Proceso('R')">
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
      <input type="hidden" name="Hora" value="<?php 
		if (!isset($Hora))	  
			echo date("H:i:s");
		else
			echo $Hora; 
	  ?>">
    </font></td>
    <td width="13%">&nbsp; </td>
  </tr>
  <tr class="boxcontent">
    <td><font color="#000000">Hornos</font></td>
    <td colspan="6"><font color="#000000">
      <SELECT name="Hornos" style="width:210px" onChange="Proceso('R')">
        <option value="S">HORNO</option>
        <?php            		
				$Consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2006 ORDER BY cod_subclase";
				$rs = mysqli_query($link, $Consulta);		
				while ($row = mysqli_fetch_array($rs))
				{
					if ($row["cod_subclase"] == $Hornos)	
						echo '<option value="'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';
					else 
						echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';				
				}

           					
		?>
      </SELECT>
      <input type="button" name="BtnNuevaHornada" value="Generar Hornada" onClick="GenerarHornada('N')">
      </font>
        <input type="button" name="BtnReiniciarHornada" value="Reiniciar Hornada" onClick="GenerarHornada('S')">
    </td>
  </tr>
  <tr class="boxcontent">
    <td><font color="#000000">Num Hornada:</font></td>
    <td colspan="6"><SELECT name="num_hornada" style="width:150px " onChange="Proceso('R')">
        <option value="S">HORNADA</option>
        <?php 
					$Consulta = "SELECT distinct hornada from sea_web.detalle_pesaje ";
					$Consulta.= " where horno = '".$Hornos."' ";
					$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
					$Consulta.= " and tipo_pesaje = 'PA'";
					$Consulta.= " order by hornada";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Respuesta))
					{
						if ($Fila["hornada"]==$num_hornada)
							echo "<option SELECTed value='".$Fila["hornada"]."'>".substr($Fila["hornada"],-4)."</option>\n";								
						else
							echo "<option value='".$Fila["hornada"]."'>".substr($Fila["hornada"],-4)."</option>\n";								
					}
		?>
      </SELECT>
        <?php
	$HornadaAux = substr($num_hornada,-4);
	if ($HornadaAux != '' && $HornadaAux != 0)
	{
		$num1 = substr($HornadaAux,0,1);
		$num2 = substr($HornadaAux,2,1);
		$num3 = substr($HornadaAux,3,1);
		
		$Consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2011 AND cod_subclase = '".$num3."' ";
		include("../principal/conectar_principal.php"); 
		$rs = mysqli_query($link, $Consulta);				
		if($row = mysqli_fetch_array($rs))
			$colores = $row["valor_subclase1"] ." ". $colores;
		
		$Consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2011 AND cod_subclase = '".$num2."'";
		include("../principal/conectar_principal.php"); 
		$rs = mysqli_query($link, $Consulta);
		if($row = mysqli_fetch_array($rs))
			$colores = $row["valor_subclase1"]." ".$colores;	
		
		$Consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2011 AND cod_subclase = '".$num1."'";
		include("../principal/conectar_principal.php"); 
		$rs = mysqli_query($link, $Consulta);
		if($row = mysqli_fetch_array($rs))				
			$colores = $row["valor_subclase1"] ." ". $colores;
	}  
	echo ""; 

			?><input name="colores" type="text" size="10" value="<?php echo $colores; ?>" disabled>        
        <font color="#FF0000">         <?php echo $Mensaje;?></font></td>
  </tr>
  <tr class="boxcontent">
    <td>Rueda</td>
    <td colspan="3"><font color="#FF0000">
    <input name="NumRueda" type="text" size="10" value="<?php echo $NumRueda; ?>" onKeyDown="TeclaPulsada('NumCarro')">
</font><font color="#000000">
<?php
			if($ChkTipoAnodo == "CTTE")
			{
				echo '<input type="radio" name="ChkTipoAnodo" value="CTTE" checked>Anodo Corriente';
				echo '<input type="radio" name="ChkTipoAnodo" value="HM">Anodo Hoja Madre'; 
			}
			else
			{
				if($ChkTipoAnodo == "HM")
				{
					echo '<input type="radio" name="ChkTipoAnodo" value="CTTE">Anodo Corriente';
					echo '<input type="radio" name="ChkTipoAnodo" value="HM" checked>Anodo Hoja Madre'; 
				}
				else
				{
					echo '<input type="radio" name="ChkTipoAnodo" value="CTTE" checked>Anodo Corriente';
					echo '<input type="radio" name="ChkTipoAnodo" value="HM">Anodo Hoja Madre'; 
				}          
			}
			?>
</font></td>
    <td colspan="3"><font color="#000000"><?php
			if($ChkFin == "S")
				echo '<input type="checkbox" name="ChkFin" value="S" checked>';
			else
				echo '<input type="checkbox" name="ChkFin" value="S">';
            
			?>
Fin de la Hornada </font></td>
  </tr>
  <tr class="boxcontent">
    <td>Carro:</td>
    <td width="10%"><input name="NumCarro" type="text" onBlur="BuscaPeso('C')" onKeyDown="TeclaPulsada('NumRack')" value="<?php echo $NumCarro; ?>" size="10"></td>
    <td colspan="2"><input name="PesoCarro" type="text" disabled onKeyDown="TeclaPulsada('NumRack')" value="<?php echo $PesoCarro; ?>" size="10">
        <img src="../principal/imagenes/ing_carro.gif" width="90" height="18" name="ImgCarro" style="visibility:hidden ">      <input type="hidden" name="CampoActivo" value="">
        <input type="hidden" name="NuevoCarro" value="N"></td>
    <td colspan="3"><font color="#000000">
      <?php 
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
			?>
Peso Automatico<font color="#000000">&nbsp;</font>
</font></td>
  </tr>
  <tr class="boxcontent">
    <td>Rack:</td>
    <td><input name="NumRack" type="text" id="NumRack2" onBlur="BuscaPeso('R')" onKeyDown="TeclaPulsada('UnidCorrientes')" value="<?php echo $NumRack; ?>" size="10"></td>
    <td colspan="2"><input name="PesoRack" type="text" disabled onKeyDown="TeclaPulsada('UnidCorrientes')" value="<?php echo $PesoRack; ?>" size="10" >
        <img src="../principal/imagenes/ing_rack.gif" width="90" height="18" name="ImgRack" style="visibility:hidden ">      <input type="hidden" name="NuevoRack" value="N"></td>
    <td colspan="3"><font color="#000000">&nbsp;
    </font></td>
  </tr>
  <tr class="boxcontent">
    <td>Total Tara:</td>
    <td>&nbsp;</td>
    <td width="18%"><input name="TotalTara" type="text" value="<?php echo $TotalTara; ?>" size="10" readonly>
    </td>
    <td width="17%" align="right">Peso Bruto:</td>
    <td width="11%"><input name="PesoBruto" type="text" id="PesoBruto" onKeyDown="TeclaPulsada('UnidCorrientes')" value="<?php echo $PesoBruto; ?>" size="10"></td>
    <td width="13%" align="right">Peso Neto: </td>
    <td><input name="PesoNeto" type="text" id="PesoNeto" value="<?php echo $PesoNeto; ?>" size="10" readonly></td>
  </tr>
</table>
<br>
<table width="95%" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="ColorTabla01">
    <td width="13%" align="left"><div align="left"></div></td>
    <td colspan="3" class="ColorTabla01"><strong>Unid. Corrientes</strong></td>
    <td colspan="4" class="ColorTabla01"><strong>Unid.Especiales</strong></td>
    <td colspan="3" class="ColorTabla01"><strong>Unid. Hojas Madre </strong></td>
  </tr>
  <tr align="center" class="boxcontent">
    <td align="left"><div align="left">
      <p>DISTRIBUCION</p>
    </div></td>
    <td colspan="3" class="boxcontent"><input name="UnidCorrientes" type="text" onKeyDown="TeclaPulsada('UnidEspeciales')" value="<?php echo $UnidCorrientes; ?>" size="15"></td>
    <td colspan="4" class="boxcontent"><input name="UnidEspeciales" type="text" onKeyDown="TeclaPulsada('UnidHM')" value="<?php echo $UnidEspeciales; ?>" size="15"></td>
    <td colspan="3" class="boxcontent"><input name="UnidHM" type="text" id="UnidHM" onKeyDown="TeclaPulsada('BtnGuardar')" value="<?php echo $UnidHM; ?>" size="15"></td>
  </tr>
  <tr align="center" class="boxcontent">
    <td colspan="11"><div align="left">
      <p align="center">
        <input name="BtnGuardar" type="button" onClick="Proceso('G_ProdAnodos')" value='Guardar' style="width:70px">
            <font color="#000000">
            <input name="ver" type="button"  value="Ver Hornadas" onClick="Proceso('V_ProdAnodos')" style="width:100px">
            <input name="ver2" type="button"  value="Ver Pesadas" onClick="Proceso('V_PesadasProdAnodos')" style="width:100px">
            <input name="ver22" type="button"  value="Informe" onClick="Proceso('V_InformeProdAnodos')" style="width:100px">
            </font>
            <input name="BtnSalir" type="button" onClick="Proceso('S')" value="Salir" style="width:70px" >
      </p>
    </div></td>
  </tr>
<?php
	//BUSCA PESOS PROMEDIOS FIJOS
	$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = '2013'";
	$Respuesta = mysqli_query($link, $Consulta);
	//$PromCtte=0; //WSO
	//$PromHM=0; // WSO
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		switch ($Fila["cod_subclase"])
		{
			case 1:
				if(isset($Fila["valor_subclase1"])){
					$PromCtte=$Fila["valor_subclase1"];	
				}else{
					$PromCtte=0;
				}
				//$PromCtte=$Fila["valor_subclase1"];	
				break;
			case 2:
				if(isset($Fila["valor_subclase1"])){
					$PromHM=$Fila["valor_subclase1"];
				}else{
					$PromHM=0;
				}
				//$PromHM=$Fila["valor_subclase1"];
				break;
		}
	}
	//BUSCA PROMEDIOS REALES
	//TOTAL DE UNIDADES POR CADA UNO DE LOS OTROS PRODUCTOS
	$Consulta = "SELECT cod_producto, cod_subproducto, sum(unidades) as unidades, sum(peso) as peso ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where hornada = '".$num_hornada."'";
	$Consulta.= " and horno = '".$Hornos."'";
	$Consulta.= " and tipo_pesaje = 'PA'";
	$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
	$Consulta.= " and cod_producto = '17' and cod_subproducto in(4,8,11)";
	$Consulta.= " and promedio <> 'S'";
	$Consulta.= " group by cod_producto, cod_subproducto ";
	$Respuesta = mysqli_query($link, $Consulta);
	$AuxUnidCtte = 0;
	$AuxUnidHM = 0;
	$AuxPesoCtte = 0;
	$AuxPesoHM = 0;
	$PromRealCtte=0; // WSO
	$PromRealHM=0; // WSO
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		switch ($Fila["cod_subproducto"])
		{
			case 4:
				$AuxUnidCtte = $AuxUnidCtte + $Fila["unidades"];
				$AuxPesoCtte = $AuxPesoCtte + $Fila["peso"];
				break;
			case 8:
				$AuxUnidHM = $AuxUnidHM + $Fila["unidades"];
				$AuxPesoHM = $AuxPesoHM + $Fila["peso"];
				break;
			case 11:
				$AuxUnidCtte = $AuxUnidCtte + $Fila["unidades"];
				$AuxPesoCtte = $AuxPesoCtte + $Fila["peso"];
				break;
		}		
	}
	if ($AuxPesoCtte != 0 && $AuxUnidCtte != 0)
		$PromRealCtte = $AuxPesoCtte/$AuxUnidCtte;
	if ($AuxPesoHM != 0 && $AuxUnidHM != 0)
		$PromRealHM = $AuxPesoHM/$AuxUnidHM;
	//TOTALES UNIDADES
	$Consulta = "SELECT cod_producto, cod_subproducto, sum(unidades) as unidades, sum(peso) as peso_real ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
	$Consulta.= " and tipo_pesaje = 'PA'";
	$Consulta.= " and hornada = '".$num_hornada."'";
	$Consulta.= " and promedio <> 'S'";
	$Consulta.= " group by cod_producto, cod_subproducto";
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalUnid = 0;	
	$UnidCtte = 0;
	$UnidHM = 0;
	$UnidEsp = 0;
	$TotalPeso = 0;	
	$PesoCtte = 0;
	$PesoHM = 0;
	$PesoEsp = 0;
	$PesoRealCtte=0;
	$PromCtte=0; //WSO
	$PesoRealEsp=0; //WSO
    $TotalRealPeso=0; // WSO
	$PromHM=0; // WSO
	$PesoRealHM=0; //WSO
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		switch ($Fila["cod_subproducto"])
		{
			case 4:
				$UnidCtte = $Fila["unidades"];
				$PesoCtte = $Fila["unidades"]*$PromCtte;
				$PesoRealCtte = $Fila["peso_real"];
				$TotalPeso = $TotalPeso + ($Fila["unidades"]*$PromCtte);
				$TotalRealPeso = $TotalRealPeso + $Fila["peso_real"];
				break;
			case 8:
				$UnidHM = $Fila["unidades"];
				$PesoHM = $Fila["unidades"]*$PromHM;
				$PesoRealHM = $Fila["peso_real"];
				$TotalPeso = $TotalPeso + ($Fila["unidades"]*$PromHM);
				$TotalRealPeso = $TotalRealPeso + $Fila["peso_real"];
				break;
			case 11:
				$UnidEsp = $Fila["unidades"];
				$PesoEsp = $Fila["unidades"]*$PromCtte;
				$PesoRealEsp = $Fila["peso_real"];
				$TotalPeso = $TotalPeso + ($Fila["unidades"]*$PromCtte);
				$TotalRealPeso = $TotalRealPeso + $Fila["peso_real"];
				break;
		}		
		$TotalUnid = $TotalUnid + $Fila["unidades"];		
	}
	//TOTALES POR RUEDA
	$Consulta = "SELECT cod_producto, cod_subproducto, rueda, unidades, peso ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
	$Consulta.= " and tipo_pesaje = 'PA'";
	$Consulta.= " and hornada = '".$num_hornada."'";
	$Consulta.= " and promedio <> 'S'";
	$Respuesta = mysqli_query($link, $Consulta);	
	$TotalRueda01 = 0;
	$TotalRueda02 = 0;
	$TotalRuedas = 0;
	$TotalPesoRueda01 = 0;
	$TotalPesoRueda02 = 0;
	$TotalPesoRuedas = 0;
	$TotalRealPesoRueda01=0; // WSO
	$TotalRealPesoRueda02=0; // WSO
	$TotalRealPesoRuedas=0; // WSO
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		switch ($Fila["rueda"])
		{
			case 1:
				$TotalRueda01 = $TotalRueda01 + $Fila["unidades"];
				switch ($Fila["cod_subproducto"])
				{
					case 4:
						$TotalPesoRueda01 = $TotalPesoRueda01 + ($Fila["unidades"]*$PromCtte);
						$TotalRealPesoRueda01 = $TotalRealPesoRueda01 + $Fila["peso"];
						break;
					case 8:
						$TotalPesoRueda01 = $TotalPesoRueda01 + ($Fila["unidades"]*$PromHM);
						$TotalRealPesoRueda01 = $TotalRealPesoRueda01 + $Fila["peso"];
						break;
					case 11:
						$TotalPesoRueda01 = $TotalPesoRueda01 + ($Fila["unidades"]*$PromCtte);
						$TotalRealPesoRueda01 = $TotalRealPesoRueda01 + $Fila["peso"];
						break;
				}
				break;
			case 2:
				$TotalRueda02 = $TotalRueda02 + $Fila["unidades"];
				switch ($Fila["cod_subproducto"])
				{
					case 4:
						$TotalPesoRueda02 = $TotalPesoRueda02 + ($Fila["unidades"]*$PromCtte);
						$TotalRealPesoRueda02 = $TotalRealPesoRueda02 + $Fila["peso"];
						break;
					case 8:
						$TotalPesoRueda02 = $TotalPesoRueda02 + ($Fila["unidades"]*$PromHM);
						$TotalRealPesoRueda02 = $TotalRealPesoRueda02 + $Fila["peso"];
						break;
					case 11:
						$TotalPesoRueda02 = $TotalPesoRueda02 + ($Fila["unidades"]*$PromCtte);
						$TotalRealPesoRueda02 = $TotalRealPesoRueda02 + $Fila["peso"];
						break;
				}
				break;			
		}	
		switch ($Fila["cod_subproducto"])
		{
			case 4:
				$TotalPesoRuedas = $TotalPesoRuedas + ($Fila["unidades"]*$PromCtte);
				$TotalRealPesoRuedas = $TotalRealPesoRuedas + $Fila["peso"];
				break;
			case 8:
				$TotalPesoRuedas = $TotalPesoRuedas + ($Fila["unidades"]*$PromHM);
				$TotalRealPesoRuedas = $TotalRealPesoRuedas + $Fila["peso"];
				break;
			case 11:
				$TotalPesoRuedas = $TotalPesoRuedas + ($Fila["unidades"]*$PromCtte);
				$TotalRealPesoRuedas = $TotalRealPesoRuedas + $Fila["peso"];
				break;
		}	
		$TotalRuedas = $TotalRuedas + $Fila["unidades"];
	}	
?>  
  <tr align="center" class="ColorTabla01">
    <td height="25" colspan="4"><strong>Resumen Hornada </strong></td>
    <td colspan="4" class="boxcontent"><strong>Resumen Ruedas </strong></td>
    <td colspan="3" class="boxcontent"><strong>Peso Prom. Anodos</strong></td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td height="25" align="left"><div align="left">
      <p>&nbsp;</p>
    </div></td>
    <td width="7%" class="boxcontent">Unid.</td>
    <td width="8%" class="boxcontent">P. Est. </td>
    <td width="9%" class="boxcontent">P. Real </td>
    <td class="boxcontent">&nbsp;</td>
    <td class="boxcontent">Unid.</td>
    <td class="boxcontent">P. Est. </td>
    <td class="boxcontent">P. Real </td>
    <td width="12%" class="boxcontent">Tipo Anodo </td>
    <td width="8%" class="boxcontent">P. Est.</td>
    <td width="7%" class="boxcontent">P. Real</td>
  </tr>
  <tr align="center" bgcolor="#FFFFFF" class="boxcontent">
    <td align="right">      <p>Corrientes : </p></td>
    <td align="center" class="boxcontent"><?php echo number_format($UnidCtte,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($PesoCtte,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($PesoRealCtte,0,",","."); ?></td>
    <td align="right" class="boxcontent">Rueda
    01: </td>
    <td align="center" class="boxcontent"><?php echo number_format($TotalRueda01,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($TotalPesoRueda01,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($TotalRealPesoRueda01,0,",","."); ?></td>
    <td align="right" class="boxcontent">Corriente:</td>
    <td align="center" class="boxcontent"><?php echo number_format($PromCtte,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($PromRealCtte,0,",","."); ?></td>
  </tr>
  <tr align="center" bgcolor="#FFFFFF" class="boxcontent">
    <td align="right">
      Especiales
    :    </td>
    <td align="center" class="boxcontent"><?php echo number_format($UnidEsp,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($PesoEsp,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($PesoRealEsp,0,",","."); ?></td>
    <td align="right" class="boxcontent"> Rueda 02: </td>
    <td align="center" class="boxcontent"><?php echo number_format($TotalRueda02,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($TotalPesoRueda02,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($TotalRealPesoRueda02,0,",","."); ?></td>
    <td align="right" class="boxcontent">Hoja Madre : </td>
    <td align="center" class="boxcontent"><?php echo number_format($PromHM,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($PromRealHM,0,",","."); ?></td>
  </tr>
  <tr align="center" bgcolor="#FFFFFF" class="boxcontent">
    <td align="right">
      <p>Hoja Madre: </p>    </td>
    <td align="center" class="boxcontent"><?php echo number_format($UnidHM,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($PesoHM,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($PesoRealHM,0,",","."); ?></td>
    <td colspan="4" class="boxcontent">&nbsp;</td>
    <td colspan="3" rowspan="2" align="center" class="boxcontent">&nbsp;</td>
  </tr>
  <tr align="center" bgcolor="#FFFFFF">
    <td align="right">
    <p><strong>Total :</strong></p>    </td>
    <td align="center" class="boxcontent"><?php echo number_format($TotalUnid,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($TotalPeso,0,",","."); ?></td>
    <td align="center" class="boxcontent"><?php echo number_format($TotalRealPeso,0,",","."); ?></td>
    <td width="9%" align="right" class="boxcontent"><strong>Total: </strong></td>
    <td width="8%" align="center" class="boxcontent"><?php echo number_format($TotalRuedas,0,",","."); ?></td>
    <td width="9%" align="center" class="boxcontent"><?php echo number_format($TotalPesoRuedas,0,",","."); ?></td>
    <td width="10%" align="center" class="boxcontent"><?php echo number_format($TotalRealPesoRuedas,0,",","."); ?></td>
  </tr>
</table>
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
<script language="javascript">
	PesoAutomatico(); 
	document.formulario.NumRueda.focus();	
	if (document.formulario.num_hornada.value=="S")
		document.formulario.colores.value="";
</script>
