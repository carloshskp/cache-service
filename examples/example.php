<?php
    $cache = new \Carloshb\CacheService\Cache();
    $content = $cache->resolve('getInfo', function(){
        return array(
            'name' => 'Carlos Henrique Bernardes',
            'email' => 'contato@carloshb.com.br'
        );
    })->getCacheContent();
    var_dump($content);