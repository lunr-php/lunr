INSERT INTO `database`.`table` (`identifier`, `language`, `content`)
VALUES
    ("LOREM_IPSUM","li-LI","Lorem ipsum dolor sit amet ..")
        ON DUPLICATE KEY UPDATE `content`="Lorem ipsum dolor sit amet ..";