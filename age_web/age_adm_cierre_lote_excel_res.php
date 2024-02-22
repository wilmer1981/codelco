<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
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
	$Mostrar='N';
	if (isset($TxtLote))
	{
		$EstadoInput = "";
		$Consulta ="select t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.descripcion as nom_subproducto,t1.rut_proveedor,t4.NOMPRV_A as nom_prv,t1.num_conjunto,";
		$Consulta.="t1.cod_faena,t5.nommin_a as nom_faena,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.valor_subclase1 as nom_recepcion ";
		$Consulta.="from age_web.lotes t1 left join ";
		$Consulta.="proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto left join ";
		$Consulta.="rec_web.proved t4 on t1.rut_proveedor=t4.RUTPRV_A left join ";
		$Consulta.="rec_web.minaprv t5 on t1.cod_faena=t5.codmin_a left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15003' and t1.estado_lote=t6.cod_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t7 on t7.cod_clase='15001' and t1.clase_producto=t7.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t8 on t8.cod_clase='15002' and t1.cod_recepcion=t8.nombre_subclase ";
		$Consulta.= "where t1.lote = '".$TxtLote."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$Mostrar='S';
			$TxtLote = $Fila["lote"];
			$CodSubProducto = $Fila["cod_subproducto"];
			$NombreSubProducto=$Fila["nom_subproducto"];
			$RutProveedor = $Fila["rut_proveedor"];
			$NombrePrv=$Fila["nom_prv"];
			$CodFaena=$Fila["cod_faena"];
			$NombreFaena = $Fila["nom_faena"];
			$Recepcion = $Fila["nom_recepcion"];
			$ClaseProducto = $Fila["nom_clase_producto"];
			$TxtConjunto = $Fila["num_conjunto"];
			$EstadoLote = $Fila["nom_estado_lote"];
			$PesoRetalla=$Fila["peso_retalla"];
			$PesoMuestra=$Fila["peso_muestra"];
			$DatosLote= array();
			$ArrLeyes=array();
			$DatosLote["lote"]=$TxtLote;
			LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
			$PesoSecoLote=$DatosLote["peso_seco"];
			$PesoHumLote=$DatosLote["peso_humedo"];
		}
	}
	if (strlen($Fila[muestra_paralela]>1))
	{
		$ConsultaR = "select distinct t1.id_muestra, t1.nro_solicitud, t1.peso_muestra, t1.peso_retalla";
		$ConsultaR.=" from cal_web.solicitud_analisis t1 where t1.id_muestra = '".$Fila[muestra_paralela]."'";
		$ConsultaR.=" and t1.recargo = 'R'";
		$RespR=mysqli_query($link, $ConsultaR);
		if ($FilaR=mysqli_fetch_array($RespR))
		{
			$SolicitudR 	= $FilaR["nro_solicitud"];
			$MuestraR   	= $FilaR["id_muestra"];
			$PesoMuestraR 	= $FilaR[peso_muestra];
			$PesoRetallaR 	= $FilaR["peso_retalla"];
		}
	} 

?>
<html>
<head>
<title>Sistema de Agencia</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;

	switch (opt)
	{
		case "I"://IMPRIMIR
			f.BtnImprimir.style.visibility='hidden';
			f.BtnSalir.style.visibility='hidden';			
			window.print();
			f.BtnImprimir.style.visibility='';
			f.BtnSalir.style.visibility='';			
			break;
		case "S"://SALIR
			window.close()
			break;			
	}
}
</script>
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
<table width="750"  border="1" align="center">
  <tr>
    <td colspan="4" align="center"><strong>ADM. CIERRE LOTES</strong></td>
  </tr>
  <tr>
    <td width="88" >Lote:</td>
    <td ><?php echo $TxtLote;?></td>
    <td align="right" >Num.Conjunto:</td>
    <td width="145" ><?php if(isset($TxtConjunto)) echo $TxtConjunto; else echo "&nbsp;";?></td>
  </tr>
  <tr >
    <td >SubProducto:</td>
    <td ><?php if(isset($CodSubProducto)) echo $CodSubProducto." - ".$NombreSubProducto; else echo "&nbsp;";?></td>
    <td align="right" >Clase Producto:</td>
    <td ><?php if(isset($ClaseProducto)) echo $ClaseProducto; else echo "&nbsp;";?></td>
  </tr>
  <tr >
    <td >Proveedor:</td>
    <td ><?php if(isset($RutProveedor)) echo $RutProveedor." - ".$NombrePrv; else echo "&nbsp;";?></td>
    <td align="right" >Cod.Recepcion:</td>
    <td ><?php if(isset($Recepcion)) echo $Recepcion; else echo "&nbsp;";?></td>
  </tr>
  <tr >
    <td >Cod Faena: </td>
    <td ><?php if(isset($CodFaena)) echo $CodFaena." - ".$NombreFaena; else echo "&nbsp;";?></td>
    <td align="right" >Peso Retalla: </td>
    <td >
		<?php if(isset($PesoRetalla)) echo number_format($PesoRetalla,4,',','.')."&nbsp;&nbsp;Grs.&nbsp;&nbsp;"; else echo "&nbsp;";?>
		<?php if(isset($PesoRetallaR)) echo number_format($PesoRetallaR,4,',','.')."&nbsp;&nbsp;Grs."; else echo "&nbsp;";?></td>
  </tr>
  <tr >
    <td >Estado Lote:</td>
    <td ><?php if(isset($EstadoLote)) echo strtoupper($EstadoLote); else echo "&nbsp;";?></td>
    <td align="right" >Peso Muestra: </td>
    <td >
		<?php if(isset($PesoMuestra)) echo number_format($PesoMuestra,0,',','.')."&nbsp;&nbsp;Grs.&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp"; else echo "&nbsp;";?>
    	<?php if(isset($PesoMuestraR)) echo number_format($PesoMuestraR,0,',','.')."&nbsp;&nbsp;Grs."; else echo "&nbsp;";?></td>
  </tr>
  <tr>
    <td >Peso Humedo:</td>
    <td ><?php if(isset($PesoHumLote)) echo number_format($PesoHumLote,0,'','.'); else echo "&nbsp;";?></td>
    <td align="right" >Peso Seco:</td>
    <td ><?php if(isset($PesoSecoLote)) echo number_format($PesoSecoLote,0,'','.'); else echo "&nbsp;";?></td>
  </tr>
	</table>
	<br>
	<?php
	if($Mostrar=='S')
	{
		echo "<table width='750'  border='1' align='center'>";
		echo '<tr align="center">';
		switch($Petalo)		  
		{
			case "H":
				echo '<td colspan="3"><strong>Leyes Humedad</strong></td>';
				break;
			case "L":
				echo '<td colspan="3"><strong>Leyes</strong></td>';
				break;
			default:
				echo '<td colspan="3"><strong>Recargos</strong></td>';
				break;
		}		
		echo "</tr>";
		echo '<tr><td colspan="3">';
		switch($Petalo)		  
		{
			case "H"://LEY HUMEDAD
				include("age_adm_cierre_lote_humedad.php");
				break;
			case "L"://LEYES
				include("age_adm_cierre_lote_leyes.php");
				break;
			default://RECARGOS
				include("age_adm_cierre_lote_recargos.php");
				break;
		}  
		echo "</td></tr>";
		echo "</table>";
	}	
	?>
</form>
</body>
</html>
