
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
	$Consulta="select * from pcip_svp_asignaciones_titulos t1 ";
	$Consulta.=" where t1.cod_titulo='".$Valores."' ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["cod_titulo"];
		$CmbAsig=$Fila["cod_asignacion"];
		$CmbNeg=$Fila["cod_negocio"];
		$TxtTit=$Fila["nom_titulo"];
		$TxtOrden=$Fila["orden"];
		$CmbGrupo=$Fila["grupo"];
		$CmbVig=$Fila["vigente"];
		$CmbMostrarAsig=$Fila["mostrar_asig"];
		$CmbMostrarPpc=$Fila["mostrar_ppc"];	
	}
}	
else
{
if(!isset($CmbVig))
      $CmbVig='1';
	  
	$Consulta="select max(cod_titulo+1) as maximo from pcip_svp_asignaciones_titulos ";
	$Resp=mysql_query($Consulta);
	//echo $Consulta,
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["maximo"];
	}
		$CmbAsig='-1';
		$CmbNeg='-1';
		$TxtTit='';
		$TxtOrden='';

}
?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nueva Asignacion Titulos</title>";
		else	
			echo "<title>Modificar Asignacion Titulos</title>";
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
			if(f.CmbAsig.value=='-1')
			{
				alert("Debe Seleccionar Asignación");
				f.CmbAsig.focus();
				return;
			}
			if(f.CmbNeg.value=='-1')
			{
				alert("Debe Seleccionar Negocio");
				f.CmbNeg.focus();
				return;
			}	
			if(f.TxtTit.value=='')
			{
				alert("Debe Ingresar Titulo");
				f.TxtTit.focus();
				return;
			}						
			if(f.TxtOrden.value=='')
			{
				alert("Debe Ingresar Nº Orden");
				f.TxtOrden.focus();
				return;
			}			
			if(f.CmbGrupo.value=='-1')
			{
				alert("Debe Seleccionar Grupo");
				f.CmbGrupo.focus();
				return;
			}			
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}			
				f.action = "pcip_mantenedor_asignaciones_titulos_proceso01.php?Opcion="+Opcion+"&Codigo="+f.TxtCodigo.value+"&asig="+f.CmbAsig.value+"&Negocio="+f.CmbNeg.value+"&Titulo="+f.TxtTit.value+"&Orden="+f.TxtOrden.value+"&vigente="+f.CmbVig.value;
				f.submit();
		        break;
		case "M":		
			if(f.CmbAsig.value=='-1')
			{
				alert("Debe Seleccionar Asignación");
				f.CmbAsig.focus();
				return;
			}
			if(f.CmbNeg.value=='-1')
			{
				alert("Debe Seleccionar Negocio");
				f.CmbNeg.focus();
				return;
			}	
			if(f.TxtTit.value=='')
			{
				alert("Debe Ingresar Titulo");
				f.TxtTit.focus();
				return;
			}						
			if(f.TxtOrden.value=='')
			{
				alert("Debe Ingresar Nº Orden");
				f.TxtOrden.focus();
				return;
			}			
			if(f.CmbGrupo.value=='-1')
			{
				alert("Debe Seleccionar Grupo");
				f.CmbGrupo.focus();
				return;
			}			
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}			
			    f.action = "pcip_mantenedor_asignaciones_titulos_proceso01.php?Opcion="+Opcion+"&Codigo="+f.TxtCodigo.value+"&asig="+f.CmbAsig.value+"&Negocio="+f.CmbNeg.value+"&Titulo="+f.TxtTit.value+"&Orden="+f.TxtOrden.value+"&vigente="+f.CmbVig.value
				f.submit();
        		break;
		case "NI":
				f.action = "pcip_mantenedor_asignaciones_titulos_proceso.php?Opc=N";
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
	echo '<body onLoad="document.FrmPopupProceso.CmbAsig.focus();">';
	else
		echo '<body onLoad="document.FrmPopupProceso.CmbAsig.focus();">';
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
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../pcip_web/archivos/sub_tit_asignacion_titulos_n.png"><? }else{?><img src="../pcip_web/archivos/sub_tit_asignacion_titulos_m.png"><?	}?></td>
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
           <td width="247" class="formulario2">Codigo Titulo</td>
           <td class="formulariosimple" colspan="3">
		    <input name="TxtCodigo"  readonly="" size="10" type="text" id="TxtCodigo" value="<? echo $TxtCodigo; ?>">
            </td>
         </tr>
	     <tr>
           <td width="247" class="formulario2">Tipo Asignaci&oacute;n</td>
           <td class="formulariosimple" colspan="3">
		    <select name="CmbAsig" onChange="Proceso('R')">
			  <option value="-1" selected="selected">Seleccionar</option>
			  <?
				$Consulta = "select cod_asignacion,nom_asignacion from pcip_svp_asignacion order by cod_asignacion ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbAsig==$FilaTC["cod_asignacion"])
						echo "<option selected value='".$FilaTC["cod_asignacion"]."'>".ucfirst($FilaTC["nom_asignacion"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_asignacion"]."'>".ucfirst($FilaTC["nom_asignacion"])."</option>\n";
				}
					?>
			</select>
            <span class="InputRojo">(*)</span></td>
         </tr>
      <tr>
    	<td width="247" height="17" class='formulario2'>Negocios</td>
    	<td colspan="3" class="formulario2" ><select name="CmbNeg" onChange="Proceso('R2')">
			  <option value="-1" selected="selected">Seleccionar</option>
			  <?
				$Consulta = "select cod_negocio,nom_negocio from pcip_svp_negocios order by cod_negocio";
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbNeg==$FilaTC["cod_negocio"])
						echo "<option selected value='".$FilaTC["cod_negocio"]."'>".ucfirst($FilaTC["nom_negocio"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_negocio"]."'>".ucfirst($FilaTC["nom_negocio"])."</option>\n";
				}
		      ?>
			</select><span class="InputRojo">(*)</span></td>
	   </tr>
	     <tr>
           <td width="247" class="formulario2">Nombre Titulo</td>
           <td class="formulariosimple" colspan="3">
		      <input name="TxtTit" size="100" maxlength="100"  type="text" id="TxtTit" value="<? echo $TxtTit; ?>">
            <span class="InputRojo">(*)</span></td>
         </tr>		   	 		 
	     <tr>
           <td width="247" class="formulario2">Orden</td>
           <td class="formulariosimple" colspan="3">
		    <input name="TxtOrden" onkeydown='TeclaPulsada(false)' maxlength="2" size="10" type="text" id="TxtOrden" value="<? echo $TxtOrden; ?>">
            <span class="InputRojo">(*)</span>
			</td>
         </tr>		 	 
		 <tr>
           <td width="247" class="formulario2">Grupos</td>
           <td class="formulariosimple" colspan="3"><select name="CmbGrupo" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31042' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbGrupo==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
           </select><? //echo $CmbVig;?>
             <span class="InputRojo">(*)</span> </td>
         </tr>		 		 
		 <tr>
           <td width="247" class="formulario2">Vigente</td>
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
           </select><? //echo $CmbVig;?>
             <span class="InputRojo">(*)</span> </td>
         </tr>		 		 
		 <tr>
           <td width="247" class="formulario2">Mostrar Asig.</td>
           <td width="146" class="formulariosimple" >
		   <select name="CmbMostrarAsig" >
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbMostrarAsig==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
           </select><? //echo $CmbVig;?>
             </td>
           <td width="115" class="formulario2">Mostrar Ppc</td>
           <td width="532" class="formulariosimple" >
		   <select name="CmbMostrarPpc" >
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbMostrarPpc==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
           </select><? //echo $CmbVig;?>
             </td>
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
	if ($Mensaje=='1')
		echo "alert('Título (s) Ingresado (s) Exitosamente');";
	if ($Mensaje=='2')
		echo "alert('Título (s) Modificado (s) Exitosamente');";
	echo "</script>";
?>