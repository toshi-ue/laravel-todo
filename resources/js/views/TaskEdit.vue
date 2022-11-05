<template>
    <!-- <div class="container content" :style="'min-height: ' + $store.state.rect.contentMinHeight + 'px'"> -->
    <div class="container content mt-4">
        <!-- TODO: エラ〜メッセージの多言語化 - front -->
        <!-- TODO: date-fns, vee-validateをグローバル化する -->
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <h2 class="card-header">TODO変更</h2>
                    <div class="card-body">
                        <ValidationObserver ref="observer" v-slot="{ invalid }">
                            <form v-on:submit.prevent="submit">
                                <div class="form-group row">
                                    <label for="id" class="col-3 col-form-label">ID</label>
                                    <input type="text" class="col-9 form-control-plaintext" readonly id="id"
                                        v-model="task.id" />
                                </div>
                                <!-- TODO: 文字数カウントを追加 -->
                                <div class="form-group row">
                                    <label for="description" class="col-sm-3 col-form-label">概要</label>
                                    <ValidationProvider rules="required|min:2|max:25" v-slot="{ errors }">
                                        <textarea class="col-sm-9 form-control" id="description"
                                            v-model="task.description" placeholder="概要" rows="2" autofocus />
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group row">
                                    <label for="done" class="col-sm-3 col-form-label">進捗</label>
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <select name="done" id="done" class="col-sm-9 form-control" v-model="task.done">
                                            <option value="0" v-bind:selected="task.done">
                                                未完了
                                            </option>
                                            <option value="1" v-bind:selected="task.done">
                                                完了
                                            </option>
                                        </select>
                                        <span>{{ errors[0] }}</span>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group row">
                                    <label for="created_at" class="col-sm-3 col-form-label">登録日</label>
                                    <p>{{ getFormattedTime(task.created_at) }}</p>
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
import { format } from "date-fns";
import { ja } from "date-fns/locale";
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
        getFormattedTime(time) {
            if (time) {
                return format(new Date(time), "M / dd (E)", { locale: ja });
            }
        },
        getTask() {
            axios.get("/api/tasks/" + this.taskId).then((res) => {
                this.task = res.data;
            });
        },
        submit() {
            // TODO: ボタンを連打できないようにする
            // TODO: サーバー側でのエラー時の対応
            // [【VeeValidate】バリデーションメッセージを削除する方法の紹介 – fumidzuki](https://fumidzuki.com/knowledge/2004/)
            axios.put("/api/tasks/" + this.taskId, this.task).then((res) => {
                this.$router.push({ name: "tasks" });
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
</style>
