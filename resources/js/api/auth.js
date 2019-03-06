import axios from 'axios';

const BASE_URL = '/api/auth';

/**
 * Logout
 * @param {Obeject} data
 * @return {Object}
 */
export async function logout(data) {
  const response = await axios.post(
    `${BASE_URL}/logout`
  );
  return response.data;
}