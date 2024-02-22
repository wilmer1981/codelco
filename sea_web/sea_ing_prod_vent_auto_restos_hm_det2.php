<?php 
	include("../principal/conectar_sea_web.php");

	//Proceso=B&Grupo=-1&Dia=1&Mes=1&Ano=2022
	if(isset($_REQUEST["Proceso"])) {
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = '';
	}
	if(isset($_REQUEST["Grupo"])) {
		$Grupo = $_REQUEST["Grupo"];
	}else{
		$Grupo = '';
	}
	if(isset($_REQUEST["Ano"])) {
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = date("Y");
	}
	if(isset($_REQUEST["Mes"])) {
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date("M");
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
			f.action="sea_ing_prod_vent_auto_restos_hm_det2.php";
			f.submit();	
			break;
		case "M":
			var DiaModif="";
			var MesModif="";
			var AnoModif="";
			var GrupoModif="";
			var CorrModif="";
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name == "ChkPesada" && f.elements[i].checked)
				{										
					var FechaHoraModif = f.elements[i].value;
					var GrupoModif = f.elements[i+1].value;
					var CorrModif = f.elements[i+2].value;
				}
			}
			if (GrupoModif == "")
			{
				alert("No hay ningun registro seleccionado para Modificar");
				return;
			}
			else
			{
				window.opener.document.formulario.action="sea_ing_prod_vent_auto.php?Modif=S&GrupoModif=" + GrupoModif + "&CorrModif=" + CorrModif + "&FechaHora=" + FechaHoraModif;
				window.opener.document.formulario.submit();
				window.close();
			}
			break;
		case "E":
			var FechaHoraElim = "";
			var GrupoModif = "";
			var CorrModif = "";
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name == "ChkPesada" && f.elements[i].checked)
				{										
					var FechaHoraElim = f.elements[i].value;
					var GrupoElim = f.elements[i+1].value;
					var CorrElim = f.elements[i+2].value;
				}
			}
			if (FechaHoraElim == "")
			{
				alert("No hay ningun registro seleccionado para Eliminar");
				return;
			}
			else
			{
				var msg = confirm("�Seguro que desea Eliminar este Pesaje?");
				if (msg==true)
				{
					f.action = "sea_ing_prod_vent_auto01.php?Proceso=E_RestosHM&GrupoElim=" + GrupoElim + "&CorrElim=" + CorrElim + "&FechaHoraElim=" + FechaHoraElim;
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
        <td>Gupos</td>
        <td width="213"><SELECT name="Grupo" onChange="Proceso('R');">
		<option  value = "-1" SELECTed>VER TODOS</option>
		<?php 		
			$Consulta = "SELECT distinct cod_producto, ";
			$Consulta.= " case when length(cod_producto)=1 then concat('0',cod_producto) else cod_producto end as orden";
			$Consulta.= " from sea_web.detalle_pesaje";
			$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
			$Consulta.= " and tipo_pesaje = 'RHM'";
			$Consulta.= " and estado = 'C'";
			$Consulta.= " order by orden";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				$GrupoAux = str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT);
				if ($GrupoAux == $Grupo)
					echo "<option SELECTed value='".$GrupoAux."'>".$GrupoAux."</option>";
				else
					echo "<option value='".$GrupoAux."'>".$GrupoAux."</option>";
			}
	   ?></SELECT>
          <font color="#000000" size="2">
          <input name="BtnBuscar" type="button" id="BtnBuscar" style="width:70" onClick="Proceso('R');" value="Buscar">
        </font>        <font color="#000000" size="2">&nbsp;        </font> </td>
      </tr>
      <tr align="center">
        <td colspan="2"><input name="BtnImprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()">
          <input name="BtnModificar" type="button" id="BtnModificar" style="width:70;" onClick="JavaScript:Proceso('M')" value="Modificar">
          <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70;" onClick="JavaScript:Proceso('E')" value="Eliminar">
          <input name="BtnSalir" type="button" style="width:70" value="Salir" onClick="JavaScript:Proceso('S')"></td>
      </tr>
  </table>
    <br><br>
	<table width="450" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle" >
      <tr align="center" class="ColorTabla01">
        <td width="38">&nbsp;</td>
        <td width="107">Fecha Hora </td>
        <td width="61">Grupo</td>
        <td width="62">Peso</td>
        <td width="75">Cant Cubas</td>
	  </tr>
<?php
	$Grupo = intval($Grupo);
	if ($Grupo != "-1")
	{
		$Consulta = "SELECT fecha, cod_producto, cod_subproducto, peso_total, horno, fecha_carga, ";
		$Consulta.= " case when length(cod_producto)=1 then concat('0',cod_producto) else cod_producto end as orden";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where cod_producto = '".$Grupo."'";
		$Consulta.= " and tipo_pesaje = 'RHM'";
		$Consulta.= " and estado <> 'C'";
		$Consulta.= " order by orden, fecha";
	}
	else
	{
		$Consulta = "SELECT fecha,cod_producto, cod_subproducto, peso_total, horno, fecha_carga, ";
		$Consulta.= " case when length(cod_producto)=1 then concat('0',cod_producto) else cod_producto end as orden";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
		$Consulta.= " and tipo_pesaje = 'RHM'";
		$Consulta.= " and estado <> 'C'";
		$Consulta.= " order by orden, fecha";
	}
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	$TotalCubas = 0;
	$SubTotalPeso = 0;
	$SubTotalCubas = 0;
	$Cont = 1;	
	$GrupoAnt=0; //WSO
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$GrupoAct = str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT);		
		if ($Cont != 1 && $Grupo == "-1" && $GrupoAnt != $GrupoAct)
		{
			//ESCRIBE SUBTOTALES POR GRUPO
			echo "<tr bgcolor='#FFFFFF'>\n"; 
			echo "<td colspan='3'><strong>TOTAL GRUPO ".$GrupoAnt."</strong></td>\n";
			echo "<td align='center'>".number_format($SubTotalPeso,0,",",".")."</td>\n";
			echo "<td align='center'>".number_format($SubTotalCubas,0,",",".")."</td>\n";
			echo "</tr>\n";
			$SubTotalPeso = 0;
			$SubTotalCubas = 0;
		}
		echo "<tr> \n";
		echo "<td align='center'><input type='radio' name='ChkPesada' value='".$Fila["fecha"]."'>";
		echo "<input type='hidden' name='NumGrupo' value='".$Fila["cod_producto"]."'>\n";
		echo "<input type='hidden' name='NumCorr' value='".$Fila["cod_subproducto"]."'></td>\n";
		$FechaHora = substr($Fila["fecha"],8,2)."-".substr($Fila["fecha"],5,2)."-".substr($Fila["fecha"],0,4)." ".substr($Fila["fecha"],11,5);
		echo "<td align='center'>".$FechaHora."</td>\n";
		echo "<td align='center'>".str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT)."</td>\n";	
		echo "<td align='center'>".number_format($Fila["peso_total"],0,",",".")."</td>\n";
		echo "<td align='center'>".number_format($Fila["horno"],0,",",".")."</td>\n"; //cant_cubas		
	  	echo "</tr> \n";
		$GrupoAnt = str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT);
		$SubTotalPeso = $SubTotalPeso + $Fila["peso_total"];
		$SubTotalCubas = $SubTotalCubas + $Fila["horno"];
		$TotalPeso = $TotalPeso + $Fila["peso_total"];
		$TotalCubas = $TotalCubas + $Fila["horno"];
		$Cont++;
	}	
	//ESCRIBE SUBTOTALES POR GRUPO
	echo "<tr bgcolor='#FFFFFF'>\n"; 
	echo "<td colspan='3'><strong>TOTAL GRUPO ".$GrupoAnt."</strong></td>\n";
	echo "<td align='center'>".number_format($SubTotalPeso,0,",",".")."</td>\n";
	echo "<td align='center'>".number_format($SubTotalCubas,0,",",".")."</td>\n";
	echo "</tr>\n";
	$SubTotalPeso = 0;
	$SubTotalCubas = 0;
	if ($Cont != 1 && $Grupo == "-1")
	{
		//ESCRIBE TOTALES POR GRUPO
		echo "<tr bgcolor='#FFFFFF'>\n"; 
		echo "<td colspan='3'><strong>TOTAL </strong></td>\n";
		echo "<td align='center'>".number_format($TotalPeso,0,",",".")."</td>\n";
		echo "<td align='center'>".number_format($TotalCubas,0,",",".")."</td>\n";
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
