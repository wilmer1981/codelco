<?php 	
 	$CodigoDeSistema = 3;
	$CodigoDePantalla =11;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	$Fecha = date('Y-m-d');
	$anito=substr($Fecha,0,4);
	$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '3'  ";
	$Respuesta =mysqli_query($link, $Consulta);
	if($Fila =mysqli_fetch_array($Respuesta))
	{
		$Nivel = $Fila["nivel"];
	}
	if ($Mostrar=="S")
	{
		/*$Consulta="select cod_marca,corr_enm from lote_catodo ";
		$Consulta.=" where cod_bulto='".$CmbCodBulto."' and num_bulto='".$NumBulto."'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$Marca=$Fila["cod_marca"];
		$ENM=$Fila["corr_enm"];*/
	}
?>
<html>
<head>
<script language="JavaScript">
function Salir()
{
	var Frm=document.FrmProceso;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();
}
function Recarga()
{
	var Frm=document.FrmProceso;
	var CodBulto="";
	//alert(Frm.CmbSerie.value);
	CodBulto=(Frm.CmbSerie.value.substr(0,1));
	NumBulto=(Frm.CmbSerie.value.substr(2,Frm.CmbSerie.value.length));
	Frm.action="sec_adm_lotes.php?Mostrar=S&CodBulto="+CodBulto+"&NumBulto="+NumBulto+"&Mostrar2=S&Mes="+Frm.CmbCodBulto.value;
	Frm.submit();
}
function CambiarMarca(codigo,numero)
{
	var Frm=document.FrmProceso;
	window.open("sec_asignar_marca.php?Ano="+Frm.CmbAno.value+"&Codigo="+codigo +"&Numero="+numero,""," fullscreen=no,width=700,height=400,scrollbars=yes,resizable = yes");
}
function ModificarProd(codigo,numero,prod,subprod)
{
	var Frm=document.FrmProceso;
	var Frm=document.FrmProceso;
	var LargoForm =Frm.elements.length;
	var cont =0;
	var MesI="";
	var NumI="";
	var MesF="";
	var NumF="";
	var sub_producto="";
	var CheckeoDetalle=false;
	var Datos="";
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
				sub_producto=Frm.subprod[l].value;
			else
				sub_producto=Frm.subprod.value;
			CheckeoDetalle=true;
			sw++;
			Datos=Datos+MesI+"~"+NumI+"~"+MesF+"~"+NumF+"//";		
		}
		l++;	
	}
	if (CheckeoDetalle==false)
	{
		alert("No Hay Elementos Seleccionados");
	}
	else
	{
		Datos=Datos.substr(0,Datos.length-2);
		//alert(Datos);
		window.open("sec_modificar_producto.php?Ano="+Frm.CmbAno.value+"&Codigo="+codigo +"&Numero="+numero+"&CmbProductos="+prod+"&cmbsubproducto="+subprod+"&Valores="+Datos,""," fullscreen=no,width=400,height=250,scrollbars=yes,resizable = yes");		
	}
	
}

function Detalle()
{
	var Frm=document.FrmProceso;
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
			CodBulto=(Frm.CmbSerie.value.substr(0,1));
			NumBulto=(Frm.CmbSerie.value.substr(2,Frm.CmbSerie.value.length));
			window.open("sec_detalle_paquete.php?Ano="+Frm.CmbAno.value+"&subproducto="+sub_producto+"&Codigo="+CodBulto +"&Numero="+NumBulto+"&MesI="+MesI+"&NumI="+NumI+"&MesF="+MesF+"&NumF="+NumF+"&Ano="+Frm.CmbAno.value,""," fullscreen=no,width=680,height=400,scrollbars=yes,resizable = yes");
		}
	}
}
function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmProceso;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("sec_ingreso_marca_proceso.php?Proceso="+Proceso,"","top=80,left=180,width=430,height=300,scrollbars=no,resizable = no");
			break;
	}
}
function Eliminar(Ano,codigo,numero)
{
	var Frm=document.FrmProceso;
	var mensaje = confirm("�Seguro que desea Quitar la Relacion?");
	var Valores="";
	if (mensaje==true)
	{
		for (i=1;i<Frm.checkbox.length;i++)
		{
			Valores =Valores + Frm.checkbox[i].value +  "//" ;
		}
		Valores=Valores.substr(0,Valores.length-2);
		Frm.action="sec_conf_inicial_lotes_proceso01.php?AnoLote="+Frm.CmbAno.value+"&Codigo="+codigo +"&Numero="+numero+"&Valores="+Valores+"&Proceso=QuitarRelacion";
		Frm.submit();
	}
	else
	{
		return;
	}
}
</script>
<title>Proceso</title>
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
<form name="FrmProceso" method="post" action="">
 



  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="776" align="center" valign="top"
	><table width="754" border="0" class="TablaInterior">
          <tr> 
            <td width="27"><font size="2">&nbsp; </font></td>
            <td width="126"><font size="2">A&ntilde;o</font><font size="1"><font size="2"><font size="1"><font size="2"><font size="1"><font size="2"> 
              <select name="CmbAno" size="1" id="select9" style="width:70px;" onChange="Recarga();">
                <?php
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
			?>
              </select>
              </font></font><font size="2"></font></font></font></font></font></td>
            <td width="36"><font size="1"><font size="2"> </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Mes</font></font></td>
            <td width="99"><font size="2"> 
              <select name="CmbCodBulto" onChange="Recarga();">
                <?php
				if ($Mostrar2!="S")
				{	
					$Mes=date("n");
					$CmbCodBulto=$Mes;		
				}
				else
				{
					$CmbCodBulto=$Mes;		
				}
				$Consulta="select * from proyecto_modernizacion.sub_clase ";
				$Consulta.=" where cod_clase='3004' and cod_subclase between 1 and 12   ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbCodBulto==$Fila["cod_subclase"])
					{
						echo "<option value=".$Fila["cod_subclase"]." selected>".$Fila["nombre_subclase"]."</option>";	
					}
					else
					{
						echo "<option value=".$Fila["cod_subclase"].">".$Fila["nombre_subclase"]."</option>";	
					}
				}
				?>
              </select>
              </font></td>
            <td width="88">N&deg; Lote</td>
            <td width="20"><input type="text" name="textlote"><?php echo "'".$txtlote."'";  ?></td>
            <td width="79"><input type="button" name="BtnBuscar" value="OK" onClick="Buscar();"></td>
            <td colspan="2">&nbsp;              </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>Total paquetes</td>
            <td colspan="2"> 
              <?php
				$Consulta="select count(num_paquete) as numero from sec_web.lote_catodo ";
				$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and substring(fecha_creacion_lote,1,4)='".$CmbAno."'	";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);	
				echo $Fila["numero"];
			?>
            </td>
            <td>Total Unidades</td>
            <td> 
              <?php
				$Consulta="select sum(num_unidades) as suma_unidades,sum(peso_paquetes) as suma_paquetes from sec_web.lote_catodo t1 ";
				$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
				$Consulta.=" and t1.num_paquete=t2.num_paquete ";
				$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and  ";
				$Consulta.=" LEFT(fecha_creacion_lote,4) between '".$CmbAno."' and '".$anito."'";
				$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  and t1.cod_estado=t2.cod_estado 	";
				//echo $Consulta;
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$SumaUnidades=$Fila[suma_unidades];
				$SumaPeso=$Fila[suma_paquetes];
				echo $SumaUnidades;
			?>
              &nbsp;</td>
            <td>Total Peso</td>
            <td width="77"> 
              <?php
			echo $SumaPeso;
			?>
            </td>
            <td width="93">IE:<?php echo $IE ?></td>
          </tr>
        </table>
		<br>
          <table width="752" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="42"> <input type="hidden" name="CheckTodos" value="checkbox"> 
            </td>
            <td width="92"><div align="center">#Inicial S-Lote</div></td>
            <td width="88" align="left"><div align="center">#Final S-Lote</div></td>
            <td width="221" align="left"><div align="center">Producto/SubProducto
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
            </div></td>
            <td width="89"><div align="center">Unidades Serie</div></td>
            <td width="79"><div align="center"></div>
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
			echo "<tr>";
      		echo "<td width='42px'><input name='checkbox' type='checkbox'  value='".$Inicial[0]."~".$Inicial[1]."~".$Final[0]."~".$Final[1]."'></td>";
			echo "<td width='92'>".$Inicial[0]."-".$Inicial[1]."</td>";
			echo "<td width='92'>".$Final[0]."-".$Final[1]."</td>";
			
			
			$MesPaqueteI=$Inicial[0];
			echo "<input type='hidden' name='MesPaqueteI' value='".$Inicial[0]."'>";
			$NumPaqueteI=$Inicial[1];
			echo "<input type='hidden' name='NumPaqueteI' value='".$Inicial[1]."'>";
			$Fechapi=$Inicial[2];
			$MesPaqueteF=$Final[0];
			echo "<input type='hidden' name='MesPaqueteF' value='".$Final[0]."'>";
			
			$NumPaqueteF=$Final[1];
			echo "<input type='hidden' name='NumPaqueteF' value='".$Final[1]."'>";
			$Fechapf=$Final[2];
			$cont = $cont +  9;
			$Consulta="select t1.cod_producto, t1.cod_subproducto,t2.descripcion,t2.abreviatura as abrevP,t3.abreviatura from sec_web.paquete_catodo t1";
			$Consulta.=" inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
			$Consulta.=" inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto";
			$Consulta.=" where  cod_paquete='".$MesPaqueteI."' and num_paquete='".$NumPaqueteI."'";
			$Consulta.="and substring(fecha_creacion_paquete,1,4)=substr('".$Fechapi."',1,4)";
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
            <td  align="center" width="637"><div align="left"> 
                <input name="BtnActualizar" type="submit" id="BtnActualizar" style="width:60" value="Actualizar">
                <input name="BtnDetalle" type="button" id="BtnDetalle" style="width:60" onClick="Detalle()" value="Detalle">
				<input name="BtnMarca" type="button" id="BtnNueva" style="width:80" onClick="MostrarPopupProceso('N')" value="Nueva Marca">

               <?php
			   if (($Nivel=='6')||($Nivel=='1'))
				{
					echo "<input name='BtnAsignar' type='button'  style='width:60' value='Marca' onClick=\"CambiarMarca('$CodBulto','$NumBulto')\">";
					
					if($IE<900000)
						echo "<input name='BtnEliminar' type='button'  style='width:90' value='Quitar Relacion' onClick=\"Eliminar('$CmbAno','$CodBulto','$NumBulto')\" >";
					else
						echo "<input name='BtnModProd' type='button'  style='width:90' value='Prod_SubProd' onClick=\"ModificarProd('$CodBulto','$NumBulto','$Fila3["cod_producto"]','$Fila3["cod_subproducto"]')\">";	
				}
				?>
              </div></td>
          </tr>
      </table> </td>
  </tr>
</table>
 <?php include("../principal/pie_pagina.php");
 
  		echo "<script languaje='JavaScript'>";
		echo "var frm=document.FrmProceso;";
		if ($Mensaje=='S')
		{
			echo "alert('Este Lote esta Asociado a una Inst Embarque');";
		}
		if ($Mensaje2=='S')
		{
			echo "alert('No se Puede Deshacer El Lote por que esta cerrado');";
		}
		if($Mensaje3!="")
		{
			echo "alert('".$Mensaje3."');";	
		}		
		echo "</script>"
  ?>
</form>
</body>
</html>
