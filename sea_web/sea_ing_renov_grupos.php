<?php
 include("../principal/conectar_raf_web.php");
$CodigoDeSistema=2;

$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Ano      = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
$Mes      = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
$Dia      = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
$hora     = isset($_REQUEST["hora"])?$_REQUEST["hora"]:date("H");
$minuto   = isset($_REQUEST["minuto"])?$_REQUEST["minuto"]:date("i");
$cmbturno = isset($_REQUEST["cmbturno"])?$_REQUEST["cmbturno"]:"";
$grupo1   = isset($_REQUEST["grupo1"])?$_REQUEST["grupo1"]:"";
$grupo2   = isset($_REQUEST["grupo2"])?$_REQUEST["grupo2"]:"";
$cmbproducto1 = isset($_REQUEST["cmbproducto1"])?$_REQUEST["cmbproducto1"]:"";
$cmbproducto2 = isset($_REQUEST["cmbproducto2"])?$_REQUEST["cmbproducto2"]:"";

if($Proceso == "E")
{
	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	$Eliminar = "DELETE FROM sea_web.renovacion_grupos WHERE fecha = '$Fecha' AND turno = '$cmbturno'";
	mysqli_query($link, $Eliminar);
	$Proceso = "B";
}

if($Proceso == "B")
{
	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	$Consulta = "SELECT * FROM sea_web.renovacion_grupos WHERE fecha = '$Fecha' AND turno = '$cmbturno'";
	$rs = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($rs);

	$grupo1       = isset($Fila["grupo1"])?$Fila["grupo1"]:"";
	$cmbproducto1 = isset($Fila["producto1"])?$Fila["producto1"]:"";
	$grupo2       = isset($Fila["grupo2"])?$Fila["grupo2"]:"";
	$cmbproducto2 = isset($Fila["producto2"])?$Fila["producto2"]:"";
	$grupo3       = isset($Fila["grupo3"])?$Fila["grupo3"]:"";
	$cmbproducto3 = isset( $Fila["producto3"])?$Fila["producto3"]:"";

}


?>
<html>
<head>
<title>Sistema de Anodos</title>
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
			f.action = "sea_ing_renov_grupos01.php?Proceso=G" ;
			f.submit();
			break;	

		case "B":
			if(f.cmbturno.value == -1)
			{
				alert("Debe Seleccionar Turno");
				f.cmbturno.focus();
				return
			}
			f.action = "sea_ing_renov_grupos.php?Proceso=B" ;
			f.submit();
			break;	

		case "E":
			f.action = "sea_ing_renov_grupos.php?Proceso=E" ;
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
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body >
<form name="FrmPrincipal" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td valign="top" align="center"><br>  		  
		<table width='560' border='0' cellpadding='0' cellspacing='0' class="TablaInterior">
          <tr> 
            <td colspan="4" class="ColorTabla01" align="center"><strong>Ingreso 
              Renovaci&oacute;n De Grupos</strong></td>
          </tr>
          <tr> 
            <td width="73">Fecha</td>
            <td width="266"><SELECT name="Dia" style="width:50px;">
                <?php
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
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
              </SELECT> <SELECT name="Mes" style="width:90px;">
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
              </SELECT></td>
            <td width="62">Turno </td>
            <td width="156"><SELECT name="cmbturno">
                <?php
				echo"<option value='-1' SELECTed>Turno</option>";
				if($cmbturno == "A")
					echo"<option value='A' SELECTed>Turno A</option>";
				else
					echo"<option value='A'>Turno A</option>";
				if($cmbturno == "B")
					echo"<option value='B' SELECTed>Turno B</option>";
				else
					echo"<option value='B'>Turno B</option>";
				if($cmbturno == "C")
					echo"<option value='C' SELECTed>Turno C</option>";
				else
					echo"<option value='C'>Turno C</option>";
			?>
              </SELECT>
              <input type="button" name="BtnBuscar" value="Buscar" style="width:80" onClick="Proceso('B');"></td>
          </tr>
        </table>
		<br>
		<table width='226' border='1' cellpadding='0' cellspacing='0' class="TablaPrincipal">
          <tr class="ColorTabla01"> 
            <td align="center">Grupo</td>
            <td align="center">Tipo Anodo</td>
          </tr>
          <tr> 
            <td width="87" align="center"><input type="text" name="grupo1" size="10" value="<?php echo $grupo1; ?>"></td>
            <td width="133" align="center"><SELECT name="cmbproducto1">
                <?php
				echo"<option value='-1' SELECTed>SELECCIONAR</option>";
				if($cmbproducto1 == "VENT")
					echo"<option value='VENT' SELECTed>Ventana</option>";
				else
					echo"<option value='VENT'>Ventana</option>";
				if($cmbproducto1 == "HVL")
					echo"<option value='HVL' SELECTed>HVL</option>";
				else
					echo"<option value='HVL'>HVL</option>";
				if($cmbproducto1 == "SUR.AND")
					echo"<option value='SUR.AND' SELECTed>Anglo American</option>";
				else
					echo"<option value='SUR.AND'>Anglo American</option>";
				if($cmbproducto1 == "TTE")
					echo"<option value='TTE' SELECTed>Teniente</option>";
				else
					echo"<option value='TTE'>Teniente</option>";
			?>
              </SELECT></td>
          </tr>
          <tr> 
            <td align="center"><input type="text" name="grupo2" size="10" value="<?php echo $grupo2; ?>"></td>
            <td align="center"><SELECT name="cmbproducto2">
                <?php
				echo"<option value='-1' SELECTed>SELECCIONAR</option>";
				if($cmbproducto2 == "VENT")
					echo"<option value='VENT' SELECTed>Ventana</option>";
				else
					echo"<option value='VENT'>Ventana</option>";
				if($cmbproducto2 == "HVL")
					echo"<option value='HVL' SELECTed>HVL</option>";
				else
					echo"<option value='HVL'>HVL</option>";
				if($cmbproducto2 == "SUR.AND")
					echo"<option value='SUR.AND' SELECTed>Anglo American</option>";
				else
					echo"<option value='SUR.AND'>Anglo American</option>";
				if($cmbproducto2 == "TTE")
					echo"<option value='TTE' SELECTed>Teniente</option>";
				else
					echo"<option value='TTE'>Teniente</option>";
			?>
              </SELECT></td>
          </tr>
         <!-- <tr> 
            <td width="87" align="center"><input type="text" name="grupo3" size="10" value="<?php echo $grupo3; ?>"> 
            </td>
            <td width="133" align="center"><SELECT name="cmbproducto3">
                <?php
				/*echo"<option value='-1' SELECTed>SELECCIONAR</option>";
				if($cmbproducto3 == "VENT")
					echo"<option value='VENT' SELECTed>Ventana</option>";
				else
					echo"<option value='VENT'>Ventana</option>";
				if($cmbproducto3 == "HVL")
					echo"<option value='HVL' SELECTed>HVL</option>";
				else
					echo"<option value='HVL'>HVL</option>";
				if($cmbproducto3 == "SUR.AND")
					echo"<option value='SUR.AND' SELECTed>Sur Andes</option>";
				else
					echo"<option value='SUR.AND'>Sur Andes</option>";
				if($cmbproducto3 == "TTE")
					echo"<option value='TTE' SELECTed>Teniente</option>";
				else
					echo"<option value='TTE'>Teniente</option>";*/
			?>
              </SELECT> </td>
          </tr>-->
        </table>
		<div style='position:absolute; left: 115px; top: 340px; width: 560px; height: 31px; OVERFLOW: auto;' id='div2'> 
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
