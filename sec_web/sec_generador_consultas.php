<?php
//include("../principal/conectar_sec_web.php");
$CodigoDeSistema = 3;
$CodigoDePantalla = 8;
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">

<script language="JavaScript">
function Ejecutar_Web()
{ 
	var f = formulario;	
	switch  (f.cmbconsulta.value)
	{
		case "-1":
			alert("Debe Escoger Tipo de Consulta");
			f.cmbconsulta.focus();
			return;
			break;
		case "1":
			f.action = "sec_con_inf_guias_despacho.php";
			f.submit();
			break;
		case "2":
			f.action = "sec_con_inf_resumen_tot_emb.php";
			f.submit();
			break;
		case "3":
			f.action = "sec_con_inf_pesaje_prod.php";
			f.submit();
			break;
		case "4":
			f.action = "sec_con_resumen_pesaje_prod.php";
			f.submit();
			break;
		case "5":
			f.action = "sec_con_inf_boletas_cortes.php";
			f.submit();
			break;
		case "6":
			f.action = "sec_con_inf_grupos_paquetes.php";
			f.submit();
			break;
		case "7":
			f.action = "sec_con_inf_pesaje_paquetes_emb.php";
			f.submit();
			break;
		case "8":
			f.action = "sec_con_inf_grupo_cuba_por_calidad.php";
			f.submit();
			break;
		case "9":
			f.action = "sec_con_num_solicitud.php";
			f.submit();
			break;	
	}
}

function Ejecutar_Excel()
{ 
	var f = formulario;
}
function Recarga()
{ 
	var f = formulario;
	f.action ="sec_generador_consultas.php";
	f.submit();
}
function Salir()
{
	var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
	f.submit();
}

</script>
</head>

<body leftmargin="0" topmargin="2">
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>  
<table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
  <tr>
  	  <td height="312" align="center" valign="top" > 
        <table width="439" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
          <tr> 
            <td width="105"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Tipo Listado</td>
            <td width="323"><SELECT name="cmbconsulta" style="width:300" onChange="Recarga();">
			<?php
				echo "<option value='-1'>Seleccionar</option>\n";
				if ($cmbconsulta == 1)
					echo "<option SELECTed value='1' SELECTed>Informe Gu�as De Despacho</option>";
				else
					echo "<option value='1' SELECTed>Informe Gu�as De Despacho</option>";
				if ($cmbconsulta == 2)
					echo "<option SELECTed value='2'>Resumen Totales Embarque</option>";
				else
					echo "<option value='2'>Resumen Totales Embarque</option>";
				if ($cmbconsulta == 3)
					echo "<option SELECTed value='3'>Informe de Pesaje de Produccion</option>";
				else
					echo "<option value='3'>Informe de Pesaje de Produccion</option>";
				if ($cmbconsulta == 4)
					echo "<option SELECTed value='4'>Resumen de Pesaje de Produccion</option>";
				else
					echo "<option value='4'>Resumen de Pesaje de Produccion</option>";
				if ($cmbconsulta == 5)
					echo "<option SELECTed value='5'>Informe Digitacion Boletes de Cortes</option>";
				else
					echo "<option value='5'>Informe Digitacion Boletes de Cortes</option>";
				if ($cmbconsulta == 6)
					echo "<option SELECTed value='6'>Informe de Grupos de Paquetes</option>";
				else
					echo "<option value='6'>Informe de Grupos de Paquetes</option>";
				if ($cmbconsulta == 7)
					echo "<option SELECTed value='7'>Informe de Pesaje Paquetes de Embarque</option>";
				else
					echo "<option value='7'>Informe de Pesaje Paquetes de Embarque</option>";
				if ($cmbconsulta == 8)
					echo "<option SELECTed value='8'>Informe de Grupo Cuba por Calidad Quimica</option>";
				else
					echo "<option value='8'>Informe de Grupo Cuba por Calidad Quimica</option>";
				if ($cmbconsulta == 9)
					echo "<option SELECTed value='9'>Consulta por Numero de Solicitud</option>";											
				else
					echo "<option value='9'>Consulta por Numero de Solicitud</option>";											
		    ?></SELECT>	
			</td>        
		  </tr>
		</table>
		<br>
        <table width="730" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
          <?php		
	if ($cmbconsulta == "8")
	{
		echo "<tr class='TablaInterior'>\n";
		echo "<td width='78'>Producto</td>\n";
		echo "<td width='263'><SELECT name='Producto' style='width:250px;' onChange='Recarga()'>\n";     
		echo "<option SELECTed value='S'>Seleccionar</option>\n";
		$Consulta = "SELECT * from proyecto_modernizacion.productos order by descripcion";     
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))                   
		{
			if ($Fila["cod_producto"] == $Producto)
				echo "<option SELECTed value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>\n";
			else
				echo "<option value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>\n";
		}
		echo "</SELECT></td>\n";
		echo "<td width='99'>SubProducto</td>\n";
		echo "<td width='241'><SELECT name='SubProducto' style='width:250px;' onChange='Recarga()'>\n";    
		echo "<option SELECTed value='S'>Seleccionar</option>\n";
		$Consulta = "SELECT * from proyecto_modernizacion.subproducto where cod_producto = '".$Producto."' order by descripcion";     
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))                   
		{
			if ($Fila["cod_subproducto"] == $SubProducto)
				echo "<option SELECTed value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>\n";
			else
				echo "<option value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>\n";
		}        
		echo "</SELECT></td>\n";
		echo "</tr>\n";
	}
	if ($cmbconsulta == "9")
	{
		echo "<tr>\n";
		echo "<td>Nro. Solicitud:</td>\n";
		echo "<td><input name='NumSolicitud' size='10' type='text' value='".$NumSolicitud."'></td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>          
          <tr> 
            <td>Fecha Inicio:</td>
            <td><SELECT name="DiaIni" style="width:50px;">
                <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
              </SELECT> <SELECT name="MesIni" style="width:90px;">
                <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
              </SELECT> <SELECT name="AnoIni" style="width:60px;">
                <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
              </SELECT></td>
            <td>Fecha Termino:</td>
            <td><SELECT name="DiaFin" style="width:50px;">
                <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
              </SELECT> <SELECT name="MesFin" style="width:90px;">
                <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
              </SELECT> <SELECT name="AnoFin" style="width:60px;">
                <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
              </SELECT></td>
          </tr>
        </table> 
        <p>&nbsp;</p>
        <p><br>
        </p>
        <table width="700" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
		  <tr> 
            <td><div align="center">
                <input name="ejecutar_web" type="button"  value="Listar Web" style="width:80" onClick="Ejecutar_Web();">
                <input name="ejecutar_excel" type="button" disabled value="Listar Excel" style="width:80" onClick="Ejecutar_Excel();">
                <input name="salir" type="button" style="width:70" onClick="Salir();" value="Salir">
              </div></td>
          </tr>
        </table>
     </td>
  </tr>
</table>
 <?php include("../principal/pie_pagina.php")?>  
		
</form>
</body>
</html>
