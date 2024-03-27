<?
include("../principal/conectar_raf_web.php");

	/*$Anito = date("Y");
    echo "hornada".$Hornada."<br>";
	echo "anito".$Anito."<br>";*/
	$Consulta = "SELECT * FROM raf_web.movimientos WHERE SUBSTRING(hornada,7) = '".$Hornada."'";
	//$Consulta.=" and left(hornada,4) = '".$Anito."'";
	$rs = mysqli_query($link, $Consulta);
	$row = mysql_fetch_array($rs);	
	$Dia = substr($row[fecha_carga],8,2);
	$Mes = substr($row[fecha_carga],5,2);					  			
	$Ano = substr($row[fecha_carga],0,4);
	$Solera = $row[solera];
	$hornada = $row["hornada"];

    $etapa =array ("nulo","Carga 1","Fusion 1","Carga 2","Fusion 2","Carga 3","Fusion 3","Calenta 1","Escoreo","Calenta 2","Reduccion","Calenta 3","Moldeo","Vac. Sell.");			

	if($hornada == '')
	{	
		echo '<script language="JavaScript">';
		echo 'alert("La Hornada No Existe");';
		echo 'window.history.back()';
		echo '</script>';	
	}
?>
<html>
<head>
<title>Sistema de Refino a Fuego</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opc)
{
	var f = document.FrmPrincipal;
	var valores = '';
	switch(opc)
	{
		case "A1":
		    valores = "?Report=2&Seccion=A1" + "&Hornada=" + f.hornada.value+ "&Fecha=" + f.fecha.value;
			window.open("raf_ing_popup1.php"+valores,"","top=0,left=180,width=400,height=250,scrollbars=yes,resizable = yes");		
			break;

		case "B1":
		    valores = "?Report=2&Seccion=B1" + "&Hornada=" + f.hornada.value+ "&Fecha=" + f.fecha.value;
			window.open("raf_ing_popup1.php"+valores,"","top=0,left=180,width=400,height=250,scrollbars=yes,resizable = yes");		
			break;

		case "B3":
		    valores = "?Report=2&Seccion=B3" + "&Hornada=" + f.hornada.value+ "&Fecha=" + f.fecha.value;
			window.open("raf_ing_popup5.php"+valores,"","top=0,left=180,width=320,height=200,scrollbars=no,resizable = no");		
			break;

		case "C1":
		    valores = "?Report=2&Seccion=C1" + "&Hornada=" + f.hornada.value+ "&Fecha=" + f.fecha.value;
			window.open("raf_ing_popup2.php"+valores,"","top=0,left=180,width=320,height=200,scrollbars=no,resizable = no");		
			break;

		case "C2":
		    valores = "?Report=2&Seccion=C2" + "&Hornada=" + f.hornada.value+ "&Fecha=" + f.fecha.value;
			window.open("raf_ing_popup6.php"+valores,"","top=0,left=180,width=320,height=200,scrollbars=no,resizable = no");		
			break;

		case "C3":
		    valores = "?Report=2&Seccion=C3" + "&Hornada=" + f.hornada.value+ "&Fecha=" + f.fecha.value;
			window.open("raf_ing_popup6.php"+valores,"","top=0,left=180,width=320,height=200,scrollbars=no,resizable = no");		
			break;

		case "D1":
		    valores = "?Report=2&Seccion=D1" + "&Hornada=" + f.hornada.value+ "&Fecha=" + f.fecha.value;
			window.open("raf_ing_popup3.php"+valores,"","top=0,left=180,width=400,height=250,scrollbars=yes,resizable = yes");		
			break;

		case "D2":
		    valores = "?Report=2&Seccion=D2" + "&Hornada=" + f.hornada.value+ "&Fecha=" + f.fecha.value;
			window.open("raf_ing_popup4.php"+valores,"","top=0,left=180,width=610,height=180,scrollbars=no,resizable = no");		
			break;

		case "P":
			f.BtnImprimir.style.visibility = 'hidden';
			f.BtnSalir.style.visibility = 'hidden';
			window.print();
			f.BtnImprimir.style.visibility = '';
			f.BtnSalir.style.visibility = '';
			break;

		case "S":
			f.action = "raf_lista_report.php";
			f.submit();
			break;
	}
	
}	
</script>	

</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="FrmPrincipal" method="post" action="">
  <table width="680" align="center" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr> 
      <td width="337" align="center">Carga Solida Y Consumos</td>
      <td width="163">Hornada : <? echo $Hornada.' - '.$Solera ?>
        <input type="hidden" name="hornada" value="<? echo $hornada;?>"></td>
      <td width="171">Fecha : <? echo $Dia.'-'.$Mes.'-'.$Ano?>
        <input type="hidden" name="fecha" value="<? echo $Ano.'-'.$Mes.'-'.$Dia?>"></td>
    </tr>
  </table>
  <br>
  <table width="900" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr> 
      <td align="center" colspan="5">&nbsp;</td>
      <td width="8" rowspan="12">&nbsp;</td>
      <td align="center" colspan="3">Tiempo Parcial</td>
      <td width="8" rowspan="12">&nbsp;</td>
      <td align="center" colspan="3">Tiempo Acumulado</td>
      <td width="8" rowspan="12">&nbsp;</td>
      <td width="46" align="center">&nbsp;</td>
      <td align="center" colspan="4">Carga Parcial Horno</td>
      <td width="69" align="center" colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td width="56" align="center" class="ColorTabla01">Etapas</td>
      <td width="47" align="center" class="ColorTabla01">Fecha</td>
      <td width="32" align="center" class="ColorTabla01">G/T</td>
      <td width="60" align="center" class="ColorTabla01">Hora Ini.</td>
      <td width="58" align="center" class="ColorTabla01">Hora Final</td>
      <td width="38" align="center" class="ColorTabla01">Real</td>
      <td width="31" align="center" class="ColorTabla01">STD</td>
      <td width="40" align="center" class="ColorTabla01">Dif</td>
      <td width="38" align="center" class="ColorTabla01">Real</td>
      <td width="31" align="center" class="ColorTabla01">Prog</td>
      <td width="40" align="center" class="ColorTabla01">Dif</td>
      <td width="46" align="center" class="ColorTabla01">Restos</td>
      <td width="37" align="center" class="ColorTabla01">Circul.</td>
      <td width="47" align="center" class="ColorTabla01">Circ.Raf </td>
      <td width="24" align="center" class="ColorTabla01">Blist.Liq</td>
      <td width="25" align="center" class="ColorTabla01">Otros</td>
      <td width="69" align="center" class="ColorTabla01">Carga Tot.</td>
      <td width="69" align="center" class="ColorTabla01">STD</td>
    </tr>
    <tr> 
      <td>Carga 1</td>
	  <?
	 // echo "hor".$hornada;
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'A1' AND campo1 = '1' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta); 
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha_ini"],8,2)."-".substr($row["fecha_ini"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 150);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 150);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">3.0</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">3,0</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
	  <? 
		//Restos	
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 1";
		$Consulta.= " AND cod_producto = 19";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumRestos = $AcumRestos + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	  <? 
	  	//Circulante
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 1";
		$Consulta.= " AND cod_producto = 42";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumCirc = $AcumCirc + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>

	  <? 
	  	//Blister Solido
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 1";
		$Consulta.= " AND (cod_producto = 16 OR cod_producto = 17) AND cod_subproducto != 41 AND cod_subproducto != 42";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumBlisSol = $AcumBlisSol + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	  <? 
	  	//Blister Liquido
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 1";
		$Consulta.= " AND cod_producto = 16 AND cod_subproducto IN('41','42')";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumBlisLiq = $AcumBlisLiq + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	  <? 
	  	//Otros
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 1";
		$Consulta.= " AND (cod_producto=18 OR cod_producto='48')";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumOtros = $AcumOtros + $row["peso"];
	  ?>	
	  <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	  <? 
	  	//Total Acum
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 1";
		$Consulta.= " AND cod_producto IN('16','17','18','19','42','48')";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumCargaTot = $AcumCargaTot + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
      <td align="center">210</td>
    </tr>
    <tr> 
      <td>Fusion 1</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'A1' AND campo1 = '2' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha_ini"],8,2)."-".substr($row["fecha_ini"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 150);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 300);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">4,0</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">7,0</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>Carga 2</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'A1' AND campo1 = '3' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta); 
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha_ini"],8,2)."-".substr($row["fecha_ini"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 90);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 390);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">1,0</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">8,0</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
	  <? 
		//Restos	
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 2";
		$Consulta.= " AND cod_producto = 19";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumRestos = $AcumRestos + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	  <? 
	  	//Blister Solido
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 2";
		$Consulta.= " AND (cod_producto = 16 OR cod_producto = 17) AND cod_subproducto != 41 AND cod_subproducto != 42";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumCirc = $AcumCirc + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>

	  <? 
	  	//Circulante
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 2";
		$Consulta.= " AND cod_producto = 42";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumBlisSol = $AcumBlisSol + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	  <? 
	  	//Blister Liquido
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 2";
		$Consulta.= " AND cod_producto = 16 AND cod_subproducto IN('41','42')";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumBlisLiq = $AcumBlisLiq + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	   <? 
	  	//Otros
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 2";
		$Consulta.= " AND (cod_producto=18 OR cod_producto='48')";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumOtros = $AcumOtros + $row["peso"];
	  ?>	
	  <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	  <? 
	  	//Total Acum
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 2";
		$Consulta.= " AND cod_producto IN('16','17','18','19','42','48')";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumCargaTot = $AcumCargaTot + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
      <td align="center">150</td>
    </tr>
    <tr> 
      <td>Fusion 2</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'A1' AND campo1 = '4' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta); 
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha_ini"],8,2)."-".substr($row["fecha_ini"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 180);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 570);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">2,0</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">10,0</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
       <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>Carga 3</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'A1' AND campo1 = '5' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta); 
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha_ini"],8,2)."-".substr($row["fecha_ini"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 90);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 660);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">0,0</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">10,0</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
	  <? 
		//Restos	
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 3";
		$Consulta.= " AND cod_producto = 19";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumRestos = $AcumRestos + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	  <? 
	  	//Blister Solido
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 3";
		$Consulta.= " AND (cod_producto = 16 OR cod_producto = 17) AND cod_subproducto != 41 AND cod_subproducto != 42";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumCirc = $AcumCirc + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>

	  <? 
	  	//Circulante
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 3";
		$Consulta.= " AND cod_producto = 42";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumBlisSol = $AcumBlisSol + $row["peso"];		
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	  <? 
	  	//Blister Liquido
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 3";
		$Consulta.= " AND cod_producto = 16 AND cod_subproducto IN('41','42')";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumBlisLiq = $AcumBlisLiq + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	   <? 
	  	//Otros
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 3";
		$Consulta.= " AND (cod_producto=18 OR cod_producto='48')";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumOtros = $AcumOtros + $row["peso"];
	  ?>	
	  <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	  <? 
	  	//Total Acum
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 3";
		$Consulta.= " AND cod_producto IN('16','17','18','19','42','48')";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumCargaTot = $AcumCargaTot + $row["peso"];
	  ?>	  	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
      <td align="center">80</td>
    </tr>
    <tr> 
      <td>Fusion 3</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'A1' AND campo1 = '6' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta); 
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha_ini"],8,2)."-".substr($row["fecha_ini"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{			
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))
		{
			$real = substr($Fila["dif"],0,5);	  					
		}
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 210);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 870);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">0,0</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">10,0</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td>Carga 4 </td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'A1' AND campo1 = '7' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta); 
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha_ini"],8,2)."-".substr($row["fecha_ini"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 90);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 660);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
     <? 
		//Restos	
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 4";
		$Consulta.= " AND cod_producto = 19";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumRestos = $AcumRestos + $row["peso"];
	  ?>	  
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	   <? 
	  	//Blister Solido
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 4";
		$Consulta.= " AND (cod_producto = 16 OR cod_producto = 17) AND cod_subproducto != 41 AND cod_subproducto != 42";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumCirc = $AcumCirc + $row["peso"];
	  ?>
	    
       <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	   <? 
	  	//Circulante
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 4";
		$Consulta.= " AND cod_producto = 42";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumBlisSol = $AcumBlisSol + $row["peso"];
	  ?>	
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	   <? 
	  	//Blister Liquido
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 4";
		$Consulta.= " AND cod_producto = 16 AND cod_subproducto IN('41','42')";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumBlisLiq = $AcumBlisLiq + $row["peso"];
	  ?>	  
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	    <? 
	  	//Otros
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 4";
		$Consulta.= " AND (cod_producto=18 OR cod_producto='48')";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumOtros = $AcumOtros + $row["peso"];
	  ?>	
	  <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
	   <? 
	  	//Total Acum
	 	$Consulta = "SELECT sum(peso) as peso FROM raf_web.det_carga WHERE hornada = $hornada AND nro_carga = 4";
		$Consulta.= " AND cod_producto IN('16','17','18','19','42','48')";
		$rs = mysqli_query($link, $Consulta); 
		$row = mysql_fetch_array($rs);
		$AcumCargaTot = $AcumCargaTot + $row["peso"];
	  ?>	  
      <td align="center"><? echo $row["peso"] ?>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td>Fusion 4 </td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'A1' AND campo1 = '8' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta); 
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha_ini"],8,2)."-".substr($row["fecha_ini"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 210);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 870);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
      <td colspan="3" align="center">&nbsp;</td>
      <td colspan="3" align="center">&nbsp;</td>
      <td align="center"><? echo $AcumRestos; ?>&nbsp;</td>
      <td align="center"><? echo $AcumCirc; ?>&nbsp;</td>
      <td align="center"><? echo $AcumBlisSol; ?>&nbsp;</td>
      <td align="center"><? echo $AcumBlisLiq; ?>&nbsp;</td>
      <td align="center"><? echo $AcumOtros; ?>&nbsp;</td>
      <td align="center"><? echo $AcumCargaTot; ?>&nbsp;</td>
      <td align="center">440</td>
    </tr>
  </table>
  <? echo $row["peso"] ?>
  <?
  	if($Proceso == "M")
	{
  ?>  
  <table width="900" border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="281" align="center"> <input type="button" name="ok1" value="Ok" style="width:30px" onClick="Proceso('A1');"></td>
      <td align="center">&nbsp;</td>
    </tr>
  </table>
  <? } ?>	
  <br>
  <table width="900" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr> 
      <td align="center" colspan="5">&nbsp;</td>
      <td width="8" rowspan="9">&nbsp;</td>
      <td align="center" colspan="3">Tiempo Parcial</td>
      <td width="8" rowspan="9">&nbsp;</td>
      <td align="center" colspan="3">Tiempo Acum.</td>
      <td width="8" rowspan="9">&nbsp;</td>
      <td width="46" align="center" colspan="6">&nbsp;</td>
    </tr>
    <tr> 
      <td width="56" align="center" class="ColorTabla01">Etapas</td>
      <td width="47" align="center" class="ColorTabla01">Fecha</td>
      <td width="32" align="center" class="ColorTabla01">G/T</td>
      <td width="60" align="center" class="ColorTabla01">Hora Ini.</td>
      <td width="58" align="center" class="ColorTabla01">Hora Final</td>
      <td width="38" align="center" class="ColorTabla01">Real</td>
      <td width="31" align="center" class="ColorTabla01">STD</td>
      <td width="40" align="center" class="ColorTabla01">Dif</td>
      <td width="38" align="center" class="ColorTabla01">Real</td>
      <td width="31" align="center" class="ColorTabla01">Prog</td>
      <td width="40" align="center" class="ColorTabla01">Dif</td>
      <td width="46" align="center" class="ColorTabla01">Troncos</td>
      <td width="36" align="center" class="ColorTabla01">Ollas</td>
      <td width="50" align="center" class="ColorTabla01">Temp 1&deg;</td>
      <td width="52" align="center" class="ColorTabla01">Temp 2&deg;</td>
      <td width="64" align="center" class="ColorTabla01">Oxig. ppm</td>
      <td width="40" align="center" class="ColorTabla01">STD</td>
    </tr>
    <tr> 
      <td>Calenta 1</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B1' AND campo1 = '1' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha"]!="" && !is_null($row["fecha"])){echo substr($row["fecha"],8,2)."-".substr($row["fecha"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 120);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 990);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">2,0</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">12,0</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B3' AND campo1 = '1' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);

	  ?>	
      <td align="center"><? echo $row[campo2]?>&nbsp;</td>
      <td align="center"><? echo $row[campo3]?>&nbsp;</td>
      <td align="center"><? echo $row[campo4]?>&nbsp;</td>
      <td align="center"><? echo $row[campo5]?>&nbsp;</td>
      <td align="center"><? echo $row[campo6]?>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>Escoreo</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B1' AND campo1 = '2' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha"]!="" && !is_null($row["fecha"])){echo substr($row["fecha"],8,2)."-".substr($row["fecha"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 120);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 1110);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">1,5</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">13,5</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B3' AND campo1 = '2' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);

	  ?>	
      <td align="center"><? echo $row[campo2]?>&nbsp;</td>
      <td align="center"><? echo $row[campo3]?>&nbsp;</td>
      <td align="center"><? echo $row[campo4]?>&nbsp;</td>
      <td align="center"><? echo $row[campo5]?>&nbsp;</td>
      <td align="center"><? echo $row[campo6]?>&nbsp;</td>
      <td align="center">8</td>
    </tr>
    <tr> 
      <td>Calenta 2</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B1' AND campo1 = '3' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha"],8,2)."-".substr($row["fecha"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 60);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 1170);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">1,0</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">14,5</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B3' AND campo1 = '3' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);

	  ?>	
      <td align="center"><? echo $row[campo2]?>&nbsp;</td>
      <td align="center"><? echo $row[campo3]?>&nbsp;</td>
      <td align="center"><? echo $row[campo4]?>&nbsp;</td>
      <td align="center"><? echo $row[campo5]?>&nbsp;</td>
      <td align="center"><? echo $row[campo6]?>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>Reduc.</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B1' AND campo1 = '4' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha_ini"],8,2)."-".substr($row["fecha_ini"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 180);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 1350);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">2,5</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">17,0</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B3' AND campo1 = '4' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);

	  ?>	
      <td align="center"><? echo $row[campo2]?>&nbsp;</td>
      <td align="center"><? echo $row[campo3]?>&nbsp;</td>
      <td align="center"><? echo $row[campo4]?>&nbsp;</td>
      <td align="center"><? echo $row[campo5]?>&nbsp;</td>
      <td align="center"><? echo $row[campo6]?>&nbsp;</td>
      <td align="center">7</td>
    </tr>
    <tr> 
      <td>Calenta 3</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B1' AND campo1 = '5' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha_ini"],8,2)."-".substr($row["fecha_ini"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 60);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 1410);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">0,5</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">17,5</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B3' AND campo1 = '5' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);

	  ?>	
      <td align="center"><? echo $row[campo2]?>&nbsp;</td>
      <td align="center"><? echo $row[campo3]?>&nbsp;</td>
      <td align="center"><? echo $row[campo4]?>&nbsp;</td>
      <td align="center"><? echo $row[campo5]?>&nbsp;</td>
      <td align="center"><? echo $row[campo6]?>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>Moldeo</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B1' AND campo1 = '6' AND Hornada = $hornada";	
		 $Rs = mysqli_query($link, $Consulta);
		 $rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha_ini"],8,2)."-".substr($row["fecha_ini"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 510);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 1920);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">6,7</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">24,2</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B3' AND campo1 = '6' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);

	  ?>	
      <td align="center"><? echo $row[campo2]?>&nbsp;</td>
      <td align="center"><? echo $row[campo3]?>&nbsp;</td>
      <td align="center"><? echo $row[campo4]?>&nbsp;</td>
      <td align="center"><? echo $row[campo5]?>&nbsp;</td>
      <td align="center"><? echo $row[campo6]?>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>Vac. Sell.</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B1' AND campo1 = '7' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? if ($row["fecha_ini"]!="" && !is_null($row["fecha_ini"])){echo substr($row["fecha_ini"],8,2)."-".substr($row["fecha_ini"],5,2);}else{echo "&nbsp;";} ?></td>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ini],0,5)  ?>&nbsp;</td>
      <td align="center"><? echo substr($row[hora_ter],0,5)  ?>&nbsp;</td>
	  <? 	
	if($row = mysql_fetch_array($Rs))
	{	
		//DIFERENCIA DE HORAS
		$Hora1 = $row[hora_ini];
		$Hora2 = $row[hora_ter];		
		if (intval(substr($Hora2,0,2)) < intval(substr($Hora1,0,2)))
		{
			$Hora2 = (substr($Hora2,0,2)+24).":".substr($Hora2,3,2);
		}
		$Consulta = "SELECT SUBTIME('".$Hora2."', '".$Hora1."') as dif";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))	
			$real = substr($Fila["dif"],0,5);	  		
		//ACUMULA HORA
		if ($AcumHora!="")
		{
			$Consulta = "SELECT ADDTIME('".$AcumHora."', '".$real."') as sum_hora";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))	
			{
				$AcumHora = substr($Fila["sum_hora"],0,5);	
				$AcumHora2 = substr($Fila["sum_hora"],0,5);	
			}
		}
		else
		{
			$AcumHora = $real;	
			$AcumHora2 = $real;	
		}
		
		//DIFERENCIA CON PROG REAL
		$mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)) - 30);		  
		$dif = date("H:i",mktime(0,$mm));
		//DIFERENCIA ACUM. CON PROG REAL
		$mm =  abs(((substr($AcumHora,0,2) * 60) + substr($AcumHora,3,2)) - 1950);	
		$AcumHora_Dif =  date("H:i",mktime(0,$mm));	
		$AcumHora_Dif2 =  date("H:i",mktime(0,$mm));		
	}
	else
	{
		$real = '';
		$dif = '';	
		$AcumHora2 ='';	
		$AcumHora_Dif2 ='';	
	}		  	
	  ?>	
      <td align="center"><? echo $real?>&nbsp;</td>
      <td align="center">0,5</td>
      <td align="center"><? echo $dif?>&nbsp;</td>
      <td align="center"><? echo $AcumHora2?>&nbsp;</td>
      <td align="center">24,7</td>
      <td align="center"><? echo $AcumHora_Dif2?>&nbsp;</td>
	  <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'B3' AND campo1 = '7' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);

	  ?>	
      <td align="center"><? echo $row[campo2]?>&nbsp;</td>
      <td align="center"><? echo $row[campo3]?>&nbsp;</td>
      <td align="center"><? echo $row[campo4]?>&nbsp;</td>
      <td align="center"><? echo $row[campo5]?>&nbsp;</td>
      <td align="center"><? echo $row[campo6]?>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
  </table>
  <?
  	if($Proceso == "M")
	{
  ?>
  <table width="900" border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="281" align="center"> <input type="button" name="ok13" value="Ok" style="width:30px" onClick="Proceso('B1');"></td>
      <td width="166" align="center">&nbsp;</td>
      <td width="96" align="center">&nbsp;</td>
      <td width="317" align="center"><input type="button" name="ok1232" value="Ok" style="width:30px" onClick="Proceso('B3');"></td>
    </tr>
  </table>
  <? } ?>
  <br>
  <table width="900" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr> 
      <td align="center" colspan="3">Integrador Combustible</td>
      <td width="7" rowspan="16">&nbsp;</td>
      <td align="center" colspan="3">Combustible Parcial</td>
      <td width="7" rowspan="16">&nbsp;</td>
      <td align="center" colspan="3">Combustible Acum.</td>
      <td width="7" rowspan="16">&nbsp;</td>
      <td align="center" colspan="5">Produccion</td>
    </tr>
    <tr> 
      <td width="77" align="center" class="ColorTabla01">Etapas</td>
      <td width="77" align="center" class="ColorTabla01">Inicial</td>
      <td width="88" align="center" class="ColorTabla01">Final</td>
      <td width="40" align="center" class="ColorTabla01">Real</td>
      <td width="39" align="center" class="ColorTabla01">STD</td>
      <td width="42" align="center" class="ColorTabla01">Dif</td>
      <td width="40" align="center" class="ColorTabla01">Real</td>
      <td width="39" align="center" class="ColorTabla01">STD</td>
      <td width="42" align="center" class="ColorTabla01">Dif</td>
      <td align="center" class="ColorTabla01">Anodos</td>
      <td width="45" align="center" class="ColorTabla01">Unid.</td>
      <td width="46" align="center" class="ColorTabla01">Peso</td>
      <td width="65" align="center" class="ColorTabla01">Peso U.</td>
      <td width="46" align="center" class="ColorTabla01">STD</td>
    </tr>
    <tr> 
      <td>Carga 1</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '1' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 3800;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 3800;
			  $Acum_Dif2 = $Acum_Comb2 - 3800;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';
			  $Acum_Comb2 = '';	
			  $Acum_Dif2 = '';	
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">5.400</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">5.400</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
      <td>Comerciales</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C2' AND campo1 = '1' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
         if($row = mysql_fetch_array($rs))
		 {
		 	$unidades = $row[campo2];
			$peso = $row[campo3];
			$promedio = number_format($row[campo3]/$row[campo2],2,',','');		 
			$AcumAnodosUnid = $AcumAnodosUnid + $unidades;
			$AcumAnodosPeso = $AcumAnodosPeso + $peso;
		 }
		 else
		 {
		 	$unidades = '';
			$peso = '';
			$promedio = '';		 
		 }		  
	  ?>
      <td align="right"><? echo $unidades?>&nbsp;</td>
      <td align="right"><? echo $peso?>&nbsp;</td>
      <td align="center"><? echo $promedio?>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>Fusion 1</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '2' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 4250;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 8050;
			  $Acum_Dif2 = $Acum_Comb2 - 8050;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';	
			  $Acum_Comb2 = '';	
			  $Acum_Dif2 = '';	
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">7.200</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">12.600</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
      <td>Especiales</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C2' AND campo1 = '2' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
         if($row = mysql_fetch_array($rs))
		 {
		 	$unidades = $row[campo2];
			$peso = $row[campo3];
			$promedio = number_format($row[campo3]/$row[campo2],2,',','');		 
			$AcumAnodosUnid = $AcumAnodosUnid + $unidades;
			$AcumAnodosPeso = $AcumAnodosPeso + $peso;
		 }
		 else
		 {
		 	$unidades = '';
			$peso = '';
			$promedio = '';		 
		 }		  
	  ?>
      <td align="right"><? echo $unidades?>&nbsp;</td>
      <td align="right"><? echo $peso?>&nbsp;</td>
      <td align="center"><? echo $promedio?>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>Carga 2</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '3' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 2300;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 10350;
			  $Acum_Dif2 = $Acum_Comb2 - 10350;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';	
			  $Acum_Comb2 = '';	
			  $Acum_Dif2 = '';	
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">1.800</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">14.400</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
      <td>H. Madres</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C2' AND campo1 = '3' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
         if($row = mysql_fetch_array($rs))
		 {
		 	$unidades = $row[campo2];
			$peso = $row[campo3];
			$promedio = number_format($row[campo3]/$row[campo2],2,',','');		 
			$AcumAnodosUnid = $AcumAnodosUnid + $unidades;
			$AcumAnodosPeso = $AcumAnodosPeso + $peso;
		 }
		 else
		 {
		 	$unidades = '';
			$peso = '';
			$promedio = '';		 
		 }		  
	  ?>
      <td align="right"><? echo $unidades?>&nbsp;</td>
      <td align="right"><? echo $peso?>&nbsp;</td>
      <td align="center"><? echo $promedio?>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>Fusion 2</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '4' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 5100;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 15450;
			  $Acum_Dif2 = $Acum_Comb2 - 15450;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';	
			  $Acum_Comb2 = '';	
			  $Acum_Dif2 = '';	
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">3.600</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">18.000</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
      <td>Total</td>
      <td align="right"><? echo $AcumAnodosUnid?>&nbsp;</td>
      <td align="right"><? echo $AcumAnodosPeso?>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">408</td>
    </tr>
    <tr> 
      <td>Carga 3</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '5' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 2300;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 17750;
			  $Acum_Dif2 = $Acum_Comb2 - 17750;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';	
			  $Acum_Comb2 = '';	
			  $Acum_Dif2 = '';	
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">0</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">18.000</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr> 
      <td>Fusion 3</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '6' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 6000;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 23750;
			  $Acum_Dif2 = $Acum_Comb2 - 23750;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';	
			  $Acum_Comb2 = '';	
			  $Acum_Dif2 = '';	
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">0</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">18.000</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
      <td align="center" class="ColorTabla01">Moldes</td>
      <td align="center" class="ColorTabla01">Unid.</td>
      <td align="center" class="ColorTabla01">Peso</td>
      <td align="center" class="ColorTabla01">Peso U.</td>
      <td align="center" class="ColorTabla01">STD</td>
    </tr>
    <tr> 
      <td>Calenta 1</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '7' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 3000;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 26750;
			  $Acum_Dif2 = $Acum_Comb2 - 26750;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';	
			  $Acum_Comb2 = '';	
			  $Acum_Dif2 = '';	
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">3.600</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">21.600</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
      <td>Placas</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C3' AND campo1 = '1' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);		 
         if($row = mysql_fetch_array($rs))
		 {
		 	$unidades = $row[campo2];
			$peso = $row[campo3];
			$promedio = number_format($row[campo3]/$row[campo2],2,',','');		 
			$AcumMoldeUnid = $AcumMoldeUnid + $unidades;
			$AcumMoldePeso = $AcumMoldePeso + $peso;
		 }
		 else
		 {
		 	$unidades = '';
			$peso = '';
			$promedio = '';		 
		 }		  
	  ?>
      <td align="right"><? echo $unidades?>&nbsp;</td>
      <td align="right"><? echo $peso?>&nbsp;</td>
      <td align="center"><? echo $promedio?>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>Escoreo</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '8' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 2700;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 29450;
			  $Acum_Dif2 = $Acum_Comb2 - 29450;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';	
			  $Acum_Comb2 = '';	
			  $Acum_Dif2 = '';	
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">2.250</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">23.850</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
      <td>H.Madres</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C3' AND campo1 = '2' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);		 
         if($row = mysql_fetch_array($rs))
		 {
		 	$unidades = $row[campo2];
			$peso = $row[campo3];
			$promedio = number_format($row[campo3]/$row[campo2],2,',','');		 
			$AcumMoldeUnid = $AcumMoldeUnid + $unidades;
			$AcumMoldePeso = $AcumMoldePeso + $peso;
		 }
		 else
		 {
		 	$unidades = '';
			$peso = '';
			$promedio = '';		 
		 }		  
	  ?>
      <td align="right"><? echo $unidades?>&nbsp;</td>
      <td align="right"><? echo $peso?>&nbsp;</td>
      <td align="center"><? echo $promedio?>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>Calenta 2</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '9' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 1500;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 30950;
			  $Acum_Dif2 = $Acum_Comb2 - 30950;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';	
			  $Acum_Comb2 = '';	
			  $Acum_Dif2 = '';	
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">1.800</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">25.650</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
      <td>Total</td>
      <td align="right"><? echo $AcumMoldeUnid?>&nbsp;</td>
      <td align="right"><? echo $AcumMoldePeso?>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>Reduc.</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '10' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 3800;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 34750;
			  $Acum_Dif2 = $Acum_Comb2 - 34750;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';
			  $Acum_Comb2 = '';	
			  $Acum_Dif2 = '';	
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">3.000</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">28.650</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
      <td colspan="5" rowspan="4">&nbsp;</td>
    </tr>
    <tr> 
      <td>Calenta 3</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '11' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 1500;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 36250;
			  $Acum_Dif2 = $Acum_Comb2 - 36250;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';
			  $Acum_Comb2 = '';	
			  $Acum_Dif2 = '';	
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">900</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">29.550</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
    </tr>
    <tr> 
      <td>Moldeo</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '12' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 10000;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 46250;
			  $Acum_Dif2 = $Acum_Comb2 - 46250;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';	
			  $Acum_Comb2 = '';
			  $Acum_Dif2 = '';
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">8.000</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">37.550</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
    </tr>
    <tr> 
      <td>Vacio Sellado</td>
      <?
		 $Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = '13' AND Hornada = $hornada";	
		 $rs = mysqli_query($link, $Consulta);
		 $Rs = mysqli_query($link, $Consulta);
		 $row = mysql_fetch_array($rs);
	  ?>
      <td align="center"><? echo $row[campo2] ?>&nbsp;</td>
      <td align="center"><? echo $row[campo3] ?>&nbsp;</td>
      <? 	
		  if($row = mysql_fetch_array($Rs))
		  {	
			  $real = abs($row[campo3] - $row[campo2]);	  	
		
			  $dif = $real - 450;
			  
			  $Acum_Comb = $Acum_Comb + $real;
			  $Acum_Comb2 = $Acum_Comb;

			  $Acum_Dif = $Acum_Comb - 46700;
			  $Acum_Dif2 = $Acum_Comb2 - 46700;
		  }
		  else
		  {
			  $real = '';
			  $dif = '';
			  $Acum_Comb2 = '';
			  $Acum_Dif2 = '';
		  }		  	
	  ?>
      <td align="right"><? echo $real?>&nbsp;</td>
      <td align="center">60</td>
      <td align="right"><? echo $dif?>&nbsp;</td>
      <td align="right"><? echo $Acum_Comb2?>&nbsp;</td>
      <td align="center">37.610</td>
      <td align="right"><? echo $Acum_Dif2?>&nbsp;</td>
    </tr>
  </table>
  <?
  	if($Proceso == "M")
	{
  ?>
  <table width="900" border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="267" align="center"> <input type="button" name="ok14" value="Ok" style="width:30px" onClick="Proceso('C1');"></td>
      <td width="173" align="center">&nbsp;</td>
      <td width="460" align="center"> Producci&oacute;n <input type="button" name="ok1233" value="Ok" style="width:30px" onClick="Proceso('C2');">
        &nbsp;&nbsp;&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp; 
        Moldes 
        <input type="button" name="ok1233" value="Ok" style="width:30px" onClick="Proceso('C3');"> 
      </td>
    </tr>
  </table>
  <? }?>	
  <br>
  <table width="900" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr> 
      <td width="63" align="center" class="ColorTabla01">Etapas</td>
      <td width="63" align="center" class="ColorTabla01">Fecha</td>
      <td width="73" align="center" class="ColorTabla01"> Hora Inicial</td>
      <td width="75" align="center" class="ColorTabla01"> Hora Final</td>
      <td width="32" rowspan="19">&nbsp;</td>
      <td width="581" colspan="3" align="center" class="ColorTabla01">Incidentes Operacionales</td>
    </tr>
	<?
		$Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'D1' AND Hornada = $hornada";
		$Consulta.= " ORDER BY fecha_ini, hora_ini";
		$rs = mysqli_query($link, $Consulta);
		while ($row = mysql_fetch_array($rs))
		{
			$arreglo[] = array($row[campo1], $row[hora_ini], $row[hora_ter], $row["fecha_ini"]);
		}

	?>
    <tr>
      <td><? echo $etapa[$arreglo[0][0]]; ?>&nbsp;</td>
      <td align="center"><? if ($arreglo[0][3]!="")echo substr($arreglo[0][3],8,2)."-".substr($arreglo[0][3],5,2); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[0][1],0,5); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[0][2],0,5); ?>&nbsp;</td>
	<?
		$Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE tipo_report = 2 AND seccion_report = 'D2' AND Hornada = $hornada";
		$rs = mysqli_query($link, $Consulta);
		$row = mysql_fetch_array($rs);
	?>
      <td colspan="3" rowspan="9" valign="top"><? echo nl2br($row[campo8]);?>&nbsp;</td>
    </tr>
    <tr> 
      <td><? echo $etapa[$arreglo[1][0]]; ?>&nbsp;</td>
      <td align="center"><? if ($arreglo[1][3]!="")echo substr($arreglo[1][3],8,2)."-".substr($arreglo[1][3],5,2); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[1][1],0,5); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[1][2],0,5); ?>&nbsp;</td>
    </tr>
    <tr> 
      <td><? echo $etapa[$arreglo[2][0]]; ?>&nbsp;</td>
     <td align="center"><?  if ($arreglo[2][3]!="")echo substr($arreglo[2][3],8,2)."-".substr($arreglo[2][3],5,2); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[2][1],0,5); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[2][2],0,5); ?>&nbsp;</td>
    </tr>
    <tr> 
      <td><? echo $etapa[$arreglo[3][0]]; ?>&nbsp;</td>
      <td align="center"><? if ($arreglo[3][3]!="")echo substr($arreglo[3][3],8,2)."-".substr($arreglo[3][3],5,2); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[3][1],0,5); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[3][2],0,5); ?>&nbsp;</td>
    </tr>
    <tr> 
      <td><? echo $etapa[$arreglo[4][0]]; ?>&nbsp;</td>
      <td align="center"><? if ($arreglo[4][3]!="")echo substr($arreglo[4][3],8,2)."-".substr($arreglo[4][3],5,2); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[4][1],0,5); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[4][2],0,5); ?>&nbsp;</td>
    </tr>
    <tr>
      <td><? echo $etapa[$arreglo[5][0]]; ?>&nbsp;</td>
      <td align="center"><? if ($arreglo[5][3]!="")echo substr($arreglo[5][3],8,2)."-".substr($arreglo[5][3],5,2); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[5][1],0,5); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[5][2],0,5); ?>&nbsp;</td>
    </tr>
    <tr>
      <td><? echo $etapa[$arreglo[6][0]]; ?>&nbsp;</td>
      <td align="center"><? if ($arreglo[6][3]!="")echo substr($arreglo[6][3],8,2)."-".substr($arreglo[6][3],5,2); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[6][1],0,5); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[6][2],0,5); ?>&nbsp;</td>
    </tr>
    <tr>
      <td><? echo $etapa[$arreglo[7][0]]; ?>&nbsp;</td>
      <td align="center"><? if ($arreglo[7][3]!="")echo substr($arreglo[7][3],8,2)."-".substr($arreglo[7][3],5,2); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[7][1],0,5); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[7][2],0,5); ?>&nbsp;</td>
    </tr>
    <tr>
      <td><? echo $etapa[$arreglo[8][0]]; ?>&nbsp;</td>
      <td align="center"><? if ($arreglo[8][3]!="")echo substr($arreglo[8][3],8,2)."-".substr($arreglo[8][3],5,2); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[8][1],0,5); ?>&nbsp;</td>
      <td align="center"><? echo substr($arreglo[8][2],0,5); ?>&nbsp;</td>
    </tr>
  </table>
  <? 
     if($Proceso == "M")
  	 {
  ?>
  <table width="900" border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="235" align="center"> <input type="button" name="ok15" value="Ok" style="width:30px" onClick="Proceso('D1');"></td>
      <td width="629" align="center"><input type="button" name="ok1234" value="Ok" style="width:30px" onClick="Proceso('D2');"></td>
    </tr>
  </table>
  <? } ?>	  	
  <br>
  <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td align="center"> <input type="button" name="BtnImprimir" value="Imprimir" style="width:70px" onClick="Proceso('P');"> 
        <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"> 
      </td>
    </tr>
  </table>
</form>

</body>
</html>
