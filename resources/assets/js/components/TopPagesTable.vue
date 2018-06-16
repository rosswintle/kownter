<template>
    <div class="table-container">
        <div class="table-buttons">
            <button :class="{'btn': true, 'btn-primary': true, 'btn-outline-primary': timePeriod != 'all' }" v-on:click="timePeriod='all'">All time</button>
            <button :class="{'btn': true, 'btn-primary': true, 'btn-outline-primary': timePeriod != 'week' }" v-on:click="timePeriod='week'" >7 days</button>
            <button :class="{'btn': true, 'btn-primary': true, 'btn-outline-primary': timePeriod != 'day' }" v-on:click="timePeriod='day'" >24 hours</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Page</th>
                    <th scope="col">Views</th>
                </tr>
            </thead>

            <tbody>
                <pages-row v-if="timePeriod == 'all'" v-for="page in topPages"
                    v-bind:key="page.id"
                    v-bind:url="page.url"
                    v-bind:count="page.views_count">
                </pages-row>
                <pages-row v-if="timePeriod == 'week'" v-for="page in topPagesWeek"
                    v-bind:key="page.id"
                    v-bind:url="page.url"
                    v-bind:count="page.views_count">
                </pages-row>
                <pages-row v-if="timePeriod == 'day'" v-for="page in topPagesDay"
                           v-bind:key="page.id"
                           v-bind:url="page.url"
                           v-bind:count="page.views_count">
                </pages-row>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: [
            'site'
        ],
        data() {
            return {
                topPages: [],
                topPagesWeek: [],
                topPagesDay: [],
                timePeriod: 'all'
            }
        },
        mounted() {

            fetch('/api/v1/site/' + this.site + '/top-pages', { credentials: "same-origin" })
                .then( response => {
                    response.json()
                        .then( pages => {
                            this.topPages = pages;
                        });
                });
            fetch('/api/v1/site/' + this.site + '/top-pages/week', { credentials: "same-origin" })
                .then( response => {
                    response.json()
                        .then( pages => {
                            this.topPagesWeek = pages;
                        });
                });
            fetch('/api/v1/site/' + this.site + '/top-pages/day', { credentials: "same-origin" })
                .then( response => {
                    response.json()
                        .then( pages => {
                            this.topPagesDay = pages;
                        });
                });
        }
    }
</script>
