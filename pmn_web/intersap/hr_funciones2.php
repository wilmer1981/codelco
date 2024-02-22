<?php
function HrCreaArchivoDatosPer($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileDatosPer.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons="select * from interfaces_sap.hr_funcionarios order by bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		//INFOTIPO 0 ***MEDIDAS***
		$Indice=$FunFila["bas_nrtcurriculum"]."0000";
		$ArrValores[$Indice][1]="0000";  //num_infotipo
		$ArrValores[$Indice][2]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //rut       
		$ArrValores[$Indice][3]= ""; //FechaIngreso
		$ArrValores[$Indice][4]='FV01';   //DivisionPersonal
		if (($FunFila["cae_codrolempl"]=='1') || ($FunFila["cae_codrolempl"]=='2'))
			$Rol='A';
		else
			$Rol='B';
		$ArrValores[$Indice][5]=$Rol;   //TipoRol
		
		//INFOTIPO 1 ***ASIGNACIONES***
		$Indice=$FunFila["bas_nrtcurriculum"]."0001";
		$ArrValores[$Indice][1]="0001";  //num_infotipo
		$ArrValores[$Indice][2]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //rut       
		$ArrValores[$Indice][3]= ""; //FechaIngreso
		$ArrValores[$Indice][4]='FVEN';   //CentroDeTrabajo  
		if (($FunFila["cae_codrolempl"]=='1') || ($FunFila["cae_codrolempl"]=='2'))
			$Rol='F1';
		else
			$Rol='F2';
		$ArrValores[$Indice][5]=$Rol;   //TipoRol
		//INFOTIPO 2 ***DATOS PERSONALES***
		$Indice=$FunFila["bas_nrtcurriculum"]."0002";
		$ArrValores[$Indice][1]="0002";  //infotipo
		$ArrValores[$Indice][2]=str_replace("-","",$FunFila["bas_nrtcurriculum"]); //rut       
		$ArrValores[$Indice][3]=""; //fecha_ingreso 
		$ArrValores[$Indice][4]=$FunFila["bas_apepaterno"];   //ape_paterno
		$ArrValores[$Indice][5]=$FunFila["bas_apematerno"];   //ape_materno
		$ArrValores[$Indice][6]=$FunFila["bas_nombres"];//nombre
		$ArrValores[$Indice][7]="";  //nic
		$ArrValores[$Indice][8]=str_replace("-","",$FunFila["bas_fecnacimient"]); //fecha_nac
		$Sexo = $FunFila["bas_flgsexo"];		
		HomologaSexo(&$Sexo);
		$ArrValores[$Indice][9]=$Sexo; //sexo
		$ArrValores[$Indice][10]="";   //nacionalidad
		$EstCivil=$FunFila["bas_codestcivil"];
		HomologaEstCivil(&$EstCivil);
		$ArrValores[$Indice][11]=$EstCivil;   //estado_civil
		if (str_replace("-","",$FunFila["bas_fecmatrimon"])=="01011900")
			$ArrValores[$Indice][12]="";//fecha_matrim
		else
			$ArrValores[$Indice][12]=str_replace("-","",$FunFila["bas_fecmatrimon"]);//fecha_matrim
		$ArrValores[$Indice][13]="0";   //num_hijos
		$EstCivilEmp=$FunFila["bas_codestcivil"];
		HomologaEstCivilEmp(&$EstCivilEmp);
		$ArrValores[$Indice][14]=$EstCivilEmp;//est_civil_emp
	}
	CreaArchivo("HrDatosPersonales", &$NomArchivo, "generados/hr", $ArrValores);
}

function HrCreaArchivoEmuBasic($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileEmolBasicos.txt";
	//CABECERA
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons = "select * from interfaces_sap.hr_funcionarios  ";
	//$FunCons.= " where cae_codrolempl in(1,2) ";
	$FunCons.= "order by cae_codrolempl, bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$Indice="0000".$FunFila["bas_nrtcurriculum"];
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]); //rut       
		$ArrValores[$Indice][2]=""; //fecha_ingreso 
		$ArrValores[$Indice][3]=$FunFila["num_anticipo"]; //CANTIDAD DE ANTICIPOS
		$ArrValores[$Indice][4]="";   //area_geografica ('09')
		if ($FunFila["cae_codempresa"]==96)// || $FunFila["cae_codrolempl"]==2)
			$Rol="A";
		else
			$Rol="B";
		$Nivel=$FunFila["cae_codgrado"];
		switch ($Rol)
		{
			case "A":
				$Nivel=78+intval($Nivel);
				break;
			default:
				$Nivel=$Nivel;
				break;
		}
		//HomologaNivel($FunFila["cae_codrolempl"],&$Nivel);
		$ArrValores[$Indice][5]=str_pad($Nivel,2,'0',STR_PAD_LEFT);   //nivel
		$ArrValores[$Indice][6]="";//subgrupo (no hay)		
		//DETALLE
		//RESCATA DATOS
		$FunCons = "select distinct t1.rut, t1.base, t1.cod_haber, t1.cod_haber_sap, t1.monto_haber, t1.rol ";
		$FunCons.= " from interfaces_sap.hr_emolumentos t1 ";
		$FunCons.= " inner join interfaces_sap.hr_homologa_emolumentos t2 on t1.cod_haber_sap=t2.clave_codelco ";
		$FunCons.= " where t1.rut='".$FunFila["bas_nrtcurriculum"]."' ";
		//$FunCons.= " and rol='".$Rol."' ";
		$FunCons.= " and t2.ocupar='1' ";
		$FunCons.= " order by rut, cod_haber_sap";
		$FunResp2=mysqli_query($link, $FunCons);
		$i=0;
		while ($FunFila2=mysqli_fetch_array($FunResp2))
		{	
			if ($i==0)
			{
				$Indice="0001".$FunFila2["rut"].str_pad($i,4,'0',STR_PAD_LEFT);
				$ArrValores[$Indice][1]=str_replace("-","",$FunFila2["rut"]); //rut 
				if ($FunFila2["rol"]=="A")      
					$ArrValores[$Indice][2]="HS01"; //cc-nomina
				if ($FunFila2["rol"]=="B")      
					$ArrValores[$Indice][2]="HS02"; //cc-nomina
				$ArrValores[$Indice][3]=$FunFila2["base"];   //valor
			}
			else
			{
				$Indice="0001".$FunFila2["rut"].str_pad($i,4,'0',STR_PAD_LEFT);
				$ArrValores[$Indice][1]=str_replace("-","",$FunFila2["rut"]); //rut       
				$ArrValores[$Indice][2]=trim($FunFila2["cod_haber_sap"]); //cc-nomina
				$ArrValores[$Indice][3]=$FunFila2["monto_haber"];   //valor
			}
			$i++;
		}
		//EMOLUMENTOS FALTANTES				
		if ($Rol=="B")				
		{
			$FunCons = "select distinct rut, clave as clave_codelco, cantidad as monto_haber, unidad ";
			$FunCons.= " from interfaces_sap.hr_emol_faltantes t1 ";
			$FunCons.= " where rut='".$FunFila["bas_nrtcurriculum"]."'";
			$FunCons.= " and clave in('HT12') ";
			$FunResp2=mysqli_query($link, $FunCons);
			while ($FunFila2=mysqli_fetch_array($FunResp2))
			{	
				$Indice="0001".$FunFila2["rut"].str_pad($i,4,'0',STR_PAD_LEFT);
				$ArrValores[$Indice][1]=str_replace("-","",$FunFila2["rut"]); //rut       
				$ArrValores[$Indice][2]=trim($FunFila2["clave_codelco"]); //cc-nomina
				$ArrValores[$Indice][3]=$FunFila2["monto_haber"];   //valor
				$i++;
			}		
			// EMOL. HH33
			$Indice="0001".$FunFila["bas_nrtcurriculum"].str_pad($i,4,'0',STR_PAD_LEFT);
			$ArrValores[$Indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]); //rut       
			$ArrValores[$Indice][2]="HH33"; //cc-nomina
			$ArrValores[$Indice][3]="";   //valor
			$i++;
		}
	}	
	CreaArchivo("HrEmolBasicos01", &$NomArchivo, "generados/hr", $ArrValores);
}

/*function HrCreaArchivoEmuBasicDet($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileEmolBasicos02.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons = "select rut, cod_haber, glosa_haber, glosa, clave_codelco, monto_haber ";
 	$FunCons.= " from interfaces_sap.hr_emolumentos t1 ";
	$FunCons.= " left join interfaces_sap.hr_haberes t2 on t1.cod_haber=t2.codigo ";
	$FunCons.= " order by rut, clave_codelco";
	$FunResp=mysqli_query($link, $FunCons);
	$i=0;
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$Indice=$FunFila["rut"].str_pad($i,4,'0',STR_PAD_LEFT);
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["rut"]); //rut       
		$ArrValores[$Indice][2]=trim($FunFila["clave_codelco"]); //cc-nomina
		$ArrValores[$Indice][3]=$FunFila["monto_haber"];   //valor
		$i++;
	}
	CreaArchivo("HrEmolBasicos02", &$NomArchivo, "generados/hr", $ArrValores);
}*/
function HrCreaArchivoTiemposRec($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileTiemposReconocidos.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons = "select * ";
 	$FunCons.= " from interfaces_sap.hr_fechas ";
	$FunCons.= " order by rut ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		//CALCULA ANTIGUEDAD
		/*$Fecha1=substr($FunFila["Antiguedad"],6,4)."-".substr($FunFila["Antiguedad"],3,2)."-".substr($FunFila["Antiguedad"],0,2);
		$Fecha2="2005-05-01";
		$AnoAnt=0;$MesAnt=0;$DiaAnt=0;
		//echo "F1=".$Fecha1." / F2=".$Fecha2."<br>";
		$AnoAnt=datediff("y",$Fecha1,$Fecha2);
		$Fecha1 = date("Y-m-d", mktime(0,0,0,substr($Fecha1,5,2),substr($Fecha1,8,2),substr($Fecha1,0,4)+$AnoAnt));
		//echo "F1=".$Fecha1." / F2=".$Fecha2."<br>";
		$MesAnt=datediff("m",$Fecha1,$Fecha2);
		$Fecha1 = date("Y-m-d", mktime(0,0,0,substr($Fecha1,5,2)+$MesAnt,substr($Fecha1,8,2),substr($Fecha1,0,4)));
		//echo "F1=".$Fecha1." / F2=".$Fecha2."<br>";
		$DiaAnt=datediff("d",$Fecha1,$Fecha2);
		//echo " -> Ano=$Ano, Mes=$Mes, Dia=$Dia<br>";
		//CALCULA INDEMNIZACION
		$Fecha1=substr($FunFila["Indemnizacion"],6,4)."-".substr($FunFila["Indemnizacion"],3,2)."-".substr($FunFila["Indemnizacion"],0,2);
		$Fecha2="2005-05-01";
		$AnoIndem=0;$MesIndem=0;$DiaIndem=0;
		//echo "F1=".$Fecha1." / F2=".$Fecha2."<br>";
		$AnoIndem=datediff("y",$Fecha1,$Fecha2);
		$Fecha1 = date("Y-m-d", mktime(0,0,0,substr($Fecha1,5,2),substr($Fecha1,8,2),substr($Fecha1,0,4)+$AnoIndem));
		//echo "F1=".$Fecha1." / F2=".$Fecha2."<br>";
		$MesIndem=datediff("m",$Fecha1,$Fecha2);
		$Fecha1 = date("Y-m-d", mktime(0,0,0,substr($Fecha1,5,2)+$MesIndem,substr($Fecha1,8,2),substr($Fecha1,0,4)));
		//echo "F1=".$Fecha1." / F2=".$Fecha2."<br>";
		$DiaIndem=datediff("d",$Fecha1,$Fecha2);
		//echo " -> Ano=$Ano, Mes=$Mes, Dia=$Dia<br>";*/
		$Indice=$FunFila["RUT"];
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["RUT"]); //rut       
		$ArrValores[$Indice][2]=""; //fecha ingreso codelco
		$ArrValores[$Indice][3]=trim(str_replace("/","",$FunFila["Antiguedad"]));//Fecha Antiguedad
		$ArrValores[$Indice][4]=trim(str_replace("/","",$FunFila["Indemnizacion"]));//Fecha Indemnizacion      
	}
	CreaArchivo("HrTiemposRec", &$NomArchivo, "generados/hr", $ArrValores);
}
function HrSinAnticipo()
{
	$Actualizar = "UPDATE interfaces_sap.hr_funcionarios set ";
	$Actualizar.= " num_anticipo='1'";
	mysqli_query($link, $Actualizar);
	$Consulta = "select * from interfaces_sap.hr_fun_sin_anticipo order by rut ";
	$FunResp=mysqli_query($link, $Consulta);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{
		$Actualizar = "UPDATE interfaces_sap.hr_funcionarios set ";
		$Actualizar.= " num_anticipo='0'";
		$Actualizar.= " where bas_nrtcurriculum='".$FunFila["rut"]."'";
		mysqli_query($link, $Actualizar);
		//echo $Actualizar;
	}
}

function HrCreaArchivoHorarioTrabTeorico($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileHorarioTrabTeorico.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons = "select * from interfaces_sap.hr_funcionarios ";
	$FunCons.= "order by bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$ArrValores[$FunFila["bas_nrtcurriculum"]][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]); //rut       
		$ArrValores[$FunFila["bas_nrtcurriculum"]][2]=""; //fecha_ingreso
		$ArrValores[$FunFila["bas_nrtcurriculum"]][3]=""; //tipo_faena
		$ArrValores[$FunFila["bas_nrtcurriculum"]][4]=""; //regla_horario
		$Rol=$FunFila["cae_codrolempl"];
		HomologaRol(&$Rol);
		switch ($Rol)
		{
			case "F1":
				$Rol="9";
				break;
			case "F2":
				$Rol="1";
				break;
		}
		$ArrValores[$FunFila["bas_nrtcurriculum"]][5]=$Rol;   //status_gestion
	}
	CreaArchivo("HrHorarioTrabTeorico", &$NomArchivo, "generados/hr", $ArrValores);
}
function HrCreaArchivoDirecciones($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileDirecciones.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons = "select t1.bas_nrtcurriculum, t2.poblacion, t2.calle, t2.numero, t2.ciudad, t2.comuna, t2.region, t2.telefono";
	$FunCons.=" from interfaces_sap.hr_funcionarios t1 inner join interfaces_sap.hr_direcciones t2";
	$FunCons.=" on t1.bas_nrtcurriculum=t2.rut order by bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		switch (strtoupper($FunFila["region"]))
		{
			case "V":
				$Region="05";				
				break;
			case "RM":
				$Region="RM";				
				break;
		}
		$Indice=$FunFila["bas_nrtcurriculum"];
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
		$ArrValores[$Indice][2]=""; //FechaIngresoCodelco
		$ArrValores[$Indice][3]=$FunFila["poblacion"]; //Poblacion		
		$ArrValores[$Indice][4]=$FunFila["calle"]; //CalleDireccion
		$ArrValores[$Indice][5]=$FunFila["numero"]; //NumeroDireccion
		$ArrValores[$Indice][6]=$FunFila["ciudad"]; //Ciudad
		$ArrValores[$Indice][7]=$FunFila["comuna"]; //Distrito (COMUNA)
		$ArrValores[$Indice][8]=$Region; //Region
		if (trim($FunFila["telefono"])=="S/T")
			$ArrValores[$Indice][9]=""; //NumeroFono
		else
			$ArrValores[$Indice][9]=$FunFila["telefono"]; //NumeroFono
	}
	CreaArchivo("HrDirecciones", $NomArchivo, "generados/hr", $ArrValores);
}

function HrCreaArchivoVacaciones($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileVacaciones.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons = "select t1.bas_nrtcurriculum as rut, t2.cod_jornada, t3.fecha_vac, t3.periodo, ";
	$FunCons.= " sum(t3.dias_base) as dias_base, sum(t3.dias_prog) as dias_prog, ";
	$FunCons.= " sum(t3.base_tom) as base_tom, sum(t3.prog_tom) as tom_prog, sum(t3.saldo) as saldo, ";
	$FunCons.= " (sum(round(REPLACE(t3.dias_base,',','.')))-sum(round(REPLACE(t3.base_tom,',','.')))) as saldo_nor, ";
	$FunCons.= " (sum(round(REPLACE(t3.dias_prog,',','.')))-sum(round(REPLACE(t3.prog_tom,',','.')))) as saldo_prog ";
	$FunCons.= " from interfaces_sap.hr_funcionarios t1 inner join interfaces_sap.hr_jornadas t2 on ";
	$FunCons.= " t1.bas_nrtcurriculum=t2.rut inner join interfaces_sap.hr_vacaciones t3 on t1.bas_nrtcurriculum=t3.rut   ";
	$FunCons.= " group by t1.bas_nrtcurriculum";
	$FunCons.= " order by t1.bas_nrtcurriculum";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{					
		$FechaIni=$FunFila["fecha_vac"];
		$FechaFin=date("d/m/Y",mktime(0,0,0,substr($FechaIni,3,2),(substr($FechaIni,0,2)-1),2006));
		$FechaIni="01/05/2005";
		//echo $FunFila["rut"]." FECHA VAC=".$FunFila["fecha_vac"]." FI=".$FechaIni." FF=".$FechaFin."<br>";
		switch ($FunFila["cod_jornada"])
		{
			case "0":
				$ClaseVacNor="V1";
				$ClaseVacAdic="V3";
				break;
			default:
				$ClaseVacNor="V2";
				$ClaseVacAdic="V4";
				break;
		}
		//$DiasNor=intval($FunFila["dias_base"])-intval($FunFila["base_tom"]);
		//$DiasAdic=$FunFila["dias_prog"]-$FunFila["prog_tom"];
		$DiasNor=intval($FunFila["saldo_nor"]);
		$DiasAdic=intval($FunFila["saldo_prog"]);
		$Saldo=($DiasNor+$DiasAdic);
		/*if ($Saldo!=$FunFila["saldo"])
		{
			echo "RUT=".$FunFila["rut"]." F_VAC=".$FunFila["fecha_vac"]." FI=".$FechaIni." FF=".$FechaFin."<br>";		
			echo "CLASE_NOR=".$ClaseVacNor." DIAS=".$DiasNor." CLASE_ADIC=".$ClaseVacAdic." DIAS=".$DiasAdic." SALDO_CALC=".$Saldo." SALDO_BD=".$FunFila["saldo"]."<br>";
		}*/
		//CABECERA
		$Indice="0000".$FunFila["rut"];
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["rut"]);  //Rut       
		$ArrValores[$Indice][2]=str_replace("/","",$FechaIni); //Fecha Ini Periodo (01/05)
		$ArrValores[$Indice][3]=str_replace("/","",$FechaFin); //Fecha Fin Periodo (FECHA REAL)
		//DETALLE (TODAS LAS PENDIENTES) SALDOS
		//.-NORMALES
		$Indice="0001".$FunFila["rut"];
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["rut"]);  //Rut 
		$ArrValores[$Indice][2]=$ClaseVacNor; //Clase Vacaciones (SEPARAR EN BASE Y PROG.)
		$ArrValores[$Indice][3]=$DiasNor; //Derecho(Cant. Dias)
		//.-ADICIONALES
		$Indice="0002".$FunFila["rut"];
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["rut"]);  //Rut 
		$ArrValores[$Indice][2]=$ClaseVacAdic; //Clase Vacaciones (SEPARAR EN BASE Y PROG.)
		$ArrValores[$Indice][3]=$DiasAdic; //Derecho(Cant. Dias)
		
	}
	CreaArchivo("HrCabVacaciones", $NomArchivo, "generados/hr", $ArrValores);
}	


function HrCreaArchivoAntecedentesPago($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileAntecedentesPago.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons = "select * ";
	$FunCons.= " from interfaces_sap.hr_funcionarios t1 left join hr_apv t2 on t1.bas_nrtcurriculum=t2.rut ";
	$FunCons.= " order by bas_nrtcurriculum";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{							
		$Indice="0000".$FunFila["bas_nrtcurriculum"];
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
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
					$TipoDep="Z"; //DEPOSITO A CTA. VISTA
				else
					$TipoDep="D"; //DEPOSITO
				break;
		}
		$ArrValores[$Indice][6]=$TipoDep;//MODO DE PAGO (C=CHEQUE, D=DEPOSITO, E=EFECTIVO, V=VALE VISTA, Y=DEPOS. CTA. AHORRO, Z=DEPOS. CTA. VISTA)			
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
						$CodBanco=$Fila2["cod_codelco"];
					else
						$CodBanco="NAN";
				}
			}
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
		if ($FunFila["cod_apv"]!="")
		{
			$Indice="0001".$FunFila["bas_nrtcurriculum"];
			$ArrValores[$Indice][1]=str_replace("-","",$FunFila["bas_nrtcurriculum"]);  //Rut       
			$ArrValores[$Indice][2]="";//Fecha Ingreso Codelco 01052005
			$ArrValores[$Indice][3]="5";//CLASE DE PAGO (MIENTRAS SOLO "0" que es remuneracion)
			$ArrValores[$Indice][4]="";//CLAVE PAIS BANCO (CL) (SOLO LOS DEPOSITOS, AHORROS Y CHUEQUE)
			$ArrValores[$Indice][5]=$FunFila[contrato];//NRO. CUENTA BANCARIA(SOLO LOS DEPOSITOS, AHORROS Y CHUEQUE)
			$TipoDep="D"; //DEPOSITO
			$ArrValores[$Indice][6]=$TipoDep;//MODO DE PAGO (C=CHEQUE, D=DEPOSITO, E=EFECTIVO, V=VALE VISTA, Y=DEPOS. CTA. AHORRO, Z=DEPOS. CTA. VISTA)			
			$CodBanco="";
			$ArrValores[$Indice][7]=$FunFila[cod_homologa];//LUGAR DE PAGO, BANCO O VENTANILLA
			$ArrValores[$Indice][8]="514";//SUCURSAL DE PAGO
			switch ($FunFila["cod_unidad"])
			{
				case "$":
					$Monto=$FunFila[monto];
				break;
				case "U.F.":
					$Monto=$FunFila[cant_moneda];
				break;
				case "%":
					$Monto=$FunFila[cant_moneda];
				break;
			}
			
			$ArrValores[$Indice][9]=$Monto;//MONTO A DEPOSITAR (SOLO LOS DEPOS. Y AHORRO)
			$ArrValores[$Indice][10]="";//ENVIAR A... DONDE DEBE RETIRAR LA PLANILLA DE SUELDO, (BLANCO, POR QUE ES UN SOLO LADO)
			$ArrValores[$Indice][11]="";//CLAVE MONEDA, CODIGO DE LA MONEDA DEL DEPOSITO O AHORRO()
			$ArrValores[$Indice][12]="";//NOMBRE COBRADOR, PERSONA QUE PUEDE RETIRAR EL DINERO EN CASO DE NO PODER EL FUNC.(BLANCO)
			$ArrValores[$Indice][13]="";//RUT COBRADOR, IDEM ANTERIOR (BLANCO)
			$ArrValores[$Indice][14]=$FunFila["tipo"];//TIPO DE INSTITUCION 
			$ArrValores[$Indice][15]="S";//DEPOSITO DIRECTO 
			$ArrValores[$Indice][16]=$FunFila["cod_unidad"];//UNIDAD DE MEDIDA
		}
		
	}
	CreaArchivo("HrAntecedentes", $NomArchivo, "generados/hr", $ArrValores);
}	

function HrCreaArchivoDatosFamiliares($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileDatosFamiliares.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons = "select * ";
	$FunCons.= " from interfaces_sap.hr_funcionarios t1 inner join interfaces_sap.hr_jornadas t2 on ";
	$FunCons.= " t1.bas_nrtcurriculum=t2.rut inner join interfaces_sap.hr_vacaciones t3 on t1.bas_nrtcurriculum=t3.rut   ";
	$FunCons.= " group by t1.bas_nrtcurriculum";
	$FunCons.= " order by t1.bas_nrtcurriculum";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{					
		$FechaIni=$FunFila["fecha_vac"];
		$FechaFin=date("d/m/Y",mktime(0,0,0,substr($FechaIni,3,2),(substr($FechaIni,0,2)-1),2006));
		$FechaIni="01/05/2005";		
		$DiasNor=intval($FunFila["saldo_nor"]);
		$DiasAdic=intval($FunFila["saldo_prog"]);
		$Saldo=($DiasNor+$DiasAdic);
		$Indice="0000".$FunFila["rut"];
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["rut"]);  //Rut       
		$ArrValores[$Indice][2]=str_replace("/","",$FechaIni); //Fecha Ini Periodo (01/05)
		$ArrValores[$Indice][3]=str_replace("/","",$FechaFin); //Fecha Fin Periodo (FECHA REAL)
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["rut"]);  //Rut 
		$ArrValores[$Indice][2]=$ClaseVacNor; //Clase Vacaciones (SEPARAR EN BASE Y PROG.)
		$ArrValores[$Indice][3]=$DiasNor; //Derecho(Cant. Dias)
		$ArrValores[$Indice][1]=str_replace("-","",$FunFila["rut"]);  //Rut 
		$ArrValores[$Indice][2]=$ClaseVacAdic; //Clase Vacaciones (SEPARAR EN BASE Y PROG.)
		$ArrValores[$Indice][3]=$DiasAdic; //Derecho(Cant. Dias)
	}
	CreaArchivo("HrCabVacaciones", $NomArchivo, "generados/hr", $ArrValores);
}	

function HrCreaArchivoEmolAdic($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="HrFileEmolAdicionales.txt";	
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons = "select * from interfaces_sap.hr_funcionarios  ";
	//$FunCons.= " where cae_codrolempl in(1,2) ";
	$FunCons.= "order by cae_codrolempl, bas_nrtcurriculum ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{			
		if ($FunFila["cae_codrolempl"]==1 || $FunFila["cae_codrolempl"]==2)
			$Rol="A";
		else
			$Rol="B";
		$Nivel=$FunFila["cae_codgrado"];
		HomologaNivel($FunFila["cae_codrolempl"],&$Nivel);
		//RESCATA DATOS
		$FunCons = "select rut, cod_haber, glosa_haber, glosa, clave_codelco, monto_haber, t2.unidad ";
		$FunCons.= " from interfaces_sap.hr_emolumentos t1 ";
		$FunCons.= " inner join interfaces_sap.hr_homologa_emolumentos t2 on t1.cod_haber=t2.codigo ";
		$FunCons.= " where rut='".$FunFila["bas_nrtcurriculum"]."'";
		$FunCons.= " and rol='".$Rol."' ";
		$FunCons.= " and ocupar='2' ";
		$FunCons.= " order by rut, clave_codelco";
		$FunResp2=mysqli_query($link, $FunCons);
		$i=1;
		while ($FunFila2=mysqli_fetch_array($FunResp2))
		{	
			$Indice="0001".$FunFila2["rut"].str_pad($i,4,'0',STR_PAD_LEFT);
			$ArrValores[$Indice][1]=str_replace("-","",$FunFila2["rut"]); //rut  
			$ArrValores[$Indice][2]=""; //fecha_ingreso      
			$ArrValores[$Indice][3]=trim($FunFila2["clave_codelco"]); //cc-nomina
			$ArrValores[$Indice][4]=$FunFila2["monto_haber"];   //cantidad
			$ArrValores[$Indice][5]=$FunFila2["unidad"];   //unidad
			$ArrValores[$Indice][6]="";   //importe
			$ArrValores[$Indice][7]="";   //moneda
			$i++;
		}
		//EMOLUMENTOS FALTANTES
		$FunCons = "select distinct rut, clave as clave_codelco, cantidad as monto_haber, unidad ";
		$FunCons.= " from interfaces_sap.hr_emol_faltantes t1 ";
		$FunCons.= " where rut='".$FunFila["bas_nrtcurriculum"]."'";
		if ($Rol=="A")
			$FunCons.= " and clave in('HH32') ";
		else
			$FunCons.= " and clave in('HT11','HJ10') ";
		$FunResp2=mysqli_query($link, $FunCons);
		$i=1;
		while ($FunFila2=mysqli_fetch_array($FunResp2))
		{	
			$Indice="0001".$FunFila2["rut"].str_pad($i,4,'0',STR_PAD_LEFT);
			$ArrValores[$Indice][1]=str_replace("-","",$FunFila2["rut"]); //rut  
			$ArrValores[$Indice][2]=""; //fecha_ingreso      
			$ArrValores[$Indice][3]=trim($FunFila2["clave_codelco"]); //cc-nomina
			$ArrValores[$Indice][4]=$FunFila2["monto_haber"];   //cantidad
			$ArrValores[$Indice][5]=$FunFila2["unidad"];   //unidad
			$ArrValores[$Indice][6]="";   //importe
			$ArrValores[$Indice][7]="";   //moneda
			$i++;
		}
	}	
	CreaArchivo("HrEmolAdic", &$NomArchivo, "generados/hr", $ArrValores);
}

function HrCreaArchivoHistCapacitacion($NomArchivo)
{
	//BD RRHH
	//mysql_close($link);
	$link_48 = mysql_connect("192.168.52.48","adm_bd","672312");
	mysql_select_db("interfaces_sap", $link_48);
	$link = mysql_connect("192.168.52.50","user_conect","perfil7");
	mysql_select_db("bd_rrhh", $link);
	//------
	if ($NomArchivo=="")
		$NomArchivo="HrFileHistCapacitacion.txt";		
	$ArrValores=array();
	$Consulta = "select * from bd_rrhh.participantes ";
	$Consulta.= " where Fecha_Inicio > '1996-12-31'"; 
	$Consulta.= " order by Rut, Fecha_Inicio";
	$Resp=mysqli_query($link, $Consulta);
	$Indice=1;
	while ($Fila=mysqli_fetch_array($Resp))
	{
		$FI=substr($Fila["Fecha_Inicio"],8,2).substr($Fila["Fecha_Inicio"],5,2).substr($Fila["Fecha_Inicio"],0,4);
		$FT=substr($Fila["Fecha_Termino"],8,2).substr($Fila["Fecha_Termino"],5,2).substr($Fila["Fecha_Termino"],0,4);
		$FI_Aux=substr($Fila["Fecha_Inicio"],8,2)."-".substr($Fila["Fecha_Inicio"],5,2)."-".substr($Fila["Fecha_Inicio"],0,4);
		$FT_Aux=substr($Fila["Fecha_Termino"],8,2)."-".substr($Fila["Fecha_Termino"],5,2)."-".substr($Fila["Fecha_Termino"],0,4);
		//BUSCA PRECIO INTERNO
		$Datos=explode("-",$Fila["Rut"]);
		$RutAux=($Datos[0]*1);		
		$RutAux2=$RutAux."-".$Datos[1];	
		$Consulta = "select * from interfaces_sap.hr_costo_capacitacion ";
		if (substr($Fila["Fecha_Inicio"],0,4)=="1998")
			$Consulta.= " where (rut*1)='".$RutAux."' ";
		else
			$Consulta.= " where lpad(rut,10,'0')='".str_pad($RutAux2,10,'0',STR_PAD_LEFT)."' ";
		$Consulta.= " and fecha_inicio='".$FI_Aux."' and fecha_termino='".$FT_Aux."' ";
		//$Consulta.= " and nombre_curso='".$Fila["Nombre_Curso"]."' ";
		$RespC=mysqli_query($link, $Consulta,$link_48);
		//echo $Consulta."<br>";
		if ($FilaC=mysqli_fetch_array($RespC))
			$PrecioInterno=$FilaC["valor_participantes"];
		else
			$PrecioInterno=0;
		if (mysql_errno($link)!=0)
		{
			$numerror=mysql_errno($link);
			$descrerror=mysql_error($link);
			echo "Se ha producido un error n� $numerror que corresponde a: $descrerror<br>";
			echo $Consulta."<br>";
		}
		//
		$DiasDuracion=0;  //DiasDuracion
		$HorasDuracion=$Fila["Hrs_Curso"];  //HorasDuracion				
		$CodMoneda="$";
		//$Indice=str_replace(".","",str_replace("-","",$Fila["Rut"]));
		//$DiasDuracion=date("d",mktime(0,0,0,(substr($Fila["Fecha_Termino"],8,2)-substr($Fila["Fecha_Inicio"],8,2)),(substr($Fila["Fecha_Termino"],5,2)-substr($Fila["Fecha_Inicio"],5,2)),(substr($Fila["Fecha_Termino"],0,4)-substr($Fila["Fecha_Inicio"],0,4)));
		$DiasDuracion=datediff("d", $Fila["Fecha_Inicio"], $Fila["Fecha_Termino"]);
		$ArrValores[$Indice][1]=str_replace(".","",str_replace("-","",$Fila["Rut"]));  //Rut
		$ArrValores[$Indice][2]=$FI;  //fecha_inicio
		$ArrValores[$Indice][3]=$FT;  //fecha_termino
		$ArrValores[$Indice][4]=trim($Fila["Nombre_Curso"]);  //denominacion
		$ArrValores[$Indice][5]=trim($Fila["Sence"]);  //institucion
		$ArrValores[$Indice][6]=trim($Fila["Relator"]);  //responsable
		$ArrValores[$Indice][7]=($DiasDuracion+1);  //DiaDuracion
		$ArrValores[$Indice][8]=$HorasDuracion;  //HoraDuracion
		$ArrValores[$Indice][9]=$PrecioInterno;  //PrecioInterno
		$ArrValores[$Indice][10]=$CodMoneda;  //Moneda
		$Indice++;
	}
	mysql_close($link);
	mysql_close($link_48);
	include("inter_conectar.php");
	CreaArchivo("HrHistCapacitacion", $NomArchivo, "generados/hr", $ArrValores);
	
}	

function HrCreaArchivoCtasCorreo()
{	
	if ($NomArchivo=="")
		$NomArchivo="HrFileCtasCorreo.txt";		
	$ArrValores=array();
	$Consulta = "select * ";
	$Consulta.= " from antecedentes_personales t1 inner join hr_ctas_correo_enm_copy t2 on ";
	$Consulta.= " lpad(t1.RUT,10,'0')=lpad(t2.rut,10,'0') left join cargo t3 on t1.cod_cargo=t3.codigo_cargo";
	$Consulta.= " order by t1.apellido_paterno, t1.apellido_materno, t1.nombres, t1.rut ";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		/*$Consulta = "select * from hr_cta_correo_codelco where lpad(rut,10,'0')=lpad('".$Fila["RUT"]."',10,'0')";
		$Resp2=mysqli_query($link, $Consulta);
		if (!($Fila2=mysqli_fetch_array($Resp2)))
		{*/
			$Consulta = "select * from fico_homologa_cc where centro_costo_enm='".substr(str_replace("-","",str_replace(".","",$Fila["COD_CENTRO_COSTO"])),2)."'";
			$Resp3=mysqli_query($link, $Consulta);
			$CodCC="";
			$NomCC="";
			if (($Fila3=mysqli_fetch_array($Resp3)))
			{
				$CodCC=$Fila3["centro_costo_sap"];
				$NomCC=$Fila3["descripcion"];
			}
			else
			{				
				$CodCC="FA001";
				$NomCC="GERENCIA FUND Y REFINERIA VENTANAS";
			}
			
			$Indice=$Fila["RUT"];
			$Datos=explode("-",$Fila["RUT"]);
			$Rut=$Datos[0]*1;
			$Dv=strtoupper($Datos[1]);
			$ApePaterno=$Fila["APELLIDO_PATERNO"];
			$ApeMaterno=$Fila["APELLIDO_MATERNO"];
			$Nombres=trim($Fila["NOMBRES"]);
			$PNombre="";
			$SNombre="";
			$Encontro=false;
			for ($i=1;$i<=strlen($Nombres);$i++)
			{
				if (substr($Nombres,$i,1)==" ")
				{
					$Encontro=true;
					$PNombre=substr($Nombres,0,$i);
					$SNombre=substr($Nombres,$i);
					break;
				}
			}		
			if (!($Encontro))
				$PNombre=trim($Nombres);
			//NOMBRE CUENTA
			$Consulta = "select * from hr_ctas_creadas where rut='".$Rut."'";
			$Resp4=mysqli_query($link, $Consulta);
			$NomCta="";
			if (($Fila4=mysqli_fetch_array($Resp4)))
			{
				$NomCta=$Fila4["CUENTA"];
			}
			//
			$ArrValores[$Indice][1]=$Rut;  //RUT
			$ArrValores[$Indice][2]=$Dv;  //DV
			$ArrValores[$Indice][3]=trim($NomCta);  //CUENTA CODELCO
			$ArrValores[$Indice][4]=trim($ApePaterno);  //APELLIDO PATERNO
			$ArrValores[$Indice][5]=trim($ApeMaterno);  //APELLIDO MATERNO
			$ArrValores[$Indice][6]=trim($PNombre);  //PRIMER NOMBRE
			$ArrValores[$Indice][7]=trim($SNombre);  //SEGUNDO NOMBRE
			$ArrValores[$Indice][8]=trim($CodCC);  //COD. CC
			$ArrValores[$Indice][9]="31129999";  //FECHA TER. CONTRATO
			$ArrValores[$Indice][10]="31129999";  //FECHA EXP. CONTRATO
			$ArrValores[$Indice][11]="";  //SIGLA
			$ArrValores[$Indice][12]="";  //E
			$ArrValores[$Indice][13]="";  //DIVISION
			$ArrValores[$Indice][14]=trim($Fila["CARGO"]);  //CARGO
			$ArrValores[$Indice][15]=trim($Fila["ANEXO"]);  //FONO					
		//}
	}
	//CTAS DE CORREO EXTERNAS
	$Consulta = "select * ";
	$Consulta.= " from  hr_ctas_correo_externos t1 ";
	$Consulta.= " order by t1.ape_paterno, t1.ape_materno, t1.primer_nombre, t1.segundo_nombre, t1.rut ";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		$Consulta = "select * from fico_homologa_cc where centro_costo_enm='".$Fila["cc"]."'";
		$Resp2=mysqli_query($link, $Consulta);
		$Datos=array();
		$Rut="";
		$Dv="";
		$ApePaterno="";
		$ApeMaterno="";
		$PNombre="";
		$SNombre="";
		$CodCC="";
		$NomCC="";
		if (($Fila2=mysqli_fetch_array($Resp2)))
		{
			$CodCC=$Fila2["centro_costo_sap"];
			$NomCC=$Fila2["descripcion"];
		}
		$Indice=$Fila["rut"];
		$Datos=explode("-",$Fila["rut"]);
		$Rut=$Datos[0]*1;
		$Dv=strtoupper($Datos[1]);
		$ApePaterno=$Fila["ape_paterno"];
		$ApeMaterno=$Fila["ape_materno"];
		$PNombre=trim($Fila["primer_nombre"]);
		$SNombre=trim($Fila["segundo_nombre"]);		
		/*$ArrValores[$Indice][1]=$Rut;  //RUT
		$ArrValores[$Indice][2]=$Dv;  //DV
		$ArrValores[$Indice][3]="";  //NRO. SAP
		$ArrValores[$Indice][4]=$ApePaterno;  //APELLIDO PATERNO
		$ArrValores[$Indice][5]=$ApeMaterno;  //APELLIDO MATERNO
		$ArrValores[$Indice][6]=$PNombre;  //PRIMER NOMBRE
		$ArrValores[$Indice][7]=$SNombre;  //SEGUNDO NOMBRE
		$ArrValores[$Indice][8]=$CodCC;  //COD. CC
		$ArrValores[$Indice][9]=$NomCC;  //NOM. CC
		$ArrValores[$Indice][10]="";  //COD. UNIDAD
		$ArrValores[$Indice][11]="";  //NOM. UNIDAD
		$ArrValores[$Indice][12]="";  //COD. FUNCION
		$ArrValores[$Indice][13]="";  //NOM. FUNCION
		$ArrValores[$Indice][14]="";  //ESTADO (VIGENTE)
		$ArrValores[$Indice][15]=$Fila["rut_empresa"];  //RUT EMPRESA
		$ArrValores[$Indice][16]=$Fila["empresa"];  //NOM. EMPRESA
		$ArrValores[$Indice][17]="";  //COD. DIVISION (VE01)
		$ArrValores[$Indice][18]="";  //NOM. DIVISION (DIVISION VENTANAS)*/
		//NOMBRE CUENTA
		$Consulta = "select * from hr_ctas_creadas where rut='".$Rut."'";
		$Resp4=mysqli_query($link, $Consulta);
		$NomCta="";
		if (($Fila4=mysqli_fetch_array($Resp4)))
		{
			$NomCta=$Fila4["CUENTA"];
		}
		//
		$FFin = substr($Fila["fecha_fin"],8,2).substr($Fila["fecha_fin"],5,2).substr($Fila["fecha_fin"],0,4);
		$ArrValores[$Indice][1]=$Rut;  //RUT
		$ArrValores[$Indice][2]=$Dv;  //DV
		$ArrValores[$Indice][3]=trim($NomCta);  //CUENTA CODELCO
		$ArrValores[$Indice][4]=trim($ApePaterno);  //APELLIDO PATERNO
		$ArrValores[$Indice][5]=trim($ApeMaterno);  //APELLIDO MATERNO
		$ArrValores[$Indice][6]=trim($PNombre);  //PRIMER NOMBRE
		$ArrValores[$Indice][7]=trim($SNombre);  //SEGUNDO NOMBRE
		$ArrValores[$Indice][8]=trim($CodCC);  //COD. CC
		$ArrValores[$Indice][9]=$FFin;  //FECHA TER. CONTRATO
		$ArrValores[$Indice][10]=$FFin;  //FECHA EXP. CONTRATO
		$ArrValores[$Indice][11]="";  //SIGLA
		$ArrValores[$Indice][12]="";  //E
		$ArrValores[$Indice][13]="";  //DIVISION
		$ArrValores[$Indice][14]=trim($Fila["cargo"]);  //CARGO
		$ArrValores[$Indice][15]=trim($Fila["telefono"]);  //FONO
	}
	include("inter_conectar.php");
	CreaArchivo("HrCtasCorreo2", $NomArchivo, "generados/hr", $ArrValores);
	
	//CTAS DE CORREOS GENERICAS
	$Consulta = "select * ";
	$Consulta.= " from  hr_ctas_correo_genericas t1 ";
	$Resp=mysqli_query($link, $Consulta);
	$Indice=0;
	while ($Fila=mysqli_fetch_array($Resp))
	{
		$Consulta = "select * from fico_homologa_cc where centro_costo_enm='".$Fila["CC"]."'";
		$Resp2=mysqli_query($link, $Consulta);
		$Datos=array();
		$Datos=explode("-",$Fila["Rut"]);
		$Rut=$Datos[0]*1;
		$Dv=strtoupper($Datos[1]);
		$PNombre="";
		$CodCC="";
		$NomCC="";
		if (($Fila2=mysqli_fetch_array($Resp2)))
		{
			$CodCC=$Fila2["centro_costo_sap"];
			$NomCC=$Fila2["descripcion"];
		}
		else
		{				
			$CodCC="FA001";
			$NomCC="GERENCIA FUND Y REFINERIA VENTANAS";
		}
		$FFin="31129999";
		/*$ArrValores[$Indice][1]=$Rut;  //RUT
		$ArrValores[$Indice][2]=$Dv;  //DV
		$ArrValores[$Indice][3]="";  //NRO. SAP
		$ArrValores[$Indice][4]="";  //APELLIDO PATERNO
		$ArrValores[$Indice][5]="";  //APELLIDO MATERNO
		$ArrValores[$Indice][6]=$Fila["CUENTA1"];  //PRIMER NOMBRE
		$ArrValores[$Indice][8]=$CodCC;  //COD. CC
		$ArrValores[$Indice][9]=$NomCC;  //NOM. CC
		$ArrValores[$Indice][10]="";  //COD. UNIDAD
		$ArrValores[$Indice][11]="";  //NOM. UNIDAD
		$ArrValores[$Indice][12]="";  //COD. FUNCION
		$ArrValores[$Indice][13]="";  //NOM. FUNCION
		$ArrValores[$Indice][14]="";  //ESTADO (VIGENTE)		*/
		$ArrValores[$Indice][1]=$Rut;  //RUT
		$ArrValores[$Indice][2]=$Dv;  //DV
		$ArrValores[$Indice][3]="";  //CUENTA CODELCO
		$ArrValores[$Indice][4]="";  //APELLIDO PATERNO
		$ArrValores[$Indice][5]="";  //APELLIDO MATERNO
		$ArrValores[$Indice][6]=trim($Fila["CUENTA1"]);  //PRIMER NOMBRE
		$ArrValores[$Indice][7]="";  //SEGUNDO NOMBRE
		$ArrValores[$Indice][8]=trim($CodCC);  //COD. CC
		$ArrValores[$Indice][9]=$FFin;  //FECHA TER. CONTRATO
		$ArrValores[$Indice][10]=$FFin;  //FECHA EXP. CONTRATO
		$ArrValores[$Indice][11]="";  //SIGLA
		$ArrValores[$Indice][12]="";  //E
		$ArrValores[$Indice][13]="";  //DIVISION
		$ArrValores[$Indice][14]="";  //CARGO
		$ArrValores[$Indice][15]="";  //FONO
		/*$Consulta = "select * from interfaces_sap.hr_ctas_correo_externos where rut_empresa='".$Fila["Rut"]."'";
		$RespEmp=mysqli_query($link, $Consulta);
		if ($FilaEmp=mysqli_fetch_array($RespEmp))
		{
			$ArrValores[$Indice][15]=$Fila["Rut"];  //RUT EMPRESA
			$ArrValores[$Indice][16]=$FilaEmp["empresa"];  //NOM. EMPRESA
		}
		else
		{
			$ArrValores[$Indice][15]="";  //RUT EMPRESA
			$ArrValores[$Indice][16]="";  //NOM. EMPRESA
		}
		$ArrValores[$Indice][17]="";  //COD. DIVISION (VE01)
		$ArrValores[$Indice][18]="";  //NOM. DIVISION (DIVISION VENTANAS)*/
		$Indice++;
	}
	include("inter_conectar.php");
	CreaArchivo("HrCtasCorreo2", $NomArchivo, "generados/hr", $ArrValores);
	
}

?>