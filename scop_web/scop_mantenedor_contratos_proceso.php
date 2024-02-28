	<?  
	include("../principal/conectar_scop_web.php");
	$KoolControlsFolder="KoolPHPSuite/KoolControls";
	require $KoolControlsFolder."/KoolTabs/kooltabs.php";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";
	
	if($koolajax->isCallback)
	{
		sleep(1); //Slow down 1s to see loading effect
	}
	echo $koolajax->Render();
	
	
	//ESTO ES PARA LOS TABS
	$kts = new KoolTabs("kts");
	$kts->scriptFolder = $KoolControlsFolder."/KoolTabs";
	$kts->styleFolder="office2007";
	
	$TabRes='true';$BlockRes='block';$BlockRec='none';$BlockBen='none';$BlockSF='none';
	if($TabRec=='true')
	{
		$TabRes='';;$TabRec='true';$TabBen='';$TabSF='';
		$BlockRes='none';$BlockRec='block';$BlockBen='none';$BlockSF='none';
	}
	if($TabBen=='true')
	{
		$TabRes='';;$TabRec='';$TabBen='true';$TabSF='';
		$BlockRes='none';$BlockSI='none';$BlockRec='none';$BlockBen='block';$BlockSF='none';
	}
	if($TabSF=='true')
	{
		$TabRes='';;$TabRec='';$TabBen='';$TabSF='true';
		$BlockRes='none';;$BlockRec='none';$BlockBen='none';$BlockSF='block';
	}
	$kts->addTab("root","resumen","Resumen","javascript:showPage(\"resumen_page\")",$TabRes);//Make node selection	
	$kts->addTab("root","recepcion","Recepcion","javascript:showPage(\"recepcion_page\")",$TabRec);	
	$kts->addTab("root","beneficio","Beneficios","javascript:showPage(\"beneficio_page\")",$TabBen);	
	$kts->addTab("root","stockfinal","StockFinal","javascript:showPage(\"stockfinal_page\")",$TabSF);
	

 $Disabled='';
if($Opc=='M')
{	
    $Datos=explode("~",$Valores);
	$Consulta = "select * from scop_contratos where cod_contrato='".$Datos[0]."'";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtContrato=$Fila["cod_contrato"];
		$TxtNumContrato=$Fila["num_contrato"];
		$TxtDescripcion=$Fila["descrip_contrato"];
		$CmbTipoContrato=$Fila["cod_tipo_contr"];
		if($Fila["tipo_cu"]==1)
			$CmbAcuerdoCu=$Fila["acuerdo_cu"];		
		else
		{
			$CmbAcuerdoCu='P';		
			$PFCU=$Fila["acuerdo_cu"];		
		}
		if($Fila["tipo_ag"]==1)
			$CmbAcuerdoAg=$Fila["acuerdo_ag"];
		else
		{
			$CmbAcuerdoAg='P';		
			$PFAG=$Fila["acuerdo_ag"];		
		}			
		if($Fila["tipo_au"]==1)
			$CmbAcuerdoAu=$Fila["acuerdo_au"];	
		else
		{
			$CmbAcuerdoAu='P';		
			$PFAU=$Fila["acuerdo_au"];		
		}	
		$CmbVig=$Fila["vigente"];		
	}
}
else
{
	$Consulta="select max(cod_contrato+1) as maximo from scop_contratos ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		if($Fila["maximo"]=='')
			$TxtContrato='1';
		else		
			$TxtContrato=$Fila["maximo"];
	}
		$TxtNumContrato='';
		$TxtDescripcion='';
		$CmbTipoContrato='-1';
		$CmbVig=''-1;		
}
$TxtFechaContr=date("Y-m-d");
?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nuevo Contrato</title>";
	else	
		echo "<title>Modifica Contrato</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/scop_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	var Valida=true;
	var Veri="";
	var Check="";
	switch(Opcion)
	{
		case "N":
			if(f.TxtNumContrato.value=='')
			{
				alert("Debe Ingresar N&uacute;mero Contrato");
				f.TxtNumContrato.focus();
				return;
			}
			if(f.TxtDescripcion.value=='')
			{
				alert("Debe Ingresar Descripci�n de Contrato");
				f.TxtDescripcion.focus();
				return;
			}
			if(f.CmbTipoContrato.value=='-1')
			{
				alert("Debe Seleccionar Tipo Contrato");
				f.CmbTipoContrato.focus();
				return;
			}			
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}		
			f.action = "scop_mantenedor_contratos_proceso01.php?Opcion="+Opcion;
			f.submit();
			break;
		case "M":
			if(f.TxtDescripcion.value=='')
			{
				alert("Debe Ingresar Descripci�n de Contrato");
				f.TxtDescripcion.focus();
				return;
			}
			if(f.CmbTipoContrato.value=='-1')
			{
				alert("Debe Seleccionar Tipo Contrato");
				f.CmbTipoContrato.focus();
				return;
			}			
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}		
			f.action = "scop_mantenedor_contratos_proceso01.php?Opcion="+Opcion;
			f.submit();
			break;
		case "NI":
				f.action = "scop_mantenedor_contratos_proceso.php?Opc=N";
				f.submit();
				break;
		case "R":	
				f.action = "scop_mantenedor_contratos_proceso.php?";
				f.submit();
		break;
				
	}
}
function ProcesoFlujo()
{
	var popup=0;
	var f= document.FrmPopupProceso;
	URL="scop_mantenedor_contratos_otros_flujos.php?Opc=NF";
	opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=750,height=450,scrollbars=1';
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 640)/2,0);
	
}
function ProcesoNuevo (Opcion,Check,R)
{
	var f= document.FrmPopupProceso;
	switch(Opcion)
	{
		case "NRECEP":
			if(f.TxtNumContrato.value=='')
			{
				alert("Debe Ingresar N&uacute;mero Contrato");
				f.TxtNumContrato.focus();
				return;
			}
			if(f.TxtDescripcion.value=='')
			{
				alert("Debe Ingresar Descripci�n de Contrato");
				f.TxtDescripcion.focus();
				return;
			}
			if(f.CmbTipoContrato.value=='-1')
			{
				alert("Debe Seleccionar Tipo Contrato");
				f.CmbTipoContrato.focus();
				return;
			}			
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}		
			if(f.CmbFlujoRecep.value=='T')
			{
				alert("Debe Seleccionar Flujo");
				f.CmbFlujoRecep.focus();
				return;
			}	
			if(f.CmbSignoRec.value=='T')
			{
				alert("Debe Seleccionar Signo");
				f.CmbSignoRec.focus();
				return;
			}
			if(f.radiorecepcion[0].checked)
				Valor='ENA';
			if(f.radiorecepcion[1].checked)
				Valor='PMN';
			if(f.radiorecepcion[2].checked)
				Valor='OTRO';
			f.action = "scop_mantenedor_contratos_proceso01.php?Opcion="+Opcion+"&Valor="+Valor+"&CheckREC="+Check+"&R="+R;
			f.submit();
		break;
		case "NBENE":
			if(f.TxtNumContrato.value=='')
			{
				alert("Debe Ingresar N&uacute;mero Contrato");
				f.TxtNumContrato.focus();
				return;
			}
			if(f.TxtDescripcion.value=='')
			{
				alert("Debe Ingresar Descripci�n de Contrato");
				f.TxtDescripcion.focus();
				return;
			}
			if(f.CmbTipoContrato.value=='-1')
			{
				alert("Debe Seleccionar Tipo Contrato");
				f.CmbTipoContrato.focus();
				return;
			}			
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}		
			if(f.CmbFlujoBene.value=='T')
			{
				alert("Debe Seleccionar Flujo");
				f.CmbFlujoBene.focus();
				return;
			}	
			if(f.CmbSignoBene.value=='T')
			{
				alert("Debe Seleccionar Signo");
				f.CmbSignoBene.focus();
				return;
			}
			if(f.radiobeneficio[0].checked)
				Valor='ENA';
			if(f.radiobeneficio[1].checked)
				Valor='PMN';
			if(f.radiobeneficio[2].checked)
				Valor='OTRO';
			f.action = "scop_mantenedor_contratos_proceso01.php?Opcion="+Opcion+"&Valor="+Valor+"&CheckBEN="+Check+"&R="+R;
			f.submit();
		break;
		case "NSKFIN":
			if(f.TxtNumContrato.value=='')
			{
				alert("Debe Ingresar N&uacute;mero Contrato");
				f.TxtNumContrato.focus();
				return;
			}
			if(f.TxtDescripcion.value=='')
			{
				alert("Debe Ingresar Descripci�n de Contrato");
				f.TxtDescripcion.focus();
				return;
			}
			if(f.CmbTipoContrato.value=='-1')
			{
				alert("Debe Seleccionar Tipo Contrato");
				f.CmbTipoContrato.focus();
				return;
			}			
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}		
			if(f.CmbFlujoFin.value=='T')
			{
				alert("Debe Seleccionar Flujo");
				f.CmbFlujoFin.focus();
				return;
			}	
			if(f.CmbSignoSF.value=='T')
			{
				alert("Debe Seleccionar Signo");
				f.CmbSignoSF.focus();
				return;
			}
			if(f.radiostockfinal[0].checked)
				Valor='ENA';
			if(f.radiostockfinal[1].checked)
				Valor='PMN';
			if(f.radiostockfinal[2].checked)
				Valor='OTRO';
			f.action = "scop_mantenedor_contratos_proceso01.php?Opcion="+Opcion+"&Valor="+Valor+"&CheckSF="+Check+"&R="+R;
			f.submit();
		break;
		
	}	
}
function ProcesoEliminar(Opcion,Cod)
{
var f= document.FrmPopupProceso;
	switch (Opcion)
	{
		case "ERECEP":
			f.action = "scop_mantenedor_contratos_proceso01.php?Opcion="+Opcion+"&Valores="+Cod;
			f.submit();
		break;		
		case "EBENE":
			f.action = "scop_mantenedor_contratos_proceso01.php?Opcion="+Opcion+"&Valores="+Cod;
			f.submit();
		break;		
		case "ESKFIN":
			f.action = "scop_mantenedor_contratos_proceso01.php?Opcion="+Opcion+"&Valores="+Cod;
			f.submit();
		break;		
	}		
}
function RecargaAcuerdo()
{
	var f= document.FrmPopupProceso;
	f.action = "scop_mantenedor_contratos_proceso.php?Opc=N";
	f.submit();

}
function Recarga(Opc)
{
var f= document.FrmPopupProceso;
	f.action = "scop_mantenedor_contratos_proceso.php?Opc="+Opc;
	f.submit();
}
function Salir()
{
	window.close();
}
</script>
<script type="text/javascript">
	function acuerdo_cu()
	{
		var acuerdo_cu = document.getElementById("CmbAcuerdoCu").value;			
		if(acuerdo_cu!="")
		{
			order_UPDATEpanel.attachData("acuerdo_cu",acuerdo_cu);
			order_UPDATEpanel.UPDATE();
		}
	}
	function acuerdo_ag()
	{
		var acuerdo_ag = document.getElementById("CmbAcuerdoAg").value;			
		if(acuerdo_ag!="")
		{
			order_UPDATEpanel2.attachData("acuerdo_ag",acuerdo_ag);
			order_UPDATEpanel2.UPDATE();
		}
	}
	function acuerdo_au()
	{
		var acuerdo_au = document.getElementById("CmbAcuerdoAu").value;			
		if(acuerdo_au!="")
		{
			order_UPDATEpanel3.attachData("acuerdo_au",acuerdo_au);
			order_UPDATEpanel3.UPDATE();
		}
	}
</script>
</head>
<?
if ($Opc=='N')
	echo '<body onLoad="document.FrmPopupProceso.TxtNumContrato.focus();">';
	else
		echo '<body onLoad="document.FrmPopupProceso.TxtDescripcion.focus();">';
?>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<input type="hidden" name="TxtContrato" value="<? echo $TxtContrato;?>">
<input type="hidden" name="TxtFechaContr" value="<? echo $TxtFechaContr;?>">
<table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="../scop_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="818" height="15"background="../scop_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="../scop_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../scop_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../scop_web/archivos/subtitulos/sub_tit_contratos_n.png"><? }else{?><img src="../scop_web/archivos/subtitulos/sub_tit_contratos_m.png"><?	}?></td>
       <td align="right">
	   <a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
	   <a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="../scop_web/archivos/grabar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="../scop_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="0" >
           <td width="99" class="formulario2">N&uacute;mero Contrato</td>
           <td class='formulario2' colspan="13">
		    <input name="TxtNumContrato" maxlength= "30"  size="35" type="text" id="TxtNumContrato" value="<? echo $TxtNumContrato; ?>">
            <span class="InputRojo">(*)</span>			</td>
         </tr>
		<tr>	 		 		  				 				  	 
           <td width="99" class="formulario2">Descripci�n</td>
           <td class="formulariosimple" colspan="12">
		   <input name="TxtDescripcion" maxlength= "48"  size="60" type="text" id="TxtDescripcion" value="<? echo $TxtDescripcion; ?>">
		   <span class="InputRojo">(*)</span> </td>
         </tr>		 		 		 
		 <tr>
           <td width="99" class="formulario2">Tipo Contrato </td>
           <td class="formulariosimple" colspan="12">
			   <select name="CmbTipoContrato" >
			   <option value="-1" class="NoSelec">Seleccionar</option>
				   <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='33002'";
					$Resp=mysql_query($Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbTipoContrato==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
					}
				   ?>
			   </select><?  //echo $Consulta; ?>
			  <span class="InputRojo">(*)</span></td>			
			</tr>	
		 <tr>
		  <td width="99" align="left" class="formulario2">Acuerdo Contractual Cu. </td>
		      <td width="255" align="left"  class="formulario2"><select name="CmbAcuerdoCu" id="CmbAcuerdoCu" onChange="acuerdo_cu()">
			   <option value="N" class="NoSelec">Ninguno</option>
			   <?
			   if("P"==$CmbAcuerdoCu)
			   {
			   ?>
				   <option value="P" selected>Precio Fijo</option>
			   <?
			   }
			   else
			   {
			   ?>
				   <option value="P">Precio Fijo</option>
			   <?
			   }
			   ?>
			   <?			   
			   if("-1"==$CmbAcuerdoCu)
			   {
			   ?>
			   <option value="-1" selected>Mes -1</option>			   
			   <?
			   }
			   else
			   {
			   ?>
			   <option value="-1">Mes -1</option>
			   <?
				}
				for($i=1;$i<=6;$i++)
				 {
				   if($i==$CmbAcuerdoCu)
						echo "<option value='".$i."' selected>Mes+".$i."</option>";
				   else
						echo "<option value='".$i."'>Mes+".$i."</option>";
				 }
			   ?>
			   </select>			   </td>
			   <td class="formulario2" align="left">
			   <? if($Opc=='N'){?>
				<div style="width:50px;min-height:100px;padding-top:5px;">
				    <?php echo KoolScripting::Start();?>
				    <UPDATEpanel id="order_UPDATEpanel">
				    <content>
				    <![CDATA[
					<? 		
						if(!isset($_POST["acuerdo_cu"])){ echo "&nbsp;";}							 				   
			   			if($_POST["acuerdo_cu"]=='P'){ echo "<input size='12' maxlength='10' onKeyDown='SoloNumerosyNegativo(true,this)' type='text' name='PFCU' value='".$PFCU."'>cUSD/LB";}
			   		?>					]]>												
				    </content>
				    <loading image="<?php echo $KoolControlsFolder; ?>/KoolAjax/loading/5.gif" />		
				    </UPDATEpanel>
				    <?php echo KoolScripting::End();?>				
				</div>	
				<? }
				   else
				   {
						?>
						<div style="width:100px;min-height:100px;padding-top:5px;">
							<?php echo KoolScripting::Start();?>
							<UPDATEpanel id="order_UPDATEpanel">
							<content>
							<![CDATA[
							<? 		
								if(!isset($_POST["acuerdo_cu"])){ echo "&nbsp;";}							 				   
								if($_POST["acuerdo_cu"]=='P'){ echo "<input size='12' maxlength='10' onKeyDown='SoloNumerosyNegativo(true,this)' type='text' name='PFCU' value='".$PFCU."'>cUSD/LB";}
							?>							]]>												
							</content>
							<loading image="<?php echo $KoolControlsFolder; ?>/KoolAjax/loading/5.gif" />		
							</UPDATEpanel>
							<?php echo KoolScripting::End();?>	
						</div>	
						<script type="text/javascript">
							acuerdo_cu();
						</script>
						<?					
				   }?>			   </td>	
		       <td class="formulario2" align="left">&nbsp;</td>
		       <td width="86" align="left" class="formulario2">Acuerdo Contractual Ag. </td>
		      <td width="252" align="left"  class="formulario2"><select name="CmbAcuerdoAg" id="CmbAcuerdoAg" onChange="acuerdo_ag()">
			   <option value="N" class="NoSelec">Ninguno</option>
			   <?
			   if("P"==$CmbAcuerdoAg)
			   {
			   ?>
				   <option value="P" selected>Precio Fijo</option>
			   <?
			   }
			   else
			   {
			   ?>
				   <option value="P">Precio Fijo</option>
			   <?
			   }
			   if("-1"==$CmbAcuerdoAg)
			   {
			   ?>
			   <option value="-1" selected>Mes -1</option>			   
			   <?
			   }
			   else
			   {
			   ?>
			   <option value="-1">Mes -1</option>
			   <?
				}
				for($i=1;$i<=6;$i++)
				 {
				   if($i==$CmbAcuerdoAg)
						echo "<option value='".$i."' selected>Mes+".$i."</option>";
				   else
						echo "<option value='".$i."'>Mes+".$i."</option>";
				 }
			   ?>
			   </select>			   </td>
			   <td class="formulario2" align="left">
			   <? if($Opc=='N'){?>
				<div style="width:100px;min-height:100px;padding-top:5px;" >
				    <?php echo KoolScripting::Start();?>
				    <UPDATEpanel id="order_UPDATEpanel2">
				    <content>
				    <![CDATA[
					<? 	
						if(!isset($_POST["acuerdo_ag"])){ echo "&nbsp;";}							 				   
			   			if($_POST["acuerdo_ag"]=='P'){ echo "<input size='12' maxlength='10' onKeyDown='SoloNumerosyNegativo(true,this)' type='text' name='PFAG' value='".$PFAG."'>USD/OZ";}
			   		?>					]]>												
				    </content>
				    <loading image="<?php echo $KoolControlsFolder; ?>/KoolAjax/loading/5.gif" />		
				    </UPDATEpanel>
				    <?php echo KoolScripting::End();?>				</div>							
				<? }
				   else
				   {
						?>
						<div style="width:100px;min-height:100px;padding-top:5px;" >
							<?php echo KoolScripting::Start();?>
							<UPDATEpanel id="order_UPDATEpanel2">
							<content>
							<![CDATA[
							<? 	
								if(!isset($_POST["acuerdo_ag"])){ echo "&nbsp;";}							 				   
								if($_POST["acuerdo_ag"]=='P'){ echo "<input size='12' maxlength='10' onKeyDown='SoloNumerosyNegativo(true,this)' type='text' name='PFAG' value='".$PFAG."'>USD/OZ";}
							?>							]]>												
							</content>
							<loading image="<?php echo $KoolControlsFolder; ?>/KoolAjax/loading/5.gif" />		
							</UPDATEpanel>
							<?php echo KoolScripting::End();?>						</div>							
						<script type="text/javascript">
							acuerdo_ag();
						</script>
						<?
				   }?>			  </td>	
		       <td class="formulario2" align="left">&nbsp;</td>
		       <td width="85" align="left" class="formulario2">Acuerdo Contractual Au. </td>
		  <td width="236" align="left"  class="formulario2"><select name="CmbAcuerdoAu" id="CmbAcuerdoAu" onChange="acuerdo_au()">
			   <option value="N" class="NoSelec">Ninguno</option>
			   <?
			   if("P"==$CmbAcuerdoAu)
			   {
			   ?>
				   <option value="P" selected>Precio Fijo</option>
			   <?
			   }
			   else
			   {
			   ?>
				   <option value="P">Precio Fijo</option>
			   <?
			   }
			   if("-1"==$CmbAcuerdoAu)
			   {
			   ?>
			   <option value="-1" selected>Mes -1</option>			   
			   <?
			   }
			   else
			   {
			   ?>
			   <option value="-1">Mes -1</option>
			   <?
				}
				for($i=1;$i<=6;$i++)
				 {
				   if($i==$CmbAcuerdoAu)
						echo "<option value='".$i."' selected>Mes+".$i."</option>";
				   else
						echo "<option value='".$i."'>Mes+".$i."</option>";
				 }
			   ?>
			   </select>			   </td>
			   <td class="formulario2" align="left">
			   <? if($Opc=='N'){?>
				<div style="width:100px;min-height:100px;padding-top:5px;">
				    <?php echo KoolScripting::Start();?>
				    <UPDATEpanel id="order_UPDATEpanel3">
				    <content>
				    <![CDATA[
					<? 		
						if(!isset($_POST["acuerdo_au"])){ echo "&nbsp;";}							 				   
			   			if($_POST["acuerdo_au"]=='P'){ echo "<input size='12' maxlength='10' onKeyDown='SoloNumerosyNegativo(true,this)' type='text' name='PFAU' value='".$PFAU."'>USD/OZ";}
			   		?>					]]>												
				    </content>
				    <loading image="<?php echo $KoolControlsFolder; ?>/KoolAjax/loading/5.gif" />		
				    </UPDATEpanel>
				    <?php echo KoolScripting::End();?>				</div>							
				<? }
				   else
				   {
				   		?>
						<div style="width:100px;min-height:100px;padding-top:5px;">
							<?php echo KoolScripting::Start();?>
							<UPDATEpanel id="order_UPDATEpanel3">
							<content>
							<![CDATA[
							<? 		
								if(!isset($_POST["acuerdo_au"])){ echo "&nbsp;";}							 				   
								if($_POST["acuerdo_au"]=='P'){ echo "<input size='12' maxlength='10' onKeyDown='SoloNumerosyNegativo(true,this)' type='text' name='PFAU' value='".$PFAU."'>USD/OZ";}
							?>							]]>												
							</content>
							<loading image="<?php echo $KoolControlsFolder; ?>/KoolAjax/loading/5.gif" />		
							</UPDATEpanel>
							<?php echo KoolScripting::End();?>						</div>							
						<script type="text/javascript">
							acuerdo_au();
						</script>
				<?						
				   }?>		                
			   <td class="formulario2" align="left">               
		 </tr>
		<tr>	 		 		  				 				  	 
           <td width="99" class="formulario2">Vigente</td>
           <td class="formulariosimple" colspan="12"><select name="CmbVig" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbVig==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
           </select>
             <span class="InputRojo">(*)</span> </td>
         </tr>		 		 
		<tr>	 		 		  				 				  	 
           <td colspan="12" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
        </tr>		 		 
       </table>
	   <? if($Opc=='M'){?>
			<table width="100%"  border="0" align="center" cellpadding="0"  cellspacing="0">				 
				 <tr>
				 <td width="78%" class="TituloTablaVerde" align="center">Configuraci�n de Flujos </td>
				 </tr>
				 <tr>
				 	<td>
					<div class="container">
						<div class="tabs">
							<?php echo $kts->Render();?>
						</div>
						<div class="multipages">
							<div id="resumen_page" class="pageResumen"  style="display:<? echo $BlockRes;?>;">
								<? include('scop_mantenedor_contratos_resumen.php');?>				
							</div>
							<div id="recepcion_page" class="pageRecepcion" style="display:<? echo $BlockRec;?>;">
								<? include('scop_mantenedor_contratos_recepcion.php');?>								
							</div>			
							<div id="beneficio_page" class="pageBeneficio" style="display:<? echo $BlockBen;?>;">
								<? include('scop_mantenedor_contratos_beneficio_emb.php');?>								
							</div>			
							<div id="stockfinal_page" class="pageStockFinal" style="display:<? echo $BlockSF;?>;">
								<? include('scop_mantenedor_contratos_stock_final.php');?>								
							</div>			
						</div>
					</div>
					<script type="text/javascript">
						function showPage(_pageid)
						{
							document.getElementById("resumen_page").style.display = "none";
							document.getElementById("recepcion_page").style.display = "none";
							document.getElementById("beneficio_page").style.display = "none";
							document.getElementById("stockfinal_page").style.display = "none";
				
							document.getElementById(_pageid).style.display = "block";
							
						}		
				
					</script>
					</td>
				</tr>											 
		    </table>
		<? }?>	
	 </td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   </td>
   <td width="16" background="../scop_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="../scop_web/archivos/images/interior/form_abajo.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="16" height="15"><img src="../scop_web/archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje)
		echo "alert('".$Mensaje."');";
	if ($Mensaje1)
		echo "alert('".$Mensaje1."');";
	if ($MensajeFlujo)
		echo "alert('".$MensajeFlujo."');";	
	if ($MensajeEli)
		echo "alert('".$MensajeEli."');";				
	echo "</script>";
?>