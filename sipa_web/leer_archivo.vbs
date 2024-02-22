function LeerArchivo(valor)	

	//ubicacion = "n:\sipa_web\archivo_basculas\PesoMatic.txt"
	ubicacion = "c:\PesoMatic.txt"
	Set fs = CreateObject("Scripting.FileSystemObject")
	Set file = fs.OpenTextFile(ubicacion,1,true) //Crea el archivo si no existe.
	
	//Validar si el peso del archivo ==  0 no leer. 
	
	Set file2 = fs.getFile(ubicacion) 
	tamano = file2.size	

	if (tamano <> 0)	then
		valor = file.ReadLine
		LeerArchivo = valor
	else
		LeerArchivo = valor
	end if
		
end function 
function LeerArchivo2(valor)	

	//ubicacion = "n:\sipa_web\archivo_basculas\PesoMatic2.txt"
	ubicacion = "c:\PesoMatic2.txt"
	Set fs = CreateObject("Scripting.FileSystemObject")
	Set file = fs.OpenTextFile(ubicacion,1,true) //Crea el archivo si no existe.
	
	//Validar si el peso del archivo ==  0 no leer. 
	
	Set file2 = fs.getFile(ubicacion) 
	tamano = file2.size	
msgbox("AAAA");
	if (tamano <> 0)	then
		valor = file.ReadLine
		LeerArchivo2 = valor
	else
		LeerArchivo2 = valor
	end if
		
end function 
function LeerRomana(valor)	

	ubicacion = "c:\PesaMatic\bascula.txt"
	Set fs = CreateObject("Scripting.FileSystemObject")
	Set file = fs.OpenTextFile(ubicacion,1,true) //Crea el archivo si no existe.
	
	//Validar si el peso del archivo ==  0 no leer. 
	
	Set file2 = fs.getFile(ubicacion) 
	tamano = file2.size	

	if (tamano <> 0)	then
		valor = file.ReadLine
		valor = file.ReadLine
		valor = file.ReadLine
		valor = file.ReadLine
		LeerRomana = valor
	else
		LeerRomana = valor
	end if
		
end function 