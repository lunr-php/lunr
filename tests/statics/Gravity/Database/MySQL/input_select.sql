SELECT `c`.`identifier`,`c`.`language`,`c`.`language`,`fb`.`identifier`,COALESCE(NULL,1) as "Teste"
from `table` as `c`
         left join `bookmarks` fb on `c`.`identifier` = `fb`.`identifier`
where `c`.`identifier` = "NOTIFICATION_UPDATE_ARRIVAL";
