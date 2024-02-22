<?
include('conectar_ori.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ver Controles Especificados al Peligro</title>
</head>
<body>
<form name="MantenedorCont" method="post">
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<?

//include('div_obs_elimina3.php');
?>
<table width="100%">
<tr>
<td width="1%" background="imagenes/tab_separator.gif"></td>
<td>
<table width="100%" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" colspan="2" class="TituloCabecera" >Familia de Controles&nbsp;&nbsp;</td>
    <td width="50%" align="center" class="TituloCabecera" >Especificaci&oacute;n Control</td>
  </tr>
  <?
		 $Consulta="SELECT * from sgrs_siperpeligros where CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."' and MVALIDADO='1'";
		 //echo $Consulta."<br>";
		 $Resp=mysql_query($Consulta);
		 if(!$Fila=mysql_fetch_array($Resp))
		 {
		 ?>
  <!--<table width="90%" border="0" cellpadding="0" cellspacing="0">	-->
  <?
		 	$ContObs=1;
	  		$Consulta="SELECT ceiling(t1.CCONTROL) as CCONTROL,t1.NCONTROL,t1.QPESOESP,t2.MCONTROL from sgrs_codcontroles t1";
			$Consulta.=" left join sgrs_sipercontroles t2 on t1.CCONTROL=t2.CCONTROL and t2.CPELIGRO='".$CmbPeligros."' ";			
			$Consulta.="where t1.MVIGENTE='1' and t2.MCONTROL='1' and t1.CCONTROL<>'--' order by NCONTROL asc";//and t2.CCONTACTO='".$CodC."' 
			//echo $Consulta;
			$Resultado=mysql_query($Consulta);//echo "<input type='hidden' name='CodControl'><input type='hidden' name='CmbControl'><input type='hidden' name='ObsControl'>";
			echo "<input type='hidden' name='Obs'><input type='hidden' name='ObsControl'>";
			while ($Fila=mysql_fetch_array($Resultado))
			{				
				echo "<tr>";
				echo "<td align='left'>".$Fila[NCONTROL]."</td>";
				echo "<td align='center'  style='border-left:none' ><input type='hidden' name='CodControl' value='".$Fila[CCONTROL]."'>";
				/*if($Fila[MCONTROL]=='1')
					$Obs='SI';
				echo $Obs;*/
				echo "</td>";
				?>
 
    <td align='left'>
        <table width="100%">
          <?
				$EncontroObs='N';
				$Consulta="SELECT * from sgrs_sipercontroles_obs where CCONTROL ='".$Fila[CCONTROL]."' and CPELIGRO='".$CmbPeligros."' and CAREA='".$Cod."' order by CIDCONTROL asc";
				//echo $Consulta."<br>";
				$ResultadoC=mysql_query($Consulta);
				while($FilaC=mysql_fetch_array($ResultadoC))
				{	
					$EncontroObs='S';
					?>
          <tr>
            <td width="90%"><? echo "<textarea name='Obs' cols='80' readonly>".$FilaC[TOBSERVACION]."</textarea><input type='hidden' name='ObsControl' value='".$Fila[CCONTROL]."~".$FilaC[CIDCONTROL]."'>";?></td>
            <td width="10%" align="left"></td>
          </tr>
          <?
					$ContObs=$ContObs+1;
				}
				if($EncontroObs=='N')
				{
					?>
          <tr>
            <td width="90%"><? echo "<textarea name='Obs' cols='80' readonly></textarea><input type='hidden' name='ObsControl' value='".$Fila[CCONTROL]."~'>";?></td>
            <td width="10%">&nbsp;</td>
          </tr>
          <?
					$ContObs=$ContObs+1;
				}	
				?>
        </table>
      <?
	//echo "</tr>";
			}
		}	
		 ?>
    </td>
  </tr>
</table>
</td>
<td width="1" background="imagenes/tab_separator.gif"></td>
</tr>
</table>
</form>
</body>
</html>
