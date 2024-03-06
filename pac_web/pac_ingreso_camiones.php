<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 3;
	include("../principal/conectar_pac_web.php");

	$EncontroRelacion  = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
	$CmbTransporte  = isset($_REQUEST["CmbTransporte"])?$_REQUEST["CmbTransporte"]:"";
	
?>
<html>
<head>
<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
	//alert(numero);
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 355 ");
			//eval("Txt" + numero + ".style.top = document.checkTodos.top ");
			//eval("Txt" + numero + ".style.top = window.event.y ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngCamiones;
	var Valores="";

	for (i=1;i<Frm.CheckPatente.length;i++)
	{
		if (Frm.CheckPatente[i].checked==true)
		{
			Valores=Valores + Frm.TxtPatenteO[i].value+"//";
		}
	}
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmIngCamiones;
	try
	{
		Frm.CheckPatente[0];
		for (i=1;i<Frm.CheckPatente.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckPatente[i].checked=true;
			}
			else
			{
				Frm.CheckPatente[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmIngCamiones;
	var CantCheck=0;
	for (i=1;i<Frm.CheckPatente.length;i++)
	{
		if (Frm.CheckPatente[i].checked==true)
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
	var Frm=document.FrmIngCamiones;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckPatente.length;i++)
	{
		if (Frm.CheckPatente[i].checked==true)
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
	var Frm=document.FrmIngCamiones;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("pac_ingreso_camiones_proceso.php?Proceso="+Proceso,"","top=60,left=180,width=415,height=385,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("pac_ingreso_camiones_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=50,left=180,width=415,height=385,scrollbars=no,resizable = no");		
				}	
			}	
			break;
		case "E":
			if (SeleccionoCheck()) 
			{
				Resp=confirm("Esta seguro de Eliminar los Datos Seleccionados");
				if (Resp==true)
				{
					Valores=RecuperarValoresCheckeado();
					Frm.action="pac_ingreso_camiones_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}
function Recarga()
{
	var Frm=document.FrmIngCamiones;

	Frm.action="pac_ingreso_camiones.php?CmbTransporte="+Frm.CmbTransporte.value;
	Frm.submit();
	
}
function Salir()
{
	var Frm=document.FrmIngCamiones;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=21";
	Frm.submit();
}
</script>
<title>Ingreso de Transporte</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngCamiones" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
	<tr>
	  <td align="center">Tipo Transporte
		  <?php
		  	echo "<select name ='CmbTransporte' style='width:120' onChange='Recarga();'>";
		  	if (isset($CmbTransporte))
			{
				switch ($CmbTransporte)
				{
					case "-1";
						echo "<option value='-1' selected>Todos</option>";
						echo "<option value='C'>Camion</option>";
						echo "<option value='R'>Rampla</option>";
						echo "<option value='B'>Buque</option>";
						break;
					case "C";
						echo "<option value='-1'>Todos</option>";
						echo "<option value='C'selected>Camion</option>";
						echo "<option value='R'>Rampla</option>";
						echo "<option value='B'>Buque</option>";
						break;
					case "B";
						echo "<option value='-1'>Todos</option>";
						echo "<option value='C'>Camion</option>";
						echo "<option value='R'>Rampla</option>";
						echo "<option value='B' selected>Buque</option>";
						break;
					case "R":
						echo "<option value='-1'>Todos</option>";
						echo "<option value='C'>Camion</option>";
						echo "<option value='R' selected>Rampla</option>";
						echo "<option value='B' >Buque</option>";
				}	
			}	
			else
			{
				echo "<option value='-1' selected>Todos</option>";
				echo "<option value='C'>Camion</option>";
				echo "<option value='R'>Rampla</option>";
				echo "<option value='B'>Buque</option>";
			}
		  	echo "</select>";
	      ?>	
	  </td>
	</tr>
    <tr>
      <td align="center" valign="top"><br> 
        <?php
			echo "<table width='750' border='1' cellpadding='3' cellspacing='0' >";
			echo "<tr class='ColorTabla01'>"; 
			echo "<td width='10'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
			echo "<td width='250' align='left'>Transportista</td>";
			echo "<td width='60' align='left'>Patente</td>";
			echo "<td width='60' align='left'>Transporte</td>";
			//echo "<td width='70' align='left'>Marca</td>";
			//echo "<td width='70' align='center'>Modelo</td>";
			//echo "<td width='40' align='center'>A�o</td>";
			echo "<td width='50' align='center'>Carga</td>";
			echo "<td width='50' align='center'>Tara</td>";
			echo "<td width='80' align='center'>Rev.Tecn.</td>";
			echo "<td width='80' align='center'>Cert.EK</td>";
			echo "</tr>";
			if ($CmbTransporte=='-1')
			{
				$Filtro="";
			}
			else
			{
				$Filtro="and t1.tipo='".$CmbTransporte."'";
			}
			$Consulta = "select t3.nombre as nombre_transp,t1.nro_patente,t1.marca,t1.modelo,t1.año,t1.carga,";
			$Consulta = $Consulta." t1.tara,t1.fecha_rev_tecnica,t1.fecha_cert_estanque,t1.tipo ";
			$Consulta = $Consulta." from pac_web.camiones_por_transportista t1 ";
			$Consulta = $Consulta." inner join pac_web.transportista t3 on t1.rut_transportista=t3.rut_transportista ".$Filtro." order by nombre_transp";
			$Resultado=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			echo "<input type='hidden' name='CheckPatente'><input type='hidden' name ='TxtPatenteO'>";
			$Cont=0;
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				echo "<td align='left'><input type='checkbox' name='CheckPatente' value='checkbox'></td>";
				echo "<td width='250' align='left'>".$Fila["nombre_transp"]."<input type='hidden' name ='TxtPatenteO' value ='".$Fila["nro_patente"]."'></td>";
				$Cont++;
				echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");' class='detalle01'>";
				echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:300px'>\n";
				echo "<font face='courier' color='#000000' size=1><b>Nro Patente:&nbsp;&nbsp;: </b>".$Fila["nro_patente"]." <b>Marca: </b>".$Fila["marca"]."</font><br>";
				echo "<font face='courier' color='#000000' size=1><b>Modelo: </b>".$Fila["modelo"]."        <b>Año: </b>".$Fila["año"]."</font><br>";
				echo "</div>".$Fila["nro_patente"]."</td>";
				switch ($Fila["tipo"])
				{
					case "C":
						echo "<td width='60' align='left'>Camion</td>";
						break;
					case "R":
						echo "<td width='60' align='left'>Rampla</td>";
						break;
					case "B":
						echo "<td width='60' align='left'>Buque</td>";
						break;
				}
				//echo "<td width='70' align='left'>".$Fila["marca"]."</td>";
				//echo "<td width='70' align='right'>".$Fila["modelo"]."</td>";
				//echo "<td width='40' align='right'>".$Fila["año"]."</td>";
				echo "<td width='50' align='right'>".$Fila["carga"]."&nbsp;</td>";
				echo "<td width='50' align='right'>".$Fila["tara"]."&nbsp;</td>";
				if ((date($Fila["fecha_rev_tecnica"]))<(date('Y-m-d')))
				{
					echo "<td width='80' align='right'><strong><font color='red'>".$Fila["fecha_rev_tecnica"]."&nbsp;</font color></strong></td>";	
				}
				else
				{
					echo "<td width='80' align='right'><strong><font color='green'>".$Fila["fecha_rev_tecnica"]."&nbsp;</font color></strong></td>";
				}
				if ((date($Fila["fecha_cert_estanque"]))<(date('Y-m-d')))
				{
					echo "<td width='80' align='right'><strong><font color='red'>".$Fila["fecha_cert_estanque"]."&nbsp;</font color></strong></td>";
				}
				else
				{
					echo "<td width='80' align='right'><strong><font color='green'>".$Fila["fecha_cert_estanque"]."&nbsp;</font color></strong></td>";
				}	
				echo "</tr>";
			}
			echo "</table>";
		?>
        <br> <table width="750" border="0" class="tablainterior">
          <tr> 
            <td align="center"> <input type="button" name="BtnNuevo" value="Nuevo" style="width:60" onClick="MostrarPopupProceso('N');"> 
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
