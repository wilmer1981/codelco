<? 	
	$CodigoDeSistema = 12;
	$CodigoDePantalla = 2;
	include("../principal/conectar_pac_web.php");
	if($Proceso == "B" || $Proceso == "H")
	{
		$Consulta = "select * from raf_web.movimientos";
		if(strlen($Hornada) == 4)
			$Consulta.= " WHERE right(hornada,4) = $Hornada";
		else
			$Consulta.= " WHERE right(hornada,5) = $Hornada";
		$res = mysqli_query($link, $Consulta);		
		$Row = mysql_fetch_array($res);
		$Solera = $Row[solera];
		$cmbturno = $Row[turno];
		$estado = $Row[estado];
		
		$Consulta2 = "select sum(unidades) as unid,sum(peso) as peso from raf_web.movimientos";
		if(strlen($Hornada) == 4)
			$Consulta2.= " WHERE right(hornada,4) = $Hornada";
		else
			$Consulta2.= " WHERE right(hornada,5) = $Hornada";
		$res2 = mysql_query($Consulta2);
		$Row2 = mysql_fetch_array($res2);
		$UnidEst = $Row2[unid];
		$PesoEst = $Row2["peso"];

		if($Proceso == "B")
		{
			$Consulta = "select fecha from raf_web.det_carga";
			if(strlen($Hornada) == 4)
				$Consulta.= " WHERE right(hornada,4) = $Hornada";
			else
				$Consulta.= " WHERE right(hornada,5) = $Hornada";
			$resp = mysqli_query($link, $Consulta);
			$fila = mysql_fetch_array($resp);
			if($fila["fecha"] != '')
			{
				$Dia = substr($fila["fecha"],8,2);
				$Ano = substr($fila["fecha"],0,4);
				$Mes = substr($fila["fecha"],5,2);								
			}
		}
	}
	
	if($Proceso == "E")
	{
		if(strlen($Dia) == 1)
			$Dia = "0".$Dia;
		if(strlen($Mes) == 1)
			$Mes = "0".$Mes;
		$fecha_val = $Ano.'-'.$Mes;
		$consulta = "SELECT * FROM raf_web.cierre_mes";
		$consulta = $consulta." WHERE left(fecha,7) = '$fecha_val' AND estado = 'C'";
		$rs = mysql_query($consulta);
		if ($row  = mysql_fetch_array($rs))
		{
			$meses = array (1=>"Enero", 2=>"Febrero", 3=>"Marzo", 4=>"Abril", 5=>"Mayo", 6=>"Junio", 7=>"Julio", 8=>"Agosto", 9=>"Septiembre", 10=>"Octubre", 11=>"Noviembre", 12=>"Diciembre");
			$array_fecha = explode("-",$fecha_val);
					
			echo '<script language="JavaScript">';
			echo 'alert("El Mes de '.$meses[intval($array_fecha[1])].' Fue Cerrado,\n Ya No Se Puede Realizar Ningun Movimiento");';
			echo 'window.history.back()';
			echo '</script>';
			break;
		}	
		$Eliminar = "DELETE FROM raf_web.det_carga";
		if(strlen($Hornada) == 4)
			$Eliminar.= " WHERE right(hornada,4) = $Hornada";
		else
			$Eliminar.= " WHERE right(hornada,5) = $Hornada";
		mysql_query($Eliminar);
		$Proceso = 'H';
	}
?>
<html>
<head>
<script language="JavaScript">
function Cerrar_Hornada()
{
var f = FrmPrincipal;
	
	if(f.checkbox.checked == true)
	{ 
	   if(confirm("Finalizará La Hornada ¿Desea Continuar?"))
	   {
	   	 f.action="raf_ingreso_carga_parcial01.php?Proceso=C";
	   	 f.submit();
	   }	   
	   else
	   {
	     f.checkbox.checked = false 
	     return	
	   }	 
	}
	else
	{
	   if(confirm("Abrirá La Hornada ¿Desea Continuar?"))
	   {
	   	 f.action="raf_ingreso_carga_parcial01.php?Proceso=C";
	   	 f.submit();
	   }	   
	   else
	   {
	     f.checkbox.checked = true 
	     return	
	   }	 	
	
	}
}
function calcula(f,j,i,tipo,carga)
{
var f = FrmPrincipal;
var pos = j;
var posi = i;
var tope = i;
var peso_prom = 0;
var cont = 0;
var Acum_unid1 = 0;
var Acum_peso1 = 0;

peso_prom = f.elements[pos - 1].value/f.elements[pos - 2].value;
switch (tipo)
{
    case 1:
			f.elements[posi + 1].value = Math.round(f.elements[posi].value * peso_prom);

		if(f.elements[posi].value == '' && carga == 1)
		{
			f.elements[posi + 1].value = f.elements[posi - 1].value;
			f.elements[posi].value = f.elements[posi - 2].value;
		}

		if(f.elements[posi].value == '' && carga == 2)
		{
			f.elements[posi + 1].value = f.elements[posi - 3].value;
			f.elements[posi].value = f.elements[posi - 4].value;
		}
		if(f.elements[posi].value == '' && carga == 3)
		{
			f.elements[posi + 1].value = f.elements[posi - 5].value;
			f.elements[posi].value = f.elements[posi - 6].value;
		}
		if(f.elements[posi].value == '' && carga == 4)
		{
			f.elements[posi + 1].value = f.elements[posi - 7].value;
			f.elements[posi].value = f.elements[posi - 8].value;
		}
		break;

	case 2:
			f.elements[posi].value = Math.round(f.elements[posi + 1].value / peso_prom);

		if(f.elements[posi + 1].value == '' && carga == 1)
		{
			f.elements[posi].value = f.elements[posi - 2].value;
			f.elements[posi + 1].value = f.elements[posi - 1].value;
		}

		if(f.elements[posi + 1].value == '' && carga == 2)
		{
			f.elements[posi].value = f.elements[posi - 4].value;
			f.elements[posi + 1].value = f.elements[posi - 3].value;
		}

		if(f.elements[posi + 1].value == '' && carga == 3)
		{
			f.elements[posi].value = f.elements[posi - 6].value;
			f.elements[posi + 1].value = f.elements[posi - 5].value;
		}

		if(f.elements[posi + 1].value == '' && carga == 4)
		{
			f.elements[posi].value = f.elements[posi - 8].value;
			f.elements[posi + 1].value = f.elements[posi - 7].value;
		}
		break;
}

    f.elements[pos + 8].value = 0;
    f.elements[pos + 9].value = 0;
 	f.elements[pos + 8].value = f.elements[pos].value * 1 + f.elements[pos + 2].value * 1 + f.elements[pos + 4].value * 1 + f.elements[pos + 6].value * 1;
 	f.elements[pos + 9].value = f.elements[pos + 1].value * 1 + f.elements[pos + 3].value * 1 + f.elements[pos + 5].value * 1 + f.elements[pos + 7].value * 1;
	//saldos
 	f.elements[pos - 4].value = f.elements[pos - 2].value - f.elements[pos].value * 1 - f.elements[pos + 2].value * 1 - f.elements[pos + 4].value * 1 - f.elements[pos + 6].value * 1;
 	f.elements[pos - 3].value = f.elements[pos - 1].value - f.elements[pos + 1].value * 1 - f.elements[pos + 3].value * 1 - f.elements[pos + 5].value * 1 - f.elements[pos + 7].value * 1;

    if(parseInt(f.elements[pos + 9].value) > (parseInt(f.elements[pos - 1].value) + 1))
	{
 		f.elements[posi].value = "";
 		f.elements[posi + 1].value = "";							
		f.elements[pos - 4].value = f.elements[pos - 2].value - f.elements[pos].value * 1 - f.elements[pos + 2].value * 1 - f.elements[pos + 4].value * 1 - f.elements[pos + 6].value * 1;
		f.elements[pos - 3].value = f.elements[pos - 1].value - f.elements[pos + 1].value * 1 - f.elements[pos + 3].value * 1 - f.elements[pos + 5].value * 1 - f.elements[pos + 7].value * 1;									
		alert("A Sobrepasado La Existencia")
	}


/******************************/	

	//Carga 1  
	if(carga == 1)
	{
		tope = 19 + (parseInt(f.cont.value) * 19);
		cont = 19;
		while(cont < tope)
		{		
			Acum_unid1 = Acum_unid1 * 1 + f.elements[cont].value * 1;
			Acum_peso1 = Acum_peso1 * 1 + f.elements[cont + 1].value * 1;
			cont = cont + 19;
		}
		f.AcumUnid1.value = Acum_unid1;
		f.AcumPeso1.value = Acum_peso1;
	}

	//carga 2
	if(carga == 2)
	{
		tope = 19 + (parseInt(f.cont.value) * 19);
		cont = 19;
		while(cont < tope)
		{		
			Acum_unid1 = Acum_unid1 * 1 + f.elements[cont + 2].value * 1;
			Acum_peso1 = Acum_peso1 * 1 + f.elements[cont + 3].value * 1;
			cont = cont + 19;
		}
		f.AcumUnid2.value = Acum_unid1;
		f.AcumPeso2.value = Acum_peso1;
	}

	//carga 3
	if(carga == 3)
	{
		tope = 19 + (parseInt(f.cont.value) * 19);
		cont = 19;
		while(cont < tope)
		{		
			Acum_unid1 = Acum_unid1 * 1 + f.elements[cont + 4].value * 1;
			Acum_peso1 = Acum_peso1 * 1 + f.elements[cont + 5].value * 1;
			cont = cont + 19;
		}
		f.AcumUnid3.value = Acum_unid1;
		f.AcumPeso3.value = Acum_peso1;
	}

	//carga 4
	if(carga == 4)
	{
		tope = 19 + (parseInt(f.cont.value) * 19);
		cont = 19;
		while(cont < tope)
		{		
			Acum_unid1 = Acum_unid1 * 1 + f.elements[cont + 6].value * 1;
			Acum_peso1 = Acum_peso1 * 1 + f.elements[cont + 7].value * 1;
			cont = cont + 19;
		}
		f.AcumUnid4.value = Acum_unid1;
		f.AcumPeso4.value = Acum_peso1;
	}
//***************
//Total 
 f.AcumUnidT.value = f.AcumUnid1.value * 1 + f.AcumUnid2.value * 1 + f.AcumUnid3.value * 1 + f.AcumUnid4.value * 1;
 f.AcumPesoT.value = f.AcumPeso1.value * 1 + f.AcumPeso2.value * 1 + f.AcumPeso3.value * 1 + f.AcumPeso4.value * 1;

}


function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	var NumContrato="";
	var Resp="";
	var LargoForm = Frm.elements.length;

	switch (Proceso)
	{

		case "B":
			if(Frm.Hornada.value == '')
			{
				alert("Ingrese Hornada a Buscar");
				Frm.Hornada.focus()
				return
			}
			Frm.action = "raf_ingreso_carga_parcial.php?Proceso=B" ;
			Frm.submit();	
			break;

		case "H":
			if(Frm.Hornada.value == '')
			{
				alert("Ingrese Hornada a Buscar");
				Frm.Hornada.focus()
				return
			}
			Frm.action = "raf_ingreso_carga_parcial.php?Proceso=H" ;
			Frm.submit();	
			break;

		case "V":
			if(Frm.Hornada.value == '')
			{
				alert("Ingrese Hornada a Buscar");
				Frm.Hornada.focus()
				return
			}
			valores = "?Hornada="  + Frm.Hornada.value;
			window.open("raf_con_carga_beneficio.php"+valores,"","top=0,left=50,width=730,height=320,scrollbars=yes,resizable = no");		
			break;

		case "A":
			Valores = "?Hornada=" + Frm.Hornada.value;
			window.open("raf_ingreso_circulantes_raf.php"+Valores,"","top=0,left=180,width=340,height=210,scrollbars=no,resizable = no");
			break;

		case "G":


			if(Frm.Hornada.value == '')
			{
				alert("Debe Ingresar Nro De Hornada");
				Frm.Hornada.focus();	 
				return
		    }

			if(Frm.Solera.value == '')
			{
				alert("Debe Ingresar Nro De Solera");
				Frm.Solera.focus();	 
				return
		    }

			if(Frm.PesoEst.value == '')
			{
				alert("Debe Ingresar Peso Estimado");
				Frm.PesoEst.focus();	 
				return
		    }

			if(Frm.cont.value == 2006)
			{
				alert("No hay Datos Para Ingresar");
				return
			}
			Frm.action = "raf_ingreso_carga_parcial01.php?Proceso=G" ;
			Frm.submit();	
			break;

		case "I":
			window.print();
			break;

		case "M":

			if(Frm.Hornada.value == '')
			{
				alert("Debe Ingresar Nro De Hornada");
				Frm.Hornada.focus();	 
				return
		    }

			if(Frm.Solera.value == '')
			{
				alert("Debe Ingresar Nro De Solera");
				Frm.Solera.focus();	 
				return
		    }

			if(Frm.PesoEst.value == '')
			{
				alert("Debe Ingresar Peso Estimado");
				Frm.PesoEst.focus();	 
				return
		    }

			if(Frm.cont.value == 2006)
			{
				alert("No hay Datos Para Ingresar");
				return
			}
			Frm.action = "raf_ingreso_carga_parcial01.php?Proceso=M" ;
			Frm.submit();	
			break;

//			window.open("raf_control_mod.php?Proceso=M2","","top=0,left=180,width=405,height=210,scrollbars=no,resizable = no");		
//			break;

		case "E":

			window.open("raf_control_mod.php?Proceso=E2","","top=0,left=180,width=405,height=210,scrollbars=no,resizable = no");		
			break;

		case "C":

			window.open("raf_control_mod.php?Proceso=C","","top=0,left=180,width=405,height=210,scrollbars=no,resizable = no");		
			break;
/*			Frm.action="raf_ingreso_carga_parcial.php?Proceso=E";
			Frm.submit();
			break;	*/
	} 
}

function Salir()
{
	var Frm=document.FrmPrincipal;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=12";
	Frm.submit();
}
</script>
<title>Preparacion Carga Parcial</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmPrincipal" method="post" action="">
  <? include("../principal/encabezado.php")?>
  <table width="770" height="340" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td valign="top"> <table width='400' border='0' cellpadding='0' cellspacing='0' class="TablaInterior">
          <tr  class="ColorTabla01"> 
            <td width="50"><b>Encargado:</b></td>
            <td colspan="4">&nbsp; 
              <? $Consulta = "SELECT * FROM proyecto_modernizacion.funcionarios WHERE rut = '$CookieRut'";
			   $rs = mysqli_query($link, $Consulta);
			   $fil = mysql_fetch_array($rs);
			   echo $fil["nombres"].' '.$fil["apellido_paterno"].' '.$fil["apellido_materno"];				
			   echo '<input type="hidden" name="encargado" value="'.$CookieRut.'">';
			?>
             &nbsp;</td>
			<td width="33">
			<b>Hora :</b>
			</td>
			<td width="54">&nbsp;
			<?
				echo date("H:i");
			?>
			</td>
			  
          </tr>
        </table>
        <table width='760' border='0' cellpadding='0' cellspacing='0' class="TablaInterior">
          <tr> 
            <td width="71">Fecha Carga</td>
            <td colspan="3"> <select name="Dia" style="width:50px;">
                <?
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("j"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			  ?>
              </select> <select name="Mes" style="width:90px;">
                <?
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($Mes == $i)
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
				}
				?>
              </select> <select name="Ano" style="width:60px;">
                <?
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($Ano))
					{
						if ($Ano == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
				?>
              </select> </td>
            <td width="57">Hornada</td>
            <td> <input type="text" name="Hornada" size="10" value="<? echo $Hornada?>"> 
            </td>
            <td width="52"><input type="button" name="BtnBuscar2" value="Ok" style="width:30" onClick="MostrarPopupProceso('H');"> 
            </td>
            <td width="195"> &nbsp; &nbsp;Ver Beneficios&nbsp; <input name="BtnVer" type="button" id="BtnVer" style="width:30" onClick="MostrarPopupProceso('V');" value="Ver"></td>
            <td width="100">
			<?
			 if($estado == "A")
			 {	
			?>
			<input type="button" name="BtnCerrar" value="Cerrar Hornada" style="width:100" onClick="MostrarPopupProceso('C');">
			<?
			 }
			 if($estado == "C")
			 {
			?>
			<input type="button" name="BtnCerrar" value="Abrir Hornada" style="width:100" onClick="MostrarPopupProceso('C');">
			<?
			 }
			?>
			</td>
          </tr>
          <tr> 
            <td>Solera</td>
            <td width="82"><input name="Solera" size="10" value="<? echo $Solera?>"></td>
            <td width="66">Peso Total</td>
            <td width="67"><input name="PesoEst" size="10" value="<? echo $PesoEst?>"></td>
            <td>&nbsp;</td>
            <td width="67">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
          </tr>
        </table>
    <?
	if($Proceso == "B" || $Proceso == "H")
	{			
		$Consulta = "SELECT distinct turno FROM raf_web.movimientos";
		if(strlen($Hornada) == 4)
			$Consulta.= " WHERE right(hornada,4) = $Hornada";
		else
			$Consulta.= " WHERE right(hornada,5) = $Hornada";
		$Consulta.= " ORDER BY grupo";
		$Resp = mysqli_query($link, $Consulta);	

		$pos = 9;
		$i=0;
		$AcumUnid1 = '';
		$AcumPeso1 = '';
		$AcumUnid2 = '';
		$AcumPeso2 = '';
		$AcumUnid3 = '';
		$AcumPeso3 = '';
		$AcumUnid4 = '';
		$AcumPeso4 = '';
		$AcumUnidT = '';
		$AcumPesoT = '';
		while($Row = mysql_fetch_array($Resp))
		{			
			echo "<table width='740' border='1' cellpadding='0' cellspacing='0'>";
			echo "<tr class='ColorTabla01'>"; 			
			echo "<td width='13%' align='center' colspan='14'><b>Turno: ".$Row[turno]."</b></td>";
			echo "</tr>";
			echo "<tr class='ColorTabla01'>"; 			
			echo "<td width='15%' align='center' rowspan='2'>Producto</td>";
			echo "<td width='3%' align='center' rowspan='2'>Gr.</td>";
			echo "<td width='13%' align='center' colspan='2'>Carga Prog</td>";
			echo "<td width='13%' align='center' colspan='2'>Carga 1</td>";
			echo "<td width='13%' align='center' colspan='2'>Carga 2</td>";
			echo "<td width='13%' align='center' colspan='2'>Carga 3</td>";
			echo "<td width='13%' align='center' colspan='2'>Carga 4</td>";
			echo "<td width='13%' align='center' colspan='2'>Carga Total</td>";
			echo "</tr>";
			echo "<tr class='Detalle01'>";
			echo "<td width='6%'>unid</td>";
			echo "<td width='7%'>peso</td>";
			echo "<td width='6%'>unid</td>";
			echo "<td width='7%'>peso</td>";
			echo "<td width='6%'>unid</td>";
			echo "<td width='7%'>peso</td>";
			echo "<td width='6%'>unid</td>";
			echo "<td width='7%'>peso</td>";
			echo "<td width='6%'>unid</td>";
			echo "<td width='7%'>peso</td>";
			echo "<td width='6%'>unid</td>";
			echo "<td width='7%'>peso</td>";
			echo "</tr>";
			echo "</table>";

				echo "<table width='740' border='1' cellpadding='0' cellspacing='0' class='TablaInterior'>";
							
/*				if($Proceso == "H")
				{*/
					$Consulta = "select distinct cod_producto, cod_subproducto, grupo, hornada_sea from raf_web.movimientos";
					if(strlen($Hornada) == 4)
						$Consulta.= " WHERE right(hornada,4) = $Hornada";
					else
						$Consulta.= " WHERE right(hornada,5) = $Hornada";
					$Consulta.= " AND turno = '$Row[turno]'";
					$Consulta.= " ORDER BY cod_producto,cod_subproducto";

				$Resultado=mysqli_query($link, $Consulta);
				
				while ($Fila=mysql_fetch_array($Resultado))
				{
						$i++;
  					    $pos = $pos + 10;				

						//limpia variables
						$unid1= '';
						$peso1= '';
						$unid2= '';
						$peso2= '';
						$unid3= '';
						$peso3= '';
						$unid4= '';
						$peso4= '';
						echo "<tr>"; 
						echo'<input name="a['.$i.']" type="hidden" size="8">';
						
						$Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto"; 
						$Consulta.= " WHERE cod_producto = ".$Fila["cod_producto"];
						$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
						$rs = mysqli_query($link, $Consulta);
						$Fil = mysql_fetch_array($rs);
						 
						echo "<td width='15%' align='left'>".$Fil["abreviatura"]."</td>";				
						echo'<input name="cod_producto['.$i.']" type="hidden" size="2" value="'.$Fila["cod_producto"].'">';
						echo'<input name="cod_subproducto['.$i.']" type="hidden" size="2" value="'.$Fila[cod_subproducto].'">';

						if($Fila[hornada_sea] == '')
							$Fila[hornada_sea] = 0;
						echo'<input name="hornada_sea['.$i.']" type="hidden" size="20" value="'.$Fila[hornada_sea].'">';
	
						echo "<td width='4%' align='center'>".$Fila["grupo"]."&nbsp;</td>";
						echo '<input type="hidden" name="grupo['.$i.']" value="'.$Fila["grupo"].'" size="10">';
	
						//Suma los Cargados en Carga Parcial
						$Consulta = "select sum(unidades) as unidades, sum(peso) as peso from raf_web.det_carga";
						if(strlen($Hornada) == 4)
							$Consulta.= " WHERE right(hornada,4) = $Hornada";
						else
							$Consulta.= " WHERE right(hornada,5) = $Hornada";
						$Consulta.= " AND cod_producto = ".$Fila["cod_producto"];
						$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta.= " AND grupo = '$Fila["grupo"]'";
						$Consulta.= " AND hornada_sea = '$Fila[hornada_sea]'";
						$Rs = mysqli_query($link, $Consulta);						
						$fila = mysql_fetch_array($Rs);						

						if($Proceso == 'B' || $Proceso == 'H')
						{
							$TotalUnid = $fila["unidades"];
							$TotalPeso = $fila["peso"];
						}

						$Consulta = "select sum(unidades) as unidades, sum(peso) as peso from raf_web.movimientos";
						if(strlen($Hornada) == 4)
							$Consulta.= " WHERE right(hornada,4) = $Hornada";
						else
							$Consulta.= " WHERE right(hornada,5) = $Hornada";
						$Consulta.= " AND cod_producto = ".$Fila["cod_producto"];
						$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta.= " AND grupo = '$Fila["grupo"]'";
						$Consulta.= " AND hornada_sea = '$Fila[hornada_sea]'";
						$Res = mysqli_query($link, $Consulta);						
						$Fil2 = mysql_fetch_array($Res);
						
						//Maneja Saldo
						if($Proceso == "H" || $Proceso == 'B')
						{
							$Saldo_unid = $Fil2["unidades"] - $fila["unidades"];
							$Saldo_peso = $Fil2["peso"] - $fila["peso"];
							$Saldo_unid2 = $Fil2["unidades"];
							$Saldo_peso2 = $Fil2["peso"];
						}

						if($Proceso == "B")
						{
							$Saldo_unid2 = $Fil2["unidades"];
							$Saldo_peso2 = $Fil2["peso"];
						}

						echo "<td width='6%' align='right'>";
						echo'<input name="unid['.$i.']" type="text" size="6" value="'.$Saldo_unid.'" readonly>';
						echo"</td>";
	
						echo "<td width='6%' align='right'>";
						echo'<input name="pes['.$i.']" type="text" size="6" value="'.$Saldo_peso.'" readonly>';
						echo"</td>";
						echo'<input name="unid1['.$i.']" type="hidden" size="6" value="'.$Saldo_unid2.'">';
						echo'<input name="pes1['.$i.']" type="hidden" size="6" value="'.$Saldo_peso2.'">';
						
						if($Proceso == "B" || $Proceso == 'H')
						{
	
							//distribuye						
							//Carga 1
							$Consulta = "select sum(unidades) as unidades, sum(peso) as peso from raf_web.det_carga";
							if(strlen($Hornada) == 4)
								$Consulta.= " WHERE right(hornada,4) = $Hornada";
							else
								$Consulta.= " WHERE right(hornada,5) = $Hornada";
							$Consulta.= " AND cod_producto = ".$Fila["cod_producto"];
							$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
							$Consulta.= " AND grupo = '$Fila["grupo"]'";
							$Consulta.= " AND nro_carga = 1";
							$Consulta.= " AND hornada_sea = '$Fila[hornada_sea]'";
							$Rs = mysqli_query($link, $Consulta);						
							$fila = mysql_fetch_array($Rs);						
							$unid1 = $fila["unidades"];
							$peso1 = $fila["peso"];
							$AcumUnid1 = $AcumUnid1 + $fila["unidades"];
							$AcumPeso1 = $AcumPeso1 + $fila["peso"];
							$AcumUnidT = $AcumUnidT + $fila["unidades"];
							$AcumPesoT = $AcumPesoT + $fila["peso"];

							//Carga 2
							$Consulta = "select sum(unidades) as unidades, sum(peso) as peso from raf_web.det_carga";
							if(strlen($Hornada) == 4)
								$Consulta.= " WHERE right(hornada,4) = $Hornada";
							else
								$Consulta.= " WHERE right(hornada,5) = $Hornada";
							$Consulta.= " AND cod_producto = ".$Fila["cod_producto"];
							$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
							$Consulta.= " AND grupo = '$Fila["grupo"]'";
							$Consulta.= " AND nro_carga = 2";
							$Consulta.= " AND hornada_sea = '$Fila[hornada_sea]'";
							$Rs = mysqli_query($link, $Consulta);						
							$fila = mysql_fetch_array($Rs);						
							$unid2 = $fila["unidades"];
							$peso2 = $fila["peso"];
							$AcumUnid2 = $AcumUnid2 + $fila["unidades"];
							$AcumPeso2 = $AcumPeso2 + $fila["peso"];
							$AcumUnidT = $AcumUnidT + $fila["unidades"];
							$AcumPesoT = $AcumPesoT + $fila["peso"];

							//Carga 3
							$Consulta = "select sum(unidades) as unidades, sum(peso) as peso from raf_web.det_carga";
							if(strlen($Hornada) == 4)
								$Consulta.= " WHERE right(hornada,4) = $Hornada";
							else
								$Consulta.= " WHERE right(hornada,5) = $Hornada";
							$Consulta.= " AND cod_producto = ".$Fila["cod_producto"];
							$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
							$Consulta.= " AND grupo = '$Fila["grupo"]'";
							$Consulta.= " AND nro_carga = 3";
							$Consulta.= " AND hornada_sea = '$Fila[hornada_sea]'";
							$Rs = mysqli_query($link, $Consulta);						
							$fila = mysql_fetch_array($Rs);						
							$unid3 = $fila["unidades"];
							$peso3 = $fila["peso"];
							$AcumUnid3 = $AcumUnid3 + $fila["unidades"];
							$AcumPeso3 = $AcumPeso3 + $fila["peso"];
							$AcumUnidT = $AcumUnidT + $fila["unidades"];
							$AcumPesoT = $AcumPesoT + $fila["peso"];


							//Carga 4
							$Consulta = "select sum(unidades) as unidades, sum(peso) as peso from raf_web.det_carga";
							if(strlen($Hornada) == 4)
								$Consulta.= " WHERE right(hornada,4) = $Hornada";
							else
								$Consulta.= " WHERE right(hornada,5) = $Hornada";
							$Consulta.= " AND cod_producto = ".$Fila["cod_producto"];
							$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
							$Consulta.= " AND grupo = '$Fila["grupo"]'";
							$Consulta.= " AND nro_carga = 4";
							$Consulta.= " AND hornada_sea = '$Fila[hornada_sea]'";
							$Rs = mysqli_query($link, $Consulta);						
							$fila = mysql_fetch_array($Rs);						
							$unid4 = $fila["unidades"];
							$peso4 = $fila["peso"];
							$AcumUnid4 = $AcumUnid4 + $fila["unidades"];
							$AcumPeso4 = $AcumPeso4 + $fila["peso"];
							$AcumUnidT = $AcumUnidT + $fila["unidades"];
							$AcumPesoT = $AcumPesoT + $fila["peso"];

							
						}
						if($estado == "A")
						{
							echo "<td width='6%'><input type='text' maxlength='6' name='unid_1[".$i."]' size='6' value='$unid1' onBlur='calcula(this.form,".($pos).",".($pos).",1,1)'></td>";	
							echo "<td width='6%'><input type='text' maxlength='6' name='peso_1[".$i."]' size='6' value='$peso1' style='background:#FFFFCC' onBlur='calcula(this.form,".($pos).",".($pos).",2,1)'></td>";	
	
							echo "<td width='6%'><input type='text' maxlength='6' name='unid_2[".$i."]' size='6' value='$unid2' onBlur='calcula(this.form,".($pos).",".($pos + 2).",1,2)'></td>";	
							echo "<td width='6%'><input type='text' maxlength='6' name='peso_2[".$i."]' size='6' value='$peso2' style='background:#FFFFCC' onBlur='calcula(this.form,".($pos).",".($pos + 2).",2,2)'></td>";	
	
							echo "<td width='6%'><input type='text' maxlength='6' name='unid_3[".$i."]' size='6' value='$unid3' onBlur='calcula(this.form,".($pos).",".($pos + 4).",1,3)'></td>";	
							echo "<td width='6%'><input type='text' maxlength='6' name='peso_3[".$i."]' size='6' value='$peso3' style='background:#FFFFCC' onBlur='calcula(this.form,".($pos).",".($pos + 4).",2,3)'></td>";	
	
							echo "<td width='6%'><input type='text' maxlength='6' name='unid_4[".$i."]' size='6' value='$unid4' onBlur='calcula(this.form,".($pos).",".($pos + 6).",1,4)'></td>";	
							echo "<td width='6%'><input type='text' maxlength='6' name='peso_4[".$i."]' size='6' value='$peso4' style='background:#FFFFCC' onBlur='calcula(this.form,".($pos).",".($pos + 6).",2,4)'></td>";	
	
							echo "<td width='6%'><input type='text' maxlength='6' name='unid_t[".$i."]' value='$TotalUnid' size='6' readonly style='background:#00CCFF'></td>";	
							echo "<td width='6%'><input type='text' maxlength='6' name='peso_t[".$i."]' value='$TotalPeso' size='6' style='background:#00CCFF' readonly></td>";	
							echo "</tr>";
						}						
						if($estado == "C")
						{
							echo "<td width='6%'><input type='text' maxlength='6' name='unid_1[".$i."]' size='6' value='$unid1' readonly></td>";	
							echo "<td width='6%'><input type='text' maxlength='6' name='peso_1[".$i."]' size='6' value='$peso1' readonly style='background:#FFFFCC'></td>";	
	
							echo "<td width='6%'><input type='text' maxlength='6' name='unid_2[".$i."]' size='6' value='$unid2' readonly></td>";	
							echo "<td width='6%'><input type='text' maxlength='6' name='peso_2[".$i."]' size='6' value='$peso2' readonly style='background:#FFFFCC'></td>";	
	
							echo "<td width='6%'><input type='text' maxlength='6' name='unid_3[".$i."]' size='6' value='$unid3' readonly></td>";	
							echo "<td width='6%'><input type='text' maxlength='6' name='peso_3[".$i."]' size='6' value='$peso3' readonly style='background:#FFFFCC'></td>";	
	
							echo "<td width='6%'><input type='text' maxlength='6' name='unid_4[".$i."]' size='6' value='$unid4' readonly></td>";	
							echo "<td width='6%'><input type='text' maxlength='6' name='peso_4[".$i."]' size='6' value='$peso4' readonly style='background:#FFFFCC'></td>";	
	
							echo "<td width='6%'><input type='text' maxlength='6' name='unid_t[".$i."]' value='$TotalUnid' size='6' readonly style='background:#00CCFF'></td>";	
							echo "<td width='6%'><input type='text' maxlength='6' name='peso_t[".$i."]' value='$TotalPeso' size='6' style='background:#00CCFF' readonly></td>";	
							echo "</tr>";
						}						
						//Acummuladores 
						$AcumUnid = $AcumUnid + $Saldo_unid;
						$AcumPeso = $AcumPeso + $Saldo_peso;
						$pos = $pos + 9;					
				}
				
				echo "</table>";
			echo "<br>";
		  }	
				echo "<input type='hidden' name='cont' value=".$i.">";
	  }	
				
				
		?>
        <br>
        <table width="740" border='1' cellpadding='0' cellspacing='0' class="TablaInterior">
          <tr> 
            <td width="18%"><strong>Totales</strong></td> 
			<td width="6%" align="right"><? echo $AcumUnid?></td>
			<td width="6%" align="right"><? echo $AcumPeso?></td>
			<td width="6%" align="right"><input name="AcumUnid1" size="6" value="<? echo $AcumUnid1; ?>" readonly style='background:#66CCFF'></td>
			<td width="6%" align="right"><input name="AcumPeso1" size="6" value="<? echo $AcumPeso1; ?>" style='background:#66CCFF' readonly></td>
			<td width="6%" align="right"><input name="AcumUnid2" size="6" value="<? echo $AcumUnid2; ?>" style='background:#66CCFF' readonly></td>
			<td width="6%" align="right"><input name="AcumPeso2" size="6" value="<? echo $AcumPeso2; ?>" style='background:#66CCFF' readonly></td>
			<td width="6%" align="right"><input name="AcumUnid3" size="6" value="<? echo $AcumUnid3; ?>" style='background:#66CCFF' readonly></td>
			<td width="6%" align="right"><input name="AcumPeso3" size="6" value="<? echo $AcumPeso3; ?>" style='background:#66CCFF' readonly></td>
			<td width="6%" align="right"><input name="AcumUnid4" size="6" value="<? echo $AcumUnid4; ?>" style='background:#66CCFF' readonly></td>
			<td width="6%" align="right"><input name="AcumPeso4" size="6" value="<? echo $AcumPeso4; ?>" style='background:#66CCFF' readonly></td>
			<td width="6%" align="right"><input name="AcumUnidT" size="6" value="<? echo $AcumUnidT; ?>" style='background:#66CCFF' readonly></td>
			<td width="6%" align="right"><input name="AcumPesoT" size="6" value="<? echo $AcumPesoT; ?>" style='background:#66CCFF' readonly></td>
		  </tr> 	
        </table>

        <table width="750" border="0" class="tablainterior">
          <tr> 
              <td align="center"> 
 		      <input type="button" name="BtnCrer" value="Crear Carga" style="width:80" onClick="MostrarPopupProceso('G');">
			  <input type="button" name="BtnModif" value="Modif Carga" style="width:80" onClick="MostrarPopupProceso('M');">
              <input type="button" name="BtnEliminar" value="Eliminar" style="width:80" onClick="MostrarPopupProceso('E');">
              <input type="button" name="BtnImprimir" value="Imprimir" style="width:80px" onClick="MostrarPopupProceso('I');">
              <input type="button" name="BtnSalir" value="Salir" style="width:80" onClick="Salir();"></td>
          </tr>
        </table>
        <br>
      </td>
    </tr>
  </table>
  <? include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
