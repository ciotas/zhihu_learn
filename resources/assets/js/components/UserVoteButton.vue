<template>
    <button class="btn btn-default"
            v-text="text"
            :class = "{'btn-primary':voted}"
            @click="vote"
    >

    </button>
</template>

<script>
    export default {
        props:['answer','count'],
        mounted() {
            this.$http.post('/api/answer/votes/user',{'answer':this.answer}).then(response => {
                console.log(response.data)
                this.voted = response.data.voted;
            })
        },
        data() {//必须为一个函数
           return {
                text: this.count,
                voted:false
           }
        },
        computed: {

        },
        methods:{
            vote(){
               this.$http.post('/api/answer/vote',{'answer':this.answer}).then(response => {
                console.log(response.data)
                this.voted = response.data.voted;
                 response.data.voted ? this.text ++ : this.text --;
                })
            },
        }
    }
</script>
