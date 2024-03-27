<?
	//echo "PROCESO:".$Proc;
	include("../principal/conectar_sget_web.php");
    include("funciones/sget_funciones.php");
	switch ($Proc)
	{
		case "G"://GRABA PERSONA
		
			if($EcoSI=='')
				$EcoSI=0;
			if($CttoSI=='')
				$CttoSI=0;
			if($EcoSB=='')
				$EcoSB=0;
			if($CttoSB=='')
				$CttoSB=0;
			if($EcoSL=='')
				$EcoSL=0;	
			if($CttoSL=='')
				$CttoSL=0;
		/*	$EcoSI=str_replace($EcoSI,'.','');
			$CttoSI=str_replace($CttoSI,'.','');
			$EcoSB=str_replace($EcoSB,'.','');
			$CttoSB=str_replace($CttoSB,'.','');
			$EcoSL=str_replace($EcoSL,'.','');
			$CttoSL=str_replace($CttoSL,'.','');
			*/
			$Consulta="SELECT * from sget_comparacion_sueldo where rut_funcionario ='".$TxtRut."' and cod_contrato='".$Contrato."' and rut_empresa='".$Empresa."'";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{
				$Actualizar=" UPDATE  sget_comparacion_sueldo set ";
				$Actualizar.="eco_si='".str_replace('.','',$EcoSI)."',ctto_si='".str_replace('.','',$CttoSI)."',eco_sb='".str_replace('.','',$EcoSB)."',ctto_sb='".str_replace('.','',$CttoSB)."'";
				$Actualizar.=",eco_sl='".str_replace('.','',$EcoSL)."',ctto_sl='".str_replace('.','',$CttoSL)."'";
				$Actualizar.=" where rut_funcionario ='".$TxtRut."' and cod_contrato='".$Contrato."' and rut_empresa='".$Empresa."'";
				mysql_query($Actualizar);
				header("location:sget_comparacion_sueldo_proceso.php?&Proceso=M&Valores=".$TxtRut);
			}
			else
			{		
				$Insertar=" INSERT INTO sget_comparacion_sueldo(rut_funcionario,cod_contrato,rut_empresa,eco_si,ctto_si,eco_sb,ctto_sb,eco_sl,ctto_sl)values( ";
				$Insertar.="'".$TxtRut."','".$Contrato."','".$Empresa."','".str_replace('.','',$EcoSI)."','".str_replace('.','',$CttoSI)."','".str_replace('.','',$EcoSB)."','".str_replace('.','',$CttoSB)."'";
				$Insertar.=",'".str_replace('.','',$EcoSL)."','".str_replace('.','',$CttoSL)."')";
				mysql_query($Insertar);
				header("location:sget_comparacion_sueldo_proceso.php?&Proceso=M&Valores=".$TxtRut);
		
			}	
			break;	
	}

?>