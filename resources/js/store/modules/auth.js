/* eslint-disable no-shadow */
import * as api from 'app/api/auth';
import * as types from 'app/store/mutations/auth';

// state
export const state = {
  user: null,
  account: null,
};

// mutations
export const mutations = {

  // logout
  [types.LOGOUT](state) {
    state.user = null;
    state.account = null;
  },
};

// actions
export const actions = {

  /**
   * Logout
   * @param  {Function} options.commit
   * @return
   */
  async logout({
    commit,
  }) {
    const response = await api.logout();
    commit(types.LOGOUT);
  },
};

// getters
export const getters = {
  /**
   * Determine the use is loggedin
   */
  isLoggedIn: state => state.user !== null,
  /**
   * Get the account
   */
  account: state => state.account,
  /**
   * Get the use
   */
  user: state => state.user,
};
