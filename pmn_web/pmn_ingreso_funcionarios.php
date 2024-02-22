<?php 	
	$CodigoDeSistema = 99;
	$CodigoDePantalla = 10;
	include("../principal/conectar_principal.php");
	/*if(!isset($TipoBusq))
		$TipoBusq='0';*/

		if(isset($_REQUEST["TipoBusq"])){
			$TipoBusq = $_REQUEST["TipoBusq"];
		}else{
			$TipoBusq = '0';
		}

		if(isset($_REQUEST["CmbCCosto"])){
			$CmbCCosto = $_REQUEST["CmbCCosto"];
		}else{
			$CmbCCosto = "";
		}
		if(isset($_REQUEST["CmbRut"])){
			$CmbRut = $_REQUEST["CmbRut"];
		}else{
			$CmbRut = "";
		}
		if(isset($_REQUEST["TxtApePaterno"])){
			$TxtApePaterno = $_REQUEST["TxtApePaterno"];
		}else{
			$TxtApePaterno = "";
		}

		if(isset($_REQUEST["TxtRut"])){
			$TxtRut = $_REQUEST["TxtRut"];
		}else{
			$TxtRut = "";
		}

		if(isset($_REQUEST["EncontroRelacion"])){
			$EncontroRelacion = $_REQUEST["EncontroRelacion"];
		}else{
			$EncontroRelacion = "";
		}


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
	//alert(Valores);
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
	switch (Proceso)
	{
		case "N":
			window.open("pmn_ingreso_funcionarios_proceso.php?Proceso="+Proceso,"","top=175,left=120,width=550,height=230,scrollbars=no,resizable = yes,status=yes");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("pmn_ingreso_funcionarios_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=175,left=120,width=590,height=265,scrollbars=no,resizable = no,status=yes");		
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
					//alert(Valores);
					Frm.action="pmn_ingreso_funcionarios_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
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
			Frm.CmbRut.value='-1';
			Frm.action="pmn_ingreso_funcionarios.php?TipoBusq=1";
			break;
		case "2":
			Frm.CmbRut.value='-1';
			Frm.action="pmn_ingreso_funcionarios.php?TipoBusq=2";
			break;
		default:
			Frm.action="pmn_ingreso_funcionarios.php?TipoBusq=0";		
	}
	Frm.submit();
}
function Detalle(Valores)
{
	window.open("pmn_ingreso_funcionario_detalle.php?Valores="+Valores,"","top=120,left=120,width=550,height=400,scrollbars=yes,resizable = no");		
}
function SistemasAsociados(funcionarios)
{
	window.open("pmn_ing_fun_nivel.php?funcionarios="+funcionarios,"","top=5,left=0,width=770,height=550,scrollbars=yes,resizable = no");		
}

function Salir()
{
	var Frm=document.FrmIngFun;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=6";
	Frm.submit();
}
</script>
<title>PMN - Asociaci�n Funcionario Proceso</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngFun" method="post" action="">
  <?php //include("../principal/encabezado.php")?>
  <table width="71%" align="center"  border="0" cellpadding="0"  cellspacing="0">
    <tr>
      <td height="1%"><img src="archivos/images/interior/esq3.png"></td>
      <td width="98%"background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif"></td>
      <td height="1%"><img src="archivos/images/interior/esq2.png"></td>
    </tr>
    <tr>
      <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
      <td align="center"><table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
          <tr>		
            <td align="center" valign="top"><span class="formulario"><img src="archivos/LblCriterios.png" /></span>
              <?php
		echo "<table width='740' border='0' cellpadding='1' cellspacing='0' >";
		echo "<tr >"; 
		echo "<td align='left' class='formulario'>Usuarios&nbsp;&nbsp;";
		echo "<select name='CmbRut' style='width:320' onchange=Recarga('')>";
		echo "<option value='-1'>Seleccionar</option>";
		$Consulta="select distinct t1.rut,t1.apellido_paterno,t1.apellido_materno,t1.nombres from proyecto_modernizacion.funcionarios t1 inner join proyecto_modernizacion.sub_clase t2 on t1.rut=t2.nombre_subclase where t2.cod_clase='6002' order by apellido_paterno";
		$Resultado=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			if(strlen($Fila["rut"])==9)
				$Rut='0'.$Fila["rut"];	
			else
				$Rut=$Fila["rut"];				
			$Nombre=ucfirst(strtolower($Fila["apellido_paterno"]))." ".ucfirst(strtolower($Fila["apellido_materno"]))." ".ucfirst(strtolower($Fila["nombres"]));
			if ($CmbRut==$Fila["rut"])			
				echo "<option value='".$Fila["rut"]."' selected>".$Nombre."</option>";
			else
				echo "<option value='".$Fila["rut"]."'>".$Nombre."</option>";
		}
		echo "</select>";
		echo "</td>";
		echo "<td align='center' class='formulario'>";
		?>
		   <a href="JavaScript:MostrarPopupProceso('N')"><img src="archivos/btn_nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp; 
		   <a href="JavaScript:MostrarPopupProceso('M')"><img src="archivos/btn_modificar.png" alt="Modificar" width="25" height="25" border="0" align="absmiddle"></a>&nbsp; 
		   <a href="JavaScript:MostrarPopupProceso('E')"><img src="archivos/btn_eliminar2.png"  alt="Eliminar" width="25" height="25" border="0" align="absmiddle"></a>&nbsp; 
		   <a href="JavaScript:Salir()"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a> 
               <!--<input type="button" name="BtnNuevo" value="Nuevo" style="width:70" onclick="MostrarPopupProceso('N');" />
                <input type="button" name="BtnModificar" value="Modificar" style="width:70" onclick="MostrarPopupProceso('M');" />
                <input type="button" name="BtnEliminar" value="Eliminar" style="width:70" onclick="MostrarPopupProceso('E');" />
                <input type="button" name="BtnSalir" value="Salir" style="width:70" onclick="Salir();" />-->
                <?php
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='formulario'>Rut&nbsp;<input name='TxtRut' type='text' value='".$TxtRut."' style='width:85'>&nbsp;<a href=JavaScript:Recarga('1')><img src='archivos/Btn_buscar.gif'   alt='OK' width='20' height='20'  border='0' align='absmiddle' /></a>&nbsp;&nbsp;&nbsp;Apellido Pate.&nbsp;&nbsp;";
		echo "<input name='TxtApePaterno' type='text' style='width:130' value='".$TxtApePaterno."'>&nbsp;<a href=JavaScript:Recarga('2')><img src='archivos/Btn_buscar.gif'   alt='OK' width='20' height='20'  border='0' align='absmiddle' /></a>";
		echo "</td>";
		echo "<td class='formulario'>&nbsp;";
		echo "</td>";
		echo "</tr>"; 
		echo "</table><br>";
		?>
 			</td>
          </tr>
      </table></td>
      <td width="1%" background="archivos/images/interior/derecho.png"></td>
    </tr>
    <tr>
      <td width="1%"><img src="archivos/images/interior/esq1.png"></td>
      <td background="archivos/images/interior/abajo.png"><img src="archivos/images/interior/transparent.gif"></td>
      <td width="1%"><img src="archivos/images/interior/esq4.png"/></td>
    </tr>
  </table><br>
  <table width="71%" align="center"  border="0" cellpadding="0"  cellspacing="0">
    <tr>
      <td height="1%"><img src="archivos/images/interior/esq3.png"></td>
      <td width="98%" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif"></td>
      <td height="1%"><img src="archivos/images/interior/esq2.png"></td>
    </tr>
    <tr>
      <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
      <td align="center"><table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
          <tr>		
            <td align="center" valign="top">  		
		<?php
		echo "<table width='740' border='1' cellpadding='2' cellspacing='0' >";
		echo "<tr class='LinkPestana'>"; 
		echo "<td width='20'><input type='checkbox' name='CheckTodos' class='SinBorde' value='checkbox' onClick='CheckearTodo();'></td>";
		echo "<td width='80' align='center'>Rut</td>";
		echo "<td width='280' align='center'>Nombres</td>";
		echo "<td width='100' align='center'>Tipo Operador</td>";
		echo "</tr>";
		//echo "Tipo Busqiueda:".$TipoBusq."<br>";
		switch($TipoBusq)
		{
			case "0"://BUSQUEDA POR USUARIO
				$CodCCosto='02-'.substr($CmbCCosto,0,2).".".substr($CmbCCosto,2,2);
				$Consulta="select * from proyecto_modernizacion.funcionarios t1 inner join ";
				$Consulta.="proyecto_modernizacion.sub_clase t2 on t2.cod_clase='6002' and  t1.rut=t2.nombre_subclase where t1.rut='".$CmbRut."' order by apellido_paterno";
				break;
			case "1"://BUSQUEDA POR RUT
				$Consulta="select * from proyecto_modernizacion.funcionarios t1 inner join ";
				$Consulta.="proyecto_modernizacion.sub_clase t2 on t2.cod_clase='6002' and t1.rut=t2.nombre_subclase where  t1.rut='".$TxtRut."' order by apellido_paterno";
				break;
			case "2"://BUSQUEDA POR APELLIDO PATERNO
				$Consulta="select * from proyecto_modernizacion.funcionarios t1 inner join ";
				$Consulta.="proyecto_modernizacion.sub_clase t2 on t2.cod_clase='6002' and t1.rut=t2.nombre_subclase where  apellido_paterno like '".$TxtApePaterno."%' order by apellido_paterno";
				break;
		}
		$Resultado=mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		echo "<input type='hidden' name='CheckCod'>";
		$Cont=0;
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			$Cont=$Cont+1;
			//var_dump($Fila);
			if(isset($Fila["valor_subclase1"])){
				$valorsubclase = $Fila["valor_subclase1"];
			}else{
				$valorsubclase = "";
			}
			//var_dump($Fila);
			
			$Nombre=ucfirst(strtolower($Fila["apellido_paterno"]))." ".ucfirst(strtolower($Fila["apellido_materno"]))." ".ucfirst(strtolower($Fila["nombres"]));;
			$ConsultaNomOpe = "SELECT  * from proyecto_modernizacion.sub_clase where cod_clase='6004' and cod_subclase='".$valorsubclase."'";
			$ResulNomOpe = mysqli_query($link, $ConsultaNomOpe);
			$FilaOpe     = mysqli_fetch_array($ResulNomOpe);
			//$NomOperador=$FilaOpe["nombre_subclase"];
			if(isset($FilaOpe["nombre_subclase"])){
				$NomOperador = $FilaOpe["nombre_subclase"];
			}else{
				$NomOperador = "";
			}
			echo "<tr class='texto_bold'>"; 
			echo "<td align='left'><input type='checkbox' name='CheckCod' class='SinBorde' value='".$Fila["rut"]."~".$valorsubclase."'></td>";
			echo "<td align='left'>".$Fila["rut"]."</td>";
			echo "<td align='left'>".$Nombre."</td>";
			echo "<td align='left'>".$NomOperador."</td>";
			echo "</tr>";
			//echo $Consulta."<br>";
		}
		echo "</table>";
		?>           
		 </td>
          </tr>
      </table></td>
      <td width="1%" background="archivos/images/interior/derecho.png"></td>
    </tr>
    <tr>
      <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"></td>
      <td height="15" background="archivos/images/interior/abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"  /></td>
    </tr>
  </table>
  <?php //include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if ($EncontroRelacion==true)
	{
		echo "<script languaje='javascript'>";
		echo "alert('Algunos Elementos No Fueron Eliminados por Tener SubClases Asociadas');";
		echo "</script>";
	}
?>