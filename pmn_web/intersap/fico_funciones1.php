<?php
/**LIBRO COMPRAS**/
function FicoCargaArchivLibComp()
{
	$Archivo1 = fopen("LibroCompras_May2005Todos.csv","r");
	$Archivo2 = fopen("LibroCompras_May2005.txt","w+");
	$Cont=1;
	$Eliminar = "delete from interfaces_sap.fico_libro_compras ";
	mysqli_query($link, $Eliminar);
	while (!feof($Archivo1))
   {
      	 $Linea=fgets($Archivo1, 512);
		$Linea=str_replace(chr(10),"",$Linea);
        $ArrLinea=explode(";",str_replace(chr(13),"",$Linea));
		if (substr($ArrLinea[0],0,14)=="Tipo Documento")
		{
			/*if ($Cont!="1")
				fwrite($Archivo2,$NewLinea."\r\n\r\n\r\n");*/
			$TipoDoc=substr($ArrLinea[0],17,30);		
			$NomTipoDoc=$ArrLinea[5];		
		}
		else
		{		
			if (strtoupper(substr($ArrLinea[0],0,5))!="TOTAL")
			{
				
				if ($NewLinea=="")
					$NewLinea.= trim($TipoDoc).";".trim($NomTipoDoc).";";
				$Largo=count($ArrLinea);
				for ($i=0;$i<=$Largo;$i++)
				{
					if (trim($ArrLinea[$i])!="")
						$NewLinea.= trim($ArrLinea[$i]).";";				
				}
				//echo "hola".$ArrLinea[0]."<br>";
				if (substr($ArrLinea[0],2,1)=="/")
				{
					
					fwrite($Archivo2,$NewLinea."\r\n");
					$Datos=explode(";",$NewLinea);
					$Insertar = "INSERT INTO interfaces_sap.fico_libro_compras (";
					$Insertar.= " tipo_doc, nom_tipo_doc, rut, razon_social, fecha, estado, folio, ";
					$Insertar.= " nro_int, nro_prov, afecto, no_afecto, neto, exento, iva, iva_no_rec, ";
					$Insertar.= " otros_imp, der_aduana, imp_retenido, total_doc)";
					$Insertar.= " values('".$Datos[0]."','".$Datos[1]."','".str_replace(".","",$Datos[2])."','".str_replace("?","�",$Datos[3])."','".$Datos[4]."',";
					$Insertar.= " '".$Datos[5]."','".$Datos[6]."','".$Datos[7]."','".$Datos[8]."','".$Datos[9]."','".$Datos[10]."',";
					$Insertar.= " '".$Datos[11]."','".$Datos[12]."','".$Datos[13]."','".$Datos[14]."','".$Datos[15]."','".$Datos[16]."',";
					$Insertar.= " '".$Datos[17]."','".$Datos[18]."')";					
					//echo $Insertar;
					mysqli_query($link, $Insertar);
					$NewLinea = "";
				}
			}							
		}
		$Cont++;	    
   }
	fclose($Archivo1);
	fclose($Archivo2);
}
/**FACTURAS PROVEEDORES PENDIENTES**/
function FicoCargaArchivoFacPrv()
{
	//$Archivo1 = fopen("FAC-PR.csv","r");
	$Archivo1 = fopen("FACPR-DIC.csv","r");
	$Archivo2 = fopen("fico_fac_prv.txt","w+");
	$Cont=1;
	while (!feof($Archivo1))
   {
        $Linea=fgets($Archivo1, 512);
		$Linea=str_replace(chr(10),"",$Linea);
		//echo $Linea;
        $ArrLinea=explode(";",str_replace(chr(13),"",$Linea));
		if ($ArrLinea[0]=="Proveedor")
		{
			$Proveedor=str_replace(".","",$ArrLinea[1]);
		}
		else
		{
			if ($ArrLinea[0]=="Cuenta")
			{
				$Cuenta=$ArrLinea[1];
				$NomCuenta=$ArrLinea[2];
			}
			else
			{
				if ($Cont==1)
				{
					$ArrLinea[17]="Proveedor";
					$ArrLinea[18]="Cuenta";
					$ArrLinea[19]="NomCuenta";
					$NewLinea=$ArrLinea[17].";".$ArrLinea[18].";".$ArrLinea[19].";";
				}
				else
				{
					$ArrLinea[17]=$Proveedor;
					$ArrLinea[18]=$Cuenta;
					$ArrLinea[19]=$NomCuenta;
					$NewLinea=$ArrLinea[17].";".$ArrLinea[18].";".$ArrLinea[19].";";
				}
				for ($i=0;$i<=15;$i++)
				{
					$NewLinea.=$ArrLinea[$i].";";
				}
				fwrite($Archivo2,$NewLinea."\r\n");
			}
		}
		$Cont++;	    
   }
	fclose($Archivo1);
	fclose($Archivo2);
}
//CREA ARCHIVO FACTURAS DE PROVEEDORES PENDIENTES
function FicoCreaArchivoFacPrv($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="FicoFacPrvPend.txt";
	$ArrValores=array();
	$Consulta=" select fecha_doc,numero_fac,rut,fecha_vence,nom_cuenta,  ";
	$Consulta.=" sum(haber-debe) as total ";
	$Consulta.=" from interfaces_sap.fico_fac_prv ";
	$Consulta.=" group by rut,numero_fac ";
	$Consulta.=" order by numero_fac ";
	$Respuesta=mysqli_query($link, $Consulta);
	$i=1;
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		//REGITRO 01
		$Indice="0001".$i;
		$ArrValores[$Indice][1]=str_replace("/","",$Fila["fecha_doc"]); //Fecha Documento
		$ArrValores[$Indice][2]=""; //Clase Doc
		$ArrValores[$Indice][3]=""; //Sociedad
		$ArrValores[$Indice][4]=""; //Fecha Contabilizacion
		$ArrValores[$Indice][5]=""; //Periodo
		$ArrValores[$Indice][6]=""; //Moneda
		$ArrValores[$Indice][7]=$Fila["numero_fac"]; //Referencia(N�Factura)
		$ArrValores[$Indice][8]="Carga Inicial ".$Fila["numero_fac"]; //texto cabecera
		$ArrValores[$Indice][9]=""; //Division PARTNER
		if ($Fila["total"] > 0){
			$ArrValores[$Indice][10]="31"; //Clase Contabilizacion (ABONO)
			$Importe=$Fila["total"];
		}
		else{
			$ArrValores[$Indice][10]="21"; //Clase Contabilizacion (ABONO)
			$Importe=0;
		}
/*		if ($Fila["debe"]!="0")
			$ArrValores[$Indice][10]="21"; //Clase Contabilizacion (ABONO)
		else
			$ArrValores[$Indice][10]="31"; //Clase Contabilizacion (CARGO)*/
		$ArrValores[$Indice][11]=$Fila["rut"]; //NUMERO CUENTA

/*		if ($Fila["debe"]!="0")
			$ArrValores[$Indice][12]=$Fila["debe"];//IMPORTE (VALOR)
		else
			$ArrValores[$Indice][12]=$Fila["haber"];//IMPORTE (VALOR)*/
	    $ArrValores[$Indice][12]=$Importe;//IMPORTE (VALOR)*/			
		$ArrValores[$Indice][13]=""; //ESPECIAL
		$ArrValores[$Indice][14]=""; //CALCULAR IVA
		$ArrValores[$Indice][15]=""; //INDICADOR IVA 
		$ArrValores[$Indice][16]=""; //INDICADOR RETENCION 
		$ArrValores[$Indice][17]=""; //DIVISION
		$ArrValores[$Indice][18]=""; //CONDICION DE PAGO 
		$ArrValores[$Indice][19]=str_replace("/","",$Fila["fecha_vence"]); //FECHA DE PAGO
		$ArrValores[$Indice][20]=""; //BASE DPP
		$ArrValores[$Indice][21]=""; //BLOQUEO DE PAGO
		$ArrValores[$Indice][22]=$Fila["numero_fac"];//ASIGNACION 
		$ArrValores[$Indice][23]=$Fila["nom_cuenta"];//TEXTO
		$ArrValores[$Indice][24]="";//CENTRO COSTO
		$ArrValores[$Indice][25]="";//CENTRO BENEFICIO
		$ArrValores[$Indice][26]="";//GRAFO
		$ArrValores[$Indice][27]="";//OPERACION GRAFO
		$ArrValores[$Indice][28]="";//ELEMENTO PEP
		$ArrValores[$Indice][29]=str_replace("/","",$Fila["fecha_vence"]);//FECHA VALOR
		$ArrValores[$Indice][30]="F";//TIPO DOCUMENTO
		$ArrValores[$Indice][31]="";//VALOR DE IVA
		$ArrValores[$Indice][32]="";//VALOR DE RETENCION
		$ArrValores[$Indice][33]="";//VIA PAGO
		$ArrValores[$Indice][34]="";//ORDEN
		//-----------------------------------------------------------------------------
		//REGITRO 02
		//------------------------------------------------------------------------------
		$Indice="0002".$i;
		$ArrValores[$Indice][1]=str_replace("/","",$Fila["fecha_doc"]); //Fecha Documento
		$ArrValores[$Indice][2]=""; //Clase Doc
		$ArrValores[$Indice][3]=""; //Sociedad
		$ArrValores[$Indice][4]=""; //Fecha Contabilizacion
		$ArrValores[$Indice][5]=""; //Periodo
		$ArrValores[$Indice][6]=""; //Moneda
		$ArrValores[$Indice][7]=$Fila["numero_fac"]; //Referencia(N�Factura)
		$ArrValores[$Indice][8]="Carga Inicial ".$Fila["numero_fac"]; //texto cabecera
		$ArrValores[$Indice][9]=""; //Division PARTNER
		if ($Fila["total"] > 0){
			$ArrValores[$Indice][10]="40"; //Clase Contabilizacion (ABONO)
			$Importe=$Fila["total"];
		}
		else{
			$ArrValores[$Indice][10]="50"; //Clase Contabilizacion (CARGO)
			$Importe=0;
		}
/*		if ($Fila["debe"]!="0")
			$ArrValores[$Indice][10]="50"; //Clase Contabilizacion (ABONO)
		else
			$ArrValores[$Indice][10]="40"; //Clase Contabilizacion (CARGO)*/
		$ArrValores[$Indice][11]="999950"; //NUMERO CUENTA
/*		if ($Fila["debe"]!="0")
			$ArrValores[$Indice][12]=$Fila["debe"];//IMPORTE (VALOR)
		else
			$ArrValores[$Indice][12]=$Fila["haber"];//IMPORTE (VALOR)*/
		$ArrValores[$Indice][12]=$Importe;//IMPORTE (VALOR)
		$ArrValores[$Indice][13]=""; //ESPECIAL
		$ArrValores[$Indice][14]=""; //CALCULAR IVA
		$ArrValores[$Indice][15]=""; //INDICADOR IVA 
		$ArrValores[$Indice][16]=""; //INDICADOR RETENCION 
		$ArrValores[$Indice][17]=""; //DIVISION
		$ArrValores[$Indice][18]=""; //CONDICION DE PAGO 
		$ArrValores[$Indice][19]=""; //FECHA DE PAGO
		$ArrValores[$Indice][20]=""; //BASE DPP
		$ArrValores[$Indice][21]=""; //BLOQUEO DE PAGO
		$ArrValores[$Indice][22]="Carga FacXpagar";//ASIGNACION 
		$ArrValores[$Indice][23]="carga inicial FV01 facturas por pagar";//TEXTO
		$ArrValores[$Indice][24]="";//CENTRO COSTO
		$ArrValores[$Indice][25]="";//CENTRO BENEFICIO
		$ArrValores[$Indice][26]="";//GRAFO
		$ArrValores[$Indice][27]="";//OPERACION GRAFO
		$ArrValores[$Indice][28]="";//ELEMENTO PEP
		$ArrValores[$Indice][29]="";//FECHA VALOR
		$ArrValores[$Indice][30]="";//TIPO DOCUMENTO
		$ArrValores[$Indice][31]="";//VALOR DE IVA
		$ArrValores[$Indice][32]="";//VALOR DE RETENCION
		$ArrValores[$Indice][33]="";//VIA PAGO
		$ArrValores[$Indice][34]="";//ORDEN
		$i++;
	}
		CreaArchivo("FicoFacBolPen", $NomArchivo, "generados/fico", $ArrValores);	
}	
/*ESTE ARCHIVO NO CORRE MOMENTANEAMENTE SON FACTURAS POR PAGAR
function FicoCreaArchivoFacVen($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="FicoFacPrvVen.txt";
	$ArrValores=array();
	$Consulta="select * from interfaces_sap.fico_fac_prv ";
	$Respuesta=mysqli_query($link, $Consulta);
	$i=1;
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		//REGITRO 01
		$Indice="0001".$i;
		$ArrValores[$Indice][1]=str_replace("/","",$Fila["fecha_doc"]); //Fecha Documento
		$ArrValores[$Indice][2]="DR"; //Clase Doc
		$ArrValores[$Indice][3]="Cl01"; //Sociedad
		$ArrValores[$Indice][4]=""; //Fecha Contabilizacion
		$ArrValores[$Indice][5]=""; //Periodo
		$ArrValores[$Indice][6]="CLP"; //Moneda
		$ArrValores[$Indice][7]=$Fila["numero_fac"]; //Referencia(N�Factura)
		$ArrValores[$Indice][8]="Carga Inicial ".$Fila["numero_fac"]; //texto cabecera
		$ArrValores[$Indice][9]=""; //Division PARTNER
		if ($Fila["debe"]!="0")
			$ArrValores[$Indice][10]="21"; //Clase Contabilizacion (CARGO)
		else
			$ArrValores[$Indice][10]="31"; //Clase Contabilizacion (ABONO)
		$ArrValores[$Indice][11]=$Fila["rut"]; //NUMERO CUENTA
		if ($Fila["debe"]!="0")
			$ArrValores[$Indice][12]=$Fila["debe"];//IMPORTE (VALOR)
		else
			$ArrValores[$Indice][12]=$Fila["haber"];//IMPORTE (VALOR)
		$ArrValores[$Indice][13]=""; //ESPECIAL
		$ArrValores[$Indice][14]=""; //CALCULAR IVA
		$ArrValores[$Indice][15]=""; //INDICADOR IVA 
		$ArrValores[$Indice][16]=""; //INDICADOR RETENCION 
		$ArrValores[$Indice][17]=""; //DIVISION
		$ArrValores[$Indice][18]=""; //CONDICION DE PAGO 
		$ArrValores[$Indice][19]=str_replace("/","",$Fila["fecha_vence"]); //FECHA DE PAGO
		$ArrValores[$Indice][20]=""; //BASE DPP
		$ArrValores[$Indice][21]=""; //BLOQUEO DE PAGO
		$ArrValores[$Indice][22]=$Fila["numero_fac"];//ASIGNACION 
		$ArrValores[$Indice][23]=$Fila["nom_cuenta"];//TEXTO
		$ArrValores[$Indice][24]="";//CENTRO COSTO
		$ArrValores[$Indice][25]="";//CENTRO BENEFICIO
		$ArrValores[$Indice][26]="";//GRAFO
		$ArrValores[$Indice][27]="";//OPERACION GRAFO
		$ArrValores[$Indice][28]="";//ELEMENTO PEP
		$ArrValores[$Indice][29]=str_replace("/","",$Fila["fecha_vence"]);//FECHA VALOR
		$ArrValores[$Indice][30]="F";//TIPO DOCUMENTO
		$ArrValores[$Indice][31]="";//VALOR DE IVA
		$ArrValores[$Indice][32]="";//VALOR DE RETENCION
		$ArrValores[$Indice][33]="";//VIA PAGO
		$ArrValores[$Indice][34]="";//ORDEN
		//-----------------------------------------------------------------------------
		//REGITRO 02
		//------------------------------------------------------------------------------
		$Indice="0002".$i;
		$ArrValores[$Indice][1]=str_replace("/","",$Fila["fecha_doc"]); //Fecha Documento
		$ArrValores[$Indice][2]="DR"; //Clase Doc
		$ArrValores[$Indice][3]="CL01"; //Sociedad
		$ArrValores[$Indice][4]=""; //Fecha Contabilizacion
		$ArrValores[$Indice][5]=""; //Periodo
		$ArrValores[$Indice][6]=""; //Moneda
		$ArrValores[$Indice][7]=$Fila["numero_fac"]; //Referencia(N�Factura)
		$ArrValores[$Indice][8]="Carga Inicial ".$Fila["numero_fac"]; //texto cabecera
		$ArrValores[$Indice][9]=""; //Division PARTNER
		if ($Fila["debe"]!="0")
			$ArrValores[$Indice][10]="50"; //Clase Contabilizacion (CARGO)
		else
			$ArrValores[$Indice][10]="40"; //Clase Contabilizacion (ABONO)
		$ArrValores[$Indice][11]="999950"; //NUMERO CUENTA
		if ($Fila["debe"]!="0")
			$ArrValores[$Indice][12]=$Fila["debe"];//IMPORTE (VALOR)
		else
			$ArrValores[$Indice][12]=$Fila["haber"];//IMPORTE (VALOR)
		$ArrValores[$Indice][13]=""; //ESPECIAL
		$ArrValores[$Indice][14]=""; //CALCULAR IVA
		$ArrValores[$Indice][15]=""; //INDICADOR IVA 
		$ArrValores[$Indice][16]=""; //INDICADOR RETENCION 
		$ArrValores[$Indice][17]=""; //DIVISION
		$ArrValores[$Indice][18]=""; //CONDICION DE PAGO 
		$ArrValores[$Indice][19]=""; //FECHA DE PAGO
		$ArrValores[$Indice][20]=""; //BASE DPP
		$ArrValores[$Indice][21]=""; //BLOQUEO DE PAGO
		$ArrValores[$Indice][22]="Carga FacXpagar";//ASIGNACION 
		$ArrValores[$Indice][23]="carga inicial FV01 facturas por pagar";//TEXTO
		$ArrValores[$Indice][24]="";//CENTRO COSTO
		$ArrValores[$Indice][25]="";//CENTRO BENEFICIO
		$ArrValores[$Indice][26]="";//GRAFO
		$ArrValores[$Indice][27]="";//OPERACION GRAFO
		$ArrValores[$Indice][28]="";//ELEMENTO PEP
		$ArrValores[$Indice][29]="";//FECHA VALOR
		$ArrValores[$Indice][30]="";//TIPO DOCUMENTO
		$ArrValores[$Indice][31]="";//VALOR DE IVA
		$ArrValores[$Indice][32]="";//VALOR DE RETENCION
		$ArrValores[$Indice][33]="";//VIA PAGO
		$ArrValores[$Indice][34]="";//ORDEN
		$i++;
	}
	CreaArchivo("FicoFacBolPen", $NomArchivo, "generados/fico", $ArrValores);	
}	*/

?>
