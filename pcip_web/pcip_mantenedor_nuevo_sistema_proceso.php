
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
	$Consulta="select * from pcip_eec_sistemas t1 ";
	$Consulta.=" where t1.cod_sistema='".$Valores."' ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["cod_sistema"];
		$TxtSistema=$Fila["nom_sistema"];
		$TxtDescrip=$Fila["descripcion"];
		$CmbVig=$Fila["vigente"];	
		$CmbMostrar=$Fila["mostrar"];		
	}
}
else
{
	$Consulta="select max(cod_sistema+1) as maximo from pcip_eec_sistemas ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["maximo"];
	}
		$TxtSistema='';
		$TxtDescrip='';
		$CmbVig='-1';	
		$CmbMostrar='-1';		
	
}
?>
<html>
<head>
	<?
		if ($Opc=='N')
		echo "<title>Nuevo Sistema</title>";
		else	
		echo "<title>Modifica Sistema</title>";
	?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	switch(Opcion)
	{
		case "N":
			if(f.TxtSistema.value=='')
			{
				alert("Debe Ingresar un Sistema");
				return;
			}			
			if(f.TxtDescrip.value=='')
			{
				alert("Debe Ingresar Descripción");
				return;
			}
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				return;
			}
			if(f.CmbMostrar.value=='-1')
			{
				alert("Debe Seleccionar Ver Disponibilidad");
				return;
			}
				f.action = "pcip_mantenedor_nuevo_sistema_proceso01.php?Opcion="+Opcion+"&Codigo="+f.TxtCodigo.value+"&sistema="+f.TxtSistema.value+"&descrip="+f.TxtDescrip.value+"&vigente="+f.CmbVig.value+"&CmbMostrar="+f.CmbMostrar.value;
				f.submit();
		        break;
		case "M":
			if(f.TxtSistema.value=='')
			{
				alert("Debe Ingresar un Sistema");
				return;
			}			
			if(f.TxtDescrip.value=='')
			{
				alert("Debe Ingresar Descripción");
				return;
			}
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				return;
			}
			if(f.CmbMostrar.value=='-1')
			{
				alert("Debe Seleccionar Ver Disponibilidad");
				return;
			}
				f.action = "pcip_mantenedor_nuevo_sistema_proceso01.php?Opcion="+Opcion+"&Codigo="+f.TxtCodigo.value+"&sistema="+f.TxtSistema.value+"&descrip="+f.TxtDescrip.value+"&vigente="+f.CmbVig.value+"&CmbMostrar="+f.CmbMostrar.value;
				f.submit();
		        break;
		case "NI":
			   f.action = "pcip_mantenedor_nuevo_sistema_proceso.php?Opc=N";
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
	echo '<body onLoad="document.FrmPopupProceso.TxtSistema.focus();">';
	else
		echo '<body onLoad="document.FrmPopupProceso.TxtSistema.focus();">';
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
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../pcip_web/archivos/sub_tit_sistema_n.png"><? }else{?><img src="../pcip_web/archivos/sub_tit_sistema_m.png"><?	}?></td>
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
           <td width="111" class="formulario2">Codigo</td>
           <td width="382" class="formulariosimple">
		    <input name="TxtCodigo" size="3" maxlength= "4" readonly="" type="text" id="TxtCodigo" value="  <? echo $TxtCodigo; ?>">
           </td>
         </tr>
		 <tr>
           <td width="111" class="formulario2">Sistema</td>
           <td width="382" class="formulariosimple" ><input name="TxtSistema" maxlength= "50" type="text" id="TxtSistema" style="width:350" value="<? echo $TxtSistema; ?>" >
             <span class="InputRojo">(*)</span> </td>
         </tr>
		 <tr>
           <td width="111" class="formulario2">Descripción</td>
           <td width="382" class="formulariosimple" ><input name="TxtDescrip" maxlength= "200" type="text" style="width:350" value="<? echo $TxtDescrip; ?>" >
             <span class="InputRojo">(*)</span> </td>
         </tr>
		 <tr>
           <td width="111" class="formulario2">Vigente</td>
           <td width="382" class="formulariosimple" ><select name="CmbVig" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbVig==$FilaTC["nombre_subclase"])
						echo "<option selected value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
           </select>
             <span class="InputRojo">(*)</span> </td>
         </tr>		 		 
		 <tr>
           <td width="111" class="formulario2">Ver Disponibilidad</td>
           <td width="382" class="formulariosimple" ><select name="CmbMostrar" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbMostrar==$FilaTC["nombre_subclase"])
						echo "<option selected value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
           </select>
             <span class="InputRojo">(*)</span> </td>
         </tr>		 		 
          <tr>
           <td colspan="2" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
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
		echo "alert('Sistema Ingresado Exitosamente');";
	if ($Mensaje==2)
		echo "alert('Sistema Modificado Exitosamente');";
	echo "</script>";
?>