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
		ActualizaRNomina($NumHoja);
		$datos = explode("//",$Valores);//CORTO EL STRING QUE CONTIENE LOS RUT CON TIPO_PROCESO
		reset($datos); 
		foreach($datos as $clave => $valor)
		{				
			$arreglo=explode("~",$valor);
			$NHoja=$arreglo[0];
			$RutPer=$arreglo[1];
			$CHito=$arreglo[2];
			$Estado=$arreglo[3];
			$FechaDAS=$arreglo[4];
			//echo $CHito."<br>";
			$Consulta="SELECT * ";
			$Consulta.=" from sget_hoja_ruta_nomina_hitos_personas  ";
			$Consulta.=" where num_hoja_ruta ='".$NHoja."' ";
			$Consulta.=" and cod_hito='".$CHito."'  and rut_personal='".$RutPer."' ";
			$RespDet2=mysql_query($Consulta);
		//	echo $NHoja."  ".$RutPer."  ".$Estado."<br>";
			if($CHito=='2')
			{
				if($Estado=='A')
					$CodRegistro='9';
				if($Estado=='R')
					$CodRegistro='10';
			}
			if($CHito=='4')
			{
				if($Estado=='A')
					$CodRegistro='11';
				if($Estado=='R')
					$CodRegistro='12';
			}
			Registra_Actividad($NHoja,$Rut,$CodRegistro,'A');
			if($FilaDet2=mysql_fetch_array($RespDet2))
			{
				$Actualizar=" UPDATE  sget_hoja_ruta_nomina set ";
				$Actualizar.="estado='".$Estado."' ";	
				$Actualizar.=" where num_hoja_ruta='".$NHoja."'  and  rut_personal='".$RutPer."'";
				mysql_query($Actualizar);
				$Actualizar=" UPDATE  sget_hoja_ruta_nomina_hitos_personas set ";
				$Actualizar.="aprob_rechazo='".$Estado."',fecha='".$FechaDAS."',fecha_hora='".$Fecha_Creacion."' ";	
				$Actualizar.=" where num_hoja_ruta='".$NHoja."' and cod_hito='".$CHito."' and  rut_personal='".$RutPer."'";
				//echo $Actualizar."<br>";
				mysql_query($Actualizar);
	
			
				Registra_Autorizacion($NHoja,$Rut,$RutPer,$Estado,$CHito,$CodRegistro);
			}
			else
			{
				$Inserta="INSERT INTO sget_hoja_ruta_nomina_hitos_personas (num_hoja_ruta,cod_hito,fecha,rut_personal,aprob_rechazo,fecha_hora)";
				$Inserta.=" values('".$NHoja."','".$CHito."','".$FechaDAS."','".$RutPer."','".$Estado."','".$Fecha_Creacion."')";
				//echo $Inserta."<br>";
				mysql_query($Inserta);
				
				Registra_Autorizacion($NHoja,$Rut,$RutPer,$Estado,$CHito,$CodRegistro);
			}
		}
		
		if($Valores2 !="")
		{
			//echo $Valores2;
			$datos2 = explode("//",$Valores2);//CORTO EL STRING QUE CONTIENE LOS RUT CON TIPO_PROCESO
			reset($datos2); 
			while (list($clave2,$valor2)=each($datos2))
			{				
				$arreglo2=explode("~",$valor2);
				if($arreglo2[0]!='')
				{
					if($arreglo2[4]=='')
					{
						$Das='NULL';$Termino='NULL';
					}
					else
					{
						$Con="SELECT valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='30024'";
						$RAno=mysql_query($Con);
						$FAno=mysql_fetch_assoc($RAno);
						$DASMasAno=$FAno["valor_subclase1"];
						$Das=$arreglo2[4];	
						$DasAux=explode('-',$arreglo2[4]);	
						$DasAux[0]=$DasAux[0]+$DASMasAno;
						$Termino=$DasAux[0]."-".$DasAux[1]."-".$DasAux[2];
					}	
					if($arreglo2[5]=='')
						$Exa='0000-00-00';
					else
						$Exa=$arreglo2[5];

					$Actualizar=" UPDATE  sget_personal set ";
					$Actualizar.="fecha_das='".$Das."' ";	
					$Actualizar.=",fecha_vigencia_exa_preo='".$Exa."' ";	
					$Actualizar.=",fecha_termino_curso='".$Termino."' ";	
					$Actualizar.=" where rut='".$arreglo2[1]."'  ";
					//echo $Actualizar."<br>";
					mysql_query($Actualizar);
				}
			}
		}
		$ConsultaFalta="SELECT t1.fecha_das,t1.fecha_vigencia_exa_preo from sget_personal t1 inner join sget_hoja_ruta_nomina_hitos_personas t2 on t1.rut=t2.rut_personal where t2.num_hoja_ruta='".$NumHoja."' and t2.cod_hito='".$CHito."' ";
		$ConsultaFalta.=" and (t1.fecha_das is null or t1.fecha_das='0000-00-00' or t1.fecha_vigencia_exa_preo is null or t1.fecha_vigencia_exa_preo='0000-00-00')";
		$Resp=mysql_query($ConsultaFalta);$Principal='S';
		if($Fila=mysql_fetch_assoc($Resp))
				$Principal='N';
		if($Principal=='N')		
			header("location:sget_autoriza_nomina_integral_2.php?Cons=S&CodSistema=".$CodSistema."&CodPantalla=".$CodPantalla."&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&NumHoja=".$NumHoja."&H=".$CHito);
		else
		{	
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmPrincipal.action='$NomPag?Cons=S&CodSistema=".$CodSistema."&CodPantalla=".$CodPantalla."&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&NumHoja=".$NumHoja."&CmbAno=".$CmbAno."&CmbEstado=".$CmbEstado."';";
			echo "window.opener.document.FrmPrincipal.submit();";
			echo "window.close();</script>";
		}
	break;
	case "GT"://GRABA TARJETAS
		ActualizaRNomina($NumHoja);
		$datos = explode("//",$Valores);//CORTO EL STRING QUE CONTIENE LOS RUT CON TIPO_PROCESO
		reset($datos); 
		foreach($datos as $clave => $valor)
		{				
			$arreglo=explode("~",$valor);
			$NTarj=$arreglo[0];
			$NHoja=$arreglo[1];
			$RutPer=$arreglo[2];
			$CHito=$arreglo[3];
			/*$Consulta="SELECT * ";
			$Consulta.=" from sget_hoja_ruta_nomina_hitos_personas  ";
			$Consulta.=" where num_hoja_ruta ='".$NHoja."' ";
			$Consulta.=" and cod_hito='".$CHito."'  and rut_personal='".$RutPer."' ";
			$RespDet2=mysql_query($Consulta);
			if($FilaDet2=mysql_fetch_array($RespDet2))
			{
				$Actualizar=" UPDATE  sget_hoja_ruta_nomina_hitos_personas set ";
				$Actualizar.="aprob_rechazo='".$Estado."',fecha='".$TxtFecha."',num_tarjeta='".$NTarj."' ";	
				$Actualizar.=" where num_hoja_ruta='".$NHoja."' and cod_hito='".$CHito."' and  rut_personal='".$RutPer."'";
				mysql_query($Actualizar);
				echo $Actualizar;
			}
			else
			{*/
				$Actualizar=" UPDATE  sget_hoja_ruta_nomina set ";
				$Actualizar.="estado='A' ";	
				$Actualizar.=" where num_hoja_ruta='".$NHoja."'  and  rut_personal='".$RutPer."'";
				mysql_query($Actualizar);
				$Eliminar=" delete from  sget_hoja_ruta_nomina_hitos_personas  ";
				$Eliminar.=" where num_hoja_ruta='".$NHoja."' and cod_hito='".$CHito."' and  rut_personal='".$RutPer."'";
				mysql_query($Eliminar);
				$Inserta="INSERT INTO sget_hoja_ruta_nomina_hitos_personas (num_hoja_ruta,cod_hito,fecha,rut_personal,aprob_rechazo,num_tarjeta,fecha_hora)";
				$Inserta.=" values('".$NHoja."','".$CHito."','".$TxtFecha."','".$RutPer."','A','".$NTarj."','".$Fecha_Creacion."')";
				mysql_query($Inserta);
				$Actualizar="UPDATE sget_personal set nro_tarjeta='".$NTarj."',estado='A' where rut ='".$RutPer."' ";
				mysql_query($Actualizar);
				
				Registra_Actividad($NHoja,$Rut,'13','A');
				Registra_Autorizacion($NHoja,$Rut,$RutPer,'A',$CHito,'13');
				
				//echo $Inserta;
			/*}*/
		} 
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmPrincipal.action='$NomPag?Cons=S&CodSistema=".$CodSistema."&CodPantalla=".$CodPantalla."&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&TxtHoja=".$TxtHoja."&CmbAno=".$CmbAno."&CmbEstado=".$CmbEstado."';";
		echo "window.opener.document.FrmPrincipal.submit();";
		echo "window.close();</script>";
	break;
	//agregado por luis cortes.
	case "OBSA"://OBSERVACION PARA LA ANULACION DE UNA HOJA DE RUTA.
		$Actualizar=" UPDATE  sget_hoja_ruta set ";
		$Actualizar.="cod_estado_aprobado='15', observacion='".$Obs."'";	
		$Actualizar.=" where num_hoja_ruta='".$NumHoja."' ";
		//echo $Actualizar;
		mysql_query($Actualizar);
		
		$Insertar="INSERT INTO sget_reg_estados (num_hoja_ruta,cod_estado,fecha_hora,rut,acept_rech,tipo,ult)";
		$Insertar.=" values('".$NumHoja."','15','".$CookieRut."','','E','S')";
		//echo $Insertar;
		mysql_query($Insertar);
		
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmPrincipal.action='sget_autorizacion_gestion_riesgos.php?Cons=S&CodSistema=".$CodSistema."&CodPantalla=".$CodPantalla."&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&TxtHoja=".$TxtHoja."&CmbAno=".$CmbAno."&CmbEstado=".$CmbEstado."';";
		echo "window.opener.document.FrmPrincipal.submit();";
		echo "window.close();</script>";
	break;
	case "DESAHR"://DESHACE ANULACION DE HOJA DE RUTA
		$Eliminar="delete from sget_reg_estados where num_hoja_ruta='".$NumHoja."' and cod_estado='15'";
		//echo $Eliminar;
		mysql_query($Eliminar);	
		
		$Actualizar=" UPDATE  sget_hoja_ruta set ";
		$Actualizar.="cod_estado_aprobado='5', observacion='".$Obs."'";	
		$Actualizar.=" where num_hoja_ruta='".$NumHoja."' ";
		//echo $Actualizar;
		mysql_query($Actualizar);

		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmPrincipal.action='sget_autorizacion_gestion_riesgos.php?Cons=S&CodSistema=".$CodSistema."&CodPantalla=".$CodPantalla."&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&TxtHoja=".$TxtHoja."&CmbAno=".$CmbAno."&CmbEstado2=5';";
		echo "window.opener.document.FrmPrincipal.submit();";
		echo "window.close();</script>";
	break;
	
	case "EHRuta"://ENVIA CORREOS DE LAS PERSONAS ELIMINADAS DE LA HOJA DE RUTA
		$DatoRut=explode('//',$DatosEliminar);
		while(list($c,$v)=each($DatoRut))
		{
			$Dato=explode('~',$v);
			$Eliminar=" delete from  sget_hoja_ruta_nomina_hitos_personas  ";
			$Eliminar.=" where num_hoja_ruta='".$NumHoja."'  and  rut_personal='".$Dato[1]."'";
			mysql_query($Eliminar);
			$Eliminar=" delete from  sget_hoja_ruta_nomina";
			$Eliminar.=" where num_hoja_ruta='".$NumHoja."'  and  rut_personal='".$Dato[1]."'";
			//echo $Eliminar."<br>";
			mysql_query($Eliminar);
		}		
		//COD HITO 4 PERTENECE A APROBACION DE LA CHARLA.
		EnvioCorreoSinCharla($NumHoja,$DatosEliminar);
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmAut.action='sget_autoriza_nomina_integral_2.php?Cons=S&CodSistema=".$CodSistema."&CodPantalla=".$CodPantalla."&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&NumHoja=".$NumHoja."';";
		echo "window.opener.document.FrmAut.submit();";
		echo "window.close();</script>";
	break;
	
}


?>