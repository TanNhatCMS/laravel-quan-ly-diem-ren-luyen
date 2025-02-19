{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}
    </a>
</li>

<x-backpack::menu-dropdown title="THÔNG TIN CHUNG" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Tổ Chức"/>
    <x-backpack::menu-item title="Danh Sách Tổ Chức" icon="la la-question" :link="backpack_url('organizations')"/>
    <x-backpack::menu-item title="Danh Sách Khoa" icon="la la-question" :link="backpack_url('faculty')"/>
    <x-backpack::menu-item title="Danh Sách Phòng" icon="la la-question" :link="backpack_url('department')"/>
    <x-backpack::menu-item title="Danh Sách Lớp" icon="la la-question" :link="backpack_url('classes')"/>
    <x-backpack::menu-item title="Danh Sách Sinh Viên" icon="la la-question" :link="backpack_url('students')"/>
    <x-backpack::menu-item title="Danh Sách Giáo Viên" icon="la la-question" :link="backpack_url('teachers')"/>
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="NGHIỆP VỤ QUẢN LÝ" icon="la la-puzzle-piece">
    <x-backpack::menu-item title="Thêm Lớp" icon="la la-question" :link="backpack_url('classes/create')"/>
    <x-backpack::menu-item title="Thêm Sinh Viên" icon="la la-question" :link="backpack_url('students/create')"/>
    <x-backpack::menu-item title="Thêm Giáo Viên" icon="la la-question" :link="backpack_url('teachers/create')"/>
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="THÔNG BÁO" icon="la la-puzzle-piece">

</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="QUẢN TRỊ" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Quản Lý Tổ Chức"/>
    <x-backpack::menu-item title="Thêm Phòng/Khoa" icon="la la-question" :link="backpack_url('organizations/create')"/>
    <x-backpack::menu-dropdown-header title="Quản Lý Tài Khoản"/>
    <x-backpack::menu-dropdown-item title="Tài khoản" icon="la la-user" :link="backpack_url('user')"/>
    <x-backpack::menu-dropdown-item title="Vai trò" icon="la la-group" :link="backpack_url('role')"/>
    <x-backpack::menu-dropdown-item title="Quyền" icon="la la-key" :link="backpack_url('permission')"/>
    <x-backpack::menu-item title="Trình Độ Chuyên Môn" icon="la la-question" :link="backpack_url('academic-degrees')"/>
    <x-backpack::menu-item title="Chức Vụ" icon="la la-question" :link="backpack_url('positions')"/>
    <x-backpack::menu-item title="Chuyên Nghành" icon="la la-question" :link="backpack_url('majors')"/>
    <x-backpack::menu-item title="Niên Khoá" icon="la la-question" :link="backpack_url('course')"/>
    <!--    <x-backpack::menu-item title="Học Kỳ" icon="la la-question" :link="backpack_url('semesters')" />-->
</x-backpack::menu-dropdown>
@if (backpack_user()->hasRole('SuperAdmin'))
<x-backpack::menu-dropdown title="TIỆN ÍCH" icon="la la-puzzle-piece">
    <!--    <x-backpack::menu-item title='Cài Đặt' icon='la la-cog' :link="backpack_url('setting')" />-->
    <x-backpack::menu-item title='Logs' icon='la la-terminal' :link="backpack_url('log')"/>
    <!--    <x-backpack::menu-item title="Activity Logs" icon="la la-stream" :link="backpack_url('activity-log')" />-->
    <x-backpack::menu-item link="/api/documentation" title="API Documentation" icon="la la-book"/>
</x-backpack::menu-dropdown>
@endif

