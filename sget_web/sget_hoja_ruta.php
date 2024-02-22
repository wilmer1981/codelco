<?
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	$FechaSist=date("d/m/Y");
	$matriz=split("/",$FechaSist);
	$dia=$matriz[0];
	$mes=$matriz[1];
	$año=$matriz[2];
	if($Opt == "M")
	{
		$Consulta="SELECT * from sget_hoja_ruta where num_hoja_ruta='".$TxtHoja."' ";
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);
		$CmbEmpresa=$Fila[rut_empresa];
		$CmbContrato=$Fila["cod_contrato"];
	}
	if($Empresa!='')
	{
		$CmbEmpresa=$Empresa;
	}
	if($Contrato!='')
	{
		$CmbContrato=$Contrato;
	}
	
	
		if(isset($pasaporte))
	{
		$Optpasaporte='checked';
	}

	
?>
<title>
Hoja de Ruta
</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function oculta(numero) 
{

	var f=document.FrmObs;
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	
	{
		if (ie4)
		{
			eval(numero + ".style.visibility = 'hidden'");
		}
	}
}

function Documentos(THoja)
{
	var f=document.FrmProceso;
	var URL="sget_cant_documento_solp.php?TxtHoja="+THoja+"&Pagina="+f.Pagina.value;
	var opciones='top=100,left=50,toolbar=0,resizable=1,menubar=0,status=1,width=600,height=200,scrollbars=1';
	window.open(URL,'',opciones)
}
function Proceso(Opt,H,E)
{
	var f=document.FrmProceso;
	switch (Opt)
	{
		case "GC":
			f.action='sget_hoja_ruta01.php?Proceso=AG';
			f.submit();		
		break;
		case "AN":
			/*if(IngresoValido())
			{*/
			//alert (f.CmbEmpresa.value);
				var URL = "sget_mantenedor_personal_proceso.php?Proceso="+Opt+"&CmbEmpresaO="+f.CmbEmpresa.value+"&CmbContratoO="+f.CmbContrato.value+"&TxtHoja="+f.TxtHoja.value;
				//window.open(URL,"","top=0,left=30,width=750,height=580,menubar=no,resizable=yes,scrollbars=yes,status=1 ");
				window.open(URL,"","top=0,left=30,width=1000,height=580,menubar=no,resizable=yes,scrollbars=yes,status=1 ");

				
			/*}*/
		break;
		case "N":
			f.action='sget_hoja_ruta01.php?Proceso=N';
			f.submit();		
		break;
		case "S":
			if(H=='')
				window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=0";
			else
			{
				window.opener.document.FrmPrincipal.action='sget_adm_hoja_ruta.php?Cons=S';
				window.opener.document.FrmPrincipal.submit();
				window.close();	
			}
		break;
		case "M":
			//alert (Opt);
			var URL = "sget_mantenedor_personal_proceso.php?Proceso="+Opt+"&CmbEmpresaO="+f.CmbEmpresa.value+"&CmbContratoO="+f.CmbContrato.value+"&TxtHoja="+f.TxtHoja.value+"&Buscar=S&Valores="+E;
			//window.open(URL,"","top=0,left=30,width=750,height=580,menubar=no,resizable=yes,scrollbars=yes,status=1 ");
			window.open(URL,"","top=0,left=30,width=1000,height=580,menubar=no,resizable=yes,scrollbars=yes,status=1 ");

		break;
		case "EN":
			f.action="sget_hoja_ruta01.php?Proceso=EN&TxtHoja="+f.TxtHoja.value+"&RutEmpresa="+E;
			f.submit();		
		break;
		case "MH":
			f.action="sget_hoja_ruta01.php?Proceso=MH&TxtHoja="+f.TxtHoja.value;
			f.submit();		
		break;
		case "BUSRut":
		//alert (FrmProceso.TxtRutPer.value);
		//poly 
		Pasaporte ='N';
		if(f.Pasaporte.checked==true)
		{
			Pasaporte='S';//Pasaporte
			//alert (Pasaporte);
		}	
		if(Pasaporte=='N')
		{
			valor= new Object(document.FrmProceso.TxtRutPer.value);
			foco = new Object(document.FrmProceso.TxtRutPer.focus());
			var bandera = Rut(document.FrmProceso.TxtRutPer.value,'Rut Persona', foco, valor);
			if(bandera == false)
			{
				return;
			}
			else
			{				
				//alert (f.TxtHoja.value);
				f.action="sget_hoja_ruta01.php?Proceso=BuscaRut&TxtHoja="+f.TxtHoja.value;
				f.submit();	
			}
		}
		else
		{	
			f.action="sget_hoja_ruta01.php?Proceso=BuscaRut&TxtHoja="+f.TxtHoja.value;
			f.submit();	
		}	
		break;
		case "Emp":	
			var	URL = "sget_mantenedor_empresas_proceso.php?Volver=S&RutReq="+f.CmbEmpresa.value+"&Form="+f.name+"&Pagina=sget_hoja_ruta.php";		//var	URL = "sget_ingreso_administradores.php?Opc=B";
			window.open(URL,"","top=30,left=30,width=800,height=500,menubar=no,status=1,resizable=yes,scrollbars=yes");
		break;
		case "Contrato":	
			var	URL = "sget_mantenedor_contratos_proceso.php?Volver=S&Contrato="+f.CmbContrato.value+"&Form="+f.name+"&Pagina=sget_hoja_ruta.php";		//var	URL = "sget_ingreso_administradores.php?Opc=B";
			window.open(URL,"","top=30,left=30,width=800,height=500,menubar=no,status=1,resizable=yes,scrollbars=yes");
		break;	
	}
}
function BuscaRut() 
{
	var f=document.FrmProceso;
	f.action='sget_hoja_ruta.php?Buscar=S';
	f.submit();
}

function IngresoValido()
{
	var f=document.FrmProceso;
	var Result=true;
	if(f.CmbEmpresa.value=='S')
	{
		alert('Debe Seleccionar Empresa');
		f.CmbEmpresa.focus();
		Result=false;
		return;		
	}
	if(f.CmbContrato.value=='S')
	{
		alert('Debe Seleccionar Contrato');
		f.CmbContrato.focus();
		Result=false;
		return;		
	}
}	
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	if ((teclaCodigo != 110 )&&(teclaCodigo != 37)&&(teclaCodigo != 39) &&(teclaCodigo != 190 ))
	{
		if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
	else
	{
		if ((teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 110 )&&(teclaCodigo != 190 ))
		{
			event.keyCode=46;
		}	
	}	
} 
function Recarga(Opt) 
{
	var f=document.FrmProceso;
	f.action='sget_hoja_ruta.php?Opt='+Opt;
	f.submit();
}
function Atachar(Tipo)
{
	var f=document.FrmProceso;
	var URL='';
	var opciones='';
	if(f.TxtHoja.value!='' && (f.TxtHoja.value*1)!=0)
	{
		URL="sget_atach.php?ActualizaPag=S&formulario2=FrmProceso&Proceso=H&ID="+f.TxtHoja.value+"&Pagina=sget_hoja_ruta.php";
		opciones='top=50px,left=150px, toolbar=0,resizable=0,menubar=0,status=1,width=480,height=350,scrollbars=1,resizable=yes';
		window.open(URL,"",opciones);
	}	
	else
		alert("Debe grabar antes de adjuntar")
}
function CargarXls()
{
	var f=document.FrmProceso;
	var URL='';
	var opciones='';
	if(f.TxtHoja.value!='' && (f.TxtHoja.value*1)!=0)
	{
		URL="sget_cargar_excel.php?ActualizaPag=S&formulario2=FrmProceso&Proceso=H&ID="+f.TxtHoja.value+"&Pagina=sget_hoja_ruta.php";
		opciones='top=50px,left=150px, toolbar=0,resizable=0,menubar=0,status=1,width=480,height=350,scrollbars=1,resizable=yes';
		window.open(URL,"",opciones);
	}	
	else
		alert("Debe grabar antes de adjuntar")
}
function DelFile(arch)
{
	var f=document.FrmProceso;
	var msg=confirm("�Desea Eliminar este Archivo?");
	if (msg==true)
	{
		
		if(f.Pagina.value!='')
		{	
			f.action="sgp_menu.php?Pagina="+f.Pagina.value+"&Elim=S&ArchivoElim="+arch;
			f.submit();
		}
		else
		{
			f.action="sgp_solp_proceso.php?Pagina="+f.Pagina.value+"&Elim=S&ArchivoElim="+arch;
			f.submit();
		}
	
	}
	else
	{
		return;
	}
}

</script>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
<form name="FrmProceso" action="" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" name="Pagina" value="<? echo 'sget_hoja_ruta.php';?>">
<input type="hidden" name="TxtHoja" value="<? echo $TxtHoja;?>">
<input type="hidden" name="Opt" value="<? echo $Opt;?>">
<input type="hidden" name="EsPopup" value="<? echo $EsPopup;?>">
  <?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'hoja_ruta.png')
 ?>
  <table width="950"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
  <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
      <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
            <td width="75%" align="center" class="formulario2"><span class="titulo_azul"> 
              <?
 		if($Opt == "M")
 		{
 			$Colspan=7;
			?>
              NUMERO OTORGADO POR EL SISTEMA </span><font style="FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #9c3031; FONT-FAMILY: Arial, Helvetica, sans-serif"><? echo $TxtHoja; ?></font>&nbsp; 
              <?
		}
		else
			echo "&nbsp;";
		?>
            </td>
        <td width="25%" align="right" class="formulario2">
		<?
		 if(!isset($EsPopup)||$EsPopup!='S')
		 {
		 ?>
	     <a href="JavaScript:Proceso('N','','')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
         &nbsp; 
		 <?
		 }
		 if($Opt=='M')
		 {
			?>
			<a href="sget_hoja_ruta_pdf.php?NumHR=<? echo $TxtHoja;?>" target="_blank"><img src="archivos/acrobat2.png"  alt="Hoja Ruta" border="0" align="absmiddle" /></a>
			
			<?
		 }
		 else
		 {
			?>
		 	<a href="JavaScript:Proceso('GC','','')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a>&nbsp;
		 	<?
		 }
		 if($EsPopup=='S')
		 {
		 ?>
		 <a href="JavaScript:Proceso('S','S','')"><img src="archivos/volver2.png"  border="0"  alt=" Salir " align="absmiddle"></a></div>
     	 <?
		 }
		 else
		 {
		 ?>
		 <a href="JavaScript:Proceso('S','','')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a></div>
		 <?
		 }
		 ?>		</td>
      </tr>
      <tr>
        <td class="formulario2">Adjuntar Documento
          <? 
 		if($TxtHoja=='')
 			$Atachar='N';
		else
			$Atachar='M';
 		?>
          <a href="JavaScript:Atachar('<? echo $Atachar;?>');"><img src="archivos/atachar2.png"  alt="Grabe el Requerimiento antes de Adjuntar Archivos" border="0" align="absmiddle" /></a>
          <?
		$CantDocs=0;
		$Consulta="Select count(num_hoja_ruta) as Cantidad from sget_documentos where num_hoja_ruta='".$TxtHoja."' and cod_referencia='H'";
		//echo $Consulta;
		$RespDoc=mysql_query($Consulta);
		if($FilaDoc=mysql_fetch_array($RespDoc))
			$CantDocs=$FilaDoc[Cantidad];
		$ArrArchivos = array();
		$Dir='doc';
		$Directorio=opendir('doc');
		$i=0;
		while ($Archivo = readdir($Directorio)) 
		{
			if($Archivo != '..' && $Archivo !='.' && $Archivo !='')
			{ 		
				//echo str_pad($TxtSolP,9,'0',STR_PAD_LEFT)."   =    ".substr($Archivo,4,9);
				if(str_pad($TxtSolP,9,'0',STR_PAD_LEFT)==substr($Archivo,4,9) && substr($Archivo,0,1)=='S')
					$CantDocs++;
			}
			$i++;
		}
		closedir($Directorio);		
	 	if($CantDocs>0)
		{
	 		?>
Cant. Docts <a href="JavaScript:Documentos('<? echo $TxtHoja;?>');"><? echo $CantDocs; ?></a>
<?
	 	}	
	 	?></td>
        <td class="formulario2">&nbsp;</td>
      </tr>
    </table>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="6" align="center" class="TituloTablaVerde">DATOS EMPRESA </td>
          </tr>
        <tr>
          <td width="9%" class="formulario2">Raz&oacute;n Social</td>
          <td width="35%" class="formulario2">
            <?
	   if($TxtHoja=='')
	   {
	   ?>
            <SELECT name="CmbEmpresa" id="CmbEmpresa" style="width:250" onchange="Recarga('<? echo $Opt;?>');" >
              <option value="-1" class="NoSelec">Seleccionar / Agregar</option>
              <?
	  	$Consulta = "SELECT * from sget_contratistas order by razon_social ";
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEmpresa==$FilaTC["rut_empresa"])
			{
				echo "<option SELECTed value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
				$Rut=$FilaTC[rut_empresa];
				$Domicilio=$FilaTC[calle];
				$Fono=$FilaTC[telefono_comercial];
				$EMail=$FilaTC[mail_empresa];
				$CodMutual=$FilaTC[cod_mutual_seguridad];
				$FechaVenc=$FilaTC[fecha_ven_cert];
				$NroRegic=$FilaTC[nro_regic];
				$NroRegistro=$FilaTC[nro_registro];
				
			}
			else
				echo "<option value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
		}
		?>
            </SELECT>&nbsp;<a href="JavaScript:Proceso('Emp')"><img src="archivos/btn_agregar2.png" height="20" width="20" alt="Agregar "align="absmiddle" border="0"></a>
            <? 
	   }
	   else
	   {
	   		echo "<input type='hidden' name='CmbEmpresa' value='".$CmbEmpresa."'>";
			$VarEmp=DescripEmpresa($CmbEmpresa);
	   		$array=explode('~',$VarEmp);
			echo FormatearNombre($array[1]);
			$Rut=FormatearRun($array[0]);
			$Domicilio=$array[2];
			$Fono=$array[3];
			$EMail=$array[4];
			$CodMutual=$array[5];
			$FechaVenc=$array[6];
			$NroRegic=$array[7];
			$NroRegistro=$array[8];
	   
	   }
	  /* echo $CmbEmpresa."<br>";
	   echo $Consulta1."<br>";*/  ?>          </td>
          <td width="7%" class="formulario2">RUT</td>
          <td align="left" class="formulariosimple"><? echo FormatearRun($Rut);?></td>
          <td align="left" class="formulario2">Fec.Venc.Certif.</td>
          <td align="left" class="formulariosimple"><? echo $FechaVenc; ?></td>
        </tr>
        <tr>
          <td class="formulario2">Domicilio</td>
          <td class="formulariosimple"><? echo $Domicilio ;?></td>
          <td class="formulario2">Fono</td>
          <td width="17%" align="left" class="formulariosimple"><? echo $Fono ;?></td>
          <td width="10%" class="formulario2">Mail</td>
          <td width="22%" align="left" class="formulariosimple"><? echo $EMail ;?></td>
          </tr>
        <tr>
          <td class="formulario2">N&ordm; Regic </td>
          <td class="formulariosimple"><? echo $NroRegic;?>&nbsp;</td>
          <td class="formulario2">Mutual</td>
          <td align="left" class="formulariosimple">
            <?
	   $DesMutual=DescripcionMutual($CodMutual);
	   echo $DesMutual;
	   ?></td>
          <td class="formulario2">N&ordm; Registro </td>
          <td align="left" class="formulariosimple"><? echo $NroRegistro;?>&nbsp;</td>
          </tr>
      </table>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="10" align="center" class="TituloTablaVerde">DATOS CONTRATO </td>
          </tr>
        <tr>
          <td width="9%" class="formulario2">Contrato</td>
          <td colspan="3" align="left" class="formulario2">
            <?
	   if($TxtHoja=='')
	   {
	   ?>
            <SELECT name="CmbContrato" style="width:250" onchange="Recarga('<? echo $Opt;?>');">
              <option value="S" SELECTed="SELECTed">Seleccionar / Agregar</option>
              <?
		$FechaActual=date("Y")."-".date("m")."-".date("d");
		$Consulta="SELECT * from sget_contratos where fecha_termino >= '".$FechaActual."' and rut_empresa='".$CmbEmpresa."' order by fecha_termino desc";
		$RespCtto=mysql_query($Consulta);
		while($FilaCtto=mysql_fetch_array($RespCtto))
		{
			if ($FechaActual > $FilaCtto[fecha_termino])
				$Color="red";
			else
				$Color='white';
			if(strtoupper($FilaCtto["cod_contrato"])==strtoupper($CmbContrato))
			{
				echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."' SELECTed>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
				if($TxtFechaCtto==''||$TxtFechaCtto=='0000-00-00')
					$TxtFechaCtto=$FilaCtto[fecha_termino];
				$FechaIniCtto=$FilaCtto[fecha_inicio];
				$FechaFinCtto=$FilaCtto[fecha_termino];
				$AdmCodelco=$FilaCtto["cod_contrato"];
				$AdmContratista=$FilaCtto["cod_contrato"];
				$CodGerencia=$FilaCtto[cod_gerencia];
				$CodArea=$FilaCtto["cod_area"];
				$TipoCtto=$FilaCtto[cod_tipo_contrato];
				$RutPrev=$FilaCtto[rut_prev];
			}	
			else
				echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."'>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
		}
		//CONTRATOS SUBCONTRATISTA
		$Consulta="SELECT t1.cod_contrato,t2.fecha_termino,t2.descripcion from sget_sub_contratistas t1 inner join sget_contratos t2 on t1.cod_contrato=t2.cod_contrato where t1.rut_empresa='".$CmbEmpresa."' and t1.rut_empresa!='' order by t2.fecha_termino desc";
		$RespCtto=mysql_query($Consulta);
		while($FilaCtto=mysql_fetch_array($RespCtto))
		{
			if ($FechaActual > $FilaCtto[fecha_termino])
				$Color="red";
			else
				$Color='white';
			if(strtoupper($FilaCtto["cod_contrato"])==strtoupper($CmbContrato))
			{
				echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."' SELECTed>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
				if($TxtFechaCtto==''||$TxtFechaCtto=='0000-00-00')
					$TxtFechaCtto=$FilaCtto[fecha_termino];
				$FechaIniCtto=$FilaCtto[fecha_inicio];
				$FechaFinCtto=$FilaCtto[fecha_termino];
				$AdmCodelco=$FilaCtto["cod_contrato"];
				$AdmContratista=$FilaCtto["cod_contrato"];
				$CodGerencia=$FilaCtto[cod_gerencia];
				$CodArea=$FilaCtto["cod_area"];
				$TipoCtto=$FilaCtto[cod_tipo_contrato];
				$RutPrev=$FilaCtto[rut_prev];
					
			}	
			else
				echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."'>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
		}
		
		?>
            </SELECT>&nbsp;<a href="JavaScript:Proceso('Contrato')"><img src="archivos/btn_agregar2.png" height="20" width="20" alt="Agregar "align="absmiddle" border="0"></a>
            <?
		}
		else
		{
	   		echo "<input type='hidden' name='CmbContrato' value='".$CmbContrato."'>";
			$VarCtto=DescripCtto($CmbContrato);
	   		$array=explode('~',$VarCtto);
			echo $array[0].' '.$array[1];
			$FechaIniCtto=$array[2];
			$FechaFinCtto=$array[3];
			$AdmCodelco=$array[0];
			$AdmContratista=$array[0];
			$CodGerencia=$array[4];
			$CodArea=$array[5];
			$TipoCtto=$array[6];
			$RutPrev=$array[7];
			
		}
		?></td>
          <td align="left" class="formulario2">Tipo </td>
          <td colspan="3" align="left" class="formulariosimple">
            <?
	   $Descripcion=DescripTipoCtto($TipoCtto);
	   echo $Descripcion;
	   ?>          </td>
          </tr>
        <tr>
          <td class="formulario2">Gerencia</td>
          <td colspan="3" align="left" class="formulariosimple">
            <? 
		  	$Gerencia=DescripcionGerencia($CodGerencia);
		  	echo $Gerencia; 
		  ?></td>
          <td width="10%" class="formulario2">Fecha Inicio </td>
          <td width="8%" align="left" class="formulariosimple"><? echo $FechaIniCtto; ?></td>
          <td width="7%" class="formulario2">FechaT&eacute;rm.</td>
          <td width="7%" align="left" class="formulariosimple"><? echo $FechaFinCtto; ?></td>
        </tr>
        <tr>
		<?
	   $VarCodelco=AdmCttoCodelco($AdmCodelco);
	   $array=explode('~',$VarCodelco);
		?>
        <td class="formulario2">Adm.Ctto Codelco&nbsp;</td>
          <td width="35%" class="formulariosimple"><? echo FormatearRun($array[0]);  ?>
            <?
	    echo " ".FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
	    ?></td>
          <td width="7%" class="formulario2">Fono&nbsp;&nbsp;</td>
          <td width="17%" class="formulariosimple"><? echo $array[4];  ?></td>
          <td class="formulario2">Area Trabajo</td>
          <td colspan="3" class="formulariosimple"><span class="formulariosimple">
            <? 
		  	$Area=DescripcionArea($CodArea);
		  	echo $Area; 
		  ?>
          </span></td>
          </tr>
        <tr>
		<?
	   $VarContratista=AdmCttoContratista($AdmContratista);
	   $array=explode('~',$VarContratista);
		?>
          <td align="left" class="formulario2"><span class="formulario2">Adm.Ctto. Contratista</span>&nbsp;          </td>
          <td align="left" class="formulariosimple"><? echo FormatearRun($array[0]);  ?>
            <?
	   echo " ".FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
	   ?></td>
          <td class="formulario2">Fono&nbsp;&nbsp;</td>
          <td class="formulariosimple"><? echo $array[4];  ?></td>
          <td class="formulario2"><span class="formulario2">E-Mail</span></td>
          <td colspan="3" align="left" class="formulariosimple"><? echo $array[5];  ?></td>
          </tr>
      </table>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="6" align="center" class="TituloTablaVerde">DATOS EXPERTO PREVENCION DE RIESGOS </td>
          </tr>
        <tr>
          <td width="10%" class="formulario2">Prev.Riesgos</td>
          <td width="29%" class="formulariosimple">
            <?
	   $VarPrev=DescripcionPrev($RutPrev);
	   $array=explode('~',$VarPrev);
	   echo FormatearNombre($array[0]).' '.FormatearNombre($array[1]).' '.FormatearNombre($array[2]); 
	   ?></td>
          <td width="9%" class="formulario2">N&ordm; Registro </td>
          <td width="17%" class="formulariosimple"><? echo $array[3];  ?></td>
          <td width="7%" class="formulario2">Categoria</td>
          <td width="28%" class="formulariosimple"><? echo $array[5];  ?></td>
        </tr>
      </table></td>
     <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
</table>
<br>
<table width="84%"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
   <tr>
      <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
      <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
      <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    </tr>
    <tr>
      <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" align="center" class="TituloTablaVerde">NOMINA</td>
        </tr>
          	<?
			if($Opt == "M")
 			{
			?>
	
      <tr>
            <td width="25%" class="formulario2"><span class="formulario2">Busqueda 
              Personal (Rut/Pasaporte)</span></td>
            <td width="83%" class="formulario2"> <input name="TxtRutPer" type="text" value="<? echo $TxtRutPer;?>" size="13" maxlength="14">
              &nbsp;Pasaporte &nbsp;
              <input type="checkbox" name="Pasaporte" value="checkbox"  <? echo $Optpasaporte;?>  class="SinBorde">

			  
			   <a href="JavaScript:Proceso('BUSRut','','')"><img src="archivos/Find2.png"  alt="Busca Personal"  border="0" align="absmiddle"  /></a> 
              &nbsp; <a href="JavaScript:Proceso('AN','','')"><img src="archivos/btn_agregar2.png"  border="0"  alt="Ingreso Personal" align="absmiddle" /></a> 
              &nbsp; <a href="JavaScript:CargarXls('');"><img src="archivos/ico_excel5.jpg"  alt="Carga Masiva de Nomina"  border="0" align="absmiddle"  /></a>	
              &nbsp;</td>
      </tr>
	  <?
	  }
	  ?>
    </table>
    <table width="940" align="center"  border="1" cellpadding="0"  cellspacing="0">
         <tr>
             <td width="8%" align="center"  class="TituloTablaVerde">M / E			</td>
			 <td width="10%" class="TituloTablaVerde" align="center">Ape. Paterno </td>
            <td width="10%" class="TituloTablaVerde" align="center">&nbsp;Ape.Materno </td>
            <td width="8%" class="TituloTablaVerde" align="center">Nombres</td>
            <td width="10%" class="TituloTablaVerde" align="center">Rut</td>
            <td width="8%" class="TituloTablaVerde" align="center">Fecha Nac </td>
            <td width="13%" class="TituloTablaVerde" align="center">Cargo Profesion </td>
            <td width="16%" class="TituloTablaVerde" align="center">Direccion</td>
            <td width="9%" class="TituloTablaVerde" align="center">Tipo Ctto.</td>
            <td width="10%" class="TituloTablaVerde" align="center">Credencial</td>
			<td width="10%" class="TituloTablaVerde" align="center">Fec.Fin.Ctto</td>
            <td width="6%" class="TituloTablaVerde" align="center">Cert.Ant</td>
          </tr>
		  <?
		  $Consulta="SELECT * from sget_hoja_ruta_nomina t1 inner join sget_personal t2 on t1.rut_personal=t2.rut ";
		  $Consulta.=" left join sget_cargos t3 on t3.cod_cargo=t2.cargo";
		  $Consulta.=" left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='30018' and t3.cod_subclase=t2.tipo_ctto";
		  $Consulta.=" where t1.num_hoja_ruta ='".$TxtHoja."'";
		
		  $RespDet=mysql_query($Consulta);
		  while($FilaDet=mysql_fetch_array($RespDet))
		  {
		  	?>
			<tr>
			<td><a href="JavaScript:Proceso('M','<? echo $TxtHoja; ?>','<? echo $FilaDet["rut"]; ?>')"><img src="archivos/btn_modificar.png"  border="0"  alt="Modifica Personal de Nomina" align="absmiddle" /></a>&nbsp;<a href="JavaScript:Proceso('EN','<? echo $TxtHoja; ?>','<? echo $FilaDet["rut"]; ?>')"><img src="archivos/elim_hito.png"  border="0"  alt="Elimina Personal de Nomina" align="absmiddle" /></a></td>
			<td width="10%"><? echo FormatearNombre($FilaDet[ape_paterno]); ?>&nbsp;</td>			  
			<td width="10%"><? echo FormatearNombre($FilaDet[ape_materno]); ?>&nbsp;</td>			  
			<td width="8%"><? echo FormatearNombre($FilaDet["nombres"]); ?>&nbsp;</td>			  
			<td width="10%"><? echo FormatearRun($FilaDet["rut"]); ?>&nbsp;</td>			  
			<td width="8%"><? echo $FilaDet[fec_nac]; ?>&nbsp;</td>			  
			<td width="13%"><? echo ucfirst(strtolower($FilaDet[descrip_cargo])); ?>&nbsp;</td>			  
			<td width="16%" ><? echo ucfirst(strtolower($FilaDet["direccion"])); ?>&nbsp;</td>			  
			<td width="9%" ><? echo $FilaDet["nombre_subclase"]; ?>&nbsp;</td>			  
			<td width="10%" ><? echo $FilaDet[nro_tarjeta]; ?>&nbsp;</td>
			<?
			if($FilaDet[fec_fin_ctto]=='0000-00-00'||$FilaDet[fec_fin_ctto]<=date('Y-m-d'))
				$ColorCelda="bgcolor='#FF0000'";
			?>
			<td width="10%" <? echo $ColorCelda;?> ><? echo $FilaDet[fec_fin_ctto]; ?>&nbsp;</td>			  
		  	<td width="6%" align="center" >
			<? if($FilaDet[certificado_ant] =='S')
			{
					if($FilaDet[fecha_certif]<>'0000-00-00')
					{
						$dif=resta_fechas(date('Y-m-d'),$FilaDet[fecha_certif]);
						if($dif>=0)
						{
							echo '<img src="archivos/rojo.gif"  border="0"  alt="Sin Certificado de Antecedente" align="center" />';
						}
						else
						{
							echo '<img src="archivos/verde.gif"  border="0"  alt="Con Certificado de Antecedentes" align="center" />'; 
			
						}
					}
					else
					{
						echo '<img src="archivos/rojo.gif"  border="0"  alt="Sin Certificado de Antecedente" align="center" />';
					}
				
			
			 } else
				echo '<img src="archivos/rojo.gif"  border="0"  alt="Sin Certificado de Antecedente" align="center" />';
								
			?></td>			  
			</tr>
			<?
		  }
		  ?>
        </table>	
	</td>
   <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
    </tr>
    <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
</table>


  
	  <?
  CierreEncabezado()
  ?>

	<?  
  if($Cadena!='')
{
?>
 <div id='Observacionxx'  style='FILTER: alpha(opacity=100); overflow:auto; VISIBILITY:visible; WIDTH:500px; height:180px; POSITION:absolute; moz-opacity: .75; opacity: .75;  left: 247px; top: 302px;'>

		<table width="100%"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
		<tr>
		<td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
		<td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
		<td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
		</tr>
		<tr>
		<td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td colspan="1" align="center" ><span class="InputRojo"> No se Cargaron las siguientes personas, debido a que se encuentran asociada a un contrato</span> </td>
		 <td colspan="1" align="right" > <a href="JavaScript:oculta('Observacionxx')"><img src="archivos/cerrar1.png" width="25" height="25" border="0" alt="Cerrar" align="absmiddle"></a> </td>
		
		</tr>
		</table>
		<table width="100%" align="center"  border="1" cellpadding="0"  cellspacing="0">
		<tr>
		<td width="10%" class="TituloTablaVerde" align="center">Ape. Paterno </td>
		<td width="10%" class="TituloTablaVerde" align="center">&nbsp;Ape.Materno </td>
		<td width="8%" class="TituloTablaVerde" align="center">Nombres</td>
		<td width="10%" class="TituloTablaVerde" align="center">Rut</td>
		<td width="8%" class="TituloTablaVerde" align="center">Contrato  </td>
		<td width="13%" class="TituloTablaVerde" align="center">Fecha Fin Contrato  </td>
		</tr>
		
		  <?
	
		$CadenaRut=substr($Cadena,0,strlen($Cadena)-1);
		$CadenaRut="(".str_replace(".","'",$CadenaRut).")";
		
		$Consulta="SELECT * from sget_personal t1 ";
		$Consulta.=" where rut in $CadenaRut";
		$RespDet=mysql_query($Consulta);
		while($FilaDet=mysql_fetch_array($RespDet))
		{
		?>
		<tr>
		<td width="10%"><? echo FormatearNombre($FilaDet[ape_paterno]); ?>&nbsp;</td>			  
		<td width="10%"><? echo FormatearNombre($FilaDet[ape_materno]); ?>&nbsp;</td>			  
		<td width="8%"><? echo FormatearNombre($FilaDet["nombres"]); ?>&nbsp;</td>			  
		<td width="10%"><? echo FormatearRun($FilaDet["rut"]); ?>&nbsp;</td>			  
		<td width="13%"><? echo $FilaDet["cod_contrato"]; ?>&nbsp;</td>			  
		<td width="13%"><? echo $FilaDet[fec_fin_ctto]; ?>&nbsp;</td>	
		</tr>
		<?
		}
		?>
		</table>	
		</td>
		<td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
		</tr>
		<tr>
		<td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
		<td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
		<td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
		</tr>
		</table>
  </div> 
		</td>
		</tr>
		</table>

<? }?>
</form>
<? 
if($Error=='S')
{
echo "<script languaje='JavaScript'>";
		echo "alert('Problema al Cargar el Excel, Archivo No Cargado')";
echo "</script>";
}
if($Error=='X')
{
?>
<script languaje='JavaScript'>
		alert('Nomina de personas a Cargar no pertenecen al Contrato.\n Verifique el Excel que internta cargar')
</script><?
}
if($Error=='RUTNO')
{
?>
<script languaje='JavaScript'>
		alert('Rut No Encontrado en el Sistema')
</script><?
}
?>