<?php
	include("conectar_principal.php");
	$Query = "SELECT codigo from parametros_auditoria";
	$Consuta=mysqli_query($link, $Query);
	$msj="E";
	while($row=mysqli_fetch_array($Consuta))
	{
		
		if(is_numeric($_POST["txt".$row["codigo"]]))
		{
			$Actualiza = "UPDATE parametros_auditoria";
			$Actualiza.= " SET valor='".$_POST["txt".$row["codigo"]]."' ";
			$Actualiza.=" where codigo='".$row["codigo"]."'";
			mysqli_query($link, $Actualiza);
		}
		else
			$msj="I";
	}
	header('location:mantenedor_parametro_auditoria.php?mensaje='.$msj);

  ?>