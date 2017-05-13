<?php

use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    public function testExpectedResultsWithDelay(){
        $cache = new \Carloshb\CacheService\Cache();
        $data = [
            'name' => 'Carlos Henrique Bernardes',
            'email' => 'contato@carloshb.com.br'
        ];
        $content = $cache->resolve('getInfo', function() use ($data) {
            sleep(5);
            return $data;
        })->getCacheContent();
        $this->assertEquals(true, $cache->isCached('getInfo'));
        $this->assertJson(json_encode($data, JSON_UNESCAPED_SLASHES), $content);
    }
    public function testExpectedResultsWithoutDelay(){
        $cache = new \Carloshb\CacheService\Cache();
        $data = [
            'name' => 'Carlos Henrique Bernardes',
            'email' => 'contato@carloshb.com.br'
        ];
        $content = $cache->resolve('getInfo', function() use ($data) {
            return $data;
        })->getCacheContent();
        $this->assertJson(json_encode($data, JSON_UNESCAPED_SLASHES), $content);
    }

    public function testManualDestroyCache(){
        $cache = new \Carloshb\CacheService\Cache();
        $response = $cache->destroy('getInfo');
        $this->assertEquals(true, $response);
        $this->assertEquals(false, $cache->isCached('getInfo'));
    }
}