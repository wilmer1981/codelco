<?php
	$CodigoDeSistema = 21;
	$CodigoDePantalla = 2;
	include("../principal/conectar_principal.php");
	include("funciones_interfaces_codelco.php");
	include("funcion_consulta.php");
	
	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$Mensaje = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");

	$CmbMovimiento  = isset($_REQUEST["CmbMovimiento"])?$_REQUEST["CmbMovimiento"]:"921";
	$CmbOrden  = isset($_REQUEST["CmbOrden"])?$_REQUEST["CmbOrden"]:"";
	$CmbAlmacen  = isset($_REQUEST["CmbAlmacen"])?$_REQUEST["CmbAlmacen"]:"";

	$Orden        = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"L";
	$CodProducto  = isset($_REQUEST["CodProducto"])?$_REQUEST["CodProducto"]:"18";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Valores      = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
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
	switch (opt)
	{
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=21&Nivel=0";
			f.submit();
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "C"://CONSULTAR
			f.action = "consulta_emb_traspasados.php?Mostrar=S";
			f.submit();
			break; 
		case "E"://CONSULTAR
			f.action = "consulta_emb_traspasados_excel.php?Mostrar=S";
			f.submit();
			break; 
		case "R"://RECARGA
			f.action = "consulta_emb_traspasados.php";
			f.submit();
			break;
	}	
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
          <td height="23" colspan="2" class="ColorTabla02"><strong>CONSULTA DE DATOS TRASPASADOS A SAP </strong></td>
        </tr>
        <tr>
          <td width="114" height="23">Mes Traspaso:</td>
          <td width="417">
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
            </select>            <span class="Estilo1"></span></td>
          </tr>
        <tr>
          <td height="30">Producto:</td>
          <td height="30"><select name="CodProducto" onChange="Proceso('R')">
<?php
	$Consulta = "select * from proyecto_modernizacion.productos ";
	$Consulta.= " where cod_producto in('18','48', '29', '34','46','64') order by lpad(cod_producto,2,'0')";
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
            <input type="hidden" name="Producto" value="CAT"></td>
          </tr>
        <tr>
          <td height="30">SubProducto</td>
          <td height="30"><select name="SubProducto">
		  <option value="S">TODOS</option>
<?php
	$Consulta = "select * from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='".$CodProducto."' order by lpad(cod_subproducto,2,'0')";
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
        <tr align="center">
          <td height="30" colspan="2"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
            <input name="BtnExcel" type="button" id="BtnExcel" style="width:70px;" onClick="Proceso('E')" value="Excel">
            <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
            <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')">              </td>
        </tr>
      </table>        
        <br>
        <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr class="ColorTabla01">
      <td width="38">Tipo</td>
      <td width="36">Fecha Doc</td>
      <td width="33">Fecha Con</td>
      <td width="73">Tipo Mov</td> 
      <td width="30" align="center">Centro</td>
      <td align="center">Almacen</td>
      <td width="23" align="center">Orden Prod</td>
      <td width="24" align="center">Cod Material</td>
      <td width="71" align="center">Cantidad</td>
      <td width="35" align="center">Unid.</td>
      <td width="77" align="center">Lote.Ventana</td>
      <td align="center">Clase Valoriz.</td>
      <td align="center">Status</td>
    </tr>
<?php	
if ($Mostrar == "S")
{
	//CONSULTA CODIGO DE MATRIAL SAP
	echo "entroooo";
	$Consulta = "select * from interfaces_codelco.ordenes_produccion ";
	$Consulta.= " where cod_producto='".$CodProducto."'";
	if ($SubProducto != "S")
	{
		$Consulta.="and cod_subproducto='".$SubProducto."' ";
	}
			//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta);
	$CodMaterialSAP="";
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$CodMaterialSAP=$Fila["cod_material_sap"];
	}
	$ArrResp = array();
	if ($CodProducto=='18' || $CodProducto=='48')
	{
		SapValidos($CodProducto, $Ano, $Mes, $link);
		$Consulta = "select t1.referencia,t1.registro from interfaces_codelco.registro_traspaso t1,";
		$Consulta.= "interfaces_codelco.tmp_control_pas t2";
		$Consulta.= " where t1.ano='".$Ano."' and t1.mes='".$Mes."' and t1.tipo_movimiento='921' ";
		$Consulta.=" and  t1.ano = t2.ano and t1.mes = t2.mes and t1.referencia = t2.referencia";
		$Consulta.= " order by substring(t1.registro,24,4), t1.referencia";
	}
	else
	{
		$Consulta = "select * from interfaces_codelco.registro_traspaso ";
		$Consulta.= " where ano='".$Ano."' and mes='".$Mes."' and tipo_movimiento='921' ";
		$Consulta.= " order by substring(registro,24,4), referencia";
	}
	$Resp=mysqli_query($link, $Consulta);
	$Cont=0;	
	while ($Fila=mysqli_fetch_array($Resp))
	{		
		$ArrResp[$Cont]["tipo"] = substr($Fila["registro"],0,1);
		$ArrResp[$Cont]["fecha_doc"] = substr($Fila["registro"],1,10);
		$ArrResp[$Cont]["fecha_con"] = substr($Fila["registro"],11,10);
		$ArrResp[$Cont]["tipo_mov"] = substr($Fila["registro"],21,3);
		$ArrResp[$Cont]["centro"] = substr($Fila["registro"],24,4);
		$ArrResp[$Cont]["almacen"] = substr($Fila["registro"],28,4);
		$ArrResp[$Cont]["orden_prod"] = substr($Fila["registro"],32,12);
		$ArrResp[$Cont]["cod_material"] = substr($Fila["registro"],44,18);					
		$ArrResp[$Cont]["cantidad"] = substr($Fila["registro"],62,15);
		$ArrResp[$Cont]["unidad"] = substr($Fila["registro"],77,3);
		//$ArrResp[$Cont]["lote"] = substr($Fila["registro"],80,10);
		$ArrResp[$Cont]["lote"] = $Fila["referencia"];
		$ArrResp[$Cont]["clase_valoriz"] = substr($Fila["registro"],90,12);
		$ArrResp[$Cont]["status"] = substr($Fila["registro"],102,1);
		$ArrResp[$Cont]["msg"] = substr($Fila["registro"],103);
		$Cont++;
		//echo $Fila["registro"];
	}
	reset($ArrResp);
	$TotalPesoTraspasado=0;
	$TotalPesoCentro=0;
	$Centro="";
	$CentroAnt="";
	//while (list($k,$Fila)=each($ArrResp))
	foreach ($ArrResp as $k => $Fila)
	{
	//echo "codigo".$CodMaterialSAP;
		if (intval($Fila["cod_material"])==$CodMaterialSAP)
		{
			$Centro=$Fila["centro"];
			if ($CentroAnt!=$Centro && trim($CentroAnt)!="")
			{
				echo "<tr class=\"Detalle01\">";
				echo "<td colspan=\"8\"><b>TOTAL ".$CentroAnt."</b></td>";
				echo "<td align=\"right\">".number_format($TotalPesoCentro,1,",",".")."</td>";
				echo "<td colspan=\"4\">&nbsp;</td>";
				echo "</tr>";
				$TotalPesoCentro=0;
			}
			$Cantidad=(str_replace(",",".",$Fila["cantidad"])*1);
			echo "<tr>";
			echo "<td align=\"center\">".$Fila["tipo"]."</td>";
			echo "<td align=\"center\">".$Fila["fecha_doc"]."</td>";
			echo "<td align=\"center\">".$Fila["fecha_con"]."</td>";
			echo "<td align=\"center\">".$Fila["tipo_mov"]."</td>";
			echo "<td align=\"center\">".$Centro."</td>";
			echo "<td align=\"center\">".$Fila["almacen"]."</td>";
			echo "<td align=\"center\">".$Fila["orden_prod"]."</td>";
			echo "<td align=\"center\">".intval($Fila["cod_material"])."</td>";
			echo "<td align=\"right\">".number_format($Cantidad,1,",",".")."</td>";
			echo "<td align=\"center\">".$Fila["unidad"]."</td>";
			echo "<td align=\"center\">".$Fila["lote"]."</td>";
			echo "<td align=\"center\">".$Fila["clase_valoriz"]."</td>";
			if ($Fila["status"]!="")
				echo "<td align=\"center\">".$Fila["status"]."</td>";
			else
				echo "<td align=\"center\">&nbsp;</td>";
			echo "</tr>";
			$TotalPesoTraspasado=$TotalPesoTraspasado + $Cantidad;
			$TotalPesoCentro=$TotalPesoCentro + $Cantidad;
			$CentroAnt=$Centro;
		}
	}
	/*if ($CentroAnt!=$Centro && $Centro!="")
	{*/
		echo "<tr class=\"Detalle01\">";
		echo "<td colspan=\"8\"><b>TOTAL ".$CentroAnt."</b></td>";
		echo "<td align=\"right\">".number_format($TotalPesoCentro,1,",",".")."</td>";
		echo "<td colspan=\"4\">&nbsp;</td>";
		echo "</tr>";
		$TotalPesoCentro=0;
	//}
	echo "<tr class=\"Detalle01\">";
	echo "<td colspan=\"8\"><b>TOTAL TRASPASADO</b></td>";
	echo "<td align=\"right\">".number_format($TotalPesoTraspasado,1,",",".")."</td>";
	echo "<td colspan=\"4\">&nbsp;</td>";
	echo "</tr>";
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