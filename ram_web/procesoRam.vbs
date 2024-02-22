function validaProceRun(Dato)
MsgBox(Dato)
	'set taskmgr = GetObject("winmgmts:{impersonationLevel=impersonate}").ExecQuery ("select * from Win32_Process")//Obtienes acceso a los procesos
	'For each process in taskmgr 
	'	If Lcase(process.name) = "AutomaticoRam.exe"  or Ucase(process.name) = "AUTOMATICORAM.EXE" then
     '           	msgbox process.name
		'End If 
	'Next
	'return ProcessRun
end function