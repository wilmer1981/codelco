
<? include("../principal/conectar_pcip_web.php");
 $Disabled='';
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
    $Datos=explode("~",$Valores);
	$Consulta = "select t1.tipo_contrato,t1.cod_mercado,t1.cod_contrato,t1.rut_proveedor,t2.nom_producto,t1.cod_producto,t1.fecha_contrato,t1.duracion,t1.acuerdo_contractual_cu,t1.acuerdo_contractual_ag,t1.acuerdo_contractual_au,t1.acuerdo_contractual_otro,t1.nom_cliente,t1.vigente";
	$Consulta.= " from pcip_fac_contratos_compra t1 inner join pcip_fac_productos_facturas t2 on t1.cod_producto=t2.cod_producto";
	$Consulta.= " left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31017' and t1.tipo_contrato=t3.cod_subclase";
	$Consulta.= " left join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31008' and t1.cod_mercado=t4.cod_subclase";
	$Consulta.=" where t1.cod_contrato='".$Datos[0]."'";
	//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtContrato=$Fila["cod_contrato"];
		$CmbRutProveedor=$Fila["rut_proveedor"];
		$CmbProducto=$Fila["cod_producto"];
		$CmbTipoContrato=$Fila["tipo_contrato"];
		$CmbMercado=$Fila["cod_mercado"];
		$TxtFechaContrato=$Fila["fecha_contrato"];
		$TxtDuracion=$Fila["duracion"];								
		$CmbAcuerdoCu=$Fila["acuerdo_contractual_cu"];		
		$CmbAcuerdoAg=$Fila["acuerdo_contractual_ag"];		
		$CmbAcuerdoAu=$Fila["acuerdo_contractual_au"];	
		$CmbOtro=$Fila["acuerdo_contractual_otro"];	
		$TxtDescripcion=$Fila["nom_cliente"];	
		$CmbVig=$Fila["vigente"];		
	}
}	
?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nuevo Contrato Facturas</title>";
		else	
			echo "<title>Modifica Contrato Facturas</title>";
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
			if(f.TxtContrato.value=='')
			{
				alert("Debe Ingresar Contrato");
				f.TxtContrato.focus();
				return;
			}
			if(f.CmbRutProveedor.value=='-1')
			{
				alert("Debe Seleccionar un Proveedor");
				f.CmbRutProveedor.focus();
				return;
			}			
			if(f.CmbProducto.value=='-1')
			{
				alert("Debe Seleccionar Producto");
				f.CmbProducto.focus();
				return;
			}
			if(f.CmbTipoContrato.value=='-1')
			{
				alert("Debe Seleccionar Tipo Contrato");
				f.CmbTipoContrato.focus();
				return;
			}
			if(f.CmbMercado.value=='-1')
			{
				alert("Debe Seleccionar Mercado");
				f.CmbMercado.focus();
				return;
			}			
				if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}			
				f.action = "pcip_mantenedor_contratos_compra_facturas_proceso01.php?Opcion="+Opcion;
				f.submit();
		        break;
		case "M":
			if(f.TxtContrato.value=='')
			{
				alert("Debe Ingresar Contrato");
				f.TxtContrato.focus();
				return;
			}
			if(f.CmbRutProveedor.value=='-1')
			{
				alert("Debe Seleccionar un Proveedor");
				f.CmbRutProveedor.focus();
				return;
			}						
			if(f.CmbProducto.value=='-1')
			{
				alert("Debe Seleccionar Producto");
				f.CmbProducto.focus();
				return;
			}
			if(f.CmbTipoContrato.value=='-1')
			{
				alert("Debe Seleccionar Tipo Contrato");
				f.CmbTipoContrato.focus();
				return;
			}
			if(f.CmbMercado.value=='-1')
			{
				alert("Debe Seleccionar Mercado");
				f.CmbMercado.focus();
				return;
			}					
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}	
				f.action = "pcip_mantenedor_contratos_compra_facturas_proceso01.php?Opcion="+Opcion;
				f.submit();
        		break;
		case "NI":
				f.action = "pcip_mantenedor_contratos_compra_facturas_proceso01.php?Opcion="+Opcion;
				f.submit();
				break;
		case "R":	
				f.action = "pcip_mantenedor_contratos_compra_facturas_proceso.php?";
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
	echo '<body onLoad="document.FrmPopupProceso.TxtContrato.focus();">';
	else
		echo '<body onLoad="document.FrmPopupProceso.TxtFechaContrato.focus();">';
?>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<input type="hidden" name="Opc" value="<? echo $Opc;?>">
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
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../pcip_web/archivos/sub_tit_contratos_facturas_n.png"><? }else{?><img src="../pcip_web/archivos/sub_tit_contratos_facturas_m.png"><?	}?></td>
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
           <td width="171" class="formulario2">Contrato</td>
           <td width="214" class="formulariosimple">
		    <?
			  if($Opc=='N')
			   {
			?>
		    <input name="TxtContrato" maxlength= "22"  size="30" type="text" id="TxtContrato" value="<? echo $TxtContrato; ?>">
            <span class="InputRojo">(*)</span>
			<?
			  }else
			   {
			?>
		    <input name="TxtContrato" maxlength= "22" readonly="" size="30" type="text" id="TxtContrato" value="<? echo $TxtContrato; ?>">
		    <span class="InputRojo">(*)</span>
             <?
			   }
			 ?>		   </td>
           <td width="148" class="formulario2">Proveedor</td>
           <td class="formulariosimple" colspan="3">
				  <select name="CmbRutProveedor" onChange="Proceso('R')">
				  <option value="-1" selected="selected">Seleccionar</option>
				  <?
					$Consulta = "select rut_proveedor,nom_proveedor from pcip_fac_proveedores order by nom_proveedor";			
					$Resp=mysqli_query($link, $Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbRutProveedor==$Fila["rut_proveedor"])
							echo "<option selected value='".$Fila["rut_proveedor"]."'>".ucfirst($Fila["rut_proveedor"])." ".strtoupper($Fila["nom_proveedor"])."</option>\n";
						else
							echo "<option value='".$Fila["rut_proveedor"]."'>".ucfirst($Fila["rut_proveedor"])." ".strtoupper($Fila["nom_proveedor"])."</option>\n";
					}	
				  ?>
				  </select>
				  <span class="InputRojo">(*)</span></td>			  
         </tr>
		<tr>	 		 		  				 				  	 
           <td width="171" class="formulario2">Descripci�n Cliente</td>
           <td class="formulariosimple" colspan="6">
		   <input name="TxtDescripcion" maxlength= "48"  size="60" type="text" id="TxtDescripcion" value="<? echo $TxtDescripcion; ?>">
		   </td>
         </tr>		 		 		 
		 <tr>
           <td width="171" class="formulario2">Producto</td>
           <td width="214" class="formulariosimple" >
				   <select name="CmbProducto" >
				   <option value="-1" class="NoSelec">Seleccionar</option>
						   <?
							$Consulta = "select t1.cod_producto,t2.nom_producto from pcip_fac_productos_por_proveedores t1";
							$Consulta.= " inner join pcip_fac_productos_facturas t2 on t1.cod_producto=t2.cod_producto where rut_proveedor='".$CmbRutProveedor."'";			
							$Resp=mysqli_query($link, $Consulta);
							while ($FilaTC=mysql_fetch_array($Resp))
							{
								if ($CmbProducto==$FilaTC["cod_producto"])
									echo "<option selected value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nom_producto"])."</option>\n";
								else
									echo "<option value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nom_producto"])."</option>\n";
							}
						   ?>
				   </select><?  //echo $Consulta; ?>
                  <span class="InputRojo">(*)</span> 
		   </td>			
           <td width="148" class="formulario2">Tipo Contrato</td>
           <td width="163" class="formulariosimple">
				   <select name="CmbTipoContrato" >
				   <option value="-1" class="NoSelec">Seleccionar</option>
					   <?
						$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31017' ";			
						$Resp=mysqli_query($link, $Consulta);
						while ($FilaTC=mysql_fetch_array($Resp))
						{
							if ($CmbTipoContrato==$FilaTC["cod_subclase"])
								echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
							else
								echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
						}
					   ?>
				   </select>
                  <span class="InputRojo">(*)</span> 
		    </td>
           <td width="163" class="formulario2">Mercado</td>
           <td width="154" class="formulariosimple">
				   <select name="CmbMercado" >
				   <option value="-1" class="NoSelec">Seleccionar</option>
					   <?
						$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31008' ";			
						$Resp=mysqli_query($link, $Consulta);
						while ($FilaTC=mysql_fetch_array($Resp))
						{
							if ($CmbMercado==$FilaTC["cod_subclase"])
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
              <td align="left" class="formulario2">Fecha Inicio Contrato </td>
              <td width="214" align="left"  class="formulario2"><input name="TxtFechaContrato" type="text" class="InputCen" value="<? echo $TxtFechaContrato; ?>" size="10" maxlength="10" readonly>&nbsp;&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha"  border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaContrato,TxtFechaContrato,popCal);return false">&nbsp;&nbsp;&nbsp; 			 </td>
              <td width="148" align="left" class="formulario2">Fecha Termino Contrato</td>
              <td align="left"  class="formulario2" colspan="3"><input name="TxtDuracion" type="text" class="InputCen" value="<? echo $TxtDuracion; ?>" size="10" maxlength="10" readonly>&nbsp;&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha"  border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtDuracion,TxtDuracion,popCal);return false">&nbsp;&nbsp;&nbsp; 			 </td>			 		  
		</tr>	
		 <tr>
		  <td width="171" align="left" class="formulario2">Acuerdo Contractual Cu. </td>
		  <td width="214" align="left"  class="formulario2"><select name="CmbAcuerdoCu" >
			   <option value="N" class="NoSelec">Ninguno</option>
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
			   </select></td>	
		  <td width="148" align="left" class="formulario2">Acuerdo Contractual Ag. </td>
		  <td width="163" align="left"  class="formulario2"><select name="CmbAcuerdoAg" >
			   <option value="N" class="NoSelec">Ninguno</option>
			   <?
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
			   </select></td>	
		  <td width="163" align="left" class="formulario2">Acuerdo Contractual Au. </td>
		  <td width="154" align="left"  class="formulario2"><select name="CmbAcuerdoAu">
			   <option value="N" class="NoSelec">Ninguno</option>
			   <?
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
			   </select></td>	
		 </tr>
		<tr>	 		 		  				 				  	 
           <td width="171" class="formulario2">Vigente</td>
           <td class="formulariosimple"><select name="CmbVig" >
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
           <td width="171" class="formulario2">Otros</td>
           <td class="formulariosimple" colspan="6"><select name="CmbOtro" >
               <option value="N" class="NoSelec">Ninguno</option>
			   <?
			   if("-1"==$CmbOtro)
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
				   if($i==$CmbOtro)
						echo "<option value='".$i."' selected>Mes+".$i."</option>";
				   else
						echo "<option value='".$i."'>Mes+".$i."</option>";
				 }
			   ?>
           </select></td>
         </tr>		 		 
          <tr>
           <td colspan="6" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
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
		echo "alert('Contrato Ingresado Exitosamente');";
	if ($Mensaje2==true)
		echo "alert('Contrato Modificado Exitosamente');";
	echo "</script>";
?>