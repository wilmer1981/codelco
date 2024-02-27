<?php
	//include("inter_conectar.php");
function FicoCreaTablaProcomi()	
{
	$Eliminar="drop table interfaces_sap.fico_maestro_procomi";
	mysqli_query($link, $Eliminar);
	$CrearTabla ="CREATE TABLE `interfaces_sap`.`fico_maestro_procomi` (";
	$CrearTabla.="`rut` varchar(255) NOT NULL DEFAULT '0',";
	$CrearTabla.="`tipo` varchar(255) NULL,";
	$CrearTabla.="`razon_social` varchar(255) NULL,";
	$CrearTabla.="`direccion` varchar(255) NULL,";
	$CrearTabla.="`ciudad` varchar(255) NULL,";
	$CrearTabla.="`region` varchar(255) NULL,";
	$CrearTabla.="`telefono` varchar(255) NULL,";
	$CrearTabla.="`fax` varchar(255) NULL,";
	$CrearTabla.="`correo_electronico` varchar(255) NULL,";
	$CrearTabla.="`cod_banco` varchar(255) NULL,";
	$CrearTabla.="`nom_banco` varchar(255) NULL,";
	$CrearTabla.="`cta_cte` varchar(255) NULL,";
	$CrearTabla.="`pago_glosa` varchar(255) NULL,";
	$CrearTabla.="`via_pago` varchar(255) NULL,";
	$CrearTabla.="`subvia_pago` varchar(255) NULL,";
	$CrearTabla.="`condicion_pago` varchar(255) NULL,";
	$CrearTabla.="`cod_comuna` varchar(255) NULL,";
	$CrearTabla.="`nom_comuna` varchar(255) NULL,";
	$CrearTabla.="`sucursal_banco` varchar(255) NULL,";
	$CrearTabla.="`op_factura` varchar(255) NULL,";
	$CrearTabla.="`op_boleta` varchar(255) NULL,";
	$CrearTabla.="`retencion` varchar(255) NULL,";
	$CrearTabla.="`nuevo` varchar(255) NULL";
	//$CrearTabla.=" , PRIMARY KEY (`rut`)";
	$CrearTabla.=" ) as ";
	$CrearTabla.= " select rut,'MI' as tipo, razon_social, direccion, '' as ciudad, '' as region, '' as telefono, ";
	$CrearTabla.= " '' as fax, '' as correo_electronico, '' as cod_banco, glosa as nom_banco, ctacte as cta_cte, pago_glosa, ";
	$CrearTabla.= "'' as nuevo, '' as via_pago, '' as subvia_pago, 'Z005' as  condicion_pago, '' as cod_comuna, '' as nom_comuna, ";
	$CrearTabla.= " '' as sucursal_banco, 'x' as op_factura, '' as op_boleta, '' as retencion ";
	$CrearTabla.=" from interfaces_sap.fico_proved_fin700 ";
	$CrearTabla.=" order by rut ";
	mysqli_query($link, $CrearTabla);
	//echo $CrearTabla;
	$Consulta =" select * ";
	$Consulta.=" from interfaces_sap.fico_proved_bddai ";
	$Consulta.=" order by rut ";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{		
		$Tipo="PR";
		$Consulta =" select * ";
		$Consulta.=" from interfaces_sap.fico_maestro_procomi ";
		$Consulta.=" where rut='".$Fila["rut"]."'";
		$Resp2=mysqli_query($link, $Consulta);
		if ($Fila2=mysqli_fetch_array($Resp2))
		{
			$Actualizar="UPDATE interfaces_sap.fico_maestro_procomi set ";
			$Actualizar.=" tipo='".$Tipo."', condicion_pago='Z001'";
			$Actualizar.=" where rut='".$Fila["rut"]."'";
			mysqli_query($link, $Actualizar);
		}
		else
		{
			$Insertar="INSERT INTO interfaces_sap.fico_maestro_procomi(";
			$Insertar.= "rut, tipo, razon_social, direccion, ciudad, region, telefono, ";
			$Insertar.= "fax, correo_electronico, cod_banco, nom_banco, cta_cte, pago_glosa,nuevo, condicion_pago,op_factura) ";
			$Insertar.= " VALUES('".$Fila["rut"]."','".$Tipo."','".$Fila["sigla"]."','',";
			$Insertar.= "'".$Fila["ciudad"]."','','','','','001','BANCO CHILE','','VALE VISTA CORREO','N','Z001','x')";
			mysqli_query($link, $Insertar);
		}		
	}
	$Consulta =" select * ";
	$Consulta.=" from interfaces_sap.fico_contratistas_vigentes ";
	$Consulta.=" order by rut ";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{		
		$Tipo="CO";
		$Consulta =" select * ";
		$Consulta.=" from interfaces_sap.fico_maestro_procomi ";
		$Consulta.=" where rut='".$Fila["rut"]."'";
		$Resp2=mysqli_query($link, $Consulta);
		if ($Fila2=mysqli_fetch_array($Resp2))
		{
			$Actualizar="UPDATE interfaces_sap.fico_maestro_procomi set ";
			$Actualizar.=" tipo='".$Tipo."', condicion_pago='Z003' ";
			$Actualizar.=" where rut='".$Fila["rut"]."'";
			mysqli_query($link, $Actualizar);
		}
		else
		{
			$Insertar="INSERT INTO interfaces_sap.fico_maestro_procomi(";
			$Insertar.= "rut, tipo, razon_social, direccion, ciudad, region, telefono, ";
			$Insertar.= "fax, correo_electronico, cod_banco, nom_banco, cta_cte, pago_glosa,nuevo, condicion_pago,op_factura) ";
			$Insertar.= " VALUES('".$Fila["rut"]."','".$Tipo."','".$Fila["razon_social"]."','".$Fila["direccion"]."',";
			$Insertar.= "'".$Fila["ciudad"]."','".$Fila["region"]."','".$Fila["telefono"]."','".$Fila["fax"]."',";
			$Insertar.= "'".$Fila["correo_electronico"]."','001','BANCO CHILE','','VALE VISTA CORREO','N', 'Z003','x')";
			mysqli_query($link, $Insertar);
			//echo $Insertar;
		}		
	}
	//INSERTA LAS RETENCIONES JUDICIALES DEL ARCHIVO FICO_PROVED_REMU "R"
	$Consulta =" select * ";
	$Consulta.=" from interfaces_sap.fico_proved_remu where tipo='R' ";
	$Consulta.=" order by rut ";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{				
		$Tipo="MI";
		$Consulta =" select * ";
		$Consulta.=" from interfaces_sap.fico_maestro_procomi ";
		$Consulta.=" where rut='".$Fila["rut"]."'";
		$Resp2=mysqli_query($link, $Consulta);
		if ($Fila2=mysqli_fetch_array($Resp2))
		{
			$Actualizar="UPDATE interfaces_sap.fico_maestro_procomi set ";
			$Actualizar.=" tipo='".$Tipo."', condicion_pago='Z005'";
			$Actualizar.=" where rut='".$Fila["rut"]."'";
			mysqli_query($link, $Actualizar);
		}
		else
		{
			$Insertar="INSERT INTO interfaces_sap.fico_maestro_procomi(";
			$Insertar.= "rut, tipo, razon_social, direccion, ciudad, region, telefono, ";
			$Insertar.= "fax, correo_electronico, cod_banco, nom_banco, cta_cte, pago_glosa,nuevo, condicion_pago,op_factura) ";
			$Insertar.= " VALUES('".$Fila["rut"]."','".$Tipo."','".$Fila["razon_social"]."','".$Fila["direccion"]."',";
			$Insertar.= "'','','','',";
			$Insertar.= "'','','".$Fila["glosa"]."','".$Fila["ctacte"]."','".$Fila["pago_glosa"]."','N', 'Z005','x')";
			mysqli_query($link, $Insertar);
			//echo $Insertar."<br>";
		}
	}
	//ELIMINA LOS TIPO "T" DEL REGISTRO DE REMUNERA
	$Consulta =" select * ";
	$Consulta.=" from interfaces_sap.fico_proved_remu where tipo='T' ";
	$Consulta.=" order by rut ";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{				
		$Consulta =" select * ";
		$Consulta.=" from interfaces_sap.fico_maestro_procomi ";
		$Consulta.=" where rut='".$Fila["rut"]."'";
		$Resp2=mysqli_query($link, $Consulta);
		if ($Fila2=mysqli_fetch_array($Resp2))
		{
			$Eliminar =" delete ";
			$Eliminar.=" from interfaces_sap.fico_maestro_procomi ";
			$Eliminar.=" where rut='".$Fila["rut"]."'";
			mysqli_query($link, $Eliminar);
		}
	}
	//ELIMINA LOS REGISTROS DE LA BDDAI
	$Consulta =" select * ";
	$Consulta.=" from interfaces_sap.fico_proved_bddai_elim ";
	$Consulta.=" order by rut ";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{				
		$Consulta =" select * ";
		$Consulta.=" from interfaces_sap.fico_maestro_procomi ";
		$Consulta.=" where rut='".$Fila["rut"]."'";
		$Resp2=mysqli_query($link, $Consulta);
		if ($Fila2=mysqli_fetch_array($Resp2))
		{
			$Eliminar =" delete ";
			$Eliminar.=" from interfaces_sap.fico_maestro_procomi ";
			$Eliminar.=" where rut='".$Fila["rut"]."'";
			mysqli_query($link, $Eliminar);
		}
	}
	//ELIMINA LOS REGISTROS DE LOS CONTRATISTAS VIGENTES
	$Consulta =" select * ";
	$Consulta.=" from interfaces_sap.fico_contratistas_vigentes_elim ";
	$Consulta.=" order by rut ";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{				
		$Consulta =" select * ";
		$Consulta.=" from interfaces_sap.fico_maestro_procomi ";
		$Consulta.=" where rut='".$Fila["rut"]."'";
		$Resp2=mysqli_query($link, $Consulta);
		if ($Fila2=mysqli_fetch_array($Resp2))
		{
			$Eliminar =" delete ";
			$Eliminar.=" from interfaces_sap.fico_maestro_procomi ";
			$Eliminar.=" where rut='".$Fila["rut"]."'";
			mysqli_query($link, $Eliminar);
		}
	}
	//HOMOLOGA LOS BANCOS
	$Consulta =" select distinct nom_banco ";
	$Consulta.=" from interfaces_sap.fico_maestro_procomi ";
	$Consulta.= " where trim(nom_banco)<>''";
	$Consulta.=" order by nom_banco ";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{				
		$Consulta =" select * ";
		$Consulta.=" from interfaces_sap.zhk19 ";
		$Consulta.=" where nom_ventana='".$Fila["nom_banco"]."'";
		$Resp2=mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		if ($Fila2=mysqli_fetch_array($Resp2))
		{
			$Actualizar =" UPDATE  interfaces_sap.fico_maestro_procomi set ";
			$Actualizar.=" cod_banco='".$Fila2["ZHK19-ZZLUGCO"]."'";
			$Actualizar.=" where nom_banco='".$Fila2["nom_ventana"]."'";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar;
		}
	}
	//HOMOLOGA VIA PAGO
	$Consulta =" select distinct pago_glosa ";
	$Consulta.=" from interfaces_sap.fico_maestro_procomi ";
	$Consulta.= " where trim(pago_glosa)<>''";
	$Consulta.=" order by pago_glosa ";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{				
		switch ($Fila["pago_glosa"])
		{
			case "ABONO A CTA. AHORRO BANCO CHIL":
				$ViaPago="";
				$SubViaPago="";
				break;
			case "ABONO A CTA. AHORRO OTRO BANCO":
				$ViaPago="";
				$SubViaPago="";
				break;
			case "ABONO CTA. CTE. OTROS BANCO":
				$ViaPago="6";
				$SubViaPago="";
				break;
			case "CHEQUE MANUAL":
				$ViaPago="5";
				$SubViaPago="";
				break;
			case "DEPOSITO CTA. CTE. BCO. CHILE":
				$ViaPago="6";
				$SubViaPago="";
				break;			
			case "VALE VISTA CORREO":
				$ViaPago="7";
				$SubViaPago="CO";
				break;				
			case "VALE VISTA MESON":
				$ViaPago="7";
				$SubViaPago="OF";
				break;													
			
		}
		$Actualizar =" UPDATE  interfaces_sap.fico_maestro_procomi set ";
		$Actualizar.=" via_pago='".$ViaPago."', ";
		$Actualizar.=" subvia_pago='".$SubViaPago."' ";
		$Actualizar.=" where pago_glosa='".$Fila["pago_glosa"]."'";
		mysqli_query($link, $Actualizar);
		//echo $Actualizar;
	}
}

function FicoCreaArchivoProcomi($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="FicoFile1.txt";
	$ArrValores=array();
	//RESCATA DATOS
	$FunCons="select * from interfaces_sap.fico_maestro_procomi order by rut ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$ArrValores[$FunFila["rut"]][1]=$FunFila["rut"];        //RUT
		$ArrValores[$FunFila["rut"]][2]=$FunFila["tipo"];       //TIPO
		$ArrValores[$FunFila["rut"]][3]=$FunFila["cod_banco"];  //CODBANCO
		$ArrValores[$FunFila["rut"]][4]=$FunFila["cta_cte"];    //CTA CTE
	}
	CreaArchivo("FicoProcomi", $NomArchivo, "generados/fico", $ArrValores);
}

function FicoCreaArchivoMaProv($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="FicoFile2.txt";
	$ArrValores=array();
	//ACTUALIZA DATOS COMUNA,SUCURSAL  Y COD_COMUNA
	$Consulta="select * from fico_maestro_procomi order by rut ";
	$Respuesta=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		$Consulta = "select t1.PRORUT, t1.PROPAGINST,t2.`zhk20-zzsucco`,t2.`zhk20-zzsucde` ";
		$Consulta.= "from fico_codigos t1 left join zhk20 t2  " ;
		$Consulta.= " on t1.cmunombre = t2.`zhk20-zzsucde`     ";
		$Consulta.=" where t1.prorut='".$Fila[rut]."'";
		$Respuesta1=mysqli_query($link, $Consulta);
		if ($Fila1=mysqli_fetch_array($Respuesta1))
		{
			$Actualizar="UPDATE fico_maestro_procomi set  sucursal_banco ='".$Fila1[PROPAGINST]."' , ";
			$Actualizar.=" cod_comuna='".$Fila1["zhk20-zzsucco"]."',  ";
			$Actualizar.=" nom_comuna= '".$Fila1["zhk20-zzsucde"]."' ";
			$Actualizar.=" where rut='".$Fila[rut]."' ";				
			mysqli_query($link, $Actualizar);
		}		
	}
	//ACTUALIZA FACTURAS,BOLETAS Y RETENCION
	$Actualizar="UPDATE interfaces_sap.fico_maestro_procomi set  op_factura='x', ";
	$Actualizar.=" op_boleta='', retencion=''  ";
	mysqli_query($link, $Actualizar); 
	$Consulta="select distinct rut from interfaces_sap.fico_rut_boletas order by rut ";
	$Respuesta=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		/*$Consulta="select rut from fico_rut_boletas where rut='".$Fila[rut]."' ";					
		$Respuesta1=mysqli_query($link, $Consulta);
		if ($Fila1=mysqli_fetch_array($Respuesta1))
		{*/
			$Actualizar="UPDATE fico_maestro_procomi set  op_factura='', ";
			$Actualizar.=" op_boleta='x', retencion='10'  ";
			$Actualizar.=" where rut='".$Fila[rut]."' ";
			mysqli_query($link, $Actualizar); 
			//echo $Actualizar."<br>"; 
		//}
	}
	//RESCATA DATOS
	$FunCons="select t1.rut,t1.razon_social,t1.direccion, ";
	$FunCons.=" t1.nom_comuna,t1.sucursal_banco,t1.op_boleta, ";
	$FunCons.=" t1.op_factura,t1.cta_cte,t1.cod_banco, ";
	$FunCons.=" t1.retencion,t1.condicion_pago,t1.via_pago, ";
	$FunCons.=" t1.subvia_pago ,t2.cta_cte_mae,t1.tipo";
	$FunCons.=" from interfaces_sap.fico_maestro_procomi t1 ";
	$FunCons.=" inner join interfaces_sap.fico_comparativo_maestro_sap t2 on   ";
	$FunCons.=" t1.rut=t2.rut ";
	$FunCons.=" where (isnull(t2.rut_mae)) and (t1.tipo='MI') ";
	$FunCons.=" order by t1.rut ";
	$FunResp=mysqli_query($link, $FunCons);
	while ($FunFila=mysqli_fetch_array($FunResp))
	{	
		$ArrValores[$FunFila["rut"]][1]=$FunFila["rut"]; //ACREEDOR = RUT
		$ArrValores[$FunFila["rut"]][2]="CL01"; //SOCIEDAD (CL01)
		$ArrValores[$FunFila["rut"]][3]="PRFI"; //GRUPOCTA (PRFI)
		$ArrValores[$FunFila["rut"]][4]=str_replace("?","�",$FunFila["razon_social"]);      //NOMBRE Y APELLIDO
		$ArrValores[$FunFila["rut"]][5]="";     //NOMBRE ABREVIADO
		$ArrValores[$FunFila["rut"]][6]=str_replace("?","�",$FunFila["direccion"]);          //CALLE (SIN NUMERO)   
		$ArrValores[$FunFila["rut"]][7]="";    //NUMERO_CALLE (N� DE LA DIR)
		$ArrValores[$FunFila["rut"]][8]="";    //CODIGO POSTAL (SI TIENE)
		$ArrValores[$FunFila["rut"]][9]=str_replace("?","�",$FunFila["nom_comuna"]);    //NOMBRE DE LA COMUNA 
		$ArrValores[$FunFila["rut"]][10]=$FunFila["sucursal_banco"];   //CODIGO DE OFICINA PARA VALE VISTA SI LO TIENE
		$ArrValores[$FunFila["rut"]][11]=$FunFila["op_boleta"];   //BOTELA (LLENAR CON "X" SI OPERA CON BOLETAS)
		$ArrValores[$FunFila["rut"]][12]=$FunFila["op_factura"];   //FACTURA (LLENAR CON "X" SI OPERA CON FACTURA)
		if ($FunFila["cta_cte"]!="")
			$ArrValores[$FunFila["rut"]][13]="CL"; //PAIS BCO (SI UTILIZA CTA CTE LLENAR CON "CL" SINO DEJAR EN BLANCO)
		else
			$ArrValores[$FunFila["rut"]][13]="";
		$ArrValores[$FunFila["rut"]][14]=$FunFila["cod_banco"]; //CODIGO BCO (SI UTILIZA CTA CTE SE DEBE LLENAR CON EL COD BCO DE LA CTA CTE, SINO EN BLANCO)
		//******ESTO ES SOLO PARA LOS PROVEEDORES QUE YA SE ENCUENTRAN EN SAP******
		$CtaCte="";
		if((!is_null($FunFila["cta_cte"])) ||($FunFila["cta_cte"]<> ""))
			$CtaCte=$FunFila["cta_cte"];	
		else
			$CtaCte=$FunFila["cta_cte_mae"];
		//*************************************************************************	
		//$ArrValores[$FunFila["rut"]][15]=$FunFila["cta_cte"];   //CTA CTE SI TIENE
		$ArrValores[$FunFila["rut"]][15]=$CtaCte;   //CTA CTE SI TIENE
		$ArrValores[$FunFila["rut"]][16]="01"; //RELACION PROVEEDOR CON CODELCO SI="02", NO="01"
		$ArrValores[$FunFila["rut"]][17]=$FunFila["retencion"];  //IND RETENCION (SI OPERA CON BOLETA SE DEBE INDICAR % DE RETENCION (SEGUN TABLA))		
		$ArrValores[$FunFila["rut"]][18]=$FunFila["condicion_pago"];		  //CONDICION PAGO (DEFINE EN CUANTOS DIAS SE PAGA... EN BLANCO ES AL DIA)
		$ArrValores[$FunFila["rut"]][19]=$FunFila["via_pago"];	  //VIAS DE PAGO (5=CHEQUE, 6=DEPOSITO, 7=VELE VISTA, EN CASO DE TENER MAS DE UNA SERIA, 56, 57, 67, 567)
		$ArrValores[$FunFila["rut"]][20]=$FunFila["subvia_pago"];	  //SUP VIA DE PAGO SE UTILIZA SI LA VIA DE PAGO ES VALE VISTA (7)... OF=V.V. A OFICINA, CO=V.V. POR CORREO		
		if($FunFila["subvia_pago"]=='OF')
			$ArrValores[$FunFila["rut"]][21]=$FunFila["sucursal_banco"];   //CODBANCO
		
		if ($FunFila["tipo"]=='MI'){
			$Consulta="select PROSUCINTERNET from fico_proveedores_codelco ";
			$Consulta.=" where PRORUT='".$FunFila["rut"]."' ";
			$RespMail=mysqli_query($link, $Consulta);
			if($FilaMail=mysqli_fetch_array($RespMail))
			{
				$ArrValores[$FunFila["rut"]][22]=$FilaMail["PROSUCINTERNET"];   //EMAIL 
			}
			else
				$ArrValores[$FunFila["rut"]][22]='';   //EMAIL 
		}
		if ($FunFila["tipo"]=='PR'){
			$Consulta="select correo from fico_proveedores_PR ";
			$Consulta.=" where rut='".$FunFila["rut"]."' ";
			$RespMail=mysqli_query($link, $Consulta);
			if($FilaMail=mysqli_fetch_array($RespMail))
			{
				$ArrValores[$FunFila["rut"]][22]=$FilaMail["correo"];   //EMAIL 
			}
			else
				$ArrValores[$FunFila["rut"]][22]='';   //EMAIL 
		}
		if ($FunFila["tipo"]=='CO'){
			$Consulta="select correo_electronico from fico_contratistas_vigentes ";
			$Consulta.=" where rut='".$FunFila["rut"]."' ";
			$RespMail=mysqli_query($link, $Consulta);
			if($FilaMail=mysqli_fetch_array($RespMail))
			{
				$ArrValores[$FunFila["rut"]][22]=$FilaMail["correo_electronico"];   //EMAIL 
			}
			else
				$ArrValores[$FunFila["rut"]][22]='';   //EMAIL 
		}
	}
	CreaArchivo("FicoMaProv", $NomArchivo, "generados/fico", $ArrValores);
}	
/**Activo Fijo**/
function FicoCreaArchivoActFijo($NomArchivo)
{
	/*ACTUALIZA RUT SIN FORMATO DE .
	$Consulta="select * from fico_relacion_numsap_rut ";
	$Resp=mysqli_query($link, $Consulta);
	while($FilaResp=mysqli_fetch_array($Resp))
	{
		$Rut=str_replace(".","",$FilaResp["rut"]);
		//echo $Rut."<br>"; 
		$Actualizar="UPDATE fico_relacion_numsap_rut set rut='".$Rut."' ";
		$Actualizar.=" where rut='".$FilaResp[rut]."' ";
		mysqli_query($link, $Actualizar);
		//echo $Actualizar."<br>";
	}*/
	if ($NomArchivo=="")
		$NomArchivo="FicoActivoFijo.txt";
	$ArrValores=array();
	$i=1;
	$Cont=0;
	$Cont1=0;
	$Consulta="select t1.grupo,t1.subgrupo,t1.codigo,t1.sec,";
	$Consulta.=" t1.descripcion,t1.fecha_incorp,t1.tipo, ";
	$Consulta.=" t1.deprecia,t1.v_util,t1.saldo_v_u,t1.v_u_usada,";
	$Consulta.=" t1.v_actualiz,t1.v_neto,t1.rut,t1.C_COSTO ";
	$Consulta.=" from fico_bienes t1  ";
	$Consulta.=" order by t1.rut";
	$Respuesta=mysqli_query($link, $Consulta);
	$Encontro1=0;
	$Encontro2=0;
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$Consulta1="select t1.clase,t1.cocep_4,t1.concep_5,t1.dest_inv, ";
		$Consulta1.=" t1.protec_amb";
		$Consulta1.=" from fico_grupos_ven t1 where ";
		$Consulta1.=" t1.grupo='".$Fila["grupo"]."' and     ";
		$Consulta1.=" t1.subgru='".$Fila["subgrupo"]."'      ";
		$Respuesta2=mysqli_query($link, $Consulta1);
		if($Fila2=mysqli_fetch_array($Respuesta2))
		{
			$Clase1=$Fila2["clase"];
			$Concep4=$Fila2[cocep_4];
			$Concep5=$Fila2[concep_5];
			$Inv=$Fila2[dest_inv];
			$Amb=$Fila2[protec_amb];
			$Encontro1++;
		}
		else
		{
			$Consulta="select t1.clase,t1.cocep_4,t1.concep_5,t1.dest_inv," ;
			$Consulta.=" t1.protec_amb";
			$Consulta.=" from fico_grupos_ven t1 where ";
			$Consulta.=" grupo='".$Fila["grupo"]."'      ";
			$Respuesta3=mysqli_query($link, $Consulta);
			if($Fila3=mysqli_fetch_array($Respuesta3))
			{
				$Clase1=$Fila3[clase];
				$Concep4=$Fila3[cocep_4];
				$Concep5=$Fila3[concep_5];
				$Inv=$Fila3[dest_inv];
				$Amb=$Fila3[protec_amb];
				$Encontro2++;
			}
		}
		$grupo=str_pad($Fila["grupo"],4,'0',l_pad);
		$subgrupo=str_pad($Fila[subgrupo],2,'0',l_pad);
		$codigo=str_pad($Fila[codigo],4,'0',l_pad);
		$secuencial=str_pad($Fila[sec],2,'0',l_pad);
		$ArrValores[$i][1]=""; //Transaccion
		$ArrValores[$i][2]=""; //Sociedad
		$ArrValores[$i][3]=$Clase1; //Clase Inmovilizado
		$ArrValores[$i][4]=$grupo.$subgrupo.$codigo.$secuencial; //NumeroAntiguo
		if (strlen($Fila["descripcion"])> 50)
		{
			$Descripcion1=substr($Fila["descripcion"],0,50);
			$Descripcion2=substr($Fila["descripcion"],50,strlen($Fila["descripcion"]));
		}
		else
		{
			$Descripcion1=$Fila["descripcion"];
			$Descripcion2="";
		}
		$ArrValores[$i][5]=str_replace("?","�",$Descripcion1); //NombreActivo
		$ArrValores[$i][6]=str_replace("/","",$Fila[fecha_incorp]); //FechaCapitalizacion
		$ArrValores[$i][7]=""; //Division
		/*******CONSIDERAR PARA CARGA EN PRODUCCION*/
		$Consulta="select * from  fico_homologa_cc_activo_fijo where centro_costo_enm=right('".$Fila[C_COSTO]."',4)";
		$RespCC=mysqli_query($link, $Consulta);
		if($FilaCC=mysqli_fetch_array($RespCC))
			$ArrValores[$i][8]=$FilaCC["centro_costo_sap"]; //CentroCosto
		else{
			$ArrValores[$i][8]='888888'; //CentroCosto
		}
		//*****CONSIDERAR SOLO PARA TESTING 
		//$ArrValores[$i][8]='FZ999'; //CentroCosto
		//**********FIN********************
		$ArrValores[$i][9]=""; //Concepto3
		$ArrValores[$i][10]=substr($Concep5,0,4); //Concepto4
		$ArrValores[$i][11]=$Concep5; //Concepto5
		$ArrValores[$i][12]=$Inv; //DestinoInversion
		$ArrValores[$i][13]=$Amb; //ProteccionAmbiental
		$ArrValores[$i][14]=""; //AreaValoracion
		$A�o=($Fila[v_util]/12);
		if(($Clase1=='14020000'))
			$Depre='ZSTL';
		else
		{	
			if((!is_null($Fila[deprecia])) && trim(($Fila[tipo])=='FIN'))
				$Depre='0000';
			else
				$Depre='ZSTL';
		}
		//*****************************************	
		$ArrValores[$i][15]=$Depre; //ClaveAmortizacion
		if(($Clase1=='14020000')|| ($A�o==0))
			$ArrValores[$i][16]='0'; //A�osVidaUtil
			else
				$ArrValores[$i][16]=intval($A�o); //A�osVidaUtil
		$Residuo=($Fila[v_util]%12);
		$MesesUtil="";
		if ($Residuo <> 0)
		{
			$MesesUtil=$Residuo;
		}	
		$Cod=$grupo.$subgrupo.$codigo.$secuencial;
		if(($Clase1=='14020000')|| ($A�o==0)){
			//if(!is_null($Fila[deprecia]))//bienes NO DEPRECIA
			//	$ArrValores[$i][17]=''; //MesesVidaUtil}
			//else
				$ArrValores[$i][17]='1'; //MesesVidaUtil}
		}
		else
			$ArrValores[$i][17]=$MesesUtil; //MesesVidaUtil}
		
		$Ano=substr($Fila["fecha_incorp"],6,4);
		$Mes=substr($Fila["fecha_incorp"],3,2);
		$Dia=substr($Fila["fecha_incorp"],0,2);
		if($Ano < '2005')
			$FechaCalcAmort='01052005';
		else
		{
			if($Ano=='2005'){
				if($Mes >= '05')
					$FechaCalcAmort=str_replace("/","",$Fila["fecha_incorp"]);			
				else{
						$FechaCalcAmort='01052005';
				}
			}
			else
				$FechaCalcAmort=str_replace("/","",$Fila["fecha_incorp"]);			
		}		
		$ArrValores[$i][18]=$FechaCalcAmort; //FechaCalculoAmort*/
		//CARGA ANTERIOR MES DE AGOSTO NO SE TOMA EN CUENTA PARA CARGA FINAL****
		/*$A�oTrans=($Fila[V_U_USADA]/12);
		$ArrValores[$i][19]=intval($A�oTrans); //A�osVidaUtilTrans
		$ResiduoTrans=($Fila[V_U_USADA]%12);//MESES
		$MesesTrans="";
		if ($ResiduoTrans <> 0)
			$MesesTrans=$ResiduoTrans;
		$ArrValores[$i][20]=$MesesTrans; //MesesVidaUtilTrans*/
		//************FIN**********
		if(($Fila[v_neto]==1)||($Fila[v_u_usada]=='0'))
		{
			$ArrValores[$i][19]="0"; //A�osVidaUtilTrans
			$ArrValores[$i][20]="1"; //MesesVidaUtilTrans
		}
		else{
			$ArrValores[$i][19]="0"; //A�osVidaUtilTrans
			$ArrValores[$i][20]=$Fila[v_u_usada]; //A�osVidaUtilTrans
		}
		$ArrValores[$i][21]=$Fila[v_actualiz]; //ValorAdquisicion
		$ArrValores[$i][22]=""; //AmortEjercicioAnt
		$Act=str_replace(",",".",$Fila[v_actualiz]);
		$Net=str_replace(",",".",$Fila[v_neto]);
		$Resta=$Act-$Net;
		$ArrValores[$i][23]=str_replace(".",",",$Resta); //AmortEjercicioAct
		$Consulta="select * from fico_relacion_numsap_rut where rut='".$Fila["rut"]."' ";
		$RespSap=mysqli_query($link, $Consulta);
		if($FilaSap=mysqli_fetch_array($RespSap))
			$ArrValores[$i][24]=$FilaSap[num_personal]; //NumeroPersonal
		else
			$ArrValores[$i][24]="99999999"; //NO TIENE Q HABER NINGUN REGISTRO CON ESTE N�
		$ArrValores[$i][25]=$Descripcion2; //descripcion sobre 50 caracteres
		$SUMA=$SUMA+$Act;
		$i=$i+1;
	}
	CreaArchivo("FicoActivoFijo", $NomArchivo, "generados/fico", $ArrValores);	
}
/**Presupuesto**/
function FicoCreaArchivoPresupuesto($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="FicoPresupuesto.txt";
	$ArrValores=array();
	$Cont=0;
	/*NO BORRAR POR NINGUN MOTIVO
	$Consulta="select centro_costo,clase_costo, ";
	$Consulta.=" sum(enero) as enero,sum(febrero) as febrero ,sum(marzo) as marzo, ";
	$Consulta.=" sum(abril) as abril,sum(mayo) as mayo ,sum(junio) as junio, ";
	$Consulta.=" sum(julio) as julio,sum(agosto) as agosto ,sum(septiembre) as septiembre, ";
	$Consulta.=" sum(octubre) as octubre,sum(noviembre) as noviembre ,sum(diciembre) as diciembre ";
	$Consulta.=" from fico_presup_gastos_mantencion ";
	$Consulta.=" group by clase_costo,centro_costo order by centro_costo,clase_costo ";
	$RespAct=mysqli_query($link, $Consulta);
	while($FilaAct=mysqli_fetch_array($RespAct))
	{
		$Consulta=" select * from fico_presupuesto where clase_costo='".$FilaAct[clase_costo]."' ";
		$Consulta.=" and centro_costo='".$FilaAct[centro_costo]."'";
		$RespExi=mysqli_query($link, $Consulta);
		if($FilaExi=mysqli_fetch_array($RespExi))
		{
			if($FilaAct[enero] >=0) 
				$Actualizar="UPDATE fico_presupuesto set enero=(enero+(".str_replace(",",".",$FilaAct[enero]).")) , ";		
			else
				$Actualizar="UPDATE fico_presupuesto set enero=(enero+(".str_replace(",",".",$FilaAct[enero]).")) , ";		
			if($FilaAct[febrero] >=0) 
				$Actualizar.="	febrero=(febrero+(".str_replace(",",".",$FilaAct[febrero]).")), ";
			else
				$Actualizar.="	febrero=(febrero+(".str_replace(",",".",$FilaAct[febrero]).")), ";
			if($FilaAct[marzo] >=0) 
				$Actualizar.="	marzo=(marzo+(".str_replace(",",".",$FilaAct[marzo]).")) , ";
			else
				$Actualizar.="	marzo=(marzo+(".str_replace(",",".",$FilaAct[marzo]).")) , ";
			if($FilaAct[abril] >=0) 	
				$Actualizar.="	abril=(abril+(".str_replace(",",".",$FilaAct[abril]).")) , ";
			else
				$Actualizar.="	abril=(abril+(".str_replace(",",".",$FilaAct[abril]).")) , ";
			if($FilaAct[mayo] >=0)
				$Actualizar.="	mayo=(mayo+(".str_replace(",",".",$FilaAct[mayo]).")) , ";
			else 		
				$Actualizar.="	mayo=(mayo+(".str_replace(",",".",$FilaAct[mayo]).")) , ";
			if($FilaAct[junio] >=0)	
				$Actualizar.="	junio=(junio+(".str_replace(",",".",$FilaAct[junio]).")) , ";
			else
				$Actualizar.="	junio=(junio+(".str_replace(",",".",$FilaAct[junio]).")) , ";
			if($FilaAct[julio] >=0)		
				$Actualizar.="	julio=(julio+(".str_replace(",",".",$FilaAct[julio]).")) , ";
			else
				$Actualizar.="	julio=(julio+(".str_replace(",",".",$FilaAct[julio]).")) , ";
			if($FilaAct[agosto] >=0)		
				$Actualizar.="	agosto=(agosto+(".str_replace(",",".",$FilaAct[agosto]).")) , ";
			else
				$Actualizar.="	agosto=(agosto+(".str_replace(",",".",$FilaAct[agosto]).")) , ";
			if($FilaAct[septiembre] >=0)			
				$Actualizar.="	septiembre=(septiembre+(".str_replace(",",".",$FilaAct[septiembre]).")) , ";
			else
				$Actualizar.="	septiembre=(septiembre+(".str_replace(",",".",$FilaAct[septiembre]).")) , ";
			if($FilaAct[octubre] >=0)			
				$Actualizar.="	octubre=(octubre+(".str_replace(",",".",$FilaAct[octubre]).")) , ";
			else
				$Actualizar.="	octubre=(octubre+(".str_replace(",",".",$FilaAct[octubre]).")) , ";
			if($FilaAct[noviembre] >=0)				
				$Actualizar.="	noviembre=(noviembre+(".str_replace(",",".",$FilaAct[noviembre]).")) , ";
			else	
				$Actualizar.="	noviembre=(noviembre+(".str_replace(",",".",$FilaAct[noviembre]).")) , ";
			if($FilaAct[diciembre] >=0)					
				$Actualizar.="	diciembre=(diciembre+(".str_replace(",",".",$FilaAct[diciembre])."))  ";
			else
				$Actualizar.="	diciembre=(diciembre+(".str_replace(",",".",$FilaAct[diciembre])."))  ";
			$Actualizar.=" where clase_costo='".$FilaAct[clase_costo]."' and centro_costo='".$FilaAct[centro_costo]."' ";
			mysqli_query($link, $Actualizar);
		}
		else
		{
			$Insertar="INSERT INTO fico_presupuesto (centro_costo,clase_costo, ";
			$Insertar.=" enero,febrero,marzo,abril,mayo,junio,julio,agosto,septiembre,octubre ";
			$Insertar.=" ,noviembre,diciembre ) values ";
			$Insertar.=" ('".$FilaAct[centro_costo]."','".$FilaAct[clase_costo]."', ";
			$Insertar.="  ".str_replace(",",".",$FilaAct[enero]).",".str_replace(",",".",$FilaAct[febrero]).", ";
			$Insertar.="  ".str_replace(",",".",$FilaAct[marzo])." , ".str_replace(",",".",$FilaAct[abril]).", ";
			$Insertar.="  ".str_replace(",",".",$FilaAct[mayo])." , ".str_replace(",",".",$FilaAct[junio]).", ";
			$Insertar.="  ".str_replace(",",".",$FilaAct[julio])." , ".str_replace(",",".",$FilaAct[agosto]).", ";
			$Insertar.="  ".str_replace(",",".",$FilaAct[septiembre])." , ".str_replace(",",".",$FilaAct[octubre]).", ";
			$Insertar.="  ".str_replace(",",".",$FilaAct[noviembre])." , ".str_replace(",",".",$FilaAct[diciembre]).") ";
			mysqli_query($link, $Insertar);
		}	
	}NO BORRAR*/
	$Consulta="select centro_costo,clase_costo,centro_costo_sap, ";
	$Consulta.=" sum(enero) as enero,sum(febrero) as febrero ,sum(marzo) as marzo, ";
	$Consulta.=" sum(abril) as abril,sum(mayo) as mayo ,sum(junio) as junio, ";
	$Consulta.=" sum(julio) as julio,sum(agosto) as agosto ,sum(septiembre) as septiembre, ";
	$Consulta.=" sum(octubre) as octubre,sum(noviembre) as noviembre ,sum(diciembre) as diciembre ";
	$Consulta.=" from fico_presupuesto t1 ";
	$Consulta.=" inner join fico_homologa_cc t2 on t1.centro_costo=t2.centro_costo_enm ";
	$Consulta.=" where centro_costo not in ('8100','8140','8200','8000','1041','1042','1040','1221') and clase_costo not in ('690815','690631') ";
	$Consulta.=" and (enero > 0 or febrero > 0 or marzo > 0 or abril > 0 or mayo > 0 or junio > 0 ";
	$Consulta.=" or julio > 0 or agosto > 0 or septiembre > 0 or octubre > 0 or  noviembre > 0 or diciembre >0) ";
	$Consulta.=" group by clase_costo,centro_costo_sap order by centro_costo,clase_costo ";
	$Respuesta=mysqli_query($link, $Consulta);
	$i=0;
	$cont=0;
	$cont1=0;
	while($Fila=mysqli_fetch_array($Respuesta))
	{
			//ESTO ES PQ CALCULA EL 80% DE LOS VALORES PARA ESTOS CE_COSTOS
			if($Fila[centro_costo]=='3400' || $Fila[centro_costo]=='4107' || $Fila[centro_costo]=='4100' || $Fila[centro_costo]=='4500' )
			{
				$i++;
				$ArrValores[$i][1]="CL01"; //sociedad(CL01)
				$ArrValores[$i][2]="ZSAP101"; //Perfil(ZSAP101)
				$ArrValores[$i][3]="000"; //Version(000)
				$ArrValores[$i][4]="01"; //PeriodoDesde
				$ArrValores[$i][5]="12"; //PeriodoHasta
				$ArrValores[$i][6]="2006"; //Ejercicio
				$ArrValores[$i][7]=$Fila["centro_costo_sap"]; //CentroCosto
				$ArrValores[$i][8]=$Fila["clase_costo"]; //ClaseCosto
				$ArrValores[$i][9]="X"; //COPN
				$ArrValores[$i][10]=""; //Formulario
				$Enero=$Fila[enero];
				$ArrValores[$i][11]=($Enero*(80/100));//Mes1 
				$Febrero=$Fila[febrero];
				$ArrValores[$i][12]=($Febrero*(80/100));//Mes2 
				$Marzo=$Fila[marzo];
				$ArrValores[$i][13]=($Marzo*(80/100));//Mes3 
				$Abril=$Fila[abril];
				$ArrValores[$i][14]=($Abril*(80/100));//Mes4 
				$Mayo=$Fila[mayo];
				$ArrValores[$i][15]=($Mayo*(80/100));//Mes5 
				$Junio=$Fila[junio];
				$ArrValores[$i][16]=($Junio*(80/100));//Mes6 
				$Julio=$Fila[julio];
				$ArrValores[$i][17]=($Julio*(80/100));//Mes7 
				$Agosto=$Fila[agosto];
				$ArrValores[$i][18]=($Agosto*(80/100));//Mes8 
				$Septiembre=$Fila[septiembre ];
				$ArrValores[$i][19]=($Septiembre*(80/100));//Mes9
				$Octubre=$Fila[octubre];
				$ArrValores[$i][20]=($Octubre*(80/100));//Mes10 
				$Noviembre=$Fila[noviembre];
				$ArrValores[$i][21]=($Noviembre*(80/100));//Mes11 
				$Diciembre=$Fila[diciembre];
				$ArrValores[$i][22]=($Diciembre*(80/100));//Mes12 
				$i++;
				//ESTO ES PQ CALCULA EL 20% DE LOS VALORES PARA ESTOS CE_COSTOS(LA DIFERENCIA DEL 80%)
				switch($Fila[centro_costo])
				{
					case "3400"://
						$CCosto='FF650';
					break;
					case "4107"://
						$CCosto='FS828';
					break;
					case "4100"://
						$CCosto='FS829';
					break;
					case "4500"://
						$CCosto='FS869';
					break;
				}
				$ArrValores[$i][1]="CL01"; //sociedad(CL01)
				$ArrValores[$i][2]="ZSAP101"; //Perfil(ZSAP101)
				$ArrValores[$i][3]="000"; //Version(000)
				$ArrValores[$i][4]="01"; //PeriodoDesde
				$ArrValores[$i][5]="12"; //PeriodoHasta
				$ArrValores[$i][6]="2006"; //Ejercicio
				$ArrValores[$i][7]=$CCosto; //CentroCosto
				$ArrValores[$i][8]=$Fila["clase_costo"]; //ClaseCosto
				$ArrValores[$i][9]="X"; //COPN
				$ArrValores[$i][10]=""; //Formulario
				$Enero=$Fila[enero];
				$ArrValores[$i][11]=($Enero*(20/100));//Mes1 
				$Febrero=$Fila[febrero];
				$ArrValores[$i][12]=($Febrero*(20/100));//Mes2 
				$Marzo=$Fila[marzo];
				$ArrValores[$i][13]=($Marzo*(20/100));//Mes3 
				$Abril=$Fila[abril];
				$ArrValores[$i][14]=($Abril*(20/100));//Mes4 
				$Mayo=$Fila[mayo];
				$ArrValores[$i][15]=($Mayo*(20/100));//Mes5 
				$Junio=$Fila[junio];
				$ArrValores[$i][16]=($Junio*(20/100));//Mes6 
				$Julio=$Fila[julio];
				$ArrValores[$i][17]=($Julio*(20/100));//Mes7 
				$Agosto=$Fila[agosto];
				$ArrValores[$i][18]=($Agosto*(20/100));//Mes8 
				$Septiembre=$Fila[septiembre ];
				$ArrValores[$i][19]=($Septiembre*(20/100));//Mes9
				$Octubre=$Fila[octubre];
				$ArrValores[$i][20]=($Octubre*(20/100));//Mes10 
				$Noviembre=$Fila[noviembre];
				$ArrValores[$i][21]=($Noviembre*(20/100));//Mes11 
				$Diciembre=$Fila[diciembre];
				$ArrValores[$i][22]=($Diciembre*(20/100));//Mes12 
			}
			else{//ESTO ES PARA EL RESTO DE LOS CECOS NO INCLUIDOS EN LA CONDICICIONANTE ANTERIOR
				//SI HAY ACTUALIZACIONES DEL PRESUPUESTO SE DEBE PEDIR A LOS USUARIOS LOS REGISTROS CON EL 
				//SGTE FORMATO CECOS(YA SEA EN ENM O EN SAP)-CLASE COSTO - MESES(ENERO-DICIEMBRE) 
				//SE DEBE DESACTIVAR TODAS LAS LINEAS ANTERIORES Y ACTIVAR DE AQUI PARA ADELANTE
				//Y LOS DATOS RECIBIDOS SUBIRLOS A EXCEL Y REEMPLAZAR LA QUERY 
				$cont1++;
				$i++;
				$ArrValores[$i][1]="CL01"; //sociedad(CL01)
				$ArrValores[$i][2]="ZSAP101"; //Perfil(ZSAP101)
				$ArrValores[$i][3]="000"; //Version(000)
				$ArrValores[$i][4]="01"; //PeriodoDesde
				$ArrValores[$i][5]="12"; //PeriodoHasta
				$ArrValores[$i][6]="2006"; //Ejercicio
				$ArrValores[$i][7]=$Fila["centro_costo_sap"]; //CentroCosto
				$ArrValores[$i][8]=$Fila["clase_costo"]; //ClaseCosto
				$ArrValores[$i][9]="X"; //COPN
				$ArrValores[$i][10]=""; //Formulario
				$Enero=$Fila[enero];
				$ArrValores[$i][11]=$Enero;//Mes1 
				$Febrero=$Fila[febrero];
				$ArrValores[$i][12]=$Febrero;//Mes2 
				$Marzo=$Fila[marzo];
				$ArrValores[$i][13]=$Marzo;//Mes3 
				$Abril=$Fila[abril];
				$ArrValores[$i][14]=$Abril;//Mes4 
				$Mayo=$Fila[mayo];
				$ArrValores[$i][15]=$Mayo;//Mes5 
				$Junio=$Fila[junio];
				$ArrValores[$i][16]=$Junio;//Mes6 
				$Julio=$Fila[julio];
				$ArrValores[$i][17]=$Julio;//Mes7 
				$Agosto=$Fila[agosto];
				$ArrValores[$i][18]=$Agosto;//Mes8 
				$Septiembre=$Fila[septiembre ];
				$ArrValores[$i][19]=$Septiembre;//Mes9
				$Octubre=$Fila[octubre];
				$ArrValores[$i][20]=$Octubre;//Mes10 
				$Noviembre=$Fila[noviembre];
				$ArrValores[$i][21]=$Noviembre;//Mes11 
				$Diciembre=$Fila[diciembre];
				$ArrValores[$i][22]=$Diciembre;//Mes12 
			}
	}
	CreaArchivo("FicoPresupuesto", $NomArchivo, "generados/fico", $ArrValores);	
}	

function FicoCreaArchivoPresupuestoHistorico($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="FicoReal2005.txt";
	$ArrValores=array();
	$Cont=0;
	$Consulta="select c_costo,clase_costo ";	
	$Consulta.=" from fico_presupuesto_historico t1 ";
	$Consulta.=" group by c_costo,clase_costo order by  c_costo,clase_costo ";
	$Respuesta=mysqli_query($link, $Consulta);
	$i=0;
	$cont=0;
	$cont1=0;
	$Datos=array();
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$Indice=$Fila[c_costo].$Fila[clase_costo];
		$Datos[$Indice][0]=$Indice;
		$Datos[$Indice][13]="CL01"; //sociedad(CL01)
		$Datos[$Indice][14]="ZSAP101"; //Perfil(ZSAP101)
		$Datos[$Indice][15]="000"; //Version(000)
		$Datos[$Indice][16]="01"; //PeriodoDesde
		$Datos[$Indice][17]="12"; //PeriodoHasta
		$Datos[$Indice][18]="2005"; //Ejercicio
		$Datos[$Indice][19]=$Fila["centro_costo_sap"]; //CentroCosto
		$Datos[$Indice][20]=$Fila["clase_costo"]; //ClaseCosto
		$Datos[$Indice][21]="X"; //COPN
	}
	$Consulta="select c_costo,clase_costo,mes, orden, ";
	$Consulta.=" sum(saldo) as suma_total ";
	$Consulta.=" from fico_presupuesto_historico t1 ";
	$Consulta.=" group by c_costo,clase_costo,mes order by  c_costo,clase_costo,orden ";
	$Respuesta=mysqli_query($link, $Consulta);
	$i=0;
	$cont=0;
	$cont1=0;
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$Indice=$Fila[c_costo].$Fila[clase_costo];
		//echo $Fila[orden]."/".$Fila[suma_total]."<br>";
		$Datos[$Indice][$Fila[orden]]=$Fila[suma_total];
	}
	reset($Datos);
	foreach($Datos as $k => $v)
	{
		//echo $k."<br>";
		$i2=$i2+1;
		$ArrValores[$i2][1]="CL01"; //sociedad(CL01)
		$ArrValores[$i2][2]="ZSAP101"; //Perfil(ZSAP101)
		$ArrValores[$i2][3]="000"; //Version(000)
		$ArrValores[$i2][4]="01"; //PeriodoDesde
		$ArrValores[$i2][5]="12"; //PeriodoHasta
		$ArrValores[$i2][6]="2005"; //Ejercicio
		$CCosto=substr($k,0,4);
		$Consulta="select * from  fico_homologa_cc_martin where centro_costo_enm='".$CCosto."' ";
		//echo $Consulta."<br>";
		$RespCC=mysqli_query($link, $Consulta);
		if($FilaCC=mysqli_fetch_array($RespCC))
			$ArrValores[$i2][7]=$FilaCC["centro_costo_sap"];//$k; //CentroCosto		
		else
			echo $CCosto."<br>";	
		$ArrValores[$i2][8]=substr($k,4,strlen($k));//substr($k,4,strlen($k)); //ClaseCosto
		$ArrValores[$i2][9]="X"; //COPN
		$ArrValores[$i2][10]=""; //Formulario
		$cont=11;
		for ($i=1;$i<=12;$i++)
		{
			$ArrValores[$i2][$cont]=$v[$i]; //Formulario
			$cont++;
		}
	}
		CreaArchivo("FicoPresupuesto", $NomArchivo, "generados/fico", $ArrValores);	
}


/**Boletas de Garantia Pendientes**/
function FicoCreaArchivoBoletasPen($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="FicoBoletasGarantiasPen.txt";
	$ArrValores=array();
	$Consulta=" select * from fico_boletas_garantia_pen t1  ";
	$Consulta.=" inner join fico_boletas_rechazadas t2 ";
	$Consulta.=" on t1.RUT=t2.rut_maestro and t1.bolgar=t2.boleta";
	//echo $Consulta;
	$Respuesta=mysqli_query($link, $Consulta);
	$i=1;
	$correlativo=0;
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$Ano=substr($Fila["FECHA2"],6,2);
		$Mes=substr($Fila["FECHA2"],3,2);
		$Dia=substr($Fila["FECHA2"],0,2);
		$ArrValores[$i][1]=$Dia.$Mes.'20'.$Ano; //FechaDocumento
		$ArrValores[$i][2]="KA"; //ClaseDocumento
		$ArrValores[$i][3]="CL01"; //Sociedad
		$ArrValores[$i][4]="01012006"; //FechaContabilizacion
		$ArrValores[$i][5]="01"; //Periodo
		$ArrValores[$i][6]=$Fila["TIPO_MON"]; //Moneda(CLP,UF,USD,etc)
		$ArrValores[$i][7]=$Fila["BOLGAR"]; //Referencia
		$ArrValores[$i][8]="Carga Inic.Bol.Garantias"; //TextoCabecera
		$ArrValores[$i][9]="29"; //ClaveContab
		$ArrValores[$i][10]="G"; //Cme
		if((substr($Fila["RUT"],0,1)=='0'))
			$ArrValores[$i][11]=substr($Fila["RUT"],1,strlen($Fila["RUT"])); //CodigoProveedor
		else
			$ArrValores[$i][11]=$Fila["RUT"]; //CodigoProveedor
		$ArrValores[$i][12]="FV01"; //Division
		$ArrValores[$i][13]=$Fila["VALOR $"]; //Importe
		if($Fila["VENCIM"]=='A LA VISTA')
			$FechaVen='31032006';
			else{
				$AnoV=substr($Fila["VENCIM"],0,4);
				$MesV=substr($Fila["VENCIM"],5,2);
				$DiaV=substr($Fila["VENCIM"],8,2);
				$FechaVen=$DiaV.$MesV.$AnoV;
			}		
		$ArrValores[$i][14]=$FechaVen; //FechaVence
		if ((is_null($Fila["NOT"]))|| ($Fila["NOT"]=='')){
			$correlativo++;
			$ArrValores[$i][15]=$correlativo; //Asignacion
		}
		else{
			$ArrValores[$i][15]=$Fila["NOT"]; //Asignacion		
		}
		$ArrValores[$i][16]=$Fila["DESCRIPCION"]; //Texto
		$i++;
	}		
	CreaArchivo("FicoBolGarPen", $NomArchivo, "generados/fico", $ArrValores);	
}















































/**Maestro MiscelaneosAnterior"NO BORRAR POR SI ACASO"**/
/*function FicoCreaArchivoMaestroMisc($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="FicoMaestroMiscelaneo.txt";
	$ArrValores=array();
	$Consulta=" select * from fico_clientes_miscelaneos ";
	$Respuesta=mysqli_query($link, $Consulta);
	$i=0;
	$correlativo=0;
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$Correl=$Fila[correlativo]-1;
		$Actualizar="UPDATE fico_clientes_miscelaneos set direccion='".$Fila["direccion"]."', ";
		$Actualizar.=" comuna='".$Fila["comuna"]."',pais='".$Fila[pais]."' ";
		$Actualizar.=" where correlativo='".$Correl."' and rut <> 1 ";
		mysqli_query($link, $Actualizar);
	}
	$Consulta=" select * from fico_clientes_miscelaneos where rut <> 1";
	$Respuesta=mysqli_query($link, $Consulta);
	$i=0;
	$correlativo=0;
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		
		/*Desactivar
		$Actualizar="UPDATE fico_clientes_miscelaneos set rut='".str_replace(".","",$Fila["rut"])."' ";
		$Actualizar.=" where correlativo='".$Fila[correlativo]."' and rut <> 1 ";
		mysqli_query($link, $Actualizar);*/
/*		$Consulta="select * from fico_funcionarios where rut ='".$Fila["rut"]."' ";
		$RespHr=mysqli_query($link, $Consulta);
		if(!($FilaHr=mysqli_fetch_array($RespHr)))
		{
			$Rut=str_replace(".","",$Fila["rut"]);
			$Datos=explode(' ',$Fila[razon_social]);
			$ArrValores[$i][1]=str_pad($Rut,10,'0',l_pad); //CodigoClienteMisc
			$ArrValores[$i][2]=str_replace("?","�",$Fila["razon_social"]); //NombreApellido
			$ArrValores[$i][3]=str_replace("?","�",str_replace(",","",$Datos[1])); //ApellidoPaterno
			$Direccion='';
			if ((is_null($Fila["direccion"]))||($Fila["direccion"]==''))
			{
				$Consulta="select * from fico_maestro_procomi where rut='".$Fila[rut]."' ";
				$RespPro=mysqli_query($link, $Consulta);
				if($FilaPro=mysqli_fetch_array($RespPro))
				{
					$Direccion=$FilaPro["direccion"];
				}
				
			}
			else{
				$Direccion=$Fila["direccion"];
			}
			$ArrValores[$i][4]=str_replace("?","�",$Direccion); //Direccion
			$Consulta="select * from comunas t1 ";
			$Consulta.=" inner join comunas_por_ciudad t2 ON ";
			$Consulta.=" t1.COD_COMUNA=t2.COD_COMUNA  ";
			$Consulta.=" inner join ciudades t3 ON ";
			$Consulta.=" t2.COD_CIUDAD=t3.COD_CIUDAD ";
			$Consulta.=" inner join ciudades_por_region t4 ON"; 
			$Consulta.=" t3.COD_CIUDAD=t4.COD_CIUDAD	";
			$Consulta.="where NOM_COMUNA=ucase('".$Fila[comuna]."')";
			$RespCom=mysqli_query($link, $Consulta);
			$Ciudad='';
			$Region='';
			if($FilaCom=mysqli_fetch_array($RespCom))
			{
				$Ciudad=$FilaCom["NOM_CIUDAD"];
				if ($FilaCom["COD_REGION"]=='13')
					$Region='RM';
					else
						$Region=str_pad($FilaCom["COD_REGION"],2,'0',l_pad);
			}
			$ArrValores[$i][5]=$Ciudad; //Ciudad
			$ArrValores[$i][6]=$Fila["comuna"]; //Comuna
			$ArrValores[$i][7]=$Region; //region
			$ArrValores[$i][8]="Z090"; //ramo
			$ArrValores[$i][9]=str_pad($Rut,10,'0',l_pad); //rut*/		
		/*	$i++;
		}
	}
	echo "rut ".$FunFila[rut].""." cuenta_procomi  ".$FunFila["cta_cte"]."=="."cuenta_comparativo  ".$FunFila["cta_cte_mae"]."<br>";
	CreaArchivo("FicoMaestroCliMis", $NomArchivo, "generados/fico", $ArrValores);		
}	*/
function FicoCreaArchivoMaestroMisc($NomArchivo)
{
	if ($NomArchivo=="")
		$NomArchivo="FicoMaestroMiscelaneo.txt";
	$ArrValores=array();
	$Consulta=" select * from fico_maestro_clientes_mis t1 ";
	$Consulta.=" inner join fico_maestro_clientes_miscelaneos_no_cargado t2 ";
	$Consulta.=" on t1.rut=t2.rut";
	$Respuesta=mysqli_query($link, $Consulta);
	$i=0;
	$correlativo=0;
	//echo $Consulta."<br>";
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$Consulta="select * from fico_funcionarios where rut ='".$Fila["rut"]."' ";
		$RespHr=mysqli_query($link, $Consulta);
		if(!($FilaHr=mysqli_fetch_array($RespHr)))
		{
			if ((!is_null($Fila["direccion"])) ||($Fila["direccion"] <> ""))
			{
				$Datos=explode(' ',$Fila["razon_social"]);
				if($Datos[1]=='')
					$Datos=explode('  ',$Fila["razon_social"]);
				$ArrValores[$i][1]=$Fila["rut"]; //CodigoClienteMisc
				$ArrValores[$i][2]=str_replace("?","�",str_replace(",","",$Fila["razon_social"])); //NombreApellido
				if($Datos[1]=='')
					$ArrValores[$i][3]=str_replace("?","�",str_replace(",","",$Datos[0])); //ApellidoPaterno
				else
					$ArrValores[$i][3]=str_replace("?","�",str_replace(",","",$Datos[1])); //ApellidoPaterno
				$ArrValores[$i][4]=str_replace("?","�",$Fila["direccion"]); //Direccion
				$ArrValores[$i][5]=str_replace("?","�",$Fila["ciudad"]); //Ciudad
				$ArrValores[$i][6]=str_replace("?","�",$Fila["comuna"]); //Comuna
				if ($Fila["region"]=='13')
					$Region='RM';
					else
						$Region=str_pad($Fila["region"],2,'0',l_pad);
				$ArrValores[$i][7]=$Region; //Comuna
				$ArrValores[$i][8]="Z090"; //ramo
				//$ArrValores[$i][9]=str_pad($Fila["rut"],10,' ',l_pad); //rut*/		
				$ArrValores[$i][9]=$Fila["rut"]; //rut*/		
				$i++;
			}
		}		
	}
		CreaArchivo("FicoMaestroCliMis", $NomArchivo, "generados/fico", $ArrValores);		
}
?>
