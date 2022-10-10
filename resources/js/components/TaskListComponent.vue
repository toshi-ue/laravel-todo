<template>
  <div class="container">
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Description</th>
          <th scope="col">Done</th>
          <th scope="col">Created at</th>
          <th scope="col">Show</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(task, index) in tasks" :key="index">
          <th scope="row">{{ task.id }}</th>
          <td>{{ task.description }}</td>
          <td>{{ task.done }}</td>
          <td>{{ task.created_at }}</td>
          <td>
            <router-link v-bind:to="{ name: 'task.show', params: { taskId: task.id } }">
              <button class="btn btn-primary">Show</button>
            </router-link>
          </td>
          <td>
            <router-link v-bind:to="{ name: 'task.edit', params: { taskId: task.id } }">
              <button class="btn btn-success">Edit</button>
            </router-link>
          </td>
          <td>
            <button class="btn btn-danger" v-on:click="deleteTask(task.id)">
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      tasks: [],
    };
  },
  methods: {
    getTasks() {
      axios.get("/api/tasks").then((res) => {
        this.tasks = res.data;
      });
    },
    deleteTask(id) {
      axios.delete("/api/tasks/" + id).then((res) => {
        this.getTasks();
      });
    },
  },
  mounted() {
    this.getTasks();
  },
};
</script>
