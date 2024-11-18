<?php 
	include("../principal/conectar_sec_web.php");
	$programa =" ";

	$opcion             = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$fecha_desconexion  = isset($_REQUEST["fecha_desconexion"])?$_REQUEST["fecha_desconexion"]:"";
	$grupo              = isset($_REQUEST["grupo"])?$_REQUEST["grupo"]:"";
	$fecha              = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$cmbtipo = isset($_REQUEST["cmbtipo"])?$_REQUEST["cmbtipo"]:"";
	$mostrar = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
	$activar = isset($_REQUEST["activar"])?$_REQUEST["activar"]:"";
	$mensaje = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";
	$dia1     = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d"); 
	$mes1     = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");  
	$ano1     = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y"); 
	$hr1     = isset($_REQUEST["hr1"])?$_REQUEST["hr1"]:date("H"); 
	$mm1     = isset($_REQUEST["mm1"])?$_REQUEST["mm1"]:date("i"); 
	$dia2     = isset($_REQUEST["dia2"])?$_REQUEST["dia2"]:date("d"); 
	$mes2     = isset($_REQUEST["mes2"])?$_REQUEST["mes2"]:date("m");  
	$ano2     = isset($_REQUEST["ano2"])?$_REQUEST["ano2"]:date("Y"); 
	$hr2     = isset($_REQUEST["hr2"])?$_REQUEST["hr2"]:date("H"); 
	$mm2     = isset($_REQUEST["mm2"])?$_REQUEST["mm2"]:date("i");
	$kahdirc = isset($_REQUEST["kahdirc"])?$_REQUEST["kahdirc"]:"";
	$kahdird = isset($_REQUEST["kahdird"])?$_REQUEST["kahdird"]:"";

	if ($opcion == "M")
	{
		$consulta = "SELECT * FROM sec_web.cortes_refineria WHERE cod_grupo = '".$grupo."' AND fecha_desconexion = '".$fecha_desconexion."'";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$mostrar = "S";
			$ano1 = substr($row["fecha_desconexion"],0,4);
			$mes1 = substr($row["fecha_desconexion"],5,2);
			$dia1 = substr($row["fecha_desconexion"],8,2);
			$hr1 = substr($row["fecha_desconexion"],11,2);
			$mm1 = substr($row["fecha_desconexion"],14,2);

			$ano2 = substr($row["fecha_conexion"],0,4);
			$mes2 = substr($row["fecha_conexion"],5,2);
			$dia2 = substr($row["fecha_conexion"],8,2);
			$hr2 = substr($row["fecha_conexion"],11,2);
			$mm2 = substr($row["fecha_conexion"],14,2);	
			$cmbtipo=$row["tipo_desconexion"];
			$kahdirc = $row["kahdirc"];
			$kahdird = $row["kahdird"];
					
		}
	}
	else {
	       
	      $f1=date("Y-m-d", mktime(0,0,0,intval(substr($fecha,5,2))+1,1,intval(substr($fecha,0,4)) ));
		  $dias_mes=date("d", mktime(0,0,0,intval(substr($f1,5,2)),1-1,intval(substr($f1,0,4)) ));
		
	}
	$programa="PP";


	
?>
<html>
<head>
<title>Ingreso Estadistica de Cortes Refineria</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValidaCampos(f)
{
 
    fecha_actual=f.ano1_actual.value+'-'+f.mes1_actual.value+'-'+f.dia1_actual.value;
	dia1="";
	mes1="";
	if (f.dia1.value.length == 1 )
	   {
	     dia1='0'+f.dia1.value;
       }
	if (f.mes1.value.length == 1 )
	   {
	    mes1='0'+f.mes1.value;
       }
	if ((mes1 != "")&&(dia1 !=""))
	   {
	    fecha_ingreso=f.ano1.value+'-'+mes1+'-'+dia1;	
	   }
	else if (dia1 != "")
	       {
		     fecha_ingreso=f.ano1.value+'-'+f.mes1.value+'-'+dia1;	
		   }
		 else if (mes1 !="")
		         {
				  fecha_ingreso=f.ano1.value+'-'+mes1+'-'+f.dia1.value;	
				 }  
    	       else {fecha_ingreso=f.ano1.value+'-'+f.mes1.value+'-'+f.dia1.value;	}
	
	
	if (f.cmbtipo.value == -1)
	{
		alert("Debe Seleccionar el Tipo de Desconexion");
		return false;
	}
	if (f.cmbtipo.value!='R')
		{
			if (f.cmbgrupo.value == -1)
			{
				alert("Debe Seleccionar el Grupo");
				return false;
			}
		}
	else{
		  if (f.cmbrectificador.value == -1)
			{
				alert("Debe Seleccionar Circuito");
				return false;
			}
	
	    }		
	
	if (f.txtkah1.value == "")
	{
		alert("Debe Ingresar los Kahdird");
		return false;
	}
	if (f.txtkah1.value > f.txtkah2.value)
	{
	 alert("El valor de Kahdird no puede ser mayor que Kahdirc");
	 return false;
	}
	if (fecha_ingreso > fecha_actual)
	{
		alert("la fecha de desconexion no puede ser mayor que la fecha actual");
		return false;
	}
	
	return true;
}
/******************/
function ayuda()
{
window.open("sec_ing_estadistica_cortes_ayuda.php","","top=50,left=390,width=500,height=238,scrollbars=no,resizable = no");
}



function Grabar(f)
{  
    fecha=f.ano1_actual.value+'-'+f.mes1_actual.value+'-'+f.dia1_actual.value;
	var dias1=0;
	var dias2 = 0;
	var mm1 = 0;
	var mm2 = 0;
	var mes1 = 0;
	var mes2 = 0;
	var hr1= 0;
	var hr2 = 0;
	
	if (f.mes2.value.length== 1)
		mes2 = "0"+f.mes2.value;
	else
		mes2 = f.mes2.value;
	
	if (f.mes1.value.length== 1)
		mes1 = "0"+f.mes1.value;
	else
		mes1 = f.mes1.value;

	if (f.dia2.value.length== 1)
		dia2 = "0"+f.dia2.value;
	else
		dia2 = f.dia2.value;
		
	if (f.dia1.value.length== 1)
		dia1 = "0"+f.dia1.value;
	else
		dia1 = f.dia1.value;
		
	if (f.hr2.value.length== 1)
		hr2 = "0"+f.hr2.value;
	else
		hr2 = f.hr2.value;
		
		if (f.hr1.value.length== 1)
		hr1 = "0"+f.hr1.value;
	else
		hr1 = f.hr1.value;

	if (f.mm2.value.length== 1)
		mm2 = "0"+f.mm2.value;
	else
		mm2 = f.mm2.value;

	if (f.mm1.value.length== 1)
		mm1 = "0"+f.mm1.value;
	else
		mm1 = f.mm1.value;
	var fecha1 = f.ano1.value + mes1 + dia1 + hr1 + mm1;	
	var fecha2 = f.ano2.value + mes2 + dia2 + hr2 + mm2;	
//	alert (dias2 +"--"+ dias1);
	if (ValidaCampos(f))
	{	
		if (fecha1 >= fecha2)
		{
			alert ("Fecha  de Conexión no puede ser Menor que Fecha de Desconexión");
			return;
		}		
 		if (f.txtkah2.value < f.txtkah1.value)
		{
			alert ("Lectura de Conexión no puede ser Menor que Lectura de Desconexión");
			return;
		}

	  if (f.cmbtipo.value!='R')
	  	{
			linea = "dia1=" + f.dia1.value + "&mes1=" + f.mes1.value + "&ano1=" + f.ano1.value + "&hr1=" + f.hr1.value + "&mm1=" + f.mm1.value;
			linea = linea + "&proceso=G" + "&cmbgrupo=" + f.cmbgrupo.value + "&programa=PP"    + "&fecha="+f.fecha.value + "&opcion=N"+"&tipo_desc="+f.tipo_desc.value; 
			
			f.action = "sec_ing_estadistica_cortes_proceso01_ref.php?" + linea ;
			f.submit();
		}
     else {
	 		linea = "dia1=" + f.dia1.value + "&mes1=" + f.mes1.value + "&ano1=" + f.ano1.value + "&hr1=" + f.hr1.value + "&mm1=" + f.mm1.value;
			linea = linea + "&proceso=G" + "&cmbrectificador=" + f.cmbrectificador.value + "&programa=PP" + "&opcion=N"+"&tipo_desc="+f.tipo_desc.value; 
			alert (linea);
			f.action = "sec_ing_estadistica_cortes_proceso01_ref.php?" + linea ;
			f.submit();
	 	  }			
	}
}
/******************/
function Salir(f,fecha)
{
	f.action = "Conexiones.php?fecha="+fecha;
	f.submit();
}

function tipo(f)
{
 	 f.action = "sec_ing_estadistica_cortes_proceso_ref2.php?cmbtipo="+f.cmbtipo.value ;
	 f.submit();
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="552" height="157" border="0" align="center" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
<td width="517" align="center" valign="middle">

<table width="538" border="0" cellspacing="0" cellpadding="3">
          <tr class="ColorTabla01"> 
            <?php if ($opcion=='M')
			    { 
			?>
			      
            <td height="15" colspan="3" align="center"><strong>Modificacion de 
              Conexiones(Versión 1)</strong></td>
			<?php  } 
			   else {?>
			          <td height="15" colspan="3" align="center"><strong>Ingreso de Nueva Conexion(Versión 1)</strong></td>
					<?php } ?>  
			        
          </tr>
          <tr> 
            <td width="174" height="15">Tipo Desconexion</td>
            <td width="231"><select name="cmbtipo" onChange="tipo(this.form)">
                <option value="-1">SELECCIONAR</option>
                <?php
			  		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 3000";
					$rs1 = mysqli_query($link, $consulta);
					while ($row1 = mysqli_fetch_array($rs1))
					{	
						if ($row1["valor_subclase1"] == $cmbtipo)
							echo '<option value="'.$row1["valor_subclase1"].'" selected>'.$row1["nombre_subclase"].'</option>';
						else 
							echo '<option value="'.$row1["valor_subclase1"].'">'.$row1["nombre_subclase"].'</option>';
					}
			  	?>
              </select></td>
            <td width="77"><input name="btnayuda" type="button" style="width:70" value="Ayuda" onClick="ayuda()"></td>
          </tr>
          <tr>
		  <?php 
		  	if ($cmbtipo!='R')
				{
		  ?> 
            		<td height="30">Grupo</td>
			<?php  }
			else { ?>
					<td height="30">Rectificador</td>
			  <?php } ?>			
            <td colspan="2"> 
              <?php
				if ($cmbtipo!='R')
				  {
					if ($opcion == "M")
						echo '<select name="cmbgrupo" id="cmbgrupo" disabled>';
					else 
						echo '<select name="cmbgrupo" id="cmbgrupo">';
				
					echo '<option value="-1">SELECCIONAR</option>';
			  	
			  		$consulta = "SELECT distinct * FROM sec_web.grupo_electrolitico2 group by cod_grupo ORDER BY cod_grupo";
					$rs2 = mysqli_query($link, $consulta);
					while ($row2 = mysqli_fetch_array($rs2))
					{		
						if ($row2["cod_grupo"] == $row["cod_grupo"])
							echo '<option value="'.$row2["cod_grupo"].'" selected>N° '.$row2["cod_grupo"].'</option>';
						else 
							echo '<option value="'.$row2["cod_grupo"].'">N° '.$row2["cod_grupo"].'</option>';
					}
			  	}
				else {
				       if ($opcion == "M")
						echo '<select name="cmbrectificador" disabled>';
					   else 
						echo '<select name="cmbrectificador" id="cmbrectificador">';
				
					   echo '<option value="-1">SELECCIONAR</option>';
			  	
			  		   $consulta = "SELECT distinct cod_rectificador FROM ref_web.rectificadores group by cod_rectificador order by cod_rectificador";
					   $rs2 = mysqli_query($link, $consulta);
					   while ($row2 = mysqli_fetch_array($rs2))
							{		
								if ($row2["cod_rectificador"] == $row["cod_rectificador"])
									echo '<option value="'.$row2["cod_rectificador"].'" selected>'.$row2["cod_rectificador"].'</option>';
								else 
									echo '<option value="'.$row2["cod_rectificador"].'">'.$row2["cod_rectificador"].'</option>';
							}
				    } 
				 
				 ?>
				 
				 
				 
				 </select>
              </td>
          </tr>
          <tr> 
            <td height="30">Fecha y Hora Desconexion</td>
            <td colspan="2"> 
              <?php
			if ($opcion == "M")
				echo '<select name="dia1" disabled>';
			else
		  		echo '<select name="dia1" id="dia1">';
            
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($mostrar == "S") && ($i == $dia1))			
					echo '<option selected value="'.$i.'">'.$i.'</option>';				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo '<option selected value="'.$i.'">'.$i.'</option>';
				else					
					echo '<option value="'.$i.'">'.$i.'</option>';												
			}		
		?></select>
              <?php
			if ($opcion == "M")
				echo '<select name="mes1" id="select" disabled>';
			else
				echo '<select name="mes1" id="select">';
            
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes1))
					echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
				else if (($i == date("n")) && ($mostrar != "S"))
						echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
				else
					echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';			
			}		  
		?></select>
              <?php			
			if ($opcion == "M")
				echo '<select name="ano1" id="ano1" disabled>';
			else 
				echo '<select name="ano1" id="ano1">';
            
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano1))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?></select>
              &nbsp; &nbsp; &nbsp; 
              <?php
			if ($opcion == "M")
				echo '<select name="hr1" id="select5" disabled>';
			else 
            	echo '<select name="hr1" id="select5">';
             
		 	for($i=0; $i<=23; $i++)
			{
				if (($mostrar == "S") && ($i == $hr1))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("H")) && ($mostrar != "S"))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?></select>
              : 
              <?php
			if ($opcion == "M")
				echo '<select name="mm1" id="select6" disabled>';
			else 
           	 	echo '<select name="mm1" id="select6">';

		 	for($i=0; $i<=59; $i++)
			{
				if (($mostrar == "S") && ($i == $mm1))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($mostrar != "S"))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?></select>
		<?php $consulta_f_actual="select left(sysdate(),10) as fecha_actual";
		   $rs_f_actual = mysqli_query($link, $consulta_f_actual);
		   $row_f_actual = mysqli_fetch_array($rs_f_actual);
		   $ano1_actual=substr($row_f_actual["fecha_actual"],0,4);
		   $mes1_actual=substr($row_f_actual["fecha_actual"],5,2);
		   $dia1_actual=substr($row_f_actual["fecha_actual"],8,2);
		   
		?>
		<input name="dia1_actual" TYPE="hidden" value="<?php echo $dia1_actual;?>" size="2" style="text-align: center;background:ColorTabla01;color:white;" readonly >
        <input name="mes1_actual" type="hidden" value="<?php echo $mes1_actual;?>" size="2" style="text-align: center;background:ColorTabla01;color:white;" readonly>
        <input name="ano1_actual" type="hidden" value="<?php echo $ano1_actual;?>" size="4" style="text-align: center;background:ColorTabla01;color:white;" readonly>
		
		
        <input name="fecha" type="hidden" value="<?php echo $fecha;?>" size="10" style="text-align: center;background:ColorTabla01;color:white;" readonly>
     
              </td>
          </tr>
          <tr> 
            <td height="30">Kahdird</td>
            <td colspan="2"><input name="txtkah1" type="text" size="10" value="<?php echo $kahdird;?>"></td>
          </tr>
          <tr> 
            <td height="30">Fecha y Hora Conexion</td>
            <td colspan="2"><select name="dia2" size="1" id="select2">
                <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($mostrar == "S") && ($i == $dia2))			
					echo '<option selected value="'.$i.'">'.$i.'</option>';				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo '<option selected value="'.$i.'">'.$i.'</option>';
				else					
					echo '<option value="'.$i.'">'.$i.'</option>';												
			}		
		?>
              </select> <select name="mes2" size="1" id="mes2">
                <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes2))
					echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
				else if (($i == date("n")) && ($mostrar != "S"))
						echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
				else
					echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';			
			}		  
		?>
              </select> <select name="ano2" size="1" id="select4">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano2))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
              </select> &nbsp; &nbsp; &nbsp; <select name="hr2" id="select7">
                <?php
		 	for($i=0; $i<=23; $i++)
			{
				if (($mostrar == "S") && ($i == $hr2))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("H")) && ($mostrar != "S"))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
              </select>
              : 
              <select name="mm2" id="select8">
                <?php
		 	for($i=0; $i<=59; $i++)
			{
				if (($mostrar == "S") && ($i == $mm2))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($mostrar != "S"))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
              </select></td>
          </tr>
          <tr> 
            <td height="30">Kahdirc</td>
            <td colspan="2"><input name="txtkah2" type="text" size="10" value="<?php echo $kahdirc?>"></td>
          </tr>
        </table>
		<?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
			echo '<input name="tipo_desc" type="hidden" size="40" value="'.$cmbtipo.'">';
			echo '<input name="programa" type="hidden" size="40" value="'.$programa.'">';
			
	  	?>	  

      <br>
      <table width="500" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td align="center"><input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="Grabar(this.form)">
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir(this.form,' <?php echo $fecha;?>')">
          </td>
        </tr>
      </table></td>
</tr>
</table>
</form>
<?php
	if ($activar!="")
	{
		echo '<script language="JavaScript">';		
		if ($mensaje!="")
			echo 'alert("'.$mensaje.'");';		
			
		echo 'window.opener.document.frmPrincipal.action = "sec_ing_estadistica_cortes.php";';
		echo 'window.opener.document.frmPrincipal.submit();';
		//echo 'window.close();';		
		echo '</script>';
	}
?>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>
