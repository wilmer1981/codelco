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
	$Valores=explode('~',$Cod);
    $Consulta="select t5.nombre_subclase as nom_maquila,t4.nombre_subclase as nom_area,t2.nom_asignacion,t3.nom_producto,t1.num_orden,t1.num_orden_relacionada,t1.cod_material,t1.consumo_interno,t1.vptm,t1.vptipinv";
	$Consulta.=" from pcip_svp_variacion_inventario t1 inner join pcip_svp_asignacion t2 on t1.cod_asignacion=t2.cod_asignacion";
	$Consulta.=" inner join pcip_svp_productos_inventarios t3 on t1.cod_producto=t3.cod_producto";
	$Consulta.=" inner join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31009' and t4.cod_subclase=t1.cod_area";
	$Consulta.=" inner join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='31010' and t5.cod_subclase=t1.cod_area";
	$Consulta.=" where t1.cod_asignacion='".$Valores[0]."' and t1.cod_area='".$Valores[1]."' and t1.cod_maquila='".$Valores[2]."' and t1.cod_producto='".$Valores[3]."'  and num_orden='".$Valores[4]."'";
	//echo $Consulta;
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$Asig=$Fila["nom_asignacion"];
		$Area=$Fila["nom_area"];
		$Maqui=$Fila["nom_maquila"];
		$Prod=$Fila["nom_producto"];
		$NomOrden=$Fila["num_orden"];
		$CmbOrdenRel=$Fila["num_orden_relacionada"];
		$TxtMaterial=$Fila["cod_material"];
		$TxtConsumo=$Fila["consumo_interno"];
		$TxtVPtm=$Fila["vptm"];
		$TxtVPti=$Fila["vptipinv"];
	}
}	

?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nueva Variacion Inventario</title>";
		else	
			echo "<title>Modificar Variacion Inventario</title>";
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
				alert("Debe seleccionar Asignación");
				f.CmbAsig.focus();
				return;
			}			
			if(f.CmbArea.value=='-1')
			{
				alert("Debe Seleccionar Área");
				f.CmbArea.focus();
				return;
			}
			if(f.CmbMaqui.value=='-1')
			{
				alert("Debe Seleccionar Maquila");
				f.CmbMaqui.focus();
				return;
			}	
			if(f.CmbProd.value=='-1')
			{
				alert("Debe Seleccionar Producto");
				f.CmbProd.focus();
				return;
			}			
			if(f.CmbOrden.value=='-1')
			{
				alert("Debe Seleccionar Nº Orden");
				f.CmbOrden.focus();
				return;
			}			
				f.action = "pcip_mantenedor_variaciones_inventarios_proceso01.php?Opcion="+Opcion;
				f.submit();
		        break;
		case "M":
			if(f.CmbOrdenRel.value=='')
			{
				alert("Debe Seleccionar Nº Orden Relacionado");
				f.CmbOrdenRel.focus();
				return;
			}			
			if(f.TxtMaterial.value=='')
			{
				alert("Debe Ingresar Codigo Material");
				f.TxtMaterial.focus();
				return;
			}			
			if(f.TxtConsumo.value=='')
			{
				alert("Debe Ingresar Consumo Interno");
				f.TxtConsumo.focus();
				return;
			}			
			if(f.TxtVPtm.value=='')
			{
				alert("Debe Ingresar VPtm");
				f.TxtVPtm.focus();
				return;
			}						
			if(f.TxtVPti.value=='')
			{
				alert("Debe Ingresar VPti");
				f.TxtVPti.focus();
				return;
			}						
			    f.action = "pcip_mantenedor_variaciones_inventarios_proceso01.php?Opcion="+Opcion;
				f.submit();
        		break;
		case "NI":
				f.action = "pcip_mantenedor_variaciones_inventarios_proceso01.php?Opcion="+Opcion;
				f.submit();
				break;
	}
}
function Recarga()
{
	var f= document.FrmPopupProceso;
	f.action = "pcip_mantenedor_variaciones_inventarios_proceso.php?Opc=N";
	f.submit();
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
		echo '<body onLoad="document.FrmPopupProceso.CmbOrdenRel.focus();">';
?>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<input type="hidden" name="Pagina" value="<? echo $Opc;?>">
<input type="hidden" name="Cod" value="<? echo $Cod;?>">
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
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../pcip_web/archivos/sub_tit_variacion_inventario_n.png"><? }else{?><img src="../pcip_web/archivos/sub_tit_variacion_inventario_m.png"><?	}?></td>
       <td align="right"><a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>  <a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="../pcip_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="0" >
	   <? 
		if ($Opc=='N')
		 {
	   ?>
		<tr>
		<td width="16%" height="17" class='formulario2'>Grupo Asignación</td>
		<td width="84%" class="formulario2" >
		  <select name="CmbGrupo" onChange="Recarga()">
		  <option value="-1" selected="selected">Seleccionar</option>
		  <?
			$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31044'order by cod_subclase ";			
			$Resp=mysql_query($Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbGrupo==$FilaTC["cod_subclase"])
					echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				else
					echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			}
		  ?>
		  </select><span class="InputRojo">(*)</span>
	     </td>      		  
		 </tr> 
		<? 
		  }
		  else 
			echo "<span class='formulario2'>&nbsp;</span>";	
		?>
		 <tr>
           <td width="159" class="formulario2">Asignaci&oacute;n </td>
           <td width="784" colspan="2" class="formulariosimple">
		   <? 
		    if ($Opc=='N')
		     {
		   ?>
				   <select name="CmbAsig">
				  <option value="-1" selected="selected">Seleccionar</option>
				  <?
					$Consulta = "select distinct t1.cod_subclase,t1.nombre_subclase from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.sub_clase t2";
					$Consulta.= " on t1.cod_clase='31045' and t2.cod_subclase=t1.valor_subclase1 where t1.valor_subclase1='".$CmbGrupo."' order by t1.cod_subclase ";			
					$Resp=mysql_query($Consulta);
					while ($FilaTC=mysql_fetch_array($Resp))
					{
						if ($CmbAsig==$FilaTC["cod_subclase"])
							echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
						else
							echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					}
				  ?>
				  </select><? //echo $CmbAsig;?><span class="InputRojo">(*)</span>
			<? 
			  }
			  else 
			    echo "<span class='formulario2'>".$Asig."</span>";	
			?>            </td>
         </tr>
	  <tr>
		<td width="159" height="17" class='formulario2'>&Aacute;rea</td>
		<td class="formulario2" >
		   <? 
		     if ($Opc=='N')
			 {
		   ?>
			   <select name="CmbArea">
			   <option value="-1" class="NoSelec">Seleccionar</option>
			   <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31009' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbArea==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
			  </select><span class="InputRojo">(*)</span>
 		  <?
			 }
			 else
				echo "<span class='formulario2'>".$Area."</span>";	
		  ?>		 </td>
	  </tr>
	  <tr>
		<td height="17" class='formulario2'>Maquila</td>
		<td class='formulario2'>
		   <? 
		     if($Opc=='N')
			 {
		   ?>
			   <select name="CmbMaqui">
			   <option value="-1" class="NoSelec">Seleccionar</option>
			   <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31010' order by cod_subclase";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbMaqui==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
			  </select><span class="InputRojo">(*)</span> 
		  <?
            }
			else
			echo "<span class='formulario2'>".$Maqui."</span>";			  
		  ?>		  </td>  
	  </tr>
	  <tr>
		<td height="17" class='formulario2'> Productos</td>
		<td class='formulario2'>
		   <?
		    if($Opc=='N')
			{
		   ?>
			   <select name="CmbProd">
			   <option value="-1" class="NoSelec">Seleccionar</option>
			   <?
				$Consulta ="select cod_producto,nom_producto from pcip_svp_productos_inventarios";	
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbProd==$FilaTC["cod_producto"])
						echo "<option selected value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nom_producto"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nom_producto"])."</option>\n";
				}
			   ?>
			  </select> <span class="InputRojo">(*)</span>    
          <?
		    }
			else
			echo "<span class='formulario2'>".$Prod."</span>";	
		  ?>		  </td> 
	  </tr>
         <tr>
           <td height="25" class="formulario2">N&ordm; Orden </td>
           <td class="FilaAbeja2">
		   <?
		   if($Opc=='N')
		   {
		   ?>
               <span class="formulario2">
               <select name="CmbOrden" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
					$Consulta = "select * from pcip_svp_ordenesproduccion order by OPorden ";			
					$Resp=mysql_query($Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbOrden==$Fila["OPorden"])
							echo "<option selected value='".$Fila["OPorden"]."'>".$Fila["OPorden"]." ".ucfirst($Fila["OPdescripcion"])."</option>\n";
						else
							echo "<option value='".$Fila["OPorden"]."'>".$Fila["OPorden"]." ".ucfirst($Fila["OPdescripcion"])."</option>\n";
					}
			   ?>
               </select>
               </span>             
		       <span class="InputRojo">(*)</span>
		   <?
		    }
		   	else
				echo "<span class='formulario2'>".$NomOrden."</span>";	
		   ?></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">N&ordm; Orden Relacionada </td>
           <td class="FilaAbeja2"><span class="formulario2">
             <select name="CmbOrdenRel" >
               <option value="-1" class="NoSelec">Ninguna</option>
               <?
				$Consulta = "select * from pcip_svp_ordenesproduccion order by OPorden ";			
				$Resp=mysql_query($Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{
					if ($CmbOrdenRel==$Fila["OPorden"])
						echo "<option selected value='".$Fila["OPorden"]."'>".$Fila["OPorden"]." ".ucfirst($Fila["OPdescripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["OPorden"]."'>".$Fila["OPorden"]." ".ucfirst($Fila["OPdescripcion"])."</option>\n";
				}
			   ?>
             </select>
           </span></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Codigo Material </td>
           <td class="FilaAbeja2"><input type="text" name="TxtMaterial" value="<? echo $TxtMaterial?>" onkeydown='TeclaPulsada(false)' maxlength="4" size="4"></td>
         </tr>
		 <tr>
           <td height="25" class="formulario2">Consumo Interno </td>
           <td class="FilaAbeja2"><input type="text" name="TxtConsumo" value="<? echo $TxtConsumo ;?>" onkeydown='TeclaPulsada(false)' maxlength="6" size="4"></td>
         </tr>		 
		 <tr>
           <td height="25" class="formulario2">VPtm</td>
           <td class="FilaAbeja2"><input type="text" name="TxtVPtm" value="<? echo $TxtVPtm ;?>" onkeydown='TeclaPulsada(false)' maxlength="6" size="4"></td>
         </tr>		 
		 <tr>
           <td height="25" class="formulario2">VPtipinv</td>
           <td class="FilaAbeja2"><input type="text" name="TxtVPti" value="<? echo $TxtVPti ;?>" onkeydown='TeclaPulsada(false)' maxlength="6" size="4"></td>		   		
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