<?
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
?>
<html>
<head>
<title>Nuevo Sistema</title>
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="javascript">

var popup=0;
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
			f.action="pcip_mantenedor_nuevo_sistema.php?&Buscar=S";
			f.submit();
		break;
		case "N":
			URL="pcip_mantenedor_nuevo_sistema_proceso.php?Opc="+Opc;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=660,height=250,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckTipoDoc','M'))
			{
				Datos=Recuperar(f.name,'CheckTipoDoc');
				URL="pcip_mantenedor_nuevo_sistema_proceso.php?Opc="+Opc+"&Valores="+Datos;
				opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=660,height=250,scrollbars=1';
				verificar_popup(popup);
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
			}	
		break;
		case "A":
				URL="pcip_mantenedor_asigna_equipos.php?";
				opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=660,height=500,scrollbars=1';
				verificar_popup(popup);
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
		break;			
		case "O":
				URL="pcip_mantenedor_asigna_costos_por_sistema.php?";
				opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=660,height=500,scrollbars=1';
				verificar_popup(popup);
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
		break;	
		case "I":
				URL="pcip_mantenedor_asigna_sistemas_por_indicadores.php?";
				opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=660,height=500,scrollbars=1';
				verificar_popup(popup);
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
		break;					
		case "E":
			if(SoloUnElemento(f.name,'CheckTipoDoc','E'))
			{
				mensaje=confirm("¿Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckTipoDoc');
					f.action='pcip_mantenedor_nuevo_sistema_proceso01.php?Opcion=E&Valor='+ Datos; //Datos; //+"&Pagina="+f.Pagina.value;
					f.submit();
				}
			}	
		break;
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=7";
		break;
	}	
}
function DetalleSistema(Cod)
{
	URL="pcip_info_relacion_sistema.php?Cod="+Cod;
	opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=900,height=400,scrollbars=1';
	//verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	/*popup.focus();
	popup.moveTo((screen.width - 640)/2,0);*/
}

</script>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'mant_sistema.png')
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
	         <td width="81%" align="right" class='formulario2' >
				<!--<a href="JavaScript:Proceso('Prov')"><img src="archivos/btn_carga.gif" border="0"></a> -->
				<a href="JavaScript:Proceso('C')"><img src="../pcip_web/archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
				<a href="JavaScript:Proceso('N')"><img src="../pcip_web/archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a> 
				<a href="JavaScript:Proceso('M')"><img src="../pcip_web/archivos/btn_modificar3.png" border="0" alt="Modificar" align="absmiddle"></a> 
				<a href="JavaScript:Proceso('I')"><img src="../pcip_web/archivos/btn_ingreso_obs2.png" border="0" alt="Relación Sistema Indicador" align="absmiddle"></a> 				
				<a href="JavaScript:Proceso('O')"><img src="../pcip_web/archivos/btn_ingreso_obs2.png" border="0" alt="Relación Sistema Centro Costo" align="absmiddle"></a> 				
				<!--<a href="JavaScript:Proceso('A')"><img src="../pcip_web/archivos/btn_ingreso_obs2.png" border="0" alt="Relación Sistema Equipo" align="absmiddle"></a> -->				
				<a href="JavaScript:Proceso('E')"><img src="../pcip_web/archivos/elim_hito2.png"  alt="Eliminar" align="absmiddle" border="0"></a>
				<a href="JavaScript:Proceso('S')"><img src="../pcip_web/archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>		    
			 </td>
		 </tr>
    <tr>
    <td width="16%" height="17" class='formulario2'>Sistema</td>
    <td colspan="3" class="formulario2" ><select name="CmbSistema" onChange="Proceso('R')">
      <option value="-1" selected="selected">Todos</option>
      <?
	    $Consulta = "select cod_sistema,nom_sistema from pcip_eec_sistemas order by cod_sistema ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbSistema==$FilaTC["cod_sistema"])
				echo "<option selected value='".$FilaTC["cod_sistema"]."'>".ucfirst($FilaTC["nom_sistema"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_sistema"]."'>".ucfirst($FilaTC["nom_sistema"])."</option>\n";
		}
			?>
    </select></tr>
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
        <td width="3%" class="TituloTablaVerde"><input class='SinBorde' type="checkbox" name="CheckTipoDoc" value="" onClick="CheckearTodo(this.form,'CheckTipoDoc','ChkTodos');"></td>
		
          <td width="13%" class="TituloTablaVerde">Código</td>
          <td width="25%" class="TituloTablaVerde">Sistema</td>
		  <td width="35%" class="TituloTablaVerde">Descripción del Sistema</td>
		  <td width="8%" class="TituloTablaVerde">Vigente</td>
		  <td width="10%" class="TituloTablaVerde">Ver en Disp.</td>
		 </tr>
<?
if($Buscar=='S')
{
	$Consulta = "select t1.cod_sistema,t1.nom_sistema,t1.descripcion,t1.vigente,t1.mostrar";
	$Consulta.= " from pcip_eec_sistemas t1 ";
	$Consulta.=" where t1.cod_sistema<>''";
	if($CmbSistema!='-1')
		$Consulta.=" and t1.cod_sistema='".$CmbSistema."'";
	
	$Consulta.= " order by cod_sistema ";
	$Resp = mysql_query($Consulta);
	//echo $Consulta;
	echo "<input name='CheckTipoDoc' type='hidden'  value=''>";
	
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Cod=$Fila["cod_sistema"];
		$Sistema=$Fila["nom_sistema"];
		$Descrip=$Fila["descripcion"];
		$Vig=$Fila["vigente"];
		$Mostrar=$Fila["mostrar"];
?>		
      	<tr >
        <td  align="center"><? echo "<input name='CheckTipoDoc' class='SinBorde' type='checkbox'  value='".$Fila["cod_sistema"]."'>" ?></td>
		<td align="center"><? echo $Cod; ?></td>
        <td ><a href="JavaScript:DetalleSistema('<? echo $Cod;?>')"><? echo $Sistema; ?></a></td>
		<td>&nbsp;<? echo $Descrip; ?></td>
		<td align="center">&nbsp;<? echo $Vig; ?></td>
		<td align="center">&nbsp;<? echo $Mostrar; ?></td>
        </tr>
<?
	}
}	
?>			
    </table></td>

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
<? }?>
