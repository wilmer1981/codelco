
<? include("../principal/conectar_pcip_web.php");
if($Volver=='S')
{
	if($Valores=='S')
	{
		$Opc='N';
	}
	else
	{
		$Opc='M';
	}
}
if ($Opc=='M')
{
	$Consulta="select * from pcip_svp_negocios t1 ";
	$Consulta.=" where t1.cod_negocio='".$Valores."' ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["cod_negocio"];
		$TxtNegocio=$Fila["nom_negocio"];
		$TxtOrden=$Fila["orden"];
		$CmbVig=$Fila["vigente"];
		$CmbMAsig=$Fila["vigente"];	
		$CmbMPpc=$Fila["vigente"];	
	}
}	
else
{
	$Consulta="select max(cod_negocio+1) as maximo from pcip_svp_negocios where cod_negocio<>'99'";
	$Resp=mysql_query($Consulta);
	//echo $Consulta,
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["maximo"];
	}
		$cod_negocio='';
		$CmbVig='-1';
}
?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nuevo Negocio</title>";
		else	
			echo "<title>Modifica Negocio</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
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
			if(f.TxtNegocio.value=='')
			{
				alert("Debe Ingresar Negocio");
				f.TxtNegocio.focus();
				return;
			}
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}			
				f.action = "pcip_mantenedor_negocio_proceso01.php?Opcion="+Opcion+"&Codigo="+f.TxtCodigo.value+"&TxtNegocio="+f.TxtNegocio.value+"&vigente="+f.CmbVig.value+"&CmbMAsig="+f.CmbMAsig.value+"&CmbMPpc="+f.CmbMPpc.value;
				f.submit();
		        break;
		case "M":
			if(f.TxtNegocio.value=='')
			{
				alert("Debe Ingresar Negocio");
				f.TxtNegocio.focus();
				return;
			}
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}			
				f.action = "pcip_mantenedor_negocio_proceso01.php?Opcion="+Opcion+"&Codigo="+f.TxtCodigo.value+"&TxtNegocio="+f.TxtNegocio.value+"&vigente="+f.CmbVig.value+"&CmbMAsig="+f.CmbMAsig.value+"&CmbMPpc="+f.CmbMPpc.value;
				f.submit();
        		break;
		case "NI":
				f.action = "pcip_mantenedor_negocio_proceso.php?Opc=N";
				f.submit();
				break;
				
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
	echo '<body onLoad="document.FrmPopupProceso.TxtNegocio.focus();">';
	else
		echo '<body onLoad="document.FrmPopupProceso.TxtNegocio.focus();">';
?>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
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
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../pcip_web/archivos/sub_tit_negocio_n.png"><? }else{?><img src="../pcip_web/archivos/sub_tit_negocio_m.png"><?	}?></td>
       <td align="right">
	   <a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
	   <a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="../pcip_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="0" >
	     <tr>
           <td width="283" class="formulario2">Codigo</td>
           <td class="formulariosimple" colspan="3">
		    <input name="TxtCodigo"  readonly="" size="5" type="text" id="TxtCodigo" value="<? echo $TxtCodigo; ?>"></td>
         </tr>
	     <tr>
           <td width="283" class="formulario2">Nombre Negocio</td>
           <td class="formulariosimple" colspan="3">
		    <input name="TxtNegocio" maxlength= "80" size="80" type="text" id="TxtNegocio" value="<? echo $TxtNegocio; ?>">
            <span class="InputRojo">(*)</span></td>
         </tr>
	     <tr>
           <td width="283" class="formulario2">Orden</td>
           <td class="formulariosimple" colspan="3">
		    <input name="TxtOrden" maxlength= "10" size="10" type="text" id="TxtOrden" value="<? echo $TxtOrden; ?>">
            <span class="InputRojo">(*)</span></td>
         </tr>
		 <tr>
           <td width="283" class="formulario2">Mostrar Asignación</td>
           <td width="146" class="formulariosimple" ><select name="CmbMAsig" >
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbMAsig==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
           </select>
             <span class="InputRojo">(*)</span> </td>
           <td width="166" class="formulario2">Mostrar PPC</td>
           <td width="445" class="formulariosimple" ><select name="CmbMPpc" >
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbMPpc==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
           </select>
             <span class="InputRojo">(*)</span> </td>
         </tr>		 		 
		 <tr>
           <td width="283" class="formulario2">Vigente</td>
           <td class="formulariosimple" colspan="3"><select name="CmbVig" >
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
           <td colspan="4" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
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
	if ($Mensaje==1)
		echo "alert('Negocio Ingresado Exitosamente');";
	if ($Mensaje==2)
		echo "alert('Este Registro ya Existe');";		
	if ($Mensaje==3)
		echo "alert('Negocio Modificado Exitosamente');";		
	echo "</script>";
?>