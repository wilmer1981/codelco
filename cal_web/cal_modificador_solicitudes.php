<?php 	
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 38;
	include("../principal/conectar_principal.php");
?>
<html>
<head>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmSolicitud;
	var Valores="";
	for (i=1;i<Frm.CheckSol.length;i++)
	{
		if (Frm.CheckSol[i].checked==true)
		{
	
			Valores=Valores + Frm.TxtNumSolO[i].value+"//";
		}
	}
	return(Valores);
}	
function SoloUnElementoCheck()
{
	var Frm=document.FrmSolicitud;
	var CantCheck=0;
	for (i=1;i<Frm.CheckSol.length;i++)
	{
		if (Frm.CheckSol[i].checked==true)
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
	var Frm=document.FrmSolicitud;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckSol.length;i++)
	{
		if (Frm.CheckSol[i].checked==true)
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
	var Frm=document.FrmSolicitud;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("cal_modificador_solicitud_proceso.php?Proceso="+Proceso +"&Valores="+Valores,"","top=110,left=10,width=760,height=370,scrollbars=yes,resizable = yes");
				}	
			}	
			break;
	} 
}

function Salir()
{
	var Frm=document.FrmSolicitud;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=1";
	Frm.submit();
}
function Historial(SA)
{
	window.open("cal_con_registro_leyes.php?SA="+ SA,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function Buscar()
{
	var Frm=document.FrmSolicitud;
	Frm.action="cal_modificador_solicitudes.php?Mostrar=S";
	Frm.submit();
}

</script>
<title>Modificador de Solicitudes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmSolicitud" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"><table width="750" border="0">
          <tr> 
            <td width="199"><font size="1">&nbsp;</font></td>
            <td width="41"><font size="1"><font size="2">#SolI</font></font></td>
            <td width="67"><font size="1"><font size="1"><font size="2"> 
              <select name="AnoIni2" style="width:60px;">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoIni2))
				{
					if ($i == $AnoIni2)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		?>
              </select>
              </font></font></font></td>
            <td width="76"><font size="1"><font size="1"><font size="1"><font size="2"> 
              <input name="NumIni" type="text" id="NumIni" value="<?php echo $NumIni; ?>" size="10" maxlength="15">
              </font></font></font></font></td>
            <td width="36"><font size="1"><font size="1"><font size="2">#SolF</font></font></font></td>
            <td width="72"><select name="AnoFin2" style="width:60px;">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoFin2))
				{
					if ($i == $AnoFin2)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		?>
              </select></td>
            <td width="229"><input name="NumFin" type="text" id="NumFin3" value="<?php echo $NumFin; ?>" size="10" maxlength="15">
            </td>
          </tr>
          <tr> 
            <td height="14">&nbsp;</td>
            <td height="14">&nbsp;</td>
            <td height="14">&nbsp;</td>
            <td height="14"><input name="BtnBuscar" type="button" id="BtnBuscar2" style="width:70px;" onClick="Buscar();" value="Buscar"></td>
            <td height="14" colspan="3"><input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:60" onClick="Salir();" ></td>
          </tr>
        </table>
        <br> 
       
 <?php			
 echo " <table width='750' border='0' cellpadding='3' cellspacing='0' bordercolor='#b26c4a' class='TablaDetalle'>";
   echo "<tr class='ColorTabla01'>";
      echo "<td width='15'>";/*<input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'>*/
	  echo "</td>";
      echo "<td width='58' align='left'>N�Sol</td>";
      echo "<td width='81' align='left'>IdMuestra</td>";
      echo "<td width='125' align='left'>Agrupacion</td>";
	  echo "<td width='125' align='left'>Producto</td>";
      echo "<td width='163' align='left'>SubProducto</td>";
      echo "<td width='100' align='left'>Originador</td>";
      echo "</tr>";
      $SolIni = $AnoIni2."000000";
	  $SolFin = $AnoFin2."000000";
	  $SolIni = $SolIni + $NumIni;
	  $SolFin = $SolFin + $NumFin;			
			$Consulta="select distinct(nro_solicitud),id_muestra,cod_producto,cod_subproducto,agrupacion,rut_funcionario from cal_web.solicitud_analisis ";
			$Consulta.=" where nro_solicitud between '".$SolIni."' and '".$SolFin."' order by nro_solicitud"; 
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckSol'><input type='hidden' name='TxtNumSolO'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				echo "<td align='left'><input type='checkbox' name='CheckSol' value='checkbox'></td>";
				echo "<td><a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].")\">\n";
				echo $Fila["nro_solicitud"]."</a></td>\n";
				//echo "<td width='58' align='center'>".$Fila["num_guia"]."<input type='hidden' name ='TxtNumGuiaO' value ='".$Fila["num_guia"]."'></td>";
				echo "<td width='81' align='left'>".$Fila["id_muestra"]."<input type='hidden' name ='TxtNumSolO' value ='".$Fila["nro_solicitud"]."'></td>";
				$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase = 1004 and cod_subclase = '".$Fila["agrupacion"]."'";
				$Resp1=mysqli_query($link, $Consulta);
				$Fil1=mysqli_fetch_array($Resp1);
				echo "<td width='125' align='left'>".$Fil1["nombre_subclase"]."</td>";
				$Consulta = "select t2.abreviatura as AbrevProducto,t3.abreviatura as AbrevSubProducto from cal_web.solicitud_analisis t1 ";
				$Consulta.= " inner join proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto  ";
				$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
				$Consulta.= " where t1.nro_solicitud = '".$Fila["nro_solicitud"]."' ";
				$Resp2=mysqli_query($link, $Consulta);
				$Fil2=mysqli_fetch_array($Resp2);  
				echo "<td width='125' align='left'>".$Fil2["AbrevProducto"]."</td>";
				echo "<td width='163' align='left'>".$Fil2["AbrevSubProducto"]."</td>";
				$Consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$Fila["rut_funcionario"]."'";
				$Resp3 = mysqli_query($link, $Consulta);
				$Fil3=mysqli_fetch_array($Resp3);  
				echo "<td width = '100'><center>".substr($Fil3["nombres"],0,1).".".$Fil3["apellido_paterno"]."</center></td>";
				echo "</tr>";
			}
			echo "</table>";
		?>
    <br>
    <table width="750" border="0" class="tablainterior">
      <tr> 
        <td align="center">
		<?php
			 echo " &nbsp; <input type='button' name='BtnModificar' value='Modificar' style='width:60' onClick=\"MostrarPopupProceso('M');\"> ";
			 echo "&nbsp; <input type='button' name='BtnSalir' value='Salir' style='width:60' onClick='Salir();'>";
	         echo" &nbsp;";
       ?>
	  </td>
	  </tr>
    </table>
    <br></td></tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>

