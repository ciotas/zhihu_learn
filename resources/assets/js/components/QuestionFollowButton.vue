<template>
    <button class="btn btn-default"
            v-text="text"
            :class = "{'btn-success':followed}"
            @click="follow"
    >

    </button>
</template>

<script>
    export default {
        props:['question'],
        mounted() {
            this.$http.post('/api/question/follower',{'question':this.question}).then(response => {
                console.log(response.data)
                this.followed = response.data.followed;
            })
        },
        data(){
            return {
                followed:false
            }
        },
        computed: {
            text(){
                return this.followed?'已关注':'关注该问题';
            }
        },
        methods:{
            follow(){
               this.$http.post('/api/question/follow',{'question':this.question}).then(response => {
                console.log(response.data)
                this.followed = response.data.followed;
                })
            },
        }
    }
</script>
