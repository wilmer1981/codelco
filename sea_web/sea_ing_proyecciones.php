<?php
include("../principal/conectar_sea_web.php");
$CodigoDeSistema=2;
if($Proceso == 'E')
{
	$Fecha = $Ano.'-'.$Mes.'-01';
	$Eliminar = "DELETE FROM sea_web.inf_prod_inter WHERE fecha = '$Fecha'";	
	mysqli_query($link, $Eliminar);
	$Proceso = "B";
}

if($Proceso == 'B')
{
	$Fecha = $Ano.'-'.$Mes.'-01';
	$Consulta = "SELECT * FROM sea_web.inf_prod_inter WHERE fecha = '$Fecha' AND Tipo = 'P'";
	$rs = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($rs);

	if($Fila[Vent] == 0)
		$Vent = '';		
	else
		$Vent = $Fila[Vent];	

	if($Fila[HMadres] == 0)
		$HMadres = '';		
	else
		$HMadres = $Fila[HMadres];	

	if($Fila[Teniente] == 0)
		$Teniente = '';		
	else
		$Teniente = $Fila[Teniente];	

	if($Fila[FHVL] == 0)
		$FHVL = '';		
	else
		$FHVL = $Fila[FHVL];	

	if($Fila[Disputada] == 0)
		$Disputada = '';		
	else
		$Disputada = $Fila[Disputada];	

	if($Fila[Restos] == 0)
		$Restos = '';		
	else	
		$Restos = $Fila[Restos];
		
}
?>
<html>
<head>
<title>Ingreso de Proyecciones</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opc)
{
var f = document.FrmPrincipal;

	switch(opc)
	{
		case "G": 
			f.action="sea_ing_proyecciones01.php?Proceso=G";
			f.submit();
			break;		
		case "B": 
			f.action="sea_ing_proyecciones.php?Proceso=B";
			f.submit();
			break;		
		case "E": 
			f.action="sea_ing_proyecciones.php?Proceso=E";
			f.submit();
			break;		
		case "S":
			document.location = "../principal/sistemas_usuario.php?CodSistema=2&Nivel=1&CodPantalla=45";										 	
			break;
	}

}
</script>
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<form name="FrmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
<table width="770" height="330" border="0" class="TablaPrincipal"> 
<tr> 
	<td align="center" valign="top">
	  <p><b>P R O Y E C C I O N &nbsp;&nbsp;D E &nbsp;&nbsp;R E C E P C I O N E S</b></p>
        <table width="320" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
		<tr>
		    <td width="84" align="center">Periodo</td>
		    <td width="229"><SELECT name="Mes" style="width:90px;">
                <?php
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($Mes == $i)
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
              </SELECT> <SELECT name="Ano" style="width:60px;">
                <?php
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($Ano))
					{
						if ($Ano == $i)
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
              </SELECT>
              <input type="button" name="BtnBuscar" value="Buscar" style="width:70px" onClick="Proceso('B');"></td>
		</tr>
		<tr class="ColorTabla01">
		  <td width="84" align="center">ANODOS</td>
		  <td width="229" align="center">PROYECCION</td>
		</tr>
		<tr>
		  <td>VENT. CTE</td>
		  <td><input type="text" name="Vent" style="width:70px" value="<?php echo $Vent; ?>"></td>
		</tr>
		<tr>
		  <td>H. MADRES</td>
		  <td><input type="text" name="HMadres" style="width:70px" value="<?php echo $HMadres; ?>"></td>
		</tr>
		<tr>
		  <td>TENIENTE</td>
		  <td><input type="text" name="Teniente" style="width:70px" value="<?php echo $Teniente; ?>"></td>
		</tr>
		<tr>
		  <td>FHVL CTE.</td>
		  <td><input type="text" name="FHVL" style="width:70px" value="<?php echo $FHVL; ?>"></td>
		</tr>
		<tr>
		    <td>ANGLO AMERICAN SA</td>
		  <td><input type="text" name="Disputada" style="width:70px" value="<?php echo $Disputada; ?>"></td>
		</tr>
		<tr>
		  <td>RESTOS</td>
		  <td><input type="text" name="Restos" style="width:70px" value="<?php echo $Restos; ?>"></td>
		</tr>
	  </table>
	  <br>
	  <table width="320" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
		<tr>
		  <td width="319" align="center">
		  <input type="button" name="BtnGrabar" value="Grabar" style="width:70px" onClick="Proceso('G');">
		  <input type="button" name="BtnEliminar" value="Eliminar" style="width:70px" onClick="Proceso('E');">
		  <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
		  </td>
		</tr>
	  </table>	</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>

</body>
</html>
