<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/05/17
 * Time: 15:57
 */

namespace Carloshb\CacheService;


use Carloshb\CacheService\Driver\Model;

class CacheModel extends Model
{
    protected $table = "storage";
    public function __construct()
    {
        $this->connect();
        $this->createTable();
        $this->disconnect();
    }
    private function createTable(){
        $this->getConn()->exec('CREATE TABLE IF NOT EXISTS storage (
            id integer PRIMARY KEY AUTOINCREMENT,
            name text,
            content varchar,
            created_at timestamp,
            updated_at timestamp
        )');
    }
}