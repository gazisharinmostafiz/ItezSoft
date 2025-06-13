{{-- File: resources/views/partials/menus/header-item.blade.php --}}
{{-- This partial is called recursively to display menu items and their children --}}
{{-- $item is a MenuItem model instance --}}
{{-- $isSubmenu is a boolean indicating if this is part of a dropdown --}}

@if ($item->is_active)
    @if (!$item->hasChildren())
        {{-- Single menu item without children --}}
        <a href="{{ $item->getUrl() }}"
           target="{{ $item->target ?? '_self' }}"
           class="{{ $isSubmenu ?? false
                       ? 'block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-md'
                       : 'text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium' }}
                  {{ request()->url() == $item->getUrl() || (Route::currentRouteName() && $item->link_type == 'route' && request()->routeIs($item->link_value))
                      ? ($isSubmenu ?? false ? 'bg-indigo-50 text-indigo-700' : 'text-indigo-600 font-semibold border-b-2 border-indigo-500')
                      : '' }}"
           role="menuitem">
            @if($item->icon_class)<i class="{{ $item->icon_class }} mr-2"></i>@endif
            {{ $item->title }}
        </a>
    @else
        {{-- Menu item with children (dropdown) --}}
        <div class="relative group">
            <button class="{{ $isSubmenu ?? false
                                ? 'w-full text-left flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-md'
                                : 'text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium inline-flex items-center' }}
                           {{-- Active state for parent might be more complex, based on children or specific routes --}}
                           {{ (collect($item->childrenRecursive)->pluck('link_value')->contains(Route::currentRouteName()) && $item->childrenRecursive()->where('link_type', 'route')->count() > 0) || Str::startsWith(request()->path(), ltrim(parse_url($item->getUrl(), PHP_URL_PATH), '/')) && $item->link_type == 'url' && $item->getUrl() != '#'
                               ? ($isSubmenu ?? false ? 'bg-indigo-50 text-indigo-700' : 'text-indigo-600 font-semibold border-b-2 border-indigo-500')
                               : '' }}"
                    aria-haspopup="true"
                    aria-expanded="false">
                @if($item->icon_class)<i class="{{ $item->icon_class }} mr-2"></i>@endif
                {{ $item->title }}
                <i class="fas fa-chevron-down ml-2 text-xs {{ $isSubmenu ?? false ? '' : 'group-hover:rotate-180 transition-transform' }}"></i>
            </button>
            <div class="{{ $isSubmenu ?? false
                            ? 'mt-1 pl-4 static w-auto' /* Static for nested dropdowns */
                            : 'absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 group-hover:opacity-100 transition-opacity duration-200 ease-in-out invisible group-hover:visible z-40'
                        }}">
                <div class="py-1 {{ $isSubmenu ?? false ? '' : 'rounded-md bg-white shadow-xs' }}" role="menu" aria-orientation="vertical">
                    @foreach ($item->childrenRecursive as $childItem)
                        {{-- Recursive call for child items, passing isSubmenu=true --}}
                        @include('partials.menus.header-item', ['item' => $childItem, 'isSubmenu' => true])
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endif
