<template>
  <div class="titlebar">
    <h1 class="titlebar__title">{{ title }}</h1>
    <a-divider orientation="right" class="titlebar__divider">
      <CreateLinkButton/>
    </a-divider>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss" scoped>
.titlebar {
  &__title,
  &__divider {
    margin: 0 !important;
  }
}
</style>
