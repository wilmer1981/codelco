<?
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

?>
<html>
<head>
<title>Mantenedor Deducciones</title>
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="javascript">

function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "R":	
			f.action = "pcip_mantenedor_ingresos_proyectados.php?Recarga=S";
			f.submit();
		break;
		case "N":
			if (f.CmbProducto.value=="-1")
			{
				alert("Debe Seleccionar Producto");
				f.CmbProducto.focus();
				return;
			}		
			var Valores2='';
			for (i=1;i<f.elements.length;i++)
			{
				if(f.elements[i].name=='CodDeduc')
					Valores2 = Valores2+f.elements[i].value+"~"+f.elements[i+1].value+"~"+f.elements[i+2].value+"~"+f.elements[i+3].value+"//";
			}
			if(Valores2!='')
		    Valores2=Valores2.substr(0,Valores2.length-2);				
			//alert(Valores2);
			f.action= "pcip_mantenedor_ingresos_proyectados_proceso01.php?Opc="+Opc+"&Valores2="+Valores2;
			f.submit();			   							
		break;
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=14";
		break;
	}	
}

</script>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">

<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'mant_deducciones.png')
 ?>
   <table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
      <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="../pcip_web/archivos/images/interior/form_arriba.png"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq2em.png" width="15" height="15" /></td>
      </tr>
    <tr>
      <td width="15" background="../pcip_web/archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td>
		<table width="100%" cellpadding="2" cellspacing="0">
		  <tr>
				<td width="19%" align="left" class='formulario2'><img src="../pcip_web/archivos/images/interior/t_buscadorGlobal4.png"></td>
	            <td align="right" class='formulario2'>
				<!--<a href="JavaScript:Proceso('Prov')"><img src="archivos/btn_carga.gif" border="0"></a> -->
			    <a href="JavaScript:Proceso('N')"><img src="../pcip_web/archivos/btn_guardar.png"  border="0"  alt="Nuevo/Modificar" align="absmiddle" /></a>&nbsp;<a href="JavaScript:Proceso('S')"><img src="../pcip_web/archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>		    </td>
		  </tr>
			<tr>
			<td width="19%" height="17" class='formulario2'>Producto</td>
			<td class="formulario2" ><select name="CmbProducto" onChange="Proceso('R')">
			<option value="-1" class="NoSelec">Seleccionar</option>
			<?
			$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31021' and cod_subclase not in ('7')";			
			$Resp=mysqli_query($link, $Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbProducto==$FilaTC["cod_subclase"])
					echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				else
					echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			}
			?>
			</select>			</tr>
			<tr>
			<td height="25" class="formulario2">A&ntilde;o</td>
			<td class="FilaAbeja2">	  
			<span class="formulario2">
			<select name="Ano" id="Ano" onChange="Proceso('R')">
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
			</span>			</tr>
	   </table>   
	</td>
      <td width="15" background="../pcip_web/archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="../pcip_web/archivos/images/interior/form_abajo.png"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
  <br>	
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
  <td><img src="../pcip_web/archivos/images/interior/esq1em.gif" width="15" /></td>
  <td width="920" background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" /></td>
  <td ><img src="../pcip_web/archivos/images/interior/esq2em.gif" width="15" /></td>
   	</tr>
      <tr>
       <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td align="center">  
	    <table width="930" border="1" cellpadding="4" cellspacing="0" >
     
	  <tr align="center">
          <td width="25%" class="TituloTablaVerde">Nombre Producto</td>
          <td width="25%" class="TituloTablaVerde">Deducci�n</td>
<?
	$Consulta = "select t3.valor_pena,t2.cod_subclase,t3.ano,t1.nombre_subclase as nom_prod,t2.nombre_subclase as nom_deduccion,t2.cod_subclase as codProveedor,t3.valor,t3.unidad ";
	$Consulta.= " from proyecto_modernizacion.sub_clase t1 ";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31022' and t1.cod_subclase=t2.valor_subclase2";
	$Consulta.= " left join pcip_inp_precios t3 on t2.valor_subclase2=t3.cod_producto and t2.cod_subclase =t3.cod_deduccion and t3.ano='".$Ano."'";
	$Consulta.= " where t1.cod_clase='31021' and t1.cod_subclase<>''";
		$Consulta.=" and t1.cod_subclase='".$CmbProducto."'";
	$Consulta.= " order by t1.cod_subclase ";
	$Resp = mysqli_query($link, $Consulta);
	//echo $Consulta;
	echo "<input name='CheckTipoDoc' type='hidden'  value=''>";	
	while ($Fila=mysql_fetch_array($Resp))
	{
		if($CmbProducto=='1')
			$Colspan='2';
		else
			$Colspan='1';	
	}
?>		  
          <td width="15%" class="TituloTablaVerde" colspan="<? echo $Colspan;?>">Valor</td>
		  <td width="15%" class="TituloTablaVerde">Unidad</td>
	  </tr>
<?
if($Recarga=='S')
{
	$Consulta = "select t3.valor_pena,t2.cod_subclase,t3.ano,t1.nombre_subclase as nom_prod,t2.nombre_subclase as nom_deduccion,t2.cod_subclase as codProveedor,t3.valor,t3.unidad ";
	$Consulta.= " from proyecto_modernizacion.sub_clase t1 ";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31022' and t1.cod_subclase=t2.valor_subclase2";
	$Consulta.= " left join pcip_inp_precios t3 on t2.valor_subclase2=t3.cod_producto and t2.cod_subclase =t3.cod_deduccion and t3.ano='".$Ano."'";
	$Consulta.= " where t1.cod_clase='31021' and t1.cod_subclase<>''";
		$Consulta.=" and t1.cod_subclase='".$CmbProducto."'";
	$Consulta.= " order by t1.cod_subclase ";
	$Resp = mysqli_query($link, $Consulta);
	//echo $Consulta;
	echo "<input name='CheckTipoDoc' type='hidden' value=''>";
	
	while ($Fila=mysql_fetch_array($Resp))
	{
	    $CodDedu=$Fila["cod_subclase"];
		$CodProveedor=$Fila["codProveedor"];
		$Ano=$Fila["ano"];	
		$NomProd=$Fila["nom_prod"];
		$NomDedu =$Fila["nom_deduccion"];
		$Valor =$Fila["valor"];
		$CmbUnidad =$Fila["unidad"];
		$ValorPena=	$Fila["valor_pena"];
	    ?>
		 <tr class="FilaAbeja"> 
		  <td align="left" ><? echo $NomProd;?></td>
		  <td align="left" ><? echo $NomDedu;?></td>
		  <td align="center"><input name="CodDeduc" type="hidden" value="<? echo $CodDedu;?>"><input name="Valor" size="10" maxlength="10" type="txt" value="<? echo number_format($Valor,2,',','.');?>">
		  </td>
		  <?
		    if($CmbProducto=='1')
			{
			  echo "<td align='center'>";
				if($CodDedu=='9')
					echo "<input name='ValorPena' size='6' maxlength='5' type='txt' value='".number_format($ValorPena,2,',','.')."'>%";
				else
					echo "<input name='ValorPena' size='6' maxlength='5' type='hidden' value='0'>";			  
			}	
			else
				echo "<input name='ValorPena' size='6' maxlength='5' type='hidden' value='0'>";			  			
		  ?>
		  <td align="center" >		   
		   <?
			$Consulta = "select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31022' and cod_subclase='".$CodProveedor."'";			
			//echo $Consulta."<br>";
			$RespUnid=mysqli_query($link, $Consulta);
			while ($FilaUnid=mysql_fetch_array($RespUnid))
			{
			    //echo $FilaUnid["valor_subclase1"];
				$CmbUnidad=$FilaUnid["valor_subclase1"];
				echo $CmbUnidad;
				echo "<input name='CmbUnidad' type='hidden' value='".$CmbUnidad."'>";
			}
		   ?>
		    <? //echo $Consulta;?> 
		   </td>
		  </tr> 	 
	    <? 
	}
}	
?>			
     </table>
	</td>
 </td>
   <td width="10" background="../pcip_web/archivos/images/interior/form_der.gif">&nbsp;</td>
   </tr>
    <tr>
      <td width="15"><img src="../pcip_web/archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="../pcip_web/archivos/images/interior/form_abajo.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="../pcip_web/archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>	
</form>
<?
CierreEncabezado()
?>
</body>
</html>
<?
	if($Mensaje=='S')
   {
?>
	<script language="javascript">
	alert("No se pueden Eliminar el dato, existen relaciones ")
	</script>
<? 
   }
   if($Mensaje2=='S')
   { 
?>
	<script language="javascript">
	alert("Producto (s) Eliminado (s) Exitosamente ")
	</script>
<?
   }
?>
