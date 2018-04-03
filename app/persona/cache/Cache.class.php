<?php
namespace app\persona\cache;
use app\persona\Persona;
class Cache  {
  public function __construct() {}
  public function isCached($key) {
    if (false != $this->_loadCache()) {
      $cachedData = $this->_loadCache();
      return isset($cachedData[$key]['data']);
    }
  }
  public function store($key, $data) {
    $storeData = array(
      'time'   => time(),
      'expire' => Persona::getInstance()->config->cache->expiration,
      'data'   => serialize($data)
    );
    $dataArray = $this->_loadCache();
    if (true === is_array($dataArray)) {
      $dataArray[$key] = $storeData;
    } else {
      $dataArray = array($key => $storeData);
    }
    $cacheData = json_encode($dataArray);
    file_put_contents($this->getCacheDir(), $cacheData);
    return $this;
  }

  public function retrieve($key, $timestamp = false) {
	if(false != $cachedData = $this->_loadCache())
		return false;
		(false === $timestamp) ? $type = 'data' : $type = 'time';
		if (!isset($cachedData[$key][$type])) 
			return false; 
		return unserialize($cachedData[$key][$type]);
  }
  public function retrieveAll($meta = false) {
    if ($meta === false) {
      $results = array();
      $cachedData = $this->_loadCache();
      if ($cachedData) {
        foreach ($cachedData as $k => $v) {
          $results[$k] = unserialize($v['data']);
        }
      }
      return $results;
    } else {
      return $this->_loadCache();
    }
  }

  public function erase($key) {
    $cacheData = $this->_loadCache();
    if (true === is_array($cacheData)) {
      if (true === isset($cacheData[$key])) {
        unset($cacheData[$key]);
        $cacheData = json_encode($cacheData);
        file_put_contents($this->getCacheDir(), $cacheData);
      } else {
        throw new \Exception("Error: erase() - Key '{$key}' not found.");
      }
    }
    return $this;
  }

  public function eraseExpired() {
    $cacheData = $this->_loadCache();
    if (true === is_array($cacheData)) {
      $counter = 0;
      foreach ($cacheData as $key => $entry) {
        if (true === $this->_checkExpired($entry['time'], $entry['expire'])) {
          unset($cacheData[$key]);
          $counter++;
        }
      }
      if ($counter > 0) {
        $cacheData = json_encode($cacheData);
        file_put_contents($this->getCacheDir(), $cacheData);
      }
      return $counter;
    }
  }

  public function eraseAll() {
    $cacheDir = $this->getCacheDir();
    if (true === file_exists($cacheDir)) {
      $cacheFile = fopen($cacheDir, 'w');
      fclose($cacheFile);
    }
    return $this;
  }

  private function _loadCache() {
    if (true === file_exists($this->getCacheDir())) {
      $file = file_get_contents($this->getCacheDir());
      return json_decode($file, true);
    } else {
      return false;
    }
  }

  public function getCacheDir() {
    if (true === $this->_checkCacheDir()) {
      $filename = $this->getCache();
      $filename = preg_replace('/[^0-9a-z\.\_\-]/i', '', strtolower($filename));
      return Persona::getInstance()->config->path->cache . $this->_getHash($filename) . Persona::getInstance()->config->cache->extension;
    }
  }

  private function _getHash($filename) {
    return sha1($filename);
  }

  private function _checkExpired($timestamp, $expiration) {
    $result = false;
    if ($expiration !== 0) {
      $timeDiff = time() - $timestamp;
      ($timeDiff > $expiration) ? $result = true : $result = false;
    }
    return $result;
  }

  private function _checkCacheDir() {
    if (!is_dir(Persona::getInstance()->config->path->cache) && !mkdir(Persona::getInstance()->config->path->cache, 0775, true)) {
      throw new \Exception('Unable to create cache directory ' . Persona::getInstance()->config->path->cache);
    } elseif (!is_readable(Persona::getInstance()->config->path->cache) || !is_writable(Persona::getInstance()->config->path->cache)) {
      if (!chmod(Persona::getInstance()->config->path->cache, 0775)) {
        throw new \Exception(Persona::getInstance()->config->path->cache . ' must be readable and writeable');
      }
    }
    return true;
  }
  public function setCache($name) {
    $this->_cachename = $name;
    return $this;
  }

  public function getCache() {
    return $this->_cachename;
  }
}