<? 
    header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	$Consulta="SELECT t1.rut_prev,t1.aviso_vencimiento,t6.cod_tipo_contrato,t1.tipo_ctto,t4.telefono as fonocttita,t3.telefono as fonoctto,t8.descrip_area,t7.descrip_gerencias,t6.descrip_tipo_contrato,t5.nombre_subclase as estado_ctto,t4.nombres as nom_contratista,t4.ape_paterno as ape_p_contratista,t4.ape_materno as ape_m_contratista,t3.nombres,t3.ape_paterno,t3.ape_materno,t1.cod_contrato,t1.descripcion,t1.rut_empresa,t2.razon_social,t1.fecha_inicio,t1.fecha_termino,t1.rut_adm_contrato ";
	$Consulta.=" from sget_contratos t1  left join sget_contratistas t2  on t1.rut_empresa=t2.rut_empresa ";
	$Consulta.=" left join  sget_administrador_contratos t3  on t1.rut_adm_contrato=t3.rut_adm_contrato ";
	$Consulta.=" left join  sget_administrador_contratistas t4  on t1.rut_adm_contratista=t4.rut_adm_contratista ";
	$Consulta.=" left join  proyecto_modernizacion.sub_clase t5  on t1.estado=t5.cod_subclase and t5.cod_clase='30007'";
	$Consulta.=" left join  sget_tipo_contrato t6  on t1.cod_tipo_contrato=t6.cod_tipo_contrato ";
	$Consulta.=" left join  sget_gerencias t7  on t1.cod_gerencia=t7.cod_gerencia ";
	$Consulta.=" left join  sget_areas t8  on t1.cod_area=t8.cod_area ";
	$Consulta.=" where t1.cod_contrato='".$Ctto."' ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtRutPrv=intval(substr(str_pad($Fila["rut_empresa"],10,'0',l_pad),0,8));
		$TxtDv=substr(str_pad($Fila["rut_empresa"],12,'0',l_pad),11,1);
		$TxtRazonSocial=$Fila["razon_social"];
		$TxtFono=$Fila["telefono_comercial"];
		$TxtCtto=$Fila["cod_contrato"];
		$TxtDescripCtto=$Fila["descripcion"];
		$TxtGerencia=$Fila["descrip_gerencias"];
		$TxtArea=$Fila["descrip_area"];	
		$TipoCtto=$Fila["descrip_tipo_contrato"];
		$AdmCtto=FormatearNombre($Fila["nombres"])."&nbsp;".FormatearNombre($Fila[ape_paterno])."&nbsp;".FormatearNombre($Fila[ape_materno]);
		$AdmContratista=FormatearNombre($Fila[nom_contratista])."&nbsp;".FormatearNombre($Fila[ape_p_contratista])."&nbsp;".FormatearNombre($Fila[ape_m_contratista]);
		$TxtFonoctta=$Fila["fonocttita"];
		$TxtFonoctto=$Fila["fonoctto"];
		$TxtFecInicio=$Fila["fecha_inicio"];
		$TxtFecTermino=$Fila["fecha_termino"];
		$Estado=$Fila[estado_ctto];
		$TipoCT=$Fila[tipo_ctto];
		$CmbTipoCtto=$Fila[cod_tipo_contrato];
		$TxtAviso=$Fila[aviso_vencimiento];
		$Prev=DescripcionPrev($Fila[rut_prev]);
		$DetCtto='';
	 $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase ";
	if ($CmbTipoCtto=='P')
	 $Consulta.= "where cod_clase='30003'  and cod_subclase='".$TipoCT."'";	
	if ($CmbTipoCtto=='N')
	 $Consulta.= "where cod_clase='30004'  and cod_subclase='".$TipoCT."'";	
		$Resp=mysql_query($Consulta);
		if($FilaTC=mysql_fetch_array($Resp))
		{
		$DetCtto=$FilaTC["nombre_subclase"];
		}
	}	
?>
<html>
<head>
<title>Informaci�n Contrato <? echo $TxtCtto;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<form name="FrmProceso" method="post" action="">
<input name="Ctto" type="hidden" value="<? echo $Ctto; ?>">
<table width="56%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  
  <tr>
   <td width="693">
   <table width="100%">
  <tr>
              <td align="right">			    </td>
          </tr>
   </table>
    <table width="600" border="1" align="center" cellpadding="3" cellspacing="0" >
          <tr>
            <td colspan="4"align="center" class="TituloTablaVerde">Datos Generales</td>
          </tr>
          
          <tr> 
          <td class="formulario2">Rut Empresa </td>
			 <td colspan="3" class="formulariosimple" ><?
				echo FormatearRun($TxtRutPrv."-".$TxtDv);
			 
			 ?>			&nbsp;</td>
          </tr>
          <tr> 
            <td width="211" class="formulario2">Raz&oacute;n Social  </td>
            <td colspan="3" class="formulariosimple" ><? echo FormatearNombre($TxtRazonSocial); ?></td>
          </tr>
		    
       
          <tr>
            <td height="33" class="formulario2">Contrato</td>
            <td colspan="3" class="formulariosimple" ><? echo $TxtCtto; ?>&nbsp;</td>
          </tr>
          <tr> 
		    <td height="33" class="formulario2">Descripci&oacute;n Contrato </td>
            <td colspan="3" class="formulariosimple" ><? echo FormatearNombre($TxtDescripCtto); ?></td>
          </tr>
          <tr> 
            <td height="25" class="formulario2">Adm. Contrato </td>
            <td width="284" class="formulariosimple" >
           <?
			echo $AdmCtto;
			?>&nbsp;</td>
            <td width="36"  class="formulario2">Fono</td>
            <td width="184" class="formulariosimple" ><? echo $TxtFonoctto;?>&nbsp;</td>
          </tr>
          <tr>
            <td height="25" class="formulario2">Adm. Contratista </td>
            <td class="formulariosimple" >    <? echo $AdmContratista;?>&nbsp;</td>
            <td class="formulario2" >Fono</td>
            <td class="formulariosimple" ><? echo $TxtFonoctta;?>&nbsp;</td>
          </tr>
          <tr>
            <td height="25" class="formulario2">Prevencionista</td>
            <td colspan="3" class="formulariosimple" ><? echo str_replace('~','   ',$Prev); ?></td>
          </tr>
        </table>	  </tr>
  </table>
		 <br>
</form>
</body>
</html>