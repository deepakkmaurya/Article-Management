<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Role') }}
            </h2>
            <a href="{{ route('role.index') }}"
                class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white mt-3 hover:bg-slate-400">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('role.store')}}" method="post">
                        @csrf
                        <div>
                            <label for="" class="text-sm font-medium">Name</label>
                            <input type="text" name="name" class="border-ger-300 shadow-sm w-1/2 rounded-lg">
                            <span>
                                @error('name')
                                    <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </span>
                        </div>
                        <div class="grid grid-cols-4 mb-3">
                            @if($permissions->isNotEmpty())
                            @foreach($permissions as $permission)

                            <div class="mt-3">
                                <input type="checkbox" id="permisssion-{{$permission->id}}"  name="permission[]" class="rounded" value="{{$permission->name }}">
                                <label for="permisssion-{{$permission->id}}">{{$permission->name }}</label>
                            </div>
                            @endforeach
                            @endif

                        </div>

                        <button class="bg-slate-700 text-sm rounded-md px-5 py-3 text-white mt-3 hover:bg-slate-400">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

