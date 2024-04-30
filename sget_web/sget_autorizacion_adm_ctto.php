<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");

$CodSistema=30;
$CodPantalla=15;
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
			if(f.CmbEstado.value !='S')
			{
				f.action='sget_autorizacion_adm_ctto.php?Cons=S';
				f.submit();
			}
			else
			{
				alert("Seleccione Estado a Buscar");
				f.CmbEstado.focus();
			}	
			break;
		case "N":
			URL="sget_mantenedor_empresas_proceso.php?Opc="+Opc;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=750,height=700,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckRut','M'))
			{
				Datos=Recuperar(f.name,'CheckRut');
				URL="sget_mantenedor_empresas_proceso.php?Opc="+Opc+"&Valores="+Datos;
				opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=750,height=700,scrollbars=1';
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
					f.action='sget_mantenedor_empresas01.php?Opcion=E&Valor='+Datos;
					f.submit();
				}	
			}
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=0";
		break;
	}	
}
function Obs(H,HR)
{
	var f=document.FrmPrincipal;
	URL="sget_detalle_obs_hito.php?H="+H+"&NumHoja="+HR+"&CodSistema="+f.CodSistema.value+"&CodPantalla="+f.CodPantalla.value;
	opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=700,height=350,scrollbars=1';
	popup=window.open(URL,"",opciones);
	popup.focus();
}
function Recarga(Opt) 
{
	var f=document.FrmPrincipal;
	f.action='sget_autorizacion_adm_ctto.php';
	f.submit();
}
function Auto(H,HR) 
{
	var f=document.FrmPrincipal;
	f.action='sget_autorizacion_adm_ctto01.php?H='+H+'&NumHoja='+HR+'&Proceso=A';
	f.submit();
}
function Rech(H,HR) 
{
	var f=document.FrmPrincipal;
	f.action='sget_autorizacion_adm_ctto01.php?H='+H+'&NumHoja='+HR+'&Proceso=RECH';
	f.submit();
}

</script>
<title>Autorizaci�n Administrador de Contratos </title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="" >
<input name="CodSistema" type="hidden" value="<? echo $CodSistema; ?>">
<input name="CodPantalla" type="hidden" value="<? echo $CodPantalla; ?>">
 <?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'auto_adm_cttos.png')
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
			<a href="JavaScript:NuevoUser('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>            </td>
          </tr>
          <tr>
            <td width="8%" class="formulario2">Empresa</td>
            <td width="51%" class="formulario2">
              <SELECT name="CmbEmpresa" id="SELECT" style="width:400" onchange="Recarga('<? echo $Opt;?>');" >
                <option value="-1" class="NoSelec">Seleccionar</option>
                <?
				$Consulta = "SELECT * from sget_contratistas order by razon_social ";
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbEmpresa==$FilaTC["rut_empresa"])
					{
						echo "<option SELECTed value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
						$Rut=$FilaTC[rut_empresa];
						$Domicilio=$FilaTC[calle];
						$Fono=$FilaTC[telefono_comercial];
						$EMail=$FilaTC[mail_empresa];
						$CodMutual=$FilaTC[cod_mutual_seguridad];
						$FechaVenc=$FilaTC[fecha_ven_cert];
						
					}
					else
						echo "<option value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
				}
				?>
                <option value="*">---SubContratistas---</option>
                <?
				$Consulta1 = "SELECT t2.rut_empresa,t1.razon_social from sget_contratistas t1 inner join sget_sub_contratistas t2 ";
				$Consulta1.= "on t1.rut_empresa=t2.rut_empresa where t2.cod_contrato ='".$CmbContrato."'order by razon_social ";
				$RespSub=mysql_query($Consulta1);
				while ($FilaSub=mysql_fetch_array($RespSub))
				{
					if ($CmbEmpresa==$FilaSub["rut_empresa"])
					{
						echo "<option SELECTed value='".$FilaSub["rut_empresa"]."'>".ucfirst($FilaSub["razon_social"])."</option>\n";
						$Rut=$FilaSub[rut_empresa];
						$Domicilio=$FilaSub[calle];
						$Fono=$FilaSub[telefono_comercial];
						$EMail=$FilaSub[mail_empresa];
						$CodMutual=$FilaSub[cod_mutual_seguridad];
						$FechaVenc=$FilaSub[fecha_ven_cert];
						
					}
					else
						echo "<option value='".$FilaSub["rut_empresa"]."'>".ucfirst($FilaSub["razon_social"])."</option>\n";
				}
				?>
              </SELECT>
            </td>
            <td class="formulario2">Nro Hoja Ruta </td>
            <td width="19%" class="formulario2"><input name="TxtHoja" type="text" id="TxtRegic" value="<? echo $TxtHoja; ?>" /></td>
            <td width="5%" class="formulario2">&nbsp;</td>
            <td width="6%" class="formulario2">&nbsp;</td>
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
            <td class="formulario2">Contrato</td>
            <td class="formulario2">
              <SELECT name="CmbContrato" style="width:400" onchange="Recarga('<? echo $Opt;?>');">
                <option value="S" SELECTed="SELECTed">Seleccionar</option>
                <?
				$FechaActual=date("Y")."-".date("m")."-".date("d");
				$Consulta="SELECT * from sget_contratos where fecha_termino >= '".$FechaActual."' and rut_empresa='".$CmbEmpresa."' order by descripcion asc,fecha_termino desc";
				$RespCtto=mysqli_query($link, $Consulta);
				while($FilaCtto=mysql_fetch_array($RespCtto))
				{
					if ($FechaActual > $FilaCtto[fecha_termino])
						$Color="red";
					else
						$Color='white';
					if(strtoupper($FilaCtto["cod_contrato"])==strtoupper($CmbContrato))
					{
						echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."' SELECTed>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
						if($TxtFechaCtto==''||$TxtFechaCtto=='0000-00-00')
							$TxtFechaCtto=$FilaCtto[fecha_termino];
						$FechaIniCtto=$FilaCtto["fecha_inicio"];
						$FechaFinCtto=$FilaCtto[fecha_termino];
						$AdmCodelco=$FilaCtto["cod_contrato"];
						$AdmContratista=$FilaCtto["cod_contrato"];
						$AreaTrabajo=$FilaCtto[area_trabajo];
						$TipoCtto=$FilaCtto[cod_tipo_contrato];
						$RutPrev=$FilaCtto[rut_prev];
					}	
					else
						echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."'>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
				}
				?>
              </SELECT>
            </td>
            <td width="11%" class="formulario2">A&ntilde;o Ingreso </td>
            <td colspan="3" class="formulario2"><span class="borderbajo">
              <SELECT name="CmbAno" id="CmbAno"  onchange="Proceso('R','<? echo $CmbAno; ?>')">
                <option value="T" class="NoSelec">Todos</option>
                <?
				for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
				{
					if (isset($CmbAno))
					{
						if ($i==$CmbAno)
						{
							echo "<option SELECTed value ='$i'>$i</option>";
						}
						else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
					}
					else
					{
						if ($i==date("Y"))
						{
							echo "<option SELECTed value ='$i'>$i</option>";
						}
						else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
					}
				}
				?>
              </SELECT>
            </span></td>
          </tr>
          <tr>
          <td class="formulario2">Estado</td>
          <td class="formulario2"><SELECT name="CmbEstado">
          <option value="S" SELECTed="SELECTed">Seleccionar</option>
          <?
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30008' and cod_subclase in ('2','4') order by cod_subclase";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				if($CmbEstado==$Fila["cod_subclase"])
					echo "<option value='".$Fila["cod_subclase"]."' SELECTed>".$Fila["nombre_subclase"]."</option>";
				else	
					echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
			}
			?>
            </SELECT></td>
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
  <table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
    <tr>
      <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
      <td width="904" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
      <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">		
       <tr>
         <td width="5%" class="TituloTablaVerde">&nbsp;</td>
          <td width="6%" align="center" class="TituloTablaVerde">Hoja Ruta </td>
          <td width="9%" align="center" class="TituloTablaVerde">Fecha Ingreso </td>
          <td width="7%" align="center" class="TituloTablaVerde">Contrato</td>
          <td width="25%" align="center" class="TituloTablaVerde">Empresa</td>
          <td width="18%" align="center" class="TituloTablaVerde">Adm.Codelco</td>
	      <td width="23%" align="center" class="TituloTablaVerde">Adm.Contratista</td>
           <?
		  	$Consulta = "SELECT * from sget_hitos ";
			$Consulta.=" where cod_sistema='".$CodSistema."' and cod_pantalla='".$CodPantalla."'  ";
			$RespH = mysqli_query($link, $Consulta);
			while ($FilaH=mysql_fetch_array($RespH))
			{
				?>
				<td width="4%" align="center" class="TituloTablaVerde">
				<? echo $FilaH[abrev_hito]; ?>		  		</td>
				<?
			}
			?>
			<td width="3%" align="center" class="TituloTablaVerde">Obs</td>	
       </tr>
  <?

if($Cons=='S')
{
	$Consulta ="SELECT nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =30";
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila=mysql_fetch_array($Respuesta);
	$Nivel=$Fila["nivel"];
	  	
	$Consulta = "SELECT * from sget_hoja_ruta t1 inner join sget_hoja_ruta_adm_ctto t2 on t1.num_hoja_ruta=t2.num_hoja_ruta and t2.activo='S'";
	$Consulta.=" where not isnull(t1.num_hoja_ruta) ";
    if($Nivel!='1')
		$Consulta.= " and t2.rut_adm_ctto='".$CookieRut."'";
	if($CmbEmpresa!='-1')
		$Consulta.=" and  t1.rut_empresa='".$CmbEmpresa."' ";
	if($CmbContrato!='S')
		$Consulta.=" and  t1.cod_contrato='".$CmbContrato."' ";
	if($TxtHoja!='')
		$Consulta.= " and t1.num_hoja_ruta like ('%".trim($TxtHoja)."%') ";
	if($CmbAno!='T')
		$Consulta.= " and year(t1.fecha_ingreso)= '".$CmbAno."' ";
	if($CmbEstado!='S')
	{
		switch($CmbEstado)
		{
			case "2":
				$Consulta.= " and t1.cod_estado_aprobado ='".$CmbEstado."'  ";	
			break;
			case "4":
				$Consulta.= " and t1.cod_estado_aprobado= '".$CmbEstado."' ";	
			break;
		}
	}
	$Consulta.= " order by t1.cod_estado_aprobado asc   ";		
	$Resp = mysqli_query($link, $Consulta);
	echo "<input name='CheckHoja' type='hidden'  value=''>";
	$cont=1;
	while ($Fila=mysql_fetch_array($Resp))
	{
		?>     	
		<tr> 
    	<td>
		<a href="sget_hoja_ruta_pdf.php?NumHR=<? echo $Fila["num_hoja_ruta"];?>" target="_blank"><img src="archivos/adobe.png"  alt="Hoja Ruta PDF" border="0" align="absmiddle" /></a><a href="sget_detalle_estados.php?Opt=M&EsPopup=S&TxtHoja=<? echo $Fila["num_hoja_ruta"];?>" target="_blank"><img src="archivos/btn_observaciones.png"  border="0"   alt="Detalle Hoja de Ruta" align="absmiddle" /></a>
		<!--<? //echo "<input name='CheckHoja' class='SinBorde' type='checkbox'  value='".$Fila["rut_empresa"]."'>" ?>-->
		</td>
	    <td ><? echo $Fila["num_hoja_ruta"]."&nbsp;"; ?></td>
        <td ><? echo substr($Fila["fecha_ingreso"],0,10)."&nbsp;"; ?>&nbsp;</td>
        <td ><a href="sget_info_ctto.php?Ctto=<? echo $Fila["cod_contrato"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Contrato" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;<? echo $Fila["cod_contrato"]."&nbsp;"; ?></td>
        <td ><a href="sget_info_empresa.php?Emp=<? echo $Fila["rut_empresa"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Empresa" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;
		<? 
		  $RazonSoc=DescripcionRazonSocial($Fila["rut_empresa"]);
		  	echo FormatearNombre($RazonSoc)."&nbsp;"; ?></td>
          	<td >
			<?
		   	$VarCodelco=AdmCttoCodelco($Fila["cod_contrato"]);
		   	$array=explode('~',$VarCodelco);
		   	echo FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
	   		?>&nbsp;
			</td>
          	<td >
			<? 
		  	$VarContratista=AdmCttoContratista($Fila["cod_contrato"]);
	  	 	$array=explode('~',$VarContratista);
	   	 	echo FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
		  	?>
			&nbsp;	
	  		</td>
			 <?
		  	$Consulta = "SELECT * from sget_hitos ";
			$Consulta.=" where cod_sistema='".$CodSistema."' and cod_pantalla='".$CodPantalla."'  ";
			$RespHD = mysqli_query($link, $Consulta);
			while ($FilaHD=mysql_fetch_array($RespHD))
			{
				?>
				<td width="7%" align="center">
				<?
				$Consulta="SELECT * from sget_hoja_ruta_hitos where num_hoja_ruta='".$Fila["num_hoja_ruta"]."' and cod_hito='".$FilaHD[cod_hito]."' ";
				$RespExi = mysqli_query($link, $Consulta);
				if($FilaExi=mysql_fetch_array($RespExi))
				{	
					$IcoObs=CantObs($Fila["num_hoja_ruta"],$FilaHD[cod_hito]);
					if($FilaExi[autorizado]=='S')
					{
						$HitosAdm=ContabHitosAdm($Fila["num_hoja_ruta"],'14');
						if($HitosAdm =='S')
						{
							?>
							<a href="JavaScript:Rech('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/acepta.png" border="0" alt="Devolver a Estado Enviadas Adm. Ctto." 	align="absmiddle"></a>
							<?
						}
						?>
						<a href=	"JavaScript:Obs('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')">
		  				<?
					}
					else
					{
						?>
						<a href="JavaScript:Auto('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/proceso.png" border="0" alt="<? echo $FilaHD[descrip_hito];  ?>" 	align="absmiddle"></a>
						<?
					}
				}
				else
				{
					?>	
					<a href="JavaScript:Auto('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/proceso.png" border="0" alt="<? echo $FilaHD[descrip_hito];  ?>" 	align="absmiddle"></a>			
					<?
				}
				?>				</td>
		<td align="center"><a href=	"JavaScript:Obs('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/<? echo $IcoObs;  ?>"  border="0"  alt="Ingreso Observaci�n <? echo $FilaHD[descrip_hito];  ?>" align=	"absmiddle" /></a></td>		
				<?
			}
			?>
		 
		  </tr>
  			<?		
  			$cont++;
	}
}
?>			
</table></td><td width="20" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>
  <?
  CierreEncabezado()
  ?>
</form>