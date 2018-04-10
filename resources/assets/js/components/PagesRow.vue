<template>
    <tr>
        <td>
            {{ path }}<br>
            <small class="text-muted">{{ domain }}</small>
        </td>
        <td>
            {{ count }}
        </td>
    </tr>

</template>

<script>
    export default {
        props: [
            'url',
            'count'
        ],
        data() {
            return {

            }
        },
        mounted() {
        },
        computed: {
            location: function () {
                // This uses creation of an A element to break the URL into parts
                var l = document.createElement("a");
                l.href = this.url;
                return l;
            },
            domain: function () {
                return this.location.hostname;
            },
            path: function () {
                return this.location.pathname;
            }
        }
    }
</script>
