<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 27;
	include("../principal/conectar_pac_web.php");

	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
	$reg_delete       = isset($_REQUEST["reg_delete"])?$_REQUEST["reg_delete"]:"";

?>
<html>
<head>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngProd;
	var Valores="";
	var paso=false;

	for (i=1;i<Frm.CheckProd.length;i++)
	{
		if (Frm.CheckProd[i].checked==true)
		{
			paso=true

			Valores=Valores +Frm.TxtCodProd[i].value+"//" ;

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
	var Frm=document.FrmIngProd;
	try
	{
		Frm.CheckProd[0];
		for (i=1;i<Frm.CheckProd.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckProd[i].checked=true;
			}
		else
			{
				Frm.CheckProd[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmIngProd;
	var CantCheck=0;
	for (i=1;i<Frm.CheckProd.length;i++)
	{
		if (Frm.CheckProd[i].checked==true)
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
	var Frm=document.FrmIngProd;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckProd.length;i++)
	{
		if (Frm.CheckProd[i].checked==true)
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
	var Frm=document.FrmIngProd;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("pac_ingreso_producto_proceso.php?Proceso="+Proceso,"","top=110,left=180,width=460,height=260,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("pac_ingreso_producto_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=110,left=180,width=460,height=260,scrollbars=no,resizable = no");		
				}	
			}	
			break;
		case "E":
			if (SeleccionoCheck()) 
			{
				Resp=confirm("Esta seguro de Eliminar los Datos Seleccionados?");
				if (Resp==true)
				{
					Valores=RecuperarValoresCheckeado();

					Frm.action="pac_ingreso_producto_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}

function Salir()
{
	var Frm=document.FrmIngProd;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=21";
	Frm.submit();
}
</script>
<title>Ingreso de Productos</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngProd" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"><br> 
        <?php
			echo "<table width='750' border='1' cellpadding='3' cellspacing='0' >";
			echo "<tr class='ColorTabla01'>"; 
			echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
			echo "<td width='90' align='left'>C&oacute;digo SAP</td>";
			echo "<td width='180' align='left'>Nombre</td>";
			echo "<td width='180' align='left'>Concentraci&oacuten</td>";
			echo "<td width='180' align='left'>N.U.</td>";
			echo "<td width='180' align='left'>Homologaci&oacute;n SIPA</td>";
				echo "<td width='180' align='left'>Estado Activo</td>";
		echo "</tr>";
			$Consulta = "select * from pac_web.pac_productos order by nombre";
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckProd'><input type='hidden' name ='TxtCodProd'>";
			while ($Fila=mysqli_fetch_array($Resultado)){
				$NombreProdSipa='';
				if(strpos($Fila["cod_sipa"],'~'))
				{
					$Codigos=explode("~", $Fila["cod_sipa"]);
					$CodProd=$Codigos[0];
					$CodSub=$Codigos[1];
					$ConsultaProd="select descripcion as nom_subprod  from proyecto_modernizacion.subproducto  where cod_producto ='".$CodProd."' and cod_subproducto='".$CodSub."'";
					$ResultadoProd=mysqli_query($link, $ConsultaProd);
					if($FilaProd=mysqli_fetch_array($ResultadoProd))
					{
						$NombreProdSipa=$FilaProd["nom_subprod"];
					}
				}
				echo "<tr>"; 
				echo "<td align='left'><input type='checkbox' name='CheckProd' value='checkbox'></td>";
				echo "<td width='90' align='left'>".$Fila["cod_sap"]."<input type='hidden' name ='TxtCodProd' value ='".$Fila["cod_producto"]."'></td>";
				echo "<td width='150' align='left'>".$Fila["nombre"]."</td>";
				echo "<td width='150' align='left'>".$Fila["concentracion"]."</td>";
				echo "<td width='150' align='left'>".$Fila["NU"]."</td>";
					echo "<td width='150' align='left'>".$NombreProdSipa."</td>";
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
