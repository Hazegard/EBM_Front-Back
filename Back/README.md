# Back-End

## Configuration d'apache

* Ajouter à  apache2.conf, si les fchiers sont stockes dans `/var/www`:

```html
<Directory /var/www/>
        AllowOverride All
</Directory>
```