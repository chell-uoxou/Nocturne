<?php
/**
 * Created by PhpStorm.
 * User: 20150176
 * Date: 2017/09/30
 * Time: 15:38
 */

namespace nocturne;


class Loader
{
    /**
     * @var Iterator
     */
    private $iterator;

    /**
     * Options
     *
     * @var array
     */
    private $exclude_files = [];
    private $exclude_file_patterns = [];
    private $exclude_dirs = [];

    /**
     * @access public
     */
    public static function init($dir, $recursive = false, $options = [])
    {
        if (!$dir || !($dir = realpath($dir)) || !is_dir($dir))
            return;
        new self($dir, (bool)$recursive, (array)$options);
    }

    /**
     * @access private
     *
     * @param  readable $dir
     * @param  boolean $recursive
     * @param  array $args
     * @return void
     */
    public function __construct($dir, $recursive, Array $args)
    {
        $this->prepare($args);
        $this->setIterator($dir, $recursive);
        $this->includeFiles();
    }

    /**
     * @access private
     *
     * @todo
     *
     * @param  array $options {
     * @type string|array $exclude_files
     * @type string|array $exclude_dirs
     * }
     * @return void
     */
    private function prepare(Array $options)
    {
        $this->exclude_files[] = __FILE__;
        if (!$options)
            return;
        $options = filter_var_array($options, self::getOptDef(), true);
        extract($options);
        /**
         * Exclude files
         */
        if ($exclude_files = array_filter((array)$this->exclude_files))
            $this->exclude_files = array_merge($this->exclude_files, $exclude_files);
        /**
         * Exclude File Patterns (Regexp)
         */
        if ($exclude_file_patterns = array_filter((array)$this->exclude_file_patterns))
            $this->exclude_file_patterns = $exclude_file_patterns;
        /**
         * Exclude Directories
         */
        if ($exclude_dirs = array_filter((array)$this->exclude_dirs))
            $this->exclude_dirs = $exclude_dirs;
    }

    /**
     * @access private
     */
    private function setIterator($path, $recursive)
    {
        $flags = \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO;
        if ($recursive)
            $this->iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, $flags));
        else
            $this->iterator = new \FilesystemIterator($path, $flags);
    }

    /**
     * @access private
     */
    public function includeFiles()
    {
        foreach ($this->iterator as $path => $fileinfo) {
            if ($this->exclude_dirs) {
                foreach ($this->exclude_dirs as $dir) {
                    if (strpos($path, $dir) !== false)
                        continue 2;
                }
            }
            if ($fileinfo->getExtension() !== 'php' || in_array($path, $this->exclude_files))
                continue;
            if ($this->exclude_file_patterns) {
                $basename = $fileinfo->getBasename();
                foreach ($this->exclude_file_patterns as $pattern) {
                    if (preg_match($pattern, $basename))
                        continue 2;
                }
            }
            require_once $path;
        }
    }

    /**
     * Return options arguments filter definition
     *
     * @access private
     *
     * @return array
     */
    private static function getOptDef()
    {
        static $def;
        if (!isset($def)) {
            $fileFilter = function ($file) {
                return filter_var($file) ? realpath($file) : false;
            };
            $dirFilter = function ($dir) use ($fileFilter) {
                if (!$dir = $fileFilter($dir))
                    return false;
                return is_dir($dir) ? $dir . DIRECTORY_SEPARATOR : false;
            };
            $regexpFilter = function ($pattern) {
                return @preg_match($pattern, '') !== false ? $pattern : false;
            };
            $def = [
                'exclude_files' => ['filter' => \FILTER_CALLBACK, 'options' => $fileFilter],
                'exclude_file_patterns' => ['filter' => \FILTER_CALLBACK, 'options' => $regexpFilter],
                'exclude_dirs' => ['filter' => \FILTER_CALLBACK, 'options' => $dirFilter],
            ];
        }
        return $def;
    }
}