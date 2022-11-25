<template>
  <div
    class="container"
    :style="'min-height: ' + $store.state.rect.contentMinHeight + 'px'"
  >
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">TODO詳細</h4>
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th>ID</th>
                  <td>{{ task.id }}</td>
                </tr>
                <tr>
                  <th>詳細</th>
                  <td>{{ task.description }}</td>
                </tr>
                <tr>
                  <th>進捗</th>
                  <td>
                    <span v-if="task.done === '0'">未完了</span>
                    <span v-else>完了</span>
                  </td>
                </tr>
                <tr>
                  <th>作成日</th>
                  <td>{{ getFormattedTime(task.created_at) }}</td>
                </tr>
              </table>
            </div>
            <div class="text-right">
              <router-link v-bind:to="{ name: 'task.edit', params: { taskId: task.id } }">
                <button class="btn btn-success">変更</button>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { format } from "date-fns";
import { ja } from "date-fns/locale";

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
    getFormattedTime(time) {
      if (time) {
        return format(new Date(time), "M / dd (E)", { locale: ja });
      }
    },
  },
  created() {
    this.getTask();
  },
};
</script>
