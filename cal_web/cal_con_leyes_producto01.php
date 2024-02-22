<?php
$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;
$Fecha_Hora = date("Y-m-d");
include("../principal/conectar_principal.php");
//header("location:cal_con_multiple_producto.php?Leyes=".$ValoresLeyes."&CodLeyes=".$ValoresCodLeyes."&TxtProducto=".$Producto01."&TxtSubProducto=".$SubProducto01."&CmbDias=".$Dia."&CmbMes=".$Mes."&CmbAno=".$Ano."&CmbDiasT=".$DiaT."&CmbMesT=".$MesT."&CmbAnoT=".$AnoT."&CmbPeriodo=".$Periodo."&CmbProductos=".$Producto."&CmbSubProducto=".$SubProducto);

$ValoresLeyes    = $_REQUEST["ValoresLeyes"];
$ValoresCodLeyes = $_REQUEST["ValoresCodLeyes"];
$E = $_REQUEST["E"];
$ProSubPro = $_REQUEST["ProSubPro"];
$Salir     = $_REQUEST["Salir"];
$cod_consulta = $_REQUEST["cod_consulta"];
$Enabal       = $_REQUEST["Enabal"];
$Codigos      = $_REQUEST["Codigos"];
$TxtConsulta  = $_REQUEST["TxtConsulta"];



switch ($Salir) 
{
	case "1":
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmConsulta.action='cal_con_multiple_producto.php?Leyes=".$ValoresLeyes."&CodLeyes=".$ValoresCodLeyes."&TxtProducto=".$Producto01."&TxtSubProducto=".$SubProducto01."&CmbDias=".$Dia."&CmbMes=".$Mes."&CmbAno=".$Ano."&CmbDiasT=".$DiaT."&CmbMesT=".$MesT."&CmbAnoT=".$AnoT."&CmbPeriodo=".$Periodo."&CmbProductos=".$Producto."&Enabal=".$E."&CmbSubProducto=".$SubProducto."';";
		echo "window.opener.document.FrmConsulta.submit();";
		echo "window.close();</script>";
	break;
	case "2":
	//	header("location:cal_con_multiple_producto.php?Leyes=".$ValoresLeyes."&CodLeyes=".$ValoresCodLeyes."&TxtProducto=".$Producto01."&TxtSubProducto=".$SubProducto01."&CmbDias=".$Dia."&CmbMes=".$Mes."&CmbAno=".$Ano."&CmbDiasT=".$DiaT."&CmbMesT=".$MesT."&CmbAnoT=".$AnoT."&CmbPeriodo=".$Periodo."&CmbProductos=".$Producto."&CmbSubProducto=".$SubProducto);
		header("location:cal_con_multiple_producto.php");
	break;
	case "3"://guarda la consulta 
		$Consulta = "select max(cod_consulta) as numero from cal_web.consulta ";
		$Respuesta2=mysqli_query($link, $Consulta);
		$Fila2=mysqli_fetch_array($Respuesta2);
		$Numero=$Fila2["numero"] + 1 ;
		for ($j = 0;$j <= strlen($ProSubPro); $j++)
		{
			if (substr($ProSubPro,$j,2) == "//")
			{
					$ProSPro = substr($ProSubPro,0,$j);
					for ($x=0;$x<=strlen($ProSPro);$x++)
					{
						if (substr($ProSPro,$x,2) == "~~")
						{
							$Producto = substr($ProSubPro,0,$x);			
							$SubProducto = substr($ProSPro,$x+2,strlen($ProSPro));
							//echo $Producto."<br>";
							//echo $SubProducto."<br>";
							$Insertar="insert into cal_web.consulta (cod_consulta,rut_funcionario,nombre_consulta,fecha,cod_producto,cod_subproducto)";						
							$Insertar.=" values ('".$Numero."','".$Rut."','".$TxtConsulta."','".$Fecha_Hora."','".$Producto."','".$SubProducto."') ";
							//echo $Insertar."<br>";
							mysqli_query($link, $Insertar);
						}
					}
			$ProSubPro = substr($ProSubPro,$j + 2);
			$j = 0;
			}
		}				
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmConsulta.action='cal_con_multiple_producto.php?Enabal=".$Enabal."&Opcion=K';";
		echo "window.opener.document.FrmConsulta.submit();";
		echo "window.close();</script>";
		break;
		case "4"://salir el cual recarga el arreglo  
			$Consulta="SELECT cod_producto,cod_subproducto from cal_web.consulta  ";
			$Consulta.=" where cod_consulta = '".$cod_consulta."'  "; 	
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				$Prod    = $Prod.$Fila["cod_producto"].'-';
				$SubProd = $SubProd.$Fila["cod_subproducto"].'-';
				$P=$Fila["cod_producto"];
				$S=$Fila["cod_subproducto"];
			}	
			$TxtProducto=substr($Prod,0,strlen($Prod)-1);
			$TxtSubProducto=substr($SubProd,0,strlen($SubProd)-1);
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmConsulta.action='cal_con_multiple_producto.php?Productito=".$TxtProducto."&SubProductito=".$TxtSubProducto."&CmbProductos=".$P."&Enabal=".$Enabal."&CmbSubProducto=".$S."&Opcion=S';";
			echo "window.opener.document.FrmConsulta.submit();";
			echo "window.close();</script>";
		break;
		case "5":
				for ($i=0;$i<=strlen($Codigos);$i++)
				{
					if (substr($Codigos,$i,2)=="//")
					{
						$Cod=substr($Codigos,0,$i);
						$Eliminar="DELETE from cal_web.consulta where cod_consulta = '".$Cod."' "; 	
						mysqli_query($link, $Eliminar);
						$Codigos = substr($Codigos,$i + 2);
						$i = 0;
					}
				}
		header("location:../cal_web/cal_ver_consulta.php?Enabal=".$Enabal);
		break;
}
?>
