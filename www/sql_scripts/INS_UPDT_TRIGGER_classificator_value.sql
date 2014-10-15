USE `strunkovadb`;
DELIMITER $$

CREATE TRIGGER `update_classificatovalues` BEFORE UPDATE ON `tclassificatorvalues` FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
  BEGIN
    IF new.parentclassificatorvalueid IS NOT null
    THEN
      SELECT
        classificatorid,
        level,
        path
      INTO
        @classificatorid,
        @ParentLevel,
        @ParentPath
      FROM tclassificatorvalues
      WHERE classificatorvalueid = new.parentclassificatorvalueid;

      SET new.classificatorid = @classificatorid;
      SET new.level = @ParentLevel + 1;
      SET new.path = concat(@ParentPath, '/', new.engvalue);
    ELSEIF new.classificatorid IS NOT null
      THEN
        SELECT
          engname
        INTO @ParentPath
        FROM tclassificator
        WHERE classificatorid = new.classificatorid;

        SET new.level = 1;
        SET new.path = concat(@ParentPath, '/', new.engvalue);

    END IF;
  END $$
DELIMITER ;
