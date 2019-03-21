<template>
  <span>
    <a-tooltip>
      <template slot="title">Create</template>
      <a-button
        type="primary"
        class="ant-btn-wow"
        icon="plus"
        @click="openDrawer"
        :size="buttonSize"
      >{{ title }}</a-button>
    </a-tooltip>

    <a-drawer
      title="Create tiny link"
      placement="right"
      :closable="false"
      class="drawer"
      @close="visible = false"
      :visible="visible"
    >
      <a-form :form="form" v-if="visible" @submit="handleSubmit">
        <!-- Domains -->
        <a-form-item>
          <a-select v-decorator="['domainname', {initialValue: '2l.nz'}]" style="width: 100%">
            <template v-for="domain in domains">
              <a-select-option :key="domain.name" :value="domain.name">{{ domain.name }}</a-select-option>
            </template>
          </a-select>
        </a-form-item>
        <!-- <a-divider/> -->
        <!-- Textarea -->
        <a-form-item>
          <a-textarea
            :rows="4"
            v-focus
            @change="onChange"
            v-decorator="[
              'longurl',
              {rules: [{ required: true, message: 'Type or paste a link (URL)' }]}
            ]"
            placeholder="Type or paste a valid link (URL)"
          />
        </a-form-item>

        <template v-if="dig">
          <h4 class="drawer__linktitle" v-if="dig.title">
            <img :src="favicon">
            {{ dig.title }}
          </h4>
        </template>

        <div class="drawer__footer">
          <a-button html-type="submit" type="primary" size="large" :style="{width: '200px'}">Create</a-button>
        </div>
      </a-form>
    </a-drawer>
  </span>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { isValidLink, favicon } from "app/util";
import * as api from "app/api/links";

const focus = {
  inserted(el) {
    el.focus();
  }
};

export default {
  directives: { focus },
  props: {
    title: {
      type: String
    },
    buttonSize: {
      type: String,
      default: "large"
    }
  },
  computed: {
    ...mapGetters(["domains"]),
    favicon() {
      if (this.dig) {
        return favicon(this.dig.host);
      }
    }
  },
  data() {
    return {
      visible: false,
      form: this.$form.createForm(this),
      dig: null,
      link: null
    };
  },
  methods: {
    ...mapActions(["digLink"]),
    check() {
      this.form.validateFields(err => {
        if (!err) {
          // console.info('success');
        }
      });
    },
    openDrawer() {
      this.visible = true;
      this.$nextTick(() => {
        this.form.setFieldsValue({
          longurl: this.link
        });
      });
    },
    onChange() {
      this.$nextTick(async () => {
        const link = this.form.getFieldValue("longurl");
        this.link = link;

        // Do not dig, if alredy
        if (this.dig && this.dig.link === link) {
          return;
        }

        if (isValidLink(link)) {
          const { data } = await api.dig({ link: link });
          this.dig = data;
        }
      });
    },
    handleSubmit(e) {
      e.preventDefault();

      const link = this.form.getFieldValue("longurl");
      if (!isValidLink(link)) {
          this.form.setFields({
            ['longurl']: {
              value: link,
              errors: [{
                "message": "Type or paste a link (URL)",
              }]
            }
          })
        return;
      }

      this.form.validateFields(err => {
        if (!err) {
          // console.log(this.form.getFieldsValue());
        }
      });
    }
  }
};
</script>

<style lang="scss" scopped>
.drawer {
  &__linktitle {
    height: 40px;
    overflow: hidden;
  }

  &__footer {
    position: absolute;
    bottom: 0;
    width: 100%;
    border-top: 1px solid #e8e8e8;
    padding: 10px 16px;
    text-align: center;
    left: 0;
    background: #fff;
    border-radius: 0 0 4px 4px;
  }
}

</style>