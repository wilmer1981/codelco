<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 37;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");

	$Mostrar    = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$Mes        = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano        = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor    = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
	$CmbPlantilla     = isset($_REQUEST["CmbPlantilla"])?$_REQUEST["CmbPlantilla"]:"";
	$Busq             = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
	$TxtFiltroPrv     = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
		
?>
<html>
<head>
<title>AGE-Consulta Comparacion Muestra Paralela</title>
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
function Recarga3()
{
	var Frm = document.frmPrincipal;
	Frm.action="age_con_muestra_paralela.php?Busq=S";
	Frm.submit();	
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
		case "R":
			f.action = "age_con_muestra_paralela.php?Mostrar=<?php echo $Mostrar; ?>";
			f.submit(); 
			break;
		case "C":
			f.action = "age_con_muestra_paralela.php?Mostrar=S";
			f.submit(); 
			break;
		case "E":
			f.action = "age_con_muestra_paralela_excel.php?Mostrar=S";
			f.submit(); 
			break;
		case "G":
			var Parametros="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name.substring(0,13)=="ChkRemuestreo" && f.elements[i].checked==true)
				{
					Parametros = Parametros + f.elements[i].value + "~~" + f.elements[i+1].value + "//";
				}
			}
			//alert(Parametros);
			if (Parametros=="")
			{
				alert("No hay nada seleccionado!!");
				return;
			}
			f.Valores.value=Parametros;
			f.action = "age_con_muestra_paralela01.php?Proceso=G";
			f.submit(); 
			break;
	}	
}

function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=1000,height=450,scrollbars=yes,resizable = yes");					
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
  <table width="800" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="800" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="4" class="ColorTabla02"><strong>COMPARACION MUESTRA PARALELA </strong></td>
        </tr>
        <tr>
          <td width="52" height="23" align="right">Periodo:</td>
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
          <td width="55" align="left">Plantilla M.Paral:</td>
          <td width="354"><select name='CmbPlantilla' class='Select01' style='width:220' onChange="Proceso('R')">
		  <option value="S" class="NoSelec">SELECCIONAR</option>
<?php		  
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
?>				
				</select></td>
        </tr>
        <tr>
          <td height="23" align="right">Producto:</td>
          <td width="261" height="23"><select name="SubProducto" style="width:250" onChange="Proceso('R')">
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
          <td colspan="2" align="left">Proveedor:
            <select name="Proveedor" style="width:260" onChange="Proceso('R')">
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
            </select>
            <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
            <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">            </td>
          </tr>
        <tr align="center">
          <td height="30" colspan="4"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
              <input name="BtnGrabar" type="button" id="BtnGrabar" style="width:70px;" onClick="Proceso('G')" value="Grabar">
              <input name="BtnExcel" type="button" id="BtnExcel" style="width:70px;" onClick="Proceso('E')" value="Excel">              
              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
        </tr>
      </table>        
      <br>
        <br>
        <table width="800" border="1" align="center" cellpadding="2" cellspacing="0">
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
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t1.rut_proveedor, t2.descripcion, t3.nomprv_a ";
	$Consulta.= " from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto inner join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a";
	$Consulta.= " where t1.lote between '".$LoteIni."' and '".$LoteFin."' ";
	//$Consulta.= " and t1.muestra_paralela <>'' ";
	if ($SubProducto!="S")
		$Consulta.= " and t1.cod_producto='1' and t1.cod_subproducto='".$SubProducto."'";
	if ($Proveedor!="S")
		$Consulta.= " and t1.rut_proveedor='".$Proveedor."'";		
	$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0') ";
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	$Cont=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		Titulo($Fila["cod_subproducto"],$Fila["descripcion"],$Fila["rut_proveedor"],$Fila["nomprv_a"]);
		//CONSULTA RECARGOS CON PARALELA
		$Consulta = "select distinct t1.lote, t1.muestra_paralela, t1.remuestreo, t1.num_lote_remuestreo, t1.estado_lote, t2.recargo ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.leyes_por_lote t2 on t1.muestra_paralela=t2.lote ";
		$Consulta.= " where t1.lote  between '".$LoteIni."' and '".$LoteFin."' ";		
		$Consulta.= " and t1.muestra_paralela <>'' ";
		$Consulta.= " and t1.cod_producto='".$Fila["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto='".$Fila["cod_subproducto"]."' and t1.rut_proveedor='".$Fila["rut_proveedor"]."'";
		$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0') ";
		$Resp2 = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$Lote=$Fila2["lote"];
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
			$Result = Leyes($Lote,$Fila2["muestra_paralela"],$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Par,$Ag_Par,$Au_Par,$SA_Pri,$SA_Par, $Ano,$link);
			//echo $Val;
			$Val = explode("**",$Result);
			$Cu_Pri = $Val[0];
			$Ag_Pri = $Val[1];
			$Au_Pri = $Val[2];
			$Cu_Par = $Val[3];
			$Ag_Par = $Val[4];
			$Au_Par = $Val[5];
			$SA_Pri = $Val[6];
			$SA_Par = $Val[7];
	
			$Cu_Dif=(float)$Cu_Pri-(float)$Cu_Par;
			$Ag_Dif=(float)$Ag_Pri-(float)$Ag_Par;
			$Au_Dif=(float)$Au_Pri-(float)$Au_Par;
			$Valores = $Lote."~~".$Fila2["recargo"];
			//echo "SA_Priiiii:".$SA_Pri;
			echo "<tr align=\"center\">\n";
			echo "<td><a href=\"JavaScript:Historial('".$SA_Pri."','0')\">".$Lote."</a></td>\n";			
			echo "<td align=\"right\">".number_format((float)$Cu_Pri,3,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format((float)$Ag_Pri,3,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format((float)$Au_Pri,3,",",".")."</td>\n";
			echo "<td><a href=\"JavaScript:Historial('".$SA_Par."','0')\">".$Fila2["muestra_paralela"]."</a></td>\n";
			echo "<td align=\"right\">".number_format((float)$Cu_Par,3,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format((float)$Ag_Par,3,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format((float)$Au_Par,3,",",".")."</td>\n";

			$Seg_Cu="";$Seg_Ag="";$Seg_Au="";
			$ColorCu="";$ColorAg=""; $ColorAu="";
			if ($Cu_Par!=0)
			{   
				$Result = ControlMuestra("02", $Cu_Pri, $Cu_Par, $Cu_Dif, $CmbPlantilla, $Seg_Cu, $ColorCu, $link);
				
				$Seg_Cu = $Val[0];
				$ColorCu = $Val[1];				
				echo "<td align='center' onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");' bgcolor='".$ColorCu."'>";
				echo "<div align='left' id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:250px'>\n";
				echo "<font face='courier' color='#000000' size=1><b>".$Seg_Cu."<br></b></div>".number_format(abs($Cu_Dif),3,",",".")."</td>";
				$Cont++;
			}
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Ag_Par!=0)
			{				
				$Result = ControlMuestra("04", $Ag_Pri, $Ag_Par, $Ag_Dif, $CmbPlantilla, $Seg_Ag, $ColorAg, $link);
				$Val = explode("**",$Result);
				$Seg_Ag = $Val[0];
				$ColorAg = $Val[1];
				echo "<td align='center' onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");' bgcolor='".$ColorAg."'>";
				echo "<div align='left' id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:250px'>\n";
				echo "<font face='courier' color='#000000' size=1><b>".$Seg_Ag."<br></b></div>".number_format(abs($Ag_Dif),3,",",".")."</td>";
				$Cont++;
			}
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			//echo
			if ($Au_Par!=0)
			{  
				$Result = ControlMuestra("05", $Au_Pri, $Au_Par, $Au_Dif, $CmbPlantilla, $Seg_Au, $ColorAu, $link);
				$Val = explode("**",$Result);
				$Seg_Au = $Val[0];
				$ColorAu = $Val[1];
				echo "<td align='center' onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");' bgcolor='".$ColorAu."'>";
				echo "<div align='left' id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:250px'>\n";
				echo "<font face='courier' color='#000000' size=1><b>".$Seg_Au."<br></b></div>".number_format(abs($Au_Dif),3,",",".")."</td>";
				$Cont++;
			}
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			$TxtRemuestreo=$LoteR;
			//echo 
			if ($TxtRemuestreo!="")
			{
				echo "<td><input checked name=\"ChkRemuestreo_".$Lote."_".$Fila2["recargo"]."\" type=\"checkbox\" value=\"".$Valores."\" onClick=\"Habilita(this, '".$Lote."', '".$Fila2["recargo"]."')\"></td>\n";
				echo "<td><input name=\"TxtRemuestreo_".$Lote."_".$Fila2["recargo"]."\" type=\"text\" value=\"".$TxtRemuestreo."\" size=\"10\" maxlength=\"8\" class=\"InputCen\" style=\"background=#FFFFFF\"  onKeyDown=\"TeclaPulsada2('S',false,this.form,'')\"></td>\n";
			}
			else
			{
				echo "<td><input name=\"ChkRemuestreo_".$Lote."_".$Fila2["recargo"]."\" type=\"checkbox\" value=\"".$Valores."\" onClick=\"Habilita(this, '".$Lote."', '".$Fila2["recargo"]."')\"></td>\n";
				echo "<td><input disabled name=\"TxtRemuestreo_".$Lote."_".$Fila2["recargo"]."\" type=\"text\" value=\"".$TxtRemuestreo."\" size=\"10\" maxlength=\"8\" class=\"InputCen\" style=\"background=#CCCCCC\"  onKeyDown=\"TeclaPulsada2('S',false,this.form,'')\"></td>\n";
			}
			echo "</tr>\n";
		}
	}
}//FIN MOSTRAR = S	

function ControlMuestra($CodLey, $Ley_Pri, $Ley_Par, $Dif, $Plantilla, $Seguimiento, $ResultControl,$link)
{
	if($Ley_Pri!='')
	{
		$Consulta = "select t1.limite_particion,t2.abreviatura,t1.descripcion ";
		$Consulta.= " from age_web.limites_particion t1 inner join proyecto_modernizacion.unidades t2 ";
		$Consulta.= " on t1.cod_unidad =t2.cod_unidad ";
		$Consulta.= " where proceso='REMUESTREO' and cod_plantilla='".$Plantilla."' ";
		$Consulta.= " and cod_ley = '".$CodLey."' and '".$Ley_Pri."' between rango1 and rango2";
		//echo $Consulta."<br>";
		$RespPar=mysqli_query($link, $Consulta);
		if($FilaPar=mysqli_fetch_array($RespPar))
		{
			$LimControl=$FilaPar["limite_particion"]*1;
			$Seguimiento="M.PARALELA: ".$FilaPar["descripcion"]."<BR>";
			$Seguimiento.="LIMITE CONTROL: ".$LimControl."&nbsp;(".$FilaPar["abreviatura"].")<br>";
			//echo "LIMITE CONTROL:".$LimControl."<br>";
			$Dif=abs((float)$Ley_Pri-(float)$Ley_Par)*1;
			$Seguimiento.="DIF.LEY FINAL Y M.PAREL :".number_format($Dif,3,',','.')."<br>";
			//echo "DIF:".$Dif."<br>";
			if(doubleval($Dif+1-1) > doubleval($LimControl+1-1))
			{
				$ResultControl="YELLOW";
				$Seguimiento.="MUESTRA FUERA DE RANGO<BR>";
			}	
			else
			{
				$ResultControl="WHITE";
				$Seguimiento.="MUESTRA OK";
			}	
		}
	}
	$valor = $Seguimiento."**".$ResultControl;
	return $valor;
}

function Titulo($Prod, $NomProd, $Proved, $NomProved)
{
	echo "<tr class=\"ColorTabla02\">\n";
	echo "<td colspan=\"7\">Producto:&nbsp;".str_pad($Prod,2,'0',STR_PAD_LEFT)."-".strtoupper($NomProd)."</td>\n";
	echo "<td colspan=\"7\">Proveedor:&nbsp;".str_pad($Proved,10,'0',STR_PAD_LEFT)."-".strtoupper($NomProved)."</td>\n";
	echo "</tr>\n";
	echo "<tr align=\"center\" class=\"ColorTabla01\">\n";
	echo "<td width=\"40\" rowspan=\"2\">Lote</td> \n";
	echo "<td colspan=\"3\">Paquete Primero</td>\n";
	echo "<td width=\"57\" rowspan=\"2\">Paralela</td>\n";
	echo "<td colspan=\"3\">Muestra Paralela</td>\n";
	echo "<td colspan=\"3\">Diferencia</td>\n";
	echo "<td colspan=\"2\">Remuestreo</td>\n";
	echo "</tr>\n";
	echo "<tr class=\"ColorTabla01\" align=\"center\">\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">S/N</td>\n";
	echo "<td>Num.</td>\n";
	echo "</tr>\n";
}//FIN FUNCION TITULO

function Leyes($Lote,$MuestraParalela,$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Par,$Ag_Par,$Au_Par,$SA_Pri,$SA_Par,$Ano,$link)
{
	//LEYES DEL PAQUETE PRIMERO
	$DatosLote= array();
	$ArrLeyes=array();
	$DatosLote["lote"]=$Lote;
	$DatosLote = LeyesLote($DatosLote,$ArrLeyes,"N","S","S","","","","",$link);
	$ArrLeyes  = LeyesLote($DatosLote,$ArrLeyes,"N","S","S","","","","L",$link);
	$PesoLote= $DatosLote["peso_seco"];
	$Cu_Pri  = $ArrLeyes["02"][2];
	$Ag_Pri  = $ArrLeyes["04"][2];
	$Au_Pri  = $ArrLeyes["05"][2];
	//BUSCA DATOS MUESTRA PARALELA
	$Consulta="select * from cal_web.solicitud_analisis ";
	$Consulta.= " where id_muestra='".$MuestraParalela."' and tipo=4 and recargo='R' ";
	$Consulta.= " and year(fecha_muestra)='".substr($DatosLote["fecha_recepcion"],0,4)."'";
	$Respuesta=mysqli_query($link, $Consulta);
	$Recargo =0; //WSO
	if($FilaLeyes=mysqli_fetch_array($Respuesta))
	{
		$PesoMuestra=$FilaLeyes["peso_muestra"];
		$PesoRetalla=$FilaLeyes["peso_retalla"];
		$Recargo    =$FilaLeyes["recargo"];
	}
	$Consulta="select * from age_web.leyes_por_lote ";
	$Consulta.= " where lote='".$MuestraParalela."' ";
	$Consulta.= " and recargo='0' and cod_leyes in('02','04','05') ";
	$Consulta.= " and ano='".substr($DatosLote["fecha_recepcion"],0,4)."' ";
	//$Cu_Par=0;
	//$Ag_Par=0;
	//$Au_Par=0;
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
	$Consulta.= " and ano='".substr($DatosLote["fecha_recepcion"],0,4)."' ";
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
	$Consulta = "select distinct t1.id_muestra,t1.nro_solicitud, t1.recargo ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " where t1.id_muestra='".$Lote."' and t1.agrupacion in(1,3,6,99)";// and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProducto'";
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
	//echo "SA_Pri:".$SA_Pri;
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
	$valores = $Cu_Pri."**".$Ag_Pri."**".$Au_Pri."**".$Cu_Par."**".$Ag_Par."**".$Au_Par."**".$SA_Pri."**".$SA_Par;
    return $valores;
}
?>
</table>	  
</td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
