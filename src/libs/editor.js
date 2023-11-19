var resultBlock = document.getElementById("txt_output");
var editor;

if(editor_readOnly == 0)
{ // FOR THE TEACHER (THE TEACHER CANNOT EDIT THE STUDENT'S CODE). READONLY WILL BE ADDED.
	editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		mode: {
			name: "python",
			version: 3,
			singleLineStringErrors: false
		},
		lineNumbers: true,
		matchBrackets: true,
		afterCursor: true,
		closeBrackets: true,
		comment: true,
		readOnly: 'nocursor'
	});
}
else if (editor_readOnly == 1)
{ // FOR THE STUDENT (CAN WRITE ANY PYTHON CODE).
	editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		mode: {
			name: "python",
			version: 3,
			singleLineStringErrors: false
		},
		lineNumbers: true,
		matchBrackets: true,
		afterCursor: true,
		closeBrackets: true,
		comment: true
	});
}

editor.setSize(null, "100%"); // To make the codeMirror editor take up 100% of the textarea.

function add_block()
{
	pyodide.runPython(`
            import sys
            from io import StringIO
            sys.stdout = StringIO()	
        `);
	
	let codeBlock = editor.getValue();

	execute_code_block(codeBlock, resultBlock);
	
	resultBlock.innerHTML = resultBlock;
	pyodide.runPython("sys.stdout.flush()");
	pyodide.runPython("sys.stdin.flush()");	
	
}

function clean()
{
	resultBlock.innerHTML = "";
	pyodide.runPython("sys.stdin.flush()");	
}

async function execute_code_block(codeBlock, resultBlock)
{		
	let result = await pyodide.runPythonAsync(codeBlock)
	.then(output =>{
		
		let stdout = pyodide.runPython("sys.stdout.getvalue()");
		
		resultBlock.innerHTML = stdout;
	})
	.catch(err=>{
		resultBlock.innerHTML = err; // To print the error message to the console.
	});
}