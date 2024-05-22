<?php
include ("../principal/conectar_principal.php");

$CodigoDeSistema = 99;
$CodigoDePantalla = 13;


$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$error     = isset($_REQUEST["error"])?$_REQUEST["error"]:"";
$mensaje   = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";
$CCosto    = isset($_REQUEST["CCosto"])?$_REQUEST["CCosto"]:"";
$Descripcion = isset($_REQUEST["Descripcion"])?$_REQUEST["Descripcion"]:"";
$MostrarCal  = isset($_REQUEST["MostrarCal"])?$_REQUEST["MostrarCal"]:"";
$MostrarFrx  = isset($_REQUEST["MostrarFrx"])?$_REQUEST["MostrarFrx"]:"";
$CmbArea     = isset($_REQUEST["CmbArea"])?$_REQUEST["CmbArea"]:"";

  	if($Proceso=="B")
  	{
  		$consulta="select * from proyecto_modernizacion.centro_costo where centro_costo = '".strtoupper($CCosto)."'";
		//echo "----".$consulta;
		$respue=mysqli_query($link, $consulta);
		if ($Row1=mysqli_fetch_array($respue))
		{
			$Descripcion = $Row1["DESCRIPCION"];
			$MostrarCal = $Row1["MOSTRAR_CALIDAD"];
			$MostrarFrx = $Row1["MOSTRAR_FRX"];
			$CmbArea  = $Row1["cod_area"];
			
		}
	}	
?>
<html>

<Script language="JavaScript">
function Recarga()
{
	var Frm=document.FrmIngCosto;
	Frm.action="actualiza_costos.php";		
	Frm.submit();
}
function Procesa(opc)
{
	var Frm=document.FrmIngCosto;
	switch (opc)
	{
		case "A":
				if (confirm("Archivo de costos Excel  .csv debe existir"))
				{
					Frm.action="actualiza_costos01.php?Proceso=A";
					Frm.submit();
					break;
				}
		case "S":
				Frm.action="sistemas_usuario.php?CodSistema=99";		
				Frm.submit();
				break;
		case "B":
				Frm.action="actualiza_costos.php?Proceso=B";
				Frm.submit();
				break;
		case "G":
				if (Frm.CCosto.value=="" || Frm.CCosto.value==0)
				{
					alert ("centro de costo debe ingresarse");
					Frm.CCosto.focus();
				}
				if (Frm.Descripcion.value=="")
				{
					alert ("Falta descripcion del Centro de Costo");
					Frm.Descripcion.focus();
				}	
				Frm.action="actualiza_costos01.php?Proceso=G";		
				Frm.submit();
				break;
		case "E":
				if (Frm.CCosto.value=="" || Frm.CCosto.value==0)
				{
					alert ("Debe ingresar Centro de Costo")
					Frm.CCosto.focus();
				}
				Frm.action="actualiza_costos01.php?Proceso=E";		
				Frm.submit();
				break;		
	}
}
function Cambia(opcion)
{
	var Frm=document.FrmIngCosto;
	switch (opcion)
	{
		case "D":
			var paso = Frm.Descripcion.value;
			Frm.Descripcion.value = paso.toUpperCase();
			Frm.MostrarCal.focus();
		case "MC":
			var paso = Frm.MostrarCal.value;
			Frm.MostrarCal.value = paso.toUpperCase();
			Frm.MostrarFrx.focus();
		case "MF":
			var paso = Frm.MostraFrx.value;
			Frm.MostrarFrx.value = paso.toUpperCase();
			Frm.CmbArea.focus();

	}
}
</script>
<title>Actualizacion Centros De Costos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngCosto" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  	<table width="775" border="1" cellpadding="1" cellspacing="0" class="TablaPrincipal" left="5">
		<tr class='ColorTabla01'> 
			<td width='80' align='center'>Centro Costos</td>
			<td width='280' align='center'>Descripci&oacute;n</td>
			<td width='80' align='center'>Mostrar Calidad</td>
			<td width='70' align='center'>Mostrar Frx</td>
			<td width='150' align='center'>Codigo Area</td>
		</tr>
		<tr>
			<td align="center"><input name="CCosto" type="text" size="6"  value="<?php echo strtoupper($CCosto); ?>" onChange="Procesa('B')"></td>
        	<td align="center"><input name="Descripcion"  type="text" size="50" value="<?php echo $Descripcion; ?>" onChange="Cambia('D')"></td>
			<td align="center"><input  name="MostrarCal" type="text" size="2"  value="<?php echo $MostrarCal; ?>"  onChange="Cambia('MC')"></td>
			<td align="center"><input name="MostrarFrx" type="text" size="2"  value="<?php echo $MostrarFrx; ?>" onChange="Cambia('MF')"></td>
        	<td align="center" width="150">
			<?php 
				echo "<select name='CmbArea'  onchange=Recarga()>";
				echo "<option value='-1'>&nbsp;SELECCIONAR&nbsp;</option>";
				$Consulta="SELECT * FROM proyecto_modernizacion.areas ORDER BY AREA";
				$Resultado = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resultado))
				{
					if ($CmbArea==$Fila["COD_AREA"])
						{
							echo "<option value='".$Fila["COD_AREA"]."' selected>".strtoupper($Fila["AREA"])."</option>";
						}
						else
						{
							echo "<option value='".$Fila["COD_AREA"]."'>".strtoupper($Fila["AREA"])."</option>";
						}	
				}
				echo "</select>";
			?>
			</td>
		</tr>
	<?php
	   $error=0;
		if ($error==1)
		{ 	
			echo '<tr> <td width="300"><input type="text" value="'.strtoupper($mensaje).'"></td></tr>';
		}	
 			?>

	<tr>
		<table width="775" bgcolor="#CCCCCC" align="left" border="0" cellspacing="3" cellpading="0">
 	  	    <tr>
			   	<td colspan="6" width="740" align="center">
			   		<input type="button" name="Actualiza" value="Act. de Archivo"  onClick="Procesa('A')">
	        		<input type="button"  value="Grabar" onClick="Procesa('G')">
	  	    		<input type="button" name="Eliminar" value="Elimina"  onClick="Procesa('E')">
            		<input type="button"  name="Finalizar"   value="Finalizar"  onClick="Procesa('S')"></td>
			</tr> 
			<tr>
				<td>
	 			 <?php include("../principal/pie_pagina.php"); ?>
				</td>
			</tr>
		</table>
	</tr>
</table>

</form>

</body>
</html>



    
    



