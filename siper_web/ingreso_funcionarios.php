<? 	
	$CodigoDeSistema = 99;
	$CodigoDePantalla = 10;
	include("../principal/conectar_principal.php");
	if(!isset($TipoBusq))
		$TipoBusq='0';
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
			window.open("ingreso_funcionarios_proceso.php?Proceso="+Proceso,"","top=175,left=120,width=550,height=230,scrollbars=no,resizable = yes,status=yes");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("ingreso_funcionarios_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=175,left=120,width=550,height=265,scrollbars=no,resizable = no");		
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
					Frm.action="ingreso_funcionarios_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
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
			Frm.action="ingreso_funcionarios.php?TipoBusq=1";
			break;
		case "2":
			Frm.CmbRut.value='-1';
			Frm.action="ingreso_funcionarios.php?TipoBusq=2";
			break;
		default:
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
	Frm.action="../principal/sistemas_usuario.php?CodSistema=29&Nivel=1";
	Frm.submit();
}
</script>
<title>SASSO - Ingreso de Funcionarios</title>
<!--<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">-->
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngFun" method="post" action="">
  <? //include("../principal/encabezado.php")?>
  <table width="71%" align="center"  border="0" cellpadding="0"  cellspacing="0">
    <tr>
      <td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15" /></td>
      <td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15" /></td>
      <td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
      <td align="center"><table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
          <tr>		
            <td align="center" valign="top"><span class="formulario"><img src="imagenes/LblCriterios.png" /></span>
              <?
		echo "<table width='740' border='0' cellpadding='1' cellspacing='0' >";
		echo "<tr >"; 
		echo "<td align='left' class='formulario'>Usuarios&nbsp;&nbsp;";
		echo "<SELECT name='CmbRut' style='width:320' onchange=Recarga('')>";
		echo "<option value='-1'>SELECCIONAR</option>";
		$Consulta="SELECT t1.rut,t1.apellido_paterno,t1.apellido_materno,t1.nombres from proyecto_modernizacion.funcionarios t1 inner join sistemas_por_usuario t2 on t1.rut=t2.rut where t2.cod_sistema='29' order by apellido_paterno";
		$Resultado=mysqli_query($link, $Consulta);
		while ($Fila=mysql_fetch_array($Resultado))
		{
			if(strlen($Fila["rut"])==9)
				$Rut='0'.$Fila["rut"];	
			else
				$Rut=$Fila["rut"];				
			$Nombre=$Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"];
			if ($CmbRut==$Fila["rut"])			
				echo "<option value='".$Fila["rut"]."' SELECTed>".$Rut."-".strtoupper($Nombre)."</option>";
			else
				echo "<option value='".$Fila["rut"]."'>".$Rut."-".strtoupper($Nombre)."</option>";
		}
		echo "</SELECT>";
		echo "</td>";
		echo "<td align='center' class='formulario'>";
		?>
		   <a href="JavaScript:MostrarPopupProceso('N')"><img src="imagenes/btn_agregar.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp; 
		   <a href="JavaScript:MostrarPopupProceso('M')"><img src="imagenes/btn_modificar.png" alt="Modificar" width="30" height="30" border="0" align="absmiddle"></a>&nbsp; 
		   <a href="JavaScript:MostrarPopupProceso('E')"><img src="imagenes/btn_eliminar2.png"  alt="Eliminar" width="25" height="25" border="0" align="absmiddle"></a>&nbsp; 
		   <a href="JavaScript:Salir()"><img src="imagenes/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a> 
               <!--<input type="button" name="BtnNuevo" value="Nuevo" style="width:70" onclick="MostrarPopupProceso('N');" />
                <input type="button" name="BtnModificar" value="Modificar" style="width:70" onclick="MostrarPopupProceso('M');" />
                <input type="button" name="BtnEliminar" value="Eliminar" style="width:70" onclick="MostrarPopupProceso('E');" />
                <input type="button" name="BtnSalir" value="Salir" style="width:70" onclick="Salir();" />-->
                <?
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='formulario'>&nbsp;&nbsp;Rut&nbsp;<input name='TxtRut' type='text' value='$TxtRut' style='width:85'>&nbsp;<a href=JavaScript:Recarga('1')><img src='imagenes/Btn_buscar.gif'   alt='OK' width='20' height='20'  border='0' align='absmiddle' /></a>&nbsp;&nbsp;&nbsp;Apellido Pate.&nbsp;&nbsp;";
		echo "<input name='TxtApePaterno' type='text' style='width:130' value='$TxtApePaterno'>&nbsp;<a href=JavaScript:Recarga('2')><img src='imagenes/Btn_buscar.gif'   alt='OK' width='20' height='20'  border='0' align='absmiddle' /></a>";
		echo "</td>";
		echo "<td class='formulario'>&nbsp;";
		echo "</td>";
		echo "</tr>"; 
		echo "</table><br>";
		?>
 			</td>
          </tr>
      </table></td>
      <td width="1%" background="imagenes/interior2/form_der.gif"></td>
    </tr>
    <tr>
      <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15" /></td>
      <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15" /></td>
      <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15" /></td>
    </tr>
  </table><br>
  <table width="71%" align="center"  border="0" cellpadding="0"  cellspacing="0">
    <tr>
      <td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15" /></td>
      <td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15" /></td>
      <td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
      <td align="center"><table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
          <tr>		
            <td align="center" valign="top">  		
		<?
		echo "<table width='740' border='1' cellpadding='2' cellspacing='0' >";
		echo "<tr class='TituloCabecera'>"; 
		echo "<td width='20'><input type='checkbox' name='CheckTodos' class='SinBorde' value='checkbox' onClick='CheckearTodo();'></td>";
		echo "<td width='80' align='center'>Rut</td>";
		echo "<td width='280' align='center'>Nombres</td>";
		echo "<td width='100' align='center'>Perfil </td>";
		echo "</tr>";
		//echo $TipoBusq."<br>";
		switch($TipoBusq)
		{
			case "0"://BUSQUEDA CENTRO DE COSTO
				$CodCCosto='02-'.substr($CmbCCosto,0,2).".".substr($CmbCCosto,2,2);
				$Consulta="SELECT * from proyecto_modernizacion.funcionarios t1 inner join proyecto_modernizacion.sistemas_por_usuario t2 on t1.rut=t2.rut";
				$Consulta.=" inner join proyecto_modernizacion.niveles_por_sistema t3 on t2.cod_sistema=t3.cod_sistema and t2.nivel=t3.nivel";
				$Consulta.=" where t2.cod_sistema='29' and t1.rut='".$CmbRut."' order by apellido_paterno";
				break;
			case "1"://BUSQUEDA POR RUT
				$Consulta="SELECT * from proyecto_modernizacion.funcionarios t1 inner join proyecto_modernizacion.sistemas_por_usuario t2 on t1.rut=t2.rut";
				$Consulta.=" inner join proyecto_modernizacion.niveles_por_sistema t3 on t2.cod_sistema=t3.cod_sistema and t2.nivel=t3.nivel";
				$Consulta.=" where t2.cod_sistema='29' and t1.rut='".$TxtRut."' order by apellido_paterno";
				break;
			case "2"://BUSQUEDA POR APELLIDO PATERNO
				$Consulta="SELECT * from proyecto_modernizacion.funcionarios t1 inner join proyecto_modernizacion.sistemas_por_usuario t2 on t1.rut=t2.rut";
				$Consulta.=" inner join proyecto_modernizacion.niveles_por_sistema t3 on t2.cod_sistema=t3.cod_sistema and t2.nivel=t3.nivel";
				$Consulta.=" where t2.cod_sistema='29' and apellido_paterno like '".$TxtApePaterno."%' order by apellido_paterno";
				break;
		}
		$Resultado=mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		echo "<input type='hidden' name='CheckCod'>";$Cont=0;
		while ($Fila=mysql_fetch_array($Resultado))
		{
			$Cont=$Cont+1;
			$Nombre=$Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"];
			echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">"; 
			echo "<td align='left'><input type='checkbox' name='CheckCod' class='SinBorde' value='".$Fila["rut"]."' onClick=\"CCA(this,'CL03')\"></td>";
			echo "<td align='left'>".$Fila["rut"]."</td>";
			echo "<td align='left'>".$Nombre."</td>";
			echo "<td align='left'>".$Fila["descripcion"]."</td>";
			echo "</tr>";
			//echo $Consulta."<br>";
		}
		echo "</table>";
		?>           
		 </td>
          </tr>
      </table></td>
      <td width="1%" background="imagenes/interior2/form_der.gif"></td>
    </tr>
    <tr>
      <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15" /></td>
      <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15" /></td>
      <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15" /></td>
    </tr>
  </table>
  <? //include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?
	if ($EncontroRelacion==true)
	{
		echo "<script languaje='javascript'>";
		echo "alert('Algunos Elementos No Fueron Eliminados por Tener SubClases Asociadas');";
		echo "</script>";
	}
?>