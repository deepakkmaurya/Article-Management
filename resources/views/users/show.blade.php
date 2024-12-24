<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
        
    </x-slot>

    <div class="py-4">
        <div class="max-w-96 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                          <h5 class="card-title text-gray-800">{{ $users->name }}</h5>
                          <h5 class="card-title text-gray-800">{{ $users->email }}</h5>
                          <p class="card-text mb-4">{{ \carbon\carbon::parse($users->created_at)->format('Y-m-d') }}</p>
                          <a href="{{ route('users.index') }}"
        class="bg-slate-700 text-sm rounded-md px-2 py-2 text-white hover:bg-slate-400">Back</a>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
