<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 11;
	include("../principal/conectar_sec_web.php");
?>
<html>
<head>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmSolicitud;
	var Valores="";
	
	var CorrEnm="";
	
	for (i=1;i<Frm.CheckSol.length;i++)
	{
		if (Frm.CheckSol[i].checked==true)
		{
			/*Valores = Valores + Frm.TxtNumSolO[i].value+"//";*/
			CorrEnm = CorrEnm + Frm.TxtCorr[i].value+"//";
			
		}
	}
	

	return(CorrEnm);

	
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

function MostrarPopupProceso(Proceso,anito,Envio)
{

	var Frm=document.FrmSolicitud;
	var Valores="";
	var Envio1=Envio
	var anito1= anito;
	
	
	
	switch (Proceso)
	{
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					/*Valores = RecuperarValoresCheckeado();*/
					CorrEnm = RecuperarValoresCheckeado();
					
					
					window.open("sec_modificador_envios_proceso.php?Proceso="+Proceso +"&anito1="+anito1 +"&Envio1="+Envio1+"&CorrEnm="+CorrEnm,"","top=110,left=10,width=760,height=370,scrollbars=yes,resizable = yes");
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
function Buscar()
{
	var Frm=document.FrmSolicitud;
	Frm.action="sec_modificador_envios.php?Mostrar=S";
	Frm.submit();
}

</script>
<title>Modificador de Envios</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmSolicitud" method="post" action="">

  <?php include("../principal/encabezado.php")?>
  <table width="770" height="240" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td height="238" align="center" valign="top"><table width="750" border="0">
          <tr> 
            <td width="198"><font size="1">&nbsp;</font></td>
            <td width="84"><font size="1"><font size="2">N�mero Envio </font></font></td>
            <td width="79"><font size="1"><font size="1"><font size="2"> 
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
			$anito = $AnoIni2;
		?>
		
              </select>
              </font></font></font></td>
            <td width="94"><font size="1"><font size="1"><font size="1"><font size="2"> 
              <input name="NumEnvio" type="text" id="NumEnvio" value="<?php echo $NumEnvio; ?>" size="8" maxlength="8">
              </font></font></font></font></td>
           
           
            <td width="273">&nbsp;</td>
          </tr>
          <tr> 
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
      echo "<td width='58' align='left'>N�Envio</td>";
      echo "<td width='81' align='left'>I.Emb.</td>";
      echo "<td width='125' align='left'>Lote </td>";
	  echo "<td width='100' align='left'>Paq.Lote</td>";
      echo "<td width='163' align='left'>Peso Lote</td>";
      echo "<td width='100' align='left'>Desp.Paq.</td>";
	  echo "<td width='100' align='left'>Desp.Peso</td>";
	  echo "<td width='100' align='left'>Cliente</td>";
	  echo "<td width='100' align='left'>Marca</td>";
      echo "</tr>";
	 
	 
	/* 	 $elimina ="delete from sec_web.paquete_catodo_externo where cod_paquete = 'G' and fecha_creacion_paquete between '2007-01-01' and '2007-12-31' ";
		 mysqli_query($link, $elimina);
	   echo "Borraaaa G ".$elimina;

	  
	$borra ="delete from sec_web.recepcion_catodo_externo where lote_origen like '%707%' and fecha_recepcion between '2007-01-01' and '2007-12-31' ";
	mysqli_query($link, $borra);
    echo "BBBBBB G".$borra;
	 
	 
	 $elimina ="delete from sec_web.paquete_catodo_externo where cod_paquete = 'H' and fecha_creacion_paquete between '2007-01-01' and '2007-12-31' ";
	mysqli_query($link, $elimina);
	   echo "Borraaaa H".$elimina;

	  
	$borra ="delete from sec_web.recepcion_catodo_externo where lote_origen like '%708%' and fecha_recepcion between '2007-01-01' and '2007-12-31' ";
	mysqli_query($link, $borra);
    echo "BBBBBB H".$borra;

	 
	/*  $borra ="delete from sec_web.lote_catodo where cod_bulto = 'G' and ";
	  $borra.=" num_bulto = '2506' and fecha_creacion_lote = '2008-07-04' and ";
	  $borra.=" corr_enm = '905911' and cod_estado ='a'";
	  mysqli_query($link, $borra);
      echo "BB".$borra;


	 $elimina  = " delete from sec_web.paquete_catodo";
	 $elimina .= " where cod_paquete = 'G' and num_paquete between  '2506' and '2508'  and ";
	 $elimina .= " fecha_creacion_paquete = '2008-07-04' and cod_estado = 'a'";
	 mysqli_query($link, $elimina );
	 echo "BBaaaa".$elimina; 
	 
	*/
	 
	$actualiza  = "UPDATE  sipa_web.recepciones set activo = 'M', sa_asignada = ' ' ";
	$actualiza. = "  where lote = '08070512' and  cod_producto = '1' and cod_subproducto = '7' and recargo in ('1','2','3','4') and conjunto = '7203' ";
	 mysqli_query($link, $actualiza);
		echo "actualiza ".$actualiza;
		
		
	/* $elimina = "delete   from sec_web.produccion_catodo where cod_grupo = '31' and ";
	 $elimina.= " cod_producto = '18' and cod_subproducto = '1' and fecha_produccion  = '2008-07-07'  and cod_muestra = 'S' ";
		mysqli_query($link, $elimina );
		
		echo "Eliminaprod".$elimina;*/
		
		
		/*
		
	   polyta
      $SolIni = $AnoIni2."000000";
	  $SolFin = $AnoFin2."000000";
	  $NumEnvio = $NumEnvio;
	  $SolFin = $SolFin + $NumFin;			
			$Consulta="select * from sec_web.embarque_ventana";
			$Consulta.=" where num_envio  = '".$NumEnvio."' and year(fecha_envio) = '".$anito."'"; 
			echo $Consulta;
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckSol'><input type='hidden' name='TxtNumSolO'>";
			
			echo "<input type='hidden' name='CheckCorr'><input type='hidden' name='TxtCorr'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				
				//<input name ='MesPaqueteI' type='hidden' >
				echo "<td align='left'><input type='checkbox' name='CheckSol' value='checkbox'></td>";
				//echo "<td><a href=\"JavaScript:Historial(".$Fila["num_envio"].")\">\n";
				//echo $Fila["num_envio"]."</a></td>\n";
				
				echo "<td width='58' align='center'>".$Fila["num_envio"]."<input type='hidden' name ='TxtNumGuiaO' value ='".$Fila["num_envio"]."'></td>";
				echo "<td width='81' align='left'>".$Fila["corr_enm"]."<input type='hidden' name ='TxtNumSolO'  value ='".$Fila["num_envio"]."'</td>";
				echo "<td width='125' align='left'>".$Fila["cod_bulto"]."-".$Fila["num_bulto"]."<input type='hidden' name ='TxtCorr'  value ='".$Fila["corr_enm"]."' </td>";
				echo "<td width='110' align='left'>".$Fila["bulto_paquetes"]."'</td>";
				echo "<td width='163' align='left'>".$Fila["bulto_peso"]."</td>";
				echo "<td width='110' align='left'>".$Fila["despacho_paquetes"]."</td>";
				echo "<td width='163' align='left'>".$Fila["despacho_peso"]."</td>";
				$CodBulto =  $Fila["cod_bulto"];
				$NumBulto =  $Fila["num_bulto"];
				
				$Consulta ="select nombre_nave from sec_web.nave  where cod_nave  = '".$Fila["cod_cliente"]."'";
				//echo $Consulta;
				$Resp1=mysqli_query($link, $Consulta);
				if ($Fila1=mysqli_fetch_array($Resp1));
				{
					echo "<td width='163' align='left'>".$Fila1["nombre_nave"]."</td>";
					$Nave = $Fila1["nombre_nave"];
					
				}	
				
				if ($Nave ==  "")
				{
						$Consulta ="select nombre_cliente  from sec_web.cliente_venta  where cod_cliente  = '".$Fila["cod_cliente"]."'";
						echo $Consulta;
						$Resp1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Resp1);
						echo "<td width='163' align='left'>".$Fila1["nombre_cliente"]."</td>";
				}		

				$Consulta ="select descripcion from sec_web.marca_catodos  where cod_marca  = '".$Fila["cod_marca"]."'";
				$Resp11=mysqli_query($link, $Consulta);
				$Fila11=mysqli_fetch_array($Resp11);

				
				echo "<td width='100' align='left'>".$Fila11["descripcion"]."</td>";
				//echo "<td width = '100'><center>".substr($Fil3["nombres"],0,1).".".$Fil3["apellido_paterno"]."</center></td>";
				echo "</tr>";
			}polyta */
			echo "</table>";
		?>
    <br>
    <table width="750" border="0" class="tablainterior">
      <tr> 
        <td align="center">
		<?php
		
																											//CambiarMarca('$CodBulto','$NumBulto')\">";
			 echo " &nbsp; <input type='button' name='BtnModificar' value='Modificar' style='width:60' onClick=\"MostrarPopupProceso('M','$anito','$NumEnvio');\"> ";
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

