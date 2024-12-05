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
	$Error  = isset($_REQUEST["Error"])?$_REQUEST["Error"]:"Error";
	$Salir  = isset($_REQUEST["Salir"])?$_REQUEST["Salir"]:"";
	$Msj    = isset($_REQUEST["Msj"])?$_REQUEST["Msj"]:"";

?>
<html>
<head>
<title>IE Avances de Programa</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProgLoteo" method="post" action="">
  <table width="770" height="350" border="0" left="5" cellpadding="5" cellspacing="0">
  <tr>
      <td align="center"><br>
	  <table width="730" border="1" cellpadding="3" cellspacing="0">
          <tr>
		  <?php
			if (($TipoIE=='Normal')||($TipoIE=='NormalVentanas'))
			{
				echo "<td width='20' align='center'>N&deg;</td>";
				echo "<td width='45' align='center'>I.E</td>";
				echo "<td width='115' align='center'>SubProducto</td>";
				echo "<td width='175' align='center'>Nave/Cliente</td>";
				echo "<td width='65' align='center'>Fecha Emb</td>";
				echo "<td width='60' align='right'>Peso Prog</td>";
				echo "<td width='60' align='center'>Peso Pre</td>";
				echo "<td width='50' align='center'>Dif.</td>";
				echo "<td width='60' align='center'>N&deg; Lote</td>";
				echo "<td width='30' align='center'>Est.</td>";
			}
		  ?>	
          </tr>
        </table>
		<?php
			echo "<table width='730' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			switch ($TipoIE)
			{
				case "Normal":
					$CrearTmp ="CREATE temporary table if not exists sec_web.tmpprograma "; 
					$CrearTmp =$CrearTmp."(corr_ie bigint(8),cliente_nave varchar(30),fecha date,fecha_programacion date,";
					$CrearTmp =$CrearTmp."cantidad_programada double,num_prog_loteo varchar(3),cod_producto varchar(10),producto varchar(30),";
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
					$Consulta=$Consulta." where t1.tipo <> 'V' and t1.estado2 <>'C' and ((t1.num_prog_loteo <>'')||(not isnull(t1.num_prog_loteo)))";
					$Resultado=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resultado))
					{
						if (($Fila["estado1"]=='')&&($Fila["estado2"]=='A'))
						{
						}
						else
						{
							$Insertar="INSERT INTO sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,num_prog_loteo ,cod_producto,producto,cod_subproducto,subproducto,pto_destino ,pto_emb,tipo,estado,estado2,fecha_disponible,tipoie,descripcion) values(";
							$Insertar=$Insertar."'".$Fila["corr_enm"]."','".$Fila["nombre_cliente"]."','".$Fila["cantidad_embarque"]."','".$Fila["num_prog_loteo"]."','".$Fila["cod_producto"]."','".$Fila["producto"]."','".$Fila["cod_subproducto"]."','".$Fila["subproducto"]."','".$Fila["pto_destino"]."','".$Fila["pto_emb"]."','E','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["fecha_disponible"]."','E','".$Fila["descripcion"]."')";
							mysqli_query($link, $Insertar);
						}	
					}
					//CONSULTA TABLA PROGRAMA CODELCO
					$Consulta="select t1.descripcion,t1.cod_producto,t1.cod_subproducto,t1.fecha_disponible,t1.estado1,t1.estado2,(case when not isnull(t3.nombre_cliente) then t3.nombre_cliente else t4.nombre_nave end) as nombre_cliente,t1.corr_codelco,t6.descripcion as producto,t2.descripcion as subproducto,t1.cantidad_programada,t1.num_prog_loteo";
					$Consulta=$Consulta." from sec_web.programa_codelco  t1";
					$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
					$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
					$Consulta=$Consulta." left join sec_web.cliente_venta t3 on t1.cod_cliente=t3.cod_cliente ";
					$Consulta=$Consulta." left join sec_web.nave t4 on ceiling(t1.cod_cliente)=t4.cod_nave ";
					$Consulta=$Consulta." where t1.estado2 <>'C' and ((t1.num_prog_loteo <>'') and (t1.num_prog_loteo <>'0') and (not isnull(t1.num_prog_loteo)))";
					$Resultado=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resultado))
					{
						if (($Fila["estado1"]=='')&&($Fila["estado2"]=='A'))
						{
						}
						else
						{
							$Insertar="INSERT INTO sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,num_prog_loteo ,cod_producto,producto,cod_subproducto,subproducto,tipo,estado,estado2,fecha_disponible,tipoie,descripcion) values(";
							$Insertar=$Insertar."'".$Fila["corr_codelco"]."','".$Fila["nombre_cliente"]."','".$Fila["cantidad_programada"]."','".$Fila["num_prog_loteo"]."','".$Fila["cod_producto"]."','".$Fila["producto"]."','".$Fila["cod_subproducto"]."','".$Fila["subproducto"]."','C','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["fecha_disponible"]."','C','".$Fila["descripcion"]."')";
							mysqli_query($link, $Insertar);
						}	   
					}
					$Consulta="select * from sec_web.tmpprograma where estado <> 'T' order by fecha_disponible";
					break;
				case "NormalVentanas":
					$CrearTmp ="CREATE temporary table if not exists sec_web.tmpprograma "; 
					$CrearTmp =$CrearTmp."(corr_ie bigint(8),cliente_nave varchar(30),fecha date,fecha_programacion date,";
					$CrearTmp =$CrearTmp."cantidad_programada double(10,3),num_prog_loteo varchar(3),cod_producto varchar(10),producto varchar(30),";
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
					$Consulta=$Consulta." where t1.estado2 <>'C' and t1.tipo='V'";
					$Resultado=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resultado))
					{
						$Insertar="INSERT INTO sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,num_prog_loteo ,cod_producto,producto,cod_subproducto,subproducto,pto_destino ,pto_emb,tipo,estado,estado2,fecha_disponible,tipoie) values(";
						$Insertar=$Insertar."'".$Fila["corr_enm"]."','".$Fila["sigla_cliente"]."','".$Fila["cantidad_embarque"]."','".$Fila["num_prog_loteo"]."','".$Fila["cod_producto"]."','".$Fila["producto"]."','".$Fila["cod_subproducto"]."','".$Fila["subproducto"]."','".$Fila["pto_destino"]."','".$Fila["pto_emb"]."','E','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["fecha_disponible"]."','E')";
						mysqli_query($link, $Insertar);
					}
					$Consulta="select * from sec_web.tmpprograma where estado <> 'T' order by fecha_disponible";
					break;	
			}
			$Respuesta=mysqli_query($link, $Consulta);
			$TotalPesoPrep=0;
			$Cont2=0;//wso
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if (($TipoIE=='Normal')||($TipoIE=='NormalVentanas'))
				{
					if ($Fila["estado"]=='A')
					{
						echo "<tr class='colortabla04'>"; 
					}
					else
					{
						if ($Fila["estado"]=='M')
						{
							echo "<tr class='colortabla03'>";
						}	 							
						else
						{					
							echo "<tr>";
						}	 
					}
					if ($Fila["estado2"]=='R')
					{
						$Consulta="select t1.cod_bulto,t1.num_bulto,t1.cod_marca,sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on ";
						$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
						//$Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_ie"]." and t1.cod_estado='a' and t2.cod_estado='a' group by t1.corr_enm,t1.cod_bulto,t1.num_bulto";
                        $Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_ie"]." and t2.cod_subproducto=".$Fila["cod_subproducto"]." and t1.cod_estado='a' and t2.cod_estado='a' group by t1.corr_enm,t1.cod_bulto,t1.num_bulto order by t1.fecha_creacion_lote desc";
                            //se agrega a la consulta el subproducto ya que se repinten paquetes en difentes lotes 13-02-2008 poly
      
                      //   echo $Consulta;
      
						$Respuesta2=mysqli_query($link, $Consulta);
						$Fila2=mysqli_fetch_array($Respuesta2);
					}	
					$MostrarBoton=true;
					$Cont2++;

					$corr_ie = isset($Fila["corr_ie"])?$Fila["corr_ie"]:"";
					$producto = isset($Fila["producto"])?$Fila["producto"]:"";
					$subproducto = isset($Fila["subproducto"])?$Fila["subproducto"]:"";
					$cod_producto = isset($Fila["cod_producto"])?$Fila["cod_producto"]:"";
					$cod_subproducto = isset($Fila["cod_subproducto"])?$Fila["cod_subproducto"]:"";
					$cantidad_programada = isset($Fila["cantidad_programada"])?$Fila["cantidad_programada"]:0;
					$tipoie              = isset($Fila["tipoie"])?$Fila["tipoie"]:"";
					$peso_preparado = isset($Fila2["peso_preparado"])?$Fila2["peso_preparado"]:0;
					$cod_bulto      = isset($Fila2["cod_bulto"])?$Fila2["cod_bulto"]:"";
					$num_bulto      = isset($Fila2["num_bulto"])?$Fila2["num_bulto"]:"";
					$cod_marca      = isset($Fila2["cod_marca"])?$Fila2["cod_marca"]:"";
					$estado         = isset($Fila2["estado"])?$Fila2["estado"]:"";

					echo "<td width='40' align='center'>".$Fila["num_prog_loteo"]."</td>";
					echo "<td width='40'>".$Fila["corr_ie"]."</td>";
					echo "<td width='160'>".$Fila["subproducto"]."&nbsp;</td>";
					echo "<td width='160'>".$Fila["cliente_nave"]."&nbsp;</td>";
					echo "<td width='100' align='center'>".$Fila["fecha_disponible"]."</td>";
					echo "<td width='60' align='right'>".($cantidad_programada*1000)."</td>";
					echo "<td width='60' align='right'>".$peso_preparado."&nbsp;</td>";
					echo "<td width='60' align='right'>".abs((int)$cantidad_programada*1000-(int)$peso_preparado)."&nbsp;</td>";
					if ($cod_bulto!="")
					{
						echo "<td width='60' align='right'><a href=\"JavaScript:MostrarPaquetes('".$Fila2["cod_bulto"]."','".$Fila2["num_bulto"]."','".$Fila["corr_ie"]."')\">\n";
						echo $Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."</a></td>\n";
					}
					else
					{
						echo "<td width='60' align='right'>&nbsp;</td>";
					}					
					echo "<td width='40' align='center'>".$Fila["estado"]."&nbsp;</td>";
					$TotalPesoPrep = $TotalPesoPrep + (int)$peso_preparado;
					$Fila2["cod_bulto"]="";
					$Fila2["num_bulto"]="";
					$Fila2["peso_preparado"]="";
					$Fila2["marca"]="";
					$Fila2["disponibilidad"]="";
					
				}
				else
				{
						$Consulta="select t1.cod_bulto,t1.num_bulto,t1.cod_marca,sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on ";
						$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
						$Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_ie"]." and t1.cod_estado='a' and t2.cod_estado='a' group by t1.corr_enm,t1.cod_bulto,t1.num_bulto";
						$Respuesta2=mysqli_query($link, $Consulta);
						$Fila2=mysqli_fetch_array($Respuesta2);
						$Cont2++;
						echo "<td width='20' align='center'><input type='radio' name='OptSeleccionar' value='".$Fila["corr_ie"]."~~".$Fila["producto"]."~~".$Fila["subproducto"]."~~".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."~~".($Fila["cantidad_programada"]*1000)."~~".$Fila[tipoie]."~~".$Fila2["peso_preparado"]."~~".$Fila2["cod_bulto"]."~~".$Fila2["num_bulto"]."~~".$Fila2["cod_marca"]."'></td>";
						echo "<td width='40'>".$Fila["corr_ie"]."</td>";
						echo "<td width='260'>".$Fila["subproducto"]."&nbsp;</td>";
						echo "<td width='100' align='center'>".$Fila["fecha_disponible"]."</td>";
						echo "<td width='80' align='right'>".$Fila["cantidad_programada"]."</td>";
						echo "<td width='100' align='right'>".$Fila2["peso_preparado"]."&nbsp;</td>";
						echo "<td width='100' align='right'>".abs($Fila["cantidad_programada"]-$Fila2["peso_preparado"])."&nbsp;</td>";
						if ($Fila2["cod_bulto"]!="")
						{
							echo "<td width='80' align='right'><a href=\"JavaScript:MostrarPaquetes('".$Fila2["cod_bulto"]."','".$Fila2["num_bulto"]."','".$Fila["corr_ie"]."')\">\n";
							echo $Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."</a></td>\n";
						}
						else
						{
							echo "<td width='80' align='right'>&nbsp;</td>";
						}
						$TotalPesoPrep=$TotalPesoPrep+$Fila2["peso_preparado"];
				}	
				echo "</tr>";
			}
			echo "</table>";	
		?>
        <br>
          <table width="730" border="0">
          <tr>
              <td align="right"><font color="#FF0000"><strong><?php echo "Total Peso Preparado:".number_format($TotalPesoPrep,0,'','.')." kgrs.";  ?></strong></font></td>
		  </tr>
		  </table>
	</td>
  </tr>
</table>
</form>
</body>
</html>
