/* eslint-disable no-undef */
/* eslint-disable no-shadow */
import * as api from 'app/api/links';
import * as types from 'app/store/mutations/links';

// state
export const state = {
  data: null,
  activeLink: null,
};

// mutations
export const mutations = {
  // Save links
  [types.SAVE_LINKS](state, {
    data,
  }) {
    state.data = data;
  },

  // Save a new link
  [types.SAVE_NEWLINK](state, {
    link,
  }) {
    state.data.unshift(link);
    state.activeLink = link;
  },
};

// actions
export const actions = {
  /**
   * Fetch Links
   * @param  {Function} options.commit
   * @return {Object} user
   */
  async fetchLinks({
    commit,
  }, data) {
    const {
      links,
    } = await api.list(data);

    if (!_.isEmpty(links)) {
      commit(types.SAVE_LINKS, {
        data: links,
      });
    }
    return links;
  },

  /**
   * Dig link
   * @param  {Function} options.commit
   * @return {Object} user
   */
  async createLink({
    commit,
  }, data) {
    const {
      link,
    } = await api.create(data);

    if (!_.isEmpty(link)) {
      commit(types.SAVE_NEWLINK, {
        link,
      });
    }

    return link;
  },
};

// getters
export const getters = {
  /**
   * Get links
   */
  links: state => state.data,

  /**
   * Get active link
   */
  activeLink: state => state.activeLink,

  /**
   * Get link by uuid
   */
  link: state => uuid => state.data[uuid],
};
