<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=100;
	if(!isset($CmbMes))
	{
		$LoteIni=substr(date('Y'),2,2).str_pad(date('n'),2,'0',STR_PAD_LEFT)."0001";
		$LoteFin=substr(date('Y'),2,2).str_pad(date('n'),2,'0',STR_PAD_LEFT)."9999";
	}
	else
	{
		if (substr($CmbAno,0,4)<2006)
		{
			$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
			$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
		}
		else
		{
			$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
			$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";;
		}
	}	
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	$Consulta="select count(*) as cant from age_web.lotes where lote between '$LoteIni' and '$LoteFin' and canjeable='S'";
	$Respuesta=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Respuesta))
	{
		$CantLotesCanjeados=$Fila[cant];
	}
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");		
?>
<html>
<head>
<title>AGE-Consulta Envio de Lotes Canjeados Arbitral</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt,opt2)
{
	var f = document.frmPrincipal;
	var Valores='';
	switch (opt)
	{
		case "B"://BUSCAR
			if(f.TxtLoteIni.value=='')
			{
				//BUSQUEDA POR MES(BM)
				f.action = "age_con_envio_paquetes_arbitrales.php?Recarga=S&TipoBusqueda=BM&Buscar=S";
			}
			else
			{
				//BUSQUEDA POR LOTE(BL)
				if(f.TxtLoteFin.value=='')
					f.TxtLoteFin.value=f.TxtLoteIni.value;
				f.action = "age_con_envio_paquetes_arbitrales.php?Recarga=S&TipoBusqueda=BL&Buscar=S";
			}
			f.submit();		
			break;		
		case "I"://IMPRIMIR			
			window.print();
			break;
		case "E"://EXCEL	
			if(f.TxtLoteIni.value=='')
			{
				f.action = "age_con_envio_paquetes_arbitrales_excel.php?Recarga=S&TipoBusqueda=BM&Buscar=S";			}
			else
			{
				if(f.TxtLoteFin.value=='')
					f.TxtLoteFin.value=f.TxtLoteIni.value;
				f.action = "age_con_envio_paquetes_arbitrales_excel.php?Recarga=S&TipoBusqueda=BL&Buscar=S";
			}
			f.submit();	
			break;		
		case "S"://SALIR
			frmPrincipal.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=40";
			frmPrincipal.submit();
			break;			
	}
}
function DetalleLote(Lote)
{
	window.open("../age_web/age_adm_canje_leyes.php?EsPopup=S&TxtLote="+Lote,"","top=0,left=0,width=800,height=600,scrollbars=yes,resizable = yes");					
}
function DetalleLeyes(Lote)
{
	window.open("../age_web/age_certificado_leyes_canje.php?Valores="+Lote,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
-->
</style>
</head>
<body onLoad="window.document.frmPrincipal.TxtLoteIni.focus();">
<form name="frmPrincipal" action="" method="post">
<table width="544"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02" align="center">
    <td colspan="4"><strong>ENVIO DE LOTES CANJEADOS ARBITRALES</strong></td>
  </tr>
  <tr class="Colum01">
    <td width="88" class="Colum01">Mes:</td>
    <td class="Colum01"><?php
			echo "<select name='CmbMes' size='1' style='width:90px;'>";
			for($i=1;$i<13;$i++)
			{
				if ($i==$CmbMes&&$Recarga=='S')
					echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
				else if ($i==date("n")&&$Recarga!='S')	
					echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
				else	
					echo "<option value='".$i."'>".$meses[$i-1]."</option>";
			}
			echo "</select>";
			echo "<select name='CmbAno' size='1' style='width:70px;'>";
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if ($i==$CmbAno&&$Recarga=='S')
					echo "<option selected value ='$i'>$i</option>";
				else if ($i==date('Y')&&$Recarga!='S')
					echo "<option selected value ='$i'>$i</option>";
				else		
					echo "<option value='".$i."'>".$i."</option>";
			}
			echo "</select>";
			?>&nbsp;&nbsp;&nbsp;&nbsp;<strong><font color="#FF0000">Lotes Canjeados en el Mes:</font></strong>&nbsp;&nbsp;
      <input name="textfield" type="text" class='InputColor' value='<?php echo $CantLotesCanjeados;?>' size="8" readonly="true"></td>
  </tr>
  <tr class="Colum01">
    <td width="71" class="Colum01">Lote Inicio:</td>
    <td width="664" class="Colum01"><input <?php echo $EstadoInput; ?> name="TxtLoteIni" type="text" class="InputCen" value="<?php echo $TxtLoteIni; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');">
      &nbsp;&nbsp;&nbsp;
      Lote Final: 
        <input <?php echo $EstadoInput; ?> name="TxtLoteFin" type="text" class="InputCen" id="TxtLote2" value="<?php echo $TxtLoteFin; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');">
        &nbsp;&nbsp;&nbsp;
  </tr>
  <tr align="center" class="Colum01">
	  <td height="30" colspan="4" class="Colum01">
		<input name="BtnOK" type="button" value="Buscar" style="width:80px " onClick="Proceso('B')">
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:80px " onClick="Proceso('I','<?php echo $Petalo?>')">
		<input name="BtnExcel" type="button" value="Excel" style="width:80px " onClick="Proceso('E','<?php echo $Petalo?>')">
		<input name="BtnSalir" type="button" value="Salir" style="width:80px " onClick="Proceso('S')">
	  </td>
	</tr>
  </table>
	<br>
	<table width='700'  border='1' align='center' cellpadding='1' cellspacing='0' class='TablaInterior'>
	<tr align="center" class="ColorTabla01">
	<td width="14" rowspan="2">N�</td>
	<td width="24" rowspan="2">Lote</td>
	<td width="56" rowspan="2">Proveedor</td>
	<td colspan="3">Pastas a tercero</td>
	<td width="58" rowspan="2">Laboratorio</td>
	<td width="68" rowspan="2">Fecha<br>Canje</td>
	<td width="99" rowspan="2">Fecha<br>Solic.Pqtes</td>
	</tr>
	<tr align="center" class="ColorTabla01">
	<td width="26">Cu</td>
	<td width="26">Ag</td>
	<td width="30">Au</td>
	</tr>
	<?php
	if($Buscar=='S')
	{

		
		$Cont=1;
		$Consulta ="select t1.fecha_sol_pqts,t1.fecha_canje,t1.fecha_recepcion,t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.abreviatura as nom_subproducto,t1.rut_proveedor,t4.nombre_prv as nom_prv,t1.num_conjunto, t1.cod_recepcion,";
		$Consulta.="t1.cod_faena,t5.descripcion as nom_faena,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.valor_subclase1 as nom_recepcion,t10.nombre_subclase as nom_lab ";
		$Consulta.="from age_web.lotes t1 inner join age_web.leyes_por_lote_canje t9 on t1.lote=t9.lote and t9.paquete_canje='2' and t9.pendiente='S' left join ";
		$Consulta.="proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto left join ";
		$Consulta.="sipa_web.proveedores t4 on t1.rut_proveedor=t4.rut_prv left join ";
		$Consulta.="age_web.mina t5 on t1.cod_faena=t5.cod_faena left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15003' and t1.estado_lote=t6.cod_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t7 on t7.cod_clase='15001' and t1.clase_producto=t7.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t8 on t8.cod_clase='15002' and t1.cod_recepcion=t8.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t10 on t10.cod_clase='15009' and t1.laboratorio_externo=t10.cod_subclase ";
		switch($TipoBusqueda)
		{
			case "BL"://POR LOTE
				$Consulta.= "where t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";
				break;
			case "BM"://POR MES
				if ($CmbAno<2006)
				{
					$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
					$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
				}
				else
				{	
					$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
					$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";
				}
				$Consulta.= "where t1.lote between '".$LoteIni."' and '".$LoteFin."'";
				//$Consulta.= "where t1.lote ='06110045'";
				break;
		}	
		$Consulta.=" and t1.canjeable='S' group by t1.lote";
		//echo $Consulta."<br>";
		$Resp = mysqli_query($link, $Consulta);
		while($Fila = mysqli_fetch_array($Resp))
		{
			$ArrLeyesCanje=array();
			$ArrLeyesCanje["02"][0]="02";
			$ArrLeyesCanje["02"][1]="Cu";
			$ArrLeyesCanje["02"][2]=0;
			$ArrLeyesCanje["02"][3]=0;
			$ArrLeyesCanje["02"][4]=0;
			$ArrLeyesCanje["04"][0]="03";
			$ArrLeyesCanje["04"][1]="Ag";
			$ArrLeyesCanje["04"][2]=0;
			$ArrLeyesCanje["04"][3]=0;
			$ArrLeyesCanje["04"][4]=0;
			$ArrLeyesCanje["05"][0]="05";
			$ArrLeyesCanje["05"][1]="Au";
			$ArrLeyesCanje["05"][2]=0;
			$ArrLeyesCanje["05"][3]=0;
			$ArrLeyesCanje["05"][4]=0;
			echo "<tr>";
			echo "<td>".$Cont."</td>";
			echo "<td><a href=\"JavaScript:DetalleLote('".$Fila[lote]."')\">$Fila[lote]</a></td>";
			echo "<td>".$Fila[nom_prv]."</td>";
			$Consulta="select * from age_web.leyes_por_lote_canje where lote='".$Fila[lote]."' and paquete_canje='2' and pendiente='S'";
			$RespLeyes=mysqli_query($link, $Consulta);
			while($FilaLeyes=mysqli_fetch_array($RespLeyes))
			{
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][2]=$FilaLeyes[valor1];
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][3]=$FilaLeyes[valor2];
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][4]=$FilaLeyes[valor3];
			}
			reset($ArrLeyesCanje);
			while(list($c,$v)=each($ArrLeyesCanje))
			{
				if($v[2]!=0)
					echo "<td>".$v[1]."</td>";
				else
					echo "<td>-</td>";
			}			
			echo "<td>".$Fila[nom_lab]."&nbsp;</td>";
			echo "<td>".substr($Fila[fecha_canje],2)."</td>";
			if($Fila[fecha_sol_pqts]!='0000-00-00')
				echo "<td>".substr($Fila[fecha_sol_pqts],2)."&nbsp;</td>";
			else
				echo "<td>&nbsp;</td>";
			echo "</tr>";
			$Cont++;
		}
	}
	?>
	</table>	
</form>
</body>
</html>
