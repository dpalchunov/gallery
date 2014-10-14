update  `strunkovadb`.`tpictures`
set
  position = pictureid ,
  engdesc = '',
  rusdesc = '' ,
  file_name = concat(cast(pictureid as CHAR(5) ) , '.jpg'),
  sketch_path = concat('./images/gallary/sketches/' , cast(pictureid as CHAR(5) ) , '.jpg'),
  pic_path =    concat('./images/gallary/',  cast(pictureid as CHAR(5) ), '.jpg' )
where
  pictureid <> 130

update  `strunkovadb`.`tpictures`
set
  sketch_path = ''

where
  pictureid <> 130
