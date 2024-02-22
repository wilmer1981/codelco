<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
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
	$CodigoDeSistema=15;
	$CodigoDePantalla=95;
	if(!isset($CmbMes))
	{
		$LoteIni=substr(date('Y'),2,2).str_pad(date('n'),2,'0',STR_PAD_LEFT)."0001";
		$LoteFin=substr(date('Y'),2,2).str_pad(date('n'),2,'0',STR_PAD_LEFT)."9999";
	}
	else
	{
		if (substr($CmbAno,0,4)<2006)
		{
			$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
			$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
		}
		else
		{
			$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
			$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";;
		}
	}	
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	$Consulta="select count(*) as cant from age_web.lotes where lote between '$LoteIni' and '$LoteFin' and canjeable='S'";
	$Respuesta=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Respuesta))
	{
		$CantLotesCanjeados=$Fila[cant];
	}
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");		
?>
<html>
<head>
<title>AGE-Consulta Lotes Canjeados Excel</title>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
<table width="544"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02" align="center">
    <td colspan="4"><strong>LOTES CANJEADOS MENSUAL </strong></td>
  </tr>
  <tr class="Colum01">
    <td width="88" class="Colum01">Mes:</td>
    <td class="Colum01">
	<?php
		echo $meses[$CmbMes-1]."&nbsp;&nbsp;&nbsp;";
		echo $CmbAno;
		?>&nbsp;&nbsp;&nbsp;&nbsp;<strong><font color="#FF0000">Lotes Canjeados en el Mes:</font></strong>&nbsp;&nbsp;
      <?php echo $CantLotesCanjeados;?></td>
  </tr>
  <tr class="Colum01">
    <td width="71" class="Colum01">Lote Inicio:</td>
    <td width="664" class="Colum01"><?php echo $TxtLoteIni; ?>
      &nbsp;&nbsp;&nbsp;
      Lote Final: 
        <?php echo $TxtLoteFin; ?>
        &nbsp;&nbsp;&nbsp;
  </tr>
  </table>
	<br>
	<table border='1' align='center' cellpadding='1' cellspacing='0' class='TablaInterior'>
	<tr align="center" class="ColorTabla01">
	<td width="14" rowspan="2">N�</td>
	<td width="24" rowspan="2">Lote</td>
	<td width="56" rowspan="2">Proveedor</td>
	<td colspan="3">Pastas a tercero</td>
	<td width="58" rowspan="2">Laboratorio</td>
	<td width="73" rowspan="2">Fecha<br>Recep.</td>
	<td width="68" rowspan="2">Fecha<br>Canje</td>
	<td width="99" rowspan="2">Fecha<br>Solic.Pqtes</td>
	<td width="103" rowspan="2">Fecha<br>Certif</td>
	<td colspan="3">Codelco</td>
	<td colspan="3">Enami</td>
	<td colspan="3">Tercero</td>
	<td colspan="3">Final<br>Codelco</td>
	<td colspan="3">Final<br>Enami</td>
	</tr>
	<tr align="center" class="ColorTabla01">
	<td width="26">Cu</td>
	<td width="26">Ag</td>
	<td width="30">Au</td>
	<td width="15">Cu</td>
	<td width="15">Ag</td>
	<td width="15">Au</td>
	<td width="15">Cu</td>
	<td width="15">Ag</td>
	<td width="15">Au</td>
	<td width="15">Cu</td>
	<td width="15">Ag</td>
	<td width="15">Au</td>
	<td width="21">Cu</td>
	<td width="21">Ag</td>
	<td width="20">Au</td>
	<td width="17">Cu</td>
	<td width="17">Ag</td>
	<td width="33">Au</td>
	</tr>
	<?php
	if($Buscar=='S')
	{

		
		$Cont=1;
		$Consulta ="select t1.fecha_sol_pqts,t1.fecha_canje,t1.fecha_recepcion,t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.abreviatura as nom_subproducto,t1.rut_proveedor,t4.nombre_prv as nom_prv,t1.num_conjunto, t1.cod_recepcion,";
		$Consulta.="t1.cod_faena,t5.descripcion as nom_faena,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.valor_subclase1 as nom_recepcion,t10.nombre_subclase as nom_lab ";
		$Consulta.="from age_web.lotes t1 inner join age_web.leyes_por_lote_canje t9 on t1.lote=t9.lote and t9.paquete_canje='3' left join ";
		$Consulta.="proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto left join ";
		$Consulta.="sipa_web.proveedores t4 on t1.rut_proveedor=t4.rut_prv left join ";
		$Consulta.="age_web.mina t5 on t1.cod_faena=t5.cod_faena left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15003' and t1.estado_lote=t6.cod_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t7 on t7.cod_clase='15001' and t1.clase_producto=t7.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t8 on t8.cod_clase='15002' and t1.cod_recepcion=t8.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t10 on t10.cod_clase='15009' and t1.laboratorio_externo=t10.cod_subclase ";
		switch($TipoBusqueda)
		{
			case "BL"://POR LOTE
				$Consulta.= "where t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";
				break;
			case "BM"://POR MES
				if ($CmbAno<2006)
				{
					$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
					$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
				}
				else
				{	
					$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
					$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";
				}
				$Consulta.= "where t1.lote between '".$LoteIni."' and '".$LoteFin."'";
				//$Consulta.= "where t1.lote ='06110045'";
				break;
		}	
		$Consulta.=" and t1.canjeable='S' group by t1.lote";
		//echo $Consulta."<br>";
		$Resp = mysqli_query($link, $Consulta);
		while($Fila = mysqli_fetch_array($Resp))
		{
			$ArrLeyesCanje=array();
			$ArrLeyesCanje["02"][0]="02";
			$ArrLeyesCanje["02"][1]="Cu";
			$ArrLeyesCanje["02"][2]=0;
			$ArrLeyesCanje["02"][3]=0;
			$ArrLeyesCanje["02"][4]=0;
			$ArrLeyesCanje["04"][0]="03";
			$ArrLeyesCanje["04"][1]="Ag";
			$ArrLeyesCanje["04"][2]=0;
			$ArrLeyesCanje["04"][3]=0;
			$ArrLeyesCanje["04"][4]=0;
			$ArrLeyesCanje["05"][0]="05";
			$ArrLeyesCanje["05"][1]="Au";
			$ArrLeyesCanje["05"][2]=0;
			$ArrLeyesCanje["05"][3]=0;
			$ArrLeyesCanje["05"][4]=0;
			echo "<tr>";
			echo "<td>".$Cont."</td>";
			echo "<td>".$Fila[lote]."</td>";
			echo "<td>".$Fila[nom_prv]."</td>";
			$Consulta="select * from age_web.leyes_por_lote_canje where lote='".$Fila[lote]."' and paquete_canje='3'";
			$RespLeyes=mysqli_query($link, $Consulta);
			while($FilaLeyes=mysqli_fetch_array($RespLeyes))
			{
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][2]=$FilaLeyes[valor1];
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][3]=$FilaLeyes[valor2];
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][4]=$FilaLeyes[valor3];
			}
			reset($ArrLeyesCanje);
			while(list($c,$v)=each($ArrLeyesCanje))
			{
				if($v[2]!=0)
					echo "<td>".$v[1]."</td>";
				else
					echo "<td>-</td>";
			}			
			echo "<td>".$Fila[nom_lab]."&nbsp;</td>";
			echo "<td>".substr($Fila[fecha_recepcion],2)."</td>";
			echo "<td>".substr($Fila[fecha_canje],2)."</td>";
			if($Fila[fecha_sol_pqts]!='0000-00-00')
				echo "<td>".substr($Fila[fecha_sol_pqts],2)."&nbsp;</td>";
			else
				echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			reset($ArrLeyesCanje);
			while(list($c,$v)=each($ArrLeyesCanje))
			{
				if($v[2]!=0)
					echo "<td align='right'>".number_format($v[2],1,'.',',')."</td>";
				else
					echo "<td align='center'>-</td>";
			}					
			reset($ArrLeyesCanje);
			while(list($c,$v)=each($ArrLeyesCanje))
			{
				if($v[2]!=0)
					echo "<td align='right'>".number_format($v[3],1,'.',',')."</td>";
				else
					echo "<td align='center'>-</td>";
			}
			reset($ArrLeyesCanje);
			while(list($c,$v)=each($ArrLeyesCanje))
			{
				if($v[2]!=0)
					echo "<td bgcolor='#CCFFFF' align='right'>".number_format($v[4],1,'.',',')."</td>";
				else
					echo "<td bgcolor='#CCFFFF' align='center'>-</td>";
			}
			reset($ArrLeyesCanje);
			while(list($c,$v)=each($ArrLeyesCanje))
			{
				if($v[2]!=0)
					echo "<td bgcolor='#99FFCC' align='right'>".number_format($v[2]-$v[4],1,'.',',')."</td>";
				else
					echo "<td bgcolor='#99FFCC' align='center'>-</td>";
			}
			reset($ArrLeyesCanje);
			while(list($c,$v)=each($ArrLeyesCanje))
			{
				if($v[2]!=0)
					echo "<td bgcolor='#66CCFF' align='right'>".number_format($v[3]-$v[4],1,'.',',')."</td>";
				else
					echo "<td bgcolor='#66CCFF' align='center'>-</td>";
			}
			echo "</tr>";
			$Cont++;
		}
	}
	?>
	</table>	
</form>
</body>
</html>
