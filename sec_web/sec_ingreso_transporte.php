<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 50;
	include("../principal/conectar_pac_web.php");
	
	if($Proceso == "E")
	{
		$Eliminar = "DELETE FROM sec_web.contrato_transporte WHERE num_cont_transporte = $Contrato AND num_contrato = $ContratoVent AND num_subcontrato = $SubContratoVent";
		mysqli_query($link, $Eliminar);
	}
?>
<html>
<head>
<script language="JavaScript">
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 100 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	
	{
		if (ie4) 
		{
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngCliente;
	var Valores="";

	for (i=1;i<Frm.CheckContrato.length;i++)
	{
		if (Frm.CheckContrato[i].checked==true)
		{
			Valores=Valores + Frm.TxtCodigoO[i].value+"//";
		}
	}
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmIngCliente;
	try
	{
		Frm.CheckContrato[0];
		for (i=1;i<Frm.CheckContrato.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckContrato[i].checked=true;
			}
			else
			{
				Frm.CheckContrato[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmIngCliente;
	var CantCheck=0;
	for (i=1;i<Frm.CheckContrato.length;i++)
	{
		if (Frm.CheckContrato[i].checked==true)
		{
			CantCheck=CantCheck+1;
		}
	}
	if (CantCheck > 1)
	{
		alert("Debe Seleccionar solo un Elemento");
		return(false);
	}
	else
	{
		return(true);
	}
}
function SeleccionoCheck()
{
	var Frm=document.FrmIngCliente;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckContrato.length;i++)
	{
		if (Frm.CheckContrato[i].checked==true)
		{
			Encontro=true;
			break;
		}
	}
	if (Encontro==false)
	{
		alert("Debe Seleccionar un Elemento");
		return(false);
	}
	else
	{
		return(true);
	}
}

function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmIngCliente;
	var Valores="";
	var NumContrato="";
	var Resp="";
	var LargoForm = Frm.elements.length;

	switch (Proceso)
	{

		case 1:
			Frm.action = "sec_ingreso_transporte.php?Proceso=B" ;
			Frm.submit();	
			break;

		case 2:
			Frm.action = "sec_ingreso_transporte.php" ;
			Frm.submit();	
			break;

		case "B":
			Frm.action = "sec_ingreso_transporte.php?Proceso=B" ;
			Frm.submit();	
			break;

		case "N":
			window.open("sec_ingreso_transporte_proceso.php?Proceso="+Proceso,"","top=60,left=180,width=530,height=420,scrollbars=no,resizable = no");
			break;

		case "P":

			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					for (i = 0; i < LargoForm; i++)
					{
						if ((Frm.elements[i].name == "CheckContrato") && (Frm.elements[i].checked == true))
						{
							Valores = "&Contrato=" + Frm.elements[i+1].value + "&ContratoVent=" + Frm.elements[i+2].value + "&SubContratoVent=" + Frm.elements[i+3].value;
							break;
						}
					}	
					window.open("sec_ingreso_transporte_proceso.php?Proceso=P"+Valores,"","top=60,left=180,width=530,height=420,scrollbars=no,resizable = no");
				}
			}
			break;

		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
						for (i = 0; i < LargoForm; i++)
						{
							if ((Frm.elements[i].name == "CheckContrato") && (Frm.elements[i].checked == true))
							{
								Valores = "&Contrato=" + Frm.elements[i+1].value + "&ContratoVent=" + Frm.elements[i+2].value;
								break;
							}
						}
						window.open("sec_ingreso_transporte_proceso.php?Proceso=M"+Valores,"","top=60,left=180,width=530,height=420,scrollbars=no,resizable = no");		
				}	
			}	
			break;
		case "E":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Resp=confirm("Esta seguro de Eliminar Los Datos");
					if (Resp==true)
					{

						for (i = 0; i < LargoForm; i++)
						{
							if ((Frm.elements[i].name == "CheckContrato") && (Frm.elements[i].checked == true))
							{
								Valores = "&Contrato=" + Frm.elements[i+1].value + "&ContratoVent=" + Frm.elements[i+2].value + "&SubContratoVent=" + Frm.elements[i+3].value;
								break;
							}
						}

						Frm.action="sec_ingreso_transporte.php?Proceso=E"+Valores;
						Frm.submit();
					}			
				}	
			}
			break;	
	} 
}

function Salir()
{
	var Frm=document.FrmIngCliente;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=46";
	Frm.submit();
}
</script>
<title>Ingreso Transporte</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style><body>
<form name="FrmIngCliente" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td valign="top" align="center"><br> 
		<table width='760' border='1' cellpadding='3' cellspacing='0'>
		  <tr> 
			<td width="229">&nbsp;</td>
			<td width="258">
              <?php
			if($estado != '')
			{					
			  echo "Vigentes";
              if($estado == 'V')
				  echo '<input type="radio" name="estado" value="V" Checked onClick="MostrarPopupProceso(1)">';
			  else	
				  echo '<input type="radio" name="estado" value="V" onClick="MostrarPopupProceso(1)">';

              echo "&nbsp;Cerrados&nbsp;&nbsp;&nbsp;&nbsp;";
              if($estado == 'C')
              	  echo '<input type="radio" name="estado" value="C" Checked onClick="MostrarPopupProceso(1)">';
			  else		
              	  echo '<input type="radio" name="estado" value="C" onClick="MostrarPopupProceso(1)">';

              echo "&nbsp;Todos&nbsp;&nbsp;&nbsp;&nbsp;";
              if($estado == 'T')
              	  echo '<input type="radio" name="estado" value="T" Checked onClick="MostrarPopupProceso(2)">';
			  else		
              	  echo '<input type="radio" name="estado" value="T" onClick="MostrarPopupProceso(2)">';
			}
			else
			{
			 echo 'Vigentes
                  <input type="radio" name="estado" value="V" onClick="MostrarPopupProceso(1)">
	              &nbsp;Cerrados&nbsp;&nbsp;&nbsp;&nbsp;
    	          <input type="radio" name="estado" value="C" onClick="MostrarPopupProceso(1)">
	              &nbsp;Todos&nbsp;&nbsp;&nbsp;&nbsp;
    	          <input type="radio" name="estado" value="T" onClick="MostrarPopupProceso(2)">';
            }
			?>
            </td>
            <td width="247">&nbsp; </td>			  
		  </tr>
		</table><br>
        <?php
			echo "<table width='760' border='1' cellpadding='0' cellspacing='0'>";
			echo "<tr class='ColorTabla01'>"; 
			echo "<td width='10%' align='center'>Cont Trasp.</td>";
			echo "<td width='9%' align='center'>Cont. Vent.</td>";
			echo "<td width='9%' align='center'>Peso Contr.</td>";
			echo "<td width='9%' align='center'>Saldo Peso</td>";
			echo "<td width='17%' align='center'>Nombre Transp</td>";
			echo "<td width='17%' align='center'>Representante</td>";
			echo "<td width='9%' align='center'>Tipo Contr.</td>";
			echo "<td width='9%' align='center'>Estado</td>";
			echo "<td width='10%' align='center'>Fecha</td>";
			echo "</tr>";
			if(strlen($Mes) == 1)
				$Mes = '0'.$Mes;
			$Fecha = $Ano.'-'.$Mes;
			if($Proceso == "B")			
				$Consulta = "SELECT * from sec_web.contrato_transporte WHERE vigente = '$estado' order by num_cont_transporte";
				
			else
				$Consulta = "SELECT * from sec_web.contrato_transporte order by num_cont_transporte";
			
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckContrato'><input type='hidden' name ='TxtCodigoO'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Cont2++;
				echo "<tr>"; 
				echo "<td align='left'width='2%'><input type='radio' name='CheckContrato' value='checkbox'></td>";
		
				$Contrato=str_pad($Fila["num_contrato"],6,"0",STR_PAD_LEFT);
				$Contrato_Transp=str_pad($Fila["num_cont_transporte"],6,"0",STR_PAD_LEFT);
				echo "<td width='7%' align='left' onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");' bgcolor='#cccccc'>".$Contrato_Transp;
				echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:350px'>\n";
				echo "<font face='courier' color='#000000' size=1><b>Nombre Contrato:&nbsp;</b>".$Fila["nombre_contrato"]."</font><br>";
				echo "<font face='courier' color='#000000' size=1><b>Nro SubContrato Vent:&nbsp;</b>".str_pad($Fila["num_subcontrato"],6,"0",STR_PAD_LEFT)."</font><br>";
				$Consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = $Fila["cod_producto"] AND cod_subproducto = $Fila["cod_subproducto"]";
				$result = mysqli_query($link, $Consulta);
				$row = mysqli_fetch_array($result);
				echo "<font face='courier' color='#000000' size=1><b>Producto:&nbsp;</b>".$row["descripcion"]."</font><br>";
				echo "</td>";				
	
				echo "<td width='9%' align='left'>".$Contrato."</td>";				
				echo "<input type='hidden' name='Contrato' value='".$Fila[num_cont_transporte]."'>";
				echo "<input type='hidden' name='ContratoVent' value='".$Fila["num_contrato"]."'>";
				echo "<input type='hidden' name='SubContratoVent' value='".$Fila["num_subcontrato"]."'>";

				//Saldos
				$Consulta = "SELECT * FROM sec_web.det_contrato WHERE num_contrato = $Contrato AND vigente = 'V'";
				$res = mysqli_query($link, $Consulta);
				if($row = mysqli_fetch_array($res))
				{
					$SubContrato = $row["num_subcontrato"];					
					$Producto = $row["cod_producto"];					
					$SubProducto = $row["cod_subproducto"];					
				}

				$peso = '';
				$Consulta = "SELECT * FROM sec_web.det_contrato WHERE num_contrato = ".$Contrato;				
				$Consulta.= " AND num_subcontrato = ".$SubContrato;
				$Consulta.= " AND cod_producto = ".$Producto;
				$Consulta.= " AND cod_subproducto = ".$SubProducto;
				$result = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($result))
				{
					$peso = $peso + $Row[peso_vendido];
				}
				echo "<td width='9%' align='left'>".$Fila[peso_venta]."&nbsp;&nbsp;".$Fila[estado_peso]."</td>";
				$Saldo = $peso - $Fila[peso_venta];
				echo "<td width='9%' align='left'>".$Saldo."&nbsp;</td>";

				$Consulta = "SELECT nombre_transportista FROM sec_web.transporte WHERE rut_transportista = '$Fila[transportista]'";
				$Rs = mysqli_query($link, $Consulta);
				$Fila1 = mysqli_fetch_array($Rs);
				$Transportista = $Fila1[nombre_transportista];				

				echo "<td width='17%'>".$Transportista."</td>";
				echo "<td width='17%' align='left'>".$Fila["representante"]."</td>";
				echo "<td width='9%' align='center'>".$Fila["tipo_contrato"]."&nbsp;</td>";
				echo "<td width='9%' align='center'>".$Fila["vigente"]."&nbsp;</td>";
				echo "<td width='10%' align='center'>".$Fila["fecha_contrato"]."</td>";
				echo "</tr>";
			}
			echo "</table>";
			echo "</div>";
		?>
        <br>
        <table width="760" border="0" class="tablainterior">
          <tr> 
            <td align="center"> <input type="button" name="BtnNuevo" value="Nuevo" style="width:60" onClick="MostrarPopupProceso('N');"> 
              <input type="button" name="BtnContrato" value="Agregar Cont Venta" style="width:120" onClick="MostrarPopupProceso('P');"> 
              <input type="button" name="BtnModificar" value="Modificar" style="width:60" onClick="MostrarPopupProceso('M');"> 
              <input type="button" name="BtnEliminar" value="Eliminar" style="width:60" onClick="MostrarPopupProceso('E');"> 
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();"></td>
          </tr>
        </table>
        <br>
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if (isset($EncontroRelacion))
	{
		if ($EncontroRelacion==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Uno o mas Elementos no fueron eliminados por tener grupos asociados');";	
			echo "</script>";
		}
	}
?>
