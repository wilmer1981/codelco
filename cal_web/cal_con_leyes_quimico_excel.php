<?php         ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename="";
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        	$filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;
$CodigoDeSistema = 1;
$CodigoDePantalla = 5;
$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '1'  ";
$Respuesta =mysqli_query($link, $Consulta);
if($Fila =mysqli_fetch_array($Respuesta))
{
	$Nivel = $Fila["nivel"];
}


	$Bloquear = $_REQUEST["Bloquear"];
	$CheckCombo = $_REQUEST["CheckCombo"];
	$CmbDias = $_REQUEST["CmbDias"];
	$CmbMes = $_REQUEST["CmbMes"];
	$CmbAno = $_REQUEST["CmbAno"];
	$CmbDiasT = $_REQUEST["CmbDiasT"];
	$CmbMesT = $_REQUEST["CmbMesT"];
	$CmbAnoT = $_REQUEST["CmbAnoT"];
	$CmbQuimico = $_REQUEST["CmbQuimico"];
	$CmbFisico = $_REQUEST["CmbFisico"];
	$TxtOpcion = $_REQUEST["TxtOpcion"];
	$Mostrar = $_REQUEST["Mostrar"];
	$LimitIni = $_REQUEST["LimitIni"];
	$LimitFin = $_REQUEST["LimitFin"];



?>
<html>
<head>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion,Bloquear,Quimico,CheckBox,Fisico)
{
	var frm=document.FrmConsultaRecepcion;
	switch (Opcion)
	{
		case "B": 
			/*alert(frm.CheckCombo.value);
			if ((frm.CheckCombo.value!=1)||(frm.CheckCombo.value!=2))
			{
				alert("Seleccione Opcion");
				
			}	
			else
			{*/
				frm.action ="cal_con_leyes_quimico.php?Bloquear="+Bloquear + "&CmbQuimico="+Quimico + "&CmbFisico="+Fisico+"&CheckCombo="+CheckBox + "&Mostrar=B";//si la busqueda es por los quimico o el jefe   
				frm.submit();
			//}
			break;	
		case "S":
			Salir();
			break;	
		case "O":
			
			frm.action ="cal_con_leyes_quimico.php?Bloquear="+Bloquear  + "&Mostrar=O"; //si mostrar es por la maquina de espectromtria  
			frm.submit();
			break;
		case "OK":
			//frm.action ="cal_con_leyes_quimico.php?Mostrar=I";//Si Busca Por Qumico anlitico o fisico   
			//frm.submit();
		break;
	}	
}
function Recarga1(Check)
{
	//alert(Check);
	var frm =document.FrmConsultaRecepcion;
	frm.action ="cal_con_leyes_quimico.php?CheckCombo="+Check +"&Bloquear=K";//Desactica el Combo Fisico  
	frm.submit();
}
function RecargaComboQuimico(Quimico,Bloquear,Check)
{
	var frm =document.FrmConsultaRecepcion;
	//frm.action ="cal_con_leyes_quimico.php?Bloquear="+Bloquear + "&CmbQuimico="+Quimico +"&Mostrar=B";//si la busqueda es por los quimico o el jefe   
	frm.action ="cal_con_leyes_quimico.php?CmbQuimico="+Quimico +"&Bloquear="+Bloquear +"&CheckCombo="+Check;//si la busqueda es por los quimico o el jefe   
	frm.submit();
}
function RecargaComboFisico(Fisico,Bloquear,Check)
{
	var frm =document.FrmConsultaRecepcion;
	//frm.action ="cal_con_leyes_quimico.php?Bloquear="+Bloquear + "&CmbQuimico="+Quimico +"&Mostrar=B";//si la busqueda es por los quimico o el jefe   
	frm.action ="cal_con_leyes_quimico.php?CmbFisico="+Fisico +"&Bloquear="+Bloquear +"&CheckCombo="+Check;//si la busqueda es por los quimico o el jefe   
	frm.submit();
}
function Recarga2(Check)
{
	//alert(Check);
	var frm =document.FrmConsultaRecepcion;
	frm.action ="cal_con_leyes_quimico.php?CheckCombo="+Check +"&Bloquear=P";//Desactiva el combo quyimijco
	frm.submit();
}
function Salir()
{
	var frm =document.FrmConsultaRecepcion;
	frm.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	frm.submit(); 
}



</script><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body>
<form name="FrmConsultaRecepcion" method="post" action="">
    <tr>
      <td width="613">
          <td width="126"><div align="left"></div></td>
  </tr>
  <tr align="center" valign="middle"><br>
    <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
    </font></font> 
    <table width="787" border="1" cellpadding="0" cellspacing="0" >
      <tr align="center"> 
        <td width="143"><strong> #SA</strong></td>
        <?php
		if ($Mostrar =='O')
		{
			echo "<td width='171'><strong>Fecha Atencion</strong></td>";
		}
		else
		{
			echo "<td width='171'><strong> Id. Muestra</strong></td>";
        }
		?>
		<td width="109"><strong> Ley</strong></td>
        <td width="50"><strong>Signo</strong></td>
        <td width="114"><strong> Valor</strong></td>
        <td width="186"><strong> Unidad</strong></td>
      </tr>
     <?php
	   	$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
		$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
		if (($Mostrar=='B')&& (($Nivel!=1)&&($Nivel!=2)&&($Nivel!=3)))	
	   	{
			$Consulta=" select t1.nro_solicitud,t1.recargo,t4.id_muestra,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
			$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
			$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
			$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad ";
			$Consulta= $Consulta." inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo= t4.recargo  and t1.fecha_hora = t4.fecha_hora and t1.rut_funcionario = t4.rut_funcionario";
			$Consulta= $Consulta." where (t4.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
			$Consulta= $Consulta." and t1.rut_quimico = '".$Rut."' and (t4.estado_actual = 5 or t4.estado_actual = 6 or t4.estado_actual = 31 or t4.estado_actual = 32)  and (not isnull(valor) or valor = '') order by t1.nro_solicitud,recargo_ordenado ";
			//echo $Consulta."<br>";
			$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
			$Respuesta=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{				
				echo "<tr>\n";
				if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
				{
					//solicitud automatica sin recargo
					$Recargo='N';
					echo "<td width='129'>".$Fila["nro_solicitud"]."</td>\n";
				}
				else
				{
					//solicitud automatica
					echo "<td width='129'>".$Fila["nro_solicitud"]."-".$Fila["recargo"]."</td>\n";
					//echo "<td width='95'>".$Fila["nro_solicitud"].'-'.$Fila["recargo"]."</td>";			
				} 
				echo "<td width='129'>".$Fila["id_muestra"]."&nbsp;</td>";
				echo "<td width='129'>".$Fila["leyes"]."&nbsp;</td>";
				if ($Fila["signo"] == 'N')
					{
						$Fila["valor"] = 'ND';
						$Fila["signo"] = "";
					}
					else
					{
						if ((is_null($Fila["signo"]))|| ($Fila["valor"] ==''))
						{
							$Fila["valor"] = "";
							$Fila["signo"] = "";
						}	
						else
						{
							if ($Fila["signo"]=='=')
							{
								$Fila["signo"]="";	
							}
							else
							{
								$Fila["signo"]=$Fila["signo"];
							}
							$Fila["valor"]=$Fila["valor"];
							$Fila["signo"]=$Fila["signo"];
						}		
					}
					echo "<td width='20'>".$Fila["signo"]."</td>";
					echo "<td width='142'>".number_format($Fila["valor"],2,",","")."</td>";	
					echo "<td width='179'>".$Fila["unidad"]."&nbsp;</td>";
					echo "</tr>";
				}
		}
		else
		{
			if (($Mostrar=='B')&& (($Nivel==1)||($Nivel==2)||($Nivel==3)))		
			{
				if (($CmbQuimico=='-1')&&($CheckCombo==1))
				{
					$Consulta=" select t1.nro_solicitud,t1.recargo,t5.id_muestra,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta." on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t5 on t1.nro_solicitud = t5.nro_solicitud and t1.recargo= t5.recargo  and t1.fecha_hora = t5.fecha_hora and t1.rut_funcionario = t5.rut_funcionario";
					$Consulta= $Consulta." where (t5.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t5.estado_actual = 5 or t5.estado_actual = 6 or t5.estado_actual = 31 or t5.estado_actual = 32) and (t5.cod_analisis ='1') and (not isnull(valor) or valor = '')order by t1.nro_solicitud,recargo_ordenado ";
					//echo "1".$Consulta."<br>";
				}
				/*if (($CmbQuimico=='-1')&&($CmbFisico=='-1')&&($CheckCombo!=1)&&($CheckCombo!=2))
				{
					$Consulta=" select  t1.nro_solicitud,t1.recargo,t4.id_muestra,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo= t4.recargo ";
					$Consulta= $Consulta." where (t1.fecha_hora between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t4.estado_actual = 5 or t4.estado_actual = 6 or t4.estado_actual = 31 or t4.estado_actual = 32) order by t1.nro_solicitud,recargo_ordenado ";
					//echo "2".$Consulta."<br>";
				}*/
				if (($CmbQuimico!='-1')&&($CheckCombo==1))
				{
					$Consulta=" select t1.nro_solicitud,t1.recargo,t4.id_muestra,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo= t4.recargo  and t1.fecha_hora = t4.fecha_hora and t1.rut_funcionario = t4.rut_funcionario";
					$Consulta= $Consulta." where (t4.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t4.estado_actual = 5 or t4.estado_actual = 6 or t4.estado_actual = 31 or t4.estado_actual = 32) and t1.rut_quimico = '".$CmbQuimico."' and (t4.cod_analisis ='1') and (not isnull(valor) or valor = '')order by t1.nro_solicitud,recargo_ordenado";
					//echo "3".$Consulta."<br>";
				}
				if (($CmbFisico=='-1')&&($CheckCombo==2))
				{
					$Consulta=" select t1.nro_solicitud,t1.recargo,t5.id_muestra,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta." on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t5 on t1.nro_solicitud = t5.nro_solicitud and t1.recargo= t5.recargo  and t1.fecha_hora = t5.fecha_hora and t1.rut_funcionario = t5.rut_funcionario";
					$Consulta= $Consulta." where (t5.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t5.estado_actual = 5 or t5.estado_actual = 6 or t5.estado_actual = 31 or t5.estado_actual = 32) and (t5.cod_analisis ='2') and (not isnull(valor) or valor = '')   order by t1.nro_solicitud,recargo_ordenado ";
					//echo "4".$Consulta."<br>";
				}
				if (($CmbFisico!='-1')&&($CheckCombo==2))//&&($CmbFisico!='-1'))
				{
					$Consulta=" select t1.nro_solicitud,t1.recargo,t4.id_muestra,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo= t4.recargo  and t1.fecha_hora = t4.fecha_hora and t1.rut_funcionario = t4.rut_funcionario ";
					$Consulta= $Consulta." where (t4.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t4.estado_actual = 5 or t4.estado_actual = 6 or t4.estado_actual = 31 or t4.estado_actual = 32) and t1.rut_quimico = '".$CmbFisico."' and (t4.cod_analisis ='2') and (not isnull(valor) or valor = '') order by t1.nro_solicitud,recargo_ordenado ";
					//echo "5".$Consulta."<br>";
				}
				//echo $Consulta."<br>";
				$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
				$Respuesta=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{			
					if ($Fila["signo"] == 'N')
					{
						$Valor = 'ND';
						$Signo = "";
					}
					else
					{
						if ((is_null($Fila["signo"]))|| ($Fila["valor"] ==''))
						{
							$Valor = "";
							$Signo = "";
						}	
						else
						{
							if ($Fila["signo"]=='=')
							{
								$Signo="";	
							}
							else
							{
								$Signo=$Fila["signo"];
							}
							$Valor=$Signo." ".number_format($Fila["valor"],3);
						}		
					}
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
					{
					//solicitud automatica sin recargo
					$Recargo='N';
					echo "<td width='129'>".$Fila["nro_solicitud"]."</td>\n";
					}
					else
					{
						//solicitud automatica
						echo "<td>".$Fila["nro_solicitud"]."-".$Fila["recargo"]."</td>\n";
					} 
					echo "<td width='129' >".$Fila["id_muestra"]."&nbsp;</td>";
					echo "<td width='129'>".$Fila["leyes"]."&nbsp;</td>";
					if ($Fila["signo"] == 'N')
					{
						$Fila["valor"] = 'ND';
						$Fila["signo"] = "";
					}
					else
					{
						if ((is_null($Fila["signo"]))|| ($Fila["valor"] ==''))
						{
							$Fila["valor"] = "";
							$Fila["signo"] = "";
						}	
						else
						{
							if ($Fila["signo"]=='=')
							{
								$Fila["signo"]="";	
							}
							else
							{
								$Fila["signo"]=$Fila["signo"];
							}
							$Fila["valor"]=$Fila["valor"];
							$Fila["signo"]=$Fila["signo"];
						}		
					}
					echo "<td width='20'>".$Fila["signo"]."</td>";
					echo "<td width='142'>".number_format($Fila["valor"],3,",","")."</td>";
					echo "<td width='179'>".$Fila["unidad"]."&nbsp;</td>";
					echo "</tr>";
				}
			}
		}	
	  if($Mostrar=='O')
	  {
	  	$Consulta="select t1.nro_solicitud,t1.recargo,t1.fecha_hora,t2.abreviatura as leyes,t3.abreviatura as unidad,t1.valor,t1.rut_funcionario,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado  ";
		$Consulta=$Consulta." from cal_web.registro_leyes t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes ";    		  
	  	$Consulta=$Consulta." inner join proyecto_modernizacion.unidades t3 on t1.cod_unidad = t3.cod_unidad ";
		$Consulta=$Consulta." where (t1.fecha_hora between '".$FechaI."' and '".$FechaT."') ";
		$Consulta= $Consulta." and t1.rut_funcionario = '".$CmbEspectrografo."'  and (not isnull(valor) or valor = '') order by t1.nro_solicitud,recargo_ordenado,t1.fecha_hora";
		$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
		$Respuesta=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";
			if ($Fila["signo"] == 'N')
			{
				$Valor = 'ND';
				$Signo = "";
			}
			else
			{
				if ((is_null($Fila["signo"]))|| ($Fila["valor"] ==''))
				{
					$Valor = "";
					$Signo = "";
				}	
				else
				{
					if ($Fila["signo"]=='=')
					{
						$Signo="";	
					}
					else
					{
						$Signo=$Fila["signo"];
					}
					$Valor=$Signo." ".number_format($Fila["valor"],3);
					//echo "valor".$Valor."<br>";
				}
			}
			if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
			{
			//solicitud automatica sin recargo o especial
			$Recargo='N';
			echo "<td width='129'>".$Fila["nro_solicitud"]."</td>\n";
			}
			else
			{
				//solicitud automatica
				echo "<td>".$Fila["nro_solicitud"]."-".$Fila["recargo"]."</td>\n";
			} 
			echo "<td width='129'>".$Fila["fecha_hora"]."&nbsp;</td>";
			echo "<td width='129'>".$Fila["leyes"]."&nbsp;</td>";
			if ($Fila["signo"] == 'N')
			{
				$Fila["valor"] = 'ND';
				$Fila["signo"] = "";
			}
			else
			{
				if ((is_null($Fila["signo"]))|| ($Fila["valor"] ==''))
				{
					$Fila["valor"] = "";
					$Fila["signo"] = "";
				}	
				else
				{
					if ($Fila["signo"]=='=')
					{
						$Fila["signo"]="";	
					}
					else
					{
						$Fila["signo"]=$Fila["signo"];
					}
					$Fila["valor"]=$Fila["valor"];
					$Fila["signo"]=$Fila["signo"];
					//$Valor=$Signo." ".number_format($Fila["valor"],2);
				}		
			}
			
			
			
		/*	if ($Fila["signo"] == 'N')
			{
				$Valor = 'ND';
				$Signo = "";
				echo "<td width='142'>".$Valor."</td>";
			}
			else
			{
				if ((is_null($Fila["signo"]))&& ($Fila["valor"] ==''))
				{
					$Valor = "";
					$Signo ="";
					echo "<td width='142'>".$Valor."</td>";
				}	
				else
				{
					//$Valor=$Fila["signo"]." ".;
					echo "<td width='20'>".$Fila["signo"]."</td>";
					echo "<td width='142'>".number_format($Fila["valor"],2,",","")."</td>";
				}
			}*/
			
			echo "<td width='20'>".$Fila["signo"]."</td>";
			echo "<td width='142'>".number_format($Fila["valor"],3,",","")."</td>";
			echo "<td width='179'>".$Fila["unidad"]."&nbsp;</td>";
			echo "</tr>";
		}
	}
	?>
    </table>
    <br></td>
    </tr>
</form>
</body>
</html>

