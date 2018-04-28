
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Navbar from './components/Navbar';
import LeftSide from './components/LeftSide';
import Sources from './components/Pages/Sources';

const app = new Vue({
    el: '#app',
    components: {
        Navbar,
        LeftSide,
        Sources,
    },
    data() {
        return {

        };
    },
    methods: {
        leftSideToggle() {
            const $leftSideWrap = $('#left-side-wrap');
            const $contentWrap = $('#content-wrap');
            const $sourcesListenersLists = $('#sources-listeners-lists');

            if ($leftSideWrap.hasClass('col-2')) {
                $leftSideWrap.removeClass('col-2');
                $leftSideWrap.addClass('col-12');
                leftSide.$data.showToggleBtn = true;
            } else {
                $leftSideWrap.removeClass('col-12');
                $leftSideWrap.addClass('col-2');
                leftSide.$data.showToggleBtn = false;
            }

            if ($sourcesListenersLists.hasClass('d-none')) {
                $sourcesListenersLists.removeClass('d-none');
                $sourcesListenersLists.removeClass('d-md-block');
                $sourcesListenersLists.addClass('d-block');
            } else {
                $sourcesListenersLists.removeClass('d-block');
                $sourcesListenersLists.addClass('d-none');
                $sourcesListenersLists.addClass('d-md-block');
            }
        },
    },
    created() {
        window.app = this;
    },
});
