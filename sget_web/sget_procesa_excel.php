<?php
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
require_once 'reader.php';
$Directorio='Excel';
$Seg=date("s");

if($Archivo_name!='none')
{
	$Extension=explode('.',$Archivo_name);
	if(strtoupper($Extension[1])!='EXE'&&strtoupper($Extension[1])!='ZIP'&&strtoupper($Extension[1])!='RAR')
	{
		$Acento=false;
		for ($j = 0;$j <= strlen($Archivo_name); $j++)
		{
			switch(substr($Archivo_name,$j,1))
			{
				case "�":
				case "�":
				case "�":
				case "�":
				case "�":
				case "�":
				case "�":
				case "�":
				case "�":
				case "�":
					$Acento=true;
				break;
			}
		}
		if($Acento==false)
		{
				$NombreArchivo="HR_".$ID."_".$Archivo_name;
				if (copy($Archivo, $Directorio."/".$NombreArchivo))
				{
					$ProcesaArchivo = "S";
				}
				else
					$ProcesaArchivo = "N";
		}
	}
}
$Consulta="Select * from sget_hoja_ruta where num_hoja_ruta='".$ID."'";
$Resp1= mysql_query($Consulta);
if($Fila1 = mysql_fetch_array($Resp1))
{
	$RutEmpresa=$Fila1[rut_empresa];
	$Contrato=$Fila1["cod_contrato"];
}
$Cadena='';
if($ProcesaArchivo=="S")
{
	$data = new Spreadsheet_Excel_Reader();
	$data->read($Directorio."/".$NombreArchivo);
	error_reporting(E_ALL ^ E_NOTICE);
	$LargoArreglo = 0;
	$Cont=0;
	$EmpresaIngreso=$data->sheets[1]['cells'][1][2];
	$ContratoIngreso=$data->sheets[1]['cells'][2][2];
	if($ContratoIngreso==$Contrato)
	{
		$Hoja=0;
		for ($i = 2; $i <= $data->sheets[$Hoja]['numRows']; $i++) 
		{
			$Cont=0;
			for ($j = 1; $j <= $data->sheets[$Hoja]['numCols']; $j++)
			{
				if($Cont=='O')  
				{	
					$Valor= $data->sheets[$Hoja]['cells'][$i][$j];
					if($Valor!='')
					{
						if(ValidaRut($Valor,$Contrato))
						{
							if(!ExisteRut($Valor))
								InsertarUsuario($ID,$Contrato,$RutEmpresa,$data->sheets[$Hoja]['cells'][$i][1],$data->sheets[$Hoja]['cells'][$i][2],$data->sheets[$Hoja]['cells'][$i][3],$data->sheets[$Hoja]['cells'][$i][4],$data->sheets[$Hoja]['cells'][$i][5],$data->sheets[$Hoja]['cells'][$i][6],$data->sheets[$Hoja]['cells'][$i][7],$data->sheets[$Hoja]['cells'][$i][8],$data->sheets[$Hoja]['cells'][$i][9],$data->sheets[$Hoja]['cells'][$i][10],$data->sheets[$Hoja]['cells'][$i][11],$data->sheets[$Hoja]['cells'][$i][12],$data->sheets[$Hoja]['cells'][$i][13],$data->sheets[$Hoja]['cells'][$i][14],$data->sheets[$Hoja]['cells'][$i][15],'','',$data->sheets[$Hoja]['cells'][$i][16],$data->sheets[$Hoja]['cells'][$i][17],$data->sheets[$Hoja]['cells'][$i][18],$data->sheets[$Hoja]['cells'][$i][19],$data->sheets[$Hoja]['cells'][$i][20],$data->sheets[$Hoja]['cells'][$i][21],$data->sheets[$Hoja]['cells'][$i][22],$data->sheets[$Hoja]['cells'][$i][23],$data->sheets[$Hoja]['cells'][$i][24]);
							else
								ActualizarUsuario($ID,$Contrato,$RutEmpresa,$data->sheets[$Hoja]['cells'][$i][1],$data->sheets[$Hoja]['cells'][$i][2],$data->sheets[$Hoja]['cells'][$i][3],$data->sheets[$Hoja]['cells'][$i][4],$data->sheets[$Hoja]['cells'][$i][5],$data->sheets[$Hoja]['cells'][$i][6],$data->sheets[$Hoja]['cells'][$i][7],$data->sheets[$Hoja]['cells'][$i][8],$data->sheets[$Hoja]['cells'][$i][9],$data->sheets[$Hoja]['cells'][$i][10],$data->sheets[$Hoja]['cells'][$i][11],$data->sheets[$Hoja]['cells'][$i][12],$data->sheets[$Hoja]['cells'][$i][13],$data->sheets[$Hoja]['cells'][$i][14],$data->sheets[$Hoja]['cells'][$i][15],'','',$data->sheets[$Hoja]['cells'][$i][16],$data->sheets[$Hoja]['cells'][$i][17],$data->sheets[$Hoja]['cells'][$i][18],$data->sheets[$Hoja]['cells'][$i][19],$data->sheets[$Hoja]['cells'][$i][20],$data->sheets[$Hoja]['cells'][$i][21],$data->sheets[$Hoja]['cells'][$i][22],$data->sheets[$Hoja]['cells'][$i][23],$data->sheets[$Hoja]['cells'][$i][24]);
						}
						else
							$Cadena=".".$Valor.".,".$Cadena;
					}
				}
				$Cont++;
			}
		}
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmProceso.action='sget_hoja_ruta.php?Opt=M&Buscar=S&TxtHoja=".intval($ID)."&CmbEmpresa=".$RutEmpresa."&CmbContrato=".$Contrato."&Cadena=".$Cadena."';";
		echo "window.opener.document.FrmProceso.submit();";
		echo "window.close();</script>";
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmProceso.action='sget_hoja_ruta.php?Opt=M&Buscar=S&TxtHoja=".intval($ID)."&CmbEmpresa=".$RutEmpresa."&CmbContrato=".$Contrato."&Error=X';";
		echo "window.opener.document.FrmProceso.submit();";
		echo "window.close();</script>";
	}
}	
else
{
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmProceso.action='sget_hoja_ruta.php?Opt=M&Buscar=S&TxtHoja=".intval($ID)."&CmbEmpresa=".$RutEmpresa."&CmbContrato=".$Contrato."&Error=S';";
	echo "window.opener.document.FrmProceso.submit();";
	echo "window.close();</script>";

}
			
function InsertarUsuario($HR,$Ctto,$Emp,$Rut,$ApP,$ApM,$Nom,$Sex,$Fnac,$Direc,$Com,$Ciu,$Tel1,$Tel2,$Afp,$Tper,$Turn,$Carg,$Cert,$FecCert,$Prev,$Sind,$Seg,$Sueldo,$FIC,$FTC,$Reg,$Tarjeta,$TCtto)
{
	
	$Carg=(split("-",$Carg,2));
	$Tper=(split("-",$Tper,2));
	$Ciu=(split("-",$Ciu,2));
	$COMUN=explode("-",$Com);
	$Com=explode(".",$COMUN[0]);
	$Sind=(split("-",$Sind,2));
	$Turn=(split("-",$Turn,2));
	$Afp=(split("-",$Afp,2));
	$Sex=(split("-",$Sex,2));
	$Prev=(split("-",$Prev,2));
	$Seg=(split("-",$Seg,2));
	$TipoCtto=(split("-",$TCtto,2));
	
	$Carg=intval($Carg[0]);
	$Tper=intval($Tper[0]);
	$Cidad=$Ciu[0];
	$Ciu="";
	$Ciu=explode(".",$Cidad);
	$REG=intval($Ciu[0]);
	$Ciu=intval($Ciu[1]);
	$Com=intval($Com[1]);
	$Sind=intval($Sind[0]);
	$Turn=intval($Turn[0]);
	$Afp=intval($Afp[0]);
	$Sex=$Sex[0];
	$Prev=intval($Prev[0]);
	$Seg=intval($Seg[0]);
	$TipoCtto=intval($TipoCtto[0]);

	$Fnac=FormatoFechaAAAAMMDD2(str_replace("-","/",$Fnac));
	//echo $FIC."<br>";
	//echo $FTC."<br><br>";
	$FIC=FormatoFechaAAAAMMDD2(str_replace("-","/",$FIC));
	$FTC=FormatoFechaAAAAMMDD2(str_replace("-","/",$FTC));
	$Tarj=str_pad($Tarjeta,8,'0',STR_PAD_LEFT);
	$TipoCtto=intval($TipoCtto[0]);
	
	$Cert='N';
	$FecCert='0000-00-00';
	$Insertar="INSERT INTO sget_personal(rut,nombres,ape_paterno,ape_materno,fec_nac,cargo,tipo,cod_ciudad,cod_comuna,fec_ini_ctto,fec_fin_ctto,certificado_ant,direccion,telefono1,telefono2,rut_empresa,cod_contrato,estado,observacion,sueldo,cod_sindicato,cod_turno,cod_afp,fecha_certif,sexo,beca,cod_aseguradora,cod_salud,cod_region,nro_tarjeta,tipo_ctto) values (";
	$Insertar.="'".str_pad(trim($Rut),10,'0',STR_PAD_LEFT)."','".strtoupper($Nom)."','".strtoupper($ApP)."','".strtoupper($ApM)."','".$Fnac."','".$Carg."','".$Tper."','".$Ciu."','".$Com."','".$FIC."','".$FTC."','".$Cert."','".strtoupper($Direc)."','".$Tel1."','".$Tel2."',";
	$Insertar.="'".$Emp."','".$Ctto."','I',''";
	$Insertar.=",".intval(str_replace('.','',$Sueldo)).",'".$Sind."','".$Turn."','".$Afp."','".$FecCert."','".$Sex."','N','".$Seg."','".$Prev."','".$REG."','".$Tarj."','".intval($TipoCtto)."')";
	//echo $Insertar."<br>";
	mysql_query($Insertar);
	Historico($Rut,$Emp,$Ctto,$FIC,$FTC,$Sueldo);
	HRutaNomina($HR,$Rut);
}
function ActualizarUsuario($HR,$Ctto,$Emp,$Rut,$ApP,$ApM,$Nom,$Sex,$Fnac,$Direc,$Com,$Ciu,$Tel1,$Tel2,$Afp,$Tper,$Turn,$Carg,$Cert,$FecCert,$Prev,$Sind,$Seg,$Sueldo,$FIC,$FTC,$Reg,$Tarjeta,$TCtto)
{
		
	$Carg=(split("-",$Carg,2));
	$Tper=(split("-",$Tper,2));
	$Ciu=(split("-",$Ciu,2));
	$COMUN=explode("-",$Com);
	$Com=explode(".",$COMUN[0]);
	$Sind=(split("-",$Sind,2));
	$Turn=(split("-",$Turn,2));
	$Afp=(split("-",$Afp,2));
	$Sex=(split("-",$Sex,2));
	$Prev=(split("-",$Prev,2));
	$Seg=(split("-",$Seg,2));
	$TipoCtto=(split("-",$TCtto,2));
	
	$Carg=intval($Carg[0]);
	$Tper=intval($Tper[0]);
	$Cidad=$Ciu[0];
	$Ciu="";
	$Ciu=explode(".",$Cidad);
	$REG=intval($Ciu[0]);
	$Ciu=intval($Ciu[1]);
	$Com=intval($Com[1]);
	$Sind=intval($Sind[0]);
	$Turn=intval($Turn[0]);
	$Afp=intval($Afp[0]);
	$Sex=$Sex[0];
	$Prev=intval($Prev[0]);
	$Seg=intval($Seg[0]);
	$TipoCtto=intval($TipoCtto[0]);
	
	$Fnac=FormatoFechaAAAAMMDD2(str_replace("-","/",$Fnac));
	$FIC=FormatoFechaAAAAMMDD2(str_replace("-","/",$FIC));
	$FTC=FormatoFechaAAAAMMDD2(str_replace("-","/",$FTC));
	$Tarj=str_pad($Tarjeta,8,'0',STR_PAD_LEFT);
	$Cert='N';
	$FecCert='0000-00-00';
	$Actualizar=" UPDATE  sget_personal set ";
	$Actualizar.="nombres='".strtoupper($Nom)."',ape_paterno='".strtoupper($ApP)."',ape_materno='".strtoupper($ApM)."',fec_nac='".$Fnac."',cargo='".$Carg."',tipo='".$Tper."',direccion='".strtoupper($Direc)."',cod_ciudad='".$Ciu."',cod_comuna='".$Com."',";
	$Actualizar.="telefono1='".$Tel1."',telefono2='".$Tel2."',rut_empresa='".$Emp."',cod_contrato='".$Ctto."',";
	$Actualizar.="estado='I',observacion='',";	
	$Actualizar.="fec_ini_ctto='".$FIC."',fec_fin_ctto='".$FTC."',sueldo=".intval(str_replace('.','',$Sueldo)).",cod_afp='".$Afp."',cod_sindicato='".$Sind."',cod_turno='".$Turn."' ";	
	$Actualizar.=",sexo='".$Sex."',cod_aseguradora='".$Seg."',cod_salud='".$Prev."',cod_region='".$REG."', nro_tarjeta='".$Tarj."',tipo_ctto='".intval($TipoCtto)."' where rut='".str_pad(trim($Rut),10,'0',STR_PAD_LEFT)."'";
	//echo $Actualizar."<br>";
	mysql_query($Actualizar);

	Historico($Rut,$Emp,$Ctto,$FIC,$FTC,$Sueldo);
	HRutaNomina($HR,$Rut);
}
function Historico($Run,$Empresa,$Ctto,$FechaIni,$FechaFin,$Sueldo)
{
	$Sueldo=intval(str_replace('.','',$Sueldo));
	if($Sueldo=='')
		$Sueldo=0;
	$Actualizar=" UPDATE sget_personal_historia set activo='N' where cod_contrato='".$Ctto."' and rut_empresa='".$Empresa."' and rut='".str_pad(trim($Run),10,'0',STR_PAD_LEFT)."'";
	mysql_query($Actualizar);
	$Insertar="INSERT INTO sget_personal_historia(cod_contrato,rut_empresa,rut,activo,fecha_ingreso,fecha_termino,sueldo) values (";
	$Insertar.="'".$Ctto."','".$Empresa."','".str_pad(trim($Run),10,'0',STR_PAD_LEFT)."','S','".$FechaIni."','".$FechaFin."','".$Sueldo."')";
	mysql_query($Insertar);
}
function HRutaNomina($Nomina,$Rut)
{
	$Consulta="SELECT * from sget_hoja_ruta_nomina where rut_personal='".str_pad(trim($Rut),10,'0',STR_PAD_LEFT)."' and num_hoja_ruta='".$Nomina."'";
	$Resp = mysql_query($Consulta);
	if(!$Fila = mysql_fetch_array($Resp))
	{
		$Insertar="INSERT INTO sget_hoja_ruta_nomina(num_hoja_ruta,rut_personal,estado,observacion,origen) values (";
		$Insertar.="'".$Nomina."','".str_pad(trim($Rut),10,'0',STR_PAD_LEFT)."','A','','E')";
		mysql_query($Insertar);
	}
}
function ExisteRut($Run)
{
	$Existe=false;
	$Consulta="SELECT * from sget_personal where rut='".str_pad(trim($Run),10,'0',STR_PAD_LEFT)."'";
	$Resp = mysql_query($Consulta);
	if($Fila = mysql_fetch_array($Resp))
	{
		$Existe=true;
	}
	return ($Existe);
}

function ValidaRut($Run,$Contra)
{
	$FechaSistema=date('Y-m-d');
	$Existe=false;
	$Consulta="SELECT * from sget_personal where rut='".str_pad(trim($Run),10,'0',STR_PAD_LEFT)."' and estado='A'";
	$Resp = mysql_query($Consulta);
	if($Fila = mysql_fetch_array($Resp))
	{
		if($Fila["cod_contrato"]!=$Contra)
		{
			if($Fila[fec_fin_ctto]!='0000-00-00')
			{
				$dif=resta_fechas($FechaSistema,$Fila[fec_fin_ctto]);
				if($dif>0)
				{
					$Existe=true;
				
				}
			}
			else
				$Existe=true;	
		}
		else
		{
			$Existe=true;
		}
	}
	else
	{
		$Existe=true;
	}
	return ($Existe);
}

?>
