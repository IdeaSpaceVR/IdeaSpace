<?php 

namespace App\Config;

use Illuminate\Filesystem\Filesystem;

class FileWriter
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    /**
     * The default configuration path.
     *
     * @var string
     */
    protected $defaultPath;
    /**
     * The config rewriter object.
     *
     * @var \October\Rain\Config\Rewrite
     */
    protected $rewriter;
    /**
     * Create a new file configuration loader.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $defaultPath
     * @return void
     */
    public function __construct(Filesystem $files, $defaultPath)
    {
        $this->files = $files;
        $this->defaultPath = $defaultPath;
        $this->rewriter = new Rewrite;
    }
    public function write($item, $value, $filename)
    {
        $path = $this->getPath($item, $filename);
        if (!$path)
            return false;
        $contents = $this->files->get($path);
        $contents = $this->rewriter->toContent($contents, [$item => $value]);
        return !($this->files->put($path, $contents) === false);
    }
    private function getPath($item, $filename)
    {
        $file = "{$this->defaultPath}/{$filename}.php";
        if ( $this->files->exists($file) &&
            $this->hasKey($file, $item)
        )
            return $file;
        return null;
    }
    private function hasKey($path, $key)
    {
        $contents = file_get_contents($path);
        $vars = eval('?>'.$contents);
        $keys = explode('.', $key);
        $isset = false;
        while ($key = array_shift($keys)) {
            $isset = isset($vars[$key]);
            if (is_array($vars[$key])) $vars = $vars[$key]; // Go down the rabbit hole
        }
        return $isset;
    }
}

