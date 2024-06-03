<?php include("../principal/conectar_principal.php"); 
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
        $filename="";
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 	      header("Expires: 0");
  	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        
        if(isset($_REQUEST["CmbDias"])) {
          $CmbDias = $_REQUEST["CmbDias"];
        }else{
          $CmbDias =  date("d");
        }
        if(isset($_REQUEST["CmbMes"])) {
          $CmbMes = $_REQUEST["CmbMes"];
        }else{
          $CmbMes =  date("m");
        }
        if(isset($_REQUEST["CmbAno"])) {
          $CmbAno = $_REQUEST["CmbAno"];
        }else{
          $CmbAno =  date("Y");
        }
        if(isset($_REQUEST["CmbDiasT"])) {
          $CmbDiasT = $_REQUEST["CmbDiasT"];
        }else{
          $CmbDiasT =  date("d");
        }
        if(isset($_REQUEST["CmbMesT"])) {
          $CmbMesT = $_REQUEST["CmbMesT"];
        }else{
          $CmbMesT =  date("m");
        }
        if(isset($_REQUEST["CmbAnoT"])) {
          $CmbAnoT = $_REQUEST["CmbAnoT"];
        }else{
          $CmbAnoT =  date("Y");
        }
        
        
?>
<html>
<head>
<title>Control de Calidad</title>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="<?php echo (270 + ($TotalLeyes * 3)); ?>" border="1" cellpadding="1" cellspacing="1">
    <tr> 
      <td colspan="16"> 
    <?php
		if ($CmbMes == $CmbMesT)
		{
			echo "MES: ".$Meses[$CmbMes]." ".$CmbAno;
		}
		else
		{
			echo "PERIODO: ".$Meses[$CmbMes-1]." ".$CmbAno." - ".$Meses[$CmbMesT-1]." ".$CmbAnoT;
		}
		?>
      </td>
    </tr>
    <tr> 
      <td colspan="16">&nbsp; </td>
    </tr>
    <tr> 
      <td><strong>Dia</strong></td>
      <td><strong>Cu</strong></td>
      <td><strong>O</strong></td>
      <td><strong>S</strong></td>
      <td><strong>PROD. DIA</strong></td>
      <td><strong>Sb</strong></td>
      <td><strong>Te</strong></td>
      <td><strong>Sn</strong></td>
      <td><strong>Fe</strong></td>
      <td><strong>Pb</strong></td>
      <td><strong>Ni</strong></td>
      <td><strong>Bi</strong></td>
      <td><strong>As</strong></td>
      <td><strong>Se</strong></td>
      <td><strong>Au</strong></td>
      <td><strong>Ag</strong></td>
    </tr>
    <?php 
    
    if(strlen($CmbDias)==1){
      $CmbDias= "0".$CmbDias;
    }
    if(strlen($CmbMes)==1){
      $CmbMes= "0".$CmbMes;
    }
    if(strlen($CmbDiasT)==1){
      $CmbDiasT= "0".$CmbDiasT;
    }
    if(strlen($CmbMesT)==1){
      $CmbMesT= "0".$CmbMesT;
    }
	$FechaInicio = $CmbAno."-".$CmbMes."-".$CmbDias;
	$FechaTermino = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT;
	$Consulta = "select year(t1.fecha_muestra) as ano, ";
	$Consulta.= " case when length(month(t1.fecha_muestra))=1 then concat('0',month(t1.fecha_muestra)) else month(t1.fecha_muestra) end as mes, ";
	$Consulta.= " case when length(DAYOFMONTH(t1.fecha_muestra))=1 then concat('0',DAYOFMONTH(t1.fecha_muestra)) else DAYOFMONTH(t1.fecha_muestra) end as dia, ";
	$Consulta.= " concat(year(t1.fecha_muestra),'-',month(t1.fecha_muestra),'-',DAYOFMONTH(t1.fecha_muestra)) as fecha_muestra ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " where t1.cod_producto = '18' and t1.cod_subproducto = '1' ";
	$Consulta.= " and t1.cod_analisis = '1' and t1.tipo='1' and t1.tipo_solicitud = 'R' ";
	$Consulta.= " and t1.fecha_muestra between '".$FechaInicio." 00:00:00' and '".$FechaTermino." 23:59:59' ";
	$Consulta.= " and t1.cod_periodo = '1' and agrupacion = '7'";
	$Consulta.= " group by ano, mes, dia";
	$Consulta.= " order by ano, mes, dia";
	$Respuesta = mysqli_query($link, $Consulta);
	$Cont = 1;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$SumaImpurezas = 0;
		echo "<tr>\n";
		if ($CmbMes == $CmbMesT)
			echo "<td>".substr($Fila["fecha_muestra"],8,2)."</td>";
		else	echo "<td>".substr($Fila["fecha_muestra"],8,2)."/".substr($Fila["fecha_muestra"],6,2)."/".substr($Fila["fecha_muestra"],0,4)."</td>";
		$Pos = $Cont+3;
		echo "<td>=REDONDEAR(100-(C".$Pos."+D".$Pos."+F".$Pos."+G".$Pos."+H".$Pos."+I".$Pos."+J".$Pos."+K".$Pos."+L".$Pos."+M".$Pos."+N".$Pos."+O".$Pos."+P".$Pos.")/10000;3)</td>";		
		$CodLey = "";
		for ($i=1;$i<=2;$i++)
		{
			switch ($i)
			{
				case 1:
					$CodLey = "48";
					break;
				case 2:
					$CodLey = "26";
					break;
			}	
			$Consulta = "select t1.fecha_muestra, t2.cod_leyes, round(AVG(t2.valor)) as valor ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
			$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo= t2.recargo ";
			$Consulta.= " where t1.cod_producto = '18' and t1.cod_subproducto = '1' ";
			$Consulta.= " and t1.cod_analisis = '1' and t1.tipo='1' and t1.tipo_solicitud = 'R' ";
			$Consulta.= " and t1.fecha_muestra between '".$Fila["fecha_muestra"]." 00:00:00' and '".$Fila["fecha_muestra"]." 23:59:59' ";
			$Consulta.= " and t2.candado = '1' and t1.cod_periodo = '1'";
			$Consulta.= " and (t2.cod_leyes = '".$CodLey."') and agrupacion = '7'";
			$Consulta.= " group by t1.fecha_muestra, t2.cod_leyes ";
			$Consulta.= " order by t1.fecha_muestra, t2.cod_leyes ";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				echo "<td>".str_replace(".",",",$Fila2["valor"])."</td>";
			}
			else
			{
				echo "<td>&nbsp;</td>";			
			}
		}
		echo "<td>0</td>";
		for ($i=1;$i<=11;$i++)
		{
			switch ($i)
			{
				case 1:
					$CodLey = "09";					
					break;
				case 2:
					$CodLey = "44";
					break;
				case 3:
					$CodLey = "30";
					break;
				case 4:
					$CodLey = "31";
					break;
				case 5:
					$CodLey = "39";
					break;
				case 6:
					$CodLey = "36";
					break;
				case 7:
					$CodLey = "27";
					break;
				case 8:
					$CodLey = "08";
					break;
				case 9:
					$CodLey = "40";
					break;
				case 10:
					$CodLey = "05";
					break;
				case 11:
					$CodLey = "04";
					break;
			}	
			if ($CodLey == "04")
				$Consulta = "select t1.fecha_muestra, t2.cod_leyes, round(AVG(t2.valor)) as valor ";
			else	$Consulta = "select t1.fecha_muestra, t2.cod_leyes, round(AVG(t2.valor),1) as valor ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
			$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo= t2.recargo ";
			$Consulta.= " where t1.cod_producto = '18' and t1.cod_subproducto = '1' ";
			$Consulta.= " and t1.cod_analisis = '1' and t1.tipo='1' and t1.tipo_solicitud = 'R' ";
			$Consulta.= " and t1.fecha_muestra between '".$Fila["fecha_muestra"]." 00:00:00' and '".$Fila["fecha_muestra"]." 23:59:59' ";
			$Consulta.= " and t2.candado = '1' and t1.cod_periodo = '1'";
			$Consulta.= " and (t2.cod_leyes = '".$CodLey."') and agrupacion = '7'";
			$Consulta.= " group by t1.fecha_muestra, t2.cod_leyes ";
			$Consulta.= " order by t1.fecha_muestra, t2.cod_leyes ";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				echo "<td>".str_replace(".",",",$Fila2["valor"])."</td>";
			}
			else
			{
				echo "<td>&nbsp;</td>";			
			}
		}		
		echo "</tr>";
		$Cont++;		
	}
?>
    <tr> 
      <td>&nbsp;</td>
      <td>=SUMAPRODUCTO(B4:B<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMAPRODUCTO(C4:C<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMAPRODUCTO(D4:D<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMA(E4:E34)</td>
      <td>=SUMAPRODUCTO(F4:F<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMAPRODUCTO(G4:G<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMAPRODUCTO(H4:H<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMAPRODUCTO(I4:I<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMAPRODUCTO(J4:J<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMAPRODUCTO(K4:K<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMAPRODUCTO(L4:L<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMAPRODUCTO(M4:M<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMAPRODUCTO(N4:N<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMAPRODUCTO(O4:O<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
      <td>=SUMAPRODUCTO(P4:P<?php echo ($Cont+2); ?>;$E4:$E<?php echo ($Cont+2); ?>)/$E<?php echo ($Cont+3); ?></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>=REDONDEAR(DESVEST(B4:B<?php echo ($Cont+2); ?>);9)</td>
      <td>=REDONDEAR(DESVEST(C4:C<?php echo ($Cont+2); ?>);9)</td>
      <td>=REDONDEAR(DESVEST(D4:D<?php echo ($Cont+2); ?>);9)</td>
      <td>&nbsp;</td>
      <td>=REDONDEAR(DESVEST(F4:F<?php echo ($Cont+2); ?>);9)</td>
      <td>=REDONDEAR(DESVEST(G4:G<?php echo ($Cont+2); ?>);9)</td>
      <td>=REDONDEAR(DESVEST(H4:H<?php echo ($Cont+2); ?>);9)</td>
      <td>=REDONDEAR(DESVEST(I4:I<?php echo ($Cont+2); ?>);9)</td>
      <td>=REDONDEAR(DESVEST(J4:J<?php echo ($Cont+2); ?>);9)</td>
      <td>=REDONDEAR(DESVEST(K4:K<?php echo ($Cont+2); ?>);9)</td>
      <td>=REDONDEAR(DESVEST(L4:L<?php echo ($Cont+2); ?>);9)</td>
      <td>=REDONDEAR(DESVEST(M4:M<?php echo ($Cont+2); ?>);9)</td>
      <td>=REDONDEAR(DESVEST(N4:N<?php echo ($Cont+2); ?>);9)</td>
      <td>=REDONDEAR(DESVEST(O4:O<?php echo ($Cont+2); ?>);9)</td>
      <td>=REDONDEAR(DESVEST(P4:P<?php echo ($Cont+2); ?>);9)</td>
    </tr>
    <tr> 
      <td colspan="16">&nbsp;</td>
    </tr>
    <tr> 
      <td><strong>PROM.<br>
        </strong></td>
      <td>=PROMEDIO(B4:B<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(C4:C<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(D4:D<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(E4:E<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(F4:F<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(G4:G<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(H4:H<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(I4:I<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(J4:J<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(K4:K<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(L4:L<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(M4:M<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(N4:N<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(O4:O<?php echo ($Cont+2); ?>)</td>
      <td>=PROMEDIO(P4:P<?php echo ($Cont+2); ?>)</td>
    </tr>
    <tr> 
      <td><strong>DESV. ST.</strong></td>
      <td>=DESVEST(B4:B<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(C4:C<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(D4:D<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(E4:E<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(F4:F<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(G4:G<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(H4:H<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(I4:I<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(J4:J<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(K4:K<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(L4:L<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(M4:M<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(N4:N<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(O4:O<?php echo ($Cont+2); ?>)</td>
      <td>=DESVEST(P4:P<?php echo ($Cont+2); ?>)</td>
    </tr>
    <tr> 
      <td height="23"><strong>MAX.</strong></td>
      <td>=MAX(B4:B<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(C4:C<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(D4:D<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(E4:E<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(F4:F<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(G4:G<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(H4:H<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(I4:I<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(J4:J<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(K4:K<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(L4:L<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(M4:M<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(N4:N<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(O4:O<?php echo ($Cont+2); ?>)</td>
      <td>=MAX(P4:P<?php echo ($Cont+2); ?>)</td>
    </tr>
    <tr> 
      <td><strong>MIN. </strong></td>
      <td>=MIN(B4:B<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(C4:C<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(D4:D<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(E4:E<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(F4:F<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(G4:G<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(H4:H<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(I4:I<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(J4:J<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(K4:K<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(L4:L<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(M4:M<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(N4:N<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(O4:O<?php echo ($Cont+2); ?>)</td>
      <td>=MIN(P4:P<?php echo ($Cont+2); ?>)</td>
    </tr>
  </table>
  <br>
</form>
</body>
</html>
