CREATE TABLE categories (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nameCategory varchar(40) NOT NULL UNIQUE,
    code varchar(15) NOT NULL UNIQUE
);

CREATE TABLE users (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    regDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    mail varchar(30) NOT NULL UNIQUE,
    nameUser varchar(30) NOT NULL,
    contact varchar(16) NOT NULL,
    password varchar(64) NOT NULL
);

CREATE TABLE lots (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    nameLot varchar(100) NOT NULL,
    description varchar(250),
    image varchar(200) NOT NULL,
    startPrice INTEGER NOT NULL,
    endDate DATE NOT NULL,
    priceStep INTEGER NOT NULL,
    lotCategory INTEGER NOT NULL,
    author INTEGER NOT NULL,
    winner INTEGER,
    FOREIGN KEY (lotCategory) REFERENCES categories (id),
    FOREIGN KEY (author) REFERENCES users (id),
    FOREIGN KEY (winner) REFERENCES users (id)
);

CREATE TABLE bets (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    timeBet TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    priceBet INTEGER NOT NULL,
    betUser INTEGER NOT NULL,
    betLot INTEGER NOT NULL,
    FOREIGN KEY (betUser) REFERENCES users (id),
    FOREIGN KEY (betLot) REFERENCES lots (id)
);

ALTER TABLE lots 
ADD FULLTEXT INDEX lot_ft_search(nameLot, description);
