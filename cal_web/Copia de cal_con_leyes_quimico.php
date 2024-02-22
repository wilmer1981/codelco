<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;
$CodigoDeSistema = 1;
$CodigoDePantalla = 5;
$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '1'  ";
$Respuesta =mysqli_query($link, $Consulta);
if($Fila =mysqli_fetch_array($Respuesta))
{
	$Nivel = $Fila["nivel"];
	
}
// echo $CmbEstado."<br>";
?>



<html>
<head>
<title></title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
//function Proceso(Opcion,FechaAtencion)
function Proceso(Opcion)
{
	var frm=document.FrmConsultaRecepcion;
	switch (Opcion)
	{
		case "B": 
			frm.action ="cal_con_leyes_quimico.php?Mostrar=B";  
			frm.submit();
			break;	
		
		case "S":
			Salir();
			break;	
		case "O":
			frm.action ="cal_con_leyes_quimico.php?Mostrar=O";   
			frm.submit();
			break;
	}	
}
function Salir()
{
	var frm =document.FrmConsultaRecepcion;
	frm.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	frm.submit(); 
}
function Imprimir()
{
	var frm =document.FrmConsultaRecepcion;
	window.print();
}	
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body background="../principal/imagenes/fondo3.gif">
<form name="FrmConsultaRecepcion" method="post" action="">
  
 <!-- <table width="625" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >-->
    <tr>
      <td width="613"><table width="571" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr> 
          <td width="315"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp; 
              <?php echo $Fecha_Hora ?>
              </strong>&nbsp; <strong> 
              <?php
			if (!isset($FechaHora))
  			{
				echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
				$FechaHora=date('Y-m-d H:i');
 			}
  			else
  			{ 
				echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
  			}
		  ?>
              </strong> </font></font></div></td>
          <td colspan="2"> <div align="center"></div></td>
        </tr>
        <tr> 
          <td height="38" colspan="3"> &nbsp;&nbsp; <strong> 
            <?php
		$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
	  	$Resultado= mysqli_query($link, $Consulta);
		if ($Fila =mysqli_fetch_array($Resultado))
		{	
			echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
		}	  
	  	else
			{
		  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
					}
		
			}
		  ?>
            <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            </font></font></strong></font></font> </strong> </td>
        </tr>
        <tr> 
          <td height="31">Fecha Inicio<font size="2"> &nbsp;&nbsp;&nbsp; 
            <select name="CmbDias" id="select24" size="1" style="font-face:verdana;font-size:10">
              <?php
				
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDias))
				{
					if ($i==$CmbDias)
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}
				else
				{
					if ($i==date("j"))
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}	
			  }
			?>
            </select>
            </font> <font size="2"> 
            <select name="CmbMes" size="1" id="select" style="FONT-FACE:verdana;FONT-SIZE:10">
              <?php
		  for($i=1;$i<13;$i++)
		  {
				if (isset($CmbMes))
				{
					if ($i==$CmbMes)
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				
				}	
				else
				{
					if ($i==date("n"))
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				}	
			}
		    ?>
            </select>
            </font> <font size="2"> 
            <select name="CmbAno" size="1" id="select2" style="FONT-FACE:verdana;FONT-SIZE:10">
              <?php
			for ($i=date("Y");$i<=date("Y");$i++)
			{
				if (isset($CmbAno))
				{
					if ($i==$CmbAno)
						{
							echo "<option selected value ='$i'>$i</option>";
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
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}		
			}
			?>
            </select>
            </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
          </td>
          <td colspan="2"><div align="center"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></strong></font></font></strong></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></strong></font></font></strong></font></font><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input name="BtnBuscar" type="submit" id="BtnBuscar" style="width:60"value="Buscar" onClick="Proceso('B');">
              </font></font></font></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></strong></font></font></strong></font></font><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></font></font></font></div></td>
        </tr>
        <tr> 
          <td height="30">Fecha Termino<font size="1"><font size="2"><font size="1"></font> 
            </font><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2"> 
            <select name="CmbDiasT" id="select6" size="1" style="font-face:verdana;font-size:10">
              <?php
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDiasT))
				{
					if ($i==$CmbDiasT)
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}
				else
				{
					if ($i==date("j"))
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}	
			}
			?>
            </select>
            </font> <font size="1"><font size="2"> 
            <select name="CmbMesT" size="1" id="select7" style="FONT-FACE:verdana;FONT-SIZE:10">
              <?php
		  for($i=1;$i<13;$i++)
		  {
				if (isset($CmbMesT))
				{
					if ($i==$CmbMesT)
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				
				}	
				else
				{
					if ($i==date("n"))
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				}	
		   }
		   ?>
            </select>
            </font></font> <font size="2"> 
            <select name="CmbAnoT" size="1" id="select8" style="FONT-FACE:verdana;FONT-SIZE:10">
              <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAnoT))
				{
					if ($i==$CmbAnoT)
						{
							echo "<option selected value ='$i'>$i</option>";
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
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}		
			}
			?>
            </select>
            </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font>&nbsp;&nbsp;&nbsp;&nbsp;<font size="1"><font size="2"> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></font></td>
          <td width="98"> <div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></strong> </font></font></strong> </font></font></div>
            <div align="left"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="CmbEspectrografo" style="width:90">
                <option value="-1">Seleccionar</option>
                <option value="00000000-1">EEA-Arco</option>
                <option value="00000000-2">EEA-Plasma</option>
              </select>
              </font></font></div></td>
          <td width="137"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="BtnOk" type="button" id="BtnOk" value="Ok" onClick="Proceso('O');">
            </font></font></td>
        </tr>
      </table>
       
        <br>
        <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        </font></font> <table width="571" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" >
        <tr align="center" class="ColorTabla01"> 
          <td width="129"> #SA</td>
          <td width="129"> Ley</td>
          <td width="140"> Valor</td>
          <td width="139"> Unidad</td>
        </tr>
        <?php
	   	$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
		$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
		if ($Mostrar=='B')	
	   	{
			$Consulta=" select distinct t1.nro_solicitud,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo ";
			$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
			$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
			$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad inner join cal_web.estados_por_solicitud t4 ";
			$Consulta= $Consulta."on t1.rut_funcionario = t4.rut_funcionario and t1.nro_solicitud = t4.nro_solicitud and ";
			$Consulta= $Consulta." t1.recargo = t4.recargo ";
			$Consulta= $Consulta." where (t1.fecha_hora between '".$FechaI."' and '".$FechaT."') ";
			$Consulta= $Consulta." and t1.rut_funcionario = '".$Rut."' and (t4.cod_estado = 5 or t4.cod_estado = 6) ";
			echo "$Consulta"."<br>";
			$Respuesta=mysqli_query($link, $Consulta);
			$SolicitudAnt = "";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{			
				$Consulta=" select count(cod_leyes) as total_leyes ";
				$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 ";
				$Consulta= $Consulta." where t1.fecha_hora between '".$FechaI."' and '".$FechaT."' ";
				$Consulta= $Consulta." and t1.rut_funcionario = '".$Rut."'";
				$Consulta= $Consulta." and t1.nro_solicitud = '".$Fila["nro_solicitud"]."'";
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2 = mysqli_fetch_array($Respuesta2);
				echo "<tr align='center'>";
				if ($SolicitudAnt != $Fila["nro_solicitud"])
					echo "<td width='129' rowspan=".$Fila2[total_leyes]." valign='top'>".$Fila["nro_solicitud"]."&nbsp;</td>";
				///////////////////////////////////
				if ($Fila["signo"] == 'N')
				{
					$Valor = 'ND';
				}
				else
				{
					if ((is_null($Fila["signo"]))|| ($Fila["valor"] ==''))
					{
						$Valor = "";
					}	
					else
					{
						$Valor=$Fila["valor"];
					
					}
				
				}
				//////////////////////////////////
				echo "<td width='129'>".$Fila["leyes"]."&nbsp;</td>";
				//echo "<td width='142'>".$Fila["valor"]."&nbsp;</td>";
				echo "<td width='142'>".$Valor."&nbsp;</td>";
				echo "<td width='179'>".$Fila["unidad"]."&nbsp;</td>";
				echo "</tr>";
				$SolicitudAnt = $Fila["nro_solicitud"];
			}
		}	
	  if($Mostrar=='O')
	  {
	  	$Consulta="select distinct t1.nro_solicitud,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.rut_funcionario  ";
		$Consulta=$Consulta." from cal_web.registro_leyes t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes ";    		  
	  	$Consulta=$Consulta." inner join proyecto_modernizacion.unidades t3 on t1.cod_unidad = t3.cod_unidad ";
		$Consulta=$Consulta." inner join cal_web.estados_por_solicitud t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo = t4.recargo  ";
	  	$Consulta=$Consulta." where (t1.fecha_hora between '".$FechaI."' and '".$FechaT."') ";
		$Consulta= $Consulta." and t1.rut_funcionario = '".$CmbEspectrografo."' and (t4.cod_estado = 5 or t4.cod_estado = 6) ";
	  	echo $Consulta."<br>";
	  	$Respuesta=mysqli_query($link, $Consulta);
		$SolicitudAnt = "";
		while ($Fila=mysqli_fetch_array($Respuesta))
		{			
			$Consulta=" select count(cod_leyes) as total_leyes ";
			$Consulta= $Consulta." from cal_web.registro_leyes t1 ";
			$Consulta= $Consulta." where t1.fecha_hora between '".$FechaI."' and '".$FechaT."' ";
			$Consulta= $Consulta." and t1.rut_funcionario = '".$Fila["rut_funcionario"]."'";
			$Consulta= $Consulta." and t1.nro_solicitud = '".$Fila["nro_solicitud"]."'";
			echo $Consulta."<br>";
			$Respuesta2=mysqli_query($link, $Consulta);
			$Fila2 = mysqli_fetch_array($Respuesta2);
			echo "<tr align='center'>";
			if ($SolicitudAnt != $Fila["nro_solicitud"])
			{
				echo "<td width='129' rowspan=".$Fila2[total_leyes]." valign='top'>".$Fila["nro_solicitud"]."&nbsp;</td>";
				echo "<td width='129'>".$Fila["leyes"]."&nbsp;</td>";
				echo "<td width='142'>".$Fila["valor"]."&nbsp;</td>";
				echo "<td width='179'>".$Fila["unidad"]."&nbsp;</td>";
				echo "</tr>";
				$SolicitudAnt = $Fila["nro_solicitud"];
			}
		}
	}
	?>
      </table>
        <br>
        <table width="569" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >
        <tr> 
          <td width="253"> <div align="right"> </div>
            <div align="center"> </div>
            <div align="right">
              <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" onClick='JavaScript:Imprimir();'>
            </div></td>
          <td width="301">&nbsp;&nbsp; 
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');"></td>
        </tr>
      </table></td>
    </tr>
 <!-- </table>-->

 
</form>
</body>
</html>
