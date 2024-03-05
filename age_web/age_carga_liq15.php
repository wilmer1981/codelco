<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 3;
	include("../principal/conectar_principal.php");
	if ($Cargar == "S")
	{	
		$Eliminar = "delete from age_web.recepciones ";
		$Eliminar.= " where ano='".$Ano."' and mes= '".$Mes."'";
		mysqli_query($link, $Eliminar);
		$Archivo = "liqli15_".str_pad($Mes,2,"0",STR_PAD_LEFT)."_".$Ano.".lis";
		$EncontroArchivo = false;		
		if (file_exists($Archivo))
		{
			$EncontroArchivo = true;
			$Mensaje="";
		}
		else
		{
			$EncontroArchivo = false;
			$Mensaje = "No se ha Encontrado en el Directorio el Archivo <strong>".$Archivo."</strong><br>Por lo tanto no se puede continuar la Carga...";
		}
		if ($EncontroArchivo == true)
		{
			$Listado = fopen($Archivo,"r");	
			while (!feof($Listado)) 
			{
				$Linea = fgetss($Listado,1024);
				if ((intval(substr($Linea,0,2)) > 1 && intval(substr($Linea,0,2)) < 99) && (substr($Linea,8,1) != "-"))
				{	
					$SubProducto = intval(substr($Linea,0,2));
				}
				else
				{
					if (substr($Linea,8,1) == "-" && substr($Linea,7,1) != "-" && substr($Linea,9,1) != "-")
					{					
						$RutProveedor = substr($Linea,0,10);
						$PesoHumedo = str_replace(",","",substr($Linea,31,11));
						$PesoSeco = str_replace(",","",substr($Linea,43,11));	
						$FinoCu = str_replace(",","",substr($Linea,55,11));
						$FinoAg = str_replace(",","",substr($Linea,67,11));
						$FinoAu = str_replace(",","",substr($Linea,79,11));
						if ($PesoSeco<>0 || $PesoHumedo<>0 || $FinoCu<>0 || $FinoAg<>0 || $FinoAu<>0)
						{
							$Insertar = "INSERT INTO age_web.recepciones (ano, mes, cod_producto, cod_subproducto, rut_proveedor, peso_seco, peso_humedo, fino_cu, fino_ag, fino_au) ";
							$Insertar.= " VALUES('".$Ano."','".$Mes."','1','".trim($SubProducto)."','".trim($RutProveedor)."','".$PesoSeco."','".$PesoHumedo."','".$FinoCu."','".$FinoAg."','".$FinoAu."')";
							mysqli_query($link, $Insertar);		
						}
					}
				}
			}		
			fclose($Listado);
		}//FIN SI ENCONTRO ARCHIVO	
		$SubProducto="S";
	}
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=15";
}
function Consultar(f)
{
	f.action = "age_carga_liq15.php?Mostrar=S";
	f.submit(); 
}
function Excel(f)
{
	f.action = "age_carga_liq15_excel.php?Mostrar=S";
	f.submit(); 
}
function Cargar(f)
{
	var msg = confirm("�Cargar Archivo Liqli15.lis a Base de Datos?");
	if (msg==true)
	{
		f.action = "age_carga_liq15.php?Cargar=S&Mostrar=S";
		f.submit(); 
	}
	else
	{
		return;
	}
}

function Suma()
{
	var f=document.frmPrincipal;
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=='ChkAju' && f.elements[i].checked)
		{
			if (f.EnvProd.value=="")
			{
				var msg = confirm("Seleccione el Receptor para estos Valores");
				if (msg==true)
				{
					f.EnvProd.value=f.elements[i+1].value;
					f.EnvSubProd.value=f.elements[i+2].value;
					f.EnvRut.value=f.elements[i+3].value;				
                    f.EnvPHum.value=f.elements[i+4].value;
                    f.EnvPSec.value=f.elements[i+5].value;
				}
				else
				{
					f.EnvProd.value="";
					f.EnvSubProd.value="";
					f.EnvRut.value="";
                    f.EnvPHum.value="";
                    f.EnvPSec.value="";
					f.RecProd.value="";
					f.RecSubProd.value="";
					f.RecRut.value="";	
                    f.RecPHum.value="";
					f.RecPSec.value="";
					return;
				}
			}
			else
			{
				if (f.RecProd.value=="")
				{
					var msg = confirm("�Confirma que desea sumar estos registros?");
					if (msg==true)
					{
						f.RecProd.value=f.elements[i+1].value;
						f.RecSubProd.value=f.elements[i+2].value;
						f.RecRut.value=f.elements[i+3].value;
                        f.RecPHum.value=f.elements[i+4].value;
                        f.RecPSec.value=f.elements[i+5].value;
						f.action = "age_carga_liq1501.php?Proceso=SUMA";
						f.submit();
					}
					else
					{
						f.EnvProd.value="";
						f.EnvSubProd.value="";
						f.EnvRut.value="";
                        f.EnvPHum.value="";
						f.EnvPSec.value="";
						f.RecProd.value="";
						f.RecSubProd.value="";
						f.RecRut.value="";
                        f.RecPHum.value="";
						f.RecPSec.value="";
						return;
					}
				}
				else
				{
					alert("Tiene una Suma Pendiente");
					return;
				}
			}
		}
	}
}
</script><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="600" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="2"><strong>Recepciones</strong></td>
        </tr>
        <tr>
          <td height="23">SubProducto:</td>
          <td height="23"><select name="SubProducto" onChange="Consultar(this.form)">
            
            <?php
	if ($SubProducto=="" || !isset($SubProducto) || $SubProducto=="S")
		echo "<option selected value='S'>VER TODOS</option>>\n";
	else
		echo "<option value='S'>VER TODOS</option>>\n";
	$Consulta = "select cod_subproducto, descripcion, ";
	$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
	$Consulta.= " from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='1' ";
	$Consulta.= " order by orden ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($SubProducto == $Fila["cod_subproducto"])
			echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
		else
			echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
	}
?>
          </select>                          </td>
          </tr>
        <tr>
          <td width="105" height="23">Mes de Carga </td>
          <td>
            <select name="Mes">
              <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (!isset($Mes))
				{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";
				}
				else
				{
					if ($i == $Mes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";						
				}				
			}		  
		?>
            </select>
            <select name="Ano" size="1">
              <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (!isset($Ano))
				{
					if ($i == date("Y"))
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";
				}
				else
				{
					if ($i == $Ano)
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";						
				}				
			}		
		?>
            </select>                        </td>
          </tr>
        <tr align="center">
          <td height="23" colspan="2">            <input name="BtnConsulta" type="button" id="BtnConsulta4" style="width:80px;" onClick="Consultar(this.form)" value="Consulta">
&nbsp;            
<input name="BtnExcel" type="button" id="BtnExcel" style="width:80px;" onClick="Excel(this.form)" value="Excel">
&nbsp;            <input name="btnconsultar" type="button" value="Carga Liq15" onClick="Cargar(this.form)" style="width:80px;">
&nbsp;            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px;" onClick="JavaScript:Salir()">            </td></tr>
      </table>
        <br>     		   
<?php	
if ($Mostrar == "S")
{	
	if ($Mensaje != "")
		echo $Mensaje."<br>.";
	echo "<table width='750' border='1' cellpadding='3' cellspacing='0' class='TablaDetalle'>\n";
	$Consulta = "select distinct cod_producto, cod_subproducto, ";
	$Consulta.= " case when length(cod_producto)=1 then concat('0',cod_producto) else cod_producto end as orden1, ";
	$Consulta.= " case when length(cod_subproducto)=1 then concat('0',cod_subproducto) else cod_subproducto end as orden2 ";
	$Consulta.= " from age_web.recepciones ";
	$Consulta.= " where ano='".$Ano."' and mes='".$Mes."'";
	if ($SubProducto!="S")
		$Consulta.= " and cod_producto='1' and cod_subproducto='".$SubProducto."'";
	$Consulta.= " order by orden1, orden2 ";
	$RespProd = mysqli_query($link, $Consulta);
	while ($FilaProd = mysqli_fetch_array($RespProd))
	{
		$Consulta = "select t1.descripcion as nom_prod, t2.descripcion as nom_subprod ";
		$Consulta.= " from proyecto_modernizacion.productos t1 inner join proyecto_modernizacion.subproducto t2";
		$Consulta.= " on t1.cod_producto = t2.cod_producto ";
		$Consulta.= " where t2.cod_producto='".$FilaProd["cod_producto"]."' and t2.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$NomProd = $Fila2["nom_prod"];
			$NomSubProd = $Fila2["nom_subprod"];
		}		
		else
		{
			$NomProd = "";
			$NomSubProd = "";
		}		
		echo "<tr class='ColorTabla01'>\n";
		echo "<td colspan='12'><strong>Producto: ".$FilaProd["cod_producto"]."-".$NomProd." / SubProducto: ".$FilaProd["cod_subproducto"]."-".$NomSubProd."</strong></td>\n";
		echo "</tr>\n";
		echo "<tr class='ColorTabla01'>\n";
		echo "<td rowspan='2' width='30'>Aju</td>\n";
		echo "<td rowspan='2' width='61'>Rut</td>\n";
		echo "<td rowspan='2' width='116'>Proveedor</td>\n";
		echo "<td rowspan='2' width='50'>P.Hum</td>\n";
		echo "<td rowspan='2' width='50'>P.Seco</td>\n";		
		echo "<td colspan='3' width='50'>FINOS</td>\n";
		echo "<td rowspan='2' width='50'>Hum(%)</td>\n";
		echo "<td colspan='3' width='50'>LEYES</td>\n";
		echo "</tr>";
		echo "<tr class='ColorTabla01'>";
		echo "<td width='50'>Cu</td>\n";
		echo "<td width='50'>Ag</td>\n";
		echo "<td width='50'>Au </td>\n";
		echo "<td width='50'>Cu</td>\n";
		echo "<td width='50'>Ag</td>\n";
		echo "<td width='50'>Au</td>\n";
		echo "</tr>\n";
		$TotalPSeco = 0;
		$TotalPHumedo = 0;
		$TotalFinoCu = 0;
		$TotalFinoAg = 0;
		$TotalFinoAu = 0;
		$Consulta = "select * from age_web.recepciones ";
		$Consulta.= " where ano='".$Ano."' and mes='".$Mes."'";
		$Consulta.= " and cod_producto = '".$FilaProd["cod_producto"]."'";
		$Consulta.= " and cod_subproducto = '".$FilaProd["cod_subproducto"]."'";
		$Consulta.= " order by cod_producto, rut_proveedor";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$Consulta = "select * from ram_web.proveedor ";
			$Consulta.= " where trim(rut_proveedor) = trim('".$Fila["rut_proveedor"]."')";
			$RespProv = mysqli_query($link, $Consulta);
			if ($FilaProv = mysqli_fetch_array($RespProv))
				$NomProv = $FilaProv["nombre"];
			else
				$NomProv = "&nbsp;";
			echo "<tr>\n";
			echo "<td align='center'><input type='radio' name='ChkAju' value='' onClick='Suma()'>";
			echo "<input type='hidden' name='H_Prod' value='".$FilaProd["cod_producto"]."'>";
			echo "<input type='hidden' name='H_SubProd' value='".$FilaProd["cod_subproducto"]."'>";
			echo "<input type='hidden' name='H_Rut' value='".$Fila["rut_proveedor"]."'>";
            echo "<input type='hidden' name='H_PHum' value='".$Fila["peso_humedo"]."'>";
			echo "<input type='hidden' name='H_Psec' value='".$Fila["peso_seco"]."'>";
			echo "</td>\n";
			echo "<td align='center'>".$Fila["rut_proveedor"]."</td>\n";
			echo "<td align='left'>".substr($NomProv,0,15)."</td>\n";			
			echo "<td align='right'>".number_format($Fila["peso_humedo"],0,",",".")."</td>\n";
			//FINOS
			echo "<td align='right'>".number_format($Fila["peso_seco"],0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fila["fino_cu"],0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fila["fino_ag"],0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fila["fino_au"],0,",",".")."</td>\n";
			//(%) Humedad
			if ($Fila["peso_seco"]>0 && $Fila["peso_humedo"]>0)
				echo "<td align='right'>".number_format(100-(($Fila["peso_seco"]/$Fila["peso_humedo"])*100),2,",",".")."</td>\n";
			else
				echo "<td align='right'>0</td>\n";
			//LEYES
			if ($Fila["peso_seco"]>0 && $Fila["fino_cu"]>0)
				echo "<td align='right'>".number_format(($Fila["fino_cu"]/$Fila["peso_seco"])*100,2,",",".")."</td>\n";
			else
				echo "<td align='right'>0</td>\n";
			if ($Fila["peso_seco"]>0 && $Fila["fino_ag"]>0)
				echo "<td align='right'>".number_format(($Fila["fino_ag"]/$Fila["peso_seco"])*1000,2,",",".")."</td>\n";
			else
				echo "<td align='right'>0</td>\n";
			if ($Fila["peso_seco"]>0 && $Fila["fino_au"]>0)
				echo "<td align='right'>".number_format(($Fila["fino_au"]/$Fila["peso_seco"])*1000,2,",",".")."</td>\n";
			else
				echo "<td align='right'>0</td>\n";
			echo "</tr>\n";
			$TotalPSeco = $TotalPSeco + $Fila["peso_seco"];
			$TotalPHumedo = $TotalPHumedo + $Fila["peso_humedo"];
			$TotalFinoCu = $TotalFinoCu + $Fila["fino_cu"];
			$TotalFinoAg = $TotalFinoAg + $Fila["fino_ag"];
			$TotalFinoAu = $TotalFinoAu + $Fila["fino_au"];
		}
		echo "<tr class='ColorTabla02'>\n";
		echo "<td align='center' colspan='3'>TOTAL PRODUCTO</td>\n";
		echo "<td align='right'>".number_format($TotalPHumedo,0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($TotalPSeco,0,",",".")."</td>\n";	
		//TOTAL FINOS	
		echo "<td align='right'>".number_format($TotalFinoCu,0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($TotalFinoAg,0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($TotalFinoAu,0,",",".")."</td>\n";
		//(%) HUMEDAD
		if ($TotalPSeco>0 && $TotalPHumedo>0)
			echo "<td align='right'>".number_format(100-(($TotalPSeco/$TotalPHumedo)*100),2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		//TOTAL LEYES
		if ($TotalPSeco>0 && $TotalFinoCu>0)
			echo "<td align='right'>".number_format(($TotalFinoCu/$TotalPSeco)*100,2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($TotalPSeco>0 && $TotalFinoAg>0)
			echo "<td align='right'>".number_format(($TotalFinoAg/$TotalPSeco)*1000,2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($TotalPSeco>0 && $TotalFinoAu>0)
			echo "<td align='right'>".number_format(($TotalFinoAu/$TotalPSeco)*1000,2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		echo "</tr>\n";
	}
}
?>		  
      </table></td>
    </tr>
</table>
<!-- CAMPO QUE ENVIA LA SUMA-->
<input type="hidden" name="EnvProd" value="">
<input type="hidden" name="EnvSubProd" value="">
<input type="hidden" name="EnvRut" value="">
<input type="hidden" name="EnvPHum" value="">
<input type="hidden" name="EnvPSec" value="">
<!-- CAMPO QUE RECIVE LA SUMA-->
<input type="hidden" name="RecProd" value="">
<input type="hidden" name="RecSubProd" value="">
<input type="hidden" name="RecRut" value="">
<input type="hidden" name="RecPHum" value="">
<input type="hidden" name="RecPSec" value="">

<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
