<?php
include("../principal/conectar_rec_web.php");

if($Proceso == "G")
{
	if(strlen($dia) == 1)
		$dia = "0".$dia;

	if(strlen($mes) == 1)
		$mes = "0".$mes;

	$fecha = $ano.'-'.$mes.'-'.$dia;

	$patente = strtoupper($patente);
	
	$Insertar = "INSERT INTO sipa_web.recepciones (FECHA, RUT_PRV, GUIA_DESPACHO, PATENTE, LOTE, RECARGO, COD_PRODUCTO,COD_SUBPRODUCTO, PESO_NETO)";
	$Insertar = "$Insertar VALUES('$fecha','$cmbproveedor',$guia,'$patente',$lote_ventana,$recargo,'1','17',$peso_recepcion)";
	mysqli_query($link, $Insertar);
}
?>
<html>
<head>
<title>Ingreso Boleta</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function guardar_datos()
{
	f=document.formulario;

	if(f.cmbproveedor.value == -1)
	{
		alert("Debe Seleccionar Proveedor")
		f.cmbproveedor.focus();
		return
	}

	if(f.guia.value == '')
	{
		alert("Debe Ingresar Nro de Gu�a")
		f.guia.focus();
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
		alert("Debe Ingresar Peso Recepci�n")
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
	
}

function valida_minuto()
{
		var f = formulario;
		
		var largo1 = f.minuto.value.length;
		if (largo1 == 1)
			f.minuto.value = "0"+f.minuto.value;
}



</script>
</head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body class="TablaPrincipal">
<form name="formulario" method="post">
  <table width="528" border="0" cellspacing="0" cellpadding="2" a align="center" class="TablaDetalle">
    <tr>
      <td colspan="9" align="center" class="ColorTabla01">Ingreso De Boleta Rancagua </td>
    </tr>
    <tr>
      <td width="90">Fecha </td>
      <td width="287"><font color="#000000" size="2">
        <SELECT name="dia" size="1" style="font-face:verdana;font-size:10">
          <?php
			if($Proceso=='G' || $Proceso == "M")
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
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
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }			
	?>
        </SELECT>
        </font> <font color="#000000" size="2">
        <SELECT name="mes" size="1" id="SELECT" style="FONT-FACE:verdana;FONT-SIZE:10">
          <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='G' || $Proceso == "M")
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
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
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
        </SELECT>
        <SELECT name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
          <?php
	if($Proceso=='G' || $Proceso == "M")
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano)
			{
			echo "<option SELECTed value ='$i'>$i</option>";
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
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
        </SELECT>
      </font></td>
      <td width="136"> Hora :
          <input type="text" name="hora" size="3" value="<?php echo $hora;?>" onBlur="valida_hora(this.form)" >
      Min.:
      <input type="text" name="minuto" size="3"  value="<?php echo $minuto;?>" onBlur="valida_minuto(this.form)" >
      </td>
    <tr>
      <td>Proveedor</td>
      <td><SELECT name="cmbproveedor">
          <option value="-1">Seleccionar</option>
          <option value="00001100-2">Anodos HVL</option>
          <option value="90132000-4">Anodos Disputada</option>
          <option value="61704005-0">Anodos Teniente</option>
        </SELECT>
      </td>
    </tr>
    <tr>
      <td>Guia Rancagua </td>
      <td>
        <input type="text" name="guia" size="8">
      Guia Ventanas :
      <input type="text" name="guia2" size="8">
      </td>
    </tr>
    <tr>
      <td>Patente Tren </td>
      <td>
        <input type="text" name="patente" size="8">
      Patente Cami&oacute;n <strong>
      <input type="text" name="patente2" size="8">
&nbsp;&nbsp; Ej: EH-2134</strong> </td>
    </tr>
    <tr>
      <td>Lote Rancagua </td>
      <td>
        <input type="text" name="lote_ventana" size="8">
      Lote Ventanas :
      <input type="text" name="lote_ventana2" size="8"></td>
    </tr>
    <tr>
      <td>Recargo</td>
      <td>
        <input type="text" name="recargo" size="8">
      </td>
    </tr>
    <tr>
      <td>Peso Recepci&oacute;n</td>
      <td>
        <input type="text" name="peso_recepcion" size="8">
        <strong>&nbsp;&nbsp;Formato Ej: 21520</strong> </td>
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
