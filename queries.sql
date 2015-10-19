SELECT CONCAT_WS(' ', first, last)
FROM Actor a, Movie m, MovieActor ma
WHERE a.id = ma.aid AND m.id = ma.mid AND m.title = 'Die Another Day';