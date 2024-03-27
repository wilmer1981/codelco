<?
	$CodigoDeSistema=12;
	$CodigoDePantalla=8;
?>
<html>
<head>
<title>Consultas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Ingresar_Datos()
{ 
var f = formulario;
	//alert (f.report.value);

	var Anito = f.Ano.value;
	var Mes   = f.Mes.value;
	if(f.Hornada.value == -1)
	{
		alert("Debe Escoger Hornada");
		f.Hornada.focus();
		return;
	}

	if(f.report.value == '1')
	{
		f.Letra.value = f.Letra.value.toUpperCase();		
		if (f.Letra.value == "")
		{
			alert("Debe Ingresar Letra");
			f.Letra.focus();
			return;
		}
		f.action = "raf_report_operacional01.php?Proceso=M&Ano=" + Anito + "&Mes=" + Mes;
		f.submit();
	}

	if(f.report.value == '2')
	{
		f.action = "raf_report_operacional03.php?Proceso=M&Anito=" + Anito +"&Mes=" + Mes;
		f.submit();
	}
		if(f.report.value == '3')
	{
		f.action = "raf_report_operacional02.php?Proceso=M&Anito=" + Anito +"&MesJ="+ Mes;
		f.submit();
	}

}

function Ejecutar_Web()
{ 
	var f = formulario;
	var Mes   = f.Mes.value;
	var Anito = f.Ano.value;
	if(f.Hornada.value == "-1")
	{
		alert("Debe Escoger Hornada");
		f.Hornada.focus();
		return;
	}

	if (f.report.value == "1")
	{
		f.Letra.value = f.Letra.value.toUpperCase();		
		if (f.Letra.value == "")
		{
			alert("Debe Ingresar Letra");
			f.Letra.focus();
			return;
		}
		f.action = "raf_report_operacional01.php?Ano=" + Anito + "&Mes=" + Mes;
		f.submit();
	}

	if (f.report.value == "2")
	{
		f.action = "raf_report_operacional03.php?Anito=" + Anito + "&Mes=" + Mes;
		f.submit();
	}
			if(f.report.value == '3')
	{
		f.action = "raf_report_operacional02.php?Anito=" + Anito + "&MesJ=" +Mes;
		f.submit();
	}

	
}

function Ejecutar_Excel()
{ 
var f = formulario;
var Hornada = f.Hornada.value;
var Anito   = f.Ano.value;
var Mes     = f.Mes.value;
	if(f.Hornada.value == -1)
	{
		alert("Debe Escoger Hornada");
		f.Hornada.focus();
		return	
	}
 
	if(f.report.value == '1')
	{
		f.action = "raf_report_operacional01_xls.php?Hornada=" + Hornada + "&Ano=" + Anito + "&Mes=" + Mes;
		f.submit();
	}

	if(f.report.value == '2')
	{
		f.action = "raf_report_operacional02_xls.php?Hornada=" + Hornada + "&Anito=" + Anito + "&Mes=" + Mes;
		f.submit();
	}
	if(f.report.value == '3')
	{
		f.action = "raf_report_operacional02_xls.php?Hornada=" + Hornada + "&Anito=" + Anito +"&Mes=" + Mes;
		f.submit();
	}

	
}

function Recarga()
{ 
var f=formulario;
    f.action ="raf_lista_report.php";
	f.submit();
}

function salir_menu()
{
	var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=12";
	f.submit();
}

function AsignaLetra()
{	
	var f=document.formulario;	
	f.Letra.value = f.LetraAux.value;
}
</script>
</head>

<body leftmargin="0" topmargin="2">
<form name="formulario" method="post" action="">
  <? include("../principal/encabezado.php")?>
  <? include("../principal/conectar_principal.php") ?> 
  
<table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
  <tr>
  	  <td height="313" align="center" valign="top"><p>&nbsp;</p>
        <table width="486" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
          <tr> 
            <td width="93"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Tipo 
              Report </td>
            <td colspan="3"> 
              <select name="report" onChange="Recarga()">
                <option value="-1" selected>Seleccionar</option>
                <!--<option value="0">-----------------</option>-->
                <?	
				if($report == "1")
	                echo'<option value="1" selected>Hornos Basculante y Reten</option>';
				else
	                echo'<option value="1">Hornos Basculante y Reten</option>';

				if($report == "2")
		            echo'<option value="2" selected>Horno Refino 1</option></option>';
				else
		            echo'<option value="2">Horno Refino 1</option></option>';
				if($report == "3")
		            echo'<option value="3" selected>Horno Refino 2</option></option>';
				else
		            echo'<option value="3">Horno Refino 2</option></option>';

    	    ?>
              </select>            </td>
          </tr>
          <tr> 
            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Fecha</td>
            <td colspan="2"><select name="Mes" style="width:90px;" onChange="Recarga()">
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
              </select> <select name="Ano" style="width:60px;" onChange="Recarga()">
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
            <td width="147"><!--<input type="button" name="BtnBuscar" value="Buscar" style="width:60" onClick="Recarga();">--></td>
          </tr>
          <tr> 
            <td width="93"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Hornadas</td>
            <td width="186">
<select name="Hornada" onChange="Recarga()">
  <option value="-1">Seleccionar</option>
  <?
				if(strlen($Mes) == 1)
					$Mes = '0'.$Mes;
				$Fecha = $Ano.'-'.$Mes;
				$Consulta = "SELECT distinct hornada FROM raf_web.movimientos";
				$Consulta.= " WHERE left(fecha_carga,7) = '$Fecha'";
				if($report == 1)
				{
					$Consulta.= " AND right(hornada,4) between '4000' and '4999'";
				}	
				elseif ($report == 2)
				{					
						$Consulta.= " AND right(hornada,4) between '1000' and '1999'";
				}
				elseif ($report == 3)
				{
						$Consulta.= " AND right(hornada,4) between '2000' and '3999'";
				}
				$Consulta.= " ORDER BY hornada DESC";
				//echo $Consulta;
				$rs = mysqli_query($link, $Consulta);
			
				while($Fila = mysql_fetch_array($rs))
				{
					if($Hornada == substr($Fila["hornada"],6,5))
						echo'<option value="'.substr($Fila["hornada"],6,5).'" selected>'.substr($Fila["hornada"],6,5).'</option>';
					else				
						echo'<option value="'.substr($Fila["hornada"],6,5).'">'.substr($Fila["hornada"],6,5).'</option>';
				}				
			?>
</select>
<?
	if ($report == 1)			
	{
		echo "<select name='LetraAux' onChange='AsignaLetra()'>";
		$Consulta = "select distinct  hornada, campo1 ";
		$Consulta.= " from raf_web.datos_operacionales ";
		$Consulta.= " where hornada = '".$Ano."".str_pad($Mes,2,"0",STR_PAD_LEFT)."".$Hornada."' ";
		$Consulta.= " and campo1 <> '' ";
		$Consulta.= " order by campo1 ";
		$Resp = mysqli_query($link, $Consulta);
		$i=1;
		$Letra = "";
		while ($Fila = mysql_fetch_array($Resp))
		{
			if ($i == 1)
				$Letra = $Fila["campo1"];
			$i++;
			if ($LetraAux == $Fila["campo1"])
			{
				echo "<option selected value='".$Fila["campo1"]."'>".$Fila["campo1"]."</option>\n";
				$Letra = $Fila["campo1"];
			}
			else
			{
				echo "<option value='".$Fila["campo1"]."'>".$Fila["campo1"]."</option>\n";
			}
		}
		echo "</select>";
	} 
?>			
			 
			</td>
            <td width="41" align="right">
<?
	if ($report == 1)
		echo "<img src='../principal/imagenes/left-flecha.gif' width='11' height='11'>Letra\n"; 
	else
		echo "&nbsp;";
?>             
            </td>
            <td>
<?
	if ($report == 1)
		echo "<input name='Letra' type='text' value='".$Letra."' size='10' maxlength='1'>\n"; 
	else
		echo "&nbsp;";
?>            			              
            </td>
          </tr>
        </table>  
		<p>&nbsp;</p>
        <p><br>
          <br>
          <br>
          <br>
          <br>
          <br>
        </p>
        <table width="700" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
		  <tr> 
            <td><div align="center">
              <input name="ejecutar_web" type="button"  value="Listar Web" style="width:80" onClick="Ejecutar_Web();">                
              <input name="ingresar" type="button"  value="Ingresar Datos" style="width:90" onClick="Ingresar_Datos();">
                <input name="ejecutar_excel" type="button"  value="Listar Excel" style="width:80" onClick="Ejecutar_Excel();">
                <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">			
              </div></td>
          </tr>
      </table>     </td>
  </tr>
</table>
 <? include("../principal/pie_pagina.php")?>  
		
</form>
</body>
</html>
