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
	include("../principal/conectar_sec_web.php");

	$TipoIE = isset($_REQUEST["TipoIE"])?$_REQUEST["TipoIE"]:"Normal";

?>
<html>
<head>
</script>
<title>Administrador del Programa de Loteo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProgLoteo" method="post" action="">
  <table>
  <tr>
      <td align="center" valign="top"><br>
	  <table width="730" border="1">
          <tr>
		  <?php
			if (($TipoIE=='Normal')||($TipoIE=='Completas'))
			{
				echo "<td width='20' align='center'>N�</td>";
				echo "<td width='45' align='center'>I.E</td>";
				echo "<td width='115' align='center'>SubProducto</td>";
				echo "<td width='175' align='center'>Nave/Cliente</td>";
				echo "<td width='65' align='center'>Fecha Emb</td>";
				echo "<td width='60' align='right'>Peso Prog</td>";
				echo "<td width='60' align='center'>Peso Pre</td>";
				echo "<td width='50' align='center'>Dif.</td>";
				echo "<td width='60' align='center'>N� Lote</td>";
			}
			else
			{
				echo "<td width='12' align='center'>I.E</td>";
				echo "<td width='200' align='center'>SubProducto</td>";
				echo "<td width='70' align='center'>Fecha Emb</td>";
				echo "<td width='60' align='right'>Peso Prog.</td>";
				echo "<td width='70' align='center'>Peso Prep.</td>";
				echo "<td width='70' align='center'>Diferencia</td>";
				echo "<td width='60' align='center'>N� Lote</td>";
			}	
		  ?>	
          </tr>
        </table>
		<?php
			echo "<table width='730' border='1' >";
			switch ($TipoIE)
			{
				case "Normal":
					$CrearTmp ="create temporary table if not exists sec_web.tmpprograma "; 
					$CrearTmp =$CrearTmp."(corr_ie bigint(8),cliente_nave varchar(30),fecha date,fecha_programacion date,";
					$CrearTmp =$CrearTmp."cantidad_programada bigint(8),num_prog_loteo varchar(3),cod_producto varchar(10),producto varchar(30),";
					$CrearTmp =$CrearTmp."cod_subproducto varchar(10),subproducto varchar (30),pto_destino varchar (30),pto_emb varchar (30),";
					$CrearTmp =$CrearTmp."tipo char(1),cod_contrato varchar(10),estado char(1),estado2 char(1),fecha_disponible date,tipoie char(1),descripcion varchar(255))";
					mysqli_query($link, $CrearTmp);
					//CONSULTA TABLA PROGRAMA ENAMI
					$Consulta="SELECT t1.descripcion,t1.cod_producto,t1.cod_subproducto,t1.fecha_disponible,t1.estado2,t1.estado1,";
					$Consulta=$Consulta."t6.descripcion as producto,t2.descripcion as subproducto,t3.nom_aero_puerto as pto_emb,t4.nom_aero_puerto as pto_destino,";
					$Consulta=$Consulta."(case when not isnull(t6.nombre_nave) then t6.nombre_nave else t5.sigla_cliente end) as nombre_cliente,";					
					$Consulta=$Consulta."t1.eta_programada,t1.corr_enm,t1.cantidad_embarque,t1.num_prog_loteo";
					$Consulta=$Consulta." from sec_web.programa_enami t1";
					$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
					$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
					$Consulta=$Consulta." left join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto ";
					$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto_destino=t4.cod_puerto ";
					$Consulta=$Consulta." left join sec_web.cliente_venta t5 on t1.cod_cliente=t5.cod_cliente ";
					$Consulta=$Consulta." left join sec_web.nave t6 on t1.cod_nave=t6.cod_nave ";
					$Consulta=$Consulta." where t1.estado2 <>'C' and t1.estado2 <>'A' and ((t1.num_prog_loteo <>'')||(not isnull(t1.num_prog_loteo)))";
					$Resultado=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resultado))
					{
						$Insertar="INSERT INTO sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,num_prog_loteo ,cod_producto,producto,cod_subproducto,subproducto,pto_destino ,pto_emb,tipo,estado,estado2,fecha_disponible,tipoie,descripcion) values(";
						//$Insertar=$Insertar."$Fila["corr_enm"],'".$Fila["nombre_cliente"]."','".$Fila["cantidad_embarque"]."','".$Fila["num_prog_loteo"]."','".$Fila["cod_producto"]."','".$Fila["producto"]."','".$Fila["cod_subproducto"]."','".$Fila["subproducto"]."','".$Fila["pto_destino"]."','".$Fila["pto_emb"]."','E','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["fecha_disponible"]."','E','$Fila["descripcion"]')";
						$Insertar=$Insertar." '".$Fila["corr_enm"]."','".$Fila["nombre_cliente"]."','".$Fila["cantidad_embarque"]."','".$Fila["num_prog_loteo"]."','".$Fila["cod_producto"]."','".$Fila["producto"]."','".$Fila["cod_subproducto"]."','".$Fila["subproducto"]."','".$Fila["pto_destino"]."','".$Fila["pto_emb"]."','E','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["fecha_disponible"]."','E','".$Fila["descripcion"]."')";

						mysqli_query($link, $Insertar);
					}
					//CONSULTA TABLA PROGRAMA CODELCO
					$Consulta="SELECT t1.descripcion,t1.cod_producto,t1.cod_subproducto,t1.fecha_disponible,t1.estado1,t1.estado2,(case when not isnull(t3.nombre_cliente) then t3.nombre_cliente else t4.nombre_nave end) as nombre_cliente,t1.corr_codelco,t6.descripcion as producto,t2.descripcion as subproducto,t1.cantidad_programada,t1.num_prog_loteo";
					$Consulta=$Consulta." from sec_web.programa_codelco  t1";
					$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
					$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
					$Consulta=$Consulta." left join sec_web.cliente_venta t3 on t1.cod_cliente=t3.cod_cliente ";
					$Consulta=$Consulta." left join sec_web.nave t4 on ceiling(t1.cod_cliente)=t4.cod_nave ";
					$Consulta=$Consulta." where t1.estado2 <>'C' and t1.estado2 <>'A' and ((t1.num_prog_loteo <>'')||(not isnull(t1.num_prog_loteo)))";
					$Resultado=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resultado))
					{
						$Insertar="INSERT INTO sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,num_prog_loteo ,cod_producto,producto,cod_subproducto,subproducto,tipo,estado,estado2,fecha_disponible,tipoie,descripcion) values(";
						//$Insertar=$Insertar."$Fila["corr_codelco"],'".$Fila["nombre_cliente"]."',$Fila["cantidad_programada"],'".$Fila["num_prog_loteo"]."','".$Fila["cod_producto"]."','".$Fila["producto"]."','".$Fila["cod_subproducto"]."','".$Fila["subproducto"]."','C','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["fecha_disponible"]."','C','$Fila["descripcion"]')";
						$Insertar=$Insertar." '".$Fila["corr_codelco"]."','".$Fila["nombre_cliente"]."','".$Fila["cantidad_programada"]."','".$Fila["num_prog_loteo"]."','".$Fila["cod_producto"]."','".$Fila["producto"]."','".$Fila["cod_subproducto"]."','".$Fila["subproducto"]."','C','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["fecha_disponible"]."','C','".$Fila["descripcion"]."')";
						mysqli_query($link, $Insertar);   
					}
					$Consulta="SELECT * from sec_web.tmpprograma where estado <> 'T' order by fecha_disponible";
					break;
				case "Virtual":
					$CrearTmp ="create temporary table if not exists sec_web.tmpprograma "; 
					$CrearTmp =$CrearTmp."(corr_ie bigint(8),cantidad_programada bigint(8),fecha_disponible date,";
					$CrearTmp =$CrearTmp."cod_producto varchar(10),producto varchar(30),";
					$CrearTmp =$CrearTmp."cod_subproducto varchar(10),subproducto varchar(30))";
					mysqli_query($link, $CrearTmp);
					//CONSULTA LAS VIRTUALES
					$Consulta="SELECT t1.corr_virtual,t1.peso_programado,t1.fecha_embarque,t1.cod_producto,t1.cod_subproducto,t6.descripcion as nombre_producto,t2.descripcion as nombre_subproducto ";
					$Consulta=$Consulta." from sec_web.instruccion_virtual t1";
					$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
					$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
					$Resultado=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resultado))
					{
						$Insertar="INSERT INTO sec_web.tmpprograma (corr_ie,cantidad_programada,producto,cod_producto,subproducto,cod_subproducto,fecha_disponible) values(";
						//$Insertar=$Insertar."$Fila[corr_virtual],$Fila["peso_programado"],'$Fila["nombre_producto"]','".$Fila["cod_producto"]."','$Fila["nombre_subproducto"]','".$Fila["cod_subproducto"]."','$Fila["fecha_embarque"]')";
						$Insertar=$Insertar." '".$Fila["corr_virtual"]."','".$Fila["peso_programado"]."','".$Fila["nombre_producto"]."','".$Fila["cod_producto"]."','".$Fila["nombre_subproducto"]."','".$Fila["cod_subproducto"]."','".$Fila["fecha_embarque"]."')";

						mysqli_query($link, $Insertar);   
					}
					$Consulta="SELECT * from sec_web.tmpprograma order by corr_ie";	
					break;
				/*case "Completas":
					$CrearTmp ="create temporary table if not exists sec_web.tmpprograma "; 
					$CrearTmp =$CrearTmp."(corr_ie bigint(8),cliente_nave varchar(30),fecha date,fecha_programacion date,";
					$CrearTmp =$CrearTmp."cantidad_programada bigint(8),num_prog_loteo varchar(3),cod_producto varchar(10),producto varchar(30),";
					$CrearTmp =$CrearTmp."cod_subproducto varchar(10),subproducto varchar (30),pto_destino varchar (30),pto_emb varchar (30),";
					$CrearTmp =$CrearTmp."tipo char(1),cod_contrato varchar(10),estado char(1),estado2 char(1),fecha_disponible date,tipoie char(1))";
					mysqli_query($link, $CrearTmp);
					//CONSULTA TABLA PROGRAMA ENAMI
					$Consulta="SELECT t1.cod_producto,t1.cod_subproducto,t1.fecha_disponible,t1.estado2,t1.estado1,t6.descripcion as producto,t2.descripcion as subproducto,t3.nom_aero_puerto as pto_emb,t4.nom_aero_puerto as pto_destino,t5.sigla_cliente,";
					$Consulta=$Consulta."t1.eta_programada,t1.corr_enm,t1.cantidad_embarque,t1.num_prog_loteo";
					$Consulta=$Consulta." from sec_web.programa_enami t1";
					$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
					$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
					$Consulta=$Consulta." left join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto ";
					$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto_destino=t4.cod_puerto ";
					$Consulta=$Consulta." left join sec_web.cliente_venta t5 on t1.cod_cliente=t5.cod_cliente ";
					$Consulta=$Consulta." where t1.estado2 ='T' and ((t1.num_prog_loteo <>'')||(not isnull(t1.num_prog_loteo)))";
					$Resultado=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resultado))
					{
						$Insertar="INSERT INTO sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,num_prog_loteo ,cod_producto,producto,cod_subproducto,subproducto,pto_destino ,pto_emb,tipo,estado,estado2,fecha_disponible,tipoie) values(";
						$Insertar=$Insertar."$Fila["corr_enm"],'".$Fila["sigla_cliente"]."','".$Fila["cantidad_embarque"]."','".$Fila["num_prog_loteo"]."','".$Fila["cod_producto"]."','".$Fila["producto"]."','".$Fila["cod_subproducto"]."','".$Fila["subproducto"]."','".$Fila["pto_destino"]."','".$Fila["pto_emb"]."','E','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["fecha_disponible"]."','E')";
						mysqli_query($link, $Insertar);
					}
					//CONSULTA TABLA PROGRAMA CODELCO
					$Consulta="SELECT t1.cod_producto,t1.cod_subproducto,t1.fecha_disponible,t1.estado1,t1.estado2,(case when not isnull(t3.nombre_cliente) then t3.nombre_cliente else t4.nombre_nave end) as nombre_cliente,t1.corr_codelco,t6.descripcion as producto,t2.descripcion as subproducto,t1.cantidad_programada,t1.num_prog_loteo";
					$Consulta=$Consulta." from sec_web.programa_codelco  t1";
					$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
					$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
					$Consulta=$Consulta." left join sec_web.cliente_venta t3 on t1.cod_cliente=t3.cod_cliente ";
					$Consulta=$Consulta." left join sec_web.nave t4 on ceiling(t1.cod_cliente)=t4.cod_nave ";
					$Consulta=$Consulta." where t1.estado2 ='T' and ((t1.num_prog_loteo <>'')||(not isnull(t1.num_prog_loteo)))";
					$Resultado=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resultado))
					{
						$Insertar="INSERT INTO sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,num_prog_loteo ,cod_producto,producto,cod_subproducto,subproducto,tipo,estado,estado2,fecha_disponible,tipoie) values(";
						$Insertar=$Insertar."$Fila["corr_codelco"],'".$Fila["nombre_cliente"]."',$Fila["cantidad_programada"],'".$Fila["num_prog_loteo"]."','".$Fila["cod_producto"]."','".$Fila["producto"]."','".$Fila["cod_subproducto"]."','".$Fila["subproducto"]."','C','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["fecha_disponible"]."','C')";
						mysqli_query($link, $Insertar);   
					}
					$Consulta="SELECT * from sec_web.tmpprograma order by fecha_disponible";
					break;*/	
			}	
			$Respuesta=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckProgLoteo'><input type='hidden' name ='NumProgLoteo'><input type='hidden' name='CheckFecha'><input type='hidden' name='OptSeleccionar'>";
			$Cont2=0;//WSO
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if (($TipoIE=='Normal')||($TipoIE=='Completas'))
				{
					/*if ($Valor["estado"]=='A')
					{
						echo "<tr class='colortabla04'>"; 
					}
					else
					{
						if ($Valor["estado"]=='M')
						{
							echo "<tr class='colortabla03'>";
						}	 							
						else
						{*/					
							echo "<tr>";
						//}	 
					//}
					if ($Fila["estado2"]=='R')
					{
						$Consulta="SELECT t1.cod_bulto,t1.num_bulto,t1.cod_marca,sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on ";
						$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
						$Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_ie"]." and t1.cod_estado='a' and t2.cod_estado='a' group by t1.corr_enm,t1.cod_bulto,t1.num_bulto";
						$Respuesta2=mysqli_query($link, $Consulta);
						$Fila2=mysqli_fetch_array($Respuesta2);
					}	
					//$MostrarBoton=true;
					$Cont2++;
					//echo "<td width='10' align='center'><input type='radio' name='OptSeleccionar' value='".$Fila["corr_ie"]."~~".$Fila["producto"]."~~".$Fila["subproducto"]."~~".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."~~".($Fila["cantidad_programada"]*1000)."~~".$Fila[tipoie]."~~".$Fila2["peso_preparado"]."~~".$Fila2["cod_bulto"]."~~".$Fila2["num_bulto"]."~~".$Fila2["cod_marca"]."'></td>";
					echo "<td width='40' align='center'>".$Fila["num_prog_loteo"]."</td>";
					echo "<td>".$Fila["corr_ie"]."</td>";
					echo "<td width='160'>".$Fila["subproducto"]."&nbsp;</td>";
					echo "<td width='160'>".$Fila["cliente_nave"]."&nbsp;</td>";
					echo "<td width='100' align='center'>".$Fila["fecha_disponible"]."</td>";
					echo "<td width='60' align='right'>".($Fila["cantidad_programada"]*1000)."</td>";
					echo "<td width='60' align='right'>".$Fila2["peso_preparado"]."&nbsp;</td>";
					echo "<td width='60' align='right'>".abs($Fila["cantidad_programada"]*1000-$Fila2["peso_preparado"])."&nbsp;</td>";
					if ($Fila2["cod_bulto"]!="")
					{
						echo "<td width='60' align='right'><a href=\"JavaScript:MostrarPaquetes('".$Fila2["cod_bulto"]."','".$Fila2["num_bulto"]."','".$Fila["corr_ie"]."')\">\n";
						echo $Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."</a></td>\n";
					}
					else
					{
						echo "<td width='60' align='right'>&nbsp;</td>";
					}					
					//echo "<td width='40' align='center'>".$Fila["estado"]."&nbsp;</td>";
					$Fila2["cod_bulto"]="";
					$Fila2["num_bulto"]="";
					$Fila2["peso_preparado"]="";
					$Fila2["marca"]="";
					$Fila2["disponibilidad"]="";
				}
				else
				{
						$Consulta="SELECT t1.cod_bulto,t1.num_bulto,t1.cod_marca,sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on ";
						$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
						$Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_ie"]." and t1.cod_estado='a' and t2.cod_estado='a' group by t1.corr_enm,t1.cod_bulto,t1.num_bulto";
						$Respuesta2=mysqli_query($link, $Consulta);
						$Fila2=mysqli_fetch_array($Respuesta2);
						$Cont2++;
						echo "<td width='40'>".$Fila["corr_ie"]."</td>";
						echo "<td width='260'>".$Fila["subproducto"]."&nbsp;</td>";
						echo "<td width='100' align='center'>".$Fila["fecha_disponible"]."</td>";
						echo "<td width='80' align='right'>".$Fila["cantidad_programada"]."</td>";
						if(!is_null($Fila2) && is_array($Fila2) && isset($Fila2["peso_preparado"])){
							$pesoprepa = $Fila2["peso_preparado"];
						}else{
							$pesoprepa = 0;
						}
						//echo "<td width='100' align='right'>".$Fila2["peso_preparado"]."&nbsp;</td>";
						//echo "<td width='100' align='right'>".abs($Fila["cantidad_programada"]-$Fila2["peso_preparado"])."&nbsp;</td>";
						echo "<td width='100' align='right'>".$pesoprepa."&nbsp;</td>";
						echo "<td width='100' align='right'>".abs($Fila["cantidad_programada"]-$pesoprepa)."&nbsp;</td>";
						if(!is_null($Fila2) && is_array($Fila2) && isset($Fila2["cod_bulto"])){
							$codbulto = $Fila2["cod_bulto"];
						}else{
							$codbulto = "";
						}
						//if ($Fila2["cod_bulto"]!="")
						if ($codbulto!="")
						{
							echo "<td width='80' align='right'><a href=\"JavaScript:MostrarPaquetes('".$Fila2["cod_bulto"]."','".$Fila2["num_bulto"]."','".$Fila["corr_ie"]."')\">\n";
							echo $Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."</a></td>\n";
						}
						else
						{
							echo "<td width='80' align='right'>&nbsp;</td>";
						}
				}	
				echo "</tr>";
			}
			echo "</table>";	
		?>
		<br>
      </td>
  </tr>
</table>
</form>
</body>
</html>
