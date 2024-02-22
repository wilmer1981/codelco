<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$Fecha_Sistema= date("Y-m-d");
$Fecha_Creacion= date("Y-m-d G:i:s");
$Rut=$CookieRut;
$NomPag=RetornoPagina($CodSistema,$CodPantalla);
//echo $NomPag;
switch($Proceso)
{
	case "G"://Autoriza
		if($Valores2 !="")
		{
			$datos2 = explode("//",$Valores2);//CORTO EL STRING QUE CONTIENE LOS RUT CON TIPO_PROCESO
			reset($datos2); 
			while (list($clave2,$valor2)=each($datos2))
			{				
				$arreglo2=explode("~",$valor2);
				$Actualizar=" UPDATE  sget_personal set ";
				if($arreglo2[1]=='')
					$Actualizar.="fecha_termino_curso=NULL ";	
				else
					$Actualizar.="fecha_termino_curso='".$arreglo2[1]."' ";	
				$Actualizar.=" where rut='".$arreglo2[0]."'  ";
				mysql_query($Actualizar);
				/*echo $Actualizar."<br>";*/
			}
		}
			header("location:sget_busca_externo_curso_basico.php?&Buscar=S&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&TxtPaterno=".$TxtPaterno."&TxtMaterno=".$TxtMaterno."&TxtNombre=".$TxtNombre);
	break;
	
	
}



?>