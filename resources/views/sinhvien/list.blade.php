@extends('master')
@section('title-page','Danh sách sinh viên')
@section('content')
    <div class="table-responsive">
        <div class="form-group">
            <a href="{{ route('sinhvien.get_add', $lop->id) }}" class="btn btn-primary">Thêm sinh viên</a>

            <a href="" class="btn btn-primary pull-right">Export</a>
        </div>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>Mã sinh viên</th>
                <th>Tên sinh viên</th>
                <th>Lớp</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Email</th>
                <th>chức vụ</th>
                <th>Thao tác</th>
            </tr>
            </thead>

            <tbody>
            @foreach($sinhviens as $item)
                <tr>
                    <td>{{ $item->masv }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->ngaysinh }}</td>
                    <td>{{ $item->tenlop }}</td>
                    <td>{{ $item->gioitinh==1?'Nam':'Nữ' }}</td>

                    <td>{{ $item->email }}</td>
                    <td>@if($item->chucvu == 1)
                            lớp trưởng
                        @endif</td>
                    <td>

                        <a href="{{ route('sinhvien.get_chamdiem',$item->id) }}" class="btn btn-warning btn-sm">Chấm
                            điểm</a>
                        <a href="" class="btn btn-success btn-sm">Xem điểm </a>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        {{ $sinhviens->links() }}

    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function () {

            $('#example').DataTable({
                data: data
            });
        });
    </script>
@endsection