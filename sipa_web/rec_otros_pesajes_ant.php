<?php
	//echo "TIPO PROCESO:".$TipoProceso."<BR>";
	//echo "PROCESO:".$Proceso;
	$CodigoDeSistema=24;
	$CodigoDePantalla=5;
	include("../principal/conectar_principal.php");
	include("funciones.php");
	$EstadoInput='';
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
	//$EstPatente='disabled';
	$EstBtnGrabar='disabled';
	$EstBtnAnular='disabled';
	$EstBtnImprimir='disabled';
	$EstBtnModificar='disabled';
	$HabilitarCmb='';
	//DETERMINAR SI ES ENTRADA O SALIDA
	if($TipoProceso==""&&$TxtPatente<>"")
	{
		$Consulta="SELECT * from sipa_web.otros_pesaje where patente = '$TxtPatente' ";
		//$Consulta.="and peso_bruto<>'0' ";
		$Consulta.="and peso_tara='0' and peso_neto='0' and estado <> 'A'";
		//echo $Consulta;
		$Respuesta=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
			$TipoProceso='S';
		else
			$TipoProceso='E';
	}	
	$RutOperador=$CookieRut;
	$Mensaje='';$TotalLote=0;
	if(!isset($ObjFoco))
		$ObjFoco="TxtPatente";
	$Mostrar='N';$HabilitarText='';
	//$TipoUpdate='GR';
	function PatenteValida($Patente,$PatenteOk,$EstPatente)
	{
			$EstPatente='readonly';
			/*$Consulta="SELECT * from sipa_web.camion where patente='".$Patente."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
			{	
				$PatenteOk=true;
			}	
			else
			{	
				$PatenteOk=false;
				$Mensaje='Patente Camion No Registrada';
			}*/
			$PatenteOk=true;
			$Mensaje='';
	}
	switch($TipoProceso)//DEFINE SI ES ENTRADA O SALIDA
	{
		case "E":
			$EstBtnGrabar='';
			$PatenteOk='';
			if($TxtPesoNeto=='')
				$TxtPesoNeto=0;
			if($TxtPesoTara=='')
				$TxtPesoTara=0;				
			PatenteValida(&$TxtPatente,&$PatenteOk,&$EstPatente);
			if($PatenteOk==true&&$RecargaConj!='S')
			{
				$Consulta="SELECT ifnull(max(correlativo)+1,1) as correlativo from sipa_web.otros_pesaje";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$TxtCorrelativo=$Fila["correlativo"];
				$TxtFecha=date('Y-m-d');
				$TxtHoraE=date('G:i:s');
				CrearArchivoResp('O','E',$TxtCorrelativo,'','','',$RutOperador,$TxtNumBascula,'',$TxtFecha,$TxtHoraE,'',$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,'','','','','',$TxtGuia,$TxtPatente,'',$TxtConjunto,$TxtObs,'','','','','');
				$Insertar="INSERT INTO sipa_web.otros_pesaje (correlativo,rut_operador,bascula_entrada,bascula_salida,fecha,";
				$Insertar.="hora_entrada,peso_tara,patente) values(";
				$Insertar.="'$TxtCorrelativo','".$RutOperador."','$bascula_entrada','$bascula_salida','$TxtFecha',";
				$Insertar.="'$TxtHoraE','$TxtPesoTara','".strtoupper($TxtPatente)."')";
				//echo $Insertar;
				mysqli_query($link, $Insertar);
				$HabilitarCmb='disabled';
				$ObjFoco='TxtGuia';
			}
			break;
		case "S"://SALIDA DEL CAMION
			$EstBtnGrabar='';
			$EstBtnAnular='';
			$EstBtnImprimir='';
			PatenteValida(&$TxtPatente,&$PatenteOk,&$EstPatente);
			if($PatenteOk==true&&$RecargaConj!='S')
			{
				$ObjFoco="TxtCorrelativo";
				$TitCmbCorr="Correlativo";
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
			break;	
	}
?>	
<html><head>
<title>Otros Pesaje</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="VBScript">
function LeerArchivo(valor)	

	ubicacion = "c:\PesoMatic.txt"	
	Set fs = CreateObject("Scripting.FileSystemObject")
	Set file = fs.OpenTextFile(ubicacion,1,true) //Crea el archivo si no existe.
	
	//Validar si el peso del archivo ==  0 no leer. 
	
	Set file2 = fs.getFile(ubicacion) 
	tamano = file2.size	

	if (tamano <> 0)	then
		valor = file.ReadLine
		LeerArchivo = valor
	else
		LeerArchivo = valor
	end if
		
end function 
function LeerArchivo2(valor)	

	ubicacion = "c:\PesoMatic2.txt"	
	Set fs = CreateObject("Scripting.FileSystemObject")
	Set file = fs.OpenTextFile(ubicacion,1,true) //Crea el archivo si no existe.
	
	//Validar si el peso del archivo ==  0 no leer. 
	
	Set file2 = fs.getFile(ubicacion) 
	tamano = file2.size	

	if (tamano <> 0)	then
		valor = file.ReadLine
		LeerArchivo2 = valor
	else
		LeerArchivo2 = valor
	end if
		
end function 
function LeerRomana(valor)	

	ubicacion = "c:\PesaMatic\bascula.txt"	
	Set fs = CreateObject("Scripting.FileSystemObject")
	Set file = fs.OpenTextFile(ubicacion,1,true) //Crea el archivo si no existe.
	
	//Validar si el peso del archivo ==  0 no leer. 
	
	Set file2 = fs.getFile(ubicacion) 
	tamano = file2.size	

	if (tamano <> 0)	then
		valor = file.ReadLine
		valor = file.ReadLine
		valor = file.ReadLine
		valor = file.ReadLine
		LeerRomana = valor
	else
		LeerRomana = valor
	end if
		
end function 
</script>

<script language="javascript">
<!--
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
			if(f.TxtNumBascula.value=='1')			
				f.TxtPesoBruto.value = LeerArchivo2(f.TxtPesoBruto.value);
			else
				f.TxtPesoBruto.value = LeerArchivo(f.TxtPesoBruto.value);
			if(f.TxtPesoBruto.value!=0&&f.TxtPesoTara.value!=0)	
				f.TxtPesoNeto.value=f.TxtPesoBruto.value-f.TxtPesoTara.value;	
			f.BtnGrabar.focus();	
			break;
		case "PT":
			f.TipoProceso.value="S";
			if(f.TxtNumBascula.value=='1')						
				f.TxtPesoTara.value = LeerArchivo2(f.TxtPesoTara.value);
			else
				f.TxtPesoTara.value = LeerArchivo(f.TxtPesoTara.value);
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
				f.action = "rec_otros_pesajes01.php?Proceso="+opt2;
				f.submit();	
			}
			break;
		case "B"://BUSCA LOTE NUEVO O LOTE EXISTENTE
			if(f.CmbLotes.value=='-1')//ES LOTE NUEVO
				f.action = "rec_otros_pesajes.php?Proceso=B1";
			else
				f.action = "rec_otros_pesajes.php?Proceso=B2";//LOTE INGRESADO
			f.submit();	
			break;
		case "BC":
			if(f.TxtCorrelativo.value!='S')
			{
				f.action = "rec_otros_pesajes.php?Proceso=BC&ObjFoco="+ObjFoco.name;//BUSCAR CORRELATIVO
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
				f.action = "rec_otros_pesajes01.php?Proceso=I";
				f.submit();	
			//}					
			break;	
		case "S"://SALIR
			FrmOtrosPesajes.action = "../principal/sistemas_usuario.php?CodSistema=24";
			FrmOtrosPesajes.submit();
			break;
		case "C"://CANCELAR
			f.action = "rec_otros_pesajes01.php?Proceso=C";
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
				f.action = "rec_otros_pesajes01.php?Proceso=M";
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
				f.action = "rec_otros_pesajes01.php?Proceso=A";
				f.submit();	
			}	
			break;
	}
}
function Recarga(ObjFoco,Tipo)
{
	var f = document.FrmOtrosPesajes;
	
	if(f.TxtPatente.value==''&&Tipo=='S')
		return;
	f.action = "rec_otros_pesajes.php?ObjFoco="+ObjFoco.name;
	f.submit();		
}
function Recarga2(ObjFoco,Tipo)
{
	var f = document.FrmOtrosPesajes;
	
	if(f.TxtPatente.value==''&&Tipo=='S')
		return;
	f.action = "rec_otros_pesajes.php?RecargaConj=S&ObjFoco="+ObjFoco.name;
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
	/*if(f.TxtGuia.value=='')
	{
		alert('Debe Ingresar Guia de Despacho');
		f.TxtGuia.focus();
		Validado=false;
		return;
	}*/
	if(f.TipoProceso.value=='E' && f.TxtPesoBruto.value=='')
	{
		alert('Debe Ingresar Peso Bruto');
		f.BtnGrabar.focus();
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='S' && f.TxtPesoTara.value=='')
	{
		alert('Debe Ingresar Peso Tara');
		f.BtnGrabar.focus();
		Validado=false;
		return;
	}
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
	if(NumBascula==1)
		f.TxtNumBascula.style.background='#FF0000';
	else
		f.TxtNumBascula.style.background='#009933';
}
function CalculaPNeto()
{
	var f = document.FrmOtrosPesajes;
	
	if(f.TxtPesoBruto.value!=''&&f.TxtPesoTara.value!='')
		f.TxtPesoNeto.value=f.TxtPesoBruto.value-f.TxtPesoTara.value;
	
}

//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo2 {color: #FF0000}
-->
</style></head>
<body <?php echo 'onload=window.document.FrmOtrosPesajes.'.$ObjFoco.'.focus()'?>>
<form action="" method="post" name="FrmOtrosPesajes" >
<?php
	if(!isset($TipoProceso))
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
    <td colspan="6"><strong>OTROS PESAJE:
	<?php
		if($TipoProceso!='S')
			echo "ENTRADA DEL CAMION";
		else
			echo "SALIDA DEL CAMION";
	?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PESANDO EN BASCULA:
<?php
if($TxtNumBascula=='1')
{
?>
<input type="text" name="TxtNumBascula" class="InputCen" value="<?php echo $TxtNumBascula;?>" size="2" readonly style="background:#FF0000"> 
<?php
}
else
{
?>
<input type="text" name="TxtNumBascula" class="InputCen" value="<?php echo $TxtNumBascula;?>" size="2" readonly style="background:#009933"> 
<?php
}
?>
1
<input name="OptBascula" type="radio" value="radiobutton" onClick="SeleccionBascula('1')" <?php echo $EstOptBascula;?>> 
2
<input name="OptBascula" type="radio" value="radiobutton" onClick="SeleccionBascula('2')" <?php echo $EstOptBascula2;?>>
&nbsp;OPERANDO EN ROMANA:
<input type="text" name="TxtNumRomana" class="InputCen" value="<?php echo $TxtNumRomana;?>" size="2" readonly>
<input name="TxtPesoHistorico" type="hidden" class="InputCen" value="<?php echo $TxtPesoHistorico; ?>" size="8" readonly>
</strong></td>
  </tr>
  <tr>
    <td width="91" align="right" class="ColorTabla02">Patente:</td>
    <td width="156" class="ColorTabla02" ><input name="TxtPatente" type="text" class="InputCen" id="TxtPatente2" value="<?php echo strtoupper($TxtPatente); ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('N',true,this.form,'TxtGuia');" onBlur="Recarga(TxtGuia,'S')" <?php echo $EstPatente;?>>    
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
		if(!isset($TipoProceso)||$TipoProceso=='E')
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
		$Consulta.="where patente='$TxtPatente' and peso_neto=0 and estado<>'A' order by t1.correlativo desc";
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
    <td align="right" class="ColorTabla02">Guia Despacho :</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtGuia" type="text" class="InputCen" id="TxtGuia" value="<?php echo $TxtGuia; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'TxtConjunto');">
    <td align="right" class="ColorTabla02">Hora Salida:</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtHoraS" type="text" class="InputCen" id="TxtHoraS2" value="<?php echo $TxtHoraS; ?>" size="10" maxlength="10" readonly></td>
    <td align="right" class="ColorTabla02">Peso Neto:</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtPesoNeto" type="text" class="InputCen" id="TxtNeto" value="<?php echo $TxtPesoNeto; ?>" size="10" maxlength="10" readonly></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Conjunto:</td>
    <td colspan="5" class="ColorTabla02">
	<input <?php echo $EstadoInput; ?> name="TxtConjunto" type="text" class="InputIzq" value="<?php echo $TxtConjunto; ?>" onKeyDown="TeclaPulsada2('S',true,this.form,'TxtNombre');" size="8" maxlength="5" onChange="Recarga2(TxtNombre,'');">
	
	<?php
		if( $TxtConjunto!='')
		{
			echo "<span class='TablaPrincipal3'>";
			$Consulta = "SELECT descripcion,cod_producto,cod_subproducto ";
			$Consulta.= " from ram_web.conjunto_ram ";
			$Consulta.= " where num_conjunto = '".$TxtConjunto."' and estado='a'";
			$Consulta.= " order by fecha_creacion desc";
			$Resultado = mysqli_query($link, $Consulta);
			if ($Row2 = mysqli_fetch_array($Resultado))
			{
				echo $Row2["descripcion"];
				$Consulta="SELECT descripcion from proyecto_modernizacion.productos where cod_producto='".trim($Row2["cod_producto"])."'";
				$RespProdRam=mysqli_query($link, $Consulta);
				if($FilaProdRam=mysqli_fetch_array($RespProdRam))
					$TxtNombre = $FilaProdRam["descripcion"];
				else
					$TxtNombre='';
				
				$Consulta="SELECT descripcion from proyecto_modernizacion.subproducto where cod_producto='".trim($Row2["cod_producto"])."' and cod_subproducto='".trim($Row2["cod_subproducto"])."'";
				$RespProdRam=mysqli_query($link, $Consulta);
				if($FilaProdRam=mysqli_fetch_array($RespProdRam))
					$TxtDescripcion = $FilaProdRam["descripcion"];
				else
					$TxtDescripcion='';
			}
			else
				echo "CONJUNTO NO IDENTIFICADO";
			echo "</span>";
		}
	
	?>
	</td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Nombre:</td>
    <td class="ColorTabla02"><input name="TxtNombre" type="text" class="InputIzq" id="TxtNombre" value="<?php echo $TxtNombre; ?>" onKeyDown="TeclaPulsada2('N',true,this.form,'TxtDescripcion');" size="24" ></td>
    <td class="ColorTabla02">&nbsp;</td>
    <td class="ColorTabla02">&nbsp;</td>
    <td class="ColorTabla02">&nbsp;</td>
    <td class="ColorTabla02">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Descripcion:</td>
    <td class="ColorTabla02"><input name="TxtDescripcion" type="text" class="InputIzq" id="TxtDescripcion" value="<?php echo $TxtDescripcion; ?>" onKeyDown="TeclaPulsada2('N',true,this.form,'TxtObs');" size="24" ></td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td align="left" class="ColorTabla02">&nbsp;</td>
    <td colspan="2" align="right" class="ColorTabla02">&nbsp;</td>
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
if($Mensaje!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('$Mensaje');";
	echo "var f = document.FrmOtrosPesajes;";
	//echo "f.TxtPatente.focus();";
	echo "</script>";
}
echo "<script language='JavaScript'>";
echo "var f = document.FrmOtrosPesajes;";
echo "f.TxtNumRomana.value = LeerRomana(f.TxtNumRomana.value);";
//echo "alert(f.TxtNumRomana.value);";
echo "</script>";

/*function PesoHistorico($Patente,$TxtPesoHistorico,$Proc)
{

}*/
?>