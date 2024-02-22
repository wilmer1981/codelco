<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 2;
	include("../principal/conectar_pmn_web.php");
	

?>
<html>
<head>
<title>Ingreso Nueva Hornada</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f =document.FrmIngreso;	
	switch (opt)
	{

		case "GD": //GRABA 
		
			if (f.NumHorno1.value == "")
			{
				alert("Debe Ingresar Numero Horno");
				f.NumHorno1.focus();
				return;
			}
			if (f.NumFunda1.value == "")
			{
				alert("Debe Ingresar Numero Funda");
				f.NumFunda1.focus();
				return;
			}
			if (f.HornadaTotal1.value == "")
			{
				alert("Debe Ingresar Hornada Total");
				f.HornadaTotal1.focus();
				return;
			}
			if (f.HornadaParcial1.value == "")
			{
				alert("Debe Ingresar Hornada Parcial");
				f.HornadaParcial1.focus();
				return;
			}
			
			//alert ("EEEEEEEEEEEEEEEE" +f.Prod.value);
			f.action = "pmn_ing_deselenizacion001.php?Proceso=GD&Prod="+f.Prod.value +  "&Dia="+f.Dia.value+"&Mes="+f.Mes.value+"&Ano="+f.Ano.value;
			//f.action = "pmn_ing_deselenizacion001.php?Proceso=GD";

			f.submit();
			break;
	}		
			
}
function Salir()
{

	var frm =document.FrmIngreso;	 
	window.close();
}

function TeclaPulsada1(salto) 
{ 
	
	var f = document.FrmIngreso;
	var teclaCodigo = event.keyCode;
		
	if (teclaCodigo == 13)
	{		
	
		eval("f." + salto + ".focus();");
	}
}


</script>
</head>
<?php

	echo '<body class="TituloCabeceraOz" leftmargin="3" topmargin="2"  onLoad="document.FrmIngreso.NumHorno1.focus();">';

	?>	
<form name="FrmIngreso" method="post" action="">
  <table width="435" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="552"><table width="423" height="50" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="4"><div align="center" class="TituloCabeceraAzul">Modifica Hornada </div></td>
          </tr>
        <br> 
		<br>
            <tr> 
            <td width="112" height="18" class="titulo_azul">Hornada a Modificar</td>
            <td height="18" colspan="2">:
			<?php
			//echo "dia".$Dia;
			echo "<input name='Prod' type='hidden' value ='".$Prod."'>\n";
			echo "<input name='Dia' type='hidden' value ='".$Dia."'>\n";
			echo "<input name='Mes' type='hidden' value ='".$Mes."'>\n";
			echo "<input name='Ano' type='hidden' value ='".$Ano."'>\n";
			//if ($Modif == "S")
				//{
					//echo "aqui".$NumFunda."%%";//"-".$NumFunda."-".$HornadaTotal."-".$HornadaParcial;
					//echo "<input name='Hornada' type='hidden' value='".$Hornada."'>\n";
					echo $NumHorno;
					echo "-";
					echo "<input name='NumHorno' type='hidden' value='".$NumHorno."'>\n";
					echo $NumFunda;
					echo "-";
					echo "<input name='NumFunda' type='hidden' value='".$NumFunda."'>\n";
					echo $HornadaTotal;
					echo "-";
					echo "<input name='HornadaTotal' type='hidden' value='".$HornadaTotal."'>\n";
					echo $HornadaParcial;
					echo "<input name='HornadaParcial' type='hidden' value='".$HornadaParcial."'>\n";
					//echo " Turno : ".$Turno;
					echo "<input name='Turno' type='hidden' value ='".$Turno."'>\n"; 	
			?>
		    </td>
            <td width="32" height="18">&nbsp;</td>
       </tr>
		<tr> 
            <td height="18" class="titulo_azul">Hornada Nueva </td>
            <td height="18" colspan="2">:
			<?php
					echo "#H";
				?>
					<input name="NumHorno1" type="text" id="NumHorno1" onKeyDown="TeclaPulsada1('NumFunda1')"  value="<?php echo $NumHorno1;?>" size='2' maxlength='1'>
				<?php
					echo "#F";
					
				?>
					<input name="NumFunda1" type="text" id="Numfunda1" onKeyDown="TeclaPulsada1('HornadaTotal1')" value="<?php echo $NumFunda1;?>"  size='2' maxlength='2'>
				<?php	
					echo "H.T";
				?>	
					<input name="HornadaTotal1" type="text" id="HornadaTotal1" onKeyDown="TeclaPulsada1('HornadaParcial1')"  value="<?php echo $HornadaTotal1;?>" size='2' maxlength='2'>
				<?php	
					echo "H.P";

				?>
					<input name="HornadaParcial1" type="text" id="HornadaParcial1" onKeyDown="TeclaPulsada1('btnGrabar2')"  value="<?php echo $HornadaParcial1;?>" size='2' maxlength='1'>
				<?php
			?>
		    </td>
            <td width="32" height="18">&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="425" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td> <div align="center">
			   <input name="btnGrabar2" type="button" id="btnGrabar2" style="width:70" value="Grabar" onClick="Proceso('GD');">
				<input name="BtnSalir" style="width:70" type="button" id="BtnSalir" value="Salir" onClick="Salir();">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
