<?
 $CodigoDeSistema = 30;
 $CodigoDePantalla = 1;
 include("../principal/conectar_sget_web.php");
 include("funciones/sget_funciones.php");
 if(isset($Rut))
 	$TxtRut=$Rut;
?>
<html>
<head>
<title>Mantenedor de Personal Colaborador</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	
	switch(TipoProceso)
	{
		case 'N'://GRABAR
	//	alert (TipoProceso);
			if (f.TxtContrato.value!= '')
				CC = f.TxtContrato.value;
				//alert (CC);
													//Proceso=MT&Tipo=E&Valores="+Valores;
			var URL = "sget_mantenedor_personal_proceso.php?Proceso=N&CC="+CC;
			//window.open(URL,"","top=0,left=30,width=1000,height=580,menubar=no,resizable=yes,scrollbars=yes,status=1");
			window.open(URL,"","top=0,left=30,width=1000,height=580,menubar=no,resizable=yes,scrollbars=yes,status=1 ");
		

			break;
		case "M":
			var Valores="";
			var contador="";
			var Empresa= "";
			var CC ="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="CheckPers" && f.elements[i].checked==true)
				{
					Valores = Valores + f.elements[i].value + "~~";
					contador=contador+1;
				}	
			}
			
			//alert (Valores);
			//alert (contador);
			if (Valores=="")
			{
				alert("Debe Seleccionar un Elemento para Modificar");
				return;
			}
			else
			{
				if (contador == 1)
				{
					var Largo=Valores.length;
					Valores=Valores.substring(0,Largo-2);
					Empresa = 1;
				//	alert (TipoProceso);
					if (f.TxtContrato.value!= '')
						CC = f.TxtContrato.value;
					var URL = "sget_mantenedor_personal_proceso.php?Proceso=M&Tipo=E&Valores="+Valores+'&CC='+CC;
					window.open(URL,"","top=0,left=30,width=1000,height=580,menubar=no,resizable=yes,scrollbars=yes,status=1 ");
				}
				else
					alert("Debe Seleccionar Solo un Elemento");
			}
		    break;
		case "MT":
			var Valores="";
			var contador="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="CheckPers" && f.elements[i].checked==true)
				{
					Valores = Valores + f.elements[i].value + "~~";
					contador=contador+1;
				}	
			}
			if (Valores=="")
			{
				alert("Debe Seleccionar un Elemento para Modificar");
				return;
			}
			else
			{
				if (contador == 1)
				{
					var Largo=Valores.length;
					Valores=Valores.substring(0,Largo-2);
					var URL = "sget_mantenedor_personal_proceso_tarjeta.php?Proceso=MT&Tipo=E&Valores="+Valores;
					window.open(URL,"","top=150,left=350,width=580,height=200,menubar=no,resizable=yes,scrollbars=yes,status=1 ");
				}
				else
					alert("Debe Seleccionar Solo un Elemento");
			}
		    break;
		case "MF":
			var Valores="";
			var contador="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="CheckPers" && f.elements[i].checked==true)
				{
					Valores = Valores + f.elements[i].value + "~~";
					contador=contador+1;
				}	
			}
			if (Valores=="")
			{
				alert("Debe Seleccionar un Elemento para Modificar");
				return;
			}
			else
			{
				var Largo=Valores.length;
				Valores=Valores.substring(0,Largo-2);
				//alert (Valores);
				var URL = "sget_mantenedor_personal_proceso_fecha_ctto.php?Proceso=MF&Tipo=E&Valores="+Valores;
				window.open(URL,"","top=150,left=350,width=720,height=500,menubar=no,resizable=yes,scrollbars=yes,status=1 ");
			}
		    break;

		case "E"://ELIMINAR
			var Valores="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="CheckPers" && f.elements[i].checked==true)
					Valores = Valores + f.elements[i].value + "~~";
			}
			if (Valores=="")
			{
				alert("Debe Seleccionar un Elemento para Eliminar");
				return;
			}
			else
			{
				if (confirm("�Desea Eliminar los Datos Seleccionados?"))
				{
					var Largo=Valores.length;
					Valores=Valores.substring(0,Largo-2);
					f.action = "sget_mantenedor_personal_proceso01.php?Proc=E&Valores="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;				
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=32";
			f.submit();
			break;
		case 'R'://RECARGA
			f.action='sget_mantenedor_personal.php?BuscarEmp=S';
			f.submit();
			break;
		case 'B'://BUSCAR
		
		if(f.CheckInactivos.checked==true && f.CheckInactivosD.checked==true)
		{
				alert ("Debe Seleccionar Solo un Criterio de Busqueda");
			return;
		}
		else
		{
			Inactivos='N';
			if(f.CheckInactivos.checked==true)
				Inactivos='S';
				
			InactivosD='N';
			if(f.CheckInactivosD.checked==true)
				InactivosD='S';
																														    
			f.action='sget_mantenedor_personal.php?Buscar=S&MostrarInact='+Inactivos+'&MostrarInactD='+InactivosD;
			f.submit();
			break;
		}
	}
	
}
function BuscarEmp()
{
	var f = document.frmPrincipal;
	
	f.TxtRut.value='';
	f.TxtApePat.value='';
	Inactivos='N';
	if(f.CheckInactivos.checked==true)
		Inactivos='S';
	InactivosD='N';
	if(f.CheckInactivosD.checked==true)
		InactivosD='S';
	alert (f.TxtBuscaEmp.value);
	if (f.TxtBuscaEmp.value != '')	
		f.action='sget_mantenedor_personal.php?BuscarEmp=S&CmbEmpresa=S&MostrarInact='+Inactivos+'&MostrarInactD='+InactivosD+'&TxtBuscaEmp='+f.TxtBuscaEmp.value;
	else
		f.action='sget_mantenedor_personal.php?BuscarEmp=S&CmbEmpresa=S&MostrarInact='+Inactivos+'&MostrarInactD='+InactivosD;
	f.submit();
}
function BuscarRut()
{
	var f = document.frmPrincipal;
	
	f.CmbEmpresa.value='S';
	f.TxtApePat.value='';
	Inactivos='N';
	if(f.CheckInactivos.checked==true)
		Inactivos='S';
	InactivosD='N';
	if(f.CheckInactivosD.checked==true)
		InactivosD='S';
	
	f.action='sget_mantenedor_personal.php?BuscarRut=S&MostrarInact='+Inactivos+'&MostrarInactD='+InactivosD;
	f.submit();
}
function BuscarApePat()
{
	var f = document.frmPrincipal;
	
	f.CmbEmpresa.value='S';
	f.TxtRut.value='';
	Inactivos='N';
	if(f.CheckInactivos.checked==true)
		Inactivos='S';
	InactivosD='N';
	if(f.CheckInactivosD.checked==true)
		InactivosD='S';
	
	f.action='sget_mantenedor_personal.php?BuscarApePat=S&MostrarInact='+Inactivos+'&MostrarInactD='+InactivosD;
	f.submit();
}
function Detalle(Rut)
{
	var URL = "sget_detalle_persona.php?Rut="+Rut;
	window.open(URL,"","top=30,left=30,width=730,height=550,menubar=no,resizable=yes,scrollbars=yes");
}
function TarjetaProvisoria(Rut)
{
	var URL = "sget_tarjeta_provisoria.php?Rut="+Rut;
	window.open(URL,"","top=30,left=30,width=450,height=250,menubar=no,resizable=yes,scrollbars=yes");
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form name="frmPrincipal" action="" method="post">
<? include("encabezado.php")?>

 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top">
 <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
              <td width="271"><img src="archivos\Titulos\mant_personal.png"></td>
              <td width="179" align="right"><font color="#9E5B3B">&nbsp;<font face="Times New Roman, Times, serif" size="2">Servidor 
                <? 
				$IP_SERV = $HTTP_HOST;
				echo $IP_SERV;?>
              </font></font></td>
              <td width="304" align="right"><font size="2" face="Times New Roman, Times, serif">&nbsp; 
                </font><font color="#9E5B3B" face="Times New Roman, Times, serif">&nbsp; 
                <? 
				//$Fecha_Hora = date("d-m-Y h:i");
				$FechaFor=FechaHoraActual();
				echo $FechaFor." hrs";
				?>
                </font></td>
            </tr>
        </table></td>
    </tr>
  </table>
<table width="950"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
  <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
    <td><table width="100%"  cellspacing="0">
      <tr>
                  <td height="35" colspan="4" align="left" class="formulario2"   ><img src="archivos/images/interior/t_buscadorGlobal4.png" width="161" height="28" /> 
                  </td>
                  <td colspan="2" align="right" class="formulario2" > <a href="JavaScript:Procesos('B')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a><a href="JavaScript:Procesos('N')"><img src="archivos/nuevo2.png"  alt="Nuevo" width="20" height="17"  border="0" align="absmiddle" /></a>&nbsp; 
                    <a href="JavaScript:Procesos('M')"><img src="archivos/btn_modificar3.png" border="0" alt="Modificar" align="absmiddle"></a>&nbsp;<a href="JavaScript:Procesos('MT')"><img src="archivos/curso_basico.png" border="0" alt="Modifica Solo Tarjeta" align="absmiddle"></a>&nbsp;<a href="JavaScript:Procesos('MF')"><img src="archivos/ModFecha3.png" border="0" alt="Modifica Solo Fecha T�rmino Contrato" align="absmiddle"></a>&nbsp;<a href="JavaScript:Procesos('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>&nbsp; 
                    <a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a> 
                  </td>
      </tr>
      <tr>
                  <td width="13%" class="formulario2">Rut Persona</td>
        <td width="16%" class="formulario2"><input type="text" name="TxtRut" value="<? echo $TxtRut;?>"></td>
        <td width="36%" class="formulario2">Ape. Paterno&nbsp;&nbsp; 
          <input type="text" name="TxtApePat" value="<? echo $TxtApePat;?>"></td>
        <td width="8%" class="formulario2">&nbsp;</td>
        <td width="18%" class="formulario2">&nbsp;</td>
        <td width="9%" class="formulario2">&nbsp;</td>
        <? 
		if($Check=='S')
		{	
			$checked='checked';
		 	$disabled="";
		}
		else
		{	
			$checked="";
			$disabled="";
		 }
		//  echo "QQQQQ".$TxtBuscaEmp;
		  ?>
      </tr>
      <tr>
                  <td class="formulario2">Rut Empresa</td>
                  <td colspan="2" class="formulario2"> 
                    <input name="TxtBuscaEmp" type="text" value="<? echo $TxtBuscaEmp;?>" size="15" maxlength="10">
					
                 <a href="JavaScript:BuscarEmp()"><img src="archivos/btn_aceptar.png"   alt="Buscar"  border="0" align="absmiddle"></a> 
                    <SELECT name="CmbEmpresa" style="width:300">
					
                <option value="S" SELECTed>Seleccionar</option>
                <?
				//include("../principal/conectar_ssgc.php");
				$Encontro=false;	
				//poly $Consulta="SELECT * from sget_contratistas where rut_empresa<>''";
				$Consulta="SELECT * from sget_contratistas where rut_empresa<>''";
				
				if($BuscarEmp=='S'&&$TxtBuscaEmp!='')
					$Consulta.=" and upper(razon_social) like '%".strtoupper($TxtBuscaEmp)."%'";
				$Consulta.=" order by razon_social";
					
				$RespEmp=mysqli_query($link, $Consulta);
				while($FilaEmp=mysql_fetch_array($RespEmp))
				{
					if(strtoupper($FilaEmp[rut_empresa])==strtoupper($CmbEmpresa))
						echo "<option value='".$FilaEmp[rut_empresa]."' SELECTed>".$FilaEmp[razon_social]."</option>";
					else
						echo "<option value='".$FilaEmp[rut_empresa]."'>".$FilaEmp[razon_social]."</option>";
					$Encontro=true;
					$vare= $CmbEmpresa;	
				}
			
			?>
              </SELECT>        </td>
        <td colspan="3" class="formulario2">Ver Inactivos:
          <? 
		//  echo "TTT".$Consulta."##".$vare;
		
				$EstadoInact='';
				if($MostrarInact=='S')
					$EstadoInact='checked';
				$EstadoInactD='';
					if($MostrarInactD=='S')
					$EstadoInactD='checked';
	
			?>
          <input type="checkbox" name="CheckInactivos" value="checkbox" <? echo $EstadoInact;?> class="SinBorde">
                    Ver Inactivos Definitivos 
                    <input type="checkbox" name="CheckInactivosD" value="checkbox" <? echo $EstadoInactD;?> class="SinBorde"></td>
      </tr>
      <tr>
                  <td class="formulario2">N&deg; Contrato</td>
                  <td colspan="2" class="formulario2"><input name="TxtContrato" type="text" id="TxtContrato" value="<? echo $TxtContrato; ?>" size="25"></td>
                  <td colspan="3" class="formulario2">Versi&oacute;n 1</td>
      </tr>
    </table></td>
    <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>  
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
</table><br>
<table width="955" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
      <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
      <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
      <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    </tr>
    <tr>
      <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
    <td><br>
        <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td width="3%" class="TituloTablaVerde"><input type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckPers','ChkTodos');" class='SinBorde' ></td>
            <td width="4%" align="center" class="TituloTablaVerde">Foto</td>
            <td width="10%" align="center" class="TituloTablaVerde">Rut</td>
            <td width="15%" align="center" class="TituloTablaVerde">Apellidos</td>
			<td width="9%" align="center" class="TituloTablaVerde">Nombre</td>
			<td width="11%" align="center" class="TituloTablaVerde">Comuna</td>
			<td width="8%" align="center" class="TituloTablaVerde">Credencial</td>
			<td width="11%" align="center" class="TituloTablaVerde">Contrato</td>
			<td width="27%" align="center" class="TituloTablaVerde">Empresa</td>
			<td width="15%" align="center" class="TituloTablaVerde">Sindicalizado</td>
          </tr>
          <?
			if($Buscar=='S')
			{
				$Consulta="SELECT t1.rut,t1.nombres,t1.ape_paterno,t1.ape_materno,t1.nro_tarjeta,t1.cod_contrato,t1.rut_empresa,t2.nom_comuna,t3.descripcion as nom_sindicato ";
				$Consulta.="from sget_personal t1 left join sget_comunas t2 on t1.cod_comuna=t2.cod_comuna left join sget_sindicato t3 on t1.cod_sindicato=t3.cod_sindicato where t1.rut<>''";
				if($CmbEmpresa!='S')
					$Consulta.=" and t1.rut_empresa='".$CmbEmpresa."'";
				if($TxtRut!='')
					$Consulta.=" and t1.rut like '".trim($TxtRut)."%'";
				if($TxtApePat!='')
					$Consulta.=" and t1.ape_paterno like '%".trim($TxtApePat)."%'";
				if($TxtContrato!='')
					$Consulta.=" and t1.cod_contrato = '".trim($TxtContrato)."'";
				if($MostrarInact=='S')
					$Consulta.=" and (t1.estado in('I')) ";
				else if ($MostrarInactD=='S') 
					$Consulta.=" and (t1.estado in('D')) ";	
				else
					$Consulta.=" and t1.estado in('A') ";		
				$Consulta.="order by t1.ape_paterno";
				//echo "EE".$Consulta."<br>";
				echo "<input type='hidden' name='CheckPers'>";
				$RespPersona=mysqli_query($link, $Consulta);
				$Cont=1;
				while($FilaPersona=mysql_fetch_array($RespPersona))
				{
					$Par=($Cont % 2);
					if($Par==1)
					{
						?>
						<tr class="FilaAbeja">
						<?
					}
					else
					{
						?>
						<tr>
						<? 
					}
					$Run=FormatearRun($FilaPersona["rut"]);
					
					echo "<td align='center' width='30'><input type='checkbox' name='CheckPers' value='".$FilaPersona["rut"]."' class='SinBorde'></td>";
					echo "<td align='center'><a href=javascript:Detalle('".$FilaPersona["rut"]."')>";
					$Foto="fotos/".$FilaPersona["rut"].".jpg";
					if(is_file($Foto))
						$Imagen=$Foto;
					else
						$Imagen="archivos/usuario.png";
					echo "<img src=\"$Imagen\" align=\"absmiddle\" border=\"0\" width='20' height='20'></a></td>";
					echo "<td>".$Run."</td>";			
					echo "<td>".ucfirst(strtolower($FilaPersona[ape_paterno]))." ".ucfirst(strtolower($FilaPersona[ape_materno]))."</td>";
					echo "<td>".ucfirst(strtolower(substr($FilaPersona["nombres"],0,20)))."</td>";
					echo "<td>".$FilaPersona[nom_comuna]."&nbsp;</td>";
					if($FilaPersona[nro_tarjeta]!='')					
						echo "<td align='center'>".strtoupper($FilaPersona[nro_tarjeta])."&nbsp;</td>";
					else
						echo "<td align='center'><a href=javascript:TarjetaProvisoria('".$FilaPersona["rut"]."')>Tarjeta Provisoria</a></td>";
					//include("../principal/conectar_ssgc.php");
					echo "<td>";
					?>
					<a href="sget_info_ctto.php?Ctto=<? echo $FilaPersona["cod_contrato"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Contrato" border="0" width='23' height='23' align="absmiddle" /></a>
					<?
					echo strtoupper($FilaPersona["cod_contrato"])."&nbsp;</td>";
					$Consulta="SELECT * from sget_contratistas where rut_empresa='".$FilaPersona[rut_empresa]."'";
					$RespEmp=mysqli_query($link, $Consulta);
					if($FilaEmp=mysql_fetch_array($RespEmp))
					{
						echo "<td>";
					?>	
						<a href="sget_info_empresa.php?Emp=<? echo $FilaPersona[rut_empresa];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Empresa" border="0" width='23' height='23' align="absmiddle" /></a>
					<?
						echo FormatearNombre($FilaEmp["razon_social"])."&nbsp;</td>";
					}
					else
						echo "<td>&nbsp;</td>";
					echo "<td>".$FilaPersona["nom_sindicato"]."&nbsp;</td>";	
					echo "</tr>";
					$Cont++;
				}
			}	
			?>
      </table></td>
    <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
    </tr>
    <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
</table>
</td>
</tr>
</table>
 </td>
    </tr>
  </table>
	<? include("pie_pagina.php")?>
</form>
</body>
</html>
<?
//ACTUALIZAR CAMPO INACTIVO DE PERSONAS CON FECHA FIN CTTO VENCIDOS POR FECHA DE TERMINO
$Consulta="SELECT rut,cod_contrato FROM sget_personal WHERE fec_fin_ctto < '".date('Y-m-d')."' and estado='A'";
//echo $Consulta;
$Resp=mysqli_query($link, $Consulta);
while($Fila=mysql_fetch_array($Resp))
{
	//$Contratos="SELECT cod_contrato from sget_contratos where cod_contrato='".$Fila["cod_contrato"]."' and (posterga='S' and fecha_posterga<='".date('Y-m-d')."')";
	$Contratos="SELECT cod_contrato,posterga,fecha_posterga from sget_contratos where cod_contrato='".$Fila["cod_contrato"]."'";
	$RespCont=mysql_query($Contratos);$Pasa='NO';
	if($FilasCont=mysql_fetch_array($RespCont))
	{
		if($FilasCont[posterga]=='S' && $FilasCont[fecha_posterga]<= date('Y-m-d') && $FilasCont[fecha_posterga]!='' && $FilasCont[fecha_posterga]!='0000-00-00')				
			$Pasa='SI';
		if($FilasCont[posterga]=='N')	
			$Pasa='SI';
	}
	if($Pasa=='SI')		
	{
		$Actualizar="UPDATE sget_personal set estado='I' where rut='".$Fila["rut"]."'";
		//echo "actualiza inactivos:    ".$Actualizar."<br>";
		mysql_query($Actualizar);
	}
}
$ConsultaCorreo="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30025' and cod_subclase='2' and valor_subclase1='A' ";//PREGUNTA SI ESTA A: ACTIVADO PARA ENVIAR CORREOS
$RespCorreo=mysql_query($ConsultaCorreo);
if($Fila=mysql_fetch_array($RespCorreo))
{
$Con="SELECT valor_subclase1,valor_subclase2 from proyecto_modernizacion.sub_clase where cod_clase='30024'";
$RAno=mysql_query($Con);
$FAno=mysql_fetch_assoc($RAno);
$PreocupaAno=$FAno["valor_subclase2"];
$OcupaAno=$FAno["valor_subclase3"];
$DASAno=$FAno["valor_subclase1"];

$Consulta="SELECT t1.estado,t1.rut,t1.fecha_das,t1.fecha_vig_exa_ocup,t1.fecha_vigencia_exa_preo,t2.fecha_exa_pst,t2.fecha_vig_licencia FROM sget_personal t1 left join sget_conductores t2 on t1.rut=t2.rut";
//echo $Consulta."<br>";
$Resp=mysqli_query($link, $Consulta);
while($Fila=mysql_fetch_array($Resp))
{
	$FPreo='N';
	if($Fila[fecha_vigencia_exa_preo]!='' && $Fila[fecha_vigencia_exa_preo]!='0000-00-00')
	{
		$FechaPreoEX=explode('-',$Fila[fecha_vigencia_exa_preo]);
		$FechaPreo=$FechaPreoEX[0]+$PreocupaAno;
		$FechaPreo=$FechaPreo."-".$FechaPreoEX[1]."-".$FechaPreoEX[2];
		if($FechaPreo < date('Y-m-d'))
			$FPreo='S';
	}
	$FDAS='N';
	if($Fila[fecha_das]!='' && $Fila[fecha_das]!='0000-00-00')
	{
		$FechaTerminoDAS=explode('-',$Fila[fecha_das]);
		$FechaDAS=$FechaTerminoDAS[0]+$DASAno;
		$FechaDAS=$FechaDAS."-".$FechaTerminoDAS[1]."-".$FechaTerminoDAS[2];
		if($FechaDAS < date('Y-m-d'))
			$FDAS='S';
	}
	$FOCUPA='N';
	if($Fila[fecha_vig_exa_ocup]!='' && $Fila[fecha_vig_exa_ocup]!='0000-00-00')
	{
		if($Fila[fecha_vig_exa_ocup] < date('Y-m-d'))
			$FOCUPA='S';
	}
	$FPST='N';
	if($Fila[fecha_exa_pst]!='' && $Fila[fecha_exa_pst]!='0000-00-00')
	{
		if($Fila[fecha_exa_pst] < date('Y-m-d'))
			$FPST='S';
	}
	$FLicencia='N';
	if($Fila[fecha_vig_licencia]!='' && $Fila[fecha_vig_licencia]!='0000-00-00')
	{
		if($Fila[fecha_vig_licencia] < date('Y-m-d'))
			$FLicencia='S';
	}		
	//una fecha vencida, inactivo.	
	if($FPreo=='S' || $FDAS=='S' || $FOCUPA=='S' || $FPST=='S' || $FLicencia=='S')
	{
		$Actualizar="UPDATE sget_personal set estado='I' where rut='".$Fila["rut"]."'";
		//echo "actualiza inactivos:    ".$Actualizar."<br>";
		mysql_query($Actualizar);
	}
	//todas las fechas estan bien deja activo.
	if($FPreo=='N' && $FDAS=='N' && $FOCUPA=='N' && $FPST=='N' && $FLicencia=='N')
	{
		$Actualizar="UPDATE sget_personal set estado='A' where rut='".$Fila["rut"]."'";
		//echo "actualiza inactivos:    ".$Actualizar."<br>";
		mysql_query($Actualizar);
	}
}
}//FIN IF
?>