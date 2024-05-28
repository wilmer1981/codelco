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
		////
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
function Validar(valores,Personalizar,Productos,SubProducto,NombrePlantilla,CodPlantilla,Modificando)
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
			ValoresLeyes = ValoresLeyes + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
		}
	}
	if (Personalizar=='S')
	{
		frm.action="cal_leyes_por_solicitud01.php?ValoresLeyes=" + ValoresLeyes + "&Personalizar=" +Personalizar+"&Producto="+Producto+"&SubProducto="+SubProducto+"&NombrePlantilla="+NombrePlantilla+"&CodPlantilla="+CodPlantilla;
		frm.submit();				
	}
	else
	{
		frm.action="cal_leyes_por_solicitud01.php?ValoresLeyes=" + ValoresLeyes + "&Muestras=" + valores+"&Modificando="+Modificando+"&Productos="+Productos+"&SubProducto="+SubProducto;
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
	
	}
	frm.action="cal_leyes_por_solicitud01.php?Muestras="+valores+"&ValoresLeyes="+ValoresLeyes+"&ValoresImpurezas="+ValoresImpurezas+"&SolAut="+SolAut+"&Productos="+Productos+"&SubProducto="+SubProducto+"&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&CmbRutPrv="+CmbRutPrv+"&Modificando="+Modificando;
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
			  	<?php
                	if (!isset($SolAut))
					{
						echo "<input name='BtnOk' type='button'  value='Ok' style='width:60' onClick=\"Validar('$Valores','$Personalizar','$Productos','$SubProducto','$NombrePlantilla','$CodPlantilla','$Modificando');\">";
					}
					else
					{
						echo "<input name='BtnOk' type='button'  value='Ok' style='width:60' onClick=\"ValidarAux('$Valores','$SolAut','$CmbProductos','$CmbSubProducto','$BuscarDetalle','$BuscarPrv','$CmbRutPrv','$Modificando');\">";
					}	
                ?>
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
          <table width="600" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
             <?php
	  			echo"<tr>";
				$cont=1;	 
				$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes = 3 order by t1.abreviatura";
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
			?>
          </table>
</td>		  
</tr>
</table>
</form></center>
</body>
</html>
