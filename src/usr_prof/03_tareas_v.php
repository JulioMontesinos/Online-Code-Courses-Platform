<input type="hidden" id="Initialize"/>
<input type="hidden" id="LoadTable_Tasks"/>

<span id="Title_tasks">TASKS</span><br/>
<div id="Full_table"></div> <!--TASKS TABLE-->
<div id="message_table"></div>

<div id="AddContainer">
	<div id="div_form_Tasks">
		<button id="button_close_modal" class="button_close_modal" title="Close">X</button>
		<h2 id="my_h2"></h2>
		<center><span id="msg_status"></span></center>

		<form id="form_tasks" name="form_tasks"> 
			<input type="hidden" name="OPC" id="OPC" /> 

            <input type="text" id="task_id" name="task_id" placeholder="ID de la task" title="ID de la task" readonly onmousedown="return false;" />
			<input type="text" id="task_name" name="task_name" placeholder="Task name" title="Task name" required />
			<textarea id="task_statement" name="task_statement" placeholder="Task statement" title="Task statement" required></textarea>
			<input type="date" id="task_date_add" name="task_date_add" placeholder="Creation date" title="Creation date" required />
            <input type="date" id="task_date_exp" name="task_date_exp" placeholder="Expiration date" title="Expiration date" required />
            
			<button type="submit" id="task_send"></button>
		</form>
	</div>
</div>