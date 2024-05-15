<?php
	include("../principal/conectar_principal.php");
	$CookieRut=$_COOKIE["CookieRut"];
	$Rut=$CookieRut;
	$Leyes=array();
	$Impurezas=array();
	$i=0;
	$f=0;

	if(isset($_REQUEST["Sol"])) {
		$Sol = $_REQUEST["Sol"];
	}else{
		$Sol = "";
	}
	if(isset($_REQUEST["Rec"])) {
		$Rec = $_REQUEST["Rec"];
	}else{
		$Rec = "";
	}

	if ($Rec == 'N')
	{
		$Consulta ="select t1.rut_funcionario,t1.cod_leyes,t1.cod_unidad from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
		$Consulta=$Consulta."on t1.cod_leyes=t2.cod_leyes and (t2.tipo_leyes=0 or t2.tipo_leyes=3)  where t1.nro_solicitud = '".$Sol."'";// and isnull(t1.valor)";
		$Respuesta=mysqli_query($link, $Consulta);
		while ($Fila1=mysqli_fetch_array($Respuesta))
		{
			$Leyes[$i][0]=$Fila1["cod_leyes"];
			$Leyes[$i][1]=$Fila1["cod_unidad"];
			$Rut=$Fila1["rut_funcionario"];
			$i++;
		}
		$Consulta ="select t1.rut_funcionario,t1.cod_leyes,t1.cod_unidad from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
		$Consulta=$Consulta."on t1.cod_leyes=t2.cod_leyes and t2.tipo_leyes=1 where t1.nro_solicitud = '".$Sol."'";// and isnull(t1.valor)";
		$Respuesta=mysqli_query($link, $Consulta);
		while ($Fila1=mysqli_fetch_array($Respuesta))
		{
			$Impurezas[$f][0]=$Fila1["cod_leyes"];
			$Impurezas[$f][1]=$Fila1["cod_unidad"];
			$Rut=$Fila1["rut_funcionario"];
			$f++;
		}
	}
	else 
	{
		$Consulta ="select t1.rut_funcionario,t1.cod_leyes,t1.cod_unidad from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
		$Consulta=$Consulta."on t1.cod_leyes=t2.cod_leyes and (t2.tipo_leyes=0 or t2.tipo_leyes=3)  where t1.nro_solicitud = '".$Sol."' and t1.recargo='".$Rec."'";// and isnull(t1.valor)";
		$Respuesta=mysqli_query($link, $Consulta);
		while ($Fila1=mysqli_fetch_array($Respuesta))
		{
			$Leyes[$i][0]=$Fila1["cod_leyes"];
			$Leyes[$i][1]=$Fila1["cod_unidad"];
			$Rut=$Fila1["rut_funcionario"];
			$i++;
		}
		$Consulta ="select t1.rut_funcionario,t1.cod_leyes,t1.cod_unidad from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
		$Consulta=$Consulta."on t1.cod_leyes=t2.cod_leyes and t2.tipo_leyes=1 where t1.nro_solicitud = '".$Sol."' and t1.recargo='".$Rec."'";// and isnull(t1.valor)";
		$Respuesta=mysqli_query($link, $Consulta);
		while ($Fila1=mysqli_fetch_array($Respuesta))
		{
			$Impurezas[$f][0]=$Fila1["cod_leyes"];
			$Impurezas[$f][1]=$Fila1["cod_unidad"];
			$Rut=$Fila1["rut_funcionario"];
			$f++;
		}
	}
?>
<html>
<head>
<script language="JavaScript">
function activar(Opcion)
{
	var frm=document.FrmIngreso;
	var LargoForm = frm.elements.length;
	
	switch (Opcion)
	{
		case "1":
		
			for (i=0;i < LargoForm;i++)
			{
				if ((frm.elements[i].name == "checkLeyes") || (frm.elements[i].name == "checkImpurezas")|| (frm.elements[i].name == "checkFisicas"))
				{
					if (frm.checkTodos.checked == true)
					{
						frm.elements[i].checked = true;
						/*frm.checkLey.checked == true;
						frm.checkImp.checked == true;
						frm.checkFis.checked == true;*/
					}
					else
					{
						frm.elements[i].checked = false;
						/*frm.checkLey.checked == false;
						frm.checkImp.checked == false;
						frm.checkFis.checked == false;*/
					}
				}
			}
			break;
		case "2":
			for (i=0; i< LargoForm; i++ )
			{
				if (frm.elements[i].name == "checkLeyes")
				{
					if (frm.checkLey.checked == true)
					{
						frm.elements[i].checked = true;
					}
					else
					{
						frm.elements[i].checked = false;
					}
				}
			}
			break;
		case "3":
			for (i=0; i< LargoForm; i++ )
			{
				if (frm.elements[i].name == "checkImpurezas")
				{
					if (frm.checkImp.checked == true)
					{
						frm.elements[i].checked = true;
					}
					else
					{
						frm.elements[i].checked = false;
					}
				}
			}
			break;
		case "4":	
			for (i=0; i< LargoForm; i++ )
			{
				if (frm.elements[i].name == "checkFisicas")
				{
					if (frm.checkFis.checked == true)
					{
						frm.elements[i].checked = true;
					}
					else
					{
						frm.elements[i].checked = false;
					}
				}
			}
			break;
	}			
}	
function Grabar(Sol,Recargo)
{
	var frm=document.FrmIngreso;
	var LargoForm = frm.elements.length;
    var checkeoLeyes=false;
	var checkeoImpurezas=false;
	var checkeoLeyesFisicas=false;
	var ValoresLeyes="";
	var ValoresImpurezas="";
	var ValoresLeyesFisicas="";
	var Unidades= "";

	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name == "checkLeyes") && (frm.elements[i].checked == true))
			{
			checkeoLeyes= true;
			ValoresLeyes = ValoresLeyes + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
		if ((frm.elements[i].name == "checkImpurezas") && (frm.elements[i].checked == true))
			{
			checkeoImpurezas=true;
			ValoresImpurezas = ValoresImpurezas + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
		if ((frm.elements[i].name == "checkFisicas") && (frm.elements[i].checked == true))
			{
			checkeoLeyesFisicas=true;
			ValoresLeyesFisicas = ValoresLeyesFisicas + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
	}
	if ((checkeoLeyes==false)&&(checkeoImpurezas == false)&& (checkeoLeyesFisicas == false))
	{
		alert ("Debe Seleccionar alguna Ley ");
		return;
	}
	else
	{
		frm.action="cal_leyes_por_solicitud_modificar01.php?Sol="+Sol +"&Rec="+Recargo +"&ValoresLeyes="+ValoresLeyes+"&ValoresImpurezas="+ValoresImpurezas+"&ValoresLeyesFisicas="+ValoresLeyesFisicas+"&Opcion=3";
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
                <input name="checkTodos" type="checkbox" onClick="JavaScript:activar('1');" value="">
                Todos </strong></td>
              <td width="381"><input name="BtnBorrar" type="SUBMIT"  value="Borrar"style="width:60">
			  	<?php
					echo "<input name='BtnOk' type='button'  value='Ok' style='width:60' onClick=\"Grabar('$Sol','$Rec');\">";				
				?>
				<input name="BtnSalir" type="Button"  value="Salir" style="width:60" onClick="JavaScript:window.close();"></td>
            </tr>
          </table><br>

	      <table width="600" height="23" border="0" class="ColorTabla01" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <tr> 
              <td width="164" height="29" ><div align="left"><strong> 
                  <input name="checkLey" type="checkbox" id="checkLey" onClick="JavaScript:activar('2');" value="">
                  </strong>Todos</div></td>
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
					$MostrarLeyes=true;
					$EncontroLey=false;
					reset($Leyes);
					for ($i=0;$i<count($Leyes);$i++)
					{
						if ($Fila["cod_leyes"]==$Leyes[$i][0])
						{
							if ($Rec=='N')
							{
								$Consulta="select valor from cal_web.leyes_por_solicitud where nro_solicitud =".$Sol." and cod_leyes='".$Fila["cod_leyes"]."'";
							}
							else
							{
								$Consulta="select valor from cal_web.leyes_por_solicitud where nro_solicitud =".$Sol." and recargo='".$Rec."' and cod_leyes='".$Fila["cod_leyes"]."'";
							}	
							$Respuesta=mysqli_query($link, $Consulta);
							$FilaValor=mysqli_fetch_array($Respuesta);
							/*if (!is_null($FilaValor["valor"]))
							{
								$MostrarLeyes=false;
							}*/
							$Ley=$Leyes[$i][0];
							$Unidad=$Leyes[$i][1];
							$EncontroLey=true;
							break;
						}
					}
					if ($MostrarLeyes==true)
					{
						if ($EncontroLey==false)
						{
							echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."'>".$Fila[abrev];
							echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";					
						}
						else
						{
							echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."' checked>".$Fila[abrev];
							echo "<input type ='hidden' name='TxtUnidad' value='$Unidad'>";
						}
						$cont =$cont+ 1;
					}	
					echo '</td>';
				}
				echo "</table>";
				?>
          <br>
          <table width="600" class="ColorTabla01" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <tr> 
              <td width="164" height="23"><div align="left"><strong> 
                  <input name="checkImp" type="checkbox" id="checkImp" onClick="JavaScript:activar('3');" value="">
                  </strong>Todos<strong></strong></div></td>
              <td width="252"><div align="center">Impurezas</div></td>
              <td width="162">&nbsp;</td>
            </tr>
          </table>
		  
   		  <?php
			echo "<table width='600' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
			echo"<tr>";
			$cont=1;	 
			$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes = 1 order by t1.abreviatura";
			$Resultado = mysqli_query($link, $Consulta);
			while ($Fila =mysqli_fetch_array($Resultado))
			{
				if($cont==5) 
				{
					echo '</tr>';
					echo '<tr>';
					$cont=1;
				}
				$MostrarLeyes=true;
				$EncontroLey=false;
				reset($Impurezas);
				for ($i=0;$i<count($Impurezas);$i++)
				{
					if ($Fila["cod_leyes"]== $Impurezas[$i][0])
					{
						if ($Rec=='N')
						{
							$Consulta="select valor from cal_web.leyes_por_solicitud where nro_solicitud =".$Sol." and cod_leyes='".$Fila["cod_leyes"]."'";
						}
						else
						{
							$Consulta="select valor from cal_web.leyes_por_solicitud where nro_solicitud =".$Sol." and recargo='".$Rec."' and cod_leyes='".$Fila["cod_leyes"]."'";
						}	
						$Respuesta=mysqli_query($link, $Consulta);
						$FilaValor=mysqli_fetch_array($Respuesta);
						/*if (!is_null($FilaValor["valor"]))
						{
							$MostrarLeyes=false;
						}*/
						$Unidad=$Impurezas[$i][1];
						$EncontroLey=true;
						break;
					}
				}
				if ($MostrarLeyes==true)
				{
					if ($EncontroLey == false)
					{
						echo "<td width='150' align='left'><input type='checkbox' name ='checkImpurezas' value='".$Fila["cod_leyes"]."'>".$Fila[abrev];		
						echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";
					}
					else
					{
						echo "<td width='150' align='left'><input type='checkbox' name ='checkImpurezas' value='".$Fila["cod_leyes"]."' checked>".$Fila[abrev];						
						echo "<input type ='hidden' name='TxtUnidad' value='$Unidad'>";
					}
					$cont =$cont+ 1;
				}	
				echo "</td>";
			}
    		echo"</table>";
		 ?>
          <table width="600" class="ColorTabla01" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <tr> 
              <td width="164" height="23"><div align="left"><strong> 
                  <input name="checkFis" type="checkbox" onClick="JavaScript:activar('4');" value="">
                  </strong>Todos<strong></strong></div></td>
              <td width="252"><div align="center">Leyes Fisicas</div></td>
              <td width="162">&nbsp;</td>
            </tr>
          </table>
		  
   		  <?php
			echo "<table width='600' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
			echo"<tr>";
			$cont=1;	 
			$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes =3 order by t1.abreviatura";
			$Resultado = mysqli_query($link, $Consulta);
			while ($Fila =mysqli_fetch_array($Resultado))
			{
				if($cont==5) 
				{
					echo '</tr>';
					echo '<tr>';
					$cont=1;
				}
				$MostrarLeyes=true;
				$EncontroLey=false;
				reset($Leyes);
				for ($i=0;$i<count($Leyes);$i++)
				{
					if ($Fila["cod_leyes"]== $Leyes[$i][0])
					{
						if ($Rec=='N')
						{
							$Consulta="select valor from cal_web.leyes_por_solicitud where nro_solicitud =".$Sol." and cod_leyes='".$Fila["cod_leyes"]."'";
						}
						else
						{
							$Consulta="select valor from cal_web.leyes_por_solicitud where nro_solicitud =".$Sol." and recargo='".$Rec."' and cod_leyes='".$Fila["cod_leyes"]."'";
						}	
						$Respuesta=mysqli_query($link, $Consulta);
						$FilaValor=mysqli_fetch_array($Respuesta);
						if (!is_null($FilaValor["valor"]))
						{
							$MostrarLeyes=false;
						}
						$Unidad=$Leyes[$i][1];
						$EncontroLey=true;
						break;
					}
				}
				if ($MostrarLeyes==true)
				{
					if ($EncontroLey == false)
					{
						echo "<td width='150' align='left'><input type='checkbox' name ='checkFisicas' value='".$Fila["cod_leyes"]."'>".$Fila[abrev];		
						echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";
					}
					else
					{
						echo "<td width='150' align='left'><input type='checkbox' name ='checkFisicas' value='".$Fila["cod_leyes"]."' checked>".$Fila[abrev];		
						echo "<input type ='hidden' name='TxtUnidad' value='$Unidad'>";
					}
					$cont =$cont+ 1;
				}	
				echo "</td>";
			}
    		echo"</table>";
		 ?>
		  
</td>		  
</tr>
</table>
</form></center>
</body>
</html>
