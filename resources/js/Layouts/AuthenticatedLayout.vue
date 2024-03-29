<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link,usePage } from '@inertiajs/vue3';
import FlashMessage from '@/Components/Flash.vue';

const showingNavigationDropdown = ref(false);

const permissions = ref(usePage().props.auth.user_role_permissions);

const getPermission = (data) => {
    return permissions.value.find((permission) =>
        permission.toLowerCase().includes(data)
    ) ? true : false;
}
</script>

<template>
    <div>
       <!--  <Banner /> -->
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 lg:flex">
                                <NavLink :href="route('clients.index')" :active="route().current('clients.index')" v-if="getPermission('view clients')">
                                    Clients
                                </NavLink>
                                <NavLink :href="route('coaches.index')" :active="route().current('coaches.index')" v-if="getPermission('view coaches')">
                                    Coaches
                                </NavLink>
                                <NavLink :href="route('users.index')" :active="route().current('users.index')" v-if="getPermission('view users')">
                                    Users
                                </NavLink>
                                <NavLink :href="route('gyms.index')" :active="route().current('gyms.index')" v-if="getPermission('view gyms')">
                                    Gyms
                                </NavLink>
                                <NavLink :href="route('training-sessions.index')" :active="route().current('training-sessions.index')" v-if="getPermission('view training sessions')">
                                    Sessions
                                </NavLink>
                                <div class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out"
                                    v-if="getPermission('view suscriptions') || getPermission('view purchases')"
                                >
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                                >
                                                    Financials

                                                    <svg
                                                        class="ml-2 -mr-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>
                                        <template #content>
                                            <DropdownLink :href="route('suscriptions.index')" :active="route().current('suscriptions.index')" v-if="getPermission('view suscriptions')">
                                                Suscriptions 
                                            </DropdownLink>
                                            <DropdownLink :href="route('purchases.index')" :active="route().current('purchases.index')" v-if="getPermission('view purchases')">
                                                Purchases
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                                <NavLink :href="route('products.index')" :active="route().current('products.index')" v-if="getPermission('view products')">
                                    Products
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden lg:flex lg:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center lg:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="lg:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('clients.index')" :active="route().current('clients.index')" v-if="getPermission('view clients')">
                            Clients
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('coaches.index')" :active="route().current('coaches.index')" v-if="getPermission('view coaches')">
                            Coaches
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('users.index')" :active="route().current('users.index')" v-if="getPermission('view users')">
                            Users
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('gyms.index')" :active="route().current('gyms.index')" v-if="getPermission('view gyms')">
                            Gyms
                        </ResponsiveNavLink >
                        <ResponsiveNavLink :href="route('training-sessions.index')" :active="route().current('training-sessions.index')" v-if="getPermission('view training sessions')">
                            Training Sessions
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('products.index')" :active="route().current('products.index')" v-if="getPermission('view products')">
                            Products
                        </ResponsiveNavLink>
                        <!-- Responsive Financial Options -->
                        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                            <div class="px-4">
                                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                    Financials
                                </div>
                            </div>
                            <div class="mt-3 space-y-1">
                                <ResponsiveNavLink :href="route('suscriptions.index')" :active="route().current('suscriptions.index')" v-if="getPermission('view suscriptions')"> 
                                    Suscriptions 
                                </ResponsiveNavLink>
                                <ResponsiveNavLink :href="route('purchases.index')" :active="route().current('purchases.index')" v-if="getPermission('view purchases')">
                                    Purchases
                                </ResponsiveNavLink>
                            </div>
                        </div>
                       
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white dark:bg-gray-800 shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
        <flash-message />
    </div>
</template>
