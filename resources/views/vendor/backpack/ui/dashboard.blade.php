@extends(backpack_view('blank'))

@php
$userCount = App\Models\User::count();

Widget::add()->to('after_content')->type('div')->class('row mt-3')->content([
// notice we use Widget::make() to add widgets as content (not in a group)
Widget::make()
->type('card')
->class('text-white bg-primary mb-2')
->content([
'header' => 'Người dùng đã đăng ký',
'body'   => $userCount,
])
]);
Widget::add()->type('script')->content('https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
Widget::add()->type('script')->content('https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js');
Widget::add()->type('script')
->content('https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js')
->integrity('sha512-d8F1J2kyiRowBB/8/pAWsqUl0wSEOkG5KATkVV4slfblq9VRQ6MyDZVxWl2tWd+mPhuCbpTB4M7uU/x9FlgQ9Q==')
->crossorigin('anonymous')
->referrerpolicy('no-referrer');

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
<style>
    .card-counter {
        box-shadow: 2px 2px 10px #DADADA;
        margin: 5px 0;
        padding: 20px 10px;
        background-color: #fff;
        height: 100px;
        border-radius: 5px;
        transition: .3s linear all;
    }

    .card-counter:hover {
        box-shadow: 4px 4px 20px #DADADA;
        transition: .3s linear all;
    }

    .card-counter.primary {
        background-color: #007bff;
        color: #FFF;
    }

    .card-counter.danger {
        background-color: #ef5350;
        color: #FFF;
    }

    .card-counter.success {
        background-color: #66bb6a;
        color: #FFF;
    }

    .card-counter.info {
        background-color: #26c6da;
        color: #FFF;
    }

    .card-counter i {
        font-size: 5em;
        opacity: 0.2;
    }

    .card-counter .count-numbers {
        position: absolute;
        right: 35px;
        top: 20px;
        font-size: 32px;
        display: block;
    }

    .card-counter .count-name {
        position: absolute;
        right: 35px;
        top: 65px;
        font-style: italic;
        text-transform: capitalize;
        opacity: 0.5;
        display: block;
        font-size: 18px;
    }
</style>
@endpush
@section('content')
<script>
    jQuery(document).ready(function($) {
        $('.counter').counterUp({
            delay: 10,
            time: 500
        });
    });
</script>
<style>
    .card-counter {
        box-shadow: 2px 2px 10px #DADADA;
        margin: 5px 0;
        padding: 20px 10px;
        background-color: #fff;
        height: 100px;
        border-radius: 5px;
        transition: .3s linear all;
    }

    .card-counter:hover {
        box-shadow: 4px 4px 20px #DADADA;
        transition: .3s linear all;
    }

    .card-counter.primary {
        background-color: #007bff;
        color: #FFF;
    }

    .card-counter.danger {
        background-color: #ef5350;
        color: #FFF;
    }

    .card-counter.success {
        background-color: #66bb6a;
        color: #FFF;
    }

    .card-counter.info {
        background-color: #26c6da;
        color: #FFF;
    }

    .card-counter i {
        font-size: 5em;
        opacity: 0.2;
    }

    .card-counter .count-numbers {
        position: absolute;
        right: 35px;
        top: 20px;
        font-size: 32px;
        display: block;
    }

    .card-counter .count-name {
        position: absolute;
        right: 35px;
        top: 65px;
        font-style: italic;
        text-transform: capitalize;
        opacity: 0.5;
        display: block;
        font-size: 18px;
    }
</style>
<div class="row">
    <div class="col-md-2">
        <div class="card-counter success">
            <i class="las la-user"></i>
            <span class="count-numbers counter">{{ $userCount }}</span>
            <span class="count-name">Người dùng</span>
        </div>
    </div>
</div>
    {{-- In case widgets have been added to a 'content' group, show those widgets. --}}
    @include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('group', 'content')->toArray() ])
@endsection
