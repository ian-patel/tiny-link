import * as api from 'app/api/links';
import * as types from 'app/store/mutations/links';

// state
export const state = {
  data: null,
  dig: null,
};

// mutations
export const mutations = {
  // Save links
  [types.SAVE_LINKS](state, { data }) {
    state.data = data;
  },

  // Save link dig
  [types.SAVE_NEWLINK](state, { data }) {
    state.dig = data;
  },
};

// actions
export const actions = {
  /**
   * Fetch Links
   * @param  {Function} options.commit
   * @return {Object} user
   */
  async fetchLinks({ commit }, data) {
    const { links } = await api.list(data);

    if (!_.isEmpty(links)) {
      commit(types.SAVE_LINKS, { data: links });
    }
    return links;
  },

  /**
   * create link
   * @param  {Function} options.commit
   * @return {Object} link
   */
  async createLink({ commit }, param) {
    const { data } = await api.create(param);

    // if (!_.isEmpty(data)) {
    //   commit(types.SAVE_NEWLINK, { data });
    // }

    return data;
  },
};

// getters
export const getters = {
  links(state) {
    return state.data;
  },
  dig(state) {
    return state.dig;
  },
};
