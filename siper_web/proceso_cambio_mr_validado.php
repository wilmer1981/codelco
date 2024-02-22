<?
    $link = mysql_connect("localhost","adm_bd","672312");
	mysql_SELECT_db("sgrv", $link);
	?>
	<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
	<form>
	 <? 
	set_time_limit(2000);
	$Consulta="SELECT * from";
	$Consulta.=" sgrs_siperpeligros ";
	$Consulta.=" where CPELIGRO<>''";
	$Resp1=mysql_query($Consulta);
	while($Fila1=mysql_fetch_array($Resp1))
	{
		//echo $Fila1[CPELIGRO]." ".$Fila1[CAREA]." ".$Fila1[MR1]." - ".$Fila1[MR2]."<br>";
		if($Fila1[MR1]==1&&$Fila1[MR2]==1||($Fila1[MR1]==2&&$Fila1[MR2]==2)||($Fila1[MR1]==3&&$Fila1[MR2]==3))
		{
			$Actualizar="UPDATE sgrs_siperpeligros set MVALIDADO='1' where CAREA='".$Fila1[CAREA]."' and CPELIGRO='".$Fila1[CPELIGRO]."'";
			//echo  $Actualizar."<br>";
			mysql_query($Actualizar);			
		}
	}

echo "<script lenguaje='JavaScript'>";
	echo "window:close();";
echo "</script>";
	?></table>
</form>
