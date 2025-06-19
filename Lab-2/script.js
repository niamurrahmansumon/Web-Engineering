function isIE() {
  const ua = window.navigator.userAgent;
  return ua.indexOf('MSIE ') > -1 || ua.indexOf('Trident/') > -1;
}

function notExcludedPage() {
  return !window.location.href.includes("/unsupported-browser/") &&
         !document.title.toLowerCase().includes('page not found');
}

if (isIE() && notExcludedPage()) {
  window.location.href = `${location.protocol}//${location.host}/unsupported-browser/`;
}