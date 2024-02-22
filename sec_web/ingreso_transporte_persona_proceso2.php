<?php 	
	include("../principal/conectar_comet_web.php");
	if(!isset($CheckRut))
		$CheckRut='N';
	$Datos=explode('//',$Valores);
	$TxtRutTrans=$Datos[0];
	switch($Proceso)
	{
		case "NP":
			$TxtRutPersona='';$TxtNombrePers='';$TxtCodCalJuri='';$TxtCodRegion='';$TxtCiudad='';$TxtDomicilio='';$TxtFono1='';$TxtFono2='';$TxtFax='';
			$TxtSWP=''; $TxtPatente='';
			break;
		case "MP":
			$Consulta = "select * from sec_web.persona where rut_persona='$rut_persona' ";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtRutPersona=$rut_persona;
			$TxtPatente=$Patente;
			$TxtNombrePers=$Fila["nombre_persona"];$TxtCodCalJuri=$Fila["cod_cal_jurid"];
			$TxtCodRegion=$Fila["cod_region_persona"];$TxtCiudad=$Fila["ciudad_persona"];
			$TxtDomicilio=$Fila["domic_persona"]; $TxtFono1=$Fila["fono1_persona"];
			$TxtFono2=$Fila["fono2_persona"]; $TxtFax=$Fila["fax_persona"];
			$TxtSWP=$Fila["sw"]; 	
			break;	
		case "IP":
			$TxtPatente=$Patente;
			$Consulta = "select * from sec_web.persona where rut_persona='$TxtRutPersona' ";
			$Respuesta=mysqli_query($link, $Consulta);
			
			if(!$Fila=mysqli_fetch_array($Respuesta)){
				$Proceso="NP";
				}
			else{
				$Proceso="MP";
				$modifi="S";
				}
			break;	
	}	
?>
<html>
<head>
<script language="javascript" src="validarut.js"></script>
<script language="JavaScript">
var Rut_Inter=0;
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtRutPersona.value=='')
	{
		alert("Debe Ingresar Rut Persona")
		Frm.TxtRutPersona.focus();
		return;
	}
	
	if (Frm.CheckRut.checked==false)
	{
		if (document.FrmProceso.TxtRutPersona.value != "")
			{
				valor= new Object(document.FrmProceso.TxtRutPersona.value);
				foco = new Object(document.FrmProceso.TxtRutPersona.focus());
				var bandera = Rut(document.FrmProceso.TxtRutPersona.value,'Rut Persona', foco, valor);
				if(bandera == false){
				return;
				}
			}
	}
	
	if (Frm.TxtNombrePers.value == "")
	{
		alert("Debe Ingresar Nombre Persona")
		Frm.TxtNombrePers.focus();
		return;
	}
	
	if (Frm.TxtPatente.value=="")
	{
		alert("Debe Ingresar Patente: utilizando boton ingresar")
		Frm.TxtPatente.focus();
		return;
	}
	
	Frm.action="ingreso_transporte_persona_proceso01.php?&Proceso="+Proceso+"&Valores="+Valores;
	Frm.submit();
}

function Eliminar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (confirm("Esta seguro de Eliminar el Subproducto"))
	{
		Frm.action="ingreso_transporte_persona_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
		Frm.submit();
	}
}


function Cancelar(Valores,Proceso)
{
	var Frm=document.FrmProceso;
	
	Frm.action="ingreso_transporte_persona_proceso2.php?Proceso="+Proceso+"&Valores="+Valores;
	Frm.submit();
}

function Buscar(Valores)
{
	window.open("ingreso_transporte_persona_popup1.php?Valores="+Valores,"","top=120,left=120,width=300,height=200,scrollbars=yes,resizable = no");		
}

function Consultar(Valores)
{
	window.open("ingreso_transporte_persona_popup.php?Valores="+Valores,"","top=120,left=120,width=550,height=350,scrollbars=yes,resizable = no");		
}
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	echo "<body onload='document.FrmProceso.TxtRutPersona.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>

<form name="FrmProceso" method="post" action="">
  <table width="565" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="617"><table width="550" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="113">Rut Transportista </td>
            <td width="408"> 
              <?php
				echo "<input type='text' name='TxtRutTrans' size='12' maxlength='10' value='$TxtRutTrans' readonly>";
  			  ?> 
          </tr>
          <tr> 
            <td>Rut Persona </td>
            <td>
			 <?php 
			  if ($Proceso=='MP')
			  {
			  ?>	
             <input name="TxtRutPersona" type="text" value='<?php echo $TxtRutPersona;?>' readonly size="12" maxlength="10">              
              <?php 
			  }
			  else
			  {
			  $Proceso=='NP';
			  ?>
			 <input name="TxtRutPersona" type="text" value='<?php echo $TxtRutPersona;?>' size="12" maxlength="10"> 
			  <?php
			  }
			  if($CheckRut=='S')
			  {
			  ?> 
			<input type='checkbox' name='CheckRut' value='N' onClick='' checked>Rut Internacional
			<?php
			}
			else
			{
			?>			
			<input type='checkbox' name='CheckRut' value='S' onClick=''>Rut Internacional
			<?php
			}
			?>
			</td>
          </tr>
          <tr> 
            <td>Nombre</td>
            <td><input name="TxtNombrePers" type="text" value='<?php echo $TxtNombrePers;?>' size="70" maxlength="60"> </td>
          </tr>
		  <tr>
            <td>Cod. Calidad Juridica </td>
            <td><input name="TxtCodCalJuri" type="text" value='<?php echo $TxtCodCalJuri;?>' size="4" maxlength="3">
            </td>
	      </tr>
		  <tr>
            <td>Codigo Region</td>
            <td><input name="TxtCodRegion" type="text" value='<?php echo $TxtCodRegion;?>' size="4" maxlength="2">
            </td>
	      </tr>
		   <tr>
            <td>Ciudad</td>
            <td><input type="text" name="TxtCiudad" size="20" maxlength="15" value="<?php echo $TxtCiudad;?>">
            </td>
	      </tr>
		   <tr>
            <td>Domicilio</td>
            <td><input type="text" name="TxtDomicilio" size="70" maxlength="60" value="<?php echo $TxtDomicilio;?>">
            </td>
	      </tr>
		   <tr>
            <td>Fono 1</td>
            <td><input type="text" name="TxtFono1" size="12" maxlength="10" value="<?php echo $TxtFono1;?>">
            </td>
	      </tr>
		   <tr>
            <td>Fono 2 </td>
            <td><input type="text" name="TxtFono2" size="12" maxlength="10" value="<?php echo $TxtFono2;?>">
            </td>
	      </tr>
		   <tr>
            <td>Fax</td>
            <td><input type="text" name="TxtFax" size="12" maxlength="10" value="<?php echo $TxtFax;?>">
            </td>
	      </tr>
		   <tr>
            <td>SW</td>
            <td><input type="text" name="TxtSWP" size="2" maxlength="1" value="<?php echo $TxtSWP;?>">
            </td>
	      </tr>
		  <tr>
            <td>Patente Asociada </td>
            <td>
			<input type="text" name="TxtPatente" size="12" maxlength="10" readonly value="<?php echo $TxtPatente;?>">
            <input type="button" name="Buscar_Pat" value="Ingresar Patente" onClick="Buscar('<?php echo $Valores;?>')"> 
			</td>
	      </tr>
		  </table>
    <br>
		  <br>
        <table width="551" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="534">
			  <?php 
			  if ($Proceso=='MP')
			  {
			  ?>	
              <input type="button" name="BtnGrabar2" value="Modificar" style="width:70" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">              
              <?php 
			  }
			  else
			  {
			  $Proceso=='NP';
			  ?>
			  <input type="button" name="BtnGrabar" value="Grabar" style="width:70" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">
			  <?php
			  }
			  ?>
              <input type="button" name="BtnConsultar" value="Consultar" style="width:70" onClick="Consultar('<?php echo $Valores;?>')">
			  <input type="button" name="BtnEliminar" value="Eliminar" style="width:70" onClick="Eliminar('EP','<?php echo $Valores;?>')">
              <input type="button" name="BtnCancelar" value="Cancelar" style="width:70" onClick="Cancelar('<?php echo $Valores;?>','NP')">		    
              <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();">            </td>
          </tr>
        </table> </td>
  </tr>
</table>
</form>
</body> 
</html>
<?php
  echo "<script languaje='javascript'>";
	if (isset($EncontroCoincidencia))
	{
		if ($EncontroCoincidencia==true)
		{
			echo "var Frm=document.FrmProceso;";
			echo "alert('Codigo ya fue Ingresado');";
			echo "Frm.TxtCodigo.focus();";
			
		}
	}
	
	if ($modifi=="S")
	{
		echo "alert('Ud. procederá a Modificar ya que la persona existe, si desea ingresar presione Cancelar y cambie Rut o Patente');";
 	} 
   echo "</script>";
?>
