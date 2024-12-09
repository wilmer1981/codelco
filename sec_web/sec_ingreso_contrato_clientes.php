<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 48;
	include("../principal/conectar_pac_web.php");
	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Mes      = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano      = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$estado   = isset($_REQUEST["estado"])?$_REQUEST["estado"]:"";
	$NumContrato    = isset($_REQUEST["NumContrato"])?$_REQUEST["NumContrato"]:"";
	$NumSubContrato = isset($_REQUEST["NumSubContrato"])?$_REQUEST["NumSubContrato"]:"";
	$prod     = isset($_REQUEST["prod"])?$_REQUEST["prod"]:"";
	$subprod  = isset($_REQUEST["subprod"])?$_REQUEST["subprod"]:"";
	
	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
	
	if($Proceso == "E")
	{
		$Consulta = "SELECT count(*) as num FROM sec_web.det_contrato WHERE num_contrato = '".$NumContrato."' AND num_subcontrato = '".$NumSubContrato."'";
		$rs = mysqli_query($link,$Consulta);
		$Fila = mysqli_fetch_array($rs);
		$num = $Fila["num"];
		if($num == 1)
		{
			$Eliminar = "DELETE FROM sec_web.contrato WHERE num_contrato = '".$NumContrato."' AND num_subcontrato = '".$NumSubContrato."'";
			mysqli_query($link,$Eliminar);
		}

		$Eliminar = "DELETE FROM sec_web.det_contrato WHERE num_contrato = '".$NumContrato."' AND num_subcontrato = '".$NumSubContrato."' AND cod_producto = $prod and cod_subproducto = $subprod";
		mysqli_query($link,$Eliminar);

		$Consulta = "SELECT distinct corr_ie FROM sec_web.det_contrato_por_ie WHERE num_contrato = ".$NumContrato;				
		$Consulta.= " AND num_subcontrato = ".$NumSubContrato;
		$Consulta.= " AND cod_producto = ".$prod;
		$Consulta.= " AND cod_subproducto = ".$subprod;
		$rs = mysqli_query($link,$Consulta);
		while($Fila = mysqli_fetch_array($rs))
		{
			$Eliminar = "DELETE FROM sec_web.programa_enami ";
			$Eliminar.= " WHERE tipo = 'V'";
			$Eliminar.= " AND corr_enm =".$Fila["corr_ie"];
			mysqli_query($link,$Eliminar);

			$Eliminar = "DELETE FROM sec_web.det_contrato_por_ie WHERE num_contrato = ".$NumContrato;				
			$Eliminar.= " AND num_subcontrato = ".$NumSubContrato;
			$Eliminar.= " AND corr_ie =".$Fila["corr_ie"];			
			mysqli_query($link,$Eliminar);

		}		
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
			Frm.action = "sec_ingreso_contrato_clientes.php?Proceso=B" ;
			Frm.submit();	
			break;

		case 2:
			Frm.action = "sec_ingreso_contrato_clientes.php" ;
			Frm.submit();	
			break;

		case "N":
			window.open("sec_ingreso_contrato_proceso.php?Proceso="+Proceso,"","top=20,left=180,width=590,height=490,scrollbars=no,resizable = no");
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
							NumContrato = Frm.elements[i+1].value;
							break;
						}
					}	
					window.open("sec_ingreso_contrato_proceso.php?Proceso=P&NumContrato="+NumContrato,"","top=20,left=180,width=590,height=490,scrollbars=no,resizable = no");
				}
			}
			break;

		case "S":

			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					for (i = 0; i < LargoForm; i++)
					{
						if ((Frm.elements[i].name == "CheckContrato") && (Frm.elements[i].checked == true))
						{
							Valores = "&NumContrato=" + Frm.elements[i+1].value + "&NumSubContrato=" + Frm.elements[i+2].value;
							break;
						}
					}	
					window.open("sec_ingreso_subcontrato_proceso.php?Proceso=P"+Valores,"","top=20,left=180,width=590,height=400,scrollbars=no,resizable = no");
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
								Valores = "&Contrato=" + Frm.elements[i+2].value + "&SubContrato=" + Frm.elements[i+3].value + "&producto=" + Frm.elements[i+4].value + "&subproducto=" + Frm.elements[i+5].value;
								if(Frm.elements[i+3].value == 0)
									window.open("sec_ingreso_contrato_proceso.php?Proceso=M"+Valores,"","top=20,left=180,width=590,height=490,scrollbars=no,resizable = no");		
								else
									window.open("sec_ingreso_subcontrato_proceso.php?Proceso=M"+Valores,"","top=20,left=180,width=590,height=400,scrollbars=no,resizable = no");		
								break;
							}
						}
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
								Valores = "&NumContrato=" + Frm.elements[i+2].value + "&NumSubContrato=" + Frm.elements[i+3].value + "&prod=" + Frm.elements[i+4].value + "&subprod=" + Frm.elements[i+5].value;
								break;
							}
						}

						Frm.action="sec_ingreso_contrato_clientes.php?Proceso=E"+Valores;
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
<title>Ingreso de Contrato</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngCliente" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td height="349" valign="top"><br>		
        <table width="759" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="150" class="Detalle02">Vigentes
			<?php
              if($estado == 'V')
				  echo '<input type="radio" name="estado" value="V" Checked onClick="MostrarPopupProceso(1)">';
			  else	
				  echo '<input type="radio" name="estado" value="V" onClick="MostrarPopupProceso(1)">';
			?></td>
			<td width="150" class="Detalle02">Cerrados
			<?php
              if($estado == 'C')
              	  echo '<input type="radio" name="estado" value="C" Checked onClick="MostrarPopupProceso(1)">';
			  else		
              	  echo '<input type="radio" name="estado" value="C" onClick="MostrarPopupProceso(1)">';
			?>
			</td>
			<td width="150" class="Detalle02">Todos
			<?php
              if($estado == 'T')
              	  echo '<input type="radio" name="estado" value="T" Checked onClick="MostrarPopupProceso(2)">';
			  else		
              	  echo '<input type="radio" name="estado" value="T" onClick="MostrarPopupProceso(2)">';
			?>
			</td>
			<td width="283" class="Detalle01">
			  <div align="center">
		      <input type="button" name="BtnNuevo" value="Nuevo" style="width:80" onClick="MostrarPopupProceso('N');">
		      <input type="button" name="BtnSubContrato" value="SubContrato" style="width:80" onClick="MostrarPopupProceso('S');">
		      <input type="button" name="BtnProducto" value="Agregar Prod" style="width:80" onClick="MostrarPopupProceso('P');">
		      </div></td>
		  </tr>
		  <tr>
			<td colspan="3">&nbsp;</td>
			<td class="Detalle01"><div align="center">
		      <input type="button" name="BtnModificar" value="Modificar" style="width:80" onClick="MostrarPopupProceso('M');">
		      <input type="button" name="BtnEliminar" value="Eliminar" style="width:80" onClick="MostrarPopupProceso('E');">
		      <input type="button" name="BtnSalir" value="Salir" style="width:80" onClick="Salir();">
		    </div></td>
		  </tr>
		</table><br>
		<?php
			echo "<table width='760' border='1' cellpadding='0' cellspacing='0'>";
			echo "<tr class='ColorTabla01'>";
			echo "<td width='3%' align='center'>&nbsp;</td>"; 
			echo "<td width='9%' align='center'>N° Cont.</td>";
			echo "<td width='16%' align='center'>Producto</td>";
			echo "<td width='10%' align='center'>Peso Contr</td>";
			echo "<td width='8%' align='center'>Saldo</td>";
			echo "<td width='9%' align='center'>Precio</td>";
			echo "<td width='14%' align='center'>Analisis Comer.</td>";
			echo "<td width='14%' align='center'>Analisis Imp.</td>";
			echo "<td width='5%' align='center'>Tran</td>";
			echo "<td width='5%' align='center'>Est</td>";
			echo "<td width='10%' align='center'>Fecha</td>";
			echo "</tr>";
			if(strlen($Mes) == 1)
				$Mes = '0'.$Mes;
				
			$Fecha = $Ano.'-'.$Mes;
			if($Proceso == "B")			
				$Consulta = "select * from sec_web.det_contrato WHERE vigente = '$estado' and num_subcontrato = 0 order by num_contrato";
			else
				$Consulta = "select * from sec_web.det_contrato WHERE num_subcontrato = 0 order by num_contrato";

			$Resultado=mysqli_query($link,$Consulta);
			echo "<input type='hidden' name='CheckContrato'><input type='hidden' name ='TxtCodigoO'>";
			$Cont2=0;
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Cont2++;
				echo "<tr>"; 
				echo "<td align='left'width='2%'><input type='radio' name='CheckContrato' value='checkbox'></td>";
				$Consulta = "SELECT t1.nombre_cliente as cliente FROM sec_web.cliente_venta as t1 Inner Join sec_web.contrato as t2"; 
				$Consulta = $Consulta." ON t1.cod_cliente = t2.cod_cliente WHERE t2.num_contrato = '".$Fila["num_contrato"]."'";
				//echo "Consulta 2:".$Consulta;
				$result = mysqli_query($link,$Consulta);
				$Fil = mysqli_fetch_array($result);				
				$Cliente = $Fil["cliente"];
		
				$Contrato=str_pad($Fila["num_contrato"],6,"0",STR_PAD_LEFT);
				$SubContrato=str_pad($Fila["num_subcontrato"],6,"0",STR_PAD_LEFT);
				echo "<td width='6%' align='left' onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");' bgcolor='#cccccc'>".$Contrato."&nbsp;<input type='hidden' name ='TxtCodigoO' value ='".$Fila["num_contrato"]."'>";
				echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:380px'>\n";
				echo "<font face='courier' color='#000000' size=1><b>Nro Contrato:&nbsp;</b>".$Contrato."</font><br>";
				echo "<font face='courier' color='#000000' size=1><b>Nombre Contrato:&nbsp;</b>".$Fila["nom_contrato"]."</font><br>";
				
				if($SubContrato != 0 && $SubContrato != '')
				    echo "<font face='courier' color='#000000' size=1><b>Nro SubContrato:&nbsp;</b>".$SubContrato."</font><br>";
				echo "<font face='courier' color='#000000' size=1><b>Cliente:&nbsp;</b>".$Cliente."</font><br>";
				$ie = '';
				$Consulta = "SELECT * FROM sec_web.det_contrato_por_ie WHERE num_contrato = ".$Fila["num_contrato"];				
				$Consulta.= " AND num_subcontrato = ".$Fila["num_subcontrato"];
				$Consulta.= " AND cod_producto = ".$Fila["cod_producto"];
				$Consulta.= " AND cod_subproducto = ".$Fila["cod_subproducto"];
				$Consulta.= " ORDER BY corr_ie";
				$result = mysqli_query($link,$Consulta);
				$peso_ie = 0;
				while ($Row = mysqli_fetch_array($result))
				{
					$ie = $ie.', '.$Row["corr_ie"]." = ".$Row["peso"];
					$peso_ie = $peso_ie + $Row["peso"];
                    
					if($Row["cod_sub_cliente"] != '')
					{
						$Consulta = "SELECT * FROM sec_web.sub_cliente_vta WHERE cod_cliente = '".$Fila["cod_cliente"]."' AND cod_sub_cliente = '".$Row["cod_sub_cliente"]."'";
						$result = mysqli_query($link,$Consulta);
						$Destino="";
						while($row = mysqli_fetch_array($result))
						{
						    $Destino = $Destino.', '.$row["direccion"];                      					
						}
					}	
				}
				$tope = strlen($ie);
				$tope2 = strlen($Destino);
				echo "<font face='courier' color='#000000' size=1><b>IE:&nbsp;</b>".substr($ie,1,$tope)."</font><br>";
				echo "<font face='courier' color='#000000' size=1><b>Destino:&nbsp;</b>".substr($Destino,1,$tope2)."</font><br>";
				if($Fila["confeccion"] == "G")
					$Confeccion = "Granel";
				if($Fila["confeccion"] == "L")
					$Confeccion = "Lote";
				echo "<font face='courier' color='#000000' size=1><b>Confección: </b>".$Confeccion."</font><br>";
				echo "</div></td>";				
				echo "<input type='hidden' name='Contrato' value='".$Fila["num_contrato"]."'>";
				echo "<input type='hidden' name='SubContrato' value='".$Fila["num_subcontrato"]."'>";
				echo "<input type='hidden' name='producto' value='".$Fila["cod_producto"]."'>";
				echo "<input type='hidden' name='subproducto' value='".$Fila["cod_subproducto"]."'>";
				$Consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = '".$Fila["cod_producto"]."' AND cod_subproducto = '".$Fila["cod_subproducto"]."'";
				$rs = mysqli_query($link,$Consulta);
				if($row = mysqli_fetch_array($rs))
				{
					$producto = $row["descripcion"];
				}

				echo "<td width='16%' align='left'>".$producto."&nbsp;</td>";
				echo "<td width='10%' align='right'>".$Fila["peso_vendido"]."&nbsp;Tons.&nbsp;".$Fila["estado_vendido"]."&nbsp;&nbsp;</td>";
				$Saldo = $Fila["peso_vendido"] - $peso_ie;
				echo "<td width='8%' align='right'>".$Saldo."&nbsp;Tons.&nbsp;&nbsp;</td>";
				echo "<td width='9%' align='right'>".$Fila["precio_compraventa"]."&nbsp;".$Fila["estado_compraventa"]."&nbsp;&nbsp;</td>";

				$StrLeyes = $Fila["analisis_comercial"];
				$Leyes= "";
				for ($j = 0;$j <= strlen($StrLeyes); $j++)
				{
					if (substr($StrLeyes,$j,2) == "//")
					{
						$LeyesUnidad = substr($StrLeyes,0,$j);
						for ($x=0;$x<=strlen($LeyesUnidad);$x++)
						{
							if (substr($LeyesUnidad,$x,2) == "~~")
							{
								$CodLeyes = substr($StrLeyes,0,$x);			
								$Consulta = "select abreviatura from proyecto_modernizacion.leyes where cod_leyes ='".$CodLeyes."'";
								$Rs= mysqli_query($link,$Consulta);
								while ($Fila2=mysqli_fetch_array($Rs))
								{
									$Leyes=$Leyes.$Fila2["abreviatura"]."-";
								}
							}
						}
						$StrLeyes = substr($StrLeyes,$j + 2);
						$j = 0;
					}
				}			
				echo "<td width='14%' align='left'>".$Leyes."&nbsp;</td>";
				$StrLeyes = "";
				$Leyes2="";
				$StrLeyes = $Fila["analisis_impurezas"];
				for ($j = 0;$j <= strlen($StrLeyes); $j++)
				{
					if (substr($StrLeyes,$j,2) == "//")
					{
						$LeyesUnidad = substr($StrLeyes,0,$j);
						for ($x=0;$x<=strlen($LeyesUnidad);$x++)
						{
							if (substr($LeyesUnidad,$x,2) == "~~")
							{
								$CodLeyes = substr($StrLeyes,0,$x);			
								$Consulta = "select abreviatura from proyecto_modernizacion.leyes where cod_leyes ='".$CodLeyes."'";
								$Rs= mysqli_query($link,$Consulta);
								while ($Fila2=mysqli_fetch_array($Rs))
								{
									$Leyes2=$Leyes2.$Fila2["abreviatura"]."-";
								}
							}
						}
						$StrLeyes = substr($StrLeyes,$j + 2);
						$j = 0;
					}
				}			
				echo "<td width='14%' align='left'>".$Leyes2."&nbsp;</td>";
				echo "<td width='5%' align='center'>".$Fila["transporte"]."&nbsp;</td>";
				echo "<td width='5%' align='center'>".$Fila["vigente"]."&nbsp;</td>";
				echo "<td width='10%' align='center'>".$Fila["fecha_contrato"]."&nbsp;</td>";
				echo "</tr>";
			}
			echo "</table>";
		?>
        <br>
      <br>      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if ($EncontroRelacion!="")
	{
		if ($EncontroRelacion==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Uno o mas Elementos no fueron eliminados por tener grupos asociados');";	
			echo "</script>";
		}
	}
?>
