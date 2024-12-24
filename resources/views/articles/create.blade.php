<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Article') }}
            </h2>
            <a href="{{ route('articles.index') }}"
                class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white mt-3 hover:bg-slate-400">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('articles.store')}}" method="post">
                        @csrf
                        <div>
                            <label for="" class=" text-sm font-medium">Title</label>
                            <input type="text" name="title" class="border-ger-300 shadow-sm w-1/2 rounded-lg" value="{{old('title')}}">
                            <span>
                                @error('title')
                                    <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </span>
                        </div>                     
                        <div class="m-3">
                            <label for="" class="align-self-start text-sm font-medium">Article</label>
                            <textarea name="article" id="article" cols="30" rows="6" class="border-ger-300 shadow-sm w-1/2 rounded-lg" placeholder="Article Contents">{{old('article')}}</textarea>
                            <span>
                                @error('article')
                                    <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </span>
                        </div> 
                        <div>
                            <label for="" class="text-sm font-medium">Author</label>
                            <input type="text" name="author" class="border-ger-300 shadow-sm w-1/2 rounded-lg" value="{{old('author')}}">
                            <span>
                                @error('author')
                                    <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </span>
                        </div>  
                        <button class="bg-slate-700 text-sm rounded-md px-5 py-3 text-white mt-3 hover:bg-slate-400">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

