<?php
function HrCreaArchivoMedida($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileMedida.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons="select * from interfaces_sap.hr_funcionarios order by bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$ArrValores[$FunFila["bas_nrtcurriculum"]][1]="0000";  //num_infotipo
		$ArrValores[$FunFila["bas_nrtcurriculum"]][2]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //rut       
		//$ArrValores[$FunFila["bas_nrtcurriculum"]][3]= str_replace("-","",$FunFila["emp_fecinggrp"]); //FechaIngreso
		$ArrValores[$FunFila["bas_nrtcurriculum"]][3]= ""; //FechaIngreso
		$ArrValores[$FunFila["bas_nrtcurriculum"]][4]='FV01';   //DivisionPersonal
		if (($FunFila["cae_codrolempl"]=='1') || ($FunFila["cae_codrolempl"]=='2'))
			$Rol='A';
		else
			$Rol='B';
		$ArrValores[$FunFila["bas_nrtcurriculum"]][5]=$Rol;   //TipoRol
		
	}
	CreaArchivo("HrMedida", $NomArchivo, "generados/hr", $ArrValores);
}
function HrCreaArchivoAsignacion($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileAsignacion.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons="select * from interfaces_sap.hr_funcionarios order by bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$ArrValores[$FunFila["bas_nrtcurriculum"]][1]="0001";  //num_infotipo
		$ArrValores[$FunFila["bas_nrtcurriculum"]][2]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //rut       
		$ArrValores[$FunFila["bas_nrtcurriculum"]][3]= ""; //FechaIngreso
		$ArrValores[$FunFila["bas_nrtcurriculum"]][4]='FVEN';   //CentroDeTrabajo  
		if (($FunFila["cae_codrolempl"]=='1') || ($FunFila["cae_codrolempl"]=='2'))
			$Rol='F1';
		else
			$Rol='F2';
		$ArrValores[$FunFila["bas_nrtcurriculum"]][5]=$Rol;   //TipoRol
	}
	CreaArchivo("HrAsignacion", $NomArchivo, "generados/hr", $ArrValores);
}

function HrCreaArchivoDatosFecha($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileDatosFecha.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons="select * from interfaces_sap.hr_funcionarios order by bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$i=1;
		while ($i<13)
		{
			switch ($i)
			{
				case "1":
					$Clase='01';
					$Consulta="select * from hr_fechas where rut ='".$FunFila["bas_nrtcurriculum"]."'  ";
					$Respuesta=mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Respuesta))
					{
						$Fecha=str_replace("/","",$Fila["Antiguedad"]);
					}
					else
					{
						$Fecha='';
					}
					break;
				case "2":
					$Clase='02';
					$Fecha='01052005';
					break;
				case "3":
					$Clase='03';
					$Fecha='01052005';
					break;	
				case "4":
					$Clase='04';
					$Fecha='01052005';
					break;		
				case "5":
					$Clase='05';
					$Fecha='01052005';
					break;
				case "6":
					$Clase='06';
					$Fecha='01052005';
					break;							
				case "7":
					$Clase='07';
					$Fecha='01052005';
					break;
				case "8":
					$Clase='08';
					$Fecha='01052005';
					break;							
				case "9":
					$Clase='09';
					$Fecha='01052005';
					break;
				case "11":
					$Clase='11';
					$Consulta="select * from hr_fechas where rut ='".$FunFila["bas_nrtcurriculum"]."'  ";
					$Respuesta=mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Respuesta))
					{
						$Fecha=str_replace("/","",$Fila["Antiguedad"]);
					}
					else
					{
						$Fecha='';
					}
					break;								
				case "12":
					$Clase='12';
					$Fecha='31122005';
					break;									
			}		
			if ($i <> 10)
			{
				$indice=$FunFila["bas_nrtcurriculum"].'/'.$Clase;
				$ArrValores[$indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //rut       
				$ArrValores[$indice][2]= ""; //FechaIngreso
				$ArrValores[$indice][3]=$Clase;   //CiFecha
				$ArrValores[$indice][4]=$Fecha  ;   //Fecha
			}
			$i=$i+1;
		 }
	}
	CreaArchivo("HrDatosFecha", $NomArchivo, "generados/hr", $ArrValores);
}
function HrCreaArchivoAsociaciones($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileAsociaciones.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons="select * from interfaces_sap.hr_funcionarios order by bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	$i=1;
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$Consulta="select * from hr_sindicatos  where rut ='".$FunFila["bas_nrtcurriculum"]."'";
		$Respuesta=mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$indice=$FunFila["bas_nrtcurriculum"]."0";
			if ($Fila[tipo]=='Socio')
			{
				$Tipo='02RH';
			}
			else
			{
				$Tipo='01RH';
			}
			$ArrValores[$indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
			$ArrValores[$indice][2]= "01052005"; //FechaAfiliacionSindicato
			$ArrValores[$indice][3]=$Fila[cod_sindicato];   //SubTipo
			$ArrValores[$indice][4]=$Tipo;   //CcNomina
			if (!is_null($Fila[asimilado]))
			{
				$indice=$FunFila["bas_nrtcurriculum"]."1";
				$ArrValores[$indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
				$ArrValores[$indice][2]= "01052005"; //FechaAfiliacionSindicato
				$ArrValores[$indice][3]="9FV2";   //SubTipo
				$ArrValores[$indice][4]="03RH";   //CcNomina
			}
		}                                                                    
	}
	CreaArchivo("HrAsociaciones", $NomArchivo, "generados/hr", $ArrValores);
}

function HrCreaArchivoPeriodoVacaciones($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileCabPeriodoVacaciones.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons="select * from interfaces_sap.hr_funcionarios order by bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$ArrValores[$FunFila["bas_nrtcurriculum"]][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
		$ArrValores[$FunFila["bas_nrtcurriculum"]][2]= str_replace("-","",$FunFila["emp_fecinggrp"]); //FechaInicioVacaciones
		$ArrValores[$FunFila["bas_nrtcurriculum"]][3]=str_replace("-","",$FunFila["emp_fecinggrp"]); //FechaTerminoVacaciones
	}
	CreaArchivo("HrPeriodoVacaciones", $NomArchivo, "generados/hr", $ArrValores);
}
function HrCreaArchivoDetalleVacaciones($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileCabDetalleVacaciones.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons="select * from interfaces_sap.hr_funcionarios order by bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$ArrValores[$FunFila["bas_nrtcurriculum"]][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
		$ArrValores[$FunFila["bas_nrtcurriculum"]][2]= ""; //ClaseVacaciones
		$ArrValores[$FunFila["bas_nrtcurriculum"]][3]=""; //Derecho
	}
	CreaArchivo("HrDetalleVacaciones", $NomArchivo, "generados/hr", $ArrValores);
}

function HrCreaArchivoSistSaludCab($NomArchivo)
{        
	if ($NomArchivo=="")
		$NomArchivo="HrFileSistemaSalud.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons="select * from interfaces_sap.hr_funcionarios order by bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	$i=0;
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$Consulta="select * from interfaces_sap.zhk07 where cod_isapre='".$FunFila["emp_codsalud"]."'";
		$Respuesta=mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$CodIsapre=$Fila["ZHK07-ZZISALU"];
		}
		else
		{
			$CodIsapre="";
		}
		$indice="0000".$FunFila["bas_nrtcurriculum"];
		$ArrValores[$indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
		$ArrValores[$indice][2]= ""; //Control
		$ArrValores[$indice][3]="01052005"; //FechaIngreso
		$ArrValores[$indice][4]=$CodIsapre; //InstitucionSalud
		$ArrValores[$indice][5]="01052005"; //FechaNotificacion
		$ArrValores[$indice][6]="04"; //ClaseNotificacion
		$ArrValores[$indice][7]="0"; //Folio
		if (($FunFila["emp_mtosalud"] <> '7') and ($FunFila["emp_codunisalud"] <> '3'))
		{
			$indice="0001".$FunFila["bas_nrtcurriculum"];
			$ArrValores[$indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
			$ArrValores[$indice][2]= ""; //Control
			$ArrValores[$indice][3]=$FunFila["emp_mtosalud"]; //Monto
			switch ($FunFila[emp_codunisalud])
			{
				case "1":
					$UMed='$';
				break;
				case "2":
					$UMed='U.F.';
				break;
				case "3":
					$UMed='%';
				break;
			}	
			$ArrValores[$indice][4]=$UMed; //UM
			$ArrValores[$indice][5]="02"; //TipoCotiz(02:Pactada)
			$ArrValores[$indice][6]=str_replace("-","",$FunFila["emp_fecafilsalud"]); //FechaInicioAporte
			$ArrValores[$indice][7]='31129999'; //FechaFinAporte
			$ArrValores[$indice][8]="04"; //ClaseNotificacion
		}
		if ($FunFila["emp_mtoseguro"] > '0')
		{
			$i++;
			$indice="0002".$FunFila["bas_nrtcurriculum"];
			$ArrValores[$indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
			$ArrValores[$indice][2]= ""; //Control
			$ArrValores[$indice][3]=$FunFila["emp_mtoseguro"]; //Monto
			switch ($FunFila[emp_codunisegro])
			{
				case "1":
					$UMed='';
				break;
				case "2":
					$UMed='U.F.';
				break;
				case "0":
					$UMed='U.F.';
				break;
			}	
			$ArrValores[$indice][4]=$UMed; //UM
			$ArrValores[$indice][5]="01"; //TipoCotiz(01:Adicional)
			$ArrValores[$indice][6]=str_replace("-","",$FunFila["emp_fecafilsalud"]); //FechaInicioAporte
			$ArrValores[$indice][7]='31129999'; //FechaFinAporte
			$ArrValores[$indice][8]="04"; //ClaseNotificacion
		}
	}
	CreaArchivo("HrSistemaSalud", $NomArchivo, "generados/hr", $ArrValores);
}
function HrCreaArchivoSistPrev($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileSistemaPrev.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons="select * from interfaces_sap.hr_funcionarios order by bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$Consulta="select * from interfaces_sap.zhk10 where cod_afp='".$FunFila["emp_codprevision"]."'";
		$Respuesta=mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$CodAfp=$Fila["ZHK10-ZZIPREV"];
		}
		else
		{
			$CodAfp="";
		}
		/**CABECERA**/
		$indice="0000".$FunFila["bas_nrtcurriculum"];
		$ArrValores[$indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
		$ArrValores[$indice][2]= ""; //Control
		$ArrValores[$indice][3]="01052005"; //FechaIngreso
		$ArrValores[$indice][4]=$CodAfp; //InstitucionAfp
		$Rut=substr(str_pad($FunFila["bas_nrtcurriculum"],10,'0',l_pad),0,8);
		//echo "rutt"."  ".$Rut."<br>";
		//$RutC=substr($Rut,0,8);
		//echo "rutt cort"."  ".$RutC."<br>";
		$ArrValores[$indice][5]=str_replace("-","",$FunFila["bas_nrtcurriculum"]); //NroSubscripcion
		$ArrValores[$indice][6]="01052005"; //FechaSubscripcion
		$ArrValores[$indice][7]="906"; //SeguroLey
		$ArrValores[$indice][8]=""; //OrgPrevisional
		$ArrValores[$indice][9]="01052005"; //FechaIngresoSistema
		$ArrValores[$indice][10]=""; //CotizacionDiferida
		$ArrValores[$indice][11]=""; //ExentoCotizacion
		$ArrValores[$indice][12]=""; //NumeroSSS
		/**DETALLE**/
		if ($FunFila["emp_mtoahorro"] > '0')
		{		
			$indice="0001".$FunFila["bas_nrtcurriculum"];
			$ArrValores[$indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
			$ArrValores[$indice][2]= ""; //Control
			$ArrValores[$indice][3]="04"; //TipoCuenta
			$ArrValores[$indice][4]=$FunFila["emp_mtoahorro"]; //Monto
			switch ($FunFila[emp_coduniahorro])
			{
				case "1":
					$UMed='$';
				break;
				case "2":
					$UMed='%';
				break;
				case "3":
					$UMed='U.F.';
				break;
			}	
			$ArrValores[$indice][5]=$UMed; //UnidadMedida
			$ArrValores[$indice][6]="01"; //TipoAporte
			$ArrValores[$indice][7]="01052005"; //FechaInicio
			$ArrValores[$indice][8]="31129999"; //FechaFin
		}
	}
	CreaArchivo("HrSistemaPrevision", $NomArchivo, "generados/hr", $ArrValores);
}
function HrCreaArchivoAntecedentesPago($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileAntecedentesPago.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons = "select * ";
	$FunCons.= " from interfaces_sap.hr_funcionarios t1  ";
	$FunCons.= " order by bas_nrtcurriculum";
	$FunResp=mysqli_query($link, $FunCons);
	$i=1;
	while ($FunFila=mysqli_fetch_array($FunResp))
	{							
		$Indice=$i;
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut      
		$Ruti=$FunFila["bas_nrtcurriculum"]; 
		$ArrValores[$Indice][2]="";//Fecha Ingreso Codelco 01052005
		$ArrValores[$Indice][3]="0";//CLASE DE PAGO (MIENTRAS SOLO "0" que es remuneracion)
		if ($FunFila["emp_numctacte"]!="0" && trim($FunFila["emp_numctacte"])!="") //OSEA DEPOSITO
		{
			$ArrValores[$Indice][4]="CL";//CLAVE PAIS BANCO (CL) (SOLO LOS DEPOSITOS, AHORROS Y CHUEQUE)
			$ArrValores[$Indice][5]=str_replace(".","",str_replace("-","",$FunFila["emp_numctacte"]));//NRO. CUENTA BANCARIA(SOLO LOS DEPOSITOS, AHORROS Y CHUEQUE)
		}
		else
		{
			$ArrValores[$Indice][4]="";//CLAVE PAIS BANCO (CL) (SOLO LOS DEPOSITOS, AHORROS Y CHUEQUE)
			$ArrValores[$Indice][5]="";//NRO. CUENTA BANCARIA(SOLO LOS DEPOSITOS, AHORROS Y CHUEQUE)

		}
		switch ($FunFila["cae_codlugpago"])
		{
			case "0":
				if ($FunFila["cae_codforpago"]=="26")
					$TipoDep="V"; //VALE VISTA
				else
					$TipoDep="D"; //DEPOSITO
				break;
			case "1":
			case "2":
			case "3":
			case "4":
			case "5":
				$TipoDep="E"; //EFECTIVO
				break;
			default:
				if ($FunFila["cae_codforpago"]=="20")
					$TipoDep="Z"; //CUENTA CHILE
				else
					$TipoDep="D"; //DEPOSITO
				break;
		}
		if ($FunFila["cae_codlugpago"]=="0" || $FunFila["cae_codforpago"]=="26" || intval($FunFila["cae_codlugpago"])>5)
		{
			if ($FunFila["cae_codforpago"]=="26")//VALE VISTA
			{
				$CodBanco="001";
			}
			else
			{
				if ($FunFila["cae_codforpago"]=="20")
				{
					$CodBanco="001";
				}
				else
				{
					$Consulta = "select * from interfaces_sap.hr_homologa_banco where cod_banco='".$FunFila["emp_codbanco"]."'";
					$Resp2=mysqli_query($link, $Consulta);
					if ($Fila2=mysqli_fetch_array($Resp2))
					{
						$CodBanco=$Fila2["cod_codelco"];
						IF ($Fila2[cod_banco]=='20')
						{
							$TipoDep='Z';
						}
					}
					else
						$CodBanco="NAN";
				}
			}
			$ArrValores[$Indice][6]=$TipoDep;//MODO DE PAGO (C=CHEQUE, D=DEPOSITO, E=EFECTIVO, V=VALE VISTA, Y=DEPOS. CTA. AHORRO, Z=DEPOS. CTA. VISTA)			
			$ArrValores[$Indice][7]=$CodBanco;//LUGAR DE PAGO, BANCO O VENTANILLA
			$ArrValores[$Indice][8]="514";//SUCURSAL DE PAGO VI�A DEL MAR
		}
		else
		{
			switch ($FunFila["cae_codlugpago"])
			{
				case "1":
					$Lugar='905';
				break;
				case "2":
					$Lugar='906';
				break;
				case "3":
					$Lugar='907';
				break;
				case "4":
					$Lugar='908';
				break;
				case "5":
					$Lugar='909';
				break;
			}	
			$ArrValores[$Indice][7]=$Lugar;//LUGAR DE PAGO, BANCO O VENTANILLA
			$ArrValores[$Indice][8]="";//SUCURSAL DE PAGO
		}
		$ArrValores[$Indice][9]="";//MONTO A DEPOSITAR (SOLO LOS DEPOS. Y AHORRO)
		$ArrValores[$Indice][10]="";//ENVIAR A... DONDE DEBE RETIRAR LA PLANILLA DE SUELDO, (BLANCO, POR QUE ES UN SOLO LADO)
		$ArrValores[$Indice][11]="";//CLAVE MONEDA, CODIGO DE LA MONEDA DEL DEPOSITO O AHORRO()
		$ArrValores[$Indice][12]="";//NOMBRE COBRADOR, PERSONA QUE PUEDE RETIRAR EL DINERO EN CASO DE NO PODER EL FUNC.(BLANCO)
		$ArrValores[$Indice][13]="";//RUT COBRADOR, IDEM ANTERIOR (BLANCO)
		//PARA EL REGISTRO DEL APV
		$Consulta=" select * from hr_apv  where  hr_apv.rut='".$FunFila[bas_nrtcurriculum]."' ";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Resp))
		//if ($FunFila["cod_apv"]!="")
		{
			//$Indice="0001".$FunFila["bas_nrtcurriculum"];
			$i++;
			$Indice=$i;
			$ArrValores[$Indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
			$ArrValores[$Indice][2]="";//Fecha Ingreso Codelco 01052005
			$ArrValores[$Indice][3]="5";//CLASE DE PAGO (MIENTRAS SOLO "0" que es remuneracion)
			$ArrValores[$Indice][4]="";//CLAVE PAIS BANCO (CL) (SOLO LOS DEPOSITOS, AHORROS Y CHUEQUE)
			$ArrValores[$Indice][5]=$Fila[contrato];//NRO. CUENTA BANCARIA(SOLO LOS DEPOSITOS, AHORROS Y CHUEQUE)
			$TipoDep="D"; //DEPOSITO
			$ArrValores[$Indice][6]=$TipoDep;//MODO DE PAGO (C=CHEQUE, D=DEPOSITO, E=EFECTIVO, V=VALE VISTA, Y=DEPOS. CTA. AHORRO, Z=DEPOS. CTA. VISTA)			
			$CodBanco="";
			$ArrValores[$Indice][7]=$Fila[cod_homologa];//LUGAR DE PAGO, BANCO O VENTANILLA
			$ArrValores[$Indice][8]="514";//SUCURSAL DE PAGO
			switch ($Fila["cod_unidad"])
			{
				case "$":
					$Monto=$Fila[monto];
					$Unidad=$Fila["cod_unidad"];
				break;
				case "U.F.":
					$Monto=$Fila[cant_moneda];
					$Unidad=$Fila["cod_unidad"];
				break;
				case "%":
					$Monto=$Fila[cant_moneda];
					$Unidad='% RI';
				break;
			}
			
			$ArrValores[$Indice][9]=$Monto;//MONTO A DEPOSITAR (SOLO LOS DEPOS. Y AHORRO)
			$ArrValores[$Indice][10]="";//ENVIAR A... DONDE DEBE RETIRAR LA PLANILLA DE SUELDO, (BLANCO, POR QUE ES UN SOLO LADO)
			$ArrValores[$Indice][11]="";//CLAVE MONEDA, CODIGO DE LA MONEDA DEL DEPOSITO O AHORRO()
			$ArrValores[$Indice][12]="";//NOMBRE COBRADOR, PERSONA QUE PUEDE RETIRAR EL DINERO EN CASO DE NO PODER EL FUNC.(BLANCO)
			$ArrValores[$Indice][13]="";//RUT COBRADOR, IDEM ANTERIOR (BLANCO)
			$ArrValores[$Indice][14]=$Fila["tipo"];//TIPO DE INSTITUCION 
			$ArrValores[$Indice][15]="S";//DEPOSITO DIRECTO 
			$ArrValores[$Indice][16]=$Unidad;//UNIDAD DE MEDIDA
		}
		$i++;
	}
	CreaArchivo("HrAntecedentes", $NomArchivo, "generados/hr", $ArrValores);
}	
function HrCreaArchivoDatosFamiliares($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileDatosFamiliares.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$Indice=1;
	$FunCons = "select * ";
	$FunCons.= " from hr_cargas_familiares ";
	$FunCons.= " order by rut ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{					
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["rut"]);  //Rut       
		//HOMOLOGA-CLASE-FAMILIA(SI ES CONYUGE)
		$Consulta="select * from t591f  where TEXTO_VENT='".$FunFila["clase_familia"]."' ";
		$Respuesta=mysqli_query($link, $Consulta);
		$CodClase='';
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$CodClase=$Fila["T591F-SUBTY"];
		}
		$ArrValores[$Indice][2]=$CodClase; //ClaseFamilia
		if (is_null($FunFila["rut_familiar"]))
		{	
			$RutFam='111111111';
			$Accion='A';
		}
		else
		{
			$RutFam=str_replace("-","",$FunFila["rut_familiar"]);
			$Accion='C';
		}	
		$ArrValores[$Indice][3]=$RutFam;  //RutFamiliar       
		$ArrValores[$Indice][4]=$Accion;  //Accion
		$ArrValores[$Indice][5]=""; //FechaInicioAccion
		$ArrValores[$Indice][6]="";//FechaTerminoAccion
		$Dia=substr($FunFila["fecha_nacimiento"],8,2);
		$Mes=substr($FunFila["fecha_nacimiento"],5,2);
		$Ano=substr($FunFila["fecha_nacimiento"],0,4);
		$ArrValores[$Indice][7]=$FunFila["apellido"];  //ApellidoPaterno
		$ArrValores[$Indice][8]=$FunFila["2do_Apellido"]; //ApellidoMaterno
		$ArrValores[$Indice][9]=$FunFila["nombres"]; //Nombre
		if ($FunFila["sexo"]=='M')
			$Sexo='1';
			else
				$Sexo='2';
		$ArrValores[$Indice][10]=$Sexo; //EstadoCivilFamiliar
		$ArrValores[$Indice][11]=$Dia.$Mes.$Ano; //FechaNacimiento
		//HOMOLOGA-TIPO-CARGA-FAMILIAR
		$Consulta="select * from zhk13 where `ZHK13-ZZDESCF` ='".$FunFila["carga_fliar"]."' ";
		$Respuesta2=mysqli_query($link, $Consulta);
		$CargaF='';
		if ($Fila2=mysqli_fetch_array($Respuesta2))
		{
			$CargaF=$Fila2["ZHK13-ZZTCF"];
		}
		$ArrValores[$Indice][12]=$CargaF; //CargaFamiliar
		$ArrValores[$Indice][13]=$FunFila["nic_familiar"]; //Titulo
		$ArrValores[$Indice][14]=$FunFila["ind_estudia"]; //ind_estudia
		$ArrValores[$Indice][15]=$FunFila["ind_fliar_vive_trabajador"]; //ind_fliar_vive_trabajador
		$ArrValores[$Indice][16]=$FunFila["direcci�n"]; //direcci�n
		$ArrValores[$Indice][17]=$FunFila["poblacion"]; //Poblacion
		$ArrValores[$Indice][18]=$FunFila["ciudad"]; //Ciudad
		$ArrValores[$Indice][19]=$FunFila["region"]; //Region
		$ArrValores[$Indice][20]=$FunFila["telefono"]; //telefono
		$ArrValores[$Indice][21]='CL'; //Pais
		$ArrValores[$Indice][22]=""; //EstadoCivil
		$Indice++;
	}
	CreaArchivo("HrFamilia", $NomArchivo, "generados/hr", $ArrValores);
}	
function HrCreaArchivoMarcas($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileDatosMarcas.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$Indice=1;
	$FunCons = "select * ";
	$FunCons.= " from hr_marcas_uca t1 inner join hr_tarjetas_fun t2 on t1.rut=t2.rut ";
	$FunCons.= " order by t2.tarjeta, t1.fecha, t1.numreg ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{							
		$NumPersonal="";
		$NumTarjeta=intval($FunFila["tarjeta"]);
		$FechaContab=str_replace("-","",$FunFila["fecha"]);
		$FechaContab=substr($FechaContab,4,4).substr($FechaContab,2,2).substr($FechaContab,0,2);
		switch (strlen($FunFila["hrareg"]))
		{
			case 1:
				$HoraContab=str_pad($FunFila["hrareg"],6,"0",STR_PAD_RIGHT);
				break;
			/*case 2:
				$HoraContab=str_pad($FunFila["hrareg"],4,"0",STR_PAD_RIGHT);
				break;*/
			case 3:
				$HoraContab=str_pad($FunFila["hrareg"],4,"0",STR_PAD_LEFT);
				$HoraContab=str_pad($HoraContab,6,"0",STR_PAD_RIGHT);
				break;
			case 4:
				$HoraContab=str_pad($FunFila["hrareg"],6,"0",STR_PAD_RIGHT);
				break;
		}		
		$FechaReg=$FechaContab;
		$HoraReg=$HoraContab;
		if ($FunFila["numreg"]=="1")
			$TipoMarca="P10";
		else
			$TipoMarca="P20";
		$ArrValores[$Indice][1]=$NumPersonal;  //NumeroPersonal
		$ArrValores[$Indice][2]=$NumTarjeta;  //NumeroIdentificacion
		$ArrValores[$Indice][3]=$FechaContab;  //FechaContabilizacion
		$ArrValores[$Indice][4]=$HoraContab;  //HoraContabilizacion
		$ArrValores[$Indice][5]=$FechaReg;  //FechaRegistro
		$ArrValores[$Indice][6]=$HoraReg;  //HoraRegistro		
		$ArrValores[$Indice][7]=$TipoMarca;  //ClaseHechoTemporal,Indica si es Ingreso o Salida 
		$ArrValores[$Indice][8]="";  //IdTerminal
		$Indice++;
	}
	CreaArchivo("HrMarcas", $NomArchivo, "generados/hr", $ArrValores);
}	
function HrCreaArchivoRelEmpTarj($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileRelEmpTarj.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$Indice=1;
	$FunCons = "select * ";
	$FunCons.= " from hr_tarjetas_fun ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{							
		$ArrValores[$Indice][1]=str_pad(str_replace("-","",$FunFila["rut"]),10,'0',l_pad);  //RUT
		$ArrValores[$Indice][2]='01052005';  //RUT
		$ArrValores[$Indice][3]=intval($FunFila["tarjeta"]);  //RUT
		$Indice++;
	}
	CreaArchivo("HrRelEmpTarj", $NomArchivo, "generados/hr", $ArrValores);
}
//**************Datos Familiares Inicial No Borrar***********// 
/*function HrCreaArchivoDatosFamiliares($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileDatosFamiliares.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$Indice=1;
	$FunCons = "select * ";
	$FunCons.= " from hr_cargas_familiares ";
	$FunCons.= " order by rut ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{					
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["rut"]);  //Rut       
		$ArrValores[$Indice][2]='01052005';//FechaIngresoaDivision 
		//HOMOLOGA-CLASE-FAMILIA(SI ES CONYUGE)
		$Consulta="select * from t591f  where TEXTO_VENT='".$FunFila["clase_familia"]."' ";
		$Respuesta=mysqli_query($link, $Consulta);
		$CodClase='';
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$CodClase=$Fila["T591F-SUBTY"];
		}
		$ArrValores[$Indice][3]=$CodClase; //ClaseFamilia
		$ArrValores[$Indice][4]=$FunFila["apellido "];  //Apellido
		$ArrValores[$Indice][5]=$FunFila["2do_Apellido"]; //2doApellido
		$ArrValores[$Indice][6]=$FunFila["nombres"];//Nombres
		$Dia=substr($FunFila["fecha_nacimiento"],8,2);
		$Mes=substr($FunFila["fecha_nacimiento"],5,2);
		$Ano=substr($FunFila["fecha_nacimiento"],0,4);
		$ArrValores[$Indice][7]=$Dia.$Mes.$Ano;  //FechaNacimiento
		$ArrValores[$Indice][8]=str_replace("-","",$FunFila["rut_familiar"]);  //RutFamiliar       
		$ArrValores[$Indice][9]=$FunFila["nic_familiar"]; //NicFamiliar
		$ArrValores[$Indice][10]=$FunFila["sexo"]; //Sexo
		$ArrValores[$Indice][11]=$FunFila["est_civil_fliar"]; //EstadoCivilFamiliar
		$ArrValores[$Indice][12]=$FunFila["ind_trabajo"]; //Ind_Trabajo
		//HOMOLOGA-NIVEL-EDUCACION
		$Consulta="select * from t517t where TEXTO_VENT ='".$FunFila["nivel_educaci�n"]."' ";
		$Respuesta1=mysqli_query($link, $Consulta);
		if ($Fila1=mysqli_fetch_array($Respuesta1))
		{
			$NivelE=$Fila1["T517T-SLART"];
		}
		else
		{
			$NivelE='99';//SinAntecedentes
		}
		$ArrValores[$Indice][13]=$NivelE; //Nivel Educacion
		//HOMOLOGA-TIPO-CARGA-FAMILIAR
		$Consulta="select * from zhk13 where `ZHK13-ZZDESCF` ='".$FunFila["carga_fliar"]."' ";
		$Respuesta2=mysqli_query($link, $Consulta);
		$CargaF='';
		if ($Fila2=mysqli_fetch_array($Respuesta2))
		{
			$CargaF=$Fila2["ZHK13-ZZTCF"];
		}
		$ArrValores[$Indice][14]=$CargaF; //CargaFamiliar
		//HOMOLOGA-TITULOS
		$Consulta="select * from hr_homologa_titulos where descripcion_ventanas ='".$FunFila["t�tulo"]."' ";
		$Respuesta3=mysqli_query($link, $Consulta);
		if ($Fila3=mysqli_fetch_array($Respuesta3))
		{
			$Titulo=$Fila3["cod_sap"];
			//HOMOLOGA-ESTABLECIMIENTO
			$Consulta="select * from t5j65 where descrip_vent='".$FunFila["establecimiento"]."' ";
			$Respuesta4=mysqli_query($link, $Consulta);
			if ($Fila4=mysqli_fetch_array($Respuesta4))
			{
				$Estable=$Fila4["T5J65-SCHCD"];
			}
			//HOMOLOGA-LUGAR-DE-ESTUDIO(COMUNA)
			$Consulta="select * from zhk20 where `ZHK20-ZZSUCDE` ='".$FunFila["lugar_de_estudio"]."' ";
			$Respuesta5=mysqli_query($link, $Consulta);
			if ($Fila5=mysqli_fetch_array($Respuesta5))
			{
				$Lugar=$Fila5["ZHK20-ZZSUCCO"];
			}
			$Duracion=$FunFila["duracion"];
			$Unidad=$FunFila["unidad"];
		}
		else
		{
			$Titulo='99';//SinAntecedentes
			$Estable='';
			$Lugar='';
			$Duracion='';
			$Unidad='';
		}
		$ArrValores[$Indice][15]=$Titulo; //Titulo
		$ArrValores[$Indice][16]=""; //Especilidad
		$ArrValores[$Indice][17]=$Estable; //Establecimiento
		$ArrValores[$Indice][18]=$Lugar; //LugardeEstudio  
		$ArrValores[$Indice][19]=$Duracion; //duracion
		$ArrValores[$Indice][20]=$Unidad; //Unidad
		$ArrValores[$Indice][21]=$FunFila["ind_estudia"]; //ind_estudia
		$ArrValores[$Indice][22]=$FunFila["ind_fliar_vive_trabajador"]; //ind_fliar_vive_trabajador
		$ArrValores[$Indice][23]=$FunFila["direcci�n"]; //direcci�n
		$ArrValores[$Indice][24]=$FunFila["prefijo_telefono"]; //prefijo_telefono
		$ArrValores[$Indice][25]=$FunFila["telefono"]; //telefono
		$ArrValores[$Indice][26]=$FunFila["poblacion"]; //Poblacion
		$ArrValores[$Indice][27]=$FunFila["ciudad"]; //Ciudad
		$ArrValores[$Indice][28]=$FunFila["region"]; //Region
		$ArrValores[$Indice][29]='CL'; //Pais
		$Indice++;
	}
	CreaArchivo("HrFamilia", $NomArchivo, "generados/hr", $ArrValores);
}	
//**************Inicial No Borrar***********/

?>