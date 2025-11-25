@extends('layouts.app')

@section('title', $title)

@section('header', $header)

@section('content')
    @if ($errors->any())
        <div id="flash-alert" class="alert-error mb-6">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mx-auto px-6 py-4 lg:px-30 grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- SIDEBAR KIRI --}}
        <div class="col-span-1 space-y-4">
            <a href="{{ route('profile') }}"
                class="block bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition {{ request()->routeIs('profile') ? 'border-l-4 border-[#FFAB2F]' : '' }}">
                <h3 class="font-semibold text-gray-800"><i class="fa-solid fa-user mr-2"></i>Account</h3>
                <p class="text-sm text-gray-500 mt-1">Manage your profile information</p>
            </a>
            <a href="{{ route('profile.password') }}"
                class="block bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition {{ request()->routeIs('profile.password') ? 'border-l-4 border-[#FFAB2F]' : '' }}">
                <h3 class="font-semibold text-gray-800"><i class="fa-solid fa-lock mr-2"></i>Password</h3>
                <p class="text-sm text-gray-500 mt-1">Change your account password</p>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full bg-white text-left shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                    <h3 class="font-semibold text-gray-800"><i class="fa-solid fa-right-from-bracket mr-2"></i>Logout</h3>
                    <p class="text-sm text-gray-500 mt-1">Sign out of your account</p>
                </button>
            </form>
        </div>
        {{-- KONTEN KANAN --}}
        <div class="col-span-1 lg:col-span-3 space-y-6 lg:ml-17">
            {{-- PROFILE SECTION --}}
            @if (request()->routeIs('profile'))
                <div class="bg-white shadow-md rounded-2xl p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Profile Photo</h2>
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                        <img src="{{ $user->photo }}" alt="{{ $user->username }}"
                            class="w-28 h-28 rounded-full object-cover shrink-0 lg:w-30 lg:h-30">
                        <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data"
                            class="w-full max-w-xs">
                            @csrf
                            <div class="overflow-hidden whitespace-nowrap text-ellipsis w-full lg:mt-6.5">
                                <input
                                    class="mb-3 cursor-pointer bg-neutral-secondary-medium text-heading text-sm rounded-lg focus:ring-brand focus:border-brand block w-full placeholder:text-body" type="file" name="photo" accept="image/jpeg,image/png,image/jpg">
                            </div>
                            <button type="submit"
                                class="bg-[#FFAB2F] text-white px-4 py-2 rounded-lg hover:bg-[#FF9D0A] transition w-fit">
                                Update Photo
                            </button>
                        </form>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Account Information</h2>
                        <button data-modal-target="edit-account-modal" data-modal-toggle="edit-account-modal"
                            class="bg-[#FFAB2F] text-white px-4 py-2 rounded-lg hover:bg-[#FF9D0A] transition text-sm font-medium"
                            type="button">
                            <i class="fas fa-edit mr-1"></i><span class="hidden lg:inline">Edit</span>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1 text-sm">Username</label>
                            <p class="text-lg text-gray-900 font-semibold">{{ $user->username }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1 text-sm">Email</label>
                            <p class="text-lg text-gray-900 font-semibold">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1 text-sm">Full Name</label>
                            <p class="text-lg text-gray-900 font-semibold">{{ $user->name }}</p>
                        </div>
                    </div>
                </div>
                <div id="edit-account-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow-xl">
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    Edit Account Information
                                </h3>
                                <button type="button" data-modal-hide="edit-account-modal"
                                    class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">
                                    ✕
                                </button>
                            </div>
                            <form action="{{ route('profile.update') }}" method="POST" class="p-4 md:p-5 space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-gray-700 font-medium mb-1">Username</label>
                                    <input type="text" name="username" value="{{ $user->username }}"
                                        class="w-full border-gray-300 rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F]">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}"
                                        class="w-full border-gray-300 rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F]">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                                    <input type="text" name="name" value="{{ $user->name }}"
                                        class="w-full border-gray-300 rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F]">
                                </div>
                                <div class="flex gap-3 pt-2">
                                    <button type="submit"
                                        class="bg-[#FFAB2F] text-white px-4 py-2 rounded-lg hover:bg-[#FF9D0A] transition">
                                        Save Changes
                                    </button>
                                    <button type="button" data-modal-hide="edit-account-modal"
                                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @elseif (request()->routeIs('profile.password'))
                {{-- PASSWORD SECTION --}}
                <div class="bg-white shadow-md rounded-2xl p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Change Password</h2>
                    <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Old Password</label>
                            <div class="relative">
                                <input type="password" id="old_password" name="old_password"
                                    class="w-full border-gray-300 rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] pr-10"
                                    required>
                                <button type="button" data-target="old_password"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 toggle-password">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">New Password</label>
                            <div class="relative">
                                <input type="password" id="new_password" name="new_password"
                                    class="w-full border-gray-300 rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] pr-10"
                                    required>
                                <button type="button" data-target="new_password"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 toggle-password">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Confirm New Password</label>
                            <div class="relative">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                    class="w-full border-gray-300 rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] pr-10"
                                    required>
                                <button type="button" data-target="new_password_confirmation"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 toggle-password">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="submit"
                                class="bg-[#FFAB2F] text-white px-4 py-2 rounded-lg hover:bg-[#FF9D0A] transition">
                                Update
                            </button>
                            <a href="{{ route('profile.password') }}"
                                class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
