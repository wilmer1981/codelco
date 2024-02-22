<?php 
	include("../principal/conectar_sea_web.php");

	//Proceso=B&Hornada=-1&Dia=1&Mes=1&Ano=2022
	if(isset($_REQUEST["Proceso"])) {
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = '';
	}
	if(isset($_REQUEST["Hornada"])) {
		$Hornada = $_REQUEST["Hornada"];
	}else{
		$Hornada = '';
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
			window.opener.document.formulario.action="sea_ing_prod_vent_auto.php";
			window.opener.document.formulario.submit();
			window.close();
			break;
		case "R":
			f.action="sea_ing_prod_vent_auto_anodos_det2.php";
			f.submit();	
			break;
		case "M":
			var DiaModif="";
			var MesModif="";
			var AnoModif="";
			var HornadaModif="";
			var HornoModif="";
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name == "ChkPesada" && f.elements[i].checked)
				{										
					var FechaHoraModif = f.elements[i].value;
					var HornadaModif = f.elements[i+1].value;
					var HornoModif = f.elements[i+2].value;
				}
			}
			if (HornadaModif == "")
			{
				alert("No hay ningun registro seleccionado para Modificar");
				return;
			}
			else
			{
				window.opener.document.formulario.action="sea_ing_prod_vent_auto.php?Modif=S&Hornada=" + HornadaModif + "&Horno=" + HornoModif + "&FechaHora=" + FechaHoraModif;
				window.opener.document.formulario.submit();
				window.close();
			}
			break;
		case "E":
			var Valores="";
			var HornadaElim="";
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name == "ChkPesada" && f.elements[i].checked)
				{
					var Valores = f.elements[i].value;
					var HornadaElim = f.elements[i+1].value;
				}
			}
			if (Valores == "")
			{
				alert("No hay ningun registro seleccionado para Eliminar");
				return;
			}
			else
			{
				var msg = confirm("�Seguro que desea Eliminar este Pesaje?");
				if (msg==true)
				{
					f.action = "sea_ing_prod_vent_auto01.php?Proceso=E_ProdAnodos&FechaElim=" + Valores + "&HornadaElim=" + HornadaElim;
					f.submit();
				}
				else
				{
					return;
				}
			}
			break;
	}    
}

function Imprimir()
{
	var f = document.frmPoPup;
	f.BtnBuscar.style.visibility = "hidden";
	f.BtnImprimir.style.visibility = "hidden";
	f.BtnModificar.style.visibility = "hidden";
	f.BtnEliminar.style.visibility = "hidden";
	f.BtnSalir.style.visibility = "hidden";
	window.print();
	f.BtnBuscar.style.visibility = "visible";
	f.BtnImprimir.style.visibility = "visible";
	f.BtnModificar.style.visibility = "visible";
	f.BtnEliminar.style.visibility = "visible";
	f.BtnSalir.style.visibility = "visible";
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
    <table width="600" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior" >
      <tr class="ColorTabla02"> 
        <td colspan="2"><div align="center"><strong>RESUMEN DE PESADAS </strong></div></td>
      </tr>
      <tr> 
        <td width="108" height="32">Fecha Busqueda</td>
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
</font></td>
      </tr>
      <tr> 
        <td>Hornada</td>
        <td width="213"><SELECT name="Hornada" onChange="Proceso('R');">
		<option  value = "-1" SELECTed>VER TODAS</option>
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
          <font color="#000000" size="2">
          <input name="BtnBuscar" type="button" id="BtnBuscar" style="width:70" onClick="Proceso('R');" value="Buscar">
        </font> </td>
      </tr>
      <tr align="center">
        <td colspan="2"><input name="BtnImprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()">
          <input name="BtnModificar" type="button" id="BtnModificar" style="width:70;" onClick="JavaScript:Proceso('M')" value="Modificar">
          <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70;" onClick="JavaScript:Proceso('E')" value="Eliminar">
          <input name="BtnSalir" type="button" style="width:70" value="Salir" onClick="JavaScript:Proceso('S')"></td>
      </tr>
  </table>
    <br><br>
	<table width="600" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle" >
      <tr align="center" class="ColorTabla01">
        <td width="31" rowspan="2">&nbsp;</td>
        <td width="132" rowspan="2">Fecha Hora </td>
        <td width="64" rowspan="2">Hornada</td>
        <td colspan="2">Ctte</td>
        <td colspan="2">Esp</td>
        <td colspan="2">H.M.</td>
        <td colspan="2"><strong>Total </strong></td>
      </tr>
      <tr align="center" class="ColorTabla01">         
        <td width="40">Unid.</td>
        <td width="36">Peso</td>
        <td width="41">Unid.</td>
        <td width="42">Peso</td>
        <td width="37">Unid.</td>
        <td width="43">Peso</td>
        <td width="29">Unid.</td>
        <td width="36">Peso</td>
      </tr> 
<?php	
	if ($Hornada != "-1")
	{
		$Consulta = "SELECT distinct fecha, horno, hornada, peso_total ";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where hornada = '".$Hornada."'";
		$Consulta.= " and tipo_pesaje = 'PA'";
		$Consulta.= " order by fecha, hornada";
	}
	else
	{
		$Consulta = "SELECT distinct fecha, horno, hornada, peso_total  ";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
		$Consulta.= " and tipo_pesaje = 'PA'";
		$Consulta.= " order by fecha, hornada";
	}	
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	$TotalUnid = 0;
	$TotalUnidCtte = 0;
	$TotalPesoCtte = 0;
	$TotalUnidEsp = 0;
	$TotalPesoEsp = 0;
	$TotalUnidHM = 0;
	$TotalPesoHM = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$TotalUnidFila = 0;
		$TotalPesoFila = $Fila["peso_total"];
		echo "<tr> \n";
		echo "<td align='center'><input type='radio' name='ChkPesada' value='".$Fila["fecha"]."'>";
		echo "<input type='hidden' name='NumHornada' value='".$Fila["hornada"]."'>\n";
		echo "<input type='hidden' name='NumHorno' value='".$Fila["horno"]."'></td>\n";
		$FechaHora = substr($Fila["fecha"],8,2)."-".substr($Fila["fecha"],5,2)."-".substr($Fila["fecha"],0,4)." ".substr($Fila["fecha"],11,5);
		echo "<td align='center'>".$FechaHora."</td>\n";
		echo "<td align='center'>".substr($Fila["hornada"],6)."</td>\n";
		//CTTE
		$Consulta = "SELECT cod_producto, cod_subproducto, hornada, sum(unidades) as unidades, sum(peso) as peso ";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where hornada = '".$Fila["hornada"]."'";
		$Consulta.= " and cod_producto = '17' ";
		$Consulta.= " and cod_subproducto = '4' ";
		$Consulta.= " and fecha = '".$Fila["fecha"]."' ";
		$Consulta.= " and tipo_pesaje = 'PA'";
		$Consulta.= " group by cod_producto, cod_subproducto, hornada ";	
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
		{
			echo "<td align='center'>".number_format($Fila2["unidades"],0,",",".")."</td>\n";
			echo "<td align='center'>".number_format($Fila2["peso"],0,",",".")."</td>\n";
			$TotalUnidCtte = $TotalUnidCtte + $Fila2["unidades"];
			$TotalUnidFila = $TotalUnidFila + $Fila2["unidades"];
			$TotalPesoCtte = $TotalPesoCtte + $Fila2["peso"];
			$TotalUnid = $TotalUnid + $Fila2["unidades"];
			$TotalPeso = $TotalPeso + $Fila2["peso"];
		}
		else
		{
			echo "<td align='center'>&nbsp;</td>\n";
			echo "<td align='center'>&nbsp;</td>\n";
		}
		//ESP.
		$Consulta = "SELECT cod_producto, cod_subproducto, hornada, sum(unidades) as unidades, sum(peso) as peso ";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where hornada = '".$Fila["hornada"]."'";
		$Consulta.= " and cod_producto = '17' ";
		$Consulta.= " and cod_subproducto = '11' ";
		$Consulta.= " and fecha = '".$Fila["fecha"]."' ";
		$Consulta.= " and tipo_pesaje = 'PA'";
		$Consulta.= " group by cod_producto, cod_subproducto, hornada ";	
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
		{
			echo "<td align='center'>".number_format($Fila2["unidades"],0,",",".")."</td>\n";
			echo "<td align='center'>".number_format($Fila2["peso"],0,",",".")."</td>\n";
			$TotalUnidEsp = $TotalUnidEsp + $Fila2["unidades"];
			$TotalUnidFila = $TotalUnidFila + $Fila2["unidades"];
			$TotalPesoEsp = $TotalPesoEsp + $Fila2["peso"];
			$TotalUnid = $TotalUnid + $Fila2["unidades"];
			$TotalPeso = $TotalPeso + $Fila2["peso"];
		}
		else
		{
			echo "<td align='center'>&nbsp;</td>\n";
			echo "<td align='center'>&nbsp;</td>\n";
		}
		//H.M.
		$Consulta = "SELECT cod_producto, cod_subproducto, hornada, sum(unidades) as unidades, sum(peso) as peso ";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where hornada = '".$Fila["hornada"]."'";
		$Consulta.= " and cod_producto = '17' ";
		$Consulta.= " and cod_subproducto = '8' ";
		$Consulta.= " and fecha = '".$Fila["fecha"]."' ";
		$Consulta.= " and tipo_pesaje = 'PA'";
		$Consulta.= " group by cod_producto, cod_subproducto, hornada ";	
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
		{
			echo "<td align='center'>".number_format($Fila2["unidades"],0,",",".")."</td>\n";
			echo "<td align='center'>".number_format($Fila2["peso"],0,",",".")."</td>\n";
			$TotalUnidHM = $TotalUnidHM + $Fila2["unidades"];
			$TotalUnidFila = $TotalUnidFila + $Fila2["unidades"];
			$TotalPesoHM = $TotalPesoHM + $Fila2["peso"];
			$TotalUnid = $TotalUnid + $Fila2["unidades"];
			$TotalPeso = $TotalPeso + $Fila2["peso"];
		}
		else
		{
			echo "<td align='center'>&nbsp;</td>\n";
			echo "<td align='center'>&nbsp;</td>\n";
		}
		echo "<td align='center'>".number_format($TotalUnidFila,0,",",".")."</td>\n";
		echo "<td align='center'>".number_format($TotalPesoFila,0,",",".")."</td>\n";
	  	echo "</tr> \n";
	}
	
?>	<tr> 
	<td colspan="3"><strong>TOTAL </strong></td>
	<td align="center"><?php echo number_format($TotalUnidCtte,0,",","."); ?></td>
	<td align="center"><?php echo number_format($TotalPesoCtte,0,",","."); ?></td>
	<td align="center"><?php echo number_format($TotalUnidEsp,0,",","."); ?></td>
	<td align="center"><?php echo number_format($TotalPesoEsp,0,",","."); ?></td>
	<td align="center"><?php echo number_format($TotalUnidHM,0,",","."); ?></td>
	<td align="center"><?php echo number_format($TotalPesoHM,0,",","."); ?></td>
	<td width="29" align="center"><?php echo number_format($TotalUnid,0,",","."); ?></td>
    <td width="36" align="center"><?php echo number_format($TotalPeso,0,",","."); ?></td>
</tr> </table>  
    <br>
    <br>
    <br>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
