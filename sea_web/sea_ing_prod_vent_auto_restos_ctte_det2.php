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
<title>Busqueda de Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function Proceso(opt)
{
	var f = document.frmPoPup;
	
	switch (opt) 
	{
		case "S":
			window.opener.document.formulario.action="sea_ing_prod_vent_auto.php?TipoPesaje=2&PesoAuto=checked";
			window.opener.document.formulario.submit();
			window.close();
			break;
		case "R":
			f.action="sea_ing_prod_vent_auto_restos_ctte_det2.php";
			f.submit();	
			break;
		case "M":
			var DiaModif="";
			var MesModif="";
			var AnoModif="";
			var GrupoModif="";
			var LadoModif="";
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name == "ChkPesada" && f.elements[i].checked)
				{							
					var FechaHoraModif = f.elements[i].value;
					var GrupoModif = f.elements[i+1].value;
					var LadoModif = f.elements[i+2].value;
				}
			}
			if (GrupoModif == "")
			{
				alert("No hay ningun registro seleccionado para Modificar");
				return;
			}
			else
			{
			
				//alert (FechaHoraModif);
				window.opener.document.formulario.action="sea_ing_prod_vent_auto.php?Modif=S&GrupoModif=" + GrupoModif + "&LadoModif=" + LadoModif + "&FechaHora=" + FechaHoraModif;
				window.opener.document.formulario.submit();
				window.close();
			}
			break;
		case "E":
			var FechaElim="";
			var GrupoElim="";
			var LadoElim="";
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name == "ChkPesada" && f.elements[i].checked)
				{
					var FechaElim = f.elements[i].value;
					var GrupoElim = f.elements[i+1].value;
					var LadoElim = f.elements[i+2].value;
					var FechaCargaElim = f.elements[i+3].value;
				}
			}
			if (FechaElim == "")
			{
				alert("No hay ningun registro seleccionado para Eliminar");
				return;
			}
			else
			{
				var msg = confirm("�Seguro que desea Eliminar este Pesaje?");
				if (msg==true)
				{
					f.action = "sea_ing_prod_vent_auto01.php?Proceso=E_RestosAnodos&FechaElim=" + FechaElim + "&GrupoElim=" + GrupoElim + "&LadoElim=" + LadoElim + "&FechaCargaElim=" + FechaCargaElim;
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
        <td>Gupo/Lado</td>
        <td width="213"><SELECT name="GrupoLado" onChange="Proceso('R');">
		<option  value = "-1" SELECTed>VER TODAS</option>
		<?php 		
			$Consulta = "SELECT distinct cod_producto, cod_subproducto, ";
			$Consulta.= " case when length(cod_producto)=1 then concat('0',cod_producto) else cod_producto end as orden";
			$Consulta.= " from sea_web.detalle_pesaje";
			$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
			$Consulta.= " and tipo_pesaje = 'RA'";
			$Consulta.= " order by orden, cod_subproducto";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				$GrupoLadoAux = str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT)."-".strtoupper($Fila["cod_subproducto"]);
				if ($GrupoLadoAux == $GrupoLado)
					echo "<option SELECTed value='".$GrupoLadoAux."'>".$GrupoLadoAux."</option>";
				else
					echo "<option value='".$GrupoLadoAux."'>".$GrupoLadoAux."</option>";
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
	<table width="622" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle" >
      <tr align="center" class="ColorTabla01">
        <td width="38">&nbsp;</td>
        <td width="107">Fecha Hora </td>
        <td width="61">Grupo</td>
        <td width="50">Lado</td>
		<td width="40">Carro</td>
		<td width="40">Rack</td>
        <td width="62">Peso</td>
        <td width="75">Cant Cubas</td>
		<td width="100">Fecha Carga</td>
      </tr>
<?php
	$Grupo = intval(substr($GrupoLado,0,2));
	$Lado = substr($GrupoLado,-1);
	if ($GrupoLado != "-1")
	{
		$Consulta = "SELECT fecha, cod_producto, cod_subproducto, peso_total, horno, fecha_carga, num_carro,num_rack, ";
		$Consulta.= " case when length(cod_producto)=1 then concat('0',cod_producto) else cod_producto end as orden";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where cod_producto = '".$Grupo."'";
		$Consulta.= " and cod_subproducto = '".$Lado."'";		
		$Consulta.= " and tipo_pesaje = 'RA'";
		$Consulta.= " order by orden, cod_subproducto, fecha";
	}
	else
	{
		$Consulta = "SELECT fecha,cod_producto, cod_subproducto, peso_total, horno, fecha_carga,num_carro, num_rack,";
		$Consulta.= " case when length(cod_producto)=1 then concat('0',cod_producto) else cod_producto end as orden";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
		$Consulta.= " and tipo_pesaje = 'RA'";
		$Consulta.= " order by orden, cod_subproducto, fecha";
	}
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	$TotalCubas = 0;
	$SubTotalPeso = 0;
	$SubTotalCubas = 0;
	$Cont = 1;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$GrupoLadoAct = str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT)."-".strtoupper($Fila["cod_subproducto"]);		
		if ($Cont != 1 && $GrupoLado == "-1" && $GrupoLadoAnt != $GrupoLadoAct)
		{
			//ESCRIBE SUBTOTALES POR GRUPO
			echo "<tr bgcolor='#FFFFFF'>\n"; 
			echo "<td colspan='6'><strong>TOTAL GRUPO ".$GrupoLadoAnt."</strong></td>\n";
			echo "<td align='center'>".number_format($SubTotalPeso,0,",",".")."</td>\n";
			echo "<td align='center'>".number_format($SubTotalCubas,0,",",".")."</td>\n";
			echo "<td>&nbsp;</td>\n";
			echo "</tr>\n";
			$SubTotalPeso = 0;
			$SubTotalCubas = 0;
		}
		echo "<tr> \n";
		echo "<td align='center'><input type='radio' name='ChkPesada' value='".$Fila["fecha"]."'>";
		echo "<input type='hidden' name='NumGrupo' value='".$Fila["cod_producto"]."'>\n";
		echo "<input type='hidden' name='NumLado' value='".$Fila["cod_subproducto"]."'></td>\n";
		echo "<input type='hidden' name='FechaCarga' value='".$Fila["fecha_carga"]."'></td>\n";
		$FechaHora = substr($Fila["fecha"],8,2)."-".substr($Fila["fecha"],5,2)."-".substr($Fila["fecha"],0,4)." ".substr($Fila["fecha"],11,5);
		echo "<td align='center'>".$FechaHora."</td>\n";
		echo "<td align='center'>".str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT)."</td>\n";	
		echo "<td align='center'>".strtoupper($Fila["cod_subproducto"])."</td>\n";
		echo "<td align='right'>".$Fila["num_carro"]."</td>\n";	
		echo "<td align='right'>".$Fila["num_rack"]."</td>\n";	
		echo "<td align='center'>".number_format($Fila["peso_total"],0,",",".")."</td>\n";
		echo "<td align='center'>".number_format($Fila["horno"],0,",",".")."</td>\n"; //cant_cubas
		$FechaCarga = substr($Fila["fecha_carga"],8,2)."-".substr($Fila["fecha_carga"],5,2)."-".substr($Fila["fecha_carga"],0,4);
		echo "<td align='center'>".$FechaCarga."</td>\n";
	  	echo "</tr> \n";
		$GrupoLadoAnt = str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT)."-".strtoupper($Fila["cod_subproducto"]);
		$SubTotalPeso = $SubTotalPeso + $Fila["peso_total"];
		$SubTotalCubas = $SubTotalCubas + $Fila["horno"];
		$TotalPeso = $TotalPeso + $Fila["peso_total"];
		$TotalCubas = $TotalCubas + $Fila["horno"];
		$Cont++;
	}	
	//ESCRIBE SUBTOTALES POR GRUPO
	echo "<tr bgcolor='#FFFFFF'>\n"; 
	echo "<td colspan='4'><strong>TOTAL GRUPO ".$GrupoLadoAnt."</strong></td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td align='center'>".number_format($SubTotalPeso,0,",",".")."</td>\n";
	echo "<td align='center'>".number_format($SubTotalCubas,0,",",".")."</td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "</tr>\n";
	$SubTotalPeso = 0;
	$SubTotalCubas = 0;
	if ($Cont != 1 && $GrupoLado == "-1" && $GrupoLadoAnt != $GrupoLadoAct)
	{
		//ESCRIBE TOTALES POR GRUPO
		echo "<tr bgcolor='#FFFFFF'>\n"; 
		echo "<td colspan='4'><strong>TOTAL </strong></td>\n";
		echo "<td align='center'>".number_format($TotalPeso,0,",",".")."</td>\n";
		echo "<td align='center'>".number_format($TotalCubas,0,",",".")."</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "</tr>\n"; 	
	}
?>	</table>  
    <br>
    <br>
    <br>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
