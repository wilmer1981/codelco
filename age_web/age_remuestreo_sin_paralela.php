<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 103;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");

	$Mostrar       = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$TxtRemuestreo = isset($_REQUEST["TxtRemuestreo"])?$_REQUEST["TxtRemuestreo"]:"";
	$TxtLote       = isset($_REQUEST["TxtLote"])?$_REQUEST["TxtLote"]:"";
	$Ano           = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";
	$Recargo       = isset($_REQUEST["Recargo"])?$_REQUEST["Recargo"]:"";
	
	
?>
<html>
<head>
<title>AGE - Remuestreo Sin Muestra Paralela</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
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
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=30";
			f.submit();
			break;
		case "I":
			window.print();
			break;		
		case "C":
			f.action = "age_remuestreo_sin_paralela.php?Mostrar=S";
			f.submit(); 
			break;
		case "G":
			var Parametros="";
			
			Parametros = f.TxtLoteOri.value + "~~" + f.TxtRemuestreo.value + "//";

			if(f.TxtRemuestreo.value=="")
			{
				alert("Debe Ingresar Lote de Remuestreo");
				return;
			}
			//alert(Parametros);
			if(confirm('Esta seguro de grabar el registro'))
			{
				f.Valores.value=Parametros;
				f.action = "age_remuestreo_sin_paralela01.php?Proceso=G";
				f.submit(); 
			}
			break;
		case "ER":
			var Parametros="";
			
			Parametros = f.TxtLoteOri.value + "~~" + f.TxtRemuestreo.value + "//";
			//alert(Parametros);
			if(f.TxtRemuestreo.value=="")
			{
				alert("Debe Ingresar Lote de Remuestreo");
				return;
			}
			if(confirm('Esta seguro de eliminar el remuestreo'))
			{
				f.Valores.value=Parametros;
				f.action = "age_remuestreo_sin_paralela01.php?Proceso=ER";
				f.submit(); 
			}
			
			break;

	}	
}

function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}

function Habilita(obj,lote,rec)
{
	var f = document.frmPrincipal;
	if (obj.checked==true)
	{
		eval("f.TxtRemuestreo_"+ lote +"_"+rec+".disabled=false;");
		eval("f.TxtRemuestreo_"+ lote +"_"+rec+".style.background='#FFFFFF';");
		eval("f.TxtRemuestreo_"+ lote +"_"+rec+".focus();");
	}
	else
	{
		eval("f.TxtRemuestreo_"+ lote +"_"+rec+".value='';");
		eval("f.TxtRemuestreo_"+ lote +"_"+rec+".disabled=true;");
		eval("f.TxtRemuestreo_"+ lote +"_"+rec+".style.background='#CCCCCC';");
	}	
}
</script></head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="759" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="4" class="ColorTabla02"><strong>REMUESTREO SIN  MUESTRA PARALELA </strong></td>
        </tr>
        <tr>
          <td width="36" height="23" align="right">Lote:</td>
          <td width="704" colspan="3"><input type="text" name="TxtLote" size="10" value="<?php echo $TxtLote;?>">
            <input name="BtnOkA2" type="button" value="Ok" onClick="Proceso('C')"></td>
          </tr>
        <tr>
          <td height="23" colspan="4" align="right">
        <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
<?php		
if ($Mostrar=="S")
{
	//CONSULTA LOS DISTINTOS PRODUCTOS Y PROVEEDORES CON MUESTRA PARALELA
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t1.rut_proveedor, t2.descripcion, t3.nomprv_a ";
	$Consulta.= " from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto inner join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a";
	$Consulta.= " where t1.lote = '".$TxtLote."'";
	//$Consulta.= " and t1.muestra_paralela <>'' ";
	$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0') ";
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	$Cont=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		Titulo($Fila["cod_subproducto"],$Fila["descripcion"],$Fila["rut_proveedor"],$Fila["nomprv_a"]);
		//CONSULTA RECARGO SIN PARALELA
		$Consulta = "select distinct t1.lote, t1.muestra_paralela, t1.remuestreo, t1.num_lote_remuestreo, t1.estado_lote ";
		$Consulta.= " from age_web.lotes t1 ";
		$Consulta.= " where t1.lote = '".$TxtLote."'";		
		$Consulta.= " and t1.muestra_paralela ='' ";
		$Consulta.= " and t1.cod_producto='".$Fila["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto='".$Fila["cod_subproducto"]."' and t1.rut_proveedor='".$Fila["rut_proveedor"]."'";
		$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0') ";
		$Resp2 = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$Lote    = isset($Fila2["lote"])?$Fila2["lote"]:"";
			$recargo = isset($Fila2["recargo"])?$Fila2["recargo"]:"";
			if ($Fila2["estado_lote"]=="6")//ANULADA POR REMUESTREO			
			{					
				$Consulta = "select * from age_web.lotes where estado_lote <>'6' and num_lote_remuestreo='".$Lote."'";
				$Resp3=mysqli_query($link, $Consulta);
				if ($Fila3=mysqli_fetch_array($Resp3))
					$LoteR=$Fila3["lote"];
			}
			else
			{
				$LoteR="";
			}
			$Cu_Pri=0;
			$Ag_Pri=0;
			$Au_Pri=0;
			$Cu_Par=0;
			$Ag_Par=0;
			$Au_Par=0;
			$SA_Pri="";
			$SA_Par="";
			Leyes($Lote,'',$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Par,$Ag_Par,$Au_Par,$SA_Pri,$SA_Par, $Ano,$link);						
			$Valores = $Lote."~~".$recargo;
			echo "<tr align=\"center\">\n";
			echo "<td><a href=\"JavaScript:Historial('".$SA_Pri."','0')\">".$Lote."</a></td>\n";			
			echo "<td align=\"right\">".number_format($Cu_Pri,3,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($Ag_Pri,3,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($Au_Pri,3,",",".")."</td>\n";
			$Seg_Cu="";
			$Seg_Ag="";
			$Seg_Au="";
			$TxtRemuestreo=$LoteR;
			//echo 
			echo "<input name='TxtLoteOri' type='hidden' value='".$Valores."'>";
			if ($TxtRemuestreo!="")
			{
				echo "<td><input name='TxtRemuestreo' type=\"text\" value=\"".$TxtRemuestreo."\" size=\"10\" maxlength=\"8\" class=\"InputCen\" style=\"background=#FFFFFF\"  onKeyDown=\"TeclaPulsada2('S',false,this.form,'')\" readonly></td>\n";
			}
			else
			{
				echo "<td><input name='TxtRemuestreo' type=\"text\" value=\"".$TxtRemuestreo."\" size=\"10\" maxlength=\"8\" class=\"InputCen\" style=\"background=#CCCCCC\"  onKeyDown=\"TeclaPulsada2('S',false,this.form,'')\"></td>\n";
			}
			echo "</tr>\n";
		}
	}
}//FIN MOSTRAR = S	
?>
</table>	  
	  &nbsp;</td>
          </tr>
        <tr align="center">
          <td height="30" colspan="4">
              <input name="BtnGrabar" type="button" id="BtnGrabar" style="width:70px;" onClick="Proceso('G')" value="Grabar">
			  <?php
			  if($TxtRemuestreo!='')
			  {
			  ?>
			   <input name="BtnEliminar" type="button" style="width:110px;" onClick="Proceso('ER')" value="Elim.Remuestreo">
			  <?php
			  }
			  ?>
              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
        </tr>
      </table>
<?php
function Titulo($Prod, $NomProd, $Proved, $NomProved)
{
	echo "<tr class=\"ColorTabla02\">\n";
	echo "<td colspan=\"2\">Producto:&nbsp;".str_pad($Prod,2,'0',STR_PAD_LEFT)."-".strtoupper($NomProd)."</td>\n";
	echo "<td colspan=\"3\">Proveedor:&nbsp;".str_pad($Proved,10,'0',STR_PAD_LEFT)."-".strtoupper($NomProved)."</td>\n";
	echo "</tr>\n";
	echo "<tr align=\"center\" class=\"ColorTabla01\">\n";
	echo "<td width=\"40\" rowspan=\"2\">Lote</td> \n";
	echo "<td colspan=\"3\">Paquete Primero</td>\n";
	echo "<td>Remuestreo</td>\n";
	echo "</tr>\n";
	echo "<tr class=\"ColorTabla01\" align=\"center\">\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td>Num.</td>\n";
	echo "</tr>\n";
}//FIN FUNCION TITULO

function Leyes($Lote,$MuestraParalela,$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Par,$Ag_Par,$Au_Par,$SA_Pri,$SA_Par,$Ano,$link)
{
	//LEYES DEL PAQUETE PRIMERO
	$DatosLote= array();
	$ArrLeyes=array();
	$DatosLote["lote"]=$Lote;
	LeyesLote($DatosLote,$ArrLeyes,"N","S","S","","","",$link);
	$PesoLote        = isset($DatosLote["peso_seco"])?$DatosLote["peso_seco"]:0;
	$fecha_recepcion = isset($DatosLote["fecha_recepcion"])?$DatosLote["fecha_recepcion"]:"";
	$Cu_Pri=isset($ArrLeyes["02"][2])?$ArrLeyes["02"][2]:"";
	$Ag_Pri=isset($ArrLeyes["04"][2])?$ArrLeyes["04"][2]:"";
	$Au_Pri=isset($ArrLeyes["05"][2])?$ArrLeyes["05"][2]:"";
	//BUSCA DATOS MUESTRA PARALELA
	$Consulta="select * from cal_web.solicitud_analisis ";
	$Consulta.= " where id_muestra='".$MuestraParalela."' and tipo=4 and recargo='R' ";
	$Consulta.= " and year(fecha_muestra)='".substr($fecha_recepcion,0,4)."'";
	$Respuesta=mysqli_query($link, $Consulta);
	if($FilaLeyes=mysqli_fetch_array($Respuesta))
	{
		$PesoMuestra=$FilaLeyes["peso_muestra"];
		$PesoRetalla=$FilaLeyes["peso_retalla"];
	}
	$Consulta="select * from age_web.leyes_por_lote ";
	$Consulta.= " where lote='".$MuestraParalela."' ";
	$Consulta.= " and recargo='0' and cod_leyes in('02','04','05') ";
	$Consulta.= " and ano='".substr($fecha_recepcion,0,4)."' ";
	$Cu_Par=0;
	$Ag_Par=0;
	$Au_Par=0;
	$Respuesta=mysqli_query($link, $Consulta);
	while($FilaLeyes=mysqli_fetch_array($Respuesta))
	{
		switch ($FilaLeyes["cod_leyes"])
		{
			case "02":
				$Cu_Par=$FilaLeyes["valor"];
				break;
			case "04":
				$Ag_Par=$FilaLeyes["valor"];
				break;
			case "05":
				$Au_Par=$FilaLeyes["valor"];
				break;
		}						
	}
	$Consulta = "select distinct t1.cod_leyes, t1.valor, t2.abreviatura as nom_unidad, t2.conversion";
	$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
	$Consulta.= " t1.cod_unidad=t2.cod_unidad ";
	$Consulta.= " where t1.lote='".$MuestraParalela."' ";
	$Consulta.= " and t1.recargo='R'";	
	$Consulta.= " and ano='".substr($fecha_recepcion,0,4)."' ";
	$Consulta.= " order by t1.cod_leyes";
	//echo $Consulta."<br>";
	$RespLeyes = mysqli_query($link, $Consulta);
	while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
	{									
		//CALCULA LA LEY INCLUYENDO INCIDENCIA DE LA RETALLA
		switch ($FilaLeyes["cod_leyes"])
		{
			case "02":
				if ($PesoRetalla>0 && $PesoMuestra>0 && $FilaLeyes["valor"]>0)
					$IncRetalla = ($FilaLeyes["valor"] - $Cu_Par) * ($PesoRetalla/$PesoMuestra);  //VALOR
				else
					$IncRetalla = 0;  //VALOR					
				$Cu_Par=$Cu_Par + $IncRetalla;
				break;
			case "04":
				if ($PesoRetalla>0 && $PesoMuestra>0 && $FilaLeyes["valor"]>0)
					$IncRetalla = ($FilaLeyes["valor"] - $Ag_Par) * ($PesoRetalla/$PesoMuestra);  //VALOR
				else
					$IncRetalla = 0;  //VALOR
				$Ag_Par=$Ag_Par + $IncRetalla;
				break;
			case "05":
				if ($PesoRetalla>0 && $PesoMuestra>0 && $FilaLeyes["valor"]>0)
					$IncRetalla = ($FilaLeyes["valor"] - $Au_Par) * ($PesoRetalla/$PesoMuestra);  //VALOR
				else
					$IncRetalla = 0;  //VALOR						
				$Au_Par=$Au_Par + $IncRetalla;
				break;
		}						
	}
	
	//CONSULTA LA S.A. PAQUETE PRIMERO
	$Recargo=""; //WSO
	$Consulta = "select distinct t1.id_muestra,t1.nro_solicitud, t1.recargo ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " where t1.id_muestra='".$Lote."' and t1.agrupacion in(1,3,6)";// and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProducto'";
	if($Recargo=='')
		$Consulta.= " and (t1.recargo='0' or t1.recargo='')";
	else
		$Consulta.= " and t1.recargo='".$Recargo."'";	
	//echo $Consulta;
	$RespSA=mysqli_query($link, $Consulta);
	if($FilaSA=mysqli_fetch_array($RespSA))
	{
		$SA_Pri=$FilaSA["nro_solicitud"];
	}
	//CONSULTA LA S.A. MUESTRA PARALELA
	$Consulta = "select distinct t1.id_muestra,t1.nro_solicitud, t1.recargo ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " where t1.id_muestra='".$MuestraParalela."' and t1.agrupacion in(1,3,6,99) and tipo='4'";// and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProducto'";
	$Consulta.= " and year(t1.fecha_muestra)='".$Ano."'";
	if($Recargo=='')
		$Consulta.= " and (t1.recargo='0' or t1.recargo='')";
	else
		$Consulta.= " and t1.recargo='".$Recargo."'";	
	//echo $Consulta;
	$RespSA=mysqli_query($link, $Consulta);
	if($FilaSA=mysqli_fetch_array($RespSA))
	{
		$SA_Par=$FilaSA["nro_solicitud"];
	}
	
}
?>
</td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
