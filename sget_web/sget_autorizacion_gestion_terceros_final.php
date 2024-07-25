<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$CodSistema=30;
$CodPantalla=18;

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
			if(f.CmbEstado.value !='S')
			{
				f.action='sget_autorizacion_gestion_terceros_final.php?Cons=S';
				f.submit();
			}
			else
			{
				alert("Seleccione Estado a Buscar");
				f.CmbEstado.focus();
			}	
			break;
		case "E":
			if(SoloUnElemento(f.name,'CheckHoja','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckHoja');
					f.action='sget_autorizacion_gestion_terceros01.php?Opcion=E&Valor='+Datos;
					f.submit();
				}	
			}
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=0";
		break;
	}	
}
function Obs(H,HR,Mos)
{
	var f=document.FrmPrincipal;
	URL="sget_detalle_obs_hito.php?H="+H+"&NumHoja="+HR+"&CodSistema="+f.CodSistema.value+"&CodPantalla="+f.CodPantalla.value+"&Mos="+Mos;
	opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=700,height=350,scrollbars=1';
	popup=window.open(URL,"",opciones);
	popup.focus();
}
function Recarga(Opt) 
{
	var f=document.FrmPrincipal;
	f.action='sget_autorizacion_gestion_terceros_final.php';
	f.submit();
}
function Auto(H,HR) 
{
	var f=document.FrmPrincipal;
	f.action='sget_autorizacion_adm_ctto01.php?H='+H+'&NumHoja='+HR+'&Proceso=A';
	f.submit();
}
function Rech(H,HR) 
{
	var f=document.FrmPrincipal;
	f.action='sget_autorizacion_adm_ctto01.php?H='+H+'&NumHoja='+HR+'&Proceso=RECH';
	f.submit();
}
</script>
<title>Autorizacion Gesti�n Final</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="" >
<input name="CodSistema" type="hidden" value="<? echo $CodSistema; ?>">
<input name="CodPantalla" type="hidden" value="<? echo $CodPantalla; ?>">
  <table width="84%"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15" /></td>
      <td height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
      <td><table width="100%"  cellspacing="0">
          <tr>
            <td height="35" colspan="4" align="left" class="formulario"   ><img src="archivos/images/interior/t_buscadorGlobal.png" /> </td>
            <td colspan="2" align="right" class="formulario" ><a href="JavaScript:NuevoUser('C')"><img src="archivos/Find.png"   alt="Buscar"  border="0" align="absmiddle" /></a>&nbsp; 
			<!--<a href="JavaScript:NuevoUser('M')"><img src="archivos/btn_modificar.png" border="0" alt="Modificar" align="absmiddle" /></a>&nbsp;-->
			<!-- <a href="JavaScript:NuevoUser('E')"><img src="archivos/elim_hito.png"  alt="Eliminar " align="absmiddle" border="0" /></a>&nbsp;--> <a href="JavaScript:NuevoUser('S')"><img src="archivos/volver.png"  border="0"  alt=" Volver " align="absmiddle" /></a> </td>
          </tr>
          <tr>
            <td class="formulario">Contrato</td>
            <td class="formulario"><SELECT name="CmbContrato" style="width:250" onchange="Recarga('<? echo $Opt;?>');">
                <option value="S" SELECTed="SELECTed">Seleccionar</option>
                <?
		$FechaActual=date("Y")."-".date("m")."-".date("d");
		$Consulta="SELECT * from sget_contratos order by fecha_termino desc";
		$RespCtto=mysqli_query($link, $Consulta);
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
				$FechaIniCtto=$FilaCtto["fecha_inicio"];
				$FechaFinCtto=$FilaCtto[fecha_termino];
				$AdmCodelco=$FilaCtto["cod_contrato"];
				$AdmContratista=$FilaCtto["cod_contrato"];
				$AreaTrabajo=$FilaCtto[area_trabajo];
				$TipoCtto=$FilaCtto[cod_tipo_contrato];
				$RutPrev=$FilaCtto[rut_prev];
			}	
			else
				echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."'>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
		}
		?>
              </SELECT>            </td>
            <td class="formulario">Nro Hoja Ruta </td>
            <td class="formulario"><input name="TxtHoja" type="text" id="TxtRegic" value="<? echo $TxtHoja; ?>" /></td>
            <td class="formulario">&nbsp;</td>
            <td class="formulario">&nbsp;</td>
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
            <td class="formulario">Empresa</td>
            <td class="formulario"><SELECT name="CmbEmpresa" id="CmbEmpresa" style="width:250" onchange="Recarga('<? echo $Opt;?>');" >
                <option value="-1" class="NoSelec">Seleccionar</option>
                <?
	  	$Consulta = "SELECT * from sget_contratistas t1 inner join sget_contratos t2 on t1.rut_empresa=t2.rut_empresa where t2.cod_contrato ='".$CmbContrato."'order by razon_social ";
		$Resp=mysqli_query($link, $Consulta);
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
				
			}
			else
				echo "<option value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
		}
		?>
                <option value="*">---SubContratistas---</option>
                <?
		$Consulta1 = "SELECT t2.rut_empresa,t1.razon_social from sget_contratistas t1 inner join sget_sub_contratistas t2 ";
		$Consulta1.= "on t1.rut_empresa=t2.rut_empresa where t2.cod_contrato ='".$CmbContrato."'order by razon_social ";
		$RespSub=mysql_query($Consulta1);
		while ($FilaSub=mysql_fetch_array($RespSub))
		{
			if ($CmbEmpresa==$FilaSub["rut_empresa"])
			{
				echo "<option SELECTed value='".$FilaSub["rut_empresa"]."'>".ucfirst($FilaSub["razon_social"])."</option>\n";
				$Rut=$FilaSub[rut_empresa];
				$Domicilio=$FilaSub[calle];
				$Fono=$FilaSub[telefono_comercial];
				$EMail=$FilaSub[mail_empresa];
				$CodMutual=$FilaSub[cod_mutual_seguridad];
				$FechaVenc=$FilaSub[fecha_ven_cert];
				
			}
			else
				echo "<option value='".$FilaSub["rut_empresa"]."'>".ucfirst($FilaSub["razon_social"])."</option>\n";
		}
		?>
              </SELECT>            </td>
            <td width="21%" class="formulario">A&ntilde;o Ingreso </td>
            <td colspan="3" class="formulario"><span class="borderbajo">
              <SELECT name="CmbAno" id="CmbAno"  onchange="Proceso('R','<? echo $CmbAno; ?>')">
                <option value="T" class="NoSelec">Todos</option>
                <?
	for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
	{
		if (isset($CmbAno))
		{
			if ($i==$CmbAno)
			{
				echo "<option SELECTed value ='$i'>$i</option>";
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
				echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
				echo "<option value='".$i."'>".$i."</option>";
			}
		}
	}
	?>
              </SELECT>
            </span></td>
          </tr>
          <tr>
            <td class="formulario">Estados</td>
            <td class="formulario"><SELECT name="CmbEstado" >
              <option value="S" SELECTed="SELECTed">Seleccionar</option>
              <?
		$Consulta="SELECT * from sget_estados_generales order by codigo";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($CmbEstado==$Fila["codigo"])
				echo "<option value='".$Fila["codigo"]."' SELECTed>".$Fila["descripcion"]."</option>";
			else	
				echo "<option value='".$Fila["codigo"]."'>".$Fila["descripcion"]."</option>";
		}
		?>
            </SELECT></td>
            <td class="formulario">&nbsp;</td>
            <td colspan="3" class="formulario">&nbsp;</td>
          </tr>
      </table></td>
      <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
    </tr>
  </table>
  <p>
  <table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td ><img src="archivos/images/interior/esq1.gif" width="15" ></td>
	<td width="1073" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" ></td>
	<td ><img src="archivos/images/interior/esq2.gif" width="15" ></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><br>
     <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">		
       <tr>
         <td width="2%" class="TituloCabecera"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckRut','ChkTodos');"></td>
          <td width="6%" align="center" class="TituloCabecera">Hoja Ruta </td>
          <td width="9%" align="center" class="TituloCabecera">Fecha Ingreso </td>
          <td width="7%" align="center" class="TituloCabecera">Contrato</td>
          <td width="19%" align="center" class="TituloCabecera">Empresa</td>
          <td width="15%" align="center" class="TituloCabecera">Adm.Codelco</td>
		   <?
		  	$Consulta = "SELECT * from sget_hitos ";
			$Consulta.=" where cod_sistema='".$CodSistema."' and cod_pantalla='14'  ";
			$RespH = mysqli_query($link, $Consulta);
			while ($FilaH=mysql_fetch_array($RespH))
			{
				?>
				<?
			}
			?>	
	      <td width="14%" align="center" class="TituloCabecera">Adm.Contratista</td>
           <?
		  	$Consulta = "SELECT * from sget_hitos ";
			$Consulta.=" where cod_sistema='".$CodSistema."' and cod_pantalla='".$CodPantalla."'  ";
			$RespH = mysqli_query($link, $Consulta);
			while ($FilaH=mysql_fetch_array($RespH))
			{
				?>
				<td width="5%" align="center" class="TituloCabecera">
				<? echo $FilaH[abrev_hito]; ?>		  		</td>
				<?
			}
			?>	
          </tr>
  <?

if($Cons=='S')
{
	$Consulta = "SELECT * from sget_hoja_ruta ";
	$Consulta.=" where not isnull(num_hoja_ruta)  ";
	if($CmbEmpresa!='-1')
		$Consulta.=" and  rut_empresa='".$CmbEmpresa."' ";
	if($CmbContrato!='S')
		$Consulta.=" and  cod_contrato='".$CmbContrato."' ";
	if($TxtHoja!='')
		$Consulta.= " and num_hoja_ruta like ('%".$TxtHoja."%') ";
	if($CmbAno!='T')
		$Consulta.=" and  year(fecha_ingreso) ='".$CmbAno."' ";
	if($CmbEstado!='S')
	{
		switch($CmbEstado)
		{
			case "1":
				$Consulta.= " and cod_estado_general in ('4')  ";	
			break;
			case "2":
				$Consulta.= " and cod_estado_general > 4  ";	
			break;
		}
	}
	$Resp = mysqli_query($link, $Consulta);
	echo "<input name='CheckHoja' type='hidden'  value=''>";
	$cont=1;
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Entro='N';
		?>     	
		<tr> 
    	<td ><? echo "<input name='CheckHoja' class='SinBorde' type='checkbox'  value='".$Fila["num_hoja_ruta"]."'>" ?></td>
	    <td ><? echo $Fila["num_hoja_ruta"]."&nbsp;"; ?></td>
        <td ><? echo substr($Fila["fecha_ingreso"],0,10)."&nbsp;"; ?>&nbsp;</td>
        <td ><? echo $Fila["cod_contrato"]."&nbsp;"; ?></td>
        <td >
		<? 
		  $RazonSoc=DescripcionRazonSocial($Fila["rut_empresa"]);
		  echo $RazonSoc."&nbsp;"; ?></td>
          <td ><?
		   $VarCodelco=AdmCttoCodelco($Fila["cod_contrato"]);
		   $array=explode('~',$VarCodelco);
		   echo $array[1].' '.$array[2].' '.$array[3];
	   	   ?>&nbsp;
		   </td>
           <td>
		   <? 
		   $VarContratista=AdmCttoContratista($Fila["cod_contrato"]);
	  	   $array=explode('~',$VarContratista);
	   	   echo $array[1].' '.$array[2].' '.$array[3];
		   //CONSULTA QUE REFLEJA SI ESTAS AUTORIZADOS LOS HITOS ANTERIORES DE GESTION DE TERCEROS
		    
		  	$Consulta = "SELECT * from sget_hitos ";
			$Consulta.=" where cod_sistema='".$CodSistema."' and cod_pantalla='16'  ";
			$RespHD = mysqli_query($link, $Consulta);
			while ($FilaHD=mysql_fetch_array($RespHD))
			{
				$Consulta="SELECT * from sget_hoja_ruta_hitos where num_hoja_ruta='".$Fila["num_hoja_ruta"]."' and cod_hito='".$FilaHD[cod_hito]."' ";
				$RespExi = mysqli_query($link, $Consulta);
				if($FilaExi=mysql_fetch_array($RespExi))
				{	
					if($FilaExi[autorizado]=='S')
						$Entro='S';
					else
						$Entro='N';
				}
				else
					$Entro='N';
			}	
		   //FIN CONSULTA GESTION DE TERCEROS
		   ?>
&nbsp;		</td>
		    <?
		  	//echo "agos______".$Entro."<br>";
			$Consulta = "SELECT * from sget_hitos ";
			$Consulta.=" where cod_sistema='".$CodSistema."' and cod_pantalla='".$CodPantalla."'  ";
			$RespHD = mysqli_query($link, $Consulta);
			while ($FilaHD=mysql_fetch_array($RespHD))
			{
				?>
				<td  align="center">
				<?
				$Consulta="SELECT * from sget_hoja_ruta_hitos where num_hoja_ruta='".$Fila["num_hoja_ruta"]."' and cod_hito='".$FilaHD[cod_hito]."' ";
				$RespExi = mysqli_query($link, $Consulta);
				if($FilaExi=mysql_fetch_array($RespExi))
				{	
					if($FilaExi[autorizado]=='S')
					{
					
					?>
					<a href="JavaScript:Rech('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/acepta.png" border="0" alt="<? echo $FilaHD[descrip_hito];  ?>" 	align="absmiddle"></a>
					<a href=	"JavaScript:Obs('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/file.png"  border="0"  alt="Ingreso Observaci�n <? echo $FilaHD[descrip_hito];  ?>" align=	"absmiddle" /></a>
		  			<?
					}
					else
					{
						if($Entro =='S')
						{
							?>
							<a href="JavaScript:Auto('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/proceso.png" border="0" alt="<? echo $FilaHD[descrip_hito];  ?>" 	align="absmiddle"></a>
							<?
						}
						else
						{
							?>
							<img src="archivos/proceso.png" border="0" alt="No se Puede Autorizar el Hito <? echo $FilaHD[descrip_hito];  ?> , hasta que el Adm.Codelco Autorize el Hito" 	align="absmiddle">
							<?
						}
						?>
						<a href=	"JavaScript:Obs('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/file.png"  border="0"  alt="Ingreso Observaci�n <? echo $FilaHD[descrip_hito];  ?>" align=	"absmiddle" /></a>
						<?
					}
				}
				else
				{
					if($Entro =='S')
					{
					?>	
					<a href="JavaScript:Auto('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/proceso.png" border="0" alt="<? echo $FilaHD[descrip_hito];  ?>" 	align="absmiddle"></a>
					<?
					}
					else
					{
						?>
						<img src="archivos/proceso.png" border="0" alt="No se Puede Autorizar el Hito <? echo $FilaHD[descrip_hito];  ?> , hasta que el Adm.Codelco Autorize el Hito" 	align="absmiddle">
						<?
					}	
					?>
					<a href=	"JavaScript:Obs('<? echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')"><img src="archivos/file.png"  border="0"  alt="Ingreso Observaci�n <? echo $FilaHD[descrip_hito];  ?>" align=	"absmiddle" /></a>			
					<?
				}
				?>				</td>
				<?
			}
			?>	 	
          </tr>
  		   <?
		   $cont++;
	}
}
?>			
</table></td><td width="20" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="20"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>
</form>