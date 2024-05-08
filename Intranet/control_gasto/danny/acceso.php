<? include("conectar.php") ?>
<?
	$encontro=0;
	$consulta="select * from usuarios where rut='$cuenta'";
	$result=mysql_query($consulta);
	while ($row=mysql_fetch_array($result))
	{
		$encontro=1;
		if ($row[PASSWORD]==$pass)
		{
			$dia=date("d"); //ENTREGA NUMERO DE DIA SIN CERO (1-31)
  			$mes=date("m"); //ENTREGA NUMERO DE MES SIN CERO (1-12)
  			$ano=date("Y"); //ENTREGA NUMERO DE AÑO DE 4 DIGITOS (2002)
  			$fecha_ingreso="dia/mes/ano";
			Setcookie ("CookieUsuario",$row[RUT]);
			Setcookie ("CookieTipoUsuario",$row[COD_TIPO_USUARIO]);
			Setcookie ("CookieFechaIngreso",$fecha_ingreso);
			Header("Location:menu_usuarios.php");
			exit;
		}
		else
		{
			Header("Location:principal.php?valida=1");
			exit;
		}
	}
	if ($encontro==0)
	{
		Header("Location:principal.php?valida=2");
		exit;
	}
?>