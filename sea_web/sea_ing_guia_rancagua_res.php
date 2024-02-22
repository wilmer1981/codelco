<?php
include("../principal/conectar_rec_web.php");
$HoraActual = date("H");
$MinutoActual = date("i");

if (Proceso=='GO')
{
	$seleccionar = "Select * From tabla_rancagua where guia_rancagua = '".$guia_origen."'  and  ......";
	$resultado = mysqli_query($link, $seleccionar);
	if ($Fila = mysqli_fetch_array($resultado))
	{
		$guia_origen =  $Fila[guia_origen];
		$lote_origen =  $Fila[lote_origen];
		$patente_tren = $Fila[patente_tren];
		$peso_origen =  $Fila[peso_origen];
	}
				
} 			
				
?>
<html>
<head>
<title>Ingreso Boleta</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function valida_proveedor()
{
	
	f.document.formulario;
	if (f.cmbproveedor=='-1')
	{
		alert ("Debe seleccionar Proveedor");
	}
	else
	{
		f.guia_origen.focus();
	}
}
function guardar_datos()
{
	f=document.formulario;

	if(f.cmbproveedor.value == -1)
	{
		alert("Debe Seleccionar Proveedor")
		f.cmbproveedor.focus();
		return
	}

	if(f.guia_ventana.value == '')
	{
		alert("Debe Ingresar Nro de Guía")
		f.guia_ventana.focus();
		return
	}

	if(f.patente.value == '')
	{
		alert("Debe Ingresar Nro de Patente")
		f.patente.focus();
		return
	}

	if(f.lote_ventana.value == '')
	{
		alert("Debe Ingresar Nro de Lote")
		f.lote_ventana.focus();
		return
	}

	if(f.recargo.value == '')
	{
		alert("Debe Ingresar Nro de Recargo")
		f.recargo.focus();
		return
	}

	if(f.peso_recepcion.value == '')
	{
		alert("Debe Ingresar Peso Recepción")
		f.peso_recepcion.focus();
		return
	}

	f.action="sea_ing_guia.php?Proceso=G";
	f.submit()
}
function valida_hora()
{
	
	var f = formulario;
		
	var largo = f.hora.value.length;
		if (largo == 1)
			f.hora.value = "0"+f.hora.value;
	f.minuto.focus();
	
}

function valida_minuto()
{
		var f = formulario;
		
		var largo1 = f.minuto.value.length;
		if (largo1 == 1)
			f.minuto.value = "0"+f.minuto.value;
		f.guia_origen.focus();
}
function valida_campo(opc)
{
	var f = formulario;
  	switch (opc)
	{
		case "GO" :
			if (f.guia_rancagua.value=="")
			{
				alert("Guia de Origen debe ingresarse");
				break;
			}
			else
			{
				linea = f.dia.value + "/" + f.mes.value + "/" + f.ano.value + "/" + f.hora.value + "/";
				linea = linea + "/" + f.minuto.value + "/" + f.guia_origen.value; 
				f.action="sea_ing_rancagua_res.php?proceso=GO&linea="linea;
				f.submit();
				break;
			}
	  case "GV" :
	  		if (f.guia_ventana.value=="")
			{
				alert ("Guia de Ventanas debe ingresarse");
				break;
			}
			else
			{
				f.patente_camion.focus();
				break;
			}
	  case "LV" :
	  		if (f.lote_origen.value=="")
			{
				alert ("Lote Ventanas debe ingresarse");
				break;
			}
			else
			{
				linea = f.dia.value + "/" + f.mes.value + "/" + f.ano.value + "/" + f.hora.value + "/";
				linea = linea + "/" + f.minuto.value + "/" + f.guia_origen.value + "/" + f.guia_ventana.value + "/" + f.patente_camion.value + "/" +f.lote_ventana_value; 
				f.action="sea_ing_guia_rancagua_02.php?proceso=LV&linea="linea;
				f.submit();
				break;
			}
	   case "PV"  :
	   		{
				if (f.patente_camion.value=="")
				{
					alert ("Patente Camión debe ingresarse");
					break;
				}
				else
				{
					f.lote_ventana.focus();
					break;
				}

	}
}


</script>
</head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body class="TablaPrincipal">
<form name="formulario" method="post">
<?php echo '<input type="hidden" name="txtrut" value="'.$txtrut.'">';   ?>
  <table width="606" border="0" cellspacing="0" cellpadding="2" a align="center" class="TablaDetalle">
    <tr>
      <td colspan="9" align="center" class="ColorTabla01">Ingreso De Boleta Rancagua </td>
    </tr>
	    <tr>
      <td>Proveedor</td>
      <?php echo "<td><input type='text' name='txtproveedor' value='".$txtproveedor."' size='30' ></td>"; ?>
    </tr>

    <tr>
      <td width="80">Fecha </td>
      <td width="510"><font color="#000000" size="2">
        <select name="dia" size="1" style="font-face:verdana;font-size:10">
          <?php
			if($Proceso=='GO' || $Proceso == "M")
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
			}
			else
			{
				for ($i=1;$i<=31;$i++)
				{
	   				   if ($i==date("j"))
						{
						echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }			
	?>
        </select>
        </font> <font color="#000000" size="2">
        <select name="mes" size="1" id="select2" style="FONT-FACE:verdana;FONT-SIZE:10">
          <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='GO' || $Proceso == "M")
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==date("n"))
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
        </select>
        <select name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
          <?php
	if($Proceso=='GO' || $Proceso == "M")
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano)
			{
			echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
        </select>
      Hora Recepci&oacute;n :
	                 <select name="CmbHora" id="select33">
                  <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($Hora))
					{	
						if ($Hora == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
                </select>
                 
                     <select name="CmbMinutos">
                  <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($CmbMinutos))
					{	
						if ($Minutos == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
                </select>
            </td>
 
      <td width="1">&nbsp; </td>
    <tr>
      <td>Guia Rancagua </td>
      <td>
        <input type="text" name="guia_origen" size="8" id="guia_origen" onChange="valida_campo(GO)">
      Lote Rancagua :
      <input type="text" name="lote_origen" size="8" value=" <?php echo $lote_origen;?> ">
      Peso Lote :
      <input type="text" name="peso_origen" size="8" value=" <?php echo $peso_origen;?> ">
      Patente Tren
      <input type="text" name="patente_tren" size="8" value="<?php echo $patente_tren; ?> "></td>
    </tr>
    <tr>
      <td>Guia Ventanas </td>
      <td>
        <input type="text" name="guia_ventana" id="guia_ventana2" size="8"  onChange="valida_campo(GV)"></td>
    </tr>
    <tr>
      <td height="23">Patente Cami&oacute;n</td>
      <td><strong>
        <input type="text" name="patente_camion" size="8" id="patente_camion" onChange="valida_campo(PV)">
&nbsp; Ej: EH-2134 </strong> </td>
    </tr>
    <tr>
      <td height="36">Lote Ventanas </td>
      <td> <input type="text" name="lote_ventana" id="lote_ventana" size="8" onChange="valida_campo(LV)">
        Hornada
          <input type="text" name="hornada" id="hornada" size="8" value=" <?php echo $hornada; ?> ">
      Recargo
      <input type="text" name="recargo" size="3" id="recargo" value=" <?php echo $recargo; ?> ">
      Unidades :
      <input type="text" name="unidades" id="unidades2" size="4" onChange="valida_campo(UV)">
      Peso 
      <input type="text" name="peso_recepcion" id="peso_recepcion2" size="8"  value=" <?php echo $peso_recepcion; ?> ">      </td>
    </tr>
  </table>
  <br>
	  <table width="523" border="1" cellspacing="0" cellpadding="2" a align="center" class="TablaDetalle">
		<tr> 
		  <td width="514" colspan="9" align="center">
		  <input type="button" name="guardar" value="Guardar" style="width:70" onClick="guardar_datos()">
		  <input type="button" name="salir" value="Salir" style="width:70" onClick="self.close()">
		  </td>
		</tr>
	  </table>	  
</form>
</body>
</html>
