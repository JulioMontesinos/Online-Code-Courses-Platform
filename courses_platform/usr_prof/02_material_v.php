<input type="hidden" id="Initialize"/>
<input type="hidden" id="LoadTable_Material"/>

<span id="Title_material">MATERIAL</span><br/>
<div id="Full_table"></div> <!--TABLE OF MATERIAL-->
<div id="message_table_material"></div>

<div id="AddContainer">
	<div id="div_form_Material">
		<button id="button_close_modal" class="button_close_modal" title="Close">X</button>
		<h2 id="my_h2"></h2>
		<center><span id="msg_status"></span></center>

		<form id="form_Material" name="form_Material"> 
			<input type="hidden" name="OPC" id="OPC" /> 
            <input type="hidden" name="Id_Content" id="Id_Content" /> 

			<input type="text" id="material_text" name="material_text" placeholder="Text del material" title="Text del material" required />
            <input type="text" id="material_url" name="material_url" placeholder="URL del material" title="URL del material" required />
            
			<button type="submit" id="material_send"></button>
		</form>
	</div>
</div>