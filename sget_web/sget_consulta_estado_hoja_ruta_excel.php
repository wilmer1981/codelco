<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

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
			f.action='sget_consulta_estado_hoja_ruta.php?Cons=S';
			f.submit();
			break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=0";
		break;
	}	
}
function Recarga(Opt) 
{
	var f=document.FrmPrincipal;
	f.action='sget_consulta_estado_hoja_ruta.php';
	f.submit();
}
</script>
<title>Consulta Estados Hoja de Ruta</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="" >
<input name="CodSistema" type="hidden" value="<? echo $CodSistema; ?>">
<input name="CodPantalla" type="hidden" value="<? echo $CodPantalla; ?>">
  <table width="84%"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15" /></td>
      <td height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
      <td><table width="100%"  cellspacing="0">
          <tr>
            <td height="35" colspan="4" align="left" class="formulario"   ><img src="archivos/images/interior/t_buscadorGlobal.png" /> </td>
            <td colspan="2" align="right" class="formulario" >
			<a href="JavaScript:NuevoUser('C')"><img src="archivos/Find.png"   alt="Buscar"  border="0" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:Excel('E')"><img src="archivos/ico_excel4.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:NuevoUser('S')"><img src="archivos/volver.png"  border="0"  alt=" Volver " align="absmiddle"></a>            </td>
          </tr>
          <tr>
            <td class="formulario">Empresa</td>
            <td class="formulario">
              <SELECT name="CmbEmpresa" id="SELECT" style="width:250" onchange="Recarga('<? echo $Opt;?>');" >
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
            <td class="formulario">Nro Hoja Ruta </td>
            <td class="formulario"><input name="TxtHoja" type="text" id="TxtRegic" value="<? echo $TxtHoja; ?>" /></td>
            <td class="formulario">&nbsp;</td>
            <td class="formulario">&nbsp;</td>
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
            <td class="formulario">Contrato</td>
            <td class="formulario">
              <SELECT name="CmbContrato" style="width:250" onchange="Recarga('<? echo $Opt;?>');">
                <option value="S" SELECTed="SELECTed">Seleccionar</option>
                <?
		$FechaActual=date("Y")."-".date("m")."-".date("d");
		$Consulta="SELECT * from sget_contratos where fecha_termino >= '".$FechaActual."' order by fecha_termino desc";
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
            <td width="21%" class="formulario">A&ntilde;o Ingreso </td>
            <td colspan="3" class="formulario"><span class="borderbajo">
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
          <td class="formulario">Estado</td>
          <td class="formulario"><SELECT name="CmbEstado">
          <option value="S" SELECTed="SELECTed">Todos</option>
          <?
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30008' order by cod_subclase";
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
            <td class="formulario">&nbsp;</td>
            <td colspan="3" class="formulario">&nbsp;</td>
          </tr>
          
      </table></td>
      <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
    </tr>
  </table>
  <p>
  <table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td ><img src="archivos/images/interior/esq1.gif" width="15" ></td>
	<td width="1073" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" ></td>
	<td ><img src="archivos/images/interior/esq2.gif" width="15" ></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><br>
     <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">		
       <tr>
         <td width="8%" class="TituloCabecera">&nbsp;</td>
          <td width="8%" align="center" class="TituloCabecera">Hoja Ruta </td>
          <td width="12%" align="center" class="TituloCabecera">Fecha Ingreso </td>
          <td width="7%" align="center" class="TituloCabecera">Contrato</td>
          <td width="20%" align="center" class="TituloCabecera">Empresa</td>
          <td width="18%" align="center" class="TituloCabecera">Adm.Codelco</td>
	      <td width="23%" align="center" class="TituloCabecera">Adm.Contratista</td>
		  <td width="23%" align="center" class="TituloCabecera">Hito</td>
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
		$Consulta.= " and num_hoja_ruta like ('%".$TxtHoja."%') ";
	if($CmbAno!='T')
		$Consulta.= " and year(fecha_ingreso)= '".$CmbAno."' ";
	if($CmbEstado!='S')
	{
		$Consulta.= " and cod_estado_aprobado ='".$CmbEstado."'  ";	
	}
	$Consulta.= " order by cod_estado_aprobado asc   ";		
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	echo "<input name='CheckHoja' type='hidden'  value=''>";
	$cont=1;
	while ($Fila_HR=mysql_fetch_array($Resp))
	{
		?>     	
		<tr> 
    	<td>
		<a href="sget_hoja_ruta_pdf.php?NumHR=<? echo $Fila["num_hoja_ruta"];?>" target="_blank"><img src="archivos/adobe.png"  alt="Hoja Ruta PDF" border="0" align="absmiddle" /></a>
		<a href="sget_detalle_estados.php?Opt=M&EsPopup=S&TxtHoja=<? echo $Fila["num_hoja_ruta"];?>" target="_blank"><img src="archivos/btn_observaciones.png"  border="0"   alt="Detalle Hoja de Ruta" align="absmiddle" /></a>
		</td>
	    <td ><? echo $Fila_HR["num_hoja_ruta"]."&nbsp;"; ?></td>
        <td ><? echo substr($Fila_HR["fecha_ingreso"],0,10)."&nbsp;"; ?>&nbsp;</td>
        <td ><? echo $Fila_HR["cod_contrato"]."&nbsp;"; ?></td>
        <td >
		<? 
		    $RazonSoc=DescripcionRazonSocial($Fila_HR["rut_empresa"]);
		  	echo ucfirst(strtolower($RazonSoc))."&nbsp;"; ?></td>
          	<td >
			<?
		   	$VarCodelco=AdmCttoCodelco($Fila_HR["cod_contrato"]);
		   	$array=explode('~',$VarCodelco);
		   	echo ucfirst(strtolower($array[1])).' '.ucfirst(strtolower($array[2])).' '.ucfirst(strtolower($array[3]));
	   		?>&nbsp;
			</td>
          	<td >
			<? 
		  	$VarContratista=AdmCttoContratista($Fila_HR["cod_contrato"]);
	  	 	$array=explode('~',$VarContratista);
	   	 	echo ucfirst(strtolower($array[1])).' '.ucfirst(strtolower($array[2])).' '.ucfirst(strtolower($array[3]));
		  	?>
			&nbsp;	
	  		</td>
			<td class="formulario">
			<?
			$Consulta = "SELECT max(fecha_hora) as fecha_hora from sget_reg_estados  ";
			$Consulta.= " where num_hoja_ruta='".$Fila_HR[num_hoja_ruta]."'";
			$Consulta.= " group by num_hoja_ruta ";
			$RespCrea=mysqli_query($link, $Consulta);
			$FilaCrea=mysql_fetch_array($RespCrea);
			
			$Consulta = "SELECT cod_estado,tipo from sget_reg_estados  ";
			$Consulta.= " where num_hoja_ruta='".$Fila_HR[num_hoja_ruta]."' and fecha_hora='".$FilaCrea["FECHA_HORA"]."'";
			$RespCrea=mysqli_query($link, $Consulta);
			if($FilaCrea=mysql_fetch_array($RespCrea))
			{
				if($FilaCrea["tipo"] =='E')
				{
					$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30008' and cod_subclase ='".$FilaCrea["cod_estado"]."' ";
					$Resp2=mysqli_query($link, $Consulta);
					$Fila2=mysql_fetch_array($Resp2);
					{
						echo str_replace(' ','&nbsp;',$Fila2["nombre_subclase"]);
					}
				}
				else
				{
					$Consulta="SELECT * from sget_hitos where cod_hito='".$FilaCrea["cod_estado"]."' ";
					$Resp2=mysqli_query($link, $Consulta);
					$Fila2=mysql_fetch_array($Resp2);
					{
						echo str_replace(' ','&nbsp;',$Fila2[descrip_hito]);
					}
				}	
			}
			?>
			</td>
		  </tr>
  			<?		
  		$cont++;
	}
}
?>			
</table></td><td width="20" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="20"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>
</form>