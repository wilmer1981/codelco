<?php 	
 	$CodigoDeSistema = 3;
	$CodigoDePantalla =66;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	$Encontro=false;
	if($TxtGuia <> "")
	{
		$Consulta = "select * from sec_web.guia_despacho_emb where num_guia= '".$TxtGuia."' order by fecha_guia desc ";
		//echo $Consulta;
		$Respuesta =mysqli_query($link, $Consulta);
		if($Fila =mysqli_fetch_array($Respuesta))
		{
			$Lote=$Fila["cod_bulto"]." ".$Fila["num_bulto"];
			$IE=$Fila["corr_enm"];
			$TxtFechaFin=$Fila["fecha_guia"];
			$Encontro=true;
		}
	}
?>
<html>
<head>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="JavaScript">
function Salir()
{
	var Frm=document.FrmProceso;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=65";
	Frm.submit();
}
function Buscar()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_cierre_paquetes.php?Buscar=S&TxtGuia="+Frm.TxtGuia.value;
	Frm.submit();
}
function CerrarPaquetes()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_cierre_paquetes01.php?Cierre=S";
	Frm.submit();
}
function Funcionarios()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_cierre_paquetes01.php?Func=S";
	Frm.submit();
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
</style>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmProceso" method="post" action="">
 



  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="776" align="center" valign="top"
	><table width="490" border="0" class="TablaInterior">
          <tr> 
            <td width="12"><font size="2">&nbsp; </font></td>
            <td width="68"><font size="2">Fecha Guia </font></td>
            <td width="149"><font size="1"><font size="2"> </font></font><font size="2">
              <input name="TxtFechaFin" type="text" class="InputCen" value="<?php echo $TxtFechaFin; ?>" size="13" maxlength="10" readonly >
              <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"> </font></td>
            <td width="56">N&deg; Guia </td>
            <td width="180"><font size="2">
              <input name="TxtGuia" type="text" id="TxtGuia" value="<?php echo $TxtGuia; ?>" size="13" maxlength="10">
              <input name="btnBuscar" type="button" id="btnBuscar" value="Buscar" onClick="Buscar();">
</font> </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Lote</td>
            <td><?php echo $Lote ;?>&nbsp;</td>
            <td>IE</td>
            <td><?php echo $IE ;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		<br>
          <table width="752" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="17"> <input type="hidden" name="CheckTodos" value="checkbox"> 
            </td>
            <td width="92"><div align="center">CodPaquete</div></td>
            <td width="80" align="center"><div align="center">#Paquete</div></td>
            <td width="319" align="left"><div align="left">Producto/SubProducto</div></td>
            <td width="89"><div align="center">Unidades Serie</div></td>
            <td width="60"><div align="center"></div>
              <div align="center">Peso Serie</div></td>
            <td width="50">Estado</td>
          </tr>
        
       <?php
	   if($Encontro == true)
	   {
			//echo "<table width='752' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
			$MostrarBtn='N';
			$Consulta = "select  distinct cod_paquete,num_paquete,t2.cod_bulto,t2.num_bulto,t2.corr_enm ";
			$Consulta.=" from sec_web.det_guia_despacho_emb t1";
			$Consulta.=" inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia and t1.fecha_guia=t2.fecha_guia";
			$Consulta.=" where t2.num_guia='".$TxtGuia."' and t2.fecha_guia = '".$TxtFechaFin."'";
			$Consulta.=" order by cod_paquete,num_paquete ";
			$Respuesta = mysqli_query($link, $Consulta);
			//echo $Consulta;
            $cont = 0;
			echo "<input name ='checkbox' type='hidden' ><input name ='MesPaqueteI' type='hidden' ><input name ='NumPaqueteI' type='hidden' ><input name ='MesPaqueteF' type='hidden' ><input name ='NumPaqueteF' type='hidden' >";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				echo "<td width='5'>&nbsp;</td>";
				echo "<td width='30'>".$Fila["cod_paquete"]."</td>";
				echo "<td width='79'>".$Fila["num_paquete"]."&nbsp;</td>";
				$Consulta="select num_unidades,peso_paquetes,t2.cod_estado,t2.cod_producto,t2.cod_subproducto from sec_web.lote_catodo t1 ";
				$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
				$Consulta.=" and t1.num_paquete=t2.num_paquete and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
				$Consulta.=" where cod_bulto='".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."' and corr_enm='".$Fila["corr_enm"]."' 	";
				$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  	";
				$Consulta.=" and t1.cod_paquete='".$Fila["cod_paquete"]."' and t2.num_paquete='".$Fila["num_paquete"]."'";
				$Resp1=mysqli_query($link, $Consulta);
				if($Fila4=mysqli_fetch_array($Resp1))
				{
					$Unidades=$Fila4["num_unidades"];
					$PesoU=$Fila4["peso_paquetes"];
                    $TotalUnidades = $TotalUnidades + $Fila4["num_unidades"];
                    $TotalPeso   = $TotalPeso     + $Fila4["peso_paquetes"];
				}	
				else
				{
					$Unidades="Error";
					$PesoU=$Fila4["peso_paquetes"];
				}
				$Consulta=" select * from proyecto_modernizacion.subproducto where ";
				$Consulta.=" cod_producto='".$Fila4["cod_producto"]."' and cod_subproducto='".$Fila4["cod_subproducto"]."'";
				$RespPro=mysqli_query($link, $Consulta);
				if($FilaPro = mysqli_fetch_array($RespPro))
					$SubPro=$FilaPro["descripcion"];
				else	
					$SubPro="";
					
				echo "<td width='300'>".$SubPro."</td>";
				echo "<td width='89'>".$Unidades."&nbsp;</td>";
				echo "<td width='79'>".$PesoU."&nbsp;</td>";
				if($Fila4["cod_estado"]=='a')
					$Estado="A";
				else
					$Estado="C";	
				echo "<td width='79' align='center'><strong>".$Estado."&nbsp;</strong></td>";
				if($Fila4["cod_estado"]=='a')
					$MostrarBtn='S';
                     $cont++;
				echo "</tr>";

			}
   




		}
  
  			echo "<tr class='Detalle01'>";
     
             echo "<td>&nbsp;</td>";
			echo "<td width='92' align='center'><strong>Total Gu�a </strong></td>";


      echo "<td align='left'><strong>".$cont."</strong</td>";
			echo "<td>&nbsp;</td>";
			echo "<td align='left'><strong>".$TotalUnidades."</strong></td> ";
			echo "<td align='left'><strong>".$TotalPeso."</strong></td> ";
            echo "<td>&nbsp;</td>";
			echo "</tr>";

  
  
  
       /*   echo "<tr>";
         echo "<td>Total</td>";
    echo "<td width='300'>".$TotalUnidades."</td>";
    echo "</tr>";   */

		//echo "</table>";
        // aqui poly agrego totales 17-04-2008
  
		?>
        <br>
		</table>
        <table width="751" border="0" class="TablaInterior">
          <tr> 
            <td  align="center"><div align="left"></div>               
              <div align="center">
			    <?php
				if($MostrarBtn=='S')
				{
				?>
				<input name="BtnCerrar" type="submit" id="BtnCerrar" style="width:60" value="Cerrar" onClick="CerrarPaquetes();">
			    <?php  
				}
				 ?>
				<input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
            <!--    <input name="BtnFuncionario" type="button" id="BtnFuncionario" value="Funcionarios" onClick="Funcionarios();">-->
              </div></td>
          </tr>
      </table>      </td>
  </tr>
</table>
 <?php include("../principal/pie_pagina.php");
 
  		echo "<script languaje='JavaScript'>";
		echo "var frm=document.FrmProceso;";
		if($TxtGuia <> "")
		{
			if ($Encontro==false)
			{
				echo "alert('Esta Guia No Ha sido ingresada al Sistema');";
			}
		}
		echo "</script>"
  ?>
</form>
</body>
</html>
