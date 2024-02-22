<?php
include("../principal/conectar_pmn_web.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;
$CodigoDeSistema = 6;
$CodigoDePantalla = 125;
if ($ConsultaEmPlata == "S")
{
	$CmbDias = $IdDiaEmPlata;
	$CmbMes = $IdMesEmPlata;
	$CmbAno = $IdAnoEmPlata;
}
?>
<html>
<head>
<title>Sistema de Plamen</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(Opcion,Bloquear)
{
	var frm= document.FrmEmbarquePlata;
	switch(Opcion)
	{
		case "G"://presiono boton Ok para ingresar  
		Validar();
		break;
		case "M": //MODIFICAR
			if(SoloUnElemento(frm.name,'CheckTipo','M'))
			{
				Datos=Recuperar(frm.name,'CheckTipo');
				//alert(Datos)
				frm.action= "pmn_embarque_plata01.php?Opcion=M&Datos="+Datos;
				frm.submit();
			}
			break;
		case "E2": 
			if(SoloUnElemento(frm.name,'CheckTipo','E'))
			{
				var mensaje = confirm("¿Seguro que desea Eliminar este Registro?");
				if (mensaje==true)
				{
					Datos=Recuperar(frm.name,'CheckTipo');
					frm.action="pmn_embarque_plata01.php?CmbDias="+frm.CmbDias.value +"&CmbAno="+frm.CmbAno.value +"&CmbMes="+frm.CmbMes.value + "&Bloquear="+Bloquear +"&Opcion=E&Datos="+Datos; 
					frm.submit(); 
				}
				else
				{
					return;
				}
			}
		break;
		case "Ver": //Consultar 
			var URL = "pmn_embarque_plata02.php";//?DiaIniCon=" + frm.CmDias.value + "&MesIniCon=" + frm.CmbMes.value + "&AnoIniCon=" + frm.CmbAno.value;// + "&DiaFinCon=" + frm.CmbDias.value + "&MesFinCon=" + frm.CmbMes.value + "&AnoFinCon=" + frm.CmbAno.value;
			window.open(URL,"","top=120,left=30,width=770,height=400,menubar=no,resizable=yes,scrollbars=yes,status=yes");
		break;
		case "E": //MODIFICAR
			frm.action= "pmn_xls_embarque_plata.php?Mostrar=C&CmbDias="+frm.CmbDias.value +"&CmbAno="+frm.CmbAno.value +"&CmbMes="+frm.CmbMes.value;
	 		frm.submit();
			break;
	}
}
//**************
function Cancelar()
{
	var frm=document.FrmEmbarquePlata;
	frm.action="pmn_embarque_plata01.php?Opcion=C"; 
	frm.submit(); 
			
}
//*************
function Validar()
{
	var frm =document.FrmEmbarquePlata;
	CmbDias=frm.CmbDias.value;
	CmbMes=frm.CmbMes.value;
	CmbAno=frm.CmbAno.value;  
	if (frm.Cantidad.value=="")
	{
		alert("Debe ingresar Cantidad");
		frm.Cantidad.focus();
		return;
	}
	if (frm.Peso.value=="")
	{
		alert("Debe ingresar Peso");
		frm.Peso.focus();
		return;
	}
	if (frm.Dolar.value=="")
	{
		alert("Debe Valor Dolar");
		frm.Dolar.focus();
		return;
	}
	if (frm.Acta.value=="")
	{
		alert("Debe ingresar Acta");
		frm.Acta.focus();
		return;
	}
	frm.action="pmn_embarque_plata01.php?CmbAno="+CmbAno + "&CmbDias="+CmbDias + "&CmbMes="+CmbMes +"&Opcion=G"; 
	frm.submit(); 
}
function Ver(Mostrar)
{
	var frm =document.FrmEmbarquePlata;
	var Fecha="";
	Fecha=frm.CmbAno.value +"-"+ frm.CmbMes.value +"-" + frm.CmbDias.value;
	frm.action="pmn_produccion_granalla_horno_cristales_plata.php?Fecha="+Fecha +"&Mostrar=V"; 
	frm.submit(); 
}
var fila = 18; //Posicion Inicial de la Fila.
var col = 9;
function Activar()
{
	var f = document.FrmEmbarquePlata;	
	if (f.todos.checked == true)
		valor = true
	else valor = false;		

	pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	//alert(pos)
	largo = f.elements.length;
	//alert(largo)
	for (i=pos; i<largo; i=i)
	{	
		//alert(i);
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
function Salir()
{
	var frm =document.FrmEmbarquePlata;
	frm.action="../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=109";
	frm.submit(); 
}
function TeclaPulsada (tecla) 
{ 
	var frm=document.FrmEmbarquePlata;
	var teclaCodigo = event.keyCode;
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

function TeclaPulsada1(salto) 
{ 

	var f = document.FrmEmbarquePlata;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}


function Detalle()
{
	var f = document.FrmEmbarquePlata;	
	var largo = f.elements.length;
	//alert(largo)
	var NumActa = "";
	if(SoloUnElemento(f.name,'CheckTipo','E'))
	{
		NumActa=Recuperar(f.name,'CheckTipo');
		window.open("pmn_embarque_plata_det.php?DiaEmb=" + f.CmbDias.value + "&MesEmb=" + f.CmbMes.value + "&AnoEmb=" + f.CmbAno.value + "&Acta=" + NumActa,"","top=100,left=30,width=470,height=400,menubar=no,resizable=yes,scrollbars=yes");
	}	
/*	if (NumActa == "")
	{
		alert("No hay ningun Acta seleccionada");		
		return;
	}*/
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body >

<form name="FrmEmbarquePlata" method="post" action="">
<table width="98%" height="330" border="0" cellpadding="5" cellspacing="0" class="TituloCabeceraOz" left="5">
        <tr>
          <td align="center" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
              <tr> 
                <td>&nbsp;</td>
                <td width="309">&nbsp;</td>
                <td width="148" align="right"> 
                  <?php echo $Fecha_Hora ?>
                  <?php
					if (!isset($FechaHora))
					{
						echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
						$FechaHora=date('Y-m-d H:i');
					}
					else
					{ 
						echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
					}
				  ?>
                </td>
                <td width="152" align="right"><div align="left">
                    <?php
					/*$Consulta="select distinct(correlativo) from pmn_web.carga_lixiviacion_barro_aurifero  ";
					$Consulta.=" where fecha ='".$Ano."-".$Mes."-".$Dia."'  ";
					//echo $Consulta."<br>";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);*/
				   ?>
				   <input name="Correlativo" type="hidden" id="Correlativo" value="<?php  echo $Correlativo;  ?>">
                  </div></td>
              </tr>
              <tr> 
                <td width="118" height="35" class="titulo_azul"> Fecha:</td>
                <td colspan="3"> 
                  <?php
				    if ($BloquearEmPlata=='B')
					{
						echo "<input type='hidden' name='CmbDias' value='".$CmbDias."'>\n";
						echo "<input type='hidden' name='CmbMes' value='".$CmbMes."'>\n";
						echo "<input type='hidden' name='CmbAno' value='".$CmbAno."'>\n";
						printf("%'02d",$CmbDias);
						echo "-";
						printf("%'02d",$CmbMes);
						echo "-";
						printf("%'04d",$CmbAno);
                    }
					else
					{
						echo "<select name='CmbDias'  size='1' style='font-face:verdana;font-size:10'>";	
					 	for ($i=1;$i<=31;$i++)
						{
							if (isset($CmbDias))
							{
								if ($i==$CmbDias)
								{
									echo "<option selected value= '".$i."'>".$i."</option>";
								}
								else
								{
								  echo "<option value='".$i."'>".$i."</option>";
								}
							}
							else
							{
								if ($i==date("j"))
								{
									echo "<option selected value= '".$i."'>".$i."</option>";
								}
								else
								{
								  echo "<option value='".$i."'>".$i."</option>";
								}
							}	
					  }
					echo "</select>";
					 echo "<select name='CmbMes' size='1'  style='FONT-FACE:verdana;FONT-SIZE:10'>";
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
						echo "<select name='CmbAno' size='1'  style='FONT-FACE:verdana;FONT-SIZE:10'>";
						for ($i=date("Y");$i<=date("Y");$i++)
						{
							if (isset($CmbAno))
							{
								if ($i==$CmbAno)
									{
										echo "<option selected value ='".$i."'>".$i."</option>";
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
										echo "<option selected value ='".$i."'>".$i."</option>";
									}
								else	
									{
										echo "<option value='".$i."'>".$i."</option>";
									}
							}		
						}
						echo "</select>";
					}	
					?>
                  <input name="BtnVer" type="button" style="width:60" value="Consultar" onClick="Proceso('Ver');"> 
                </td>
              </tr>
            </table>
			  
            <br>
            <table width="100%" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
              <tr> 
                <td width="61" height="26">&nbsp;</td>
                <td width="50" height="26">&nbsp;</td>
                <td width="62" height="26" class="titulo_azul">Cantidad</td>
                <td width="76"><input name="Cantidad" type="text" id="Cantidad" style="width:60" onKeyDown="SoloNumeros(true,this)" value="<?php  echo $Cantidad; ?>"></td>
                <td width="69" height="26" class="titulo_azul">Peso (Kgr)</td>
                <td width="68"><input name="Peso" type="text" id="Peso2" style="width:60" onKeyDown="SoloNumeros(true,this)" value="<?php  echo $Peso;  ?>"></td>
                <td width="29" class="titulo_azul">Us$</td>
                <td width="70"><input name="Dolar" type="text" id="Dolar" style="width:60" onKeyDown="SoloNumeros(true,this)"value="<?php echo $Dolar; ?>" >
                </td>
                <td width="33" height="26" class="titulo_azul">Acta</td>
                <td width="173" height="26">
				<?php
				$Consulta="select distinct num_acta from  pmn_web.embarque_plata  ";
				$Consulta.=" where fecha = '".$CmbAno."-".$CmbMes."-".$CmbDias."'	";			 
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);	
				$Acta=$Fila[num_acta];
			 	?>  
				<input name="Acta" type="text" id="Acta" style="width:60" onKeyDown="TeclaPulsada1('BtnGrabar')" value="<?php echo $Acta; ?>" ></td>
              </tr>
            </table>
            <br>
            <table width="754"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
              <tr> 
                <td align="center" valign="middle"> <input name="FechaHorita" type="hidden" value="<?php echo $Fecha;?>"> 
                  <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" onClick="Proceso('G');"> 
                  <input name="BtnModificar" type="button" id="BtnModificar" value="Modificar" style="width:60px;" onClick="Proceso('M','<?php echo $Bloquear;   ?>');"> 
                  <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" onClick="Proceso('E2','<?php echo $Bloquear; ?>');">
                  <input name="BtnExcel" type="hidden" style="width:60px;" value="Excel" onClick="Proceso('E');">
                  <input name="BtnCancelar" type="button" style="width:60" value="Cancelar" onClick="Cancelar('');">
                  <input name="BtnDetalle" type="button" id="BtnDetalle" value="Detalle" onClick="Detalle();"> 
                </td>
              </tr>
            </table>
            <br>
            <table width="754" border="1" align="center" cellpadding="0" cellspacing="0">
              <tr align="center"  class="TituloCabeceraAzul"> 
                <td width="34" height="22" align="center"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckTipo','ChkTodos');"></td>
                <td width="128"> <div align="center"><strong>Cantidad</strong></div></td>
                <td width="142"> <div align="center"><strong>Peso(Kgr)</strong></div></td>
                <td width="121"> <div align="center"><strong>US$</strong></div></td>
                <td width="160"><strong>Acta</strong></td>
              </tr>
              <?php
				$Fecha = $CmbAno."-".$CmbMes."-".$CmbDias; 
				if (($MostrarEmPlata=='C')|| ($MostrarEmPlata =='V'))
				{
					$Consulta="select * from pmn_web.embarque_plata  ";
					$Consulta.=" where (fecha = '".$Fecha."') order by cantidad";
					//echo $Consulta."<br>";
					$Cont=0;
					$i=1;
					echo "<input name='CheckTipo' type='hidden' value=''>";
					$Resultado=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resultado))
					{
						//echo "filas:    ".$Fila["fecha"]."<br>";
						$Clave=$Fila["fecha"]."~".$Fila[correlativo]."~".$Fila[cantidad]."~".$Fila["peso"]."~".$Fila["valor"]."~".$Fila[num_acta];
						echo "<tr>";
						echo "<td align='center'><input type='checkbox' name='CheckTipo' class='SinBorde' value='".$Clave."'>\n";
						//echo "<input type='hidden' name='ChkCaja[".$i."]' value='".$Fila[num_caja]."'>\n";
						echo "<input type='hidden' name='ChkCantidad[".$i."]' value='".$Fila[cantidad]."'>\n";
						echo "<input type='hidden' name='ChkPeso[".$i."]' value='".$Fila["peso"]."'>\n";
						echo "<input type='hidden' name='ChkValor[".$i."]' value='".$Fila["valor"]."'>\n";
						echo "<input type='hidden' name='ChkActa[".$i."]' value='".$Fila[num_acta]."'>\n";
						echo "<input type='hidden' name='ChkCorrelativo[".$i."]' value='".$Fila[correlativo]."'>\n";
						echo "<td><div align='left'>".$Fila["cantidad"]."</div></td>";
						echo "<td><div align='left'>".str_replace(".",",",$Fila["peso"])."</div></td>";								
						echo "<td><div align='left'>".str_replace(".",",",$Fila["valor"])."</div></td>";		
						echo "<td><div align='left'>".str_replace(".",",",$Fila["num_acta"])."</div></td>";		
						echo "</tr>";
						$i++;		
						$Cont++;
					}
				}
				?>
            </table>         
		  </td>
        </tr>
  </table>
 
</form>
<p>&nbsp;</p>
</body>
</html>
