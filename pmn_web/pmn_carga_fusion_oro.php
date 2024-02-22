<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 14;
	include("../principal/conectar_pmn_web.php");
	if(!isset($AnoCForo))
		$AnoCForo=date('Y');
	if(!isset($MesCForo))
		$MesCForo=date('m');
	if(!isset($DiaCForo))
		$DiaCForo=date('d');
		
	if ($OpFOro=="S")
	{
		$DiaCForo = $DCForo;
		$MesCForo = $MCForo;
		$AnoCForo = $AnitoCForo;
	}
	if ($Op=="S")
	{
		$DiaCForo = $DCForo;
		$MesCForo = $MCForo;
		$AnoCForo = $AnitoCForo;
		$MostrarFOro = "S";
	}
	if ($ConsultaFOro == "S")
	{
		$MostrarFOro = "S";
		$DiaCForo = $IdDiaCForo;
		$MesCForo = $IdMesCForo;
		$AnoCForo = $IdAnoCForo;
	}
	if ($MostrarFOro == "S")
	{
		$Consulta = "select * from pmn_web.carga_fusion_oro ";
		$Consulta.= " where fecha = '".$AnoCForo."-".$MesCForo."-".$DiaCForo."'";
		$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
		//echo $Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$PesoProm = $Row[peso_prom];
		}
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
function muestraFOro(numero) 
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
function ocultaFOro(numero) 
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
function ProcesoFOro(opt,boton)
{
	var f = document.frmPrincipalRpt;
	switch (opt)
	{
		case "G": //GRABAR			
			f.action= "pmn_carga_fusion_oro01.php?Proceso=G";
	 		f.submit();
			break;
		case "G2": //GRABAR DETALLE			
			if (f.CmbTipoF.value !="6")
			{
				if (f.NumElectrolisis.value == "")
				{
					alert("Debe Ingresar Num. Electrolisis");
					f.NumElectrolisis.focus();
					return;
				}			
			}
			if (f.CmbTipoF.value !="4")
			{
				if (f.NumBarra.value == "")
				{
					alert("Debe Ingresar Num. Barra");
					f.NumBarra.focus();
					return;
				}
			}
			if (f.PesoBarra.value == "")
			{
				alert("Debe Ingresar Peso de la Barra");
				f.PesoBarra.focus();
				return;
			}					
			f.action= "pmn_carga_fusion_oro01.php?Proceso=G2";
	 		f.submit();
			break;
		case "M2": //MODIFICAR DETALLE
			if(SoloUnElemento(f.name,'ChkElectrolisis1','M'))
			{
				var Datos=Recuperar(f.name,'ChkElectrolisis1');
				f.action= "pmn_carga_fusion_oro01.php?Proceso=M&Datos="+Datos;
				f.submit();
			}
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
				if(SoloUnElemento(f.name,'ChkElectrolisis1','E'))
				{
					var Datos=Recuperar(f.name,'ChkElectrolisis1');
					f.action= "pmn_carga_fusion_oro01.php?Proceso=E2&Datos="+Datos;
					f.submit();
				}
			}
			else
			{
				return;
			}
			break;
		case "C": //CANCELAR
			f.action= "pmn_carga_fusion_oro01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //CANCELAR
			var URL = "pmn_carga_fusion_oro02.php?DiaIniCon=" + f.DiaCForo.value + "&MesIniCon=" + f.MesCForo.value + "&AnoIniCon=" + f.AnoCForo.value + "&DiaFinCon=" + f.DiaCForo.value + "&MesFinCon=" + f.MesCForo.value + "&AnoFinCon=" + f.AnoCForo.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=108";
	 		f.submit();
			break;
		case "Muestra":
			var fila = 19; //Posicion Inicial de la Fila.
			var col = 9;
			var Elect="";
			var Barra="";
			var Fecha="";
			var Cont=0;
			var Correlativo="";
			var Tipo="";
/*			pos = fila; 
			largo = f.elements.length;
			for (i=pos; i<largo; i=i+col)
			{	
				alert(f.elements[i].type)
					alert(f.elements[i].name)
				if ((f.elements[i].type == 'checkbox')&&(f.elements[i].checked == true))
				{
					Elect=f.elements[i+1].value;
					Barra=f.elements[i+2].value;
					Muestra=f.elements[i+4].value;
					Sobrante=f.elements[i+5].value;
					Correlativo=f.elements[i+7].value;
					Tipo=f.elements[i+6].value;
					Cont++;
				}
			}
			//alert(Correlativo);*/
			
			if(SoloUnElemento(f.name,'ChkElectrolisis1','M'))
			{
				var Datos=Recuperar(f.name,'ChkElectrolisis1');
				Datos=Datos.split('~');
				Elect=Datos[0];
				Barra=Datos[1];
				Muestra=Datos[3];
				Sobrante=Datos[4];
				Correlativo=Datos[6];
				Tipo=Datos[5];
				
				Fecha=f.AnoCForo.value +'-'+f.MesCForo.value + '-'+f.DiaCForo.value;
				
				//alert(boton)
				//alert(Tipo)
				if (boton=='M')//pulso boton muestra
				{
					if(Tipo!="6"&&Tipo!="1")
					{
						alert('No corresponde a tipo barra para muestra')
						return;
					}	
					if (Tipo=="6")
					{
						window.open("pmn_carga_fusion_oro07.php?Elect="+ Elect + "&Tipo="+Tipo +"&Corr="+Correlativo + "&Barra="+Barra + "&Fecha="+Fecha + "&Muestra="+Muestra,"","top=150,left=0,width=500,height=200,scrollbars=no,resizable = yes");						
					}
					else
					{
						if(Tipo!="1")
						{
							alert('No corresponde a tipo barra para sobrante')
							return;
						}	
						if (Tipo=="1")
						{
							window.open("pmn_carga_fusion_oro03.php?Elect="+ Elect + "&Tipo="+Tipo +"&Corr="+Correlativo + "&Barra="+Barra + "&Fecha="+Fecha + "&Muestra="+Muestra,"","top=150,left=210,width=490,height=180,scrollbars=no,resizable = yes");												
						}
					}
				}
				else//pulso boton Sobrante
				{
					if(Tipo!="1")
					{
						alert('No corresponde a tipo barra para sobrante')
						return;
					}	
					if (Tipo=="1")
					{
						window.open("pmn_carga_fusion_oro04.php?Elect="+ Elect + "&Corr="+Correlativo +"&Barra="+Barra + "&Fecha="+Fecha + "&Muestra="+Muestra+"&Sobrante="+Sobrante,"","top=150,left=210,width=490,height=180,scrollbars=no,resizable = yes");													
					}
				}
			}
			break;
			case "Embalaje":
				var fila = 19; //Posicion Inicial de la Fila.
				var col = 9;
				var Elect="";
				var Barra="";
				var Fecha="";
				var Cont=0;
				pos = fila; 
				largo = f.elements.length;
				Fecha=f.AnoCForo.value +'-'+f.MesCForo.value + '-'+f.DiaCForo.value;
				for (i=pos; i<largo; i=i+col)
				{	
					if ((f.elements[i].type == 'checkbox')&&(f.elements[i].checked == true))
					{
						Elect=Elect + f.elements[i+1].value + "~~" + f.elements[i+7].value + "//";
						Cont++;
					}
				}
				if (Cont==0)
				{
					alert("Debe seleccionar un elemento");
				}
				else
				{
					if (boton=="EM")
					{
						if (Cont >2)
						{
							alert("Debe Seleccionar 2 elementos como maximo");
						}
						else
						{
							window.open("pmn_carga_fusion_oro05.php?ElectBarras="+ Elect  + "&Fecha="+Fecha,"","top=150,left=0,width=490,height=180,scrollbars=no,resizable = yes");													
						}
					}
					else
					{
						window.open("pmn_carga_fusion_oro06.php?ElectBarras="+ Elect + "&Barra="+Barra + "&Fecha="+Fecha,"","top=150,left=0,width=450,height=200,scrollbars=no,resizable = yes");													
					}
				}				
			break;
	}
}
function TeclaPulsadaFOro (tecla) 
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
var fila = 19; //Posicion Inicial de la Fila.
var col = 9;

function TeclaPulsada1FOro(salto) 
{ 
	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 
		
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}


function ActivarFOro(f)
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
function RecargaFOro()
{
	var Frm=document.frmPrincipalRpt;
	if (Frm.CmbTipoF.value == "4")
	{
		//Frm.action="pmn_carga_fusion_oro.php?Opcion=S";
		Frm.action="pmn_principal_reportes.php?Tab7=true&Opcion=S";
		Frm.submit();
	}
	else
	{
		if (Frm.CmbTipoF.value == "6")
		{
			//Frm.action="pmn_carga_fusion_oro.php?Sobrante=S";
			Frm.action="pmn_principal_reportes.php?Tab7=true&Sobrante=S";
			Frm.submit();
		}
		else
		{
			//Frm.action="pmn_carga_fusion_oro.php";
			Frm.action="pmn_principal_reportes.php?Tab7=true";
			Frm.submit();
		}
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
</script> 
</head>
	<?php
		if ($Sobrante != S)
		{
			echo '<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" >';
	
		}
		else
		{
			echo '<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" >';
		}
	?>	
<form name="frmPrincipalFOro" method="post" action="">
  <table width="100%" height="330" border="0" class="TituloCabeceraOz">
    <tr>
    <td align="center" valign="top"><table width="760" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="106" height="30" class="titulo_azul">Fecha:</td>
            <td colspan="2"> 
              <?php 
				if ($MostrarFOro == "S")
				{
					echo "<input type='hidden' name='DiaCForo' value='".$DiaCForo."'>\n";
					echo "<input type='hidden' name='MesCForo' value='".$MesCForo."'>\n";
					echo "<input type='hidden' name='AnoCForo' value='".$AnoCForo."'>\n";
					printf("%'02d",$DiaCForo);
					echo "-";
					printf("%'02d",$MesCForo);
					echo "-";
					printf("%'04d",$AnoCForo);
				}
				else
				{
					echo "<select name='DiaCForo' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaCForo))
						{
							if ($i == $DiaCForo)
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
				  	echo "</select> <select name='MesCForo' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesCForo))
						{
							if ($i == $MesCForo)
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
					
				  	echo "</select> <select name='AnoCForo' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($AnoCForo))
						{
							if ($i == $AnoCForo)
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
				//echo "mes:       ".$MesCForo."<br>";
			?>
            </td>
            <td width="391"> <input name="ver" type="button" style="width:60" value="Consultar" onClick="ProcesoFOro('B');">
              <input name="BtnEliminar22" type="hidden" value="Eliminar" style="width:60px;" onClick="ProcesoFOro('E2');"> 
            </td>
          </tr>
        </table>
		<br>
        <table width="759" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="750" colspan="7"><input type="hidden" style="width:20" name="Correlativo" value="<?php echo $Correlativo;  ?>">
              <input name="BtnGrabar2" type="button" value="Grabar" style="width:60px;" onClick="ProcesoFOro('G2');"> 
              <input name="BtnModificar2" type="button" value="Modificar" style="width:60px;" onClick="ProcesoFOro('M2');"> 
              <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="ProcesoFOro('E2');">
            <input name="BtnCancelar" type="button" id="BtnCancelar2" value="Cancelar" style="width:60px;" onClick="ProcesoFOro('C');"></td>
          </tr>
        </table>
        <br>
        <table width="759" cellpadding="3" cellspacing="0" class="TablaInterior" border="0">
          <tr> 
            <td width="80" height="26" class="titulo_azul">Tipo</td>
            <td width="100"> <select name="CmbTipoF" onChange="RecargaFOro();">
                <?php
			$Consulta="select * from proyecto_modernizacion.sub_clase";
			$Consulta.=" where cod_clase ='6006'  and valor_subclase2='S' order by cod_subclase";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta)) 
			{
				if ($CmbTipoF==$Fila["cod_subclase"])
				{
					echo "<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
				}
				else
				{
					echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
				}
			}
			?>
              </select></td>
              <?php
				if ($Sobrante== "S")
				{
					echo "<input name='NumElectrolisis' type='hidden' value=''>\n";
				}
				else
				{
				?>

              		<td width='79' class="titulo_azul">#Electrolisis:</td>
            		<td width='74'><input name="NumElectrolisis" type="text" id="NumElectrolisis" onKeyDown="TeclaPulsada1FOro('NumBarra')"  value="<?php echo $NumElectrolisis;?>" size='10' maxlength='15'></td>
					<?php
					//echo "<input name='NumElectrolisis' style='width:60px;' type='text' value='".$NumElectrolisis."'>\n";echo"</td>";
					?>
				<?php	
				}
				if ($OpcionFOro !="S")
				{
				?>
					<td width='180' class="titulo_azul">#Barra: 
		    <input name="NumBarra" type="text" id="NumBarra" onKeyDown="TeclaPulsada1FOro('PesoBarra')"  value="<?php echo $NumBarra;?>" size='10' maxlength='15'></td>
				
				<?php
				}
				else
				{
					echo "<input type='hidden' name='NumBarra'  value ''>";
				}
				?>
            <td width="60" class="titulo_azul">Peso: </td>
            <td width="110" align="left" valign="middle"> <input name="PesoBarra" type="text" onKeyDown="SoloNumeros(true,this)" value="<?php echo str_replace(".",",",$PesoBarra);?>" size="10" maxlength="15">
              &nbsp;&nbsp;&nbsp;</td>
            <td width="251" align="left" valign="middle"> 
               
					<input name="BtnMuestra" type="button" id="BtnMuestra" style="width:60px;" onClick="ProcesoFOro('Muestra','M');" value="Muestra"> 
				<?php
					//echo 'Mta:<input name="Muestra" type="text" size="10" maxlength="15" value="">';
				?>
              <input name="BtnSob" type="button" id="BtnSob" style="width:60px;" onClick="ProcesoFOro('Muestra','S');" value="Sobrante">
			</td>
          </tr>
        </table>
        <!-- <input name="BtnEmbalaje" type="button" id="BtnEmbalaje" style="width:60px;" onClick="Proceso('Embalaje','EM');" value="Embalaje">
                <input name="BtnActa" type="button" id="BtnActa"  style="width:60px;" value="Acta" onClick="Proceso('Embalaje','AC');">-->
		<br> 
        <table width="759" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="TituloCabeceraAzul"> 
            <td width="57" height="15"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'ChkElectrolisis1','ChkTodos');"></td>
            <td width="131"><strong>#Electrolisis</strong></td>
            <td width="124"><strong>#Barra</strong></td>
            <td width="133"><strong>Peso</strong></td>
            <td width="86"><strong>Muestra</strong></td>
            <td width="109"><strong>Sobrante</strong></td>
            <td width="102"><strong>Tipo</strong></td>
            <!--<td width="100"><strong>#Sello</strong></td>
			<td width="100"><strong>#Acta</strong></td>-->
          </tr>
          <?php	
		$Consulta = "select * from pmn_web.carga_fusion_oro ";
		$Consulta.= " where fecha = '".$AnoCForo."-".$MesCForo."-".$DiaCForo."'";	  
		$Consulta.= " order by fecha,correlativo";
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		$TotalPeso = 0;
		$cont = 19;
		$Cont2=1;
		$Datos='';
		//echo $Consulta."<br>";
		echo "<input type='hidden' name='ChkElectrolisis1'>";
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";
			//mouse over
			$Datos=$Row[num_electrolisis]."~".$Row[num_barra]."~".$Row["peso"]."~".$Row[muestra]."~".$Row[sobrante]."~".$Row[tipo]."~".$Row[correlativo];
			echo "<td align='center'><input type='checkbox' name='ChkElectrolisis1' value='".$Datos."'class='SinBorde'>\n";echo "</td>\n";
			echo "<td>".$Row[num_electrolisis]."&nbsp;</td>\n";
			echo "<td align='center'>".$Row[num_barra]."&nbsp;</td>\n";
			echo "<td align='center'>".number_format($Row["peso"],4,',','.')."</td>\n";
			if ($Row[muestra] =='S')
			{
				echo "<td align='center'>".$Row[mtra]."</td>\n";
			}
			else
			{
				echo "<td align='center'>&nbsp;</td>\n";
			}
			if ($Row[sobrante] =='S')
			{
				echo "<td align='center'>".number_format($Row[peso_sobrante],4,',','.')."</td>\n";
			}
			else
			{
				echo "<td align='center'>&nbsp;</td>\n";
			}
			$Consulta="select * from proyecto_modernizacion.sub_clase";
			$Consulta.=" where cod_clase ='6006' and cod_subclase='".$Row[tipo]."'   ";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			echo "<td align='center'>".$Fila["nombre_subclase"]."</td>\n";
			echo "</tr>\n";
			$TotalPeso = $TotalPeso + $Row["peso"];
			$i++;
			$cont = $cont +  9;
		}
		?>
          <tr align="center"> 
            <td height="15" colspan="2" align="center" class="TituloCabeceraAzul"><strong class="TituloCabeceraAzul">TOTAL PESO&nbsp;<?php echo  $TotalPeso;?></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <!--<td>&nbsp;</td>
			 <td>&nbsp;</td>-->
          </tr>
        </table>      </td>
  </tr>
</table>

</form>
</body>
</html>
