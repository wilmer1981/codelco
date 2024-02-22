<?php
  include("../principal/conectar_principal.php");
  $Fecha_Hora = date("d/m/Y");
  $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<html>
<head>
<script language="JavaScript">
function Recarga()
{
 var Frm=document.FrmBuscarSolicitud;
     Frm.action= "cal_buscar_solicitud.php";
	 Frm.submit();
}

function ValidaIngreso(Sol_Aut)
{

	var Frm=document.FrmBuscarSolicitud;
     Frm.action= "cal_buscar_solicitud.php?Buscar=S&Sol_Aut="+Sol_Aut;
	 Frm.submit();

}		
function RecuperarSeleccion(ValorProducto,ValorSubProducto,Sol_Aut)
{
	var Frm=document.FrmBuscarSolicitud;
	var Fecha = "";
	for (i=4;i<=Frm.elements.length;i++)
	{
		if (Frm.elements[i].checked == true)
		{
			Fecha=Frm.elements[i].value;
			break;
		}
	}
	if (Sol_Aut =='S')
	{
		window.opener.document.FrmSolicitudAut.action="cal_solicitud_automatica.php?FechaBusqueda=" + Fecha + "&Productos=" + ValorProducto + "&SubProducto=" + ValorSubProducto +"&Modificar=S";
		window.opener.document.FrmSolicitudAut.submit();
	}	
	else
	{
		window.opener.document.FrmSolicitud.action="cal_solicitud.php?FechaBusqueda=" + Fecha + "&Productos=" + ValorProducto + "&SubProducto=" + ValorSubProducto +"&Modificar=S";
		window.opener.document.FrmSolicitud.submit();
	}
	window.close();
	 
}
</script>
<title>Buscar Solicitudes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
</head>
<body background="../principal/imagenes/fondo3.gif">

<form action="" method="post" name="FrmBuscarSolicitud" id="FrmBuscarSolicitud">
  <table width="690" border="0" cellpadding="5" class="tablaprincipal">
    <tr> 
      <td>
<table width="690" border="1" class="TablaInterior">
          <tr> 
            <td width="86" height="30"><div align="right">Fecha:</div></td>
            <td width="576"><font size="2"> 
              <select name="CmbDias" id="select4" size="1" style="font-face:verdana;font-size:10">
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
              <select name="CmbMes" size="1" id="select7" style="FONT-FACE:verdana;FONT-SIZE:10">
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
              <select name="CmbAno" size="1" id="select8" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
	for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
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
              </font><font size="2">&nbsp; 
              <input name="BtnBuscar" type="button" id="BtnBuscar" value="Buscar" onClick="ValidaIngreso('<?php echo $Sol_Aut;?>');">
              </font></td>
          </tr>
        </table>
        <br> <table width="690" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
          <tr class="ColorTabla01"> 
            <td width="20">&nbsp;</td>
            <td width="149"><div align="center"><strong>Fecha-Hora</strong></div></td>
            <td width="142"><div align="center"><strong>Producto</strong></div></td>
            <td width="142"><div align="center"><strong>SubProducto</strong></div></td>
            <td width="204"><div align="center"><strong>Id-Muestras</strong></div></td>
          </tr>
          <?php
		if (isset($Buscar))
		{
			include ("../Principal/conectar_cal_web.php");	   
			$Fecha_I_Dia = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
			$Fecha_T_Dia = $CmbAno."-".$CmbMes."-".$CmbDias.' 23:59';
			$Consulta = "select t1.fecha_hora,t1.cod_producto,t1.cod_subproducto,";
			$Consulta = $Consulta." t2.descripcion as nombreproducto,t3.descripcion as nombresubproducto  from solicitud_analisis t1 inner join";
			$Consulta = $Consulta." proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto inner join ";
			$Consulta = $Consulta." proyecto_modernizacion.subproducto t3 on t1.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto";
			$Consulta = $Consulta." where (t1.rut_funcionario = '".$CookieRut."') and (((estado_actual is null and frx <> 'S') or (estado_actual = '1')) or (cod_tipo_muestra=1 and estado_actual ='12')) and ";
			if ($Sol_Aut=='S')
			{
				$Tipo ="A";
			}
			else
			{
				$Tipo ="R";
			}
			$Consulta = $Consulta."(t1.fecha_hora between '".$Fecha_I_Dia."' and '".$Fecha_T_Dia."') and (tipo_solicitud='".$Tipo."') group by t1.fecha_hora,t1.cod_producto,t1.cod_subproducto"; 
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>\n";
				echo "<td><input type='radio' name='OptSelect' value='".$Fila["fecha_hora"]."' onClick=RecuperarSeleccion(".$Fila["cod_producto"].",".$Fila["cod_subproducto"].",'".$Sol_Aut."');></td>\n";
				echo "<td>".$Fila["fecha_hora"]."&nbsp;</td>\n";
				echo "<td>".ucwords(strtolower($Fila["nombreproducto"]))."&nbsp;</td>\n";
				echo "<td>".ucwords(strtolower($Fila["nombresubproducto"]))."&nbsp;</td>\n";
				$Consulta = "select id_muestra,recargo,nro_solicitud from solicitud_analisis where rut_funcionario ='".$CookieRut."' and fecha_hora='".$Fila["fecha_hora"]."' and ";
				$Consulta = $Consulta." cod_producto ='".$Fila["cod_producto"]."' and cod_subproducto ='".$Fila["cod_subproducto"]."' and tipo_solicitud='".$Tipo."'"; 
				$Resultado=mysqli_query($link, $Consulta);
				$StrMuestras = "";
				while ($Fila2=mysqli_fetch_array($Resultado))
				{
					if((is_null($Fila2["recargo"])) or ($Fila2["recargo"]==''))
					{
						if((is_null($Fila2["nro_solicitud"])) or ($Fila2["nro_solicitud"]==''))
						{
							$StrMuestras= $StrMuestras.$Fila2["id_muestra"]." | ";
						}
						else
						{
							$StrMuestras= $StrMuestras.$Fila2["id_muestra"]."(SA:".$Fila2["nro_solicitud"].") | ";						
						}	
					}
					else
					{
						if((is_null($Fila2["nro_solicitud"])) or ($Fila2["nro_solicitud"]==''))
						{
							$StrMuestras= $StrMuestras.$Fila2["id_muestra"]."-".$Fila2["recargo"]." | ";					
						}
						else
						{
							$StrMuestras= $StrMuestras.$Fila2["id_muestra"]."-".$Fila2["recargo"]."(SA:".$Fila2["nro_solicitud"].") | ";											
						}	
					}	
				}
				echo "<td>".substr($StrMuestras,0,strlen($StrMuestras)-2)."&nbsp;</td>";
				echo "</tr>";
			}		
		}		
	?>
        </table></td>
    </tr>
  </table>
</form>
<br>
<br>
<br>
</body>
</html>
