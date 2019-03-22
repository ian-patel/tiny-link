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
      placement="top"
      :closable="false"
      class="drawer"
      @close="visible = false"
      :visible="visible"
      height="auto"
    >
      <a-form class="drawer__form" :form="form" v-if="visible">
        <!-- Domains -->
        <!-- <a-form-item>
          <a-select v-decorator="['domainname', {initialValue: '2l.nz'}]" style="width: 100%">
            <template v-for="domain in domains">
              <a-select-option :key="domain.name" :value="domain.name">{{ domain.name }}</a-select-option>
            </template>
          </a-select>
        </a-form-item>-->
        <!-- Textarea -->
        <h2>Create tiny link</h2>
        <a-divider/>

        <a-form-item label="Paste a valid long link" :colon="colon">
          <a-input
            v-focus
            size="large"
            @change="onChange"
            v-decorator="[
              'longurl',
              {rules: [{ required: false, message: 'Type or paste a link (URL)' }]}
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

        <!-- <div class="drawer__footer">
          <a-button html-type="submit" type="primary" size="large" :style="{width: '200px'}">Create</a-button>
        </div>-->
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
      colon: false,
      link: null,
      domain: '2l.nz',
    };
  },
  methods: {
    ...mapActions(["createLink"]),
    openDrawer() {
      this.visible = true;
      // this.$nextTick(() => {
      //   this.form.setFieldsValue({
      //     longurl: this.link
      //   });
      // });
    },
    onChange(e) {
      // only paste event will create link
      if (e.inputType !== "insertFromPaste") {
        return;
      }

      this.$nextTick(async () => {
        const link = this.form.getFieldValue("longurl");

        if (!isValidLink(link)) {
          this.form.setFields({
            ["longurl"]: {
              value: link,
              errors: [{ message: "Paste a valid link" }]
            }
          });
          return;
        }

        this.createLink({
          longLink: link,
          domain: this.domain,
          source: "website"
        });
      });
    } // onchange
  }
};
</script>

<style lang="scss" scopped>
.drawer {
  &__form {
    max-width: 500px;
    margin: auto !important;
  }

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