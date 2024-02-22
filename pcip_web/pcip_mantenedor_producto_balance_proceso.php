
<? include("../principal/conectar_pcip_web.php");
if($Opc=='M') 
{	
 $Disabled='disabled';
}

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
	$Consulta="select * from pcip_svp_productos_etapas t1 ";
	$Consulta.=" where t1.cod_producto_etapa='".$Valores."' ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["cod_producto_etapa"];
		$TxtProducto=$Fila["nom_producto_etapa"];
		$CmbTipo=$Fila["cod_tipo_balance"];
		$CmbVig=$Fila["vigente"];
	}
}
else
{
	$Consulta="select max(cod_producto_etapa+1) as maximo from pcip_svp_productos_etapas ";
	$Resp=mysql_query($Consulta);
	//echo $Consulta;
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["maximo"];
	}
	$TxtProducto='';
	$CmbTipo='-1';
	$CmbVig='-1';
	
}

?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nuevo Producto Balance</title>";
		else	
			echo "<title>Modifica Producto Balance</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
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
			Veri=ValidaCampos(Valida,Opcion);
			if (Veri==true)
			{
				f.action = "pcip_mantenedor_producto_balance_proceso01.php?Opcion="+ Opcion+"&Codigo="+f.TxtCodigo.value+"&produc="+f.TxtProducto.value+"&balance="+f.CmbTipo.value+"&vigente="+f.CmbVig.value;
				f.submit();
			}
		break;
		case "M":
			Veri=ValidaCampos(Valida,Opcion);
			if (Veri==true)
			{
				f.action = "pcip_mantenedor_producto_balance_proceso01.php?Opcion="+ Opcion+"&Codigo="+f.TxtCodigo.value+"&produc="+f.TxtProducto.value+"&balance="+f.CmbTipo.value+"&vigente="+f.CmbVig;
				f.submit();
			}
		break;
		case "NI":
			f.action = "pcip_mantenedor_producto_balance_proceso.php?Opc=N";
			f.submit();
		    break;			
	}
}
function Salir()
{
	window.close();
}
function ValidaCampos(Res,Opcion)
{
	var f= document.FrmPopupProceso;
	if (f.TxtProducto.value=="")
	{
		alert("Debe Ingresar Producto");
		f.TxtProducto.focus();
		Res=false;
		return;
	}
	if(f.CmbTipo.value=='-1')
	{
		alert("Debe Seleccionar Tipo balance");
		f.CmbTipo.focus();
		Res=false;
		return;
	}
	if(f.CmbVig.value=='-1')
	{
		alert("Debe Seleccionar Vigencia");
		f.CmbVig.focus();
		Res=false;
		return;
	}
	return(Res);
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
<input type="hidden" name="Volver" value="<? echo $Volver;?>">
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
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../pcip_web/archivos/sub_tit_producto_balance_n.png"><? }else{?><img src="../pcip_web/archivos/sub_tit_producto_balance_m.png"><?	}?></td>
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
           <td width="111" class="formulario2">Codigo Producto</td>
           <td width="382" class="formulariosimple">
		    <input name="TxtCodigo" maxlength= "4" readonly="" size="5" type="text" id="TxtCodigo" value="<? echo $TxtCodigo; ?>">
           </td>
         </tr>
        
		 <tr>
           <td width="111" class="formulario2">Producto</td>
           <td width="382" class="formulariosimple" ><input name="TxtProducto" maxlength= "50" type="text" id="TxtProducto" style="width:350" value="<? echo $TxtProducto; ?>" >
             <span class="InputRojo">(*)</span> </td>
         </tr>
		 <tr>
           <td width="111" class="formulario2">Tipo Balance</td>
           <td width="382" class="formulariosimple"><select name="CmbTipo" onChange="Proceso('R')">
			  <option value="-1" selected="selected">Seleccionar</option>
			  <?
			  $Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='31002' order by nombre_subclase ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbTipo==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".$FilaTC["nombre_subclase"]."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".$FilaTC["nombre_subclase"]."</option>\n";
				}
			  ?>
			  </select>
             <span class="InputRojo">(*)</span>		  </td>		   		   
         </tr>			 		 
         <tr>
           <td class="formulario2">Vigente</td>
           <td class="formulariosimple" ><select name="CmbVig" >
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
           <span class="InputRojo">(*)</span>
		   </td>
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
	echo "</script>";
?>