<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 136;
	
	include("../principal/conectar_pmn_web.php");				
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1PSub()
{
	var f = document.frmPrincipalRpt;
	
	f.action = "pmn_principal_reportes.php?recargapag1=S&Tab12=true";
	f.submit();
}
/******************/
function TeclaPulsada1PSub(salto) 
{ 
	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		if (f.txtnumero.value =="")
		{
			alert ("Debe ingresar Nmero");
			f.numero.focus();
		}	
		eval("f." + salto + ".focus();");
	}
}

function TeclaPulsada2PSub(salto) 
{ 

	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
	
		if (f.txtid.value =="")
		{
			alert ("Debe ingresar ID Analisis");
			f.txtid.focus();	
		}
		else
		{	
		
			f.action = "pmn_principal_reportes.php?recargapag2=P&recargapag1=S&Tab12=true";
			f.submit();
			
			eval("f." + salto + ".focus();");
		}
	}
}

function ValidaCamposPSub()
{
	var f = document.frmPrincipalRpt;
	
	if (f.cmbproducto.value == -1)
	{
		alert("Debe Seleccionar El Producto");
		return false;
	}	
	
	if (f.cmbsubproducto.value == -1)
	{
		alert("Debe Seleccionar El SubProducto");
		return false;
	}
	
	if (f.cmbidentificacion.value == -1)
	{
		alert("Debe Seleccionar Identificacion");
		return false;
	}	
	
	if (f.txtnumero.value == "")
	{
		alert("Debe Ingresar N");
		return false;
	}	
	
	if (isNaN(parseInt(f.txtpeso.value)))
	{
		alert("El Peso No Es Valido");
		return false;
	}
		if (isNaN(parseInt(f.txtpeso2.value)))
	{
		alert("El Peso de Tara No Es Valido");
		return false;
	}

	if (f.cmbproducto.value == '28')
	{
		if (f.txtid.value == "")
		{
			alert("Debe Ingresar Id. Analisis");
			return false;
		}		
	}
	
		if (f.cmbproducto.value == '24')
	{
		if (f.txtid.value == "")
		{
			alert("Debe Ingresar Id. Analisis");
			return false;
		}		
	}

	
	return true;
}
/******************/
function GrabarPSub()
{	
	var f = document.frmPrincipalRpt;
	
	if (ValidaCamposPSub())
	{
		f.action = "pmn_ing_produccion_subproductos01.php?proceso=G";
		f.submit();
	}
}
/***************/
function ModificarPSub()
{
	var f = document.frmPrincipalRpt;
	
	linea = "cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	f.action = "pmn_ing_produccion_subproductos01.php?proceso=M&" + linea;
	f.submit();
}

function EliminarPSub()
{
	var f = document.frmPrincipalRpt;

	if (f.cmbproducto.value=="28" && f.eli.value=="E")
	{
		j=0;
		todos=0;
		Valor="";
		pos =21;
		largo = f.elements.length;
		
		for (j=21;j<largo;j=j+3)
		{
			if ((f.elements[j].type=='checkbox') && (f.elements[j].checked==true))
			{
				Valor=Valor + f.elements[j].value + "~" + f.elements[j+1].value + "~" + f.elements[j+2].value + "~~";
			}
			else
			{
				if ((f.elements[j].type=='checkbox') && (f.elements[j].checked==false))
				{
					todos=todos+1;
				}		
			}
		}
		if (Valor=="")
		{
			alert("No ha seleccionado elementos para Eliminar");
			return;
		}
		else
		{
			if(confirm('Esta Seguro de Eliminar Los Datos?'))
			{
				linea = f.cmbproducto.value + "~" + f.cmbsubproducto.value + "~" + f.txtid.value + "~" + f.cmbidentificacion.value  + "~" + f.cmbdisponibilidad.value;
				f.action = "pmn_ing_produccion_subproductos01.php?proceso=E&" + "&linea=" + linea + "&Valor=" + Valor + "&todos="+todos;
				f.submit();
			}
		}
	}
	else
	{	
		linea = "cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;	
		f.action = "pmn_ing_produccion_subproductos01.php?proceso=E&" + linea;
		f.submit();
	}
}
/******************/
function ConsultarPSub()
{
	var f = document.frmPrincipalRpt;
	
	if (f.cmbproducto.value == -1)
	{
		alert("Debe Seleccionar El Producto");
		return false;
	}	
	
	if (f.cmbsubproducto.value == -1)
	{
		alert("Debe Seleccionar El SubProducto");
		return false;
	}	

	var linea = 'cmbproducto=' + f.cmbproducto.value + '&cmbsubproducto=' + f.cmbsubproducto.value;	
	window.open("pmn_ing_produccion_subproductos_popup.php?"+linea,"","top=100,left=180,width=750,height=370,scrollbars=no,resizable=no,status=yes");
}
/******************/
function CancelarPSub()
{
	document.location = 'pmn_principal_reportes.php?Tab12=true';	
}
/******************/
function SalirPSub()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=135";
}
/******************/
function HabilitarPSub()
{
	var f = document.frmPrincipalRpt;
	//alert(f.cmbdisponibilidad.value)
	if (f.cmbdisponibilidad.value == "S")
	{
		f.ano2.disabled = true;
		f.mes2.disabled = true;
		f.dia2.disabled = true;
	}
	else
	{
		f.ano2.disabled = false;
		f.mes2.disabled = false;
		f.dia2.disabled = false;	
	}
}
function ActivarPSub(f)
{
	if (f.todos.checked == true)
		valor = true
	else valor = false;		

	pos=20;//Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = f.elements.length;
	for (i=20; i<largo; i=i+3)
	{	
	
		if (f.elements[i].type != 'checkbox')
			return;
		else 
			f.elements[i].checked = valor;
	}	
}

</script>
</head>
<body onLoad="HabilitarPSub()">

<!--<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" onLoad="Habilitar()">-->
<form name="frmPrincipalPSub" method="post" action="">
<?php //include("../principal/encabezado.php")?>
<?php
	//Campos Ocultos.
	if ($mostrarPSub2 == "S")
	{	
		$txtnumero=$txtnumero2;
		$fecha_prod=$fecha_prodMod;
		$fecha_ven=$fecha_venMod;
		$cmbproducto=$cmbproducto2;
		$cmbsubproducto=$cmbsubproducto2;
		$cmbidentificacion=$cmbidentificacion2;
		$txtpeso=$txtpesoNorm;
		$txtpesoTara=$txtpesoTara;
		$txtid=$txtidAna;
		$cmbdisponibilidad=$cmbdisponibilidadMod;
		echo '<input name="fecha_aux_prod" type="hidden" value="'.$fecha_prod.'">';
		echo '<input name="fecha_aux_ven" type="hidden" value="'.$fecha_ven.'">';
		echo '<input name="producto_aux" type="hidden" value="'.$cmbproducto.'">';
		echo '<input name="subproducto_aux" type="hidden" value="'.$cmbsubproducto.'">';
		echo '<input name="id_aux" type="hidden" value="'.$cmbidentificacion.'">';
		echo '<input name="num_aux" type="hidden" value="'.$txtnumero.'">';
		echo '<input name="peso_aux" type="hidden" value="'.$txtpeso.'">';
		
		echo '<input name="peso_aux2" type="hidden" value="'.$txtpesoTara.'">';
		echo '<input name="id_analisis_aux" type="hidden" value="'.$txtid.'">';		
		$eli= "";
		echo '<input name="eli" type="hidden" value="'.$eli.'">';
		
	}
?>
<table width="100%" height="330" border="0" class="TituloCabeceraOz">
<tr>
      <td align="center" valign="top">
	 	 <table width="634" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="195" align="left" class="titulo_azul">Fecha Produccion</td>
            <td width="412" align="left"> 
              <?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		echo '<select name="dia1" size="1">';
		for ($i=1;$i<=31;$i++)
		{	
			if (($mostrar == "S") && ($i == $dia1))			
				echo "<option selected value= '".$i."'>".$i."</option>";				
			else 
			if (($i == $dia1) and ($mostrar != "S")) 
				echo "<option selected value= '".$i."'>".$i."</option>";											
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}
		echo '</select>';

	?>              
              <select name="mes1" size="1">
                <?php
		for($i=1;$i<13;$i++)
		{
			if (($mostrar == "S") && ($i == $mes1))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == $mes1) && ($mostrar != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
              </select> <select name="ano1" size="1">
                <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($mostrar == "S") && ($i == $ano1))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == $ano1) && ($mostrar != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
            </select></td>
          </tr>
        </table>
        <br>
       	 <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="195" class="titulo_azul">Producto
            <td width="431"> 
			
              <?php
					
					echo '<select name="cmbproducto" onChange="Recarga1PSub()">';
			?>
              <option value="-1">SELECCIONAR</option> 
              <?php
					$consulta = "SELECT * FROM proyecto_modernizacion.productos";
					$consulta.= " WHERE cod_producto IN ('24','28','31','33','47','64')";
					$rs = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($rs))
					{
						if ($row["cod_producto"] == $cmbproducto)
							echo '<option value="'.$row["cod_producto"].'" selected>'.$row["descripcion"].'</option>';
						else
							echo '<option value="'.$row["cod_producto"].'">'.$row["descripcion"].'</option>';
					}
				?>
            </td>
          </tr>
          <tr> 
            <td class="titulo_azul">SubProducto</td>
            <td> 
              <?php				
				echo '<select name="cmbsubproducto">';
			?>
              <option value="-1">SELECCIONAR</option> 
              <?php
					if ($recargapag1 == "S")
					{
						$consulta = "SELECT * FROM proyecto_modernizacion.subproducto";
						$consulta.= " WHERE cod_producto = '".$cmbproducto."'";
						if ($recargapag2 == "P")
						{
							$consulta.=" and cod_subproducto = '".$cmbsubproducto."'";
						}	
						$rs1 = mysqli_query($link, $consulta);
						while ($row1 = mysqli_fetch_array($rs1))
						{
							if (($row1["cod_producto"] == '24' and $row1["cod_subproducto"] == '9') or($row1["cod_producto"] == '28' and $row1["cod_subproducto"] == '1') or ($row1["cod_producto"] == '31' and ($row1["cod_subproducto"] == '1' or $row1["cod_subproducto"] == '2')) or ($row1["cod_producto"] == '33' and $row1["cod_subproducto"] == '2') or ($row1["cod_producto"] == '47' and $row1["cod_subproducto"] == '1') or ($row1["cod_producto"] == '64' and $row1["cod_subproducto"] == '5'))
							{
								$descri = $row1["descripcion"];
								
								if ($row1["cod_subproducto"] == $cmbsubproducto)
									echo '<option value="'.$row1["cod_subproducto"].'" selected>'.$row1["descripcion"].'</option>';
									
								else
									echo '<option value="'.$row1["cod_subproducto"].'">'.$row1["descripcion"].'</option>';
							}
						}
					}
					
				?>
            </td>
          </tr>
        </table>        
       	 <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td width="87" class="titulo_azul">Identificacion:</td>
            <td width="115"><select name="cmbidentificacion">
              <option value="-1">SELECCIONAR</option>
              <?php
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
				$consulta.= " WHERE cod_clase = 6008";
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
					if ($row["cod_subclase"] == $cmbidentificacion)
						echo '<option value="'.$row["cod_subclase"].'"selected>'.$row["nombre_subclase"].'</option>';
					else
						echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
				}
			?>
            </select></td>
            <td width="78" class="titulo_azul">Disponibilidad</td>
            <td width="50"><select name="cmbdisponibilidad" onChange="HabilitarPSub()">
                <?php
				if ($cmbdisponibilidad == "V")
				{
                	echo '<option value="S">STOCK</option>';
                	echo '<option value="V" selected>VENTA</option>';
				}
				else
				{
                	echo '<option value="S" selected>STOCK</option>';
                	echo '<option value="V">VENTA</option>';				
				}
			?>
            </select></td>
            <td width="75" class="titulo_azul">Fecha Venta </td>
            <td width="197"><?php
		echo '<select name="dia2" size="1">';
		for ($i=1;$i<=31;$i++)
		{	
			if (($mostrarPSub == "S") && ($i == $dia2))			
				echo "<option selected value= '".$i."'>".$i."</option>";				
			else if (($i == date("j")) and ($mostrar != "S")) 
					echo "<option selected value= '".$i."'>".$i."</option>";											
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}
		echo '</select>';

	?>
                <select name="mes2" size="1">
                  <?php
		for($i=1;$i<13;$i++)
		{
			if (($mostrarPSub == "S") && ($i == $mes2))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($mostrar != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
                </select>
                <select name="ano2" size="1">
                  <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($mostrarPSub == "S") && ($i == $ano2))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($mostrar != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
                </select>
</td>
          </tr>
          <?php
         	if ($cmbproducto == '28' or $cmbproducto == '24')
			{
				echo '<tr>';
			    echo '<td class="titulo_azul">Id. Analisis:</td>';
			
				?>
			
      <?php
			if ($recargapag2 != 'P')
			{					
			
		?>
      		<td width="76"><input name="txtid" type="text" id="txtid" style="width:65" onKeyDown="TeclaPulsada2PSub('txtnumero');" value="<?php  echo $txtid; ?>"></td>
      	<?php 
			}
				else
			{
				$mostrarPSub="Q";
				
		?>
      			<td width="76"><input name="txtid" type="text" id="txtid" style="width:65" onKeyDown="TeclaPulsada2PSub('txtnumero');" value="<?php  echo $txtid; ?>"></td>
      	<?php
			
				echo '</tr>';
			}
			}
		?>
        </table>
        <br>
		  <table width="637" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td width="39" class="titulo_azul">Numero</td>
			<td width="67"><input name="txtnumero" type="text" id="txtnumero" style="width:60" onKeyDown="TeclaPulsada1PSub('txtpeso');" value="<?php  echo $txtnumero; ?>"></td>
			<td width="85" class="titulo_azul">Peso Neto </td>
            <td width="76">
				<input name="txtpeso" type="text" id="txtpeso" style="width:65" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($txtpeso,2,',','.') ?>" size="15">
		    </td>
		<td width="66" class="titulo_azul">Peso Tara</td> 
		<td width="265">
		<input name="txtpeso2" type="text" id="txtpeso2" style="width:65" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($txtpesoTara,2,',','.') ?>" size="15">
		</td>
           
          </tr>
		</table>
        <br>
       	 <table width="634" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr class="TablaInterior">
            <td align="center">
              <?php
				if ($mostrarPSub2 == "S")
					echo '<input name="btnmodificar" type="button" value="Modificar" style="width:70" onClick="ModificarPSub()">';
				else
				    echo '<input name="btngrabar" id="btngrabar" type="button" value="Grabar" style="width:70" onClick="GrabarPSub()">';
			?>
              <input name="btneliminar" type="button" value="Eliminar" style="width:70" onClick="EliminarPSub()">
              <input name="btnconsultar" type="button" value="Consultar" style="width:70" onClick="ConsultarPSub()">
              <input name="btncancelar" type="button" style="width:70" value="Cancelar" onClick="CancelarPSub()">
            </td>
          </tr>
          <?php
			///aqui?>
		</table>
          <table width="634" border="1" align="center" cellpadding="0" cellspacing="0">
          	<tr align="center"  class="TituloCabeceraAzul">
              <td width="34" height="22" align="center">
                <input type="checkbox" name="todos" value="checkbox" class="SinBorde" onClick="ActivarPSub(this.form)"><strong>Todos</strong></td>
              <td width="128">
                <div align="center"><strong>Cantidad</strong></div></td>
              <td width="142">
                <div align="center"><strong>Peso Neto(Kgr)</strong></div></td>
			<td width="142">
                <div align="center"><strong>Peso Bruto(Kgr)</strong></div></td>
			</tr>
            <?php
				
				$Fecha = $ano1."-".$mes1."-".$dia1; 
			
				if ($mostrarPSub=='Q')
				{	
					$eli= "E";
					echo '<input name="eli" type="hidden" value="'.$eli.'">';
					$Consulta="select * from pmn_web.produccion_subproductos";
					$Consulta.=" where (fecha_produccion = '".$Fecha."') and id_analisis = '".$txtid."'   order by numero";
					//echo $Consulta."<br>";
					$Cont=0;
					$i=1;
					
					$Resultado=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resultado))
					{
					
						echo "<tr>";
						//td width="34" height="22" align="center">
						echo "<td  align='center'><input type='checkbox' name='ChkCaja[".$i."]' class='SinBorde' value='".$Fila[fecha_produccion]."'>\n";
						//echo "<input type='hidden' name='ChkCaja[".$i."]' value='".$Fila[num_caja]."'>\n";
						echo "<input type='hidden' name='ChkCantidad[".$i."]' value='".$Fila["numero"]."'>\n";
						echo "<input type='hidden' name='ChkPeso[".$i."]' value='".$Fila["peso"]."'>\n";
						echo "<td><div align='left'>".$Fila["numero"]."</div></td>";
						echo "<td><div align='left'>".str_replace(".",",",$Fila["peso"])."</div></td>";		
						$peso_bruto = $Fila["peso"] + $Fila["peso_tara"];
						//echo "<td><div align='left'>".str_replace(".",",",$Fila["peso"] + $Fila["peso_tara"])."</div></td>";								
						echo "<td><div align='left'>".str_replace(".",",",$peso_bruto)."</div></td>";								

						echo "</tr>";
						$i++;		
						$Cont++;
					}
				}
				?>
          </table>
	  </td>
</tr>
</table>

<?php //include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php 	//include("../principal/cerrar_pmn_web.php"); ?>
