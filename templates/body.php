</head>
<body>
<header id="mainHeader">
	<h1><a href="/">World Database</a></h1>
</header>
<nav>
	<ul>
	<li><a href="/">Browse</a></li>
	<li><a href="/cities.php">Cities</a></li>
	<li><a href="/search.php">Search</a></li>
	<li><?php if(!empty($_SESSION['loggedIn']) && !empty($_SESSION['username'])):
	?>Welcome, <?php echo $_SESSION['username'] ?> [<a href="/logout.php">Log Out</a>]
	<?php else: ?><a href="/login.php">Log In/Register</a><?php endif; ?></li>
	</ul>
</nav>
<div id="content">
