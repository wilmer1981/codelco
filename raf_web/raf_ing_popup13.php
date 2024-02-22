<?
include("../principal/conectar_raf_web.php");

if(strlen($Mes) == 1)
	$Mes = '0'.$Mes;
if(strlen($Dia) == 1)
	$Dia = '0'.$Dia;

if($Proc == "E")
{
	$Elimina = "DELETE FROM raf_web.datos_operacionales ";
	$Elimina.= " WHERE fecha='".$Fecha."'";
	$Elimina.= " AND hornada = '".$Hornada."'";	
	$Elimina.= " AND tipo_report = 1 ";
	$Elimina.= " AND seccion_report = '".$Seccion."'";
	$Elimina.= " AND campo1='".$Letra."' ";
	$Elimina.= " AND campo2 = '".$Valor."'";
	mysql_query($Elimina);
}


if($Proc == "G")
{
	$Peso = str_replace(",",".",$Unidades) * str_replace(",",".",$Peso);
	$Ano = substr($Fecha,0,4);
	$Insertar = "INSERT INTO raf_web.datos_operacionales ";
	$Insertar.= " (hornada,fecha,tipo_report,seccion_report,";
	$Insertar.= " campo1,campo2,campo3,campo4)";
	$Insertar.= " values('".$Hornada."','".$Fecha."','1','".$Seccion."','".strtoupper($Letra)."','".$TipoMolde."','".str_replace(",",".",$Unidades)."','".str_replace(",",".",$Peso)."')";	
	mysql_query($Insertar);	
}
?>
<html>
<head>
<title>Ingreso de Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Proceso(opc)
{
	var f = document.FrmPopUp;
	
	switch (opc)
	{
		case "G":
		    if(f.TipoMolde.value == "S")			
			{
				alert("Debe Seleccionar Tipo de Molde o Placa")
				f.TipoMolde.focus();
				return
			}
			f.action = "raf_ing_popup13.php?Proc=G&LetraC=" + f.Letra.value;
			f.submit();
			break							
		case "E":
			var Valor = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkElim" && f.elements[i].checked)
					Valor = f.elements[i].value;
			}
		    if (Valor == "")			
			{
				alert("Debe Seleccionar un Tipo Molde para Eliminar");
				return
			}
			f.action = "raf_ing_popup13.php?Valor=" +  Valor + "&Proc=E&LetraC=" + f.Letra.value;
			f.submit();
			break							
		case "R":
			f.action = "raf_ing_popup13.php?LetraC=" + f.Letra.value;
			f.submit();
			break;
		case "S":
			window.opener.document.FrmPrincipal.action = "raf_report_operacional01.php?Proceso=M&Hornada=" + f.Hornada.value.substring(6) +"&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			window.opener.document.FrmPrincipal.submit();
			window.close();
			break							
	
	}

}

</script>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body class="TablaPrincipal">
<form name="FrmPopUp" method="post" action="">
<input name="Report" type="hidden" value="<? echo $Report ?>">
<input name="Seccion" type="hidden" value="<? echo $Seccion ?>">
<input name="Hornada" type="hidden" value="<? echo $Hornada ?>">
<input name="Letra" type="hidden" value="<? echo $LetraC ?>">
<input name="Fecha" type="hidden" value="<? echo $Fecha ?>">
<input type="hidden" name="Ano" value="<? echo $Ano; ?>">
<input type="hidden" name="Mes" value="<? echo $Mes; ?>">
  
        <table width="300" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
         <tr align="center"> 
            <td colspan="2" class="ColorTabla02"><strong>HORNADA:</strong> <? echo substr($Hornada,-4)."-".$LetraC; ?></td>
          </tr>
          <tr>
            <td colspan="2"><strong>Produccion de Moldes:</strong></td>
          </tr>
          <tr> 
            <td>
			Tipo Molde </td>
            <td> <select name="TipoMolde" onChange="Proceso('R')">
			<option value="S">SELECCIONAR</option>
<?
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '12006' order by cod_subclase ";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		if ($TipoMolde == $Fila["cod_subclase"])
			echo "<option selected value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
	}
?>
              </select>  
            </td>
          </tr>
          <tr> 
            <td width="73">
Unidades	
	</td>
            <td width="206"> <input name="Unidades" size="10" value="<? echo $Unidades; ?>"></td>
          </tr>
          <tr> 
            <td>
Peso	Est.			
			</td>
<?			
$Consulta = "select * from proyecto_modernizacion.sub_clase ";
$Consulta.= " where cod_clase='12006' and cod_subclase = '".$TipoMolde."'";
$Resp = mysql_query($Consulta);
if ($Fila = mysql_fetch_array($Resp))
{
	$Peso = $Fila["valor_subclase1"];
}
else
{
	$Peso = 0;
}
?>			
            <td><input name="Peso" readonly size="10" value="<? echo $Peso; ?>"> 
            (Peso Referencial) </td>
          </tr>
          <tr align="center">
            <td height="30" colspan="2"><input type="button" name="BtnOk" size="20" style="width:70px" value="Grabar" onClick="Proceso('G')">
              <input type="button" name="BtnOk22" size="20" style="width:70px" value="Eliminar" onClick="Proceso('E')">
              <input type="button" name="BtnSalir" size="20"  style="width:70px" value="Salir" onClick="Proceso('S')"></td>
          </tr>
  </table>
        <br>
        <table width="300"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr class="ColorTabla01">
            <td width="51">Mod/Elim</td>
            <td width="163">Tipo</td>
            <td width="40">Cant.</td>
            <td width="69">Peso</td>
          </tr>
<?		  
$Consulta = "select * from raf_web.datos_operacionales t1 inner join proyecto_modernizacion.sub_clase t2 ";
$Consulta.= " on t1.campo2 = t2.cod_subclase and t2.cod_clase='12006'";
$Consulta.= " where t1.hornada='".$Hornada."'";
$Consulta.= " and t1.campo1='".$LetraC."'";
$Consulta.= " and t1.tipo_report='1'";
$Consulta.= " and t1.seccion_report='10'";
$Consulta.= " order by t1.campo2";
$Resp = mysql_query($Consulta);
$TotalCant=0;
$TotalPeso=0;
while ($Fila = mysql_fetch_array($Resp))
{
	echo "<tr>\n";
	echo "<td><input name='ChkElim' type='radio' value='".$Fila["cod_subclase"]."'></td>\n";
	echo "<td>".$Fila["nombre_subclase"]."</td>\n";
	echo "<td align='center'>".$Fila["campo3"]."</td>\n";
	echo "<td align='right'>".$Fila["campo4"]."</td>\n";
	echo "</tr>\n";
	$TotalCant = $TotalCant + $Fila["campo3"];
	$TotalPeso = $TotalPeso + $Fila["campo4"];	
}
?>		  
          <tr class="ColorTabla02">
            <td colspan="2"><strong>TOTAL</strong></td>
            <td align="center"><? echo number_format($TotalCant,0,",",".") ?></td>
            <td align="right"><? echo number_format($TotalPeso,0,",",".") ?></td>
          </tr>
        </table>
</form>
</body>
</html>
