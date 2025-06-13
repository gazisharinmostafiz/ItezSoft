{{-- File: resources/views/admin/menus/items/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manage Items for Menu: ' . $menu->name)

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Manage Items for: <span class="text-indigo-600">{{ $menu->name }}</span></h1>
            <a href="{{ route('admin.menus.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                &larr; Back to All Menus
            </a>
        </div>
        <a href="{{ route('admin.menus.items.create', $menu->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
            <i class="fas fa-plus mr-2"></i>Add New Item to {{ $menu->name }}
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        @if ($menuItems->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500 text-lg">No items found for this menu yet.</p>
                <a href="{{ route('admin.menus.items.create', $menu->id) }}" class="mt-4 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm">
                    Add the first item!
                </a>
            </div>
        @else
            <p class="text-sm text-gray-600 mb-4">Drag and drop to reorder items (reordering functionality to be implemented).</p>
            {{-- We will use a nested list to display items and their children --}}
            {{-- For simplicity, this example will just list them. Reordering and deep nesting display will be more complex. --}}
            <div class="space-y-2">
                @foreach ($menuItems as $item)
                    @include('admin.menus.items.partials.item-display', ['item' => $item, 'menu' => $menu, 'level' => 0])
                @endforeach
            </div>
        @endif
    </div>

@endsection

@push('scripts')
{{-- Scripts for drag-and-drop reordering (e.g., SortableJS) would go here later --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    // Basic SortableJS example (needs more work for actual saving of order)
    // const menuItemsList = document.getElementById('menu-items-list');
    // if (menuItemsList) {
    //     new Sortable(menuItemsList, {
    //         animation: 150,
    //         ghostClass: 'bg-blue-100',
    //         // onEnd: function (evt) {
    //         //     // evt.oldIndex; // element's old index within parent
    //         //     // evt.newIndex; // element's new index within parent
    //         //     // Send AJAX request to update order
    //         // }
    //     });
    // }
</script> --}}
@endpush
