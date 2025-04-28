<template>
  <div class="modal-overlay">
    <div class="modal">
      <h2>Edit Task ( ID: {{ task.id }} )</h2>
      <BForm @submit.prevent="submitUpdate">
        <label class="mr-sm-2 header-text" for="input-1">Task Name</label>
        <BFormInput
          id="input-1"
          v-model="task.name"
          type="text"
          placeholder="Task Name"
          class="task-input px-2"
          required
        />
        <label class="mr-sm-2 header-text mt-2" for="input-2">Task Description</label>
        <BFormInput
          id="input-2"
          v-model="task.description"
          type="text"
          placeholder="Task Description"
          class="task-input px-2"
        />
        <div class="col-12 text-right">
          <BButton type="submit" pill variant="primary" :disabled="isProcessing">Confirm</BButton>
          <BButton @click="closeModal" type="button" pill variant="danger" :disabled="isProcessing">Cancel</BButton>
        </div>
      </BForm>
    </div>
  </div>
</template>
  
<script setup>
import { defineProps, defineEmits, ref } from 'vue';

const props = defineProps({
  task: Object,
});

const isProcessing = ref(false)
const emit = defineEmits(['updateTaskData', 'closeModal', 'get']);

async function submitUpdate() {
  isProcessing.value = true
  await emit('updateTask', props.task)
  await emit('refreshTaskData')
  isProcessing.value = false
  emit('closeModal')
};

function closeModal(e) {
  e.preventDefault() // prevent refresh
  emit('closeModal')
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.modal {
  display: block;
  position: relative;
  background: white;
  padding: 20px;
  border-radius: 5px;
  width: 400px;
  min-height: 250px;
  z-index: 10000;
  height: auto;
}

button {
  margin-top: 10px;
}
</style>
