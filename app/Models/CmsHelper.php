<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Roles;
use Cache;

class CmsHelper
{
  function __construct()
  {
    //echo 'test';
  }

  //=====================================================
  //หมวด วัน เวลา
  //=====================================================
  //ใช้แล้วของมูลวันที่ เช่น 2021-01-11 08:04:01 เป็นวันที่ภาษาไทย
  //ตัวอย่างการใช้งาน DateThai($strDate) จะแสดงเป็น 11 มกราคม 2564
  public static function DateThai($strDate, $type = "d-M-Y")
  {
    if ($strDate == '0000-00-00' || $strDate == '' || $strDate == null) return '-';
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strWeek = date("w", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthWeek = array("", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์", "อาทิตย์");
    $strMonthNick = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthFull = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

    //d-M-Y       11 มกราคม 2564
    //d-m-Y       11 ม.ค. 2564
    //w-d-M-Y     ประจำวันจันทร์ที่ 11 มกราคม 2564
    //M-Y         มกราคม 2564
    //d-m-Y H:i   11 ม.ค. 2564 เวลา 14:30
    //H:i:s       14:30:12
    //H.i         14.30 น.

    if ($type == 'd-M-Y') {
      $strMonthThai = $strMonthFull[$strMonth];
      return "$strDay $strMonthThai $strYear";
    } else if ($type == 'd-m-Y') {
      $strMonthThai = $strMonthNick[$strMonth];
      return "$strDay $strMonthThai $strYear";
    } else if ($type == 'w-d-M-Y') {
      $strWeekThai = $strMonthWeek[$strWeek];
      $strMonthThai = $strMonthFull[$strMonth];
      return "ประจำวัน" . $strWeekThai . "ที่ " . $strDay . " " . $strMonthThai . " " . $strYear;
    } else if ($type == 'M-Y') {
      $strMonthThai = $strMonthFull[$strMonth];
      return "$strMonthThai $strYear";
    } else if ($type == 'd-m-Y H:i') {
      $strMonthThai = $strMonthNick[$strMonth];
      return "$strDay $strMonthThai $strYear เวลา $strHour:$strMinute";
    } else if ($type == 'H:i:s') {
      return $strHour . ":" . $strMinute . ":" . $strSeconds;
    } else if ($type == 'H.i') {
      return intval($strHour) . "." . intval($strMinute) . " น.";
    }
  }

  public static function DateThai2($strDate)
  {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
  }


  public static function DateEnglish($strDate)
  {
    if ($strDate == '0000-00-00' || $strDate == '' || $strDate == null) return '-';
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
  }

  public static function TimeThai($strTime)
  {
    if ($strTime == '00:00:00' || $strTime == '' || $strTime == null) return '-';
    $strHour = date("H", strtotime($strTime));
    $strMinute = date("i", strtotime($strTime));
    $strSeconds = date("s", strtotime($strTime));
    return $strHour . ":" . $strMinute . ":" . $strSeconds;
  }

  public static function MonthThai($strDate)
  {
    if ($strDate == '0000-00-00' || $strDate == '' || $strDate == null) return '-';
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strMonthThai $strYear";
  }

  public static function formatDateThai($strDate)
  {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear เวลา $strHour:$strMinute";
  }

  //=====================================================
  //หมวด แปลงค่า
  //====================================================
  public static function Numth($younum)
  {
    //เปลี่ยนเป็นเลขไทย
    $temp = str_replace("0", "๐", $younum);
    $temp = str_replace("1", "๑", $temp);
    $temp = str_replace("2", "๒", $temp);
    $temp = str_replace("3", "๓", $temp);
    $temp = str_replace("4", "๔", $temp);
    $temp = str_replace("5", "๕", $temp);
    $temp = str_replace("6", "๖", $temp);
    $temp = str_replace("7", "๗", $temp);
    $temp = str_replace("8", "๘", $temp);
    $temp = str_replace("9", "๙", $temp);
    return $temp;
  }

  public static function generateRandomString($length = 10)
  {
    //สุ่มข้อความ
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return trim($randomString);
  }

  public static function TextFormat($text = '', $pattern = '', $ex = '')
  {
    $cid = ($text == '') ? '0000000000000' : $text;
    $pattern = ($pattern == '') ? '_-____-_____-__-_' : $pattern;
    $p = explode('-', $pattern);
    $ex = ($ex == '') ? '-' : $ex;
    $first = 0;
    $last = 0;
    for ($i = 0; $i <= count($p) - 1; $i++) {
      $first = $first + $last;
      $last = strlen($p[$i]);
      $returnText[$i] = substr($cid, $first, $last);
    }
    return implode($ex, $returnText);
  }
}
