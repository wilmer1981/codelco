<head>
<title></title>
<link href="js/style.css" rel=stylesheet>
</head>
<body  background="images/fondo.gif">
  <table width="223" border="0" cellpadding="2" cellspacing="1" class="TablaPrincipal">
      <tr>
        <td colspan="2" class="titulo_codelco_informa">Informe Diario Fund. y Refiner&iacute;a </td>
      </tr>
      <tr align="center">
        <td colspan="2" class="BordeInf">
          <p><font size="1">
            <select name="DiaIni" id="DiaIni">
              <?
				  	for ($i=1;$i<=31;$i++)
					{
						if ($i==date("j"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					} 
				  ?>
            </select>
            <select name="MesIni" id="MesIni">
              <?
				  	for ($i=1;$i<=12;$i++)
					{
						if ($i==date("n"))
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					} 
				  ?>
            </select>
            <select name="AnoIni" id="AnoIni">
              <?
				  	for ($i=2000;$i<=date("Y");$i++)
					{
						if ($i==date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					} 
				  ?>
            </select>
</font></p></td>
      </tr>
      <tr>
        <td class="BordeInf">Web:</td>
        <td align="left" class="BordeInf"><input name="Ayer_Web" type="button" id="Ayer_Web2" value="Ayer" onClick="List_Inf_Dia2('A_W','<? echo $DiaAnt; ?>','<? echo $MesAnt; ?>','<? echo $AnoAnt; ?>')">
        <input type="button" name="Listar_Web" value="Consulta" onClick="List_Inf_Dia2('W','','','')"> </td>
      </tr>
      <tr>
        <td class="BordeInf">Excel:</td>
        <td align="left"  class="BordeInf"><span class="main-menu"><font class="main-menu">
          <input name="Ayer_Excel" type="button" value="Ayer" onClick="List_Inf_Dia2('A_E','<? echo $DiaAnt; ?>','<? echo $MesAnt; ?>','<? echo $AnoAnt; ?>')">
          <input type="button" name="Listar_Excel" value="Consulta" onClick="List_Inf_Dia2('E','','','')">
        </font></a></span></td>
      </tr>
      <tr align="center" bgcolor="#efefef">
        <td colspan="2" class="BordeInf"><a href="JavaScript:window.history.back();"><span>volver</span></a></td>
    </tr>
</table>
  </div>
</body></html>