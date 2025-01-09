<?php
    $link = mysql_connect("localhost","adm_bd","672312");
	mysql_select_db("sgrv", $link);
	?>
	<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
	<form>
	 <?php 
	set_time_limit(2000);
	$Consulta="select * from";
	$Consulta.=" sgrs_siperpeligros ";
	$Consulta.=" where CPELIGRO<>''";
	$Resp1=mysqli_query($link,$Consulta);
	while($Fila1=mysqli_fetch_array($Resp1))
	{
		//echo $Fila1[CPELIGRO]." ".$Fila1[CAREA]." ".$Fila1[MR1]." - ".$Fila1[MR2]."<br>";
		if($Fila1[MR1]==1&&$Fila1[MR2]==1||($Fila1[MR1]==2&&$Fila1[MR2]==2)||($Fila1[MR1]==3&&$Fila1[MR2]==3))
		{
			$Actualizar="update sgrs_siperpeligros set MVALIDADO='1' where CAREA='".$Fila1[CAREA]."' and CPELIGRO='".$Fila1[CPELIGRO]."'";
			//echo  $Actualizar."<br>";
			mysqli_query($link,$Actualizar);			
		}
	}

echo "<script lenguaje='JavaScript'>";
	echo "window:close();";
echo "</script>";
	?></table>
</form>
