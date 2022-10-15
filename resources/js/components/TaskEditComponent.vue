<template>
  <div class="container min-vh-100">
    <!-- TODO: フラッシュメッセージを追加する -->
    <!-- TODO: エラ〜メッセージの多言語化 - front -->
    <!-- TODO: date-fns, vee-validateをグローバル化する
     -->
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <div class="card">
          <!-- <h2 class="card-header">TODO編集</h2> -->
          <h2 class="card-header">{{ $t("task.title.edit") }}</h2>
          <div class="card-body">
            <ValidationObserver ref="observer" v-slot="{ invalid }">
              <form v-on:submit.prevent="submit">
                <div class="form-group row">
                  <label for="id" class="col-3 col-form-label">{{ $t("task.id") }}</label>
                  <input
                    type="text"
                    class="col-9 form-control-plaintext"
                    readonly
                    id="id"
                    v-model="task.id"
                  />
                </div>
                <!-- TODO: 文字数カウントを追加 -->
                <div class="form-group row">
                  <label for="description" class="col-sm-3 col-form-label">{{
                    $t("task.description")
                  }}</label>
                  <ValidationProvider rules="required|min:2|max:50" v-slot="{ errors }">
                    <textarea
                      class="col-sm-9 form-control"
                      id="description"
                      v-model="task.description"
                      :placeholder="$t('task.description')"
                      rows="2"
                      minlength="2"
                      maxlength="20"
                      autofocus
                    />
                    <span class="text-danger">{{ errors[0] }}</span>
                  </ValidationProvider>
                </div>
                <div class="form-group row">
                  <label for="done" class="col-sm-3 col-form-label">{{
                    $t("task.done")
                  }}</label>
                  <ValidationProvider rules="required" v-slot="{ errors }">
                    <select
                      name="done"
                      id="done"
                      class="col-sm-9 form-control"
                      v-model="task.done"
                    >
                      <option value="0" v-bind:selected="task.done">
                        {{ $t("task.status.undone") }}
                      </option>
                      <option value="1" v-bind:selected="task.done">
                        {{ $t("task.status.completed") }}
                      </option>
                    </select>
                    <span>{{ errors[0] }}</span>
                  </ValidationProvider>
                </div>
                <div class="form-group row">
                  <label for="created_at" class="col-sm-3 col-form-label">{{
                    $t("task.created_at")
                  }}</label>
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
                  {{ $t("task.button.update") }}
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
        this.task.description = "";
      });
    },
    submit() {
      // TODO: ボタンを連打できないようにする
      // TODO: サーバー側でのエラー時の対応
      // [【VeeValidate】バリデーションメッセージを削除する方法の紹介 – fumidzuki](https://fumidzuki.com/knowledge/2004/)
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
