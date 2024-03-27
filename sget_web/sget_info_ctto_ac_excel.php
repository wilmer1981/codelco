<? 
    include("../principal/conectar_sget_web.php");
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

	$Consulta="SELECT t1.aviso_vencimiento,t6.cod_tipo_contrato,t1.tipo_ctto,t4.telefono as fonocttita,t3.telefono as fonoctto,t8.descrip_area,t7.descrip_gerencias,t6.descrip_tipo_contrato,t5.nombre_subclase as estado_ctto,t4.nombres as nom_contratista,t4.ape_paterno as ape_p_contratista,t4.ape_materno as ape_m_contratista,t3.nombres,t3.ape_paterno,t3.ape_materno,t1.cod_contrato,t1.descripcion,t1.rut_empresa,t2.razon_social,t1.fecha_inicio,t1.fecha_termino,t1.rut_adm_contrato ";
	$Consulta.=" from sget_contratos t1  left join sget_contratistas t2  on t1.rut_empresa=t2.rut_empresa ";
	$Consulta.=" left join  sget_administrador_contratos t3  on t1.rut_adm_contrato=t3.rut_adm_contrato ";
	$Consulta.=" left join  sget_administrador_contratistas t4  on t1.rut_adm_contratista=t4.rut_adm_contratista ";
	$Consulta.=" left join  proyecto_modernizacion.sub_clase t5  on t1.estado=t5.cod_subclase and t5.cod_clase='30007'";
	$Consulta.=" left join  sget_tipo_contrato t6  on t1.cod_tipo_contrato=t6.cod_tipo_contrato ";
	$Consulta.=" left join  sget_gerencias t7  on t1.cod_gerencia=t7.cod_gerencia ";
	$Consulta.=" left join  sget_areas t8  on t1.cod_area=t8.cod_area ";
	$Consulta.=" where t1.cod_contrato='".$Ctto."' ";
	$Resp=mysqli_query($link, $Consulta);
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
		$AdmCtto=$Fila["nombres"]."&nbsp;".$Fila[ape_paterno]."&nbsp;".$Fila[ape_materno];
		$AdmContratista=$Fila[nom_contratista]."&nbsp;".$Fila[ape_p_contratista]."&nbsp;".$Fila[ape_m_contratista];
		$TxtFonoctta=$Fila["fonocttita"];
		$TxtFonoctto=$Fila["fonoctto"];
		$TxtFecInicio=$Fila["fecha_inicio"];
		$TxtFecTermino=$Fila["fecha_termino"];
		$Estado=$Fila[estado_ctto];
		$TipoCT=$Fila[tipo_ctto];
		$CmbTipoCtto=$Fila[cod_tipo_contrato];
		$TxtAviso=$Fila[aviso_vencimiento];
		$DetCtto='';
	 $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase ";
	if ($CmbTipoCtto=='P')
	 $Consulta.= "where cod_clase='30003'  and cod_subclase='".$TipoCT."'";	
	if ($CmbTipoCtto=='N')
	 $Consulta.= "where cod_clase='30004'  and cod_subclase='".$TipoCT."'";	
		$Resp=mysqli_query($link, $Consulta);
		if($FilaTC=mysql_fetch_array($Resp))
		{
		$DetCtto=$FilaTC["nombre_subclase"];
		}
	}	
?>
<html>
<head>
<title>Informaci�n Contrato <? echo $TxtCtto;?></title>
</head>
<form name="FrmProceso" method="post" action="">
<input name="Ctto" type="hidden" value="<? echo $Ctto; ?>">
<table  border="1" >
          <tr>
            <td colspan="4" align="center" >Datos Generales</td>
          </tr>
          <tr>
            <td >Gerencia</td>
            <td ><?
				echo $TxtGerencia;
			 
			 ?>		&nbsp;</td>
            <td width="98" >Area</td>
            <td width="105" ><?
				echo $TxtArea;
			 
			 ?>		&nbsp;</td>
          </tr>
          <tr> 
          <td >Rut Empresa </td>
			 <td ><?
				echo $TxtRutPrv."-".$TxtDv;
			 
			 ?>			</td>
             <td >Estado</td>
             <td ><? echo $Estado; ?>&nbsp;</td>
          </tr>
          <tr> 
            <td width="167" >Raz&oacute;n Social  </td>
            <td colspan="3" ><? echo $TxtRazonSocial; ?></td>
          </tr>
		    
       
          <tr>
            <td >Contrato</td>
            <td ><? echo $TxtCtto; ?></td>
            <td  >Tipo Contrato </td>
            <td ><? echo $TipoCtto;?>&nbsp;
			
			<? echo $DetCtto;?>			</td>
          </tr>
          <tr> 
		    <td  >Descripci&oacute;n Contrato </td>
            <td colspan="3" ><? echo $TxtDescripCtto; ?></td>
          </tr>
          <tr> 
            <td  >Adm. Contrato </td>
            <td >
           <?
			echo $AdmCtto;
			?>&nbsp;</td>
            <td  >Fono</td>
            <td ><? echo $TxtFonoctto;?>&nbsp;</td>
          </tr>
          <tr>
            <td  >Adm. Contratista </td>
            <td >    <? echo $AdmContratista;?>&nbsp;</td>
            <td  >Fono</td>
            <td ><? echo $TxtFonoctta;?>&nbsp;</td>
          </tr>
          <tr>
            <td  >Fecha Inicio </td>
            <td ><? echo $TxtFecInicio; ?></td>
            <td  >Fecha Termino </td>
            <td ><? echo $TxtFecTermino; ?></td>
          </tr>
          <tr>
            <td  >Aviso Vencimiento </td>
            <td ><? echo $TxtAviso;?>&nbsp;Meses</td>
            <td  >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
        </table>	
		<br>
<table border="1">
  <tr>
	<td align="center" >Run</td>
   	<td align="center" >Nombre</td>  
	<td align="center" >Direcci�n</td> 
	<td align="center" >Nro. Tarjeta</td>
	<td align="center" >Sexo</td>
	<td align="center" >Afp</td>
	<td align="center" >Sindicato</td>
	<td align="center" >Estado</td>     
 	</tr>
	<?
	$Consulta="Select t1.rut,t1.nombres,t1.ape_paterno,t1.ape_materno,t1.direccion,t1.nro_tarjeta,t1.estado,t2.nom_comuna,t1.sexo,t3.descripcion_afp as nom_afp,t4.descripcion as nom_sindicato ";
	$Consulta.="from sget_personal t1 LEFT JOIN SGET_COMUNAS t2 on t1.cod_comuna=t2.cod_comuna left join sget_afp t3 on t1.cod_afp=t3.cod_Afp ";
	$Consulta.="left join sget_sindicato t4 on t1.cod_sindicato=t4.cod_sindicato where t1.cod_contrato='".$Ctto."'";
	$Respd=mysqli_query($link, $Consulta);
	while($Filad=mysql_fetch_array($Respd))
	{
	?>
	<tr>
    <td align="center"><? echo $Filad["rut"];?>&nbsp;</td>
   	<td ><? echo $Filad["nombres"]."&nbsp;".$Filad[ape_paterno]."&nbsp;".$Filad[ape_materno];?>&nbsp;</td>  
	<td ><? echo $Filad["direccion"].", ".$Filad[nom_comuna];?>&nbsp;</td> 
	<td align="center"><? echo $Filad[nro_tarjeta];?>&nbsp;</td>
	<td align="center"><? echo $Filad[sexo];?>&nbsp;</td>
	<td ><? echo $Filad[nom_afp];?>&nbsp;</td>
	<td ><? echo $Filad[nom_sindicato];?>&nbsp;</td>
	<td align="center"><? echo $Filad["estado"];?>&nbsp;</td>   
	</tr>
	<?
	}
	?>	  		  
</table>
</form>
</body>
</html>