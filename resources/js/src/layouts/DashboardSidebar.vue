<script setup>
import {inject, ref} from 'vue';
import useHttpRequest from '../composables/useHttpRequest';
import useUserStore from '../store/useUserStore';
import useRoleStore from '../store/useRoleStore';
import usePermissionStore from '../store/usePermissionStore';
import useAppRouter from '../composables/useAppRouter';
import PageLoader from './PageLoader.vue';
import SuspenseFallback from './SuspenseFallback.vue';

const asyncLoading = ref(false);

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
    console.log(isSidebarHidden.value);

}

// Toggle dropdown visibility
function toggleDropdown() {
    isDropdownHidden.value = !isDropdownHidden.value;
    isArrowRotated.value = !isArrowRotated.value;
}
</script>

<template>
    <div>
        <div class="relative flex min-h-screen ">
            <div class="
            bg-gray-600
            text-cyan-100
            w-64
            space-y-6
            px-2 py-4
            absolute
            inset-y-0
            left-0
            md:relative
            md:-translate-x-0
            transform
            -translate-x-full
            transition
            duration-200
            ease-in-out
            " :class="[ isSidebarHidden ? isSidebarHidden : 'relative -translate-x-0']"
            >
                <a href="#" class="flex items-center px-4 space-x-2 py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m21 7.5-2.25-1.313M21 7.5v2.25m0-2.25-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3 2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75 2.25-1.313M12 21.75V19.5m0 2.25-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25"/>
                    </svg>
                    <span class="text-2xl font-extrabold">QuickAssist</span>
                </a>

                <nav class="sidebar  overflow-y-auto text-center p-4">
                    <div class="text-gray-100 text-xl">
                        <div class="p-2.5 mt-1 flex items-center">
                            <div v-if="userStore.user?.id" class="text-xs text-emerald-300 flex justify-end" >
                                <h1 class="font-bold text-gray-200 text-[15px] ml-3">{{ `${userStore.user?.name} (${userStore.user?.email})` }}</h1>
                            </div>
<!--                            <i class="bi bi-x cursor-pointer ml-28 lg:hidden" @click="toggleSidebar()" ></i>-->
                        </div>
                        <div class="my-2 bg-gray-600 h-[1px]"></div>
                    </div>
                    <div class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer bg-gray-700 text-white" >
                        <i class="bi bi-search text-sm"></i>
                        <input type="text" placeholder="Search" class="text-[15px] ml-4 w-full bg-transparent focus:outline-none" />
                    </div>
                    <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white" >
                        <i class="bi bi-house-door-fill"></i>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>

                        <span class="text-[15px] ml-4 text-gray-200 font-bold">Dashboard</span>
                    </div>
                    <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white" >
                        <i class="bi bi-bookmark-fill"></i>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                        </svg>

                        <span class="text-[15px] ml-4 text-gray-200 font-bold">Bookmark</span>
                    </div>
                    <div class="my-4 bg-gray-900 h-[1px]"></div>
                    <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white" @click="toggleDropdown" >
                        <div class="flex justify-between w-full items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>

                            <span class="text-[15px] text-gray-200 font-bold ">User Control</span>
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
                    <div v-show="!isDropdownHidden" class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold"  id="submenu" >
                        <RouterLink :to="{ name: 'users' }">
                            <template v-slot="{ isActive }">
                                <h1 class="cursor-pointer p-2 hover:bg-blue-600  rounded-md mt-1"
                                    :class="[ isActive ? 'bg-blue-600' : 'hover:text-active-hover', ]">
                                    Users
                                </h1>
                            </template>
                        </RouterLink>

                        <RouterLink :to="{ name: 'roles' }">
                            <template v-slot="{ isActive }">
                                <h1 class="cursor-pointer p-2 hover:bg-blue-600  rounded-md mt-1"
                                    :class="[ isActive ? 'bg-blue-600' : 'hover:text-active-hover', ]">
                                    Roles
                                </h1>
                            </template>
                        </RouterLink>
                        <RouterLink :to="{ name: 'permissions' }">
                            <template v-slot="{ isActive }">
                                <h1 class="cursor-pointer p-2 hover:bg-blue-600  rounded-md mt-1"
                                    :class="[ isActive ? 'bg-blue-600' : 'hover:text-active-hover', ]">
                                    Permission
                                </h1>
                            </template>
                        </RouterLink>
                    </div>
                    <div class="my-4 bg-gray-600 h-[1px]"></div>

                    <div @click="onLogout" class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white" >
                        <i class="bi bi-box-arrow-in-right"></i>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>

                        <span class="text-[15px] ml-4 text-gray-200 font-bold" >Logout</span>
                    </div>




                </nav>
            </div>
            <div class="flex-1">
                <div class="bg-gray-500 text-gray-900 shadow px-2 py-4 " >

                    <!-- sun -->
                    <div class="flex-start gap-4 lg:gap-8">
                        <button @click="toggleSidebar()" class="font-extrabold">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 ">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
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
                </div>
                <div class="p-8 font-extrabold">

                    <main class="h-[calc(100%-80px)] w-full relative">
                        <PageLoader :loading="asyncLoading" />

                        <div class="container mx-auto max-w-[1172px] px-4 lg:px-0 h-full">
                            <RouterView v-slot="{ Component }">
                                <template v-if="Component">
                                    <Suspense
                                        @pending="asyncLoading = true"
                                        @resolve="asyncLoading = false"
                                    >
                                        <component :is="Component"></component>
                                        <template #fallback>
                                            <SuspenseFallback />
                                        </template>
                                    </Suspense>
                                </template>
                            </RouterView>
                        </div>
                    </main>

                </div>
            </div>
        </div>


<!--                <span-->
<!--                    class="absolute text-white text-4xl top-5 left-4 cursor-pointer"-->
<!--                    @click="toggleSidebar()">-->
<!--                    <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>-->
<!--                </span>-->
<!--                <div class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[300px] overflow-y-auto text-center bg-gray-900">-->
<!--                    <div class="text-gray-100 text-xl">-->
<!--                        <div class="p-2.5 mt-1 flex items-center">-->
<!--        &lt;!&ndash;                    <i class="bi bi-app-indicator px-2 py-1 rounded-md bg-blue-600"></i>&ndash;&gt;-->
<!--                            <div-->
<!--                                v-if="userStore.user?.id"-->
<!--                                class="text-xs text-emerald-300 flex justify-end"-->
<!--                            >-->
<!--                                <h1 class="font-bold text-gray-200 text-[15px] ml-3">{{ `${userStore.user?.name} (${userStore.user?.email})` }}</h1>-->

<!--                            </div>-->
<!--                            <i-->
<!--                                class="bi bi-x cursor-pointer ml-28 lg:hidden"-->
<!--                                @click="toggleSidebar()"-->
<!--                            ></i>-->
<!--                        </div>-->
<!--                        <div class="my-2 bg-gray-600 h-[1px]"></div>-->
<!--                    </div>-->
<!--                    <div-->
<!--                        class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer bg-gray-700 text-white"-->
<!--                    >-->
<!--                        <i class="bi bi-search text-sm"></i>-->
<!--                        <input-->
<!--                            type="text"-->
<!--                            placeholder="Search"-->
<!--                            class="text-[15px] ml-4 w-full bg-transparent focus:outline-none"-->
<!--                        />-->
<!--                    </div>-->
<!--                    <div-->
<!--                        class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"-->
<!--                    >-->
<!--                        <i class="bi bi-house-door-fill"></i>-->
<!--                        <span class="text-[15px] ml-4 text-gray-200 font-bold">Dashboard</span>-->
<!--                    </div>-->

<!--                    <div-->
<!--                        class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"-->
<!--                    >-->
<!--                        <i class="bi bi-bookmark-fill"></i>-->
<!--                        <span class="text-[15px] ml-4 text-gray-200 font-bold">Bookmark</span>-->
<!--                    </div>-->
<!--                    <div class="my-4 bg-gray-600 h-[1px]"></div>-->
<!--                    <div-->
<!--                        class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"-->
<!--                        @click="toggleDropdown"-->
<!--                    >-->
<!--                        <i class="bi bi-chat-left-text-fill"></i>-->
<!--                        <div class="flex justify-between w-full items-center">-->
<!--                            <span class="text-[15px] ml-4 text-gray-200 font-bold ">User Control</span>-->
<!--                            <span class="text-sm" v-if="!isArrowRotated">-->
<!--                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"-->
<!--                         width="24" height="24" fill="none" viewBox="0 0 24 24">-->
<!--                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
<!--                              d="m5 15 7-7 7 7"/>-->
<!--                    </svg>-->
<!--                  </span>-->
<!--                            <span class="text-sm" v-if="isArrowRotated">-->
<!--                               <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"-->
<!--                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">-->
<!--                                 <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>-->
<!--                                </svg>-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div v-show="!isDropdownHidden"-->
<!--                         class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold"-->
<!--                         id="submenu"-->
<!--                    >-->
<!--        &lt;!&ndash;                <h1 class="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">&ndash;&gt;-->
<!--        &lt;!&ndash;                    Users&ndash;&gt;-->
<!--        &lt;!&ndash;                </h1>&ndash;&gt;-->
<!--        &lt;!&ndash;                <h1 class="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">&ndash;&gt;-->
<!--        &lt;!&ndash;                    Roles&ndash;&gt;-->
<!--        &lt;!&ndash;                </h1>&ndash;&gt;-->
<!--        &lt;!&ndash;                <h1 class="cursor-pointer p-2 hover:bg-blue-600  rounded-md mt-1">&ndash;&gt;-->
<!--        &lt;!&ndash;                    Permission&ndash;&gt;-->
<!--        &lt;!&ndash;                </h1>&ndash;&gt;-->

<!--                        <RouterLink :to="{ name: 'users' }">-->
<!--                            <template v-slot="{ isActive }">-->
<!--                                <h1 class="cursor-pointer p-2 hover:bg-blue-600  rounded-md mt-1"-->
<!--                                    :class="[-->
<!--                                            isActive-->
<!--                                                ? 'bg-blue-600'-->
<!--                                                : 'hover:text-active-hover',-->
<!--                                        ]">-->
<!--                                    Users-->
<!--                                </h1>-->
<!--                            </template>-->
<!--                        </RouterLink>-->

<!--                        <RouterLink :to="{ name: 'roles' }">-->
<!--                            <template v-slot="{ isActive }">-->
<!--                                <h1 class="cursor-pointer p-2 hover:bg-blue-600  rounded-md mt-1"-->
<!--                                    :class="[-->
<!--                                            isActive-->
<!--                                                ? 'bg-blue-600'-->
<!--                                                : 'hover:text-active-hover',-->
<!--                                        ]">-->
<!--                                    Roles-->
<!--                                </h1>-->
<!--                            </template>-->
<!--                        </RouterLink>-->
<!--                        <RouterLink :to="{ name: 'permissions' }">-->
<!--                            <template v-slot="{ isActive }">-->
<!--                                <h1 class="cursor-pointer p-2 hover:bg-blue-600  rounded-md mt-1"-->
<!--                                    :class="[-->
<!--                                            isActive-->
<!--                                                ? 'bg-blue-600'-->
<!--                                                : 'hover:text-active-hover',-->
<!--                                        ]">-->
<!--                                    Permission-->
<!--                                </h1>-->
<!--                            </template>-->
<!--                        </RouterLink>-->
<!--                    </div>-->
<!--                    <div class="my-4 bg-gray-600 h-[1px]"></div>-->

<!--                    <div @click="onLogout"-->
<!--                        class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"-->
<!--                    >-->
<!--                        <i class="bi bi-box-arrow-in-right"></i>-->
<!--                        <span class="text-[15px] ml-4 text-gray-200 font-bold" >Logout</span>-->
<!--                    </div>-->
<!--                </div>-->
    </div>
</template>
../store/useAuthUserStore
