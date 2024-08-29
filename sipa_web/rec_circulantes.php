<?php
	//echo "TIPO PROCESO:".$TipoProceso."<BR>";
	//echo "PROCESO:".$Proceso;
	$CodigoDeSistema=24;
	$CodigoDePantalla=16;
	include("../principal/conectar_principal.php");
	include("funciones.php");
	$CookieRut = $_COOKIE["CookieRut"];
	$REMOTE_ADDR  = gethostbyaddr($_SERVER['REMOTE_ADDR']); //Nombnre completro de la PC : WSALDANA-PERU.sml.sermaluc.cl
	$EstadoInput='';
	/*
	if(isset($RNA))
	{
		setcookie("ROMANA",$RNA);
		$TxtNumRomana=$RNA;
	}*/
	$ObjFoco = isset($_REQUEST["ObjFoco"])?$_REQUEST["ObjFoco"]:"";
	$CmbRecarga = isset($_REQUEST["CmbRecarga"])?$_REQUEST["CmbRecarga"]:"";
	$Productos = isset($_REQUEST["Productos"])?$_REQUEST["Productos"]:"";
	$SubProductos = isset($_REQUEST["SubProductos"])?$_REQUEST["SubProductos"]:"";
	$Conjunto = isset($_REQUEST["Conjunto"])?$_REQUEST["Conjunto"]:"";
	$TxtNumBascula = isset($_REQUEST["TxtNumBascula"])?$_REQUEST["TxtNumBascula"]:"";
	$TxtBasculaTara = isset($_REQUEST["TxtBasculaTara"])?$_REQUEST["TxtBasculaTara"]:"";
	$TxtBasculaAux = isset($_REQUEST["TxtBasculaAux"])?$_REQUEST["TxtBasculaAux"]:"";
	$Valor = isset($_REQUEST["Valor"])?$_REQUEST["Valor"]:"";
	$TxtPesoHistorico = isset($_REQUEST["TxtPesoHistorico"])?$_REQUEST["TxtPesoHistorico"]:"";
	$OptBascula = isset($_REQUEST["OptBascula"])?$_REQUEST["OptBascula"]:"";		
	$RNA        = isset($_REQUEST["RNA"])?$_REQUEST["RNA"]:"";

	if(isset($RNA) && $RNA!=''){
		setcookie("ROMANA",$RNA);
		$TxtNumRomana=$RNA;
	}/*else{
		$RNA = "";
	}*/
    /*
	if($RNA!='')	
	{	
		setcookie("ROMANA",$RNA);
		$TxtNumRomana=$RNA;
	}*/
	/*

	if(isset($_REQUEST["TxtNumRomana"])){
		$TxtNumRomana=$RNA;
	}else{
		$TxtNumRomana = "";
	}
	if($TxtNumRomana=='')
		$TxtNumRomana=$_COOKIE["ROMANA"];
	*/

	$TxtNumRomana	= isset($_REQUEST["TxtNumRomana"])?$RNA:"";
	$TipoProceso 	= isset($_REQUEST["TipoProceso"])?$_REQUEST["TipoProceso"]:"";
	$TxtPatente 	= isset($_REQUEST["TxtPatente"])?$_REQUEST["TxtPatente"]:"";
	$TxtCorrelativo = isset($_REQUEST["TxtCorrelativo"])?$_REQUEST["TxtCorrelativo"]:"";
	$TitCmbCorr     = isset($_REQUEST["TitCmbCorr"])?$_REQUEST["TitCmbCorr"]:"";
	$TxtObs 		= isset($_REQUEST["TxtObs"])?$_REQUEST["TxtObs"]:"";
	$TxtFecha 		= isset($_REQUEST["TxtFecha"])?$_REQUEST["TxtFecha"]:date('Y-m-d');
	$TxtHoraE 		= isset($_REQUEST["TxtHoraE"])?$_REQUEST["TxtHoraE"]:date('G:i:s');
	$TxtHoraS 		= isset($_REQUEST["TxtHoraS"])?$_REQUEST["TxtHoraS"]:"";
	$TxtPesoBruto 	= isset($_REQUEST["TxtPesoBruto"])?$_REQUEST["TxtPesoBruto"]:"";
	$TxtPesoTara 	= isset($_REQUEST["TxtPesoTara"])?$_REQUEST["TxtPesoTara"]:"";
	$TxtPesoNeto 	= isset($_REQUEST["TxtPesoNeto"])?$_REQUEST["TxtPesoNeto"]:"";
	$TxtConjunto 	= isset($_REQUEST["TxtConjunto"])?$_REQUEST["TxtConjunto"]:"";
	$TxtGuia 	= isset($_REQUEST["TxtGuia"])?$_REQUEST["TxtGuia"]:"";

	if($TxtNumRomana=='')
		$TxtNumRomana=isset($_COOKIE["ROMANA"])?$_COOKIE["ROMANA"]:"";
		
	switch($TxtNumBascula)
	{
		case "1":
			$EstOptBascula='checked';
			$EstOptBascula2='';
			break;
		case "2":
			$EstOptBascula='';
			$EstOptBascula2='checked';
			break;
		default:
			$EstOptBascula='checked';
			$EstOptBascula2='';
			$TxtNumBascula='1';
			break;		
	}
	//$EstPatente='disabled'; // esto estaba desactivada
	$EstPatente='';// WSO
	$EstBtnGrabar='disabled';
	$EstBtnAnular='disabled';
	$EstBtnImprimir='disabled';
	$EstBtnModificar='disabled';
	$HabilitarCmb='';
	//DETERMINAR SI ES ENTRADA O SALIDA
	if($TipoProceso=="" && $TxtPatente<>"")
	{
		$Consulta="SELECT * from sipa_web.otros_pesaje where patente = '".$TxtPatente."' ";
		//$Consulta.="and peso_bruto<>'0' ";
		$Consulta.="and peso_tara='0' and peso_neto='0' and estado <> 'A'";
	//	echo $Consulta;
		$Respuesta=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
			$TipoProceso='S';
		else
			$TipoProceso='E';
	}	
	$RutOperador=$CookieRut;
	$Mensaje='';$TotalLote=0;
	if($ObjFoco=="")
		$ObjFoco="TxtPatente";

	$Mostrar='N';$HabilitarText='';
	//$TipoUpdate='GR';
	function PatenteValida($Patente,$PatenteOk,$EstPatente,$Mensaje,$TxtPesoTara,$link)
	{global $TxtBasculaTara;
			$EstPatente='readonly';
			$Consulta="SELECT peso_tara,fecha,bascula_entrada from sipa_web.otros_pesaje where patente='".$Patente."' and observacion='TARA' order by fecha desc, hora_entrada desc";
			$Respuesta=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
			{	
				$PatenteOk=true;
				$TxtPesoTara=$Fila["peso_tara"];
				$TxtBasculaTara=$Fila["bascula_entrada"];
				$RUTOPeradorTara=$Fila["rut_operador"];
				$DiasDif=abs(resta_fechas($Fila["fecha"],date('Y-m-d')));
				//echo "DIAS DIF:".$DiasDif."<br>";
				if($DiasDif>=7) 
				{
					$FechaUltAct=explode('-',$Fila["fecha"]);
					$Mensaje='Actualizar Tara del Camión, Ultima Actualizacion '.$FechaUltAct[2]."-".$FechaUltAct[1]."-".$FechaUltAct[0];
				}
			}	
			else
			{	
				$PatenteOk=false;
				$Mensaje='Patente Camion No Registrada, Debe Registrar Tara Inicial';
			}
			$PatenteOk=true;
			//$Mensaje='';
			return $PatenteOk;
	}
	//DEFINE SI ES ENTRADA O SALIDA
	switch($TipoProceso)
	{
		case "E":
			$EstBtnGrabar='';
			$PatenteOk='';
			$PatenteOk = PatenteValida($TxtPatente,$PatenteOk,$EstPatente,$Mensaje,$TxtPesoTara,$link);
			
			$Consulta="SELECT bascula_entrada from sipa_web.otros_pesaje where patente='".$TxtPatente."' and observacion='TARA' order by fecha desc, hora_entrada desc";
				$Respuesta=mysqli_query($link, $Consulta);
				if($Fila=mysqli_fetch_array($Respuesta))
				{	
					$TxtBasculaTara=$Fila["bascula_entrada"];
				
				}
			if($TxtBasculaTara!='')
			{
				
				$TxtBasculaAux=$TxtBasculaTara;
			}
			if($PatenteOk==true&&$CmbRecarga!='S')
			{
				
				$TxtPesoBruto=0;$TxtPesoTara=0;$TxtPesoNeto=0;
				$Consulta="SELECT ifnull(max(correlativo)+1,1) as correlativo from sipa_web.otros_pesaje";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$TxtCorrelativo=$Fila["correlativo"];
				$TxtFecha=date('Y-m-d');
				$TxtHoraE=date('G:i:s');
				CrearArchivoResp('O','E',$TxtCorrelativo,'','','',$RutOperador,$TxtBasculaAux,'',$TxtFecha,$TxtHoraE,'',$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,'','','','','',$TxtGuia,$TxtPatente,'',$TxtConjunto,$TxtObs,'','','','','');
				$Insertar="INSERT INTO sipa_web.otros_pesaje (correlativo,rut_operador,bascula_entrada,bascula_salida,fecha,";
				$Insertar.="hora_entrada,peso_tara,patente) values(";
				$Insertar.="'$TxtCorrelativo','".$RutOperador."','$TxtBasculaAux','','$TxtFecha',";
				$Insertar.="'$TxtHoraE','$TxtPesoTara','".strtoupper($TxtPatente)."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
				$HabilitarCmb='disabled';
				$ObjFoco='Productos';
			}
			break;
			case "S":
			//$EstBtnGrabar='';
			
			break;
			/*case "S"://SALIDA DEL CAMION
			$EstBtnGrabar='';
			$EstBtnAnular='';
			$EstBtnImprimir='';
			PatenteValida(&$TxtPatente,&$PatenteOk,&$EstPatente,&$Mensaje,&$TxtPesoTara);
			if($PatenteOk==true)
			{
			//$ObjFoco="TxtCorrelativo";
				//$TitCmbCorr="Correlativo";
				switch($Proceso)
				{
					case "BC"://BUSCAR CORRELATIVO
						$Consulta ="SELECT distinct t1.correlativo,t1.fecha,t1.hora_entrada,t1.hora_salida,t1.conjunto,t1.cod_mop,";
						$Consulta.="t1.peso_bruto,t1.guia_despacho,t1.nombre,t1.descripcion,t1.observacion from sipa_web.otros_pesaje t1 ";
						$Consulta.="where patente='$TxtPatente' and correlativo='".$TxtCorrelativo."'";
						//echo $Consulta;
						$Resp2 = mysqli_query($link, $Consulta);
						while($Fila = mysqli_fetch_array($Resp2))
						{
							$TxtCorrelativo=$Fila["correlativo"];
							$TxtGuia=$Fila["guia_despacho"];
							$TxtConjunto=$Fila["conjunto"];
							$TxtFecha=$Fila["fecha"];
							$TxtHoraE=$Fila["hora_entrada"];
							$TxtHoraS=date('G:i:s');
							$TxtPesoBruto=$Fila["peso_bruto"];
							$TxtPesoNeto=abs($Fila["peso_bruto"]-$TxtPesoTara);
							$TxtNombre=$Fila["nombre"];
							$TxtDescripcion=$Fila["descripcion"];
							$TxtConjunto=$Fila["conjunto"];
							$CmbCodMop=$Fila["cod_mop"];
							$TxtObs=$Fila["observacion"];
							$TipoUpdate='GS';
							$HabilitarCmb='disabled';
							$HabilitarText='readonly';
							$ObjFoco='TxtNombre';
						}	
					break;
				}	
			}	
			break;	*/
	}
?>	
<html><head>
<title>Circulantes</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
var digitos=20 //cantidad de digitos buscados 
var puntero=0 
var buffer=new Array(digitos) //declaraci�n del array Buffer 
var cadena="" 
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 450 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function PesoAutomatico()
{
	setTimeout("CapturaPeso()",500);
}	
/*
function LeerRomana(Rom)
{
	var ubicacion = "C:\\PesaMatic\\ROMANA.txt";
	var valor="";
	var fso, f1, ts, s,retorno; 
	var ForReading = 1; 
	fso = new ActiveXObject("Scripting.FileSystemObject"); 
	if(fso.FileExists(ubicacion))
	{
          f = fso.OpenTextFile( ubicacion, ForReading); 
		  valor=f.Readline(); 
    }
	else
	{
       alert("No Existe archivo en :"+ubicacion);
	}
	return(valor); 
}*/
//var ROMA=LeerRomana('');
//var ROMA = '<?php echo LeerArchivo('PesaMatic','ROMANA.txt');?>';
var ROMA = '<?php echo LeerRomana($REMOTE_ADDR,$link); ?>'; 
/*
function LeerArchivo(valor)
{
	var ubicacion = "C:\\PesoMatic.txt";
var valor="";
	var fso, f1, ts, s,retorno; 
		var ForReading = 1; 
	fso = new ActiveXObject("Scripting.FileSystemObject"); 
	if(fso.FileExists(ubicacion)){
          f = fso.OpenTextFile( ubicacion, ForReading); 
		  valor=f.Readline(); 
        } else {
       alert("No Existe archivo en: "+ubicacion ) 
	
	   }
		return(valor); 
}

function LeerArchivo2(valor)
{
	var ubicacion = "C:\\PesoMatic2.txt";
var valor="";
	var fso, f1, ts, s,retorno; 
		var ForReading = 1; 
	fso = new ActiveXObject("Scripting.FileSystemObject"); 
	if(fso.FileExists(ubicacion)){
          f = fso.OpenTextFile( ubicacion, ForReading); 
		  valor=f.Readline(); 
        } else {
       alert("No Existe archivo en: "+ubicacion ) 
	
	   }
		return(valor); 
}
*/
/*****************/
function CapturaPeso(tipo)
{
	var f = document.FrmOtrosPesajes;
	var PesoAux=0;
	//if (f.checkpeso.checked == true)
	switch(tipo)
	{
		case "PB":
			f.TipoProceso.value="E";
			if(f.TxtNumBascula.value=='1'){		
				//f.TxtPesoBruto.value = LeerArchivo2(f.TxtPesoBruto.value);
				//f.TxtPesoBruto.value = '<?php echo LeerArchivo('','PesoMatic2.txt');?>';
				f.TxtPesoBruto.value = '<?php echo LeerArchivo('configuracion_pesaje','PesoMatic2_1.txt'); ?>';
			}else{
				//f.TxtPesoBruto.value = LeerArchivo(f.TxtPesoBruto.value);
				//f.TxtPesoBruto.value = '<?php echo LeerArchivo('','PesoMatic.txt');?>';
				f.TxtPesoBruto.value = '<?php echo LeerArchivo('configuracion_pesaje','PesoMatic_1.txt'); ?>';
			}
			if(f.TxtPesoBruto.value!=0&&f.TxtPesoTara.value!=0)	
				f.TxtPesoNeto.value=f.TxtPesoBruto.value-f.TxtPesoTara.value;	
			f.BtnGrabar.focus();	
			break;
		case "PT":
			f.TipoProceso.value="S";
			if(f.TxtNumBascula.value=='1'){					
				//f.TxtPesoTara.value = LeerArchivo2(f.TxtPesoTara.value);
				//f.TxtPesoTara.value = '<?php echo LeerArchivo('','PesoMatic2.txt');?>';
				f.TxtPesoTara.value = '<?php echo LeerArchivo('configuracion_pesaje','PesoMatic2_1.txt'); ?>';
			}else{
				//f.TxtPesoTara.value = LeerArchivo(f.TxtPesoTara.value);
				//f.TxtPesoTara.value = '<?php echo LeerArchivo('','PesoMatic.txt');?>';
				f.TxtPesoTara.value ='<?php echo LeerArchivo('configuracion_pesaje','PesoMatic_1.txt'); ?>';
			}
			if(parseInt(f.TxtPesoTara.value)>parseInt(f.TxtPesoBruto.value))
			{
				PesoAux=f.TxtPesoBruto.value;
				f.TxtPesoBruto.value=f.TxtPesoTara.value;
				f.TxtPesoTara.value=PesoAux;
			}		
			if(f.TxtPesoBruto.value!=0&&f.TxtPesoTara.value!=0)	
				f.TxtPesoNeto.value=f.TxtPesoBruto.value-f.TxtPesoTara.value;
			f.BtnGrabar.focus();	
			break;
	}	
	//setTimeout("CapturaPeso()",200);
	f.TxtPatente.disabled='';
	//f.TxtPatente.focus();
		
}

function buscar_op(obj,objfoco,InicioBusq,Recargar){ 
   var f = document.FrmOtrosPesajes;
   var letra = String.fromCharCode(event.keyCode) 
   if(puntero >= digitos){ 
       cadena=""; 
       puntero=0; 
    }
   //si se presiona la tecla ENTER, borro el array de teclas presionadas y salto a otro objeto... 
   if (event.keyCode == 13||event.keyCode == 27)
   { 
       borrar_buffer(); 
       if(event.keyCode != 27&&objfoco!=0) //evita foco a otro objeto si objfoco=0 
		if(Recargar=='S')
			Recarga(objfoco);	   
		else
		   objfoco.focus(); 
    } 
   //sino busco la cadena tipeada dentro del combo... 
   else{ 
       buffer[puntero]=letra; 
       //guardo en la posicion puntero la letra tipeada 
       cadena=cadena+buffer[puntero]; //armo una cadena con los datos que van ingresando al array 
       puntero++; 

       //barro todas las opciones que contiene el combo y las comparo la cadena... 
       for (var opcombo=0;opcombo < obj.length;opcombo++){ 
          if(obj[opcombo].text.substr(InicioBusq,puntero).toLowerCase()==cadena.toLowerCase()){ 
          obj.SELECTedIndex=opcombo; 
          } 
       } 
    } 
   event.returnValue = false; //invalida la acci�n de pulsado de tecla para evitar busqueda del primer caracter 

} 

function borrar_buffer(){ 
   //inicializa la cadena buscada 
    cadena=""; 
    puntero=0;
}
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 50 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function Proceso(opt,ObjFoco,opt2)
{
	var f = document.FrmOtrosPesajes;
	var Valores='';
	//alert(f.TipoProceso.value);
	switch (opt)
	{
		case "G"://ACTUALIZAR RECEPCION
			if(ValidarCampos())
			{
				f.BtnGrabar.disabled=true;
				//alert(opt2);
				f.action = "rec_circulantes01.php?Proceso="+opt2;
				f.submit();	
			}
			break;
		case "B"://BUSCA LOTE NUEVO O LOTE EXISTENTE
			if(f.CmbLotes.value=='-1')//ES LOTE NUEVO
				f.action = "rec_circulantes.php?Proceso=B1";
			else
				f.action = "rec_circulantes.php?Proceso=B2";//LOTE INGRESADO
			f.submit();	
			break;
		case "BC":
			if(f.TxtCorrelativo.value!='S')
			{
				f.action = "rec_circulantes.php?Proceso=BC&ObjFoco="+ObjFoco.name;//BUSCAR CORRELATIVO
				f.submit();	
			}	
			break;	
		case "I"://IMPRIMIR
			/*if(f.TxtLote.value=='')
			{
				alert('No hay Correlativo para Modificar');
				f.TxtCorrelativo.focus();
				return;
			}
			else
			{*/
				f.action = "rec_circulantes01.php?Proceso=I";
				f.submit();	
			//}					
			break;	
		case "S"://SALIR
			FrmOtrosPesajes.action = "../principal/sistemas_usuario.php?CodSistema=24";
			FrmOtrosPesajes.submit();
			break;
		case "C"://CANCELAR
			f.action = "rec_circulantes01.php?Proceso=C";
			f.submit();	
			break;
		case "M"://MODIFICAR
			f.TipoProceso.value="S";
			if(f.TxtCorrelativo.value=='S')
			{
				alert('No hay Correlativo para Modificar');
				f.TxtCorrelativo.focus();
				return;
			}
			else
			{
				f.action = "rec_circulantes01.php?Proceso=M";
				f.submit();	
			}	
			break;
		case "A"://ANULAR
			if(f.TxtCorrelativo.value=='S')
			{
				alert('No hay Correlativo para Anular');
				f.TxtCorrelativo.focus();
				return;
			}
			else
			{
				f.action = "rec_circulantes01.php?Proceso=A";
				f.submit();	
			}	
			break;
	}
}
function Recarga(ObjFoco,Tipo,CmbRecarga)
{
	var f = document.FrmOtrosPesajes;
	
	if(f.TxtPatente.value==''&&Tipo=='S')
		return;
	f.action = "rec_circulantes.php?ObjFoco="+ObjFoco.name+"&CmbRecarga="+CmbRecarga;
	f.submit();		
}
function ValidarCampos()
{
	var f = document.FrmOtrosPesajes;
	var Validado=true;
	
	if(f.TxtCorrelativo.value==''||f.TxtCorrelativo.value=='S')
	{
		alert('No hay Correlativo para Grabar');
		f.TxtPatente.focus();
		Validado=false;
		return;
	}
	if(f.TxtPatente.value=='')
	{
		alert('Debe Ingresar Patente');
		f.TxtPatente.focus();
		Validado=false;
		return;
	}
	if(f.SoloTara.value=='')
	{
		if(f.Productos.value=='S')
		{
			alert('Debe Seleccionar Producto');
			f.Productos.focus();
			Validado=false;
			return;
		}
		if(f.SubProductos.value=='S')
		{
			alert('Debe Seleccionar SubProducto');
			f.SubProductos.focus();
			Validado=false;
			return;
		}
		if(f.Conjunto.value=='S')
		{
			alert('Debe Seleccionar Conjunto');
			f.Conjunto.focus();
			Validado=false;
			return;
		}
		if(f.TipoProceso.value=='E' && f.TxtPesoBruto.value=='')
		{
			alert('Debe Ingresar Peso Bruto');
			f.BtnGrabar.focus();
			Validado=false;
			return;
		}
	}
	else
	{	
		if(f.TipoProceso.value=='E' && f.TxtPesoTara.value=='')
		{
			alert('Debe Ingresar Peso Tara');
			IngresaTara();
			f.BtnGrabar.focus();
			Validado=false;
			return;
		}
	}
	/*if(f.TipoProceso.value=='S' && f.TxtPesoTara.value=='')
	{
		alert('Debe Ingresar Peso Tara');
		f.BtnGrabar.focus();
		Validado=false;
		return;
	}*/
	return(Validado);
}
function MM_jumpMenu(targ,selObj,restore)
{ //v3.0
  eval(targ+".location='"+selObj.options[selObj.SELECTedIndex].value+"'");
  if (restore) selObj.SELECTedIndex=0;
}
function SeleccionRomana(tipo)
{
	var f = document.FrmOtrosPesajes;
	f.BtnPBruto.disabled=true;
	f.BtnPTara.disabled=true;
	window.open("rec_seleccion_romana.php?tipo="+tipo+"&Frm="+f.name,"","top=210,left=200,width=400,height=200,scrollbars=no,resizable=no,status=yes");
	
}

function SeleccionBascula(NumBascula)
{
	var f = document.FrmOtrosPesajes;
	f.TxtNumBascula.value=NumBascula;
	if(f.TxtNumRomana.value=='1' && f.TxtNumBascula.value=='1')	
	{	f.TxtBasculaAux.style.background='#FF0000';
		f.TxtBasculaAux.value=1;
	}
	if(f.TxtNumRomana.value=='1' && f.TxtNumBascula.value=='2')	
	{	f.TxtBasculaAux.style.background='#009933';
		f.TxtBasculaAux.value=2;
	}
	if(f.TxtNumRomana.value=='2' && f.TxtNumBascula.value=='1')	
	{	f.TxtBasculaAux.style.background='#FF0000';
		f.TxtBasculaAux.value=3;
	}
	if(f.TxtNumRomana.value=='2' && f.TxtNumBascula.value=='2')	
	{	f.TxtBasculaAux.style.background='#009933';
		f.TxtBasculaAux.value=4;
	}
}
function CalculaPNeto()
{
	var f = document.FrmOtrosPesajes;
	
	if(f.TxtPesoBruto.value!=''&&f.TxtPesoTara.value!='')
		f.TxtPesoNeto.value=f.TxtPesoBruto.value-f.TxtPesoTara.value;
	
}
function IngresaTara()
{
	var f = document.FrmOtrosPesajes;
	if(f.TxtCorrelativo.value==''||f.TxtCorrelativo.value=='S')
	{
		alert('No hay Correlativo para Grabar');
		//f.TxtPatente.focus();
		Validado=false;
		return;
	}
	if(f.TxtPatente.value=='')
	{
		alert('Debe Ingresar Patente');
		f.TxtPatente.focus();
		Validado=false;
		return;
	}
	if(confirm('Desea Efectuar Pesaje de Tara de Camión'))
	{
		f.TxtPesoBruto.value = '';
		f.TxtPesoTara.value = '';
		f.BtnPTara.disabled = false;
		f.BtnPBruto.disabled = true; 
		f.SoloTara.value='TARA'; 	
	}
	else
	{
		f.BtnPTara.disabled = true;
		f.BtnPBruto.disabled = false; 
		f.SoloTara.value=''; 	
		
	}
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo2 {color: #FF0000}
</style>
</head>
<body <?php echo 'onload=window.document.FrmOtrosPesajes.'.$ObjFoco.'.focus()';?>>
<form action="" method="post" name="FrmOtrosPesajes" >
<input type="hidden" name="TxtBasculaTara" value="<?php echo $TxtBasculaTara;?>">
<input type="hidden" name="SoloTara" value="">
<?php
	if($TipoProceso=="")
		echo "<input type='hidden' name='TipoProceso' value=''>";
	else
		echo "<input type='hidden' name='TipoProceso' value='$TipoProceso'>";
?>

<?php include("../principal/encabezado.php") ?>
<table class="TablaPrincipal" width="770" height="330" cellpadding="0" cellspacing="0" >
	<tr>
	  <td width="760" height="330" align="center" valign="top"><br>
<table width="700"  border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="6"><strong>CIRCULANTES:
	<?php
		if($TipoProceso!='S')
		{	echo "ENTRADA DEL CAMION";
		$Testo="ENTRADA";
		}else
		{	echo "SALIDA DEL CAMION";
	$Testo="SALIDA";
		}?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PESANDO EN BASCULA DE <?php echo $Testo;?>:
	
	<input type="hidden" name="TxtNumBascula" class="InputCen" value="<?php echo $TxtNumBascula;?>" size="2" > 
	<?php
	
	
		switch($TxtNumRomana)
		{
			case 1:
				$BasculaA='1';
				$BasculaB='2';
			break;
			case 2:
				$BasculaA='3';
				$BasculaB='4';
			break;
			default:
					$BasculaA='S/N';
					$BasculaB='S/N';
			break;
		}	
		$Color='000000';
	if($TxtNumRomana==1 && $TxtNumBascula==1)	
		{$Valor=1;$Color='FF0000';}
	if($TxtNumRomana==1 && $TxtNumBascula==2)	
		{$Valor=2;$Color='009933';}
	if($TxtNumRomana==2 && $TxtNumBascula==1)	
		{$Valor=3;$Color='FF0000';}
	if($TxtNumRomana==2 && $TxtNumBascula==2)	
		{$Valor=4;$Color='009933';}
			
		
	?>
	<input type="text" name="TxtBasculaAux" class="InputCen" value="<?php echo $Valor;?>" size="2" readonly style="background:#<?php echo $Color;?>">	
	<?php echo $BasculaA;?>
	<input name="OptBascula" type="radio" value="radiobutton" onClick="SeleccionBascula('1')" <?php echo $EstOptBascula;?>>
	<?php echo $BasculaB;?>
	<input name="OptBascula" type="radio" value="radiobutton" onClick="SeleccionBascula('2')" <?php echo $EstOptBascula2;?>>
    <input type="hidden" name="TxtNumRomana" class="InputCen" value="<?php echo $TxtNumRomana;?>" size="2" readonly >
<input name="TxtPesoHistorico" type="hidden" class="InputCen" value="<?php echo $TxtPesoHistorico; ?>" size="8" readonly>
</strong></td>
  </tr>
  <tr>
    <td width="91" align="right" class="ColorTabla02">Patente:</td>
    <td width="156" class="ColorTabla02" ><input name="TxtPatente" type="text" class="InputCen" id="TxtPatente" value="<?php echo strtoupper($TxtPatente); ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('N',true,this.form,'Productos');" onBlur="Recarga(Productos,'S','N')" <?php echo $EstPatente;?>>    
      <td width="91" align="right" class="ColorTabla02">Fecha:</td>
    <td width="106" class="ColorTabla02" ><input name="TxtFecha" type="text" class="InputCen" value="<?php echo $TxtFecha; ?>" size="12" maxlength="10" readonly ></td>
    <td width="111" align="right" class="ColorTabla02">Peso Bruto :	</td>	
    <td width="111" class="ColorTabla02">
	<input name="TxtPesoBruto" type="text" class="InputCen" value="<?php echo $TxtPesoBruto; ?>" size="10" maxlength="10" onBlur="CalculaPNeto()" readonly></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Correlativo:</td>
	<td class="ColorTabla02">
	<?php
	if($TipoProceso=="" || $TipoProceso=='E')
	{
	?>
    <input <?php echo $EstadoInput; ?> name="TxtCorrelativo" type="text" class="InputCen" id="TxtCorrelativo" value="<?php echo $TxtCorrelativo; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');" readonly>      
    <?php
	}
	else
	{
	?>
    <SELECT name="TxtCorrelativo" onChange="Proceso('BC',TxtObs)" onkeypress="buscar_op(this,TxtCorrelativo,0,'S')" onBlur="borrar_buffer()" onclick="borrar_buffer()" <?php //echo $HabilitarCmb;?>>
    <option value="S" SELECTed class="NoSelec"><?php echo $TitCmbCorr;?></option>
    <?php
		$AnoMes=substr(date('Y'),2,2).date('m');
		$Consulta ="SELECT distinct t1.correlativo from sipa_web.otros_pesaje t1 ";
		$Consulta.="where patente='".$TxtPatente."' and peso_neto=0 and estado<>'A' order by t1.correlativo desc";
		$RespCorr=mysqli_query($link, $Consulta);
		while($FilaCorr=mysqli_fetch_array($RespCorr))
		{
			if($FilaCorr["correlativo"]==$TxtCorrelativo)
			{
				echo "<option value='".$FilaCorr["correlativo"]."' SELECTed>".str_pad($FilaCorr["correlativo"],4,0,STR_PAD_LEFT)."</option>";
			}
			else
			{
				echo "<option value='".$FilaCorr["correlativo"]."'>".str_pad($FilaCorr["correlativo"],4,0,STR_PAD_LEFT)."</option>";			
			}
		}
				
	?></SELECT>
	<?php
		}
	?>	</td>
	<td align="right" class="ColorTabla02">Hora Entrada:</td>
    <td class="ColorTabla02"><input name="TxtHoraE" type="text" class="InputCen" value="<?php echo $TxtHoraE; ?>" size="10" maxlength="10" readonly ></td>
    <td align="right" class="ColorTabla02">Peso Tara :</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtPesoTara" type="text" class="InputCen" id="TxtPesoTara" value="<?php echo $TxtPesoTara; ?>" size="10" maxlength="10" onBlur="CalculaPNeto()" readonly></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Producto:</td>
    <td class="ColorTabla02"><SELECT name="Productos" style="width:200" onChange="Recarga(SubProductos,'S','S')">
      <option SELECTed value="S">Seleccionar</option>
      <?php
	$Consulta = "SELECT * from proyecto_modernizacion.productos where cod_producto ='42' order by descripcion";
	$result = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($result))
	{
		if ($Productos == $Row["cod_producto"])
		{
			echo "<option SELECTed value='".$Row["cod_producto"]."'>".$Row["cod_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
		}
		else
		{
			echo "<option value='".$Row["cod_producto"]."'>".$Row["cod_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
		}
	}
?>
    </SELECT>
    <td align="right" class="ColorTabla02">Hora Salida:</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtHoraS" type="text" class="InputCen" id="TxtHoraS2" value="<?php echo $TxtHoraS; ?>" size="10" maxlength="10" readonly></td>
    <td align="right" class="ColorTabla02">Peso Neto:</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtPesoNeto" type="text" class="InputCen" id="TxtNeto" value="<?php echo $TxtPesoNeto; ?>" size="10" maxlength="10" readonly></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">SubProducto:</td>
    <td class="ColorTabla02"><SELECT name="SubProductos" style="width:200" onChange="Recarga(Conjunto,'S','S');">
      <option SELECTed value="S">Seleccionar</option>
      <?php
	$Consulta = "SELECT distinct t1.cod_subproducto,t1.cod_subproducto,t1.descripcion from proyecto_modernizacion.subproducto t1 inner join ram_web.conjunto_ram t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
	$Consulta.= "where t1.cod_producto = '".$Productos."' and t2.estado='a' order by t1.descripcion";
	$result = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($result))
	{
		if ($SubProductos == $Row["cod_subproducto"])
		{
			echo "<option SELECTed value='".$Row["cod_subproducto"]."'>".str_pad($Row["cod_subproducto"],3,'0',STR_PAD_LEFT)."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
		}
		else
		{
			echo "<option value='".$Row["cod_subproducto"]."'>".str_pad($Row["cod_subproducto"],3,'0',STR_PAD_LEFT)."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
		}
	}
?>
    </SELECT></td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td colspan="3" align="left" class="ColorTabla02">&nbsp;</td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Conjunto:</td>
    <td colspan="2" class="ColorTabla02"><SELECT name="Conjunto" style="width:250" onChange="Recarga(TxtObs,'S','S');">
      <option SELECTed value="S">Seleccionar</option>
      <?php
	$VarFecha=explode('-',date('Y-m-d'));
	$FechaDesde=date('Y-m-d',mktime(0,0,0,$VarFecha[1]-12,$VarFecha[2],$VarFecha[0]));
	$FechaDesde="2023-01-01";
	$FechaHasta=date('Y-m-d');
	$Consulta = "SELECT distinct num_conjunto ";
	$Consulta.= " from ram_web.conjunto_ram ";
	$Consulta.= " where cod_producto = '".$Productos."' ";
	$Consulta.= " and cod_subproducto = '".$SubProductos."' and estado='a' and fecha_creacion between '".$FechaDesde."' and '".$FechaHasta."'";
	$Consulta.= " order by num_conjunto";
	echo "Consulta: ".$Consulta;
	$result = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($result))
	{
		$Consulta = "SELECT descripcion ";
		$Consulta.= " from ram_web.conjunto_ram ";
		$Consulta.= " where cod_producto = '".$Productos."' ";
		$Consulta.= " and cod_subproducto = '".$SubProductos."' ";
		$Consulta.= " and num_conjunto = '".$Row["num_conjunto"]."' and estado='a'";
		$Consulta.= " order by num_conjunto";
		$Resultado = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resultado))
		{
			$Descripcion = $Row2["descripcion"];
		}
		if ($Conjunto == $Row["num_conjunto"])
		{
			echo "<option SELECTed value='".$Row["num_conjunto"]."'>".$Row["num_conjunto"]."&nbsp;-&nbsp;".ucwords(strtolower($Descripcion))."</option>\n";
		}
		else
		{
			echo "<option value='".$Row["num_conjunto"]."'>".$Row["num_conjunto"]."&nbsp;-&nbsp;".ucwords(strtolower($Descripcion))."</option>\n";
		}
	}
?>
    </SELECT><?php //echo $Consulta;?></td>
    <td colspan="3" align="center" class="ColorTabla02"><input name="BtnPTara2" type="button" style="width:180px " onClick="IngresaTara()" value="Pesaje Tara de Camión"></td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Observacion:</td>
    <td colspan="5" class="ColorTabla02"><input name="TxtObs" type="text" class="InputIzq" id="TxtObs2" onKeyDown="TeclaPulsada2('N',true,this.form,'BtnGrabar');" value="<?php echo $TxtObs; ?>" size="100" <?php echo $EstadoInput; ?>>	</td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td class="ColorTabla02">&nbsp;</td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td colspan="2" align="left" class="ColorTabla02">&nbsp;</td>
  </tr>
	</table>
	<br>
	<table width="700" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
	  <tr bgcolor="#FFFFFF">
	  <td align="center" class="ColorTabla02">
	  	<?php  switch($TipoProceso)
			{
				case "E":
					$EstBtnPBruto='';
					$EstBtnPTara='disabled';									
					break;
				case "S":
					$EstBtnPBruto='disabled';
					$EstBtnPTara='';									
					break;
				case "T":
					$EstBtnPBruto='disabled';
					$EstBtnPTara='';									
					break;

				default:	
					$EstBtnPBruto='disabled';
					$EstBtnPTara='disabled';									
					break;
			}
		?>
        <input name="BtnPBruto" type="button" id="BtnPBruto" style="width:70px " onClick="CapturaPeso('PB')" value="P.Bruto" <?php echo $EstBtnPBruto;?>>
        <input name="BtnPTara" type="button" id="BtnPTara" style="width:70px " onClick="CapturaPeso('PT')" value="P.Tara" <?php echo $EstBtnPTara;?>>
		<input name="BtnGrabar" type="button" value="Grabar" style="width:70px " onClick="Proceso('G','','<?php echo $TipoProceso;?>')" <?php echo $EstBtnGrabar;?>>
		<input name="BtnModificar" type="button" id="BtnModificar" style="width:70px " onClick="Proceso('M')" value="Modificar" <?php echo $EstBtnModificar;?>>
		<input name="BtnCancelar" type="button" id="BtnCancelar" style="width:70px " onClick="Proceso('C')" value="Cancelar">
		<input name="BtnAnular" type="button" style="width:70px " onClick="Proceso('A')" value="Anular" <?php echo $EstBtnAnular;?>>
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:70px " onClick="Proceso('I')" <?php echo $EstBtnImprimir;?> disabled>
		<input name="BtnSalir" type="button" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
	</table>  
</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
<?php
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
//echo "AAAAAA".$Mensaje;
$Romana = LeerRomana($REMOTE_ADDR,$link);
echo "<br>ROMANA: ".$Romana;
if($Mensaje!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('$Mensaje');";
	echo "var f = document.FrmOtrosPesajes;";
	echo "IngresaTara();";
	//echo "f.TxtPatente.focus();";
	echo "</script>";
}
echo "<script language='JavaScript'>";
echo "var f = document.FrmOtrosPesajes;";
//$Romana = LeerArchivo('PesaMatic','ROMANA.txt');
echo "f.TxtNumRomana.value=".$Romana.";";
//echo "f.TxtNumRomana.value = LeerRomana(f.TxtNumRomana.value);";
//echo "alert(f.TxtNumRomana.value);";
echo "</script>";

/*function PesoHistorico($Patente,$TxtPesoHistorico,$Proc)
{

}*/
?>