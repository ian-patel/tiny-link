/* eslint-disable import/prefer-default-export */
import axios from 'axios';

const BASE_URL = '/api/auth';

/**
 * Logout
 * @return {Object}
 */
export async function logout() {
  const response = await axios.post(
    `${BASE_URL}/logout`,
  );
  return response.data;
}
