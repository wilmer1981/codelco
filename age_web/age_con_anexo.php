<?php
	$CodigoDeSistema = 16;
	$CodigoDePantalla = 6;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");

	if(isset($_REQUEST["Mostrar"])){
		$Mostrar = $_REQUEST["Mostrar"];
	}else{
		$Mostrar = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}

	if ($Mostrar == "S")
	{	
		$Consulta = "SELECT * FROM age_web.flujos_mes ";
		$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."'";
		$Consulta.= " AND bloqueado = '1'";
		$Resp2 = mysqli_query($link, $Consulta);
		if (!$Fila2 = mysqli_fetch_array($Resp2))
		{
			//LIMPIA TABLAS FLUJOS_MES Y EXISTENCIA NODO
			$Eliminar = "DELETE FROM age_web.flujos_mes where ano='".$Ano."' and mes='".$Mes."'";
			mysqli_query($link, $Eliminar);
			$Consulta = "SELECT DISTINCT t1.cod_producto, t1.cod_subproducto, ";
			$Consulta.= "case when ISNULL(t2.flujo) then ";
			$Consulta.= "case WHEN length(t3.flujo)=1 THEN concat('00',t3.flujo) else case WHEN length(t3.flujo)=2 then CONCAT('0',t3.flujo) ELSE t3.flujo end end else ";
			$Consulta.= "case WHEN length(t2.flujo)=1 THEN concat('00',t2.flujo) else case WHEN length(t2.flujo)=2 then CONCAT('0',t2.flujo) ELSE t2.flujo end end end as flujo, ";
			$Consulta.= "sum(peso_humedo) as peso_humedo, ";
			$Consulta.= "sum(peso_seco) as peso_seco, sum(fino_cu) as fino_cu, sum(fino_ag) as fino_ag, SUM(fino_au) as fino_au ";
			$Consulta.= "from age_web.recepciones t1 left join age_web.recpromin t2 on t1.cod_producto = t2.cod_producto ";
			$Consulta.= "and t1.cod_subproducto=t2.cod_subproducto and TRIM(t1.rut_proveedor)=trim(t2.rut_proveedor) ";
			$Consulta.= "left join age_web.recpromin t3 on t1.cod_producto = t3.cod_producto ";
			$Consulta.= "and t1.cod_subproducto=t3.cod_subproducto and SUBSTRING(t3.rut_proveedor,1,8)='99999999' ";
			$Consulta.= "where mes='".$Mes."' and ano='".$Ano."' ";
			$Consulta.= "group by flujo ";
			$Consulta.= "order by flujo ";
			//echo $Consulta."<br>";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{			
				if ($Fila["flujo"]!="" && !is_null($Fila["flujo"]))
				{
					$Insertar = "insert into age_web.flujos_mes(ano, mes, flujo, peso, fino_cu, fino_ag, fino_au)";
					$Insertar.= " values('".$Ano."','".$Mes."','".$Fila["flujo"]."','".$Fila["peso_seco"]."','".$Fila["fino_cu"]."','".$Fila["fino_ag"]."','".$Fila["fino_au"]."')";
					mysqli_query($link, $Insertar);
					//echo $Insertar."<br>";
				}
			}
		}//FIN RECORSET
		
	}//FIN MOSTRAR = "S"
	//ELIMINA LOS DATOS DE AGENCIA QUE HABIAN PREVIAMENTE EN EL RAM
		$Eliminar = "delete from ram_web.leyes_agencia where ano='".$Ano."' and mes='".str_pad($Mes,2,"0",STR_PAD_LEFT)."' ";
		mysqli_query($link, $Eliminar);
		//echo $Eliminar;
		//CARGA LEYES DE AGENCIA A SISTEMA RAM EN TABLA LEYES_AGENCIA
		$Consulta = "SELECT t1.flujo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au  ";
		$Consulta.= " FROM age_web.flujos_mes t1 LEFT join proyecto_modernizacion.flujos t2 ";
		$Consulta.= " on t1.flujo = t2.cod_flujo and t2.sistema = 'AGE'";
		$Consulta.= " WHERE t1.ano = ".$Ano." AND t1.mes = ".$Mes;
		$Consulta.= " ORDER BY flujo";	
		$Resp = mysqli_query($link, $Consulta);	
		//echo $Consulta."<br>";
		while ($row = mysqli_fetch_array($Resp))
		{			
			$Flujo = $row["flujo"];
			$Consulta = "select cod_producto, cod_subproducto, rut_proveedor ";
			$Consulta.= " from age_web.relaciones where flujo='".$Flujo."' order by lpad(rut_proveedor,10,'0')";
			$RespFlujo=mysqli_query($link, $Consulta);
			while ($FilaFlujo=mysqli_fetch_array($RespFlujo))
			{
				$FinoCu=0;
				$FinoAg=0;
				$FinoAu=0;
				$PesoSecoProv=0;
				$TipoRecep="";
				$RutProv=$FilaFlujo["rut_proveedor"];
				$Prod=$FilaFlujo["cod_producto"];
				$SubProd=$FilaFlujo["cod_subproducto"];
				$ArrDatosProv=array();
				$ArrLeyesProv=array();
				$ArrLeyesProv["01"][0]="01";
				$ArrLeyesProv["02"][0]="02";
				$ArrLeyesProv["04"][0]="04";
				$ArrLeyesProv["05"][0]="05";
				LeyesProveedor($TipoRecep,$RutProv,$Prod,$SubProd,$ArrDatosProv,$ArrLeyesProv,"N","S","S",$FechaIni,$FechaFin,"",$link);		
				$PesoHumProv = $ArrDatosProv["peso_humedo"];
				$PesoSecoProv = $ArrDatosProv["peso_seco3"];
				if ($PesoSecoProv>0)
				{
					reset($ArrLeyesProv);
					//while (list($k,$v)=each($ArrLeyesProv))
					foreach ($ArrLeyesProv as $k => $v)
					{			
						if ($PesoSecoProv>0 && $v[2]>0 && $v[5]>0) 
						{
							switch ($v[0])
							{
								case "02":
									$FinoCu = (($PesoSecoProv * $v[2])/$v[5]);//VALOR
									break;
								case "04":
									$FinoAg = (($PesoSecoProv * $v[2])/$v[5]);//VALOR
									break;
								case "05":
									$FinoAu = (($PesoSecoProv * $v[2])/$v[5]);//VALOR
									break;
							}				
						}
					}
					//reset($ArrLeyesLote);								
					$Insertar = "INSERT INTO ram_web.leyes_agencia(ano, mes,  vended, trecep, ph, pseco, fin_cu, fin_ag, fin_au) ";
					$Insertar.= " VALUES('".$Ano."', '".str_pad($Mes,2,"0",STR_PAD_LEFT)."', '".$RutProv."', '".str_pad($SubProd,2,"0",STR_PAD_LEFT)."',";
					$Insertar.= " '".$PesoHumProv."', '".$PesoSecoProv."', '".$FinoCu."', '".$FinoAg."' , '".$FinoAu."')";
					//echo $Insertar;
					mysqli_query($link, $Insertar);
					//LIMPIA ARREGLO
					do {			 
						$k = key ($ArrLeyesProv);			
						$ArrLeyesProv[$k][2] = "";
					} while (next($ArrLeyesProv));					
				}				
			}//FIN SACA DATOS DEL PROVEEDOR
		}//FIN CARGA LEYES A RAM
	
	
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "AM":
			var Pag = "../principal/abrir_mes_anexo.php?Sistema=AGE&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			window.open(Pag,"","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
			break;
		case "CM":
			var msg = confirm("�Esta seguro que desea guardar esta version del Anexo.AGE?");
			if (msg)
			{
				f.action = "age_con_anexo01.php?Proceso=G&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
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
			f.action = "age_con_anexo_excel.php?Mostrar=S&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			f.submit(); 
			break;
		case "C":
			f.action = "age_con_anexo.php?Mostrar=S";
			f.submit(); 
			break;
	}	
}
function Detalle(flu)
{
	var f = frmPrincipal;		
	window.open("age_anexo_det_flujo.php?Flujo=" + flu + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script></head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="650" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="4" class="ColorTabla02"><strong>ANEXO DE AGENCIA </strong></td>
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
          <td width="183">
            <?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='15' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='15' ";
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
	$Consulta.= " where cod_sistema='15' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='15' ";
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
	$Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM age_web.flujos_mes ";
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
      </table>        <br>
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
	$Consulta.= " FROM age_web.flujos_mes t1 LEFT join proyecto_modernizacion.flujos t2 ";
	$Consulta.= " on t1.flujo = t2.cod_flujo and t2.sistema = 'AGE'";
	$Consulta.= " WHERE t1.ano = ".$Ano." AND t1.mes = ".$Mes;
	$Consulta.= " ORDER BY flujo";	
	$Resp = mysqli_query($link, $Consulta);	
	while ($row = mysqli_fetch_array($Resp))
	{			
		/*if ($row["peso"] != 0)
		{*/
			echo '<tr>';
			echo '<td align="center">'.$row["flujo"].'</td>';
			$Consulta = "select * from proyecto_modernizacion.flujos where sistema='RAM' and cod_flujo='".$row["flujo"]."' ";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))								
				echo '<td align="left"><a href="JavaScript:Detalle('.$row["flujo"].')">'.strtoupper($Fila2["descripcion"]).'</a></td>';
			else
				echo '<td align="center">&nbsp;</td>';			
			echo '<td align="right">'.number_format($row["peso"],0,',','.').'</td>';
			if ($row["fino_cu"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_cu"] / $row["peso"] * 100),2,',','.').'</td>';
			else
				echo '<td align="right">0</td>';
			if ($row[fino_ag]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row[fino_ag] / $row["peso"] * 1000),2,',','.').'</td>';		
			else
				echo '<td align="right">0</td>';
			if ($row[fino_au]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row[fino_au] / $row["peso"] * 1000),2,',','.').'</td>';	
			else
				echo '<td align="right">0</td>';
			echo '<td align="right">'.number_format($row["fino_cu"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row[fino_ag],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row[fino_au],0,',','.').'</td>';										
			echo '</tr>';
		//}
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
