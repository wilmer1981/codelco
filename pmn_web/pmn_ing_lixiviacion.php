<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 1;
	include("../principal/conectar_pmn_web.php");
	include('funciones/pmn_funciones.php'); 

	if(isset($_REQUEST["ModifLixi"])){
		$ModifLixi=$_REQUEST["ModifLixi"];
	}else{
		$ModifLixi="";
	}
	if(isset($_REQUEST["DiaModif"])){
		$DiaModif=$_REQUEST["DiaModif"];
	}else{
		$DiaModif="";
	}
	if(isset($_REQUEST["MesModif"])){
		$MesModif=$_REQUEST["MesModif"];
	}else{
		$MesModif="";
	}
	if(isset($_REQUEST["AnoModif"])){
		$AnoModif=$_REQUEST["AnoModif"];
	}else{
		$AnoModif="";
	}
	if(isset($_REQUEST["TurnoModif"])){
		$TurnoModif=$_REQUEST["TurnoModif"];
	}else{
		$TurnoModif="";
	}
	if(isset($_REQUEST["NumLixModif"])){
		$NumLixModif=$_REQUEST["NumLixModif"];
	}else{
		$NumLixModif="";
	}
	if(isset($_REQUEST["FechaModif"])){
		$FechaModif=$_REQUEST["FechaModif"];
	}else{
		$FechaModif="";
	}
	if(isset($_REQUEST["Tab6"])){
		$Tab6=$_REQUEST["Tab6"];
	}else{
		$Tab6=false;
	}


	if(isset($_REQUEST["Modif"])){
		$Modif=$_REQUEST["Modif"];
	}else{
		$Modif="";
	}

	$TxtPorcAgua = 0;	
	$TxtPorcAgua2 = 0;	
	$TxtPorcAgua3 = 0;	
	$TxtPorcAgua4 = 0;	
	$TxtPorcAgua5 = 0;	
	$TxtNumLixiv="";
	$TxtLixiv="";
	$TxtAcidc=0;
	$Operador="";
	$Observacion="";
	$TxtBAD=0;
	$PorcHum=0;
	$StkBAD=0;
	if ($ModifLixi == "S")
	{
		$Dia = $DiaModif;
		$Mes = $MesModif;
		$Ano = $AnoModif;
		$Turno = $TurnoModif;
		$FechaConsulta = $AnoModif."-".$MesModif."-".$DiaModif;
		$sql = "select * from lixiviacion_barro_anodico where ";
		$sql.= " num_lixiviacion = '".$NumLixModif."' and ";
		$sql.= " fecha = '".$FechaModif."'  ";
		$sql.= " and turno = '".$TurnoModif."'";
		$result = mysqli_query($link, $sql);
		if ($row=mysqli_fetch_array($result))
		{
		$Fecha=$row["fecha"];
		$TxtNumLixiv = $row["num_lixiviacion"];
		$TxtLixiv = $row["lixiviador"];
		$TxtAcidc = $row["acidc"];
		//$DiaLixiv = $row[dia_carga];
		$DiaLixiv = intval(substr($row["fecha_carga"],8,2));
		$MesLixiv = intval(substr($row["fecha_carga"],5,2));
		$AnoLixiv = intval(substr($row["fecha_carga"],0,4));
		$HoraLixiv = substr($row["hora_carga"],0,2);
		$MinutosLixiv = substr($row["hora_carga"],3,2);
		$Operador = $row["operador"];
		//echo $Operador;
		$JefeTurno = $row["jefe_turno"];
		$DiaAnalisis = intval(substr($row["fecha_analisis"],8,2));
		$MesAnalisis = intval(substr($row["fecha_analisis"],5,2));
		$AnoAnalisis = intval(substr($row["fecha_analisis"],0,4));
		$HoraAnalisis = substr($row["hora_analisis"],0,2);
		$MinutosAnalisis = substr($row["hora_analisis"],3,2);
		$DiaFiltracion = intval(substr($row["fecha_filtracion"],8,2));
		$MesFiltracion = intval(substr($row["fecha_filtracion"],5,2));
		$AnoFiltracion = intval(substr($row["fecha_filtracion"],0,4));
		$Observacion=$row["observacion"];
		$HoraFiltra = substr($row["hora_filtracion"],0,2);
		$MinutosFiltra = substr($row["hora_filtracion"],3,2);
		$PorcHum	=$row["porc_agua"];

		$StkBAD	=$row["stock_bad"];
		$TxtHoraFiltra = substr($row["hora_filtracion"],0,2);
		$TxtMinutosFiltra = substr($row["hora_filtracion"],3,2);
		if ($row["bad"] == 0)
			$TxtBAD = "";
		else
			$TxtBAD = $row["bad"];
		$OperadorAnalisis = $row["operador_analisis"];
		$JefeTurnoAnalisis = $row["jefe_turno_analisis"];
		}
		else
		{
			echo "Error No se encuentran los Datos";
		}
	}
	if ($ModifLixi == "L")
	{
		$Turno = $TurnoModif;
		$sql = "select * from lixiviacion_barro_anodico where ";
		$sql.= " num_lixiviacion = '".$NumLixModif."'";
		$sql.= " and turno = '".$TurnoModif."'";
		$sql.= " and fecha = '".$FechaModif."'";
		$result = mysqli_query($link, $sql);
		if ($row=mysqli_fetch_array($result))
		{
		$Fecha=$row["fecha"];
		$Dia = substr($Fecha,8,2);
		$Mes = substr($Fecha,5,2);
		$Ano = substr($Fecha,0,4);
		$TxtNumLixiv = $row["num_lixiviacion"];
		$TxtLixiv = $row["lixiviador"];
		$TxtAcidc = $row["acidc"];
		//$DiaLixiv = $row[dia_carga];
		$DiaLixiv = intval(substr($row["fecha_carga"],8,2));
		$MesLixiv = intval(substr($row["fecha_carga"],5,2));
		$AnoLixiv = intval(substr($row["fecha_carga"],0,4));
		$HoraLixiv = substr($row["hora_carga"],0,2);
		$MinutosLixiv = substr($row["hora_carga"],3,2);
		$Operador = $row["operador"];
		$JefeTurno = $row["jefe_turno"];
		$DiaAnalisis = intval(substr($row["fecha_analisis"],8,2));
		$MesAnalisis = intval(substr($row["fecha_analisis"],5,2));
		$AnoAnalisis = intval(substr($row["fecha_analisis"],0,4));
		$HoraAnalisis = substr($row["hora_analisis"],0,2);
		$MinutosAnalisis = substr($row["hora_analisis"],3,2);
		$DiaFiltracion = intval(substr($row["fecha_filtracion"],8,2));
		$MesFiltracion = intval(substr($row["fecha_filtracion"],5,2));
		$AnoFiltracion = intval(substr($row["fecha_filtracion"],0,4));
		$Observacion=$row["observacion"];
		$HoraFiltra = substr($row["hora_filtracion"],0,2);
		$MinutosFiltra = substr($row["hora_filtracion"],3,2);
		$TxtHoraFiltra = substr($row["hora_filtracion"],0,2);
		$TxtMinutosFiltra = substr($row["hora_filtracion"],3,2);
		if ($row["bad"] == 0)
			$TxtBAD = "";
		else
			$TxtBAD = $row["bad"];

		$PorcHum	=$row["porc_agua"];
		$StkBAD	    =$row["stock_bad"];
		$OperadorAnalisis = $row["operador_analisis"];
		$JefeTurnoAnalisis = $row["jefe_turno_analisis"];
		}
		else
		{
			echo "Error No se encuentran los Datos";
		}
	}	
	
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_pmn_web.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">

function TeclaPulsada1Lixi1(salto) 
{ 
	var f=document.frmPrincipalRpt;
	
	var largo_lixi1=(f.TxtNumLixiv.value);
	var l;
	var i;
	var p=0;
	var teclaCodigo = event.keyCode; 	
	
	if (teclaCodigo == 13 ||  teclaCodigo == 9)
	{		
		l=largo_lixi1.length;
		for(i=0; i<=l;i++)
		{
			a=largo_lixi1.substr(i,1);
			if (a=='-')
			{
				alert("Error, No debe Ingresar Guión... ");
				f.TxtNumLixiv.value ='';
				
				p=1;
				return;
			}	
			
		}
		
		if (p==0)
		{
			
			eval("f." + salto + ".focus();");	
		}	
	}
}
/*function CalculaTot()
{
	var ValorLixi=document.getElementById('TxtBAD2').value.replace('.','');
	
	ValorLixi=ValorLixi.replace(',','.');
	ValorLixi=parseFloat(ValorLixi);
	
	var Valor1=parseFloat(document.getElementById('TxtPorcAgua').value.replace(',','.'));
	var ValorFinal=ValorLixi-(ValorLixi*Valor1/100);
	var Valor2=parseFloat(document.getElementById('TxtPorcAgua2').value.replace(',','.'));
	var ValorFinal=ValorFinal-(ValorFinal*Valor2/100);
	var Valor3=parseFloat(document.getElementById('TxtPorcAgua3').value.replace(',','.'));
	var ValorFinal=ValorFinal-(ValorFinal*Valor3/100);
	var Valor4=parseFloat(document.getElementById('TxtPorcAgua4').value.replace(',','.'));
	var ValorFinal=ValorFinal-(ValorFinal*Valor4/100);
	var Valor5=parseFloat(document.getElementById('TxtPorcAgua5').value.replace(',','.'));
	var ValorFinal=ValorFinal-(ValorFinal*Valor5/100);
	document.getElementById('TotBADFinal').innerHTML=	decimales(ValorFinal,2);
	document.getElementById('TotInputBAD').value=	decimales(ValorFinal,2);
}*/


function ValidaCamposLixi1()
{
	var f=document.frmPrincipalRpt;
	
	//-----------VALIDA QUE FECHA NO SEA MAYOR------------------
	if ((parseInt(f.D_Actual.value) < parseInt(f.Dia.value)) &&
		(parseInt(f.M_Actual.value) == parseInt(f.Mes.value)) &&
		(parseInt(f.A_Actual.value) == parseInt(f.Ano.value)))
	{

		alert("El Dia no puede ser Mayor al Actual");
		f.Dia.focus();
		return false;
	}
	if ((parseInt(f.M_Actual.value) < parseInt(f.Mes.value)) &&
		(parseInt(f.A_Actual.value) == parseInt(f.Ano.value)))
	{

		alert("El Mes no puede ser Mayor al Actual");
		f.Mes.focus();
		return false;
	}
	if (parseInt(f.A_Actual.value) < parseInt(f.Ano.value))
	{
		alert("El Año no puede ser Mayor al Actual");
		f.Ano.focus();
		return false;
	}
	//-------------------------------------------------------------
	if (f.Reproceso.checked == true)
	{
		f.TxtNumLixiv.value = "Rep";
		//f.TxtLixiv.value = "Rep";
	}
	else
	{
		if (f.TxtNumLixiv.value == "")
		{
			alert("Debe ingresar Numero de Lixiviacion");
			f.TxtNumLixiv.focus();
			return false;
		}
		if (f.TxtLixiv.value == "")
		{
			alert("Debe ingresar Lixiviador");
			f.TxtLixiv.focus();
			return false;
		}	
	}
	if (f.TxtAcidc.value == "")
	{
		alert("Debe ingresar Acidc");
		f.TxtAcidc.focus();
		return false;
	}	
	if (f.Operador.value == "S")
	{
		alert("Debe seleccionar Operador");
		f.Operador.focus();
		return false;
	}	
	/*if (f.JefeTurno.value == "S")
	{
		alert("Debe seleccionar Jefe de Turno");
		f.JefeTurno.focus();
		return false;
	}*/	
	/*if (f.TxtPorcCu.value == "")
	{
		alert("Debe ingresar Porcentaje de Cobre (%Cu)");
		f.TxtPorcCu.focus();
		return false;
	}	
	if (f.TxtBAD.value == "")
	{
		alert("Debe ingresar cantidad de B.A.D.");
		f.TxtBAD.focus();
		return false;
	}	
	if (f.OperadorAnalisis.value == "S")
	{
		alert("Debe seleccionar Operador de Analisis");
		f.Operador.focus();
		return false;
	}	
	if (f.JefeTurnoAnalisis.value == "S")
	{
		alert("Debe seleccionar Jefe de Turno de Analisis");
		f.JefeTurnoAnalisis.focus();
		return false;
	}	*/
	return true;
}
function ProcesoLixiVer(opt,Mod,F,F2)//la opcion y la variable Modiif 
{	
	//alert("aca")
	var f=document.frmPrincipalRpt;
	switch (opt)
	{
		case "G":  //GRABA DATOS
			var Valor = ValidaCamposLixi1()
			if (Valor)
			{
				f.action = "pmn_ing_lixiviacion01.php?Proceso=" + opt;
				f.submit();
			}
			else
			{
				return;
			}
			break
		case "A": //ACTUALIZA DATOS
			Fe=F;
			var Valor = ValidaCamposLixi1()
			if (Valor)
			{
				f.action = "pmn_ing_lixiviacion01.php?Proceso=" + opt + "&Modif="+Mod +"&FechaModif="+Fe + "&Fecha="+F2 ;
				f.submit();
			}
			else
			{
				return;
			}
			break
		case "R": //VALIDA CUANDO SE PINCHA LA OPCION DE REPROCESO
			if (f.Reproceso.checked == true)
			{
				f.TxtNumLixiv.value = "Rep";
				//f.TxtLixiv.value = "Rep";
			}
			break
		case "V": //VER DIA
			var URL = "pmn_ing_lixiviacion02.php?Dia=" + f.Dia.value + "&Mes=" + f.Mes.value + "&Ano=" + f.Ano.value;
			window.open(URL,"","top=120,left=10,width=740,height=350,menubar=no,resizable=yes,scrollbars=yes,status=yes");
			break
		case "C": //CANCELAR
			f.action = "pmn_ing_lixiviacion01.php?Proceso=" + opt;
			f.submit();
			break
		case "I": //IMPRIMIR
			window.print();
			break
		case "S":  //SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=101";
			f.submit();
			break
		case "L": //VER lixiviacion sola
			//var URL = "pmn_ing_lixiviacion03.php?NumLix=" + f.TxtNumLixiv.value;
			var URL = "pmn_ing_lixiviacion03.php?NumLix=" + f.TxtNumLixiv.value+"&Dia=" + f.Dia.value + "&Mes=" + f.Mes.value + "&Ano=" + f.Ano.value;
			window.open(URL,"","top=120,left=10,width=740,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break
		case "Humedad":	//INGRESO DE HUMEDAD
			var URL = "pmn_ing_lixiviacion04.php?NumLix=" + f.TxtNumLixiv.value+"&Dia=" + f.Dia.value + "&Mes=" + f.Mes.value + "&Ano=" + f.Ano.value+"&Turno="+f.Turno.value;
			window.open(URL,"","top=200,left=400,width=400,height=150,menubar=no,resizable=yes,scrollbars=yes");
		break;
	}
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="3" topmargin="0">
<!--<form name="frmPrincipalLixi1Ano" action="" method="post">-->
<form name="frmPrincipalRpt" action="" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="TituloCabeceraOz">
  <tr>
      <td align="center" valign="top"> 
        <table width="100%" height="56" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr> 
          <td width="42" height="28" class="titulo_azul">Fecha</td>
          <td width="606"> 
    <?php
	if ($ModifLixi == "S" || $ModifLixi == "L")
	{
		if ($Ver=="S")
		{
			$Dia=$D;
			$Mes=$M;
			$Ano=$A;
		}
		echo "<font>".$Dia."-".$Mes."-".$Ano."</font>";
		echo "<input type='hidden' name='Dia' value='".$Dia."'>";
		echo "<input type='hidden' name='Mes' value='".$Mes."'>";
		echo "<input type='hidden' name='Ano' value='".$Ano."'>";
	}
	else
	{		
     	echo "<select name='Dia'>\n";
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($Dia))
			{
				//echo "dia:".$Dia;
				if ($Dia == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				//echo "diaActual:".$DiaActual;
				if ($i == $DiaActual)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		echo "</select> <select name='Mes'>\n";
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
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		echo "</select> <select name='Ano'>\n";
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
				if ($i == $AnoActual)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
        echo "</select>\n";
	}
?>          </td>
          <td width="29" class="titulo_azul">Turno</td>
          <td width="78">
            <?php
	if ($ModifLixi == "S" || $ModifLixi == "L")
	{
		$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase='".$Turno."' ";
		$result2 = mysqli_query($link, $sql);
		if ($row2=mysqli_fetch_array($result2))
			echo "<font>".strtoupper($row2["nombre_subclase"])."</font>";
		else	echo "<font>N</font>";
		echo "<input type='hidden' name='Turno' value='".$Turno."'>";
	}
	else
	{		
		echo "<select name='Turno' style='width:50'>\n";
		$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase not in('2') order by valor_subclase1 ";
		$result = mysqli_query($link, $sql);
		while ($row=mysqli_fetch_array($result))
		{
			if ($Turno == $row["cod_subclase"])
				echo "<option selected value='".$row["cod_subclase"]."'>".strtoupper($row["nombre_subclase"])."</option>\n";
			else	echo "<option value='".$row["cod_subclase"]."'>".strtoupper($row["nombre_subclase"])."</option>\n";
		}
		echo "</select>\n";
		//echo $sql."<br>";
	}
?>          </td>
          <td width="300">
            <?php
		//echo "modif:    ".$Modif;
		if (($Modif == "S") || ($Modif == "L"))
			echo "<input type='button' name='btnCancel' value='Cancelar' onClick=ProcesoLixiVer('C');>\n";
		else	
			echo "<input type='button' name='btnVerDia' value='Ver Dia' onClick=ProcesoLixiVer('V');>\n";
		?>          </td>
        </tr>
      </table>
        <br>
		<table width="100%" border="0" cellspacing="0" cellpadding="3" class="TablaDetalle">
          <tr class="TituloCabeceraAzul"> 
            <td colspan="8"><strong >LIXIVIACION</strong></td>
          </tr>
          <tr> 
            <td width="2" rowspan="3">&nbsp; </td>
            <td width="96" class="titulo_azul"># Lixiviacion</td>
            <td> <input name="TxtNumLixiv" type="text" id="TxtNumLixiv" value="<?php echo $TxtNumLixiv ?>" OnKeyDown="TeclaPulsada1Lixi1('TxtLixiv')" size="7" maxlength="7"></td>
            <td width="302" align="right" class="titulo_azul">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="170" class="titulo_azul">Lixiviador</td>
            <td colspan="3"><input name="TxtLixiv" type="text" id="TxtLixiv" value="<?php echo $TxtLixiv; ?>" size="7" maxlength="7">
            <input name="BtnLixiviacion" type="button" id="BtnLixiviacion" value="Ver Lixiv" onClick="ProcesoLixiVer('L')">            <strong> 
              <input name="Reproceso" type="hidden" id="Reproceso2" value="0" onClick="ProcesoLixiVer('R');">
            <!--Reproceso-->
            </strong></td>
          </tr>
          <tr> 
            <td align="left" valign="middle" class="titulo_azul">Acidc</td>
            <td width="112" align="left" valign="middle">
            <input name="TxtAcidc" type="text" id="TxtAcidc3" value="<?php echo number_format($TxtAcidc,2,',','.'); ?>" onKeyDown="SoloNumeros(true,this)" size="10" maxlength="10">            </td>
            <td width="302" align="right" valign="middle" class="titulo_azul">&nbsp;</td>
            <td align="left" valign="middle"><span class="titulo_azul">Fecha Carga</span></td>
            <td colspan="3" align="left" valign="middle"><select name="DiaLixiv">
              <?php
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($DiaLixiv))
					{
						if ($DiaLixiv == $i)
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
				?>
            </select>
              <select name='MesLixiv' id="select6">
                <?php
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($MesLixiv))
					{
						if ($MesLixiv == $i)
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
					else
					{
						if ($i == $MesActual)
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
				}
				?>
              </select>
              <select name='AnoLixiv' id="select8">
                <?php
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($AnoLixiv))
					{
						if ($AnoLixiv == $i)
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
				?>
              </select>
Hora
<select name="HoraLixiv" id="select10">
  <?php
			for ($i=0;$i<=23;$i++)
			{
				if ($i<10)
					$Valor = "0".$i;
				else	$Valor = $i;
				if (isset($HoraLixiv))
				{	
					if ($HoraLixiv == $Valor)
						echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
					else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
				}
				else
				{	
					if ($HoraActual == $Valor)
						echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
					else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
				}
			}
		?>
</select>
<strong>:</strong>
<select name="MinutosLixiv">
  <?php
			for ($i=0;$i<=59;$i++)
			{
				if ($i<10)
					$Valor = "0".$i;
				else	$Valor = $i;
				if (isset($MinutosLixiv))
				{	
					if ($MinutosLixiv == $Valor)
						echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
					else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
				}
				else
				{
					echo "<option value='".$Valor."'>".$Valor."</option>\n";		
				}
			}
		?>
</select></td>
          </tr>
          <tr> 
            <td align="left" valign="middle" class="titulo_azul">Operador</td>
            <td colspan="2" align="left" valign="middle">
                <select name="Operador" id="select14" style="width:200px">
                  <option value="S">Seleccionar</option>
                  <?php
				   LlenaCombosPersonalPmn($Operador,'2',$link);
				  ?>
            </select><?php //echo $sql;?>            </td>
            <td align="left" valign="middle" class="titulo_azul">&nbsp;</td>
            <td width="582" align="left" valign="middle">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td align="left" valign="middle" class="titulo_azul">Observaci&oacute;n</td>
            <td colspan="6" align="left" valign="middle">
                <textarea name="Observacion" style="width:500px;"><?php echo $Observacion; ?></textarea></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td align="center" valign="middle">&nbsp;</td>
            <td colspan="6" align="center" valign="middle">&nbsp;</td>
          </tr>
        </table>
       	 <br>
       	<table width="100%" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
<!--          <tr class="TituloCabeceraAzul"> 
            <td colspan="10"><strong>ANALISIS</strong></td>
          </tr>
         <tr> 
            <td width="4">&nbsp;</td>
            <td width="141" valign="middle" class="titulo_azul">Fecha Analisis</td>
            <td colspan="5" valign="middle"> <strong> </strong> 
              <select name='DiaAnalisis'>
                <?php
	  	/*for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaAnalisis))
			{
				if ($DiaAnalisis == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == $DiaActual)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}*/
		?>
              </select> <select name='MesAnalisis'>
                <?php
		/*for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesAnalisis))
			{
				if ($MesAnalisis == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}*/
		?>
              </select> <select name='AnoAnalisis'>
                <?php
		/*for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoAnalisis))
			{
				if ($AnoAnalisis == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == $AnoActual)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}*/
		?>
              </select> &nbsp;Hora 
              <select name="HoraAnalisis" id="select15">
                <?php
			/*for ($i=0;$i<=23;$i++)
			{
				if ($i<10)
					$Valor = "0".$i;
				else	$Valor = $i;
				if (isset($HoraAnalisis))
				{	
					if ($HoraAnalisis == $Valor)
						echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
					else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
				}
				else
				{	
					if ($HoraActual == $Valor)
						echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
					else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
				}
			}*/
		?>
              </select> <strong>:</strong> <select name="MinutosAnalisis" id="select16">
                <?php
			/*for ($i=0;$i<=59;$i++)
			{
				if ($i<10)
					$Valor = "0".$i;
				else	$Valor = $i;
				if (isset($MinutosAnalisis))
				{	
					if ($MinutosAnalisis == $Valor)
						echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
					else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
				}
				else
				{
					echo "<option value='".$Valor."'>".$Valor."</option>\n";		
				}
			}*/
			?>
              </select> </strong><strong> </strong><strong> </strong></td>
            <td valign="middle" class="titulo_azul">Cu (%)</td>
            <td width="127" valign="middle"><strong> --> 
              <input name="TxtPorcCu" type="hidden" id="TxtPorcCu2" value="0" size="17" maxlength="7">
           <!--</strong></td>
            <td width="160" valign="middle"><strong> </strong></td>
          </tr>-->
          <tr class="TituloCabeceraAzul"> 
            <td colspan="10"><strong> </strong><strong>FILTRACION </strong></td>
          </tr>
          <tr> 
            <td width="28">&nbsp;</td>
            <td width="172" class="titulo_azul">Fecha Filtrado</td>
            <td colspan="4"><select name='DiaFiltracion' id="select">
                <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFiltracion))
			{
				if ($DiaFiltracion == $i)
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
		?>
              </select> <select name='MesFiltracion' id="select2">
                <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFiltracion))
			{
				if ($MesFiltracion == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
              </select> <select name='AnoFiltracion' id="select3">
                <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFiltracion))
			{
				if ($AnoFiltracion == $i)
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
		?>
              </select> &nbsp;Hora<strong> 
              <select name="HoraFiltra" id="select4">
                <?php
			for ($i=0;$i<=23;$i++)
			{
				if ($i<10)
					$Valor = "0".$i;
				else	$Valor = $i;
				if (isset($HoraFiltra))
				{	
					if ($HoraFiltra == $Valor)
						echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
					else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
				}
				else
				{	
					if ($HoraActual == $Valor)
						echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
					else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
				}
			}
		?>
              </select>
              : 
              <select name="MinutosFiltra" id="select7">
                <?php
			for ($i=0;$i<=59;$i++)
			{
				if ($i<10)
					$Valor = "0".$i;
				else	$Valor = $i;
				if ($MinutosFiltra!="")
				{	
					if ($MinutosFiltra == $Valor)
						echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
					else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
				}
				else
				{
					echo "<option value='".$Valor."'>".$Valor."</option>\n";		
				}
			}
		?>
              </select>
              </strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="1">&nbsp;</td>
            <td width="32">&nbsp;</td>
          </tr>
		  <?php
			$TotFinal=$TxtBAD-($TxtBAD*$PorcHum/100);
		  ?>
          <tr> 
            <td>&nbsp;</td>
            <td><strong class="titulo_azul">B.A.D. (Peso) </strong></td>
            <td width="63"><strong>
            <input name="TxtBAD" type="text" id="TxtBAD2" value="<?php echo number_format($TxtBAD,0,',','.'); ?>" size="10" onKeyDown="SoloNumeros(true,this)" maxlength="10"></strong></td>
            <td width="576" class="TituloCabeceraOz"><?php if($ModifLixi=='S' && number_format($TotFinal,2,',','.')==number_format($StkBAD,2,',','.')){?>
            <input type="button" name="HumedadIng" value="Ingresar Humedad" onClick="ProcesoLixiVer('Humedad')"><?php }
			if(number_format($TotFinal,2,',','.')!=number_format($StkBAD,2,',','.')){ echo "Stock BAD ya tiene descuentos en conformación de lotes.";}?></td>
            <td width="99" class="titulo_azul">% Humedad</td>
            <td width="90" class="titulo_azul"><?php echo number_format($PorcHum,2,',','.');?></td>
            <td width="88" class="titulo_azul">Stock BAD </td>
            <td width="103" class="titulo_azul"><?php echo number_format($StkBAD,2,',','.');?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td class="titulo_azul">Operador</td>
            <td colspan="3"><strong>
              <select name="OperadorAnalisis" id="select11" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
				LlenaCombosPersonalPmn($OperadorAnalisis,'2',$link);
				?>
              </select>
              </strong></td>
            <td class="titulo_azul">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
          </tr>
        </table>
			<table width="100%">
			  <tr align="center" valign="middle"> 
				<?php 
				if (($ModifLixi == "S")|| ($ModifLixi=="L"))
				{
					echo "<td width=88><input type='button' name='btnActualizar' value='Actualizar' style='width:70px' onClick=ProcesoLixiVer('A','".$ModifLixi."','".$FechaModif."','".$Fecha."');></td>\n";
				}
				else
				{
					echo "<td width=88><input type='button' name='btnGrabar' value='Grabar' style='width:70px' onClick=ProcesoLixiVer('G');></td>\n";
				}
				?>
				<td width="88">
				<input type="button" name="btnGenerarSA" value="Imprimir" style="width:70px" onClick="ProcesoLixiVer('I');">
			    </td>
				<td width="107"><input type="button" name="Cancelar" value="Cancelar" onClick="ProcesoLixiVer('C')">&nbsp;</td>
			  </tr>
		</table>
	</td>
  </tr>
</table>  			
<input type="hidden" name="D_Actual" value="<?php echo $DiaActual?>">
<input type="hidden" name="M_Actual" value="<?php echo $MesActual?>">
<input type="hidden" name="A_Actual" value="<?php echo $AnoActual?>">
</form>
</body>
</html>
<script language="javascript">
//CalculaTot();
</script>
<?php  
 if ($TxtPorcAgua > 100)
 {
		echo "<script languaje='JavaScript'>";
		echo "alert('% de H2O debe ser menor de 100 ');";
		//echo "<input name='TxtPorcAgua' type='text'  value=' ' size='17' maxlength='7'>";
		echo "</script>";
}
 ?>
