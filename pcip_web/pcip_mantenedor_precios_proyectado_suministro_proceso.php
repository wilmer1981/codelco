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
	    $Consulta = "select nom_agrupacion from pcip_eec_suministros_grupos where cod_suministro_grupo='".$Cod[0]."'";			
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$GrupoSuministro=$Fila[nom_agrupacion];
	    $Consulta = "select nom_suministro from pcip_eec_suministros where cod_suministro='".$Cod[1]."'";			
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Suministro=$Fila[nom_suministro];
		$Ano=$Cod[2];
	}
	else
	{
	
	}
}	
?>
<html>
<head>
<?
	if ($Opcion=='N')
		echo "<title>Nuevo Precio Pre-Suministro</title>";
	else	
		echo "<title>Modifica Precio Pre-Suministro</title>";
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
					Valores=Valores+f.TxtValorMes[i].value+"~~";
				}
				Valores=Valores.substr(0,Valores.length-2);
				f.action = "pcip_mantenedor_precios_proyectado_suministro_proceso01.php?Opcion="+Opcion+"&Valores="+Valores;
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			for (i=0;i<f.TxtValorMes.length;i++)
			{
				Valores=Valores+f.TxtValorMes[i].value+"~~";
			}
			Valores=Valores.substr(0,Valores.length-2);
			f.action = "pcip_mantenedor_precios_proyectado_suministro_proceso01.php?Opcion="+Opcion+"&Valores="+Valores;
			f.submit();
		break;
		case "NI":
			f.Opcion.value='N';
			f.action = "pcip_mantenedor_precios_proyectado_suministro_proceso.php?Opcion=N";
			f.submit();
		break;

		case "R":	
			f.action = "pcip_mantenedor_precios_proyectado_suministro_proceso.php?Recarga=S";
			f.submit();
		break;
	}
}
function Salir()
{
	window.close();
}
/*function TeclaPulsada(tecla) 
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
} */
function ValidaCampos()
{
	var f= document.FrmPopupProceso;
	var Res=true;

	if(f.CmbGrupoSuministro.value=='-1')
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
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_precio_suministro_n.png" width="450" height="40"><? }else{?><img src="archivos/sub_tit_precio_suministro_m.png" width="450" height="40"><? }?></td>
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
           <td width="180" class="formulario2">Grupo Suministro</td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <select name="CmbGrupoSuministro" onChange="Proceso('R')">
             <option value="-1" class="NoSelec">Seleccionar</option>
             <?
	  $Consulta = "select * from pcip_eec_suministros_grupos where cod_suministro_grupo not in ('4','5') order by nom_agrupacion ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbGrupoSuministro==$FilaTC["cod_suministro_grupo"])
				echo "<option selected value='".$FilaTC["cod_suministro_grupo"]."'>".ucfirst($FilaTC["nom_agrupacion"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_suministro_grupo"]."'>".ucfirst($FilaTC["nom_agrupacion"])."</option>\n";
		}
			?>
           </select>
		   <span class="InputRojo">(*)</span>
		   <?
		   }
		   else
		   		echo "<span class='formulario2'>".$GrupoSuministro."</span>";	
		   ?>		   </td>
         </tr>
         <tr>
           <td height="33" class="formulario2">Suministro</td>
           <td width="387" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbSuministro" onChange="Proceso('R')">
             <option value="-1" class="NoSelec">Seleccionar</option>
             <?
	    $Consulta = "select t1.cod_suministro,t2.nom_suministro,t2.cod_unidad from pcip_eec_suministros_por_grupos t1 inner join pcip_eec_suministros t2 on t1.cod_suministro=t2.cod_suministro ";
	    $Consulta.= "where t1.cod_suministro_grupo='".$CmbGrupoSuministro."' order by t2.nom_suministro ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbSuministro==$FilaTC["cod_suministro"])
			{
				echo "<option selected value='".$FilaTC["cod_suministro"]."'>".ucfirst($FilaTC["nom_suministro"])."</option>\n";
				$Unidad=$FilaTC["cod_unidad"];
			}
			else
				echo "<option value='".$FilaTC["cod_suministro"]."'>".ucfirst($FilaTC["nom_suministro"])."</option>\n";
		}
			?>
           </select><? //echo $Consulta;?>
		   </span>		   <?
		   }
		   else
		   		echo "<span class='formulario2'>".$Suministro."</span>";	
		   ?>		   </td>
           <td width="462" colspan="2" class="FilaAbeja2" >&nbsp;</td>
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
				echo "<span class='formulario2'>".$Ano."</span>";	
		   ?>		   </td>
         </tr>

         <tr>
           <td colspan="4" class='formulario2'><table width="100%" border="1" cellpadding="4" cellspacing="0" >
             <tr>
               <td colspan="13" align="center" class="TituloTablaNaranja">Valores a Ingresar [<? echo $Unidad;?>]</td>
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
             <?
				if($Opcion=='M')
				{
					 for($i=1;$i<=12;$i++)
					 {
						$Consulta="select * from pcip_eec_suministros_detalle where cod_suministro='".$Cod[1]."' and  ano='".$Cod[2]."' and mes='".$i."' and tipo='V'";	
						$RespMes=mysql_query($Consulta);
						if($FilaMes=mysql_fetch_array($RespMes))
						{
						?>	
						<td align="right"><input type='text' name='TxtValorMes' value='<? echo number_format($FilaMes[valor],2,',','');?>' size='6' onkeydown='TeclaPulsada(true)' maxlength="7"></td>
						<?
						}else{		
						?>
						<td><input type='text' name='TxtValorMes' value='' size='6' onkeydown='TeclaPulsada(true)' maxlength="7"></td>
						<?
						}	
					 }
			   }
			   else
			   {
			   		echo "<tr>";
					for($i=1;$i<=12;$i++)
					{
						echo "<td align='center'><input type='text' name='TxtValorMes' value='' size='6' onkeydown='TeclaPulsada(true)' maxlength='7'></td>";
					}
			   		echo "</tr>";
			   }
			   ?>
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
<? 
echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Precios de Sumistro Ingresados Correctamente');";
	echo "</script>";
?>
</body>
</html>
