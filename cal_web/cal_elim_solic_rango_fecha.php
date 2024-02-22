<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 67;
	include("../principal/conectar_principal.php");
	$Fecha_Hora = date("d-m-Y h:i");
	$Rut =$CookieRut;
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	if ($Opcion=="E")
	{
		if (strlen($CmbDias)==1)
			$CmbDias = "0".$CmbDias;
		if (strlen($CmbMes)==1)
			$CmbMes= "0".$CmbMes;
		if (strlen($CmbDiasT)==1)
			$CmbDiasT = "0".$CmbDiasT;
		if (strlen($CmbMesT)==1)
			$CmbMesT= "0".$CmbMesT;
		$Wsolicitud = 0;
		$Westados   = 0;
		$Wregistro  = 0;
		$Wleyes    = 0;
		$FechaIni = $CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
		$FechaFin = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
		//echo "fecha---".$FechaIni."++".$FechaFin;
		
		$CreaTB ="create table cal_web.tmp_solicitud_analisis as select distinct nro_solicitud as nro_solicitud, year(fecha_hora) as ano ";
		$CreaTB.=" from cal_web.solicitud_analisis_copy  where fecha_hora between '".$FechaIni."' and '".$FechaFin."'";
		mysqli_query($link, $CreaTB);
		echo $CreaTB;
		// comienza proceso de eliminacion 
		$Consulta="select nro_solicitud as clave, ano as ano from cal_web.tmp_solicitud_analisis ";
		$Rsp=mysqli_query($link, $Consulta);
		while ($Row = mysqli_fetch_array($Rsp))
		{
			 // de Solicitud de Analisis
			 $numero = 0;
			 $BuscaS="select count(*) as numero from cal_web.solicitud_analisis where nro_solicitud = '".$Row[clave]."' and ";
			 $BuscaS.=" year(fecha_hora) = '".$Row[ano]."'";
			 $RspB=mysqli_query($link, $BuscaS);
			 if ($RowS=mysqli_fetch_array($RspB))
			 {
			 	$BorraS="delete from cal_web.solicitud_analisis where nro_solicitud = '".$Row[clave]."' and ";
				$BorraS.=" year(fecha_hora) = '".$Row[ano]."'";
			 	 mysqli_query($link, $BorraS);
				$Wsolicitud = $Wsolicitud + $numero;
			 }
			 // estados por solicitud
			 $numero = 0;
			 $BuscaE="select count(*) as numero from cal_web.estados_por_solicitud where nro_solicitud = '".$Row[clave]."' and ";
			 $BuscaE.=" year(fecha_hora) = '".$Row[ano]."'";
			 $RspE=mysqli_query($link, $BuscaE);
			 if ($RowE=mysqli_fetch_array($RspE))
			 {
			 	$BorraE="delete from cal_web.estados_por_solicitud where nro_solicitud = '".$Row[clave]."' and ";
				$BorraE.=" year(fecha_hora) = '".$Row[ano]."'";
			 	mysqli_query($link, $BorraE);
				$Westado = $Westado + $numero;
			 }
			 // leyes por solicitud
			 $numero = 0;
			 $BuscaL="select count(*) as numero from cal_web.leyes_por_solicitud where nro_solicitud = '".$Row[clave]."' and ";
			 $BuscaL.=" year(fecha_hora) = '".$Row[ano]."'";
			 $RspL=mysqli_query($link, $BuscaL);
			 if ($RowL=mysqli_fetch_array($RspL))
			 {
			 	$BorraL="delete from cal_web.solicitud_analisis where nro_solicitud = '".$Row[clave]."' and ";
				$BorraL.=" year(fecha_hora) = '".$Row[ano]."'";
			 	mysqli_query($link, $BorraL);
				$Wleyes = $Wleyes + $numero;
			 }
			// registro de leyes
			 $numero = 0;
			 $BuscaR="select count(*) as numero from cal_web.solicitud_analisis where nro_solicitud = '".$Row[clave]."' and ";
			 $BuscaR.=" year(fecha_hora) = '".$Row[ano]."'";
			 $RspR=mysqli_query($link, $BuscaR);
			 if ($RowS=mysqli_fetch_array($RspR))
			 {
			 	$BorraR="delete from cal_web.solicitud_analisis where nro_solicitud = '".$Row[clave]."' and ";
				$BorraR.=" year(fecha_hora) = '".$Row[ano]."'";
			 	mysqli_query($link, $BorraR);
				$Wregistro = $Wregistro + $numero;
			 }
		}
		echo "Solicitudes..".$Wsolicitud."</br>";
		echo "leyes........".$Wleyes."</br>";
		echo "registro.....".$Wregistro."</br>";
		echo "estado.......".$Westado."</br>";
		//borro temporal
		$Borro="drop table cal_web.tmp_solicitud_analisis";
		mysqli_query($link, $Borro);
 }			 
				
			 		
?>
<html>
<head>
<title>Elimina solicitudes por rango de fechas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function  Eliminar()
{
	var f = document.formulario;
	if (confirm("Seguro de Eliminar Solicitudes de Fecha Seleccionada"))
		{
		 
			f.action ="cal_elim_solic_rango_fecha.php?Opcion=E";  
			f.submit();
		}

}

function Salir()
{
	var f = document.formulario;
	f.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	f.submit(); 
}

</script>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5"  >
    <tr> 
      <td valign="top"><table width="760"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="78"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                Usuario: </font></font></div></td>
            <td width="274"><strong> 
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
			</strong></td>
            <td>Fecha:</td>
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php echo $Fecha_Hora ?>
              </strong>&nbsp; <strong> 
              <?php
			if (!isset($FechaHora))
  			{
				echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i:s')."'>";
				$FechaHora=date('Y-m-d H:i:s');
 			}
  			else
  			{ 
				echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
  			}
		  ?>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td height="31">Fecha Inicio<font size="2">: </font></td>
            <td height="31"><font size="2"> 
              <select name="CmbDias" size="1" style="width:40px;">
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
              <select name="CmbMes" size="1" id="select8" style="width:90px;">
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
              <select name="CmbAno" size="1" id="select9" style="width:70px;">
                <?php
			for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
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
              </font></td>
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha 
              Termino:<strong> </strong></font></font></font></font></td>
            <td><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2"> 
              <select name="CmbDiasT" id="select" size="1" style="width:40px;">
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
              <select name="CmbMesT" size="1" id="select2" style="width:90px;">
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
              <select name="CmbAnoT" size="1" id="select3" style="width:70px;">
                <?php
			for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
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
              </font></font></font></td>
          </tr>
		  
        <table width="760" border="0" cellpadding="0" cellspacing="0" class="TablaInterior" >
          <tr><td>&nbsp;</td></tr>
		  <tr>
             <td>&nbsp;</td>
                 <td align="center"><input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" onClick="Eliminar();"></td>
                 <td align="center"><input name="BtnSalir" type="button" id="BtnSalir" value="Salir" onClick="Salir();"></td>
				 <td>&nbsp;</td>
		  </tr>
	          <tr><td>&nbsp;</td></tr>
      </table></td>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
