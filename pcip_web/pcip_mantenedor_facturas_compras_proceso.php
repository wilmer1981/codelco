<? include("../principal/conectar_pcip_web.php");

$Consulta="select cod_subclase,nombre_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31016' ";			
$RespTipoProc=mysqli_query($link, $Consulta);
if($FilaTipoProc=mysql_fetch_array($RespTipoProc))
	$Iva=$FilaTipoProc["valor_subclase1"];

if($Volver=='S')
{
	if($Valores=='S')
		$Opc='N';
	else
		$Opc='M';
}
if(!isset($CmbFactNot))
    $CmbFactNot='N';	
if ($Opc=='M')
{
    $Correlativo='1';
	$Consulta="select t1.estado_actual,t1.codigo,t3.cod_subclase,t3.nombre_subclase,t1.rut_proveedor,t1.cod_contrato,t1.cod_producto,t2.nom_producto,t1.tipo,t1.num_factura,t1.fecha_emision,t1.cuota,t1.cod_mercado,t1.observacion";
	$Consulta.=" from pcip_fac_compra t1 inner join pcip_fac_productos_facturas t2 on t1.cod_producto=t2.cod_producto";
	$Consulta.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31017' and t3.cod_subclase=t1.tipo";
	$Consulta.=" where t1.codigo='".$Cod."'";
	//echo $Consulta."<br>";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
	    $TxtCodigo=$Fila["codigo"];
		$CmbRutProveedor=$Fila["rut_proveedor"];
		if(!isset($Recarga2))
		{
			$CmbContrato=$Fila["cod_contrato"];
			$CmbProducto=$Fila["cod_producto"];
		}		
		$CmbProdMine=$Fila["cod_producto"];		
		$TxtNuFact=$Fila["num_factura"];
		$TxtFecha=$Fila["fecha_emision"];
		$CmbCuota=$Fila["cuota"];
		$CmbTipoContrato=$Fila["tipo"];
		$CmbMercado=$Fila["cod_mercado"];
		$TexObs=$Fila["observacion"];
		if(!isset($CmbTipo)&&isset($Mensaje))
			$CmbTipo=$Fila["estado_actual"];
		$CheckDef='';
		if($Fila["estado_actual"]=='2')
		{
		 //echo "entrooooooo";
			$Consulta = "select correlativo,numero from pcip_fac_compra_finos_relacion where tipo_factura='2' and codigo='".$TxtCodigo."' order by numero";			
			$Resp2=mysqli_query($link, $Consulta);
			if(!$Fila2=mysql_fetch_array($Resp2))
			{
				$CmbTipo=1;
				$CheckDef='checked';
			}
		}
	}
	if(!isset($CmbTipo))	
	    	$CmbTipo='1';
	if ($CmbTipo=='1')//PROVISORIA
	{
		$Consulta=" select valor_neto,iva,valor_total,cambio from pcip_fac_compra_finos_relacion";
		$Consulta.=" where codigo='".$TxtCodigo."' and correlativo='1'";
		$Resp=mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		if($Fila=mysql_fetch_array($Resp))
		{
		  $TxtNeto=$Fila["valor_neto"];
		  $TxtIva=$Fila["iva"];
		  $TxtTotal=$Fila["valor_total"];
		  $TxtEuro=$Fila["cambio"];
		}
	}
	if($CmbTipo=='2')//DEFINITIVA
	{
		$TxtNeto='0';$TxtNeto1='0';$TxtIva='0';$TxtTotal='0';$TxtNuDeCr='';$TxtFechaDebitoCredito='';$NomNetoAnterior='';
		$Datos=explode('~',$CmbFactNot);
		$Correlativo=$Datos[1];	
		$Consulta=" select numero,correlativo,iva,valor_total,valor_neto,fecha_debito_credito,tipo_nota from pcip_fac_compra_finos_relacion";
		$Consulta.=" where codigo='".$TxtCodigo."' and numero='".$Datos[0]."' and correlativo='".$Correlativo."'";
		$Resp=mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		if($Fila=mysql_fetch_array($Resp))
		{
		  $TxtNeto=$Fila["valor_neto"];
		  $TxtIva=$Fila["iva"];
		  $TxtTotal=$Fila["valor_total"];
		  $Correlativo=$Fila["correlativo"];
		  $TxtNuDeCr=$Fila["numero"];
		  $TxtFechaDebitoCredito=$Fila["fecha_debito_credito"];
		  $CmbDeCre=$Fila["tipo_nota"];
		}				
		$Consulta=" select ifnull(count(*),0) as cant from pcip_fac_compra_finos_relacion";
		$Consulta.=" where codigo='".$TxtCodigo."' and tipo_nota='".$CmbDeCre."' ";
		$Resp=mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		$Fila=mysql_fetch_array($Resp);
		$CantDef=$Fila["cant"];	
		if($CantDef>1&&$Correlativo!='')
		{
			$Consulta=" select valor_neto,valor_neto2,tipo_factura from pcip_fac_compra_finos_relacion";
			$Consulta.=" where codigo='".$TxtCodigo."' and numero<>'".$Datos[0]."' and correlativo<>'".$Correlativo."' and fecha_debito_credito<'".$TxtFechaDebitoCredito."' order by fecha_debito_credito desc";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			if($Fila=mysql_fetch_array($Resp))
			{
				 if($Fila["tipo_factura"]=='2') 
				 {
					$TxtNeto1=$Fila["valor_neto2"];				 
					$NomNetoAnterior="Factura NC/ND";
				 }
				 else
				 {
					$TxtNeto1=$Fila["valor_neto"];				 
					$NomNetoAnterior="Factura Provisoria";
				 }	
			}		
		}
		else
		{
			$Consulta=" select fecha_debito_credito,valor_neto,valor_neto2,tipo_factura from pcip_fac_compra_finos_relacion";
			$Consulta.=" where codigo='".$TxtCodigo."' order by fecha_debito_credito";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			if($Fila=mysql_fetch_array($Resp))
			{
				 if($Fila["tipo_factura"]=='2') 
				 {
					$TxtNeto1=$Fila["valor_neto2"];	
					//echo $TxtNeto1."<br>";
					$NomNetoAnterior="Factura NC/ND";
				 }
				 else
				 {
					$TxtNeto1=$Fila["valor_neto"];
					//echo $TxtNeto1."<br>";
					$NomNetoAnterior="Factura Provisoria";
				 }	
			}		
		}
	}
	$TipoProc='';
	$Consulta="select distinct(cod_fino) from pcip_fac_compra_finos where codigo='".$TxtCodigo."' and correlativo='".$Correlativo."'";
	//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
		$TipoProc=$Fila[cod_fino]."~".$TipoProc;
	$TipoProc=substr($TipoProc,0,strlen($TipoProc)-1);
		
}
if(!isset($CmbTipo))	
		$CmbTipo='1';
if($Opc=='N')
{
	$Consulta1=" select t1.rut_proveedor,t1.cod_producto,t1.tipo_contrato,t1.cod_mercado from pcip_fac_contratos_compra t1";
	$Consulta1.=" where t1.cod_contrato='".$CmbContrato."' ";
	$Resp1=mysql_query($Consulta1);
	//echo  $Consulta1;
	if($Fila1=mysql_fetch_array($Resp1))
	{
		$CmbRutProveedor=$Fila1["rut_proveedor"];
		$CmbProdMine=$Fila1["cod_producto"];
		$CmbTipoContrato=$Fila1["tipo_contrato"];	
		$CmbMercado=$Fila1["cod_mercado"];	
	}
}	
if(isset($ValoresCadena))	
	$TipoProc=$ValoresCadena;

?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nueva Factura</title>";
		else	
			echo "<title>Modificar Factura</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function QuitarMiles()
{
	var f=document.FrmPopupProceso;
	
	for (i=1;i<f.elements.length;i++)
	{
		var Nom= f.elements[i].id;
		//alert(Nom);					    
		if(Nom=='MTR11')
		{
			f.MTR11.value=ReemplazarComasPorPuntos(f.MTR11.value.toString());
			f.MTR21.value=ReemplazarComasPorPuntos(f.MTR21.value.toString());
			f.MTR31.value=ReemplazarComasPorPuntos(f.MTR31.value.toString());
			f.MTR41.value=ReemplazarComasPorPuntos(f.MTR41.value.toString());
		}
		if(Nom=='MTR12')
		{
			f.MTR12.value=ReemplazarComasPorPuntos(f.MTR12.value.toString());
			f.MTR22.value=ReemplazarComasPorPuntos(f.MTR22.value.toString());
			f.MTR32.value=ReemplazarComasPorPuntos(f.MTR32.value.toString());
			f.MTR42.value=ReemplazarComasPorPuntos(f.MTR42.value.toString());
		}
		if(Nom=='MTR13')
		{
			f.MTR13.value=ReemplazarComasPorPuntos(f.MTR13.value.toString());
			f.MTR23.value=ReemplazarComasPorPuntos(f.MTR23.value.toString());
			f.MTR33.value=ReemplazarComasPorPuntos(f.MTR33.value.toString());
			f.MTR43.value=ReemplazarComasPorPuntos(f.MTR43.value.toString());
		}
		if(Nom=='MTR14')
		{
			f.MTR14.value=ReemplazarComasPorPuntos(f.MTR14.value.toString());
			f.MTR24.value=ReemplazarComasPorPuntos(f.MTR24.value.toString());
			f.MTR34.value=ReemplazarComasPorPuntos(f.MTR34.value.toString());
			f.MTR44.value=ReemplazarComasPorPuntos(f.MTR44.value.toString());
		}
		if(Nom=='MTR15')
		{
			f.MTR15.value=ReemplazarComasPorPuntos(f.MTR15.value.toString());
			f.MTR25.value=ReemplazarComasPorPuntos(f.MTR25.value.toString());
			f.MTR35.value=ReemplazarComasPorPuntos(f.MTR35.value.toString());
			f.MTR45.value=ReemplazarComasPorPuntos(f.MTR45.value.toString());
		}

		if(Nom=='MTR50')
		   f.MTR50.value=ReemplazarComasPorPuntos(f.MTR50.value.toString());
		if(Nom=='MTR60')
		   f.MTR60.value=ReemplazarComasPorPuntos(f.MTR60.value.toString());
		if(Nom=='MTR70')
		   f.MTR70.value=ReemplazarComasPorPuntos(f.MTR70.value.toString());
		if(Nom=='MTR80')
		   f.MTR80.value=ReemplazarComasPorPuntos(f.MTR80.value.toString());
		if(Nom=='MTR90')
		   f.MTR90.value=ReemplazarComasPorPuntos(f.MTR90.value.toString());
		if(Nom=='MTR100')
		   f.MTR100.value=ReemplazarComasPorPuntos(f.MTR100.value.toString());
		if(Nom=='MTR110')
		   f.MTR110.value=ReemplazarComasPorPuntos(f.MTR110.value.toString());
		if(Nom=='MTR120')
		   f.MTR120.value=ReemplazarComasPorPuntos(f.MTR120.value.toString());
		if(Nom=='MTR130')
		   f.MTR130.value=ReemplazarComasPorPuntos(f.MTR130.value.toString());
	}
	if(f.CmbTipo.value==2)
	{	    	   
		f.TxtNeto1.value=ReemplazarComasPorPuntos(f.TxtNeto1.value.toString());
	}
	
}
function PoneMiles()
{
	var f=document.FrmPopupProceso;
	for (i=1;i<f.elements.length;i++)
	{
		var Nom= f.elements[i].id;
		if(Nom=='MTR11')
		{
			f.MTR11.value=formatNumber(f.MTR11.value,'');
			f.MTR21.value=formatNumber(f.MTR21.value,'');
			f.MTR31.value=formatNumber(f.MTR31.value,'');
			f.MTR41.value=formatNumber(f.MTR41.value,'');
		}
		if(Nom=='MTR12')
		{
			f.MTR12.value=formatNumber(f.MTR12.value,'');
			f.MTR22.value=formatNumber(f.MTR22.value,'');
			f.MTR32.value=formatNumber(f.MTR32.value,'');
			f.MTR42.value=formatNumber(f.MTR42.value,'');
		}
		if(Nom=='MTR13')
		{
			f.MTR13.value=formatNumber(f.MTR13.value,'');
			f.MTR23.value=formatNumber(f.MTR23.value,'');
			f.MTR33.value=formatNumber(f.MTR33.value,'');
			f.MTR43.value=formatNumber(f.MTR43.value,'');
		}
		if(Nom=='MTR14')
		{
			f.MTR14.value=formatNumber(f.MTR14.value,'');
			f.MTR24.value=formatNumber(f.MTR24.value,'');
			f.MTR34.value=formatNumber(f.MTR34.value,'');
			f.MTR44.value=formatNumber(f.MTR44.value,'');
		}
		if(Nom=='MTR15')
		{
			f.MTR15.value=formatNumber(f.MTR15.value,'');
			f.MTR25.value=formatNumber(f.MTR25.value,'');
			f.MTR35.value=formatNumber(f.MTR35.value,'');
			f.MTR45.value=formatNumber(f.MTR45.value,'');
		}
		if(Nom=='MTR50')
		   f.MTR50.value=formatNumber(f.MTR50.value,'');
		if(Nom=='MTR60')
		   f.MTR60.value=formatNumber(f.MTR60.value,'');
		if(Nom=='MTR70')
		   f.MTR70.value=formatNumber(f.MTR70.value,'');
		if(Nom=='MTR80')
		   f.MTR80.value=formatNumber(f.MTR80.value,'');
		if(Nom=='MTR90')
		   f.MTR90.value=formatNumber(f.MTR90.value,'');
		if(Nom=='MTR100')
		   f.MTR100.value=formatNumber(f.MTR100.value,'');
		if(Nom=='MTR110')
		   f.MTR110.value=formatNumber(f.MTR110.value,'');
		if(Nom=='MTR120')
		   f.MTR120.value=formatNumber(f.MTR120.value,'');
		if(Nom=='MTR130')
		   f.MTR130.value=formatNumber(f.MTR130.value,'');
			
	}
	f.TxtIva.value=formatNumber(f.TxtIva.value,'');
	if(f.CmbTipo.value==2)
	{	    	   
		f.TxtNeto1.value=formatNumber(f.TxtNeto1.value,'');
	}	
	f.TxtNeto.value=formatNumber(f.TxtNeto.value,'');
	f.TxtRcCu.value=formatNumber(f.TxtRcCu.value,'');
	f.TxtRcAg.value=formatNumber(f.TxtRcAg.value,'');
	f.TxtRcAu.value=formatNumber(f.TxtRcAu.value,'');
	f.TxtTcCu.value=formatNumber(f.TxtTcCu.value,'');

}
function Calcula()
{
	var f=document.FrmPopupProceso;
	var Neto=parseInt(f.TxtNeto.value);
	var iv=parseInt(f.Iva.value);
	var IvaAux=0;	
	var PagablePrecioCu=0;
	var PagableMasaCu=0;
	var PagablePrecioAg=0;
	var PagableMasaAg=0;
	var PagablePrecioAu=0;
	var PagableMasaAu=0;
	var PagableMasaOtro=0;
	var PagablePrecioOtro=0;
	var PagableMasaOtro2=0;
	var PagablePrecioOtro2=0;
	var	Tms=0;Tmh=0;RcCu=0;RcAg=0;RcAu=0;TcCu=0;Trans=0;Pena=0;Otro=0;
	
	QuitarMiles();
	for (i=1;i<f.elements.length;i++)
	{
		var Nom= f.elements[i].id;					    
		if(Nom=='MTR21'&&f.elements[i].value!='')
		   PagableMasaCu=parseFloat(f.elements[i].value);
		if(Nom=='MTR31'&&f.elements[i].value!='')
		   PagablePrecioCu=parseFloat(f.elements[i].value);
	}
	if(PagableMasaCu!=0&&PagablePrecioCu!=0)
	{
		f.MTR41.value=Math.round(Conversion(f.CmbUnidad31.value,f.CmbUnidad21.value,PagablePrecioCu,PagableMasaCu)*100)/100;
		//alert(f.MTR41.value);
	}	
	for (i=1;i<f.elements.length;i++)
	{
		var Nom= f.elements[i].id;					    
		if(Nom=='MTR22'&&f.elements[i].value!='')
		   PagableMasaAg=parseFloat(f.elements[i].value);
		if(Nom=='MTR32'&&f.elements[i].value!='')
		   PagablePrecioAg=parseFloat(f.elements[i].value);
	}
	if(PagableMasaAg!=0&&PagablePrecioAg!=0)
	{
		f.MTR42.value=Math.round(Conversion(f.CmbUnidad32.value,f.CmbUnidad22.value,PagablePrecioAg,PagableMasaAg)*100)/100;
		//alert(f.MTR42.value);
	}
	for (i=1;i<f.elements.length;i++)
	{
		var Nom= f.elements[i].id;					    
		if(Nom=='MTR23'&&f.elements[i].value!='')
		   PagableMasaAu=parseFloat(f.elements[i].value);
		if(Nom=='MTR33'&&f.elements[i].value!='')
		   PagablePrecioAu=parseFloat(f.elements[i].value);
	}	
	if(PagableMasaAu!=0&&PagablePrecioAu!=0)
	{
		f.MTR43.value=Math.round(Conversion(f.CmbUnidad33.value,f.CmbUnidad23.value,PagablePrecioAu,PagableMasaAu)*100)/100;					
		//alert(f.MTR43.value);
	}	
	for (i=1;i<f.elements.length;i++)
	{
		var Nom= f.elements[i].id;					    
		if(Nom=='MTR24'&&f.elements[i].value!='')
		   PagableMasaOtro=parseFloat(f.elements[i].value);
		if(Nom=='MTR34'&&f.elements[i].value!='')
		   PagablePrecioOtro=parseFloat(f.elements[i].value);
	}
	if(PagableMasaOtro!=0&&PagablePrecioOtro!=0)
		f.MTR44.value=Math.round(Conversion(f.CmbUnidad34.value,f.CmbUnidad24.value,PagablePrecioOtro,PagableMasaOtro)*100)/100;			
	for (i=1;i<f.elements.length;i++)
	{
		var Nom= f.elements[i].id;					    
		if(Nom=='MTR25'&&f.elements[i].value!='')
		   PagableMasaOtro2=parseFloat(f.elements[i].value);
		if(Nom=='MTR35'&&f.elements[i].value!='')
		   PagablePrecioOtro2=parseFloat(f.elements[i].value);
	}
	if(PagableMasaOtro2!=0&&PagablePrecioOtro2!=0)
		f.MTR45.value=Math.round(Conversion(f.CmbUnidad35.value,f.CmbUnidad25.value,PagablePrecioOtro2,PagableMasaOtro2)*100)/100;		
	for (i=1;i<f.elements.length;i++)
	{
		var Nom= f.elements[i].id;	 
		if(Nom=='MTR50'&&f.elements[i].value!='')
		   Tms=parseFloat(f.elements[i].value);		   
		if(Nom=='MTR60'&&f.elements[i].value!='')
		   Tmh=parseFloat(f.elements[i].value);
		if(Nom=='MTR70'&&f.elements[i].value!='')
		   RcCu=parseFloat(f.elements[i].value);	
		if(Nom=='MTR80'&&f.elements[i].value!='')
		   RcAg=parseFloat(f.elements[i].value);
		if(Nom=='MTR90'&&f.elements[i].value!='')
		   RcAu=parseFloat(f.elements[i].value);
		if(Nom=='MTR100'&&f.elements[i].value!='')
		   TcCu=parseFloat(f.elements[i].value);
		if(Nom=='MTR110'&&f.elements[i].value!='')
		   Trans=parseFloat(f.elements[i].value);
		if(Nom=='MTR120'&&f.elements[i].value!='')
		   Pena=parseFloat(f.elements[i].value);
		if(Nom=='MTR130'&&f.elements[i].value!='')
		   Otro=parseFloat(f.elements[i].value);
	}
	//alert(Tms);	
	f.TxtRcCu.value=0;f.TxtRcAg.value=0;f.TxtRcAu.value=0;f.TxtTcCu.value=0;
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="CheckTipoProc" && f.elements[i].checked==true)
		{
			if(f.elements[i].value=='1'&&parseFloat(f.MTR21.value)!=0)
				f.TxtRcCu.value=Math.round(Conversion(f.CmbUnidad70.value,f.CmbUnidad21.value,RcCu,f.MTR21.value)*100)/100;
			if(f.elements[i].value=='2'&&parseFloat(f.MTR22.value)!=0)
				f.TxtRcAg.value=Math.round(Conversion(f.CmbUnidad80.value,f.CmbUnidad22.value,RcAg,f.MTR22.value)*100)/100;
			if(f.elements[i].value=='3'&&parseFloat(f.MTR23.value)!=0)
				f.TxtRcAu.value=Math.round(Conversion(f.CmbUnidad90.value,f.CmbUnidad23.value,RcAu,f.MTR23.value)*100)/100;
			if(f.elements[i].value=='4'&&parseFloat(f.MTR24.value)!=0)
				f.TxtRcCu.value=Math.round(Conversion(f.CmbUnidad70.value,f.CmbUnidad24.value,RcCu,f.MTR24.value)*100)/100;
			if(f.elements[i].value=='5'&&parseFloat(f.MTR25.value)!=0)
				f.TxtRcCu.value=Math.round(Conversion(f.CmbUnidad70.value,f.CmbUnidad25.value,RcCu,f.MTR25.value)*100)/100;
		}	
	}
	if(Tms!=0)
	{	
		f.TxtTcCu.value=Conversion(f.CmbUnidad100.value,f.CmbUnidad50.value,TcCu,Tms);	
		Pena=Math.round(Conversion(f.CmbUnidad120.value,f.CmbUnidad50.value,Pena,Tms)*100)/100;
	}
	if(Tmh!=0)
	{
		Trans=Math.round(Conversion(f.CmbUnidad110.value,f.CmbUnidad60.value,Trans,Tmh)*100)/100;	
		Otro=Math.round(Conversion(f.CmbUnidad130.value,'',Otro,1)*100)/100;
	}
	f.TxtNeto.value=0;
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="CheckTipoProc" && f.elements[i].checked==true)
		{
			if(f.elements[i].value=='1'&&f.MTR41.value!='')
				f.TxtNeto.value=parseFloat(f.TxtNeto.value)+parseFloat(f.MTR41.value);
			if(f.elements[i].value=='2'&&f.MTR42.value!='')
				f.TxtNeto.value=parseFloat(f.TxtNeto.value)+parseFloat(f.MTR42.value);
			if(f.elements[i].value=='3'&&f.MTR43.value!='')
				f.TxtNeto.value=parseFloat(f.TxtNeto.value)+parseFloat(f.MTR43.value);
			if(f.elements[i].value=='4'&&f.MTR44.value!='')
				f.TxtNeto.value=parseFloat(f.TxtNeto.value)+parseFloat(f.MTR44.value);
			if(f.elements[i].value=='5'&&f.MTR45.value!='')
				f.TxtNeto.value=parseFloat(f.TxtNeto.value)+parseFloat(f.MTR45.value);
		}	
	}	
	f.TxtNeto.value=parseFloat(f.TxtNeto.value)-parseFloat(f.TxtRcCu.value)-parseFloat(f.TxtRcAg.value)-parseFloat(f.TxtRcAu.value)-parseFloat(f.TxtTcCu.value)-Trans-Pena-Otro;
	f.TxtNeto.value=Math.round(f.TxtNeto.value*100)/100;
	f.TxtNeto.value=Math.abs(f.TxtNeto.value);
	f.TxtIva.value=0;
	
	if(f.TxtNeto.value>0 && f.OptIva.checked==true)
	{	
		IvaAux=parseFloat(f.TxtNeto.value)*0.19;
		f.TxtIva.value=Math.round(parseFloat(IvaAux)*100)/100;			
	}
	f.TxtTotal.value=Math.round((parseFloat(f.TxtIva.value)+parseFloat(f.TxtNeto.value))*100)/100;	
	f.TxtTotal.value=formatNumber(f.TxtTotal.value,'');
	if(f.CmbTipo.value==2&&f.TxtNeto.value>0)
	{	    	   
		IvaAux2=0;
		f.TxtAfecto.value=Math.abs(f.TxtNeto.value-(parseFloat(f.TxtNeto1.value)));
		if(f.OptIva.checked==true)
			IvaAux2=parseFloat(f.TxtAfecto.value)*0.19;
		f.TxtIva.value=Math.round(parseFloat(IvaAux2)*100)/100;
		f.TxtTotal.value=parseFloat(f.TxtAfecto.value)+parseFloat(f.TxtIva.value);
		f.TxtAfecto.value=formatNumber(Math.round(f.TxtAfecto.value*100)/100,'');
		f.TxtTotal.value=formatNumber(Math.round(f.TxtTotal.value*100)/100,'');
	}
	PoneMiles();
}
function formatNumber(num,prefix)//FUNCION PARA DEJAR CON MILES LOS RESULTADOS
{
prefix = prefix || '';
num += '';
var splitStr = num.split('.');
var splitLeft = splitStr[0];
var splitRight = splitStr.length > 1 ? ',' + splitStr[1] : '';
var regx = /(\d+)(\d{3})/;
while (regx.test(splitLeft)) {
splitLeft = splitLeft.replace(regx, '$1' + '.' + '$2');
}
return prefix + splitLeft + splitRight;
} 
function unformatNumber(num) 
{
return num.replace(/([^0-9\.\-])/g,'')*1;
}
function Conversion(UnidRc,UnidFinos,ValorRc,ValorFino)
{
	var f=document.FrmPopupProceso;
	ValorUS=0;
	ValorEuro=0;
	

	//alert("Antes:"+ValorRc);
	//alert("Antes:"+ValorFino);

	//ValorRc=ReemplazarComasPorPuntos(ValorRc.toString());
	//ValorFino=ReemplazarComasPorPuntos(ValorFino.toString());

	//ValorRc=unformatNumber(ValorRc.toString());
	//ValorFino=unformatNumber(ValorFino.toString());

	//alert("Despues:"+ValorRc);
	//alert("Despues:"+ValorFino);

	switch(UnidRc)
	{
		case "6"://[USC/LB]
			switch(UnidFinos)
			{
				case "1"://{Ton}
					//alert("en la funcion"+ValorRc);
					//alert("en la funcion"+ValorFino);
					ValorUS=ValorRc*ValorFino*1000*(1/0.4535924)*(1/100);
					break;	
				case "2"://{Gr}
					ValorUS=ValorRc*ValorFino*(1/1000)*(1/0.4535924)*(1/100);
					break;	
				case "3"://{Oz}
					ValorUS=ValorRc*ValorFino*0.0686*(1/100);
					break;	
				case "4"://{Lb}
					ValorUS=ValorRc*ValorFino*(1/100);
					break;	
				case "5"://{Kg}
					ValorUS=ValorRc*ValorFino*(1/0.4535924)*(1/100);
					break;	
			}
			break;	
		case "7"://[US$/LB]
			switch(UnidFinos)
			{
				case "1"://{Ton}
					ValorUS=ValorRc*ValorFino*1000*(1/0.4535924);
					break;	
				case "2"://{Gr}
					ValorUS=ValorRc*ValorFino*(1/1000)*(1/0.4535924);
					break;	
				case "3"://{Oz}
					ValorUS=ValorRc*ValorFino*0.0686;
					break;	
				case "4"://{Lb}
					ValorUS=ValorRc*ValorFino;
					break;	
				case "5"://{Kg}
					ValorUS=ValorRc*ValorFino*(1/0.4535924);
					break;	
			}
			break;	
		case "8"://[US$/Oz]
			switch(UnidFinos)
			{
				case "1"://{Ton}
					ValorUS=ValorRc*ValorFino*1000*(1/31.10347768);
					break;	
				case "2"://{Gr}
					ValorUS=ValorRc*ValorFino*(1/31.10347768);
					break;	
				case "3"://{Oz}
					ValorUS=ValorRc*ValorFino;
					break;	
				case "4"://{Lb}
					ValorUS=ValorRc*ValorFino*(1/0.0686);
					break;	
				case "5"://{Kg}
					ValorUS=ValorRc*ValorFino*(1/31.10347768);
					break;	
			}
			break;	
		case "9"://[Euro/Kg]
			if(f.TxtEuro.value!='')
			{
				ValorEuro=ReemplazarComasPorPuntos(f.TxtEuro.value);
				switch(UnidFinos)
				{
					case "1"://{Ton}
						ValorUS=ValorRc*ValorFino*1000*(ValorEuro/1);
						break;	
					case "2"://{Gr}
						ValorUS=ValorRc*ValorFino*(1/1000)*(ValorEuro/1);
						break;	
					case "3"://{Oz}
						ValorUS=ValorRc*ValorFino*(1/32.15074657)*(ValorEuro/1);
						break;	
					case "4"://{Lb}
						ValorUS=ValorRc*ValorFino*(0.45359237/1)*(ValorEuro/1);
						break;	
					case "5"://{Kg}
						ValorUS=ValorRc*ValorFino*(ValorEuro/1);
						break;	
				}
			}
			else
			{
				alert('Debe Ingresar Valor Euro');
				f.TxtEuro.focus();
			}
			break;	
		case "10"://[US$/Kg]
			switch(UnidFinos)
			{
				case "1"://{Ton}
					ValorUS=ValorRc*ValorFino*1000;
					break;	
				case "2"://{Gr}
					ValorUS=ValorRc*ValorFino*(1/1000);
					break;	
				case "3"://{Oz}
					ValorUS=ValorRc*ValorFino*(1/32.15074657);
					break;	
				case "4"://{Lb}
					ValorUS=ValorRc*ValorFino*(0.45359237/1);
					break;	
				case "5"://{Kg}
					ValorUS=ValorRc*ValorFino;
					break;	
			}
			break;	
		case "11"://[US$/Gr]
			switch(UnidFinos)
			{
				case "1"://{Ton}
					ValorUS=ValorRc*ValorFino*1000000;
					break;	
				case "2"://{Gr}
					ValorUS=ValorRc*ValorFino;
					break;	
				case "3"://{Oz}
					ValorUS=ValorRc*ValorFino*(32.1034768);
					break;	
				case "4"://{Lb}
					ValorUS=ValorRc*ValorFino*((0.45359237*1000)/1);
					break;	
				case "5"://{Kg}
					ValorUS=ValorRc*ValorFino*(1000/1);
					break;	
			}
			break;	
		case "12"://[US$/TMS]
		case "15"://[US$/TMH]
			switch(UnidFinos)
			{
				case "1"://{Ton}
					ValorUS=ValorRc*ValorFino;
					break;	
				case "5"://{Kg}
					ValorUS=ValorRc*ValorFino*(1/1000);
					//alert(ValorUS);
					break;	
			}
			break;	
		case "13"://[Euro/TMS]
		case "14"://[Euro/TMH]
			ValorEuro=ReemplazarComasPorPuntos(f.TxtEuro.value);
			switch(UnidFinos)
			{
				case "1"://{Ton}
					ValorUS=ValorRc*ValorFino*(ValorEuro/1);
					break;	
				case "5"://{Kg}
					ValorUS=ValorRc*ValorFino*(1/1000)*(ValorEuro/1);
					break;	
			}
			break;	
		case "16"://[EURO]
			ValorEuro=ReemplazarComasPorPuntos(f.TxtEuro.value);
			ValorUS=ValorRc*ValorFino*(ValorEuro/1);
			break;
		case "17"://US$
			ValorUS=ValorRc;
			break;
		case "18"://[US$/Ton]
			switch(UnidFinos)
			{
				case "1"://{Ton}
					ValorUS=ValorRc*ValorFino;
					break;	
				case "2"://{Gr}
					ValorUS=ValorRc*ValorFino*(1/1000000);
					break;	
				case "3"://{Oz}
					ValorUS=ValorRc*ValorFino*(1000*32.15074657);
					break;	
				case "4"://{Lb}
					ValorUS=ValorRc*ValorFino*(1/1000)*(0.45359237/1);
					break;	
				case "5"://{Kg}
					ValorUS=ValorRc*ValorFino*(1/1000);
					break;	
			}
			break;
		case "21"://[USC/Oz]
			switch(UnidFinos)
			{
				case "1"://{Ton}
					ValorUS=ValorRc*ValorFino*1000*(1/31.10347768)*(1/100);
					break;	
				case "2"://{Gr}
					ValorUS=ValorRc*ValorFino*(1/31.10347768)*(1/100);
					break;	
				case "3"://{Oz}
					ValorUS=ValorRc*ValorFino*(1/100);
					break;	
				case "4"://{Lb}
					ValorUS=ValorRc*ValorFino*(1/0.0686)*(1/100);
					break;	
				case "5"://{Kg}
					ValorUS=ValorRc*ValorFino*(1/31.10347768)*(1/100);
					break;	
			}
			break;
	}
	return(ValorUS);
}

function ReemplazarComasPorPuntos(Str)
{
	Str=Str.replace( /\./g,'');
	return(Str.replace(',','.'));
}
function ReemplazarPuntos(Str)
{
	return(Str.replace('.',''));
}
function ReemplazarPuntosPorComas(Str)
{
	return(Str.replace('.',','));
}

function HabilitaEuro()
{
	var f=document.FrmPopupProceso;
	
	if(f.CmbUnidad70.value=='9'||f.CmbUnidad80.value=='9'||f.CmbUnidad90.value=='9'||f.CmbUnidad100.value=='13'||f.CmbUnidad110.value=='14'||f.CmbUnidad120.value=='13'||f.CmbUnidad130.value=='16')
	{
		f.TxtEuro.style.visibility='';
		f.NomEuro.style.visibility='';
		f.TxtUS.style.visibility='';
	}
	else
	{
		f.TxtEuro.style.visibility='hidden';	
		f.NomEuro.style.visibility='hidden';
		f.TxtUS.style.visibility='hidden';
	}
}
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	var Valida=true;
	var Veri="";
	var Check="";
	switch(Opcion)
	{
		case "N":
				if(f.TxtNuFact.value=='')
				{
					alert("Debe Ingresar N� Factura");
					f.TxtNuFact.focus();
					return;
				}	
				if(f.TxtFecha.value=='')
				{
					alert("Debe Seleccionar fecha Emision");
					f.TxtFecha.focus();
					return;
				}			
				if(f.CmbCuota.value=='')
				{
					alert("Debe Seleccionar Cuota");
					f.CmbCuota.focus();
					return;
				}	
				if(f.CmbTipo.value=='2'&& f.CmbFactNot.value!='N')
				{
					if(f.TxtNuDeCr.value=='')
					{
					alert("Debe Ingresar Numero de Nota");
					f.TxtNuDeCr.focus();
					return;
					}
					if(f.TxtFechaDebitoCredito.value=='')
					{
					alert("Debe Seleccionar fecha de Nota");
					f.TxtFechaDebitoCredito.focus();
					return;
					}
				}
				var Valores2='';
				for (i=1;i<f.elements.length;i++)
				{
					if (f.elements[i].name=="CheckTipoProc" && f.elements[i].checked==true)
					{
						Valores2 = Valores2+f.elements[i].name+"~";
					}	
				}					
				if(Valores2=='')					
				{		
					alert('Debe Seleccionar Finos Contenido');
					f.elements.focus();
					return;				
				}
				var Valores='';								
				for (i=1;i<f.elements.length;i++)
				{
					var Nom= f.elements[i].name					    
					if(Nom.substring(0,3)=='MTR')
					{
					   Valores = Valores+f.elements[i].name+"||"+f.elements[i].value+"||"+f.elements[i+1].value+"//";
					}   																		
				}
				Valores=Valores.substr(0,Valores.length-2);
				var EsDefinitiva='1';
				if(f.Definitiva.checked==true)
					EsDefinitiva='2';
				if(f.TxtNeto.value>99999999.99||f.TxtTotal.value>99999999.99)	
				{
					alert('Valor Neto o Valor Total Excede a lo Permitido');
					return;				
				}
				f.action= "pcip_mantenedor_facturas_compras_proceso01.php?Opcion="+Opcion+"&Valores="+Valores+"&EstadoFact="+EsDefinitiva;
				f.submit();
				break;				   							
		case "M":
				if(f.CmbTipo.value=='2'&& f.CmbFactNot.value!='N')
				{
					if(f.TxtNuDeCr.value=='')
					{
					alert("Debe Ingresar Numero de Nota");
					f.TxtNuDeCr.focus();
					return;
					}
					if(f.TxtFechaDebitoCredito.value=='')
					{
					alert("Debe Seleccionar fecha de Nota");
					f.TxtFechaDebitoCredito.focus();
					return;
					}
				}
				var Valores2='';
				for (i=1;i<f.elements.length;i++)
				{
					if (f.elements[i].name=="CheckTipoProc" && f.elements[i].checked==true)
					{
						Valores2 = Valores2+f.elements[i].name+"~";
					}	
				}					
				if(Valores2=='')					
				{		
				alert('Debe Seleccionar Finos Contenido');
				f.elements.focus();
				return;				
				}
				var Valores='';								
				for (i=1;i<f.elements.length;i++)
				{
					var Nom= f.elements[i].name					    
					if(Nom.substring(0,3)=='MTR')
					{
					   Valores = Valores+f.elements[i].name+"||"+f.elements[i].value+"||"+f.elements[i+1].value+"//";
					}   																		
				}
				Valores=Valores.substr(0,Valores.length-2);
				var EsDefinitiva='1';
				if(f.CmbTipo.value=='1')
				{
					if(f.Definitiva.checked==true)
						EsDefinitiva='2';
			    }
				if(f.TxtNeto.value>99999999.99||f.TxtTotal.value>99999999.99)	
				{
					alert('Valor Neto o Valor Total Excede a lo Permitido');
					return;				
				}
				f.action = "pcip_mantenedor_facturas_compras_proceso01.php?Opcion="+Opcion+"&Cod="+f.Cod.value+"&Valores="+Valores+"&EstadoFact="+EsDefinitiva;
				f.submit();
        		break;
		case "R":
				var Valores2='';
				for (i=1;i<f.elements.length;i++)
				{
					if (f.elements[i].name=="CheckTipoProc" && f.elements[i].checked==true)
					{
						Valores2 = Valores2+f.elements[i].value+"~";
					}	
				}
		        f.action="pcip_mantenedor_facturas_compras_proceso.php?Recarga=S&TipoProc="+Valores2;
				f.submit();
			    break;	
		case "R1":
				var Valores2='';
				for (i=1;i<f.elements.length;i++)
				{
					if (f.elements[i].name=="CheckTipoProc" && f.elements[i].checked==true)
					{
						Valores2 = Valores2+f.elements[i].value+"~";
					}	
				}	
		        f.action="pcip_mantenedor_facturas_compras_proceso.php?Recarga=S&ValoresCadena="+Valores2;
				f.submit();
			    break;	
		case "R2":
		        f.action="pcip_mantenedor_facturas_compras_proceso.php?Recarga2=S";
				f.submit();
			    break;					
		case "NI":
			    f.action = "pcip_mantenedor_facturas_compras_proceso01.php?Opcion="+Opcion;
			    f.submit();
		        break;
							
	}
}
function Eliminar(Valor)
{
	var f= document.FrmPopupProceso;
	if(confirm('Esta Seguro de Eliminar Nota de Debito O Credito'))
	{
	f.action = "pcip_mantenedor_facturas_compras_proceso01.php?Opcion=EI&Valores="+Valor;
	f.submit();
	}
}
function Salir()
{
	window.close();
}
</script>
</head>
<?
if ($Opc=='N')
	echo '<body>';
	else
		echo '<body>';
?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<input type="hidden" name="Cod" value="<? echo $Cod;?>">
<input type="hidden" name="Opc" value="<? echo $Opc;?>">
<input type="hidden" name="TxtCodigo" value="<? echo $TxtCodigo; ?>">
<input name="Iva" type="hidden" value="<? echo $Iva; ?>">			
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="../pcip_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="818" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../pcip_web/archivos/sub_tit_facturas_compras_n.png"><? }else{?>
         <img src="../pcip_web/archivos/sub_tit_facturas_compras_m.png"><?	}?></td>
       <td align="right">
	   <a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
	   <a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="../pcip_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a></td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center">
	   <table width="100%" border="0" cellpadding="3" cellspacing="0" >
				   <?
					 if($CmbTipo=='2' && $Opc=='M')
					 {				 
				   ?>
			     <tr>	
                  <td width="138" class="formulario2">&nbsp;</td>
                  <td width="232" class="formulario2" colspan="5">&nbsp;</td>
				  </tr>				     
				   <?
				    }
					else
					{
				   ?>				  				 
			     <tr>	
                 <td width="138" class="formulario2">Productos</td>
                 <td width="232" class="formulario2" colspan="5">
					<select name="CmbProducto" <? echo $Disabled; ?> onChange="Proceso('R2')">
					<option value="T" selected="selected">Todos</option>
					<?
					$ConsultaProducto = "select cod_producto,nom_producto from pcip_fac_productos_facturas order by cod_producto";							
					$RespProducto=mysql_query($ConsultaProducto);
						while ($FilaProducto=mysql_fetch_array($RespProducto))
						{
							if ($CmbProducto==$FilaProducto["cod_producto"])
								echo "<option selected value='".$FilaProducto["cod_producto"]."'>".$FilaProducto["cod_contrato"]." ".ucfirst($FilaProducto["nom_producto"])."</option>\n";
							else
								echo "<option value='".$FilaProducto["cod_producto"]."'>".$FilaProducto["cod_contrato"]." ".ucfirst($FilaProducto["nom_producto"])."</option>\n";
						}
					?>
					</select><? //echo $ConsultaProducto;	?>
					</td>
				  </tr>
					<?
					  }
					?>				  
			     <tr>	
                 <td width="138" class="formulario2">Contrato</td>
                 <td width="232" class="formulario2">
				   <?
					 if($CmbTipo=='2' && $Opc=='M')
					 {				 
					 echo $CmbContrato;
					 echo"<input type='hidden' name='CmbContrato' value='".$CmbContrato."'>";				  					 
					 }
					 else
					 {
					 if(!isset($CmbProducto))
					   $CmbProducto='T';
				   ?>				  				 
					<select name="CmbContrato" <? echo $Disabled; ?> onChange="Proceso('R2')">
					<option value="-1" selected="selected">Seleccionar</option>
					<?
					$ConsultaContrato= "select t1.cod_contrato from pcip_fac_contratos_compra t1 inner join pcip_fac_productos_facturas t2";
					$ConsultaContrato.= " on t1.cod_producto=t2.cod_producto where t2.cod_producto<>''";
					if($CmbProducto!='T')
						$ConsultaContrato.= " and t2.cod_producto='".$CmbProducto."'";			   
					$ConsultaContrato.= " order by t1.cod_contrato";					 			
					$RespContrato=mysql_query($ConsultaContrato);
						while ($FilaContrato=mysql_fetch_array($RespContrato))
						{
							if ($CmbContrato==$FilaContrato["cod_contrato"])
								echo "<option selected value='".$FilaContrato["cod_contrato"]."'>".ucfirst($FilaContrato["cod_contrato"])."</option>\n";
							else
								echo "<option value='".$FilaContrato["cod_contrato"]."'>".ucfirst($FilaContrato["cod_contrato"])."</option>\n";
						}
					?>
					</select><? //echo $ConsultaContrato;?>
					<span class="InputRojo">(*)</span>
			       <?
					  }
					?>				   </td>
				  <td width="92" class="formulario2">Tipo Contrato </td>
				  <td width="115" class="formulario2">
					<?
					$Consulta = "select t1.cod_subclase,t1.nombre_subclase as nom_tipo from pcip_fac_contratos_compra t2 ";
					$Consulta.= " inner join proyecto_modernizacion.sub_clase t1 on t1.cod_clase='31017' and t2.tipo_contrato=t1.cod_subclase";
					$Consulta.= " where t2.cod_contrato='".$CmbContrato."'";			
					$Resp=mysqli_query($link, $Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbTipoContrato==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nom_tipo"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nom_tipo"])."</option>\n";
					}	
					
					echo"<input type='hidden' name='CmbTipoContrato' value='".$CmbTipoContrato."'>";
					?>                  </td>
				  <td width="301" class="formulario2">Rut&nbsp;Proveedor&nbsp;&nbsp;&nbsp;&nbsp;
				   <?
					$Consulta = "select t1.rut_proveedor,t1.nom_proveedor,t2.nom_cliente from pcip_fac_proveedores t1 left join pcip_fac_contratos_compra t2";
					$Consulta.= " on t1.rut_proveedor=t2.rut_proveedor where t2.cod_contrato='".$CmbContrato."'";	
					$Resp=mysqli_query($link, $Consulta);
					if($Fila=mysql_fetch_array($Resp))
					{
						echo ucfirst($Fila["rut_proveedor"])."&nbsp;".$Fila["nom_proveedor"];
						echo"<input type='hidden' name='CmbRutProveedor' value='".$Fila["rut_proveedor"]."'>";
					}
									  	
					?>					</td>
			      <td width="137" class="formulario2">&nbsp;</td>
		        </tr>
				<tr>
				  <td width="138" class="formulario2">Cliente</td>
				  <td class="formulario2" colspan="5">
					<?
					$Consulta1 = "select nom_cliente from pcip_fac_contratos_compra ";
					$Consulta1.= " where cod_contrato='".$CmbContrato."'";	
					$Resp1=mysql_query($Consulta1);
					while ($Fila1=mysql_fetch_array($Resp1))
					{
						echo "&nbsp;".$Fila1["nom_cliente"];
					}										
					?>				  </td>
			    </tr>				
				  <tr><td width="138" class="formulario2">N&uacute;mero Factura</td>
				  <td width="232"  class="formulario2">
				   <?
					 if($CmbTipo=='2' && $Opc=='M')
					 {				 
					 echo $TxtNuFact;
					 echo"<input type='hidden' name='TxtNuFact' value='".$TxtNuFact."'>";				  					 
					 }
					 else
					 {
				   ?>				  
				  <input name="TxtNuFact" <? echo $Disabled; ?> maxlength= "10" type="text" id="TxtNuFact" style="width:100" value="<? echo $TxtNuFact; ?>" >
				  <span class="InputRojo">(*)</span><br>				  
				   <?
					  }
				   ?>				  </td>
				  <td width="92" class="formulario2">Producto&nbsp;Minero</td>
				  <td  class="formulario2" >
                    <?
					$Consulta = "select t1.cod_producto,t1.nom_producto from pcip_fac_productos_facturas t1 inner join";
					$Consulta.= " pcip_fac_contratos_compra t2 on t1.cod_producto=t2.cod_producto where cod_contrato='".$CmbContrato."'";			
					$Resp=mysqli_query($link, $Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbProdMine==$Fila["cod_producto"])
							echo "<option selected value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_producto"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_producto"])."</option>\n";
					}	
				    echo"<input type='hidden' name='CmbProdMine' value='".$CmbProdMine."'>";				  
				  ?>				  </td>
                  <td  class="formulario2">Mercado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?
					$Consulta = "select t1.cod_subclase,t1.nombre_subclase as nom_mercado from pcip_fac_contratos_compra t2 ";
					$Consulta.= " inner join proyecto_modernizacion.sub_clase t1 on t1.cod_clase='31008' and t1.cod_subclase=t2.cod_mercado";
					$Consulta.= " where t2.cod_contrato='".$CmbContrato."'";			
					$Resp=mysqli_query($link, $Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbMercado==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>&nbsp;&nbsp;".ucfirst($Fila["nom_mercado"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>&nbsp;&nbsp;".ucfirst($Fila["nom_mercado"])."</option>\n";
					}
					 echo"<input type='hidden' name='CmbMercado' value='".$CmbMercado."'>";				  	
				   ?></td>
			      <td  class="formulario2">&nbsp;</td>
			    </tr>
		   <tr>		   
			  <td width="138" class="formulario2">Fecha&nbsp;Emisi&oacute;n </td>
			  <td class="formulariosimple"><span class="formulario2">
			    <?
			    if($CmbTipo=='2' && $Opc=='M')
				{
				echo $TxtFecha;
 			    echo"<input type='hidden' name='TxtFecha' value='".$TxtFecha."'>";				  					 				
				}
				else
				{
			  ?>
                <input name="TxtFecha" <? echo $Disabled; ?> type="text" class="InputCen" value="<? echo $TxtFecha; ?>" size="10" maxlength="10" readonly>
                &nbsp;<img src="archivos/calendario.gif" <? echo $Disabled; ?> alt="Pulse Aqui ParaSeleccionar Fecha"  border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFecha,TxtFecha,popCal);return false"> <span class="InputRojo">(*)</span>
                <?
			    }
			  ?>
			  </span></td>
              <td align="left" class="formulario2">Cuota</td>
              <td height="17" colspan="4" align="left"  class="formulario2">&nbsp;&nbsp;&nbsp;
                <?
				if($CmbTipo=='2' && $Opc=='M')
				{
				echo substr($CmbCuota,0,4)." ". $Meses[intval(substr($CmbCuota,4)-1)];
				echo"<input type='hidden' name='CmbCuota' value='".$CmbCuota."'>";				  					 				
				}
				else
				{
				if(!isset($CmbCuota))
				{
					$CmbCuota=date('Y')." ".intval(date('m'));
				}
				?>
                <select name="CmbCuota"  <? echo $Disabled; ?>>
                  <?
					for ($i=date("Y")-1;$i<=date("Y");$i++)
					{
						for ($K=1;$K<=12;$K++)
						{
							$valorMes=$i." ".$K;
							if ($valorMes==$CmbCuota)
								echo "<option selected value=\"".$valorMes."\">".$i." ".$Meses[$K-1]."</option>\n";
							else
								echo "<option value=\"".$valorMes."\">".$i." ".$Meses[$K-1]."</option>\n";
						}					
					}
				   ?>
                </select>
                <span class="InputRojo">(*)</span>
                <?
				}
				?></td>
				</tr>
	      <tr>
		    <td height="17" class='formulario2'>Observaci&oacute;n</td>
		    <td height="17" colspan="8"  class='formulario2'><label>
		      <textarea name="TexObs" cols="80" rows="3"><? echo $TexObs;?></textarea>
		    </label></td>
		    </tr>
			<tr>
			<td height="17" class='formulario2'>Archivo</td>
			<td class="formulario2"><input type="file" name="Archivo" id="Archivo">
			<span class="titulo_rojo_tabla">(*)</span> </td>
			<td class="formulario2">&nbsp;</td>
			<td class="formulario2">&nbsp;</td>
			<td class="formulario2">				   
			<?
			 if($CmbTipo!='2')
		      {
			?>				   
		     Estado Definitiva &nbsp;<input type="checkbox" name="Definitiva" class="SinBorde" <? echo $CheckDef;?>>
			<?
			  }
			?>
			</td>
			<td class="formulario2">&nbsp;</td>
			</tr>  				   				
	      <tr>
		    <td height="17" class='formulario2'>Finos&nbsp;Contenidos</td>
		    <td height="17" colspan="8"  class='formulario2'>
			<? 			
			$arreglo=array();
			$Datos = explode("~",$TipoProc);
			$x=0;
			while (list($clave,$Codigo)=each($Datos))
			{
				$arreglo[$x][0]=$Codigo;
				$x=$x+1;
			}	
			$Consulta="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31012' order by cod_subclase";			
			$RespTipoProc=mysqli_query($link, $Consulta);
			while($FilaTipoProc=mysql_fetch_array($RespTipoProc))
			{
				echo $FilaTipoProc["nombre_subclase"]."&nbsp";
				echo "<input type='checkbox' name='CheckTipoProc' value='".$FilaTipoProc["cod_subclase"]."' class='SinBorde' onClick=Proceso('R1');"; 
				for($i=0;$i<=$x;$i++)
				{
					echo $arreglo[$i][0];
					if($FilaTipoProc["cod_subclase"]==$arreglo[$i][0])
						echo " checked ";	
				}
				echo "> &nbsp; &nbsp;";
			}
			?>
			<span class="InputRojo">(*)</span></td>
		    </tr>	   
			   <?
				if($Opc=='M')
				{
			   ?>	 					   	       
					<tr>
					<td height="17" class='formulario2'>Tipo</td>
					<td colspan="8" class='formulario2'> <select name="CmbTipo" onChange="Proceso('R')">
					<option value="S" selected="selected">Seleccionar</option>
					<?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31018' ";			
					$Resp=mysqli_query($link, $Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbTipo==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
					}	
					?>
					</select></td>
					</tr>
					<?
					if($Opc=='M' && $CmbTipo=='2')
					{
					 ?>
						<tr>
						<td height="17" class='formulario2'>Facturas/Notas </td>
						<td colspan="8" class='formulario2'><span class="formulariosimple">
						<select name="CmbFactNot" onChange="Proceso('R')">
						<option value="N" selected="selected">Nueva NC/ND</option>
						<?
						$Consulta = "select correlativo,numero from pcip_fac_compra_finos_relacion where tipo_factura='2' and codigo='".$TxtCodigo."' order by numero";			
						$Resp=mysqli_query($link, $Consulta);
						while ($Fila=mysql_fetch_array($Resp))
						{
							if ($CmbFactNot==$Fila["numero"]."~".$Fila["correlativo"])
								echo "<option value='".$Fila["numero"]."~".$Fila["correlativo"]."' selected>".ucfirst($Fila["numero"])."</option>\n";
							else
								echo "<option value='".$Fila["numero"]."~".$Fila["correlativo"]."'>".ucfirst($Fila["numero"])."</option>\n";
						}	
						?>
						</select><? //echo $Consulta;?>
							<?
							 if($CmbFactNot!='N')
							 {
							?> 
							<a href="JavaScript:Eliminar('<? echo $TxtCodigo."~".$CmbFactNot;?>')"><img src="../pcip_web/archivos/elim_hito2.png"  border="0"  alt=" Eliminar " align="absmiddle" width="20" height="20"></a>
							<?
							  }
							?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							N&uacute;mero&nbsp;Nota&nbsp;Debito o&nbsp;Cr&eacute;dito
							<input name="TxtNuDeCr" maxlength= "10" type="text" id="TxtNuDeCr" style="width:100" value="<? echo $TxtNuDeCr; ?>" >
							<span class="InputRojo">(*)</span>&nbsp;&nbsp;&nbsp;
							Fecha debito Credito
						    <input name="TxtFechaDebitoCredito" <? echo $Disabled; ?> type="text" class="InputCen" value="<? echo $TxtFechaDebitoCredito; ?>" size="10" maxlength="10" readonly>
						    &nbsp;<img src="archivos/calendario.gif" <? echo $Disabled; ?> alt="Pulse Aqui ParaSeleccionar Fecha"  border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaDebitoCredito,TxtFechaDebitoCredito,popCal);return false"> <span class="InputRojo">(*)</span>
					        <span class="FilaAbeja2">
							Tipo Nota Debito/Credito
							<select name="CmbDeCre">
							  <?
							switch($CmbDeCre)
							{
								case "1":
									echo "<option value='1' selected>Debito</option>";
									echo "<option value='2'>Credito</option>";
								break;
								case "2":
									echo "<option value='1'>Debito</option>";
									echo "<option value='2' selected>Credito</option>";
								break;
								default:
									echo "<option value='1'>Debito</option>";
									echo "<option value='2'>Credito</option>";
								break;	
							}
							?>
							</select><? //echo $CmbDeCre;?>
							<span class="InputRojo">(*)</span>
                            </span></td> 
					   ��
					</tr>  
					<?					
					}
				}
				else
					echo "<input name='CmbTipo' type='hidden'>";					
			    ?>
          <tr>
           <td colspan="9" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span><br><br>		   
             <table align="center" width="90%" border="1" cellpadding="4" cellspacing="0" >
               <tr align="center">
                 <td width="20%" class="TituloTablaVerde">Descripci&oacute;n</td>
				<? 						
				$Consulta="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31012' ";			
				$RespTipoProc=mysqli_query($link, $Consulta);
				while($FilaTipoProc=mysql_fetch_array($RespTipoProc))
				{
					for($i=0;$i<=$x;$i++)
					{
						if($FilaTipoProc["cod_subclase"]==$arreglo[$i][0])
						{		
						//echo $FilaTipoProc["cod_subclase"];					 
						 ?><td width="24%" class="TituloTablaVerde">Finos <? echo $FilaTipoProc["nombre_subclase"];?></td>
						 <?	
						}
					}
				}								
				?>				 				 					 
               </tr>
               <?		
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31000' and cod_subclase in ('1','2','4','3') ";					
				$Resp = mysqli_query($link, $Consulta);
				//echo $Consulta;
				while ($Fila=mysql_fetch_array($Resp))
				{				
					$Nom=$Fila["nombre_subclase"];
					$Cod=$Fila["cod_subclase"];
					$TxtTotal=0;		
					//$TxtIva=$TxtNeto*0.19;	
					$TxtTotal=$TxtNeto+$TxtIva;				
					?>
					<tr class="FilaAbeja">
					<td align="center"><? echo $Nom;?></td>
					<?
			        $Consulta="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31012'";			
					$RespTipoProce=mysqli_query($link, $Consulta);
					while($FilaTipoProce=mysql_fetch_array($RespTipoProce))
					{
						for($i=0;$i<=$x;$i++)
						{
							if($FilaTipoProce["cod_subclase"]==$arreglo[$i][0])
							{							 							   
								if($Opc=='M')
								{
								  	$Dato=ObtenerValorFino($TxtCodigo,$Fila["cod_subclase"],$FilaTipoProce["cod_subclase"],$Correlativo);
							   		$Valor=explode('~',$Dato);
								}								     
							   ?>
							   <td align="right">
							   <? //echo $Cod;
							   if($Cod=='4')//si es pagable para que sea readonly
							   {
							   ?>
							   <input name="MTR~<? echo $Fila["cod_subclase"]."~".$FilaTipoProce["cod_subclase"];?>" readonly="" maxlength= "16" type="text" id="MTR<? echo $Fila["cod_subclase"].$FilaTipoProce["cod_subclase"];?>" style="width:90" align="absmiddle" value="<? echo $Valor[0]; ?>" >&nbsp;
							   <?
							   } 
							   else
							   {
							  //echo $Fila["cod_subclase"]
							   ?>
							   <input name="MTR~<? echo $Fila["cod_subclase"]."~".$FilaTipoProce["cod_subclase"];?>" onKeyDown="SoloNumeros(true,this)" maxlength= "16" type="text" id="MTR<? echo $Fila["cod_subclase"].$FilaTipoProce["cod_subclase"];?>" style="width:90" align="absmiddle" value="<? echo number_format($Valor[0],5,',','.'); ?>" >&nbsp;
							   <?
							   }
							   ?> 
							   <select name="CmbUnidad~<? echo $Fila["cod_subclase"]."~".$FilaTipoProce["cod_subclase"];?>" style="width:70" id="CmbUnidad<? echo $Fila["cod_subclase"].$FilaTipoProce["cod_subclase"];?>">
							   <?
								$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31013' ";
								switch($Fila["cod_subclase"])
								{
									case "1":
										$Consulta.= " and cod_subclase in('1','2','3','4','5') ";
										break;
									case "2":
									    $Consulta.= " and cod_subclase in('1','2','3','4','5') ";
									    break;	
									case "3":
									    $Consulta.= " and cod_subclase in('18','8','7','11','10','18') ";
									    break;										
									case "4":
									    $Consulta.= " and cod_subclase in('17') ";
									    break;	
								}			
								$RespUnid=mysqli_query($link, $Consulta);
								while ($FilaUnid=mysql_fetch_array($RespUnid))
								{
									if ($Valor[1]==$FilaUnid["cod_subclase"])
										echo "<option selected value='".$FilaUnid["cod_subclase"]."'>".ucfirst($FilaUnid["nombre_subclase"])."</option>\n";
									else
										echo "<option value='".$FilaUnid["cod_subclase"]."'>".ucfirst($FilaUnid["nombre_subclase"])."</option>\n";
								}
							   ?>
						       </select><? //echo $Valor[1];
							   ?>							   </td>
							 <?	
							}
						}
					}
					?>
			       </tr>
				 <?						                 
				}								
         	     ?>
			   </table>
			   <table align="center" width="90%" border="1" cellpadding="4" cellspacing="0" >
                 <tr align="center"></tr>
                 <?
				 $OptEuro='hidden';		
				 $Consulta1 = "select cod_subclase,nombre_subclase,ceiling(valor_subclase1) as orden from proyecto_modernizacion.sub_clase where cod_clase='31000' and cod_subclase not in ('1','2','3','4') order by orden asc";					
				 $Resp1 = mysql_query($Consulta1);
				 //echo $Consulta;
				 while ($Fila1=mysql_fetch_array($Resp1))
				 {				
					$Nom=$Fila1["nombre_subclase"];
					if($Opc=='M')
					{
						$Dato2=ObtenerValorFino($TxtCodigo,$Fila1["cod_subclase"],'0',$Correlativo);
						$Valor2=explode('~',$Dato2);
					}								     
					if($Fila1["cod_subclase"]=='7')
					{
				 ?>
				  <tr class="FilaAbeja">
				   <td colspan="2" align="center" class="TituloTablaVerde">DEDUCCIONES</td>	
				   </tr>				 
				 <?
					}
				 ?>
				 <tr class="FilaAbeja">
                   <td align="center"><? echo $Nom;?></td>	
                   <td align="left">&nbsp;
				     <?
					  if( $Fila1["cod_subclase"]==13)//Otros para que ingrese numeros negativos
					  {
					 ?>
					 <input name="MTR~<? echo $Fila1["cod_subclase"]."~0"; ?>" onKeyDown="SoloNumerosyNegativo(true,this)" maxlength= "16" type="text" id="MTR<? echo $Fila1["cod_subclase"]."0";?>" style="width:90" align="absmiddle" value="<? if($Valor2[0]==0.00000)
					 																																														$Valor2[0]=0.0;																		
					 																																												   else echo number_format($Valor2[0],5,',','.'); ?>" >
					 <select name="CmbUnidad~<? echo $Fila1["cod_subclase"]."~0"; ?>" style="width:105" id="CmbUnidad<? echo $Fila1["cod_subclase"]."0";?>" onChange="HabilitaEuro();">
					  <?
					  }
					  else
					  {
					  ?> 
					 <input name="MTR~<? echo $Fila1["cod_subclase"]."~0"; ?>" onKeyDown="SoloNumeros(true,this)" maxlength= "10" type="text" id="MTR<? echo $Fila1["cod_subclase"]."0";?>" style="width:80" align="absmiddle" value="<? if($Valor2[0]==0.00000)	$Valor2[0]=0.0;	else echo number_format($Valor2[0],5,',','.'); ?>" >
					 <select name="CmbUnidad~<? echo $Fila1["cod_subclase"]."~0"; ?>" style="width:105" id="CmbUnidad<? echo $Fila1["cod_subclase"]."0";?>" onChange="HabilitaEuro();">
					  <?
					   }
					  ?>						  
					   <?
						$Consulta2 = "select cod_subclase,nombre_subclase,ceiling(valor_subclase1) as orden from proyecto_modernizacion.sub_clase where cod_clase='31013'";
						switch($Fila1["cod_subclase"])
						{
							case "5":
							case "6":
								$Consulta2.= " and cod_subclase in ('1','2','5')";
								break;									   
							case "7":
							case "8":
							case "9":
								$Consulta2.= " and cod_subclase in ('6','7','8','9','10','11','21') ";
								break;	
							case "10":
								$Consulta2.= " and cod_subclase in ('12','13') ";
								break;	
							case "11":
								$Consulta2.= " and cod_subclase in ('14','15') ";
								break;	
							case "12":
								$Consulta2.= " and cod_subclase in ('12','13') ";
								break;	
							case "13":
								$Consulta2.= " and cod_subclase in ('16','17') ";
								break;	
						}	
						 	$Consulta2.= " order by orden";	
						$RespUnid2=mysql_query($Consulta2);
						while ($FilaUnid2=mysql_fetch_array($RespUnid2))
						{
							if ($Valor2[1]==$FilaUnid2["cod_subclase"])
								echo "<option selected value='".$FilaUnid2["cod_subclase"]."'>".ucfirst($FilaUnid2["nombre_subclase"])."</option>\n";
							else
								echo "<option value='".$FilaUnid2["cod_subclase"]."'>".ucfirst($FilaUnid2["nombre_subclase"])."</option>\n";
						}
						if($Valor2[1]=='9'||$Valor2[1]=='13'||$Valor2[1]=='14'||$Valor2[1]=='16')//[Euro/Kg]
							$OptEuro='';
					   ?>
					 </select>
					 
					 <? 
					 //echo $Valor2[1]." &nbsp;&nbsp;";
					 //echo $Fila1["cod_subclase"]."<br>";
					 if($Fila1["cod_subclase"]=='13')
					 {
						  ?>	 
							  <input name="Calcular" type="button" onClick="Calcula()" value="Calcular">&nbsp;&nbsp;&nbsp;&nbsp;
						  <?	
					 }
					  ?>					  </td>
                 </tr>
                 <?				                 
				}								
         	     ?>
				 <tr class="FilaAbeja">
				 <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo "<input name='NomEuro' value='EURO' style='visibility:$OptEuro' readonly class='SinBorde'>"?></td>
				 <td>
				 <? 
				 echo "<input type='text' name='TxtEuro' value='".$TxtEuro."' onKeyDown='SoloNumeros(true)' maxlength= '10' size='6' style='visibility:$OptEuro'>";
				 echo "&nbsp;&nbsp;<input name='TxtUS' value='US$' style='visibility:$OptEuro' readonly class='SinBorde'>";
				 ?>				 </td>
				 </tr>
               </table>
			   <table align="center" width="90%" border="1" cellpadding="4" cellspacing="0" >
                 <tr class="FilaAbeja" align="right">
                   <td width="10%">Tota RC Cu</td>
                   <td width="14%" align="left" ><input name="TxtRcCu"  onKeyDown="SoloNumeros(true)" readonly=""  maxlength= "50" align="right" type="text" id="TxtRcCu" style="width:70" value="<? echo number_format($TxtRcCu,3,',','.'); ?>" >&nbsp;US$</td>
				   <td width="12%">Total RC Ag </td>
                   <td width="14%" align="left"><input name="TxtRcAg" readonly="" onKeyDown="SoloNumeros(true)" align="right" maxlength= "10" type="text" id="TxtRcAg" style="width:70" value="<? echo number_format($TxtRcAg,3,',','.'); ?>" >&nbsp;US$</td>
                   <td width="11%"> Total RC Au </td>
                   <td width="14%" align="left"><input name="TxtRcAu" readonly="" onKeyDown="SoloNumeros(true)"  align="right"maxlength= "10" type="text" id="TxtRcAu" style="width:70" value="<? echo number_format($TxtRcAu,3,',','.'); ?>" >&nbsp;US$</td>
                   <td width="10%"> Total TC Cu </td>
                   <td width="15%" align="left"><input name="TxtTcCu" readonly="" onKeyDown="SoloNumeros(true)"  align="right"maxlength= "10" type="text" id="TxtTcCu" style="width:70" value="<? echo number_format($TxtTcCu,3,',','.'); ?>" >&nbsp;US$</td>
                 </tr>
               </table>
			   <?
			    if($CmbTipo!='2')
				{
			   ?>
			   <table align="center" width="90%" border="1" cellpadding="4" cellspacing="0" >			   			   
			   <tr class="FilaAbeja" align="right">
			       <td width="4%">Valor Neto</td> 
				   <td width="11%" align="left" >
				   <input name="TxtNeto" readonly="" maxlength= "50" align="right" type="text" id="TxtNeto" style="width:90" value="<? echo number_format($TxtNeto,3,',','.'); ?>" >&nbsp;US$</td>		   
				   <td width="3%">Iva</td> 
				   <td width="11%" align="left"><input name="TxtIva" readonly=""  align="right" maxlength= "10" type="text" id="TxtIva" style="width:90" value="<? echo number_format($TxtIva,3,',','.'); ?>" >&nbsp;US$
				   <?
				    $CheckedIva='';
				    if($TxtIva>0)
						$CheckedIva="checked";
				   ?>				   
				   <input type="checkbox" name="OptIva" class="SinBorde" <? echo $CheckedIva;?>> Habilitar IVA</td>
				   <td width="4%">Valor Total</td> 
				   <td width="11%" align="left"><input name="TxtTotal" readonly=""  align="right"maxlength= "10" type="text" id="TxtTotal" style="width:90" value="<? echo number_format($TxtTotal,3,',','.'); ?>" >&nbsp;US$</td>		   			   
			    </tr>
               </table>
			    <?
				 }
				 if($CmbTipo=='2')
				 {
				?>
			   <table align="center" width="90%" border="1" cellpadding="4" cellspacing="0" >			   			   
			   <tr class="FilaAbeja" align="right">
			       <td width="11%">Total Definitivo</td> 
				   <td width="14%" align="left" >
				   <input name="TxtNeto" readonly="" maxlength= "50" align="right" type="text" id="TxtNeto" style="width:90" value="<? echo number_format($TxtNeto,3,',','.'); ?>" >&nbsp;US$</td>		   
				   <td width="14%">Total <? echo $NomNetoAnterior;?></td> 
				   <td width="21%" align="left"><input name="TxtNeto1" readonly="" align="right" maxlength= "10" type="text" id="TxtNeto1" style="width:90" value="<? echo number_format($TxtNeto1,3,',','.'); ?>" >&nbsp;US$					</td>					 
				   <td width="14%">Neto Afecto</td> 
				   <td width="26%" align="left"><input name="TxtAfecto" readonly=""  align="right"maxlength= "10" type="text" id="TxtAfecto" style="width:90" value="<? echo number_format($TxtAfecto,3,',','.'); ?>" >&nbsp;US$</td>		   			   
			    </tr>
			   <tr class="FilaAbeja" align="right">
			       <td colspan="5">Iva</td> 
				   <td width="26%" align="left"><input name="TxtIva" readonly=""  align="right"maxlength= "10" type="text" id="TxtIva" style="width:90" value="<? echo number_format($TxtIva,3,',','.'); ?>" >&nbsp;US$		   			   
					<?
				    $CheckedIva='';
					if($TxtIva>0)					
						$CheckedIva="checked";
				    ?>				   
				   <input type="checkbox" name="OptIva" class="SinBorde" <? echo $CheckedIva;?>> Habilitar IVA				   </td>		   
			   </tr>
			   <tr class="FilaAbeja" align="right">
			       <td colspan="5">Total Nota</td> 
				   <td width="26%" align="left"><input name="TxtTotal" readonly="" align="right"maxlength= "10" type="text" id="TxtTotal" style="width:90" value="<? echo number_format($TxtTotal,3,',','.'); ?>" >&nbsp;US$</td>		   			   
			   </tr>			    	   
               </table>
			   <?  }?>			   </td><br><br>
          </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   </td>
   <td width="16" background="../pcip_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="../pcip_web/archivos/images/interior/form_abajo.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="16" height="15"><img src="../pcip_web/archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>	  		
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje!='')
		echo "alert('".$Mensaje."');";
	echo "</script>";
	
function ObtenerValorFino($Codigo,$CodConte,$CodFino,$Correlativo)
{
	$Valor=0;
	$Consulta="select t1.valor,t1.cod_unidad "; 
	$Consulta.="from pcip_fac_compra_finos t1 where t1.codigo='".$Codigo."'";
	$Consulta.=" and t1.cod_contenido='".$CodConte."'";
	$Consulta.=" and t1.cod_fino='".$CodFino."'";
	$Consulta.=" and t1.correlativo='".$Correlativo."'";
	//echo $Consulta."<br>";
	$Respaux=mysqli_query($link, $Consulta);
	if($Filaaux=mysql_fetch_array($Respaux))
	{
		$Valor=$Filaaux[valor]."~".$Filaaux[cod_unidad];
		
	}
	return($Valor);
}
if($Opc=='M')
{
	echo "<script languaje='JavaScript'>";
    echo "Calcula();";
	echo "HabilitaEuro();";
	echo "</script>";
}
	
?>