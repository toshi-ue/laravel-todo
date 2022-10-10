<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <form v-on:submit.prevent="submit">
          <div class="form-group row">
            <label for="title" class="col-sm-3 col-form-label">Description</label>
            <input
              type="description"
              class="col-sm-9 form-control"
              id="description"
              v-model="task.description"
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
  data: function () {
    return {
      task: {},
    };
  },
  methods: {
    submit() {
      axios.post("/api/tasks", this.task).then((res) => {
        this.$router.push({ name: "task.list" });
      });
    },
  },
};
</script>
