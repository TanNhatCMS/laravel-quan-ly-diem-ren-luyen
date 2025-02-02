@extends('master')
@section('title-page','Chấm điểm cho sinh viên Nguyễn Văn A lớp CNTT')

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="6">Nội dung đánh giá</th>
                <th>Thang điểm</th>
                <th>Sinh viên tự đánh giá</th>
                <th>Tập thể lớp đánh giá</th>
                <th>GVHT / GVCN kết luận điểm</th>

            </tr>
            </thead>

            <tbody>
            <tr style="font-weight: bold">
                <td colspan="10">I. Ý thức kết quả học tập, nghiên cứu khoa học, ngoại ngữ, tin học, hoạt động học
                    thuật.
                </td>

            </tr>

            <tr>
                <td colspan="6"><i>a. Ý thức học tập</i></td>
                <td style="font-weight: bold">0-10</td>
                <td colspan="3"></td>

            </tr>
            <tr>
                <td colspan="6">- Đi học đầy đủ, đúng giờ, không bỏ tiết</td>
                <td>3</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Nghiêm túc trong tất cả buổi học</td>
                <td>3</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Không vi phạm quy chế vì thi, kiểm tra</td>
                <td>4</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr style="font-weight: bold">
                <td colspan="7" class="text-center">Tổng I.a (tối đa 10)</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>

            </tr>


            <tr>
                <td colspan="6"><i>b. Kết quả học tập (chỉ chọn 1 mục dưới đây)</i></td>
                <td style="font-weight: bold">0-12</td>
                <td colspan="3"></td>

            </tr>

            <tr>
                <td colspan="6">- Điểm trung binh học tập......</td>
                <td>6</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Điểm trung binh học tập......</td>
                <td>8</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Điểm trung binh học tập......</td>
                <td>9</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Điểm trung binh học tập......</td>
                <td>10</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Điểm trung binh học tập......</td>
                <td>11</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Điểm trung binh học tập......</td>
                <td>12</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Điểm trung binh học tập......</td>
                <td>12</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr style="font-weight: bold">
                <td colspan="7" class="text-center">Tổng I.b (tối đa 12)</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>

            </tr>


            <tr>
                <td colspan="6"><i>c. Nghiêm cứu.....</i></td>
                <td style="font-weight: bold">0-8</td>
                <td colspan="3"></td>
            </tr>

            <tr>
                <td colspan="6">- tham gia......</td>
                <td>2 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- tham gia......</td>
                <td>2 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Thành viên......</td>
                <td>3 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Thành viên......</td>
                <td>3 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Đạt giải......</td>
                <td>7 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>


            <tr>
                <td colspan="6">- Có tham gia......</td>
                <td>3 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>


            <tr>
                <td colspan="6">- Có bằng khen......</td>
                <td>5 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Có bài nghiên cứu khoa học......</td>
                <td>6 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Có bài báo......</td>
                <td>8 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Đạt chứng chỉ ngoại ngữ.....</td>
                <td>3 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Đạt chứng chỉ TOELF.....</td>
                <td>4 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr style="font-weight: bold">
                <td colspan="7" class="text-right">Tổng I.c (tối đa 8)</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>

            </tr>

            <tr style="font-weight: bold">
                <td colspan="7" class="text-center">Tổng I (tối đa 30)</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>

            </tr>

            <tr style="font-weight: bold">
                <td colspan="10">II. Ý thức và kết quả chấp hành nội quy, quy định nhà trường
                    .
                </td>
            </tr>

            <tr>
                <td colspan="6">- Tham gia đầy đủ.....</td>
                <td>5</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Đảm bảo mặc trang phục.....</td>
                <td>10</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Để tóc .....</td>
                <td>5</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td colspan="6">- Tích cực giư gìn an ninh .....</td>
                <td>5</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Tích cực giữ gìn vệ sinh .....</td>
                <td>5</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Tích cực hưởng ứng .....</td>
                <td>5</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">- Thực hiện khám sức khỏe .....</td>
                <td>5</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>
            <tr style="font-weight: bold">
                <td colspan="7" class="text-center">Tổng II (tối đa 25)</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>

            </tr>

            <tr style="font-weight: bold">
                <td colspan="10">III....

                </td>
            </tr>

            <tr>
                <td colspan="6"> Không tham gia .....</td>
                <td>0</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Tham gia .....</td>
                <td>2 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Thanh viên .....</td>
                <td>3 điểm / đội</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Thanh viên tích cực .....</td>
                <td>5 điểm / đội</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Tham gia .....</td>
                <td>3 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Tham gia .....</td>
                <td>3 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Phân loại .....</td>
                <td>7</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Phân loại .....</td>
                <td>8</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Được kết nạp Đảng</td>
                <td>15 điểm</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Là chiến sĩ</td>
                <td>8</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td colspan="6"> Được công nhận...</td>
                <td>10</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Được khen thương...</td>
                <td>5 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Được khen thương...</td>
                <td>7 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Được khen thương...</td>
                <td>10 điểm / lần</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>


            <tr style="font-weight: bold">
                <td colspan="7" class="text-center">Tổng III (tối đa 20)</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>

            </tr>

            <tr style="font-weight: bold">
                <td colspan="10" class="text-center">IV....

                </td>
            </tr>

            <tr>
                <td colspan="6"> Sinh viên...</td>
                <td>5</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Sinh viên...</td>
                <td>3</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Sinh viên...</td>
                <td>5</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Sinh viên...</td>
                <td>10</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>


            <tr>
                <td colspan="6"> Sinh viên...</td>
                <td>5</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6"> Thành viên...</td>
                <td>2</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">Được biểu dương...</td>
                <td>10</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr style="font-weight: bold">
                <td colspan="7" class="text-center">Tổng IV (tối đa 15)</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>

            </tr>

            <tr style="font-weight: bold">
                <td colspan="10" class="text-center">V....

                </td>
            </tr>

            <tr>
                <td colspan="6">Không tham gia...</td>
                <td>2</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">Ban cán sự...</td>
                <td>0</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">Ban cán sự lớp...</td>
                <td>6</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">Ban cán sự lớp...</td>
                <td>8</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">Ban cán sự lớp...</td>
                <td>9</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td colspan="6">Ban cán sự lớp...</td>
                <td>10</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>

            <tr style="font-weight: bold">
                <td colspan="7" class="text-center">Tổng V (tối đa 10)</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>

            </tr>

            <tr style="font-weight: bold">
                <td colspan="6" class="text-center"> Tổng cộng
                </td>
                <td>0 – 100</td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>
            <tr style="font-weight: bold">
                <td colspan="6" class="text-center"> Xếp loại
                </td>
                <td></td>
                <td colspan="2"></td>

                <td><input type="text"></td>
            </tr>


            </tbody>
        </table>
    </div>

@endsection