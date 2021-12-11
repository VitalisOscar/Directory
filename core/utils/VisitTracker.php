<?php

use Carbon\Carbon;

class VisitTracker{
    static function track(){
        $user = SessionManager::getUser();

        $user_id = 0;

        if($user != null){
            $user_id = $user->getId();
        }

        $device_id = self::getDeviceId();
        $page = currentPage();
        $params = json_encode(getUrlParams());
        $ip = getIpAddress();

        $sql = "INSERT INTO `visits`(`user_id`,`device_id`,`ip_address`,`page`,`params`)
            VALUES($user_id, '$device_id', '$ip', '$page', '$params')";

        db()->query($sql);
    }

    static function getVisitStats(){
        $sql = "SELECT date(`visited_at`) AS `day`, count(*) AS `visits` FROM `visits` GROUP BY date(`visited_at`)";
        $result = db()->query($sql);

        $from = Carbon::today()->subDays(30);
        $to = Carbon::today();

        $missing = [];

        for(;$from->isBefore($to); $from->addDay()){
            $missing[$from->dayOfYear] = substr($from->monthName, 0, 3).' '.$from->day;
        }
        
        $stats = [];

        while($row = $result->fetch_assoc()){
            $day = Carbon::createFromFormat('Y-m-d', $row['day']);
            $row['day'] = substr($day->monthName, 0, 3).' '.$day->day;
            $stats[$day->dayOfYear] = $row;
            unset($missing[$day->dayOfYear]);
        }

        foreach ($missing as $key => $val){
            $stats[$key] = ['visits' => 0, 'day' => $val];
        }

        ksort($stats);

        return $stats;
    }

    static function getPageStats(){
        $sql = "SELECT `page`, count(*) AS `views` FROM `visits` GROUP BY `page`";
        $result = db()->query($sql);
        
        $stats = [];

        while($row = $result->fetch_assoc()){
            $color = self::getColor();
            $row['color'] = $color;
            array_push($stats, $row);
        }

        return $stats;
    }

    static function getColor(){
        $from = "0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F";
        $from = explode(",", $from);

        $color = '#';
        for($i=0; $i<6; $i++){
            $color .= $from[rand(0, (count($from)-1))];
        }

        return $color;
    }

    static function getDeviceId(){
        $device_id = $_COOKIE['device_id'] ?? null;

        if($device_id == null){
            $device_id = md5(uniqid().rand(1000, 100000));
            setcookie('device_id', $device_id, (time() + 365 * 24 * 3600), '/');
        }

        return $device_id;
    }
}
