<?php 	
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}
	if(isset($_REQUEST["Tipo"])){
		$Tipo = $_REQUEST["Tipo"];
	}else{
		$Tipo = "";
	}

	if(isset($_REQUEST["Envio"])){
		$Envio = $_REQUEST["Envio"];
	}else{
		$Envio = "";
	}
	if(isset($_REQUEST["CmbTipoEmb"])){
		$CmbTipoEmb = $_REQUEST["CmbTipoEmb"];
	}else{
		$CmbTipoEmb = "";
	} 
	
	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$corr_enm=$Datos2[0];
		$cod_bulto=$Datos2[1];				
		$num_bulto=$Datos2[2];
		$fecha_embarque=$Datos2[3];
		$fecha_programacion=$Datos2[4];
		$bulto_peso=$Datos2[5];
		$bulto_paquetes=$Datos2[6];
		$cod_marca=$Datos2[7];
		$cod_producto=$Datos2[8];
		$cod_subproducto=$Datos2[9];
		$cod_cliente=$Datos2[10];
	}
		
?>
<html>
<head>
<script language="JavaScript">
function Grabar()
{
	var Frm=document.FrmProceso;
	if (Frm.NumEnvio.value=="")
	{
		alert("Debe Ingresar Num.Envio");
		return;
	}
	if (Frm.CmbTipoEmb.value=="-1")
	{
		alert("Debe Seleccionar Tipo Embarque");
		Frm.CmbTipoEmb.focus();
		return;
	}
	if (Frm.CmbTipoEmb.value!="T")
	{
	
	Frm.action="sec_confirmacion_num_envio_codelco01.php?Envio="+Frm.NumEnvio.value+"&TipoEmbarque="+Frm.CmbTipoEmb.value+"&CodNave="+Frm.CmbNave.value+"&CodPuerto="+Frm.CmbPuerto.value+"&Tipo="+Frm.TipoAux.value+"&Proceso=G";
		Frm.submit();
	}
	else
	{
		var Nave="";  
		var Puerto="";
		//alert (Frm.NumOrden.value);
		Frm.action="sec_confirmacion_num_envio_codelco01.php?Envio="+Frm.NumEnvio.value+"&TipoEmbarque="+Frm.CmbTipoEmb.value+"&CodNave="+Nave+"&CodPuerto="+Puerto+"&Tipo="+Frm.TipoAux.value+"&NumOrden="+Frm.NumOrden.value+"&Proceso=G";
		//Frm.action="sec_confirmacion_num_envio_codelco01.php?Envio="+Frm.NumEnvio.value+"&TipoEmbarque="+Frm.CmbTipoEmb.value+"&CodNave="+Nave+"&CodPuerto="+Puerto+"&Tipo="+Frm.TipoAux.value+"&Proceso=G";

		Frm.submit();
	}
}
function Salir()
{
	window.close();
}
function Recarga(Envio,Valor)//#envio y valor=string de checkbox
{
	var Frm=document.FrmProceso;
	Frm.action="sec_confirmacion_num_envio_codelco_proceso.php?Envio="+Envio+"&CmbTipoEmb="+Frm.CmbTipoEmb.value+"&Valores="+Valor+"&Tipo="+Frm.TipoAux.value;
	Frm.submit();
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body onLoad="document.FrmProceso.NumEnvio.focus()" background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
<input name="ValoresAux" type="text" value="<?php echo $Valores  ?>">
<input name="TipoAux" type="hidden" value="<?php echo $Tipo  ?>">
  <table width="446" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="434"><table width="421" height="114" border="0" >
          <tr> 
            <td width="154">&nbsp;</td>
            <td width="257" align="right"><strong>Fecha:&nbsp;<?php echo date('Y:m:d')?></strong>&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr> 
            <td>Numero Envio</td>
            <td> 
			<?php
			//echo "EE".$Fila["cod_cliente"];
			$Consulta = "select ifnull(max(num_envio),0) as NroMayor from sec_web.embarque_ventana  ";
			$Consulta.=" where YEAR(fecha_envio) = year(now()) and tipo <> 'V'	";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$NumEnvio=$Fila["NroMayor"]+1;
			?>
			<input name="NumEnvio" type="text" id="NumEnvio" size="10" value="<?php echo $NumEnvio; ?>"></td>
          </tr>
          <tr> 
            <td>Tipo Embarque</td>
            <td> <select name='CmbTipoEmb' style='width:90' onChange="Recarga('<?php echo $NumEnvio  ?>','<?php echo $Valores  ?>');">
                <?php
			if ($CmbTipoEmb==-1)
			{
				echo "<option value='-1' selected>Seleccionar</option>";
			}
			if ($CmbTipoEmb=="A")
			{
				echo "<option value='A' selected>Acopio</option>";
			}
			if ($CmbTipoEmb=="E")
			{
				echo "<option value='E' selected>Estiba</option>";
			}
			if($CmbTipoEmb=="T")
			{
				echo"<option value='T'>Terreste</option>";
			}
			echo "<option value='-1'>Seleccionar</option>";
			echo "<option value='A'>Acopio</option>";
			echo "<option value='E'>Estiba</option>";
			echo"<option value='T'>Terreste</option>";
			?>
              </select></td>
          </tr>
		 
		 <?php
		if ($cod_cliente == '45' && $CmbTipoEmb== "T")
		{
		?>		  
			<tr> 
            	<td>N&deg; Orden Compra</td>
          		<td> <input name="NumOrden" type="text" id="NumOrden" size="20" value="<?php echo  $NumOrden; ?>">
              	<strong>(Solo Para Cocesa)</strong></td>
			</tr>
 		<?php
		}
		else
		{
		?>	
			<td> <input name="NumOrden" type="hidden" id="NumOrden" size="20" value="<?php echo  $NumOrden; ?>">
		<?php
		}	
		?>
		  
		<!-- aqui la validacion-->	         
		  <?php
		   if ($CmbTipoEmb!="T")
		   {
			echo "<tr>";
			echo "<td>Puerto</td>";
			echo "<td><select name='CmbPuerto'>";
			$Consulta="select * from sec_web.puertos order by nom_aero_puerto";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbPuerto==$Fila["cod_puerto"])
				{
					echo "<option value='".$Fila["cod_puerto"]."' selected>".$Fila["cod_puerto"]."-".$Fila["nom_aero_puerto"]."</option>";
				}
				else
				{
					echo "<option value='".$Fila["cod_puerto"]."'>".$Fila["cod_puerto"]."-".$Fila["nom_aero_puerto"]."</option>";
				}
			}
		  	echo "</select></td>";
			echo"</tr>";
			echo "<tr>";
			echo"<td>Nave</td>";
			echo "<td><select name='CmbNave'>";
			$Consulta="select * from sec_web.nave order by nombre_nave";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbNave==$Fila["cod_nave"])
				{
					echo "<option value='".$Fila["cod_nave"]."' selected>".$Fila["nombre_nave"]."</option>";
				}
				else
				{
					echo "<option value='".$Fila["cod_nave"]."'>".$Fila["nombre_nave"]."</option>";
				}
			}
			
		   echo"</select></td>";
		   echo"</tr>";
           }
		  
		?>

		<!--hasta aqui la validacion-->
		</table>
        <br>
        <table width="422" border="0">
          <tr> 
            <td  align="center" width="416"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
