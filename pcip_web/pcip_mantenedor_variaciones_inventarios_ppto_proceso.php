<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
if(!isset($Ano))
 	$Ano=date('Y');

if(!isset($Recarga))
{
	if ($Opcion=='M')
	{
		$Valores=explode('~',$Cod);
		$Consulta="select t1.cod_asignacion,t1.cod_area,t1.cod_maquila,t1.cod_producto,t5.nombre_subclase as nom_maquila,t4.nombre_subclase as nom_area,t2.nom_asignacion,t1.ano,t1.mes,t3.nom_producto,t1.valor_ppto";
		$Consulta.=" from pcip_svp_variacion_inventario_ppto t1 inner join pcip_svp_asignacion t2 on t1.cod_asignacion=t2.cod_asignacion";
		$Consulta.=" inner join pcip_svp_productos_inventarios t3 on t1.cod_producto=t3.cod_producto";
		$Consulta.=" inner join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31009' and t4.cod_subclase=t1.cod_area";
		$Consulta.=" inner join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='31010' and t5.cod_subclase=t1.cod_area";
		$Consulta.=" where t1.cod_asignacion='".$Valores[0]."' and t1.cod_area='".$Valores[1]."' and t1.cod_maquila='".$Valores[2]."' and t1.cod_producto='".$Valores[3]."' and t1.ano='".$Valores[4]."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$Asig=$Fila["nom_asignacion"];
			$Area=$Fila["nom_area"];
			$Maqui=$Fila["nom_maquila"];
			$Prod=$Fila["nom_producto"];
			$Ano=$Fila["ano"];
			$TxtValor=$Fila["valor"];
			$CmbAsig=$Fila["cod_asignacion"];
			$CmbArea=$Fila["cod_area"];
			$CmbMaqui=$Fila["cod_maquila"];
			$CmbProd=$Fila["cod_producto"];
			$Ano=$Fila["ano"];
			
		}
	}

}
	
?>
<html>
<head>
<?
	if ($Opcion=='N')
		echo "<title>Nuevo variación inventario PPTO</title>";
	else	
		echo "<title>Modifica variación inventario PPTO</title>";
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
				for (i=0;i<f.TxtValorMes.length;i++)
				{
					Valores=Valores+f.TxtValorMes[i].value+"~";
				}
				Valores=Valores.substr(0,Valores.length-1);
				f.action = "pcip_mantenedor_variaciones_inventarios_ppto_proceso01.php?Opcion="+Opcion+"&Valores="+Valores;
				f.submit();
			}
		break;
		case "M":
		f.Opcion.value='N';
			
			for (i=0;i<f.TxtValorMes.length;i++)
			{
				Valores=Valores+f.TxtValorMes[i].value+"~";
			}
			Valores=Valores.substr(0,Valores.length-1);
			f.action = "pcip_mantenedor_variaciones_inventarios_ppto_proceso01.php?Opcion=N&Valores="+Valores;
			f.submit();
		break;
		case "R":	
			f.action = "pcip_mantenedor_variaciones_inventarios_ppto_proceso.php";
			f.submit();
		break;
		case "NI":
			f.Opcion.value='N';
			f.action = "pcip_mantenedor_variaciones_inventarios_ppto_proceso.php?Opcion=N";
			f.submit();
		break;
		
	}
}
function Salir()
{
	window.close();
}
function TeclaPulsada1(tecla) 
{ 
	var Frm=document.FrmPopupProceso;
	var teclaCodigo = event.keyCode; 


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
function ValidaCampos()
{
	var f= document.FrmPopupProceso;
	var Res=true;

	if(f.CmbGrupo.value=='-1')
	{
		alert("Debe seleccionar Grupo Asignación");
		f.CmbGrupo.focus();
		Res=false;
		return;
	}
	if(f.CmbAsig.value=='-1')
	{
		alert("Debe seleccionar Asignación");
		f.CmbAsig.focus();
		Res=false;
		return;
	}
	if(f.CmbArea.value=='-1')
	{
		alert("Debe seleccionar Equipo");
		f.CmbArea.focus();
		Res=false;
		return;
	}
	if(f.CmbMaqui.value=='-1')
	{
		alert("Debe seleccionar Maquila");
		f.CmbMaqui.focus();
		Res=false;
		return;
	}
	if(f.CmbProd.value=='-1')
	{
		alert("Debe seleccionar Producto");
		f.CmbProd.focus();
		Res=false;
		return;
	}
	if(f.Ano.value=='T')
	{
		alert("Debe seleccionar Año");
		f.Ano.focus();
		Res=false;
		return;
	}
	return(Res);		
}
function Recarga()
{
	var f= document.FrmPopupProceso;
	f.action = "pcip_mantenedor_variaciones_inventarios_ppto_proceso.php?Opcion=N";
	f.submit();
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
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_variacion_inventario_ppto_n.png"><? }else{?><img src="archivos/sub_tit_variacion_inventario_ppto_m.png"><? }?></td>
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
		if ($Opcion=='N')
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
           <td width="113" class="formulario2">Asignaci&oacute;n </td>
           <td width="840" colspan="4" class="formulariosimple">
		   <? 
		    if ($Opcion=='N')
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
			  </select><span class="InputRojo">(*)</span>
			<? 
			  }
			  else 
			  { 
			  ?>
			   <span class='formulario2'><? echo $Asig;?></span>	
			 <input name="CmbAsig" type="hidden" value="<? echo $CmbAsig;?>">
			  <? }
			
			?>	  
				  
            </td>
         </tr>
	  <tr>
		<td width="113" height="17" class='formulario2'>&Aacute;rea</td>
		<td colspan="3" class="formulario2" >
		   <? 
		     if ($Opcion=='N')
			 {
		   ?>
			   <select name="CmbArea">
			   <option value="-1" class="NoSelec">Todos</option>
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
			{?>
			   <span class='formulario2'><? echo $Area;?></span>	
			 <input name="CmbArea" type="hidden" value="<? echo $CmbArea;?>">
			<? }?>
		 </td>
	  </tr>
	  <tr>
		<td height="17" class='formulario2'>Maquila</td>
		<td colspan="3" class='formulario2'>
		   <? 
		     if($Opcion=='N')
			 {
		   ?>
			   <select name="CmbMaqui">
			   <option value="-1" class="NoSelec">Todos</option>
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
			{
			?>
			   <span class='formulario2'><? echo $Maqui;?></span>	
			 <input name="CmbMaqui" type="hidden" value="<? echo $CmbMaqui;?>">
			<? }?>
			 
		  </td>  
	  </tr>
	  <tr>
		<td height="17" class='formulario2'> Productos</td>
		<td colspan="3" class='formulario2'>
		   <?
		    if($Opcion=='N')
			{
		   ?>
			   <select name="CmbProd">
			   <option value="-1" class="NoSelec">Todos</option>
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
			{
			?>
			   <span class='formulario2'><? echo $Prod;?></span>	
			 <input name="CmbProd" type="hidden" value="<? echo $CmbProd;?>">
			<? }?>
		  </td> 
	  </tr>
         <tr>
           <td height="25" class="formulario2">A&ntilde;o</td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
             <select name="Ano" id="Ano">
               <?
					for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
					{
						if ($i==$Ano)
							echo "<option selected value=\"".$i."\">".$i."</option>\n";
						else
							echo "<option value=\"".$i."\">".$i."</option>\n";
					}
				?>
             </select>
           </span>
		   <?
		    }
		   	else
			{
			?>
			   <span class='formulario2'><? echo $Ano;?></span>	
			 <input name="Ano" type="hidden" value="<? echo $Ano;?>">
			<? }?>	</td>
         </tr>
         <tr>
           <td colspan="4" class='formulario2'>
		   <table width="100%" border="1" cellpadding="4" cellspacing="0" >
             <tr>
               <td colspan="13" align="center" class="TituloTablaNaranja">Variaciones Inventarios PPTO</td>
             </tr>
             <tr align="center">
			   <td width="7%" class="TituloCabecera">Enero</td>
               <td width="7%" class="TituloCabecera">Febrero</td>
               <td width="7%" class="TituloCabecera">Marzo</td>
               <td width="7%" class="TituloCabecera">Abril</td>
               <td width="7%" class="TituloCabecera">Mayo</td>
               <td width="7%" class="TituloCabecera">Junio</td>
               <td width="7%" class="TituloCabecera">Julio</td>
               <td width="7%" class="TituloCabecera">Agosto</td>
               <td width="7%" class="TituloCabecera">Septiembre</td>
               <td width="7%" class="TituloCabecera">Octubre</td>
               <td width="7%" class="TituloCabecera">Noviembre</td>
               <td width="7%" class="TituloCabecera">Diciembre</td>
             </tr>
					 <tr>
					 
             <?
				if($Opcion=='M')
				{
					for($i=1;$i<=12;$i++)
					{
						$Consulta="select t1.valor_ppto from pcip_svp_variacion_inventario_ppto t1 where t1.cod_asignacion='".$Valores[0]."' and t1.cod_area='".$Valores[1]."' and t1.cod_maquila='".$Valores[2]."' and t1.cod_producto='".$Valores[3]."' and t1.ano='".$Valores[4]."'";
						$Consulta.=" and t1.mes='".$i."'";
						$Resp=mysql_query($Consulta);
						$Fila=mysql_fetch_array($Resp);
					//if(!isset($TxtValorMes2))
						$TxtValorMes=$Fila[valor_ppto];
						echo "<td align='center'><input type='text' name='TxtValorMes' value='".$TxtValorMes."' size='6' onkeydown='TeclaPulsada(true)' maxlength='7'></td>";
					}
			   }
			   else
			   {			   
					for($i=1;$i<=12;$i++)
					{
						$Consulta="select valor_ppto from pcip_svp_variacion_inventario_ppto where cod_asignacion='".$Asig."' and cod_area='".$Area."' and cod_maquila='".$Maquila."' and cod_producto='".$Prod."' and ano='".$Ano."' ";
						$Consulta.=" and mes='".$i."'";
						//echo $Consulta;
						$Resp=mysql_query($Consulta);
						$Fila=mysql_fetch_array($Resp);
						//if(!isset($TxtValorMes2))
						$TxtValorMes=$Fila[valor_ppto];
						echo "<td align='center'><input type='text' name='TxtValorMes' value='".$TxtValorMes."' size='6' onkeydown='TeclaPulsada(true)' maxlength='7'></td>";
					}
			   }
			   ?>
					 </tr>
					
           </table></td>
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

</body>
</html>
