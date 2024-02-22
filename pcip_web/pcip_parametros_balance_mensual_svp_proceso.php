<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

if(!isset($Recarga))
{
	if ($Opcion=='M')
	{
		$Cod=explode('~',$Codigos);
		$Consulta="select t1.ordes,t1.num_orden,t1.num_orden_relacionada,t1.tramo,t1.tipo_inventario,t1.cod_material,t2.OPdescripcion,t8.OPdescripcion as OPdescripcion2,t7.nombre_subclase as nom_etapa,t3.nombre_subclase as nom_negocio,";
		$Consulta.="t4.nom_producto_etapa,t5.nombre_subclase as nom_tipo_informe,t6.nombre_subclase as nom_tipo_balance from pcip_svp_balance_mensual t1 ";
		$Consulta.="inner join pcip_svp_ordenesproduccion t2 on t1.num_orden=t2.OPorden ";
		$Consulta.="left join pcip_svp_ordenesproduccion t8 on t1.num_orden=t8.OPorden ";
		$Consulta.="inner join proyecto_modernizacion.sub_clase t7 on t7.cod_clase='31004' and t1.cod_tipo_negocio=t7.cod_subclase  ";
		$Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31005' and t1.cod_tipo_negocio=t3.cod_subclase  ";
		$Consulta.="inner join pcip_svp_productos_etapas t4 on t1.cod_producto_etapa=t4.cod_producto_etapa ";
		$Consulta.="inner join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='31002' and t1.cod_tipo_informe=t5.cod_subclase ";
		$Consulta.="inner join proyecto_modernizacion.sub_clase t6 on t6.cod_clase='31003' and t1.cod_tipo_balance=t6.cod_subclase ";
		$Consulta.="where t1.cod_etapa = '".$Cod[0]."' and t1.cod_tipo_negocio='".$Cod[1]."' and t1.cod_producto_etapa='".$Cod[2]."' and t1.cod_tipo_informe='".$Cod[3]."' and t1.cod_tipo_balance='".$Cod[4]."' and t1.num_orden='".$Cod[5]."' and t1.tipo_inventario='".$Cod[6]."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($FilaBal=mysql_fetch_array($Resp))
		{
			$CmbEtapa=$FilaBal[nom_etapa];
			$CmbTipoNegocio=$FilaBal[nom_negocio];
			$CmbProd=$FilaBal[nom_producto_etapa];
			$CmbTipoInforme=$FilaBal[nom_tipo_informe];
			$CmbTipoBalance=$FilaBal[nom_tipo_balance];
			$CmbOrdenProd=$FilaBal[num_orden]."  ".$FilaBal[OPdescripcion];
			$CmbOrdenRel=$FilaBal[num_orden_relacionada];
			$TxtTr=$FilaBal[tramo];
			$TxtTipoInv=$FilaBal[tipo_inventario];
			$TxtMaterial=$FilaBal[cod_material];
			$TxtOrdes=$FilaBal[ordes];
		}	
	}
	else
	{
		$TxtTr="";
		$TxtTipoInv="";
		$TxtMaterial="";	
	}
}	
?>
<html>
<head>
<?
	if ($Opcion=='N')
		echo "<title>Nuevo Parametro Balance Mensual SVP</title>";
	else	
		echo "<title>Modifica Parametro Balance Mensual SVP</title>";
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
	var Adm="";
	var Check="";
	var i="";
	var Valores="";
	
	switch(Opcion)
	{	
		case "N":
			f.Opcion.value=Opcion;
			Veri=ValidaCampos();
			if (Veri==true)
			{
				f.action = "pcip_parametros_balance_mensual_svp_proceso01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			f.action = "pcip_parametros_balance_mensual_svp_proceso01.php?Opcion="+Opcion;
			f.submit();
		break;
		case "NI":
			f.Opcion.value='N';
			f.action = "pcip_parametros_balance_mensual_svp_proceso.php?Opcion=N";
			f.submit();
		break;

		case "R":	
			f.action = "pcip_parametros_balance_mensual_svp_proceso.php?Recarga=S";
			f.submit();
		break;
	}
}
function Salir()
{
	window.close();
}
function TeclaPulsada(tecla) 
{ 
	var Frm=document.FrmPopupProceso;
	var teclaCodigo = event.keyCode; 

		if(teclaCodigo != 189)
		{
			if ((teclaCodigo != 37)&&(teclaCodigo != 39))
			{
				if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
				{
				   if ((teclaCodigo < 96) || (teclaCodigo > 105))
				   {
						event.keyCode=46;
				   }		
				}   
			}
		}		
} 
function ValidaCampos()
{
	var f= document.FrmPopupProceso;
	var Res=true;

	/*if(f.CmbGrupoSuministro.value=='-1')
	{
		alert("Debe seleccionar Grupo Suministro");
		f.CmbGrupoSuministro.focus();
		Res=false;
		return;
	}
	if(f.CmbSuministro.value=='-1')
	{
		alert("Debe seleccionar Suministro");
		f.CmbSuministro.focus();
		Res=false;
		return;
	}
	if(f.CmbCC.value=='-1')
	{
		alert("Debe seleccionar Centro de Costo");
		f.CmbCC.focus();
		Res=false;
		return;
	}
	if(f.CmbTipo.value=='-1')
	{
		alert("Debe seleccionar Tipo");
		f.CmbTipo.focus();
		Res=false;
		return;
	}*/

	return(Res);

}
</script>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #F9F9F9;
}
-->
</style></head>

<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="">
  <input type="hidden" name="Opcion" value="<? echo $Opcion;?>">
 <input name="Form" type="hidden" value="<? echo $Form; ?>">
<input name="Pagina" type="hidden" value="<? echo $Pagina; ?>">
<input name="Codigos" type="hidden" value="<? echo $Codigos; ?>">

  <table align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="955" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2x.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_parametro_balance_n.png" width="450" height="40"><? }else{?><img src="archivos/sub_tit_parametro_balance_m.png" width="450" height="40"><? }?></td>
       <td align="right">
	   <a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
	   <a href="JavaScript:Proceso('<? echo $Opcion;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="ColorTabla02" >
         <tr>
           <td height="33" class="formulario2">Negocio</td>
           <td class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbTipoNegocio" >
             <option value="-1" selected="selected">Seleccionar</option>
             <?
	    $Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31005' order by cod_subclase ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoNegocio==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
		?>
           </select>
		   </span><span class="InputRojo">(*)</span>		   <?
		   }
		   else
		   		echo "<span class='formulario2'>".$CmbTipoNegocio."</span>";	
		   ?>		   </td>
           </tr>

         <tr>
           <td width="180" class="formulario2">Etapa</td>
           <td class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbEtapa">
             <option value="-1" selected="selected">Seleccionar</option>
             <?
	    $Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31004' order by cod_subclase ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEtapa==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
           </select>
		   </span><span class="InputRojo">(*)</span>
		   <?
		   }
		   else
		   		echo "<span class='formulario2'>".$CmbEtapa."</span>";	
		   ?>		   </td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Tipo Informe </td><!---->
           <td class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbTipoInforme" onChange="Proceso('R')" >
             <option value="-1" selected="selected">Seleccionar</option>
             <?
	    $Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31002' order by cod_subclase ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoInforme==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
           </select>
		   </span><span class="InputRojo">(*)</span>		   <?
		    }
		   	else
				echo "<span class='formulario2'>".$CmbTipoInforme."</span>";	
		   ?>		   </td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Tipo Balance </td>
           <td class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbTipoBalance">
             <option value="-1" selected="selected">Seleccionar</option>
             <?
	    $Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31003' order by cod_subclase ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoBalance==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
           </select>
		   </span><span class="InputRojo">(*)</span>		   <?
		    }
		   	else
				echo "<span class='formulario2'>".$CmbTipoBalance."</span>";	
		   ?>		   </td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Producto </td>
           <td class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbProd" >
             <option value="-1" selected="selected">Seleccionar</option>
             <?
	    $Consulta = "select * from pcip_svp_productos_etapas ";
		if($CmbTipoInforme!='-1')
			$Consulta.= "where cod_tipo_balance='".$CmbTipoInforme."' ";
		$Consulta.= "order by cod_producto_etapa ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbProd==$FilaTC["cod_producto_etapa"])
				echo "<option selected value='".$FilaTC["cod_producto_etapa"]."'>".ucfirst($FilaTC["nom_producto_etapa"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_producto_etapa"]."'>".ucfirst($FilaTC["nom_producto_etapa"])."</option>\n";
		}
			?>
           </select>
		   </span><span class="InputRojo">(*)</span>		   <?
		    }
		   	else
				echo "<span class='formulario2'>".$CmbProd."</span>";	
		   ?>		   </td>
         </tr>		 
         <tr>
           <td height="25" class="formulario2">Orden de Producci&oacute;n </td>
           <td class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbOrdenProd">
             <option value="-1" selected="selected">Seleccionar</option>
             <?
		    $Consulta = "select OPorden,OPdescripcion from pcip_svp_ordenesproduccion order by OPorden ";			
			$Resp=mysql_query($Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbOrdenProd==$FilaTC["OPorden"])
					echo "<option selected value='".$FilaTC["OPorden"]."'>".$FilaTC["OPorden"]."&nbsp;&nbsp;".ucfirst($FilaTC["OPdescripcion"])."</option>\n";
				else
					echo "<option value='".$FilaTC["OPorden"]."'>".$FilaTC["OPorden"]."&nbsp;&nbsp;".ucfirst($FilaTC["OPdescripcion"])."</option>\n";
			}
			?>
           </select>
		   </span><span class="InputRojo">(*)</span>		   <?
		    }
		   	else
				echo "<span class='formulario2'>".$CmbOrdenProd."</span>";	
		   ?>		   </td>
         </tr>
         <tr>
           <td height="25" class="formulario2">N&ordm; Orden Relacionada </td>
           <td colspan="3" class="FilaAbeja2"><span class="formulario2">
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
           <td height="25" class="formulario2">Tramo</td>
           <td class="FilaAbeja2">
		   <input name="TxtTr" type="text" maxlength="2" size="2"  class="InputIzq" value="<? echo  $TxtTr; ?>" onKeyDown="TeclaPulsada(false)">
		   <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Tipo Inventario </td>
           <td class="FilaAbeja2">
		   <input name="TxtTipoInv" type="text" maxlength="2" size="2"  class="InputIzq" value="<? echo  $TxtTipoInv; ?>" onKeyDown="TeclaPulsada(false)">
		   <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Material</td>
           <td class="FilaAbeja2">
		   <input name="TxtMaterial" type="text" maxlength="5" size="6"  class="InputIzq" value="<? echo $TxtMaterial; ?>" onKeyDown="TeclaPulsada(false)">
		   <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Ordes</td>
           <td class="FilaAbeja2">
		   <input name="TxtOrdes" type="text" maxlength="8" size="6"  class="InputIzq" value="<? echo $TxtOrdes; ?>">
		   <span class="InputRojo">(*)</span></td>
         </tr>

         <tr>
           <td colspan="2" class='formulario2'>&nbsp;</td>
         </tr>
		 
         <tr>
           <td height="14" colspan="2" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
         </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   <br></td>
   <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>
</form>		
<? 
echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Sumistro Ingresado Correctamente');";
	echo "</script>";
?>
</body>
</html>
