<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla =28;
	include("../principal/conectar_sec_web.php");
	set_time_limit(3000);
   $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
		$productos = array(18=>"CATODOS", 64=> "SALES", 48=> "DESPUNTES Y LAMINAS", 57=> "BARROS REFINERIA", 66=> "OTROS PESAJES", 19=> "RESTOS ANODOS", 17=> "ANODOS");

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
			eval("Txt" + numero + ".style.left = 355 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function Salir()
{
	var Frm=document.FrmProceso;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
	Frm.submit();
}
function Consultar()
{
	var Frm=document.FrmProceso;
	
	if(Frm.cmbproducto.value=='-1')
	{
		alert('Debe seleccionar Producto');	
		return;
	}
	if(Frm.cmbsubproducto.value=='-1')
	{
		alert('Debe seleccionar Sub-Producto');	
		return;
	}
	if(Frm.CmbEstado.value=='-1')
	{
		alert('Debe seleccionar Estado');	
		return;
	}
	
	Frm.action="sec_consulta_paquetes_gradoA.php?Mostrar=S";
	Frm.submit();
}
function Recarga()
{
	var Frm=document.FrmProceso;
	var Orden="";
	Frm.action="sec_consulta_paquetes_gradoA.php?Recarga=S";
	Frm.submit();
}

function Excel()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_consulta_paquetes_gradoA_xls.php?cmbproducto="+Frm.cmbproducto.value+"&cmbsubproducto="+Frm.cmbsubproducto.value+"&CmbMes="+Frm.CmbMes.value+"&CmbAno="+Frm.CmbAno.value+"&CmbEstado="+Frm.CmbEstado.value;
	Frm.submit();
}

function Imprimir()
{
	var Frm=document.FrmProceso;
	window.print();
}
</script>
<title>Detalle Paquetes Grado "A"</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif">
<center>
<form name="FrmProceso" method="post" action="">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5">
      <tr>
      <td width="883" align="left"> 
		<table width="1000" border="0" class="TablaInterior">
            <tr> 
              <td  align="left" width="130">Producto</td>
              <td  align="left" width="197"><select name="cmbproducto" onChange="Recarga()">
                <option value="-1">SELECCIONAR</option>
                <?php
					foreach($productos as $clave => $valor)
					{
						if (($clave == $cmbproducto))
							echo '<option value="'.$clave.'" selected>'.$valor.'</option>';
						else 
							echo '<option value="'.$clave.'">'.$valor.'</option>';
					}	
			?>
              </select></td>
              <td  align="left" width="167">Fecha</td>
              <td  align="left" width="270"><?php
			echo"<select name='CmbMes'>";
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
			echo "<select name='CmbAno'>";
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
			echo "</select>";
	?></td>
            </tr>
            <tr>
              <td  align="left">Sub-Producto</td>
              <td  align="left"><select name="cmbsubproducto">
                <option value="-1">SELECCIONAR</option>
                <?php	
				$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = ".$cmbproducto." AND tipo_mov LIKE '%".$cmbmovimiento."%'";
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
					$codigo = $row["cod_subproducto"];
					$descripcion = $row["descripcion"];
					if (($cmbmovimiento == 3) and ($cmbproducto == 48) and ($codigo == 1))	
						$descripcion = "LAMINAS";
				
					if (($codigo == $cmbsubproducto))
						echo '<option value="'.$codigo.'" selected>'.$descripcion.'</option>';
					else
						echo '<option value="'.$codigo.'">'.$descripcion.'</option>';
				}						
				?>
              </select></td>
              <td  align="left">Estado Paquete</td>
              <td  align="left"><select name="CmbEstado">
              <option value="-1">SELECCIONAR</option>
              <?php
              switch($CmbEstado)
			  {
					case "a":
						echo '<option value="a" selected>Abierto</option>';
						echo '<option value="c" >Cerrado</option>';
						echo '<option value="t" >Todos</option>';
					break; 
					case "c":
						echo '<option value="a" >Abierto</option>';
						echo '<option value="c" selected>Cerrado</option>';
						echo '<option value="t" >Todos</option>';
					break; 
					case "t":
						echo '<option value="a" >Abierto</option>';
						echo '<option value="c" >Cerrado</option>';
						echo '<option value="t" selected>Todos</option>';
					break; 
					default:
						echo '<option value="a">Abierto</option>';
						echo '<option value="c">Cerrado</option>';
						echo '<option value="t">Todos</option>';
					break;
					 
			  }
			  ?></select>
              &nbsp;</td>
            </tr>
            <tr>
              <td  align="center" colspan="4"><input name="BtnConsultar" type="button" id="BtnConsultar5" value="Consultar" style="width:60px;" onClick="Consultar('');">
                <input name="BtnImprimir22" type="button" id="BtnImprimir22" value="Imprimir" style="width:60px;" onClick="Imprimir();">
                <input name="BtnExcel" type="button" id="BtnImprimir5" value="Excel" style="width:60px;" onClick="Excel();">
              <input type="button" name="BtnSalir2" value="Salir" style="width:60" onClick="Salir();"></td>
            </tr>
          </table>
		<br>
        <table width="1000" height="20" border="1" cellpadding="3" cellspacing="0">
          <tr class="ColorTabla01"> 
            <td width="46" align="left"><div align="center">I.E.</div></td>
            <td width="120" align="left"><div align="center">Cliente</div></td>
            <td width="20" align="left"><div align="left">Cod.Lote</div></td>
            <td width="30" align="left"><div align="left">Num.Lote</div></td>
            <td width="60" align="left"><div align="left">Fecha Creacion Lote</div></td>
            <td width="20" align="left"><div align="left">Cod.Paquete</div></td>
            <td width="30" align="left"><div align="left">Num.Paquete</div></td>
             <td width="60"><div align="center">Fecha Creacion Paquete</div>
            <td width="30" align="left"><div align="left">Estado</div></td>
            <td width="40"><div align="center">Peso</div></td>
            <td width="40"><div align="center">Unidades</div></td>
            <td width="40"><div align="center">Promedio</div></td>
          </tr>
        <?php
			if ($Mostrar=='S')
			{
				if (strlen($CmbMes)==1)
				{
					$CmbMes="0".$CmbMes;
				}
				$FechaInicio=$CmbAno."-".$CmbMes."-01";
				$FechaFin=$CmbAno."-".$CmbMes."-31";
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
				$consulta.= " WHERE cod_clase = '3004' and cod_subclase='".intval($CmbMes)."'";		
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{  
					$LetraMes=$row["nombre_subclase"];
				}		
				$Consulta="SELECT t1.cod_bulto,t1.num_bulto,t1.cod_estado,t3.cod_cliente,t2.cod_paquete,t2.num_paquete,t1.corr_enm,t1.fecha_creacion_lote,t2.fecha_creacion_paquete,t2.peso_paquetes,t2.num_unidades 
				from lote_catodo t1 
				inner join paquete_catodo t2 on t1.num_paquete=t2.num_paquete and t1.cod_paquete=t2.cod_paquete 
				and t1.fecha_creacion_paquete=t2.fecha_creacion_paquete and t1.cod_estado=t2.cod_estado and t2.cod_producto='".$cmbproducto."' and t2.cod_subproducto='".$cmbsubproducto."'
				inner join embarque_ventana t3 on t1.corr_enm=t3.corr_enm and t1.cod_bulto=t3.cod_bulto and t1.num_bulto=t3.num_bulto and t3.cod_producto='".$cmbproducto."' and t3.cod_subproducto='".$cmbsubproducto."'
				where t1.fecha_creacion_lote BETWEEN '".$FechaInicio."' and '".$FechaFin."' "; 
				if($CmbEstado!='t')
					$Consulta.="and t1.cod_estado='".$CmbEstado."' ";
				$Consulta.=" and t1.cod_bulto='".$LetraMes."' ";
				//echo $Consulta;
				$Respuesta=mysqli_query($link, $Consulta);
				$Cont=0;$Cont2=0;
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					$Cont++;
					if($Cont=='1') 
						echo "<tr bgcolor='#FFFFFF'>"; 
					else
						echo "<tr bgcolor='#CCCCCC'>"; 
					echo "<td width='40' align='center'>".$Fila["corr_enm"]."</td>";
					$Consulta="select * from sec_web.nave where cod_nave ='".$Fila["cod_cliente"]."'";
					$Respuesta2=mysqli_query($link, $Consulta);
					if($Fila2=mysqli_fetch_array($Respuesta2))
					{
						$Cliente=$Fila2["nombre_nave"];
					}
					else
					{
						$Consulta="select * from sec_web.cliente_venta where cod_cliente ='".$Fila["cod_cliente"]."'";
						$Respuesta2=mysqli_query($link, $Consulta);
						if($Fila2=mysqli_fetch_array($Respuesta2))
						{
							$Cliente=$Fila2["sigla_cliente"];
						}
					}
					echo "<td width='99' align='center'>".$Cliente."&nbsp;</td>";					
					echo "<td width='60' align='center'>".$Fila["cod_bulto"]."</td>\n";
					echo "<td width='60' align='center'>".$Fila["num_bulto"]."</td>\n";
					echo "<td width='41' align='center'>".FechaDMA($Fila["fecha_creacion_lote"])."&nbsp;</td>";
					echo "<td width='60' align='center'>".$Fila["cod_paquete"]."</td>\n";
					echo "<td width='60' align='center'>".$Fila["num_paquete"]."</td>\n";
					echo "<td width='41' align='center'>".FechaDMA($Fila[fecha_creacion_paquete])."&nbsp;</td>";
					echo "<td width='44' align='center'>".$Fila["cod_estado"]."</td>";
					echo "<td width='44' align='right'>".$Fila["peso_paquetes"]."</td>";
					echo "<td width='41' align='right'>".$Fila["num_unidades"]."&nbsp;</td>";
					if($Fila["num_unidades"]>0)
						$Prom=$Fila["peso_paquetes"]/$Fila["num_unidades"];
					else
						$Prom=0;	
					echo "<td width='41' align='right'>".round($Prom,0)."&nbsp;</td>";
					$Cont2++;
					echo "</tr>";
					if($Cont=='2')
						$Cont=0;
				}
				echo "</table>Cant reg: ".$Cont2;	
			}
		?>
        <br> <table width="785" border="0" class="TablaInterior">
          <tr> 
            <td  align="center" width="270"><div align="left"></div></td>
            <td  align="center" width="502"><div align="left"> 
                <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:60px;" onClick="Imprimir();">
                <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              </div></td>
          </tr>
        </table>
</table>
  </form>
  </center>
</body>
</html>
<?php 
function FechaDMA($Fecha)
{
	$FecAux=explode('-',$Fecha);
	$FecDMA=$FecAux[2]."-".$FecAux[1]."-".$FecAux[0];
	return($FecDMA);
}
?>