<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 14;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sept","Oct","Nov","Dic");
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut=$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");

	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";

	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$AnoIni2     = isset($_REQUEST["AnoIni2"])?$_REQUEST["AnoIni2"]:date("Y");
	$CmbCliente  = isset($_REQUEST["CmbCliente"])?$_REQUEST["CmbCliente"]:"";
	$CmbContrato = isset($_REQUEST["CmbContrato"])?$_REQUEST["CmbContrato"]:"";
	$Tonelada    = isset($_REQUEST["Tonelada"])?$_REQUEST["Tonelada"]:"";
	$FechaHora   = isset($_REQUEST["FechaHora"])?$_REQUEST["FechaHora"]:"";
	$ChkContrato1= isset($_REQUEST["ChkContrato1"])?$_REQUEST["ChkContrato1"]:"";
	$ChkContrato = isset($_REQUEST["ChkContrato"])?$_REQUEST["ChkContrato"]:"";
	$ChkCliente  = isset($_REQUEST["ChkCliente"])?$_REQUEST["ChkCliente"]:"";
	$ChkTonelajeTotal= isset($_REQUEST["ChkTonelajeTotal"])?$_REQUEST["ChkTonelajeTotal"]:"";
	$ChkTonelaje1    = isset($_REQUEST["ChkTonelaje1"])?$_REQUEST["ChkTonelaje1"]:"";
	$ChkTonelaje2    = isset($_REQUEST["ChkTonelaje2"])?$_REQUEST["ChkTonelaje2"]:"";
	$ChkTonelaje3    = isset($_REQUEST["ChkTonelaje3"])?$_REQUEST["ChkTonelaje3"]:"";
	$ChkTonelaje4    = isset($_REQUEST["ChkTonelaje4"])?$_REQUEST["ChkTonelaje4"]:"";
	$ChkTonelaje5    = isset($_REQUEST["ChkTonelaje5"])?$_REQUEST["ChkTonelaje5"]:"";
	$ChkTonelaje6    = isset($_REQUEST["ChkTonelaje6"])?$_REQUEST["ChkTonelaje6"]:"";
	$ChkTonelaje7    = isset($_REQUEST["ChkTonelaje7"])?$_REQUEST["ChkTonelaje7"]:"";
	$ChkTonelaje8    = isset($_REQUEST["ChkTonelaje8"])?$_REQUEST["ChkTonelaje8"]:"";
	$ChkTonelaje9    = isset($_REQUEST["ChkTonelaje9"])?$_REQUEST["ChkTonelaje9"]:"";
	$ChkTonelaje10    = isset($_REQUEST["ChkTonelaje10"])?$_REQUEST["ChkTonelaje10"]:"";
	$ChkTonelaje11    = isset($_REQUEST["ChkTonelaje11"])?$_REQUEST["ChkTonelaje11"]:"";
	$ChkTonelaje12    = isset($_REQUEST["ChkTonelaje12"])?$_REQUEST["ChkTonelaje12"]:"";
	
	
	

?>
<html>
<head>
<script language="JavaScript">
function Proceso(Opt,f)
{
	var Frm=document.FrmIngreso;
	switch (Opt)
	{
		case "O":
			if (Frm.CmbCliente.value == -1 ) 
			{
				alert("Debe Seleccionar Cliente");
				Frm.CmbCliente.focus();
				return;
			}
			if (Frm.CmbContrato.value == -1 ) 
			{
				alert("Debe Seleccionar Contrato");
				Frm.CmbContrato.focus();
				return;
			}
			if (Frm.Tonelada.value == "" ) 
			{
				alert("Debe Ingresar Toneladas");
				Frm.Tonelada.focus();
				return;
			}
			Frm.action="pac_ingreso_programa_ventas01.php?Proceso="+Opt;
			Frm.submit();
		break;
		case "G": 
			var fila = 8; //Posicion Inicial de la Fila.	
			var col = 16;
			var Encontro=false;
			var Valido=false;
			pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
			//largo = f.elements.length;
			largo = Frm.elements.length;
			Suma="";
			for (i=pos; i<largo; i=i+col)
			{
				if (Frm.elements[i].type == 'checkbox')
				{
					if (Frm.elements[i].checked == true)
					{ 	//Suma=Suma=Number(Frm.elements[i+4].value)+Number(Frm.elements[i+5].value)+Number(Frm.elements[i+6].value)+Number(Frm.elements[i+7].value)+Number(Frm.elements[i+8].value)+Number(Frm.elements[i+9].value)+Number(Frm.elements[i+10].value)+Number(Frm.elements[i+11].value)+Number(Frm.elements[i+12].value)+Number(Frm.elements[i+13].value)+Number(Frm.elements[i+14].value)+Number(Frm.elements[i+15].value);
						Suma= Suma+Number(Frm.elements[i+4].value)+Number(Frm.elements[i+5].value)+Number(Frm.elements[i+6].value)+Number(Frm.elements[i+7].value)+Number(Frm.elements[i+8].value)+Number(Frm.elements[i+9].value)+Number(Frm.elements[i+10].value)+Number(Frm.elements[i+11].value)+Number(Frm.elements[i+12].value)+Number(Frm.elements[i+13].value)+Number(Frm.elements[i+14].value)+Number(Frm.elements[i+15].value);
						if (Frm.elements[i+3].value < Suma)
						{
							Encontro=true;
						}
						Valido=true;
					}
				}
			}
			if (Encontro==true)
			{
				alert("El Valor Total es Menor que la Suma de los Valores Ingresados");
			}
			else{
				if(Valido==true){
					Frm.action= "pac_ingreso_programa_ventas01.php?Proceso="+Opt;
					Frm.submit();				
				}else{
					alert("Seleccione un Contrato.");
				}
			}
			/*
			else
			{
				Frm.action= "pac_ingreso_programa_ventas01.php?Proceso="+Opt;
				Frm.submit();
			}*/
			break;
		case "E":		
			var valido = validar_checkbox(Frm);
			if(valido==true){
				var mensaje=confirm("¿Seguro que Desea Elimnar?");
				if (mensaje==true)
				{
					Frm.action= "pac_ingreso_programa_ventas01.php?Proceso="+Opt;
					Frm.submit();
				}
			}else{
				alert("Seleccione un Contrato.");
			}
		break;

		case "S":
			Frm.action="../principal/sistemas_usuario.php?CodSistema=9";
			Frm.submit();	
		break;
		
		case "B":
			Frm.action= "pac_ingreso_programa_ventas.php?Proceso="+Opt;
	 		Frm.submit();
		break;
		
		case "A":
			Frm.action= "pac_ingreso_programa_ventas.php";
	 		Frm.submit();
		break;
	}
}

function validar_checkbox(Frm) {
	var fila = 8; //Posicion Inicial de la Fila.	
	var col = 16;
	var Valido=false;
	pos   = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = Frm.elements.length;
	for (i=pos; i<largo; i=i+col)
	{
		if (Frm.elements[i].type == 'checkbox')
		{
			if (Frm.elements[i].checked == true)
			{ 	
				Valido=true;
			}
		}
	}
	if(Valido==true){
		return true;
	}else{
	    return false;
	}
}

function Calcula(J)
{
	var Frm=document.FrmIngreso;
	
	var Suma=Number(Frm.elements[J].value)+Number(Frm.elements[J+1].value)+Number(Frm.elements[J+2].value)+Number(Frm.elements[J+3].value)+Number(Frm.elements[J+4].value)+Number(Frm.elements[J+5].value)+Number(Frm.elements[J+6].value)+Number(Frm.elements[J+7].value)+Number(Frm.elements[J+8].value)+Number(Frm.elements[J+9].value)+Number(Frm.elements[J+10].value)+Number(Frm.elements[J+11].value);
	if (Frm.elements[J-1].value < Suma)
	{
		alert("El Valor Ingresado Supera el Valor Total");
		return;
	}
	else
	{
		return;
	}
}
function Recarga()
{
	var Frm=document.FrmIngreso;
	Frm.action="pac_ingreso_programa_ventas.php";
	Frm.submit();
}
var fila = 8; //Posicion Inicial de la Fila.
var col = 16;
function Activar(Frm)
{
	if (Frm.todos.checked == true)
		valor = true
	else valor = false;		
	pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = Frm.elements.length;
	for (i=pos; i<largo; i=i+col)
	{	
		if (Frm.elements[i].type != 'checkbox')
			return;
		else 
			Frm.elements[i].checked = valor;
	}	
}
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmIngreso;
	var teclaCodigo = event.keyCode; 
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
	{
		if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
} 
</script>
<title>Programacion De Ventas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngreso" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td width="203" height="32" align="center" valign="top"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
          <?php
					$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from proyecto_modernizacion.funcionarios where rut = '".$Rut."'";
					$Resultado= mysqli_query($link, $Consulta);
					if ($Fila =mysqli_fetch_array($Resultado))
					{	
						echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
					}	  
					else
					{
						$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
						$Respuesta = mysqli_query($link, $Consulta);
						if ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
						}
					}
		  			?>
          </strong></font></font></div></td>
      <td width="409" align="center" valign="top"><font size="1"><font size="1"><font size="2">
        <select name="AnoIni2" style="width:60px;">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoIni2))
				{
					if ($i == $AnoIni2)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		?>
        </select>
        <input name="BtnBuscar" type="button" id="BtnBuscar2" value="Buscar" onClick="Proceso('B');">
        </font></font></font></td>
      <td width="147" align="center" valign="top"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
        <?php echo $Fecha_Hora ?> </strong>&nbsp; <strong> 
        <?php
					if ($FechaHora=="")
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
      <td colspan="3" align="center" valign="top"> <table width="752" border="0" class="TablaInterior">
          <tr> 
            <td colspan="3">&nbsp;</td>
            <td colspan="2"><div align="left"><font size="1"><font size="1"><font size="2"> 
                </font></font></font></div></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td width="59"><div align="right">Cliente</div></td>
            <td width="240"> <select name="CmbCliente" style="width:240" onChange="Recarga();">
                <option value="-1">Seleccionar</option>
                <?php
			$Consulta="select DISTINCT t1.rut_cliente,t1.nombre from pac_web.clientes t1 inner join pac_web.contrato_cliente t2 ";	
			$Consulta.=" on t1.rut_cliente = t2.rut_cliente  ";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbCliente==$Fila["rut_cliente"])
				{
					echo "<option value = '".$Fila["rut_cliente"]."' selected>".$Fila["rut_cliente"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";	
				}
				else
				{
					echo "<option value = '".$Fila["rut_cliente"]."'>".$Fila["rut_cliente"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";	
				}
			}
			?>
              </select> </td>
            <td width="16">&nbsp;</td>
            <td width="68">N&deg;Contrato</td>
            <td width="101"><select name="CmbContrato" style="width:90">
                <option value="-1">Seleccionar</option>
                <?php
				$Consulta="select nro_contrato from pac_web.contrato_cliente where rut_cliente = '".$CmbCliente."' ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbContrato==$Fila["nro_contrato"])
					{
						echo "<option value = '".$Fila["nro_contrato"]."' selected>".$Fila["nro_contrato"]."</option>";	
					}
					else
					{
						echo "<option value = '".$Fila["nro_contrato"]."'>".$Fila["nro_contrato"]."</option>";	
					}
				}
				?>
              </select></td>
            <td width="43"><div align="center">Ton</div></td>
            <td width="192"><input name="Tonelada" type="text" onKeyDown="TeclaPulsada();" style="width:90" >
              <input name="BtnOk" type="button" id="BtnOk" value="Ok" onClick="Proceso('O');"></td>
          </tr>
        </table>
        <br>
        <table width="762" height="20" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="15" height="15"><input type="checkbox" name="todos" value="checkbox" onClick="Activar(this.form)"></td>
            <td width="60"><strong>#Contrato</strong></td>
            <td width="80"><strong>Cliente</strong></td>
            <td width="55"><strong>Total</strong></td>
            <?php
			for($i=1;$i<13;$i++)
		  	{
				echo "<td width='40'>".$meses[$i-1]."</td>";
			}
			?>
		  </tr>
          <?php	
		$Consulta = "select * from pac_web.programa_ventas ";
		if ($Proceso =='B')
		{
			$Consulta.=" where fecha between '".$AnoIni2."-01-01 00:01:00' and '".$AnoIni2."-12-31 23:59:00' order by nro_contrato,rut_cliente"; 
		}
		else
		{
			$Consulta.=" order by nro_contrato,rut_cliente";
		}
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		$J=8;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>";
			echo "<td align='center'><input type='checkbox' name='ChkContrato1[".$i."]' value='".$Fila["nro_contrato"]."'></td>";
			echo "<td align='center'><input type='text' style='width:60'  name='ChkContrato[".$i."]' readonly value='".$Fila["nro_contrato"]."'></td>";
			echo "<td align='center'><input type='text' style='width:80' name='ChkCliente[".$i."]' value='".$Fila["rut_cliente"]."'></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelajeTotal[".$i."]' value='".$Fila["tonelaje_total"]."'></td>";
			echo "<td align='center'><input type='text' style='width:40' name='ChkTonelaje1[".$i."]' value='".$Fila["tonelaje1"]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:40' name='ChkTonelaje2[".$i."]' value='".$Fila["tonelaje2"]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:40' name='ChkTonelaje3[".$i."]' value='".$Fila["tonelaje3"]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:40' name='ChkTonelaje4[".$i."]' value='".$Fila["tonelaje4"]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:40' name='ChkTonelaje5[".$i."]' value='".$Fila["tonelaje5"]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:40' name='ChkTonelaje6[".$i."]' value='".$Fila["tonelaje6"]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:40' name='ChkTonelaje7[".$i."]' value='".$Fila["tonelaje7"]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:40' name='ChkTonelaje8[".$i."]' value='".$Fila["tonelaje8"]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:40' name='ChkTonelaje9[".$i."]' value='".$Fila["tonelaje9"]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:40' name='ChkTonelaje10[".$i."]' value='".$Fila["tonelaje10"]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:40' name='ChkTonelaje11[".$i."]' value='".$Fila["tonelaje11"]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:40' name='ChkTonelaje12[".$i."]' value='".$Fila["tonelaje12"]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			
			echo "</tr>";
			$i++;
			$J=$J+16;
		}
		?>
        </table>
        <br>
        <table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="51">&nbsp;</td>
            <td width="165">&nbsp;</td>
            <td width="309"><div align="center">
                <input name="BtnActualizar" type="button" id="BtnActualizar" style="width:60px;" onClick="Proceso('A');" value="Actualizar">
                <input name="BtnGrabar2" type="button" value="Grabar" style="width:60px;" onClick="Proceso('G',this.form);">
                <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="Proceso('E');">
                <input name="BtnSalir2" type="button" id="BtnSalir" value="Salir" style="width:60px;" onClick="Proceso('S');">
              </div></td>
            <td width="209" align="center">&nbsp; </td>
          </tr>
      </table> </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if ($Mostrar=='S')
	{
		echo "<script language='JavaScript'>";
		echo "var Frm=document.FrmIngreso;";
		echo "alert('Este Contrato Ya existe');";
		echo "Frm.CmbContrato.focus();";
		echo "</script>";
	}
?>
