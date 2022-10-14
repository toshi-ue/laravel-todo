<template>
  <div class="container min-vh-100">
    <!-- TODO: フラッシュメッセージを追加する -->
    <!--  -->
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <div class="card">
          <h2 class="card-header">TODO編集</h2>
          <div class="card-body">
            <ValidationObserver ref="observer" v-slot="{ invalid }">
              <form v-on:submit.prevent="submit">
                <div class="form-group row">
                  <label for="id" class="col-3 col-form-label">ID</label>
                  <input
                    type="text"
                    class="col-9 form-control-plaintext"
                    readonly
                    id="id"
                    v-model="task.id"
                  />
                </div>
                <div class="form-group row">
                  <label for="description" class="col-sm-3 col-form-label">詳細</label>

                  <ValidationProvider rules="required|min:2|max:50" v-slot="{ errors }">
                    <textarea
                      class="col-sm-9 form-control"
                      id="description"
                      v-model="task.description"
                      placeholder="詳細"
                      rows="2"
                      autofocus
                    />
                    <span>{{ errors[0] }}</span>
                  </ValidationProvider>
                </div>
                <div class="form-group row">
                  <label for="done" class="col-sm-3 col-form-label">Done</label>
                  <ValidationProvider rules="required" v-slot="{ errors }">
                    <select
                      name="done"
                      id="done"
                      class="col-sm-9 form-control"
                      v-model="task.done"
                    >
                      <option value="0" v-bind:selected="task.done">未完了</option>
                      <option value="1" v-bind:selected="task.done">完了</option>
                    </select>
                    <span>{{ errors[0] }}</span>
                  </ValidationProvider>
                </div>
                <div class="form-group row">
                  <label for="created_at" class="col-sm-3 col-form-label"
                    >Created At</label
                  >
                  <p>{{ task.created_at }}</p>
                  <!-- <input
              type="text"
              class="col-sm-9 form-control-plaintext"
              id="created_at"
              readonly
              v-model="task.created_at"
            /> -->
                </div>
                <button type="submit" class="btn btn-primary" :disabled="invalid">
                  更新
                </button>
              </form>
            </ValidationObserver>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ValidationObserver, ValidationProvider, extend } from "vee-validate";
import { max, min, required } from "vee-validate/dist/rules";

extend("max", max);
extend("min", min);
extend("required", required);

export default {
  props: {
    taskId: String,
  },
  components: {
    ValidationObserver,
    ValidationProvider,
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
  created() {
    this.getTask();
  },
};
</script>
<style>
:disabled {
  color: #fff;
  cursor: not-allowed;
  background-color: #434342;
}
.btn:hover:not([disabled]) {
}
</style>
