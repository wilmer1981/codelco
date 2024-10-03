<?php 	
	$CodigoDeSistema = 99;
	$CodigoDePantalla = 10;
	include("../principal/conectar_principal.php");
	
	$TipoBusq      = isset($_REQUEST["TipoBusq"])?$_REQUEST["TipoBusq"]:0;
	$CmbCCosto     = isset($_REQUEST["CmbCCosto"])?$_REQUEST["CmbCCosto"]:"";
	$TxtRut        = isset($_REQUEST["TxtRut"])?$_REQUEST["TxtRut"]:"";
	$TxtApePaterno = isset($_REQUEST["TxtApePaterno"])?$_REQUEST["TxtApePaterno"]:"";

	//if(!isset($TipoBusq))
	//	$TipoBusq='0';
?>
<html>
<head>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngFun;
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
	var Frm=document.FrmIngFun;
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
	var Frm=document.FrmIngFun;
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
	var Frm=document.FrmIngFun;
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
function CopiarPerfil()
{
	var Frm=document.FrmIngFun;
	var Valores="";
	for (i=1;i<Frm.CheckCod.length;i++)
	{
		if (Frm.CheckCod[i].checked==true)
		{
			Valores=Valores + Frm.CheckCod[i].value + "~~";
		}
	}
	if (Valores=="")
		alert("Debe Seleccionar a lo menos un Funcionario");
	else
	{
		Valores=Valores.substring(0,Valores.length - 2);
		window.open("ingreso_funcionarios_copia_perfil.php?Valores="+Valores,"","top=175,left=120,width=550,height=230,scrollbars=no,resizable = no");			
	}		
}

function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmIngFun;
	var Valores="";
	var Resp="";
	//alert("Proceso:"+Proceso);
	switch (Proceso)
	{
		case "N":
			window.open("ingreso_funcionarios_proceso.php?Proceso="+Proceso+"&CmbCCosto2="+Frm.CmbCCosto.value,"","top=175,left=120,width=550,height=280,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("ingreso_funcionarios_proceso.php?Proceso="+Proceso+"&Valores="+Valores+"&CmbCCosto2="+Frm.CmbCCosto.value,"","top=175,left=120,width=550,height=320,scrollbars=no,resizable = no");		
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
					//alert("Valores:"+Valores);
					Frm.action="ingreso_funcionarios_proceso01.php?Proceso="+Proceso+"&Valores="+Valores+"&CmbCCosto2="+Frm.CmbCCosto.value;
					Frm.submit();
				}			
			}	
			break;	
	} 
}
function Recarga(TipoBusq)
{
	var Frm=document.FrmIngFun;
	switch(TipoBusq)
	{
		case "1":
			//alert("Ingreso 1");
			
			Frm.CmbCCosto.value='-1';
			Frm.action="ingreso_funcionarios.php?TipoBusq=1";
			break;
		case "2":
			//alert("Ingreso 2");
			Frm.CmbCCosto.value='-1';
			Frm.action="ingreso_funcionarios.php?TipoBusq=2";
			break;
		default:
		    //alert("Ingreso 0");
			Frm.action="ingreso_funcionarios.php?TipoBusq=0";		
	}
	Frm.submit();
}
function Detalle(Valores)
{
	window.open("ingreso_funcionario_detalle.php?Valores="+Valores,"","top=120,left=120,width=550,height=400,scrollbars=yes,resizable = no");		
}
function SistemasAsociados(funcionarios)
{
	window.open("ing_fun_nivel.php?funcionarios="+funcionarios,"","top=5,left=0,width=770,height=550,scrollbars=yes,resizable = no");		
}

function Salir()
{
	var Frm=document.FrmIngFun;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=99";
	Frm.submit();
}
</script>
<title>Ingreso de Funcionarios</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngFun" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"> 
	  <?php
		echo "<table width='740' border='1' cellpadding='1' cellspacing='0' >";
		echo "<tr>"; 
		echo "<td align='center'>Centro Costos&nbsp;&nbsp;";
		echo "<select name='CmbCCosto' style='width:320' onchange=Recarga('')>";
		echo "<option value='-1'>SELECCIONAR</option>";
		$Consulta="select * from proyecto_modernizacion.centro_costo order by CENTRO_COSTO";
		$Resultado=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			if ($CmbCCosto==$Fila["CENTRO_COSTO"]){
				echo "<option value='".$Fila["CENTRO_COSTO"]."' selected>".$Fila["CENTRO_COSTO"]."-".strtoupper($Fila["DESCRIPCION"])."</option>";
			}else{
				echo "<option value='".$Fila["CENTRO_COSTO"]."'>".$Fila["CENTRO_COSTO"]."-".strtoupper($Fila["DESCRIPCION"])."</option>";
			}	
		}
		echo "</select>";
		echo "</td>";
		echo "<td align='center'>";
		?>			 
			<input type="button" name="BtnNuevo" value="Nuevo" style="width:70" onClick="MostrarPopupProceso('N');"> 
			<input type="button" name="BtnModificar" value="Modificar" style="width:70" onClick="MostrarPopupProceso('M');"> 
			<input type="button" name="BtnEliminar" value="Eliminar" style="width:70" onClick="MostrarPopupProceso('E');">
			<input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();">
		<?php
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>&nbsp;&nbsp;Rut&nbsp;<input name='TxtRut' type='text' value='".$TxtRut."' style='width:85'>&nbsp;<input name='BtnOk' value='OK' type='button' style='width:25' onclick=Recarga('1')>&nbsp;&nbsp;&nbsp;Apellido Pate.&nbsp;&nbsp;";
		echo "<input name='TxtApePaterno' type='text' style='width:130' value='".$TxtApePaterno."'>&nbsp;<input name='BtnOk2' value='OK' type='button' style='width:25' onclick=Recarga('2')>";
		echo "</td>";
		echo "<td><input type=\"button\" name=\"BtnPerfil\" value=\"Copiar Perfil\" style=\"width:90\" onClick=\"CopiarPerfil()\">";
		echo "</td>";
		echo "</tr>"; 
		echo "</table><br>";
		echo "<table width='740' border='1' cellpadding='2' cellspacing='0' >";
		echo "<tr class='ColorTabla01'>"; 
		echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
		echo "<td width='80' align='center'>Rut</td>";
		echo "<td width='280' align='center'>Nombres</td>";
		echo "<td width='100' align='center'>Sistemas</td>";
		echo "<td width='100' align='center'>Centro Costo</td>";
		echo "<td width='100' align='center'>Cambio Password</td>";
		echo "<td width='100' align='center'>Bloqueado</td>";
		echo "</tr>";

		switch($TipoBusq)
		{
			case "0"://BUSQUEDA CENTRO DE COSTO
				$CodCCosto='02-'.substr($CmbCCosto,0,2).".".substr($CmbCCosto,2,2);
				$Consulta="SELECT * FROM proyecto_modernizacion.funcionarios WHERE cod_centro_costo='".$CodCCosto."' order by apellido_paterno";
				break;
			case "1"://BUSQUEDA POR RUT		
				//echo "<br>RUT:".$TxtRut	
				$Consulta="SELECT * FROM proyecto_modernizacion.funcionarios WHERE rut='".$TxtRut."'";
				break;
			case "2"://BUSQUEDA POR APELLIDO PATERNO
				$TxtApePaterno = $_POST["TxtApePaterno"];
				$Consulta="select * from proyecto_modernizacion.funcionarios where apellido_paterno like '".$TxtApePaterno."%' order by apellido_paterno";
				break;
		}
		//echo "Consulta:".$Consulta;
		$Resultado=mysqli_query($link, $Consulta);
		//$Fila=mysqli_fetch_array($Resultado);
		//echo "<br>Resultado:";
		//var_dump($Fila);

		echo "<input type='hidden' name='CheckCod'>";
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">"; 
			echo "<td align='left'><input type='checkbox' name='CheckCod' value='".$Fila["rut"]."' onClick=\"CCA(this,'CL03')\"></td>";
			echo "<td align='right'>".$Fila["rut"]."</td>";
			echo "<td align='left'><a href=JavaScript:Detalle('".$Fila["rut"]."')>".ucwords(strtolower($Fila["apellido_paterno"]))."&nbsp;".$Fila["apellido_materno"]."&nbsp;".$Fila["nombres"]."</a></td>";
			echo "<td align='center'><a href=JavaScript:SistemasAsociados('".$Fila["rut"]."')>Sistemas Asociados</td>";
			echo "<td align='center'>".$Fila["cod_ceco"]."&nbsp;</td>";
			echo "<td align='left'>".$Fila["fecha_cambio_password"]."&nbsp;</td>";
			echo "<td align='left'>".$Fila["Bloqueo"]."&nbsp;</td>";
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
$EncontroRelacion='';
	if ($EncontroRelacion==true)
	{
		echo "<script languaje='javascript'>";
		echo "alert('Algunos Elementos No Fueron Eliminados por Tener SubClases Asociadas');";
		echo "</script>";
	}
?>