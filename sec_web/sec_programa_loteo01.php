<?php
	include("../principal/conectar_principal.php");

	$Accion  = $_REQUEST["Accion"];
	$EnmCode = $_REQUEST["EnmCode"];
	$Proceso = $_REQUEST["Proceso"];

	$CmbAsignacion  = $_REQUEST["CmbAsignacion"];
	$CmbProducto    = $_REQUEST["CmbProducto"];
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	$CmbCliente     = $_REQUEST["CmbCliente"];
	$CmbNave        = $_REQUEST["CmbNave"];
	$CmbPtoEmbarque = $_REQUEST["CmbPtoEmbarque"];
	$CmbPtoDestino  = $_REQUEST["CmbPtoDestino"];
	$TxtNumSemana = $_REQUEST["TxtNumSemana"];
	$TxtPartida   = $_REQUEST["TxtPartida"];
	$TxtCantidad  = $_REQUEST["TxtCantidad"];
	$TxtNumOrden     = $_REQUEST["TxtNumOrden"];
	$TxtNumProgLoteo = $_REQUEST["TxtNumProgLoteo"];
	$TxtContrato     = $_REQUEST["TxtContrato"];
	$TxtCuota        = $_REQUEST["TxtCuota"];
	$TxtDescripcion  = $_REQUEST["TxtDescripcion"];
	$TxtFechaProg    = $_REQUEST["TxtFechaProg"];
	$TxtFechaDisp    = $_REQUEST["TxtFechaDisp"];
	$TxtFechaDevo    = $_REQUEST["TxtFechaDevo"];

	if($TxtNumSemana=='')
		$TxtNumSemana=0;
	if($TxtPartida=='')
		$TxtPartida=0;
	if($TxtCantidad=='')
		$TxtCantidad=0;
	if($TxtNumProgLoteo=='')
		$TxtNumProgLoteo=0;
	if($TxtCuota=='')
		$TxtCuota=0;

	switch ($EnmCode)
	{
		case "C":
			switch ($Proceso)
			{
				case "G":
					if ($CmbCliente!="S")
						$CmbCliente=$CmbCliente;
					else
						$CmbCliente=$CmbNave;
					$Cliente_Nave="";
					if ($CmbAsignacion=="S")
						$CmbAsignacion="";
					if ($CmbCliente=="S")
						$CmbCliente="";
					if ($CmbProducto=="S")
						$CmbProducto="";
					if ($CmbSubProducto=="S")
						$CmbSubProducto="";
					if ($CmbPtoEmbarque=="S")
						$CmbPtoEmbarque="";
					if ($CmbPtoDestino=="S")
						$CmbPtoDestino="";
					if ($CmbNave=="S")
						$CmbNave="";
					$Consulta = "SELECT * from sec_web.programa_codelco where corr_codelco='".$TxtNumOrden."'";
					$Resp=mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Resp))
					{
						if ($Accion=="M")
						{
							$FechaMaxima=date("Y-m-d");
							if ($TxtNumProgLoteo!="" && $TxtNumProgLoteo!="0")
							{
								$Consulta = "SELECT * from sec_web.programa_loteo where num_prog_loteo='".$TxtNumProgLoteo."'";
								$RespAux=mysqli_query($link, $Consulta);
								if (!$FilaAux=mysqli_fetch_array($RespAux)) 
								{
									$Insertar = "insert into sec_web.programa_loteo(num_prog_loteo,fecha_hora,fecha_maxima,estado,descripcion) ";
									$Insertar.= "values('".$TxtNumProgLoteo."','".date('Y-m-d h:i')."','".$FechaMaxima."','P','".$TxtDescripcion."')";
									mysqli_query($link, $Insertar)."<br>";
								}
							}
							//echo $TxtNumProgLoteo."-".$Fila["num_prog_loteo"];
							$Actualizar = "UPDATE sec_web.programa_codelco set ";
							$Actualizar.= " cod_contrato_maquila='".$CmbAsignacion."', ";
							$Actualizar.= " fecha_devolucion_maquila='".$TxtFechaDevo."', numero_semana='".$TxtNumSemana."', ";
							$Actualizar.= " partida='".$TxtPartida."', fecha_programacion='".$TxtFechaProg."', ";
							$Actualizar.= " cod_cliente='".$CmbCliente."', cod_producto='".$CmbProducto."', cod_subproducto='".$CmbSubProducto."', ";
							$Actualizar.= " cantidad_programada='".$TxtCantidad."', num_prog_loteo='".$TxtNumProgLoteo."', fecha_disponible='".$TxtFechaDisp."', ";
							$Actualizar.= " descripcion='".$TxtDescripcion."', cod_contrato='".$TxtContrato."', mes_cuota='".$TxtCuota."', cod_puerto='".$CmbPtoEmbarque."', ";
							$Actualizar.= " cod_puerto_destino='".$CmbPtoDestino."' ";
							$Actualizar.= " where corr_codelco=".$TxtNumOrden."";
							mysqli_query($link, $Actualizar);
							//echo $Actualizar;
						}
					}
					else
					{
						if ($Accion=="N")
						{
							if ($TxtNumProgLoteo!="" && $TxtNumProgLoteo!="0")
							{
								$Consulta = "select * from sec_web.programa_loteo where num_prog_loteo='".$TxtNumProgLoteo."'";
								$RespAux=mysqli_query($link, $Consulta);
								if (!$FilaAux=mysqli_fetch_array($RespAux)) 
								{								
									$FechaMaxima=date("Y-m-d");
									$Insertar = "insert into sec_web.programa_loteo(num_prog_loteo,fecha_hora,fecha_maxima,estado,descripcion) ";
									$Insertar.= "values('".$TxtNumProgLoteo."','".date('Y-m-d h:i')."','".$FechaMaxima."','P','".$TxtDescripcion."')";
									mysqli_query($link, $Insertar);
								}
							}
							$Insertar = "insert into sec_web.programa_codelco (corr_codelco, cod_contrato_maquila, ";
							$Insertar.= " fecha_devolucion_maquila, numero_semana, partida, fecha_programacion, ";
							$Insertar.= " cod_cliente, cod_producto, cod_subproducto, cantidad_programada, estado1, estado2, ";
							$Insertar.= " num_prog_loteo, fecha_disponible, descripcion, estado3, estado4, fecha_confirmacion, ";
							$Insertar.= " usuario, modif_usuario, cod_contrato, mes_cuota, cod_puerto, cod_puerto_destino) ";
							$Insertar.= " values('".$TxtNumOrden."','".$CmbAsignacion."','".$TxtFechaDevo."','".$TxtNumSemana."','".$TxtPartida."', ";
							$Insertar.= " '".$TxtFechaProg."','".$CmbCliente."','".$CmbProducto."','".$CmbSubProducto."','".$TxtCantidad."','','','".$TxtNumProgLoteo."',";
							$Insertar.= " '".$TxtFechaDisp."','".$TxtDescripcion."','','','0000-00-00 00:00:00','','','".$TxtContrato."','".$TxtCuota."','".$CmbPtoEmbarque."','".$CmbPtoDestino."')";
							//echo $Insertar;
							mysqli_query($link, $Insertar);
							//echo $Insertar;
						}
					}
					
					$Consulta="Select peso_rango from  sec_web.sec_parametro_peso";
					$rs = mysqli_query($link, $Consulta);
					if ($row = mysqli_fetch_array($rs))
					{
						$TxtPesoRango=$row["peso_rango"];
					}
					$AnoMenosConsulta=date('Y')-1;
					$consulta = "SELECT IFNULL(SUM(peso_paquetes),0) AS peso FROM sec_web.lote_catodo AS t1";
					$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
					$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete  AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
					$consulta.= " WHERE t1.corr_enm = '".$TxtNumOrden."' and year(fecha_creacion_lote) between '".$AnoMenosConsulta."' and '".date('Y')."'";//agregado 22-05-2012
					$rs = mysqli_query($link, $consulta);
					$row = mysqli_fetch_array($rs);
					$TxtAcumulado = $row["peso"];
					//echo $TxtAcumulado." >= ((".$TxtCantidad."*1000) - ".$TxtPesoRango." )";
					if ($TxtAcumulado >= (($TxtCantidad*1000) - $TxtPesoRango ))
					{
						$actualizar = "UPDATE sec_web.programa_codelco SET estado2 = 'T'";
						$actualizar.= " WHERE corr_codelco = '".$TxtNumOrden."' AND estado2 NOT IN ('C','A')";
						mysqli_query($link, $actualizar);

					//	echo "TT ".$actualizar."<br>";
						$actualizar = "UPDATE sec_web.programa_enami SET estado2 = 'T'";
						$actualizar.= " WHERE corr_enm = '".$TxtNumOrden."' AND estado2 NOT IN ('C','A')";
						mysqli_query($link, $actualizar);	
						$actualizar = "UPDATE sec_web.lote_catodo SET disponibilidad = 'T'";
						$actualizar.= " WHERE corr_enm = '".$TxtNumOrden."'";
						mysqli_query($link, $actualizar);
					}
					else
					{
						if($TxtAcumulado>=0)
						{
							$Estado="P";
						}
						else
						{
							$Estado="T";
						}
						$actualizar = "UPDATE sec_web.programa_codelco SET estado2 = '".$Estado."'";
						$actualizar.= " WHERE corr_codelco = '".$TxtNumOrden."' AND estado2 NOT IN ('C','A')";
						mysqli_query($link, $actualizar);
						$actualizar = "UPDATE sec_web.programa_enami SET estado2 = '".$Estado."'";
						$actualizar.= " WHERE corr_enm = '".$TxtNumOrden."' AND estado2 NOT IN ('C','A')";
						mysqli_query($link, $actualizar);	
						$actualizar = "UPDATE sec_web.lote_catodo SET disponibilidad = '".$Estado."'";
						$actualizar.= " WHERE corr_enm = '".$TxtNumOrden."'";
						mysqli_query($link, $actualizar);
					
					}
					$Valor=$TxtNumOrden."~~C";
					header("location:sec_programa_loteo_orden_emb.php?Accion=".$Accion."&Valor=".$Valor."&Prog=".$Prog);
					break;					
			}
			break;
		case "E":
			break;
	}
?>