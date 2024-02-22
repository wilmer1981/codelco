<?php include("../principal/conectar_pmn_web.php");
	include("pmn_funciones.php");	

?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmConsulta;
	switch (opt)
	{
		case "S":
			f.action= "pmn_principal_consulta.php";
			f.submit();
			break;
		case "C":
			f.action = "pmn_con_prod_externo.php?Mostrar=S";
			f.submit();
			break;
	}
}
function CargaDatos(RB)
{
	var f = document.frmConsulta;
	window.opener.document.frmPrincipal.action = "pmn_ing_deselenizacion.php?Modif=S&Hornada01=" + RB.value + "&Dia01=" + f.DiaConsulta.value + "&Mes01=" + f.MesConsulta.value + "&Ano01=" + f.AnoConsulta.value;
	window.opener.document.frmPrincipal.submit();
	window.close();
}
function Recarga()
{
	var f=document.frmConsulta;
	f.action="pmn_con_prod_externo.php";
	f.submit();  
}
function Excel()
{
	var f=document.frmConsulta;
	linea = "FechaIni=" + f.AnoIniCon.value + "-" + f.MesIniCon.value + "-" + f.DiaIniCon.value;
	linea = linea + "&FechaFin=" + f.AnoFinCon.value+ "-" + f.MesFinCon.value + "-" + f.DiaFinCon.value ;
	linea = linea + "&Producto=" + f.Producto.value + "&Subproducto=" + f.Subproducto.value;
	f.action="pmn_xls_prod_externo.php?Mostrar=S&" + linea;
	f.submit();  
}
function Imprimir()
{
	window.print();
}

</script>
</head>

<body>
<form name="frmConsulta" action="" method="post">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td ><img src="archivos/images/interior/esq3.png"/></td>
      <td colspan="3" background="archivos/images/interior/arriba.png"></td>
      <td width="2%" align="right" background="archivos/images/interior/derecho.png"><img src="archivos/images/interior/esq2.png" /></td>
    </tr>
    <tr>
      <td width="1%" background="archivos/images/interior/izquierdo.png">&nbsp;</td>
      <td width="19%"><img src="archivos/logo_sup.jpeg"/></td>
      <td width="74%" align="center"  bgcolor="#F7F2EB" class="formulario" style="border-bottom-color:#FFFFFF; border-bottom-style:double; border-bottom-width:thin;">CONSULTAS - PLAMEN </td>
      <td width="4%" align="right" bgcolor="#F7F2EB" style="border-bottom-color:#FFFFFF; border-bottom-style:double; border-bottom-width:thin;"><a href="JavaScript:Salir('')" class="LinkPestana" ></a><a href="JavaScript:SalirRpt('')" class="LinkPestana" ></a></td>
      <td width="2%" align="right" background="archivos/images/interior/derecho.png">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5"><table width="100%"  border="0"  align="center" cellpadding="0"  cellspacing="0" bgcolor="#F7F2EB">
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td colspan="5" ><img src="archivos/images/interior/transparent.gif" width="4" /></td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td colspan="5" rowspan="4" align="center" valign="top">
			<!--PANTALLA PROD EXTERNO-->
			<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="TituloCabeceraOz">
              <tr>
                <td><table width="684" height="20" border="0" align="center">
                    <tr>
                      <td width="678" align="center" class="TituloCabeceraAzul"><strong class="TituloCabeceraAzul">Consulta de Productos Externos </strong></td>
                    </tr>
                  </table>
                    <br>
                    <table width="685" border="0" align="center" cellpadding="3" cellspacing="1" class="TablaInterior">
                      <tr>
                        <td class="titulo_azul">Fecha Inicio</td>
                        <td><select name="DiaIniCon" style="width:50px;">
                            <?php
							for ($i=1;$i<=31;$i++)
							{
								if (isset($DiaIniCon))
								{
									if ($i == $DiaIniCon)
										echo "<option selected value='".$i."'>".$i."</option>\n";
									else	echo "<option value='".$i."'>".$i."</option>\n";
								}
								else
								{
									if ($i == $DiaActual)
										echo "<option selected value='".$i."'>".$i."</option>\n";
									else	echo "<option value='".$i."'>".$i."</option>\n";
								}
							}
							?>
                          </select>
                            <select name="MesIniCon" style="width:90px;">
                              <?php
							 for ($i=1;$i<=12;$i++)
							{
								if (isset($MesIniCon))
								{
									if ($i == $MesIniCon)
										echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
									else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
								}
								else
								{
									if ($i == $MesActual)
										echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
									else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
								}
							}
							  ?>
                            </select>
                            <select name="AnoIniCon" style="width:60px;">
                              <?php
								 for ($i=2002;$i<=date("Y");$i++)
								{
									if (isset($AnoIniCon))
									{
										if ($i == $AnoIniCon)
											echo "<option selected value='".$i."'>".$i."</option>\n";
										else	echo "<option value='".$i."'>".$i."</option>\n";
									}
									else
									{
										if ($i == $AnoActual)
											echo "<option selected value='".$i."'>".$i."</option>\n";
										else	echo "<option value='".$i."'>".$i."</option>\n";
									}
								}
								?>
                          </select></td>
                        <td width="84" class="titulo_azul">Fecha Termino</td>
                        <td width="215"><select name="DiaFinCon" style="width:50px;">
                            <?php
							for ($i=1;$i<=31;$i++)
							{
								if (isset($DiaFinCon))
								{
									if ($i == $DiaFinCon)
										echo "<option selected value='".$i."'>".$i."</option>\n";
									else	echo "<option value='".$i."'>".$i."</option>\n";
								}
								else
								{
									if ($i == $DiaActual)
										echo "<option selected value='".$i."'>".$i."</option>\n";
									else	echo "<option value='".$i."'>".$i."</option>\n";
								}
							}
							?>
                          </select>
                            <select name="MesFinCon" style="width:90px;">
                              <?php
								for ($i=1;$i<=12;$i++)
								{
									if (isset($MesFinCon))
									{
										if ($i == $MesFinCon)
											echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
										else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
									}
									else
									{
										if ($i == $MesActual)
											echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
										else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
									}
								}
								?>
                            </select>
                            <select name="AnoFinCon" style="width:60px;">
                              <?php
								for ($i=2002;$i<=date("Y");$i++)
								{
									if (isset($AnoFinCon))
									{
										if ($i == $AnoFinCon)
											echo "<option selected value='".$i."'>".$i."</option>\n";
										else	echo "<option value='".$i."'>".$i."</option>\n";
									}
									else
									{
										if ($i == $AnoActual)
											echo "<option selected value='".$i."'>".$i."</option>\n";
										else	echo "<option value='".$i."'>".$i."</option>\n";
									}
								}
							  ?>
                          </select></td>
                      </tr>
                      <tr>
                        <td class="titulo_azul">Productos</td>
                        <td><select name='Producto' onChange='Recarga();' style='width:220px'>
                            <?php 
						echo "<option value ='-1' selected>Todos</option>\n";
						$Consulta = "select t2.cod_producto, t2.descripcion ";
						$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.productos t2 on ";
						$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1 = t2.cod_producto and t1.nombre_subclase='2' ";
						$Consulta.= " order by t1.cod_subclase";
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Row = mysqli_fetch_array($Respuesta))
						{
							if ($Producto == $Row["cod_producto"])
								echo "<option selected value='".$Row["cod_producto"]."'>";														
							else	echo "<option value='".$Row["cod_producto"]."'>";
							printf("%'03d",$Row["cod_producto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
						}
						echo "<option value=''>-----------------------------</option>\n";
						$Consulta = "select * from proyecto_modernizacion.productos order by cod_producto";
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Row = mysqli_fetch_array($Respuesta))
						{
							if ($Producto == $Row["cod_producto"])
								echo "<option selected value='".$Row["cod_producto"]."'>";														
							else	echo "<option value='".$Row["cod_producto"]."'>";
							printf("%'03d",$Row["cod_producto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
						}
					?>
                        </select></td>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="108" class="titulo_azul">SubProdutos</td>
                        <td width="246"><select name="Subproducto" onChange="Recarga();" style="width:220px">
                            <option value="-1" selected>Seleccionar</option>
                            <?php
						$Consulta = "select t2.cod_subproducto, t2.descripcion ";
						$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.subproducto t2 on ";
						$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1='".$Producto."' and ";
						$Consulta.= " t1.valor_subclase2 = t2.cod_subproducto and t2.cod_producto='".$Producto."' and t1.nombre_subclase='2'";
						$Consulta.= " order by t1.cod_subclase";
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Row = mysqli_fetch_array($Respuesta))
						{
							if ($Subproducto == $Row["cod_subproducto"])
								echo "<option selected value='".$Row["cod_subproducto"]."'>";														
							else	echo "<option value='".$Row["cod_subproducto"]."'>";
							printf("%'03d",$Row["cod_subproducto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
						}
						echo "<option value=' '>-----------------------------</option>\n";
						$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$Producto."' order by cod_subproducto";
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Row = mysqli_fetch_array($Respuesta))
						{
							if ($Subproducto == $Row["cod_subproducto"])
								echo "<option selected value='".$Row["cod_subproducto"]."'>\n";
							else	echo "<option value='".$Row["cod_subproducto"]."'>\n";
							printf("%'03d",$Row["cod_subproducto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
						}			
					?>
                        </select></td>
                        <td colspan="2"><div align="left"> </div></td>
                      </tr>
                      <tr align="center">
                        <td height="30" colspan="4"><input type="button" name="btnVerDia2" value="Consultar" onClick="Proceso('C');" style="width:70px">
                            <input name="BtnExcel2" type="button" id="BtnExcel" style="width:70px" onClick="Excel('C');" value="Excel">
                            <input name="BtnImprimir2" type="button" id="BtnImprimir" value="Imprimir" onClick="Imprimir();">
                            <input type="button" name="btnCerrar2" value="Salir" onClick="Proceso('S');" style="width:70px"></td>
                      </tr>
                    </table>
                  <br>
                    <?php
		$FechaIni = $AnoIniCon."-".$MesIniCon."-".$DiaIniCon;
		$FechaFin = $AnoFinCon."-".$MesFinCon."-".$DiaFinCon;
		
		if ((!(($Producto == '44') && ($Subproducto == '2')))  && (!(($Producto == '34') && ($Subproducto == '3'))))
		{
	?>
                    <table width="650" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
                      <tr class="TituloCabeceraAzul">
                        <!--  <td width="57">&nbsp;</td>-->
                        <td width="83" align="center"><strong>Fecha</strong></td>
                        <td width="100" align="center"><strong>Tambor/Ref</strong></td>
                        <td width="64" align="center"><strong>Lote Ven.</strong></td>
                        <td width="66" align="center"><strong>Producto</strong></td>
                        <td width="123" align="center"><strong>SubProducto</strong></td>
                        <td width="55" align="center"><strong>P. Bruto</strong></td>
                        <td width="51" align="center"><strong>P.Tambor</strong></td>
                        <td width="41" align="center"><strong>P.Neto</strong></td>
                      </tr>
                      <?php  	
		if ($Mostrar=='S')
		{
			$Consulta = "select t1.fecha,t1.id_producto,t1.referencia,t2.abreviatura as DesProducto,t3.abreviatura as DesSubproducto,t1.peso_bruto,t1.peso_resta,t1.peso_final,t3.mostrar2, t0.lote_ventana ";
			$Consulta.= " from pmn_web.productos_externos t0 inner join pmn_web.detalle_productos_externos t1 on t0.cod_producto=t1.cod_producto and t0.cod_subproducto=t1.cod_subproducto and t0.id_producto=t1.id_producto  ";
			$Consulta.= " inner join proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto ";
			$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t1.cod_subproducto = t3.cod_subproducto and t2.cod_producto = t3.cod_producto ";
		
			if (($Producto != '-1') && ($Subproducto != '-1'))
			{
				$Consulta.=" where t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$Subproducto."' AND fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."' order by id_producto,referencia"; 
			} 
			if (($Producto != '-1') && ($Subproducto == '-1'))
			{
				$Consulta.=" where t1.cod_producto = '".$Producto."' AND fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."' order by id_producto,referencia";
			}		
			if (($Producto == '-1') && ($Subproducto == '-1'))
			{
				$Consulta.=" where fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."' order by id_producto,referencia ";
			}	
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			$TotalBr=0;
			$TotalTr=0;
			$TotalNt=0;
			while ($Row = mysqli_fetch_array($Respuesta))
			{
				echo "<tr>\n";
				echo "<td align='center'>".substr($Row["fecha"],8,2)."/".substr($Row["fecha"],5,2)."/".substr($Row["fecha"],0,4)."</td>\n";		
				echo "<td>".$Row[id_producto]." ".$Row[referencia]."</td>\n";	
				if ($Row["lote_ventana"]=="")
					echo "<td>&nbsp;</td>\n";
				else
					echo "<td align='center'>".$Row["lote_ventana"]."</td>\n";			
				echo "<td>".$Row[DesProducto]."&nbsp;</td>\n";
				echo "<td>".$Row[DesSubproducto]."&nbsp;</td>\n";
				echo "<td align='right'>".number_format($Row[peso_bruto],$Row[mostrar2],',','.')."&nbsp;</td>\n";
				echo "<td align='right'>".number_format($Row[peso_resta],$Row[mostrar2],',','.')."&nbsp;</td>\n";
				$PesoFinal=$Row[peso_bruto]-$Row[peso_resta];
				echo "<td align='right'>".number_format($PesoFinal,$Row[mostrar2],',','.')."&nbsp;</td>\n";
				echo "</tr>\n";
				$TotalBr=$TotalBr + $Row[peso_bruto];
				$TotalTr=$TotalTr + $Row[peso_resta];
				$TotalNt=$TotalNt + $PesoFinal;
				$NumDec=$Row[mostrar2];
			}
		}
	?>
                      <tr class="Detalle01">
                        <td colspan="5" align="right"><strong>TOTAL</strong></td>
                        <td align="right"><?php echo number_format($TotalBr,$NumDec,",","."); ?></td>
                        <td align="right"><?php echo number_format($TotalTr,$NumDec,",","."); ?></td>
                        <td align="right"><?php echo number_format($TotalNt,$NumDec,",","."); ?></td>
                      </tr>
                    </table>
                  <?php
		}
		/*else
		{*/
	?>
                    <table width="500" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
                      <tr class="TituloCabeceraAzul">
                        <td width="82" align="center">Fecha</td>
                        <td width="116" align="center">Lote Ventana</td>
                        <td width="141" align="center">Num. Barra</td>
                        <td width="126" align="center">Peso</td>
                      </tr>
                      <?php
		/*if ($Mostrar=='S')
		{*/
			if (($Producto==34 && $Subproducto==3) || ($Producto=="-1" && $Subproducto=="-1"))
			{
				//ORO COMPRA
				$consulta = "select * from pmn_web.ingreso_oro_compra";
				$consulta.= " WHERE fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
				$consulta.= " order by fecha,num_barra,lote_ventana";
				$NumDec=4;
			
			/*else
			{
				//METAL DORE CANCAN
				$consulta = "select * from pmn_web.ingreso_metal_dore";
				$consulta.= " WHERE fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
				$consulta.= " order by fecha,num_lote,num_barra";
				$NumDec=2;
			}*/
			//echo $consulta."<br>";
			
			$rs = mysqli_query($link, $consulta);
			$TotalPeso22=0;
			while ($row = mysqli_fetch_array($rs))
			{		
				$TotalPeso2=$TotalPeso2+$row[peso_barra];
				echo '<tr>';
				echo '<td>'.$row["fecha"].'</td>';
				echo '<td align="center">'.$row["lote_ventana"].'</td>';
				echo '<td align="center">'.$row[num_barra].'</td>';
				echo '<td align="right">'.number_format($row[peso_barra],$NumDec,",",".").'</td>';
				echo '</tr>';
			}
		}
	?>
                      <tr class="Detalle01">
                        <td colspan="3" align="right"><strong>TOTAL</strong></td>
                        <td align="right"><?php echo number_format($TotalPeso2,$NumDec,",","."); ?></td>
                      </tr>
                    </table>
                  <p>
                      <?php
		//}
	?>
                    </p>
                  <p>&nbsp; </p></td>
              </tr>
            </table>
			<!--TERMINO-->
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td width="12"><img src="archivos/images/interior/esq1.png"/></td>
            <td height="1" colspan="5" background="archivos/images/interior/abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /><?php echo "<font color='#FFFFFF' SIZE='2'>".$CookieRut."  -  ".NomUsuario($CookieRut)."&nbsp;&nbsp;-&nbsp;&nbsp;".NomPerfil($CookieRut)."&nbsp;</SPAN>";?></td>
            <td width="18"><img src="archivos/images/interior/esq4.png"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
