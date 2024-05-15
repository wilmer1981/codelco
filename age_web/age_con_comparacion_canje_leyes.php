<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 42;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date('n');
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date('Y');
	$TxtFiltroPrv  = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$SubProducto   = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor     = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
	$Busq          = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
	
?>
<html>
<head>
<title>AGE-Consulta Comparacion Canje Leyes</title>
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
function Recarga3()
{
	var Frm = document.frmPrincipal;
	Frm.action="age_con_comparacion_canje_leyes.php?Busq=S";
	Frm.submit();	
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
			f.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=40";
			f.submit();
			break;
		case "I":
			window.print();
			break;		
		case "R":
			f.action = "age_con_comparacion_canje_leyes.php?Mostrar=<?php echo $Mostrar; ?>";
			f.submit(); 
			break;
		case "C":
			f.action = "age_con_comparacion_canje_leyes.php?Mostrar=S";
			f.submit(); 
			break;
		case "E":
			f.action = "age_con_comparacion_canje_leyes_excel.php?Mostrar=S";
			f.submit(); 
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
      <td width="762" height="313" align="center" valign="top"><table width="750" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="3" class="ColorTabla02"><strong>COMPARACION CANJE LEYES </strong></td>
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
          <td align="right"><div align="left">Proveedor:
                <select name="Proveedor" style="width:330" onChange="Proceso('R')">
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
          </div></td>
          </tr>
        <tr>
          <td height="23" align="right">Producto:</td>
          <td width="273" height="23"><select name="SubProducto" style="width:250" onChange="Proceso('R')">
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
          <td align="center">---> Filtro Prv&nbsp;              <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">              <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">
          </td>
        </tr>
		  <tr align="center">
		  <td colspan="3"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
            <input name="BtnExcel" type="button" id="BtnExcel2" style="width:70px;" onClick="Proceso('E')" value="Excel">
            <input name="BtnImprimir" type="button" id="BtnImprimir2" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
		  </tr>
      </table>
      <br>
	  <table width="750" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
		<tr align="center">
		  <td width="200" bgcolor="#FFFF00">Gana Codelco Div.Ventanas</td>
		  <td width="250" >Prom. Entre(Pqte1 Y Pqte2) O Gana Arbitral</td>
		  <td width="200" bgcolor="#FFFFFF">Gana Enami</td>
		  </tr>
	  </table>		
      <br>
      <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
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
	$Consulta.= " where t1.lote between '".$LoteIni."' and '".$LoteFin."' and canjeable='S' ";
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
		$Consulta = "select distinct t1.lote, t1.muestra_paralela, t1.remuestreo, t1.num_lote_remuestreo, t1.estado_lote ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.leyes_por_lote_canje t2 on t1.lote=t2.lote ";
		$Consulta.= " where t1.lote  between '".$LoteIni."' and '".$LoteFin."' and canjeable='S'";
		$Consulta.= " and t1.cod_producto='".$Fila["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto='".$Fila["cod_subproducto"]."' ";
		$Consulta.= " and t1.rut_proveedor='".$Fila["rut_proveedor"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$Lote=$Fila2["lote"];
			$Cu_Pri=0;$Ag_Pri=0;$Au_Pri=0;$Cu_Seg=0;$Ag_Seg=0;$Au_Seg=0;$Cu_Ter=0;$Ag_Ter=0;$Au_Ter=0;$SA_Pri="";
			Leyes($Lote,$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Seg,$Ag_Seg,$Au_Seg,$Cu_Ter,$Ag_Ter,$Au_Ter,$Ley_CanjeCu,$Ley_CanjeAg,$Ley_CanjeAu,$SA_Pri,$link);						
			$Cu_Dif=0;$Ag_Dif=0;$Au_Dif=0;$Cu_Dif2=0;$Ag_Dif2=0;$Au_Dif2=0;
			if($Cu_Seg>0)
				$Cu_Dif=abs($Cu_Pri-$Cu_Seg);
			if($Ag_Seg>0)	
				$Ag_Dif=abs($Ag_Pri-$Ag_Seg);
			if($Au_Seg>0)	
				$Au_Dif=abs($Au_Pri-$Au_Seg);
			if($Cu_Ter>0)	
				$Cu_Dif2=abs($Cu_Pri-$Cu_Ter);
			if($Ag_Ter>0)	
				$Ag_Dif2=abs($Ag_Pri-$Ag_Ter);
			if($Au_Ter>0)	
				$Au_Dif2=abs($Au_Pri-$Au_Ter);
			echo "<tr align=\"center\">\n";
			echo "<td><a href=\"JavaScript:Historial('".$SA_Pri."','0')\">".$Lote."</a></td>\n";
			if($Cu_Pri==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else			
				echo "<td align=\"right\">".number_format($Cu_Pri,3,",",".")."</td>\n";
			if($Ag_Pri==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Ag_Pri,3,",",".")."</td>\n";
			if($Au_Pri==0)	
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Au_Pri,3,",",".")."</td>\n";
			if($Cu_Seg==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Cu_Seg,3,",",".")."</td>\n";
			if($Ag_Seg==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Ag_Seg,3,",",".")."</td>\n";
			if($Au_Seg==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Au_Seg,3,",",".")."</td>\n";
			if($Cu_Dif==0)
				echo "<td class='Detalle02' align=\"right\">&nbsp;</td>\n";
			else
				echo "<td class='Detalle02' align=\"right\">".number_format($Cu_Dif,3,",",".")."</td>\n";
			if($Ag_Dif==0)
				echo "<td class='Detalle02' align=\"right\">&nbsp;</td>\n";
			else
				echo "<td class='Detalle02' align=\"right\">".number_format($Ag_Dif,3,",",".")."</td>\n";
			if($Au_Dif==0)
				echo "<td class='Detalle02' align=\"right\">&nbsp;</td>\n";
			else
				echo "<td class='Detalle02' align=\"right\">".number_format($Au_Dif,3,",",".")."</td>\n";
			if($Cu_Ter==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Cu_Ter,3,",",".")."</td>\n";
			if($Ag_Ter==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Ag_Ter,3,",",".")."</td>\n";
			if($Au_Ter==0)
				echo "<td align=\"right\">&nbsp;</td>\n";
			else
				echo "<td align=\"right\">".number_format($Au_Ter,3,",",".")."</td>\n";
			if($Cu_Dif2==0)
				echo "<td class='Detalle02' align=\"right\">&nbsp;</td>\n";
			else
				echo "<td class='Detalle02' align=\"right\">".number_format($Cu_Dif2,3,",",".")."</td>\n";
			if($Ag_Dif2==0)
				echo "<td class='Detalle02' align=\"right\">&nbsp;</td>\n";
			else
				echo "<td class='Detalle02' align=\"right\">".number_format($Ag_Dif2,3,",",".")."</td>\n";
			if($Au_Dif2==0)
				echo "<td class='Detalle02' align=\"right\">&nbsp;</td>\n";
			else
				echo "<td class='Detalle02' align=\"right\">".number_format($Au_Dif2,3,",",".")."</td>\n";
			$ColorCeldaCu="";
			if($Ley_CanjeCu==$Cu_Pri)
				$ColorCeldaCu="bgcolor=\"#FFFF00\"";
			else 
				if($Ley_CanjeCu==$Cu_Seg)	
					$ColorCeldaCu="bgcolor=\"#FFFFFF\"";
			echo "<td $ColorCeldaCu align=\"right\">".number_format($Ley_CanjeCu,3,",",".")."</td>\n";
			$ColorCeldaAg="";
			if($Ley_CanjeAg==$Ag_Pri)
				$ColorCeldaAg="bgcolor=\"#FFFF00\"";
			else 
				if($Ley_CanjeAg==$Ag_Seg)	
					$ColorCeldaAg="bgcolor=\"#FFFFFF\"";
			echo "<td $ColorCeldaAg align=\"right\">".number_format($Ley_CanjeAg,3,",",".")."</td>\n";
			$ColorCeldaAu="";
			if($Ley_CanjeAu==$Au_Pri)
				$ColorCeldaAu="bgcolor=\"#FFFF00\"";
			else 
				if($Ley_CanjeAu==$Au_Seg)	
					$ColorCeldaAu="bgcolor=\"#FFFFFF\"";
			echo "<td $ColorCeldaAu align=\"right\">".number_format($Ley_CanjeAu,3,",",".")."</td>\n";
			echo "</tr>\n";			
		}		
	}
}//FIN MOSTRAR = S	

function Titulo($Prod, $NomProd, $Proved, $NomProved)
{
	echo "<tr class=\"ColorTabla02\">\n";
	echo "<td colspan=\"7\">Producto:&nbsp;".str_pad($Prod,2,'0',STR_PAD_LEFT)."-".strtoupper($NomProd)."</td>\n";
	echo "<td colspan=\"12\">Proveedor:&nbsp;".str_pad($Proved,10,'0',STR_PAD_LEFT)."-".strtoupper($NomProved)."</td>\n";
	echo "</tr>\n";
	echo "<tr align=\"center\" class=\"ColorTabla01\">\n";
	echo "<td width=\"40\" rowspan=\"2\">Lote</td> \n";
	echo "<td colspan=\"3\">Paquete Primero</td>\n";
	echo "<td colspan=\"3\">Paquete Segundo</td>\n";
	echo "<td colspan=\"3\">Dif Pqte1-Pqte2</td>\n";
	echo "<td colspan=\"3\">Paquete Tercero</td>\n";
	echo "<td colspan=\"3\">Dif Pqte1-Pqte3</td>\n";
	echo "<td colspan=\"3\">Resultados</td>\n";
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
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "</tr>\n";
}//FIN FUNCION TITULO

function Leyes($Lote,$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Seg,$Ag_Seg,$Au_Seg,$Cu_Ter,$Ag_Ter,$Au_Ter,$Ley_CanjeCu,$Ley_CanjeAg,$Ley_CanjeAu,$SA_Pri,$link)
{
	$Consulta="select * from age_web.leyes_por_lote_canje where lote='".$Lote."' and cod_leyes in('02','04','05') order by lote,cod_leyes";
	$Cu_Par=0;$Ag_Par=0;$Au_Par=0;
	$Respuesta=mysqli_query($link, $Consulta);
	while($FilaLeyes=mysqli_fetch_array($Respuesta))
	{
		switch($FilaLeyes["cod_leyes"])
		{
			case "02":
				$Cu_Pri=$FilaLeyes["valor1"];
				$Cu_Seg=$FilaLeyes["valor2"];
				$Cu_Ter=$FilaLeyes["valor3"];
				$Ley_CanjeCu=$FilaLeyes["ley_canje"];
				break;
			case "04":
				$Ag_Pri=$FilaLeyes["valor1"];
				$Ag_Seg=$FilaLeyes["valor2"];
				$Ag_Ter=$FilaLeyes["valor3"];
				$Ley_CanjeAg=$FilaLeyes["ley_canje"];
				break;
			case "05":
				$Au_Pri=$FilaLeyes["valor1"];
				$Au_Seg=$FilaLeyes["valor2"];
				$Au_Ter=$FilaLeyes["valor3"];
				$Ley_CanjeAu=$FilaLeyes["ley_canje"];
				break;
		}
	}
	//CONSULTA LA S.A. PAQUETE PRIMERO
	$Consulta = "select distinct t1.id_muestra,t1.nro_solicitud, t1.recargo ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " where t1.id_muestra='".$Lote."' and t1.agrupacion in(1,3,6)";// and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProducto'";
	if($Recargo=='')
		$Consulta.= " and (t1.recargo='0' or t1.recargo='')";
	else
		$Consulta.= " and t1.recargo='".$Recargo."'";	
	$RespSA=mysqli_query($link, $Consulta);
	if($FilaSA=mysqli_fetch_array($RespSA))
		$SA_Pri=$FilaSA["nro_solicitud"];
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