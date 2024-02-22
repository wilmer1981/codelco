<?php
	include("../principal/conectar_principal.php");
	include("../age_web/age_funciones.php");
	include("funciones_interfaces_codelco.php");	
?>
<html>
<head>
<title>Interfaces codelco</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../principal/funciones/funciones_java.js"></script> 
<script language="JavaScript">
function Proceso(Proceso)
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	var Resp="";
	
	switch (Proceso)
	{
		case "I"://IMPRIMIR			
			window.print();
			break;
		case "S"://SALIR
			window.close();
			break;
	} 
}
function Detalle(Lote)
{
	window.open("../age_web/age_adm_lotes_imp_web.php?TxtLote="+Lote,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
    <table width="820" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr>
        <td align="left" class="Detalle01">
		<?php 
			$FechaIni=$Ano."-".$Mes."-01 00:00:00";
			$FechaFin=$Ano."-".$Mes."-31 23:59:59";
			$Consulta="select descripcion from proyecto_modernizacion.subproducto where cod_producto ='".$Producto."' and cod_subproducto='".$SubProducto."'";
			$RespProd = mysqli_query($link, $Consulta);
			$FilaProd = mysqli_fetch_array($RespProd);
			echo "<strong>FECHA: </strong>".$FechaIni." al ".$FechaFin."&nbsp;&nbsp;&nbsp;&nbsp;<strong>SUBPRODUCTO: </strong>".$FilaProd["descripcion"]."&nbsp;&nbsp;&nbsp;&nbsp;";
			$Consulta="select NOMPRV_A as nom_prv from rec_web.proved where RUTPRV_A ='".$RutPrv."'";
			$RespProv = mysqli_query($link, $Consulta);
			$FilaProv = mysqli_fetch_array($RespProv);
			if($RutPrv=='99999999-9')
				echo "<strong>PROVEEDOR: </strong>".$RutPrv." - VARIOS ENAMI";
			else
				echo "<strong>PROVEEDOR: </strong>".$RutPrv." - ".$FilaProv[nom_prv];
		?>
		</td>
      </tr>
    </table>
	<br>
    <table width="820" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr>
		<td align="center" class="Detalle02">
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:80px " onClick="Proceso('I')">
		<input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="JavaScript:Proceso('S')"></td>
      </tr>
    </table>
    <br>
      <table width="820" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr align="center" class="ColorTabla01">
		<td colspan="2">&nbsp;</td>
		<td colspan="2">Pesos(Kg)</td>
		<?php
			$ArrLeyes=array();
			DefinirArregloLeyes('1',$SubProducto,&$ArrLeyes);
			$CantLeyes=count($ArrLeyes);
		?>
		<td colspan="<?php echo $CantLeyes;?>">Finos</td>
		</tr>
		<tr align="center" class="ColorTabla01">
          <td width="30">Lote</td>
		  <td width="10">Est.</td>
		  <td width="80">Hum.</td>
		  <td width="80">Seco</td>
		  <?php
			$ArrLeyes=array();
			DefinirArregloLeyes('1',$SubProducto,&$ArrLeyes);
		  	while(list($c,$v)=each($ArrLeyes))
			{
				$Consulta="select t1.abreviatura as nom_ley,t2.abreviatura as nom_unidad,t2.conversion from proyecto_modernizacion.leyes t1 inner join proyecto_modernizacion.unidades t2 ";
				$Consulta.="on t1.cod_unidad =t2.cod_unidad where t1.cod_leyes='".$c."'";
				$RespLeyes=mysqli_query($link, $Consulta);
				$FilaLeyes=mysqli_fetch_array($RespLeyes);
				//echo "<td width='80'>".$FilaLeyes[nom_ley]."(".$FilaLeyes[nom_unidad].")</td>";
				echo "<td width='80'>".$FilaLeyes[nom_ley]."</td>";
				
			}
		  
		  ?>
        </tr>
        <?php
			$Consulta="select * from interfaces_codelco.asignaciones where rut_proveedor<>'99999999-9'";
			$RespAsig= mysqli_query($link, $Consulta);	
			$RutCompra="(";
			while ($FilaAsig=mysqli_fetch_array($RespAsig))
			{			
				$RutCompra=$RutCompra."'".$FilaAsig["rut_proveedor"]."',";
			}
			$RutCompra=substr($RutCompra,0,strlen($RutCompra)-1);
			$RutCompra=$RutCompra.")";
			$Consulta ="select distinct t1.rut_proveedor,t2.NOMPRV_A as nom_prv from age_web.lotes t1 left join rec_web.proved t2 on t1.rut_proveedor=t2.RUTPRV_A ";
			$Consulta.="where t1.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."' ";
			$Consulta.="and t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$SubProducto."' ";
			if($RutPrv!='99999999-9')
				$Consulta.=" and t1.rut_proveedor='".$RutPrv."'";
			else
				$Consulta.=" and t1.rut_proveedor not in ".$RutCompra;
			$Consulta.=" order by t1.rut_proveedor";
			$RespPrv = mysqli_query($link, $Consulta);
			while ($FilaPrv = mysqli_fetch_array($RespPrv))
			{
				echo "<tr class='Detalle01'>\n";
				echo "<td colspan='".($CantLeyes+4)."' align='center'>PROVEEDOR:&nbsp;$FilaPrv["rut_proveedor"]&nbsp;&nbsp;&nbsp;$FilaPrv[nom_prv]</td>\n";	
				echo "</tr>\n";
				$Consulta ="select distinct t1.lote,estado_lote from age_web.lotes t1 left join age_web.leyes_por_lote t3 on t1.lote=t3.lote ";
				$Consulta.="where t1.estado_lote <> '6' and t1.rut_proveedor='".$FilaPrv["rut_proveedor"]."' and t1.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."' ";
				$Consulta.="and t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$SubProducto."' order by t1.lote";
				//echo $Consulta;
				$TotalPesoHumProv=0;$TotalPesoSecoProv=0;$TotalAjusteCuProv=0;$TotalAjusteAgProv=0;$TotalAjusteAuProv=0;
				$RespLote = mysqli_query($link, $Consulta);
				while ($FilaLote = mysqli_fetch_array($RespLote))
				{
					echo "<tr align='center'>\n";
					echo "<td><a href=JavaScript:Detalle('$FilaLote[lote]')>$FilaLote[lote]</a></td>\n";
					if($FilaLote[estado_lote]=='4')
						echo "<td><STRONG><font color='#000000'>C</font></STRONG></td>\n";
					else
						echo "<td><STRONG><font color='#FF0000'>A</font></STRONG></td>\n";	
					$DatosLote= array();
					$ArrLeyes=array();
					$DatosLote["lote"]=$FilaLote[lote];
					DefinirArregloLeyes($Producto,$SubProducto,&$ArrLeyes);
					LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
					echo "<td>".number_format($DatosLote[peso_humedo],0,'','.')."</td>\n";
					echo "<td>".number_format($DatosLote[peso_seco],0,'','.')."</td>\n";
					reset($ArrLeyes);
					while(list($c,$v)=each($ArrLeyes))
					{
						if($c!='')						
							echo "<td>".number_format($v[23],2,',','.')."</td>\n";	
					}
					echo "</tr>\n";
				}
				echo "<tr class='Detalle02'>\n";
				echo "<td colspan='2'>TOTAL</td>\n";
				$DatosLotePrv= array();
				$ArrLeyesPrv=array();
				DefinirArregloLeyes($Producto,$SubProducto,&$ArrLeyesPrv);
				LeyesProveedor('',$FilaPrv["rut_proveedor"],$Producto,$SubProducto,&$DatosLotePrv,&$ArrLeyesPrv,'N','S','S',$FechaIni,$FechaFin,"");
				echo "<td align='center'>".number_format($DatosLotePrv[peso_humedo],0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($DatosLotePrv[peso_seco],0,'','.')."</td>\n";
				reset($ArrLeyesPrv);
				while(list($c,$v)=each($ArrLeyesPrv))
				{
					if($c!='')
						echo "<td align='center'>".number_format($v[23],2,',','.')."</td>\n";	
				}
				echo "</tr>\n";
				echo "<tr class='Detalle02'>\n";
				echo "<td colspan='4'>LEY PONDERADA</td>\n";
				reset($ArrLeyesPrv);
				while(list($c,$v)=each($ArrLeyesPrv))
				{
					if($c!='')					
						echo "<td align='center'>".number_format($v[2],2,',','.')."</td>\n";	
				}
				echo "</tr>\n";				
			}
			if($RutPrv=='99999999-9')			
			{
				echo "<tr class='Detalle03'>\n";
				echo "<td colspan='2'>TOT.PROD</td>\n";	
				$DatosLoteProd= array();
				$ArrLeyesProd=array();
				DefinirArregloLeyes($Producto,$SubProducto,&$ArrLeyesProd);
				LeyesProducto($RutCompra,'','',$Producto,$SubProducto,&$DatosLoteProd,&$ArrLeyesProd,'N','S','S',$FechaIni,$FechaFin,"");
				echo "<td align='center'>".number_format($DatosLoteProd[peso_humedo],0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($DatosLoteProd[peso_seco],0,'','.')."</td>\n";
				reset($ArrLeyesProd);
				while(list($c,$v)=each($ArrLeyesProd))
				{
					if($c!='')				
						echo "<td align='center'>".number_format($v[23],2,',','.')."</td>\n";	
				}
				echo "</tr>\n";
				echo "<tr class='Detalle03'>\n";
				echo "<td colspan='4'>LEY PONDERADA</td>\n";	
				reset($ArrLeyesProd);
				while(list($c,$v)=each($ArrLeyesProd))
				{
					if($c!='')				
						echo "<td align='center'>".number_format($v[2],2,',','.')."</td>\n";	
				}
				echo "</tr>\n";
			}	
		?>
      </table>
</form>
</body>
</html>