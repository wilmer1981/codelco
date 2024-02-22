<?php 	
 	$CodigoDeSistema = 3;
	$CodigoDePantalla =11;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");

	$Codigo  = isset($_REQUEST["Codigo"])?$_REQUEST["Codigo"]:"";
	$Numero  = isset($_REQUEST["Numero"])?$_REQUEST["Numero"]:"";
	$IE  = isset($_REQUEST["IE"])?$_REQUEST["IE"]:"";
	
?>
<html>
<head>
<script language="JavaScript">
function Salir()
{
	window.close();
}

function Detalle(CodBulto,NumBulto,IE)
{
	var Frm=document.FrmProceso;
	var LargoForm =Frm.elements.length;
	var cont =0;
	var MesI="";
	var NumI="";
	var MesF="";
	var NumF="";
	var CheckeoDetalle=false;
	var sw=0;
	for (i=1;i<Frm.checkbox.length;i++)
	{
		if (Frm.checkbox[i].checked==true)
		{
			MesI =Frm.MesPaqueteI[i].value ;
			NumI =Frm.NumPaqueteI[i].value ;
			MesF =Frm.MesPaqueteF[i].value ;
			NumF =Frm.NumPaqueteF[i].value ;
			CheckeoDetalle=true;
			sw++;
		}	
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
			window.open("sec_detalle_paquete2.php?Codigo="+CodBulto +"&Numero="+NumBulto+"&IE="+IE+"&MesI="+MesI+"&NumI="+NumI+"&MesF="+MesF+"&NumF="+NumF,""," fullscreen=no,left=80,width=580,height=400,scrollbars=yes,resizable = yes");
		}
	}
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmProceso" method="post" action="">
  <table width="697" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
      <td width="697"> 
        <table width="685" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="27"> <input type="hidden" name="CheckTodos" value="checkbox"></td>
            <td width="120"><div align="center">#Inicial S-Lote</div></td>
            <td width="115" align="left"><div align="center">#Final S-Lote</div></td>
            <td width="195" align="left"><div align="center">Descripcion</div></td>
            <td width="116"><div align="center">Unidades Serie</div></td>
            <td width="73"><div align="center"></div>
              <div align="center">Peso Serie</div></td>
          </tr>
        </table>
       <?php
  		echo "<table width='685' border='1' cellpadding='3' cellspacing='0'>";
		$Consulta = "SELECT  distinct cod_paquete,num_paquete ";
		$Consulta.=" from sec_web.lote_catodo ";
		$Consulta.=" where cod_bulto='".$Codigo."' and num_bulto='".$Numero."' and corr_enm=".$IE;
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
						if(!is_null($arreglo) && is_array($arreglo) && isset($arreglo[$i+1][1])){
							$arreg1= $arreglo[$i+1][1];
						}else{
							$arreg1= 0;
						}
						if(!is_null($arreglo) && is_array($arreglo) && isset($arreglo[$i+2][1])){
							$arreg2= $arreglo[$i+2][1];
						}else{
							$arreg2= 0;
						}
						//if ($arreglo[$i+1][1]!=($arreglo[$i+2][1]-1))
						if ($arreg1!=($arreg2-1))
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
		foreach($vector as $Clave => $Valor)
		{
			$Inicial=explode("-",$Valor[0]);
			$Final=explode("-",$Valor[1]);
			echo "<tr>";
      		echo '<td width="20px"><input name="checkbox" type="checkbox"  value=""></td>';
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
			$Consulta="SELECT t1.cod_producto,t2.descripcion from sec_web.paquete_catodo t1 ";
			$Consulta.=" inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto			";
			$Consulta.=" where cod_paquete='".$MesPaqueteI."' and num_paquete='".$NumPaqueteI."'							";
			$Respuesta3=mysqli_query($link, $Consulta);
			$Fila3=mysqli_fetch_array($Respuesta3);
			echo "<td width='150'>".$Fila3["descripcion"]."&nbsp;</td>";
			$Consulta="SELECT sum(num_unidades) as unidades, sum(peso_paquetes) as paquetes from sec_web.paquete_catodo t1";
			$Consulta.=" inner join sec_web.lote_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
			$Consulta.=" and t1.num_paquete=t2.num_paquete ";					
			$Consulta.=" where (t1.num_paquete between '".$NumPaqueteI."' and '".$NumPaqueteF."' and t1.cod_estado=t2.cod_estado)  and  ";
			$Consulta.=" t2.cod_bulto='".$Codigo."' and t2.num_bulto='".$Numero."' and t2.corr_enm=".$IE;
			$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
			//echo $Consulta;
			$Respuesta4=mysqli_query($link, $Consulta);
			$Fila4=mysqli_fetch_array($Respuesta4);
			echo "<td width='89'>".$Fila4["unidades"]."&nbsp;</td>";
			echo "<td width='79'>".$Fila4["paquetes"]."&nbsp;</td>";
			echo "</tr>";
		}
		echo "</table>";
		?>
        <br>
        <table width="687" border="0" class="TablaInterior">
          <tr> 
            <td width="678"  align="center">
			    <input name="BtnDetalle" type="button" id="BtnDetalle" style="width:60" onClick="Detalle('<?php echo $Codigo;?>','<?php echo $Numero;?>','<?php echo $IE;?>')" value="Detalle">
                <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
           </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
