<?php
	include("../principal/conectar_principal.php");
	include("sec_anexo_sec_funciones.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../Principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style>
<!--
#postit{
position:absolute;
width:330;
padding:5px;
background-color:#339999;
border:1px solid black;
visibility:hidden;
z-index:500;
cursor:hand;
}
-->
</style>

<script language="JavaScript">
function Guardar()
{
	var f = frmPrincipal;
	var msg = confirm("¿Esta seguro que desea guardar esta version del Anexo.sec?");
	if (msg)
	{
		f.action = "sec_anexo_sec01.php?Proceso=G&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
		f.submit();
	}
	else
	{
		return;
	}
}
function Recarga()
{
	var f = frmPrincipal;
	f.action = "sec_anexo_sec.php?Proceso=S";
	f.submit();
}
function Salir()
{
	var f = frmPrincipal;
	f.action = "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
	f.submit();
}
function Detalle(flu,pag)
{
	var f = frmPrincipal;
	switch (flu)
	{
		case "161":
			pagAux = "sec_con_detalle_ley_comercial.php?Flujo=161&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			break;
		case "160":
			pagAux = "sec_con_detalle_ley_desc_parcial.php?Flujo=160&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			break;
		case "314":
			pagAux = "sec_con_detalle_ley_ew.php?Flujo=314&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			break;
		case "211":
			pagAux = "sec_con_detalle_ley_externos.php?Flujo=211&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			break;
		default:
			pagAux = pag;
			break;
	}	
	window.open(pagAux,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
  <table width="500" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr> 
    <td width="97">Mes Anexo</td>
    <td width="194"><select name="Mes">
	<?php
	for ($i = 1;$i <= 12;$i++)
	{
		if (isset($Mes))
		{
			if ($Mes == $i)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else	
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
		else
		{
			if (date("n") == $i)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else	
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
	}
?>	 
      </select> <select name="Ano">
<?php
	for ($i = date("Y")-1;$i <= date("Y");$i++)
	{
		if (isset($Ano))
		{
			if ($Ano == $i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if (date("Y") == $i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	
				echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
?>	  
      </select>
      <input name="BtnOK" type="button" id="BtnOK" value="OK" onClick="Recarga();"> </td>
    <td width="195"><input name="BrnGuardar" type="button" id="BrnGuardar2" value="Guardar" style="width:70px;" onClick="Guardar();">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px;" onClick="Salir();"></td>
  </tr>
</table>
<br>
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
if ($Proceso == "S")  
{	
	//Consulto si las existencias del mes se pueden borrar.
	$Copiar = "N";
    $Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM sec_web.existencia_nodo ";
    $Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' and bloqueado = '1'";    
   	$Respuesta = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Respuesta);
	if ($Fila["valor"] == "0")
	{
		//Elimino las existencia de los Nodos y Flujos
		$Eliminar = "DELETE FROM sec_web.existencia_nodo";
		$Eliminar.= " WHERE  ano = '".$Ano."' AND mes = '".$Mes."'";
		mysqli_query($link, $Eliminar);
		$Eliminar = "DELETE FROM sec_web.flujos_mes";
		$Eliminar.= " WHERE  ano = '".$Ano."' AND mes = '".$Mes."'";
		mysqli_query($link, $Eliminar);
		$Copiar = "S";
	}
	//$Copiar = "S";
	if ($Copiar == "S")
	{
		//RESCATA LEYES
		RescataLeyes($Ano, $Mes);
		//-------------
		$FechaInicio = $Ano."-".$Mes."-01";
		$FechaTermino = $Ano."-".$Mes."-31";
		$Consulta = "select distinct cod_flujo, descripcion from proyecto_modernizacion.flujos ";
		$Consulta.= " where sistema = 'SEC' order by cod_flujo";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Consulta = "select * from sec_web.relacion_flujo ";
			$Consulta.= " where flujo = '".$Fila["cod_flujo"]."'";
			$Resp2 = mysqli_query($link, $Consulta);
			$Peso = 0;
			$Fino_Cu = 0;
			$Fino_Ag = 0;
			$Fino_Au = 0;
			$Finos = "";
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$TipoMovimiento = $Fila2["tipo_mov"];
				RescataPeso($Fila2["tipo_mov"],$Fila2["cod_producto"],$Fila2["cod_subproducto"],$Fila["cod_flujo"],$FechaInicio,$FechaTermino,&$PesoAux,&$Fino_Cu,&$Fino_Ag,&$Fino_Au);
				$Peso = $Peso + $PesoAux;
			}			
			
			echo "<tr> \n";
			echo "<td align='center'>".$Fila["cod_flujo"]."</td>\n";
			echo "<td><a href=\"JavaScript:Detalle('".$Fila["cod_flujo"]."','sec_con_detalle_flujo.php?TipoMov=".$TipoMovimiento."&Flujo=".$Fila["cod_flujo"]."&Ano=".$Ano."&Mes=".$Mes."')\">";
			echo strtoupper($Fila["descripcion"])."</a></td>\n";		
			echo "<td align='right'>".number_format($Peso,0,",",".")."</td>\n";
			if ($Fino_Cu > 0 && $Peso > 0)
			{					
				echo "<td align='right'>".substr(number_format(($Fino_Cu/$Peso),4,",","."),0,5)."</td>\n";
				$Fino_Cu = $Fino_Cu / 100;
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Cu = 0;
			}
			if ($Fino_Ag > 0 && $Peso > 0)					
			{
				echo "<td align='right'>".number_format(($Fino_Ag/$Peso),2,",",".")."</td>\n";
				$Fino_Ag = $Fino_Ag / 1000;
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Ag = 0;
			}
			if ($Fino_Au > 0 && $Peso > 0)					
			{
				echo "<td align='right'>".number_format(($Fino_Au/$Peso),2,",",".")."</td>\n";
				$Fino_Au = $Fino_Au / 1000;
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Au = 0;
			}
			echo "<td align='right'>".number_format($Fino_Cu,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Ag,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Au,0,",",".")."</td>\n";
			echo "</tr>\n";
			//INSERTO EN TABLA FLUJO MES
			$Insertar = "INSERT INTO sec_web.flujos_mes ";
			$Insertar.= " (ano, mes, flujo, peso, fino_cu, fino_ag, fino_au) ";
			$Insertar.= " VALUES ('".$Ano."', '".$Mes."', '".$Fila["cod_flujo"]."', ";
			$Insertar.= "'".$Peso."', '".$Fino_Cu."', '".$Fino_Ag."', '".$Fino_Au."')";			
			mysqli_query($link, $Insertar);
		}
	}
	else
	{
		//RESCATO LO YA GENERADO EN EL ANEXO
		$Consulta = "select t1.flujo, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au, t2.descripcion ";
		$Consulta.= " from sec_web.flujos_mes t1 inner join proyecto_modernizacion.flujos t2 ";
		$Consulta.= " on t1.flujo = t2.cod_flujo ";
		$Consulta.= " where t1.ano = '".$Ano."'";
		$Consulta.= " and t1.mes = '".$Mes."'";
		$Consulta.= " and t2.sistema = 'SEC'";
		$Consulta.= " order by t1.flujo";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Peso = $Fila["peso"];
			$Fino_Cu = $Fila["fino_cu"];
			$Fino_Ag = $Fila["fino_ag"];
			$Fino_Au = $Fila["fino_au"];
			echo "<tr> \n";
			echo "<td align='center'>".$Fila["flujo"]."</td>\n";
			echo "<td>".strtoupper($Fila["descripcion"])."</td>\n";		
			echo "<td align='right'>".number_format($Peso,0,",",".")."</td>\n";
			if ($Fino_Cu > 0 && $Peso > 0)
			{					
				echo "<td align='right'>".substr(number_format((($Fino_Cu/$Peso)*100),4,",","."),0,5)."</td>\n";
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Cu = 0;
			}
			if ($Fino_Ag > 0 && $Peso > 0)					
			{
				echo "<td align='right'>".number_format((($Fino_Ag/$Peso)*1000),2,",",".")."</td>\n";
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Ag = 0;
			}
			if ($Fino_Au > 0 && $Peso > 0)					
			{
				echo "<td align='right'>".number_format((($Fino_Au/$Peso)*1000),2,",",".")."</td>\n";
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Au = 0;
			}
			echo "<td align='right'>".number_format($Fino_Cu,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Ag,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Au,0,",",".")."</td>\n";
			echo "</tr>\n";
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
if ($Proceso == "S")  
{	
	 if ($Copiar == "S")
	{
		$Unidades = array(2=>100,4=>1000,5=>1000);
		$Consulta = "SELECT DISTINCT nodo FROM proyecto_modernizacion.flujos";
		$Consulta.= " WHERE sistema = 'SEC' ORDER BY nodo";
		$Respuesta = mysqli_query($link, $Consulta);            
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Constante = "3";
			$Nodo = $Fila["nodo"];
			$Cont = 0;
			$Acum_Cu = 0;
			$Acum_Ag = 0;
			$Acum_Au = 0;
			//Existencias del Mes Pasado
			if ($Mes == 1)
				$AnoAnterior = $Ano - 1;
			else
				$AnoAnterior = $Ano;
			
			$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso, ";
			$Consulta.= " IFNULL(SUM(fino_cu),0) AS fino_cu, ";
			$Consulta.= " IFNULL(SUM(fino_ag),0) AS fino_ag, ";
			$Consulta.= " IFNULL(SUM(fino_au),0) AS fino_au";
			$Consulta.= " FROM sec_web.existencia_nodo";
			$Consulta.= " WHERE nodo = '".$Nodo."'";
			$Consulta.= " AND ano = '".$AnoAnterior."' ";
			$Consulta.= " AND mes = MONTH(SUBDATE('2004-".$Mes."-01', INTERVAL 1 MONTH))";
			$RespAux = mysqli_query($link, $Consulta);
			$Fila2 = mysqli_fetch_array($RespAux);
			if ($Fila2["peso"] > 0)
			{
				if ($Fila2["fino_cu"] > 0 && $Fila2["peso"] > 0)								
					$Acum_Cu = $Fila2["fino_cu"] / ($Fila2["peso"] * $Unidades[2]);					
				if ($Fila2["fino_ag"] > 0 && $Fila2["peso"] > 0)				
					$Acum_Ag = $Fila2["fino_ag"] / ($Fila2["peso"] * $Unidades[4]);
				if ($Fila2["fino_au"] > 0 && $Fila2["peso"] > 0)				
					$Acum_Au = $Fila2["fino_au"] / ($Fila2["peso"] * $Unidades[5]);
				$Cont = $Cont + 1;
			}
				
			//Entradas.
			$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso, ";
			$Consulta.= " IFNULL(SUM(fino_cu),0) AS fino_cu, ";
			$Consulta.= " IFNULL(SUM(fino_ag),0) AS fino_ag, ";
			$Consulta.= " IFNULL(SUM(fino_au),0) AS fino_au";
			$Consulta.= " FROM sec_web.flujos_mes AS t1";
			$Consulta.= " INNER JOIN proyecto_modernizacion.flujos AS t2";
			$Consulta.= " ON t1.flujo = t2.cod_flujo";
			$Consulta.= " WHERE mes = '".$Mes."'";
			$Consulta.= " AND ano = '".$Ano."'";
			$Consulta.= " AND t2.nodo = '".$Nodo."'";
			$Consulta.= " AND tipo = 'E'";			
			$RespAux = mysqli_query($link, $Consulta);
			$Fila3 = mysqli_fetch_array($RespAux);
			if ($Fila3["peso"] > 0)
			{
				if ($Fila3["fino_cu"] > 0 && $Fila3["peso"] > 0)				
					$Acum_Cu = $Acum_Cu + ($Fila3["fino_cu"] / ($Fila3["peso"] * $Unidades[2]));
				if ($Fila3["fino_ag"] > 0 && $Fila3["peso"] > 0)				
					$Acum_Ag = $Acum_Ag + ($Fila3["fino_ag"] / ($Fila3["peso"] * $Unidades[4]));
				if ($Fila3["fino_au"] > 0 && $Fila3["peso"] > 0)				
					$Acum_Au = $Acum_Au + ($Fila3["fino_au"] / ($Fila3["peso"] * $Unidades[5]));
				$Cont = Cont + 1;
			}
			
			//Salidas.
			$PesoOtros = 0;
			$PesoTraspaso = 0;
			if ($Nodo == 82) //DESPUNTES Y LAMINAS
			{
				//RESCATO TODOS LOS TRASPASOS EN SEC_WEB.TRASPASOS
				$Consulta = "SELECT SUM(PESO) as peso_otros FROM sec_web.traspaso  ";
				$Consulta.= " WHERE `fecha_traspaso` BETWEEN '".$FechaInicio."' AND '".$FechaTermino."' ";
				$Consulta.= " AND COD_PRODUCTO=48 ORDER BY fecha_traspaso ASC";
				$RespAux = mysqli_query($link, $Consulta);
				if ($FilaAux = mysqli_fetch_array($RespAux))
				{
					$PesoOtros = $FilaAux["peso_otros"];
				}
				//
				//TABLA MOVIMIENTOS DEL SISTEMA SEA_WEB			
				$Consulta = "select t2.cod_producto, t2.cod_subproducto,sum(t1.peso) as peso_traspaso, ";
				$Consulta.= " year(t2.fecha_creacion_lote) as ano, t2.cod_bulto as serie";
				$Consulta.= " from sea_web.movimientos t1 inner join sec_web.traspaso t2";
				$Consulta.= " on t1.hornada = t2.hornada";
				$Consulta.= "  where t1.cod_producto='48'";
				//$Consulta.= "  and t1.cod_subproducto = '".$SubProducto."' ";
				$Consulta.= " and t1.tipo_movimiento = '4'";
				$Consulta.= "  and t1.fecha_movimiento ";
				$Consulta.= "  between '".$FechaInicio."' and '".$FechaTermino."'";
				$Consulta.= "  group by t1.cod_producto,t1.cod_subproducto, serie"; 
				$RespAux = mysqli_query($link, $Consulta);
				while ($FilaAux = mysqli_fetch_array($RespAux))
				{
					$PesoTraspaso = $FilaAux["peso_traspaso"];
					$Consulta = "select * from proyecto_modernizacion.sub_clase ";
					$Consulta.= " where cod_clase=3004 and nombre_subclase = '".$FilaAux["serie"]."'";
					$RespAux2 = mysqli_query($link, $Consulta);
					if ($FilaAux2 = mysqli_fetch_array($RespAux2))
					{
						$MesAux = $FilaAux2["cod_subclase"];
					}
					//TABLA STOC_PISO DEL SISTEMA SEA_WEB
					$Consulta = "select sum(peso) as peso_piso from sea_web.stock_piso_raf ";
					$Consulta.= " where fecha between '".$FechaInicio."' and '".$FechaTermino."'";
					$Consulta.= " and cod_producto = '48'";
					//$Consulta.= " and cod_subproducto = '".$SubProducto."'";
					$Consulta.= " group by cod_producto, cod_subproducto";
					$RespAux2 = mysqli_query($link, $Consulta);
					while ($FilaAux2 = mysqli_fetch_array($RespAux2))
					{
						$PesoTraspaso = $PesoTraspaso - $FilaAux2["peso_piso"];
					}					
				}		
			}
			$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso, ";
			$Consulta.= " IFNULL(SUM(fino_cu),0) AS fino_cu, ";
			$Consulta.= " IFNULL(SUM(fino_ag),0) AS fino_ag, ";
			$Consulta.= " IFNULL(SUM(fino_au),0) AS fino_au";
			$Consulta.= " FROM sec_web.flujos_mes AS t1";
			$Consulta.= " INNER JOIN proyecto_modernizacion.flujos AS t2";
			$Consulta.= " ON t1.flujo = t2.cod_flujo";
			$Consulta.= " WHERE mes = '".$Mes."'";
			$Consulta.= " AND ano = '".$Ano."'";
			$Consulta.= " AND t2.nodo = '".$Nodo."' AND tipo = 'S'";
			$RespAux = mysqli_query($link, $Consulta);
			$Fila4 = mysqli_fetch_array($RespAux);
			if ($Fila4["peso"] > 0)
			{
				$PesoSalidas = $Fila4["peso"];// + ($PesoOtros - $PesoTraspaso);
				//echo $Fila4["fino_cu"]." / ".$PesoSalidas;
				if ($Fila4["fino_cu"] > 0 && $PesoSalidas > 0)				
					$Acum_Cu = $Acum_Cu + ($Fila4["fino_cu"] / ($PesoSalidas * $Unidades[2]));
				if ($Fila4["fino_ag"] > 0 && $PesoSalidas > 0)				
					$Acum_Ag = $Acum_Ag + ($Fila4["fino_ag"] / ($PesoSalidas * $Unidades[4]));
				if ($Fila4["fino_au"] > 0 && $PesoSalidas > 0)				
					$Acum_Au = $Acum_Au + ($Fila4["fino_au"] / ($PesoSalidas * $Unidades[5]));
				$Cont = $Cont + 1;
			}
						
			$Peso = ($Fila2["peso"] + $Fila3["peso"]) - $PesoSalidas;
			$Fino_Cu = ($Fila2["fino_cu"] + $Fila3["fino_cu"]) - $Fila4["fino_cu"];
			$Fino_Ag = ($Fila2["fino_ag"] + $Fila3["fino_ag"]) - $Fila4["fino_ag"];
			$Fino_Au = ($Fila2["fino_au"] + $Fila3["fino_au"]) - $Fila4["fino_au"];                           
			
			//INSERTO VALORES EN LA TABLA EXISTENCIA NODO	   
			$Insertar = "INSERT INTO sec_web.existencia_nodo ";
			$Insertar.= " (ano,mes,nodo,peso,fino_cu,fino_ag,fino_au)";
			$Insertar.= " VALUES ('".$Ano."',";
			$Insertar.= "'".$Mes."',";
			$Insertar.= "'".$Nodo."',";
			$Insertar.= "'".$Peso."',";
			$Insertar.= "'".$Fino_Cu."',";
			$Insertar.= "'".$Fino_Ag."',";
			$Insertar.= "'".$Fino_Au."')";
			//echo $Insertar."<br>";
			mysqli_query($link, $Insertar);
			
			$Consulta = "select * from proyecto_modernizacion.nodos ";
			$Consulta.= " where cod_nodo = '".$Nodo."'";
			$Consulta.= " and sistema = 'SEC'";
			$Resp2 = mysqli_query($link, $Consulta);
			$Descripcion = "&nbsp;";
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$Descripcion = $Fila2["descripcion"];
			}
			echo "<tr> \n";
			echo "<td align='center'>".$Nodo."</td>\n";
			echo "<td><a href=\"JavaScript:Detalle('".$Nodo."','sec_con_detalle_nodo.php?Nodo=".$Nodo."&Ano=".$Ano."&Mes=".$Mes."')\">";
			echo $Descripcion."</td>\n";		
			echo "<td align='right'>".number_format($Peso,0,",",".")."</td>\n";		
			if ($Fino_Cu > 0 && $Peso > 0)					
				echo "<td align='right'>".number_format(($Fino_Cu/$Peso)*100,2,",",".")."</td>\n";
			else
				echo "<td align='right'>0</td>\n";
			if ($Fino_Ag > 0 && $Peso > 0)					
				echo "<td align='right'>".number_format(($Fino_Ag/$Peso)*1000,2,",",".")."</td>\n";
			else
				echo "<td align='right'>0</td>\n";
			if ($Fino_Au > 0 && $Peso > 0)					
				echo "<td align='right'>".number_format(($Fino_Au/$Peso)*1000,2,",",".")."</td>\n";
			else
				echo "<td align='right'>0</td>\n";
			echo "<td align='right'>".number_format($Fino_Cu,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Ag,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Au,0,",",".")."</td>\n";
			echo "</tr>\n";
		}
	}
	else
	{
		//RESCATO ANEXO CREADO BLOQUEADO = 1
		$Consulta = "select t1.nodo, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au, t2.descripcion ";
		$Consulta.= " from sec_web.existencia_nodo t1 inner join proyecto_modernizacion.nodos t2 ";
		$Consulta.= " on t1.nodo = t2.cod_nodo ";
		$Consulta.= " where t1.ano = '".$Ano."'";
		$Consulta.= " and t1.mes = '".$Mes."'";
		$Consulta.= " and t2.sistema = 'SEC'";
		$Consulta.= " order by t1.nodo";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Peso = $Fila["peso"];
			$Fino_Cu = $Fila["fino_cu"];
			$Fino_Ag = $Fila["fino_ag"];
			$Fino_Au = $Fila["fino_au"];
			echo "<tr> \n";
			echo "<td align='center'>".$Fila["nodo"]."</td>\n";
			echo "<td>".strtoupper($Fila["descripcion"])."</td>\n";		
			echo "<td align='right'>".number_format($Peso,0,",",".")."</td>\n";
			if ($Fino_Cu > 0 && $Peso > 0)
			{					
				echo "<td align='right'>".substr(number_format((($Fino_Cu/$Peso)*100),4,",","."),0,5)."</td>\n";
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Cu = 0;
			}
			if ($Fino_Ag > 0 && $Peso > 0)					
			{
				echo "<td align='right'>".number_format((($Fino_Ag/$Peso)*1000),2,",",".")."</td>\n";
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Ag = 0;
			}
			if ($Fino_Au > 0 && $Peso > 0)					
			{
				echo "<td align='right'>".number_format((($Fino_Au/$Peso)*1000),2,",",".")."</td>\n";
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Au = 0;
			}
			echo "<td align='right'>".number_format($Fino_Cu,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Ag,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Au,0,",",".")."</td>\n";
			echo "</tr>\n";
		}
	}
}
?>
  </table> 
</form> 
</body>
</html>
