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
        props:['user'],
        mounted() {
            this.$http.post('/api/user/follower',{'user':this.user}).then(response => {
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
                return this.followed?'已关注':'关注他';
            }
        },
        methods:{
            follow(){
               this.$http.post('/api/user/follow',{'user':this.user}).then(response => {
                console.log(response.data)
                this.followed = response.data.followed;
                })
            },
        }
    }
</script>
