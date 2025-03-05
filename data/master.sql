CREATE TABLE master (
	id INT auto_increment PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL
);

INSERT INTO master (id, name, password) 
            VALUES (1, "master", "master");