<nav class="bg-[#FFAB2F]">
    <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">Blogify</span>
        </a>
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            @if (!Auth::check())
                <a href="{{ route('login-register') }}"
                    class="text-white bg-rose-800 hover:bg-rose-900 box-border border border-transparent focus:ring-4 focus:ring-rose-700 shadow-xs font-medium leading-5 cursor-pointer rounded-xl text-sm px-5 py-2 focus:outline-none">Login</a>
            @else
                <button type="button"
                    class="flex text-sm bg-[#FFAB2F] rounded-full md:me-0 focus:ring-4 focus:ring-[#FFBE5C]"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full object-cover"
                        src="{{ Auth::user()->photo ?? 'https://i.imgur.com/ENtvpST.png' }}" alt="user photo">
                </button>
                <!-- Dropdown menu profile -->
                <div class="z-50 hidden my-4 text-base list-none divide-y rounded-lg shadow-sm bg-[#FF9D0A] divide-[#FFBE5C]"
                    id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-white">{{ Auth::user()->username }}</span>
                        <span class="block text-sm truncate text-gray-700">{{ Auth::user()->email }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="{{ route('profile') }}"
                                class="block px-4 py-2 text-sm hover:bg-[#FFAB2F] text-white">Profile</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-[#FFAB2F] text-white">Settings</a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm hover:bg-[#FFAB2F] text-white">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                <button data-collapse-toggle="navbar-user" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg md:hidden focus:outline-none focus:ring-2 text-gray-100 hover:bg-[#FFBE5C] focus:ring-[#FFBE5C]"
                    aria-controls="navbar-user" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            @endif
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
                class="flex flex-col font-semibold p-4 md:p-0 mt-4 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:shadow-none bg-[#FF9D0A] md:bg-[#FFAB2F] border-2 border-[#FFB647] shadow-[0_0_10px_#FFB647]">
                @if (Auth::check())
                    <li>
                        <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                    </li>
                    <!-- Dropdown menu -->
                    <li>
                        <button id="dropdownNvbarButton" data-dropdown-toggle="dropdownNavbar"
                            class="flex items-center justify-between w-full py-2 px-3 rounded font-semibold md:w-auto hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:p-0 {{ Request::is('blog*') || Request::is('my-blog*') || Request::is('create-post*') ? 'text-rose-800' : 'text-white md:hover:text-rose-800' }} ">
                            Blog
                            <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 9-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="dropdownNavbar"
                            class="z-10 hidden w-44 my-4 list-none divide-y rounded-lg shadow-sm bg-[#FF9D0A] divide-[#FFBE5C]">
                            <ul class="py-2 text-sm text-white font-medium" aria-labelledby="dropdownNvbarButton">
                                <li>
                                    <a href="{{ route('posts') }}"
                                        class="inline-flex items-center w-full p-2 hover:bg-[#FFAB2F]">All
                                        Blog</a>
                                </li>
                                <li>
                                    <a href="{{ route('myBlog') }}"
                                        class="inline-flex items-center w-full p-2 hover:bg-[#FFAB2F]">My
                                        Blog</a>
                                </li>
                                <li>
                                    <a href="{{ route('create') }}"
                                        class="inline-flex items-center w-full p-2 hover:bg-[#FFAB2F]">Create
                                        Post</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @if (Auth::user()->role === 'admin')
                        <li>
                            <x-nav-link href="{{ route('admin.posts') }}" :active="request()->is('admin/posts')">Manage Posts</x-nav-link>
                        </li>
                        <li>
                            <x-nav-link href="{{ route('admin.users') }}" :active="request()->is('admin/users')">Manage Users</x-nav-link>
                        </li>
                    @endif
                @else
                    <li>
                        <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="/blog" :active="request()->is('blog')">Blog</x-nav-link>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
