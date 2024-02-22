<?php
	include("../principal/conectar_principal.php"); 

	if(isset($_REQUEST["Op"])){
		$Op = $_REQUEST["Op"];
	}else{
		$Op = "";
	}
	if(isset($_REQUEST["Buscar"])){
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar = "";
	}
	if(isset($_REQUEST["CmbProveedor"])){
		$CmbProveedor = $_REQUEST["CmbProveedor"];
	}else{
		$CmbProveedor = "";
	}
	if(isset($_REQUEST["SA"])){
		$SA = $_REQUEST["SA"];
	}else{
		$SA = "";
	}
	if(isset($_REQUEST["L"])){
		$L = $_REQUEST["L"];
	}else{
		$L = "";
	}
	if(isset($_REQUEST["R"])){
		$R = $_REQUEST["R"];
	}else{
		$R = "";
	}
	if(isset($_REQUEST["TxtLote"])){
		$TxtLote = $_REQUEST["TxtLote"];
	}else{
		$TxtLote = "";
	}
	if(isset($_REQUEST["TxtRecargo"])){
		$TxtRecargo = $_REQUEST["TxtRecargo"];
	}else{
		$TxtRecargo = "";
	}
	
	
	$OK='N';
	if($Op=='QS')
	{
		$Actualizar="UPDATE sipa_web.recepciones set sa_asignada=NULL, activo='S' where lote = '".$L."' and recargo='".$R."' ";
		mysqli_query($link, $Actualizar);
		$Buscar='S';
		$OK='S';
		$TxtLote=$L;
		$TxtRecargo=$R;
	}

	$TxtConjunto=""; //WSO
	$CmbGrupoProd="";
	$CmbProducto="";
	$CmbSubProducto="";
	$CmbEstadoLote="";
	$CmbClase="";
	$TxtAsignacion="";
	$ChkFinLote="";
	$TxtFechaRecep="";
	$ChkFinLote="";
	$TxtPatente="";
	$TxtPesoBruto="";
	$TxtPesoTara="";
	$TxtPesoNeto="";
	$TxtCorrelativo="";
	$TxtGuia="";
	$TxtObs="";
	$TxtSolAnalisis="";
	$EstadoActual="";
	$HabilitarBtn="";
	$LoteB="";
	$Rgo="";
	if ($Buscar=='S')
	{
		
		$Consulta = "SELECT t1.sa_asignada,t1.rut_prv,t1.observacion,t1.lote,t1.recargo,t1.cod_producto,t1.cod_subproducto,t1.cod_mina,t1.rut_prv,t1.cod_clase,t1.conjunto,t1.estado, ";
		$Consulta.= "t1.correlativo,t1.patente,t1.fecha,t1.ult_registro,t1.peso_bruto,t1.peso_tara,t1.peso_neto,t1.guia_despacho,t2.asignacion,t1.cod_grupo ";
		$Consulta.= " from sipa_web.recepciones t1 left join sipa_web.rut_asignacion t2 on t1.rut_prv=t2.rut_prv ";
		$Consulta.= " where t1.lote = '".$TxtLote."' and recargo='".$TxtRecargo."'";
		$Resp = mysqli_query($link, $Consulta);
		//echo $Consulta;
		if ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$TxtLote = $Fila["lote"];
			$TxtSolAnalisis = $Fila["sa_asignada"];
			$Consulta="SELECT t1.estado_actual,t2.nombre_subclase as estado from cal_web.solicitud_analisis t1 left join proyecto_modernizacion.sub_clase t2 ";
			$Consulta.="on t2.cod_clase='1002' and t1.estado_actual=t2.cod_subclase ";
			$Consulta.="where t1.nro_solicitud='".$TxtSolAnalisis."' and t1.id_muestra='".$TxtLote."' and t1.recargo='".$TxtRecargo."'";
			$RespSA = mysqli_query($link, $Consulta);
			//echo $Consulta;
			if ($FilaSA = mysqli_fetch_array($RespSA))
			{
				$EstadoActual=$FilaSA["estado"];
				$HabilitarBtn='N';
				//SI NO ESTA AT. QUIMICO O FINALIZADA SE PUEDE QUITAR RELACION CON SIPA
				if($FilaSA["estado_actual"]!=5 && $FilaSA["estado_actual"]!=6)
				{
					$HabilitarBtn='S';
				}
			}
			$CmbGrupoProd = $Fila["cod_grupo"];
			$CmbProducto = $Fila["cod_producto"];
			$CmbSubProducto=$Fila["cod_subproducto"];
			$CmbProveedor = $Fila["rut_prv"];
			$CmbSubP = $Fila["cod_producto"]."~".$Fila["cod_subproducto"];
			$CmbMinaPlanta=$Fila["rut_prv"]."~".$Fila["cod_mina"]."~".$Fila["conjunto"];
			//$CmbCodFaena = $Fila["cod_mina"];
			$TxtConjunto = $Fila["conjunto"];
			if(!is_null($Fila["asignacion"]))
				$TxtAsignacion=$Fila["asignacion"];
			else
				$TxtAsignacion="MAQ ENM";
			$CmbClaseProducto = $Fila["cod_clase"];
			$CmbEstadoLote = $Fila["estado"];
			$TxtRecargo = $Fila["recargo"];
 				$LoteB=$Fila["lote"];
				$Rgo=$Fila["recargo"];
				$TxtCorrelativo = $Fila["correlativo"];
				$TxtFechaRecep = $Fila["fecha"];
				$ChkFinLote = $Fila["ult_registro"];
				$TxtPesoBruto = $Fila["peso_bruto"];
				$TxtPesoTara = $Fila["peso_tara"];
				$TxtPesoNeto = $Fila["peso_neto"];
				$TxtGuia = $Fila["guia_despacho"];
				$TxtPatente = $Fila["patente"];
				$TxtObs=$Fila["observacion"];
			
		}
	}
	$AbastMinero=""; // WSO
	if(isset($CmbGrupoProd))
	{
		$Consulta="SELECT abast_minero from sipa_web.grupos_productos where cod_grupo='$CmbGrupoProd'";
		$RespGrupo=mysqli_query($link, $Consulta);
		$FilaGrupo=mysqli_fetch_array($RespGrupo);
		//$AbastMinero=$FilaGrupo["abast_minero"];
		if(isset($FilaGrupo["abast_minero"])){
			$AbastMinero=$FilaGrupo["abast_minero"];
		}else{
			$AbastMinero="";
		}

		if($AbastMinero=='N')
			$BuscarPrv='S';
	}	
	$Consulta = "SELECT * from sipa_web.proveedores where rut_prv='$CmbProveedor'";
	$Respuesta=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Respuesta))
		$TxtNombrePrv=$Fila["nombre_prv"];
?>
<html>
<head>
<title>Sistema Pesaje Desvincular SA de Recargo en Estado Creado</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
var digitos=20 //cantidad de digitos buscados 
var puntero=0 
var buffer=new Array(digitos) //declaraci�n del array Buffer 
var cadena="" 
function Proceso(opt,SA,L,R)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "R":
			
				if (f.TxtLote.value==""){
					alert("Debe Ingresar Num. Lote");
					f.TxtLote.focus();
					return;}
				
				if (f.TxtRecargo.value=="" || f.TxtRecargo.value=="0"){
					alert("Debe Ingresar Num. de Recargo");
					f.TxtRecargo.focus();
					return;}
				f.action = "rec_adm_lote_sa.php?Buscar=S";
				f.submit();	

		break;		
			
		case "QS": //RECARGA		
			if(confirm("�Esta Seguro De Eliminar la Relaci�n del Lote con S.A.?"))
			{
				f.action = "rec_adm_lote_sa.php?Op=QS&SA="+SA+"&L="+L+"&R="+R;
				f.submit();
			}		
			break
		case "S":
			frmProceso.action = "../principal/sistemas_usuario.php?CodSistema=24";
			frmProceso.submit();

			break;
	}
}

function buscar_op(obj,objfoco,InicioBusq,Recargar){ 
   var f = document.FrmRecepcion;
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
 
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmProceso" method="post" action="">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="NewRec" value="<?php echo $NewRec; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
<input type="hidden" name="TxtCorr" value="<?php echo $TxtCorr; ?>">
<?php include("../principal/encabezado.php") ?>



<table class="TablaPrincipal" width="770" height="330" cellpadding="0" cellspacing="0" >
	<tr>
	  <td width="760" height="330" align="center" valign="top"><br>

<table width="600"  border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="4"><strong>
	    <?php
	
			echo "Desvincular Solicitud An�lisis";
		
	?>
    </strong></td>
  </tr>
 
  <tr class="ColorTabla02">
    <td colspan="4"><strong>BUSCAR LOTE </strong></td>
  </tr>
  <tr class="Colum01">
    <td width="155">Lote:</td>
    <td colspan="3"><input name="TxtLote" type="text" class="InputCen" id="TxtLote" value="<?php echo $TxtLote; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'TxtRecargo');"></td>
    </tr>
  <tr class="Colum01">
    <td>Recargo</td>
    <td colspan="3"><input name="TxtRecargo" type="text" class="InputDer" id="TxtRecargo" value="<?php echo $TxtRecargo; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'BtnBuscar');"></td>
    </tr>
  <tr class="Colum01">
    <td colspan="4" align="center"><input name="BtnBuscar" type="button" id="BtnBuscar" value="Buscar"  onClick="Proceso('R','','')">
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S','','')"></td>
  </tr></table>
<br />
 <?php if($TxtLote!='')
  {
  ?><table  border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">

  <tr class="ColorTabla02">
    <td colspan="4"><strong>DATOS DEL LOTE </strong></td>
  </tr>

  <tr class="Colum01">
    <td width="104" class="Colum01">Lote:</td>
    <td width="200" class="Colum01"><?php echo $TxtLote; ?>&nbsp;</td>
    <td width="145" align="right" class="Colum01">Num.Conjunto:</td>
    <td width="124" class="Colum01"><?php echo $TxtConjunto; ?>&nbsp;</td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Grupo Prod :</td>
    <td class="Colum01">
    
        <?php
				$Consulta = "SELECT * from sipa_web.grupos_productos where cod_grupo='".$CmbGrupoProd ."' order by descripcion_grupo ";
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Fila2= mysqli_fetch_array($Resp2))
				{
				echo strtoupper($Fila2["descripcion_grupo"]);
				}
		?>
      
    &nbsp;</td>
    <td align="right" class="Colum01">Estado del Lote:</td>
    <td class="Colum01">
      <?php
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase='24001' and valor_subclase1='".$CmbEstadoLote."' order by cod_subclase";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2= mysqli_fetch_array($Resp2))
		{
			echo $Fila2["nombre_subclase"];
			}
	 ?>
&nbsp;</td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">SubProducto:</td>
    <td colspan="3" class="Colum01">
        <?php
				$Consulta="SELECT  t1.cod_producto,t1.cod_subproducto,t2.abreviatura as nom_prod,t2.descripcion as nom_subprod, ";
				$Consulta.= " case when length(t1.cod_subproducto)<2 then concat('0',t1.cod_subproducto) else t1.cod_subproducto end as orden ";
				$Consulta.="from sipa_web.grupos_prod_subprod t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto =t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.="where t1.cod_grupo='".$CmbGrupoProd."' and t1.cod_producto='".$CmbProducto."' and t1.cod_subproducto='".$CmbSubProducto."' order by t2.descripcion";
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Resp2))
				{
					echo str_pad($Fila2["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila2["nom_subprod"]);
				}
			  ?>
     
 &nbsp;</td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Proveedor:</td>
	
    <td colspan="3" class="Colum01">

        <?php
					$Consulta = "SELECT distinct rut_prv,nombre_prv from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
					$Consulta.= " on t1.rut_prv=t2.rut_proveedor ";
					$Consulta.= " where t2.cod_producto='".$CmbProducto."' and t2.cod_subproducto='".$CmbSubProducto."' and rut_prv='".$CmbProveedor."'";
					$Consulta.= " order by t1.nombre_prv";
					$Resp2 = mysqli_query($link, $Consulta);
					if($Fila2 = mysqli_fetch_array($Resp2))
					{
						echo str_pad($Fila2["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila2["nombre_prv"];
					}
				?>
  &nbsp;</td>
	
	   
  </tr>
  	<?php
		if($AbastMinero=='S')
		{
	?>	
  <tr class="Colum01">
    <td class="Colum01">Cod Mina/Planta: </td>
    <td colspan="3" class="Colum01">
         <?php
	  		if($CmbMinaPlanta!='')
			{
				$SubProd=explode('~',$CmbSubP);
				$Datos=explode('~',$CmbMinaPlanta);
				$Consulta = "SELECT  t1.rut_prv,t1.cod_mina,t1.nombre_mina,t1.sierra,t1.comuna,t1.fecha_padron,t3.conjunto from sipa_web.minaprv t1 ";
				$Consulta.= "left join sipa_web.grupos_prod_prv t2 on t2.cod_producto='1' and t2.cod_subproducto='".$SubProd[1]."' ";
				$Consulta.= "and t2.rut_prv='".$CmbProveedor."' and t2.cod_mina=t1.cod_mina ";
				$Consulta.= "left join sipa_web.grupos_conjunto t3 on t3.cod_grupo=t2.cod_grupo ";
				$Consulta.= "where t1.rut_prv='".$CmbProveedor."' ";
				$Consulta.= "order by t1.rut_prv,t1.cod_mina,t1.nombre_mina";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Datos[0] == $Fila["rut_prv"]&&$Datos[1] == $Fila["cod_mina"]&&$Datos[2] == $Fila["conjunto"])
						echo $Fila["cod_mina"]." | ".$Fila["nombre_mina"]." | ".$Fila["sierra"]." | ".$Fila["comuna"];
				}			
			}
	  ?>
     
    &nbsp;</td>
    </tr>
	<?php
		}
	?>
  <tr class="Colum01">
    <td class="Colum01">Clase Producto:</td>
    <td class="Colum01">
          <?php
			$CodProdSub=explode('~',$CmbSubProducto);
			if($CodProdSub[0]=='1')
			{	
				switch($CodProdSub[1])
				{
					case "1":
					case "2":
					case "4":
					case "5":
					case "6":
					case "9":
					case "13":
						$CmbClase='G';
						break;
					case "17":
					case "18":
					case "16":
						$CmbClase='M';
						break;
					default:
						$CmbClase='O';
						break;
				}
			}	
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='15001' ";
			if($CmbClase=='O')
				$Consulta.="and nombre_subclase='O' ";//OTRA
			$Consulta.="order by nombre_subclase";
			$RespAsig=mysqli_query($link, $Consulta);
			while($FilaAsig=mysqli_fetch_array($RespAsig))
			{
				if($FilaAsig["nombre_subclase"]==$CmbClase)
					echo $FilaAsig["valor_subclase1"];
			}
		?>
    &nbsp; </td>
    <td align="right" class="Colum01">Cod.Recep:</td>
    <td class="Colum01">
      <?php echo $TxtAsignacion; ?>&nbsp;
    </td>
  </tr>
  <tr class="ColorTabla02">
    <td colspan="4"><strong>
<?php		echo "DATOS DEL RECARGO";
?>	 </strong></td>
  </tr>
  <tr>
    <td width="104" class="Colum01">Num.Recargo:</td>
    <td class="Colum01"><?php echo $TxtRecargo; ?>&nbsp;</td>
    <td width="145" align="right" class="Colum01">Fin Lote:</td>
    <td width="124" class="Colum01">
    <?php
	switch ($ChkFinLote)
	{
		case "S":
			echo "Si";
			break;
		default:
			echo "No";
		break;
	}
?>  
  </tr>
  <tr>
    <td class="Colum01">Fecha Recep:</td>
    <td class="Colum01">      <?php echo $TxtFechaRecep; ?>&nbsp;</td>
    <td align="right" class="Colum01">Peso Bruto:</td>
    <td class="Colum01"><?php echo $TxtPesoBruto;?>&nbsp; </td>
  </tr>
  <tr>
    <td class="Colum01">Patente:</td>
    <td class="Colum01"><?php echo $TxtPatente; ?>&nbsp;</td>
    <td align="right" class="Colum01">Peso Tara:</td>
    <td class="Colum01"><?php echo $TxtPesoTara; ?>&nbsp; </td>
  </tr>
  <tr>
    <td class="Colum01">Correlativo: </td>
    <td class="Colum01"><?php echo str_pad($TxtCorrelativo,5,0,STR_PAD_LEFT); ?>&nbsp;</td>
    <td align="right" class="Colum01">Peso Neto:</td>
    <td class="Colum01"><?php echo $TxtPesoNeto;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="Colum01">Guia Despacho:</td>
    <td class="Colum01"><?php echo $TxtGuia; ?>&nbsp;</td>
    <td align="right" class="Colum01">&nbsp;</td>
    <td class="Colum01" ><span class="InputRojo">&nbsp;</span></td>
  </tr>
  <tr>
    <td class="Colum01">Observacion:</td>
    <td class="Colum01" colspan="3"><?php echo $TxtObs; ?>&nbsp;</td>
  </tr>
  <tr>
    <td class="Colum01">Solicitud An&aacute;lisis </td>
    <td class="Colum01" colspan="3" ><span class="InputRojo"><?php echo $TxtSolAnalisis;?></span>&nbsp;Estado Actual:&nbsp;<span class="InputRojo"><?php echo $EstadoActual;?></span></td>
  </tr>
  <tr align="center" valign="middle">
    <td height="30" colspan="4" class="Colum01">
	  <?php
	  $EstBtn='';
	  if($HabilitarBtn=='N')
	  	$EstBtn='disabled="disabled"';
	  ?>
	  <input name="BtnGuardar" type="button" id="BtnGuardar" value="Quitar Relaci�n Solicitud" onClick="Proceso('QS','<?php echo $TxtSolAnalisis;?>','<?php echo $LoteB;?>','<?php echo $Rgo;?>')" <?php echo $EstBtn;?>>
	  <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S','','')"></td>
    </tr>
</table>
<?php 

}?> </td></tr></table>
</form>
</body>
</html>
<?php if($OK=='S')
{
?>
<script language="javascript">
	alert("Desvinculaci�n Realizada con Exito");
</script>
	<?php
}?>