/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
import SignaturePad from "signature_pad";

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// var sig = new SignaturePad(document.querySelector('canvas'));

const app = new Vue({
    el: '#app',
});

// const am_checkboxes = $('input[name^="am_checkin"]');
// const pm_checkboxes = $('input[name^="pm_checkout"]');
const pm_checkboxes = document.querySelectorAll('input[name^="pm_checkout"]');
const body = $('body');

function sigModal(checkboxes) {
    checkboxes.forEach(function (el) {
        const modal = el.parentNode.parentNode.querySelector('.sig-modal');
        const canvas = modal.querySelector('canvas');
        let sigPad = null;
        if (canvas) {
            sigPad = new SignaturePad(canvas, {
                penColor: "#333",
                backgroundColor: "#fff"
            });
        }
        const close = modal.querySelector('.close');
        const submit = modal.querySelector('button[type="submit"]');

        const openModal = function () {
            modal.classList.add('active')
            document.querySelector('body').classList.add('modal-open');
        }

        const closeModal = function (event) {
            if (event.key == "escape" || event.type == "click") {
                modal.classList.remove('active');
                document.querySelector('body').classList.remove('modal-open');
                // sigModal.close();
                el.checked = false;
            }
        }

        const submitSig = function(event) {
            const sigInput = modal.querySelector('input[name^="sig"]');
            if (!sigPad.isEmpty()) {
                sigInput.value = sigPad.toDataURL("image/jpeg");
                if (sigInput.value > 0) {
                    // console.log(sigInput.value.length);
                    this.form.submit();
                }
            }
        }
        // console.log(el);
        el.addEventListener('click', openModal);
        close.addEventListener('click', closeModal);
        submit.addEventListener('click', submitSig);
    });

    //     const closeModal = function(event) {
    //         if (event.key == "escape" || event.type == "click") {
    //             modal.classList.remove('active');
    //             body.classList.remove('modal-open');
    //             sigPad.clear();
    //             checkbox.checked = false;
    //         }
    //     };

    //     $(this).on('click', openModal);
    //     close.on('click', closeModal);
    //     submit.on('click', submitSig);
    // });
}

// sigModal(am_checkboxes);
sigModal(pm_checkboxes);
