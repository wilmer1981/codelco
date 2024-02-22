<?php
	include("../principal/conectar_principal.php");
	$CodigoDeSistema = 2;
	//$CodigoDePantalla = 11;	
	$CodigoDePantalla = 48;	
	if(isset($_REQUEST["Proceso"])) {
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = '';
	}

	/******************Modificar********************************* */
	//Modif=S&Hornada=202201&Horno=0&FechaHora=2022-01-01%2016:26:11
	if(isset($_REQUEST["Hornada"])) {
		$Hornada = $_REQUEST["Hornada"];
	}else{
		$Hornada = "";
	}
	if(isset($_REQUEST["Horno"])) {
		$Horno = $_REQUEST["Horno"];
	}else{
		$Horno = "";
	}
	if(isset($_REQUEST["FechaHora"])) {
		$FechaHora = $_REQUEST["FechaHora"];
	}else{
		$FechaHora = "";
	}
	/********************************************** */

	if(isset($_REQUEST["ano"])) {
		$ano = $_REQUEST["ano"];
	}else{
		$ano = date("Y");
	}
	if(isset($_REQUEST["mes"])) {
		$mes = $_REQUEST["mes"];
	}else{
		$mes = date("m");
	}
	if(isset($_REQUEST["dia"])) {
		$dia = $_REQUEST["dia"];
	}else{
		$dia = date("d");
	}
	if(isset($_REQUEST["TipoPesaje"])) {
		$TipoPesaje = $_REQUEST["TipoPesaje"];
	}else{
		$TipoPesaje = "";
	}
	if(isset($_REQUEST["PesoAuto"])) {
		$PesoAuto = $_REQUEST["PesoAuto"];
	}else{
		$PesoAuto = "";
	}
	if(isset($_REQUEST["Hornos"])) {
		$Hornos = $_REQUEST["Hornos"];
	}else{
		$Hornos = "";
	}
	if(isset($_REQUEST["num_hornada"])) {
		$num_hornada = $_REQUEST["num_hornada"];
	}else{
		$num_hornada = "";
	}
	if(isset($_REQUEST["Mensaje"])) {
		$Mensaje = $_REQUEST["Mensaje"];
	}else{
		$Mensaje = "";
	}

	if(isset($_REQUEST["UnidCorrientes"])) {
		$UnidCorrientes = $_REQUEST["UnidCorrientes"];
	}else{
		$UnidCorrientes = "";
	}
	if(isset($_REQUEST["Hora"])) {
		$Hora = $_REQUEST["Hora"];
	}else{
		$Hora = date("H");
	}
	if(isset($_REQUEST["Minutos"])) {
		$Minutos = $_REQUEST["Minutos"];
	}else{
		$Minutos = date("i");
	}
	

	if (!isset($dia))
	{
		//$ano = date("Y");
		//$mes = date("m");
		//$dia = date("d");
		$Fecha = date("Y-m-d");  
	}
	$Fecha = $ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($dia,2,"0",STR_PAD_LEFT); 


/********************************** 2 **************************************** */
//sea_ing_prod_vent_auto.php?Modif=S&GrupoModif=" + GrupoModif + "&LadoModif=" + LadoModif + "&FechaHora=" + FechaHoraModif
if(isset($_REQUEST["Modif"])) {
	$Modif = $_REQUEST["Modif"];
}else{
	$Modif = "";
}
if(isset($_REQUEST["GrupoModif"])) {
	$GrupoModif = $_REQUEST["GrupoModif"];
}else{
	$GrupoModif = "";
}

if(isset($_REQUEST["CorrModif"])) {
	$CorrModif = $_REQUEST["CorrModif"];
}else{
	$CorrModif = '';
}

if(isset($_REQUEST["LadoModif"])) {
	$LadoModif = $_REQUEST["LadoModif"];
}else{
	$LadoModif = "";
}

if(isset($_REQUEST["NumCarro"])) {
	$NumCarro = $_REQUEST["NumCarro"];
}else{
	$NumCarro = "";
}
if(isset($_REQUEST["NumRack"])) {
	$NumRack = $_REQUEST["NumRack"];
}else{
	$NumRack = "";
}
if(isset($_REQUEST["PesoCarro"])) {
	$PesoCarro = $_REQUEST["PesoCarro"];
}else{
	$PesoCarro = "";
}
if(isset($_REQUEST["PesoRack"])) {
	$PesoRack = $_REQUEST["PesoRack"];
}else{
	$PesoRack = "";
}

if(isset($_REQUEST["PesoBruto"])) {
	$PesoBruto = $_REQUEST["PesoBruto"];
}else{
	$PesoBruto = "";
}
if(isset($_REQUEST["PesoNeto"])) {
	$PesoNeto = $_REQUEST["PesoNeto"];
}else{
	$PesoNeto = "";
}

if(isset($_REQUEST["Parametros"])) {
	$Parametros = $_REQUEST["Parametros"];
}else{
	$Parametros = "";
}
if(isset($_REQUEST["UnidCorr"])) {
	$UnidCorr = $_REQUEST["UnidCorr"];
}else{
	$UnidCorr = "";
}
if(isset($_REQUEST["PesoCorr"])) {
	$PesoCorr = $_REQUEST["PesoCorr"];
}else{
	$PesoCorr = "";
}
if(isset($_REQUEST["Factor"])) {
	$Factor = $_REQUEST["Factor"];
}else{
	$Factor = "";
}
if(isset($_REQUEST["Grupo"])) {
	$Grupo = $_REQUEST["Grupo"];
}else{
	$Grupo = "";
}
if(isset($_REQUEST["Lado"])) {
	$Lado = $_REQUEST["Lado"];
}else{
	$Lado = "";
}
if(isset($_REQUEST["FechaCarga"])) {
	$FechaCarga = $_REQUEST["FechaCarga"];
}else{
	$FechaCarga = "";
}
if(isset($_REQUEST["UnidHM"])) {
	$UnidHM = $_REQUEST["UnidHM"];
}else{
	$UnidHM = "";
}
if(isset($_REQUEST["PesoHM"])) {
	$PesoHM = $_REQUEST["PesoHM"];
}else{
	$PesoHM = "";
}

/********************************** 3 ***************************** */
if(isset($_REQUEST["ChkFin"])) {
	$ChkFin = $_REQUEST["ChkFin"];
}else{
	$ChkFin = "";
}
if(isset($_REQUEST["NumCubas"])) {
	$NumCubas = $_REQUEST["NumCubas"];
}else{
	$NumCubas = "";
}
/********************************* 4 ************************************************* */
if(isset($_REQUEST["TipoTara"])) {
	$TipoTara = $_REQUEST["TipoTara"];
}else{
	$TipoTara = "";
}
if(isset($_REQUEST["Numero"])) {
	$Numero = $_REQUEST["Numero"];
}else{
	$Numero = "";
}


?>
<html>
<head>
<title>Producci�n de �nodos Ventana</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<!--<script language="VBScript">-->
<script type="text/vbscript">
	Function LeerArchivo(valor)	
		ubicacion = "c:\PesoMatic.txt"	
		Set fs = CreateObject("Scripting.FileSystemObject")
		Set file = fs.OpenTextFile(ubicacion,1,true) //Crea el archivo si no existe.
		
		//Validar si el peso del archivo ==  0 no leer. 
		
		Set file2 = fs.getFile(ubicacion) 
		tamano = file2.size	

		If (tamano <> 0)	Then
			valor = file.ReadLine
			LeerArchivo = valor
		Else
			LeerArchivo = valor
		End If

	End Function 
</script>

<script language="JavaScript">
function PesoAutomatico()
{	
	setTimeout("CapturaPeso()",500);

}	
/*****************/
function CapturaPeso()
{
	var f = document.formulario;
	if (f.checkpeso.checked == true)
		f.PesoBruto.value = LeerArchivo(f.PesoBruto.value);
		
	setTimeout("CapturaPeso()",200);		
}
/****************/
function TeclaPulsada(salto) 
{ 
	var f = document.formulario;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{
		eval("f." + salto + ".focus();");
	}	
	CalculaPesos();

}

//Solo para prod. restos de H.M.
function TeclaPulsadaHM(salto) 
{ 
	var f = document.formulario;
	if (salto == "Recarga")
	{	
		if (f.Grupo.value != "")
		{			
		<?php
			$GruposHM = "";
			$Condicion = "";
			//Grupos de Hojas Madre
			$Consulta = "SELECT DISTINCT t1.campo2 AS grupo, t2.nombre_subclase AS nombre ";
			$Consulta.= " FROM sea_web.movimientos AS t1";
			$Consulta.= " INNER JOIN  proyecto_modernizacion.sub_clase AS t2";
			$Consulta.= " ON t1.campo2 = t2.cod_subclase";
			$Consulta.= " WHERE t1.tipo_movimiento = 2 AND t2.cod_clase = 2004 AND t1.campo1 NOT IN ('T','M','N','S')";
			$Consulta.= " AND t1.numero_recarga = 0 ORDER BY t2.cod_subclase";				
			$Resp = mysqli_query($link, $Consulta);
			$Entro = false;
			while ($Fila = mysqli_fetch_array($Resp))
			{
				$Entro = true;
				$GruposHM = $GruposHM.$Fila["grupo"]."-";
				$Condicion = $Condicion."f.Grupo.value!=".$Fila["grupo"]." && ";
			}
			if ($GruposHM != "")
				$GruposHM =  substr($GruposHM,0,strlen($GruposHM)-1);
			if ($Condicion != "")
				$Condicion = substr($Condicion,0,strlen($Condicion)-4);
			if ($Entro)
			{
				echo "if (".$Condicion.")\n";
				echo "{\n";
				echo "alert(\"Los Grupos de H.M. son ".$GruposHM."\");\n";
				echo "f.Grupo.focus();\n";
				echo "return;\n";
				echo "}\n";
			}
		?>		
		}		
		f.action = "sea_ing_prod_vent_auto.php";
		f.submit();
		return;
	}
	else
	{
		var teclaCodigo = event.keyCode; 	
		if (teclaCodigo == 13)
		{		
			if (f.Grupo.value != "")
			{				
			<?php
				$GruposHM = "";
				$Condicion = "";
				//Grupos de Hojas Madre
				$Consulta = "SELECT DISTINCT t1.campo2 AS grupo, t2.nombre_subclase AS nombre ";
				$Consulta.= " FROM sea_web.movimientos AS t1";
				$Consulta.= " INNER JOIN  proyecto_modernizacion.sub_clase AS t2";
				$Consulta.= " ON t1.campo2 = t2.cod_subclase";
				$Consulta.= " WHERE t1.tipo_movimiento = 2 AND t2.cod_clase = 2004 AND t1.campo1 NOT IN ('T','M','S','N')";
				$Consulta.= " AND t1.numero_recarga = 0 ORDER BY t2.cod_subclase";				
				$Resp = mysqli_query($link, $Consulta);
				$Entro = false;
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Entro = true;
					$GruposHM = $GruposHM.$Fila["grupo"]."-";
					$Condicion = $Condicion."f.Grupo.value!=".$Fila["grupo"]." && ";
				}
				if ($GruposHM != "")
					$GruposHM =  substr($GruposHM,0,strlen($GruposHM)-1);
				if ($Condicion != "")
					$Condicion = substr($Condicion,0,strlen($Condicion)-4);
				if ($Entro)
				{
					echo "if (".$Condicion.")\n";
					echo "{\n";
					echo "alert(\"Los Grupos de H.M. son ".$GruposHM."\");\n";
					echo "f.Grupo.focus();\n";
					echo "return;\n";
					echo "}\n";
				}
			?>				
			}
			f.action = "sea_ing_prod_vent_auto.php";
			f.submit();
			return;
		}
	}
}

function TeclaPulsada_2(salto) 
{ 
	var f = document.formulario;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
	return;	
}

function Proceso(opt)
{
	var f = document.formulario;
    switch (opt)
	{
//******************************************************************************************************
//************************ PRODUCCION ANODOS VENTANA ***************************************************
//******************************************************************************************************	
		case "V_ProdAnodos":
			 //window.open("sea_ing_prod_vent_auto_anodos_det.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");
			 window.open("sea_ing_prod_vent_auto_anodos_det.php?Proceso=B&cmbproductos=-1&dia=" + f.dia.value + "&mes=" + f.mes.value + "&ano=" + f.ano.value, "","menubar=no resizable=yes Top=30 Left=50 width=550 height=500 scrollbars=yes");
			 break;
		case "V_PesadasProdAnodos":
			 //window.open("sea_ing_prod_vent_auto_anodos_det.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");
			 window.open("sea_ing_prod_vent_auto_anodos_det2.php?Proceso=B&Hornada=-1&Dia=" + f.dia.value + "&Mes=" + f.mes.value + "&Ano=" + f.ano.value, "","menubar=no resizable=yes Top=30 Left=50 width=630 height=500 scrollbars=yes");
			 break;
		case "V_InformeProdAnodos":
			 //window.open("sea_ing_prod_vent_auto_anodos_det.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");
			 window.open("sea_ing_prod_vent_auto_anodos_det3.php?Proceso=B&Hornada=-1&Dia=" + f.dia.value + "&Mes=" + f.mes.value + "&Ano=" + f.ano.value, "","menubar=no resizable=yes Top=30 Left=50 width=550 height=500 scrollbars=yes");
			 break;
		case "G_ProdAnodos":				
			if (f.Hornos.value == "S")
			{
				alert("Debe Seleccionar Horno");
				f.Hornos.focus();
				return;
			}
			if (f.num_hornada.value == "S")
			{
				alert("Debe Seleccionar Hornada");
				f.num_hornada.focus();
				return;
			}
			if (f.NumRueda.value == "")
			{
				alert("Debe Ingresar Rueda");
				f.NumRueda.focus();
				return;
			}
			else
			{
				if (parseInt(f.NumRueda.value)!=1 && parseInt(f.NumRueda.value)!=2)
				{
					alert("Las Ruedas son 1 y 2 solamente");
					f.NumRueda.focus();
					return;
				}
			}
			if (f.NumCarro.value == "")
			{
				alert("Debe Ingresar Numero de Carro");
				f.NumCarro.focus();
				return;
			}
			if (f.NumRack.value == "")
			{
				alert("Debe Ingresar Numero de Rack");
				f.NumRack.focus();
				return;
			}
			if (f.PesoCarro.value == "")
			{
				alert("Debe Ingresar Peso de Carro");
				f.PesoCarro.focus();
				return;
			}
			if (f.PesoRack.value == "")
			{
				alert("Debe Ingresar Peso de Rack");
				f.PesoRack.focus();
				return;
			}
			if (f.PesoBruto.value == "")
			{
				alert("Debe Ingresar Peso");
				f.PesoBruto.focus();
				return;
			}
			if (f.UnidCorrientes.value == "" && f.UnidEspeciales.value == "" && f.UnidHM.value == "")
			{
				alert("Debe Hacer la Distribucion de las Unidades");
				f.UnidCorrientes.focus();
				return;
			}
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkTipoAnodo" && f.elements[i].checked)
				{
					var Tipo=f.elements[i].value;
					if (Tipo=="HM" && (f.UnidCorrientes.value!="" || f.UnidEspeciales.value!=""))	
					{
						alert("Ud. marco que los Anodos son Hojas Madre\nPor lo tanto solo deben haber unidades de Hojas Madres");
						f.UnidHM.focus();
						return;
					}
					break;
				}
			}			
			f.action = "sea_ing_prod_vent_auto01.php?Proceso=" + opt;
			f.submit();
			break;
//******************************************************************************************************
//******************************* OPCIONES GENERALES ***************************************************
//******************************************************************************************************			
		case "S": //SALIR
			f.action ="../principal/sistemas_usuario.php?CodSistema=2";
			f.submit();
			break;
		case "V": //VER
			window.open("sea_ing_prod_vent02.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");
			break;
		case "R": //RECARGA
			f.action = "sea_ing_prod_vent_auto.php";
			f.submit();
			break;
		case "RN": //RECARGA NUEVA PAG. CON CAMPOS LIMPIOS
			f.action = "sea_ing_prod_vent_auto01.php?Proceso=" + opt;
			f.submit();
			break;
//******************************************************************************************************
//******************PRODUCCION RESTOS DE ANODOS CTTE Y RESTOS DE H.M. ***************************************************
//******************************************************************************************************			
		case "B_RestosAnodos": //BUSCA GRUPO LADO Y FECHA DE CARGA
			if (f.Grupo.value == "")
			{
				alert("Debe Ingresar Grupo");
				f.Grupo.focus();
				return;
			}
			else
			{
				if (parseInt(f.Grupo.value)<1 || parseInt(f.Grupo.value)>49)
				{
					alert("El Grupo debe estar entre 1 y 49");
					f.Grupo.focus();
					return;
				}
			}
			
			<?php
				$GruposHM = "";
				$Condicion = "";
				//Grupos de Hojas Madre
				$Consulta = "SELECT DISTINCT t1.campo2 AS grupo, t2.nombre_subclase AS nombre ";
				$Consulta.= " FROM sea_web.movimientos AS t1";
				$Consulta.= " INNER JOIN  proyecto_modernizacion.sub_clase AS t2";
				$Consulta.= " ON t1.campo2 = t2.cod_subclase";
				$Consulta.= " WHERE t1.tipo_movimiento = 2 AND t2.cod_clase = 2004 AND t1.campo1 NOT IN ('T','M','S','N')";
				$Consulta.= " AND t1.numero_recarga = 0 ORDER BY t2.cod_subclase";			
				
				$Resp = mysqli_query($link, $Consulta);
				$Entro = false;
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Entro = true;
					$GruposHM = $GruposHM.$Fila["grupo"]."-";
					$Condicion = $Condicion."f.Grupo.value==".$Fila["grupo"]." || ";
				}
				
				if ($GruposHM != "")
					$GruposHM =  substr($GruposHM,0,strlen($GruposHM)-1);
				if ($Condicion != "")
					$Condicion = substr($Condicion,0,strlen($Condicion)-4);
				if ($Entro)
				{
					echo "if (".$Condicion.")\n";
					echo "{\n";
					echo "alert(\"Los Grupos de H.M. son ".$GruposHM.", Debe Ingresar Otro Grupo\");\n";
					echo "f.Grupo.focus();\n";
					echo "return;\n";
					echo "}\n";
				}
			?>
			//alert ("Holaaaaa");
			f.action = "sea_ing_prod_vent_auto01.php?Proceso=B_RestosAnodos";
			f.submit();
			break;
		case "V_RestosAnodos":
			 window.open("sea_ing_prod_vent_auto_restos_ctte_det.php?Proceso=B&cmbproductos=-1&dia=" + f.dia.value + "&mes=" + f.mes.value + "&ano=" + f.ano.value, "","menubar=no resizable=yes Top=30 Left=50 width=550 height=500 scrollbars=yes");
			 break;
		case "V_PesadasRestosAnodos":			
			 window.open("sea_ing_prod_vent_auto_restos_ctte_det2.php?Proceso=B&Hornada=-1&Dia=" + f.dia.value + "&Mes=" + f.mes.value + "&Ano=" + f.ano.value, "","menubar=no resizable=yes Top=30 Left=50 width=630 height=500 scrollbars=yes");
			 break;
		case "V_InformeRestosAnodos":
			 window.open("sea_ing_prod_vent_auto_restos_ctte_det3.php?Proceso=B&Hornada=-1&Dia=" + f.dia.value + "&Mes=" + f.mes.value + "&Ano=" + f.ano.value, "","menubar=no resizable=yes Top=30 Left=50 width=630 height=500 scrollbars=yes");
			 break;
		case "G_RestosAnodos":				
			if (f.Grupo.value == "")
			{
				alert("Debe Ingresar Grupo");
				f.Grupo.focus();
				return;
			}
			else
			{
				if (parseInt(f.Grupo.value)<1 || parseInt(f.Grupo.value)>49)
				{
					alert("El Grupo debe estar entre 1 y 49");
					f.Grupo.focus();
					return;
				}
			}
			<?php
				$GruposHM = "";
				$Condicion = "";
				//Grupos de Hojas Madre
				$Consulta = "SELECT DISTINCT t1.campo2 AS grupo, t2.nombre_subclase AS nombre ";
				$Consulta.= " FROM sea_web.movimientos AS t1";
				$Consulta.= " INNER JOIN  proyecto_modernizacion.sub_clase AS t2";
				$Consulta.= " ON t1.campo2 = t2.cod_subclase";
				$Consulta.= " WHERE t1.tipo_movimiento = 2 AND t2.cod_clase = 2004 AND t1.campo1 NOT IN ('T','M','S','N')";
				$Consulta.= " AND t1.numero_recarga = 0 ORDER BY t2.cod_subclase";				
				$Resp = mysqli_query($link, $Consulta);
				$Entro = false;
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Entro = true;
					$GruposHM = $GruposHM.$Fila["grupo"]."-";
					$Condicion = $Condicion."f.Grupo.value==".$Fila["grupo"]." || ";
				}
				if ($GruposHM != "")
					$GruposHM =  substr($GruposHM,0,strlen($GruposHM)-1);
				if ($Condicion != "")
					$Condicion = substr($Condicion,0,strlen($Condicion)-4);
				if ($Entro)
				{
					echo "if (".$Condicion.")\n";
					echo "{\n";
					echo "alert(\"Los Grupos de H.M. son ".$GruposHM.", Debe Ingresar Otro Grupo\");\n";
					echo "f.Grupo.focus();\n";
					echo "return;\n";
					echo "}\n";
				}
			?>
			if (f.Lado.value == "")
			{
				alert("Debe Ingresar Lado");
				f.Lado.focus();
				return;
			}			
			if (f.NumCarro.value == "")
			{
				alert("Debe Ingresar Numero de Carro");
				f.NumCarro.focus();
				return;
			}
			if (f.NumRack.value == "")
			{
				alert("Debe Ingresar Numero de Rack");
				f.NumRack.focus();
				return;
			}
			if (f.PesoCarro.value == "")
			{
				alert("Debe Ingresar Peso de Carro");
				f.PesoCarro.focus();
				return;
			}
			if (f.PesoRack.value == "")
			{
				alert("Debe Ingresar Peso de Rack");
				f.PesoRack.focus();
				return;
			}
			if (f.NumCubas.value == "")
			{
				alert("Debe Ingresar Cantidad de Cubas que trae el Rack");
				f.NumCubas.focus();
				return;
			}			
			if (f.PesoBruto.value == "")
			{
				alert("Debe Ingresar Peso");
				f.PesoBruto.focus();
				return;
			}	
			f.action = "sea_ing_prod_vent_auto01.php?Proceso=" + opt;
			f.submit();
			break;
		case "M_RestosAnodos":				
			if (f.Grupo.value == "")
			{
				alert("Debe Ingresar Grupo");
				f.Grupo.focus();
				return;
			}
			else
			{
				if (parseInt(f.Grupo.value)<1 || parseInt(f.Grupo.value)>49)
				{
					alert("El Grupo debe estar entre 1 y 49");
					f.Grupo.focus();
					return;
				}
			}
			<?php
				$GruposHM = "";
				$Condicion = "";
				//Grupos de Hojas Madre
				$Consulta = "SELECT DISTINCT t1.campo2 AS grupo, t2.nombre_subclase AS nombre ";
				$Consulta.= " FROM sea_web.movimientos AS t1";
				$Consulta.= " INNER JOIN  proyecto_modernizacion.sub_clase AS t2";
				$Consulta.= " ON t1.campo2 = t2.cod_subclase";
				$Consulta.= " WHERE t1.tipo_movimiento = 2 AND t2.cod_clase = 2004 AND t1.campo1 NOT IN ('T','M','S','N')";
				$Consulta.= " AND t1.numero_recarga = 0 ORDER BY t2.cod_subclase";				
				$Resp = mysqli_query($link, $Consulta);
				$Entro = false;
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Entro = true;
					$GruposHM = $GruposHM.$Fila["grupo"]."-";
					$Condicion = $Condicion."f.Grupo.value==".$Fila["grupo"]." || ";
				}
				if ($GruposHM != "")
					$GruposHM =  substr($GruposHM,0,strlen($GruposHM)-1);
				if ($Condicion != "")
					$Condicion = substr($Condicion,0,strlen($Condicion)-4);
				if ($Entro)
				{
					echo "if (".$Condicion.")\n";
					echo "{\n";
					echo "alert(\"Los Grupos de H.M. son ".$GruposHM.", Debe Ingresar Otro Grupo\");\n";
					echo "f.Grupo.focus();\n";
					echo "return;\n";
					echo "}\n";
				}
			?>			
			if (f.Lado.value == "")
			{
				alert("Debe Ingresar Lado");
				f.Lado.focus();
				return;
			}			
			if (f.NumCarro.value == "")
			{
				alert("Debe Ingresar Numero de Carro");
				f.NumCarro.focus();
				return;
			}
			if (f.NumRack.value == "")
			{
				alert("Debe Ingresar Numero de Rack");
				f.NumRack.focus();
				return;
			}
			if (f.PesoCarro.value == "")
			{
				alert("Debe Ingresar Peso de Carro");
				f.PesoCarro.focus();
				return;
			}
			if (f.PesoRack.value == "")
			{
				alert("Debe Ingresar Peso de Rack");
				f.PesoRack.focus();
				return;
			}
			if (f.NumCubas.value == "")
			{
				alert("Debe Ingresar Cantidad de Cubas que trae el Rack");
				f.NumCubas.focus();
				return;
			}			
			if (f.PesoBruto.value == "")
			{
				alert("Debe Ingresar Peso");
				f.PesoBruto.focus();
				return;
			}			
			f.action = "sea_ing_prod_vent_auto01.php?Proceso=" + opt;
			f.submit();
			break;
//******************************************************************************************************
//*************************** TARA DE RACKS Y CARROS ***************************************************
//******************************************************************************************************			
		case "G_Tara": //GRABA TARA
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="TipoTara" && f.elements[i].checked)
				{
					var Tipo=f.elements[i].value;			
					break;
				}
			}
			switch (Tipo)
			{
				case "C":
					var RC="Carro";
					break;
				case "R":			
					var RC="Rack";
					break;
			}		
			if (f.Numero.value == "")
			{
				alert("Debe Ingresar Numero de " + RC );
				f.Numero.focus();
				return;
			}
			if (f.PesoBruto.value == "" || f.PesoBruto.value == "0")
			{
				alert("Debe Ingresar Peso de " + RC );
				f.PesoBruto.focus();
				return;
			}
			f.action = "sea_ing_prod_vent_auto01.php?Proceso=" + opt;
			f.submit();
			break;
		case "E_Tara": //ELIMINA TARA			
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="TipoTara" && f.elements[i].checked)
				{
					var Tipo=f.elements[i].value;			
					break;
				}
			}			
			switch (Tipo)
			{
				case "C":
					var RC="Carro";
					break;
				case "R":			
					var RC="Rack";
					break;
			}		
			if (f.Numero.value == "")
			{
				alert("Debe Ingresar Numero de " + RC );
				f.Numero.focus();
				return;
			}
			var msg=confirm("�Seguro que desea Eliminar este " + RC + "?");
			if (msg==true)
			{
				f.action = "sea_ing_prod_vent_auto01.php?Proceso=" + opt;
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "G_Periodo":
			if (f.Periodo.value == "" || f.Periodo.value == "0")
			{
				alert("Debe Ingresar Periodo de Tara de Racks y Carros");
				f.Periodo.focus();
				return;
			}
			f.action = "sea_ing_prod_vent_auto01.php?Proceso=" + opt;
			f.submit();
			break;
		case "V_Tara":
			window.open("sea_ing_prod_vent_auto_taras_det.php", "","menubar=no resizable=yes Top=50 Left=200 width=520 height=500 scrollbars=yes");
			break;
//******************************************************************************************************
//******************PRODUCCION RESTOS DE HOJAS MADRE ***************************************************
//******************************************************************************************************
		case "V_RestosHM":
			 window.open("sea_ing_prod_vent_auto_restos_ctte_det.php?Proceso=B&cmbproductos=-1&dia=" + f.dia.value + "&mes=" + f.mes.value + "&ano=" + f.ano.value, "","menubar=no resizable=yes Top=30 Left=50 width=550 height=500 scrollbars=yes");
			 break;
		case "V_PesadasRestosHM":			
			 window.open("sea_ing_prod_vent_auto_restos_hm_det2.php?Proceso=B&Grupo=-1&Dia=" + f.dia.value + "&Mes=" + f.mes.value + "&Ano=" + f.ano.value, "","menubar=no resizable=yes Top=30 Left=50 width=630 height=500 scrollbars=yes");
			 break;
		case "V_InformeRestosHM":
			 window.open("sea_ing_prod_vent_auto_restos_ctte_det3.php?Proceso=B&Hornada=-1&Dia=" + f.dia.value + "&Mes=" + f.mes.value + "&Ano=" + f.ano.value, "","menubar=no resizable=yes Top=30 Left=50 width=630 height=500 scrollbars=yes");
			 break;
		case "DefCubas_RestosHM":
			if (f.Grupo.value == "")
			{
				alert("Debe Ingresar Grupo");
				f.Grupo.focus();
				return;
			}
			<?php
				$GruposHM = "";
				$Condicion = "";
				//Grupos de Hojas Madre
				$Consulta = "SELECT DISTINCT t1.campo2 AS grupo, t2.nombre_subclase AS nombre ";
				$Consulta.= " FROM sea_web.movimientos AS t1";
				$Consulta.= " INNER JOIN  proyecto_modernizacion.sub_clase AS t2";
				$Consulta.= " ON t1.campo2 = t2.cod_subclase";
				$Consulta.= " WHERE t1.tipo_movimiento = 2 AND t2.cod_clase = 2004 AND t1.campo1 NOT IN ('T','M','S','N')";
				$Consulta.= " AND t1.numero_recarga = 0 ORDER BY t2.cod_subclase";				
				$Resp = mysqli_query($link, $Consulta);
				$Entro = false;
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Entro = true;
					$GruposHM = $GruposHM.$Fila["grupo"]."-";
					$Condicion = $Condicion."f.Grupo.value!=".$Fila["grupo"]." && ";
				}
				if ($GruposHM != "")
					$GruposHM =  substr($GruposHM,0,strlen($GruposHM)-1);
				if ($Condicion != "")
					$Condicion = substr($Condicion,0,strlen($Condicion)-4);
				if ($Entro)
				{
					echo "if (".$Condicion.")\n";
					echo "{\n";
					echo "alert(\"Los Grupos de H.M. son ".$GruposHM."\");\n";
					echo "f.Grupo.focus();\n";
					echo "return;\n";
					echo "}\n";
				}
			?>			
			window.open("sea_ing_prod_vent_auto_restos_hm_cubas.php?GrupoProd=" + f.Grupo.value + "&DiaProd=" + f.dia.value + "&MesProd=" + f.mes.value + "&AnoProd=" + f.ano.value + "&Cubas=" + f.Cubas.value, "","menubar=no resizable=yes Top=50 Left=200 width=450 height=350 scrollbars=yes");
			break;
		case "G_RestosHM":				
			if (f.Grupo.value == "")
			{
				alert("Debe Ingresar Grupo");
				f.Grupo.focus();
				return;
			}
			else
			{
				if (parseInt(f.Grupo.value)<1 || parseInt(f.Grupo.value)>49)
				{
					alert("El Grupo debe estar entre 1 y 49");
					f.Grupo.focus();
					return;
				}
			}
			<?php
				$GruposHM = "";
				$Condicion = "";
				//Grupos de Hojas Madre
				$Consulta = "SELECT DISTINCT t1.campo2 AS grupo, t2.nombre_subclase AS nombre ";
				$Consulta.= " FROM sea_web.movimientos AS t1";
				$Consulta.= " INNER JOIN  proyecto_modernizacion.sub_clase AS t2";
				$Consulta.= " ON t1.campo2 = t2.cod_subclase";
				$Consulta.= " WHERE t1.tipo_movimiento = 2 AND t2.cod_clase = 2004 AND t1.campo1 NOT IN ('T','M','S','N')";
				$Consulta.= " AND t1.numero_recarga = 0 ORDER BY t2.cod_subclase";				
				$Resp = mysqli_query($link, $Consulta);
				$Entro = false;
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Entro = true;
					$GruposHM = $GruposHM.$Fila["grupo"]."-";
					$Condicion = $Condicion."f.Grupo.value!=".$Fila["grupo"]." && ";
				}
				if ($GruposHM != "")
					$GruposHM =  substr($GruposHM,0,strlen($GruposHM)-1);
				if ($Condicion != "")
					$Condicion = substr($Condicion,0,strlen($Condicion)-4);
				if ($Entro)
				{
					echo "if (".$Condicion.")\n";
					echo "{\n";
					echo "alert(\"Los Grupos de H.M. son ".$GruposHM."\");\n";
					echo "f.Grupo.focus();\n";
					echo "return;\n";
					echo "}\n";
				}
			?>
			if (f.Cubas.value == "")
			{
				alert("Debe Ingresar Cubas");
				f.BtnCubas.focus();
				return;
			}			
			if (f.NumCarro.value == "")
			{
				alert("Debe Ingresar Numero de Carro");
				f.NumCarro.focus();
				return;
			}
			if (f.NumRack.value == "")
			{
				alert("Debe Ingresar Numero de Rack");
				f.NumRack.focus();
				return;
			}
			if (f.PesoCarro.value == "")
			{
				alert("Debe Ingresar Peso de Carro");
				f.PesoCarro.focus();
				return;
			}
			if (f.PesoRack.value == "")
			{
				alert("Debe Ingresar Peso de Rack");
				f.PesoRack.focus();
				return;
			}
			if (f.NumCubas.value == "")
			{
				alert("Debe Ingresar Cantidad de Cubas que trae el Rack");
				f.NumCubas.focus();
				return;
			}			
			if (f.PesoBruto.value == "")
			{
				alert("Debe Ingresar Peso");
				f.PesoBruto.focus();
				return;
			}		
			f.action = "sea_ing_prod_vent_auto01.php?Proceso=" + opt;
			f.submit();
			break;
		case "M_RestosHM":				
			if (f.Grupo.value == "")
			{
				alert("Debe Ingresar Grupo");
				f.Grupo.focus();
				return;
			}
			else
			{
				if (parseInt(f.Grupo.value)<1 || parseInt(f.Grupo.value)>49)
				{
					alert("El Grupo debe estar entre 1 y 49");
					f.Grupo.focus();
					return;
				}
			}
			<?php
				$GruposHM = "";
				$Condicion = "";
				//Grupos de Hojas Madre
				$Consulta = "SELECT DISTINCT t1.campo2 AS grupo, t2.nombre_subclase AS nombre ";
				$Consulta.= " FROM sea_web.movimientos AS t1";
				$Consulta.= " INNER JOIN  proyecto_modernizacion.sub_clase AS t2";
				$Consulta.= " ON t1.campo2 = t2.cod_subclase";
				$Consulta.= " WHERE t1.tipo_movimiento = 2 AND t2.cod_clase = 2004 AND t1.campo1 NOT IN ('T','M','S','N')";
				$Consulta.= " AND t1.numero_recarga = 0 ORDER BY t2.cod_subclase";				
				$Resp = mysqli_query($link, $Consulta);
				$Entro = false;
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Entro = true;
					$GruposHM = $GruposHM.$Fila["grupo"]."-";
					$Condicion = $Condicion."f.Grupo.value!=".$Fila["grupo"]." && ";
				}
				if ($GruposHM != "")
					$GruposHM =  substr($GruposHM,0,strlen($GruposHM)-1);
				if ($Condicion != "")
					$Condicion = substr($Condicion,0,strlen($Condicion)-4);
				if ($Entro)
				{
					echo "if (".$Condicion.")\n";
					echo "{\n";
					echo "alert(\"Los Grupos de H.M. son ".$GruposHM."\");\n";
					echo "f.Grupo.focus();\n";
					echo "return;\n";
					echo "}\n";
				}
			?>
			if (f.Cubas.value == "")
			{
				alert("Debe Ingresar Cubas");
				f.BtnCubas.focus();
				return;
			}			
			if (f.NumCarro.value == "")
			{
				alert("Debe Ingresar Numero de Carro");
				f.NumCarro.focus();
				return;
			}
			if (f.NumRack.value == "")
			{
				alert("Debe Ingresar Numero de Rack");
				f.NumRack.focus();
				return;
			}
			if (f.PesoCarro.value == "")
			{
				alert("Debe Ingresar Peso de Carro");
				f.PesoCarro.focus();
				return;
			}
			if (f.PesoRack.value == "")
			{
				alert("Debe Ingresar Peso de Rack");
				f.PesoRack.focus();
				return;
			}
			if (f.NumCubas.value == "")
			{
				alert("Debe Ingresar Cantidad de Cubas que trae el Rack");
				f.NumCubas.focus();
				return;
			}			
			if (f.PesoBruto.value == "")
			{
				alert("Debe Ingresar Peso");
				f.PesoBruto.focus();
				return;
			}		
			f.action = "sea_ing_prod_vent_auto01.php?Proceso=" + opt;
			f.submit();
			break;
	} 	     		
}

function GenerarHornada(ReiniciarHornada)
{  
	var f = document.formulario; 
	if(f.Hornos.value == "S")
	{
		alert("Debe Escoger un Horno");
		f.Hornos.focus();
		return;
	}	 
	if(ReiniciarHornada == "S")	 
	{		 
		if(confirm("Reiniciar� La Hornada �Desea Continuar?"))
		{
			f.action = "sea_ing_prod_vent_auto01.php?Proceso=Genera_Hornada&Reiniciar=S";
			f.submit();
		}	   
		else
		{
			return;
		}
	}
	else
	{
		f.action = "sea_ing_prod_vent_auto01.php?Proceso=Genera_Hornada&Reiniciar=N";
		f.submit();
	} 	
}

<?php
	if ($TipoPesaje != 4)
		echo "window.onerror = Valida";
?>

function Valida()
{
	var f=document.formulario;
	switch (f.CampoActivo.value)
	{
		case "C":
			if (f.NumCarro.value != "")
			{		
				f.PesoCarro.value = "";
				var msg = confirm("�Carro no Ingresado\nDesea ingresar el Peso Para Guardarlo?");
				if (msg==true)
				{
					f.PesoCarro.disabled = false;
					f.PesoCarro.focus();
					f.ImgCarro.style.visibility = "visible";
					f.NuevoCarro.value = "S";
				}		
			}
			break;
		case "R":
			if (f.NumRack.value != "")
			{		
				f.PesoRack.value = "";
				var msg = confirm("�Rack no Ingresado\nDesea ingresar el Peso Para Guardarlo?");
				if (msg==true)
				{
					f.PesoRack.disabled = false;
					f.PesoRack.focus();
					f.ImgRack.style.visibility = "visible";
					f.NuevoRack.value = "S";
				}		
			}
			break;
	}		
	return true;
}

function BuscaPeso(opt)
{
	var f=formulario;
	f.CampoActivo.value = opt;
	switch (opt)
	{
		case "C":
			if (f.CantCarros.value != "0")
			{
				if (f.NumCarro.value != "")
				{
					var msg = eval("f.PesoCarro.value = f.Carro" + f.NumCarro.value + ".value")			
					f.ImgCarro.style.visibility = "hidden";
					f.NuevoCarro.value = "N";
					//f.PesoCarro.disabled = true;
				}
				else
				{
					return;
				}
			}
			break;
		case "R":
			if (f.CantRack.value != "0")
			{
				if (f.NumRack.value != "")
				{
					var msg = eval("f.PesoRack.value = f.Rack" + f.NumRack.value + ".value")			
					f.ImgRack.style.visibility = "hidden";
					f.NuevoRack.value = "N";
					//f.PesoRack.disabled = true;
				}
				else
				{
					return;
				}
			}
			break
	}	
	CalculaPesos();
}

function CalculaPesos()
{
	var f = document.formulario;
	
	if (f.PesoCarro.value == "")
		f.PesoCarro.value = 0;
	else
		f.PesoCarro.value = parseInt(f.PesoCarro.value);
		
	if (f.PesoRack.value == "")
		f.PesoRack.value = 0;
	else
		f.PesoRack.value = parseInt(f.PesoRack.value);
		
	if (f.TotalTara.value == "")
		f.TotalTara.value = 0;
	else
		f.TotalTara.value = parseInt(f.TotalTara.value);
	
	if (f.PesoBruto.value == "")
		f.PesoBruto.value = 0;
	else
		f.PesoBruto.value = parseInt(f.PesoBruto.value);
	f.TotalTara.value = parseInt(f.PesoCarro.value) + parseInt(f.PesoRack.value);
	if (f.PesoBruto.value>0)
		f.PesoNeto.value = parseInt(f.PesoBruto.value) - parseInt(f.TotalTara.value);
	return;
}

function FuncPesoAuto()
{
	var f = document.formulario;
	if (f.checkpeso.checked==true)
		f.PesoAuto.value = "S";
	else
		f.PesoAuto.value = "N";
	if (f.PesoAuto.value=="S")
		PesoAutomatico();
}

function ValidaTaras(opt)
{
	var f = document.formulario;
	f.Numero.value = "";
	f.FechaPesajeAnt.value = "";
	f.PesoAnt.value = "";
	f.Img.style.visibility = "hidden";
	f.Nuevo.value = "N";
	return;
}

<?php
	if ($TipoPesaje == 4)
		echo "window.onerror = Valida_2";
?>

function BuscaFechaAnt()
{	
	var f=document.formulario;	
	for (i=0;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="TipoTara" && f.elements[i].checked)
		{
			var opt=f.elements[i].value;			
			break;
		}
	}
	switch (opt)
	{
		case "C":
			if (f.CantCarros.value != "0")
			{
				if (f.Numero.value != "")
				{
					var msg = eval("f.FechaPesajeAnt.value = f.Carro" + f.Numero.value + ".value.substring(0,10)")
					var msg = eval("f.PesoAnt.value = f.Carro" + f.Numero.value + ".value.substring(10)")					
					f.Img.style.visibility = "hidden";
					f.Nuevo.value = "N";
				}
				else
				{
					return;
				}
			}
			break;
		case "R":
			if (f.CantRack.value != "0")
			{
				if (f.Numero.value != "")
				{
					var msg = eval("f.FechaPesajeAnt.value = f.Rack" + f.Numero.value + ".value.substring(0,10)")
					var msg = eval("f.PesoAnt.value = f.Rack" + f.Numero.value + ".value.substring(10)")					
					f.Img.style.visibility = "hidden";
					f.Nuevo.value = "N";
				}
				else
				{
					return;
				}
			}
			break
	}	
}

function Valida_2()
{
	var f=document.formulario;
	for (i=0;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="TipoTara" && f.elements[i].checked)
		{
			var opt=f.elements[i].value;			
			break;
		}
	}
	switch (opt)
	{
		case "C":
			var RC="Carro";
			break;
		case "R":			
			var RC="Rack";
			break;
	}		
	if (f.Numero.value != "")
	{	
		f.FechaPesajeAnt.value = "NUEVO";
		f.PesoAnt.value = "NUEVO";
		f.Img.style.visibility = "visible";
		f.Nuevo.value = "S";		
	}
	return true;
}
function PesosPromedio()
{
	window.open("sea_ing_prod_vent_auto_promedios.php", "","menubar=no resizable=yes Top=100 Left=100 width=450 height=200 scrollbars=yes");
}
</script>
</head>

<body leftmargin="0" topmargin="2">
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>

  
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td height="313" align="center" valign="top">
    <table width="95%" class="TablaDetalle" cellpadding="2" cellspacing="0">
          <tr>
            <td width="11%">Tipo Pesaje: </td>
            <td width="67%"><SELECT name="TipoPesaje" onChange="Proceso('RN')">
			<option value="S">SELECCIONAR</option>
			<?php
			
				switch ($TipoPesaje)
				{
					case 1:
						echo "<option SELECTed value='1'>Prod. Anodos y Hojas Madres</option>\n";
						echo "<option value='2'>Producci�n Restos de Anodos </option>\n";
						echo "<option value='3'>Producci�n Restos Hojas Madres</option>\n";
						echo "<option value='4'>Tara de Rack y Carros</option>\n";
						break;
					case 2:
						echo "<option value='1'>Prod. Anodos y Hojas Madres</option>\n";
						echo "<option SELECTed value='2'>Producci�n Restos de Anodos</option>\n";
						echo "<option value='3'>Producci�n Restos Hojas Madres</option>\n";
						echo "<option value='4'>Tara de Rack y Carros</option>\n";
						break;
					case 3:
						echo "<option value='1'>Prod. Anodos y Hojas Madres</option>\n";
						echo "<option value='2'>Producci�n Restos de Anodos</option>\n";
						echo "<option SELECTed value='3'>Producci�n Restos Hojas Madres</option>\n";
						echo "<option value='4'>Tara de Rack y Carros</option>\n";
						break;
					case 4:
						echo "<option value='1'>Prod. Anodos y Hojas Madres</option>\n";
						echo "<option value='2'>Producci�n Restos de Anodos</option>\n";
						echo "<option value='3'>Producci�n Restos Hojas Madres</option>\n";
						echo "<option SELECTed value='4'>Tara de Rack y Carros</option>\n";
						break;
					default:
						echo "<option value='1'>Prod. Anodos y Hojas Madres</option>\n";
						echo "<option value='2'>Producci�n Restos de Anodos</option>\n";
						echo "<option value='3'>Producci�n Restos Hojas Madres</option>\n";
						echo "<option value='4'>Tara de Rack y Carros</option>\n";
						break;
				}			
			?>
            </SELECT>
            <input type="button" name="BtnPromedios" value="Pesos Promedio" onClick="PesosPromedio()">
            <input type="button" name="BtnTaras" value="Ver Taras" onClick="Proceso('V_Tara')">
			<input type="button" name="BtnSale" value="Salir" onClick="Proceso('S')"></td>
 
            <td width="22%" align="right">Bascula:&nbsp;&nbsp;<strong>
		<?php
			//$IpPc = $REMOTE_ADDR;
			$IpPc = $IP_USER;	
			$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
			$Consulta.= " where cod_clase = '2014' and nombre_subclase = '".$IpPc."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				$IpPc = $Fila["valor_subclase2"];
			}
			echo strtoupper($IpPc);
		?></strong></td>
          </tr>
	    </table><br>
		<?php
			switch ($TipoPesaje)
			{
				case 1:
					include("sea_ing_prod_vent_auto_anodos.php");
					break;
				case 2:
						include("sea_ing_prod_vent_auto_restos_ctte.php");
						break;
				case 3:
					include("sea_ing_prod_vent_auto_restos_hm.php");
					break;
				case 4:
					include("sea_ing_prod_vent_auto_taras.php");
					break;
			}
		?>
		
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>