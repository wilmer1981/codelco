
<? include("../principal/conectar_pcip_web.php");
if(!isset($CmbGrupo))
	$CmbGrupo="-1";
?>
<html>
<head>
<title>Relaci�n Productos por Grupos</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Guardar()
{
	var f= document.FrmPopupProceso;
		if(f.CmbGrupo.value=='-1')
		{
			alert("Debe seleccionar Un Grupo");
			f.CmbGrupo.focus();
			return;
		}
		if(f.CmbProducto.value=='-1')
		{
			alert("Debe seleccionar Producto");
			f.CmbProducto.focus();
			return;
		}
		f.action = "pcip_mantenedor_asigna_productos_ventas_por_grupo_proceso01.php?Opc=G&Producto="+f.CmbProducto.value+"&Grupo="+f.CmbGrupo.value;
		f.submit();
	
}
function Eliminar(Cod)
{
	var f= document.FrmPopupProceso;
		f.action = "pcip_mantenedor_asigna_productos_ventas_por_grupo_proceso01.php?Opc=E&Cod="+Cod;
		f.submit();
	
}
function Recarga()
{
    f=document.FrmPopupProceso;
	f.action = "pcip_mantenedor_asigna_productos_ventas_por_grupo.php";
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
	<td width="733" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><img src="../pcip_web/archivos/sub_tit_asigna_productos_por_grupo.png"></td>
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
           <td width="14%" class="formulario2" align="justify">Grupos</td>
           <td width="86%" class="formulario2" ><select name="CmbGrupo" onChange="JavaScript:Recarga()">
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31014' order by cod_subclase ";			
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbGrupo==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
           </select>
           </td>
         </tr>
		 <? 	 
				 $In='';
				 $Consulta = "select t1.cod_producto from pcip_cdv_productos_ventas_por_grupo t1  ";			
				 $Consulta.= " where t1.cod_grupo='".$CmbGrupo."'";
				 //echo $Consulta;
				 $Resp=mysqli_query($link, $Consulta);
				 while ($FilaTC=mysql_fetch_array($Resp))
				 {
					$In=$In."'".$FilaTC["cod_producto"]."',";
				 }
				 if($In<>'')
				 	$In="(".substr($In,0,strlen($In)-1).")";
				 //echo "IN".$In; 
		 ?>		 		 		 
		 <tr>
           <td width="14%" class="formulario2" align="justify">Producto</td>
           <td width="86%" class="formulario2" ><select name="CmbProducto">
				 <option value="-1" selected="selected">Seleccionar</option>
				 <?
					if($CmbGrupo=='-1')
					{
						$Consulta = "select t2.cod_producto,t2.nom_producto from  pcip_cdv_productos_ventas t2 order by t2.nom_producto";
					}
					else
					{
						$Consulta = "select t2.cod_producto,t2.nom_producto from  pcip_cdv_productos_ventas t2 ";
						if($In<>'')
							$Consulta.= " where t2.cod_producto not in $In ";
						$Consulta.= "order by t2.cod_producto ";
					}
					$Resp=mysqli_query($link, $Consulta);
					while ($FilaTC=mysql_fetch_array($Resp))
					{
						if ($CmbProducto==$FilaTC["cod_producto"])
							echo "<option selected value='".$FilaTC["cod_producto"]."'>".$FilaTC["cod_producto"]." ".ucfirst($FilaTC["nom_producto"])."</option>\n";
						else
							echo "<option value='".$FilaTC["cod_producto"]."'>".$FilaTC["cod_producto"]." ".ucfirst($FilaTC["nom_producto"])."</option>\n";
					}	
				 ?>
			   </select>
		   </td>
         </tr>
          <tr>
           <td colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
             <tr align="center">
               <td width="5%" class="TituloTablaVerde">Elim.</td>			   
               <td width="25%" class="TituloTablaVerde">Grupos</td>
               <td width="11%" class="TituloTablaVerde">Codigo</td>
               <td width="49%" class="TituloTablaVerde">Productos</td>
               <td width="10%" class="TituloTablaVerde">Vigente</td>			   
             </tr>
             <?
				$Consulta = "select t1.nom_producto,t1.cod_producto,t3.nombre_subclase,t4.nombre_subclase as nom_vig"; 
				$Consulta.= " from pcip_cdv_productos_ventas t1";
				$Consulta.= " left join pcip_cdv_productos_ventas_por_grupo t2 on t1.cod_producto=t2.cod_producto";
				$Consulta.= " left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31014' and t3.cod_subclase=t2.cod_grupo";
				$Consulta.= " inner join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31007' and t4.cod_subclase=t1.vigente";				
				$Consulta.= " where t3.cod_subclase<>''";
				if($CmbGrupo!='-1')
				       $Consulta.=" and t3.cod_subclase='".$CmbGrupo."'";				
				$Consulta.= " order by t2.cod_grupo and t1.cod_producto";			
				$Resp = mysqli_query($link, $Consulta);
				//echo $Consulta;
				    while ($Fila=mysql_fetch_array($Resp))
				    {
				    $Grupo=$Fila["nombre_subclase"];
					$Cod=$Fila["cod_producto"];
					$Prod=$Fila["nom_producto"];
					$Vigente=$Fila["nom_vig"];
			 ?>
             <tr class="FilaAbeja">
               <td align="center"><a href="JavaScript:Eliminar('<? echo $Cod;?>')"><img src="../pcip_web/archivos/elim_hito.png"  border="0"  alt=" Eliminar " align="absmiddle"></a></td>
               <td align="left"><? echo $Grupo; ?>&nbsp;</td>               
			   <td align="center"><? echo $Cod; ?></td>			   
               <td align="left"><? echo $Prod; ?></td>
               <td align="center"><? echo $Vigente; ?></td>
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