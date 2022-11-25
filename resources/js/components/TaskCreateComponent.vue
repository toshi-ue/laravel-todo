<template>
  <div
    class="container content"
    :style="'min-height: ' + $store.state.rect.contentMinHeight + 'px'"
  >
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <div class="card">
          <h2 class="card-header">{{ $t("task.title.add") }}</h2>
          <div class="card-body">
            <ValidationObserver ref="observer" v-slot="{ invalid }">
              <form v-on:submit.prevent="submit">
                <div class="form-group row">
                  <label for="description" class="col-sm-3 col-form-label">{{
                    $t("task.description")
                  }}</label>
                  <ValidationProvider rules="required|min:2|max:25" v-slot="{ errors }">
                    <textarea
                      class="col-sm-9 form-control"
                      id="description"
                      v-model="task.description"
                      :placeholder="$t('task.description')"
                      rows="2"
                      minlength="2"
                      maxlength="25"
                      autofocus
                    />
                    <span class="text-danger">{{ errors[0] }}</span>
                  </ValidationProvider>
                </div>
                <button type="submit" class="btn btn-success" :disabled="invalid">
                  {{ $t("task.button.add") }}
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
<style>
:disabled {
  color: #fff;
  cursor: not-allowed;
  background-color: #434342;
}
.btn:hover:not([disabled]) {
}
</style>
