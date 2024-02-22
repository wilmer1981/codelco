
<? include("../principal/conectar_pcip_web.php");

?>
<html>
<head>
<title>Asigna Productos por Proveedores Clientes</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function Guardar()
{
	var f= document.FrmPopupProceso;
		f.action = "pcip_mantenedor_asigna_productos_proveedor_proceso01.php?Opc=G&Proveedor="+f.CmbProveedor.value+"&Producto="+f.CmbProducto.value;
		f.submit();
	
}
function Eliminar(Cod)
{
	var f= document.FrmPopupProceso;
		f.action = "pcip_mantenedor_asigna_productos_proveedor_proceso01.php?Opc=E&Cod="+Cod;
		f.submit();
	
}
function Recarga()
{
    f=document.FrmPopupProceso;
	f.action = "pcip_mantenedor_asigna_productos_proveedor.php";
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
<table width="89%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="831" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><img src="../pcip_web/archivos/sub_tit_asigna_productos_por_proveedor.png"></td>
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
           <td width="18%" class="formulario2" align="justify">Rut Proveedor</td>
           <td width="82%" class="formulario2" ><select name="CmbProveedor" onChange="Recarga()">
			  <option value="-1" selected="selected">Seleccionar</option>
			  <?
			  $Consulta = "select rut_proveedor,nom_proveedor from pcip_fac_proveedores order by rut_proveedor ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbProveedor==$FilaTC["rut_proveedor"])
						echo "<option selected value='".$FilaTC["rut_proveedor"]."'>".ucfirst($FilaTC["rut_proveedor"])." ".ucfirst($FilaTC["nom_proveedor"])."</option>\n";
					else
						echo "<option value='".$FilaTC["rut_proveedor"]."'>".ucfirst($FilaTC["rut_proveedor"])." ".ucfirst($FilaTC["nom_proveedor"])."</option>\n";
				}
			   ?>
			</select></td>
         </tr>
		 <? 	 
				 $Consulta = "select t1.cod_producto from pcip_fac_productos_por_proveedores t1  ";			
				 $Consulta.= " where t1.rut_proveedor='".$CmbProveedor."'";
					$Resp=mysql_query($Consulta);
						while ($FilaTC=mysql_fetch_array($Resp))
						{
							$In=$In."'".$FilaTC["cod_producto"]."',";
						
						}
				 
				 $In="(".substr($In,0,strlen($In)-1).")";
				 //echo "IN".$In; 
		 ?>		 
		 <tr>
           <td width="18%" class="formulario2" align="justify">Producto</td>
           <td width="82%" class="formulario2" ><select name="CmbProducto">
			<option value="-1" selected="selected">Seleccionar</option>
			    <?
				if($CmbProveedor=='-1')
				{
					$Consulta = "select t2.cod_producto,t2.nom_producto from  pcip_fac_productos_facturas t2 order by t2.nom_producto";
				}
				else
				{
					$Consulta = "select t2.cod_producto,t2.nom_producto from  pcip_fac_productos_facturas t2 ";
					if(strlen($In)>4)
					$Consulta.= " where  t2.cod_producto not in $In ";
					$Consulta.= "order by t2.nom_producto ";
				}
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbProducto==$FilaTC["cod_producto"])
						echo "<option selected value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nom_producto"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nom_producto"])."</option>\n";
				}	
				?>
		  </select><? //echo $Consulta;?></td>
         </tr>
          <tr>
           <td colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
             <tr align="center">
               <td width="5%" class="TituloTablaVerde">Elim.</td>
               <td width="14%" class="TituloTablaVerde">Cod. Producto</td>
               <td width="37%" class="TituloTablaVerde">Producto</td>
               <td width="14%" class="TituloTablaVerde">Rut Proveedor</td>
               <td width="30%" class="TituloTablaVerde">Nombre Proveedor</td>			   
             </tr>
             <?
		
				$Consulta = "select t1.cod_producto,t2.nom_producto,t1.rut_proveedor,t3.nom_proveedor from pcip_fac_productos_por_proveedores ";
				$Consulta.= " t1 inner join pcip_fac_productos_facturas t2 on t1.cod_producto=t2.cod_producto inner join pcip_fac_proveedores t3";
				$Consulta.= " on t1.rut_proveedor=t3.rut_proveedor where t1.rut_proveedor='".$CmbProveedor."' order by t1.rut_proveedor";			
				$Resp = mysql_query($Consulta);
				//echo $Consulta;
				    while ($Fila=mysql_fetch_array($Resp))
				    {				
					$Cod=$Fila["cod_producto"];
					$Producto=$Fila["nom_producto"];
					$Rut=$Fila["rut_proveedor"];
					$Nom=$Fila["nom_proveedor"];					
			 ?>
             <tr class="FilaAbeja">
               <td align="center"><a href="JavaScript:Eliminar('<? echo $Cod;?>')"><img src="../pcip_web/archivos/elim_hito.png"  border="0"  alt=" Eliminar " align="absmiddle"></a></td>
               <td align="center"><? echo $Cod; ?></td>
               <td ><? echo $Producto; ?></td>
               <td ><? echo $Rut; ?></td>
               <td ><? echo $Nom; ?></td>			   
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
   <td width="16" background="../pcip_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="17" height="15"><img src="../pcip_web/archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="../pcip_web/archivos/images/interior/form_abajo.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="16" height="15"><img src="../pcip_web/archivos/images/interior/esq4.gif" width="15" height="15" /></td>
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