<?php
	include("../principal/conectar_sec_web.php");

	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$cmbproducto  = isset($_REQUEST["cmbproducto"])?$_REQUEST["cmbproducto"]:"-1";
	$cmbsubproducto  = isset($_REQUEST["cmbsubproducto"])?$_REQUEST["cmbsubproducto"]:"-1";
	$TxtNombreGDE  = isset($_REQUEST["TxtNombreGDE"])?$_REQUEST["TxtNombreGDE"]:"";
	$TxtCodSAP  = isset($_REQUEST["TxtCodSAP"])?$_REQUEST["TxtCodSAP"]:"";
	$TxtUnidadSAP  = isset($_REQUEST["TxtUnidadSAP"])?$_REQUEST["TxtUnidadSAP"]:"";
	$CheckEst   = isset($_REQUEST["CheckEst"])?$_REQUEST["CheckEst"]:"";

	$TxtRut     = isset($_REQUEST["TxtRut"])?$_REQUEST["TxtRut"]:"";
	$TxtDv      = isset($_REQUEST["TxtDv"])?$_REQUEST["TxtDv"]:"";

	$RutOriginador=$TxtRut."-".$TxtDv;
	if($CheckEst == ''){
		$CheckEst = 0;
	}
	
	switch ($Proceso)
	{
		case "N":
			$Insertar="insert into sec_web.homologacion_producto_sap (cod_producto_sec,cod_subproducto_sec,denominacion_sap,cod_unidad_sap,codigo_material) values (";
			$Insertar= $Insertar."'".$cmbproducto."','".$cmbsubproducto."','".$TxtNombreGDE."','".$TxtUnidadSAP."','".$TxtCodSAP."')";
			/*echo $Insertar;*/
			$respuesta=mysqli_query($link, $Insertar);
			if(!$respuesta)
			{

				 $Msg = "Error: Registro no se creó correctamente.";	
			}
			else
			{
				 $Msg = "Registro creado correctamente.";
			}
		break;

		case "M":		
			$Modificar="UPDATE sec_web.homologacion_producto_sap set DENOMINACION_SAP='".$TxtNombreGDE."',COD_UNIDAD_SAP='".$TxtUnidadSAP."',CODIGO_MATERIAL='".$TxtCodSAP."' where cod_producto_sec='".$cmbproducto."' and cod_subproducto_sec='".$cmbsubproducto."'";
			$respuesta=mysqli_query($link, $Modificar);
			if(!$respuesta)
			{
				 $Msg = "Error: Registro no se modifico correctamente";
			}
			else
			{
				 $Msg = "Registro modificado correctamente.";

			}
		break;
		case "E":
			$reg_delete=false;
			$EncontroRelacion=false;
			/*echo $Valores;*/
			$Datos = explode("//", $Valores);
			for ($i=0;$i<=count($Datos);$i++)
			{
				if($Datos[$i]!='')
				{
					$Matriz=explode("-",$Datos[$i]);
					$Consulta = "select * from sec_web.guia_despacho_emb t1";
					$Consulta.= " inner join sec_web.embarque_ventana t2 on t1.corr_enm=t2.corr_enm where t2.cod_producto='".$Matriz[0]."' and t2.cod_subproducto='".$Matriz[1]."'";
					$Resultado=mysqli_query($link, $Consulta);
					if (!$Fila=mysqli_fetch_array($Resultado))
					{
						$Eliminar ="delete from sec_web.homologacion_producto_sap where cod_producto_sec='".$Matriz[0]."' and cod_subproducto_sec='".$Matriz[1]."'";
						mysqli_query($link, $Eliminar);
						/*echo $Eliminar;*/
						$reg_delete=true;
					}
					else
					{
					$EncontroRelacion=true;
					}
				}
			}
		break;	

	}
	if ($Proceso=="E")
	{

		header("location:sec_producto.php?EncontroRelacion=".$EncontroRelacion."&reg_delete=".$reg_delete);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmProducto.action='sec_producto.php?Msg=".$Msg."';";
		echo "window.opener.document.FrmProducto.submit();";
		//echo "window.close();";
		echo "</script>";
	}	

?>