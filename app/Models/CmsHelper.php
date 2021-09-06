<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Roles;

use App\Models\Province;
use App\Models\User;
use App\Models\UploadFile;
use App\Models\UploadImg;
use App\Models\Relate;
use App\Models\Organize;

class CmsHelper
{
  function __construct()
  {
    //echo 'test';
  }

  //=====================================================================================================

  //หมวด วัน เวลา

  //=====================================================================================================

  //ใช้แล้วของมูลวันที่ เช่น 2021-01-11 08:04:01 เป็นวันที่ภาษาไทย
  //ตัวอย่างการใช้งาน DateThai($strDate) จะแสดงเป็น 11 มกราคม 2564

  public static function DateThai($strDate)
  {
    if ($strDate == '0000-00-00' || $strDate == '' || $strDate == null) return '-';

    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthCut2 = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    $strMonthThai2 = $strMonthCut2[$strMonth];
    // return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
    return array(
      "dmY" => $strDay . ' ' . $strMonthThai . ' ' . $strYear,
      "dMY" => $strDay . ' ' . $strMonthThai2 . ' ' . $strYear,
      "dmYHi" => $strDay . ' ' . $strMonthThai . ' ' . $strYear . ' เวลา ' . $strHour . ':' . $strMinute,
      "dMYHi" => $strDay . ' ' . $strMonthThai2 . ' ' . $strYear . ' เวลา ' . $strHour . ':' . $strMinute,
    );
  }

  //แปลง d M Y ไทยเป็น Y-m-d
  public static function DateThai2Eng($strDate)
  {
    if (empty($strDate)) return false;
    
    $array = [
      'มกราคม'   => '01',
      'กุมภาพันธ์'  => '02',
      'มีนาคม'    => '03',
      'เมษายน'    => '04',
      'พฤษภาคม'  => '05',
      'มิถุนายน'    => '06',
      'กรกฎาคม'   => '07',
      'สิงหาคม'    => '08',
      'กันยายน'    => '09',
      'ตุลาคม'     => '10',
      'พฤศจิกายน'  => '11',
      'ธันวาคม'    => '12'
    ];
    $bc_year = explode(" ", $strDate);
    $day = $bc_year['0'];
    $month = $array[$bc_year['1']];
    $year = $bc_year['2'] - 543;
    return $year . '-' . $month . '-' . $day;
  }

  //=====================================================================================================

  //หมวด แปลงค่า

  //=====================================================================================================

  //เปลี่ยนเป็นเลขไทย
  public static function Numth($younum)
  {
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

  //สุ่มข้อความ
  public static function generateRandomString($length = 10)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return trim($randomString);
  }

  // Phone format : cms::TextFormat($value,'__-____-____')
  // IDCard format : cms::TextFormat($value)
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

  //=====================================================================================================

  // หมวด แปลงค่า จาก Database

  //=====================================================================================================


  // ชื่อผู้ใช้งาน : วิธีใช้ cms::GetUser(รหัส)['name']
  public static function GetUser($id)
  {
    $query = User::findOrFail($id);
    return array(
      "name" => $query->name
    );
  }
  
  // ชื่อหน่วยงาน : วิธีใช้ cms::GetOrg(รหัสหน่วยงาน)
  public static function GetOrg($id)
  {
    $query = Organize::findOrFail($id);
    return $query->org_name;
  }


  // ชื่อจังหวัด : วิธีใช้ cms::GetProvince(รหัส)
  public static function GetProvince($code)
  {
    $query = Province::where('province_code', $code)->first();
    return $query->province;
  }

  // ชื่ออำเภอ : วิธีใช้ cms::GetAmphoe(รหัส)
  public static function GetAmphoe($code)
  {
    $query = Province::where('amphoe_code', $code)->first();
    return $query->amphoe;
  }

  // ชื่อตำบล : วิธีใช้ cms::GetTumbon(รหัส)
  public static function GetTumbon($code)
  {
    $query = Province::where('district_code', $code)->first();
    return $query->district;
  }


  //=====================================================================================================

  // หมวด นับจำนวน จาก Database

  //=====================================================================================================

  // วิธีใช้งาน : cms::CountFile()
  public static function CountFile()
  {
    $count = UploadFile::count();
    return $count;
  }

  // วิธีใช้งาน : cms::CountFile()
  public static function CountImg()
  {
    $count = UploadImg::count();
    return $count;
  }

  // วิธีใช้งาน : cms::CountRelate()
  public static function CountRelate()
  {
    $count = Relate::count();
    return $count;
  }
}
