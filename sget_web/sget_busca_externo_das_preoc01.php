<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$Fecha_Sistema= date("Y-m-d");
$Fecha_Creacion= date("Y-m-d G:i:s");
$Rut=$CookieRut;
//$NomPag=RetornoPagina($CodSistema,$CodPantalla);
//echo $NomPag;
switch($Proceso)
{
	case "G"://Autoriza
		if($DatosFechasPersonal !="")
		{
			$datos2 = explode("//",$DatosFechasPersonal);//CORTO EL STRING QUE CONTIENE LOS RUT CON TIPO_PROCESO
			reset($datos2); 
			while (list($clave2,$valor2)=each($datos2))
			{				
				$arreglo2=explode("~",$valor2);
				$Actualizar=" UPDATE  sget_personal set ";
				if($arreglo2[1]=='')
					$Actualizar.="fecha_das=0000-00-00 ";	
				else
					$Actualizar.="fecha_das='".$arreglo2[1]."' ";	
				if($arreglo2[2]=='')
					$Actualizar.=",fecha_exa_ocup=0000-00-00 ";	
				else
					$Actualizar.=",fecha_exa_ocup='".$arreglo2[2]."' ";	
				if($arreglo2[3]=='')
					$Actualizar.=",fecha_vig_exa_ocup=0000-00-00 ";	
				else
					$Actualizar.=",fecha_vig_exa_ocup='".$arreglo2[3]."' ";	
				$Actualizar.=" where rut='".$arreglo2[0]."'  ";
				mysql_query($Actualizar);
				//echo $Actualizar."<br>";
			}
		}
			header("location:sget_busca_externo_das_preoc.php?&Buscar=S&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&TxtPaterno=".$TxtPaterno."&TxtMaterno=".$TxtMaterno."&TxtNombre=".$TxtNombre);
	break;
	
	
}



?>