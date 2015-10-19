-- Three Tables with Primary Keys
-- 1. Movie, id
-- 2. Actor, id
-- 3. Director, id

-- Six Referential Integrity Constraints
-- 4. MovieGenre, mid
-- 5,6. MovieDirector, mid and did
-- 7,8 MovieActor, mid and aid
-- 9. Review, mid

-- Three Check Constraints
-- 10. Movie, Actor, Director: id should be non-negative
-- 11. Actor, Director: Date of birth should be before date of death
-- 12. Review: rating should be between 1 and 5 stars

-- 1
INSERT INTO Movie Values (4709, 'Avengers', 2015, 'Great', 'Marvel');
-- ERROR 1062 (23000) at line 18: Duplicate entry '4709' for key 'PRIMARY'
-- Can't add duplicate primary key

-- 2
INSERT INTO Actor Values (68580, 'DJ', 'Kim', 'Male', '1993-03-02', null);
-- ERROR 1062 (23000) at line 23: Duplicate entry '68580' for key 'PRIMARY'
-- Can't add duplicate primary key

-- 3
INSERT INTO Director Values (68398, 'Josh', 'St.Clair', '1994-07-28', null);
-- ERROR 1062 (23000) at line 26: Duplicate entry '68398' for key 'PRIMARY'
-- Can't add duplicate primary key

-- 4
DELETE FROM Movie WHERE id = 4706;
-- ERROR 1451 (23000) at line 30: Cannot delete or update a parent row: a foreign key
-- constraints fails (`CS143`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY
-- (`mid`) REFERENCES `Movie` (`id`))
-- Can't delete 4706 from Movie because MovieGenre contains 4706 as a foreign key

-- 5
UPDATE Movie SET id = id + 1 WHERE id = 4706;
-- ERROR 1451 (23000) at line 36: Cannot delete or update a parent row: a foreign key
-- constraints fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY
-- (`mid`) REFERENCES `Movie` (`id`))
-- Can't update 4706 from Movie because MovieGenre contains 4706 as a foreign key

-- 6
UPDATE MovieDirector SET did = did + 1 WHERE did = 68573;
-- ERROR 1452 (23000) at line 42: Cannot add or update a child row: a foreign key
-- constraints fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY
-- (`did`) REFERENCES `Director` (`id`))
-- Can't update 68573 from MovieDirector because Director contains 68573 and did is a foreign key

-- 7
DELETE FROM Movie WHERE id = 4733;
-- ERROR 1451 (23000) at line 48: Cannot delete or update a parent row: a foreign key
-- constraints fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY
-- (`mid`) REFERENCES `Movie` (`id`))
-- Can't delete 4733 from Movie because MovieDirector contains 4733 as a foreign key

-- 8
UPDATE MovieActor SET aid = aid + 10 WHERE aid = 68628;
-- ERROR 1452 (23000) at line 48: Cannot add or update a child row: a foreign key
-- constraints fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY
-- (`aid`) REFERENCES `Actor` (`id`))
-- Can't update 68628 from MovieActor because Actor contains 68628 and aid is a foreign key

-- 9
UPDATE Review SET mid = mid + 5;
-- This should fail but since we don't have anything added into the review set, it works.
-- However, once something is added, it should throw a 1452 ERROR.
-- Can't update mid from Review because Movie contains the same id and mid is a foreign key

-- 10
INSERT INTO Movie Values (-2, 'Avengers', 2015, 'Great', 'Marvel');
-- Should fail because id should be non-negative

-- 11
INSERT INTO Actor Values (82930, 'Foo', 'Bar', 'Male', '1992-11-02', '1991-02-09');
-- Should fail because one can't be born after one died

-- 12
INSERT INTO Review Values ('Joe Smith', '2015-10-18', '4733', '6', 'Best movie ever!');
-- Should fail because the rating should be between 1 and 5 (inclusive)

