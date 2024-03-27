<?
	require "includes/class.phpmailer.php";
	
	function EncabezadoPagina($IP_SERV,$Imagen)
	{
		include("encabezado.php")?>
		 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
		 <tr> 
		 <td width="958" valign="top">
		 <table width="760" border="0" cellspacing="0" cellpadding="0" >
			<tr>
			  <td height="30" align="right" >
			  <table width="100%" class="TablaPrincipal2">
					<tr valign="middle"> 
					  <td width="271"><img src="archivos\Titulos\<? echo $Imagen; ?>"></td>
					  <td width="179" align="right"><font color="#9E5B3B">&nbsp;<font face="Times New Roman, Times, serif" size="2">Servidor 
						<? 
						echo $IP_SERV;?>
					  </font></font></td>
					  <td width="280" align="right"><font size="2" face="Times New Roman, Times, serif">&nbsp; 
						</font><font color="#9E5B3B" face="Times New Roman, Times, serif">&nbsp; 
						<? 
						//$Fecha_Hora = date("d-m-Y h:i");
						$FechaFor=FechaHoraActual();
						echo $FechaFor." hrs";
						?>
						</font>
						</td>
						<td align="right" width="24">
						<a href="Manual_Usuario_scop.pdf"  target="_blank"><img src="archivos/acrobat.png" alt='Manual de Usuario' width="20" height="20" border="0"></a>
					    </td>
					</tr>
				</table></td>
			</tr>
		  </table>
	
	<?
	}

	function CierreEncabezado()
	{
		?>
		</td>
    	</tr>
  		</table>
		<? include("pie_pagina.php");
	}
	function DatosCC($Cod)
	{
		$Consulta="select * from pcip_eec_centro_costos where cod_cc='".$Cod."' ";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Datos=$Fila[cod_gerencia].'~'.$Fila[cod_area].'~'.$Fila[descrip_area].'~'.$Fila[cod_cc].'~'.$Fila["abreviatura"];
		return($Datos);	
	}
	function DatosSumistros($Cod)
	{
		$Consulta="select * from pcip_eec_suministros where cod_suministro='".$Cod."' ";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Datos=$Fila[cod_suministro].'~'.$Fila[nom_suministro].'~'.$Fila["cod_unidad"];
		return($Datos);	
	}
	function DatosListaExcel($Cod)
	{
		$Consulta="select * from pcip_lista_excel where cod_excel='".$Cod."' ";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Datos=$Fila[cod_excel].'~'.$Fila[nom_excel].'~'.$Fila[perfiles_accesos].'~'.$Fila["valor"].'~'.$Fila[ini_fil_cc].'~'.$Fila[ini_col_cc].'~'.$Fila[hoja].'~'.$Fila[tipo_excel].'~'.$Fila[corta_mes].'~'.$Fila[tipo_carga];
		return($Datos);	
	}
	function QuitaMiles($Valor)
	{
		$Valor=str_replace('.','',$Valor);
		return($Valor);
	}
	function QuitaMilesDecimales($Valor)
	{
		$Valor=str_replace('.','',$Valor);
		$Valor=str_replace(',','.',$Valor);
		return($Valor);
	}
	function FormatearRun($Run)
	{
		$RUT=substr($Run,0,strlen($Run-2));
		$RUT1=substr($Run,0,2);
		$RUT2=substr($Run,2,3);
		$RUT3=substr($Run,5,3);
		$RUT4=substr($Run,8,2);
		
		$RUT=$RUT1.".".$RUT2.".".$RUT3."".$RUT4;
		return($RUT);
	}
	function FormatearNombre($Nombre)
	{
		$Nom=ucwords(strtolower($Nombre));
		return($Nom);
	}
	function FechaHoraActual()
	{
		$Dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S�bado");
		$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$str_dia = date("w");
		$str_dia = $str_dia;
		$dia = date("j");
		$mes = date("n");
		$mes = $mes - 1;
		$ano = date("Y");
		$hora = date("H");
		$min = date("i");
		$FormatFecha= $Dias[$str_dia]." ".$dia." de ".$Meses[$mes]." de ".$ano." ".$hora.":".$min;
		return($FormatFecha);
	}
	function edad($edad){
		list($anio,$mes,$dia) = explode("-",$edad);
		$anio_dif = date("Y") - $anio;
		$mes_dif = date("m") - $mes;
		$dia_dif = date("d") - $dia;
		if ($dia_dif < 0 || $mes_dif < 0)
		$anio_dif--;
		return $anio_dif;
	}
	function FormatoFechaAAAAMMDD($FechaReal)
	{
		//echo "fecha1".$FechaReal."<br>";
		if($FechaReal!='')
		{
			$Datos = explode("/",$FechaReal);
			$Dia=$Datos[2];
			$Mes=$Datos[1];
			$A�o=$Datos[0];
			$FechaFormat=$Dia.'-'.$Mes.'-'.$A�o;
			//echo "fecha2".$FechaFormat."<br>";
		}
		else
			$FechaFormat='0000-00-00';
		return ($FechaFormat);
	}
	function FormatoFechaAAAAMMDD2($FecDDMMAAAA)
	{
		if(substr($FecDDMMAAAA,2,1)=='/')
		  $Separador='/';
		else
		  $Separador='-';
		//echo "fecha: ".$FecDDMMAAAA."<br>";
		if($FecDDMMAAAA!='')
		{
			$Datos = explode($Separador,$FecDDMMAAAA);
			$Dia=$Datos[2];
			$Mes=$Datos[1];
			$A�o=$Datos[0];
			if($Dia=='')
				$FechaFormat='0000-00-00';
			else
				$FechaFormat=$Dia.'-'.$Mes.'-'.$A�o;
			//echo "fecha2:".$FechaFormat."<br>";
		}
		else
			$FechaFormat='0000-00-00';
		return ($FechaFormat);
	}
	function ValidaEntero($Cod)
	{
		if($Cod=='S'||$Cod==''||$Cod=='-1')
			$Cod=0;
		else
			$Cod=$Cod;	
		return($Cod);
	}
	function ObtenerMaxCorr($Tabla,$Campo)
	{
		$Consulta="select max(".$Campo.") as mayor from ".$Tabla;
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysql_fetch_array($Resp);
		$Corr=$Fila["mayor"]+1;
		return($Corr);
	}

function resta_fechas($fecha1,$fecha2)
{
     // echo "f_1".$fecha1."<br>"; 
	  //echo "f_2".$fecha2."<br>"; 
	  if($fecha1 != '0000-00-00' && $fecha2 != '0000-00-00')
	  {
		  $fecha1=substr($fecha1,8,2)."-".substr($fecha1,5,2)."-".substr($fecha1,0,4);
		  $fecha2=substr($fecha2,8,2)."-".substr($fecha2,5,2)."-".substr($fecha2,0,4);
		  //echo "f1".$fecha1."<br>";
		  //echo "f2".$fecha2."<br>";
		  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
				  list($dia1,$mes1,$año1)=split("-",$fecha1);
		  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
				  list($dia1,$mes1,$año1)=split("-",$fecha1);
		  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
				  list($dia2,$mes2,$año2)=split("-",$fecha2);
		  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
				  list($dia2,$mes2,$año2)=split("-",$fecha2);
		  $dif = mktime(0,0,0,$mes1,$dia1,$año1,1) - mktime(0,0,0,$mes2,$dia2,$año2,1);
		  //echo "dif".$dif."<br>";
		  $ndias=floor($dif/(24*60*60));
		 //echo "DIAS:".$ndias."<br><br>";
	 }
	 else 
		 $ndias=0;
      return($ndias);
}
function valida_rut($r)
{
	$r=strtoupper(ereg_replace('\.|,|-','',$r));
	$sub_rut=substr($r,0,strlen($r)-1);
	$sub_dv=substr($r,-1);
	$x=2;
	$s=0;
	for ( $i=strlen($sub_rut)-1;$i>=0;$i-- )
	{
		if ( $x >7 )
		{
			$x=2;
		}
		$s += $sub_rut[$i]*$x;
		$x++;
	}
	$dv=11-($s%11);
	if ( $dv==10 )
	{
		$dv='K';
	}
	if ( $dv==11 )
	{
		$dv='0';
	}
	if ( $dv==$sub_dv )
	{
		return true;
	}
	else
	{
		return false;
	}
}
	
function CambioDeEstado($Rut,$Contrato,$Fecha,$Ano,$Mes,$Tipo)
{
	if($Tipo=='2')//SI ES 2 ES PARA ACTUALIZAR LOS DATOS A VALIDADO
	{
		$Consulta="select cod_estado,cod_contrato,rut,mes,ano from scop_inventario where cod_contrato='".$Contrato."' and cod_estado='1' and ano='".$Ano."' and mes='".$Mes."'";
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$Actualizar="UPDATE scop_inventario set rut='".$Rut."', fecha_hora='".$Fecha."', cod_estado='2',observacion='validado' where cod_estado='".$Fila["cod_estado"]."'";
			$Actualizar.=" and cod_contrato='".$Fila["cod_contrato"]."' and ano='".$Fila["ano"]."' and mes='".$Fila["mes"]."'";
			mysql_query($Actualizar);
			
			//GUARDAR EN LA TABLA REGISTROS LO MODIFICADO
			//ACA EN IDENTIFICACION GUARDA TIPO CONTRATO - ANO - MES
			$InsertarRe="INSERT INTO scop_registro_estado (cod_estado,identificacion,rut,fecha_hora,observacion)";
			$InsertarRe.=" values('2','".$Fila["cod_contrato"]."-".$Ano."-".$Mes."','".$Rut."','".$Fecha."','validado')";	
			mysql_query($InsertarRe);		
		}	
		else
		{
			$Inserta="INSERT INTO scop_inventario (cod_estado,cod_contrato,rut,fecha_hora,ano,mes,observacion)";
			$Inserta.=" values('2','".$Contrato."','".$Rut."','".$Fecha."','".$Ano."','".$Mes."','validado')";
			mysql_query($Inserta);				

			//ACA EN IDENTIFICACION GUARDA TIPO CONTRATO - ANO - MES
			$InsertarRe="INSERT INTO scop_registro_estado (cod_estado,identificacion,rut,fecha_hora,observacion)";
			$InsertarRe.=" values('2','".$Contrato."-".$Ano."-".$Mes."','".$Rut."','".$Fecha."','validado')";	
			mysql_query($InsertarRe);		
		}
	}	
	else// CUANDO INGRESA CONTRATO NUEVO QUEDA CON ESTADO CREADO
	{		
		//$Inserta="INSERT INTO scop_inventario (cod_estado,cod_contrato,rut,fecha_hora,observacion)";
		//$Inserta.=" values ('1','".$Contrato."','".$Rut."','".$Fecha."','creado')";
		//mysql_query($Inserta);	

		//ACA EN IDENTIFICACION GUARDA TIPO CONTRATO					
		$InsertarRe="INSERT INTO scop_registro_estado (cod_estado,identificacion,rut,fecha_hora,observacion)";
		$InsertarRe.=" values ('1','".$Contrato."','".$Rut."','".$Fecha."','creado')";	
		mysql_query($InsertarRe);		
	}
}
function EnvioCorreo($Correo,$NumEstado,$TipoEst,$Ano,$Mes,$Meses,$TipoEstado,$TipContrato,$Acuerdo,$Obs,$CarryQP,$PrecioFijo,$CmbComVen)	
{	
	$FechaActual=date('Y-m-d');
	$DiaSemana=date('w');
	$DiaMes=date('j');
	if($Acuerdo!='-1')
		$MesAcu='Mes ';
	else
		$MesAcu='Mes +';	
	$MesCorreo=$Meses[$Mes-1];
	if($TipoEstado=='PV')//INVENTARIO VALIDACION
	{	//ESTADO 2 pantalla valida inventario
		$Asunto='Validaci�n Inventario '.$MesCorreo.'&nbsp;'.$Ano.'';
		$Titulo='Validaci�n Inventario '.$MesCorreo.'&nbsp;'.$Ano.'';
		$Mensaje='<font face="Arial" size="2">La Unidad Operaciones Comerciales a Validado el Inventario Correspondiente para el Mes <b>'.$MesCorreo.'&nbsp;'.$Ano.'</b>';
		$Mensaje.='<br>';
		$Mensaje.='Para su Revisi�n e Ingreso de Valores Carry Costs Correspondientes.';
		$Mensaje.='<br><br>';
		$Mensaje.='"'.$Obs.'"';
		$Mensaje.='Por Favor seguir el link para ingresar a Pantalla de Inventario para Coberturas.';
		$Mensaje.='<br><br>';
		$Mensaje.='Y una Vez seleccionados las Opciones y Seleccionados los Contratos, Grabar el Proceso';
		$Mensaje.='<br><br>';
		$Mensaje.='<a href="http://10.56.11.9/proyecto/scop_web/scop_proceso_cobertura_carry_cost_proceso.php?Opc=N"><font size="2">Revisi�n de Inventario Validado</font></a>';
	}
	if($TipoEstado=='GC')//CARRY COST
	{	//ESTADO 3.	
		$Asunto='Validaci�n Carry Cost '.$MesCorreo.'&nbsp;'.$Ano.'';
		$Titulo='Carry Cost Ingresado, Validado '.$MesCorreo.'&nbsp;'.$Ano.'';	
		$Mensaje='<font face="Arial" size="2">La Unidad Operaciones Comerciales a Validado el Carry Cost para el Mes <b>'.$MesCorreo.'&nbsp;'.$Ano.'&nbsp;y Acuerdo Contractual Buscado&nbsp;'.$MesAcu.$Acuerdo.'</b>';
		$Mensaje.='<br>';
		$Mensaje.='Para su Revisi�n e Ingreso de Precios de Metales Correspondientes.</font>';
	}
	if($TipoEstado=='VIMP')//VALORES precios PANTALLA SCOP_PROCESO_COBERTURA_CARRY_COST CUANDO VALIDO LOS VALORES INGRESADOS
	{	//ESTADO 5.
		$Asunto='Validaci�n Precios Metales por la VCO '.$MesCorreo.'&nbsp;'.$Ano.'';
		$Titulo='Validaci�n Precios Metales por la VCO '.$MesCorreo.'&nbsp;'.$Ano.'';	
		$Mensaje='<font face="Arial" size="2">La Unidad Operaciones Comerciales a Validado los Precios de los Metales para el mes <b>'.$MesCorreo.'&nbsp;'.$Ano.'&nbsp;y Acuerdo Contractual Buscado&nbsp;'.$MesAcu.$Acuerdo.'</b>';
		$Mensaje.='<br><br>';
		$Mensaje.='Por Favor seguir el link para ingresar a pantalla de imputaci�n de precios</font>';
		$Mensaje.='<br><br>';
		$Mensaje.='<a href="http://10.56.11.9/proyecto/scop_web/scop_proceso_cobertura_imputacion_cc.php?&Buscar=S&Ano='.$Ano.'&TipoEst='.$TipEst.'&CmbAcuerdo='.$Acuerdo.'"><font size="2">Link imputacion de valores</font></a>';
	}
	if($TipoEstado=='CA')//CERRAR CANDADO PANTALLA SCOP_PROCESO_COBERTURA_VCO para que carry cost valide los precios metales para poder imputar
	{	//ESTADO 4.
		$Asunto='Precios Metales Ingresados, mes'.$MesCorreo.'&nbsp;'.$Ano.'';
		$Titulo='Precios Metales Ingresados';	
		$Mensaje='<font face="Arial" size="2">La Unidad Operaciones Comerciales a Ingresado los Precios de los Metales para el mes <b>'.$MesCorreo.'&nbsp;'.$Ano.'</b>';
		$Mensaje.='<br><br>';
		$Mensaje.='Para su revisi�n y validaci�n de los precios metales ingresado.</font>';
	}
	if($TipoEstado=='VI')//ACA LOS VALORES DE IMPUTACION ESTAN INGRESADOS
	{	//ESTADO 6
		$Asunto='Imputacion Ingresada, para el mes'.$MesCorreo.'&nbsp;'.$Ano.'';
		$Titulo='Proceso Imputaci�n';	
		$Mensaje='<font face="Arial" size="2">La Unidad Operaciones Comerciales a ingresado los Precios de Imputacion para el mes <b>'.$MesCorreo.'&nbsp;'.$Ano.'</b>';
		$Mensaje.='<br><br>';
		$Mensaje.='El Cual se encuentra cerrado.</font>';
	}
	if($TipoEstado=='PIPC')//CARRY COST INGRESADO PANTALLA SCOP_PROCESO_COBERTURA_CARRY_COST_PROCESO
	{		
		$Dato1=explode("~",$Obs);
		while(list($c,$v)=each($Dato1))
		{
			$Consulta="select * from scop_contratos where cod_contrato='".$v."'";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			    $Contratos=$Contratos."N�&nbsp;".$Fila["num_contrato"].",";
		}
		$Contratos=substr($Contratos,0,strlen($Contratos)-1);
		$TipoEst2=substr($TipoEst,0,strlen($TipoEst)-1);
		$Metal=explode("~",$TipoEst2);
		while(list($c,$CodMetal)=each($Metal))
			   $Metales=$Metales."&nbsp;".$CodMetal."&nbsp;y";
		$Metales=substr($Metales,0,strlen($Metales)-1);
		
		$arreglo=array();
		$Datos = explode("~",$TipoEst);
		$x=0;
		foreach($Datos as $clave => $Codigo)
		{
			$arreglo[$x][0]=$Codigo;
			$x=$x+1; 
		}	
		for($i=0;$i<=$x;$i++)
		{
			
			$CarryQP2=explode(",",$CarryQP);
			if('Cu'==$arreglo[$i][0])
			{
				if($CarryQP2[0]=='-1')
					$MesQP=$MesQP.' Cu&nbsp;Mes&nbsp;'.$CarryQP2[0].",";
				if($CarryQP2[0]!='-1')
					$MesQP=$MesQP.' Cu&nbsp;Mes&nbsp;+'.$CarryQP2[0].",";	
				if($CarryQP2[0]=='P')
					$MesQP=$MesQP.' Cu&nbsp;'.$CarryQ2[0].",";	
			}
			if('Ag'==$arreglo[$i][0])
			{
				if($CarryQP2[1]=='-1')
					$MesQP=$MesQP.' Ag&nbsp;Mes&nbsp;'.$CarryQP2[1].",";
				if($CarryQP2[1]!='-1')
					$MesQP=$MesQP.' Ag&nbsp;Mes&nbsp;+'.$CarryQP2[1].",";	
				if($CarryQP2[1]=='P')
					$MesQP=$MesQP.' Ag&nbsp;'.$CarryQP2[1].",";	
			}
			if('Au'==$arreglo[$i][0])
			{
				if($CarryQP2[2]=='-1')
					$MesQP=$MesQP.' Au&nbsp;Mes&nbsp;'.$CarryQP2[2].",";
				if($CarryQP2[2]!='-1')
					$MesQP=$MesQP.' Au&nbsp;Mes&nbsp;+'.$CarryQP2[2].",";	
				if($CarryQP2[2]=='P')
					$MesQP=$MesQP.' Au&nbsp;'.$CarryQP2[2].",";	
			}
		}
		if($MesQP!='')
			$MesQP=substr($MesQP,0,strlen($MesQP)-1);
		if($TipContrato==1)
			$Men=',&nbsp;tipo cobertura&nbsp;<b>Cambio de QP&nbsp;'.$MesQP.'</b>.';
		if($TipContrato==2)
			$Men=',&nbsp;tipo cobertura Precio Fijo con Valor&nbsp;<b>'.$MesQP.'</b>';	
		if($Acuerdo=='-1')
			$MesAcu='Mes&nbsp;';
		else
			$MesAcu='Mes&nbsp;+';	
		$Asunto='Inventario para Cobertura, para el mes'.$MesCorreo.'&nbsp;'.$Ano.'';
		$Titulo='Proceso Inventario para Cobertura';	
		$Mensaje='<font face="Arial" size="2">Estimado:';
		$Mensaje.='<br><br>';
		$Mensaje.='Se han seleccionados los inventarios de los contratos correspondientes para el Mes <b>'.$MesCorreo.'</b>&nbsp;y A�o&nbsp;<b>'.$Ano.'</b>';
		$Mensaje.='<br>';
		$Mensaje.='Con acuerdo contractual&nbsp;<b>'.$MesAcu.$Acuerdo.'</b>'.$Men;
		$Mensaje.='<br>';
		$Mensaje.='Los contratos seleccionados Son: ';
		$Mensaje.='<br>';
		$Mensaje.='<b>'.$Contratos.'</b>.';
		$Mensaje.='<br>';
		$Mensaje.='Para los Metales:&nbsp;'.$Metales.'.';
		$Mensaje.='<br><br></font>';
		$Mensaje.="<table width='100%'  border='1' align='center' cellpadding='3'  cellspacing='0'>";				 

					$arreglo=array();
					$Datos = explode("~",$TipoEst);
					$x=0;
					foreach($Datos as $clave => $Codigo)
					{
						$arreglo[$x][0]=$Codigo;
						$x=$x+1; 
					}	
					for($i=0;$i<=$x;$i++)
					{
						if('Cu'==$arreglo[$i][0])
							$Cu=1;$Colspan=2;	
						if('Ag'==$arreglo[$i][0])
							$Ag=2;$Colspan=$Colspan+2;
						if('Au'==$arreglo[$i][0])
							$Au=3;$Colspan=$Colspan+2;	
					}
				  $Mensaje.="<tr>";
				   $Mensaje.="<td class='TituloTablaVerde' colspan='4' align='center'>Inventario</td>";
				   $Mensaje.="<td class='TituloTablaVerde' colspan='".$Colspan."' align='center'>&nbsp;</td>";
				  $Mensaje.="</tr>";
				    $Mensaje.="<tr class='TituloTablaVerde'>";
					$Mensaje.="<td width='2%'>&nbsp;</td>";
					$Mensaje.="<td colspan='3'>Contratos</td>";

					$arregloContr=array();
					$DatosContr = explode("~",$ContInvo);
					$c=0;
					while (list($clave,$CodigoContr)=each($DatosContr))
					{
						$arregloContr[$c][0]=$CodigoContr;
						$c=$c+1; 
					}	
					
					$arreglo=array();
					$Datos = explode("~",$TipoEst);
					$x=0;
					foreach($Datos as $clave => $Codigo)
					{
						$arreglo[$x][0]=$Codigo;
						$x=$x+1; 
					}	
					if($Acuerdo!='P')
						$TipoAcu='1';
					else
						$TipoAcu='2';						
					for($i=0;$i<=$x;$i++)
					{		
						if('Cu'==$arreglo[$i][0])
						{
							if($Acuerdo!='P')
							{
								$TipoCon.=" and t2.tipo_cu='".$TipoAcu."' ";
								$Dato.=" t2.acuerdo_cu='".$Acuerdo."' or";									
							}
							else
								$TipoCon.=" and t2.tipo_cu='".$TipoAcu."' ";
						}
						if('Ag'==$arreglo[$i][0])
						{
							if($Acuerdo!='P')
							{
								$TipoCon.=" and t2.tipo_ag='".$TipoAcu."' ";
								$Dato.=" t2.acuerdo_ag='".$Acuerdo."' or";
							}
							else
								$TipoCon.=" and t2.tipo_ag='".$TipoAcu."' ";
						}										
						if('Au'==$arreglo[$i][0])
						{
							if($Acuerdo!='P')
							{
								$TipoCon.=" and t2.tipo_au='".$TipoAcu."' ";
								$Dato.=" t2.acuerdo_au='".$Acuerdo."' or";									
							}
							else
								$TipoCon.=" and t2.tipo_au='".$TipoAcu."' ";
						}	
					}
					if($Dato!='')
						$Dato=substr($Dato,0,strlen($Dato)-2);
					if($Acuerdo!='P')
					{
						$Dato=' and ('.$Dato.')';
					}
						$Cobre="[LB]";$Plata="[OZ]";$Oro="[OZ]";
						if($Cu==1)
						{
							$Mensaje.="<td width='5%' align='center'>Cobre [Kg]</td>";
							$Mensaje.=" <td width='5%' align='center'>Cobre ".$Cobre."</td>";
						}
						if($Ag==2)
						{
							 $Mensaje.="<td width='5%' align='center'>PLata [Grs]</td>";
							 $Mensaje.="<td width='5%' align='center'>PLata ".$Plata."</td>";
						}
						if($Au==3)
						{
							 $Mensaje.="<td width='5%' align='center'>Oro [Grs]</td>";
							 $Mensaje.="<td width='5%' align='center'>Oro ".$Oro."</td>";
						}
					$Mensaje.="</tr>";						
							$ArrFinos=array();
							$Consulta="select * from scop_inventario t1 inner join scop_contratos t2 on t1.cod_contrato=t2.cod_contrato where t1.mes='".$Mes."' and t1.cod_estado='2' $TipoCon $Dato";
							$Resp=mysqli_query($link, $Consulta);$Contratos='';
							while ($Fila=mysql_fetch_array($Resp))
							{	
								$Consulta2=" select * from scop_contratos t1 inner join scop_contratos_flujos t2 on t1.cod_contrato=t2.cod_contrato where t2.cod_contrato='".$Fila["cod_contrato"]."' and t2.tipo_inventario='4'";
								$Resp2=mysql_query($Consulta2);$ArrFinos[1][Cu]='';$ArrFinos[2][Ag]='';$ArrFinos[3][Au]='';
								while($Fila2=mysql_fetch_array($Resp2))
								{	
									$TipoInventario=$Fila2[tipo_inventario];
									$TipoFlujo=$Fila2[tipo_flujo];
									$CodFlujo=$Fila2["flujo"];
									$Contrato=$Fila2["cod_contrato"];
									
									$Buscar2='S';
									$ValorPeso=DatosEnabalFlujos($Ano,$Mes,$Contrato,$TipoFlujo,$CodFlujo,&$ArrFinos,'4');
									
								}
								$Contratos=$Contratos.$Fila["cod_contrato"]."~";								
									$Mensaje.="<tr bgcolor='#FFFFFF'>";
									$CheckedCtto="";
									if(!isset($ContInvo))
										$CheckedCtto="checked";	
									for($i=0;$i<=$c;$i++)
									{
										//echo $arregloContr[$i][0];
										if($Fila["cod_contrato"]==$arregloContr[$i][0])
											$CheckedCtto="checked";	
									}
									$DetalleContrato=$Ano."~".$CmbMes."~".$CmbAcuerdo;
									$Mensaje.="<td width='29'>&nbsp;</td>";				
									if($Acuerdo=='P')
									{
										for($i=0;$i<=$x;$i++)
										{
											if('Cu'==$arreglo[$i][0])
												$PF="<span class='formulario'>&nbsp;&nbsp;P.F Cu:  ".$Fila[acuerdo_cu]."&nbsp;cUSD/Lb</span>,";
											if('Ag'==$arreglo[$i][0])
												$PF=$PF."<span class='formulario'>&nbsp;&nbsp;P.F Ag:   ".$Fila[acuerdo_ag]."&nbsp;USD/Oz</span>,";
											if('Au'==$arreglo[$i][0])
												$PF=$PF."<span class='formulario'>&nbsp;&nbsp;P.F Au:  ".$Fila[acuerdo_au]."&nbsp;USD/Oz</span>,";
										}
									}
									if($PF!='')
										$PF=substr($PF,0,strlen($PF)-1);
									$Mensaje.="<td>".$Fila["num_contrato"]."</td>";									
									if($Acuerdo=='P')
									{
										$Mensaje.="<td>".$PF."&nbsp;</td>";
										$Mensaje.="<td width='287'>".$Fila[descrip_contrato]."</td>";
									}
									else
										$Mensaje.="<td width='287' colspan='2'>".$Fila[descrip_contrato]."</td>";
									$Mensaje.="</td>";
									$ValorCobre=0;$ValorPLata=0;$ValorOro=0;
									$arreglo=array();
									$Datos = explode("~",$TipoEst);
									$x=0;
									foreach($Datos as $clave => $Codigo)
									{
										$arreglo[$x][0]=$Codigo;
										$x=$x+1; 
									}	
									for($i=0;$i<=$x;$i++)
									{
										if('Cu'==$arreglo[$i][0])
										{
											if($Acuerdo!='P')
											{
												if($Fila[acuerdo_cu]==$Acuerdo)
												{
													$Mensaje.="<td align='right'>".number_format($ArrFinos[1][Cu],3,',','.')."</td>";	
													$SumaCu=$SumaCu+$ArrFinos[1][Cu];
													$ValorCobreOZ=Convertir($ArrFinos[1][Cu],'Cobre');
													$Mensaje.="<td align='right'>".number_format($ValorCobreOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorCobreOZ,3,',','.').">";				
													$SumaCuOz=$SumaCuOz+$ValorCobreOZ;
												}
												else
												{
													$Mensaje.="<td align='right'>".number_format(0,3,',','.')."</td>";	
													$Mensaje.="<td align='right'>".number_format(0,3,',','.')."";				
												}	
											}
											else
											{
													$Mensaje.="<td align='right'>".number_format($ArrFinos[1][Cu],3,',','.')."</td>";	
													$SumaCu=$SumaCu+$ArrFinos[1][Cu];
													$ValorCobreOZ=Convertir($ArrFinos[1][Cu],'Cobre');
													$Mensaje.="<td align='right'>".number_format($ValorCobreOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorCobreOZ,3,',','.').">";				
													$SumaCuOz=$SumaCuOz+$ValorCobreOZ;
											}
														
										}
										if('Ag'==$arreglo[$i][0])
										{									
											if($Acuerdo!='P')
											{
												if($Fila[acuerdo_ag]==$Acuerdo)
												{
													$Mensaje.="<td align='right'>".number_format($ArrFinos[2][Ag],3,',','.')."</td>";
													$SumaAg=$SumaAg+$ArrFinos[2][Ag];	
													$ValorPlataOZ=Convertir($ArrFinos[2][Ag],'PLata');
													$Mensaje.="<td align='right'>".number_format($ValorPlataOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorPlataOZ,3,',','.').">";				
													$SumaAgOz=$SumaAgOz+$ValorPlataOZ;
												}
												else
												{
													$Mensaje.="<td align='right'>".number_format(0,3,',','.')."</td>";	
													$Mensaje.="<td align='right'>".number_format(0,3,',','.')."";				
												}
											}
											else		
											{
													$Mensaje.="<td align='right'>".number_format($ArrFinos[2][Ag],3,',','.')."</td>";
													$SumaAg=$SumaAg+$ArrFinos[2][Ag];	
													$ValorPlataOZ=Convertir($ArrFinos[2][Ag],'PLata');
													$Mensaje.="<td align='right'>".number_format($ValorPlataOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorPlataOZ,3,',','.').">";				
													$SumaAgOz=$SumaAgOz+$ValorPlataOZ;
											}
										}
										if('Au'==$arreglo[$i][0])
										{
											if($Acuerdo!='P')
											{
												if($Fila[acuerdo_au]==$Acuerdo)
												{
													$Mensaje.="<td align='right'>".number_format($ArrFinos[3][Au],3,',','.')."</td>";	
													$SumaAu=$SumaAu+$ArrFinos[3][Au];	
													$ValorOroOZ=Convertir($ArrFinos[3][Au],'Oro');
													$Mensaje.="<td align='right'>".number_format($ValorOroOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorOroOZ,3,',','.').">";				
													$SumaAuOz=$SumaAuOz+$ValorOroOZ;
												}
												else
												{
													$Mensaje.="<td align='right'>".number_format(0,3,',','.')."</td>";	
													$Mensaje.="<td align='right'>".number_format(0,3,',','.')."";				
												}	
											}	
											else
											{
												$Mensaje.="<td align='right'>".number_format($ArrFinos[3][Au],3,',','.')."</td>";	
												$SumaAu=$SumaAu+$ArrFinos[3][Au];	
												$ValorOroOZ=Convertir($ArrFinos[3][Au],'Oro');
												$Mensaje.="<td align='right'>".number_format($ValorOroOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorOroOZ,3,',','.').">";				
												$SumaAuOz=$SumaAuOz+$ValorOroOZ;
											}	
										}
									}
								  $Mensaje.="</tr>";	
								  $AcuerdoCU=$Fila2[acuerdo_cu];$AcuerdoAG=$Fila2[acuerdo_ag];$AcuerdoAU=$Fila2[acuerdo_au];						  
							}	
							$Mensaje.="<tr>";
								$Mensaje.="<td align='right' colspan='4'>Total</td>";	
								for($i=0;$i<=$x;$i++)
								{
									if('Cu'==$arreglo[$i][0])
									{
											$Mensaje.="<td align='right'>".number_format($SumaCu,3,',','.')."</td>";				
											$Mensaje.="<td align='right'>".number_format($SumaCuOz,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' name='InventarioCu' value=".number_format($ValorCobreOZ,3,',','.')."></td>";				
									}
									if('Ag'==$arreglo[$i][0])
									{
											$Mensaje.="<td align='right'>".number_format($SumaAg,3,',','.')."</td>";		
											$Mensaje.="<td align='right'>".number_format($SumaAgOz,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' name='InventarioAg' value=".number_format($ValorPlataOZ,3,',','.')."></td>";	
									}
									if('Au'==$arreglo[$i][0])
									{
											$Mensaje.="<td align='right'>".number_format($SumaAu,3,',','.')."</td>";				
											$Mensaje.="<td align='right'>".number_format($SumaAuOz,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' name='InventarioAu' value=".number_format($ValorOroOZ,3,',','.')."></td>";	
									}
								}
								$Mensaje.="</tr>";										
		    $Mensaje.="</table>";
	}
	$cuerpoMsj = '<html>';
	$cuerpoMsj.= '<head>';
	$cuerpoMsj.= '<title>'.$Titulo.'&nbsp;'.$MesCorreo.'&nbsp;'.$Ano.'</title>';
	$cuerpoMsj.= '</head>';
	$cuerpoMsj.= '<body>';
	$cuerpoMsj.= '<table  width="100%"  border="0" align="center">';
	$cuerpoMsj.= '<tr><td>';
	$cuerpoMsj.= ''.$Mensaje.'';
	$cuerpoMsj.= "<br><br>";
	$cuerpoMsj.="Por Su Atenci�n Muchas Gracias";
	$cuerpoMsj.= "<br>";
	$cuerpoMsj.="Servicio Automatico de Sistema Cobertura de Precios Ventanas (SCOP)";
	$cuerpoMsj.= "<br>";
	$cuerpoMsj.="scop@codelco.cl";
	$cuerpoMsj.= '</td></tr>';
	$cuerpoMsj.= '</table>';
	$cuerpoMsj.= '</body></html>';
	//echo $cuerpoMsj."<br>";
	$mail = new phpmailer();
	//$mail->AddEmbeddedImage("includes/logo_seti.jpg","logo","includes/logo_seti.jpg","base64","image/jpg");
	$mail->PluginDir = "includes/";
	//$mail->Mailer = "smtp";
	$mail->Host = "VEFVEX03.codelco.cl";
	$mail->From = "SCOP";
	$mail->FromName = "SCOP - Sistemas Cobertura Precios ";
	$mail->Subject = $Asunto;
	$mail->Body=$cuerpoMsj;
	$mail->IsHTML(true);
	$mail->AltBody =str_replace('<br>','\n',$cuerpoMsj);
	$mail->AddAddress($Correo);
	$mail->Timeout=120;
	//$mail->AddAttachment($Doc,$Doc);
	$exito = $mail->Send();
	$intentos=1; 
	while((!$exito)&&($intentos<5)&&($mail->ErrorInfo!="SMTP Error: Data not accepted")){
	sleep(5);
	$exito = $mail->Send();
	$intentos=$intentos+1;				
	}
	$mail->ClearAddresses();
}

function ColorGrilla($Cont)
{
	$Rs=$Cont%2;
	if($Rs==0)
	{
		$Clase=" class='Grilla1' 	style='border-bottom-style:none; 
	border-top:1px;
	border-top-style:solid;
	border-top-color:#EFEFEF;
	border-bottom:2px;
	border-bottom-style:solid;
	border-bottom-color:#EFEFEF;
	border-left:1px;
	border-left-style:solid;
	border-left-color:#D5E0F1;
	border-right:1px;
	border-right-style:solid;
	border-right-color:#D5E0F1;'";
	}
	else
	{
		$Clase=" class='Grilla2' style='border-bottom-style:yes; 
	border-top:1px;
	border-top-style:solid;
	border-top-color:#EFEFEF;
	border-bottom:1px;
	border-bottom-style:solid;
	border-bottom-color:#EFEFEF;
	border-left:1px;
	border-left-style:solid;
	border-left-color:#D5E0F1;
	border-right:1px;
	border-right-style:solid;
	border-right-color:#D5E0F1;' ";
	}
	return($Clase);
}
function DatosEnabalFlujos($AnoFlujo,$MesFlujo,$Contrato,$TipoFlujo,$CodFlujo,$ArrFinos,$i)
{
	$Consulta="select * from scop_contratos_flujos where cod_contrato='".$Contrato."' and  tipo_inventario='".$i."' and flujo='".$CodFlujo."'";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		if($Fila[tipo_inventario]=='1')
		{
			if($MesFlujo==1)
			{
				$AnoFlujo=$AnoFlujo-1;
				$MesFlujo=12;
			}
			else
				$MesFlujo=$MesFlujo-1;
		}
		if($Fila[tipo_inventario]=='1'||$Fila[tipo_inventario]=='4')
			$TipoMovimiento=3;
		else
			$TipoMovimiento=2;		
		$Flujo= $Fila["flujo"];
		$Consulta="select cobre,plata,oro from scop_datos_enabal where ano='".$AnoFlujo."' and cod_flujo='".$Flujo."' and origen='".$TipoFlujo."' and tipo_mov='".$TipoMovimiento."' and tipo_dato='F'";		
		$Consulta.=" and mes='".$MesFlujo."'";
		$RespValor=mysqli_query($link, $Consulta);
		while($FilaValor=mysql_fetch_array($RespValor))
		{
			$Cu=$FilaValor[cobre];
			$Ag=$FilaValor[plata];
			$Au=$FilaValor[oro];
			if($Fila["signo"]==1)
			{
				$ArrFinos[1][Cu]=$ArrFinos[1][Cu]+$Cu;
				$ArrFinos[2][Ag]=$ArrFinos[2][Ag]+$Ag;
				$ArrFinos[3][Au]=$ArrFinos[3][Au]+$Au;
			}
			else
			{
				$ArrFinos[1][Cu]=$ArrFinos[1][Cu]-$Cu;
				$ArrFinos[2][Ag]=$ArrFinos[2][Ag]-$Ag;
				$ArrFinos[3][Au]=$ArrFinos[3][Au]-$Au;
			}
		}			
	}	
}
function Convertir($Valor,$Dato)
{
	switch($Dato)
	{
		case "Cobre"://DE KG A lb
				$ValorSalida=$Valor*2.2;
		break;
		case "PLata"://de grs a OZ
		case "Oro"://de grs a OZ
				$ValorSalida=$Valor*0.032150746568628;
		break;
	}
	return($ValorSalida);
}
?>