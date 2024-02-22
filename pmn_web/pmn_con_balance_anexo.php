<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 141;
	include("../principal/conectar_pmn_web.php");
	include("pmn_con_balance_calcula_flujo.php");	
	//include("pmn_con_balance_calcula_nodo.php");	 (NO SE CALCULAN POR QUE TOMA LOS QUE INGRESA EL USUARIO ENCARGASO)
?>
<html>
<head>
<title>Sistema de PLAMEN</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "AM":
			var Pag = "../principal/abrir_mes_anexo.php?Sistema=PMN&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			window.open(Pag,"","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
			break;
		case "CM":
			var msg = confirm("�Esta seguro que desea guardar esta version del Anexo.PMN?");
			if (msg)
			{
				f.action = "pmn_con_balance_anexo01.php?Proceso=G&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=144";
			f.submit();
			break;
		case "I":
			window.print();
			break;
		case "E":
			f.action = "pmn_con_balance_anexo_excel.php?Proceso=S&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			f.submit(); 
			break;
		case "C":
			f.action = "pmn_con_balance_anexo.php?Mostrar=S&Proceso=S";
			f.submit(); 
			break;
	}	
}
/**************/
function Detalle(Nodo,Ano,Mes)
{
	var f = frmPrincipal;
	var linea = "Nodo=" + Nodo + "&Ano=" + Ano + "&Mes=" + Mes;
	
	window.open("pmn_con_balance_detalle_nodo.php?" + linea ,"" ,"top=50,left=10,width=790,height=450,scrollbars=yes,resizable = no");
}

</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top">
<table width="650" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr align="center">
    <td height="23" colspan="4" class="ColorTabla02"><strong>ANEXO DE PLANTA DE METALES NOBLES </strong></td>
  </tr>
  <tr>
    <td width="92" height="23">Mes Anexo</td>
    <td width="166">
      <select name="Mes" id="Mes">
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
      <select name="Ano" size="1" id="Ano">
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
    <td align="right">Cierre Parcial:</td>
    <td width="183"><?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='6' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='6' ";
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
    <td height="23" align="right">Cierre General:</td>
    <td height="23"><?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='6' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='6' ";
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
    <td height="23" colspan="4"><input name="BtnConsultar" type="button" id="BtnConsultar" style="width:70px;" onClick="Proceso('C')" value="Consultar">
        <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
        <?php
	if ($Mostrar == "S")
	{		
        echo "<input name='BtnExcel' type='button' style='width:70px;' onClick=\"Proceso('E')\" value='Excel'>\n";
	}
	//Consulto si las existencias del mes estab bloqueadas
	$Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM pmn_web.existencia_nodo ";
	$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND bloqueado = '1'";    
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Respuesta);
	if ($Fila["valor"] == "0")
	{		
        echo "<input name='BrnCerrar' type='button' value='Cierre Parcial'  onClick=\"Proceso('CM')\">";
	}
	else
	{
		if ($CierreBalance == false)
			echo "<input name='BrnAbrir' type='button' value='Abrir Cierre Parcial'  onClick=\"Proceso('AM')\">";
	}
?>
        <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
  </tr>
</table>
<br>
  <table width="650" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Flujo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="2" align="center">Leyes</td>
      <td colspan="2" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Ag</td>
      <td align="center">Au</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
    </tr>
    <?php
if ($Proceso == "S")  
{	
	//Consulto si las existencias del mes se pueden borrar.
	$Copiar = "N";
    $Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM pmn_web.existencia_nodo ";
    $Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' and bloqueado = '1'";    
	//echo $Consulta."<br>";
   	$Respuesta = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Respuesta);
	if ($Fila["valor"] == "0")
	{	
		$Eliminar = "DELETE FROM pmn_web.flujos_mes";
		$Eliminar.= " WHERE  ano = '".$Ano."' AND mes = '".$Mes."'";
		mysqli_query($link, $Eliminar);
		/*$Eliminar = "DELETE FROM pmn_web.existencia_nodo";
		$Eliminar.= " WHERE  ano = '".$Ano."' AND mes = '".$Mes."'";
		mysqli_query($link, $Eliminar);*/
		$Copiar = "S";
		
		//CALCULA FLUJOS.
		CalculaFlujos($Ano,$Mes);
		//CALCULA NODOS (NO SE CALCULAN POR QUE TOMA LOS QUE INGRESA EL USUARIO ENCARGASO)
		//CalculaNodos($Ano,$Mes);
	}	
	
	$consulta = "SELECT t1.flujo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au";
	$consulta.= " FROM pmn_web.flujos_mes AS t1";
	$consulta.= " INNER JOIN proyecto_modernizacion.flujos t2";
	$consulta.= " ON t1.flujo = t2.cod_flujo AND t2.sistema = 'PMN'";
	$consulta.= " WHERE t1.ano = '".$Ano."' AND t1.mes = '".$Mes."'";
	$consulta.= " AND peso != 0 and t2.esflujo<>'N'";
	$consulta.= " GROUP BY t1.flujo";
	$consulta.= " ORDER BY CEILING(t2.cod_flujo)";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{	
		echo '<tr>';
		echo '<td align="center">'.$row["flujo"].'</td>';
		echo '<td align="left">'.$row["descripcion"].'</td>';
		echo '<td align="right">'.number_format($row["peso"],3,",",".").'</td>';
		if ($row["peso"] != 0)
		{
			echo '<td align="right">'.number_format(($row[fino_ag] / $row["peso"] * 1000),2,",","").'</td>';
			echo '<td align="right">'.number_format(($row[fino_au] / $row["peso"] * 1000),2,",","").'</td>';
		}
		else
		{
			echo '<td align="center">&nbsp;</td>';
			echo '<td align="center">&nbsp;</td>';		
		}
		
		echo '<td align="right">'.number_format($row[fino_ag],3,",",".").'</td>';								
		echo '<td align="right">'.number_format($row[fino_au],3,",",".").'</td>';								
		echo '</tr>';
	}
}

?>
    <tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Nodo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="2" align="center">Leyes</td>
      <td colspan="2" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Ag</td>
      <td align="center">Au</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
    </tr>
    <?php
	//RESCATO ANEXO 
	$consulta = "SELECT t1.nodo, SUM(t1.peso) AS peso, SUM(t1.fino_ag) AS fino_ag, SUM(t1.fino_au) AS fino_au, t2.descripcion ";
	$consulta.= " FROM pmn_web.existencia_nodo AS t1";
	$consulta.= " INNER JOIN proyecto_modernizacion.nodos AS t2 ";
	$consulta.= " ON t1.nodo = t2.cod_nodo AND t2.sistema = 'PMN'";
	$consulta.= " WHERE t1.ano = '".$Ano."' AND t1.mes = '".$Mes."'";
	$consulta.= " GROUP BY t1.nodo";
	$consulta.= " ORDER BY t1.nodo";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))	
	{
		echo '<tr>';
		echo '<td align="center">'.$row["nodo"].'</td>';
		echo '<td align="left"><a href="JavaScript:Detalle('.$row["nodo"].','.$Ano.','.$Mes.')">'.$row["descripcion"].'</a></td>';
		echo '<td align="right">'.number_format($row["peso"],3,",",".").'</td>';
		if ($row["peso"] != 0)
		{
			echo '<td align="right">'.number_format(($row[fino_ag] / $row["peso"] * 1000),2,",","").'</td>';
			echo '<td align="right">'.number_format(($row[fino_au] / $row["peso"] * 1000),2,",","").'</td>';
		}
		else
		{
			echo '<td align="center">&nbsp;</td>';
			echo '<td align="center">&nbsp;</td>';		
		}
		
		echo '<td align="right">'.number_format($row[fino_ag],3,",",".").'</td>';								
		echo '<td align="right">'.number_format($row[fino_au],3,",",".").'</td>';								
		echo '</tr>';	
	}
?>
  </table>
  <br>
  <br>
  <table width="566" border="1" align="center" cellpadding="2" cellspacing="0">
<tr align="center" class="ColorTabla01"> 
      <td colspan="5">NODOS CON DIFERENCIAS METALURGICAS</td>
    </tr>
    <tr align="center" class="ColorTabla01"> 
      <td width="39" rowspan="2">Nodo</td>
      <td width="266" rowspan="2">Descripcion</td>
      <td width="92" rowspan="2">Peso</td>
      <td colspan="2">Fino</td>
    </tr>
    <tr align="center" class="ColorTabla01"> 
      <td width="72">Ag</td>
      <td width="65">Au</td>
    </tr>
    <?php
	$consulta = "SELECT t1.nodo, t2.descripcion ";
	$consulta.= " FROM pmn_web.existencia_nodo AS t1";
	$consulta.= " INNER JOIN proyecto_modernizacion.nodos AS t2 ";
	$consulta.= " ON t1.nodo = t2.cod_nodo AND t2.sistema = 'PMN'";
	$consulta.= " WHERE t1.ano = '".$Ano."' AND t1.mes = '".$Mes."' and t2.virtual<>'S'";
	$consulta.= " GROUP BY t1.nodo";
	$consulta.= " ORDER BY t1.nodo";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		$vector = explode('~', CalculaDifMetalurgicas($row["nodo"], $Mes, $Ano)); 
		if ($vector[0] == 'S')
		{
			echo '<tr>';
			echo '<td align="center">'.$row["nodo"].'</td>';
			echo '<td align="left">'.$row["descripcion"].'</td>';
			echo '<td align="right">'.number_format($vector[1],3,",",".").'</td>';
			echo '<td align="right">'.number_format($vector[2],3,",",".").'</td>';
			echo '<td align="right">'.number_format($vector[3],3,",",".").'</td>';
			echo '</tr>';
		}
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
