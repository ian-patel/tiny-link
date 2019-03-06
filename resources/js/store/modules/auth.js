import * as api from 'App/api/auth';
import * as types from 'App/store/mutations/auth';

// state
export const state = {
  user: null,
  account: null,
}

// mutations
export const mutations = {

  // logout
  [types.LOGOUT](state) {
    state.user = null;
    state.account = null;
  },
}

// actions
export const actions = {

  /**
   * Logout
   * @param  {Function} options.commit
   * @return
   */
  async logout({
    commit
  }) {
    const response = await api.logout();
    commit(types.LOGOUT);
  },
}

// getters
export const getters = {
  isLoggedIn(state) {
    return state.user !== null;
  },
  user(state) {
    return state.user;
  },
  account(state) {
    return state.account;
  },
}
