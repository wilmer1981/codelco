<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 29;
	include("../principal/conectar_pac_web.php");
?>
<html>
<head>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngOriginador;
	var Valores="";
	var paso=false;

	for (i=1;i<Frm.CheckUnidad.length;i++)
	{
		if (Frm.CheckUnidad[i].checked==true)
		{
			paso=true

			Valores=Valores +Frm.TxtCodUnidad[i].value+"//" ;

		}
	}
	if(paso==true)
	{

		Valores=Valores.substring(0,Valores.length -2);
	}
	/*alert(Valores);*/
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmIngOriginador;
	try
	{
		Frm.CheckUnidad[0];
		for (i=1;i<Frm.CheckUnidad.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckUnidad[i].checked=true;
			}
			else
			{
				Frm.CheckUnidad[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmIngOriginador;
	var CantCheck=0;
	for (i=1;i<Frm.CheckUnidad.length;i++)
	{
		if (Frm.CheckUnidad[i].checked==true)
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
	var Frm=document.FrmIngOriginador;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckUnidad.length;i++)
	{
		if (Frm.CheckUnidad[i].checked==true)
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
	var Frm=document.FrmIngOriginador;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("pac_ingreso_originador_proceso.php?Proceso="+Proceso,"","top=110,left=180,width=460,height=260,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("pac_ingreso_originador_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=110,left=180,width=460,height=260,scrollbars=no,resizable = no");		
				}	
			}	
			break;
		case "E":
			if (SeleccionoCheck()) 
			{
				Resp=confirm("Esta seguro de eliminar los datos seleccionados?");
				if (Resp==true)
				{
					Valores=RecuperarValoresCheckeado();

					Frm.action="pac_ingreso_originador_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	 
			break;	
	} 
}

function Salir()
{
	var Frm=document.FrmIngOriginador;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=21";
	Frm.submit();
}
</script>
<title>Ingreso de Unidades de Medida</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngOriginador" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"><br> 
        <?php
			echo "<table width='750' border='1' cellpadding='3' cellspacing='0' >";
			echo "<tr class='ColorTabla01'>"; 
			echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
			echo "<td width='90' align='left'>Rut</td>";
			echo "<td width='180' align='left'>Nombre</td>";
			echo "<td width='180' align='left'>Lugar</td>";
			echo "<td width='180' align='left'>Divisi&oacute;n SAP</td>";
			echo "<td width='180' align='left'>Almac&eacute;n SAP</td>";
			echo "<td width='180' align='left'>Estado Activo</td>";
			echo "</tr>";
			$Consulta = "select * from pac_web.pac_originador order by nombre";
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckUnidad'><input type='hidden' name ='TxtCodUnidad'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				echo "<td align='left'><input type='checkbox' name='CheckUnidad' value='checkbox'></td>";
				echo "<td width='90' align='left'>".$Fila["rut"]."<input type='hidden' name ='TxtCodUnidad' value ='".$Fila["cod_originador"]."'></td>";
				echo "<td width='150' align='left'>".$Fila["nombre"]."</td>";
				echo "<td width='150' align='left'>".$Fila["lugar"]."&nbsp;</td>";
				echo "<td width='60' align='left'>".$Fila["div_sap"]."&nbsp;</td>";
				echo "<td width='60' align='left'>".$Fila["almacen_sap"]."&nbsp;</td>";
				if($Fila["activo"] == 1){
					echo "<td align='left'>SI</td>";
				}else{
					echo "<td align='left'>NO</td>";
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
			echo "alert('Uno o mas Elementos no fueron eliminados por tener registros asociados');";
			echo "</script>";
		}
	}
	if (isset($reg_delete))
	{
		if ($reg_delete==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Registro eliminado correctamente.');";	
			echo "</script>";
		}
	}
?>
