
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
	$Consulta="select * from pcip_svp_asignaciones_productos t1 ";
	$Consulta.=" where t1.cod_producto='".$Valores."' ";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["cod_producto"];
		$CmbAsig=$Fila["cod_asignacion"];
		$TxtProd=$Fila["nom_asignacion"];
		$TxtOrden=$Fila["orden"];
		$CmbVig=$Fila["vigente"];
		$CmbUnidad=$Fila["cod_unidad"];
	}
}	
else
{
	$Consulta="select max(cod_producto+1) as maximo from pcip_svp_asignaciones_productos ";
	$Resp=mysqli_query($link, $Consulta);
	//echo $Consulta,
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["maximo"];
	}
		$CmbAsig='-1';
		$TxtProd='';
		$TxtOrden='';
		$CmbVig='-1';
		$CmbUnidad='-1';	

}
?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nueva Asignacion de Productos PPC</title>";
		else	
			echo "<title>Modificar Asignacion de Productos PPC</title>";
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
				alert("Debe Seleccionar Asiganci�n");
				f.CmbAsig.focus();
				return;
			}			
			if(f.TxtProd.value=='')
			{
				alert("Debe Ingresar Producto");
				f.TxtProd.focus();
				return;
			}
			if(f.TxtOrden.value=='')
			{
				alert("Debe Ingresar N� Orden");
				f.TxtOrden.focus();
				return;
			}	
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}			
				f.action = "pcip_mantenedor_asignaciones_productos_ppc_proceso01.php?Opcion="+Opcion;
				f.submit();
		        break;
		case "M":
			if(f.CmbAsig.value=='-1')
			{
				alert("Debe Seleccionar Asiganci�n");
				f.CmbAsig.focus();
				return;
			}			
			if(f.TxtProd.value=='')
			{
				alert("Debe Ingresar Producto");
				f.TxtProd.focus();
				return;
			}
			if(f.TxtOrden.value=='')
			{
				alert("Debe Ingresar N� Orden");
				f.TxtOrden.focus();
				return;
			}	
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}			
			    f.action = "pcip_mantenedor_asignaciones_productos_ppc_proceso01.php?Opcion="+Opcion;
				f.submit();
        		break;
		case "NI":
				f.action = "pcip_mantenedor_asignaciones_productos_ppc_proceso.php?Opc=N";
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
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="archivos/sub_tit_asignacion_producto_ppc_n.png"><? }else{?><img src="archivos/sub_tit_asignacion_producto_ppc_m.png"><?	}?></td>
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
           <td width="273" class="formulario2">Codigo</td>
           <td width="682" class="formulariosimple"><input name="TxtCodigo" size="5" type="txt" readonly="" value="<? echo $TxtCodigo?>"></td>
         </tr>
	  <tr>
		<td width="16%" height="17" class='formulario2'>Tipo Asignaci&oacute;n </td>
		<td colspan="3" class="formulario2" ><span class="formulariosimple">
		  <select name="CmbAsig" onChange="Proceso('R')">
            <option value="-1" selected="selected">Seleccionar</option>
            <?
			$Consulta = "select cod_asignacion,nom_asignacion from pcip_svp_asignacion where mostrar_ppc='1' order by cod_asignacion ";			
			$Resp=mysqli_query($link, $Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbAsig==$FilaTC["cod_asignacion"])
					echo "<option selected value='".$FilaTC["cod_asignacion"]."'>".ucfirst($FilaTC["nom_asignacion"])."</option>\n";
				else
					echo "<option value='".$FilaTC["cod_asignacion"]."'>".ucfirst($FilaTC["nom_asignacion"])."</option>\n";
			}
		  ?>
          </select>
		</span>	  </tr>
	  <tr>
		<td height="17" class='formulario2'>Productos</td>
		<td colspan="3" class='formulario2'><input name="TxtProd" type="txt" maxlength="90" size="100" value="<? echo $TxtProd?>">
	  </tr>
		 <tr>
           <td class="formulario2">Unidad</td>
		   <td class="formulariosimple" colspan="3">
		   <select name="CmbUnidad">
               <option value="-1">Seleccionar</option>
               <?
				$Consulta="select * from pcip_unidades ";
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					if($Fila["cod_unidad"]==$CmbUnidad)
						echo "<option value='".$Fila["cod_unidad"]."' selected>".$Fila["cod_unidad"]."</option>";
					else
						echo "<option value='".$Fila["cod_unidad"]."'>".$Fila["cod_unidad"]."</option>";					
				}
			?>
             </select>                 
	   </tr>		 
	  <tr>
		<td height="17" class='formulario2'> Orden </td>
		<td colspan="3" class='formulario2'><span class="formulariosimple">
		  <input name="TxtOrden" size="10" maxlength="3" type="txt" onChange="TeclaPulsada(true)" value="<? echo $TxtOrden?>">
		</span></tr>
		 <tr>
           <td width="273" class="formulario2">Vigente</td>
           <td width="682" class="formulariosimple" ><select name="CmbVig" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
				$Resp=mysqli_query($link, $Consulta);
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
	if ($Mensaje==true)
		echo "alert('Este Registro ya Existe');";
	if ($Mensaje1)
		echo "alert('".$Mensaje1."');";
	echo "</script>";
?>