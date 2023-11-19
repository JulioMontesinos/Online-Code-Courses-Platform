<input type="hidden" id="Initialize"/>
<input type="hidden" id="LoadTable"/>
<input type="hidden" id="SeeListCourses"/>
<div id="Full_table"></div>

<div id="AddContainer">
	<div id="div_form_courses">
		<button id="button_close_modal" class="button_close_modal" title="Close">X</button>
		<h2 id="my_h2"></h2>
		<center><span id="msg_status"></span></center>

		<form id="form_courses" name="form_courses"> 
			<input type="hidden" name="OPC" id="OPC" /> 

			<!--ALL MANDATORY-->
			<input type="text" id="course_id" name="course_id" placeholder="ID course" title="ID course" readonly onmousedown="return false;" />
			
			<input type="text" id="course_name" name="course_name" placeholder="Course name" title="Course name" required />
            
			<button type="submit" id="course_send"></button>
		</form>
	</div>
</div>