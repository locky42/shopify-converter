<?php

namespace app\helpers;

use Exception;

class File
{
    const FILES_DIR = 'uploads/';

    /**
     * @param string $file
     * @return string
     */
    public static function getFilePath(string $file): string
    {
        return self::FILES_DIR . $file;
    }

    /**
     * @param $patch
     * @return bool
     * @throws Exception
     */
    public static function setDir($patch): bool
    {
        if (!is_dir($patch)) {
            $mkdir = mkdir($patch, 0777, true);
            if (!$mkdir) {
                throw new Exception('Сan\'t create folder ' . $patch);
            }
        }
        return true;
    }
}