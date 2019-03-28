<template>
  <a-modal
    placement="top"
    class="modal"
    width="800px"
    height="auto"
    :closable="true"
    :visible="visible"
    :footer="footer"
    :maskStyle="maskStyle"
    @cancel="closeModal"
  >
    <a-form class="modal__form" :form="form" v-if="visible">
      <h2 class="modal__title">Create tiny link</h2>
      <!-- Domains -->
      <a-form-item>
        <a-select v-decorator="['domainName', {initialValue: '2l.nz'}]" style="width: 150px">
          <template v-for="domain in domains">
            <a-select-option :key="domain.name" :value="domain.name">{{ domain.name }}</a-select-option>
          </template>
        </a-select>
      </a-form-item>

      <a-form-item label="Destination URL" :colon="colon">
        <a-input
          v-focus
          size="large"
          @change="onChange"
          v-decorator="[
              'longLink',
              {rules: [{ required: false, message: 'Paste a link' }]}
            ]"
          placeholder="Paste a valid link (URL)"
        />
      </a-form-item>
    </a-form>
  </a-modal>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import { isValidLink } from 'app/util';

const focus = {
  inserted(el) {
    el.focus();
  }
};

export default {
  directives: { focus },
  computed: {
    ...mapGetters(['domains', 'activeLink'])
  },
  data() {
    return {
      visible: true,
      form: this.$form.createForm(this),
      colon: false,
      domain: '2l.nz',
      footer: null,
      maskStyle: {
        backgroundColor: 'rgba(0, 0, 0, .35)'
      }
    };
  },
  watch: {
    activeLink(val) {
      if (val) {
        this.$router.push({ name: 'editLink', params: { uuid: val.uuid } });
      }
    }
  },
  methods: {
    ...mapActions(['createLink']),

    /**
     * Open modal
     */
    openModal() {
      this.visible = true;
    },

    /**
     * Close modal
     */
    closeModal() {
      this.visible = false;
      this.goBack();
    },

    /**
     * Create new link input change
     */
    onChange(e) {
      if (e.inputType === 'insertFromPaste') {
        this.onPaste(e);
        return;
      }
    },

    /**
     * Create new link on paste
     */
    onPaste(e) {
      this.$nextTick(() => {
        const longLink = this.form.getFieldValue('longLink');

        if (!isValidLink(longLink)) {
          this.form.setFields({
            ['longLink']: {
              value: longLink,
              errors: [{ message: 'Paste a valid link' }]
            }
          });
          return;
        }

        // Create tiny link
        this.createLink({
          longLink: longLink,
          domain: this.form.getFieldValue('domainName'),
          source: 'website'
        });
      });
    },

    /**
     * Go back
     */
    goBack() {
      window.history.length > 1
        ? this.$router.go(-1)
        : this.$router.push({ name: 'links' });
    }
  }
};
</script>

<style lang="scss" scopped>
.modal {
  .ant-modal-body {
    padding: 50px;
  }
  .ant-form-item-label {
    font-weight: 600;
    label {
      color: rgba(0, 0, 0, 0.65) !important;
    }
  }

  &__form {
    max-width: 700px;
    margin: auto !important;
  }

  &__title {
    margin-bottom: 35px;
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