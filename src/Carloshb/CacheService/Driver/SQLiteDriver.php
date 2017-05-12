<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/05/17
 * Time: 16:11
 */

namespace Carloshb\CacheService\Driver;


trait SQLiteDriver
{
    protected $conn = null;
    protected function connect(){
        $path = $_ENV['cache_path'] ?? __DIR__;
        $this->conn = new \SQLite3(realpath($path) . '/cache.sqlite');
    }
    protected function getConn(){
        return $this->conn;
    }
    protected function disconnect(){
        if (null !== $this->conn)
            $this->conn->close();
    }
}