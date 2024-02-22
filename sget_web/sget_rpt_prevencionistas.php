<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
//if(!isset($Cons))
//	$Cons='S';

if(!isset($HoraActual))
	$HoraActual = date("H");
if(!isset($MinutoActual))
	$MinutoActual = date("i");	
if(!isset($TxtFEcha))
	$TxtFEcha=date("Y-m-d");
if(!isset($TxtSalida))	
	$TxtSalida=date("Y-m-d");
if(!isset($TxtBus))		
	$TxtBus	=date("Y-m-d");
if(!isset($TxtFEntrada))
	$TxtFEntrada=date("Y-m-d");
if(!isset($TxtFSalida))
	$TxtFSalida=date("Y-m-d");
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
		case "R":
			f.action='sget_rpt_prevencionistas.php?';
			f.submit();
		break;
		case "BE"://PARA BUSCAR POR FECHA ENTRADA
			f.action='sget_rpt_prevencionistas.php?Buscar=S';
			f.submit();
		break;
		case "E"://PARA BUSCAR POR FECHA ENTRADA
			URL="sget_rpt_prevencionistas_excel.php?TxtRut="+f.TxtRut.value+"&TxtNombre="+f.TxtNombre.value+"&TxtPaterno="+f.TxtPaterno.value+"&TxtMaterno="+f.TxtMaterno.value+"&CmbEstado="+f.CmbEstado.value+"&TxtEmpresa="+f.TxtEmpresa.value;
			opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=660,height=700,scrollbars=1';
			//verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 1024));
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=22";
		break;
	}	
}
</script>
<title>Consulta Prevencionistas</title>
<style type="text/css">
<!--
body {
	/*background-image: url(archivos/f1.gif);*/
}
-->
</style>

<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css" />
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>

<form name="FrmPrincipal" method="post" action="" >
 <? include("encabezado.php")?>

 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top">
 <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
              <td width="271"><img src="archivos\Titulos\rpt_prevencionista.png"></td>
              <td width="179" align="right"><font color="#9E5B3B">&nbsp;<font face="Times New Roman, Times, serif" size="2">Servidor 
                <? 
				$IP_SERV = $HTTP_HOST;
				echo $IP_SERV;?>
              </font></font></td>
              <td width="304" align="right"><font size="2" face="Times New Roman, Times, serif">&nbsp; 
                </font><font color="#9E5B3B" face="Times New Roman, Times, serif">&nbsp; 
                <? 
				//$Fecha_Hora = date("d-m-Y h:i");
				$FechaFor=FechaHoraActual();
				echo $FechaFor." hrs";
				?>
                </font></td>
            </tr>
        </table></td>
    </tr>
  </table>
  <table width="950"  border="0" align="center"  cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td><table width="920" align="center"  cellspacing="0">
          <tr>
            <td height="35" colspan="2" align="left" class="FilaAbeja2"   ><span class="formulario2"><img src="archivos/images/interior/t_buscadorGlobal4.png" /></span></td>
            <td colspan="2" align="right" class="FilaAbeja2" ><a href="JavaScript:Proceso('E')"><img src="archivos/ico_excel5.jpg"  alt=" Volver " width="24" height="25"  border="0" align="absmiddle" /></a>
			<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>            </td>
          </tr>
          <tr>
            <td width="15%" height="23" align="left" class="FilaAbeja2"   >Rut</td>
            <td align="left" class="FilaAbeja2"   ><label>
              <input name="TxtRut" type="text" id="TxtRut"  value="<? echo $TxtRut?>"/>
            </label></td>
            <td align="left" class="FilaAbeja2"   >Nombres</td>
            <td align="left" class="FilaAbeja2"   ><input name="TxtNombre" type="text" id="TxtNombre" value="<? echo $TxtNombre?>"/></td>
          </tr>
          <tr>
            <td height="25" align="left" class="FilaAbeja2"   >Apellido Paterno </td>
            <td width="14%" align="left" class="FilaAbeja2"   ><input name="TxtPaterno" type="text" id="TxtPaterno" value="<? echo $TxtPaterno?>"/></td>
            <td width="16%" align="left" class="FilaAbeja2" >Apellido Materno </td>
            <td align="left" class="FilaAbeja2" ><input name="TxtMaterno" type="text" id="TxtMaterno" value="<? echo $TxtMaterno?>"/></td>
          </tr>
          <tr>
            <td height="25" align="left" class="FilaAbeja2"   >Razon Social (Empresa) </td>
            <td align="left" class="FilaAbeja2"   ><span class="formulario2">
              <input name="TxtEmpresa" type="text" id="TxtEmpresa" value="<? echo $TxtEmpresa; ?>" />
            </span></td>
            <td align="left" class="FilaAbeja2" >Estado Contrato</td>
            <td align="left" class="FilaAbeja2" ><SELECT name="CmbEstado">
              <?
				switch($CmbEstado)
				{
					case "A":
						echo "<option value='T'>Todos</option>";
						echo "<option value='A' SELECTed>Activos</option>";
						echo "<option value='I'>Inactivos</option>";
					break;
					case "I":
						echo "<option value='T'>Todos</option>";
						echo "<option value='A'>Activos</option>";
						echo "<option value='I' SELECTed>Inactivos</option>";
					break;
					default:
						echo "<option value='T' SELECTed>Todos</option>";
						echo "<option value='A'>Activos</option>";
						echo "<option value='I'>Inactivos</option>";
					break;
				}
			?>
            </SELECT>
              <a href="JavaScript:Proceso('BE')" class="SinBorde"><img src="archivos/Find2.png" width="23" height="20" alt="Buscar Patentes de la Fecha" class="SinBorde"/></a>&nbsp;</td>
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
  <br/>
  <table width="955"   border="0" align="center" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
    <tr>
      <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
      <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
      <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    </tr>
    <tr>
      <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
      <td>
	  <table width="100" border="1" align="center" cellpadding="2" cellspacing="0">
      </table>
        <table width="1000" border="1" align="center" cellpadding="2" cellspacing="0">
          <tr>
          <td width="30%" align="center" class="TituloTablaVerde">Nombres</td>
          <td width="11%" align="center" class="TituloTablaVerde">Rut </td>
          <td width="13%" align="center" class="TituloTablaVerde">Telefono&nbsp;1</td>
          <td width="13%" align="center" class="TituloTablaVerde">Telefono&nbsp;2</td>
          <td width="13%" align="center" class="TituloTablaVerde">Correo&nbsp;1</td>
          <td width="13%" align="center" class="TituloTablaVerde">Correo&nbsp;2</td>
          <td width="13%" align="center" class="TituloTablaVerde">Registro Serganomin</td>
          <td width="13%" align="center" class="TituloTablaVerde">Registro SNS</td>
          <td width="13%" align="center" class="TituloTablaVerde">T�tulo<br>Profesional</td>
		  <td width="13%" align="center" class="TituloTablaVerde">Observaci�n</td>
		  <td width="21%" align="center" class="TituloTablaVerde">Empresa</td>
          <td width="13%" align="center" class="TituloTablaVerde">D�as&nbsp;y&nbsp;Horas Asesor�a</td>
          <td width="25%" align="center" class="TituloTablaVerde">N� Contrato</td>
          <td width="25%" align="center" class="TituloTablaVerde">Nombre&nbsp;Contrato</td>
          <td width="10%" align="center" class="TituloTablaVerde">Fecha&nbsp;Inicio</td>
          <td width="10%" align="center" class="TituloTablaVerde">Fecha&nbsp;T�rmino</td>
          </tr>
          <?
		  if($Buscar=='S')
		  {
				$CuentaR='N';
				$Consulta = "SELECT * from sget_prevencionistas t1 inner join sget_contratos t2 on t1.rut_prev=t2.rut_prev";
				$Consulta.=" inner join sget_contratistas t3 on t3.rut_empresa=t2.rut_empresa";
				$Consulta.= " where t1.rut_prev<>''";
				if($TxtRut!='')
					$Consulta.= " and t1.rut_prev='".$TxtRut."'";
				if($TxtNombre!='')	
					$Consulta.= " and t1.nombres like '%".$TxtNombre."%'";
				if($TxtPaterno!='')
					$Consulta.= " and t1.apellido_paterno like '%".$TxtPaterno."%'";
				if($TxtMaterno!='')
					$Consulta.= " and t1.apellido_materno like '%".$TxtMaterno."%'";
				if($TxtEmpresa!='')
					$Consulta.= " and t3.razon_social like '%".$TxtEmpresa."%'";
				if($CmbEstado!='T')
				{
					if($CmbEstado=='I')
						$Consulta.=" and t2.fecha_termino < '".date('Y-m-d')."'";	
					else
						$Consulta.=" and t2.fecha_termino > '".date('Y-m-d')."'";		
				}
				$Consulta.= " group by t1.rut_prev order by t1.apellido_paterno,t1.apellido_materno,t1.nombres";
				//echo $Consulta;
				$Resp = mysql_query($Consulta);
				echo "<input name='CheckConduc' type='hidden'  value=''>";
				$Cont=1;
				while ($Filas=mysql_fetch_array($Resp))
				{
					$ConsultaEmp="SELECT count(t1.rut_empresa) as cantEmp from sget_contratos t1 inner join sget_contratistas t2 on t1.rut_empresa=t2.rut_empresa where t1.rut_prev='".$Filas[rut_prev]."' ";
					if($TxtEmpresa!='')
						$ConsultaEmp.= " and t2.razon_social like '%".$TxtEmpresa."%'";
					if($CmbEstado!='T')
					{
						if($CmbEstado=='I')
							$ConsultaEmp.=" and fecha_termino < '".date('Y-m-d')."'";	
						else
							$ConsultaEmp.=" and fecha_termino > '".date('Y-m-d')."'";		
					}
					$ConsultaEmp.=" order by razon_social";
					//echo $ConsultaEmp;
					$RespEmp = mysql_query($ConsultaEmp);$CantEmp=0;
					$FilaEmp=mysql_fetch_array($RespEmp);
					$CantEmp=$FilaEmp[cantEmp];
					
					$SeparoRegis=explode('~',$Filas[regis_sns_serg]);
					$TxtSerga=$SeparoRegis[0];
					$TxtSNS=$SeparoRegis[1];
				  ?>
					  <tr>
						<td align="left" rowspan="<? echo $CantEmp;?>"><? echo strtoupper($Filas["apellido_paterno"]." ".$Filas["apellido_materno"]." ".$Filas["nombres"]); ?></td>
						<td align="left" rowspan="<? echo $CantEmp;?>"><? echo strtoupper(str_pad($Filas[rut_prev],10,0,STR_PAD_LEFT)); ?></td>
						<td align="left" rowspan="<? echo $CantEmp;?>"><? echo $Filas[telefono]; ?>&nbsp;</td>
						<td align="left" rowspan="<? echo $CantEmp;?>"><? echo $Filas[celular]; ?>&nbsp;</td>
						<td align="left" rowspan="<? echo $CantEmp;?>"><? echo $Filas[email_1]; ?>&nbsp;</td>
						<td align="left" rowspan="<? echo $CantEmp;?>"><? echo $Filas[email_2]; ?>&nbsp;</td>
						<td align="left" rowspan="<? echo $CantEmp;?>"><? echo ucwords(strtolower($TxtSerga)); ?>&nbsp;</td>
						<td align="left" rowspan="<? echo $CantEmp;?>"><? echo ucwords(strtolower($TxtSNS)); ?>&nbsp;</td>
						<td align="left" rowspan="<? echo $CantEmp;?>"><? echo $Filas[titulo]; ?>&nbsp;</td>
						<td width="13%" rowspan="<? echo $CantEmp;?>"><textarea name="Obs" cols="20" readonly="readonly"><? echo $Filas["observacion"]; ?></textarea>&nbsp;</td>
						<?
						$CeldaBlanca='S';
						$ConsultaEmp="SELECT t1.rut_empresa,t2.razon_social from sget_contratos t1 inner join sget_contratistas t2 on t1.rut_empresa=t2.rut_empresa where t1.rut_prev='".$Filas[rut_prev]."'";
						if($TxtEmpresa!='')
							$ConsultaEmp.= " and t2.razon_social like '%".$TxtEmpresa."%'";
						if($CmbEstado!='T')
						{
							if($CmbEstado=='I')
								$ConsultaEmp.=" and fecha_termino < '".date('Y-m-d')."'";	
							else
								$ConsultaEmp.=" and fecha_termino > '".date('Y-m-d')."'";		
						}
						$ConsultaEmp.=" group by rut_empresa order by razon_social";
						//echo $ConsultaEmp."<br>";
						$RespEmp = mysql_query($ConsultaEmp);
						while($FilaEmp=mysql_fetch_array($RespEmp))
						{
							$ConsultaCont="SELECT count(cod_contrato) as cantContra from sget_contratos where rut_prev='".$Filas[rut_prev]."' and rut_empresa='".$FilaEmp[rut_empresa]."' ";
							if($CmbEstado!='T')
							{
								if($CmbEstado=='I')
									$ConsultaCont.=" and fecha_termino < '".date('Y-m-d')."'";	
								else
									$ConsultaCont.=" and fecha_termino > '".date('Y-m-d')."'";		
							}
							$ConsultaCont.=" order by descripcion";
							$RespCont = mysql_query($ConsultaCont);$CantCont=0;
							$FilaCont=mysql_fetch_array($RespCont);
							$CantCont=$FilaCont[cantContra];
							
							?>
							<td align="left" rowspan="<? echo $CantCont;?>"><? echo ucwords(strtolower($FilaEmp[razon_social]));?>&nbsp;</td>
							<?
							$ConsultaCont="SELECT descripcion,fecha_termino,fecha_inicio,cod_contrato,tipo_jornada from sget_contratos where rut_prev='".$Filas[rut_prev]."' and rut_empresa='".$FilaEmp[rut_empresa]."' ";
							if($CmbEstado!='T')
							{
								if($CmbEstado=='I')
									$ConsultaCont.=" and fecha_termino < '".date('Y-m-d')."'";	
								else
									$ConsultaCont.=" and fecha_termino > '".date('Y-m-d')."'";		
							}
							$ConsultaCont.=" order by fecha_termino desc,descripcion";
							//echo $ConsultaCont;
							$RespCont = mysql_query($ConsultaCont);$CantCont=0;
							while($FilaCont=mysql_fetch_array($RespCont))
							{	
								$Class='';
								if($FilaCont[fecha_termino] < date('Y-m-d'))							
									$Class='class=InputRojo';
								?>	
								<td align="left"<? echo $Class;?>><? echo $FilaCont[tipo_jornada];?>&nbsp;</td>
								<td align="left"<? echo $Class;?>><? echo $FilaCont["cod_contrato"];?>&nbsp;</td>
								<td align="left"<? echo $Class;?>><? echo $FilaCont["descripcion"];?>&nbsp;</td>
								<td align="center"><? echo $FilaCont[fecha_inicio];?>&nbsp;</td>
								<td align="center"<? echo $Class;?>><? echo $FilaCont[fecha_termino];?>&nbsp;</td>
				   				</tr>
					  			<?		
							}//FIN CONTRATOS
							$CeldaBlanca='N';
						}//FIN EMPRESA
						if($CeldaBlanca=='S')
						{
							?>
								<td align="left"<? echo $Class;?>>&nbsp;</td>
								<td align="left"<? echo $Class;?>>&nbsp;</td>
								<td align="center"<? echo $Class;?>>&nbsp;</td>
			    				</tr>
							<?
						}
				  $Cont++;
				  $CuentaR='S';
				}
				if($CuentaR=='N')
				{
					?>
					  <tr>	
						<td colspan="4" align="center" ><span class="InputRojo"><? echo "Sin Registros para busqueda" ?></span></td>
					  </tr>
					<?
				}
			}	
			//}
			?>
        </table></td>
      <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
    </tr>
    <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>
  <p>  </td>
    </tr>
  </table>
	<? include("pie_pagina.php")?>
<?
$Pasa='N';
$Consulta="SELECT * from sget_transporte_ingreso where patente='".$PatenteIng."' and estado='E'";
$Resp=mysql_query($Consulta);
if($Fila=mysql_fetch_array($Resp))
{
	$Consulta="SELECT * from sget_transporte_ingreso where patente='".$Fila["patente"]."' and estado='S' and corr_transporte='".$Fila[corr_transporte]."'";
	$Resp=mysql_query($Consulta);
	if(!$Fila=mysql_fetch_array($Resp))
	{	
		$Pasa='S';
	}
}
?>
<input type="hidden" name="PasaPaten" value='<? echo $Pasa;?>' />	
</form>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Msj=='G')
		echo "alert('Patente ingresada con �xito');";
	if ($Msj=='M')
		echo "alert('Patente modificada con �xito');";
	if ($Msj=='Sa')
		echo "alert('Salida ingresada con �xito');";
	if ($Msj=='E')
		echo "alert('Patente eliminada con �xito');";
	echo "</script>";
?>