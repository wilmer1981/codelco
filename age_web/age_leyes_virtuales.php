<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 53;
	include("../principal/conectar_principal.php");	
	$Proceso          = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Mostrar          = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$LotesOcultos     = isset($_REQUEST["LotesOcultos"])?$_REQUEST["LotesOcultos"]:"";

	$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$SubProducto   = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor     = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
	$TxtFiltroPrv  = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$TxtLey     = isset($_REQUEST["TxtLey"])?$_REQUEST["TxtLey"]:"";
	$TxtLoteInicio = isset($_REQUEST["TxtLoteInicio"])?$_REQUEST["TxtLoteInicio"]:"";
	$TxtLoteFinal  = isset($_REQUEST["TxtLoteFinal"])?$_REQUEST["TxtLoteFinal"]:"";
	$CmbLeyes      = isset($_REQUEST["CmbLeyes"])?$_REQUEST["CmbLeyes"]:"";	

	$ValoresSel=$LotesOcultos;//LotesOcultos ES UN HIDDEN QUE TOMA TODOS LO VALORES SELECCIONADOS
	$Solicitudes="";
	if($Proceso=='LMA'||$Proceso=='UL')	
	{		
		$Datos=explode("//",$ValoresSel);
		foreach($Datos as $k => $v)
		{
			$Datos2=explode("~~",$v);
			$Solicitudes=$Solicitudes."'".$Datos2[0]."',";
		}
		$Solicitudes=substr($Solicitudes,0,strlen($Solicitudes)-1);
	}
	//echo $Solicitudes;
	$Datos=explode("//",$ValoresSel);
	$Lotes="";
	foreach($Datos as $k => $v)
	{
		$Datos2=explode("~~",$v);
		$Lotes=$Lotes."'".$Datos2[0]."',";
	}
	$Lotes=substr($Lotes,0,strlen($Lotes)-1);
	//echo $Lotes;
	
?>
<html>
<head>
<title>AGE-Leyes Provisionales</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../principal/funciones/funciones_java.js"></script> 
<script language="JavaScript">
function Detalle(Valores)
{
	window.open("age_leyes_virtuales_detalle.php?Valores="+Valores,"","top=60,left=100,width=580,height=385,scrollbars=yes,resizable = no");
}
function Proceso(Proceso)
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	var Resp="";
	
	switch (Proceso)
	{
		case "B"://BUSCAR
			if (Frm.SubProducto.value=="S" && Frm.TxtLoteInicio.value=="")
			{
				alert("Debe Seleccinar un Producto o Ingresar Rango de Lote(s)");
				Frm.SubProducto.focus();
				return;
			}
			else
			{
				if (Frm.SubProducto.value!="S" && (Frm.TxtLoteInicio.value!="" || Frm.TxtLoteFinal!=""))
				{
					Frm.TxtLoteInicio.value = "";
					Frm.TxtLoteFinal.value = "";
				}
				else
				{
					if (Frm.TxtLoteInicio.value!="" && Frm.TxtLoteFinal.value=="")
					{
						Frm.TxtLoteFinal.value = Frm.TxtLoteInicio.value;
					}
				}
			}
			Frm.action='age_leyes_virtuales.php?Proceso=B&Mostrar=S';
			Frm.submit();		
			break;
		case "G"://GRABAR
			if (SeleccionoCheck()) 
			{
				if(confirm('Esta Seguro de Grabar los Datos'))
				{
					Valores=RecuperarValoresCheckeado();
					Frm.action='age_leyes_virtuales01.php?Proceso=G&ValoresIng='+Valores;
					Frm.submit();
				}						
			}	
			break;
		case "R"://RECARGA
			Frm.action='age_leyes_virtuales.php';
			Frm.submit();		
			break;
		case "LMA"://LEYES MES ANTERIOR
			if (SeleccionoCheck()) 
			{
				Valores=RecuperarValoresCheckeado();
				//Frm.action='age_leyes_virtuales.php?Proceso=LMA&Mostrar=S&ValoresSel='+Valores;
				Frm.action='age_leyes_virtuales.php?Proceso=LMA&Mostrar=S';
				Frm.submit();
			}			
			break;
		case "UL"://ULTIMA LEY
			if (SeleccionoCheck()) 
			{
				Valores=RecuperarValoresCheckeado();
				Frm.action='age_leyes_virtuales.php?Proceso=UL&Mostrar=S&ValoresSel='+Valores;
				Frm.submit();
			}			
			break;
		case "OM"://OK MASIVO
			if(Frm.CmbLeyes.value=='-1')
			{
				alert('Debe Seleccionar Ley');
				Frm.CmbLeyes.focus();
				return;
			}
			if (SeleccionoCheck()) 
			{
				Valores=RecuperarValoresCheckeado();
				Frm.action='age_leyes_virtuales.php?Proceso=OM&Mostrar=S&ValoresSel='+Valores;
				Frm.submit();
			}			
			break;
		case "S"://SALIR
			Frm.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=50&Nivel=1";
			Frm.submit();
			break;
	} 
}
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	var J=1;
	
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckCod[i].checked==true)
			{
				Valores=Valores + Frm.CheckCod[i].value+"~|"+Frm.TxtLeyes[J].value+"~~"+Frm.TxtVirtual[J].value+"||"+Frm.TxtLeyes[J+1].value+"~~"+Frm.TxtVirtual[J+1].value+"||"+Frm.TxtLeyes[J+2].value+"~~"+Frm.TxtVirtual[J+2].value+"//";
			}
			J=J+3;
		}
		Valores=Valores.substr(0,Valores.length-2);
		Frm.LotesOcultos.value=Valores;
		//alert(Valores);
		return(Valores);
	}
	catch (e)
	{
	}
}
function RecuperarValoresCheckeado2()
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	var J=1;
	
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckCod[i].checked==true)
			{
				Valores=Valores + Frm.TxtLeyes[J].value+"~~"+Frm.TxtVirtual[J].value+"||"+Frm.TxtLeyes[J+1].value+"~~"+Frm.TxtVirtual[J+1].value+"||"+Frm.TxtLeyes[J+2].value+"~~"+Frm.TxtVirtual[J+2].value+"//";
			}
			J=J+3;
		}
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);
	}
	catch (e)
	{
	}
}

function CheckearTodo()
{
	var Frm=document.FrmPrincipal;
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckCod[i].checked=true;
			}
			else
			{
				Frm.CheckCod[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmPrincipal;
	var CantCheck=0;
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckCod[i].checked==true)
			{
				CantCheck=CantCheck+1;
			}
		}
		if (CantCheck > 1)
		{
			alert("Debe Seleccionar solo un Elemento");
			return(false);
		}
		else
		{
			return(true);
		}
	}
	catch (e)
	{
	}
}
function Recarga3()
{
	var Frm=document.FrmPrincipal;
	Frm.action="age_leyes_virtuales.php?Busq=S";
	Frm.submit();	
}
function SeleccionoCheck()
{
	var Frm=document.FrmPrincipal;
	var Encontro="";
	
	Encontro=false; 
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckCod[i].checked==true)
			{
				Encontro=true;
				break;
			}
		}
		if (Encontro==false)
		{
			alert("Debe Seleccionar un Elemento");
			return(false);
		}
		else
		{
			return(true);
		}
	}
	catch (e)
	{}	
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 3px;
	margin-bottom: 3px;
	background-image: url();
}
body,td,th {
	font-size: 10px;
}
</style></head>

<body>
<form name="FrmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<input type="hidden" name="Valores" value="">
<input type="hidden" name="LotesOcultos" value="">
<table width="770" height="330" border="0" cellpadding="2" cellspacing="0" class="TablaPrincipal">
  <tr>
    <td align="center" valign="top">
    <table width="750" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr align="center">
        <td height="23" colspan="4" class="Detalle02"><strong>LEYES PROVISIONALES</strong></td>
      </tr>
      <tr>
        <td height="28" class="Colum01">SubProducto:</td>
        <td height="28"><select name="SubProducto" style="width:300" onChange="Proceso('R')" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbFlujos');">
          <option class="NoSelec" value="S">SELECCIONAR</option>
          <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($SubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
        </select></td>
        <td height="28" colspan="-1">Leyes Mes Anterior:</td>
        <td height="28"><input name="BtnProm" type="button" id="BtnProm" style="width:40px;" onClick="JavaScript:Proceso('LMA')" value="OK" ></td>
      </tr>
      <tr>
        <td height="23" class="Colum01">Proveedor:</td>
        <td height="23" colspan="2"><select name="Proveedor" style="width:300">   
		<option class='NoSelec' value='S'>TODOS</option>      
          <?php
				if ($SubProducto!="" && $SubProducto != "S")
				{
					$Consulta = "select t1.rut_prv as RUTPRV_A, t1.nombre_prv as NOMPRV_A ";
					$Consulta.= " from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
					$Consulta.= " on t1.rut_prv = t2.rut_proveedor inner join proyecto_modernizacion.subproducto t3 ";
					$Consulta.= " on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
					$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";	
					if($Busq=='S'&&$TxtFiltroPrv!='')
					   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv."%' "; 							
					$Consulta.= " order by trim(t1.nombre_prv)";		
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						if ($Proveedor == $Fila["RUTPRV_A"])
							echo "<option selected value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
						else
							echo "<option value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
					}
				}
			?>
        </select>          ---> Filtro Prv&nbsp;
            <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
            <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">        </td>
        <td height="23">&nbsp;<!--<input name="BtnUltLey" type="button" id="BtnUltLey2" style="width:40px;" onClick="JavaScript:Proceso('UL')" value="OK" disabled></td>-->
      </tr>
      <tr>
        <td height="23" class="Colum01">Periodo:</td>
        <td height="23"><select name="Mes" id="Mes">
		<?php
		for ($i=1;$i<=12;$i++)
		{
			if ($Mes=="")
			{
				if ($i==date("n"))
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
			else
			{
				if ($i==$Mes)
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
		}
		?>
        </select>
        <select name="Ano" id="Ano">
		<?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if ($Ano=="")
			{
				if ($i==date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i==$Ano)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select></td>
        <td height="23">Ley Masiva de:&nbsp;
		<select name="CmbLeyes" style="width:95">
		<option value="-1" selected>Seleccionar</option>
		<?php
		$Consulta="select * from proyecto_modernizacion.leyes where cod_leyes in('02','04','05') order by cod_leyes";
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			if($Fila["cod_leyes"]==$CmbLeyes)
				echo "<option value='".$Fila["cod_leyes"]."' selected>".$Fila["abreviatura"]."</option>";
			else
				echo "<option value='".$Fila["cod_leyes"]."'>".$Fila["abreviatura"]."</option>";
		}
		?>
		</select>&nbsp;<input type="text" name="TxtLey" value="<?php echo $TxtLey;?>" class="InputCen" size="12" onKeyDown="TeclaPulsada(true)">
		<input name="BtnOkMasivo" type="button" style="width:40px;" onClick="JavaScript:Proceso('OM')" value="OK">
		
		</td>
      </tr>
	  <tr>
	  <td>Lote Inicio</td>
	  <td><input type="text" name="TxtLoteInicio" value="<?php echo $TxtLoteInicio;?>" class="InputCen" size="12">&nbsp;&nbsp;
	    Lote Final&nbsp;&nbsp;
	    <input type="text" name="TxtLoteFinal" value="<?php echo $TxtLoteFinal;?>" class="InputCen" size="12"></td>
	  <td><div align="center"><span class="Detalle02">
	      <input name="BtnBuscar" type="button" style="width:70px;" onClick="Proceso('B')" value="Buscar">
          <input name="BtnGrabar" type="button" id="BtnGrabar2" style="width:70px;" onClick="Proceso('G')" value="Grabar" >
          <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="JavaScript:Proceso('S')">
	    </span></div></td>
	  </tr>
      <tr>
        <td height="23" colspan="4" align="center" >
		  <table width="600" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr align="center">
              <td width="200" bgcolor="#FFFF00">Canje C/Paq 1 Conocido(Tiene Paq 2)</td>
              <td width="200" >Canje C/Paq 1 No Conocido</td>
			  <td width="200" bgcolor="#FFFFFF">Cierre Operacional Sin Canje</td>
              </tr>
          </table>		
		</td>
      </tr>
    </table>
    <br>
      <table width="750" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr align="center" class="ColorTabla01">
          <td width="10"><input type="checkbox" name="CheckTodos" onClick="CheckearTodo()"></td>
          <td width="70">Lote</td>
          <td width="50">S.A.</td>
          <td width="80">F.Muestra</td>
          <td width="60">Estado</td>
		  <td width="70">Cu</td>
		  <td width="70">Ag</td>
		  <td width="70">Au</td>
        </tr>
        <?php
		if($Mes=='1')
		{
			$MesAux='12';
			$AnoAux=$Ano-1;
		}
		else
		{
			$MesAux=$Mes;
			$AnoAux=$Ano;
		}
		$FechaIni = $Ano."-".$Mes."-01";
		$FechaFin = $Ano."-".$Mes."-31";		
		$AnoMes=substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT);
		if ($Mostrar=="S")
		{ 		
			$ArrayLeyes=array();
			$ArrayLeyes['02'][0]='';//[0] VALOR
			$ArrayLeyes['02'][1]='';//[1] UNIDAD
			$ArrayLeyes['02'][2]='';//[2] LEY VIRTUAL
			$ArrayLeyes['04'][0]='';
			$ArrayLeyes['04'][1]='';
			$ArrayLeyes['04'][2]='';
			$ArrayLeyes['05'][0]='';
			$ArrayLeyes['05'][1]='';
			$ArrayLeyes['05'][2]='';
			$Consulta = "select t1.cod_producto,t1.cod_subproducto,t2.abreviatura from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
			$Consulta.= "and t1.cod_subproducto=t2.cod_subproducto where t1.lote <> '' and t1.estado_lote <>'6' "; 
			if($TxtLoteInicio!="" && $TxtLoteInicio!='')
				$Consulta.= " and t1.lote between '".$TxtLoteInicio."' and '".$TxtLoteFinal."' ";
			else
			{
				if ($SubProducto!="" && $SubProducto != "S")
				{
					$Consulta.= " and t1.cod_producto='1'";
					$Consulta.= " and t1.cod_subproducto='".$SubProducto."'";
					if ($Proveedor!="" && $Proveedor != "S")
						$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
				}
				$Consulta.= " and t1.lote between '".$AnoMes."000' and '".$AnoMes."999' ";
			}
			$Consulta.=" group by t1.cod_producto,t1.cod_subproducto";	
			$RespProd = mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckCod'><input type='hidden' name='TxtLeyes'><input type='hidden' name='TxtVirtual'>\n";
			while ($FilaProd = mysqli_fetch_array($RespProd))
			{
				$Consulta = "select t1.rut_proveedor,t2.nomprv_a ";
				$Consulta.= " from age_web.lotes t1 left join rec_web.proved t2 on t1.rut_proveedor = t2.rutprv_a ";
				$Consulta.= " where t1.lote <> '' "; 
				if($TxtLoteInicio!="" && $TxtLoteInicio!='')
					$Consulta.= " and t1.lote between '".$TxtLoteInicio."' and '".$TxtLoteFinal."' ";
				else
				{
					if ($SubProducto!="" && $Subroducto!= "S")
					{
						$Consulta.= " and t1.cod_producto='1'";
						$Consulta.= " and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."'";
						if ($Proveedor!="" && $Proveedor != "S")
							$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
					}
					$Consulta.= " and t1.lote between '".$AnoMes."000' and '".$AnoMes."999' ";
				}	
				$Consulta.= " group by t1.rut_proveedor";
				//echo $Consulta."<br>";
				$MostrarProducto='N';
				$RespProv = mysqli_query($link, $Consulta);
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$Consulta = "select t1.lote, t1.rut_proveedor,t1.cod_producto, t1.cod_subproducto, t1.fecha_recepcion, t2.abreviatura, t3.nomprv_a,t1.canjeable ";
					$Consulta.= " from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
					$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto ";
					$Consulta.= " left join rec_web.proved t3 on t1.rut_proveedor = t3.rutprv_a ";
					$Consulta.= " where t1.estado_lote <> '6' and t1.lote <> '' "; 
					if($TxtLoteInicio!="" && $TxtLoteInicio!='')
						$Consulta.= " and t1.lote between '".$TxtLoteInicio."' and '".$TxtLoteFinal."' ";
					else
						$Consulta.= " and t1.lote between '".$AnoMes."000' and '".$AnoMes."999' ";
					$Consulta.= " and t1.cod_producto='1'";
					$Consulta.= " and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."'";
					$Consulta.= " and t1.rut_proveedor='".$FilaProv["rut_proveedor"]."' ";
					if($Proceso=='LMA'||$Proceso=='UL'||$Proceso=='OM')
						$Consulta.= " and t1.lote in(".$Lotes.")";						
					$Consulta.= " order by t1.lote";
					//echo $Consulta;
					$MostrarProveedor='N';
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						$MostrarLote='N';
						foreach($ArrayLeyes as $c=>$v)
						{
							$ArrayLeyes[$c][0]='';$ArrayLeyes[$c][1]='';$ArrayLeyes[$c][2]='';
						}
						$LoteCons = $Fila["lote"];
						/*if ($Fila["rut_proveedor"]=="1100-2")
						{
							$Consulta = "select * from sea_web.relaciones where lote_ventana='".$Fila["lote"]."'";
							$RespAux=mysqli_query($link, $Consulta);
							$FilaAux = mysqli_fetch_array($RespAux);
							$LoteCons = $FilaAux["lote_origen"];					
						}*/				
						$Consulta = "select t1.cod_leyes,t1.valor,t2.abreviatura as unidad,t1.virtual as virt, ";
						$Consulta.= " t1.nro_solicitud, t1.recargo, t3.nombre_subclase as nom_est_actual, ";
						$Consulta.= " t1.cod_producto, t1.cod_subproducto, t1.id_muestra ";
						$Consulta.= " from cal_web.solicitud_analisis t0 inner join cal_web.leyes_por_solicitud t1 ";
						$Consulta.= " on t0.nro_solicitud=t1.nro_solicitud and t0.recargo=t1.recargo and t0.rut_funcionario=t1.rut_funcionario and t0.fecha_hora=t1.fecha_hora";
						$Consulta.= " inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad=t2.cod_unidad ";
						$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t0.estado_actual ";
						$Consulta.= " where t0.id_muestra ='".$LoteCons."' and (t0.recargo='' or t0.recargo='0') ";
						$Consulta.= " and t1.cod_leyes in('02','04','05') and t0.estado_actual not in ('7','16')";
						//echo $Consulta."<BR>";
						$NroSolicitud = "";
						$EstadoActual = "";
						$Recargo = "";
						$ProductoSA = "";
						$SubProductoSA = "";
						$IdMuestraSA = "";
						$RespLeyes=mysqli_query($link, $Consulta);
						while($FilaLeyes=mysqli_fetch_array($RespLeyes))
						{
							$NroSolicitud = $FilaLeyes["nro_solicitud"];
							$Recargo = $FilaLeyes["recargo"];
							$EstadoActual = $FilaLeyes["nom_est_actual"];
							$ProductoSA = $FilaLeyes["cod_producto"];
							$SubProductoSA = $FilaLeyes["cod_subproducto"];
							$IdMuestraSA = $FilaLeyes["id_muestra"];
							if($FilaLeyes["virt"]=='S')
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][0]=$FilaLeyes["valor"];
							else
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][0]=0;
							$ArrayLeyes[$FilaLeyes["cod_leyes"]][1]=$FilaLeyes["unidad"];
							if($FilaLeyes["virt"]=='N' && $FilaLeyes["valor"]!='' && $FilaLeyes["valor"]!='0')
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][2]='N';
							else
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][2]='S';
							if($FilaLeyes["virt"]=='S')
								$MostrarLote='S';
							if(($FilaLeyes["virt"]=='N') && ($FilaLeyes["valor"]=='' || $FilaLeyes["valor"]=='0'))
								$MostrarLote='S';
								
							/*echo "LOTE:".$IdMuestraSA."<BR>";	
							echo "LEY:".$FilaLeyes["cod_leyes"]."<br>";	
							echo "ES VIRTUAL:".$FilaLeyes["virt"]."<br>";
							echo "VALOR:".$FilaLeyes["valor"]."<br>";*/
						}
						$Consulta="select * from age_web.leyes_por_lote_canje where lote='".$Fila["lote"]."' and paquete_canje='2'";
						$RespCanje=mysqli_query($link, $Consulta);
						$Paq2='N';
						if($FilaCanje=mysqli_fetch_array($RespCanje))
						{
							$Paq2='S';
						}
						if(($MostrarLote=='S')||($Fila["canjeable"]=='S'&&$Paq2=='N'))
						{
							$MostrarProveedor='S';$MostrarProducto='S';
							$Color="bgcolor='#FFFFFF'";
							if($Fila["canjeable"]=='S')
							{
								$Consulta="select * from age_web.leyes_por_lote_canje where lote='".$Fila["lote"]."' and paquete_canje='2'";
								$RespCanje=mysqli_query($link, $Consulta);
								if($FilaCanje=mysqli_fetch_array($RespCanje))
									$Color="bgcolor='#FFFF00'";
								else
									$Color="bgcolor=''";
							}
							echo "<tr align='center' $Color>\n";
							$Datos=$Fila["lote"]."~~".$Recargo."~~".$FechaIni."~~".$FechaFin."~~".$ProductoSA."~~".$SubProductoSA."~~".$IdMuestraSA."~~".$NroSolicitud;
							$DatosDetalle=$NroSolicitud."~~".$Recargo."~~".$FechaIni."~~".$FechaFin."~~".$ProductoSA."~~".$SubProductoSA."~~".$IdMuestraSA;				
							echo "<td><input type='checkbox' name='CheckCod' value='".$Datos."'></td>\n";
							echo "<td><a href=JavaScript:Detalle('".$DatosDetalle."')>".$Fila["lote"]."</a></td>\n";
							echo "<td>".substr($NroSolicitud,4)."</td>\n";		
							echo "<td>".substr($Fila["fecha_recepcion"],8,2)."/".substr($Fila["fecha_recepcion"],5,2)."/".substr($Fila["fecha_recepcion"],0,4)."</td>\n";
							echo "<td>".$EstadoActual."</td>\n";
							switch($Proceso)
							{
								case "OM"://ASUMIR VALOR PARA TODOS LOS SELECCIONADOS
									//if($ArrayLeyes[$CmbLeyes][2]=='S')
										$ArrayLeyes[$CmbLeyes][0]=$TxtLey;
									break;
								case "LMA"://LEY MES ANTERIOR
									if($Mes==1)
									{
										$MesAnt=12;
										$AnoAnt=$Ano-1;
									}
									else
									{
										$MesAnt=$Mes-1;
										$AnoAnt=$Ano;
									}
									$Consulta="select ano, mes, cod_producto, cod_subproducto, rut_proveedor,round(sum(peso_seco * round(c_02,3)) / sum(peso_seco),3) as fino_cu ,  round(sum(peso_seco * round(c_04,3)) / sum(peso_seco),3) as fino_ag , round(sum(peso_seco * round(c_05,3)) / sum(peso_seco),3) as fino_au ";
									$Consulta.="from age_web.historico t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.rutprv_a where ano = '$AnoAnt' and mes ='$MesAnt' and cod_producto='".$FilaProd["cod_producto"]."' and cod_subproducto='".$FilaProd["cod_subproducto"]."' and  rut_proveedor='".$FilaProv["rut_proveedor"]."' ";
									$Consulta.="group by ano, mes, rut_proveedor order by rut_proveedor, ano, lpad(mes,2,'0')"; 
									$Respuesta=mysqli_query($link, $Consulta);
									//echo $Consulta."<br>";
									if($FilaLeyes=mysqli_fetch_array($Respuesta))
									{
										//if($ArrayLeyes['02'][2]=='S')
										//{
											$ArrayLeyes['02'][0]=$FilaLeyes["fino_cu"];
											$ArrayLeyes['02'][1]='%';
										//}	
										//if($ArrayLeyes['04'][2]=='S')
										//{
											$ArrayLeyes['04'][0]=$FilaLeyes["fino_ag"];
											$ArrayLeyes['04'][1]='g/t';
										//}	
										//if($ArrayLeyes['05'][2]=='S')
										//{
											$ArrayLeyes['05'][0]=$FilaLeyes["fino_au"];
											$ArrayLeyes['05'][1]='g/t';
										//}	
									}
									break;		
								case "UL"://ULTIMA LEY
									$Consulta="select * from age_web.lotes where lote='".$Fila["lote_ventana"]."'";
									$RespLote=mysqli_query($link, $Consulta);
									if($FilaLote=mysqli_fetch_array($RespLote))
									{
										$FechaDesde=substr($FilaLote["fecha_recepcion"],0,7)."-01";
										$FechaHasta=substr($FilaLote["fecha_recepcion"],0,7)."-31";
										$Consulta="select max(t1.lote) as lote_mayor  from age_web.lotes t1 inner join age_web.leyes_por_lote t2 on t1.lote=t2.lote and t2.recargo='0' where t1.cod_producto='".$FilaLote["cod_producto"]."' and t1.cod_subproducto='".$FilaLote["cod_subproducto"]."' ";
										$Consulta.="and t1.rut_proveedor='".$FilaLote["rut_proveedor"]."' and fecha_recepcion between '".$FechaDesde."' and '".$FechaHasta."'";
										$RespLoteMayor=mysqli_query($link, $Consulta);
										$FilaLoteMayor=mysqli_fetch_array($RespLoteMayor);
										$Consulta="select * from age_web.leyes_por_lote where lote='".$FilaLoteMayor["lote_mayor"]."' and cod_leyes in('02','04','05')";
										//$RespLeyes=mysqli_query($link, $Consulta);
										while($FilaLeyes=mysqli_fetch_array($RespLeyes))
										{
											if($ArrayLeyes[$FilaLeyes["cod_leyes"]][2]=='S')
											{
												$ArrayLeyes[$FilaLeyes["cod_leyes"]][0]=$FilaLeyes["valor"];
											}	
										}
									}
									break;		
							}	
							reset($ArrayLeyes);
							foreach($ArrayLeyes as $c=>$v)
							{
								if($v[2]=='S')
									echo "<td><input type='text' name='TxtLeyes' value='".number_format((float)$v[0],2,',','')."' maxlength='8' class='InputColor' size='14' onkeydown=TeclaPulsada(true)>&nbsp;$v[1]<input name='TxtVirtual' type='hidden' value='S~~$c'></td>\n";
								else
									echo "<td><input type='text' name='TxtLeyes' value='".number_format((float)$v[0],2,',','')."' maxlength='8' class='InputCent' size='14' onkeydown=TeclaPulsada(true)>&nbsp;$v[1]<input name='TxtVirtual' type='hidden' value='S~~$c'></td>\n";
									//echo "<td><input type='text' name='TxtLeyes' value='".number_format($v[0],2,',','')."' maxlength='8' class='InputColor' size='10' readonly='true'>&nbsp;$v[1]<input name='TxtVirtual' type='hidden' value='N~~$c'></td>\n";											
							}
							echo "</tr>\n";
						}	
					}
					if($MostrarProveedor=='S')
					{
						echo "<tr>";
						echo "<td>&nbsp;</td>";
						echo "<td colspan='7' class='Detalle02'>".$FilaProv["rut_proveedor"]." - ".$FilaProv["nomprv_a"]."&nbsp;</td>\n";
						echo "</tr>";
					}	
				}
				if($MostrarProducto=='S')				
				{
					echo "<tr>";
					echo "<td>&nbsp;</td>";
					echo "<td colspan='7' class='Detalle01'>".$FilaProd["abreviatura"]."&nbsp;</td>\n";
					echo "</tr>";
				}	
			}
		}
		?>
      </table>
    </td>
  </tr>
</table> 
</table>
<?php include ("../principal/pie_pagina.php") ?>     
</form>
</body>
</html>
<?php
/*$Consulta= "select t2.abreviatura as unidad from proyecto_modernizacion.leyes t1 left join proyecto_modernizacion.unidades t2 on t1.cod_unidad=t2.cod_unidad where cod_leyes='05'";
$RespUnidad=mysqli_query($link, $Consulta);
$FilaUnidad=mysqli_fetch_array($RespUnidad);*/
?>
