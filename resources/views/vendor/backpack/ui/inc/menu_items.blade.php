{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}
    </a>
</li>

<x-backpack::menu-item title="Trình Độ Chuyên Môn" icon="la la-question" :link="backpack_url('academic-degrees')" />
<x-backpack::menu-item title="Chuyên Nghành" icon="la la-question" :link="backpack_url('majors')" />
<x-backpack::menu-item title="Niên Khoá" icon="la la-question" :link="backpack_url('academic-years')" />

<x-backpack::menu-item title="Học kỳ" icon="la la-question" :link="backpack_url('semester-scores')" />
<x-backpack::menu-dropdown title="THÔNG TIN CHUNG" icon="la la-puzzle-piece">

</x-backpack::menu-dropdown>
<x-backpack::menu-dropdown title="NGHIỆP VỤ QUẢN LÝ" icon="la la-puzzle-piece">
    <x-backpack::menu-item title="Lớp" icon="la la-question" :link="backpack_url('classes')" />
    <x-backpack::menu-item title="Sinh viên" icon="la la-question" :link="backpack_url('students')" />
    <x-backpack::menu-item title="Giáo Viên" icon="la la-question" :link="backpack_url('teachers')" />
    <x-backpack::menu-item title="Ban Cán Sự" icon="la la-question" :link="backpack_url('class-officers')" />
</x-backpack::menu-dropdown>
<x-backpack::menu-dropdown title="THÔNG BÁO" icon="la la-puzzle-piece">

</x-backpack::menu-dropdown>
<x-backpack::menu-dropdown title="QUẢN TRỊ" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Quản Lý Tổ Chức" />
    <x-backpack::menu-item title="Danh Sách Tổ Chức" icon="la la-question" :link="backpack_url('organizations')" />
    <x-backpack::menu-item title="Danh Sách Khoa" icon="la la-question" :link="backpack_url('organizations?type=department')" />
    <x-backpack::menu-item title="Danh Sách Phòng" icon="la la-question" :link="backpack_url('organizations?type=faculty')" />
    <x-backpack::menu-item title="Thêm Phòng/Khoa" icon="la la-question" :link="backpack_url('organizations/create')" />
    <x-backpack::menu-dropdown-header title="Quản Lý Tài Khoản" />
    <x-backpack::menu-dropdown-item title="Users" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />

</x-backpack::menu-dropdown>
<x-backpack::menu-dropdown title="TIỆN ÍCH" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Authentication" />
    <x-backpack::menu-item title='Settings' icon='la la-cog' :link="backpack_url('setting')" />
    <x-backpack::menu-item title='Logs' icon='la la-terminal' :link="backpack_url('log')" />
    <x-backpack::menu-item title="Activity Logs" icon="la la-stream" :link="backpack_url('activity-log')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-item title="Positions" icon="la la-question" :link="backpack_url('positions')" />
<x-backpack::menu-item title="User positions" icon="la la-question" :link="backpack_url('user-position')" />

<x-backpack::menu-item title="User organizations" icon="la la-question" :link="backpack_url('user-organizations')" />
<x-backpack::menu-item title="User classes" icon="la la-question" :link="backpack_url('user-classes')" />
<x-backpack::menu-item title="User profiles" icon="la la-question" :link="backpack_url('user-profiles')" />
