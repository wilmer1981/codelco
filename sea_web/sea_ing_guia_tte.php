<?php
include("../principal/conectar_rec_web.php");

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = '';
}
if(isset($_REQUEST["subprod"])) {
	$subprod = $_REQUEST["subprod"];
}else{
	$subprod = '';
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
if(isset($_REQUEST["proveedor"])) {
	$proveedor = $_REQUEST["proveedor"];
}else{
	$proveedor = "";
}
if(isset($_REQUEST["guia"])) {
	$guia = $_REQUEST["guia"];
}else{
	$guia = "";
}
if(isset($_REQUEST["patente"])) {
	$patente = $_REQUEST["patente"];
}else{
	$patente = "";
}
if(isset($_REQUEST["LoteVentana"])) {
	$LoteVentana = $_REQUEST["LoteVentana"];
}else{
	$LoteVentana = "";
}
if(isset($_REQUEST["recargo"])) {
	$recargo = $_REQUEST["recargo"];
}else{
	$recargo = "";
}
if(isset($_REQUEST["LoteOrigen"])) {
	$LoteOrigen = $_REQUEST["LoteOrigen"];
}else{
	$LoteOrigen = "";
}
if(isset($_REQUEST["Marca"])) {
	$Marca = $_REQUEST["Marca"];
}else{
	$Marca = "";
}
if(isset($_REQUEST["unidad_recepcion"])) {
	$unidad_recepcion = $_REQUEST["unidad_recepcion"];
}else{
	$unidad_recepcion = "";
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
	$tipo = substr($subprod,0,1);
	$fecha = $ano.'-'.$mes.'-'.$dia;

	//echo "TIPO:".$tipo;
	//exit();

	if (strlen($LoteVentana)==7)
		$LoteVentana = "0".$LoteVentana;
	if ($tipo=='A')
	{
		$patente = strtoupper($patente);
		$Recargo = 1;
		$Busqueda ="Select * from sea_web.relaciones where lote_ventana = '".$LoteVentana."' and lote_origen = '".$LoteOrigen."'";
		$resp=mysqli_query($link, $Busqueda);
		if ($Fila=mysqli_fetch_array($resp))
		{
			$Consulta = "select max(recargo) as recargo from sipa_web.recepciones where lote = '".$Fila["lote_ventana"]."'";
			$resp1 = mysqli_query($link, $Consulta);
			if ($Fila1=mysqli_fetch_array($resp1))
				$Recargo = $Fila1["recargo"] + 1;
		}
		$Consulta ="Select max(correlativo) as numero from sipa_web.recepciones";
		$Rsp=mysqli_query($link, $Consulta);
		if($Row=mysqli_fetch_array($Rsp))
		{
				$Numero = $Row["numero"] + 1;
		}
		$Insertar = "INSERT INTO sipa_web.recepciones (correlativo,lote,recargo,ult_registro,rut_operador,fecha,rut_prv,cod_mina,cod_producto,";
		$Insertar.="cod_subproducto,guia_despacho,patente,cod_clase,activo,estado,cod_grupo, tipo)";
		$Insertar.=" VALUES('".$Numero."','".$LoteVentana."','".$recargo."','N','9999999-9','".$fecha."','61704005-0','06101.0004-2','1','17',";
		$Insertar.=" '".$guia."','".$patente."','M','S','C',2,'A')";
    	//echo "sipa".$Insertar;
		mysqli_query($link, $Insertar);

		$Inserta ="INSERT into sea_web.recepcion_externa (guia,cod_producto,cod_subproducto,lote_origen,lote_ventana,peso,peso_recep,piezas,piezas_recep,marca,fecha,fecha_guia";
		$Inserta.=" values('".$guia."','17','2','".$LoteOrigen."','".$LoteVentana."','".$peso_recepcion."','".$peso_recepcion."','".$unidad_recepcion."',0,'".$Marca."','".$fecha."','".$fecha."')";
   		// echo "encabezado".$Inserta;
    	mysqli_query($link, $Inserta);
		$Atados = $unidad_recepcion / 8;
		$Inserta ="INSERT into sea_web.recepcion_externa_detalle (guia,corr,fecha,atados, piezas,lote_origen,marca,peso_bruto,peso_tara,";
		$Inserta.="peso_neto,patente,tipo_ingreso) values('".$guia."',1,'".$fecha."','".$Atados."','".$unidad_recepcion."','".$LoteOrigen."','".$Marca."',";
		$Inserta.="0,0,'".$peso_recepcion."','".$patente."',1)";
   		// echo "detalle".$Inserta;
		mysqli_query($link, $Inserta);
	}
	if ($tipo=='B')
	{
		$patente = strtoupper($patente);
		$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 1 AND cod_producto = 16";
		$consulta = $consulta." AND cod_subproducto = '".$subprod."' ";
		$Respuesta=mysqli_query($link, $consulta);
		if ($Row=mysqli_fetch_array($Respuesta))
		{
			$flujo = $Row["flujo"];
		}
		else
		{
			$flujo = 0;
		}
		$Hornada = 0;
		$Busqueda ="Select * from sea_web.relaciones where lote_ventana = '".$LoteVentana."'"; //and lote_origen = '".$LoteOrigen."'";
		$resp=mysqli_query($link, $Busqueda);
		if ($Fila=mysqli_fetch_array($resp))
		{
			$Hornada = $Fila["hornada_ventana"];
		}
		if ($Hornada==0)
		{
			$LoteAux = substr($LoteVentana,0,4)."%";
			$BuscaHor = "Select max(hornada_ventana) as hornada from sea_web.relaciones where cod_origen = '4' and ";
			$BuscaHor.=" lote_ventana like '".$LoteAux."'";
			echo "hola".$BuscaHor;
			$Busca = mysqli_query($link, $BuscaHor);
			if ($Rhor=mysqli_fetch_array($Busca))
				$Hornada = $Rhor["hornada"] + 1;
			if ($Hornada==0 || $Hornada==1)
				$Hornada = "20".substr($LoteVentana,0,4)."9001";
			$Insertar="INSERT INTO sea_web.relaciones (cod_origen,lote_ventana,lote_origen,hornada_externa,hornada_ventana, ";
			$Insertar.="marca,ciclo,estado_lote) values ('4','".$LoteVentana."','".$LoteOrigen."','0','".$Hornada."','".$Marca."','3','0')";
			echo "hola".$Insertar;
			mysqli_query($link, $Insertar);
		}
			
		$Consulta ="SELECT max(correlativo) as numero from sipa_web.recepciones";
		$Rsp=mysqli_query($link, $Consulta);
		if($Row=mysqli_fetch_array($Rsp))
		{
				$Numero = $Row["numero"] + 1;
		}
		$Insertar = "INSERT INTO sipa_web.recepciones (correlativo,lote,recargo,ult_registro,rut_operador,fecha,peso_neto,rut_prv,cod_mina,cod_producto,";
		$Insertar.="cod_subproducto,guia_despacho,patente,cod_clase,activo,estado,cod_grupo, tipo)";
		$Insertar.=" VALUES('".$Numero."','".$LoteVentana."','".$recargo."','N','9999999-9','".$fecha."','".$peso_recepcion."','61704005-0','06101.0004-2','1','16',";
		$Insertar.=" '".$guia."','".$patente."','M','S','C',2,'A')";
		echo "hola".$Insertar;
		mysqli_query($link, $Insertar);
	
		$Consulta = "SELECT * from sea_web.movimientos where tipo_movimiento = '1' and cod_producto = '16' and ";
		$Consulta.=" cod_subproducto = '4' and hornada = '".$Hornada."' and fecha_movimiento = '".$fecha."'";
		$RspH=mysqli_query($link, $Consulta);
		if ($Row2=mysqli_fetch_array($RspH))
		{
			$actualiza ="UPDATE sea_web.movimientos set peso = peso + '".$peso_recepcion."', unidades = unidades + '".$unidad_recepcion."' ";
			$actualiza.=" where tipo_movimiento = '1' and cod_producto = '16' and  cod_subproducto = '4' and hornada = '".$Hornada."'";
			$actualiza.=" and fecha_movimiento = '".$fecha."'";
			//echo "dos".$actualiza;
			mysqli_query($link, $actualiza);
		}
		else
		{
			$fechaHora = $fecha." 23:50:50";
			$Inserta="INSERT into sea_web.movimientos (tipo_movimiento, cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,";
			$Inserta.="campo1,campo2,unidades,flujo,peso,estado,lote_ventana,hora) values ('1','16','4','".$Hornada."',0,'".$fecha."',";
			$Inserta.=" '".$guia."', '".$patente."','".$unidad_recepcion."','000','".$peso_recepcion."','0','".$LoteVentana."','".$fechaHora."')";
			echo "tres".$Inserta;
			mysqli_query($link, $Inserta);
		}
		$ConsultaH="select * from sea_web.hornadas where cod_producto = '16' and cod_subproducto ='4' and hornada_ventana = '".$Hornada."'";
		$resph=mysqli_query($link, $ConsultaH);
		if ($FilaH=mysqli_fetch_array($resph))
		{
			$ActualizaH="UPDATE sea_web.hornadas set unidades = unidades + '".$unidad_recepcion."', peso_unidades = peso_unidades + '".$peso_recepcion."'";
			$ActualizaH.=" where cod_producto = '16' and cod_subproducto ='4' and hornada_ventana = '".$Hornada."'";
			//echo "cuatro".$Actualiza;
			mysqli_query($link, $ActualizaH);
		}
		else
		{
			$InsertaH="insert into sea_web.hornadas (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades,analizada,estado)";
			$InsertaH.=" values('16','4','".$Hornada."','".$unidad_recepcion."','".$peso_recepcion."','N','1')";
			//echo "cinco".$InsertaH;
			mysqli_query($link, $InsertaH);
		}
	}


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

	f.subprod.value = f.proveedor.value;

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
	
	f.action="sea_ing_guia_tte.php?Proceso=G&subprod=" + f.subprod.value;
	f.submit()
}
function Recarga()
{
		var f = document.formulario;
		f.subprod.value = f.proveedor.value;
		//f.action="sea_ing_guia_tte.php?Proceso=V&subproducto="+ f.subprod.value;
		f.action="sea_ing_guia_tte.php?Proceso=V&subprod="+ f.subprod.value;
        f.submit();
  		
}

</script>
</head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body class="TablaPrincipal">
<form name="formulario" method="post">
	  <input name="subprod" type="hidden" value="subprod">
 	  
	  <table width="500" border="0" cellspacing="0" cellpadding="2" a align="center" class="TablaDetalle">
		<tr> 
		  <td colspan="9" align="center" class="ColorTabla01">Ingreso Manual Guias Teniente       &nbsp;&nbsp;  (Version 2)</td>
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
		
	<?php //desde aquiiiiiii  ?>
	
	        <tr> 
            <td>Anodo-Blister</td>
            <td>
              <?php
			   echo'<select name="proveedor" onChange="Recarga()">';
			   echo'<option value="-1" seleted>Seleccionar</option>';

				$subprod = $proveedor;
               if($proveedor == "A-61704005-0")
			   	echo'<option value="A-61704005-0" selected>ANODOS TENIENTE</option>';		   
               else
			   	echo'<option value="A-61704005-0">ANODOS TENIENTE</option>';		   

			    if($proveedor == "B-61704005-0")
			   	echo'<option value="B-61704005-0" selected>BLISTER TENIENTE</option>';		   
			   else
			   	echo'<option value="B-61704005-0">BLISTER TENIENTE</option>';		
				
		      ?>
			</select>
			</td></tr>

	
	<?php  //hasta aca.... ?>
	

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
		<?php
			$valbli = substr($proveedor,0,1);
			echo '<input type="hidden" name="valbli" value="'.$valbli.'">';
		?>
		<tr> 
		  <td>Recargo</td>
		  <td>
			<input type="text" name="recargo" size="8" >
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
