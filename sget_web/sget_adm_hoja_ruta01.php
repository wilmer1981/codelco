<?
ob_start("ob_gzhandler");
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$Fecha_Sistema= date("Y-m-d");
$Fecha_Creacion= date("Y-m-d G:i:s");
$Rut=$CookieRut;
//$NomPag=RetornoPagina($CodSistema,$CodPantalla);
//echo $NomPag;
switch($Proceso)
{
	case "A"://Autoriza
		$Consulta="SELECT * from sget_hoja_ruta_hitos where num_hoja_ruta='".$NumHoja."' and cod_hito='".$H."' ";
		$RespHD = mysql_query($Consulta);
		if($FilaHD=mysql_fetch_array($RespHD))
		{
			if($FilaHD[autorizado]!='S')
			{
				$Actualizar=" UPDATE  sget_hoja_ruta_hitos set ";
				$Actualizar.="autorizado='S',fecha_autorizacion='".$Fecha_Sistema."',rut_autorizador='".$Rut."' ";	
				$Actualizar.=" where num_hoja_ruta='".$NumHoja."' and cod_hito='".$H."' ";
				mysql_query($Actualizar);
			}
		}
		else
		{
			$Inserta="INSERT INTO sget_hoja_ruta_hitos (num_hoja_ruta,cod_hito,autorizado,fecha_autorizacion,rut_autorizador)";
			$Inserta.=" values('".$NumHoja."','".$H."','S','".$Fecha_Sistema."','".$Rut."')";
			mysql_query($Inserta);
		}
		Registra_Estados($NumHoja,$Fecha_Creacion,$Rut,$CodPantalla,$H,'A','H');		
		ActualizaGen($NumHoja,$CodPantalla);
 		
		//ENVIO DE CORREO
		   	$VarCodelco=AdmCttoCodelcoHR($NumHoja);
		   	$array=explode('~',$VarCodelco);
		   	$EMail=$array[5];
			$Consulta="SELECT cod_contrato,rut_empresa from sget_hoja_ruta where num_hoja_ruta='".$NumHoja."'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
			$ArrayCtto=explode('~',DescripCtto($Fila["cod_contrato"]));
			$Ctto=$ArrayCtto[0]." ".$ArrayCtto[1];
			$ArrayEmp=explode('~',DescripEmpresa($Fila[rut_empresa]));
			$Emp=$ArrayEmp[0]." ".$ArrayEmp[1];
			//echo $EMail;
			//$Nombre=$FilaU["nombres"].' '.$FilaU[ape_paterno].' '.$FilaU[ape_materno];
			$Asunto="SOLICITUD DE INGRESO PERSONAL PARA SU AUTORIZACION";
			$cuerpo = "\n";

			$cuerpo.= "Estimado en Sistema Gesti�n de Terceros http://tevmraphpp01/proyecto/ esta para su aprobaci�n la siguiente Hoja de Ruta";

			$cuerpo.= "\n";
			$cuerpo.= "\n";

			$cuerpo.= "N� Hoja Ruta             : " .$NumHoja. "\n"; 

			$cuerpo.= "N� Contrato              : " .$Ctto. "\n"; 

			$cuerpo.= "Empresa                  : " .$Emp. "\n"; 
			
			$cuerpo.= "\n";

			$cuerpo.= "\n";
			
			$cuerpo.= "Atte\n";
			$cuerpo.= "\n";
			$cuerpo.= "                Departamento de Gesti�n de Terceros\n"; 
			$MsjC=true;

			$UN_SALTO="\r\n";

			$DOS_SALTOS="\r\n\r\n";

			$destinatario=str_replace(";",",",$EMail);

			$TxtDe=str_replace(";",",","DEPARTAMENTO GESTION DE TERCEROS");

			 $mensaje =$cuerpo;

			$remite=str_replace(";",",",$TxtDe);

			$separador = "_separador_de_trozos_".md5 (uniqid (rand())); 

			$cabecera = "Date: ".date("l j F Y, G:i").$UN_SALTO; 

			$cabecera .= "MIME-Version: 1.0".$UN_SALTO; 

			$cabecera .= "From: ".$remitente."<".$remite.">".$UN_SALTO;

			$cabecera .= "Return-path: ". $remite.$UN_SALTO;

			$cabecera .= "Reply-To: ".$remite.$UN_SALTO;

			$cabecera .="X-Mailer: PHP/". phpversion().$UN_SALTO;

			$cabecera .= "Content-Type: multipart/mixed;".$UN_SALTO; 

			$cabecera .= " boundary=$separador".$DOS_SALTOS; 

			// Parte primera -Mensaje en formato HTML 

			# Separador inicial

			$texto ="--$separador".$UN_SALTO; 

			# Encabezado parcial

			$texto .="Content-Type: text/html; charset=\"ISO-8859-1\"".$UN_SALTO; 

			$texto .="Content-Transfer-Encoding: 7bit".$DOS_SALTOS; 

			# Contenido de esta parte del mensaje

			$texto .= $mensaje;

			$FechaHora= date("Y-m-d G:i:s");

			mail($destinatario, $Asunto, $mensaje,$cabecera);

		header("location:sget_adm_hoja_ruta.php?Cons=S&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja."&CmbEstado=".$CmbEstado);
	break;
	case "RECH":
		$Actualizar=" UPDATE  sget_hoja_ruta_hitos set ";
		$Actualizar.="autorizado='N',fecha_autorizacion='".$Fecha_Sistema."',rut_autorizador='".$Rut."' ";	
		$Actualizar.=" where num_hoja_ruta='".$NumHoja."' and cod_hito='".$H."' ";
		mysql_query($Actualizar);
		Registra_Estados($NumHoja,$Fecha_Creacion,$Rut,$CodPantalla,$H,'R','H');
		ActualizaGen($NumHoja,$CodPantalla);
		header("location:sget_adm_hoja_ruta.php?Cons=S&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja."&CmbEstado=".$CmbEstado);
	break;
	
}
ob_end_flush();


?>