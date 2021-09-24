INSERT INTO `database`.`table` (`identifier`, `language`, `content`) 
VALUES 
  (COALESCE(`param1`,`param2`,0),"en_US","What is Lorem Ipsum?") ,
  (COALESCE(`param1`,`param2`,0),"zh_CN","什么是Lorem Ipsum?") ,
  (COALESCE(`param1`,`param2`,0),"nl_NL","Wat is Lorem Ipsum?")
ON DUPLICATE KEY UPDATE `content`="What is Lorem Ipsum?";