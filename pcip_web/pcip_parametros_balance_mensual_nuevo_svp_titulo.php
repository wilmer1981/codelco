
<? include("../principal/conectar_pcip_web.php");

    if(!isset($Opc))
		$Opc='GI';
	if(!isset($CmbNegocio))
		$CmbNegocio='-1';
	$Consulta="select max(cod_subclase+1) as maximo from proyecto_modernizacion.sub_clase where cod_clase='31057'";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodigo=$Fila["maximo"];
	}
	
	if($Opc=='MI')
	 {
	   $TxtCodigo=$Cod;
	   $Consulta="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31057' and cod_subclase='".$TxtCodigo."'";
	   //echo $Consulta;
	   $Resp=mysql_query($Consulta);
	   if($Fila=mysql_fetch_array($Resp))
	    {
			$TxtCodigo=$Fila["cod_subclase"];
			$TxtNuevo=$Fila["nombre_subclase"];
	    }
	 }
	
?>
<html>
<head><title>Nuevo Titulo Balance </title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function Guardar(Opc)
{
	var f= document.FrmPopupProceso;
	if (f.CmbNegocio.value=='-1')
    {
     	alert("Debe Seleccionar Negocio")
		f.CmbNegocio.focus();
		return;
	}	
    if (f.TxtNuevo.value=='')
    {
     	alert("Debe ingresar Nombre de Titulo")
		f.TxtNuevo.focus();
		return;
	}	
	f.action = "pcip_parametros_balance_mensual_nuevo_svp_proceso01.php?Opcion="+Opc;
	f.submit();	
}
function Recarga()
{   
	var f= document.FrmPopupProceso;
	f.action = "pcip_parametros_balance_mensual_nuevo_svp_titulo.php";
	f.submit();
}
function Eliminar(Cod)
{   
	var f= document.FrmPopupProceso;
		f.action = "pcip_parametros_balance_mensual_nuevo_svp_proceso01.php?Opcion=EI&Cod="+Cod;
		f.submit();
}
function Modificar(Cod)
{   
	var f= document.FrmPopupProceso;
		f.action = "pcip_parametros_balance_mensual_nuevo_svp_titulo.php?Opc=MI&Cod="+Cod;
		f.submit();
}
function Salir()
{
   window.opener.document.FrmPopupProceso.action='pcip_parametros_balance_mensual_nuevo_svp_proceso.php';
   window.opener.document.FrmPopupProceso.submit();
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
       <td width="60%" align="left"><img src="../pcip_web/archivos/n_titulo_balance_mensual.png"></td>
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
           <td width="24%" class="formulario2" align="justify">Codigo</td>
           <td width="76%" class="formulario2" >
		   <input name="TxtCodigo" size="1" maxlength= "4" readonly="" type="text" id="TxtCodigo" value="<? echo $TxtCodigo; ?>"></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Negocio</td>
           <td class="FilaAbeja2">
		   <span class="formulario2">
		   <select name="CmbNegocio" onChange="Recarga('')">
             <option value="-1" selected="selected">Seleccionar</option>
             <?
				$Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31056' order by cod_subclase ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbNegocio==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			?>
           </select>
		   </span><span class="InputRojo">(*)</span>		   
			</td>
         </tr>
		 <tr>
           <td width="24%" class="formulario2" align="justify">Nuevo Titulo</td>
           <td width="76%" class="formulario2" >
		   <input name="TxtNuevo" type="text" value="<? echo $TxtNuevo; ?>" size="50" maxlength="50"><span class="InputRojo">(*)</span>
		   </td>
         </tr>
		<td colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
				 <tr align="center">
				   <td width="5%" class="TituloTablaVerde">Elim.</td>
				   <td width="5%" class="TituloTablaVerde">Modi.</td>
				   <td width="6%" class="TituloTablaVerde">Codigo</td>
				   <td width="40%" class="TituloTablaVerde">Negocio</td>			   
				   <td width="40%" class="TituloTablaVerde">Titulo</td>	
				 </tr>
             <?
		
				$Consulta = "select t1.cod_subclase,t1.nombre_subclase,t2.nombre_subclase as nom_negocio from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.sub_clase t2";
				$Consulta.= " on t1.cod_clase='31057' and  t1.valor_subclase1=t2.cod_subclase where t2.cod_clase='31056'";	
				if($CmbNegocio!='-1')
					$Consulta.= " and t1.valor_subclase1='".$CmbNegocio."'";		
				$Resp = mysql_query($Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{				
					$Cod=$Fila["cod_subclase"];
					$Titulo=$Fila["nombre_subclase"];
					$Negocio=$Fila["nom_negocio"];
					
			 ?>
             <tr class="FilaAbeja">
               <td align="center"><a href="JavaScript:Eliminar('<? echo $Cod;?>')" name="Elim"><img src="../pcip_web/archivos/elim_hito.png"  border="0"  alt=" Eliminar " align="absmiddle"></a></td>			    
               <td align="center"><a href="JavaScript:Modificar('<? echo $Cod;?>')" name="Modi"><img src="../pcip_web/archivos/btn_modificar.png"  border="0"  alt=" Modificar " align="absmiddle"></a></td>
               <td align="center"><? echo $Cod; ?></td>
               <td ><? echo $Negocio; ?></td>
               <td ><? echo $Titulo; ?></td>
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