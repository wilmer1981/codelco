<?php
	include("../principal/conectar_principal.php");
	$Mes = array("Tot","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
	$Proceso        = isset($_REQUEST['Proceso'])?$_REQUEST['Proceso'] : '';
	$CmbContrato    = isset($_REQUEST['CmbContrato'])?$_REQUEST['CmbContrato'] : '';
	$EstadoContrato = isset($_REQUEST['EstadoContrato'])?$_REQUEST['EstadoContrato'] : 1;
	$CmbSubProducto = isset($_REQUEST['CmbSubProducto'])?$_REQUEST['CmbSubProducto'] : '';
	$CmbProveedor   = isset($_REQUEST['CmbProveedor'])?$_REQUEST['CmbProveedor'] : '';
	$TxtNumContrato = isset($_REQUEST['TxtNumContrato'])?$_REQUEST['TxtNumContrato'] : '';
	$TxtDescripContrato = isset($_REQUEST['TxtDescripContrato'])?$_REQUEST['TxtDescripContrato'] : '';
	$TxtFechaIni = isset($_REQUEST['TxtFechaIni'])?$_REQUEST['TxtFechaIni'] : '';
	$TxtFechaFin = isset($_REQUEST['TxtFechaFin'])?$_REQUEST['TxtFechaFin'] : '';

	$SubProducto = isset($_REQUEST['SubProducto'])?$_REQUEST['SubProducto'] : '';

	$Ano         = isset($_REQUEST['Ano']) ? $_REQUEST['Ano'] : date("Y");
	$ChkTipoProg = isset($_REQUEST['ChkTipoProg']) ? $_REQUEST['ChkTipoProg'] : "00";
	$ChkProv     = isset($_REQUEST['ChkProv']) ? $_REQUEST['ChkProv'] : "";
	//$ChkPeso     = isset($_REQUEST['ChkPeso']) ? $_REQUEST['ChkPeso'] : "";

	

	switch ($Proceso)
	{
		case "G":
			$Consulta = "select distinct rut_proveedor from age_web.programa_recepcion ";
			$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."' ";
			$Consulta.= " and cod_contrato='".$CmbContrato."' and ano='".$Ano."' ";//and tipo_programa='".$ChkTipoProg."'";
			$Resp = mysqli_query($link, $Consulta);
			$Existe = false;
			while ($Fila = mysqli_fetch_array($Resp))
			{
				$rut_proveedor = isset($Fila["rut_proveedor"])?$Fila["rut_proveedor"]:"";
				$Existe = true;
				for ($i=1;$i<=12;$i++)
				{
					$Valor = 0;
					//$Objeto = "\$ChkPeso".$Mes[$i]."_".str_replace("-","",$rut_proveedor);
					$Objeto  = "ChkPeso".$Mes[$i]."_".str_replace("-","",$rut_proveedor);
					$Objeto1 = isset($_REQUEST[$Objeto])?$_REQUEST[$Objeto]:"";
					eval(" \$Valor= \"$Objeto1\";");
					
					//VERIFICA SI EXISTE EL REGISTRO
					//INSERTAR NUEVO REGISTRO POR PROVEEDOR
					$Consulta = "select * from age_web.programa_recepcion ";
					$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."' ";
					$Consulta.= " and cod_contrato='".$CmbContrato."'";
					$Consulta.= " and ano='".$Ano."' and tipo_programa='".$ChkTipoProg."'";
					$Consulta.= " and rut_proveedor='".$rut_proveedor."'";
					$RespAux = mysqli_query($link, $Consulta);
					if (!$FilaAux = mysqli_fetch_array($RespAux))
					{
						$Insertar = "insert into age_web.programa_recepcion (tipo_programa, cod_producto, cod_subproducto, cod_contrato, rut_proveedor, ano) ";
						$Insertar.= " values('".$ChkTipoProg."', '1','".$CmbSubProducto."','".$CmbContrato."', '".$rut_proveedor."','".$Ano."')";
						mysqli_query($link, $Insertar);
					}
					//ACTUALIZA
					$Actualizar = "UPDATE age_web.programa_recepcion set ";
					$Actualizar.= " ".$Mes[$i]." = '".$Valor."'";
					$Actualizar.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."'  and tipo_programa='".$ChkTipoProg."' ";
					$Actualizar.= " and cod_contrato='".$CmbContrato."' and rut_proveedor='".$rut_proveedor."' and ano='".$Ano."'";
					//echo $Actualizar;
					mysqli_query($link, $Actualizar);
				}
			}
			if (!$Existe)
			{
				//INSERTAR NUEVO REGISTRO POR PROVEEDOR
				$Consulta = "select * from age_web.programa_recepcion ";
				$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."' ";
				$Consulta.= " and cod_contrato='".$CmbContrato."'";
				$Consulta.= " and ano='".$Ano."' and tipo_programa='00'";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Insertar = "insert into age_web.programa_recepcion (tipo_programa, cod_producto, cod_subproducto, cod_contrato, rut_proveedor, ano) ";
					$Insertar.= " values('".$ChkTipoProg."', '1','".$CmbSubProducto."','".$CmbContrato."', '".$Fila["rut_proveedor"]."','".$Ano."')";
					mysqli_query($link, $Insertar);
				}
				//CONSULTA EL REGISTRO RECIEN CREADO
				$Consulta = "select * from age_web.programa_recepcion ";
				$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."' ";
				$Consulta.= " and cod_contrato='".$CmbContrato."' and ano='".$Ano."' and tipo_programa='".$ChkTipoProg."'";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{   
					$rut_proveedor = isset($Fila["rut_proveedor"])?$Fila["rut_proveedor"]:"";
					for ($i=1;$i<=12;$i++)
					{
						$Valor = 0;
						//$Objeto = "\$ChkPeso".$Mes[$i]."_".str_replace("-","",$Fila["rut_proveedor"]);
						//eval(" \$Valor= \"$Objeto\";");
						$Objeto  = "ChkPeso".$Mes[$i]."_".str_replace("-","",$rut_proveedor);
						$Objeto1 = isset($_REQUEST[$Objeto])?$_REQUEST[$Objeto]:"";
						eval(" \$Valor= \"$Objeto1\";");		
						
						$Actualizar = "UPDATE age_web.programa_recepcion set ";
						$Actualizar.= " ".$Mes[$i]." = '".$Valor."'";
						$Actualizar.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."' and tipo_programa='".$ChkTipoProg."' ";
						$Actualizar.= " and cod_contrato='".$CmbContrato."' and rut_proveedor='".$Fila["rut_proveedor"]."' and ano='".$Ano."'";
						mysqli_query($link, $Actualizar);
						//echo $Actualizar."<br>";
					}
				}
			}
			header("location:age_programa_recepcion.php?ChkTipoProg=".$ChkTipoProg."&Ano=".$Ano."&CmbSubProducto=".$CmbSubProducto."&CmbContrato=".$CmbContrato);
			break;
		case "E": //ELIMINA PROVEEDOR DEL PROGRAMA
			$RutProveedor = $ChkProv;
			$Eliminar = "delete from age_web.programa_recepcion ";
			$Eliminar.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."' ";
			$Eliminar.= " and cod_contrato='".$CmbContrato."' and rut_proveedor='".$RutProveedor."'";
			$Eliminar.= " and ano='".$Ano."'";
			mysqli_query($link, $Eliminar);
			header("location:age_programa_recepcion.php?Ano=".$Ano."&CmbSubProducto=".$CmbSubProducto."&CmbContrato=".$CmbContrato);
			break;
		case "AP": //AGREGA PROVEEDOR AL PROGRAMA
			if ($CmbProveedor=="V")
			{
				$Consulta = "select * from age_web.relaciones ";
				$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."'";
				$Consulta.= " and grupo='V'";
				$RespAux=mysqli_query($link, $Consulta);
				while ($FilaAux=mysqli_fetch_array($RespAux))
				{
					$Consulta = "select * from age_web.programa_recepcion ";
					$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."' ";
					$Consulta.= " and cod_contrato='".$CmbContrato."' and rut_proveedor='".$FilaAux["rut_proveedor"]."'";
					$Consulta.= " and ano='".$Ano."' and tipo_programa='00'";
					$Resp = mysqli_query($link, $Consulta);
					if (!$Fila = mysqli_fetch_array($Resp))
					{
						//INSERTAR NUEVO CONTRATO
						$Insertar = "insert into age_web.programa_recepcion (tipo_programa, cod_producto, cod_subproducto, cod_contrato, rut_proveedor, ano) ";
						$Insertar.= " values('00', '1','".$CmbSubProducto."','".$CmbContrato."', '".$FilaAux["rut_proveedor"]."','".$Ano."')";
						mysqli_query($link, $Insertar);
					}
				}
			}
			else
			{
				if ($CmbProveedor=="D")
					$CmbProveedor="99999999-9";
				$Consulta = "select * from age_web.programa_recepcion ";
				$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."' ";
				$Consulta.= " and cod_contrato='".$CmbContrato."' and rut_proveedor='".$CmbProveedor."'";
				$Consulta.= " and tipo_programa='00'";
				//$Consulta.= " and ano='".$Ano."' and tipo_programa='00'";
				$Resp = mysqli_query($link, $Consulta);
				//$Cont = mysqli_num_rows($Resp);				
				if (!$Fila = mysqli_fetch_array($Resp))
				{
					//INSERTAR NUEVO CONTRATO
					$Insertar = "insert into age_web.programa_recepcion (tipo_programa, cod_producto, cod_subproducto, cod_contrato, rut_proveedor, ano) ";
					$Insertar.= " values('00', '1','".$CmbSubProducto."','".$CmbContrato."', '".$CmbProveedor."','".$Ano."')";
					mysqli_query($link, $Insertar);
				}				
			}
			header("location:age_programa_recepcion.php?Ano=".$Ano."&CmbSubProducto=".$CmbSubProducto."&CmbContrato=".$CmbContrato);
			break;
		case "GC": //GRABA NUEVO CONTRATO
			$Consulta = "select * from age_web.contratos where cod_producto='1' and cod_subproducto='".$SubProducto."' ";
			$Consulta.= " and cod_contrato='".$TxtNumContrato."'";
			$Resp = mysqli_query($link, $Consulta);
			if (!$Fila = mysqli_fetch_array($Resp))
			{
				//INSERTAR NUEVO CONTRATO
				$Insertar = "insert into age_web.contratos (cod_producto, cod_subproducto, cod_contrato, descripcion, fecha_inicio, fecha_termino, cod_estado) ";
				$Insertar.= " values('1','".$SubProducto."','".$TxtNumContrato."', '".$TxtDescripContrato."','".$TxtFechaIni."','".$TxtFechaFin."', '".$EstadoContrato."')";
				mysqli_query($link, $Insertar);
			}
			header("location:age_programa_recepcion_contrato.php?Modif=S&SubProducto=".$SubProducto."&TxtNumContrato=".$TxtNumContrato);
			break;
		case "MC": //MODIFICA CONTRATO
			$Consulta = "select * from age_web.contratos where cod_producto='1' and cod_subproducto='".$SubProducto."' ";
			$Consulta.= " and cod_contrato='".$TxtNumContrato."'";
			echo $Consulta;
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				//MODIFICA CONTRATO
				$Actualizar = "UPDATE age_web.contratos SET ";
				$Actualizar.= " fecha_inicio = '".$TxtFechaIni."', fecha_termino='".$TxtFechaFin."', ";
				$Actualizar.="  cod_estado='".$EstadoContrato."', descripcion='".$TxtDescripContrato."' ";
				$Actualizar.= " where cod_producto='1' and cod_subproducto='".$SubProducto."' ";
				$Actualizar.= " and cod_contrato='".$TxtNumContrato."'";
				mysqli_query($link, $Actualizar);
			}
			header("location:age_programa_recepcion_contrato.php?Modif=S&SubProducto=".$SubProducto."&TxtNumContrato=".$TxtNumContrato);
			break;
		case "EC": //ELIMINA CONTRATO
			$Eliminar = "delete from age_web.contratos ";
			$Eliminar.= " where cod_producto='1' and cod_subproducto='".$SubProducto."' ";
			$Eliminar.= " and cod_contrato='".$TxtNumContrato."'";
			mysqli_query($link, $Eliminar);			
			//ELIMINA PROGRAMA DE RECEPCION
			$Eliminar = "delete from age_web.programa_recepcion ";
			$Eliminar.= " where cod_producto='1' and cod_subproducto='".$SubProducto."' ";
			$Eliminar.= " and cod_contrato='".$TxtNumContrato."'";
			mysqli_query($link, $Eliminar);	
			header("location:age_programa_recepcion_contrato.php");
			break;
		case "LC":
			header("location:age_programa_recepcion_contrato.php");
			break;
	}
?>