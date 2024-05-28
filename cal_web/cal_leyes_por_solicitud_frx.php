<?php
	include("../principal/conectar_principal.php");
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
				if ((frm.elements[i].name == "checkLeyes") || (frm.elements[i].name == "checkImpurezas"))
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
	}			
}	

function Validar(valores,Personalizar,Productos,SubProducto,NombrePlantilla,CodPlantilla,Modificando)
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
	if (Personalizar=='S')
	{
		frm.action="cal_leyes_por_solicitud_frx01.php?ValoresLeyes=" + ValoresLeyes + "&ValoresImpurezas=" + ValoresImpurezas+ "&ValoresLeyesFisicas=" + ValoresLeyesFisicas+"&Personalizar=" +Personalizar+"&Productos="+Productos+"&SubProducto="+SubProducto+"&NombrePlantilla="+NombrePlantilla+"&CodPlantilla="+CodPlantilla;
		frm.submit();				
	}
	else
	{
		frm.action="cal_leyes_por_solicitud_frx01.php?ValoresLeyes=" + ValoresLeyes + "&ValoresImpurezas=" + ValoresImpurezas+ "&ValoresLeyesFisicas=" + ValoresLeyesFisicas+ "&Muestras=" + valores+"&Modificando="+Modificando+"&Productos="+Productos+"&SubProducto="+SubProducto;
		frm.submit();				
	}	
}	
function ValidarAux(valores,SolAut,Productos,SubProducto,BuscarDetalle,BuscarPrv,CmbRutPrv,Modificando)
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
	frm.action="cal_leyes_por_solicitud_frx01.php?Muestras="+valores+"&ValoresLeyes="+ValoresLeyes+"&ValoresImpurezas="+ValoresImpurezas+"&SolAut="+SolAut+"&Productos="+Productos+"&SubProducto="+SubProducto+"&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&CmbRutPrv="+CmbRutPrv+"&Modificando="+Modificando;
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
                <input name="checkTodos" type="checkbox" onClick="JavaScript:activar('1');" value="">
                Todos </strong></td>
              <td width="381"><input name="BtnBorrar" type="SUBMIT"  value="Borrar"style="width:60">
			  	<?php
                	if (!isset($SolAut))
					{
						echo "<input name='BtnOk' type='button'  value='Ok' style='width:60' onClick=\"Validar('$Valores','$Personalizar','$Productos','$SubProducto','$NombrePlantilla','$CodPlantilla','$Modificando');\">";
					}
					else
					{
						echo "<input name='BtnOk' type='button'  value='Ok' style='width:60' onClick=\"ValidarAux('$Valores','$SolAut','$Productos','$SubProducto','$BuscarDetalle','$BuscarPrv','$CmbRutPrv','$Modificando');\">";
					}	
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
     				echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."'>".$Fila["abrev"];
					echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";
					echo '</td>';
					$cont =$cont+ 1;
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
				echo "<td width='150' align='left'><input type='checkbox' name ='checkImpurezas' value='".$Fila["cod_leyes"]."'>".$Fila["abrev"];		
				echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";
				
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
