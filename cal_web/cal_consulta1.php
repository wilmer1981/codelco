<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 9;
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y H:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;
$HoraActual = date("H");
$MinutoActual = date("i");

if(isset($_REQUEST["Mostrar"])) {
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar = "";
}
if(isset($_REQUEST["CmbDias"])) {
	$CmbDias = $_REQUEST["CmbDias"];
}else{
	$CmbDias =  date("d");
}
if(isset($_REQUEST["CmbMes"])) {
	$CmbMes = $_REQUEST["CmbMes"];
}else{
	$CmbMes =  date("m");
}
if(isset($_REQUEST["CmbAno"])) {
	$CmbAno = $_REQUEST["CmbAno"];
}else{
	$CmbAno =  date("Y");
}

if(isset($_REQUEST["CmbProductos"])) {
	$CmbProductos = $_REQUEST["CmbProductos"];
}else{
	$CmbProductos = "";
}
if(isset($_REQUEST["CmbSubProducto"])) {
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
}else{
	$CmbSubProducto = "";
}
?>
<html>
<head>
<title>Consulta de Certificados</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion)
{
	var frm=document.FrmGeneracion;
	switch (Opcion)
	{
		case "T":
			
			frm.action="cal_consulta1.php?Mostrar=T";
			frm.submit();
			break;
		case "R":
			frm.action="cal_consulta1.php";
			frm.submit();
			break;
		
			case "S":
			frm.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
			frm.submit(); 
			break;

			

			//Salir();
			
	}
}
function mostrar_cert(nro_solicitud,nro_certificado)
{
	var f=document.FrmGeneracion;
	f.action="cal_consulta2.php?nro_certificado="+nro_certificado+"&nro_solicitud="+nro_solicitud;
	f.submit();
}


function Salir()
{
	var frm =document.FrmGeneracion;
	frm.action="cal_adm_ingreso_leyes01.php?Opcion=S";
	frm.submit(); 
}			
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form  method="post" name="FrmGeneracion" action="" >
 <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="1" cellspacing="0" class="TablaPrincipal"  left="5">
   <input name="SA01" type="hidden" value="<?php echo $SA  ?>">
    <tr> 
      <td width="784" valign="top"> 
        <table width="700" border="0"  cellpadding="0" align="center" class="TablaInterior">
          <tr> 
            <td width="134"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
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
            </td>
           	<td width="181"><div align="right"></div></td>
            <td width="127"><div align="left"> </div></td>
		</tr>
		<tr> 
            <td align="left" colspan="5" >Fecha Consulta&nbsp;&nbsp;<font size="2">&nbsp; 
              </font> <font size="2"> 
              <select name="CmbMes">
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
              <select name="CmbAno">
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
            <td colspan="3"><font size="1"><font size="2"> </font><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2"> 
              </font> <font size="1"><font size="2"> </font></font> <font size="2"> 
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></td>
          </tr>
          <tr> 
            <td align="left" colspan="4"><font size="1"><font size="2">Producto 
              :&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;</font><font size="1"><font size="2"><strong> 
              <select name="CmbProductos" style="width:280" onChange="Proceso('R');" >
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
              </strong></font></font><font size="2"><strong>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td align="left" colspan="4"><font size="1"><font size="2">Sub Producto 
              :&nbsp;<strong> 
              <select name="CmbSubProducto" style="width:280"  onChange="Proceso('T');" >
                <option value="-1" selected>Todos</option>
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
            </td>
          </tr>
        </table>
       
      </td>
   <?php
	//<td width="301" valign="top"></td>//?>
    </tr>
    <tr> 
      <td colspan="2" valign="top"><table width="762" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr> 
            <?php 
           //<td width="89" height="28">&nbsp; </td>?>
            <td  align="center"> 
                <input name="BtnEmision" type="button" id="BtnEmision" value="Consultar" onClick="Proceso('T');">
				<input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:60" onClick="Proceso('S');">
            </td>
		</tr>
        </table>
        <br> <table width="762" border="0" cellpadding="0" class="TablaInterior" bordercolor="#b26c4a">
          <tr class="ColorTabla01"> 
           	<td width='100'><div align='center'>#CERTIFICADO</div></td>
           	<td width='150'><div align='center'>#SOLICITUD</div></td>
           	<td width='300'><div align='center'>NOMBRE GENERADOR</div></td>
           	<td width='200'><div align='center'>FECHA CERTIFICADO </div></td>
			<?php
				if (strlen($CmbDias)==1)
				{
					$CmbDias="0".$CmbDias;
				}
				if (strlen($CmbMes)==1)
				{
					$CmbMes="0".$CmbMes;
				}
				$fecha  = $CmbAno."-".$CmbMes."-01";
				$fecha1 = $CmbAno."-".$CmbMes."-31";
				/*$Mostrar='R';*/
		   		if ($Mostrar =='T')
		   		{
		   			$consulta="select * from cal_web.certificados where fecha_hora between '".$fecha."' and '".$fecha1."' order by nro_certificado";
					$respuesta =mysqli_query($link, $consulta);
					 
					while ($fila=mysqli_fetch_array($respuesta))
					{
						$nro		= $fila["nro_solicitud"];
						$cert		= $fila["nro_certificado"];
						$producto 	= $CmbProductos;
						$sub       	=$CmbSubProducto;
						if ($CmbSubProducto == -1)				
						{
							$consulta1="select * from cal_web.solicitud_analisis where  cod_producto = '".$producto."'  and nro_solicitud = '".$nro."'"; 
						}
						else
						{
							$consulta1="select * from cal_web.solicitud_analisis where  cod_producto = '".$producto."' and cod_subproducto = '".$sub."' and nro_solicitud = '".$nro."'"; 
						}																		
						$respuesta1=mysqli_query($link, $consulta1);
						$fila1=mysqli_fetch_array($respuesta1);
						if ($fila1["nro_solicitud"]== $fila["nro_solicitud"])
						{ 
							echo"<tr>";
							/*echo"<td width='250'><div align='center'><a href=\"cal_generacion_certificados_analisis.php?nro_certificado='".$fila["nro_certificado"]."','".$fila["nro_solicitud"]."')\">\n";*/
							echo"<td width='100'><div align='center'><a href=\"JavaScript:mostrar_cert('".$nro."','".$cert."')\">\n";
							echo $fila["nro_certificado"]."</a></div></td>";

							if ($fila1["nro_sa_lims"]=='') {
								echo"<td width='150'><div align='center'>".$fila1["nro_solicitud"]."</div></td>";
							}else{
								echo"<td width='150'><div align='center'>".$fila1["nro_sa_lims"]."</div></td>";
							}

 							
							$consulta2="select rut,apellido_paterno,apellido_materno,nombres from proyecto_modernizacion.funcionarios where rut ='".$fila["rut_generador"]."'";
							$respuesta2=mysqli_query($link, $consulta2);
							$fila2=mysqli_fetch_array($respuesta2);
							if ($fila["rut_generador"] == $fila2["rut"])	
							{
								$nombre=$fila2["nombres"]." ".$fila2["apellido_paterno"]." ".$fila2["apellido_materno"];
								/*echo"<td width='200'><div align='center'>$fila["rut_generador"]</div></td>";*/
								echo"<td width='300'><div align='center'>$nombre</div></td>";
							}
							echo"<td width='200'><div slign='LEFT'>".$fila["fecha_hora"]."</div></td>";
							echo"</tr>";
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
