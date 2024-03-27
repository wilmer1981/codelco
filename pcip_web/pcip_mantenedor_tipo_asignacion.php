<?
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
if(isset($BuscarAux)&&$BuscarAux=='S')
	$Buscar="S";

?>
<html>
<head>
<title> Tipo Asignaci�n</title>
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
			f.action="pcip_mantenedor_tipo_asignacion.php?&Buscar=S&CmbAsign=-1";
			f.submit();
		break;
		case "N":
			URL="pcip_mantenedor_tipo_asignacion_proceso.php?Opc="+Opc;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=700,height=400,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckTipoDoc','M'))
			{
				Datos=Recuperar(f.name,'CheckTipoDoc');
				URL="pcip_mantenedor_tipo_asignacion_proceso.php?Opc="+Opc+"&Valores="+Datos;
				opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=700,height=400,scrollbars=1';
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
					f.action='pcip_mantenedor_tipo_asignacion_proceso01.php?Opcion=E&Valor='+ Datos; //Datos; //+"&Pagina="+f.Pagina.value;
					f.submit();
				}
			}	
		break;
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=8";
		break;
	}	
}

</script>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'mant_tipo_asignacion.png')
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
				<a href="JavaScript:Proceso('E')"><img src="../pcip_web/archivos/elim_hito2.png"  alt="Eliminar" align="absmiddle" border="0"></a>
				<a href="JavaScript:Proceso('S')"><img src="../pcip_web/archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>		    </td>
		  </tr>
      <tr>
    	<td width="16%" height="17" class='formulario2'>Nombre Asignaci�n</td>
    	<td colspan="3" class="formulario2" ><select name="CmbAsign" onChange="Proceso('R')">
			  <option value="-1" selected="selected">Todos</option>
			  <?
				$Consulta = "select cod_asignacion,nom_asignacion from pcip_svp_asignacion order by cod_asignacion ";			
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbAsign==$FilaTC["cod_asignacion"])
						echo "<option selected value='".$FilaTC["cod_asignacion"]."'>".ucfirst($FilaTC["nom_asignacion"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_asignacion"]."'>".ucfirst($FilaTC["nom_asignacion"])."</option>\n";
				}
					?>
			</select>
	 </tr>
      <tr>
    	<td width="16%" height="17" class='formulario2'>Vigente</td>
    	<td colspan="3" class="formulario2" ><select name="CmbVig" onChange="Proceso('R')">
               <option value="-1" class="NoSelec">Todos</option>
               <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbVig==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
           </select>
	 </tr>
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
          <td width="7%" class="TituloTablaVerde"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckTipoDoc','ChkTodos');"></td>
          <td width="11%" class="TituloTablaVerde">Codigo</td>
          <td width="71%" class="TituloTablaVerde">Nombre de Asignaci�n</td>
		  <td width="11%" class="TituloTablaVerde">Mostrar Asignaci�n</td>
		  <td width="11%" class="TituloTablaVerde">Mostrar PPC</td>
		  <td width="11%" class="TituloTablaVerde">Vigente</td>		  
	  </tr>
<?
if($Buscar=='S')
{
	$Consulta = "select t1.cod_asignacion,t1.nom_asignacion,t1.vigente,t1.mostrar_asig,t1.mostrar_ppc,t2.nombre_subclase,t3.nombre_subclase as m_asig,t4.nombre_subclase as m_ppc";
	$Consulta.= " from pcip_svp_asignacion t1 left join  proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31007' and t1.vigente=t2.cod_subclase";
	$Consulta.= " left join  proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31007' and t1.mostrar_asig=t3.cod_subclase";
	$Consulta.= " left join  proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31007' and t1.mostrar_ppc=t4.cod_subclase";
	$Consulta.=" where t1.cod_asignacion<>''";
	if($CmbAsign!='-1')
		$Consulta.=" and t1.cod_asignacion='".$CmbAsign."'";
	if($CmbVig!='-1')
		$Consulta.=" and t1.vigente='".$CmbVig."'";		
			
	$Consulta.= " order by cod_asignacion ";
	$Resp = mysqli_query($link, $Consulta);
	//echo $Consulta;
	echo "<input name='CheckTipoDoc' type='hidden'  value=''>";
	
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Cod=$Fila["cod_asignacion"];
		$Asig =$Fila["nom_asignacion"];
		$MAsig=$Fila["m_asig"];
		$MPpc=$Fila["m_ppc"];
		$Vig =$Fila["nombre_subclase"];		
?>		
      	<tr >
        <td  align="center"><? echo "<input name='CheckTipoDoc' class='SinBorde' type='checkbox'  value='".$Fila["cod_asignacion"]."'>" ?></td>
		<td align="center"><? echo $Cod; ?></td>
        <td >&nbsp;<? echo $Asig; ?></td>
		<td align="center">&nbsp;<? echo $MAsig; ?></td>
		<td align="center">&nbsp;<? echo $MPpc; ?></td>
		<td align="center">&nbsp;<? echo $Vig; ?></td>
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
<? }?>
