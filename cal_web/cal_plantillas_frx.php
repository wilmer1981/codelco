<?php
include("../principal/conectar_principal.php");
$CookieRut = $_COOKIE["CookieRut"];	
$Rut =$CookieRut;

$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:'';
$Modificando = isset($_REQUEST["Modificando"])?$_REQUEST["Modificando"]:'';
$CmbProductos = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:'';
$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:'';
$Productos = isset($_REQUEST["Productos"])?$_REQUEST["Productos"]:'';
$TxtProducto = isset($_REQUEST["TxtProducto"])?$_REQUEST["TxtProducto"]:'';
$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:'';
$TxtSubProducto = isset($_REQUEST["TxtSubProducto"])?$_REQUEST["TxtSubProducto"]:'';
$Personalizar = isset($_REQUEST["Personalizar"])?$_REQUEST["Personalizar"]:'';
$NombrePlantilla = isset($_REQUEST["NombrePlantilla"])?$_REQUEST["NombrePlantilla"]:'';
$CodPlantilla = isset($_REQUEST["CodPlantilla"])?$_REQUEST["CodPlantilla"]:'';
$SolAut = isset($_REQUEST["SolAut"])?$_REQUEST["SolAut"]:'';
$SolEsp = isset($_REQUEST["SolEsp"])?$_REQUEST["SolEsp"]:'';
$BuscarDetalle = isset($_REQUEST["BuscarDetalle"])?$_REQUEST["BuscarDetalle"]:'';
$BuscarPrv = isset($_REQUEST["BuscarPrv"])?$_REQUEST["BuscarPrv"]:'';
$CmbRutPrv = isset($_REQUEST["CmbRutPrv"])?$_REQUEST["CmbRutPrv"]:'';
$TxtLotes = isset($_REQUEST["TxtLotes"])?$_REQUEST["TxtLotes"]:'';
$Lotes = isset($_REQUEST["Lotes"])?$_REQUEST["Lotes"]:'';
$TxtCCosto = isset($_REQUEST["TxtCCosto"])?$_REQUEST["TxtCCosto"]:'';
$CCosto = isset($_REQUEST["CCosto"])?$_REQUEST["CCosto"]:'';
$BtnMuestras = isset($_REQUEST["BtnMuestras"])?$_REQUEST["BtnMuestras"]:'';
$TxtSA = isset($_REQUEST["TxtSA"])?$_REQUEST["TxtSA"]:'';
$SA = isset($_REQUEST["SA"])?$_REQUEST["SA"]:'';
$TxtPlantillas = isset($_REQUEST["TxtPlantillas"])?$_REQUEST["TxtPlantillas"]:'';
?>
<html>
<head>
<title>Seleccionar Plantillas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function Recarga(Opcion,BuscarDetalle,BuscarPrv,CmbRutPrv,Modificando)
{
 	var frm=document.FrmPlantillas;
 	switch(Opcion)  
 	{	
		case"A"://AUTOMATICA O RUTINARIA 
			frm.action= "cal_plantillas_frx.php?SolAut=S&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&CmbRutPrv="+CmbRutPrv+"&Modificando="+Modificando;
			frm.submit();
			break;
		case "E"://ESPECIAL
			frm.action= "cal_plantillas_frx.php?SolEsp=S&Modificando="+Modificando;
			frm.submit();
			break;
		case "R"://SI ES MODIFICADA POR ADM. MUESTREO
			if (frm.BtnOk.value == "Ok")
			{
				frm.action= "cal_plantillas_frx.php";
			}
			else
			{
				frm.action= "cal_plantillas_frx.php?Modificando="+Modificando;
			}
			frm.submit();
			break;
	}
}

function Recuperar(Valor,valor2,BuscarDetalle,BuscarPrv,CmbRutPrv,Modificando)
{
	var frm=document.FrmPlantillas;
	var LargoForm = frm.elements.length;
	var Plantilla="";
	var RutPlant ="";
	var CheckeoPlantillas="";
	for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "radioP") && (frm.elements[i].checked == true))
		{
			Plantilla =frm.elements[i+2].value; 
			RutPlant =frm.elements[i+3].value; 
			CheckeoPlantillas = true;
		}
	}
	if (CheckeoPlantillas == false)
	{
		alert ("No Hay Plantillas Seleccionadas");
	}
	else
	{
		switch (Valor)
		{
			case "A"://SI ES AUTOMATICA O RUTINARIA	
				frm.action ="cal_plantillas_frx01.php?Plantilla=" +Plantilla + "&SolAut=S&Rut="+RutPlant+"&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&CmbRutPrv="+CmbRutPrv+"&Modificando="+Modificando;
				frm.submit();
				break;	
			case "E"://SI ES ESPECIAL
				frm.action ="cal_plantillas_frx01.php?Plantilla=" +Plantilla + "&SolEsp=S&Rut="+RutPlant+"&Modificando="+Modificando;
				frm.submit();
				break;
			default://SI ES MODIFICADA DE ADM. DE MUESTREO
				window.opener.document.FrmModifica.action="cal_modificacion_leyes.php?Plantilla="+ Plantilla+"&SolA="+ frm.TxtSA.value + "&CentroCosto="+ frm.TxtCCosto.value + "&RutPlant="+RutPlant;
				window.opener.document.FrmModifica.submit();
				window.close();
				break;			
		}
	}
}
</script>



</head>

<body leftmargin="0" topmargin="0"  >
<form name="FrmPlantillas" method="post" action="">
  <?php
if ($TxtProducto!="")
{
	echo "<input type='hidden' name ='TxtProducto' value='$TxtProducto'>";
}
else
{
	echo "<input type='hidden' name ='TxtProducto' value='$Productos'>";
}

if ($TxtSubProducto!="")
{
	echo "<input type='hidden' name ='TxtSubProducto' value='$TxtSubProducto'>";
}
else
{
	echo "<input type='hidden' name ='TxtSubProducto' value='$SubProducto'>";
}
  
if ($Modificando!="")
{
	echo "<input name='Modificando' type='hidden' value='".$Modificando."'>";
}
if ($CmbProductos!="")
{
	echo "<input name='CmbProductos' type='hidden' value='".$CmbProductos."'>";
}
if ($CmbSubProducto!="")
{
	echo "<input name='$CmbSubProducto' type='hidden' value='".$CmbSubProducto."'>";
}
  
if($BtnMuestras=="")
{ 
 	echo "<input name='BtnMuestras' type='hidden' value='".$Valores."'>";
	$BtnMuestras=$Valores;
}
else
{
	echo "<input name='BtnMuestras' type='hidden' value='".$BtnMuestras."'>";
}
if($TxtLotes=="")
{ 
 	echo "<input name='TxtLotes' type='hidden' value='".$Lotes."'>";
	$TxtLotes=$Lotes;
}
else
{
	echo "<input name='TxtLotes' type='hidden' value='".$TxtLotes."'>";
}
if($TxtCCosto=="")
{ 
 	echo "<input name='TxtCCosto' type='hidden' value='".$CCosto."'>";
	$TxtCCosto=$CCosto;
}
else
{
	echo "<input name='TxtCCosto' type='hidden' value='".$TxtCCosto."'>";
}
if($TxtSA=="")
{ 
 	echo "<input name='TxtSA' type='hidden' value='".$SA."'>";
	$TxtSA=$SA;
}
else
{
	echo "<input name='TxtSA' type='hidden' value='".$TxtSA."'>";
}

?>
  <table width="609" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
      <td width="591"><table width="600"  border="0" cellpadding="3" cellspacing="0" class="ColorTabla01">
          <tr> 
            <td><div align="center"><strong>Seleccionar Plantillas</strong></div></td>
          </tr>
        </table>
        <br>
        <table width="600"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="3"><strong>Buscar</strong></td>
          </tr>
          <tr> 
            <td width="156">Tipo Producto</td>
            <td width="338"><strong> 
            <?php
				if (isset($SolAut))//S.A AUTOMATICA O RUTINARIA
				{
					echo "<select name='CmbProductos' style='width:280' onChange=\"Recarga('A','$BuscarDetalle','$BuscarPrv','$CmbRutPrv','$Modificando');\">";
				}
				else
				{
					if (isset($SolEsp))//S.A ESPECIAL
					{
						echo "<select name='CmbProductos' style='width:280' onChange=\"Recarga('E','','','','$Modificando');\">";
					}
					else
					{
						echo "<select name='CmbProductos' style='width:280' onChange=\"Recarga('R','','','','$Modificando');\">";
					}
				}	
            	echo "<option value='-1' selected>Seleccionar</option>";
				$Consulta="select cod_producto,descripcion from productos order by descripcion"; 
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
              	echo "</select>";
			 ?> 
              </strong></td>
            <td width="84" rowspan="2"><div align="center"> 
                <?php
					if ($SolAut!="")//S.A AUTOMATICA O RUTINARIA
					{
						echo "<input name='BtnBuscar' type='button' value='Buscar' onClick=\"Recarga('A','$BuscarDetalle','$BuscarPrv','$CmbRutPrv','$Modificando');\">";
					}
					else
					{
						if ($SolEsp!="")//S.A ESPECIAL
						{
							echo "<input name='BtnBuscar' type='button' value='Buscar' onClick=\"Recarga('E','','','','$Modificando');\">";
						}
						else
						{
							echo "<input name='BtnBuscar' type='button' value='Buscar' onClick=\"Recarga('R','','','','$Modificando');\">";
						}					
					} 	
				?>	
              </div></td>
          </tr>
          <tr> 
            <td>Tipo SubProducto</td>
            <td><strong> 
				<?php
	    	        echo "<select name='CmbSubProducto' style='width:280'>";
    	            echo "<option value='-1' selected>Seleccionar</option>";
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
					echo "</select>"
				?>
              </strong></td>
          </tr>
          <tr> 
            <td>Nombre Funcionario</td>
            <td colspan="2"><strong> </strong> <strong> 
              <?php
			$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
	  		$Resultado= mysqli_query($link, $Consulta);
			if ($Fila =mysqli_fetch_array($Resultado))
			{	
				echo "<input name='TxtNombre' type='text' style='width:280' maxlength='200' readonly value= '".$TxtNombre = $Fila["nombres"]." ".$Fila["apellido_paterno"]." ".$Fila["apellido_materno"]."'>";
				//echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));   
	  		}
	  		else
			{
		  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					//echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
					echo "<input name='TxtNombre' type='text' style='width:280' maxlength='200' readonly value='".$TxtNombre = $Fila["nombres"]." ".$Fila["apellido_paterno"]." ".$Fila["apellido_materno"]."'>";				
				}
		
			}
		  ?>
              </strong> <strong> </strong></td>
          </tr>
        </table>
        <br>
        <table width="600"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td height="23" colspan="3"><strong>Plantillas Seleccionadas</strong></td>
          </tr>
          <?php
	//include ("../Principal/conectar_cal_web.php");
	//if ($Mostrar =='s')
	//{
		//consulta que busca al funcionario si este ha creado a una plantilla 
		$Consulta ="select distinct t1.rut_funcionario,t1.cod_plantilla,t1.nombre_plantilla ";
		$Consulta = $Consulta."from cal_web.plantillas t1 inner join cal_web.leyes_por_plantillas t2 on t1.rut_funcionario = t2.rut_funcionario and t1.cod_plantilla = t2.cod_plantilla ";
		$Consulta = $Consulta."where ((t1.rut_funcionario = '".$Rut."' and t1.tipo_plantilla ='P') or (t1.rut_funcionario='0' and t1.tipo_plantilla ='G')) and  (cod_producto = '".$CmbProductos."' and cod_subproducto = '".$CmbSubProducto."')";  
		$Respuesta =mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{		
			echo "<tr>"; 
			echo "<td width='29'><input type='radio' name='radioP' value='radiobutton'></td>";
			echo "<td width='150'><input name='TxtNombreP' type='text'  style='width:150' maxlength='200' readonly value = '".$TxtNombreP = $Fila["nombre_plantilla"]."'><input type = 'hidden' value =".$Fila["cod_plantilla"]."><input type = 'hidden' value =".$Fila["rut_funcionario"]."></td>";
			//consulta que busca las leyes asociadas al funcionario que este ha generado en las plantillas 
			$Consulta ="select t2.abreviatura ";
			$Consulta = $Consulta."from cal_web.leyes_por_plantillas t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes ";
			$Consulta = $Consulta."where (t1.rut_funcionario = '".$Fila["rut_funcionario"]."' and t1.cod_plantilla ='".$Fila["cod_plantilla"]."')";  
			$Respuesta2=mysqli_query($link, $Consulta);
			$Plantillas="";
			while ($Fila2=mysqli_fetch_array($Respuesta2))
			{
				$Plantillas = $Plantillas.$Fila2["abreviatura"].'-';  		
			}		
			echo "<td width='399'><input name='TxtPlantillas' type='text'  style='width:399' readonly value = '".$TxtPlantillas = $Plantillas."'></td>";
			echo "</tr>";
		}	
	//}
	?>
        </table>
        <br>
        <table width="600"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td> <div align="center"><strong> 
            <?php
				if (!isset($SolAut))//solicitud automatica
				{
				  if (isset($SolEsp))//solicitud rutinarias
				  {
				  	echo "<input name='BtnOk' type='button' value='Ok' style='width:70' onClick=\"Recuperar('E');\">";
				  }
				  else
				  {
				  	echo "<input name='BtnOk' type='button' value='Ok' style='width:70' onClick=\"Recuperar('N');\">";
				  }		
				}
				else 
				{
					echo "<input name='BtnOk' type='button' value='Grabar' style='width:70' onClick=\"Recuperar('A','$Valores','$BuscarDetalle','$BuscarPrv','$CmbRutPrv','$Modificando');\">";
				}	
			?>
                &nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70" onClick="JavaScript:window.close();">
                </strong> </div>
              <div align="center"> </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>
