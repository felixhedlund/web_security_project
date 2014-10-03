Nu ska det funka med SSL-anslutningen... -Eric

* Inställningar gäller endast för MAMP, sorry Caroline.


==================================================
# 1: Kopiera filer
==================================================

Skapa backups och kopiera följande filer :

    httpd-ssl.conf  ->  MAMP/conf/apache/extra/httpd-ssl.conf
    server.crt      ->  MAMP/conf/apache/server.crt
    server.key      ->  MAMP/conf/apache/server.key


==================================================
# 2: Konfigurera MAMP
==================================================

Öppna 'MAMP/conf/apache/extra/httpd-ssl.conf' och ta bort kommentaren
på följande rad:

    (528) Include /Applications/MAMP/conf/apache/extra/httpd-ssl.conf

Starta MAMP och ändra apache-porten från 8888 (default) till 80.


==================================================
# 3: Anslut via SSL:
==================================================

Lägg till 'https://' innan 'localhost' i URL:en och acceptera certifikatet

