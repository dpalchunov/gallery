UPDATE `strunkovadb`.`tpictures`
SET
  position = pictureid,
  engdesc = '',
  rusdesc = '',
  file_name = concat(cast(pictureid AS CHAR(5)), '.jpg'),
  sketch_path = concat('./images/gallary/sketches/', cast(pictureid AS CHAR(5)), '.jpg'),
  pic_path =    concat('./images/gallary/', cast(pictureid AS CHAR(5)), '.jpg')
WHERE
  pictureid <> 130

UPDATE `strunkovadb`.`tpictures`
SET
  sketch_path = ''

WHERE
  pictureid <> 130
