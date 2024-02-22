<?php
	include("conectar_principal.php");
	$CookieRut=$_COOKIE["CookieRut"];

	$CodSist = $_POST["CodSist"];
	$CodPant = $_POST["CodPant"];
	$Pagina  = $_POST["Pagina"];

	$Favoritos=array();	
	$Consulta = "SELECT * FROM proyecto_modernizacion.funcionarios WHERE rut='".$CookieRut."'";
	$Resp=mysqli_query($link, $Consulta);
	if ($Fila=mysqli_fetch_array($Resp))
	{	
		$NewFav = $CodSist."-".$CodPant;

		if ($Fila["favoritos"]=="")
		{
			$Favoritos[0][0]=$CodSist;
			$Favoritos[0][1]=$CodPant;
		}
		else
		{
			$Datos=explode(";",$Fila["favoritos"]);			
			$Favoritos[0][0]=$CodSist;
			$Favoritos[0][1]=$CodPant;
			$i=1;
			foreach($Datos as $k => $v)
			{
				$Datos2=explode("-",$v);	
				if ($Datos2[0]!="" && $Datos2[1]!="")			
				{
					$Favoritos[$i][0]=$Datos2[0];
					$Favoritos[$i][1]=$Datos2[1];
					$i++;
				}
			}
						
		}
		$StrFavoritos="";
		$LargoArr=count($Favoritos);
		if ($LargoArr>5)
		{
			for ($i=0;$i<=$LargoArr;$i++)
			{
				if ($i==5)
					break;
				else
					$StrFavoritos.=$Favoritos[$i][0]."-".$Favoritos[$i][1].";";
			}
		}
		else
		{
			
			for ($i=0;$i<=$LargoArr;$i++)
			{
				$StrFavoritos.=$Favoritos[$i][0]."-".$Favoritos[$i][1].";";
			}
		}
		$Actualizar = "UPDATE proyecto_modernizacion.funcionarios set ";
		$Actualizar.= " favoritos='".$StrFavoritos."' ";
		$Actualizar.= " where rut='".$CookieRut."' ";
		//mysqli_query($link, $Actualizar);
	}
	session_start();
    $_SESSION["CodSistemaSel"] = $CodSist;
     //print_r($_SESSION);
	header("location:".$Pagina);
?>
