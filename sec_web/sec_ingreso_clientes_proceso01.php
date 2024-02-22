<?php
	include("../principal/conectar_fac_web.php");
	$RutCliente=$TxtRut."-".$TxtDv;
	$Regiones =array("I Regi�n","II Regi�n","III Regi�n","IV Regi�n","V Regi�n","VI Regi�n","VII Regi�n","VIII Regi�n","IX Regi�n","X Regi�n","XI Regi�n","XII Regi�n","Regi�n Metrop.");	
	$DirecGuiaDespacho=$TxtDireccion;
	if ($TxtCiudad!='')
	{
		$DirecGuiaDespacho=$TxtDireccion." ".$TxtCiudad;
	}
	if ($TxtComuna!='')
	{
		$DirecGuiaDespacho=eregi_replace($TxtComuna,'',$DirecGuiaDespacho)." ".$TxtComuna;
	}	
	if ($cmbregion!='-1')
	{
		$DirecGuiaDespacho=$DirecGuiaDespacho." ".$Region;
		$Region=$Regiones[$cmbregion];
	}
	if ($CheckVD==on)
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
				$TxtId = $Fila[Id];
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
				$TxtId = $Fila[Id];
				$Insertar = "insert into sec_web.sub_cliente_vta(Id,cod_cliente,rut_cliente,cod_sub_cliente,ciudad,comuna,direccion,region,representante,fono,celular)";
				$Insertar = $Insertar." values('$TxtId','$TxtCodigo','$RutCliente','001','$TxtCiudad','$TxtComuna','$DirecGuiaDespacho','$cmbregion','$TxtRepresentante','$TxtTelefono','$TxtTelefono2')";
				mysqli_query($link, $Insertar);
			}
			break;
		case "E":
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