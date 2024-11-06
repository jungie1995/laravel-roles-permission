<script setup>
import { ref } from 'vue';

import DashboardHeader from './DashboardHeader.vue';
import PageLoader from './PageLoader.vue';
import SuspenseFallback from './SuspenseFallback.vue';
import DashboardSidebar from "./DashboardSidebar.vue";

const asyncLoading = ref(false);
</script>

<template>
    <div class="w-full">
        <!-- header -->
        <DashboardSidebar/>
<!--       <div class="container mx-auto">-->
<!--           <header-->
<!--               class="w-full bg-cc-10 h-20 min-h-[80px] sticky top-0 shadow-google z-10"-->
<!--           >-->
<!--               <DashboardHeader-->
<!--                   class="h-full container mx-auto flex-between max-w-[1172px] px-4 xl:px-0 gap-4 text-dark-color"-->
<!--               />-->
<!--               <DashboardSidebar-->
<!--                   class="h-full container mx-auto px-4 xl:px-0 text-dark-color"-->
<!--               />-->
<!--           </header>-->
<!--       </div>-->



    </div>
</template>
