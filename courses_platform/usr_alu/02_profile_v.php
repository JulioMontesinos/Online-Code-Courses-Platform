<div id="div_form_Profile">
	<h2>Data</h2>
	<center><span id="msg_status"></span></center>

	<form id="form_Profile" name="form_Profile"> 
		<input type="hidden" name="OPC" id="OPC" value="RECORD"/> 

		<!--ALL MANDATORY-->
		<input type="text" id="ID" name="ID" placeholder="ID" title="Identificator" readonly onmousedown="return false;"><br/>
        <input type="text" id="Name" name="Name" placeholder="Name" title="Name" required><br/>
        <input type="text" id="Surname" name="Surname" placeholder="Surname" title="Surname" required><br/>
        <input type="text" id="Rol" name="Rol" placeholder="Rol" title="Rol"  readonly onmousedown="return false;"><br/>
        <input type="text" id="Email" name="Email" placeholder="Email" title="Email"  readonly onmousedown="return false;"><br/>
        <input type="password" id="New_Pass" name="New_Pass" placeholder="New password" title="If left empty, it will not change"><br/>
		<input type="password" id="Pass_Vieja" name="Pass_Vieja" placeholder="Current password" title="Required to save changes" required><br/>
		<button type="submit" id="Profile_enviar">Save changes</button>
	</form>
</div>
