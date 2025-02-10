<?php

use App\Http\Controllers\KhoaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::prefix('khoa')->group(function () {
    Route::get('danhsach', [KhoaController::class,  'getDanhSach'])->name('khoa.get_danhsach');

    Route::get('themkhoa', 'KhoaController@getAdd')->name('khoa.get_add');
    Route::post('themkhoa', 'KhoaController@postAdd')->name('khoa.post_add');

    Route::get('edit/{id}', 'KhoaController@getEdit')->name('khoa.get_edit');
    Route::post('edit/{id}', 'KhoaController@postEdit')->name('khoa.post_edit');

    Route::get('delete/{id}', 'KhoaController@delete')->name('khoa.delete');
});

Route::prefix('sinhvien')->group(function () {
    Route::get('tuchamdiem/{id}', 'SinhvienController@getTuChamdiem')->name('sinhvien.get_tuchamdiem');

    Route::get('loptruongchamdiem/{id_lop}', 'SinhvienController@getLopTruongChamdiem')->name('sinhvien.get_loptruongchamdiem');
});

Route::prefix('lop')->group(function () {
    Route::get('danhsach', 'LopController@getDanhSach')->name('lop.get_danhsach');

    Route::get('themlop', 'LopController@getAdd')->name('lop.get_add');
    Route::post('themlop', 'LopController@postAdd')->name('lop.post_add');

    Route::get('edit/{id}', 'LopController@getEdit')->name('lop.get_edit');

    Route::get('delete/{id}', 'LopController@delete')->name('lop.delete');

    Route::get('danhsachsinhvien/{id_lop}', 'SinhVienController@getDanhSach')->name('sinhvien.get_danhsach');

    Route::get('themsinhvien/{id_lop}', 'SinhVienController@getAdd')->name('sinhvien.get_add');
    Route::post('themsinhvien/{id_lop}', 'SinhVienController@postAdd')->name('sinhvien.post_add');

    Route::get('chamdiem/{id}', 'SinhVienController@getChamdiem')->name('sinhvien.get_chamdiem');
});

Route::prefix('giangvien')->group(function () {
    Route::get('danhsach', 'GiangVienController@getDanhSach')->name('giangvien.get_danhsach');
    Route::get('themgiangvien', 'GiangVienController@getAdd')->name('giangvien.get_add');

    Route::post('themgiangvien', 'GiangVienController@postAdd')->name('giangvien.post_add');

    Route::get('edit/{id}', 'GiangVienController@getEdit')->name('giangvien.get_edit');
    Route::post('edit/{id}', 'GiangVienController@postEdit')->name('giangvien.post_edit');

    Route::get('delete/{id}', 'GiangVienController@delete')->name('giangvien.delete');

    Route::get('danhgiadiemlopchunhiem/{ma_lop}', 'GiangVienController@getDanhGiaDiemLop')->name('giangvien.get_danhgia');
});

Route::get('tonghop', 'GiangVienController@tongHopKetQua')->name('khoa.get_tonghop');

//Auth::routes();

Route::get('/home', function () {
    return redirect('/admin');
});


Route::get('login', ['as' => 'admin.login.getLogin', 'uses' => 'Auth\LoginController@getLogin']);
Route::post('login', ['as' => 'admin.login.postLogin', 'uses' => 'Auth\LoginController@postLogin']);
Route::get('logout', ['as' => 'admin.logout', 'uses' => 'Auth\LoginController@logout']);
