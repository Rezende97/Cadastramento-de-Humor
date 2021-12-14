DROP TABLE IF EXISTS humor;
DROP TABLE IF EXISTS help;
DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS `users`(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	email varchar(255) NOT NULL UNIQUE,
	password varchar(255) NOT NULL,
	tutorial char NOT NULL DEFAULT 0,
	nivel tinyint NOT NULL DEFAULT 0
);

ALTER TABLE users AUTO_INCREMENT = 1;

INSERT INTO users(email, password, tutorial) VALUES('a@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);
INSERT INTO users(email, password, tutorial) VALUES('b@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);
INSERT INTO users(email, password, tutorial) VALUES('c@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);
INSERT INTO users(email, password, tutorial) VALUES('d@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);
INSERT INTO users(email, password, tutorial) VALUES('e@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);
INSERT INTO users(email, password, tutorial) VALUES('f@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);
INSERT INTO users(email, password, tutorial) VALUES('g@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);
INSERT INTO users(email, password, tutorial) VALUES('h@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);
INSERT INTO users(email, password, tutorial) VALUES('i@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);
INSERT INTO users(email, password, tutorial) VALUES('j@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);
INSERT INTO users(email, password, tutorial) VALUES('k@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);
INSERT INTO users(email, password, tutorial) VALUES('l@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);
INSERT INTO users(email, password, tutorial) VALUES('m@provedor.com', '2b8fd8541a5faf512691635f5290493695745bef', 0);

CREATE TABLE IF NOT EXISTS `humor`(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	userID int NOT NULL,
	humor_initial CHAR,
	humor_final CHAR,
	data DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	comment_initial varchar(255),
	comment_final varchar(255),
	foreign key(userID) references users(id)
);

ALTER TABLE humor AUTO_INCREMENT = 1;

INSERT INTO humor(userID, humor_initial, humor_final, data, comment_initial, comment_final) VALUES(1, 3, 2, now(), 'comentário pela manhã 1', 'comentário pela tarde 1');
INSERT INTO humor(userID, humor_initial, humor_final, data, comment_initial, comment_final) VALUES(1, 1, 3, now(), 'comentário pela manhã 2', 'comentário pela tarde 2');
INSERT INTO humor(userID, humor_initial, humor_final, data, comment_initial, comment_final) VALUES(2, 3, 2, now(), 'comentário pela manhã 3', 'comentário pela tarde 3');
INSERT INTO humor(userID, humor_initial, humor_final, data, comment_initial, comment_final) VALUES(2, 1, 3, now(), 'comentário pela manhã 4', 'comentário pela tarde 4');

CREATE TABLE IF NOT EXISTS `help` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  foreign key(userID) references users(id)
);