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
  [types.SAVE_LINKS] (state, { data }) {
    state.data = data;
  },

  // Save link dig
  [types.SAVE_LINKDIG] (state, { data }) {
    console.log(data);

    state.dig = data;
  },
};

// actions
export const actions = {
  /**
   * Get Links
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
   * Dig link
   * @param  {Function} options.commit
   * @return {Object} user
   */
  async digLink({ commit }, param) {
    const { data } = await api.dig(param);

    if (!_.isEmpty(data)) {
      commit(types.SAVE_LINKDIG, { data: data });
    }

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
  }
};
