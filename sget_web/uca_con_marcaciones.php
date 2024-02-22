<?
	$CodigoDeSistema=27;
	$CodigoDePantalla=35;
	include("../principal/conectar_sget_web.php");
	if (!isset($TxtFechaIni))
	{
		$TxtFechaIni=date("Y-m-d");
	}
	if (!isset($TxtFechaFin))
	{
		$TxtFechaFin=date("Y-m-d");
	}
?>
<html>
<head>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action="uca_con_marcaciones_web.php?Mostrar=S";
			f.submit();
			break;		
		case "E":
			f.action="uca_con_marcaciones_excel.php?Mostrar=S";
			f.submit();
			break;		
		case "R":
			f.action="uca_con_marcaciones.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=22";
			f.submit();
			break;
	}
}
function MuestraCapa(id, opcion)
{
	var f=document.frmPrincipal;
	switch (opcion)
	{
		case "M":
			eval("Div"+id+".style.visibility='visible'");
			break;
		case "C":
			eval("Div"+id+".style.visibility='hidden'");
			break;
	}
}
function Buscar(letra)
{
	var f=document.frmPrincipal;
	f.CmbEmpresa.value="S";
	window.location="uca_con_empresas.php?Mostrar=S&Letra="+letra;
}
function DetalleContrato(emp, cont)
{
	var f=document.frmPrincipal;
	var url="uca_con_empresas_detalle_contrato.php?IdEmpresa="+emp+"&IdContrato="+cont;
	window.open(url,"","top=20;left=20,width=550,height=400,resizable=yes,scrollbars=yes");
}
function BuscarEmp()
{
	var f = document.frmPrincipal;
	
	f.action='uca_con_marcaciones.php?BuscarEmp=S';
	f.submit();
}
</script>
<title>Consulta de Marcaciones</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="frmPrincipal" method="post" action="">
<? 
	include("../principal/encabezado.php");
	include("../principal/conectar_sget_web.php");

?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td>
	  <table width="750" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr align="center" bgcolor="#FFFFFF">
            <td colspan="2" class="Detalle01"><em>CONSULTA DE MARCACIONES</em></td>
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;Fecha: </td>
            <td align="left"><input name="TxtFechaIni" type="text" class="InputCen" value="<? echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al
              <input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<? echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"></td>
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;Empresa:</td>
            <td align="left">Buscar&nbsp;&nbsp;
              <input name="TxtBuscaEmp" type="text" value="<? echo $TxtBuscaEmp;?>" size="15" maxlength="10">
              <span class="ColorTabla02">
              <input name="BtnBuscar" type="button" value="Ok" onClick="BuscarEmp()">
              </span>
              <SELECT name="CmbEmpresa" style="width:400" onChange=Proceso('R')>
                <option class="NoSelec" value="S">TODOS</option>
                <?
				//$Consulta = "SELECT distinct t1.rut_empresa,t1.razon_social from sget_contratistas t1 inner join sget_contratos t2 on t1.rut_empresa =t2.rut_empresa  and t2.fecha_termino > '".date('Y-m-d')."'";
				$Consulta = "SELECT distinct t1.rut_empresa,t1.razon_social from sget_contratistas t1 ";
				$Consulta.= "where t1.razon_social<>''  and t1.rut_empresa<>'61704000-k'";
				if($TxtBuscaEmp!=''&&$BuscarEmp=='S')
					$Consulta.= "and  t1.razon_social like '%".$TxtBuscaEmp."%' ";
				$Consulta.= "order by t1.razon_social asc";
				$Resp=mysql_query($Consulta); 
				while ($Fila=mysql_fetch_array($Resp)) 
				{ 
					if ($CmbEmpresa == $Fila["rut_empresa"])
						echo "<option SELECTed value='".$Fila["rut_empresa"]."'>".str_pad($Fila["rut_empresa"],10,'0',STR_PAD_LEFT)." - ".strtoupper($Fila["razon_social"])."</option>";
					else
						echo "<option value='".$Fila["rut_empresa"]."'>".str_pad($Fila["rut_empresa"],10,'0',STR_PAD_LEFT)." - ".strtoupper($Fila["razon_social"])."</option>";
				}
				?>
              </SELECT>
            <? //echo $Consulta;?></td>
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;Contrato:</td>
            <td align="left"><SELECT name="CmbContrato" style="width:550" onChange="Proceso('R')">
              <option class="NoSelec" value="S">VER PERSONAL DE TODOS LOS CONTRATOS</option>
              <?
				$FechaActual=date("Y")."-".date("m")."-".date("d");
				$Consulta = "SELECT * from sget_contratos  ";
				$Consulta.= " where rut_empresa='".$CmbEmpresa."' ";
				$Consulta.= " order by cod_contrato asc";
				$Resp=mysql_query($Consulta); 
				while ($Fila=mysql_fetch_array($Resp)) 
				{ 
					if ($FechaActual > $Fila["fecha_termino"]){
						$Estado="C";$Color="red";}
					else{
						$Estado="A";$Color="white";}
					if ($CmbContrato == $Fila["cod_contrato"])
						echo "<option style='background:".$Color."' SELECTed value='".$Fila["cod_contrato"]."'>".$Estado." - ".$Fila["cod_contrato"]." - ".$Fila["descripcion"]."</option>";
					else
						echo "<option style='background:".$Color."' value='".$Fila["cod_contrato"]."'>".$Estado." - ".$Fila["cod_contrato"]." - ".$Fila["descripcion"]."</option>";
				}
				//CONTRATOS SUBCONTRATISTA
				$Consulta="SELECT t1.cod_contrato,t2.fecha_termino,t2.descripcion from sget_sub_contratistas t1 inner join sget_contratos t2 on t1.cod_contrato=t2.cod_contrato where t1.rut_empresa='".$CmbEmpresa."' and t1.rut_empresa!='' order by t2.fecha_termino desc";
				$RespCtto=mysql_query($Consulta);
				while($FilaCtto=mysql_fetch_array($RespCtto))
				{
					if ($FechaActual > $FilaCtto["fecha_termino"]){
						$Estado="C";$Color="red";}
					else{
						$Estado="A";$Color="white";}
					if ($CmbContrato == $FilaCtto["cod_contrato"])
						echo "<option style='background:".$Color."' SELECTed value='".$FilaCtto["cod_contrato"]."'>".$Estado." - ".$FilaCtto["cod_contrato"]." - ".$FilaCtto["descripcion"]."</option>";
					else
						echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."'>".$Estado." - ".$FilaCtto["cod_contrato"]." - ".$FilaCtto["descripcion"]."</option>";
				}
				
			  ?>
            </SELECT><? //echo $Consulta;?></td>
          </tr>
          <tr>
            <td width="100" class="Detalle02">&gt;&gt;Funcionario:</td>
            <td width="481" align="left"><SELECT name="CmbRut" style="width:350" onChange="Proceso('R')">
              <option class="NoSelec" value="S">VER TODO EL PERSONAL</option>
              <?
				$Consulta = "SELECT * from sget_personal t1  ";
				$Consulta.= " where t1.rut_empresa='".$CmbEmpresa."' ";
				if ($CmbContrato!="S")
					$Consulta.= " and t1.cod_contrato='".$CmbContrato."' ";
				$Consulta.= " and t1.nro_tarjeta<>'00000000' and estado<>'I' ";
				$Consulta.= " order by t1.ape_paterno, t1.ape_materno, t1.nombres";
				$Resp=mysql_query($Consulta); 
				$var1 = $Consulta;
				while ($Fila=mysql_fetch_array($Resp)) 
				{
					$Rut=substr($Fila["rut"],0,2).".".substr($Fila["rut"],2,3).".".substr($Fila["rut"],5,3)."-".substr($Fila["rut"],9,1);				
					$Nombre = ucwords(strtolower($Fila["ape_paterno"]." ".$Fila["ape_materno"]." ".$Fila["nombres"]));
					if ($CmbRut == $Fila["rut"])
						echo "<option SELECTed value='".$Fila["rut"]."'>".$Rut." ".$Nombre."</option>\n";
					else
						echo "<option  value='".$Fila["rut"]."'>".$Rut." ".$Nombre."</option>\n";
				}
			  ?>
            </SELECT></td>
			<? // echo $var1; ?>
          </tr>
          <tr align="center" bgcolor="#efefef"> 
            <td height="30" colspan="2">   
              <input type="button" name="BtnConsulta" value="Consulta" style="width:70" onClick="Proceso('C');">
			  <input type="button" name="BtnExcel" value="Excel" style="width:70" onClick="Proceso('E');">
		    <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');"></td>
          </tr>
        </table>
      <br>
      </td>
    </tr>
  </table>
      <? include("../principal/pie_pagina.php")?>
</form>
</body>
</html>