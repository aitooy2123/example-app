<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use Illuminate\Support\Facades\log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

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
        $datas1 = Cache::remember('count_province', '60', function () {
            return  DB::table('today-cases-line-lists')->selectRaw('count(txn_date) as totals,province')->GroupBy('province')->Orderby('totals', 'desc')->limit(10)->get();
        });
        foreach ($datas1 as $data1) {
            $dataPoints1[] = array("y" => $data1->totals, "label" => $data1->province);
        }

        // Cache Gender ------------------------------------------------------------------------------------
        $datas2 = Cache::remember('datas2', '60', function () {
            return  DB::table('today-cases-line-lists')->selectRaw('count(txn_date) as totals,gender')->GroupBy('gender')->get();
        });
        foreach ($datas2 as $data2) {
            $dataPoints2[] = array("y" => $data2->totals, "label" => $data2->gender);
        }

        // Cache Risk ------------------------------------------------------------------------------------
        $datas3 = Cache::remember('datas3', '60', function () {
            return  DB::table('today-cases-line-lists')->selectRaw('count(txn_date) as totals,risk')->GroupBy('risk')->orderByDesc('totals')->limit(5)->get();
        });
        foreach ($datas3 as $data3) {
            $dataPoints3[] = array("y" => $data3->totals, "label" => $data3->risk);
        }

        // API ------------------------------------------------------------------------------------
        $response = Http::get('https://covid19.ddc.moph.go.th/api/Usage-Stats-Count');
        $datas4 = json_decode($response->body());
        foreach ($datas4 as $data4) {
            $dataPoints4[] = array("y" => $data4->totals, "label" => $data4->date_req);
        }

        //dd($dataPoints4);

        return view('dashboard', [
            "dataPoints1" => $dataPoints1,
            "dataPoints2" => $dataPoints2,
            "dataPoints3" => $dataPoints3,
            "dataPoints4" => $dataPoints4,
        ]);
    }


    // Upload File -----------------------------------------------------------------------------------
    public function form_upload()
    {

        return view('form_upload');
    }
    public function form_upload_insert(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file' => 'mimes:doc,docx,xls,xlsx,pdf|max:2048'
        ]);

        
        return back()->withInput()->with('Success', 'Upload Successfully');
    }


    // Upload Image -----------------------------------------------------------------------------------
    public function form_image()
    {
        return view('form_image');
    }
    public function form_image_insert(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        return back()->withInput()->with('Success', 'Upload Successfully');
    }

    // Relate Province -----------------------------------------------------S------------------------------
    public function form_relate()
    {
        return view('form_relate');
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
