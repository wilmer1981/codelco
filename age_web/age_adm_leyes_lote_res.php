<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=32;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	//COLORES DE LIMITES
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15007'";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		switch ($Fila["cod_subclase"])
		{
			case 1:
				$BajoMin=$Fila["valor_subclase1"];
				break;
			case 2:
				$SobreMax=$Fila["valor_subclase1"];
				break;
		}
	}
	//ARREGLO DE LIMITES
	$ArrLimites=array();
	if ($Plantilla!="S")
	{		
		$Consulta = "select * from age_web.limites where cod_plantilla='".$Plantilla."'";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$ArrLimites[$Fila["cod_leyes"]]["min"]=$Fila["limite_minimo"];
			$ArrLimites[$Fila["cod_leyes"]]["med"]=$Fila["limite_medio"];
			$ArrLimites[$Fila["cod_leyes"]]["max"]=$Fila["limite_maximo"];
			$ArrLimites[$Fila["cod_leyes"]]["usada"]="S";
		}
	}	
	
	$Mostrar='N';
	if (isset($TxtLote))
	{
		$EstadoInput = "";
		$Consulta ="select t3.recepcion,t1.num_lote_remuestreo,t1.fecha_recepcion,t1.muestra_paralela,t1.canjeable,t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.descripcion as nom_subproducto,t1.rut_proveedor,t4.nombre_prv as nom_prv,t1.num_conjunto,";
		$Consulta.="t1.cod_faena,t5.nombre_mina as nom_faena,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.nombre_subclase as nom_recepcion ";
		$Consulta.="from age_web.lotes t1 left join ";
		$Consulta.="proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto left join ";
		$Consulta.="sipa_web.proveedores t4 on t1.rut_proveedor=t4.rut_prv left join ";
		$Consulta.="sipa_web.minaprv t5 on t1.rut_proveedor=t5.rut_prv and t1.cod_faena=t5.cod_mina left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15003' and t1.estado_lote=t6.cod_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t7 on t7.cod_clase='15001' and t1.clase_producto=t7.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t8 on t8.cod_clase='3104' and t1.cod_recepcion=t8.nombre_subclase ";
		$Consulta.= "where t1.lote = '".$TxtLote."'";
		//echo $Consulta;
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$Mostrar='S';
			if($Fila[canjeable]=='S')
			{
				$CheckCanjeSi='checked';
				$CheckCanjeNo='';
			}
			else
			{
				$CheckCanjeSi='';
				$CheckCanjeNo='checked';
			}	
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
			$FechaRecepcion=$Fila["fecha_recepcion"];
			$ExLote=$Fila["num_lote_remuestreo"];
			$ProdRecepcion=$Fila["recepcion"];
			$DatosLote= array();
			$ArrLeyes=array();
			$DatosLote["lote"]=$TxtLote;
			LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
			if($DatosLote["tipo_remuestreo"]=='A')
			{
				$PesoSecoLote=$DatosLote["peso_seco2_ori"];
				$PesoHumLote=$DatosLote["peso_humedo_ori"];
			}
			else
			{
				if ($DatosLote["recepcion"]=="PMN")
				{
					$PesoSecoLote=$DatosLote["peso_seco"];
					$PesoHumLote=$DatosLote["peso_humedo"];
				}
				else
				{
					$PesoSecoLote=$DatosLote["peso_seco2"];
					$PesoHumLote=$DatosLote["peso_humedo"];
				}
			}	
			$AnoMes=substr($TxtLote,0,3);
			$LoteCons = $TxtLote;
			/*if ($RutProveedor=="1100-2")
			{
				$Consulta = "select * from sea_web.relaciones where lote_ventana='".$TxtLote."'";
				$RespAux=mysqli_query($link, $Consulta);
				$FilaAux = mysqli_fetch_array($RespAux);
				$LoteCons = $FilaAux["lote_origen"];					
			}			*/	
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

			$Consulta = "select distinct t1.id_muestra,t1.nro_solicitud, t1.recargo ";
			$Consulta.= " from cal_web.solicitud_analisis t1 ";
			$Consulta.= " where t1.id_muestra='".$LoteCons."' "; //and t1.agrupacion in(1,3,6)";// and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProducto'";
			
			if($EsPopup=='S')
			{
				if($Recargo=='')
					$Consulta.= " and (t1.recargo='0' or t1.recargo='')";
				else
					$Consulta.= " and t1.recargo='".$Recargo."'";
			}
			else
				$Consulta.= " and (t1.recargo='0' or t1.recargo='')";
			//echo $Consulta;
			$RespSA=mysqli_query($link, $Consulta);
			if($FilaSA=mysqli_fetch_array($RespSA))
			{
				$SA=$FilaSA["nro_solicitud"];
				if(is_null($FilaSA["recargo"]) or $FilaSA["recargo"]=='')
					$Recargo='N';
				else
					$Recargo=$FilaSA["recargo"];
			}
			else
			{
				$SA='N';
				$Recargo='N';
			}
		}
	}
?>
<html>
<head>
<title>AGE-Adm. Leyes Lotes</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function Proceso(opt,opt2)
{
	var f = document.frmPrincipal;
	var Valores='';
	switch (opt)
	{
		case "P"://PETALOS
			f.action = "age_adm_leyes_lote_res.php?Petalo="+opt2+"&EsPopup="+f.TxtEsPopup.value;
			f.submit();	
			break;
		case "I"://IMPRIMIR			
			if (f.TxtLote.value=="")
			{
				alert("Debe Ingresar Num. Lote");
				f.TxtLote.focus();
				return;
			}
			window.open("age_adm_cierre_lote_imprimir_res.php?TxtLote="+f.TxtLote.value+"&Petalo="+opt2+"&CmbPlantilla="+f.CmbPlantilla.value,"","top=30,left=2,width=770,heiht=500,scrollbars=yes,resizable=yes");
			break;
		case "E"://EXCEL	
			if (f.TxtLote.value=="")
			{
				alert("Debe Ingresar Num. Lote");
				f.TxtLote.focus();
				return;
			}
			f.action="age_adm_cierre_lote_excel.php?TxtLote="+f.TxtLote.value+"&Petalo="+opt2;
			f.submit();
			break;		
		case "R"://RECARGA					
			f.action = "age_adm_leyes_lote_res.php";
			f.submit();
			break
		case "S"://SALIR
			if(f.TxtEsPopup.value=='S')
				window.close();
			else	
				frmPrincipal.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=30";
				frmPrincipal.submit();
			break;			
	}
}
function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 400 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function DetalleHistorica(CmbSubProducto,CmbProveedor,CmbAnoIni,CmbAnoFin,LeyUnica,MesCons)
{
	window.open("age_con_leyes_historicas_mensual.php?Mes="+MesCons+"&PopUp=S&MesAnt=S&CmbSubProducto="+ CmbSubProducto+"&CmbProveedor="+CmbProveedor+"&CmbAnoIni="+CmbAnoIni+"&CmbAnoFin="+CmbAnoFin+"&LeyUnica="+LeyUnica,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body,td,th {
	font-size: 10p�xele;
}
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<?php
if($EsPopup=='S')
	$Fondo="background='../principal/imagenes/fondo3.gif'";
else
	$Fondo="";	
?>
<body onLoad='window.document.frmPrincipal.TxtLote.focus();' <?php echo $Fondo;?>>
<form name="frmPrincipal" action="" method="post">
<?php
if(!isset($TxtEsPopup))
	echo "<input type='hidden' name='TxtEsPopup' value='$EsPopup'>";
else
	echo "<input type='hidden' name='TxtEsPopup' value='$TxtEsPopup'>";
if($EsPopup!='S')
{
	include("../principal/encabezado.php");
	echo "<table class='TablaPrincipal' width='770'>";
	echo "<tr>";
	echo "<td width='770' height='340' align='center' valign='top'>";
}	
?>
<table width="750"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02">
    <td colspan="4"><strong>ADM. LEYES LOTE </strong></td>
  </tr>
  <tr class="Colum01">
    <td width="88" class="Colum01">Lote:</td>
    <td class="Colum01">
    <?php
		if($EsPopup!='S')
		{
			echo "<input $EstadoInput name='TxtLote' type='text' class='InputCen' value='$TxtLote' size='10' maxlength='10' onKeyDown=TeclaPulsada2('S',true,this.form,'BtnOK') >&nbsp;";
			echo "<input name='BtnOK' type='button' value='OK' onClick=Proceso('R') onFocus=Proceso('R')>";
		}
		else
			echo "<input $EstadoInput name='TxtLote' type='text' class='InputCen' value='$TxtLote' size='10' maxlength='10' onKeyDown=TeclaPulsada2('S',true,this.form,'BtnOK') readonly='true'>";
	?>
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
			<?php if(isset($PesoRetallaR)) echo number_format($PesoRetallaR,4,',','.')."&nbsp;&nbsp;Grs."; else echo "&nbsp;";?>
		</td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Estado Lote:</td>
    <td class="Colum01"><strong><font color="#FF3300"><?php if(isset($EstadoLote)) echo strtoupper($EstadoLote); else echo "&nbsp;";?></font></strong></td>
    <td align="right" class="Colum01">Peso Muestra: </td>
    <td  colspan="2">
		<?php if(isset($PesoMuestra)) echo number_format($PesoMuestra,0,',','.')."&nbsp;&nbsp;Grs.&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp"; else echo "&nbsp;";?>
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
	<?php if(isset($PesoHumLote)) 
		if($ProdRecepcion=='PMN')
			echo number_format($PesoHumLote,4,'','.')."&nbsp;&nbsp;Kgrs."; 
		else
			echo number_format($PesoHumLote,0,'','.')."&nbsp;&nbsp;Kgrs."; 
	   else 
	   	echo "&nbsp;";?></td>
    <td align="right" class="Colum01">Peso Seco:</td>
    <td class="Colum01">
	<?php if(isset($PesoSecoLote)) 
		if($ProdRecepcion=='PMN')
			echo number_format($PesoSecoLote,4,'','.')."&nbsp;&nbsp;Kgrs."; 
		else
			echo number_format($PesoSecoLote,0,'','.')."&nbsp;&nbsp;Kgrs."; 
	   else 
	     echo "&nbsp;";?></td>
  </tr>
  <tr align="center" class="Detalle01">
  	  <td class="Colum01">&nbsp;</td>
	  <td height="30" colspan="3" class="Colum01">
		<!--<input name="BtnCertLeyes" type="button" value="Certificado de Leyes" style="width:140px " onClick="Proceso('CL')">-->
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:70px " onClick="Proceso('I','<?php echo $Petalo?>')">
		<input name="BtnExcel" type="button" value="Excel" style="width:70px " onClick="Proceso('E','<?php echo $Petalo?>')">
		<input name="BtnSalir" type="button" value="Salir" style="width:70px " onClick="Proceso('S')">
	  </td>
	</tr>
     <tr align="center" class="Detalle01">
	<td colspan="2">
		<?php
			//if($Petalo=='L')
			//{
				echo "Plantilla M.Paral: ";
				echo "<select name='CmbPlantilla' class='Select01' style='width:220' >";
				//echo "<option value='-1'>SELECCIONAR</option>";
				$Consulta = "select distinct cod_plantilla,nombre_plantilla ";
				$Consulta.= " from age_web.limites_particion where proceso='REMUESTREO' order by cod_plantilla";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbPlantilla == $Fila["cod_plantilla"])
						echo  "<option selected value='".$Fila["cod_plantilla"]."'>".$Fila["nombre_plantilla"]."</option>\n";
					else
						echo  "<option value='".$Fila["cod_plantilla"]."'>".$Fila["nombre_plantilla"]."</option>\n";
				}
				echo "</select>";
			//}	
		?>	  		
	</td>
	<td colspan="2" align="center">
      <?php
			//BUSCO PLANTILLA PARA SUBPRODUCTO PROVEEDOR
			echo "<select name='Plantilla' style='width:300' onchange=Proceso('P','L')>";
			$Consulta = "select DISTINCT cod_plantilla, descripcion ";
			$Consulta.= " from age_web.limites ";
			$Consulta.= " where cod_producto='1'";
			$Consulta.= " and cod_subproducto='".$CodSubProducto."'";
			$Consulta.= " and rut_proveedor ='".$RutProveedor."'";
			$Consulta.= " order by descripcion ";
			echo $Consulta;
			$Resp = mysqli_query($link, $Consulta);
			$Encontro01=false;
			$i=1;
			while ($Fila = mysqli_fetch_array($Resp))
			{
				$Encontro01=true;
				if ($i==1)
					echo "<option class='NoSelec' value='S'>.::PLANTILLA ESPECIFICA::.</option>\n";
				if ($Plantilla == $Fila["cod_plantilla"])
					echo "<option selected value='".$Fila["cod_plantilla"]."'>-->".strtoupper($Fila["descripcion"])."</option>\n";
				else
					echo "<option value='".$Fila["cod_plantilla"]."'>-->".strtoupper($Fila["descripcion"])."</option>\n";
				$i++;
			}	
			//BUSCO PLANTILLA PARA SUBPRODUCTO				
			$Consulta = "select DISTINCT cod_plantilla, descripcion ";
			$Consulta.= " from age_web.limites ";
			$Consulta.= " where cod_producto='1'";
			$Consulta.= " and cod_subproducto='".$CodSubProducto."'";
			$Consulta.= " and rut_proveedor='99999999-9'";
			$Consulta.= " order by descripcion ";
			$Resp = mysqli_query($link, $Consulta);
			$Encontro02=false;
			$i=1;
			while ($Fila = mysqli_fetch_array($Resp))
			{
				$Encontro02=true;
				if ($i==1)
					echo "<option class='NoSelec' value='S'>.::PLANTILLA SUBPRODUCTO::.</option>";
				if ($Plantilla == $Fila["cod_plantilla"])
					echo "<option selected value='".$Fila["cod_plantilla"]."'>-->".strtoupper($Fila["descripcion"])."</option>\n";
				else
					echo "<option value='".$Fila["cod_plantilla"]."'>-->".strtoupper($Fila["descripcion"])."</option>\n";
				$i++;
			}
			//BUSCO PLANTILLAS EN GENERAL				
			$Consulta = "select DISTINCT cod_plantilla, descripcion ";
			$Consulta.= " from age_web.limites ";
			$Consulta.= " where cod_producto='1'";
			$Consulta.= " and cod_subproducto='0'";
			$Consulta.= " and rut_proveedor='99999999-9'";
			$Consulta.= " order by descripcion ";
			$Resp = mysqli_query($link, $Consulta);
			$Encontro03=false;
			$i=1;
			while ($Fila = mysqli_fetch_array($Resp))
			{
				$Encontro03=true;
				if ($i==1)
					echo "<option class='NoSelec' value='S'>.::PLANTILLA GENERICAS::.</option>";
				if ($Plantilla == $Fila["cod_plantilla"])
					echo "<option selected value='".$Fila["cod_plantilla"]."'>-->".strtoupper($Fila["descripcion"])."</option>\n";
				else
					echo "<option value='".$Fila["cod_plantilla"]."'>-->".strtoupper($Fila["descripcion"])."</option>\n";
				$i++;
			}
			if (!$Encontro01 && !$Encontro02 && !$Encontro03)
				echo "<option class='NoSelec' value='S'>NO HAY PLANTILLAS</option>";
			echo "</select>";
	  ?>
	</td>
	</tr>

  </table>
  <?php
		echo "<table width='750'  border='1' align='center' cellpadding='2' cellspacing='0' class='TablaInterior'>";
		echo "<tr align='center'><td>";
        echo "<table width='730' border='1' align='center' cellpadding='2' cellspacing='0'>";
		echo "<tr align='center' class='ColorTabla02'>";
		echo "<td>F.Recep.</td>";
		echo "<td>Solicitud</td>";
		echo "<td>Estado</td>";
		echo "<td>Retalla</td>";
		echo "<td>Estado</td>";
		echo "<td>Paralela</td>";
		echo "<td>Estado</td>";
		echo "</tr>";
		//SOLICITUD DEL LOTE
		$Consulta = "select distinct t2.nro_solicitud ,t2.recargo , t2.estado_actual, t3.nombre_subclase";
		$Consulta.= " from age_web.lotes t1 ";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
		$Consulta.= " where t1.lote = '".$TxtLote."' and t2.estado_actual not in ('7','16')";			
		$Consulta.= " and (t2.recargo='0' or t2.recargo='') ";	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$SA=$FilaAux["nro_solicitud"];
			$Recargo=$FilaAux["recargo"];
			$EstadoSA=$FilaAux["nombre_subclase"];
			$CodEstadoSA=$FilaAux["estado_actual"];
		}
		else
		{
			$SA="";
			$Recargo="";
			$EstadoSA="";
			$CodEstadoSA="";
		}
		//RETALLA
		$Consulta = "select distinct t2.nro_solicitud, t2.estado_actual, t3.nombre_subclase";
		$Consulta.= " from age_web.lotes t1 ";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
		$Consulta.= " where t1.lote = '".$TxtLote."' ";			
		$Consulta.= " and t2.recargo='R' ";	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$SA_Retalla=$FilaAux["nro_solicitud"];
			$EstadoRetalla=$FilaAux["nombre_subclase"];
			$CodEstadoRetalla=$FilaAux["estado_actual"];
		}
		else
		{
			$SA_Retalla="";
			$EstadoRetalla="";
			$CodEstadoRetalla="";
		}
		//MUESTRA PARALELA
		$Consulta = "select distinct t2.nro_solicitud, t2.estado_actual, t3.nombre_subclase";
		$Consulta.= " from age_web.lotes t1 ";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.muestra_paralela=t2.id_muestra  ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
		$Consulta.= " where t1.lote = '".$TxtLote."' ";			
		$Consulta.= " and (t2.recargo='0' or t2.recargo='' or isnull(t2.recargo)) ";	
		$Consulta.= " and year(t2.fecha_muestra)='".substr($FechaRecepcion,0,4)."'";
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$SA_Paralela=$FilaAux["nro_solicitud"];
			$EstadoParalela=$FilaAux["nombre_subclase"];
			$CodEstadoParalela=$FilaAux["estado_actual"];
		}
		else
		{
			$SA_Paralela="";
			$EstadoParalela="";
			$CodEstadoParalela="";
		}
		echo "<tr align=\"center\">\n";
		echo "<td>".substr($FechaRecepcion,8,2)."/".substr($FechaRecepcion,5,2)."/".substr($FechaRecepcion,0,4)."</td>\n";
		if 	($SA=="")
			echo "<td>&nbsp;</td>\n";		
		else
		{
			if ($SA!="")
				echo "<td><a href=\"JavaScript:Historial('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".$SA."</a></td>\n";
		}			
		if ($CodEstadoSA!=6 && $EstadoSA!="")
			echo "<td bgcolor='yellow'>".$EstadoSA."&nbsp;</td>\n";
		else
		{
			if ($EstadoSA!="")
				echo "<td bgcolor='#FFFFFF'>".$EstadoSA."&nbsp;</td>\n";
			else
				echo "<td>&nbsp;</td>\n";
		}
		if 	($SA_Retalla=="")
			echo "<td>&nbsp;</td>\n";		
		else
			echo "<td><a href=\"JavaScript:Historial('".$SA_Retalla."','R')\" class=\"LinksAzul\">".$SA_Retalla."</a></td>\n";
		if ($CodEstadoRetalla!=6 && $EstadoRetalla!="")
			echo "<td bgcolor='yellow'>".$EstadoRetalla."&nbsp;</td>\n";
		else
			echo "<td>".$EstadoRetalla."&nbsp;</td>\n";
		if 	($SA_Paralela=="")
			echo "<td>&nbsp;</td>\n";		
		else
			echo "<td><a href=\"JavaScript:Historial('".$SA_Paralela."','0')\" class=\"LinksAzul\">".$SA_Paralela."</a></td>\n";
		if ($CodEstadoParalela!=6 && $EstadoParalela!="")
			echo "<td bgcolor='yellow'>".$EstadoParalela."&nbsp;</td>\n";
		else
			echo "<td>".$EstadoParalela."&nbsp;</td>\n";
		echo "</tr>\n";
		echo "</table>";
		
		echo "</td></tr>";
		echo "</table>";
  ?>
	<br>
	<?php
	if($Mostrar=='S')
	{
		echo "<table width='750'  border='1' align='center' cellpadding='2' cellspacing='0' class='TablaInterior'>";
		echo "<tr align='center'>";
		switch($Petalo)		  
		{
			case "H":
				echo "<td><a href=JavaScript:Proceso('P','R');>Recargos</a></td>";
				echo "<td><a href=JavaScript:Proceso('P','H');><strong>Leyes Humedad</strong></a></td>";
				echo "<td><a href=JavaScript:Proceso('P','L');>Leyes</a></td>";
				break;
			case "L":
				echo "<td><a href=JavaScript:Proceso('P','R');>Recargos</a></td>";
				echo "<td><a href=JavaScript:Proceso('P','H');>Leyes Humedad</a></td>";
				echo "<td><a href=JavaScript:Proceso('P','L');><strong>Leyes</strong></a></td>";
				break;
			default:
				echo "<td><a href=JavaScript:Proceso('P','R');><strong>Recargos</strong></a></td>";
				echo "<td><a href=JavaScript:Proceso('P','H');>Leyes Humedad</a></td>";
				echo "<td><a href=JavaScript:Proceso('P','L');>Leyes</a></td>";
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
		echo "</table><br>";
	}	
if($EsPopup!='S')
{ 
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	include("../principal/pie_pagina.php"); 
}	
?>
</form>
</body>
</html>