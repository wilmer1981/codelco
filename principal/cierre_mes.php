<?php 
	$CodigoDeSistema = 16;
	$CodigoDePantalla = 5;
	include("conectar_principal.php");

	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["Sistema"])){
		$Sistema = $_REQUEST["Sistema"];
	}else{
		$Sistema = "";
	}

	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = date("Y");
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date("m");
	}
	if(isset($_REQUEST["VerTodo"])){
		$VerTodo = $_REQUEST["VerTodo"];
	}else{
		$VerTodo = "";
	}

	
	

	//CONSULTA ESTADO Y ULTIMA FECHA ESTADO
	$Estado = "";
	$UltFecha = "";
	/*
	if (!isset($Ano))
		$Ano = date("Y");
	if (!isset($Mes))
		$Mes = date("n");
	*/
	if ($Proceso=="R")
	{
		$Consulta = "select * from proyecto_modernizacion.sistemas ";
		$Consulta.= " where cierre='S'";
		if ($Sistema!="S")
		{
			$Consulta.= " and cod_sistema='".$Sistema."'";
		}
		$RespAux = mysqli_query($link, $Consulta);
		$SistemasNoCerrar="";
		$SistemasCerrar="";
		$SistemasAbrir="";
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{
			//CONSULTA ESTADO CIERRE PARCIAL	
			$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
			$Consulta.= " where cod_sistema='".$FilaAux["cod_sistema"]."'";
			$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1' and fecha_cierre = (";
			$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
			$Consulta.= " where cod_sistema='".$FilaAux["cod_sistema"]."'";
			$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1')";
			$Resp = mysqli_query($link, $Consulta);
			$CierreOpe = "";
			$FechaCierreOpe = "";
			if ($Fila = mysqli_fetch_array($Resp))
			{			
				if ($Fila["estado"] == "C")
				{
					$CierreOpe= $Fila["estado"];
					$FechaCierreOpe = $Fila["fecha_cierre"];
				}
			}//FIN CIERRE PARCIAL		
			//CONSULTA CIERRE GENERAL
			$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
			$Consulta.= " where cod_sistema='".$FilaAux["cod_sistema"]."'";
			$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2' and fecha_cierre = (";
			$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
			$Consulta.= " where cod_sistema='".$FilaAux["cod_sistema"]."'";
			$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2')";
			$Resp = mysqli_query($link, $Consulta);
			
			if ($Fila = mysqli_fetch_array($Resp))
			{
				if ($Sistema=="S")
				{
					if ($Fila["estado"]=="C" && $CierreOpe=="C")
						$SistemasAbrir = $SistemasAbrir.$FilaAux["nombre"].", ";
					else
						if ($Fila["estado"]!="C" && $CierreOpe=="C")
							$SistemasCerrar = $SistemasCerrar.$FilaAux["nombre"].", ";
						else
							if ($Sistema=="S" && $CierreOpe!="C")
								$SistemasNoCerrar = $SistemasNoCerrar.$FilaAux["nombre"].", ";
				}
				else
				{
					$Estado = $Fila["estado"];
					$UltFecha = $Fila["fecha_cierre"];
				}
			}
			else
			{
				if ($Sistema=="S" && $CierreOpe=="C")
					$SistemasCerrar = $SistemasCerrar.$FilaAux["nombre"].", ";
				else
					if ($Sistema=="S" && $CierreOpe!="C")
						$SistemasNoCerrar = $SistemasNoCerrar.$FilaAux["nombre"].", ";
			}//FIN CIERRE GENERAL			
		}//FIN WHILE SISTEMAS	
	}
?>
<html>
<head>
<title>Administrador de Sistemas</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{	
		case "A":
			var Pag = "../principal/abrir_mes_anexo.php?Proc=A&BalanceMes=S&Sistema=" + f.Sistema.value + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			window.open(Pag,"","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
			break;
		case "C":
			var Pag = "../principal/abrir_mes_anexo.php?Proc=C&BalanceMes=S&Sistema=" + f.Sistema.value + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			window.open(Pag,"","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
			break;
		case "I":
			window.print();
			break;
		case "R":
			f.action = "cierre_mes.php?Proceso=R";
			f.submit();
			break;
		case "S":
			f.action = "sistemas_usuario.php?CodSistema=16&Nivel=0";
			f.submit();
			break;
		case "VT":
			f.action = "cierre_mes.php?Proceso=R&VerTodo=S";
			f.submit();
			break;
	}
}

function Detalle(Sist, AnoCons, MesCons)
{
	var f = document.frmPrincipal;
	var Pag = "cierre_mes_detalle.php?Sistema=" + Sist + "&Ano=" + AnoCons + "&Mes=" + MesCons;
	window.open(Pag,"","top=70,left=20,width=550,height=400,scrollbars=yes,resizable = yes");	
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body leftmargin="3" topmargin="2">
<form name="frmPrincipal" method="post" action="">
<?php include("encabezado.php");?> 
<table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td height="313" valign="top">
  <table width="700" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr> 
      <td width="23%">Mes:</td>
      <td width="77%">        <select name="Mes" onChange="Proceso('R')">
 <?php
	for ($i=1;$i<=12;$i++)
	{
		if (isset($Mes))
		{
			if ($i==$Mes)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}/*
		else
		{
			if ($i==date("n"))
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}*/
	}
?>	  
        </select>
        <select name="Ano" onChange="Proceso('R')">
          <?php
	for ($i=(date("Y")-4);$i<=date("Y");$i++)
	{
		if (isset($Ano))
		{
			if ($i==$Ano)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}/*
		else
		{
			if ($i==date("Y"))
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}*/
	}
?>
        </select>        </td>
  </tr>
    <tr> 
      <td>Sistema: </td>
      <td><select name="Sistema" onChange="Proceso('R')">
        <option value="S">TODOS</option>
        <?php
			$Consulta = "select * from proyecto_modernizacion.sistemas where cierre='S' order by nombre ";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{
				if ($Sistema == $Fila["cod_sistema"])
					echo "<option selected value='".$Fila["cod_sistema"]."'>".strtoupper($Fila["descripcion"])."</option>\n";
				else
					echo "<option value='".$Fila["cod_sistema"]."'>".strtoupper($Fila["descripcion"])."</option>\n";
			}
		?>
      </select>
        </td>
    </tr>
<?php
	if ($Proceso=="R" && $Sistema != "S")
	{	
    	echo "<tr valign='middle'>\n";
      	echo "<td height='20'>Fecha \n"; 
		if ($Estado == "")
		{
			echo "Cierre";
		}
		else
		{
			if ($Estado == "C")
			{
				echo "Cierre";
			}
			else
			{
				echo "Apertura";
			}
		}
		echo "</td>\n";
		echo "<td height='20'>";
		if ($UltFecha == "")	
			echo date("Y-m-d");
		else
			echo $UltFecha;
		echo "</td>\n";
		echo "</tr>";
    	echo "<tr class='ColorTabla02'>";
      	echo "<td>Cierre General</td>";
		echo "<td>";
		if ($Estado != "")
		{
			if ($Estado == "C")
			{
				echo "<img src='imagenes/cand_cerrado.gif'>\n";
			}
			else
			{
				if ($Estado=="A")
					echo "<img src='imagenes/cand_abierto.gif'>\n";
			}
		}
		else
		{
			echo "<img src='imagenes/cand_abierto.gif'>\n";
		}
		echo "</td>";
    	echo "</tr>";   
		echo "<tr class='ColorTabla02'>";
		echo "<td>Cierre Parcial</td>";
		echo "<td>";
		if ($CierreOpe == "C")
			echo "<img src='imagenes/cand_cerrado.gif'>&nbsp;".$FechaCierreOpe;
		else
			echo "<img src='imagenes/cand_abierto.gif'>&nbsp;No se puede hacer Cierre General";
		echo "</td></tr>\n";      
	}
	else
	{
		if ($Proceso=="R" && $Sistema == "S")
		{
			echo "<tr class='ColorTabla02'>";
			echo "<td>Sistema Que se Pueden Cerrar</td>";
			echo "<td>";
			if ($SistemasCerrar != "")
			{
				$Largo = strlen($SistemasCerrar);
				echo substr($SistemasCerrar,0,$Largo-2);
			}
			else
			{
				echo "&nbsp;";
			}
			echo "</td></tr>\n"; 
			echo "<tr class='ColorTabla02'>";
			echo "<td>Sistema Que se Pueden Abrir</td>";
			echo "<td>";
			if ($SistemasAbrir != "")
			{
				$Largo = strlen($SistemasAbrir);
				echo substr($SistemasAbrir,0,$Largo-2);
			}
			else
			{
				echo "&nbsp;";
			}
			echo "</td></tr>\n";
			echo "<tr class='ColorTabla02'>";	
			echo "<td><font color='red'>Sistema Que se No Pueden Cerrar por Falta de Cierre Parcial</font></td>";
			echo "<td><font color='red'>";
			if ($SistemasNoCerrar != "")
			{
				$Largo = strlen($SistemasNoCerrar);
				echo substr($SistemasNoCerrar,0,$Largo-2);
			}
			else
			{
				echo "&nbsp;";
			}
			echo "</font></td></tr>\n";		
		}//FIN SISTEMA =="S"
	}//FIN SISTEMA <> "S"
 	
?>	    
    <tr align="center" valign="middle"> 
      <td height="20" colspan="2"> 
<?php	  
	if ($Sistema == "S")
	{
		echo "<input name='BtnAbrir' type='button' style='width:120px' onClick=\"Proceso('A')\" value='Abrir Cierre General'>\n";
		echo "<input name='BtnCerrar' type='button' style='width:120px' onClick=\"Proceso('C')\" value='Cierre General'>\n";
	}
	else
	{
		if ($Estado != "")
		{
			if ($Estado == "C")
			{
				echo "<input name='BtnAbrir' type='button' style='width:120px' onClick=\"Proceso('A')\" value='Abrir Cierre General'>\n";
			}
			else
			{
				if ($Estado=="A" && $CierreOpe == "C")
					echo "<input name='BtnCerrar' type='button' style='width:120px' onClick=\"Proceso('C')\" value='Cierre General'>\n";
			}
		}
		else
		{
			if ($Proceso=="R" && $CierreOpe == "C")
				 echo "<input name='BtnCerrar' type='button' style='width:120px' onClick=\"Proceso('C')\" value='Cierre General'>\n";
		}  
	}//FIN SISTEMAS == "S"       
?>		  
&nbsp;
          <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:120px" onClick="Proceso('I')" value="Imprimir">
              &nbsp;
              <input name="btnVerTodo" type="button" value="Ver A&ntilde;o Completo" onClick="Proceso('VT')" style="width:120px">
              &nbsp;  
              <input name="btnSalir" type="button" value="Salir" onClick="Proceso('S')" style="width:120px"></td>
    </tr>    
  </table>
<br>
<table width="700"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td colspan="7"><strong>HISTORICO DE CIERRES DEL A&Ntilde;O <?php echo $Ano; ?></strong></td>
    </tr>
  <tr align="center" class="ColorTabla01">
    <td width="72">Mes</td>
    <td width="73">Sistema</td>
    <td width="146">Fecha Cierre General </td>
    <td width="43">Cierre<br>
      General</td>
    <td width="196">Responsable Cierre General </td>
    <td width="49">Detalle</td>
    <td width="76">Cierre <br>
      Parcial</td>
  </tr>
<?php	
	$Consulta = "select * from proyecto_modernizacion.sistemas ";
	$Consulta.= " where cierre='S'";
	$Resp = mysqli_query($link, $Consulta);
	$CantSistemas = mysqli_num_rows($Resp);
	$Color="";
	if ($VerTodo == "S")
	{
		$MesIni = 1;
		$MesFin = 12;
	}
	else
	{
		$MesIni = $Mes;
		$MesFin = $Mes;
	}
	for ($i=$MesFin;$i>=$MesIni;$i--)
	{
		if ($Color == "")
			$Color = "#FFFFFF";
		else
			$Color = "";
		echo "<tr align='center' bgcolor='".$Color."'>\n";
		echo "<td rowspan='".$CantSistemas."'>".$Meses[$i-1]."</td>\n";
		$Consulta = "select * from proyecto_modernizacion.sistemas where cierre='S' ORDER BY nombre";
		$Resp = mysqli_query($link, $Consulta);
		$j=1;
		while ($Fila = mysqli_fetch_array($Resp))
		{			
			$Consulta = "select cod_sistema, estado, fecha_cierre, rut_funcionario from proyecto_modernizacion.cierre_mes";
			$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
			$Consulta.= " and ano='".$Ano."' and mes='".$i."' and cod_bloqueo='2' and fecha_cierre = (";
			$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
			$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
			$Consulta.= " and ano='".$Ano."' and mes='".$i."' and cod_bloqueo='2')";
			$Resp2 = mysqli_query($link, $Consulta);	
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				if ($j!=1)				
					echo "<tr align='center' bgcolor='".$Color."'>\n";
				echo "<td>".$Fila["nombre"]."</td>\n";
				echo "<td>".$Fila2["fecha_cierre"]."</td>\n";
				if ($Fila2["estado"]=="C")
					echo "<td><img src='imagenes/cand_cerrado.gif'></td>\n";
				else
					echo "<td><img src='imagenes/cand_abierto.gif'></td>\n";
				$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Fila2["rut_funcionario"]."'";
				$Resp3 = mysqli_query($link, $Consulta);
				if ($Fila3 = mysqli_fetch_array($Resp3))
				{
					$Nombre = ucwords(strtolower($Fila3["nombres"]))." ".ucwords(strtolower($Fila3["apellido_paterno"]))." ".ucwords(strtolower($Fila3["apellido_materno"]));
					echo "<td>".$Nombre."</td>\n";
				}				
				else
				{	
					echo "<td>No Encontrado</td>\n";
				}
				echo "<td><a href=\"JavaScript:Detalle('".$Fila["cod_sistema"]."','".$Ano."','".$i."')\">Detalle</a></td>\n";
				//CONSULTA POR EL CIERRE OPERACIONAL
				$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
				$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
				$Consulta.= " and ano='".$Ano."' and mes='".$i."' and cod_bloqueo='1' and fecha_cierre = (";
				$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
				$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
				$Consulta.= " and ano='".$Ano."' and mes='".$i."' and cod_bloqueo='1')";
				$Resp3 = mysqli_query($link, $Consulta);
				if ($Fila3 = mysqli_fetch_array($Resp3))
				{
					if ($Fila3["estado"] == "A")
					{
						echo "<td><img src='imagenes/cand_abierto.gif'></td>\n";
					}
					else
					{
						if ($Fila3["estado"] == "C")
							echo "<td><img src='imagenes/cand_cerrado.gif'></td>\n";
						else
							echo "<td><img src='imagenes/cand_abierto.gif'></td>\n";
					}
				}			
				else
				{
					echo "<td><img src='imagenes/cand_abierto.gif'></td>\n";
				}						
				echo "</tr>\n";
				$j++;
			}
			else
			{
				if ($j!=1)				
					echo "<tr align='center' bgcolor='".$Color."'>\n";
				echo "<td>".$Fila["nombre"]."</td>\n";
				echo "<td>SIN CIERRE</td>\n";
				echo "<td><img src='imagenes/cand_abierto.gif'></td>\n";
				echo "<td>&nbsp;</td>\n";
				echo "<td><a href=\"JavaScript:Detalle('".$Fila["cod_sistema"]."','".$Ano."','".$i."')\">Detalle</a></td>\n";
				//CONSULTA POR EL CIERRE OPERACIONAL
				$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
				$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
				$Consulta.= " and ano='".$Ano."' and mes='".$i."' and cod_bloqueo='1' and fecha_cierre = (";
				$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
				$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
				$Consulta.= " and ano='".$Ano."' and mes='".$i."' and cod_bloqueo='1')";
				$Resp3 = mysqli_query($link, $Consulta);
				if ($Fila3 = mysqli_fetch_array($Resp3))
				{
					if ($Fila3["estado"] == "A")
					{
						echo "<td><img src='imagenes/cand_abierto.gif'></td>\n";
					}
					else
					{
						if ($Fila3["estado"] == "C")
							echo "<td><img src='imagenes/cand_cerrado.gif'></td>\n";
						else
							echo "<td><img src='imagenes/cand_abierto.gif'></td>\n";
					}
				}			
				else
				{
					echo "<td><img src='imagenes/cand_abierto.gif'></td>\n";
				}						
				echo "</tr>\n";
				$j++;
			}
		}
	}
?>  
</table>      </td>
    </tr>
  </table>
<?php include("pie_pagina.php");?>
</form>
</body>
</html>
<?php include ("cerrar_principal.php") ?>
