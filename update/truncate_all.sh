mysql wd15 <<< '
SET foreign_key_checks = 0;

truncate buyer; 
truncate broker;
truncate manufacturer;
truncate leg;
truncate article;
truncate textile;
truncate supplier;
TRUNCATE `order` ;

SET foreign_key_checks = 1;
'
