{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}
    </a>
</li>
<x-backpack::menu-dropdown title="Quản Lý Tổ Chức" icon="la la-question">
    <x-backpack::menu-item title="Danh Sách Tổ Chức" icon="la la-question" :link="backpack_url('organizations')" />
    <x-backpack::menu-item title="Danh Sách Khoa" icon="la la-question" :link="backpack_url('organizations?type=department')" />
    <x-backpack::menu-item title="Danh Sách Phòng" icon="la la-question" :link="backpack_url('organizations?type=faculty')" />
    <x-backpack::menu-item title="Thêm Phòng/Khoa" icon="la la-question" :link="backpack_url('organizations/create')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-item title="Danh Sách Chuyên Nghành" icon="la la-question" :link="backpack_url('majors')" />
<x-backpack::menu-item title="Danh Sách Lớp" icon="la la-question" :link="backpack_url('classes')" />

<x-backpack::menu-dropdown title="Add-ons" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Authentication" />
    <x-backpack::menu-dropdown-item title="Users" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
    <x-backpack::menu-item title='Settings' icon='la la-cog' :link="backpack_url('setting')" />
    <x-backpack::menu-item title='Logs' icon='la la-terminal' :link="backpack_url('log')" />
    <x-backpack::menu-item title="Activity Logs" icon="la la-stream" :link="backpack_url('activity-log')" />
</x-backpack::menu-dropdown>
<x-backpack::menu-item title="Sinh viên" icon="la la-question" :link="backpack_url('students')" />
<x-backpack::menu-item title="Giảng Viên" icon="la la-question" :link="backpack_url('lecturers')" />
<x-backpack::menu-item title="Học kỳ" icon="la la-question" :link="backpack_url('semester-scores')" />
<x-backpack::menu-item title="Ban Cán Sự" icon="la la-question" :link="backpack_url('class-officers')" />







<x-backpack::menu-item title="Academic years" icon="la la-question" :link="backpack_url('academic-years')" />
