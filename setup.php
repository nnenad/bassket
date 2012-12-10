<html><head><title>Setting up database</title></head><body>

        <h3>Setting up...</h3>

        <?php
        // Example 21-3: setup.php
        include_once 'functions.php';

        createTable('members', 'user VARCHAR(16),
            pass VARCHAR(16),
            INDEX(user(6))', '');

        createTable('messages', 'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            auth VARCHAR(16),
            recip VARCHAR(16),
            pm CHAR(1),
            time INT UNSIGNED,
            message VARCHAR(4096),
            INDEX(auth(6)),
            INDEX(recip(6))', '');

        createTable('friends', 'user VARCHAR(16),
            friend VARCHAR(16),
            INDEX(user(6)),
            INDEX(friend(6))', '');

        createTable('profiles', 'user VARCHAR(16),
            text VARCHAR(4096),
            INDEX(user(6))', '');

        createTable('player', 'playerId INT UNSIGNED NOT NULL AUTO_INCREMENT,
        username VARCHAR(52) NOT NULL,
        pass VARCHAR(32) NOT NULL,
        playerName VARCHAR(52) DEFAULT NULL,
        playerLastName VARCHAR(52) DEFAULT NULL,
        telfon VARCHAR(32) DEFAULT NULL,
        isAdmin BOOLEAN DEFAULT FALSE,
        PRIMARY KEY (playerId),
        UNIQUE KEY `username` (`username`)', 'ENGINE=INNODB DEFAULT CHARSET=utf8'
        );
        createTable('sala', 'salaId INT UNSIGNED NOT NULL AUTO_INCREMENT,
        imeSale VARCHAR(52) NOT NULL,
        cena INT DEFAULT NULL,
        PRIMARY KEY (salaId)', 'ENGINE=INNODB DEFAULT CHARSET=utf8'
        );
        createTable('termin', '`terminId` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `datumVreme` datetime DEFAULT NULL,
        `brojMesta` int(11) DEFAULT NULL,
        `salaId` int(10) unsigned NOT NULL,
        PRIMARY KEY (`terminId`),
        KEY `FK_termin_sala` (`salaId`),
        CONSTRAINT `FK_termin_sala` FOREIGN KEY (`salaId`) REFERENCES `sala` (`salaId`)', 'ENGINE=InnoDB DEFAULT CHARSET=utf8'
        );

        createTable('prisustvo', 'prisustvoId INT UNSIGNED NOT NULL AUTO_INCREMENT,
        terminId INT UNSIGNED NOT NULL,
        playerId INT UNSIGNED NOT NULL,
        caledFromPlayer INT UNSIGNED DEFAULT NULL,
        PRIMARY KEY (prisustvoId),
        KEY `Fk_prisustvo_termin` (terminId),
        KEY `Fk_prisustvo_player` (playerId),
        KEY `Fk_prisustvo_calledFromPlayer` (caledFromPlayer),
        CONSTRAINT `Fk_prisustvo_termin` FOREIGN KEY (terminId) REFERENCES `termin` (`terminId`),
        CONSTRAINT `Fk_prisustvo_player` FOREIGN KEY (playerId) REFERENCES `player` (`playerId`),
        CONSTRAINT `Fk_prisustvo_calledFromPlayer` FOREIGN KEY (caledFromPlayer) REFERENCES `player` (`playerId`)', 'ENGINE=INNODB DEFAULT CHARSET=utf8'
        );

        createTable('userToken', 'token INT UNSIGNED NOT NULL,
	playerId INT UNSIGNED NOT NULL,
	PRIMARY	KEY (token),
	KEY `Fk_userToken_player` (playerId),
	CONSTRAINT  `Fk_userToken_player` FOREIGN KEY (`playerId`) REFERENCES `player` (`playerId`)', 'ENGINE=INNODB DEFAULT CHARSET=utf8')
        ?>

        <br />...done.
    </body></html>
