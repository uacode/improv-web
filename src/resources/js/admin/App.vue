<template>
  <div>
    <vue-progress-bar />
    <notifications
      group="app"
      position="top center"
      width="50%"
      :duration="5000" />

    <b-navbar
      id="top-nav"
      toggleable="md"
      type="dark"
      variant="default">
      <b-navbar-toggle target="nav_collapse" />

      <b-collapse
        id="nav_collapse"
        is-nav>
        <b-navbar-nav>
          <b-nav-item
            exact
            to="/">
            {{ $t("nav.home") }}
          </b-nav-item>
          <b-nav-item :to="{ name: 'productions' }">
            {{ $t("nav.productions") }}
          </b-nav-item>
          <b-nav-item :to="{ name: 'organizations' }">
            {{ $t("nav.organizations") }}
          </b-nav-item>
        </b-navbar-nav>
        <nav-language-switcher />
      </b-collapse>
    </b-navbar>

    <div class="row">
      <div class="col-12 admin-content">
        <transition name="fade">
          <router-view />
        </transition>
      </div>
    </div>

    <BottomNav />
  </div>
</template>

<script>
import BottomNav from '../components/BottomNav';
import { progress } from '../mixins/progress';
import NavLanguageSwitcher from '../components/NavLanguageSwitcher';

export default {
    components: {
        BottomNav,
        NavLanguageSwitcher
    },
    mixins: [progress]
};
</script>
