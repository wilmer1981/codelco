<?php
	include("../principal/conectar_principal.php");
	$Fecha_Hora = date("Y-m-d");
	if (isset($FechaBusqueda) and ($FechaBusqueda !=""))
	{
		$FechaHora = $FechaBusqueda;
		$FechaBusqueda="";
	}
?>
<html>
<head>
<script language="JavaScript">

function CheckeoSolicitud()
{
//ESTA FUNCION DEVUELVE VERDADERO SI ENCUENTRA A LO MENOS UNA SOLICITUD CHECKEADA
	var Frm=document.FrmIngEspec;
    for (i=13;i<=Frm.elements.length - 12;i++)
	{
		if ((Frm.elements[i].name == "CheckSA") && (Frm.elements[i].checked == true))
		{
            return(true);	
		 	break;
		}
	}
}

function Proceso(Opcion)
{
	var frm=document.FrmIngEspec;
	switch (Opcion)
	{
		case "B": 
			frm.action ="cal_adm_solicitud_muestreo.php";  
			frm.submit();
			break;	
		case "A":
			RecuperarSA(FechaAtencion);
			break;
		
		case "S":
			Salir();
			break;	
	
		case "E":
			CambiarEstado();
			break; 
	}	

}
function Activar()
{
	
	var frm=document.FrmIngEspec;
	var LargoForm = frm.elements.length;
	for (i=0; i< LargoForm; i++ )

	{
	if (frm.elements[i].name == "checkAtender") 
		{
			if (frm.checkTodos.checked == true)
			{
			frm.elements[i].checked = true;
			}
			else 
			{
			frm.elements[i].checked = false;		
			}
		}
	}
}
function Salir()
{
	var frm =document.FrmIngEspec;
	frm.action="cal_atencion_solicitud_muestreo01?Opcion=S";
	frm.submit(); 
}
</script>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngEspec" method="post" action="">
  <table width="600" height="200" border="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td><div align="center"></div>
        <table width="768" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
        <tr>
          <td width="754"><table width="747" border="0" cellpadding="5" class="ColorTabla01">
              <tr> 
                <td width="733"><div align="center">Ingreso de Leyes de Espectrometria</div></td>
              </tr>
            </table>
            <br> <table width="749" border="0" cellpadding="5" class="TablaInterior">
              <tr> 
                <td width="732">Quimico: 
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
            <br> <table width="751" border="0" cellpadding="5" class="TablaInterior">
              <tr> 
                <td width="99">Nombre Archivo</td>
                <td width="153"> <select name="select" style="width:130"  >
                  </select></td>
                <td width="458"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <input name="BtnBuscar" type="submit" style="width:70" id="BtnBuscar" value="Buscar" onClick="Proceso('B');">
                  </font></font></font></font></font></font></strong></font></font></font></font></font></strong></font></font></font></strong></font></font></font></font></font></strong></font></font></font></font></font></strong></font></font></font></strong></font></font></font></font></font></strong></font></font></font></font></font></strong></font></font></font></strong></font></font></font></font></font></strong></font></font></font></font></font></strong></font></font></font></strong></font></font></font></font></font></strong></td>
              </tr>
            </table>
            <br> <table width="752" border="0" cellpadding="5" class="TablaInterior">
              <tr> 
                <td width="72"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <input name="checkTodos" type="checkbox" onClick="JavaScript:Activar();" value="checkbox">
                  </font><font size="2">Todos</font></font></td>
                <td width="203"><div align="right"> 
                    <input name="BtnEliminar" type="button" id="BtnEliminar2" value="Eliminar" style="width:110">
                  </div></td>
                <td width="204"><input name="BtnCargar" type="button" id="BtnCargar2" value="Cargar" style="width:110"></td>
                <td width="220">&nbsp;</td>
              </tr>
            </table>
            <br>
            <table width="752" border="0" cellpadding="5" class="ColorTabla01">
              <tr> 
                <td width="32">&nbsp;</td>
                <td width="93"><div align="center">S.A</div></td>
                <td width="155"><div align="center">Tipo Producto</div></td>
                <td width="224"><div align="center">Leyes</div></td>
                <td width="186"><div align="center">Impurezas</div></td>
              </tr>
            </table>
            <br> <table width="754" border="0" cellpadding="5" class="TablaInterior">
              <tr> 
                <td width="364"><div align="right"> 
                    <input name="BtnOk" type="submit" id="BtnOk" value="Ok" style="width:60">
                  </div></td>
                <td width="361"><input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:60" onClick="Proceso('S');"></td>
              </tr>
            </table></td>
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
									echo "<td width='37' height='25'><input type='checkbox' name='checkSA' value='checkbox'></td>";
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
									echo "<input type='text' name='TxtProducto' style='width:150' disabled value=".$Producto.">";
									echo "</div></td>";
									echo "<td width='158'><div align='center'>";
									echo "<input type='text' name='TxtSubProducto' style='width:150' disabled value =".$SubProducto.">";
									echo "</div></td>";
									echo "<td width='107'>&nbsp;</td>";
									echo "</tr>";
									echo "</table>";
									echo "<br>";
									echo "</td>";
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
</form>
</body>
</html>
