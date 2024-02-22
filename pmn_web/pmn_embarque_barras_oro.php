<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 124;
	include("../principal/conectar_pmn_web.php");
	if ($MostrarBarraOro=="S")
	{
		$DiaBarraOro = $DiaBarraOro;
		$MesBarraOro = $MesBarraOro;
		$AnoBarraOro = $AnoBarraOro;
	}
	if ($ConsultaBarraOro == "S")
	{
		$DiaBarraOro = $IdDiaBarraOro;
		$MesBarraOro = $IdMesBarraOro;
		$AnoBarraOro = $IdAnoBarraOro;
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestraBarraOro(numero) 
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
function ocultaBarraOro(numero) 
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
function ProcesoBarraOro(opt,boton)
{
	var f = document.frmPrincipalRpt;
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
			if(SoloUnElemento(f.name,'CheckTipo','M'))
			{
				Datos=Recuperar(f.name,'CheckTipo');
				f.action= "pmn_embarque_barras_oro01.php?Proceso=M&Datos="+Datos;
				f.submit();
			}
			break;
		case "E": //ELIMINAR TODO
			if(SoloUnElemento(f.name,'CheckTipo','E'))
			{
				var mensaje = confirm("Seguro que desea Eliminar?");
				if (mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckTipo');
					//f.action= "pmn_carga_fusion_oro01.php?Proceso=E&Datos="+Datos;
					//f.submit();
					f.action= "pmn_embarque_barras_oro01.php?Proceso=E2&Datos="+Datos;
					f.submit();
				}
				else
				{
					return;
				}
			}
			break;
		case "E2": //ELIMINAR
			var mensaje = confirm("Seguro que desea Eliminar los datos seleccionados?");
			if (mensaje==true)
			{
				/*f.action= "pmn_embarque_barras_oro01.php?Proceso=E2";
				f.submit();*/
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
				
						    f.action= "pmn_embarque_barras_oro01.php?Proceso=E2"+"&ChkBarra1=" + Barras;
							f.submit();
							
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
			if(SoloUnElemento(f.name,'CheckTipo','E'))
			{
				Datos=Recuperar(f.name,'CheckTipo');
				var Cont=Cuenta(f.name,'CheckTipo');
				//alert(Cont)
				if (Cont >3)
				{
					alert("Debe Seleccionar 3 elementos como maximo");
				}
				else
				{
					window.open("pmn_embarque_barras_oro03.php?Datos="+ Datos  + "&Fecha="+Fecha + "&Dia="+f.DiaBarraOro.value +"&Ano="+f.AnoBarraOro.value +"&Mes="+f.MesBarraOro.value,"","top=150,left=0,width=580,height=250,scrollbars=yes,resizable = yes");													
				}
			}	
		break;
		case "Excel":
				f.action= "pmn_xls_embarque_barras_oro.php?DiaBarraOro="+f.DiaBarraOro.value +"&AnoBarraOro="+f.AnoBarraOro.value +"&MesBarraOro="+f.MesBarraOro.value;
		 		f.submit();
		break;
	}
}
function ActaBarraOro()
{
	var f=document.frmPrincipalRpt;
	window.open("pmn_embarque_barras_oro04.php?Dia="+f.DiaBarraOro.value +"&Ano="+f.AnoBarraOro.value +"&Mes="+f.MesBarraOro.value+"&Acta="+f.NumActa.value,"","top=150,left=0,width=580,height=150,scrollbars=yes,resizable = yes");													
	/*f.action= "pmn_embarque_barras_oro04.php?Dia="+f.Dia.value +"&Ano="+f.Ano.value +"&Mes="+f.Mes.value+"&Acta="+f.NumActa.value;
	f.submit();*/
}
function TeclaPulsadaBarraOro (tecla) 
{ 
	var Frm=document.frmPrincipalRpt;
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

function TeclaPulsada1BarraOro(salto) 
{ 
	var f = document.frmPrincipalRpt
	;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}




function ActivarBarraOro(f)
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
function CheckearTodo(f,nomchk,nomchkT)
{
	var Check=new Object();
	var CheckT=new Object();
	
	try
	{
		eval("document."+f.name+"."+nomchk+"[0]");
		Check=eval("document."+f.name+"."+nomchk);
		CheckT=eval("document."+f.name+"."+nomchkT);
		for (i=1;i<Check.length;i++)
		{
			if (CheckT.checked==true){
				if(Check[i].disabled==false)
					Check[i].checked=true;
			}
			else{
				if(Check[i].disabled==false)
					Check[i].checked=false;
			}
		}
	}
	catch (e)
	{
	}
}
function SoloUnElemento(f,inputchk,Opc)
{
	var CantCheck=0;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
			CantCheck++;
	}
	if (Opc=='M')
	{
		if (CantCheck > 1 ||CantCheck==0)
		{
			if(CantCheck==0)
				alert("Debe Seleccionar un Elemento");
			else
				alert("Debe Seleccionar solo un Elemento");
			return(false);
		}
		else
			return(true);
	}
	else
	{
		if(CantCheck==0)
			alert("Debe Seleccionar un Elemento");
		else
			return(true);			
	}
}
function Recuperar(f,inputchk,niv,rutc)
{
		
	var Valores="";
	var Encontro=false;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
		{
			if(niv=='4')
			{
				if(eval("document."+f+".elements["+i+2+"].value")==rutc)
				{
					Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
					Encontro=true;
//				alert(eval("document."+f+".elements["+i+2+"].value"));
				}
				else
				{
					alert("Ud No tiene Acceso a Modificar el Requerimiento");
					Valores="";
				}
			}
			else
			{
				Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
				Encontro=true;
				
			}
			
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
function Cuenta(f,inputchk,niv,rutc)
{
	var Cont=0;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
		{
			Cont=Cont+1;
		}
	}
	return(Cont);
}
</script>
</head>
															  
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipalBarraOro" method="post" action="">
  <table width="100%" height="330" border="0" class="TituloCabeceraOz">
    <tr>
    <td align="center" valign="top"><table width="761" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="106" height="30" class="titulo_azul">Fecha:</td>
            <td colspan="2"> 
              <?php 
				if ($Mostrar == "S")
				{
					echo "<input type='hidden' name='DiaBarraOro' value='".$DiaBarraOro."'>\n";
					echo "<input type='hidden' name='MesBarraOro' value='".$MesBarraOro."'>\n";
					echo "<input type='hidden' name='AnoBarraOro' value='".$AnoBarraOro."'>\n";
					printf("%'02d",$DiaBarraOro);
					echo "-";
					printf("%'02d",$MesBarraOro);
					echo "-";
					printf("%'04d",$AnoBarraOro);
				}
				else
				{
					echo "<select name='DiaBarraOro' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaBarraOro))
						{
							if ($i == $DiaBarraOro)
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
				  echo "</select> <select name='MesBarraOro' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesBarraOro))
						{
							if ($i == $MesBarraOro)
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
				  echo "</select> <select name='AnoBarraOro' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($AnoBarraOro))
						{
							if ($i == $AnoBarraOro)
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
			?>            </td>
            <td width="392"> <input name="ver" type="button" style="width:60" value="Consultar" onClick="ProcesoBarraOro('B');">
            </td>
          </tr>
        </table>
		  
        <br>
        <table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="206" height="24">
			<div align="right" class="titulo_azul">N&deg;. Barra:</div></td>
            <td width="91"><input name="NumBarra" type="text" id="NumBarra" onKeyDown="TeclaPulsada1BarraOro('PesoBarra')"  value="<?php echo $NumBarra;?>" size="10" maxlength="15"></td> 
			<?php
            //poly lo modifique por lo de arriba echo "<input name='NumBarra'  style='width:60px;'  type='text' value='".$NumBarra."'>\n";
			?>	
			<td width="114" class="titulo_azul">PesoNeto Barra: </td>
            <td width="61"><input name="PesoBarra" type="text" id="PesoBarra" onKeyDown="SoloNumeros(true,this)"  value="<?php echo number_format($PesoBarra,4,',','.');?>" size="10" maxlength="15"></td>
            <td width="63" align="center" valign="middle"> 
              <div align="left" class="titulo_azul"> Num Acta</div></td>
            <td width="187" align="center" valign="middle"><div align="left"> 
                <?php
				$Consulta="select distinct num_acta from  pmn_web.embarque_oro  ";
				$Consulta.=" where fecha = '".$AnoBarraOro."-".$MesBarraOro."-".$DiaBarraOro."'	";			 
				//echo $Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);	
				$NumActa=$Fila[num_acta];
			 //aqui 	echo $NumActa;
			 
			 ?>
                <input name="NumActa" type="text" id="NumActa" onKeyDown="TeclaPulsada1BarraOro('BtnGrabar2')"  value="<?php echo $NumActa;?>" size="10" maxlength="15">
              </div></td>
          </tr>
        </table>
        <br>
        <table width="761" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="726" colspan="7"><input name="BtnGrabar2" type="button" value="Grabar" style="width:60px;" onClick="ProcesoBarraOro('G2');"> 
              <input name="BtnModificar2" type="button" value="Modificar" style="width:60px;" onClick="ProcesoBarraOro('M2');"> 
              <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="ProcesoBarraOro('E');">
              <input name="BtnCancelar" type="button" id="BtnCancelar" value="Cancelar" style="width:60px;" onClick="ProcesoBarraOro('C');">
              <input name="BtnValores" type="button" id="BtnValores2" style="width:60px;" onClick="ProcesoBarraOro('Valores');" value="Valores">
              <input name="BtnActa" type="button" id="BtnValores" style="width:60px;" onClick="ActaBarraOro('Acta');" value="Acta"> 
              <input name="BtnExcel" type="button" style="width:60px;" value="Excel" onClick="ProcesoBarraOro('Excel');">
            </td>
          </tr>
        </table>
        <br> 
        <table width="748" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="TituloCabeceraAzul"> 
            <td width="55" height="15"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckTipo','ChkTodos');"></td>
            <td width="120"><strong> N&deg; de Barra</strong></td>
            <td width="128"><strong>Peso Neto Barra</strong></td>
            <td width="63"><strong>Acta</strong></td>
            <td width="113"><div align="left"><strong>Peso Neto (Caja)</strong></div></td>
            <td width="91"><strong>Peso Bruto Caja</strong></td>
            <td width="109"><strong>Valor Declarado</strong></td>
            <td width="51"><strong>#Sello</strong></td>
          </tr>
        <?php	
		$Consulta = "select num_sello,num_acta,count(*) as cant from pmn_web.embarque_oro ";
		$Consulta.= " where fecha = '".$AnoBarraOro."-".$MesBarraOro."-".$DiaBarraOro."'";	  
		$Consulta.= " group by num_sello,num_acta order by num_barra,num_acta";
		$Respuesta = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		$i=1;
		$TotalPeso = 0;
		$sw=0;
		$SelloAnt="";
		$ActaAnt="";
		echo "<input name='CheckTipo' type='hidden' value=''>";
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			$Entro = true;
			$Consulta = "select * from pmn_web.embarque_oro ";
			$Consulta.= " where fecha = '".$AnoBarraOro."-".$MesBarraOro."-".$DiaBarraOro."' ";
			if (is_null($Row[num_sello]))
				$Consulta.= " and isnull(num_sello) ";
			else
				$Consulta.= " and num_sello = '".$Row[num_sello]."' ";
			$Consulta.= " and num_acta = '".$Row[num_acta]."'";
			//echo $Consulta;	  
			$Respuesta2 = mysqli_query($link, $Consulta);
			while ($Row2 = mysqli_fetch_array($Respuesta2))
			{			
				$Clave=$Row2[num_barra]."~".$Row2[peso_neto_barra];	
				echo "<tr>\n";
				echo "<td align='center'><input type='checkbox' name='CheckTipo' class='SinBorde' value='".$Clave."'>";
				echo "</td>\n";
				echo "<td>".$Row2[num_barra]."</td>\n";
				echo "<td align='center'>".number_format($Row2[peso_neto_barra],4,',','.')."&nbsp;</td>\n";
				if (is_null($Row[num_sello]))
				{
				    //echo entro;
					echo "<td align='center' rowspan='1'>".$Row2[num_acta]."&nbsp;</td>\n";
					echo "<td align='center' rowspan='1'>".$Row2[peso_neto_caja]."&nbsp;</td>\n";
					echo "<td align='center' rowspan='1'>".number_format($Row2[peso_bruto_caja],3,',','.')."&nbsp;</td>\n";
					echo "<td align='center' rowspan='1'>".number_format($Row2[valor_declarado],2,',','.')."&nbsp;</td>\n";
					echo "<td align='center' rowspan='1'>".$Row2[num_sello]."&nbsp;</td>\n";
					echo "</tr>";
					$SumaNeto=$SumaNeto+$Row2[peso_neto_caja];
					
				}
				else
				{				
					if ($Entro==true)
					{
					    //echo entro2;
						echo "<td align='center' rowspan='".$Row["cant"]."'>".$Row2[num_acta]."&nbsp;</td>\n";
						echo "<td align='center' rowspan='".$Row["cant"]."'>".number_format($Row2[peso_neto_caja],4,',','.')."&nbsp;</td>\n";
						echo "<td align='center' rowspan='".$Row["cant"]."'>".number_format($Row2[peso_bruto_caja],3,',','.')."&nbsp;</td>\n";
						echo "<td align='center' rowspan='".$Row["cant"]."'>".number_format($Row2[valor_declarado],4,',','.')."&nbsp;</td>\n";
						echo "<td align='center' rowspan='".$Row["cant"]."'>".$Row2[num_sello]."&nbsp;</td>\n";
						$Entro = false;
						$SumaNeto=$SumaNeto+$Row2[peso_neto_caja];
						
					}
				}	
				$SumaNeto2=$SumaNeto2+$Row2[peso_neto_barra];
				echo "</tr>";
			}	
			
			$i++;
			$cont = $cont +  4;
			$SelloAnt = $Row[num_sello];
			$ActaAnt = $Row[num_acta];
		}
		?>
          <tr align="center"> 
            <td>&nbsp;</td>
            <td class="TituloCabeceraAzul"><strong class="TituloCabeceraAzul">Total Neto:</strong></td>
            <td align="rigth"><?php
				echo "<strong>$SumaNeto2&nbsp;</strong>";
			?></td>
            <td align="rigth">&nbsp;</td>
            <td align="rigth"><?php
				echo "<strong>".$SumaNeto."&nbsp;</strong>";
			?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
          </tr>
        </table>      </td>
  </tr>
</table>

</form>
</body>
</html>
