<?php
	include("../principal/conectar_fac_web.php");

	$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$TxtCodigo = isset($_REQUEST["TxtCodigo"])?$_REQUEST["TxtCodigo"]:"";
	$TxtRut    = isset($_REQUEST["TxtRut"])?$_REQUEST["TxtRut"]:"";
	$TxtDv     = isset($_REQUEST["TxtDv"])?$_REQUEST["TxtDv"]:"";
	$TxtNombre     = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$TxtNombre2    = isset($_REQUEST["TxtNombre2"])?$_REQUEST["TxtNombre2"]:"";
	$TxtDireccion  = isset($_REQUEST["TxtDireccion"])?$_REQUEST["TxtDireccion"]:"";
	$TxtCiudad     = isset($_REQUEST["TxtCiudad"])?$_REQUEST["TxtCiudad"]:"";
	$TxtComuna     = isset($_REQUEST["TxtComuna"])?$_REQUEST["TxtComuna"]:"";
	$TxtRepresentante = isset($_REQUEST["TxtRepresentante"])?$_REQUEST["TxtRepresentante"]:"";
	$cmbregion        = isset(isset($_REQUEST["cmbregion"])?$_REQUEST["cmbregion"]:"";
	$TxtTelefono      = isset($_REQUEST["TxtTelefono"])?$_REQUEST["TxtTelefono"]:"";
	$TxtTelefono2     = isset($_REQUEST["TxtTelefono2"])?$_REQUEST["TxtTelefono2"]:"";
	$CheckVD          = isset($_REQUEST["CheckVD"])?$_REQUEST["CheckVD"]:"";
	
	$RutCliente=$TxtRut."-".$TxtDv;
	$Regiones =array("I Región","II Región","III Región","IV Región","V Región","VI Región","VII Región","VIII Región","IX Región","X Región","XI Región","XII Región","Región Metrop.");	
	$DirecGuiaDespacho=$TxtDireccion;
	if ($TxtCiudad!='')
	{
		$DirecGuiaDespacho=$TxtDireccion." ".$TxtCiudad;
	}
	if ($TxtComuna!='')
	{
		//$DirecGuiaDespacho=eregi_replace($TxtComuna,'',$DirecGuiaDespacho)." ".$TxtComuna;
		//$DirecGuiaDespacho=preg_replace($TxtComuna,'',$DirecGuiaDespacho)." ".$TxtComuna;
		$DirecGuiaDespacho=mb_eregi_replace($TxtComuna,'',$DirecGuiaDespacho)." ".$TxtComuna;
	}	
	$Region="";
	if ($cmbregion!='-1')
	{
		$DirecGuiaDespacho=$DirecGuiaDespacho." ".$Region;
		$Region=$Regiones[$cmbregion];
	}
	if ($CheckVD=="on")
	{
		$CheckVD='V';
	}
	else
	{
		$CheckVD='';
	}
	switch ($Proceso)
	{
		case "N":
			$Consulta="SELECT * from sec_web.cliente_venta where rut='".$RutCliente."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Mensaje='Rut Ingresado ya Existe';
				$Variables="Mensaje=".$Mensaje."&TxtRut=".$TxtRut."&TxtDv=".$TxtDv."&TxtNombre=".$TxtNombre."&TxtDireccion=".$TxtDireccion."&TxtCiudad=".$TxtCiudad."&TxtComuna=".$TxtComuna."&cmbregion=".$cmbregion."&TxtRepresentante=".$TxtRepresentante."&TxtTelefono=".$TxtTelefono."&TxtTelefono2=".$TxtTelefono2;
				header("location:sec_ingreso_clientes_proceso.php?Proceso=N&".$Variables);
			}
			else
			{
				$Consulta="SELECT * from sec_web.cliente_venta where ";
				$Insertar="insert into sec_web.cliente_venta (cod_cliente,sigla_cliente,rut,nombre_cliente,direccion,ciudad,comuna,region,representante,fono1,fono2,tipo,direccion2) values (";
				$Insertar = $Insertar."'$TxtCodigo','$TxtNombre','$RutCliente','$TxtNombre2','$DirecGuiaDespacho','$TxtCiudad','$TxtComuna','$cmbregion','$TxtRepresentante','$TxtTelefono','$TxtTelefono2','$CheckVD','$TxtDireccion')";
				mysqli_query($link, $Insertar);
				$Consulta = "SELECT ceiling(ifnull(max(Id),0))+1 as Id FROM sec_web.sub_cliente_vta";
				$rs = mysqli_query($link, $Consulta);	
				$Fila = mysqli_fetch_array($rs);
				$TxtId = $Fila["Id"];
				$Insertar = "INSERT INTO sec_web.sub_cliente_vta(Id,cod_cliente,rut_cliente,cod_sub_cliente,ciudad,comuna,direccion,region,representante,fono,celular)";
				$Insertar = $Insertar." values('$TxtId','$TxtCodigo','$RutCliente','001','$TxtCiudad','$TxtComuna','$DirecGuiaDespacho','$cmbregion','$TxtRepresentante','$TxtTelefono','$TxtTelefono2')";
				mysqli_query($link, $Insertar);
			}	
			break;
		case "M":
			$Modificar="UPDATE sec_web.cliente_venta set rut='$RutCliente',sigla_cliente='$TxtNombre2',nombre_cliente='$TxtNombre',comuna='$TxtComuna',region='$cmbregion',direccion='$DirecGuiaDespacho',ciudad='$TxtCiudad',representante='$TxtRepresentante',fono1='$TxtTelefono',fono2='$TxtTelefono2',Direccion2='$TxtDireccion',tipo='$CheckVD' where cod_cliente='".$TxtCodigo."'";
			mysqli_query($link, $Modificar);
			$Consulta="SELECT * from sec_web.sub_cliente_vta where cod_cliente='".$TxtCodigo."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
			{
				$Modificar="UPDATE sec_web.sub_cliente_vta set rut_cliente='$RutCliente',comuna='$TxtComuna',region='$cmbregion',direccion='$DirecGuiaDespacho',ciudad='$TxtCiudad',representante='$TxtRepresentante',fono='$TxtTelefono',celular='$TxtTelefono2' where cod_cliente='".$TxtCodigo."'";
				mysqli_query($link, $Modificar);
			}
			else
			{
				$Consulta = "SELECT ceiling(ifnull(max(Id),0))+1 as Id FROM sec_web.sub_cliente_vta";
				$rs = mysqli_query($link, $Consulta);	
				$Fila = mysqli_fetch_array($rs);
				$TxtId = $Fila["Id"];
				$Insertar = "insert into sec_web.sub_cliente_vta(Id,cod_cliente,rut_cliente,cod_sub_cliente,ciudad,comuna,direccion,region,representante,fono,celular)";
				$Insertar = $Insertar." values('$TxtId','$TxtCodigo','$RutCliente','001','$TxtCiudad','$TxtComuna','$DirecGuiaDespacho','$cmbregion','$TxtRepresentante','$TxtTelefono','$TxtTelefono2')";
				mysqli_query($link, $Insertar);
			}
			break;
		case "E":
			$Valores   = $_REQUEST["Valores"];
			$EncontroRelacion=false;
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$CodCliente=$Datos[0];
				$Eliminar ="delete from sec_web.cliente_venta where cod_cliente='".$CodCliente."' and tipo='V'";
				mysqli_query($link, $Eliminar);
				$Eliminar ="delete from sec_web.sub_cliente_vta where cod_cliente='".$CodCliente."'";
				mysqli_query($link, $Eliminar);
			}
			break;	
	}
	if ($Proceso=="E")
	{
		header("location:sec_ingreso_clientes.php?EncontroRelacion=".$EncontroRelacion);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngCliente.action='sec_ingreso_clientes.php';";
		echo "window.opener.document.FrmIngCliente.submit();";
		echo "window.close();";
		echo "</script>";	
	}
?>