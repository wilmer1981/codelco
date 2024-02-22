<?php 
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 3;
	if (!isset($CmbAno))
	{
		$CmbAno=date("Y");
		$CmbMes=date("n");
	}
	include("../principal/conectar_pmn_web.php");
	if ((isset($ProductoExt)) && (isset($Identificacion)))
	{
		$Consulta = "select * from pmn_web.productos_externos where ";
		$Consulta.= " cod_producto = '".$ProductoExt."'";
		if ((isset($SubproductoExt)) && ($SubproductoExt != "S"))
			$Consulta.= " and cod_subproducto = '".$SubproductoExt."' ";
		$Consulta.= " and id_producto = '".$Identificacion."' ";
		//echo "consulta".$Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$IdProducto=$Row[id_producto];
			$ProductoExt = $Row["cod_producto"];
			$SubproductoExt = $Row["cod_subproducto"];
			$Identificacion = $Row[id_producto];
			$Referencia = $Row[referencia];
			$Observacion = $Row["observacion"];
			$TxtLoteVentana = $Row["lote_ventana"];
			$Referencia=$Row[referencia];
		}
	}
	if($limpia=='S')
	{
		$ProductoExt='';
		$SubproductoExt='';
		$Identificacion	='';	
		$PesoBruto='';
		$PesoResta='';
		$IdProducto='';
		$Referencia='';
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
<!--
function ProcesoExtPrin(opt)
{
	var f = document.frmPrincipalRpt;
	var Tipo="";
	switch (opt)
	{
		case "AC":
			if (f.ProductoExt.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.ProductoExt.focus();
				return;
			}
			if (f.SubproductoExt.value == "S")
			{
				alert("Debe seleccionar Subproducto");
				f.SubproductoExt.focus();
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
			if (f.ProductoExt.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.ProductoExt.focus();
				return;
			}
			if (f.SubproductoExt.value == "S")
			{
				alert("Debe seleccionar Subproducto");
				f.SubproductoExt.focus();
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
			//alert(f.ProductoExt.value);
			//alert(f.SubproductoExt.value);
			URL="pmn_ing_prod_externo02.php?Producto=" + f.ProductoExt.value + "&Subproducto="+f.SubproductoExt.value;
			window.open(URL,"","top=50px,left=60px, width=750px, height=400px, menubar=no, resizable=yes, scrollbars=yes");
			break;
		case "Cancela":
			f.action = "pmn_principal_reportes.php?&Tab1=true&TabE=true&limpia=S";
			f.submit();
		break;	
	}
}

function GrabaCabeceraExtPrin()
{
	var f = document.frmPrincipalRpt;
	if (f.ProductoExt.value == "S")
	{
		alert("Debe seleccionar Producto");
		f.Producto.focus();
		return;
	}
	if (f.SubproductoExt.value == "S")
	{
		alert("Debe seleccionar Subproducto");
		f.SubproductoExt.focus();
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

function AgregarDetalleExtPrin()
{
	var f = document.frmPrincipalRpt;
	if (f.ProductoExt.value == "S")
	{
		alert("Debe seleccionar Producto");
		f.ProductoExt.focus();
		return;
	}
	if (f.SubproductoExt.value == "S")
	{
		alert("Debe seleccionar Subproducto");
		f.SubproductoExt.focus();
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
	if (f.PesoBruto.value == "")
	{
		alert("Debe ingresar peso Bruto");
		f.PesoBruto.focus();
		return;
	}
	if (f.PesoResta.value == "")
	{
		f.PesoResta.value = "0";
		return;
	}
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
	f.action = "pmn_ing_prod_externos01.php?Proceso=G2&Tipo="+Tipo;
	f.submit();
}

function ModificaDetalleExtPrin()
{
	var f = document.frmPrincipalRpt;
	var Valores = 0;
	var ValorMarcado = 0;
	try
	{
		for (i=1;i < f.CheckDetalle.length;i++)
		{
			if (f.CheckDetalle[i].checked == true)
			{
				ValorMarcado = i;
				Valores++;
				f.DetModificado.value = f.CheckDetalle[i].value;
			}
		}
	}
	catch (e)
	{
		//alert("No hay nada para seleccionar");
	}
//	alert(Valores);
	if (Valores != 0)
	{
		if (Valores > 1)
		{
			alert("Solo puede seleccionar 1 registro para Modificar");
		}
		else
		{
			f.DetModificado.value = f.CheckDetalle[ValorMarcado].value;
			f.PesoBruto.value = f.Bruto[ValorMarcado].value;
			f.PesoResta.value = f.Resta[ValorMarcado].value;
		}
	}
	else
	{
		alert("No hay nada seleccionado");
	}
}
function EliminaDetalleExtPrin()
{
	var f = document.frmPrincipalRpt;
	var Tipo="";
	var Valores = "";
	try
	{
		for (i=1;i < f.CheckDetalle.length;i++)
		{
			if (f.CheckDetalle[i].checked == true)
			{
				Valores = Valores + f.CheckDetalle[i].value + "-";
			}
		}
	}
	catch (e)
	{
		alert("No hay nada para seleccionar");
	}
	if (Valores != "")
	{
		var mensaje = confirm("Esta seguro que desea eliminar este(os) registro(s)?");
		if (mensaje == true)
		{
			f.Marcados.value = Valores;
			if(f.radio[0].checked)
			{
				Tipo="S";
			
			}
			else
			{
				Tipo="H";
			
			}
			f.action = "pmn_ing_prod_externos01.php?Proceso=E&Tipo="+Tipo;
			f.submit();
		}
		else
		{
			return;
		}
	}
	else
	{
		alert("No hay nada seleccionado");
	}
}

function MarcaTodosExtPrin()
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
function TeclaPulsada1ExtPrin(salto) 
{ 
	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}



function RecargaExtProd(num)
{
	var f = document.frmPrincipalRpt;
	var Tipo="";
	switch (num)
	{		
		case 1:
			
			f.IdProducto.value="";
			//f.TxtLoteVentana.value="";
			f.Referencia.value="";
			f.Observacion.value="";
			break;
	}
	if(f.radio[0].checked)
	{
		Tipo="S";
	
	}
	else
	{
		Tipo="H";
	
	}
	f.action = "pmn_principal_reportes.php?Tipo="+Tipo+"&Tab1=true&TabE=true";
	f.submit();
}
-->
</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="3" topmargin="2">
<form name="frmPrincipalRpt" action="" method="post">
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
            <td class="titulo_azul">Producto:</td>
            <td colspan="4"><select name='ProductoExt' onChange='RecargaExtProd(1);' style='width:220px'>
                <?php 
					echo "<option value='S'>Seleccionar</option>\n";
					$Consulta = "select t2.cod_producto, t2.descripcion ";
					$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.productos t2 on ";
					$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1 = t2.cod_producto and t1.nombre_subclase='1' ";
					$Consulta.= " group by t2.cod_producto order by t2.cod_producto";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($ProductoExt == $Row["cod_producto"])
							echo "<option selected value='".$Row["cod_producto"]."'>";														
						else	echo "<option value='".$Row["cod_producto"]."'>";
						printf("%'03d",$Row["cod_producto"]);
						echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
					}
/*					echo "<option value='S'>-----------------------------</option>\n";
					$Consulta = "select * from proyecto_modernizacion.productos order by cod_producto";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($Producto == $Row["cod_producto"])
							echo "<option selected value='".$Row["cod_producto"]."'>";														
						else	echo "<option value='".$Row["cod_producto"]."'>";
						printf("%'03d",$Row["cod_producto"]);
						echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
					}*/
				?>
              </select>
			  </td>
            <!--<td>
			<input name="BtnConsultar" type="button" id="BtnConsultar3" onClick="Proceso('C');" value="Consultar"></td>-->
          </tr>
          <tr> 
            <td width="98" class="titulo_azul">SubProducto :</td>
            <td colspan="5"><select name="SubproductoExt" onChange="RecargaExtProd(1);" style="width:220px">
              <option value="S">Seleccionar</option>
              <?php
					$Consulta = "select t2.cod_subproducto, t2.descripcion,t2.mostrar_pmn ";
					$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.subproducto t2 on ";
					$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1='".$ProductoExt."' and ";
					$Consulta.= " t1.valor_subclase2 = t2.cod_subproducto and t2.cod_producto='".$ProductoExt."' and t1.nombre_subclase='1'";
					$Consulta.= " group by t2.cod_subproducto order by t1.cod_subclase";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($SubproductoExt == $Row["cod_subproducto"])
							echo "<option selected value='".$Row["cod_subproducto"]."'>";
							
						else	echo "<option value='".$Row["cod_subproducto"]."'>";
						printf("%'03d",$Row["cod_subproducto"]);
						echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
					}
/*					echo "<option value='S'>-----------------------------</option>\n";
					$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$Producto."'   order by cod_subproducto";
					$Respuesta = mysqli_query($link, $Consulta);
					echo "pro".$Producto."-".$Subproducto;
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($Subproducto == $Row["cod_subproducto"])
							echo "<option selected value='".$Row["cod_subproducto"]."'>\n";
						else
							if ((($Row["cod_producto"]!='44') || ($Row["cod_subproducto"]!='2')) &&(($Row["cod_producto"]!='34') || ($Row["cod_subproducto"]!='3')))
							echo "<option value='".$Row["cod_subproducto"]."'>\n";
						printf("%'03d",$Row["cod_subproducto"]);
						echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
					}*/
					
				?>
            </select>
              <?php 
			  if ($Tipo=="S")
			   { 
			   		echo "<input type='radio' name='radio' class='SinBorde' value='Selenio' checked>";
			   }
			   else
		       {
					echo "<input type='radio' name='radio' class='SinBorde' value='Selenio'>";
			   }
			 
			 ?>            <strong  class="titulo_azul">Pta Selenio</strong>
			  <?php
			  if ($Tipo=="H")
			  { 
				echo "<input type='radio' name='radio' class='SinBorde' value='horno' checked>";
              }
			  else
			  {
			  	echo "<input type='radio' name='radio' class='SinBorde' value='horno' >";
			  }
			  ?>
		      <strong class="titulo_azul"> Horno Trof</strong></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><strong class="formulario"><em>LOTE SIPA: </em></strong></td>
            <td width="143"><input name="IdProducto" onKeyDown="TeclaPulsada2('S',false,this.form,'');" type="text" class="InputDer" id="IdProducto3" value="<?php echo $IdProducto; ?>" size="15" maxlength="8"></td>
            <td width="113" class="formulario">Ident/Referencia :</td>
            <td width="377" colspan="3"><input name="Referencia" type="text" class="InputDer"  value="<?php echo $Referencia ?>" size="35" maxlength="50">              
            <input name="btnOK01" type="button" value="Grabar" onClick="ProcesoExtPrin('G1')">            </td></tr>
          <!-- <tr>
            <td><strong><em>LOTE SIPA: </em></strong></td>
            <td colspan="6" valign="middle"><input name="TxtLoteVentana" type="text" class="InputDer" id="TxtLoteVentana" value="<?php echo $TxtLoteVentana; ?>" size="20" maxlength="6" onKeyDown="TeclaPulsada2('S',false,this.form,'');">            </td>
          </tr>-->
          <tr>
            <td class="titulo_azul">Lotes Ingresasdos:</td>
            <td colspan="5" valign="middle"><select name="CmbAno" id="CmbAno"  onChange='RecargaExtProd(1);'>
			<?php
				for ($i=date("Y")-2;$i<=date("Y")+1;$i++)
				{
					if ($i==$CmbAno)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			?>
            </select>
              <select name="CmbMes" id="CmbMes"  onChange='RecargaExtProd(1);'>
			  <?php
			  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

			  for ($i=1;$i<=12;$i++)
				{
					if ($i==$CmbMes)
						echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
					else
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
				?>
				
              </select>
              <select name="Identificacion" style="width:350" onChange="RecargaExtProd(2);">
                <?php 
				//echo $CodLote;
			  		$CodLote=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT);			  	
				//echo $CodLote;
					$Consulta = "select * from pmn_web.productos_externos ";
					$Consulta.= " where cod_producto = '".$ProductoExt."' "; 
					$Consulta.= " and substring(id_producto,1,4)='".$CodLote."' ";
					if ((isset($SubproductoExt)) && ($SubproductoExt != "S"))
					{
						$Consulta.= " and cod_subproducto = '".$SubproductoExt."'"; 
					}    
					$Consulta.= " order by id_producto";				
					//echo "COns".$Consulta;
					$Respuesta = mysqli_query($link, $Consulta);
					echo "<option value='S'>Seleccionar</option>";
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($Row[id_producto] == $Identificacion)
							echo "<option selected value='".$Row[id_producto]."'>".$Row[id_producto]." - ".$Row[referencia]."</option>";
						else	echo "<option value='".$Row[id_producto]."'>".$Row[id_producto]." - ".$Row[referencia]."</option>";
					}
			  ?>
              </select><?php //echo $Consulta; ?></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Observaci&oacute;n</td>
            <td colspan="5" valign="middle"> <textarea name="Observacion" cols="74" rows="3" onKeyDown="TeclaPulsada1ExtPrin('PesoBruto')" wrap="VIRTUAL"><?php echo $Observacion; ?></textarea> 
            </td>
          </tr>
          <tr align="center">
            <td colspan="6">
<?php
	if ($Identificacion!="S" && $Identificacion!="S" && isset($Identificacion))
		echo "<input name=\"BtnCabecera\" type=\"button\" value=\"Guarda Cabecera\" onClick=\"ProcesoExtPrin('AC')\">\n";
?>	
            <input name="btnGrabaCabecera" type="button" value="Actualizar Pagina" onClick="GrabaCabeceraExtPrin();"></td>
          </tr>
        </table>
        <br> 
        <table width="100%" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="103" height="26" class="TituloCabeceraAzul">Nuevo / Modificar</td>
            <td width="81" class="titulo_azul">Peso Bruto:</td>
            <td width="118"> <input name="PesoBruto" type="text" class="InputDer" id="PesoBruto" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($PesoBruto,4,',',''); ?>" size="15" maxlength="10"></td>
            <td width="87" class="TituloCabeceraAzul">Peso Resta:</td>
            <td width="106"><input name="PesoResta" type="text" class="InputDer" id="PesoResta" onKeyDown="SoloNumeros(true,this)" value="<?php 
			if ((!isset($PesoResta) || ($PesoResta == "")) && (($Producto == '24') || ($Producto == '25')))
			{
				echo "9.3"; 
			}
			else
			{
				echo number_format($PesoResta,4,',',''); 
			}			
			?>" size="15" maxlength="10"> 
            </td>
            <td width="66"><input name="btnAgregar" type="button" value="Grabar" onClick="AgregarDetalleExtPrin();"></td>
            <td width="144"><input type="hidden" name="DetModificado" value =''>&nbsp; </td>
          </tr>
      </table></td>
    </tr>
    <tr> 
      <td width="609" valign="top"><table width="500" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="TituloCabeceraAzul"> 
            <td height="19">&nbsp;</td>
            <td width="100"><strong>Referencia</strong></td>
            <td width="125"><strong>Peso Bruto</strong></td>
            <td width="146">Peso Resta</td>
            <td width="146"><strong>Peso Final</strong></td>
          </tr>
<?php		  
	if ((isset($ProductoExt)) && (isset($SubproductoExt)) && (isset($Identificacion)))
	{
		$Consulta = "select * from pmn_web.detalle_productos_externos t1 ";
		$Consulta.=" inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.=" on t1.cod_producto =t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto	";
		$Consulta.= " where t1.cod_producto = '".$ProductoExt."'";
		$Consulta.= " and t1.cod_subproducto = '".$SubproductoExt."'";
		$Consulta.= " and t1.id_producto = '".$Identificacion."'";
		$Consulta.= " order by t1.cod_producto, t1.cod_subproducto, t1.id_producto, t1.referencia";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		echo "<input type='hidden' name='CheckDetalle'>";
		echo "<input type='hidden' name='Bruto'>";
		echo "<input type='hidden' name='Resta'>";
		$TotalBruto = 0;
		$TotalResta = 0;
		$TotalFinal = 0;
		while ($Row = mysqli_fetch_array($Respuesta))
		{		
			echo "<tr align='center'>\n";
			echo "<td><input type='checkbox' name='CheckDetalle' value='".$Row[referencia]."'></td>\n";
			echo "<td align='center'> <input class='InputCen' name='RefDetalle' readonly type='text' value='".$Row[id_producto]."-".$Row[referencia]."' size=15 maxlength=15></td>\n";
			echo "<td align='right'><input class='InputDer' name='Bruto' readonly type='text' value='".$Row[peso_bruto]."' size=12 maxlength=12 style='text-align: right;'></td>\n";
			echo "<td align='right'><input class='InputDer' name='Resta' readonly type='text' value='".$Row[peso_resta]."' size=12 maxlength=12 style='text-align: right;'></td>\n";
			echo "<input type='hidden' name='Mostrar' value='".$Row[mostrar_pmn]."'>";
			$P_Final = $Row[peso_bruto] - $Row[peso_resta];
			echo "<td align='right'> <input class='InputDer' name='PesoFinal' readonly type='text' value='".$P_Final."' size=12 maxlength=12 style='text-align: right;'></td>\n";
			$TotalBruto = $TotalBruto + $Row[peso_bruto];
			$TotalResta = $TotalResta + $Row[peso_resta];
			$TotalFinal = $TotalFinal + $P_Final;
			echo "</tr>\n";
		}
	}
?>		  
          <tr align="center"> 
            <td colspan="2" class="titulo_azul">TOTAL</td>
            <td align="right"> <input name="TotalBruto" type="text" class="InputDer" style="text-align: right; background:#F7F2EB;" value="<?php echo $TotalBruto; ?>" size="12" maxlength="12" readonly></td>
            <td align="right">
<input name="TotalResta" type="text" class="InputDer" style="text-align: right;background:#F7F2EB;" value="<?php echo $TotalResta; ?>" size="12" maxlength="12" readonly></td>
            <td align="right">
<input name="TotalFinal" type="text" class="InputDer" style="text-align: right;background:#F7F2EB;" value="<?php echo $TotalFinal; ?>" size="12" maxlength="12" readonly></td>
          </tr>
        </table>
        
      </td>
      <td width="139" valign="top"><table width="84" border="0" cellspacing="0" cellpadding="3">
          <tr> 
            <td><strong class="titulo_azul"> 
              <input type="checkbox" name="CheckTodos" class="SinBorde" value="checkbox" onClick="MarcaTodosExtPrin();">
            Todos</strong></td>
          </tr>
          <tr> 
            <td width="78"><input type="button" name="btnModificar" value="Modificar" style="width:70" onClick="ModificaDetalleExtPrin();"></td>
          </tr>
          <tr> 
            <td><input type="button" name="btnEliminar" value="Eliminar" style="width:70" onClick="EliminaDetalleExtPrin();"></td>
          </tr>
          <tr> 
            <td><input type="button" name="btnEliminar2" value="Cancelar" style="width:70" onClick="ProcesoExtPrin('Cancela');"></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <?php //include("../principal/pie_pagina.php");?>  
</form>
</body>
</html>
