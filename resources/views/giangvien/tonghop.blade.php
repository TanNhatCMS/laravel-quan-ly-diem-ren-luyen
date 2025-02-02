@extends('master')
@section('title-page', 'Bảng tổng hợp kết quả của sinh viên')

@section('content')
    <form action="">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="text-center">
                <tr class="text-center">
                    <th rowspan="2">STT</th>
                    <th rowspan="2">MSSV</th>
                    <th rowspan="2">Họ Và Tên</th>
                    <th rowspan="2">LỚp</th>
                    <th colspan="3">I</th>
                    <th rowspan="2">II</th>
                    <th rowspan="2">III</th>
                    <th rowspan="2">IV</th>
                    <th rowspan="2">V</th>
                    <th rowspan="2">TỔNG ĐIỂM</th>
                    <th rowspan="2">XẾP LOẠI</th>
                    <th rowspan="2">GHI CHÚ</th>

                </tr>
                </thead>

                <tbody>
                <tr>
                    <td rowspan="2">(1)</td>
                    <td rowspan="2">(2)</td>
                    <td rowspan="2">(3)</td>
                    <td rowspan="2">(4)</td>
                    <td>(a)</td>
                    <td>(b)</td>
                    <td>(c)</td>
                </tr>

                <tr>
                    <td>(5)</td>
                    <td>(6)</td>
                    <td>(7)</td>
                    <td>(8)</td>
                    <td>(9)</td>
                    <td>(10)</td>
                    <td>(11)</td>
                    <td>(12)</td>
                    <td>(13)</td>
                    <td>(14)</td>
                </tr>


                <tr>
                    <td>(1)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>

                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                </tr>

                <tr>
                    <td>(2)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>

                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                </tr>

                <tr>
                    <td>(3)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>

                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                    <td><input type="text" style="width: 50px"></td>
                </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection