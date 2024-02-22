<?php
	include ("conectar_principal.php");
	$FechaHora=date("Y-m-d H:i:s");

	//agregadoi por WSO
	$P_Actual  = $_REQUEST["P_Actual"]; 
	$P_Nueva   = $_REQUEST["P_Nueva"]; 
	$P_NuevaRN = $_REQUEST["P_RNueva"]; 
	
	$CookieRut = $_COOKIE["CookieRut"];
	$Proceso = $_REQUEST["Proceso"];    
	$Pag     = $_REQUEST["Pag"]; 

	//Junio 2017 Consulta el parametro de cantidad de contraseñas a evaluar
	$ConsulPass="select valor from parametros_auditoria where codigo=4";
	$RespPass=mysqli_query($link, $ConsulPass);

	if($Fila=mysqli_fetch_assoc($RespPass))
		$cantPass = $Fila["valor"];

	switch ($Proceso)
	{
		case "G":		
			$Consulta = "select * from funcionarios where rut = '".$CookieRut."'";
			$Resultado = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Resultado))
			{
				$Consulta = "select * from funcionarios ";
				$Consulta.= " where rut = '".$CookieRut."' ";
				$Consulta.= " and password=md5('".strtoupper(trim($P_Actual))."')";
				$RsAux=mysqli_query($link, $Consulta);			
				if ($RowAux=mysqli_fetch_array($RsAux))				
				{
					//Junio 2017 Consulta las ultimas contraseñas utilizadas por el usuario y valida que la nueva pwd sea distinta
			   		$ConsultaPass="select password from password_funcionario where rut='".$CookieRut."' order by fecha_creacion desc limit ".$cantPass;
			   		$RespPwd=mysqli_query($link, $ConsultaPass);
			   		$diff=true;
					while($Fila=mysqli_fetch_assoc($RespPwd))
					{
						if (md5(strtoupper(trim($P_Nueva)))==$Fila["password"])
						{
							$diff=false;
							$Mensaje=' Ya ha utilizado esta password. Por favor ingrese una distinta.';
							$cod=3;
							break;
						}						
					}
					if($diff==true)	  
					{
						$PassAux = strtoupper(trim($Row["password"]));
						$P_Actual = strtoupper(trim($P_Actual));
						$P_Nueva = strtoupper(trim($P_Nueva));
						$Actualizar = "UPDATE funcionarios set password = md5('".$P_Nueva."') ";
						$Actualizar.= " , fecha_cambio_password = '".date("Y-m-d")."' ";
						$Actualizar.= " where rut = '".$CookieRut."'";
						mysqli_query($link, $Actualizar);
						$Consulta = "select * from proyecto_modernizacion.funcionarios ";
						$Consulta.= " where rut = '".$CookieRut."'";
						$Respuesta = mysqli_query($link, $Consulta);
						$Row = mysqli_fetch_array($Respuesta);
						//echo "Consulta:".$row;
						

						if ($Row = mysqli_fetch_array($Respuesta))
						{
							if (!is_null($Row["password2"]) and ($Row["password2"] != ""))
							{
								$Actualizar = "UPDATE funcionarios set password2 = md5('".$P_Nueva."') ";
								$Actualizar.= " , fecha_cambio_password = '".date("Y-m-d")."' ";
								$Actualizar.= " where rut = '".$CookieRut."'";
								mysqli_query($link, $Actualizar);
							}								
						}
						//Junio 2017 Inserta registro en tabla password_usuario	
					   $Guarda = "insert into password_funcionario (rut,password,fecha_creacion) values('".$CookieRut."',md5('".$P_Nueva."'),'".$FechaHora."')";	
					   mysqli_query($link, $Guarda);
					   //Junio 2017 Borra las pwd mas antiguas
				   		$ConsultaBoraraPwd= "delete from password_funcionario where id <= (select id from(select id from password_funcionario where rut='".$CookieRut."' order by fecha_creacion desc limit 1 offset ".$cantPass.")foo) and rut='".$CookieRut."'";
				   		mysqli_query($link, $ConsultaBoraraPwd);
					   $Mensaje = "Cambio exitoso. Debe ingresar al sistema con su nueva clave.";
					   $cod=1;
					}
				}
				else
				{
					$Mensaje = "Datos ingresados incorrectos.";
					$cod=2;
				}
			}
			break;
	}	
	if ($Pag=="pass02")
	{
		header("location:password02.php?Titulo2=".$Mensaje."&codigo=".$cod);
	}else
		header("location:password.php?mensaje=".$Mensaje."&codigo=".$cod);
?>
<html>
<head>
<title>Cambio de Contrase&ntilde;a</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
/*function Proceso(opt,opt2)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "A":
			alert(<?php echo json_encode($Mensaje);?>);
		case "C":
			//alert(opt2);
			if (opt2=='')
			{
				alert(<?php echo json_encode($Mensaje);?>);
			}
			else
			{
				alert(<?php echo json_encode($Mensaje);?>);
			}
			break
	}
}*/
//-->
</script>
<!--
<body background="imagenes/fondo3.gif" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
  <br>
  <table width="100%" border="0" cellspacing="1" cellpadding="5" class="TablaInterior">
    <tr>
      <td align="center" valign="middle"><strong><?php echo $Mensaje; ?>&nbsp;</strong></td>
    </tr>
  </table>
  <br>
  <table width="100%" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr align="center" valign="middle"> 
      <td> 
      <?php
      if($Pag!=""&&$Pag!="X")
	  {
	  ?>
        <input type='button' name='BtnAceptar' value='Aceptar' onClick="JavaScript:Proceso('A');"  style='width:70px;'>
        <?php
	  }
		?>
        &nbsp; 
        <input name="BtnCerrar" type="button" style="width:70px;" onClick="JavaScript:Proceso('C','<?php echo $Pag;?>');" value="Cerrar"></td>
    </tr>
  </table>
</form>
</body>
</html>
-->