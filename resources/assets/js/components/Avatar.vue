<template>
    <div>
        <my-upload field="img"
                   @crop-success="cropSuccess"
                   @crop-upload-success="cropUploadSuccess"
                   @crop-upload-fail="cropUploadFail"
                   v-model="show"
                   :width="300"
                   :height="300"
                   url="/avatar"
                   :params="params"
                   :headers="headers"
                   img-format="png"></my-upload>
        <img style="width: 25px;" :src="imgDataUrl">
        <a class="btn" @click="toggleShow">更新头像</a>
    </div>
</template>

<script>
    import 'babel-polyfill';
    import myUpload from 'vue-image-crop-upload/upload-2.vue';
    export default{
        props : ['avatar'],
        data()
        {
            return {
                show: false,
                params: {
                    _token: document.head.querySelector('meta[name="csrf-token"]').content,
                    name: 'img'
                },
                headers: {
                    smail: '*_~'
                },
                imgDataUrl: this.avatar
            }
        },
        components: {
            'my-upload': myUpload
        },
        methods: {
            toggleShow() {
                this.show = !this.show;
            },
            /**
             * crop success
             * [param] imgDataUrl
             * [param] field
             */
            cropSuccess(imgDataUrl, field){
                this.imgDataUrl = imgDataUrl;
            },
            /**
             * upload success
             * [param] jsonData   服务器返回数据，已进行json转码
             * [param] field
             */
            cropUploadSuccess(response, field){
                this.imgDataUrl = response.url;
                this.toggleShow();
            },
            /**
             * upload fail
             * [param] status    server api return error status, like 500
             * [param] field
             */
            cropUploadFail(status, field){
//
            }
        }
    }
</script>