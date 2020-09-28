<?php


namespace Lma;


class CreateCsv implements CreateCsvInterface
{
    const FILE_OUTPUT_PATH =  __DIR__ . '/../output/pay.csv';
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
        $file = fopen($this->file,'wb+');
        fputcsv($file, self::HEADER_CSV,';');
        foreach ($this->calendar->pay as $item) {
            fputcsv($file, $item,';');
        }
        fclose($file);
    }
}