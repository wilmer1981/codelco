
<? include("../principal/conectar_pcip_web.php");

    if(!isset($Opc))
		$Opc='GI';

	$Consulta="select max(cod_indicador+1) as maximo from pcip_eec_indicadores ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["maximo"];
	}
	
	if($Opc=='MI')
	 {
	   $TxtCodigo=$Cod;
	   $Consulta="select cod_indicador,nom_indicador,vigente from pcip_eec_indicadores where cod_indicador='".$Cod."'";
	   //echo $Consulta;
	   $Resp=mysql_query($Consulta);
	   if($Fila=mysql_fetch_array($Resp))
	    {
		$Cod=$Fila["cod_indicador"];
		$TxtNuevo=$Fila["nom_indicador"];
		$CmbVig=$Fila["vigente"];
	    }
	 }
	
?>
<html>
<head><title>Nuevo Indicador Sistema </title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function Guardar(Opc)
{
	var f= document.FrmPopupProceso;
	  if (f.TxtNuevo.value=='')
    {
     	alert("Debe ingresar un Indicador")
		f.TxtNuevo.focus();
		return;
	}	
	if (f.CmbVig.value=='-1')
    {
     	alert("Debe seleccionar Vigente")
		f.CmbVig.focus();
		return;
	}	
	f.action = "pcip_mantenedor_asigna_sistemas_por_indicadores_proceso01.php?Opc="+Opc+"&Sistema="+f.TxtCodigo.value+"&Nuevo="+f.TxtNuevo.value+"&Vigente="+f.CmbVig.value;
	f.submit();
	
}
function Eliminar(Cod)
{   
	var f= document.FrmPopupProceso;
		f.action = "pcip_mantenedor_asigna_sistemas_por_indicadores_proceso01.php?Opc=EI&Cod="+Cod;
		f.submit();
}
function Modificar(Cod)
{   
	var f= document.FrmPopupProceso;
		f.action = "pcip_mantenedor_asigna_sistemas_por_indicadores_nuevo_proceso.php?Opc=MI&Cod="+Cod;
		f.submit();
}
function Salir()
{
		window.close();
}

</script>
</head>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<table width="86%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="733" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="60%" align="left"><img src="../pcip_web/archivos/sub_tit_asigna_nuevo_indicador_sistema.png"></td>
       <td width="40%" align="right"><a href="JavaScript:Guardar('<? echo $Opc;?>')"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar Indicador"  border="0" align="absmiddle" /></a>  <a href="JavaScript:Salir()"><img src="../pcip_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center">
	   <table width="100%" border="0" cellpadding="3" cellspacing="0" >
		 <tr>
           <td width="24%" class="formulario2" align="justify">Codigo Indicador</td>
           <td width="76%" class="formulario2" >
		   <input name="TxtCodigo" size="3" maxlength= "4" readonly="" type="text" id="TxtCodigo" value="    <? echo $TxtCodigo; ?>"></td>
         </tr>
		 <tr>
           <td width="24%" class="formulario2" align="justify">Nuevo Indicador</td>
           <td width="76%" class="formulario2" >
		   <input name="TxtNuevo" type="text" value="<? echo $TxtNuevo; ?>" size="50" maxlength="50">
		   </td>
         </tr>
		 <tr>
           <td width="24%" class="formulario2" align="justify">Vigente</td>
           <td width="76%" class="formulario2" ><select name="CmbVig" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbVig==$FilaTC["nombre_subclase"])
						echo "<option selected value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
           </select>
		   </td>
		   
         </tr> <td colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
				 <tr align="center">
				   <td width="5%" class="TituloTablaVerde">Elim.</td>
				   <td width="5%" class="TituloTablaVerde">Modi.</td>
				   <td width="6%" class="TituloTablaVerde">Codigo</td>
				   <td width="82%" class="TituloTablaVerde">Indicadores</td>
				   <td width="7%" class="TituloTablaVerde">Vigente</td>				   
				 </tr>
             <?
		
				$Consulta = "select cod_indicador,nom_indicador,vigente from pcip_eec_indicadores order by cod_indicador";			
				$Resp = mysql_query($Consulta);
				//echo $Consulta;
				    while ($Fila=mysql_fetch_array($Resp))
				    {				
					$Cod=$Fila["cod_indicador"];
					$Ind=$Fila["nom_indicador"];
			        $Vig=$Fila["vigente"]; 
			 ?>
             <tr class="FilaAbeja">
               <td align="center"><a href="JavaScript:Eliminar('<? echo $Cod;?>')" name="Elim"><img src="../pcip_web/archivos/elim_hito.png"  border="0"  alt=" Eliminar " align="absmiddle"></a></td>			    
               <td align="center"><a href="JavaScript:Modificar('<? echo $Cod;?>')" name="Elim"><img src="../pcip_web/archivos/btn_modificar.png"  border="0"  alt=" Modificar " align="absmiddle"></a></td>
               <td align="center"><? echo $Cod; ?></td>
               <td ><? echo $Ind; ?></td>
			   <td  align="center"><? echo $Vig; ?></td>
             </tr>
             <?
			        }
         	 ?>
           </table>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   </td>
   <td width="26" background="../pcip_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="../pcip_web/archivos/images/interior/form_abajo.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="26" height="15"><img src="../pcip_web/archivos/images/interior/esq4.gif" width="15" height="15" /></td>
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