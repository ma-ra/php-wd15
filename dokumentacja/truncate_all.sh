mysql wd15 <<< '
SET foreign_key_checks = 0;

truncate buyer; 
truncate broker;
truncate manufacturer;
truncate leg;
truncate article;
truncate textile;
truncate supplier;
truncate order_has_textile;
TRUNCATE `order` ;

SET foreign_key_checks = 1;
'
