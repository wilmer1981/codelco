<?php 
	include("../principal/conectar_imp_web.php");
	//echo "ARREGLADA";
	$CookieRut = $_COOKIE["CookieRut"];

	if(isset($_GET["TipoProd"])){
		$TipoProd = $_GET["TipoProd"];
	}else {
		$TipoProd = "";
	}
	if(isset($_GET["RutProv"])){
		$RutProv = $_GET["RutProv"];
	}else {
		$RutProv = "";
	}


	$Consulta = "SELECT * from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema='5'";
	$Resp=mysqli_query($link, $Consulta);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$NivelUsuario=$Fila["nivel"];
	}
	else
	{
		$NivelUsuario=4;
	}
	//CONSULTO PARA SABER QUE TIPO DE CONTROL DE LEYES SE APLICARA A ESTE PROVEEDOR
	//PARTICULAR, POR PRODUCTO O GENERAL
	$Encontro = false;
	//1.- CONSULTO POR LIMITES DE PROVEEDOR
	$Consulta = "SELECT * from limites ";
	$Consulta.= " WHERE ";
	$Consulta.= " tipo_producto = '".$TipoProd."'";
	$Consulta.= " AND rut_proveedor LIKE '%".$RutProv."'";
	$resLimite = mysqli_query($link, $Consulta);
	if ($rowLimite = mysqli_fetch_array($resLimite))
	{
		$Encontro = true;
		$Indice = 1;
	}
	if ($Encontro == false)
	{
		//2.- CONSULTO POR LIMITES DE PRODUCTO
		$Consulta = "SELECT * from limites ";
		$Consulta.= " WHERE ";
		$Consulta.= " tipo_producto = '".$TipoProd."'";
		$Consulta.= " AND rut_proveedor = '000000000'";
		$resLimite = mysqli_query($link, $Consulta);
		if ($rowLimite = mysqli_fetch_array($resLimite))
		{
			$Encontro = true;
			$Indice = 2;
		}
	}
	if ($Encontro == false)
	{
			$Encontro = true;
			$Indice = 3;
	}
	include("../principal/cerrar_imp_web.php");
	include("../principal/conectar_principal.php");
	//------------------------------------------------------------------------------	
	$sql = "SELECT cod_leyes, abreviatura ";
	$sql.= " FROM leyes ";
	$sql.= " ORDER BY cod_leyes";
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result))
	{
		$valor = intval($row["cod_leyes"]);
		$Leyes[$valor][0] = $row["abreviatura"];
		switch ($valor)
		{
			case 1:
				$Leyes[$valor][1] = "(%)";
				break;
			case 2:
				$Leyes[$valor][1] = "(%)";
				break;
			case 3:
				$Leyes[$valor][1] = "(%)";
				break;
			case 4:
				$Leyes[$valor][1] = "(g/t)";
				break;
			case 5:
				$Leyes[$valor][1] = "(g/t)";
				break;
			case 6:
				$Leyes[$valor][1] = "(%)";
				break;
			case 7:
				$Leyes[$valor][1] = "(%)";
				break;
			case 8:
				if (($TipoProd == "007") || ($TipoProd == "003"))
				{
					$Leyes[$valor][1] = "(%)";
				}
				else
				{
					$Leyes[$valor][1] = "(ppm)";
				}
				break;
			case 9:
				if (($TipoProd == "007") || ($TipoProd == "003"))
				{
					$Leyes[$valor][1] = "(%)";
				}
				else
				{
					$Leyes[$valor][1] = "(ppm)";
				}
				break;
			case 10:
				if (($TipoProd == "007") || ($TipoProd == "003"))
				{
					$Leyes[$valor][1] = "(%)";
				}
				else
				{
					$Leyes[$valor][1] = "(ppm)";
				}
				break;
			case 11:
				$Leyes[$valor][1] = "(%)";
				break;
			case 12:
				$Leyes[$valor][1] = "(%)";
				break;
			case 13:
				$Leyes[$valor][1] = "(%)";
				break;
			case 14:
				$Leyes[$valor][1] = "(%)";
				break;
			case 15:
				$Leyes[$valor][1] = "(%)";
				break;
			case 16:
				$Leyes[$valor][1] = "(%)";
				break;
			case 17:
				$Leyes[$valor][1] = "(%)";
				break;
			case 18:
				$Leyes[$valor][1] = "(%)";
				break;
			case 19:
				$Leyes[$valor][1] = "(%)";
				break;
			case 20:
				$Leyes[$valor][1] = "(%)";
				break;
			case 21:
				$Leyes[$valor][1] = "(%)";
				break;
			case 22:
				$Leyes[$valor][1] = "(%)";
				break;
			case 23:
				$Leyes[$valor][1] = "(%)";
				break;
			case 24:
				$Leyes[$valor][1] = "(%)";
				break;
			case 25:
				$Leyes[$valor][1] = "(%)";
				break;
			case 26:
				if (($TipoProd == "007") || ($TipoProd == "003"))
				{
					$Leyes[$valor][1] = "(%)";
				}
				else
				{
					$Leyes[$valor][1] = "(ppm)";
				}
				break;
			case 27:
				$Leyes[$valor][1] = "(ppm)";
				break;
			case 28:
				$Leyes[$valor][1] = "(%)";
				break;
			case 29:
				$Leyes[$valor][1] = "(%)";
				break;
			case 30:
				$Leyes[$valor][1] = "(ppm)";
				break;
			case 31:
				$Leyes[$valor][1] = "(ppm)";
				break;
			case 32:
				$Leyes[$valor][1] = "(%)";
				break;
			case 33:
				$Leyes[$valor][1] = "(%)";
				break;
			case 34:
				$Leyes[$valor][1] = "(ppm)";
				break;
			case 35:
				$Leyes[$valor][1] = "(%)";
				break;
			case 36:
				$Leyes[$valor][1] = "(ppm)";
				break;
			case 37:
				$Leyes[$valor][1] = "(%)";
				break;
			case 38:
				$Leyes[$valor][1] = "(%)";
				break;
			case 39:
				if (($TipoProd == "007") || ($TipoProd == "003"))
				{
					$Leyes[$valor][1] = "(%)";
				}
				else
				{
					$Leyes[$valor][1] = "(ppm)";
				}
				break;
			case 40:
				if ($TipoProd == "017")
				{
					$Leyes[$valor][1] = "(ppm)";
				}
				else
				{
					$Leyes[$valor][1] = "(%)";
				}				
				break;
			case 41:
				$Leyes[$valor][1] = "(ppm)";
				break;
			case 42:
				$Leyes[$valor][1] = "(%)";
				break;
			case 43:
				$Leyes[$valor][1] = "(%)";
				break;
			case 44:
				if ($TipoProd == "017")
				{
					$Leyes[$valor][1] = "(ppm)";
				}
				else
				{
					$Leyes[$valor][1] = "(%)";
				}				
				break;
			case 45:
				$Leyes[$valor][1] = "(%)";
				break;
			case 46:
				$Leyes[$valor][1] = "(%)";
				break;
			case 47:
				$Leyes[$valor][1] = "(%)";
				break;
			case 48:
				if ($TipoProd == "017")
				{
					$Leyes[$valor][1] = "(ppm)";
				}
				else
				{
					$Leyes[$valor][1] = "(%)";
				}				
				break;
			case 49:
				$Leyes[$valor][1] = "(%)";
				break;
			case 50:
				$Leyes[$valor][1] = "(%)";
				break;
			case 51:
				$Leyes[$valor][1] = "(%)";
				break;
			case 52:
				$Leyes[$valor][1] = "(%)";
				break;
			case 53:
				$Leyes[$valor][1] = "(%)";
				break;
			case 54:
				$Leyes[$valor][1] = "(%)";
				break;
			case 55:
				$Leyes[$valor][1] = "(%)";
				break;
			case 56:
				$Leyes[$valor][1] = "(%)";
				break;
			case 57:
				$Leyes[$valor][1] = "(%)";
				break;
			case 58:
				$Leyes[$valor][1] = "(%)";
				break;
			case 59:
				$Leyes[$valor][1] = "-(%)";
				break;
			case 60:
				$Leyes[$valor][1] = "-(%)";
				break;
			default:
				$Leyes[$valor][1] = " ";
				break;
		}		
		//-------------------------------------CONSULTO LIMITES-----------------------------
		//RESCATO EL VALOR DE LOS LIMITES DE LAS LEYES SI ES QUE TIENE
		switch ($Indice)
		{
			case 1:
				//1.- CONSULTO POR LEYES DE PROVEEDOR
				$Consulta = "SELECT * from imp_web.limites ";
				$Consulta.= " where ";
				$Consulta.= " tipo_producto = '".$TipoProd."'";
				$Consulta.= " and rut_proveedor like '%".$RutProv."'";
				if ($valor < 10)
				$Consulta.= " and cod_leyes = '0".$valor."'";
				else	$Consulta.= " and cod_leyes = '".$valor."'";			
				$resLimite = mysqli_query($link, $Consulta);
				if ($rowLimite = mysqli_fetch_array($resLimite))
				{
					$Leyes[$valor][1] = $Leyes[$valor][1]." ".number_format($rowLimite["limite"],4,',','.');
				}
				break;
			case 2:
				//2.- CONSULTO POR LEYES DE PRODUCTO
				$Consulta = "SELECT * from imp_web.limites ";
				$Consulta.= " where ";
				$Consulta.= " tipo_producto = '".$TipoProd."'";
				$Consulta.= " and rut_proveedor = '000000000'";
				if ($valor < 10)
					$Consulta.= " and cod_leyes = '0".$valor."'";
				else	$Consulta.= " and cod_leyes = '".$valor."'";
				$resLimite = mysqli_query($link, $Consulta);
				if ($rowLimite = mysqli_fetch_array($resLimite))
				{
					$Leyes[$valor][1] = $Leyes[$valor][1]." ".number_format($rowLimite["limite"],4,',','.');
				}									
				break;	
			case 3:
				// 3.- CONSULTO POR LEYES EN GENERAL
				$Consulta = "SELECT * from imp_web.limites ";
				$Consulta.= " where ";
				$Consulta.= " tipo_producto = '000'";
				$Consulta.= " and rut_proveedor = '000000000'";
				if ($valor < 10)
					$Consulta.= " and cod_leyes = '0".$valor."'";
				else	$Consulta.= " and cod_leyes = '".$valor."'";
				$resLimite = mysqli_query($link, $Consulta);
				if ($rowLimite = mysqli_fetch_array($resLimite))
				{
					$Leyes[$valor][1] = $Leyes[$valor][1]." ".number_format($rowLimite["limite"],4,',','.');
				}
				break;
		}
		//----------------------------------------------------------------------------------
	}
	include("../principal/cerrar_principal.php");
	include("../principal/conectar_imp_web.php");
?>
<html>
<head>
<title>CONSULTA DE LEYES DE IMPUREZA (PONDERADAS)/ POR LOTES</title>
<link href="../principal/estilos/css_imp_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function Proceso(opcion)
{
	var f = document.frmPrincipal;
	switch (opcion)
	{
		case "C":
			window.close();		
			break;	
		case "E":
			f.target = "_blank";
			f.action = "imp_xls_leyes_prov.php?TipoProd=" + f.TipoProd.value + "&RutProv=" + f.RutProv.value;			
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}

function Detalle(valores)
{
	var f = document.frmPrincipal;
	var URL = "imp_con_leyes_lote.php" + valores;
	window.open(URL,"","top=60,left=50,width=700,height=450,menubar=no,resizable=yes,scrollbars=yes");
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body background="../principal/imagenes/fondo3.gif" link="#FFFF33" vlink="#FFFF33" alink="#FFFF33">
<form name="frmPrincipal" action="" method="post">
  <table width="500" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td height="20" colspan="2"><strong><font>LEYES PONDERADAS</font></strong> </td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td width="156"><strong>PRODUCTO</strong></td>
      <td width="427"> 
        <?php
	$consulta = "SELECT * from imp_web.productos where tipo_producto = '".$TipoProd."'";	
	$result = mysqli_query($link, $consulta);
	if ($row = mysqli_fetch_array($result))
		echo $row["tipo_producto"]." - ".ucwords(strtolower($row["nombre"]));
	else
		echo "&nbsp;";
	?>
      </td>
    </tr>
    <tr> 
      <td><strong>PROVEEDOR</strong></td>
      <td> 
        <?php
	$consulta = "SELECT * from proveedores where rut_proveedor = '".$RutProv."'";	
	$result = mysqli_query($link, $consulta);
	if ($row = mysqli_fetch_array($result))
		echo $row["rut_proveedor"]." - ".ucwords(strtolower($row["nombre"]));
	else
		echo "&nbsp;";
	?>
      </td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
  <br>
  <br>
  <strong><font size="1">Seleccione Mes y Ano para ver la descripción de Lotes</font></strong><br>
  <table width="1000" border="0" cellspacing="1" cellpadding="1">
    <tr> 
      <td width="1000"><table width="1000" border="0" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td>
			<table width="1000" border="0" cellpadding="1" cellspacing="1">
<?php		
		$LeyesUsadas = array();
        echo "<tr bgcolor='".$ColorTabla1."'> \n";
        echo "<td width=30 align='center'><font color='#000000'><strong>IND</strong></font></td>\n";
        echo "<td width=60 align='center'><font color='#000000'><strong>AÑO</strong></font></td>\n";
        echo "<td width=60 align='center'><font color='#000000'><strong>MES</strong></font></td>\n";
		switch ($TipoProd)
		{
			case "043":
				echo "<td width=60 align='center'><font color='#000000'><strong>PESO (kg.)</strong></font></td>\n";
				break;
			case "058":
				echo "<td width=60 align='center'><font color='#000000'><strong>PESO (kg.)</strong></font></td>\n";
				break;
			default:
				echo "<td width=60 align='center'><font color='#000000'><strong>PESO (ton.)</strong></font></td>\n";
				break;
        	
		}       
		$sql = "SELECT ";
		for ($i = 1; $i<=60; $i++)
		{
			if ($i<10)
			{
				if ($i == 1)
					$sql.= "sum(c_0".$i.") as c_0".$i;
				else	$sql.= ", sum(c_0".$i.") as c_0".$i;
			}
			else
			{
				$sql.= ", sum(c_".$i.") as c_".$i;
			}
		}
		$sql.= " FROM ponderados_lotes ";
		$sql.= " WHERE tipo_reg = '2'"; // PONDERADOS
		$sql.= " AND tipo_producto = '".$TipoProd."'";
		$sql.= " AND rut_proveedor like '%".$RutProv."'";
		//echo $sql."<br><br>"; 
		$result = mysqli_query($link, $sql);		
		if ($row = mysqli_fetch_array($result))
		{
			for ($i = 1; $i <= 60; $i++)
			{
				if ($i < 10)
				{
					if ($row["c_0".$i.""] <> 0)
					{
						$LeyesUsadas[$i] = $i;	
						echo "<td width=60 align='center'><font color='#000000'>".$Leyes[$i][0]." ".$Leyes[$i][1]."</font></td>\n";
					}
					else
					{
						$LeyesUsadas[$i] = 0;
					}
				}
				else
				{
					if ($row["c_".$i.""] <> 0)
					{
						$LeyesUsadas[$i] = $i;	
						echo "<td width=60 align='center'><font color='#000000'>".$Leyes[$i][0]." ".$Leyes[$i][1]."</font></td>\n";
					}
					else
					{
						$LeyesUsadas[$i] = 0;
					}
				}
			}
		}			
        echo "</tr>\n";
		$Consulta = "SELECT * FROM ponderados_lotes ";
		$Consulta.= " WHERE tipo_reg = '2'"; // PONDERADOS
		$Consulta.= " AND tipo_producto = '".$TipoProd."'";
		$Consulta.= " AND rut_proveedor like '%".$RutProv."'";
		$Consulta.= " ORDER BY fecha_aamm asc";
		//echo $Consulta."<br><br>"; 
		$result = mysqli_query($link, $Consulta);
		$Color = $ColorTabla3;
		while ($Row = mysqli_fetch_array($result))
		{
			if ($Color == $ColorTabla3)
			{
				$Color = $ColorTabla2;
				echo "<tr bgcolor='".$ColorTabla2."'>\n";
			}
			else
			{
				$Color = $ColorTabla3;
				echo "<tr bgcolor='".$ColorTabla3."'>\n";			
			}
			echo "<td width=30 align='center'><font color='#ffff33'>";
			if ($Row["ind"] == "&")
				echo "*";
			else
				echo "&nbsp;";
			echo "</font></td>\n";
			echo "<td width=60 align='right'><a href=JavaScript:Detalle('?RutProv=".$Row["rut_proveedor"]."&TipoProd=".$TipoProd."&Fecha=".$Row["fecha_aamm"]."')>";
			echo substr($Row["fecha_aamm"],0,4);
			echo "</td>\n";
			echo "<td width=60 align='right'><a href=JavaScript:Detalle('?RutProv=".$Row["rut_proveedor"]."&TipoProd=".$TipoProd."&Fecha=".$Row["fecha_aamm"]."')>";
			echo strtoupper(substr($Meses[intval(substr($Row["fecha_aamm"],4,2))-1],0,3));
			echo "</td>\n";
			echo "<td width=60 align='right'><font color='#ffff33'>";
			//$PesoTon = substr($Row["peso_humedo"],0,6).".".substr($Row["peso_humedo"],6,2);
			$PesoTon = $Row["peso_humedo"];
			echo number_format(round($PesoTon),2,',','.');
			echo "</font></td>\n";
			for ($i = 1; $i <= 60; $i++)
			{
				$ColorAlerta = "";
				if (intval($LeyesUsadas[$i]) != 0)
				{
					if ($i < 10)
					{						
						if ($i == 5) // CONDICION PARA EL ORO.... X 1000
						{
							//$LeyNum = (intval(substr($Row["c_05"],4,4))*1000);
							$LeyNum = $Row["c_05"]*1000;
						}
						else
						{							
							//$LeyNum = substr($Row["c_0".$i.""],0,4).".".substr($Row["c_0".$i.""],4,4);
							$LeyNum = $Row["c_0".$i.""];
						}		
					}
					else
					{
						$LeyNum = substr($Row["c_".$i.""],0,4).".".substr($Row["c_".$i.""],4,4);
					}
					//-------------------------------------CONSULTO LIMITES-----------------------------
					//SI ALGUNA DE LAS 3 COMPARACIONES ESTA FUERA DEL LIMITE LA VARIABLE INDICE PASA A TRUE
					//QUEDANDO LAS OTRAS CONSULTAS EN EL CAMINO;				
					switch ($Indice)
					{
						case 1:
							//1.- CONSULTO POR LEYES DE PROVEEDOR
							$Consulta = "SELECT * from limites ";
							$Consulta.= " WHERE ";
							$Consulta.= " tipo_producto = '".$TipoProd."'";
							$Consulta.= " AND rut_proveedor like '%".$RutProv."'";
							if ($i < 10 )
								$Consulta.= " AND cod_leyes = '0".$i."'";					
							else	$Consulta.= " AND cod_leyes = '".$i."'";
							$resLimite = mysqli_query($link, $Consulta);
							if ($rowLimite = mysqli_fetch_array($resLimite))
							{
								if ($LeyNum > $rowLimite["limite"])
								{
									$ColorAlerta = "#FF0000";
								}
							}
							break;
						case 2:
							//2.- CONSULTO POR LEYES DE PRODUCTO
							$Consulta = "SELECT * from limites ";
							$Consulta.= " WHERE ";
							$Consulta.= " tipo_producto = '".$TipoProd."'";
							$Consulta.= " AND rut_proveedor = '000000000'";
							if ($i < 10 )
								$Consulta.= " AND cod_leyes = '0".$i."'";					
							else	$Consulta.= " AND cod_leyes = '".$i."'";
							$resLimite = mysqli_query($link, $Consulta);
							if ($rowLimite = mysqli_fetch_array($resLimite))
							{
								if ($LeyNum > $rowLimite["limite"])
								{
									$ColorAlerta = "#FF0000";
								}
							}												
							break;
						case 3:
							// 3.- CONSULTO POR LEYES EN GENERAL
							$Consulta = "SELECT * from limites ";
							$Consulta.= " WHERE ";
							$Consulta.= " tipo_producto = '000'";
							$Consulta.= " AND rut_proveedor = '000000000'";
							if ($i < 10 )
								$Consulta.= " AND cod_leyes = '0".$i."'";					
							else	$Consulta.= " AND cod_leyes = '".$i."'";					
							$resLimite = mysqli_query($link, $Consulta);
							if ($rowLimite = mysqli_fetch_array($resLimite))
							{
								if ($LeyNum > $rowLimite["limite"])
								{
									$ColorAlerta = "#FF0000";
								}						
							}						
							break;
					}
					//----------------------------------------------------------------------------------				
					if ($i <  10)
					{						
						if ($NivelUsuario==4 && ($i==2 || $i==4 || $i==5))
						{
							echo "<td width=60 align='center' bgcolor=\"#FFFFFF\" ><img src=\"..\principal\imagenes\cand_cerrado.gif\"></td>\n";
						}
						else
						{
							if ($Row["c_0".$i.""] == "0")
								echo "<td width=60 align='right' bgcolor='".$ColorAlerta."'><font color='#ffff33'>0</font></td>\n";
							else															
								echo "<td width=60 align='right' bgcolor='".$ColorAlerta."'><font color='#ffff33'>".number_format($Row["c_0".$i.""],4,',','.')."</font></td>\n";
						}
					}
					else
					{
						if ($Row["c_".$i.""] == "0")
						{
							echo "<td width=60 align='right' bgcolor='".$ColorAlerta."'><font color='#ffff33'>0</font></td>\n";
						}
						else
						{
							echo "<td width=60 align='right' bgcolor='".$ColorAlerta."'><font color='#ffff33'>".number_format($Row["c_".$i.""],4,',','.')."</font></td>\n";
						}
					}
				}
			}			
			echo "</tr>\n";
		}
?>
                </table>
              <br></td>
          </tr>
          <tr> 
            <td height="41"><table width="100" border="0" align="center" cellpadding="7" cellspacing="1">
                <tr> 
                  <td align="center" valign="middle"><input type="button" name="BtnPrint" value="Imprimir" style="width:110" onClick="JavaScript:Proceso('I');"></td>
                  <td align="center" valign="middle"><input type="button" name="BtnExcel" value="Generar Excel" style="width:110" onClick="JavaScript:Proceso('E');"></td>
                  <td align="center" valign="middle"><input type="button" name="BtnCerrar" value="Cerrar Ventana" style="width:110" onClick="JavaScript:Proceso('C');"></td>
                </tr>
              </table>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
<br>
  <input type="hidden" name="TipoProd" value="<?php echo $TipoProd;?>">
<input type="hidden" name="RutProv" value="<?php echo $RutProv;?>">
</form>
</body>
</html>
