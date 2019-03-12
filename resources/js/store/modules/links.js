import * as api from 'App/api/links';
import * as types from 'App/store/mutations/links';

// state
export const state = {
  data: null,
};

// mutations
export const mutations = {
  // Save categories
  [types.SAVE_LINKS] (state, { data }) {
    state.data = data;
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
    const response = await api.list(data);
    console.log(response);
    if (!_.isEmpty(response.links)) {
      commit(types.SAVE_LINKS, { data: response.links });
    }
    return response.data;
  },

  /**
   * Dig link
   * @param  {Function} options.commit
   * @return {Object} user
   */
  async digLink({ commit }, data) {
    const response = await api.dig(data);
    return response.data;
  },
};

// getters
export const getters = {
  links(state) {
    return state.data;
  },
};
