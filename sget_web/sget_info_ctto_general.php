<? 
    include("../principal/conectar_sget_web.php");
    //include("funciones/sget_funciones.php");
	$Consulta="SELECT * from sget_contratos where cod_contrato = '".$Ctto."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtContrato=$Fila["cod_contrato"];
		$TxtDescripcion=$Fila["descripcion"];
		$CmbGerencias=$Fila["cod_gerencia"];
		$CmbAreas=$Fila["cod_area"];
		$TxtMontoCtto=$Fila["monto_ctto"];
		$TxtFechaInicio=$Fila["fecha_inicio"];
		$TxtFechaTermino=$Fila["fecha_termino"];
		$CmbEmpresa=$Fila["rut_empresa"];
		$CmbTipoCtto=$Fila["cod_tipo_contrato"];
		$CmbAdmCtto=$Fila["rut_adm_contrato"];
		$CmbAdmContratista=$Fila["rut_adm_contratista"];
		$TxtFechaGarantia=$Fila["fecha_venc_bol_garantia"];
		$TxtCelular=$Fila["celular"];
		$TxtFechaSolp=$Fila["fecha_solp"];	
		$CmbPrevencionista=$Fila["rut_prev"];	
		$CmbMoneda=$Fila["tipo_cambio"];	
		$CmbTipoCttoPers=$Fila["tipo_ctto"];
		if($TxtFechaSolp=='0000-00-00')
			$TxtFechaSolp='';
		$FechaActual=date("Y")."-".date("m")."-".date("d");	
		$Consulta="SELECT * from sget_contratos where fecha_termino >= '".$FechaActual."' and cod_contrato='".$Ctto."'";
		$RespCtto=mysqli_query($link, $Consulta);
		if($FilaCtto=mysql_fetch_array($RespCtto))
			$CmbEstado='ACTIVO';
		else
			$CmbEstado='INACTIVO';
		$TxtAviso=$Fila["aviso_vencimiento"];
		//ACUERDOS MARCOS
		$CmbBono=$Fila[bono];
		$CmbReaj=$Fila[reajuste];
		$CmbSeg=$Fila[seguro];
		$CmbEco4=$Fila[eco4];
		$CmbSobreT=$Fila[sobreTiempo];
		$CmbGratif=$Fila[gratificacion];
		$CmbIndem=$Fila[indemnizacion];
				
		//$CmbEstado=$Fila["estado"];	
	}
?>
    <br>
	<table width="101%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
          <tr> 
          <td class="formulario2">Nro.&nbsp;Contrato </td>
			 <td colspan="3" class="formulariosimple" ><? echo $TxtContrato;?></td>
          </tr>
          <tr> 
            <td width="210" class="formulario2">Descripci&oacute;n</td>
            <td colspan="3" class="formulariosimple" ><?  echo FormatearNombre($TxtDescripcion); ?></tr>
		  <tr> 
		    <td height="33" class="formulario2">Gerencia </td>
            <td class="formulariosimple" >
              <?
			  $Consulta = "SELECT cod_gerencia,descrip_gerencias from sget_gerencias where cod_gerencia='".$CmbGerencias."' order by descrip_gerencias ";			
			  $Resp4=mysqli_query($link, $Consulta);
			  while ($Fila4=mysql_fetch_array($Resp4))
			  {
					echo $Fila4["descrip_gerencias"];
			  }
			 ?>            </td>
            <td class="formulario2">Areas&nbsp;&nbsp;</td>
            <td class="formulariosimple" ><?
			  $Consulta = "SELECT cod_area,descrip_area,cod_cc from sget_areas where cod_gerencia='".$CmbGerencias."' and cod_area='".$CmbAreas."' order by descrip_area ";			
			  $Resp4=mysqli_query($link, $Consulta);
			  while ($Fila4=mysql_fetch_array($Resp4))
			  {
				echo $Fila4["cod_cc"]." - ".$Fila4["descrip_area"];
			  }
			 ?></td>
		  </tr>
          <tr> 
            <td height="25" class="formulario2">Monto&nbsp;Contrato </td>
            <td colspan="3" class="formulariosimple" >
			<? echo  number_format($TxtMontoCtto,0,'','.'); ?>
			  <?
			  $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30002' and cod_subclase='".$CmbMoneda."'";			
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					echo ucfirst($FilaTC["nombre_subclase"]);
				}
				?>          </td> 
	      </tr>

          <tr>
            <td class='formulario2'>Empresa</td>
            <td colspan="3" class="formulariosimple" >
		  <? 
		    $Consulta = "SELECT * from sget_contratistas where estado='1' and rut_empresa='".$CmbEmpresa."'";
			$Consulta.= " order by razon_social ";
			$Resp=mysqli_query($link, $Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				echo FormatearRun($FilaTC["rut_empresa"])." - ".FormatearNombre($FilaTC["razon_social"]);
			}
			?>          </tr>
          <tr>
    <td width="210"class='formulario2'>Fecha&nbsp;Inicio </td>
    <td width="443" class="formulariosimple" >
	
	<? echo $TxtFechaInicio; ?>&nbsp;
    <td width="206" class="formulario2" >Fecha&nbsp;Termino     
    <td width="351" class="formulariosimple" ><? echo $TxtFechaTermino; ?></td>
          </tr>
     <tr>
            <td height="25" class="formulario2">Tipo Contrato </td>
            <td class="formulariosimple" >
      <?
		 $Consulta = "SELECT * from sget_tipo_contrato where cod_tipo_contrato='".$CmbTipoCtto."'";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			echo ucfirst($FilaTC["descrip_tipo_contrato"]);
		}
			?>
   
	<? 
	if($CmbTipoCtto=='P' || $CmbTipoCtto=='N' )
	{
	   $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase ";
	   if ($CmbTipoCtto=='P')
	      $Consulta.= "where cod_clase='30003' ";	
	   if ($CmbTipoCtto=='N')
	      $Consulta.= "where cod_clase='30004' ";	
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoCttoPers==$FilaTC["cod_subclase"])
				echo "<option SELECTed value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
	}
	?>       </td>
       <td class="formulario2" >Fecha de Reuni&oacute;n de Arranque </td>
       <td class="formulariosimple" ><? echo $TxtFechaGarantia; ?></td>
      </tr>
   
           <tr>
               <td height="28" class="formulario2">Adm. Contrato </td>
             <td class="formulariosimple" >
        <?
	    $Consulta = "SELECT * from sget_administrador_contratos where rut_adm_contrato='".$CmbAdmCtto."' order by ape_paterno ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			$Nom=$FilaTC["ape_paterno"]." ".$FilaTC["ape_materno"]."  ".$FilaTC["nombres"];
			echo FormatearNombre($Nom)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fono: ".$FilaTC["telefono"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mail: ".$FilaTC["email"];
		}
			?>             </td> 
             <td class="formulariosimple" >&nbsp;</td>
             <td class="formulariosimple" >&nbsp;</td>
           </tr>
           
           <tr>
             <td height="14" class="formulario2">Prevencionista</td>
             <td colspan="3" class="formulariosimple" >
               <?
			  $Consulta = "SELECT * from sget_prevencionistas";
			  //  t1 left join proyecto_modernizacion.clase t2 on t1.cod_clase=t2.cod_clase  left join proyecto_modernizacion.sub_clase t3 on t1.cod_subclase=t3.cod_subclase and t1.cod_clase=t3.cod_clase  ";
			  $Consulta.= " where rut_prev='".$CmbPrevencionista."' order by apellido_paterno ";			
			  $Resp4=mysqli_query($link, $Consulta);
			  while ($Fila4=mysql_fetch_array($Resp4))
			  {
			    $SernaSNS=explode('~',$Fila4[regis_sns_serg]);
				$Nom=$Fila4["nombres"]." ".$Fila4["apellido_paterno"];
				echo FormatearRun($Fila4["rut_prev"])." - ".FormatearNombre($Nom)." &nbsp;&nbsp;&nbsp;Registro Sernageomin:".$SernaSNS[0]." &nbsp;&nbsp;&nbsp;Registro SNS:".$SernaSNS[1]." &nbsp;&nbsp;&nbsp;fono:".$Fila4["telefono"] ;
			  }
			 ?>
             </SELECT></td>
           </tr>
           <tr>
             <td height="14" class="formulario2">Adm. Contratista </td>
             <td colspan="3" class="formulariosimple" >
             <?
			$Consulta = "SELECT * from sget_administrador_contratistas where rut_adm_contratista='".$CmbAdmContratista."'order by ape_paterno ";			
			$Resp=mysqli_query($link, $Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				$Nom=$FilaTC["ape_paterno"]." ".$FilaTC["ape_materno"]."  ".$FilaTC["nombres"];
				echo FormatearRun($FilaTC["rut_adm_contratista"])." - ".FormatearNombre($Nom)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fono: ".$FilaTC["telefono"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mail: ".$FilaTC["email"];
				
			
			}
			?>        </td>
           </tr>
           <tr>
             <td height="14" class="formulario2">Aviso Vencimiento </td>
             <td colspan="3" class="formulariosimple" ><? echo $TxtAviso;?>&nbsp;Meses</td>
           </tr>   
           <tr>
             <td height="14" colspan="4" align="center"class="TituloTablaVerde">Control Acuerdos Marcos </td>
           </tr>   
           <tr>
             <td height="14" colspan="4" class="formulario2"><table width="100%" border="0" cellspacing="2" cellpadding="0">
               <tr>
                 <td width="19%" class="formulario2">Bono Anual </td>
                 <td width="18%"><span class="formulariosimple"><? echo $CmbBono;?></span></td>
                 <td width="9%" class="formulario2">Eco4</td>
                 <td width="17%"><span class="formulariosimple"><? echo $CmbEco4;?></span></td>
                 <td width="9%" class="formulario2">Gratificaci&oacute;n</td>
                 <td width="28%"><span class="formulariosimple"><? echo $CmbGratif;?></span></td>
               </tr>
               <tr>
                 <td class="formulario2">Reajustabilidad</td>
                 <td><span class="formulariosimple"><? echo $CmbReaj;?></span></td>
                 <td class="formulario2">SobreTiempo</td>
                 <td><span class="formulariosimple"><? echo $CmbSobreT;?></span></td>
                 <td class="formulario2">Indemnizaci&oacute;n</td>
                 <td><span class="formulariosimple"><? echo $CmbIndem;?></span></td>
               </tr>
               <tr>
                 <td class="formulario2">Seguro Complementario de Salud </td>
                 <td><span class="formulariosimple"><? echo $CmbSeg;?></span></td>
                 <td class="formulario2">&nbsp;</td>
                 <td>&nbsp;</td>
                 <td class="formulario2">&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
             </table></td>
           </tr> 
          <tr>
             <td height="14" class="formulario2">Estado</td>
             <td colspan="3" class="formulariosimple" >
               <?
	    /*$Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30007' and cod_subclase='".$CmbEstado."'";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			echo ucfirst($FilaTC["nombre_subclase"]);
		}*/
			echo $CmbEstado;
			?>           </td>
      </tr>   
</table>
<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr>
	<td align="center" class="TituloTablaVerde">Run</td>
   	<td align="center" class="TituloTablaVerde">Nombre</td>  
	<td align="center" class="TituloTablaVerde">Direcci�n</td> 
	<td align="center" class="TituloTablaVerde">N� Tarjeta</td>
	<td align="center" class="TituloTablaVerde">Afp</td>
	<td align="center" class="TituloTablaVerde">Sindicato</td>
	<td align="center" class="TituloTablaVerde">Est</td>     
  </tr>
	<?
	$Consulta="Select t1.rut,t1.nombres,t1.ape_paterno,t1.ape_materno,t1.direccion,t1.nro_tarjeta,t1.estado,t2.nom_comuna,t1.sexo,t3.descripcion_afp as nom_afp,t4.descripcion as nom_sindicato ";
	$Consulta.="from sget_personal t1 LEFT JOIN SGET_COMUNAS t2 on t1.cod_comuna=t2.cod_comuna left join sget_afp t3 on t1.cod_afp=t3.cod_Afp ";
	$Consulta.="left join sget_sindicato t4 on t1.cod_sindicato=t4.cod_sindicato where t1.estado='A' and t1.cod_contrato='".$Ctto."' and t1.rut_empresa='".$CmbEmpresa."' order by t1.ape_paterno ";
	$Respd=mysqli_query($link, $Consulta);$Cont=0;
	while($Filad=mysql_fetch_array($Respd))
	{
		$Cont++;
	?>
	<tr>
    <td align="center">
	<a  href="sget_info_personal.php?run=<? echo $Filad["rut"];?>"  target="_blank"><img src="archivos/info2.png"   alt="Informaci�n Personal"  border="0" align="absmiddle" /></a>&nbsp;<? echo FormatearRun($Filad["rut"]);?>&nbsp;</td>
   	<td ><? echo FormatearNombre($Filad[ape_paterno])."&nbsp;".FormatearNombre($Filad[ape_materno])."&nbsp;".FormatearNombre($Filad["nombres"]);?>&nbsp;</td>  
	<td ><? echo $Filad["direccion"].", ".$Filad[nom_comuna];?>&nbsp;</td> 
	<td align="center"><? echo $Filad[nro_tarjeta];?>&nbsp;</td>
	<td ><? echo $Filad[nom_afp];?>&nbsp;</td>
	<td ><? echo $Filad[nom_sindicato];?>&nbsp;</td>
	<td align="center"><? echo $Filad["estado"];?>&nbsp;</td>   
	</tr>
	<?
	}
	?>
	<tr>
	  <td colspan="6" align="right" class="TituloTablaVerde">Cantidad Personas</td>
	  <td align="right" class="TituloTablaVerde" ><? echo $Cont; ?>&nbsp;</td>
     </tr>
</table>
