<script setup>
import {inject, ref} from 'vue';
import useHttpRequest from '../composables/useHttpRequest';
import useUserStore from '../store/useUserStore';
import useRoleStore from '../store/useRoleStore';
import usePermissionStore from '../store/usePermissionStore';
import useAppRouter from '../composables/useAppRouter';

const {isDarkMode, updateDarkMode, windowWidth} = inject('theme');

const {index: logout} = useHttpRequest('/logout');
const {pushToRoute} = useAppRouter();

const userStore = useUserStore();
const roleStore = useRoleStore();
const permissionStore = usePermissionStore();

const onLogout = async () => {
    const isLoggedOut = await logout();
    if (isLoggedOut) {
        userStore.setUser(null);
        userStore.users = [];
        roleStore.roles = [];
        permissionStore.permissions = [];

        await pushToRoute({name: 'login'});
    }
};

// Reactive state for sidebar and submenu visibility
const isSidebarHidden = ref(true);
const isDropdownHidden = ref(true);
const isArrowRotated = ref(false);

// Toggle sidebar visibility
function toggleSidebar() {
    isSidebarHidden.value = !isSidebarHidden.value;
}

// Toggle dropdown visibility
function toggleDropdown() {
    isDropdownHidden.value = !isDropdownHidden.value;
    isArrowRotated.value = !isArrowRotated.value;
}
</script>

<template>
    <div>


        <!-- logo -->
        <RouterLink :to="{ name: 'users' }">
            <div class="text-3xl font-nabla hidden md:block">
                <span class="logo-char animation-delay-100">R</span>
                <span class="logo-char animation-delay-200">o</span>
                <span class="logo-char animation-delay-300">l</span>
                <span class="logo-char animation-delay-400">e</span>
                <span class="">{{ ' ' }}</span>
                <span class="logo-char animation-delay-500">P</span>
                <span class="logo-char animation-delay-600">e</span>
                <span class="logo-char animation-delay-700">r</span>
                <span class="logo-char animation-delay-800">m</span>
                <span class="logo-char animation-delay-900">i</span>
                <span class="logo-char animation-delay-1000">s</span>
                <span class="logo-char animation-delay-1100">s</span>
                <span class="logo-char animation-delay-1200">i</span>
                <span class="logo-char animation-delay-1300">o</span>
                <span class="logo-char animation-delay-1400">n</span>
                <span class="logo-char animation-delay-1500">s</span>
            </div>
            <div class="text-2xl font-nabla md:hidden">
                <span class="logo-char animation-delay-100">R</span>
                <span class="">{{ ' ' }}</span>
                <span class="logo-char animation-delay-200">P</span>
            </div>
        </RouterLink>

        <!-- menu links -->

        <div class="flex-start gap-4 lg:gap-8">
            <div class="flex flex-col gap-0.5">
                <div class="flex-start gap-6 lg:gap-8">
                    <RouterLink :to="{ name: 'users' }">
                        <template v-slot="{ isActive }">
                            <span
                                class="lg:text-lg font-bold"
                                :class="[
                                    isActive
                                        ? 'text-active'
                                        : 'hover:text-active-hover',
                                ]"
                            >Users</span
                            >
                        </template>
                    </RouterLink>

                    <RouterLink :to="{ name: 'roles' }">
                        <template v-slot="{ isActive }">
                            <span
                                class="lg:text-lg font-bold"
                                :class="[
                                    isActive
                                        ? 'text-active'
                                        : 'hover:text-active-hover',
                                ]"
                            >Roles</span
                            >
                        </template>
                    </RouterLink>

                    <RouterLink :to="{ name: 'permissions' }">
                        <template v-slot="{ isActive }">
                            <span
                                class="lg:text-lg font-bold"
                                :class="[
                                    isActive
                                        ? 'text-active'
                                        : 'hover:text-active-hover',
                                ]"
                            >Permissions</span
                            >
                        </template>
                    </RouterLink>

                    <span
                        class="lg:text-lg font-bold hover:text-active-hover cursor-pointer text-red-200"
                        @click="onLogout"
                    >
                        Logout
                    </span>
                </div>

                <div
                    v-if="userStore.user?.id"
                    class="text-xs text-emerald-300 flex justify-end"
                >
                    {{ `${userStore.user?.name} (${userStore.user?.email})` }}
                </div>
            </div>

            <!-- sun -->
            <span
                v-if="isDarkMode"
                class="hover:text-active-hover cursor-pointer"
                @click="updateDarkMode(false)"
            >
                <svg
                    viewBox="0 0 24 24"
                    :width="windowWidth > 992 ? 24 : 18"
                    :height="windowWidth > 992 ? 24 : 18"
                    stroke="currentColor"
                    stroke-width="2"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="css-i6dzq1"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="5"
                    ></circle>
                    <line
                        x1="12"
                        y1="1"
                        x2="12"
                        y2="3"
                    ></line>
                    <line
                        x1="12"
                        y1="21"
                        x2="12"
                        y2="23"
                    ></line>
                    <line
                        x1="4.22"
                        y1="4.22"
                        x2="5.64"
                        y2="5.64"
                    ></line>
                    <line
                        x1="18.36"
                        y1="18.36"
                        x2="19.78"
                        y2="19.78"
                    ></line>
                    <line
                        x1="1"
                        y1="12"
                        x2="3"
                        y2="12"
                    ></line>
                    <line
                        x1="21"
                        y1="12"
                        x2="23"
                        y2="12"
                    ></line>
                    <line
                        x1="4.22"
                        y1="19.78"
                        x2="5.64"
                        y2="18.36"
                    ></line>
                    <line
                        x1="18.36"
                        y1="5.64"
                        x2="19.78"
                        y2="4.22"
                    ></line>
                </svg>
            </span>

            <span
                v-else
                class="hover:text-active-hover cursor-pointer"
                @click="updateDarkMode(true)"
            >
                <svg
                    viewBox="0 0 24 24"
                    :width="windowWidth > 992 ? 24 : 18"
                    :height="windowWidth > 992 ? 24 : 18"
                    stroke="currentColor"
                    stroke-width="2"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="css-i6dzq1"
                >
                    <path
                        d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"
                    ></path>
                </svg>
            </span>
        </div>


        <span
            class="absolute text-white text-4xl top-5 left-4 cursor-pointer"
            @click="toggleSidebar()">
            <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>
        </span>
        <div class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[300px] overflow-y-auto text-center bg-gray-900">
            <div class="text-gray-100 text-xl">
                <div class="p-2.5 mt-1 flex items-center">
<!--                    <i class="bi bi-app-indicator px-2 py-1 rounded-md bg-blue-600"></i>-->
                    <div
                        v-if="userStore.user?.id"
                        class="text-xs text-emerald-300 flex justify-end"
                    >
                        <h1 class="font-bold text-gray-200 text-[15px] ml-3">{{ `${userStore.user?.name} (${userStore.user?.email})` }}</h1>

                    </div>
                    <i
                        class="bi bi-x cursor-pointer ml-28 lg:hidden"
                        @click="toggleSidebar()"
                    ></i>
                </div>
                <div class="my-2 bg-gray-600 h-[1px]"></div>
            </div>
            <div
                class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer bg-gray-700 text-white"
            >
                <i class="bi bi-search text-sm"></i>
                <input
                    type="text"
                    placeholder="Search"
                    class="text-[15px] ml-4 w-full bg-transparent focus:outline-none"
                />
            </div>
            <div
                class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"
            >
                <i class="bi bi-house-door-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Home</span>
            </div>
            <div
                class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"
            >
                <i class="bi bi-bookmark-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Bookmark</span>
            </div>
            <div class="my-4 bg-gray-600 h-[1px]"></div>
            <div
                class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"
                @click="toggleDropdown"
            >
                <i class="bi bi-chat-left-text-fill"></i>
                <div class="flex justify-between w-full items-center">
                    <span class="text-[15px] ml-4 text-gray-200 font-bold ">User Control</span>
                    <span class="text-sm" v-if="!isArrowRotated">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m5 15 7-7 7 7"/>
            </svg>
          </span>
                    <span class="text-sm" v-if="isArrowRotated">
                       <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                        </svg>
                    </span>
                </div>
            </div>
            <div v-show="!isDropdownHidden"
                 class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold"
                 id="submenu"
            >
                <h1 class="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">
                    Users
                </h1>
                <h1 class="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">
                    Roles
                </h1>
                <h1 class="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">
                    Permission
                </h1>
            </div>
            <div class="my-4 bg-gray-600 h-[1px]"></div>

            <div
                class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"
            >
                <i class="bi bi-box-arrow-in-right"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold" @click="onLogout">Logout</span>
            </div>
        </div>


    </div>
</template>
../store/useAuthUserStore
