<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 19;
	//include("../principal/conectar_sec_web.php");
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	$DispEmb   = isset($_REQUEST["DispEmb"])?$_REQUEST["DispEmb"]:"N";
	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
	$Mensaje          = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";

	/*
	if (!isset($DispEmb))
	{
		$DispEmb='N';
	}
	*/
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
function Recarga()
{
	var Frm=document.FrmDispLotes;
	var DispEmb="";
	
	if (Frm.OpcDispEmb[0].checked)
	{
		DispEmb="N";
	}
	if (Frm.OpcDispEmb[1].checked)
	{
		DispEmb="S";
	}
	Frm.action="sec_disponibilidad_lotes.php?DispEmb="+DispEmb;
	Frm.submit();
	
}

function RecuperarValores()
{
	var Frm=document.FrmDispLotes;
	var Valores=new String();
	
	for (i=1;i<Frm.OptSeleccionar.length;i++)
	{
		if (Frm.OptSeleccionar[i].checked==true)
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

function Disponibilidad()
{
	var Frm=document.FrmDispLotes;
	var Valores="";

	Valores=RecuperarValores();
	if (Valores!='')
	{
		window.open("sec_disponibilidad_lotes_proceso.php?Valores="+Valores,"","top=195,left=180,width=450,height=190,scrollbars=no,resizable = no");
	}	
}
function Disponibilidad2()
{
	var Frm=document.FrmDispLotes;
	var Valores="";

	window.open("sec_disponibilidad_lotes_proceso2.php","","top=195,left=180,width=650,height=400,scrollbars=yes,resizable = no");
}

function Salir()
{
	var Frm=document.FrmDispLotes;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();
	
}
function Lote()
{
	var Proceso="";
	var Frm=document.FrmDispLotes;
	Frm.action="sec_disponibilidad_lotes_proceso01.php?Proceso=Lote";
	Frm.submit();
}
</script>
<title>Disponibilidad de Lotes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmDispLotes" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="350" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
  <tr>
      <td align="center"><br>
	  <div style="position:absolute; left: 15px; top: 55px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
	  <table width="730" border="0">
	  <tr>
	  
	  <?php
			switch ($DispEmb)
			{
				case "N":
					echo "<td>No Disponible Embarque<input type='radio' name='OpcDispEmb' value='' onclick='Recarga()' checked><td>";
					echo "<td>Disponible Embarque<input type='radio' name='OpcDispEmb' value='' onclick='Recarga()'></td>";
					break;
				case "S":
					echo "<td>No Disponible Embarque<input type='radio' name='OpcDispEmb' value='' onclick='Recarga()'></td>";		
					echo "<td>Disponible Embarque<input type='radio' name='OpcDispEmb' value='' onclick='Recarga()' checked></td>";	
			}
	  ?>
	  </tr>
	  </table></div><br>
	  <div style="position:absolute; left: 15px; top: 85px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
	  <table width="730" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01">
		    <td width='85' align="center">Prog.N&deg;</td>
			<td width='2' align="center">I.E</td>
			<td width='150' align="center">Nave/Cliente</td>
			<td width='90' align="center">Fecha Emb</td>
			<td width='60' align="center">Peso Prog.</td>
			<td width='90' align="center">Peso Prep.</td>
			<td width='70' align="center">Diferencia</td>
			<td width='70' align="center">N&deg; Lote</td>
			<td width="30" align="center">Est.</td>
          </tr>
        </table></div>
		<div style="position:absolute; left: 15px; top: 105px; width: 750px; height: 255px; OVERFLOW: auto;" id="div2">
		<?php
			echo "<table width='730' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			$CrearTmp ="CREATE TEMPORARY TABLE if not exists sec_web.tmpprograma "; 
			$CrearTmp =$CrearTmp."(corr_ie bigint(8),cliente_nave varchar(30),fecha date,fecha_programacion date,";
			$CrearTmp =$CrearTmp."cantidad_programada bigint(8),num_prog_loteo varchar(3),producto varchar(30),";
			$CrearTmp =$CrearTmp."subproducto varchar (30),pto_destino varchar (30),pto_emb varchar (30),";
			$CrearTmp =$CrearTmp."tipo char(1),cod_contrato varchar(10),estado char(1),estado2 char(1),fecha_disponible date)";
			mysqli_query($link, $CrearTmp);
			//CONSULTA TABLA PROGRAMA ENAMI
			$Consulta="SELECT t1.fecha_disponible,t1.estado2,t1.estado1,t6.descripcion as producto,t2.descripcion as subproducto,t3.nom_aero_puerto as pto_emb,t4.nom_aero_puerto as pto_destino,t5.sigla_cliente,";
			$Consulta=$Consulta."t1.eta_programada,t1.corr_enm,t1.cantidad_embarque,t1.num_prog_loteo";
			$Consulta=$Consulta." from sec_web.programa_enami t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta=$Consulta." left join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto ";
			$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto_destino=t4.cod_puerto ";
			$Consulta=$Consulta." left join sec_web.cliente_venta t5 on t1.cod_cliente=t5.cod_cliente ";
			$Consulta=$Consulta." where t1.estado2 <>'C' and ((t1.num_prog_loteo <>'')||(not isnull(t1.num_prog_loteo)))";
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar="INSERT INTO sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,num_prog_loteo ,producto,subproducto,pto_destino ,pto_emb,tipo,estado,estado2,fecha_disponible) values(";
				$Insertar=$Insertar."'".$Fila["corr_enm"]."','".$Fila["sigla_cliente"]."','".$Fila["cantidad_embarque"]."','".$Fila["num_prog_loteo"]."','".$Fila["producto"]."','".$Fila["subproducto"]."','".$Fila["pto_destino"]."','".$Fila["pto_emb"]."','E','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["fecha_disponible"]."')";
				mysqli_query($link, $Insertar);
			}
			//CONSULTA TABLA PROGRAMA CODELCO
			$Consulta="SELECT t1.fecha_disponible,t1.estado1,t1.estado2,(case when not isnull(t3.nombre_cliente) then t3.nombre_cliente else t4.nombre_nave end) as nombre_cliente,t1.corr_codelco,t6.descripcion as producto,t2.descripcion as subproducto,t1.cantidad_programada,t1.num_prog_loteo";
			$Consulta=$Consulta." from sec_web.programa_codelco  t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta=$Consulta." left join sec_web.cliente_venta t3 on t1.cod_cliente=t3.cod_cliente ";
			$Consulta=$Consulta." left join sec_web.nave t4 on ceiling(t1.cod_cliente)=t4.cod_nave ";
			$Consulta=$Consulta." where t1.estado2 <>'C' and ((t1.num_prog_loteo <>'')||(not isnull(t1.num_prog_loteo)))";
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar="INSERT INTO sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,num_prog_loteo ,producto,subproducto,tipo,estado,estado2,fecha_disponible) values(";
				$Insertar=$Insertar." '".$Fila["corr_codelco"]."','".$Fila["nombre_cliente"]."','".$Fila["cantidad_programada"]."','".$Fila["num_prog_loteo"]."','".$Fila["producto"]."','".$Fila["subproducto"]."','C','".$Fila["estado2"]."','".$Fila["estado1"]."','".$Fila["fecha_disponible"]."')";
				mysqli_query($link, $Insertar);   
			}
			$Consulta="SELECT * from sec_web.tmpprograma where estado2='R' and estado<>'P' order by fecha_disponible ";
			$Respuesta=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='OptSeleccionar'><input type='hidden' name='TxtDisp' >";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				//if ($Valor["estado"]=='A')
				if ($Fila["estado"]=='A')
				{
					echo "<tr class='colortabla04'>"; 
				}
				else
				{
					//if ($Valor["estado"]=='M')
					if ($Fila["estado"]=='M')
					{
						echo "<tr class='colortabla03'>";
					}	 							
					else
					{					
						echo "<tr>";
					}	 
				}
				switch ($DispEmb)
				{
					case "N":
						$Consulta="SELECT t1.disponibilidad,t3.descripcion as marca,t1.cod_bulto,t1.num_bulto,sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on ";
						$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
						$Consulta=$Consulta." left join sec_web.marca_catodos t3 on t1.cod_marca=t3.cod_marca ";
						$Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_ie"]." and (t1.disponibilidad='T' or t1.disponibilidad='PLE' or t1.disponibilidad='PLP') and t1.cod_estado='a' and t2.cod_estado='a' group by t1.corr_enm,t1.cod_bulto,t1.num_bulto";
						break;
					case "S":
						$Consulta="SELECT t1.disponibilidad,t3.descripcion as marca,t1.cod_bulto,t1.num_bulto,sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on ";
						$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
						$Consulta=$Consulta." left join sec_web.marca_catodos t3 on t1.cod_marca=t3.cod_marca ";
						$Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_ie"]." and substring(t1.disponibilidad,1,1)='E' and t1.cod_estado='a' and t2.cod_estado='a' group by t1.corr_enm,t1.cod_bulto,t1.num_bulto";
						break;
				}	
				$Respuesta2=mysqli_query($link, $Consulta);
				$MostrarBoton=true;
				$Cont2=0;
				while ($Fila2=mysqli_fetch_array($Respuesta2))
				{
					$Cont2++;
					echo "<td width='20' align='center'><input type='radio' name='OptSeleccionar' value='".$Fila2["cod_bulto"]."~~".$Fila2["num_bulto"]."~~".$Fila["corr_ie"]."~~".$Fila2["disponibilidad"]."'></td>";
					echo "<td width='85' align='center'>".$Fila["num_prog_loteo"]."</td>";
					echo "<td width='40'  onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");' bgcolor='#cccccc'>";
					echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:550px'>\n";
					echo "<font face='courier' color='#000000' size=1><b>Producto:&nbsp;</b>".$Fila["producto"]."&nbsp;<b>Sub-Producto:&nbsp;</b>".$Fila["subproducto"]." </font><br>";
					echo "<font face='courier' color='#000000' size=1><b>Puerto Embarque: </b>".$Fila["pto_emb"]."&nbsp;<b>Puerto Destino: </b>".$Fila["pto_destino"]."&nbsp;<b>Marca: </b>".$Fila2["marca"]."</font><br>";
					echo "</div>".$Fila["corr_ie"]."</td>";
					echo "<td width='205'>".$Fila["cliente_nave"]."&nbsp;</td>";
					echo "<td width='100' align='center'>".$Fila["fecha_disponible"]."</td>";
					echo "<td width='80' align='right'>".($Fila["cantidad_programada"]*1000)."</td>";
					echo "<td width='100' align='right'>".$Fila2["peso_preparado"]."&nbsp;</td>";
					echo "<td width='100' align='right'>".abs($Fila["cantidad_programada"]*1000-$Fila2["peso_preparado"])."&nbsp;</td>";
					echo "<td width='80' align='right'>".$Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."&nbsp;</td>";
					echo "<td width='40' align='center'>".$Fila2["disponibilidad"]."&nbsp;</td>";
				}
				echo "</tr>";
			}
			echo "</table>";	
		?>
		</div>
        <br>
		<div style="position:absolute; left: 15px; top: 370px; width: 750px; height: 41px; OVERFLOW: auto;" id="div2"> 
          <table width="730" border="0" class="tablainterior">
          <tr>
              <td align="center">
			    <input type="button" name="BtnGrabar" value="Disponibilidad" style="width:90" onClick="Disponibilidad();">
				<!--<input type="button" name="BtnGrabar" value="Consulta" style="width:90" onClick="Disponibilidad2();">-->
				<input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="Salir();">
               <!-- <input type="button" name="BtnSalir2" value="Proceso" style="width:60" onClick="Lote();">-->
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
	if ($EncontroRelacion!="")
	{
		if ($EncontroRelacion==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Uno o mas Elementos no fueron eliminados por tener grupos asociados');";	
			echo "</script>";
		}
	}
	if ($Mensaje!="")
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."');";	
		echo "</script>";
	}
?>
