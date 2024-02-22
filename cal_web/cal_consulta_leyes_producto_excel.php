<?php   
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

	if(isset($_REQUEST["Buscar"])) {
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar =  "";
	}
	if(isset($_REQUEST["Leyes"])) {
		$Leyes = $_REQUEST["Leyes"];
	}else{
		$Leyes =  "";
	}
	if(isset($_REQUEST["Limite"])) {
		$Limite = $_REQUEST["Limite"];
	}else{
		$Limite =  "";
	}
	if(isset($_REQUEST["CmbAno"])) {
		$CmbAno = $_REQUEST["CmbAno"];
	}else{
		$CmbAno =  date("Y");
	}
	if(isset($_REQUEST["CmbMes"])) {
		$CmbMes = $_REQUEST["CmbMes"];
	}else{
		$CmbMes = date("m");
	}
	if(isset($_REQUEST["CmbDias"])) {
		$CmbDias = $_REQUEST["CmbDias"];
	}else{
		$CmbDias =  date("d");
	}
	if(isset($_REQUEST["CmbAnoT"])) {
		$CmbAnoT = $_REQUEST["CmbAnoT"];
	}else{
		$CmbAnoT =  date("Y");
	}
	if(isset($_REQUEST["CmbMesT"])) {
		$CmbMesT = $_REQUEST["CmbMesT"];
	}else{
		$CmbMesT = date("m");
	}
	if(isset($_REQUEST["CmbDiasT"])) {
		$CmbDiasT = $_REQUEST["CmbDiasT"];
	}else{
		$CmbDiasT =  date("d");
	}
	
	$TxtLeyes=$Leyes;
	$LimitIni=$Limite;
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 32;
	include("../principal/conectar_principal.php");
?>
<html>
<head>
<title>Consulta Analisis por Producto</title>
</head>
<body>
<form name="FrmConsultaAnalisisProducto" method="post" action="">
  <table>
    <tr>
      <td> <br>
		<?php
			if (($Buscar=='S') and ($TxtLeyes!=''))
			{
				if (($CmbAno=="") || ($CmbMes=="")|| ($CmbDias==""))
				{
					$FechaI=date("Y-m-d")." 00:00:01";
					$FechaT=date("Y-m-d")." 23:59:59";
				}
				else
				{
					$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
					$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
				}	
				
				$ArregloAux=explode('-',$TxtLeyes);
				reset($ArregloAux);
				$Arreglo=array();
				$Largo=count($ArregloAux);
				for ($i=0;$i<$Largo;$i++)
				{
					$Consulta="select abreviatura from proyecto_modernizacion.leyes where cod_leyes=".$ArregloAux[$i];
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Arreglo[$ArregloAux[$i]][0]=$Fila["abreviatura"];
					$Arreglo[$ArregloAux[$i]][1]=$ArregloAux[$i];
				}
				if (count($Arreglo))
				{				
					
					echo "<table border='1'>";
					echo "<tr align='center'>";
					echo "<td >Producto</td>";
					echo "<td >SubProducto</td>";
					reset($Arreglo);
					ksort($Arreglo);
					//while(list($Clave,$Valor)=each($Arreglo))
					foreach($Arreglo as $Clave => $Valor)
					{
						echo "<td align='center'>";
						if ($Valor[0]!='')
						{
							echo $Valor[0];
							//$CodLeyes=$CodLeyes." t2.cod_leyes='".$Valor[1]."' or ";
							$CodLeyes=" t2.cod_leyes='".$Valor[1]."' or ";
						}
						else
						{
							echo "&nbsp;";
						}	
						echo "</td>";
					}
					$CodLeyes=substr($CodLeyes,0,strlen($CodLeyes)-3);
					// apura consulta
					$ConsTB = "SHOW TABLES FROM `cal_web`";
					$RespTB = mysqli_query($link, $ConsTB);
					while ($FilaTB = mysqli_fetch_array($RespTB))
					{
						if ($FilaTB["Tables_in_cal_web"] == "tmp_paso_leyes")
						{
							$Borra = "DROP TABLE cal_web.tmp_paso_leyes";
							mysqli_query($link, $Borra);
							
						}
					}
					$Consulta="CREATE TABLE cal_web.tmp_paso_leyes SELECT * FROM cal_web.solicitud_analisis ";
					$Consulta.=" where not isnull(nro_solicitud)  and estado_actual !='7' and estado_actual !='16' AND  fecha_hora BETWEEN '".$FechaI."' and '".$FechaT."' ";
					mysqli_query($link, $Consulta);
					// hasta aca
					echo "</tr>";
					
					//------QUERY MODIFICADA EN EL GROUP ANTES group by t2.producto,t3.subproducto ahora group by producto,subproducto
					//------ADEMAS LA TABLA PRINCIPAL NO ESTA REFERENCIADA CON t1
					//------DVS / LRC 13-06-2014
					$Consulta="SELECT distinct t1.cod_producto,t1.cod_subproducto,t2.descripcion as producto,t3.descripcion as subproducto from cal_web.tmp_paso_leyes t1"; //cal_web.solicitud_analisis t1 ";
					$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
					$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
					$Consulta=$Consulta." where not isnull(t1.nro_solicitud)  and ";
					$Consulta.=" t1.fecha_hora BETWEEN '".$FechaI."' and '".$FechaT."' group by producto,subproducto";
					$Respuesta2=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta2))
					{
						echo "<tr>";
						echo "<td align='left'>".$Fila["producto"]."</td>";
						echo "<td align='left'>".$Fila["subproducto"]."</td>";
						$Consulta="select t2.cod_leyes,count(t2.cod_leyes)as total from cal_web.tmp_paso_leyes t1 inner join cal_web.leyes_por_solicitud t2 on ";
						$Consulta=$Consulta." t1.rut_funcionario=t2.rut_funcionario and t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo";
						$Consulta=$Consulta." inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes=t3.cod_leyes ";
						$Consulta=$Consulta." where t1.cod_producto=".$Fila["cod_producto"]." and t1.cod_subproducto=".$Fila["cod_subproducto"]." and ";
						$Consulta.=" (".$CodLeyes.") and t1.fecha_hora between '".$FechaI."' and '".$FechaT."' group by t2.cod_leyes";
						$Respuesta3=mysqli_query($link, $Consulta);
						reset($Arreglo);
						//while(list($Clave,$Valor)=each($Arreglo))
						foreach($Arreglo as $Clave => $Valor)
						{
							$Arreglo[$Clave][0]="&nbsp;";
							$Arreglo[$Clave][1]="&nbsp;";				
						}
						while($FilaLeyes=mysqli_fetch_array($Respuesta3))
						{
							$Arreglo[$FilaLeyes["cod_leyes"]][0]='*';
							$Arreglo[$FilaLeyes["cod_leyes"]][1]='*';
						}
						reset($Arreglo);
						ksort($Arreglo);
						//while(list($Clave,$Valor)=each($Arreglo))
						foreach($Arreglo as $Clave => $Valor)
						{
							echo "<td align='center'>";
							echo $Valor[1];
							echo "</td>";
						}
						echo "</tr>";
					}
					echo "</table>";
				}	
			}	
		?>
		<br>
        <br>
	  </td>
	</tr>
  </table>
  </form>
</body>
</html>
