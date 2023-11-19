<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" type="image/png" href="imgs/icon.png" />
<title>Programming and Data Science Courses</title>
<link rel="stylesheet" href="libs/styles.css" />
<script src="libs/scripts.js"></script>
<!--<script src="libs/pyodide/pyodide_19.js"></script>-->

<!--EDITOR-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.css" />
<script src="https://cdn.jsdelivr.net/pyodide/v0.19.1/full/pyodide.js"></script> <!--Imprescindible-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.3/codemirror.min.js"
		integrity="sha512-XMlgZzPyVXf1I/wbGnofk1Hfdx+zAWyZjh6c21yGo/k1zNC4Ve6xcQnTDTCHrjFGsOrVicJsBURLYktVEu/8vQ=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.3/mode/python/python.min.js"
	integrity="sha512-/mavDpedrvPG/0Grj2Ughxte/fsm42ZmZWWpHz1jCbzd5ECv8CB7PomGtw0NAnhHmE/lkDFkRMupjoohbKNA1Q=="
	crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<body>
<header id="header">
	<nav id="headnav"></nav>
	<img src="imgs/logo-course.jpg" height="50px" style="border-radius: 4px;"/>
</header>
<nav id="nav"></nav>
<h1 id="h1" class="h1">Programming and Data Science Courses</h1>
<main id="main" class="main">
</main>

<?php if(isset($_SESSION["ID"])){echo"<script>INTRO_=true;</script>\n";} $_SESSION["EDITOR"] = 0;?>
</body>
</html>
