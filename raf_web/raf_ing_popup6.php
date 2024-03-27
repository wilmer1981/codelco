<?
include("../principal/conectar_raf_web.php");

if(strlen($Mes) == 1)
	$Mes = '0'.$Mes;
if(strlen($Dia) == 1)
	$Dia = '0'.$Dia;

$fecha = $Ano.'-'.$Mes.'-'.$Dia;
$Anito=substr($Hornada,0,4);
$MesJ=substr($Hornada,4,2);

if($Proceso == "B")
{
	$Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE fecha='$Fecha'";
	$Consulta.= " AND hornada = $Hornada AND campo1='$etapa' AND tipo_report = 2 AND seccion_report = '$Seccion'";
	$rs = mysqli_query($link, $Consulta);
	if($row = mysql_fetch_array($rs))
	{
		$etapa = $row["campo1"];
		$Unidades = $row[campo2];
		$Peso = $row[campo3];
	}
					
}


if($Proceso == "E")
{
	$Elimina = "DELETE FROM raf_web.datos_operacionales WHERE fecha='$Fecha'";
	$Elimina.= " AND hornada = $Hornada AND campo1='$etapa' AND tipo_report = 2 AND seccion_report = '$Seccion'";
	mysql_query($Elimina);
					
	$Valores = '?Proceso=M&Hornada='.substr($Hornada,6,4).'&Anito='.$Anito.'&MesJ='.$MesJ;
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmPrincipal.action = 'raf_report_operacional02.php".$Valores."';";
	echo "window.opener.document.FrmPrincipal.submit();";
	echo "window.close();";										 	
	echo "</script>";

}


if($Proceso == "G")
{
	$Elimina = "DELETE FROM raf_web.datos_operacionales WHERE fecha='$Fecha'";
	$Elimina.= " AND hornada = $Hornada AND campo1='$etapa' AND tipo_report = 2 AND seccion_report = '$Seccion'";
	mysql_query($Elimina);

	$hora_ini = $hhIni.':'.$mmIni;
	$hora_ter = $hhTer.':'.$mmTer;
	$Ano = substr($Fecha,0,4);
	$Fecha_Ini = $Ano.'-'.$Mes.'-'.$Dia;
	$Insertar = "INSERT INTO raf_web.datos_operacionales (hornada,fecha,tipo_report,seccion_report,";
	$Insertar.= " campo1,campo2,campo3)";
	$Insertar.= " values($Hornada,'$Fecha','$Report','$Seccion','$etapa','$Unidades','$Peso')";	
	mysql_query($Insertar);
	$Valores = '?Proceso=M&Hornada='.substr($Hornada,6,4).'&Anito='.$Anito.'&MesJ='.$MesJ;
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmPrincipal.action = 'raf_report_operacional02.php".$Valores."';";
	echo "window.opener.document.FrmPrincipal.submit();";
	echo "window.close();";										 	
	echo "</script>";
}

?>
<html>
<head>
<title>Ingreso de Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Calcula()
{
	var f = document.FrmPopUp;

	f.Total.value = f.PrecipitadoCu.value * 1 + f.OtrosCirc.value * 1; 
}

function Proceso(opc)
{
	var f = document.FrmPopUp;
	
	switch (opc)
	{
		case "G":
		    if(f.etapa.value == -1)			
			{
				alert("Debe Seleccionar Producto")
				f.etapa.focus();
				return
			}
			f.action = "raf_ing_popup6.php?Proceso=G";
			f.submit();
			break							

		case "B":
		    if(f.etapa.value == -1)			
			{
				alert("Debe Seleccionar Producto")
				f.etapa.focus();
				return
			}
			f.action = "raf_ing_popup6.php?Proceso=B";
			f.submit();
			break							

		case "E":
		    if(f.etapa.value == -1)			
			{
				alert("Debe Seleccionar Producto")
				f.etapa.focus();
				return
			}
			f.action = "raf_ing_popup6.php?Proceso=E";
			f.submit();
			break							
	
		case "S":
			document.location = "../principal/sistemas_usuario.php?CodSistema=12&Nivel=1&CodPantalla=10";										 	
			break							
	
	}

}

</script>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body class="TablaPrincipal">
<form name="FrmPopUp" method="post" action="">
<input name="Report" type="hidden" value="<? echo $Report?>">
<input name="Seccion" type="hidden" value="<? echo $Seccion?>">
<input name="Hornada" type="hidden" value="<? echo $Hornada?>">
<input name="Fecha" type="hidden" value="<? echo $Fecha?>">
  <table width="293" height="160" border="0" class="TablaPrincipal">
    <tr> 
      <td width="285" height="154" align="center">
        <table width="282" border="0" cellspacing="0" cellpadding="0" class="TablaDetalle">
          <tr> 
            <td>
			<?
				if($Seccion == "C2")
				{ 
          			echo "Anodos";
			    }
				if($Seccion == "C3")
				{ 
          			echo "Moldes";
			    }
			?>
			</td>
            <td> <select name="etapa">
                <?
				echo '<option value="-1" selected>Seleccionar</option>';
				if($Seccion == "C2")
				{ 
					if($etapa == "1")
						echo '<option value="1" selected>Comerciales</option>';
					else
						echo '<option value="1">Comerciales</option>';
					if($etapa == "2")
						echo '<option value="2" selected>Especiales</option>';
					else
						echo '<option value="2">Especiales</option>';
					if($etapa == "3")
						echo '<option value="3" selected>H. Madres</option>';
					else
						echo '<option value="3">H. Madres</option>';
				}
				if($Seccion == "C3")
				{ 
					if($etapa == "1")
						echo '<option value="1" selected>Placas</option>';
					else
						echo '<option value="1">Placas</option>';
					if($etapa == "2")
						echo '<option value="2" selected>H. Madres</option>';
					else
						echo '<option value="2">H. Madres</option>';
				}
			?>
              </select> <input type="button" name="BtnOk2" size="20" style="width:70px" value="Buscar" onClick="Proceso('B');"> 
            </td>
          </tr>
          <tr> 
            <td width="73">Unidades</td>
            <td width="206"> <input name="Unidades" size="10" value="<? echo $Unidades; ?>"> 
            </td>
          </tr>
          <tr> 
            <td>Peso</td>
            <td><input name="Peso" size="10" value="<? echo $Peso; ?>"></td>
          </tr>
        </table>
		<br>
        <br>	
			<table width="282" border="1" cellspacing="" cellpadding="0" class="TablaInterior">
				<tr>
				  <td width="366" align="center">
					<input type="button" name="BtnOk" size="20" style="width:70px" value="Grabar" onClick="Proceso('G');">
              <input type="button" name="BtnOk22" size="20" style="width:70px" value="Eliminar" onClick="Proceso('E');">
              <input type="button" name="BtnSalir" size="20"  style="width:70px" value="Salir" onClick="self.close()">
				  </td>	
				</tr>
		    </table>		
	  </td>	
   </tr>
</table>
 </form>
</body>
</html>
