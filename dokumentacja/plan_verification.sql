SELECT order_number, count(order_number) 
FROM `order` 
WHERE order_number in (SELECT order_number  FROM `order` WHERE `article_planed` LIKE '%36/2015%') AND article_planed NOT LIKE '%36/2015%'
GROUP BY order_number
ORDER BY count(order_number)  DESC
