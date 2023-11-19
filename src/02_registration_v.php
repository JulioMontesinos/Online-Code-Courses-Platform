<div id="div_form_Registration">
	<h2>New user</h2>
	<center><span id="msg_Registration"></span></center>
	<form id="form_Registration" name="form_Registration"> 
		<input type="hidden" name="OPP" id="OOP" value="REGISTER"/> 

		<!--ALL MANDATORY-->
		<input type="text" name="Name_R" id="Name_R" placeholder="Name" required/><br/>
		<input type="text" name="Surname_R" id="Surname_R" placeholder="Last Name" required/><br/>
		<input type="text" name="Email_R" id="Email_R" placeholder="Email" required/><br/>
		<input type="password" name="Pass_R" id="Pass_R" placeholder="Password" required/><br/>
		<input type="password" name="Pass_R2" id="Pass_R2" placeholder="Repeat Password"/><br/>
		<button type="submit" id="Registration_send">Sign Up</button>
	</form>
</div>