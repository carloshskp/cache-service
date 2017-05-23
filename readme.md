# carloshb/cache-service
[![Latest Stable Version](https://poser.pugx.org/carloshb/cache-service/v/stable)](https://packagist.org/packages/carloshb/cache-service)
[![Total Downloads](https://poser.pugx.org/carloshb/cache-service/downloads)](https://packagist.org/packages/carloshb/cache-service)
[![Latest Unstable Version](https://poser.pugx.org/carloshb/cache-service/v/unstable)](https://packagist.org/packages/carloshb/cache-service)
[![License](https://poser.pugx.org/carloshb/cache-service/license)](https://packagist.org/packages/carloshb/cache-service)

Simple cache service using SQLite to reduce multiple db queries.
## Basic information
* **default cache time**: 60mins
* **default cache path**: Carloshb\CacheService\Driver
## How to install?
Install using composer
```shell
composer require carloshb/cache-service 0.2.*
```
Or clone in or project.
### How to change default configs?
Add PHP env:
```php
    $_ENV['cache_time'] = 10; // minutes
    $_ENV['cache_path'] = 'yor/storage/path';
```
## Usage
### resolve(string $key, callable $callback [, int $time = 60]) : Cache
The method **resolve()** returns an instance of Cache class and generate or update the key sent with the callback return. First parameter is the key, a string.
Second parameter is the callback, a function returning array with expected results. Third parameter is optional, for set *n* minutes for cache. 
```php
    $cache = new \Carloshb\CacheService\Cache();
    $cache->resolve('getInfo', function(){
        return array(
            'name' => 'Carlos Henrique Bernardes',
            'email' => 'contato@carloshb.com.br'
        );
    });
```
### getCacheContent() : json
Use after **resolve()** to get a content of cache, the method returns a json.
```php
    $cache = new \Carloshb\CacheService\Cache();
    $content = $cache->resolve('getInfo', function(){
        return array(
            'name' => 'Carlos Henrique Bernardes',
            'email' => 'contato@carloshb.com.br'
        );
    })->getCacheContent();
```

### destroy(string $key) : bool
Use this method to force cache destroy using the key name.
```php
    $cache = new \Carloshb\CacheService\Cache();
    $response = $cache->destroy('getInfo');
    var_dump($response); // true or false
```