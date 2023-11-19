<input type="hidden" id="Initialize"/>
<input type="hidden" id="LoadTable_Submissions"/>
<input type="hidden" id="Task_list_value"/>
<input type="hidden" id="editor"/>

<span id="Title_submissions">ENTREGAS DE ALUMNOS</span><br/>

    <br/>
    Select task to view submissions
    <select type="text" id="select_task" name="select_task" placeholder="Select task" title="Select task">
        <option>Select task to view submissions</option>
    </select>
    <br/><br/>

<div id="Full_table"></div> <!--TABLE OF SUBMISSIONS-->

<div id="AddContainer">
	<div id="div_form_submissions">
		<button id="button_close_modal" class="button_close_modal" title="Close">X</button>
		<h2 id="my_h2"></h2>
		<center><span id="msg_status"></span></center>

		<form id="form_Submissions" name="form_Submissions"> 
			<input type="hidden" name="OPC" id="OPC" /> 
            <input type="hidden" name="Id_Submission" id="Id_Submission" /> 
            

            <input type="text" id="submission_grade" name="submission_grade" placeholder="Score de la submission" title="Score de la submission" />
            <input type="text" id="observations" name="observations" placeholder="Observations de la submission" title="Observations de la submission" />
			
			<button type="submit" id="submission_send"></button>
		</form>
	</div>
</div>

<div id="AddContainer_2">
    <button id="button_close_modal_2" class="button_close_modal_2" title="Close">X</button>
    <center><h1 id="Task_h1"></h1></center>
    <textarea id="statement" name="statement" readonly></textarea>
	
	<div id="Box_code">
		<textarea id="code" name="code" readonly></textarea>
	</div>
	
	<div id="buttons_code">
		<button id="clean_code" onclick="clean()">Clear</button>
		<button id="add_code" onclick="add_block()">Run</button>
		<button id="add_nota">Assign grade</button>
	</div>
	
	<div id="Box_output">
		<textarea id="txt_output" name="txt_output" readonly></textarea>
	</div>
	
</div>