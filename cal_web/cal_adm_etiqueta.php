<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 28;
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;
$HoraActual = date("H");
$MinutoActual = date("i");
?>
<html>
<head>
<title>Administracion de Etiquetas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion)
{
	var frm=document.FrmGeneracion;
	switch (Opcion)
	{
		case "R":
			frm.action="cal_adm_etiqueta.php";
			frm.submit();
			break;
		case "S":
			Salir();
			break;
		case "B":
			frm.action="cal_adm_etiqueta.php?Mostrar=S";
			frm.submit();
			break;
		case "I":
			RecuperarSA();	
			break;
		case "O":
		
			frm.action ="cal_adm_etiqueta.php?Mostrar=O";
			frm.submit();
			break;
		case "E":
			EmisionCert();
			break;
		case "D":
			frm.action ="cal_adm_etiqueta.php?Mostrar=D";
			frm.submit(); 
			break;
		case "H":
			Historial();
			break;
		case "A":
			Anular();	
			break;
	}
}
function RecuperarSA()
{
	var frm=document.FrmGeneracion;
	var LargoForm = frm.elements.length;
	var SA="";
	var CheckeoSolicitud="";
	for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "checkSA") && (frm.elements[i].checked == true))
		{
			SA = SA + frm.elements[i+1].value + "//"  ;
			CheckeoSolicitud = true;
		}
	}
	if (CheckeoSolicitud == false)
	{
		alert ("No Hay Elementos Seleccionados");
	}
	else
	{
	
	frm.action="cal_adm_etiqueta.php?SA="+ SA + "&Mostrar=I";
	frm.submit();

	}
}
//Funcion que recupera la solicitud para mostrarla en el historial
function Historial()
{
	var frm=document.FrmGeneracion;
	var LargoForm = frm.elements.length;
	var SA="";
	var cont="";
	var CheckeoSolicitud="";
	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name == "checkAtender") && (frm.elements[i].checked == true))
		cont =cont + 1;
	}
	if ((cont > 1))
	{
		alert ("Debe seleccionar solo una Solicitud");
		return;
	} 
	
	for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "checkAtender") && (frm.elements[i].checked == true))
		{
			//Recupera la solicitud de analisis 
			
			SA = SA + frm.elements[i+1].value   ;
			CheckeoSolicitud = true;
		}
	}
	if (CheckeoSolicitud == false)
	{
		alert ("No Hay Elementos Seleccionados");
	}
	else
	{
	
	window.open("cal_con_registro_leyes.php?SA="+ SA,"","top=200,left=5,width=800,height=400,scrollbars=yes,resizable = yes");					
	}
}

function Activar()
{
	var frm=document.FrmGeneracion;
	var LargoForm = frm.elements.length;
	for (i=0; i< LargoForm; i++ )

	{
	if ((frm.elements[i].name == "checkAtender") || ( frm.elements[i].name == "checkSA" ))
		{
			if ((frm.CheckTodos.checked == true) || (frm.CheckTodosA.checked == true ))
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
	var frm =document.FrmGeneracion;
	
	frm.action="../principal/sistemas_usuario.php?CodSistema=1";
	frm.submit();
	
}

function ImprimirEtiqueta(Rut)
{
	var frm=document.FrmGeneracion;
	var LargoForm = frm.elements.length;
	var CheckeoSolicitud="";
	var SA ="";
	
	CheckeoSolicitud=false;		
	for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "checkAtender") && (frm.elements[i].checked == true))
		{
			SA = SA + frm.elements[i+1].value + "~~" + frm.elements[i+2].value +"||"+frm.elements[i+3].value+"//";
			CheckeoSolicitud=true;
		}
	}
	if (CheckeoSolicitud == false)
	{
		alert ("No Hay Elementos Seleccionados");
		return;
	}
	window.open("cal_imprimir_etiqueta.php?SA="+SA,"","top=50px,left=50px,width=500px,height=400px,scrollbars=yes,resizable = yes");					

}

</script>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form  method="post" name="FrmGeneracion" action="" >
 <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal"  left="5">
  	<input name="SA01" type="hidden" value="<?php echo $SA  ?>">
    <tr> 
      <td width="427"><table width="425" border="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="157"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php echo $Fecha_Hora ?> </strong>&nbsp; <strong> 
              <?php
			//creacion de campo oculto para almacenar la fecha y hora si no existe lo crea en caso contraria le asigana la feha hora del sistema 
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
              </strong></font></font></td>
            <td width="218"><div align="right"></div></td>
            <td width="21"><div align="left"> </div></td>
          </tr>
          <tr> 
            <td colspan="3">Fecha Inicio<font size="2">&nbsp;&nbsp;&nbsp;&nbsp; 
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
              <select name="CmbMes" size="1" id="select25" style="FONT-FACE:verdana;FONT-SIZE:10">
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
              <select name="CmbAno" size="1" id="select26" style="FONT-FACE:verdana;FONT-SIZE:10">
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
              </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          </tr>
          <tr> 
            <td colspan="3"><font size="1"><font size="1"><font size="2">Fecha 
              Termino </font><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2"> 
              <select name="CmbDiasT" id="select4" size="1" style="font-face:verdana;font-size:10">
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
              <select name="CmbMesT" size="1" id="select5" style="FONT-FACE:verdana;FONT-SIZE:10">
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
              <select name="CmbAnoT" size="1" id="select6" style="FONT-FACE:verdana;FONT-SIZE:10">
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
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font><font size="2"><strong><br>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td colspan="3"><font size="1"><font size="2">Producto&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><font size="1"><font size="2"><strong>&nbsp;&nbsp; 
              <select name="CmbProductos" style="width:280" onChange="Proceso('R');">
                <option value='-1' selected>Seleccionar</option>
                <?php 
					
					$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos order by descripcion"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbProductos==$Fila["cod_producto"])
						{
							echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}
						else
						{

							echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}
					
					
					}
					echo $CmbProductos."<br>";
				?>
              </select>
              </strong></font></font><font size="2"><strong></strong></font></font></td>
          </tr>
          <tr> 
            <td colspan="3"><font size="1"><font size="2">Sub Producto&nbsp;<strong> 
              &nbsp; 
              <select name="CmbSubProducto" style="width:280"  onChange="Proceso('R');" >
                <option value="-1" selected>Seleccionar</option>
                <?php
				//Pregunta si el valor del Combo es 1 osea Productos mineros si es 1 despliega como proveedor
				if ($CmbProductos == '1')
				{
					$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."' and ((mostrar <> 16) or (mostrar <> 17)) "; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
						{
							echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						}
						else
						{
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}	
					}
				}
				else
				{
					$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."'"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
						{
							echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						}
						else
						{
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}	
					}
				}
				?>
              </select>
              </strong>&nbsp;&nbsp;&nbsp;&nbsp;</font></font></td>
          </tr>
          <tr> 
            <td colspan="3"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></font> 
              <?php
			  if ($CmbProductos =='1')
			  {
			  	echo"<font size='1'>Rut Proveedor </font>";	
				echo "<select name='CmbRutProveedor' style='width:280'>";
              	echo "<option value='-1' selected>Seleccionar</option>";
			  	//echo "<option>"echo $CmbProductos."<br>";"</option>";	
				switch (strlen($CmbSubProducto))
				{
					
					case "1":
						$Estado ="inner join proyecto_modernizacion.subproducto t2 on right(t1.tipo_producto,1) = t2.cod_subproducto and t2.cod_producto = 1" ; 
						break;
					case "2":
						$Estado ="inner join proyecto_modernizacion.subproducto t2 on right(t1.tipo_producto,2) = t2.cod_subproducto and t2.cod_producto = 1" ; 
						break;
					case "3":
						$Estado ="inner join proyecto_modernizacion.subproducto t2 on t1.tipo_producto = t2.cod_subproducto and t2.cod_producto = 1" ; 
						break;
				
				}
				$Consulta = "select t1.rut_proveedor,t1.nombre from imp_web.proveedores t1 ";
			  	$Consulta = $Consulta.$Estado;
			  	$Consulta = $Consulta." where t2.cod_subproducto = '".$CmbSubProducto."' order by t1.rut_proveedor ";			  
			  	$Respuesta=mysqli_query($link, $Consulta);			
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbRutProveedor == $Fila["rut_proveedor"])
					{
						echo "<option value = '".$Fila["rut_proveedor"]."' selected>".$Fila["rut_proveedor"]."   ".ucwords(strtolower($Fila["nombre"]))."</option>\n";				

					}
					else
					{
						echo "<option value = '".$Fila["rut_proveedor"]."'>".$Fila["rut_proveedor"]."   ".ucwords(strtolower($Fila["nombre"]))."</option>\n";
						
					}	
				}
				
			    echo "</select>";
              }
			  ?>
            </td>
          </tr>
        </table>
        <div style='position:absolute; overflow:auto; left: 488px; top: 78px; width: 250px; height: 114px; border:solid 0px'> 
          <?php
			
			echo  "<table width='200' border='0' cellpadding='3' cellspacing='0'>";
			echo "<tr>";
			echo "<td><input name='CheckTodosA' type='checkbox' id='CheckTodosA3' value='checkbox' onClick=\"Activar();\">Todos <td>";
			echo "<td ><input name='BtnBusqueda' type='button'  value='Busqueda' onClick=\"Proceso('B');\"></td>";
			echo "<td><input name='BtnIngresar' type='button'  value='Ingresar' onClick=\"Proceso('I');\"></td>";
			echo "</tr>";
			
			echo "</table>";
			//echo "</div>";
		?>
        </div>
        <div style='position:absolute; overflow:auto; left: 527px; top: 107px; width: 203px; height: 127px; border:solid 0px'> 
          <table width="170" border="1"  class="ColorTabla01" cellpadding="3" cellspacing="0" >
            <?php
					
				
					$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
					$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
					//Entra si a clickeado el boton busqueda y valor del combo es producto mineros  y realizo la busqueda por el proveedor
					if (($Mostrar == 'S' ) && ($CmbProductos == 1)) 
					{
						switch (strlen($CmbSubProducto))
						{	
							case "1":
								$Estado = " inner join proyecto_modernizacion.subproducto t2 on right(t1.tipo_producto,1) = t2.cod_subproducto  ";
							break; 	
							case "2":
								$Estado = " inner join proyecto_modernizacion.subproducto t2 on right(t1.tipo_producto,2) = t2.cod_subproducto   ";
							break;
							case "3":
								$Estado = " inner join proyecto_modernizacion.subproducto t2 on t2.cod_subproducto = t1.tipo_producto ";
							break;					
						}
						$Consulta ="select distinct t3.nro_solicitud,nombre_subclase  from imp_web.proveedores t1 ";
						$Consulta = $Consulta.$Estado ; 
						$Consulta = $Consulta." inner join cal_web.solicitud_analisis t3 on t3.cod_producto = t2.cod_producto ";
						$Consulta = $Consulta." and t3.cod_subproducto = t2.cod_subproducto ";//and t3.estado_actual = '6' "; 
						$Consulta = $Consulta." inner join proyecto_modernizacion.sub_clase t4 on t4.cod_subclase = t3.estado_actual and t4.cod_clase = '1002' "; 
						$Consulta = $Consulta." where (t2.cod_producto = ".$CmbProductos.") and (t2.cod_subproducto = ".$CmbSubProducto.") ";
						
						if ($CmbRutProveedor == -1)
						{
							$Consulta = $Consulta." and (t3.fecha_hora between '".$FechaI."' and '".$FechaT ."') and (isnull(t3.rut_proveedor)) and ((t3.estado_actual <> 4) and (t3.estado_actual <> 5) and (t3.estado_actual <> 6)) ";							
						}
						else
						{
							$RutP=substr($CmbRutProveedor,0,strlen($CmbRutProveedor)-1).'-'.substr($CmbRutProveedor,strlen($CmbRutProveedor)-1,1);
							$Consulta = $Consulta." and (t3.fecha_hora between '".$FechaI."' and '".$FechaT ."') and(t3.rut_proveedor = '".$RutP."') and ((t3.estado_actual <> 4) and (t3.estado_actual <> 5) and (t3.estado_actual <> 6))  ";
						}
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo "<tr>";
							echo "<td width='20'><input type='checkbox' name ='checkSA' value=''></td>"; 
              				echo "<td width='100'><input name='TxtSA' type='text' readonly style='width:100' maxlength='100' value =".$TxtSA = $Fila["nro_solicitud"]."><input name = 'TxtRecargo' type = 'hidden' value ='N'><input name='TxtEstadoO' type = 'hidden' value =".$TxtEstadoO = $Fila["nombre_subclase"]."></td>";
          					echo "</tr>";		
						}
					}
					//Entra si a clickeado el boton busqueda y valor del combo es distinto de producto mineros  por el producto y subproducto 
					if (($Mostrar =='S') && ($CmbProductos != 1))
					{
						$Consulta = " select  distinct t1.nro_solicitud,t1.tipo_solicitud ";
						$Consulta = $Consulta." from cal_web.solicitud_analisis t1 ";
						$Consulta = $Consulta." inner join cal_web.estados_por_solicitud t2 ";
						$Consulta = $Consulta." on (t1.estado_actual = t2.cod_estado) and  (t1.nro_solicitud = t2.nro_solicitud) "; 
						$Consulta = $Consulta." and (t1.rut_funcionario = t1.rut_funcionario) "; 
						$Consulta = $Consulta." where (t1.cod_producto = ".$CmbProductos.") and (t1.cod_subproducto = ".$CmbSubProducto.") ";
						$Consulta = $Consulta." and (t2.fecha_hora between '".$FechaI."' and '".$FechaT."') and ((t1.estado_actual <> '4') and (t1.estado_actual <> '5') and (t1.estado_actual <> '6'))  "; 					
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo "<tr>";
							echo "<td width='2'><input type='checkbox' name ='checkSA' value=''></td>"; 
							echo "<td width='100'><input name='TxtSA' type='text' readonly style='width:80' maxlength='80' value =".$TxtSA = $Fila["nro_solicitud"]."><input name = 'TxtRecargo' type = 'hidden' value ='N'><input name = 'TxtEstadoO' type = 'hidden' value =".$TxtEstadoO = $Fila["nombre_subclase"]."></td>";
							echo "</tr>";		
						}
					}				
					//Pregunta si la busqueda se hace mostrando todas las solicitudes o en forma directa
					if ($Mostrar == 'D' )
					{
						if (!isset($AnoIni2))
							$AnoIni2 = 0;
						if (!isset($NumIni))
							$NumIni = 0;
						if (!isset($AnoFin2))
							$AnoFin2 = 0;
						if (!isset($NumFin))
							$NumFin = 0;
						$SolIni = $AnoIni2."000000";
						$SolFin = $AnoFin2."000000";
						$SolIni = $SolIni + $NumIni;
						$SolFin = $SolFin + $NumFin;
						$Consulta ="select  distinct t1.nro_solicitud ";
						$Consulta = $Consulta." from cal_web.solicitud_analisis t1 ";	
						$Consulta = $Consulta."	inner join proyecto_modernizacion.subproducto t2 ";
			 			$Consulta = $Consulta."	on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
						$Consulta = $Consulta. " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_subclase = t1.estado_actual and t3.cod_clase = '1002'"; 
						//$Consulta = $Consulta. " inner join cal_web.estados_por_solicitud t4 on t1.estado_actual = t4.cod_estado " ;
						$Consulta = $Consulta. " inner join proyecto_modernizacion.productos t4 on t4.cod_producto = t1.cod_producto "; 
						$Consulta = $Consulta. " where (t1.nro_solicitud between '".$SolIni."' and '".$SolFin."' ) and ((t1.estado_actual <> '4') and (t1.estado_actual <> '5') and (t1.estado_actual <> '6')) ";
						$Consulta = $Consulta. " order by t1.nro_solicitud "; 
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo "<tr>";
							echo "<td width='2'><input type='checkbox' name ='checkSA' value=''></td>"; 
							echo "<td width='100'><input name='TxtSA' type='text' readonly style='width:80' maxlength='80' value =".$TxtSA = $Fila["nro_solicitud"]."><input name = 'TxtRecargo' type = 'hidden' value ='N'><input name = 'TxtEstadoO' type = 'hidden' value =".$TxtEstadoO = $Fila["nombre_subclase"]."></td>";
							echo "</tr>";		
						}
					 }
					
					?>
          </table>
        </div>
        <br> 
        <table width="428" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="28" height="30"><font size="1"><font size="2">#SolI</font></font></td>
            <td width="144"><font size="1"><font size="1"><font size="2"> 
              <select name="AnoIni2" style="width:60px;">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoIni2))
				{
					if ($i == $AnoIni2)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		?>
              </select>
              <input name="NumIni" type="text" id="NumIni2" value="<?php echo $NumIni; ?>" size="10" maxlength="15">
              </font></font></font> </td>
            <td width="28"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font><font size="1"><font size="1"><font size="2">#SolF&nbsp; 
              </font></font></font></td>
            <td width="144"><select name="AnoFin2" style="width:60px;">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoFin2))
				{
					if ($i == $AnoFin2)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		?>
              </select> <input name="NumFin" type="text" id="NumFin2" value="<?php echo $NumFin; ?>" size="10" maxlength="15"></td>
            <td width="34"> <div align="center"><font size="1"><font size="1"><font size="2"> 
                <input name="BtnOk2" type="button" id="BtnOk22" value="Ok" onClick="Proceso('D');">
                </font></font></font> </div>
              <div align="left"> </div>
              <div align="center"> </div></td>
          </tr>
        </table>
        <br>
      </td>
      <td width="322"><table width="325" height="182" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="316">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td colspan="2"><table width="758" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="89"><input name="CheckTodos" type="checkbox" id="CheckTodosD2" value="checkbox" onClick="Activar();">
              Todos</td>
            <td width="182"><div align="center"> 
                <input name="BtnHistorial" type="button" id="BtnHistorial" value="Ver Historial" onClick="Historial('H');">
              </div></td>
            <td width="124"> <div align="center"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                <input name="BtnImprimir2" type="button" id="BtnImprimir23" value="Etiqueta" onClick="ImprimirEtiqueta();">
                </font></font> </div></td>
            <td width="336"><input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:60" onClick="Proceso('S');"></td>
          </tr>
        </table>
        <br> 
        <table width="758" border="0" cellpadding="0" class="TablaInterior" bordercolor="#b26c4a">
          <tr class="ColorTabla01"> 
            <td width="751"><div align="center"></div></td>
            <?php
		   if ($Mostrar =='O')
		   {
		   		echo  "<td width='100'><div align='center'>#SA</div></td>";
           		echo "<td width='130'><div align='center'>ESTADO</div></td>";
           		echo "<td width='230'><div align='center'>PRODUCTO</div></td>";
           		echo "<td width='250'><div align='center'>SUBPRODUCTO</div></td>";
           }
		   if ($Mostrar =='I')
		   {		
				echo  "<td width='100'><div align='center'>#SA</div></td>";
           		echo "<td width='130'><div align='center'>ESTADO</div></td>";
           		echo "<td width='230'><div align='center'>PRODUCTO</div></td>";
           		echo "<td width='250'><div align='center'>SUBPRODUCTO</div></td>";
		   
		   }
			if ($Mostrar == 'I' )
			{
				for ($j = 0;$j <= strlen($SA); $j++)
				{
					if (substr($SA,$j,2) == "//")
					{	
						$Solicitud = substr($SA,0,$j);
						$Consulta ="select   distinct t1.nro_solicitud,t1.tipo_solicitud,t4.descripcion as DesProducto,t2.descripcion as DesSubProducto,t1.rut_funcionario,t1.recargo   from cal_web.solicitud_analisis t1";	
						$Consulta = $Consulta."	inner join proyecto_modernizacion.subproducto t2 ";
						$Consulta = $Consulta."	on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
						$Consulta = $Consulta. " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_subclase = t1.estado_actual and t3.cod_clase = '1002'"; 
						$Consulta = $Consulta. " inner join proyecto_modernizacion.productos t4 on t4.cod_producto = t1.cod_producto "; 
						$Consulta = $Consulta. " where (nro_solicitud = '".$Solicitud."') ";
						$Respuesta = mysqli_query($link, $Consulta);
						if ($Fila = mysqli_fetch_array($Respuesta))
						{
								echo "<tr>";
								echo "<td width='5' align='rigth'><input type='checkbox' name ='checkAtender' value=''></td>"; 
								echo "<td width='110'><div align='rigth'><input name='TxtSA' type='text' readonly style='width:100' maxlength='100' value =".$TxtSA = $Fila["nro_solicitud"]."><input name = 'TxtRut' type = 'hidden' value ='".$Fila["rut_funcionario"]."'>";
								if ((is_null($Fila["recargo"]))||($Fila["recargo"]==""))
								{
									echo "<input name = 'TxtRecargo' type = 'hidden' value ='N'></div></td>";
								}
								else
								{
									echo "<input name = 'TxtRecargo' type = 'hidden' value ='M'></div></td>";
								}	
								$Consulta = "select  t1.estado_actual,t2.nombre_subclase from cal_web.solicitud_analisis t1 "; 
								$Consulta = $Consulta." inner join proyecto_modernizacion.sub_clase t2 ";
								$Consulta = $Consulta." on t1.estado_actual = t2.cod_subclase and t2.cod_clase = '1002'  ";
								$Consulta = $Consulta." where nro_solicitud = '".$Solicitud."' order by t2.valor_subclase4";
								$Respuesta0 = mysqli_query($link, $Consulta);
								while ($Fila0 = mysqli_fetch_array($Respuesta0))
								{	
									//pregunta para saber cual es el ultimo estado de la solicitud 
									switch ($Fila0["estado_actual"]) 
									{
										//creadas
										case "1":
											$EstadoActual= $Fila0["estado_actual"];
											break;
										//directo a calidad
										case "12":
											$EstadoActual= $Fila0["estado_actual"];
											break;
										//recepcionado
										case "2":
											$EstadoActual= $Fila0["estado_actual"];
											break;
										//atendido en muestrera
										case "13":
											$EstadoActual= $Fila0["estado_actual"];
											break;
										//eliminado
										case "7":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//pendiente
										case "8":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//activados
										case "14":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Enviados a laboratorio
										case "3":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Recepcionados en Contro calidad
										case "4":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Atendidos por quimico
										case "5":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Anulados
										case "16":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Finalizados
										case "6":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Certificados
										case "15":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Atendidos en lab frx
										case "31":
											$EstadoActual= $Fila0["estado_actual"];
										break;
										//Finalizado en lab frx
										case "32":
											$EstadoActual= $Fila0["estado_actual"];
										break;
									}
								}
								//consulta que rescata el nombre del estado 
								$Consulta = "select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase = '1002' and cod_subclase = '".$EstadoActual."' ";
								$Respuesta9 = mysqli_query($link, $Consulta);
								$Fila9 = mysqli_fetch_array($Respuesta9);
								echo "<td width='130'><div align='rigth'><input name='TxtEstado' type='text' readonly style='width:130' maxlength='10' value ='".$Fila9["nombre_subclase"]."'></div></td>";
								echo "<td width='230'><div align='rigth'><input name='TxtProducto' type='text' readonly style='width:250' maxlength='10' value ='".$TxtProducto = $Fila["DesProducto"]."'></div></td>";				
								echo "<td width='250'><div align='rigth'><input name='TxtProducto' type='text' readonly style='width:250' maxlength='10' value ='".$TxtProducto = $Fila["DesSubProducto"]."'></div></td>";				
								echo "</tr>";
						}
					 	$SA = substr($SA,$j + 2);
						$j = 0;
					 }		
				}		
			}
			
			?>

		  </tr>
        </table></td>
    </tr>
  </table>
 <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
