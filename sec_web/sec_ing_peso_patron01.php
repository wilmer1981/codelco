<?
	include("../principal/conectar_sec_web.php");
	$CookieRut = $_COOKIE["CookieRut"];
	$proceso = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$txtpeso = isset($_REQUEST["txtpeso"])?$_REQUEST["txtpeso"]:"";
	$txtpeso = str_replace(",",".",$txtpeso);

switch($proceso)
{
	case "G"://ELIMINA CUBAS DEL GRUPO SELECCIONADO EN POPUP DE MODIFICACION
		if($txtpeso>0)
		{
			$IpUser=$_SERVER['REMOTE_ADDR'];
			$Nombre_Bascula="";
		  	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase=3112 and  valor_subclase1='".$IpUser."' ";
			$Resp=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Resp))
			{
				$Nombre_Bascula=$Fila['nombre_subclase'];
				$Cod_Bascula=$Fila['cod_subclase'];
				$Insertar = "INSERT INTO sec_web.sec_registro_peso_patron(fecha_registro,ip_bascula,peso,usuario,id_bascula,descripcion)";
				$Insertar.= " VALUES ('".date('Y-m-d G:i:s')."','".$IpUser."','".$txtpeso."','".$CookieRut."','".$Cod_Bascula."','".$Nombre_Bascula."')";
				if(mysqli_query($link, $Insertar))
				{
					header("Location:sec_ing_peso_patron.php?msj=0");
				}
				else
				{
					header("Location:sec_ing_peso_patron.php?msj=3");	
				}
			
			}
			else
			{
				header("Location:sec_ing_peso_patron.php?msj=1");
			}
		}
		else
		{
			header("Location:sec_ing_peso_patron.php?msj=2");
			}
		
						
	break;
}


?>
