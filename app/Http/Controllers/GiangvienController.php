<?php

namespace App\Http\Controllers;

use App\Models\Giangvien;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GiangvienController extends Controller
{
    public function getDanhSach()
    {
        $giangviens = Giangvien::paginate(10);
        return view('giangvien.danhsach', compact('giangviens'));
    }

    public function getAdd()
    {
        return view('giangvien.add');
    }

    public function postAdd(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->email);
        $user->vaitro = 3;
        $user->remember_token = $request->_token;
        $user->save();

        $giangvien = new Giangvien();
        $giangvien->name = $request->name;
        $giangvien->email = $request->email;
        $giangvien->save();
        return redirect()->route('giangvien.get_danhsach');

    }

    public function getEdit($id)
    {

    }


    public function postEdit($id)
    {

    }


    public function delete($id)
    {

    }

    public function getDanhGiaDiemLop($id_lop)
    {
        $lop =  DB::table('lops')->where('id', $id_lop)->first();

        $sinhviens = DB::table('sinhviens')->join('lops', 'sinhviens.lop_id', '=', 'lops.id')
            ->select('lops.*', 'sinhviens.*')->where('sinhviens.lop_id', $id_lop)->paginate(10);

        return view('sinhvien.list', compact('lop','sinhviens'));
    }

    public function tongHopKetQua()
    {
        return view('giangvien.tonghop');
    }
}
