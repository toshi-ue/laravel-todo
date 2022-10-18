<template>
  <div class="container-fluid sticky-top bg-light mb-3" ref="header">
    <div class="container">
      <nav class="navbar">
        <span class="navbar-brand mb-0 h1"
          ><RouterLink to="/tasks">TODOアプリ</RouterLink></span
        >
        <div>
          <RouterLink v-bind:to="{ name: 'task.list' }"
            ><button class="btn btn-success">{{ $t("task.button.list") }}</button>
          </RouterLink>
          <RouterLink :to="{ name: 'task.create' }">
            <button class="btn btn-success">{{ $t("task.button.add") }}</button>
          </RouterLink>
          <RouterLink to="/login">
            <button class="btn btn-success">{{ $t("login") }}</button>
          </RouterLink>
        </div>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    isNotMatchPath(stringOfPath) {
      return this.$router.history.current["path"] !== stringOfPath;
    },
    getHeaderHeight() {
      return this.$refs.header.offsetHeight;
    },
  },
  mounted() {
    this.$store.dispatch("rect/calcHeaderHeightActions", {
      headerHeight: this.$refs.header.offsetHeight,
      windowInnerHeight: window.innerHeight,
    });
  },
};
</script>
