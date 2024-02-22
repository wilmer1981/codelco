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
	include("funciones.php");

	$Buscar 	 = $_REQUEST["Buscar"];
	$TxtFechaIni = $_REQUEST["TxtFechaIni"];
	$TxtFechaIniMes = substr(date('Y-m-d'),0,7)."-01";	

?>
<html>
<head>
<title>Informe Recepciones por Producto Excel</title>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
<table width="600" border="1" align="center" cellpadding="2" cellspacing="0" >
  <tr class="ColorTabla02">
    <td align="center">LOTE</td>
    <td align="center">RE</td>
    <td align="center">UR</td>
    <td align="center">PROVEEDOR</td>
    <td align="center">CONJ.</td>
    <td align="center">P.NETO</td>
  </tr>
<?php
if($Buscar=='S')
{
	$TotalRecep=0;
	$Consulta="SELECT distinct t1.cod_subproducto,t2.descripcion as nom_prod from sipa_web.recepciones t1 left join proyecto_modernizacion.subproducto t2 on ";
	$Consulta.="t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
	$Consulta.="where t1.cod_producto='1' and fecha='".$TxtFechaIni."' order by nom_prod ";
	//echo $Consulta;
	$RespProd=mysqli_query($link, $Consulta);
	while($FilaProd=mysqli_fetch_array($RespProd))
	{
		$TotNeto=0;
		echo "<tr class=\"Detalle01\" align=\"left\">";
		echo "<td colspan=\"6\">".$FilaProd["nom_prod"]."</td>";
		echo "</tr>";
		$Consulta="SELECT t1.lote,t2.nombre_prv,t1.conjunto,sum(t1.peso_neto) as peso_neto ";
		$Consulta.="from sipa_web.recepciones t1 left join sipa_web.proveedores t2 on t1.rut_prv=t2.rut_prv ";
		$Consulta.="where t1.fecha='".$TxtFechaIni."' and t1.cod_producto='1' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' and peso_neto<>'' ";
		$Consulta.="group by lote order by t1.lote";
		//echo $Consulta."<br>";
		$RespRecep=mysqli_query($link, $Consulta);
		while($FilaR=mysqli_fetch_array($RespRecep))
		{
			echo "<tr>";
			echo "<td align='center'>".$FilaR["lote"]."</td>";
			$Consulta="SELECT count(*) as cant_rec from sipa_web.recepciones where lote='".$FilaR["lote"]."' and fecha between '".$TxtFechaIniMes."' and '".$TxtFechaIni."' group by lote";
			$RespRec=mysqli_query($link, $Consulta);
			$FilaRec=mysqli_fetch_array($RespRec);
			//echo $Consulta."<br>";
			echo "<td align='right'>".$FilaRec["cant_rec"]."</td>";
			$Consulta="SELECT ult_registro from sipa_web.recepciones where lote='".$FilaR["lote"]."' and recargo='".$FilaRec["cant_rec"]."'";
			$RespUR=mysqli_query($link, $Consulta);
			$FilaUR=mysqli_fetch_array($RespUR);
			echo "<td align='center'>".$FilaUR["ult_registro"]."</td>";
			echo "<td>".$FilaR["nombre_prv"]."</td>";
			echo "<td align='center'>".$FilaR["conjunto"]."</td>";
			echo "<td align='right'>".number_format($FilaR["peso_neto"],0,'','.')."</td>";
			echo "</tr>";			
			$TotNeto=$TotNeto+$FilaR["peso_neto"];
		}
		echo "<tr class='Detalle01'>";
		echo "<td colspan=\"5\" align='right'>SUBTOTAL</td>";
		echo "<td align='right'>".number_format($TotNeto,0,'','.')."</td>";
		echo "</tr>";
		$TotalRecep=$TotalRecep+$TotNeto;
	}
	echo "<tr class='Detalle01'>";
	echo "<td colspan=\"5\" align='right'>TOTAL</td>";
	echo "<td align='right'>".number_format($TotalRecep,0,'','.')."</td>";
	echo "</tr>";
}
?>
</table>
</form>
</body>
</html>