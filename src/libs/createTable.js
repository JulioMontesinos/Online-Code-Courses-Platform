

function CreateTable2(header, JSON, opc, nomTabla) // "ADD,UPDATE,DELETE"
{
	var fil, col, tr, celda;
	var tabla = document.createElement("table");
	var ADD = UPD = DEL = false;

	if(opc)
	{
		opc = opc.toUpperCase();
		ADD = (opc.indexOf("ADD")>=0); //True or false
		UPD = (opc.indexOf("UPDATE")>=0);;
		DEL = (opc.indexOf("DELETE")>=0);
	}
	
	// HEADER
	tr = document.createElement("tr");
	for(col=1; col<header.length ; col++)
	{
		celda = document.createElement("th");
		celda.innerHTML = header[col];
		tr.appendChild(celda);
	}
	if(ADD || UPD || DEL)
	{
		celda = document.createElement("th");
		if(ADD)
			celda.innerHTML = "<button id='add'>➕</button>";
		tr.appendChild(celda);	
	}
	// To add the header to the table, even if there are no editing buttons.
	tabla.appendChild(tr);

	// DATA
	for (fil = 0; fil < JSON.length; fil++)
	{ 
		tr = document.createElement("tr");

		for (col = 1; col < header.length; col++)
		{
			celda = document.createElement("td");
			texto = JSON[fil][col];
			if(texto.indexOf("http://")==0 || texto.indexOf("https://")==0)
				texto="<a href='"+texto+"' target='_blank'>"+texto+"</a>";
			celda.innerHTML = texto;
			tr.appendChild(celda);
		}

		//FOR THE LAST COLUMN
		if( ADD || UPD || DEL )
		{
			celda = document.createElement("td");
			celda.innerHTML = "";

			if(UPD)
				celda.innerHTML += "<button id='edit_"+fil+"' data-id='"+JSON[fil][0]+"'>✏️</button>";
				
			if(DEL)
				celda.innerHTML += "<button id='delete_"+fil+"' data-id='"+JSON[fil][0]+"'>❌</button>";
				
			tr.appendChild(celda);
		}
		tabla.appendChild(tr);
	}
    $(nomTabla).appendChild(tabla);
}
