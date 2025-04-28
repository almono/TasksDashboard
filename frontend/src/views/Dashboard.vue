<template>
  <div>
    <BCard
      :title="'Dashboard'"
      tag="article"
      style="max-width: 90vw"
      class="mx-auto my-auto text-left d-flex align-center justify-center register-card"
    >
      <BCardText class="align-right card-body-content mt-2">
        <div class="col-12 px-0 my-2" v-if="projectsStore?.projectsList">
          <label class="mr-sm-2 header-text" for="projects-select">Project</label>
          <BFormSelect 
            v-model="selectedProject"
            id="projects-select"
            :options="projectsStore.projectsList" 
            value-field="id"
            text-field="name">
          </BFormSelect>
        </div>
        <hr class="task-line" />
        <template class="mt-2" v-if="selectedProject">
          <div class="col-sm-6 col-lg-5 px-0 mt-2">
            <span class="header-text">Add New Task</span>
            <BForm inline @submit.prevent="addNewTask()">
              <BInputGroup class="mt-1 mb-2">
                <BFormInput
                  id="input-1"
                  v-model="newTask.name"
                  type="text"
                  placeholder="Task Name"
                  class="task-input px-2"
                  required
                />
                <BFormInput
                  id="input-2"
                  v-model="newTask.description"
                  type="text"
                  placeholder="Task Description"
                  class="task-input px-2"
                  required
                />
                <BFormInput
                  id="input-3"
                  v-model="newTask.priority"
                  type="number"
                  placeholder="Task Priority"
                  class="task-input px-2"
                  min="1"
                  required
                />
                <div class="task-input text-center align-items-center justify-content-center d-flex">
                  <BButton pill variant="primary" type="submit" v-if="!data.requestProcessing">Create Task</BButton>
                  <BButton pill variant="primary" v-else :disabled="true">Processing...</BButton>
                </div>
              </BInputGroup>
            </BForm>
          </div>
          <hr class="task-line" />
          <template v-if="tasksStore?.tasks && Object.keys(tasksStore?.tasks).length > 0 && !loadingTasks">
            <draggable 
              v-model="tasksStore.tasks" 
              @end="updateTasksList"
              @change="updateTasksList"
              item-key="id"
            >
              <template #item="{element}">
                <div class="col-3 d-block px-2 task-main my-2">
                  <div class="col-12 px-0 task-title">
                    {{ element.name }}
                  </div>
                  <hr class="task-line" />
                  <div class="col-12 px-0 task-desc">
                    {{ element.description }}
                  </div>
                  <hr class="task-line" />
                  <div class="col-12 px-0 mb-2 mt-1 task-desc">
                    <BButton pill variant="secondary" @click="openEditTaskModal(element)" :disabled="data.requestProcessing">Edit</BButton>
                    <BButton pill variant="danger" @click="deleteTask(element.id)" :disabled="data.requestProcessing">Delete</BButton>
                  </div>
                </div>
              </template>
            </draggable>
          </template>
          <template v-else-if="loadingTasks">
            <div class="col-12 px-2">Tasks are being loaded....</div>
          </template>
          <template v-else>
            <div class="col-12 px-2">No tasks are present for selected project!</div>
          </template>
        </template>
        <template v-else>
          <div class="text-red text-left">Please select project to view the tasks list</div>
        </template>
      </BCardText>
    </BCard>
    <edit-task-modal
      v-if="isModalOpen"
      :task="selectedTask"
      @updateTask="updateTaskData"
      @closeModal="closeModal"
      @refreshTaskData="refreshTaskData"
    />
  </div>
</template>

<script setup>
import { reactive, ref, watch } from 'vue'
import { useProjectsStore } from '../stores/projects/projects'
import { useTasksStore } from '../stores/tasks/tasks'
import EditTaskModal from '../components/EditTaskModal.vue';

const tasksStore = useTasksStore();
const projectsStore = useProjectsStore();
const selectedProject = ref(null)

const data = reactive({
  requestProcessing: false,
  loadingTasks: false
})

const newTask = reactive({
  name: null,
  description: null,
  priority: null
})

const isModalOpen = ref(false);
const selectedTask = ref(null)

watch(selectedProject, async(newProject, oldProject) => {
  data.loadingTasks = true
  const response = await tasksStore.getTasksList({ project_id: newProject })
  data.loadingTasks = false
})

async function updateTasksList() {
  data.requestProcessing = true

  tasksStore.tasks.forEach(async (task, index) => {
    task = { ...task, priority: index + 1 } // update each tasks index ( add 1 to avoid 0 priority )
    await tasksStore.updateTask(task.id, task)
  })
  
  data.requestProcessing = false
}

async function addNewTask() {
  data.requestProcessing = true
  newTask.project_id = selectedProject
  await tasksStore.createTask(newTask)
  await tasksStore.getTasksList({ project_id: selectedProject.value })
  data.requestProcessing = false
}

async function deleteTask(taskId) {
  data.requestProcessing = true
  await tasksStore.deleteTask(taskId)
  await tasksStore.getTasksList({ project_id: selectedProject.value })
  data.requestProcessing = false
}

async function updateTaskData(task) {
  await tasksStore.updateTask(task.id, task)
}

function openEditTaskModal(task) {
  selectedTask.value = { ...task }; // we are copying the values to not update the original task until confirmed
  isModalOpen.value = true;
}

function closeModal() {
  isModalOpen.value = false;
}

async function refreshTaskData() {
  await tasksStore.getTasksList({ project_id: selectedProject.value })
}

</script>
<script>
import draggable from 'vuedraggable'

export default {
  name: "Dashboard",
  components: {
    draggable
  },
  methods: {
    checkTaskOrder: function(evt){
      console.log(evt.draggedContext.element)

      const index = tasks.findIndex(task => task.id === targetId);
      console.log(index); // Output: 1
    }
  }
};
</script>
  
<style scoped>

h2 {
  color: #42b983;
}

.card-body > h4 {
  font-size: 30px !important;
}

.register-card {
  box-shadow: 3px 3px 3px rgba(201, 201, 201, 0.438);
}

.card-body-content {
  border-top: 1px solid rgba(128, 128, 128, 0.548);
}

.task-main {
  border: 1px solid rgba(128, 128, 128, 0.788);
  border-radius: 5px;
  cursor: pointer;
}

.task-title {
  font-weight: 600;
  color: black;
}

.task-line {
  margin-top: 5px;
  margin-bottom: 5px;
}

.task-desc {

}

.task-input {
  border-radius: 0px;
  padding-left: 5px;
  color: rgb(90, 90, 90) !important;
  height: 3rem;
  border: 0px 0px 1px 1px gray solid;
}

.header-text {
  font-weight: 600;
}
</style>
  