<?
	include("../principal/conectar_scop_web.php");
	include("funciones/scop_funciones.php");
	$Encontro=false;
	$Rut=$CookieRut;
	$Fecha=date('Y-m-d H:i:s');
	switch($Opcion)
	{  
		case "VI"://valores imputacion			
			$Valores=explode("//",$Valores2);
			while(list($c,$Codigo)=each($Valores))
			{
				$Codigo=explode("~",$Codigo);
				//echo $Codigo[0]."&nbsp;".$Codigo[1]."&nbsp;".$Codigo[2]."<BR>";
				$Valor=str_replace(".","",$Codigo[2]);
				$Valor=str_replace(",",".",$Valor);
				$ConsultaImputacion="select * from scop_imputacion where ano='".$Ano."' and cod_ley='".$TipoCodLey."' and mes='".$Mes."' and cod_division='".$Codigo[1]."'";
				$RespCorreo=mysql_query($ConsultaImputacion);
				if(!$FilaCorreo=mysql_fetch_array($RespCorreo))
				{
					$InsertaImputacion="INSERT INTO scop_imputacion (ano,mes,cod_ley,estado,cod_division,valor_imputado)";
					$InsertaImputacion.=" values('".$Ano."','".$Mes."','".$TipoCodLey."','6','".$Codigo[1]."','".$Valor."')";
					//echo "insertar   ".$InsertaImputacion."<br>";
					mysql_query($InsertaImputacion);	
				}
				else
				{
					$ActualizarCost="UPDATE scop_imputacion set valor_imputado='".$Valor."'";
					$ActualizarCost.=" where ano='".$Ano."' and mes='".$Mes."' and cod_division='".$Codigo[1]."' and cod_ley='".$TipoCodLey."'";
					//echo "actualiza cost:  ".$ActualizarCost."<br>";
					mysql_query($ActualizarCost);
				}					
			}
			$VI='S';
			header('location:scop_proceso_cobertura_imputacion_valores.php?Opcion=M&Ano='.$Ano.'&Mes='.$Mes.'&CoPlOr='.$CoPlOr.'&VI='.$VI);
		break;	    
		case "VIM"://valores imputacion	 modificacion		
			$Valores=explode("//",$Valores2);
			while(list($c,$Codigo)=each($Valores))
			{
				$Codigo=explode("~",$Codigo);
				$Valor=str_replace(".","",$Codigo[2]);
				$Valor=str_replace(",",".",$Valor);
				$ConsultaImputacion="select * from scop_imputacion where ano='".$Ano."' and mes='".$Mes."' and cod_division='".$Codigo[1]."' and cod_ley='".$TipoCodLey."'";
				$RespCorreo=mysql_query($ConsultaImputacion);
				if(!$FilaCorreo=mysql_fetch_array($RespCorreo))
				{
					$InsertaImputacion="INSERT INTO scop_imputacion (ano,mes,cod_ley,estado,cod_division,valor_imputado)";
					$InsertaImputacion.=" values('".$Ano."','".$Mes."','".$TipoCodLey."','6','".$Codigo[1]."','".$Valor."')";
					mysql_query($InsertaImputacion);	
				}
				else
				{
					$ActualizarImputacion="UPDATE scop_imputacion set valor_imputado='".$Valor."'";
					$ActualizarImputacion.=" where ano='".$Ano."' and mes='".$Mes."' and cod_division='".$Codigo[1]."' and cod_ley='".$TipoCodLey."'";
					mysql_query($ActualizarImputacion);
				}					
			}
			$VIM='S';
			header('location:scop_proceso_cobertura_imputacion_valores.php?Opcion=M&Ano='.$Ano.'&Mes='.$Mes.'&CoPlOr='.$CoPlOr.'&VIM='.$VIM);
		break;	    
		case "AC"://ABRIR CANDADO
			$Valores=explode("//",$Valores);
			while(list($c,$Codigo)=each($Valores))
			{
				$Dato=explode("~",$Codigo);
				$InsertaCost="UPDATE scop_carry_cost set estado='5'";
				$InsertaCost.=" where corr='".$Dato[0]."' and parcializacion='".$Dato[1]."' and ano='".$Dato[2]."' and mes='".$Dato[3]."'";
				//echo $InsertaCost."<br><br>";
				mysql_query($InsertaCost);	
				
				$DatosContratos=explode("~",$Contratos);
				while(list($c,$v)=each($DatosContratos))
				{
					//EN EL CAMPO IDENTIFICACION VA TIPOCONTRATO-A�O-MES
					$InsertaRegistroEstado="INSERT INTO scop_registro_estado (cod_estado,identificacion,rut,fecha_hora,observacion)";
					$InsertaRegistroEstado.=" values('5','".$v."-".$Ano."-".$Mes."','".$Rut."','".$Fecha."','Proceso Imputacion Abierto, Modificar')";
					//echo $InsertaRegistroEstado."<br>";
					mysql_query($InsertaRegistroEstado);	
				}	
			}
			header('location:scop_proceso_cobertura_imputacion_cc.php?&Buscar=S&Ano='.$Ano.'&Mes='.$Mes);
		break;
		case "ED"://eliminar valores de la division
			$Datos=explode("~",$Valores);
			$EliminarValor="delete from scop_imputacion where  cod_division='".$Datos[0]."' and ano='".$Datos[1]."' and mes='".$Datos[2]."' and cod_ley='".$CoPlOr."'";
			mysql_query($EliminarValor);	
			$MEli='E';
			header('location:scop_proceso_cobertura_imputacion_valores.php?Opcion=M&Ano='.$Ano.'&Mes='.$Mes.'&MEli='.$MEli.'&CoPlOr='.$CoPlOr);
		break;
		case "GIPV"://GRABA EL PROCESO DE IMPUTACION DE LOS VALORES ESTADO 6
			$Valores=explode("//",$Valores);
			while(list($c,$Codigo)=each($Valores))
			{
				$Dato=explode("~",$Codigo);				
				$ActualizarCost="UPDATE scop_carry_cost set estado='6'";
				$ActualizarCost.=" where corr='".$Dato[0]."' and parcializacion='".$Dato[1]."' and ano='".$Dato[2]."' and mes='".$Dato[3]."'";
				mysql_query($ActualizarCost);
	
				$InsertaRegistroEstado="INSERT INTO scop_registro_estado (cod_estado,identificacion,rut,fecha_hora,observacion)";
				$InsertaRegistroEstado.=" values('6','".$Dato[0]."-".$Dato[1]."-".$Dato[2]."-".$Dato[3]."','".$Rut."','".$Fecha."','Imputacion Ingresada, Procesos Cerrados')";
				mysql_query($InsertaRegistroEstado);	
			}
			//ENVIO DE CORREO FUNCION GC=Abrir Candado Para Volver a Ingresar Carry Cost
			$Consulta="select * from proyecto_modernizacion.sub_clase";
			$Consulta.=" where cod_clase='33007' and nombre_subclase<>''  and not isnull(nombre_subclase) and valor_subclase1='5'";
			//echo $Consulta."<br>";
			$RespCorreo=mysql_query($Consulta);
			while($FilaCorreo=mysql_fetch_array($RespCorreo))
					EnvioCorreo($FilaCorreo["nombre_subclase"],'6',$TipEst,$Dato[2],$Dato[3],$Meses,'VI','','','','','','');	//ENVIO CORREO Imputacion

			$Envio='N';
			$Consulta="select * from proyecto_modernizacion.sub_clase";
			$Consulta.=" where cod_clase='33007' and nombre_subclase<>''  and not isnull(nombre_subclase) and valor_subclase1='5'";
			//echo $Consulta."<br>";
			$RespCorreo=mysql_query($Consulta);
			if($FilaCorreo=mysql_fetch_array($RespCorreo))
				$Envio='S';

			header('location:scop_proceso_cobertura_imputacion_cc.php?Buscar=S&Ano='.$Dato[2].'&Mes='.$Dato[3].'&Envio='.$Envio);
		break;
	}
?>		