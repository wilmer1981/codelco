
<? include("../principal/conectar_pcip_web.php");

    if(!isset($Opc))
		$Opc='GI';
		
	if($Opc=='GI')
	{
		$Consulta="select max(corr+1) as maximo from pcip_eva_asig_cargo_unidad ";
		$Resp=mysql_query($Consulta);		
		if($Fila=mysql_fetch_array($Resp))
		{
			$TxtCodigo=$Fila["maximo"];
		}
	}	
	if($Opc=='MI')
	 {	 
	   //echo $Codigo."<br>";
   	   $Consulta1="select * from pcip_eva_asig_cargo_unidad t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31039'";
	   $Consulta1.=" and t1.cod_cargo=t2.cod_subclase where corr='".$Corr."' and cod_cargo='".$Cod."'";
	   echo $Consulta;
	   $Resp1=mysql_query($Consulta1);
	   if($Fila1=mysql_fetch_array($Resp1))
		{
			$TxtCodigo=$Fila1["corr"];
			$NomCargo=$Fila1["nombre_subclase"];
			$CmbCargo=$Fila1["cod_cargo"];
			$CmbUnidad2=$Fila1["cod_unidad"];
		}
	 }
	
?>
<html>
<head><title>Nueva Asignación de Unidad con Cargo</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function Guardar(Opc)
{
	if(Opc=='GI')
	{
		var f= document.FrmPopupProceso;
		if (f.CmbCargo.value=='-1')
		{
			alert("Debe Seleccionar un Cargo")
			f.CmbCargo.focus();
			return;
		}	
		if (f.CmbUnidad2.value=='T')
		{
			alert("Debe Seleccionar una Unidad")
			f.CmbUnidad2.focus();
			return;
		}	
		f.action = "pcip_evaluacion_negocio_proceso_asig01.php?Opc="+Opc+"&CmbCargo="+f.CmbCargo.value+"&CmbUnidad2="+f.CmbUnidad2.value;
		f.submit();	
	}
	else
	{
		var f= document.FrmPopupProceso;
		f.action = "pcip_evaluacion_negocio_proceso_asig01.php?Opc="+Opc+"&Codigo="+f.TxtCodigo.value+"&CmbCargo="+f.CmbCargo.value+"&CmbUnidad2="+f.CmbUnidad2.value;
		f.submit();	
	}
}
function Recarga()
{   
	var f= document.FrmPopupProceso;
	f.action = "pcip_evaluacion_negocio_proceso_asig.php";
	f.submit();
}
function Eliminar(Corr,Cod)
{   
	var f= document.FrmPopupProceso;
	f.action = "pcip_evaluacion_negocio_proceso_asig01.php?Opc=E&Cod="+Cod+"&Corr="+Corr;
	f.submit();
}
function Modificar(Corr,Cod)
{   
	var f= document.FrmPopupProceso;
	f.action = "pcip_evaluacion_negocio_proceso_asig.php?Opc=MI&Cod="+Cod+"&Corr="+Corr;
	f.submit();
}
function Salir()
{
   var f= document.FrmPopupProceso;
   window.opener.document.FrmPopupProceso.action='pcip_evaluacion_negocio_proceso_nuevo.php';
   window.opener.document.FrmPopupProceso.submit();
   window.close();
}

</script>
</head>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="TxtCodigo" value="<? echo $TxtCodigo;?>">
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
	   <a href="JavaScript:Guardar('<? echo $Opc;?>')"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar Registro"  border="0" align="absmiddle" /></a>  
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
           <td width="30%" class="formulario2" align="justify">Cargo</td>
           <td width="70%" class="formulario2" >
		   <? if($Opc!='MI')
		   {
		   ?>
		   <select name="CmbCargo" onChange="JavaScript:Recarga('')">
			 <option value="-1" selected="selected" class="Selected">Seleccionar</option>
			 <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31039' ";			
				$Resp=mysql_query($Consulta);		
				while ($Fila=mysql_fetch_array($Resp))
				{
					if ($CmbCargo==$Fila["cod_subclase"])
						echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					else
						echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
				}
				?>
		   </select>
		  <?
		   } 
		  	else
			{
				echo "<input type='hidden' name='CmbCargo' value='".$CmbCargo."'>";
		  		echo $NomCargo;
			}
		  ?>	
		  </td>	
         </tr>
		 <tr>
           <td width="30%" class="formulario2" align="justify">Unidad</td>
           <td width="70%" class="formulario2" >
		  <select name="CmbUnidad2">
			 <option value="T" class="Selected">Seleccionar</option>
			 <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31051' and cod_subclase in('1','2','3','4','5','8','15','16','17','18','22','23') ";			
				$Resp=mysql_query($Consulta);		
				while ($Fila=mysql_fetch_array($Resp))
				{
					if ($CmbUnidad2==$Fila["cod_subclase"])
						echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					else
						echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";																												
				}
				?>
			 </select>
		   </td>
         </tr>
		 <td colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
				 <tr align="center">
				   <td width="5%" class="TituloTablaVerde">Elim.</td>
				   <td width="5%" class="TituloTablaVerde">Modi.</td>
				   <td width="82%" class="TituloTablaVerde">Cargo</td>
				   <td width="6%" class="TituloTablaVerde">Unidad</td>
				 </tr>
             <?			 

				$ConsultaMostrar = "select t1.corr,t1.cod_cargo,t2.nombre_subclase as nom_cargo,t3.nombre_subclase as nom_unidad from pcip_eva_asig_cargo_unidad t1 ";
				$ConsultaMostrar.= " inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31039' and t1.cod_cargo=t2.cod_subclase";
				$ConsultaMostrar.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase";
				$ConsultaMostrar.= " where t1.cod_cargo<>''";
				if($CmbCargo!='-1')
					$ConsultaMostrar.= " and t1.cod_cargo='".$CmbCargo."' order by corr";
				$RespMostrar = mysql_query($ConsultaMostrar);
				//echo $ConsultaMostrar;
				while ($FilaMostrar=mysql_fetch_array($RespMostrar))
				{
					$Corr=$FilaMostrar["corr"];
				    $NomCargo=$FilaMostrar["nom_cargo"];
					$NomUni=$FilaMostrar["nom_unidad"];
					$Cod=$FilaMostrar["cod_cargo"];
					$Nombre=$FilaMostrar["nombre_subclase"];
				 ?>
				 <tr class="FilaAbeja">
				   <td align="center"><a href="JavaScript:Eliminar('<? echo $Corr;?>','<? echo $Cod;?>')" name="Elim"><img src="../pcip_web/archivos/elim_hito.png"  border="0"  alt=" Eliminar " align="absmiddle"></a></td>			    
				   <td align="center"><a href="JavaScript:Modificar('<? echo $Corr;?>','<? echo $Cod;?>')" name="Elim"><img src="../pcip_web/archivos/btn_modificar.png"  border="0"  alt=" Modificar " align="absmiddle"></a></td>
				   <td align="center"><? echo $NomCargo; ?></td>
				   <td align="center"><? echo $NomUni; ?></td>
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