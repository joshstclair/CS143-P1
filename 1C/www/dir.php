<html>
	<head>
		<title>Navigation</title>
	</head>
	<body>
		Add New Content :
			<ul>
				<li><a href="./addActorDirector.php" target="main">Add Actor/Director</a></li>
				<li><a href="./addMovie.php" target="main">Add Movie Information</a></li>
				<li><a href="./addMovieToActor.php" target="main">Add Movie / Actor Relation</a></li>
				<li><a href="./addMovieToDirector.php" target="main">Add Movie / Director Relation</a></li>
				<li><a href="./addComment.php" target="main">Add Comments</a></li>
			</ul>
		Browse Movies and Actor Information :
			<ul>
				<li><a href="./displayInfo.php?type=movie&movie_id=100" target="main">Browse Movies</a></li>
				<li><a href="./displayInfo.php?type=actor&actor_id=20852" target="main">Browse Actors</a></li>
			</ul>
		Search:
			<form method="GET" action="./search.php" target="main">
   			<input type="text" name="search">
   			<br>
   			<input type="submit"/>
		</form>
	</body>
</html>
