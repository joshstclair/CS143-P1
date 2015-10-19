-- Primary key should be ID since there should be one unique ID per movie.
-- There should not be a negative ID
CREATE TABLE Movie (
	id INT NOT NULL,
	title VARCHAR(100) NOT NULL,
	year INT,
	rating VARCHAR(10),
	company VARCHAR(50),
	PRIMARY KEY (id)
	CHECK (id >= 0)
) ENGINE = INNODB;

-- Primary key should be ID since there should be one unique ID per actor.
-- There should not be a negative ID
CREATE TABLE Actor (
	id INT NOT NULL,
	last VARCHAR(20) NOT NULL,
	first VARCHAR(20) NOT NULL,
	sex VARCHAR(6) NOT NULL,
	dob DATE NOT NULL,
	dod DATE,
	PRIMARY KEY (id)
	CHECK (id >= 0)
) ENGINE = INNODB;

-- Primary key should be ID since there should be one unique ID per director.
-- There should not be a negative ID
CREATE TABLE Director (
	id INT NOT NULL,
	last VARCHAR(20) NOT NULL,
	first VARCHAR(20) NOT NULL,
	dob DATE NOT NULL,
	dod DATE,
	PRIMARY KEY (id),
	CHECK (id >= 0)
) ENGINE = INNODB;

-- mid should be the same as Movie table's id
CREATE TABLE MovieGenre (
	mid INT NOT NULL,
	genre VARCHAR(20),
	UNIQUE (mid),
	FOREIGN KEY (mid) REFERENCES Movie(id)
) ENGINE = INNODB;

-- mid and did should be the same as Movie table's id and Director table's id
CREATE TABLE MovieDirector (
	mid INT NOT NULL,
	did INT NOT NULL,
	FOREIGN KEY (mid) REFERENCES Movie(id),
	FOREIGN KEY (did) REFERENCES Director(id)
) ENGINE = INNODB;

-- mid and aid should be the same as Movie table's id and Actor table's id
CREATE TABLE MovieActor (
	mid INT NOT NULL,
	aid INT NOT NULL,
	role VARCHAR(50),
	FOREIGN KEY (mid) REFERENCES Movie(id),
	FOREIGN KEY (aid) REFERENCES Actor(id)
) ENGINE = INNODB;

-- mid should be the same as Movie table's id
-- Rating should be between 1-star and 5-star
CREATE TABLE Review (
	name VARCHAR(20),
	time TIMESTAMP,
	mid INT NOT NULL,
	rating INT,
	comment VARCHAR(500),
	FOREIGN KEY (mid) REFERENCES Movie(id)
	CHECK (rating > 0 AND rating <= 5)
) ENGINE = INNODB;

CREATE TABLE MaxPersonID (
	id INT NOT NULL
) ENGINE = INNODB;

CREATE TABLE MaxMovieID (
	id INT NOT NULL
) ENGINE = INNODB;