<? include("../principal/conectar_sget_web.php");
$readonly="";
if($Opc=='A')
{
	if($CmbAdmCtto=='-1')
		$OpcionAux='N';
	else
	{	
		$OpcionAux='M';
		$Consulta="SELECT * from sget_administrador_contratos where rut_adm_contrato='".$CmbAdmCtto."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$TxtRutPrv=substr($Fila[rut_adm_contrato],0,strlen($Fila[rut_adm_contrato])-2);
			$TxtDv=substr($Fila[rut_adm_contrato],strlen($Fila[rut_adm_contrato])-1);
			$TxtNombres=$Fila["nombres"];
			$TxtApePaterno=$Fila[ape_paterno];
			$TxtApeMaterno=$Fila[ape_materno];
			$TxtEmail=$Fila[email];
			$TxtTelefono=$Fila[telefono];
			$CmbCargo=$Fila[cargo];
			$readonly="readonly";
		}
		
	}
}	
else
{	
	if($CmbAdmContratista=='-1')
		$OpcionAux='N';
	else
	{	
		$OpcionAux='M';
		$Consulta="SELECT * from sget_administrador_contratistas where rut_adm_contratista='".$CmbAdmContratista."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$TxtRutPrv=substr($Fila[rut_adm_contratista],0,strlen($Fila[rut_adm_contratista])-2);
			$TxtDv=substr($Fila[rut_adm_contratista],strlen($Fila[rut_adm_contratista])-1);
			$TxtNombres=$Fila["nombres"];
			$TxtApePaterno=$Fila[ape_paterno];
			$TxtApeMaterno=$Fila[ape_materno];
			$TxtEmail=$Fila[email];
			$TxtTelefono=$Fila[telefono];
			$CmbCargo=$Fila[cargo];
			$readonly="readonly";
		}
	
	}
	
}	
	if($Cargo!='')
	$CmbCargo=$Cargo;
?>
<html>
<head>
<title><? echo $Titulo;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function AgregarCargo()
{
	var f = document.FrmPopupProceso;
	URL = "../sget_web/sget_mantenedor_cargos_proceso.php?Volver=S&Valores="+f.CmbCargo.value+"&Form="+f.name+"&Pagina=sget_ingreso_administradores.php";
	window.open(URL,"","top=30,left=30,width=650,height=400,menubar=no,status=1,resizable=yes,scrollbars=yes");
}
function Proceso(Opcion)
{

	var f= document.FrmPopupProceso;
	var Veri=false
	switch(Opcion)
	{
		case "G":
			Veri=ValidaCampos();
			if (Veri==true)
			{
				f.action = "sget_ingreso_administradores01.php?Selec="+Opcion
				f.submit();
			}
		break;
		case "E":
			f.action = "sget_ingreso_administradores01.php?Selec="+Opcion
			f.submit();
		break;
		
	}
}
function Salir()
{
	window.close();
}
function ValidaCampos()
{
	var f= document.FrmPopupProceso;
	var Res=true;
	if (f.TxtRutPrv.value=="")
	{
		alert("Debe Ingresar Run");
		f.TxtRutPrv.focus();
		Res=false;
		return;
	}
	if (f.TxtNombres.value=="")
	{
		alert("Debe Ingresar TxtNombres");
		f.TxtNombres.focus();
		Res=false;
		return;
	}
	if (f.TxtApePaterno.value=="")
	{
		alert("Debe Ingresar Apellido Paterno");
		f.TxtApePaterno.focus();
		Res=false;
		return;
	}
	return(Res);
	if (f.TxtApeMaterno.value=="")
	{
		alert("Debe Ingresar Apellido Materno");
		f.TxtApeMaterno.focus();
		Res=false;
		return;
	}
	return(Res);
}

</script>
</head>
<?
	echo '<body onLoad="document.FrmPopupProceso.TxtRutPrv.focus();">';
?>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Opc01" value="<? echo $Opc;?>">
<input type="hidden" name="Volver" value="<? echo $Volver;?>">
<input type="hidden" name="NumHoja" value="<? echo $NumHoja;?>">
<input type="hidden" name="Opcion01" value="<? echo $Opcion;?>">
<input type="hidden" name="TxtContrato01" value="<? echo $TxtContrato;?>">
<input type="hidden" name="TxtDescripcion01" value="<? echo $TxtDescripcion;?>">
<input type="hidden" name="TxtAreaTrabajo01" value="<? echo $TxtAreaTrabajo;?>">
<input type="hidden" name="TxtMontoCtto01" value="<? echo $TxtMontoCtto;?>">
<input type="hidden" name="TxtFechaInicio01" value="<? echo $TxtFechaInicio;?>">
<input type="hidden" name="TxtFechaTermino01" value="<? echo $TxtFechaTermino;?>">
<input type="hidden" name="CmbTipoCtto01" value="<? echo $CmbTipoCtto;?>">
<input type="hidden" name="CmbAdmCtto01" value="<? echo $CmbAdmCtto;?>">
<input type="hidden" name="TxtFechaSolp01" value="<? echo $TxtFechaSolp;?>">
<input type="hidden" name="CmbAdmContratista01" value="<? echo $CmbAdmContratista;?>">
<input type="hidden" name="CmbCargo01" value="<? echo $CmbCargo;?>">
<input type="hidden" name="TxtCelular01" value="<? echo $TxtCelular;?>">
<input type="hidden" name="CmbEmpresa01" value="<? echo $CmbEmpresa;?>">
<input type="hidden" name="TxtFechaGarantia01" value="<? echo $TxtFechaGarantia;?>">
<input type="hidden" name="CmbPrevencionista01" value="<? echo $CmbPrevencionista;?>">
<input type="hidden" name="CmbMoneda01" value="<? echo $CmbMoneda;?>">
<input type="hidden" name="CmbTipoCttoPers01" value="<? echo $CmbTipoCttoPers;?>">
<input type="hidden" name="TxtCodigo" value="<? echo $TxtCodigo;?>">
  <table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="212" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="79%" align="left"><? if($Opc=='A'){if($OpcionAux=='N'){?><img src="archivos/sub_tit_adm_ctto_n.png"><? }else{?><img src="archivos/sub_tit_adm_ctto_m.png"><? }}else{if($OpcionAux=='N'){?><img src="archivos/sub_tit_adm_ctta_n.png"><? }else{?> <img src="archivos/sub_tit_adm_ctta_m.png"><? }}?></td>
       <td width="21%" align="right"><a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a>
	   <a href="JavaScript:Proceso('E')"><img src="archivos/elim_hito.png" alt="Guardar"  border="0" align="absmiddle" /></a>
	   <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="0" >
         <tr>
           <td class="formulario2">Run</td>
           <td class="formulariosimple" ><?
			echo "<input name='TxtRutPrv'  $readonly type='text'   value='".$TxtRutPrv."' size='12' maxlength='8' onBlur=CalculaDv(this.form,'TxtRutPrv','TxtDv') onKeyDown=\"ValidaIngreso('S',false,this.form,'TxtDv')\">";//Numerico,Decimales,formulario,Salto
			?>
               <input name="TxtDv" type="text" <? echo $readonly;?> id="TxtDv" value="<? echo $TxtDv;?>"  size="3" maxlength="1">
               <span class="InputRojo">(*)</span>                </tr>
         <tr>
           <td class="formulario2">Nombres</td>
           <td class="formulariosimple" ><input name="TxtNombres" type="text" id="TxtNombres" style="width:100" value="<? echo $TxtNombres; ?>" >
               <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td class="formulario2">Apellido&nbsp;Paterno </td>
           <td class="formulariosimple" ><input name="TxtApePaterno" type="text" id="TxtApePaterno" style="width:150" value="<? echo $TxtApePaterno; ?>" >
               <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td class="formulario2">Apellido&nbsp;Materno</td>
           <td class="formulariosimple" ><input name="TxtApeMaterno" type="text" id="TxtApeMaterno" style="width:150" value="<? echo $TxtApeMaterno; ?>" >
             <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td class="formulario2">E-Mail</td>
           <td class="formulariosimple" ><input name="TxtEmail" type="text" id="TxtEmail" style="width:150"  maxlength="200" value="<? echo $TxtEmail; ?>" ></td>
         </tr>
         <tr>
           <td width="111" class="formulario2">Tel&eacute;fono</td>
           <td width="382" class="formulariosimple" ><input name="TxtTelefono" type="text" id="TxtTelefono"   maxlength="50" style="width:150" value="<? echo $TxtTelefono; ?>" ></td>
         </tr>
         <tr>
           <td class="formulario2">Cargo</td>
           <td class="formulariosimple" ><SELECT name="CmbCargo" style="width:250">
               <option value="S" SELECTed="SELECTed">Seleccionar / Agregar</option>
               <?
		$Consulta="SELECT * from sget_cargos where estado='1' order by descrip_cargo";
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($CmbCargo==$Fila[cod_cargo])
				echo "<option value='".$Fila[cod_cargo]."' SELECTed>".$Fila[descrip_cargo]."</option>";
			else	
				echo "<option value='".$Fila[cod_cargo]."'>".$Fila[descrip_cargo]."</option>";
		}
		?>
           </SELECT> &nbsp;<a href="JavaScript:AgregarCargo()"><img src="archivos/btn_agregar2.png" height="20" width="20" alt="Agregar "align="absmiddle" border="0"></a> </td>
         </tr>
         <tr>
           <td colspan="2" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
         </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   <br></td>
   <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>			
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje=='S')
		echo "alert('Este Registro ya Existe');";
	echo "</script>";
?>