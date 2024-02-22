<?php 
	include("../principal/conectar_pmn_web.php"); 
  //NumLix=TES1001&Dia=11&Mes=12&Ano=2023&Turno=3

  $NumLix=$_REQUEST["NumLix"];
  $Dia=$_REQUEST["Dia"];
	$Mes=$_REQUEST["Mes"];
	$Ano=$_REQUEST["Ano"];
  $Turno=$_REQUEST["Turno"];

$FechaModif=$Ano."-".$Mes."-".$Dia;
$sql = "select * from lixiviacion_barro_anodico where ";
$sql.= " num_lixiviacion = '".$NumLix."'";
$sql.= " and turno = '".$Turno."'";
$sql.= " and fecha = '".$FechaModif."'";
$result = mysqli_query($link, $sql);
$StockTxtBAD=0;
if ($row=mysqli_fetch_array($result))
{
	if ($row["bad"] == 0)
		$TxtBAD = "";
	else
		$TxtBAD = $row["bad"];
	$StockTxtBAD = $row["stock_bad"];
	$Porc =$row["porc_agua"];	
}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function ProcesoHum(opt)
{
	var f=document.frmConsulta;
	switch (opt)
	{		
		case "N":
			if(confirm('¿Está seguro de guardar humedad ingresada?'))
			{
				if(parseFloat(f.Porc.value)>100)
				{
					alert('Humedad no puede superar el 100%');
					f.Porc.focus();
					return;
				}
				f.action = "pmn_ing_lixiviacion01.php?Proceso=IngHum&NumLix="+f.NumLix.value;
				f.submit();
			}
		break;
		case "S":
			window.close();
		break;
	}
}

//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body class="TituloCabeceraOz" leftmargin="3" topmargin="2" style="overflow:hidden;" onLoad="document.getElementById('Porc').focus();">
<form name="frmConsulta" action="" method="post">
<input type="hidden" name="NumLix" value="<?php echo $NumLix;?>">
<input type="hidden" name="Ano" value="<?php echo $Ano;?>">
<input type="hidden" name="Mes" value="<?php echo $Mes;?>">
<input type="hidden" name="Dia" value="<?php echo $Dia;?>">
<input type="hidden" name="Turno" value="<?php echo $Turno;?>">
<input type="hidden" name="TxtBAD" value="<?php echo $TxtBAD;?>">
<div align="center"> 
    <table width="300" height="20" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
      <tr bgcolor="#CCCCCC"> 
        <td height="20" colspan="16" class="titulo_azul">Ingreso de Humedad</td>
      </tr>
      <tr class="TituloCabeceraAzul"> 
        <td height="20">Lixiviación</td>
        <td height="20" align="right" valign="middle"><?php echo $NumLix;?></td>
      </tr>
      <tr class="TituloCabeceraAzul"> 
        <td height="20">BAD.</td>
        <td height="20" align="right" valign="middle"><?php echo number_format($TxtBAD,0,',','.');?></td>
      </tr>
      <tr> 
        <td height="20" class="TituloCabeceraAzul">Valor Humedad %</td>
        <td height="20" align="right" valign="middle"><input name="Porc" maxlength="5" size="3" type="text" onKeyDown="SoloNumeros(true,this)" id="Porc" value="<?php echo $Porc;?>"></td>
      </tr>
      <tr class="TituloCabeceraAzul"> 
        <td height="20">Stock BAD.</td>
        <td height="20" align="right" valign="middle"><?php echo number_format($StockTxtBAD,0,',','.');?></td>
      </tr>
    </table>
    <table width="300" height="30" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr> 
        <td height="28"> <div align="center">
            <input type="button" name="btnModificar" value="Ingresar" onClick="ProcesoHum('N')" style="width:70px">
            <input type="button" name="btnSalir" value="Salir" onClick="ProcesoHum('S')" style="width:70px">
          </div></td>
      </tr>
    </table>
</div>	
</form>
</body>
</html>
