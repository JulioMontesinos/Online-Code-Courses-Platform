/*
Library with common functions for the AJAX ENGINE
(and other useful JavaScript functions)
*/
var INTRO_= false;
function $(id){return document.getElementById(id);}

var editor_readOnly = 0; // IF IT IS 0, IT WILL BE READONLY (FOR THE TEACHER), IF IT IS 1, IT CAN BE WRITTEN (FOR THE STUDENT). BY DEFAULT, IT WILL BE 0.

function GetDataForm(form)
{
	var f, data, pair, strData="";

	if( (f=$(form)) && (data=new FormData($(form))) )
	{
		if(data.entries) /* For chrome and firefox */
			for(pair of data.entries())
				strData+=pair[0] + "=" + encodeURIComponent(pair[1]) + "&";
		else /* For edge, explorer, safari, opera, ... */
			strData=ScanDataForm(f);  /* See this function below */
	}
	else
		strData=form;
	return strData;
}

var ON=1; var OFF=0; /* Change these values if deemed appropriate. */
function ScanDataForm(f)
{
	if(!f) return "";

	var i,j,x, val;
	var cad="";
	var radioNom="";

	for(i=0;i<f.length;i++) /* Iterate through all 'x' elements in the form. */
	{
		x=f.elements[i];  /* Ignore elements without a name. */
		if(typeof(x.name)!="undefined" && x.name.length>0)
		{
			val=undefined; /* Initialization of the value to 'undefined'. */
			switch(x.type) /* Depending on the type of form element. */
			{
				case "text": case "password": case "hidden": case "textarea":
					val=x.value.trim();
					break;

				case "select-one":
					if(x.options.length>0 && x.selectedIndex>=0 && x.selectedIndex<x.options.length)
						val=(x.options[x.selectedIndex].value) ?
							x.options[x.selectedIndex].value : x.options[x.selectedIndex].text;
					break;

				case "checkbox":
					val=(x.checked)?ON:OFF; /* Values ON/OFF based on 'checked' yes or no. */
					break;

				case "radio":
					if(radioNom!=x.name)
					{
						radioNom=x.name;
						j=0;
						while(f.elements[radioNom][j] && val=="")
						{
							if(f.elements[radioNom][j].checked)
								val=f.elements[radioNom][j].value;
							j++;
						}
					}
					break;
				
				default: /* case "button": case "reset": case "submit": case "file": IGNORAR */
					val=undefined; /* Not necessary, added for better code understanding. */
					break;
			}
			if(val!=undefined)
			{
				if(cad!="")
					cad+="&";
				cad+=x.name+"="+encodeURIComponent(val); /* par atributo=valor */
			}

		}
	}
	return cad; /* String of attribute/value pairs: "x1=val1&x2=val2&..." */
}
//It's better to use the ScanDataForm function

/**************************************************************************/
/* TABLES CREATION *****************************************************/
/*
opc = {
	header: [ ["texto", funcion], ... ];
	rows:   [ ["texto", funcion], ... ];
}
*/
function CreateTable(header, JSON, opc, nomTabla) 
{
	var col, tr, celda, boton;
	var tabla = document.createElement("table");
	var thereAreButtons;

	if(!opc || !opc.header || !opc.rows)
	{
		alert('opc = {\n   header: [ ["text", funcion], ... ];\n   rows:   [ ["text", funcion], ... ];\n}');
		return false;
	}
	thereAreButtons = (opc.header.length >0 || opc.rows.length >0);

	// HEADER
	tr = document.createElement("tr");
	for(col=1; col<header.length ; col++)
	{
		celda = document.createElement("th");
		celda.innerHTML = header[col];
		tr.appendChild(celda);
	}
	if(thereAreButtons)
	{
		celda = document.createElement("th");
		for(let i=0 ; i<opc.header.length ; i++)
		{
			//celda.innerHTML += "<button class='headerButton' id='headerButton_'"+i+">"+opc.header[i][0]+"</button>";
			boton = document.createElement("button");
			boton.id="headerButton_"+i;
			boton.className="headerButton";
			boton.innerHTML=opc.header[i][0];
			boton.onclick=opc.header[i][1];
			celda.appendChild(boton);
		}
		tr.appendChild(celda);	
	}
	// To add the header to the table, even if there are no editing buttons.
	tabla.appendChild(tr);

	// DATA
	for (let fil = 0; fil < JSON.length; fil++)
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
		if(thereAreButtons)
		{
			celda = document.createElement("td");
			for(let i=0 ; i<opc.rows.length ; i++)
			{
				//celda.innerHTML += "<button class='headerButton' id='headerButton_'"+i+">"+opc.header[i][0]+"</button>";
				boton = document.createElement("button");
				boton.id="rowsButton_"+fil+"_"+i;
				boton.dataset.id=JSON[fil][0];   //data-id='"+JSON[fil][0]
				boton.className="rowsButton";
				boton.innerHTML=opc.rows[i][0];
				boton.onclick=opc.rows[i][1];
				celda.appendChild(boton);
			}					
			tr.appendChild(celda);
		}
		tabla.appendChild(tr);
	}
    $(nomTabla).appendChild(tabla);
}

/**************************************************************************/
function Confirm(nombre,option){ //The option can be delete, add, or close.
    var retVal = confirm("Are you sure you want "+option+" "+nombre+"?");
    if( retVal == true )
	{
        return true;
    }
	else
	{
        return false;
    }
}

/*************************************************************************/
// Used to check if the grade given by the teacher for a submission is a number or not.
function isNum(val)
{
	return !isNaN(val)
}

/*************************************************************************/
//Used to get the server time.

function current_date()
{
	let date = new Date();
	var date_server = date.toISOString().split('T')[0];
	return date_server;
}

function expired_date(my_date)
{
	//The server date needs to be retrieved and converted from the format "Sun May 11, 2014" to "2014-05-11".
	
	// IF IT RETURNS TRUE --> THE EXPIRATION DATE HAS PASSED.
	// IF IT RETURNS FALSE --> THE EXPIRATION DATE HAS NOT PASSED.

	let date = new Date();
	var date_server = date.toISOString().split('T')[0];

	if(my_date > date_server)
	{
		return false;
	}
	else if(my_date < date_server)
	{
		return true;
	}
	else
	{
		return false; //In this case, the dates are equal, so it will be the last day before it expires.
	}
}

/*************************************************************************/
function LoadCSS(cssURL, cssID)
{
	if(!$(cssID))
	{
		var css=document.createElement("link");
		css.id = cssID;
		css.rel = "stylesheet";
		css.type = "text/css";
		css.href = cssURL;
		css.media = "all";
		document.getElementsByTagName('head')[0].appendChild(css);
	}
}

function GetModule(mod, target)
{
	LoadCSS((mod+".css"), ("cssID_"+mod)); /* optional */

	var ajaxV = new XMLHttpRequest();
	ajaxV.open("POST", (mod+"_v.php"), false); /* false => SYNCHRONOUS */
	ajaxV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxV.send();
	$(target).innerHTML=ajaxV.responseText; /* Dumps the text into the specified layer */

	var ajaxC = new XMLHttpRequest();
	ajaxC.open("POST", (mod+"_c.php"), false); /* false => SYNCHRONOUS */
	ajaxC.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxC.send();
	try{eval(ajaxC.responseText);} /* Execute JavaScript code */
	catch(e){console.log("## ERROR GetModule '"+mod+"'\n\n"+ajaxC.responseText);}
}

function ModelCall(mod, form, type)
{
	var postData=GetDataForm(form); /* See this function below */

	var ajaxM = new XMLHttpRequest();
	ajaxM.open("POST", (mod+"_m.php"), false); /* false => SYNCHRONOUS */
	ajaxM.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxM.send(postData);
	if(type.toUpperCase()=="TEXT") /* Plane text or Javascript/JSON */
		return ajaxM.responseText;
	try{return eval(ajaxM.responseText);}
	catch(e){console.log("## ERROR ModellCall '"+mod+"' / '"+form+"'\n\n"
						  + ajaxM.responseText);}
}

/**************************************************************************/
/* MESSAGES IN FORMS ************************************************/
function Message(id, color, texto)
{
	$(id).style.color =color;
	$(id).innerHTML = texto;
	setTimeout("$('"+id+"').innerHTML=''", 4000);
}

/**************************************************************************/
/* FUNCTIONS FOR FORM 'SELECT' CONTROLS ************************/
function SetSelect(mod, data, idSelect)
{
	if(!$(idSelect) || $(idSelect).type!="select-one")
	{
		conole.log("## ERROR SetSelect: idSelect='"+idSelect+"'");
		return 0;
	}
	var i, idText, idTitle;
	var JSON = ModelCall(mod, data, "JSON");
	var opt;
	
	if(JSON.length==0 || JSON[0].length==0)
	{
		// Possible error...
		//console.log("## ERROR SetSelect: [JSON.length==0 || JSON[0].length==0]");
		return 0;
	}
	idText = ((JSON[0].length>1) ? 1 : 0);
	idTitle = ((JSON[0].length>2) ? 1 : idText);
	
	for(i=0 ; i<JSON.length ; i++)
	{
		opt = document.createElement('option');
		opt.value = JSON[i][0];
		opt.text = JSON[i][idText];
		opt.title = JSON[i][idTitle];
		$(idSelect).add(opt);
	}
	return 1;
}

function ClearSelect(idSelect)
{
	if(!$(idSelect) || $(idSelect).type!="select-one")
	{
		conole.log("## ERROR ClearSelect: idSelect='"+idSelect+"'");
		return 0;
	}
	while($(idSelect).options.length>1)
		$(idSelect).remove(1);
}

/**************************************************************************/
/* VALIDATION OF CERTAIN DATA TYPES ***********************************/
function ValidateEmail(val)
{
	var p, a = val.indexOf("@");
	
	if(a<1 || a!=val.lastIndexOf("@"))
		return false;
	if(val[a-1]=="." || val[a+1]==".")
		return false;
	p = val.lastIndexOf(".");
	if(p<a || p>=val.length-1)
		return false;
	if(val[p-1]==".")
		return false;
	return true;
}

/**************************************************************************/
/* CHANGES *****************************************************************/
function Change(option)
{   
	switch(option){

		case 1: //INSIDE OF LOGIN
			$("nav").style.display=""; // To prevent it from being hidden (The object is visible).
			$("main").className="main2";
			$("h1").className="h1_2";
			break;  

		default: //EXITS IDENTIFIED ACCESS
			$("nav").style.display="none"; //To hide it
			$("main").className="main";
			$("h1").className="h1";
			break;
	}
}

/**************************************************************************/
/* MODAL WINDOW (ON/OFF) *************************************************/
// 'id' is a number >= 0, indicating the 'Z' order of the Modal window.
// 'id' is also used to identify the window.
function CreateModal(id)
{
	if($("ModalBackground_"+id))
	{
		alert("##CreateModal: The modal window already exists'"+id+"'");
		return;
	}

	var divModalBackground=document.createElement("div");
	divModalBackground.id="ModalBackground_"+id;
	divModalBackground.style.zIndex=1000+(2*id);
	divModalBackground.style.position="absolute";
	divModalBackground.style.top="0px";
	divModalBackground.style.left="0px";
	divModalBackground.style.right="0px";
	divModalBackground.style.bottom="0px";
	divModalBackground.style.background="#cecece";
	divModalBackground.style.opacity="0.7";
	divModalBackground.style.display="none";
	document.body.appendChild(divModalBackground);
	var divModalWindow=document.createElement("div");
	divModalWindow.id="ModalWindow_"+id;
	divModalWindow.style.zIndex=1001+(2*id);
	divModalWindow.style.position="absolute";
	divModalWindow.style.width="300px";
	divModalWindow.style.top="80px";
	divModalWindow.style.left="50%";
	divModalWindow.style.marginLeft="-150px";
	divModalWindow.style.background="#ffffff";
	divModalWindow.style.border="1p solid #bbbbbb";
	divModalWindow.style.borderRadius="4px";
	divModalWindow.style.display="none";
	divModalWindow.innerHTML="...";
	document.body.appendChild(divModalWindow);
	$("ModalBackground_"+id).onclick=function()
	{
		var xID = this.id.substr(11);
		$("ModalBackground_"+xID).style.display="none";
		$("ModalWindow_"+xID).style.display="none";
	}
}

function SetModal(id, view)
{
	if(!$("ModalBackground_"+id))
	{
		alert("##OpenModal: No existe ventana modal '"+id+"'");
		return;
	}
	$("ModalWindow_"+id).innerHTML=view;
}

function OpenModal(id, width)
{
	if(!$("ModalBackground_"+id))
	{
		alert("##OpenModal: No existe ventana modal '"+id+"'");
		return;
	}

	if(width=="MAX")
	{
		$("ModalWindow_"+id).style.width="";
		$("ModalWindow_"+id).style.marginLeft="";
		$("ModalWindow_"+id).style.top="0px";
		$("ModalWindow_"+id).style.left="0px";
		$("ModalWindow_"+id).style.right="0px";
		$("ModalWindow_"+id).style.bottom="0px";
	}
	else
	{
		$("ModalWindow_"+id).style.width=(width + "px");
		$("ModalWindow_"+id).style.marginLeft=((-width/2) + "px");
		$("ModalWindow_"+id).style.top="80px";
		$("ModalWindow_"+id).style.left="50%";
		$("ModalWindow_"+id).style.right="";
		$("ModalWindow_"+id).style.bottom="";
	}
	$("ModalBackground_"+id).style.display="";
	$("ModalWindow_"+id).style.display="";
}

function CloseModal(id)
{
	if(!$("ModalBackground_"+id))
	{
		alert("##CloseModal: No existe ventana modal '"+id+"'");
		return;
	}
	$("ModalBackground_"+id).style.display="none";
	$("ModalWindow_"+id).style.display="none";
}

/**************************************************************************/
/* 'ONLOAD' EVENT (INITIALIZATION ON STARTUP) ******************************/
window.onload = function()
{
	//Modal Window Initialization.
	CreateModal(1);
	CreateModal(2);
	CreateModal(3);
	
	if(INTRO_===true)
		SessionIn();
	else
	{
		// Initial menu for unidentified user.
		GetModule("navs/01_nav_pub", "headnav");
		$("nav").style.display = "none";
	}
}

function SessionIn()
{
	//The function Change() should be called.
	Change(1);

	$('main').style.left='205px'; //It is set to ensure the correct display of identified access after logging in, logging out, and logging in again.

	$('h1').innerHTML = "<button id='h1_Button_hamb'>☰</button> <span id='h1_text' style='float:right;'>...</span>";
	$('h1_Button_hamb').onclick = function()
	{
		if($('main').style.left=='5px')
		{
			$('main').style.left='205px';
		}
		else
		{
			$('main').style.left='5px';
		}
	}
	GetModule('navs/02_nav_priv', 'headnav');
	GetModule('navs/03_nav_left', 'nav');
}