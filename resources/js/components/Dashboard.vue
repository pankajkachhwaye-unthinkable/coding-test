<template>
    <div class="max-w-7xl flex-1 mx-auto flex flex-col overflow-auto sm:px-6 lg:px-8">
        

        <div id="dashboard-container" class="flex-1 flex overflow-auto w-full scrollbar-hide shadow-lg">
            <div class="text-gray-900 w-full">
                <div class="h-full w-full flex overflow-x-auto overflow-y-auto space-x-4">
                   <div class="flex flex-wrap mb-2 w-full">
                        <div class="w-full md:w-1/2 xl:w-1/3 pt-3 px-3 md:pr-2">
                            <div class="bg-green-600 border rounded shadow p-2">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pl-1 pr-4"><i class="fa fa-wallet fa-2x fa-fw fa-inverse"></i></div>
                                    <div class="flex-1 text-right">
                                        <h5 class="text-white">Completed this week</h5>
                                        <h3 class="text-white text-3xl">{{dashboard.week_count}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-full md:w-1/2 xl:w-1/3 pt-3 px-3 md:pr-2 xl:pr-3 xl:pl-1">
                            <div class="bg-orange-600 border rounded shadow p-2">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pl-1 pr-4"><i class="fas fa-user-plus fa-2x fa-fw fa-inverse"></i></div>
                                    <div class="flex-1 text-right pr-1">
                                        <h5 class="text-white">Completed this month</h5>
                                        <h3 class="text-white text-3xl">{{dashboard.month_count}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="w-full md:w-1/2 xl:w-1/3 pt-3 px-3 md:pr-2 xl:pl-2 xl:pr-3">
                            <div class="bg-red-600 border rounded shadow p-2">
                                <div class="flex flex-row items-center">
                                    <div class="flex-shrink pl-1 pr-4"><i class="fas fa-tasks fa-2x fa-fw fa-inverse"></i></div>
                                    <div class="flex-1 text-right">
                                        <h5 class="text-white">Pending </h5>
                                        <h3 class="text-white text-3xl">{{dashboard.pending_count}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- <task-column v-for="col in kanban.phases" :phase_id="col.id"></task-column> -->
                </div>
                
            </div>
        
        </div>

        
    </div>
    <section class="container px-4 mx-auto">
    <div class="flex flex-col">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                   <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                         <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                         User Statics
                    </h2>
                   </div>
                   
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                             

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Name
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Email
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Profile
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                   Task Assigned
                                 
                                </th>

                                
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                            <!-- <tr > -->
                            <tr v-if="dashboard.users.length > 0" v-for="user in dashboard.users" >
                                <td class="px-4 py-4 text-sm font-medium text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                      <h2 class="text-sm font-medium text-gray-800 dark:text-white ">{{user.name}}</h2>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                    {{user.email}}
                                    </td>
                               
                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                    <div class="flex items-center gap-x-2">
                                        <img class="object-cover w-8 h-8 rounded-full" :src="getAvatar(user)" :alt="user.name" >
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{user.tasks_count}}</td>
                               
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   
</section>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'
import { useDashboardStore } from '../stores/dashboard'
import { DialogTitle, Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon, TrashIcon } from '@heroicons/vue/20/solid'
import { sha256 } from 'js-sha256';


const dashboard = useDashboardStore()
const selected = ref(null)
const errors = ref(null)


const getAvatar = function (user) {
    if (user.profile_picture_url !== null) {
        return user.profile_picture_url;
    } else {
        return ("https://www.gravatar.com/avatar/" + sha256(String(user.email).trim().toLowerCase()) + "?size=400");
    }
}



const getError = function (field) {
    if (errors.value && errors.value[field]) {
        return errors.value[field][0].message;
    }
    return null;
}

const hasError = function (field) {
    if (errors.value && errors.value[field]) {
        return true;
    }
    return false;
}



const refreshDashboard = async () => {
    try {
        const response = await axios.get('/api/dashboard');
        const originalData = response.data;
        dashboard.users = originalData.user
        dashboard.week_count = originalData.week_count
        dashboard.month_count = originalData.month_count
        dashboard.pending_count = originalData.pending_count
       
    } catch (error) {
        console.error('There was an error fetching the tasks!', error);
    }
}

onMounted(async () => {

    await refreshDashboard();
    // await refreshUsers();
    // await getSelf();

    await nextTick();

    // ele = document.getElementById('kanban-container');
    // if (ele) {
    //     ele.style.cursor = 'grab';
    //     ele.addEventListener('mousedown', mouseDownHandler);
    // }

})


</script>

<style scoped>/* For Webkit-based browsers (Chrome, Safari and Opera) */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* For IE, Edge and Firefox */
.scrollbar-hide {
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
    /* Firefox */
}
.phase-container{
    height: 400px;
}
</style>