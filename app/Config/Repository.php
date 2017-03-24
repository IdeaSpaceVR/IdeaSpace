<?php 

namespace App\Config;

use Illuminate\Config\Repository as RepositoryBase;

class Repository extends RepositoryBase
{
    /**
     * The config rewriter object.
     *
     * @var string
     */
    protected $writer;
    /**
     * Create a new configuration repository.
     *
     * @param  array  $items
     * @param  FileWriter $writer
     * @return void
     */
    public function __construct($items = array(), $writer)
    {
        $this->writer = $writer;
        parent::__construct($items);
    }
    /**
     * Write a given configuration value to file.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function write($key, $value)
    {
        list($filename, $item) = $this->parseKey($key);
        $result = $this->writer->write($item, $value, $filename);
        if(!$result) throw new \Exception('File could not be written to');
        $this->set($key, $value);
    }
    /**
     * Split key into 2 parts. The first part will be the filename
     * @param $key
     * @return array
     */
    private function parseKey($key)
    {
        return preg_split('/\./', $key, 2);
    }
}

