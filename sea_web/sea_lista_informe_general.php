<?php
	$CodigoDeSistema=2;
	$Dia = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
	$Mes = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	
	$Ayer = date("Y-m-d", mktime(1,0,0,date("m"),(date("d")-1),date("Y")));
	$DiaAyer = intval(substr($Ayer,8,2));
	$MesAyer = intval(substr($Ayer,5,2));
	$AnoAyer = intval(substr($Ayer,0,4));
?>
<html>
<head>
<title>Informe Operativo De Productos Intermedios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<script language="JavaScript">
function Proceso(opc)
{
var f = document.FrmPrincipal;

	switch(opc)
	{
		case "W": 
		//	f.action="prueba_rechazo_hm.php";
			f.action="sea_mov_acum_anodos.php?opcion=1";
		//	f.action="rechazo_prueba.php";
			f.submit();
			break;  		
		case "A": 
			f.Dia.value = f.DiaAyer.value;   
			f.Mes.value = f.MesAyer.value;
			f.Ano.value = f.AnoAyer.value;		
			f.action="sea_mov_acum_anodos.php?opcion=2";
			f.submit();
			break;		
		case "E": 
			f.action="sea_mov_acum_anodos_xls.php";
			f.submit();
			break;		
		case "S":
			history.back();
			break;
	}

}

</script>
</head>

<body>
<form name="FrmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
<input type="hidden" name="DiaAyer" value="<?php echo $DiaAyer; ?>">
<input type="hidden" name="MesAyer" value="<?php echo $MesAyer; ?>">
<input type="hidden" name="AnoAyer" value="<?php echo $AnoAyer; ?>">
<table width="770" height="330" border="0" class="TablaPrincipal"> 
<tr> 
	<td align="center" valign="top">
	  <p><b>INFORME DIARIO PRODUCTOS INTERMEDIOS</b><p>
        <table width="600" border="0" cellspacing="0" cellpadding="0" class="TablaDetalle">
		<tr>
		  <td width="80">Fecha</td>
		  <td width="514"><select name="Dia" style="width:50px;">
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
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
	  </table>
	    <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><br>
        </p>
        <table width="600" border="0" cellspacing="0" cellpadding="0" class="TablaDetalle">
		<tr>
		    <td align="center"> <input name='BtnAyer' type='button' id="BtnAyer" style='width:70px' onClick="Proceso('A');" value='Ayer'>
              <input type="button" name="BtnWeb" value="List Web" style="width:70px" onClick="Proceso('W');">
		  <input type="button" name="BtnExcel" value="List Excel" style="width:70px" onClick="Proceso('E');">
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
