<?php 	
	include("../principal/conectar_sec_web.php");
	 
	$CodigoDeSistema = 3;
	//$CodigoDePantalla = 69;
	$CodigoDePantalla = 78;
	
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	$CmbMes  = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno  = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$EncontroRelacion  = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
	$reg_delete        = isset($_REQUEST["reg_delete"])?$_REQUEST["reg_delete"]:"";
	
?>
<html>
<head>
<!-- <script  language="JavaScript" src="funciones/funciones_java.js"></script> -->
<script language="JavaScript">

function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngOriginador;
	var Valores="";
	var paso=false;

	for (i=1;i<Frm.CheckCod.length;i++)
	{
		if (Frm.CheckCod[i].checked==true)
		{
			paso=true

			Valores=Valores +Frm.CheckCod[i].value+"//" ;
		}
	}
	if(paso==true)
	{

		Valores=Valores.substring(0,Valores.length -2);
	}
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmIngOriginador;
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
	var Frm=document.FrmIngOriginador;
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
	var Frm=document.FrmIngOriginador;
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
	var Frm=document.FrmIngOriginador;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("sec_originador_proceso.php?Proceso="+Proceso,"","top=110,left=180,width=470,height=330,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{

					Valores=RecuperarValoresCheckeado();
					window.open("sec_originador_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=110,left=180,width=470,height=330,scrollbars=no,resizable = no");		
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

					Frm.action="sec_originador_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}

function Salir()
{
	var Frm=document.FrmIngOriginador;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=65";
	Frm.submit();
}
</script>
<title>Ingreso de Originador</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngOriginador" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"> 
		<?php
		echo "<table width='600' border='1' cellpadding='2' cellspacing='0' >";
		echo "<tr class='ColorTabla01'>"; 
			echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
			echo "<td width='200' align='center'>Rut</td>";
			echo "<td width='200' align='center'>Nombre</td>";
			echo "<td width='200' align='center'>Lugar</td>";
			echo "<td width='200' align='center'>Divisi&oacuten SAP</td>";
			echo "<td width='200' align='center'>Almac&eacuten SAP</td>";
			echo "<td width='20' align='center'>Activo</td>";
		echo "</tr>";
		$Consulta="select rut, nombre, lugar, div_sap, almacen_sap, activo, cod_originador from sec_web.sec_originador";
		/*echo $Consulta;*/
		$Resultado=mysqli_query($link, $Consulta);
		echo "<input type='hidden' name='CheckCod'><input type='hidden' name ='TxtCheckCod'>";
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			echo "<tr>"; 
				echo "<td align='left'><input type='checkbox' name='CheckCod' value='".$Fila["cod_originador"]."'></td>";
				echo "<td align='right'>".$Fila["rut"]."&nbsp;</td>";
				echo "<td align='right'>".$Fila["nombre"]."&nbsp;</td>";
				echo "<td align='right'>".$Fila["lugar"]."&nbsp;</td>";
				echo "<td align='right'>".$Fila["div_sap"]."&nbsp;</td>";
				echo "<td align='right'>".$Fila["almacen_sap"]."&nbsp;</td>";
				if($Fila["activo"] == 1){
					echo "<td align='left'>SI</td>";
				}else{
					echo "<td align='left'>NO</td>";
				}
				/*echo "<td align='right'>".$Fila["activo"]."&nbsp;</td>";*/
			echo "</tr>";
		}
		echo "</table>";
		?>
      </td>
  </tr>
  <tr>
	  <td height="25px">
	    <table border="0" align="center">  		      
		    <tr>
		    	<td><input type="button" name="nuevo" value="Nuevo" style="width:60" onClick="MostrarPopupProceso('N');"/></td>
		    	<td><input type="button" name="modificar" value="Modificar" style="width:60" onClick="MostrarPopupProceso('M');"/></td>
		    	<td><input type="button" name="eliminar" value="Eliminar" style="width:60" onClick="MostrarPopupProceso('E');"/></td>
		    	<td><input type="button" name="salir" value="Salir" style="width:60" onClick="Salir();"/></td>
		    </tr>
	  	</table>
	  </td>
  </tr>
  </table>



  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
