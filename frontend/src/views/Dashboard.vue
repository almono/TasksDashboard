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
          <label class="mr-sm-2" for="projects-select">Project</label>
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
          <div class="col-12 px-0 mt-2">

          </div>
          <template v-if="tasksStore?.tasks && Object.keys(tasksStore?.tasks).length > 0">
            <draggable 
              v-model="tasksStore.tasks" 
              @start="data.drag=true" 
              @end="data.drag=false"
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
                </div>
              </template>
            </draggable>
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
  </div>
</template>

<script setup>
import { reactive, ref, watch } from 'vue'
import { useProjectsStore } from '../stores/projects/projects'
import { useTasksStore } from '../stores/tasks/tasks'

const tasksStore = useTasksStore();
const projectsStore = useProjectsStore();
const selectedProject = ref(null)

const data = reactive({
  drag: false
})

watch(selectedProject, async(newProject, oldProject) => {
  const response = await tasksStore.getTasksList({ project_id: newProject })
})

function updateTasksList() {
  console.log("TEST")
}

function addNewTask() {

}

</script>
<script>
import draggable from 'vuedraggable'

export default {
  name: "Dashboard",
  components: {
    draggable
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
</style>
  