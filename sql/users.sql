DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created DATETIME NOT NULL DEFAULT NOW(),
    lastlogin DATETIME,
    active TINYINT DEFAULT 1,
    salt VARCHAR(255)
);

DROP TABLE IF EXISTS messages;
CREATE TABLE messages (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    send_id INT NOT NULL,
    recp_id INT NOT NULL,
    subject VARCHAR(255),
    message TEXT,
    send_time DATETIME DEFAULT NOW(),
    readed TINYINT DEFAULT 0,
    
    FOREIGN KEY (send_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (recp_id) REFERENCES users (id) ON DELETE CASCADE
);

INSERT INTO messages (send_id, recp_id, subject, message) VALUES
	(1, 6, "hello", "Hellofdsa, "),
    (3, 4, "hello", "Helloadfsa "),
    (1, 6, "hello", "Hello fser2"),
    (5, 6, "hi", "hi ddude!!!) ");

SELECT
	u.username sender,
	m.recp_id,
    m.subject,
    m.message,
    m.send_time
FROM
	messages m
INNER JOIN
	users u
ON m.send_id = u.id
WHERE m.recp_id = 6;