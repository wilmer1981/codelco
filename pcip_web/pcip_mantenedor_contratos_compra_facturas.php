<?
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
?>
<html>
<head>
<title>Mantenedor Contratos Facturas</title>
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
			f.action="pcip_mantenedor_contratos_compra_facturas.php?&Buscar=S&CmbContrato=-1";
			f.submit();
		break;
		case "N":
			URL="pcip_mantenedor_contratos_compra_facturas_proceso.php?Opc="+Opc;
			opciones='left=50,top=30,toolbar=0,resizable=0,menubar=0,status=1,width=900,height=400,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			//popup.moveTo((screen.width - 1024)/2,0);
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckTipoDoc','M'))
			{
				Datos=Recuperar(f.name,'CheckTipoDoc');
				URL="pcip_mantenedor_contratos_compra_facturas_proceso.php?Opc="+Opc+"&Valores="+Datos;
				opciones='left=50,top=30,toolbar=0,resizable=0,menubar=0,status=1,width=900,height=400,scrollbars=1';
				verificar_popup(popup);
				popup=window.open(URL,"",opciones);
				popup.focus();
				//popup.moveTo((screen.width - 640)/2,0);
			}	
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckTipoDoc','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckTipoDoc');
					f.action='pcip_mantenedor_contratos_compra_facturas_proceso01.php?Opcion=E&Valor='+ Datos; //Datos; //+"&Pagina="+f.Pagina.value;
					f.submit();
				}
			}	
		break;
		case "EX"://GENERA EXCEL
			URL='pcip_mantenedor_contratos_compra_facturas_excel.php?&CmbContrato='+f.CmbContrato.value+'&CmbProveedor='+f.CmbProveedor.value+'&CmbTipoContrato='+f.CmbTipoContrato.value+'&CmbVig='+f.CmbVig.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;				
		case "I"://IMPRIMIR
			window.print();
		break;			
		case "R":
			f.action = "pcip_mantenedor_contratos_compra_facturas.php";
			f.submit();
		break;		
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=10";
		break;
	}	
}

</script>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'mant_contratos_facturas.png')
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
	            <td align="right" class='formulario2' >
				<!--<a href="JavaScript:Proceso('Prov')"><img src="archivos/btn_carga.gif" border="0"></a> -->
				<a href="JavaScript:Proceso('C')"><img src="../pcip_web/archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
			    <a href="JavaScript:Proceso('N')"><img src="../pcip_web/archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a> 
				<a href="JavaScript:Proceso('M')"><img src="../pcip_web/archivos/btn_modificar3.png" border="0" alt="Modificar" align="absmiddle"></a>
				<a href="JavaScript:Proceso('EX')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>
				<a href="JavaScript:Proceso('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> 
				<a href="JavaScript:Proceso('E')"><img src="../pcip_web/archivos/elim_hito2.png"  alt="Eliminar" align="absmiddle" border="0"></a>
				<a href="JavaScript:Proceso('S')"><img src="../pcip_web/archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>		    </td>
		  </tr>
      <tr>
    	<td width="19%" height="17" class='formulario2'>Contrato</td>
    	<td colspan="3" class="formulario2" ><select name="CmbContrato" onChange="Proceso('R')">
			  <option value="-1" selected="selected">Todos</option>
			  <?
				$Consulta = "select cod_contrato from pcip_fac_contratos_compra order by cod_contrato ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbContrato==$FilaTC["cod_contrato"])
						echo "<option selected value='".$FilaTC["cod_contrato"]."'>".ucfirst($FilaTC["cod_contrato"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_contrato"]."'>".ucfirst($FilaTC["cod_contrato"])."</option>\n";
				}
					?>
		  </select>	 </tr>
      <tr>
    	<td width="19%" height="17" class='formulario2'>Proveedor</td>
    	<td colspan="3" class="formulario2" ><select name="CmbProveedor" onChange="Proceso('R')">
			  <option value="-1" selected="selected">Todos</option>
			  <?
				$Consulta = "select distinct(t1.rut_proveedor),t2.nom_proveedor from pcip_fac_contratos_compra t1 inner join";
				$Consulta.= " pcip_fac_proveedores t2 where t1.rut_proveedor=t2.rut_proveedor order by rut_proveedor ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbProveedor==$FilaTC["rut_proveedor"])
							echo "<option selected value='".$FilaTC["rut_proveedor"]."'>".str_pad($FilaTC["rut_proveedor"],10,'0',STR_PAD_LEFT)." ".$FilaTC["nom_proveedor"]."</option>\n";
						else
							echo "<option value='".$FilaTC["rut_proveedor"]."'>".str_pad($FilaTC["rut_proveedor"],10,'0',STR_PAD_LEFT)." ".$FilaTC["nom_proveedor"]."</option>\n";
				}
					?>
			</select>	    Tipo Contrato        
	      <span class="formulariosimple">
	      <select name="CmbTipoContrato" >
            <option value="-1" class="NoSelec">Todos</option>
            <?
						$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31017' ";			
						$Resp=mysql_query($Consulta);
						while ($FilaTC=mysql_fetch_array($Resp))
						{
							if ($CmbTipoContrato==$FilaTC["cod_subclase"])
								echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
							else
								echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
						}
					   ?>
          </select>
	      </span>	          </tr>	 
      <tr>
    	<td width="19%" height="17" class='formulario2'>Vigente</td>
    	<td colspan="3" class="formulario2" ><select name="CmbVig" onChange="Proceso('R')">
               <option value="-1" class="NoSelec">Seleccionar</option>
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
          </select>	 </tr>
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
          <td width="3%" class="TituloTablaVerde"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckTipoDoc','ChkTodos');"></td>
          <td width="6%" class="TituloTablaVerde">Contrato</td>
          <td width="8%" class="TituloTablaVerde">Rut Proveedor</td>
		  <td width="11%" class="TituloTablaVerde">Proveedor/Cliente</td>		  
		  <td width="7%" class="TituloTablaVerde">Producto</td>
		  <td width="6%" class="TituloTablaVerde">Tipo Contrato</td>
		  <td width="6%" class="TituloTablaVerde">Mercado</td>		  
		  <td width="6%" class="TituloTablaVerde">Fecha Inicio</td>
		  <td width="7%" class="TituloTablaVerde">Fecha Termino</td>
		  <td width="11%" class="TituloTablaVerde">Acuerdo Contractual Cu</td>
		  <td width="11%" class="TituloTablaVerde">Acuerdo Contractual Ag</td>
		  <td width="11%" class="TituloTablaVerde">Acuerdo Contractual Au</td>
		  <td width="11%" class="TituloTablaVerde">Acuerdo Contractual Otro</td>
		  <td width="7%" class="TituloTablaVerde">Vigente</td>		  		  
	  </tr>
<?
if($Buscar=='S')
{
	$Consulta = "select t4.nombre_subclase as nom_tipo,t5.nombre_subclase as nom_mercado,t1.cod_contrato,t1.cod_producto,t1.rut_proveedor,t2.nom_producto,t1.fecha_contrato,t1.duracion,t1.acuerdo_contractual_cu,t1.acuerdo_contractual_ag,t1.acuerdo_contractual_au,t1.nom_cliente,t1.vigente,t1.acuerdo_contractual_otro,t3.nombre_subclase,t6.nom_proveedor";
	$Consulta.= " from pcip_fac_contratos_compra t1 inner join pcip_fac_productos_facturas t2 on t1.cod_producto=t2.cod_producto";
	$Consulta.= " left join  proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31007' and t1.vigente=t3.cod_subclase";
	$Consulta.= " left join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31017' and t1.tipo_contrato=t4.cod_subclase";
	$Consulta.= " left join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='31008' and t1.cod_mercado=t5.cod_subclase";
	$Consulta.= " left join pcip_fac_proveedores t6 on t1.rut_proveedor=t6.rut_proveedor";	
	$Consulta.= " where t1.cod_contrato<>''";
	if($CmbContrato!='-1')
		$Consulta.=" and t1.cod_contrato='".$CmbContrato."'";
	if($CmbProveedor!='-1')
		$Consulta.=" and t1.rut_proveedor='".$CmbProveedor."'";					
	if($CmbVig!='-1')
		$Consulta.=" and t1.vigente='".$CmbVig."'";		
	if($CmbTipoContrato!='-1')
		$Consulta.=" and t1.tipo_contrato='".$CmbTipoContrato."'";				
	$Consulta.= " order by t1.cod_producto ";
	$Resp = mysql_query($Consulta);
	//echo $Consulta;
	echo "<input name='CheckTipoDoc' type='hidden'  value=''>";
	
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Cod=$Fila["cod_contrato"];
		$NomProveedor=ucfirst(strtolower($Fila["nom_proveedor"]));
		$Rut =$Fila["rut_proveedor"];
		$Pro =ucfirst(strtolower($Fila["nom_producto"]));
		$TipCon=$Fila["nom_tipo"];
		$Merc=$Fila["nom_mercado"];
		$Fecha =$Fila["fecha_contrato"];	
		$Dura =$Fila["duracion"];	
		if($Fila["acuerdo_contractual_cu"]=='')
			$AcuerdoCu ="";	
		else
			$AcuerdoCu ="Mes ".$Fila["acuerdo_contractual_cu"];	
		if($Fila["acuerdo_contractual_ag"]=='')
		    $AcuerdoAg ="";
		else
		   	$AcuerdoAg ="Mes ".$Fila["acuerdo_contractual_ag"];
		if($Fila["acuerdo_contractual_au"]=='')
		    $AcuerdoAu ="";
		else
		    $AcuerdoAu ="Mes ".$Fila["acuerdo_contractual_au"];	
		if($Fila["acuerdo_contractual_otro"]=='')								
		    $Otro ="";
		else
		 	$Otro ="Mes ".$Fila["acuerdo_contractual_otro"];	
		$Vig =$Fila["nombre_subclase"];	
		$Des=$Fila["nom_cliente"];
		
		$Clave=$Fila["cod_contrato"];
		
		if($Rut=='-1')
		  $Rut=''; 	   
?>		  	
      	<tr>
        <td  align="center"><? echo "<input name='CheckTipoDoc' class='SinBorde' type='checkbox'  value='".$Clave."'>" ?></td>
		<td align="center"><? echo $Cod; ?></td>		
        <td align="right">&nbsp;<? echo $Rut; ?></td>
		<td align="left"><? echo $NomProveedor."  ".$Des; ?>&nbsp;</td>
        <td align="left">&nbsp;<? echo $Pro; ?></td>
        <td align="left">&nbsp;<? echo $TipCon; ?></td>
        <td align="left">&nbsp;<? echo $Merc; ?></td>		
        <td align="right">&nbsp;<? echo $Fecha; ?></td>
        <td align="right">&nbsp;<? echo $Dura; ?></td>
		<td align="right"><? echo $AcuerdoCu; ?>&nbsp;</td>		
        <td align="right"><? echo $AcuerdoAg; ?>&nbsp;</td>		
        <td align="right"><? echo $AcuerdoAu; ?>&nbsp;</td>
        <td align="right"><? echo $Otro; ?>&nbsp;</td>				
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
