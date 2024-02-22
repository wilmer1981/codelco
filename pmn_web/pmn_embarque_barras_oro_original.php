<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 124;
	include("../principal/conectar_pmn_web.php");
	if ($Op=="S")
	{
		$Dia = $D;
		$Mes = $M;
		$Ano = $Anito;
	}
	if ($Consulta == "S")
	{
		$Dia = $IdDia;
		$Mes = $IdMes;
		$Ano = $IdAno;
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
	//alert(numero);
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 355 ");
			//eval("Txt" + numero + ".style.top = document.checkTodos.top ");
			//eval("Txt" + numero + ".style.top = window.event.y ");
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
function Proceso(opt,boton)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "G": //GRABAR			
			f.action= "pmn_embarque_barras_oro01.php?Proceso=G";
	 		f.submit();
			break;
		case "G2": //GRABAR DETALLE			
			if (f.NumBarra.value == "")
			{
				alert("Debe Ingresar Num. Barra");
				f.NumBarra.focus();
				return;
			}			
			if (f.PesoBarra.value == "")
			{
				alert("Debe Ingresar Peso Barra");
				f.PesoBarra.focus();
				return;
			}
			if (f.NumActa.value == "")
			{
				alert("Debe Ingresar Num Acta");
				f.NumActa.focus();
				return;
			}
			f.action= "pmn_embarque_barras_oro01.php?Proceso=G2";
	 		f.submit();
			break;
		case "M2": //MODIFICAR DETALLE
			f.action= "pmn_embarque_barras_oro01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR TODO
			var mensaje = confirm("Seguro que desea Eliminar?");
			if (mensaje==true)
			{
				f.action= "pmn_carga_fusion_oro01.php?Proceso=E";
	 			f.submit();
			}
			else
			{
				return;
			}
			break;
		case "E2": //ELIMINAR
			var mensaje = confirm("Seguro que desea Eliminar?");
			if (mensaje==true)
			{
				f.action= "pmn_embarque_barras_oro01.php?Proceso=E2";
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "C": //CANCELAR
			f.action= "pmn_embarque_barras_oro01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //BUSCAR
			var URL = "pmn_embarque_barras_oro02.php";//?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=5,width=780,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=109";
	 		f.submit();
			break;
			case "Valores":
				var fila = 16; //Posicion Inicial de la Fila.
				var col = 3;
				var Barras="";
				var Fecha="";
				var Cont=0;
				pos = fila; 
				largo = f.elements.length;
				Fecha=f.Ano.value +'-'+f.Mes.value + '-'+f.Dia.value;
				for (i=pos; i<largo; i=i+col)
				{	
					if ((f.elements[i].type == 'checkbox')&&(f.elements[i].checked == true))
					{
						Barras=Barras + f.elements[i+1].value + "//";// + f.elements[i+2].value + "//";
						Cont++;
					}
				}
				if (Cont==0)
				{
					alert("Debe seleccionar un elemento");
				}
				else
				{
						if (Cont >3)
						{
							alert("Debe Seleccionar 3 elementos como maximo");
						}
						else
						{
							window.open("pmn_embarque_barras_oro03.php?Barras="+ Barras  + "&Fecha="+Fecha + "&Dia="+f.Dia.value +"&Ano="+f.Ano.value +"&Mes="+f.Mes.value,"","top=150,left=0,width=580,height=250,scrollbars=yes,resizable = yes");													
						}
					
				}				
			break;
			case "Excel":
				f.action= "pmn_xls_embarque_barras_oro.php?Dia="+f.Dia.value +"&Ano="+f.Ano.value +"&Mes="+f.Mes.value;
		 		f.submit();
			break;
	}
}
function Acta()
{
	var f=document.frmPrincipal;
	window.open("pmn_embarque_barras_oro04.php?Dia="+f.Dia.value +"&Ano="+f.Ano.value +"&Mes="+f.Mes.value+"&Acta="+f.NumActa.value,"","top=150,left=0,width=580,height=150,scrollbars=yes,resizable = yes");													
	/*f.action= "pmn_embarque_barras_oro04.php?Dia="+f.Dia.value +"&Ano="+f.Ano.value +"&Mes="+f.Mes.value+"&Acta="+f.NumActa.value;
	f.submit();*/
}
function TeclaPulsada (tecla) 
{ 
	var Frm=document.frmPrincipal;
	var teclaCodigo = event.keyCode; 
	//alert(teclaCodigo);
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 110 )&&(teclaCodigo != 190 ))
	{
		if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
}
var fila = 16; //Posicion Inicial de la Fila.
var col = 3;
function Activar(f)
{
	if (f.todos.checked == true)
		valor = true
	else valor = false;		

	pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = f.elements.length;
	for (i=pos; i<largo; i=i+col)
	{	
		if (f.elements[i].type != 'checkbox')
			return;
		else 
			f.elements[i].checked = valor;
	}	
}
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" border="0" class="TablaPrincipal">
    <tr>
    <td width="762"><table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="106" height="30">Fecha:</td>
            <td colspan="2"> 
              <?php 
				if ($Mostrar == "S")
				{
					echo "<input type='hidden' name='Dia' value='".$Dia."'>\n";
					echo "<input type='hidden' name='Mes' value='".$Mes."'>\n";
					echo "<input type='hidden' name='Ano' value='".$Ano."'>\n";
					printf("%'02d",$Dia);
					echo "-";
					printf("%'02d",$Mes);
					echo "-";
					printf("%'04d",$Ano);
				}
				else
				{
					echo "<select name='Dia' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($Dia))
						{
							if ($i == $Dia)
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
				  echo "</select> <select name='Mes' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($Mes))
						{
							if ($i == $Mes)
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
				  echo "</select> <select name='Ano' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($Ano))
						{
							if ($i == $Ano)
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
					echo "</select>\n";
				}
			?>
            </td>
            <td width="392"> <input name="ver" type="button" style="width:60" value="Consultar" onClick="Proceso('B');">
              </td>
          </tr>
        </table>
		  
        <br>
        <table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="206" height="24">
<div align="right">N&deg;. Barra:</div></td>
            <td width="91"> 
              <?php
				/*if ($Mostrar == "S")
				{
					echo $NumElectrolisis;
					echo "<input name='NumElectrolisis' type='hidden' value='".$NumElectrolisis."'>\n";
				}
				else
				{*/
              		echo "<input name='NumBarra'  style='width:60px;'  type='text' value='".$NumBarra."'>\n";
				//}
			  ?>
            </td>
            <td width="114">PesoNeto Barra: </td>
            <td width="61"><input name="PesoBarra" type="text" id="PesoBarra" onKeyDown="TeclaPulsada()"  value="<?php echo $PesoBarra;?>" size="10" maxlength="15"></td>
            <td width="63" align="center" valign="middle"> 
              <div align="left"> Num Acta</div></td>
            <td width="187" align="center" valign="middle"><div align="left">
             <?php
				$Consulta="select distinct num_acta from  pmn_web.embarque_oro  ";
				$Consulta.=" where fecha = '".$Ano."-".$Mes."-".$Dia."'	";			 
				//echo $Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);	
				$NumActa=$Fila[num_acta];
			 	//echo $NumActa;
			 ?>   
				<input name="NumActa" type="text" id="NumActa" onKeyDown="TeclaPulsada()"  value="<?php echo $NumActa;?>" size="10" maxlength="15">
              </div></td>
          </tr>
        </table>
        <br>
        <table width="761" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="726" colspan="7"><input name="BtnGrabar2" type="button" value="Grabar" style="width:60px;" onClick="Proceso('G2');"> 
              <input name="BtnModificar2" type="button" value="Modificar" style="width:60px;" onClick="Proceso('M2');"> 
              <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="Proceso('E2');">
              <input name="BtnCancelar" type="button" id="BtnCancelar" value="Cancelar" style="width:60px;" onClick="Proceso('C');">
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:60px;" onClick="Proceso('S');">
              <input name="BtnValores" type="button" id="BtnValores2" style="width:60px;" onClick="Proceso('Valores');" value="Valores">
              <input name="BtnActa" type="button" id="BtnValores" style="width:60px;" onClick="Acta('Acta');" value="Acta"> 
              <input name="BtnExcel" type="button" style="width:60px;" value="Excel" onClick="Proceso('Excel');">
            </td>
          </tr>
        </table>
        <br> 
        <table width="748" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="55" height="15"><input type="checkbox" name="todos" value="checkbox" onClick="Activar(this.form)"></td>
            <td width="120"><strong> N&deg; de Barra</strong></td>
            <td width="128"><strong>Peso Neto Barra</strong></td>
            <td width="63"><strong>Acta</strong></td>
            <td width="113"><div align="left"><strong>Peso Neto (Caja)</strong></div></td>
            <td width="91"><strong>Peso Bruto Caja</strong></td>
            <td width="109"><strong>Valor Declarado</strong></td>
            <td width="51"><strong>#Sello</strong></td>
          </tr>
        <?php	
		$Consulta = "select * from pmn_web.embarque_oro ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";	  
		$Consulta.= " order by num_barra,num_acta";
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		$TotalPeso = 0;
		$sw=0;
		$SelloAnt="";
		$ActaAnt="";
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";
			echo "<td align='center'><input type='checkbox' name='ChkBarra1[".$i."]' value='".$Row[num_barra]."'>\n";
			echo "<input type='hidden' name='ChkBarra[".$i."]' value='".$Row[num_barra]."'>\n";
			echo "<input type='hidden' name='ChkPeso[".$i."]' value='".$Row[peso_neto_barra]."'>\n";
			echo "</td>\n";
			echo "<td>".$Row[num_barra]."</td>\n";
			echo "<td align='center'>".$Row[peso_neto_barra]."&nbsp;</td>\n";
			echo "<td align='center'>".$Row[num_acta]."&nbsp;</td>\n";
			echo "<td align='center'>".$Row[peso_neto_caja]."&nbsp;</td>\n";
			echo "<td align='center'>".$Row[peso_bruto_caja]."&nbsp;</td>\n";
			echo "<td align='center'>".$Row[valor_declarado]."&nbsp;</td>\n";
			echo "<td align='center'>".$Row[num_sello]."&nbsp;</td>\n";
			$SumaNeto=$SumaNeto+$Row[peso_neto_caja];
			$SumaNeto2=$SumaNeto2+$Row[peso_neto_barra];
			echo "</tr>\n";
			$i++;
			$cont = $cont +  4;
			$SelloAnt = $Row[num_sello];
			$ActaAnt = $Row[num_acta];
		}
		?>
          <tr align="center"> 
            <td>&nbsp;</td>
            <td><strong>Total Neto:</strong></td>
            <td align="rigth"><?php
				echo "<strong>$SumaNeto2&nbsp;</strong>";
			?></td>
            <td align="rigth">&nbsp;</td>
            <td align="rigth"><?php
				echo "<strong>".($SumaNeto/2)."&nbsp;</strong>";
			?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
          </tr>
        </table>
        
      </td>
  </tr>
</table>

<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
