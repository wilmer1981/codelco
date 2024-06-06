<?php
	include("../principal/conectar_principal.php");
	$CookieRut  = $_COOKIE["CookieRut"];
	$RutProceso = $CookieRut;

	$Rut      = isset($_REQUEST["Rut"])?$_REQUEST["Rut"]:"";
	$SA       = isset($_REQUEST["SA"])?$_REQUEST["SA"]:"";
	$Rec      = isset($_REQUEST["Rec"])?$_REQUEST["Rec"]:"";
	$TxtValor = isset($_REQUEST["TxtValor"])?$_REQUEST["TxtValor"]:"";

	$Consulta = "select nro_solicitud,recargo,peso_muestra from cal_web.solicitud_analisis where nro_solicitud = '".$SA."'";
	$Respuesta2= mysqli_query($link, $Consulta);
	$Encontro = false;
	while ($Fila2 = mysqli_fetch_array($Respuesta2))
	{
		if ($Fila2["recargo"] == 'R')//La  solicitud ya tiene recrago R 
		{
			$Encontro = 1; 		
			break;
		}
		else
			$Encontro =2;
	 }	

	if ($Encontro == 1) //Si ya tiene Recargo R solo actualiza el valor 
	{
		$Actualizar= "UPDATE  cal_web.solicitud_analisis set peso_muestra ='".$TxtValor."' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo = 'R' ";
		mysqli_query($link, $Actualizar); 
	}
	if($Encontro == 2) 	
	{	
		//consulta que  devuelve todos los datso asociados a la solicitud con el recargo 0 en la tabla solicitud de analisis
		$Consulta = "select * from cal_web.solicitud_analisis ";
		$Consulta = $Consulta." where (nro_solicitud = '".$SA."') and (rut_funcionario = '".$Rut."') and ((recargo= '0') or (recargo='' ))";
		$Respuesta=mysqli_query($link, $Consulta); 
		$Fila=mysqli_fetch_array($Respuesta);
		$Recargo=$Fila["recargo"];
		if ((is_null($Fila["peso_retalla"]))||($Fila["peso_retalla"]==""))
			$Peso = "NULL";
		else
			$Peso = $Fila["peso_retalla"];
		if ((is_null($Fila["nro_semana"]))||($Fila["nro_semana"]==""))
			$NroSemana="NULL";
		else
			$NroSemana=$Fila["nro_semana"];
		if ((is_null($Fila["año"]))||($Fila["año"]==""))
			$Ano="NULL";
		else
			$Ano=$Fila["año"];
		if ((is_null($Fila["mes"]))||($Fila["mes"]==""))
			$Mes="NULL";
		else
			$Mes=$Fila["mes"];
		if ((is_null($Fila["tipo"]))||($Fila["tipo"]==""))
			$Tipo="NULL";
		else
			$Tipo=$Fila["tipo"];
		if ($Recargo=='0') 
		{
			//inserta todos los registroa asociados a la solicitud con recargo 0 al nuevo registro con trecargo R 
			$insertar = "insert into cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,peso_muestra,recargo,";
			$insertar =$insertar." cod_producto,cod_subproducto,cod_analisis,cod_tipo_muestra,tipo_solicitud,";
			$insertar =$insertar." nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,rut_proveedor,peso_retalla,observacion,agrupacion,fecha_muestra,nro_semana,año,mes,tipo,enabal)";
			$insertar =$insertar." values ('".$Rut."','".$Fila["fecha_hora"]."','".$Fila["id_muestra"]."','".str_replace(",",".",$TxtValor)."',";
			$insertar =$insertar." '".$Rec."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."', ";
			$insertar =$insertar." '".$Fila["cod_analisis"]."','".$Fila["cod_tipo_muestra"]."','".$Fila["tipo_solicitud"]."',";
			$insertar =$insertar." '".$SA."','".$Fila["cod_area"]."','".$Fila["cod_ccosto"]."','".$Fila["cod_periodo"]."',";
			$insertar =$insertar." '".$Fila["estado_actual"]."','".$Fila["rut_proveedor"]."',".$Peso.",'".$Fila["observacion"]."', ";
			$insertar =$insertar." '".$Fila["agrupacion"]."','".$Fila["fecha_muestra"]."',".$NroSemana.",".$Ano.",".$Mes.",".$Tipo.",'".$Fila["enabal"]."')";
			mysqli_query($link, $insertar);
		}
		else//si es especial la nueva solictud con recargo R queda como automatica 
		{
			//Actualiza la solicitud especial en automatica 
			$Actualizar = $Actualizar="UPDATE cal_web.solicitud_analisis set recargo=0,tipo_solicitud ='A' where nro_solicitud='".$SA."' and rut_funcionario='".$Rut."' and id_muestra='".$Fila["id_muestra"]."'";	
			mysqli_query($link, $Actualizar);
			//inserta el nuevo registro de la solicitud especial insertando el recargo R de Retalla
			$insertar = "insert into cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,peso_muestra,recargo,";
			$insertar =$insertar." cod_producto,cod_subproducto,cod_analisis,cod_tipo_muestra,tipo_solicitud,";
			$insertar =$insertar." nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,rut_proveedor,peso_retalla,observacion,agrupacion,fecha_muestra,nro_semana,año,mes,tipo,enabal)";
			$insertar =$insertar." values ('".$Rut."','".$Fila["fecha_hora"]."','".$Fila["id_muestra"]."','".str_replace(",",".",$TxtValor)."',";
			$insertar =$insertar." '".$Rec."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."', ";
			$insertar =$insertar." '".$Fila["cod_analisis"]."','".$Fila["cod_tipo_muestra"]."','A',";
			$insertar =$insertar." '".$SA."','".$Fila["cod_area"]."','".$Fila["cod_ccosto"]."','".$Fila["cod_periodo"]."',";
			$insertar =$insertar." '".$Fila["estado_actual"]."','".$Fila["rut_proveedor"]."',".$Peso.",'".$Fila["observacion"]."', ";
			$insertar =$insertar." '".$Fila["agrupacion"]."','".$Fila["fecha_muestra"]."',".$NroSemana.",".$Ano.",".$Mes.",".$Tipo.",'".$Fila["enabal"]."')";
			mysqli_query($link, $insertar);
		}			
		if ($Recargo =='0')
			//consulta que devuelve los datos   asociadas ala solicitud con recargo  0 para insertalos ala nueva solicitud con recargo R
			//excepto las leyes del recargo 0 en la tabla leyes por solicitud  
			$Consulta = "select * from cal_web.leyes_por_solicitud where nro_solicitud = '".$SA."' and recargo = '0'";
		else
			//consulta que devuelve los datos   asociadas ala solicitud con recargo  0 para insertalos ala nueva solicitud con recargo R
			//excepto las leyes del recargo 0 en la tabla leyes por solicitud  
			$Consulta = "select * from cal_web.leyes_por_solicitud where nro_solicitud = '".$SA."'";
		$Respuesta4 = mysqli_query($link, $Consulta);
		$Fila4=mysqli_fetch_array($Respuesta4); 	
		if ($Recargo=='0' )
		{
			//nada
		}
		else 
		{
			if ((is_null($Fila4["recargo"]))||($Fila4["recargo"]==""))
			{
				//Actualiza la solicitud especial en automatica 
				$Actualizar="UPDATE cal_web.leyes_por_solicitud set recargo=0 where nro_solicitud='".$SA."' and rut_funcionario='".$Rut."' and recargo <> 'R'";	
				mysqli_query($link, $Actualizar);
			}
		}
		if ($Recargo =='0')
		{
			//consulta qie devuelve los estadsos asociados a la solicitud la  solicitud con el recargo 0
			$Consulta = "select * from cal_web.estados_por_solicitud where nro_solicitud = '".$SA."'  and recargo = '0' ";  
		}
		else
			$Consulta = "select * from cal_web.estados_por_solicitud where nro_solicitud = '".$SA."' ";  
		$Respuesta2=mysqli_query($link, $Consulta);
		while($Fila2=mysqli_fetch_array($Respuesta2))
		{
			if ($Recargo=='0') 
			{
				//NADA
			}
			else
			{
				if ((is_null($Fila4["recargo"]))||($Fila4["recargo"]==""))
				{
					$Actualizar="UPDATE cal_web.estados_por_solicitud set recargo=0 where nro_solicitud='".$SA."' and rut_funcionario='".$Rut."' and recargo <> 'R' ";	
					mysqli_query($link, $Actualizar);
				}
			}
			if ((is_null($Fila2["fecha_hora"]))||($Fila2["fecha_hora"]==""))
			{
				$insertar ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso)";
				$insertar.="values ('".$Rut."','". $SA."','R','".$Fila2["cod_estado"]."',NULL,'N','".$RutProceso."')";
				mysqli_query($link, $insertar);		
			}
			else
			{
				$insertar ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso)";
				$insertar.="values ('".$Rut."','". $SA."','R','".$Fila2["cod_estado"]."','".$Fila2["fecha_hora"]."','N','".$RutProceso."')";
				mysqli_query($link, $insertar);		
			}	
		}
	}
	$Consulta="select * from cal_web.solicitud_analisis where nro_solicitud=".$SA." and recargo='R'";
	$RespRetalla=mysqli_query($link, $Consulta);
	$FilaRetalla=mysqli_fetch_array($RespRetalla);
	$FechaReg = date('Y-m-d H:i:s');
	$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,recargo,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values(";
	$Insertar=$Insertar.$SA.",'".$FechaReg."','".$FilaRetalla["rut_funcionario"]."','".$FilaRetalla["recargo"]."','PES.RET','".str_replace(",",".",$TxtValor)."','','','','".$RutProceso."')";
	mysqli_query($link, $Insertar);
	
	header("location:../cal_web/cal_retalla.php?Rut=".$Rut."&SA=".$SA."&Rec=".$Rec."&TxtValor=".$TxtValor);
?>




