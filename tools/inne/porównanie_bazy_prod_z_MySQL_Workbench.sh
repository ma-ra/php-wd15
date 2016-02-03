### 1. Dump bazy prod za pomocą schema_dump.sh i zapis pod prod.sql
### 2. Załadowanie schematu z MySQL workbench do bazy i dump za pomocą schema_dump.sh i zapis pod work.sql

rm *.cmp *.srt
cp prod.sql prod.cmp
cp work.sql work.cmp

sed -i '/^[/][*][!]/d' *.cmp
sed -i '/^--/d' *.cmp
sed -i 's/ENGINE=InnoDB */ENGINE=InnoDB /' *.cmp

sort prod.cmp > prod.srt
sort work.cmp > work.srt
