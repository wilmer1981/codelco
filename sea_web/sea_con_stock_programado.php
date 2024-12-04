<?php
	include("../principal/conectar_principal.php");
    //$link = mysql_connect('10.56.11.7','adm_bd','672312');
    //mysql_select_db("sea_web",$link);
	$CodigoDeSistema=2;
	$CodigoDePantalla=50;
	
	$Dia    = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
	$Mes    = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano    = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	
function CalculaPesoReal($PesoAux, $AnoAux, $MesAux, $DiaAux,$link)
{
	$Fecha = $AnoAux."-".$MesAux."-".$DiaAux;
	$FechaIni = date("Y-m-d",mktime(7,59,59,$MesAux,($DiaAux - 1),$AnoAux));	//Fecha para recepciones
	$Fecha_Ini = $AnoAux."-".$MesAux."-01";
	$Fecha_Ter = $AnoAux."-".$MesAux."-".$DiaAux;
	$Consulta = "SELECT MAX(fecha) as fecha FROM sea_web.inf_rechazos WHERE fecha <= '".$Fecha_Ter."'";
	$res = mysqli_query($link,$Consulta);
	$fil = mysqli_fetch_array($res);
	$Fecha_B = $fil["fecha"]; 
	$Consulta = "SELECT * FROM sea_web.inf_rechazos WHERE fecha = '".$Fecha_B."'";
	$rs = mysqli_query($link,$Consulta);				
	if($row = mysqli_fetch_array($rs))
	{
		$AcumFisi  = 0;
		$AcumQuim  = 0;
		$AcumCalaf = 0;
		$AcumAna   = 0;	
		$AcumFinal3= 0;              
		$AcumAprob = 0;			  
		$AcumTotal = 0;	
		
		$Consulta = "SELECT distinct cod_subproducto FROM sea_web.movimientos WHERE cod_producto = 17 ";
		//$Consulta = $Consulta." AND fecha_movimiento BETWEEN '$Fecha_Ini' AND '$Fecha_Ter'";
		$resp = mysqli_query($link,$Consulta);
		while($Fila = mysqli_fetch_array($resp))
		{	
			$ExFinal3 = 0;
			$AcumIni3 = 0;
			$AcumRecep3 = 0;
			$AcumNave3 = 0;
			$AcumRaf3 = 0;
			$AcumDest3 = 0;
			$AcumRech3 = 0;
			$Total = 0;			  

			//STOCK INICIAL
			$Consulta = "SELECT cod_producto, cod_subproducto, ifnull(sum(unid_fin),0) as unidades, ifnull(sum(peso_fin),0) as peso ";
			$Consulta.= " FROM sea_web.stock ";
			$Consulta.= " WHERE cod_producto = 17";
			$Consulta.= " AND cod_subproducto = '".$Fila["cod_subproducto"]."'";
			$Consulta.= " AND ano = YEAR(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH))";
			$Consulta.= " GROUP BY cod_producto, cod_subproducto";			
			$rs2 = mysqli_query($link,$Consulta);
			$Fil2 = mysqli_fetch_array($rs2);
			$peso = isset($Fil2["peso"])?$Fil2["peso"]:0;
			$AcumIni3 = $AcumIni3 + $peso;	
			  		  
			//Recep 	
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17 ";
			$Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento = 1";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
			$rs3 = mysqli_query($link,$Consulta);
			$Fil3 = mysqli_fetch_array($rs3);						
			$AcumRecep3 = $AcumRecep3 + $Fil3["peso"];
			
			//Nave	
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17 ";
			$Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento = 2";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
			$rs4 = mysqli_query($link,$Consulta);
			$Fil4 = mysqli_fetch_array($rs4);						
			$AcumNave3 = $AcumNave3 + $Fil4["peso"];

			//Trasp Raf
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17";
			$Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento = 4";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
			$rs5 = mysqli_query($link,$Consulta);
			$Fil5 = mysqli_fetch_array($rs5);						
			$AcumRaf3 = $AcumRaf3 + $Fil5["peso"];
			
			//Otros Destinos
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17";
			$Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento IN (5,9)";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
			$rs6 = mysqli_query($link,$Consulta);
			$Fil6 = mysqli_fetch_array($rs6);						
			$AcumDest3 = $AcumDest3 + $Fil6["peso"];

			if($Fila["cod_subproducto"] == 4)
			{
				$Consulta = "SELECT Fis_Vent,Quim_Vent,Calaf_Vent,Ana_Vent FROM sea_web.inf_rechazos WHERE Fecha = '".$Fecha_B."'";
				$res = mysqli_query($link,$Consulta);
				$row = mysqli_fetch_array($res);
				if($row["Fis_Vent"] != '')
					$peso_fisico = $row["Fis_Vent"]*1000;
				if($row["Quim_Vent"] != '')
					$peso_quimico = $row["Quim_Vent"]*1000;
				if($row["Calaf_Vent"] != '')
					$peso_calafateo = $row["Calaf_Vent"]*1000;
				if($row["Ana_Vent"] != '')
					$peso_analisis = $row["Ana_Vent"]*1000;
			}	
			if($Fila["cod_subproducto"] == 8)
			{
				$Consulta = "SELECT Fis_HMadres,Quim_HMadres,Calaf_HMadres,Ana_HMadres FROM sea_web.inf_rechazos WHERE fecha = '".$Fecha_B."'";
				$res = mysqli_query($link,$Consulta);
				$row = mysqli_fetch_array($res);
				if($row["Fis_HMadres"] != '')
					$peso_fisico = $row["Fis_HMadres"]*1000;
				if($row["Quim_HMadres"] != '')
					$peso_quimico = $row["Quim_HMadres"]*1000;
				if($row["Calaf_HMadres"] != '')
					$peso_calafateo = $row["Calaf_HMadres"]*1000;
				if($row["Ana_HMadres"] != '')
					$peso_analisis = $row["Ana_HMadres"]*1000;
			}	
			if($Fila["cod_subproducto"] == 1)
			{
				$Consulta = "SELECT Fis_FHVL,Quim_FHVL,Calaf_FHVL,Ana_FHVL FROM sea_web.inf_rechazos WHERE fecha = '".$Fecha_B."'";
				$res = mysqli_query($link,$Consulta);
				$row = mysqli_fetch_array($res);
				if($row["Fis_FHVL"] != '')
					$peso_fisico = $row["Fis_FHVL"]*1000;
				if($row["Quim_FHVL"] != '')
					$peso_quimico = $row["Quim_FHVL"]*1000;
				if($row["Calaf_FHVL"] != '')
					$peso_calafateo = $row["Calaf_FHVL"]*1000;
				if($row["Ana_FHVL"] != '')
					$peso_analisis = $row["Ana_FHVL"]*1000;
			}	
			if($Fila["cod_subproducto"] == 2)
			{
				$Consulta = "SELECT Fis_Teniente,Quim_Teniente,Calaf_Teniente,Ana_Teniente FROM sea_web.inf_rechazos WHERE fecha = '".$Fecha_B."'";
				$res = mysqli_query($link,$Consulta);
				$row = mysqli_fetch_array($res);
				if($row["Fis_Teniente"] != '')
					$peso_fisico = $row["Fis_Teniente"]*1000;
				if($row["Quim_Teniente"] != '')
					$peso_quimico = $row["Quim_Teniente"]*1000;
				if($row["Calaf_Teniente"] != '')
					$peso_calafateo = $row["Calaf_Teniente"]*1000;
				if($row["Ana_Teniente"] != '')
					$peso_analisis = $row["Ana_Teniente"]*1000;
			}	
			if($Fila["cod_subproducto"] == 3)
			{
				$Consulta = "SELECT Fis_Disputada,Quim_Disputada,Calaf_Disputada,Ana_Disputada FROM sea_web.inf_rechazos WHERE fecha = '".$Fecha_B."'";
				$res = mysqli_query($link,$Consulta);
				$row = mysqli_fetch_array($res);
				if($row["Fis_Disputada"] != '')
					$peso_fisico = $row["Fis_Disputada"]*1000;;
				if($row["Quim_Disputada"] != '')
					$peso_quimico = $row["Quim_Disputada"]*1000;
				if($row["Calaf_Disputada"] != '')
					$peso_calafateo = $row["Calaf_Disputada"]*1000;
				if($row["Ana_Disputada"] != '')
					$peso_analisis = $row["Ana_Disputada"]*1000;
			}				
			$AcumFisi  = $AcumFisi + $peso_fisico;
			$AcumQuim  = $AcumQuim + $peso_quimico;
			$AcumCalaf = $AcumCalaf + $peso_calafateo;
			$AcumAna   = $AcumAna + $peso_analisis;
									  
			$ExFinal3 = $AcumIni3 + $AcumRecep3 - $AcumNave3 - $AcumRaf3 - $AcumDest3;			
			$AcumFinal3 = $AcumFinal3 + $ExFinal3;              
			$Aprobados = $ExFinal3 - $peso_fisico - $peso_calafateo - $peso_quimico - $peso_analisis;
			$AcumAprob = $AcumAprob + $Aprobados;
			$Total = $peso_fisico + $peso_calafateo + $peso_quimico + $peso_analisis;					  
			$AcumTotal = $AcumTotal + $Total;			  		  
			//$ExFinal3 = 0;			
		}
	
	}
	else
	{				
		$Consulta = "SELECT distinct cod_subproducto FROM sea_web.movimientos WHERE cod_producto = 17 ";
		$Consulta.= " AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
		$resp = mysqli_query($link,$Consulta);
		while($Fila = mysqli_fetch_array($resp))
		{
			$ExFinal3   = 0;
			$AcumIni3   = 0;
			$AcumRecep3 = 0;
			$AcumNave3  = 0;
			$AcumRaf3   = 0;
			$AcumRech3  = 0;
			$AcumDest3  = 0;
			$total = 0;	 

			//STOCK INICIAL
			$Consulta = "SELECT cod_producto, cod_subproducto, ifnull(sum(unid_fin),0) as unidades, ifnull(sum(peso_fin),0) as peso ";
			$Consulta.= " FROM sea_web.stock ";
			$Consulta.= " WHERE cod_producto = 17";
			$Consulta.= " AND cod_subproducto = '".$Fila["cod_subproducto"]."'";
			$Consulta.= " AND ano = YEAR(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH))";
			$Consulta.= " GROUP BY cod_producto, cod_subproducto";
			$rs2 = mysqli_query($link,$Consulta);
			$Fil2 = mysqli_fetch_array($rs2);
			$AcumIni3 = $AcumIni3 + $Fil2["peso"];			  
			//Recep 	
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17 ";
			$Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento = 1";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
			$rs3 = mysqli_query($link,$Consulta);
			$Fil3 = mysqli_fetch_array($rs3);						
			$AcumRecep3 = $AcumRecep3 + $Fil3["peso"];
			//Nave	
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17 ";
			$Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento = 2";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
			$rs4 = mysqli_query($link,$Consulta);
			$Fil4 = mysqli_fetch_array($rs4);						
			$AcumNave3 = $AcumNave3 + $Fil4["peso"];
			
			//Trasp Raf
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17";
			$Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento = 4";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
			$rs5 = mysqli_query($link,$Consulta);
			$Fil5 = mysqli_fetch_array($rs5);						
			$AcumRaf3 = $AcumRaf3 + $Fil5["peso"];
			
			//Otros Destinos
			$Consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos WHERE cod_producto = 17";
			$Consulta = $Consulta." AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND tipo_movimiento IN (5,9)";	
			$Consulta = $Consulta." AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
			$rs6 = mysqli_query($link,$Consulta);
			$Fil6 = mysqli_fetch_array($rs6);						
			$AcumDest3 = $AcumDest3 + $Fil6["peso"];

			$Consulta = "SELECT sum(recuperables) as calaf FROM sea_web.rechazos";
			$Consulta.= " WHERE cod_producto=17 AND cod_subproducto='".$Fila["cod_subproducto"]."'"; 
			$Consulta.= " AND cod_tipo=6 AND cod_defecto<>0"; 
			$Consulta.= " AND cod_defecto=15"; 
			$Consulta.= " AND fecha_ini >= '".$Fecha_Ini."' AND fecha_ter <= '".$Fecha_Ter."'";
			$res = mysqli_query($link,$Consulta);
			if($row = mysqli_fetch_array($res))
			{
				$Consulta = "SELECT (peso_unidades/unidades) as prom from sea_web.hornadas";
				$Consulta.= " WHERE cod_producto=17";
				$Consulta.= " AND cod_subproducto='".$Fila["cod_subproducto"]."' group by hornada_ventana";
				$res = mysqli_query($link,$Consulta);				   
				$fila = mysqli_fetch_array($res);
				$prom       = $fila["prom"];
				$peso_calaf = $row["calaf"] * $prom;	
			}
			$AcumCalaf = $AcumCalaf + $peso_calaf;

			//Fisico	
			$Consulta = "SELECT sum(rechazados) as rech FROM sea_web.rechazos";
			$Consulta.= " WHERE cod_producto=17 AND cod_subproducto='".$Fila["cod_subproducto"]."'"; 
			$Consulta.= " AND cod_tipo=6 AND cod_defecto<>0"; 
			$Consulta.= " AND cod_defecto <> 15"; 
			$Consulta.= " AND fecha_ini >= '".$Fecha_Ini."' AND fecha_ter <= '".$Fecha_Ter."'";
			$res = mysqli_query($link,$Consulta);
			if($row = mysqli_fetch_array($res))
			{
				$Consulta = "SELECT (peso_unidades/unidades) as prom from sea_web.hornadas";
				$Consulta.= " WHERE cod_producto=17";
				$Consulta.= " AND cod_subproducto='".$Fila["cod_subproducto"]."' group by hornada_ventana";
				$res = mysqli_query($Consulta);				   
				$fila = mysqli_fetch_array($res);
				$prom        = $fila["prom"];
				$peso_fisico = $row["rech"] * $prom;	
			}
			$AcumFisi = $AcumFisi + $peso_fisico;
			
			//Quimico	
			$Consulta = "SELECT sum(peso) as peso, hornada FROM sea_web.movimientos WHERE cod_producto = 17";
			$Consulta.= " AND tipo_movimiento = 1 AND cod_subproducto = '".$Fila["cod_subproducto"]."' ";
			$Consulta.= " AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
			$Consulta.= " GROUP BY hornada";
			$rs = mysqli_query($link,$Consulta);
			$peso_quimico = 0;
			while($row = mysqli_fetch_array($rs))
			{
				$Consulta = "SELECT valor from sea_web.leyes_por_hornada where cod_producto = 17";
				$Consulta.= " AND cod_subproducto = '".$Fila["cod_subproducto"]."' AND hornada = '".$row["hornada"]."'";
				$Consulta.= " AND cod_unidad = 2 AND cod_leyes = '09'";					  
				$result = mysqli_query($link,$Consulta);
				$fila = mysqli_fetch_array($result);	
				if($fila["valor"] > 400)
				{
					$peso_quimico = $peso_quimico + $row["peso"];	
				}
	
			}
			$AcumQuim = $AcumQuim + $peso_quimico;
											  
			$ExFinal3 = $AcumIni3 + $AcumRecep3 - $AcumNave3 - $AcumRaf3 - $AcumDest3;
			$AcumFinal3 = $AcumFinal3 + $ExFinal3;              
			$Aprobados = $ExFinal3 - $peso_fisico - $peso_calaf;
			$AcumAprob = $AcumAprob + $Aprobados;
			
			$total = $peso_calaf + $peso_fisico + $peso_quimico;
			$AcumTotal = $AcumTotal + $total;		
			//echo $DiaAux."=".$ExFinal3."<br>";	    
			$ExFinal3 = 0;			
			  
		}				
	}	
	$PesoAux = $AcumAprob;
	//$PesoAux = $AcumFinal3;	
}//FIN FUNCION
?>
<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript">
function TeclaPulsada(salto) 
{ 
	var f = document.frmPrincipal;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}

function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action = "sea_con_stock_programado.php";
			f.submit();
			break;		
		case "S":
			history.back();
			break;
		case "I":
			window.print();
			break;
		case "X":
			f.action = "sea_con_stock_programado_excel.php";
			f.submit();
			break;
	}
}
</script>
<style type="text/css">
<!--
.Estilo1 {
	color: #000066;
	font-weight: bold;
}
.Estilo2 {color: #000066}
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      	<td width="762" height="312" align="center" valign="top"><table width="682" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td width="77" height="23">Fecha </td>
            <td width="194">
              <select name="Mes" size="1" id="select7">
                <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (isset($Mes))
				{
					if ($i == $Mes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]."</option>";					
					else	
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
				}
				else
				{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]."</option>";					
					else	
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
				}					
			}		  
		?>
              </select>
              <select name="Ano" size="1">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($Ano))
				{
					if ($i == $Ano)
						echo "<option selected value ='".$i."'>".$i."</option>";					
					else	
						echo "<option value='".$i."'>".$i."</option>";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option selected value ='".$i."'>".$i."</option>";					
					else	
						echo "<option value='".$i."'>".$i."</option>";
				}				
			}
		?>
              </select>
            </td>
            <td width="390"><input name="BtnConsultar" type="button" id="BtnConsultar" style="width:70px " onClick="Proceso('C')" value="Consultar">
              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px " onClick="Proceso('I')" value="Imprimir">
              <input name="BtnExcel" type="button" id="BtnGrabar4" onClick="Proceso('X')" value="Excel" style="width:70px ">
            <input name="BtnSalir" type="button" id="BtnSalir" onClick="Proceso('S')" value="Salir" style="width:70px "></td>
          </tr>
        </table>
		
		  <br>
		 <table width="405" border="1" cellpadding="2" cellspacing="0" class="TablaDetalle" align="center">
                <tr align="center" class="ColorTabla01">
                  <td width="36" rowspan="2">Dia</td>
                  <td colspan="2">STOCK</td>
                  <td width="65" rowspan="2">Diferencia</td>
                  <td colspan="2"></td>
                </tr>
                <tr align="center" class="ColorTabla01">
                  <td width="72">Programado </td>
                  <td width="56">Real</td>
                  <td width="90"></td>
                </tr>
                <?php	
	$Fecha01 = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
	$FinMes = date("d", mktime(0,0,0,substr($Fecha01,5,2),intval(substr($Fecha01,8,2))-1,substr($Fecha01,0,4)));	
	for ($i=1;$i<=$FinMes;$i++)
	{	
		//PESO PROGRAMADO
		$Consulta = "select * from sea_web.stock_programado ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$i."'";
		$Resp = mysqli_query($link,$Consulta);
		$PesoProgramado=0;
		$Alerta = "ALERTA";
		if ($Fila = mysqli_fetch_array($Resp))
		{
			if ($Fila["peso"]>0)
				$PesoProgramado=$Fila["peso"]; //toneladas
			else
				$PesoProgramado=0;
		}	
		$TotalProgramado =0;$TotalReal=0;$TotalDiferencia=0;
		if ($Mes!=date("n") || ($Mes == date("n") && $i<=date("j")))
		{
			//PESO REAL
			$PesoReal=0;
			CalculaPesoReal($PesoReal,$Ano,$Mes,$i,$link);
			if ($PesoReal>0)
				$PesoReal=($PesoReal/1000);
			else
				$PesoReal=0;
			//DIFERENCIA
			$PesoDiferencia = $PesoReal - $PesoProgramado;
			$TotalProgramado = $TotalProgramado + $PesoProgramado;	
			$TotalReal = $TotalReal + $PesoReal;		
			$TotalDiferencia = $TotalDiferencia + $PesoDiferencia;
			echo "<tr align='center'>\n";  
			echo "<td class='ColorTabla02'>".str_pad($i,2,"0",STR_PAD_LEFT)."</td>\n";
			echo "<td bgcolor='#FFFFFF'>".number_format($PesoProgramado,0,",",".")."</td>\n";		
			echo "<td bgcolor='#FFFFFF'>".number_format($PesoReal,0,",",".")."</td>\n";
			echo "<td bgcolor='#FFFFFF'>".number_format($PesoDiferencia,0,",",".")."</td>\n";
			if ($PesoReal <=2500)
			{
				echo "<td bgcolor='#FF0000'>".$Alerta."</td>\n";
			}	
			/*else
			{
		
				echo "<td bgcolor='#FFFFFF'>".number_format($PesoDiferencia,0,",",".")."</td>\n";
			}*/

			/*echo "<td>".number_format($TotalProgramado,0,",",".")."</td>\n";		
			echo "<td>".number_format($TotalReal,0,",",".")."</td>\n";
			echo "<td>".number_format($TotalDiferencia,0,",",".")."</td>\n";*/
		}
		else
		{
			$TotalProgramado = $TotalProgramado + $PesoProgramado;	
			echo "<tr align='center'>\n";  
			echo "<td class='ColorTabla02'>".str_pad($i,2,"0",STR_PAD_LEFT)."</td>\n";
			echo "<td bgcolor='#FFFFFF'>".number_format($PesoProgramado,0,",",".")."</td>\n";		
			echo "<td bgcolor='#FFFFFF'>0</td>\n";
			if ($PesoProgramado>0)
				$PesoProgramado = $PesoProgramado*-1;
			echo "<td bgcolor='#FFFFFF'>".number_format($PesoProgramado,0,",",".")."</td>\n";
			/*echo "<td>".number_format($TotalProgramado,0,",",".")."</td>\n";		
			echo "<td>".number_format($TotalReal,0,",",".")."</td>\n";
			echo "<td>".number_format($TotalDiferencia,0,",",".")."</td>\n";*/
		}
		echo "</tr>\n";			
	}
?>
                <tr bgcolor="#FFFFFF" >
                  <td><span class="Estilo1">TOTAL</span></td>
                  <td align="center"><span class="Estilo2"><? echo number_format($TotalProgramado,0,",","."); ?></span></td>
                  <td align="center"><span class="Estilo2"><? echo number_format($TotalReal,0,",","."); ?></span></td>
                  <td align="center"><span class="Estilo2"><? echo number_format($TotalDiferencia,0,",","."); ?></span></td>
                </tr>
          </table>
	    <br>
	    </td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
