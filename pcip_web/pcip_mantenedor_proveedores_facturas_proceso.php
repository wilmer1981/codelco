
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
	$Consulta="select * from pcip_fac_proveedores t1 ";
	$Consulta.=" where t1.rut_proveedor='".$Valores."' ";
	//echo $Consulta;
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtRut=$Fila["rut_proveedor"];
		$TxtProveedor=$Fila["nom_proveedor"];
		$CmbVig=$Fila["vigente"];		
	}
	else
	{
		$TxtRut='';
		$TxtProveedor='';
        $CmbVig='-1';		
	}
}
?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nuevo Proveedores Clientes</title>";
		else	
			echo "<title>Modifica Proveedores Clientes</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">


function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
    var Validado=true;
	var Valida=true;
	var Veri="";
	var Check="";
	switch(Opcion)
	{
		case "N":
			if(f.TxtRut.value == '')
			{
				alert("Debe Ingresar Rut");
				f.TxtRut.focus();
				Validado=false;
				return;
			}
			valor= new Object(document.FrmPopupProceso.TxtRut.value);
			foco = new Object(document.FrmPopupProceso.TxtRut.focus());
			var bandera = Rut(document.FrmPopupProceso.TxtRut.value,'Rut Persona', foco, valor);
			if(bandera == false)
			{
				Validado=false;
				return;
				
			}
			if(f.TxtProveedor.value=='')
			{
				alert("Debe Ingresar Nombre Proveedor");
				f.TxtProveedor.focus();
				return;
			}			
				if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}	
				f.action = "pcip_mantenedor_proveedores_facturas_proceso01.php?Opcion="+Opcion+"&Rut="+f.TxtRut.value+"&Provee="+f.TxtProveedor.value+"&Vigente="+f.CmbVig.value;
				f.submit();
		        break;
		case "M":
			if(f.TxtRut.value=='')
			{
				alert("Debe Ingresar Rut Proveedor");
				f.TxtRut.focus();
				return;
			}
			if(f.TxtProveedor.value=='')
			{
				alert("Debe Ingresar Nombre Proveedor");
				f.TxtProveedor.focus();
				return;
			}			
				if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}			
				f.action = "pcip_mantenedor_proveedores_facturas_proceso01.php?Opcion="+Opcion+"&Rut="+f.TxtRut.value+"&Provee="+f.TxtProveedor.value+"&Vigente="+f.CmbVig.value;
				f.submit();
        		break;
		case "NI":
				f.action = "pcip_mantenedor_proveedores_facturas_proceso01.php?Opcion="+Opcion;
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
	echo '<body onLoad="document.FrmPopupProceso.TxtRut.focus();">';
	else
		echo '<body onLoad="document.FrmPopupProceso.TxtRut.focus();">';
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
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../pcip_web/archivos/sub_tit_proveedores_clientes_n.png"><? }else{?><img src="../pcip_web/archivos/sub_tit_proveedores_clientes_m.png"><?	}?></td>
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
           <td width="111" class="formulario2">Rut Proveedor</td>
           <td width="382" class="formulariosimple">
		    <input name="TxtRut" maxlength= "10" size="10" type="text" id="TxtRut" value="<? echo $TxtRut; ?>">  (Ej.13009321-5)
		    <span class="InputRojo">(*)</span></td>
         </tr>
	     <tr>
           <td width="111" class="formulario2">Nombre Proveedor</td>
           <td width="382" class="formulariosimple">
		    <input name="TxtProveedor" maxlength= "80" size="80" type="text" id="TxtProveedor" value="<? echo $TxtProveedor; ?>">
            <span class="InputRojo">(*)</span></td>
         </tr>
		 <tr>
           <td width="111" class="formulario2">Vigente</td>
           <td width="382" class="formulariosimple" ><select name="CmbVig">
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
	if ($Mensaje1==true)
		echo "alert('Proveedor Ingresado Exitosamente');";
	if ($Mensaje2==true)
		echo "alert('Proveedor Modificado Exitosamente');";
	echo "</script>";
?>