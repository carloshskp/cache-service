<?php

namespace Carloshb\CacheService\Contracts;

interface ModelContract
{
    /**
     * @return bool|array
     */
    public function get();

    /**
     * @param array $data = ["field" => "name", "operation" => "LIKE", "content" => "Carlos"]
     * @return ModelContract
     */
    public function where(array $data) : ModelContract;

    /**
     * @param int $id
     * @return array
     */
    public function find(int $id) : array ;

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data) : bool;

    /**
     * @param array $data
     * @return bool
     */
    public function update(array $data) : bool;

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id) : bool ;
}