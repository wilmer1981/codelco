<?php 	
	$CodigoDeSistema = 99;
	$CodigoDePantalla = 9;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	
	
	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");

	$CmbSistema = isset($_REQUEST["CmbSistema"])?$_REQUEST["CmbSistema"]:"";
	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";


/*
	if(isset($_GET["EncontroRelacion"])){
		$CmbSistema = $_GET["CmbSistema"];
	}
*/
if($EncontroRelacion!=""){
	$CmbSistema = $CmbSistema;
}
	
?>
<html>
<head>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngClaseSubclase;
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
	var Frm=document.FrmIngClaseSubclase;
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
function SoloUnElementoCheck()
{
	var Frm=document.FrmIngClaseSubclase;
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
function SeleccionoCheck()
{
	var Frm=document.FrmIngClaseSubclase;
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

function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmIngClaseSubclase;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "NC":
			window.open("ingreso_clase_subclase_proceso.php?Proceso="+Proceso+"&CmbSistema2="+Frm.CmbSistema.value,"","top=175,left=120,width=550,height=230,scrollbars=no,resizable = no");
			break;
		case "MC":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("ingreso_clase_subclase_proceso.php?Proceso="+Proceso+"&Valores="+Valores+"&CmbSistema2="+Frm.CmbSistema.value,"","top=175,left=120,width=550,height=230,scrollbars=no,resizable = no");		
				}	
			}	
			break;
		case "MS":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("ingreso_clase_subclase_proceso2.php?Proceso=NS&Valores="+Valores,"","top=125,left=120,width=550,height=330,scrollbars=no,resizable = no");		
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
					Frm.action="ingreso_clase_subclase_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}
function Recarga()
{
	var Frm=document.FrmIngClaseSubclase;
	Frm.action="ingreso_clase_subclase.php";
	Frm.submit();
}
function Detalle(Valores)
{
	window.open("ingreso_clase_subclase_detalle.php?Valores="+Valores,"","top=120,left=120,width=550,height=350,scrollbars=yes,resizable = no");		
}
function Salir()
{
	var Frm=document.FrmIngClaseSubclase;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=99";
	Frm.submit();
}
</script>
<title>Ingreso de Parametros</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngClaseSubclase" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"> 
	  <?php
		echo "<table width='740' border='1' cellpadding='1' cellspacing='0' >";
		echo "<tr>"; 
		echo "<td align='center' rowspan='2'>";
		echo "<select name='CmbSistema' style='width:250' onchange='Recarga()'>";
		echo "<option value='-1'>SELECCIONAR</option>";
		$Consulta="select * from proyecto_modernizacion.sistemas order by cod_sistema";
		$Resultado=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			if ($CmbSistema==$Fila["cod_sistema"])
			{
				echo "<option value='".$Fila["cod_sistema"]."' selected>".strtoupper($Fila["descripcion"])."</option>";
			}
			else
			{
				echo "<option value='".$Fila["cod_sistema"]."'>".strtoupper($Fila["descripcion"])."</option>";
			}	
		}
		echo "</select>";
		echo "</td>";
		echo "<td align='center'>";
		?>
	    <input type="button" name="BtnNuevo" value="Agregar Clase" style="width:100" onClick="MostrarPopupProceso('NC');"> 
	    <input type="button" name="BtnModificar" value="Modif.Clase" style="width:100" onClick="MostrarPopupProceso('MC');"> 
	    <input type="button" name="BtnEliminar" value="Eliminar" style="width:100" onClick="MostrarPopupProceso('E');">
		<?php
		echo "</td>";
		echo "</tr>"; 
		//echo "<tr><td>&nbsp;</td>";
		echo "<td align='center'>";
		?>
	    <input type="button" name="BtnNuevo2" value="Agregar/Modificar SubClase " style="width:204" onClick="MostrarPopupProceso('MS');"> 
		<input type="button" name="BtnSalir" value="Salir" style="width:100" onClick="Salir();">
		<?php
		echo "</td>";
		echo "</tr>"; 
		echo "</table><br>";
		echo "<table width='740' border='1' cellpadding='2' cellspacing='0' >";
		echo "<tr class='ColorTabla01'>"; 
		echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
		echo "<td width='40' align='center'>Codigo</td>";
		echo "<td width='400' align='center'>Descripcion</td>";
		echo "<td width='100' align='center'>Valor1</td>";
		echo "<td width='100' align='center'>Valor1</td>";
		echo "</tr>";
		if ($CmbSistema=='-1')
		{
			$Consulta="select * from proyecto_modernizacion.clase order by cod_clase";
	//		echo "COnsulta  :" .$Consulta."<br>";
		}
		else
		{
			$CodigoIni=1000*intval($CmbSistema);
			$CodigoFin=$CodigoIni+999;
			$Consulta="select * from proyecto_modernizacion.clase where cod_clase between '".$CodigoIni."' and '".$CodigoFin."' ";
		//	echo "COnsulta  :" .$Consulta."<br>";
			
		}	
		$Resultado=mysqli_query($link, $Consulta);
		echo "<input type='hidden' name='CheckCod'>";
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">"; 
			echo "<td align='left'><input type='checkbox' name='CheckCod' value='".$Fila["cod_clase"]."' onclick=\"CCA(this,'CL03')\"></td>";
			echo "<td align='right'>".$Fila["cod_clase"]."</td>";
			echo "<td align='left'><a href=JavaScript:Detalle('".$Fila["cod_clase"]."')>".$Fila["nombre_clase"]."</a></td>";
			echo "<td align='left'>".$Fila["valor1"]."&nbsp;</td>";
			echo "<td align='left'>".$Fila["valor2"]."&nbsp;</td>";
			echo "</tr>";
		}
		echo "</table>";
		?>
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if($EncontroRelacion!=""){
		if ($EncontroRelacion==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Algunos Elementos No Fueron Eliminados por Tener SubClases Asociadas');";
			echo "</script>";
		}
	}
?>