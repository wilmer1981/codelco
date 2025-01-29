<?php
	$CodigoDeSistema = 21;
	$CodigoDePantalla = 8;
	include("../principal/conectar_principal.php");
	include("funciones_interfaces_codelco.php");
	
	$CmbMovimiento  = isset($_REQUEST["CmbMovimiento"])?$_REQUEST["CmbMovimiento"]:"";
	$CmbOrden       = isset($_REQUEST["CmbOrden"])?$_REQUEST["CmbOrden"]:"";
	$Orden          = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
	$CmbAlmacen     = isset($_REQUEST["CmbAlmacen"])?$_REQUEST["CmbAlmacen"]:"";
	
	if ($CmbMovimiento=="")
		$CmbMovimiento="921";
	if ($Orden=="")
		$Orden="L";		
    /*
	if(!isset($TxtFechaCon))
	{
		$TxtFechaCon = date("Y-m-d");

	}*/
	if(isset($_REQUEST["TxtFechaCon"])){
		$TxtFechaCon = $_REQUEST["TxtFechaCon"];
	}else {
		$TxtFechaCon = date("Y-m-d");
	}

	if(isset($_REQUEST["Mensaje"])){
		$Mensaje = $_REQUEST["Mensaje"];
	}else {
		$Mensaje = "";
	}
	if(isset($_REQUEST["Mostrar"])){
		$Mostrar = $_REQUEST["Mostrar"];
	}else {
		$Mostrar = "";
	}

	if(isset($_REQUEST["TxtTonelaje"])){
		$TxtTonelaje = $_REQUEST["TxtTonelaje"];
	}else {
		$TxtTonelaje = "";
	}
	if(isset($_REQUEST["TxtLote"])){
		$TxtLote = $_REQUEST["TxtLote"];
	}else {
		$TxtLote = "";
	}
	

?>
<html>
<head>
<title>Traspaso Emb. PAC</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	var Valor="";
	switch (opt)
	{
		case "CA"://CREAR ARCHIVO
			Valor="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkSelec" && f.elements[i].checked==true)
					Valor=Valor + f.elements[i].value + "~" + f.elements[i+1].value + "~" + f.elements[i+2].value + "~" + f.elements[i+3].value + "~" + f.elements[i+4].value + "//";
			}
			if (Valor=="")
			{
				alert("No ha seleccionado elementos para Traspasar");
				return;
			}
			else
			{
				if(confirm('\xBFEsta Seguro de Traspasar Los Datos?'))
				{
					Valor=Valor.substr(0,Valor.length-2);
					//alert(Valor);
					f.action = "traspaso_embarque_acid_manual01.php?Proceso=CA&Valor="+Valor;
					f.submit();
				}
			}	
			break;
		case "CR"://CREAR REGISTRO		
			if(confirm('\xBFEsta Seguro de Crear Registro?'))
			{
				f.action = "traspaso_embarque_acid_manual01.php?Proceso=CR";
				f.submit();
			}
			break;
		case "C"://CONSULTAR
			f.action = "traspaso_embarque_acid_manual.php?Mostrar=S&Orden=<?php echo $Orden; ?>";
			f.submit();
			break;
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=21&Nivel=0";
			f.submit();
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
	}	
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
			//TIPO MOVIMIENTO
			if (f.CmbMovimiento.value!="")
			{
				f.elements[i+1].value=f.CmbMovimiento.value;
				if (f.CmbMovimiento.value=="922")
					f.elements[i+1].style.background="YELLOW";
				else
					f.elements[i+1].style.background="white";
			}
			//ORDEN COMPRA Y CLASE VALORIZACION
			if (f.CmbOrden.value!="")
			{
				var OrdenAux="";
				var ClaseValorAux="";
				var Largo=f.CmbOrden.value.length;
				for (j=0;j<=Largo;j++)
				{
					if (f.CmbOrden.value.substring(j,j+1)=="~")
					{
						OrdenAux=f.CmbOrden.value.substring(0,j);
						ClaseValorAux=f.CmbOrden.value.substring(j+1);
					}
				}
				f.elements[i+2].value=OrdenAux;
				f.elements[i+2].style.background="YELLOW";
				f.elements[i+3].value=ClaseValorAux;
				f.elements[i+3].style.background="YELLOW";
			}
			//ALMACEN
			if (f.CmbAlmacen.value!="")
			{
				f.elements[i+4].value=f.CmbAlmacen.value;
				f.elements[i+4].style.background="YELLOW";
			}
		}
	}
}
function DescargaArchivos()
{
	window.open("descarga.php?Proceso=E&Tipo=ACI","","top=35,left=10,width=600,height=400,scrollbars=yes,resizable=YES,toolbar=YES,menubar=YES");
}
</script><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">

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

</style></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="600" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
        <tr align="center" class="ColorTabla01">
          <td height="23" colspan="5" class="ColorTabla02"><strong>GENERACION DE ARCHIVO MANUAL DE EMBARQUE PARA &quot;SAP&quot; - ACIDO SULFURICO </strong></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="100" height="23">Fecha:</td>
          <td colspan="3"><input name="TxtFechaCon" type="text" class="InputCen" value="<?php echo $TxtFechaCon; ?>" size="15" maxlength="10" >
            <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="17" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaCon,TxtFechaCon,popCal);return false"> </td>
          <td width="112" align="center"><span class="Estilo1"><a href="JavaScript:DescargaArchivos()">Descargar Archivos</a></span></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="30">SubProducto:</td>
          <td height="30" colspan="4">ACIDO SULFURICO
              <input type="hidden" name="Producto" value="ACID"></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="30">Cantidad:</td>
          <td height="30" colspan="4">
              <input type="text" name="TxtTonelaje" value="<?php echo $TxtTonelaje;?>" onKeyDown="TeclaPulsada(true)" size="12" maxlength="12">&nbsp;TON.</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td height="30">Identi.Lote:</td>
          <td height="30" colspan="4">
              <input type="text" name="TxtLote" value="<?php echo $TxtLote;?>" maxlength="5" size="12"></td>
        </tr>
        <tr align="center" bgcolor="#FFFFFF">
          <td>&nbsp;</td>
          <td width="99" height="16" class="ColorTabla01">Movimiento</td>
          <td width="147" class="ColorTabla01">Orden - Valorizacion </td>
          <td width="122" height="16" class="ColorTabla01">Almacen</td>
          <td height="16">&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>Asignar Valores:</td>
          <td height="28"><select name="CmbMovimiento" id="select3">
              <?php
	switch ($CmbMovimiento)
	{
		case "921":
			echo "<option value='' class='NoSelec'>Tipo Movimiento</option>\n";
			echo "<option selected value='921'>921 - Ingresar</option>\n";
			echo "<option value='922'>922 - Eliminar</option>\n";
			break;
		case "922":
			echo "<option value='' class='NoSelec'>Tipo Movimiento</option>\n";
			echo "<option value='921'>921 - Ingresar</option>\n";
			echo "<option selected value='922'>922 - Eliminar</option>\n";
			break;
		default:
			echo "<option selected value='' class='NoSelec'>Tipo Movimiento</option>\n";
			echo "<option value='921'>921 - Ingresar</option>\n";
			echo "<option value='922'>922 - Eliminar</option>\n";
			break;
	}
?>
            </select>
          </td>
          <td height="28"><select name="CmbOrden">
              <option value="" class="NoSelec">Orden - Valorizacion.</option>
              <?php
				$Consulta = "select distinct codigo_op, clase_valorizacion from interfaces_codelco.ordenes_produccion where codigo_op<>'' and clase_valorizacion like '%ACIDO%' order by codigo_op ";
				$Resp = mysqli_query($link, $Consulta);	 
				while ($Fila=mysqli_fetch_array($Resp))
				{
					if ($CmbOrden==$Fila["codigo_op"])
						echo "<option selected value=\"".strtoupper($Fila["codigo_op"])."~".strtoupper($Fila["clase_valorizacion"])."\">".strtoupper($Fila["codigo_op"])." - ".strtoupper($Fila["clase_valorizacion"])."</option>\n";
					else
						echo "<option value=\"".strtoupper($Fila["codigo_op"])."~".strtoupper($Fila["clase_valorizacion"])."\">".strtoupper($Fila["codigo_op"])." - ".strtoupper($Fila["clase_valorizacion"])."</option>\n";
				}
			  ?>
          </select></td>
          <td height="28"><select name="CmbAlmacen" id="select4">
              <option value="" class="NoSelec">Almacen</option>
              <?php
				$Consulta = "select distinct cod_almacen_codelco, abreviatura from interfaces_codelco.relacion_almacen order by cod_almacen_codelco ";
				$Resp = mysqli_query($link, $Consulta);	 
				while ($Fila=mysqli_fetch_array($Resp))
				{
					if ($CmbAlmacen==$Fila["cod_almacen_codelco"])
						echo "<option selected value=\"".$Fila["cod_almacen_codelco"]."\">".strtoupper($Fila["abreviatura"])."</option>\n";
					else
						echo "<option value=\"".$Fila["cod_almacen_codelco"]."\">".strtoupper($Fila["abreviatura"])."</option>\n";
				}			  
	
			?>
            </select>
          </td>
          <td align="center"><input name="BtnMovimiento" type="button" id="BtnMovimiento" style="width:70px;" onClick="AsignaMovimiento()" value="Asignar"></td>
        </tr>
        <tr align="center" class="Detalle02">
          <td height="30" colspan="5">
		    <input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
		    <input name="BtnCrearRegistro2" type="button" style="width:105px;" onClick="Proceso('CR')" value="Crear Registro">
		  <input name="BtnCrearArchivo" type="button" style="width:85px;" onClick="Proceso('CA')" value="Crear Archivo">
          <input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="Proceso('S')">          </td>
        </tr>
        <tr align="center" class="Detalle01">
          <td colspan="5">&nbsp;</td>
        </tr>
      </table><br>
	  <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
        <tr class="ColorTabla01">
          <td><input name="ChkMarcaTodo" type="checkbox" id="ChkMarcaTodo" value="S" onClick="MarcaTodo(this)"></td>
          <td width="38">Est.</td>
          <td width="36">Trasp.</td>
          <td width="33">Ley</td>
          <td width="60">Fec. Guia</td>
          <td width="30" align="center">Movi.</td>
          <td width="200" align="center">Descripcion</td>
          <td width="47" align="center">Mat.</td>
          <td width="40" align="center">Cant.</td>
          <td width="35" align="center">Unid.</td>
          <td width="77" align="center">Lote.Ventana</td>
          <td align="center">Orden</td>
          <td width="31" align="center">Valoriz.</td>
          <td width="31" align="center">Almacen</td>
        </tr>
        <?php	
		if ($Mostrar == "S")
		{
			$Ano=substr($TxtFechaCon,0,4);
			$Mes=substr($TxtFechaCon,5,2);
			$Tipo = "1";
			$ContCantidad = 0;
			$SubTotalPeso = 0;
			$Consulta ="SELECT * from interfaces_codelco.registro_traspaso ";
			$Consulta.="WHERE tipo_registro='99' AND ano='".$Ano."' AND mes='".$Mes."' ";
			$Resp = mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Resp))
			{
				$Datos=explode('~~',$Fila["registro"]);
				$Referencia=$Datos[5];
				$SAP_OrdenProd_Manual = "";
				$SAP_ClaseValoriz_Manual = "";
				$SAP_Almacen_Manual = "";		
				//CONSULTA SI ESTA TRASPASADO
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
					$SAP_OrdenProd_Manual = $Datos[6];
					$SAP_ClaseValoriz_Manual = $Datos[7];
					$SAP_Almacen_Manual = $Datos[8];
					$Traspaso="Si";
				}		
				$AnoLote = substr($Datos[0],0,4);		
				$SAP_OrdenProd = $Datos[6];
				$SAP_CodMaterial = $Datos[2];
				$SAP_Cantidad = $Datos[3];
				$SAP_Unidad = $Datos[4];
				$SAP_ClaseValoriz = $Datos[7];
				$SAP_Centro = $Datos[8];
				echo '<tr>';	
				$ClaveChk =$Datos[0]."~".$Datos[2]."~".$Datos[3]."~".$Datos[4]."~".$Datos[5];
				echo '<td align="center"><input type="checkbox" name="ChkSelec" value="'.$ClaveChk.'"></td>';//CHECKBOX PARA SELECCIONAR
				echo '<td align="center" bgcolor="'.$ColorEstado.'">'.$Estado.'</td>';//TIPO	
				echo '<td align="center" bgcolor="'.$ColorTraspaso.'">'.$Traspaso.'</td>';
				/*
				if ($Fila["con_leyes"] == "S")
				{
					echo "<td align='center'>";
					echo "<a href=\"JavaScript:Historial('".$Fila["num_certificado"]."','".$Fila["num_recargo"]."')\">";
					echo substr($Fila["num_certificado"],4)."</a></td>\n";
				}
				else
				{
					echo "<td>&nbsp;</td>\n";
				}	
				*/	
				echo "<td>&nbsp;</td>\n";	
				echo '<td align="center">'.substr($Datos[0],0,2).".".substr($Datos[0],3,2).".".substr($Datos[0],6,4).'</td>';//FECHA DOC. (ETA)
				echo '<td align="center"><input type="text" name="TxtMovimiento" '.$ColorTxtMov.' value="'.$TipoMovimiento.'" size="6" readonly class="InputCen"></td>';//CLASE DE MOVIMIENTO
				echo '<td align="center">'.$Referencia.'</td>';//DESCRIPCION PRODUCTO
				echo '<td align="center">'.$SAP_CodMaterial.'</td>';//CODIGO MATERIAL
				echo '<td align="right">'.number_format((float)$SAP_Cantidad,0,",",".").'</td>';//CANTIDAD
				echo '<td align="center">'.$SAP_Unidad.'</td>';//UNIDAD DE MEDIDA
				echo '<td>'.$Referencia.'</td>';//IDENTIFICACION
				echo "<td align=\"center\"><input type=\"text\" name=\"TxtOrden\" value=\"";
				if ($SAP_OrdenProd_Manual!="")
					echo $SAP_OrdenProd_Manual;
				else
					echo $SAP_OrdenProd;		
				echo "\" size=\"8\" readonly class=\"InputCen\"></td>\n";//ORDEN DE PRODUCTO
				echo "<td align=\"center\"><input type=\"text\" name=\"TxtClaseValor\" value=\"";
				if ($SAP_ClaseValoriz_Manual!="")
					echo $SAP_ClaseValoriz_Manual;
				else
					echo $SAP_ClaseValoriz;
				echo "\" size=\"15\" readonly class=\"InputCen\"></td>\n";//CLASE DE VALORIZACION		
				echo "<td align=\"right\"><input type=\"text\" size=\"8\" readonly class=\"InputCen\" value=\"";
				if ($SAP_Almacen_Manual=="")
					echo "0005";
				else
					echo $SAP_Almacen_Manual;
				echo "\"></td>";//ALMACEN		
				echo '</tr>';
				$ContCantidad++;
				$SubTotalPeso = (int)$SubTotalPeso + (int)$SAP_Cantidad;
				//GUARDA REG. ANTERIOR
			}
			EscribeSubTotal("", $ContCantidad, $SubTotalPeso);
		}			
function EscribeSubTotal($Desc, $Reg, $Peso)
{
	//ESCRIBE TOTALES POR PRODUCTO
	echo '<tr class="Detalle01">';
	echo '<td align="left" colspan="4">&nbsp;</strong></td>';
	echo '<td align="left" colspan="3"><strong>>>TOTAL '.$Desc.'</strong></td>';
	echo '<td align="right" colspan="2"><strong>'.$Reg.' reg(s)</strong></td>';
	echo '<td align="right"><strong>'.number_format($Peso,0,',','.').'</strong></td>';
	echo '<td align="center" colspan="4">&nbsp;</td>';
	echo '</tr>';
	$Reg = 0;
	$Peso = 0;
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
<?php
if($Mensaje!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('$Mensaje')";
	echo "</script>";
}

?>