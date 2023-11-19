<input type="hidden" id="Initialize"/>
<input type="hidden" id="LoadTable"/>
<input type="hidden" id="SeeListTeachers"/>
<div id="Full_table"></div>

<div id="AddContainer">
	<div id="div_form_editions">
		<button id="button_close_modal" class="button_close_modal" title="Close">X</button>
		<h2 id="my_h2"></h2>
		<center><span id="msg_status"></span></center>

		<form id="form_editions" name="form_editions"> 
			<input type="hidden" name="OPC" id="OPC" /> 

			<!--ALL MANDATORY-->
			<input type="text" id="edicion_id" name="edicion_id" placeholder="ID" title="Identificator" readonly onmousedown="return false;" />
			
			<input type="date" id="edicion_fecha" name="edicion_fecha" placeholder="Date" title="Date" required />
			
			<input type="text" id="edicion_nombre" name="edicion_nombre" placeholder="Edition name" title="Edition name" required />
            
            <select type="text" id="edicion_estado" name="edicion_estado" placeholder="Status" title="Status">
                <option>Activated</option>
                <option>Disabled</option>
            </select>

            <select type="text" id="select_edition_teacher" name="select_edition_teacher" placeholder="Teacher name" title="Teacher name">
				<option>Select responsible teacher</option>
			</select>
			<input type="hidden" id="edicion_id_profesor" name="edicion_id_profesor" />
			
            
            <select type="text" id="select_edition_course" name="select_edition_course" placeholder="Course associated with the edition" title="Course associated with the edition">
				<option>Select course</option>
			</select>
            
			<button type="submit" id="edition_send"></button>
		</form>
	</div>
</div>