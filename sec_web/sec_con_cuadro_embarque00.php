<?php
	$CodigoDeSistema = 3;
	include("../principal/conectar_principal.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	$Mes  = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano  = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{	
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "GW":
			f.action = "sec_con_cuadro_embarque.php";
			f.submit();
			break;
		case "GE":
			f.action = "sec_con_cuadro_embarque_excel.php";
			f.submit();
			break;				
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
		case "R":
			f.action = "sec_con_cuadro_embarque00.php";
			f.submit();
			break;
	}
}
</script>

<body leftmargin="2" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php"); ?>
<table width="770" height="315" border="0" cellpadding="3" cellspacing="3" class="TablaPrincipal">
    <tr>
      <td valign="top"> <div align="center"><strong><br>
          CUADRO DE EMBARQUE COBRE ELECTROLITICO Y SUB-PRODUCTOS</strong><br>
          <br>
        </div>
        <table width="548" border="1" align="center" cellpadding="2" cellspacing="0">
          <tr> 
            <td width="152" class="ColorTabla01">MES INFORME</td>
            <td width="491"><!--<SELECT name="Dia" id="Dia">
                <?php
				for ($i=1;$i<=31;$i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("j"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
              </SELECT> --><SELECT name="Mes" id="Mes">
                <?php
				for ($i=1;$i<=12;$i++)
				{
					if (isset($Mes))
					{
						if ($Mes == $i)
							echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
					else
					{
						if ($i ==date("n"))
							echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
				}
			?>
              </SELECT> <SELECT name="Ano" id="Ano">
                <?php
				for ($i=date("Y")-2;$i<=date("Y");$i++)
				{
					if (isset($Ano))
					{
						if ($Ano == $i)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i ==date("Y"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
              </SELECT>
            </td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr align="center"> 
            <td height="30" colspan="2"> 
             <input name="BtnGenerar" type="button" value="Generar Web" style="width:90px" onClick="Proceso('GW');"> 
              <input name="BtnGenerar2" type="button" value="Generar Excel" style="width:90px" onClick="Proceso('GE');">
              <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"> 
            </td>
          </tr>
        </table>
        <br>
      </td>
  </tr>
</table><?php include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>
