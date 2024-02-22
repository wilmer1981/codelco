<?  include("../principal/conectar_sget_web.php");
	$Fecha=date('Y-m-d');
	$RutDV=$TxtRutPrv;
	$Fecha_Hora = date("Y-m-d h:i");
	switch($Opcion)
	{
		case "N":
			$Consulta="SELECT * from sget_contratistas where rut_empresa='".$RutDV."' ";
			$Respuesta=mysql_query($Consulta);
			if ($Fila=mysql_fetch_array($Respuesta))
			{
				$Encontro=true;
				header("location:sget_mantenedor_empresas_proceso.php?Mensaje=".$Encontro."&Opc=".$Opcion);
			}
			else
			{
				if($CmbCiudad =='-1')
					$CmbCiudad=0;
				if($CmbComuna =='-1')
					$CmbComuna=0;	
				if($CmbMutuales =='-1')
					$CmbMutuales=0;		
				if($CmbPrevencionista =='-1')
					$CmbPrevencionista=0;	
				if($TxtFechaCert =='')	
					$TxtFechaCert='0000-00-00';
				$RutDV=str_pad($RutDV,10,'0',l_pad);			
				$Insertar="INSERT INTO sget_contratistas(rut_empresa,razon_social, ";
				$Insertar.=" nombre_fantasia,calle,cod_ciudad,cod_comuna,mail_empresa,telefono_comercial, ";
				$Insertar.=" repres_legal1,telefono_repres1,mail_repres_legal1,celular_repres_legal1, ";
				$Insertar.=" repres_legal2,telefono_repres2,celular_repres_legal2,mail_repres_legal2, ";
				$Insertar.=" nro_regic,cod_mutual_seguridad,nro_registro,fecha_ven_cert,estado,cod_region) ";
				$Insertar.="values ('".$RutDV."','".strtoupper($TxtRazonSocial)."','".strtoupper($TxtNombreFantasia)."','".strtoupper($TxtCalle)."', ";
				$Insertar.="'".$CmbCiudad."','".$CmbComuna."','".strtoupper($TxtCorreo)."' ,'".$TxtFono."', ";
				$Insertar.="'".strtoupper($TxtRep1)."','".$TxtFonoRep1."','".strtoupper($TxtMailRep1)."' , ";
				$Insertar.="'".$TxtCelRep1."','".strtoupper($TxtRep2)."','".$TxtFonoRep2."' , ";
				$Insertar.="'".$TxtCelRep2."','".strtoupper($TxtMailRep2)."','".$TxtNroRegic."' , ";
				$Insertar.="'".$CmbMutuales."','".$TxtNroRegistro."','".$TxtFechaCert."','1','".$CmbRegion."') ";
				mysql_query($Insertar);
				if($Form!='')
				{
					echo "<script languaje='JavaScript'>";		
					echo " window.opener.document.$Form.action='$Pagina?Empresa=$RutDV'; ";
					echo " window.opener.document.$Form.submit();";		
					echo " window.close();</script>";
				}
				else
				{
					echo "<script languaje='JavaScript'>";		
					echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_empresas.php?Cons=S&RutEmp=".$RutDV."'; ";
					echo " window.opener.document.FrmPrincipal.submit();";		
					echo " window.close();</script>";
				}
			}
			
		break;
		case "M":
			$Eliminar="delete  from sget_contratistas  ";
			IF ($NewOpc=='S')
				$Eliminar.=" where rut_empresa='".$RutAnt."'";
				else
				$Eliminar.=" where rut_empresa ='".$RutDV."'";	
			mysql_query($Eliminar);
			if($CmbCiudad =='-1')
				$CmbCiudad=0;
			if($CmbComuna =='-1')
				$CmbComuna=0;	
			if($CmbMutuales =='-1')
				$CmbMutuales=0;		
			if($CmbPrevencionista =='-1')
				$CmbPrevencionista=0;	
			if($TxtFechaCert =='')	
				$TxtFechaCert='0000-00-00';
			$Insertar="INSERT INTO sget_contratistas(rut_empresa,razon_social, ";
			$Insertar.=" nombre_fantasia,calle,cod_ciudad,cod_comuna,mail_empresa,telefono_comercial, ";
			$Insertar.=" repres_legal1,telefono_repres1,mail_repres_legal1,celular_repres_legal1, ";
			$Insertar.=" repres_legal2,telefono_repres2,celular_repres_legal2,mail_repres_legal2, ";
			$Insertar.=" nro_regic,cod_mutual_seguridad,nro_registro,fecha_ven_cert,estado,cod_region) ";
			$Insertar.="values ('".$RutDV."','".strtoupper($TxtRazonSocial)."','".strtoupper($TxtNombreFantasia)."','".strtoupper($TxtCalle)."', ";
			$Insertar.="'".$CmbCiudad."','".$CmbComuna."','".strtoupper($TxtCorreo)."' ,'".$TxtFono."', ";
			$Insertar.="'".strtoupper($TxtRep1)."','".$TxtFonoRep1."','".strtoupper($TxtMailRep1)."' , ";
			$Insertar.="'".$TxtCelRep1."','".strtoupper($TxtRep2)."','".$TxtFonoRep2."' , ";
			$Insertar.="'".$TxtCelRep2."','".strtoupper($TxtMailRep2)."','".$TxtNroRegic."' , ";
			$Insertar.="'".$CmbMutuales."','".$TxtNroRegistro."','".$TxtFechaCert."','1','".$CmbRegion."') ";
			mysql_query($Insertar);
			if ($NewOpc=='S')
			{
				$Consulta1 ="SELECT * from des_sget.sget_comparacion_sueldo where rut_empresa = '".$RutAnt."'";
				$Resp1=mysql_query($Consulta1);
				if ($Fila1=mysql_fetch_array($Resp1))
				{
					$Actualiza1="UPDATE des_sget.sget_comparacion_sueldo set rut_empresa = '".$RutDV."' ";
					$Actualiza1.=" where rut_empresa = '".$RutAnt."'";
					mysql_query($Actualiza1);
				}
				$Consulta2 ="SELECT * from des_sget.sget_contratos where rut_empresa = '".$RutAnt."'";
				$Resp2=mysql_query($Consulta2);
				if ($Fila2=mysql_fetch_array($Resp2))
				{
					$Actualiza2="UPDATE des_sget.sget_contratos set rut_empresa = '".$RutDV."' ";
					$Actualiza2.=" where rut_empresa = '".$RutAnt."'";
					mysql_query($Actualiza2);
				}
				$Consulta3 ="SELECT * from des_sget.sget_hoja_ruta where rut_empresa = '".$RutAnt."'";
				$Resp3=mysql_query($Consulta3);
				if ($Fila3=mysql_fetch_array($Resp3))
				{
					$Actualiza3="UPDATE des_sget.sget_hoja_ruta set rut_empresa = '".$RutDV."' ";
					$Actualiza3.=" where rut_empresa = '".$RutAnt."'";
					mysql_query($Actualiza3);
				}
				$Consulta4 ="SELECT * from des_sget.sget_personal where rut_empresa = '".$RutAnt."'";
				$Resp4=mysql_query($Consulta4);
				if ($Fila4=mysql_fetch_array($Resp4))
				{
					$Actualiza4="UPDATE des_sget.sget_personal set rut_empresa = '".$RutDV."' ";
					$Actualiza4.=" where rut_empresa = '".$RutAnt."'";
					mysql_query($Actualiza4);
				}
				$Consulta5 ="SELECT * from des_sget.sget_sub_contratistas where rut_empresa = '".$RutAnt."'";
				$Resp5=mysql_query($Consulta5);
				if ($Fila5=mysql_fetch_array($Resp5))
				{
					$Actualiza5="UPDATE des_sget.sget_sub_contratistas set rut_empresa = '".$RutDV."' ";
					$Actualiza5.=" where rut_empresa = '".$RutAnt."'";
					mysql_query($Actualiza5);
				}
				$Consulta6 ="SELECT * from des_sget.sget_personal_historia where rut_empresa = '".$RutAnt."'";
				$Resp6=mysql_query($Consulta6);
				if ($Fila6=mysql_fetch_array($Resp6))
				{
					$Actualiza6="UPDATE des_sget.sget_personal_historia set rut_empresa = '".$RutDV."' ";
					$Actualiza6.=" where rut_empresa = '".$RutAnt."'";
					mysql_query($Actualiza6);
				}
				 
			}
			if($Form!='')
			{
				echo "<script languaje='JavaScript'>";		
				echo " window.opener.document.$Form.action='$Pagina?Empresa=$RutDV'; ";
				echo " window.opener.document.$Form.submit();";		
				echo " window.close();</script>";
			}
			else
			{
				$vale =1;
				header("location:sget_mantenedor_empresas_proceso.php?Valores=".$RutDV."&Opc=".$Opcion);
			}
		break;
		case "E":
			$Datos = explode("//",$Valor);
			while (list($clave,$Rut)=each($Datos))
			{
				$Consulta=" Select count(rut_empresa) as Total from sget_contratos where rut_empresa='".$Rut."'";
				//echo $Consulta."<br>";
				$Respuesta=mysql_query($Consulta);
				$Fila=mysql_fetch_array($Respuesta);
				if ($Fila["total"]<=0)
				{
					$Eliminar="delete from sget_contratistas where rut_empresa='".$Rut."'";
					mysql_query($Eliminar);
					$Mensaje="N";
				}
				else
				{
					$Mensaje="S";
					break;	
				}	
			}
			if($Mensaje=="N")
				$Mensaje='Empresa(s) Eliminada(s) Exitosamente';
			else
				$Mensaje='Empresa(s) No puede ser Eliminada tiene Contratos Asociados';	
			header("location:sget_mantenedor_empresas.php?Mensaje=".$Mensaje);
		break;
		case "GSC":
			$Insertar="INSERT INTO sget_sub_contratistas(rut_contratista,rut_empresa) ";
			$Insertar.="values ('".$RutDV."','".$CmbEmpresa."') ";
			
			mysql_query($Insertar);
			header("location:sget_mantenedor_empresas_proceso.php?Opc=M&Valores=".$RutDV);
		break;
	case "ESC":
			$Delete="delete from  sget_sub_contratistas where rut_contratista='".$RutDV."' and rut_empresa='".$Clave."'";
			mysql_query($Delete);
			header("location:sget_mantenedor_empresas_proceso.php?Opc=M&Valores=".$RutDV);
		break;

	
	}
?>
