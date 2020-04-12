@if($menus)
    @foreach($menus as $key => $items)
        <ul class="childNav" data-parent="{{ $key }}">
            @foreach($items as $menu)
                    @can($menu['route'])
                        <li class="{{ $menu['liClass']  }}">
                            <a class="{{ $menu['aClass'] }}" href="{{ route($menu['route']) }}">
                                <i class="{{ $menu['iconClass']  }}"></i>
                                <span class="item-name">{{ __($menu['label']) }}</span>
                            </a>
                        </li>
                    @endcan
            @endforeach
        </ul>
    @endforeach
@endif