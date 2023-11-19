<input type="hidden" id="Initialize"/>
<input type="hidden" id="LoadTable_Teachers"/>
<input type="hidden" id="SeeListTeachers"/>

<span id="Title_teachers">TEACHER MANAGEMENT</span>
<div id="Full_table"></div> <!--TEACHERS TABLE-->

<div id="AddContainer">
	<div id="div_form_teachers">
		<button id="button_close_modal" class="button_close_modal" title="Close">X</button>
		<h2 id="my_h2"></h2>
		<center><span id="msg_status"></span></center>

		<form id="form_Teachers" name="form_Teachers"> 
			<input type="hidden" name="OPC" id="OPC" /> 

            <input type="hidden" name="Id_Teacher" id="Id_Teacher" /> 

            <select type="text" id="select_teacher" name="select_teacher" placeholder="Select non-responsible teacher" title="Select non-responsible teacher">
				<option>Select non-responsible teacher</option>
			</select>
            
			<button type="submit" id="teacher_send"></button>
		</form>
	</div>
</div>