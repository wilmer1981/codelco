
<? include("../principal/conectar_pcip_web.php");

?>
<html>
<head><title>Asignaci�n Producto SAP a Material SVP</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function Guardar()
{
	var f= document.FrmPopupProceso;
	
	if(f.CmbProd.value=='-1')
	{
		alert('Debe Seleccionar Producto SVP');
		f.CmbProd.focus();
		return;
	}
	if(f.CmbMaterial.value=='-1')
	{
		alert('Debe Seleccionar Material');
		f.CmbMaterial.focus();
		return;
	}
	if(f.CmbTipoMov.value=='-1')
	{
		alert('Debe Seleccionar Tipo Movimiento');
		f.CmbTipoMov.focus();
		return;
	}
	f.action = "pcip_mantenedor_asigna_prodsap_matsvp01.php?Opc=G&CmbProd="+f.CmbProd.value+"&CmbMaterial="+f.CmbMaterial.value;
	f.submit();
	
}
function Eliminar(Cod)
{   
	var f= document.FrmPopupProceso;
		f.action = "pcip_mantenedor_asigna_prodsap_matsvp01.php?Opc=E&Cod="+Cod;
		f.submit();
	
}
function Recarga()
{
		f=document.FrmPopupProceso;
		f.action = "pcip_mantenedor_asigna_prodsap_matsvp.php";
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
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="733" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><img src="../pcip_web/archivos/sub_tit_asigna_prod_sap_matsvp.png"></td>
       <td align="right"><a href="JavaScript:Guardar()"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="../pcip_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
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
           <td width="20%" class="formulario2" align="justify">Producto SAP </td>
           <td width="80%" class="formulario2" ><select name="CmbProd" onChange="Recarga()">
             <option value="-1" selected="selected">Seleccionar</option>
             <?
	  $Consulta = "select * from pcip_svp_productos_sap order by cod_sap ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbProd==$FilaTC["cod_sap"])
				echo "<option selected value='".$FilaTC["cod_sap"]."'>".str_pad($FilaTC["cod_sap"],3,'0',STR_PAD_LEFT)."&nbsp;&nbsp;".ucfirst($FilaTC["nom_sap"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_sap"]."'>".str_pad($FilaTC["cod_sap"],3,'0',STR_PAD_LEFT)."&nbsp;&nbsp;".ucfirst($FilaTC["nom_sap"])."</option>\n";
		}
			?>
           </select>
             <span class="formulariosimple"><span class="InputRojo">(*)</span></span></td>
		 </tr>
		 <tr>
           <td width="20%" class="formulario2" align="justify">Material SVP </td>
           <td width="80%" class="formulario2" ><select name="CmbMaterial">
             <option value="-1" selected="selected">Seleccionar</option>
             <?
			  	$Consulta = "select * from pcip_svp_materiales ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbMaterial==$FilaTC["MAcodigo"])
						echo "<option selected value='".$FilaTC["MAcodigo"]."'>Mat: ".str_pad($FilaTC["MAcodigo"],5,'0',STR_PAD_LEFT)."&nbsp;&nbsp;Orden: ".str_pad($FilaTC["MAorden"],4,'0',STR_PAD_LEFT)."&nbsp;&nbsp;".ucfirst($FilaTC["MAdescripcion"])."</option>\n";
					else
						echo "<option value='".$FilaTC["MAcodigo"]."'>Mat: ".str_pad($FilaTC["MAcodigo"],5,'0',STR_PAD_LEFT)."&nbsp;&nbsp;Orden: ".str_pad($FilaTC["MAorden"],4,'0',STR_PAD_LEFT)."&nbsp;&nbsp;".ucfirst($FilaTC["MAdescripcion"])."</option>\n";
				}
			?>
           </select>
             <span class="formulariosimple"><span class="InputRojo">(*)</span></span></td>
		 </tr>
		 <tr>
           <td width="20%" class="formulario2" align="justify">Tipo Movimiento </td>
           <td width="80%" class="formulario2" ><span class="formulariosimple">
             <select name="CmbTipoMov">
			 <option value="-1" selected="selected">Seleccionar</option>
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31043' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbTipoMov==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
             </select>
             <span class="InputRojo">(*)</span></span></td>
		 </tr>

          <tr>
           <td colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
				 <tr align="center">
				   <td width="8%" class="TituloTablaVerde">Elim.</td>
				   <td width="8%" class="TituloTablaVerde">Codigo</td>
				   <td width="34%" class="TituloTablaVerde">Descripci�n</td>
				   <td width="20%" class="TituloTablaVerde">Orden SVP</td>
				   <td width="30%" class="TituloTablaVerde">Tipo Inventario SVP(Vtpm)</td>
				 </tr>
             <?
		
				$Consulta = "select t1.RMmaterial,t2.MAcodigo,t2.MAdescripcion,t2.MAorden,t3.nombre_subclase as TipoMov from pcip_svp_relmateriales t1 inner join pcip_svp_materiales t2 on t1.RMmaterial=t2.MAcodigo ";
				$Consulta.= "inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31043' and t3.cod_subclase=t1.tipo_movimiento_svp ";
				$Consulta.= "where t1.RMmaterialequivalente='".$CmbProd."' order by t2.MAorden";
				$Resp = mysql_query($Consulta);
				//echo $Consulta;
				    while ($Fila=mysql_fetch_array($Resp))
				    {
				
					$Cod=$Fila["MAcodigo"];
					$Descrip=$Fila["MAdescripcion"];
					$Orden=$Fila["MAorden"];
					$Vtmp=$Fila["TipoMov"];
			 ?>
             <tr class="FilaAbeja">
               <td align="center"><a href="JavaScript:Eliminar('<? echo $Cod;?>')"><img src="../pcip_web/archivos/elim_hito.png"  border="0"  alt=" Eliminar " align="absmiddle"></a></td>
               <td align="center"><? echo $Cod; ?></td>
               <td ><? echo $Descrip; ?></td>
			   <td ><? echo $Orden; ?></td>
			   <td ><? echo str_replace(' -',', ',$Vtmp); ?></td>
             </tr>
             <?
			          
					}
			
         	 ?>
           </table></td>
          </tr>
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