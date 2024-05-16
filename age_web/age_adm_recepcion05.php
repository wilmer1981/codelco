<?php
	include("../principal/conectar_principal.php");
	require_once 'reader.php';
	if(!isset($TxtConjunto))
		$TxtConjunto=0;
	if($Opcion=='MO')
	{
		$LotesConsulta=explode("~",$Lotes);
		if(list($c,$v)=each($LotesConsulta))
		{
			//DATOS PARA LA CABEZERA
			$Consulta="select * from age_web.lotes_temp where lote='".$v."'";
			$Resp = mysqli_query($link, $Consulta);
			if($Fila = mysqli_fetch_array($Resp))
			{
				$TxtSubProducto=$Fila["cod_subproducto"];	
				$TxtConjunto=$Fila["num_conjunto"];
				$CmbEstadoLote=$Fila["estado_lote"];
				$CmbProveedor=$Fila["rut_proveedor"];
				$CmbCodFaena=$Fila[cod_faena];
				$CmbClaseProducto=$Fila[clase_producto];
				$CmbCodRecepcion=$Fila["cod_recepcion"];
				$CmbCodRecepcionENM=$Fila[cod_recepcion_enm];
				$TxtCancha=$Fila[cancha];
			}		
		}
	}
	if ($Proc == "M")
	{
		$EstadoInput = "readonly";
		$Consulta = "select * ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 ";
		$Consulta.= " on t1.lote = t2.lote";
		$Consulta.= " where t1.lote = '".$TxtLote."'";
		$Consulta.= " and t2.recargo = '".$TxtRecargo."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$TxtLote = $Fila["lote"];
			$CmbSubProducto = $Fila["cod_subproducto"];
			$CmbProveedor = $Fila["rut_proveedor"];
			$CmbCodFaena = $Fila["cod_faena"];
			$CmbCodRecepcion = $Fila["cod_recepcion"];
			$CmbCodRecepcionENM = $Fila["cod_recepcion_enm"];
			$CmbClaseProducto = $Fila["clase_producto"];
			$TxtConjunto = $Fila["num_conjunto"];
			$TxtMuestraParalela = $Fila["muestra_paralela"];
			$TxtLoteRemuestreo = $Fila["num_lote_remuestreo"];
			$CmbEstadoLote = $Fila["estado_lote"];
			$TxtCancha = $Fila["cancha"];
			$CmbEstadoRecargo = $Fila["estado_recargo"];
			//DATOS DEL DETALLE
			if ($NewRec != "S")
			{
				$TxtRecargo = $Fila["recargo"];
				$TxtFolio = $Fila["folio"];
				$TxtCorrelativo = $Fila["corr"];
				$TxtFechaRecep = $Fila["fecha_recepcion"];
				$ChkFinLote = $Fila["fin_lote"];
				$TxtPesoBruto = $Fila["peso_bruto"];
				$TxtPesoTara = $Fila["peso_tara"];
				$TxtPesoNeto = $Fila["peso_neto"];
				$TxtGuia = $Fila["guia_despacho"];
				$TxtPatente = $Fila["patente"];
				$CmbAutorizado = $Fila["autorizado"];
			}
			else
			{
				$Consulta = "select ifnull(max(recargo*1),0) as ult_recargo from age_web.detalle_lotes ";
				$Consulta.= " where lote='".$TxtLote."'";
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Resp2))
					$TxtRecargo = $Fila2["ult_recargo"] + 1;
				else
					$TxtRecargo = 1;
				$TxtFolio = "";
				$TxtCorrelativo = "";
				$TxtFechaRecep = date("Y-m-d");
				$ChkFinLote = "N";
				$TxtPesoBruto = 0;
				$TxtPesoTara = 0;
				$TxtPesoNeto = 0;
				$TxtGuia = "";
				$TxtPatente = "";
				$CmbAutorizado = "N";
			}//FIN SI ES NEWREC!= "S"
		}
	}
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "G":
			f.action = "age_adm_recepcion01.php?Proceso=GRDL";
			f.submit();
			break;
		case "C": //Cancelar	
			mensaje=confirm("�Esta Seguro de Cancelar el Resultado?");
			if(mensaje==true)
			{
				f.action = "age_adm_recepcion01.php?Proceso=ERDL";
				f.submit();
			}
			break;
		case "Info":
			document.getElementById('Informacion').style.visibility='visible';
		break;	
		case "Cerrar":
			document.getElementById('Informacion').style.visibility='hidden';
		break;	
			
	}
}
</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmProceso" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="NewRec" value="<?php echo $NewRec; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
<table width="550"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr class="ColorTabla02">
    <td colspan="4"><strong>DATOS  PROCESADOS </strong></td>
  </tr>
<?php
	if ($EstOpe != "")
	{  
		switch ($EstOpe)
		{
			case "S":
				$Clase="ErrorSI";
				break;
			case "N":
				$Clase="ErrorNO";
				break;
		}
		echo "<tr class='ColorTabla02'>\n";
    	echo "<td colspan='4' class='Colum01' align='center'><font class='".$Clase."'>".$Mensaje."</font></td>\n";
    	echo "</tr>\n";
	}
?>
  <tr class="Colum01">
    <td width="92" class="Colum01">SubProducto:</td>
	<td width="180" class="Colum01">
	<?php
	if($Opcion!='MO')
	{
		?><?php
	 }
	 else
	 {
			$Consulta = "select cod_subproducto, descripcion, abreviatura, LPAD(cod_subproducto,2,'0') as orden ";
			$Consulta.= " from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto='1' and cod_subproducto='".$TxtSubProducto."' order by orden";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				echo "<input type='hidden' name='CmbSubProducto' value='".$Fila["cod_subproducto"]."'>"; 
				echo $Fila["orden"]." - ".$Fila["abreviatura"];	
			}	 
	 }	 		
	?>		</td>	
    <td  align="right" class="Colum01">Estado del Lote:</td>
    <td width="98" class="Colum01">
	<?php
	if($Opcion!='MO')
	{
	?><?php
	}
	else
	{
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15003' and cod_subclase='".$CmbEstadoLote."' order by cod_subclase";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			echo "<input type='hidden' name='CmbEstadoLote' value='".$Fila["cod_subproducto"]."'>"; 
			echo $Fila["nombre_subclase"];	
		}	
	}	
	?></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Proveedor: </td>
    <td colspan="3" class="Colum01">
	<?php
		$Consulta = "select * ";
		$Consulta.= " from sipa_web.proveedores where rut_prv='".$CmbProveedor."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			echo "<input type='hidden' name='CmbProveedor' value='".$Fila["rut_prv"]."'>"; 
			echo str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre_prv"];
		}
	?>
	</td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Cod Faena: </td>
    <td colspan="3" class="Colum01">
	<?php
		$Consulta = "select distinct cod_mina,nombre_mina from sipa_web.minaprv where cod_mina='".$CmbCodFaena."' order by nombre_mina ";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			echo "<input type='hidden' name='CmbCodFaena' value='".$Fila["cod_mina"]."'>"; 
			echo $Fila["cod_mina"]." - ".$Fila["nombre_mina"];
		}	 	
	?>	</td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Clase Producto:</td>
    <td class="Colum01">
	<?php
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15001' and nombre_subclase='".$CmbClaseProducto."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			echo "<input type='hidden' name='CmbClaseProducto' value='".$Fila["nombre_subclase"]."'>"; 
			echo $Fila["valor_subclase1"];
		}	 
	?>	</td>					
    <td align="right" class="Colum01">Cod.Recep:</td>
    <td class="Colum01">	
	<?php
		$Consulta = "select * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase='3104' and nombre_subclase='".$CmbCodRecepcion."'order by cod_subclase ";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			echo "<input type='hidden' name='CmbCodRecepcion' value='".$Fila["nombre_subclase"]."'>"; 
			echo $Fila["nombre_subclase"];
		}	
	?>	</td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Cod.Recep.ENM :</td>
    <td class="Colum01">
	<?php
		$Consulta = "select COD_C, DESC_A from rec_web.tipos  where indica='R' and COD_C='".$CmbCodRecepcionENM."' order by DESC_A ";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			echo "<input type='hidden' name='CmbCodRecepcionENM' value='".$Fila["COD_C"]."'>"; 
			echo $Fila["DESC_A"];
		}	 
	?>	</td>
    <td align="right" class="Colum01">Cancha:</td>
    <td class="Colum01">
	<?php
	 	echo "<input type='hidden' name='TxtCancha' value='".$TxtCancha."'>"; 
	 	echo $TxtCancha;
	?>
	</td>
  </tr>
  <tr>
    <td align="left"  class="Colum01">Num.Conjunto:</td>
    <td align="left" colspan="3" class="Colum01"><?php	echo $TxtConjunto;?> &nbsp;</td>		  
  </tr>
  <tr class="Colum01">
    <td colspan="4" align="center" class="Colum01">
      <input name="BtnGuardar" type="button" id="BtnGuardar" value="Guardar" style="width:70px " onClick="Proceso('G')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Cancelar" style="width:70px " onClick="Proceso('C')">
	  &nbsp;<?php 
	  $ConsultaDetalle="select * from age_web.lotes_temp_detalle where obsloten!=''";
	  //echo $ConsultaDetalle."<br>";
	  $RespDet = mysqli_query($link, $ConsultaDetalle);
	  if($FilaDet = mysqli_fetch_array($RespDet))
	  { ?><input name="BtnSalir" type="button" id="BtnSalir" value="Ver Informaci�n" style="width:120px " onClick="Proceso('Info')"><?php }?></td>
  </tr>
</table>
<br>
<div id="Informacion" style="float:inherit; position:absolute; top:15px;">
<table width="800"  border="1" align="center" class="ColorTabla02">
<tr>
<td><input name="BtnSalir" type="button" id="BtnSalir" value="Cerrar" style="width:70px " onClick="Proceso('Cerrar')"></td>
</tr>
<tr>
<td>
<?php 
$ConsultaDetalle="select * from age_web.lotes_temp_detalle where obsloten!=''";
//echo $ConsultaDetalle."<br>";
$RespDet = mysqli_query($link, $ConsultaDetalle);
while($FilaDet = mysqli_fetch_array($RespDet))
	echo str_replace('//',' ya se encuentra ingresada en el Lote: ',str_replace('~R~',' del Recargo: ',str_replace('~L~',' del Lote: ',str_replace('G~','Gu�a: ',$FilaDet[obsloten]))))."<br>";

?>
</td>
</tr>
</table><br>
</div>
<table width="800"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <?php
  //echo $Opcion;
	if($Opcion=='MO')
	{		
		reset($LotesConsulta);$TotBruto=0;$TotTara=0;$TotNeto=0;
		while(list($c,$v)=each($LotesConsulta))
		{
			$Consulta="select * from age_web.lotes_temp where lote='".$v."'";
			//echo $Consulta."<BR>";
			$Resp = mysqli_query($link, $Consulta);$Leyes1='';$Impureza1='';
			if($Fila = mysqli_fetch_array($Resp))
			{
			  echo "<tr class='ColorTabla02'>";
				echo "<td width='97' colspan='3' align='center'>FECHA EMISION</td>";
				echo "<td width='97' colspan='7' align='left'>".$Fila[fecha_recepcion]."</td>";
			  echo  "</tr>";
				$ConsultaLote="select * from age_web.lotes_temp_detalle where lote='".$Fila["lote"]."'";
				$RespLote = mysqli_query($link, $ConsultaLote);
				if($FilaLote = mysqli_fetch_array($RespLote))
				{
					  echo "<tr class='ColorTabla02'>";
						echo "<td colspan='3' align='left'>LOTE ORIGEN:</td>";
						echo "<td  align='left' colspan='7'><span class='ErrorNo'>".$FilaLote["observacion"]."</span></td>";
					  echo  "</tr>";
				}
				   echo "<tr class='SinBorde'>";
					echo "<td width='30' align='center'><strong>REC</strong></td>";
					echo "<td width='74' align='center'><strong>PATENTE</strong></td>";
					echo"<td width='70' align='center'><strong>GUIA</strong></td>";
					echo "<td width='70' align='center'><strong>PESO BRUTO</strong></td>";
					echo "<td width='70' align='center'><strong>PESO TARA </strong></td>";
					echo "<td width='70' align='center'><strong>PESO NETO</strong></td>";	
					echo "<td width='70' align='center'><strong>HUMEDAD</strong></td>";	
					echo "<td width='90' align='center'><strong>LEYES</strong></td>";	
					echo "<td width='310' align='center'><strong>IMPUREZAS</strong></td>";	
				   echo  "</tr>";$SubTotBruto=0;$SubTotTara=0;$SubTotNeto=0;			
				$Consulta="select *,ceiling(recargo) as RecOrden from age_web.lotes_temp_detalle where lote='".$Fila["lote"]."'  order by RecOrden asc";
				//echo $Consulta."<br>";
				$Resp2 = mysqli_query($link, $Consulta);$Leyes='';$Impureza='';$SubTotHum='0';
				while($Fila2 = mysqli_fetch_array($Resp2))
				{
					$Leyes='';$Impureza='';
					$Ley=explode("~",$Fila2[pastas]);
					while(list($c,$LEY)=each($Ley))
					{
						$ConLey="select * from proyecto_modernizacion.leyes where cod_leyes='".$LEY."'";
						$RespLey = mysqli_query($link, $ConLey);
						if($FilaLey = mysqli_fetch_array($RespLey))
						{
							$Leyes=$Leyes.$FilaLey["abreviatura"]."-";
						}						
					}
					$Leyes1=substr($Leyes,0,strlen($Leyes)-1);
					
					$Impu=explode("~",$Fila2[impurezas]);
					while(list($c,$IM)=each($Impu))
					{
						$ConIMP="select * from proyecto_modernizacion.leyes where cod_leyes='".$IM."'";
						$RespIMP = mysqli_query($link, $ConIMP);
						if($FilaIMP = mysqli_fetch_array($RespIMP))
						{
							$Impureza=$Impureza.$FilaIMP["abreviatura"]."-";
						}						
					}
					$Impureza1=substr($Impureza,0,strlen($Impureza)-1);
					
					if($Fila2[humedad]!='0')
						$Humedad="<td  align='right'>".number_format($Fila2[humedad],2,',','.')."</td>";
					else
						$Humedad="<td  align='center'><strong><span class='InputRojo'>X</span></strong></td>";							
					echo "<tr>";
					echo "<td  align='center'>".$Fila2["recargo"]."</td>";
					echo "<td  align='center'>".$Fila2["patente"]."</td>";
					echo "<td  align='center'>".$Fila2["guia_despacho"]."</td>";
					echo "<td  align='right'>".number_format($Fila2[peso_bruto],0,'','.')."</td>";
					echo "<td  align='right'>".number_format($Fila2["peso_tara"],0,'','.')."</td>";
					echo "<td  align='right'>".number_format($Fila2[peso_neto],0,'','.')."</td>";	
					echo $Humedad;	
					echo "<td  align='left'>".$Leyes1."&nbsp;</td>";	
					echo "<td  align='left'>".$Impureza1."&nbsp;</td>";	
					echo "</tr>";
					$SubTotBruto=$SubTotBruto+$Fila2[peso_bruto];	
					$SubTotTara=$SubTotTara+$Fila2["peso_tara"];
					$SubTotNeto=$SubTotNeto+$Fila2[peso_neto];
					
					if($Fila2[humedad]=='0')			
						$SubTotHum=$SubTotHum+0;			
					else
						$SubTotHum=$SubTotHum+$Fila2[humedad];			
						
					$TotBruto=$TotBruto+$Fila2[peso_bruto];	
					$TotTara=$TotTara+$Fila2["peso_tara"];
					$TotNeto=$TotNeto+$Fila2[peso_neto];	
							
					$TotHum=$TotHum+$Fila2[humedad];			
				}
				echo "<tr class='SinBorde'>";
				echo "<td align='right' colspan='3'>SUB-TOTAL</td>";
				echo "<td width='97' align='right'>".number_format($SubTotBruto,0,'','.')."</td>";
				echo "<td width='97' align='right'>".number_format($SubTotTara,0,'','.')."</td>";
				echo "<td width='97' align='right'>".number_format($SubTotNeto,0,'','.')."</td>";	
				echo "<td width='97' align='right'>".number_format($SubTotHum,2,',','.')."</td>";	
				echo "<td width='97' align='right' colspan='2'>&nbsp;</td>";	
				echo "</tr>";					
			}

  	   }
		echo "<tr class='SinBorde'>";
		echo "<td align='right' colspan='3'>TOTAL</td>";
		echo "<td width='97' align='right'>".number_format($TotBruto,0,'','.')."</td>";
		echo "<td width='97' align='right'>".number_format($TotTara,0,'','.')."</td>";
		echo "<td width='97' align='right'>".number_format($TotNeto,0,'','.')."</td>";	
		echo "<td width='97' align='right'>".number_format($TotHum,2,',','.')."</td>";	
		echo "<td width='97' align='right' colspan='2'>&nbsp;</td>";	
		echo "</tr>";					

  }
  ?> 
  </tr>
</table>
<script language="javascript">
	document.getElementById('Informacion').style.visibility='hidden';
</script>
</form>
</body>
</html>