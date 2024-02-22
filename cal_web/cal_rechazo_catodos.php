<?php
$CodigoDeSistema = 1;
$CodigoDePantalla = 55;
//include("../principal/conectar_cal_web.php");
include("../principal/conectar_sea_web.php");

$CookieRut= $_COOKIE["CookieRut"];

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso =  "";
}
if(isset($_REQUEST["dia"])) {
	$dia = $_REQUEST["dia"];
}else{
	$dia =  date("d");
}
if(isset($_REQUEST["mes"])) {
	$mes = $_REQUEST["mes"];
}else{
	$mes =  date("m");
}
if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano =  date("Y");
}
if(isset($_REQUEST["cmbturno"])) {
	$cmbturno = $_REQUEST["cmbturno"];
}else{
	$cmbturno =  "";
}
if(isset($_REQUEST["cmbgrupo"])) {
	$cmbgrupo = $_REQUEST["cmbgrupo"];
}else{
	$cmbgrupo =  "";
}
if(isset($_REQUEST["cmblado"])) {
	$cmblado = $_REQUEST["cmblado"];
}else{
	$cmblado =  "";
}
if(isset($_REQUEST["cmbcuba"])) {
	$cmbcuba = $_REQUEST["cmbcuba"];
}else{
	$cmbcuba =  "";
}
if(isset($_REQUEST["encargado"])) {
	$encargado = $_REQUEST["encargado"];
}else{
	$encargado =  "";
}
if(isset($_REQUEST["inspector"])) {
	$inspector = $_REQUEST["inspector"];
}else{
	$inspector =  "";
}
if(isset($_REQUEST["observacion"])) {
	$observacion = $_REQUEST["observacion"];
}else{
	$observacion =  "";
}


if(isset($_REQUEST["Fecha"])) {
	$Fecha = $_REQUEST["Fecha"];
}else{
	$Fecha =  "";
}
if(isset($_REQUEST["turno"])) {
	$turno = $_REQUEST["turno"];
}else{
	$turno =  "";
}
if(isset($_REQUEST["grupo"])) {
	$grupo = $_REQUEST["grupo"];
}else{
	$grupo =  "";
}
if(isset($_REQUEST["cuba_aux"])) {
	$cuba_aux = $_REQUEST["cuba_aux"];
}else{
	$cuba_aux =  "";
}


$Consulta = "select * from proyecto_modernizacion.funcionarios  where rut='".$CookieRut."'";
$Resp=mysqli_query($link, $Consulta);
while($Fila=mysqli_fetch_array($Resp))
{
		$NombreUser =  strtoupper(substr($Fila["nombres"],0,1)).".".strtoupper($Fila["apellido_paterno"])." ".strtoupper(substr($Fila["apellido_materno"],0,1));
}

if($Proceso == "M")
{
	$cuba = $cuba_aux;
	$Consulta = "SELECT * FROM cal_web.rechazo_catodos WHERE fecha = '".$Fecha."' AND turno = '".$turno."' AND grupo = '".$grupo."' AND cuba = '".$cuba."'";
	$rs = mysqli_query($link, $Consulta);
	if($row = mysqli_fetch_array($rs))
	{	
		$Consulta1 = "select * from cal_web.rechazo_catodos_obs where fecha = '".$Fecha."' and turno = '".$turno."' and grupo = '".$grupo."'";
		$resp=mysqli_query($link, $Consulta1);
		if($row2=mysqli_fetch_array($resp))
		{
			$NombreUser = $row2["encargado"];
			$observacion = $row2["observacion"];
		}
		$ano = substr($Fecha,0,4);
		$mes = substr($Fecha,5,2);
		$dia = substr($Fecha,8,2);
		$cmbturno = $row["turno"];
		$cmbgrupo = $row["grupo"];
		$inspector = $row["inspector"];
		$cmblado = $row["lado"];
		$cmbcuba = $row["cuba"];
		$unid_recup = $row["unid_recup"];
		$recup_menor = $row["recup_menor"];
		$muestra = $row["muestra"];
		$estampa = $row["estampa"];
		$dispersos = $row["dispersos"];
		$rayado = $row["rayado"];
		$cordon_superior = $row["cordon_superior"];
		$cordon_lateral = $row["cordon_lateral"];
		$quemados = $row["quemados"];
		$redondos = $row["redondos"];
		$aire = $row["aire"];
		$otros = $row["otros"];
	}
}
?>
<html>
<head>
<title>Selecci�n de Catodos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Nuevo_Dato()
{
	var f = document.formulario;
	
	f.action="cal_rechazo_catodos.php"
	f.submit()
}

function Guardar_Datos()
{
	var f = document.formulario;

	if(f.cmbturno.value == -1)
	{
		alert("Debe Seleccionar Turno");
		f.cmbturno.focus();		
		return
	}	

	if(f.cmbgrupo.value == -1)
	{
		alert("Debe Seleccionar Grupo");
		f.cmbgrupo.focus();				
		return
	}	

	if(f.cmblado.value == -1)
	{
		alert("Debe Seleccionar Lado");
		f.cmblado.focus();		
		return
	}	

	if(f.cmbcuba.value == -1)
	{
		alert("Debe Seleccionar Cuba");
		f.cmbcuba.focus();				
		return
	}	
	
	f.action="cal_rechazo_catodos01.php?Proceso=G"
	f.submit()
}

function Modificar_Datos()
{
	var f = document.formulario;

	if(f.cmbturno.value == -1)
	{
		alert("Debe Seleccionar Turno");
		f.cmbturno.focus();		
		return
	}	

	if(f.cmbgrupo.value == -1)
	{
		alert("Debe Seleccionar Grupo");
		f.cmbgrupo.focus();				
		return
	}	

	if(f.cmblado.value == -1)
	{
		alert("Debe Seleccionar Lado");
		f.cmblado.focus();		
		return
	}	

	if(f.cmbcuba.value == -1)
	{
		alert("Debe Seleccionar Cuba");
		f.cmbcuba.focus();				
		return
	}	
	
	f.action="cal_rechazo_catodos01.php?Proceso=M"
	f.submit()
}

function Ver_Datos()
{
	var f = document.formulario;
	var valores = "";

	if(f.cmbturno.value == -1)
	{
		alert("Debe Seleccionar Turno");
		f.cmbturno.focus();		
		return
	}	

	if(f.cmbgrupo.value == -1)
	{
		alert("Debe Seleccionar Grupo");
		f.cmbgrupo.focus();				
		return
	}	
		valores = "ano=" + f.ano.value + "&mes=" + f.mes.value + "&dia=" + f.dia.value + "&turno=" + f.cmbturno.value + "&grupo=" + f.cmbgrupo.value +"&NombreUser=" + f.encargado.value;
	    window.open("cal_rechazo_catodos02.php?"+valores, "","menubar=no resizable=no Top=10 Left=25 width=720 height=600 scrollbars=yes");
}

function Salir_Menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=15";
	f.submit();
}
</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet"></head>

<body leftmargin="3" topmargin="2">
<form name="formulario" method="post" action="">
<?php include("../principal/encabezado.php")?>
<?php include("../principal/conectar_principal.php") ?> 

<table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
 <tr>
  	<td height="313" align="center" valign="top" >
		<table width="750" border="0" class="TablaDetalle">
          <tr> 
            <td class="ColorTabla01" colspan="7" align="center">Selecci�n de Catodos 
            </td>
          </tr>
          <tr> 
            <td width="66">Fecha</td>
            <td width="227">
			<select name="dia">
            <?php
				if($Proceso=='B' || $Proceso=='M')
				{
					for ($i=1;$i<=31;$i++)
					{
					   if ($i==$dia)
							{
							echo "<option selected value= '".$i."'>".$i."</option>";
							}
							else
							{						
						  echo "<option value='".$i."'>".$i."</option>";
							}		    		
					}
				}
				else
				{
					for ($i=1;$i<=31;$i++)
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
        	</select> <select name="mes">
            <?php
				$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				if($Proceso=='B' || $Proceso=='M')
				{
					for($i=1;$i<13;$i++)
					{	
						if ($i==$mes)
						{				
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
						}			
						else
						{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
						}
					}		
				}
				else
				{
					for($i=1;$i<13;$i++)
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
			<select name="ano">
            <?php
				if($Proceso=='B' || $Proceso=='M')
				{
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
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
				else
				{
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
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
			</td>
            <td width="35">Turno</td>
            <td width="77">
			<select name="cmbturno">
            <?php
				echo'<option selected value="-1">Seleccionar</option>';
				if($cmbturno == "A")
					echo'<option value="A" selected>Turno A</option>';
				else
					echo'<option value="A">Turno A</option>';

				if($cmbturno == "B")
					echo'<option value="B" selected>Turno B</option>';
				else
					echo'<option value="B">Turno B</option>';	
				
				if($cmbturno == "C")
					echo'<option value="C" selected>Turno C</option>';
				else
					echo'<option value="C">Turno C</option>';	
			?>
            </select>
			</td>
            <td width="36">Grupo</td>
            <td width="79">
			<select name="cmbgrupo">
            <?php				
				echo '<option value="-1">Seleccionar</option>';
			
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2004 ORDER BY cod_subclase";
				$rs = mysqli_query($link, $consulta);
				
				while ($row = mysqli_fetch_array($rs))
				{
					if ($row["cod_subclase"] == $cmbgrupo)
						echo '<option value="'.$row["cod_subclase"].'" selected>N� '.$row["cod_subclase"].'</option>';
					else 
						echo '<option value="'.$row["cod_subclase"].'">N� '.$row["cod_subclase"].'</option>';
				}
		  ?>
          </select>
		  </td>
          <td width="197"><input name="ver_datos" type="button" style="width:100" onClick="Ver_Datos()"  value="Ver Datos">
		  </td>
          </tr>
		<tr>
          	<td>Encargado</td>
          	<td colspan="6">
			<?php
				if($Proceso == "B" || $Proceso == "M")
					echo'<input name="encargado" type="text" size="60" value="'.$NombreUser.'">';
				else
					echo'<input name="encargado" type="text" size="60" value="'.$NombreUser.'">';
          	?>
			</td>
		  </tr>
          <tr> 
          	<td>Inspector</td>
          	<td colspan="6">
			<?php
				if($Proceso == "B" || $Proceso == "M")
					echo'<input name="inspector" type="text" size="60" value="'.$inspector.'">';
				else
					echo'<input name="inspector" type="text" size="60">';
          	?>
			</td>
		</tr>
          <tr> 
          	<td>Observaciones</td>
          	<td colspan="6">
			<?php
					echo'<input name="observacion" type="text" size="120" value="'.$observacion.'">';
          	?>
			</td>
		  </tr>
        </table>
		<br>
		<table width="750" border="1" cellpadding="3" cellspacing="0" class="TablaPrincipal">
          <tr class="ColorTabla02"> 
            <td colspan="2">&nbsp;</td>
            <td colspan="3" align="center"><strong>Recuperados</strong></td>
            <td colspan="8" align="center"><strong>Rechazados</strong></td>
          </tr>
          <tr class="ColorTabla01"> 
            <td width="59" align="center">Lado</td>
            <td width="61" align="center">Cuba</td>
            <td width="66" align="center">Recup.</td>
            <td width="76" align="center">Recup. Menor</td>
            <td width="63"align="center">Nod. Estampa</td>
            <td width="62"align="center">Nod. Disper.</td>
            <td width="53"align="center">Rayado</td>
            <td width="66"align="center">Cordon Superior</td>
            <td width="63"align="center">Cordon Lateral</td>
            <td width="63"align="center">Quemados</td>
            <td width="63"align="center">Redondos</td>
            <td width="63"align="center">Aire</td>
            <td width="68"align="center">Otros</td>
          </tr>
          <tr> 
            <td align="center">
			<select name="cmblado">
                <?php
				echo'<option value="-1" selected>Seleccionar </option>';
				
				if($cmblado == "T")
					echo'<option value="T" selected>Total</option>';
				else
					echo'<option value="T">Total</option>';

				if($cmblado == "P")
					echo'<option value="P" selected>Parcial</option>';
				else
					echo'<option value="P">Parcial</option>';	
				?>
             </select>
		    </td>
            <td align="center">
			<select name="cmbcuba">
                <?php
					echo '<option value="-1">Seleccionar</option>';


					for ($i=1; $i<=42; $i++)				
					{
						if ($i == $cmbcuba)
							echo '<option value="'.$i.'" selected>N� '.$i.'</option>';
						else 
							echo '<option value="'.$i.'">N� '.$i.'</option>';
					}
						
				?>
              </select>
			</td>
            <td align="center">
			<?php
				if($Proceso == "M")
					echo'<input type="text" name="recuperado" size="5" value="'.$unid_recup.'" >';
				else
					echo'<input type="text" name="recuperado" size="5">';
			?>
			</td>
            <td align="center">
			<?php
				if($Proceso == "M")
					echo'<input type="text" name="recup_menor" size="5" value="'.$recup_menor.'" >';
				else
					echo'<input type="text" name="recup_menor" size="5">';
			?>
			</td>
            <td align="center">
			<?php
				if($Proceso == "M")
					echo'<input type="text" name="estampa" size="5" value="'.$estampa.'">';
				else
					echo'<input type="text" name="estampa" size="5">';
			?>
			</td>
            <td align="center">
			<?php
				if($Proceso == "M")
					echo'<input type="text" name="dispersos" size="5" value="'.$dispersos.'">';
				else
					echo'<input type="text" name="dispersos" size="5">';
			?>
			</td>
            <td align="center">
			<?php
				if($Proceso == "M")
					echo'<input type="text" name="rayado" size="5" value="'.$rayado.'">';
				else
					echo'<input type="text" name="rayado" size="5">';
			?>
			</td>
            <td align="center">
			<?php
				if($Proceso == "M")
					echo'<input type="text" name="c_superior" size="5" value="'.$cordon_superior.'">';
				else
					echo'<input type="text" name="c_superior" size="5">';
			?>
			</td>
            <td align="center">
			<?php
				if($Proceso == "M")
					echo'<input type="text" name="c_lateral" size="5" value="'.$cordon_lateral.'">';
				else
					echo'<input type="text" name="c_lateral" size="5">';
			?>		
			</td>
            <td align="center">
			<?php
				if($Proceso == "M")
					echo'<input type="text" name="quemados" size="10" value="'.$quemados.'">';
				else
					echo'<input type="text" name="quemados" size="10">';
			?>
			</td>
            <td align="center">
			<?php
				if($Proceso == "M")
					echo'<input type="text" name="redondos" size="10" value="'.$redondos.'">';
				else
					echo'<input type="text" name="redondos" size="10">';
			?>
			</td>
            <td align="center">
			<?php
				if($Proceso == "M")
					echo'<input type="text" name="aire" size="10" value="'.$aire.'">';
				else
					echo'<input type="text" name="aire" size="10">';
			?>
			</td>
            <td align="center">
			<?php
				if($Proceso == "M")
					echo'<input type="text" name="otros" size="5" value="'.$otros.'">';
				else
					echo'<input type="text" name="otros" size="5">';
			?>
			</td>
          </tr>
        </table>
		<br>
		<table width="750" border="0" class="TablaDetalle">
          <tr> 
            <td align="center">
			<?php
				if($Proceso == "M")
				{
					echo'<input type="button" name="nuevo" style="width:70" value="Nuevo" onClick="Nuevo_Dato()">&nbsp;';
					echo'<input type="button" name="modificar" style="width:70" value="Modificar" onClick="Modificar_Datos()">';
				}
				else
					echo'<input type="button" name="guardar" style="width:70" value="Guardar" onClick="Guardar_Datos()">';
			?>	
				<input type="button" name="salir" style="width:70" value="Salir" onClick="Salir_Menu()">
            </td>
          </tr>
	  </table>	</td>
</tr>
</table>
  <?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
