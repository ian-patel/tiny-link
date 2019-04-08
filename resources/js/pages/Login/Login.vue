<template>
  <a-row type="flex" justify="space-around" class="login">
    <a-col :xs="22" :sm="14" :md="12" :lg="10" :xl="7" class="login__container">
      <a-card :bordered="false">
        <div scope="title" class="login__title">
          <!-- <a-icon type="dingding" class="login__logo"/> -->
          <img src="logo.svg">
          <!-- <img src="images/empty.svg" class="emptybox"> -->
        </div>
        <!-- <a-divider/> -->
        <h2>Login to 2ny link</h2>
        <p>We're a community of product people here to geek out and discover new, interesting products.</p>
        <a-divider/>
        <a-button icon="twitter" class="btn-twitter" @click="login('twitter')">Twitter</a-button>
        <a-button icon="facebook" @click="login('facebook')">Facebook</a-button>
        <a-button icon="google" @click="login('google')">Google</a-button>

        <a-card-meta>
          <template
            slot="description"
          >We'll never post to any of your accounts without your permission.</template>
        </a-card-meta>
      </a-card>
    </a-col>
  </a-row>
</template>
<script>
export default {
  methods: {
    login(social) {
      window.location.href = `/login/${social}`;
    }
  }
};
</script>

<style lang="scss" scoped>
.login {
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  background: linear-gradient(0deg, #0b4182 1%, #1e88e5 100%);

  &__container {
    margin-top: 150px;
    text-align: center;
  }

  &__title {
    font-size: 50px;
  }

  &__module {
  }
}
</style>

<style lang="css">
.ant-card-meta-detail {
  margin-top: 30px;
}
.ant-card-meta-description {
  font-size: 10px;
}
</style>
