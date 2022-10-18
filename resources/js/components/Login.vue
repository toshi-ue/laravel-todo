<template>
  <div class="container--small">
    <ul class="tab">
      <li class="tab__item" :class="{ 'tab__item--active': tab === 1 }" @click="tab = 1">
        {{ $t("login") }}
      </li>
      <li class="tab__item" :class="{ 'tab__item--active': tab === 2 }" @click="tab = 2">
        {{ $t("signup") }}
      </li>
    </ul>
    <div class="panel" v-show="tab === 1">Login Form</div>
    <div class="panel" v-show="tab === 2">Register Form</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tab: 1,
    };
  },
};
</script>
