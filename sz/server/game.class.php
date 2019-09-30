<?php
class Game {
    
    public function __construct(){
        
	}
    
    public static function newgame() {
        $tem = array();
        for ($i = 0 ; $i < 10; $i ++) {
            array_push($tem, mt_rand(1, 6));
        }
        
        return $tem;
    }
    
    public static function compare($l, $f) {
        $l[1] = $l[1] == 1 ? 7 : $l[1];
        $f[1] = $f[1] == 1 ? 7 : $f[1];
        $r = FALSE;
        if ($l[0] > $f[0]) {
            $r = $l[2] == $f[2] ? TRUE : FALSE;
            if ($f[2] == FALSE && $l[2] == TRUE) {
                $r = TRUE;
            }
            if ($f[2] == TRUE && $l[2] == FALSE && $l[0] >= $f[0]*2) {
                $r = TRUE;
            }
        }
        if ($l[0] == $f[0]) {
            if ($l[1] == $f[1]) {
                $r = $f[2] == FALSE && $l[2] == TRUE ? TRUE : FALSE;
            }else if ($l[1] > $f[1]) {
                if ($f[2] == $l[2] || ($f[2] == FALSE && $l[2] == TRUE)) {
                    $r = TRUE;
                }
            }
        }
        
        return $r;
    }
    
    public static function ifture($a, $b, $mode = FALSE) {
        
        $arr = array_count_values($b);
        
        if ($mode || $a[1] == 1) {
            $x = empty($arr[$a[1]]) ? 0 : $arr[$a[1]];
            $r = $x >= $a[0] ? TRUE : FALSE;
        }else {
            $x = empty($arr[$a[1]]) ? 0 : $arr[$a[1]];
            $y = empty($arr[1]) ? 0 : $arr[1];
            $r = $x + $y >= $a[0] ? TRUE : FALSE;
        }
        
        return $r;
    }
}