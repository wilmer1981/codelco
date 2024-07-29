<?php
include("../principal/conectar_raf_web.php");
$CodigoDeSistema=2;

$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Ano      = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
$Mes      = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
$Dia      = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
$cmbturno = isset($_REQUEST["cmbturno"])?$_REQUEST["cmbturno"]:"";

$ton_proy1 = isset($_REQUEST["ton_proy1"])?$_REQUEST["ton_proy1"]:"";
$ton_proy2 = isset($_REQUEST["ton_proy2"])?$_REQUEST["ton_proy2"]:"";
$ton_proy3 = isset($_REQUEST["ton_proy3"])?$_REQUEST["ton_proy3"]:"";
$hornada1  = isset($_REQUEST["hornada1"])?$_REQUEST["hornada1"]:"";
$hornada2  = isset($_REQUEST["hornada2"])?$_REQUEST["hornada2"]:"";
$hornada3  = isset($_REQUEST["hornada3"])?$_REQUEST["hornada3"]:"";
$observacion = isset($_REQUEST["observacion"])?$_REQUEST["observacion"]:"";

if($Proceso == "E")
{
	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	$Eliminar = "DELETE FROM raf_web.proyeccion_moldeo WHERE fecha = '$Fecha' AND turno = '$cmbturno'";
	mysqli_query($link, $Eliminar);
	$Proceso = "B";
}

if($Proceso == "B")
{
	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	$Consulta = "SELECT * FROM raf_web.proyeccion_moldeo WHERE fecha = '$Fecha' AND turno = '$cmbturno'";
	$rs = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($rs);
	
	$ton_proy1 = isset($Fila["ton_proy1"])?$Fila["ton_proy1"]:0;
	$ton_proy2 = isset($Fila["ton_proy2"])?$Fila["ton_proy2"]:0;
	$ton_proy3 = isset($Fila["ton_proy3"])?$Fila["ton_proy3"]:0;
	$hornada1  = isset($Fila["hornada1"])?$Fila["hornada1"]:0;
	$hornada2  = isset($Fila["hornada2"])?$Fila["hornada2"]:0;
	$hornada3  = isset($Fila["hornada3"])?$Fila["hornada3"]:0;
	$observacion = isset($Fila["observacion"])?$Fila["observacion"]:"";
	
	if($hornada1 == 0)
	   $hornada1 = '';		
	else
		$hornada1 = $Fila["hornada1"];

	if($ton_proy1 == 0)
		$ton_proy1 = '';
	else
		$ton_proy1 = $Fila["ton_proy1"];

	if($hornada2 == 0)
	   $hornada2 = '';		
	else
		$hornada2 = $Fila["hornada2"];

	if($ton_proy2 == 0)
		$ton_proy2 = '';
	else
		$ton_proy2 = $Fila["ton_proy2"];

	if($hornada3 == 0)
	   $hornada3 = '';		
	else
		$hornada3 = $Fila["hornada3"];

	if($ton_proy3 == 0)
		$ton_proy3 = '';
	else
		$ton_proy3 = $Fila["ton_proy3"];

	$Consulta = "SELECT observacion FROM raf_web.proyeccion_moldeo WHERE fecha = '$Fecha' AND observacion != ''";
	$rs = mysqli_query($link, $Consulta);
	$fila = mysqli_fetch_array($rs);
	$observacion = isset($fila["observacion"])?$fila["observacion"]:"";
}
?>
<html>
<head>
<title>SISTEMA DE ANODOS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function Proceso(opc)
{
	var f = document.FrmPrincipal;
	
	switch(opc)
	{
		case "G":
			if(f.cmbturno.value == -1)
			{
				alert("Debe Seleccionar Turno");
				f.cmbturno.focus();
				return
			}
			f.action = "raf_ing_recep_moldeos01.php?Proceso=G" ;
			f.submit();
			break;	

		case "B":
			if(f.cmbturno.value == -1)
			{
				alert("Debe Seleccionar Turno");
				f.cmbturno.focus();
				return
			}
			f.action = "raf_ing_recep_moldeos.php?Proceso=B" ;
			f.submit();
			break;	

		case "E":
			f.action = "raf_ing_recep_moldeos.php?Proceso=E" ;
			f.submit();
			break;	

		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=2&Nivel=1&CodPantalla=45";
			f.submit();
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
.Estilo4 {color: #666666}
-->
</style></head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body >
<form name="FrmPrincipal" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="340" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td valign="top" align="center"><br>  		  
		<table width='560' border='0' cellpadding='0' cellspacing='0' class="TablaInterior">
          <tr> 
            <td colspan="4" class="ColorTabla01" align="center"><strong>Ingreso 
              Recepci&oacute;n De Moldeos Proyectados</strong></td>
          </tr>
          <tr> 
            <td width="73">Fecha</td>
            <td width="266"><select name="Dia" style="width:50px;">
                <?php
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("j"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			  ?>
              </select> <select name="Mes" style="width:90px;">
                <?php
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($Mes == $i)
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
				}
				?>
              </select> <select name="Ano" style="width:60px;">
                <?php
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($Ano))
					{
						if ($Ano == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
				?>
              </select></td>
            <td width="62">Turno </td>
            <td width="156"><select name="cmbturno">
                <?php
				echo"<option value='-1' selected>Turno</option>";
				if($cmbturno == "A")
					echo"<option value='A' selected>Turno A</option>";
				else
					echo"<option value='A'>Turno A</option>";
				if($cmbturno == "B")
					echo"<option value='B' selected>Turno B</option>";
				else
					echo"<option value='B'>Turno B</option>";
				if($cmbturno == "C")
					echo"<option value='C' selected>Turno C</option>";
				else
					echo"<option value='C'>Turno C</option>";
				
			?>
              </select>
              <input type="button" name="BtnBuscar" value="Buscar" style="width:80" onClick="Proceso('B');"></td>
          </tr>
        </table>
		<br>
		<table width='560' border='1' cellpadding='0' cellspacing='0' class="TablaPrincipal">
          <tr class="Detalle01"> 
            <td>&nbsp;</td>
            <td align="center"><span class="Estilo4">HORNADA</span></td>
            <td align="center"><span class="Estilo4">TM/PROY</span></td>
          </tr>
          <tr> 
            <td width="150">Reverb 1</td>
            <td width="184" align="center"><input type="text" name="hornada1" size="15" value="<?php echo $hornada1; ?>"></td>
            <td width="218" align="center"><input type="text" name="ton_proy1" size="15" value="<?php echo $ton_proy1; ?>"></td>
          </tr>
          <tr> 
            <td>Reverb 2</td>
            <td width="184" align="center"><input type="text" name="hornada2" size="15" value="<?php echo $hornada2; ?>"></td>
            <td width="218" align="center"><input type="text" name="ton_proy2" size="15" value="<?php echo $ton_proy2; ?>"></td>
          </tr>
          <tr> 
            <td>Basculante</td>
            <td width="184" align="center"><input type="text" name="hornada3" size="15" value="<?php echo $hornada3; ?>"></td>
            <td width="218" align="center"><input type="text" name="ton_proy3" size="15" value="<?php echo $ton_proy3; ?>"></td>
          </tr>
        </table>
		<br>
		<table width='560' border='1' cellpadding='0' cellspacing='0' class="TablaPrincipal">
          <tr class="Detalle01"> 
            <td align="center"><span class="Estilo4">OBSERVACIONES</span></td>
		  </tr>
		  <tr> 	
            <td align="center"><textarea name="observacion" cols="60" rows="3" wrap="VIRTUAL"><?php echo $observacion;?></textarea></td>
		  </tr>
		</table>  	
		<div style='position:absolute; left: 115px; top: 364px; width: 560px; height: 31px; OVERFLOW: auto;' id='div2'> 
        <table width="560" border="0" class="tablainterior">
          <tr> 
           <td align="center"> 
		   <input type="button" name="BtnGuardar" value="Grabar" style="width:80" onClick="Proceso('G');"> 
		   <input type="button" name="BtnEliminar" value="Eliminar" style="width:80" onClick="Proceso('E');"> 
           <input type="button" name="BtnSalir" value="Salir" style="width:80" onClick="Proceso('S');"></td>
 		  </tr>
		</table>
		</div>  	
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
