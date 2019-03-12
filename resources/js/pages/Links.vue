<template>
  <div>
    <TitleBar title="Links"/>

    <!-- <a-divider/> -->
    <a-row v-if="empty">
      <a-col :span="24">
        <a-row>
          <a-col :span="24" class="toolbar">
            <span class="toolbar_counter">4 Links</span>
            <a-select defaultValue="latest" style="width: 150px">
              <a-select-option value="latest">Lastest</a-select-option>
              <a-select-option value="acs">Slashtag A - Z</a-select-option>
              <a-select-option value="desc">Slashtag Z - A</a-select-option>
              <a-select-option value="liked">Loved</a-select-option>
            </a-select>
          </a-col>
        </a-row>
        <a-list
          class="demo-loadmore-list"
          size="large"
          :loading="loading"
          itemLayout="vertical"
          :dataSource="links"
        >
          <div
            v-if="showLoadingMore"
            slot="loadMore"
            :style="{ textAlign: 'center', marginTop: '12px', height: '32px', lineHeight: '32px' }"
          >
            <a-spin v-if="loadingMore"/>
            <a-button v-else @click="fetchData">loading more</a-button>
          </div>

          <a-list-item
            slot="renderItem"
            slot-scope="item, index"
            @mouseover="mouseovering = index"
            @mouseout="mouseovering = -1"
          >
            <a-list-item-meta>
              <a slot="title" href="https://vue.ant.design/">{{item.short_link.link}}</a>
              <a-avatar size="small" slot="avatar" :src="faviconLink(item.hostname)"/>

              <div slot="description">
                {{ item.title }}
                <div class="tags-list" v-show="false">
                  <a-tag color="blue">blue</a-tag>
                  <a-tag color="blue">blue</a-tag>
                  <a-tag color="blue">blue</a-tag>
                  <a-tag color="blue">blue</a-tag>
                  <a-tag color="blue">blue</a-tag>
                </div>
              </div>
            </a-list-item-meta>

            <div slot="extra" column="12">
              <p class="title">1 clicks</p>
              <div class="icons-list" v-show="mouseovering == index">
                <a-tooltip>
                  <template slot="title">Love</template>
                  <a href="#" class="icons-list__icon">
                    <a-icon type="heart"/>
                  </a>
                </a-tooltip>
                <a-tooltip>
                  <template slot="title">Visit URL</template>
                  <a href="#" class="icons-list__icon">
                    <a-icon type="select"/>
                  </a>
                </a-tooltip>
                <a-tooltip>
                  <template slot="title">Copy</template>
                  <a href="#" class="icons-list__icon">
                    <a-icon type="copy"/>
                  </a>
                </a-tooltip>
                <a-tooltip>
                  <template slot="title">Share</template>
                  <a href="#" class="icons-list__icon">
                    <a-icon type="share-alt"/>
                  </a>
                </a-tooltip>
                <a-tooltip>
                  <template slot="title">Edit</template>
                  <a href="#" class="icons-list__icon">
                    <a-icon type="edit"/>
                  </a>
                </a-tooltip>
                <a-tooltip>
                  <template slot="title">Delete</template>
                  <a href="#" class="icons-list__icon">
                    <a-icon type="delete"/>
                  </a>
                </a-tooltip>
              </div>
            </div>
          </a-list-item>
        </a-list>
      </a-col>
    </a-row>
    <a-row v-else type="flex" justify="space-around" align="middle">
      <a-col :sm="18" :md="12" :lg="10" :xl="6" :style="{textAlign: 'Center'}">
        <img src="images/empty.svg" class="emptybox">
        <AddLinkButton title="Create first link"/>
      </a-col>
    </a-row>
  </div>
</template>

<script>
// import EmptyBox from "svg/authentication.svg";
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      loading: false,
      loadingMore: false,
      showLoadingMore: false,
      mouseovering: -1,
      limit: 5,
      page: 1,
      empty: null
    };
  },
  watch: {
    fetchQuery() {
      this.fetchData();
    }
  },
  computed: {
    ...mapGetters(["links"]),
    fetchQuery() {
      return {
        limit: this.limit,
        page: this.page
      };
    }
  },
  mounted() {
    if (!this.links) {
      this.fetchLinks(this.fetchQuery);
    }
  },
  methods: {
    ...mapActions(["fetchLinks"]),
    fetchData() {
      this.fetchLinks(this.fetchQuery);
    },
    faviconLink(url) {
      return `https://www.google.com/s2/favicons?domain=${url}`;
    }
  }
};
</script>

<style scoped lang="scss">
.title {
  text-align: right;
  margin-right: 16px;
  font-size: 16px;
}
.icons-list {
  &__icon {
    margin-right: 12px;
    font-size: 20px;
    color: #919398;
  }
}
.tags-list {
  margin: 10px;
}
.ant-list-lg .ant-list-item {
  padding: 24px 10px;

  &:hover {
    background-color: #f9f9fa;
  }
}
.emptybox {
  margin: 50px 0px;
  width: 100%;
}
</style>