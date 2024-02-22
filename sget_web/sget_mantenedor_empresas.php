<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
//if(!isset($Cons))
//	$Cons='S';
if(!isset($CmbCiudad))	
	$CmbCiudad='-1';	
	
?>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function NuevoUser(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
			f.action='sget_mantenedor_empresas.php?Cons=S';
			f.submit();
			break;
		case "N":
			URL="sget_mantenedor_empresas_proceso.php?Opc="+Opc;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=750,height=700,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckRut','M'))
			{
				Datos=Recuperar(f.name,'CheckRut');
				//alert (Datos);
				URL="sget_mantenedor_empresas_proceso.php?Opc="+Opc+"&Valores="+Datos;
				opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=750,height=700,scrollbars=1';
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
			}	
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckRut','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckRut');
					f.action='sget_mantenedor_empresas01.php?Opcion=E&Valor='+Datos;
					f.submit();
				}	
			}
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=32";
		break;
	}	
}
</script>
<title>Mantenedor de Empresa</title>
<style type="text/css">
<!--
body {
	/*background-image: url(archivos/f1.gif);*/
}
-->
</style>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="" >
 <? include("encabezado.php")?>

 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top">
 <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
              <td width="271"><img src="archivos\Titulos\mant_empresas.png"></td>
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
  <table width="950"  border="0" align="center"  cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td><table width="920" align="center"  cellspacing="0">
          <tr>
            <td height="35" colspan="4" align="left" class="FilaAbeja2"   ><img src="archivos/images/interior/t_buscadorGlobal4.png" /> </td>
            <td colspan="2" align="right" class="FilaAbeja2" >
			<a href="JavaScript:NuevoUser('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:NuevoUser('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:NuevoUser('M')"><img src="archivos/btn_modificar3.png" border="0" alt="Modificar" align="absmiddle"></a>&nbsp;
			<a href="JavaScript:NuevoUser('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>&nbsp;	
			<a href="JavaScript:NuevoUser('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>            </td>
          </tr>
          <tr>
            <td width="13%" class="FilaAbeja2">Razon Social </td>
            <td width="36%" class="FilaAbeja2"><input name="TxtRazon" type="text" id="TxtRazon" value="<? echo $TxtRazon; ?>" size="30" /></td>
            <td class="FilaAbeja2">Nro Regic </td>
            <td width="17%" class="FilaAbeja2"><input name="TxtRegic" type="text" id="TxtRegic" value="<? echo $TxtRegic; ?>" /></td>
            <td width="12%" class="FilaAbeja2">&nbsp;</td>
            <td width="13%" class="FilaAbeja2">&nbsp;</td>
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
		  
		  ?>
          </tr>
          <tr>
            <td class="FilaAbeja2">Nombre Fantasia </td>
            <td class="FilaAbeja2"><input name="TxtNombreFantasia" type="text" id="TxtNombreFantasia" value="<? echo $TxtNombreFantasia; ?>" size="30" /></td>
            <td width="9%" class="FilaAbeja2">Ciudad</td>
            <td colspan="3" class="FilaAbeja2"><SELECT name="CmbCiudad" >
              <option value="-1" class="NoSelec">Todos</option>
              <?
			$Consulta = "SELECT * from sget_ciudades order by nom_ciudad ";			
			$Resp1=mysql_query($Consulta);
			while ($Fila1=mysql_fetch_array($Resp1))
			{
				if ($CmbCiudad==$Fila1["cod_ciudad"])
					echo "<option SELECTed value='".$Fila1["cod_ciudad"]."'>".ucfirst($Fila1["nom_ciudad"])."</option>\n";
				else
					echo "<option value='".$Fila1["cod_ciudad"]."'>".ucfirst($Fila1["nom_ciudad"])."</option>\n";
			}
			?>
            </SELECT></td>
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
  <br/>
  <table width="955"   border="0" align="center" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
    <tr>
      <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
      <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
      <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    </tr>
    <tr>
      <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
      <td><table width="928" border="1" align="center" cellpadding="2" cellspacing="0">
            <tr>
              <td width="4%" class="TituloTablaVerde"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onclick="CheckearTodo(this.form,'CheckRut','ChkTodos');" /></td>
              <td width="14%" align="center" class="TituloTablaVerde">Rut</td>
			  <td width="31%" align="center" class="TituloTablaVerde">Raz�n Social</td>
              <td width="17%" align="center" class="TituloTablaVerde">E-Mail</td>
              <td width="10%" align="center" class="TituloTablaVerde">Telefono</td>
              <td width="10%" align="center" class="TituloTablaVerde">N� Regic</td>
              <td width="8%" align="center" class="TituloTablaVerde">Estado</td>
            </tr>
            <?


	
if($Cons=='S')
{
	$Consulta = "SELECT t1.rut_empresa,t1.razon_social,t1.mail_empresa,t1.telefono_comercial,t1.nro_regic,t2.nombre_subclase as estado_emp from sget_contratistas t1 ";
	$Consulta.=" left join  proyecto_modernizacion.sub_clase t2  on t1.estado=t2.cod_subclase and t2.cod_clase='30007'";
	$Consulta.=" where not isnull(rut_empresa)  ";
	if($RutEmp!='')
		$Consulta.=" and  rut_empresa='".$RutEmp."' ";
	if($CmbCiudad!='-1')
		$Consulta.=" and  cod_ciudad='".$CmbCiudad."' ";
	if($TxtRegic!='')
		$Consulta.= " and nro_regic like ('%".$TxtRegic."%') ";
	if($TxtRazon!='')
		$Consulta.= " and upper(razon_social) like ('%".strtoupper($TxtRazon)."%') ";
	if($TxtNombreFantasia!='')
		$Consulta.= " and upper(nombre_fantasia) like ('%".strtoupper($TxtNombreFantasia)."%') ";
	$Resp = mysql_query($Consulta);
	//echo $Consulta;
	echo "<input name='CheckRut' type='hidden'  value=''>";
	$Cont=1;
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Par=($Cont % 2);
		if($Par==1)
		{
			?>
            <tr class="FilaAbeja" >
              <?
		}
		else
		{
			?>
            </tr>
            <tr class="FilaAbeja">
              <? 
		}
		
		$Rut=FormatearRun($Fila["rut_empresa"]);
		$Nom=FormatearNombre($Fila["razon_social"]);

		?>
              <td ><? echo "<input name='CheckRut' class='SinBorde' type='checkbox'  value='".$Fila["rut_empresa"]."'>" ?></td>
                  <td ><a href="sget_info_empresa.php?Emp=<? echo $Fila["rut_empresa"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Empresa" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;<? echo $Rut."&nbsp;"; ?></td>
			  <td ><? echo $Nom."&nbsp;"; ?></td>
              <td ><? echo $Fila["mail_empresa"]."&nbsp;"; ?></td>
              <td ><? echo $Fila["telefono_comercial"]."&nbsp;"; ?></td>
              <td ><? echo $Fila["nro_regic"]."&nbsp;"; ?></td>
              <td ><? echo $Fila["estado_emp"]."&nbsp;"; ?></td>
            </tr>
            <?		$Cont++;
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
  </table>  <p>
  </td>
    </tr>
  </table>
	<? include("pie_pagina.php")?>
</form>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje!='')
		echo "alert('".$Mensaje."');";
	echo "</script>";
?>