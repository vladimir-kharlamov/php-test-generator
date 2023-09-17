-- Create procedure
DELIMITER $
DROP PROCEDURE IF EXISTS insert_records $
CREATE PROCEDURE insert_records()
BEGIN
DECLARE i INT DEFAULT 0;
WHILE i < 300000 DO
-- insert INTO records (text) VALUES (MD5(RAND()));
insert INTO records (text) VALUES('03edcfe36760936271dc5e6c7d0ab034');
SET i = i + 1;
END WHILE;
END$
DELIMITER ;

-- Call proc
CALL insert_records();

-- Drop procedure before recreate
drop procedure insert_records; 

-- Check data size
SELECT TABLE_NAME AS "Table",
ROUND(((data_length + index_length) / 1024 / 1024), 2) AS "Size (MB)"
FROM information_schema.TABLES
WHERE table_schema = "benchmark_test"
AND TABLE_NAME = "records"
ORDER BY (data_length + index_length) DESC;

-- Kill procedure action on demand by id 
SHOW PROCESSLIST;
kill <ID_Procedure> ;