<?php
	$CodigoDeSistema = 21;
	$CodigoDePantalla = 1;
	include("../principal/conectar_principal.php");

	$CmbMovimiento  = isset($_REQUEST["CmbMovimiento"])?$_REQUEST["CmbMovimiento"]:"101";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$Mensaje = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
?>
<html>
<head>
<title>Interfaces Codelco</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	var Valores='';
	switch (opt)
	{
		case "C"://CONSULTAR
			f.action = "traspaso_recepcion.php?Mostrar=S";
			f.submit();
			break;
		case "G":
			Valores=RecuperarValoresCheckeado();
			//alert(Valores);
			if(Valores!='')
			{	
				if(confirm('¿Esta Seguro de Traspasar Los Datos?'))
				{
					f.action = "traspaso_recepcion01.php?Valores="+Valores+"&Proceso=G";
					f.submit();
				}
			}	
			else
				alert('Debe Seleccionar Lote');
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "E"://EXCEL
			break;
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=21&Nivel=0";
			f.submit();
			break;
	}	
}
function CheckearTodo()
{
	var Frm = frmPrincipal;
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckCod[i].checked=true;
			}
			else
			{
				Frm.CheckCod[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function RecuperarValoresCheckeado()
{
	var Frm = frmPrincipal;
	var Valores="";
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckCod[i].checked==true)
			{
				Valores=Valores + Frm.CheckCod[i].value+"~~"+Frm.TxtMovimiento[i].value+"//";
			}
		}
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);
	}
	catch (e)
	{
	}
}
function AsignaMovimiento()
{
	var f=document.frmPrincipal;
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="CheckCod" && f.elements[i].checked==true)
		{
			f.elements[i+1].value=f.CmbMovimiento.value;
			if (f.CmbMovimiento.value=="102")
				f.elements[i+1].style.background="YELLOW";
			else
				f.elements[i+1].style.background="WHITE";
		}
	}
}

function DescargaArchivos()
{
	window.open("descarga.php?Proceso=R&Tipo=REC","","top=35,left=10,width=600,height=400,scrollbars=yes,resizable=YES,toolbar=YES,menubar=YES");
}
function DetallePrv(Prod,SubPro,RutPrv)
{
	var Frm = frmPrincipal;
	window.open("detalle_lotes_prv.php?Producto="+Prod+"&SubProducto="+SubPro+"&RutPrv="+RutPrv+"&Mes="+Frm.Mes.value+"&Ano="+Frm.Ano.value,"","top=60,left=0,width=770,height=385,scrollbars=yes,resizable = yes");			
}
</script>
</head>
<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="650" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="4" class="ColorTabla02"><strong>GENERACION DE ARCHIVO RECEPCIONES PARA "SAP" <strong>(TIPO 5 - TIPO 3)</strong></strong></td>
        </tr>
        <tr>
          <td width="92" height="23">Mes Traspaso</td>
          <td width="166">
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
          <td align="right">&nbsp;</td>
          <td width="183">&nbsp;            </td>
        </tr>
        <tr>
          <td height="23">SubProducto</td>
          <td height="23"><select name="CmbSubProducto" style="width:300" onKeyDown="TeclaPulsada2('N',false,this.form,'btnconsultar');">
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				$Consulta = "SELECT cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' and cod_subproducto between 1 and 80";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
          </select></td>
          <td height="23" align="right">&nbsp;</td>
          <td height="23" align="center"><span class="Estilo1"><a href="JavaScript:DescargaArchivos()"><strong>Descargar Archivos</strong></a></span></td>
        </tr>
        <tr>
          <td height="23">Asignar Movimiento:</td>
          <td height="23">
		  <select name="CmbMovimiento">
			<?php
				switch ($CmbMovimiento)
				{
					case "101":
						echo "<option selected value='101'style='background:WHITE'>101 - Ingresar</option>\n";
						echo "<option value='921'style='background:WHITE'>921 - Ingresar</option>\n";
						echo "<option value='102' style='background:YELLOW'>102 - Eliminar</option>\n";
						echo "<option value='922' style='background:YELLOW'>922 - Eliminar</option>\n";
						break;
					case "921":
						echo "<option value='101'style='background:WHITE'>101 - Ingresar</option>\n";
						echo "<option selected value='921'style='background:WHITE'>921 - Ingresar</option>\n";
						echo "<option value='102' style='background:YELLOW'>102 - Eliminar</option>\n";
						echo "<option value='922' style='background:YELLOW'>922 - Eliminar</option>\n";
						break;
					case "102":
						echo "<option value='101'style='background:WHITE'>101 - Ingresar</option>\n";
						echo "<option value='921'style='background:WHITE'>921 - Ingresar</option>\n";
						echo "<option selected value='102' style='background:YELLOW'>102 - Eliminar</option>\n";
						echo "<option value='922' style='background:YELLOW'>922 - Eliminar</option>\n";
						break;
					case "922":
						echo "<option value='101'style='background:WHITE'>101 - Ingresar</option>\n";
						echo "<option value='921'style='background:WHITE'>921 - Ingresar</option>\n";
						echo "<option value='102' style='background:YELLOW'>102 - Eliminar</option>\n";
						echo "<option selected value='922' style='background:YELLOW'>922 - Eliminar</option>\n";
						break;
				}
			?>		  
          </select>
		  <input name="BtnMovimiento" type="button" id="BtnMovimiento" style="width:70px;" onClick="AsignaMovimiento()" value="Asignar"></td>
          <td height="23" align="right">&nbsp;</td>
          <td height="23">&nbsp;</td>
        </tr>
        <tr align="center">
          <td height="23" colspan="4">
			<input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:90">
			<input name="BtnCrearArchivo" type="button" style="width:85px;" onClick="Proceso('G')" value="Crear Archivo">
			<input name="BtnImprimir" type="button"  value="Imprimir" onClick="Proceso('I')" style="width:90">
			<input name="BtnSalir" type="button" value="Salir" onClick="Proceso('S')" style="width:100"></td>
        </tr>
        <tr align="center">
          <td height="23" colspan="4"><table width="600" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr>
              <td width="50" bgcolor="#FFFFFF">&nbsp;</td>
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
        <br>
        <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr class="ColorTabla01">
      <td width="20" align="center"><input type="checkbox" name="CheckTodos" onClick="CheckearTodo()"></td>
	  <td width="120" align="center">SUB-PROD.</td>
      <td width="38">EST</td>
      <td width="36">TRASP</td>
      <td width="80" align="center">LOTE</td>
	  <td width="30" align="center">EST</td> 
	  <td width="80" align="center">FEC.RECEP</td> 
      <td width="30" align="center">MOV</td>
      <td width="60" align="center">C.VALORIZ</td>
      <td width="50" align="center">CENTRO</td>
      <td width="50" align="center">ALMACEN</td>
      <td width="80" align="center">CANT</td>
      </tr>
<?php	
if ($Mostrar == "S")
{		
	$FechaDesde=$Ano."-".$Mes."-01 00:00:00";
	$FechaHasta=$Ano."-".$Mes."-31 23:59:59";
	$Consulta="SELECT * from interfaces_codelco.asignaciones where rut_proveedor<>'99999999-9'";
	$RespAsig= mysqli_query($link, $Consulta);	
	$RutCompra="(";
	while ($FilaAsig=mysqli_fetch_array($RespAsig))
	{			
		$RutCompra=$RutCompra."'".$FilaAsig["rut_proveedor"]."',";
	}
	$RutCompra=substr($RutCompra,0,strlen($RutCompra)-1);
	$RutCompra=$RutCompra.")";
	$Consulta="select t1.rut_proveedor,t1.asignacion,t2.NOMPRV_A as nom_prv from interfaces_codelco.asignaciones t1 left join rec_web.proved t2 on t1.rut_proveedor=t2.RUTPRV_A where t1.entrada<>'' ";
	$RespAsig= mysqli_query($link, $Consulta);	
	echo '<input name="CheckCod" type="hidden"><input type="hidden" name="TxtMovimiento">';
	//echo $Consulta;
	while ($FilaAsig=mysqli_fetch_array($RespAsig))
	{			
		echo '<tr class="Detalle01">';
		echo "<td colspan='14' align='left'><strong>ASIGNACION:&nbsp;.'".$FilaAsig["asignacion"]."'&nbsp;&nbsp;&nbsp;&nbsp;PROVEEDOR:&nbsp;'".$FilaAsig["rut_proveedor"]."'&nbsp;&nbsp;&nbsp;'".$FilaAsig["nom_prv"]."'</strong></td>";
		echo '</tr>';
		$TotCant=0;
		$Consulta="select distinct t1.cod_subproducto,t2.abreviatura as nom_prod from interfaces_codelco.asignaciones t5 inner join age_web.lotes t1 on t5.entrada<>'' ";
		$Consulta.="inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
		$Consulta.="where t1.fecha_recepcion between '$FechaDesde' and '$FechaHasta' ";
		$Consulta.="and t1.cod_producto='1' ";
		if($CmbSubProducto!='S')
			$Consulta.="and t1.cod_subproducto='$CmbSubProducto' ";
		if($FilaAsig["rut_proveedor"]=='99999999-9')
			$Consulta.="and t1.rut_proveedor not in ".$RutCompra;	
		else
			$Consulta.="and t1.rut_proveedor = '".$FilaAsig["rut_proveedor"]."'";
		$Consulta.="group by t1.cod_subproducto";
		$RespProd = mysqli_query($link, $Consulta);	
		//echo $Consulta;
		while ($FilaProd=mysqli_fetch_array($RespProd))
		{			
			$Consulta="select case when isnull(t5.entrada) then '921' else t5.entrada end as cod_entrada,t4.tipo_movimiento,case when isnull(t4.referencia) then 'No' else 'Si' end as traspasado,"; 
			$Consulta.="t3.materiales_sap,t3.pedido,t3.posicion,t3.clase_valorizacion,t1.cod_producto ,t1.cod_subproducto ,t1.rut_proveedor as rut,t1.lote,t1.fecha_recepcion,sum(peso_neto) as peso,min(t1.estado_lote) as estado ";
			$Consulta.="from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote = t2.lote ";
			if($FilaAsig["rut_proveedor"]=='99999999-9')
				$Consulta.="left join interfaces_codelco.pedido_de_compra t3 on t3.rut='99999999-9' and t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
			else
				$Consulta.="left join interfaces_codelco.pedido_de_compra t3 on t1.rut_proveedor=t3.rut and t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";				
			$Consulta.="left join interfaces_codelco.registro_traspaso t4 on t1.lote=t4.referencia and ano='$Ano' and mes='$Mes' ";
			$Consulta.="left join interfaces_codelco.asignaciones t5 on t1.rut_proveedor=t5.rut_proveedor ";
			$Consulta.="where t1.estado_lote <> '6' and t1.fecha_recepcion between '".$FechaDesde."' and '".$FechaHasta."' ";
			$Consulta.="and t1.cod_producto='1' ";
			$Consulta.="and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";
			if($FilaAsig["rut_proveedor"]=='99999999-9')
			{	
				$Consulta.="and t1.rut_proveedor not in ".$RutCompra;
				$Consulta.="group by t1.cod_subproducto";	
			}	
			else
			{
				$Consulta.="and t1.rut_proveedor = '".$FilaAsig["rut_proveedor"]."'";
				$Consulta.="group by t1.rut_proveedor";
			}	
			//echo $Consulta."<br><br>";
			$Encontro=false;
			$CantReg=0;$TotCantProd=0;
			$Resp=mysqli_query($link, $Consulta);	
			while($Fila=mysqli_fetch_array($Resp))
			{			
				$Encontro=true;
				$LoteTraspaso=substr($Fila["fecha_recepcion"],0,4).$Fila["lote"];
				echo '<tr>';
				echo '<td align="center"><input name="CheckCod" type="checkbox" value='.$Fila["lote"].'~~'.$FilaProd["cod_subproducto"].'~~'.$FilaAsig["rut_proveedor"].'></td>';//SELECCION
				echo '<td align="left">'.$FilaProd["nom_prod"].'</td>';
				echo '<td align="center">'.$Fila["tipo_movimiento"].'&nbsp;</td>';//ESTADO
				if($Fila["traspasado"]=='Si')
					$ColorTraspaso = "#00CC00";
				else
					$ColorTraspaso = "#FF6600";
				echo '<td align="center" bgcolor="'.$ColorTraspaso.'">'.$Fila["traspasado"].'</td>';//TRASPASO
				echo '<td align="center"><a href=JavaScript:DetallePrv("1","'.$FilaProd["cod_subproducto"].'","'.$FilaAsig["rut_proveedor"].'")>'.$LoteTraspaso.'</a></td>';//LOTE
				if($Fila["estado"]=='4')
					echo "<td><STRONG><font color='#000000'>C</font></STRONG></td>\n";
				else
					echo "<td><STRONG><font color='#FF0000'>A</font></STRONG></td>\n";	
				
				echo '<td align="center">'.$Fila["fecha_recepcion"].'</td>';//PEDIDO
				echo '<td align="center"><input type="text" name="TxtMovimiento" value="'.$Fila["cod_entrada"].'" size="6" readonly class="InputCen"></td>';//CLASE DE MOVIMIENTO
				//echo '<td align="right">'.$Fila[pedido].'&nbsp;</td>';//PEDIDO
				//echo '<td align="right">'.$Fila[posicion].'&nbsp;</td>';//POSICION
				echo '<td align="right">'.$Fila["clase_valorizacion"].'&nbsp;</td>';//CLASE VALORIZACION
				echo '<td align="right">FV01</td>';//CENTRO
				echo '<td align="right">0005</td>';//ALMACEN
				echo '<td align="right">'.number_format($Fila["peso"],0,',','.').'</td>';//PESO
				echo '</tr>';
				$CantReg++;
				$TotCantProd=$TotCantProd+$Fila["peso"];
				$TotCant=$TotCant+$TotCantProd;
			}
			/*if($Encontro==true)
			{
				echo '<tr class="Detalle02">';
				echo "<td colspan='12'><strong>&nbsp;&nbsp;SUBPRODUCTO:&nbsp;$FilaProd["nom_prod"]</strong></td>";
				echo "<td align='right'><strong>".number_format($TotCantProd,0,',','.')."</strong></td>";
				echo '</tr>';
			}*/	
		}
		echo '<tr class="Detalle01">';
		echo "<td colspan='11' align='left'><strong>TOTAL ASIGNACION:&nbsp;'".$FilaAsig["asignacion"]."'&nbsp;&nbsp;&nbsp;&nbsp;PROVEEDOR:&nbsp;'".$FilaAsig["rut_proveedor"]."'&nbsp;&nbsp;&nbsp;'".$FilaAsig["nom_prv"]."'</strong></td>";
		echo "<td align='right'><strong>".number_format($TotCant,0,',','.')."</strong></td>";
		echo '</tr>';
	}	
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