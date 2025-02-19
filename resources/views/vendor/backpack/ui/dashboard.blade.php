@extends(backpack_view('blank'))

@php
$userCount = App\Models\User::count();

$userStudent = App\Models\User::whereHas('profile', function ($query) {
    $query->where('type', 'student');
})->count();

$userTeacher = App\Models\User::whereHas('profile', function ($query) {
    $query->where('type', 'teacher');
})->count();

$facultyCount = App\Models\Organizations::where('type', 'faculty')->count();
$departmentCount = App\Models\Organizations::where('type', 'department')->count();
$classCount = App\Models\Classes::count();

$widgets['before_content'][] = [
'type'         => 'alert',
'class' => 'alert alert-info  mb-2 col-12',
'heading' =>'QUẢN LÝ ĐIỂM RÈN LUYỆN SINH VIÊN',
'content' =>'Phiên bản LMS: <span class="text-danger text-break"> </span>'.get_lms_version().'<br>Phiên bản CRUD:<span
    class="text-danger text-break"> '.get_crud_version().' </span>',
'close_button' => true,
]
@endphp


@push('after_styles')

@endpush
@section('content')
<style>
    .card-counter {
        box-shadow: 2px 2px 10px #DADADA;
        padding: 20px;
        background-color: #fff;
        height: 120px;
        border-radius: 10px;
        transition: 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
    }

    .card-counter:hover {
        box-shadow: 4px 4px 20px #DADADA;
    }

    .card-counter i {
        font-size: 2.5rem;
        opacity: 0.6;
    }

    .count-numbers {
        font-size: 28px;
        font-weight: bold;
        margin-top: 5px;
    }

    .count-name {
        font-size: 16px;
        opacity: 0.7;
    }

    .primary {
        background-color: #007bff;
        color: white;
    }

    .info {
        background-color: #17a2b8;
        color: white;
    }

    .danger {
        background-color: #dc3545;
        color: white;
    }

    .success {
        background-color: #28a745;
        color: white;
    }
</style>
<div class="container mt-4">
    <div class="row g-3">

        <div class="col-6 col-sm-4 col-md-2">
            <div class="card-counter success">
                <i class="fas fa-user"></i>
                <span class="count-numbers counter">{{$userCount}}</span>
                <span class="count-name">Tổng Tài khoản người dùng</span>
            </div>
        </div>


        <div class="col-6 col-sm-4 col-md-2">
            <div class="card-counter primary">
                <i class="fas fa-film"></i>
                <span class="count-numbers counter">{{$userStudent}}</span>
                <span class="count-name">Tổng sinh viên</span>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-md-2">
            <div class="card-counter info">
                <i class="fas fa-server"></i>
                <span class="count-numbers counter">{{$userTeacher}}</span>
                <span class="count-name">Tổng giáo viên</span>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-md-2">
            <div class="card-counter danger">
                <i class="fas fa-bug"></i>
                <span class="count-numbers counter">{{$facultyCount}}</span>
                <span class="count-name">Tổng Khoa</span>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-md-2">
            <div class="card-counter primary">
                <i class="fas fa-paint-brush"></i>
                <span class="count-numbers counter">{{$departmentCount}}</span>
                <span class="count-name">Tổng Phòng</span>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-md-2">
            <div class="card-counter">
                <i class="fas fa-puzzle-piece"></i>
                <span class="count-numbers">{{$classCount}}</span>
                <span class="count-name">Tổng lớp</span>
            </div>
        </div>
    </div>
</div>
{{-- In case widgets have been added to a 'content' group, show those widgets. --}}
@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('group', 'content')->toArray() ])
@endsection
