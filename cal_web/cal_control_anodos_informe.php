<?php 
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Informacion"])) {
		$Informacion = $_REQUEST["Informacion"];
	}else{
		$Informacion ="";
	}

	$Datos=explode("//",$Informacion);
	$Cont=0;
	//foreach($Datos as $k => $v)
	foreach($Datos as $k => $v )
	{
		if ($v["hornada"]!="")
		{
			$Datos2=explode("~~",$v);
			$Fila[$Cont]["cod_producto"]=$Datos2[0];
			$Fila[$Cont]["cod_subproducto"]=$Datos2[1];
			$Fila[$Cont]["hornada"]=$Datos2[2];
			$Fila[$Cont]["cod_leyes"]=$Datos2[3];
			$Fila[$Cont]["signo"]=$Datos2[4];
			$Fila[$Cont]["limite"]=$Datos2[5];
			$Fila[$Cont]["valor"]=$Datos2[6];
			$Fila[$Cont]["cod_unidad"]=$Datos2[7];
			$Cont++;
		}
	}
?>
<html>
<head>
<title>CAL-Control de Anodos</title>
<link href="../principal/estilos/css_rec_web.css" rel="stylesheet" type="text/css">
<script language="javascript">
function Proceso(o)
{	
	var f = document.frmPrincipal;
	switch (o)
	{
		case "I":
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnImprimir.style.visibility = "";
			f.BtnSalir.style.visibility = "";
			break;
		case "S":
			window.close();
			break;
	}
}
</script>
<style type="text/css">
.Estilo1 {
	font-size: 14px;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo11 {
	font-size: 12px;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
}
.Estilo2 {font-size: 12px}
.Estilo4 {font-family: Arial, Helvetica, sans-serif}
.Estilo7 {font-size: 18px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; }
.Estilo9 {font-size: 24px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; }
</style>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
<div align="center" class="Estilo1">
  <table width="600" height="880" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td height="120" valign="top"><u><img src="../principal/imagenes/logo_codelco5.jpg" width="149" height="90"><br>
      </u>
        </td>
      <td align="center" valign="top" class="Estilo11">Corporaci&oacute;n Nacional del Cobre de Chile<br>
        Divisi&oacute;n Ventanas <br>
        <br>
        <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
        <input name="BtnSalir" type="button" id="BtnSalir" value="Cerrar" style="width:70px " onClick="Proceso('S')">
      </td>
    </tr>
    <tr align="center">
      <td height="70" colspan="2" valign="top"><u><span class="Estilo9">NO CONFORMIDAD QUIMICA DE ANODOS</span></u></td>
    </tr>
    <tr align="center">
      <td height="50" colspan="2" valign="top"><u><span class="Estilo7">CAUSA DE NO CONFORMIDAD QUIMICA</span></u></td>
    </tr>
    <tr>
      <td colspan="2" valign="top"><table width="600" border="1" cellpadding="2" cellspacing="0" bordercolor="#000000">
        <tr align="center">
          <td colspan="2" class="Estilo1 Estilo2">HORNADA</td>
          <td width="86"  class="Estilo1 Estilo2">ELEM</td>
          <td colspan="2" class="Estilo1 Estilo2">VALORES</td>
        </tr>
<?php	
	reset($Fila);
	//while (list($k,$v)=each($Fila))
	foreach($Fila as $k => $v )
	{	
		echo "<tr height=\"30\">\n";
		switch ($v["cod_subproducto"])
		{
			case "1":
				$TipoAnodo="H.V.L.";
				break;
			case "2":
				$TipoAnodo="TENIENTE";
				break;
			case "3":
				$TipoAnodo="SUR ANDES";
				break;
			case "4":
				$TipoAnodo="VENTANA";
				break;
			case "8":
				$TipoAnodo="VENTANA";
				break;
		}
		echo "<td >".$TipoAnodo."</td>\n";
		echo "<td align=\"center\">".$v["hornada"]."</td>\n";
		echo "<td align=\"center\">";
		if ($v["cod_leyes"]!="AS/SB")
		{
			$Consulta = "select * from proyecto_modernizacion.leyes where cod_leyes='".$v["cod_leyes"]."'";
			$RespAux=mysqli_query($link, $Consulta);
			if ($FilaAux=mysqli_fetch_array($RespAux))			
				echo $FilaAux["abreviatura"];
			else
				echo "&nbsp;";
		}
		else
		{
			echo "As/Sb";
		}
		echo "</td>\n";
		echo "<td align=\"center\">".$v["signo"]."&nbsp;".$v["limite"]."</td>\n";
		echo "<td align=\"center\">".number_format($v["valor"],2,",",".");
		if ($v["cod_unidad"]!="")
		{
			$Consulta = "select * from proyecto_modernizacion.unidades where cod_unidad='".$v["cod_unidad"]."'";
			$RespAux=mysqli_query($link, $Consulta);
			if ($FilaAux=mysqli_fetch_array($RespAux))			
				echo "&nbsp;(".$FilaAux["abreviatura"].")";
		}
		echo "</td>\n";
		echo "</tr>\n";
	}
?>
      </table></td>
    </tr>
    <tr align="center" valign="middle">
      <td width="300" height="90" class="Estilo1">__________________________<br>QUIMICO ESPECTROGRAFIA</td>
      <td width="300" height="100" class="Estilo11">____________________________<br>JEFE LABORATORIO ANALITICO </td>
    </tr>
    <tr>
      <td height="70" valign="top">FECHA:<?php echo date("d-m-Y");?></td>
      <td height="50" align="right" valign="top">Anexo 6.2, PCC-005/03 </td>
    </tr>
  </table>
  <U>  </U></div>
  </form>
</body>
</html>
