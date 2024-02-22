<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
if(!isset($Cons))
	$Cons='S';
?>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function NuevoUser(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
			f.action='sget_mantenedor_prevencionista.php?Cons=S';
			f.submit();
			break;
		case "N":
			URL="sget_mantenedor_prevencionista_proceso.php?Opc="+Opc;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=850,height=700,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckRut','M'))
			{
				Datos=Recuperar(f.name,'CheckRut');
				URL="sget_mantenedor_prevencionista_proceso.php?Opc="+Opc+"&Valores="+Datos;
				opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=850,height=700,scrollbars=1';
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
			}	
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckRut','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckRut');
					f.action='sget_mantenedor_prevencionista01.php?Opcion=E&Valor='+Datos;
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
<title>Mantenedor de Prevencionista</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="" >
  <?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina2($IP_SERV,'mant_prev.png')
 ?>
  <table width="950"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td><table width="100%"  cellspacing="0">
          <tr>
            <td height="35" colspan="4" align="left" class="formulario2"   ><img src="archivos/images/interior/t_buscadorGlobal4.png" /> </td>
            <td colspan="2" align="right" class="formulario2" >
			<a href="JavaScript:NuevoUser('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:NuevoUser('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:NuevoUser('M')"><img src="archivos/btn_modificar3.png" border="0" alt="Modificar" align="absmiddle"></a>&nbsp;
			<a href="JavaScript:NuevoUser('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>&nbsp;	
			<a href="JavaScript:NuevoUser('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>            </td>
          </tr>
          <tr>
            <td class="formulario2">Nombres</td>
            <td class="formulario2"><input name="TxtNombres" type="text" id="TxtNombres" value="<? echo $TxtNombres; ?>" size="30" /></td>
            <td class="formulario2">Razon Social (Empresa) </td>
            <td class="formulario2"><input name="TxtRegistro" type="text" id="TxtRegistro" value="<? echo $TxtRegistro; ?>" /></td>
            <td class="formulario2">&nbsp;</td>
            <td class="formulario2">&nbsp;</td>
            <? 
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
          <tr>
            <td class="formulario2">Apellido Paterno  </td>
            <td class="formulario2"><input name="TxtApellidoPaterno" type="text" id="TxtApellidoPaterno" value="<? echo $TxtApellidoPaterno; ?>" size="30" /></td>
            <td width="21%" class="formulario2">Apellido Materno </td>
            <td colspan="3" class="formulario2"><input name="TxtApellidoMaterno" type="text" id="TxtApellidoMaterno" value="<? echo $TxtApellidoMaterno; ?>" size="30" /></td>
          </tr>
          <tr>
            <td class="formulario2">Estado</td><? if(!isset($CmbEstado)) $CmbEstado='-1';?>
            <td class="formulario2"><SELECT name="CmbEstado" >
            <option value="-1" class="NoSelec">Todos</option>
            <?
				$Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30007' ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbEstado==$FilaTC["cod_subclase"])
						echo "<option SELECTed value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			?>
           </SELECT>&nbsp;</td>
            <td class="formulario2">&nbsp;</td>
            <td colspan="3" class="formulario2">&nbsp;</td>
          </tr>
          
      </table></td>
      <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>
  <p>
  <table width="1000" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
  <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
  <td width="920" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
  <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
</tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">		
       <tr>
         <td width="3%" class="TituloTablaVerde"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckRut','ChkTodos');"></td>
          <td width="30%" align="center" class="TituloTablaVerde">Nombres</td>
          <td width="11%" align="center" class="TituloTablaVerde">Rut </td>
          <td width="13%" align="center" class="TituloTablaVerde">Telefono&nbsp;1</td>
          <td width="13%" align="center" class="TituloTablaVerde">Telefono&nbsp;2</td>
          <td width="13%" align="center" class="TituloTablaVerde">Correo&nbsp;1</td>
          <td width="13%" align="center" class="TituloTablaVerde">Correo&nbsp;2</td>
          <td width="13%" align="center" class="TituloTablaVerde">Registro Sernageomin</td>
          <td width="13%" align="center" class="TituloTablaVerde">Registro SNS</td>
          <td width="13%" align="center" class="TituloTablaVerde">T�tulo<br>Profesional</td>
          <td width="13%" align="center" class="TituloTablaVerde">Empresa</td>
          <td width="13%" align="center" class="TituloTablaVerde">Contrato</td>
          <td width="30%" align="center" class="TituloTablaVerde">Direcci&oacute;n</td>
		  <td width="13%" align="center" class="TituloTablaVerde">Estado</td>
		  <td width="13%" align="center" class="TituloTablaVerde">Observaci�n</td>
		  <td width="20%" align="center" class="TituloTablaVerde">Documentos</td>
       </tr>
  <?


if($Cons=='S')
{
	$Consulta = "SELECT t1.*,t2.nombre_subclase as estado_prev,t3.rut_empresa,t3.cod_contrato from sget_prevencionistas t1 ";
	$Consulta.=" left join  proyecto_modernizacion.sub_clase t2  on t1.estado=t2.cod_subclase and t2.cod_clase='30007'";
	$Consulta.=" left join sget_personal t3 on t3.rut=t1.rut_prev";
	$Consulta.=" left join sget_contratistas t4 on t4.rut_empresa=t3.rut_empresa";
	$Consulta.=" where not isnull(rut_prev)  ";
	if($TxtRegistro!='')
		$Consulta.= " and razon_social like ('%".$TxtRegistro."%') ";
	if($TxtNombres!='')
		$Consulta.= " and upper(t1.nombres) like ('%".strtoupper($TxtNombres)."%') ";
	if($TxtApellidoPaterno!='')
		$Consulta.= " and upper(t1.apellido_paterno) like ('%".strtoupper($TxtApellidoPaterno)."%') ";
	if($TxtApellidoMaterno!='')
		$Consulta.= " and upper(t1.apellido_materno) like ('%".strtoupper($TxtApellidoMaterno)."%') ";
	if($CmbEstado!='-1')		
		$Consulta.= " and t1.estado='".$CmbEstado."' ";
	$Consulta.=" order by t1.apellido_paterno,t1.apellido_materno,t1.nombres";
	//echo 	$Consulta;
	$Resp = mysql_query($Consulta);
	echo "<input name='CheckRut' type='hidden'  value=''>";
	$cont=1;
	while($Fila=mysql_fetch_array($Resp))
	{
		$Run=FormatearRun($Fila[rut_prev]);
		$CEmp="SELECT razon_social from sget_contratistas where rut_empresa='".$Fila[rut_empresa]."'";
		$REmp=mysql_query($CEmp);
		//echo $CEmp."<br>";
		$FEmp=mysql_fetch_array($REmp);
		if($Fila["rut_empresa"]!='')
			$Empresa=$Fila["rut_empresa"]." - ".$FEmp[razon_social];
		else
			$Empresa="<span class='InputRojo'>Sin Registro Gesti�n Tercero</span>";	

		$RCont=mysql_query('SELECT descripcion from sget_contratos where cod_contrato="'.$Fila["cod_contrato"].'"');
		$FCont=mysql_fetch_array($RCont);
		if($Fila["cod_contrato"]!='')
			$Contrato=$Fila["cod_contrato"]." - ".$FCont["descripcion"];
		else
			$Contrato="<span class='InputRojo'>Sin Registro Gesti�n Tercero</span>";	
		
		$SeparoRegis=explode('~',$Fila[regis_sns_serg]);
		$TxtSerga=$SeparoRegis[0];
		$TxtSNS=$SeparoRegis[1];
?>     	<tr> 
    <td ><? echo "<input name='CheckRut' class='SinBorde' type='checkbox'  value='".$Fila["rut_prev"]."'>" ?></td>
	      <td ><? echo FormatearNombre($Fila["nombres"])." ".FormatearNombre($Fila["apellido_paterno"])." ".FormatearNombre($Fila["apellido_materno"]); ?></td>
          <td ><? echo $Run."&nbsp;"; ?></td>
          <td ><? echo $Fila["telefono"]."&nbsp;"; ?></td>
          <td ><? echo $Fila["celular"]."&nbsp;"; ?></td>
          <td ><? echo $Fila["email_1"]."&nbsp;"; ?></td>
          <td ><? echo $Fila["email_2"]."&nbsp;"; ?></td>
          <td ><? echo $TxtSerga."&nbsp;"; ?></td>
          <td ><? echo $TxtSNS."&nbsp;"; ?></td>
          <td ><? echo $Fila["titulo"]."&nbsp;"; ?></td>
          <td ><? echo $Empresa."&nbsp;"; ?></td>
          <td ><? echo $Contrato."&nbsp;"; ?></td>
          <td ><? echo $Fila["direccion"]."&nbsp;"; ?></td>
		  <td width="13%" ><? echo $Fila["estado_prev"]."&nbsp;"; ?></td>
		  <td width="13%" ><textarea name="Obs" cols="20"><? echo $Fila["observacion"]; ?></textarea></td>
		  <td >
		  <?
		  	$Curri=str_replace('_','&nbsp;',$Fila[curriculum]);
		  	$Titulo=str_replace('_','&nbsp;',$Fila[titulo_prof]);
		  	$Serna=str_replace('_','&nbsp;',$Fila[res_serna]);
		  	$SNS=str_replace('_','&nbsp;',$Fila[res_sns]);
		  	echo "<a href=doc/".$Fila[curriculum]."  target='_blank'>".$Curri."</a><br>";
		  	echo "<a href=doc/".$Fila[titulo_prof]."  target='_blank'>".$Titulo."</a><br>";
		  	echo "<a href=doc/".$Fila[res_serna]."  target='_blank'>".$Serna."</a><br>";
		  	echo "<a href=doc/".$Fila[res_sns]."  target='_blank'>".$SNS."</a>";
		  ?>
		  </td>
  </tr>
  <?		$cont++;
	}
}
?>			
</table></td><td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>
  <?
CierreEncabezado2()
?>
</form>
<?
if($Mensaje=='S')
{
?>
<script language="javascript">
alert("No se pueden Eliminar, Tiene Requerimientos Asociados")
</script>
<? }?>