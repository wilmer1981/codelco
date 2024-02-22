<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$CodSistema=30;
$CodPantalla=15;
?>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
			f.action='sget_rpt_estado_hoja_ruta.php?Cons=S';
			f.submit();
			break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=22";
		break;
		case "I"://IMPRIMIR
			window.print();
			break;			
		
	}	
}
function Excel() 
{
	var f=document.FrmPrincipal;
	URL='sget_rpt_estado_hoja_ruta_excel.php?CmbEmpresa='+f.CmbEmpresa.value+'&CmbContrato='+f.CmbContrato.value+'&TxtHoja='+f.TxtHoja.value+'&CmbAno='+f.CmbAno.value+'&CmbEstado='+f.CmbEstado.value;
	window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
	
}

function Recarga(Opt) 
{
	var f=document.FrmPrincipal;
	f.action='sget_rpt_estado_hoja_ruta.php';
	f.submit();
}
</script>
<title>Consulta Estados Hoja de Ruta</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="" >
<input name="CodSistema" type="hidden" value="<? echo $CodSistema; ?>">
<input name="CodPantalla" type="hidden" value="<? echo $CodPantalla; ?>">
 <?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'estado_hoja_ruta.png')
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
			<a href="JavaScript:Proceso('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:Excel('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:Proceso('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a>&nbsp;
			<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a></td>
          </tr>
          <tr>
            <td class="formulario2">Empresa</td>
            <td class="formulario2">
              <SELECT name="CmbEmpresa" id="SELECT" style="width:250" onchange="Recarga('<? echo $Opt;?>');" >
                <option value="-1" class="NoSelec">Seleccionar</option>
                <?
				$Consulta = "SELECT * from sget_contratistas order by razon_social ";
				$Resp=mysql_query($Consulta);
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
            <td class="formulario2"><input name="TxtHoja" type="text" id="TxtRegic" value="<? echo $TxtHoja; ?>" /></td>
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
            <td class="formulario2">Contrato</td>
            <td class="formulario2">
              <SELECT name="CmbContrato" style="width:250" onchange="Recarga('<? echo $Opt;?>');">
                <option value="S" SELECTed="SELECTed">Seleccionar</option>
                <?
		$FechaActual=date("Y")."-".date("m")."-".date("d");
		$Consulta="SELECT * from sget_contratos where rut_empresa='".$CmbEmpresa."' order by fecha_termino desc";
		$RespCtto=mysql_query($Consulta);
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
				$FechaIniCtto=$FilaCtto[fecha_inicio];
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
            <td width="21%" class="formulario2">A&ntilde;o Ingreso </td>
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
          <option value="S" SELECTed="SELECTed">Todos</option>
          <?
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30008' order by cod_subclase";
			$Resp=mysql_query($Consulta);
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
  <table width="944" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
      <td width="914" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
      <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">		
       <tr>
         <td width="11%" class="TituloTablaVerde">&nbsp;</td>
          <td width="8%" align="center" class="TituloTablaVerde">Hoja Ruta </td>
          <td width="11%" align="center" class="TituloTablaVerde">Fecha Ingreso </td>
          <td width="9%" align="center" class="TituloTablaVerde">Contrato</td>
          <td width="17%" align="center" class="TituloTablaVerde">Empresa</td>
          <td width="17%" align="center" class="TituloTablaVerde">Adm.Codelco</td>
	      <td width="14%" align="center" class="TituloTablaVerde">Adm.Contratista</td>
		  <td width="13%" align="center" class="TituloTablaVerde">Hito</td>
      </tr>
  <?

if($Cons=='S')
{
	$Consulta = "SELECT * from sget_hoja_ruta ";
	$Consulta.=" where not isnull(num_hoja_ruta)  ";
	if($CmbEmpresa!='-1')
		$Consulta.=" and  rut_empresa='".$CmbEmpresa."' ";
	if($CmbContrato!='S')
		$Consulta.=" and  cod_contrato='".$CmbContrato."' ";
	if($TxtHoja!='')
		$Consulta.= " and num_hoja_ruta like ('%".trim($TxtHoja)."%') ";
	if($CmbAno!='T')
		$Consulta.= " and year(fecha_ingreso)= '".$CmbAno."' ";
	if($CmbEstado!='S')
	{
		$Consulta.= " and cod_estado_aprobado ='".$CmbEstado."'  ";	
	}
	else
		$Consulta.= " and cod_estado_aprobado <>'3' ";	
	$Consulta.= " order by num_hoja_ruta desc, cod_estado_aprobado asc   ";		
	//echo $Consulta;
	$Resp = mysql_query($Consulta);
	echo "<input name='CheckHoja' type='hidden'  value=''>";
	$cont=1;
	while ($Fila_HR=mysql_fetch_array($Resp))
	{
		?>     	
		<tr> 
    	<td>
		<a href="sget_hoja_ruta_pdf.php?NumHR=<? echo $Fila_HR["num_hoja_ruta"];?>" target="_blank"><img src="archivos/adobe.png"  alt="Hoja Ruta PDF" border="0" align="absmiddle" /></a>
		<a href="sget_detalle_estados.php?Opt=M&EsPopup=S&TxtHoja=<? echo $Fila_HR["num_hoja_ruta"];?>" target="_blank"><img src="archivos/btn_observaciones.png"  border="0"   alt="Detalle Hoja de Ruta" align="absmiddle" /></a>
		</td>
	    <td ><? echo $Fila_HR["num_hoja_ruta"]."&nbsp;"; ?></td>
        <td ><? echo substr($Fila_HR["fecha_ingreso"],0,10)."&nbsp;"; ?>&nbsp;</td>
        <td ><a  href="sget_info_ctto_ac.php?Ctto=<? echo $Fila_HR["cod_contrato"];?>"  target="_blank"><img src="archivos/info2.png"   alt="Detalle Contrato"  border="0" align="absmiddle" /></a>&nbsp;<? echo $Fila_HR["cod_contrato"]."&nbsp;"; ?></td>
        <td ><a href="sget_info_empresa.php?Emp=<? echo $Fila_HR["rut_empresa"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Empresa" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;
		<? 
		    $RazonSoc=DescripcionRazonSocial($Fila_HR["rut_empresa"]);
		  	echo FormatearNombre($RazonSoc)."&nbsp;"; ?></td>
          	<td >
			<?
		   	$VarCodelco=AdmCttoCodelco($Fila_HR["cod_contrato"]);
		   	$array=explode('~',$VarCodelco);
		   	echo FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
	   		?>&nbsp;
			</td>
          	<td >
			<? 
		  	$VarContratista=AdmCttoContratista($Fila_HR["cod_contrato"]);
	  	 	$array=explode('~',$VarContratista);
	   	 	echo FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
		  	?>
			&nbsp;	
	  		</td>
			
			<?
			$Color='';
			$Consulta = "SELECT max(fecha_hora) as fecha_hora from sget_reg_estados  ";
			$Consulta.= " where num_hoja_ruta='".$Fila_HR[num_hoja_ruta]."'";
			$Consulta.= " group by num_hoja_ruta ";
			$RespCrea=mysql_query($Consulta);
			$FilaCrea=mysql_fetch_array($RespCrea);
			
			$Consulta = "SELECT cod_estado,tipo from sget_reg_estados  ";
			$Consulta.= " where num_hoja_ruta='".$Fila_HR[num_hoja_ruta]."' and fecha_hora='".$FilaCrea["fecha_hora"]."'";
			$RespCrea=mysql_query($Consulta);
			if($FilaCrea=mysql_fetch_array($RespCrea))
			{
				if($FilaCrea["cod_estado"]!='14')
					$Color='bgcolor="#FFFF66"';
				else
					$Color='bgcolor="#33CC00"';	
				if($FilaCrea["tipo"] =='E')
				{
					$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30008' and cod_subclase ='".$FilaCrea["cod_estado"]."' ";
					$Resp2=mysql_query($Consulta);
					$Fila2=mysql_fetch_array($Resp2);
					{
						$Estado=str_replace(' ','&nbsp;',$Fila2["nombre_subclase"]);
					}
				}
				else
				{
					$Consulta="SELECT * from sget_hitos where cod_hito='".$FilaCrea["cod_estado"]."' ";
					$Resp2=mysql_query($Consulta);
					$Fila2=mysql_fetch_array($Resp2);
					{
						$Estado=str_replace(' ','&nbsp;',$Fila2[descrip_hito]);
					}
				}	
			}
			?>
			<td <? echo $Color;?> >
			<? echo $Estado;?>
			&nbsp;
			</td>
		  </tr>
  			<?		
  		$cont++;
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
  CierreEncabezado()
  ?>
</form>