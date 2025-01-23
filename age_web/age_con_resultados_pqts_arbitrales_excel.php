<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=95;
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
	  $CmbMes     = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:"";
	  $CmbAno     = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:"";
	  $Recarga    = isset($_REQUEST["Recarga"])?$_REQUEST["Recarga"]:"";
	  $Buscar     = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	  $TipoBusqueda = isset($_REQUEST["TipoBusqueda"])?$_REQUEST["TipoBusqueda"]:"";
	  $EstadoInput = isset($_REQUEST["EstadoInput"])?$_REQUEST["EstadoInput"]:"";
	  $TxtOrdenEnsaye = isset($_REQUEST["TxtOrdenEnsaye"])?$_REQUEST["TxtOrdenEnsaye"]:"";
	  $TxtLoteIni  = isset($_REQUEST["TxtLoteIni"])?$_REQUEST["TxtLoteIni"]:"";
	  $TxtLoteFin  = isset($_REQUEST["TxtLoteFin"])?$_REQUEST["TxtLoteFin"]:"";
	  $Petalo      = isset($_REQUEST["Petalo"])?$_REQUEST["Petalo"]:"";

	if($CmbMes=="")
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
		$CantLotesCanjeados=$Fila["cant"];
	}
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");		
?>
<html>
<head>
<title>AGE-Consulta Resultado Paquetes Arbitrales</title>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form name="frmPrincipal" action="" method="post">
  <br>
	<table border='1' align='center' cellpadding='1' cellspacing='0' class='TablaInterior'>
	<tr align="center" class="ColorTabla01">
	<td colspan="11">CANJE MES O-E N&deg;</td>
	</tr>
	<tr align="center" class="ColorTabla01">
	<td rowspan="2">N&deg;</td>
	<td rowspan="2">Lote</td>
	<td rowspan="2">Proveedor</td>
	<td colspan="3">Gana Codelco</td>
	<td colspan="3">Gana Enami</td>
	<td rowspan="2">Laboratorio</td>
	<td rowspan="2">Orden de Ensaye</td>
	<td rowspan="2">Fecha<br>
	Cierre Lote </td>
	<td rowspan="2">Fecha<br>Canje</td>
	<td rowspan="2">Fecha<br>Solic.Pqtes</td>
	<td rowspan="2">Fecha<br>
	Recep. Codelco</td>
	</tr>
	<tr align="center" class="ColorTabla01">
	<td>Cu</td>
	<td>Ag</td>
	<td>Au</td>
	<td>Cu</td>
	<td>Ag</td>
	<td>Au</td>
	</tr>
	<?php
	if($Buscar=='S')
	{
		$Cont=1;$CantGanaC_CU=0;$CantGanaC_AG=0;$CantGanaC_AU=0;$CantGanaE_CU=0;$CantGanaE_AG=0;$CantGanaE_AU=0;
		$Consulta ="select t1.fecha_sol_pqts,t1.fecha_canje,t1.fecha_recepcion,t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.abreviatura as nom_subproducto,t1.rut_proveedor,t4.nombre_prv as nom_prv,t1.num_conjunto, t1.cod_recepcion,";
		$Consulta.="t1.cod_faena,t5.descripcion as nom_faena,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.valor_subclase1 as nom_recepcion,t10.nombre_subclase as nom_lab,t1.orden_ensaye ";
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
			case "BOE"://BUSCAR POR ORDEN DE ENSAYE
				$Consulta.= "where t1.orden_ensaye='".$TxtOrdenEnsaye."'";
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
			$ArrLeyesCanje["04"][0]="04";
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
			echo "<td>".$Fila["lote"]."</td>";
			echo "<td>".$Fila["nom_prv"]."</td>";
			$Consulta="select * from age_web.leyes_por_lote_canje where lote='".$Fila["lote"]."' and paquete_canje='3'";
			$RespLeyes=mysqli_query($link, $Consulta);
			while($FilaLeyes=mysqli_fetch_array($RespLeyes))
			{
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][2]=$FilaLeyes["valor1"];
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][3]=$FilaLeyes["valor2"];
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][4]=$FilaLeyes["valor3"];
			}
			reset($ArrLeyesCanje);
			foreach($ArrLeyesCanje as $c=>$v)
			{
				if($v[2]!=0)
				{
					$GanaC=0;
					if(abs($v[2]-$v[4]+1000-1000)<abs($v[3]-$v[4]+1000-1000))
					{
						echo "<td align='center'>1</td>";
						$GanaC=1;
					}
					else
						if(abs($v[2]-$v[4]+1000-1000)==abs($v[3]-$v[4]+1000-1000))
						{
							echo "<td align='center'>0,5</td>";
							$GanaC=0.5;
						}	
						else
							echo "<td align='center'>0</td>";
					switch($v[0])
					{
						case "02":
							$CantGanaC_CU=$CantGanaC_CU+$GanaC;
							break;
						case "04":
							$CantGanaC_AG=$CantGanaC_AG+$GanaC;
							break;
						case "05":
							$CantGanaC_AU=$CantGanaC_AU+$GanaC;
							break;
					}		
				}	
				else
					echo "<td align='center'>-</td>";
			}
			reset($ArrLeyesCanje);			
			foreach($ArrLeyesCanje as $c=>$v)
			{
				if($v[2]!=0)
				{
					$GanaE=0;
					if(abs($v[2]-$v[4]+1000-1000)>abs($v[3]-$v[4]+1000-1000))
					{
						echo "<td align='center'>1</td>";
						$GanaE=1;
					}	
					else
						if(abs($v[2]-$v[4]+1000-1000)==abs($v[3]-$v[4]+1000-1000))
						{
							echo "<td align='center'>0,5</td>";
							$GanaE=0.5;
						}	
						else
							echo "<td align='center'>0</td>";
					switch($v[0])
					{
						case "02":
							$CantGanaE_CU=$CantGanaE_CU+$GanaE;
							break;
						case "04":
							$CantGanaE_AG=$CantGanaE_AG+$GanaE;
							break;
						case "05":
							$CantGanaE_AU=$CantGanaE_AU+$GanaE;
							break;
					}
				}			
				else
					echo "<td align='center'>-</td>";
					
			}		
			echo "<td>".$Fila["nom_lab"]."&nbsp;</td>";
			echo "<td>".$Fila["orden_ensaye"]."&nbsp;</td>";
			echo "<td>".$Fila["fecha_recepcion"]."</td>";
			echo "<td>".$Fila["fecha_canje"]."</td>";
			if($Fila["fecha_sol_pqts"]!='0000-00-00')
				echo "<td>".$Fila["fecha_sol_pqts"]."&nbsp;</td>";
			else
				echo "<td>&nbsp;</td>";
			echo "<td>".$Fila["fecha_recepcion"]."</td>";
			echo "</tr>";
			$Cont++;
		}
		echo "<tr class='colortabla02'>";
		echo "<td colspan='3' align='center'>RESULTADOS</td>";
		echo "<td align='center'><strong>".str_replace('.',',',$CantGanaC_CU)."</strong></td>";
		echo "<td align='center'><strong>".str_replace('.',',',$CantGanaC_AG)."</strong></td>";
		echo "<td align='center'><strong>".str_replace('.',',',$CantGanaC_AU)."</strong></td>";
		echo "<td align='center'><strong>".str_replace('.',',',$CantGanaE_CU)."</strong></td>";
		echo "<td align='center'><strong>".str_replace('.',',',$CantGanaE_AG)."</strong></td>";
		echo "<td align='center'><strong>".str_replace('.',',',$CantGanaE_AU)."</strong></td>";
		echo "<td colspan='6'>&nbsp;</td>";
		echo "</tr>";
	}
	?>
	</table>	
</form>
</body>
</html>
