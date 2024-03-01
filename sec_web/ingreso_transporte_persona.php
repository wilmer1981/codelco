<?php 	
	  include("../principal/conectar_sec_web.php");
	  /*$Crear_Tabla = " CREATE TEMPORARY TABLE IF NOT EXISTS sec_web.tmp_table3 ( ";
	  $Crear_Tabla.= " cod_existencia char(2) NOT NULL DEFAULT '0' , ";
	  $Crear_Tabla.= " num_conjunto varchar(6) NOT NULL DEFAULT '0' , ";
	  $Crear_Tabla.= " conjunto_destino varchar(6) NOT NULL DEFAULT '0' , ";
	  $Crear_Tabla.= " fecha_movimiento datetime NOT NULL DEFAULT '0000-00-00 00:00:00' , ";
	  $Crear_Tabla.= " peso_humedo double NOT NULL DEFAULT '0' , ";
	  $Crear_Tabla.= " estado_validacion char(2) NOT NULL DEFAULT '0' , ";
	  $Crear_Tabla.= " ip varchar(10) NOT NULL DEFAULT '0')  ";
	  //echo $Crear_Tabla."<br>";
	  mysqli_query($link, $Crear_Tabla);
	  $IpUsuario=	str_replace('.','',$REMOTE_ADDR);
	  if($IpUsuario=='10564325')//105643174
	  {
	  	$Insertar="insert into sec_web.tmp_table3 (cod_existencia,num_conjunto,conjunto_destino,fecha_movimiento,peso_humedo,estado_validacion,ip) values('1','1','1','2006-11-06','1','1','$IpUsuario') "; 	
	  }	
	  else
	  {
	  	$Insertar="insert into sec_web.tmp_table3 (cod_existencia,num_conjunto,conjunto_destino,fecha_movimiento,peso_humedo,estado_validacion,ip) values('2','2','2','2006-11-06','2','2','$IpUsuario') "; 	
	  }
	  //echo $Insertar."<br>";
	  mysqli_query($link, $Insertar);
	  $Consulta="select cod_existencia,num_conjunto,conjunto_destino,fecha_movimiento,peso_humedo,estado_validacion,ip from sec_web.tmp_table3 ";
	  //echo $Consulta."<br>";
	  $Resp=mysqli_query($link, $Consulta);
	  while($Fila=mysqli_fetch_array($Resp))
	  {
	  		echo $Fila[cod_existencia]."<br>";
			echo $Fila[num_conjunto]."<br>";
			echo $Fila[conjunto_destino]."<br>";
			echo $Fila[fecha_movimiento]."<br>";
			echo $Fila[ip]."<br><br>";
	  }
	  */
	$CodigoDeSistema = 3;
	//$CodigoDePantalla = 69;
	$CodigoDePantalla = 70;
	
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	$CmbAno  = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbMes  = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$BuscarNombre  = isset($_REQUEST["BuscarNombre"])?$_REQUEST["BuscarNombre"]:"";
	$TxtBuscar  = isset($_REQUEST["TxtBuscar"])?$_REQUEST["TxtBuscar"]:"";

	$EncontroRelacion  = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:false;
	$Msj  = isset($_REQUEST["Msj"])?$_REQUEST["Msj"]:"";
	

?>
<html>
<head>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">

function Detalle(Valores)
{
	window.open("ingreso_transporte_persona_det.php?Valores="+Valores,"","top=120,left=120,width=550,height=350,scrollbars=yes,resizable = no");		
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
function SoloUnElementoCheck()
{
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

function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmIngTransporte;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "IT":
		  window.open("ingreso_transporte_persona_proceso.php?Proceso="+Proceso,"","top=175,left=120,width=550,height=370,scrollbars=no,resizable = no");
		break;
		case "MT":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("ingreso_transporte_persona_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=175,left=120,width=550,height=370,scrollbars=no,resizable = no");		
				}	
			}	
			break;
		case "MP":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("ingreso_transporte_persona_proceso2.php?Proceso=NP&Valores="+Valores,"","top=125,left=120,width=570,height=470,scrollbars=no,resizable = no");	 
				}	
			}	
			break;
		case "E":
			if (SeleccionoCheck()) 
			{
				Resp=confirm("�Est� seguro de Eliminar los Datos Seleccionados y todos sus Dependencias?");
				if (Resp==true)
				{
					Valores=RecuperarValoresCheckeado();
					Frm.action="ingreso_transporte_persona_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}
function Buscar()
{
	var Frm=document.FrmIngTransporte;

	Frm.action="ingreso_transporte_persona.php?BuscarNombre=S";
	Frm.submit();
			
}

function Salir()
{
	var Frm=document.FrmIngTransporte;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=65";
	Frm.submit();
}
</script>
<title>Ingreso de Transporte</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngTransporte" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"> 
	  	<table width='706' height="58" border='1' cellpadding='1' cellspacing='0' >
		<td width="700" height="29" align='center'>
          <input type="button" name="BtnNuevo" value="Ing. Transportista" style="width:130" onClick="MostrarPopupProceso('IT');">        
          <input type="button" name="BtnModificar" value="Modif. Transportista" style="width:130" onClick="MostrarPopupProceso('MT');">        
          <input type="button" name="BtnEliminar" value="Eliminar" style="width:130" onClick="MostrarPopupProceso('E');">
</td>
		</tr><tr>
		  <td align='center'>Buscar por Nombre(Todos *)&nbsp;<input type="text" name="TxtBuscar" value="<?php echo $TxtBuscar;?>"><input type="button" name="BtnOk" value="Ok" size="15" onClick="Buscar()"><input type="button" name="BtnNuevo2" value="Agregar/Modificar Persona " style="width:204" onClick="MostrarPopupProceso('MP');">
		    <input type="button" name="BtnSalir" value="Salir" style="width:130" onClick="Salir();"></td>
		  </tr>
		</table>
	  	<br>
		<?php
		echo "<table width='600' border='1' cellpadding='2' cellspacing='0' >";
		echo "<tr class='ColorTabla01'>"; 
		echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
		echo "<td width='200' align='center'>Rut Transportista</td>";
		echo "<td width='200' align='center'>Nombre Transportista</td>";
		echo "<td width='50' align='center'>Cant</td>";
		echo "</tr>";
		$Consulta="SELECT distinct rut_transportista,nombre_transportista from sec_web.transporte ";
		if($BuscarNombre=='S'&&$TxtBuscar!='*'&&$TxtBuscar!='')
			$Consulta.="where nombre_transportista like '".$TxtBuscar."%' ";
		$Consulta.="order by nombre_transportista";
		//echo $Consulta;
		$Resultado=mysqli_query($link, $Consulta);
		echo "<input type='hidden' name='CheckCod'>";
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			echo "<tr>"; 
			echo "<td align='left'><input type='checkbox' name='CheckCod' value='".$Fila["rut_transportista"]."' onclick=\"CCA(this,'CL03')\"></td>";
			echo "<td align='right'>".$Fila["rut_transportista"]."&nbsp;</td>";
			echo "<td align='left'><a href=JavaScript:Detalle('".$Fila["rut_transportista"]."')>".$Fila["nombre_transportista"]."&nbsp;</a></td>";
			$consulta = "SELECT ifnull(count(*),0) as cant ";
			$consulta.= "FROM sec_web.transporte_persona where rut_transportista='".$Fila["rut_transportista"]."' ";
			$consulta.= "group by rut_transportista";
			$rs = mysqli_query($link, $consulta);
			$FilaCant=mysqli_fetch_array($rs);

			$FilaCant = isset($FilaCant["cant"])?$FilaCant["cant"]:0;

			echo "<td align='right'>".$FilaCant."&nbsp;</td>";
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
	if ($EncontroRelacion==true)
	{
		echo "<script languaje='javascript'>";
		echo "alert('Algunos Elementos No Fueron Eliminados por Tener Personas Asociadas');";
		echo "</script>";
	}
	if ($Msj!='')
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Msj."');";
		echo "</script>";
	}
?>