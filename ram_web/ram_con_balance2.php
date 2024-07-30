<?
	$CodigoDeSistema = 7;
	$CodigoDePantalla =15; 
	include("../principal/conectar_principal.php")
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "C":
			if(f.TipoMovimiento.value=="S")
			{
				alert("Debe Seleccionar Tipo de Movimiento");
				f.TipoMovimiento.focus();
				return;
			}
			f.action = "ram_con_balance_web2.php";				
			f.submit();		
			break;		
		case "E":
			if(f.TipoMovimiento.value=="S")
			{
				alert("Debe Seleccionar Tipo de Movimiento");
				f.TipoMovimiento.focus();
				return;
			}
			f.action = "ram_con_balance_excel.php";				
			f.submit();		
			break;		
		case "S":
			f.action = "ram_generador_consultas_usuarios2.php";
			f.submit();		
			break;
	}
}
function Recarga()
{
	var f = document.frmPrincipal;
	f.action = "ram_con_balance.php";
	f.submit();
}
</script>
</head>

<body leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<? include("../principal/encabezado.php"); ?>
  <table width="770" height="315" border="0" cellpadding="3" cellspacing="3" class="TablaPrincipal">
    <tr>
      <td valign="top">
<table width="76%" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="27%">TIPO MOVIMIENTO:</td>
            <td width="73%"><select name="TipoMovimiento" id="TipoMovimiento" style="width:250px">
                <option value="T">Balance Completo</option>
                <?
				$Consulta = "select * from proyecto_modernizacion.sub_clase ";
				$Consulta.= " where cod_clase = '7002'";
				$Consulta.= " order by cod_subclase";
				$Respuesta = mysql_query($Consulta);
				while ($Fila = mysql_fetch_array($Respuesta))
				{
					if ($TipoBalance == $Fila["cod_subclase"])
						echo "<option value='".$Fila["valor_subclase1"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";
					else
						echo "<option value='".$Fila["valor_subclase1"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";
				}
			?>
              </select></td>
          </tr>
          <tr align="center"> 
            <td colspan="2">
			<?
				if (!isset($Agrup) || $Agrup=="C")				 
				{
					echo "<input name='Agrup' type='radio' value='C' checked>VER POR CONJUNTO&nbsp;\n";             
	                echo "<input name='Agrup' type='radio' value='P'>VER POR PROVEEDOR\n";  								     
				}
				else
				{
					echo "<input name='Agrup' type='radio' value='C'>VER POR CONJUNTO&nbsp;\n";             
	                echo "<input name='Agrup' type='radio' value='P' checked>VER POR PROVEEDOR\n";  								     
				}
			?>
			</td>
          </tr>
          <tr> 
            <td width="27%">
			<?
				if (!isset($Acum) || $Acum=="D")				 				
					echo "<input name='Acum' type='radio' value='D' checked>VER EL DIA\n";            
				else
					echo "<input name='Acum' type='radio' value='D'>VER EL DIA\n";            
			?>
			</td>
            <td width="73%" rowspan="2"><select name="Dia" style="width:60px">
                <?
				for ($i = 1; $i <= 31; $i++)
				{
					if (isset($Dia))
					{
						if ($i == $Dia)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("j"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
                        </select>
              <select name="Mes" id="select5" style="width:110px">
                <?
			  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				for ($i = 1; $i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($i == $Mes)
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
				}
			?>
                            </select>
              <select name="Ano" style="width:70px">
                <?
				for ($i = (date("Y")-1); $i <= (date("Y")+1); $i++)
				{
					if (isset($Ano))
					{
						if ($i == $Ano)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
                            </select></td>
          </tr>
          <tr>
            <td>
			<?
				if ($Acum=="A")				 				
					echo "<input name='Acum' type='radio' value='A' checked>VER ACUMULADO AL\n";            
				else
					echo "<input name='Acum' type='radio' value='A'>VER ACUMULADO AL\n";            
			?></td>
          </tr>
          <tr align="center">
            <td colspan="2"><input name="ChkPMineros" type="checkbox" id="ChkPMineros" value="S" checked>
              PROD. MINEROS 
                 <input name="ChkCirculantes" type="checkbox" id="ChkCirculantes" value="S" checked>
CIRCULANTES</td>
          </tr>
        </table>
      <br>      <table width="76%" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr>
          <td width="27%" height="75" align="center">
            <table width='190' border='1' cellpadding='2' cellspacing='0' class="TablaInterior">
              <tr>
                  <td width='68'>LEYES</td>
                  <td width='102' align='center'><?
				if (($FinoLeyes == "L"))
					echo "<input type='radio' checked name='FinoLeyes' value='L'></td>\n";
				else
					echo "<input type='radio' name='FinoLeyes' value='L'></td>\n";
				?>
</td>
              </tr>
              <tr>
                <td>FINOS</td>
                <td align='center'><?
				if ($FinoLeyes == "F" || (!isset($FinoLeyes)))
					echo "<input name='FinoLeyes' checked type='radio' value='F'>\n";
				else
					echo "<input name='FinoLeyes' type='radio' value='F'>\n";		
				?>                  
              </tr>
          </table></td>
        </tr>
      </table>      <br>      <table width="76%" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr>
          <td width="100%" align="center"><input name="BtnConsultar2" type="button" value="Consultar" style="width:70px" onClick="Proceso('C');">
              <input name="BtnExcel2" type="button" id="BtnExcel2" style="width:70px" onClick="Proceso('E');" value="Excel">
              <input name="BtnSalir2" type="button" value="Salir" style="width:70px" onClick="Proceso('S');"></td>
        </tr>
      </table></td>
  </tr>
</table>
<? include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>
