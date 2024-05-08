<?php
	include("../principal/conectar_principal.php");


	$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$CmbSistema2 = isset($_REQUEST["CmbSistema2"])?$_REQUEST["CmbSistema2"]:"";
	$Valores     = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$TxtCodigo   = isset($_REQUEST["TxtCodigo"])?$_REQUEST["TxtCodigo"]:"";
	$TxtDescripcion     = isset($_REQUEST["TxtDescripcion"])?$_REQUEST["TxtDescripcion"]:"";
	$TxtValor1     = isset($_REQUEST["TxtValor1"])?$_REQUEST["TxtValor1"]:"";
	$TxtValor2     = isset($_REQUEST["TxtValor2"])?$_REQUEST["TxtValor2"]:"";

	$CmbSistema = isset($_REQUEST["CmbSistema"])?$_REQUEST["CmbSistema"]:"";
	$TxtCodSubClase = isset($_REQUEST["TxtCodSubClase"])?$_REQUEST["TxtCodSubClase"]:"";
	$TxtNombre  = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$CmbSistema = isset($_REQUEST["CmbSistema"])?$_REQUEST["CmbSistema"]:"";
	$TxtValor3  = isset($_REQUEST["TxtValor3"])?$_REQUEST["TxtValor3"]:"";
	$TxtValor4  = isset($_REQUEST["TxtValor4"])?$_REQUEST["TxtValor4"]:"";
	$TxtValor5  = isset($_REQUEST["TxtValor5"])?$_REQUEST["TxtValor5"]:"";
	$TxtValor6  = isset($_REQUEST["TxtValor6"])?$_REQUEST["TxtValor6"]:"";
	$TxtValor7  = isset($_REQUEST["TxtValor7"])?$_REQUEST["TxtValor7"]:"";

	$EncontroRelacion=false;
	switch ($Proceso)
	{
		case "NC"://NUEVA CLASE
			$Insertar="INSERT into proyecto_modernizacion.clase () values (";
			$Insertar.="'$TxtCodigo','$TxtDescripcion','$TxtValor1','$TxtValor2')";
			mysqli_query($link, $Insertar);
			break;
		case "MC"://NUEVA SUBCLASE
			$Modificar="UPDATE proyecto_modernizacion.clase SET nombre_clase='$TxtDescripcion',valor1='$TxtValor1',valor2='$TxtValor2' ";
			$Modificar.="where cod_clase='$TxtCodigo'";
			mysqli_query($link, $Modificar);
			break;
		case "NS"://NUEVA SUBCLASE
		
			$Insertar="INSERT INTO proyecto_modernizacion.sub_clase (cod_clase,cod_subclase,nombre_subclase,valor_subclase1,valor_subclase2,valor_subclase3,valor_subclase4,valor_subclase5,valor_subclase6,valor_subclase7,valor_subclase) values (";
			$Insertar.="'$TxtCodigo','$TxtCodSubClase','$TxtNombre','$TxtValor1','$TxtValor2','$TxtValor3','$TxtValor4','$TxtValor5','$TxtValor6','$TxtValor7',NULL)";
			mysqli_query($link, $Insertar);
		break;
		case "MS"://MODIFICAR SUBCLASE
			$Modificar="UPDATE proyecto_modernizacion.sub_clase set nombre_subclase='$TxtNombre',valor_subclase1='$TxtValor1',valor_subclase2='$TxtValor2',";
			$Modificar.="valor_subclase3='$TxtValor3',valor_subclase4='$TxtValor4',valor_subclase5='$TxtValor5',valor_subclase6='$TxtValor6',valor_subclase7='$TxtValor7' where cod_clase='$TxtCodigo' and cod_subclase='$TxtCodSubClase'";
			mysqli_query($link, $Modificar);
			break;
		case "ES"://ELIMINAR SUBCLASE
			$Eliminar ="DELETE from proyecto_modernizacion.sub_clase where cod_clase='$TxtCodigo' and cod_subclase='$TxtCodSubClase'";
			mysqli_query($link, $Eliminar);
			break;
		case "E"://ELIMINAR CLASE
			$Datos=explode('//',$Valores);
			foreach ($Datos as $Clave => $Valor){
				$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase ='".$Valor."' ";
				$Respuesta=mysqli_query($link, $Consulta);
				if(!$Fila=mysqli_fetch_array($Respuesta))
				{
					$Eliminar ="DELETE from proyecto_modernizacion.clase where cod_clase='".$Valor."' ";
					mysqli_query($link, $Eliminar);
				}
				else
				{
					$EncontroRelacion=true;
				}

			}
			break;	
	}
	if ($Proceso=="E")
	{
		header("location:ingreso_clase_subclase.php?EncontroRelacion=".$EncontroRelacion."&CmbSistema=".$CmbSistema);
		//http://localhost/proyecto/principal/ingreso_clase_subclase.php?EncontroRelacion=&CmbSistema=
	}
	else
	{
		//if ($Proceso=="NC"||$Proceso=="MC")
		if ($Proceso=="NC")
		{
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmIngClaseSubclase.action='ingreso_clase_subclase.php';";
			echo "window.opener.document.FrmIngClaseSubclase.submit();";
			echo "window.close();";
			echo "</ script>";
		}
		if ($Proceso=="MC")
		{/*
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmIngClaseSubclase.action='ingreso_clase_subclase.php';";
			echo "window.opener.document.FrmIngClaseSubclase.submit();";
			echo "window.close();";
			echo "</ script>";*/
				// ingreso_clase_subclase_proceso.php?Proceso=MC&Valores=34001&CmbSistema2=34
			header("location:ingreso_clase_subclase_proceso.php?Proceso=MC&Valores=".$Valores."&CmbSistema2=".$CmbSistema2);
		}
		else
		{
			//header("location:ingreso_clase_subclase_proceso2.php?Proceso=NS&Valores=".$Valores);
			header("location:ingreso_clase_subclase_proceso2.php?Proceso=NS&Valores=".$TxtCodigo);
		}	
	}	
?>