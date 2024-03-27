<?
 	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	
			$Consulta="SELECT t12.descripcion_aseguradora,t6.descripcion,t11.nombre_subclase,t8.nom_ciudad,t13.nom_region,t10.descrip_tipo,t9.descrip_turno,t1.*,t2.abreviatura_afp,t3.nom_comuna,t5.razon_social,t7.descrip_cargo from sget_personal t1 ";
			$Consulta.=" left join sget_afp t2 on t1.cod_afp=t2.cod_afp ";
			$Consulta.=" left join sget_comunas t3  on t1.cod_comuna=t3.cod_comuna";
			$Consulta.=" left join sget_contratos t4  on t1.cod_contrato=t4.cod_contrato";
			$Consulta.=" left join sget_contratistas t5  on t1.rut_empresa=t5.rut_empresa";
			$Consulta.=" left join sget_sindicato t6  on t1.cod_sindicato=t6.cod_sindicato";
			$Consulta.=" left join sget_cargos t7 on t1.cargo=t7.cod_cargo";
			$Consulta.=" left join sget_regiones t13  on t1.cod_region=t13.cod_region";
			$Consulta.=" left join sget_ciudades t8  on t1.cod_ciudad=t8.cod_ciudad";
			$Consulta.=" left join sget_turnos t9  on t1.cod_turno=t9.cod_turno";
			$Consulta.=" left join sget_tipo_persona t10  on t1.tipo=t10.cod_tipo";
			$Consulta.=" left join proyecto_modernizacion.sub_clase t11 on t1.cod_salud=t11.cod_subclase and  t11.cod_clase='30011'";
			$Consulta.=" left join sget_aseguradoras t12  on t1.cod_aseguradora=t12.cod_aseguradora";
			$Consulta.="  where t1.rut='".$run."'";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{
				$TxtRut=$Fila["rut"];					
				$TxtNom=$Fila["nombres"];
				$TxtPat=$Fila[ape_paterno];
				$TxtMat=$Fila[ape_materno];
				$TxtFechaNac=$Fila[fec_nac];
				$Cargo=$Fila[descrip_cargo];
				$TxtDir=$Fila["direccion"];
				$TxtFono1=$Fila[telefono1];
				$TxtFono2=$Fila[telefono2];
				$Turnos=$Fila[descrip_turno];
				$TipoPersona=$Fila[descrip_tipo];
				$TxtFechaCert=$Fila[fecha_certif];
				$Region=$Fila[nom_region];
				$Ciudad=$Fila[nom_ciudad];
				$Comunas=$Fila[nom_comuna];
				$TxtFecIniCtto=$Fila[fec_ini_ctto];
				$TxtFecFinCtto=$Fila[fec_fin_ctto];
				$TxtTarj=$Fila[nro_tarjeta];
				$Empresa=$Fila[razon_social];
				$Contrato=$Fila["cod_contrato"];
				if($Fila[certificado_ant]=='S')
				{
					$CertAnt='Si';
				}
				else
				{
					$CertAnt='No';
				}
				if($Fila["estado"]=='A')
				{
					$Estado='Activo';
				}
				else
				{
					$Estado='Inactivo';
				}
				if($Fila[sexo]=='M')
				{
					$Sexo='Masculino';
				}
				if($Fila[sexo]=='F')
				{
					$Sexo='Femenino';
				}
				
				$Afp=$Fila[abreviatura_afp];
				$Salud=$Fila["nombre_subclase"];
				$Sindicato=$Fila["descripcion"];
				$TxtSueldo=$Fila[sueldo];
				if($TxtFechaNac!='')
					$TxtEdad=edad($TxtFechaNac);
				$TxtFechaNac=substr($Fila[fec_nac],8,2)."/".substr($Fila[fec_nac],5,2)."/".substr($Fila[fec_nac],0,4);
				$TxtAseguradora=$Fila[descripcion_aseguradora];
				$TxtCarga=$Fila[cargas_familiares];
			}
	

?>
<html>
<head>
<title>Detalle Persona
</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	var Est='';
	var Cert='';
	var Sexo='';
	var Beca='';
	//alert(TipoProceso);
	switch(	TipoProceso)		
	{	case 'S'://SALIR
			window.close();
			break;
		
	}
}

</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post" enctype="multipart/form-data" >
<input type="hidden" name="run" value="<? echo $run;?>">
<table width="80%"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">

  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq1_sget3.gif" width="15" height="15" /></td>
    <td height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq2_sget.gif" width="15" height="15" /></td>
  </tr>
  <tr>
    <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
    <td align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
      <tr align="right">
        <td colspan="2" >
		
             <a href="JavaScript:Procesos('S')"><img src="archivos/close.png"  border="0"  alt=" Volver " align="absmiddle"></a></td>
      </tr>
    </table>
     <table width="100%" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td colspan="4" align="center" class="TituloTablaVerde">Datos Personales</td>
          </tr>
          <tr >
        <td width="106"  class="formulario2">Run</td>
        <td width="146" align="left" class="formulariosimple" ><? echo $TxtRut;?></td>
        <td align="center" class="formulariosimple">&nbsp;</td>
        <td rowspan="4" align="left" class="formulariosimple"><img src='fotos/<? echo $TxtRut;?>.jpg' width="100" height="100"  border='0' align='absmiddle' class="formulariosimple"></td>
          </tr>
      <tr >
        <td height="24"  class="formulario2">Nombre</td>
        <td colspan="2" align="left" class="formulariosimple"><? echo $TxtNom."&nbsp;".$TxtPat."&nbsp;".$TxtMat?></td>
        </tr>
      <tr >
        <td height="24"  class="formulario2">Sexo</td>
        <td align="left" class="formulariosimple" ><? echo $Sexo;?></td>
        <td align="center" class="formulario2">&nbsp;</td>
        </tr>
      <tr>
        <td  class="formulario2">Fec.Nacimiento</td>
        <td align="left" class="formulariosimple"><? echo $TxtFechaNac; ?>&nbsp;&nbsp;&nbsp;&nbsp;<span class="formulario2">&nbsp;Edad</span>&nbsp;<? echo $TxtEdad;?>&nbsp;<span class="formulario2">A�os</span></td>
        <td align="left" class="formulariosimple"><span class="formulario2">Carga Familiar</span>&nbsp;&nbsp;<? echo $TxtCarga;?></td>
        </tr>
      <tr>
        <td  class="formulario2">AFP</td>
        <td align="left" class="formulariosimple" ><? echo $Afp;?>   &nbsp;</td>
        <td width="111" align="left" class="formulario2">Sistema&nbsp;Salud</td>
        <td width="136" align="left" class="formulariosimple" >  <? echo $Salud;?>&nbsp;</td>
      </tr>
      <tr >
        <td  class="formulario2">Direccion</td>
        <td align="left" class="formulariosimple" ><? echo $TxtDir;?></td>
	    <td align="left" class="formulario2" >Regi&oacute;n</td>
	    <td align="left" class="formulariosimple" ><? echo $Region;?></td>
      </tr>
      <tr >
        <td  class="formulario2">Ciudad</td>
        <td align="left" class="formulariosimple" ><? echo $Ciudad;?>&nbsp;</td>
        <td align="left" class="formulario2">Comuna</td>
        <td align="left" class="formulariosimple" ><? echo $Comunas;?>&nbsp;</td>              
      </tr>
      <tr  >
        <td  class="formulario2">Cert. Antec.</td>
        <td  align="left" class="formulariosimple"><? echo $CertAnt;?>&nbsp;</td>
        <td  class="formulario2" align="left">Fec. Venc. Cert. </td>
        <td   align="left" class="formulariosimple"><? echo $TxtFechaCert;?>&nbsp;</td>
      </tr>
      <tr>
        <td  class="formulario2"> Telefono</td>
        <td colspan="3" align="left" class="formulario2" >(1)<? echo $TxtFono1;?> &nbsp;(2)<? echo $TxtFono2;?></td>
      </tr>	
      <tr align="center" >
        <td colspan="4" align="center" class="TituloTablaVerde">Datos Contractuales</td>
        </tr>
      <tr >
        <td  class="formulario2">Fecha&nbsp;Inicio&nbsp;Ctto</td>
        <td align="left" class="formulariosimple" ><? echo $TxtFecIniCtto;?>&nbsp;</td>
        <td align="left" class="formulario2">Fecha&nbsp;Termino&nbsp;Ctto </td>
        <td align="left" class="formulariosimple" ><? echo $TxtFecFinCtto;?>&nbsp;</td>
      </tr>
      <tr >
        <td  class="formulario2">Empresa</td>
        <td colspan="3" align="left" class="formulariosimple" ><? echo $Empresa;?>&nbsp;</td>
        </tr>
      <tr >
        <td  class="formulario2">Contrato</td>
        <td colspan="3" align="left" class="formulariosimple" ><? echo $Contrato;?>&nbsp;</td>
        </tr>
      <tr >
        <td  class="formulario2">Credencial</td>
        <td align="left" class="formulariosimple" ><? echo $TxtTarj;?>&nbsp;</td>
        <td align="left" class="formulario2">Sueldo</td>
        <td align="left" class="formulariosimple" ><? echo $TxtSueldo;?>&nbsp;</td>
      </tr>
      <tr >
        <td  class="formulario2">Cargo</td>
        <td colspan="3" align="left" class="formulariosimple" ><? echo $Cargo;?>&nbsp;      </tr>
      <tr>
        <td  class="formulario2">Tipo Persona</td>
        <td align="left" class="formulariosimple" ><? echo $TipoPersona;?>&nbsp;</td>
        <td align="left" class="formulario2">Turnos</td>
        <td align="left" class="formulariosimple" ><? echo $Turnos;?>&nbsp;</td>
      </tr>
      <tr>
        <td  class="formulario2">Estado</td>
        <td align="left" class="formulariosimple" ><? echo $Estado;?>&nbsp;</td>
        <td align="left" class="formulario2">Sindicalizado</td>
        <td align="left" class="formulariosimple" ><? echo $Sindicato;?>&nbsp;</td>
      </tr>
      <tr >
        <td  class="formulario2">Seg.&nbsp;Salud&nbsp;Comple.</td>
        <td colspan="3" align="left" class="formulariosimple"><? echo $TxtAseguradora;?>&nbsp;</td>
      </tr>
    </table></td>
    <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq_sget3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4_sget.gif" width="15" height="15" /></td>
  </tr>
</table>
<br>
</td>
 </tr>
</table>


<table width="80%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="1"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="1"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td  width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
    <table width="100%" align="center" cellpadding="2" border="0" cellspacing="0">
	<tr>
        
   
	
	  
	  
      <? 	$Contador=0;	$encontro="N";
 	$Consulta=" SELECT t1.*,t2.razon_social from sget_personal_historia t1 left join sget_contratistas t2 on t1.rut_empresa=t2.rut_empresa";
	$Consulta.="  where t1.rut ='".$TxtRut."'";
 	
	$RespModificaciones=mysqli_query($link, $Consulta);
	while($FilaModificaciones=mysql_fetch_array($RespModificaciones))
	{
		$Contador=$Contador+1;
		if($Contador==1)
		{		?>
		  <tr> 
	  <td colspan="3">
      <table width="100%" align="center" cellpadding="2" border="1" cellspacing="0">
      
        <tr><td width="147" align="center"class="TituloTablaVerde">Contrato</td>
          <td width="449" align="center"class="TituloTablaVerde">Empresa</td>
          <td width="93" align="center"class="TituloTablaVerde">Fecha Ingreso </td>
          <td width="111" align="center" class="TituloTablaVerde">Fecha T�rmino </td>
          </tr>
        <? 
		}?>
        <tr>
          <td ><a href="sget_info_ctto_ac.php?Ctto=<? echo $FilaModificaciones["cod_contrato"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Contrato" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp; <? echo $FilaModificaciones["cod_contrato"];?></td>
          <td  align="left"><? 
			echo $FilaModificaciones[razon_social];
			?>
&nbsp;</td>
          <td  align="center"><? 
			echo $FilaModificaciones[fecha_ingreso];
			?>&nbsp;</td>
          <td  align="center"><? 
			echo $FilaModificaciones[fecha_termino];
			?>&nbsp;</td>
          </tr>
        <?
	$encontro="S";
	}
	if(	$encontro=="S")
	{
	?>
      </table>     </td>
	 </tr> <?
	}
	?>
    </table></td>
   <td width="17" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td width="573" height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="17" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>	



</form>
</body>
</html>
<?
	//echo "EXISTE RUT:".$Existe."<br>";
	//echo "EXISTE INICIALES:".$Existe2."<br>"; 
	echo "<script languaje='JavaScript'>";
	if ($Existe==true)
	{
		echo "alert('Rut Ingresado ya Existe');";
		echo "document.frmPrincipal.TxtRut.focus();";
	}	
	if ($Existe2==true)
	{
		echo "alert('Iniciales Ingresada ya Existe');";
		echo "document.frmPrincipal.TxtRut.focus();";
	}	
	echo "</script>";
	$Existe=false;$Existe2=false;
	
?>	