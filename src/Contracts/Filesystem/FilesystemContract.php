<?php
namespace Fluffy\Assistance\Contracts\Filesystem;

/**
 * Class Filesystem
 *
 * @package Fluffy\Assistance\Contracts\Filesystem\FilesystemContract
 */
interface FilesystemContract
{

    /**
     * Prepend contents to file.
     * If file doesn't exists, creates one.
     *
     * @param string $path
     * @param string $contents
     *
     * @return int
     */
    public function prepend(string $path, string $contents): int;

    /**
     * Checks whether a file or directory exists in given path
     *
     * @param string $path
     *
     * @return bool
     */
    public function exists(string $path): bool;

    /**
     *  Puts contents to file.
     *  If file doesn't exists, creates one.
     *
     * @param string $path
     * @param string $contents
     * @param bool   $lock
     *
     * @return int
     */
    public function put(
        string $path,
        string $contents,
        bool $lock = false
    ): int;

    /**
     * Return contents of given file, if not exists, throw Exception
     *
     * @param string $path
     *
     * @return string
     *
     * @throws \Fluffy\Filesystem\Exceptions\FileNotFoundException
     */
    public function get(string $path): string;

    /**
     * Checks whether it's file
     *
     * @param string $path
     *
     * @return bool
     */
    public function isFile(string $path): bool;

    /**
     * Checks whether it's file
     *
     * @param string $path
     *
     * @return bool
     */
    public function isDirectory(string $path): bool;

    /**
     * Append contents to file, if file not exists creates one.
     *
     * @param string $path
     * @param string $contents
     *
     * @return int
     */
    public function append(string $path, string $contents): int;

    /**
     * Attempts to create the directory specified by pathname.
     *
     * @param string $pathName
     * @param int    $mode
     * @param bool   $recursive
     *
     * @return bool
     */
    public function makeDirectory(
        string $pathName,
        int $mode = 0777,
        bool $recursive = false
    ): bool;

    /**
     * Delete's file.
     *
     * @param string $path
     *
     * @return bool
     */
    public function delete(string $path): bool;

    /**
     * Moves a file to a new location.
     *
     * @param string $source
     * @param string $destination
     *
     * @return bool
     */
    public function move(string $source, string $destination): bool;

    /**
     * Copy file to new location
     *
     * @param string $source
     * @param string $destination
     *
     * @return bool
     */
    public function copy(string $source, string $destination): bool;
}