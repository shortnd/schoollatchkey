<template>
<div class="sig-modal">
    <span class="close">X</span>
    <canvas height="250px" width="500px"></canvas>
    <input type="hidden" name="sig">
    <button class="btn btn-primary" type="submit">submit</button>
</div>
</template>

<script>
export default {
    name: 'signature-modal',
    data() {
        return {
            form: null,
        }
    },
    created() {
        this.form = document.querySelector('.pm-checkout-form')
        // console.log('mounted');
    }
}
</script>
