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
    <div class="panel" v-show="tab === 1">
      <form class="form" @submit.prevent="login">
        <label for="login-mail">email</label>
        <input type="text" class="form__item" id="login-mail" v-model="loginForm.email" />
        <label for="password">password</label>
        <input type="password" name="form__item" id="login-password" v-model="loginForm.password" />
        <div class="form_button">
          <button type="submit" class="button button-inverse">login</button>
        </div>
      </form>
    </div>
    <div class="panel" v-show="tab === 2">
      <form class="form" @submit.prevent="register">
        <label for="username">name</label>
        <input type="text" class="form__item" id="username" v-model="registerForm.name" />
        <label for="email">email</label>
        <input type="text" class="form__item" id="email" v-model="registerForm.email" />
        <label for="password">password</label>
        <input type="password" name="form__item" id="password" v-model="registerForm.password" />
        <label for="password-confirmation">password</label>
        <input type="password" name="form__item" id="password-confirmation"
          v-model="registerForm.password_confirmation" />
        <div class="form_button">
          <button type="submit" class="button button-inverse">register</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tab: 1,
      loginForm: {
        email: '',
        password: '',
      },
      registerForm: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
    };
  },
  methods: {
    login() {
      console.log(this.loginForm)
    },
    register() {
      console.log(this.registerForm)
    }
  }
};
</script>
