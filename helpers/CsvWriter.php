<?php

namespace app\helpers;

use Exception;

class CsvWriter
{
    const EXPORT_FILE_NAME = 'export.csv';

    protected string $outputDir;
    protected array $columns = [];
    protected array $data = [];
    protected string $fileName;

    private $fStream;

    /**
     * @param string|null $outputDir
     * @param array $columns
     * @param string|null $fileName
     * @throws Exception
     */
    public function __construct(?string $outputDir = '', array $columns = [], ?string $fileName = null)
    {
        $this
            ->setOutputDir($outputDir)
            ->setColumns($columns)
            ->setFileName($fileName ? : self::EXPORT_FILE_NAME);
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function setColumns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string $outputDir
     * @return $this
     * @throws Exception
     */
    public function setOutputDir(string $outputDir): self
    {
        File::setDir($outputDir);
        $this->outputDir = $outputDir;
        return $this;
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

    public function write()
    {
        $this->initFStream();
        if (!empty($this->columns)) {
            fputcsv($this->fStream, $this->columns);
        }

        foreach ($this->data as $row) {
            fputcsv($this->fStream, $row);
        }
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return "$this->outputDir/" . $this->fileName;
    }

    protected function initFStream()
    {
        $exportFile = $this->getFilePath();
        $this->fStream = fopen($exportFile, 'w');
        if ($this->fStream === false) {
            die('Error opening the file ' . $exportFile);
        }
    }

    public function __destruct()
    {
        if ($this->fStream) {
            fclose($this->fStream);
        }
    }
}
