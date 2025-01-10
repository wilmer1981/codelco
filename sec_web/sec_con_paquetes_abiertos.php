<?php 	
 	$CodigoDeSistema = 3;
	$CodigoDePantalla =28;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
		
	$Orden = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";

	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
?>
<html>
<head>
<script language="JavaScript">

function Salir()
{
	var Frm=document.FrmProceso;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
	Frm.submit();
}
function Consultar()
{
	var Frm=document.FrmProceso;
	var Orden="";
	Frm.action="sec_con_paquetes_abiertos.php?Orden="+Orden+"&Mostrar=S";
	Frm.submit();
}
function Excel()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_con_paquetes_abiertos_xls.php?CmbAno="+Frm.CmbAno.value+"&Mostrar=S";
	Frm.submit();
}

function Imprimir()
{
	var Frm=document.FrmProceso;
	window.print();
}
</script>
<title>Proceso</title>
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
              <td colspan="2"  align="center"><strong>Consulta de Paquetes Abiertos</strong></td>
            </tr>
            <tr> 
              <td  align="center" width="591">A&ntilde;o
                <SELECT name='CmbAno'>
                <?php
			for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAno))
				{
					if ($i==$CmbAno)
						{
							echo "<option SELECTed value ='$i'>$i</option>";
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
							echo "<option SELECTed value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}		
			}?>
              </SELECT>
              (Busqueda de Paquetes Abiertos Menores al Filtro de A&ntilde;o)</td>
              <td width="396"  align="center"> <div align="left"> 
                  <input name="BtnConsultar" type="button" id="BtnConsultar5" value="Consultar" style="width:60px;" onClick="Consultar('');">
                  <input name="BtnImprimir22" type="button" id="BtnImprimir22" value="Imprimir" style="width:60px;" onClick="Imprimir();">
                  <input name="BtnExcel" type="button" id="BtnImprimir5" value="Excel" style="width:60px;" onClick="Excel();">
                  <input type="button" name="BtnSalir2" value="Salir" style="width:60" onClick="Salir();">
              </div></td>
            </tr>
          </table>
		<br>
        <table width="1000" height="20" border="1" cellpadding="3" cellspacing="0">
          <tr class="ColorTabla01"> 
          <td width="46" align="left">I.E.</td>
          <td width="39" align="left">Num.Lote</td>
          <td width="80">Fecha Creaci&oacute;n </td>
          <td width="100">Marca Lote</td>
          <td width="90" align="left">Sub Producto</td>
          <td width="59">Num.Paquete</td>
		  <td width="59">Peso</td>
		  <td width="59">Unidades</td>
          </tr>
       <!-- </table>-->
        <?php
			$Cont=0;
			if ($Mostrar=='S')
			{
				
				$Consulta="  SELECT t1.fecha_creacion_lote,t1.cod_bulto,t1.num_bulto,t2.cod_paquete,t2.num_paquete,t1.corr_enm,t2.cod_producto,t1.cod_marca, ";
				$Consulta.=" t2.cod_subproducto,t2.peso_paquetes,t2.num_unidades  from sec_web.lote_catodo t1 ";
				$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
				$Consulta.=" and t1.num_paquete=t2.num_paquete ";
				$Consulta.=" where  ";
				$Consulta.=" LEFT(fecha_creacion_lote,4) <'".$CmbAno."'";
				$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  and t1.cod_estado=t2.cod_estado and t1.cod_estado='a'and t2.cod_estado='a' ";
             	$Respuesta=mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				$Cont=0;
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					
					$Cont++;
				//	echo $IEAnt.' vs '.$Fila["corr_enm"]."<br>";
					
					if($Cont=='1') 
						echo "<tr bgcolor='#FFFFFF'>"; 
					else
						echo "<tr bgcolor='#CCCCCC'>";
					echo "<td width='40' align='center'>".$Fila["corr_enm"]."</td>";
					echo "<td width='50' align='center'>".$Fila["cod_bulto"]."-".$Fila["num_bulto"]."</td>";
					echo "<td width='70' align='center'>".$Fila["fecha_creacion_lote"]."</td>";
					/* CONSULTA DE MARCA DE CATODOS*/
					$Consulta="SELECT distinct t1.cod_marca,t2.descripcion from sec_web.lote_catodo t1 ";   
					$Consulta.="inner join sec_web.marca_catodos t2 on t1.cod_marca=t2.cod_marca ";
					$Consulta.=" where corr_enm='".$Fila["corr_enm"]."' and cod_bulto='".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."'	";
					$Respuesta4=mysqli_query($link, $Consulta);
					$Fila4=mysqli_fetch_array($Respuesta4);
					$descripcion = isset($Fila4["descripcion"])?$Fila4["descripcion"]:"";
					echo "<td width='100' align='center'>".$descripcion."&nbsp;</td>";
					/* CONSULTA DE SUBPRODUCTO DE CATODOS*/
					$Consulta="SELECT abreviatura from proyecto_modernizacion.subproducto where cod_producto='".$Fila["cod_producto"]."' ";
					$Consulta.=" and cod_subproducto='".$Fila["cod_subproducto"]."'	";
					$Respuesta6=mysqli_query($link, $Consulta);
					$Fila6=mysqli_fetch_array($Respuesta6);
					echo "<td width='90' align='left'>".$Fila6["abreviatura"]."&nbsp;</td>";
					echo "<td width='70' align='center'>".$Fila["cod_paquete"].'-'.$Fila["num_paquete"];"</td>";
					echo "<td width='55' align='center'>".$Fila["peso_paquetes"]."&nbsp;</td>";
					echo "<td width='59' align='center'>".$Fila["num_unidades"]."&nbsp;</td>";
					echo "</tr>";
					$IEAnt=$Fila["corr_enm"];
					if($Cont=='2')
						$Cont=0;
				}
				echo "</table>";	
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
   <!--   </td>
  </tr>-->
</table>
  </form>
  </center>
</body>
</html>
