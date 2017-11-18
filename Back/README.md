# Back-End

## Configuration d'apache

* Ajouter à  apache2.conf, si les fchiers sont stockes dans `/var/www`:

```html
<Directory /var/www/>
        AllowOverride All
</Directory>
```

## Tester le router et l'API:

```bash
curl --data {json} -X {METHOD} localhost/v1/{action}/{id}
```

Avec :

```bash
json='{"param1":"value1","param2":"value2"}'
METHOD=[GET|POST|PUT|PATCH|DELETE]
action= action de la route
id= id de la ressource
```