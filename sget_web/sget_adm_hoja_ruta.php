<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$CodSistema=30;
$CodPantalla=19;


?>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opc,Var1,Var2)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
			if(f.CmbEstado.value !='S')
			{
				f.action='sget_adm_hoja_ruta.php?Cons=S';
				f.submit();
			}
			else
			{
				alert("Seleccione Estado a Buscar");
				f.CmbEstado.focus();
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
		case "AHR"://ANULAR HOJA RUTA
			if(confirm('Esta Seguro de Anular la Hoja de Ruta'))
			{
				f.action='sget_adm_hoja_ruta_reasigna01.php?Proceso=AHR&NumHoja='+Var1+"&EstActual="+Var2;
				f.submit();
			}
		break;
		case "ACHR"://ACTIVAR HOJA DE RUTA
			if(confirm('Esta Seguro de Activar Hoja de Ruta'))
			{
				f.action='sget_adm_hoja_ruta_reasigna01.php?Proceso=ACHR&NumHoja='+Var1+"&EstActual="+Var2;
				f.submit();
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
	f.action='sget_adm_hoja_ruta.php';
	f.submit();
}
function Auto(H,HR) 
{
	var f=document.FrmPrincipal;
	f.action='sget_adm_hoja_ruta01.php?H='+H+'&NumHoja='+HR+'&Proceso=A';
	f.submit();
}
function Rech(H,HR) 
{
	var f=document.FrmPrincipal;
	f.action='sget_autorizacion_adm_ctto01.php?H='+H+'&NumHoja='+HR+'&Proceso=RECH';
	f.submit();
}
</script>
<title>Administrador Hoja de Ruta</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="" >
<input name="CodSistema" type="hidden" value="<? echo $CodSistema; ?>">
<input name="CodPantalla" type="hidden" value="<? echo $CodPantalla; ?>">
     <?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'adm_hoja_ruta.png')
 ?>
<table width="940"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
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
			<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>            </td>
          </tr>
          <tr>
            <td width="7%" class="formulario2">Contrato</td>
            <td width="45%" class="formulario2">
              <SELECT name="CmbContrato" style="width:250" onchange="Recarga('<? echo $Opt;?>');">
                <option value="S" SELECTed="SELECTed">Seleccionar</option>
                <?
		$FechaActual=date("Y")."-".date("m")."-".date("d");
		$Consulta="SELECT * from sget_contratos where estado='1' and fecha_termino >= '".$FechaActual."' order by fecha_termino desc";
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
              </SELECT>           </td>
            <td class="formulario2">Nro Hoja Ruta </td>
            <td width="24%" class="formulario2"><input name="TxtHoja" type="text" id="TxtRegic" value="<? echo $TxtHoja; ?>" /></td>
            <td width="5%" class="formulario2">&nbsp;</td>
            <td width="7%" class="formulario2">&nbsp;</td>
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
            <td class="formulario2">Empresa</td>
            <td class="formulario2">
              <SELECT name="CmbEmpresa" id="CmbEmpresa" style="width:250" onchange="Recarga('<? echo $Opt;?>');" >
                <option value="S"  SELECTed="SELECTed">Seleccionar</option>
                <?
	  	$Consulta = "SELECT * from sget_contratistas t1 inner join sget_contratos t2 on t1.rut_empresa=t2.rut_empresa where t2.cod_contrato ='".$CmbContrato."'order by razon_social ";
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
              </SELECT></td>
			  
            <td width="12%" class="formulario2">Fecha de Ingreso </td>
            <td colspan="3" class="formulario2"><span class="borderbajo">
              <SELECT name="CmbAno" id="CmbAno"  onchange="Proceso('R','<? echo $CmbAno; ?>')">
                <option value="T"  SELECTed="SELECTed">Todos</option>
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
		
			<SELECT name="MesIni" id="MesIni" onChange="Proceso('R','<? echo $Meses;?>')"style="width:90px;">
          <?
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
	?>
              </SELECT>
            </span></td>
          </tr>
          <tr>
            <td class="formulario2">Estado</td>
            <td class="formulario2"><SELECT name="CmbEstado" >
              <option value="S" SELECTed="SELECTed">Seleccionar</option>
              <?
		$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30008' and cod_subclase in ('1','2','3') order by cod_subclase";
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
  <table width="951" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
      <td width="921" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
      <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">		
       <tr>
          <td width="5%" align="center" class="TituloTablaVerde">M/A</td>
		  <td width="9%" align="center" class="TituloTablaVerde">Hoja Ruta</td>
          <td width="7%" align="center" class="TituloTablaVerde">Fecha Ingreso</td>
          <td width="8%" align="center" class="TituloTablaVerde">Contrato</td>
          <td width="15%" align="center" class="TituloTablaVerde">Empresa</td>
          <td width="15%" align="center" class="TituloTablaVerde">Adm.Codelco</td>
 		  <?
		  if($CmbEstado!='3')
		  {
		  ?>
		  <td width="1%" align="center" class="TituloTablaVerde">R</td>
	      <?
		  }
		  ?>
           <?
		  if($CmbEstado!='3')
		  {

		  	$Consulta = "SELECT * from sget_hitos ";
			$Consulta.=" where cod_sistema='".$CodSistema."' and cod_pantalla='".$CodPantalla."'  ";
			$RespH = mysqli_query($link, $Consulta);
			while ($FilaH=mysql_fetch_array($RespH))
			{
				?>
				<td width="5%" align="center" class="TituloTablaVerde">
				<? echo $FilaH[abrev_hito]; ?>
		  		</td>
				<?
			}
			}
			?>	
       </tr>
  <?

if($Cons=='S')
{
	$Consulta = "SELECT * from sget_hoja_ruta ";
	$Consulta.=" where not isnull(num_hoja_ruta)  ";
	if($CmbEmpresa!='S')
		$Consulta.=" and  rut_empresa='".$CmbEmpresa."' ";
	if($CmbContrato!='S')
		$Consulta.=" and  cod_contrato='".$CmbContrato."' ";
	if($TxtHoja!='')
		$Consulta.= " and num_hoja_ruta like ('%".$TxtHoja."%') ";
	if($CmbAno!='T')
	{
		$Consulta.= " and year(fecha_ingreso)= '".$CmbAno."' ";
		$Consulta.= " and month(fecha_ingreso)= '".$MesIni."' ";
	}	
	if($CmbEstado!='S')
	{
		switch($CmbEstado)
		{
			case "1":
				$Consulta.= " and cod_estado_aprobado in ('1')  ";	
			break;
			case "2":
				$Consulta.= " and cod_estado_aprobado >= 2  ";	
			break;
			case "3":
				$Consulta.= " and cod_estado_aprobado = 3  ";	
			break;
		}
	}
	$Consulta.= "  order by num_hoja_ruta,fecha_ingreso,rut_empresa asc    ";		
	$Resp = mysqli_query($link, $Consulta);
//	echo $Consulta."<br>";
	echo "<input name='CheckHoja' type='hidden'  value=''>";
	$cont=1;
	while ($Fila=mysql_fetch_array($Resp))
	{
		?>     	
		<tr> 
	    <td>
		<?
		$Consulta=" SELECT * from sget_hoja_ruta_hitos where num_hoja_ruta='".$Fila["num_hoja_ruta"]."' and cod_hito in ('1') and autorizado='S' ";
		$Resp8 = mysqli_query($link, $Consulta);
		if ($Fila8=mysql_fetch_array($Resp8))
		{
		?>
			<img src="archivos/btn_modificar.png"  border="0"  alt="No puede Modificar Personal de Nomina, Hoja Ruta esta Aprobada por Adm.Contrato" align="absmiddle" />
		<?
		}
		else
		{
		?>
		<a href="sget_hoja_ruta.php?Opt=M&EsPopup=S&TxtHoja=<? echo $Fila["num_hoja_ruta"];?>" target="_blank"><img src="archivos/btn_modificar.png"  border="0"  alt="Modifica Personal de Nomina" align="absmiddle" /></a>
		<?
		}
		if($CmbEstado!='3')
		{
			$Consulta=" SELECT * from sget_hoja_ruta_hitos where num_hoja_ruta='".$Fila["num_hoja_ruta"]."' and cod_hito in ('1') and autorizado='S' ";
			$Resp8 = mysqli_query($link, $Consulta);
			if ($Fila8=mysql_fetch_array($Resp8))
			{
			?>
			<img src="archivos/elim_hito.png"  border="0"  alt="No se Puede Anular Hoja de Ruta, Hoja Ruta esta Aprobada por Adm.Contrato" align="absmiddle">
			<?
			}
			else
			{
		?>
			<a href="JavaScript:Proceso('AHR','<? echo $Fila["num_hoja_ruta"]; ?>','<? echo $CmbEstado;?>')"><img src="archivos/elim_hito.png"  border="0"  alt="Anula Hoja de Ruta" align="absmiddle" /></a>		
		<?
			}
		}
		else
		{
		?>
		<a href="JavaScript:Proceso('ACHR','<? echo $Fila["num_hoja_ruta"]; ?>','<? echo $CmbEstado;?>')"><img src="archivos/activo.png"  alt="Activar Hoja de Ruta" border="0"  align="absmiddle" /></a>		
		<?
		}
		?>
		</td>
		<td>
		<a href="sget_hoja_ruta_pdf.php?NumHR=<? echo $Fila["num_hoja_ruta"];?>" target="_blank"><img src="archivos/adobe.png"  alt="Hoja Ruta PDF" border="0" width='23' height='23' align="absmiddle" /></a><a href="sget_detalle_estados.php?Opt=M&EsPopup=S&TxtHoja=<? echo $Fila["num_hoja_ruta"];?>" target="_blank"><img src="archivos/btn_observaciones.png"  border="0"  width='23' height='23' alt="Detalle Hoja de Ruta" align="absmiddle" /></a><? echo $Fila["num_hoja_ruta"]."&nbsp;"; ?>
		</td>
        <td ><? echo substr($Fila["fecha_ingreso"],0,10)."&nbsp;"; ?>&nbsp;</td>
        <td ><a href="sget_info_ctto.php?Ctto=<? echo $Fila["cod_contrato"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Contrato" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;<? echo $Fila["cod_contrato"]."&nbsp;"; ?></td>
        <td >
		<? 
		    $RazonSoc=str_replace(' ','&nbsp;',FormatearNombre(DescripcionRazonSocial($Fila["rut_empresa"])));
	?>
		<a href="sget_info_empresa.php?Emp=<? echo $Fila["rut_empresa"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Empresa" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;<? echo $RazonSoc."&nbsp;"; ?>
		</td>
          	<td >
			<?
		   	$VarCodelco=AdmCttoCodelcoHR($Fila["num_hoja_ruta"]);
		   	$array=explode('~',$VarCodelco);
		   	echo FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
	   		?>&nbsp;
			</td>
			<?
			if($CmbEstado!='3')
			{
		    ?>	
			<td>
			<?
				$Consulta=" SELECT * from sget_hoja_ruta_hitos where num_hoja_ruta='".$Fila["num_hoja_ruta"]."' and cod_hito in ('1') and autorizado='S' ";
				$Resp8 = mysqli_query($link, $Consulta);
				if ($Fila8=mysql_fetch_array($Resp8))
				{
					echo "<img src='archivos/reasigna.png' border='0' alt='No se Puede Reasignar Adm.Codelco, ya fue aprobado' align='absmiddle'>";
				}
				else
				{
					echo "<a href='sget_adm_hoja_ruta_reasigna.php?NumHoja=".$Fila["num_hoja_ruta"]."' target='_blank'><img src='archivos/reasigna.png' border='0' alt='Reasigna Adm. Codelco' align='absmiddle'></a>";
				}
			?>
			</td>
          	<?
			}
			?>
			<?
			if($CmbEstado!='3')
			{
				$Consulta="SELECT * from sget_hoja_ruta_nomina where num_hoja_ruta='".$Fila["num_hoja_ruta"]."'"; 
				$RespNom=mysqli_query($link, $Consulta);
				if($FilaNom=mysql_fetch_array($RespNom))
				{
					$Consulta = "SELECT * from sget_hitos ";
					$Consulta.=" where cod_sistema='".$CodSistema."' and cod_pantalla='".$CodPantalla."'  ";
					$RespHD = mysqli_query($link, $Consulta);
					while ($FilaHD=mysql_fetch_array($RespHD))
					{
						?>
						<td width="5%" align="center">
						<?
						$IcoObs=CantObs($Fila["num_hoja_ruta"],$FilaHD[cod_hito]);
						$Consulta="SELECT * from sget_hoja_ruta_hitos where num_hoja_ruta='".$Fila["num_hoja_ruta"]."' and cod_hito='".$FilaHD[cod_hito]."' ";
						$RespExi = mysqli_query($link, $Consulta);
						if($FilaExi=mysql_fetch_array($RespExi))
						{	
							
							if($FilaExi[autorizado]=='S')
							{
								$HitosAdm=ContabHitosAdm($Fila["num_hoja_ruta"],'15');
								if($HitosAdm =='S')
								{
									$Consulta=" SELECT * from sget_hoja_ruta_hitos where num_hoja_ruta='".$Fila["num_hoja_ruta"]."' and cod_hito in ('1') and autorizado='S' ";
									$RespGI = mysqli_query($link, $Consulta);
									if ($FilaGI=mysql_fetch_array($RespGI))
									{
										?>
										<img src="archivos/acepta_final6.png" border="0" alt="No Se puede Rechazar <? echo $FilaHD[descrip_hito];  ?>, esta Aprobado Por El Adm.COntratos" 	align="absmiddle">
										<?
									}
									else
									{	
										?>
										<a href="JavaScript:Rech('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/acepta.png" border="0" alt="Rechazo Hito <? echo $FilaHD[descrip_hito];  ?>" 	align="absmiddle"></a>
										<?
									}
								}
								else
								{
									?>
									<img src="archivos/acepta_final6.png" border="0" alt="No Se puede Rechazar <? echo $FilaHD[descrip_hito];  ?>, esta Aprobado Por El Adm.COntratos" 	align="absmiddle">
									<?
								}
								?>
							<a href=	"JavaScript:Obs('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/<? echo $IcoObs;  ?>"  border="0"  alt="Ingreso Observaci�n <? echo $FilaHD[descrip_hito];  ?>" align=	"absmiddle" /></a>
							<?
							}
							else
							{
								?>
								<a href="JavaScript:Auto('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/proceso.png" border="0" alt="<? echo $FilaHD[descrip_hito];  ?>" 	align="absmiddle"></a><a href=	"JavaScript:Obs('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/<? echo $IcoObs;  ?>"  border="0"  alt="Ingreso Observaci�n <? echo $FilaHD[descrip_hito];  ?>" align=	"absmiddle" /></a>
								<?
							}
						}
						else
						{
							?>	
							<a href="JavaScript:Auto('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/proceso.png" border="0" alt="<? echo $FilaHD[descrip_hito];  ?>" 	align="absmiddle"></a><a href=	"JavaScript:Obs('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/<? echo $IcoObs;  ?>"  border="0"  alt="Ingreso Observaci�n <? echo $FilaHD[descrip_hito];  ?>" align=	"absmiddle" /></a>			
							<?
						}
						?>
						</td>
						<?
					}
				}
				else
				{
					echo "<td align='center'><img src='archivos/sin_user_nomina.png' border='0' alt='Hoja Ruta sin Personal Asociado' 	align='absmiddle'></td>";
				}
			}
			?>	 		  
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