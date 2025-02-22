{{-- This file is used for menu items by any Backpack v6 theme --}}

<x-backpack::menu-item :title="trans('backpack::base.dashboard')" icon="la la-dashboard"
                       :link="backpack_url('dashboard')"/>
<x-backpack::menu-dropdown title="THÔNG TIN CHUNG" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-item title="Danh Sách Tổ Chức" icon="la la-question" :link="backpack_url('organizations')"/>
    <x-backpack::menu-dropdown-item title="Danh Sách Khoa" icon="la la-question" :link="backpack_url('faculty')"/>
    <x-backpack::menu-dropdown-item title="Danh Sách Phòng" icon="la la-question" :link="backpack_url('department')"/>
    <x-backpack::menu-dropdown-item title="Danh Sách Lớp" icon="la la-question" :link="backpack_url('classes')"/>
    <x-backpack::menu-dropdown-item title="Danh Sách Sinh Viên" icon="la la-question" :link="backpack_url('students')"/>
    <x-backpack::menu-dropdown-item title="Danh Sách Giáo Viên" icon="la la-question" :link="backpack_url('teachers')"/>
</x-backpack::menu-dropdown>
<x-backpack::menu-dropdown title="NGHIỆP VỤ QUẢN LÝ" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-item title="Thêm Lớp" icon="la la-question" :link="backpack_url('classes/create')"/>
    <x-backpack::menu-dropdown-item title="Thêm Sinh Viên" icon="la la-question" :link="backpack_url('students/create')"/>
    <x-backpack::menu-dropdown-item title="Thêm Giáo Viên" icon="la la-question" :link="backpack_url('teachers/create')"/>
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="THÔNG BÁO" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-item title="Danh sách thông báo" icon="la la-question" :link="backpack_url('notifications')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="QUẢN TRỊ" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Quản Lý Tổ Chức"/>
    <x-backpack::menu-dropdown-item title="Thêm Phòng/Khoa" icon="la la-question" :link="backpack_url('organizations/create')"/>

    <x-backpack::menu-dropdown title="Quản Lý Tài Khoản" icon="la la-user" nested="true">
        <x-backpack::menu-dropdown-item title="Tài khoản" icon="la la-user" :link="backpack_url('user')"/>
        <x-backpack::menu-dropdown-item title="Vai trò" icon="la la-group" :link="backpack_url('role')"/>
        <x-backpack::menu-dropdown-item title="Quyền" icon="la la-key" :link="backpack_url('permission')"/>
    </x-backpack::menu-dropdown>
    <x-backpack::menu-dropdown-item title="Trình Độ Chuyên Môn" icon="la la-question" :link="backpack_url('academic-degrees')"/>
    <x-backpack::menu-dropdown-item title="Chức Vụ" icon="la la-question" :link="backpack_url('positions')"/>
    <x-backpack::menu-dropdown-item title="Chuyên Nghành" icon="la la-question" :link="backpack_url('majors')"/>
    <x-backpack::menu-dropdown-item title="Niên Khoá" icon="la la-question" :link="backpack_url('course')"/>
    <x-backpack::menu-dropdown-item title="Học Kỳ" icon="la la-question" :link="backpack_url('semesters')" />
</x-backpack::menu-dropdown>
@if (backpack_user()->hasRole('SuperAdmin'))
<x-backpack::menu-dropdown title="TIỆN ÍCH" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-item title='Cài Đặt' icon='la la-cog' :link="backpack_url('setting')" />
<x-backpack::menu-dropdown-item title='Logs' icon='la la-terminal' :link="backpack_url('log')"/>
    <!--    <x-backpack::menu-dropdown-item title="Activity Logs" icon="la la-stream" :link="backpack_url('activity-log')" />-->
    <x-backpack::menu-dropdown-item link="/api/documentation" title="API Documentation" icon="la la-book"/>
</x-backpack::menu-dropdown>
@endif


<!--<x-backpack::menu-item title="Evaluation scores" icon="la la-question" :link="backpack_url('evaluation-scores')" />-->
<!--<x-backpack::menu-item title="Semester scores" icon="la la-question" :link="backpack_url('semester-scores')" />-->
<!--<x-backpack::menu-item title="Notification statuses" icon="la la-question" :link="backpack_url('notification-statuses')" />-->
