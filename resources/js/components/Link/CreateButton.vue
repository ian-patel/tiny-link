<template>
  <span>
    <router-link :to="{ name: 'createLink' }">
      <a-tooltip>
        <template slot="title">Create</template>
        <a-button type="primary" class="ant-btn-wow" icon="plus" :size="buttonSize">{{ title }}</a-button>
      </a-tooltip>
    </router-link>
  </span>
</template>

<script>
export default {
  props: {
    title: {
      type: String
    },
    buttonSize: {
      type: String,
      default: 'large'
    }
  }
};
</script>