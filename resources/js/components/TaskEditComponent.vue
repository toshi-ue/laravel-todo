<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <form v-on:submit.prevent="submit">
          <div class="form-group row">
            <label for="id" class="col-sm-3 col-form-label">ID</label>
            <input
              type="text"
              class="col-sm-9 form-control-plaintext"
              readonly
              id="id"
              v-model="task.id"
            />
          </div>
          <div class="form-group row">
            <label for="description" class="col-sm-3 col-form-label">description</label>
            <input
              type="text"
              class="col-sm-9 form-control"
              id="description"
              v-model="task.description"
            />
          </div>
          <div class="form-group row">
            <label for="done" class="col-sm-3 col-form-label">Done</label>
            <input
              type="text"
              class="col-sm-9 form-control"
              id="content"
              v-model="task.done"
            />
          </div>
          <div class="form-group row">
            <label for="created_at" class="col-sm-3 col-form-label">Created At</label>
            <input
              type="text"
              class="col-sm-9 form-control-plaintext"
              id="created_at"
              readonly
              v-model="task.created_at"
            />
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    taskId: String,
  },
  data: function () {
    return {
      task: {},
    };
  },
  methods: {
    getTask() {
      axios.get("/api/tasks/" + this.taskId).then((res) => {
        this.task = res.data;
      });
    },
    submit() {
      axios.put("/api/tasks/" + this.taskId, this.task).then((res) => {
        this.$router.push({ name: "task.list" });
      });
    },
  },
  mounted() {
    this.getTask();
  },
};
</script>
