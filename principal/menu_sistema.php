<?php include("conectar_principal.php")?>
<html>
<head>
<title>SISTEMAS LOCALES</title>
</head>
<body>
<?php
	$consulta = "select * from sistemas where cod_sistema = ".$CodSistema;
	$result = mysqli_query($link, $consulta);
	if ($row = mysqli_fetch_array($result))
	{
		echo "<strong>".$row["nombre"].":&nbsp;&nbsp;".$row["descripcion"]."</strong><br><br>";
		$consulta = "select min(nivel) as nivel from acceso_menu";
		$consulta.= " where cod_sistema = ".$CodSistema;
		$consulta.= " order by nivel asc";
		$result2 = mysqli_query($link, $consulta);
		while ($row2 = mysqli_fetch_array($result2))
		{
			$consulta = "select * from acceso_menu ";
			$consulta.= " where cod_sistema = ".$CodSistema;
			$consulta.= " and nivel = ".$row2[nivel];
			$consulta.= " order by cod_pantalla ";
			$result3 = mysqli_query($link, $consulta);
			while ($row3 = mysqli_fetch_array($result3))
			{
				echo "<a href='".$row3['link']."?CodSistema=".$CodSistema."&nivel=".$row2[nivel]."'>".ucwords(strtolower($row3["descripcion"]))."</a><br>";
			}
		}
	}
	else
	{
		echo "SISTEMA NO ENCONTRADO<br>";
	}
	
?>
</body>
</html>
<?php  include("cerrar_principal.php")?>