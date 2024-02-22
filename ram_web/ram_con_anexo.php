<?php 
$CodigoDeSistema = 16;
$CodigoDePantalla = 3;
include("../principal/conectar_principal.php");
set_time_limit(1200);

if(isset($_REQUEST["Mostrar"])){
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar = "";
}
if(isset($_REQUEST["Ano"])){
	$Ano = $_REQUEST["Ano"];
}else{
	$Ano = date("Y");
}
if(isset($_REQUEST["Mes"])){
	$Mes = $_REQUEST["Mes"];
}else{
	$Mes = date("m");
}


if ($Mostrar == "S")
{	
	$Consulta = "SELECT * FROM ram_web.existencia_nodo";
	$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."'";
	$Consulta.= " AND bloqueado = '1'";
	//echo $Consulta;
	$Resp2 = mysqli_query($link, $Consulta);
	if (!$Fila2 = mysqli_fetch_array($Resp2))
	{
		//ELIMINA TABLA TEMPORALES
		$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_1";
		mysqli_query($link, $Eliminar);
		$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_2";
		mysqli_query($link, $Eliminar);
		$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_3";
		mysqli_query($link, $Eliminar);
		$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_general";
		mysqli_query($link, $Eliminar);
		$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_final";
		//mysqli_query($link, $Eliminar);
		//LIMPIA TABLAS FLUJOS_MES Y EXISTENCIA NODO
		$Eliminar = "DELETE FROM ram_web.flujos_mes where ano='".$Ano."' and mes='".$Mes."'";
		mysqli_query($link, $Eliminar);
		$Eliminar = "DELETE FROM ram_web.existencia_nodo where ano='".$Ano."' and mes='".$Mes."'";
		mysqli_query($link, $Eliminar);
		//PROCESOS
		$FechaIniTra = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01 08:00:00";
		$FechaFinTra = date("Y-m-d H:i:s", mktime(7,59,00,intval($Mes)+1,1,$Ano));
		$FechaIniRec = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
		$FechaFinRec = date("Y-m-d", mktime(0,0,0,intval($Mes)+1,1,$Ano));
		$FechaFinRec = date("Y-m-d", mktime(0,0,0,intval(substr($FechaFinRec,5,2)),1-1,intval(substr($FechaFinRec,0,4))));
		//echo "fecha:".$FechaFinRec;
		//PROCESO ENABAL 1 crea recepción
		$Consulta = " CREATE  TEMPORARY TABLE ram_web.proceso_enabal_1 AS  SELECT t1.cod_existencia, t2.cod_producto, t2.cod_subproducto,t1.rut_proveedor,";
		$Consulta.= " Sum(t1.peso_humedo) AS SumaDepeso_humedo,Sum(t1.peso_seco) AS SumaDepeso_seco,";
		$Consulta.= " Sum(t1.fino_cu) AS SumaDefino_cu,Sum(t1.fino_ag) AS SumaDefino_ag, Sum(t1.fino_au) AS SumaDefino_au";
		$Consulta.= " FROM ram_web.movimiento_proveedor t1 INNER JOIN ram_web.conjunto_ram_bd t2";
		$Consulta.= " ON t1.num_conjunto = t2.num_conjunto AND t1.cod_conjunto = t2.cod_conjunto";
		$Consulta.= " WHERE t1.fecha_movimiento >= '".$FechaIniRec."' And t1.fecha_movimiento <= '".$FechaFinRec."'";
		$Consulta.= " GROUP BY t1.cod_existencia, t2.cod_producto, t2.cod_subproducto, t1.rut_proveedor";
		$Consulta.= " HAVING t1.cod_existencia='02'";
		mysqli_query($link, $Consulta);
		//echo $Consulta."<br><br>";
		
		//PROCESO ENABAL 2 crea stock final
		$Consulta = " CREATE  TEMPORARY TABLE ram_web.proceso_enabal_2 AS  SELECT '04' AS Expr1, t2.cod_producto, t2.cod_subproducto,";
		$Consulta.= " t1.rut_proveedor, Sum(t1.peso_humedo) AS SumaDepeso_humedo,";
		$Consulta.= " Sum(t1.peso_seco) AS SumaDepeso_seco, Sum(t1.fino_cu) AS SumaDefino_cu,";
		$Consulta.= " Sum(t1.fino_ag) AS SumaDefino_ag, Sum(t1.fino_au) AS SumaDefino_au";
		$Consulta.= " FROM ram_web.movimiento_proveedor t1 INNER JOIN ram_web.conjunto_ram_bd t2";
		$Consulta.= " ON t1.num_conjunto = t2.num_conjunto AND t1.cod_conjunto = t2.cod_conjunto";
		$Consulta.= " WHERE t2.cod_conjunto='01'";
		$Consulta.= " and t1.cod_existencia='01' AND t1.fecha_movimiento='".$FechaFinRec."'";
		$Consulta.= " GROUP BY '04', t2.cod_producto, t2.cod_subproducto, t1.rut_proveedor";
		$Consulta.= " HAVING t2.cod_producto=1";
		mysqli_query($link, $Consulta);
		//echo $Consulta."<br><br>";
		
		//PROCESO  ENABAL 3 crea  movimientos
		$Consulta = " CREATE  TEMPORARY TABLE ram_web.proceso_enabal_3 AS  SELECT t3.COD_LUGAR_DESTINO, t1.cod_existencia,t2.COD_PRODUCTO, t2.COD_SUBPRODUCTO, t1.rut_proveedor,";
		$Consulta.= " Sum(t1.peso_humedo) AS SumaDepeso_humedo, Sum(t1.peso_seco) AS SumaDepeso_seco,";
		$Consulta.= " Sum(t1.fino_cu) AS SumaDefino_cu, Sum(t1.fino_ag) AS SumaDefino_ag,Sum(t1.fino_au) AS SumaDefino_au";
		$Consulta.= " FROM ram_web.movimiento_conjunto t3 INNER JOIN (ram_web.movimiento_proveedor t1 INNER JOIN ram_web.conjunto_ram_bd t2";
		$Consulta.= " ON t1.num_conjunto = t2.num_conjunto AND t1.cod_conjunto = t2.cod_conjunto)";
		$Consulta.= " ON t3.fecha_movimiento = t1.fecha_movimiento";
		$Consulta.= " WHERE (t1.cod_existencia='12' Or t1.cod_existencia='16'";
		$Consulta.= " Or t1.cod_existencia='15' Or t1.cod_existencia='05')";
		$Consulta.= " AND (t1.fecha_movimiento>='".$FechaIniTra."' And t1.fecha_movimiento<='".$FechaFinTra."')";
		$Consulta.= " GROUP BY t3.cod_lugar_destino, t1.cod_existencia,";
		$Consulta.= " t2.cod_producto, t2.cod_subproducto, t1.rut_proveedor";
		$Consulta.= " HAVING (t3.cod_lugar_destino>='14' And t3.cod_lugar_destino<='25')";
		$Consulta.= " AND (t2.cod_subproducto='2' Or t2.cod_subproducto='3'";
		$Consulta.= " Or t2.cod_subproducto='6' Or t2.cod_subproducto='7' Or t2.cod_subproducto='8'";
		$Consulta.= " Or t2.cod_subproducto='12' Or t2.cod_subproducto='14' Or t2.cod_subproducto='91'";
		$Consulta.= " Or t2.cod_subproducto='92' Or t2.cod_subproducto='54')";
		mysqli_query($link, $Consulta);
		//echo $Consulta."<br><br>";
		
		//PROCESO ENABAL GENERAL, junta las tablas en una unión
		$Consulta = " CREATE  TEMPORARY TABLE ram_web.proceso_enabal_general AS";
		$Consulta.= " SELECT 0 as expr1000, cod_existencia, cod_producto, cod_subproducto, rut_proveedor,";
		$Consulta.= " SumaDepeso_humedo,SumaDepeso_Seco,SumaDefino_cu,SumaDefino_ag,SumaDefino_au";
		$Consulta.= " FROM ram_web.proceso_enabal_1";
		$Consulta.= " UNION SELECT 0 as expr1000, expr1, cod_producto, cod_subproducto, rut_proveedor,";
		$Consulta.= " SumaDepeso_humedo,SumaDepeso_Seco,SumaDefino_cu,SumaDefino_ag,SumaDefino_au";
		$Consulta.= " FROM ram_web.proceso_enabal_2";
		$Consulta.= " UNION SELECT cod_lugar_destino, cod_existencia, cod_producto, cod_subproducto, rut_proveedor,";
		$Consulta.= " SumaDepeso_humedo,SumaDepeso_Seco,SumaDefino_cu,SumaDefino_ag,SumaDefino_au";
		$Consulta.= " FROM ram_web.proceso_enabal_3";
		mysqli_query($link, $Consulta);
		//echo $Consulta."<br><br>";
		
		//PROCESO ENABAL FINAL genera tabla final de la unión mas unos campos para selección
		$Consulta = " CREATE TEMPORARY TABLE ram_web.proceso_enabal_final AS";
		$Consulta.= " SELECT t2.expr1000, t2.cod_existencia,";
		$Consulta.= " case when t2.cod_existencia<'05' then t2.cod_existencia else '03' end AS expr3,t2.cod_producto,";
		$Consulta.= " case when IsNull(t1.rut) then '9999999-9' else t2.rut_proveedor end AS expr1,";
		$Consulta.= " case when IsNull(t1.flujo) then (select flujo_rut.flujo from ram_web.flujo_rut";
		$Consulta.= " where t2.expr1000=destino";
		$Consulta.= " and t2.cod_existencia = flujo_rut.cod_existencia";
		$Consulta.= " and t2.cod_producto = flujo_rut.cod_producto";
		$Consulta.= " and t2.cod_subproducto = flujo_rut.cod_subproducto";
		$Consulta.= " and flujo_rut.rut = '99999999-9') else t1.flujo end AS exp2,";
		$Consulta.= " t2.SumaDepeso_humedo,t2.SumaDepeso_seco,t1.nodo,";
		$Consulta.= " t2.SumaDefino_cu,t2.SumaDefino_ag, t2.SumaDefino_au";
		$Consulta.= " FROM ram_web.flujo_rut t1 RIGHT JOIN ram_web.proceso_enabal_general t2";
		$Consulta.= " ON t1.cod_subproducto = t2.cod_subproducto AND t1.destino = t2.expr1000 AND t1.rut = t2.rut_proveedor";
		$Consulta.= " AND t1.cod_producto = t2.cod_producto AND t1.cod_existencia = t2.cod_existencia";
		mysqli_query($link, $Consulta);
		//echo $Consulta."<br><br>";
		
		//GENERA ANEXO Y LLENA TABLAS EXISTENCIA_NODO Y FLUJOS_MES
		$Consulta = " SELECT DISTINCTROW t1.exp2 as flujo_nodo, t1.expr3 as codigo,t1.nodo,t1.expr1 as rut_prv,";
		$Consulta.= " ROUND(Sum(t1.SumaDepeso_humedo)) AS peso_humedo,";
		$Consulta.= " ROUND(Sum(t1.SumaDepeso_seco)) AS peso_seco,";
		$Consulta.= " ROUND(Sum(t1.SumaDefino_cu)) AS fino_cu,";
		$Consulta.= " ROUND(Sum(t1.SumaDefino_ag)) AS fino_ag,";
		$Consulta.= " ROUND(Sum(t1.SumaDefino_au)) AS fino_au";
		$Consulta.= " FROM ram_web.proceso_enabal_final t1 INNER JOIN ram_web.atributo_existencia t2";
		$Consulta.= " ON t1.cod_existencia = t2.cod_existencia";
		$Consulta.= " WHERE t1.exp2<>'0' And t1.exp2<='900'";
		$Consulta.= " GROUP BY flujo_nodo, codigo";
		$Consulta.= " ORDER BY codigo, flujo_nodo";
		//echo $Consulta."<br><br>";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			switch ($Fila["codigo"])
			{
				case "03":		
					//INSERTAR EN TABLA FLUJO MES
					//if($Fila["rut_prv"]!='96561560-1'&&$Fila["rut_prv"]!='90132000-5')
					//{
						if($Fila["nodo"]=='')
							$Nodo=0;
						else
							$Nodo=$Fila["nodo"];
						$Insertar = "INSERT INTO ram_web.flujos_mes(ano, mes, flujo, peso, fino_cu, fino_ag, fino_au,nodo) ";
						$Insertar.= " VALUES('".$Ano."','".$Mes."','".$Fila["flujo_nodo"]."','".$Fila["peso_seco"]."',";
						$Insertar.= "'".$Fila["fino_cu"]."','".$Fila["fino_ag"]."','".$Fila["fino_au"]."','".$Nodo."')";
						mysqli_query($link, $Insertar);
					/*}
					else
					{
						$Insertar = "INSERT INTO ram_web.existencia_nodo(ano, mes, nodo, peso, fino_cu, fino_ag, fino_au, bloqueado) ";
						$Insertar.= " VALUES('".$Ano."','".$Mes."','".$Fila["nodo"]."','".$Fila["peso_seco"]."',";
						$Insertar.= "'".$Fila["fino_cu"]."','".$Fila["fino_ag"]."','".$Fila["fino_au"]."','0')";
						mysqli_query($link, $Insertar);	
						//echo $Insertar."<br>";				
					}*/	
					//echo $Insertar."<br>";
					break;
				case "04":
					//INSERTAR EN TABLA EXISTENCIA NODO
					$Insertar = "INSERT INTO ram_web.existencia_nodo(ano, mes, nodo, peso, fino_cu, fino_ag, fino_au, bloqueado) ";
					$Insertar.= " VALUES('".$Ano."','".$Mes."','".$Fila["flujo_nodo"]."','".$Fila["peso_seco"]."',";
					$Insertar.= "'".$Fila["fino_cu"]."','".$Fila["fino_ag"]."','".$Fila["fino_au"]."','0')";
					mysqli_query($link, $Insertar);
					//echo $Insertar."<br>";
					break;
			}			
		}		
		//ELIMINA TABLA TEMPORALES
		$Eliminar = "DROP TABLE ram_web.proceso_enabal_1";
		//mysqli_query($link, $Eliminar);
		$Eliminar = "DROP TABLE ram_web.proceso_enabal_2";
		//mysqli_query($link, $Eliminar);
		$Eliminar = "DROP TABLE ram_web.proceso_enabal_3";
		//mysqli_query($link, $Eliminar);
		$Eliminar = "DROP TABLE ram_web.proceso_enabal_general";
		//mysqli_query($link, $Eliminar);
		$Eliminar = "DROP TABLE ram_web.proceso_enabal_final";
		//mysqli_query($link, $Eliminar);
	}//FIN VERIFICA BLOQUEO
}//FIN SI ES MOSTRAR
?>
<html>
<head>
<title>Sistema RAM</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frm1;
	switch (opt)
	{
		case "AM":
			var Pag = "../principal/abrir_mes_anexo.php?Sistema=RAM&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			window.open(Pag,"","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
			break;
		case "CM":
			var msg = confirm("¿Esta seguro que desea guardar esta version del Anexo.RAM?");
			if (msg)
			{
				f.action = "ram_con_anexo01.php?Proceso=G&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=16&Nivel=0";
			f.submit();
			break;
		case "I":
			window.print();
			break;
		case "E":
			f.action = "ram_con_anexo_excel.php?Mostrar=S&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			f.submit(); 
			break;
		case "C":
			f.action = "ram_con_anexo.php?Mostrar=S";
			f.submit(); 
			break;
	}	
}
function Detalle(flu)
{
	var f = frm1;		
	window.open("ram_con_anexo_det_flujo.php?Flujo=" + flu + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function DetalleNodo(nodo)
{
	var f = frm1;		
	window.open("ram_con_anexo_det_nodo.php?Nodo=" + nodo + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top">
	  
<table width="600" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr align="center">
    <td height="23" colspan="4" class="ColorTabla02"><strong>ANEXO DE RECEPCION Y ALMACENAMIENTO DE MEZCLA (RAM) </strong></td>
    </tr>
  <tr>
    <td width="92" height="23">Mes Anexo</td>
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
			for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
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
    <td align="right">Cierre Parcial:</td>
  <td width="183">
<?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='7' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='7' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1')";
	$Resp = mysqli_query($link, $Consulta);
	$CierreBalance = false;	
	if ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["estado"]=="C")
		{
			$CierreBalance = true;
			echo "<img src='../principal/imagenes/cand_cerrado.gif'>&nbsp;".$Fila["fecha_cierre"];
		}
		else
			echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
	else
	{
		echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
?></td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
  <td height="23">&nbsp;</td>
    <td height="23" align="right">Cierre General: </td>
  <td height="23"><?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='7' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='7' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2')";
	$Resp = mysqli_query($link, $Consulta);
	$CierreBalance = false;	
	if ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["estado"]=="C")
		{
			$CierreBalance = true;
			echo "<img src='../principal/imagenes/cand_cerrado.gif'>&nbsp;".$Fila["fecha_cierre"];
		}
		else
			echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
	else
	{
		echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
?></td>
  </tr>
  <tr align="center">
    <td height="23" colspan="4"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
        <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
<?php
	if ($Mostrar == "S")
	{		
        echo "<input name='BtnExcel' type='button' style='width:70px;' onClick=\"Proceso('E')\" value='Excel'>\n";
	}
	//Consulto si las existencias del mes estab bloqueadas
	$Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM ram_web.existencia_nodo ";
	$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND bloqueado = '1'";    
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Respuesta);
	if ($Fila["valor"] == "0")
	{		
        echo "<input name='BrnCerrar' type='button' value='Cerrar Mes' style='width:70px;' onClick=\"Proceso('CM')\">";
	}
	else
	{
		if ($CierreBalance == false)
			echo "<input name='BrnAbrir' type='button' value='Abrir Mes' style='width:70px;' onClick=\"Proceso('AM')\">";
	}
?>
        <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
  </tr>
</table>
<br>
	<table width="600" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr align="center" class="ColorTabla01"> 
      <td width="28" rowspan="2">Flujo</td>
      <td width="245" rowspan="2">Descripcion</td>
      <td width="59" rowspan="2">Peso</td>
      <td colspan="3" align="center">Leyes</td>
      <td colspan="3" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="37" align="center">Cu</td>
      <td width="35" align="center">Ag</td>
      <td width="35" align="center">Au</td>
      <td width="37" align="center">Cu</td>
      <td width="35" align="center">Ag</td>
      <td width="53" align="center">Au</td>
    </tr>
<?php	
if ($Mostrar == "S")
{		
	$Consulta = "SELECT t1.flujo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au  ";
	$Consulta.= " FROM ram_web.flujos_mes t1 LEFT join proyecto_modernizacion.flujos t2 ";
	$Consulta.= " on t1.flujo = t2.cod_flujo and t2.sistema = 'RAM'";
	$Consulta.= " WHERE t1.ano = ".$Ano." AND t1.mes = ".$Mes." and t2.esflujo<>'N'";
	$Consulta.= " group by t1.flujo ORDER BY flujo";
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);	
	while ($row = mysqli_fetch_array($Resp))
	{			
		if ($row["peso"] != 0)
		{
			echo '<tr>';
			echo '<td align="center">'.$row["flujo"].'</td>';
			echo '<td align="left"><a href="JavaScript:Detalle('.$row["flujo"].')">'.substr(strtoupper($row["descripcion"]),0,22).'</a></td>';
			echo '<td align="right">'.number_format($row["peso"],0,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_cu"] / $row["peso"] * 100),2,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_ag"] / $row["peso"] * 1000),2,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_au"] / $row["peso"] * 1000),2,',','.').'</td>';	
			echo '<td align="right">'.number_format($row["fino_cu"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_ag"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_au"],0,',','.').'</td>';										
			echo '</tr>';
		}
	}
}			
?>		
	<tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Nodo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="3" align="center">Leyes</td>
      <td colspan="3" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
    </tr>
<?php	
if ($Mostrar == "S")
{					
	$Consulta = "SELECT t1.nodo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au ";
	$Consulta.= " FROM ram_web.existencia_nodo t1 LEFT join proyecto_modernizacion.nodos t2 ";
	$Consulta.= " on t1.nodo = t2.cod_nodo and t2.sistema = 'RAM'";
	$Consulta.= " WHERE t1.ano = ".$Ano." AND t1.mes = ".$Mes." and t2.virtual<>'S'";
	$Consulta.= " ORDER BY nodo";			
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);	
	while ($row = mysqli_fetch_array($Resp))
	{			
		if ($row["peso"] != 0)
		{
			echo '<tr>';
			echo '<td align="center">'.$row["nodo"].'</td>';
			echo '<td align="left"><a href="JavaScript:DetalleNodo('.$row["nodo"].')">'.substr(strtoupper($row["descripcion"]),0,22).'</a></td>';
			echo '<td align="right">'.number_format($row["peso"],0,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_cu"] / $row["peso"] * 100),2,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_ag"] / $row["peso"] * 1000),2,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_au"] / $row["peso"] * 1000),2,',','.').'</td>';	
			echo '<td align="right">'.number_format($row["fino_cu"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_ag"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_au"],0,',','.').'</td>';												
			echo '</tr>';
		}
	}	
}			
?>
</table>      </td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>