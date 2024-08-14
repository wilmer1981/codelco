<?php
	include("../principal/conectar_principal.php");
	$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Productos    = isset($_REQUEST["Productos"])?$_REQUEST["Productos"]:"";
	$SubProductos = isset($_REQUEST["SubProductos"])?$_REQUEST["SubProductos"]:"";
	$Conjunto     = isset($_REQUEST["Conjunto"])?$_REQUEST["Conjunto"]:"";
	$CodConjunto  = isset($_REQUEST["CodConjunto"])?$_REQUEST["CodConjunto"]:"";
	$TipoLey      = isset($_REQUEST["TipoLey"])?$_REQUEST["TipoLey"]:"";
	$Ano      = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";
	$Mes      = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:"";
	
	$H2O      = isset($_REQUEST["H2O"])?$_REQUEST["H2O"]:0;
	$Cu       = isset($_REQUEST["Cu"])?$_REQUEST["Cu"]:0;
	$Ag       = isset($_REQUEST["Ag"])?$_REQUEST["Ag"]:0;
	$Au       = isset($_REQUEST["Au"])?$_REQUEST["Au"]:0;
	$As       = isset($_REQUEST["As"])?$_REQUEST["As"]:0;
	$S        = isset($_REQUEST["S"])?$_REQUEST["S"]:0;
	$Pb       = isset($_REQUEST["Pb"])?$_REQUEST["Pb"]:0;
	$Fe       = isset($_REQUEST["Fe"])?$_REQUEST["Fe"]:0;
	$Si       = isset($_REQUEST["Si"])?$_REQUEST["Si"]:0;
	$CaO      = isset($_REQUEST["CaO"])?$_REQUEST["CaO"]:0;
	$AL2O3    = isset($_REQUEST["AL2O3"])?$_REQUEST["AL2O3"]:0;
	$MgO      = isset($_REQUEST["MgO"])?$_REQUEST["MgO"]:0;
	$Sb       = isset($_REQUEST["Sb"])?$_REQUEST["Sb"]:0;
	$Cd       = isset($_REQUEST["Cd"])?$_REQUEST["Cd"]:0;
	$Hg       = isset($_REQUEST["Hg"])?$_REQUEST["Hg"]:0;
	$Te       = isset($_REQUEST["Te"])?$_REQUEST["Te"]:0;
	$Zn       = isset($_REQUEST["Zn"])?$_REQUEST["Zn"]:0;
	$Fe3O4    = isset($_REQUEST["Fe3O4"])?$_REQUEST["Fe3O4"]:0;

	switch ($Proceso)
	{
		case "G":
			$Consulta = "select * from ram_web.leyes_especiales ";
			$Consulta.= " where cod_producto = '".$Productos."' ";
			$Consulta.= " and cod_subproducto = '".$SubProductos."' ";
			$Consulta.= " and num_conjunto = '".$Conjunto."'";
			$Consulta.= " and tipo_ley = '".$TipoLey."'";
			$Consulta.= " and fecha = '".$Ano."-".$Mes."-01'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				//ACTUALIZA
				$Actualizar = "update ram_web.leyes_especiales set ";
				$Actualizar.= " v_h2o = '".str_replace(",",".",$H2O)."'";
				$Actualizar.= ",v_cu = '".str_replace(",",".",$Cu)."'";
				$Actualizar.= ",v_ag = '".str_replace(",",".",$Ag)."'";
				$Actualizar.= ",v_au = '".str_replace(",",".",$Au)."'";
				$Actualizar.= ",v_as = '".str_replace(",",".",$As)."'";
				$Actualizar.= ",v_s = '".str_replace(",",".",$S)."'";
				$Actualizar.= ",v_pb = '".str_replace(",",".",$Pb)."'";
				$Actualizar.= ",v_fe = '".str_replace(",",".",$Fe)."'";
				$Actualizar.= ",v_si = '".str_replace(",",".",$Si)."'";
				$Actualizar.= ",v_cao = '".str_replace(",",".",$CaO)."'";
				$Actualizar.= ",v_al2o3 = '".str_replace(",",".",$AL2O3)."'";
				$Actualizar.= ",v_mgo = '".str_replace(",",".",$MgO)."'";
				$Actualizar.= ",v_sb = '".str_replace(",",".",$Sb)."'";
				$Actualizar.= ",v_cd = '".str_replace(",",".",$Cd)."'";
				$Actualizar.= ",v_hg = '".str_replace(",",".",$Hg)."'";
				$Actualizar.= ",v_te = '".str_replace(",",".",$Te)."'";
				$Actualizar.= ",v_zn = '".str_replace(",",".",$Zn)."'";
				$Actualizar.= ",v_fe3o4 = '".str_replace(",",".",$Fe3O4)."'";
				$Actualizar.= " where cod_producto = '".$Productos."' ";
				$Actualizar.= " and cod_subproducto = '".$SubProductos."' ";
				$Actualizar.= " and cod_conjunto = '".$CodConjunto."'";
				$Actualizar.= " and num_conjunto = '".$Conjunto."' ";
				$Actualizar.= " and tipo_ley = '".$TipoLey."' ";
				$Actualizar.= " and fecha = '".$Ano."-".$Mes."-01'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar;
			}
			else
			{
				//INSERTA
				$Insertar = "insert into ram_web.leyes_especiales (cod_producto,cod_subproducto,cod_conjunto,num_conjunto,fecha,";
				$Insertar.= "v_h2o,v_cu,v_ag,v_au,v_as,v_s,v_pb,v_fe,v_si,v_cao,v_al2o3,v_mgo,v_sb,v_cd,v_hg,v_te,v_zn,v_fe3o4, tipo_ley) ";
				$Insertar.= " values('".$Productos."','".$SubProductos."','".$CodConjunto."','".$Conjunto."','".$Ano."-".$Mes."-01','".str_replace(",",".",$H2O)."','".str_replace(",",".",$Cu)."'";
				$Insertar.= ",'".str_replace(",",".",$Ag)."','".str_replace(",",".",$Au)."','".str_replace(",",".",$As)."','".str_replace(",",".",$S)."','".str_replace(",",".",$Pb)."'";
				$Insertar.= ",'".str_replace(",",".",$Fe)."','".str_replace(",",".",$Si)."','".str_replace(",",".",$CaO)."','".str_replace(",",".",$AL2O3)."','".str_replace(",",".",$MgO)."','".str_replace(",",".",$Sb)."'";
				$Insertar.= ",'".str_replace(",",".",$Cd)."','".str_replace(",",".",$Hg)."','".str_replace(",",".",$Te)."','".str_replace(",",".",$Zn)."','".str_replace(",",".",$Fe3O4)."','".$TipoLey."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar;
			}
			header("location:ram_ing_leyes_esp.php?Productos=".$Productos."&SubProductos=".$SubProductos."&Conjunto=".$Conjunto."&TipoLey=".$TipoLey."&Ano=".$Ano."&Mes=".$Mes);
			break;
		case "E":
			$Eliminar = "delete from ram_web.leyes_especiales ";
			$Eliminar.= " where cod_producto = '".$Productos."' ";
			$Eliminar.= " and cod_subproducto = '".$SubProductos."' ";
			$Eliminar.= " and num_conjunto = '".$Conjunto."'";
			$Eliminar.= " and tipo_ley = '".$TipoLey."'";
			$Eliminar.= " and fecha = '".$Ano."-".$Mes."-01'";
			mysqli_query($link, $Eliminar);
			header("location:ram_ing_leyes_esp.php?Productos=".$Productos."&SubProductos=".$SubProductos."&Conjunto=".$Conjunto."&TipoLey=".$TipoLey."&Ano=".$Ano."&Mes=".$Mes);
			break;
	}
?>