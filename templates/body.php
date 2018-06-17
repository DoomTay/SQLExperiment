</head>
<body>
<header id="mainHeader">
	<h1><a href="/">World Database</a></h1>
</header>
<nav>
	<a href="/">Browse</a>
	<a href="/cities.php">Cities</a>
	<a href="/search.php">Search</a>
	<?php if(!empty($_SESSION['loggedIn']) && !empty($_SESSION['username'])): ?>
	Welcome, <?php echo $_SESSION['username'] ?> [<a href="/logout.php">Log Out</a>]
	<?php else: ?>
	<a href="/login.php">Log In/Register</a>
	<?php endif; ?>
</nav>
<div id="content">