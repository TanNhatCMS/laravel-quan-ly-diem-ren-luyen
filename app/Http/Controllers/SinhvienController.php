<?php

namespace App\Http\Controllers;

use App\Http\Requests\SinhVienAddRequest;
use App\Models\Lop;
use App\Models\Sinhvien;
use App\User;
use DB;
use Illuminate\Support\Facades\Hash;

class SinhvienController extends Controller
{
    public function getAdd($id)
    {
        $lops = Lop::all();

        return view('sinhvien.add', compact('lops'));
    }

    public function getDanhSach($id_lop)
    {
        $lop = DB::table('lops')->where('id', $id_lop)->first();

        $sinhviens = DB::table('sinhviens')->join('lops', 'sinhviens.lop_id', '=', 'lops.id')
            ->select('lops.*', 'sinhviens.*')->where('sinhviens.lop_id', $id_lop)->paginate(10);

        return view('sinhvien.list', compact('lop', 'sinhviens'));
    }

    public function postAdd(SinhVienAddRequest $request, $id_lop)
    {
        $user = new User();
        $user->name = $request->tensv;
        $user->email = $request->email;
        $user->password = Hash::make($request->email);
        $user->vaitro = 4;
        $user->remember_token = $request->_token;
//        vai tro 4 la sinh vien
        $user->save();

        $sinhvien = new Sinhvien();
        $sinhvien->name = $request->tensv;
        $sinhvien->masv = $request->masv;
        $sinhvien->ngaysinh = $request->ngaysinh;
        $sinhvien->gioitinh = $request->gioitinh;
        $sinhvien->lop_id = $id_lop;

        $sinhvien->email = $request->email;

        $sinhvien->save();

        return redirect()->route('sinhvien.get_danhsach', $id_lop);
    }

    public function getChamdiem($id)
    {
        return view('sinhvien.chamdiem');
    }

    public function getTuChamdiem($id)
    {
        return view('sinhvien.chamdiem');
    }

    public function getLopTruongChamdiem($id_lop)
    {
        $lop = \Illuminate\Support\Facades\DB::table('lops')->where('id', $id_lop)->first();

        $sinhviens = DB::table('sinhviens')->join('lops', 'sinhviens.lop_id', '=', 'lops.id')
            ->select('lops.*', 'sinhviens.*')->where('sinhviens.lop_id', $id_lop)->paginate(10);

        return view('sinhvien.list', compact('lop', 'sinhviens'));
    }
}
