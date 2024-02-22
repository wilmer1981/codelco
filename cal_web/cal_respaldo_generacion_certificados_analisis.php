<?php
include("../principal/conectar_principal.php");
$Eliminar = "delete  from cal_web.certificados where estado = 'I' ";
mysqli_query($link, $Eliminar);
$FechaHora = date("Y-m-d h:i");
$FechaHora1 = date("d-m-Y h:i");
$Rut =$CookieRut;


?>

<html>
<head>
<title>Generacion de Certificados de Analisis</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
</head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Imprimir(Correlativo)
	{
	var frm=document.FrmGeneracionAnalisis;
	var Opcion ="";
	
	frm.action="cal_generacion_certificados_analisis01.php?Correlativo="+Correlativo +"&Opcion=G";
	frm.submit();
	//frm.BtnImprimir.Visible= false;
	window.print();
	}
function Salir()
{	
	var frm=document.FrmGeneracionAnalisis;   
	frm.action="cal_generacion_certificados_analisis01.php?Opcion=S";
	frm.submit();

}


</script> 


</head>

<body>
<form name="FrmGeneracionAnalisis" method="post" action="">
		<input name="SA02" type="hidden" value="<?php echo $SA02  ?>">
	<?php
	//aqui empieza el ciclo del for
	for ($j = 0;$j <= strlen($SolRecargo); $j++)
	{
		if (substr($SolRecargo,$j,2) == "//")
					{	
						$Sol = substr($SolRecargo,0,$j);
						
						$Consulta ="select distinct(id_muestra) as id_muestra from cal_web.solicitud_analisis where nro_solicitud = '".$Sol."'";
						$Respuesta1 = mysqli_query($link, $Consulta);
						if ($Fila1=mysqli_fetch_array($Respuesta1))
						{
							$Muestra = $Fila1["id_muestra"];
						}
						//-------CONSULTO SI TIENE RECARGOS------
						$sql = "select ifnull(sum(recargo),0) as num_recargos from cal_web.solicitud_analisis where nro_solicitud = '".$Sol."' ";
						$result = mysqli_query($link, $sql);
						if ($row = mysqli_fetch_array($result))
						{
							if ($row[num_recargos] == 0) //---->SI NO TIENE
							{	
								
								$Recargo = "N";
							}
							
							else
							{
								$Recargo = "S";
							}	
						
						}
						//---------------------------------------						
						$Consulta ="select t2.cod_producto,t3.cod_subproducto,t2.descripcion as DesProducto,t3.descripcion as DesSubProducto from cal_web.solicitud_analisis t1 ";
						$Consulta = $Consulta." inner join proyecto_modernizacion.productos t2 ";
						$Consulta = $Consulta." on t1.cod_producto = t2.cod_producto ";
						$Consulta = $Consulta." inner join proyecto_modernizacion.subproducto t3 ";
						$Consulta = $Consulta." on t1.cod_subproducto = t3.cod_subproducto and t1.cod_producto = t3.cod_producto";
						$Consulta = $Consulta." where t1.nro_solicitud = '".$Sol."'"; 
						$Respuesta2=mysqli_query($link, $Consulta);
						if ($Fila2=mysqli_fetch_array($Respuesta2))
						
						{
							$CodProducto = $Fila2["cod_producto"];
							$Producto = $Fila2["DesProducto"];
							$SubProducto= $Fila2["DesSubProducto"];
							//echo $CodProducto;
						}
						
						//Consulta que devuelve el mayor de los elementos de la tabla certificados
						$Consulta5 = "select max(nro_certificado) as numero from cal_web.certificados ";/* t1 ";
						$Consulta5 =$Consulta5." inner join cal_web.solicitud_analisis t2  "; 					
						$Consulta5 =$Consulta5." on t1.nro_solicitud = t2.nro_solicitud    ";
						$Consulta5 = $Consulta5." where t2.nro_solicitud = '".$Sol."'"; */
						//echo $Consulta5."<br>";
						$Respuesta5=mysqli_query($link, $Consulta5);
						if ($Fila5=mysqli_fetch_array($Respuesta5))
						{
						
							$NroCert= $Fila5["numero"] + 1;
							//echo $NroCert."<br>";
							$Correlativo = $Correlativo.$NroCert.'~~'.$Sol.'//';
							//echo $Correlativo."<br>";
						}
						else
						{
							$NroCert=1;
							$Correlativo = $Correlativo.$NroCert.'//';
						}
						
						echo "<table width='560' height='410' border='0' cellpadding='5' class='tablaprincipal'>";
  						echo "<tr>";
      					echo "<td>";
			
						echo " <table width='550' height='400' border='0' cellpadding='5'> ";
							echo '<tr>'; 
							echo '<td>';
							echo "<table width='550'  border='0' cellpadding='0' class='TablaInterior'>";
							echo '<tr>'; 
							echo " <td width='221' height='14'>Empresa Nacional De Mineria </td>";
							echo "<td width='323'><div align='center'><font size='1'><font size='1'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>";
							echo $FechaHora1;
							if (!isset($FechaHora))
							{
								echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
								$FechaHora=date('Y-m-d H:i');
							}
							else
							{ 
								echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
							}
							echo "</font></font><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></font></div></td>";
							echo '</tr>';
							echo '<tr>'; 
							echo "<td height='14'>Fundicion y Refineria Ventanas</td>";
							echo "<td width='323'>&nbsp;</td>";
							echo '</tr>';
							echo '</table>';
							echo '<br>'; 
							echo "<table width='550'  border='0' cellpadding='0' class='TablaInterior'>";
								echo '<tr>'; 
								echo "<td>Tipo Producto</td>";
								echo " <td><div align='center'>:</div></td>";
								echo "<td>";
								echo $Producto;
								echo"</td>";
								echo '</tr>';
								echo '<tr>'; 
								echo "<td>Tipo SubProducto</td>";
								echo " <td><div align='center'>:</div></td>";
								echo "<td>";
								echo $SubProducto;
								echo"</td>";
								echo '</tr>';
								echo '<tr>'; 
								echo "<td>Identificacion de Muestra</td>";
								echo "<td><div align='center'>:</div></td>";
								echo "<td>";
								echo $Muestra;
								echo "</td>";
								echo '</tr>';
								echo '<tr>'; 
								echo "<td>#Solicitud de Analisis</td>";
								echo "<td><div align='center'>:</div></td>";
								echo "<td>";
								echo $Sol;
								echo "</td>";
								echo '</tr>';
								echo '<tr>'; 
								echo "<td>Numero de Certificado</td>";
								echo "<td><div align='center'>:</div></td>";
								echo "<td>";
								printf("%'06d",$NroCert);
								echo "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td width='211'>Generador</td>";
								echo "<td width='14'><div align='center'>:</div></td>";
								echo "<td width='334'>";
								$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
								$Resultado= mysqli_query($link, $Consulta);
								if ($Fila =mysqli_fetch_array($Resultado))
								{	
									echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
								}	  
								else
								{
									$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
									$Respuesta = mysqli_query($link, $Consulta);
									if ($Fila=mysqli_fetch_array($Respuesta))
									{
										echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
									}
								}
								echo "</td>";
								echo "</tr>";
								echo "</table>";
								//echo "<br>";

								//Si Producto es = a catodo
								if ($CodProducto == '18')
								{
									//Comienzo tabla de paquetes
									echo "<table width='550' border='0' cellpadding='0' class='TablaInterior'>";
  										echo"<tr>";
    									echo"<td width='111'>N&ordm; Serie Paquete </td>";
										echo "<td width='142'>:</td>";
										echo"<td width='121'>Inst de Embarque</td>";
										echo"<td width='180'>:</td>";
									  	echo"</tr>";
									  	echo"<tr>";
										echo"<td>N&ordm; Paquetes </td>";
										echo"<td>:</td>";
										echo"<td>Fecha Disponible</td>";
										echo"<td>:</td>";
									  	echo"</tr>";
									  	echo"<tr>"; 
										echo"<td>Peso Lote</td>";
										echo"<td>:</td>";
										echo"<td colspan='2'>&nbsp;</td>";
									  	echo"</tr>";
										echo "</table>";
									echo "<table width='550' border='1' cellpadding='3' class='TablaInterior'>";
										echo "<tr>";
										echo "<td colspan='9'><center><strong>Leyes</center></strong><td>";
										echo "</tr>";
										//Consulta que devuelve las leyes asociadas a los catodos
										$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad, ";
										$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey,t1.signo, ";
										$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
										$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
										$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
										$Consulta =$Consulta." and t1.recargo = t2.recargo ";
										$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
										$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes and t1.cod_unidad = t3.cod_unidad ";
										$Consulta =$Consulta."  inner join proyecto_modernizacion.unidades t4 ";
										$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
										$Consulta =$Consulta."  where t3.tipo_leyes = '0' and t2.estado_actual = '6' and t1.nro_solicitud = '".$Sol."' ";
										//echo $Consulta;
										$Respuesta = mysqli_query($link, $Consulta);
										echo "<tr>";
										$cont = 1; 
										$cont1 = 0;
										while ($Fila5=mysqli_fetch_array($Respuesta))
										{
											if ($cont == '4')	
												{
													echo '</tr>';
													echo '<tr>';
													$cont=1;
												}
												
												//echo "<td align ='center'>";
												echo "<td width = '60'><center>".$Fila5["abrevLey"]."</center></td>";
												if ($Fila5["signo"] == 'N')
													{
														$Valor='ND';
													}
													else
													{
														$Valor = $Fila5["signo"].round($Fila5["valor"],2);
													}
												echo "<td width = '60'><center>".Valor."</center></td>";
												echo "<td width = '60'><center>".$Fila5["abrevUnidad"]."</center></td>";				
												//echo '</td>';
												$cont =$cont+ 1;
												$cont1 =$cont1+1; 
										}
										
										if (($cont1 == 1) || ($cont1 == 4) || ($cont1 == 7) || ($cont1 == 10) || ($cont1 == 13) || ($cont1 == 16) || ($cont1 == 19))
										{																							
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";				
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
										}
										if (($cont1 == 2) ||($cont1 == 5) || ($cont1 == 8)|| ($cont1 == 11) || ($cont1 == 14)||($cont1 == 17)) 
										{
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";				
										}
										
										echo "</tr>";
										echo"<br>";
										
										echo "<tr>";
										echo "<td colspan='9'><center><strong>Impurezas</center></strong><td>";
										echo "</tr>";
										//Consulta que devuelve las impurezas asociadas a los catodos 
										$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad, ";
										$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
										$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
										$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
										$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
										$Consulta =$Consulta." and t1.recargo = t2.recargo ";
										$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
										$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes and t1.cod_unidad = t3.cod_unidad ";
										$Consulta =$Consulta."  inner join proyecto_modernizacion.unidades t4 ";
										$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
										$Consulta =$Consulta."  where t3.tipo_leyes = '1' and t2.estado_actual = '6' and t1.nro_solicitud = '".$Sol."' ";
										$Respuesta = mysqli_query($link, $Consulta);
										echo "<tr>";
										$cont2 = 1; 
										$cont3 = 0;
										while ($Fila6=mysqli_fetch_array($Respuesta))
										{
											if ($cont2 == '4')	
												{
													echo '</tr>';
													echo '<tr>';
													$cont2=1;
												}
												
											//echo "<td align ='center'>";
											echo "<td width = '60'><center>".$Fila6["abrevLey"]."</center></td>";
											if ($Fila6["signo"] == 'N')
													{
														$Valor='ND';
													}
													else
													{
														$Valor = $Fila6["signo"].round($Fila5["valor"],2);
													}
											echo "<td width = '60'><center>".Valor."</center></td>";
											echo "<td width = '60'><center>".$Fila6["abrevUnidad"]."</center></td>";				
											//echo $Fila6["abrevLey"]." ".$Fila6["valor"]." ".$Fila6["abrevUnidad"]; 				
											//echo '</td>';
											$cont2 =$cont2+ 1;
											$cont3 =$cont3+ 1; 
										}
										if (($cont3 == 1) || ($cont3 == 4) || ($cont3 == 7) || ($cont3 == 10) || ($cont3 == 13) || ($cont3 == 16) || ($cont3 == 19))
										{																							
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";				
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
										}
										if (($cont3 == 2) ||($cont3 == 5) || ($cont3 == 8)|| ($cont3 == 11) || ($cont3 == 14)||($cont3 == 17)) 
										{
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";				
										}
										
										
										echo "</tr>";
																		
										
										echo"</table>";
										//fin tabla paquetes
								echo "<br>";
								//								
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											
											//
								}
								////////////////////////////Fin if para Catodos////////////////////////////////////////////////////////////////////
								else
								{							
									//Si es Producto Minero y el recargo y viene con recargo
									if (($CodProducto =="1") && ($Recargo == "S"))
									{
										//echo $CodProducto;
										//echo $Recargo;
										//HUMEDADES DE LOS RECARGOS
										echo "<table 550' border='1' cellpadding='2' class='TablaInterior'>";
										echo "<tr>";
										echo "<td colspan=30><strong><center>Humedad</center></strong></td>";
										echo "</tr>";
										//ciclo que las rescata
										$Consulta =" select t1.recargo,t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad,t1.signo, ";
										$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
										$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
										$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
										$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
										$Consulta =$Consulta." and t1.recargo = t2.recargo ";
										$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
										$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes and t1.cod_unidad = t3.cod_unidad ";
										$Consulta =$Consulta."  inner join proyecto_modernizacion.unidades t4 ";
										$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
										$Consulta =$Consulta."  where t3.tipo_leyes = '0' and t2.estado_actual = '6' and t1.nro_solicitud = '".$Sol."' and t1.cod_leyes = '01' ";
										//echo $Consulta;
										$Respuesta = mysqli_query($link, $Consulta);
										//echo "<table width='572' border='0' cellpadding='5'>";
										while ($Fila6 = mysqli_fetch_array($Respuesta))
										{
											if (($Fila6["recargo"] != 0) || ($Fila6["recargo"]!='R'))
											{
												$Recar= $Fila6["recargo"];
												$Ley= $Fila6["abrevLey"];
												$ValorHumedad=$Fila6["valor"];
												$Unidad=$Fila6["abrevUnidad"];
												
												echo "<tr> ";
												echo"<td width='100'><center>Recargo</center></td>";
												echo "<td width='110'><center>".$Recar."</center></td>";
												echo "<td width='100'><center>".$Ley."</center></td>";
												if ($Fila6["signo"] == 'N')
												{
													$Valor='ND';
												}
												else
												{
													$Valor = $Fila6["signo"].round($Fila6["valor"],2);
												}
												echo "<td width='100'><center>".$Valor."</center></td>";
												echo "<td width='100'><center>".$Unidad."</center></td>";
												echo "</tr>";										
											}										
										}										
										echo "</table>";
										//-----------------------------										
										echo "<br>";
										//Comienzo de tabla para formulario  para todo tipo de productos excepto catodos  									
										echo "<table width='550'  border='1' cellpadding='0' class='TablaInterior'>";
										echo "<tr>";
										//echo "<td width='80' colspan= 14 ><strong><center>Leyes</center></strong></td>";
										echo "<td height='15' colspan=10><div align='center'><strong>Leyes</strong></div></td>";
										echo "</tr>";
										//Comienzo del recargo R
										echo "<tr> ";
										echo"<td width='80' colspan=14>Recargo:R</td>";
										//echo "<td width='78'></td>";
										echo "</tr>";
										echo "<td>";
										//echo "<table width='550' border=0' cellpadding='5'>";
											echo "<tr>";
											$cont = 1; 
											$cont1 = 0; 
											$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad,t1.signo, ";
											$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
											$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
											$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
											$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
											$Consulta =$Consulta." and t1.recargo = t2.recargo ";
											$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
											$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes and t1.cod_unidad = t3.cod_unidad ";
											$Consulta =$Consulta."  inner join proyecto_modernizacion.unidades t4 ";
											$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
											$Consulta =$Consulta."  where t3.tipo_leyes = '0' and t2.estado_actual = '6' and t1.nro_solicitud = '".$Sol."' and t1.recargo = 'R' and t1.cod_leyes <> '01' ";
											//echo $Consulta."<br>";
											$Respuesta5 = mysqli_query($link, $Consulta);
											   
											$Respuesta5 = mysqli_query($link, $Consulta);
											while ($Fila5=mysqli_fetch_array($Respuesta5))
											{
												if ($cont == '4')	
												{
													echo '</tr>';
													echo '<tr>';
													$cont=1;
												}
												
												//echo '<td>';
												echo "<td width = '30' ><center>".$Fila5["abrevLey"]."</center></td>";
												if ($Fila5["signo"] == 'N')
												{
													$Valor='ND';
												}
												else
												{
													$Valor = $Fila5["signo"].round($Fila5["valor"],2);
												}
												echo "<td width = '30'><center>".$Valor."</center></td>";
												echo "<td width = '30'><center>".$Fila5["abrevUnidad"]."</center></td>";
												//echo $Fila3["abrevLey"]." ".round($Fila3["valor"],2)." ".$Fila3["abrevUnidad"]; 				
												//echo '</td>';
												$cont =$cont+ 1;
												$cont1 =$cont1+ 1;
											}
											if (($cont1 == 1) || ($cont1 == 4) || ($cont1 == 7) || ($cont1 == 10) || ($cont1 == 13) || ($cont1 == 16) || ($cont1 == 19))
										{																							
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";				
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
										}
										if (($cont1 == 2) ||($cont1 == 5) || ($cont1 == 8)|| ($cont1 == 11) || ($cont1 == 14)||($cont1 == 17)) 
										{
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";				
										}
										echo "</tr>";
										echo "</td>";
										echo "</tr>";
										///////////////////////////////fin recargo R///////////////////////
										//coimienzo del recargo 0
										echo "<tr> ";
										echo"<td width='80' colspan=14>Recargo:0</td>";
										echo "</tr>";
										echo "<td>";
										//echo "<table width='550' border=0' cellpadding='5'>";
											echo "<tr>";
											$cont = 1; 
											$cont1 = 0; 
											$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad,t1.signo, ";
											$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
											$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
											$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
											$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
											$Consulta =$Consulta." and t1.recargo = t2.recargo ";
											$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
											$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes and t1.cod_unidad = t3.cod_unidad ";
											$Consulta =$Consulta."  inner join proyecto_modernizacion.unidades t4 ";
											$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
											$Consulta =$Consulta."  where t3.tipo_leyes = '0' and t2.estado_actual = '6' and t1.nro_solicitud = '".$Sol."' and t1.recargo = '0' and t1.cod_leyes <> '01' ";
											//echo $Consulta."<br>";  
											$Respuesta3 = mysqli_query($link, $Consulta);
											   
											$Respuesta3 = mysqli_query($link, $Consulta);
											while ($Fila3=mysqli_fetch_array($Respuesta3))
											{
												if ($cont == '4')	
												{
													echo '</tr>';
													echo '<tr>';
													$cont=1;
												}
												echo "<td width = '30' ><center>".$Fila3["abrevLey"]."</center></td>";
												if ($Fila3["signo"] == 'N')
													{
														$Valor='ND';
													}
													else
													{
														$Valor = $Fila3["signo"].round($Fila3["valor"],2);
													}
												echo "<td width = '30'><center>".$Valor."</center></td>";
												echo "<td width = '30'><center>".$Fila3["abrevUnidad"]."</center></td>";
												//echo $Fila3["abrevLey"]." ".round($Fila3["valor"],2)." ".$Fila3["abrevUnidad"]; 				
												//echo '</td>';
												$cont =$cont+ 1;
												$cont1 =$cont1+ 1;
											}
											if (($cont1 == 1) || ($cont1 == 4) || ($cont1 == 7) || ($cont1 == 10) || ($cont1 == 13) || ($cont1 == 16) || ($cont1 == 19))
											{																							
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";				
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
											}
											if (($cont1 == 2) ||($cont1 == 5) || ($cont1 == 8)|| ($cont1 == 11) || ($cont1 == 14)||($cont1 == 17)) 
											{
													echo "<td width = '60'><center>&nbsp;</center></td>";
													echo "<td width = '60'><center>&nbsp;</center></td>";
													echo "<td width = '60'><center>&nbsp;</center></td>";				
											}
												echo "</tr>";
										//	echo "</table>";
											////////////////
											echo "</td>";
											echo "</tr>";
											//echo "</table>";
											//vienen las impurezas
											echo "<tr>";
											echo "<td height='15' colspan=10><div align='center'><strong>Impurezas</strong></div></td>";
												//echo "<table width='570' border=0' cellpadding='5'>";
													echo "<tr>";
													$cont = 1; 
													$cont3 = 0; 
													$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad,t1.signo, ";
													$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
													$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
													$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
													$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
													$Consulta =$Consulta." and t1.recargo = t2.recargo ";
													$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
													$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes and t1.cod_unidad = t3.cod_unidad ";
													$Consulta =$Consulta."  inner join proyecto_modernizacion.unidades t4 ";
													$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
													$Consulta =$Consulta."  where t3.tipo_leyes = '1' and t2.estado_actual = '6' and t1.nro_solicitud = '".$Sol."' and t1.recargo ='0' ";
													$Respuesta4 = mysqli_query($link, $Consulta);
													while ($Fila4=mysqli_fetch_array($Respuesta4))
													
													{
													
														if ($cont == '4')	
														{
															echo '</tr>';
															echo '<tr>';
															$cont=1;
														}
														
														//echo '<td>';
														echo "<td width = '30' ><center>".$Fila4["abrevLey"]."</center></td>";
														if ($Fila4["signo"] == 'N')
														{
															$Valor='ND';
														}
														else
														{
															$Valor = $Fila4["signo"].round($Fila4["valor"],2);
														}
														echo "<td width = '30'><center>".$Valor."</center></td>";
														echo "<td width = '60'><center>".$Fila4["abrevUnidad"]."</center></td>";
														//echo $Fila4["abrevLey"]." ".$Fila4["valor"]." ".$Fila4["abrevUnidad"]; 				
														//echo '</td>';
														$cont =$cont+ 1;
														$cont3 =$cont3+ 1;
													}
													if (($cont3 == 1) || ($cont3 == 4) || ($cont3 == 7) || ($cont3 == 10) || ($cont3 == 13) || ($cont3 == 16) || ($cont3 == 19))
											{																							
													echo "<td width = '30'><center>&nbsp;</center></td>";
													echo "<td width = '30'><center>&nbsp;</center></td>";
													echo "<td width = '60'><center>&nbsp;</center></td>";				
													echo "<td width = '30'><center>&nbsp;</center></td>";
													echo "<td width = '30'><center>&nbsp;</center></td>";
													echo "<td width = '60'><center>&nbsp;</center></td>";
											}
										if (($cont3 == 2) ||($cont3 == 5) || ($cont3 == 8)|| ($cont3 == 11) || ($cont3 == 14)||($cont3 == 17)) 
										{
												echo "<td width = '30'><center>&nbsp;</center></td>";
												echo "<td width = '30'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";				
										}
												
												
												
												echo "</tr>";
										
										
										echo "</table>";
										/////fin de tabla para de productos mineros con recargo
										echo "<br>";
										echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											
									}
									/////////////////////////////Fin If de Productos mineros  con Recargo///////////////////////////////////////////////
									
									//si es producto minero y sin recargo o si otro producto pero distinto de catodos y ademas sin recargo entra al if 
									if ((($CodProducto =='1') && ($Recargo =='N'))|| ((($CodProducto !='1')||($CodProducto!='18')) && ($Recargo =='N')))
									{
										echo "<table width='550'border='1' cellpadding='3' class='TablaInterior'>";
											echo "<tr>";
											echo "<td colspan='9'><center><strong>Leyes</center></strong><td>";
											echo "</tr>";
											echo "<tr>";
											echo "<br>";
											echo "</tr>";
											//Consulta que devuelve las leyes asociadas a cualquier producto excepto catodoss y productos mineros con recargos  
											$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad, ";
											$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
											$Consulta =$Consulta." t4.abreviatura as abrevUnidad,t1.signo ";
											$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
											$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
											$Consulta =$Consulta." and t1.recargo = t2.recargo ";
											$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
											$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes and t1.cod_unidad = t3.cod_unidad ";
											$Consulta =$Consulta."  inner join proyecto_modernizacion.unidades t4 ";
											$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
											$Consulta =$Consulta."  where t3.tipo_leyes = '0' and t2.estado_actual = '6' and t1.nro_solicitud = '".$Sol."' ";
											//echo $Consulta;
											$Respuesta = mysqli_query($link, $Consulta);
											echo "<tr>";
											$cont = 1; 
											$cont1 = 0; 
											while ($Fila5=mysqli_fetch_array($Respuesta))
											{
												if ($cont == '4')	
													{
														echo '</tr>';
														echo '<tr>';
														$cont=1;
													}
													echo "<td width = '60'><center>".$Fila5["abrevLey"]."</center></td>";
												//	echo "<td width = '60'><center>".$Fila5["signo"]."</center></td>";
													if ($Fila5["signo"] == 'N')
													{
														$Valor='ND';
													}
													else
													{
														$Valor = $Fila5["signo"].round($Fila5["valor"],2);
													}
													echo "<td width = '60'><center>".$Valor."</center></td>";
													echo "<td width = '60'><center>".$Fila5["abrevUnidad"]."</center></td>";
													//echo $Fila5["abrevLey"]." ".$Fila5["valor"]." ".$Fila5["abrevUnidad"]; 				
													//echo '</td>';
													$cont =$cont+ 1;
													$cont1 =$cont1+ 1;
											}
											if (($cont1 == 1) || ($cont1 == 4) || ($cont1 == 7) || ($cont1 == 10) || ($cont1 == 13) || ($cont1 == 16) || ($cont1 == 19))
										{																							
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";				
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
										}
										if (($cont1 == 2) ||($cont1 == 5) || ($cont1 == 8)|| ($cont1 == 11) || ($cont1 == 14)||($cont1 == 17)) 
										{
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";				
										}
											echo "</tr>";
											echo"<br>";
											echo"<br>";
											echo "<tr>";
											//echo "<td>&nbsp</td>";
											echo "<td  colspan='9'><center><strong>Impurezas</center></strong><td>";
											echo "</tr>";
											//Consulta que devuelve las impurezas asociadas a cualquier producto excepto catodoss y productos mineros con recargos  
											$Consulta =" select t1.valor,t1.cod_leyes,t1.nro_solicitud,t1.cod_unidad,t1.signo, ";
											$Consulta =$Consulta." t2.estado_actual,t3.tipo_leyes,t1.recargo,t3.abreviatura as abrevLey, ";
											$Consulta =$Consulta." t4.abreviatura as abrevUnidad ";
											$Consulta =$Consulta."  from cal_web.leyes_por_solicitud t1 ";
											$Consulta =$Consulta. " inner join cal_web.solicitud_analisis t2 on t1.nro_solicitud = t2.nro_solicitud ";
											$Consulta =$Consulta." and t1.recargo = t2.recargo ";
											$Consulta =$Consulta." inner join proyecto_modernizacion.leyes t3 ";
											$Consulta =$Consulta." on t1.cod_leyes = t3.cod_leyes and t1.cod_unidad = t3.cod_unidad ";
											$Consulta =$Consulta."  inner join proyecto_modernizacion.unidades t4 ";
											$Consulta =$Consulta."  on t1.cod_unidad = t4.cod_unidad ";
											$Consulta =$Consulta."  where t3.tipo_leyes = '1' and t2.estado_actual = '6' and t1.nro_solicitud = '".$Sol."' ";
											$Respuesta = mysqli_query($link, $Consulta);
											echo "<tr>";
											$cont2 = 1; 
											$cont3 = 0; 
											while ($Fila6=mysqli_fetch_array($Respuesta))
											{
												if ($cont2 == '4')	
													{
														echo '</tr>';
														echo '<tr>';
														$cont2=1;
													}
													
													//echo "<td align ='center' >";
													echo "<td width = '60'><center>".$Fila6["abrevLey"]."</center></td>";
													if ($Fila6["signo"] == 'N')
													{
														$Valor='ND';
													}
													else
													{
														$Valor = $Fila6["signo"].round($Fila6["valor"],2);
													}
													echo "<td width = '60'><center>".$Valor."</center></td>";
													echo "<td width = '60'><center>".$Fila6["abrevUnidad"]."</center></td>";
													//echo $Fila6["abrevLey"]." ".$Fila6["valor"]." ".$Fila6["abrevUnidad"]; 				
													//echo '</td>';
													$cont2 =$cont2+ 1;
													$cont3 =$cont3+ 1;
											 }
											if (($cont3 == 1) || ($cont3 == 4) || ($cont3 == 7) || ($cont3 == 10) || ($cont3 == 13) || ($cont3 == 16) || ($cont3 == 19))
										{																							
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";				
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
										}
										if (($cont3 == 2) ||($cont3 == 5) || ($cont3 == 8)|| ($cont3 == 11) || ($cont3 == 14)||($cont3 == 17)) 
										{
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";
												echo "<td width = '60'><center>&nbsp;</center></td>";				
										}		
											
											
											
											echo "</tr>";
											
										echo"</table>";
										echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
										//fin tabla 
								}//fin if si no es p minero o otro producto con recargo
									
									
								
											echo "<br>";
											echo "<br>";
											echo "<br>";
											
							
								
							}
									//Cominezo de tabla para de la firma y digito de verificacion
									echo "<table width='550' border='0'>";
  										echo "<tr>";
    									//filas que separan las leyes de las filas 									
										echo "<tr>";
										echo "</tr>";	
										echo "<tr>";
										echo "</tr>";
										echo "<tr>";
										echo "</tr>";
										echo "<tr>";
										echo "</tr>";
										echo "<tr>";
										echo "</tr>";
										echo "<tr>";
										echo "</tr>";
										echo "<tr>";
										echo "</tr>";
										echo "<tr>";
										echo "</tr>";
										echo "<tr>";
										echo "</tr>";
										echo "<tr>";
										echo "</tr>";
										echo "<tr>";
										echo "</tr>";
										echo "<tr>";
										echo "</tr>";
										
										//filas que separan las leyes con las filas	
											echo "<td width ='210'>&nbsp;</td>";					
											echo"<td width = '300' >__________</td>";
    
 										 echo "</tr>";
  										 echo "<tr>";
											echo "<tr>";	
											echo "</tr>";	
											echo "<tr>";	
											echo "</tr>";
											echo "<td width ='210'>&nbsp;</td>";
											echo "<td width = '300'>&nbsp&nbsp;Firma</td>";								
										 	echo "<tr>";								
											//echo "<td width ='210'>&nbsp;</td>";
											
											echo "</tr>";
									echo "</tr>";
									
									echo "</table>";
									echo "<br>";
									echo "<br>";
									echo "<br>";
									echo "Codigo Verificacion XGGHDFSVDAHSDRAUDSKD";
									//////	fin tabla firma verificacion
													
										
									echo "</tr>";
									echo "</tr>";
									echo "</td>";
									echo "</tr>";
								
									
										
								echo "</table>";
								///fin tabla dinamica
								echo "</td>";
    							echo "</tr>";
  								echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											
												
  								echo"</table>";
  								echo "<hr style='border:dashed'>";
								$insertar ="insert into cal_web.certificados (rut_generador,nro_solicitud,fecha_hora,nro_certificado,estado)";
								$insertar.="values ('".$Rut."','".$Sol."','".$FechaHora."','".$NroCert."','I')";
								mysqli_query($link, $insertar);
								if (mysql_errno($link)==0)
								{
									$mensaje="Los datos se han Insertado Correctamente";
								}
								else
								{
									if (mysql_errno($link)==1062)
									{
										$mensaje="Los datos NO se han Ingresado por que el registro<br>Ya existe</h2>";
								  	}
									 else
									 {
										 $numerror=mysql_errno($link);
										 $descrerror=mysql_error($link);
										 $mensaje="Los datos no se han Insertado por que se ha producido un error n� $numerror que corresponde a: $descrerror  <br>";
									  }
								}
					$SolRecargo = substr($SolRecargo,$j + 2);
					$j = 0;						
					} 
	  				
					}
					echo "<table width='550' border='0' cellpadding=0' >";
            			echo "<tr>";
			  			echo "</tr>";			
						echo "<tr>";
			  			echo "</tr>";
						echo "<tr>";
			  			echo "</tr>";			
						echo "<tr>";
			  			echo "</tr>";			
						echo "<tr>";
			  			echo "</tr>";
						echo "<tr>";
			  			echo "</tr>";									
						echo "<tr>";
                    	echo "<td width='185'>"; 
                		echo "</td>";
    					//								
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											echo "<br>";
											
											//
											    
			  			echo "<td widh='381'><input name='BtnImprimir' type='button'  value='Imprimir' style='width:60' onClick=Imprimir('$Correlativo');>&nbsp;&nbsp;&nbsp;";
                    	echo "<input name='BtnSalir' type='Button'  value='Salir' style='width:60' onClick='Salir();'></td>";
            			echo "</tr>";
          			echo "</table>";
					
					
									
	  //aqui termina
    
	  ?>
	  
	  
</form>
</body>
</html>
