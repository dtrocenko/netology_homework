<?php

declare(strict_types=1);

echo'Введите номер года, с которого нужно начать расчёт: ' ;
$year = (int)trim(fgets(STDIN));

echo'Введите номер месяца, с которого нужно начать расчёт: ' ;
$month = (int)trim(fgets(STDIN));

if ($month < 1 || $month > 12) {
     echo 'Ошибка! Введен некорректный номер месяца.';
     exit;
}
function calendarWorkingDays(int $month, int $year): void
{
    $countDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $resultList = []; 
    $day = "." . $month . "." . $year; 
  
    for ($i = 1; $i <= $countDaysInMonth; $i++) {                      
        $resultList[$i.$day] = date('l', mktime(0, 0, 0, $month, $i, $year));
        $calculationMonth = date('F', mktime(0, 0, 0, $month, $i, $year));
    };

    for ($i = 1; $i <= $countDaysInMonth; $i++) {       
        if ($resultList[$i.$day] == 'Saturday') {
            $resultList[$i.$day] = $resultList[$i.$day];
        } elseif ($resultList[$i.$day] == 'Sunday') {
            $resultList[$i.$day] = $resultList[$i.$day];      
        } else {
            $resultList[$i.$day] = "\033[32m{$resultList[$i.$day]} - рабочий день \033[0m";
            $i += 2;
        }
    }
    
    echo PHP_EOL . 'Расчётный месяц: ' . $calculationMonth . PHP_EOL;
    print_r($resultList);    
}

calendarWorkingDays($month, $year);