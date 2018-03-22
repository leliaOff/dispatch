<template>
    <div class="easy-checkbox" v-bind:class="{ checked: isChecked }" @click="click">
        <div class="easy-checkbox-icon">
            <span class="glyphicon glyphicon-ok"></span>
            <input type="checkbox" v-model="isChecked" />
        </div><!--
        --><div class="easy-checkbox-label">
            {{ label }}
        </div>
    </div>
</template>

<script>
    export default {

        props: {
            checked:    Boolean,
            index:      [String, Number],
            label:      String
        },

         data() {
            return {
                localChecked: this.checked
            }
        },

        computed: {
            isChecked() {
                return this.localChecked;
            },
        },

        methods: {
            click() {
                this.localChecked = !this.localChecked;
                this.$emit('change', this.index, this.localChecked);
            }
        }

    }
</script>