<style lang="less">

</style>

<template>
    <div>
        <Modal
                v-model="show"
                title="新增系统分支"
                @on-ok="ok('formData')"
                :loading="loading">
            <Form :model="formData" :label-width="100"  :rules="formInline" ref="formData">
                <FormItem label="分支：" prop="page">
                    <Input v-model="formData.page" type="text" placeholder="请输入分支名称" style="width: 80%"></Input>
                </FormItem>
                <FormItem label="路由：" prop="route">
                    <Input v-model="formData.route" type="text" placeholder="请输入路由" style="width: 80%"></Input>
                </FormItem>
            </Form>
        </Modal>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                formData :{
                    page: '',
                    route: ''
                },
                formInline:{
                    page:[
                        { required: true, message: '请输入分支名', trigger: 'blur' },
                    ],
                    route:[
                        { required: true, message: '请输入路由', trigger: 'blur'},
                        { pattern: /^[A-Za-z]+$/, message:'路由必须是纯英文', trigger: 'blur' },
                    ],
                },
                show : false,
                loading: true
            };
        },
        props: {
            newModel: false
        },
        methods: {
            ok (name) {
                // 请求接口
                this.$refs[name].validate((valid) => {
                    if(valid){
                        this.JAjax.postJson('framework/add/page', this.formData, res=>{
                            if ( res.code === 1){
                                this.$Message.success(res.message);
                                this.formData.page ='';
                                this.formData.r ='';
                                this.$emit('afresh_list', 'data')
                            }
                        })
                        setTimeout(() => {
                            this.show = false;
                        }, 500);
                    }else{
                        this.loading = false;
                        setTimeout(() => {
                            this.loading = true;
                        }, 100);
                        this.$Message.error('请检查您输入的信息');
                    }
                })
            },
            cancel () {
                // this.$Message.info('Clicked cancel');
            }
        },
        watch: {
            newModel () {
                this.show = true
            }
        }
    };
</script>
