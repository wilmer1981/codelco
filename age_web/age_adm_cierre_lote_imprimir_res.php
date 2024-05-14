<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	$Mostrar='N';
	if (isset($TxtLote))
	{
		$EstadoInput = "";
		$Consulta ="select t1.estado_lote,t1.fin_canje,t1.fecha_recepcion,t1.muestra_paralela,t1.num_lote_remuestreo,t1.canjeable,t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.descripcion as nom_subproducto,t1.rut_proveedor,t4.NOMPRV_A as nom_prv,t1.num_conjunto,";
		$Consulta.="t1.cod_faena,t5.descripcion as nom_faena,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.nombre_subclase as nom_recepcion,t3.recepcion ";
		$Consulta.="from age_web.lotes t1 left join ";
		$Consulta.="proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto left join ";
		$Consulta.="rec_web.proved t4 on t1.rut_proveedor=t4.RUTPRV_A left join ";
		$Consulta.="age_web.mina t5 on t1.cod_faena=t5.cod_faena left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15003' and t1.estado_lote=t6.cod_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t7 on t7.cod_clase='15001' and t1.clase_producto=t7.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t8 on t8.cod_clase='3104' and t1.cod_recepcion=t8.nombre_subclase ";
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
			$MuestraParalela=$Fila["muestra_paralela"];
			$CodEstadoLote=$Fila["estado_lote"];
			$FechaRecepcion=$Fila["fecha_recepcion"];
			$ExLote=$Fila["num_lote_remuestreo"];
			$ProdRecepcion=$Fila["recepcion"];
			$CierreComercial='N';
			if($Fila["fin_canje"]=='S'||($Fila["estado_lote"]=='4'&&$Fila["canjeable"]=='N'))
				$CierreComercial='S';
			$DatosLote= array();
			$ArrLeyes=array();
			$DatosLote["lote"]=$TxtLote;
			LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
			$PesoSecoLote=$DatosLote["peso_seco"];
			$PesoHumLote=$DatosLote["peso_humedo"];
			
		}
	}
	if (strlen($Fila["muestra_paralela"]>1))
	{
			$ConsultaR = "select distinct t1.id_muestra, t1.nro_solicitud, t1.peso_muestra, t1.peso_retalla";
			$ConsultaR.=" from cal_web.solicitud_analisis t1 where t1.id_muestra = '".$Fila["muestra_paralela"]."'";
			$ConsultaR.=" and t1.recargo = 'R'";
			$RespR=mysqli_query($link, $ConsultaR);
			if ($FilaR=mysqli_fetch_array($RespR))
			{
				$SolicitudR 	= $FilaR["nro_solicitud"];
				$MuestraR   	= $FilaR["id_muestra"];
				$PesoMuestraR 	= $FilaR["peso_muestra"];
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
<table width="750"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02">
    <td colspan="4"><strong>ADM. CIERRE LOTES</strong></td>
  </tr>
  <tr class="Colum01">
    <td width="88" class="Colum01">Lote:</td>
    <td class="Colum01"><?php echo $TxtLote;?><strong>
	<?php
		if($CierreComercial=='S')
			echo "&nbsp;&nbsp;&nbsp;Cerrado Comercialmente";
	?></strong>
	</td>
    <td align="right" class="Colum01">Num.Conjunto:</td>
    <td width="145" class="Colum01"><?php if(isset($TxtConjunto)) echo $TxtConjunto."&nbsp;"; else echo "&nbsp;";?></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">SubProducto:</td>
    <td class="Colum01"><?php if(isset($CodSubProducto)) echo $CodSubProducto." - ".$NombreSubProducto; else echo "&nbsp;";?></td>
    <td align="right" class="Colum01">Clase Producto:</td>
    <td class="Colum01"><?php if(isset($ClaseProducto)) echo $ClaseProducto; else echo "&nbsp;";?></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Proveedor:</td>
    <td class="Colum01"><?php if(isset($RutProveedor)) echo $RutProveedor." - ".$NombrePrv; else echo "&nbsp;";?></td>
    <td align="right" class="Colum01">Cod.Recepcion:</td>
    <td class="Colum01"><?php if(isset($Recepcion)) echo $Recepcion; else echo "&nbsp;";?></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Cod Faena: </td>
    <td class="Colum01"><?php if(isset($CodFaena)) echo $CodFaena." - ".$NombreFaena; else echo "&nbsp;";?></td>
    <td align="right" class="Colum01">Peso Retalla: </td>
	<td colspan="2">
		<?php if(isset($PesoRetalla)) echo number_format($PesoRetalla,4,',','.')."&nbsp;&nbsp;Grs.&nbsp;&nbsp;"; else echo "&nbsp;";?>
		<?php if(isset($PesoRetallaR)) echo number_format($PesoRetallaR,4,',','.')."&nbsp;&nbsp;Grs."; else echo "&nbsp;";?></td>

  </tr>
  <tr class="Colum01">
    <td class="Colum01">Estado Lote:</td>
    <td class="Colum01"><strong><?php if(isset($EstadoLote)) echo strtoupper($EstadoLote); else echo "&nbsp;";?></strong></td>
    <td align="right" class="Colum01">Peso Muestra: </td>
	<td  colspan="2"><?php if(isset($PesoMuestra)) echo number_format($PesoMuestra,0,',','.')."&nbsp;&nbsp;Grs.&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp"; else echo "&nbsp;";?>
     <?php if(isset($PesoMuestraR)) echo number_format($PesoMuestraR,0,',','.')."&nbsp;&nbsp;Grs."; else echo "&nbsp;";?></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Ex.Lote:</td>
    <td class="Colum01"><strong>
	<?php echo $ExLote;?></strong>&nbsp;</td>
    <td align="right" class="Colum01">Muestra Paralela:</td>
    <td class="Colum01"><strong>
    <?php if(isset($MuestraParalela)) echo $MuestraParalela."&nbsp;&nbsp;"; else echo "&nbsp;";?></strong>
    </td>
  </tr>
  
  <tr class="ColorTabla02">
    <td class="Colum01">Peso Humedo:</td>
    <td class="Colum01">
	<?php 
	if(isset($PesoHumLote)) 
		if($ProdRecepcion=='PMN')
			echo number_format($PesoHumLote,4,'','.')."&nbsp;&nbsp;Kgrs."; 
		else
			echo number_format($PesoHumLote,0,'','.')."&nbsp;&nbsp;Kgrs."; 
	else echo "&nbsp;";
	?>	</td>
    <td align="right" class="Colum01">Peso Seco:</td>
    <td class="Colum01">
<?php 
	if(isset($PesoSecoLote)) 
		if($ProdRecepcion=='PMN')
			echo number_format($PesoSecoLote,4,'','.')."&nbsp;&nbsp;Kgrs."; 
		else
			echo number_format($PesoSecoLote,0,'','.')."&nbsp;&nbsp;Kgrs."; 
	else echo "&nbsp;";?>	</td>
  </tr>
  <tr align="center" class="Colum01">
	  <td height="30" colspan="4" class="Colum01">
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:70px " onClick="Proceso('I')">
		<input name="BtnSalir" type="button" value="Salir" style="width:70px " onClick="Proceso('S')" >
	  </td>
	</tr>
	</table>
	<br>
	<?php
	if($Mostrar=='S')
	{
		echo "<table width='750'  border='1' align='center' cellpadding='2' cellspacing='0' class='TablaInterior'>";
		echo "<tr align='center'>";
		switch($Petalo)		  
		{
			case "H":
				echo "<td><strong>Leyes Humedad</strong></td>";
				break;
			case "L":
				echo "<td><strong>Leyes</strong></td>";
				break;
			default:
				echo "<td><strong>Recargos</strong></td>";
				break;
		}		
		echo "</tr>";
		echo "<tr><td colspan='3'>";
		switch($Petalo)		  
		{
			case "H"://LEY HUMEDAD
				include("age_adm_cierre_lote_humedad.php");
				break;
			case "L"://LEYES
				include("age_adm_cierre_lote_leyes_res.php");
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
