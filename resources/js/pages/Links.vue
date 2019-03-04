<template>
  <div>
    <h1>Links</h1>
    <img :src="empty">
  </div>
</template>
<script>
import Empty from 'svg/empty.svg';

export default {
data() {
  return {
    empty: Empty
  }
},
}
</script>