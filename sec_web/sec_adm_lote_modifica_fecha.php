<?php
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	$Fecha = date('Y-m-d');
	$anito=substr($Fecha,0,4);
?>
<html>
<head>
<title>Cambio Fecha Lote</title>
<script language="javascript">
function Proceso(Opcion)
{
	var f=document.form1;
	var Valores='';
	for (i=1;i<f.checkbox.length;i++)
	{
		if(f.checkbox[i].checked==true)
			Valores =f.checkbox[i].value;
	}
	if(Valores=='')
	{
		alert('Debe Seleccionar Fecha a asignar');
		return;
	}
	if(Valores!='')
	{
		var mensaje=confirm('�Est� Seguro de asignar esta Fecha de Creaci�n al Lote?');
		if(mensaje==true)
		{
			f.action="sec_adm_lote_modifica_fecha01.php?CodBulto="+f.CodBulto.value+"&NumBulto="+f.NumBulto.value+"&CorrEnm="+f.CorrENM.value+"&FechaLoteModifi="+Valores;
			f.submit();
		}
	}
}
function Salir()
{
	window.close();
}
</script>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style><body>
<form name="form1" method="post" action="">
<input type="hidden" name="CmbAno" value="<?php echo $CmbAno?>">
<input type="hidden" name="CodBulto" value="<?php echo $CodBulto?>">
<input type="hidden" name="NumBulto" value="<?php echo $NumBulto?>">
<table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
  <tr>
    <td width="776" align="center" valign="top"
	><table width="754" border="0" class="TablaInterior">
      <tr>
        <td width="27"><font size="2">&nbsp; </font></td>
        <td width="126"><font size="2">A&ntilde;o</font><font size="1"><font size="2"><font size="1"><font size="2"><font size="1"><font size="2">
            <?php
				echo $CmbAno;

			?>
          </select>
        </font></font><font size="2"></font></font></font></font></font></td>
        <td width="36"><font size="1"><font size="2"> </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Mes</font></font></td>
        <td width="99"><font size="2">
            <?php
				echo $CodBulto;
			?>
          </select>
        </font></td>
        <td width="88">N&deg; Lote</td>
        <td width="88">
          <?php
				echo $CodBulto."-".$NumBulto;
		  ?>
        </select>
        </td>
        <td width="79">Marca</td>
        <td colspan="2"><?php
				//if ($Mostrar=="S")
				//{
					$Consulta="select distinct t1.cod_marca,t2.descripcion,t1.corr_enm from sec_web.lote_catodo t1";
					$Consulta.=" left join sec_web.marca_catodos t2 on t1.cod_marca = t2.cod_marca	";
					$Consulta.=" where t1.cod_bulto ='".$CodBulto."' and t1.num_bulto='".$NumBulto."' and substring(fecha_creacion_lote,1,4)='".$CmbAno."'";
					//echo $Consulta."<br>";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Descripcion=$Fila["descripcion"];
					$CodMarca=$Fila["cod_marca"];
					$IE=$Fila["corr_enm"];
				//}
			echo $CodMarca;
			echo "&nbsp;&nbsp;";
			echo $Descripcion;
			?>
			  <input name="CorrENM" type="hidden" value="<?php echo $IE; ?>">	
              <input name="MarcaBulto" type="hidden" value="<?php echo $CodMarca; ?>">
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Total paquetes</td>
        <td colspan="2"><?php
			//if ($Mostrar=="S")
			//{
				$Consulta="select count(num_paquete) as numero from sec_web.lote_catodo ";
				$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and "; //substring(fecha_creacion_lote,1,4)='".$CmbAno."'	";
				$Consulta.=" LEFT(fecha_creacion_lote,4) between '".$CmbAno."' and '".$anito."'";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);	
				echo $Fila["numero"];
			//}
			?>
        </td>
        <td>Total Unidades</td>
        <td><?php
				$Consulta="select sum(num_unidades) as suma_unidades,sum(peso_paquetes) as suma_paquetes, t2.cod_subproducto as cod_subproducto1 from sec_web.lote_catodo t1 ";
				$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
				$Consulta.=" and t1.num_paquete=t2.num_paquete ";
				$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and  ";
				$Consulta.=" LEFT(fecha_creacion_lote,4) between '".$CmbAno."' and '".$anito."'";
				$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  and t1.cod_estado=t2.cod_estado";
                 //poly 12-02-2008
                //$Consulta.=" group by t2.cod_subproducto";
                $Consulta.=" group by t2.cod_producto";
				//echo $Consulta;
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$SumaUnidades=$Fila[suma_unidades];
				$SumaPeso=$Fila[suma_paquetes];
				/*$Consulta="select t1.cod_paquete,t1.num_paquete,t2.num_unidades,t2.peso_paquetes from sec_web.lote_catodo t1 ";
				$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
				$Consulta.=" and t1.num_paquete=t2.num_paquete ";
				$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and LEFT(fecha_creacion_lote,4)='".$CmbAno."'	";
				//echo $Consulta;
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					$SumaUnidades=$SumaUnidades+$Fila["num_unidades"];
					$SumaPeso=$SumaPeso+$Fila["peso_paquetes"];
				}*/	
                $subproducto_consulta = $Fila[cod_subproducto1];

				echo $SumaUnidades;
			?>
          &nbsp;</td>
        <td>Total Peso</td>
        <td width="77"><?php
			echo $SumaPeso;
			?>
        </td>
        <td width="93">IE:<?php echo $IE ?></td>
      </tr>
    </table>
        <br>
        <table width="752" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01">
            <td width="38"><input type="hidden" name="CheckTodos" value="checkbox">
            </td>
            <td width="102"><div align="center">Fecha Creaci�n Lote</div></td>
            <td width="86"><div align="center">#Inicial S-Lote</div></td>
            <td width="88" align="left"><div align="center">#Final S-Lote</div></td>
            <td width="222" align="left"><div align="center">Producto/SubProducto</div></td>
            <td width="89"><div align="center">Unidades Serie</div></td>
            <td width="82"><div align="center"></div>
            <div align="center">Peso Serie</div></td>
          </tr>
        </table>
      <?php
  		echo "<table width='752' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
		

		
		$Consulta = "select  distinct t1.cod_paquete,t1.num_paquete,substr(t1.fecha_creacion_paquete,1,4) as anop";
		$Consulta.=" from sec_web.lote_catodo t1  ";
		$Consulta.=" where t1.cod_bulto='".$CodBulto."' and t1.num_bulto='".$NumBulto."' and substring(t1.fecha_creacion_lote,1,4) between '".$CmbAno."' and '".$anito."' ";
		$Consulta.=" order by fecha_creacion_lote desc,cod_paquete,num_paquete ";
		//echo "con-----".$Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		$cont=1;
		$arreglo=array();
		$i=0;
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			$arreglo[$i]=	array($Fila["cod_paquete"],$Fila["num_paquete"],$Fila["anop"]);
			$i++;
		}
		reset($arreglo);
		$sw=0;
		$vector=array();
		$a=0;
		$i=0;
		while ($i < count($arreglo))
		{
			if ($arreglo[$i][0]==$arreglo[$i+1][0])
			{
				if($arreglo[$i][1]==($arreglo[$i+1][1]-1))
				{
					if($sw==0)
					{
						$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1]."-".$arreglo[$i][2];//inicial
						$sw=1;
					}
					else
					{
						if ($arreglo[$i+1][1]!=($arreglo[$i+2][1]-1))
						{
							$vector[$a][1]=$arreglo[$i+1][0]."-".$arreglo[$i+1][1]."-".$arreglo[$i+1][2];//final
							$sw=0;
							$a++;
							$i++;
						}
					}
				}
				else
				{
					if ($sw==0)
					{	
						$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1]."-".$arreglo[$i][2];//inicial
						$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1]."-".$arreglo[$i][2];//final
						$a++;
					}
					else
					{
						$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1]."-".$arreglo[$i][2];//final
						$sw=0;
						$a++;
					}
				}
			}
			else
			{
				if ((count($arreglo)-$i)<=1)//fin del arreglo
				{
					if ($vector[$a][0]=="")
					{
						$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1]."-".$arreglo[$i][2];//inicial
					}
					$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1]."-".$arreglo[$i][2];//final
				}		
				else
				{
					if ($sw==1)
					{
						$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1]."-".$arreglo[$i][2];//final
						$a++;
						$sw=0;
					}
					else
					{
						$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1]."-".$arreglo[$i][2];//inicial
						$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1]."-".$arreglo[$i][2];//final
						$a++;
					}
				}
			}
			$i++;
		}		
		reset($vector);
		echo "<input name ='checkbox' type='hidden' ><input name ='MesPaqueteI' type='hidden' ><input name ='NumPaqueteI' type='hidden' ><input name ='MesPaqueteF' type='hidden' ><input name ='NumPaqueteF' type='hidden' >";
		$j=1;
		foreach($vector as $Clave => $Valor)
		{
			
			$Inicial=explode("-",$Valor[0]);
			$Final=explode("-",$Valor[1]);
			//echo $Inicial[0]."-".$Inicial[1];
			echo "<tr>";
			$ConFechaLote="select fecha_creacion_lote from sec_web.lote_catodo where cod_paquete='".$Final[0]."' and num_paquete='".$Inicial[1]."' and corr_enm='".$IE."'";
			$RespFechaLote=mysqli_query($link, $ConFechaLote);
			$FilaFechaLote=mysqli_fetch_array($RespFechaLote);
			$Fecha_creacion_lote=$FilaFechaLote["fecha_creacion_lote"];
      		echo "<td width='42px'><input name='checkbox' type='radio'  value='".$Fecha_creacion_lote."'></td>";
			echo "<td width='92'>".$Fecha_creacion_lote."</td>";
			echo "<td width='92'>".$Inicial[0]."-".$Inicial[1]."</td>";
			echo "<td width='92'>".$Final[0]."-".$Final[1]."</td>";
			
			
			//echo "<td width='92'>".$Valor[0]."</td>";
			//echo "<td width='92'>".$Valor[1]."</td>";
			$MesPaqueteI=$Inicial[0];
			echo "<input type='hidden' name='MesPaqueteI' value='".$Inicial[0]."'>";
			$NumPaqueteI=$Inicial[1];
			echo "<input type='hidden' name='NumPaqueteI' value='".$Inicial[1]."'>";
			$Fechapi=$Inicial[2];
			//echo "<input type='hidden' name='Fechapi' value='".$Inicial[2]."'>";
			$MesPaqueteF=$Final[0];
			echo "<input type='hidden' name='MesPaqueteF' value='".$Final[0]."'>";
			
			$NumPaqueteF=$Final[1];
			echo "<input type='hidden' name='NumPaqueteF' value='".$Final[1]."'>";
			$Fechapf=$Final[2];
			//echo "<input type='hidden' name='Fechapf' value='".$Final[2]."'>";
			//echo $Fechapi."-".$Fechapf;
			/*$CodPaqueteI=$Inicial[0];
			$NumPaqueteI=$Inicial[1];  
			echo "<input type='hidden' name='CodPaqueteINumPaqueteI' value='".$Inicial[0]."~".$Inicial[1]."'>";*/
			$cont = $cont +  9;
			$Consulta="select t1.cod_producto, t1.cod_subproducto,t2.descripcion,t2.abreviatura as abrevP,t3.abreviatura from sec_web.paquete_catodo t1";
			$Consulta.=" inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
			$Consulta.=" inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto";
			//$Consulta.=" inner join sec_web.lote_catodo t4 on t1.cod_paquete = t4.cod_paquete and";
			//$Consulta.=" t1.num_paquete = t4.num_paquete";  
			$Consulta.=" where  cod_paquete='".$MesPaqueteI."' and num_paquete='".$NumPaqueteI."'";
			
			//$Consulta.="and substring(fecha_creacion_paquete,1,4)='".$CmbAno."' ";
			$Consulta.=" and substring(fecha_creacion_paquete,1,4)=substr('".$Fechapi."',1,4)";
			//$Consulta.=" and t1.cod_subproducto = t3.cod_subproducto";
   

   
   
           // poly 28-02-2008 lote A-2829 $Consulta.=" and t1.cod_subproducto = '".$subproducto_consulta."'";
			$Consulta.="and t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto";
			//echo "con".$Consulta;
			$Respuesta3=mysqli_query($link, $Consulta);
			$Fila3=mysqli_fetch_array($Respuesta3);
			echo "<td width='221'>".$Fila3["descripcion"]."/".$Fila3["abreviatura"]."&nbsp;</td>";
			$Consulta="select sum(num_unidades) as unidades, sum(peso_paquetes) as paquetes from sec_web.paquete_catodo t1";
			$Consulta.=" inner join sec_web.lote_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
			$Consulta.=" and t1.num_paquete=t2.num_paquete ";					
			$Consulta.=" where (t1.cod_paquete='".$MesPaqueteI."' and t1.num_paquete between '".$NumPaqueteI."' and '".$NumPaqueteF."' and t1.cod_estado=t2.cod_estado)  and  ";
			$Consulta.=" t2.cod_bulto='".$CodBulto."' and t2.num_bulto='".$NumBulto."' and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  and LEFT(t2.fecha_creacion_lote,4) between '".$CmbAno."' and '".$anito."' and t2.corr_enm='".$IE."' and t1.cod_producto='".$Fila3["cod_producto"]."' and t1.cod_subproducto='".$Fila3["cod_subproducto"]."'";
			$Respuesta4=mysqli_query($link, $Consulta);
			$Fila4=mysqli_fetch_array($Respuesta4);
			$subprod = $Fila3["cod_subproducto"];
			echo "<input type='hidden' name='subprod' value='".$subprod."'>";
			//echo "<input type='hidden' name='sub_producto['".$i."']' value='".$sub_producto."'>"
			echo "<td width='89'>".$Fila4["unidades"]."&nbsp;</td>";
			echo "<td width='79'>".$Fila4["paquetes"]."&nbsp;</td>";
			echo "</tr>";
			$j++;
		}
		echo "</table>";
		?>
        <br>
        <table width="751" border="0" class="TablaInterior">
          <tr>
            <td  align="center" width="201"><div align="left">Cliente:
              <?php	
			$Consulta="select * from sec_web.programa_enami where corr_enm='".$IE."' ";
			$Respuesta=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
			{
				$Consulta="select * from sec_web.cliente_venta where cod_cliente='".$Fila["cod_cliente"]."' ";
				$Respuesta1=mysqli_query($link, $Consulta);
				if ($Fila1=mysqli_fetch_array($Respuesta1))
				{
					$Cliente=$Fila1["sigla_cliente"];
				}
				else
				{
					$Consulta="select * from sec_web.nave where cod_nave='".$Fila["cod_cliente"]."' ";
					$Respuesta2=mysqli_query($link, $Consulta);
					if ($Fila2=mysqli_fetch_array($Respuesta2))
					{
						$Cliente=$Fila1["nombre_nave"];
					}
				}
			}
			else
			{
				$Consulta="select * from sec_web.programa_codelco where corr_codelco='".$IE."' ";
				$Respuesta3=mysqli_query($link, $Consulta);
				if($Fila3=mysqli_fetch_array($Respuesta3))
				{
					$Consulta="select * from sec_web.cliente_venta where cod_cliente='".$Fila3["cod_cliente"]."' ";
					$Respuesta4=mysqli_query($link, $Consulta);
					if ($Fila4=mysqli_fetch_array($Respuesta4))
					{
						$Cliente=$Fila4["sigla_cliente"];
					}
					else
					{
						$Consulta="select * from sec_web.nave where cod_nave='".$Fila3["cod_cliente"]."' ";
						$Respuesta4=mysqli_query($link, $Consulta);
						if ($Fila4=mysqli_fetch_array($Respuesta4))
						{
							$Cliente=$Fila4["nombre_nave"];
						}
					}
				}
			}
			echo $Cliente;
			?>
            </div></td>
            <td  align="center" width="637"><div align="center">
                <input name="BtnGuardar" type="button" id="BtnGuardar" style="width:60" value="Guardar" onClick="Proceso('G')">
				<input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
            </div></td>
          </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</head>
</html>
