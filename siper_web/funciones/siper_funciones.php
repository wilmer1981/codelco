<?
//include('conectar_ori.php');

function acceso($CookieRut,$Pantalla)
{
	function getIP() 
	{
	
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
		   $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} 
		elseif (isset($_SERVER['HTTP_VIA']))
		{
		   $ip = $_SERVER['HTTP_VIA'];
		} 
		elseif (isset($_SERVER['REMOTE_ADDR'])) 
		{
		   $ip = $_SERVER['REMOTE_ADDR'];
		}
		else 
		{ 
		   $ip = "unknown";
		}
     	return $ip;
	}
	$IpUser=getIP();
	$Inserta="INSERT INTO sgrs_control_acceso (fecha_hora,rut,ip,pantalla) values('".date('Y-m-d G:i:s')."','".$CookieRut."','".$IpUser."','".$Pantalla."')";
	//echo $Inserta."<br>";
	mysql_query($Inserta);
}
function Contactos($Gerencias)//OBTIENE NOMBRES GERENCIAS
{
	$Gere=explode('//',$Gerencias);
	while(list($c,$v)=each($Gere))
	{
		$Consulta="SELECT * from sgrs_areaorg where CAREA='".$v."'";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$NomGere=$NomGere.$Fila[NAREA].", ";			
	}
	return($NomGere);
}
function InsertaHistorico($Rut,$TipoProceso,$Obs,$Obs2,$Parent,$ObsEli)
{
	$Fecha=date('Y-m-d G:i:s');
	$Consulta="SELECT max(correlativo+1) as maximo from sgrs_registro_historico ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		if($Fila[maximo]=='')
			$Corr='1';
		else		
			$Corr=$Fila[maximo];
	}
	$Inserta="INSERT INTO sgrs_registro_historico (correlativo,fecha_registro,rut_funcionario,tipo_proceso,observacion,Observacion2,parent,obs_elimina,Tipo_Eli_Sust) values('".$Corr."','".$Fecha."','".$Rut."','".$TipoProceso."','".$Obs."','".$Obs2."','".$Parent."','".$ObsEli."','1')";
	//echo $Inserta;
	mysql_query($Inserta);
}	
function InsertaHistoricoIdent($Rut,$TipoProceso,$Obs,$Obs2,$Parent,$ObsEli,$TipoES)
{
	$Fecha=date('Y-m-d G:i:s');
	$Consulta="SELECT max(correlativo+1) as maximo from sgrs_registro_historico ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		if($Fila[maximo]=='')
			$Corr='1';
		else		
			$Corr=$Fila[maximo];
	}
	$Inserta="INSERT INTO sgrs_registro_historico (correlativo,fecha_registro,rut_funcionario,tipo_proceso,observacion,Observacion2,parent,obs_elimina,Tipo_Eli_Sust) values('".$Corr."','".$Fecha."','".$Rut."','".$TipoProceso."','".$Obs."','".$Obs2."','".$Parent."','".$ObsEli."','".$TipoES."')";
	//echo $Inserta;
	mysql_query($Inserta);
}	

function OrigenOrg($Cod,$Ruta)
{
	$Ruta='';
	$Codigos=explode(',',$Cod);
	while(list($c,$v)=each($Codigos))
	{
		//echo $v."<br>";
		if($v!=''&&$v!='0')
		{
			$Consulta="SELECT * from sgrs_areaorg where CAREA='".$v."'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
			$Ruta=$Ruta.$Fila[NAREA].", ";
		}	
	
	}
} 
function ObtenerCodParent($Parent)
{
	$CodOrganica=substr($Parent,1);
	$CodOrganica=substr($CodOrganica,0,strlen($CodOrganica)-1);
	$CodOrganica=explode(',',$CodOrganica);
	$LarArr=count($CodOrganica);$ContArr=1;$CodOrganicaAux=',';
	while(list($c,$v)=each($CodOrganica))
	{
		if($ContArr=$LarArr)
			$CodOrganicaAux=$v;
		$ContArr++;	
	}
	$Parent=$CodOrganicaAux;
	return($Parent);
}
function ObtenerNivel($CodNivel)
{
	$Consulta="SELECT CTAREA from sgrs_areaorg where CAREA='".$CodNivel."'";	
	//echo $Consulta."<br>";
	$Resp=mysql_query($Consulta);
	$Fila=mysql_fetch_array($Resp);	
	$CodNivel=$Fila[CTAREA];
	return $CodNivel;
}
function CalculoMR($CodContacto,$CodPel,$PH,$CH,$MRi,$PC,$CC,$MR,$Descrip,$Semaforo)
{

	$PH='';$CH='';$MRi='';$PC='';$CC='';$MR='';$Descrip='';$Semaforo='';
	$Consulta="SELECT QPROBHIST,QCONSECHIST from sgrs_codcontactos where CCONTACTO ='".$CodContacto."'";
	//echo $Consulta;
	$Resultado=mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resultado))
	{
		$PH=$Fila[QPROBHIST];	
		$CH=$Fila[QCONSECHIST];
		$MRi=$PH*$CH;
		$MRi=Reduccion(&$MRi);		
	}
	//echo "MAG.INI:".$MRi."<br>";
	$Consulta="SELECT QMR,QPC,QCC,QMRH from sgrs_siperpeligros where CPELIGRO ='".$CodPel."'";
	//echo $Consulta;
	$Resultado=mysql_query($Consulta);
	$Fila=mysql_fetch_array($Resultado);
	if(!is_null($Fila[QPC])&&!is_null($Fila[QCC]))
	{
		if($Fila[QPC]==0&&$Fila[QCC]==0&&$Fila[QMR]==0&&$Fila[QMRH]==0)
		{
			$Descrip="SIN CONTROLES ASOCIADOS";	
			$Semaforo='sin_controles.png';	
		}
		else
		{	
			$PC=PC_Controles(1,$PC,$CodPel);
			$CC=PC_Controles(0,$CC,$CodPel);
			//echo "PC:".$PC."<BR>";
			//echo "CC:".$CC;
			$MRc=$PC*$CC;
			$MRc=Reduccion(&$MRc);
			
			$MR=$MRi*$MRc;
			if($MR>=1&&$MR<=4)
			{
				$Descrip="ACEPTABLE";
				$Semaforo='semaforo_verde.jpg';
			}
			if($MR>=8&&$MR<=16)
			{
				$Descrip="MODERADO";
				$Semaforo='semaforo_amarillo.jpg';
			}
			if($MR>=32&&$MR<=64)
			{
				$Descrip="INACEPTABLE";	
				$Semaforo='semaforo_rojo.jpg';			
			}
		}
		
	}
	else
	{
		$Descrip='NO CALCULADO';
		$Semaforo='semaforo_nada.jpg';
	}	
}
function Reduccion($MR_D)
{
	switch($MR_D)
	{
		case 64:
			$MR_D=8;
		break;
		case 32:
			$MR_D=4;
		break;
		case 16:
		case 8:
			$MR_D=2;
		break;
		case 4:
		case 2:
		case 1:
			$MR_D=1;
		break;					
	}
	return($MR_D);
}
function CalculoMRI($PH,$CH,$DESMRI,$SEMAMRI)
{
$DESMRI='';$DMRI='';
	switch($PH)
	{
		case 1://PROBABILIDAD
			   switch($CH)
			   {
			   		case 1:
			   		case 2:
			   		case 4:
						$DMRI='1';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
		case 2:
			   switch($CH)
			   {
			   		case 1:
			   		case 2:
						$DMRI='1';
					break;
					case 4:
						$DMRI='2';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
		case 4:
			   switch($CH)
			   {
			   		case 1:
						$DMRI='1';
					break;
					case 2:
					case 4:
						$DMRI='2';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
		case 8:
			   switch($CH)
			   {
			   		case 1:
					case 2:
						$DMRI='2';
					break;
					case 4:
						$DMRI='3';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
	}
	if($DMRI==1)
	{
		$DESMRI="<font face='Arial, Helvetica, sans-serif' size='1'>ACEPTABLE</font>";
		$SEMAMRI='semaforo_verde.jpg';
	}	
	if($DMRI==2)
	{
		$DESMRI="<font face='Arial, Helvetica, sans-serif' size='1'>MODERADO</font>";
		$SEMAMRI='semaforo_amarillo.jpg';
	}	
	if($DMRI==3)
	{
		$DESMRI="<font face='Arial, Helvetica, sans-serif' color='#FF0000' size='1'>INACEPTABLE</font>";
		$SEMAMRI='semaforo_rojo.jpg';
	}	
}
function CalculoMRIConsulta($PH,$CH,$DESMRI,$SEMAMRI,$NMRi)
{
	$DESMRI='';$DMRI='';
	switch($PH)
	{
		case 1://PROBABILIDAD
			   switch($CH)
			   {
			   		case 1:
			   		case 2:
			   		case 4:
						$DMRI='1';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
		case 2:
			   switch($CH)
			   {
			   		case 1:
			   		case 2:
						$DMRI='1';
					break;
					case 4:
						$DMRI='2';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
		case 4:
			   switch($CH)
			   {
			   		case 1:
						$DMRI='1';
					break;
					case 2:
					case 4:
						$DMRI='2';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
		case 8:
			   switch($CH)
			   {
			   		case 1:
					case 2:
						$DMRI='2';
					break;
					case 4:
						$DMRI='3';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
	}
	if($DMRI==1)
	{
		$DESMRI="<font face='Arial, Helvetica, sans-serif' size='1'>ACEPTABLE</font>";
		$SEMAMRI='semaforo_verde.jpg';
	}	
	if($DMRI==2)
	{
		$DESMRI="<font face='Arial, Helvetica, sans-serif' size='1'>MODERADO</font>";
		$SEMAMRI='semaforo_amarillo.jpg';
	}	
	if($DMRI==3)
	{
		$DESMRI="<font face='Arial, Helvetica, sans-serif' color='#FF0000' size='1'>INACEPTABLE</font>";
		$SEMAMRI='semaforo_rojo.jpg';
	}
	$NMRi=$DMRI;	
}



function SUMAMRI($PH,$CH,$Cod,$CodT,$SUMAACEP,$SUMAMODE,$SUMAINAC)
{
if($CodT==8)
	$Filtro="t1.CAREA='".$Cod."'";
else
	$Filtro="t1.CPARENT like '%,".$Cod.",%' ";			
$Consulta="SELECT t1.CAREA,t1.CPARENT,t1.CTAREA,t1.NAREA,t2.QPROBHIST,t2.QCONSECHIST from sgrs_areaorg t1 left join sgrs_siperpeligros t2 on t1.CAREA=t2.CAREA ";
$Consulta.=" where ".$Filtro." and t1.CPARENT <>'' and t2.MVIGENTE<>'0' and t1.CTAREA ='8' and t1.MVIGENTE='1' and ".$Filtro;
/*$Consulta="SELECT * from sgrs_areaorg t1 left join sgrs_siperpeligros t2 on t1.CAREA=t2.CAREA ";
$Consulta.="where t1.MVIGENTE='1' and t2.MVIGENTE<>'0' and t2.MVALIDADO='1' and t1.CTAREA ='8' and ".$Filtro;
*/$RespPel=mysql_query($Consulta);
//echo $Consulta."<br>";
while($FilaPel=mysql_fetch_array($RespPel))
{
	switch($FilaPel[QPROBHIST])
	{
		case 1://PROBABILIDAD
			   switch($FilaPel[QCONSECHIST])
			   {
			   		case 1:
			   		case 2:
			   		case 4:
						$DMRI='1';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
		case 2:
			   switch($FilaPel[QCONSECHIST])
			   {
			   		case 1:
			   		case 2:
						$DMRI='1';
					break;
					case 4:
						$DMRI='2';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
		case 4:
			   switch($FilaPel[QCONSECHIST])
			   {
			   		case 1:
						$DMRI='1';
					break;
					case 2:
					case 4:
						$DMRI='2';
					break;
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
		case 8:
			   switch($FilaPel[QCONSECHIST])
			   {
			   		case 1:
					case 2:
						$DMRI='2';
					break;
					case 4:
					case 8:
						$DMRI='3';
					break;
			   } 	
		break;
	}
	if($DMRI==1)
		$SUMAACEP=$SUMAACEP+1;		
	if($DMRI==2)
		$SUMAMODE=$SUMAMODE+1;		
	if($DMRI==3)
		$SUMAINAC=$SUMAINAC+1;	
}			
}
function PC_Controles($Tipo,$PC,$CodPel)
{
	//SUMA NA
	$Consulta="SELECT sum(t1.QPESOESP) as SumNA  from sgrs_codcontroles t1 left join sgrs_sipercontroles t2 on t1.CCONTROL=t2.CCONTROL and t2.CPELIGRO='".$CodPel."' ";
	$Consulta.="where t1.QPESOESP IS NOT NULL and t2.MCONTROL IS NULL and  MPROBCONSEC=".$Tipo." and t1.MVIGENTE='1' and t1.CCONTROL<>'--'  order by t1.CCONTROL"; 
	//echo $Consulta."<BR>";
	$Resultado=mysql_query($Consulta);
	$Fila=mysql_fetch_array($Resultado);
	$SumNA=$Fila[SumNA];
	if($SumNA!=1)
		$ModNa=$SumNA/(1-$SumNA);
	else
		$ModNa=1;	
	//SUMA SI
	$Consulta="SELECT ifnull(sum(t1.QPESOESP),0) as SumSI  from sgrs_codcontroles t1 inner join sgrs_sipercontroles t2 on t1.CCONTROL=t2.CCONTROL and t2.CPELIGRO='".$CodPel."' ";
	$Consulta.="where t1.QPESOESP IS NOT NULL and t2.MCONTROL = 1 and  MPROBCONSEC=".$Tipo." and t1.MVIGENTE='1' and t1.CCONTROL<>'--'  order by t1.CCONTROL"; 
	//echo $Consulta."<BR>";
	$Resultado=mysql_query($Consulta);
	$Fila=mysql_fetch_array($Resultado);
	$SumSI=$Fila[SumSI];
	$SISumSI=($SumSI+$SumSI*$ModNa);
	//SUMA SIsi- SIsr
	$Consulta="SELECT ifnull(sum(t1.QPESOESP),0) as SumSIsisr  from sgrs_codcontroles t1 inner join sgrs_sipercontroles t2 on t1.CCONTROL=t2.CCONTROL and t2.CPELIGRO='".$CodPel."' ";
	$Consulta.="where t1.QPESOESP IS NOT NULL and t2.MCONTROL in (2,3) and  MPROBCONSEC=".$Tipo." and t1.MVIGENTE='1' and t1.CCONTROL<>'--'  order by t1.CCONTROL"; 
	//echo $Consulta."<BR>";
	$Resultado=mysql_query($Consulta);
	$Fila=mysql_fetch_array($Resultado);
	$SumSIsisr=$Fila[SumSIsisr];
	$SISumSIsisr=($SumSIsisr+$SumSIsisr*$ModNa);
	$C=intval(($SISumSI+$SISumSIsisr*0.5)*100);
	if($Tipo==1)
	{
		if($C==100)
			$PC=1;
		else
		{
			if(100>$C&&$C>=75)
				$PC=2;
			else
				if(75>$C&&$C>=50)
					$PC=4;
				else
					if($C<50)
						$PC=8;
		}				
	}					
	else
	{
		if($C==100)
			$PC=1;
		else
		{
			if(100>$C&&$C>=83)
				$PC=2;
			else
				if(83>$C&&$C>=67)
					$PC=4;
				else
					if($C<67)
						$PC=8;
		}
	}				
	return($PC);	
}
function EntregaMR($MRi,$PC,$CC,$Descrip,$Semaforo)
{
		$MRc=$PC*$CC;
		$MRc=Reduccion(&$MRc);
		
		$MR=$MRi*$MRc;
		if($MR>=1&&$MR<=4)
		{
			$Descrip="ACEPTABLE";
			$Semaforo='semaforo_verde.jpg';
		}
		if($MR>=8&&$MR<=16)
		{
			$Descrip="MODERADO";
			$Semaforo='semaforo_amarillo.jpg';
		}
		if($MR>=32&&$MR<=64)
		{
			$Descrip="INACEPTABLE";	
			$Semaforo='semaforo_rojo.jpg';			
		}


}
function ObtieneUsuario($Rut,$NombreUser)
{
	$Consulta = "SELECT * from proyecto_modernizacion.funcionarios ";
	$Consulta.= " where rut='".$Rut."'";
	$Resp=mysql_query($Consulta);
	if ($Fila=mysql_fetch_array($Resp))
	{
		$PrimerNombre=$Fila["nombres"];
		for ($i=0;$i<=strlen($PrimerNombre);$i++)
		{
			if (substr($PrimerNombre,$i,1)==" ")
			{
				$PrimerNombre=trim(substr($PrimerNombre,0,$i));
				break;
			}
		}
		$NombreUser = ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($PrimerNombre))." ".strtoupper(substr($Fila["apellido_materno"],0,1)).".";
	}
}
function ObtieneAccesoOrg($Rut,$AccesoOrg)
{
	$Consulta = "SELECT * from sgrs_acceso_organica where rut='".$Rut."' ";
	//echo $Consulta;
	$Resp=mysql_query($Consulta);
	if ($Fila=mysql_fetch_array($Resp))
	{
		$AccesoOrg=$Fila[COD_GERENCIAS];
		/*$AccesoOrg="'";
		$DatosOrg=explode(',',$Fila[COD_GERENCIAS]);
		while(list($c,$v)=each($DatosOrg))
		{
			$AccesoOrg=$AccesoOrg.$v."','";
		}
		$AccesoOrg=substr($AccesoOrg,0,strlen($AccesoOrg)-2);*/
	}
	return($AccesoOrg);
}
function ObtieneAccesoOrg2($Rut,$AccesoOrg)
{
	$Consulta = "SELECT * from sgrs_acceso_organica where rut='".$Rut."' ";
	//echo $Consulta;
	$Resp=mysql_query($Consulta);
	if ($Fila=mysql_fetch_array($Resp))
	{
		$AccesoOrg=" and (CPARENT LIKE '%";
		$DatosOrg=explode(',',$Fila[COD_GERENCIAS]);
		while(list($c,$v)=each($DatosOrg))
		{
			$AccesoOrg=$AccesoOrg.$v."%' or CPARENT LIKE '%";
		}
		$AccesoOrg=substr($AccesoOrg,0,strlen($AccesoOrg)-19);
		$AccesoOrg=$AccesoOrg.")";
	}
	return($AccesoOrg);
}
function CrearArbol($Cod,$Estado,$SelTarea,$Rut,$TareaVigente)
{
	if($Cod=='')
		$Cod=",0,";
	$CodAux=$Cod;
	$Niveles=array('D','G','S','A','P','U','AC','O','T');
	$Organica=explode(',',$Cod);
	$LargoArreglo=count($Organica)-3;
	//echo "LARGO:".$LargoArreglo."<br><br><br>";
	//echo "<div style='position:absolute; left:2px; top:100px; width:99%; height: 482px; OVERFLOW: auto;' id='OrganicaGen'>";
	//echo "<table border='0' cellpadding='0' cellspacing='0'>";
	//$AccesoOrg=ObtieneAccesoOrg($Rut,$AccesoOrg);
	if($TareaVigente=='N')
		$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT=',".$Organica[1].",' ORDER BY CTAREA";
	else
		$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT=',".$Organica[1].",' and MVIGENTE='1'  ORDER BY CTAREA";	
	//echo $Consulta."<br>";
	$RespD=mysql_query($Consulta);
	while($FilaD=mysql_fetch_array($RespD))
	{
			$Cod=$FilaD[CPARENT].$FilaD[CAREA].",";
			if($TareaVigente=='N')		
				$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
			else
				$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
			//echo $Consulta;
			$RespG=mysql_query($Consulta);
			$CantHijosG=mysql_num_rows($RespG);$ContG=1;
			MuestraHijo(0,$Cod,$FilaD[CTAREA],$FilaD[NAREA],$CodAux,$Estado,$CantHijosG,$SelTarea,$Rut);
			while($FilaG=mysql_fetch_array($RespG))
			{
				$Item='';
				if($CantHijosG==1)
					$Item='I';
				if($CantHijosG==$ContG)
					$Item='F';
				$ContG++;	
				$Cod=$FilaG[CPARENT].$FilaG[CAREA].",";
				if($TareaVigente=='N')	
					$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
				else
					$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
				$RespS=mysql_query($Consulta);
				$CantHijosS=mysql_num_rows($RespS);$ContS=1;
				if($FilaG[CPARENT]==",".$Organica[1].",".$Organica[2].",")
					MuestraHijo(1,$Cod,$FilaG[CTAREA],$FilaG[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
				if($LargoArreglo>1)
				{
				while($FilaS =mysql_fetch_array($RespS))	
				{		
					$Item='';
					if($CantHijosS==1)
						$Item='I';
					if($CantHijosS==$ContS)
						$Item='F';
					$ContS++;						
					$Cod=$FilaS[CPARENT].$FilaS[CAREA].",";
					if($TareaVigente=='N')
						$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
					else
						$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";
					$RespA=mysql_query($Consulta);
					$CantHijosA=mysql_num_rows($RespA);$ContA=1;
					if($FilaS[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",")
						MuestraHijo(2,$Cod,$FilaS[CTAREA],$FilaS[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
					if($LargoArreglo>2)
					{
					while($FilaA = mysql_fetch_array($RespA))	
					{			
						$Item='';
						if($CantHijosA==1)
							$Item='I';
						if($CantHijosA==$ContA)
							$Item='F';
						$ContA++;	
						$Cod=$FilaA[CPARENT].$FilaA[CAREA].",";
						if($TareaVigente=='N')
							$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
						else
							$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
						$RespP=mysql_query($Consulta);
						$CantHijosP=mysql_num_rows($RespP);$ContP=1;
						if($FilaA[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",")
							MuestraHijo(3,$Cod,$FilaA[CTAREA],$FilaA[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
						if($LargoArreglo>3)
						{
						while($FilaP = mysql_fetch_array($RespP))	
						{			
							$Item='';
							if($CantHijosP==1)
								$Item='I';
							if($CantHijosP==$ContP)
								$Item='F';
							$ContP++;								
							$Cod=$FilaP[CPARENT].$FilaP[CAREA].",";
							if($TareaVigente=='N')
								$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
							else
								$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
							$RespU=mysql_query($Consulta);
							$CantHijosU=mysql_num_rows($RespU);$ContU=1;
							if($FilaP[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",".$Organica[5].",")
								MuestraHijo(4,$Cod,$FilaP[CTAREA],$FilaP[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
							if($LargoArreglo>4)
							{
							while($FilaU = mysql_fetch_array($RespU))	
							{			
								$Item='';
								if($CantHijosU==1)
									$Item='I';
								if($CantHijosU==$ContU)
									$Item='F';
								$ContU++;	
								$Cod=$FilaU[CPARENT].$FilaU[CAREA].",";
								if($TareaVigente=='N')
									$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
								else
									$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
								$RespAC=mysql_query($Consulta);
								$CantHijosAC=mysql_num_rows($RespAC);$ContAC=1;
								if($FilaU[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",".$Organica[5].",".$Organica[6].",")
									MuestraHijo(5,$Cod,$FilaU[CTAREA],$FilaU[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
								if($LargoArreglo>5)
								{
								while($FilaAC = mysql_fetch_array($RespAC))	
								{			
									$Item='';
									if($CantHijosAC==1)
										$Item='I';
									if($CantHijosAC==$ContAC)
										$Item='F';
									$ContAC++;	
									$Cod=$FilaAC[CPARENT].$FilaAC[CAREA].",";
									if($TareaVigente=='N')
										$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
									else
										$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";
									$RespO=mysql_query($Consulta);
									$CantHijosO=mysql_num_rows($RespO);$ContO=1;
									if($FilaAC[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",".$Organica[5].",".$Organica[6].",".$Organica[7].",")
										MuestraHijo(6,$Cod,$FilaAC[CTAREA],$FilaAC[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
									if($LargoArreglo>6)
									{
									while($FilaO = mysql_fetch_array($RespO))	
									{			
										$Item='';
										if($CantHijosO==1)
											$Item='I';
										if($CantHijosO==$ContO)
											$Item='F';
										$ContO++;	
										$Cod=$FilaO[CPARENT].$FilaO[CAREA].",";
										if($TareaVigente=='N')
											$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
										else
											$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";
										$RespT=mysql_query($Consulta);
										if($FilaO[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",".$Organica[5].",".$Organica[6].",".$Organica[7].",".$Organica[8].",")
											MuestraHijo(7,$Cod,$FilaO[CTAREA],$FilaO[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
										if($LargoArreglo>7)
										{
										while($FilaT = mysql_fetch_array($RespT))	
										{			
											$Cod=$FilaT[CPARENT].$FilaT[CAREA].",";
											if($FilaT[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",".$Organica[5].",".$Organica[6].",".$Organica[7].",".$Organica[8].",".$Organica[9].",")
											{
												//echo "CODIGO:".$Cod."<BR>";
												MuestraHijo(8,$Cod,$FilaT[CTAREA],$FilaT[NAREA],'','','',$SelTarea,$Rut);
											}	
										}
										}
									}
									}
								}
								}
							}
							}
						}
						}
					}
					}
				}
				}
			}
		}
		//echo "</table>";
}
function CrearArbolNivelArea($Cod,$Estado,$SelTarea,$Rut,$TareaVigente)
{
	if($Cod=='')
		$Cod=",0,";
	$CodAux=$Cod;
	$Niveles=array('D','G','S','A','P','U','AC','O','T');
	$Organica=explode(',',$Cod);
	$LargoArreglo=count($Organica)-3;
	//echo "LARGO:".$LargoArreglo."<br><br><br>";
	//echo "<div style='position:absolute; left:2px; top:100px; width:99%; height: 482px; OVERFLOW: auto;' id='OrganicaGen'>";
	//echo "<table border='0' cellpadding='0' cellspacing='0'>";
	//$AccesoOrg=ObtieneAccesoOrg($Rut,$AccesoOrg);
	if($TareaVigente=='N')
		$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT=',".$Organica[1].",' ORDER BY CTAREA";
	else
		$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT=',".$Organica[1].",' and MVIGENTE='1'  ORDER BY CTAREA";	
	//echo $Consulta."<br>";
	$RespD=mysql_query($Consulta);
	while($FilaD=mysql_fetch_array($RespD))
	{
			$Cod=$FilaD[CPARENT].$FilaD[CAREA].",";
			if($TareaVigente=='N')		
				$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
			else
				$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
			//echo $Consulta;
			$RespG=mysql_query($Consulta);
			$CantHijosG=mysql_num_rows($RespG);$ContG=1;
			MuestraHijoNivelarea(0,$Cod,$FilaD[CTAREA],$FilaD[NAREA],$CodAux,$Estado,$CantHijosG,$SelTarea,$Rut);
			while($FilaG=mysql_fetch_array($RespG))
			{
				$Item='';
				if($CantHijosG==1)
					$Item='I';
				if($CantHijosG==$ContG)
					$Item='F';
				$ContG++;	
				$Cod=$FilaG[CPARENT].$FilaG[CAREA].",";
				if($TareaVigente=='N')	
					$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
				else
					$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
				$RespS=mysql_query($Consulta);
				$CantHijosS=mysql_num_rows($RespS);$ContS=1;
				if($FilaG[CPARENT]==",".$Organica[1].",".$Organica[2].",")
					MuestraHijoNivelarea(1,$Cod,$FilaG[CTAREA],$FilaG[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
				if($LargoArreglo>1)
				{
				while($FilaS =mysql_fetch_array($RespS))	
				{		
					$Item='';
					if($CantHijosS==1)
						$Item='I';
					if($CantHijosS==$ContS)
						$Item='F';
					$ContS++;						
					$Cod=$FilaS[CPARENT].$FilaS[CAREA].",";
					if($TareaVigente=='N')
						$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
					else
						$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";
					$RespA=mysql_query($Consulta);
					$CantHijosA=mysql_num_rows($RespA);$ContA=1;
					if($FilaS[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",")
						MuestraHijoNivelarea(2,$Cod,$FilaS[CTAREA],$FilaS[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
					if($LargoArreglo>2)
					{
					while($FilaA = mysql_fetch_array($RespA))	
					{			
						$Item='';
						if($CantHijosA==1)
							$Item='I';
						if($CantHijosA==$ContA)
							$Item='F';
						$ContA++;	
						$Cod=$FilaA[CPARENT].$FilaA[CAREA].",";
						if($TareaVigente=='N')
							$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
						else
							$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
						$RespP=mysql_query($Consulta);
						$CantHijosP=mysql_num_rows($RespP);$ContP=1;
						if($FilaA[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",")
							MuestraHijoNivelarea(3,$Cod,$FilaA[CTAREA],$FilaA[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
						if($LargoArreglo>3)
						{
							while($FilaP = mysql_fetch_array($RespP))	
							{			
								$Item='';
								if($CantHijosP==1)
									$Item='I';
								if($CantHijosP==$ContP)
									$Item='F';
								$ContP++;								
								$Cod=$FilaP[CPARENT].$FilaP[CAREA].",";
							}
						}
					}
					}
				}
				}
			}
		}
		//echo "</table>";
}
function MuestraHijoNivelarea($Nivel,$CodOrganica,$CodTarea,$DescripItem,$CodNavega,$Estado,$Item,$SelTarea,$Rut)
{
	if($Nivel==1&&$Rut!='')
	{
		$CodOrg=$CodOrganica;
		$CODAREA=ObtenerCodParent(&$CodOrg);
		$AccesoOrg=ObtieneAccesoOrg($Rut,$AccesoOrg);
		$CodGer=explode(',',$AccesoOrg);
		while(list($c,$v)=each($CodGer))
		{
			if($v==$CODAREA)
			{
				$Accede='S';
				break;
			}
			else
				$Accede='N';	
		}
	}
	if(($Nivel==1&&$Accede=='S') or ($Nivel!=1) or ($Rut==''))
	{
	echo "<tr>";
	$Accion='';$CodNav='';$CodOrg='';
	$Accion=explode(',',$Estado);
	$CodNav="X".$CodNavega;
	$CodOrg=$CodOrganica;
	//echo $Nivel."  -  ".$Accion[$Nivel]."  -   ".$CodNav."  -  ".$CodOrg;
	
	if(trim($Accion[$Nivel])=='A'&&strpos($CodNav,$CodOrg))
	{
		switch($Nivel)
		{
			 case "0":
			 	$Img="minus5.gif";
			 	break;
			 default:
				switch($Item)
				{
					case "I":
						$Img="minus3.gif";
						break;
					case "F":
						$Img="minus2.gif";
						break;
					default:
						$Img="minus3.gif";		
				}
		}
		if($CodTarea!='8')
		{
			$CodOrganica=substr($CodOrganica,1);
			$CodOrganica=substr($CodOrganica,0,strlen($CodOrganica)-1);
			$CodOrganica=explode(',',$CodOrganica);
			$LarArr=count($CodOrganica);$ContArr=1;$CodOrganicaAux=',';
			while(list($c,$v)=each($CodOrganica))
			{
				if($ContArr<$LarArr)
					$CodOrganicaAux=$CodOrganicaAux.$v.",";
				$ContArr++;	
			}
			$CodOrganica=$CodOrganicaAux;
		}
	}
	else
	{
		switch($Nivel)
		{
			 case "0":
			 	$Img="plus5.gif";
			 	break;
			 default:
				switch($Item)
				{
					case "I":
						$Img="plus3.gif";
						break;
					case "F":
						$Img="plus2.gif";
						break;
					default:
						$Img="plus3.gif";		
				}
		}		
	}
	if($CodTarea=='8')
		$Img="line2.gif";
	for($i=1;$i<=$Nivel;$i++)
	{
		if($i==1)
			echo "<td width='1%' align='center' valign='middle'>&nbsp;</td>";	
		else
			echo "<td width='1%' align='center' valign='middle'><img src='imagenes/line1.gif' border='0' align='absmiddle'  ></td>";
	}
	if($CodTarea=='3'||$CodTarea=='2'||$CodTarea=='1'||$CodTarea=='0')
		echo "<td width='1%' ><a href=JavaScript:BuscaHijos('".$CodOrganica."')><img src='imagenes/".$Img."' align='absmiddle' border='0' ><a/></td>";
	$CantCol=9-$Nivel;
	if($CodTarea=='8')
	{
		//echo "ORG:".$CodOrganica."<br>";
		//echo "TAR:".$SelTarea."<br>";
		if($CodOrganica==$SelTarea)
			echo "<td colspan='".$CantCol."' class='InputAzul'><a href=JavaScript:ItemSelec('".$CodOrganica."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
		//else
			//echo "<td colspan='".$CantCol."'>tt<a href=JavaScript:ItemSelec('".$CodOrganica."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
	}
	else
		if($CodOrg==$SelTarea)
			echo "<td colspan='".$CantCol."' class='InputAzul'><a href=JavaScript:ItemSelec('".$CodOrg."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
		else
			echo "<td colspan='".$CantCol."'><a href=JavaScript:ItemSelec('".$CodOrg."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";	
	echo "</tr>";
	}
}
function MuestraHijo($Nivel,$CodOrganica,$CodTarea,$DescripItem,$CodNavega,$Estado,$Item,$SelTarea,$Rut)
{
	if($Nivel==1&&$Rut!='')
	{
		$CodOrg=$CodOrganica;
		$CODAREA=ObtenerCodParent(&$CodOrg);
		$AccesoOrg=ObtieneAccesoOrg($Rut,$AccesoOrg);
		$CodGer=explode(',',$AccesoOrg);
		while(list($c,$v)=each($CodGer))
		{
			if($v==$CODAREA)
			{
				$Accede='S';
				break;
			}
			else
				$Accede='N';	
		}
	}
	if(($Nivel==1&&$Accede=='S') or ($Nivel!=1) or ($Rut==''))
	{
	echo "<tr>";
	$Accion='';$CodNav='';$CodOrg='';
	$Accion=explode(',',$Estado);
	$CodNav="X".$CodNavega;
	$CodOrg=$CodOrganica;
	//echo $Nivel."  -  ".$Accion[$Nivel]."  -   ".$CodNav."  -  ".$CodOrg;
	
	if(trim($Accion[$Nivel])=='A'&&strpos($CodNav,$CodOrg))
	{
		switch($Nivel)
		{
			 case "0":
			 	$Img="minus5.gif";
			 	break;
			 default:
				switch($Item)
				{
					case "I":
						$Img="minus3.gif";
						break;
					case "F":
						$Img="minus2.gif";
						break;
					default:
						$Img="minus3.gif";		
				}
		}
		if($CodTarea!='8')
		{
			$CodOrganica=substr($CodOrganica,1);
			$CodOrganica=substr($CodOrganica,0,strlen($CodOrganica)-1);
			$CodOrganica=explode(',',$CodOrganica);
			$LarArr=count($CodOrganica);$ContArr=1;$CodOrganicaAux=',';
			while(list($c,$v)=each($CodOrganica))
			{
				if($ContArr<$LarArr)
					$CodOrganicaAux=$CodOrganicaAux.$v.",";
				$ContArr++;	
			}
			$CodOrganica=$CodOrganicaAux;
		}
	}
	else
	{
		switch($Nivel)
		{
			 case "0":
			 	$Img="plus5.gif";
			 	break;
			 default:
				switch($Item)
				{
					case "I":
						$Img="plus3.gif";
						break;
					case "F":
						$Img="plus2.gif";
						break;
					default:
						$Img="plus3.gif";		
				}
		}		
	}
	if($CodTarea=='8')
		$Img="line2.gif";
	for($i=1;$i<=$Nivel;$i++)
	{
		if($i==1)
			echo "<td width='1%' align='center' valign='middle'>&nbsp;</td>";	
		else
			echo "<td width='1%' align='center' valign='middle'><img src='imagenes/line1.gif' border='0' align='absmiddle'  ></td>";
	}
	echo "<td width='1%' ><a href=JavaScript:BuscaHijos('".$CodOrganica."')><img src='imagenes/".$Img."' align='absmiddle' border='0' ><a/></td>";
	$CantCol=9-$Nivel;
	if($CodTarea=='8')
	{
		//echo "ORG:".$CodOrganica."<br>";
		//echo "TAR:".$SelTarea."<br>";
		if($CodOrganica==$SelTarea)
			echo "<td colspan='".$CantCol."' class='InputAzul'><a href=JavaScript:ItemSelec('".$CodOrganica."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
		else
			echo "<td colspan='".$CantCol."'><a href=JavaScript:ItemSelec('".$CodOrganica."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
	}
	else
		if($CodOrg==$SelTarea)
			echo "<td colspan='".$CantCol."' class='InputAzul'><a href=JavaScript:ItemSelec('".$CodOrg."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
		else
			echo "<td colspan='".$CantCol."'><a href=JavaScript:ItemSelec('".$CodOrg."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";	
	echo "</tr>";
	}
}
function CrearArbol2($Cod,$Estado,$SelTarea,$Rut,$TareaVigente)
{
	if($Cod=='')
		$Cod=",0,";
	$CodAux=$Cod;
	$Niveles=array('D','G','S','A','P','U','AC','O','T');
	$Organica=explode(',',$Cod);
	$LargoArreglo=count($Organica)-3;
	//echo "LARGO:".$LargoArreglo."<br><br><br>";
	//echo "<div style='position:absolute; left:2px; top:100px; width:99%; height: 482px; OVERFLOW: auto;' id='OrganicaGen'>";
	//echo "<table border='0' cellpadding='0' cellspacing='0'>";
	//$AccesoOrg=ObtieneAccesoOrg($Rut,$AccesoOrg);
	if($TareaVigente=='N')
		$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT=',".$Organica[1].",' ORDER BY CTAREA";
	else
		$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT=',".$Organica[1].",' and MVIGENTE='1'  ORDER BY CTAREA";	
	//echo $Consulta."<br>";
	$RespD=mysql_query($Consulta);
	while($FilaD=mysql_fetch_array($RespD))
	{
			$Cod=$FilaD[CPARENT].$FilaD[CAREA].",";
			if($TareaVigente=='N')		
				$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
			else
				$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
			//echo $Consulta;
			$RespG=mysql_query($Consulta);
			$CantHijosG=mysql_num_rows($RespG);$ContG=1;
			MuestraHijo2(0,$Cod,$FilaD[CTAREA],$FilaD[NAREA],$CodAux,$Estado,$CantHijosG,$SelTarea,$Rut);
			while($FilaG=mysql_fetch_array($RespG))
			{
				$Item='';
				if($CantHijosG==1)
					$Item='I';
				if($CantHijosG==$ContG)
					$Item='F';
				$ContG++;	
				$Cod=$FilaG[CPARENT].$FilaG[CAREA].",";
				if($TareaVigente=='N')	
					$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
				else
					$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
				$RespS=mysql_query($Consulta);
				$CantHijosS=mysql_num_rows($RespS);$ContS=1;
				if($FilaG[CPARENT]==",".$Organica[1].",".$Organica[2].",")
					MuestraHijo2(1,$Cod,$FilaG[CTAREA],$FilaG[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
				if($LargoArreglo>1)
				{
				while($FilaS =mysql_fetch_array($RespS))	
				{		
					$Item='';
					if($CantHijosS==1)
						$Item='I';
					if($CantHijosS==$ContS)
						$Item='F';
					$ContS++;						
					$Cod=$FilaS[CPARENT].$FilaS[CAREA].",";
					if($TareaVigente=='N')
						$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
					else
						$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";
					$RespA=mysql_query($Consulta);
					$CantHijosA=mysql_num_rows($RespA);$ContA=1;
					if($FilaS[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",")
						MuestraHijo2(2,$Cod,$FilaS[CTAREA],$FilaS[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
					if($LargoArreglo>2)
					{
					while($FilaA = mysql_fetch_array($RespA))	
					{			
						$Item='';
						if($CantHijosA==1)
							$Item='I';
						if($CantHijosA==$ContA)
							$Item='F';
						$ContA++;	
						$Cod=$FilaA[CPARENT].$FilaA[CAREA].",";
						if($TareaVigente=='N')
							$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
						else
							$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
						$RespP=mysql_query($Consulta);
						$CantHijosP=mysql_num_rows($RespP);$ContP=1;
						if($FilaA[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",")
							MuestraHijo2(3,$Cod,$FilaA[CTAREA],$FilaA[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
						if($LargoArreglo>3)
						{
						while($FilaP = mysql_fetch_array($RespP))	
						{			
							$Item='';
							if($CantHijosP==1)
								$Item='I';
							if($CantHijosP==$ContP)
								$Item='F';
							$ContP++;								
							$Cod=$FilaP[CPARENT].$FilaP[CAREA].",";
							if($TareaVigente=='N')
								$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
							else
								$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
							$RespU=mysql_query($Consulta);
							$CantHijosU=mysql_num_rows($RespU);$ContU=1;
							if($FilaP[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",".$Organica[5].",")
								MuestraHijo2(4,$Cod,$FilaP[CTAREA],$FilaP[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
							if($LargoArreglo>4)
							{
							while($FilaU = mysql_fetch_array($RespU))	
							{			
								$Item='';
								if($CantHijosU==1)
									$Item='I';
								if($CantHijosU==$ContU)
									$Item='F';
								$ContU++;	
								$Cod=$FilaU[CPARENT].$FilaU[CAREA].",";
								if($TareaVigente=='N')
									$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
								else
									$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";	
								$RespAC=mysql_query($Consulta);
								$CantHijosAC=mysql_num_rows($RespAC);$ContAC=1;
								if($FilaU[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",".$Organica[5].",".$Organica[6].",")
									MuestraHijo2(5,$Cod,$FilaU[CTAREA],$FilaU[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
								if($LargoArreglo>5)
								{
								while($FilaAC = mysql_fetch_array($RespAC))	
								{			
									$Item='';
									if($CantHijosAC==1)
										$Item='I';
									if($CantHijosAC==$ContAC)
										$Item='F';
									$ContAC++;	
									$Cod=$FilaAC[CPARENT].$FilaAC[CAREA].",";
									if($TareaVigente=='N')
										$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
									else
										$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";
									$RespO=mysql_query($Consulta);
									$CantHijosO=mysql_num_rows($RespO);$ContO=1;
									if($FilaAC[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",".$Organica[5].",".$Organica[6].",".$Organica[7].",")
										MuestraHijo2(6,$Cod,$FilaAC[CTAREA],$FilaAC[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
									if($LargoArreglo>6)
									{
									while($FilaO = mysql_fetch_array($RespO))	
									{			
										$Item='';
										if($CantHijosO==1)
											$Item='I';
										if($CantHijosO==$ContO)
											$Item='F';
										$ContO++;	
										$Cod=$FilaO[CPARENT].$FilaO[CAREA].",";
										if($TareaVigente=='N')
											$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' ORDER BY CTAREA";
										else
											$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' and MVIGENTE='1' ORDER BY CTAREA";
										$RespT=mysql_query($Consulta);
										if($FilaO[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",".$Organica[5].",".$Organica[6].",".$Organica[7].",".$Organica[8].",")
											MuestraHijo2(7,$Cod,$FilaO[CTAREA],$FilaO[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
										if($LargoArreglo>7)
										{
										while($FilaT = mysql_fetch_array($RespT))	
										{			
											$Cod=$FilaT[CPARENT].$FilaT[CAREA].",";
											if($FilaT[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",".$Organica[5].",".$Organica[6].",".$Organica[7].",".$Organica[8].",".$Organica[9].",")
											{
												//echo "CODIGO:".$Cod."<BR>";
												MuestraHijo2(8,$Cod,$FilaT[CTAREA],$FilaT[NAREA],'','','',$SelTarea,$Rut);
											}	
										}
										}
									}
									}
								}
								}
							}
							}
						}
						}
					}
					}
				}
				}
			}
		}
		//echo "</table>";
}
function MuestraHijo2($Nivel,$CodOrganica,$CodTarea,$DescripItem,$CodNavega,$Estado,$Item,$SelTarea,$Rut)
{
	if($Nivel==1&&$Rut!='')
	{
		$CodOrg=$CodOrganica;
		$CODAREA=ObtenerCodParent(&$CodOrg);
		$AccesoOrg=ObtieneAccesoOrg($Rut,$AccesoOrg);
		$CodGer=explode(',',$AccesoOrg);
		while(list($c,$v)=each($CodGer))
		{
			if($v==$CODAREA)
			{
				$Accede='S';
				break;
			}
			else
				$Accede='N';	
		}
	}
	if(($Nivel==1&&$Accede=='S') or ($Nivel!=1) or ($Rut==''))
	{
	echo "<tr>";
	$Accion='';$CodNav='';$CodOrg='';
	$Accion=explode(',',$Estado);
	$CodNav="X".$CodNavega;
	$CodOrg=$CodOrganica;
	//echo $Nivel."  -  ".$Accion[$Nivel]."  -   ".$CodNav."  -  ".$CodOrg;
	
	if(trim($Accion[$Nivel])=='A'&&strpos($CodNav,$CodOrg))
	{
		switch($Nivel)
		{
			 case "0":
			 	$Img="minus5.gif";
			 	break;
			 default:
				switch($Item)
				{
					case "I":
						$Img="minus3.gif";
						break;
					case "F":
						$Img="minus2.gif";
						break;
					default:
						$Img="minus3.gif";		
				}
		}
		if($CodTarea!='8')
		{
			$CodOrganica=substr($CodOrganica,1);
			$CodOrganica=substr($CodOrganica,0,strlen($CodOrganica)-1);
			$CodOrganica=explode(',',$CodOrganica);
			$LarArr=count($CodOrganica);$ContArr=1;$CodOrganicaAux=',';
			while(list($c,$v)=each($CodOrganica))
			{
				if($ContArr<$LarArr)
					$CodOrganicaAux=$CodOrganicaAux.$v.",";
				$ContArr++;	
			}
			$CodOrganica=$CodOrganicaAux;
		}
	}
	else
	{
		switch($Nivel)
		{
			 case "0":
			 	$Img="plus5.gif";
			 	break;
			 default:
				switch($Item)
				{
					case "I":
						$Img="plus3.gif";
						break;
					case "F":
						$Img="plus2.gif";
						break;
					default:
						$Img="plus3.gif";		
				}
		}		
	}
	if($CodTarea=='8')
		$Img="line2.gif";
	for($i=1;$i<=$Nivel;$i++)
	{
		if($i==1)
			echo "<td width='1%' align='center' valign='middle'>&nbsp;</td>";	
		else
			echo "<td width='1%' align='center' valign='middle'><img src='imagenes/line1.gif' border='0' align='absmiddle'  ></td>";
	}
	echo "<td width='1%' ><a href=JavaScript:BuscaHijos2('".$CodOrganica."')><img src='imagenes/".$Img."' align='absmiddle' border='0' ><a/></td>";
	$CantCol=9-$Nivel;
	if($CodTarea=='8')
	{
		//echo "ORG:".$CodOrganica."<br>";
		//echo "TAR:".$SelTarea."<br>";
		if($CodOrganica==$SelTarea)
			echo "<td colspan='".$CantCol."' class='InputAzul'><a href=JavaScript:ItemSelec2('".$CodOrganica."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
		else
			echo "<td colspan='".$CantCol."'><a href=JavaScript:ItemSelec2('".$CodOrganica."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
	}
	else
		if($CodOrg==$SelTarea)
			echo "<td colspan='".$CantCol."' class='InputAzul'><a href=JavaScript:ItemSelec2('".$CodOrg."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
		else
			echo "<td colspan='".$CantCol."'><a href=JavaScript:ItemSelec2('".$CodOrg."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
			
	echo "</tr>";
	}
}

function DescripOrganica($Cod,$Tipo)
{
	$Gerencias='';
	if($Cod!='')
	{
		switch($Tipo)
		{
			case "T":
				$Codigo=ObtenerCodParent($Cod);
				break;
			case "G":	
				$Codigo=$Cod;
				break;
		}
		$Consulta="SELECT NAREA from sgrs_areaorg where CAREA IN(".$Codigo.")";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			$Gerencias=$Gerencias.$Fila[NAREA].', ';
		}
		$Gerencias=substr($Gerencias,0,strlen($Gerencias)-2);
	}
	return($Gerencias);	

}
function DescripOrganica2($Cod)
{
	$Descrip='';
	if($Cod!='')
	{
		$Codigo=ObtenerCodParent($Cod);
		$Consulta="SELECT NAREA,CTAREA from sgrs_areaorg where CAREA = '".$Codigo."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			switch($Fila[CTAREA])
			{
				case "0":
					$Tipo="Divisi�n";
				break;
				case "1":
					$Tipo="Gerencia";
				break;
				case "2":
					$Tipo="SuperIntendencia";
				break;
				case "3":
					$Tipo="Area";
				break;
				case "4":
					$Tipo="Proceso";
				break;
				case "5":
					$Tipo="Unidad";
				break;
				case "6":
					$Tipo="Actividad";
				break;
				case "7":
					$Tipo="Operacion";
				break;
				case "8":
					$Tipo="Tarea";
				break;				
																												
			}
			$Descrip="<label class='InputAzul'>".$Tipo."&nbsp;<img src='imagenes/vineta.gif' border='0'>&nbsp;".$Fila[NAREA]."</label>";
		}
	}
	return($Descrip);	

}
function DescripOrganica4($Cod)//SIN FLECHA DE IMAGEN EN ENVIO DE CORREO
{
	$Descrip='';
	if($Cod!='')
	{
		$Codigo=ObtenerCodParent($Cod);
		$Consulta="SELECT NAREA,CTAREA from sgrs_areaorg where CAREA = '".$Codigo."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			switch($Fila[CTAREA])
			{
				case "0":
					$Tipo="Divisi�n";
				break;
				case "1":
					$Tipo="Gerencia";
				break;
				case "2":
					$Tipo="SuperIntendencia";
				break;
				case "3":
					$Tipo="Area";
				break;
				case "4":
					$Tipo="Proceso";
				break;
				case "5":
					$Tipo="Unidad";
				break;
				case "6":
					$Tipo="Actividad";
				break;
				case "7":
					$Tipo="Operacion";
				break;
				case "8":
					$Tipo="Tarea";
				break;				
																												
			}
			$Descrip="<label class='InputAzul'>".$Tipo."&nbsp;->&nbsp;".$Fila[NAREA]."</label>";
		}
	}
	return($Descrip);	

}
function DescripOrganicaHi($Cod)
{
	$Descrip='';
	if($Cod!='')
	{
		$Codigo=$Cod;
		$Consulta="SELECT NAREA,CTAREA from sgrs_areaorg where CAREA = '".$Codigo."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			switch($Fila[CTAREA])
			{
				case "0":
					$Tipo="Divisi�n";
				break;
				case "1":
					$Tipo="Gerencia";
				break;
				case "2":
					$Tipo="SuperIntendencia";
				break;
				case "3":
					$Tipo="Area";
				break;
				case "4":
					$Tipo="Proceso";
				break;
				case "5":
					$Tipo="Unidad";
				break;
				case "6":
					$Tipo="Actividad";
				break;
				case "7":
					$Tipo="Operacion";
				break;
				case "8":
					$Tipo="Tarea";
				break;				
																												
			}
			$Descrip="<label class='InputAzul'>".$Tipo."&nbsp;<img src='imagenes/vineta.gif' border='0'>&nbsp;".$Fila[NAREA]."</label>";
		}
	}
	return($Descrip);	

}

function DescripOrganica3($Codigo)
{
	$Descrip='';
	if($Codigo!='')
	{
		$Consulta="SELECT NAREA from sgrs_areaorg where CAREA = '".$Codigo."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);
		$Descrip=$Fila[NAREA];
	}
	return($Descrip);				
}
function CrearArbolHI($Cod,$Estado,$SelTarea,$Rut)
{
	if($Cod=='')
		$Cod=",0,";
	$CodAux=$Cod;
	$Niveles=array('D','G','S','A','P','U','AC','O','T');
	$Organica=explode(',',$Cod);
	$LargoArreglo=count($Organica)-3;
	//echo "LARGO:".$LargoArreglo."<br><br><br>";
	//echo "<div style='position:absolute; left:2px; top:100px; width:99%; height: 482px; OVERFLOW: auto;' id='OrganicaGen'>";
	//echo "<table border='0' cellpadding='0' cellspacing='0'>";
	//$AccesoOrg=ObtieneAccesoOrg($Rut,$AccesoOrg);
	$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT=',".$Organica[1].",' AND CTAREA NOT IN ('7','8') ORDER BY CTAREA";
	//echo $Consulta."<br>";
	$RespD=mysql_query($Consulta);
	while($FilaD=mysql_fetch_array($RespD))
	{
			$Cod=$FilaD[CPARENT].$FilaD[CAREA].",";
					
			$Consulta="SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' AND CTAREA NOT IN ('7','8') ORDER BY CTAREA";
			//echo $Consulta;
			$RespG=mysql_query($Consulta);
			$CantHijosG=mysql_num_rows($RespG);$ContG=1;
			MuestraHijoHI(0,$Cod,$FilaD[CTAREA],$FilaD[NAREA],$CodAux,$Estado,$CantHijosG,$SelTarea,$Rut);
			while($FilaG=mysql_fetch_array($RespG))
			{
				$Item='';
				if($CantHijosG==1)
					$Item='I';
				if($CantHijosG==$ContG)
					$Item='F';
				$ContG++;	
				$Cod=$FilaG[CPARENT].$FilaG[CAREA].",";
				$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' AND CTAREA NOT IN ('7','8') ORDER BY CTAREA";
				$RespS=mysql_query($Consulta);
				$CantHijosS=mysql_num_rows($RespS);$ContS=1;
				if($FilaG[CPARENT]==",".$Organica[1].",".$Organica[2].",")
					MuestraHijoHI(1,$Cod,$FilaG[CTAREA],$FilaG[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
				if($LargoArreglo>1)
				{
				while($FilaS =mysql_fetch_array($RespS))	
				{		
					$Item='';
					if($CantHijosS==1)
						$Item='I';
					if($CantHijosS==$ContS)
						$Item='F';
					$ContS++;						
					$Cod=$FilaS[CPARENT].$FilaS[CAREA].",";
					$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' AND CTAREA NOT IN ('7','8') ORDER BY CTAREA";
					$RespA=mysql_query($Consulta);
					$CantHijosA=mysql_num_rows($RespA);$ContA=1;
					if($FilaS[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",")
						MuestraHijoHI(2,$Cod,$FilaS[CTAREA],$FilaS[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
					if($LargoArreglo>2)
					{
					while($FilaA = mysql_fetch_array($RespA))	
					{			
						$Item='';
						if($CantHijosA==1)
							$Item='I';
						if($CantHijosA==$ContA)
							$Item='F';
						$ContA++;	
						$Cod=$FilaA[CPARENT].$FilaA[CAREA].",";
						$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' AND CTAREA NOT IN ('7','8') ORDER BY CTAREA";
						$RespP=mysql_query($Consulta);
						$CantHijosP=mysql_num_rows($RespP);$ContP=1;
						if($FilaA[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",")
							MuestraHijoHI(3,$Cod,$FilaA[CTAREA],$FilaA[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
						if($LargoArreglo>3)
						{
						while($FilaP = mysql_fetch_array($RespP))	
						{			
							$Item='';
							if($CantHijosP==1)
								$Item='I';
							if($CantHijosP==$ContP)
								$Item='F';
							$ContP++;								
							$Cod=$FilaP[CPARENT].$FilaP[CAREA].",";
							$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' AND CTAREA NOT IN ('7','8') ORDER BY CTAREA";
							$RespU=mysql_query($Consulta);
							$CantHijosU=mysql_num_rows($RespU);$ContU=1;
							if($FilaP[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",".$Organica[5].",")
								MuestraHijoHI(4,$Cod,$FilaP[CTAREA],$FilaP[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
							if($LargoArreglo>4)
							{
								while($FilaU = mysql_fetch_array($RespU))	
								{			
									$Item='';
									if($CantHijosU==1)
										$Item='I';
									if($CantHijosU==$ContU)
										$Item='F';
									$ContU++;	
									$Cod=$FilaU[CPARENT].$FilaU[CAREA].",";
									$Consulta = "SELECT CAREA,CTAREA,CPARENT,NAREA from sgrs_areaorg where CPARENT='".$Cod."' AND CTAREA NOT IN ('7','8') ORDER BY CTAREA";
									$RespAC=mysql_query($Consulta);
									$CantHijosAC=mysql_num_rows($RespAC);$ContAC=1;
									if($FilaU[CPARENT]==",".$Organica[1].",".$Organica[2].",".$Organica[3].",".$Organica[4].",".$Organica[5].",".$Organica[6].",")
										MuestraHijoHI(5,$Cod,$FilaU[CTAREA],$FilaU[NAREA],$CodAux,$Estado,$Item,$SelTarea,$Rut);
								}
							}
						}
						}
					}
					}
				}
				}
			}
		}
		//echo "</table>";
}
function MuestraHijoHI($Nivel,$CodOrganica,$CodTarea,$DescripItem,$CodNavega,$Estado,$Item,$SelTarea,$Rut)
{
	if($Nivel==1&&$Rut!='')
	{
		$CodOrg=$CodOrganica;
		$CODAREA=ObtenerCodParent(&$CodOrg);
		$AccesoOrg=ObtieneAccesoOrg($Rut,$AccesoOrg);
		$CodGer=explode(',',$AccesoOrg);
		while(list($c,$v)=each($CodGer))
		{
			if($v==$CODAREA)
			{
				$Accede='S';
				break;
			}
			else
				$Accede='N';	
		}
	}
	if(($Nivel==1&&$Accede=='S') or ($Nivel!=1) or ($Rut==''))
	{
	echo "<tr>";
	$Accion='';$CodNav='';$CodOrg='';
	$Accion=explode(',',$Estado);
	$CodNav="X".$CodNavega;
	$CodOrg=$CodOrganica;
	//echo $Nivel."  -  ".$Accion[$Nivel]."  -   ".$CodNav."  -  ".$CodOrg;
	
	if(trim($Accion[$Nivel])=='A'&&strpos($CodNav,$CodOrg))
	{
		switch($Nivel)
		{
			 case "0":
			 	$Img="minus5.gif";
			 	break;
			 default:
				switch($Item)
				{
					case "I":
						$Img="minus3.gif";
						break;
					case "F":
						$Img="minus2.gif";
						break;
					default:
						$Img="minus3.gif";		
				}
		}
		if($CodTarea!='5')
		{
			$CodOrganica=substr($CodOrganica,1);
			$CodOrganica=substr($CodOrganica,0,strlen($CodOrganica)-1);
			$CodOrganica=explode(',',$CodOrganica);
			$LarArr=count($CodOrganica);$ContArr=1;$CodOrganicaAux=',';
			while(list($c,$v)=each($CodOrganica))
			{
				if($ContArr<$LarArr)
					$CodOrganicaAux=$CodOrganicaAux.$v.",";
				$ContArr++;	
			}
			$CodOrganica=$CodOrganicaAux;
		}
	}
	else
	{
		switch($Nivel)
		{
			 case "0":
			 	$Img="plus5.gif";
			 	break;
			 default:
				switch($Item)
				{
					case "I":
						$Img="plus3.gif";
						break;
					case "F":
						$Img="plus2.gif";
						break;
					default:
						$Img="plus3.gif";		
				}
		}		
	}
	if($CodTarea=='5')
		$Img="line2.gif";
	for($i=1;$i<=$Nivel;$i++)
	{
		if($i==1)
			echo "<td width='1%' align='center' valign='middle'>&nbsp;</td>";	
		else
			echo "<td width='1%' align='center' valign='middle'><img src='imagenes/line1.gif' border='0' align='absmiddle'  ></td>";
	}
	echo "<td width='1%' ><a href=JavaScript:BuscaHijos('".$CodOrganica."')><img src='imagenes/".$Img."' align='absmiddle' border='0' ><a/></td>";
	$CantCol=6-$Nivel;
	if($CodTarea=='5')
	{
		//echo "ORG:".$CodOrganica."<br>";
		//echo "TAR:".$SelTarea."<br>";
		if($CodOrganica==$SelTarea)
			echo "<td colspan='".$CantCol."' class='InputAzul'><a href=JavaScript:ItemSelec('".$CodOrganica."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
		else
			echo "<td colspan='".$CantCol."'><a href=JavaScript:ItemSelec('".$CodOrganica."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0' ><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
	}
	else
		if($CodOrg==$SelTarea)
			echo "<td colspan='".$CantCol."' class='InputAzul'><a href=JavaScript:ItemSelec('".$CodOrg."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0'><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
		else
			echo "<td colspan='".$CantCol."'><a href=JavaScript:ItemSelec('".$CodOrg."')><img src='imagenes/nivel_".$CodTarea.".gif' align='absmiddle'  border='0'><a/>".str_replace('-','&minus;',str_replace(' ','&nbsp;',strtoupper($DescripItem)))."</td>";
			
	echo "</tr>";
	}
}
function FormatoFechaAAAAMMDD($FechaReal)
{

	if($FechaReal!='')
	{
		$Datos = explode("/",$FechaReal);
		$Dia=$Datos[2];
		$Mes=$Datos[1];
		$A�o=$Datos[0];
		$FechaFormat=$Dia.'-'.$Mes.'-'.$A�o;
	}
	else
		$FechaFormat='0000-00-00';
	return ($FechaFormat);
}
function FormatoFechaDDMMAAAA($FechaReal)
{

	if($FechaReal!='')
	{
		$Datos = explode("-",$FechaReal);
		$Dia=$Datos[2];
		$Mes=$Datos[1];
		$A�o=$Datos[0];
		$FechaFormat=$Dia.'/'.$Mes.'/'.$A�o;
	}
	else
		$FechaFormat='00/00/0000';
	return ($FechaFormat);
}

function ValidaEntero($Cod)
{
	if($Cod=='S'||$Cod=='')
		$Cod=0;
	else
		$Cod=$Cod;	
	return($Cod);
}
function RegistroHi($Codigo,$Rut,$Accion,$Cod)
{
	switch($Accion)
	{
		case "EMP"://ELIMINAR MEDICION PERSONAL
			$Consulta="SELECT * from sgrs_medpersonales where CMEDPERSONAL='".$Cod."'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
			$Obs=$Fila[CMEDPERSONAL].", ".$Fila[QMEDICION].", ".$Fila[QMR].", ".$Fila[QDOSIS].", ".$Fila[CRUT].", ".$Fila[CAGENTE];
		break;
		case "EMA"://ELIMINAR MEDICION AMBIENTALES
			$Consulta="SELECT * from sgrs_medambientes where CMEDAMB='".$Cod."'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
			$Obs=$Fila[CMEDAMB].", ".$Fila[QMEDICION].", ".$Fila[QMR].", ".$Fila[CAREA].", ".$Fila[CLUGAR].", ".$Fila[CAGENTE];
		break;
		case "EEL"://ELIMINAR EXAMENES DE LABORATORIO
			$Consulta="SELECT * from sgrs_exlaboratorio where CEXAMEN='".$Cod."'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
			$Obs=$Fila[CEXAMEN].", ".$Fila[QVALOR].", ".$Fila[QPERIODICIDAD].", ".$Fila[CEVALUACION].", ".$Fila[FEXAMEN].", ".$Fila[CRUT];
		break;
		case "ELUG"://ELIMINAR LUGAR MEDICION
			$Consulta="SELECT * from sgrs_lugares where CLUGAR='".$Cod."'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
			$Obs=$Fila[CLUGAR].", ".$Fila[NLUGAR].", ".$Fila[CCORDX].", ".$Fila[CCORDY].", ".$Fila[CCORDZ].", ".$Fila[CAREA];
		break;
	}
	
	$Insertar="INSERT INTO sgrs_registro_hi(CCOD,CRUT,FECHAHORA,CACCION,TOBSERVACION) values(".$Codigo.",'".$Rut."','".date('Y-m-d G:i:s')."','".$Accion."','".$Obs."')";
	mysql_query($Insertar);
	//echo $Insertar;

}
function RegistroSiper($Codigo,$Rut,$Accion,$Cod)
{
	switch($Accion)
	{
		case "MP"://MODIFICAR CONTACTOS/PELIGROS
				$Insertar="INSERT INTO sgrs_registro_siper(CCOD,CRUT,FECHAHORA,CACCION,TOBSERVACION) values(".$Codigo.",'".$Rut."','".date('Y-m-d G:i:s')."','".$Accion."','".$Cod."')";
				//echo $Insertar;
				mysql_query($Insertar);				
		break;
		case "GC"://GRABAR CONTROLES
				$Insertar="INSERT INTO sgrs_registro_siper(CCOD,CRUT,FECHAHORA,CACCION,TOBSERVACION) values(".$Codigo.",'".$Rut."','".date('Y-m-d G:i:s')."','".$Accion."','".$Cod."')";
				//echo $Insertar;
				mysql_query($Insertar);				
		break;
		case "MC"://MODIFICAR CONTROLES
				$Insertar="INSERT INTO sgrs_registro_siper(CCOD,CRUT,FECHAHORA,CACCION,TOBSERVACION) values(".$Codigo.",'".$Rut."','".date('Y-m-d G:i:s')."','".$Accion."','".$Cod."')";
				//echo $Insertar;
				mysql_query($Insertar);				
		break;
		case "EC"://MODIFICAR CONTROLES
				$Insertar="INSERT INTO sgrs_registro_siper(CCOD,CRUT,FECHAHORA,CACCION,TOBSERVACION) values(".$Codigo.",'".$Rut."','".date('Y-m-d G:i:s')."','".$Accion."','".$Cod."')";
				//echo $Insertar;
				mysql_query($Insertar);				
		break;
		case "ECT"://ELIMINAR CONTROLES TODOS
			$Consulta="SELECT * from sgrs_sipercontroles where CPELIGRO='".$Cod."'";
			$Resp=mysql_query($Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$Obs=$Fila[CPELIGRO].",".$Fila[CCONTACTO].",".$Fila[CCONTROL].",".$Fila[MCONTROL].",".$Fila[MCONTROLH].",".$Fila[CAREA];
				$Insertar="INSERT INTO sgrs_registro_siper(CCOD,CRUT,FECHAHORA,CACCION,TOBSERVACION) values(".$Codigo.",'".$Rut."','".date('Y-m-d G:i:s')."','".$Accion."','".$Obs."')";
				//echo $Insertar;
				mysql_query($Insertar);				
			}	
		break;
	}
	
}
function ObtieneNivelUsuario($RutUsuario)
{
	$Consulta ="SELECT nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$RutUsuario."' and cod_sistema =29";
	$Respuesta = mysql_query($Consulta);
	$Fila=mysql_fetch_array($Respuesta);
	$Nivel=$Fila["nivel"];  		
	return ($Nivel);
}

?>
