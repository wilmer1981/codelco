<?php
	include("../principal/conectar_principal.php");
	
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
		if ((frm.elements[i].name == "checkLeyes") || (frm.elements[i].name == "checkImpurezas"))
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
		for (i=0; i< LargoForm; i++ )
		{
		if (frm.elements[i].name == "checkLeyes")
			{
			if (frm.checkLey.checked == true)
				{
					frm.elements[i].checked = true;
				}
			}
		}
		for (i=0; i< LargoForm; i++ )
		{
		if (frm.elements[i].name == "checkImpurezas")
			{
			if (frm.checkImp.checked == true)
				{
					frm.elements[i].checked = true;
				}
			}
		}
}	
function Validar(valores,Personalizar,Producto,SubProducto,NombrePlantilla,CodPlantilla)
{
	var frm=document.FrmIngreso;
	var LargoForm = frm.elements.length;
    var checkeoLeyes=false;
	var checkeoImpurezas=false;
	var ValoresLeyes="";
	var ValoresImpurezas="";
	var Unidades= "";
	

	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name == "checkLeyes") && (frm.elements[i].checked == true))
			{
			checkeoLeyes= true;
			//ValoresChequeados = ValoresChequeados + frm.elements[i].value + "//";
			ValoresLeyes = ValoresLeyes + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
		if ((frm.elements[i].name == "checkImpurezas") && (frm.elements[i].checked == true))
			{
			checkeoImpurezas=true;
			ValoresImpurezas = ValoresImpurezas + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
	
	}
	/*if (CodPlantilla=="")
	{
		if (checkeoLeyes==false) 
		{
			alert("Debe ingresar una ley");
			return;
		}
	}*/	
	frm.action="cal_leyes_quimico201.php?ValoresLeyes=" + ValoresLeyes + "&ValoresImpurezas=" + ValoresImpurezas+ "&Personalizar=" +Personalizar+"&Producto="+Producto+"&SubProducto="+SubProducto+"&NombrePlantilla="+NombrePlantilla+"&CodPlantilla="+CodPlantilla;
	frm.submit();				
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
                <input name="BtnOk" type="button"  value="Ok" style="width:60" onClick="JavaScript:Validar('<?php echo $Valores;?>','<?php echo $Personalizar;?>','<?php echo $Producto;?>','<?php echo $SubProducto;?>','<?php echo $NombrePlantilla;?>','<?php echo $CodPlantilla;?>');">
                <input name="BtnSalir" type="Button"  value="Salir" style="width:60" onClick="JavaScript:window.close();"></td>
            </tr>
          </table><br>

	      <table width="600" height="23" border="0" class="ColorTabla01" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <tr> 
              <td width="164" height="29" ><div align="left"><strong> 
                  <input name="checkLey" type="checkbox" id="checkLey" onClick="JavaScript:activar();" value="">
                  </strong>Todos</div></td>
              <td width="251" ><div align="center">Leyes</div></td>
              <td width="163" >&nbsp;</td>
            </tr>
          </table>
          <table width="600" height="15" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <?php
	  			echo"<tr>";
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
     				echo "<td align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."'>".$Fila[abrev];
					echo "<select name='CmbUnidad' style='width:80' align='right'>";
					$Consulta = "select * from unidades";
					$Resultado2 = mysqli_query($link, $Consulta);
					while ($Fila2 =mysqli_fetch_array($Resultado2))
						{
							if ($Fila[cod_unidad] == $Fila2[cod_unidad])
							{
								echo"<option value='".$Fila2[cod_unidad]."' selected>".$Fila2["abreviatura"]."</option>";
							}
							else
							{
								echo"<option value='".$Fila2[cod_unidad]."'>".$Fila2["abreviatura"]."</option>";
							}							
						}
					echo "</select></td>";
					$cont =$cont+ 1;
				}
				?>
          </table><br>
          <table width="600" class="ColorTabla01" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <tr> 
              <td width="164" height="23"><div align="left"><strong> 
                  <input name="checkImp" type="checkbox" id="checkImp" onClick="JavaScript:activar();" value="">
                  </strong>Todos<strong></strong></div></td>
              <td width="252"><div align="center">Impurezas</div></td>
              <td width="162">&nbsp;</td>
            </tr>
          </table>
		  <table width="600" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
   	<?php
					
	  			echo"<tr>";
				$cont=1;	 
				$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes = 1 order by  t1.abreviatura";
				$Resultado = mysqli_query($link, $Consulta);
				while ($Fila =mysqli_fetch_array($Resultado))
				{
			 		if($cont==5) 
					{
						echo '</tr>';
						echo '<tr>';
						$cont=1;
			    	}
     				echo "<td align='left'><input type='checkbox' name ='checkImpurezas' value='".$Fila["cod_leyes"]."'>".$Fila[abrev];		
					echo "<select name='CmbUnidad' style='width:80' align='right'>";
					$Consulta = "select * from unidades";
					$Resultado2 = mysqli_query($link, $Consulta);
					while ($Fila2 =mysqli_fetch_array($Resultado2))
						{
							if ($Fila[cod_unidad] == $Fila2[cod_unidad])
							{
								echo"<option value='".$Fila2[cod_unidad]."' selected>".$Fila2["abreviatura"]."</option>";
							}
							else
							{
								echo"<option value='".$Fila2[cod_unidad]."'>".$Fila2["abreviatura"]."</option>";
							}							
						}
					echo "</select></td>";
					$cont =$cont+ 1;
				}
				?>
		  </table>
</td>		  
</tr>
</table>

	<p>&nbsp; </p>

</form></center>
</body>
</html>
