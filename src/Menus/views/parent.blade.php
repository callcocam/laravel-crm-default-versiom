@if($menus)
    @foreach($menus as $menu)
        @canany($menu['cannot'])
            <li class="{{ $menu['liClass']  }}"
                @isset($menu['dataItem'])
                data-item="{{ $menu['dataItem'] }}"
                    @endisset>
                <a @isset($menu['dataItem'])
                   href="{{ $menu['href'] }}"
                   @else
                   @isset($menu['url'])
                   href="{{ url($menu['url']) }}"
                   @else
                   href="{{ route($menu['route']) }}"
                   @endisset
                   @endisset
                   class="{{ $menu['aClass'] }}">
                    <i class="{{ $menu['iconClass']  }}"></i>
                    <span class="nav-text">{{ __($menu['label']) }}
                    </span>
                </a>
                <div class="triangle"></div>
            </li>
        @endcan
    @endforeach
@endif