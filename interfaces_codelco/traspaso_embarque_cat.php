<?php
	set_time_limit(2000);
	$CodigoDeSistema = 21;
	$CodigoDePantalla = 2;
	include("../principal/conectar_principal.php");
	include("funciones_interfaces_codelco.php");

	$CmbMovimiento  = isset($_REQUEST["CmbMovimiento"])?$_REQUEST["CmbMovimiento"]:"921";
	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$Mensaje = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");

	$Orden   = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"L";
	$CodProducto     = isset($_REQUEST["CodProducto"])?$_REQUEST["CodProducto"]:"";
	$SubProducto     = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";

/*
	if(isset($_REQUEST["DescAnt"])){
		$DescAnt = $_REQUEST["DescAnt"];
	}else {
		$DescAnt = "";
	}*/


?>
<html>
<head>
<title>Traspaso Emb. Catodos</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	var Valor="";
     var algo="";
	switch (opt)
	{
		case "G"://GENERA ARCHIVO		
			Valor="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkSelec" && f.elements[i].checked==true)
				{
					if (f.elements[i+4].name=="ChkMarca" && f.elements[i+4].checked==true)	
					{

						Valor=Valor + f.elements[i].value + "~" + f.elements[i+1].value + "~" + f.elements[i+2].value + "~" + f.elements[i+3].value + "~E~~";
					}
					else
					{
						Valor=Valor + f.elements[i].value + "~" + f.elements[i+1].value + "~" + f.elements[i+2].value + "~" + f.elements[i+3].value + "~~T~~";
					}
				}	
			}
			
			if (Valor=="")
			{
				alert("No ha seleccionado elementos para Traspasar");
				return;
			}
			else
			{
				if(confirm('¿Esta Seguro de Traspasar Los Datos?'))
				{
					var Largo = Valor.length;
					f.Valores.value = Valor.substring(0,Largo-2);
					//alert(Valor);
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

			f.action = "traspaso_embarque_cat.php?Mostrar=S&Orden=<?php echo $Orden; ?>";
			f.submit();
			break; 
		case "R"://RECARGA
			f.action = "traspaso_embarque_cat.php";
			f.submit();
			break;
	}	
}
function Historial(Sa,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ Sa +"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function DetalleLeyes(prod,subprod,num,Sol,idioma)
{
	var f = document.frmPrincipal;	
    var contador = 1;
  	if ((prod == '19') || (prod== '18' && (subprod=='16' || subprod=='17' || subprod =='49'))) // leyes para RESTOS y EW STD 1, 2 y 3
    {
          var URL = "../cal_web/cal_generacion_certificados_analisis.php?contador="+contador+"&NumCertificado=" + num + "&SolRecargo=" + Sol;
          window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");

    }else{
        var URL = "../sec_web/sec_con_certificado_creado.php?NumCertificado=" + num + "&Idioma=" + idioma;
        window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
    }
}
function DetalleLoteCAT(prod,subprod,ano,cod_lote,num_lote)
{
	window.open("../sec_web/sec_con_balance_detalle_paquete.php?Producto="+prod+"&SubProducto="+subprod+"&Ano="+ano+"&Codigo="+cod_lote+"&Numero="+num_lote,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable=YES");
}
function DetalleLotePMN(num_lote,prod,subprod)
{
	var f=document.frmPrincipal;
	window.open("detalle_lote_pmn.php?AnoAux="+f.Ano.value+"&MesAux="+f.Mes.value+"&NumLote="+num_lote+"&Producto="+prod+"&SubProducto="+subprod,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable=YES");
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

function MarcaCatodo(MC)
{
	var f=document.frmPrincipal;
	var Valor=false;
	if (MC.checked==true)
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
			//alert (f.CmbMovimiento.value);
				f.elements[i+1].value=f.CmbMovimiento.value;
				if (f.CmbMovimiento.value=="922")
					f.elements[i+1].style.background="YELLOW";
				else
					f.elements[i+1].style.background="white";
			}
				//alert (f.elements[i+2].value);
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
			/*if (f.CmbAlmacen.value!="")
			{
				f.elements[i+4].value=f.CmbAlmacen.value;
				f.elements[i+4].style.background="YELLOW";
			}*/
		}
	}
}

function Ordenar(opcion)
{
	var f = document.frmPrincipal;
	f.action = "traspaso_embarque_cat.php?Mostrar=S&Orden="+opcion;
	f.submit();
}

function DescargaArchivos()
{
	window.open("descarga.php?Proceso=E&Tipo=CAT&M=T","","top=35,left=10,width=600,height=400,scrollbars=yes,resizable=YES,toolbar=YES,menubar=YES");
}
</script><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">

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
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top">        <table width="550" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
          <tr align="center" class="ColorTabla01">
            <td height="23" colspan="5" class="ColorTabla02"><strong>GENERACION DE ARCHIVO DE EMBARQUE PARA &quot;SAP&quot; -CATODOS </strong></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td width="101" height="23">Mes Traspaso:</td>
            <td colspan="3">
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
              </select>          </td>
            <td width="112"><span class="Estilo1"><a href="JavaScript:DescargaArchivos()">Descargar Archivos</a></span></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="24">Producto:</td>
            <td height="24" colspan="4"><select name="CodProducto" onChange="Proceso('R')">
			<option value="S">SELECCIONAR</option>
  <?php
	$Consulta = "select * from proyecto_modernizacion.productos ";
	$Consulta.= " where cod_producto in('18','48','19','64') order by lpad(cod_producto,2,'0')";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		if ($CodProducto==$Fila["cod_producto"])
			echo "<option value=\"".$Fila["cod_producto"]."\" selected>".strtoupper($Fila["descripcion"])."</option>\n";
		else
			echo "<option value=\"".$Fila["cod_producto"]."\" >".strtoupper($Fila["descripcion"])."</option>\n";			
	}
?>		  
            </select>
              <input type="hidden" name="Producto" value="CAT">            </td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="24">SubProducto</td>
            <td height="24" colspan="4"><select name="SubProducto">
              <option value="S">TODOS</option>
              <?php
	$Consulta = "select * from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='".$CodProducto."' ";
	if($CodProducto=='18')
		$Consulta.= " and cod_subproducto<>'40'";	
	$Consulta.= " order by lpad(cod_subproducto,2,'0')";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		if ($SubProducto==$Fila["cod_subproducto"])
			echo "<option value=\"".$Fila["cod_subproducto"]."\" selected>".strtoupper($Fila["descripcion"])."</option>\n";
		else
			echo "<option value=\"".$Fila["cod_subproducto"]."\" >".strtoupper($Fila["descripcion"])."</option>\n";			
	}
?>
            </select></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td>&nbsp;</td>
            <td width="104" height="16" class="ColorTabla01">Movimiento</td>
            <td width="149" class="ColorTabla01">Orden - Valorizacion </td>
           <!-- <td width="114" height="16" class="ColorTabla01">Almacen</td>-->
            <td height="16" colspan="2">&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>Asignar Valores:</td>
            <td height="28"><select name="CmbMovimiento" id="select">
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
              </select> </td>
            <td height="28"><select name="CmbOrden">
                <option value="" class="NoSelec">Orden - Valorizacion.</option>
                <?php
	$Consulta = "select distinct codigo_op, clase_valorizacion from interfaces_codelco.ordenes_produccion where codigo_op<>'' order by codigo_op ";
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
            <!--<td height="28"><select name="CmbAlmacen" id="CmbClaseValor">
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
          </td>-->
            <td align="center" colspan="2"><input name="BtnMovimiento" type="button" id="BtnMovimiento2" style="width:70px;" onClick="AsignaMovimiento()" value="Asignar"></td>
          </tr>
          <tr align="center" class="Detalle02">
            <td height="24" colspan="5">              <input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
              <input name="BtnCrearArchivo" type="button" id="BtnCrearArchivo2" style="width:85px;" onClick="Proceso('G')" value="Crear Archivo">              
              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
            <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')">              </td></tr>
          <tr align="center" class="Detalle01">
            <td colspan="5"><table width="600" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
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
        <td width="73"><a href="JavaScript:Ordenar('F')">Fecha Guia</a></td> 
        <td width="30" align="center">Movi.</td>
        <td align="center">Descripcion</td>
        <td width="23" align="center">Mat.</td>
        <td width="24" align="center">Almacen</td>
        <td width="71" align="center">Cantidad</td>
        <td width="35" align="center">Unid.</td>
        <td width="77" align="center"><a href="JavaScript:Ordenar('L')">Lote.Ventana</a></td>
        <td align="center">Orden</td>
        <td align="center">Valoriz.</td>
		    <td><input name="ChkMarcaCatodo" type="checkbox" id="ChkMarcaCatodo" value="S" onClick="MarcaCatodo(this)"></td>
			
      </tr>
  <?php	

if ($Mostrar == "S")
{
	$ArrResp = array();
	$ArrRespLeyes = array();
	$Tipo = "1";
	$Almacen = "0005";
	$Prod=$CodProducto;
	$SubProd=$SubProducto;
	RescataCatodos($Prod, $SubProd, $Ano, $Mes, $ArrResp, "", $ArrRespLeyes, $Orden, $link);
	$ContCantidad = 0;
	$SubTotalPeso = 0;
	$ProdAnt = "";
	$SubProdAnt = "";
	$DescAnt    = "";
	reset($ArrResp);

	//while (list($k,$Fila)=each($ArrResp))
	foreach ($ArrResp as $k => $Fila)
	{
		$Referencia="";

		//echo "Producto Ant----".$ProdAnt."---sub ante--".$SubProdAnt."---fila producto---".$Fila["cod_producto"]."---fila sunpro---".$Fila["cod_subproducto"];
		if (($ProdAnt!="" || $SubProdAnt!="") && ($ProdAnt!=$Fila["cod_producto"] || $SubProdAnt!=$Fila["cod_subproducto"]))

			EscribeSubTotal($DescAnt, $ContCantidad, $SubTotalPeso);
		$Lote2 = $Fila["cod_bulto"]."~".$Fila["num_bulto"];	
		$Referencia=substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT).'".$Fila["corr_enm"]."';
        // echo "-------------entrooooo".'".$Fila["corr_enm"]."';
		$SAP_OrdenProd_Manual = "";
		$SAP_ClaseValoriz_Manual = "";
		//CONSULTA SI ESTA TRASPASADO
		$Consulta = "select * from interfaces_codelco.registro_traspaso ";
		$Consulta.= " where tipo_registro='".$Tipo."' and ano='".$Ano."' and mes='".$Mes."' ";
		$Consulta.= " and referencia='".$Referencia."' ";		
		//echo "Connnnn".$Consulta;
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
			$SAP_OrdenProd_Manual = trim(substr($Fila2["registro"],32,12));
			$SAP_ClaseValoriz_Manual = trim(substr($Fila2["registro"],90,11));
			$Traspaso="Si";
		}		
		$AnoLote = substr($Fila["fecha_creacion_lote"],0,4);		
		$SAP_OrdenProd = "";
		$SAP_CodMaterial = "";
		$SAP_Unidad = "";
		$SAP_ClaseValoriz = "";
		$SAP_Centro = "";
		//echo "PPP".$Fila["cod_marca"];
		OrdenProduccionSap($Fila["asignacion"],$Fila["cod_producto"],$Fila["cod_subproducto"],$SAP_OrdenProd,$SAP_CodMaterial,$SAP_Unidad,$SAP_ClaseValoriz,$SAP_Centro);	
		echo '<tr>';	
		$ClaveChk = $Fila["cod_producto"]."~".$Fila["cod_subproducto"]."~".$Lote2."~".'".$Fila["corr_enm"]."';
		//echo "SSS".$ClaveChk."--".$Estado."--".$Fila2["tipo_movimiento"];
		echo '<td align="center"><input type="checkbox" name="ChkSelec" value="'.$ClaveChk.'"></td>';//CHECKBOX PARA SELECCIONAR
		
				//poly 07-10-2010
	//echo "POLY".$Traspaso."<br>";
		echo '<td align="center" bgcolor="'.$ColorEstado.'">'.$Estado.'</td>';//TIPO	
		echo '<td align="center" bgcolor="'.$ColorTraspaso.'">'.$Traspaso.'</td>';
		if ($Fila["con_leyes"] == "S")
		{
			echo "<td align='center'>";
 //  echo "SSS".$Fila["num_certificado"]."-".$Fila["cod_producto"]."-".$Fila["cod_subproducto"]."---SA----".$Fila["nro_solicitud"];
   
   		//	echo "<a href=\"JavaScript:DetalleLeyes('".$Fila["num_certificado"]."','E')\"><img src='../Principal/imagenes/ico_pag.gif' width='18' height='9' border='0'>\n";
			
	         if (($Fila["cod_producto"] == '19') || ($Fila["cod_producto"]== '18'&& ($Fila["cod_subproducto"]=='16' || $Fila["cod_subproducto"]=='17' || $Fila["cod_subproducto"] =='49'))) // leyes para RESTOS y EW STD 1, 2 y 3
				echo "<a href=\"JavaScript:DetalleLeyes('".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','".$Fila["num_certificado"]."','".$Fila["nro_solicitud"]."','E')\"><img src='../Principal/imagenes/ico_pag2.gif' width='18' height='9' border='0'>\n";
			 else	
				echo "<a href=\"JavaScript:DetalleLeyes('".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','".$Fila["num_certificado"]."','".$Fila["nro_solicitud"]."','E')\"><img src='../Principal/imagenes/ico_pag.gif' width='18' height='9' border='0'>\n";
			echo "</a></td>\n";
		}
		else
		{
			echo "<td>&nbsp;</td>\n";
		}			
		echo '<td align="center">'.substr($Fila["fecha_embarque"],8,2).".".substr($Fila["fecha_embarque"],5,2).".".substr($Fila["fecha_embarque"],0,4).'</td>';//FECHA DOC. (ETA)
		echo '<td align="center"><input type="text" name="TxtMovimiento" '.$ColorTxtMov.' value="'.$TipoMovimiento.'" size="6" readonly class="InputCen"></td>';//CLASE DE MOVIMIENTO
		echo '<td align="center">'.$Fila["descripcion"].'</td>';//DESCRIPCION PRODUCTO		
		echo '<td align="center">'.$SAP_CodMaterial.'</td>';//CODIGO MATERIAL
		echo '<td align="center">'.$Fila["desc_almacen_codelco"].'</td>';//ALMACEN CODELCO
		echo '<td align="right">'.number_format($Fila["peso"],0,",",".").'</td>';//CANTIDAD
		echo '<td align="center">'.$SAP_Unidad.'</td>';//UNIDAD DE MEDIDA
		echo '<td align="center">';
		echo "<a href=\"JavaScript:DetalleLoteCAT('".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','".$AnoLote."','".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."')\">";
		echo substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT).'".$Fila["corr_enm"]."'.'</a></td>';//LOTE
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
		echo '<td align="center"><input type="checkbox" name="ChkMarca" value="'.$ChkMarca.'"></td>';//CHECKBOX Marca ingles

		echo "</tr>\n";
		$ContCantidad++;
		$SubTotalPeso = $SubTotalPeso + $Fila["peso"];
		//GUARDA REG. ANTERIOR
		$ProdAnt    = $Fila["cod_producto"];
		$SubProdAnt = $Fila["cod_subproducto"];
		$DescAnt    = $Fila["descripcion"];
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
	echo '<td align="center" colspan="4">&nbsp;</td>';
	echo '</tr>';
	$Reg = 0;
	$Peso = 0;
}
?>	
  </table>	  
          <br>
        <br></td></tr>
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
