<? include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");

header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmProceso" method="post" action="">
  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
		<td width="4%" align="center" class="TituloTablaVerde">Fecha<br>Ingreso</td>
		<td width="4%" align="center" class="TituloTablaVerde">Hora Entrada </td>
		<td width="3%" align="center" class="TituloTablaVerde">Hora Salida </td>
		<td width="5%" align="center" class="TituloTablaVerde">Rut</td>
		<td width="10%" align="center" class="TituloTablaVerde">Nombre</td>
		<td width="10%" align="center" class="TituloTablaVerde">Cargo</td>
		<td width="16%" align="center" class="TituloTablaVerde">Empresa </td>
		<td width="16%" align="center" class="TituloTablaVerde">Ctto/OC</td>
		<td width="10%" align="center" class="TituloTablaVerde">&Aacute;rea a Visitar </td>
		<td width="9%" align="center" class="TituloTablaVerde">Visita solicitada por</td>
		<td width="5%" align="center" class="TituloTablaVerde">Telefono</td>
		 <td width="5%" align="center" class="TituloTablaVerde">Patente </td>
		<td width="6%" align="center" class="TituloTablaVerde">Fecha&nbsp;DAS. (Ini.)</td>
		<td width="6%" align="center" class="TituloTablaVerde">Fecha&nbsp;DAS. (Venc.)</td>
		<td width="12%" align="center" class="TituloTablaVerde">Motivo<br>Solicitante</td>
		<td width="12%" align="center" class="TituloTablaVerde">Observaci&oacute;n<br>Solicitante </td>
		<td width="12%" align="center" class="TituloTablaVerde">Observaci&oacute;n<br>Control Visita</td>
		<td width="12%" align="center" class="TituloTablaVerde">Autorizado Por</td>
		<td width="12%" align="center" class="TituloTablaVerde">Cargo Solicita</td>
		<!--<td width="12%" align="center" class="TituloTablaVerde">Observaci&oacute;n<br>
		Rechazo</td>-->
    </tr>
    <?		
				$ConsultaC="SELECT valor_subclase1,valor_subclase2,valor_subclase3 from proyecto_modernizacion.sub_clase where cod_clase='30024'";
				$RC=mysql_query($ConsultaC);
				$FC=mysql_fetch_array($RC);
				$AnoDAS=$FC["valor_subclase1"];
				
				$Consulta="SELECT * from sget_visitas where corr_visita<>'' ";
				if($Estado=='4')//Por Aprobar
					$Consulta.=" and estado='I'";	
				if($Estado=='3')//Rechazada.
					$Consulta.=" and estado='R'";	
				if($Estado!='3' && $Estado!='4')
				{
					if($Estado!='T' && ($Estado=='1' || $Estado=='2'))
						$Consulta.=" and estado='V'";
					if($Estado=='T')
						$Consulta.=" and estado in ('V','R','I')";	
				}		
				if($TxtRut!='')
					$Consulta.=" and rut='".$TxtRut."'";	
				if($CorrVisita!='')
					$Consulta.=" and corr_visita='".$CorrVisita."'";
				if($TxtFecha!='')
					$Consulta.=" and fecha_ingreso between '".$TxtFecha."' and '".$TxtFechaH."'";	
				if($Estado!='T')
				{	
					if($Estado=='1')//En Proceso.
						$Consulta.=" and (hora_entrada='0:00:00' or (hora_entrada<>'0:00:00' and hora_salida='0:00:00'))";	
					if($Estado=='2')//Terminada.
						$Consulta.=" and hora_entrada<>'0:00:00' and hora_salida<>'0:00:00'";	
				}
				if($TxtEmp!='')
					$Consulta.=" and empresa like '%".$TxtEmp."%'";
				if($TxtCttoOC!='')
					$Consulta.=" and contrato_orden like '%".$TxtCttoOC."%'";	
				if($TxtNom!='')
					$Consulta.=" and nombres like '%".$TxtNom."%'";	
				if($TxtPat!='')
					$Consulta.=" and apellido_paterno like '%".$TxtPat."%'";	
				if($TxtMat!='')
					$Consulta.=" and apellido_materno like '%".$TxtMat."%'";	
				$Consulta.=" order by apellido_paterno,apellido_materno,nombres";	
				$Resp = mysqli_query($link, $Consulta);
				//echo $Consulta;
				$Cont=1;
				while ($Fila=mysql_fetch_array($Resp))
				{
					if($Fila["hora_entrada"]=='')
						$Fila["hora_entrada"]='00:00:00';
					if($Fila["hora_salida"]=='')
						$Fila["hora_salida"]='00:00:00';
						
					$MuestraBlanco='N';	
					if($Fila["fecha_das"]<=date('Y-m-d'))
						$Color="bgcolor=#FF0000";
					else
					{
						if($Fila["hora_entrada"]!='00:00:00'&&$Fila["hora_salida"]!='00:00:00')
							$Color='bgcolor="#C1FF84"';
						else
						{
							if($Fila["hora_entrada"]=='00:00:00'&&$Fila["hora_salida"]=='00:00:00')
								$Color='bgcolor="#FFFFFF"';							
							list($YVis,$MVis,$DVis)=explode('-',$Fila['fecha_ingreso']);
							list($HVis,$MinVis)=explode(':',$Fila['hora_entrada']);						
							$fecha1=mktime(intval($HVis),intval($MinVis),0,intval($MVis),intval($DVis),intval($YVis));
							
							$fecha2=mktime(intval(date('H')),intval(date('m')),intval(date('s')),intval(date('m')),intval(date('d')),intval(date('Y')));
							$segundos=$fecha2-$fecha1;
							
							// Ahora pasas de segundos, a horas
							$horas=$segundos/60/60;
							
							if($Fila["hora_entrada"]!='00:00:00' && $Fila["hora_salida"]=='00:00:00')
							{
								if(intval(round($horas)) >= 12)	 					
								{
									$Color='bgcolor="#FF0000"';
									$MuestraBlanco='S';
								}
								if($MuestraBlanco=='N')
									$Color='bgcolor="#FFFFFF"';							
							}
						}	
					}	
					if($Fila["hora_entrada"]!='00:00:00'&&$Fila["hora_salida"]!='00:00:00')
						$Color='bgcolor="#C1FF84"';
					else
					{
						if($Fila["hora_entrada"]=='00:00:00'&&$Fila["hora_salida"]=='00:00:00')
							$Color='bgcolor="#FFFFFF"';		

						list($YVis,$MVis,$DVis)=explode('-',$Fila['fecha_ingreso']);
						list($HVis,$MinVis)=explode(':',$Fila['hora_entrada']);						
						$fecha1=mktime(intval($HVis),intval($MinVis),0,intval($MVis),intval($DVis),intval($YVis));
						
						$fecha2=mktime(intval(date('H')),intval(date('m')),intval(date('s')),intval(date('m')),intval(date('d')),intval(date('Y')));
						$segundos=$fecha2-$fecha1;
						
						// Ahora pasas de segundos, a horas
						$horas=$segundos/60/60;
						
						if($Fila["hora_entrada"]!='00:00:00' && $Fila["hora_salida"]=='00:00:00')
						{
						    if(intval(round($horas)) >= 12)	 					
							{
								$Color='bgcolor="#FF0000"';
								$MuestraBlanco='S';
							}
							if($MuestraBlanco=='N')
								$Color='bgcolor="#FFFFFF"';							
						}
					}	
						
					if($Fila["hora_salida"]=='00:00:00')	
						$ColorSalida="<span class='InputRojo'>".substr($Fila["hora_salida"],0,5)."</span>";
					else
						$ColorSalida=substr($Fila["hora_salida"],0,5);	
					if($Fila["hora_entrada"]=='00:00:00')	
						$ColorEnt="<span class='InputRojo'>".substr($Fila["hora_entrada"],0,5)."</span>";
					else
						$ColorEnt=substr($Fila["hora_entrada"],0,5);
					if($Fila[fecha_das]=='0000-00-00')
					{
						 //$FechaDAS="<span class='InputRojo'>Sin DAS</span>";
						 //$FechaTerminoDAS="<span class='InputRojo'>Sin DAS</span>";
						 $FechaDAS="";
						 $FechaTerminoDAS="";
					}
					else
					{
						$FechaDAS=$Fila[fecha_das];
						$FechaDASAux=explode('-',$Fila[fecha_das]);
						$FechaDASAux[0]=$FechaDASAux[0]+$AnoDAS;
						$FechaTerminoDAS=$FechaDASAux[0]."-".$FechaDASAux[1]."-".$FechaDASAux[2];
						if($FechaTerminoDAS< date('Y-m-d') || $FechaPreoExpi< date('Y-m-d'))
							$Checked='checked=checked';	
						if($FechaTerminoDAS< date('Y-m-d'))	
							$FechaTerminoDAS="<span class='InputRojo'>".$FechaTerminoDAS."</span>";
						else
							$FechaTerminoDAS=$FechaTerminoDAS;	
					}
					?>
					  <tr>
                        <td <? echo $Color;?> width="4%" align="center"><? echo $Fila["fecha_ingreso"];?>&nbsp;
						<td <? echo $Color;?> width="4%" align="center"><? echo $ColorEnt;?>&nbsp;</td>
                        <td <? echo $Color;?> width="3%" align="center"><? echo $ColorSalida;?>&nbsp;</td>
                        <td <? echo $Color;?> width="5%" align="center"><? echo $Fila["rut"];?></td>
                        <td <? echo $Color;?> width="10%" align="left"><? echo ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"]));?></td>
                        <td <? echo $Color;?> width="16%" align="left"><? echo ucwords(strtolower($Fila["cargo_visita"]));?>&nbsp;</td>
						<td <? echo $Color;?> width="16%" align="left"><? echo ucwords(strtolower($Fila["empresa"]));?>&nbsp;</td>
						<td <? echo $Color;?> width="16%" align="left"><? echo ucwords(strtolower($Fila["contrato_orden"]));?>&nbsp;</td>
                        <td <? echo $Color;?> width="10%" align="left"><? echo ucwords(strtolower($Fila["area"]));?>&nbsp;</td>
                        <td <? echo $Color;?> width="9%" align="left"><? echo ucwords(strtolower($Fila["solicitada_por"]));?>&nbsp;</td>
                        <td <? echo $Color;?> width="5%" align="left"><? echo $Fila["telefono_solicita"];?></td>
						<td <? echo $Color;?> width="5%" align="center"><? echo $Fila["patente"];?></td>
                        <td <? echo $Color;?> width="6%" align="center"><? echo $FechaDAS;?></td>
                        <td <? echo $Color;?> width="6%" align="center"><? echo $FechaTerminoDAS;?></td>
                        <td <? echo $Color;?> width="12%" align="left"><? echo $Fila["motivo"];?></td>
                        <td <? echo $Color;?> width="12%" align="left"><? echo $Fila["observacion"];?></td>
						<td <? echo $Color;?> width="12%" align="left"><? echo $Fila["observacion_control"];?></td>
						<td <? echo $Color;?> width="6%" align="left"><?
						$Consulta2="SELECT * from proyecto_modernizacion.funcionarios where rut='".$Fila["autorizado_por"]."'";
						$Resp2=mysql_query($Consulta2);
						$Fila2=mysql_fetch_assoc($Resp2);
						echo ucwords(strtolower($Fila2["apellido_paterno"]." ".$Fila2["apellido_materno"]." ".$Fila2["nombres"]));?></td>
						<td <? echo $Color;?> width="6%" align="left"><? echo ucwords(strtolower($Fila["cargo_solicita"]));?></td>
						<!--<td <? //echo $Color;?> width="12%" align="left"><? //echo $Fila["observacion_autoriza"];?></td>-->
                      </tr>
                      <? 
					  $Cont++;
				}
			?>
  </table>
</form>