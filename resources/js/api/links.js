import axios from 'axios';

const BASE_URL = '/api/links';

/**
 * Fetch the links
 * @param {Number} page
 * @return {Objects}
 */
export async function list(params) {
  const response = await axios.get(
    `${BASE_URL}`, {
      params: {
        ...params,
      },
    },
  );
  return response.data;
}

/**
 * create a tiny link
 * @param {Number} page
 * @return {Objects}
 */
export async function create(params) {
  const response = await axios.post(
    `${BASE_URL}/create`, {
      ...params,
    },
  );
  return response.data;
}

/**
 * Dig the link
 * @param {Number} page
 * @return {Objects}
 */
export async function dig(params) {
  const response = await axios.get(
    `${BASE_URL}/dig`, {
      params: {
        ...params,
      },
    },
  );
  return response.data;
}
