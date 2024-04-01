<template>
    <div v-if="video != ''" class="my-6">
        <HeadLine :text="title"></HeadLine>
        <div v-for="(id, index) in video.split('\n').slice(0, video.split('\n').length - 1)" :key="index" class="m-2">
            <iframe width="100%" style="aspect-ratio: 16 / 9;" :src="`https://www.youtube.com/embed/${id}`" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</template>


<script>
    module.exports = {
        props: ["title", "video"],

        components:{
            headline: httpVueLoader("./HeadLine.vue")
        }
    }
</script>