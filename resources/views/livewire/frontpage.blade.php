<div class="divide-y divide-gray-800" x-data="{ show: false }">
    <nav class="flex items-center bg-gray-900 px-3 py-2 shadow-lg">
        <div>
            <button @click="show =! show" class="block h-8 mr-3 text-gray-400 items-center hover:text-gray-200 focus:text-gray-200 focus:outline-none sm:hidden">
                <svg class="w-8 fill-current" viewBox="0 0 24 24">
                    <path x-show="!show" fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/>
                    <path x-show="show" fill-rule="evenodd" d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z"/>
                </svg>
            </button>
        </div>
        <div class="h-12 w-full flex items-center">
            <a href="{{ url('/')}}" class="w-full">
                <img class="h-16" src="{{ url('/img/logo.png')}}" />
            </a>
        </div>
        <div class="flex justify-end sm:w-11/12">
            {{-- Top Navigation --}}
            <ul class="hidden sm:flex sm:text-left text-gray-200 text-lg">
                @foreach ($topNavLinks as $item)
                    <a href="{{ url('/'.$item->slug) }}"><li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li></a>
                @endforeach
            </ul>
        </div>
    </nav>
    <div class="sm:flex min-h-screen">
        <aside class="bg-gray-900 text-gray-700">
            {{-- Desktop Web View --}}
            <ul class="hidden text-gray-200 text-xs sm:block sm:text-left">
                @foreach ($sidebarLinks as $item)
                    <a href="{{ url('/'.$item->slug) }}"><li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li></a>
                @endforeach
            </ul>
            {{-- Mobile Web View --}}
            <div :class="show ? 'block' : 'hidden' " class="pb-3 divide-y divide-gray-800 block sm:hidden">
                <ul class="text-gray-200 text-xs">
                    @foreach ($sidebarLinks as $item)
                        <a href="{{ url('/'.$item->slug) }}"><li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li></a>
                    @endforeach
                </ul>

                {{-- Top Navigation Mobile Web View --}}
                <ul class="text-gray-200 text-xs">
                    @foreach ($topNavLinks as $item)
                        <a href="{{ url('/'.$item->slug) }}"><li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li></a>
                    @endforeach
                </ul>

            </div>
        </aside>
        <main class="bg-gray-100 p-12 w-full">
            <section class="divide-y text-gray-900">
                <h1 class="text-xl text-center font-bold">{{ $title }}</h1>
                <article>
                    <div class="mt-5 text-sm">
                        {!! $content !!}
                    </div>
                </article>
            </section>
        </main>
    </div>
    <footer class="bg-gray-900 text-gray-200">
        <div>
            <ul class="text-xs text-gray-200 sm:text-lg flex justify-center">
                @foreach ($footerNavLinks as $item)
                    <a href="{{ url('/'.$item->slug) }}"><li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li></a>
                @endforeach
            </ul>
        </div>
        <div class="text-xs sm:text-md sm:tracking-widest py-4 flex justify-center tracking-tighter">
            <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">CreaTuWeb Copyright © </span>
            <?php
            $copyYear = 2002;
            $curYear = date('Y');
            echo $copyYear . (($copyYear != $curYear) ? '-' . $curYear : '');
            ?><a xmlns:cc="http://creativecommons.org/ns#" href="https://alojatuweb.com" property="cc:attributionName" rel="cc:attributionURL"> AlojaTuWeb</a>. Licencia <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"> CC BY-SA 4.0</a>
        </div>
    </footer>

</div>
