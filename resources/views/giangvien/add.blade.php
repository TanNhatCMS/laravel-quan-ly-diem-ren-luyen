@extends('master')
@section('title-page','Thêm giảng viên')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Tên giảng viên</label>
                <input type="text" name="name" class="form-control" placeholder="Họ Tên" required>
            </div>

            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>



            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection