@extends('layouts.app')

@section('title', $title)

@section('header', $header)

@section('content')
    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-sm p-4 mt-4 mb-6">
        <form method="GET" action="{{ route('admin.users') }}">
            <div class="flex justify-between items-center gap-4">
                <div class="flex-1 max-w-md">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search author name..."
                        autocomplete="off"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFAB2F] focus:border-transparent">
                </div>
                <button type="button" id="createModalButton" data-modal-target="createModal"
                    data-modal-toggle="createModal"
                    class="flex items-center justify-center text-white bg-[#FFAB2F] hover:bg-[#FF9D0A] focus:ring-4 focus:ring-[#FF9D0A] font-medium rounded-lg text-sm px-4 py-2 whitespace-nowrap">
                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Add user
                </button>
            </div>
        </form>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Username</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Email</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Role</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Create at</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img src="{{ $user->photo }}" alt="{{ $user->username }}"
                                        class="w-8 h-8 rounded-full object-cover mr-2">
                                    <div class="text-sm text-gray-900">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $user->username }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $user->email }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900 capitalize">{{ $user->role }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $user->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <button type="button"
                                        class="text-amber-600 hover:text-amber-800 cursor-pointer edit-user-btn"
                                        title="Edit" data-user-id="{{ $user->id }}"
                                        data-user-name="{{ $user->name }}" data-user-username="{{ $user->username }}"
                                        data-user-email="{{ $user->email }}" data-user-photo="{{ $user->photo }}"
                                        data-modal-target="updateModal" data-modal-toggle="updateModal">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button type="button"
                                        class="text-red-600 hover:text-red-800 cursor-pointer delete-user-btn"
                                        title="Delete" data-user-id="{{ $user->id }}"" data-modal-target="deleteModal"
                                        data-modal-toggle="deleteModal">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
    </div>
    <!-- Create modal -->
    <div id="createModal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
        data-backdrop-classes="bg-gray-900 bg-opacity-80 fixed inset-0 z-40"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative p-4 bg-white rounded-lg shadow sm:p-5">
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5">
                    <h3 class="text-lg font-semibold text-gray-900">Add User</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-target="createModal" data-modal-toggle="createModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex justify-center mb-4">
                        <div class="relative">
                            <img id="photoPreview"
                                src="https://res.cloudinary.com/dqsnhqpta/image/upload/v1763554774/default_rhbaay.png"
                                alt="Preview" class="w-32 h-32 rounded-full object-cover border-4 border-[#FFAB2F]">
                            <label for="photo"
                                class="absolute bottom-0 right-0 bg-[#FFAB2F] hover:bg-[#FF9D0A] text-white rounded-full p-2 cursor-pointer shadow-lg transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </label>
                        </div>
                    </div>
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <input type="file" name="photo" id="photo"
                                accept="image/jpeg,image/png,image/jpg,image/gif" class="hidden"
                                onchange="previewImage(event)">
                            @error('photo')
                                <p class="mt-1 text-sm text-red-500 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5"
                                placeholder="John Doe" required autocomplete="off"
                                oninput="updatePreviewName(this.value)">
                        </div>
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="username" id="username" value="{{ old('username') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5"
                                placeholder="johndoe" required autocomplete="off">
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5"
                                placeholder="john@example.com" required autocomplete="off">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5 pr-10"
                                    placeholder="••••••••" required autocomplete="off">
                                <button type="button" onclick="togglePassword('password', 'toggleIcon')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                    <svg id="toggleIcon" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Minimum 6 characters</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="submit"
                            class="text-white inline-flex items-center bg-[#FFAB2F] hover:bg-[#FF9D0A] focus:ring-4 focus:outline-none focus:ring-[#FF9D0A] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Add new user
                        </button>
                        <button type="button" data-modal-toggle="createModal"
                            class="text-gray-700 inline-flex items-center bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Update modal -->
    <div id="updateModal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
        data-backdrop-classes="bg-gray-900 bg-opacity-80 fixed inset-0 z-40"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative p-4 bg-white rounded-lg shadow sm:p-5">
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5">
                    <h3 class="text-lg font-semibold text-gray-900">Edit User</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="updateModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="updateUserForm"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" id="update-user-id">
                    <!-- Photo Preview Section -->
                    <div class="flex justify-center mb-4">
                        <div class="relative">
                            <img id="updatePhotoPreview"
                                src="https://ui-avatars.com/api/?name=User&background=FFAB2F&color=fff&size=128"
                                alt="Preview" class="w-32 h-32 rounded-full object-cover border-4 border-[#FFAB2F]">
                            <label for="update-photo"
                                class="absolute bottom-0 right-0 bg-[#FFAB2F] hover:bg-[#FF9D0A] text-white rounded-full p-2 cursor-pointer shadow-lg transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </label>
                        </div>
                    </div>
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <!-- Photo Input (Hidden) -->
                        <div class="sm:col-span-2">
                            <input type="file" name="photo" id="update-photo"
                                accept="image/jpeg,image/png,image/jpg" class="hidden"
                                onchange="previewUpdateImage(event)">
                            @error('photo')
                                <p class="mt-1 text-sm text-red-500 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="update-name" class="block mb-2 text-sm font-medium text-gray-900">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="update-name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5"
                                placeholder="John Doe" autocomplete="off" required
                                oninput="updatePreviewNameUpdate(this.value)">
                        </div>
                        <div>
                            <label for="update-username" class="block mb-2 text-sm font-medium text-gray-900">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="username" id="update-username"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5"
                                placeholder="johndoe" autocomplete="off" required>
                        </div>
                        <div>
                            <label for="update-email" class="block mb-2 text-sm font-medium text-gray-900">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="update-email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5"
                                placeholder="john@example.com" autocomplete="off" required>
                        </div>
                        <div>
                            <label for="update-password" class="block mb-2 text-sm font-medium text-gray-900">
                                Password
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="update-password"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5 pr-10"
                                    autocomplete="off">
                                <button type="button" onclick="togglePassword('update-password', 'updateToggleIcon')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                    <svg id="updateToggleIcon" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Leave blank to keep current password</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="submit"
                            class="text-white bg-[#FFAB2F] hover:bg-[#FF9D0A] focus:ring-4 focus:outline-none focus:ring-[#FF9D0A] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <svg class="inline-block mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd"
                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Save changes
                        </button>
                        <button type="button" id="deleteFromUpdate"
                            class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <svg class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewbox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Delete
                        </button>
                        <button type="button" data-modal-target="deleteModal" data-modal-toggle="updateModal"
                            data-user-id="{{ $user->id }}"
                            class="text-gray-700 inline-flex items-center bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete modal -->
    <div id="deleteModal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
        data-backdrop-classes="bg-gray-900 bg-opacity-90 fixed inset-0 z-40"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
                <button type="button"
                    class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-toggle="deleteModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <svg class="text-gray-400 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor"
                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <p class="mb-4 text-gray-500">Are you sure you want to delete this account?</p>
                <p class="mb-4 text-sm text-gray-400">This action cannot be undone.</p>
                <form action="" method="POST" id="deleteUserForm">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center items-center space-x-4">
                        <button data-modal-toggle="deleteModal" type="button"
                            class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 hover:text-gray-900 focus:z-10">
                            No, cancel
                        </button>
                        <button type="submit"
                            class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300">
                            Yes, I'm sure
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Create modal
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('photoPreview');

            if (file) {
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    alert('Only JPG, and PNG files are allowed');
                    event.target.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('createModal');
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.target.classList.contains('hidden')) {
                        // Reset form
                        document.getElementById('photo').value = '';
                        document.getElementById('photoPreview').src =
                            'https://res.cloudinary.com/dqsnhqpta/image/upload/v1763554774/default_rhbaay.png';
                    }
                });
            });
            observer.observe(modal, {
                attributes: true,
                attributeFilter: ['class']
            });
        });

        function previewUpdateImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('updatePhotoPreview');

            if (file) {
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    alert('Only JPG, and PNG files are allowed');
                    event.target.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        // Update modal
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-user-btn');
            const deleteFromUpdateBtn = document.getElementById('deleteFromUpdate');
            const deleteForm = document.getElementById('deleteUserForm');
            const updateModal = document.getElementById('updateModal');
            const deleteModal = document.getElementById('deleteModal');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const userName = this.getAttribute('data-user-name');
                    const userUsername = this.getAttribute('data-user-username');
                    const userEmail = this.getAttribute('data-user-email');
                    const userPhoto = this.getAttribute('data-user-photo');
                    const photoPreview = document.getElementById('updatePhotoPreview');

                    document.getElementById('updateUserForm').action =
                        `/admin/users/${userId}/update`;
                    document.getElementById('update-user-id').value = userId;
                    document.getElementById('update-name').value = userName;
                    document.getElementById('update-username').value = userUsername;
                    document.getElementById('update-email').value = userEmail;
                    document.getElementById('update-password').value = '';

                    if (userPhoto) {
                        photoPreview.src = userPhoto;
                    }

                    document.getElementById('update-photo').value = '';
                    if (deleteFromUpdateBtn) {
                        deleteFromUpdateBtn.setAttribute('data-user-id', userId);
                    }
                });
            });

            if (deleteFromUpdateBtn) {
                deleteFromUpdateBtn.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    deleteForm.action = `/admin/users/${userId}`;
                    updateModal.classList.add('hidden');
                    updateModal.classList.remove('flex');
                    deleteModal.classList.remove('hidden');
                    deleteModal.classList.add('flex');
                });
            }

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.target.classList.contains('hidden')) {
                        document.getElementById('update-photo').value = '';
                    }
                });
            });

            observer.observe(updateModal, {
                attributes: true,
                attributeFilter: ['class']
            });
        });

        // Delete modal
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-user-btn');
            const deleteForm = document.getElementById('deleteUserForm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    deleteForm.action = `/admin/users/${userId}`;
                });
            });
        });
    </script>
@endsection
