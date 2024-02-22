<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
//if(!isset($Cons))
//	$Cons='S';

	
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
			f.action='sget_mantenedor_conductores.php?Cons=S';
			f.submit();
			break;
		case "N":
			URL="sget_mantenedor_conductores_proceso.php?Opc="+Opc;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=1024,height=700,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckConduc','M'))
			{
				Datos=Recuperar(f.name,'CheckConduc');
				//alert (Datos);
				URL="sget_mantenedor_conductores_proceso.php?Opc="+Opc+"&CorrCond="+Datos;
				opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=1024,height=700,scrollbars=1';
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
			}	
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckConduc','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckConduc');
					//alert(Datos);
					f.action='sget_mantenedor_conductores_proceso01.php?Opcion=E&Valor='+Datos;
					f.submit();
				}	
			}
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=1";
		break;
		case "EX":
			URL="sget_mantenedor_conductores_proceso_carga.php?Opc="+Opc+"&Valores="+Datos+"&Borra=S";
			opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=990,height=500,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 1024));
		break;
	}	
}
function Validar(RUT,Val)
{
	var f=document.FrmPrincipal;
	if(Val=='S')
		var mensaje=confirm('�Est� Seguro de Validar Conductor?');		
	else
		var mensaje=confirm('�Est� Seguro de Desvalidar Conductor?');		
	if(mensaje==true)	
	{
		f.action='sget_mantenedor_conductores_proceso01.php?Opcion=VAL&Validar='+Val+'&Rut='+RUT;
		f.submit();
	}
}
</script>
<title>Mantenedor de Conductores</title>
<style type="text/css">
<!--
body {
	/*background-image: url(archivos/f1.gif);*/
}
-->
</style>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
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
              <td width="271"><img src="archivos\Titulos\mant_conductores.png"></td>
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
            <td height="35" colspan="4" align="left" class="FilaAbeja2"   ><img src="archivos/images/interior/t_buscadorGlobal4.png" /> </td>
            <td colspan="2" align="right" class="FilaAbeja2" >
			<a href="JavaScript:Proceso('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:Proceso('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a> 
			<a href="JavaScript:Proceso('EX')"><img src="archivos/Cexec.png"  alt="Procesa Excel"  border="0" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:Proceso('M')"><img src="archivos/btn_modificar3.png" border="0" alt="Modificar" align="absmiddle"></a><a href="JavaScript:Proceso('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a><a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>            </td>
          </tr>
          <tr>
            <td width="12%" class="FilaAbeja2">Apellido Paterno </td>
            <td width="31%" class="FilaAbeja2"><input name="TxtPat" type="text" id="TxtPat" size="30" /></td>
            <td width="14%" class="FilaAbeja2">Apellido Materno </td>
            <td width="13%" class="FilaAbeja2"><input name="TxtMat" type="text" id="TxtMat" /></td>
            <td width="19%" class="FilaAbeja2">&nbsp;</td>
            <td width="11%" class="FilaAbeja2">&nbsp;</td>
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
            <td class="FilaAbeja2">Contrato</td>
            <td class="FilaAbeja2"><input name="TxtContrato" type="text" id="TxtContrato" size="30" /></td>
            <td class="FilaAbeja2">Empresa</td>
            <td colspan="2" class="FilaAbeja2"><input name="TxtEmp" type="text" id="TxtEmp" size="50" /></td>
            <td class="FilaAbeja2">&nbsp;</td>
          </tr>
          <tr>
            <td class="FilaAbeja2">Fecha Vig. Licencia </td>
            <td class="FilaAbeja2">Desde 
            <input name="TxtFechaDVIG" type="text" id="TxtFechaDVIG"   size="10" readonly="readonly">
			&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaDVIG,TxtFechaDVIG,popCal);return false" /> 
			&nbsp;Hasta
            <input name="TxtFechaHVIG" type="text" id="TxtFechaHVIG"   size="10" readonly="readonly">
			&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaHVIG,TxtFechaHVIG,popCal);return false" />			</td>
            <td class="FilaAbeja2">Tipo Licencia </td>
            <td class="FilaAbeja2"><SELECT name="CmbTipo">
              <?
					  switch($CmbTipo)
					  {
					  	case "A5":
								?>
              <option value="T">Todos</option>
              <option value="A5" SELECTed="SELECTed">A5</option>
              <option value="A4">A4</option>
              <option value="A3">A3</option>
              <option value="A2">A2</option>
              <option value="A1">A1</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="C">D</option>
              <?
						break;
					  	case "A4":
								?>
              <option value="T">Todos</option>
              <option value="A5">A5</option>
              <option value="A4" SELECTed="SELECTed">A4</option>
              <option value="A3">A3</option>
              <option value="A2">A2</option>
              <option value="A1">A1</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="C">D</option>
              <?
						break;
					  	case "A3":
								?>
              <option value="T">Todos</option>
              <option value="A5">A5</option>
              <option value="A4">A4</option>
              <option value="A3" SELECTed="SELECTed">A3</option>
              <option value="A2">A2</option>
              <option value="A1">A1</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="C">D</option>
              <?
						break;
					  	case "A2":
								?>
              <option value="T">Todos</option>
              <option value="A5">A5</option>
              <option value="A4">A4</option>
              <option value="A3">A3</option>
              <option value="A2" SELECTed="SELECTed">A2</option>
              <option value="A1">A1</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="C">D</option>
              <?
						break;
					  	case "A1":
						break;
					  	case "B":
								?>
              <option value="T">Todos</option>
              <option value="A5">A5</option>
              <option value="A4">A4</option>
              <option value="A3">A3</option>
              <option value="A2">A2</option>
              <option value="A1">A1</option>
              <option value="B" SELECTed="SELECTed">B</option>
              <option value="C">C</option>
              <option value="C">D</option>
              <?
						break;
					  	case "C":
								?>
              <option value="T">Todos</option>
              <option value="A5">A5</option>
              <option value="A4">A4</option>
              <option value="A3">A3</option>
              <option value="A2">A2</option>
              <option value="A1">A1</option>
              <option value="B">B</option>
              <option value="C" SELECTed="SELECTed">C</option>
              <option value="C">D</option>
              <?
						break;
					  	case "D":
								?>
              <option value="T">Todos</option>
              <option value="A5">A5</option>
              <option value="A4">A4</option>
              <option value="A3">A3</option>
              <option value="A2">A2</option>
              <option value="A1">A1</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="C" SELECTed="SELECTed">D</option>
              <?
						break;
						default:
								?>
              <option value="T" SELECTed="SELECTed">Todos</option>
              <option value="A5">A5</option>
              <option value="A4">A4</option>
              <option value="A3">A3</option>
              <option value="A2">A2</option>
              <option value="A1">A1</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="C">D</option>
              <?
						break;
					  }
					?>
            </SELECT></td>
            <td class="FilaAbeja2">&nbsp;</td>
            <td class="FilaAbeja2">&nbsp;</td>
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
      <td><table width="928" border="1" align="center" cellpadding="2" cellspacing="0">
            <tr>
              <td width="4%" class="TituloTablaVerde"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onclick="CheckearTodo(this.form,'CheckConduc','ChkTodos');" /></td>
              <td width="8%" align="center" class="TituloTablaVerde">Rut</td>
			  <td width="18%" align="center" class="TituloTablaVerde">Nombre</td>
              <td width="13%" align="center" class="TituloTablaVerde">Tipo Vehiculo</td>
              <td width="13%" align="center" class="TituloTablaVerde">Tipo Licencias</td>
              <td width="15%" align="center" class="TituloTablaVerde">Restricci&oacute;n</td>
              <td width="13%" align="center" class="TituloTablaVerde">Fecha&nbsp;Vig. Licencia&nbsp;municipal</td>
              <td width="11%" align="center" class="TituloTablaVerde">Fecha&nbsp;Vig.&nbsp;Exa. Preoc.</td>
              <td width="11%" align="center" class="TituloTablaVerde">Fecha&nbsp;Vig.&nbsp;Exa. psico-senso-tecnico</td>
              <td width="11%" align="center" class="TituloTablaVerde">Fecha&nbsp;Vig. Curso Manejo&nbsp;Defensivo</td>
              <td width="11%" align="center" class="TituloTablaVerde">Empresa </td>
              <td width="11%" align="center" class="TituloTablaVerde">N&deg; Contrato </td>
              <td width="11%" align="center" class="TituloTablaVerde">Validado</td>
              <td width="11%" align="center" class="TituloTablaVerde">Observaci�n</td>
            </tr>
            <?
			if($Cons=='S')
			{
				$ConsultaC="SELECT valor_subclase1,valor_subclase2,valor_subclase3 from proyecto_modernizacion.sub_clase where cod_clase='30024'";
				$RC=mysql_query($ConsultaC);
				$FC=mysql_fetch_array($RC);
				$AnoDAS=$FC["valor_subclase1"];
				$AnoPreo=$FC["valor_subclase2"];
				$Ano2Ocu=$FC[valor_subclase3];
				echo "<input name='CheckConduc' type='hidden'  value=''>";
				$Consulta="SELECT *,t1.corr_conductor from sget_conductores t1 left join sget_conductores_licencias t2 on t1.corr_conductor=t2.corr_conductor where t1.corr_conductor<>''";
				if($TxtPat!='')
					$Consulta.=" and t1.apellido_paterno like '%".$TxtPat."%'";
				if($TxtMat!='')
					$Consulta.=" and t1.apellido_materno like '%".$TxtMat."%'";
				if($TxtContrato!='')	
					$Consulta.=" and t1.contrato like '%".$TxtContrato."%'";
				if($TxtEmp!='')	
					$Consulta.=" and t1.empresa like '%".$TxtEmp."%'";
				if($CmbTipo!='T' && $CmbTipo!='')	
					$Consulta.=" and t2.tipo_licencia like '".$CmbTipo."'";
				if($TxtFechaDVIG!=''&&$TxtFechaHVIG!='')	
					$Consulta.=" and fecha_vig_licencia between '".$TxtFechaDVIG."' and '".$TxtFechaHVIG."'";
				$Consulta.=" group by t1.corr_conductor order by apellido_paterno,apellido_materno,nombres";	
				$Resp = mysql_query($Consulta);
				//echo $Consulta;
				$Cont=1;
				while ($Fila=mysql_fetch_array($Resp))
				{
				
					?>
					<tr>	
					  <td ><? echo "<input name='CheckConduc' class='SinBorde' type='checkbox'  value='".$Fila["corr_conductor"]."'>" ?></td>
					  <td ><? echo $Fila["rut"]; ?></td>
					  <td ><? echo ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"])); ?></td>
					  <td align="center"><? 
					  if(strtoupper($Fila["tipo_vehiculo"])=='VL') 
					  		echo "Veh&iacute;culo Liviano";
					  if(strtoupper($Fila["tipo_vehiculo"])=='EP') 
					  		echo "Veh&iacute;culo Pesado";			
					  ?>&nbsp;</td>
					  <td align="left" >
					  <? $Tipo='';
					  $ConsulTip="SELECT tipo_licencia from sget_conductores_licencias where corr_conductor='".$Fila["corr_conductor"]."'";	
					  $RespTip=mysql_query($ConsulTip);
					  while($FilasTip=mysql_fetch_array($RespTip))
					  {
					  		$Tipo=$Tipo.$FilasTip["tipo_licencia"].", "; 					  	
					  }
					  echo substr($Tipo,0,strlen($Tipo)-2);
					  
					  if($Fila["fecha_curso_manejo"]=='0000-00-00')
					  	$Fila["fecha_curso_manejo"]='';
						
					 /* //CONSULTAMOS SI LA FECHA DEL Psico-senso-tecnico 	
					  if(strtoupper($Fila["tipo_vehiculo"])=='VL')//VEHICULO LIVIANO
						 $fecha_cambiada = mktime(0,0,0,substr($Fila["fecha_exa_pst"],5,2),substr($Fila["fecha_exa_pst"],8,2),substr($Fila["fecha_exa_pst"],0,4)+4);
					  else//VEHICULO PESADO
						 $fecha_cambiada = mktime(0,0,0,substr($Fila["fecha_exa_pst"],5,2),substr($Fila["fecha_exa_pst"],8,2),substr($Fila["fecha_exa_pst"],0,4)+1);	
					  $fechaPST = date("Y-m-d", $fecha_cambiada);*/
					  
					  //echo $Fila["fecha_exa_pst"]." < ".date('Y-m-d')."<br>"; 
					  $TxtExaPreocu2=explode('-',$Fila["fecha_exa_preoc"]);
					  $TxtExaPreocu2[0]=$TxtExaPreocu2[0]+$AnoPreo;
					  $FechaTerminoPreo=$TxtExaPreocu2[0]."-".$TxtExaPreocu2[1]."-".$TxtExaPreocu2[2];
					  if($FechaTerminoPreo< date('Y-m-d'))	
						  $FechaTerminoPreo="<span class='InputRojo'>".$FechaTerminoPreo."</span>";
					  else
						  $FechaTerminoPreo=$FechaTerminoPreo;
					  if($Fila["fecha_exa_pst"]< date('Y-m-d'))	
						  $FVigPST="<span class='InputRojo'>".$Fila["fecha_exa_pst"]."</span>";
					  else
						  $FVigPST=$Fila["fecha_exa_pst"];						  
					  if($Fila["fecha_curso_manejo"]< date('Y-m-d'))	
						  $FVigCurso="<span class='InputRojo'>".$Fila["fecha_curso_manejo"]."</span>";
					  else
						  $FVigCurso=$Fila["fecha_curso_manejo"];						  
					  if($Fila["fecha_vig_licencia"]< date('Y-m-d'))	
						  $FVigLicencia="<span class='InputRojo'>".$Fila["fecha_vig_licencia"]."</span>";
					  else
						  $FVigLicencia=$Fila["fecha_vig_licencia"];						  
						  						
					  if($Fila["fecha_exa_pst"] < date('Y-m-d'))
					  		ActualizaEstadoConductor($Fila["corr_conductor"]);	
					  ?>
					  &nbsp;</td>
					  <td ><textarea name="Restriccion" cols="30" readonly="readonly"><? echo $Fila["restriccion_licencia"]?></textarea></td>
					  <td align="center" ><? echo $FVigLicencia; ?></td>
					  <td align="center" ><? echo $FechaTerminoPreo."&nbsp;"; ?></td>
					  <td align="center"><? echo $FVigPST."&nbsp;"; ?></td>
					  <td align="center" ><? echo $FVigCurso."&nbsp;"; ?></td>
					  <td ><? echo $Fila["empresa"]."&nbsp;"; ?></td>
					  <td ><? echo $Fila["contrato"]."&nbsp;"; ?></td>
					  <td align="center" >
					  <? 
					  		$ConHoja="SELECT cod_estado_aprobado from sget_hoja_ruta_nomina t1 inner join sget_hoja_ruta t2 on t1.num_hoja_ruta=t2.num_hoja_ruta";
							$ConHoja.=" where rut_personal='".$Fila["rut"]."'";
							//echo $ConHoja."<br>";
							$RHoja=mysql_query($ConHoja);
							if($FHoja=mysql_fetch_array($RHoja))
								$Aprobaci�n=$FHoja[cod_estado_aprobado];
								
							if($Fila[validado]=='N')
							{
								if($Fila["fecha_exa_pst"] < date('Y-m-d'))
									echo "<img src='archivos/proceso.png' class='SinBorde' alt='Conductor No Validado para Validar, Modificar Fecha Examen Psico-senso-tecnico.'>";
								else
									echo "<a href=JavaScript:Validar('".$Fila["rut"]."','S')><img src='archivos/proceso.png' class='SinBorde' alt='Conductor No Validado (Desea Validar)'></a>";	
							}
							else
								echo "<a href=JavaScript:Validar('".$Fila["rut"]."','N')><img src='archivos/acepta.png' class='SinBorde' alt='Conductor Validado (Desea Desvalidar)'></a>";	
					  ?></td>
					  <td ><textarea name="observacion" cols="30" readonly="readonly"><? echo $Fila["observacion"]?></textarea></td>
					</tr>
					<?		$Cont++;
				}
			
			}
			?>
        </table></td>
      <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
    </tr>
    <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>  <p>
  </td>
    </tr>
  </table>
	<? include("pie_pagina.php")?>
</form>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Msj=='E')
		echo "alert('Registro Eliminado con Exito');";
	//if ($Msj=='VAL')
		//echo "alert('Validaci�n Modificada');";
	echo "</script>";
	
function ActualizaEstadoConductor($CodConductor)	
{
	$Update="UPDATE sget_conductores set validado='N' where corr_conductor='".$CodConductor."'";
	//echo $Update."<br>";
	mysql_query($Update);
}
?>