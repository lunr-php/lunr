/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `table` (
   `param1` varchar(255) NOT NULL,
   `param2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changedData`)),
   `param3` int(11) NOT NULL,
   `param4` bigint(20) NOT NULL,
   `param5` enum('added','changed','deleted') NOT NULL,
   `param6` varchar(8) GENERATED ALWAYS AS (json_value(from_base64(`id`),'$.codeShareFlightNumber')) STORED,
   `param7` tinyint(1) GENERATED ALWAYS AS (if(json_value(from_base64(`id`),'$.arrival') = '1',1,0)) STORED,
   `param8` date GENERATED ALWAYS AS (json_value(from_base64(`id`),'$.scheduledDate')) STORED,
   `param9` char(3) GENERATED ALWAYS AS (json_value(from_base64(`id`),'$.departureAirport')) STORED,
   `param10` char(3) GENERATED ALWAYS AS (json_value(from_base64(`id`),'$.arrivalAirport')) STORED,
   `param11` char(3) GENERATED ALWAYS AS (json_value(from_base64(`id`),'$.viaAirport')) STORED,
   PRIMARY KEY (`param1`,`param2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 `PAGE_COMPRESSED`=1;
/*!40101 SET character_set_client = @saved_cs_client */;