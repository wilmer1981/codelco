
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
	$Consulta="select * from pcip_svp_productos_inventarios t1 ";
	$Consulta.=" where t1.cod_producto='".$Valores."' ";
	//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["cod_producto"];
		$TxtProducto=$Fila["nom_producto"];
		$CmbVig=$Fila["vigente"];		
	}
}
else
{
	$Consulta="select max(cod_producto+1) as maximo from pcip_svp_productos_inventarios ";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["maximo"];
	}
	$TxtProducto='';
	$CmbVig='-1';
}
?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nuevo Producto</title>";
		else	
			echo "<title>Modifica Producto</title>";
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
			if(f.TxtProducto.value=='')
			{
				alert("Debe Ingresar Producto");
				f.TxtProducto.focus();
				return;
			}
				if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}			
				f.action = "pcip_mantenedor_variaciones_inventarios_productos_proceso01.php?Opcion="+Opcion+"&Codigo="+f.TxtCodigo.value+"&Produc="+f.TxtProducto.value+"&Vigente="+f.CmbVig.value
				f.submit();
		        break;
		case "M":
			if(f.TxtProducto.value=='')
			{
				alert("Debe Ingresar Producto");
				f.TxtProducto.focus();
				return;
			}
				if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}			
				f.action = "pcip_mantenedor_variaciones_inventarios_productos_proceso01.php?Opcion="+Opcion+"&Codigo="+f.TxtCodigo.value+"&Produc="+f.TxtProducto.value+"&Vigente="+f.CmbVig.value;
				f.submit();
        		break;
		case "NI":
				f.action = "pcip_mantenedor_variaciones_inventarios_productos_proceso01.php?Opcion="+Opcion;
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
	echo '<body onLoad="document.FrmPopupProceso.TxtProducto.focus();">';
	else
		echo '<body onLoad="document.FrmPopupProceso.TxtProducto.focus();">';
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
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../pcip_web/archivos/sub_tit_productos_inventarios_n.png"><? }else{?><img src="../pcip_web/archivos/sub_tit_productos_inventarios_m.png"><?	}?></td>
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
           <td width="106" class="formulario2">Codigo</td>
           <td class="formulariosimple" colspan="3">
		   <?
		    if($Opc=='N')
			{
		   ?>
		    <input name="TxtCodigo" maxlength= "4" onkeydown='TeclaPulsada(false)' size="10" type="text" id="TxtCodigo" value="<? echo $TxtCodigo; ?>">
            <span class="InputRojo">(*)</span>
			<?
			 }
			 else
			 {
			   echo $TxtCodigo;
			   echo"<input type='hidden' name='TxtCodigo' value='".$TxtCodigo."'>";
			 } 
			?></td>
         </tr>
	     <tr>
           <td width="106" class="formulario2">Producto</td>
           <td width="371" class="formulariosimple">
		    <input name="TxtProducto" maxlength= "80" size="60" type="text" id="TxtProducto" value="<? echo $TxtProducto; ?>">
            <span class="InputRojo">(*)</span>
		   </td>
		 </tr>          		 
		 <tr>
           <td width="106" class="formulario2">Vigente</td>
           <td class="formulariosimple" colspan="3"><select name="CmbVig" >
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
	if ($MensajeExiste==true)
		echo "alert('Este Registro ya Existe');";
	if ($Mensaje1==true)
		echo "alert('Registro Modificado Exitosamente');";
	if ($Mensaje2==true)
		echo "alert('Registro Ingresado Exitosamente');";		
		
	echo "</script>";
?>