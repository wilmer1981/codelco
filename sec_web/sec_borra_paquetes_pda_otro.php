<?php 	
	  include("../principal/conectar_sec_web.php");
	$CodigoDeSistema = 3;
	//$CodigoDePantalla = 69;
	$CodigoDePantalla = 72;
	
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut =$CookieRut;
	//$Fecha_Hora = date("d-m-Y h:i");
	
	
	$Encontro=false;
	if ($Buscar != 'S')
	$TxtFechaFin=date('Y-m-d');
	//if($TxtFechaFin <> "")
	{
		
		$Consulta = "SELECT * from sec_web.paquetes_pda where (fecha_hora between '".$TxtFechaFin." 00:00:00'  and '".$TxtFechaFin." 23:59:59') ";
		//echo $Consulta;
		$Respuesta =mysqli_query($link, $Consulta);
		if($Fila =mysqli_fetch_array($Respuesta))
		{
			$Lote=$Fila[cod_lote]." ".$Fila[num_lote];
			$Encontro=true;
		}
	}
?>
<html>
<head>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">

function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmIngTransporte;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "E":
			if (SeleccionoCheck()) 
			{
				Resp=confirm("Esta seguro de Eliminar los Datos Seleccionados");
				if (Resp==true)
				{
					Valores=RecuperarValoresCheckeado();
					//alert (Valores);
					//alert (Proceso);
					Frm.action="sec_borra_paquetes_pda_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}


function SoloUnElementoCheck()
{
	var CantCheck='';

	var Frm=document.FrmIngTransporte;
	var CantCheck=0;
	for (i=1;i<Frm.CheckCod.length;i++)
	{
		if (Frm.CheckCod[i].checked==true)
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


function RecuperarValoresCheckeado()
{

	var Frm=document.FrmIngTransporte;
	var Valores="";

	for (i=1;i<Frm.CheckCod.length;i++)
	{
		if (Frm.CheckCod[i].checked==true)
		{
			Valores=Valores + Frm.CheckCod[i].value+"//";
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);	
}
function CheckearTodo()
{

	var Frm=document.FrmIngTransporte;
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckCod[i].checked=true;
			}
			else
			{
				Frm.CheckCod[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}

function SeleccionoCheck()
{

	var Frm=document.FrmIngTransporte;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckCod.length;i++)
	{
		if (Frm.CheckCod[i].checked==true)
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

function Buscar()
{
	var Frm=document.FrmIngTransporte;
	Frm.action="sec_borra_paquetes_pda_otro.php?Buscar=S&TxtFechaFin="+Frm.TxtFechaFin.value;
	//Frm.action="sec_borra_paquetes_pda.php?Buscar=S";
	Frm.submit();
}

function Salir()
{
	var Frm=document.FrmIngTransporte;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=65";
	Frm.submit();
}
</script>
<title>Elimina Paquetes PDA</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">

<body background="../principal/imagenes/fondo3.gif">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>

<form name="FrmIngTransporte" method="post" action="">
  <?php include("../principal/encabezado.php")?>
    <table width="600"  border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
          <tr>
            <td width="109"><font size="2"><strong>Fecha a Buscar : </strong></font></td>
            <td width="204"><font size="1"><font size="2"> </font></font><font size="2">
              <input name="TxtFechaFin" type="text" class="InputCen" value="<?php echo $TxtFechaFin; ?>" size="13" maxlength="10" readonly >
              <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"> </font></td>
            <td width="242"><font size="2">
              <input name="btnBuscar" type="button" id="btnBuscar2" value="Buscar" style="width:60" onClick="Buscar();">
			  <input type="button" name="BtnEliminar" value="Eliminar" style="width:60" onClick="MostrarPopupProceso('E');">

			  <input name="btnSalir" type="button" id="btnSalir" value="Salir"  style="width:60" onClick="Salir();">
            </font></td>
          </tr>
        </table>
    	<br>
		<?php
		echo "<table width='600' border='1' cellpadding='2' cellspacing='0' >";
		echo "<tr class='ColorTabla01'>"; 
		echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
		echo "<td width='200' align='center'>Hora</td>";
		echo "<td width='100' align='center'>Patente</td>";
		echo "<td width='50' align='center'>Cod.Paquete</td>";
		echo "<td width='50' align='center'>Num.Paquete</td>";
		echo "<td width='100' align='center'>Peso</td>";
		echo "</tr>";
		
		if($Encontro == true)
		{
			$cont = 0;
			$Consulta = "SELECT * from sec_web.paquetes_pda where (fecha_hora between '".$TxtFechaFin." 00:00:00'  and '".$TxtFechaFin." 23:59:59') ";
			$Consulta.=" order by fecha_hora,patente ";
			//echo $Consulta;
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckCod'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				//echo "FFF".$Fila["cod_paquete"];
				echo "<td align='left'><input type='checkbox' name='CheckCod' value='".$Fila["fecha_hora"]."~".$Fila[patente]."~".$Fila["cod_paquete"]."~".$Fila["num_paquete"]."'></td>";
				echo "<td align='left'>".$Fila["fecha_hora"]."&nbsp;</td>";
				echo "<td align='right'>".$Fila[patente]."&nbsp;</td>";
				echo "<td align='right'>".$Fila["cod_paquete"]."&nbsp;</td>";
				echo "<td align='right'>".$Fila["num_paquete"]."&nbsp;</td>";
				echo "<td align='right'>".$Fila[peso_paquete]."&nbsp;</td>";
				$cont = $cont + 1;
				echo "</tr>";
			}
			//echo "</table>";
		}	
		  	echo "<tr class='Detalle01'>";
            echo "<td>&nbsp;</td>";
			echo "<td width='92' align='center'><strong>Total Paquetes </strong></td>";
	  	    echo "<td align='left'><strong>".$cont."</strong</td>";
			echo "<td>&nbsp;</td>";
			echo "<td align='left'><strong>".$TotalUnidades."</strong></td> ";
			echo "<td align='left'><strong>".$TotalPeso."</strong></td> ";
            //echo "<td>&nbsp;</td>";
			echo "</tr>";
			echo "</table>";
		
		?>
  <?php //include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
  		echo "<script languaje='JavaScript'>";
		echo "var frm=document.FrmIngTransporte;";
		if($TxtFechaFin<> "")
		{
			if ($Encontro==false && $Buscar=="S")
			{
				echo "alert('No Existen Paquete PDA Para Fecha ".$TxtFechaFin." ');";
			}
		}
		echo "</script>"

?>