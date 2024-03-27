<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$Consulta="SELECT rut_adm_ctto from sget_hoja_ruta_adm_ctto ";
$Consulta.="  where num_hoja_ruta='".$NumHoja."'";
$Resp=mysqli_query($link, $Consulta);
$RutExi="(";
while($Fila=mysql_fetch_array($Resp))
{
	$RutExi=$RutExi."'".$Fila["rut_adm_ctto"]."',";
}
$RutExi=substr($RutExi,0,strlen($RutExi)-1).")";
if(isset($AdmCtto))
	$CmbAdmCtto=$AdmCtto;
?>
<title>Reasignaci�n de Administrador de Contrato</title>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">

function muestra(numero) 
{
 	var f=document.FrmObs;
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	
	{
		if (ie4)
		{
			eval(numero + ".style.visibility = 'visible'");
		
		}
	}
	//eval("f.Obs.value=f.ObsHito_"+ Hito +".value");
}
function oculta(numero) 
{

	var f=document.FrmObs;
f.Obs.value='';
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	
	{
		if (ie4)
		{
			eval(numero + ".style.visibility = 'hidden'");
		}
	}
}


function Proceso(Opt,Var1,Var2)
{
	var f=document.FrmObs;
	switch (Opt)
	{
		case "GADM"://GRABA ADMINISTRADOR DE CONTRATO REASIGNADO
			if(f.CmbAdmCtto.value=='-1')
			{
				alert('Debe Seleccionar Administrador de Contrato');
				return;
			}
			f.action = "sget_adm_hoja_ruta_reasigna01.php?Proceso="+Opt;
			f.submit();
		break;
		case "EADM"://ELIMINA ADMINISTRADOR REASIGNADO
			f.action = "sget_adm_hoja_ruta_reasigna01.php?Proceso="+Opt+"&RutAdm="+Var1;
			f.submit();
		break;
		case "AADM"://ACTIVA ADMINISTRADOR DE LA HOJA DE RUTA
			f.action = "sget_adm_hoja_ruta_reasigna01.php?Proceso="+Opt+"&RutAdm="+Var1;
			f.submit();
		break;
		case "GOBS"://GRABA OBSERVACION
			//alert(f.TxtObs[Var2].value)
			f.action = "sget_adm_hoja_ruta_reasigna01.php?Proceso="+Opt+"&RutAdm="+Var1+"&Observ="+f.TxtObs[Var2].value;
			f.submit();
		break;
		case "GEMAIL"://GRABA EMAIL
			//alert('ho');
			//alert(f.TxtMail[Var2].value);
			f.action = "sget_adm_hoja_ruta_reasigna01.php?Proceso="+Opt+"&RutAdm="+Var1+"&Email="+f.TxtMail[Var2].value;
			f.submit();
		break;

		case "S":
			window.opener.document.FrmPrincipal.action='sget_adm_hoja_ruta.php?Cons=S';
			window.opener.document.FrmPrincipal.submit();
			window.close();	
		break;
		case "I":
			window.print()
		break;
		case "Ctto":	
			URL = "sget_ingreso_administradores.php?Opc=A&Volver=R";
			window.open(URL,"","top=30,left=30,width=450,height=300,menubar=no,status=1,resizable=yes,scrollbars=yes");
		break;
			
	}
}
</script><link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmObs" method="post" action="">
<input name="CodSistema" type="hidden" value="<? echo $CodSistema; ?>">
<input name="CodPantalla" type="hidden" value="<? echo $CodPantalla; ?>">
<input name="CodHito" type="hidden" value="<? echo $H; ?>">
<input name="NumHoja" type="hidden" value="<? echo $NumHoja; ?>">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="918" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="74%" align="left"><img src="archivos/sub_tit_reasig_adm_ctto.png" /></td>
    <td align="right">
	<a href="JavaScript:Proceso('Ctto')"><img src="archivos/btn_agregar.png" height="25" width="25" alt="Crear Nuevo Adm. Contrato"align="absmiddle" border="0" /></a> 
	<a href="JavaScript:Proceso('I')"><img src="archivos/Impresora.png" width="25" height="25" border="0" alt="Imprimir" align="absmiddle" /></a>
	<a href="JavaScript:Proceso('S')"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0" /></a>
	</td>
  </tr>
</table>
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
       <tr>
         <td colspan="3"align="center" class="TituloTablaVerde"></td>
       </tr>
       <tr>
         <td width="1%" align="center" class="TituloTablaVerde"></td>
         <td align="center"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
           <tr>
             <td class="formulario2" ><span class="formulario">Adm. Contrato</span>
                 <SELECT name="CmbAdmCtto">
                   <option value="-1">Seleccionar</option>
                   <?
	  $Consulta = "SELECT * from sget_administrador_contratos where rut_adm_contrato not in ".$RutExi." order by ape_paterno ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbAdmCtto==$FilaTC["rut_adm_contrato"])
				echo "<option SELECTed value='".$FilaTC["rut_adm_contrato"]."'>".ucfirst(strtolower($FilaTC["ape_paterno"]))." ".ucfirst(strtolower($FilaTC["ape_materno"]))."  ".ucfirst(strtolower($FilaTC["nombres"]))."</option>\n";
			else
				echo "<option value='".$FilaTC["rut_adm_contrato"]."'>".ucfirst(strtolower($FilaTC["ape_paterno"]))." ".ucfirst(strtolower($FilaTC["ape_materno"]))."  ".ucfirst(strtolower($FilaTC["nombres"]))."</option>\n";
		}
			?>
                 </SELECT>
                 <? //echo  $Consulta;?>
               &nbsp; <a href="JavaScript:Proceso('GADM')"><img src="archivos/reasigna_agre2.png"  border="0" alt="Agregar Adm. Contrato para Reasignaci�n" align="absmiddle" /></a>&nbsp; </td>
           </tr>
		   <tr><td class="formulario2">&nbsp;</td>
		   </tr>
         </table>
           <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
             <tr>
               <td width="5%" class="TituloCabecera" align="center" >Elim.</td>
               <td width="20%" class="TituloCabecera" align="center" >Administrador</td>
               <td width="10%" class="TituloCabecera" align="center" >Mail</td>
               <td width="15%" class="TituloCabecera" align="center">Tipo</td>
               <td width="5%" class="TituloCabecera" align="center">Activo</td>
               <td width="40%" class="TituloCabecera" align="center">Observaci&oacute;n</td>
             </tr>
             <?
		$Consulta="SELECT * from sget_hoja_ruta_adm_ctto ";
		$Consulta.="  where num_hoja_ruta='".$NumHoja."' order by tipo";
		$Resp=mysqli_query($link, $Consulta);echo "<input name='TxtObs' type='hidden'><input name='TxtMail' type='hidden'>";$Cont=1;
		while($Fila=mysql_fetch_array($Resp))
		{
		   	$VarCodelco=AdmCodelco($Fila["rut_adm_ctto"]);
		   	$array=explode('~',$VarCodelco);
		   	$AdmCtto=FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
			$TxtMail=$array[5];
			?>
             <tr>
               <td align="center"><?
			if($Fila["tipo"]=='O'||$Fila["activo"]=='S')
			{
				echo "&nbsp;";
			}
			else
			{
			?>
                 <a href="JavaScript:Proceso('EADM','<? echo $Fila["rut_adm_ctto"]; ?>')"><img src="archivos/elim_hito.png"  border="0"  width='23' height='23' alt="Quitar Administrador Reasignado" align="absmiddle" /></a></td>
               <?
			}
			?>
               <td><? echo $AdmCtto;?>&nbsp;</td>
               <td><input name="TxtMail" type="text" size="30" value="<? echo $TxtMail;?>" maxlength="100">&nbsp;<a href="JavaScript:Proceso('GEMAIL','<? echo $Fila["rut_adm_ctto"]; ?>','<? echo $Cont;?>')"><img src="archivos/btn_guardar.png"  border="0"  width='23' height='23' alt="Grabar Email" align="absmiddle" /></a></td>
               <td><? 
			if($Fila["tipo"]=='O')
				echo "Adm. Ctto. Titular";
			else
				echo "Adm. Ctto. Reasignado";
			?>
                 &nbsp;</td>
               <td align="center"><?
			 if($Fila["activo"]=='S')
			 	echo "<img src='archivos/activo.png' width='20' height='20' alt='Activo' align='absmiddle'>";
			 else
			 {
			 ?>
                   <a href="JavaScript:Proceso('AADM','<? echo $Fila["rut_adm_ctto"]; ?>')"> <img src='archivos/inactivo.png' width='20' height='20' border='0' alt='Activar Administrador' align='absmiddle' /></a>
                   <?
			 }
			 ?>
                 &nbsp;</td>
               <td align="center"><textarea name="TxtObs" rows="2" cols="60"><? echo $Fila["observacion"];?></textarea>
                 <a href="JavaScript:Proceso('GOBS','<? echo $Fila["rut_adm_ctto"]; ?>','<? echo $Cont;?>')"><img src="archivos/btn_guardar.png"  border="0"  width='23' height='23' alt="Grabar Observacion" align="absmiddle" /></a></td>
             </tr>
             <?
			$Cont++;
		}
		?>
           </table>
</td>
         <td width="0%" align="center" class="TituloTablaVerde"></td>
       </tr>
       <tr>
         <td colspan="3"align="center" class="TituloTablaVerde"></td>
       </tr>
     </table>
     <br>
     <br>
     <br></td>
	 <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
    <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15"></td>
	<td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15"></td>
  </tr>
  </table>
<br>
<div id='Observacionxx'  style='FILTER: alpha(opacity=100); overflow:auto; VISIBILITY: hidden; WIDTH: 380px; height:196px; POSITION: absolute; moz-opacity: .75; opacity: .75;  left: 270px; top: 48px;'>
	<table width="77%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="614" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>

	
		<table width="320" border="0" align="center" cellpadding="2" cellspacing="0" >
		
		<tr >
		  <td >
		  <span class="titulo_azul">
		  <img src="archivos/vineta.gif" border="0">Ingreso&nbsp;Observaci�n</span>
		  </td>
         <td  align="right" >
		  <a href="JavaScript:Proceso('GOBS')"><img src="archivos/btn_guardar.png" height="20" alt="Guardar" width="20" border="0" align="absmiddle" /></a> 
		  <a href="JavaScript:oculta('Observacionxx')"><img src="archivos/cerrar1.png" width="25" height="25" border="0" alt="Cerrar" align="absmiddle"></a> 
		  </td>
		</tr>   
     
		<tr>
		<td colspan="2" align='center' >
		 <textarea name="Obs" cols="80" rows="8" wrap="VIRTUAL" ><? echo $Obs; ?></textarea>
		</td>
		</tr>
		
	   </table>
	   </td>
	 <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
    <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15"></td>
	<td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15"></td>
  </tr>
  </table>
  </div> 
  
</form>