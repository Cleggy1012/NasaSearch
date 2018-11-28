<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h4 class="center">NASA Search</h4>
                <form id="searchNasa" @submit.prevent="searchNasa()">
                    <div class="row" v-bind:class="errors.search.class">
                        <label for="search" class="col-2 col-form-label">Search Phrase</label>
                        <input v-bind:title="errors.search.title"  v-model="search" class="col-6" type="text" ref="search" id="search" value="apollo"/>
                        <div class="col-1"></div>
                        <button class="col-3" type="submit">Search</button>
                    </div>
                    <div class="row" v-bind:class="errors.media_type.class">
                        <div class="col-6">
                            <label><input v-bind:title="errors.media_type.title" v-model="images" type="checkbox" value="images"/>Images</label>
                        </div>
                        <div class="col-6">
                            <label><input v-bind:title="errors.media_type.title" v-model="audio" type="checkbox" value="audio"/>Audio</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="results.length === 0 && searched" class="center alert">No Items to display</div>
        <div v-if="results.loading && searched" class="center alert">Loading Results Please Wait.</div>
        <div v-for="result in results" class="searchContainer">
            <div v-if="result.type === 'image'">
                <a :href="'/asset/' + result.nasa_id">
                    <img class="listImg" :src="result.link">
                </a>
            </div>
            <div class="audio" v-else-if="result.type === 'audio'">
                <audio controls>
                    <source :src="result.link"/>
                    Your browser does not support the audio element.
                </audio>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                results: [],
                errors: {
                    'media_type': {
                        'class': null,
                        'title': null
                    },
                    'search': {
                        'class': null,
                        'title': null
                    }
                },
                search: null,
                images: null,
                audio: null,
                searched: null,
            }
        },
        methods: {
            searchNasa: function () {
                this.results = {'loading': true};
                this.searched = true;
                var errors = (!this.images && !this.audio) || !this.search;
                this.errors['media_type']['class'] = !this.images && !this.audio ? 'hasError' : null;
                this.errors['media_type']['title'] = !this.images && !this.audio ? 'Please select Images or Audio to search' : null;
                this.errors['search']['class'] = !this.search ? 'hasError' : null;
                this.errors['search']['title'] = !this.search ? 'Please input a search phrase' : null;

                //Media Type
                var media_type = '&media_type=' + (this.images ? 'image,' : '') + (this.audio ? 'audio' : '');
                if(!errors) {
                    fetch('/api/search/get?search=' + this.search  + media_type)
                        .then(response => response.json())
                        .then(json => { this.results = json});
                }
                this.results['loading'] = false;
            },
        }


    }
</script>