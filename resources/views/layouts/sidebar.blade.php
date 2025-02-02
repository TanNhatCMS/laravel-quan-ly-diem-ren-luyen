<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->email }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            @if(Auth::user()->vaitro == 1)
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Khoa</span> <span
                                class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('khoa.get_add')}}"><i class="fa fa-circle-o"></i> Thêm </a></li>
                        <li><a href="{{route('khoa.get_danhsach')}}"><i class="fa fa-circle-o"></i> Danh sách </a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Lớp</span> <span
                                class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('lop.get_add')}}"><i class="fa fa-circle-o"></i> Thêm </a></li>
                        <li><a href="{{route('lop.get_danhsach')}}"><i class="fa fa-circle-o"></i> Danh sách </a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Giảng viên</span> <span
                                class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('giangvien.get_add')}}"><i class="fa fa-circle-o"></i> Thêm </a></li>
                        <li><a href="{{route('giangvien.get_danhsach')}}"><i class="fa fa-circle-o"></i> Danh sách </a>
                        </li>
                    </ul>
                </li>


                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Quản lý tiêu chí đánh giá</span> <span
                                class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-circle-o"></i> Danh sách </a></li>
                        <li><a href=""><i class="fa fa-circle-o"></i> Thêm </a></li>
                    </ul>
                </li>


                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Quản lý nội  đánh giá</span> <span
                                class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-circle-o"></i> Danh sách </a></li>
                        <li><a href=""><i class="fa fa-circle-o"></i> Thêm </a></li>
                    </ul>
                </li>
            @elseif (Auth::user()->vaitro == 3)

                <li class="">
                    <a href="{{ route('giangvien.get_danhgia', 1) }}">
                        <i class="fa fa-table"></i> <span>Đánh giá điểm lớp chủ nhiệm</span>
                    </a>

                </li>


            @elseif (Auth::user()->vaitro == 5)
                <li class="">

                    <a href="{{ route('sinhvien.get_loptruongchamdiem', 1) }}">
                        <i class="fa fa-table"></i> <span>Lớp trưởng chấm</span>
                    </a>

                </li>
            @elseif (Auth::user()->vaitro == 2)
                <li class="">
                    <a href="{{ route('khoa.get_tonghop') }}">
                        <i class="fa fa-table"></i> <span>Tông hợp kết quả đánh giá</span>
                    </a>

                </li>
            @elseif (Auth::user()->vaitro == 4)

                <li class="">
                    <a href="{{ route('sinhvien.get_tuchamdiem', Auth::user()->id) }}">
                        <i class="fa fa-table"></i> <span>Sinh viên tự chấm</span>
                    </a>

                </li>
            @endif
            {{--            <li class="treeview">--}}
            {{--                <a href="#">--}}
            {{--                    <i class="fa fa-table"></i> <span>Thống kê</span>--}}
            {{--                </a>--}}

            {{--            </li>--}}

            <li>
                <a href="">
                    <i class="fa fa-calendar"></i> <span>Calendar</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
                </a>
            </li>


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>