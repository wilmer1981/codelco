<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 93;
	include("../principal/conectar_principal.php");
	if (!isset($ChkSolicitud))
		$ChkSolicitud="S";
	
?>
<html>
<head>
<title>AGE-Consulta Indicadores Tiempo</title>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga3()
{
	var Frm = document.frmPrincipal;
	Frm.action="age_con_indicadores_tiempo.php?Busq=S";
	Frm.submit();	
}
function Proceso(opt,valor)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "S":
			if (f.Sistema.value=="CAL")
				f.action = "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
			else
				f.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=30";
			f.submit();
			break;
		case "I":
			window.print();
			break;		
		case "R":
			f.action = "age_con_indicadores_tiempo.php";
			f.submit(); 
			break;
		case "C":
			f.action = "age_con_indicadores_tiempo.php?Mostrar=S";
			f.submit(); 
			break;
		case "E":
			f.action = "age_con_indicadores_tiempo_excel.php?Mostrar=S&Orden=<?php echo $Orden; ?>";
			f.submit(); 
			break;		
		case "O": //ORDENA
			f.action = "age_con_indicadores_tiempo.php?Mostrar=S&Orden=" + valor;
			f.submit();
			break;
	}	
}

function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}

function DetalleAnalisis(SA,Rec)
{
	window.open("age_con_detalle_leyes.php?SA="+ SA+"&Recargo="+Rec,"","top=70,left=50,width=400,height=430,scrollbars=yes,resizable = yes");					
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<input type="hidden" name="Sistema" value="<?php echo $Sistema; ?>">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="750" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="4" class="ColorTabla02"><strong>INDICADORES DE TIEMPO </strong></td>
        </tr>
        <tr>
          <td width="68" height="23" align="right">Periodo:</td>
          <td>
            <select name="Mes">
              <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (!isset($Mes))
				{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";
				}
				else
				{
					if ($i == $Mes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";						
				}				
			}		  
		?>
            </select>
            <select name="Ano" size="1">
              <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (!isset($Ano))
				{
					if ($i == date("Y"))
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";
				}
				else
				{
					if ($i == $Ano)
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";						
				}				
			}		
		?>
            </select>          
            </td>
          <td align="right">Proveedor:</td>
          <td><select name="Proveedor" style="width:300" onChange="Proceso('R')">
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				$Consulta = "select * from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rut_prv=t2.rut_proveedor ";
				$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv."%' "; 				
				$Consulta.= " order by t1.nombre_prv";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Proveedor == $Fila["rut_prv"])
						echo "<option selected value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
					else
						echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
				}
			?>
          </select></td>
        </tr>
        <tr>
          <td height="23" align="right">Producto:</td>
          <td width="291" height="23"><select name="SubProducto" style="width:250" onChange="Proceso('R')">
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($SubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
				}
			  ?>
          </select></td>
          <td width="87" align="right">Filtro Prv</td>
          <td width="269">
              <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
              <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">
          </td>
        </tr>
        <tr align="center">
          <td height="30" colspan="4"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
              <input name="BtnExcel" type="button" id="BtnExcel" style="width:70px;" onClick="Proceso('E')" value="Excel">              
              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
        </tr>
      </table>        
      <br>
        <br>
        <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
		<tr class="ColorTabla01" align="center">
			<td><a href="JavaScript:Proceso('O','PD');" class="LinksBlancoRaya">Producto</a></td>
			<td><a href="JavaScript:Proceso('O','PV');" class="LinksBlancoRaya">Proveedor</a></td>
			<td><a href="JavaScript:Proceso('O','L');" class="LinksBlancoRaya">Lote</a></td> 
			<td><a href="JavaScript:Proceso('O','FR');" class="LinksBlancoRaya">Recep.Lote</a></td>
			<td>Recep.Lab</td>
			<td>DIF.<br>(Dias)</td>
			<td>DIF.<br>(Hrs)</td>
			<td>Finaliz.</td>
			<td>DIF.<br>(Dias)</td>
			<td>DIF.<br>(Hrs)</td>
			<td>Cierre.Lote</td> 
			<td>DIF.<br>(Dias)</td>			
			<td>DIF.<br>(Hrs)</td>
			<td>TOT.<br>(Dias)</td>
			<td>TOT.<br>(Hrs)</td>			
			<!--<td><a href="JavaScript:Proceso('O','S');" class="LinksBlancoRaya">SA</a></td>
			<td>Est</td>
			<td>Retal</td> 
			<td>Est</td>
			<td>Paral</td>
			<td>Est</td>		-->	
		</tr>		
<?php		
		
if ($Mostrar=="S")
{
	if ($Ano<2006)
	{
		$LoteIni = substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."000";
		$LoteFin = substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."999";
	}
	else
	{
		$LoteIni = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."0000";
		$LoteFin = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."9999";
	}
	//CONSULTA LOS DISTINTOS PRODUCTOS Y PROVEEDORES CON MUESTRA PARALELA
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto,t1.lote, t1.muestra_paralela, t1.rut_proveedor, t3.nomprv_a, ";
	$Consulta.= " t4.nro_solicitud, t4.estado_actual, t5.nombre_subclase as estado, t6.abreviatura as nom_prod, ";
	$Consulta.= " t1.fecha_recepcion, t11.fecha_recepcion as fecha_recep_rec_0, t11.hora_entrada, t1.fecha_cierre_op, t1.estado_lote ";
	$Consulta.= " from age_web.lotes t1 ";
	$Consulta.= " left join age_web.detalle_lotes t11 on t1.lote=t11.lote and t11.recargo='1'  ";
	$Consulta.= " left join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a  ";
	$Consulta.= " left join cal_web.solicitud_analisis t4 on t1.lote=t4.id_muestra  ";
	$Consulta.= " left join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='1002' and t4.estado_actual=t5.cod_subclase ";
	$Consulta.= " left join proyecto_modernizacion.subproducto t6 on t6.cod_producto='1' and t6.cod_subproducto=t1.cod_subproducto ";
	$Consulta.= " where t1.lote between '".$LoteIni."' and '".$LoteFin."'  ";
	if ($SubProducto!="S")
		$Consulta.= " and t1.cod_producto='1' and t1.cod_subproducto='".$SubProducto."'";
	if ($Proveedor!="S")
		$Consulta.= " and t1.rut_proveedor='".$Proveedor."'";		
	$Consulta.= " and (t4.recargo='0' or t4.recargo='' or isnull(t4.recargo)) ";	
	
	switch ($Orden)
	{
		case "L":
			$Consulta.= " order by t1.lote ";
			break;
		case "S":
			$Consulta.= " order by t4.nro_solicitud ";
			break;
		case "PD":
			$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0'), t1.lote ";
			break;
		case "PV":
			$Consulta.= " order by lpad(t1.rut_proveedor,11,'0'), t1.lote ";
			break;
		case "FR":
			$Consulta.= " order by t1.fecha_recepcion, t1.lote ";
			break;
		default:
			$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0'), t1.lote ";
			break;
	}	
	$Resp = mysqli_query($link, $Consulta);
	//echo $Consulta;
	$ContSA=0;
	$ContLotes=0;
	$ContSA_Fin=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$ContDias=0;
		$ContHrs=0;
		//SOLICITUD DEL LOTE
		$Consulta = "select distinct t2.nro_solicitud ,t2.recargo , t2.estado_actual, t3.nombre_subclase";
		$Consulta.= " from age_web.lotes t1 ";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
		$Consulta.= " where t1.lote = '".$Fila["lote"]."' ";			
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
		//FECHA RECEPCION LABORATORIO
		$Consulta = "select * ";
		$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA."' ";			
		$Consulta.= " and t1.recargo='".$Recargo."' ";	
		$Consulta.= " and t1.cod_estado='4' "; //RECEPCIONADO LABORATORIO	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$FechaRecepLab=$FilaAux["fecha_hora"];
		}
		else
		{
			$FechaRecepLab="";
		}		
		//RETALLA
		$Consulta = "select distinct t2.nro_solicitud, t2.estado_actual, t3.nombre_subclase";
		$Consulta.= " from age_web.lotes t1 ";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
		$Consulta.= " where t1.lote = '".$Fila["lote"]."' ";			
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
		$Consulta.= " where t1.lote = '".$Fila["lote"]."' ";			
		$Consulta.= " and (t2.recargo='0' or t2.recargo='' or isnull(t2.recargo)) ";	
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
		//CALCULA SI TODAS SUS SOLICITUDES ESTAN FINALIZADAS SA, RETALLA, PARALELA
		//FECHA FINALIZADA SA
		$FechaFinalizSA="";
		$FechaFinalizRetalla="";
		$FechaFinalizParalela="";
		$Consulta = "select * ";
		$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA."' ";			
		$Consulta.= " and t1.recargo='".$Recargo."' ";	
		$Consulta.= " and t1.cod_estado='6' "; //RECEPCIONADO LABORATORIO	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$FechaFinalizSA=$FilaAux["fecha_hora"];
		}		
		//FECHA FINALIZADA RETALLA
		$Consulta = "select * ";
		$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA_Retalla."' ";			
		$Consulta.= " and t1.recargo='R' ";	
		$Consulta.= " and t1.cod_estado='6' "; //RECEPCIONADO LABORATORIO	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$FechaFinalizRetalla=$FilaAux["fecha_hora"];
		}		
		//FECHA FINALIZADA PARALELA
		$Consulta = "select * ";
		$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA_Paralela."' ";			
		$Consulta.= " and (t1.recargo='' or t1.recargo='0')";	
		$Consulta.= " and t1.cod_estado='6' "; //RECEPCIONADO LABORATORIO	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$FechaFinalizParalela=$FilaAux["fecha_hora"];
		}		
		$FechaFinaliz="";
		if ($SA_Retalla=="" && $SA_Paralela=="")
		{
			if ($CodEstadoSA=="6")
				$FechaFinaliz=$FechaFinalizSA;
		}
		else
		{
			if ($SA!="" && $SA_Retalla!="" && $SA_Paralela=="")
			{
				if ($CodEstadoSA=="6" && $CodEstadoRetalla=="6")
				{			
					if ($FechaFinalizRetalla > $FechaFinalizSA)
						$FechaFinaliz=$FechaFinalizRetalla;
					else
						$FechaFinaliz=$FechaFinalizSA;
				}
			}
			else
			{
				if ($CodEstadoSA=="6" && $CodEstadoRetalla=="6" && $CodEstadoParalela=="6")
				{					
					if ($FechaFinalizRetalla > $FechaFinalizSA)
					{
						if ($FechaFinalizParalela > $FechaFinalizRetalla)	
							$FechaFinaliz=$FechaFinalizParalela;
						else
							$FechaFinaliz=$FechaFinalizRetalla;
					}
					else
					{
						if ($FechaFinalizParalela > $FechaFinalizSA)
							$FechaFinaliz=$FechaFinalizParalela;
						else
							$FechaFinaliz=$FechaFinalizSA;
					}					
				}				
			}
		}
		//------------------------------------------------------
		echo "<tr align=\"center\">\n";
		echo "<td align=\"left\">".substr($Fila["nom_prod"],0,20)."&nbsp;</td>\n";
		echo "<td align=\"left\">".substr($Fila["nomprv_a"],0,20)."&nbsp;</td>\n";
		echo "<td>".$Fila["lote"]."</td>\n";
		echo "<td>".substr($Fila["fecha_recepcion"],8,2)."/".substr($Fila["fecha_recepcion"],5,2)."/".substr($Fila["fecha_recepcion"],2,2)."</td>\n";
		if ($FechaRecepLab=="")
			echo "<td>&nbsp;</td>\n";
		else
			echo "<td>".substr($FechaRecepLab,8,2)."/".substr($FechaRecepLab,5,2)."/".substr($FechaRecepLab,2,2)."</td>\n";
		//DIFERENCIA DE RECEPCION LOTE Y RECEP. LAB DIAS.
		if ($FechaRecepLab!="")
		{
			$FechaRecepLote=$Fila["fecha_recepcion"]." ".$Fila["hora_entrada"];
			DifFecha($FechaRecepLote,$FechaRecepLab,'D',&$DifFecha);
			$ContDias=$ContDias+intval($DifFecha);				
			echo "<td bgcolor=\"#FFFFFF\">".number_format($DifFecha,0,",",".")."</td>\n";
		}
		else
		{
			echo "<td bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
		}

		//DIFERENCIA DE RECEPCION LOTE Y RECEP. LAB HORAS MIN.
		if ($FechaRecepLab!="")
		{
			$FechaRecepLote=$Fila["fecha_recepcion"]." ".$Fila["hora_entrada"];
			DifFecha($FechaRecepLote,$FechaRecepLab,'H', &$DifFecha);	
			$ContHrs=$ContHrs+$DifFecha;			
			echo "<td bgcolor=\"#FFFFFF\">".number_format($DifFecha,2,",",".")."</td>\n";
		}
		else
		{
			echo "<td bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
		}
		//---------------------------------------
		if ($FechaFinaliz=="")
			echo "<td>&nbsp;</td>\n";
		else
			echo "<td>".substr($FechaFinaliz,8,2)."/".substr($FechaFinaliz,5,2)."/".substr($FechaFinaliz,2,2)."</td>\n";
		//DIFERENCIA DE RECEP.LAB Y FINALIZADA Dias.
		if ($FechaRecepLab!="" && $FechaFinaliz!="")
		{
			DifFecha($FechaRecepLab,$FechaFinaliz,'D', &$DifFecha);	
			$ContDias=$ContDias+intval($DifFecha);
			echo "<td bgcolor=\"#FFFFFF\">".number_format($DifFecha,0,",",".")."</td>\n";
		}
		else
		{
			echo "<td bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
		}

		//DIFERENCIA DE RECEP.LAB Y FINALIZADA HORAS Y MIN.
		if ($FechaRecepLab!="" && $FechaFinaliz!="")
		{
			DifFecha($FechaRecepLab,$FechaFinaliz,'H', &$DifFecha);
			$ContHrs=$ContHrs+$DifFecha;	
			echo "<td bgcolor=\"#FFFFFF\">".number_format($DifFecha,2,",",".")."</td>\n";
		}
		else
		{
			echo "<td bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
		}
		//---------------------------------------		
		if ($Fila["estado_lote"]==4)
		{
			echo "<td >".substr($Fila["fecha_cierre_op"],8,2)."/".substr($Fila["fecha_cierre_op"],5,2)."/".substr($Fila["fecha_cierre_op"],2,2)."</td>\n";
			//DIFERENCIA DE RECEP.LAB Y FINALIZADA DIAS.
			if ($Fila["fecha_cierre_op"]!="0000-00-00")
			{
				DifFecha($FechaFinaliz,$Fila["fecha_cierre_op"],'D', &$DifFecha);
				$ContDias=$ContDias+intval($DifFecha);	
				echo "<td bgcolor=\"#FFFFFF\">".number_format($DifFecha,0,",",".")."</td>\n";
			}
			else
			{
				echo "<td bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
			}
			//DIFERENCIA DE RECEP.LAB Y FINALIZADA HORAS Y MIN.
			if ($Fila["fecha_cierre_op"]!="0000-00-00")
			{
				DifFecha($FechaFinaliz,$Fila["fecha_cierre_op"],'H', &$DifFecha);
				$ContHrs=$ContHrs+$DifFecha;	
				echo "<td bgcolor=\"#FFFFFF\">".number_format($DifFecha,2,",",".")."</td>\n";
			}
			else
			{
				echo "<td bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
			}
			//---------------------------------------		
		}
		else
		{
			echo "<td>&nbsp;</td>\n";
			echo "<td bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
			echo "<td bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
		}
		echo "<td bgcolor=\"#FFFFFF\">".number_format($ContDias,0,",",".")."</td>\n";
		echo "<td bgcolor=\"#FFFFFF\">".number_format($ContHrs,2,",",".")."</td>\n";
		echo "</tr>\n";
		$ContLotes++;
		if ($Fila["nro_solicitud"]!="")
			$ContSA++;				
		if ($Fila["estado_actual"]=="6")
			$ContSA_Fin++;
	}
}//FIN MOSTRAR = S	

function DifFecha($Fecha1, $Fecha2, $Tipo, $DifFecha)
{
	//echo $Fecha1."<br>";
	$AnoAux=substr($Fecha1,0,4);
	$MesAux=substr($Fecha1,5,2);
	$DiaAux=substr($Fecha1,8,2);
	$HoraAux=substr($Fecha1,11,2);
	$MinutoAux=substr($Fecha1,14,2);
	$SegundoAux=substr($Fecha1,17,2);
	//echo $Fecha2."<br>";
	$AnoAux2=substr($Fecha2,0,4);
	$MesAux2=substr($Fecha2,5,2);
	$DiaAux2=substr($Fecha2,8,2);
	$HoraAux2=substr($Fecha2,11,2);
	$MinutoAux2=substr($Fecha2,14,2);
	$SegundoAux2=substr($Fecha2,17,2);
	//echo $Fecha1." - ".$Fecha2."<br>";	
	//echo $HoraAux2."-".$HoraAux.", ".$MinutoAux2."-".$MinutoAux.", ".$SegundoAux2."-".$SegundoAux.", ".$MesAux2."-".$MesAux.", ".$DiaAux2."-".$DiaAux.", ".$AnoAux2."-".$AnoAux."<br>";
	$Fecha1=mktime($HoraAux, $MinutoAux, 0, $MesAux, $DiaAux, $AnoAux);
	$Fecha2=mktime($HoraAux2, $MinutoAux2, 0, $MesAux2, $DiaAux2, $AnoAux2);
	$DifFecha=$Fecha2-$Fecha1;
	if($Tipo=='H')
	{
		$Horas = intval($DifFecha / 3600); 
		$Min = intval(($DifFecha-$Horas*3600)/60); 
		$Min = (($Min * 100) / 60)/100;	
		//$seg = $DifFecha-$horas*3600-$min*60; 
		$DifFecha=$Horas + $Min;
	}
	else
		$DifFecha=round(($DifFecha/3600)/24);
	//echo "Diferencia: $horas Hs:$min Min:$seg Seg"; 
	//$DifFecha=mktime($HoraAux2-$HoraAux, $MinutoAux2-$MinutoAux, $SegundoAux2-$SegundoAux, $MesAux2-$MesAux, $DiaAux2-$DiaAux, $AnoAux2-$AnoAux);
}
?>
</table></td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
