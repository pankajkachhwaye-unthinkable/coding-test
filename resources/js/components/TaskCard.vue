<template>
    <div class="w-full bg-white text-gray-900 shadow-md rounded-lg p-3 pb-8 mb-4 relative"
       
        @mouseenter="kanban.hoveredName = task.name" 
        @mouseleave="kanban.unhoverTask()"
        
       >
      
        <PencilSquareIcon 
                @click="editTask(task)" 
                class="mb-3 h-6 w-6 float-right hover:cursor-pointer" 
                aria-hidden="true" />
                <div  @click="kanban.selectTask(task)">
                     {{ task.name }}<br>
        <div class="text-xs text-gray-500 absolute bottom-2 ">{{ task.user.name }}</div>
        <img class="w-10 h-10 shadow-lg rounded-full absolute bottom-0 right-0 -mr-2 -mb-2 border-2 border-white"
            :src="getAvatar()" :alt="task.user.name" />
                </div>

       
    </div>
</template>

<script setup>
// get the props
import { useKanbanStore } from '../stores/kanban';
import { sha256 } from 'js-sha256';
import { PencilSquareIcon } from '@heroicons/vue/20/solid'
const kanban = useKanbanStore()

const getAvatar = function () {
    if (props.task.user.profile_picture_url !== null) {
        return props.task.user.profile_picture_url;
    } else {
        return ("https://www.gravatar.com/avatar/" + sha256(String(props.task.user.email).trim().toLowerCase()) + "?size=40");
    }
}
const editTask = function(task){
    console.log('task',task);
    console.log('adsa',kanban.creatingTask);
     kanban.editingTask = true;
        kanban.editingTaskProps = {
            id:task.id,
           name: task.name,
            phase_id: task.phase_id,
            user_id: task.user_id
        };
   // this.kanban.selectedTask(task)
    // this.selectedTask = task
//    console.log('a',id);
}

const props = defineProps({
    task: {
        type: Object,
        required: true
    }
})
</script>