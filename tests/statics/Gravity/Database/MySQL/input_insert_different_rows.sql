INSERT INTO `database`.`table` (`param1`, `param2`, `param3`) 
VALUES 
(CONCAT(COALESCE(`param3`,null),`param4`), "x", 'Lorem'), 
("id_value1", "x1", ?), 
("id_value2", 'x12', '?'), 
(CONCAT(COALESCE(`param3`,null),"_",`param4`), "x123", 'Lorem'), 
(CONCAT(COALESCE(`param3`,null),"_",`param4`), "x1234", 'Lorem'), 
(CONCAT(COALESCE(`param3`,null),"_",`param4`), "x12345", 'Lorem'), 
(CONCAT(COALESCE(`param3`,null),"_",`param4`), "x123456", 'Lorem');