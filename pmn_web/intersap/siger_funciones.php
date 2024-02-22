<?php
function SigerLiqHistoricas($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="SigerFileLiqHistoricas.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons = "select t1.fecha, t1.rut, t1.rol, t1.TOT_HAB, t1.LEY_SOCIAL, t1.IMP_UNIC, t1.LIQ_GAN, ";
	//$FunCons.= " t1.TOT_IMP, t1.TOT_TRIB, t1.TOT_DESC, t1.LIQ_PAGO, t2.IMP_MEN_ANUAL ";
	$FunCons.= " t1.TOT_IMP, t1.TOT_TRIB, t1.TOT_DESC, t1.LIQ_PAGO ";
	$FunCons.= " from interfaces_sap.siger_hist_liq t1 ";//left join interfaces_sap.siger_imp_anuales t2 on t1.rol=t2.rol and t1.rut=t2.rut and t1.fecha=t2.fecha ";
	$FunCons.= " order by t1.fecha, t1.rol, t1.rut ";
	$FunResp=mysqli_query($link, $FunCons);
	//echo $FunCons;
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$Indice=$FunFila["fecha"].$FunFila["rut"];
		for ($i=1;$i<=10;$i++)
		{
			if($i=='3')
			{
				if($FunFila["IMP_UNIC"]=='0')
					$i=$i+1;
			}
			
			switch ($i)
			{
				case 1:
					$Clave="HC09";
					$Valor=$FunFila["TOT_HAB"];
					break;
				case 2:
					$Clave="DC05";
					$Valor=$FunFila["LEY_SOCIAL"];
					break;
				case 3:
					$Clave="DL10";
					$Valor=$FunFila["IMP_UNIC"];
					break;
				case 4:
					$Clave="DC11";
					$Valor=$FunFila["LIQ_GAN"];
					break;
				case 5:
					$Clave="DC03";
					$Valor=$FunFila["TOT_IMP"];
					break;
				case 6:
					$Clave="DC04";
					$Valor=$FunFila["TOT_TRIB"];
					break;
				case 7:
					$Clave="DC10";
					$Valor=$FunFila["TOT_DESC"];
					break;
				case 8:
					$Clave="DC12";
					$Valor=$FunFila["LIQ_PAGO"];
					break;
				case 9:
					$Clave="DC00";
					//DL10 + DC05 + DC10
					$Valor=$FunFila["IMP_UNIC"] + $FunFila["LEY_SOCIAL"] + $FunFila["TOT_DESC"];
					break;
				case 10:
					$Clave="DC08";
					$Valor=$FunFila["TOT_HAB"];
					break;
				/*case 11:
					/*$Clave="DC02";
					$Valor=$FunFila["IMP_MEN_ANUAL"];
					break;*/
			}
			$CodConcepto="LIM".strtoupper($FunFila["rol"]);			
			$Indice=str_pad($i,2,'0',STR_PAD_LEFT).$FunFila["fecha"].$FunFila["rut"];
			$ArrValores[$Indice][1]=$CodConcepto;  //COD_CONCEPTO (LIMA, LIMB)					
			$ArrValores[$Indice][2]=str_replace("-","",$FunFila["rut"]); //RUT       
			$ArrValores[$Indice][3]=$Clave; //COD_CLAVE (CC-Nomina)
			$ArrValores[$Indice][4]="1";   //COD_VALOR (1=valor en si, 2=Cantidad)
			$ArrValores[$Indice][5]=$FunFila["fecha"];   //FECHA (Ultimo d�a del mes de carga)
			$ArrValores[$Indice][6]=$Valor;//VALOR
		}
	}
	//RUT NOT NULL NUMBER(8) /* 8 Enteros; Ajustado a la Derecha; Rellenado a la Izquierda con Ceros; Sin Puntos */
	//CODIGO_CLAVE NOT NULL VARCHAR2(4) /* Cuatro caracteres ajustado a la Derecha */
	//CODIGO_VALOR NOT NULL NUMBER(3) /* 3 Enteros; Ajustado a la Derecha; Rellenado a la Izquierda con Ceros; Sin Puntos; Sin Coma; Puede ser �1� si es Valor Final, �2� si es Cantidad o �3� si es Porcentaje */
	//FECHA NOT NULL DATE /* DDMMAAAA DD:D�a M: Mes AAAA: Anho */
	//CODIGO_CONCEPTO  NOT NULL VARCHAR2(4) /* Cuatro caracteres ajustado a la Derecha */
	//VALOR  NOT NULL NUMBER(13,4) /* 9 Enteros y 4 Decimales; Ajustado a la Derecha; Rellenado a la Izquierda con Ceros; Sin Puntos; Sin Coma */
	//CreaArchivo("SigerLiqHist", $NomArchivo, "generados/siger", $ArrValores);
	$Archivo = fopen("generados/siger/".$NomArchivo,"w+");
	while (list($k,$v)=each($ArrValores))
	{
		$Rut=str_pad($v[2],9,"0",STR_PAD_LEFT);
		$Rut=substr($Rut,0,8);	
		//echo $FunFila["rut"]." --> ".$Rut."<br>";
		$Valor=str_replace(",",".",$v[6]);
		$Valor=number_format($Valor,4,".","");	
		$Valor=str_replace(".","",$Valor);
		$Valor = str_pad($Valor,13,"0",STR_PAD_LEFT);
		
		$Linea=str_pad($Rut,8,"0",STR_PAD_LEFT).str_pad($v[3],4," ",STR_PAD_LEFT).str_pad($v[4],3,"0",STR_PAD_LEFT).$v[5].str_pad($v[1],4," ",STR_PAD_LEFT).str_pad($Valor,13,"0",STR_PAD_LEFT);
		fwrite($Archivo,$Linea."\r\n");
	}
	fclose($Archivo);
}

function SigerLiqHistoricasDet($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="SigerFileLiqHistoricasDet.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons = "select rol, fecha, rut, codhab, Clave, F, corhaber, sum(mtocalc*1) as mtocalc, sum(replace(indhab,',','.')*1) as indhab, unidad ";
	$FunCons.= " from interfaces_sap.siger_det_liq ";
	$FunCons.= " group by rut, rol, fecha, Clave ";
	$FunCons.= " order by fecha, rol, rut ";
	#$FunCons.= " limit 0,35000";
	$FunResp=mysqli_query($link, $FunCons);
	$i=1;
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		if ($FunFila["Clave"]!="0" && $FunFila["Clave"]!="")
		{
			$Indice=$FunFila["fecha"].$FunFila["rut"];
			$CodConcepto="LIM".strtoupper($FunFila["rol"]);			
			$Valor=$FunFila["mtocalc"];
			//VALOR
			//$Indice="0000".$FunFila["fecha"].$FunFila["rut"];
			$Indice=$i;			
			$ArrValores[$Indice][1]=substr($FunFila["rut"], 0, strlen($FunFila["rut"]-2)); //RUT       
			$ArrValores[$Indice][2]=$FunFila["Clave"]; //COD_CLAVE (CC-Nomina)
			$ArrValores[$Indice][3]="1";   //COD_VALOR (1=valor en si, 2=Cantidad)
			$ArrValores[$Indice][4]=$FunFila["fecha"];   //FECHA (Ultimo d�a del mes de carga)
			$ArrValores[$Indice][5]=$CodConcepto;  //COD_CONCEPTO (LIMA, LIMB)
			$ArrValores[$Indice][6]=$Valor;//VALOR
			//CANTIDAD
			$i++;
			$Indice=$i;
			$Valor=$FunFila["indhab"];
			//$Indice="0001".$FunFila["fecha"].$FunFila["rut"];			
			$ArrValores[$Indice][1]=substr($FunFila["rut"], 0, strlen($FunFila["rut"]-2)); //RUT     
			$ArrValores[$Indice][2]=$FunFila["Clave"]; //COD_CLAVE (CC-Nomina)
			$ArrValores[$Indice][3]="2";   //COD_VALOR (1=valor en si, 2=Cantidad)
			$ArrValores[$Indice][4]=$FunFila["fecha"];   //FECHA (Ultimo d�a del mes de carga)
			$ArrValores[$Indice][5]=$CodConcepto;  //COD_CONCEPTO (LIMA, LIMB)
			$ArrValores[$Indice][6]=$Valor;//VALOR
			$i++;
		}
		//echo "CANT REG=".$i++;
	}
	CreaArchivo("SigerLiqHist", $NomArchivo, "generados/siger", $ArrValores);
}
function SigerCreaArchivoLicenciasMedicas($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="SigerFileLicenciasMedicas.txt";
	$ArrValores=array();
	$i=1;
	$Consulta=" select t1.rut,t1.num_licencia,t1.estado ,";
	$Consulta.="  t1.tipo_profesional,t1.rut_profesional,t1.nombre_profesional, ";
	$Consulta.=" t1.fecha_emision,t1.fecha_inicio,t1.fecha_termino,t1.cantidad_dias,t2.sub_tipo as subt "; 
	$Consulta.="  from siger_licencias t1 inner join siger_tipo_licencias t2 on ";
	$Consulta.=" t1.sub_tipo=t2.cod_tipo ";
	//echo $Consulta;
	$Respuesta=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$ArrValores[$i][1]=""; //NumeroPersonal
		$ArrValores[$i][2]=str_replace("-","",$Fila["rut"]); //Rut
		$ArrValores[$i][3]=$Fila["subt"]; //SubTipo
		$ArrValores[$i][4]=$Fila["num_licencia"]; //NumCaso/NumLicencia
		$ArrValores[$i][5]=""; //FechaModificacion
		$ArrValores[$i][6]=$Fila["estado"]; //EstadoLicencia
		$ArrValores[$i][7]="Autorizada"; //Descripcion
		$ArrValores[$i][8]=$Fila["tipo_profesional"]; //TipoProfesional
		$ArrValores[$i][9]=str_replace("-","",$Fila["rut_profesional"]); //RutProfesional
		$ArrValores[$i][10]=$Fila["nombre_profesional"]; //NombreProfesional
		$ArrValores[$i][11]=str_replace("/","",$Fila["fecha_emision"]); //FechaEmisionLicencia
		$ArrValores[$i][12]=""; //FechaRecepcionIsapre
		$ArrValores[$i][13]=""; //FechaNotificacion
		$ArrValores[$i][14]=""; //CantidaddeDias
    	$ArrValores[$i][15]=str_replace("/","",$Fila["fecha_inicio"]); //FechaInicio
		$ArrValores[$i][16]=str_replace("/","",$Fila["fecha_termino"]);//FechaTermino
		$ArrValores[$i][17]=$Fila["cantidad_dias"];; //CantidadDias
		$ArrValores[$i][18]=""; //FechaInicioMod
		$ArrValores[$i][19]=""; //FechaTerminoMod
		$i++;
	}
	CreaArchivo("SigerLicencias", $NomArchivo, "generados/siger", $ArrValores);
}	
function SigerCreaArchivoCtasCtesEmpresa($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="SigerFileCtasCtesEmpresa.txt";
	$ArrValores=array();
	$i=1;
	$cantidad=0;
	$Corr=0;
	/*$Consulta="select * from siger_cuentas_corrientes ORDER BY";//ESTO ES SOLO PARA REGISTRO REPETIDOS EN CORRELATIVO
	$Consulta.=" RUT,CODIGO_DESCUENTO ";
	$Respuesta=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		if (($Fila[RUT]!=$RutAnt) || ($Fila[CODIGO_DESCUENTO]!=$CodAnt))
		{
			$Corr=1;
			$Actualizar="UPDATE siger_cuentas_corrientes set CORRELATIVO='".$Corr."' ";
			$Actualizar.="	where RUT='".$Fila["RUT"]."' AND CODIGO_DESCUENTO='".$Fila["CODIGO_DESCUENTO"]."' and  ";
			$Actualizar.=" CORRELATIVO='".$Fila["CORRELATIVO"]."' and FECHA_DEUDA='".$Fila["FECHA_DEUDA"]."' AND ";
			$Actualizar.="	MONTO_INICIAL='".$Fila["MONTO_INICIAL"]."'";
			mysqli_query($link, $Actualizar);
		}
		else{
			if (($Fila[RUT]!=$RutAnt) || ($Fila[CODIGO_DESCUENTO]!=$CodAnt))
			{
				$Corr=1;
				$Actualizar="UPDATE siger_cuentas_corrientes set CORRELATIVO='".$Corr."' ";
				$Actualizar.="	where RUT='".$Fila["RUT"]."' AND CODIGO_DESCUENTO='".$Fila["CODIGO_DESCUENTO"]."' and  ";
				$Actualizar.=" CORRELATIVO='".$Fila["CORRELATIVO"]."' and FECHA_DEUDA='".$Fila["FECHA_DEUDA"]."' AND ";
				$Actualizar.="	MONTO_INICIAL='".$Fila["MONTO_INICIAL"]."'";
				mysqli_query($link, $Actualizar);
			}
			else{
				$Corr++;//ACTUALIZA EL CORRELATIVO YA QUE VIENE REPETIDO DESDE EL ARCHIVO DE ORIGEN
				$Actualizar="UPDATE siger_cuentas_corrientes set CORRELATIVO='".$Corr."' ";
				$Actualizar.="	where RUT='".$Fila["RUT"]."' AND CODIGO_DESCUENTO='".$Fila["CODIGO_DESCUENTO"]."' and  ";
				$Actualizar.=" CORRELATIVO='".$Fila["CORRELATIVO"]."' and FECHA_DEUDA='".$Fila["FECHA_DEUDA"]."' AND ";
				$Actualizar.="	MONTO_INICIAL='".$Fila["MONTO_INICIAL"]."'";
				mysqli_query($link, $Actualizar);
			}
		}
		$RutAnt=$Fila["RUT"];
		$CodAnt=$Fila["CODIGO_DESCUENTO"];
	}*/
	$Consulta="select * from siger_cuentas_corrientes ORDER BY";
	$Consulta.=" RUT,CODIGO_DESCUENTO,CORRELATIVO ";
	$Respuesta=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$ArrValores[$i][1]=substr(str_pad($Fila["RUT"],10,'0',l_pad),0,8); //rut
		/*HOMOLOGACION DE CODIGO DESCUENTO EN ULTIMA CARGA DON CLAUDIO ENVIO EL ARCHIVO HOMOLOGADO
		$Consulta="select * from hr_homologa_emolumentos where ";
		$Consulta.=" codigo='".$Fila["CODIGO_DESCUENTO"]."' ";
		$Consulta.=" and rol='".$Fila["ROL"]."' and tipo='D' ";
		$RespHomo=mysqli_query($link, $Consulta);
		if ($FilaHomo=mysqli_fetch_array($RespHomo))
		{
			$Codigo=$FilaHomo["CLAVE_CODELCO"];
		}
		else{
			$Consulta="select * from hr_homologa_emolumentos where  ";
			$Consulta.=" codigo='".$Fila["CODIGO_DESCUENTO"]."' ";
			$Consulta.=" and tipo='D' ";
			$RespHomo2=mysqli_query($link, $Consulta);
			$FilaHomo2=mysqli_fetch_array($RespHomo2);
			$Codigo=$FilaHomo2["CLAVE_CODELCO"];
			$cantidad++;
		}*/
		$ArrValores[$i][2]=$Fila["CODIGO_DESCUENTO"]; //codigo_descuento
		$ArrValores[$i][3]=$Fila["CORRELATIVO"]; //correlativo
		$Mes=substr($Fila["FECHA_DEUDA"],4,2);
		$Ano=substr($Fila["FECHA_DEUDA"],0,4);
		$ArrValores[$i][4]='01'.$Mes.$Ano; //fecha_deuda
		$ArrValores[$i][5]=substr($Fila["FECHA_DEUDA"],0,4); //año
		$ArrValores[$i][6]=substr($Fila["FECHA_DEUDA"],4,2); //mes
		$MontoInicial=$Fila["MONTO_INICIAL"];
		$ValorMensual=$Fila["VALOR_MENSUAL"];
		/*ESTO ERA PARA CUENTAS QUE TENIAN VALORES EXPRESADOS EN UF EN ARCHIVO ANTERIOR NO CORRE PARA CARGA FINAL A NO SER QUE VENGAN VALORES EN UF
		if($Fila["ROL"]=='A'){
			$MontoInicial=$Fila["MONTO_INICIAL"];
			$ValorMensual=$Fila["VALOR_MENSUAL"];
		}
		else{
			if (($Fila["GLOSA"]=='Prestamo Anual')|| ($Fila["GLOSA"]=='Interes Prest Anual')){
				$pos = strpos($Fila["MONTO_INICIAL"],',');
				if ($pos === false)
				{
					//if($Ano == '2005')
					//{
						$MontoInicial=$Fila["MONTO_INICIAL"];
						$ValorMensual=$Fila["VALOR_MENSUAL"];
					//}
				}
				else{
					$MontoInicial=str_replace(",",".",$Fila["MONTO_INICIAL"])*$Uf;
					$ValorMensual=str_replace(",",".",$Fila["VALOR_MENSUAL"])*$Uf;
				}
			}
			else{
				$MontoInicial=$Fila["MONTO_INICIAL"];
				$ValorMensual=$Fila["VALOR_MENSUAL"];
			}
		}*/
		$ArrValores[$i][7]=$MontoInicial; //monto_inicial
		$ArrValores[$i][8]=$Fila["CUOTAS_INICIO"]; //cuotas_inicio
		$ArrValores[$i][9]=$Fila["SALDO_PENDIENTE"]; //saldo_pendiente
		$ArrValores[$i][10]=$Fila["CUOTAS_PENDIENTES"]; //cuotas_pendientes
		$ArrValores[$i][11]=$ValorMensual; //valor_mensual
		$DiaR=substr($Fila["FECHA_REAJUSTE"],0,2);
		$MesR=substr($Fila["FECHA_REAJUSTE"],3,2);
		$AnoR=substr($Fila["FECHA_REAJUSTE"],6,4);
		/*echo "dia r".$DiaR."<br>";
		echo "mes r".$MesR."<br>";
		echo "ano r".$AnoR."<br>";*/
		$ArrValores[$i][12]=""; //valor_reajuste
		$ArrValores[$i][13]=""; //valor_interes
		$ArrValores[$i][14]=$AnoR.$MesR.$DiaR; //fecha_reajuste
		$ArrValores[$i][15]=""; //saldo_transitorio
		$ArrValores[$i][16]=""; //correlativo_cont
		$ArrValores[$i][17]=""; //digitado
		$ArrValores[$i][18]=""; //fecha_actualizacion
		$ArrValores[$i][19]=""; //orden_pago
		$ArrValores[$i][20]=""; //año_orden
		$ArrValores[$i][21]=""; //nro_licencia
		$ArrValores[$i][22]=""; //dias_licencia
		$ArrValores[$i][23]=""; //codigo_concepto
		$i++;
		
	}	
	//valor uf 31 oct 2005 =17.859,16 
	CreaArchivo("SigerCtaCteEmpresa", $NomArchivo, "generados/siger", $ArrValores);
}
?>
