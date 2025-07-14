<!-- Navbar -->
    <nav class="bg-white shadow-lg fade-top relative z-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <img src="{{ asset('images/inter2.png') }}" alt="Logo" class="h-10">
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ url('/') }}"
                        class="text-black hover:text-yellow-400 px-3 py-2 text-sm font-medium underline-animation">Početna</a>
                    {{-- News Button Removed --}}

                    {{-- <a href="{{ url('/novosti') }}">Novosti</a> --}}
                    <div class="relative group">
                        <button
                            class="text-black hover:text-yellow-400 px-3 py-2 text-sm font-medium flex items-center">
                            Rezerviraj
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute z-10 mt-0 w-48 rounded-md shadow-lg bg-gray-700 hidden group-hover:block">
                            <a href="{{ url('/rijeka') }}"
                                class="block px-4 py-2 text-sm text-white hover:bg-gray-600 rounded-md">Rijeka</a>
                            <a href="{{ url('/crikvenica') }}"
                                class="block px-4 py-2 text-sm text-white hover:bg-gray-600 rounded-md">Crikvenica</a>
                        </div>
                    </div>
                    @auth
                        <a href="{{ url('/kreiraj') }}"
                            class="text-black hover:text-yellow-400 px-3 py-2 text-sm font-medium underline-animation">Kreiraj
                            Dan</a>
                        <a href="{{ route('admin.news.view') }}"
                            class="text-black hover:text-yellow-400 px-3 py-2 text-sm font-medium underline-animation">Kreiraj
                            Novost</a>
                    @endauth
                    @guest
                        <a href="{{ url('/login') }}"
                            class="text-black hover:text-yellow-400 px-3 py-2 text-sm font-medium">Login</a>
                        <a href="{{ url('/register') }}"
                            class="text-black hover:text-yellow-400 px-3 py-2 text-sm font-medium">Register</a>
                    @endguest
                    @auth
                        <div class="flex items-center">
                            <span class="text-black text-sm mr-2">Pozdrav {{ Auth::user()->name }}</span>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="text-black hover:text-yellow-400 text-sm underline-animation">Logout</a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                    @endauth
                </div>
                <div class="md:hidden flex items-center">
                    <button id="hamburgerBtn" class="text-gray-300 hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile overlay -->
    <div id="mobileMenu" class="overlay">
        <a href="javascript:void(0)" class="closebtn" id="closeBtn">&times;</a>
        <div class="overlay-content">
            <a href="{{ url('/') }}">Početna</a>

            {{-- News Button Removed --}}

            {{-- <a href="{{ url('/novosti') }}">Novosti</a> --}}
            <div class="relative">
                <button id="mobileDropdownBtn" class="text-white text-2xl w-full py-2">
                    Rezerviraj <i class="fas fa-chevron-down ml-2"></i>
                </button>
                <div id="mobileDropdown" class="hidden bg-gray-700 rounded mt-2">
                    <a href="{{ url('/rijeka') }}" class="text-white block py-2">Rijeka</a>
                    <a href="{{ url('/crikvenica') }}" class="text-white block py-2">Crikvenica</a>
                </div>
            </div>
            <a href="{{ url('/kreiraj') }}">Kreiraj Dan</a>
            <a href="{{ route('admin.news.view') }}">Kreiraj Novost</a>
            @guest
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Register</a>
            @endguest
            @auth
                <div class="mt-4 pt-4 border-t border-gray-600">
                    <p class="text-white text-xl p-5">Pozdrav {{ Auth::user()->name }}</p>
                    <a href="#" class="text-white underline-animation"
                        onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">Logout</a>
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">@csrf
                    </form>
                </div>
            @endauth
        </div>
    </div>
