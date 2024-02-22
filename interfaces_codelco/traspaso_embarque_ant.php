<?php
	$CodigoDeSistema = 21;
	$CodigoDePantalla = 2;
	include("../principal/conectar_principal.php");
	include("funciones_interfaces_codelco.php");
	if (!isset($CmbMovimiento))
		$CmbMovimiento="921";

?>
<html>
<head>
<title>Interfaces Codelco</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	var Valor="";
	switch (opt)
	{
		case "G"://GENERA ARCHIVO		
			Valor="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkSelec" && f.elements[i].checked==true)
					Valor=Valor + f.elements[i].value + "~" + f.elements[i+1].value + "~~";
			}
			if (Valor=="")
			{
				alert("No ha seleccionado elementos para Traspasar");
				return;
			}
			else
			{
				if(confirm('�Esta Seguro de Traspasar Los Datos?'))
				{
					var Largo = Valor.length;
					f.Valores.value = Valor.substring(0,Largo-2);				
					f.action = "traspaso_embarque01.php?Proceso=G";
					f.submit();
				}
			}
			break;
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=21&Nivel=0";
			f.submit();
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "C"://CONSULTAR
			f.action = "traspaso_embarque.php?Mostrar=S";
			f.submit();
			break;
	}	
}
function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function DetalleLeyes(num,idioma)
{
	var f = document.frmPrincipal;	
	var URL = "../sec_web/sec_con_certificado_creado.php?NumCertificado=" + num + "&Idioma=" + idioma;
	window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
}

function DetalleLoteCAT(prod,subprod,ano,cod_lote,num_lote)
{
	window.open("../sec_web/sec_con_balance_detalle_paquete.php?Producto=" + prod + "&SubProducto=" + subprod + "&Ano=" + ano + "&Codigo=" + cod_lote + "&Numero=" + num_lote,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
}

function DetalleLotePMN(num_lote,prod,subprod)
{
	var f=document.frmPrincipal;
	window.open("detalle_lote_pmn.php?AnoAux="+f.Ano.value+"&MesAux="+f.Mes.value+"&NumLote="+num_lote+"&Producto="+prod+"&SubProducto="+subprod,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
}

function MarcaTodo(CB)
{
	var f=document.frmPrincipal;
	var Valor=false;
	if (CB.checked==true)
		Valor=true;
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="ChkSelec")
			f.elements[i].checked=Valor;
	}
}
function AsignaMovimiento()
{
	var f=document.frmPrincipal;
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="ChkSelec" && f.elements[i].checked==true)
		{
			f.elements[i+1].value=f.CmbMovimiento.value;
			if (f.CmbMovimiento.value=="922")
				f.elements[i+1].style.background="YELLOW";
			else
				f.elements[i+1].style.background="white";
		}
	}
}

function DescargaArchivos()
{
	window.open("descarga.php?Proceso=E","","top=35,left=10,width=600,height=400,scrollbars=yes,resizable=YES,toolbar=YES,menubar=YES");
}
</script><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {
	color: #0066CC;
	font-weight: bold;
}
-->
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="550" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="3" class="ColorTabla02"><strong>GENERACION DE ARCHIVO DE EMBARQUE PARA &quot;SAP&quot; (TIPO 1) </strong></td>
        </tr>
        <tr>
          <td width="124" height="23">Mes Traspaso:</td>
          <td colspan="2">
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
          </tr>
        <tr>
          <td height="30">SubProducto:</td>
          <td height="30"><select name="Producto">
<?php
	if (!isset($Producto))
		$Producto = "CAT";
	switch ($Producto)
	{
		case "CAT":
			echo "<option selected value='CAT'>PROD. CATODOS</option>\n";
			echo "<option value='PMN'>PROD. PLAMEN</option>\n";
			break;
		case "PMN":
			echo "<option value='CAT'>PROD. CATODOS</option>\n";
			echo "<option selected value='PMN'>PROD. PLAMEN</option>\n";
			break;
	}
?>		  
          </select> </td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td height="30">Asignar Movimiento:</td>
          <td width="213" height="30"><select name="CmbMovimiento" id="CmbMovimiento">
<?php
	switch ($CmbMovimiento)
	{
		case "921":
			echo "<option selected value='921'>921 - Ingresar</option>\n";
			echo "<option value='922'>922 - Eliminar</option>\n";
			break;
		case "922":
			echo "<option value='921'>921 - Ingresar</option>\n";
			echo "<option selected value='922'>922 - Eliminar</option>\n";
			break;
	}
?>		  
          </select>
            <input name="BtnMovimiento" type="button" id="BtnMovimiento" style="width:70px;" onClick="AsignaMovimiento()" value="Asignar"></td>
          <td width="247" align="center"><span class="Estilo1"><a href="JavaScript:DescargaArchivos()">Descargar Archivos</a></span></td>
          </tr>
        <tr align="center">
          <td height="30" colspan="3"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
            <input name="BtnCrearArchivo" type="button" id="BtnCrearArchivo" style="width:85px;" onClick="Proceso('G')" value="Crear Archivo">
            <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')">              </td>
        </tr>
        <tr align="center">
          <td colspan="3"><table width="600" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr>
              <td width="50">&nbsp;</td>
              <td width="100">Insertado</td>
              <td width="50" bgcolor="#FFFF00">&nbsp;</td>
              <td width="100">Eliminado</td>
              <td width="50" bgcolor="#00CC00">&nbsp;</td>
              <td width="100">Traspasado</td>
              <td width="50" bgcolor="#FF6600">&nbsp;</td>
              <td width="100">No Traspasado</td>
            </tr>
          </table></td>
        </tr>
      </table>        
        <br>
        <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr class="ColorTabla01">
      <td><input name="ChkMarcaTodo" type="checkbox" id="ChkMarcaTodo" value="S" onClick="MarcaTodo(this)"></td>
      <td width="38">Estado</td>
      <td width="36">Trasp.</td>
      <td width="33">Leyes</td>
      <td width="73">Fecha Guia </td> 
      <td width="30" align="center">Movi.</td>
      <td align="center">Descripcion</td>
      <td align="center">Orden</td>
      <td width="47" align="center">Mat.</td>
      <td width="71" align="center">Cantidad</td>
      <td width="35" align="center">Unid.</td>
      <td width="77" align="center">Lote.Ventana</td>
      <td width="62" align="center">Valoriz.</td>
      </tr>
<?php	
if ($Mostrar == "S")
{
	$ArrResp = array();
	$ArrRespLeyes = array();
	$Tipo = "1";
	$Almacen = "0005";
	$Prod="";
	$SubProd="";
	switch ($Producto)
	{
		case "CAT":
			RescataCatodos($Prod, $SubProd, $Ano, $Mes, &$ArrResp, "", &$ArrRespLeyes, $Orden);
			break;
		case "PMN":
			RescataPlamen($Prod, $SubProd, $Ano, $Mes, &$ArrResp, "", &$ArrRespLeyes);
			break;			
	}	
	$ContCantidad = 0;
	$SubTotalPeso = 0;
	$ProdAnt = "";
	$SubProdAnt = "";
	reset($ArrResp);
	while (list($k,$Fila)=each($ArrResp))
	{
		$Referencia="";
		if (($ProdAnt!="" || $SubProdAnt!="")&&($ProdAnt!=$Fila["cod_producto"] || $SubProdAnt!=$Fila["cod_subproducto"] ))
			EscribeSubTotal($DescAnt, &$ContCantidad, &$SubTotalPeso);
		switch ($Producto)
		{
			case "CAT":
				$Lote2 = $Fila["cod_bulto"]."~".$Fila["num_bulto"];	
				$Referencia=substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT).'".$Fila["corr_enm"]."';
				break;
			case "PMN":
				$Lote2 = $Fila["lote"];	
				$Referencia = $Fila["lote"];	
				break;
		}		
		//CONSULTA SI ESTA TRASPASADO
		if ($Fila["cod_producto"]=="29" && $Fila["cod_subproducto"]=="4")
		{
			$Consulta = "select * from pmn_web.detalle_embarque_plata where ano='".$Ano."' and mes='".$Mes."' and num_electrolisis='".$Referencia."'";
			$Resp3=mysqli_query($link, $Consulta);
			while ($Fila3=mysqli_fetch_array($Resp3))
			{
				$Consulta = "select * from interfaces_codelco.registro_traspaso ";
				$Consulta.= " where tipo_registro='".$Tipo."' and ano='".$Ano."' and mes='".$Mes."' ";
				$Consulta.= " and referencia like '".$Fila3["caja_ini"]."%' ";		
				$Resp2 = mysqli_query($link, $Consulta);
				$Traspaso="No";
				$Estado="&nbsp;";
				$ColorEstado = "";		
				$ColorTraspaso = "#FF6600";		
				$TipoMovimiento = $CmbMovimiento;
				$ColorTxtMov = "";
				if ($Fila2 = mysqli_fetch_array($Resp2))
				{
					if ($Fila2["tipo_movimiento"]=="922")
					{
						$ColorEstado="YELLOW";
						$ColorTxtMov = "style='background=yellow;'";
					}
					$TipoMovimiento = $Fila2["tipo_movimiento"];
					$Estado = $Fila2["tipo_movimiento"];
					$ColorTraspaso = "#00CC00";			
					$Traspaso="Si";
				}		
			}
		}
		else
		{
			$Consulta = "select * from interfaces_codelco.registro_traspaso ";
			$Consulta.= " where tipo_registro='".$Tipo."' and ano='".$Ano."' and mes='".$Mes."' ";
			$Consulta.= " and referencia='".$Referencia."' ";		
			$Resp2 = mysqli_query($link, $Consulta);
			$Traspaso="No";
			$Estado="&nbsp;";
			$ColorEstado = "";		
			$ColorTraspaso = "#FF6600";		
			$TipoMovimiento = $CmbMovimiento;
			$ColorTxtMov = "";
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				if ($Fila2["tipo_movimiento"]=="922")
				{
					$ColorEstado="YELLOW";
					$ColorTxtMov = "style='background=yellow;'";
				}
				$TipoMovimiento = $Fila2["tipo_movimiento"];
				$Estado = $Fila2["tipo_movimiento"];
				$ColorTraspaso = "#00CC00";			
				$Traspaso="Si";
			}		
		}
		$AnoLote = substr($Fila["fecha_creacion_lote"],0,4);		
		$SAP_OrdenProd = "";
		$SAP_CodMaterial = "";
		$SAP_Unidad = "";
		$SAP_ClaseValoriz = "";
		$SAP_Centro = "";
		OrdenProduccionSap($Fila["cod_producto"],$Fila["cod_subproducto"],&$SAP_OrdenProd,&$SAP_CodMaterial,&$SAP_Unidad,&$SAP_ClaseValoriz,&$SAP_Centro);	
		echo '<tr>';	
		if ($Fila["cod_producto"]=="29" && $Fila["cod_subproducto"]=="4")
			$ClaveChk = $Fila["cod_producto"]."~".$Fila["cod_subproducto"]."~".$Lote2."//".$Fila["num_acta"];
		else
			$ClaveChk = $Fila["cod_producto"]."~".$Fila["cod_subproducto"]."~".$Lote2;
		echo '<td align="center"><input type="checkbox" name="ChkSelec" value="'.$ClaveChk.'"></td>';//CHECKBOX PARA SELECCIONAR
		echo '<td align="center" bgcolor="'.$ColorEstado.'">'.$Estado.'</td>';//TIPO	
		echo '<td align="center" bgcolor="'.$ColorTraspaso.'">'.$Traspaso.'</td>';
		if ($Fila["con_leyes"] == "S")
		{
			switch ($Producto)
			{
				case "CAT":
					echo "<td align='center'>";
					echo "<a href=\"JavaScript:DetalleLeyes('".$Fila["num_certificado"]."','E')\"><img src='../Principal/imagenes/ico_pag.gif' width='18' height='9' border='0'>\n";
					echo "</a></td>\n";
					break;
				case "PMN":
					echo "<td align='center'>";
					/*if ($Fila["cod_producto"]=="29" && $Fila["cod_subproducto"]=="4")
						echo "<a href=\"JavaScript:DetalleLotePMN('".$Fila["lote"]."~~".$Fila["num_acta"]."','".$Fila["cod_producto"]."',".$Fila["cod_subproducto"].")\">";
					else
						echo "<a href=\"JavaScript:DetalleLotePMN('".$Fila["lote"]."','".$Fila["cod_producto"]."',".$Fila["cod_subproducto"].")\">";*/
					echo "<a href=\"JavaScript:Historial('".$Fila["num_certificado"]."','".$Fila["num_recargo"]."')\">";
					echo substr($Fila["num_certificado"],4)."</a></td>\n";
					break;
			}			
		}
		else
		{
			echo "<td>&nbsp;</td>\n";
		}			
		echo '<td align="center">'.substr($Fila["fecha_embarque"],8,2).".".substr($Fila["fecha_embarque"],5,2).".".substr($Fila["fecha_embarque"],0,4).'</td>';//FECHA DOC. (ETA)
		echo '<td align="center"><input type="text" name="TxtMovimiento" '.$ColorTxtMov.' value="'.$TipoMovimiento.'" size="6" readonly class="InputCen"></td>';//CLASE DE MOVIMIENTO
		echo '<td align="center">'.$Fila["descripcion"].'</td>';//DESCRIPCION PRODUCTO
		echo '<td align="center">'.$SAP_OrdenProd.'</td>';//ORDEN DE PRODUCTO
		echo '<td align="center">'.$SAP_CodMaterial.'</td>';//CODIGO MATERIAL
		switch ($Producto)
		{
			case "CAT":
				echo '<td align="right">'.number_format($Fila["peso"],0,",",".").'</td>';//CANTIDAD
				break;
			case "PMN":
				echo '<td align="right">'.number_format($Fila["peso"],3,",",".").'</td>';//CANTIDAD
				break;
		}
		echo '<td align="center">'.$SAP_Unidad.'</td>';//UNIDAD DE MEDIDA
		echo '<td align="center">';
		switch ($Producto)
		{
			case "CAT":
				echo "<a href=\"JavaScript:DetalleLoteCAT('".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','".$AnoLote."','".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."')\">";
				echo substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT).'".$Fila["corr_enm"]."'.'</a></td>';//LOTE
				break;
			case "PMN":
				if ($Fila["cod_producto"]=="29" && $Fila["cod_subproducto"]=="4")
					echo "<a href=\"JavaScript:DetalleLotePMN('".$Fila["lote"]."~~".$Fila["num_acta"]."','".$Fila["cod_producto"]."',".$Fila["cod_subproducto"].")\">";
				else
					echo "<a href=\"JavaScript:DetalleLotePMN('".$Fila["lote"]."','".$Fila["cod_producto"]."',".$Fila["cod_subproducto"].")\">";
				echo $Fila["lote"].'</a></td>';//LOTE
				break;
		}
		echo '<td align="center">'.$SAP_ClaseValoriz.'</td>';//CLASE DE VALORIZACION				
		echo '</tr>';
		$ContCantidad++;
		$SubTotalPeso = $SubTotalPeso + $Fila["peso"];
		//GUARDA REG. ANTERIOR
		$ProdAnt = $Fila["cod_producto"];
		$SubProdAnt = $Fila["cod_subproducto"];
		$DescAnt = $Fila["descripcion"];
	}
	EscribeSubTotal($DescAnt, $ContCantidad, $SubTotalPeso);
}			
function EscribeSubTotal($Desc, $Reg, $Peso)
{
	//ESCRIBE TOTALES POR PRODUCTO
	echo '<tr class="Detalle01">';
	echo '<td align="left" colspan="4">&nbsp;</strong></td>';
	echo '<td align="left" colspan="3"><strong>>>TOTAL '.$Desc.'</strong></td>';
	echo '<td align="right" colspan="2"><strong>'.$Reg.' reg(s)</strong></td>';
	echo '<td align="right"><strong>'.number_format($Peso,0,',','.').'</strong></td>';
	echo '<td align="center" colspan="3">&nbsp;</td>';
	echo '</tr>';
	$Reg = 0;
	$Peso = 0;
}
?>	
</table>	  
        <br>
      <br></td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
<?php
if($Mensaje!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('$Mensaje')";
	echo "</script>";
}

?>