<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

if(!isset($Recarga))
{
	if ($Opcion=='M')
	{
		$Cod=explode('~',$Codigos);
		$Consulta="select t1.cod_producto,t1.cod_negocio,t1.cod_subproducto,t1.orden,t1.cod_titulo,t2.nombre_subclase as nom_producto,t3.nombre_subclase as nom_subproducto,t4.nombre_subclase as nom_negocio,t5.nombre_subclase as nom_titulo,t6.OPdescripcion";
		$Consulta.=" from pcip_svp_balance_mensual t1 ";
		$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31054' and t1.cod_producto=t2.cod_subclase ";
		$Consulta.=" left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31055' and t1.cod_subproducto=t3.cod_subclase ";
		$Consulta.=" inner join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31056' and t1.cod_negocio=t4.cod_subclase ";
		$Consulta.=" inner join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='31057' and t1.cod_titulo=t5.cod_subclase ";
		$Consulta.=" inner join pcip_svp_ordenesproduccion t6 on t1.orden=t6.OPorden ";
		$Consulta.="where t1.cod_producto='".$Cod[0]."' and t1.cod_negocio='".$Cod[1]."' and t1.orden='".$Cod[2]."'";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		if($FilaBal=mysql_fetch_array($Resp))
		{
			$CmbProducto=$FilaBal["cod_producto"];
			$Nomproducto=$FilaBal["nom_producto"];
			$CmbSubProducto=$FilaBal[cod_subproducto];
			$CmbNegocio=$FilaBal[cod_negocio];
			$NomNegocio=$FilaBal[nom_negocio];
			$CmbOrdenProd=$FilaBal[OPorden];
			$CmbTitulo=$FilaBal[cod_titulo];
			$CmbOrdenProd=$FilaBal[orden];
		}	
	}
	else
	{
		$TxtTitulo="";
		$CmbProducto="-1";
		$CmbSubProducto="-1";
		$CmbNegocio="-1";
		$CmbSubNegocio="-1";
		$CmbOrdenProd="-1";
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
				f.action = "pcip_parametros_balance_mensual_nuevo_svp_proceso01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			f.action = "pcip_parametros_balance_mensual_nuevo_svp_proceso01.php?Opcion="+Opcion;
			f.submit();
		break;
		case "NI":
			f.Opcion.value='N';
			f.action = "pcip_parametros_balance_mensual_nuevo_svp_proceso.php?Opcion=N";
			f.submit();
		break;
		case "TI":
				var popup=0;		
				URL="pcip_parametros_balance_mensual_nuevo_svp_titulo.php";
				opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=660,height=400,scrollbars=1';
				verificar_popup(popup);
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
		break;
		case "R":	
			f.action = "pcip_parametros_balance_mensual_nuevo_svp_proceso.php?Recarga=S";
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

	if(f.CmbProducto.value=='-1')
	{
		alert("Debe seleccionar Producto");
		f.CmbProducto.focus();
		Res=false;
		return;
	}
	if(f.CmbProducto.value=='4')
	{
		if(f.CmbSubProducto.value=='-1')
		{
			alert("Debe seleccionar SubProducto");
			f.CmbSubProducto.focus();
			Res=false;
			return;
		}
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
	if(f.CmbOrdenProd.value=='-1')
	{
		alert("Debe Seleccionar Orden");
		f.CmbOrdenProd.focus();
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
	   <a href="JavaScript:Proceso('TI')"><img src="../pcip_web/archivos/btn_agregar.png" alt="Nuevo/Modificar Titulo"  border="0" align="absmiddle" /></a>
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
           <td height="33" class="formulario2">Producto</td>
           	<td class="FilaAbeja2">
			   <?
			   if($Opcion=='N')
			   {
			   ?>
			   <span class="formulario2">
				   <select name="CmbProducto" onChange="Proceso('R')">
					 <option value="-1" selected="selected">Seleccionar</option>
					 <?
					$Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31054' order by cod_subclase ";			
					$Resp=mysqli_query($link, $Consulta);
					while ($FilaTC=mysql_fetch_array($Resp))
					{
						if ($CmbProducto==$FilaTC["cod_subclase"])
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
			   {
			   		echo "<input name='CmbProducto' type='hidden' value='".$CmbProducto."'>";
					echo $Nomproducto;	
			   }
			   ?>		    </td>
           </tr>
			<?
		   	if($CmbProducto=='4')
			{
			?>
			 <tr>
			   <td width="180" class="formulario2">SubProducto</td>
			   <td class="FilaAbeja2">
			   <span class="formulario2">
			   <select name="CmbSubProducto">
				 <option value="-1" selected="selected">Seleccionar</option>
				 <?
				$Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31055' and valor_subclase1='".$CmbProducto."' order by cod_subclase ";			
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbSubProducto==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
				?>
			   </select></span><span class="InputRojo">(*)</span>			</td>
         </tr>
		 <?
		  }
		 ?>
         <tr>
           <td height="25" class="formulario2">Negocio</td>
           <!---->
           <td class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbNegocio" onChange="Proceso('R')" >
             <option value="-1" selected="selected">Seleccionar</option>
             <?
				$Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31056' order by cod_subclase ";			
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbNegocio==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			?>
           </select>
		   </span><span class="InputRojo">(*)</span>		   <?
		    }
		   	else
			{
		   		echo "<input name='CmbNegocio' type='hidden' value='".$CmbNegocio."'>";
				echo $NomNegocio;	
		   	}
		   ?>		    </td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Titulos</td>
           <td class="FilaAbeja2">
		   <span class="formulario2">
		   <select name="CmbTitulo">
           	<option value="-1" selected="selected">Seleccionar</option>			 
			<?
			$Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31057' and valor_subclase1='".$CmbNegocio."' order by cod_subclase ";						
			$Resp=mysqli_query($link, $Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbTitulo==$FilaTC["cod_subclase"])
					echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				else
					echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			}
			?>
           </select><? //echo "Consulta:  ".$Consulta."<br>";?>
		   </span><span class="InputRojo">(*)</span>			</td>
         </tr>		 
         <tr>
           <td height="25" class="formulario2">Orden de Producci&oacute;n </td>
           <td class="FilaAbeja2">
		   <span class="formulario2">
		   <select name="CmbOrdenProd">
             <option value="-1" selected="selected">Seleccionar</option>
             <?
		    $Consulta = "select OPorden,OPdescripcion from pcip_svp_ordenesproduccion order by OPorden ";			
			$Resp=mysqli_query($link, $Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbOrdenProd==$FilaTC["OPorden"])
					echo "<option selected value='".$FilaTC["OPorden"]."'>".$FilaTC["OPorden"]."&nbsp;&nbsp;".ucfirst($FilaTC["OPdescripcion"])."</option>\n";
				else
					echo "<option value='".$FilaTC["OPorden"]."'>".$FilaTC["OPorden"]."&nbsp;&nbsp;".ucfirst($FilaTC["OPdescripcion"])."</option>\n";
			}
			?>
           </select>
		   </span><span class="InputRojo">(*)</span>			</td>
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
	if ($Mensaje)
		echo "alert('".$Mensaje."');";
	echo "</script>";
?>
</body>
</html>
