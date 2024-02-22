<?php
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
	if(isset($_GET["Fecha"])){
		$Fecha = $_GET["Fecha"];
	}else {
		$Fecha = "";
	}
ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename = "";
if ( preg_match( '/MSIE/i', $userBrowser ) ) 
{
$filename = urlencode($filename);
}
$filename = iconv('UTF-8', 'gb2312', $filename);
$file_name = str_replace(".php", "", $file_name);
header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
header("content-disposition: attachment;filename={$file_name}");
header( "Cache-Control: public" );
header( "Pragma: public" );
header( "Content-type: text/csv" ) ;
header( "Content-Dis; filename={$file_name}" ) ;
header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_imp_web.php");
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
	$Consulta.= " where ";
	$Consulta.= " tipo_producto = '".$TipoProd."'";
	$Consulta.= " and rut_proveedor like '%".$RutProv."'";
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
		$Consulta.= " where ";
		$Consulta.= " tipo_producto = '".$TipoProd."'";
		$Consulta.= " and rut_proveedor = '000000000'";
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
	$sql.= " from leyes ";
	$sql.= " order by cod_leyes";
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
				$Consulta.= " WHERE ";
				$Consulta.= " tipo_producto = '".$TipoProd."'";
				$Consulta.= " AND rut_proveedor like '%".$RutProv."'";
				if ($valor < 10)
				$Consulta.= " AND cod_leyes = '0".$valor."'";
				else	$Consulta.= " AND cod_leyes = '".$valor."'";			
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
<title>CONSULTA DE LEYES DE IMPUREZA (PONDERADAS)/ POR LOTES </title>
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
			f.action = "imp_xls_leyes_lote.php?TipoProd=" + f.TipoProd.value + "&RutProv=" + f.RutProv.value + "&Fecha=" + f.Fecha.value;			
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body >
<form name="frmPrincipal" action="" method="post">
  <table width="500" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr class="ColorTabla01"> 
      <td  colspan="15"><strong><font>CONSULTA DE LEYES DE IMPUREZA POR LOTES</font></strong> 
      </td>
    </tr>
    <tr> 
      <td colspan="15">&nbsp;</td>
    </tr>
    <tr> 
      <td width="140" colspan="5"><strong>PRODUCTO</strong></td>
      <td width="603" colspan="10"> 
        <?php
	$consulta = "SELECT * from productos where tipo_producto = '".$TipoProd."'";	
	$result = mysqli_query($link, $consulta);
	if ($row = mysqli_fetch_array($result))
		echo $row["tipo_producto"]." - ".ucwords(strtolower($row["nombre"]));
	else
		echo "&nbsp;";
	?>
      </td>
    </tr>
    <tr> 
      <td colspan="5"><strong>PROVEEDOR</strong></td>
      <td colspan="10"> 
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
      <td colspan="5"><strong>PERIODO</strong></td>
      <td colspan="10"> 
        <?php echo $Meses[intval(substr($Fecha,4,2)) - 1]." de ".substr($Fecha,0,4); ?>
      </td>
    </tr>
  </table>
  <br><!--
  <table width="643" border="0">
    <tr> 
      <td width="29" bgcolor="#000099">&nbsp;</td>
      <td width="84">Normal</td>
      <td width="29" bgcolor="#FF0000">&nbsp;</td>
      <td width="114"> Sobre Ley General</td>
      <td width="29" bgcolor="#0000FF">&nbsp;</td>
      <td width="148">Sobre Ley de Producto</td>
      <td width="29" bgcolor="#00FF00">&nbsp;</td>
      <td width="147">Sobre Ley de Proveedor</td>
    </tr>
  </table>
  <br>//-->
<table width="690" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr> 
            <td> <table width="690" border="1" cellpadding="1" cellspacing="1">                
		<?php			
		$LeyesUsadas = array();
        echo "<tr > \n";
        echo "<td width=30 align='center'><font ><strong>IND</strong></font></td>\n";
		switch ($TipoProd)
		{
			case "021":
				echo "<td width=60 align='center'><font ><strong>HORN.</strong></font></td>\n";
				break;
			default:
				echo "<td width=60 align='center'><font ><strong>LOTES</strong></font></td>\n";
				break;
		}        
		switch ($TipoProd)
		{
			case "043":
				echo "<td width=60 align='center'><font ><strong>PESO (kg.)</strong></font></td>\n";
				break;
			case "058":
				echo "<td width=60 align='center'><font ><strong>PESO (kg.)</strong></font></td>\n";
				break;
			default:
				echo "<td width=60 align='center'><font ><strong>PESO (ton.)</strong></font></td>\n";
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
		$sql.= " from ponderados_lotes ";
		$sql.= " where tipo_reg = '3'"; // LOTES
		$sql.= " and tipo_producto = '".$TipoProd."'";
		$sql.= " and rut_proveedor like '%".$RutProv."'";
		$sql.= " and fecha_aamm = '".$Fecha."'";
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
						echo "<td width=60 align='center'><font >".$Leyes[$i][0]." ".$Leyes[$i][1]."</font></td>\n";
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
						echo "<td width=60 align='center'><font >".$Leyes[$i][0]." ".$Leyes[$i][1]."</font></td>\n";
					}
					else
					{
						$LeyesUsadas[$i] = 0;
					}
				}
			}
		}			
		//
        echo "</tr>\n";				   
		$Consulta = "SELECT * from ponderados_lotes ";
		$Consulta.= " where tipo_reg = '3'"; // LOTES
		$Consulta.= " and tipo_producto = '".$TipoProd."'";
		$Consulta.= " and rut_proveedor = '".$RutProv."'";
		$Consulta.= " and fecha_aamm = '".$Fecha."'";		
		$Consulta.= " order by lote_agencia";
		$result = mysqli_query($link, $Consulta);
		$Color = $ColorTabla3;
		while ($Row = mysqli_fetch_array($result))
		{
			if ($Color == $ColorTabla3)
			{
				$Color = $ColorTabla2;
				echo "<tr >\n";
			}
			else
			{
				$Color = $ColorTabla3;
				echo "<tr >\n";			
			}
			echo "<td width=30 align='center'><font >";
			if ($Row["ind"] == "&")
				echo "*";
			else
				echo "&nbsp;";
			echo "</font></td>\n";
			echo "<td width=60 align='right'><font >".$Row["lote_agencia"]."</font></td>\n";
			echo "<td width=60 align='right'><font >";
			if ($Row["peso_humedo"] == "00000000")
			{
				echo "0";
			}
			else
			{
				
				$PesoTon = $Row["peso_humedo"];
				echo number_format($PesoTon,2,',','.');
			}
			echo "</font></td>\n";
			//impurezas
			for ($i = 1; $i <= 60; $i++)
			{
				$ColorAlerta = "";
				if (intval($LeyesUsadas[$i]) != 0)
				{
					if ($i < 10)
					{						
						if ($i == 5) // CONDICION PARA EL ORO.... X 1000
						{
							$LeyNum = $Row["c_05"]*1000;
						}
						else
						{							
							$LeyNum = $Row["c_0".$i.""];
						}		
					}
					else
					{
						$LeyNum = $Row["c_".$i.""];
					}
					//-------------------------------------CONSULTO LIMITES-----------------------------
					//SI ALGUNA DE LAS 3 COMPARACIONES ESTA FUERA DEL LIMITE LA VARIABLE INDICE PASA A TRUE
					//QUEDANDO LAS OTRAS CONSULTAS EN EL CAMINO;				
					switch ($Indice)
					{
						case 1:
							//1.- CONSULTO POR LEYES DE PROVEEDOR
							$Consulta = "SELECT * from limites ";
							$Consulta.= " where ";
							$Consulta.= " tipo_producto = '".$TipoProd."'";
							$Consulta.= " AND rut_proveedor like '%".$RutProv."'";
							if ($i < 10 )
								$Consulta.= " and cod_leyes = '0".$i."'";					
							else	$Consulta.= " and cod_leyes = '".$i."'";
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
							$Consulta.= " where ";
							$Consulta.= " tipo_producto = '".$TipoProd."'";
							$Consulta.= " and rut_proveedor = '000000000'";
							if ($i < 10 )
								$Consulta.= " and cod_leyes = '0".$i."'";					
							else	$Consulta.= " and cod_leyes = '".$i."'";
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
							$Consulta.= " where ";
							$Consulta.= " tipo_producto = '000'";
							$Consulta.= " and rut_proveedor = '000000000'";
							if ($i < 10 )
								$Consulta.= " and cod_leyes = '0".$i."'";					
							else	$Consulta.= " and cod_leyes = '".$i."'";					
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
							echo "<td width=60 align='center' bgcolor=\"#FFFFFF\" >&nbsp;</td>\n";
						}
						else
						{
							if ($Row["c_0".$i.""] == "0")
								echo "<td width=60 align='right' ><font >0</font></td>\n";
							else
								echo "<td width=60 align='right' ><font >".number_format($Row["c_0".$i.""],4,',','.')."</font></td>\n";
						}
					}
					else
					{
						if ($Row["c_".$i.""] == "00000000")
						{
							echo "<td width=60 align='right' ><font >0</font></td>\n";
						}
						else
						{
							echo "<td width=60 align='right'><font >".number_format($Row["c_".$i.""],4,',','.')."</font></td>\n";
						}
					}
				}
			}			
			echo "</tr>\n";
		}
?>
                </table>
              </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
  </table>
	</td>
  </tr>
</table>
<input type="hidden" name="TipoProd" value="<?php echo $TipoProd;?>">
<input type="hidden" name="RutProv" value="<?php echo $RutProv;?>">
<input type="hidden" name="Fecha" value="<?php echo $Fecha;?>">
</form>
</body>
</html>
