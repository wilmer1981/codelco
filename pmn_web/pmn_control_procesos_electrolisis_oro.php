<?php
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 17;
	include("../principal/conectar_pmn_web.php");
	if ($Consulta == "S")
	{
		$Mostrar = "S";
		$Dia = $IdDia;
		$Mes = $IdMes;
		$Ano = $IdAno;
		$TxtNumElectrolisis = $IdElectrolisis;
		
	}
	if ($Mostrar == "S")
	{
		$Consulta ="select * from pmn_web.control_procesos_electrolisis_oro";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Consulta.= " and num_electrolisis = '".$TxtNumElectrolisis."'";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$TxtCloroStockI = $Fila[stock_ini_cloruro];
			$TxtCloroProduccion = $Fila[produccion_cloruro];
			$TxtCloroStockF = $Fila[stock_final_cloruro]; 
			$TxtCatodosS= $Fila[catodos_secos];
			$TxtRestosAnodosS= $Fila[restos_anodos_secos];
			$TxtObs = $Fila[observaciones];
			$TxtCant = $Fila[cantidad_anodos];
			$TxtPeso = $Fila["peso"];
		}
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "R":
			f.action="pmn_carga_fusion_barro_aurifero.php";
			f.submit();
		break;
		case "G": //GRABAR			
			if (f.TxtNumElectrolisis.value == "")
			{
				alert("Debe Ingresar Num. Electrolisis");
				f.TxtNumElectrolisis.focus();
				return;
			}
			if (f.TxtObs.value == "")
			{
				alert("Debe ingresar Observacion");
				f.TxtObs.focus();
				return;
			}
			if (f.TxtCatodosS.value=="")
			{
				alert("Dese Ingresar Catodos Secos");
				f.TxtCatodosS.focus();
				return;
			}
			if (f.TxtRestosAnodosS.value=="")
			{
				alert("Dese Ingresar Restos Anodos Secos");
				f.TxtRestosAnodosS.focus();
				return;
			}
			if (f.TxtCloroStockI.value == "")
			{
				alert("Debe ingresar Stock Inicial de cloruro auricos");
				f.TxtCloroStockI.focus();
				return;
			}
			if (f.TxtCloroProduccion.value == "")
			{
				alert("Debe Produccion de Cloruro Auricos");
				f.TxtCloroProduccion.focus();
				return;
			}
			if (f.TxtCloroStockF.value == "")
			{
				alert("Debe ingresar Stock Final de Cloruro Auricos");
				f.TxtCloroStockF.focus();
				return;
			}
			
			f.action= "pmn_control_procesos_electrolisis_oro01.php?Proceso=G";
	 		f.submit();
			break;
		case "M": //MODIFICAR DETALLE
			if (f.TxtNumElectrolisis.value=="")
			{
				alert("No hay Electrolisis para Modificar")
				f.TxtNumElectrolisis.focus();
				return;
			}
			else
			{
			f.action= "pmn_control_procesos_electrolisis_oro01.php?Proceso=M";
	 		f.submit();
			}
			break;
		case "E": //ELIMINAR TODO
			var mensaje = confirm("�Seguro que desea Eliminar?");
			if (mensaje==true)
			{
				f.action= "pmn_control_procesos_electrolisis_oro01.php?Proceso=E";
	 			f.submit();
			}
			else
			{
				return;
			}
			break;
		case "B": //Consultar
			var URL = "pmn_control_procesos_electrolisis_oro02.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "N":
			f.action= "pmn_control_procesos_electrolisis_oro01.php?Proceso=N";
	 		f.submit();
		break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=108";
	 		f.submit();
			break;
	}

}
function TeclaPulsada (tecla) 
{ 
	var Frm=document.frmPrincipal;
	var teclaCodigo = event.keyCode; 
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 110))
	{
		if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
} 
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="769" border="0" class="TablaPrincipal">
    <tr>
      <td width="761" height="404">
<table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td height="30" colspan="3"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php
					$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
					$Resultado= mysqli_query($link, $Consulta);
					if ($Fila =mysqli_fetch_array($Resultado))
					{	
						echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
					}	  
					else
					{
						$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
						$Respuesta = mysqli_query($link, $Consulta);
						if ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
						}
					}
		  			?>
              </strong></font></font></td>
            <td colspan="2"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $Fecha_Hora ?> 
              </strong>&nbsp; <strong> 
              <?php
					if (!isset($FechaHora))
					{
						echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
						$FechaHora=date('Y-m-d H:i');
					}
					else
					{ 
						echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
					}
				  ?>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td width="105" height="30">Fecha:</td>
            <td colspan="2"> 
              <?php 
				if ($Mostrar == "S")
				{
					echo "<input type='hidden' name='Dia' value='".$Dia."'>\n";
					echo "<input type='hidden' name='Mes' value='".$Mes."'>\n";
					echo "<input type='hidden' name='Ano' value='".$Ano."'>\n";
					printf("%'02d",$Dia);
					echo "-";
					printf("%'02d",$Mes);
					echo "-";
					printf("%'04d",$Ano);
				}
				else
				{
					echo "<select name='Dia' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($Dia))
						{
							if ($i == $Dia)
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
				  echo "</select> <select name='Mes' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($Mes))
						{
							if ($i == $Mes)
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
				  echo "</select> <select name='Ano' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($Ano))
						{
							if ($i == $Ano)
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
					echo "</select>\n";
				}
			?>
            </td>
            <td width="176"> <div align="right"> 
                <input name="ver" type="button" style="width:70" value="Consultar" onClick="Proceso('B');">
              </div></td>
            <td width="114"><input name="BtnNuevo" type="button" id="BtnNuevo" style="width:70" onClick="Proceso('N');" value="Nuevo"></td>
          </tr>
          <tr> 
            <td width="105">N&deg;.Electrolisis:</td>
            <td width="228"> 
              <?php
				if ($Mostrar == "S")
				{
					echo $TxtNumElectrolisis;
					echo "<input name='TxtNumElectrolisis' type='hidden' value='".$TxtNumElectrolisis."'>\n";
				}
				else
				{
              		echo "<input name='TxtNumElectrolisis' type='text' value='".$TxtNumElectrolisis."'>\n";
				}
			  ?>
            </td>
            <td width="105">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td>Observaci&oacute;n:</td>
            <td colspan="4"><input name="TxtObs" type="text" id="TxtObs" value="<?php echo $TxtObs;?>" size="80" maxlength="80"></td>
          </tr>
        </table>
		  
        <br>
        <br>
        <table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="2"><font size="1"><font size="1"><font size="2">Produccion 
              Catodos y Restos de Anodos</font></font></font></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><font size="1"><font size="1">Cant de Anodos</font></font></td>
            <td><input name="TxtCant" type="text" id="TxtCant" onKeyDown="TeclaPulsada()" value="<?php  echo str_replace(".",",",$TxtCant);  ?>"></td>
            <td width="99">&nbsp;</td>
            <td width="178">Peso</td>
            <td width="123"><input name="TxtPeso" type="text" id="TxtPeso2" onKeyDown="TeclaPulsada()" value="<?php  echo str_replace(".",",",$TxtPeso);  ?>"></td>
            <td width="92">&nbsp;</td>
          </tr>
          <tr> 
            <td width="110">Catodos Secos</td>
            <td width="120"><input name="TxtCatodosS" type="text" onKeyDown="TeclaPulsada()" value="<?php  echo str_replace(".",",",$TxtCatodosS);  ?>"></td>
            <td>Kilos</td>
            <td>Restos de Anodos Secos</td>
            <td><input name="TxtRestosAnodosS" type="text" onKeyDown="TeclaPulsada()" value="<?php  echo str_replace(".",",",$TxtRestosAnodosS);  ?>"></td>
            <td>Kilos</td>
          </tr>
        </table>
        &nbsp; <table width="761" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td height="16" colspan="4"> <div align="left">Cloruros Auricos</div></td>
            <td width="235">&nbsp;</td>
            <td width="171"><div align="left"></div></td>
            <td width="226">&nbsp;</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td colspan="4"><div align="left">Stock Inicial</div></td>
            <td><div align="left"> 
                <input name="TxtCloroStockI" type="text" id="TxtCloroStockI2" onKeyDown="TeclaPulsada()" style="width:224px" value="<?php echo str_replace(".",",",$TxtCloroStockI);  ?>">
              </div></td>
            <td><div align="left"></div></td>
            <td><div align="left"> </div></td>
          </tr>
          <tr align="center" valign="middle"> 
            <td colspan="4"><div align="left">Produccion</div></td>
            <td><div align="left"> 
                <input name="TxtCloroProduccion" type="text" id="TxtCloroProduccion2" onKeyDown="TeclaPulsada()" style="width:224px" value="<?php  echo  str_replace(".",",",$TxtCloroProduccion);   ?>">
              </div></td>
            <td><div align="left"></div></td>
            <td><div align="left"> </div></td>
          </tr>
          <tr align="center" valign="middle"> 
            <td colspan="4"><div align="left">Stock Final</div></td>
            <td><div align="left"> 
               <?php
			  // $TxtCloroStockF=$TxtCloroProduccion+TxtCloroStockI;
			   
			   ?>
			    <input name="TxtCloroStockF" type="text" onKeyDown="TeclaPulsada()" style="width:224px" value="<?php echo str_replace(".",",",$TxtCloroStockF);  ?>">
              </div></td>
            <td><div align="left"></div></td>
            <td>&nbsp;</td>
          </tr>
        </table> 
        <table width="760" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td width="750"><div align="center">
                <input name="BtnGrabar2" type="button" value="Grabar" style="width:60px;" onClick="Proceso('G');">
                &nbsp; 
                <input name="BtnModificar2" type="button" value="Modificar" style="width:60px;" onClick="Proceso('M');">
                &nbsp; 
                <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="Proceso('E');">
                &nbsp; 
                <input name="BtnSalir" type="button" id="BtnSalir" style="width:60px;" onClick="Proceso('S');" value="Salir">
              </div></td>
          </tr>
        </table>
        <br>
      </td>
  </tr>
</table>

<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
