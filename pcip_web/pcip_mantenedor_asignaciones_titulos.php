<?
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
if(isset($BuscarAux)&&$BuscarAux=='S')
	$Buscar="S";
?>
<html>
<head>
<title> Mantenedor Asignaciones Titulos</title>
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="javascript">
var popup=0;
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	var Asignacion=f.CmbAsig.value;
	switch(Opc)
	{
		case "C":
			f.action="pcip_mantenedor_asignaciones_titulos.php?&Buscar=S&CmbAsig="+Asignacion;
			f.submit();
		break;
		case "N":
			URL="pcip_mantenedor_asignaciones_titulos_proceso.php?Opc="+Opc;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=750,height=400,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckTipoDoc','M'))
			{
				Datos=Recuperar(f.name,'CheckTipoDoc');
				URL="pcip_mantenedor_asignaciones_titulos_proceso.php?Opc="+Opc+"&Valores="+Datos;
				opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=750,height=400,scrollbars=1';
				verificar_popup(popup);
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
			}	
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckTipoDoc','E'))
			{
				mensaje=confirm("¿Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckTipoDoc');
					f.action='pcip_mantenedor_asignaciones_titulos_proceso01.php?Opcion=E&Valor='+ Datos; //Datos; //+"&Pagina="+f.Pagina.value;
					f.submit();
				}
			}	
		break;
		case "R":
			f.action = "pcip_mantenedor_asignaciones_titulos.php";
			f.submit();
		break;		
		case "R1":
			f.CmbNeg.value='-1';
			f.CmbTit.value='-1';
			f.CmbVig.value='-1';
			f.action = "pcip_mantenedor_asignaciones_titulos.php";
			f.submit();
		break;	
		case "R2":
			f.CmbTit.value='-1';
			f.action = "pcip_mantenedor_asignaciones_titulos.php";
			f.submit();
		break;	
		case "R3":
			f.action = "pcip_mantenedor_asignaciones_titulos.php";
			f.submit();
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
 EncabezadoPagina($IP_SERV,'mant_asignaciones_titulos.png')
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
    	<td width="16%" height="17" class='formulario2'>Nombre Asignaci&oacute;n</td>
    	<td colspan="3" class="formulario2" ><select name="CmbAsig" onChange="Proceso('R1')">
			  <option value="-1" selected="selected">Todos</option>
			  <?
				$Consulta = "select cod_asignacion,nom_asignacion from pcip_svp_asignacion order by cod_asignacion ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbAsig==$FilaTC["cod_asignacion"])
						echo "<option selected value='".$FilaTC["cod_asignacion"]."'>".ucfirst($FilaTC["nom_asignacion"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_asignacion"]."'>".ucfirst($FilaTC["nom_asignacion"])."</option>\n";
				}
					?>
			</select>
	 </tr>
      <tr>
    	<td width="16%" height="17" class='formulario2'>Negocios</td>
    	<td colspan="3" class="formulario2" ><select name="CmbNeg" onChange="Proceso('R2')">
			  <option value="-1" selected="selected">Todos</option>
			  <?
				$Consulta = "select distinct(t1.cod_negocio),t2.nom_negocio from pcip_svp_asignaciones_titulos  t1 inner join pcip_svp_negocios t2 on t1.cod_negocio=t2.cod_negocio ";
				$Consulta.= "where t1.cod_asignacion='".$CmbAsig."'";		
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbNeg==$FilaTC["cod_negocio"])
						echo "<option selected value='".$FilaTC["cod_negocio"]."'>".ucfirst($FilaTC["nom_negocio"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_negocio"]."'>".ucfirst($FilaTC["nom_negocio"])."</option>\n";
				}
		      ?>
			</select>
	 </tr>	 
      <tr>
    	<td width="16%" height="17" class='formulario2'>Titulos</td>
    	<td colspan="3" class="formulario2" ><select name="CmbTit" onChange="Proceso('R3')">
			  <option value="-1" selected="selected">Todos</option>
			  <?
				$Consulta = "select t1.cod_titulo,t1.nom_titulo from pcip_svp_asignaciones_titulos t1 inner join pcip_svp_negocios t2 on t1.cod_negocio=t2.cod_negocio";		
				$Consulta.=" where t1.cod_negocio='".$CmbNeg."'";
				if($CmbAsig!='-1')
					$Consulta.=" and t1.cod_asignacion='".$CmbAsig."'";
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbTit==$FilaTC["cod_titulo"])
						echo "<option selected value='".$FilaTC["cod_titulo"]."'>".ucfirst($FilaTC["nom_titulo"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_titulo"]."'>".ucfirst($FilaTC["nom_titulo"])."</option>\n";
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
				$Resp=mysql_query($Consulta);
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
          <td width="4%" class="TituloTablaVerde"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckTipoDoc','ChkTodos');"></td>
          <td width="11%" class="TituloTablaVerde">Codigo Titulo</td>
          <td width="15%" class="TituloTablaVerde">Tipo Asignaci&oacute;n</td>
		  <td width="19%" class="TituloTablaVerde">Nombre Negocio</td>	  
          <td width="31%" class="TituloTablaVerde">Nombre Titulo</td>
		  <td width="12%" class="TituloTablaVerde">Orden</td>
		  <td width="12%" class="TituloTablaVerde">Grupo</td>
		  <td width="8%" class="TituloTablaVerde">Vigente</td>
		  <td width="8%" class="TituloTablaVerde">Mostrar Asig</td>
		  <td width="8%" class="TituloTablaVerde">Mostrar Ppc</td>
	  </tr>
<?
if($Buscar=='S')
{
	$Consulta = "select t5.nombre_subclase as nom_grupo,t1.cod_titulo,t3.nom_asignacion,t2.nom_negocio,t1.nom_titulo,t1.orden,t4.nombre_subclase as nom_vig";
	$Consulta.= ",t6.nombre_subclase as nom_asig,t7.nombre_subclase as nom_ppc from pcip_svp_asignaciones_titulos t1 inner join pcip_svp_negocios t2 on t1.cod_negocio=t2.cod_negocio";
	$Consulta.= " inner join pcip_svp_asignacion t3 on t1.cod_asignacion=t3.cod_asignacion";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31007' and t4.cod_subclase=t1.vigente";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='31042' and t5.cod_subclase=t1.grupo";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t6 on t6.cod_clase='31007' and t6.cod_subclase=t1.mostrar_asig";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t7 on t7.cod_clase='31007' and t7.cod_subclase=t1.mostrar_ppc";
	$Consulta.= " where t1.cod_asignacion<>''";
	if($CmbAsig!='-1')
		$Consulta.=" and t1.cod_asignacion='".$CmbAsig."'";
	if($CmbNeg!='-1')
		$Consulta.=" and t2.cod_negocio='".$CmbNeg."'";	
	if($CmbTit!='-1')
		$Consulta.=" and t1.cod_titulo='".$CmbTit."'";				
	if($CmbVig!='-1')
		$Consulta.=" and t1.vigente='".$CmbVig."'";		
			
	$Consulta.= " order by t1.cod_titulo,t3.nom_asignacion,t1.orden ";
	$Resp = mysql_query($Consulta);
	//echo $Consulta;
	echo "<input name='CheckTipoDoc' type='hidden'  value=''>";
	
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Cod=$Fila["cod_titulo"];
		$Asig=$Fila["nom_asignacion"];
		$Prod=$Fila["nom_negocio"];
		$Tit=$Fila["nom_titulo"];
		$Orden=$Fila["orden"];
		$Grupo=$Fila["nom_grupo"];
		$Vig=$Fila["nom_vig"];	
		$MostrarAsig=$Fila["nom_asig"];	
		$MostrarPpc=$Fila["nom_ppc"];		
?>		
      	<tr >
        <td  align="center"><? echo "<input name='CheckTipoDoc' class='SinBorde' type='checkbox'  value='".$Fila["cod_titulo"]."'>" ?></td>
		<td align="center"><? echo $Cod; ?></td>
		 <td >&nbsp;<? echo $Asig; ?></td>
        <td >&nbsp;<? echo $Prod; ?></td>
		<td >&nbsp;<? echo $Tit; ?></td>
		<td align="center">&nbsp;<? echo $Orden; ?></td>
		<td align="center">&nbsp;<? echo $Grupo; ?></td>
		<td align="center">&nbsp;<? echo $Vig; ?></td>
		<td align="center">&nbsp;<? echo $MostrarAsig; ?></td>
		<td align="center">&nbsp;<? echo $MostrarPpc; ?></td>
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
	echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Registro Eliminado Correctamente');";
	echo "</script>";
?>
