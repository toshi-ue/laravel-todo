<template>
    <!-- <div class="container content" :style="'min-height: ' + $store.state.rect.contentMinHeight + 'px'"> -->
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <h2 class="card-header">TODO追加</h2>
                    <div class="card-body">
                        <ValidationObserver ref="observer" v-slot="{ invalid }">
                            <form v-on:submit.prevent="submit">
                                <div class="form-group row">
                                    <label for="description" class="col-sm-3 col-form-label">概要</label>
                                    <!--
                                        FIXME: field is invalid　としか表示されない
                                            [Vue.jsでVeeValidateを使ってバリデーション | ScrambleNote-WEBエンジニア(奈良)のメモ](https://scramblenote.com/article/vue-veevalidate)
                                    -->
                                    <ValidationProvider rules="required|min:2|max:25" v-slot="{ errors }">
                                        <textarea class="col-sm-9 form-control" id="description"
                                            v-model="task.description" placeholder="概要" rows="2" autofocus />
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </ValidationProvider>
                                </div>
                                <button type="submit" class="btn btn-success" :disabled="invalid">
                                    追加
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
    components: {
        ValidationObserver,
        ValidationProvider,
    },
    data: function () {
        return {
            task: {
                description: ''
            },
        }
    },
    methods: {
        submit() {
            axios.post(`/api/tasks`, this.task).then((res) => {
                this.$router.push({ name: "tasks" })
            })
        }
    }
}
</script>
