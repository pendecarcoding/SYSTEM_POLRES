/**
 * Add the CSRF Token to the Laravel object. The Laravel object is being
 * used by Axios and the reference can be seen in ./bootstrap.js
 *
 * Requires the token be set as a meta tag as described in the documentation:
 * https://laravel.com/docs/5.4/csrf#csrf-x-csrf-token
 */

window.Laravel = {
  csrfToken: document.head.querySelector("[name=csrf-token]").content,
};

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

/**
 * The Vue components for managing the OAuth setup
 */

Vue.component("passport-clients", require("./components/passport/Clients.vue"));

Vue.component(
  "passport-authorized-clients",
  require("./components/passport/AuthorizedClients.vue")
);

Vue.component(
  "passport-personal-access-tokens",
  require("./components/passport/PersonalAccessTokens.vue")
);

/**
 * Instantiate Vue for use
 */

const app = new Vue({
  el: "#app",
});
