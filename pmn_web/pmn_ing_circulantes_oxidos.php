<?php 
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 3;
	if (!isset($CmbAno))
	{
		$CmbAno=date("Y");
		$CmbMes=date("n");
	}
	include("../principal/conectar_pmn_web.php");
	include('funciones/pmn_funciones.php'); 
	if(!isset($Mod))
		$Opc='Graba';
		
	$V=str_replace('.','',$V);	
	$V=str_replace(',','.',$V);	
	if($Graba=="S")
	{
		$AnoMesDia=explode('-',$FechaOxi);	
		$Consulta="select * from pmn_web.produccion_circulantes_oxidos where fecha='".$FechaOxi." ".date('G:h:s')."'";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		if(!$Fila=mysqli_fetch_array($Resp))
		{
			$Inserta="INSERT INTO pmn_web.produccion_circulantes_oxidos (fecha,cod_producto,cod_subproducto,valor,rut) values('".$FechaOxi." ".date('H:i:s')."','".$P."','".$SP."','".$V."','".$CookieRut."')";
			//echo $Inserta."<br>";
			mysqli_query($link, $Inserta);
			
			$AnoMes=explode('-',$FechaOxi);	
			StockPmn_valor($P,$SP,$AnoMes[0],$AnoMes[1],'I','P',$V,'0');				
			
			$Productos='S';
			$Subproductos='S';
			$PesoCirc='';
			$AnoOxi=date("Y");
			$MesOxi=date("n");
			$DiaOxi=date("d");
		}
		else
		{
			$PesoCirc='';
			echo "<script lenguaje='javascript'>";
				echo "alert('Existe Valor para Fecha a Ingresar')";
			echo "</script>";
		}	
	}
	if($Modifi=='S')
	{
		$Consulta="select * from pmn_web.produccion_circulantes_oxidos where fecha='".$FechaModi."'";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Resp);
		$PesoAnt=$Fila["valor"];

		$Actualiza="UPDATE pmn_web.produccion_circulantes_oxidos set valor='".$V."' where fecha='".$FechaModi."' and cod_producto='".$P."' and cod_subproducto='".$SP."'";
		//echo $Actualiza;
		mysqli_query($link, $Actualiza);
		
		$AnoMes=explode('-',$FechaModi);
		StockPmn_valor($P,$SP,$Ano,$Mes,'E','P',$PesoAnt,'0');				
		StockPmn_valor($P,$SP,$Ano,$Mes,'I','P',$V,'0');				
		
		$Productos='S';
		$Subproductos='S';
		$PesoCirc='';
		$AnoOxi=date("Y");
		$MesOxi=date("n");
		$DiaOxi=date("d");
	}
	if($Mod=='S')
	{
		$Consulta="select * from pmn_web.produccion_circulantes_oxidos where fecha='".$DatoModifi."'";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Resp);
		$Productos=$Fila["cod_producto"];
		$Subproductos=$Fila["cod_subproducto"];
		$PesoCirc=$Fila["valor"];
		
		$Opc='Modifi';
	}
	if($Elim=='S')
	{
		$Consulta="select * from pmn_web.produccion_circulantes_oxidos where fecha='".$FechaEli."'";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Resp);
		$PesoAnt=$Fila["valor"];

		$Eliminar="delete from pmn_web.produccion_circulantes_oxidos where fecha='".$FechaEli."'";
		mysqli_query($link, $Eliminar);
		
		$AnoMes=explode('-',$FechaEli);
		StockPmn_valor($P,$SP,$Ano,$Mes,'E','P',$PesoAnt,'0');				
		
		$Productos='S';
		$Subproductos='S';
		$PesoCirc='';
		$AnoOxi=date("Y");
		$MesOxi=date("n");
		$DiaOxi=date("d");
	}
	if($Canc=='S')
	{
		$Productos='S';
		$Subproductos='S';
		$PesoCirc='';
		$AnoOxi=date("Y");
		$MesOxi=date("n");
		$DiaOxi=date("d");
	}
/*	if ((isset($Producto)) && (isset($Identificacion)))
	{
		$Consulta = "select * from pmn_web.productos_externos where ";
		$Consulta.= " cod_producto = '".$Producto."'";
		if ((isset($Subproducto)) && ($Subproducto != "S"))
			$Consulta.= " and cod_subproducto = '".$Subproducto."' ";
		$Consulta.= " and id_producto = '".$Identificacion."' ";
		//echo "consulta".$Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$IdProducto=$Row[id_producto];
			$Producto = $Row["cod_producto"];
			$Subproducto = $Row["cod_subproducto"];
			$Identificacion = $Row[id_producto];
			$Referencia = $Row[referencia];
			$Observacion = $Row["observacion"];
			$TxtLoteVentana = $Row["lote_ventana"];
		}
	}*/
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
<!--
function ProcesoOxido(opt)
{
	var f = document.frmPrincipalRpt;
	var Tipo="";
	switch (opt)
	{
		case "AC":
			if (f.Producto.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Producto.focus();
				return;
			}
			if (f.Subproducto.value == "S")
			{
				alert("Debe seleccionar Subproducto");
				f.Subproducto.focus();
				return;
			}
			if (f.Identificacion.value == "S")
			{
				alert("Debe seleccionar Identificacin del Producto");
				f.Identificacion.focus();
				return;
			}
			if (f.Referencia.value == "")
			{
				alert("Debe ingresar Referencia del Producto");
				f.Referencia.focus();
				return;
			}
			/*if (f.TxtLoteVentana.value == "")
			{
				if (confirm("No ha ingresado el Lote asignado por el SIPA!!\nDesea Ingresarlo ahora?"))
				{
					f.TxtLoteVentana.focus();
					return;
				}
			}*/
			f.IdProducto.value = f.IdProducto.value.toUpperCase();
			f.Referencia.value = f.Referencia.value.toUpperCase();
			f.Observacion.value = f.Observacion.value.toUpperCase();
			if(f.radio[0].checked)
			{
				Tipo="S";
			
			}
			else
			{
				Tipo="H";
			
			}		
			
			f.action = "pmn_ing_prod_externos01.php?Proceso=" + opt+"&Tipo="+Tipo;
			//alert(f.action);
			f.submit();
			break;
		case "G1":
			if (f.Producto.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Producto.focus();
				return;
			}
			if (f.Subproducto.value == "S")
			{
				alert("Debe seleccionar Subproducto");
				f.Subproducto.focus();
				return;
			}
			if (f.IdProducto.value == "")
			{
				alert("Debe ingresar Identificacin del Producto");
				f.IdProducto.focus();
				return;
			}
			if (f.Referencia.value == "")
			{
				alert("Debe ingresar Referencia del Producto");
				f.Referencia.focus();
				return;
			}
			/*if (f.TxtLoteVentana.value == "")
			{
				alert("Debe ingresar Lote asignado por el SIPA");
				f.TxtLoteVentana.focus();
				return;
			}*/
			f.IdProducto.value = f.IdProducto.value.toUpperCase();
			f.Referencia.value = f.Referencia.value.toUpperCase();
			f.Observacion.value = f.Observacion.value.toUpperCase();
			if(f.radio[0].checked)
			{
				Tipo="S";
			
			}
			else
			{
				Tipo="H";
			
			}		
			
			f.action = "pmn_ing_prod_externos01.php?Proceso=" + opt+"&Tipo="+Tipo;
			//alert(f.action);
			f.submit();
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=100";
			f.submit();
			break;
		case "C":
			//alert(f.Producto.value);
			//alert(f.Subproducto.value);
			URL="pmn_ing_prod_externo02.php?Producto=" + f.Productos.value + "&Subproducto="+f.Subproductos.value;
			window.open(URL,"","top=50px,left=60px, width=750px, height=400px, menubar=no, resizable=yes, scrollbars=yes");
			break;
		case "Graba":
			if(f.Productos.value=='S')
			{
				alert("Debe seleccionar producto");
				f.Productos.focus();
				return;
			}
			if(f.Subproductos.value=='S')
			{
				alert("Debe seleccionar subproducto");
				f.Subproductos.focus();
				return;
			}
			if(f.PesoCirc.value=='')
			{
				alert("Debe ingresar peso");
				f.PesoCirc.focus();
				return;
			}
			f.action = "pmn_principal_reportes.php?Tab13=true&Graba=S&P="+f.Productos.value+"&SP="+f.Subproductos.value+"&V="+f.PesoCirc.value+"&FechaOxi="+f.AnoOxi.value+"-"+f.MesOxi.value+"-"+f.DiaOxi.value;
			f.submit();
		break;	
		case "Modifi":
			if(f.PesoCirc.value=='')
			{
				alert("Debe ingresar peso");
				f.PesoCirc.focus();
				return;
			}
			f.action = "pmn_principal_reportes.php?Tab13=true&Modifi=S&P="+f.Productos.value+"&SP="+f.Subproductos.value+"&V="+f.PesoCirc.value+"&FechaModi="+f.Fecha.value;
			f.submit();
		break;	
		case "Consulta":
			URL="pmn_ing_circulantes_oxidos2.php";
			window.open(URL,"","top=50px,left=60px, width=750px, height=400px, menubar=no, resizable=yes, scrollbars=yes");
		break;
		case "E":
			var mensaje=confirm("Est seguro de eliminar el registro.");
			if(mensaje==true)
			{
				f.action = "pmn_principal_reportes.php?Tab13=true&Elim=S&P="+f.Productos.value+"&SP="+f.Subproductos.value+"&V="+f.PesoCirc.value+"&FechaEli="+f.Fecha.value;
				f.submit();
			}			
		break;
		case "Cancela":
			f.action = "pmn_principal_reportes.php?Tab13=true&Canc=S";
			f.submit();
		break;
	}
}

function GrabaCabeceraOxido()
{
	var f = document.frmPrincipalRpt;
	if (f.Producto.value == "S")
	{
		alert("Debe seleccionar Producto");
		f.Producto.focus();
		return;
	}
	if (f.Subproducto.value == "S")
	{
		alert("Debe seleccionar Subproducto");
		f.Subproducto.focus();
		return;
	}
	if (f.Identificacion.value == "S")
	{
		alert("Debe seleccionar Identificacin del Producto");
		f.Identificacion.focus();
		return;
	}
	/*if (f.TxtLoteVentana.value == "S")
	{
		alert("Debe seleccionar Lote asignado por el SIPA");
		f.TxtLoteVentana.focus();
		return;
	}*/
	f.IdProducto.value = f.IdProducto.value.toUpperCase();
	f.Referencia.value = f.Referencia.value.toUpperCase();
	f.Observacion.value = f.Observacion.value.toUpperCase();
	if(f.radio[0].checked)
	{
		Tipo="S";
	}
	else
	{
		Tipo="H";
	}
	f.action = "pmn_ing_prod_externos01.php?Proceso=G3&Tipo="+Tipo;
	f.submit();
}

function MarcaTodosOxido()
{
	var f = document.frmPrincipalRpt;
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
}
function TeclaPulsada1Oxido(salto) 
{ 
	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}



function RecargaOxido(num)
{
	var f = document.frmPrincipalRpt;
	var Tipo="";

	f.Productos.value=f.Productos.value;
	f.Subproductos.value=f.Subproductos.value;
	f.action = "pmn_principal_reportes.php?Tipo="+Tipo+"&Tab13=true";
	f.submit();
}
-->
</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="3" topmargin="2">
<form name="frmPrincipalOxidos" action="" method="post">
<input type="hidden" name="Marcados" value="">
  <?php //include("../principal/encabezado.php");?>
  <table width="98%" border="0" cellpadding="5" cellspacing="0" class="TituloCabeceraOz">
    <tr> 
      <td colspan="2" valign="top" > 
	  <!--<table width="100%" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="67" class="titulo_azul">Usuario :</td>
            <td width="1040" class="pie_tabla_bold"> 
              <?php
				  /*$sql = "select * from proyecto_modernizacion.funcionarios where rut = '".$CookieRut."'";
				  $result = mysqli_query($link, $sql);
				  if ($row = mysqli_fetch_array($result))
				  {
					$Nombre = ucwords(strtolower($row["apellido_paterno"]." ".$row["apellido_materno"]." ".$row["nombres"]));
					echo $Nombre;
				  }
				  else
				  {
					echo "Error no se Encuentra el Funcionario";
				  }*/
	  		?>            </td>
          </tr>
        </table>-->
        <br> 
        <table width="100%" border="0" cellspacing="0" cellpadding="2" class="TablaInterior">
          <tr> 
            <td class="titulo_azul">Fecha</td>
            <td width="434">
			<?php
			if(!isset($Mod)) 
			{
				if ($BuscaCir == "S")
				{
					echo "<input type='hidden' name='DiaOxi' value='".$DiaOxi."'>\n";
					echo "<input type='hidden' name='MesOxi' value='".$MesOxi."'>\n";
					echo "<input type='hidden' name='AnoOxi' value='".$AnoOxi."'>\n";
					printf("%'02d",$DiaOxi);
					echo "-";
					printf("%'02d",$MesOxi);
					echo "-";
					printf("%'04d",$AnoOxi);
				}
				else
				{
					echo "<select name='DiaOxi' style='width:50px' >\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaOxi))
						{
							if ($i == $DiaOxi)
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
				  echo "</select> <select name='MesOxi' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesOxi))
						{
							if ($i == $MesOxi)
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
				  echo "</select> <select name='AnoOxi' style='width:60px'>\n";
					for ($i=2008;$i<=date("Y");$i++)
					{
						if (isset($AnoOxi))
						{
							if ($i == $AnoOxi)
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
			}
			else
			{
				echo $DatoModifi;
				echo "<input type='hidden' name='Fecha' value='".$DatoModifi."'>";
			}	
			?></td>
            <td width="668"><input name="btnAgregar2" type="button" value="Consultar" onClick="ProcesoOxido('Consulta');"></td>
            <!--<td>
			<input name="BtnConsultar" type="button" id="BtnConsultar3" onClick="Proceso('C');" value="Consultar"></td>-->
          </tr>
          <tr> 
            <td width="172" class="titulo_azul">Producto:</td>
            <td colspan="3">
			<?php
			if(!isset($Mod))
			{
			?>
			<select name="Productos" style="width:220px" onChange="RecargaOxido('R');">
              <?php
				echo "<option value='S'>Seleccionar</option>\n";
				$Consulta = "select distinct t2.cod_producto, t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.productos t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1 = t2.cod_producto and t1.nombre_subclase='CirOxi' ";
				$Consulta.= " order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Productos == $Row["cod_producto"])
						echo "<option selected value='".$Row["cod_producto"]."'>";														
					else	echo "<option value='".$Row["cod_producto"]."'>";
					//printf("%'03d",$Row["cod_producto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
				//echo "<option value='S'>-----------------------------</option>\n";
/*				$Consulta = "select * from proyecto_modernizacion.productos order by descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Producto == $Row["cod_producto"])
								echo "<option selected value='".$Row["cod_producto"]."'>";														
							else	echo "<option value='".$Row["cod_producto"]."'>";
							//printf("%'03d",$Row["cod_producto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}*/
			?>
            </select>
			<?php
			}
			else
			{
				$Consulta = "select distinct t2.cod_producto, t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.productos t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1 = t2.cod_producto and t1.nombre_subclase='CirOxi' ";
				$Consulta.= " where cod_producto='".$Productos."' order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				$Row = mysqli_fetch_array($Respuesta);
				echo $Row["descripcion"];
				echo "<input type='hidden' name='Productos' value='".$Productos."'";														
					
			}
			?>
			</td>
          </tr>
          <tr>
            <td class="titulo_azul">SubProducto :</td>
            <td colspan="3">
			<?php
			if(!isset($Mod))
			{
			?>
			<select name="Subproductos" id="Subproductos" style="width:220px">
              <option value="S">Seleccionar</option>
              <?php
				$Consulta = "select t2.cod_subproducto, t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.subproducto t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1='".$Productos."' and ";
				$Consulta.= " t1.valor_subclase2 = t2.cod_subproducto and t2.cod_producto='".$Productos."' and t1.nombre_subclase='CirOxi'";
				$Consulta.= " order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Subproductos == $Row["cod_subproducto"])
						echo "<option selected value='".$Row["cod_subproducto"]."'>";														
					else	echo "<option value='".$Row["cod_subproducto"]."'>";
					//printf("%'03d",$Row["cod_subproducto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
/*				echo "<option value='S'>-----------------------------</option>\n";
				$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$Productos."' order by descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Subproductos == $Row["cod_subproducto"])
								echo "<option selected value='".$Row["cod_subproducto"]."'>";														
							else	echo "<option value='".$Row["cod_subproducto"]."'>";
							//printf("%'03d",$Row["cod_subproducto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}*/
			?>
            </select>
			<?php 
			}
			else
			{
				$Consulta = "select t2.cod_subproducto, t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.subproducto t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1='".$Productos."' and ";
				$Consulta.= " t1.valor_subclase2 = t2.cod_subproducto and t2.cod_producto='".$Productos."' and t2.cod_subproducto='".$Subproductos."' and t1.nombre_subclase='CirOxi'";
				$Consulta.= " order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				$Row = mysqli_fetch_array($Respuesta);
				echo $Row["descripcion"];
				echo "<input type='hidden' name='Subproductos' value='".$Subproductos."'";														
			}
			?></td>
          </tr>
          <!-- <tr>
            <td><strong><em>LOTE SIPA: </em></strong></td>
            <td colspan="6" valign="middle"><input name="TxtLoteVentana" type="text" class="InputDer" id="TxtLoteVentana" value="<?php echo $TxtLoteVentana; ?>" size="20" maxlength="6" onKeyDown="TeclaPulsada2('S',false,this.form,'');">            </td>
          </tr>-->
        </table>
        <br> 
        <table width="100%" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
		  <?php
		  //echo $Opc;
		  ?>
            <td width="137" height="26" class="TituloCabeceraAzul">Peso:</td>
            <td width="316" class="titulo_azul"><input name="PesoCirc" type="text" value="<?php echo number_format($PesoCirc,2,',','.');?>" onKeyDown="SoloNumeros(true,this)"></td>
            <td width="94">&nbsp;</td>
            <td width="271"><input name="btnAgregar" type="button" value="Grabar" onClick="ProcesoOxido('<?php echo $Opc;?>');">&nbsp;<input name="btnAgregar3" type="button" value="Eliminar" onClick="ProcesoOxido('E');">&nbsp;<input name="btnAgregar32" type="button" value="Cancelar" onClick="ProcesoOxido('Cancela');"></td>
            <td width="45">&nbsp;</td>
            <td width="387"><input type="hidden" name="DetModificado" value =''></td>
          </tr>
      </table></td>
    </tr>
    <tr> 
      <td width="609" valign="top">&nbsp;</td>
      <td width="139" valign="top">&nbsp;</td>
    </tr>
  </table>
  <?php //include("../principal/pie_pagina.php");?>  
</form>
</body>
</html>
