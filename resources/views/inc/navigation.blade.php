@php
$menuItems = [
    [
        'title'      => 'Thống Kê',
        'icon'       => 'table_view',
        'link'       => 'dashboard',
        'module'       => 'dashboard',
    ],
    [
        'title'      => 'Trả Góp',
        'icon'       => 'table_view',
        'link'       => 'dashboard',
        'module'       => '123',
    ],
    [
        'title'     => 'Bảo Hành',
        'icon'      => 'table_view',
        'link'      => 'dashboard',
        'module'       => '123',
    ],
    [
        'title'     => 'QL Khách Hàng',
        'icon'      => 'table_view',
        'link'      => 'dashboard',
        'module'       => '132',
    ],
    [
        'title'      => 'QL Nhân Viên',
        'icon'       => 'table_view',
        'module'       => 'ư123',
        'sub-menu'  => [
            [
                'title'     => 'Danh sách nhân viên',
                'link'      => 'dashboard',
                'icon'      => 'table_view',
                'module'       => '123',
            ],
            [
                'title'     => 'Quản lý chức vụ',
                'link'      => 'dashboard',
                'icon'      => 'table_view',
                'module'       => 'dashboard',
            ],
        ]
    ],
    [
        'title'     => 'QL Chi Nhánh',
        'icon'      => 'table_view',
        'link'      => 'dashboard',
        'module'       => '123',
    ],
    [
        'title'     => 'QL Sản Phẩm',
        'icon'      => 'table_view',
        'link'      => 'dashboard',
        'module'       => '123',
    ],
    [
        'title'     => 'QL Sản Phẩm',
        'icon'      => 'table_view',
        'link'      => 'dashboard',
        'module'       => '123',
    ],
    [
        'title'     => 'QL Sản Phẩm',
        'icon'      => 'table_view',
        'link'      => 'dashboard',
        'module'       => '123',
    ],
];

@endphp

<div class="collapse navbar-collapse w-auto h-auto ps">
    <ul class="navbar-nav">
        @foreach($menuItems as $menu)
            @if(empty($menu['sub-menu']))
                <li class="nav-item">
                    <a 
                    @if($module == $menu['module']) class="nav-link text-white active bg-gradient-primary" 
                    @else class="nav-link text-white "
                    @endif href="{{ route($menu['link']) }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">{{ $menu['icon'] }}</i>
                        </div>
                        <div class="menu-title">{{ $menu['title'] }}</div>
                    </a>
                </li>
            @else
            <li class="nav-item ">
                <a 
                    @if($module == $menu['module']) class="nav-link text-white active bg-gradient-primary" 
                    @else class="nav-link text-white collapsed"
                    @endif data-bs-toggle="collapse" aria-expanded="false" href="#foundationExample">
                    <div class="parent-icon">
                        <i class="material-icons opacity-10">{{ $menu['icon'] }}</i>
                    </div>
                    <div class="menu-title">{{ $menu['title'] }}</div>
                </a>
                <div 
                    @if($module == $menu['module']) class="collapse show" 
                    @else class="collapse"
                    @endif 
                    id="foundationExample">
                    <ul class="nav nav-sm flex-column">
                        @foreach($menu['sub-menu'] as $sub)
                            <li class="nav-item">
                            <a 
                                @if($module == $sub['module']) class="nav-link text-white active bg-gradient-primary" 
                                @else class="nav-link text-white "
                                @endif href="{{ route($sub['link']) }}">
                                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">{{ $sub['icon'] }}</i>
                                    </div>
                                    <div class="menu-title">{{ $sub['title'] }}</div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            @endif
        @endforeach
    </ul>
</div>