--- Weryfikacja planu
SELECT order_number, count(order_number) 
FROM `order` 
WHERE order_number in (SELECT order_number  FROM `order` WHERE `article_planed` LIKE '%36/2015%') AND article_planed NOT LIKE '%36/2015%'
GROUP BY order_number

--- Zestawienie do fakturowania
SELECT 
   COUNT(model_name) as 'szt.', 
   model_name as 'model', 
   model_type as 'typ', 
   article_all_textile_amount as 'ilość mat.', 
   article_first_textile_amount as 'deseń 1 - ilość mat.', 
   article_second_textile_amount as 'deseń 2 - ilość mat.',
   fabric1.fabric_price_group as 'deseń 1 - grupa', 
   fabric2.fabric_price_group as 'deseń 2 - grupa',
   ROUND((fabric1.fabric_price_group + fabric2.fabric_price_group)/2) as 'średnia grupa',
   order_total_price as 'cena za szt.',  
   SUM(order_total_price) as 'suma cen'
   
FROM `order`
LEFT JOIN article
   ON order.article_article_id = article.article_id
LEFT JOIN textile textile1
   ON order.textile1_textile_id = textile1.textile_id
LEFT JOIN textile textile2
   ON order.textile2_textile_id = textile2.textile_id
LEFT JOIN fabric_collection fabric1
   ON textile1.textile_number = fabric1.fabric_number
LEFT JOIN fabric_collection fabric2
   ON textile2.textile_number = fabric2.fabric_number
   
WHERE checked=1
GROUP BY 
   model_name, 
   model_type, 
   article_all_textile_amount, 
   article_first_textile_amount, 
   article_second_textile_amount, 
   textile1.textile_price_group, 
   textile2.textile_price_group,
   fabric1.fabric_price_group,
   fabric2.fabric_price_group,
   order_total_price
ORDER BY model_name ASC, model_type ASC

SELECT 
   COUNT(model_name) as 'szt.', 
   model_name as 'model', 
   model_type as 'typ', 
   article_all_textile_amount as 'ilość mat.', 
   article_first_textile_amount as 'deseń 1 - ilość mat.', 
   article_second_textile_amount as 'deseń 2 - ilość mat.',
   textile1.textile_number,
   textile2.textile_number,
   fabric1.fabric_price_group as 'deseń 1 - grupa', 
   fabric2.fabric_price_group as 'deseń 2 - grupa',
   ROUND((fabric1.fabric_price_group + fabric2.fabric_price_group)/2) as 'średnia grupa',
   order_total_price as 'cena za szt.',  
   SUM(order_total_price) as 'suma cen'
   
FROM `order`
LEFT JOIN article
   ON order.article_article_id = article.article_id
LEFT JOIN textile textile1
   ON order.textile1_textile_id = textile1.textile_id
LEFT JOIN textile textile2
   ON order.textile2_textile_id = textile2.textile_id
LEFT JOIN fabric_collection fabric1
   ON textile1.textile_number = fabric1.fabric_number
LEFT JOIN fabric_collection fabric2
   ON textile2.textile_number = fabric2.fabric_number
   
WHERE checked=1
GROUP BY 
   model_name, 
   model_type, 
   article_all_textile_amount, 
   article_first_textile_amount, 
   article_second_textile_amount, 
   textile1.textile_price_group, 
   textile2.textile_price_group,
   fabric1.fabric_price_group,
   fabric2.fabric_price_group,
   order_total_price,
   textile1.textile_number,
   textile2.textile_number
ORDER BY model_name ASC, model_type ASC

--- Nowe zamówienia, które już kiedyś wyjechały
SELECT SUBSTRING(order_number,1,6)  FROM `order` WHERE `order_add_date` > '2015-10-07 00:00:00' AND
SUBSTRING(order_number,1,6) IN (SELECT SUBSTRING(order_number,1,6)  FROM `order` WHERE `article_exported` IS NOT NULL AND `order_add_date` < '2015-10-07 00:00:00')

--- Nowe zamówienia z takimi samymi numerami jak stare
SELECT SUBSTRING(order_number,1,6) FROM `order` WHERE `order_add_date` > '2015-10-07 00:00:00' AND 
SUBSTRING(order_number,1,6) IN (SELECT SUBSTRING(order_number,1,6) FROM `order` WHERE `article_exported` IS NULL AND article_canceled = 0 AND `order_add_date` < '2015-10-07 00:00:00')


--- Materiały które nie mają dostawcy - dopasowany dostawca na podstawie wzoru
SELECT *, textile_number, 
(SELECT CONCAT_WS(', ', textile_number, pattern, supplier_supplier_id) FROM textile textile2 where pattern=1 AND textile2.textile_number=textile1.textile_number) 
FROM `textile` textile1 WHERE `supplier_supplier_id` IS NULL 

--- Przypisuje dostawcę do nowych materiałów na podstawie wzorów
CREATE TEMPORARY TABLE IF NOT EXISTS temporary_textiles AS (SELECT textile.textile_number, textile.supplier_supplier_id, textile.pattern FROM textile WHERE pattern=1);

UPDATE textile 
SET textile.supplier_supplier_id=(SELECT temporary_textiles.supplier_supplier_id FROM temporary_textiles WHERE pattern=1 AND 
    textile.textile_number=temporary_textiles.textile_number)
WHERE `supplier_supplier_id` IS NULL

--- Lista zaplanowanych zamówień na potrzeby pliku Excel
SELECT CONCAT_WS("_", order_number, buyer_order_number) article_planed 
FROM `order` 
WHERE article_planed IS NOT NULL and article_exported IS NULL AND article_canceled=0

--- Lista zużycia materiałów z firmy Hypke w poszczególnych miesiącach
SELECT order_add as 'miesiąc', textile_number as 'nr mat.', SUM(des1) as 'm.'
FROM (SELECT SUBSTR(order_add_date,1,7) as order_add,
textile1.textile_number,
IFNULL(article_first_textile_amount, article_all_textile_amount) as 'des1'

FROM `order`

LEFT JOIN article
ON order.article_article_id = article.article_id

LEFT JOIN textile textile1
ON order.textile1_textile_id = textile1.textile_id

LEFT JOIN textile textile2
ON order.textile2_textile_id = textile2.textile_id

WHERE article_canceled = 0 AND textile1.textile_number in (4001, 4002, 4003, 4005, 4006, 4007, 4008)

UNION ALL

SELECT SUBSTR(order_add_date,1,7) as order_add,
textile2.textile_number,
article_second_textile_amount as 'des1'

FROM `order`

LEFT JOIN article
ON order.article_article_id = article.article_id

LEFT JOIN textile textile1
ON order.textile1_textile_id = textile1.textile_id

LEFT JOIN textile textile2
ON order.textile2_textile_id = textile2.textile_id

WHERE article_canceled = 0 AND textile2.textile_number in (4001, 4002, 4003, 4005, 4006, 4007, 4008)) as sub


GROUP BY order_add, textile_number
ORDER BY order_add ASC

--- Statystyka planu
SELECT COUNT(model_name) as 'szt.', model_name as 'model', model_type as 'typ', article_planed as 'plan'
FROM `order`

LEFT JOIN article
ON order.article_article_id = article.article_id

LEFT JOIN textile textile1
ON order.textile1_textile_id = textile1.textile_id

LEFT JOIN textile textile2
ON order.textile2_textile_id = textile2.textile_id

WHERE article_planed like '43/%' AND article_exported is null AND article_canceled = 0

GROUP BY model_name, model_type, article_planed
ORDER BY model_name ASC, model_type ASC
