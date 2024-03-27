<? 
include("../principal/conectar_pac_web.php");
$CodigoDeSistema = 12;
$CodigoDePantalla = 7;

$fecha = $Ano.'-'.$Mes.'-01';	
if($Proceso == "G")
{
	$Elimina = "DELETE FROM raf_web.cierre_mes WHERE fecha = '$fecha'";	
	mysql_query($Elimina);	

	$Inserta = "INSERT INTO raf_web.cierre_mes (fecha,estado)";
	$Inserta.= " values('$fecha','$estado')";
	mysql_query($Inserta);

}
if($Proceso == "B")
{
	$Consulta = "SELECT * FROM raf_web.cierre_mes WHERE fecha = '$fecha'";
	$rs = mysqli_query($link, $Consulta);
	if($Fila = mysql_fetch_array($rs))
	{
	
			$Ano = substr($Fila["fecha"],0,4);
			$Mes = substr($Fila["fecha"],5,2);		
			$estado = $Fila["estado"];	
	}
	else
		$estado = '';	

}

?>
<html>
<head>
<title>Consultas</title>
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
		case "G": 
			f.action="raf_cierre_mes.php?Proceso=G";
			f.submit();
			break;		
		case "B": 
			f.action="raf_cierre_mes.php?Proceso=B";
			f.submit();
			break;		
		case "S":
			document.location = "../principal/sistemas_usuario.php?CodSistema=12";										 	
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
	<td height="313" align="center" valign="top">
	  <br>
	  <br>
	  <table width="600" border="0" cellpadding="5" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td width="42">Fecha</td>
            <td width="260"> <select name="Mes" style="width:90px;">
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
              </select>
              <input name="BtnBuscar" type="button" id="BtnBuscar" style="width:70px" onClick="Proceso('B');" value="Buscar"></td>
            <td width="265">
              <?		
			if($estado != '')
			{					
			  echo "Abierto";
              if($estado == 'A')
				  echo '<input type="radio" name="estado" value="A" Checked>';
			  else	
				  echo '<input type="radio" name="estado" value="A">';

              echo "&nbsp;Cerrado&nbsp;&nbsp;&nbsp;&nbsp;";
              if($estado == 'C')
              	  echo '<input type="radio" name="estado" value="C" Checked>';
			  else		
              	  echo '<input type="radio" name="estado" value="C">';
			}
			else
			{
			 echo 'Abierto
                  <input type="radio" name="estado" value="A">
	              &nbsp;Cerrado&nbsp;&nbsp;&nbsp;&nbsp;
    	          <input type="radio" name="estado" value="C">';
            }
			?>
            </td>
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
		  <input type="button" name="BtnGuardar" value="Grabar" style="width:70px" onClick="Proceso('G');">
		  <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
		  </td>
		 </tr>
	  </table>	</td>
</tr>
</table>
<? include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
