{{-- Recursive Menu Item for Frontend - Histudy Style --}}
@foreach($menus as $menu)
    @if($menu->children->count() > 0)
        <li class="has-dropdown has-menu-child-item {{ $menu->isActive() ? 'active' : '' }}">
            <a class="{{ $menu->isActive() ? 'active' : '' }}" href="{{ $menu->url ?? 'javascript:void(0)' }}">
                @if($menu->icon)<i class="{{ $menu->icon }}"></i>@endif
                {{ $menu->title }} <i class="feather-chevron-down"></i>
            </a>
            <ul class="submenu">
                @include('partials.site.menu-item', ['menus' => $menu->children])
            </ul>
        </li>
    @else
        <li class="{{ $menu->isActive() ? 'active' : '' }}">
            <a class="{{ $menu->isActive() ? 'active' : '' }}" href="{{ $menu->url ?? '#' }}" @if($menu->open_new_tab) target="_blank" rel="noopener" @endif>
                @if($menu->icon)<i class="{{ $menu->icon }}"></i>@endif
                {{ $menu->title }}
            </a>
        </li>
    @endif
@endforeach
