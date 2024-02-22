<?php
include("../principal/conectar_rec_web.php");

if($Proceso == "G")
{
	if(strlen($dia) == 1)
		$dia = "0".$dia;

	if(strlen($mes) == 1)
		$mes = "0".$mes;

	$fecha = $ano.'-'.$mes.'-'.$dia;
	
	if (strlen($LoteVentana)==7)
		$LoteVentana = "0".$LoteVentana;
	
	$patente = strtoupper($patente);
	$Recargo = 1;
	$Busqueda ="Select * from sea_web.relaciones where lote_ventana = '".$LoteVentana."' and lote_origen = '".$LoteOrigen."'";
	$resp=mysqli_query($link, $Busqueda);
	if ($Fila=mysqli_fetch_array($resp))
	{
		$Consulta = "SELECT max(recargo) as recargo from sipa_web.recepciones where lote = '".$Fila[lote_ventana]."'";
		$resp1 = mysqli_query($link, $Consulta);
		if ($Fila1=mysqli_fetch_array($resp1))
			$Recargo = $Fila1["recargo"] + 1;
	}
	$Consulta ="Select max(correlativo) as numero from sipa_web.recepciones";
	$Rsp=mysqli_query($link, $Consulta);
	if($Row=mysqli_fetch_array($Rsp))
	{
			$Numero = $Row[numero] + 1;
	}
	$Insertar = "INSERT INTO sipa_web.recepciones (correlativo,lote,recargo,ult_registro,rut_operador,fecha,rut_prv,cod_mina,cod_producto,";
	$Insertar.="cod_subproducto,guia_despacho,patente,cod_clase,activo,estado,cod_grupo, tipo)";
	$Insertar.=" VALUES('".$Numero."','".$LoteVentana."','".$recargo."','N','9999999-9','".$fecha."','61704005-0','06101.0004-2','1','17',";
	$Insertar.=" '".$guia."','".$patente."','M','S','C',2,'A')";
    //echo "sipa".$Insertar;
	mysqli_query($link, $Insertar);

	$Inserta ="Insert into sea_web.recepcion_externa (guia,cod_producto,cod_subproducto,lote_origen,lote_ventana,peso,";
	$Inserta.="peso_recep,piezas,piezas_recep,marca,fecha,fecha_guia) values('".$guia."','17','2','".$LoteOrigen."','".$LoteVentana."',";
	$Inserta.=" '".$peso_recepcion."',0,'".$unidad_recepcion."',0,'".$Marca."','".$fecha."','".$fecha."')";
   // echo "encabezado".$Inserta;
    mysqli_query($link, $Inserta);
	$Atados = $unidad_recepcion / 8;
	$Inserta ="Insert into sea_web.recepcion_externa_detalle (guia,corr,fecha,atados, piezas,lote_origen,marca,peso_bruto,peso_tara,";
	$Inserta.="peso_neto,patente,tipo_ingreso) values('".$guia."',1,'".$fecha."','".$Atados."','".$unidad_recepcion."','".$LoteOrigen."','".$Marca."',";
	$Inserta.="0,0,'".$peso_recepcion."','".$patente."',1)";
   // echo "detalle".$Inserta;
	mysqli_query($link, $Inserta);
			

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

//	if(f.cmbproveedor.value == -1)
//	{
//		alert("Debe Seleccionar Proveedor")
//		f.cmbproveedor.focus();
//		return
//	}

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

	if(f.LoteVentana.value == '')
	{
		alert("Debe Ingresar Nro de Lote")
		f.LoteVentana.focus();
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

	f.action="sea_ing_guia_tte.php?Proceso=G";
	f.submit()
}

</script>
</head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body class="TablaPrincipal">
<form name="formulario" method="post">
	  <table width="500" border="0" cellspacing="0" cellpadding="2" a align="center" class="TablaDetalle">
		<tr> 
		  <td colspan="9" align="center" class="ColorTabla01">Ingreso Manual Guias Teniente </td>
		</tr>
		<tr> 
		  <td width="101">Fecha </td>
		  
      <td width="385"><font color="#000000" size="2">
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
        <SELECT name="mes" size="1" id="SELECT7" style="FONT-FACE:verdana;FONT-SIZE:10">
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
		
		<tr> 
		  <td height="25">Guia</td>
		  <td><p><input type="text" name="guia" size="8">
		    </p>
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
		  <input type="text" name="LoteVentana" size="8">
		  </td>
		</tr>
		<tr> 
		  <td>Recargo</td>
		  <td>
		  <input type="text" name="recargo" size="8">
		  </td>
		</tr>
		<tr>
		  <td height="24">Lote Origen </td>
		  <td><input type="text" name="LoteOrigen" size="8"></td>
	    </tr>
		<tr>
		  <td height="25">Marca</td>
		  <td><font color="#000000" size="2">
		    <input type="text" name="Marca" size="8">
</font></td>
	    </tr>
		<tr>
			<td>Unidades</td>
			<td><input type="text" name="unidad_recepcion" size="8"></td>
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
