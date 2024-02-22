<?php
include("../principal/conectar_principal.php");
$CookieRut=$_COOKIE["CookieRut"];
$Rut =$CookieRut;


?>


<html>
<head>
<title>Atencion de solicitudes de Muestreo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Proceso(Opcion,ValorSA,FechaAT)
{
	switch (Opcion)
	{
		case "G":
		//ValorSA =Contiene Nro Solicitud,rut_funcionario, recargo
		RecuperarMuestras(ValorSA,FechaAT);
		break;
		case "T":
		CheckearTodos();
		break; 
	} 
}
function RecuperarMuestras(ValorSA,FechaAT)
{
	var frm=document.FrmAtencion;
	var LargoForm = frm.elements.length;
	var Muestras="";
	var MuestraCheckeda=false;
	for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "checkMuestras") && (frm.elements[i].checked == true))
			{
			Muestras = Muestras + frm.elements[i].value + "~~" ;
			MuestraCheckeda = true;
			}
	}
	if (MuestraCheckeda == false)
	{
		alert("Debe Seleccionar un Tipo de Muestra");
		MuestraCheckeda = false;
		return;
	}
	
	
	frm.action="cal_atencion_solicitud_muestreo01.php?Muestras=" + Muestras + "&ValorSA=" + ValorSA + "&FechaAT="+FechaAT + "&Opcion=A";
	frm.submit();
}
function CheckearTodos()
{
	var frm=document.FrmAtencion;
	var LargoForm = frm.elements.length;
	for (i=0; i< LargoForm; i++ )
	{
	if (frm.elements[i].name == "checkMuestras") 
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
</script>



</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="FrmAtencion" method="post" action="">
  <table width="632"border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="620"><table width="620" border="0" cellpadding="3" cellspacing="0" class="ColorTabla01">
          <tr> 
            <td width="681" height="27"><div align="center"><strong><font size="4">Atender 
                solicitudes de Muestreo</font></strong></div></td>
          </tr>
        </table>
        <br>
        <table width="620" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="161">Atendiendo Solicitudes</td>
            <td width="447">
              <?php 
	 
	  $Sol=substr($Solicitudes,0,strlen($Solicitudes)-1);
	 echo $Sol;
	  ?>
             </td>
          </tr>
        </table>
        <table width="620" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="72"><div align="center"></div>
              <div align="left"> <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <input name="checkTodos" type="checkbox" onClick="JavaScript:Proceso('T');" value="checkbox">
                </font></font> Todos </div></td>
            <td width="398"><div align="center"></div></td>
            <td width="132">&nbsp;</td>
          </tr>
        </table>
        <table width="620" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <?php
			echo"<tr>";
			$cont=1;	 
			$Consulta  = "select * from sub_clase where cod_clase = '1002' and valor_subclase1 = 'atender'"; 
			$Resultado = mysqli_query($link, $Consulta);
			while ($Fila =mysqli_fetch_array($Resultado))
			{
				if($cont==4) 
					{
						echo '</tr>';
						echo '<tr>';
						$cont=1;
			    	}
     			echo "<td width='50' align='rigth'><input type='checkbox' name ='checkMuestras' value='".$Fila['cod_subclase']."'>".ucwords(strtolower($Fila['nombre_subclase']))."</td>";		
				$cont =$cont+ 1;
			}
			echo "</tr>";
			?>
        </table><br>
        <table width="620" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="287" height="42"><div align="right"> 
                <input name="BtnGrabar" type="button"  value="Grabar" onClick="Proceso('G','<?php echo $ValoresSA;?>','<?php echo $FechaA;?>')">
              </div></td>
            <td width="387">&nbsp;&nbsp; <input name="BtnSalir" type="button"  id="BtnSalir3" value="Salir" style="width:50" onClick="JavaScript:window.close();"></td>
          </tr>
        </table>
        <br>
        <table width="620" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="672"> 
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
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
