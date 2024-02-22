<?php 
	include("../principal/conectar_sea_web.php");

	if(isset($_REQUEST["Proceso"])) {
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = '';
	}

	if(isset($_REQUEST["Ano"])) {
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = date("Y");
	}
	if(isset($_REQUEST["Mes"])) {
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date("m");
	}
	if(isset($_REQUEST["Dia"])) {
		$Dia = $_REQUEST["Dia"];
	}else{
		$Dia = date("d");
	}
	if(isset($_REQUEST["Hornada"])) {
		$Hornada = $_REQUEST["Hornada"];
	}else{
		$Hornada = "";
	}

	if(isset($_REQUEST["colores"])) {
		$colores = $_REQUEST["colores"];
	}else{
		$colores = "";
	}


	$Fecha = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".str_pad($Dia,2,"0",STR_PAD_LEFT);
?>

<html>
<head>
<title>Busqueda de Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function Proceso(opt)
{
	var f = document.frmPoPup;
	
	switch (opt) 
	{
		case "S":
			//window.opener.document.formulario.action="sea_ing_prod_vent_auto.php";
			//window.opener.document.formulario.submit();
			window.close();
			break;
		case "R":
			f.action="sea_ing_prod_vent_auto_anodos_det3.php";
			f.submit();	
			break;
	}    
}

function Imprimir()
{
	var f = document.frmPoPup;
	f.BtnImprimir.style.visibility = "hidden";
	f.BtnSalir.style.visibility = "hidden";
	f.BtnBuscar.style.visibility = "hidden";
	window.print();
	f.BtnImprimir.style.visibility = "visible";
	f.BtnSalir.style.visibility = "visible";
	f.BtnBuscar.style.visibility = "visible";
}


</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<style type="text/css">
body {
	background-image: url(../Principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<form name="frmPoPup" method="post" action="">
    <table width="500" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior" >
      <tr class="ColorTabla02"> 
        <td colspan="2"><div align="center"><strong>RECEPCION MOLDEO DE ANODOS </strong></div></td>
      </tr>
      <tr> 
        <td width="155" height="32">Fecha </td>
        <td><font color="#000000" size="2"> 
          <SELECT name="Dia" onChange="Proceso('R');">
            <?php
    			for ($i=1;$i<=31;$i++)
				{
					if (isset($Dia))
					{
						if ($i==$Dia)						
							echo "<option SELECTed value= '".$i."'>".$i."</option>";						
						else												
					  		echo "<option value='".$i."'>".$i."</option>";
					}/*
					else
					{
						if ($i==date("j"))						
							echo "<option SELECTed value= '".$i."'>".$i."</option>";						
						else												
					  		echo "<option value='".$i."'>".$i."</option>";
					} 	*/			   								    		
 				}
	?>
          </SELECT>
          </font> <font color="#000000" size="2"> 
          <SELECT name="Mes" onChange="Proceso('R');">
            <?php
        		$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");					
		   		for ($i=1;$i<=12;$i++)
				{
					if (isset($Mes))
					{
						if ($i==$Mes)						
							echo "<option SELECTed value= '".$i."'>".$Meses[$i-1]."</option>";						
						else												
					  		echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
					}/*
					else
					{
						if ($i==date("n"))						
							echo "<option SELECTed value= '".$i."'>".$Meses[$i-1]."</option>";						
						else												
					  		echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
					} 	*/			   								    		
 				}  		  
     ?>
          </SELECT>
          <SELECT name="Ano" onChange="Proceso('R');">
            <?php	
	    		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if (isset($Ano))
					{
						if ($i==$Ano)						
							echo "<option SELECTed value= '".$i."'>".$i."</option>";						
						else												
					  		echo "<option value='".$i."'>".$i."</option>";
					}/*
					else
					{
						if ($i==date("Y"))						
							echo "<option SELECTed value= '".$i."'>".$i."</option>";						
						else												
					  		echo "<option value='".$i."'>".$i."</option>";
					} */				   								    		
 				}  		
?>
          </SELECT>
</font></td>
      </tr>
      <tr> 
        <td>Moldeo N&ordm;</td>
        <td width="434"><SELECT name="Hornada" onChange="Proceso('R');">
		<option  value = "-1" SELECTed>SELECCIONAR</option>
		<?php 		
			$Consulta = "SELECT distinct hornada from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
			$Consulta.= " and tipo_pesaje = 'PA'";
			$Consulta.= " order by hornada";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				if ($Fila["hornada"] == $Hornada)
					echo "<option SELECTed value='".$Fila["hornada"]."'>".substr($Fila["hornada"],6)."</option>";
				else
					echo "<option value='".$Fila["hornada"]."'>".substr($Fila["hornada"],6)."</option>";
			}
	   ?></SELECT>
          <?php
if (isset($Hornada) && $Hornada != "-1")		  
{
	$HornadaAux = substr($Hornada,-4);
	if ($HornadaAux != '' && $HornadaAux != 0)
	{
		$num1 = substr($HornadaAux,0,1);
		$num2 = substr($HornadaAux,2,1);
		$num3 = substr($HornadaAux,3,1);
		
		$Consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2011 AND cod_subclase = $num3";
		include("../principal/conectar_principal.php"); 
		$rs = mysqli_query($link, $Consulta);				
		if($row = mysqli_fetch_array($rs))
			$colores = $row["valor_subclase1"] ." ". $colores;
		
		$Consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2011 AND cod_subclase = $num2";
		include("../principal/conectar_principal.php"); 
		$rs = mysqli_query($link, $Consulta);
		if($row = mysqli_fetch_array($rs))
			$colores = $row["valor_subclase1"] ." ". $colores;	
		
		$Consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2011 AND cod_subclase = $num1";
		include("../principal/conectar_principal.php"); 
		$rs = mysqli_query($link, $Consulta);
		if($row = mysqli_fetch_array($rs))				
			$colores = $row["valor_subclase1"] ." ". $colores;
	}  
}

			?>
          <input name="colores" type="text" size="10" value="<?php echo $colores; ?>" disabled>         
          <input name="BtnBuscar" type="button" id="BtnBuscar" style="width:70" onClick="Proceso('R');" value="Buscar"> </td>
      </tr>
  </table>
<?php  
	$Consulta = "SELECT distinct cod_producto, cod_subproducto ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where rueda='1'";
	$Consulta.= " and hornada = '".$Hornada."'";
	$Consulta.= " order by fecha";		
	$Respuesta = mysqli_query($link, $Consulta); 
	$CantProd = mysqli_num_rows($Respuesta);
	$Ctte = false;
	$Esp = false;
	$HM = false;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		switch ($Fila["cod_subproducto"])
		{
			case 4:
				$Ctte = true;
				break;
			case 11:
				$Esp = true;
				break;
			case 8:
				$HM = true;
				break;
		}
	}
?>	
    <br>
    <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top"><table width="184" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr align="center">
            <td colspan="<?php echo ($CantProd + 2);?>" class="ColorTabla01"><strong>RUEDA N&ordm; 1 </strong></td>
          </tr>
          <tr align="center">
            <td width="27">&nbsp;</td>
<?php			
	if ($Ctte)
		echo "<td width='38'><strong>CTTES.</strong></td>\n";
	if ($Esp)
		echo "<td width='38'><strong>ESP.</strong></td>\n";
	if ($HM)
		echo "<td width='38'><strong>H.M.</strong></td>\n";
?>		
            <td width="47"><strong>PESO</strong></td>
          </tr>
<?php
	$Consulta = "SELECT distinct fecha, peso_total ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where rueda='1'";
	$Consulta.= " and hornada = '".$Hornada."'";
	$Consulta.= " order by fecha";		
	$Respuesta = mysqli_query($link, $Consulta);
	$Cont = 1;
	$TotalUnidCtteRueda01 = 0;
	$TotalUnidEspRueda01 = 0;
	$TotalUnidHMRueda01 = 0;
	$TotalPeso = 0;
	$TotalPesoRueda01=0; //WSO
	while ($Fila = mysqli_fetch_array($Respuesta))
	{  
		echo "<tr align='center'>\n";
		echo "<td>".$Cont."</td>\n";
		//CTTE
		if ($Ctte)
		{
			$Consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha = '".$Fila["fecha"]."'";
			$Consulta.= " and cod_producto = '17' and cod_subproducto = '4'";
			$Resp2 = mysqli_query($link, $Consulta);
			$Unidades = 0;
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				echo "<td>".number_format($Fila2["unidades"],0,",",".")."</td>\n";
				$Unidades = $Fila2["unidades"];
			}
			else
			{
				echo "<td>&nbsp;</td>\n";
			}
			$TotalUnidCtteRueda01 = $TotalUnidCtteRueda01 + $Unidades;
		}
		//ESP
		if ($Esp)
		{
			$Consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha = '".$Fila["fecha"]."'";
			$Consulta.= " and cod_producto = '17' and cod_subproducto = '11'";
			$Resp2 = mysqli_query($link, $Consulta);
			$Unidades = 0;
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				echo "<td>".number_format($Fila2["unidades"],0,",",".")."</td>\n";
				$Unidades = $Fila2["unidades"];
			}
			else
			{
				echo "<td>&nbsp;</td>\n";
			}
			$TotalUnidEspRueda01 = $TotalUnidEspRueda01 + $Unidades;
		}
		//HM
		if ($HM)
		{
			$Consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha = '".$Fila["fecha"]."'";
			$Consulta.= " and cod_producto = '17' and cod_subproducto = '8'";
			$Resp2 = mysqli_query($link, $Consulta);
			$Unidades = 0;
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				echo "<td>".number_format($Fila2["unidades"],0,",",".")."</td>\n";
				$Unidades = $Fila2["unidades"];
			}
			else
			{
				echo "<td>&nbsp;</td>\n";
			}
			$TotalUnidHMRueda01 = $TotalUnidHMRueda01 + $Unidades;
		}
		echo "<td align='right'>".number_format($Fila["peso_total"],0,",",".")."</td>\n";		
		$TotalPesoRueda01 = $TotalPesoRueda01 + $Fila["peso_total"];
		echo "</tr>\n";
		$Cont++;
	}
?>		  
          <tr align="center">
            <td><strong>TOT.</strong></td>
<?php		
	if ($Ctte)	
    	echo "<td>".number_format($TotalUnidCtteRueda01,0,",",".")."</td>\n";
	if ($Esp)	
    	echo "<td>".number_format($TotalUnidEspRueda01,0,",",".")."</td>\n";
	if ($HM)	
    	echo "<td>".number_format($TotalUnidHMRueda01,0,",",".")."</td>\n";
?>			
            <td><?php echo number_format($TotalPesoRueda01,0,",","."); ?></td>
          </tr>
        </table>          </td>
        <td valign="top">
<?php  
	$Consulta = "SELECT distinct cod_producto, cod_subproducto ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where rueda='2'";
	$Consulta.= " and hornada = '".$Hornada."'";
	$Consulta.= " order by fecha";		
	$Respuesta = mysqli_query($link, $Consulta); 
	$CantProd = mysqli_num_rows($Respuesta);
	$Ctte = false;
	$Esp = false;
	$HM = false;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		switch ($Fila["cod_subproducto"])
		{
			case 4:
				$Ctte = true;
				break;
			case 11:
				$Esp = true;
				break;
			case 8:
				$HM = true;
				break;
		}
	}
?>			
		<table width="184" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr align="center">
            <td colspan="<?php echo ($CantProd + 2);?>" class="ColorTabla01"><strong>RUEDA
                N&ordm; 2 </strong></td>
          </tr>
          <tr align="center">
            <td width="27">&nbsp;</td>
            <?php			
	if ($Ctte)
		echo "<td width='38'><strong>CTTES.</strong></td>\n";
	if ($Esp)
		echo "<td width='38'><strong>ESP.</strong></td>\n";
	if ($HM)
		echo "<td width='38'><strong>H.M.</strong></td>\n";
?>
            <td width="47"><strong>PESO</strong></td>
          </tr>
          <?php
	$Consulta = "SELECT distinct fecha, peso_total ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where rueda='2'";
	$Consulta.= " and hornada = '".$Hornada."'";
	$Consulta.= " order by fecha";		
	$Respuesta = mysqli_query($link, $Consulta);
	$Cont = 1;
	$TotalUnidCtteRueda01 = 0;
	$TotalUnidEspRueda01 = 0;
	$TotalUnidHMRueda01 = 0;
	$TotalPesoRueda01 = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{  
		echo "<tr align='center'>\n";
		echo "<td>".$Cont."</td>\n";
		//CTTE
		if ($Ctte)
		{
			$Consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha = '".$Fila["fecha"]."'";
			$Consulta.= " and cod_producto = '17' and cod_subproducto = '4'";
			$Resp2 = mysqli_query($link, $Consulta);
			$Unidades = 0;
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				echo "<td>".number_format($Fila2["unidades"],0,",",".")."</td>\n";
				$Unidades = $Fila2["unidades"];
			}
			else
			{
				echo "<td>&nbsp;</td>\n";
			}
			$TotalUnidCtteRueda01 = $TotalUnidCtteRueda01 + $Unidades;
		}
		//ESP
		if ($Esp)
		{
			$Consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha = '".$Fila["fecha"]."'";
			$Consulta.= " and cod_producto = '17' and cod_subproducto = '11'";
			$Resp2 = mysqli_query($link, $Consulta);
			$Unidades = 0;
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				echo "<td>".number_format($Fila2["unidades"],0,",",".")."</td>\n";
				$Unidades = $Fila2["unidades"];
			}
			else
			{
				echo "<td>&nbsp;</td>\n";
			}
			$TotalUnidEspRueda01 = $TotalUnidEspRueda01 + $Unidades;
		}
		//HM
		if ($HM)
		{
			$Consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha = '".$Fila["fecha"]."'";
			$Consulta.= " and cod_producto = '17' and cod_subproducto = '8'";
			$Resp2 = mysqli_query($link, $Consulta);
			$Unidades = 0;
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				echo "<td>".number_format($Fila2["unidades"],0,",",".")."</td>\n";
				$Unidades = $Fila2["unidades"];
			}
			else
			{
				echo "<td>&nbsp;</td>\n";
			}
			$TotalUnidHMRueda01 = $TotalUnidHMRueda01 + $Unidades;
		}
		echo "<td align='right'>".number_format($Fila["peso_total"],0,",",".")."</td>\n";		
		$TotalPesoRueda01 = $TotalPesoRueda01 + $Fila["peso_total"];
		echo "</tr>\n";
		$Cont++;
	}
?>
          <tr align="center">
            <td><strong>TOT.</strong></td>
            <?php		
	if ($Ctte)	
    	echo "<td>".number_format($TotalUnidCtteRueda01,0,",",".")."</td>\n";
	if ($Esp)	
    	echo "<td>".number_format($TotalUnidEspRueda01,0,",",".")."</td>\n";
	if ($HM)	
    	echo "<td>".number_format($TotalUnidHMRueda01,0,",",".")."</td>\n";
?>
            <td><?php echo number_format($TotalPesoRueda01,0,",","."); ?></td>
          </tr>
        </table></td>
      </tr>
    </table>
    <br>
	<br>
<?php
	//BUSCA PROMEDIOS REALES
	//TOTAL DE UNIDADES POR CADA UNO DE LOS OTROS PRODUCTOS
	$Consulta = "SELECT cod_producto, cod_subproducto, sum(unidades) as unidades, sum(peso) as peso ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where hornada = '".$Hornada."'";
	$Consulta.= " and tipo_pesaje = 'PA'";
	$Consulta.= " and cod_producto = '17' and cod_subproducto in(4,8,11)";
	$Consulta.= " group by cod_producto, cod_subproducto ";
	$Respuesta = mysqli_query($link, $Consulta);
	$AuxUnidCtte = 0;
	$AuxUnidHM = 0;
	$AuxPesoCtte = 0;
	$AuxPesoHM = 0;
	$PromRealCtte=0;
	$PromRealHM=0;
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
	$Consulta = "SELECT cod_producto, cod_subproducto, sum(unidades) as unidades, sum(peso) as peso ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where hornada = '".$Hornada."'";
	$Consulta.= " group by cod_producto, cod_subproducto";
	$Respuesta = mysqli_query($link, $Consulta);
	
	$UnidCttes=""; //WSO
	$UnidEsp="";
	$UnidHM="";
	$PesoCttes=0;
	$PesoEsp=0;
	$PesoHM=0;
	$TotalUnid=0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		switch ($Fila["cod_subproducto"])
		{
			case 4:
				$UnidCttes = $Fila["unidades"];
				$TotalUnid = $TotalUnid + $Fila["unidades"];
				$PesoCttes = $Fila["peso"];
				$TotalPeso = $TotalPeso + $Fila["peso"];
				break;
			case 8:
				$UnidHM = $Fila["unidades"];
				$TotalUnid = $TotalUnid + $Fila["unidades"];
				$PesoHM = $Fila["peso"];
				$TotalPeso = $TotalPeso + $Fila["peso"];
				break;
			case 11:	
				$UnidEsp = $Fila["unidades"];
				$TotalUnid = $TotalUnid + $Fila["unidades"];
				$PesoEsp = $Fila["peso"];
				$TotalPeso = $TotalPeso + $Fila["peso"];
				break;
		}
	}
?>	
	<table width="338" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr align="center" class="ColorTabla01">
        <td>&nbsp;</td>
        <td><strong>UNIDADES</strong></td>
        <td><strong>PESO</strong></td>
        <td><strong>PROM.</strong></td>
      </tr>
      <tr>
        <td width="95"><strong>CORRIENTES</strong></td>
        <td width="65" align="center"><?php echo number_format($UnidCttes,0,",","."); ?></td>
        <td width="69" align="center"><?php echo number_format($PesoCttes,0,",","."); ?></td>
        <td width="74" align="center"><?php echo number_format($PromRealCtte,0,",","."); ?></td>
      </tr>
      <tr>
        <td><strong>ESPECIALES</strong></td>
        <td align="center"><?php echo number_format($UnidEsp,0,",","."); ?></td>
        <td align="center"><?php echo number_format($PesoEsp,0,",","."); ?></td>
        <td width="74" align="center"><?php echo number_format($PromRealCtte,0,",","."); ?></td>
      </tr>
      <tr>
        <td><strong>HOJAS MADRES</strong></td>
        <td align="center"><?php echo number_format($UnidHM,0,",","."); ?></td>
        <td align="center"><?php echo number_format($PesoHM,0,",","."); ?></td>
        <td align="center"><?php echo number_format($PromRealHM,0,",","."); ?></td>
      </tr>
      <tr>
        <td><strong>TOTAL</strong></td>
        <td align="center"><?php echo number_format($TotalUnid,0,",","."); ?></td>
        <td align="center"><?php echo number_format($TotalPeso,0,",","."); ?></td>
        <td align="center">&nbsp;</td>
      </tr>
    </table>
	<br>
    <br>
    <br>
    <table cellpadding="3" cellspacing="0" width="550" border="0" align="center">
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="center">___________________________________</td>
        <td align="center">___________________________________</td>
      </tr>
      <tr>
        <td width="50%" align="center">PESADOR</td>
        <td width="50%" align="center">ENCARGADO</td>
      </tr>
      <tr>
        <td colspan="2" align="center">  
		    <input name="BtnImprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()"> 
        <input name="BtnSalir" type="button" style="width:70" value="Salir" onClick="JavaScript:Proceso('S')">        </td>
      </tr>
  </table>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
