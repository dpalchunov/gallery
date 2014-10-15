USE strunkovaDB;

CREATE TABLE `tclassificatorvalues_log` (
  `log_type`                   VARCHAR(10)
                               COLLATE utf8_bin DEFAULT NULL,
  `timestamp`                  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `classificatorvalue_logid`   INT(11)   NOT NULL AUTO_INCREMENT,
  `classificatorvalueid`       INT(11)   NOT NULL,
  `classificatorid`            INT(11) DEFAULT NULL,
  `rusvalue`                   VARCHAR(45)
                               COLLATE utf8_bin DEFAULT NULL,
  `parentclassificatorvalueid` INT(11) DEFAULT NULL,
  `engvalue`                   VARCHAR(45)
                               COLLATE utf8_bin DEFAULT NULL,
  `level`                      INT(11) DEFAULT NULL,
  `path`                       VARCHAR(1000)
                               COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`classificatorvalue_logid`),
  KEY `classificatorvalues_log_classificatorvalueid_idx` (`classificatorvalueid`, `log_type`)
)
  ENGINE =InnoDB
  AUTO_INCREMENT =1
  DEFAULT CHARSET =utf8
  COLLATE =utf8_bin;

