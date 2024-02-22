<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 17;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	if(isset($_REQUEST["Envio"])){
		$Envio = $_REQUEST["Envio"];
	}else{
		$Envio ='N';
	}
	if(isset($_REQUEST["CmbDias"])){
		$CmbDias = $_REQUEST["CmbDias"];
	}else{
		$CmbDias = date('d');
	}
	if(isset($_REQUEST["CmbAno"])){
		$CmbAno = $_REQUEST["CmbAno"];
	}else{
		$CmbAno = date('Y');
	}
	if(isset($_REQUEST["CmbMes"])){
		$CmbMes = $_REQUEST["CmbMes"];
	}else{
		$CmbMes = date('n');
	}
	if(isset($_REQUEST["Mensaje"])){
		$Mensaje = $_REQUEST["Mensaje"];
	}else{
		$Mensaje = "";
	}
	if(isset($_REQUEST["Mensaje2"])){
		$Mensaje2 = $_REQUEST["Mensaje2"];
	}else{
		$Mensaje2 = "";
	}
	if(isset($_REQUEST["Dia"])){
		$Dia = $_REQUEST["Dia"];
	}else{
		$Dia = date('d');
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date('n');
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = date('Y');
	}

/*
	if (!isset($Envio))
	{
		$Envio='N';
	}
	if (!isset($CmbDias))
	{
		$CmbDias=date('d');
	}
	if (!isset($CmbAno))
	{
		$CmbAno=date('Y');
	}
	if (!isset($CmbMes))
	{
		$CmbMes=date('n');
	}*/
?>
<html>
<head>
<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 100 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	
	{
		if (ie4) 
		{
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}

function Confirmar()
{
	var Frm=document.FrmConfEnvio;
	var Valores="";
	var Resp="";

	Valores=RecuperarValores();
	if (Valores!='')
	{
		window.open("sec_confirmacion_num_envio.php?Valores="+Valores+"&CmbDias="+Frm.CmbDias.value+"&CmbMes="+Frm.CmbMes.value+"&CmbAno="+Frm.CmbAno.value,"","top=100,left=0,width=770,height=400,scrollbars=no,resizable = no");
	}	
}
function Eliminar()
{
	var Frm=document.FrmConfEnvio;
	var Valores="";
	var Resp="";

	if (confirm('Esta Seguro de Eliminar el Envio'))
	{
		Valores=RecuperarValores();
		if (Valores!='')
		{
			window.open("sec_confirmacion_num_envio01.php?Proceso=A&Valores="+Valores,"","top=100,left=0,width=770,height=400,scrollbars=no,resizable = no");
		}
	}		
}
function GenerarFax()
{
	var Frm=document.FrmConfEnvio;
	var Valores="";

	Valores=RecuperarValores();
	if (Valores!='')
	{
		Frm.target="_blank";
		Frm.action="sec_consulta_fax_excel.php?Valores="+Valores;
		Frm.submit();
		Frm.target="_parent";
	}
}

function Recarga()
{
	var Frm=document.FrmConfEnvio;
	var Envio="";
	
	if (Frm.OpcEnvio[0].checked)
	{
		Envio="N";
	}
	if (Frm.OpcEnvio[1].checked)
	{
		Envio="S";
	}
	Frm.action="sec_seleccion_num_envio_despacho.php?Envio="+Envio;
	Frm.submit();
	
}

function RecuperarValores()
{
	var Frm=document.FrmConfEnvio;
	var Valores=new String();
	
	for (i=1;i<Frm.OptSeleccionar.length;i++)
	{
		if ((Frm.OptSeleccionar[i].checked==true))
		{
			Valores=Valores + Frm.OptSeleccionar[i].value +"//";
		}	
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);	
	}
	else
	{
		Valores="";
		return(Valores);	
	}	
} 
function Salir()
{
	var Frm=document.FrmConfEnvio;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();
	
}

function Imprimir(opt)
{
	var f=document.FrmConfEnvio;
	switch (opt)
	{
		case "W":
			window.open("sec_seleccion_num_envio_despacho_imp_web.php", "","menubar=no resizable=yes Top=30 Left=50 width=670 height=500 scrollbars=yes");
			 break;
	}
}
</script>
<title>Programa de Loteo Enami - Codelco</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConfEnvio" method="post" action="" target="_parent">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="350" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
  <tr>
      <td align="center"><br>
	  <div style="position:absolute; left: 15px; top: 55px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
	  <table width="730" border="0">
	  <tr>
	  <?php
			switch ($Envio)
			{
				case "N":
					echo "<td>Sin Envio<input type='radio' name='OpcEnvio' value='' onclick='Recarga()' checked>&nbsp;";
					echo "<select name='CmbDias' onchange='Recarga()'>";
					for ($i=1;$i<=31;$i++)
					{
						if (isset($CmbDias))
						{
							if ($i==$CmbDias)
							{
								echo "<option selected value= '".$i."'>".$i."</option>";
							}
							else
							{
							  echo "<option value='".$i."'>".$i."</option>";
							}
						}
						else
						{
							if ($i==date("j"))
							{
								echo "<option selected value= '".$i."'>".$i."</option>";
							}
							else
							{
							  echo "<option value='".$i."'>".$i."</option>";
							}
						}	
					}
					echo"</select>";
					echo"<select name='CmbMes' onchange='Recarga()'>";
					for($i=1;$i<13;$i++)
					{
						if (isset($CmbMes))
						{
							if ($i==$CmbMes)
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						
						}	
						else
						{
							if ($i==date("n"))
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						}	
					}
					echo "</select>";
					echo "<select name='CmbAno' onchange='Recarga()'>";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($CmbAno))
						{
							if ($i==$CmbAno)
								{
									echo "<option selected value ='$i'>$i</option>";
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}
						else
						{
							if ($i==date("Y"))
								{
									echo "<option selected value ='$i'>$i</option>";
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}		
					}
					echo "</select></td>";
					echo "<td>Con Envio<input type='radio' name='OpcEnvio' value='' onclick='Recarga()'><td>";								
					break;
				case "S":
					echo "<td>Sin Envio<input type='radio' name='OpcEnvio' value='' onclick='Recarga()'></td>";		
					echo "<td>Con Envio<input type='radio' name='OpcEnvio' value='' onclick='Recarga()' checked>&nbsp;&nbsp;";	
					echo"<select name='CmbMes' onchange='Recarga()'>";
					for($i=1;$i<13;$i++)
					{
						if (isset($CmbMes))
						{
							if ($i==$CmbMes)
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						
						}	
						else
						{
							if ($i==date("n"))
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						}	
					}
					echo "</select>";
					echo "<select name='CmbAno' onchange='Recarga()'>";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($CmbAno))
						{
							if ($i==$CmbAno)
								{
									echo "<option selected value ='$i'>$i</option>";
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}
						else
						{
							if ($i==date("Y"))
								{
									echo "<option selected value ='$i'>$i</option>";
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}		
					}
					echo "</select>&nbsp;";
					echo "<input type='button' name='BtnFax' value='Generar Fax' style='width:90' onClick='GenerarFax();'></td>";			
					break;
			}
	  ?>
	  </tr>
	  </table></div><br>
	  <div style="position:absolute; left: 20px; top: 85px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
	  <table width="730" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01">
		  <?php
			switch ($Envio)
			{
				case "N":
					echo "<td width='20' align='center'>&nbsp;</td>";
					echo "<td width='120' align='center'>Fecha Programa</td>";
					echo "<td width='70' align='center'>Cod.Nave</td>";
					echo "<td width='200' align='center'>Nave/Cliente</td>";
					echo "<td width='70' align='center'>Cod.Puerto</td>";
					echo "<td width='200' align='center'>Puerto</td>";
					break;
				case "S":
					echo "<td width='20' align='center'>&nbsp;</td>";
					echo "<td width='50' align='center'>N�Envio</td>";
					echo "<td width='130' align='center'>SubProducto</td>";
					echo "<td width='80' align='center'>Fecha Prog</td>";
					echo "<td width='50' align='center'>Cod.Nave</td>";
					echo "<td width='140' align='center'>Nave/Cliente</td>";
					echo "<td width='50' align='center'>Cod.Puerto</td>";
					echo "<td width='180' align='center'>Puerto</td>";
					break;
			}		
		  ?>	
          </tr>
        </table></div>
		<div style="position:absolute; left: 20px; top: 105px; width: 750px; height: 255px; OVERFLOW: auto;" id="div2">
		<?php
			echo "<table width='730' border='1' cellpadding='2' cellspacing='0'>";
			switch ($Envio)
			{
				case "N":
					if (strlen($CmbDias)==1)
					{
						$CmbDias="0".$CmbDias;
					}
					if (strlen($CmbMes)==1)
					{
						$CmbMes="0".$CmbMes;
					}
					$Fecha_Envio=$CmbAno."-".$CmbMes."-".$CmbDias;
					$Consulta="select t1.cod_servicio,t1.cod_prestador_servicio as ag_aduanero,t1.cod_prestador_servicio2 as ag_estiva,t1.eta_programada,t1.cod_nave,t1.cod_puerto,t4.nom_aero_puerto as pto_puerto,t5.nombre_nave,t1.fecha_disponible";
					$Consulta=$Consulta." from sec_web.programa_enami t1";
					$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto=t4.cod_puerto ";
					$Consulta=$Consulta." left join sec_web.nave t5 on t1.cod_nave=t5.cod_nave ";
					$Consulta=$Consulta." where t1.tipo <> 'V' and t1.estado2='T' and t1.estado1='R' and t1.eta_programada ='$Fecha_Envio' group by t1.eta_programada,t1.cod_nave order by t1.eta_programada";
					$Respuesta=mysqli_query($link, $Consulta);
					break;
				case "S":
					if (strlen($CmbMes)==1)
					{
						$CmbMes="0".$CmbMes;
					}
					$Fecha_Envio=$CmbAno."-".$CmbMes;
					$Consulta="select t3.descripcion as subproducto,t1.cod_servicio,t1.cod_prestador_servicio as ag_aduanero,t1.cod_prestador_servicio2 as ag_estiva,t1.eta_programada,t1.cod_nave,t1.cod_puerto,t4.nom_aero_puerto as pto_puerto,t5.nombre_nave,t1.fecha_disponible,t2.num_envio,t2.fecha_envio";
					$Consulta=$Consulta." from sec_web.programa_enami t1 inner join sec_web.embarque_ventana t2 on t1.corr_enm=t2.corr_enm";
					$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";					
					$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto=t4.cod_puerto ";
					$Consulta=$Consulta." left join sec_web.nave t5 on t1.cod_nave=t5.cod_nave ";
					$Consulta=$Consulta." where t1.tipo <> 'V' and t1.estado2='C' and t1.estado1='R'  and substring(t2.fecha_envio,1,7) ='$Fecha_Envio'  group by t2.num_envio,t1.eta_programada,t1.cod_nave order by t2.num_envio desc";
					$Respuesta=mysqli_query($link, $Consulta);
					break;
			}		
			echo "<input type='hidden' name='OptSeleccionar'>";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				switch ($Envio)
				{
					case "N":
						echo "<td width='20'align='center'><input type='radio' name='OptSeleccionar' value='".$Fila["eta_programada"]."~~".$Fila["cod_nave"]."~~".$Fila["nombre_nave"]."~~".$Fila[ag_aduanero]."~~".$Fila[ag_estiva]."~~".$Fila["eta_programada"]."~~".$Fila["fecha_disponible"]."~~".$Fila["cod_servicio"]."'></td>"; 
						echo "<td width='120' align='center'>".$Fila["eta_programada"]."&nbsp;</td>";
						echo "<td width='70' align='center'>".$Fila["cod_nave"]."&nbsp;</td>";
						echo "<td width='200' align='left'>".$Fila["nombre_nave"]."&nbsp;</td>";
						echo "<td width='70' align='center'>".$Fila["cod_puerto"]."&nbsp;</td>";
						echo "<td width='200' align='left'>".$Fila[pto_puerto]."&nbsp;</td>";
						break;
					case "S":
						$TipoEmb='';
						$IE='';
						$Consulta="select cod_bulto,num_bulto,corr_enm,tipo_embarque from sec_web.embarque_ventana where num_envio=".$Fila["num_envio"]." and fecha_envio='".$Fila["fecha_envio"]."'";
						$Respuesta2=mysqli_query($link, $Consulta);
						while ($Fila2=mysqli_fetch_array($Respuesta2))
						{
							$Consulta="select sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on ";
							$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
							$Consulta=$Consulta." left join sec_web.marca_catodos t3 on t1.cod_marca=t3.cod_marca ";
							$Consulta=$Consulta." where t1.corr_enm=".$Fila2["corr_enm"]." group by t1.corr_enm,t1.cod_bulto,t1.num_bulto";
							$Respuesta3=mysqli_query($link, $Consulta);
							$Fila3=mysqli_fetch_array($Respuesta3);						
							$IE=$IE.$Fila2["corr_enm"]."(".$Fila2["cod_bulto"]."-".$Fila2["num_bulto"].") Peso:".$Fila3["peso_preparado"]." - ";
							$TipoEmb=$Fila2["tipo_embarque"];
						}
						$IE=substr($IE,0,strlen($IE)-3);
						$Cont2++;
						switch ($TipoEmb)
						{
							case "T":
								$TipoEmb="Terrestre";
								break;
							case "A":
								$TipoEmb="Acopio";
								break;
							case "E":
								$TipoEmb="Estiba";
								break;						
							default:
								$TipoEmb="Ninguno";
						}
						echo "<td width='20'align='center'><input type='checkbox' name='OptSeleccionar' value='".$Fila["num_envio"]."~~".$Fila["fecha_envio"]."'></td>"; 
						echo "<td width='40' onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");' bgcolor='#cccccc'>";
						echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:550px'>\n";
						echo "<font face='courier' color='#000000' size=1><b>IE:&nbsp;</b>".$IE."</font><BR>";
						echo "<font face='courier' color='#000000' size=1><b>Tipo Embarque&nbsp;</b>".$TipoEmb."</font>";
						echo "</div>".$Fila["num_envio"]."&nbsp;</td>";
						echo "<td width='130' align='center'>".$Fila["subproducto"]."&nbsp;</td>";
						echo "<td width='80' align='center'>".$Fila["eta_programada"]."&nbsp;</td>";
						echo "<td width='50' align='center'>".$Fila["cod_nave"]."&nbsp;</td>";
						echo "<td width='140' align='left'>".$Fila["nombre_nave"]."&nbsp;</td>";
						echo "<td width='50' align='center'>".$Fila["cod_puerto"]."&nbsp;</td>";
						echo "<td width='180' align='left'>".$Fila[pto_puerto]."&nbsp;</td>";
						break;
				}
				echo "</tr>";
			}
			echo "</table>";	
		?>
		</div>
        <br>
		<div style="position:absolute; left: 15px; top: 370px; width: 750px; height: 43px; OVERFLOW: auto;" id="div2"> 
          <table width="730" border="0" class="tablainterior">
          <tr>
              <td align="center"> 
				<?php
					switch ($Envio)
					{
						case "N":
							echo "<input type='button' name='BtnAsignar' value='Confirmar N� Envio' style='width:130' onClick='Confirmar();'>";
							//echo "<input type='button' name='BtnSalir' value='Salir' style='width:90' onClick='Salir();'>";
							break;
						case "S":
							echo "<input type='button' name='BtnEliminar' value='Eliminar N� Envio' style='width:130' onClick='Eliminar();'>";
							//echo "<input type='button' name='BtnSalir' value='Salir' style='width:90' onClick='Salir();'>";
							break;
					}		
				?>
                <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:90" onClick="Imprimir('W');" value="Imprimir">
                <input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="Salir();">
</td>
          </tr>
        </table></div><br></td>
  </tr>
</table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if ($Mensaje2!='')
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje2."');";	
		echo "</script>";
	}
?>
