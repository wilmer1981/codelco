<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=4;
	include("../principal/conectar_principal.php");
	if (!isset($Ano))
		$Ano = date("Y");
?>	
<html>
<head>
<title>Sistema de Agencia</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
function Proceso(opt,opt1)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "S":
			window.close();
			break;
		case "I":
			f.BtnImprimir.style.visibility="hidden";
			f.BtnSalir.style.visibility="hidden";
			window.print();
			f.BtnImprimir.style.visibility="visible";
			f.BtnSalir.style.visibility="visible";
			break;
	}
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
	    <table width="547" border="0" align="center" cellpadding="3" cellspacing="0">
          <tr align="center">
            <td height="30" colspan="2"><strong>PROGRAMA DE RECEPCION A&Ntilde;O <?php echo $Ano; ?><br><br>
<?php
	switch ($ChkTipoProg)
	{
		case "00":
			echo "*** (TMS) ***";
			break;
		case "02":
			echo "*** (TM) Fino Cu***";
			break;
		case "04":
			echo "*** (Kg) Fino Ag***";
			break;
		case "05":
			echo "*** (Kg) Fino Au***";
			break;
	}
?>
            </strong></td>
          </tr>
          <tr align="center">
            <td width="528" height="30" colspan="2">              <input name="BtnImprimir" type="button" id="BtnEliminar" value="Imprimir" onClick="Proceso('I')" style="width:70px ">
          <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" onClick="Proceso('S')" style="width:70px "></td>
          </tr>
        </table>
        <br>
        <table width="765" border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">          
<?php			
$TotalPesoTot = 0;
$TotalPesoEne = 0;
$TotalPesoFeb = 0;
$TotalPesoMar = 0;
$TotalPesoAbr = 0;
$TotalPesoMay = 0;
$TotalPesoJun = 0;
$TotalPesoJul = 0;
$TotalPesoAgo = 0;
$TotalPesoSep = 0;
$TotalPesoOct = 0;
$TotalPesoNov = 0;
$TotalPesoDic = 0;	
$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t2.descripcion ";
$Consulta.= " from age_web.programa_recepcion t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto ";
$Consulta.= " where t1.ano='".$Ano."' and t1.tipo_programa='".$ChkTipoProg."'";
if (isset($CmbSubProducto) && $CmbSubProducto!="S")
	$Consulta.= " and t1.cod_producto='1' and t1.cod_subproducto='".$CmbSubProducto."' ";
if (isset($CmbContrato) && $CmbContrato!="S")
	$Consulta.= " and t1.cod_contrato='".$CmbContrato."' ";
if (isset($CmbProveedor) && $CmbProveedor!="S")
	$Consulta.= " and t1.rut_proveedor='".$CmbProveedor."' ";
$Consulta.= " order by t1.cod_producto, lpad(t1.cod_subproducto,3,'0')";
$RespIni = mysqli_query($link, $Consulta);
$i=1;
while ($FilaIni = mysqli_fetch_array($RespIni))	
{
	echo "<tr align='center' class='ColorTabla01'>\n";
	echo "<td width='100'><strong>Proveedor</strong></td>\n";
	echo "<td><strong>Total</strong></td>\n";
	echo "<td><strong>Ene</strong></td>\n";
	echo "<td><strong>Feb</strong></td>\n";
	echo "<td><strong>Mar</strong></td>\n";
	echo "<td><strong>Abr</strong></td>\n";
	echo "<td><strong>May</strong></td>\n";
	echo "<td><strong>Jun</strong></td>\n";
	echo "<td><strong>Jul</strong></td>\n";
	echo "<td><strong>Ago</strong></td>\n";
	echo "<td><strong>Sep</strong></td>\n";
	echo "<td><strong>Oct</strong></td>\n";
	echo "<td><strong>Nov</strong></td>\n";
	echo "<td><strong>Dic</strong></td>\n";
	echo "</tr>\n";
	echo "<tr class='detalle02'>\n";
	echo "<td colspan='14'><strong>Producto:&nbsp;&nbsp;".$FilaIni["cod_subproducto"]."&nbsp;&nbsp;&nbsp;".$FilaIni["descripcion"]."</strong></td>\n";
	echo "</tr>\n";
	$ProdPesoTotalTot = 0;
	$ProdPesoTotalEne = 0;
	$ProdPesoTotalFeb = 0;
	$ProdPesoTotalMar = 0;
	$ProdPesoTotalAbr = 0;
	$ProdPesoTotalMay = 0;
	$ProdPesoTotalJun = 0;
	$ProdPesoTotalJul = 0;
	$ProdPesoTotalAgo = 0;
	$ProdPesoTotalSep = 0;
	$ProdPesoTotalOct = 0;
	$ProdPesoTotalNov = 0;
	$ProdPesoTotalDic = 0;	
	$Consulta = "select distinct t1.cod_contrato, t2.descripcion ";
	$Consulta.= " from age_web.programa_recepcion t1 inner join age_web.contratos t2 on t1.cod_contrato=t2.cod_contrato ";
	$Consulta.= " where t1.cod_producto='".$FilaIni["cod_producto"]."' and t1.cod_subproducto='".$FilaIni["cod_subproducto"]."' ";
	$Consulta.= " and t1.ano='".$Ano."' and t1.tipo_programa='".$ChkTipoProg."'";
	if (isset($CmbContrato) && $CmbContrato!="S")
		$Consulta.= " and t1.cod_contrato='".$CmbContrato."' ";
	if (isset($CmbProveedor) && $CmbProveedor!="S")
		$Consulta.= " and t1.rut_proveedor='".$CmbProveedor."' ";
	$Consulta.= " order by t1.cod_contrato";
	$RespAux = mysqli_query($link, $Consulta);
	$i=1;
	while ($FilaAux = mysqli_fetch_array($RespAux))	
	{
		echo "<tr class='Detalle01'>\n";
		echo "<td colspan='14'><strong>Contrato:</strong>&nbsp;&nbsp;".$FilaAux["cod_contrato"]." <strong>Descrip.:&nbsp;&nbsp;</strong>".$FilaAux["descripcion"]."</td>\n";
		echo "</tr>\n";
		$ChkPesoTotalTot = 0;
		$ChkPesoTotalEne = 0;
		$ChkPesoTotalFeb = 0;
		$ChkPesoTotalMar = 0;
		$ChkPesoTotalAbr = 0;
		$ChkPesoTotalMay = 0;
		$ChkPesoTotalJun = 0;
		$ChkPesoTotalJul = 0;
		$ChkPesoTotalAgo = 0;
		$ChkPesoTotalSep = 0;
		$ChkPesoTotalOct = 0;
		$ChkPesoTotalNov = 0;
		$ChkPesoTotalDic = 0;
		for ($Cont=1;$Cont<=3;$Cont++)
			{
				switch ($Cont)
				{
					case 1:
						$Titulo="PROVEEDORES PRINCIPALES";
						$Grupo="P";
						break;
					case 2:
						$Titulo="PROVEEDORES VARIOS";
						$Grupo="V";
						break;
					case 3:
						$Titulo="PROVEEDORES SIN GRUPO";
						$Grupo="";
						break;
				}
				$Consulta = "select * ";
				$Consulta.= " from age_web.programa_recepcion t1 left join rec_web.proved t2 on ";
				$Consulta.= " t1.rut_proveedor = t2.rutprv_a left join age_web.relaciones t3 on ";
				$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
				$Consulta.= " and t1.rut_proveedor=t3.rut_proveedor ";
				$Consulta.= " where t1.cod_producto='".$FilaIni["cod_producto"]."' and t1.cod_subproducto='".$FilaIni["cod_subproducto"]."' ";
				$Consulta.= " and ano='".$Ano."'  and t1.tipo_programa='".$ChkTipoProg."'";
				$Consulta.= " and t1.cod_contrato='".$FilaAux["cod_contrato"]."' ";
				if ($Grupo=="")
					$Consulta.= " and (t3.grupo='".$Grupo."' or isnull(t3.grupo)) ";
				else
					$Consulta.= " and t3.grupo='".$Grupo."'";
				if (isset($CmbProveedor) && $CmbProveedor!="S")
					$Consulta.= " and t1.rut_proveedor='".$CmbProveedor."' ";
				$Consulta.= " order by t2.nomprv_a";
				$Resp = mysqli_query($link, $Consulta);
				$i=1;
				$j=1;
				while ($Fila = mysqli_fetch_array($Resp))  	
				{
					if ($j==1)
						echo "<tr class=\"Detalle01\" align=\"left\"><td colspan=\"15\">>>>&nbsp;&nbsp;".$Titulo."</td></tr>";
					$j++;				
					$ValorTot= $Fila["ene"]+$Fila["feb"]+$Fila["mar"]+$Fila["abr"]+$Fila["may"]+$Fila["jun"]+$Fila["jul"]+$Fila["ago"]+$Fila["sep"]+$Fila["oct"]+$Fila["nov"]+$Fila["dic"];
					echo "<tr align='right'>\n";
					echo "<td align='left' ><font style='font-family:Verdana;font-size:9px'>";
					if ($Grupo=="" && $Fila["NOMPRV_A"]=="")
						echo "DIFERENCIA";
					else
						echo substr($Fila["NOMPRV_A"],0,20);
					echo "</font></td>\n";
					echo "<td bgcolor='#FFFF99'>".number_format($ValorTot,0,",",".")."</td>\n";		
					echo "<td>".number_format($Fila["ene"],0,",",".")."</td>\n";
					echo "<td>".number_format($Fila["feb"],0,",",".")."</td>\n";
					echo "<td>".number_format($Fila["mar"],0,",",".")."</td>\n";
					echo "<td>".number_format($Fila["abr"],0,",",".")."</td>\n";
					echo "<td>".number_format($Fila["may"],0,",",".")."</td>\n";
					echo "<td>".number_format($Fila["jun"],0,",",".")."</td>\n";
					echo "<td>".number_format($Fila["jul"],0,",",".")."</td>\n";
					echo "<td>".number_format($Fila["ago"],0,",",".")."</td>\n";
					echo "<td>".number_format($Fila["sep"],0,",",".")."</td>\n";
					echo "<td>".number_format($Fila["oct"],0,",",".")."</td>\n";
					echo "<td>".number_format($Fila["nov"],0,",",".")."</td>\n";
					echo "<td>".number_format($Fila["dic"],0,",",".")."</td>\n";
					echo "</tr>\n";
					$ChkPesoTotalTot = $ChkPesoTotalTot + $ValorTot;
					$ChkPesoTotalEne = $ChkPesoTotalEne + $Fila["ene"];
					$ChkPesoTotalFeb = $ChkPesoTotalFeb + $Fila["feb"];
					$ChkPesoTotalMar = $ChkPesoTotalMar + $Fila["mar"];
					$ChkPesoTotalAbr = $ChkPesoTotalAbr + $Fila["abr"];
					$ChkPesoTotalMay = $ChkPesoTotalMay + $Fila["may"];
					$ChkPesoTotalJun = $ChkPesoTotalJun + $Fila["jun"];
					$ChkPesoTotalJul = $ChkPesoTotalJul + $Fila["jul"];
					$ChkPesoTotalAgo = $ChkPesoTotalAgo + $Fila["ago"];
					$ChkPesoTotalSep = $ChkPesoTotalSep + $Fila["sep"];
					$ChkPesoTotalOct = $ChkPesoTotalOct + $Fila["oct"];
					$ChkPesoTotalNov = $ChkPesoTotalNov + $Fila["nov"];
					$ChkPesoTotalDic = $ChkPesoTotalDic + $Fila["dic"];
					$i++;
				}
			}
		echo "<tr class='Detalle01' align='right'>\n";
		echo "<td>Total Contrato:</td>\n";
		echo "<td>".number_format($ChkPesoTotalTot,0,",",".")."</td>\n";
		echo "<td>".number_format($ChkPesoTotalEne,0,",",".")."</td>\n";
		echo "<td>".number_format($ChkPesoTotalFeb,0,",",".")."</td>\n";
		echo "<td>".number_format($ChkPesoTotalMar,0,",",".")."</td>\n";
		echo "<td>".number_format($ChkPesoTotalAbr,0,",",".")."</td>\n";
		echo "<td>".number_format($ChkPesoTotalMay,0,",",".")."</td>\n";
		echo "<td>".number_format($ChkPesoTotalJun,0,",",".")."</td>\n";
		echo "<td>".number_format($ChkPesoTotalJul,0,",",".")."</td>\n";
		echo "<td>".number_format($ChkPesoTotalAgo,0,",",".")."</td>\n";
		echo "<td>".number_format($ChkPesoTotalSep,0,",",".")."</td>\n";
		echo "<td>".number_format($ChkPesoTotalOct,0,",",".")."</td>\n";
		echo "<td>".number_format($ChkPesoTotalNov,0,",",".")."</td>\n";
		echo "<td>".number_format($ChkPesoTotalDic,0,",",".")."</td>\n";
		echo "</tr>\n";
		$ProdPesoTotalTot = $ProdPesoTotalTot + $ChkPesoTotalTot;
		$ProdPesoTotalEne = $ProdPesoTotalEne + $ChkPesoTotalEne;
		$ProdPesoTotalFeb = $ProdPesoTotalFeb + $ChkPesoTotalFeb;
		$ProdPesoTotalMar = $ProdPesoTotalMar + $ChkPesoTotalMar;
		$ProdPesoTotalAbr = $ProdPesoTotalAbr + $ChkPesoTotalAbr;
		$ProdPesoTotalMay = $ProdPesoTotalMay + $ChkPesoTotalMay;
		$ProdPesoTotalJun = $ProdPesoTotalJun + $ChkPesoTotalJun;
		$ProdPesoTotalJul = $ProdPesoTotalJul + $ChkPesoTotalJul;
		$ProdPesoTotalAgo = $ProdPesoTotalAgo + $ChkPesoTotalAgo;
		$ProdPesoTotalSep = $ProdPesoTotalSep + $ChkPesoTotalSep;
		$ProdPesoTotalOct = $ProdPesoTotalOct + $ChkPesoTotalOct;
		$ProdPesoTotalNov = $ProdPesoTotalNov + $ChkPesoTotalNov;
		$ProdPesoTotalDic = $ProdPesoTotalDic + $ChkPesoTotalDic;
	}
	if (isset($CmbContrato) && $CmbContrato=="S")
	{
		echo "<tr class='Detalle02' align='right'>\n";
		echo "<td align='right'>Total Producto:</td>\n";
		echo "<td>".number_format($ProdPesoTotalTot,0,",",".")."</td>\n";
		echo "<td>".number_format($ProdPesoTotalEne,0,",",".")."</td>\n";
		echo "<td>".number_format($ProdPesoTotalFeb,0,",",".")."</td>\n";
		echo "<td>".number_format($ProdPesoTotalMar,0,",",".")."</td>\n";
		echo "<td>".number_format($ProdPesoTotalAbr,0,",",".")."</td>\n";
		echo "<td>".number_format($ProdPesoTotalMay,0,",",".")."</td>\n";
		echo "<td>".number_format($ProdPesoTotalJun,0,",",".")."</td>\n";
		echo "<td>".number_format($ProdPesoTotalJul,0,",",".")."</td>\n";
		echo "<td>".number_format($ProdPesoTotalAgo,0,",",".")."</td>\n";
		echo "<td>".number_format($ProdPesoTotalSep,0,",",".")."</td>\n";
		echo "<td>".number_format($ProdPesoTotalOct,0,",",".")."</td>\n";
		echo "<td>".number_format($ProdPesoTotalNov,0,",",".")."</td>\n";
		echo "<td>".number_format($ProdPesoTotalDic,0,",",".")."</td>\n";
		echo "</tr>\n";
		$TotalPesoTot = $TotalPesoTot + $ProdPesoTotalTot;
		$TotalPesoEne = $TotalPesoEne + $ProdPesoTotalEne;
		$TotalPesoFeb = $TotalPesoFeb + $ProdPesoTotalFeb;
		$TotalPesoMar = $TotalPesoMar + $ProdPesoTotalMar;
		$TotalPesoAbr = $TotalPesoAbr + $ProdPesoTotalAbr;
		$TotalPesoMay = $TotalPesoMay + $ProdPesoTotalMay;
		$TotalPesoJun = $TotalPesoJun + $ProdPesoTotalJun;
		$TotalPesoJul = $TotalPesoJul + $ProdPesoTotalJul;
		$TotalPesoAgo = $TotalPesoAgo + $ProdPesoTotalAgo;
		$TotalPesoSep = $TotalPesoSep + $ProdPesoTotalSep;
		$TotalPesoOct = $TotalPesoOct + $ProdPesoTotalOct;
		$TotalPesoNov = $TotalPesoNov + $ProdPesoTotalNov;
		$TotalPesoDic = $TotalPesoDic + $ProdPesoTotalDic;
	}
}
if (isset($CmbSubProducto) && $CmbSubProducto=="S")
{
	echo "<tr class='Detalle01' align='right'>\n";
	echo "<td align='right'>Total Consulta:</td>\n";
	echo "<td>".number_format($TotalPesoTot,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalPesoEne,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalPesoFeb,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalPesoMar,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalPesoAbr,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalPesoMay,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalPesoJun,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalPesoJul,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalPesoAgo,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalPesoSep,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalPesoOct,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalPesoNov,0,",",".")."</td>\n";
	echo "<td>".number_format($TotalPesoDic,0,",",".")."</td>\n";
	echo "</tr>\n";
}
?>		  
          
        </table>
</form>
</body>
</html>
