<?php
if(!isset($CmbTipo))
	$CmbTipo="2";
	
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 122;
	
	include("../principal/conectar_pmn_web.php");
	if ($ConsultaFusion == "S")
	{
		$MostrarFusion = "S";
		$DiaFusion = $IdDiaFusion;
		$MesFusion = $IdMesFusion;
		$AnoFusion = $IdAnoFusion;
	}
	/*if ($Mostrar == "S")
	{
		$Consulta = "select * from pmn_web.carga_fusion_barro_aurifero ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			
		}
	}*/
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ProcesoFusion(opt)//Opcion de boton y opcion de del checkbox
{
	var f = document.frmPrincipalRpt;
	switch (opt)
	{
		case "R":
			f.action="pmn_principal_reportes.php?Ver=L&Tab5=true";
			f.submit();
			break;
		case "G2": //GRABAR DETALLE
				if (f.CmbProductos.value == 'S')
				{
					alert("Debe Seleccionar Producto");
					f.CmbProductos.focus();
					return;
				}
				if (f.CmbSubProducto.value == 'S')
				{
					alert("Debe Seleccionar SubProducto");
					f.CmbSubProducto.focus();
					return;
				}
				if (f.Peso.value == "")
				{
					alert("Debe Ingresar Peso");
					f.Peso.focus();
					return;
				}
				f.action= "pmn_carga_fusion01.php?Proceso="+opt;
		 		f.submit();
			break;
		case "M2": //MODIFICAR DETALLE
			f.action= "pmn_carga_fusion01.php?Proceso=M";
			f.submit();
			break;
		case "E2": //ELIMINAR
			var mensaje = confirm("Seguro que desea Eliminar?");
			if (mensaje==true)
			{
				f.action= "pmn_carga_fusion01.php?Proceso=E2";
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "C": //CANCELAR
			f.action= "pmn_carga_fusion01.php?Proceso=C";
		 	f.submit();	
			break;
		case "B": //Consultar 
			var URL = "pmn_carga_fusion02.php?DiaIniCon=" + f.DiaFusion.value + "&MesIniCon=" + f.MesFusion.value + "&AnoIniCon=" + f.AnoFusion.value + "&DiaFinCon=" + f.DiaFusion.value + "&MesFinCon=" + f.MesFusion.value + "&AnoFinCon=" + f.AnoFusion.value;
			window.open(URL,"","top=120,left=30,width=740,height=400,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=107";
	 		f.submit();
			break;
		case "Recuperacion":
			if(f.Recuperacion.value=="")
			{
				alert("Debe Ingresar % Recuperacion");
				f.Recuperacion.focus();
				return;
			}
			if (f.Recuperacion.value > 100)
			{
				alert("El % de Recuperacion debe ser menor  que 100");
				f.Recuperacion.focus();
				return;
			}
			if(f.CantAnodos.value=="")
			{
				alert("Debe Ingresar Cantidad de Anodos ");
				f.CantAnodos.focus();
				return;
			}
			f.action="pmn_carga_fusion01.php?Proceso=Recuperacion";
			f.submit();
			break;
		case "PesoFusion":
			f.action="pmn_carga_fusion01.php?Proceso=PesoFusion";
			f.submit();
		break;
	}

}
function RecargaFusion()
{
	var f=document.frmPrincipalRpt;
	f.action="pmn_carga_fusion.php";
	f.submit();
}
function TeclaPulsadaFusion (tecla) 
{ 
	var Frm=document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 100 )&&(teclaCodigo != 190 )&&(teclaCodigo != 110 ))
	{
		if (((teclaCodigo != 8)&&(teclaCodigo !=9 )) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
} 
var fila = 18; //Posicion Inicial de la Fila.
var col = 7;
function ActivarFusion(f)
{
	if (f.todos.checked == true)
		valor = true
	else valor = false;		

	pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = f.elements.length;
	for (i=pos; i<largo; i=i+col)
	{	
		//alert(f.elements[i].name);
		if (f.elements[i].type != 'checkbox')
			return;
		else 
			f.elements[i].checked = valor;
	}	
}
function BuscarSubProductoFusion()
{
	window.open("pmn_buscar_subproducto.php","","top=80,left=10,width=750,height=460,scrollbars=yes,resizable = no");	
}
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipalFusion" method="post" action="">
  <table width="100%" height="330" border="0" class="TituloCabeceraOz">
    <tr>
      <td align="center" valign="top"><table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td height="30" colspan="3">&nbsp;</td>
            <td colspan="2"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php echo $Fecha_Hora ?> </strong>&nbsp; <strong> 
              <?php
					if (!isset($FechaHora))
					{
						echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
						$FechaHora=date('Y-m-d H:i');
					}
					else
					{ 
						echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
					}
				  ?>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td width="100" height="30" class="titulo_azul">Fecha:</td>
            <td width="272" class="formulario"> 
              <?php 
				if ($Mostrar == "S")
				{
					echo "<input type='hidden' name='DiaFusion' value='".$DiaFusion."'>\n";
					echo "<input type='hidden' name='MesFusion' value='".$MesFusion."'>\n";
					echo "<input type='hidden' name='AnoFusion' value='".$AnoFusion."'>\n";
					printf("%'02d",$DiaFusion);
					echo "-";
					printf("%'02d",$MesFusion);
					echo "-";
					printf("%'04d",$AnoFusion);
				}
				else
				{
					echo "<select name='DiaFusion' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaFusion))
						{
							if ($i == $DiaFusion)
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
				  echo "</select> <select name='MesFusion' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesFusion))
						{
							if ($i == $MesFusion)
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
				  echo "</select> <select name='AnoFusion' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($AnoFusion))
						{
							if ($i == $AnoFusion)
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
			//echo $Mes=$MesActual."<br>";
			?>
              <font size="1"><font size="1"><font size="1"><font size="2"><strong> 
              </strong></font></font></font></font> </td>
            <td width="67"><input name="ver" type="button" style="width:70" value="Consultar" onClick="ProcesoFusion('B');"></td>
            <td width="174"> <div align="left"><strong>
           	    <input name="BtnBuscarSP" type="button" value="Buscar Producto" style="width:100" onClick="BuscarSubProductoFusion();">
			     </strong> </div></td>
            <td width="111">&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td>
            <td class="titulo_azul">Tipo</td>
            <td colspan="3">
			<select name="CmbTipo">
            <?php
			$Consulta="select * from proyecto_modernizacion.sub_clase ";
			$Consulta.=" where cod_clase=6007 and (cod_subclase between 1 and 2) order by cod_subclase ";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbTipo==$Fila["cod_subclase"])
				{
					echo "<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
				}
				else
				{
					echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
				}
				
			}
			?>
			</select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td width="45"> 
            <td width="81" class="titulo_azul">Producto:</td>
            <td colspan="3"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2"><strong> 
              <select name="CmbProductos" style="width:220px" onChange="ProcesoFusion('R');">
                <?php
				echo "<option value='S'>Seleccionar</option>\n";
				$Consulta = "select distinct t2.cod_producto,t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.productos t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1 = t2.cod_producto and t1.nombre_subclase='3'";
				$Consulta.= " order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($CmbProductos == $Row["cod_producto"])
						echo "<option selected value='".$Row["cod_producto"]."'>";														
					else	echo "<option value='".$Row["cod_producto"]."'>";
					//printf("%'03d",$Row["cod_producto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
/*				echo "<option value='S'>-----------------------------</option>\n";
				$Consulta = "select * from proyecto_modernizacion.productos order by descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($CmbProductos == $Row["cod_producto"])
								echo "<option selected value='".$Row["cod_producto"]."'>";														
							else	echo "<option value='".$Row["cod_producto"]."'>";
							//printf("%'03d",$Row["cod_producto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}*/
			?>
              </select>
            </strong></font></font></font></font></font></td>
            <td width="92" class="titulo_azul">SubProducto</td>
            <td width="394"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2"><strong> 
              <select name="CmbSubProducto" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
				$Consulta = "select t2.cod_subproducto, t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.subproducto t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1='".$CmbProductos."' and ";
				$Consulta.= " t1.valor_subclase2 = t2.cod_subproducto and t2.cod_producto='".$CmbProductos."' and t1.nombre_subclase='3'";
				$Consulta.= " order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($CmbSubProducto == $Row["cod_subproducto"])
					{	
						echo "<option selected value='".$Row["cod_subproducto"]."'>";														
					}
					else
					{
						echo "<option value='".$Row["cod_subproducto"]."'>";
					}
					//printf("%'03d",$Row["cod_subproducto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
/*				echo "<option value='S'>-----------------------------</option>\n";
				$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$CmbProductos."' order by descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($CmbSubProducto == $Row["cod_subproducto"])
					{
						echo "<option selected value='".$Row["cod_subproducto"]."'>";														
					}
					else
					{
						echo "<option value='".$Row["cod_subproducto"]."'>";
					}
					//printf("%'03d",$Row["cod_subproducto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}*/
			?>
              </select>
            </strong></font></font></font><font size="2"><strong> </strong></font></font></font></td>
          </tr>
          <tr> 
            <td> 
            <td class="titulo_azul">Peso</td>
            <td colspan="3"><input name="Peso" type="text" id="Peso2" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($Peso,4,',','');?>" size="15" maxlength="15"></td>
            <td class="titulo_azul">Observacion</td>
            <td><input name="Observacion" type="text" id="Observacion2" style="width:220px" value="<?php echo $Observacion;  ?>"></td>
          </tr>
        </table>
		<br>
        <table width="759" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td height="22" colspan="5"><input type="hidden" name="Correlativo"style="width:20px" value="<?php echo $Correlativo;   ?>"> </td>
            <?php //echo "Correlativo".$Correlativo."<br>";   ?>
			<td height="22"><font size="1"><font size="1"><font size="2"><strong> 
              <input name="BtnGrabar2" type="button" value="Grabar" style="width:60px;" onClick="ProcesoFusion('G2','<?php echo $Ver; ?> ');">
              </strong></font><font size="1"><font size="1"><font size="2"><strong> 
              <input name="BtnModificar2" type="button" value="Modificar" style="width:60px;" onClick="ProcesoFusion('M2','<?php echo $Ver; ?>');">
              </strong></font></font></font><font size="2"><strong> </strong></font></font></font> 
              <font size="1"><font size="1"><font size="1"><font size="2"><strong> 
              <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="ProcesoFusion('E2','<?php echo $Ver;  ?>');">
              </strong></font></font></font></font> <input name="BtnCancelar" type="button" id="BtnCancelar" value="Cancelar" style="width:60px;" onClick="ProcesoFusion('C','<?php echo $Ver;  ?>');"> 
              <!--<input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:60px;" onClick="ProcesoFusion('S');"> -->
            </td>
          </tr>
        </table>
        <br> 
        <table width="759" height="18" border="1"  cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="TituloCabeceraAzul"> 
            <td width="51" height="15"><input type="checkbox" name="todos" value="checkbox" class='SinBorde' onClick="ActivarFusion(this.form)"></td>
            <td width="145"><strong>Producto</strong></td>
            <td width="139"><strong>SubProducto</strong></td>
            <td width="97"><strong>Pesos</strong></td>
            <td width="269"><strong>Observacion</strong></td>
          </tr>
          <?php	
		$Consulta= "select t1.peso,t1.recuperacion,t2.abreviatura as DesProducto,t3.abreviatura as DesSubProducto, ";
		$Consulta= $Consulta." t3.cod_subproducto,t2.cod_producto,t1.observacion,correlativo,cantidad_anodos,tipo  ";
		$Consulta= $Consulta." from pmn_web.fusion t1 ";
		$Consulta= $Consulta." left join proyecto_modernizacion.productos t2 on ";
		$Consulta= $Consulta." t1.producto = t2.cod_producto "; 
		$Consulta= $Consulta." left join proyecto_modernizacion.subproducto t3 on ";
		$Consulta= $Consulta." t1.subproducto = t3.cod_subproducto and t2.cod_producto=t3.cod_producto ";
 		$Consulta= $Consulta." where fecha = '".$AnoFusion."-".$MesFusion."-".$DiaFusion."'  and tipo=2 order by t1.fecha,correlativo,t1.producto,t1.subproducto ";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";
			echo "<td align='center'><input type='checkbox' name='ChkFecha[".$i."]' class='SinBorde' value='".$Row["fecha"]."'>\n";
			echo "<input type='hidden' name='ChkProducto[".$i."]' value='".$Row["cod_producto"]."'>\n";
			echo "<input type='hidden' name='ChkSubProducto[".$i."]' value='".$Row["cod_subproducto"]."'>\n";
			echo "<input type='hidden' name='ChkPesos[".$i."]' value='".str_replace(".",",",$Row["peso"])."'>\n";
			echo "<input type='hidden' name='ChkObservacion[".$i."]' value='".$Row["observacion"]."'>\n";
			echo "<input type='hidden' name='ChkCorrelativo[".$i."]' value='".$Row[correlativo]."'>\n";
			echo "<input type='hidden' name='ChkTipo[".$i."]' value='".$Row[tipo]."'>\n";
			echo "</td>\n";
			echo "<td align='center'>".$Row[DesProducto]."&nbsp;</td>\n";
			echo "<td align='center'>".$Row[DesSubProducto]."&nbsp;</td>\n";
			echo "<td align='center'>".number_format($Row["peso"],4,',','.')."&nbsp;</td>\n";
			echo "<td align='left'>".$Row["observacion"]."&nbsp;</td>\n";
			$Suma=$Suma+$Row["peso"];
			echo "</tr>\n";
			$i++;
			$Recuperacion=$Row[recuperacion];
			$PesoF=$PesoF + $Row["peso"];
			$CantAnodos=$Row[cantidad_anodos];
		}
		
		echo "<tr>\n";
		echo "<td colspan='3'>&nbsp;</td>";
		echo "<td><strong>Peso:$PesoF</strong></td>";
		echo "<td>&nbsp;</td>";
			//echo "&nbsp;&nbsp;<input name='PesoFusion' type='text' onKeyDown='TeclaPulsada();' style=width:'50' value =".str_replace(".",",",$PesoF)." ></td>\n";		
		echo "</tr>\n";
		$Consulta= "select t1.peso,t1.recuperacion,t2.abreviatura as DesProducto,t3.abreviatura as DesSubProducto, ";
		$Consulta= $Consulta." t3.cod_subproducto,t2.cod_producto,t1.observacion,correlativo,cantidad_anodos,tipo  ";
		$Consulta= $Consulta." from pmn_web.fusion t1 ";
		$Consulta= $Consulta." left join proyecto_modernizacion.productos t2 on ";
		$Consulta= $Consulta." t1.producto = t2.cod_producto "; 
		$Consulta= $Consulta." left join proyecto_modernizacion.subproducto t3 on ";
		$Consulta= $Consulta." t1.subproducto = t3.cod_subproducto and t2.cod_producto=t3.cod_producto ";
 		$Consulta= $Consulta." where fecha = '".$AnoFusion."-".$MesFusion."-".$DiaFusion."' and tipo =1 order by t1.fecha,correlativo,t1.producto,t1.subproducto ";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		$i=$i;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";
			echo "<td align='center'><input type='checkbox' name='ChkFecha[".$i."]' class='SinBorde' value='".$Row["fecha"]."'>\n";
			echo "<input type='hidden' name='ChkProducto[".$i."]' value='".$Row["cod_producto"]."'>\n";
			echo "<input type='hidden' name='ChkSubProducto[".$i."]' value='".$Row["cod_subproducto"]."'>\n";
			echo "<input type='hidden' name='ChkPesos[".$i."]' value='".str_replace(".",",",$Row["peso"])."'>\n";
			echo "<input type='hidden' name='ChkObservacion[".$i."]' value='".$Row["observacion"]."'>\n";
			echo "<input type='hidden' name='ChkCorrelativo[".$i."]' value='".$Row[correlativo]."'>\n";
			echo "<input type='hidden' name='ChkTipo[".$i."]' value='".$Row[tipo]."'>\n";
			echo "</td>\n";
			echo "<td align='center'>".$Row[DesProducto]."&nbsp;</td>\n";
			echo "<td align='center'>".$Row[DesSubProducto]."&nbsp;</td>\n";
			echo "<td align='center'>".$Row["peso"]."&nbsp;</td>\n";
			echo "<td align='left'>".$Row["observacion"]."&nbsp;</td>\n";
			$Suma=$Suma+$Row["peso"];
			echo "</tr>\n";
			$i++;
			$PesoP=$PesoP + $Row["peso"];
			$CantAnodos=$Row[cantidad_anodos];
			//echo $Row["peso"]."<br>";
		}
		echo "<td>Recup</td>\n";
		//echo "peso P_: ".$PesoP."<br>";
		if ($PesoP!=0)
		{
			$Recuperacion=number_format((($PesoP/$PesoF)*100),2);
			//echo "peso recuperacion:   ".$Recuperacion."<br>";
		}
		echo "<td><input name='Recuperacion' type='text' readonly onKeyDown='TeclaPulsada();' style=width:'50' value =".str_replace(".",",",$Recuperacion)." >%</td>\n";
		echo "<td>Cant/Anod";
		echo "&nbsp;&nbsp;<input name='CantAnodos' type='text' onKeyDown='TeclaPulsada();' style=width:'50' value =".str_replace(".",",",$CantAnodos)."></td>\n";		
		echo "<td><strong>Peso:$PesoP</strong>";
		echo "<td><input name='Ok' type='button'  value ='Ok' onClick=\"ProcesoFusion('Recuperacion','$Ver');\"></td>\n";
		echo "</tr>\n";
		if ($PesoP!=0)
		{
			$Actualizar=" UPDATE pmn_web.fusion set recuperacion='".str_replace(",",".",$Recuperacion)."' ";
			$Actualizar.=" where fecha='".$AnoFusion."-".$MesFusion."-".$DiaFusion."'";		
			//echo $Actualizar;
			mysqli_query($link, $Actualizar);
		}
?>
      </table></td>
  </tr>
</table>

</form>
</body>
</html>
