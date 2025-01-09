<?php
include('conectar_ori.php');
include('funciones/siper_funciones.php');
if($VisibleDivProceso=='S')
$VisibleDiv='hidden';
?>
<html>
<head>
<title>Mantenedor Unidad</title>

<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">

var popup=0;
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "N":
				Datos=Recuperar(f.name,'CheckRut');
				DivProceso.style.visibility='visible';
				f.Proc.value='N';
				f.Datos.value=Datos;
				f.action='mantenedor_unidad.php?VisibleDivProceso=S&Buscar=S';
				f.submit();		
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckRut','M'))
			{
				Datos=Recuperar(f.name,'CheckRut');
				DivProceso.style.visibility='visible';
				f.Proc.value='M';
				f.Datos.value=Datos;
				f.action='mantenedor_unidad.php?VisibleDivProceso=S&Buscar=S';
				f.submit();				
			}	
		break;
		case "G":
			if(f.TxtNombre.value!='')
			{
			
					DivProceso.style.visibility='hidden';
					f.action='mantenedor_unidad01.php?Proceso='+f.Proc.value;
					f.submit();				
			}
			else
			{alert('Debe Ingresar Descripción')
			f.TxtNombre.focus();
			}
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckRut','E'))
			{
				mensaje=confirm("¿Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					DatosUni=Recuperar(f.name,'CheckRut');
					f.action='mantenedor_unidad01.php?Proceso=E&DatosUni='+DatosUni;
					f.submit();
				}
			}	
		break;
		case "C":
				f.action='mantenedor_unidad.php?Buscar=S';
				f.submit();		
		break;
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=29&Nivel=1&CodPantalla=6";
		break;
	}	
}
function CloseDiv()
{

	DivProceso.style.visibility='hidden';
	DivOCu.style.visibility='visible';
}
</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<input name="Datos" type="hidden" value="<?php echo $Datos;?>">
<input name="Proc" type="hidden" value="<?php echo $Proc;?>">
<table width="71%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
	<td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
	<td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
	<td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
   <td align="center"><table width="96%" border="0" cellpadding="0"  cellspacing="0">
     <tr>
	 <td align="center" colspan="2" class="TituloCabecera2">Mantenedor de Unidades</td>
	 </tr>
     <tr>
       <td width="52" height="35" align="left" class="formulario"   ><img src="imagenes/LblCriterios.png" /> </td>
       <td align="right" class="formulario" >
	      <div id="DivOCu" style="visibility:<?php echo $VisibleDiv;?>">

	   <a href="JavaScript:Proceso('N')"><img src="imagenes/btn_agregar.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp; <a href="JavaScript:Proceso('M')"><img src="imagenes/btn_modificar.png" alt="Modificar" width="30" height="30" border="0" align="absmiddle"></a>&nbsp; <a href="JavaScript:Proceso('E')"><img src="imagenes/btn_eliminar2.png"  alt="Eliminar" width="25" height="25" border="0" align="absmiddle"></a>&nbsp; <a href="JavaScript:Proceso('S')"><img src="imagenes/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a>
	   </div> </td>
     </tr>
     <tr>
       <td colspan="3" class="formulario">Descripcion
         <input name="TxtDescripcion" type="text" id="TxtDescripcion" value="<?php echo $TxtDescripcion; ?>" size="30" />
         <a href="JavaScript:Proceso('C')"><img src="imagenes/Btn_buscar.gif"   alt="Buscar" width="20" height="20"  border="0" align="absmiddle" /></a>
         </td>
       <?php 
		if($Check=='S')
		{	
			$checked='checked';
		 	$disabled="";
		}
		else
		{	
			$checked="";
			$disabled="";
		 }
		  
		  ?>
     </tr>
   </table></td>
   <td width="1%" background="imagenes/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
  </table><br>	
<table width="71%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
    <td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
    <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td width="7%" class="TituloCabecera"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckRut','ChkTodos');"></td>
        <td width="17%" align="center" class="TituloCabecera">Abreviatura</td>
        <td width="76%" align="center" class="TituloCabecera">Descripci&oacute;n</td>
        </tr>
      <?php
		//if($Buscar=='S')
		//{
			$Consulta = "select * from sgrs_unidades ";
			$Consulta.=" where not isnull(CUNIDAD)  ";
			if($TxtDescripcion!='')
				$Consulta.= " and upper(NUNIDAD) like('%".strtoupper($TxtDescripcion)."%') ";
			$Resp = mysqli_query($link,$Consulta);
			echo "<input name='CheckRut' type='hidden'  value=''>";
			$cont=1;
			while ($Fila=mysqli_fetch_array($Resp))
			{
		?>
			  <tr>
				<td ><?php echo "<input name='CheckRut' class='SinBorde' type='checkbox'  value='".$Fila["CUNIDAD"]."'"; ?></td>
				<td ><?php echo $Fila["AUNIDAD"]."&nbsp;"; ?></td>
				<td ><?php echo strtoupper($Fila["NUNIDAD"])."&nbsp;"; ?></td>
			  </tr>
			  <?php		$cont++;
			}
		//}
?>
    </table></td>
    <td width="1%" background="imagenes/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
</table><br>
<?php 
if (!isset($VisibleDivProceso))
	$VisibleDivProceso='hidden';
?>

<div id="DivProceso" style="visibility:<?php echo $VisibleDivProceso;?>;FILTER: alpha(opacity=100);overflow:auto; POSITION: absolute; moz-opacity: .75; opacity: .75;left: 380px; top: 24px; width:466px; height:143px;" align="center">
<table width="55%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td ><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td ><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
    <td align="center"><table width="403" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td  colspan="2"align="right"><a href="JavaScript:Proceso('G')"><img src="imagenes/btn_guardar.png"  border="0"  alt="Grabar" align="absmiddle" /></a><a href="JavaScript:CloseDiv()"><img src="imagenes/btn_salir.png"  border="0"  alt="Cerra" align="absmiddle" /></a></td>
      </tr>
	  <tr>
	  
	  <?php 
	  	if($Proc=='M')
		{
			$Consulta="Select * from sgrs_unidades where CUNIDAD='".$Datos."' ";
			$Resp1 = mysqli_query($link,$Consulta);
			if ($Fila1=mysqli_fetch_array($Resp1))
			{
			 $TxtNombre=$Fila1[NUNIDAD];
			 $TxtAbrev=$Fila1[AUNIDAD];
			}
		}
		else
		{
		 	$TxtNombre='';
			$TxtAbrev='';
		}
	  
	  
	  ?>
	  
	  
        <td class="formulario">Descripción</td>
		<td > <input name="TxtNombre" type="text" id="TxtNombre" value="<?php echo $TxtNombre; ?>" size="40"  maxlength="100"/><span class="InputRojo">(*)</span></td>
      </tr>
	    <tr>
        <td class="formulario">Abreviatura</td>
		<td class="formulario"> <input name="TxtAbrev" type="text" id="TxtAbrev" value="<?php echo $TxtAbrev; ?>" size="15"  maxlength="10"/></td>
      </tr>
       </table></td>
    <td width="1%" background="imagenes/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
</table>
</div>
</form>
</body>
</html>
<?php
echo "<script language='javascript'>";
if($Mensaje!='')
	echo "alert('".$Mensaje."');";
echo "</script>";
?>
