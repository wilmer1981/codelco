<?php
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 80;
	include("../principal/conectar_principal.php");
	//echo "PROD: ".$SubProducto2."<br>";
	//echo "PRV: ".$Proveedor2."<br>";
	
if($G=='s')
{
	$Dato=explode('::',$vs);
	$Val1=$Dato[0];
	$Val2=$Dato[1];
	$Actualiza="UPDATE proyecto_modernizacion.clase set valor1='".$Val1."',valor2='".$Val2."' where cod_clase='1012'";
	mysqli_query($link, $Actualiza);
	$MSJ='Datos Modificados';	
}	
$Consulta="select valor1,valor2 from proyecto_modernizacion.clase where cod_clase='1012'";
$R=mysqli_query($link, $Consulta);
$F=mysqli_fetch_assoc($R);
$CmbCCosto=$F[valor1];
$CmbAreasProceso=$F[valor2];
?>
<html>
<head>
<title>CAL- Asig. De �rea Y Cc Para Sa Auto.</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=1&CodPantalla=10&Nivel=1";
}
function Proceso(Opc)
{	
	var f = document.frmPrincipal;
	switch(Opc)
	{
		case "G":
			if(f.CmbCCosto.value=='-1')
			{
				alert('Debe seleccionar Centro de Costo');
				f.CmbCCosto.focus();
				return;
			}
			if(f.CmbAreasProceso.value=='-1')
			{
				alert('Debe seleccionar �rea');
				f.CmbAreasProceso.focus();
				return;
			}
			f.action = "cal_asig_area_cc_sa.php?G=s&vs="+f.CmbCCosto.value+"::"+f.CmbAreasProceso.value;
		break;
	}
	f.submit(); 
}
function Func_msj(msj)
{
	if(msj!='')
		alert(msj);	
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body onLoad="Func_msj('<?php echo $MSJ;?>')">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="TipoBusqueda" value="<?php echo $TipoBusq; ?>">
<?php include("../principal/encabezado.php") ?>
  <table width="770"  height="313"border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" align="center" valign="top"><br><br>
	    <table width="527" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
	      <tr>
	        <td colspan="3" class="ColorTabla01">Asignaci&oacute;n De �rea y CC Para SA Autom�tica</td>
          </tr>
          <tr>  
	        <td width="40">C.C.</td>
	        <td width="398"><strong>
	          <select name="CmbCCosto" style="width:330">
	            <option value ='-1' selected>Seleccionar</option>
	            <?php
				$Consulta = "select centro_costo,descripcion from proyecto_modernizacion.centro_costo where mostrar_calidad='S' order by centro_costo";
				$Respuesta = mysql_query ($Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbCCosto == $Fila[centro_costo])
						echo "<option value = '".$Fila[centro_costo]."' selected>".$Fila[centro_costo]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
					else
						echo "<option value = '".$Fila[centro_costo]."'>".$Fila[centro_costo]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
				}
				echo "<option value ='-1'>____________________________________________________</option>\n";
				$Consulta = "select centro_costo,descripcion from proyecto_modernizacion.centro_costo where mostrar_calidad<>'S' order by centro_costo";
				$Respuesta = mysql_query ($Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbCCosto == $Fila[centro_costo])
						echo "<option value = '".$Fila[centro_costo]."' selected>".$Fila[centro_costo]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
					else
						echo "<option value = '".$Fila[centro_costo]."'>".$Fila[centro_costo]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
				}
			?>
              </select>
	        </strong></td>
	        <td width="68" rowspan="2"><strong>
	          <input name="BtnOk2" type="button" id="BtnOk2" value="Guardar" style='width:67' onClick="Proceso('G');">
	          <input name='BtnSalir' type='button' value='Salir' style='width:67' onClick='Salir();'>
	        </strong></td>
          </tr>
	      <tr>
	        <td>&Aacute;rea</td>
	        <td><strong>
	          <select name="CmbAreasProceso" style="width:330">
	            <option value ='-1' selected>Seleccionar</option>
	            \n;
                
	            <?php
			$Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase = 3 order by valor_subclase1 ";
			$Respuesta = mysql_query ($Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbAreasProceso == $Fila["cod_subclase"])
				{
					echo "<option value = '".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 				
				}
				else
				{
					echo "<option value = '".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
				}	
			}
		?>
              </select>
	        </strong></td>
          </tr>
        </table></td>
 </tr>
</table>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
