<?php 
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 2;
	include("../principal/conectar_pmn_web.php");
	include('funciones/pmn_funciones.php'); 
	
	if ($ModifDese == "S" and $Prod01 == "")
	{
		
		if (isset($NumHorno01))
			$NumHorno = $NumHorno01;
		if (isset($NumFunda01))
			$NumFunda = $NumFunda01;
		if (isset($HornadaTotal01))
			$HornadaTotal = $HornadaTotal01;
		if (isset($HornadaParcial01))
			$HornadaParcial = $HornadaParcial01;		
		if (isset($Dia01))
			$DiaDese = $Dia01;
		if (isset($Mes01))
			$MesDese = $Mes01;
		if (isset($Ano01))
			$AnoDese = $Ano01;
			$Producto ="";
			
		$Consulta = "Select * from pmn_web.deselenizacion ";
		$Consulta.= " where fecha = '".$AnoDese."-".$MesDese."-".$DiaDese."'";
		$Consulta.= " and num_horno = '".$NumHorno."'";
		$Consulta.=" and num_funda='".$NumFunda."'";
		$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
		$Consulta.=" and hornada_parcial='".$HornadaParcial."'		";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$NumHorno = $Row[num_horno];
			$NumFunda = $Row[num_funda];
			$HornadaTotal = $Row[hornada_total];
			$HornadaParcial = $Row[hornada_parcial];
			$KwhIni = number_format($Row[kwh_ini],2,',','.');
			$KwhFin = number_format($Row[kwh_fin],2,',','.');
			$SacosCarbon = $Row[sacos_carbon];
			$Operador01 = $Row[operador];
			$Acidc = number_format($Row[acidc],2,',','.');
			$Petracel = number_format($Row[petracel],2,',','.');
			$ArregloFecha = explode("-",$Row[fecha_salida]);
			$AnoSalida = $ArregloFecha[0];
			$MesSalida = $ArregloFecha[1];
			$DiaSalida = $ArregloFecha[2];
			$ProdCalcina = number_format($Row[prod_calcina],2,',','.');
			$Operador02 = $Row[operador_02];
			$Turno = $Row[turno];
			$ObsDese= $Row["observacion"];
		}
	}
	//echo "modif".$Modif."-".$Prod01;
	if ($ModifDese == "S" and $Prod01 <> "")
	{
		//echo "horno1xxxx".$NumHorno01."----".$NumHorno;
		if (isset($NumHorno01))
			$NumHorno = $NumHorno01;
		if (isset($NumFunda01))
			$NumFunda = $NumFunda01;
		if (isset($HornadaTotal01))
			$HornadaTotal = $HornadaTotal01;
		if (isset($HornadaParcial01))
			$HornadaParcial = $HornadaParcial01;		
		if (isset($Dia01))
			$DiaDese = $Dia01;
		if (isset($Mes01))
			$MesDese = $Mes01;
		if (isset($Ano01))
			$AnoDese = $Ano01;
		if (isset($Prod01))
			$Prod =$Prod01;
		if (isset($Subp01))
			$Subp =$Subp01;	
			//echo "NumHornoppppp :".$NumHorno;
		$Consulta = "Select * from pmn_web.observaciones ";
		$Consulta.= " where fecha = '".$AnoDese."-".$MesDese."-".$DiaDese."'";
		$Consulta.= " and num_horno = '".$NumHorno."'";
		$Consulta.=" and num_funda='".$NumFunda."'";
		$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
		$Consulta.=" and hornada_parcial='".$HornadaParcial."' ";
		$Consulta.=" and cod_producto   ='".$Prod."' and cod_subproducto = '".$Subp."'";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$NumHorno = $Row[num_horno];
			$NumFunda = $Row[num_funda];
			$HornadaTotal = $Row[hornada_total];
			$HornadaParcial = $Row[hornada_parcial];
			$KwhIni = number_format($Row[kwh_ini],2,',','.');
			$KwhFin = number_format($Row[kwh_fin],2,',','.');
			$SacosCarbon = $Row[sacos_carbon];
			$Operador01 = $Row[rut];
			$Producto = $Row["cod_producto"];
			$SubProducto=$Row["cod_subproducto"];
			$textotxt =$Row["observacion"];	
		}
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_pmn_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
<!--
function ValidaDese()
{
	var f = document.frmPrincipalRpt;
	
	for (i=1;i < f.CheckDetalle.length;i++)
	{
		if ((f.CheckDetalle[i].checked == true) && (f.Tipo_H[i].value == 'L'))
		{			
			if ((f.BAD[i].value) > (parseFloat(f.StockActual[i].value) + parseFloat(f.AuxBad[i].value)))
			{
				alert("La Lix. N " + f.CheckDetalle[i].value + " Excede el Peso de Carga");
				return false;
			}
		}	
	}
	return true;
}
/****************/
function ProcesoDese(opt)
{
	var f = document.frmPrincipalRpt;
	switch (opt)
	{
		case "GL": //GRABA LIXIVIACION
			if (f.NumHorno.value == "")
			{
				alert("Debe Ingresar Numero Horno");
				f.NumHorno.focus();
				return;
			}
			if (f.NumFunda.value == "")
			{
				alert("Debe Ingresar Numero Funda");
				f.NumFunda.focus();
				return;
			}
			if (f.HornadaTotal.value == "")
			{
				alert("Debe Ingresar Hornada Total");
				f.HornadaTotal.focus();
				return;
			}
			if (f.HornadaParcial.value == "")
			{
				alert("Debe Ingresar Hornada Parcial");
				f.HornadaParcial.focus();
				return;
			}
			if (f.Lixiviacion.value == "S")
			{
				alert("Debe seleccionar Lixiviacion");
				f.Lixiviacion.focus();
				return;
			}			
			f.action = "pmn_ing_deselenizacion01.php?Proceso=GL";
			f.submit();
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=102";
			f.submit();
			break;
		case "R":
			f.action = "pmn_principal_reportes.php?Tab8=true";
			f.submit();
			break;
		case "DP": //DETALLE PRODUCTO EXTERNO
		
			if (f.NumHorno.value == "")
			{
				alert("Debe Ingresar Numero Horno");
				f.NumHorno.focus();
				return;
			}
			if (f.NumFunda.value == "")
			{
				alert("Debe Ingresar Numero Funda");
				f.NumFunda.focus();
				return;
			}
			if (f.HornadaTotal.value == "")
			{
				alert("Debe Ingresar Hornada Total");
				f.HornadaTotal.focus();
				return;
			}
			if (f.HornadaParcial.value == "")
			{
				alert("Debe Ingresar Hornada Parcial");
				f.HornadaParcial.focus();
				return;
			}
			if (f.Producto.value == "S")
			{
				alert("Debe seleccionar un Producto");
				f.Producto.focus();
				return;
			}
			if (f.Subproducto.value == "S")
			{
				alert("Debe seleccionar un SubProducto");
				f.Subproducto.focus();
				return;
			}			
			
			//URL="pmn_detalle_productos.php?Prod=" + f.Producto.value + "&SubProd=" + f.Subproducto.value + "&Hornada01=" + f.Hornada.value + "&Dia01=" + f.Dia.value + "&Mes01=" + f.Mes.value + "&Ano01=" + f.Ano.value;
			//URL="pmn_detalle_productos.php?Prod=" + f.Producto.value + "&SubProd=" + f.Subproducto.value + "&Hornada01=" + f.Hornada.value + "&Dia01=" + f.Dia.value + "&Mes01=" + f.Mes.value + "&Ano01=" + f.Ano.value;
			URL="pmn_detalle_productos.php?Prod=" + f.Producto.value + "&SubProd=" + f.Subproducto.value + "&NumHorno=" + f.NumHorno.value + "&NumFunda="+ f.NumFunda.value + "&HornadaTotal="+ f.HornadaTotal.value +"&HornadaParcial="+f.HornadaParcial.value + "&Dia=" + f.DiaDese.value + "&Mes=" + f.MesDese.value + "&Ano=" + f.AnoDese.value;
			URL = URL + "&KwhIni=" + f.KwhIni.value + "&KwhFin=" + f.KwhFin.value + "&SacosCarbon=" + f.SacosCarbon.value + "&Operador01=" + f.Operador01.value + "&Acidc=" + f.Acidc.value + "&Petracel=" + f.Petracel.value;
			URL = URL + "&ProdCalcina=" + f.ProdCalcina.value + "&Operador02=" + f.Operador02.value + "&DiaSalida=" + f.DiaSalida.value + "&MesSalida=" + f.MesSalida.value + "&AnoSalida=" + f.AnoSalida.value + "&Turno="+f.Turno.value;
			window.open(URL,"","top=50px,left=60px, width=700px, height=400px, menubar=no, resizable=yes, scrollbars=yes");
			break
	
			case "OBS": //Graba observacion
			if (f.NumHorno.value == "")
			{
				alert("Debe Ingresar Numero Horno");
				f.NumHorno.focus();
				return;
			}
			if (f.NumFunda.value == "")
			{
				alert("Debe Ingresar Numero Funda");
				f.NumFunda.focus();
				return;
			}
			if (f.HornadaTotal.value == "")
			{
				alert("Debe Ingresar Hornada Total");
				f.HornadaTotal.focus();
				return;
			}
			if (f.HornadaParcial.value == "")
			{
				alert("Debe Ingresar Hornada Parcial");
				f.HornadaParcial.focus();
				return;
			}
			if (f.Producto.value == "S")
			{
				alert("Debe seleccionar un Producto");
				f.Producto.focus();
				return;
			}
			if (f.Subproducto.value == "S")
			{
				alert("Debe seleccionar un SubProducto");
				f.Subproducto.focus();
				return;
			}			
 				
 			if (f.textotxt.value == "")
			{
				alert("Debe Ingresar Observacin");
				f.textotxt.focus();
				return;
			}			
	 			//alert (f.Producto.value);
			  //alert (f.Subproducto.value);
			 // alert (f.textotxt.value);
			  	     
			f.action ="pmn_detalle_observacion.php?Prod=" + f.Producto.value + "&SubProd=" + f.Subproducto.value + "&NumHorno=" + f.NumHorno.value + "&NumFunda="+ f.NumFunda.value + "&HornadaTotal="+ f.HornadaTotal.value +"&HornadaParcial="+f.HornadaParcial.value + "&Dia=" + f.Dia.value + "&Mes=" + f.Mes.value + "&Ano=" + f.Ano.value + "&KwhIni=" + f.KwhIni.value + "&KwhFin=" + f.KwhFin.value + "&SacosCarbon=" + f.SacosCarbon.value + "&Operador01=" + f.Operador01.value + "&Turno="+ f.Turno.value + "&textotxt=" +f.textotxt.value; 
			f.submit();


			break
		case 'MT': //CHEQKEAR TODOS
			try
			{
				for (i=1;i < f.CheckDetalle.length;i++)
				{
					if (f.CheckTodos.checked == true)
						f.CheckDetalle[i].checked = true;
					else	f.CheckDetalle[i].checked = false;
				}
			}
			catch (e)
			{
				alert("No hay nada para seleccionar");
			}
			break
		case "Eli"://elimina de observaciones(reproceso, remanente	
			var mensaje = confirm("Esta seguro que desea eliminar los Datos?");
			if (mensaje == true)
			{
				var f=document.frmPrincipal;
				f.action = "pmn_ing_deselenizacion01.php?Proceso=Eli" + "&Prod=" + f.Producto.value + "&SubProd=" + f.Subproducto.value + "&NumHorno=" + f.NumHorno.value + "&NumFunda="+ f.NumFunda.value + "&HornadaTotal="+ f.HornadaTotal.value +"&HornadaParcial="+f.HornadaParcial.value + "&Dia=" + f.Dia.value + "&Mes=" + f.Mes.value + "&Ano=" + f.Ano.value + "&KwhIni=" + f.KwhIni.value + "&KwhFin=" + f.KwhFin.value + "&SacosCarbon=" + f.SacosCarbon.value + "&Operador01=" + f.Operador01.value + "&Turno="+ f.Turno.value + "&textotxt=" +f.textotxt.value;
				f.submit();
			}
			else
			{
				return;
			}
			
		break
		case "E": //ELIMINAR
			var StrTipos = "";
			var StrProductos = "";
			var StrSubproductos = "";
			var StrIdProductos = "";
			var StrValores = "";
			var Valores = "";
				for (i=1;i < f.CheckDetalle.length;i++)
				{
					if (f.CheckDetalle[i].checked == true)
					{						
						StrTipos = StrTipos + f.Tipo_H[i].value + "~";
						StrProductos = StrProductos + f.Producto_H[i].value + "~";
						StrSubproductos = StrSubproductos + f.SubProducto_H[i].value + "~";
						StrIdProductos = StrIdProductos + f.IdProducto_H[i].value + "~";
						Valores = Valores + f.CheckDetalle[i].value + "~";
						StrValores = StrValores + f.BAD[i].value + "~";
					}
				}
			if (Valores != "")
			{
				var mensaje = confirm("Esta seguro que desea eliminar este(os) registro(s)?");
				if (mensaje == true)
				{					
					f.MarcadosTipos.value = StrTipos;
					f.MarcadosProductos.value = StrProductos;
					f.MarcadosSubproductos.value = StrSubproductos;
					f.MarcadosIdProductos.value = StrIdProductos;
					f.MarcadosReferencias.value = Valores;
					f.MarcadosValores.value = StrValores;
					f.action = "pmn_ing_deselenizacion01.php?Proceso=E";
					f.submit();
				}
				else
				{
					return;
				}
			}
			else
			{
				alert('Debe Seleccionar detalle para Eliminar Produccin')
				return;
			}
			break;
		case "GD": //GRABA TODO Y LOS DETALLES, INCLUYE LOS DATOS DE B.A.D.
			if (ValidaDese() == true)
			{			
				var StrTipos = "";
				var StrProductos = "";
				var StrSubproductos = "";
				var StrIdProductos = "";
				var StrReferecias = "";
				var StrValores = "";
				var StrValAux = "";
					for (i=1;i < f.CheckDetalle.length;i++)
					{						
						if (f.CheckDetalle[i].checked == true)
						{
							StrTipos = StrTipos + f.Tipo_H[i].value + "~";
							StrProductos = StrProductos + f.Producto_H[i].value + "~";
							StrSubproductos = StrSubproductos + f.SubProducto_H[i].value + "~";
							StrIdProductos = StrIdProductos + f.IdProducto_H[i].value + "~";
							StrReferecias = StrReferecias + f.CheckDetalle[i].value + "~";
							StrValores = StrValores + f.BAD[i].value + "~";
							if (f.Tipo_H[i].value == 'L')
								StrValAux = StrValAux + f.AuxBad[i].value + "~";
						}
					}
				if (StrValores != "")
				{		
					f.MarcadosTipos.value = StrTipos;
					f.MarcadosProductos.value = StrProductos;
					f.MarcadosSubproductos.value = StrSubproductos;
					f.MarcadosIdProductos.value = StrIdProductos;
					f.MarcadosReferencias.value = StrReferecias;
					f.MarcadosValores.value = StrValores;
					f.MarcadosValAux.value = StrValAux;
					//alert(f.MarcadosTipos.value);
				}
				f.action = "pmn_ing_deselenizacion01.php?Proceso=GD";
				f.submit();
			}
			break;
		case "C":
			URL="pmn_detalle_deselenizacion.php?DiaConsulta=" + f.DiaDese.value + "&MesConsulta=" + f.MesDese.value + "&AnoConsulta=" + f.AnoDese.value+"&Tab8=true";
			//URL="poly_1.php?DiaConsulta=" + f.Dia.value + "&MesConsulta=" + f.Mes.value + "&AnoConsulta=" + f.Ano.value;

			window.open(URL,"","top=50px,left=90px, width=700px, height=400px, menubar=no, resizable=yes, scrollbars=yes");
			break;
		case "H":
			URL="pmn_detalle_deselenizacion01.php?NumHorno=" + f.NumHorno.value +"&NumFunda="+f.NumFunda.value+"&HornadaTotal="+f.HornadaTotal.value+"&HornadaParcial="+f.HornadaParcial.value;
			window.open(URL,"","top=50px,left=100px, width=690px, height=400px, menubar=no, resizable=yes, scrollbars=yes");
			break;
		case "CAN":
			f.action = "pmn_ing_deselenizacion01.php?Proceso=CAN";
			f.submit();
			break;
		case "Mod":
			window.open("pmn_ing_hornada_nueva.php?Prod=" + f.Producto.value + "&SubProd=" + f.Subproducto.value + "&NumHorno=" + f.NumHorno.value + "&NumFunda="+ f.NumFunda.value + "&HornadaTotal="+ f.HornadaTotal.value +"&HornadaParcial="+f.HornadaParcial.value + "&Dia=" + f.DiaDese.value + "&Mes=" + f.MesDese.value + "&Ano=" + f.AnoDese.value + "&KwhIni=" + f.KwhIni.value + "&KwhFin=" + f.KwhFin.value + "&SacosCarbon=" + f.SacosCarbon.value + "&Operador01=" + f.Operador01.value + "&Turno="+ f.Turno.value,""," fullscreen=no,width=500,height=200,scrollbars=yes,resizable = yes");

			
		
	}
}

function TeclaPulsada1Dese(salto) 
{ 
	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}
function CalculaCalcina()
{
	var f = document.frmPrincipalRpt;
	if(f.TotalBAD.value!='0' && f.TotalBAD.value!='')
	{
		var Valor=(parseInt(f.TotalBAD.value)*parseInt(f.PorcCalcina.value))/100;
		f.ProdCalcina.value=addCommas(Valor);
	}
	else
	{
		alert('No se Puede Calcular, Total BAD en Cero.')
		return;
	}
}
function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? ',' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return x1 + x2;
}
-->
</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
	<?php
		if ($ModifDese != S)
		{
			//echo '<body leftmargin="3" topmargin="2"  onLoad="document.frmPrincipalDese.NumHorno.focus();">';
			echo '<body leftmargin="3" topmargin="2"  >';
	
		}
		else
		{
			//if ($Producto <> '39')
			//{
				//echo '<body leftmargin="3" topmargin="2"  onLoad="document.frmPrincipalDese.Producto.focus();">';
				echo '<body leftmargin="3" topmargin="2" >';
			//}
			//else
			//{	
				//echo '<body leftmargin="3" topmargin="2"  onLoad="document.frmPrincipal.textotxt.focus();">';
			//}
		}
	?>	
<form name="frmPrincipalDese" action="" method="post">
<input type="hidden" name="MarcadosTipos" value="">
<input type="hidden" name="MarcadosProductos" value="">
<input type="hidden" name="MarcadosSubproductos" value="">
<input type="hidden" name="MarcadosIdProductos" value="">
<input type="hidden" name="MarcadosReferencias" value="">
<input type="hidden" name="MarcadosValores" value="">
<input type="hidden" name="MarcadosValAux" value="">
<?php //include("../principal/encabezado.php");?>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="TituloCabeceraOz">
    <tr> 
      <td colspan="2" valign="top"> 
	  	<table width="100%" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="114" class="titulo_azul">Fecha</td>
            <td width="360"> 
              <?php 
				if ($ModifDese == "S")
				{
					echo "<input type='hidden' name='DiaDese' value='".$DiaDese."'>\n";
					echo "<input type='hidden' name='MesDese' value='".$MesDese."'>\n";
					echo "<input type='hidden' name='AnoDese' value='".$AnoDese."'>\n";
					printf("%'02d",$DiaDese);
					echo "-";
					printf("%'02d",$MesDese);
					echo "-";
					printf("%'04d",$AnoDese);
				}
				else
				{
					echo "<select name='DiaDese' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaDese))
						{
							if ($i == $DiaDese)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == $DiaActual)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
				  echo "</select> <select name='MesDese' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesDese))
						{
							if ($i == $MesDese)
								echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
						else
						{
							if ($i == $MesActual)
								echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
					}
				  echo "</select> <select name='AnoDese' style='width:60px'>\n";
					for ($i=2002;$i<=date("Y");$i++)
					{
						if (isset($AnoDese))
						{
							if ($i == $AnoDese)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == $AnoActual)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
					echo "</select>\n";
				}
			?>            </td>
            <td width="42" class="titulo_azul">Turno</td>
            <td width="90"> 
              <?php
			if ($ModifDese == "S")
			{
				$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase='".$Turno."'";
				$result2 = mysqli_query($link, $sql);
				if ($row2=mysqli_fetch_array($result2))
					echo "<font>".strtoupper($row2["nombre_subclase"])."</font>";
				else	echo "<font>N</font>";
				echo "<input type='hidden' name='Turno' value='".$Turno."'>";
			}
			else
			{		
				echo "<select name='Turno' style='width:50'>\n";
				$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase not in('2') order by cod_subclase";
				$result = mysqli_query($link, $sql);
				while ($row=mysqli_fetch_array($result))
				{
					if ($Turno == $row["cod_subclase"])
						echo "<option selected value='".$row["cod_subclase"]."'>".strtoupper($row["nombre_subclase"])."</option>\n";
					else	echo "<option value='".$row["cod_subclase"]."'>".strtoupper($row["nombre_subclase"])."</option>\n";
				}
				echo "</select>\n";
			}
			?>            </td>
            <td width="437"><input type="button" name="btnVerDia" value="Consultar" onClick="ProcesoDese('C');"></td>
          </tr>
        </table>
        <br> 
        <table width="100%" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="138" height="53" class="titulo_azul">Hornada : </td>
            <td width="469"> 
              <?php
				if ($ModifDese == "S")
				{
					//echo $Hornada;
					//echo "<input name='Hornada' type='hidden' value='".$Hornada."'>\n";
					echo $NumHorno;
					echo "-";
					echo "<input name='NumHorno' type='hidden' value='".$NumHorno."'>\n";
					echo $NumFunda;
					echo "-";
					echo "<input name='NumFunda' type='hidden' value='".$NumFunda."'>\n";
					echo $HornadaTotal;
					echo "-";
					echo "<input name='HornadaTotal' type='hidden' value='".$HornadaTotal."'>\n";
					echo $HornadaParcial;
					echo "<input name='HornadaParcial' type='hidden' value='".$HornadaParcial."'>\n";
				
				}
				else
				{
					echo "#H";
				?>
					<input name="NumHorno" type="text" id="NumHorno" onKeyDown="TeclaPulsada1Dese('NumFunda')"   value="<?php echo $NumHorno;?>" size='2' maxlength='1'>
				<?php
					echo "#F";
					
				?>
					<input name="NumFunda" type="text" id="Numfunda" onKeyDown="TeclaPulsada1Dese('HornadaTotal')"  value="<?php echo $NumFunda;?>" size='2' maxlength='2'>
				<?php	
					echo "H.T";
				?>	
					<input name="HornadaTotal" type="text" id="HornadaTotal" onKeyDown="TeclaPulsada1Dese('HornadaParcial')" value="<?php echo $HornadaTotal;?>" size='2' maxlength='2'>
				<?php	
					echo "H.P";
					
				?>	
					<input name="HornadaParcial" type="text" id="HornadaParcial" onKeyDown="TeclaPulsada1Dese('KwhIni')"  value="<?php echo $HornadaParcial;?>" size='2' maxlength='1'>
				<?php
				}
			?>
                <input name="BtnHornada" type="button" id="BtnHornada" value="Ver " onClick="ProcesoDese('H');" >			  
              <input name='modifica' type='hidden' value="modifica">
            <div align="right"> </div>
			</td>
            <td width="79" align="right" class="titulo_azul">Acidc :</td>
            <td width="189" class="titulo_azul"><input name="Acidc" type="text" id="Acidc" value="<?php echo $Acidc; ?>" onKeyDown="SoloNumeros(true,this)" size="15" maxlength="15">
            Kg.</td>
            <td width="157" class="titulo_azul">Tierras Diatomea :</td>
            <td width="213" class="titulo_azul"><input name="Petracel" type="text" value="<?php echo $Petracel; ?>" onKeyDown="SoloNumeros(true,this)" size="15" maxlength="15">
            Kg.</td>
          </tr>
          <tr> 
            <td class="titulo_azul">#Sacos Carbon:</td>
            <td><input name="SacosCarbon" type="text" id="SacosCarbon" onKeyDown="TeclaPulsada1Dese('Operador01')" value="<?php echo $SacosCarbon; ?>" size="10" maxlength="10"></td>
            <td align="right" class="titulo_azul">Operador :</td>
            <td colspan="3"><select name="Operador01" style="width:300px">
                <option value="S">Seleccionar</option>
                <?php
				LlenaCombosPersonalPmn(&$Operador01,'3');
				?>
              </select></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="86" class="titulo_azul">Lixiviaci&oacute;n :</td>
            <td width="154" valign="middle"><select name="Lixiviacion" style="width:100px">
                <option value="S">Seleccionar</option>
                <?php
				$Consulta = "SELECT * FROM pmn_web.lixiviacion_barro_anodico";
				$Consulta.= " WHERE stock_bad > 0";
				//$Consulta.= " AND ((YEAR(fecha) = '2004' AND num_lixiviacion >= '800') OR (YEAR(fecha) >= 2005))";
				$Consulta.= " ORDER BY num_lixiviacion desc";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Lixiviacion==$Row[num_lixiviacion])
					{
						echo "<option selected value = '".$Row[num_lixiviacion]."'>".$Row[num_lixiviacion]."</option>\n";
					}
					else
					{
						echo "<option  value = '".$Row[num_lixiviacion]."'>".$Row[num_lixiviacion]."</option>\n";
					}
				}
				?>
              </select>		    </td>
            <td width="95" valign="middle"><span class="titulo_azul">Observaci&oacute;n</span></td>
            <td width="431" valign="middle" class="titulo_azul"><textarea name="ObsDese" cols="80" rows="2"><?php echo $ObsDese;?></textarea></td>
            <td width="485" valign="middle"><label>
              <input type="button" name="btnGrabar" value="OK" onClick="ProcesoDese('GL');">
            </label></td>
          </tr>
        </table>
        <br>
        <table width="100%" height="26" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="57" class="titulo_azul">Producto: </td>
            <td width="237"><select name="Producto" style="width:220px" onChange="ProcesoDese('R');">
              <?php
				echo "<option value='S'>Seleccionar</option>\n";
				$Consulta = "select distinct t2.cod_producto, t2.descripcion ";
				$Consulta.= " from pmn_web.productos_externos t1 inner join proyecto_modernizacion.productos t2 on ";
				$Consulta.= " t1.cod_producto=t2.cod_producto and t1.tipo='S' and t1.cod_producto <> '44'" ;
				$Consulta.= " order by t2.descripcion";
				//echo "poly".$Consulta;
				$Respuesta = mysqli_query($link, $Consulta);
				
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Producto == $Row["cod_producto"])
						echo "<option selected value='".$Row["cod_producto"]."'>";														
					else	echo "<option value='".$Row["cod_producto"]."'>";
					//printf("%'03d",$Row["cod_producto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
			?>
            </select> 
			</td>
            <td width="91" class="titulo_azul">SubProducto:</td>
            <td width="234"><select name="Subproducto" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
				
				$Consulta = " select * from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.subproducto t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1='".$Producto."' and ";
				$Consulta.= " t1.valor_subclase2 = t2.cod_subproducto and t2.cod_producto='".$Producto."' and t1.nombre_subclase='2'";
				$Consulta.= " order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				
				while ($Row = mysqli_fetch_array($Respuesta))
				{
				
					if ($Producto == $Row["cod_subproducto"])
						echo "<option selected value='".$Row["cod_subproducto"]."'>";														
					else	echo "<option value='".$Row["cod_subproducto"]."'>";
					//printf("%'03d",$Row["cod_subproducto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
				echo "<option value='S'>-----------------------------</option>\n";
				
				$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$Producto."' order by descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Subproducto == $Row["cod_subproducto"])
								echo "<option selected value='".$Row["cod_subproducto"]."'>";														
							else	echo "<option value='".$Row["cod_subproducto"]."'>";
							//printf("%'03d",$Row["cod_subproducto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
				?>
			
				
	        </select>
			</td>
						<?php
							if ($Producto == '39')
							{
						?>	
							<td width="92"><input type="button" name="Obs" value="Graba Obs." onClick="ProcesoDese('OBS')"></td>
							<td>&nbsp;</td>
						<?php
							}
							else
							{	
						?>
    	        			<td width="92"><input type="button" name="btnBuscar" value="Buscar" onClick="ProcesoDese('DP')"></td>
						<?php
							}
						?>	
						
          </tr>
        </table>
        
      </td>
    </tr>
    <tr> 
      <td width="90%" align="center" valign="top">
		<?php	
		//echo $Producto; 		
		if ($Producto == '39')
		{
		?>
    		<table width="390" align="center" cellpadding="0" cellspacing="0">
			<tr align="center"> 			
			<td align="center"><strong>Observaci&oacute;n</strong></td>
			</tr>
			</table>
			<table width="390" border="0" align="center" cellpadding="0">
			<tr align="center">
			  <td><textarea  name="textotxt" cols="50" rows="3" class="Borde" id="textotxt"><?php echo $textotxt;?></textarea><br><input type="button" name="btnmodificar" value="Modifica Hornada" style="width:100" onClick="ProcesoDese('Mod');">
			  <input type="button" name="btneli" value="Eliminar" style="width:100" onClick="ProcesoDese('Eli');"></td>
			</tr>
			</table>
		</td></tr>
		<?php
		}
		else
		{
		?>
			 <table width="391" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
	  		<tr align="center" class="TituloCabeceraAzul"> 
			<td width="17" height="19" >&nbsp;</td>
			<td width="94"><strong>N&ordm; Lixiv./Id.</strong></td>
			<td width="130"><strong>Stock Actual</strong></td>
			<td width="123"><strong>B.A.D.</strong></td>
	  		</tr>
	<?php	
$Consulta = "select * from pmn_web.detalle_deselenizacion ";
$Consulta.= " where fecha = '".$AnoDese."-".$MesDese."-".$DiaDese."' ";
//$Consulta.= " and hornada = '".$Hornada."'";
$Consulta.= " and num_horno = '".$NumHorno."'";
$Consulta.=" and num_funda='".$NumFunda."'";
$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
$Consulta.=" and hornada_parcial='".$HornadaParcial."'		";
$Consulta.= " order by tipo, cod_producto, cod_subproducto, id_producto, referencia";

$Respuesta = mysqli_query($link, $Consulta);
$Row[bad] = 0;
echo "<input type='hidden' name='Tipo_H' value=''>\n";
echo "<input type='hidden' name='Producto_H' value=''>\n";
echo "<input type='hidden' name='SubProducto_H' value=''>\n";
echo "<input type='hidden' name='IdProducto_H' value=''>\n";
echo "<input type='hidden' name='CheckDetalle' value=''>\n";
echo "<input type='hidden' name='BAD' value=''>\n";
echo "<input type='hidden' name='AuxBad' value=''>\n";
echo "<input type='hidden' name='StockActual' value=''>\n";
while ($Row = mysqli_fetch_array($Respuesta))
{		
	echo "<tr align='center'>\n";
	echo "<td>\n";
	echo "<input type='hidden' name='Tipo_H' value='".$Row[tipo]."'>\n";
	echo "<input type='hidden' name='Producto_H' value='".$Row["cod_producto"]."'>\n";
	echo "<input type='hidden' name='SubProducto_H' value='".$Row["cod_subproducto"]."'>\n";
	echo "<input type='hidden' name='IdProducto_H' value='".$Row[id_producto]."'>\n";
	echo "<input type='checkbox' class='SinBorde' name='CheckDetalle' value='".$Row[referencia]."'>\n";
	echo "</td>\n";
	if ($Row[id_producto] == '')
		echo "<td> <input name='NumLixivID' type='text' readonly value='".$Row[referencia]."' size='15' maxlength='15'></td>\n";
	else	echo "<td> <input name='NumLixivID' type='text' readonly value='".$Row[id_producto]."-".$Row[referencia]."' size='15' maxlength='15'></td>\n";
	if ($Row[tipo] == "L")
	{
		//STOCK DE LA LIXIVIACION
		/*$Consulta = "select ifnull(sum(bad),0) as ocupado from pmn_web.detalle_deselenizacion ";
		$Consulta.= " where tipo = 'L' ";
		$Consulta.= " and referencia = '".$Row[referencia]."' ";
		$Respuesta2 = mysqli_query($link, $Consulta);
		$Row2 = mysqli_fetch_array($Respuesta2);
		$Ocupado = $Row2[ocupado];
		$Consulta = "select ifnull(bad,0) as inicial from pmn_web.lixiviacion_barro_anodico ";
		$Consulta.= " where num_lixiviacion = '".$Row[referencia]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		$Row2 = mysqli_fetch_array($Respuesta2);
		$Inicial = $Row2[inicial];
		$StockActual = $Inicial - $Ocupado;*/
		$Consulta="select * from pmn_web.lixiviacion_barro_anodico  ";
		$Consulta.=" where num_lixiviacion = '".$Row[referencia]."' and YEAR(fecha) = year(now()) ";
		//echo $Consulta."<br>";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Respuesta2))
		{
			$StockActual=$Row2[stock_bad];
		}
		else
		{
			$Consulta="select * from pmn_web.lixiviacion_barro_anodico  ";
			$Consulta.=" where num_lixiviacion = '".$Row[referencia]."' and YEAR(fecha) = year(subdate(now(), interval 1 year)) ";
			//echo $Consulta."<br>";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Row2 = mysqli_fetch_array($Respuesta2))
			{
				$StockActual=$Row2[stock_bad];
			}
		}
		echo "<td><input name='StockActual' type='text' readonly value='".number_format($StockActual,0,',','')."' size='12' maxlength='12' style='text-align=right'></td>\n";
		if ($StockActual <= 0)
			echo "<td><input name='BAD' readonly type='text' value='".number_format($Row[bad],0,',','')."' onKeyDown='SoloNumeros(true,this)' size='12' maxlength='12' style='text-align=right'></td>\n";
		else 	
			echo "<td><input name='BAD' type='text' value='".number_format($Row[bad],0,',','')."' onKeyDown='SoloNumeros(true,this)' size='12' maxlength='12' style='text-align=right'>";
		$TotalBAD1 = $TotalBAD1 + $Row[bad];

		//Campo oculto para verificar e exceso.
		echo "<input name='AuxBad' type='hidden' value='".$Row[bad]."'></td>\n";			
	}
	else
	{
		//STOCK DE LA PRODUCTOS EXTERNOS
		/*$Consulta = "select ifnull(sum(bad),0) as ocupado from pmn_web.detalle_deselenizacion ";
		$Consulta.= " where tipo = 'P' ";
		$Consulta.= " and cod_producto = '".$Row["cod_producto"]."' ";
		$Consulta.= " and cod_subproducto = '".$Row["cod_subproducto"]."' ";
		$Consulta.= " and id_producto = '".$Row[id_producto]."' ";
		$Consulta.= " and referencia = '".$Row[referencia]."' ";
		//echo $Consulta."<br>"; 
		$Respuesta2 = mysqli_query($link, $Consulta);
		$Row2 = mysqli_fetch_array($Respuesta2);
		$Ocupado = $Row2[ocupado];
		$Consulta = "select ifnull(peso_bruto - peso_resta,0) as inicial from pmn_web.detalle_productos_externos ";
		$Consulta.= " where cod_producto = '".$Row["cod_producto"]."'";
		$Consulta.= " and cod_subproducto = '".$Row["cod_subproducto"]."'";
		$Consulta.= " and id_producto = '".$Row[id_producto]."'";
		$Consulta.= " and referencia = '".$Row[referencia]."'";
		//echo $Consulta."<br>"; 
		$Respuesta2 = mysqli_query($link, $Consulta);
		$Row2 = mysqli_fetch_array($Respuesta2);
		$Inicial = $Row2[inicial];
		$StockActual = $Inicial - $Ocupado;*/
		$Consulta = "select * from pmn_web.detalle_productos_externos ";
		$Consulta.= " where cod_producto = '".$Row["cod_producto"]."'";
		$Consulta.= " and cod_subproducto = '".$Row["cod_subproducto"]."'";
		$Consulta.= " and id_producto = '".$Row[id_producto]."'";
		$Consulta.= " and referencia = '".$Row[referencia]."'";
		//echo $Consulta."<br>"; 
		$Respuesta2 = mysqli_query($link, $Consulta);
		$Row2 = mysqli_fetch_array($Respuesta2);
		
		echo "<td><input name='StockActual' type='text' readonly value='".number_format($Row2[stock_bad],2,',','')."' size='12' maxlength='12' style='text-align=right'></td>\n";
		echo "<td><input name='BAD' type='text' value='".number_format($Row[bad],2,',','')."' size='12'  onKeyDown='SoloNumeros(true,this)' maxlength='12' style='text-align=right'></td>\n";
		$TotalBAD2 = $TotalBAD2 + $Row[bad];			
	}
	/*if ($StockActual <= 0)
		echo "<td><input name='BAD' readonly type='text' value='".$Row[bad]."' size='12' maxlength='12' style='text-align=right'></td>\n";
	else 	echo "<td><input name='BAD' type='text' value='".$Row[bad]."' size='12' maxlength='12' style='text-align=right'></td>\n";*/
	echo "</tr>\n";
}
$TotalBADFinal = $TotalBAD1 + $TotalBAD2;
?>		  
	  <tr align="center"> 
		<td colspan="3" align="right" class="titulo_azul">Total :</td>
		<td><input name="TotalBAD" readonly type="text" value="<?php echo $TotalBADFinal; ?>" size="12" maxlength="15" style="text-align=right"></td>
	  </tr>
	</table>
		<hr>
			 <table width="430" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
		  <tr> 
			<td width="74" class="titulo_azul">KWH-Inicio :</td>
			<td width="103"><input name="KwhIni" type="text" id="KwhIni2" onKeyDown='SoloNumeros(true,this)' value="<?php echo $KwhIni; ?>" size="10" maxlength="10"></td>
			<td width="79" class="titulo_azul">KWH-Final :</td>
			<td width="129"><input name="KwhFin" type="text" id="KwhFin" onKeyDown='SoloNumeros(true,this)' value="<?php echo $KwhFin; ?>" size="10" maxlength="10"></td>
		  </tr>
	  </table>
	   	</td>
			<td width="10%" align="left" valign="top">
			<table width="76" border="0" cellspacing="0" cellpadding="3">
				  <tr> 
					<td><input type="checkbox" name="CheckTodos" value="checkbox" onClick="ProcesoDese('MT');"> 
					  <strong>Todos</strong></td>
				  </tr>
				  <tr> 
					<td><input name="btnGrabar2" type="button" id="btnGrabar2" style="width:70" value="Grabar" onClick="ProcesoDese('GD');"></td>
				  </tr>
				  <tr> 
				
					<td><input type="button" name="btnmodificar" value="Mod.Horn." style="width:70" onClick="ProcesoDese('Mod');"></td>
					
				  </tr>
					<tr> 
						<td><input type="button" name="btnEliminar" value="Eliminar" style="width:70" onClick="ProcesoDese('E');"></td>
					</tr>
					<tr> 
						<td><input name="btnCancelar" type="button" id="btnCancelar" style="width:70" onClick="ProcesoDese('CAN');" value="Cancelar"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
			<tr> 
			<td colspan="2" valign="top">
				<table width="670" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
				  <tr> 
					<td width="108" class="titulo_azul">Fecha Salida :</td>
					<td colspan="3"><select name="DiaSalida" style="width:50px">
					<?php				
						for ($i=1;$i<=31;$i++)
						{
							if (isset($DiaSalida))
							{
								if ($i == $DiaSalida)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
							else
							{
								if ($i == $DiaActual)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
						}
					?>
					  </select> <select name="MesSalida" style="width:100px">
						<?php				
						for ($i=1;$i<=12;$i++)
						{
							if (isset($MesSalida))
							{
								if ($i == $MesSalida)
									echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
								else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
							}
							else
							{
								if ($i == $MesActual)
									echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
								else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
							}
						}
					?>
					  </select> 
					  <select name="AnoSalida" style="width:60px">
					  <?php				
						for ($i=2002;$i<=date("Y");$i++)
						{
							if (isset($AnoSalida))
							{
								if ($i == $AnoSalida)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
							else
							{
								if ($i == $AnoActual)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
						}
					?>
					  </select></td>
				  </tr>
				  <tr> 
				  <?php
				  $Consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='6017' and cod_subclase='1'";
				  $Resp=mysqli_query($link, $Consulta);
				  if($Fila=mysqli_fetch_assoc($Resp))
				  {
				  	 if($Fila["valor_subclase1"]!='0')
				  	 	$Porcentaje=$Fila["valor_subclase1"];
					 else
						$Porcentaje='75';	
				  }	
				  else
				  	$Porcentaje='75';	
				  ?>
					<td class="titulo_azul">Prod. de Calcina :</td>
					<td width="235"><input type="hidden" name="PorcCalcina" value="<?php echo $Porcentaje;?>"><input name="ProdCalcina" type="text" id="ProdCalcina" value="<?php echo $ProdCalcina; ?>" size="15" maxlength="15">
					<a href="JavaScript:CalculaCalcina()"><img src="archivos/calcula.png" border="0" alt="Calcula Prod. Calcina con <?php echo $Porcentaje;?>% de Total del BAD."></a>&nbsp;Calcular al <?php echo $Porcentaje;?>% del BAD.</td>
					<td width="84" class="titulo_azul">Operador :</td>
					<td width="216"><select name="Operador02" style="width:200px">
					<option value="S">Seleccionar</option>
					<?php
						LlenaCombosPersonalPmn(&$Operador02,'3');
					?>
				    </select></td>
				  </tr>
				</table>
			</td>
			</tr>
			<?php
		  //aqui fin del else poly
		
		}
			?>
  </table>
  <?php //include("../principal/pie_pagina.php");?>  
</form>
</body>
</html>
