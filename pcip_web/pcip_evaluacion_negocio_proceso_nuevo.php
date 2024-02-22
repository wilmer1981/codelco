
<? include("../principal/conectar_pcip_web.php");

    if(!isset($Opc))
		$Opc='GI';
		
	if($Opc=='GI')
	{
		if($Opcion=='NREC')
			$Consulta="select max(cod_subclase+1) as maximo from proyecto_modernizacion.sub_clase where cod_clase='31038' ";
		if($Opcion=='NCAR')
			$Consulta="select max(cod_subclase+1) as maximo from proyecto_modernizacion.sub_clase where cod_clase='31039' ";
		if($Opcion=='NCAS')
			$Consulta="select max(cod_subclase+1) as maximo from proyecto_modernizacion.sub_clase where cod_clase='31040' ";
		if($Opcion=='NDES')
			$Consulta="select max(cod_subclase+1) as maximo from proyecto_modernizacion.sub_clase where cod_clase='31036' ";
		if($Opcion=='NLEY')
			$Consulta="select max(cod_subclase+1) as maximo from proyecto_modernizacion.sub_clase where cod_clase='31037' ";	
		if($Opcion=='NPREM')
			$Consulta="select max(cod_subclase+1) as maximo from proyecto_modernizacion.sub_clase where cod_clase='31052' ";	
		//echo $Consulta."<br>";
		$Resp=mysql_query($Consulta);		
		if($Fila=mysql_fetch_array($Resp))
		{
			$TxtCodigo=$Fila["maximo"];
		}
	}	
	if($Opc=='MI')
	 {	 
	   //echo $Codigo."<br>";
   	   $Consulta1="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='".$CodClase."' and cod_subclase='".$Cod."'";
	   //echo $Consulta;
	   $Resp1=mysql_query($Consulta1);
	   if($Fila1=mysql_fetch_array($Resp1))
		{
			$TxtCodigo=$Fila1["cod_subclase"];
			$TxtNuevo=$Fila1["nombre_subclase"];
		}
	 }
	
?>
<html>
<head><title>Nuevos Ingresos</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="JavaScript">
var popup=0;
function ProcesoAsig()
{
	//alert(Opc);
	URL="pcip_evaluacion_negocio_proceso_asig.php";
	opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=720,height=350,scrollbars=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 640)/2,0);
}
function Guardar(Opc,Cod,CodClase)
{
	if(Opc=='GI')
	{
		var f= document.FrmPopupProceso;
		if (f.TxtNuevo.value=='')
		{
			alert("Debe ingresar Nombre")
			f.TxtNuevo.focus();
			return;
		}	
		f.action = "pcip_evaluacion_negocio_proceso_nuevo01.php?Opc="+Opc+"&Codigo="+f.TxtCodigo.value+"&Nuevo="+f.TxtNuevo.value+"&Opcion="+f.Opcion.value;
		f.submit();	
	}
	else
	{
		var f= document.FrmPopupProceso;
		if (f.TxtNuevo.value=='')
		{
			alert("Debe ingresar Nombre")
			f.TxtNuevo.focus();
			return;
		}	
		f.action = "pcip_evaluacion_negocio_proceso_nuevo01.php?Opc="+Opc+"&Codigo="+f.TxtCodigo.value+"&Nuevo="+f.TxtNuevo.value+"&Cod="+Cod+"&CodClase="+CodClase;
		f.submit();	
	}
}

function Eliminar(Cod,CodClase)
{   
	var f= document.FrmPopupProceso;
	f.action = "pcip_evaluacion_negocio_proceso_nuevo01.php?Opc=E&Cod="+Cod+"&CodClase="+CodClase;
	f.submit();
}
function Modificar(Cod,CodClase)
{   
	var f= document.FrmPopupProceso;
	f.action = "pcip_evaluacion_negocio_proceso_nuevo.php?Opc=MI&Cod="+Cod+"&CodClase="+CodClase;
	f.submit();
}
function Salir()
{
   var f= document.FrmPopupProceso;
   window.opener.document.FrmPopupProceso.action='pcip_evaluacion_negocio_proceso.php?Ptl='+f.Ptl.value+'&'+f.ProcesoAbierto.value+'=S';
   window.opener.document.FrmPopupProceso.submit();
   window.close();
}

</script>
</head>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<input type="hidden" name="Opcion" value="<? echo $Opcion;?>">
<input type="hidden" name="Ptl" value="<? echo $Ptl;?>">
<input type="hidden" name="ProcesoAbierto" value="<? echo $ProcesoAbierto;?>">
<table width="71%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="733" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="60%" align="left"><img src="../pcip_web/archivos/sub_tit_evaluacion_negocio_n_m.png"></td>
       <td width="40%" align="right">
	   <? if($Opcion=='NCAR')
	   {
	   ?>
	   <a href="JavaScript:ProcesoAsig('')"><img src="archivos/asignar_unidad.png"  alt="Asignar Unidad a Cargo" align="absmiddle" border="0" /></a> 
	   <?
	   }
	   ?>
	   <a href="JavaScript:Guardar('<? echo $Opc;?>','<? echo $Cod;?>','<? echo $CodClase;?>')"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar Registro"  border="0" align="absmiddle" /></a>  
	   <a href="JavaScript:Salir()"><img src="../pcip_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
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
           <td width="30%" class="formulario2" align="justify">Codigo</td>
           <td width="70%" class="formulario2" >
		   <input name="TxtCodigo" size="3" maxlength= "4" readonly="" type="text" id="TxtCodigo" value="<? echo $TxtCodigo; ?>"></td>
         </tr>
		 <?
		  if($Opcion=='NREC')
				$Nombre='Nombre Recuperación';
		  if($Opcion=='NCAR')
		  		$Nombre='Nombre Cargo';	
		  if($Opcion=='NCON')
		  		$Nombre='Nombre Contable';	
		  if($Opcion=='NCAS')
		  		$Nombre='Nombre Castigo';	
		  if($Opcion=='NDES')
		  		$Nombre='Origen - Destino';	
		  if($Opcion=='NLEY')
		  		$Nombre='Nombre Ley';	
		  if($Opcion=='NPREM')
		  		$Nombre='Nombre Premio';	
		 ?>
		 <tr>
           <td width="30%" class="formulario2" align="justify"><? echo $Nombre;?></td>
           <td width="70%" class="formulario2" >
		   <input name="TxtNuevo" type="text" value="<? echo $TxtNuevo; ?>" size="50" maxlength="50">
		   </td>
         </tr>
		 <td colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
				 <tr align="center">
				   <td width="5%" class="TituloTablaVerde">Elim.</td>
				   <td width="5%" class="TituloTablaVerde">Modi.</td>
				   <td width="6%" class="TituloTablaVerde">Codigo</td>
				   <td width="82%" class="TituloTablaVerde">Código</td>
				 </tr>
             <?			 
				if($Opcion=='NREC')
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='31038' order by cod_subclase";	 
				if($Opcion=='NCAR')
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='31039' order by cod_subclase";
				if($Opcion=='NCAS')
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='31040' and cod_subclase not in ('1','2','3') order by cod_subclase";
				if($Opcion=='NDES')
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='31036' order by cod_subclase";
				if($Opcion=='NLEY')
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='31037' order by cod_subclase";
				if($Opcion=='NPREM')
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='31052' order by cod_subclase";
				$Resp = mysql_query($Consulta);
				//echo $Consulta;
				while ($Fila=mysql_fetch_array($Resp))
				{
				    $CodClase=$Fila["cod_clase"];				
					$Cod=$Fila["cod_subclase"];
					$Nombre=$Fila["nombre_subclase"];
				 ?>
				 <tr class="FilaAbeja">
				   <?
				    if(($CodClase=='31038'&&($Cod=='3'||$Cod=='4'))||($CodClase=='31039'&&($Cod=='2'||$Cod=='3'||$Cod=='4'||$Cod=='5'||$Cod=='6'||$Cod=='7'||$Cod=='8'||$Cod=='9'||$Cod=='10'))||($CodClase=='31040'&&($Cod=='4'||$Cod=='5'||$Cod=='6'||$Cod=='7')))
				   		echo "<td align='center'>&nbsp;</td>";
				    else
				    {		
				   ?>
				   <td align="center"><a href="JavaScript:Eliminar('<? echo $Cod;?>','<? echo $CodClase;?>')" name="Elim"><img src="../pcip_web/archivos/elim_hito.png"  border="0"  alt=" Eliminar " align="absmiddle"></a></td>			    
				   <?
				  	}
				   ?>
				   <td align="center"><a href="JavaScript:Modificar('<? echo $Cod;?>','<? echo $CodClase;?>')" name="Elim"><img src="../pcip_web/archivos/btn_modificar.png"  border="0"  alt=" Modificar " align="absmiddle"></a></td>
				   <td align="center"><? echo $Cod; ?></td>
				   <td ><? echo $Nombre; ?></td>
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
	if ($Mensaje!='')
		echo "alert('".$Mensaje."');";
	echo "</script>";
?>