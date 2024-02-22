<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 20;
	include("../principal/conectar_pmn_web.php");
	include("pmn_funciones.php");		
	
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f= document.frmPrincipal;
	switch (opt)
	{
		case "C":
			switch (f.TipoReport.value)
			{
				case "1":
					f.action = "pmn_con_prod_barro_anodico.php";
					f.submit();
					break;
				case "2":
					f.action = "pmn_con_control_hornadas.php";
					f.submit();
					break;				
				case "3":
					f.action = "pmn_con_beneficio_barro.php";
					f.submit();
					break;				
				case "4":
					f.action = "pmn_con_carga_electrolisis.php";
					f.submit();
					break;
				case "6":
					f.action = "pmn_con_traspaso_restos_anodos.php ";
					f.submit();
					break;
				case "7":
					f.action = "pmn_con_carga_barro_aurifero_crudo.php  ";
					f.submit();
					break;
				case "8":
					f.action = "pmn_con_embarque_barras_oro.php  ";
					f.submit();
					break;
				case "9":
					f.action = "pmn_con_embarque_plata.php";
					f.submit();
					break;
				case "10":
					f.action = "pmn_con_electrolisis_oro.php  ";
					f.submit();
					break;
				case "11":
					f.action = "pmn_con_electrolisis_plata.php";
					f.submit();
					break;
				case "12":
					f.action = "pmn_con_horno_trof.php";
					f.submit();
					break;
				case "13":
					f.action = "pmn_con_lixiviacion_barro_aurifero.php";
					f.submit();
					break;
				case "14":
					f.action = "pmn_con_existencia_calcina.php";
					f.submit();
					break;
				case "15":
					f.action = "pmn_con_selenio.php";
					f.submit();
					break;
				case "16":
					f.action = "pmn_con_teluro.php";
					f.submit();
					break;
				case "17":
					f.action = "pmn_con_platino_paladio.php";
					f.submit();
					break;
				case "18":
					f.action = "pmn_con_escoria_fusion.php";
					f.submit();
					break;
				case "19":
					f.action = "pmn_con_sulfato_cu.php";
					f.submit();
					break;																																												
			}
			break;
		case "S":
			f.action = "pmn_principal_consulta.php";
			f.submit();
			break;
		case "R":
			f.action = "pmn_consulta_report.php";
			f.submit();
			break;
	
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td ><img src="archivos/images/interior/esq3.png"/></td>
      <td colspan="3" background="archivos/images/interior/arriba.png"></td>
      <td width="2%" align="right" background="archivos/images/interior/derecho.png"><img src="archivos/images/interior/esq2.png" /></td>
    </tr>
    <tr>
      <td width="1%" background="archivos/images/interior/izquierdo.png">&nbsp;</td>
      <td width="19%"><img src="archivos/logo_sup.jpeg"/></td>
      <td width="74%" align="center"  bgcolor="#F7F2EB" class="formulario" style="border-bottom-color:#FFFFFF; border-bottom-style:double; border-bottom-width:thin;">CONSULTAS - PLAMEN </td>
      <td width="4%" align="right" bgcolor="#F7F2EB" style="border-bottom-color:#FFFFFF; border-bottom-style:double; border-bottom-width:thin;"><a href="JavaScript:Salir('')" class="LinkPestana" ></a><a href="JavaScript:SalirRpt('')" class="LinkPestana" ></a></td>
      <td width="2%" align="right" background="archivos/images/interior/derecho.png">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5"><table width="100%"  border="0"  align="center" cellpadding="0"  cellspacing="0" bgcolor="#F7F2EB">
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td colspan="5" ><img src="archivos/images/interior/transparent.gif" width="4" /></td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td colspan="5" rowspan="4" align="center" valign="top"><!--PANTALLA PROD EXTERNO-->
              <table width="100%" border="0" cellspacing="1" cellpadding="1" class="TituloCabeceraOz">
                <tr>
                  <td height="316" valign="top"><br>
                      <table width="716" border="0" align="center" cellpadding="1" cellspacing="1" class="TablaInterior">
                        <tr>
                          <td class="titulo_azul">Tipo Report</td>
                          <td colspan="3"><select name="TipoReport" style="width:300px;" onChange="Proceso('R');">
                              <option value="S">Seleccionar</option>
                              <?php
								$Consulta = "select * from proyecto_modernizacion.sub_clase ";
								$Consulta.= " where cod_clase = '6002' and cod_subclase not in('14') and valor_subclase1 ='0' order by cod_subclase";
								$Respuesta = mysqli_query($link, $Consulta);
								while ($Row = mysqli_fetch_array($Respuesta))
								{
									if ($TipoReport == $Row["cod_subclase"])
										echo "<option selected value='".$Row["cod_subclase"]."'>".$Row["nombre_subclase"]."</option>\n";
									else
										echo "<option value='".$Row["cod_subclase"]."'>".$Row["nombre_subclase"]."</option>\n";
								}
							?>
                          </select></td>
                        </tr>
                        <tr>
                          <td class="titulo_azul">Fecha Inicio</td>
                          <td><select name="DiaIniCon" style="width:50px;">
                              <?php
	for ($i=1;$i<=31;$i++)
	{
		if (isset($DiaIniCon))
		{
			if ($i == $DiaIniCon)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if ($i == $DiaActual)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
	?>
                            </select>
                              <select name="MesIniCon" style="width:90px;">
                                <?php
	 for ($i=1;$i<=12;$i++)
	{
		if (isset($MesIniCon))
		{
			if ($i == $MesIniCon)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
		else
		{
			if ($i == $MesActual)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
	}
	  ?>
                              </select>
                              <select name="AnoIniCon" style="width:60px;">
                                <?php
	 for ($i=2002;$i<=date("Y");$i++)
	{
		if (isset($AnoIniCon))
		{
			if ($i == $AnoIniCon)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if ($i == $AnoActual)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
	?>
                            </select></td>
                          <td class="titulo_azul">Fecha Termino</td>
                          <td><select name="DiaFinCon" style="width:50px;">
                              <?php
	for ($i=1;$i<=31;$i++)
	{
		if (isset($DiaFinCon))
		{
			if ($i == $DiaFinCon)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if ($i == $DiaActual)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
	?>
                            </select>
                              <select name="MesFinCon" style="width:90px;">
                                <?php
	  	for ($i=1;$i<=12;$i++)
		{
			if (isset($MesFinCon))
			{
				if ($i == $MesFinCon)
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
			else
			{
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
		}
		?>
                              </select>
                              <select name="AnoFinCon" style="width:60px;">
                                <?php
	  	for ($i=2002;$i<=date("Y");$i++)
		{
			if (isset($AnoFinCon))
			{
				if ($i == $AnoFinCon)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == $AnoActual)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
                            </select></td>
                        </tr>
                        <?php
			
			if (($TipoReport!='1') && ($TipoReport!='8')&&($TipoReport!='9'))
			{
				echo "<tr>"; 
				echo "<td>Turno</td>";
				echo "<td>";
				echo "<select name='Turno' style='width:90px'>";
				echo "<option value='S'>Todos</option>\n";				
				$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Row["cod_subclase"] == $Turno)
						echo "<option selected value='".strtoupper($Row["cod_subclase"])."'>".strtoupper($Row["nombre_subclase"])."</option>";
					else 	echo "<option value='".strtoupper($Row["cod_subclase"])."'>".strtoupper($Row["nombre_subclase"])."</option>";
				}
				echo "</select>";
				 echo "</td>";
				 echo "<td>&nbsp;</td>";
				 echo "<td>&nbsp;</td>";
				 echo "</tr>";
      		}	
		?>
                      </table>
                    <br>
                      <table width="620" border="0" align="center">
                        <tr>
                          <td align="center"><input type="button" name="BtnConsultar" value="Consultar" style="width:70px" onClick="Proceso('C');">
                            &nbsp;
                            <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
                          </td>
                        </tr>
                    </table></td>
                </tr>
              </table>
              <!--TERMINO-->
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td width="12"><img src="archivos/images/interior/esq1.png"/></td>
            <td height="1" colspan="5" background="archivos/images/interior/abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /><?php echo "<font color='#FFFFFF' SIZE='2'>".$CookieRut."  -  ".NomUsuario($CookieRut)."&nbsp;&nbsp;-&nbsp;&nbsp;".NomPerfil($CookieRut)."&nbsp;</SPAN>";?></td>
            <td width="18"><img src="archivos/images/interior/esq4.png"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
