-- The names of all the actors in the movie 'Die Another Day'
SELECT CONCAT_WS(' ', first, last)
FROM Actor a, Movie m, MovieActor ma
WHERE a.id = ma.aid AND m.id = ma.mid AND m.title = 'Die Another Day';

-- The count of all the actors who acted in multiple movies
SELECT count(*)
FROM
	(SELECT count(mid)
		FROM Actor a, MovieActor ma
		WHERE a.id = ma.aid
		GROUP BY a.id
		HAVING count(mid) > 1)
multipleMovies;

-- The count of all the female actors who are also directors
SELECT count(*)
FROM Actor a, Director d
WHERE a.id = d.id AND a.sex = 'Female';