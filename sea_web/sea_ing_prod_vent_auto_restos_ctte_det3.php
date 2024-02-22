<?php 
	include("../principal/conectar_sea_web.php");

	if(isset($_REQUEST["Proceso"])) {
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["Hornada"])) {
		$Hornada = $_REQUEST["Hornada"];
	}else{
		$Hornada = "";
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

	$Fecha = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-".str_pad($Dia,2,"0",STR_PAD_LEFT);

	if(isset($_REQUEST["GrupoLado"])) {
		$GrupoLado = $_REQUEST["GrupoLado"];
	}else{
		$GrupoLado = "";
	}
	if(isset($_REQUEST["GrupoLadoAnt"])) {
		$GrupoLadoAnt = $_REQUEST["GrupoLadoAnt"];
	}else{
		$GrupoLadoAnt = "";
	}

?>

<html>
<head>
<title>Informe de Recepciones</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function Proceso(opt)
{
	var f = document.frmPoPup;
	
	switch (opt) 
	{
		case "S":			
			window.close();
			break;
		case "R":
			f.action="sea_ing_prod_vent_auto_restos_ctte_det3.php";
			f.submit();	
			break;		
	}    
}

function Imprimir()
{
	var f = document.frmPoPup;
	f.BtnBuscar.style.visibility = "hidden";
	f.BtnImprimir.style.visibility = "hidden";	
	f.BtnSalir.style.visibility = "hidden";
	window.print();
	f.BtnBuscar.style.visibility = "visible";
	f.BtnImprimir.style.visibility = "visible";	
	f.BtnSalir.style.visibility = "visible";
}


</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {
	background-image: url(../Principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<form name="frmPoPup" method="post" action="">
    <table width="600" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior" >
      <tr class="ColorTabla02"> 
        <td colspan="2"><div align="center"><strong>RECEPCION DE ANODOS COMERCIALES </strong></div></td>
      </tr>
      <tr> 
        <td width="105" height="32">Fecha Recepcion: </td>
        <td width="484"><font color="#000000" size="2"> 
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
					}
					else
					{
						if ($i==date("n"))						
							echo "<option SELECTed value= '".$i."'>".$Meses[$i-1]."</option>";						
						else												
					  		echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
					} 				   								    		
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
					}
					else
					{
						if ($i==date("Y"))						
							echo "<option SELECTed value= '".$i."'>".$i."</option>";						
						else												
					  		echo "<option value='".$i."'>".$i."</option>";
					} 				   								    		
 				}  		
?>
          </SELECT>
          <input name="BtnBuscar" type="button" id="BtnBuscar2" style="width:70" onClick="Proceso('R');" value="Buscar">
</font></td>
      </tr>
      <tr align="center">
        <td colspan="2"><font color="#000000" size="2">&nbsp;
        </font></td>
      </tr>
  </table>
    <br>          
<?php
	//PRODUCCION RESTOS CORRIENTES Y RESTOS DE RESTOS DE HOJAS MADRE
	echo "<table width='600' border='0' align='center' cellpadding='4' cellspacing='0'>";
	echo "<tr><td valign='top'>";
	$Grupo = intval(substr($GrupoLado,0,2));
	$Lado = substr($GrupoLado,-1);	
	$Consulta = "SELECT fecha,cod_producto, cod_subproducto, peso_total, horno, fecha_carga, ";
	$Consulta.= " case when length(cod_producto)=1 then concat('0',cod_producto) else cod_producto end as orden";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
	$Consulta.= " and tipo_pesaje = 'RA'";
	$Consulta.= " order by orden, cod_subproducto, fecha";
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	$TotalCubas = 0;
	$SubTotalPeso = 0;
	$SubTotalCubas = 0;
	$Cont = 1;
	$ContVueltas = 1;
	$Corr = 1;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$GrupoLadoAct = str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT)."-".strtoupper($Fila["cod_subproducto"]);		
		if ($GrupoLadoAnt != $GrupoLadoAct)
		{
			$Corr=1;
			if ($ContVueltas != 1)
			{
				//ESCRIBE SUBTOTALES POR GRUPO
				echo "<tr bgcolor='#FFFFFF'>\n"; 
				echo "<td><strong>TOTAL</strong></td>\n";
				echo "<td align='center'>".number_format($SubTotalPeso,0,",",".")."</td>\n";
				echo "<td align='center'>".number_format($SubTotalCubas,0,",",".")."</td>\n";
				echo "</tr>\n";
				echo "</table>";
				$SubTotalPeso = 0;
				$SubTotalCubas = 0;
				if ($Cont == 4)
				{
					//CICLO 1 --> CADA 3 COLUMNAS 1 NUEVA FILA
					echo "</tr>\n";
					echo "<tr>\n";
					echo "<td valign='top'>\n";
					$Cont = 1;
				}		
				else
				{
					echo "<td valign='top'>";
				}
			}
			//CICLO 2 --> 3 COLUMNAS POR FILA	
			$FechaCarga = substr($Fila["fecha_carga"],8,2)."-".substr($Fila["fecha_carga"],5,2)."-".substr($Fila["fecha_carga"],0,4);		
			echo "<table width='170' border='1' align='center' cellpadding='2' cellspacing='0' class='TablaDetalle'>\n";
			echo "<tr align='left' class='ColorTabla01'>\n";
			echo "<td colspan='3'><strong>Grupo/Lado:</strong>&nbsp;".$GrupoLadoAct."</td>\n";
			echo "</tr>\n";
			echo "<tr align='left' class='ColorTabla01'>\n";
			echo "<td colspan='3'><strong>Fecha Carga:</strong>&nbsp;".$FechaCarga."</td>\n";
			echo "</tr>\n";
			echo "<tr align='center' class='ColorTabla01'>\n";
			echo "<td width='30'>Num.</td>\n";
			echo "<td width='70'>Peso</td>\n";
			echo "<td width='70'>N.Cubas</td>\n";
			echo "</tr>\n";
			$Cont++;
			
		}
		echo "<tr> \n";
		echo "<td align='center'>".$Corr."</td>\n";
		echo "<td align='center'>".number_format($Fila["peso_total"],0,",",".")."</td>\n";	
		echo "<td align='center'>".number_format($Fila["horno"],0,",",".")."</td>\n";			
	  	echo "</tr> \n";
		$GrupoLadoAnt = str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT)."-".strtoupper($Fila["cod_subproducto"]);
		$SubTotalPeso = $SubTotalPeso + $Fila["peso_total"];
		$SubTotalCubas = $SubTotalCubas + $Fila["horno"];
		$TotalPeso = $TotalPeso + $Fila["peso_total"];
		$TotalCubas = $TotalCubas + $Fila["horno"];		
		$ContVueltas++;
		$Corr++;
	}	
	//ESCRIBE SUBTOTALES POR GRUPO
	echo "<tr bgcolor='#FFFFFF'>\n"; 
	echo "<td><strong>TOTAL</strong></td>\n";
	echo "<td align='center'>".number_format($SubTotalPeso,0,",",".")."</td>\n";
	echo "<td align='center'>".number_format($SubTotalCubas,0,",",".")."</td>\n";
	echo "</tr>\n";
	echo "</table>";
    echo "</td></tr>\n";
	echo "</table>\n";
?>
    <br>
    <table width="600" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior" >
      <tr class="ColorTabla02">
        <td width="589" colspan="2"><div align="center"><strong>RECEPCION DE
              RESTOS DE ANODOS HOJAS MADRE </strong></div></td>
      </tr>
    </table>
    <br>
    <?php
	//PROD RESTOS DE HOJAS MADRE
	echo "<table width='600' border='0' align='center' cellpadding='4' cellspacing='0'>";
	echo "<tr><td valign='top'>";
	$Grupo = intval(substr($GrupoLado,0,2));
	$Lado = substr($GrupoLado,-1);	
	$Consulta = "SELECT fecha,cod_producto, peso_total, horno, fecha_carga, ";
	$Consulta.= " case when length(cod_producto)=1 then concat('0',cod_producto) else cod_producto end as orden";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
	$Consulta.= " and tipo_pesaje = 'RHM'";
	$Consulta.= " and estado <> 'C'";
	$Consulta.= " order by orden, fecha";
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	$TotalCubas = 0;
	$SubTotalPeso = 0;
	$SubTotalCubas = 0;
	$Cont = 1;
	$ContVueltas = 1;
	$Corr = 1;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$GrupoLadoAct = str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT);		
		if ($GrupoLadoAnt != $GrupoLadoAct)
		{
			$Corr=1;
			if ($ContVueltas != 1)
			{
				//ESCRIBE SUBTOTALES POR GRUPO
				echo "<tr bgcolor='#FFFFFF'>\n"; 
				echo "<td><strong>TOTAL</strong></td>\n";
				echo "<td align='center'>".number_format($SubTotalPeso,0,",",".")."</td>\n";
				echo "<td align='center'>".number_format($SubTotalCubas,0,",",".")."</td>\n";
				echo "</tr>\n";
				echo "</table>";
				$SubTotalPeso = 0;
				$SubTotalCubas = 0;
				if ($Cont == 4)
				{
					//CICLO 1 --> CADA 3 COLUMNAS 1 NUEVA FILA
					echo "</tr>\n";
					echo "<tr>\n";
					echo "<td valign='top'>\n";
					$Cont = 1;
				}		
				else
				{
					echo "<td valign='top'>";
				}
			}
			//CICLO 2 --> 3 COLUMNAS POR FILA	
			$FechaCarga = substr($Fila["fecha_carga"],8,2)."-".substr($Fila["fecha_carga"],5,2)."-".substr($Fila["fecha_carga"],0,4);		
			echo "<table width='200' border='1' align='center' cellpadding='2' cellspacing='0' class='TablaDetalle'>\n";
			echo "<tr align='left' class='ColorTabla01'>\n";
			echo "<td colspan='3'><strong>Grupo:</strong>&nbsp;".$GrupoLadoAct."</td>\n";
			echo "</tr>\n";
			echo "<tr align='left' class='ColorTabla01'>\n";
			//CONSULTA CUBAS
			$Consulta = "SELECT distinct cod_producto, cod_subproducto, unidades, peso, fecha_carga, ";
			$Consulta.= " case when length(cod_subproducto)=1 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where tipo_pesaje = 'RHM'";
			$Consulta.= " and cod_producto = '".intval($GrupoLadoAct)."'";
			$Consulta.= " and estado = 'C'";
			$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
			$Consulta.= " order by orden";
			$Resp2 = mysqli_query($link, $Consulta);
			//echo $Consulta;
			$Cubas = "";
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$Cubas = $Cubas.$Fila2["orden"]."-";
			}
			$Cubas = substr($Cubas,0,strlen($Cubas)-1);
			echo "<td colspan='3'><strong>Cubas:</strong>&nbsp;".$Cubas."</td>\n";
			echo "</tr>\n";
			echo "<tr align='center' class='ColorTabla01'>\n";
			echo "<td width='30'>Num.</td>\n";
			echo "<td width='70'>Peso</td>\n";
			echo "<td width='70'>N.Cubas</td>\n";
			echo "</tr>\n";
			$Cont++;
			
		}
		echo "<tr> \n";
		echo "<td align='center'>".$Corr."</td>\n";
		echo "<td align='center'>".number_format($Fila["peso_total"],0,",",".")."</td>\n";	
		echo "<td align='center'>".number_format($Fila["horno"],0,",",".")."</td>\n";			
	  	echo "</tr> \n";
		$GrupoLadoAnt = str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT);
		$SubTotalPeso = $SubTotalPeso + $Fila["peso_total"];
		$SubTotalCubas = $SubTotalCubas + $Fila["horno"];
		$TotalPeso = $TotalPeso + $Fila["peso_total"];
		$TotalCubas = $TotalCubas + $Fila["horno"];		
		$ContVueltas++;
		$Corr++;
	}	
	//ESCRIBE SUBTOTALES POR GRUPO
	echo "<tr bgcolor='#FFFFFF'>\n"; 
	echo "<td><strong>TOTAL</strong></td>\n";
	echo "<td align='center'>".number_format($SubTotalPeso,0,",",".")."</td>\n";
	echo "<td align='center'>".number_format($SubTotalCubas,0,",",".")."</td>\n";
	echo "</tr>\n";
	echo "</table>";
    echo "</td></tr>\n";
	echo "</table>\n";
?>
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
          <font color="#000000" size="2">
          <input name="BtnImprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()">
          </font>
          <input name="BtnSalir" type="button" style="width:70" value="Salir" onClick="JavaScript:Proceso('S')"></td>
      </tr>
    </table>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
