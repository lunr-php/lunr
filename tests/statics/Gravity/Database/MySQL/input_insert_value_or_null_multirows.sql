INSERT INTO `database`.`table` (`param1`, `param2`, `param3`) 
VALUES 
(CONCAT(COALESCE(`param3`,"Unknown"),`param4`), "x", 'Lorem'), 
(CONCAT(COALESCE(`param3`,null),"_",`param4`), "x123", 'Lorem'), 
(CONCAT(COALESCE(`param3`,"WW"),"_",`param4`), "x1234", 'Lorem'), 
(CONCAT(COALESCE(`param3`,null),"_",`param4`), "x12345", 'Lorem'), 
(CONCAT(COALESCE(`param3`,null),"_",`param4`), "x123456", 'Lorem');