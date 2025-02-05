<?php

namespace App\Http\Controllers;

use App\Models\Khoa;
use App\Models\Lop;
use DB;
use Illuminate\Http\Request;

class LopController extends Controller
{
    public function getDanhSach()
    {
        $lops = DB::table('lops')->join('khoas', 'lops.khoa_id', '=', 'khoas.id')
            ->select('khoas.*', 'lops.*')->paginate(10);

//        $lops = Lop::paginate(10);
        return view('lop.danhsach', compact('lops'));
    }

    public function getAdd()
    {
        $khoas = Khoa::all();

        return view('lop.add', compact('khoas'));
    }

    public function postAdd(Request $request)
    {
        $lop = new Lop();
        $lop->tenlop = $request->tenlop;
        $lop->khoa_id = $request->khoa;
        $lop->hedaotao = $request->hedaotao;
        $lop->save();

        return redirect()->route('lop.get_danhsach');
    }

    public function getEdit()
    {
    }
}
