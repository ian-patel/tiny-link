<template>
  <span>
    <a-button
      type="primary"
      class="ant-btn-wow"
      icon="plus"
      @click="showModal"
      :size="buttonSize"
    >{{ title }}</a-button>
    <!-- <a-modal title="Create short link" v-model="visible" @ok="check" okText="Create" width="720px">
      <a-form :form="form">
        <a-form-item>
          <a-radio-group defaultValue="2l.nz">
            <template v-for="domain in domains">
              <a-radio-button :key="domain.name" :value="domain.name">{{ domain.name }}</a-radio-button>
            </template>
          </a-radio-group>
        </a-form-item>
        <a-form-item label="Type or paste a link">
          <a-textarea
            @paste="onPaste"
            v-decorator="[
              'longurl',
              {rules: [{ required: true, message: 'Type or paste a link (URL)' }]}
            ]"
            placeholder="Type or paste a valid link (URL)"
          />
        </a-form-item>
      </a-form>
    </a-modal>-->
    <a-drawer
      title="Basic Drawer"
      placement="right"
      :closable="false"
      @close="onClose"
      :visible="visible"
    >
      <p>Some contents...</p>
      <p>Some contents...</p>
      <p>Some contents...</p>
    </a-drawer>
  </span>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  props: {
    title: {
      type: String
    }
  },
  computed: {
    ...mapGetters(["domains"]),
    buttonCircle() {
      return this.title == null ? 'circle' : 'default';
    },
    buttonSize() {
      return this.title == null ? 'large' : 'default';
    },
  },
  data() {
    return {
      visible: false,
      form: this.$form.createForm(this)
    };
  },
  methods: {
    ...mapActions(["digLink"]),
    check() {
      this.form.validateFields(err => {
        if (!err) {
          console.info("success");
        }
      });
    },
    showModal() {
      this.visible = true;
      console.log(this.form.getFieldValue("longurl"));
    },
    onClose(e) {
      console.log(e);
      this.visible = false;
    },
    onPaste() {
      this.$nextTick(() => {
        console.log(this.form.getFieldValue("longurl"));
      });
    }
  }
};
</script>

<style lang="scss" scopped>
.ant-form-item-label label {
  font-size: 16px !important;

  &:after,
  &:before {
    display: none;
  }
}
</style>