<?php
include("../principal/conectar_rec_web.php");
if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = '';
}
if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano = "";
}
if(isset($_REQUEST["mes"])) {
	$mes= $_REQUEST["mes"];
}else{
	$mes = "";
}
if(isset($_REQUEST["dia"])) {
	$dia= $_REQUEST["dia"];
}else{
	$dia = "";
}

if(isset($_REQUEST["lote_ventana"])) {
	$lote_ventana = $_REQUEST["lote_ventana"];
}else{
	$lote_ventana = "";
}
if(isset($_REQUEST["patente"])) {
	$patente = $_REQUEST["patente"];
}else{
	$patente = "";
}
if(isset($_REQUEST["cmbproveedor"])) {
	$cmbproveedor = $_REQUEST["cmbproveedor"];
}else{
	$cmbproveedor = "";
}
if(isset($_REQUEST["guia"])) {
	$guia = $_REQUEST["guia"];
}else{
	$guia = "";
}
if(isset($_REQUEST["recargo"])) {
	$recargo = $_REQUEST["recargo"];
}else{
	$recargo = "";
}
if(isset($_REQUEST["peso_recepcion"])) {
	$peso_recepcion = $_REQUEST["peso_recepcion"];
}else{
	$peso_recepcion = "";
}



if($Proceso == "G")
{
	if(strlen($dia) == 1)
		$dia = "0".$dia;

	if(strlen($mes) == 1)
		$mes = "0".$mes;

	$fecha = $ano.'-'.$mes.'-'.$dia;
	
	if (strlen($lote_ventana)==7)
		$lote_ventana = "0".$lote_ventana;
	
	$patente = strtoupper($patente);
	if ($cmbproveedor=="1100-2")
		$Conjunto = "5000";
	else
		$Conjunto = "7000";
	
	$Consulta ="Select max(correlativo) as numero from sipa_web.recepciones";
	$Rsp=mysqli_query($link, $Consulta);
	if($Row=mysqli_fetch_array($Rsp))
	{
		$Numero = $Row["numero"] + 1;
	}
	$Insertar = "INSERT INTO sipa_web.recepciones (correlativo,lote,recargo,fecha,rut_prv,guia_despacho,patente,";
	$Insertar.="cod_producto,cod_subproducto,peso_neto,ult_registro,cod_clase,conjunto,humedad,cod_grupo)";
	$Insertar = "$Insertar VALUES('$Numero','$lote_ventana','$recargo','$fecha','$cmbproveedor','$guia','$patente',";
	$Insertar.="'1','17','$peso_recepcion','N','M','".$Conjunto."','N','2')";
	//echo $Insertar;
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

</script>
</head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body class="TablaPrincipal">
<form name="formulario" method="post">
	  <table width="500" border="0" cellspacing="0" cellpadding="2" a align="center" class="TablaDetalle">
		<tr> 
		  <td colspan="9" align="center" class="ColorTabla01">Ingreso De Boleta</td>
		</tr>
		<tr> 
		  <td width="101">Fecha </td>
		  
      <td width="385"><font color="#000000" size="2">
        <select name="dia" size="1" style="font-face:verdana;font-size:10">
          <?php
			if($Proceso=='G' || $Proceso == "M")
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
        <select name="mes" size="1" id="select7" style="FONT-FACE:verdana;FONT-SIZE:10">
          <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='G' || $Proceso == "M")
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
	if($Proceso=='G' || $Proceso == "M")
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
        </font></td>
		<tr> 
		  <td>Proveedor</td>
		  <td>
		  <select name="cmbproveedor">
		  <option value="-1">Seleccionar</option> 
		  <option value="1100-2">Anodos HVL</option> 
		  <option value="77762940-9">Anodos Anglo American</option> 
		  <option value="90132000-4">Anodos Disputada</option> 
		  <?php //echo'<option value="61704005-0">Anodos Teniente</option>'; ?> 
		  </select>	
		  </td>
		</tr>
		<tr> 
		  <td>Guia</td>
		  <td>
		  <input type="text" name="guia" size="8">
		  </td>
		</tr>
		<tr> 
		  <td>Patente</td>
		  <td>
		  <input type="text" name="patente" size="8"><strong>&nbsp;&nbsp;Formato Ej: EH-2134 � HNBS-99</strong>
		  </td>
		</tr>
		<tr> 
		  <td>Lote Ventana</td>
		  <td>
		  <input type="text" name="lote_ventana" size="8">
		  </td>
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
		  <input type="text" name="peso_recepcion" size="8"><strong>&nbsp;&nbsp;Formato Ej: 21520</strong>
		  </td>
		</tr>
	  </table>
	  <br>
	  <table width="500" border="1" cellspacing="0" cellpadding="2" a align="center" class="TablaDetalle">
		<tr> 
		  <td colspan="9" align="center">
		  <input type="button" name="guardar" value="Guardar" style="width:70" onClick="guardar_datos()">
		  <input type="button" name="salir" value="Salir" style="width:70" onClick="self.close()">
		  </td>
		</tr>
	  </table>	  
</form>
</body>
</html>
