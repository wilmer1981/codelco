<?
ob_start("ob_gzhandler");
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$Fecha_Sistema= date("Y-m-d");
$Fecha_Creacion= date("Y-m-d G:i:s");
$Rut=$CookieRut;
$NomPag=RetornoPagina($CodSistema,$CodPantalla);
//echo $NomPag;
switch($Opcion)
{
	case "E"://AGREGA CABECERA
		$Datos = explode("//",$Valor);
		foreach($Datos as $clave => $Codigo)
		{
			$Eliminar=" delete from sget_hoja_ruta ";
			$Eliminar.=" where num_hoja_ruta='".$Codigo."'  ";
			mysql_query($Eliminar);
			$Eliminar=" delete from sget_hoja_ruta_hitos ";
			$Eliminar.=" where num_hoja_ruta='".$Codigo."'  ";
			mysql_query($Eliminar);
			$Eliminar=" delete from sget_hoja_ruta_nomina ";
			$Eliminar.=" where num_hoja_ruta='".$Codigo."'  ";
			mysql_query($Eliminar);
			$Eliminar=" delete from sget_hoja_ruta_hitos_observaciones ";
			$Eliminar.=" where num_hoja_ruta='".$Codigo."'  ";
			mysql_query($Eliminar);
			//echo $Actualizar;
		}	
		header("location:$NomPag?Cons=S&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja);
	break;
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
		$Consulta=" SELECT * from sget_hitos where  cod_pantalla='".$CodPantalla."' ";
		$Consulta.=" and cod_sistema='".$CodSistema."' and cod_hito='".$H."' ";
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);
		/*echo $Consulta;
		echo "Inicial_____".$Fila[inicial]."<br>";*/
		if($Fila[inicial] =='S')
		{
			$Consulta=" SELECT count(*) as cantidad from sget_hitos t1 left join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$CodPantalla."' ";
			$Consulta.="  where t2.num_hoja_ruta='".$NumHoja."' and  inicial='S'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
				$Cant=$Fila["cantidad"];
			$Consulta=" SELECT count(*) as cantau from sget_hitos t1 inner join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$CodPantalla."' ";
			$Consulta.="  where t2.num_hoja_ruta='".$NumHoja."' and t2.autorizado='S' and  inicial='S' ";
			$Resp2=mysql_query($Consulta);
			$Fila2=mysql_fetch_array($Resp2);
				$CantAut=$Fila2[cantau];
			/*echo "cant___".$Cant."<br>";
			echo "cant2___".$CantAut."<br>";*/
			if($Cant > 0 )
			{
				if($CantAut > 0)
				{	
					if($Cant==$CantAut)
					{
						$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=5,cod_estado_pantalla=4 where num_hoja_ruta='".$NumHoja."'";
						mysql_query($Actualizar);
					}
				}	
			}
		}
		else
		{
			$Consulta=" SELECT count(*) as cantidad from sget_hitos t1 left join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$CodPantalla."' ";
			$Consulta.="  where t2.num_hoja_ruta='".$NumHoja."' and  final='S'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
				$Cant=$Fila["cantidad"];
			$Consulta=" SELECT count(*) as cantau from sget_hitos t1 inner join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$CodPantalla."' ";
			$Consulta.="  where t2.num_hoja_ruta='".$NumHoja."' and t2.autorizado='S' and  final='S' ";
			$Resp2=mysql_query($Consulta);
			$Fila2=mysql_fetch_array($Resp2);
				$CantAut=$Fila2[cantau];
			/*echo "cant___".$Cant."<br>";
			echo "cant2___".$CantAut."<br>";*/
			if($Cant > 0 )
			{
				if($CantAut > 0)
				{	
					if($Cant==$CantAut)
					{
						$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=7,cod_estado_pantalla=4 where num_hoja_ruta='".$NumHoja."'";
						mysql_query($Actualizar);
					}
				}	
			}
		}						
		//ActualizaGen($NumHoja,$CodPantalla);
		EnvioMailCodelco($NumHoja);
		EnvioMailExterno($NumHoja,$CookieRut);
		header("location:$NomPag?Cons=S&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja."&CmbEstado=".$CmbEstado);
	
	break;
	case "RECH":
		$Actualizar=" UPDATE  sget_hoja_ruta_hitos set ";
		$Actualizar.="autorizado='N',fecha_autorizacion='".$Fecha_Sistema."',rut_autorizador='".$Rut."' ";	
		$Actualizar.=" where num_hoja_ruta='".$NumHoja."' and cod_hito='".$H."' ";
		mysql_query($Actualizar);
		Registra_Estados($NumHoja,$Fecha_Creacion,$Rut,$CodPantalla,$H,'R','H');
		$Consulta=" SELECT * from sget_hitos where  cod_pantalla='".$CodPantalla."' ";
		$Consulta.=" and cod_sistema='".$CodSistema."' and cod_hito='".$H."' ";
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);
		/*echo $Consulta;
		echo "Inicial_____".$Fila[inicial]."<br>";*/
		if($Fila[inicial] =='S')
		{
			$Consulta=" SELECT count(*) as cantidad from sget_hitos t1 left join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$CodPantalla."' ";
			$Consulta.="  where t2.num_hoja_ruta='".$NumHoja."' and  inicial='S'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
				$Cant=$Fila["cantidad"];
			$Consulta=" SELECT count(*) as cantau from sget_hitos t1 inner join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$CodPantalla."' ";
			$Consulta.="  where t2.num_hoja_ruta='".$NumHoja."' and t2.autorizado='S' and  inicial='S' ";
			$Resp2=mysql_query($Consulta);
			$Fila2=mysql_fetch_array($Resp2);
				$CantAut=$Fila2[cantau];
			/*echo "cant___".$Cant."<br>";
			echo "cant2___".$CantAut."<br>";*/
			if($Cant > 0 )
			{
				if($CantAut > 0)
				{	
					if($Cant==$CantAut)
					{
						/*$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=5,cod_estado_pantalla=4 where num_hoja_ruta='".$NumHoja."'";
						mysql_query($Actualizar);*/
					}
					else
					{
						$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=4,cod_estado_pantalla=4 where num_hoja_ruta='".$NumHoja."'";
						mysql_query($Actualizar);
					}
				}
				else
				{
					$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=4,cod_estado_pantalla=4 where num_hoja_ruta='".$NumHoja."'";
					mysql_query($Actualizar);
				}	
			}
		}
		else// HITOS FINALES
		{
			$Consulta=" SELECT count(*) as cantidad from sget_hitos t1 left join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$CodPantalla."' ";
			$Consulta.="  where t2.num_hoja_ruta='".$NumHoja."' and  final='S'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
				$Cant=$Fila["cantidad"];
			$Consulta=" SELECT count(*) as cantau from sget_hitos t1 inner join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$CodPantalla."' ";
			$Consulta.="  where t2.num_hoja_ruta='".$NumHoja."' and t2.autorizado='S' and  final='S' ";
			$Resp2=mysql_query($Consulta);
			$Fila2=mysql_fetch_array($Resp2);
				$CantAut=$Fila2[cantau];
			/*echo "cant___".$Cant."<br>";
			echo "cant2___".$CantAut."<br>";*/
			if($Cant > 0 )
			{
				if($CantAut > 0)
				{	
					if($Cant==$CantAut)
					{
						/*$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=6,cod_estado_pantalla=4 where num_hoja_ruta='".$NumHoja."'";
}						mysql_query($Actualizar);*/
					}
					else
					{
						$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=6,cod_estado_pantalla=4 where num_hoja_ruta='".$NumHoja."'";
						mysql_query($Actualizar);
					}
				}
				else
				{
					$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=6,cod_estado_pantalla=4 where num_hoja_ruta='".$NumHoja."'";
					mysql_query($Actualizar);
				}	
			}
		}		
		//ActualizaGen($NumHoja,$CodPantalla);
		header("location:$NomPag?Cons=S&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja."&CmbEstado=".$CmbEstado);
	break;
	
	case "CandadoF":
		switch($Tipo)
		{
			case 'C':
				$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado='14' where num_hoja_ruta='".$NumHoja."'";
				mysql_query($Actualizar);
				Registra_Actividad($NumHoja,$Rut,'14','E');
			break;
		}	
		header("location:$NomPag?Cons=S&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja."&CmbEstado=".$CmbEstado);

	break;
	
	
}
function EnvioMailCodelco($NumHoja)
{
	$Consulta="SELECT nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30017' and cod_subclase='1'";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$EMail=$Fila["nombre_subclase"];
		$Consulta = "SELECT cod_contrato,rut_empresa from sget_hoja_ruta where num_hoja_ruta = '".$NumHoja."'";
		//echo $Consulta;
		$Resp2=mysql_query($Consulta);
		$Fila2=mysql_fetch_array($Resp2);
		$Ctto=$Fila2["cod_contrato"];
		$Emp=$Fila2[rut_empresa];
		$Asunto="SOLICITUD DE INGRESO PERSONAL PARA SU AUTORIZACION";
		$cuerpo = "\n";

		$cuerpo.= "Estimado en Sistema Gesti�n de Terceros M�dulo Gesti�n de Riesgos esta para su aprobaci�n la siguiente Hoja de Ruta";

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
	}	
}
function EnvioMailExterno($NumHoja,$Rut)
{
	$Consulta = "SELECT cod_contrato,rut_empresa from sget_hoja_ruta where num_hoja_ruta = '".$NumHoja."'";
	//echo $Consulta;
	$Resp2=mysql_query($Consulta);
	$Fila2=mysql_fetch_array($Resp2);
	$Ctto=$Fila2["cod_contrato"];
	$Empresa=$Fila2[rut_empresa];
	$Consulta="Select t2.email from sget_contratos t1 left join sget_administrador_contratistas t2 on t1.rut_adm_contratista=t2.rut_adm_contratista where t1.cod_contrato='".$Ctto."' and t1.rut_empresa='".$Empresa."'";
	//echo $Consulta;
	$Resp1= mysql_query($Consulta);
	if($Fila1 = mysql_fetch_array($Resp1))
		$EMail=strtolower($Fila1[email]);
	if ($EMail)
		$direcciones["direccion1"]=$EMail;
	$Consulta="Select * from sget_ruta_archivo where rut='".$Rut."'";
	//echo $Consulta;
	$Resp0= mysql_query($Consulta);
	if($Fila0 = mysql_fetch_array($Resp0))
	{
		$Cuenta=$Fila0[cuenta];
		$txtpassword=$Fila0[password];
	}
	require "includes/class.phpmailer.php";
	$mail = new phpmailer();
	$mail->PluginDir = "includes/";
	$mail->Mailer = "smtp";
	$mail->Host = "VEFVEX03.codelco.cl";
	$mail->SMTPAuth = true;
	$mail->Username = $Cuenta;
	$mail->Password = $txtpassword;
	//$mail->Password = 'joa022022';
	$mail->From = $Cuenta;
	$mail->FromName = "Gesti�n de Terceros Codelco Ventanas";
	$mail->Subject = "HOJA DE RUTA DIGITAL DE INGRESO PERSONAL CONTRATISTA";
	$mail->Body = "Estimado se notifica que la Hoja de Ruta N� ".$NumHoja." del Contrato N� ".$Ctto." a sido enviada a Gestion de Riesgo para su Autorizaci�n";
	$mail->AltBody ="Departamento de Gesti�n de Terceros";
	$mail->Timeout=120;
	reset($direcciones);
	while (list($clave, $valor)=each($direcciones))
	{
		$mail->AddAddress($valor);
		$exito = $mail->Send();
		$intentos=1; 
		while((!$exito)&&($intentos<10)&&($mail->ErrorInfo!="SMTP Error: Data not accepted"))
		{
		   sleep(5);
			   //echo $mail->ErrorInfo;
			   $exito = $mail->Send();
			   $intentos=$intentos+1;				
		}
		$mail->ClearAddresses();
	}
}
ob_end_flush();
?>