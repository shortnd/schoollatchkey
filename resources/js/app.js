require('./bootstrap');
import SignaturePad from "signature_pad";

window.Vue = require('vue');

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

const am_checkboxes = $('input[name^="am_checkin"]');
const pm_checkboxes = $('input[name^="pm_checkout"]');
const body = $('body');

function sigModal(checkboxes) {
    checkboxes.each(function() {
        const modal = $(this).parent().parent().find('.sig-modal');
        const canvas = modal.find('canvas');
        if (canvas.length) {
            const sigPad = new SignaturePad(canvas, {penColor: "#333",backgroundColor: "#fff"});
        }
        const close = modal.find('.close');
        const submit = modal.find('button[type^="submit"]');

        const openModal = function() {
            modal.classList.add('active');
            body.classList.add('modal-open');
        };

        const closeModal = function(event) {
            if (event.key == "escape" || event.type == "click") {
                modal.classList.remove('active');
                body.classList.remove('modal-open');
                sigPad.clear();
                checkbox.checked = false;
            }
        };

        const submitSig = function(event) {
            const sigInput = modal.querySelector('input[name^="sig"]');
            if (!sigPad.isEmpty()) {
                sigInput.value = sigPad.toDataURL("image/jpeg");
                if (sigInput.value > 0) {
                    console.log(sigInput.value.length);
                    this.form.submit();
                }
            }
        };

        $(this).on('click', openModal);
        close.on('click', closeModal);
        submit.on('click', submitSig);
    });
}

sigModal(am_checkboxes);
sigModal(pm_checkboxes);
