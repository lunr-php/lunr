INSERT INTO `database`.`table` (`identifier`, `language`, `content`)
VALUES
    ("LOREM_IPSUM","pt-PT","Lorem ipsum dolor sit amet .."),
	("LOREM_IPSUM","zh-CN","Lorem ipsum dolor sit amet .."),
	("LOREM_IPSUM","nl-NL","Lorem ipsum dolor sit amet .."),
	("LOREM_IPSUM","pt-BR","Lorem ipsum dolor sit amet .."),
	("LOREM_IPSUM","en-EN","Lorem ipsum dolor sit amet .."),
	("LOREM_IPSUM","en-US","Lorem ipsum dolor sit amet .."),
	("LOREM_IPSUM","li-LI","Lorem ipsum dolor sit amet ..")
        ON DUPLICATE KEY UPDATE `content`="Lorem ipsum dolor sit amet ..";