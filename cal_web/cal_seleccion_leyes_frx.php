<?php
	include("../principal/conectar_principal.php");
	$Consulta="select t1.cod_leyes from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2";
	$Consulta=$Consulta." on t1.cod_leyes = t2.cod_leyes and t2.tipo_leyes='0' where t1.nro_solicitud=".$SA;
	if ($Recargo!='N')
	{
		$Consulta=$Consulta." and recargo='".$Recargo."'";
	}
	$Respuesta=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		$Leyes=$Leyes." and t1.cod_leyes <>'".$Fila["cod_leyes"]."'"; 
	}
	//$Leyes=substr($Leyes,0,strlen($Leyes)-4);
	$Consulta="select t1.cod_leyes from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2";
	$Consulta=$Consulta." on t1.cod_leyes = t2.cod_leyes and t2.tipo_leyes='1' where t1.nro_solicitud=".$SA;
	if ($Recargo!='N')
	{
		$Consulta=$Consulta." and recargo='".$Recargo."'";
	}
	$Respuesta=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		$Imp=$Imp." and t1.cod_leyes <>'".$Fila["cod_leyes"]."'"; 
	}
	//$Imp=substr($Imp,0,strlen($Imp)-4);
	$Consulta="select t1.cod_leyes from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2";
	$Consulta=$Consulta." on t1.cod_leyes = t2.cod_leyes and t2.tipo_leyes='3' where t1.nro_solicitud=".$SA;
	if ($Recargo!='N')
	{
		$Consulta=$Consulta." and recargo='".$Recargo."'";
	}
	$Respuesta=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		$Fis=$Fis." and t1.cod_leyes <>'".$Fila["cod_leyes"]."'"; 
	}
	//$Fis=substr($Fis,0,strlen($Fis)-4);
	
?>
<html>
<head>
<script language="JavaScript">
function Validar(ValoresSA,SA,Recargo,Ley,Proceso)
{
	var frm=document.FrmIngreso;
	var LargoForm = frm.elements.length;
    var checkeoLeyes=false;
	var LeyNueva="";
	var UnidadNueva="";
	
	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name == "checkLeyes") && (frm.elements[i].checked == true))
		{
			checkeoLeyes= true;
			LeyNueva=frm.elements[i].value;
			UnidadNueva=frm.elements[i+1].value;
			break;
		}
	}
	if (checkeoLeyes==true)
	{
		frm.action="cal_seleccion_leyes_frx01.php?ValoresSA="+ValoresSA+"&LeyNueva="+LeyNueva+"&UnidadNueva="+UnidadNueva+"&SA="+SA+"&Ley="+Ley+"&Recargo="+Recargo+"&Proceso="+Proceso;
		frm.submit();
	}
	else
	{
		alert("Debe Seleccionar Ley");
		return;
	}					
}	

</script>

<title>Modificacion de Leyes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body background="../principal/imagenes/fondo3.gif">
<center>
<form name="FrmIngreso" method="post" action="">
<table width="600" height="228" border="0" cellpadding="5" class="tablaprincipal">
<td>
	<table width="600" border="0" cellpadding="0" class="ColorTabla01">
  	<tr>
              <td><div align="center"><strong>MODIFICACION DE LEYES</strong></div></td>
  	</tr>
	</table><br>
          <table width="600" border="0" cellpadding="0" class="TablaInterior">
            <tr> 
              <td width="185"></td>
              <td width="381"><input name="BtnBorrar" type="SUBMIT"  value="Borrar"style="width:60">
                <input name="BtnOk" type="button"  value="Ok" style="width:60" onClick="JavaScript:Validar('<?php echo $ValoresSA;?>','<?php echo $SA;?>','<?php echo $Recargo;?>','<?php echo $Ley;?>','<?php echo $Proceso;?>');">
                <input name="BtnSalir" type="Button"  value="Salir" style="width:60" onClick="JavaScript:window.close();"></td>
            </tr>
          </table><br>

	      <table width="600" height="23" border="0" class="ColorTabla01" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <tr> 
              <td width="164" height="29" ></td>
              <td width="251" ><div align="center">Leyes</div></td>
              <td width="163" >&nbsp;</td>
            </tr>
          </table>
          
            <?php
	  			echo "<table width='600' height='15' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
				echo"<tr>";
				$cont=1;	 
				$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes = 0 ".$Leyes." order by  t1.abreviatura";
				$Resultado = mysqli_query($link, $Consulta);
				while ($Fila =mysqli_fetch_array($Resultado))
				{
			 		if($cont==5) 
					{
						echo '</tr>';
						echo '<tr>';
						$cont=1;
			    	}
     				echo "<td align='left'><input type='radio' name ='checkLeyes' value='".$Fila["cod_leyes"]."'>".$Fila[abrev];
					echo "&nbsp;";
					echo "<select name='CmbUnidad' style='width:80'";
					$Consulta = "select * from unidades";
					$Resultado2 = mysqli_query($link, $Consulta);
					while ($Fila2 =mysqli_fetch_array($Resultado2))
					{
						if ($Fila[cod_unidad] == $Fila2[cod_unidad])
						{
							echo"<option value='".$Fila2[cod_unidad]."' selected>".ucwords(strtolower($Fila2["abreviatura"]))."</option>";
						}
						else
						{
							echo"<option value='".$Fila2[cod_unidad]."'>".ucwords(strtolower($Fila2["abreviatura"]))."</option>";
						}							
					}
					echo "</select></td>";
					$cont =$cont+ 1;
				}
				echo "</table>";
				?>
          <br>
          <table width="600" class="ColorTabla01" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <tr> 
              <td width="164" height="23"></td>
              <td width="252"><div align="center">Impurezas</div></td>
              <td width="162">&nbsp;</td>
            </tr>
          </table>
   			<?php
				echo "<table width='600' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";	
	  			echo"<tr>";
				$cont=1;	 
				$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes = 1 ".$Imp." order by  t1.abreviatura";
				$Resultado = mysqli_query($link, $Consulta);
				while ($Fila =mysqli_fetch_array($Resultado))
				{
			 		if($cont==5) 
					{
						echo '</tr>';
						echo '<tr>';
						$cont=1;
			    	}
     				echo "<td align='left'><input type='radio' name ='checkLeyes' value='".$Fila["cod_leyes"]."'>".$Fila[abrev];		
					echo "<select name='CmbUnidad' style='width:80' align='right'>";
					$Consulta = "select * from unidades";
					$Resultado2 = mysqli_query($link, $Consulta);
					while ($Fila2 =mysqli_fetch_array($Resultado2))
						{
							if ($Fila[cod_unidad] == $Fila2[cod_unidad])
							{
								echo"<option value='".$Fila2[cod_unidad]."' selected>".ucwords(strtolower($Fila2["abreviatura"]))."</option>";
							}
							else
							{
								echo"<option value='".$Fila2[cod_unidad]."'>".ucwords(strtolower($Fila2["abreviatura"]))."</option>";
							}							
						}
					echo "</select></td>";
					$cont =$cont+ 1;
				}
				echo "</table>";
		  ?>
		  <table width="600" class="ColorTabla01" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <tr> 
              <td width="164" height="23"></td>
              <td width="252"><div align="center">Leyes Fisicas</div></td>
              <td width="162">&nbsp;</td>
            </tr>
          </table>
   		  <?php
			echo "<table width='600' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
			echo"<tr>";
			$cont=1;	 
			$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes =3 ".$Fis." order by t1.abreviatura";
			$Resultado = mysqli_query($link, $Consulta);
			while ($Fila =mysqli_fetch_array($Resultado))
			{
				if($cont==5) 
				{
					echo '</tr>';
					echo '<tr>';
					$cont=1;
				}
				echo "<td width='150' align='left'><input type='radio' name ='checkLeyes' value='".$Fila["cod_leyes"]."'>".$Fila[abrev];		
				echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";
				echo "<select name='CmbUnidad' style='width:80' align='right'>";
				$Consulta = "select * from unidades";
				$Resultado2 = mysqli_query($link, $Consulta);
				while ($Fila2 =mysqli_fetch_array($Resultado2))
					{
						if ($Fila[cod_unidad] == $Fila2[cod_unidad])
						{
							echo"<option value='".$Fila2[cod_unidad]."' selected>".ucwords(strtolower($Fila2["abreviatura"]))."</option>";
						}
						else
						{
							echo"<option value='".$Fila2[cod_unidad]."'>".ucwords(strtolower($Fila2["abreviatura"]))."</option>";
						}							
					}
				echo "</select></td>";
				echo "</td>";
				$cont =$cont+ 1;
			}
    		echo"</table>";
		 ?>
</td>		  
</tr>
</table>

	<p>&nbsp; </p>

</form></center>
</body>
</html>
