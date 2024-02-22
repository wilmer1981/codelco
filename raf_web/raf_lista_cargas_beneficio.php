<html>
<head>
<title>Consultas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css"></head>
<script language="JavaScript">
function Proceso(opc)
{
var f = document.FrmPrincipal;

	switch(opc)
	{
		case "W": 
			if(f.cmbturno.value == -1)
			{
				alert("Debe Seleccionar Turno");
				f.cmbturno.focus();	 
				return
		    }
			f.action="raf_con_cargas_beneficio.php";
			f.submit();
			break;		

		case "E": 
			if(f.cmbturno.value == -1)
			{
				alert("Debe Seleccionar Turno");
				f.cmbturno.focus();	 
				return
		    }
			f.action="raf_con_cargas_beneficio_xls.php";
			f.submit();
			break;		

		case "S":
			document.location = "../principal/sistemas_usuario.php?CodSistema=12&Nivel=1&CodPantalla=9";										 	
			break;
	}

}

</script>
</head>

<body>
<form name="FrmPrincipal" method="post" action="">
<? include("../principal/encabezado.php")?>
<table width="770" border="0" class="TablaPrincipal"> 
<tr> 
	<td align="center">
	  <table width="600" border="0" cellspacing="0" cellpadding="0" class="TablaDetalle">
          <tr> 
            <td width="55">Fecha</td>
            <td width="261"><select name="Dia" style="width:50px;">
                <?
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
                <?
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
                <?
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
            <td width="67">Turno</td>
            <td width="214"><select name="cmbturno">
                <?
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
              </select></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
        </table>
	    <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><br>
        </p>
        <table width="600" border="0" cellspacing="0" cellpadding="0" class="TablaDetalle">
		<tr>
		  <td align="center">
		  <input type="button" name="BtnWeb" value="List Web" style="width:70px" onClick="Proceso('W');">
		  <input type="button" name="BtnExcel" value="List Excel" style="width:70px" onClick="Proceso('E');">
		  <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
		  </td>
		 </tr>
	  </table>
	</td>
</tr>
</table>
<? include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
