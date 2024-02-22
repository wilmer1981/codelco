<?
include("../principal/conectar_sget_web.php");
?>
<script language="javascript" src="funciones/sget_funciones.js"></script>
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
			URL="sget_mantenedor_clase_subclase_proceso.php?Opc="+Opc;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=560,height=200,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);sget_mantenedor_mutuales_proceso.php
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckTipoDoc','M'))
			{
				Datos=Recuperar(f.name,'CheckTipoDoc');
				
				URL="sget_mantenedor_clase_subclase_proceso.php?Opc="+Opc+"&Valores="+Datos;
				opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=560,height=200,scrollbars=1';
				verificar_popup(popup);
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
			}	
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckTipoDoc','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckTipoDoc');
					f.action='sget_mantenedor_AFP01.php?Opcion=E&Valor='+ Datos; //Datos; //+"&Pagina="+f.Pagina.value;
					f.submit();
				}
			}	
		break;
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=1";
		break;
	}	
}

</script>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<br>
<table width="70%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1067" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
		<table width="100%" cellpadding="2" cellspacing="0">
		  <tr>
				 <td align="right" >
				<!--<a href="JavaScript:Proceso('Prov')"><img src="archivos/btn_carga.gif" border="0"></a> -->
				<a href="JavaScript:Proceso('N')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a> 
				<a href="JavaScript:Proceso('M')"><img src="archivos/btn_modificar.png" border="0" alt="Modificar" align="absmiddle"></a> 
				<a href="JavaScript:Proceso('E')"><img src="archivos/elim_hito.png"  alt="Eliminar" align="absmiddle" border="0"></a>
				 <a href="JavaScript:Proceso('S')"><img src="archivos/volver.png"  border="0"  alt=" Volver " align="absmiddle"></a>
				 </td>
		  </tr>
		</table>    
	<table width="100%" border="1" cellpadding="4" cellspacing="0" >
     <tr>  <td colspan="3" align="center" class="TituloTablaNaranja">Mantenedor de Clase Subclase </td>
     </tr>
	  <tr align="center">
        <td width="6%" class="TituloCabecera"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckTipoDoc','ChkTodos');"></td>
     
        <td width="55%" class="TituloCabecera">Clase</td>
		 <td width="30%" class="TituloCabecera">Subclase</td>
        </tr>
	<?
	$Consulta = "SELECT * ";
	$Consulta.= " from sget_clase  ";
	$Consulta.= " order by descripcion  ";
	$Resp = mysql_query($Consulta);
	echo "<input name='CheckTipoDoc' type='hidden'  value=''>";
	while ($Fila=mysql_fetch_array($Resp))
	{
		?>		
      	<tr >
        <td  align="center"><? echo "<input name='CheckTipoDoc' class='SinBorde' type='checkbox' value= '".$Fila["cod_clase"]."'>" ?></td>
        <td ><? echo $Fila["descripcion"]; ?></td>
		<td >
		<? 
		$Consulta = "SELECT * ";
		$Consulta.= " from sget_subclase  where cod_clase='".$Fila["cod_clase"]."' ";
		$Consulta.= " order by descripcion_subclase  ";
		$Resp1 = mysql_query($Consulta);
		$DescripSubClase='';
		while ($Fila1=mysql_fetch_array($Resp1))
		{
			$DescripSubClase= $DescripSubClase.' '.$Fila1[descripcion_subclase].' - ';
		}
		//echo $DescripSubClase.'<br>';  
		$DescripSubClase = substr ($DescripSubClase,0,strlen ($DescripSubClase) -2); 
		echo $DescripSubClase; 
		?>&nbsp;</td>
        </tr>
		<?
	}
	?>			
    </table></td>

 </td>
  <td width="1" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="18" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>	
</form>
<script language="javascript">
/*alert("No se pueden Eliminar, Tiene Requerimientos Asociados")*/
</script>
