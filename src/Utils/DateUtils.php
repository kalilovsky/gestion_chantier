<?php
namespace App\Utils;

use DateInterval;
use DateTime;
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

    public static function setStartDate(String $date, String $startTime){
        return new DateTime($date . ' ' . $startTime);
    }
    /**
     * Undocumented function
     *
     * @param String $startTime
     * @param String $endTime
     * @return DateInterval|String
     */
    public static function createDateIntervall(String $startTime, String $endTime){
        $start = new DateTime($startTime);
        $end = new DateTime($endTime);
        if($end <= $start){
            return 'Heure de fin inférieur à l\'heure de début !';
        }
        return $start->diff($end);
    }

    public static function sumDateIntervallFromArray($array, int &$minutes, int &$hours){
        foreach($array as $pointage){
            $minutes += $pointage->getDuree()->i;
            if($minutes>=60){
                $minutes -= 60;
                $hours++;
            }
            $hours += $pointage->getDuree()->h;
        }
    }
    
}
