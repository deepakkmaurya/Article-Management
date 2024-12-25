<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User') }}
            </h2>
            <a href="{{ route('users.index') }}"
                class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white mt-3 hover:bg-slate-400">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('users.update',$user->id)}}" method="post">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $user->name)" autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email',$user->email)" autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-4 mb-3">
                            @if($roles->isNotEmpty())
                            @foreach($roles as $role)    
                            <div class="mt-3">
                                {{--  --}}
                                <input {{($hasRoles->contains($role->id))?'checked':''}} type="checkbox" id="role-{{$role->id}}"  name="role[]" class="rounded" value="{{$role->name }}" >
                                <label for="role-{{$role->id}}">{{$role->name }}</label>
                            </div>
                            @endforeach
                            @endif
                            </div>
                        
                        <button class="bg-blue-700 text-sm rounded-md px-5 py-3 text-white mt-3 hover:bg-blue-400">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

