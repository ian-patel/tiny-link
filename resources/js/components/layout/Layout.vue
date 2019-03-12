<template>
  <a-layout>
    <a-affix>
      <a-layout-header :style="{background: '#fff' }">
        <topbar/>
      </a-layout-header>
    </a-affix>
    <a-layout>
      <sidebar/>
      <a-layout-content :style="{ margin: '0px 16px 0' }">
        <div :style="{ padding: '20px', background: '#fff', minHeight: '360px' }">
          <router-view/>
        </div>
      </a-layout-content>
      <!-- <a-layout-footer style="textAlign: center">2ny link ©2019</a-layout-footer> -->
    </a-layout>
  </a-layout>
</template>
<script>