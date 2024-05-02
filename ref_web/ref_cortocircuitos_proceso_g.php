<?php 
	include("../principal/conectar_sec_web.php");
	
	if ($opcion == "M")
	{
		$consulta = "SELECT distinct cod_grupo,cod_circuito,cont_dia,fecha,cortos,tipo_anodo,estado FROM ref_web.cortocircuitos WHERE cod_grupo = '".$grupo."' and fecha='".$fecha."' and tipo_anodo='".$tipo."'";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$mostrar = "S";
			$ano1 = substr($row["fecha"],0,4);
			$mes1 = substr($row["fecha"],5,2);
			$dia1 = substr($row["fecha"],8,2);
		}
	}
	
	if ($opcion2=="N")
	   {
		   $fecha=$ano1.'-'.$mes1.'-'.$dia1;
		   $consulta="select distinct cod_circuito from ref_web.grupo_electrolitico2 where cod_grupo='".$cmbgrupo."'";
		   $rs2 = mysqli_query($link, $consulta);
		   $row2 = mysqli_fetch_array($rs2);
		   
			$insertar = "INSERT INTO ref_web.cortocircuitos (cod_grupo,cod_circuito,cont_dia,fecha,cortos,tipo_anodo,estado)";
			$insertar = $insertar." VALUES ('".$cmbgrupo."','".$row2["cod_circuito"]."','".$correlativo."','".$fecha."',".$cortos.",'".$cmbtipo."','A')";		
			mysqli_query($link, $insertar);
			echo '<script language="JavaScript">';		
		    echo 'window.opener.document.frmPrincipal.action = "ref_cortocircuitos.php";';
		    echo 'window.opener.document.frmPrincipal.submit();';
		    echo 'window.close();';		
		    echo '</script>';
		}
		else if ($opcion2=="M")
				 {
				  $fecha=$ano1.'-'.$mes1.'-'.$dia1;
				  $actualizar = "UPDATE ref_web.cortocircuitos SET cortos = '".$cortos."',tipo_anodo = '".$cmbtipo."'";
		          $actualizar = $actualizar." WHERE cod_grupo = '".$cmbgrupo."' AND fecha = '".$fecha_des."'";
		          mysqli_query($link, $actualizar);}			
		
	
?>

<html>
<head>
<title>Ingreso Cortocuicuitos</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValidaCampos(f)
{
	
	if (f.cmbgrupo.value == -1)
	{
		alert("Debe Seleccionar el Grupo");
		return false;
	}
	
	if (f.txtcortos.value == "")
	{
		alert("Debe Ingresar el Numero de cortos");
		return false;
	}
	if (f.cmbtipo.value == -1)
	{
		alert("Debe Seleccionar el Tipo de Anodo");
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
	if (ValidaCampos(f))
	{			
		linea = "dia1=" + f.dia1.value + "&mes1=" + f.mes1.value + "&ano1=" + f.ano1.value ;
		linea = linea +"&opcion2=N"+"&cmbgrupo=" + f.cmbgrupo.value+"&cortos="+f.txtcortos.value+"&tipo="+f.cmbtipo.value+"&correlativo="+f.txtcorrelativo.value; 
		f.action = "ref_cortocircuitos_proceso_g.php?" + linea ;
		f.submit();
	}
}
function Grabar2(f)
{
	if (ValidaCampos(f))
	{			
		linea = "dia1=" + f.dia1.value + "&mes1=" + f.mes1.value + "&ano1=" + f.ano1.value ;
		linea = linea +"&opcion2=M"+"&cmbgrupo=" + f.cmbgrupo.value+"&cortos="+f.txtcortos.value+"&tipo="+f.cmbtipo.value+"&correlativo="+f.txtcorrelativo.value; 
		f.action = "ref_cortocircuitos_proceso_g.php?" + linea ;
		f.submit();
	}
}
function Recarga1(f)
{
	f.action = "ref_cortocircuitos_proceso_g.php?recargapag1=S"+"&opcion=N"+"&grupo="+f.cmbgrupo.value;
	f.submit();
}
/******************/
function Salir()
{
	window.close();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="433" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
<td width="762" align="center" valign="middle">

<table width="500" border="0" cellspacing="0" cellpadding="3">
          <tr> 
            <td width="174" height="30">Fecha</td>
            <td><select name="dia1" size="1" >
                <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{   
					    if (($mostrar == "S") && ($i == $dia1))
						   {  if (($mostrar == "S") && ($Sig == "S"))
						         { 
								   echo '<option selected value="'.$i.'">'.$i.'</option>'; 
								   $i=$i+1;
								   echo '<option selected value="'.$i.'">'.$i.'</option>'; 
							     }
							  else if  (($mostrar == "S") && ($Ant == "S"))
							          {
									   $i=$i-1;
									   echo '<option selected value="'.$i.'">'.$i.'</option>'; 
									   $i=$i+1;
									   
									  }
								 
								 
							       else echo '<option selected value="'.$i.'">'.$i.'</option>';
					       }  
						else if (($i == date("j")) and ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
							
					}
				?>
              </select> <select name="mes1" size="1" id="mes1">
                <?php
					for($i=1;$i<13;$i++)
					{
						if (($mostrar == "S") && ($i == $mes1))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else if (($i == date("n")) && ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else
							echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';
					}
				?>
              </select> <select name="ano1" size="1" id="select4">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (($mostrar == "S") && ($i == $ano1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("Y")) && ($mostrar != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select> &nbsp; </td>
          </tr>
          <tr> 
            <td height="30">Grupo</td>
            <td> 
              <?php
					if ($opcion == "M")
						echo '<select name="cmbgrupo" id="cmbgrupo" disabled>';
					else 
						echo '<select name="cmbgrupo" id="cmbgrupo" onChange="Recarga1(this.form)">';
				
					echo '<option value="-1">SELECCIONAR</option>';
			  	
			  		$consulta = "SELECT distinct * FROM ref_web.grupo_electrolitico2 group by cod_grupo ORDER BY cod_grupo";
					$rs2 = mysqli_query($link, $consulta);
					while ($row2 = mysqli_fetch_array($rs2))
					{		
						if ($row2["cod_grupo"] == $grupo)
							echo '<option value="'.$row2["cod_grupo"].'" selected>N° '.$row2["cod_grupo"].'</option>';
						else 
							echo '<option value="'.$row2["cod_grupo"].'">N° '.$row2["cod_grupo"].'</option>';
					}
			  	?></select>
              </td>
          </tr>
          <tr> 
            <td height="30">N° de Cortocircuitos</td>
            <td><input name="txtcortos" type="text" size="10" value="<?php echo $row[cortos]?>"></td>
          </tr>
          <tr> 
            <td height="30">Tipo de Anodo</td>
            <td><select name="cmbtipo" size="1">
                <option value="-1">SELECCIONAR</option>
				  <?php
					if (($mostrar == "S") and ($row[tipo_anodo] == "A"))
                	{		
						echo '<option value="'.$row[tipo_anodo].'" selected>Nuevo</option>';
						echo '<option value="'.$row[tipo_anodo].'" >Semi</option>';
					}
					if (($mostrar == "S") and ($row[tipo_anodo] == "S"))
					{
						//echo '<option value="S">Semi</option>';
						echo '<option value="'.$row[tipo_anodo].'" selected>Semi</option>';
						echo '<option value="'.$row[tipo_anodo].'" >Nuevo</option>';
					}
				    if($row[tipo_anodo] == '')
					{
						echo '<option value="A">Nuevo</option>';
						echo '<option value="S">Semi</option>';
					}
				?>
               
				
              </select></td>
          </tr>
          <tr> 
            <td height="30">Correlativo Dia</td>
			<?php if (($recargapag1 == "S") and ($opcion=='N'))
		           { $consulta="select distinct max(cont_dia) as cont_dia from ref_web.cortocircuitos where cod_grupo='".$grupo."'";
				     $rs3 = mysqli_query($link, $consulta);
					 $row3 = mysqli_fetch_array($rs3);
					 $row3[cont_dia]=strval(intval($row3[cont_dia])+1);
				?>
            <td><input name="txtcorrelativo" type="text" size="10" value="<?php echo $row3[cont_dia]?>" disabled></td>
			<?php } 
			else {?><td><input name="txtcorrelativo" type="text" size="10" value="<?php echo $row[cont_dia]?>"></td> <?php } ?>
          </tr>
        </table>
		<?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>	  

      <br>
      <table width="500" border="0" cellspacing="0" cellpadding="3">
        <tr>
		 <?php if ($opcion2=='N')
		       {  ?><td align="center"><input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="Grabar(this.form)"> 
			   <?php }
			   else if ($opcion=='M')
			           { ?> <td align="center"><input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="Grabar2(this.form)"><?php } ?>
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()">
          </td>
        </tr>
      </table></td>
</tr>
</table>
</form>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>