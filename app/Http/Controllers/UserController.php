<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Models\Province;
use App\Models\User;
use App\Models\UploadFile;
use App\Models\UploadImg;
use App\Models\Relate;
use App\Models\Organize;
use App\Models\Survey;
use App\Models\SurveyImg;
use App\Models\CmsHelper as cms;

use Image;
use Carbon\Carbon;

class UserController extends Controller
{
    // ประกาศใช้ Auth
    public function __construct()
    {
        $this->middleware('auth');
    }

    // หน้าแรก -----------------------------------------------------------------------------------
    public function home2()
    {
        return view('home2');
    }

    // จังหวัด (CRUD) -----------------------------------------------------------------------------------
    public function table()
    {
        $data = Province::orderBy('id', 'DESC')->limit(10)->get();
        return view('table', [
            'data' => $data
        ]);
    }
    public function table_insert(Request $request)
    {
        // dd($request);
        $insert = new Province;
        $insert->province = $request->province;
        $insert->amphoe = $request->amphoe;
        $insert->district = $request->district;
        $insert->zipcode = $request->zipcode;

        if ($insert->save()) {
            return back()->with('Success', 'เพิ่มข้อมูลสำเร็จ');
        } else {
            return back()->with('Error', 'เพิ่มข้อมูลไม่สำเร็จ');
        }
    }
    public function table_edit(Request $request)
    {
        $edit = Province::where('id', $request->id)->first();
        return view('table_edit', [
            'edit' => $edit
        ]);
    }
    public function table_update(Request $request)
    {
        // dd($request);
        $update = Province::find($request->id);
        $update->province = $request->province;
        $update->amphoe = $request->amphoe;
        $update->district = $request->district;
        $update->zipcode = $request->zipcode;

        if ($update->save()) {
            return redirect()->route('table')->with('Success', 'แก้ไขข้อมูลสำเร็จ');
        } else {
            return back()->with('Error', 'ไม่สามารถแก้ไขได้');
        }
    }
    public function table_delete(Request $request)
    {
        $delete = Province::where('id', $request->id)->delete();

        if ($delete) {
            return redirect()->route('table')->with('Success', 'ลบข้อมูลสำเร็จ');
        } else {
            return back()->with('Error', 'ไม่สามารถลบข้อมูลได้');
        }
    }


    // Dashboard -----------------------------------------------------------------------------------
    public function dashboard()
    {
        // กำหนด array ทดสอบ
        $dataPoints = array(
            array("y" => 25, "label" => "Sunday"),
            array("y" => 15, "label" => "Monday"),
            array("y" => 25, "label" => "Tuesday"),
            array("y" => 5, "label" => "Wednesday"),
            array("y" => 10, "label" => "Thursday"),
            array("y" => 0, "label" => "Friday"),
            array("y" => 20, "label" => "Saturday")
        );

        // Province + Cache ------------------------------------------------------------------------------------
        $datas1 = Cache::remember('datas1', '60', function () {
            return  DB::table('today-cases-line-lists')
                ->selectRaw('count(txn_date) as totals,province')
                ->GroupBy('province')->Orderby('totals', 'desc')
                ->limit(10)
                ->get();
        });
        foreach ($datas1 as $data1) {
            $dataPoints1[] = array("y" => $data1->totals, "label" => $data1->province);
        }

        // Gender + Cache ------------------------------------------------------------------------------------
        $datas2 = Cache::remember('datas2', '60', function () {
            return  DB::table('today-cases-line-lists')
                ->selectRaw('count(txn_date) as totals,gender')
                ->GroupBy('gender')
                ->get();
        });
        foreach ($datas2 as $data2) {
            $dataPoints2[] = array("y" => $data2->totals, "label" => $data2->gender);
        }

        // Risk + Cache ------------------------------------------------------------------------------------
        $datas3 = Cache::remember('datas3', '60', function () {
            return  DB::table('today-cases-line-lists')
                ->selectRaw('count(txn_date) as totals,risk')
                ->GroupBy('risk')->orderByDesc('totals')
                ->limit(5)
                ->get();
        });
        foreach ($datas3 as $data3) {
            $dataPoints3[] = array("y" => $data3->totals, "label" => $data3->risk);
        }

        // API + Cache ------------------------------------------------------------------------------------
        $datas4 = Cache::remember('datas4', '60', function () {
            $response = Http::get('https://covid19.ddc.moph.go.th/api/Usage-Stats-Count');
            return  json_decode($response->body());
        });
        foreach ($datas4 as $data4) {
            $dataPoints4[] = array("y" => $data4->totals, "label" => $data4->date_req);
        }

        //dd($dataPoints4);

        $count1 = User::count();
        $count2 = Province::count();
        $count3 = DB::table('cars')->count();
        $count4 = DB::table('customers')->count();

        // dd($count2);

        return view('dashboard', [
            "dataPoints1" => $dataPoints1,
            "dataPoints2" => $dataPoints2,
            "dataPoints3" => $dataPoints3,
            "dataPoints4" => $dataPoints4,
            "count1" => $count1,
            "count2" => $count2,
            "count3" => $count3,
            "count4" => $count4,
        ]);
    }


    // Upload File -----------------------------------------------------------------------------------
    public function form_upload()
    {
        $file = UploadFile::all();
        return view('form_upload', [
            "file" => $file
        ]);
    }
    public function form_upload_insert(Request $request)
    {
        //ตรวจสอบเงื่อนไข
        $request->validate([
            'name' => 'required',
            'file' => 'mimes:doc,docx,xls,xlsx,pdf|max:2048'
        ]);

        //Rename =======================================================================================
        $rename = carbon::now()->year + 543 . date('mdHis') . rand('111', '999');

        //Stroage =======================================================================================
        $filename = $rename  . '.' . $request->file->getClientOriginalExtension();
        $storage_path = $request->file('file')->storeAs('files', $filename); // Storage 
        $public_path = $request->file->move(public_path('uploads/files/'), $filename); // Public

        //Insert =======================================================================================
        $file_type = $request->file->getClientOriginalExtension();
        $file_size = File::size($public_path);

        // dd($file_size);

        $insert = new UploadFile;
        $insert->file_name = $request->name;
        $insert->file_path1 = $filename;
        $insert->file_path2 = $storage_path;
        $insert->file_type = $file_type;

        if ($insert->save()) {
            return back()->with('Success', 'อัพโหลดไฟล์สำเร็จ');
        } else {
            return back()->withInput()->with('Error', 'อัพโหลดไฟล์ไม่สำเร้จ');
        }
    }
    public function form_upload_download(Request $request)
    {
        $download = UploadFile::find($request->id);
        return Storage::download($download->file_path2);
    }
    public function form_upload_delete(Request $request)
    {
        $delete = UploadFile::where('id', $request->id)->delete();
        File::delete('uploads/files/' . $request->path1);
        Storage::delete($request->path2);

        if ($delete) {
            return back()->with('Success', 'ลบไฟล์สำเร็จ');
        } else {
            return back()->withInput()->with('Error', 'ลบไฟล์ไม่สำเร้จ');
        }
    }

    public function form_upload_truncate()
    {
        File::cleanDirectory('uploads/files/');
        Storage::delete(Storage::allFiles('files/'));
        UploadFile::truncate();
        return back()->with('Success', 'ข้อมูล/ไฟล์ ทั้งหมดถูกล้าง');
    }

    // Upload Image -----------------------------------------------------------------------------------
    public function form_image()
    {
        $file = UploadImg::all();
        return view('form_image', [
            'file' => $file
        ]);
    }
    public function form_image_insert(Request $request)
    {
        // ตรวจสอบเงื่อนไข
        $request->validate([
            'name' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ตรวจสอบว่ามี folder หรือไม่ หากไม่มีให้สร้าง
        $folder_image = "uploads/images/";
        $folder_thumbnail = "uploads/images/thumbnail/";
        $folder_resize = "uploads/images/resize/";

        if (!File::exists($folder_image)) {
            File::makeDirectory($folder_image, 0755, true, true);
        }
        if (!File::exists($folder_thumbnail)) {
            File::makeDirectory($folder_thumbnail, 0755, true, true);
        }
        if (!File::exists($folder_resize)) {
            File::makeDirectory($folder_resize, 0755, true, true);
        }

        // Rename =======================================================================================
        $rename = carbon::now()->year + 543 . date('mdHis') . rand('111', '999');

        // Upload Storage & Public  ====================================================================
        $img_name = $rename  . '.' . $request->file->getClientOriginalExtension();
        $storage_path = $request->file('file')->storeAs('images', $img_name); // Storage 
        $public_path = $request->file->move(public_path($folder_image), $img_name); // Public

        // Thumbnail =======================================================================================
        Image::make($public_path)->fit(100, 100)->save(public_path($folder_thumbnail . $img_name));

        // Resize =======================================================================================
        Image::make($public_path)->resize(1280, null, function ($constraint) {
            $constraint->aspectRatio();
        })
            ->save(public_path($folder_resize . $img_name));

        //Insert =======================================================================================
        $insert = new UploadImg;
        $insert->img_name = $request->name;
        $insert->img_path1 = $img_name;
        $insert->img_path2 = $storage_path;

        if ($insert->save()) {
            return back()->with('Success', 'อัพโหลดไฟล์ สำเร็จ');
        } else {
            return back()->withInput()->with('Error', 'อัพโหลดไฟล์ไม่สำเร็จ');
        }
    }
    public function form_image_download(Request $request)
    {
        // dd($request);
        $download = UploadImg::find($request->id);
        return Storage::download($download->img_path2);
    }
    public function form_image_delete(Request $request)
    {
        // dd($request);
        $delete = UploadImg::where('id', $request->id)->delete();
        //delete public
        File::delete('uploads/images/' . $request->path1);
        File::delete('uploads/images/resize/' . $request->path1);
        File::delete('uploads/images/thumbnail/' . $request->path1);
        //delete storate
        Storage::delete($request->path2);

        if ($delete) {
            return back()->with('Success', 'ลบไฟล์สำเร็จ');
        } else {
            return back()->withInput()->with('Error', 'ลบไฟล์ไม่สำเร้จ');
        }
    }

    // Relate Province -----------------------------------------------------S------------------------------
    public function form_relate()
    {
        $Relate = Relate::all();
        $Organize = Organize::all();
        $Users = User::all();

        foreach ($Users as $val) {
            $User[] =  $val->name;
        }
        // dd($User);

        return view('form_relate', [
            'Relate' => $Relate,
            'Organize' => $Organize,
            'User' => $User
        ]);
    }
    public function form_relate_insert(Request $request)
    {
        $insert = new Relate;
        $insert->name = $request->name;
        $insert->organize = $request->organize;
        $insert->province = $request->province;
        $insert->amphoe = $request->amphoe;
        $insert->tumbon = $request->tumbon;
        $insert->zipcode = $request->zipcode;

        if ($insert->save()) {
            return back()->with('Success', 'บันทึกสำเร็จ');
        } else {
            return back()->withInput()->with('Error', 'บันทึกไม่สำเร็จ');
        }
    }


    // Profile -----------------------------------------------------S------------------------------
    public function profile()
    {
        $Profile = User::where('id', auth::user()->id)->first();

        return view('profile', [
            'Profile' => $Profile
        ]);
    }
    public function profile_update(Request $request)
    {
        // dd($request);
        $update = User::find(auth::user()->id);
        $update->name = $request->name;
        $update->class = $request->class;
        $update->save();

        if ($update->save()) {
            return back()->with('Success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
        } else {
            return back()->withInput()->with('Error', 'ไม่สามารถแก้ไขข้อมูลได้');
        }
    }
    public function crop(Request $request)
    {
        $path = 'uploads/avatar/';
        File::delete($path . auth::user()->avatar);
        // File::cleanDirectory($path);

        $file = $request->file('file');

        $new_image_name = 'User' . auth::user()->id . '.jpg';
        $upload = $file->move(public_path($path), $new_image_name);

        $update = User::find(auth::user()->id);
        $update->avatar = $new_image_name;
        $update->save();

        if ($upload) {
            return response()->json(['status' => 1, 'msg' => 'Image has been cropped successfully.', 'name' => $new_image_name]);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong, try again later']);
        }
    }
    public function change_password(Request $request)
    {
        // dd($request->Password, Hash::make($request->Password));

        $update = User::find(auth::user()->id);
        $update->password = Hash::make($request->Password);

        if ($update->save()) {
            return back()->with('Success', 'แก้ไขรหัสผ่านสำเร็จ');
        } else {
            return back()->with('Error', 'เปลี่ยนรหัสผ่านไม่สำเร็จ');
        }
    }


    // Contact Us -----------------------------------------------------S------------------------------
    public function contact()
    {
        return view('contact');
    }

    // ================================================================================================
    // Work Shop
    // ================================================================================================

    // form 
    public function workshop_form(Request $request)
    {
        return view('workshop_form');
    }
    public function workshop_form_insert(Request $request)
    {
        $insert = new Survey();
        $insert->date = cms::DateThai2Eng($request->date);
        $insert->store_name = $request->store_name;
        $insert->store_no = $request->store_no;
        $insert->store_moo = $request->store_moo;
        $insert->store_soi = $request->store_soi;
        $insert->store_road = $request->store_road;
        $insert->province = $request->province;
        $insert->amphoe = $request->amphoe;
        $insert->tumbon = $request->tumbon;
        $insert->zipcode = $request->zipcode;
        $insert->tel = $request->tel;
        $insert->summernote = $request->summernote;
        $insert->save();

        if ($request->hasFile('image')) {

            $images = $request->file('image');

            foreach ($images as $image) {
                $rename = Carbon::now()->year + 543 . '_' . date('mdHis') . '_' . rand(111, 999) . '.' . $image->extension();
                $path = $image->move(public_path('uploads/survey/'), $rename);

                $width = Image::make($path)->width();
                $height = Image::make($path)->height();

                if ($width > $height) {
                    Image::make($path)->resize(1028, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('uploads/survey/' . $rename));
                } else {
                    Image::make($path)->resize(null, 720, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('uploads/survey/' . $rename));
                }

                $SurveyImg = new SurveyImg();
                $SurveyImg->img_name = $rename;
                $SurveyImg->survey_id = $insert->id;
                $SurveyImg->user_id = auth::user()->id;
                $SurveyImg->save();
            }
        }

        if ($insert->save()) {
            return redirect()->route('workshop.list')->with('Success', 'บันทึกสำเร็จ');
        } else {
            return back()->withInput()->with('Error', 'บันทึกไม่สำเร็จ');
        }
    }
    public function workshop_form_edit(Request $request)
    {
        $Edit = Survey::where('id', $request->id)->first();
        $Img = SurveyImg::where('survey_id', $request->id)->get();

        if(empty($Edit)){
            return back();
        }

        return view('workshop_form_edit', [
            'Edit' => $Edit,
            'Img' => $Img
        ]);
    }
    public function workshop_form_update(Request $request)
    {
        // dd($request);
        $insert = Survey::find($request->id);
        $insert->date = cms::DateThai2Eng($request->date);
        $insert->store_name = $request->store_name;
        $insert->store_no = $request->store_no;
        $insert->store_moo = $request->store_moo;
        $insert->store_soi = $request->store_soi;
        $insert->store_road = $request->store_road;
        // $insert->province = $request->province;
        // $insert->amphoe = $request->amphoe;
        // $insert->tumbon = $request->tumbon;
        // $insert->zipcode = $request->zipcode;
        $insert->summernote = $request->summernote;
        $insert->tel = $request->tel;

        if ($request->hasFile('image')) {

            $images = $request->file('image');
            foreach ($images as $image) {
                $rename = Carbon::now()->year + 543 . '_' . date('mdHis') . '_' . rand(111, 999) . '.' . $image->extension();
                $path = $image->move(public_path('uploads/survey/'), $rename);

                $width = Image::make($path)->width();
                $height = Image::make($path)->height();
                if ($width > $height) {
                    Image::make($path)->widen(1028, null, function ($constraint) {
                        $constraint->upsize();
                    })->save(public_path('uploads/survey/' . $rename));
                } else {
                    Image::make($path)->heighten(null, 720, function ($constraint) {
                        $constraint->upsize();
                    })->save(public_path('uploads/survey/' . $rename));
                }

                $SurveyImg = new SurveyImg();
                $SurveyImg->img_name = $rename;
                $SurveyImg->survey_id = $request->id;
                $SurveyImg->user_id = auth::user()->id;
                $SurveyImg->save();
            }
        }

        if ($insert->save()) {
            return redirect()->route('workshop.list')->with('Success', 'บันทึกสำเร็จ');
        } else {
            return back()->withInput()->with('Error', 'บันทึกไม่สำเร็จ');
        }
    }
    public function workshop_form_delete(Request $request)
    {
        $CheckImg = SurveyImg::where('survey_id', $request->id)->get();
        foreach ($CheckImg as $val) {
            File::delete('uploads/survey/' . $val->img_name);
        }

        $DelSurveyImg = SurveyImg::where('survey_id', $request->id)->delete();
        $DelSurvey = Survey::where('id', $request->id)->delete();

        if ($DelSurvey) {
            return back()->with('Success', 'ลบไฟล์สำเร็จ');
        } else {
            return back()->withInput()->with('Error', 'ลบไฟล์ไม่สำเร้จ');
        }
    }
    public function workshop_list(Request $request)
    {
        $survey = Survey::get();
        return view('workshop_list', [
            "survey" => $survey
        ]);
    }

    // Detail
    public function workshop_detail(Request $request)
    {
        $survey = Survey::where('id', $request->id)->first();
        $img = SurveyImg::where('survey_id', $request->id)->get();

        if(empty($survey)){
            return back();
        }

        return view('workshop_detail', [
            "survey" => $survey,
            "img" => $img
        ]);
    }
    public function workshop_detail_delete_img(Request $request)
    {
        File::delete('uploads/survey/' . $request->img_name);
        $delete = SurveyImg::where('id', $request->id)->delete();
        if ($delete) {
            return back()->with('Success', 'ลบไฟล์สำเร็จ');
        } else {
            return back()->withInput()->with('Error', 'ลบไฟล์ไม่สำเร้จ');
        }
    }

    public function truncate()
    {
        File::cleanDirectory('uploads/');
        // File::cleanDirectory('uploads/files/');
        // File::cleanDirectory('uploads/images/');
        // File::cleanDirectory('uploads/survey/');

        Storage::delete(Storage::allFiles('files/'));
        Storage::delete(Storage::allFiles('images/'));

        UploadFile::truncate();
        UploadImg::truncate();
        Relate::truncate();
        Survey::truncate();
        SurveyImg::truncate();

        User::where('avatar','!=',NULL)->update(['avatar'=> NULL]);

        return redirect()->back()->with('Truncate', 'ข้อมูล/ไฟล์ ทั้งหมดถูกล้าง');
    }
}
