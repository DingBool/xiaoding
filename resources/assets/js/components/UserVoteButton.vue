<template>
    <button class="btn btn-default" v-text="text" @click="voteds" :class="{'btn-success':voted}"></button>
</template>

<script>
    export default
    {
        props:['answer','count'],
        mounted()
        {
            axios.post('/api/answer/'+this.answer+'/votes/user').then((response)=>
            {
                this.voted = response.data.voted;
            })
        },
        data()
        {
            return{
                voted:false
            }
        },
        computed :
            {
                text()
                {
                    return this.count
                }
            },
        methods:
            {
                voteds()
                {
                    axios.post('/api/answer/vote',{'answer':this.answer}).then((response)=>
                    {
                        this.voted = response.data.voted;
                        response.data.voted ? this.count++ : this.count--;
                    })
                }
            }
    }
</script>