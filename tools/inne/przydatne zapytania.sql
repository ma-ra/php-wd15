--- Weryfikacja planu
SELECT order_number, count(order_number) 
FROM `order` 
WHERE order_number in (SELECT order_number  FROM `order` WHERE `article_planed` LIKE '%36/2015%') AND article_planed NOT LIKE '%36/2015%'
GROUP BY order_number

--- Nowe zamówienia, które już kiedyś wyjechały
SELECT SUBSTRING(order_number,1,6)  FROM `order` WHERE `order_add_date` > '2015-10-07 00:00:00' AND
SUBSTRING(order_number,1,6) IN (SELECT SUBSTRING(order_number,1,6)  FROM `order` WHERE `article_exported` IS NOT NULL AND `order_add_date` < '2015-10-07 00:00:00')

--- Nowe zamówienia z takimi samymi numerami jak stare
SELECT SUBSTRING(order_number,1,6) FROM `order` WHERE `order_add_date` > '2015-10-07 00:00:00' AND 
SUBSTRING(order_number,1,6) IN (SELECT SUBSTRING(order_number,1,6) FROM `order` WHERE `article_exported` IS NULL AND article_canceled = 0 AND `order_add_date` < '2015-10-07 00:00:00')


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

--- Lista zamówień w danym materiale oraz lista zamówień powiązanych
SELECT 
   order_number,
   buyer_order_number,
   order_term, 
   article.model_name,
   article.model_type,
   textile1.textile_number, 
   textile2.textile_number

FROM `order`
LEFT JOIN article
   ON order.article_article_id = article.article_id
LEFT JOIN textile textile1
   ON order.textile1_textile_id = textile1.textile_id
LEFT JOIN textile textile2
   ON order.textile2_textile_id = textile2.textile_id
   
WHERE
   article_canceled = 0 AND
   article_exported is NULL AND
   (textile1.textile_number = 4005 OR textile2.textile_number = 4005);
   
SELECT 
   order_number,
   buyer_order_number,
   order_term, 
   article.model_name,
   article.model_type,
   textile1.textile_number, 
   textile2.textile_number

FROM `order` as order1
LEFT JOIN article
   ON order1.article_article_id = article.article_id
LEFT JOIN textile textile1
   ON order1.textile1_textile_id = textile1.textile_id
LEFT JOIN textile textile2
   ON order1.textile2_textile_id = textile2.textile_id
   
WHERE
   article_canceled = 0 AND
   article_exported is NULL AND
   (textile1.textile_number != 4005 OR textile2.textile_number != 4005) AND
   order_number IN 
      (SELECT 
         order_number
        
      FROM `order` as order2
      LEFT JOIN textile textile1
         ON order2.textile1_textile_id = textile1.textile_id
      LEFT JOIN textile textile2
         ON order2.textile2_textile_id = textile2.textile_id
         
      WHERE
         article_canceled = 0 AND
         article_exported is NULL AND
         (textile1.textile_number = 4005 OR textile2.textile_number = 4005)
      );


--- Ustalenie notki na podstawie powyższego
CREATE TEMPORARY TABLE IF NOT EXISTS temporary_order AS 
(SELECT 
     order_number
    
  FROM `order` as order2
  LEFT JOIN textile textile1
     ON order2.textile1_textile_id = textile1.textile_id
  LEFT JOIN textile textile2
     ON order2.textile2_textile_id = textile2.textile_id
     
  WHERE
     article_canceled = 0 AND
     article_exported is NULL AND
     (textile1.textile_number = 4005 OR textile2.textile_number = 4005)
);


UPDATE `order`
SET order_notes = 'Dostawa 4005 w 49/50' 
WHERE
   article_canceled = 0 AND
   article_exported is NULL AND
   order_number IN (SELECT * FROM temporary_order);

-- usówanie części notatek
ELECT `order_number` , `order_error` , `order_notes` , replace( order_notes, 'czy storno?', '' )
FROM `order`
WHERE order_notes LIKE '%czy storno?%'

update `order`
SET `order_notes`=replace(`order_notes`,'czy storno?','')
where order_notes like '%czy storno?%';
