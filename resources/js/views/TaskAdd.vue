<template>
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <h2 class="card-header">TODO追加</h2>
                    <div class="card-body">
                        <ValidationObserver ref="observer" v-slot="{ invalid }">
                            <form v-on:submit.prevent="submit">
                                <div class="form-group row">
                                    <label for="description" class="col-sm-3 col-md-12 col-form-label">概要</label>
                                    <div class="col-sm-9 col-md-12">
                                        <ValidationProvider name="概要" rules="required|min:3|max:20" v-slot="{ errors }">
                                            <textarea class="form-control" id="description" v-model="task.description"
                                                placeholder="概要" rows="2" autofocus />
                                            <span class="text-danger">{{ errors[0] }}</span>
                                        </ValidationProvider>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-success" :disabled="invalid">
                                        追加
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
import { ValidationObserver, ValidationProvider, extend, localize } from "vee-validate";
import ja from "vee-validate/dist/locale/ja.json";
import { max, min, required } from "vee-validate/dist/rules";

localize('ja', ja)
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
            this.$toasted.clear();

            axios.post(`/api/tasks`, this.task).then((res) => {
                this.$router.push({ name: "tasks" });

                this.$toasted.show('タスクを追加しました', {
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
            })
        }
    }
}
</script>
