<template>
  <div class="container-fluid sticky-top bg-light mb-3" ref="header">
    <div class="container">
      <nav class="navbar">
        <span class="navbar-brand mb-0 h1">TODOアプリ</span>
        <div>
          <router-link v-bind:to="{ name: 'task.list' }" v-if="isNotMatchPath('/tasks')"
            ><button class="btn btn-success">List</button>
          </router-link>
          <router-link
            :to="{ name: 'task.create' }"
            v-if="isNotMatchPath('/tasks/create')"
          >
            <button class="btn btn-success">ADD</button>
          </router-link>
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
