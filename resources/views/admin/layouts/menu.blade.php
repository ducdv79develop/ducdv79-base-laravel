@if(checkHasRead(PER_GROUP_ROLE) || checkHasRead(PER_GROUP_ADMIN))
    <li class="nav-header">SYSTEM MANAGER</li>
@endif
@if(checkHasRead(PER_GROUP_ADMIN))
    @php
        $adminRoute = array(
            'admin.member.index'
        );
    @endphp
    <li class="nav-item @if(in_array($route, $adminRoute)) menu-open @endif">
        <a class="nav-link" href="javascript:void(0)">
            <i class="nav-icon fas fa-users"></i>
            <p>
                {{ __('Member') }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item @if($route == 'admin.member.index') active @endif">
                <a href="{{ route('admin.member.index') }}" class="nav-link">
                    <i class="@if($route == 'admin.member.index') fas @else far @endif fa-circle nav-icon"></i>
                    <p>{{ __('List Member') }}</p>
                </a>
            </li>
        </ul>
    </li>
@endif

@if(checkHasRead(PER_GROUP_ROLE))
    @php
        $policyRoute = array(
            'admin.role.index',
            'admin.permission.index',
        );
    @endphp
    <li class="nav-item @if(in_array($route, $policyRoute)) menu-open @endif">
        <a class="nav-link" href="javascript:void(0)">
            <i class="nav-icon fas fa-lock"></i>
            <p>
                {{ __('Policy') }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item @if($route == 'admin.role.index') active @endif">
                <a href="{{ route('admin.role.index') }}" class="nav-link">
                    <i class="@if($route == 'admin.role.index') fas @else far @endif fa-circle nav-icon"></i>
                    <p>{{ __('List Role') }}</p>
                </a>
            </li>
            <li class="nav-item @if($route == 'admin.permission.index') active @endif">
                <a href="{{ route('admin.permission.index') }}" class="nav-link">
                    <i class="@if($route == 'admin.permission.index') fas @else far @endif fa-circle nav-icon"></i>
                    <p>{{ __('List Permission') }}</p>
                </a>
            </li>
        </ul>
    </li>
@endif
