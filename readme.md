![http://souktel.com/](http://www.souktel.com/cached_uploads/fit/350/233/default-image.png) 

# About Souktel
- **Website:** ***[souktel.com](http://www.souktel.com/).***
- **LinkedIn:** ***[Souktel](https://www.linkedin.com/company/souktel).***
- **Facebook:** ***[Souktel Digital Solutions](https://www.facebook.com/souktel).***
- **Twitter:** ***[Souktel](https://twitter.com/Souktel).***


# About The Project

implementation of ACL in souktel services

# Installation
```composer
 composer require souktel/acl
```
In Laravel:
 - publish config and migrations files from vendor
 ```php
php artisan vendor:publish --provider="Souktel\ACL\SouktelACLServiceProvider"
```

In Lumen:
- copy config file from vendor
- copy migration files from vendor


# configuration

in config file

| variable  | description | 
| ------------- | ------------- |
|enable | (boolean) enable or disable ACL in the service [default = true] |
| auth | auth functionality |
| auth.auth_service | auth service details |
| auth.token_header.sent | token header in request sent to Auth service from current service |
| auth.token_header.received | token header in request received in the current service |
| auth.invalid_payload_exception | Custom exception when token payload is invalid |
| acl | acl functionality |
| acl.model | permission model |
| acl.database  | name and slug columns in permissions table in database |
| acl.register_permission_message_name  | register permission message in message broker  |
| this_service  | current service details |
| this_service.key  | current service key or slug to be send in register permission message in message broker |