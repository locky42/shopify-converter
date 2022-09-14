<?php

namespace app\helpers;

use Exception;

class CsvReader
{
    const IMPORT_FILE_NAME = 'import.csv';

    protected ?string $fileName;

    private $fStream;

    /**
     * @param string|null $fileName
     */
    public function __construct(?string $fileName = null)
    {
        $this->setFileName($fileName ? : self::IMPORT_FILE_NAME);
    }

    /**
     * @param string $fileName
     * @return $this
     */
    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function read(): array
    {
        $this->initFStream();
        $data = [];
        while (($row = fgetcsv($this->fStream)) !== FALSE) {
            $data[] = $row;
        }
        return $data;
    }

    protected function initFStream()
    {
        $importFile = $this->fileName;
        if (!is_file($importFile)) {
            throw new Exception("File $importFile not exist");
        }
        $this->fStream = fopen($importFile, 'r');

        if ($this->fStream === false) {
            die('Error opening the file ' . $importFile);
        }
    }

    public function __destruct()
    {
        if ($this->fStream) {
            fclose($this->fStream);
        }
    }
}
