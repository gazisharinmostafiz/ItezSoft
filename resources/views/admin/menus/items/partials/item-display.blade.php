{{-- File: resources/views/admin/menus/items/partials/item-display.blade.php --}}
{{-- This partial is called recursively to display nested menu items --}}

<div class="bg-gray-50 p-3 rounded-md shadow-sm border border-gray-200 {{ $level > 0 ? 'ml-' . ($level * 6) : '' }}">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            {{-- Drag handle (for future reordering) --}}
            {{-- <span class="cursor-move text-gray-400 hover:text-gray-600 mr-3"><i class="fas fa-grip-vertical"></i></span> --}}
            <span class="font-medium text-gray-800">{{ $item->title }}</span>
            <span class="ml-2 text-xs text-gray-500"> (Order: {{ $item->order }})</span>
            @if (!$item->is_active)
                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    Inactive
                </span>
            @endif
        </div>
        <div class="space-x-2 text-sm">
            <a href="{{ route('admin.menus.items.edit', ['menu' => $menu->id, 'menu_item' => $item->id]) }}" class="text-indigo-600 hover:text-indigo-800" title="Edit Item">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('admin.menus.items.destroy', ['menu' => $menu->id, 'menu_item' => $item->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this item and all its children?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete Item">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
            </form>
        </div>
    </div>
    <div class="ml-4 mt-1 text-xs text-gray-500">
        Type: <span class="font-semibold">{{ ucfirst($item->link_type) }}</span> |
        Value: <span class="font-semibold">{{ Str::limit($item->link_value, 40) }}</span>
        @if($item->target === '_blank') (New Tab) @endif
        @if($item->icon_class) | Icon: <i class="{{ $item->icon_class }}"></i>@endif
    </div>

    {{-- Recursively include children --}}
    @if ($item->childrenRecursive && $item->childrenRecursive->count() > 0)
        <div class="mt-2 space-y-2 pl-4 border-l-2 border-gray-200">
            @foreach ($item->childrenRecursive as $childItem)
                @include('admin.menus.items.partials.item-display', ['item' => $childItem, 'menu' => $menu, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>
