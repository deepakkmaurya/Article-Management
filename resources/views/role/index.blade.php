<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Role') }}
            </h2>
            <a href="{{ route('role.create') }}"
                class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white mt-3 hover:bg-slate-400">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($roles->isNotEmpty())
                        <table class="w-full table table-striped table-dark">
                            <thead class="bg-gray-60">
                                <tr>
                                    <td class=" px-6 py-3 text-left ">#</td>
                                    <td class=" px-6 py-3 text-left ">Name</td>
                                    <td class=" px-6 py-3 text-left ">Roles</td>
                                    <td class=" px-6 py-3 text-left ">Create</td>
                                    <td class=" px-6 py-3 text-center ">Action</td>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <th class=" px-6 py-3 text-left ">
                                            {{ $roles->perPage() * ($roles->currentPage() - 1) + $key + 1 }}
                                        </th>
                                        <td class=" px-6 py-3 text-left ">{{ $role->name }}</td>
                                        <td class=" px-6 py-3 text-left ">{{ $role->permissions->pluck('name')->implode(' , ') }}</td>
                                        <td class=" px-6 py-3 text-left ">
                                            {{ \carbon\carbon::parse($role->created_at)->format('Y-M-d') }}</td>
                                        <td class=" px-6 py-3 text-center ">
                                            <a class="bg-yellow-700 text-sm rounded-md px-3 py-3 text-white mt-3 hover:bg-yellow-400"
                                                href="{{ route('role.show', $role->id) }}">Show</a>
                                            <a class="bg-green-700 text-sm rounded-md px-3 py-3 text-white mt-3 hover:bg-green-400"
                                                href="{{ route('role.edit', $role->id) }}">Edit</a>

                                            <a class="bg-red-700 text-sm rounded-md px-3 py-3 text-white mt-3 hover:bg-red-400"
                                                href ="javascript:void()"
                                                onclick=" deleteRole({{ $role->id }})">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <span class="text-red-700"> No Record Found ! </span>
                    @endif
                </div>
            </div>
            <div class="my-3">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deleteRole(id) {
                if (confirm("Are you sure you want to delete this role?")) {
                    $.ajax({
                        url:  '{{ route("role.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            window.location.href = '{{ route('role.index') }}'
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
