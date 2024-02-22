<?php
	include("../principal/conectar_principal.php");
	$Fecha_Hora = date("Y-m-d");
	if (isset($FechaBusqueda) and ($FechaBusqueda !=""))
	{
		$FechaHora = $FechaBusqueda;
		$FechaBusqueda="";
	}
	$Consulta = "select descripcion from productos where cod_producto =".$Producto;
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$NomProducto=$Fila["descripcion"];
	$Consulta = "select descripcion from Subproducto where cod_producto =".$Producto." and cod_subproducto=".$SubProducto;
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$NomSubProducto=$Fila["descripcion"];
?>
<html>
<head>
<script language="JavaScript">

function CheckeoSolicitud()
{
//ESTA FUNCION DEVUELVE VERDADERO SI ENCUENTRA A LO MENOS UNA SOLICITUD CHECKEADA
	var Frm=document.FrmIngresoLeyes;
    for (i=0;i<Frm.elements.length;i++)
	{
		if ((Frm.elements[i].name == "CheckSA") && (Frm.elements[i].checked == true))
		{
            return(true);	
		 	break;
		}
	}

}

function RecuperarSolicitudCheckeadas()
{
	var Frm=document.FrmIngresoLeyes;
	var ValoresSA = "";
    for (i=0;i<Frm.elements.length;i++)
	{
		if ((Frm.elements[i].name == "CheckSA") && (Frm.elements[i].checked == true))
		{
			ValoresSA = ValoresSA + Frm.elements[i+3].value + "~~" + Frm.elements[i+2].value + "||" +Frm.elements[i+4].value + "//" ;					
		}
	}
	return(ValoresSA);	
}

function EncontroSAconRecargo()
{
	var Frm=document.FrmIngresoLeyes;
	var Resultado=false;
    for (i=0;i<Frm.elements.length;i++)
	{
		if ((Frm.elements[i].name == "CheckSA") && (Frm.elements[i].checked == true))
		{
			if ((Frm.elements[i+4].value != "N") && (Frm.elements[i+4].value != "0"))
			{
				Resultado=true;
				break;
			}
			
		}
	}
	return(Resultado);	
}

function ChequearTodo()
{
	var Frm=document.FrmIngresoLeyes;
	for (i=0;i<=Frm.elements.length;i++)
	{
		if (Frm.elements[i].name == "CheckSA")
		{
			if (Frm.CheckTodos.checked == true)
			{
				Frm.elements[i].checked = true;
			}
			else
			{
				Frm.elements[i].checked = false;
			}
		}
	}
}	
function Salir()
{
	var Frm=document.FrmIngresoLeyes;
	Frm.action = "cal_solicitud01.php?proceso=S";
	Frm.submit();	
}
function Mostrar(Pantalla,ValoresSA)
{
	var Frm=document.FrmIngresoLeyes;
	var ValoresSA="";
	if (CheckeoSolicitud())
	{
		switch (Pantalla)
		{
			case "L":
				if(!EncontroSAconRecargo())			
				{
					ValoresSA=RecuperarSolicitudCheckeadas();		
					window.open("cal_ingreso_valor_leyes.php?ValoresSA="+ValoresSA,"","top=200,left=200,width=440,height=300,scrollbars=yes,resizable = no");
				}
				else
				{
					alert ("Valores de Leyes solo al Recargo Nro.0 ");
				}	
				break;
			case "I":		
				if(!EncontroSAconRecargo())			
				{
					ValoresSA=RecuperarSolicitudCheckeadas();		
					window.open("cal_ingreso_valor_impureza.php","","top=200,left=200,width=440,height=300,scrollbars=yes,resizable = no");
				}	
				else
				{
					alert ("Valores de Leyes solo al Recargo Nro.0 ");
				}	
				break;
			case "H":
				if(EncontroSAconRecargo())			
				{
					ValoresSA=RecuperarSolicitudCheckeadas();		
					window.open("cal_ingreso_valor_leyesHum.php","","top=200,left=200,width=440,height=300,scrollbars=yes,resizable = no");
				}	
				else
				{
					alert ("Valores de Humedad a SA con Recargo mayor a Nro.0 ");
				}	
				break;						
		}
	}
	else
	{
		alert ("Debe Seleccionar Solicitud");
	}
		
}
</script>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngresoLeyes" method="post" action="">
  <table width="600" height="200" border="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td><div align="center"></div>
        <table width="600" border="0" cellpadding="5" class="ColorTabla01">
          <tr>
            <td><div align="center">Ingreso de Leyes</div></td>
          </tr>
        </table>
		<br>
        <table width="600" border="0" cellpadding="5" class="TablaInterior">
          <tr>
            <td>Quimico:
			<?php  
				$Consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$CookieRut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
				}
			?>						
			</td>
          </tr>
        </table>
		<br>
        <table width="600" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="72">&nbsp;</td>
            <td width="131"><div align="right">
                <input name="BtnLeyes" type="button" id="BtnLeyes" value="Valor Leyes" style="width:110" onClick="Mostrar('L','<?php echo $ValoresSA;?>');">
              </div></td>
            <td width="114"><input name="BtnImpureza" type="button" id="BtnImpureza" value="Valor Impurezas" style="width:110" onClick="Mostrar('I');"></td>
            <td width="230">
			<?php
				if ($Producto == 1)
				{
					echo "<input name='BtnLeyesHum' type='button' value='Valor Leyes Hum.' style='width:110' onClick=\"Mostrar('H');\"></td>";
				}
					
			?>
          </tr>
        </table><BR>
		<table width="600" border="0" cellpadding="3" cellspacing="0" class="ColorTabla01">
          <tr> 
            <td width="31">&nbsp;</td>
            <td width="91"><div align="center">S.A</div></td>
            <td width="152"><div align="center">Tipo Producto</div></td>
            <td width="152"><div align="center">Tipo SubProducto</div></td>
            <td width="98"><div align="center">Leyes</div></td>
          </tr>
        </table>
		<table width="600" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" >
          <?php
			for ($j = 0;$j <= strlen($ValoresSA); $j++)
			{
				if (substr($ValoresSA,$j,2) == "//")
				{
					$SARutRecargo = substr($ValoresSA,0,$j);
					for ($x=0;$x<=strlen($SARutRecargo);$x++)
					{
						if (substr($SARutRecargo,$x,2) == "~~")
						{
							$SA = substr($SARutRecargo,0,$x);			
							$RutRecargo=substr($SARutRecargo,$x+2,strlen($SARutRecargo));
							for ($y=0;$y<=strlen($RutRecargo);$y++)
							{
								if (substr($RutRecargo,$y,2) == "||")
								{
									$Rut = substr($RutRecargo,0,$y);
									$Recargo=substr($RutRecargo,$y+2,strlen($RutRecargo));
									echo "<tr>"; 
									echo "<td width='37' height='25'><input type='checkBox' name='CheckSA' value='checkbox'></td>";
									echo "<td width='96'><div align='center'>";
									if ($Recargo == 'N')
									{
										echo "<input type='text' name='TxtSA' style='width:90' disabled value=".$SA."><input type='hidden' name='TxtRut' value =".$Rut."><input type='hidden' name='SA' value =".$SA."><input type='hidden' name='Recargo' value ='N'";
									}
									else
									{
										echo "<input type='text' name='TxtSA' style='width:90' disabled value=".$SA."-".$Recargo."><input type='hidden' name='SA' value =".$SA."><input type='hidden' name='TxtRut' value =".$Rut."><input type='hidden' name='Recargo' value =".$Recargo.">";									
									}
									echo "</div></td>";
									echo "<td width='160'><div align='center'>"; 
									echo "<input type='text' name='TxtProducto' style='width:150' disabled value='".$NomProducto."'>";
									echo "</div></td>";
									echo "<td width='158'><div align='center'>";
									echo "<input type='text' name='TxtSubProducto' style='width:150' disabled value ='".$NomSubProducto."'>";
									echo "</div></td>";
									echo "<td width='107'>&nbsp;</td>";
									echo "</tr>";
								}	
							}
						}
					}	
					$ValoresSA = substr($ValoresSA,$j + 2);
					$j = 0;
				}
			}			
	?>
	</table>
	</td>
	</tr>
  </table>
  </td>
  </tr>
  </table>
</form>
</body>
</html>
