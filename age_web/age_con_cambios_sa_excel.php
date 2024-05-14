<?php
	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename="";
	if ( preg_match( '/MSIE/i', $userBrowser ) ) {
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
	include("../principal/conectar_principal.php");
	include("age_funciones.php");

	$Mostrar      = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$Orden        = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
	$Mes          = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("n");
	$Ano          = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Busq         = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
    $ChkSolicitud = isset($_REQUEST["ChkSolicitud"])?$_REQUEST["ChkSolicitud"]:"S";
	$TxtFiltroPrv     = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$SubProducto   = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor     = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";

	//CONSULTO FECHA CIERRE ANEXO
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='15' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='15' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1')";
	$RespCierre = mysqli_query($link, $Consulta);
	$CierreBalance = false;	
	$FechaCierreAnexo="";
	if ($FilaCierre = mysqli_fetch_array($RespCierre))
	{
		if ($FilaCierre["estado"]=="C")
		{
			$CierreBalance = true;
			$FechaCierreAnexo=$FilaCierre["fecha_cierre"];
		}
	}
	
?>
<html>
<head>
<title>Ajustes</title>
</head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="TxtValores" value="">
<input type="hidden" name="Sistema" value="<?php echo $Sistema; ?>">
<br>
        <?php
	$MesAjuste = date("n", mktime(0,0,0,$Mes+1,1,$Ano));
	$AnoAjuste = date("Y", mktime(0,0,0,$Mes+1,1,$Ano));
	$NomMesAjuste = $Meses[$MesAjuste-1];
?>
        <br>
          <table width="700" border="1" align="center" cellpadding="2" cellspacing="0">
            <tr align="center" >
              <td height="18" colspan="8" class="Detalle01"><strong>Ajustes Mes de <?php echo $NomMesAjuste."&nbsp;".$AnoAjuste; ?></strong></td>
            </tr>
            <tr align="center" >
              <td width="70" rowspan="2" bgcolor="#EFEFEF">A&ntilde;o</td>
              <td width="100" rowspan="2" bgcolor="#EFEFEF">Mes</td>
              <td width="170" rowspan="2" bgcolor="#EFEFEF">Producto</td>
              <td width="250" rowspan="2" bgcolor="#EFEFEF">Proveedor</td>
              <td height="18" colspan="4" bgcolor="#CCCCCC">Ajustes</td>
            </tr>
            <tr align="center">
              <td width="70" height="18" bgcolor="#EFEFEF">Peso</td>
              <td width="70" bgcolor="#EFEFEF">Cu (Kg) </td>
              <td width="70" bgcolor="#EFEFEF">Ag (g/t)</td>
              <td width="70" bgcolor="#EFEFEF">Au (g/t) </td>
            </tr>
            <?php		
			$TotalPesoSeco=0;
			$TotalFinoCu=0;
			$TotalFinoAg=0;
			$TotalFinoAu=0;
			if ($Mostrar=="S" && $FechaCierreAnexo!="")
			{
				$Consulta = "select t1.ano, t1.mes, t1.cod_producto, t1.cod_subproducto, t2.abreviatura, t1.peso_seco, ";
				$Consulta.= " t1.fino_cu, t1.fino_ag, t1.fino_au, t1.rut_proveedor, t3.nomprv_a";
				$Consulta.= " from age_web.ajustes t1 inner join proyecto_modernizacion.subproducto t2 ";
				$Consulta.= " on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.= " inner join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a ";
				$Consulta.= " where t1.ano='".$AnoAjuste."' and t1.mes='".$MesAjuste."'";
				$Consulta.= " order by t1.cod_subproducto, t1.rut_proveedor ";
				//echo $Consulta;
				$Resp=mysqli_query($link, $Consulta);
				$TotalPesoSeco=0;
				$TotalFinoCu=0;
				$TotalFinoAg=0;
				$TotalFinoAu=0;
				while ($Fila=mysqli_fetch_array($Resp))
				{
					echo "<tr>\n";
					echo "<td align=\"center\">".$Fila["ano"]."</td>\n";
					echo "<td align=\"center\">".$Meses[$Fila["mes"]-1]."</td>\n";
					echo "<td>".$Fila["abreviatura"]."</td>\n";
					echo "<td>".$Fila["nomprv_a"]."</td>\n";
					echo "<td align=\"right\">".number_format($Fila["peso_seco"],2,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($Fila["fino_cu"],2,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($Fila["fino_ag"],2,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($Fila["fino_au"],2,",",".")."</td>\n";
					echo "</tr>\n";
					$TotalPesoSeco=$TotalPesoSeco+$Fila["peso_seco"];
					$TotalFinoCu=$TotalFinoCu+$Fila["fino_cu"];
					$TotalFinoAg=$TotalFinoAg+$Fila["fino_ag"];
					$TotalFinoAu=$TotalFinoAu+$Fila["fino_au"];
				}
			}//FIN MOSTRAR = S	
?>
            <tr align="center" >
              <td colspan="4" bgcolor="#efefef" >TOTAL AJUSTES </td>
              <td align="right" bgcolor="#efefef" ><?php echo number_format($TotalPesoSeco,2,",",".");?></td>
              <td align="right" bgcolor="#efefef" ><?php echo number_format($TotalFinoCu,2,",",".");?></td>
              <td align="right" bgcolor="#efefef" ><?php echo number_format($TotalFinoAg,2,",",".");?></td>
              <td align="right" bgcolor="#efefef" ><?php echo number_format($TotalFinoAu,2,",",".");?></td>
            </tr>
      </table>
</form>
</body>
</html>
