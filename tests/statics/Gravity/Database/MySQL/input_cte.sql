WITH `teste` AS (
    SELECT
        `c`.`language` as `lang`,
        RAND() as `num`
    FROM
        `table1` as `c`
            LEFT JOIN
        `table2` as `fb` ON `c`.`id`=`fb`.`id`
    WHERE
            COALESCE(NULL,1) = 1
      AND `c`.`id` = 1
    GROUP BY `lang`
    ORDER BY `num` DESC
    LIMIT 100 OFFSET 5
    )
SELECT
    `table1`.*
FROM
    `table1`
        JOIN
    `teste`;