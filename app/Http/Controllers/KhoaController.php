<?php

namespace App\Http\Controllers;

use App\Models\Khoa;
use Illuminate\Http\Request;

class KhoaController extends Controller
{
    public function getAdd()
    {
        return view('khoa.add');
    }

    public function postAdd(Request $request)
    {
        $khoa = new Khoa();
        $khoa->tenkhoa = $request->tenkhoa;
        $khoa->save();

        return redirect()->route('khoa.get_danhsach');
    }

    public function getDanhSach()
    {
        $khoa = Khoa::all();

        return view('khoa.danhsach', compact('khoa'));
    }

    public function getEdit($id)
    {
        $khoa = Khoa::find($id);

        return view('khoa.edit', compact('khoa'));
    }

    public function postEdit(Request $request, $id)
    {
        $khoa = Khoa::find($id);
        $khoa->tenkhoa = $request->tenkhoa;
        $khoa->save();

        return redirect()->route('khoa.get_danhsach');
    }

    public function delete($id)
    {
        Khoa::find($id)->delete();

        return redirect()->route('khoa.get_danhsach');
    }
}
