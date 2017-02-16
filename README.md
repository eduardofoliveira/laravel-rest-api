# Laravel PHP Framework

Rest API versão 0.1 Exemplo

    .htaccess para funcionar corretamente no Apache

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteCond %{HTTP:Authorization} ^(.*)$
        RewriteRule ^(.*)$ laravel-api/public/$1 [e=HTTP_AUTHORIZATION:%1,L]
    </IfModule>
