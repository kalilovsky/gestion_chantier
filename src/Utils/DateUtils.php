<?php
namespace App\Utils;

use DateTimeInterface;

class DateUtils{
    public static function getDateOfWeek(DateTimeInterface $date){
        $firstDayOfTheWeek = clone $date;
        $firstDayOfTheWeek->modify('last sunday +1 day')->format('Y-m-d');
        $lastDayOfTheWeek = clone $firstDayOfTheWeek;
        $lastDayOfTheWeek->modify('next sunday')->format('Y-m-d');
        return [
            'firstDayOfTheWeek'=> $firstDayOfTheWeek,
            'lastDayOfTheWeek' => $lastDayOfTheWeek];
    }
}
