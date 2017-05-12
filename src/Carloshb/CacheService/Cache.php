<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/05/17
 * Time: 15:53
 */

namespace Carloshb\CacheService;

final class Cache
{
    private $callback;
    private $cache;

    /**
     * @param string $key
     * @return bool
     */
    public function isCached(string $key) : bool {
        $cache = new CacheModel();
        $result = $cache->where([
            'field' => 'name',
            'operation' => '=',
            'content' => $key
        ])->get();
        if (is_array($result) && !empty($result)):
            $lastUpdate = strtotime($result['updated_at']);
            $difference = time() - $lastUpdate;
            $time = ($_ENV['cache_time'] ?? 60) * 10;
            if($difference <= $time):
                $this->cache = $result;
            else:
                $this->updateCache($key);
            endif;
            return true;
        else:
            return false;
        endif;
    }

    /**
     * @param string $key
     */
    protected function updateCache(string $key){
        $callback = $this->callback;
        $cache = new CacheModel();
        $cache->where([
            'field' => 'name',
            'operation' => '=',
            'content' => $key
        ])->update([
            'content' => json_encode($callback(), JSON_UNESCAPED_SLASHES),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $this->cache = $cache->where([
            'field' => 'name',
            'operation' => '=',
            'content' => $key
        ])->get();
    }

    /**
     * @param string $key
     */
    protected function createCache(string $key){
        $cache = new CacheModel();
        $callback = $this->callback;
        $time = date('Y-m-d H:i:s');
        $cache->save([
            'name' => $key,
            'content' => json_encode($callback(), JSON_UNESCAPED_SLASHES),
            'created_at' => $time,
            'updated_at' => $time
        ]);
        $this->cache = $cache->where([
            'field' => 'name',
            'operation' => '=',
            'content' => $key
        ])->get();
    }

    /**
     * @param string $key
     * @param callable $callback
     * @return Cache
     */
    public function resolve(string $key, callable $callback) : Cache {
        $this->callback = $callback;
        if (!$this->isCached($key)):
            $this->createCache($key);
        endif;
        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function destroy(string $key) : bool {
        $cache = new CacheModel();
        $result = $cache->where([
            'field' => 'name',
            'operation' => '=',
            'content' => $key
        ])->get();
        return $cache->destroy($result['id']);
    }

    /**
     * @return mixed = json
     */
    public function getCacheContent(){
        return $this->cache['content'];
    }
}