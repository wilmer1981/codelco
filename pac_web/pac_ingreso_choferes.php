<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 4;
	include("../principal/conectar_pac_web.php");

	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
?>
<html>
<head>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngChoferes;
	var Valores="";

	for (i=1;i<Frm.CheckRutChofer.length;i++)
	{
		if (Frm.CheckRutChofer[i].checked==true)
		{
			Valores=Valores + Frm.TxtRutChoferO[i].value+"//";
		}
	}
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmIngChoferes;
	try
	{
		Frm.CheckRutChofer[0];
		for (i=1;i<Frm.CheckRutChofer.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckRutChofer[i].checked=true;
			}
			else
			{
				Frm.CheckRutChofer[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmIngChoferes;
	var CantCheck=0;
	for (i=1;i<Frm.CheckRutChofer.length;i++)
	{
		if (Frm.CheckRutChofer[i].checked==true)
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
	var Frm=document.FrmIngChoferes;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckRutChofer.length;i++)
	{
		if (Frm.CheckRutChofer[i].checked==true)
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
	var Frm=document.FrmIngChoferes;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("pac_ingreso_choferes_proceso.php?Proceso="+Proceso,"","top=110,left=180,width=410,height=260,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("pac_ingreso_choferes_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=110,left=180,width=410,height=260,scrollbars=no,resizable = no");		
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
					Frm.action="pac_ingreso_choferes_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}

function Salir()
{
	var Frm=document.FrmIngChoferes;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=21";
	Frm.submit();
}
</script>
<title>Ingreso de Choferes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngChoferes" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"><br> 
        <?php
			echo "<table width='750' border='1' cellpadding='2' cellspacing='0'>";
			echo "<tr class='ColorTabla01'>"; 
			echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
			echo "<td width='200' align='left'>Transportista</td>";
			echo "<td width='80' align='center'>Rut</td>";
			echo "<td width='150' align='left'>Nombre</td>";
			echo "<td width='150' align='left'>Direccion</td>";
			echo "<td width='100' align='center'>Reg.Nac.Conduct</td>";
			echo "</tr>";
			$Consulta = "select t2.nombre as nombre_transp,t1.rut_chofer,t1.nombre,t1.direccion,t1.registro from pac_web.choferes t1 " ;
			$Consulta = $Consulta." inner join pac_web.transportista t2 on t1.rut_transportista=t2.rut_transportista order by t2.nombre";
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckRutChofer'><input type='hidden' name ='TxtRutChoferO'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				echo "<td align='left'><input type='checkbox' name='CheckRutChofer' value='checkbox'></td>";
				echo "<td width='200' align='left'>".$Fila["nombre_transp"]."<input type='hidden' name ='TxtRutChoferO' value ='".$Fila["rut_chofer"]."'></td>";
				echo "<td width='80' align='right'>".$Fila["rut_chofer"]."</td>";
				echo "<td width='150' align='left'>".$Fila["nombre"]."</td>";
				echo "<td width='150' align='left'>".$Fila["direccion"]."&nbsp;</td>";
				echo "<td width='100' align='right'>".$Fila["registro"]."&nbsp;</td>";
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
