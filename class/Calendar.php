<?php


namespace Lma;


class Calendar extends Iterator
{
    const CURRENT_YEAR = '2020';
    const TIME_MODIFY_ADD_14_DAY = '+14 day';
    const TIME_MODIFY_MINUS_1_DAY = '-1 day';
    const TIME_MODIFY_MINUS_2_DAY = '-2 day';
    const TIME_MODIFY_FIRST_WEDNESDAY = 'next wednesday';
    const TIME_DATE_DEFAULT_FORMAT = 'd.m.Y';
    const WEK_DAY = ['Sat', 'Sun'];

    /**
     * @var \DateTime;
     */
    private \DateTime $date;

    /**
     * Calendar constructor.
     * @param \DateTime $date
     */
    public function __construct()
    {
        parent::__construct();
        $this->date = new \DateTime();
    }


    public function init(): void
    {
        for($i = 1; $i<= 12; $i++){
           $this->setData($i);
           $this->getPayments();
           $this->setData($i);
           $this->getBonus();
           $this->next();
        }
    }

    /**
     * @param $month
     * @param int $day
     * @return \DateTime
     */
    private function setData(int $month, int $day = 1) :\DateTime
    {
        return $this->date->setDate(self::CURRENT_YEAR ,$month,$day);
    }

    private function getBonus()
    {
        $this->date->modify(self::TIME_MODIFY_ADD_14_DAY);

        $dayName = $this->date->format('D');

        $this->pay[$this->key()]['bonus'] = $this->date->format(self::TIME_DATE_DEFAULT_FORMAT);

        if('Sat' === $dayName || 'Sun' === $dayName)
        {
            $this->pay[$this->key()]['bonus'] =
                $this->date->modify(self::TIME_MODIFY_FIRST_WEDNESDAY)->format(self::TIME_DATE_DEFAULT_FORMAT);
        }
    }

    private function getPayments()
    {
        $day = (int) $this->date->format('t');
        $month = (int) $this->date->format('m');
        $this->setData($month, $day);
        $dayName = $this->date->format('D');

        $this->pay[$this->key()]['moth'] = $this->date->format('M');
        if($this->isWeekend($dayName))
        {
            $this->pay[$this->key()]['pay'] = $this->date->format(self::TIME_DATE_DEFAULT_FORMAT);
        }else{
            $this->pay[$this->key()]['pay'] = $this->getFriday($dayName)->format(self::TIME_DATE_DEFAULT_FORMAT);
        }
     }

    /**
     * @param string $day
     * @return bool
     */
    private function isWeekend(string $day) : bool
    {
        if(in_array($day,self::WEK_DAY)){
            return false;
        }
        return true;
    }

    /**
     * @param string $day
     * @return \DateTime
     */
    private function getFriday(string $day) :?\DateTime
    {
        if($day === self::WEK_DAY[0]){
            return $this->date->modify(self::TIME_MODIFY_MINUS_1_DAY);
        }
        if($day === self::WEK_DAY[1]){
            return $this->date->modify(self::TIME_MODIFY_MINUS_2_DAY);
        }
        return null;
    }
}