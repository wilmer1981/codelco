<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
	$FechaSist=date("d/m/Y");
	$matriz=split("/",$FechaSist);
	$dia=$matriz[0];
	$mes=$matriz[1];
	$a�o=$matriz[2];
	if($Recarga=='S')
	{
	  	$Consulta = "select tipo_carga from pcip_lista_excel where cod_excel='".$CmbExcel."'";
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Tipo=$Fila[tipo_carga];
	}
	if(!isset($Ano))
		$Ano=date('Y');	
	if(!isset($Mes))
		$Mes=date('m');	
	if(!isset($Ano2))
		$Ano2=date('Y');	
		
?>
<title>Carga de Excel</title>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
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
function Proceso(Opt,H,E)
{
	var f=document.FrmProceso;
	switch (Opt)
	{
		case "GE"://GENERAR EXCEL		
			if(f.CmbExcel.value=='-1')
			{
				alert('Debe Seleccionar Excel a Procesar');
				f.CmbExcel.focus();
				return;
			}
			if(f.Archivo.value=='')
			{
				alert('Debe Seleccionar Documento');
				f.Archivo.focus();
				return;
			}
			f.action='pcip_carga_excel01.php?Proceso='+f.CmbExcel.value;
			f.submit();		
		break;
		case "E"://ELIMINAR CARGA EXCEL
			URL="../pcip_web/pcip_carga_excel_eliminar_proceso.php";
			window.open(URL,"","top=30,left=150,width=900,height=350,status=yes,menubar=no,resizable=yes,scrollbars=yes");
		break;
		case "CE"://CONFIGURACION EXCEL
			URL="../pcip_web/pcip_carga_excel_proceso.php";
			window.open(URL,"","top=30,left=30,width=900,height=350,status=yes,menubar=no,resizable=yes,scrollbars=yes");
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=1";
		break;
	}
}
function Recarga(Opt) 
{
	var f=document.FrmProceso;
	f.action='pcip_carga_excel.php?Recarga=S';
	f.submit();
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
 EncabezadoPagina($IP_SERV,'carga_archivo_excel.png')
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
        <td width="75%" align="center" class="formulario2">&nbsp;</td>
        <td width="25%" align="right" class="formulario2">
		<a href="JavaScript:Proceso('GE','','')"><img src="archivos/btn_guardar.png" alt="Procesar Excel"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Proceso('CE','','')"><img src="archivos/ico_excel5.jpg" alt="Configuraci�n Excel"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Proceso('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar Excel " align="absmiddle" border="0"></a>
	    <a href="JavaScript:Proceso('S','','')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>
      </td>
      </tr>  
      <tr>
        <td class="formulario2">&nbsp;</td>
        <td class="formulario2">&nbsp;</td>
      </tr>
    </table>
	  <table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td colspan="6" align="center" class="TituloTablaVerde">CARGA DE EXCEL </td>
          </tr>
        <tr>
          <td width="11%" class="formulario2">Excel</td>
          <td width="36%" class="formulario2">
            <select name="CmbExcel" style="width:250" onchange="Recarga();" >
              <option value="-1" class="NoSelec">Seleccionar</option>
              <?
				$Consulta = "select * from pcip_lista_excel where vigente='S' order by orden ";
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbExcel==$FilaTC["cod_excel"])
						echo "<option selected value='".$FilaTC["cod_excel"]."'>".ucfirst($FilaTC["nom_excel"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_excel"]."'>".ucfirst($FilaTC["nom_excel"])."</option>\n";
				}
				?>
            </select></td>
          <td width="9%" class="formulario2">&nbsp;</td>
          <td width="12%" align="left" class="formulariosimple">&nbsp;</td>
          <td width="10%" align="left" class="formulario2">&nbsp;</td>
          <td width="22%" align="left" class="formulariosimple">&nbsp;</td>
        </tr>
		<? 
		if($Tipo=='A'||$Tipo=='M')
		{
		?>
        <tr>
          <td class="formulario2">A&ntilde;o</td>
          <td class="formulario2"><select name="Ano" id="Ano" onchange="Recarga();">
              <?
				for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
				{
					if ($i==$Ano)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}
			  ?>
            </select></td>
          <td class="formulario2">&nbsp;</td>
          <td align="left" class="formulariosimple">&nbsp;</td>
          <td align="left" class="formulario2">&nbsp;</td>
          <td align="left" class="formulariosimple">&nbsp;</td>
        </tr>
		<?
		}
		if($Tipo=='M')
		{		
		?>
        <tr>
          <td class="formulario2">Mes</td>
          <td class="formulario2"><select name="Mes" id="Mes">
            <?
	for ($i=1;$i<=12;$i++)
	{
		if ($i==$Mes)
			echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		else
			echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
	}
?>
          </select></td>
          <td class="formulario2">&nbsp;</td>
          <td align="left" class="formulariosimple">&nbsp;</td>
          <td align="left" class="formulario2">&nbsp;</td>
          <td align="left" class="formulariosimple">&nbsp;</td>
        </tr>
		<?
		}
		if($Tipo=='A'||$Tipo=='M')
		{
		?>
        <tr>
          <td class="formulario2"><span class="formulario2">Documento Excel</span></td>
          <td class="formulario2"><input type="file" name="Archivo" id="Archivo" /></td>
          <td class="formulario2">&nbsp;</td>
          <td align="left" class="formulariosimple">&nbsp;</td>
          <td align="left" class="formulario2">&nbsp;</td>
          <td align="left" class="formulariosimple">&nbsp;</td>
        </tr>
        <tr>
          <td class="formulario2">&nbsp;</td>
          <td class="formulario2">&nbsp;</td>
          <td class="formulario2">&nbsp;</td>
          <td align="left" class="formulariosimple">&nbsp;</td>
          <td align="left" class="formulario2">&nbsp;</td>
          <td align="left" class="formulariosimple">&nbsp;</td>
        </tr>
				
		<?
		}
		?>
		</table><br>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr><td colspan="13" class="TituloTablaVerde" align="center">INDICADOR DE DATOS PROCESADOS A�O 
              <select name="Ano2" id="select" onchange="Recarga();">
                <?
					for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
					{
						if ($i==$Ano2)
							echo "<option selected value=\"".$i."\">".$i."</option>\n";
						else
							echo "<option value=\"".$i."\">".$i."</option>\n";
					}
				?>
              </select>
           </td>
            </tr>
			<tr>
              <td align="center" class="TituloTablaVerde">TIPO</td>
              <td align="center" class="TituloTablaVerde">ENE</td>
              <td align="center" class="TituloTablaVerde">FEB</td>
              <td align="center" class="TituloTablaVerde">MAR</td>
              <td align="center" class="TituloTablaVerde">ABR</td>
              <td align="center" class="TituloTablaVerde">MAY</td>
              <td align="center" class="TituloTablaVerde">JUN</td>
              <td align="center" class="TituloTablaVerde">JUL</td>
              <td align="center" class="TituloTablaVerde">AGO</td>
              <td align="center" class="TituloTablaVerde">SEP</td>
              <td align="center" class="TituloTablaVerde">OCT</td>
              <td align="center" class="TituloTablaVerde">NOV</td>
              <td align="center" class="TituloTablaVerde">DIC</td>
            </tr>
			<?
				$Consulta = "select valor,nom_excel,tipo_excel from pcip_lista_excel where vigente='S' order by orden ";
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					echo "<tr>";
					echo "<td class='texto_bold'>&nbsp;".$Fila[nom_excel]."</td>";
					for($i=1;$i<=12;$i++)
					{
						if(ExisteDatoIng($Fila[valor],$Fila[tipo_excel],$Ano2,$i))
							echo "<td class='FilaAbeja' align='center'><img src='archivos/activo.jpg' width='15' height='15'></td>";
						else
							echo "<td class='FilaAbeja'>&nbsp;</td>";
					}
					echo "</tr>";
				}
			?>
          </table>
	  </td>
    <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
</table>
<br>
<?
  CierreEncabezado()
  ?>
<?  
  if($Cadena!='')
{
?>
</td>
</tr>
</table>
<? }?>
</form>
<? 
function ExisteDatoIng($CodSumi,$TipoExcel,$Ano,$Mes)
{
	switch($TipoExcel)
	{
		case "P"://PRESUMINISTRO
		case "S"://SUMINISTRO
			$Consulta="select * from pcip_eec_suministros_detalle where cod_suministro='".$CodSumi."' and tipo='".$TipoExcel."' and ano='".$Ano."' and mes='".$Mes."' and cod_cc<>''";
			//echo $Consulta."<br>";
			$Resp2=mysqli_query($link, $Consulta);
			if($Fila2=mysql_fetch_array($Resp2))
				return(true);
			else
				return(false);
		break;
		case "CDV"://CUADRO DIARIO VENTAS
			$Consulta="select * from pcip_cdv_cuadro_diario_ventas where ano='".$Ano."' and mes='".$Mes."'";
			//echo $Consulta."<br>";
			$Resp2=mysqli_query($link, $Consulta);
			if($Fila2=mysql_fetch_array($Resp2))
				return(true);
			else
				return(false);
		break;
		case "EER"://ESTADO RESULTADO
			$Consulta="select * from pcip_ere_estado_resultado where ano='".$Ano."' and mes='".$Mes."'";
			//echo $Consulta."<br>";
			$Resp2=mysqli_query($link, $Consulta);
			if($Fila2=mysql_fetch_array($Resp2))
				return(true);
			else
				return(false);
		break;		
		case "RHO"://ESTADO RESULTADO ORGANICA
			$Consulta="select * from pcip_organica";
			//echo $Consulta."<br>";
			$Resp2=mysqli_query($link, $Consulta);
			if($Fila2=mysql_fetch_array($Resp2))
				return(true);
			else
				return(false);
		break;		
		case "RHS"://ESTADO RESULTADO SOBRETIEMPO
			$Consulta="select * from pcip_sobretiempo where ano='".$Ano."' and mes='".$Mes."'";
			//echo $Consulta."<br>";
			$Resp2=mysqli_query($link, $Consulta);
			if($Fila2=mysql_fetch_array($Resp2))
				return(true);
			else
				return(false);
		break;		
		case "RHA"://ESTADO RESULTADO SOBRETIEMPO
			$Consulta="select * from pcip_ausentismo where ano='".$Ano."' and mes='".$Mes."'";
			//echo $Consulta."<br>";
			$Resp2=mysqli_query($link, $Consulta);
			if($Fila2=mysql_fetch_array($Resp2))
				return(true);
			else
				return(false);
		break;		
		case "IP"://INGRESOS PROYECTADOS
			$Consulta="select * from pcip_inp_tratam where ano='".$Ano."' and mes='".$Mes."'";
			//echo $Consulta."<br>";
			$Resp2=mysqli_query($link, $Consulta);
			if($Fila2=mysql_fetch_array($Resp2))
				return(true);
			else
				return(false);
		break;		
		
	}				
}
if(isset($Mensaje)&&$Mensaje!='')
{
	echo "<script languaje='JavaScript'>";
	echo "alert('".$Mensaje."')";
	echo "</script>";
}

/*echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Archivo Cargado Exitosamente');";
	if ($Mensaje=='2')
		echo "alert('Excel Eliminado Correctamente');";
echo "</script>";*/
?>