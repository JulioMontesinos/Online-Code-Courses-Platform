<input type="hidden" id="Initialize"/>
<input type="hidden" id="LoadTable"/>
<div id="Full_table"></div>

<div id="AddContainer">
	<div id="div_form_teacher">
		<button id="button_close_modal" class="button_close_modal" title="Close">X</button>
		<h2 id="my_h2"></h2>
		<center><span id="msg_status"></span></center>

		<form id="form_teacher" name="form_teacher"> 
			<input type="hidden" name="OPC" id="OPC" /> 

			<!--ALL ARE MANDATORY-->
			<input type="text" id="profesor_id" name="profesor_id" placeholder="ID" title="Identificator" readonly onmousedown="return false;" />
			
			<input type="text" id="profesor_nombre" name="profesor_nombre" placeholder="Name" title="Name" required />
			
			<input type="text" id="profesor_apellidos" name="profesor_apellidos" placeholder="Surname" title="Surname" required />
			
			<input type="text" id="profesor_rol" name="profesor_rol" placeholder="Rol" title="Rol"  readonly onmousedown="return false;" />
			
			<input type="text" id="profesor_email" name="profesor_email" placeholder="Email" title="Email" readonly="true" />
			
			<input type="password" id="teacher_new_pass" name="teacher_new_pass" placeholder="New password" title="If left empty, it will not change." />
			
			<button type="submit" id="teacher_send"></button>
		</form>
	</div>
</div>