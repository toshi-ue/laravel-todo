<template>
    <!-- <div class="container content" :style="'min-height: ' + $store.state.rect.contentMinHeight + 'px'"> -->
    <div class="container content mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <h2 class="card-header">TODO変更</h2>
                    <div class="card-body">
                        <ValidationObserver ref="observer" v-slot="{ invalid }">
                            <form v-on:submit.prevent="submit">
                                <div class="form-group row">
                                    <div class="row col-10 offset-1">
                                        <label for="id" class="col-3 col-form-label">ID</label>
                                        <input type="text" class="col-9 form-control-plaintext" readonly id="id"
                                            v-model="task.id" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="row col-10 offset-1">
                                        <label for="description" class="col-12 col-form-label">概要</label>
                                        <div class="col-12">
                                            <ValidationProvider name="概要" rules="required|min:3|max:20"
                                                v-slot="{ errors }">
                                                <textarea class="form-control" id="description"
                                                    v-model="task.description" placeholder="概要" rows="2" autofocus />
                                                <span class="text-danger">{{ errors[0] }}</span>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="row col-10 offset-1">
                                        <label for="done" class="col-12 col-form-label">進捗</label>
                                        <div class="col-12">
                                            <ValidationProvider rules="required" v-slot="{ errors }">
                                                <select name="done" id="done" class="col-12 form-control"
                                                    v-model="task.done">
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
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="row col-10 offset-1">
                                        <div class="col-4 col-md-4 col-xl-3"><label for="created_at"
                                                class="col-form-label">登録日</label>
                                        </div>
                                        <div class="col-8 col-md-8 col-xl-9 d-flex align-items-center pl-0">
                                            {{ getFormattedTime(task.created_at) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary" :disabled="invalid">
                                        更新
                                    </button>
                                </div>
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
import * as DateFnsLocale from "date-fns/locale";
import { ValidationObserver, ValidationProvider, extend, localize } from "vee-validate";
import ja from "vee-validate/dist/locale/ja.json";
import { max, min, required } from "vee-validate/dist/rules";

localize('ja', ja);
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
                return format(new Date(time), "M / dd (E)", { locale: DateFnsLocale.ja });
            }
        },
        getTask() {
            axios.get("/api/tasks/" + this.taskId).then((res) => {
                this.task = res.data;
            });
        },
        submit() {
            this.$toasted.clear();

            axios.put("/api/tasks/" + this.taskId, this.task).then((res) => {
                this.$router.push({ name: "tasks" });

                this.$toasted.show('タスクを更新しました', {
                    duration: 2000,
                    position: 'top-center',
                    type: 'success',
                    action: {
                        text: 'CLOSE',
                        onClick: function (e, toastObject) {
                            toastObject.goAway(0)
                        }
                    }
                })
            }).catch((error) => {
                this.$toasted.show('エラーが発生しました。しばらく経ってから再度お試しください', {
                    duration: -1,
                    position: 'bottom-center',
                    type: 'error',
                    action: {
                        text: 'CLOSE',
                        onClick: function (e, toastObject) {
                            toastObject.goAway(0)
                        }
                    }
                })
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
