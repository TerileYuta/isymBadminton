<template>
    <div v-if="document != ''" class="my-6">
        <HeadLine :text="title"></HeadLine>
        <div class="text-basic mt-3">
            <p v-for="(row, index) in document.split('\n')" :key="index">{{row}}</p>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props: ["title", "document"],

        components:{
            headline: httpVueLoader("./HeadLine.vue")
        }
    }
</script>