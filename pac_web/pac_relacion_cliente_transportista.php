<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 24;
	include("../principal/conectar_pac_web.php");
	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
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
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 355 ");
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
	var Frm=document.FrmRelacion;
	var Valores="";

	for (i=1;i<Frm.CheckRelacion.length;i++)
	{
		if (Frm.CheckRelacion[i].checked==true)
		{
			Valores=Valores + Frm.CheckRelacion[i].value+"//";
		}
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);	
	}
	else
	{
		return('');	
	}
	
}
function CheckearTodo()
{
	var Frm=document.FrmRelacion;
	try
	{
		Frm.CheckRelacion[0];
		for (i=1;i<Frm.CheckRelacion.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckRelacion[i].checked=true;
			}
			else
			{
				Frm.CheckRelacion[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmRelacion;
	var CantCheck=0;
	for (i=1;i<Frm.CheckRelacion.length;i++)
	{
		if (Frm.CheckRelacion[i].checked==true)
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
	var Frm=document.FrmRelacion;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckRelacion.length;i++)
	{
		if (Frm.CheckRelacion[i].checked==true)
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
	var Frm=document.FrmRelacion;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("pac_relacion_cliente_transportista_proceso.php?Proceso="+Proceso,"","top=180,left=180,width=415,height=180,scrollbars=no,resizable = no");
			break;
		case "E":
			if (SeleccionoCheck()) 
			{
				Resp=confirm("Esta seguro de Eliminar los Datos Seleccionados");
				if (Resp==true)
				{
					Valores=RecuperarValoresCheckeado();
					Frm.action="pac_relacion_cliente_transportista_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}
function Salir()
{
	var Frm=document.FrmRelacion;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=21";
	Frm.submit();
}
</script>
<title>Relacion Cliente Transportista</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmRelacion" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
	<tr>
	  <td align="center">
	  </td>
	</tr>
    <tr>
      <td align="center" valign="top"><br> 
        <?php
			echo "<table width='750' border='1' cellpadding='3' cellspacing='0' >";
			echo "<tr class='ColorTabla01'>"; 
			echo "<td width='10'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
			echo "<td align='left'>Cliente</td>";
			echo "<td align='left'>Transportista</td>";
			echo "</tr>";
			$Consulta = "select t1.corr_interno_cliente,t1.rut_cliente,t1.rut_transportista,t2.nombre as nombre_cliente,t3.nombre as nombre_transp from pac_web.relacion_cliente_transp t1 inner join pac_web.clientes t2 on t1.rut_cliente=t2.rut_cliente and t1.corr_interno_cliente=t2.corr_interno_cliente";
			$Consulta = $Consulta." inner join pac_web.transportista t3 on t1.rut_transportista=t3.rut_transportista order by nombre_cliente,nombre_transp";
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckRelacion'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				echo "<td align='left'><input type='checkbox' name='CheckRelacion' value='".$Fila["rut_cliente"]."~~".$Fila["rut_transportista"]."~~".$Fila["corr_interno_cliente"]."'></td>";
				echo "<td align='left'>".$Fila["nombre_cliente"]."</td>";
				echo "<td align='left'>".$Fila["nombre_transp"]."</td>";
				echo "</tr>";
			}
			echo "</table>";
		?>
        <br> <table width="750" border="0" class="tablainterior">
          <tr> 
            <td align="center"> <input type="button" name="BtnNuevo" value="Nuevo" style="width:60" onClick="MostrarPopupProceso('N');">
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
	if ($EncontroRelacion)
	{
		if ($EncontroRelacion==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Uno o mas Elementos no fueron eliminados por tener grupos asociados');";	
			echo "</script>";
		}
	}
?>
