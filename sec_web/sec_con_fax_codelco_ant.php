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
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$Consulta = "SELECT ifnull(max(corr_fax)+1,1) as corrfax from sec_web.control_fax ";
	$Consulta.=" where YEAR(fecha_hora) = year(now())	";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$CorrFax=$Fila[corrfax];
	//echo $Consulta."<br>";
	$Rut =$CookieRut;
?>
<html>
<head>
</script>
<title>FAX CODELCO</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProgLoteo" method="post" action="">
  <table>
  <tr>
      <td align="center" valign="top"><br>
  	    <table width="730" border="0" cellpadding="3" cellspacing="1">
		  <tr>
		  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		  <td colspan="2" align="right"><img src="../principal/imagenes/letras_codelco_2.jpg" width="170" height="50"></td>
		  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		  </tr>	
		  <tr><td colspan="8"></td></tr>	
		  <tr><td colspan="8"></td></tr>	
		  <tr><td colspan="8"></td></tr>		
		  <tr><td colspan="8"><h4>VENTANAS&nbsp;<?php echo date('d');?> DE <?php echo strtoupper($meses[date('n')-1]);?> DE <?php echo date('Y');?></h4></td></tr>	
		  <tr><td colspan="8"></td></tr>	
		  <tr><td colspan="8"></td></tr>	
          <tr><td colspan="8" align="center"><h4><strong>FAX N�&nbsp;<?php echo $CorrFax;?>/<?php echo date('Y')?>&nbsp;DEFINITIVO</strong></h4></td></tr>
		  <tr><td colspan="8"></td></tr>
		  <tr><td colspan="8"></td></tr>
		  <tr><td colspan="8"></td></tr>
		  <tr><td colspan="8"><h4><strong>A&nbsp;&nbsp;&nbsp;AGENCIA DE ADUANA</strong></h4></td></tr>
		  <tr><td colspan="8"><h4>C.C.&nbsp;&nbsp;&nbsp;ADMINISTRACION CONTRATOS VENTAS</h4></td></tr>	
		  <tr><td colspan="8"><h4>.C&nbsp;&nbsp;&nbsp;RECEPCIONA Y CONSOLIDA&nbsp;<?php echo $Prestador;?></h4></td></tr>
		  <tr><td colspan="8"><h4>C.C&nbsp;&nbsp;&nbsp;ESTIBA&nbsp;<?php echo $Estibador;?></h4></td></tr>
		  <tr><td colspan="8"><h4>DE&nbsp;&nbsp;&nbsp;DIVISION VENTANAS</h4></td></tr>
		  <tr><td colspan="8"></td></tr>
		  <tr><td colspan="8"><h4>REF&nbsp;&nbsp;&nbsp;EMBARQUE</h4></td></tr>
		  <tr><td colspan="8"><h4>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Nave;?></h4></td></tr>
        </table>
		<br>
		<br>  		  
  	    <table width="730" border="1" cellpadding="3" cellspacing="0">
          <tr>
		  <?php
			echo "<td width='40' align='center'>IE</td>";
			echo "<td width='120' align='center'>CLIENTE/NAVE</td>";
			echo "<td width='100' align='center'>PUERTO DESTINO</td>";
			echo "<td width='70' align='right'>MARCA</td>";
			echo "<td width='50' align='center'>PAQ</td>";
			echo "<td width='60' align='center'>UNID</td>";
			echo "<td width='60' align='center'>NETO KG</td>";
			echo "<td width='60' align='center'>BRUTO KG</td>";
			echo "<td width='60' align='center'>CONTRATO</td>";
			echo "<td width='60' align='center'>CUOTA</td>";
			echo "<td width='60' align='center'>PARTIDA</td>";
		  ?>	
          </tr>
		<?php			
			$Datos=explode('//',$ValoresCheck);
			$TotalPaquete=0;
			$TotalUnidades=0;
			$TotalNeto=0;
			$TotalBruto=0;
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				$IE=$Datos2[0];
				$Codigo=$Datos2[1];//COD_VIA_TRANSPORTE
				$Envio=$Datos2[2];
				//if($Codigo=='01')
				//{
					$FechaHora=date('Y-m-d H:i:s');
					$Insertar="insert into sec_web.control_fax(num_envio,corr_fax,tipo,fecha_hora,rut) values (";
					$Insertar.=" '".$Envio."','".$CorrFax."','C','".$FechaHora."','".$Rut."')";
					mysqli_query($link, $Insertar);
					$Consulta="SELECT t7.cod_contrato,t7.mes_cuota,t7.partida,t1.corr_enm as ie,t1.bulto_paquetes,t1.bulto_peso,t1.cod_bulto,t1.num_bulto,";
					$Consulta=$Consulta." t4.nom_aero_puerto as puerto,t2.descripcion as marca,t3.sigla_cliente as cliente,t5.nombre_nave as cliente from sec_web.embarque_ventana t1 "; 
					$Consulta=$Consulta." left join sec_web.marca_catodos t2 on t1.cod_marca=t2.cod_marca";
					$Consulta=$Consulta." left join sec_web.cliente_venta t3 on t1.cod_cliente=t3.cod_cliente";
					$Consulta=$Consulta." left join sec_web.nave t5 on t1.cod_cliente=t5.cod_nave			";
					$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto=t4.cod_puerto";
					$Consulta=$Consulta." left join sec_web.programa_codelco t7 on t1.corr_enm=t7.corr_codelco ";
					$Consulta=$Consulta." where corr_enm=".$IE." order by t1.corr_enm";
					//echo $Consulta;
					$Respuesta=mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo "<tr>";
						$Consulta="SELECT sum(t2.num_unidades) as unidades from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
						$Consulta=$Consulta." on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete";
						$Consulta=$Consulta." where t1.cod_bulto='".$Fila["cod_bulto"]."' and t1.num_bulto=".$Fila["num_bulto"]." and t1.corr_enm=".$Fila["ie"];
						$Respuesta2=mysqli_query($link, $Consulta);
						$Fila2=mysqli_fetch_array($Respuesta2);
						echo "<td width='40' align='center'>".$Fila[ie]."</td>";
						echo "<td width='120'>".$Fila[cliente]."</td>";
						echo "<td width='100'>".$Fila[puerto]."&nbsp;</td>";
						echo "<td width='100'>".$Fila[marca]."&nbsp;</td>";
						echo "<td width='60' align='center'>".number_format($Fila["bulto_paquetes"],0,',','.')."&nbsp;</td>";
						echo "<td width='60' align='right'>".number_format($Fila2["unidades"],0,',','.')."&nbsp;</td>";
						echo "<td width='60' align='right'>".number_format($Fila["bulto_peso"],0,',','.')."&nbsp;</td>";
						echo "<td width='60' align='right'>".number_format(($Fila["bulto_peso"]+$Fila["bulto_paquetes"]),0,',','.')."&nbsp;</td>";
						echo "<td width='100'>".$Fila["cod_contrato"]."&nbsp;</td>";
						echo "<td width='100'>".$Fila["mes_cuota"]."&nbsp;</td>";
						echo "<td width='100'>".$Fila[partida]."&nbsp;</td>";
						echo "</tr>";
						$TotalPaquete=$TotalPaquete+$Fila["bulto_paquetes"];
						$TotalUnidades=$TotalUnidades+$Fila2["unidades"];
						$TotalNeto=$TotalNeto+$Fila["bulto_peso"];
						$TotalBruto=$TotalBruto+($Fila["bulto_peso"]+$Fila["bulto_paquetes"]);
					}
				//}
			}
			echo "<tr height='20'>";
			echo "<td width='40' align='center'>&nbsp;</td>";
			echo "<td width='120'>&nbsp;</td>";
			echo "<td width='100'>&nbsp;</td>";
			echo "<td width='100'>&nbsp;</td>";
			echo "<td width='60' align='center'>".number_format($TotalPaquete,0,',','.')."&nbsp;</td>";
			echo "<td width='60' align='right'>".number_format($TotalUnidades,0,',','.')."&nbsp;</td>";
			echo "<td width='60' align='right'>".number_format($TotalNeto,0,',','.')."&nbsp;</td>";
			echo "<td width='60' align='right'>".number_format($TotalBruto,0,',','.')."&nbsp;</td>";
			echo "</tr>";						
			echo "</table>";	
		?>
		<br>
   <!--   </td>
  </tr>-->
</table>
</form>
</body>
</html>
