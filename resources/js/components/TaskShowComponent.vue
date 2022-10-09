<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <form>
          <div class="form-group row border-bottom">
            <label for="id" class="col-sm-3 col-form-label">ID</label>
            <input
              type="text"
              class="col-sm-9 form-control-plaintext"
              readonly
              id="id"
              v-model="task.id"
            />
          </div>
          <div class="form-group row border-bottom">
            <label for="description" class="col-sm-3 col-form-label">Description</label>
            <input
              type="text"
              class="col-sm-9 form-control-plaintext"
              readonly
              id="description"
              v-model="task.description"
            />
          </div>
          <div class="form-group row border-bottom">
            <label for="done" class="col-sm-3 col-form-label">Done</label>
            <select name="done" id="done" class="form-control" v-model="task.done">
              <option value="0" v-bind:selected="task.done">未完了</option>
              <option value="1" v-bind:selected="task.done">完了</option>
            </select>
          </div>
          <div class="form-group row border-bottom">
            <label for="created_at" class="col-sm-3 col-form-label">Created at</label>
            {{ task.created_at }}
          </div>
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
  },
  mounted() {
    this.getTask();
  },
};
</script>
