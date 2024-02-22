<?php
	include("../principal/conectar_principal.php");	


		$Proceso = $_REQUEST["Proceso"];
	
	
		$TxtConjunto = $_REQUEST["TxtConjunto"];
		$TxtCodGrupo = $_REQUEST["TxtCodGrupo"];
		$TxtDescripcion = $_REQUEST["TxtDescripcion"];
		$CheckEst = $_REQUEST["CheckEst"];
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];

		$Valor = $_REQUEST["Valor"];


	switch($Proceso)
	{
		case "N":
			$Insertar="INSERT INTO sipa_web.grupos_conjunto(conjunto,cod_grupo,descripcion,estado,cod_producto,cod_subproducto) values(";
			$Insertar.="'$TxtConjunto','$TxtCodGrupo','$TxtDescripcion','$CheckEst','1','$CmbSubProducto')";
			mysqli_query($link, $Insertar);
			$Datos=explode('//',$Valor);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~',$v);
				$Prv=$Datos2[0];
				$Mina=$Datos2[1];
				$Insertar="INSERT INTO sipa_web.grupos_prod_prv(cod_grupo,cod_subproducto,rut_prv,cod_mina) values(";
				$Insertar.="'$TxtCodGrupo','$CmbSubProducto','$Prv','$Mina')";
				mysqli_query($link, $Insertar);
				$Insertar="INSERT INTO sipa_web.prodprv_conjuntados(cod_grupo,cod_producto,cod_subproducto,rut_prv,cod_mina) values(";
				$Insertar.="'$TxtCodGrupo','1','$CmbSubProducto','$Prv','$Mina')";
				mysqli_query($link, $Insertar);
			}	
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='rec_grupos_conjunto.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "M":
			$Actualizar="UPDATE sipa_web.grupos_conjunto set conjunto='$TxtConjunto',descripcion='$TxtDescripcion',estado='$CheckEst' ";
			$Actualizar.="where cod_grupo='$TxtCodGrupo'";
			mysqli_query($link, $Actualizar);
			$Eliminar="delete from sipa_web.grupos_prod_prv where cod_grupo='$TxtCodGrupo'";
			mysqli_query($link, $Eliminar);
			$Eliminar="delete from sipa_web.prodprv_conjuntados where cod_grupo='$TxtCodGrupo' and cod_producto='1' and cod_subproducto='$CmbSubProducto'";
			mysqli_query($link, $Eliminar);
			$Datos=explode('//',$Valor);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~',$v);
				$Prv=$Datos2[0];
				$Mina=$Datos2[1];
				$Insertar="INSERT INTO sipa_web.grupos_prod_prv(cod_grupo,cod_subproducto,rut_prv,cod_mina) values(";
				$Insertar.="'$TxtCodGrupo','$CmbSubProducto','$Prv','$Mina')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
				$Insertar="INSERT INTO sipa_web.prodprv_conjuntados(cod_grupo,cod_producto,cod_subproducto,rut_prv,cod_mina) values(";
				$Insertar.="'$TxtCodGrupo','1','$CmbSubProducto','$Prv','$Mina')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
			}	
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='rec_grupos_conjunto.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "E":
			$Datos=explode('//',$Valor);
			foreach($Datos as $c => $v)
			{
				$Eliminar="delete from sipa_web.grupos_conjunto where cod_grupo='".$v."'";
				mysqli_query($link, $Eliminar);
				$Consulta="SELECT rut_prv,cod_subproducto from sipa_web.grupos_prod_prv where cod_grupo='".$v."'";
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Resp))
				{
					$Eliminar="delete from sipa_web.prodprv_conjuntados where cod_grupo='".$v."' and cod_producto='1' and cod_subproducto='".$Fila["cod_subproducto"]."'";
					mysqli_query($link, $Eliminar);
				}	
				$Eliminar="delete from sipa_web.grupos_prod_prv where cod_grupo='".$v."'";
				mysqli_query($link, $Eliminar);
			}
			header('location:rec_grupos_conjunto.php');
			break;
		case "AP"://ASOCIAR PLANTA
			header('location:rec_grupos_conjunto.php');
			break;
		case "QP"://QUITAR PLANTA
			header('location:rec_grupos_conjunto.php');
			break;
	}
?>