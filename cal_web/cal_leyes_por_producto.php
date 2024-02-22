<?php
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Pantalla"])) {
		$Pantalla = $_REQUEST["Pantalla"];
	}else{
		$Pantalla =  "";
	}
	if(isset($_REQUEST["TxtLeyes"])) {
		$TxtLeyes = $_REQUEST["TxtLeyes"];
	}else{
		$TxtLeyes =  "";
	}


	$Leyes=array();
	$LeyesAux=$TxtLeyes."-";


	$i=0;
	for ($l=0;$l<=strlen($LeyesAux);$l++)
	{
		if (substr($LeyesAux,$l,1) == "-")
		{
			$LeyUnidad = substr($LeyesAux,0,$l);
			$Leyes[$i][0]=substr($LeyUnidad,0,$l);
			$i=$i+1;			
			$LeyesAux=substr($LeyesAux,$l+1);
			$l=0;
		}
	}
?>
<html>
<head>
<script language="JavaScript">
function activar()
{
	var frm=document.FrmIngreso;
	var LargoForm = frm.elements.length;
	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name == "checkLeyes"))
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
	/*for (i=0; i< LargoForm; i++ )
	{
		if (frm.elements[i].name == "checkLeyes")
		{
			if (frm.checkLey.checked == true)
			{
				frm.elements[i].checked = true;
			}
		}
	}*/
	
}	
function Validar(Pantalla)
{
	var frm=document.FrmIngreso;
	var LargoForm = frm.elements.length;
    var checkeoLeyes=false;
	var ValoresLeyes="";
	var Unidades= "";
	
	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name == "checkLeyes") && (frm.elements[i].checked == true))
			{
			checkeoLeyes= true;
			ValoresLeyes = ValoresLeyes + frm.elements[i].value + "-" ;
			}
	}
	if ((checkeoLeyes==false))
	{
		alert ("Debe Seleccionar alguna Ley ");
		return;
	}
	else
	{
		frm.action="cal_leyes_por_producto01.php?TxtLeyes="+ValoresLeyes+"&Pantalla="+Pantalla;
		frm.submit();				
	}
}	
</script>

<title>Seleccion de Leyes e Impurezas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
</head>
<body><center>
<form name="FrmIngreso" method="post" action="">
<table width="600" height="228" border="0" cellpadding="5" class="tablaprincipal">
<td>
	<table width="600" border="0" cellpadding="0" class="ColorTabla01">
  	<tr>
              <td><div align="center"><strong>INGRESO DE LEYES</strong></div></td>
  	</tr>
	</table><br>
          <table width="600" border="0" cellpadding="0" class="TablaInterior">
            <tr> 
              <td width="185"><strong> 
                <input name="checkTodos" type="checkbox" onClick="JavaScript:activar();" value="">
                Todos </strong></td>
              <td width="381"><input name="BtnBorrar" type="SUBMIT"  value="Borrar"style="width:60">
			  	<?php
					echo "<input name='BtnOk' type='button'  value='Ok' style='width:60' onClick=Validar('$Pantalla');>";
				?>
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
	  			echo "<table width='600' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
				echo "<tr>";
				$cont=1;
				$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes = 0 order by  t1.abreviatura";
				$Resultado = mysqli_query($link, $Consulta);
				while ($Fila =mysqli_fetch_array($Resultado))
				{
			 		if($cont==5) 
					{
						echo '</tr>';
						echo '<tr>';
						$cont=1;
			    	}
					$Encontro=false;
					reset($Leyes);
					for ($i=0;$i<=count($Leyes);$i++)
					{
						if(isset($Fila["cod_leyes"])){
							$codleyes=$Fila["cod_leyes"];
						}else{
							$codleyes=0;
						}
						if(isset($Leyes[$i][0])){
							$leyess=$Leyes[$i][0];
						}else{
							$leyess=0;
						}
						//if ($Fila["cod_leyes"]== $Leyes[$i][0])
						if ($codleyes==$leyess)
						{
							$Ley=$Leyes[$i][0];
							//$Unidad=$Leyes[$i][1];
							$Encontro=true;
							break;
						}					
					}
					if ($Encontro== false)
     				{
						echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."'>".$Fila["abrev"];
						//echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";					
					}
					else
					{
						echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."' checked>".$Fila["abrev"];
						//echo "<input type ='hidden' name='TxtUnidad' value='$Unidad'>";
					}
					echo '</td>';
					$cont =$cont+ 1;
				}
				echo "</table>";
				?>
          	<br>
			<br>
	      
            <?php
				if ($Pantalla=='40')
				{
					echo "<table width='600' height='23' border='0' class='ColorTabla01' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
					echo "<tr>";
					echo "<td width='164' height='29'></td>";
					echo "<td width='251'><div align='center'>Impurezas</div></td>";
					echo "<td width='163'>&nbsp;</td>";
					echo "</tr>";
				  	echo "</table>";
					echo "<table width='600' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
					echo "<tr>";
					$cont=1;
						$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes =  1 order by  t1.abreviatura";
					$Resultado = mysqli_query($link, $Consulta);
					while ($Fila =mysqli_fetch_array($Resultado))
					{
						if($cont==5) 
						{
							echo '</tr>';
							echo '<tr>';
							$cont=1;
						}
						$Encontro=false;
						reset($Leyes);
						for ($i=0;$i<=count($Leyes);$i++)
						{
							if(isset($Fila["cod_leyes"])){
								$codleyes=$Fila["cod_leyes"];
							}else{
								$codleyes=0;
							}
							if(isset($Leyes[$i][0])){
								$leyess=$Leyes[$i][0];
							}else{
								$leyess=0;
							}

							//if ($Fila["cod_leyes"]== $Leyes[$i][0])
							if ($codleyes==$leyess)
							{
								$Ley=$Leyes[$i][0];
								//$Unidad=$Leyes[$i][1];
								$Encontro=true;
								break;
							}					
						}
						if ($Encontro== false)
						{
							echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."'>".$Fila["abrev"];
							//echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";					
						}
						else
						{
							echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."' checked>".$Fila["abrev"];
							//echo "<input type ='hidden' name='TxtUnidad' value='$Unidad'>";
						}
						echo '</td>';
						$cont =$cont+ 1;
					}
					echo "</table>";
				}	
				?>
          	<br>
			<br>
            <?php
				if ($Pantalla=='40')
				{
					echo "<table width='600' height='23' border='0' class='ColorTabla01' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
					echo "<tr>";
					echo "<td width='164' height='29'></td>";
					echo "<td width='251'><div align='center'>Leyes Fisicas</div></td>";
					echo "<td width='163'>&nbsp;</td>";
					echo "</tr>";
				  	echo "</table>";
					echo "<table width='600' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
					echo "<tr>";
					$cont=1;
					$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes =  3 order by  t1.abreviatura";
					$Resultado = mysqli_query($link, $Consulta);
					while ($Fila =mysqli_fetch_array($Resultado))
					{
						if($cont==5) 
						{
							echo '</tr>';
							echo '<tr>';
							$cont=1;
						}
						$Encontro=false;
						reset($Leyes);
						for ($i=0;$i<=count($Leyes);$i++)
						{
							if(isset($Fila["cod_leyes"])){
								$codleyes=$Fila["cod_leyes"];
							}else{
								$codleyes=0;
							}
							if(isset($Leyes[$i][0])){
								$leyess=$Leyes[$i][0];
							}else{
								$leyess=0;
							}

							//if ($Fila["cod_leyes"]== $Leyes[$i][0])
							if ($codleyes==$leyess)
							{
								$Ley=$Leyes[$i][0];
								//$Unidad=$Leyes[$i][1];
								$Encontro=true;
								break;
							}					
						}
						if ($Encontro== false)
						{
							echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."'>".$Fila["abrev"];
							//echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";					
						}
						else
						{
							echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."' checked>".$Fila["abrev"];
							//echo "<input type ='hidden' name='TxtUnidad' value='$Unidad'>";
						}
						echo '</td>';
						$cont =$cont+ 1;
					}
					echo "</table>";
				}	
				?>
</td>		  
</tr>
</table>

	<p>&nbsp; </p>

</form></center>
</body>
</html>
