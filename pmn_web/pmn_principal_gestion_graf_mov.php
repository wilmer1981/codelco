<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");					

if($VisibleDivProceso=='S')
$VisibleDiv='hidden';

if(!isset($FDesde))
	$FDesde=date('Y-m-d');
	
$SelTarea=$NivelOrg;
?>
<html>
<head>
<title>Consulta Histórica</title>

<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">

var popup=0;
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmPrincipal;
	var teclaCodigo = event.keyCode;
	
	
		if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39) &&(teclaCodigo != 190 ))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
					event.keyCode=46;
			   }		
			}   
		}
		else
		{
			if ((teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 188 )&&(teclaCodigo != 190 ))
			{
				event.keyCode=46;
			}	
		}
	
} 
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "R":
				if(f.FDesde.value=='')
				{
					alert('Debe Ingresar Fecha Desde');
					f.FDesde.focus();
					return;
				}	
				if(f.FHasta.value=='')
				{
					alert('Debe Ingresar Fecha Hasta');
					f.FHasta.focus();
					return;
				}	
				f.action='consulta_acceso_control.php';
				f.submit();		
		break;
		case "C":
				f.action='consulta_acceso_control.php?Buscar=S&Tipo=C';
				f.submit();		
		break;
		case "GF":
				URL='consulta_acceso_control_grafica.php?Buscar=S&FDesde='+f.FDesde.value+'&FHasta='+f.FHasta.value+'&USUARIO='+f.USUARIO.value+'&CmbM='+f.CmbTipoProceso.value;
				window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");	
		break;
		case "S":
				window.location="pmn_principal_gestion.php";
		break;
	}	
}
function CloseDiv()
{

	DivProceso.style.visibility='hidden';
	DivOCu.style.visibility='visible';
}
function compare_dates(fecha, fecha2)  
{  
	var xMonth=fecha.substring(3, 5);  
	var xDay=fecha.substring(0, 2);  
	var xYear=fecha.substring(6,10);  
	var yMonth=fecha2.substring(3, 5);  
	var yDay=fecha2.substring(0, 2);  
	var yYear=fecha2.substring(6,10);  
	if (xYear> yYear)  
   {  
	   return(true)  
   }  
  else  
   {  
	 if (xYear == yYear)  
	 {   
	   if (xMonth> yMonth)  
	   {  
		   return(true)  
	   }  
	   else  
	   {   
		 if (xMonth == yMonth)  
		 {  
		   if (xDay> yDay)  
			 return(true);  
		   else  
			 return(false);  
		 }  
		 else  
		   return(false);  
	   }  
	 }  
	 else  
	   return(false);  
  }  
}  

</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmPrincipal" method="post" action="">
<input name="Datos" type="hidden" value="<?php echo $Datos;?>">
<input name="Proc" type="hidden" value="<?php echo $Proc;?>">
<input type="hidden" size='100' value="<?php echo $SelTarea;?>" name="SelTarea">

<table width="900" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
	<td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
	<td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
	<td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
   <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
   <td align="center"><table width="100%" border="0" cellpadding="0"  cellspacing="0">
     <tr>
	 <td align="center" colspan="7" class="TituloCabecera2">GR&Aacute;FICO DE MOVIMIENTO </td>
	 </tr>
	 <tr>       
	   <td width="106" height="35" align="left" class="formulario"   ><img src="archivos/LblCriterios.png" /> </td>
       <td align="right" class="formulario" colspan="7">
	   <div id="DivOCu" style="visibility:<?php echo $VisibleDiv;?>">
	   <a href="JavaScript:Proceso('C')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;
	   <a href="javascript:Proceso('GF')"></a>&nbsp;
	    <a href="javascript:window.print()"><img src="archivos/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Proceso('S')"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a>       </div></td>
	 </tr>
     <tr>
       <td colspan="3" align="left" class="formulario">Producto</td>
	   <td width="338" class="formulario"><select name="select">
          <?php
				echo"<option value='-1' selected>Seleccionar</option>";
				if($cmbturno == "A")
					echo"<option value='A' selected>A</option>";
				else
					echo"<option value='A'>A</option>";
				if($cmbturno == "B")
					echo"<option value='B' selected>B</option>";
				else
					echo"<option value='B'>B</option>";
				if($cmbturno == "C")
					echo"<option value='C' selected>C</option>";
				else
					echo"<option value='C'>C</option>";
			?>
        </select></td>
	   <td width="74" class="formulario">Movimiento</td>
	   <td width="295" class="formulario"><select name="cmbturno">
         <?php
				echo"<option value='-1' selected>Seleccionar</option>";
				if($cmbturno == "A")
					echo"<option value='A' selected>A</option>";
				else
					echo"<option value='A'>A</option>";
				if($cmbturno == "B")
					echo"<option value='B' selected>B</option>";
				else
					echo"<option value='B'>B</option>";
				if($cmbturno == "C")
					echo"<option value='C' selected>C</option>";
				else
					echo"<option value='C'>C</option>";
			?>
       </select></td>
	   <td width="147" class="formulario">&nbsp;</td>
       </tr>
     <tr>
       <td colspan="3" class="formulario">Desde</td>
       <td class="formulario"><select name="select2">
         <?php
				echo"<option value='-1' selected>Seleccionar</option>";
				if($cmbturno == "A")
					echo"<option value='A' selected>A</option>";
				else
					echo"<option value='A'>A</option>";
				if($cmbturno == "B")
					echo"<option value='B' selected>B</option>";
				else
					echo"<option value='B'>B</option>";
				if($cmbturno == "C")
					echo"<option value='C' selected>C</option>";
				else
					echo"<option value='C'>C</option>";
			?>
       </select>
         <select name="select3">
           <?php
				echo"<option value='-1' selected>Seleccionar</option>";
				if($cmbturno == "A")
					echo"<option value='A' selected>A</option>";
				else
					echo"<option value='A'>A</option>";
				if($cmbturno == "B")
					echo"<option value='B' selected>B</option>";
				else
					echo"<option value='B'>B</option>";
				if($cmbturno == "C")
					echo"<option value='C' selected>C</option>";
				else
					echo"<option value='C'>C</option>";
			?>
         </select></td>
       <td class="formulario">Hasta</td>
       <td class="formulario"><select name="select4">
         <?php
				echo"<option value='-1' selected>Seleccionar</option>";
				if($cmbturno == "A")
					echo"<option value='A' selected>A</option>";
				else
					echo"<option value='A'>A</option>";
				if($cmbturno == "B")
					echo"<option value='B' selected>B</option>";
				else
					echo"<option value='B'>B</option>";
				if($cmbturno == "C")
					echo"<option value='C' selected>C</option>";
				else
					echo"<option value='C'>C</option>";
			?>
       </select>
         <select name="select4">
           <?php
				echo"<option value='-1' selected>Seleccionar</option>";
				if($cmbturno == "A")
					echo"<option value='A' selected>A</option>";
				else
					echo"<option value='A'>A</option>";
				if($cmbturno == "B")
					echo"<option value='B' selected>B</option>";
				else
					echo"<option value='B'>B</option>";
				if($cmbturno == "C")
					echo"<option value='C' selected>C</option>";
				else
					echo"<option value='C'>C</option>";
			?>
         </select></td>
       <td rowspan="2" align="center" class="formulario"><a href="javascript:window.print()"><img src="archivos/grafico.png" alt='Graficar' width="78" height="69" border="0" align="absmiddle" /></a></td>
     </tr>
     <tr>
       <td colspan="3" class="formulario">&nbsp;</td>
       <td class="formulario">&nbsp;</td>
       <td class="formulario">&nbsp;</td>
       <td class="formulario">&nbsp;</td>
     </tr>
     <tr>
       <td colspan="3" class="formulario">&nbsp;</td>
       <td class="formulario">&nbsp;</td>
       <td class="formulario">&nbsp;</td>
       <td class="formulario">&nbsp;</td>
       <td align="center" class="formulario">Graficar</td>
     </tr>
	 <?php
		$FDesde=$FDesde." 00:00:00";
		$FHasta=$FHasta." 23:59:59";
	 ?>
   </table></td>
   <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"  /></td>
  </tr>
  </table><br>
<table width="50%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="6" align="center" class="formulario">Producto / Tipo Movimiento </td>
        </tr>
      <tr>
        <td colspan="3" align="center" class="LineasBordesAba">Mes - A&ntilde;o </td>
        <td width="51%" colspan="3" align="center" class="LineasBordesAba">Valor Producci&oacute;n </td>
        </tr>
      <tr>
        <td colspan="3" class="LineasBordesAlmedio">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        </tr>
      
    </table></td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"  /></td>
  </tr>
</table>
<BR>
<br>
<br>
</form>
</body>
</html>
<?php
echo "<script language='javascript'>";
if($Mensaje!='')
	echo "alert('".$Mensaje."');";
echo "</script>";
?>

