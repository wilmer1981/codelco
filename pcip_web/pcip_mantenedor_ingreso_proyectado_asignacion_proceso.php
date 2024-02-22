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
		if($Cod[0]==1)
		{
			$Consulta =" select t1.dato,t1.VPorden,t1.VPtm,t1.VPmaterial,t1.Vptipinv,t1.VPordenrel,t1.VPordes,t2.nombre_subclase as nom_productos,t3.nombre_subclase as nom_proveedor";
			$Consulta.=" from pcip_inp_asignacion t1";
			$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31029' and t1.cod_producto=t2.cod_subclase";	
			$Consulta.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31030' and t1.cod_proveedor=t3.cod_subclase";
			$Consulta.=" where dato='".$Cod[0]."' and cod_producto='".$Cod[1]."' and cod_proveedor='".$Cod[2]."' and  VPorden='".$Cod[3]."'";	
			//echo $Consulta;
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
			
				$CmbDatos=$Fila[dato];
				$CmbProducto=$Fila[nom_productos];
				$CmbProveedores=$Fila[nom_proveedor];
				$CmbOrden=$Fila[VPorden];
				$CmbOrdenRel=$Fila[VPordenrel];
				$TxtMaterial=$Fila[VPmaterial];
				$TxtVPtm=$Fila[VPtm];
				$TxtVptipinv=$Fila[Vptipinv];
				$TxtVPOrdes=$Fila[VPordes];
		}		
		else
		{
			$Consulta =" select t1.cod_producto,t1.cod_proveedor,t1.dato,t1.VPorden,t1.VPtm,t1.VPmaterial,t1.Vptipinv,t1.VPordenrel,t1.VPordes,t2.nombre_subclase as nom_productos,t3.nombre_subclase as nom_proveedor";
			$Consulta.=" from pcip_inp_asignacion t1";
			$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31029' and t1.cod_producto=t2.cod_subclase";	
			$Consulta.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31030' and t1.cod_proveedor=t3.cod_subclase";
			$Consulta.=" where dato='".$Cod[0]."' and cod_producto='".$Cod[1]."' and cod_proveedor='".$Cod[2]."' and  VPorden='".$Cod[3]."' and VPtm='".$Cod[4]."' and VPmaterial='".$Cod[5]."' and VPtipinv='".$Cod[6]."'";	
			//echo $Consulta;
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);

				$CmbDatos=$Fila[dato];
				$CmbProducto=$Fila[nom_productos];
				$CodProducto=$Fila["cod_producto"];
				$CmbProveedores=$Fila[nom_proveedor];
				$CodProveedor=$Fila[cod_proveedor];
				$CmbProd=$Fila[VPorden];
				$CmbAsig=$Fila[VPtm];
				$CmbNegocio=$Fila[VPmaterial];
				$CmbTitulo=$Fila[Vptipinv];
		}
	}
	else
	{
		$CmbProducto='-1';
		$CmbProveedores='-1';
		$CmbOrden='-1';
		$CmbOrdenRel='-1';
		$TxtMaterial='';
		$TxtVPtm='';
		$TxtVptipinv='';
		$TxtVPOrdes='';
	}
}	
if(isset($Recarga))
{
	$Cod=explode('~',$Codigos);
	if($Cod[0]==2)
	{		
		$Consulta =" select t1.cod_producto,t1.cod_proveedor,t1.dato,t1.VPorden,t1.VPtm,t1.VPmaterial,t1.Vptipinv,t1.VPordenrel,t1.VPordes,t2.nombre_subclase as nom_productos,t3.nombre_subclase as nom_proveedor";
		$Consulta.=" from pcip_inp_asignacion t1";
		$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31029' and t1.cod_producto=t2.cod_subclase";	
		$Consulta.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31030' and t1.cod_proveedor=t3.cod_subclase";
		$Consulta.=" where dato='".$Cod[0]."' and cod_producto='".$Cod[1]."' and cod_proveedor='".$Cod[2]."' and  VPorden='".$Cod[3]."' and VPtm='".$Cod[4]."' and VPmaterial='".$Cod[5]."' and VPtipinv='".$Cod[6]."'";	
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);

			$CmbDatos=$Fila[dato];
			$CmbProducto=$Fila[nom_productos];
			$CodProducto=$Fila["cod_producto"];
			$CmbProveedores=$Fila[nom_proveedor];
			$CodProveedor=$Fila[cod_proveedor];			
	}	
}
if($Opcion=='N')
{
	if(!isset($CmbDatos))
		$CmbDatos='1';
}
?>
<html>
<head>
<?
	if ($Opcion=='N')
		echo "<title>Nuevo Ingreso Proyectado Asignacion</title>";
	else	
		echo "<title>Modifica Ingreso Proyectado Asignacion</title>";
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
				f.action = "pcip_mantenedor_ingreso_proyectado_asignacion_proceso01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			f.action = "pcip_mantenedor_ingreso_proyectado_asignacion_proceso01.php?Opcion="+Opcion;
			f.submit();
		break;
		case "NI":
			f.Opcion.value='N';
			f.action = "pcip_mantenedor_ingreso_proyectado_asignacion_proceso.php?Opcion=N";
			f.submit();
		break;
		case "R":
				f.action = "pcip_mantenedor_ingreso_proyectado_asignacion_proceso.php?Recarga=S";
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

    if(f.CmbDatos.value=='1')
	{
		if(f.CmbProducto.value=='-1')
		{
			alert("Debe Seleccionar Producto");
			f.CmbProducto.focus();
			Res=false;
			return;
		}
		if(f.CmbProveedores.value=='-1')
		{
			alert("Debe Seleccionar Proveedor");
			f.CmbProveedores.focus();
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
	}
	else
	{
		if(f.CmbProducto.value=='-1')
		{
			alert("Debe Seleccionar Producto");
			f.CmbProducto.focus();
			Res=false;
			return;
		}
		if(f.CmbProveedores.value=='-1')
		{
			alert("Debe Seleccionar Proveedor");
			f.CmbProveedores.focus();
			Res=false;
			return;
		}
		if(f.CmbProd.value=='-1')
		{
			alert("Debe seleccionar Asignacion");
			f.CmbProd.focus();
			Res=false;
			return;
		}
		if(f.CmbAsig.value=='-1')
		{
			alert("Debe Seleccionar Producto");
			f.CmbAsig.focus();
			Res=false;
			return;
		}
		if(f.CmbNegocio.value=='-1')
		{
			alert("Debe Seleccionar Negocio");
			f.CmbNegocio.focus();
			Res=false;
			return;
		}
		if(f.CmbTitulo.value=='-1')
		{
			alert("Debe Seleccionar Titulo");
			f.CmbTitulo.focus();
			Res=false;
			return;
		}
		
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
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_ingreso_proyectado_asignacion_n.png" width="450" height="40"><? }else{?><img src="archivos/sub_tit_ingreso_proyectado_asignacion_m.png" width="450" height="40"><? }?></td>
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
			<?
			if($Opcion=='N')
			{
			?>
		 <tr>
           <td width="180" class="formulario2">Seleccionar PPC - SVP</td>
           <td class="FilaAbeja2">
			<select name="CmbDatos" onChange="Proceso('R')">
			<?
			 switch($CmbDatos)
			 {
			 	case "1":
				        echo"<option value='1' selected>SVP</option>";
						echo"<option value='2' >PPC</option>";  
				break;
			 	case "2":
				        echo"<option value='1' >SVP</option>";
						echo"<option value='2' selected>PPC</option>";  
				break;
			 	default:
				        echo"<option value='1' selected>SVP</option>";
						echo"<option value='2' >PPC</option>";  
				break;
				
			 }
			?>
		    </select>		  
			</td>
		 </tr>
		  <? } ?>
		 <?
		  if($CmbDatos=='1')
		  {
		 ?>
			 <tr>
			   <td width="180" class="formulario2">Productos</td>
			   <td class="FilaAbeja2">
					<?
					if($Opcion=='N')
					{
					?>
					 <select name="CmbProducto" onChange="Proceso('R')">
					 <option value="-1" selected="selected">Seleccionar</option>
					<?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31029' order by cod_subclase ";			
					$Resp=mysql_query($Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbProducto==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
					}
					?>
				   </select>
				   <span class="InputRojo">(*)</span>
				   <?
				   }
				   else
						echo "<span class='formulario2'>".$CmbProducto."</span>";	
				   ?></td>
				 </tr>
					 <tr>
					   <td height="33" class="formulario2">Proveedores</td>
					   <td class="FilaAbeja2">
					   <?
					   if($Opcion=='N')
					   {
					   ?>
					   <span class="formulario2">
					   <select name="CmbProveedores" >
						 <option value="-1" class="NoSelec">Seleccionar</option>
						<?
						$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31030' and valor_subclase1='".$CmbProducto."'";					
						$Resp=mysql_query($Consulta);
						while ($Fila=mysql_fetch_array($Resp))
						{
							if ($CmbProveedores==$Fila["cod_subclase"])
								echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
							else
								echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
						}
						?>
					   </select>
					   </span>		   
					   <span class="InputRojo">(*)</span>
					   <?
					   }
					   else
							echo "<span class='formulario2'>".$CmbProveedores."</span>";	
					   ?></td>
					   </tr>		 
					 <tr>
					   <td height="25" class="formulario2">N&ordm; Orden</td>
					   <td class="FilaAbeja2"><?
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
						{
							echo "<span class='formulario2'>".$CmbOrden."</span>";	
					   	}
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
				   </span>				  </td>
			 </tr>
			 <tr>
			   <td height="25" class="formulario2">Codigo Material </td>
			   <td class="FilaAbeja2"><input type="text" name="TxtMaterial" value="<? echo $TxtMaterial?>" onkeydown='TeclaPulsada(false)' maxlength="4" size="4"></td>
			 </tr>		 
			 <tr>
			   <td height="25" class="formulario2">VPtm</td>
			   <td class="FilaAbeja2"><input type="text" name="TxtVPtm" value="<? echo $TxtVPtm ;?>" onkeydown='TeclaPulsada(false)' maxlength="3" size="4"></td>
			 </tr>		 		
			 <tr>
			   <td height="25" class="formulario2">Vptipinv</td>
			   <td class="FilaAbeja2"><input type="text" name="TxtVptipinv" value="<? echo $TxtVptipinv ;?>" onkeydown='TeclaPulsada(false)' maxlength="12" size="11"></td>
			 </tr>		 
			 <tr>
			   <td height="25" class="formulario2">Vpordes </td>
			   <td class="FilaAbeja2"><input type="text" name="TxtVPOrdes" value="<? echo $TxtVPOrdes ;?>" onkeydown='TeclaPulsada(false)' maxlength="10" size="10"></td>
			 </tr>		 
			<?
			 }
			 else
			 {
			?>	
			 <tr>
			   <td width="180" class="formulario2">Productos Asignaci&oacute;n </td>
			   <td class="FilaAbeja2">
					<?
					if($Opcion=='N')
					{
					?>
					 <select name="CmbProducto" onChange="Proceso('R')">
					 <option value="-1" selected="selected">Seleccionar</option>
					<?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31029' order by cod_subclase ";			
					$Resp=mysql_query($Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbProducto==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
					}
					?>
				   </select>
				   <span class="InputRojo">(*)</span>
				   <?
				   }
				   else
				   {
						echo "<span class='formulario2'>".$CmbProducto."</span>";
						echo "<input type='hidden' name='CodProducto' value='".$CodProducto."'>";	
				   }
				   ?></td>
				 </tr>
					 <tr>
					   <td height="33" class="formulario2">Proveedores Asignaci�n</td>
					   <td class="FilaAbeja2">
					   <?
					   if($Opcion=='N')
					   {
					   ?>
					   <span class="formulario2">
					   <select name="CmbProveedores" >
						 <option value="-1" class="NoSelec">Seleccionar</option>
						<?
						$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31030' and valor_subclase1='".$CmbProducto."'";					
						$Resp=mysql_query($Consulta);
						while ($Fila=mysql_fetch_array($Resp))
						{
							if ($CmbProveedores==$Fila["cod_subclase"])
								echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
							else
								echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
						}
						?>
					   </select>
					   </span>		   
					   <span class="InputRojo">(*)</span>
					   <?
					   }
					   else
							echo "<span class='formulario2'>".$CmbProveedores."</span>";	
							echo "<input type='hidden' name='CodProveedor' value='".$CodProveedor."'>";	
					   ?></td>
					   </tr>		 
				 <tr>
				   <td width="180" class="formulario2">Asignacion</td>
				   <td class="FilaAbeja2">
				   <select name="CmbProd" onChange="Proceso('R')">
					 <option value="-1" selected="selected">Seleccionar</option>
					 <?
					$Consulta = "select * from pcip_svp_asignacion where mostrar_ppc='1'order by nom_asignacion ";			
					$Resp=mysql_query($Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbProd==$Fila["cod_asignacion"])
						{
							echo "<option selected value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
							$Unidad=$Fila["cod_unidad"];
						}
						else
							echo "<option value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
					}
					?>
				   </select>
				   <span class="InputRojo">(*)</span>
					</td>
				 </tr>				 
				 <tr>
				   <td height="33" class="formulario2">Producto</td>
				   <td width="387" class="FilaAbeja2">
				   <span class="formulario2">
				   <select name="CmbAsig" onChange="Proceso('R')">
					 <option value="-1" class="NoSelec">Seleccionar</option>
					 <?
					$Consulta = "select * from pcip_svp_asignaciones_productos where cod_asignacion='".$CmbProd."' and mostrar_ppc='1' order by nom_asignacion";			
					$Resp=mysql_query($Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbAsig==$Fila["cod_producto"])
						{
							echo "<option selected value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
							//$Unidad=$Fila["cod_unidad"];
						}
						else
							echo "<option value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
					}
					?>
				   </select>
				   </span>		   
				   <span class="InputRojo">(*)</span>
					</td>
				 </tr>
				 <tr>
				   <td height="25" class="formulario2">Negocio</td>
				   <td class="FilaAbeja2">
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
				   <span class="InputRojo">(*)</span></span>		   
				   </td>
				 </tr>
				 <tr>
				   <td height="25" class="formulario2">Titulos</td>
				   <td class="FilaAbeja2">
				   <span class="formulario2">
				   <select name="CmbTitulo" >
					 <option value="-1" class="NoSelec">Seleccionar</option>
					 <?
					$Consulta = "select * from pcip_svp_asignaciones_titulos where cod_asignacion='".$CmbProd."' and cod_negocio='".$CmbNegocio."' order by orden";						
					$Resp=mysql_query($Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbTitulo==$Fila["cod_titulo"])
							echo "<option selected value='".$Fila["cod_titulo"]."'>".ucfirst(trim($Fila["nom_titulo"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_titulo"]."'>".ucfirst(trim($Fila["nom_titulo"]))."</option>\n";
					}			  
					?>
				   </select><? //echo $Consulta."<br>";?>
				   <span class="InputRojo">(*)</span></span>		   
				   </td>
				 </tr>
			<?
			 }
			?>	 
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
	if ($MensajeExiste==true)
		echo "alert('Este Registro Existe');";
	if ($Mensaje1==true)
		echo "alert('Registro Ingresado Exitosamente');";
	if ($Mensaje2==true)
		echo "alert('Registro Modifico Correctamente');";
	echo "</script>";
?>
</body>
</html>
