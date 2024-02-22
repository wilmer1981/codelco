<?
	function EncabezadoPagina($IP_SERV,$Imagen)
	{
		include("encabezado.php")?>
		 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
		 <tr> 
		 <td width="958" valign="top">
		 <table width="760" border="0" cellspacing="0" cellpadding="0" >
			<tr>
			  <td height="30" align="right" >
			  <table width="770" class="TablaPrincipal2">
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
						<a href="Manual_Usuario_pcip.pdf"  target="_blank"><img src="archivos/acrobat.png" alt='Manual de Usuario' width="20" height="20" border="0"></a>
					    </td>
					</tr>
				</table></td>
			</tr>
		  </table>
	
	<?
	}
	function DatosCC($Cod)
	{
		$Consulta="select * from pcip_eec_centro_costos where cod_cc='".$Cod."' ";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Datos=$Fila[cod_gerencia].'~'.$Fila[cod_area].'~'.$Fila[descrip_area].'~'.$Fila[cod_cc].'~'.$Fila["abreviatura"];
		return($Datos);	
	}
	function DatosSumistros($Cod)
	{
		$Consulta="select * from pcip_eec_suministros where cod_suministro='".$Cod."' ";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Datos=$Fila[cod_suministro].'~'.$Fila[nom_suministro].'~'.$Fila[cod_unidad];
		return($Datos);	
	}
	function DatosListaExcel($Cod)
	{
		$Consulta="select * from pcip_lista_excel where cod_excel='".$Cod."' ";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Datos=$Fila[cod_excel].'~'.$Fila[nom_excel].'~'.$Fila[perfiles_accesos].'~'.$Fila[valor].'~'.$Fila[ini_fil_cc].'~'.$Fila[ini_col_cc].'~'.$Fila[hoja].'~'.$Fila[tipo_excel].'~'.$Fila[corta_mes].'~'.$Fila[tipo_carga];
		return($Datos);	
	}

	function CierreEncabezado()
	{
		?>
		</td>
    	</tr>
  		</table>
		<? include("pie_pagina.php");
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
		$Resp=mysql_query($Consulta);
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
				  list($dia1,$mes1,$a�o1)=split("-",$fecha1);
		  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
				  list($dia1,$mes1,$a�o1)=split("-",$fecha1);
		  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
				  list($dia2,$mes2,$a�o2)=split("-",$fecha2);
		  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
				  list($dia2,$mes2,$a�o2)=split("-",$fecha2);
		  $dif = mktime(0,0,0,$mes1,$dia1,$a�o1,1) - mktime(0,0,0,$mes2,$dia2,$a�o2,1);
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
	
?>