<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
if(!isset($Ano))
 	$Ano=date('Y');

if(!isset($Recarga))
{
	if ($Opcion=='M')
	{
		$Cod=explode('~',$Codigos);
		$Consulta="select t1.origen,t6.nom_titulo as nom_titulo,t1.cod_titulo,t1.vptm,t1.orden,t1.cod_asignacion,t1.cod_procedencia,t1.cod_negocio,t1.num_orden,";
		$Consulta.="t1.num_orden_relacionada,t1.cod_material,t1.consumo_interno,t2.nom_asignacion as prod,t3.nom_asignacion,t4.nom_negocio,t5.OPdescripcion as nom_orden ";
		$Consulta.="from pcip_svp_productos_procedencias t1 inner join pcip_svp_asignaciones_productos t2 on t1.cod_procedencia=t2.cod_producto inner join pcip_svp_asignacion t3 on t1.cod_asignacion=t3.cod_asignacion ";
		$Consulta.="inner join pcip_svp_negocios t4 on t1.cod_negocio=t4.cod_negocio ";
		$Consulta.="left join pcip_svp_ordenesproduccion t5 on t1.num_orden=t5.OPorden ";
		$Consulta.="inner join pcip_svp_asignaciones_titulos t6 on t6.cod_titulo=t1.cod_titulo ";
		$Consulta.="where t1.cod_asignacion='".$Cod[0]."' and t1.cod_procedencia='".$Cod[1]."' and t1.cod_negocio='".$Cod[2]."' and t1.num_orden='".$Cod[3]."'";
		if($Cod[4]=='SVP')
		 	$Consulta.="and t1.num_orden_relacionada='".$Cod[4]."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);
		$CmbProd=$Fila[cod_asignacion];
		$CmbAsig=$Fila[cod_procedencia];
		$CmbNegocio=$Fila[cod_negocio];
		$CmbTitulo=$Fila[cod_titulo];
		$CmbOrden=$Fila[num_orden];
		$CmbOrdenRel=$Fila[num_orden_relacionada];
		$TxtMaterial=$Fila[cod_material];
		$TxtConsumo=$Fila[consumo_interno];
		$NomAsig=$Fila[nom_asignacion];
		$NomProd=$Fila[prod];
		$NomNegocio=$Fila[nom_negocio];
		$NomTitulo=$Fila[nom_titulo];
		$NomOrden=$Fila[num_orden]."&nbsp;&nbsp;&nbsp;".$Fila[nom_orden];
		$TxtMaterial=$Fila[cod_material];
		$TxtConsumo=$Fila[consumo_interno];
		$TxtVPtm=$Fila[vptm];
		$TxtOrden=$Fila[orden];
		$NomOrigen=$Fila[origen];
		$CmbOrigenDatos=$Fila[origen];
		$EstOrden='readonly';

	}
	else
	{
		$TxtOrdenRel='';
		$TxtMaterial='';
		$TxtConsumo='';
		if(!isset($CmbOrigenDatos))
			$CmbOrigenDatos='SVP';
	}
}	
?>
<html>
<head>
<?
	if ($Opcion=='N')
		echo "<title>Nueva Asignación PPC</title>";
	else	
		echo "<title>Modifica Asignación PPC</title>";
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
				f.action = "pcip_mantenedor_asignaciones_ppc_proceso01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			f.action = "pcip_mantenedor_asignaciones_ppc_proceso01.php?Opcion="+Opcion;
			f.submit();
		break;
		case "NI":
			f.Opcion.value='N';
			f.action = "pcip_mantenedor_asignaciones_ppc_proceso.php?Opcion=N";
			f.submit();
		break;

		case "R":	
			f.action = "pcip_mantenedor_asignaciones_ppc_proceso.php?Recarga=S";
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

	if(f.CmbProd.value=='-1')
	{
		alert("Debe seleccionar Asignación");
		f.CmbProd.focus();
		Res=false;
		return;
	}
	if(f.CmbAsig.value=='-1')
	{
		alert("Debe seleccionar Producto");
		f.CmbAsig.focus();
		Res=false;
		return;
	}
	if(f.CmbNegocio.value=='-1')
	{
		alert("Debe seleccionar Negocio");
		f.CmbNegocio.focus();
		Res=false;
		return;
	}
	if(f.CmbTitulo.value=='-1')
	{
		alert("Debe seleccionar Titulo");
		f.CmbTitulo.focus();
		Res=false;
		return;
	}

	if(f.CmbOrden.value=='-1')
	{
		alert("Debe seleccionar Numero de Orden");
		f.CmbOrden.focus();
		Res=false;
		return;
	}

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
<form name="FrmPopupProceso" method="post" action="" >
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
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_asignacion_ppc_n.png" width="450" height="40"><? }else{?><img src="archivos/sub_tit_asignacion_ppc_m.png" width="450" height="40"><? }?></td>
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
           <td width="180" class="formulario2">Asignacion</td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
			<select name="CmbProd" onChange="Proceso('R')">
			<option value="-1" selected="selected">Seleccionar</option>
			<?
			$Consulta = "select * from pcip_svp_asignacion where mostrar_ppc='1' order by cod_asignacion";			
			$Resp=mysql_query($Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($CmbProd==$Fila["cod_asignacion"])
					echo "<option selected value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
				else
					echo "<option value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
			}
			?>
           </select>
		   <span class="InputRojo">(*)</span>
		   <?
		   }
		   else
		   		echo "<span class='formulario2'>".$NomAsig."</span>";	
		   ?>		   </td>
         </tr>
         <tr>
           <td height="33" class="formulario2">Producto</td>
           <td width="387" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbAsig" >
             <option value="-1" class="NoSelec">Seleccionar</option>
             <?
				$Consulta = "select * from pcip_svp_asignaciones_productos where cod_asignacion='".$CmbProd."' and tipo='PPC'";			
				$Resp=mysql_query($Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{
					if ($CmbAsig==$Fila["cod_producto"])
						echo "<option selected value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
				}
			?>
           </select>
		   </span>		   
		   <span class="InputRojo">(*)</span>
		   <?
		   }
		   else
		   		echo "<span class='formulario2'>".$NomProd."</span>";	
		   ?>		   </td>
           <td width="462" colspan="2" class="FilaAbeja2" >&nbsp;</td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Negocio</td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbNegocio" onChange="Proceso('R')">
             <option value="-1" class="NoSelec">Seleccionar</option>
             <?
			$Consulta = "select * from pcip_svp_negocios ";			
			$Resp=mysql_query($Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($CmbNegocio==$Fila["cod_negocio"])
					echo "<option selected value='".$Fila["cod_negocio"]."'>".ucfirst($Fila["nom_negocio"])."</option>\n";
				else
					echo "<option value='".$Fila["cod_negocio"]."'>".ucfirst($Fila["nom_negocio"])."</option>\n";
			}
			?>
           </select>
           <span class="InputRojo">(*)</span>		   </span>		   <?
		    }
		   	else
				echo "<span class='formulario2'>".$NomNegocio."</span>";	
		   ?>		   </td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Titulos</td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbTitulo" >
             <option value="-1" class="NoSelec">Seleccionar</option>
             <?
			$Consulta = "select * from pcip_svp_asignaciones_titulos where cod_asignacion='".$CmbProd."' and cod_negocio='".$CmbNegocio."' order by orden";			
			$Resp=mysql_query($Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($CmbTitulo==$Fila["cod_titulo"])
					echo "<option selected value='".$Fila["cod_titulo"]."'>".ucfirst($Fila["nom_titulo"])."</option>\n";
				else
					echo "<option value='".$Fila["cod_titulo"]."'>".ucfirst($Fila["nom_titulo"])."</option>\n";
			}
			?>
           </select>
           <span class="InputRojo">(*)</span>		   </span>		   <?
		    }
		   	else
				echo "<span class='formulario2'>".$NomTitulo."</span>";	
		   ?>		   </td>
         </tr>		 
         <tr>
           <td height="25" class="formulario2">N&ordm; Orden </td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
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
		   ?>         </td>
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
           <td height="25" class="formulario2">Codigo Material </td>
           <td colspan="3" class="FilaAbeja2"><input type="text" name="TxtMaterial" value="<? echo $TxtMaterial?>" onkeydown='TeclaPulsada(false)' maxlength="4" size="4"></td>
         </tr>
		 <tr>
           <td height="25" class="formulario2">Consumo Interno </td>
           <td colspan="3" class="FilaAbeja2"><input type="text" name="TxtConsumo" value="<? echo $TxtConsumo ;?>" onkeydown='TeclaPulsada(false)' maxlength="6" size="4"></td>
         </tr>		 
		 <tr>
           <td height="25" class="formulario2">VPtm</td>
           <td colspan="3" class="FilaAbeja2"><input type="text" name="TxtVPtm" value="<? echo $TxtVPtm ;?>" onkeydown='TeclaPulsada(false)' maxlength="3" size="4"></td>
         </tr>		 
		 <tr>
           <td height="25" class="formulario2">Ordenamiento en Reporte </td>
           <td colspan="3" class="FilaAbeja2"><input type="text" name="TxtOrden" value="<? echo $TxtOrden ;?>" onkeydown='TeclaPulsada(false)' maxlength="2" size="1"></td>
         </tr>		 

         <tr>
           <td height="14" colspan="4" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
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
		echo "alert('Asignacion Ingresada Correctamente');";
	if ($Mensaje=='2')
		echo "alert('Asignacion Modifica Correctamente');";
	echo "</script>";
?>
</body>
</html>
