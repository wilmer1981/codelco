<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");
	//echo $TxtValores;
	$CookieRut   = $_COOKIE["CookieRut"];
	$RutOperador = $CookieRut;
	$TipoRegistro = isset($_REQUEST["TipoRegistro"])?$_REQUEST["TipoRegistro"]:'';
	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:'';
	$TxtValores = isset($_REQUEST["TxtValores"])?$_REQUEST["TxtValores"]:'';
	$TxtNumRomana = isset($_REQUEST["TxtNumRomana"])?$_REQUEST["TxtNumRomana"]:'';

	switch($TipoRegistro)
	{
		case "R":
			$NomTabla='sipa_web.recepciones';
			break;
		case "D":
			$NomTabla='sipa_web.despachos';
			break;
	}	
	switch ($Proceso)
	{
		case "N"://CERRAR LOTES
			
			$Datos=explode('//',$TxtValores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~',$v);
				$Actualizar="UPDATE ".$NomTabla." set ult_registro='S' ";
				$Actualizar.="where lote='".$Datos2[0]."' and recargo='".$Datos2[1]."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				if($TipoRegistro=='R')
				{
					$Consulta="SELECT rut_prv as proveedor,cod_producto,cod_subproducto from ".$NomTabla." where lote='".$Datos2[0]."' and recargo='".$Datos2[1]."'";
					$Resp=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Resp);
					$Consulta = "SELECT leyes,impurezas from age_web.relaciones ";
					$Consulta.= " where cod_producto='".$Fila["cod_producto"]."' and cod_subproducto='".$Fila["cod_subproducto"]."' and rut_proveedor='".$Fila["proveedor"]."'";
					$Resp2=mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($Resp2);
					//CrearSA($Datos2[0],$Datos2[1],$Fila[proveedor],'S',$Fila["cod_producto"],$Fila["cod_subproducto"],$Fila["leyes"],$Fila["impurezas"],$RutOperador);							
				}
				//SE IMPRIME BOLETA CON RECARGO CERRADO	
			}
			echo "<script language='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='rec_cierre_lote_masivo.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";
			echo "</script>";		
			break;
		case "S"://ABRIR LOTES
			$Datos=explode('//',$TxtValores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~',$v);
				$Actualizar="UPDATE ".$NomTabla." set ult_registro='N' ";
				$Actualizar.="where lote='".$Datos2[0]."' and recargo='".$Datos2[1]."'";
				//echo $Actualizar."<br>";				
				mysqli_query($link, $Actualizar);
				//CODIGO PARA AVISAR A MUESTRERA QUE SE ABRIO UN LOTE
			}
			echo "<script language='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='rec_cierre_lote_masivo.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "I":
			$Datos=explode('//',$TxtValores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~',$v);
				switch($TipoRegistro)
				{
					case "R":
						ImprimirRecepcion($Datos2[2],$TxtNumRomana,'',$link);
						break;
					case "D":
						ImprimirDespachos($Datos2[2],$TxtNumRomana,'',$link);
						break;
				}
			}	
			header('location:rec_cierre_lote_masivo.php');
			break;		
	}
	
	//FUNCION PARA CREAR S.A
	/*function CrearSA($Lote,$Recargo,$Proveedor,$UltRec,$Producto,$SubProducto,$Leyes,$Impurezas,$RutOperador)
	{
		$FechaHora=date('Y-m-d H:i');
		$Datos=explode('~',$ProdSubProd);
		//VERIFICA SI EXISTE OTRO RECARGO CON NRO DE SOLICITUD PARA TOMAR SUS VALORES E INSERTARLO EN FORMA AUTOMATICA
		$Consulta ="SELECT * from cal_web.solicitud_analisis where id_muestra = '".$Lote."' and cod_producto ='".$Producto."' ";
		$Consulta.="and cod_subproducto='".$SubProducto."' and tipo_solicitud = 'A' and ((nro_solicitud is not null) or (nro_solicitud <> ''))";
		//echo $Consulta."<br><BR>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$Insertar="INSERT INTO cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
			$Insertar.="leyes,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,";
			$Insertar.="rut_proveedor,observacion,agrupacion,fecha_muestra) values (";
			$Insertar.= "'".$Fila["rut_funcionario"]."','".$Fila["FECHA_HORA"]."','$Lote','$Recargo','".$Producto."','$SubProducto','01~~1//','1',";			
			$Insertar.= "'3','A','".$Fila["nro_solicitud"]."','80','3312','1','1','$Proveedor','','1','$FechaHora')";
			echo $Insertar."<br><BR>";
			mysqli_query($link, $Insertar);
			$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
			$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["nro_solicitud"]."','$Recargo','1','".$Fila["FECHA_HORA"]."','N','".$Fila["rut_funcionario"]."')";
			echo $Insertar2."<br><BR>";
			mysqli_query($link, $Insertar2);
			$Insertar2="INSERT INTO cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values (";
			$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["FECHA_HORA"]."','".$Fila["nro_solicitud"]."','$Recargo','01','1','$SubProducto','$SubProducto','$Lote')";
			echo $Insertar2."<br><BR><BR><BR>";
			mysqli_query($link, $Insertar2);
			if($UltRec=='S')
			{
				$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
				$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["nro_solicitud"]."','0','1','".$Fila["FECHA_HORA"]."','N','".$Fila["rut_funcionario"]."')";
				echo $Insertar2."<br><BR>";
				mysqli_query($link, $Insertar2);
				$LeyesSA='';$LeyesImp='';					
				$CodLeyes=$Leyes."~".$Impurezas;
				$Leyes=explode('~',$CodLeyes);
				echo $CodLeyes."<br>";
				foreach($Leyes as  $c =>$v)
				{
					$Consulta="SELECT cod_unidad from proyecto_modernizacion.leyes where cod_leyes='$v'";
					$RespUnidad=mysqli_query($link, $Consulta);
					$FilaUnidad=mysqli_fetch_array($RespUnidad);
					$Insertar2="INSERT INTO cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values (";
					$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["FECHA_HORA"]."','".$Fila["nro_solicitud"]."','0','$v','".$FilaUnidad["cod_unidad"]."','".$Producto."','$SubProducto','$Lote')";
					echo $Insertar2."<br><BR>";
					mysqli_query($link, $Insertar2);
					if(($v=='02')||($v=='03')||($v=='04')||($v=='05'))
						$LeyesSA=$LeyesSA.$v."~~".$FilaUnidad["cod_unidad"]."//";
					else
						$LeyesImp=$LeyesImp.$v."~~".$FilaUnidad["cod_unidad"]."//";
				}
				$Insertar="INSERT INTO cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
				$Insertar.="leyes,impurezas,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,";
				$Insertar.="rut_proveedor,observacion,agrupacion,fecha_muestra) values (";
				$Insertar.= "'".$Fila["rut_funcionario"]."','".$Fila["FECHA_HORA"]."','$Lote','0','".$Producto."','$SubProducto','$LeyesSA','$LeyesImp','1',";			
				$Insertar.= "'3','A','".$Fila["nro_solicitud"]."','80','3312','1','1','$Proveedor','','1','$FechaHora')";
				echo $Insertar."<br><BR>";
				mysqli_query($link, $Insertar);
			}
		}	
		else
		{
			//echo "PRIMERA SOLICITUD RECARGO 1<br><br>";
			//SE OBTIENE EL NUMERO MAYOR DE LAS SOLICITUDES
			$Consulta = "SELECT max(nro_solicitud) as NroMayor from cal_web.solicitud_analisis";
			$RespSA = mysqli_query($link, $Consulta);
			if ($FilaSA = mysqli_fetch_array($RespSA))
			{
				if ((substr($FilaSA["NroMayor"],0,4)) == (date("Y")))
					$NroSA =$FilaSA["NroMayor"]+1;										
				else
					$NroSA=date("Y")."000001";	
			}
			else
				$NroSA=date("Y")."000001";	
			$Insertar="INSERT INTO cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
			$Insertar.="leyes,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,";
			$Insertar.="rut_proveedor,observacion,agrupacion,fecha_muestra) values (";
			$Insertar.= "'".$RutOperador."','$FechaHora','$Lote','$Recargo','".$Producto."','$SubProducto','01~~1//','1',";			
			$Insertar.= "'3','A','$NroSA','80','3312','1','1','$Proveedor','','1','$FechaHora')";
			echo $Insertar."<br><BR>";
			mysqli_query($link, $Insertar);
			$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
			$Insertar2.="'".$RutOperador."','$NroSA','$Recargo','1','$FechaHora','N','".$RutOperador."')";
			echo $Insertar2."<br><BR>";
			mysqli_query($link, $Insertar2);
			$Insertar2="INSERT INTO cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values (";
			$Insertar2.="'".$RutOperador."','$FechaHora','$NroSA','$Recargo','01','1','".$Producto."','$SubProducto','$Lote')";
			echo $Insertar2."<br><BR>";
			mysqli_query($link, $Insertar2);
			if($UltRec=='S')
			{
				$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
				$Insertar2.="'".$RutOperador."','$NroSA','0','1','$FechaHora','N','".$RutOperador."')";
				echo $Insertar2."<br><BR>";
				mysqli_query($link, $Insertar2);
				$LeyesSA='';$LeyesImp='';
				$CodLeyes=$Leyes."~".$Impurezas;
				$Leyes=explode('~',$CodLeyes);
				foreach($Leyes as  $c =>$v)
				{
					$Consulta="SELECT cod_unidad from proyecto_modernizacion.leyes where cod_leyes='$v'";
					$RespUnidad=mysqli_query($link, $Consulta);
					$FilaUnidad=mysqli_fetch_array($RespUnidad);
					$Insertar2="INSERT INTO cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values (";
					$Insertar2.="'".$RutOperador."','$FechaHora','$NroSA','0','$v','".$FilaUnidad["cod_unidad"]."','".$Producto."','$SubProducto','$Lote')";
					echo $Insertar2."<br><BR>";
					mysqli_query($link, $Insertar2);
					if(($v=='02')||($v=='03')||($v=='04')||($v=='05'))
						$LeyesSA=$LeyesSA.$v."~~".$FilaUnidad["cod_unidad"]."//";
					else
						$LeyesImp=$LeyesImp.$v."~~".$FilaUnidad["cod_unidad"]."//";
				}	
				$Insertar="INSERT INTO cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
				$Insertar.="leyes,impurezas,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,";
				$Insertar.="rut_proveedor,observacion,agrupacion,fecha_muestra) values (";
				$Insertar.= "'".$RutOperador."','$FechaHora','$Lote','0','$Producto','$SubProducto','$LeyesSA','$LeyesImp','1',";			
				$Insertar.= "'3','A','$NroSA','80','3312','1','1','$Proveedor','','1','$FechaHora')";
				echo $Insertar."<br><BR>";
				mysqli_query($link, $Insertar);
			}
		}
	}*/
?>