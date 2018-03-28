CREATE TABLE IF NOT EXISTS Konjugation (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  Sprachen_id int(11) DEFAULT NULL,
  Deutsch text,
  Fremdsprache text CHARACTER SET utf8mb4,
  Zeitform text,
  `Abgefragt` int(11) DEFAULT '0',
  `Richtig` int(11) DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
