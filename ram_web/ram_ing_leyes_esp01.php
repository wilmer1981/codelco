<?
	include("../principal/conectar_principal.php");
	if($H2O=='')
		$H2O=0;
	if($Cu=='')
		$Cu=0;
	if($Ag=='')
		$Ag=0;
	if($Au=='')
		$Au=0;
	if($As=='')
		$As=0;
	if($S=='')
		$S=0;
	if($Pb=='')
		$Pb=0;
	if($Fe=='')
		$Fe=0;
	if($Si=='')
		$Si=0;
	if($CaO=='')
		$CaO=0;
	if($AL2O3=='')
		$AL2O3=0;
	if($MgO=='')
		$MgO=0;
	if($Sb=='')
		$Sb=0;
	if($Cd=='')
		$Cd=0;
	if($Hg=='')
		$Hg=0;
	if($Te=='')
		$Te=0;
	if($Zn=='')
		$Zn=0;
	if($Fe3O4=='')
		$Fe3O4=0;
	switch ($Proceso)
	{
		case "G":
			$Consulta = "select * from ram_web.leyes_especiales ";
			$Consulta.= " where cod_producto = '".$Productos."' ";
			$Consulta.= " and cod_subproducto = '".$SubProductos."' ";
			$Consulta.= " and num_conjunto = '".$Conjunto."'";
			$Consulta.= " and tipo_ley = '".$TipoLey."'";
			$Consulta.= " and fecha = '".$Ano."-".$Mes."-01'";
			$Respuesta = mysql_query($Consulta);
			if ($Fila = mysql_fetch_array($Respuesta))
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
				mysql_query($Actualizar);
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
				mysql_query($Insertar);
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
			mysql_query($Eliminar);
			header("location:ram_ing_leyes_esp.php?Productos=".$Productos."&SubProductos=".$SubProductos."&Conjunto=".$Conjunto."&TipoLey=".$TipoLey."&Ano=".$Ano."&Mes=".$Mes);
			break;
	}
?>