Egutegia
============

Pasaiako Udaletxeko langileen egutegiak kudeatzeko web aplikazioa.

   `app/config/parameters.yml` fitxategia bete beharrezko datuekin
   
node bertsio zehatza erabiltzeko:
    `nvm use --delete-prefix v6.17.1`

ondoren `nvm use --delete-prefix v14`


CKEditor fix:

    bin/console ckeditor:install --tag=4.22.1
    bin/console assets:install


# DEPLOY

    pasahitza jarri ./ansistrano/production fitxategian
    ansible-playbook -i .ansistrano/production .ansistrano/deploy.yml -vvv exekutatu

    ssh root@egutegia.pasai.net-era
    bin/console ckeditor:install --tag=4.22.1
    bin/console assets:install

## COMPOSER.PHAR erabili

Bikoiztutako filak ezabatzeko MYSQL-n

    DELETE t1 FROM notification t1
             INNER JOIN
         notification t2 
     WHERE
         t1.id > t2.id 
         and t1.description = t2.description 
         and t1.eskaera_id = t2.eskaera_id 
         and t1.firma_id=t2.firma_id 
         and t1.name = t2.name 
         and t1.user_id = t2.user_id;   

Requirements:
- Beharrezkoaz da wkhtmltopdf instalatua izatea zerbitzarian:
    - EZ ERABILI => sudo apt-get install wkhtmltopdf => EZ DABIL!!!
    - lib barruan dagoena instalatu (Debian 8 bertsioa)
    - eskuratu non instalatua dagoen => whereis wkhtmltopdf


