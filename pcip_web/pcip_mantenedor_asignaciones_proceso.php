<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
if(!isset($Ano))
 	$Ano=date('Y');

if(!isset($Recarga))
{
	if ($Opcion=='M')
	{
	   //echo $Codigos."<br>";
		$Cod=explode('~',$Codigos);
		//echo "origen :  ".$Cod[6]."<br>"; 
		$Consulta="select t1.correlativo,t1.ano,t1.origen,t1.nodo,t6.nom_titulo as nom_titulo,t1.cod_titulo,t1.vptm,t1.orden,t1.cod_asignacion,t1.cod_procedencia,t1.cod_negocio,t1.num_orden,";
		$Consulta.="t1.num_orden_relacionada,t1.cod_material,t1.consumo_interno,t1.signo,t1.factor,t2.nom_asignacion as prod,t3.nom_asignacion,t4.nom_negocio,t5.OPdescripcion as nom_orden ";
		$Consulta.="from pcip_svp_productos_procedencias t1 inner join pcip_svp_asignaciones_productos t2 on t1.cod_procedencia=t2.cod_producto inner join pcip_svp_asignacion t3 on t1.cod_asignacion=t3.cod_asignacion ";
		$Consulta.="inner join pcip_svp_negocios t4 on t1.cod_negocio=t4.cod_negocio ";
		$Consulta.="left join pcip_svp_ordenesproduccion t5 on t1.num_orden=t5.OPorden ";
		$Consulta.="inner join pcip_svp_asignaciones_titulos t6 on t6.cod_titulo=t1.cod_titulo ";
		$Consulta.="where t1.correlativo='".$Cod[0]."' and t1.cod_asignacion='".$Cod[1]."' and t1.cod_procedencia='".$Cod[2]."' and t1.cod_negocio='".$Cod[3]."' and t1.num_orden='".$Cod[4]."' and t1.origen='".$Cod[6]."' ";
		if($Cod[6]=='SVP')
		 	$Consulta.="and t1.num_orden_relacionada='".$Cod[5]."' and t1.vptm='".$Cod[7]."' ";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysql_fetch_array($Resp);
		$CmbProd=$Fila[cod_asignacion];
		$Ano=$Fila[ano];
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
		$TxtVPtm=$Fila[vptm];
		$TxtOrden=$Fila[orden];
		$NomOrigen=$Fila[origen];
		$CmbOrigenDatos=$Fila[origen];
		$EstOrden='readonly';
		$CmbSigno=$Fila[signo];
		$TxtFactor=$Fila[factor];
		$CmbProducto=$Fila[num_orden_relacionada];
		if(!isset($Recarga2))
			$CmbNodo=$Fila["nodo"];
	}
	else
	{
		$Consulta="select max(correlativo+1) as maximo from pcip_svp_productos_procedencias ";
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$TxtCodigo=$Fila["maximo"];
		}
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
		echo "<title>Nueva Asignaci�n</title>";
	else	
		echo "<title>Modifica Asignaci�n</title>";
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
				f.action = "pcip_mantenedor_asignaciones_proceso01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			f.action = "pcip_mantenedor_asignaciones_proceso01.php?Opcion="+Opcion;
			f.submit();
		break;
		case "NI":
			f.Opcion.value='N';
			f.action = "pcip_mantenedor_asignaciones_proceso.php?Opcion=N";
			f.submit();
		break;
		case "R":	
			f.action = "pcip_mantenedor_asignaciones_proceso.php?Recarga=S";
			f.submit();
		break;
		case "R2":	
			f.action = "pcip_mantenedor_asignaciones_proceso.php?Recarga2=S";
			f.submit();
		break;

	}
}
function Salir()
{
    window.opener.document.frmPrincipal.action='pcip_mantenedor_asignaciones.php?Buscar=S';
    window.opener.document.frmPrincipal.submit();
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
		alert("Debe seleccionar Asignaci�n");
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
	if(f.CmbOrigenDatos.value=='ENA'||f.CmbOrigenDatos.value=='PMN')
	{
		if(f.CmbOrden.value=='-1')
		{
			alert("Debe Seleccionar Flujo");
			f.CmbOrden.focus();
			Res=false;
			return;
		}
		if(f.CmbNodo.value=='-1')
		{
			alert("Debe Seleccionar Nodo");
			f.CmbNodo.focus();
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
<input name="TxtCodigo" type="hidden" value="<? echo $TxtCodigo; ?>">
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
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_asignacion_n.png" width="450" height="40"><? }else{?><img src="archivos/sub_tit_asignacion_m.png" width="450" height="40"><? }?></td>
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
		 <td width="9%" class='formulario2'>A&ntilde;o
		 <td width="387" class='formulario2'>
		   <span class="formulario2">
            <select name="Ano" id="Ano">
            <?
			for ($i=2003;$i<=date("Y");$i++)
			{
				if ($i==$Ano)
					echo "<option selected value=\"".$i."\">".$i."</option>\n";
				else
					echo "<option value=\"".$i."\">".$i."</option>\n";
			}
			?>
            </select>
            </span>
		  </td>
		</tr>
         <tr>
           <td width="9%" class="formulario2">Asignacion</td>
           <td class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <select name="CmbProd" onChange="Proceso('R')">
             <option value="-1" selected="selected">Seleccionar</option>
             <?
			$Consulta = "select * from pcip_svp_asignacion order by nom_asignacion ";			
			$Resp=mysqli_query($link, $Consulta);
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
           <td class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbAsig" >
             <option value="-1" class="NoSelec">Seleccionar</option>
             <?
	    $Consulta = "select * from pcip_svp_asignaciones_productos where cod_asignacion='".$CmbProd."'";			
		$Resp=mysqli_query($link, $Consulta);
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
           </tr>
         <tr>
           <td height="25" class="formulario2">Negocio</td>
           <td class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbNegocio" onChange="Proceso('R')">
             <option value="-1" class="NoSelec">Seleccionar</option>
             <?
	    $Consulta = "select * from pcip_svp_negocios ";			
		$Resp=mysqli_query($link, $Consulta);
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
           <td class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbTitulo" >
             <option value="-1" class="NoSelec">Seleccionar</option>
             <?
	    $Consulta = "select * from pcip_svp_asignaciones_titulos where cod_asignacion='".$CmbProd."' and cod_negocio='".$CmbNegocio."' order by orden";			
		$Resp=mysqli_query($link, $Consulta);
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
           <td height="25" class="formulario2">Origen Datos </td>
           <td class="FilaAbeja2"><?
		   if($Opcion=='N')
		   {
		   ?>
             <span class="formulario2">
             <select name="CmbOrigenDatos" onChange="Proceso('R')">
               <?
			   		switch($CmbOrigenDatos)
					{
						case "SVP":
							echo "<option value='SVP' selected>SVP</option>";
							echo "<option value='CDV' >CDV</option>";
							echo "<option value='ENA' >ENA</option>";
							echo "<option value='PMN' >PMN</option>";
						break;
						case "CDV":
							echo "<option value='SVP' >SVP</option>";
							echo "<option value='CDV' selected>CDV</option>";
							echo "<option value='ENA' >ENA</option>";
							echo "<option value='PMN' >PMN</option>";
						break;
						case "ENA":
							echo "<option value='SVP' >SVP</option>";
							echo "<option value='CDV' >CDV</option>";
							echo "<option value='ENA' selected>ENA</option>";
							echo "<option value='PMN' >PMN</option>";
						break;
						case "PMN":
							echo "<option value='SVP' >SVP</option>";
							echo "<option value='CDV' >CDV</option>";
							echo "<option value='ENA' >ENA</option>";
							echo "<option value='PMN' selected>PMN</option>";
						break;
						default:
							echo "<option value='SVP' >SVP</option>";
							echo "<option value='CDV' >CDV</option>";
							echo "<option value='ENA' >ENA</option>";
							echo "<option value='PMN' >PMN</option>";
						break;						
					}
			   ?>
             </select>
             <span class="InputRojo">(*)</span> </span>
             <?
		    }
		   	else
				echo "<span class='formulario2'>".$NomOrigen."</span>";	
		   ?></td>
		 </tr>		 
		<?
		if($CmbOrigenDatos=='SVP')
		{
		?>
         <tr>
           <td height="25" class="formulario2">N&ordm; Orden </td>
           <td class="FilaAbeja2"><?
		   if($Opcion=='N')
		   {
		   ?>
             <span class="formulario2">
             <select name="CmbOrden" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
				$Consulta = "select * from pcip_svp_ordenesproduccion order by OPorden ";			
				$Resp=mysqli_query($link, $Consulta);
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
				$Resp=mysqli_query($link, $Consulta);
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
           <td class="FilaAbeja2"><input type="text" name="TxtVPtm" value="<? echo $TxtVPtm ;?>" onkeydown='TeclaPulsada(false)' maxlength="3" size="4"></td>
         </tr>		 
		<?
		}
		if($CmbOrigenDatos=='CDV')
		{
		if($CmbOrden=='-1')
			$CmbOrden='';
		?>
		 <tr>
           <td height="25" class="formulario2">Cod. Producto</td>
           <td class="FilaAbeja2"><input type="text" name="CmbOrden" value="<? echo $CmbOrden ;?>" onkeydown='TeclaPulsada(false)' maxlength="5" size="1"></td>
         </tr>		 
		<?
		}
			if($CmbOrigenDatos=='ENA' || $CmbOrigenDatos=='PMN')
			{
		?>
		 <tr>
           <td height="25" class="formulario2">Nodo</td>
           <td class="FilaAbeja2"> 
             <select name="CmbNodo" onChange="Proceso('R2')">
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
				$Consulta = "select valor_subclase1,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31025' order by valor_subclase1";						
				$Resp=mysqli_query($link, $Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{
					if ($CmbNodo==$Fila["valor_subclase1"])
						echo "<option selected value='".$Fila["valor_subclase1"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$Fila["valor_subclase1"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
				}
  			   ?>
             </select><span class="InputRojo">(*)</span> </span><? //echo $Consulta;?>
			 &nbsp;&nbsp;&nbsp; Flujo   
             <select name="CmbOrden" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
				$Consulta = "select distinct cod_flujo,nom_flujo,tipo_dato from pcip_ena_datos_enabal where origen='".$CmbOrigenDatos."' and tipo_dato='F' and tipo_mov='".$CmbNodo."'";
				$Consulta.= " group by origen,cod_flujo, tipo_dato order by cod_flujo ";			
				$Resp=mysqli_query($link, $Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{
					if ($CmbOrden==$Fila["cod_flujo"])
						echo "<option selected value='".$Fila["cod_flujo"]."'>".$Fila["cod_flujo"]."&nbsp;".ucfirst($Fila["nom_flujo"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_flujo"]."'>".$Fila["cod_flujo"]."&nbsp;".ucfirst($Fila["nom_flujo"])."</option>\n";
				}
  			   ?>
             </select><span class="InputRojo">(*)</span> </span><? //echo $Consulta;?>
         </tr>	
		 <tr>
           <td height="25" class="formulario2">Producto</td>
           <td class="FilaAbeja2">
             <select name="CmbProducto">
               <?
			   		switch($CmbProducto)
					{
						case "1":
							echo "<option value='1' selected>COBRE</option>";
							echo "<option value='2' >PLATA</option>";
							echo "<option value='3' >ORO</option>";
						break;
						case "2":
							echo "<option value='1' >COBRE</option>";
							echo "<option value='2'  selected>PLATA</option>";
							echo "<option value='3' >ORO</option>";
						break;
						case "3":
							echo "<option value='1' >COBRE</option>";
							echo "<option value='2' >PLATA</option>";
							echo "<option value='3' selected>ORO</option>";
						break;
						default:
							echo "<option value='1' >COBRE</option>";
							echo "<option value='2' >PLATA</option>";
							echo "<option value='3' >ORO</option>";
						break;						
					}
			   ?>
             </select>             
         </tr>	
		<?
			}
		?>
		 <tr>
           <td height="25" class="formulario2">Signo</td>
           <td class="FilaAbeja2">
             <select name="CmbSigno">
               <?
			   		switch($CmbSigno)
					{
						case "+":
							echo "<option value='+' selected>+</option>";
							echo "<option value='-' >-</option>";
						break;
						case "-":
							echo "<option value='+' >+</option>";
							echo "<option value='-'  selected>-</option>";
						break;
						default:
							echo "<option value='+' selected>+</option>";
							echo "<option value='-' >-</option>";
						break;						
					}
			   ?>
             </select>             
         </tr>
		 <?
		 	if($TxtFactor=='')
				$TxtFactor='1';
		 ?>	
		 <tr>
           <td height="25" class="formulario2">Factor</td>
           <td class="FilaAbeja2"><input type="text" name="TxtFactor" onkeydown='SoloNumerosyNegativo(true,this)' maxlength="7" size="10" value="<? echo number_format($TxtFactor,4,',','.');?>"></td>
         </tr>		 
         <tr>
           <td height="14" colspan="2" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
         </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td align="center" class="TituloTablaVerde"></td>
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
