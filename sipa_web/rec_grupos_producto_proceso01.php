<?php
	include("../principal/conectar_principal.php");	
	
		$Proceso = $_REQUEST["Proceso"];
		$Valores = $_REQUEST["Valores"];
		$TxtCodGrupo = $_REQUEST["TxtCodGrupo"];
		$TxtDescripcion = $_REQUEST["TxtDescripcion"];
		$OptAbast = $_REQUEST["OptAbast"];
		$Valor = $_REQUEST["Valor"];

	switch($Proceso)
	{
		case "N":
			$Insertar="INSERT INTO sipa_web.grupos_productos(cod_grupo,descripcion_grupo,abast_minero) values(";
			$Insertar.="'$TxtCodGrupo','$TxtDescripcion','$OptAbast')";
			mysqli_query($link, $Insertar);
			$Datos=explode('//',$Valores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~',$v);
				$Insertar="INSERT INTO sipa_web.grupos_prod_subprod(cod_grupo,cod_producto,cod_subproducto,valor1) values(";
				$Insertar.="'$TxtCodGrupo','$Datos2[0]."','$Datos2[1]."','')";
				mysqli_query($link, $Insertar);
			}	
			//header('location:rec_grupos_conjunto.php');
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='rec_grupos_producto.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "M":
			$Actualizar="UPDATE sipa_web.grupos_productos set descripcion_grupo='$TxtDescripcion',abast_minero='$OptAbast' ";
			$Actualizar.="where cod_grupo='$TxtCodGrupo'";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			$Eliminar="delete from sipa_web.grupos_prod_subprod where cod_grupo='$TxtCodGrupo'";
			mysqli_query($link, $Eliminar);
			//echo $Valores."<br>";
			$Datos=explode('//',$Valores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~',$v);
				$Insertar="INSERT INTO sipa_web.grupos_prod_subprod(cod_grupo,cod_producto,cod_subproducto,valor1) values(";
				$Insertar.="'$TxtCodGrupo','$Datos2[0]."','$Datos2[1]."','')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
			}	
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='rec_grupos_producto.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "E":
			$Datos=explode('//',$Valor);
			foreach($Datos as $c => $v)
			{
				$Eliminar="delete from sipa_web.grupos_productos where cod_grupo='".$v."'";
				mysqli_query($link, $Eliminar);
				$Eliminar="delete from sipa_web.grupos_prod_subprod where cod_grupo='".$v."'";
				mysqli_query($link, $Eliminar);
				
			}
			header('location:rec_grupos_producto.php');
			break;
	}
?>