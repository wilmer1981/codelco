<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;
$CodigoDeSistema = 1;
$CodigoDePantalla = 5;
$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '1'  ";
$Respuesta =mysqli_query($link, $Consulta);
if($Fila =mysqli_fetch_array($Respuesta))
{
	$Nivel = $Fila["nivel"];
}


if(isset($_REQUEST["Bloquear"])) {
	$Bloquear = $_REQUEST["Bloquear"];
}else{
	$Bloquear =  "";
}
if(isset($_REQUEST["CheckCombo"])) {
	$CheckCombo = $_REQUEST["CheckCombo"];
}else{
	$CheckCombo =  "";
}

if(isset($_REQUEST["CmbDias"])) {
	$CmbDias = $_REQUEST["CmbDias"];
}else{
	$CmbDias =  date("d");
}
if(isset($_REQUEST["CmbMes"])) {
	$CmbMes = $_REQUEST["CmbMes"];
}else{
	$CmbMes =  date("m");
}
if(isset($_REQUEST["CmbAno"])) {
	$CmbAno = $_REQUEST["CmbAno"];
}else{
	$CmbAno =  date("Y");
}
if(isset($_REQUEST["CmbDiasT"])) {
	$CmbDiasT = $_REQUEST["CmbDiasT"];
}else{
	$CmbDiasT =  date("d");
}
if(isset($_REQUEST["CmbMesT"])) {
	$CmbMesT = $_REQUEST["CmbMesT"];
}else{
	$CmbMesT =  date("m");
}
if(isset($_REQUEST["CmbAnoT"])) {
	$CmbAnoT = $_REQUEST["CmbAnoT"];
}else{
	$CmbAnoT =  date("Y");
}
if(isset($_REQUEST["CmbQuimico"])) {
	$CmbQuimico = $_REQUEST["CmbQuimico"];
}else{
	$CmbQuimico =  "";
}
if(isset($_REQUEST["CmbFisico"])) {
	$CmbFisico = $_REQUEST["CmbFisico"];
}else{
	$CmbFisico =  "";
}
if(isset($_REQUEST["TxtOpcion"])) {
	$TxtOpcion = $_REQUEST["TxtOpcion"];
}else{
	$TxtOpcion =  "";
}
if(isset($_REQUEST["Mostrar"])) {
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar =  "";
}
if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni = 0;
}
if(isset($_REQUEST["LimitFin"])) {
	$LimitFin = $_REQUEST["LimitFin"];
}else{
	$LimitFin = 50;
}
if(isset($_REQUEST["CmbEspectrografo"])) {
	$CmbEspectrografo = $_REQUEST["CmbEspectrografo"];
}else{
	$CmbEspectrografo = "";
}
		



?>
<html>
<head>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion,Bloquear,Quimico,CheckBox,Fisico)
{
	var frm=document.FrmConsultaRecepcion;
	switch (Opcion)
	{
		case "B": 
				frm.TxtOpcion.value=1;
				var TotalDiasT=0;
				var CantDiasI=0;
				var CantDiasT=0;
				var TotalDiasI=0;
				var DifDias=0;
				var Mostrar =1;
				CantDiasI=365*parseInt(frm.CmbAno.value);
				TotalDiasI=parseInt(CantDiasI)+(31*parseInt(frm.CmbMes.value))+parseInt(frm.CmbDias.value);
				CantDiasT=365*parseInt(frm.CmbAno.value);
				TotalDiasT=CantDiasT+(31*parseInt(frm.CmbMesT.value))+parseInt(frm.CmbDiasT.value);
				DifDias=TotalDiasT-TotalDiasI;
				if (DifDias > 65)
				{
					alert("Rango de busqueda debe ser 2 meses aprox.")
					Mostrar=2;
					return;
				}
				if (frm.CmbAnoT.value==frm.CmbAno.value)
				{
					if ((frm.CmbMesT.value-frm.CmbMes.value)>2)
					{
						alert("El rango de fecha debe ser menor o igual a 2 meses");
						Mostrar=2;
						return;
					}
				}
				if (Mostrar == 1)
				{
					frm.action ="cal_con_leyes_quimico.php?Bloquear="+Bloquear + "&CmbQuimico="+Quimico + "&CmbFisico="+Fisico+"&CheckCombo="+CheckBox + "&Mostrar=B";//si la busqueda es por los quimico o el jefe   
					frm.submit();
				}
			break;	
		case "S":
			Salir();
			break;	
		case "O":
			frm.TxtOpcion.value=2;
			var TotalDiasT=0;
			var CantDiasI=0;
			var CantDiasT=0;
			var TotalDiasI=0;
			var DifDias=0;
			var Mostrar =1;
			CantDiasI=365*parseInt(frm.CmbAno.value);
			TotalDiasI=parseInt(CantDiasI)+(31*parseInt(frm.CmbMes.value))+parseInt(frm.CmbDias.value);
			CantDiasT=365*parseInt(frm.CmbAno.value);
			TotalDiasT=CantDiasT+(31*parseInt(frm.CmbMesT.value))+parseInt(frm.CmbDiasT.value);
			DifDias=TotalDiasT-TotalDiasI;
			if (DifDias > 65)
			{
				alert("Rango de busqueda debe ser 2 meses aprox.")
				Mostrar=2;
				return;
			}
			if (frm.CmbAnoT.value==frm.CmbAno.value)
			{
				if ((frm.CmbMesT.value-frm.CmbMes.value)>2)
				{
					alert("El rango de fecha debe ser menor o igual a 2 meses");
					Mostrar=2;
					return;
				}
			}
			if (Mostrar == 1)
			{
				frm.action ="cal_con_leyes_quimico.php?Bloquear="+Bloquear  + "&Mostrar=O"; //si mostrar es por la maquina de espectromtria  
				frm.submit();
			}
		break;
		case "OK":
			//frm.action ="cal_con_leyes_quimico.php?Mostrar=I";//Si Busca Por Qumico anlitico o fisico   
			//frm.submit();
		break;
	}	
}
function Recarga1(Check)
{
	//alert(Check);
	var frm =document.FrmConsultaRecepcion;
	frm.action ="cal_con_leyes_quimico.php?CheckCombo="+Check +"&Bloquear=K";//Desactica el Combo Fisico  
	frm.submit();
}
function RecargaComboQuimico(Quimico,Bloquear,Check)
{
	var frm =document.FrmConsultaRecepcion;
	//frm.action ="cal_con_leyes_quimico.php?Bloquear="+Bloquear + "&CmbQuimico="+Quimico +"&Mostrar=B";//si la busqueda es por los quimico o el jefe   
	frm.action ="cal_con_leyes_quimico.php?CmbQuimico="+Quimico +"&Bloquear="+Bloquear +"&CheckCombo="+Check;//si la busqueda es por los quimico o el jefe   
	frm.submit();
}
function RecargaComboFisico(Fisico,Bloquear,Check)
{
	var frm =document.FrmConsultaRecepcion;
	//frm.action ="cal_con_leyes_quimico.php?Bloquear="+Bloquear + "&CmbQuimico="+Quimico +"&Mostrar=B";//si la busqueda es por los quimico o el jefe   
	frm.action ="cal_con_leyes_quimico.php?CmbFisico="+Fisico +"&Bloquear="+Bloquear +"&CheckCombo="+Check;//si la busqueda es por los quimico o el jefe   
	frm.submit();
}
function Recarga2(Check)
{
	//alert(Check);
	var frm =document.FrmConsultaRecepcion;
	frm.action ="cal_con_leyes_quimico.php?CheckCombo="+Check +"&Bloquear=P";//Desactiva el combo quyimijco
	frm.submit();
}
function Salir()
{
	var frm =document.FrmConsultaRecepcion;
	frm.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	frm.submit(); 
}

function Imprimir()
{
	var frm =document.FrmConsultaRecepcion;
	window.print();
}
function Historial(SA,Rec)
{
	window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}	
function Excel(Opcion,Bloquear,Quimico,CheckBox,Fisico,Opcion)
{
	var frm =document.FrmConsultaRecepcion;
	if (Opcion == 1)
	{
		frm.action ="cal_con_leyes_quimico_excel.php?Bloquear="+Bloquear + "&CmbQuimico="+Quimico + "&CmbFisico="+Fisico+"&CheckCombo="+CheckBox + "&LimitIni="+frm.LimitIni.value + "&LimitFin="+frm.LimitFin.value + "&Mostrar=B";//si la busqueda es por los quimico o el jefe   
		frm.submit();
	}
	else
	{
		frm.action ="cal_con_leyes_quimico_excel.php??Bloquear="+Bloquear + "&LimitIni="+frm.LimitIni.value + "&LimitFin="+frm.LimitFin.value + "&Mostrar=O";//si la busqueda es por los quimico o el jefe   
		frm.submit();
	}
}
function Recarga3(URL,LimiteIni,Mostrar,Quimico,Fisico,CkCombo,B)
{
	var frm=document.FrmConsultaRecepcion;
	frm.LimitIni.value = LimiteIni;
	frm.action=URL + "?LimitIni=" + LimiteIni +"&Mostrar="+Mostrar + "&CmbQuimico="+Quimico + "&CmbFisico="+Fisico + "&CheckCombo="+CkCombo + "&Bloquear="+B ;
	frm.submit(); 
}
	
</script></head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmConsultaRecepcion" method="post" action="">
    <?php
	/*
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 50;*/
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
  </font></font></font></font></font></font></strong></font></font></strong></font></font>	
  <tr>
      <td width="613"><table width="786" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr> 
          <td width="126"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Usuario: 
              </font></font></div></td>
          <td width="269"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
            <?php
			$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
			$Resultado= mysqli_query($link, $Consulta);
			if ($Fila =mysqli_fetch_array($Resultado))
			{	
				echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
			}	  
			else
			{
				$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
				}
		
			}
  		   ?>
            </strong></font></font></td>
          <td width="96">Fecha:</td>
          <td colspan="2"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
            <?php echo $Fecha_Hora ?>
            </strong>&nbsp; <strong> 
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
            </strong></font></font></td>
        </tr>
        <tr> 
          <td height="31">Fecha Inicio<font size="2">:</font></td>
          <td height="31"><font size="2"> 
            <select name="CmbDias" style="width:40px;">
              <?php
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
				?>
            </select>
            </font> <font size="2"> 
            <select name="CmbMes" style="width:90px;">
              <?php
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
		     ?>
            </select>
            </font> <select name="CmbAno" style="width:70px;">
              <?php
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
			 ?>
            </select></td>
          <td>Fecha Termino:</td>
          <td width="213"><select name="CmbDiasT" style="width:40px;">
              <?php
				for ($i=1;$i<=31;$i++)
				{
					if (isset($CmbDiasT))
					{
						if ($i==$CmbDiasT)
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
			 ?>
            </select> <select name="CmbMesT" style="width:90px;">
              <?php
			  for($i=1;$i<13;$i++)
			  {
					if (isset($CmbMesT))
					{
						if ($i==$CmbMesT)
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
		     ?>
            </select> <font size="2"> 
            <select name="CmbAnoT" style="width:70px;">
              <?php
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if (isset($CmbAnoT))
					{
						if ($i==$CmbAnoT)
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
			?>
            </select>
            </font></td>
          <td width="49"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            </font></font></font></font></font></font></strong></font></font></strong></font></font></td>
        </tr>
        <!--despuespregunta-->
        <?php
		if (($Nivel=='1')||($Nivel=='2')||($Nivel=='3'))
		{
			echo "<tr>";
        	//if ($Bloquear=='K')
			if ($Bloquear=='P')
			{
				echo"<td width='90'>Q.Analitico<input name='CheckCombo'  type='checkbox' value='1' onClick=\"Recarga1('$CheckCombo');\" ></td>";
        	}
			else
			{
				echo"<td width='90'>Q.Analitico<input name='CheckCombo' type='checkbox' value='1' onClick=\"Recarga1('$CheckCombo');\" checked  ></td>";
			}
			echo"<td width='150'>";
		 	//if ($Bloquear=='K')
			// echo $Bloquear."<br>";
			if ($Bloquear=='P')
			{
				echo "<select name='CmbQuimico' disabled style='width:200' >"; 	
		 	}
			else
			{
				//echo "<select name='CmbQuimico'  style='width:200' onChange=\"RecargaCombo('$CmbQuimico');\" >"; 	
			echo "<select name='CmbQuimico'  style='width:200' onChange=\"RecargaComboQuimico('$CmbQuimico','$Bloquear','$CheckCombo');\">"; 	
			}
			echo "<option value='-1' selected>Todos</option>";
		  	$Consulta = "select STRAIGHT_JOIN t1.rut,t1.nombres,t1.apellido_paterno,t1.apellido_materno from proyecto_modernizacion.funcionarios t1 ";
			$Consulta= $Consulta." inner join proyecto_modernizacion.sistemas_por_usuario t2  ";
			$Consulta= $Consulta." on t1.rut=t2.rut ";
			$Consulta= $Consulta." where t2.cod_sistema=1 and (t2.nivel = 5 or t2.nivel = 6 or t2.nivel =12 or t2.nivel = 14 or t2.nivel = 16) order by t1.apellido_paterno,t1.apellido_materno,t1.nombres ";
			$Resultado= mysqli_query($link, $Consulta);
			while ($Fila2=mysqli_fetch_array($Resultado))
			{
				if ($CmbQuimico == $Fila2["rut"])
				{
					echo"<option value='".$Fila2["rut"]."'selected>".ucwords(strtolower($Fila2["apellido_paterno"]))." ".ucwords(strtolower($Fila2["apellido_materno"]))." ".ucwords(strtolower($Fila2["nombres"]))."</option>";
				}
				else
				{
					echo "<option value='".$Fila2["rut"]."'>".ucwords(strtolower($Fila2["apellido_paterno"]))." ".ucwords(strtolower($Fila2["apellido_materno"]))." ".ucwords(strtolower($Fila2["nombres"]))."</option>";
				}
			}
			echo "</select>";
		  echo"</td>";
          //if ($Bloquear =='P')
		 
		  if ($Bloquear =='K')
		  {
		  	echo "<td width='80' height='31'>Q.Fisico<input name='CheckCombo' type='checkbox' value='2' onClick=\"Recarga2('$CheckCombo');\" ></td>";
          	
		  }
		  else
		  {
		  	echo"<td width='90'>Q.Fisico<input name='CheckCombo' type='checkbox' value='2' onClick=\"Recarga2('$CheckCombo');\" checked  ></td>";
			
		  }
		  echo "<td width='100'>";
		  	//if ($Bloquear=='P')
			if ($Bloquear=='K')
			{
				echo "<select name='CmbFisico' disabled style='width:200'>";
			}
			else
			{
				echo "<select name='CmbFisico' style='width:200' onChange=\"RecargaComboFisico('$CmbFisico','$Bloquear','$CheckCombo');\" >";
			}
			echo "<option value='-1' selected>Todos</option>";
		  	$Consulta = "select STRAIGHT_JOIN t1.rut,t1.nombres,t1.apellido_paterno,t1.apellido_materno from proyecto_modernizacion.funcionarios t1 ";
			$Consulta= $Consulta." inner join proyecto_modernizacion.sistemas_por_usuario t2  ";
			$Consulta= $Consulta." on t1.rut=t2.rut ";
			$Consulta= $Consulta." where t2.cod_sistema=1 and t2.nivel =10 ";
			$Resultado= mysqli_query($link, $Consulta);
			while ($Fila2=mysqli_fetch_array($Resultado))
			{
				if ($CmbFisico == $Fila2["rut"])
				{
					echo"<option value='".$Fila2["rut"]."'selected>".ucwords(strtolower($Fila2["apellido_paterno"]))." ".ucwords(strtolower($Fila2["apellido_materno"]))." ".ucwords(strtolower($Fila2["nombres"]))."</option>";
				}
				else
				{
					echo "<option value='".$Fila2["rut"]."'>".ucwords(strtolower($Fila2["apellido_paterno"]))." ".ucwords(strtolower($Fila2["apellido_materno"]))." ".ucwords(strtolower($Fila2["nombres"]))."</option>";
				}
			}
			echo "</select>";
		  echo "</td>";
          echo"<td width='87'>";
		  echo "</td>";
	      echo "</tr>";
		}       
	    ?>
        <!--termmino-->
        <tr align="center" valign="middle"> 
          <td height="30" colspan="5"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            </font></font><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            </font><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            <input name="BtnBuscar" type="button" id="BtnBuscar" style="width:70"value=	"Consultar" onClick="Proceso('B','<?php echo $Bloquear;  ?>','<?php echo $CmbQuimico; ?>','<?php echo $CheckCombo;?>','<?php echo $CmbFisico; ?>');">
            </font></font></font></font></font></font></strong></font></font></strong></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            &nbsp; 
            <input name="BtnImprimir2" type="button" value="Imprimir" onClick='JavaScript:Imprimir();' style="width:70">
            &nbsp;</font><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            <?php
			if (!isset($TxtOpcion))
			{
				echo "<input name='TxtOpcion' type='hidden' value=''>";
 				$TxtOpcion=$TxtOpcion;
			}
			else
			{ 
				echo "<input name='TxtOpcion' type='hidden' value=' $TxtOpcion'>";
			}
			?>
		    <input name="BtnExcel" type="button" style="width:70" onClick="Excel('B','<?php echo $Bloquear;  ?>','<?php echo $CmbQuimico; ?>','<?php echo $CheckCombo;?>','<?php echo $CmbFisico; ?>','<?php echo $TxtOpcion;   ?>');" value="Excel">
            </font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            &nbsp; 
           
			<input name="BtnSalir2" type="button" value="Salir" style="width:70" onClick="Proceso('S');">
            </font></font><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            </font></font></td>
        </tr>
		</table>
		
      <br>
      <table width="786" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr> 
          <td width="128" height="30">Equipo Espectrográfo:</td>
          <td width="266" height="30"> <select name="CmbEspectrografo" style="width:150">
              <?php
					if (!isset($CmbEspectrografo))
					{
						echo "<option selected value='-1' selected>Seleccionar</option>";
						echo "<option value='00000000-1'>EEA-Arco</option>";
						echo "<option value='00000000-2'>EEA-Plasma</option>";
					}
					else
					{
						if ($CmbEspectrografo == "-1")
						{
							echo "<option selected value='-1' selected>Seleccionar</option>";
							echo "<option value='00000000-1'>EEA-Arco</option>";
							echo "<option value='00000000-2'>EEA-Plasma</option>";
						}
						if ($CmbEspectrografo == '00000000-1') 
						{
							echo "<option selected value='-1' >Seleccionar</option>";
							echo "<option value='00000000-1' selected>EEA-Arco</option>";
							echo "<option value='00000000-2'>EEA-Plasma</option>";
						}
						if ($CmbEspectrografo == '00000000-2') 
						{
							echo "<option selected value='-1' >Seleccionar</option>";
							echo "<option value='00000000-1'>EEA-Arco</option>";
							echo "<option value='00000000-2' selected>EEA-Plasma</option>";
						}
					}	
				?>
            </select> <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            <input name="BtnBuscar" type="button" value="Buscar" onClick="Proceso('O','<?php echo $Bloquear;  ?>');" style="width:50">
            </font></font></td>
          <td width="85">Lineas Por Pag</td>
          <td width="280"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="LimitFin" type="text" id="LimitFin" value="<?php echo $LimitFin;?>" size="12" maxlength="12">
            </font></font></font></font></font></font></strong></font></font></strong></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            </font></font></font></font></font></font></strong></font></font></strong></font></font></td>
        </tr>
      </table>
       
        <br>
        <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        </font></font> <table width="787" border="1" cellpadding="0" cellspacing="0" >
        
        <tr align="center" class="ColorTabla01"> 
          <td width="142"><strong> #SA</strong></td>
          <?php
		  if ($Mostrar=='O')
		  {
		  	echo "<td width='169'><strong>Fecha Atencion</strong></td>";
		  }
		  else
		  {
		  	echo "<td width='169'><strong> Id. Muestra</strong></td>";
          }
		  ?>
		  <td width="157"><strong> Ley</strong></td>
          <td width="113"><strong> Valor</strong></td>
          <td width="182"><strong> Unidad</strong></td>
        </tr>
        <?php
	   	$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
		$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
		if (($Mostrar=='B')&& (($Nivel!=1)&&($Nivel!=2)&&($Nivel!=3)))	
	   	{
			$Consulta=" select STRAIGHT_JOIN t1.nro_solicitud,t1.recargo,t4.id_muestra,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
			$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
			$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
			$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad ";
			$Consulta= $Consulta." inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo= t4.recargo  and t1.fecha_hora = t4.fecha_hora and t1.rut_funcionario = t4.rut_funcionario";
			$Consulta= $Consulta." where (t4.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
			$Consulta= $Consulta." and t1.rut_quimico = '".$Rut."' and (t4.estado_actual = 5 or t4.estado_actual = 6 or t4.estado_actual = 31 or t4.estado_actual = 32)  and (not isnull(valor) or valor = '') order by t1.nro_solicitud,recargo_ordenado ";
			//echo $Consulta."<br>";
			$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
			$Respuesta=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{				
				echo "<tr>\n";
				if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
				{
					//solicitud automatica sin recargo
					$Recargo='N';
					echo "<td width='129'><a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'".$Recargo."')\">\n";
					echo $Fila["nro_solicitud"]."</a></td>\n";
				}
				else
				{
					//solicitud automatica
					echo "<td width='129'><a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'".$Fila["recargo"]."')\">\n";
					echo $Fila["nro_solicitud"]."-".$Fila["recargo"]."</td>\n";
					//echo "<td width='95'>".$Fila["nro_solicitud"].'-'.$Fila["recargo"]."</td>";			
				} 
				//echo "<td width='129'>".$Fila["nro_solicitud"]."&nbsp;</td>";
				if ($Fila["signo"] == 'N')
				{
					$Valor = 'ND';
					$Signo = "";
				}
				else
				{
					if ((is_null($Fila["signo"]))|| ($Fila["valor"] ==''))
					{
						$Valor = "";
						$Signo = ""; 
					}	
					else
					{
						$Valor=$Fila["signo"]." ".number_format($Fila["valor"],2);
					
					}
				}
				//////////////////////////////////
				echo "<td width='129'>".$Fila["id_muestra"]."&nbsp;</td>";
				echo "<td width='129'>".$Fila["leyes"]."&nbsp;</td>";
				echo "<td width='142'>".$Valor."&nbsp;</td>";
				echo "<td width='179'>".$Fila["unidad"]."&nbsp;</td>";
				echo "</tr>";
			}
		}
		else
		{
			if (($Mostrar=='B')&& (($Nivel==1)||($Nivel==2)||($Nivel==3)))		
			{
				if (($CmbQuimico=='-1')&&($CheckCombo==1))
				{
					$Consulta=" select STRAIGHT_JOIN t1.nro_solicitud,t1.recargo,t5.id_muestra,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta." on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t5 on t1.nro_solicitud = t5.nro_solicitud and t1.recargo= t5.recargo  and t1.fecha_hora = t5.fecha_hora and t1.rut_funcionario = t5.rut_funcionario";
					$Consulta= $Consulta." where (t5.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t5.estado_actual = 5 or t5.estado_actual = 6 or t5.estado_actual = 31 or t5.estado_actual = 32) and (t5.cod_analisis ='1') and (not isnull(valor) or valor = '')order by t1.nro_solicitud,recargo_ordenado ";
					//echo "1".$Consulta."<br>";
				}
				/*if (($CmbQuimico=='-1')&&($CmbFisico=='-1')&&($CheckCombo!=1)&&($CheckCombo!=2))
				{
					$Consulta=" select  STRAIGHT_JOIN t1.nro_solicitud,t1.recargo,t4.id_muestra,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo= t4.recargo ";
					$Consulta= $Consulta." where (t1.fecha_hora between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t4.estado_actual = 5 or t4.estado_actual = 6 or t4.estado_actual = 31 or t4.estado_actual = 32) order by t1.nro_solicitud,recargo_ordenado ";
					//echo "2".$Consulta."<br>";
				}*/
				if (($CmbQuimico!='-1')&&($CheckCombo==1))
				{
					$Consulta=" select STRAIGHT_JOIN t1.nro_solicitud,t1.recargo,t4.id_muestra,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo= t4.recargo  and t1.fecha_hora = t4.fecha_hora and t1.rut_funcionario = t4.rut_funcionario";
					$Consulta= $Consulta." where (t4.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t4.estado_actual = 5 or t4.estado_actual = 6 or t4.estado_actual = 31 or t4.estado_actual = 32) and t1.rut_quimico = '".$CmbQuimico."' and (t4.cod_analisis ='1') and (not isnull(valor) or valor = '')order by t1.nro_solicitud,recargo_ordenado";
					//echo "3".$Consulta."<br>";
				}
				if (($CmbFisico=='-1')&&($CheckCombo==2))
				{
					$Consulta=" select STRAIGHT_JOIN t1.nro_solicitud,t1.recargo,t5.id_muestra,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta." on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t5 on t1.nro_solicitud = t5.nro_solicitud and t1.recargo= t5.recargo  and t1.fecha_hora = t5.fecha_hora and t1.rut_funcionario = t5.rut_funcionario";
					$Consulta= $Consulta." where (t5.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t5.estado_actual = 5 or t5.estado_actual = 6 or t5.estado_actual = 31 or t5.estado_actual = 32) and (t5.cod_analisis ='2') and (not isnull(valor) or valor = '')   order by t1.nro_solicitud,recargo_ordenado ";
					//echo "4".$Consulta."<br>";
				}
				if (($CmbFisico!='-1')&&($CheckCombo==2))//&&($CmbFisico!='-1'))
				{
					$Consulta=" select STRAIGHT_JOIN t1.nro_solicitud,t1.recargo,t4.id_muestra,t2.abreviatura as leyes ,t3.abreviatura as unidad,t1.valor,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo= t4.recargo  and t1.fecha_hora = t4.fecha_hora and t1.rut_funcionario = t4.rut_funcionario ";
					$Consulta= $Consulta." where (t4.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t4.estado_actual = 5 or t4.estado_actual = 6 or t4.estado_actual = 31 or t4.estado_actual = 32) and t1.rut_quimico = '".$CmbFisico."' and (t4.cod_analisis ='2') and (not isnull(valor) or valor = '') order by t1.nro_solicitud,recargo_ordenado ";
					//echo "5".$Consulta."<br>";
				}
				//echo $Consulta."<br>";
				$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
				$Respuesta=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{			
					if ($Fila["signo"] == 'N')
					{
						$Valor = 'ND';
						$Signo = "";
					}
					else
					{
						if ((is_null($Fila["signo"]))|| ($Fila["valor"] ==''))
						{
							$Valor = "";
							$Signo = "";
						}	
						else
						{
							if ($Fila["signo"]=='=')
							{
								$Signo="";	
							}
							else
							{
								$Signo=$Fila["signo"];
							}
							$Valor=$Signo." ".number_format($Fila["valor"],3);
						}		
					}
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
					{
					//solicitud automatica sin recargo
					$Recargo='N';
					echo "<td width='129'><a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'".$Recargo."')\">\n";
					echo $Fila["nro_solicitud"]."</a></td>\n";
					}
					else
					{
						//solicitud automatica
						echo "<td><a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'".$Fila["recargo"]."')\">\n";
						echo $Fila["nro_solicitud"]."-".$Fila["recargo"]."</td>\n";
					} 
					echo "<td width='129' >".$Fila["id_muestra"]."&nbsp;</td>";
					echo "<td width='129'>".$Fila["leyes"]."&nbsp;</td>";
					echo "<td width='142'>".$Valor."&nbsp;</td>";
					echo "<td width='179'>".$Fila["unidad"]."&nbsp;</td>";
					echo "</tr>";
				}
			}
		}	
	  if($Mostrar=='O')
	  {
	  	$Consulta="select STRAIGHT_JOIN t1.nro_solicitud,t1.recargo,t1.fecha_hora,t2.abreviatura as leyes,t3.abreviatura as unidad,t1.valor,t1.rut_funcionario,t1.signo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado  ";
		$Consulta=$Consulta." from cal_web.registro_leyes t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes ";    		  
	  	$Consulta=$Consulta." inner join proyecto_modernizacion.unidades t3 on t1.cod_unidad = t3.cod_unidad ";
		$Consulta=$Consulta." where (t1.fecha_hora between '".$FechaI."' and '".$FechaT."') ";
		$Consulta= $Consulta." and t1.rut_funcionario = '".$CmbEspectrografo."'  and (not isnull(valor) or valor = '') order by t1.nro_solicitud,recargo_ordenado,t1.fecha_hora";
		$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
		$Respuesta=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";
			if ($Fila["signo"] == 'N')
			{
				$Valor = 'ND';
				$Signo = "";
			}
			else
			{
				if ((is_null($Fila["signo"]))|| ($Fila["valor"] ==''))
				{
					$Valor = "";
					$Signo = "";
				}	
				else
				{
					if ($Fila["signo"]=='=')
					{
						$Signo="";	
					}
					else
					{
						$Signo=$Fila["signo"];
					}
					$Valor=$Signo." ".number_format($Fila["valor"],3);
					//echo "valor".$Valor."<br>";
				}
			}
			if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
			{
			//solicitud automatica sin recargo o especial
			$Recargo='N';
			echo "<td width='129'><a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'".$Recargo."')\">\n";
			echo $Fila["nro_solicitud"]."</a></td>\n";
			}
			else
			{
				//solicitud automatica
				echo "<td><a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'".$Fila["recargo"]."')\">\n";
				echo $Fila["nro_solicitud"]."-".$Fila["recargo"]."</td>\n";
			} 
			echo "<td width='129'>".$Fila["fecha_hora"]."&nbsp;</td>";
			echo "<td width='129'>".$Fila["leyes"]."&nbsp;</td>";
			echo "<td width='142'>".$Valor."&nbsp;</td>";
			echo "<td width='179'>".$Fila["unidad"]."&nbsp;</td>";
			echo "</tr>";
		}
	}
	?>
      </table>
        
      <table width="760" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="25" align="center" valign="middle">Paginas &gt;&gt; 
        <?php		
		if (($Mostrar=='B')&& (($Nivel!=1)&&($Nivel!=2)&&($Nivel!=3)))	
	   	{
			$Consulta=" select count(*) as total_registros ";
			$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
			$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
			$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad ";
			$Consulta= $Consulta." inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo= t4.recargo  and t1.fecha_hora = t4.fecha_hora and t1.rut_funcionario = t4.rut_funcionario";
			$Consulta= $Consulta." where (t4.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
			$Consulta= $Consulta." and t1.rut_quimico = '".$Rut."' and (t4.estado_actual = 5 or t4.estado_actual = 6 or t4.estado_actual = 31 or t4.estado_actual = 32)  and (not isnull(valor) or valor = '') ";
		}
		else
		{
			if (($Mostrar=='B')&& (($Nivel==1)||($Nivel==2)||($Nivel==3)))		
			{
				if (($CmbQuimico=='-1')&&($CheckCombo==1))
				{
					$Consulta=" select count(*) as total_registros ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta." on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t5 on t1.nro_solicitud = t5.nro_solicitud and t1.recargo= t5.recargo  and t1.fecha_hora = t5.fecha_hora and t1.rut_funcionario = t5.rut_funcionario";
					$Consulta= $Consulta." where (t5.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t5.estado_actual = 5 or t5.estado_actual = 6 or t5.estado_actual = 31 or t5.estado_actual = 32) and (t5.cod_analisis ='1') and (not isnull(valor) or valor = '') ";
					//echo "1".$Consulta."<br>";
				}
				/*if (($CmbQuimico=='-1')&&($CmbFisico=='-1')&&($CheckCombo!=1)&&($CheckCombo!=2))
				{
					$Consulta=" select  count(*) as total_registros ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo= t4.recargo ";
					$Consulta= $Consulta." where (t1.fecha_hora between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t4.estado_actual = 5 or t4.estado_actual = 6 or t4.estado_actual = 31 or t4.estado_actual = 32)  ";
					//echo "2".$Consulta."<br>";
				}*/
				if (($CmbQuimico!='-1')&&($CheckCombo==1))
				{
					$Consulta=" select count(*) as total_registros ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo= t4.recargo  and t1.fecha_hora = t4.fecha_hora and t1.rut_funcionario = t4.rut_funcionario";
					$Consulta= $Consulta." where (t4.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t4.estado_actual = 5 or t4.estado_actual = 6 or t4.estado_actual = 31 or t4.estado_actual = 32) and t1.rut_quimico = '".$CmbQuimico."' and (t4.cod_analisis ='1') and (not isnull(valor) or valor = '') ";
					//echo "3".$Consulta."<br>";
				}
				if (($CmbFisico=='-1')&&($CheckCombo==2))
				{
					$Consulta=" select count(*) as total_registros ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta." on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t5 on t1.nro_solicitud = t5.nro_solicitud and t1.recargo= t5.recargo  and t1.fecha_hora = t5.fecha_hora and t1.rut_funcionario = t5.rut_funcionario";
					$Consulta= $Consulta." where (t5.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t5.estado_actual = 5 or t5.estado_actual = 6 or t5.estado_actual = 31 or t5.estado_actual = 32) and (t5.cod_analisis ='2') and (not isnull(valor) or valor = '')  ";
					//echo "4".$Consulta."<br>";
				}
				if (($CmbFisico!='-1')&&($CheckCombo==2))//&&($CmbFisico!='-1'))
				{
					$Consulta=" select count(*) as total_registros ";
					$Consulta= $Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
					$Consulta= $Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 ";
					$Consulta= $Consulta."on t1.cod_unidad = t3.cod_unidad ";
					$Consulta= $Consulta." inner join cal_web.solicitud_analisis t4 on t1.nro_solicitud = t4.nro_solicitud and t1.recargo= t4.recargo  and t1.fecha_hora = t4.fecha_hora and t1.rut_funcionario = t4.rut_funcionario ";
					$Consulta= $Consulta." where (t4.fecha_muestra between '".$FechaI."' and '".$FechaT."') ";
					$Consulta= $Consulta."  and (t4.estado_actual = 5 or t4.estado_actual = 6 or t4.estado_actual = 31 or t4.estado_actual = 32) and t1.rut_quimico = '".$CmbFisico."' and (t4.cod_analisis ='2') and (not isnull(valor) or valor = '') ";
					//echo "5".$Consulta."<br>";
				}	
			}		
		}
		if($Mostrar=='O')
		{
			$Consulta="select count(*) as total_registros  ";
			$Consulta=$Consulta." from cal_web.registro_leyes t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes ";    		  
			$Consulta=$Consulta." inner join proyecto_modernizacion.unidades t3 on t1.cod_unidad = t3.cod_unidad ";
			$Consulta=$Consulta." where (t1.fecha_hora between '".$FechaI."' and '".$FechaT."') ";
			$Consulta= $Consulta." and t1.rut_funcionario = '".$CmbEspectrografo."'  and (not isnull(valor) or valor = '')";
		}	
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		$Row = mysqli_fetch_array($Respuesta);
		if(isset($Row["total_registros"])){
			$Coincidencias = $Row["total_registros"];
		}else{
			$Coincidencias = 0;
		}
		//$Coincidencias = $Row["total_registros"];
		$NumPaginas = ($Coincidencias / $LimitFin);
		$LimitFinAnt = $LimitIni;
		$StrPaginas = "";
		for ($i = 0; $i <= $NumPaginas; $i++)
		{
			$LimitIni = ($i * $LimitFin);
			if ($LimitIni == $LimitFinAnt)
			{
				$StrPaginas.= "<strong>".($i + 1)."</strong>&nbsp;-&nbsp;\n";
			}
			else
			{
				$StrPaginas.=  "<a href=JavaScript:Recarga3('cal_con_leyes_quimico.php','".($i * $LimitFin)."','$Mostrar','$CmbQuimico','$CmbFisico','$CheckCombo','$Bloquear');>";
				$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
			}
		}
		echo substr($StrPaginas,0,-15);
?>
          </td>
        </tr>
      </table>
      <br>
        <table width="787" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >
        <tr> 
          <td width="778" align="center"> 
            <input name="BtnImprimir" type="button" id="BtnImprimir2" value="Imprimir" onClick='JavaScript:Imprimir();'>
            &nbsp; 
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');">
          </td>
        </tr>
      </table></td>
    </tr>
</form>
</body>
</html>
