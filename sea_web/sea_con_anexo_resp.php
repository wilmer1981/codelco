<?php 
$CodigoDeSistema = 16;
$CodigoDePantalla = 1;
include("../principal/conectar_principal.php");
if (!isset($Ano))
	$Ano = date("Y");
if (!isset($Mes))
	$Mes = date("n");	
if ($Mostrar == "S")
{
	//************************************** FLUJOS ********************************************	
	$Consulta = "SELECT * FROM sea_web.existencia_nodo";
	$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."'";
	$Consulta.= " AND bloqueado = '1'";
	$Resp2 = mysqli_query($link, $Consulta);
	if (!$Fila2 = mysqli_fetch_array($Resp2))
	{
		//PROCESO
		$Unidades = array('02'=>100,'04'=>1000,'05'=>1000);
		$Fecha_Ini = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
		$Fecha_Ter = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-31";
		//Obtiene los todos flujos
		$Consulta = "SELECT * FROM proyecto_modernizacion.flujos WHERE sistema = 'SEA' and esflujo<>'N' ";
		$Consulta.= " ORDER BY cod_flujo";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			//Borra el Registro Existente
			$Eliminar = "DELETE FROM sea_web.stock_anexo";
			$Eliminar.= " WHERE mes = '".$Mes."'";
			$Eliminar.= " AND ano = '".$Ano."'";
			$Eliminar.= " AND flujo = '".$Fila["cod_flujo"]."'";
			mysqli_query($link, $Eliminar);
			
			//Consulta si el flujo representa el movimiento de beneficio
			$Consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo";
			$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
			$Resp3 = mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			if ($Fila3 = mysqli_fetch_array($Resp3))
			{
				if ($Fila3["cod_proceso"] == 2)
				{
					//Consulto el peso total por el flujo, considerando tambien fecha_benef
					$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
					$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
					$Consulta.= " AND ((fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."' AND fecha_benef = '0000-00-00')";
					$Consulta.= " OR (fecha_benef BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'))";
					$Beneficio = "S";
				}
				else
				{
					$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
					$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
					$Beneficio = "N";
				}
			}
			else
			{
				//Consulto el peso total por el flujo
				$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
				$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
				$Consulta.= " AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
				$Beneficio = "N";
			}			
			$Resp4 = mysqli_query($link, $Consulta);
			$Fila4 = mysqli_fetch_array($Resp4);
			
			//Consulto el en stock_piso_raf
			$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.stock_piso_raf";
			$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
			$Consulta.= " AND fecha BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
			$Resp5 = mysqli_query($link, $Consulta);
			$Fila5 = mysqli_fetch_array($Resp5);			
			
			//Consulto el en stock_piso_raf, del mes pasado.
			$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.stock_piso_raf";
			$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
			$Consulta.= " AND fecha BETWEEN SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)";
			$Consulta.= " AND SUBDATE('".$Fecha_Ter."', INTERVAL 1 MONTH)";
	
			$Resp6 = mysqli_query($link, $Consulta);
			$Fila6 = mysqli_fetch_array($Resp6);
			


			//Graba el Registro
			$Insertar = "INSERT INTO sea_web.stock_anexo (ano,mes,flujo,peso)";
			$Insertar.= " VALUES ('".$Ano."'";
			$Insertar.= ",'".$Mes."'";
			$Insertar.= ",'".$Fila["cod_flujo"]."'";
			$Insertar.= ",'".($Fila4["peso"] - $Fila5["peso"] + $Fila6["peso"])."')";
			mysqli_query($link, $Insertar);	
			//echo $Fila["cod_flujo"]." P4=".$Fila4["peso"]." P5=".$Fila5["peso"]." P6=".$Fila6["peso"]." - ".$Insertar."<br>";
			$Codigos = array('02'=>0,'04'=>0,'05'=>0);
			//Calcula los finos
			if ($Beneficio == "S")
			{
				$Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.hornada,";
				$Consulta.= " IFNULL(t4.peso,0) AS peso_raf, sum(t1.peso) AS peso_hornada";
				$Consulta.= " FROM sea_web.movimientos AS t1";
				$Consulta.= " LEFT JOIN sea_web.stock_piso_raf AS t4";
				$Consulta.= " ON t1.cod_producto = t4.cod_producto AND t1.cod_subproducto = t4.cod_subproducto";
				$Consulta.= " AND t1.hornada = t4.hornada AND t1.flujo = t4.flujo";
				$Consulta.= " AND t4.fecha BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
				$Consulta.= " WHERE t1.flujo = '".$Fila["cod_flujo"]."'";
				$Consulta.= " AND ((t1.fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
				$Consulta.= " AND t1.fecha_benef = '0000-00-00')";
				$Consulta.= " OR (t1.fecha_benef BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'))";
				$Consulta.= " GROUP BY t1.hornada";
			}
			else
			{
				$Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.hornada,";
				$Consulta.= " IFNULL(t4.peso,0) AS peso_raf, sum(t1.peso) AS peso_hornada";
				$Consulta.= " FROM sea_web.movimientos AS t1";
				$Consulta.= " LEFT JOIN sea_web.stock_piso_raf AS t4";
				$Consulta.= " ON t1.cod_producto = t4.cod_producto AND t1.cod_subproducto = t4.cod_subproducto";
				$Consulta.= " AND t1.hornada = t4.hornada AND t1.flujo = t4.flujo";
				$Consulta.= " AND t4.fecha BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
				$Consulta.= " WHERE t1.flujo = '".$Fila["cod_flujo"]."'";
				$Consulta.= " AND t1.fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
				$Consulta.= " GROUP BY t1.hornada";
			}			
			$Resp7 = mysqli_query($link, $Consulta);
			while ($Fila7 = mysqli_fetch_array($Resp7))		
			{
				//STOCK PISO RAF
				$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso_piso FROM sea_web.stock_piso_raf";
				$Consulta.= " where cod_producto='".$Fila7["cod_producto"]."' ";
				$Consulta.= " and cod_subproducto='".$Fila7["cod_subproducto"]."' ";
				$Consulta.= " and hornada='".$Fila7["hornada"]."'";
				$Consulta.= " AND fecha BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
				$RespPiso = mysqli_query($link, $Consulta);
				$FilaPiso = mysqli_fetch_array($RespPiso);
				$PesoPiso = $FilaPiso["peso_piso"];

				$Consulta = "SELECT * from sea_web.leyes_por_hornada ";
				$Consulta.= " where cod_producto='".$Fila7["cod_producto"]."' ";
				$Consulta.= " and cod_subproducto='".$Fila7["cod_subproducto"]."' ";
				$Consulta.= " and hornada='".$Fila7["hornada"]."'";
				$Consulta.= " and cod_leyes in('02','04','05')";
				$RespLeyes = mysqli_query($link, $Consulta);
				while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
				{
					$Codigos[$FilaLeyes["cod_leyes"]] = $Codigos[$FilaLeyes["cod_leyes"]] + (($Fila7["peso_hornada"] - $PesoPiso) * $FilaLeyes["valor"] / $Unidades[$FilaLeyes["cod_leyes"]]);					
				}
				$PesoPiso = 0;
			}
						
			$Consulta = "SELECT * FROM sea_web.stock_piso_raf";
			$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
			$Consulta.= " AND fecha BETWEEN SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)";
			$Consulta.= " AND SUBDATE('".$Fecha_Ter."', INTERVAL 1 MONTH)";
			$Resp8 = mysqli_query($link, $Consulta);
			while ($Fila8 = mysqli_fetch_array($Resp8))
			{
				$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.stock_piso_raf";
				$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
				$Consulta.= " AND fecha BETWEEN '".$Fecha_Ini."'";
				$Consulta.= " AND '".$Fecha_Ter."'";
				$Consulta.= " AND cod_producto = '".$Fila8["cod_producto"]."'";
				$Consulta.= " AND cod_subproducto = '".$Fila8["cod_subproducto"]."'";
				$Consulta.= " AND hornada = '".$Fila8["hornada"]."'";
				$Resp9 = mysqli_query($link, $Consulta);
		
				$Consulta = "SELECT cod_leyes, valor FROM sea_web.leyes_por_hornada";
				$Consulta.= " WHERE cod_producto = '".$Fila8["cod_producto"]."'";
				$Consulta.= " AND cod_subproducto = '".$Fila8["cod_subproducto"]."'";
				$Consulta.= " AND hornada = '".$Fila8["hornada"]."'";
				$Consulta.= " AND cod_leyes IN ('02','04','05')";
				$Resp10 = mysqli_query($link, $Consulta);
		
				if ($Fils8["peso"] == $Fila9["peso"])
				{
					while ($Fila10 = mysqli_fetch_array($Resp10))
					{
						$Codigos[$Fila10["cod_leyes"]] = $Codigos[$Fila10["cod_leyes"]] + ($Fila8["peso"] * $Fila10["valor"] / $Unidades[$Fila10["cod_leyes"]]);
					}
				}
				else
				{
					while ($Fila10 = mysqli_fetch_array($Resp10))
					{
						$Codigos[$Fila10["cod_leyes"]] = $Codigos[$Fila10["cod_leyes"]] + (($Fila8["peso"] - $Fila9["peso"]) * $Fila10["valor"] / $Unidades[$Fila10["cod_leyes"]]);
					}
				}		
			}					   			
			//Actualiza el Registro por el Flujo
			$Actualizar = "UPDATE sea_web.stock_anexo SET fino_cu = '".str_replace(",",".",$Codigos["02"])."'";
			$Actualizar.= ", fino_ag = '".str_replace(",",".",$Codigos["04"])."'";
			$Actualizar.= ", fino_au = '".str_replace(",",".",$Codigos["05"])."'";
			$Actualizar.= " WHERE mes = '".$Mes."' AND ano = '".$Ano."'";
			$Actualizar.= " AND flujo = '".$Fila["cod_flujo"]."'";
			mysqli_query($link, $Actualizar);			
		}
		//******************************* NODOS *********************************************			
		//Totales Por Nodo
		$mes_aux = $Mes - 1;
		$ano_aux = $Ano;
		
		if ($mes_aux == 0)
		{
			$mes_aux = 12;
			$ano_aux = $Ano - 1;
		}
		
		
		//Elimino las existencia de los nodos
		$Eliminar = "DELETE FROM sea_web.existencia_nodo";
		$Eliminar.= " WHERE  ano = '".$Ano."' AND mes = '".$Mes."'";
		mysqli_query($link, $Eliminar);
		$Copiar = "S";		
			
		$Consulta = "SELECT DISTINCT t1.nodo FROM proyecto_modernizacion.flujos t1";
		$Consulta.= " inner join proyecto_modernizacion.nodos t2 on t1.nodo=t2.cod_nodo";
		$Consulta.= " WHERE t1.sistema = 'SEA' and t2.virtual<>'S' ORDER BY nodo";
		$Resp1 = mysqli_query($link, $Consulta);			
		while ($Fila1 = mysqli_fetch_array($Resp1))
		{
			$Nodo = $Fila1["nodo"];
			$Cont = 0;
			$acumular_cu = 0;
			$acumular_ag = 0;
			$acumular_au = 0;
			$Peso_2 = 0;
			$Peso_3 = 0;
			$Peso_4 = 0;	
			//Existencias del Mes Pasado
			if ($Mes == 1)
				$AnoAnterior = $Ano - 1;
			else
				$AnoAnterior = $Ano;						
				
			$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso, IFNULL(SUM(fino_cu),0) AS fino_cu, IFNULL(SUM(fino_ag),0) AS fino_ag, IFNULL(SUM(fino_au),0) AS fino_au";
			$Consulta.= " FROM sea_web.existencia_nodo";
			$Consulta.= " WHERE nodo = '".$Fila1["nodo"]."'";
			$Consulta.= " AND ano = '".$AnoAnterior."' AND mes = MONTH(SUBDATE('".$Ano."-".$Mes."-01', INTERVAL 1 MONTH))";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				if ($Fila2["peso"] > 0)
				{
					$Peso_2 = $Fila3["peso"];
					$acumular_cu = ($Fila2["fino_cu"] / $Fila2["peso"]) * $Unidades["02"];
					$acumular_ag = ($Fila2["fino_ag"] / $Fila2["peso"]) * $Unidades["04"];
					$acumular_au = ($Fila2["fino_au"] / $Fila2["peso"]) * $Unidades["05"];
					$Cont = Cont + 1;
				}
			}
				
			//Entradas.
			$Consulta = "SELECT SUM(peso) AS peso, SUM(fino_cu) AS fino_cu, SUM(fino_ag) AS fino_ag, SUM(fino_au) AS fino_au ";
			$Consulta.= " FROM sea_web.stock_anexo AS t1 ";
			$Consulta.= " INNER JOIN proyecto_modernizacion.flujos AS t2 ";
			$Consulta.= " ON t1.flujo = t2.cod_flujo ";
			$Consulta.= " WHERE mes = '".$Mes."' ";
			$Consulta.= " AND ano = '".$Ano."' ";
			$Consulta.= " AND t2.nodo = '".$Fila1["nodo"]."' ";
			$Consulta.= " AND tipo = 'E'";
			$Resp3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Resp3))
			{
				if ($Fila3["peso"] > 0)
				{
					$Peso_3 = $Fila3["peso"];
					$acumular_cu = $acumular_cu + $Fila3["fino_cu"] / $Fila3["peso"] * $Unidades["02"];
					$acumular_ag = $acumular_ag + $Fila3["fino_ag"] / $Fila3["peso"] * $Unidades["04"];
					$acumular_au = $acumular_au + $Fila3["fino_au"] / $Fila3["peso"] * $Unidades["05"];
					$Cont = Cont + 1;
				}
			}
			
			//Salidas.
			$Consulta = "SELECT SUM(peso) AS peso, SUM(fino_cu) AS fino_cu, SUM(fino_ag) AS fino_ag, SUM(fino_au) AS fino_au";
			$Consulta.= " FROM sea_web.stock_anexo AS t1";
			$Consulta.= " INNER JOIN proyecto_modernizacion.flujos AS t2";
			$Consulta.= " ON t1.flujo = t2.cod_flujo";
			$Consulta.= " WHERE mes = '".$Mes."'";
			$Consulta.= " AND ano = '".$Ano."'";
			$Consulta.= " AND t2.nodo = '".$Fila1["nodo"]."' AND tipo = 'S'";			
			$Resp4 = mysqli_query($link, $Consulta);
			if ($Fila4 = mysqli_fetch_array($Resp4))
			{
				if ($Fila4["peso"] > 0)
				{
					$Peso_4 = $Fila3["peso"];
					$acumular_cu = $acumular_cu + $Fila4["fino_cu"] / $Fila4["peso"] * $Unidades["02"];
					$acumular_ag = $acumular_ag + $Fila4["fino_ag"] / $Fila4["peso"] * $Unidades["04"];
					$acumular_au = $acumular_au + $Fila4["fino_au"] / $Fila4["peso"] * $Unidades["05"];
					$Cont++;
				}
			}
			$Peso = ($Fila2["peso"] + $Fila3["peso"] - $Fila4["peso"]);			
			$Fino_Cu = ($Fila2["fino_cu"] + $Fila3["fino_cu"] - $Fila4["fino_cu"]);
			$Fino_Ag = ($Fila2["fino_ag"] + $Fila3["fino_ag"] - $Fila4["fino_ag"]);
			$Fino_Au = ($Fila2["fino_au"] + $Fila3["fino_au"] - $Fila4["fino_au"]);
			
			
			//Verificar Ley
			if ($Peso < 10000 && $Peso > 0)
			{
				$Fino_Cu = ($acumular_cu / $Cont) * $Peso / $Unidades["02"];
				$Fino_Ag = ($acumular_ag / $Cont) * $Peso / $Unidades["04"];
				$Fino_Au = ($acumular_au / $Cont) * $Peso / $Unidades["05"];
			}
								
			if ($Copiar == "S")
			{
				$Insertar = "INSERT INTO sea_web.existencia_nodo (ano,mes,nodo,peso,fino_cu,fino_ag,fino_au)";
				$Insertar.= " VALUES ('".$Ano."',";
				$Insertar.= "'".$Mes."',";
				$Insertar.= "'".$Nodo."',";
				$Insertar.= "'".$Peso."',";
				$Insertar.= "'".$Fino_Cu."',";
				$Insertar.= "'".$Fino_Ag."',";
				$Insertar.= "'".$Fino_Au."')";
				mysqli_query($link, $Insertar);				
			}		
		}	
	}
}
?>
<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frm1;
	switch (opt)
	{
		case "AM":
			var Pag = "../principal/abrir_mes_anexo.php?Sistema=SEA&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			window.open(Pag,"","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
			break;
		case "CM":
			var msg = confirm("¿Esta seguro que desea guardar esta version del Anexo.SEA?");
			if (msg)
			{
				f.action = "sea_con_anexo01.php?Proceso=G&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
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
			f.action = "sea_con_anexo_excel.php?Mostrar=S&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			f.submit(); 
			break;
		case "C":
			f.action = "sea_con_anexo.php?Mostrar=S";
			f.submit(); 
			break;
	}	
}

function Detalle(flu)
{
	var f = frm1;		
	window.open("sea_con_anexo_det_flujo.php?Flujo=" + flu + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function DetalleNodo(nodo)
{
	var f = frm1;		
	window.open("sea_con_anexo_det_nodo.php?Nodo=" + nodo + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top">
	  
<table width="650" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr align="center">
    <td height="23" colspan="4" class="ColorTabla02"><strong>ANEXO DEL SISTEMA DE ANODOS </strong></td>
  </tr>
  <tr>
    <td width="91" height="23">Mes Anexo</td>
    <td width="163">
      <SELECT name="Mes">
        <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (!isset($Mes))
				{
					if ($i == date("n"))
						echo "<option SELECTed value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";
				}
				else
				{
					if ($i == $Mes)
						echo "<option SELECTed value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";						
				}				
			}		  
		?>
      </SELECT>
      <SELECT name="Ano" size="1">
        <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (!isset($Ano))
				{
					if ($i == date("Y"))
						echo "<option SELECTed value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";
				}
				else
				{
					if ($i == $Ano)
						echo "<option SELECTed value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";						
				}				
			}		
		?>
      </SELECT>
    </td>
    <td width="198"  align="right">Cierre Parcial:</td>
  <td width="163">
<?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "SELECT estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='2' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1' and fecha_cierre = (";
	$Consulta.= " SELECT max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='2' ";
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
    <td height="23" align="center">&nbsp;</td>
  <td height="23" align="center">&nbsp;</td>
    <td height="23" align="right">Cierre General:</td>
  <td height="23"><?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "SELECT estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='2' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2' and fecha_cierre = (";
	$Consulta.= " SELECT max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='2' ";
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
	$Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM sea_web.existencia_nodo ";
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
	<table width="650" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Flujo</td>
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
	$Consulta = "SELECT t1.flujo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au  ";
	$Consulta.= " FROM sea_web.stock_anexo t1 inner join proyecto_modernizacion.flujos t2 ";
	$Consulta.= " on t1.flujo = t2.cod_flujo ";
	$Consulta.= " WHERE t1.ano = ".$Ano." AND t1.mes = ".$Mes;
	$Consulta.= " and t2.sistema = 'SEA'";
	$Consulta.= " and t2.esflujo <> 'N'";
	$Consulta.= " ORDER BY flujo";	
	$Resp = mysqli_query($link, $Consulta);	
	while ($row = mysqli_fetch_array($Resp))
	{			
		if ($row["peso"] != 0)
		{
			echo '<tr>';
			echo '<td align="center">'.$row["flujo"].'</td>';
			echo '<td align="left"><a href="JavaScript:Detalle('.$row["flujo"].')">'.strtoupper($row["descripcion"]).'</a></td>';
			echo '<td align="right">'.number_format($row["peso"],0,',','.').'</td>';
			echo '<td align="right">'.number_format(($row[fino_cu] / $row["peso"] * 100),2,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_ag"] / $row["peso"] * 1000),2,',','.').'</td>';
			echo '<td align="right">'.number_format(($row[fino_au] / $row["peso"] * 1000),2,',','.').'</td>';	
			echo '<td align="right">'.number_format($row[fino_cu],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_ag"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row[fino_au],0,',','.').'</td>';										
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
	$Consulta.= " FROM sea_web.existencia_nodo t1 inner join proyecto_modernizacion.nodos t2 ";
	$Consulta.= " on t1.nodo = t2.cod_nodo";
	$Consulta.= " WHERE t1.ano = ".$Ano." AND t1.mes = ".$Mes;
	$Consulta.= " and t2.sistema = 'SEA' ";
	$Consulta.= " and t2.virtual<>'S' ";
	$Consulta.= " ORDER BY nodo";			
	$Resp = mysqli_query($link, $Consulta);			
	while ($row = mysqli_fetch_array($Resp))
	{			
		if ($row["peso"] != 0)
		{
			echo '<tr>';
			echo '<td align="center">'.$row[nodo].'</td>';
			echo '<td align="left"><a href="JavaScript:DetalleNodo('.$row[nodo].')">'.strtoupper($row["descripcion"]).'</a></td>';
			echo '<td align="right">'.number_format($row["peso"],0,',','.').'</td>';
			echo '<td align="right">'.number_format(($row[fino_cu] / $row["peso"] * 100),2,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_ag"] / $row["peso"] * 1000),2,',','.').'</td>';
			echo '<td align="right">'.round(($row[fino_au] / $row["peso"] * 1000),2).'</td>';	
			echo '<td align="right">'.number_format($row[fino_cu],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_ag"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row[fino_au],0,',','.').'</td>';												
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