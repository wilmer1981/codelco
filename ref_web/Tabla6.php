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
	include("../principal/conectar_ref_web.php");

	$dia     = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
	$mes     = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
	$ano     = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
	$fecha    = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
?>

<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="post" name="form1">
              <table width="87%" border="1">
                <tr>
                  
              <table width="87%" height="12" border="1" cellpadding="2">
                <tr align="center"  class="ColorTabla01"> 
                  <td colspan="16"><strong>6.- ELECTROLITO</strong></td>
                </tr>
                <tr> 
                  <td width="40" align="center"><strong>CIRCUITO</strong></td>
                  <td width="40" height="63" align="center"><p><strong>Cu</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>H2SO4</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>As</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Sb</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Ca</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Fe</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" height="3" align="center"><p><strong>Mg</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Ni</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Zn</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Bi</strong></p>
                    <p><strong>[mg/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Pb</strong></p>
                    <p><strong>[g/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Cl</strong></p>
                    <p><strong>[mg/l]</strong></p></td>
                  <td width="40" align="center"><p><strong>Se</strong></p>
                    <p><strong>[mg/l]</strong></p></td>
                  <td width="19" align="center"><p><strong>Te</strong></p>
                    <p><strong>[mg/l]</strong></p></td>
                  <td width="19" align="center"><p><strong>SS</strong></p>
                    <p><strong>[mg/l]</strong></p></td>
                </tr>
                <?php 
				      $mostrar='S';			
					  if (strlen(strval($dia)) ==1)
		              {$dia = '0'.strval($dia);}
	                   if (strlen($mes) ==1) 
  		               {$mes = '0'.$mes;}
	                   $fecha=$ano."-".$mes."-".$dia;
				   if ($mostrar == "S")
					{
       					$cod_leyes=array('02','22','08','09','56','31','60','36','10','27','39','11','40','44','72');
						$circuitos=array('1','2','3','4','5','6','DP','DT','RETORNO');
						reset($circuitos);
						foreach($circuitos as $a=>$b)
							{
							       $Consulta_fecha="select left(fecha_hora,10) as fecha2 from cal_web.solicitud_analisis ";
                                   $Consulta_fecha=$Consulta_fecha." where left(fecha_muestra,10)='".$fecha."' and id_muestra='$b' and cod_producto='41' "; 		
							       $Respuesta_fecha =  mysqli_query($link,$Consulta_fecha);
							       $Fila_fecha = mysqli_fetch_array($Respuesta_fecha);
								   $fecha2 = isset($Fila_fecha["fecha2"])?$Fila_fecha["fecha2"]:"0000-00-00";
				    		       echo "<td align='center'>$b&nbsp</td>\n";
							        reset($cod_leyes); 
									foreach($cod_leyes as $c=>$v)
								          {
											$Consulta_electrolitos="select  t1.valor as valor,t1.candado,t1.cod_unidad,t1.cod_leyes from cal_web.leyes_por_solicitud as t1 ";
											$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
											$Consulta_electrolitos=$Consulta_electrolitos."where t1.id_muestra='$b' and t1.cod_producto='41' and left(t1.fecha_hora,10)='".$fecha2."' and t1.cod_leyes='$v'";
											$Respuesta_electrolitos =  mysqli_query($link,$Consulta_electrolitos);
											$Fila_electrolitos = mysqli_fetch_array($Respuesta_electrolitos);
											$valor = isset($Fila_electrolitos["valor"])?$Fila_electrolitos["valor"]:0;
											if ($valor <> 0)
												{$total=number_format($Fila_electrolitos["valor"],"2","","");
												 if (($Fila_electrolitos["cod_unidad"]=='6') and ($Fila_electrolitos["cod_leyes"]=='27'))
													 {echo "<td align='center'>$total gr/lt&nbsp</td>\n";  }  
												 else { echo "<td align='center'>$total&nbsp</td>\n";}
												 }
											else{echo "<td align='center'>&nbsp</td>\n";}
								}
							    echo "</tr>\n";
							 }
/****************************************************************************************************************************************/   						 
						 $HM=array('HM','H.M.','1HM','1-HM','H-M','HM.');
						 reset($cod_leyes);
						 reset($HM);
						foreach($HM as $a=>$b)
						 	{ 
							   $Consulta_fecha="select left(fecha_hora,10) as fecha2 from cal_web.solicitud_analisis ";
                               $Consulta_fecha=$Consulta_fecha." where left(fecha_muestra,10)='".$fecha."' and id_muestra='$b' and cod_producto='41' "; 		
							   $Respuesta_fecha =  mysqli_query($link,$Consulta_fecha);
							   $Fila_fecha = mysqli_fetch_array($Respuesta_fecha);
							   $fecha2 = isset($Fila_fecha["fecha2"])?$Fila_fecha["fecha2"]:"0000-00-00";
								$Consulta_hm="select  t1.id_muestra from cal_web.leyes_por_solicitud as t1 ";
								$Consulta_hm=$Consulta_hm."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
								$Consulta_hm=$Consulta_hm."where t1.id_muestra='$b' and t1.cod_producto='41' and left(t1.fecha_hora,10)='".$fecha2."'";
								$Respuesta_hm =  mysqli_query($link,$Consulta_hm);
								$Fila_hm = mysqli_fetch_array($Respuesta_hm);
								$id_muestra = isset($Fila_hm["id_muestra"])?$Fila_hm["id_muestra"]:"";
								if ($id_muestra==$b)
									{
										$idmuestra=$Fila_hm["id_muestra"];
										echo "<td align='center'>".$Fila_hm["id_muestra"]."&nbsp</td>\n";
										reset($cod_leyes);	
										foreach($cod_leyes as $c=>$v)
							   				{
								 				$Consulta_electrolitos="select  t1.valor as valor,t1.candado,t1.cod_unidad,t1.cod_leyes from cal_web.leyes_por_solicitud as t1 ";
												$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
												$Consulta_electrolitos=$Consulta_electrolitos."where t1.id_muestra='$idmuestra' and t1.cod_producto='41' and left(t1.fecha_hora,10)='".$Fila_fecha["fecha2"]."' and t1.cod_leyes='$v'";
												$Respuesta_electrolitos =  mysqli_query($link,$Consulta_electrolitos);
												$Fila_electrolitos = mysqli_fetch_array($Respuesta_electrolitos);
												$valor = isset($Fila_electrolitos["valor"])?$Fila_electrolitos["valor"]:0;
												if ($valor <> 0)
									    			{$total=number_format($Fila_electrolitos["valor"],"2","","");
										 			 if (($Fila_electrolitos["cod_unidad"]=='6') and ($Fila_electrolitos["cod_leyes"]=='27'))
										                {echo "<td align='center'>$total gr/lt&nbsp</td>\n";  }  
										             else { echo "<td align='center'>$total&nbsp</td>\n";}
										            }
												else{echo "<td align='center'>&nbsp</td>\n";}
											}
										echo "</tr>\n";
									}	
							}
							
						 							
/*******************************************************************************************************************************************************/							
						 $e100=array('E-100','E100','TK-100');
						 reset($e100);
						 reset($cod_leyes);
						foreach($e100 as $a=>$b)
						 	{
							    $Consulta_fecha="select left(fecha_hora,10) as fecha2 from cal_web.solicitud_analisis ";
                                $Consulta_fecha=$Consulta_fecha." where left(fecha_muestra,10)='".$fecha."' and id_muestra='$b' and cod_producto='41' "; 		
							    $Respuesta_fecha =  mysqli_query($link,$Consulta_fecha);
							    $Fila_fecha = mysqli_fetch_array($Respuesta_fecha);
								$fecha2 = isset($Fila_fecha["fecha2"])?$Fila_fecha["fecha2"]:"0000-00-00";
								$Consulta_e="select  t1.id_muestra from cal_web.leyes_por_solicitud as t1 ";
								$Consulta_e=$Consulta_e."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
								$Consulta_e=$Consulta_e."where t1.id_muestra='$b' and t1.cod_producto='41' and left(t1.fecha_hora,10)='".$fecha2."'";
								$Respuesta_e =  mysqli_query($link,$Consulta_e);
								$Fila_e = mysqli_fetch_array($Respuesta_e);
								$id_muestra = isset($Fila_e["id_muestra"])?$Fila_e["id_muestra"]:"";
								if ($id_muestra<>"")
									{
										$idmuestra=$Fila_e["id_muestra"];
										echo "<td align='center'>".$Fila_e["id_muestra"]."&nbsp</td>\n";
    									reset($cod_leyes);	
										foreach($cod_leyes as $c=>$v)
							   				{
								 				$Consulta_v="select  t1.valor as valor,t1.candado from cal_web.leyes_por_solicitud as t1 ";
												$Consulta_v=$Consulta_v."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
												$Consulta_v=$Consulta_v."where t1.id_muestra='$idmuestra' and t1.cod_producto='41' and left(t1.fecha_hora,10)='".$fecha2."' and t1.cod_leyes='$v'";
												$Respuesta_v =  mysqli_query($link,$Consulta_v);
												$Fila_v = mysqli_fetch_array($Respuesta_v);
												if ($Fila_v["valor"] <> 0)
									    			{$total=number_format($Fila_v["valor"],"2","","");
										 		 	 echo "<td align='center'>$total&nbsp</td>\n";}
												else{echo "<td align='center'>&nbsp</td>\n";}
											}
										echo "</tr>\n";
									}	
							 }
               }
	?>
              </table>
             <p>&nbsp;</p>
              </td>
  </tr>
</table>
</table>
</form>
</body>
</html>
			  
