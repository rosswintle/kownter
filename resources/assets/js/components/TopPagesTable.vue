<template>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Page</th>
                <th scope="col">Views</th>
            </tr>
        </thead>

        <tbody>
            <pages-row v-for="page in topPages"
                v-bind:key="page.id"
                v-bind:url="page.url"
                v-bind:count="page.views_count">
            </pages-row>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: [
            'site'
        ],
        data() {
            return {
                topPages: []
            }
        },
        mounted() {
            fetch('/api/v1/site/' + this.site + '/top-pages/week', { credentials: "same-origin" })
            .then( response => {
                response.json()
                    .then( pages => {
                        this.topPages = pages;
                    });
            });
            console.log('Component mounted.')
        }
    }
</script>
