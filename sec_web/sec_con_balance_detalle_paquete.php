<?php 
	include("../principal/conectar_principal.php");
		
	$Producto    = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Ano         = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";
	$Codigo      = isset($_REQUEST["Codigo"])?$_REQUEST["Codigo"]:"";
	$Numero      = isset($_REQUEST["Numero"])?$_REQUEST["Numero"]:"";


	$CodSubProducto  = "";
	$DescripProducto = "";
	//PRODUCTO
	$Consulta = "select * from proyecto_modernizacion.productos where cod_producto = '".$Producto."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$DescripProducto = $Fila["descripcion"];

	}
	//SUBPRODUCTO
	if ($SubProducto == "T")
	{
		$DescripSubProducto = "TODOS";
	}
	else
	{
		$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$Producto."' and cod_subproducto='".$SubProducto."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$DescripSubProducto = $Fila["descripcion"];
            $CodSubProducto = $Fila["cod_subproducto"];
		}
	}

	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase='3004' and nombre_subclase='".$Codigo."' ";
	$Respuesta0=mysqli_query($link, $Consulta);
	$Fila0=mysqli_fetch_array($Respuesta0);
	$CmbCodBulto = $Fila0["cod_subclase"];
	$CmbSerie = $Numero;
	$CodBulto = $Codigo;
	$NumBulto = $Numero;
	//le puese en duro 2005 ver despues porque le pasa siempre 2003
	//$Ano = '2005';

	$CmbAno = $Ano;
 if ($CmbAno == '2007')
	   $AnoAux = $Ano + 1;
	
	//SERIE DE PAQUETES
	$SeriePaquetes = "";
	$Consulta = "select t1.cod_paquete, t1.num_paquete ";
	$Consulta.= " from sec_web.lote_catodo t1 ";	
	$Consulta.= " where t1.cod_bulto = '".$Codigo."' ";
	$Consulta.= " and t1.num_bulto = '".$Numero."' ";
	//$Consulta.="  and substring(fecha_creacion_lote,1,4)='".$CmbAno."'";
	$Consulta.="  and year(fecha_creacion_lote) = '".$CmbAno."'";
	$Consulta.= " order by t1.cod_bulto, t1.num_bulto, t1.cod_paquete, t1.num_paquete ";
	//echo "XXXX".$Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$CodPaquete = "";
	$NumPaquete = "";
	$CodPaqueteAnt = "";
	$NumPaqueteAnt = "";
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$CodPaquete = $Fila["cod_paquete"];
		$NumPaquete = $Fila["num_paquete"];
		if (($CodPaqueteAnt != $CodPaquete) || (($NumPaqueteAnt + 1) != $NumPaquete))
		{
			if ($SeriePaquetes == "")
				$SeriePaquetes = $Fila["cod_paquete"]."-".str_pad($Fila["num_paquete"], 6, "0", STR_PAD_LEFT);
			else
				$SeriePaquetes = $SeriePaquetes."/".$CodPaqueteAnt."-".str_pad($NumPaqueteAnt, 6, "0", STR_PAD_LEFT)."&nbsp;&nbsp;".$Fila["cod_paquete"]."-".str_pad($Fila["num_paquete"], 6, "0", STR_PAD_LEFT);
		}
		$CodPaqueteAnt = $Fila["cod_paquete"];
		$NumPaqueteAnt = $Fila["num_paquete"];
	}
	if (($CodPaqueteAnt != $CodPaquete) || (($NumPaqueteAnt) != $NumPaquete))
		$SeriePaquetes = $SeriePaquetes."&nbsp;&nbsp;".$CodPaquete."-".str_pad($NumPaquete, 6, "0", STR_PAD_LEFT);
	else
		$SeriePaquetes = $SeriePaquetes."/".$CodPaquete."-".str_pad($NumPaquete, 6, "0", STR_PAD_LEFT);	 
?>
<html>
<head>
<title>Detalle de SubLotes </title>
<link href="../principal/estilos/css_pmn_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function DetallePqtes()
{
	var Frm=document.frmConsulta;
	var LargoForm =Frm.elements.length;
	var cont =0;
	var MesI="";
	var NumI="";
	var MesF="";
	var NumF="";
	var sub_producto="";
	var CheckeoDetalle=false;
	var sw=0;
	var l = 0;
	var a =  Frm.checkbox.length;
	
	for (i=1;i<Frm.checkbox.length;i++)
	{
		if (Frm.checkbox[i].checked==true)
		{
			MesI =Frm.MesPaqueteI[i].value ;
			NumI =Frm.NumPaqueteI[i].value ;
			MesF =Frm.MesPaqueteF[i].value ;
			NumF =Frm.NumPaqueteF[i].value ;
			if (a> 2)
			{
				sub_producto=Frm.subprod[l].value;
			}
			else
			{
			sub_producto=Frm.subprod.value;
			}
			CheckeoDetalle=true;
			sw++;
			
		}
		l++;	
	}
	if (CheckeoDetalle==false)
	{
		alert("No Hay Elementos Seleccionados ");
	}
	else
	{
		if (sw > 1)
		{
			alert("Debe Seleccionar Solo un Elemento");
		}
		else
		{			
			window.open("sec_detalle_paquete.php?Ano="+Frm.CmbAno.value+"&subproducto="+sub_producto+"&Codigo="+ Frm.CmbBulto.value +"&Numero="+ Frm.CmbSerie.value +"&MesI="+MesI+"&NumI="+NumI+"&MesF="+MesF+"&NumF="+NumF+"&Ano="+Frm.CmbAno.value,""," fullscreen=no,width=680,height=400,scrollbars=yes,resizable = yes");
		}
	}
}

</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmConsulta" action="" method="post">
<input name="NumI" type="hidden" value="<?php echo $NumI  ?>">
<input name="NumF" type="hidden" value="<?php echo $NumF  ?>">
<input name="MesI" type="hidden" value="<?php echo $MesI  ?>">
<input name="AnoAux" type="hidden" value="<?php echo $Ano  ?>">

<input name="CmbAno" type="hidden" value="<?php echo $CmbAno  ?>">
<input name="CmbBulto" type="hidden" value="<?php echo $Codigo ?>">
<input name="CmbSerie" type="hidden" value="<?php echo $Numero  ?>">
  
      <table width="600" border="0" align="center" cellpadding="1" cellspacing="1" class="TablaInterior">
        <tr align="center">
          <td height="30" colspan="4"><strong>DETALLE DE SUBLOTES </strong></td>
        </tr>
        <tr> 
          <td width="121" height="16"><strong>PRODUCTO</strong></td>
          <td colspan="3"> 
            <?php	echo strtoupper($DescripProducto); ?>
          </td>
        </tr>
        <tr> 
          <td><strong>SUBPRODUCTO</strong></td>
          <td colspan="3"> 
            <?php	echo strtoupper($DescripSubProducto); ?>
          </td>
        </tr>
        <tr> 
          <td><strong>LOTE</strong></td>
          <td> 
            <?php
			echo $Codigo;
			echo "-";
			echo $Numero;
			echo "<input name='CodigoO' type='hidden' value='$Codigo'>";
			echo "<input name='NumeroO' type='hidden' value='$Numero'>";
			?>
          </td>
          <td>&nbsp;</td>
          <td>&nbsp; </td>
        </tr>
        <tr> 
          <td><strong>SUB-LOTES</strong></td>
          <td colspan="3"> 
            <?php	echo $SeriePaquetes; ?>
          </td>
        </tr>
        <tr> 
          <td><strong>TOTAl PAQUETES</strong></td>
          <td> 
            <?php			
				$Consulta="select count(num_paquete) as numero from sec_web.lote_catodo ";
				$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' ";
				//$Consulta.=" and substring(fecha_creacion_lote,1,4)='".$CmbAno."'	";
				$Consulta.="  and year(fecha_creacion_lote) = ".$CmbAno." ";

				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);	
				echo $Fila["numero"];
			?>
          </td>
          <td>&nbsp;</td>
          <td>&nbsp; </td>
        </tr>
        <tr> 
          <td><strong>TOTAL UNIDADES</strong></td>
          <td width="107">
            <?php
				$Consulta="select sum(num_unidades) as suma_unidades,sum(peso_paquetes) as suma_paquetes, t1.corr_enm as IE from sec_web.lote_catodo t1 ";
				$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
				$Consulta.=" and t1.num_paquete=t2.num_paquete ";
				$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' ";
//				$Consulta.=" and LEFT(fecha_creacion_lote,4)='".$CmbAno."'	";
				$Consulta.="  and year(fecha_creacion_lote) = ".$CmbAno." ";
				$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  and t1.cod_estado=t2.cod_estado group by t1.corr_enm	";
				//  echo "cc".$Consulta;
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$SumaUnidades=$Fila["suma_unidades"];
				$SumaPeso=$Fila["suma_paquetes"];
                $IE = $Fila["IE"];
				echo $SumaUnidades;
			?>
          </td>
          <td width="143">&nbsp;</td>
          <td width="202">&nbsp; </td>
        </tr>
        <tr> 
          <td><strong>TOTAL PESO</strong></td>
          <td>
            <?php
			echo $SumaPeso;
			?>
          </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><strong>IE</strong></td>
          <td colspan="3"><?php echo $IE ?></td>
        </tr>
        <tr> 
          <td><strong>MARCA</strong></td>
          <td colspan="3"> 
            <?php
					$Consulta="select distinct t1.cod_marca,t2.descripcion,t1.corr_enm from sec_web.lote_catodo t1";
					$Consulta.=" left join sec_web.marca_catodos t2 on t1.cod_marca = t2.cod_marca	";
					$Consulta.=" where t1.cod_bulto ='".$CodBulto."' and t1.num_bulto='".$NumBulto."' ";
				//	$Consulta.=" and substring(fecha_creacion_lote,1,4)='".$CmbAno."'";
					$Consulta.="  and year(fecha_creacion_lote) = ".$CmbAno." ";

					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Descripcion=$Fila["descripcion"];
					$CodMarca=$Fila["cod_marca"];
					$IE=$Fila["corr_enm"];
			echo $CodMarca;
			echo "&nbsp;&nbsp;";
			echo $Descripcion;
			?>
            <input name="MarcaBulto" type="hidden" value="<?php echo $CodMarca; ?>"></td>
        </tr>
      </table>
        
      <br>
      <br> 
      <table width="600" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
        <tr class="ColorTabla01"> 
          <td width="24"> <input type="hidden" name="CheckTodos" value="checkbox"> 
          </td>
          <td width="87"><div align="center">#Inicial S-Lote</div></td>
          <td width="81" align="left"><div align="center">#Final S-Lote</div></td>
          <td width="236" align="left"><div align="center">Producto/SubProducto</div></td>
          <td width="64"><div align="center">Unidades</div></td>
          <td width="57"><div align="center"></div>
            <div align="center">Peso</div></td>
        </tr>
      <?php
		$Consulta = "SELECT  distinct cod_paquete,num_paquete ";
		$Consulta.=" from sec_web.lote_catodo ";
		$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' ";
	//	$Consulta.=" and substring(fecha_creacion_lote,1,4)='".$CmbAno."' ";
		$Consulta.="  and year(fecha_creacion_lote) = ".$CmbAno." ";
		$Consulta.=" order by fecha_creacion_lote desc,cod_paquete,num_paquete ";

		$Respuesta = mysqli_query($link, $Consulta);
		$cont=1;
		$arreglo=array();
		$i=0;
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			$arreglo[$i]=	array($Fila["cod_paquete"],$Fila["num_paquete"]);
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
						$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1];//inicial
						$sw=1;
					}
					else
					{    
						$arreglo11 = isset($arreglo[$i+1][1])?$arreglo[$i+1][1]:0;
						$arreglo21 = isset($arreglo[$i+2][1])?$arreglo[$i+2][1]:0;
						//if ($arreglo[$i+1][1]!=($arreglo[$i+2][1]-1))
						if ($arreglo11!=($arreglo21-1))
						{
							$vector[$a][1]=$arreglo[$i+1][0]."-".$arreglo[$i+1][1];//final
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
						$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1];//inicial
						$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
						$a++;
					}
					else
					{
						$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
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
						$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1];//inicial
					}
					$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
				}		
				else
				{
					if ($sw==1)
					{
						$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
						$a++;
						$sw=0;
					}
					else
					{
						$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1];//inicial
						$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
						$a++;
					}
				}
			}
			$i++;
		}		
		reset($vector);
		echo "<input name ='checkbox' type='hidden' ><input name ='MesPaqueteI' type='hidden' ><input name ='NumPaqueteI' type='hidden' ><input name ='MesPaqueteF' type='hidden' ><input name ='NumPaqueteF' type='hidden' >";
		$j=1;
		//while (list($Clave,$Valor)=each($vector))
		foreach ($vector as $Clave => $Valor)
		{
			
			$Inicial=explode("-",$Valor[0]);
			$Final=explode("-",$Valor[1]);
			echo "<tr>";
      		echo "<td width='42px'><input name='checkbox' type='checkbox'  value='".$Inicial[0]."~".$Inicial[1]."~".$Final[0]."~".$Final[1]."'></td>";
			echo "<td width='92'>".$Valor[0]."</td>";
			echo "<td width='92'>".$Valor[1]."</td>";
			$MesPaqueteI=$Inicial[0];
			echo "<input type='hidden' name='MesPaqueteI' value='".$Inicial[0]."'>";
			$NumPaqueteI=$Inicial[1];
			echo "<input type='hidden' name='NumPaqueteI' value='".$Inicial[1]."'>";
			$MesPaqueteF=$Final[0];
			echo "<input type='hidden' name='MesPaqueteF' value='".$Final[0]."'>";
			$NumPaqueteF=$Final[1];
			echo "<input type='hidden' name='NumPaqueteF' value='".$Final[1]."'>";			
			$cont = $cont +  9;
			$Consulta="select t1.cod_producto, t1.cod_subproducto,t2.descripcion,t2.abreviatura as abrevP,t3.abreviatura from sec_web.paquete_catodo t1";
			$Consulta.=" inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
			$Consulta.=" inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto";
			$Consulta.=" where cod_paquete='".$MesPaqueteI."' and num_paquete='".$NumPaqueteI."' and (year(fecha_creacion_paquete) <= '".$CmbAno."'||  year(fecha_creacion_paquete) <= '".$AnoAux."')";
			$Consulta.="and t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.cod_subproducto = '".$CodSubProducto."' ";
			//  echo "con".$Consulta;
			$Respuesta3 = mysqli_query($link, $Consulta);
			$Fila3      = mysqli_fetch_array($Respuesta3);
			$descripcion = isset($Fila3["descripcion"])?$Fila3["descripcion"]:"";
			$abreviatura = isset($Fila3["abreviatura"])?$Fila3["abreviatura"]:"";
			$cod_producto= isset($Fila3["cod_producto"])?$Fila3["cod_producto"]:"";
			$cod_subproducto = isset($Fila3["cod_subproducto"])?$Fila3["cod_subproducto"]:"";
			echo "<td width='221'>".$descripcion."/".$abreviatura."&nbsp;</td>";
			$Consulta="select sum(num_unidades) as unidades, sum(peso_paquetes) as paquetes from sec_web.paquete_catodo t1";
			$Consulta.=" inner join sec_web.lote_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
			$Consulta.=" and t1.num_paquete=t2.num_paquete ";					
			$Consulta.=" where (t1.cod_paquete='".$MesPaqueteI."' and t1.num_paquete between '".$NumPaqueteI."' and '".$NumPaqueteF."' and t1.cod_estado=t2.cod_estado)  and  ";
			$Consulta.=" t2.cod_bulto='".$CodBulto."' and t2.num_bulto='".$NumBulto."' and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  ";
	//		$Consulta.=" and LEFT(t2.fecha_creacion_lote,4)='".$CmbAno."' ";
			$Consulta.="  and year(fecha_creacion_lote) = ".$CmbAno." ";
			$Consulta.=" and t2.corr_enm='".$IE."' and t1.cod_producto='".$cod_producto."' and t1.cod_subproducto='".$cod_subproducto."'";
						//echo "con".$Consulta;
			$Respuesta4= mysqli_query($link, $Consulta);
			$Fila4     = mysqli_fetch_array($Respuesta4);
			//$subprod   = $Fila3["cod_subproducto"];
			echo "<input type='hidden' name='subprod' value='".$cod_subproducto."'>";
			echo "<td width='89'>".$Fila4["unidades"]."&nbsp;</td>";
			echo "<td width='79'>".$Fila4["paquetes"]."&nbsp;</td>";
			echo "</tr>";
			$j++;
		}
		?></table>
      <br> 
      <table width="600" border="0" align="center" class="TablaInterior">
        <tr> 
          <td  align="center" width="205"><div align="left">Cliente: 
              <?php	
			$Consulta="select * from sec_web.programa_enami where corr_enm='".$IE."' ";
			$Respuesta=mysqli_query($link, $Consulta);
			$Cliente="";
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
          <td  align="center" width="371"><div align="left"> 
              <input name="BtnImprimir" type="button"  value="Imprimir"onClick="JavaScript:window.print();" style="width:70px;">
              <input name="BtnDetalle" type="button" style="width:70px;" onClick="JavaScript:DetallePqtes();" value="Detalle">
              <input name="btnCerrar" type="button" value="Cerrar" onClick="JavaScript:window.close();" style="width:70px;">
            </div></td>
        </tr>
      </table>
</form>
</body>
</html>
