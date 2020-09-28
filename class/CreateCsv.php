<?php


namespace Lma;


class CreateCsv implements CreateCsvInterface
{
    const DIR_NAME =  __DIR__ . '/../output/';
    const FILE_OUTPUT_PATH =  self::DIR_NAME . 'pay.csv';
    const HEADER_CSV = ['Miesiąc','Data wypłaty','Data premii'];
    /**
     * @var string
     */
    private string $file;
    /**
     * @var Calendar
     */
    private Calendar $calendar;

    /**
     * CreateCsv constructor.
     * @param Calendar $calendar
     */
    public function __construct(Calendar $calendar)
    {
        $this->file = self::FILE_OUTPUT_PATH;
        $this->calendar = $calendar;
    }


    public function create()
    {
        $this->crateDir();
        $file = fopen($this->file,'wb+');
        fputcsv($file, self::HEADER_CSV,';');
        foreach ($this->calendar->pay as $item) {
            fputcsv($file, $item,';');
        }
        fclose($file);
    }

    private function crateDir()
    {
        if (!file_exists(self::DIR_NAME)) {
            mkdir(self::DIR_NAME, 0777, true);
        }
    }
}