<input type="hidden" id="Initialize"/>
<input type="hidden" id="LoadTable_Tasks"/>
<input type="hidden" id="editor"/>

<span id="Title_tasks">TASKS</span><br/>
<div id="Full_table"></div> <!--TASKS TABLE-->

<div id="AddContainer">
    <button id="button_close_modal" class="button_close_modal" title="Close">X</button>
    <center><h1 id="Task_h1"></h1></center>
    <textarea id="statement" name="statement" readonly></textarea>
	
	<div id="Box_code">
		<textarea id="code" name="code"></textarea>
	</div>
	
	<div id="buttons_code">
		<button id="clean_code" onclick="clean()">Clear</button>
		<button id="add_code" onclick="add_block()">Run</button>
		<button id="save_code">SAVE/SUBMIT</button>
	</div>
	
	<div id="Box_output">
		<textarea id="txt_output" name="txt_output" readonly></textarea>
	</div>
</div>
