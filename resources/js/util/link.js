const validation = /^(?:(?:(?:https?|ftp|www):)?\/\/)?(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i;

/**
 * Validate link
 *
 * @param {string} link
 * @return {boolean}
 */
function validate(link) {
  return validation.test(link);
}

/**
 * Check the link is valid or not
 *
 * @param {string} link
 * @return {boolean}
 */
export function isValidLink(link) {
  return validate(link);
}

/**
 * Check the link is valid or not
 *
 * @param {string} link
 * @return {string}
 */
export function favicon(link) {
  return `https://www.google.com/s2/favicons?domain=${link}`;
}
