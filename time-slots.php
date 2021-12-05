<?php
/**
 * Split time slots from given start and end time and interval.
 * Credit: https://codebriefly.com/create-time-slots-in-php-for-given-time/
 * 
 * @param int $interval
 * @param string $start_time
 * @param string $end_time
 * @return array
 */
function getTimeSlot($interval, $start_time, $end_time)
{
    $start = new DateTime($start_time);
    $end = new DateTime($end_time);
    $startTime = $start->format('H:i');
    $endTime = $end->format('H:i');
    $i=0;
    $time = [];
    while(strtotime($startTime) <= strtotime($endTime)){
        $start = $startTime;
        $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
        $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
        $i++;
        if(strtotime($startTime) <= strtotime($endTime)){
            $time[$i]['slot_start_time'] = $start;
            $time[$i]['slot_end_time'] = $end;
        }
    }
    return $time;
}

/**
 * Get todays time slots with passing date time in PHP
 * Create time slots by passing start and end time with php. method accepts three parameters startTime, endTime and duration. slots are created from start to end time by breaking with duration .like you need to break time slots with 15 minutes then set duration will be set as 15.
 * @credit: https://codebaker.in/create-time-slots-passing-date-time-php/
 *
 * @param  int $duration
 * @param  string $start
 * @param  string $end
 * @return array
 */
function getTodaysTimeSlots($duration, $start, $end)
{
        $time = array();
        $start = new \DateTime($start);
        $end = new \DateTime($end);
        $start_time = $start->format('H:i');
        $end_time = $end->format('H:i');
        $currentTime = strtotime(Date('Y-m-d H:i'));
        $i=0;

        while(strtotime($start_time) <= strtotime($end_time)){
            $start = $start_time;
            $end = date('H:i',strtotime('+'.$duration.' minutes',strtotime($start_time)));
            $start_time = date('H:i',strtotime('+'.$duration.' minutes',strtotime($start_time)));
            
            $today = Date('Y-m-d');
            $slotTime = strtotime($today.' '.$start);

            if($slotTime > $currentTime){
                if(strtotime($start_time) <= strtotime($end_time)){
                    $time[$i]['start'] = $start;
                    $time[$i]['end'] = $end;
                }
                $i++;
            }

        }
        return $time;
}
