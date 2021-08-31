<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\User;
use App\Models\UploadFile;
use App\Models\UploadImg;
use App\Models\Relate;
use App\Models\Organize;

use Illuminate\Support\Facades\log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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

        // Cache province ------------------------------------------------------------------------------------
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

        // Cache Gender ------------------------------------------------------------------------------------
        $datas2 = Cache::remember('datas2', '60', function () {
            return  DB::table('today-cases-line-lists')
                ->selectRaw('count(txn_date) as totals,gender')
                ->GroupBy('gender')
                ->get();
        });
        foreach ($datas2 as $data2) {
            $dataPoints2[] = array("y" => $data2->totals, "label" => $data2->gender);
        }

        // Cache Risk ------------------------------------------------------------------------------------
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

        // API ------------------------------------------------------------------------------------
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
        $request->validate([
            'name' => 'required',
            'file' => 'mimes:doc,docx,xls,xlsx,pdf|max:2048'
        ]);

        // Storage
        $file_name = date('His') . '_' . $request->file->getClientOriginalName();
        $file_path = $request->file('file')->storeAs('uploads/files', $file_name, 'public');

        //Public
        $DateTime = carbon::now()->year + 543 . date('mdHis');
        $public_name = $DateTime . rand('111', '999') . '.' . $request->file->extension();
        $public_path = $request->file->move(public_path('uploads'), $public_name); //หลังจากเปลี่ยนชื่อไฟล์แล้วให้ย้ายไปที่ pubilb/uploads

        $insert = new UploadFile;
        $insert->file_name = $request->name;
        $insert->file_path1 = $public_name;
        $insert->file_path2 = $file_path;

        if ($insert->save()) {
            return back()->with('Success', 'อัพโหลดไฟล์สำเร็จ');
        } else {
            return back()->withInput()->with('Error', 'อัพโหลดไฟล์ไม่สำเร้จ');
        }
    }
    public function form_upload_download(Request $request)
    {
        $download = UploadFile::find($request->id);
        return Storage::download('public/' . $download->file_path2);
    }
    public function form_upload_delete(Request $request)
    {
        // dd($request);
        $delete = UploadFile::where('id', $request->id)->delete();
        File::delete('uploads/' . $request->path1);
        Storage::delete('public/' . $request->path2);

        if ($delete) {
            return back()->with('Success', 'ลบไฟล์สำเร็จ');
        } else {
            return back()->withInput()->with('Error', 'ลบไฟล์ไม่สำเร้จ');
        }
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
        $request->validate([
            'name' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Storage
        $file_name = $request->file('file')->getClientOriginalName();
        $file_path = $request->file('file')->store('images');

        // Public
        $DateTime = carbon::now()->year + 543 . date('mdHis');
        $public_name = $DateTime . rand('111', '999') . '.' . $request->file->getClientOriginalExtension();
        $public_path = $request->file->move(public_path('uploads/images/'), $public_name);

        // save to thumbnail
        Image::make($public_path)->fit(100, 100)->save(public_path('uploads/images/thumbnail/' . $public_name));

        // save to resize
        Image::make($public_path)->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('uploads/images/resize/' . $public_name));

        $insert = new UploadImg;
        $insert->img_name = $request->name; // ชื่อของไฟล์
        $insert->img_path1 = $public_name; // insert public
        $insert->img_path2 =  $file_path; // insert storage
        $insert->save();

        if ($insert->save()) {
            return back()->with('Success', 'อัพโหลดไฟล์สำเร็จ');
        } else {
            return back()->withInput()->with('Error', 'อัพโหลดไฟล์ไม่สำเร้จ');
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
        return view('form_relate',[
            'Relate' => $Relate,
            'Organize' => $Organize
        ]);
    }
    public function form_relate_insert(Request $request)
    {
        return back()->withInput()->with('Success', 'Insert Successfully');
    }


    // Contact Us -----------------------------------------------------S------------------------------
    public function contact()
    {
        return view('contact');
    }
}
