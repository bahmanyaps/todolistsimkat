<template lang="">
  <h1 class="text-center mt-5">ToDo List Skibidi</h1>
  <div class="container py-5">
    <button 
      class="btn btn-success rounded mb-3" 
      @click="openCreateModal()" 
      style="margin-left: 100px;">
      TAMBAH TUGAS
    </button>
    
    <div class="row">
      <div class="col-10 mx-auto bg-white rounded shadow">
        <div class="table-responsive">
          <table class="table table-fixed">
            <thead>
              <tr>
                <th scope="col">No.</th>
                <th scope="col">Tugas</th>
                <th scope="col">Prioritas</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(task, index) in tasks" :key="task.id">
                <td>{{ index + 1 }}</td>
                <td>{{ task.task_name }}</td>
                <td>{{ task.priority }}</td>
                <td>{{ task.date }}</td>
                <td>{{ task.status }}</td>
                <td>
                  <button 
                    v-if="task.status !== 'Selesai'" 
                    class="btn btn-sm btn-success" 
                    style="margin-right: 5px;" 
                    @click="updateTask(task)">
                    Selesai
                  </button>
                  <button 
                    class="btn btn-sm btn-danger" 
                    style="margin-right: 5px;" 
                    @click="deleteTask(task.id)">
                    Hapus
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">Menambah Tugas Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="registerUserForm" @submit.prevent="createTask">
            <div class="mb-2">
              <label for="job-name" class="form-label">Nama Tugas</label>
              <input 
                type="text" 
                v-model="newTask.task" 
                class="form-control" 
                placeholder="Masukkan nama tugas" 
                required>
            </div>
            <div class="mb-2">
              <label for="job-name" class="form-label">Prioritas</label>
              <select v-model="newTask.priority" class="form-control" required>
                <option value="" disabled selected>Pilih prioritas</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
              </select>
            </div>
            <div class="mb-2">
              <label class="form-label text-muted">Tanggal tugas</label>
              <input 
                type="date" 
                v-model="newTask.date" 
                class="shadow-none form-control" 
                :min="minDate" 
                required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="registerUserForm">
            Tambah
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      tasks: [],
      newTask: {
        task: '',
        priority: '',
        date: ''
      },
      minDate: '',
    }
  },
  mounted() {
    this.getTask();
    this.setMinDate();
  },
  methods: {
    getTask() {
      axios.get("http://localhost:8000/api/todolist")
        .then(response => {
          this.tasks = response.data;
        })
        .catch(error => {
          console.error(error);
        })
    },
    setMinDate() {
      const today = new Date();
      const year = today.getFullYear();
      const month = (today.getMonth() + 1).toString().padStart(2, '0');
      const day = today.getDate().toString().padStart(2, '0');
      this.minDate = `${year}-${month}-${day}`;
    },
    updateTask(task) {
      axios.patch(`http://localhost:8000/api/todolist/${task.id}`, {
        status: 'Selesai'
      })
        .then(response => {
          this.getTask();
        })
        .catch(error => {
          console.error(error);
        })
    },
    deleteTask(taskId) {
      axios.delete(`http://localhost:8000/api/todolist/${taskId}`)
        .then(response => {
          this.getTask();
        })
        .catch(error => {
          console.error(error);
        })
    },
    createTask() {
      const formData = new FormData();
      formData.append('task_name', this.newTask.task);
      formData.append('priority', this.newTask.priority);
      formData.append('date', this.newTask.date);

      axios.post('http://localhost:8000/api/todolist/', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        }
      })
        .then(response => {
          window.location.reload();
        })
        .catch(error => {
          console.error('There was an error!', error);
          alert('Error menambahkan tugas');
        });
    },
    openCreateModal() {
      const createModal = new bootstrap.Modal(document.getElementById('createModal'));
      createModal.show();
    },
  }
}
</script>