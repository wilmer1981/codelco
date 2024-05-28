<?php 
include("../principal/conectar_principal.php");
$CookieRut = $_COOKIE["CookieRut"];

$ValoresSA    = isset($_REQUEST["ValoresSA"])?$_REQUEST["ValoresSA"]:"";
$Valores      = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
$Tipo         = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";
$Opcion       = isset($_REQUEST["Opcion"])?$_REQUEST["Opcion"]:"";
$CheckT       = isset($_REQUEST["CheckT"])?$_REQUEST["CheckT"]:"";
$PonerCandado = isset($_REQUEST["PonerCandado"])?$_REQUEST["PonerCandado"]:"";

function LimiteControl($SA,$CodLey,$Unidad,$Valor,$link)
{
	global $Recargo;
	$Consulta=" Select cod_producto,rut_proveedor,cod_subproducto,recargo from cal_web.solicitud_analisis where nro_solicitud='".$SA."' and recargo='".$Recargo."'";
	//echo $Consulta."<br>";
	$RespSa = mysqli_query($link, $Consulta);
	if($FilaSa=mysqli_fetch_array($RespSa))
	{
		
	
		$Consulta="Select * from cal_web.limite where cod_producto='".$FilaSa["cod_producto"]."' and cod_subproducto='".$FilaSa["cod_subproducto"]."'";
		$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' ";
		if($FilaSa["cod_producto"]=='1')
			$Consulta.=" and rut_proveedor='".$FilaSa["rut_proveedor"]."'";
		$RespColor = mysqli_query($link, $Consulta);
		if($FilaColor=mysqli_fetch_array($RespColor))
		{
			if(($FilaColor["limite_inicial"]<=$Valor) && ( $FilaColor["limite_final"] >=$Valor))
			{
				$Actualiza='N';
			}
			else
			{
				$Actualiza='S';	
			}
		}
		else
		{
			$Consulta="Select * from cal_web.limite where cod_producto='".$FilaSa["cod_producto"]."' and cod_subproducto='".$FilaSa["cod_subproducto"]."'";
			$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' ";
			if($FilaSa["cod_producto"]=='1')
				$Consulta.=" and rut_proveedor='T' ";
		
			$RespColor = mysqli_query($link, $Consulta);
			if($FilaColor=mysqli_fetch_array($RespColor))
			{
				if(($FilaColor["limite_inicial"]<=$Valor) && ( $FilaColor["limite_final"] >=$Valor))
				{
					$Actualiza='N';
				}
				else
				{
					$Actualiza='S';
				}
			}
			else
			{
				$Actualiza='N';
			}
		}
	}
	return($Actualiza);
	
}

function AvisoModLeyesConCandado($SA,$CodLey,$Unidad,$Valor,$link)
{
	global $Recargo;
	$Consulta=" Select cod_producto,rut_proveedor,cod_subproducto,recargo,id_muestra from cal_web.solicitud_analisis where nro_solicitud='".$SA."' and recargo='".$Recargo."'";
	//echo $Consulta."<br>";
	$RespSa = mysqli_query($link, $Consulta);
	if($FilaSa=mysqli_fetch_array($RespSa))
	{
		if($FilaSa["recargo"]!='R')//Envio Correo para distintos de Retalla
		{
			$Consulta="Select * from cal_web.registro_leyes where nro_solicitud='".$SA."' and recargo='".$Recargo."'  and cod_leyes='".$CodLey."' and cod_unidad='".$Unidad."' and candado='1' order by fecha_hora desc ";
			//echo $Consulta."<br>";
			$RespCANDADO = mysqli_query($link, $Consulta);
			if($FilaCANDADO=mysqli_fetch_array($RespCANDADO))
			{
				if($Valor<>$FilaCANDADO["valor"])
				{	
					EnvioCorreoLeyes($SA,$FilaSa["id_muestra"],$CodLey,$Unidad,$Valor,$FilaSa["cod_producto"],$FilaCANDADO["valor"],$link);
				}
			}
		}
	}

}


function EnvioCorreoLeyes($SA,$Lote,$CodLey,$Unidad,$Valor,$Producto,$ValorAnterior,$link)
{	
	global $CookieRut;
	if(ObtenerCorreos($Producto,$SA,$link))
	{
	
	$ConsultaAux = "select t1.cod_producto, t2.cod_subproducto, t1.descripcion as nom_prod, t2.descripcion as nom_subprod from proyecto_modernizacion.productos t1 inner join proyecto_modernizacion.subproducto t2 ";
	$ConsultaAux.= " on t1.cod_producto=t2.cod_producto ";
	$ConsultaAux.= " where t1.cod_producto='".$Producto."'";
	$Resp=mysqli_query($link, $ConsultaAux);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$desProducto=$Fila["nom_prod"];
	}
	 
		$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$CookieRut."'";
		$Resultado= mysqli_query($link, $Consulta);
		if ($Fila =mysqli_fetch_array($Resultado))
		{	
			 $user=ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
		}	  
		else
		{
			$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$CookieRut."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				$user=ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
			}
		}
		$Consulta1="select cod_unidad,cod_leyes,abreviatura from proyecto_modernizacion.leyes where cod_leyes='".$CodLey."' "; 
		$Respuesta1 = mysqli_query($link, $Consulta1);
		if ($Fila=mysqli_fetch_array($Respuesta1))
		{
		$LeyDES=$Fila["abreviatura"];
		}
		 $Consulta1="select cod_unidad,abreviatura from proyecto_modernizacion.unidades where cod_unidad='".$Unidad."' "; 
		$Respuesta1 = mysqli_query($link, $Consulta1);
		if ($Fila=mysqli_fetch_array($Respuesta1))
		{
			$UnidadDES=$Fila["abreviatura"];
		}
		$Asunto='Cambio Valor de Ley';
		$UN_SALTO="\r\n";
		$DOS_SALTOS="\r\n\r\n";
		$mensaje = '<html>';
		$mensaje.= '<head>';
		$mensaje.= '<title>Envio de Correo Sistema Control de Calidad</title>';
		$mensaje.= '</head>';
		$mensaje.= '<body>';
		$mensaje.= '<img src="cid:logo"><br><br>';
		$mensaje.= 'Estimado Usuario:<br>';
		$mensaje.= 'Se informa que ha sido modificado el valor para la Siguiente Ley: <br><br>';	
		$mensaje.= '<table border="1"  ><tr><td><font color="#999999" face="Times New Roman, Times, serif">Solicitud</font></td><td><font color="#999999" face="Times New Roman, Times, serif">'.$SA.'</font></td></tr>';
		$mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Lote</font></td><td><font color="#999999" face="Times New Roman, Times, serif">'.$Lote.'</font></td></tr>';
		$mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Producto</font></td><td><font color="#999999" face="Times New Roman, Times, serif">'.$desProducto.'</font></td></tr>';
		$mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Ley</font></td><td><font color="#999999" face="Times New Roman, Times, serif">'.$LeyDES.'</font></td></tr>';
		$mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Unidad</font></td><td><font color="#999999" face="Times New Roman, Times, serif">'.$UnidadDES.'</font></td></tr>';
		$mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Valor Anterior</font></td><td><font color="#999999" face="Times New Roman, Times, serif">'.$ValorAnterior.'</font></td></tr>';
		$mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Valor Nuevo</font></td><td><font color="#999999" face="Times New Roman, Times, serif">'.$Valor.'</font></td></tr>';
		$mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Usuario Modificador de la Ley</font></td><td><font color="#999999" face="Times New Roman, Times, serif">'.$user.'</font></td></tr>';
		$mensaje.= '</table>';
		$mensaje.= '<BR><BR> Sistema de Control de Calidad';
		$mensaje.= '</font>';	
		require "../principal/clasemail/class.phpmailer.php";
		$mail = new phpmailer();
		$mail->AddEmbeddedImage("../principal/imagenes/logo_cal.jpg","logo","../principal/imagenes/logo_cal.jpg","base64","image/jpg");
		
		$mail->PluginDir = "../principal/clasemail/";
		$mail->Host = "VEFVEX03.codelco.cl";
		$mail->From = "CAL WEB";
		$mail->FromName = "CAL WEB - Sistema de Control de Calidad";
		$mail->Subject = $Asunto;
		$mail->Body=$mensaje;
		$mail->IsHTML(true);
		$mail->AltBody =str_replace('<br>','\n',$mensaje);
		$mail->Timeout=120;		
		$Consulta="select * from cal_web.tmp_correo where rut='".$SA."' ";
		$RespCorreo= mysqli_query($link, $Consulta);
		while ($FilaCorreo= mysqli_fetch_array($RespCorreo))
		{
			$mail->AddAddress($FilaCorreo["correo"]);
		}
		$exito = $mail->Send();
		$intentos=1; 
		while((!$exito)&&($intentos<5)&&($mail->ErrorInfo!="SMTP Error: Data not accepted")){
		sleep(5);
		$exito = $mail->Send();
		$intentos=$intentos+1;				
		}
		$mail->ClearAddresses();
	}
	$Delete="delete from cal_web.tmp_correo where rut='".$SA."'";
	mysqli_query($link, $Delete);
}
function ObtenerCorreos($Producto,$SA,$link)
{

	$Delete="delete from cal_web.tmp_correo where rut='".$SA."'";
	mysqli_query($link, $Delete);
	$Contiene=false;			
	$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='1009' ";
	$RespC= mysqli_query($link, $Consulta);
	while ($FilaC= mysqli_fetch_array($RespC))
	{
		$CadenaValor=explode(',',$FilaC["valor_subclase1"]);
		//while (list($clave,$Codigo)=each($CadenaValor))
		foreach ($CadenaValor as $clave => $Codigo)
		{
			if($Codigo==$Producto)
			{
				$CadenaValorCorreo=explode(',',$FilaC["nombre_subclase"]);
				//while (list($clave1,$Codigo1)=each($CadenaValorCorreo))
				foreach ($CadenaValorCorreo as $clave1 => $Codigo1)
				{
					if($Codigo1!='')
					{	
						$Insertar="insert into cal_web.tmp_correo(rut,correo,producto)values('".$SA."','".$Codigo1."','".$Producto."')";
						mysqli_query($link, $Insertar);
						$Contiene=true;
					}
				}
			}
		}
	}
	return($Contiene);
}
$RutQ=$CookieRut;
$Fecha = date('Y-m-d H:i:s');
$Fecha2=date('Y-m-d H:i:s');
$FechaReg=date('Y-m-d H:i:s');
$Entrar = true;
switch ($Opcion)
{
	case "S":
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngLeyes.action='cal_adm_ingreso_leyes.php?Mostrar=S&Valores_Check=".$Valores."';";
		echo "window.opener.document.FrmIngLeyes.submit();";		
		echo "window.close();</script>";
		$Entrar=false;
		break;
	case "G":
	
	
		for ($f=0;$f<=strlen($Valores);$f++)
		{
			if (substr($Valores,$f,2)=="**")
			{
				$SARutLeyesRecargoValorUnidadPesoHPesoS=substr($Valores,0,$f);
				for ($i=0;$i<=strlen($SARutLeyesRecargoValorUnidadPesoHPesoS);$i++)
				{
					if (substr($SARutLeyesRecargoValorUnidadPesoHPesoS,$i,2)=="~~")
					{
						$SA = substr($SARutLeyesRecargoValorUnidadPesoHPesoS,0,$i);
						$RutLeyesRecargoValorUnidadPesoHPesoS = substr($SARutLeyesRecargoValorUnidadPesoHPesoS,$i+2);
						for ($j=0;$j<=strlen($RutLeyesRecargoValorUnidadPesoHPesoS);$j++)
						{
							if (substr($RutLeyesRecargoValorUnidadPesoHPesoS,$j,2)=="||")
							{
								$Rut=substr($RutLeyesRecargoValorUnidadPesoHPesoS,0,$j);
								$LeyesRecargoValorUnidadPesoHPesoS=substr($RutLeyesRecargoValorUnidadPesoHPesoS,$j+2);
								for ($k=0;$k<=strlen($LeyesRecargoValorUnidadPesoHPesoS);$k++)
								{
									if (substr($LeyesRecargoValorUnidadPesoHPesoS,$k,2)=="")
									{
										$Leyes=substr($LeyesRecargoValorUnidadPesoHPesoS,0,$k);
										$RecargoValorUnidadPesoHPesoS=substr($LeyesRecargoValorUnidadPesoHPesoS,$k+2);
										for ($l=0;$l<=strlen($RecargoValorUnidadPesoHPesoS);$l++)
										{
											if (substr($RecargoValorUnidadPesoHPesoS,$l,2)=="//")
											{
												$Recargo=substr($RecargoValorUnidadPesoHPesoS,0,$l);
												
												$ValorUnidadPesoHPesoS=substr($RecargoValorUnidadPesoHPesoS,$l+2);
												for ($m=0;$m<=strlen($ValorUnidadPesoHPesoS);$m++)
												{
													if (substr($ValorUnidadPesoHPesoS,$m,2)=="!!")
													{
														$Valor=substr($ValorUnidadPesoHPesoS,0,$m);
														$UnidadPesoHPesoS=substr($ValorUnidadPesoHPesoS,$m+2);												
														if ($Valor<>'')
														{
															$Valor=str_replace(",",".",$Valor);
														}
														else
														{
															$Valor="NULL";
														}												
														for ($n=0;$n<=strlen($UnidadPesoHPesoS);$n++)
														{
															if (substr($UnidadPesoHPesoS,$n,2)=="??")
															{	
																$Unidad=substr($UnidadPesoHPesoS,0,$n);
																$PesoHPesoS=substr($UnidadPesoHPesoS,$n+2);
																for($p=0;$p<=strlen($PesoHPesoS);$p++)
																{
																	if (substr($PesoHPesoS,$p,2)=="@@")
																	{	
																		$PesoH=substr($PesoHPesoS,0,$p);
																		$PesoS=substr($PesoHPesoS,$p+2);
																		if (($PesoH!='') and ($PesoS!=''))
																		{
																			$Valor=round((($PesoH-$PesoS)*100/$PesoH),6);
																		}
																		else
																		{
																			$PesoH="NULL";
																			$PesoS="NULL";
																			$Valor="NULL";
																		}
																		if ($Recargo =='N')
																		{
																			$Consulta = "select  * from cal_web.estados_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_estado='5'";
																			$Respuesta=mysqli_query($link, $Consulta);
																			if(!$Fila=mysqli_fetch_array($Respuesta))
																			{
																				$Insertar="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) values ('";
																				$Insertar=$Insertar.$Rut."',";
																				$Insertar=$Insertar.$SA.",";
																				$Insertar=$Insertar."'5','";
																				$Insertar=$Insertar.$Fecha."','".$RutQ."')";
																				mysqli_query($link, $Insertar);
																				$Actualizar="UPDATE cal_web.solicitud_analisis set estado_actual='5' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."'";
																				mysqli_query($link, $Actualizar);
																			}
																			$Consulta = "select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																			$Respuesta=mysqli_query($link, $Consulta);
																			if($Fila=mysqli_fetch_array($Respuesta))
																			{
																				if(($Valor)!=($Fila["valor"]) or (($Unidad)!=($Fila["cod_unidad"])))
																				{
																					if ($Fila["proceso"]==0)//QUIMICO
																					{
																						$Actualizar = "UPDATE cal_web.leyes_por_solicitud set peso_humedo=".$PesoH.",peso_seco=".$PesoS.",valor=".$Valor.",cod_unidad='".$Unidad."',proceso=3,rut_quimico='".$RutQ."' ";
																						
																						$Var='';
																						$Var=LimiteControl($SA,$Leyes,$Unidad,$Valor,$link);
																						if($Var=='S')
																							$Actualizar.= " , observacion='".$CookieRut."' ";
																						$Actualizar.= " where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																						mysqli_query($link, $Actualizar);
																					
																					}	
																					else
																					{
																						if ((($Fila["proceso"]==1) || ($Fila["proceso"]==2)) and ($Valor=='NULL'))//ANULAR
																						{
																							$Actualizar = "UPDATE cal_web.leyes_por_solicitud set peso_humedo=".$PesoH.",peso_seco=".$PesoS.",valor=".$Valor.",cod_unidad='".$Unidad."',proceso=5,rut_quimico='".$RutQ."' ";
																							$Var='';
																							$Var=LimiteControl($SA,$Leyes,$Unidad,$Valor,$link);
																							if($Var=='S')
																								$Actualizar.= " , observacion='".$CookieRut."' ";
																						    $Actualizar.= " where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																							mysqli_query($link, $Actualizar);
				
																						}
																						if (($Fila["proceso"]=='1')||($Fila["proceso"]=='2')||($Fila["proceso"]=='3')||($Fila["proceso"]=='4')||($Fila["proceso"]=='5'))//MODIFICAR
																						{
																							$Actualizar = "UPDATE cal_web.leyes_por_solicitud set peso_humedo=".$PesoH.",peso_seco=".$PesoS.",valor=".$Valor.",cod_unidad='".$Unidad."',proceso=4,rut_quimico='".$RutQ."'";
																							$Var='';
																							$Var=LimiteControl($SA,$Leyes,$Unidad,$Valor,$link);
																							if($Var=='S')
																								$Actualizar.= " , observacion='".$CookieRut."' ";
																						    $Actualizar.= "  where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																							mysqli_query($link, $Actualizar);
																						}
																					}
																					$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso) values(";
																					$Insertar=$Insertar.$SA.",'";
																					$Insertar=$Insertar.$FechaReg."','";
																					$Insertar=$Insertar.$Rut."','";
																					$Insertar=$Insertar.$Leyes."',";
																					$Insertar=$Insertar.$PesoH.",";
																					$Insertar=$Insertar.$PesoS.",";
																					$Insertar=$Insertar.$Valor.",'";
																					$Insertar=$Insertar.$Unidad."',";
																					$Insertar=$Insertar."'0','".$RutQ."')";	
																					mysqli_query($link, $Insertar);
																				}
																			}
																			if ($PonerCandado=="S")
																			{
																				$Actualizar="UPDATE cal_web.leyes_por_solicitud set candado='1',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";		
																				mysqli_query($link, $Actualizar);//ACTUALIZA EL CANDADO
																				
																				$Consulta = "select valor,cod_unidad,(case when peso_humedo is null then 'NULL' else peso_humedo end) as peso_humedo,(case when peso_seco is null then 'NULL' else peso_seco end) as peso_seco from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																				$Respuesta=mysqli_query($link, $Consulta);
																				$Fila=mysqli_fetch_array($Respuesta);
																				AvisoModLeyesConCandado($SA,$Leyes,$Fila["cod_unidad"],$Fila["valor"],$link);
																	
																				$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso) values(";
																				$Insertar=$Insertar.$SA.",'";
																				$Insertar=$Insertar.$Fecha."','";
																				$Insertar=$Insertar.$Rut."','";
																				$Insertar=$Insertar.$Leyes."',";
																				$Insertar=$Insertar.$Fila["peso_humedo"].",";
																				$Insertar=$Insertar.$Fila["peso_seco"].",";
																				$Insertar=$Insertar.$Fila["valor"].",'";
																				$Insertar=$Insertar.$Fila["cod_unidad"]."',";
																				$Insertar=$Insertar."'1','".$RutQ."')";
																				mysqli_query($link, $Insertar);//INSERTA EL REGISTRO DE LEYES
																				//SE PREGUNTA PARA SABER SI HAY QUE FINALIZAR LA SOLICITUD 
																				$Consulta = "select count(*) as existe from cal_web.leyes_por_solicitud where (nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and candado <> '1')";
																				$Respuesta=mysqli_query($link, $Consulta);
																				$Fila= mysqli_fetch_array($Respuesta);
																				if ($Fila["existe"] == 0)
																				{
																					$Consulta = "select count(*) as existe_at_quimico from cal_web.estados_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_estado = 5";
																					$Respuesta2=mysqli_query($link, $Consulta);
																					$Fila2= mysqli_fetch_array($Respuesta2);
																					if ($Fila2["existe_at_quimico"]==0)
																					{
																						$insertar3 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso)";
																						$insertar3.="values ('".$Rut."','".$SA."','5','".$Fecha2."','".$RutQ."')";
																						mysqli_query($link, $insertar3);
																					}
																					$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) ";
																					$insertar2.="values ('".$Rut."','".$SA."','6','".$Fecha2."','".$RutQ."')";
																					mysqli_query($link, $insertar2);
																					$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='6' where rut_funcionario = '".$Rut."' and nro_solicitud =".$SA;
																					mysqli_query($link, $Actualizar2);
																				}
																			}	
																		}
																		else
																		{
																			$Consulta = "select  * from cal_web.estados_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and cod_estado='5'";
																			$Respuesta=mysqli_query($link, $Consulta);
																			if(!$Fila=mysqli_fetch_array($Respuesta))
																			{
																				$Insertar="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso) values ('";
																				$Insertar=$Insertar.$Rut."',";
																				$Insertar=$Insertar.$SA.",'";
																				$Insertar=$Insertar.$Recargo."',";
																				$Insertar=$Insertar."'5','";
																				$Insertar=$Insertar.$Fecha."','".$RutQ."')";
																				mysqli_query($link, $Insertar);
																				$Actualizar="UPDATE cal_web.solicitud_analisis set estado_actual='5' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."'";
																				mysqli_query($link, $Actualizar);
																			}
																			$Consulta = "select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";											
																			$Respuesta=mysqli_query($link, $Consulta);	
																			if($Fila=mysqli_fetch_array($Respuesta))
																			{
																				if(($Valor)!=($Fila["valor"]) or (($Unidad)!=($Fila["cod_unidad"])))
																				{
																					if ($Fila["proceso"]==0)//QUIMICO
																					{
																						$Actualizar = "UPDATE cal_web.leyes_por_solicitud set peso_humedo=".$PesoH.",peso_seco=".$PesoS.",valor=".$Valor.",cod_unidad='".$Unidad."',proceso=3,rut_quimico='".$RutQ."' ";
																						$Var='';
																						$Var=LimiteControl($SA,$Leyes,$Unidad,$Valor,$link);
																						if($Var=='S')
																							$Actualizar.= " , observacion='".$CookieRut."' ";
																						$Actualizar.= "	where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																						mysqli_query($link, $Actualizar);
																					}
																					else
																					{
																						if ((($Fila["proceso"]==1) || ($Fila["proceso"]==2)) and ($Valor=='NULL'))//ANULAR
																						{
																							$Actualizar = "UPDATE cal_web.leyes_por_solicitud set peso_humedo=".$PesoH.",peso_seco=".$PesoS.",valor=".$Valor.",cod_unidad='".$Unidad."',proceso=5,rut_quimico='".$RutQ."' ";
																							$Var='';
																							$Var=LimiteControl($SA,$Leyes,$Unidad,$Valor,$link);
																							if($Var=='S')
																								$Actualizar.= " , observacion='".$CookieRut."' ";
																							$Actualizar.= "	where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																							mysqli_query($link, $Actualizar);
				
																						}
																						if (($Fila["proceso"]=='1')||($Fila["proceso"]=='2')||($Fila["proceso"]=='3')||($Fila["proceso"]=='4')||($Fila["proceso"]=='5'))//MODIFICAR
																						{
																							$Actualizar = "UPDATE cal_web.leyes_por_solicitud set peso_humedo=".$PesoH.",peso_seco=".$PesoS.",valor=".$Valor.",cod_unidad='".$Unidad."',proceso=4,rut_quimico='".$RutQ."' ";
																							$Var='';
																							$Var=LimiteControl($SA,$Leyes,$Unidad,$Valor,$link);
																							if($Var=='S')
																								$Actualizar.= " , observacion='".$CookieRut."' ";
																							$Actualizar.= "	where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																							mysqli_query($link, $Actualizar);
																						}
																					}
																					$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,recargo,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso) values(";
																					$Insertar=$Insertar.$SA.",'";
																					$Insertar=$Insertar.$FechaReg."','";
																					$Insertar=$Insertar.$Rut."','";
																					$Insertar=$Insertar.$Recargo."','";
																					$Insertar=$Insertar.$Leyes."',";
																					$Insertar=$Insertar.$PesoH.",";
																					$Insertar=$Insertar.$PesoS.",";
																					$Insertar=$Insertar.$Valor.",'";
																					$Insertar=$Insertar.$Unidad."',";
																					$Insertar=$Insertar."'0','".$RutQ."')";
																					mysqli_query($link, $Insertar);
																				}
																			}
																			if ($PonerCandado=="S")
																			{
																				
																				$Actualizar="UPDATE cal_web.leyes_por_solicitud set candado='1',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																				mysqli_query($link, $Actualizar);//ACTUALIZA EL CANDADO
																				$Consulta = "select valor,cod_unidad,(case when peso_humedo is null then 'NULL' else peso_humedo end) as peso_humedo,(case when peso_seco is null then 'NULL' else peso_seco end) as peso_seco from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																				$Respuesta=mysqli_query($link, $Consulta);
																				$Fila=mysqli_fetch_array($Respuesta);
																				AvisoModLeyesConCandado($SA,$Leyes,$Fila["cod_unidad"],$Fila["valor"],$link);
																	
																				$Insertar="insert into cal_web.registro_leyes(nro_solicitud,recargo,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso) values(";
																				$Insertar=$Insertar.$SA.",'";
																				$Insertar=$Insertar.$Recargo."','";
																				$Insertar=$Insertar.$Fecha."','";
																				$Insertar=$Insertar.$Rut."','";
																				$Insertar=$Insertar.$Leyes."',";
																				$Insertar=$Insertar.$Fila["peso_humedo"].",";
																				$Insertar=$Insertar.$Fila["peso_seco"].",";
																				$Insertar=$Insertar.$Fila["valor"].",'";
																				$Insertar=$Insertar.$Fila["cod_unidad"]."',";
																				$Insertar=$Insertar."'1','".$RutQ."')";
																				mysqli_query($link, $Insertar);//INSERTA EL REGISTRO DE LEYES
																				//SE PREGUNTA PARA SABER SI HAY QUE FINALIZAR LA SOLICITUD 
																				$Consulta = "select count(*) as existe from cal_web.leyes_por_solicitud where (nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and candado <> '1')";
																				$Respuesta=mysqli_query($link, $Consulta);
																				$Fila= mysqli_fetch_array($Respuesta);
																				if ($Fila["existe"]== 0)
																				{
																					$Consulta = "select count(*) as existe_at_quimico from cal_web.estados_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and cod_estado = '5'";
																					$Respuesta2=mysqli_query($link, $Consulta);
																					$Fila2= mysqli_fetch_array($Respuesta2);
																					if ($Fila2["existe_at_quimico"]==0)
																					{
																						$insertar3 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
																						$insertar3.="values ('".$Rut."','".$SA."','".$Recargo."','5','".$Fecha2."','".$RutQ."')";
																						mysqli_query($link, $insertar3);					
																					}
																					$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
																					$insertar2.="values ('".$Rut."','".$SA."','".$Recargo."','6','".$Fecha2."','".$RutQ."')";
																					mysqli_query($link, $insertar2);
																					$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='6' where rut_funcionario = '".$Rut."' and nro_solicitud =".$SA." and recargo='".$Recargo."'";
																					mysqli_query($link, $Actualizar2);
																				}
																			}		
																		}
																	}
																}		
															}	
														}	
													}	
												}		
											}
										}
									}
								}	
							}
						}	
					}
				}
			$Valores=substr($Valores,$f+2);
			$f=0;
			}	
		}
}		
if ($Entrar=true)
{
	switch ($Tipo)
	{
		case "H":		
			header ("location:cal_ingreso_valor_humedad.php?ValoresSA=".$ValoresSA."&CheckT=".$CheckT);
			break;
	
	}
}	
?>