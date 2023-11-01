<template>
<div class="w-[300px] bg-sky-950 rounded-lg shadow-lg">
    <div class="py-4">
        <div class="flex items-center justify-between px-4">
            <h2 class="text-lg text-zinc-100 font-black mb-3">{{ kanban.phases[props.phase_id].name }} ({{kanban.phases[props.phase_id].tasks_count}})</h2>
           <span class="flex">
             <PlusIcon 
                @click="createTask()" 
                class="mb-3 h-6 w-6 text-white hover:cursor-pointer" 
                aria-hidden="true" />
                 <TrashIcon class="mb-3 h-6 w-6 text-white hover:cursor-pointer" @click="deletePhase(kanban.phases[props.phase_id].id)" /> 
                </span> 
           
               
        </div>
        <div class="px-4 overflow-auto phase-container">
            <task-card v-if="kanban.phases[props.phase_id].tasks.length > 0" v-for="task in kanban.phases[props.phase_id].tasks" :task="task" />
        </div>
        
        
        <!-- A card to create a new task -->
        <div class="p-4">
               <div class="w-full flex items-center justify-between bg-white text-gray-900 hover:cursor-pointer shadow-md rounded-lg p-3 relative"
            @click="createTask()">
            <span>Create a new task</span>
            <PlusIcon class="h-6 w-6" aria-hidden="true" />
        </div>
        </div>
     

    </div>
</div>
</template>

<script setup>
// get the props
import { useKanbanStore } from '../stores/kanban'
import { PlusIcon, TrashIcon } from '@heroicons/vue/20/solid'

const kanban = useKanbanStore()

const props = defineProps({
    phase_id: {
        type: Number,
        required: true
    },
})

const createTask = function () {
    kanban.creatingTask = true;
    kanban.creatingTaskProps.phase_id = props.phase_id;
}

const deletePhase = async function (id) {
   
   try {
        const response = await axios.delete('/api/phases/' + id);
        await refreshTasks();
        kanban.unselectTask();
    } catch (error) {
        console.error('There was an error deleting the task!', error);
    }
}


const refreshTasks = async () => {
    try {
        const response = await axios.get('/api/tasks');
        const originalTasks = response.data;
        kanban.phases = originalTasks.reduce((acc, cur) => {
            acc[cur.id] = cur;
            return acc;
        }, {});
      
    } catch (error) {
        console.error('There was an error fetching the tasks!', error);
    }
}


</script>
<style scoped>/* For Webkit-based browsers (Chrome, Safari and Opera) */

.phase-container{
    height: 350px;
}


:root {
  --primary: rebeccapurple;
  --secondary: cornflowerblue;
}

/* Scrollbar styles */

/* Firefox */
* {
  scrollbar-width: thin;
  scrollbar-color: var(--primary) var(--secondary);
}

/* Chrome, Edge, and Safari */
*::-webkit-scrollbar {
  width: 12px;
}

*::-webkit-scrollbar-track {
  background: var(--primary);
}

*::-webkit-scrollbar-thumb {
  background-color: var(--secondary);
/*   background: repeating-linear-gradient(
    45deg,
    var(--secondary),
    var(--secondary) 5px,
    var(--primary) 5px,
    var(--primary) 10px
  ); */
  border-radius: 20px;
  border: 3px solid var(--primary);
}

</style>