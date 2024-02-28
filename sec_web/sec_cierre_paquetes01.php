<?php
	include("../principal/conectar_principal.php");
	$Cierre = $_REQUEST["Cierre"];
	$Func   = $_REQUEST["Func"];
	$TxtFechaFin   = $_REQUEST["TxtFechaFin"];
	$TxtGuia       = $_REQUEST["TxtGuia"];

	$Entro=false;
	$Consulta = "select  distinct cod_paquete,num_paquete,t2.cod_bulto,t2.num_bulto,t2.corr_enm,t2.fecha_guia,t2.num_guia ";
	$Consulta.=" from sec_web.det_guia_despacho_emb t1";
	$Consulta.=" inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia ";
	$Consulta.=" where t2.num_guia='".$TxtGuia."' and t2.fecha_guia = '".$TxtFechaFin."'";
	$Consulta.=" order by cod_paquete,num_paquete ";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		$Entro=true;
		$Consulta=" select num_unidades,peso_paquetes,t2.cod_estado,t2.cod_producto,t2.cod_subproducto, ";
		$Consulta.=" t2.fecha_creacion_paquete ";
		$Consulta.=" from sec_web.lote_catodo t1 ";
		$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
		$Consulta.=" and t1.num_paquete=t2.num_paquete and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
		$Consulta.=" where cod_bulto='".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."' and corr_enm='".$Fila["corr_enm"]."' 	";
		$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  	";
		$Consulta.=" and t1.cod_paquete='".$Fila["cod_paquete"]."' and t2.num_paquete='".$Fila["num_paquete"]."'";
		$Resp1=mysqli_query($link, $Consulta);
		if($Fila4=mysqli_fetch_array($Resp1))
		{
			if($Fila4["cod_estado"] == 'a')
			{
				$Actualizar=" UPDATE sec_web.lote_catodo set cod_estado ='c'  where  ";
				$Actualizar.="  cod_bulto='".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."' and corr_enm='".$Fila["corr_enm"]."' 	";
				$Actualizar.=" and cod_paquete='".$Fila["cod_paquete"]."' and num_paquete='".$Fila["num_paquete"]."'";
				$Actualizar.=" and fecha_creacion_paquete ='".$Fila4["fecha_creacion_paquete"]."' ";	
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				$Actualizar=" UPDATE sec_web.paquete_catodo set cod_estado ='c',fecha_embarque='".$Fila["fecha_guia"]."',num_guia='".$Fila["num_guia"]."'  ";
				//$Actualizar.="  and corr_enm='".$Fila["corr_enm"]."' 	";
				$Actualizar.="   where cod_paquete='".$Fila["cod_paquete"]."' and num_paquete='".$Fila["num_paquete"]."'";
				$Actualizar.=" and fecha_creacion_paquete ='".$Fila4["fecha_creacion_paquete"]."' ";	
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			
			}
		}	
		$Consulta="select count(cod_estado) as cantidad from sec_web.lote_catodo where cod_bulto ='".$Fila["cod_bulto"]."' ";
		$Consulta.=" and num_bulto='".$Fila["num_bulto"]."' and corr_enm='".$Fila["corr_enm"]."'     ";
		$Resp=mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		if($Fila1=mysqli_fetch_array($Resp))
		{
			$Consulta="select count(cod_estado) as cantidad from sec_web.lote_catodo where cod_bulto ='".$Fila["cod_bulto"]."' ";
			$Consulta.=" and num_bulto='".$Fila["num_bulto"]."' and corr_enm='".$Fila["corr_enm"]."' and cod_estado='c'    ";
			$Resp2=mysqli_query($link, $Consulta);
			if($Fila2=mysqli_fetch_array($Resp2))
			{
				if($Fila1["cantidad"] == $Fila2["cantidad"])
				{
					$Actualizar="UPDATE  sec_web.embarque_ventana set despacho_paquetes=bulto_paquetes ";
					$Actualizar.=" , despacho_peso=bulto_peso  where corr_enm = '".$Fila["corr_enm"]."' and   ";
					$Actualizar.=" cod_bulto= '".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."'  ";
					mysqli_query($link, $Actualizar);
					//echo $Actualizar."<br>";
				}
			}
		
		}
	}
	header("location:sec_cierre_paquetes.php?TxtGuia=".$TxtGuia."&TxtFechaFin=".$TxtFechaFin);
	/*
	
	
//	echo $ValoresAux;
	switch ($Proceso)
	{
		case "N":
			$Existe=false;
			$Consulta="select * from interfaces_codelco.ordenes_produccion where ";
			$Consulta.="  asignacion ='".$CmbAsignacion."' and cod_producto='".$CmbProducto."' ";
			$Consulta.=" and cod_subproducto='".$CmbSubProducto."' and ucase(codigo_op)='".strtoupper($TxtOP)."' ";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if($Fila=mysqli_fetch_array($Resp))
			{
				$Existe=true;
				header("location:inter_orden_produccion_proceso.php?Existe=".$Existe."&Proceso=".$Proceso);
			}
			else
			{
				$Insertar=" insert into interfaces_codelco.ordenes_produccion ";
				$Insertar.=" (asignacion,cod_producto,cod_subproducto,codigo_op,cod_material_sap,unidad_medida, ";
				$Insertar.=" centro,clase_valorizacion ";
				$Insertar.=" ) values(";
				$Insertar.=" '".$CmbAsignacion."','".$CmbProducto."','".$CmbSubProducto."',";
				$Insertar.=" '".strtoupper($TxtOP)."','".$CmbMateriales."','".$CmbUnidad."','".$CmbDivision."',";
				$Insertar.=" '".strtoupper($TxtClase)."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
				echo "<script languaje='JavaScript'>";
				echo "window.opener.document.frmPrincipal.action='inter_orden_produccion.php';";
				echo "window.opener.document.frmPrincipal.submit();";
				echo "window.close();</script>";	
			}
		break;
		case "E":
			$Datos = explode("//",$Valores);
			foreach($Datos as $clave => $Codigo)
			{
				$arreglo=explode("~",$Codigo);
				$Eliminar=" delete from interfaces_codelco.ordenes_produccion ";
				$Eliminar.=" where ";
				if($arreglo[0] == "")
					$Eliminar.="  isnull(asignacion) ";
				else
					$Eliminar.=" asignacion='".$arreglo[0]."' ";
				$Eliminar.=" and cod_producto='".$arreglo[1]."' and ";
				$Eliminar.=" cod_subproducto = '".$arreglo[2]."' and ucase(codigo_op)='".strtoupper($arreglo[3])."'  ";
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";
			}
			header("location:inter_orden_produccion.php");
		break;
		case "M":
			$Datos2=explode('~',$Valores);
			$Asignacion=$Datos2[0];
			$Producto=$Datos2[1];
			$SubProducto=$Datos2[2];
			$OP=$Datos2[3];
			$Actualizar=" UPDATE  interfaces_codelco.ordenes_produccion set ";
			$Actualizar.="  asignacion ='".$CmbAsignacion."',cod_producto='".$CmbProducto."',   ";
			$Actualizar.="  cod_subproducto='".$CmbSubProducto."' , codigo_op = '".strtoupper($OP)."', ";
			$Actualizar.="  cod_material_sap='".$CmbMateriales."' , unidad_medida = '".$CmbUnidad."', ";
			$Actualizar.="  centro='".$CmbDivision."' , clase_valorizacion = '".strtoupper($TxtClase)."' ";
			$Actualizar.=" where ";
			if($Asignacion == "")
				$Actualizar.="  isnull(asignacion) ";
			else	
				$Actualizar.=" asignacion='".$Asignacion."' ";
			$Actualizar.=" and cod_producto='".$Producto."' and ";
			$Actualizar.=" cod_subproducto = '".$SubProducto."' and ucase(codigo_op)='".strtoupper($OP)."'  ";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar;
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='inter_orden_produccion.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";	
		break;
	}*/
?>