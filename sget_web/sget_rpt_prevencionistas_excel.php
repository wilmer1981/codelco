<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
//if(!isset($Cons))
//	$Cons='S';
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
?>
<form name="FrmPrincipal" method="post" action="" >
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
      <td width="13%" align="center" class="TituloTablaVerde">T&iacute;tulo<br />
        Profesional</td>
	  <td width="13%" align="center" class="TituloTablaVerde">Observaci�n</td>
      <td width="21%" align="center" class="TituloTablaVerde">Empresa</td>
      <td width="13%" align="center" class="TituloTablaVerde">D&iacute;as&nbsp;y&nbsp;Horas Asesor&iacute;a</td>
      <td width="25%" align="center" class="TituloTablaVerde">N&deg; Contrato</td>
      <td width="25%" align="center" class="TituloTablaVerde">Nombre&nbsp;Contrato</td>
      <td width="10%" align="center" class="TituloTablaVerde">Fecha&nbsp;Inicio</td>
      <td width="10%" align="center" class="TituloTablaVerde">Fecha&nbsp;T&eacute;rmino</td>
    </tr>
    <?
		$Buscar='S';
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
      <td align="left" rowspan="<? echo $CantEmp;?>"><? echo $Filas["celular"]; ?>&nbsp;</td>
      <td align="left" rowspan="<? echo $CantEmp;?>"><? echo $Filas[email_1]; ?>&nbsp;</td>
      <td align="left" rowspan="<? echo $CantEmp;?>"><? echo $Filas[email_2]; ?>&nbsp;</td>
      <td align="left" rowspan="<? echo $CantEmp;?>"><? echo ucwords(strtolower($TxtSerga)); ?>&nbsp;</td>
      <td align="left" rowspan="<? echo $CantEmp;?>"><? echo ucwords(strtolower($TxtSNS)); ?>&nbsp;</td>
      <td align="left" rowspan="<? echo $CantEmp;?>"><? echo $Filas[titulo]; ?>&nbsp;</td>
	<td width="13%" rowspan="<? echo $CantEmp;?>"><? echo $Filas["observacion"]; ?>&nbsp;</td>
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
    <tr>
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
  </table>
</form>