<?
		include("../principal/conectar_sget_web.php");
		include("funciones/sget_funciones.php");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
 $CodigoDeSistema = 27;
 $CodigoDePantalla = 7;
 if(!isset($CmbSexo))
 	$CmbSexo="-1";
if(!isset($CmbEmpresa))
	$CmbEmpresa='-1';
?>
<html>
<head>
<title>Reporte Conductores</title>
<body>
<form name="frmconductores" action="" method="post">
  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr>
            <td align="center" class="TituloTablaVerde">Rut</td>
            <td align="center" class="TituloTablaVerde">Nombre</td>
            <td align="center" class="TituloTablaVerde">Tipo Veh�culo </td>
            <td align="center" class="TituloTablaVerde">Tipo Licencias </td>
            <td align="center" class="TituloTablaVerde">Restricci&oacute;n</td>
            <td align="center" class="TituloTablaVerde">Fecha&nbsp;Vig. Licencia  Municipal</td>
            <td align="center" class="TituloTablaVerde">Vig.&nbsp;Examenes Preoc.</td>
            <td align="center" class="TituloTablaVerde">Vig.&nbsp;Examenes psico-senso-tecnico</td>
            <td align="center" class="TituloTablaVerde">Instituci�n&nbsp;que&nbsp;realiza examen psico-senso-tecnico</td>
            <td width="11%" align="center" class="TituloTablaVerde">Fecha&nbsp;Curso Manejo&nbsp;Defensivo</td>
            <td width="11%" align="center" class="TituloTablaVerde">Fecha&nbsp;Hoja Vida Conductor</td>
            <td width="11%" align="center" class="TituloTablaVerde">N�&nbsp;Hoja de Vida Conductor</td>
            <td width="11%" align="center" class="TituloTablaVerde">Observaci�n</td>
            <td align="center" class="TituloTablaVerde">Empresa</td>
            <td align="center" class="TituloTablaVerde">N&deg; Contrato </td>
            <td align="center" class="TituloTablaVerde">Fec.&nbsp;Ini.&nbsp;Ctto.</td>
            <td align="center" class="TituloTablaVerde">Fec.&nbsp;Fin.&nbsp;Ctto.</td>
            <td align="center" class="TituloTablaVerde">Validado</td>
    </tr>
    <?
				$Consulta="SELECT *,t1.rut from sget_conductores t1 left join sget_personal t2 on t1.rut=t2.rut where t1.corr_conductor<>''";
				$Consulta.=" order by t1.apellido_paterno,t1.apellido_materno,t1.nombres";	
				$Resp = mysql_query($Consulta);
				//echo $Consulta;
				echo "<input name='CheckConduc' type='hidden'  value=''>";
				$Cont=1;
				while ($Fila=mysql_fetch_array($Resp))
				{
					?>
					<tr>
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
					?>
					&nbsp;</td>
					<td ><? echo $Fila["restriccion_licencia"]?></td>
					<td align="center" ><? echo $Fila["fecha_vig_licencia"]; ?></td>
					<td align="center" ><? echo $Fila["fecha_exa_preoc"]."&nbsp;"; ?></td>
					<td align="center"><? echo $Fila["fecha_exa_pst"]."&nbsp;"; ?></td>
					<td align="center"><? echo $Fila["institu_realiza_exam_pst"]."&nbsp;"; ?></td>
					<td align="center"><? echo $Fila["fecha_curso_manejo"]."&nbsp;"; ?></td>
					<td align="center"><? echo $Fila["fecha_hoja_vida"]."&nbsp;"; ?></td>
					<td align="center"><? echo $Fila["hoja_vida_n_docu"]."&nbsp;"; ?></td>
					<td ><? echo $Fila["observacion"]?></td>
					<td align="left"><? echo $Fila["rut_empresa"]." - ".$Fila["empresa"]."&nbsp;"; ?></td>
					<td ><? echo $Fila["contrato"]."&nbsp;"; ?></td>
					<td align="center" ><? echo $Fila["fec_ini_ctto"]."&nbsp;"; ?></td>
					<td align="center" ><? echo $Fila["fec_fin_ctto"]."&nbsp;"; ?></td>
				    <td align="center" >
				    <? 
						echo $Fila[validado];
				    ?></td>
					</td>
					</tr>
					<?		$Cont++;
				}
			?>
  </table>
</form>


</body>
</html>