<?php
/**
 * класс для конвертации csv-файлов в sql-таблицы
 */
namespace TaskForce\Convertation;

use \SplFileObject;
use \SplFileInfo;
use TaskForce\Exceptions\FileExistException;
use TaskForce\Exceptions\FileOpenException;

class ConvertCSVtoSQL
{
    private string $filename;       // путь к csv-файлу
    private string $sqlTableName;   // имя sql-файла, куда нужно импортировать данные csv-файла
    private string $columns;        // массив имен столбцов/полей файла csv
    private array $values;          // массив данных полей файла csv
    private object $fObject;     // объект класса SplFileObject
    private string $dumpDB;         // путь к sql-файлу базы данных


    public function __construct(string $filename, string $sqlTableName, string $dumpDB)
    {
        $this->filename = $filename;
        $this->sqlTableName = $sqlTableName;
        $this->dumpDB = $dumpDB;
    }
    /**
     * Функция для проверки существования файла и возможности его открыть для чтения
     * @param string $filePath
     * @return void
     * @throws FileExistException
     * @throws FileOpenException
     */
    private function validCSV(string $fObject): void
    {
       $this->fObject = new SplFileObject($this->filename, $this->sqlTableName, $this->dumpDB);

       if (!file_exists($this->filename)) {
            throw new FileExistException('Файл не найден в данной директории'); // exception needs try-catch in test
        }
        $this->fObject = new SplFileObject($this->filename, $this->sqlTableName, $this->dumpDB);

        $this->fp = fopen($this->filename, "rb");

        if (!$this->fp) {
            throw new FileOpenException('Не удалось открыть файл для чтения'); // exception needs try-catch in test
        }
    }

    /**
     * получает имена столбцов
     * @param string $filename
     * @return string $columns
     */
    public function getHeadersCSV(string $filename) : string
    {
        $this->fObject = new SplFileObject($this->filename, $this->sqlTableName, $this->dumpDB);

        $this->fObject->rewind();
        $this->columns = implode('`, `', $this->fObject->fgetcsv());

        return $this->columns;
    }

    /**
     * получает массив данных из файла *.csv для заполнения строк в sql-таблице
     * @param string $filename
     * @return array $values
     */
    public function getCSVData(string $filename) : array
    {
        $this->fObject = new SplFileObject($this->filename, $this->sqlTableName, $this->dumpDB);

        $result = [];

        while (!$this->fObject->eof()) {
            $result[] = implode("', '", $this->fObject->fgetcsv());
        }
        $values = array_filter($result);
        unset($values[0]);
        return $values;
    }

    /**
    * готовит sql-запросы на добавление данных из файла *.csv в sql-таблицу
    * @param string $filename
    * @param string $sqlTableName
    * @return string
    */
    public function createSQLQuery(string $filename, string $sqlTableName) : string
    {
        $sqlLine = [];

        foreach ($this->getCSVData($filename) as $values)
        {
           $sqlLine[] = "INSERT INTO `" . $this->sqlTableName . "` (`" . $this->columns . "`)"."\r\n"."VALUES ('" . $values . "');". "\r\n";
        }

       return implode($sqlLine);
    }

    /**
     * записывает sql-запросы на добавление данных в файл базы данных
     * @param string $dumpDB
     * @param string $sqlTableName
     * @return
     */

  /*  public function writeQuery(string $dumpDB, string $sqlTableName)
    {
        file_put_contents($this->dumpDB, $this->createSQLQuery($this->dumpDB, $this->sqlTableName), FILE_APPEND);
    }*/
}



